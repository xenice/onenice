<?php


/**
 * Functions
 *
 */

require __DIR__ . '/vessel/vessel.php';

require __DIR__ . '/ext/ext.php';

/**
 * Get option
 *
 * @param string $name option name.
 */
function yy_get( $name) {
    
    return vessel\get($name);
}

/**
 * Get page
 *
 * @param string $template tempalge name.
 */
function yy_get_page($template)
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
        return get_post($page_id);
    }
}

/**
 * Add page
 *
 * @param string $template tempalge name.
 */
function yy_add_page($template){
    $post = [
        'post_name' => 'login',
        'post_title' => __('Login', 'onenice'),
        'post_status'=> 'publish',
        'post_type' => 'page'
    ];
    
    $id = wp_insert_post($post);
    
    if($id){
        update_post_meta($id, '_wp_page_template', $template);
    }
}

/**
 * Import tempalge page
 *
 * @param string $template tempalge name.
 */
function yy_import($name){
    $file = apply_filters('yy_import_file', '', $name);
    if(is_file($file)){
        include($file);
        return true;
    }
}

/**
 * Breadcrumb
 *
 * @return string   Output breadcrumb html.
 */
function yy_breadcrumb() {
	/**
	 * Get breadcrumb
	 *
	 * @param int    $cid          Category id.
	 * @param string $taxonomy  Category taxonomy name.
	 * @return string           Return the breadcrumb html.
	 */
	function yy_get_greadcrumb( $cid, $taxonomy ) {
		if ( is_date() ) {
			echo '<span class="breadcrumb-item active">' . esc_html( get_the_date('Y-m-d') ) . '</span>';
			return;
		}
		if ( is_author() ) {
			echo '<span class="breadcrumb-item active">' . esc_html( get_the_author() ) . '</span>';
			return;
		}
		if(is_post_type_archive()){
		    echo '<span class="breadcrumb-item active">' . esc_html( post_type_archive_title('', false) ) . '</span>';
		    return;
		}

		$row = get_term( $cid, $taxonomy );
		$pid = $row->parent;
		if ( $pid ) {
			yy_get_greadcrumb( $pid, $taxonomy );
		}
		echo '<a class="breadcrumb-item" href="' . esc_attr( get_term_link( $row->term_id, $taxonomy ) ) . '">' . esc_html( $row->name ) . '</a>';
		
	}
    if ( is_page() ) {
		global $post;
		global $wpdb;
		echo '<a class="breadcrumb-item" href="' . esc_attr( home_url() ) . '">' . esc_html__( 'Home', 'onenice' ) . '</a>';
		echo '<span class="breadcrumb-item active">' . esc_html( $post->post_title ) . '</span>';
		return;
	}
	elseif ( is_single() ) {
	    global $post;
		global $wpdb;
	    if (get_post_type() != 'post') {
            $post_type = get_post_type_object(get_post_type());
            $post_type_archive_link = get_post_type_archive_link($post_type->name);
            $post_type_archive_name = $post_type->labels->name;
            echo '<a class="breadcrumb-item" href="' . esc_attr( home_url() ) . '">' . esc_html__( 'Home', 'onenice' ) . '</a>';
            echo '<a class="breadcrumb-item" href="' . esc_attr( $post_type_archive_link ) . '">' . $post_type_archive_name . '</a>';
            echo '<span class="breadcrumb-item active">' . esc_html( $post->post_title ) . '</span>';
		    return;
	    }
		
		$cats = wp_get_post_categories( $post->ID );
		echo '<a class="breadcrumb-item" href="' . esc_attr( home_url() ) . '">' . esc_html__( 'Home', 'onenice' ) . '</a>';
		$cid = $cats[0]??0;
		if ( $cid ) {
			$taxonomy = wp_cache_get( 'taxonomy_' . $cid, 'yy_cache_group' );
			if ( false === $taxonomy ) {
				$taxonomy = $wpdb->get_var( $wpdb->prepare( "SELECT taxonomy FROM {$wpdb->term_taxonomy} WHERE term_id=%d", $cid ) );
				wp_cache_set( 'taxonomy_' . $cid, $taxonomy, 'yy_cache_group' );
			}
			yy_get_greadcrumb( $cid, $taxonomy );
		}
		echo '<span class="breadcrumb-item active">' . esc_html( $post->post_title ) . '</span>';
		return;
	}
	elseif ( is_archive() ) {
		global $wpdb;
		$cid      = get_queried_object_id();
		$taxonomy = wp_cache_get( 'taxonomy_' . $cid, 'yy_cache_group' );
		if ( false === $taxonomy ) {
			$taxonomy = $wpdb->get_var( $wpdb->prepare( "SELECT taxonomy FROM {$wpdb->term_taxonomy} WHERE term_id=%d", $cid ) );
			wp_cache_set( 'taxonomy_' . $cid, $taxonomy, 'yy_cache_group' );
		}
		echo '<a class="breadcrumb-item" href="' . esc_attr( home_url() ) . '">' . esc_html__( 'Home', 'onenice' ) . '</a>';
		yy_get_greadcrumb( $cid, $taxonomy );
	}
}

/**
 * Login
 */
function yy_login() {
	global $current_user;
	$user = $current_user->data;
	echo '<div class="user-login">';
	if ( isset( $user->ID ) ) {

		?>
		<style>
			#userMenuLink .avatar{
				border-radius: 5px;
			}
			.user-menu .dropdown-item{
				font-size:13px;
				color:#555;
			}
			.user-menu .role{
				color:#999;
			}

			.user-menu .expire{
				color:#999;
			}
			@media screen and (max-width: 767px){

			}
		</style>
		<div class="dropdown">
		<a class="" href="#" role="button" id="userMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<?php echo get_avatar( $user->ID, 32 ); ?>
		</a>

		<div class="dropdown-menu dropdown-menu-right user-menu" aria-labelledby="userMenuLink">
		<?php
		if ( function_exists( 'xenice\member\get_vip_info' ) ) {
			$vip_info = xenice\member\get_vip_info( $user->ID );

			echo '<span class="dropdown-item role">' . esc_html( $user->display_name ) . ' (' . esc_html( $vip_info['name'] ) . ')</span>';
			if ( 'vip' === $vip_info['key'] || 'svip' === $vip_info['key'] ) {
				echo '<span class="dropdown-item expire">' . esc_html__( 'Expire time: ', 'onenice' ) . esc_html( $vip_info['expire'] ) . '</span>';

			}
            
			$page_id = xenice\member\get( 'vip_checkout' );
			if ( $page_id ) {
				echo '<a class="dropdown-item" href="' . esc_html( get_permalink( $page_id ) ) . '">' . esc_html__( 'Buy VIP ', 'onenice' ) . '</a>';
			}
		}
		else{
		    echo '<span class="dropdown-item role">' . esc_html( $user->display_name ) . '</span>';
		}
		
		if(function_exists('xc_get_page_url')){
            echo '<a class="dropdown-item" href="' . esc_html( xc_get_page_url('my_orders') ) . '">' . esc_html__('My orders', 'onenice' ) . '</a>';
        }
		?>
		<?php if(current_user_can('edit_posts')):?>
            <a class="dropdown-item" href="<?php echo esc_attr( get_admin_url()); ?>"><?php esc_html_e( 'Manage', 'onenice' ); ?></a>
		<?php endif;?>
			<a class="dropdown-item" href="<?php echo esc_attr( wp_logout_url() ); ?>"><?php esc_html_e( 'Logout', 'onenice' ); ?></a>
			</div>
		</div>
		<?php

	} else {
		echo '<a href="' . esc_attr( wp_login_url() ) . '" >' . esc_html__( 'Login', 'onenice' ) . '</a>';
	}
	echo '</div>';
}

if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
}
register_nav_menus( array( 'main-menu' => __( 'Main Menu', 'onenice' ) ) );

/**
 * Register sidebars
 */
function yy_register_sidebars() {
	register_sidebar(
		array(
			'id'           => 'home',
			'name'         => __( 'Home', 'onenice' ),
			'before_title' => '<h3>',
			'after_title'  => '</h3>',
		)
	);
	register_sidebar(
		array(
			'id'           => 'single',
			'name'         => __( 'Posts', 'onenice' ),
			'before_title' => '<h3>',
			'after_title'  => '</h3>',
		)
	);
	register_sidebar(
		array(
			'id'           => 'archive',
			'name'         => __( 'archive', 'onenice' ),
			'before_title' => '<h3>',
			'after_title'  => '</h3>',
		)
	);
}

add_action( 'widgets_init', 'yy_register_sidebars' );

/**
 * Ignore sticky posts
 *
 * @param object $query query object.
 */
function yy_exclude_sticky_posts( $query ) {
	if ( $query->is_home() && $query->is_main_query() ) {
		$query->set( 'ignore_sticky_posts', 1 );
	}
}
add_action( 'pre_get_posts', 'yy_exclude_sticky_posts' );

/**
 * Clean excerpt html
 *
 * @param string $excerpt   query object.
 * @return string       Return to the overworry excerpt.
 */
function yy_excerpt( $excerpt ) {
	$excerpt = wp_strip_all_tags( $excerpt );
	$max_len = yy_get( 'excerpt_length' );
	if(mb_strlen($excerpt)>$max_len){
        return mb_substr($excerpt, 0, $max_len).'...';
    }
    else{
        return $excerpt;
    }
}
add_filter( 'the_excerpt', 'yy_excerpt' );


/**
 * Set the default thumbnail url
 *
 * @param string $thumbnail_url   Original thumbnail url.
 * @return string       Returns the modified thumbnail url.
 */
function yy_post_thumbnail_url( $thumbnail_url ) {
	if ( ! $thumbnail_url ) {
		return yy_get( 'site_thumbnail' );
	}
	return $thumbnail_url;
}
add_filter( 'post_thumbnail_url', 'yy_post_thumbnail_url', 99999999, 1 );

/**
 * Set the number of tag clouds and sort by count
 *
 * @param array $args   Tag cloud args.
 * @return string       Returns the modified tag cloud args.
 */
function yy_tag_cloud_args( $args ) {
	$newargs = array(
		'orderby' => 'count',
		'order'   => 'DESC',
		'number'  => 30,
	);

	return array_merge( $args, $newargs );
}
add_filter( 'widget_tag_cloud_args', 'yy_tag_cloud_args' );

/**
 * Get post first image
 *
 */
function yy_get_post_first_image($post){
    
    $content = $post->post_content;

    preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);

    if (!empty($matches[1])) {
        $image_url = $matches[1];
        return $image_url;
    }

    return false;
}






if ( ! is_admin() ) {
	/**
	 * Load script and style
	 */
	function yy_load_scripts() {
		$cdn_url = yy_get( 'static_lib_cdn' );

		if ( $cdn_url ) {
			wp_enqueue_style( 'font-awesome', $cdn_url . '/font-awesome/4.7.0/css/font-awesome.min.css', array(), '4.7.0' );
			wp_enqueue_style( 'bootstrap', $cdn_url . '/twitter-bootstrap/4.4.1/css/bootstrap.min.css', array(), '4.4.1' );

			wp_enqueue_script( 'popper', $cdn_url . '/popper.js/1.15.0/umd/popper.min.js', array(), '1.15.0', true );
			wp_enqueue_script( 'bootstrap', $cdn_url . '/twitter-bootstrap/4.4.1/js/bootstrap.min.js', array( 'jquery' ), '4.4.1', true );
			wp_enqueue_script( 'gifffer', $cdn_url . '/gifffer/1.5.0/gifffer.min.js', array(), '1.5.0', true );
		} else {
			wp_enqueue_style( 'font-awesome', STATIC_URL . '/css/font-awesome.min.css', array(), '4.7.0' );
			wp_enqueue_style( 'bootstrap', STATIC_URL . '/libs/bootstrap/css/bootstrap.min.css', array(), '4.4.1' );

			wp_enqueue_script( 'popper', STATIC_URL . '/libs/popper/popper.min.js', array(), '1.15.0', true );
			wp_enqueue_script( 'bootstrap', STATIC_URL . '/libs/bootstrap/js/bootstrap.min.js', array( 'jquery' ), '4.4.1', true );
			wp_enqueue_script( 'gifffer', STATIC_URL . '/libs/gifffer/gifffer.min.js', array(), '1.5.0', true );

		}

		wp_enqueue_style( 'yythemes', STATIC_URL . '/css/style.css', array('bootstrap'), filemtime(STATIC_DIR . '/css/style.css'));
		wp_enqueue_script( 'yythemes', STATIC_URL . '/js/script.js', array('bootstrap'), filemtime(STATIC_DIR . '/js/script.js'));
		wp_enqueue_script( 'lazyload', STATIC_URL . '/libs/lazyload/lazyload.min.js', array(), '2.0.0', true );

		if ( is_single() ) {

			if ( yy_get( 'single_enable_highlight' ) ) {
				if ( $cdn_url ) {
					wp_enqueue_style( 'highlight', $cdn_url . '/highlight.js/10.1.2/styles/vs.min.css', array(), '10.1.2' );
					wp_enqueue_script( 'highlight', $cdn_url . '/highlight.js/10.1.2/highlight.min.js', array(), '10.1.2', true );
					wp_enqueue_script( 'line-numbers', $cdn_url . '/highlightjs-line-numbers.js/2.8.0/highlightjs-line-numbers.min.js', array(), '2.8.0', true );
				} else {
					wp_enqueue_style( 'highlight', STATIC_URL . '/libs/highlight/styles/vs.css', array(), '9.9.0' );
					wp_enqueue_script( 'highlight', STATIC_URL . '/libs/highlight/highlight.pack.js', array(), '9.9.0', true );
					wp_enqueue_script( 'line-numbers', STATIC_URL . '/libs/highlight/line-numbers.min.js', array(), '1.0.0', true );
				}
			}

			if ( yy_get( 'single_show_share') ) {
				if ( $cdn_url ) {
					wp_enqueue_style( 'share', $cdn_url . '/social-share.js/1.0.16/css/share.min.css', array(), '1.0.16' );
					wp_enqueue_script( 'share', $cdn_url . '/social-share.js/1.0.16/js/social-share.min.js', array(), '1.0.16', true );
				} else {
					wp_enqueue_style( 'share', STATIC_URL . '/libs/share/css/share.min.css', array(), '1.0.16' );
					wp_enqueue_script( 'share', STATIC_URL . '/libs/share/js/social-share.min.js', array(), '1.0.16', true );
				}
			}
		}

	}

	add_action( 'wp_enqueue_scripts', 'yy_load_scripts' );
	
    
	/**
	 * Add style
	 */
	function yy_head(){

		// set theme color.
		$vars = [];
	    $vars['--yy-main-color']  = yy_get( 'main_color' )?:'#0099FF';
	    $vars['--yy-dark-color']  = yy_get( 'dark_color' )?:'#007bff';
	    $vars['--yy-light-color'] = yy_get( 'light_color' )?:'#99CCFF';
	    $vars['--yy-link-color']  = yy_get( 'link_color' )?:'#555555';
	    $vars['--yy-bg-color']    = yy_get( 'bg_color' )?:'#ffffff';
	    $vars['--yy-fg-color']    = yy_get( 'fg_color' )?:'#333333';
		
		$vars['--yy-hf-main-color']  = yy_get( 'hf_main_color' )?:'#0099FF';
	    $vars['--yy-hf-dark-color']  = yy_get( 'hf_dark_color' )?:'#007bff';
	    $vars['--yy-hf-light-color'] = yy_get( 'hf_light_color' )?:'#99CCFF';
	    $vars['--yy-hf-link-color']  = yy_get( 'hf_link_color' )?:'#555555';
	    $vars['--yy-hf-bg-color']    = yy_get( 'hf_bg_color' )?:'#ffffff';
	    $vars['--yy-hf-fg-color']    = yy_get( 'hf_fg_color' )?:'#333333';
	    
		$page_width = yy_get( 'page_width' )?:1200;
		$vars['--yy-page-width'] = $page_width . 'px';
        
        /**
    	 * Filter css vars
    	 */
        $vars = apply_filters('yy_css_vars', $vars);
        
        echo '<style>';
        echo ':root{';
		foreach ( $vars as $key => $style ) {
			echo esc_html( $key . ':' . $style . ';');
		}
		echo '}';
		
		if(yy_get('enable_css_animation')){
            echo '@keyframes fade-in{ 0% { transform: translateY(20px); opacity: 0 } 100% { transform: translateY(0); opacity: 1 } } ';
            echo '@-webkit-keyframes fade-in{ 0% { -webkit-transform: translateY(20px); opacity: 0 } 100% { -webkit-transform: translateY(0); opacity: 1 } } ';
        }
		
		echo '</style>';

        echo '<script>';
        echo 'var admin_ajax = "'.admin_url( 'admin-ajax.php' ).'"';
        echo '</script>';
		if ( yy_get( 'single_enable_highlight' ) ) {
			?>
			<style>
			/* for block of numbers */
			.hljs-ln-numbers {
				text-align: center;
				background-color: #fafafa;
				vertical-align: top;
				padding-right: 5px;
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

			</style>
			<?php
		}

	}

	add_action( 'wp_head', 'yy_head' );

    
	add_action('wp_footer', function() {
		?>
		<script>
		jQuery(function($){
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
		</script>
			<?php

			if ( is_single() ) {
				if ( yy_get( 'single_enable_highlight' ) ) {
					?>
					<script>hljs.initHighlightingOnLoad();hljs.initLineNumbersOnLoad();</script>
					<?php
				}
			}
			

	},99);
	
	function yy_rollbar(){
        ?>
        <script>
            jQuery(function($){
                $(".rollbar .scroll-top").on("click",function(){
    				$("body,html").animate({"scrollTop":0},500);
    			});
            });
        </script>
        <?php
        echo '<div class="rollbar md-down-none">';
		if ( yy_get( 'enable_back_to_top' ) ) {
			?>
			<div class="rollbar-item scroll-top" title="<?php esc_attr_e( 'Back to top', 'onenice' ); ?>"><i class="fa fa-angle-up"></i></div>
			<?php

		}
		echo '</div>';
    }
    add_action('wp_footer', 'yy_rollbar', 99);
	
}


