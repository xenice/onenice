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
        $this->row = get_term($mix, Theme::get('taxonomy'));
    }
    
    public function id()
	{
		return $this->row->term_id;
	}
	
	public function pid()
	{
		return $this->row->parent;
	}

	
	public function name()
	{
		return $this->row->name;
	}
	
	public function slug()
	{
		return $this->row->slug;
	}
	
	public function count()
	{
		return $this->row->count;
	}
	
	public function description()
	{
		return $this->row->description;
	}
}