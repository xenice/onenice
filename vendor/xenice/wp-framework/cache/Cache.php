<?php

/**
 * @name        Xenice Cache
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-08-16
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\cache;

use xenice\theme\Base;

class Cache extends Base
{	
	private $extends;
	
	public function __construct()
	{
        if(!CACHE) return;
        
	    if(class_exists('\Memcached')){
	        $this->extends = new Memcached;
	        $this->extends->addServer('127.0.0.1', '11211');
	    }
	    else{
	        $this->extends = new File;
	    }
	}
	
	protected function set($key, $value, $time = 0)
	{
	    if(!CACHE) return;
	    $this->extends->set($key, $value, $time);
	}
	
	protected function get($key)
	{
	    if(!CACHE) return;
		return $this->extends->get($key);
	}
	
	protected function keys()
	{
	    if(!CACHE) return;
		return $this->extends->keys();
	}
	
	protected function clear()
	{
	    if(!CACHE) return;
	    return $this->extends->clear();
	}
}