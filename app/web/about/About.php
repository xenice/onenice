<?php
namespace app\web\about;

use xenice\theme\Base;
use xenice\theme\Theme;

class About extends Base
{
	public function __construct()
	{
	    if(is_admin()){
            Theme::bind('xenice_options_init', [$this,'set']);
            Theme::bind('xenice_options_button', [$this,'hideButton']);
        }
	}
	
	public function set($options)
    {
        $defaults   = [];
        $defaults[] = [
            'id'=>'about',
            'name'=> _t('About'),
            'title'=> _t('About the theme'),
            'desc'=> sprintf(_t('Thank you for using <a href="http://www.xenice.com/" target="_blank">%s</a> theme.'),THEME_NAME),
            'fields'=>[
                [
                    'id' => 'about_version',
                    'type'  => 'label',
                    'name'  => _t('Version'),
                    'value' => THEME_VER,
                ],
                [
                    'id' => 'about_official_website',
                    'type'  => 'label',
                    'name'  => _t('Official website'),
                    'value' => '<a href="http://www.xenice.com/" target="_blank">http://www.xenice.com/</a>',
                ],
            ]
        ];
        return array_merge($options, $defaults);
    }
    
    public function hideButton($buttons, $id)
    {
        return ($id == 'about')?'':$buttons;
    }
}