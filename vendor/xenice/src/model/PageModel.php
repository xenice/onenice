<?php
/**
 * @name        Xenice Page Model
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-10-13
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\model;

use xenice\theme\Theme;

class PageModel extends Model
{

    public function __construct()
    {
        $this->type = Theme::get('type');
        switch($this->type){
            case 'page':
                global $post;
                $this->pointer = Theme::new('page_pointer', $post);
                break;
        }
    }
    
    
    public function first($template)
    {
        global $wpdb;
        $page_id = $wpdb->get_var($wpdb->prepare("SELECT `post_id` 
        FROM `$wpdb->postmeta`, `$wpdb->posts`
        WHERE `post_id` = `ID`
        AND `post_status` = 'publish'
        AND `meta_key` = '_wp_page_template'
        AND `meta_value` = %s
        LIMIT 1;", $template));
        if($page_id){
            return Theme::new('page_pointer', $page_id);
        }
    }
}