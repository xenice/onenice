<?php
/**
 * @name        Xenice Pointer
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-10-17
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\model\pointer;

use xenice\theme\Base;

class Pointer extends Base
{
    protected $row;
    
    public function null()
    {
        return empty($this->row)?true:false;
    }
    
    public function row($name)
    {
        return $this->row->$name;
    }
}