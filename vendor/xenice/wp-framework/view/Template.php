<?php
/**
 * @name        Xenice Template
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-10-22
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\view;

use xenice\theme\Base;
use xenice\theme\Theme;

class Template extends Base
{
    public $js = '';
    
    public function head()
    {
        ob_start(); 
        do_action( 'wp_head');
        $head = ob_get_contents();
        ob_end_clean();
        return Theme::call('head', $head);
    }
    
    public function footer()
    {
        ob_start(); 
        do_action( 'wp_footer' );
        $footer = ob_get_contents();
        ob_end_clean();
        $footer = Theme::call('footer', $footer);
        if($this->js){
            $footer .= '<script>' .$this->js . '</script>';
        }
        return $footer;
    }
    
    public function sidebar($mix)
    {
        $sidebar = '';
        ob_start();
        if(is_array($mix)){
            foreach($mix as $value){
                dynamic_sidebar($value);
            }
        }
        else{
            dynamic_sidebar($mix);
        }
        $sidebar = ob_get_contents();
        ob_end_clean();
        if(!$sidebar){
            $sidebar = '<p>' . _t( 'Please set up widgets at dashboard!') . '</p>';
        }
        return $sidebar;
    }
    
    public function menu($args)
    {
        $args['echo'] = false;
        $args['fallback_cb'] = false;
        return wp_nav_menu($args);
    }

    
    function bodyClass( $class = '')
    {
        return 'class="' . join( ' ', get_body_class( $class ) ) . '"';
    }
}