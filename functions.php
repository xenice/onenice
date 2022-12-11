<?php

define('HOME_URL', home_url('', empty($_SERVER['HTTPS'])?'http':'https'));
define('THEME_NAME', wp_get_theme()->get('Name'));
define('THEME_URI', wp_get_theme()->get('ThemeURI'));
define('THEME_DIR', get_template_directory());
define('THEME_URL', get_template_directory_uri());
define('THEME_VER', wp_get_theme()->get('Version'));
define('STATIC_DIR', THEME_DIR . '/static');
define('STATIC_URL', THEME_URL . '/static');
define('AJAX_URL', admin_url('admin-ajax.php'));

load_theme_textdomain(THEME_NAME, __DIR__ . '/languages/');

/* customize */

$onenice_defaults = [
    // global
    'site_icon'=>STATIC_URL . '/images/icon.ico',
    'theme_color'=>'#0099FF #007bff #99CCFF',
    'static_lib_cdn'=>'',
    'page_width'=>'1200px',
    
    // header
    'site_logo'=>STATIC_URL . '/images/logo.png',
    'show_search'=>true,
    'show_login_button'=>true,
    
    // footer
    'delete_theme_copyright'=>false,
    'icp_number'=>'',
    
    // slides
    'enable_slides'=>true,
    'slides_image_1'=>STATIC_URL . '/images/onenice_slide_1.jpg',
    'slides_url_1'=>'https://www.xenice.com',
    'slides_title_1'=>__('OneNice Theme','onenice'),
    'slides_description_1'=> __('OneNice is a super concise WordPress theme, supporting both Chinese and English, free open source, no encryption, no redundant code, no authorization restrictions, can be used freely.','onenice'),
    
    'slides_image_2'=>STATIC_URL . '/images/onenice_slide_2.jpg',
    'slides_url_2'=>'https://www.xenice.com',
    'slides_title_2'=>__('OneNice Theme','onenice'),
    'slides_description_2'=> __('OneNice is a super concise WordPress theme, supporting both Chinese and English, free open source, no encryption, no redundant code, no authorization restrictions, can be used freely.','onenice'),
    
    'slides_image_3'=>STATIC_URL . '/images/onenice_slide_3.jpg',
    'slides_url_3'=>'https://www.xenice.com',
    'slides_title_3'=>__('OneNice Theme','onenice'),
    'slides_description_3'=> __('OneNice is a super concise WordPress theme, supporting both Chinese and English, free open source, no encryption, no redundant code, no authorization restrictions, can be used freely.','onenice'),
    
    // archive
    'list_style'=>'text',
    'excerpt_length'=>50,
    'site_thumbnail'=>STATIC_URL . '/images/thumbnail.png',
    'site_loading_image'=>STATIC_URL . '/images/loading.png',
    'archive_show_date'=>true,
    'archive_show_author'=>true,

    
    // posts
    'single_show_date'=>true,
    'single_show_author'=>true,
    'single_show_tags'=>true,
    'single_show_previous_next'=>true,
    'show_related_posts'=>true,
    'single_show_share'=>false,
    'single_disable_share_buttons'=>'weibo,wechat,qq,douban,qzone,tencent,linkedin,diandian,google,twitter,facebook',
    'single_enable_highlight'=>false,
];

function onenice_get($name){
    global $onenice_defaults;
    return get_theme_mod( $name, $onenice_defaults[$name]);
}

function onenice_customize($wp_customize){
    require __DIR__ . '/includes/Onenice_Options.php';
    new Onenice_Options($wp_customize);
    
}

add_action('customize_register', 'onenice_customize');

/* #customize */

function onenice_breadcrumb(){
    
    function onenice_get_greadcrumb($cid, $taxonomy)
    {
        if(is_date()){
            $str = '<span class="breadcrumb-item active">' . get_the_date() . '</span>';
            return $str;
        }
        if(is_author()){
            $str = '<span class="breadcrumb-item active">' . get_the_author() . '</span>';
            return $str;
        }
        $str = '';
        $row = get_term($cid, $taxonomy);
        $pid = $row->parent;
        if($pid){
            $str .= onenice_get_greadcrumb($pid);
        }
        $str .= '<a class="breadcrumb-item" href="'. get_term_link($row->term_id, $taxonomy) .'">'.$row->name.'</a>';
        return $str;
    }
    
    if(is_single()){
        global $post;
        global $wpdb;
        $cats = wp_get_post_categories($post->ID);
        $str = '<a class="breadcrumb-item" href="'. home_url() .'">'.__('Home', 'onenice').'</a>'; 
        if($cid = $cats[0]){
            $taxonomy = $wpdb->get_var("SELECT taxonomy FROM $wpdb->term_taxonomy WHERE term_id=".$cid);
            $str .= onenice_get_greadcrumb($cid, $taxonomy);
        }
        $str .= '<span class="breadcrumb-item active">' . $post->post_title . '</span>';
    	return $str;
    }
    elseif(is_archive()){
        global $wpdb;
	    $cid = get_queried_object_id();
		$taxonomy = $wpdb->get_var("SELECT taxonomy FROM $wpdb->term_taxonomy WHERE term_id=".$cid);
        $str = '<a class="breadcrumb-item" href="'. home_url() .'">'.__('Home', 'onenice').'</a>'; 
        $str .= onenice_get_greadcrumb($cid, $taxonomy);
    	return $str;
    }
}


function onenice_login(){
    global $current_user;
	$user = $current_user->data;
    $str = '<div class="user-login">';
    if(isset($user->ID)){
        //$str .= get_avatar($user->ID, 32, '', '', ['class'=>'rounded-circle']);
        //$str .= '<a>'.$user->display_name.'</a> &nbsp;';
        if(is_super_admin($user->ID)){
            $str .= '<a href="'.get_admin_url().'">'.__('Admin', 'onenice').'</a> &nbsp;';
        }
        
        $str .= '<a href="'.wp_logout_url().'">'.__('Logout','onenice').'</a>';
    }
    else{
        $str .= '<a href="'.wp_login_url().'" >'.__('Login', 'onenice').'</a>';
    }
    $str .= '</div>';
    return $str;
}

if ( function_exists( 'add_theme_support' ) ) {
    add_theme_support( 'post-thumbnails' );
}
register_nav_menus(['main-menu'=> __( 'Main Menu', 'onenice')]);
register_sidebar(['id' => 'home','name' => __('Home', 'onenice'),'before_title'  => '<h3>','after_title'   => '</h3>']);
register_sidebar(['id' => 'single','name' => __('Posts', 'onenice'),'before_title'  => '<h3>','after_title'   => '</h3>']);
register_sidebar(['id' => 'archive','name' => __('archive', 'onenice'),'before_title'  => '<h3>','after_title'   => '</h3>']);


function onenice_exclude_sticky_posts($query){
    if ( $query->is_home() && $query->is_main_query() ) {
        $query->set( 'ignore_sticky_posts', 1 );
    }
}  
add_action('pre_get_posts','onenice_exclude_sticky_posts');

function onenice_excerpt( $str ) {
	return strip_tags($str);
}
add_filter( 'the_excerpt', 'onenice_excerpt');

function onenice_excerpt_length( $length ) {
	return onenice_get('excerpt_length');
}
add_filter( 'excerpt_length', 'onenice_excerpt_length');

function onenice_excerpt_more( $more ) {
	return ' ...';
}
add_filter( 'excerpt_more', 'onenice_excerpt_more');


function onenice_post_thumbnail_url( $thumbnail_url, $post, $size) {
    if(!$thumbnail_url){
        return onenice_get('site_thumbnail');
    }
	return $thumbnail_url;
}
add_filter( 'post_thumbnail_url', 'onenice_post_thumbnail_url',99999999,3);


if(!is_admin()){
    
    function onenice_load_scripts()
    {
        //wp_dequeue_style( 'wp-block-library' );
        wp_deregister_script( 'jquery' );
        $cdn_url = onenice_get('static_lib_cdn');
        
        if($cdn_url){
            wp_enqueue_style('font-awesome', $cdn_url . '/font-awesome/4.7.0/css/font-awesome.min.css', [], '4.7.0');
            wp_enqueue_style('bootstrap-css', $cdn_url . '/twitter-bootstrap/4.4.1/css/bootstrap.min.css', [], '4.4.1');
            
            wp_enqueue_script('jquery', $cdn_url . '/jquery/3.2.1/jquery.min.js', [], '3.2.1',true);
            wp_enqueue_script('popper', $cdn_url . '/popper.js/1.15.0/umd/popper.min.js', [], '1.15.0',true);
            wp_enqueue_script('bootstrap-js', $cdn_url . '/twitter-bootstrap/4.4.1/js/bootstrap.min.js', [], '4.4.1',true);
            wp_enqueue_script('gifffer', $cdn_url . '/gifffer/1.5.0/gifffer.min.js', [], '1.5.0',true);
        }
        else{
            wp_enqueue_style('font-awesome', STATIC_URL . '/css/font-awesome.min.css', [], '4.7.0');
            wp_enqueue_style('bootstrap-css', STATIC_URL. '/libs/bootstrap/css/bootstrap.min.css', [], '4.4.1');

            wp_enqueue_script('jquery', STATIC_URL. '/libs/jquery/jquery.min.js', [], '3.2.1',true);
            wp_enqueue_script('popper', STATIC_URL. '/libs/popper/popper.min.js', [], '1.15.0',true);
            wp_enqueue_script('bootstrap-js', STATIC_URL. '/libs/bootstrap/js/bootstrap.min.js', [], '4.4.1',true);
            wp_enqueue_script('gifffer', STATIC_URL. '/libs/gifffer/gifffer.min.js', [], '1.5.0',true);
            
        }
        
        wp_enqueue_style('style', STATIC_URL . '/css/style.css', [], THEME_VER);
        wp_enqueue_script('lazyload', STATIC_URL . '/libs/lazyload/lazyload.min.js', [], '2.0.0', true);
        //wp_enqueue_script('xenice', STATIC_URL . '/js/xenice.js', [], THEME_VER,true);
        //wp_enqueue_script('login', STATIC_URL . '/js/login.js', [], THEME_VER,true);
        
        if(is_single()){

            if(onenice_get('single_enable_highlight')){
                if($cdn_url){
                    wp_enqueue_style('highlight-css', $cdn_url . '/highlight.js/10.1.2/styles/vs.min.css', [], '10.1.2');
                    wp_enqueue_script('highlight-js', $cdn_url . '/highlight.js/10.1.2/highlight.min.js', [], '10.1.2', true);
                    wp_enqueue_script('line-numbers', $cdn_url . '/highlightjs-line-numbers.js/2.8.0/highlightjs-line-numbers.min.js', [], '2.8.0', true);
                }
                else{
                    wp_enqueue_style('highlight-css', STATIC_URL . '/libs/highlight/styles/vs.css', [], '9.9.0');
                    wp_enqueue_script('highlight-js', STATIC_URL . '/libs/highlight/highlight.pack.js', [], '9.9.0', true);
                    wp_enqueue_script('line-numbers', STATIC_URL . '/libs/highlight/line-numbers.min.js', [], '1.0.0', true);
                }
                
                
                
            }
            
            if(onenice_get('single_show_share', true)){
                if($cdn_url){
                    wp_enqueue_style('share-css', $cdn_url . '/social-share.js/1.0.16/css/share.min.css', [], '1.0.16');
                    wp_enqueue_script('share-js', $cdn_url . '/social-share.js/1.0.16/js/jquery.share.min.js', [], '1.0.16', true);
                }
                else{
                    wp_enqueue_style('share-css', STATIC_URL . '/libs/share/css/share.min.css', [], '1.0.16');
                    wp_enqueue_script('share-js', STATIC_URL . '/libs/share/js/jquery.share.min.js', [], '1.0.16', true);
                }
            }
            
        }
            
        
    }
    
    add_action( 'wp_enqueue_scripts', 'onenice_load_scripts');
    
    
    function onenice_head(){
        // set theme color
        $colors = explode(' ', onenice_get('theme_color'));
        list($a1, $a2, $a3) = $colors;
        $styles = [
            'a:hover'=>"{color:$a1;}",
            '.breadcrumb a:hover'=>"{color:$a1;}",
            '.comment-form .submit,.btn-custom,.badge-custom'=>"{color:#fff!important;background-color:$a1;border-color:$a1;}",
            '.comment-form .submit:hover,.btn-custom:hover,.badge-custom:hover'=>"{color:#fff;background-color:$a2;border-color:$a2}",
            '.form-control:focus'=>"{border-color: $a3!important;}",
            
            '.navbar-nav .current-menu-item a'=>"{color:$a1}",
            '.fa-search:hover'=>"{color:$a1;}",
            '.post-content a'=>"{color:$a1;}",
            '.post-content a:hover'=>"{color:$a2;}",
            '.rollbar .rollbar-item:hover'=>"{background-color: $a3;}",
            
        ];
         // #set theme color
        
        // set page width
        $styles['.container, .container-lg, .container-md, .container-sm, .container-xl'] = '{max-width: '.onenice_get('page_width').';}';
        // #set page width
        
        $str = '<style>';
        foreach($styles as $key => $style){
            $str .= $key . $style;
        }
        $str .= '</style>';
       
       if(onenice_get('single_enable_highlight')){
            $str .= '<style>
            /* for block of numbers */
            .hljs-ln-numbers {
                text-align: center;
                background-color: #fafafa;
                
                vertical-align: top;
                padding-right: 5px;
                /* your custom style here */
            }
            .hljs-ln{
                border: solid 1px #eee;
                width: 100%;
                padding:10px 0;
                
            }
            
            /* for block of code */
            .hljs-ln td{
                border-right:solid 1px #eee;;
                border-bottom:none;
                padding-left: 5px!important;
            }
            
            .hljs-ln tr td:first-child{
                width:40px;
            }
            
            </style>';
       }
        echo $str;
    }
    
    add_action( 'wp_head', 'onenice_head');
    
    
    
    
    add_action('wp_footer', function(){
        echo '<script>
         jQuery(function(){
            len = jQuery(".widget_tag_cloud .tagcloud a").length - 1;
            jQuery(".widget_tag_cloud .tagcloud a").each(function(i) {
                var let = new Array( "27ea80","3366FF","ff5473","df27ea", "31ac76", "ea4563", "31a6a0", "8e7daa", "4fad7b", "f99f13", "f85200", "666666");
                var random1 = Math.floor(Math.random() * 12) + 0;
                var num = Math.floor(Math.random() * 5 + 12);
                jQuery(this).attr("style", "background:#" + let[random1] + "; opacity: 0.6;");
                if (jQuery(this).next().length > 0) {
                    last = $(this).next().position().left
                }
            });
         });
        </script>';
        
       if(is_single()){
           if(onenice_get('single_enable_highlight')){
               echo '<script>hljs.initHighlightingOnLoad();hljs.initLineNumbersOnLoad();</script>';
           }
       }
       
    },99);
}

