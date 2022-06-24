<?php
namespace app\pro\ajax;

use xenice\theme\Theme;
use xenice\theme\Ajax;

class LikeAjax extends Ajax
{
	public function __construct()
	{
		$this->action('like');
	}
    
    public function like()
    {
		$id = esc_sql($_POST['pid']);
		if(isset($_COOKIE['xenice_like_'.$id])){
            echo json_encode(['key'=>'liked', 'value'=>_t('You already liked it')]);
            exit;
        }
        
		$count = get_post_meta($id, 'likes', true);
		if($count){
		    $count ++;
		    update_post_meta($id, 'likes', $count);
		}
		else{
		    $count = 1;
		    add_post_meta($id, 'likes', $count, true);
		}

		$html = '<i class="fa fa-thumbs-o-up"></i>&nbsp;' . _t('Liked') . '(<span>' .$count . '</span>)';
		echo json_encode(['key'=>'success','value'=>$html]);
		
        $expire = time() + 99999999;
        $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false; // make cookies work with localhost
        setcookie('xenice_like_'.$id, $id, $expire, '/', $domain);
		exit;
    }
}