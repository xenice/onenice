<?php
return [
    [
        'id'=>'global',
        'name'=>_t('Global'),
        'title'=>_t('Global Settings'),
        'fields'=>[
            [
                'id'   => 'color',
                'name' => _t('Theme Color'),
                'type'  => 'radio',
                'value'=>'#0099FF #0099FF #0099FF #007bff #fff #99CCFF',
                'opts' =>[
                    '#0099FF #0099FF #0099FF #007bff #fff #99CCFF'  => _t('Blue'),
                    '#000 #666 #f9f9f9 #eee #666 #aaa' => _t('Grey'),
                    '#FF5E52 #FF5E52 #FF5E52 #f13c2f #fff #fc938b'  => _t('Red'),
                ]
                
            ],
            [
                'id'   => 'display_style',
                'name' => _t('Display Style'),
                'type'  => 'radio',
                'value'=>'thumbnail',
                'opts' =>[
                    'text'  => _t('Pure Text'),
                    'thumbnail' => _t('Show Thumbnail'),
                    
                ]
                
            ],
            [
                'name' => _t('Auxiliary'),
                'fields'=>[
                    [
                        'id'   => 'enable_cdn',
                        'type'  => 'checkbox',
                        'value' => true,
                        'label'  => _t('Enable static file CDN acceleration')
                    ],
                    [
                        'id'   => 'enable_category_badge',
                        'type'  => 'checkbox',
                        'value' => false,
                        'label'  => _t('Enbale category badge on the list page')
                    ],
                    [
                        'id'   => 'enable_article_seo',
                        'type'  => 'checkbox',
                        'value' => false,
                        'label'  => _t('Enable article seo')
                    ],
                    [
                        'id'   => 'enable_phrase',
                        'type'  => 'checkbox',
                        'value' => false,
                        'label'  => _t('Enable the phrase')
                    ]
                ]
            ],
            [
                'id'   => 'Baidu_statistics',
                'name' => _t('Baidu Statistics'),
                'desc' => _t('Fill in baidu statistics script'),
                'type'  => 'textarea',
                'style' => 'regular',
                'value' => '',
                'rows' => 6
                
            ],
            [
                'id'   => 'baidu_auto_push',
                'name' => _t('Baidu Auto Push'),
                'desc' => _t('Fill in baidu auto push script'),
                'type'  => 'textarea',
                'style' => 'regular',
                'value' => '',
                'rows' => 6
                
            ]
        ]
    ],
    [
        'id'=>'home',
        'name'=>_t('Home'),
        'title'=>_t('Home Settings'),
        'fields'=>[
            [
                'id'   => 'description',
                'name' => _t('Description'),
                'type'  => 'textarea',
                'style' => 'regular',
                'value' => '',
                'rows' => 3
                
            ],
            [
                'id'   => 'keywords',
                'name' => _t('Keywords'),
                'type'  => 'textarea',
                'style' => 'regular',
                'value' => '',
                'rows' => 3
            ],
            [
                'id'   => 'enable_slide',
                'name' => _t('Slide'),
                'desc' => _t('Please set slide images below if Enable slide, Images recommended size is 715px*350px.'),
                'type'  => 'checkbox',
                'value' => true,
                'label'  => _t('Enable Slide')
            ],
            [
                'id'   => 'slide_image_1',
                'name' => _t('Slide Image 1'),
                'type'  => 'image',
                'value' => [
                    'url'  =>'http://www.xenice.com/',
                    'title'=>'xenice',
                    'path' =>'https://www-xenice-com-1255371979.cos.ap-hongkong.myqcloud.com/project/images/2020/04/onenice_slide_1.jpg'
                ]
            ],
            [
                'id'   => 'slide_image_2',
                'name' => _t('Slide Image 2'),
                'type'  => 'image',
                'value' => [
                    'url'  =>'http://www.xenice.com/',
                    'title'=>'xenice',
                    'path' =>'https://www-xenice-com-1255371979.cos.ap-hongkong.myqcloud.com/project/images/2020/04/onenice_slide_2.jpg'
                ]
            ],
            [
                'id'   => 'slide_image_3',
                'name' => _t('Slide Image 3'),
                'type'  => 'image',
                'value' => [
                    'url'  =>'http://www.xenice.com/',
                    'title'=>'xenice',
                    'path' =>'https://www-xenice-com-1255371979.cos.ap-hongkong.myqcloud.com/project/images/2020/04/onenice_slide_3.jpg'
                ]
            ]
        ]
    ],
    [
        'id'=>'advertise',
        'name'=>_t('Advertise'),
        'title'=>_t('Advertise Settings'),
        'fields'=>[
            [
                'name' => _t('Single page top AD'),
                'fields'=>[
                    [
                        'id'   => 'enable_single_top_ad',
                        'type'  => 'checkbox',
                        'label' => _t('Enable'),
                        'value' => false,
                    ],
                    [
                        'id'   => 'single_top_ad_code',
                        'type'  => 'textarea',
                        'label' => _t('PC AD code'),
                        'style' => 'regular',
                        'value' => '',
                        'rows' => 6
                    ],
                    [
                        'id'   => 'single_top_ad_code_m',
                        'type'  => 'textarea',
                        'label' => _t('Mobile AD code'),
                        'style' => 'regular',
                        'value' => '',
                        'rows' => 6
                    ]
                ]
                
            ],
            [
                'name' => _t('Single page bottom AD'),
                'fields'=>[
                    [
                        'id'   => 'enable_single_bottom_ad',
                        'type'  => 'checkbox',
                        'label' => _t('Enable'),
                        'value' => false,
                    ],
                    [
                        'id'   => 'single_bottom_ad_code',
                        'type'  => 'textarea',
                        'label' => _t('PC AD code'),
                        'style' => 'regular',
                        'value' => '',
                        'rows' => 6
                    ],
                    [
                        'id'   => 'single_bottom_ad_code_m',
                        'type'  => 'textarea',
                        'label' => _t('Mobile AD code'),
                        'style' => 'regular',
                        'value' => '',
                        'rows' => 6
                    ]
                ]
                
            ],
            [
                'name' => _t('List page top AD'),
                'fields'=>[
                    [
                        'id'   => 'enable_list_top_ad',
                        'type'  => 'checkbox',
                        'label' => _t('Enable'),
                        'value' => false,
                    ],
                    [
                        'id'   => 'list_top_ad_code',
                        'type'  => 'textarea',
                        'label' => _t('PC AD code'),
                        'style' => 'regular',
                        'value' => '',
                        'rows' => 6
                    ],
                    [
                        'id'   => 'list_top_ad_code_m',
                        'type'  => 'textarea',
                        'label' => _t('Mobile AD code'),
                        'style' => 'regular',
                        'value' => '',
                        'rows' => 6
                    ]
                ]
                
            ],
            [
                'name' => _t('List page bottom AD'),
                'fields'=>[
                    [
                        'id'   => 'enable_list_bottom_ad',
                        'type'  => 'checkbox',
                        'label' => _t('Enable'),
                        'value' => false,
                    ],
                    [
                        'id'   => 'list_bottom_ad_code',
                        'type'  => 'textarea',
                        'label' => _t('PC AD code'),
                        'style' => 'regular',
                        'value' => '',
                        'rows' => 6
                    ],
                    [
                        'id'   => 'list_bottom_ad_code_m',
                        'type'  => 'textarea',
                        'label' => _t('Mobile AD code'),
                        'style' => 'regular',
                        'value' => '',
                        'rows' => 6
                    ]
                ]
            ]
        ]
    ]
];