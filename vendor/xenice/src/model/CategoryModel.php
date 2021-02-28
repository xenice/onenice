<?php
/**
 * @name        Xenice Article Model
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-10-13
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\model;

use xenice\theme\Theme;

class CategoryModel extends Model
{
    
    public function __construct()
    {
        $type = Theme::get('type');
        if($type == 'category' || $type == 'tax'){
            $this->pointer = Theme::new('category_pointer', Theme::get('cid'));
        }
    }
}