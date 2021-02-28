<?php

namespace app\web\module\inner;

use xenice\theme\Theme;

class Base extends \xenice\theme\Base
{
	public function __construct()
	{
	    add_action( 'wp_enqueue_scripts', [$this, 'scripts']);
	    // Change login page
	    add_action('login_enqueue_scripts',[$this, 'login']);
	    
	    $this->registerMenus();
        $this->registerSidebars();
	    // Register theme languages files

        add_theme_support( 'post-thumbnails' );
        add_image_size( 'index-thumbnail', 250, 250, true );
	}
	
    public function scripts()
    {
        $scripts = $this->addScripts();
        
        ksort($scripts['css']);
        foreach($scripts['css'] as $arr){
            call_user_func_array('wp_enqueue_style', $arr);
        }
        
        ksort($scripts['js']);
        foreach($scripts['js'] as $arr){
            call_user_func_array('wp_enqueue_script', $arr);
        }
    }
    
    public function addScripts()
    {
        return ['css'=>[], 'js'=>[]];
    }
    
    public function login()
    {
        $page = Theme::use('page');
        if($p = $page->first('login')){
            header('Location:' . $p->url());
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