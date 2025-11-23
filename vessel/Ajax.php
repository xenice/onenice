<?php
/**
 * @name        Xenice Ajax
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-08-16
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace vessel;

class Ajax
{
    public function action($method)
	{
	    add_action( 'wp_ajax_' . $method, [$this, $method] );
        add_action( 'wp_ajax_nopriv_' . $method,  [$this, $method] );
	}
	
	public function guestAction($method)
	{
        add_action( 'wp_ajax_nopriv_' . $method,  [$this, $method] );
	}
	
	public function adminAction($method)
	{
	    add_action( 'wp_ajax_' . $method, [$this, $method] );
	}
}