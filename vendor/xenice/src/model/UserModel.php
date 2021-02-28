<?php
/**
 * @name        Xenice User Model
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-10-13
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\model;

use xenice\theme\Theme;

class UserModel extends Model
{
    protected $login = false;
    
    public function __construct()
    {
        global $current_user;
	    $data = $current_user->data;
	    if(isset($data->ID)){
	        $this->login = true;
	        $this->pointer = Theme::new('user_pointer', $data);
	    }
    }
    
    public function signon($arr)
    {
        $mix = wp_signon( $arr);
		return is_wp_error($mix)?false:true;
    }
    
    public function auth($name, $password)
    {
        $mix = wp_authenticate($name, $password);
		return is_wp_error($mix)?false:true;
    }
   
}