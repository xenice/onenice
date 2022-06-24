<?php
/**
 * @name        Xenice Base
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-08-16
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\theme;

class Base
{	
	public $extras = []; // Extended objects
	
	public static function __callstatic($method, $args)
	{
		// instance Theme
		if(!Theme::$instance){
			$instance = new Theme;
		}
		
		$classname = get_called_class();
		if(get_class(Theme::$instance) == $classname){
			// execute Theme method
			$instance = Theme::$instance;
			return call_user_func_array([$instance, $method], $args);
			
		}
		else{
			if($method == 'instance'){
				// instance object in the Theme
				array_unshift($args, $classname);
				return call_user_func_array([Theme::$instance, 'instance'], $args);
			}
			else{
				// execute object method
				$instance = Theme::$instance->instance($classname);
				return call_user_func_array([$instance, $method], $args);
			}
		}
		
	}
	
	public function __call($method, $args)
    {
        
        foreach($this->extras as $ext){
            if(method_exists($ext, $method)){
                array_unshift($args, $this);
                return call_user_func_array([$ext, $method], $args);
            }
        }
        throw new \Exception('Call to undefined method ' . get_called_class() . '::' . $method);
    }
}