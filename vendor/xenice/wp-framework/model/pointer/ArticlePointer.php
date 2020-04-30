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
	    return $this->row->post_category[0];
	}
	
    public function cids()
	{
	    return $this->row->post_category;
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