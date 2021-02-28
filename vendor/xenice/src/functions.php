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
 * get option
 */
function take($name)
{
    static $option = [];
    if(!$option){
        $options = get_option('xenice_options')?:[];
        foreach($options as $o){
            $option = array_merge($option, $o);
        }
    }
    return $option[$name]??'';
}

 /**
 * set option
 */
function put($name, $value)
{
    $options = get_option('xenice_options')?:[];
    foreach($options as $id=>&$o){
        if(isset($o[$name])){
            $o[$name] = $value;
            update_option('xenice_options', $options);
            return;
        }
    }
}


function _t($str, $domain = THEME_NAME)
{
    $translations = get_translations_for_domain($domain);
    return $translations->translate($str);
}

function is_url($v){
	$pattern="#(http|https)://(.*\.)?.*\..*#i";
    return preg_match($pattern,$v);
}


function import($slug, $dir = '')
{
    if($dir == ''){
        $file = '/' . $slug . '.php';
        $file = Theme::call('render_view', VIEW_DIR_EX . $file, VIEW_DIR . $file);
    }
    else{
        $file = $dir . '/' . $slug . '.php';
    }
	extract(View::getVars());
	include($file);
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