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
	    isset($_SESSION) || @session_start();
	    load_theme_textdomain(THEME_NAME, THEME_DIR . '/lang');
	    date_default_timezone_set(get_option('timezone_string'));
	    add_action('after_switch_theme',[$this, 'switchTheme']);
	    Theme::alias([
	        // util
	        'str' => 'xenice\util\Str',
	        'http' => 'xenice\util\Http',
	        'cookie' => 'xenice\util\Cookie',
	        'client' => 'xenice\util\Client',
	        'buffer' => 'xenice\util\Buffer',
	        'aes' => 'xenice\util\Aes',
	        'rsa' => 'xenice\util\Rsa',
	        
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
            'page_pointer' => 'xenice\model\pointer\PagePointer',
            'category_pointer' => 'xenice\model\pointer\CategoryPointer',
            'tag_pointer' => 'xenice\model\pointer\TagPointer',
	        'comment_pointer' => 'xenice\model\pointer\CommentPointer',
	        'user_pointer' => 'xenice\model\pointer\UserPointer',
	        
            // template
            'view' => 'xenice\view\View',
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
		$dir = VIEW_DIR_EX . '/page';
		if(is_dir($dir)){
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
		}
		return $templates;
	}
	
	function switchTheme()
	{
	    // 设置随机KEY以备后用
	    $m = Theme::use('option');
	    if(!$m->getValue('key32')){
	        $m->setValue("key32", md5(uniqid (mt_rand(), true)));
	    }
    }
}