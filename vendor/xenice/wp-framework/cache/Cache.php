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
	    if(class_exists('\Memcached')){
	        $this->extends = new \Memcached();
            $this->extends->addServer('127.0.0.1', '11211');
	    }
	    else{
	        $this->extends = new File;
	    }
	}
	
	public function set($key, $value, $time = 0)
	{
	    $this->extends->set($key, $value, $time);
	}
	
	public function get($key)
	{
		return $this->extends->get($key);
	}
}