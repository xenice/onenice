<?php
/**
 * @name        Xenice custom meta
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-10-17
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\model\pointer\part;

use xenice\theme\Theme;

trait XeniceMeta
{
    public function getRow($key, $metaKey = 'xenice_table')
    {
        $rows = $this->get($metaKey);
        if(is_array($rows) && isset($rows[$key])){
            return $rows[$key];
            
        }
    }
    
    public function setRow($data, $metaKey = 'xenice_table')
    {
        $rows = $this->get($metaKey);
        if(!is_array($rows)){
            $rows = [];
        }
        if(empty($data['key'])){
            $data['key'] = uniqid();
        }
        $rows[$data['key']] = $data;
		return $this->set($metaKey, $rows);
    }
    
    public function delRow($key, $metaKey = 'xenice_table')
    {
        $rows = $this->get($metaKey);
        if(!is_array($rows)){
            $rows = [];
        }
        if(isset($rows[$key])){
            unset($rows[$key]);
            return $this->set($metaKey, $rows);
        }
    }
    
    public function getValue($key = '', $metaKey = 'xenice_value')
    {
        $data = $this->get($metaKey);
        return empty($key)?$data:(isset($data[$key])?$data[$key]:'');
    }
    
    public function setValue($mix, $value = '', $metaKey = 'xenice_value')
    {
        is_string($mix) && $mix =  [$mix => $value];
        $data = $this->get($metaKey);
        empty($data) && $data = [];
        $data = array_merge($data, $mix);
		return $this->set($metaKey, $data);
    }
    
    public function delValue($key, $metaKey = 'xenice_value')
    {
        $arr = $this->get($metaKey);

        if(!is_array($arr)){
            return;
        }
        if(isset($arr[$key])){
            unset($arr[$key]);
            return $this->set($metaKey, $arr);
        }
    }
    
    public function getValues($metaKey = 'xenice_value')
    {
        return $this->get($metaKey);
    }
    
    public function setValues($data, $metaKey = 'xenice_value')
    {
        $arr = $this->getValues();
        empty($arr) && $arr = [];
        $data = array_merge($arr, $data);
        return $this->set($metaKey, $data);
    }
}