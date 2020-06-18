<?php

namespace app\web\action;

class AdminAction extends GlobalAction
{
	public function __construct()
	{
		parent::__construct();
		// Add HTML editor custom shortcut TAB buttons
        add_action('after_wp_tiny_mce', [$this, 'mceButtons']);
        register_nav_menus(['top-menu'=> _t( 'Top menu')]);
        take('enable_phrase') && add_action('init', [$this, 'phrase']);
        
	}
	
	public function mceButtons($settings)
	{
        ?>
        <script type="text/javascript">
        QTags.addButton( 'h4', 'h4', "<h4>", "</h4>" );
        QTags.addButton( 'p', 'p', "<p>", "</p>" );
        QTags.addButton( 'pre-code', 'pre-code', "<pre><code>", "</code></pre>" );
        </script>
        <?php
    }
    
    public function phrase()
    {
    	$labels = [
        	'name' => _t('Phrase'),
        	'singular_name' => _t('Phrase'), 
        	'all_items' => _t('All Phrases'),
        	'add_new' => _t('Add New'), 
        	'add_new_item' => _t('Add New Phrase'),
        	'edit_item' => _t('Edit Phrase'), 
        	'new_item' => _t('New Phrase'), 
        	'view_item' => _t('View Phrase'), 
        	'search_items' => _t('Search Phrases'), 
        	'not_found' => _t('No phrases found'), 
        	'not_found_in_trash' => _t('No phrases found in trash'), 
        	'parent_item_colon' => '',
        	'menu_name' => _t('Phrase')
    	]; 
    	$args = [
        	'labels' => $labels, 
        	'public' => true, 
        	'publicly_queryable' => true, 
        	'show_ui' => true, 
        	'show_in_menu' => true, 
        	'query_var' => true, 
        	'rewrite' => true, 
        	'capability_type' => 'post', 
        	'has_archive' => true, 
        	'hierarchical' => false, 
        	'menu_position' => 5, 
        	'menu_icon' => 'dashicons-format-chat',
        	'supports' => ['title','editor','author']
    	]; 
    	register_post_type('phrase',$args); 
    }
}