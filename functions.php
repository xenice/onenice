<?php
/**
 * Functions
 *
 * @package Onenice
 */

define( 'HOME_URL', home_url( '', empty( $_SERVER['HTTPS'] ) ? 'http' : 'https' ) );
define( 'THEME_NAME', 'onenice' );
define( 'THEME_URI', wp_get_theme()->get( 'ThemeURI' ) );
define( 'THEME_DIR', get_template_directory() );
define( 'THEME_URL', get_template_directory_uri() );
define( 'THEME_VER', wp_get_theme()->get( 'Version' ) );
define( 'STATIC_DIR', THEME_DIR . '/static' );
define( 'STATIC_URL', THEME_URL . '/static' );
define( 'AJAX_URL', admin_url( 'admin-ajax.php' ) );

load_theme_textdomain( THEME_NAME, __DIR__ . '/languages/' );

/* customize */

$onenice_defaults = array(
	// global.
	'site_icon'                    => STATIC_URL . '/images/icon.ico',
	'theme_color'                  => '#0099FF #007bff #99CCFF',
	'static_lib_cdn'               => '',
	'page_width'                   => '1200px',
	'enable_back_to_top'           => false,
	'service_qq'                   => '',

	// header.
	'site_logo'                    => STATIC_URL . '/images/logo.png',
	'show_search'                  => true,
	'show_login_button'            => true,

	// footer.
	'delete_theme_copyright'       => false,
	'icp_number'                   => '',

	// slides.
	'enable_slides'                => true,
	'slides_image_1'               => STATIC_URL . '/images/onenice_slide_1.jpg',
	'slides_url_1'                 => 'https://www.xenice.com',
	'slides_title_1'               => __( 'OneNice Theme', 'onenice' ),
	'slides_description_1'         => __( 'OneNice is a super concise WordPress theme, supporting both Chinese and English, free open source, no encryption, no redundant code, no authorization restrictions, can be used freely.', 'onenice' ),

	'slides_image_2'               => STATIC_URL . '/images/onenice_slide_2.jpg',
	'slides_url_2'                 => 'https://www.xenice.com',
	'slides_title_2'               => __( 'OneNice Theme', 'onenice' ),
	'slides_description_2'         => __( 'OneNice is a super concise WordPress theme, supporting both Chinese and English, free open source, no encryption, no redundant code, no authorization restrictions, can be used freely.', 'onenice' ),

	'slides_image_3'               => STATIC_URL . '/images/onenice_slide_3.jpg',
	'slides_url_3'                 => 'https://www.xenice.com',
	'slides_title_3'               => __( 'OneNice Theme', 'onenice' ),
	'slides_description_3'         => __( 'OneNice is a super concise WordPress theme, supporting both Chinese and English, free open source, no encryption, no redundant code, no authorization restrictions, can be used freely.', 'onenice' ),

	// archive.
	'list_style'                   => 'text',
	'excerpt_length'               => 50,
	'site_thumbnail'               => STATIC_URL . '/images/thumbnail.png',
	'site_loading_image'           => STATIC_URL . '/images/loading.png',
	'archive_show_date'            => true,
	'archive_show_author'          => true,


	// posts.
	'single_show_date'             => true,
	'single_show_author'           => true,
	'single_show_tags'             => true,
	'single_show_previous_next'    => true,
	'show_related_posts'           => true,
	'single_show_share'            => false,
	'single_disable_share_buttons' => 'weibo,wechat,qq,douban,qzone,tencent,linkedin,diandian,google,twitter,facebook',
	'single_enable_highlight'      => false,
);

/**
 * Get option
 *
 * @param string $name  option name.
 */
function onenice_get( $name ) {
	global $onenice_defaults;
	return get_theme_mod( $name, $onenice_defaults[ $name ] );
}

/**
 * Register customize options
 *
 * @param object $wp_customize wp customize object.
 */
function onenice_customize( $wp_customize ) {
	require __DIR__ . '/includes/class-onenice-options.php';
	new Onenice_Options( $wp_customize );

}

add_action( 'customize_register', 'onenice_customize' );

/**
 * Breadcrumb
 *
 * @return string   Output breadcrumb html.
 */
function onenice_breadcrumb() {
	/**
	 * Get breadcrumb
	 *
	 * @param int    $cid          Category id.
	 * @param string $taxonomy  Category taxonomy name.
	 * @return string           Return the breadcrumb html.
	 */
	function onenice_get_greadcrumb( $cid, $taxonomy ) {
		if ( is_date() ) {
			echo '<span class="breadcrumb-item active">' . esc_html( get_the_date() ) . '</span>';
			return;
		}
		if ( is_author() ) {
			echo '<span class="breadcrumb-item active">' . esc_html( get_the_author() ) . '</span>';
			return;
		}
		$row = get_term( $cid, $taxonomy );
		$pid = $row->parent;
		if ( $pid ) {
			onenice_get_greadcrumb( $pid );
		}
		echo '<a class="breadcrumb-item" href="' . esc_attr( get_term_link( $row->term_id, $taxonomy ) ) . '">' . esc_html( $row->name ) . '</a>';
	}

	if ( is_single() ) {
		global $post;
		global $wpdb;
		$cats = wp_get_post_categories( $post->ID );
		echo '<a class="breadcrumb-item" href="' . esc_attr( home_url() ) . '">' . esc_html__( 'Home', 'onenice' ) . '</a>';
		$cid = $cats[0];
		if ( $cid ) {
			$taxonomy = wp_cache_get( 'taxonomy_' . $cid, 'onenice_cache_group' );
			if ( false === $taxonomy ) {
				$taxonomy = $wpdb->get_var( $wpdb->prepare( "SELECT taxonomy FROM {$wpdb->term_taxonomy} WHERE term_id=%d", $cid ) );
				wp_cache_set( 'taxonomy_' . $cid, $taxonomy, 'onenice_cache_group' );
			}
			onenice_get_greadcrumb( $cid, $taxonomy );
		}
		echo '<span class="breadcrumb-item active">' . esc_html( $post->post_title ) . '</span>';
		return;
	} elseif ( is_archive() ) {
		global $wpdb;
		$cid      = get_queried_object_id();
		$taxonomy = wp_cache_get( 'taxonomy_' . $cid, 'onenice_cache_group' );
		if ( false === $taxonomy ) {
			$taxonomy = $wpdb->get_var( $wpdb->prepare( "SELECT taxonomy FROM {$wpdb->term_taxonomy} WHERE term_id=%d", $cid ) );
			wp_cache_set( 'taxonomy_' . $cid, $taxonomy, 'onenice_cache_group' );
		}
		echo '<a class="breadcrumb-item" href="' . esc_attr( home_url() ) . '">' . esc_html__( 'Home', 'onenice' ) . '</a>';
		onenice_get_greadcrumb( $cid, $taxonomy );
	}
}

/**
 * Login
 */
function onenice_login() {
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
			<span><?php echo esc_html( $user->display_name ); ?></span>
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
		?>
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
function onenice_register_sidebars() {
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

add_action( 'widgets_init', 'onenice_register_sidebars' );

/**
 * Ignore sticky posts
 *
 * @param object $query query object.
 */
function onenice_exclude_sticky_posts( $query ) {
	if ( $query->is_home() && $query->is_main_query() ) {
		$query->set( 'ignore_sticky_posts', 1 );
	}
}
add_action( 'pre_get_posts', 'onenice_exclude_sticky_posts' );

/**
 * Clean excerpt html
 *
 * @param string $str   query object.
 * @return string       Return to the overworry excerpt.
 */
function onenice_excerpt( $str ) {
	return wp_strip_all_tags( $str );
}
add_filter( 'the_excerpt', 'onenice_excerpt' );

/**
 * Change excerpt length
 *
 * @param int $length   Excerpt length.
 * @return string       Returns the modified excerpt length.
 */
function onenice_excerpt_length( $length ) {
	return onenice_get( 'excerpt_length' );
}
add_filter( 'excerpt_length', 'onenice_excerpt_length' );

/**
 * Change the content at the end of the excerpt
 *
 * @param string $more   Later original content.
 * @return string       Returns the modified content at the end of the excerpt.
 */
function onenice_excerpt_more( $more ) {
	return ' ...';
}
add_filter( 'excerpt_more', 'onenice_excerpt_more' );

/**
 * Set the default thumbnail url
 *
 * @param string $thumbnail_url   Original thumbnail url.
 * @return string       Returns the modified thumbnail url.
 */
function onenice_post_thumbnail_url( $thumbnail_url ) {
	if ( ! $thumbnail_url ) {
		return onenice_get( 'site_thumbnail' );
	}
	return $thumbnail_url;
}
add_filter( 'post_thumbnail_url', 'onenice_post_thumbnail_url', 99999999, 1 );

/**
 * Set the number of tag clouds and sort by count
 *
 * @param array $args   Tag cloud args.
 * @return string       Returns the modified tag cloud args.
 */
function onenice_tag_cloud_args( $args ) {
	$newargs = array(
		'orderby' => 'count',
		'order'   => 'DESC',
		'number'  => 30,
	);

	return array_merge( $args, $newargs );
}
add_filter( 'widget_tag_cloud_args', 'onenice_tag_cloud_args' );


if ( ! is_admin() ) {
	/**
	 * Load script and style
	 */
	function onenice_load_scripts() {
		$cdn_url = onenice_get( 'static_lib_cdn' );

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

		wp_enqueue_style( 'style', STATIC_URL . '/css/style6.css', array(), THEME_VER );
		wp_enqueue_script( 'lazyload', STATIC_URL . '/libs/lazyload/lazyload.min.js', array(), '2.0.0', true );

		if ( is_single() ) {

			if ( onenice_get( 'single_enable_highlight' ) ) {
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

			if ( onenice_get( 'single_show_share', true ) ) {
				if ( $cdn_url ) {
					wp_enqueue_style( 'share', $cdn_url . '/social-share.js/1.0.16/css/share.min.css', array(), '1.0.16' );
					wp_enqueue_script( 'share', $cdn_url . '/social-share.js/1.0.16/js/jquery.share.min.js', array(), '1.0.16', true );
				} else {
					wp_enqueue_style( 'share', STATIC_URL . '/libs/share/css/share.min.css', array(), '1.0.16' );
					wp_enqueue_script( 'share', STATIC_URL . '/libs/share/js/jquery.share.min.js', array(), '1.0.16', true );
				}
			}
		}

	}

	add_action( 'wp_enqueue_scripts', 'onenice_load_scripts' );

	/**
	 * Add style
	 */
	function onenice_head() {
		// set theme color.
		$colors             = explode( ' ', onenice_get( 'theme_color' ) );
		list($a1, $a2, $a3) = $colors;
		$styles             = array(
			'a:hover'                          => "{color:$a1;}",
			'.breadcrumb a:hover'              => "{color:$a1;}",
			'.comment-form .submit,.btn-custom,.badge-custom' => "{color:#fff!important;background-color:$a1;border-color:$a1;}",
			'.comment-form .submit:hover,.btn-custom:hover,.badge-custom:hover' => "{color:#fff;background-color:$a2;border-color:$a2}",
			'.form-control:focus'              => "{border-color: $a3!important;}",

			'.navbar-nav .current-menu-item a' => "{color:$a1}",
			'.fa-search:hover'                 => "{color:$a1;}",
			'.post-content a'                  => "{color:$a1;}",
			'.post-content a:hover'            => "{color:$a2;}",
			'.rollbar .rollbar-item:hover'     => "{background-color: $a3;}",
		);
		// #set theme color.

		// set page width.
		$styles['.container, .container-lg, .container-md, .container-sm, .container-xl'] = '{max-width: ' . onenice_get( 'page_width' ) . ';}';
		// #set page width.

		echo '<style>';
		foreach ( $styles as $key => $style ) {
			echo esc_html( $key . $style );
		}
		echo '</style>';

		if ( onenice_get( 'single_enable_highlight' ) ) {
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

	add_action( 'wp_head', 'onenice_head' );

	add_action(
		'wp_footer',
		function() {
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

			$(".scroll-top").on("click",function(){
				$("body,html").animate({"scrollTop":0},500);
			});
		});

		function onenice_check_search(){

			if(jQuery("#wd").val() == ""){
				return false;
			}
			return true;
		}
		</script>
			<?php

			if ( is_single() ) {
				if ( onenice_get( 'single_enable_highlight' ) ) {
					?>
					<script>hljs.initHighlightingOnLoad();hljs.initLineNumbersOnLoad();</script>
					<?php
				}
			}
			echo '<div class="rollbar md-down-none">';
			if ( onenice_get( 'enable_back_to_top' ) ) {
				?>
				<div class="rollbar-item scroll-top" title="<?php esc_attr_e( 'Back to top', 'onenice' ); ?>"><i class="fa fa-angle-up"></i></div>
				<?php

			}
			echo '</div>';

		},
		99
	);
}
