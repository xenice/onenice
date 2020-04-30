<?php

namespace app\web\action;

use xenice\theme\Action;
use xenice\theme\Theme;

class GlobalAction extends Action
{
	public function __construct()
	{
	    // Change login page
	    add_action('login_enqueue_scripts',[$this, 'login']);
	    
	    $this->registerMenus();
        $this->registerSidebars();
	    // Register theme languages files
        
        
        add_action('init', [$this, 'enableSession']);
        add_theme_support( 'post-thumbnails' );
        add_image_size( 'index-thumbnail', 250, 250, true );
	}
    
    public function login()
    {
        $page = Theme::use('page');
        if($p = $page->first('login')){
            header('Location:' . $p->url());
        }
    }

    
    
    public function enableSession()
    {
    	if(!session_id()){	
    		session_start();
    	}
    }
    
    private function registerMenus()
    {
        register_nav_menus([
            'top-menu'=> _t( 'Top menu')
        ]);
    }
    
    private function registerSidebars()
    {
        register_sidebar([
            'id'            => 'global_top',
            'name'          => _t('Global Top'),
            'before_title'  => '<h3>',
            'after_title'   => '</h3>'
        ]);
        
        register_sidebar([
            'id'            => 'global_bottom',
            'name'          => _t('Global Bottom'),
            'before_title'  => '<h3>',
            'after_title'   => '</h3>'
        ]);
        
        register_sidebar([
            'id'            => 'home',
            'name'          => _t('Home Page'),
            'before_title'  => '<h3>',
            'after_title'   => '</h3>'
        ]);
        
        register_sidebar([
            'id'            => 'category',
            'name'          => _t('Category Page'),
            'before_title'  => '<h3>',
            'after_title'   => '</h3>'
        ]);
        
        register_sidebar([
            'id'            => 'tag',
            'name'          => _t('Tag Page'),
            'before_title'  => '<h3>',
            'after_title'   => '</h3>'
        ]);
        
        register_sidebar([
            'id'            => 'search',
            'name'          => _t('Search Page'),
            'before_title'  => '<h3>',
            'after_title'   => '</h3>'
        ]);
        
        register_sidebar([
            'id'            => 'single',
            'name'          => _t('Single Page'),
            'before_title'  => '<h3>',
            'after_title'   => '</h3>'
        ]);
    }
    
}