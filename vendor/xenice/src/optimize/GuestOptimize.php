<?php
/**
 * @name        xenice guest optimize
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-10-02
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\optimize;

class GuestOptimize
{
    public function __construct()
    {
        // wordpress
        take('disable_admin_bar') && add_filter('show_admin_bar', '__return_false');
        take('disable_head_links') && $this->disableHeadLinks();

    }
    
    private function disableHeadLinks()
	{
		remove_action( 'wp_head', 'wp_generator');          //删除 head 中的 WP 版本号
		foreach (['rss2_head', 'commentsrss2_head', 'rss_head', 'rdf_header', 'atom_head', 'comments_atom_head', 'opml_head', 'app_head'] as $action) {
			remove_action( $action, 'the_generator' );
		}

		remove_action( 'wp_head', 'rsd_link' );           //删除 head 中的 RSD LINK
		remove_action( 'wp_head', 'wlwmanifest_link' );       //删除 head 中的 Windows Live Writer 的适配器？ 

		remove_action( 'wp_head', 'feed_links_extra', 3 );        //删除 head 中的 Feed 相关的link
		//remove_action( 'wp_head', 'feed_links', 2 );  

		remove_action( 'wp_head', 'index_rel_link' );       //删除 head 中首页，上级，开始，相连的日志链接
		remove_action( 'wp_head', 'parent_post_rel_link', 10); 
		remove_action( 'wp_head', 'start_post_rel_link', 10); 
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10);

		remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );  //删除 head 中的 shortlink
		remove_action( 'wp_head', 'rest_output_link_wp_head', 10);  // 删除头部输出 WP RSET API 地址

		remove_action( 'template_redirect', 'wp_shortlink_header', 11);   //禁止短链接 Header 标签。  
		remove_action( 'template_redirect', 'rest_output_link_header', 11); // 禁止输出 Header Link 标签。
		
		
	}
	

    
}