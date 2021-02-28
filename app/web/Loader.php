<?php
namespace app\web;

use xenice\theme\Theme;

class Loader extends \xenice\theme\Loader
{
	public function __construct($args = [])
	{
	    Theme::alias([
            // model
            'user' => 'app\web\model\User',
            'article' => 'app\web\model\Article',
            'page' => 'app\web\model\Page',
            'category' => 'app\web\model\Category',
            'tag' => 'app\web\model\Tag',
            'comment' => 'app\web\model\Comment',
            
            // pointer
            'article_pointer' => 'app\web\model\pointer\Article',
            'page_pointer' => 'app\web\model\pointer\Page',
            'category_pointer' => 'app\web\model\pointer\Category',
            'comment_pointer' => 'app\web\model\pointer\Comment',
            'user_pointer' => 'app\web\model\pointer\User',
            
        ]);
        
        isset($args['aliases']) && Theme::alias($args['aliases']);
        
        parent::__construct();
        
        $prepares = [
           10 => 'app\web\widget\Widget',
           20 => 'xenice\optimize\Optimize',
           30 => 'xenice\mail\Mail',
           //40 => 'xenice\profession\Profession',
           50 => 'app\web\module\About',
           60 => 'app\web\ajax\Ajax',
        ];
        
        if(is_admin()){
            $prepares[70] = 'xenice\option\Option';
            take('enable_article_seo') && $prepares[80] = 'app\web\module\Seo';
            $prepares[90] = 'app\web\module\inner\Admin';
        }
        else{
            $prepares[100] = 'app\web\module\inner\Guest';
            $prepares[110] = 'xenice\theme\Route';
        }
        
        Theme::prepare($prepares);
        
        isset($args['prepares']) && Theme::prepare($args['prepares']);
        
        Theme::execute();
		
	}

}