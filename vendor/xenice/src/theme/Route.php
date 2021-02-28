<?php
/**
 * @name        Xenice Route
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-09-07
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\theme;

class Route extends Base
{
    public $rules = [];
    public $namespace = 'app\web\controller\\';
    
	public function __construct()
	{
        add_action( 'init', [$this,'addRules']);
	    add_filter('query_vars', [$this, 'addQuery'], 1);
		add_action("template_include", [$this,'run']);
		add_filter('template_redirect', [$this,'generate'],1);
		
	}
	
	public function generate()
	{
	    // custom page
	    global $wp_query;
		$key = $wp_query->query_vars['xenice_route']??'';
        if ($key && isset($this->rules[$key])){
			$args = $wp_query->query_vars['xenice_route_args']??[];
			$args = empty($args)?[]:explode(' ', $args);
			call_user_func_array($this->rules[$key]['callback'],$args);
			exit;
		}
	}
	
	public function run($template)
	{
		// default page
		if(is_home()){
			$type = 'home';
		}
		elseif(is_single()){
			$type = 'single';
		}
		elseif(is_page()){
			$type = 'page';
		}
		elseif(is_category()){
		    global $cat;
		    Theme::set('taxonomy', 'category');
		    Theme::set('cid', $cat);
			$type = 'category';
		}
		elseif(is_tag()){
		    Theme::set('taxonomy', 'post_tag');
			$type = 'tag';
		}
		elseif(is_tax()){
		    global $wpdb;
		    $cid = get_queried_object_id();
			$taxonomy = $wpdb->get_var("SELECT taxonomy FROM $wpdb->term_taxonomy WHERE term_id=".$cid);
		    Theme::set('taxonomy', $taxonomy);
		    Theme::set('cid', $cid);
			$type = 'tax';
		}
		elseif(is_search()){
			$type = 'search';
		}
		elseif(is_author()){
			$type = 'author';
		}
		elseif(is_archive()){
			$type = 'archive';
		}
		elseif(is_404()){
			$type = 'notFound';
		}
		else{
		    $type = Theme::call('set_undefined_type');
		}
		$method = 'index';
		$args = [];
		Theme::set('type', $type);
		
		if(Theme::call('xenice_route_run', $type, $method, $args)){
		    $class = ucfirst($type) . 'Controller';
		    
		    $controllers = Theme::get('controllers');
		    if(isset($controllers[$class])){ // custom controllers
		        $controller = Theme::instance($controllers[$class]);
		    }
		    else{
                $controller = Theme::instance('app\web\controller\\' . $class);
		    }
            $controller->extends = Theme::use('view');
            return call_user_func_array([$controller, $method], $args);
		}
	}
	
    public function add($slug, $callback, $count = 0, $level = 'top')
	{
		$this->rules[md5($slug)] = ['slug'=>$slug, 'callback'=>$callback, 'count'=>$count, 'level'=>$level];
	}
	
    public function addRules()
    {
		foreach($this->rules as $key=>$arr){
		    $args = '';
		    if($arr['count']>0){
		        for($i=1; $i<=$arr['count']; $i++){
		            $args .= '+$matches['.$i.']';
		        }
		        $args = '&xenice_route_args=' . ltrim($args,'+');
		    }
			add_rewrite_rule($arr['slug'], 'index.php?xenice_route=' . $key . $args, $arr['level']);
		}
        flush_rewrite_rules();
    }
    
    function addQuery($vars)
    {
        $vars[] = 'xenice_route';
		$vars[] = 'xenice_route_args';
        return $vars;
    }
}