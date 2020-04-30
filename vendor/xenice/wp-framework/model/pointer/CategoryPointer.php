<?php
/**
 * @name        Xenice Category Pointer
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-10-17
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\model\pointer;

use xenice\theme\Theme;

class CategoryPointer extends Pointer
{

    public function __construct($mix)
    {
        $this->row = get_category($mix);
    }
    
    public function id()
	{
		return $this->row->cat_ID;
	}
	
	public function pid()
	{
		return $this->row->category_parent;
	}

	
	public function name()
	{
		return $this->row->cat_name;
	}
	
	public function slug()
	{
		return $this->row->category_nicename;
	}
	
	public function count()
	{
		return $this->row->category_count;
	}
	
	public function description()
	{
		return $this->row->category_description;
	}
}