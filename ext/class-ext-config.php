<?php

class YYThemes_Ext_Config extends vessel\Options
{
    protected $key = 'yy_ext';
    protected $name = ''; // Database option name
    protected $defaults = [];
    
    public function __construct()
    {
        $tabs = [];
        $this->name = 'xenice_' . $this->key;
        $this->defaults[] = [
            'id'=>'ext',
            'name'=> __('Extension','onenice'),
            'submit'=>__('Save changes','onenice'),
            'title'=> __('Extension', 'onenice'),
            'tabs' => [
                [
                    'id' => 'optimize',
                    'title' => __('Optimize', 'onenice'),
                    'fields'=>apply_filters('yythemes_ext_optimize_fields', [])
                ],
                [
                    'id' => 'more',
                    'title' => __('More', 'onenice'),
                    'fields'=>apply_filters('yythemes_ext_more_fields', [])
                ],
            ]
        ];
	    parent::__construct();
    }

}