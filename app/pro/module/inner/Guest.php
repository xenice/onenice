<?php

namespace app\pro\module\inner;

use xenice\theme\Theme;

class Guest extends \app\web\module\inner\Guest
{
    
    public function __construct()
	{
		parent::__construct();
		Theme::bind('render_view', [$this, 'render']);
		take('only_search_title') && add_filter( 'posts_search', [$this, 'onlySearchTitle'], 10, 2 );
		
	}
	
	public function render($ex, $web)
    {
        if(!is_file($ex) && is_file($web)){
            return $web;
        }
        else{
            return $ex;
        }
    }
    
    public function customColor($colors)
    {
        $styles = parent::customColor($colors);
        list($a1, $a2, $b1, $b2, $b3, $b4) = $colors;
        $styles = [
            '.current-menu-item>a'=>"{color:$a1}",
            '.fa-search:hover'=>"{color:$a2;}",
            '.search-toggle .fa-times'=>"{color:$a1}",
            '.modal .nav-item .nav-link'=>"{color:$b4;}",
            '.modal .nav-item .active'=>"{color:$a2;}",
        ] + $styles;
        
        if(take('enable_css_animation')){
            $styles['@keyframes fade-in'] = '{ 0% { transform: translateY(20px); opacity: 0 } 100% { transform: translateY(0); opacity: 1 } }';
            $styles['@-webkit-keyframes fade-in'] = '{ 0% { -webkit-transform: translateY(20px); opacity: 0 } 100% { -webkit-transform: translateY(0); opacity: 1 } }';
        }
        return $styles;
    }
    
    public function addScripts()
    {
        $scripts = Parent::addScripts();
        $scripts['css'][50] = ['style', STATIC_URL_EX . '/css/style.css', [], THEME_VER];
        $scripts['js'][100] = ['xenice', STATIC_URL_EX . '/js/xenice.js', [], THEME_VER,true];
        $scripts['js'][110] = ['login', STATIC_URL_EX . '/js/login.js', [], THEME_VER,true];
        return $scripts;
    }

    public function onlySearchTitle( $search, $wp_query )
    {
        if ( ! empty( $search ) && ! empty( $wp_query->query_vars['search_terms'] ) ) {
            global $wpdb;
            $q = $wp_query->query_vars;
            $n = ! empty( $q['exact'] ) ? '' : '%';
            $search = array();
            foreach ( ( array ) $q['search_terms'] as $term )
                $search[] = $wpdb->prepare( "$wpdb->posts.post_title LIKE %s", $n . $wpdb->esc_like( $term ) . $n );
            if ( ! is_user_logged_in() )
                $search[] = "$wpdb->posts.post_password = ''";
            $search = ' AND ' . implode( ' AND ', $search );
            
        }
        return $search;
    }
}