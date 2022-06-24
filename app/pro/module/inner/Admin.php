<?php

namespace app\pro\module\inner;

class Admin extends \app\web\module\inner\Admin
{
    public function __construct()
	{
	    parent::__construct();
	    //add_action('media_buttons', [$this, 'addButtons'], 15);
	    //add_action('wp_enqueue_media', [$this, 'mediaJs']);
	    
	}

    /*
    public function addButtons()
	{
        echo '<a href="#" id="add-resource" class="button">'._t('Add Resource').'</a>';
	}
	
	public function mediaJs()
	{
	    wp_enqueue_script('media-js', STATIC_URL_EX . '/js/media.js', ['jquery'], '1.2', true);
	    wp_localize_script( 'media-js', 'default_shotcode', take('default_shotcode'));
	}*/
	
}