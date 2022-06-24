<?php
/**
 * @name        xenice admin optimize
 * @description Admin optimize
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-10-02
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\optimize;

use xenice\theme\Theme;

class AdminOptimize
{
    public function __construct()
    {
        //Hide the Upgrade Notice to Recent Versions
        take('disable_update_remind') && add_filter( 'pre_site_transient_update_core', create_function( '$a', "return null;" ) );
		take('disable_auto_save') && add_action('wp_print_scripts', [$this, 'disableAutoSave']);
		take('disable_post_revision') && remove_action('post_updated','wp_save_post_revision' );
		take('enable_empty_email_save') && add_action('user_profile_update_errors',[$this,'enableEmptyEmailSave'],10,3);
		take('remove_w_icon') && add_action('wp_before_admin_bar_render',[$this,'removeWIcon']);
		take('enable_link') && add_filter( 'pre_option_link_manager_enabled', '__return_true' );
		take('enable_code_escape') && add_filter( 'content_save_pre', [$this, 'replaceCodeTags'], 9 );
		take('external_link_to_local') && new LinksToLocal;
		if(take('remove_image_attribute')){
    		add_filter( 'post_thumbnail_html', [$this, 'removeImageAttribute'], 10 );
            add_filter( 'image_send_to_editor', [$this, 'removeImageAttribute'], 10 );
            //add_filter( 'content_save_pre', [$this, 'removeImageAttribute'], 10 );
		}
    }
    
    public function disableAutoSave()
    {
        wp_deregister_script('autosave'); 
    }

	public function enableEmptyEmailSave($errors, $update, $user)
	{
	    if(isset($errors->errors['empty_email'])){
            unset($errors->errors['empty_email']);
            unset($errors->errors['empty_data']);
        }
	    
	}
	
	public function removeWIcon()
	{
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('wp-logo');
    }

    public function escapeCode($arr)
    {
    	$output = htmlspecialchars($arr[2], ENT_NOQUOTES, get_bloginfo('charset'), false); 
    	if (! empty($output)) {
    		return  $arr[1] . $output . $arr[3];
    	}
    	else
    	{
    		return  $arr[1] . $arr[2] . $arr[3];
    	}
    	
    }
    
    public function replaceCodeTags($data)
    {
    	$data = preg_replace_callback('@(<code.*>)(.*)(</code>)@isU', [$this,'escapeCode'], $data);
    	return $data;
    }
    
    public function removeImageAttribute( $html ) {
    	//$html = preg_replace( '/width="(\d*)"\s+height="(\d*)"\s+class=\"[^\"]*\"/', "", $html );
    	//$html = preg_replace( '/  /', "", $html );
    	$html = preg_replace('/<img.+(src="?[^"]+"?)[^\/]+\/>/i',"<img \${1} />",$html);
    	return $html;
    }
    
}