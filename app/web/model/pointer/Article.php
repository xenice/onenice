<?php

namespace app\web\model\pointer;

use xenice\theme\Theme;
use xenice\model\pointer\ArticlePointer;

class Article extends ArticlePointer
{
    public function __construct($mix)
    {
        parent::__construct($mix);
    }
    
    public function url()
	{
	    return get_permalink($this->id());
	}
	
    public function curl()
	{
	    return get_category_link($this->cid());
	}
	
    public function category($field = 'name')
	{
	    $obj = get_term($this->cid(), $this->taxonomy());
	    if(!is_wp_error($obj)){
	        return $obj->$field;
	    }
	}
	
	public function user($field = 'display_name')
	{
	    return get_the_author_meta( $field, $this->uid());
	}
	
	public function avatar($size = 32)
	{
	    return get_avatar( $this->user('user_email'), $size, '', '', ['class'=>'rounded-circle']);
	}
	
    public function views()
    {
        return Theme::call('article_views', $this->get('views')?:0);
    }
    
    public function description($limit = 180)
	{
	    if(take('enable_article_seo')){
	        if($rt = $this->get('description')){
	            return $rt;
	        }
	    }
	    $excerpt = $this->excerpt();
	    if(!$excerpt){
	       $excerpt = $this->row('post_content');
	    }
	    $pattern = '\[(\[?)([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)';
        $excerpt = preg_replace("/$pattern/", '', $excerpt);
	    //$excerpt = preg_replace( "/\[.*?\].*?\[\/.*?\]/is", "", $excerpt);
        $excerpt = mb_strimwidth( strip_tags( $excerpt), 0, $limit, "..." );
	    return $excerpt;
	}
	
	public function editUrl()
	{
	    return get_edit_post_link($this->id());
	}
    
    
    public function tags($taxis = '', $before = '', $sep = '', $after = '')
    {
        $taxis || $taxis = $this->taxis();
        return get_the_term_list( $this->id(), $taxis, $before, $sep, $after ); 
    }
    
    public function keywords()
    {
        if(take('enable_article_seo')){
	        if($rt = $this->get('keywords')){
	            return $rt;
	        }
	    }
        $tags = wp_get_post_tags($this->id());
        $keywords = '';
        foreach ( $tags as $tag ) {
            $keywords = $keywords . $tag->name . ",";
        }
        return rtrim($keywords, ', ');
    }
    
    public function thumbnail($type = 'full')
    {
        $src = null;
        if (get_post_meta( $this->id(), '_thumbnail_id', true )){
            $attachment = wp_get_attachment_image_src(get_post_thumbnail_id($this->id()), $type);
            $src = $attachment[0];
        }
        return Theme::call('article_thumbnail', $src, $this);
    }
    
    public function stick()
    {
        return is_sticky($this->id()); 
    }
    
    public function likes()
    {
        return Theme::call('article_likes', $this->get('likes')?:0);
    }
    
    public function tag()
    {
        $arr = get_the_tags($this->id());
        if(isset($arr[0])){
            return $arr[0];
        }
    }
}