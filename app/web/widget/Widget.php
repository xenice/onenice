<?php
namespace app\web\widget;

use xenice\theme\Base;

class Widget extends Base
{
	
	public function __construct()
	{
		add_action('widgets_init', [$this, 'register']);
	}
	
	public function register()
	{
	    register_widget( __namespace__ . '\UniversalArticles');
		register_widget( __namespace__ . '\HotArticles');
		register_widget( __namespace__ . '\RelatedArticles');
		register_widget( __namespace__ . '\RecentArticles');
		register_widget( __namespace__ . '\StickyArticles');
		register_widget( __namespace__ . '\RecentComments');
		register_widget( __namespace__ . '\TagsCloud');
		register_widget( __namespace__ . '\Links');
		register_widget( __namespace__ . '\Advertise');
		
	}
}