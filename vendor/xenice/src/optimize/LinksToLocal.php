<?php
/**
 * @name        xenice links to local
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2021-01-31
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\optimize;

class LinksToLocal
{
    public function __construct()
    {
        add_action('save_post', [$this, 'savePost'], 120, 2);
    }
    
   public function savePost($post_id, $post)
   {
    	global $wpdb;
    	if($post->post_status == 'publish') {
    		$p   = '/<img.*[\s]src=[\"|\'](.*)[\"|\'].*>/iU';
    		$num = preg_match_all($p, $post->post_content, $matches);
    		if ($num) {
    			$wp_upload_dir = wp_upload_dir();
    			set_time_limit(0);
    			$ch = curl_init();
    			curl_setopt($ch, CURLOPT_HEADER, false);
    			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    			curl_setopt($ch, CURLOPT_MAXREDIRS,20);
    			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
     
    			$ecp_options = $_SERVER['HTTP_HOST'];
    			foreach ($matches[1] as $src) {
    				if (isset($src) && strpos($src, $ecp_options) === false) {
    					$file_info = wp_check_filetype(basename($src), null);
    					if ($file_info['ext'] == false) {
    						date_default_timezone_set('PRC');
    						$file_name = date('YmdHis-').dechex(mt_rand(100000, 999999)).'.tmp';
    					} else {
    						$file_name = dechex(mt_rand(100000, 999999)) . '-' . basename($src);
    					}
    					curl_setopt($ch, CURLOPT_URL, $src);
    					$file_path = $wp_upload_dir['path'] . '/' . $file_name;
    					$img = fopen($file_path, 'wb');
    					curl_setopt($ch, CURLOPT_FILE, $img);
    					$img_data  = curl_exec($ch);
    					fclose($img);
     
    					if (file_exists($file_path) && filesize($file_path) > 0) {
    						$t   = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
    						$arr = explode('/', $t);
    						if (pathinfo($file_path, PATHINFO_EXTENSION) == 'tmp') {
    							$file_path = $this->handleExt($file_path, $arr[1], $wp_upload_dir['path'], $file_name, 'tmp');
    						} elseif (pathinfo($file_path, PATHINFO_EXTENSION) == 'webp') {
    							$file_path = $this->handleExt($file_path, $arr[1], $wp_upload_dir['path'], $file_name, 'webp');
    						}
    						$post->post_content  = str_replace($src, $wp_upload_dir['url'] . '/' . basename($file_path), $post->post_content);
    						$attachment = $this->getAttachmentPost(basename($file_path), $wp_upload_dir['url'] . '/' . basename($file_path));
    						$attach_id = wp_insert_attachment($attachment, ltrim($wp_upload_dir['subdir'] . '/' . basename($file_path), '/'), 0);
    						$attach_data = wp_generate_attachment_metadata($attach_id, $file_path);
    						$ss = wp_update_attachment_metadata($attach_id, $attach_data);
    					}
    				}
    			}
    			curl_close($ch);
    			$wpdb->update( $wpdb->posts, array('post_content' => $post->post_content), array('ID' => $post->ID));
    		}
    	}
    }
 
    public function handleExt($file, $type, $file_dir, $file_name, $ext)
    {
        switch ($ext) {
        	case 'tmp':
        		if (rename($file, str_replace('tmp', $type, $file))) {
        			if ('webp' == $type) {
        				return $this->imageConvert('webp', 'jpeg', $file_dir . '/' . str_replace('tmp', $type, $file_name));
        			}
        			return $file_dir . '/' . str_replace('tmp', $type, $file_name);
        		}
        	case 'webp':
        		if ('webp' == $type) {
        			return $this->imageConvert('webp', 'jpeg', $file);
        		} else {
        			if (rename($file, str_replace('webp', $type, $file))) {
        				return $file_dir . '/' . str_replace('webp', $type, $file_name);
        			}
        		}
        	default:
        		return $file;
        }
    }
    
    public function imageConvert($from='webp', $to='jpeg', $image)
    {
        $im = imagecreatefromwebp($image);
        if (imagejpeg($im, str_replace('webp', 'jpeg', $image), 100)) {
        	try {
        		unlink($image);
        	} catch (Exception $e) {
        		$error_msg = sprintf('Error removing local file %s: %s', $image,
        			$e->getMessage());
        		error_log($error_msg);
        	}
        }
        imagedestroy($im);
        
        return str_replace('webp', 'jpeg', $image);
    }
    
    public function getAttachmentPost($filename, $url)
    {
        $file_info  = wp_check_filetype($filename, null);
        return array(
        	'guid'           => $url,
        	'post_type'      => 'attachement',
        	'post_mime_type' => $file_info['type'],
        	'post_title'     => preg_replace('/\.[^.]+$/', '', $filename),
        	'post_content'   => '',
        	'post_status'    => 'inherit'
        );
    }

}