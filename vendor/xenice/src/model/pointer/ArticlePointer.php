<?php
/**
 * @name        Xenice Article Pointer
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-10-17
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\model\pointer;

use xenice\theme\Theme;

class ArticlePointer extends PostPointer
{
    public function __construct($mix)
    {
        parent::__construct($mix);
    }
    
	public function cid()
	{
	    if(property_exists($this->row, 'cid')){
	        return $this->row->cid;
	    }
	    
	    global $wpdb;
	    $taxonomy = $this->taxonomy();
	    $cid = $wpdb->get_var("SELECT r.term_taxonomy_id FROM $wpdb->term_relationships as r, $wpdb->term_taxonomy as t WHERE r.term_taxonomy_id = t.term_taxonomy_id AND r.object_id=".$this->id()." AND t.taxonomy='$taxonomy'");
	    $this->row->cid = intval($cid);
	    return $this->row->cid;
	}
	
	// category type
	public function taxonomy()
	{
	    if(property_exists($this->row, 'taxonomy')){
	        return $this->row->taxonomy;
	    }
	    
	    $type = $this->type();
	    $this->row->taxonomy = ($type == 'post')?'category':$type . "_category";
	    return $this->row->taxonomy;
	}
	
	// tag type
	public function taxis()
	{
	    if(property_exists($this->row, 'taxis')){
	        return $this->row->taxis;
	    }
	    
	    $type = $this->type();
	    $this->row->taxis = ($type == 'post')?'post_tag':$type . "_tag";
	    return $this->row->taxis;
	}
	
	public function content()
	{
	    return Theme::call('article_content', parent::content(), $this);
	}
	
	public function date()
	{
	    return Theme::call('article_date', parent::date(), $this);
	}
	
    public function comments()
	{
	    return Theme::call('article_comments', parent::comments(), $this);
	}
}