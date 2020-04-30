<?php
/**
 * @name        Xenice Pointer
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-10-17
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\model\pointer;

class Pointer
{
    protected $row;
    
    public function null()
    {
        return empty($this->row)?true:false;
    }

}