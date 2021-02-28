<?php

namespace app\web\module;

class Seo
{
	public function __construct()
	{
		add_action('add_meta_boxes', [$this, 'createMetaBox']);
		add_action('save_post', [$this,'saveMeta']);
		
	}
	
	public function createMetaBox()
	{
		add_meta_box( 'seo-meta-box', _t('SEO'), [$this, 'metaForm'], 'post', 'advanced', 'high' );
	}
	
	public function metaForm()
	{
		global $post;
		$title = ["name" => "title"];
		$desc = ["name" => "description"];
		$keywords = ["name" => "keywords"];
		$title['value'] = get_post_meta($post->ID, $title['name'], true);
		$desc['value'] = get_post_meta($post->ID, $desc['name'], true);
		$keywords['value'] = get_post_meta($post->ID, $keywords['name'], true);
		echo '<p>' . _t('Title') . '</p>';
		echo '<input style="width:100%" type="text" value="'.$title['value'].'" name="'.$title['name'].'">';
		echo '<p>' . _t('Describtion') . '</p>';
		echo '<input style="width:100%" type="text" value="'.$desc['value'].'" name="'.$desc['name'].'">';
		echo '<p>' . _t('Keywords') . '</p>';
		echo '<input style="width:100%" type="text" value="'.$keywords['value'].'" name="'.$keywords['name'].'">';
		echo '<input type="hidden" name="post_seo_meta_nonce" value="'.wp_create_nonce('update_post_seo_meta').'" />';
	}



	function saveMeta( $post_id )
	{
		global $postmeta_from;
	   
		if (empty($_POST['post_seo_meta_nonce']) || !wp_verify_nonce( $_POST['post_seo_meta_nonce'], 'update_post_seo_meta'))
			return;
	   
		if ( !current_user_can( 'edit_posts', $post_id ))
			return;
		if($_POST['title']){
		    update_post_meta($post_id, 'title', $_POST['title']);
		}
		else{
		    delete_post_meta($post_id, 'title');
		}
		if($_POST['description']){
		    update_post_meta($post_id, 'description', $_POST['description']);
		}
		else{
		    delete_post_meta($post_id, 'description');
		}
		if($_POST['keywords']){
		    update_post_meta($post_id, 'keywords', $_POST['keywords']);
		}
		else{
		    delete_post_meta($post_id, 'keywords');
		}

	}
}