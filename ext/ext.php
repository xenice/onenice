<?php

/**
 * Get ext option
 *
 * @param string $name option name.
 */
function yy_ext_get($name, $key='xenice_yy_ext'){
    static $option = [];
    if(!$option){
        $options = get_option($key)?:[];
        foreach($options as $o){
            $option = array_merge($option, $o);
        }
    }
    return $option[$name]??'';
}

spl_autoload_register( function( $classname ) {
    $prefix = 'YYThemes_';
    $base_dir = __DIR__ . '/';
    
    if ( strpos( $classname, $prefix ) !== 0 ) {
        return;
    }
    
    $relative_class = substr( $classname, strlen( $prefix ) );
    $file = $base_dir . 'class-' . str_replace( '_', '-', strtolower( $relative_class ) ) . '.php';

    if ( file_exists( $file ) ) {
        require $file;
    }
});

add_action('after_setup_theme', function(){
    global $pagenow;
    if('themes.php' == $pagenow && isset( $_GET['activated'])){
        (new YYThemes_Ext_Config)->active();
    }
});

add_action( 'admin_menu', function(){
    add_submenu_page('onenice', esc_html__('Extension','onenice'), esc_html__('Extension','onenice'), 'manage_options', 'onenice-ext', function(){
        (new YYThemes_Ext_Config)->show();
    });
    
},20);


new YYThemes_Optimize;
new YYThemes_Sticky_Posts;
new YYThemes_Photoswipe;
new YYThemes_Relative_Date;