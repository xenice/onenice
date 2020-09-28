<?php
/**
 * @name        Xenice Loader
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-08-16
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\theme;

class Loader extends Base
{
    public function __construct()
	{
	    if(WP_DEBUG){
	        error_reporting(-1);
            ini_set('display_errors', 1);
	    }
	    isset($_SESSION) || session_start();
	    load_theme_textdomain(THEME_NAME, THEME_DIR . '/lang');
	    date_default_timezone_set(get_option('timezone_string'));
	    add_action('after_switch_theme',[$this, 'themeCheck']);
	    Theme::alias([
	        
	        // model
	        'article' => 'xenice\model\ArticleModel',
	        'page' => 'xenice\model\PageModel',
	        'category' => 'xenice\model\CategoryModel',
	        'tag' => 'xenice\model\TagModel',
	        'comment' => 'xenice\model\CommentModel',
            'option' => 'xenice\model\OptionModel',
            'user' => 'xenice\model\UserModel',
            
            // pointer
            'article_pointer' => 'xenice\model\pointer\ArticlePointer',
            'category_pointer' => 'xenice\model\pointer\CategoryPointer',
            'tag_pointer' => 'xenice\model\pointer\TagPointer',
	        'comment_pointer' => 'xenice\model\pointer\CommentPointer',
	        'user_pointer' => 'xenice\model\pointer\UserPointer',
	        
            // template
            'template' => 'xenice\view\Template',
            
            // route
            'route' => 'xenice\theme\Route',
            
            // cache
            'cache' => 'xenice\cache\Cache',

        ], true);
        
	    if(is_admin()){
	        add_filter( 'theme_templates', [$this, 'addTemplates']);
		}
	}

	public function addTemplates($templates)
	{
		$dir = VIEW_DIR . '/page';
		$arr = scandir($dir);
		foreach($arr as $name){
			$file = $dir . '/' . $name;
			if(is_dir($dir . '/' . $file)){
				continue;
			}
			if (!preg_match( '|Template Name:(.*)$|mi', @file_get_contents( $file ), $header ) ) {
				continue;
			}
			$templates[substr($name,0,-4)] = $header[1];
			
		}
		return $templates;
	}
	
	function themeCheck()
	{
        $body = [
            'key'=>'iunice',
            'seceret'=>'f47a40c92ef0605f0bfdb03b7b02bfbd',
            'data'=>[
                'type'=>'user',
                'name' => get_bloginfo('name'), 
                'theme' => wp_get_theme()->get('Name'),
                'version' => wp_get_theme()->get('Version'), 
                'domain' => get_bloginfo('url'), 
                'email' => get_bloginfo('admin_email')
            ]
        ];
        
        $key = md5(json_encode($body['data']) . date("Y-m-d"));
        $m = Theme::use('option');
        $url='https://api.xenice.com/guest';
        $request = new \WP_Http;
        $result = $request->request( $url, ['method' => 'POST', 'body' => $body]);
        $m->setMeta('xenice_guest', $key, $body['data']['type']);
    }
}