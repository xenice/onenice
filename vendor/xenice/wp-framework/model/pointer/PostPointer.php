<?php
/**
 * @name        Xenice Post Pointer
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-11-13
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\model\pointer;

use xenice\theme\Theme;

class PostPointer extends Pointer
{
    use part\XeniceMeta;
    
    public function __construct($mix)
    {
        if(is_numeric($mix)){
            $this->row = get_post($mix);
        }
        else{
            $this->row = $mix;
        }
    }
    
    public function id()
	{
		return $this->row->ID;
	}
	
	public function title()
	{
	    return $this->row->post_title;
	}
	
	public function guid()
	{
	    return $this->row->guid;
	}
	
	public function slug()
	{
	    return $this->row->post_name;
	}
	
	public function content()
	{
	    $content = apply_filters( 'the_content', $this->row->post_content );
	    return Theme::call('post_content', $content, $this);
	}
	
	public function uid()
	{
	    return $this->row->post_author;
	}

	public function type()
	{
	    return $this->row->post_type;
	}
	
	public function date()
	{
	    return Theme::call('post_date', $this->row->post_date, $this);
	}
	
	public function status()
	{
	    return $this->row->post_status;
	}

    public function excerpt()
    {
        return $this->row->post_excerpt;
    }
    
    public function comments()
	{
	    return Theme::call('post_comments', $this->row->comment_count, $this);
	}
	
    public function get($key)
    {
        return get_post_meta($this->id(), $key, true);
    }
    
    public function set($key, $value)
    {
        return update_post_meta($this->id(), $key, $value);
    }
}