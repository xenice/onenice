<?php
namespace vessel\ajax;

use vessel\Ajax;

class LikeAjax extends Ajax
{
	public function __construct()
	{
		$this->action('like');
	}
    
    public function like()
    {
		$id = esc_sql($_POST['pid']);
		if(isset($_COOKIE['xenice_likes_'.$id])){
            echo json_encode(['key'=>'liked', 'value'=>esc_html__('You already liked it', 'onenice')]);
            exit;
        }
        
		$count = get_post_meta($id, 'xenice_likes', true);
		if($count){
		    $count ++;
		    update_post_meta($id, 'xenice_likes', $count);
		}
		else{
		    $count = 1;
		    add_post_meta($id, 'xenice_likes', $count, true);
		}

		$html = '<i class="fa fa-thumbs-o-up"></i>&nbsp;' . esc_html__('Liked', 'onenice') . '(<span>' .$count . '</span>)';
		echo json_encode(['key'=>'success','value'=>$html]);
		
        $expire = time() + 99999999;
        $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false; // make cookies work with localhost
        setcookie('xenice_likes_'.$id, $id, $expire, '/', $domain);
		exit;
    }
}