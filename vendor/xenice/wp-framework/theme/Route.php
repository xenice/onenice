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
	public function __construct()
	{
		add_action("template_include", [$this,'run']);
	}
	
	public function run($template)
	{
		if(is_home()){
			$type = 'home';
		}
		elseif(is_single()){
			$type = 'single';
		}
		elseif(is_category()){
			$type = 'category';
		}
		elseif(is_page()){
			$type = 'page';
		}
		elseif(is_tag()){
			$type = 'tag';
		}
		elseif(is_search()){
			$type = 'search';
		}
		elseif(is_archive()){
			$type = 'archive';
		}
		elseif(is_author()){
			$type = 'author';
		}
		elseif(is_404()){
			$type = 'notFound';
		}
		
		$method = 'index';
		$args = [];
		Theme::set('type', $type);
		return Theme::call('xenice_route_run', $type, $method, $args);
		
	}
}