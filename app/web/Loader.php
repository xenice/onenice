<?php
namespace app\web;

use xenice\theme\Route;
use xenice\option\Option;
use xenice\optimize\Optimize;
use xenice\mail\Mail;
use app\web\widget\Widget;
use app\web\action\SeoAction;
use app\web\action\AdminAction;
use app\web\action\GuestAction;
use app\web\ajax\Ajax;
use app\web\about\About;

class Loader extends \xenice\theme\Loader
{
	public function __construct()
	{
	    isset($_SESSION) || session_start();
	    load_theme_textdomain(THEME_NAME, THEME_DIR . '/lang');

	    parent::__construct();
		Widget::instance();
		Optimize::instance();
		Mail::instance();
		About::instance();
		Ajax::instance();
		if(is_admin()){
			Option::instance();
			take('enable_article_seo') && SeoAction::instance();
			AdminAction::instance();
			
		}
		else{
			GuestAction::instance();
			Route::instance();
		}
	}

}