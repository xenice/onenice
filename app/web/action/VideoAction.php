<?php

namespace app\web\action;

use censky\wp\Action;

class VideoAction extends Action
{
	public function __construct()
	{
		add_action('add_meta_boxes', [$this, 'createMetaBox']);
		add_action('save_post', [$this,'saveMeta']);
		
	}
	
	public function createMetaBox()
	{
		add_meta_box( 'video-meta-box', '视频链接', [$this, 'metaForm'], 'post', 'advanced', 'high' );
	}
	
	public function metaForm()
	{
		global $post;
		$meta_box = [
			"name" => "header_video_id",
			"std" => "",
			"type" => "text",
			"title" => "视频链接(支持各大视频网站链接解析)"
			];
		$meta_box_value = get_post_meta($post->ID, $meta_box['name'], true);
		echo '<input style="width:100%" type="text" value="'.$meta_box_value.'" name="'.$meta_box['name'].'">';	
		echo $meta_box['title'];
		echo '<input type="hidden" name="post_video_meta_noncename" id="post_video_meta_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
	}



	function saveMeta( $post_id )
	{
		global $postmeta_from;
	   
		if ( !wp_verify_nonce( $_POST['post_video_meta_noncename'], plugin_basename(__FILE__) ))
			return;
	   
		if ( !current_user_can( 'edit_posts', $post_id ))
			return;
		
		$meta_box = [
			"name" => "header_video_id",
			"std" => "",
			"type" => "text",
			"title" => "视频链接(支持各大视频网站链接解析)"
		];               
		$data = $_POST[$meta_box['name']];
		if(get_post_meta($post_id, $meta_box['name']) == "")
			add_post_meta($post_id, $meta_box['name'], $data, true);
		elseif($data != get_post_meta($post_id, $meta_box['name'], true))
			update_post_meta($post_id, $meta_box['name'], $data);
		elseif($data == "")
			delete_post_meta($post_id, $meta_box['name'], get_post_meta($post_id, $meta_box['name'], true));

	}
}