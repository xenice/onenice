<?php
require __dir__ . '/config/app.php';
require __dir__ . '/vendor/autoload.php';

use xenice\theme\Theme;
use xenice\view\View;
use app\web\Loader;

Theme::alias([
    // model
    'user' => 'app\web\model\User',
    'article' => 'app\web\model\Article',
    'page' => 'app\web\model\Page',
    'category' => 'app\web\model\Category',
    'tag' => 'app\web\model\Tag',
    'comment' => 'app\web\model\Comment',
    
    // pointer
    'article_pointer' => 'app\web\model\pointer\Article',
    'page_pointer' => 'app\web\model\pointer\Page',
    'category_pointer' => 'app\web\model\pointer\Category',
    'comment_pointer' => 'app\web\model\pointer\Comment',
    'user_pointer' => 'app\web\model\pointer\User',
    
]);

Theme::bind('xenice_route_run',function($type, $method, $args){
    $class = ucfirst($type) . 'Controller';
	$controller = Theme::instance('app\web\controller\\' . $class);
    $controller->extends = View::instance();
    return call_user_func_array([$controller, $method], $args);
});


function _t($str, $domain = THEME_NAME)
{
    $translations = get_translations_for_domain($domain);
    return $translations->translate($str);
}

function is_url($v){
	$pattern="#(http|https)://(.*\.)?.*\..*#i";
    return preg_match($pattern,$v);
}


function import($slug, $dir = VIEW_DIR)
{
	extract(View::getVars());
	include($dir . '/' . $slug . '.php');
}

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


Loader::instance();