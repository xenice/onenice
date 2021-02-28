<?php
/**
 * @name        Xenice Tag Model
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-11-29
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\model;

use xenice\theme\Theme;

class TagModel extends Model
{
    
    public function __construct()
    {
        if(Theme::get('type') == 'tag'){
            $name = single_tag_title('',false);
        	$mix = get_term_by('name',$name,'post_tag');   
            $this->pointer = Theme::new('tag_pointer', $mix);
        }
    }
}