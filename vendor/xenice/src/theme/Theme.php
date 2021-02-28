<?php
/**
 * @name        Xenice Theme
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-08-16
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\theme;

class Theme extends Base
{
	public static $instance;
    private $defines = [];
    private $aliases = [];
    private $instances = [];
	private $actions = [];
	private $prepares = [];
	public  $vars = [];
	
	public function __construct()
	{
	    self::$instance = $this;
	}
	
	protected function instance()
	{
		$args = func_get_args();
		$class = array_shift($args);
		if($args && !isset($this->defines[$class])){
			$this->defines[$class] = function(){
				$reflector = new \ReflectionClass($class);
				if (!$reflector->isInstantiable()) {
                    throw new \Exception('class ['.$class.'] cannot be instantiated');
                }
				return $reflector->newInstanceArgs($args);
			};
		}
		return $this->make($class);
	}
	
    protected function define($class, $closure)
    {
        $this->defines[$class] = $closure;
    }
	
    protected function make($class)
    {
        if (isset($this->instances[$class])) {
            return $this->instances[$class];
        }
        $object = null;
        if (isset($this->defines[$class])) {
            $closure = $this->defines[$class];
			$object = $closure();
        } else {
            $object =  $this->create($class);
        }
        $this->instances[$class] = $object;
        return $object;
    }
	
    private function create($class)
    {
		$class = '\\' . $class;
        $reflector = new \ReflectionClass($class);

        if (!$reflector->isInstantiable()) {
            throw new \Exception('class ['.$class.'] cannot be instantiated');
        }

        $constructor = $reflector->getConstructor();

        if (is_null($constructor)) {
            return new $class;
        }

		$dependencies = [];
        foreach ($constructor->getParameters() as $param) {
            if ($param->isDefaultValueAvailable()) {
                $dependencies[] = $param->getDefaultValue();
            } else {
                $dependClass = $param->getClass();
                $isClass = !is_null($dependClass) ? true : false;
                $dependencies[] = $isClass ? $this->make($dependClass->getName()) : null;
            }
        }
        return $reflector->newInstanceArgs($dependencies);
    }
    
    /**
	 * Get an instance through an alias
     */
    protected function use()
	{
	    $args = func_get_args();
		$alias = array_shift($args);
	    if(isset($this->aliases[$alias])){
	        array_unshift($args, $this->aliases[$alias]);
	        return call_user_func_array([$this,'instance'], $args);
	    }
	}
	
	/**
	 * create an instance through an alias
     */
    protected function new()
	{
	    $args = func_get_args();
		$alias = array_shift($args);
	    if(isset($this->aliases[$alias])){
	        $class = new \ReflectionClass($this->aliases[$alias]);
			return $class->newInstanceArgs($args);
	    }
	}
	
	/**
	 * Add class alias
	 * When a duplicate string key occurs, weak equals false does not override the original value, 
	 * weak equals true overrides the original value, and weak defaults to false
     */
	protected function alias($aliases, $weak =  false)
	{
	    if($weak){
	        $this->aliases = array_merge($aliases, $this->aliases);
	    }
	    else{
	        $this->aliases = array_merge($this->aliases, $aliases);
	    }
	}

    /**
	 * Invoke instance methods through alias
     */
    protected function invoke($alias, $method, $args)
    {
        $instance = $this->use($alias);
        return call_user_func_array([$instance, $method], $args);
    }
    
	protected function bind($name, $closure, $priority = null)
    {
        $action = ['closure'=>$closure];
        if($priority !== null){
            $action['priority'] = $priority;
        }
		if(isset($this->actions[$name])){
		    $this->actions[$name][] = $action;
		}
		else{ // First binding
		    $this->actions[$name] = [];
			$this->actions[$name][] = $action;
		}
    }
	
	protected function call()
    {
		$args = func_get_args();
		$name = array_shift($args);
		
		if (isset($this->actions[$name])){
		    $actions = $this->actions[$name];
		    // priority
		    if(count($actions)>1){
		        $i = 0;
                foreach ($actions as $key=>$action) {
                    if(!isset($action['priority'])){
                        $actions[$key]['priority'] = $i;
                        $i += 10;
                    }
                    $poses[] = $actions[$key]['priority'];
                }
                
                array_multisort($poses, SORT_ASC, $actions);
		    }
		    $rt = null;
		    $first = true;
		    foreach($actions as $action){
		        // The first argument is the value returned by the previous function
		        if($first){
		           $first = false;
		        }
		        else{
		            $args[0] = $rt;
		        }
		       
		        $rt = call_user_func_array($action['closure'], $args);
		    }
		    return $rt;
        }
        return $args[0]??null;
	}
	
	protected function prepare($prepares)
	{
	    $this->prepares = $prepares + $this->prepares;
	}
	
	protected function execute()
	{
	    
        ksort($this->prepares);
	    foreach($this->prepares as $value){
	        $this->instance($value);
	    }
	}
	
	protected function get($key)
	{
	    return $this->vars[$key]??'';
	}
	
	protected function set($key, $value, $merge = false)
	{
	    if($merge && !empty($this->vars[$key])){
            $this->vars[$key] .= $value;
	    }
	    else{
            $this->vars[$key] = $value;
	    }
	}
}