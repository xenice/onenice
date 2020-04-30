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
    public function getMeta($metaKey, $key = '')
    {
        $data = $this->get($metaKey);
        return empty($key)?$data:(isset($data[$key])?$data[$key]:'');
    }
    
    public function setMeta($metaKey, $mix, $value = '')
    {
        is_string($mix) && $mix =  [$mix => $value];
        $data = $this->get($metaKey);
        empty($data) && $data = [];
        $data = array_merge($data, $mix);
		return $this->set($metaKey, $data);
    }
    
    public function getValue($key = '')
    {
        return $this->getMeta('xenice_value', $key);
    }
    
    public function setValue($mix, $value = '')
    {
        return $this->setMeta('xenice_value', $mix, $value );
    }
    
}