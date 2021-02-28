<?php
/**
 * @name        Xenice Page Pointer
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-10-17
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\model\pointer;

use xenice\theme\Theme;

class PagePointer extends PostPointer
{
    public function __construct($mix)
    {
        parent::__construct($mix);
    }
    
	public function date()
	{
	    return Theme::call('Page_date', parent::date(), $this);
	}
	
    public function comments()
	{
	    return Theme::call('Page_comments', parent::comments(), $this);
	}
}