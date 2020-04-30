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
	    return get_category($this->cid())->$field;
	}
	
	public function user($field = 'display_name')
	{
	    return get_the_author_meta( $field, $this->uid());
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
	       $excerpt = $this->content();
	    }
	    $excerpt = preg_replace( "/\[.*?\].*?\[\/.*?\]/is", "", $excerpt);
        $excerpt = mb_strimwidth( strip_tags( $excerpt), 0, $limit, "..." );
	    return $excerpt;
	}
	
	public function editUrl()
	{
	    return get_edit_post_link($this->id());
	}
    
    
    public function tags($before = '', $sep = '', $after = '')
    {
        return get_the_term_list( $this->id(), 'post_tag', $before, $sep, $after ); 
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
        if (has_post_thumbnail()){
            $attachment = wp_get_attachment_image_src(get_post_thumbnail_id($this->id()), $type);
            $src = $attachment[0];
        } 
        return Theme::call('article_thumbnail', $src, $this);
    }
    
    public function stick()
    {
        return is_sticky($this->id()); 
    }
}