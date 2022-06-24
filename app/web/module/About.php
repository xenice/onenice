<?php
namespace app\web\module;

use xenice\theme\Base;
use xenice\theme\Theme;

class About
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
            'pos'=>1000,
            'name'=> _t('About'),
            'title'=> _t('About the theme'),
            'desc'=> sprintf(_t('感谢使用 <a href="%s" target="_blank">%s</a> 主题。'), THEME_URI, THEME_NAME),
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
                    'value' => sprintf('<a href="%s" target="_blank">%s</a>', THEME_URI, THEME_URI),
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