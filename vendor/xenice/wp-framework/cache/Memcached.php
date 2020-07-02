<?php
/**
 * @name        Xenice Memcached
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2020-06-21
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\cache;

class Memcached extends \Memcached
{
    public function keys()
    {
        return $this->getAllKeys();
    }
    
    // clear all cache
    public function clear()
    {
        $this->deleteMulti($this->keys());
    }
}