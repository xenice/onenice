<?php
/**
 * @name        Xenice Tag Pointer
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-11-29
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\model\pointer;

use xenice\theme\Theme;

class TagPointer extends Pointer
{

    public function __construct($mix)
    {
        if(is_numeric($mix)){
            $this->row = get_term_by('id', $mix, 'post_tag');   
        }
        else{
            $this->row = $mix;
        }
        
    }
    
    public function id()
	{
		return $this->row->term_id;
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
}