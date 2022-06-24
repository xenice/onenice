<?php
namespace app\pro;

use xenice\theme\Theme;

class Loader extends \app\web\Loader
{
	public function __construct()
	{
	    Theme::set('default_theme', 'web');
	    
        $aliases = [
            'article' => 'app\pro\model\Article',
            'article_pointer' => 'app\pro\model\pointer\Article',
            'template' => 'app\pro\template\Template',
        ];
        
        $prepares = [
            11 => 'xenice\login\Login',
            60 => 'app\pro\ajax\Ajax',
        ];
        
        if(is_admin()){
            //Theme::bind('xenice_options_init', [$this,'set']);
            $prepares[90] = 'app\pro\module\inner\Admin';
        }
        else{
            $prepares[100] = 'app\pro\module\inner\Guest';
        }
        
        $args = [
            'aliases' => $aliases,
            'prepares' => $prepares,
        ];
        
        parent::__construct($args);
	}
	
	/*
	public function set($options)
    {
        
        $options = parent::set($options);
        $options[0]['fields'][0]['value'] = '#FF5E52 #FF5E52 #FF5E52 #f13c2f #fff #fc938b';
        $options[0]['fields'][2]['value'] = STATIC_URL_EX . '/images/logo.png';
        $options[1]['fields'][3]['value'][0]['src'] = STATIC_URL_EX . '/images/onenice-1.jpg';
        $options[1]['fields'][3]['value'][1]['src'] = STATIC_URL_EX . '/images/onenice-2.jpg';
        $options[1]['fields'][3]['value'][2]['src'] = STATIC_URL_EX . '/images/onenice-3.jpg';
        
        return array_merge($options, require(__DIR__ . '/options.php'));
    }*/
}