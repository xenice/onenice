<?php
/**
 * @name        Xenice Model
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-08-16
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\model;

use xenice\theme\Base;


class Model extends Base
{
    public $pointer;

    public function __call($method, $args)
    {
        if(method_exists($this->pointer, $method)){
            return call_user_func_array([$this->pointer, $method], $args);
        }
        elseif (isset($this->$method)){ // Call dynamic methods
            return call_user_func_array($this->$method, $args);
        }
        else{
            throw new \Exception('Call to undefined method ' . get_called_class() . '::' . $method);
        }

    }
}