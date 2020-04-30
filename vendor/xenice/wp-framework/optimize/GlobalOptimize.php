<?php
/**
 * @name        xenice global optimize
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-10-02
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\optimize;

use xenice\theme\Theme;

class GlobalOptimize
{
    public function __construct()
    {
        // wordpress
        take('disable_pingback') && $this->disablePingback();
        take('disable_emoji') && $this->disableEmoji();
        take('disable_rest_api') && $this->disableRestApi();
        take('disable_embeds') && $this->disableEmbeds();
        take('disable_open_sans') && add_action( 'init', [$this, 'disableOpenSans']);
        take('disable_widgets') && add_action('widgets_init', [$this, 'disableWidgets']);
        
        // xenice
        take('enable_ssl_avatar') && add_filter('get_avatar', [$this,'getAvatar']);
        take('remove_category_pre') && new NoCategory;
        take('remove_child_categories') && add_filter( 'post_link_category', [$this,'removeChildCategories']);
        take('enable_user_register_login_info') && new UserTableOptimize;
    }
    
    /**
	 * disable Pingback
	 */
	private function disablePingback()
	{
		//彻底关闭 pingback
		add_filter('xmlrpc_methods',function($methods){
			$methods['pingback.ping'] = '__return_false';
			$methods['pingback.extensions.getPingbacks'] = '__return_false';
			return $methods;
		});

		//禁用 pingbacks, enclosures, trackbacks 
		remove_action( 'do_pings', 'do_all_pings', 10 );

		//去掉 _encloseme 和 do_ping 操作。
		remove_action( 'publish_post','_publish_post_hook',5 );
	}
	
	private function disableEmoji()
	{
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script');
		remove_action( 'admin_print_styles',  'print_emoji_styles');

		remove_action( 'wp_head',       'print_emoji_detection_script', 7);
		remove_action( 'wp_print_styles',   'print_emoji_styles');

		remove_action('embed_head',       'print_emoji_detection_script');

		remove_filter( 'the_content_feed',    'wp_staticize_emoji');
		remove_filter( 'comment_text_rss',    'wp_staticize_emoji');
		remove_filter( 'wp_mail',       'wp_staticize_emoji_for_email');

		add_filter( 'tiny_mce_plugins', function ($plugins){ return array_diff( $plugins, array('wpemoji') ); });

		add_filter( 'emoji_svg_url', '__return_false' );

	}
	
	private function disableRestApi()
	{
		remove_action( 'init',          'rest_api_init' );
		remove_action( 'rest_api_init', 'rest_api_default_filters', 10 );
		remove_action( 'parse_request', 'rest_api_loaded' );

		add_filter('rest_enabled', '__return_false');
		add_filter('rest_jsonp_enabled', '__return_false');

		// 移除头部 wp-json 标签和 HTTP header 中的 link 
		remove_action('wp_head', 'rest_output_link_wp_head', 10 );
		remove_action('template_redirect', 'rest_output_link_header', 11 );


		remove_action( 'xmlrpc_rsd_apis',            'rest_output_rsd' );

		remove_action( 'auth_cookie_malformed',      'rest_cookie_collect_status' );
		remove_action( 'auth_cookie_expired',        'rest_cookie_collect_status' );
		remove_action( 'auth_cookie_bad_username',   'rest_cookie_collect_status' );
		remove_action( 'auth_cookie_bad_hash',       'rest_cookie_collect_status' );
		remove_action( 'auth_cookie_valid',          'rest_cookie_collect_status' );
		remove_filter( 'rest_authentication_errors', 'rest_cookie_check_errors', 100 );
	}
	
	private function disableEmbeds()
	{
		$disable_embeds_rewrites = function($rules){
			foreach ($rules as $rule => $rewrite) {
				if (false !== strpos($rewrite, 'embed=true')) {
					unset($rules[$rule]);
				}
			}
			return $rules;
		};
		
		add_action('init', function ()use($disable_embeds_rewrites){
			global $wp;
			$wp->public_query_vars = array_diff($wp->public_query_vars, array('embed'));
			remove_action('rest_api_init', 'wp_oembed_register_route');
			add_filter('embed_oembed_discover', '__return_false');
			remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
			remove_action('wp_head', 'wp_oembed_add_discovery_links');
			remove_action('wp_head', 'wp_oembed_add_host_js');
			add_filter('tiny_mce_plugins', function ($plugins){
				return array_diff($plugins, array('wpembed'));
			});
			add_filter('rewrite_rules_array', $disable_embeds_rewrites);
		}, 9999);

		register_activation_hook(__FILE__, function()use($disable_embeds_rewrites){
			add_filter('rewrite_rules_array', $disable_embeds_rewrites);
			flush_rewrite_rules();
		});

		
		register_deactivation_hook(__FILE__, function()use($disable_embeds_rewrites){
			remove_filter('rewrite_rules_array', $disable_embeds_rewrites);
			flush_rewrite_rules();
		});
	}
	
	public function disableOpenSans() {
		wp_deregister_style( 'open-sans' );
		wp_register_style( 'open-sans', false );
		wp_enqueue_style('open-sans', '');
	}
	
	// 替换Gavatar头像地址
    public function getAvatar($avatar) {
        if (preg_match_all(
            '/(src|srcset)=["\']https?.*?\/avatar\/([^?]*)\?s=([\d]+)&([^"\']*)?["\']/i',
            $avatar,
            $matches
        ) > 0) {
            $url = 'https://secure.gravatar.com';
            $size = $matches[3][0];
            $vargs = array_pad(array(), count($matches[0]), array());
            for ($i = 1; $i < count($matches); $i++) {
                for ($j = 0; $j < count($matches[$i]); $j++) {
                    $tmp = strtolower($matches[$i][$j]);
                    $vargs[$j][] = $tmp;
                    if ($tmp == 'src') {
                        $size = $matches[3][$j];
                    }
                }
            }
            $buffers = array();
            foreach ($vargs as $varg) {
                $buffers[] = vsprintf(
                '%s="%s/avatar/%s?s=%s&%s"',
                array($varg[0], $url, $varg[1], $varg[2], $varg[3])
               );
            }
            return sprintf(
                    '<img alt="avatar" %s class="avatar avatar-%s" height="%s" width="%s" />',
                    implode(' ', $buffers), $size, $size, $size
                );
        } else {
            return false;
        }
    }
	
	public function disableWidgets()
	{
		unregister_widget ('WP_Widget_Search');
		unregister_widget ('WP_Nav_Menu_Widget');
		unregister_widget ( 'WP_Widget_Calendar' );
		unregister_widget ( 'WP_Widget_Pages' );
		unregister_widget ( 'WP_Widget_Archives' );
		unregister_widget ( 'WP_Widget_Links' );
		unregister_widget ( 'WP_Widget_Meta' );
		unregister_widget ( 'WP_Widget_Text' );
		unregister_widget ( 'WP_Widget_Categories' );
		unregister_widget ( 'WP_Widget_Recent_Posts' );
		unregister_widget ( 'WP_Widget_Recent_Comments' );
		unregister_widget ( 'WP_Widget_RSS' );
		unregister_widget ( 'WP_Widget_Tag_Cloud' );
		unregister_widget ( 'WP_Widget_Media_Audio' );
		unregister_widget ( 'WP_Widget_Media_Video' );
		unregister_widget ( 'WP_Widget_Media_Image' );
		unregister_widget ( 'WP_Widget_Media_Gallery' );
		unregister_widget ( 'WP_Widget_Custom_HTML' );
	}

    public function removeChildCategories( $category )
    {
		while ( $category->parent ) {
			$category = get_term( $category->parent, 'category' );
		}
		return $category;
	}
}