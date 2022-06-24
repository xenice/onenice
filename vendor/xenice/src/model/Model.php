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
        // Call pointer methods
        if(method_exists($this->pointer, $method)){
            return call_user_func_array([$this->pointer, $method], $args);
        }
        // Call pointer extends methods
        foreach($this->pointer->extras as $ext){
            if(method_exists($ext, $method)){
                array_unshift($args, $this->pointer);
                
                return call_user_func_array([$ext, $method], $args);
            }
        }
        
        // Call dynamic methods
        if (isset($this->$method)){ 
            return call_user_func_array($this->$method, $args);
        }
        
        return parent::__call($method, $args);

    }
}