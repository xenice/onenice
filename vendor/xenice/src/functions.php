<?php
/**
 * @name        xenice options
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-09-26
 * @link        http://www.xenice.com/
 * @package     xenice
 */

use xenice\theme\Theme;
use xenice\view\View;
 
 
  /**
 * get current user meta
 */
if(!function_exists("cur_take")){
    
    function cur_take($name)
    {
        $user_id = Theme::get('current_user_id');
        
        if($user_id){
            return multi_take($user_id, $name);
        }
    }
}


 /**
 * get user meta
 */
if(!function_exists("multi_take")){
    function multi_take($user_id, $name)
    {
        static $option = [];
        if(!$option){
            
            $options = Theme::use('app')->getOptions($user_id)?:[];
            foreach($options as $o){
                $option = array_merge($option, $o);
            }
            
        }
        return $option[$name]??'';
    }
}

 /**
 * get option
 */
if(!function_exists("take")){
    function take($name, $key='xenice_options')
    {
        static $option = [];
        if(!$option){
            $options = get_option($key)?:[];
            //var_dump($options);
            foreach($options as $o){
                $option = array_merge($option, $o);
            }
            
        }
        return $option[$name]??'';
    }
}

 /**
 * set option
 */
if(!function_exists("put")){
    function put($name, $value, $key='xenice_options')
    {
        $options = get_option($key)?:[];
        foreach($options as $id=>&$o){
            if(isset($o[$name])){
                $o[$name] = $value;
                update_option($key, $options);
                return;
            }
        }
    }
}

if(!function_exists("_t")){
    function _t($str, $domain = THEME_NAME)
    {
        $translations = get_translations_for_domain($domain);
        return $translations->translate($str);
    }
}

function is_url($v){
	$pattern="#(http|https)://(.*\.)?.*\..*#i";
    return preg_match($pattern,$v);
}


function import($slug, $dir = '', $vars =[])
{
    if($dir == ''){
        $file = '/' . $slug . '.php';
        $file = Theme::call('render_view', VIEW_DIR_EX . $file, VIEW_DIR . $file);
    }
    else{
        $file = $dir . '/' . $slug . '.php';
    }
	extract(View::getVars());
	if($vars){
	   extract($vars);
	}
	include($file);
}

function get_ajax_url($action, $args_str = '')
{
    $url = admin_url('admin-ajax.php').'?action='.$action;
    if($args_str){
        $url .= '&' . $args_str;
    }
    return $url;
}

function get_ext_static_url($ext_name, $slug)
{
    return THEME_URL . '/ext/'.$ext_name.'/static/' . $slug;
}


/*
function import_relate()
{
    // Get the file that called this function
    $arr = debug_backtrace();
    $file = str_replace(VIEW_SLUG, 'app/web/view', $arr[0]['file']);
    
	extract(View::getVars());
	include($file);
}*/

function ad($id, $class='', $style = ''){
    if(take('enable_' . $id. '_ad')){
        $ad_code = take($id. '_ad_code');
        $ad_code_m = take($id. '_ad_code_m');
        $class && $class .= ' ';
        if($ad_code){
            echo '<div class="' . $class .'md-down-none" style="'.$style.'">' . $ad_code . '</div>';
        }
        if($ad_code_m){
            echo '<div class="' . $class .'card md-up-none" style="'.$style.'">' . $ad_code_m . '</div>';
        }
    }
}