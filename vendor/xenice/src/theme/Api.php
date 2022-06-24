<?php

namespace xenice\theme;

class Api
{
    protected $namespace = 'xenice/v1';
    
    protected $resource = 'resource';
    
    protected $routers = [];

    public function __construct()
    {
        add_action( 'rest_api_init', [$this,'__register']);
    }
     
    public function __register()
    {
        foreach($this->routers as $router){
            
            // id
            $id = $router['id'];
            
            // slug
            $slug = '/' . $this->resource;
            if(!empty($router['slug'])){
                $slug .= '/' . ltrim($router['slug'], '/');
            }
            
            // methods
            $arr = [];
            $arr['methods'] = $router['methods']??'GET';
            
            // schema
            /*
            $schema = [];
            $func = [$this, $router['schema']??'schema'];
            if(method_exists($func[0], $func[1])){
                $schema = call_user_func($func);
            }*/
            
            // callback
            $arr['callback'] = [$this, $router['callback']??$id];
            
            // permission_callback
            $func = [$this, $router['permission_callback']??$id . 'Check'];
            if(method_exists($func[0], $func[1])){
                $arr['permission_callback'] = $func;
            }
            else{
                $arr['permission_callback'] = '__return_true';
            }
            // args
            $args = [$this, $router['args']??$id . 'Args'];
            if(method_exists($args[0], $args[1])){
                $arr['args'] = call_user_func($args);
            }
            
            register_rest_route( $this->namespace, $slug, $arr);
        }
    }
    
    public function success($data = [], $msg = 'success')
	{
	    $arr = [
	        'code'=>1,
	        'msg'=>$msg,
	        'data'=>$data
	    ];
	    
	    return $arr;
	}
	
	public function error($msg = 'error')
	{
	    return [
	        'code'=>0,
	        'msg'=>$msg,
	    ];
	    
	}
}