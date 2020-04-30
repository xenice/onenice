<?php
/**
 * @name        Xenice User Pointer
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-10-17
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\model\pointer;

use xenice\theme\Theme;

class UserPointer extends Pointer
{

    use part\XeniceMeta;
    
    public function __construct($mix)
    {
        if(is_numeric($mix)){
            $this->row = get_userdata($mix);
        }
        else{
            $this->row = $mix;
        }
        
    }
    
    public function id()
	{
		return $this->row->ID;
	}
	
	public function name()
	{
		return $this->row->user_login;
	}
	
	public function email()
	{
		return $this->row->user_email;
	}
	
	public function nicename()
	{
		return $this->row->display_name;
	}
	
	public function url()
	{
		return $this->row->user_url;
	}
	
	public function registered()
	{
		return $this->row->user_registered;
	}
	
	public function update($mix)
	{
	    $mix['ID'] = $this->row->ID;
	    $id = wp_update_user($mix);
	    return is_wp_error($id)?false:true;
	}
	
    public function get($key)
    {
        return get_user_meta($this->id(), $key, true);
    }
    
    public function set($key, $value)
    {
        return update_user_meta($this->id(), $key, $value);
    }
}