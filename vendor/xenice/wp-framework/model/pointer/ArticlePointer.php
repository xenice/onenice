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
	    global $wpdb;
	    $cid = $wpdb->get_var("SELECT term_taxonomy_id FROM $wpdb->term_relationships WHERE object_id=".$this->id());
	    return intval($cid);
	}
	
	public function taxonomy()
	{
	    $type = $this->type();
	    return ($type == 'post')?'category':$type . "_category";
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