<?php
/**
 * @name        Xenice Option Model
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-10-20
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\model;

class OptionModel extends Model
{
    use pointer\part\XeniceMeta;
    
    public $info;
    
    public function __construct()
    {
        $this->info['url'] = get_bloginfo('url');
        $this->info['name'] = get_bloginfo('name');
        $this->info['description'] = get_bloginfo('description');
        $this->info['email'] = get_bloginfo('admin_email');
    }
    
    public function get($key)
    {
        return get_option($key);
    }
    
    public function set($key, $value)
    {
        return update_option($key, $value);
    }
    
    public function delete($key)
    {
        return delete_option($key);
    }
}