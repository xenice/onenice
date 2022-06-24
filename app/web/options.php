<?php
return [
    [
        'id'=>'general',
        'name'=>_t('常规'),
        'title'=>_t('常规设置'),
        'tabs' => [
            [
                'id'=>'global',
                'title'=>_t('Global'),
                'fields'=>[
                    [
                        'id'   => 'color',
                        'name' => _t('Theme Color'),
                        'type'  => 'radio',
                        'value'=>'#0099FF #0099FF #0099FF #007bff #fff #99CCFF',
                        'opts' =>[
                            '#0099FF #0099FF #0099FF #007bff #fff #99CCFF'  => _t('Blue'),
                            '#FF5E52 #FF5E52 #FF5E52 #f13c2f #fff #fc938b'  => _t('Red'),
                            '#1fae67 #1fae67 #1fae67 #229e60 #fff #35dc89'  => _t('Green'),
                            '#ff4979 #ff4979 #ff4979 #f2295e #fff #fb94af'  => _t('Pink'),
                            '#000 #666 #f9f9f9 #eee #666 #aaa' => _t('Grey'),
                        ]
                        
                    ],
                    [
                        'id'   => 'site_icon',
                        'name' => _t('Site Icon'),
                        'type'  => 'img',
                        'style' => 'regular',
                        'value' => STATIC_URL . '/images/icon.ico',
                    ],
                    [
                        'id'   => 'site_logo',
                        'name' => _t('Site Logo'),
                        'type'  => 'img',
                        'style' => 'regular',
                        'value' => STATIC_URL . '/images/logo.png',
                    ],
                    [
                        'id'   => 'default_thumbnail',
                        'name' => _t('Default Thumbnail'),
                        'type'  => 'img',
                        'style' => 'regular',
                        'value' => STATIC_URL . '/images/thumbnail.png',
                    ],
                    [
                        'id'   => 'default_loading_image',
                        'name' => _t('Default Loading Image'),
                        'type'  => 'img',
                        'style' => 'regular',
                        'value' => STATIC_URL . '/images/loading.png',
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
                        
                    ],
                    [
                        'id'   => 'site_footer',
                        'name' => _t('Site Footer'),
                        'desc' => _t('Customize the site footer'),
                        'type'  => 'textarea',
                        'style' => 'regular',
                        'value' => '',
                        'rows' => 6
                        
                    ],
                    [
                        'name' => _t('Bottom right button'),
                        'fields'=>[
                            [
                                'id'   => 'enable_scroll_top',
                                'type'  => 'checkbox',
                                'value' => false,
                                'label'  => _t('Enable back-to-top button')
                            ],
                            [
                                'id'   => 'service_qq',
                                'type'  => 'text',
                                'value' => '',
                                'label'  => _t('Service QQ')
                            ],
                        ]
                    ],
                    [
                        'name' => _t('Site ICP'),
                        'fields'=>[
                            [
                                'id'   => 'enable_site_icp',
                                'type'  => 'checkbox',
                                'value' => false,
                                'label'  => _t('显示备案号')
                            ],
                            [
                                'id'   => 'site_icp',
                                'type'  => 'text',
                                'label' => _('备案号'),
                                'value' => '',
                            ],
                        ]
                    ],
                    
                    [
                        'name' => 'CDN',
                        'fields'=>[
                            [
                                'id'   => 'enable_cdn',
                                'type'  => 'checkbox',
                                'value' => true,
                                'label'  => _t('Enable static file CDN acceleration')
                            ],
                            [
                                'id'   => 'cdn_url',
                                'type'  => 'select',
                                'label' => _t('CDN Repository'),
                                'value' => 'https://cdn.staticfile.org',
                                'opts' => [
                                    'https://cdn.staticfile.org'=>'staticfile',
                                    'https://cdn.bootcdn.net/ajax/libs'=>'bootcdn',
                                    'https://libs.cdnjs.net'=>'cdnjs',
                                ]
                            ],
                        ]
                    ],
                    [
                        'name' => _t('Auxiliary'),
                        'fields'=>[
                            [
                                'id'   => 'first_image_thumbnail',
                                'type'  => 'checkbox',
                                'value' => true,
                                'label'  => _t('The first picture of the article is used as a thumbnail when no thumbnail is set')
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
                                'id'   => 'enable_highlight',
                                'type'  => 'checkbox',
                                'value' => true,
                                'label'  => _t('Enable code highlight')
                            ],
                        ]
                    ],
                ]
            ],
            [
                'id'=>'home',
                'title'=>_t('Home'),
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
                        'name' => _t('Slide'),
                        'desc' => _t('Please set slide images below if Enable slide, Images recommended size is 715px*350px.'),
                        'fields'=>[
                            [
                                'id'   => 'enable_slide',
                                'type'  => 'checkbox',
                                'value' => true,
                                'label'  => _t('Enable Slide')
                            ],
                            [
                                'id'   => 'display_slide_info',
                                'type'  => 'checkbox',
                                'value' => true,
                                'label'  => _t('Display the title and description of the slide')
                            ]
                        ]
                        
                    ],
                    [
                        'id'   => 'slide_images',
                        'name' => _t('Slide Images'),
                        'type'  => 'slide',
                        'value' => [
                            [
                                'url'=>'https://www.xenice.com/',
                                'src'=>STATIC_URL . '/images/onenice_slide_1.jpg',
                                'title'=>'xenice',
                                'desc'=>''
                            ],
                            [
                                'url'=>'https://www.xenice.com/',
                                'src'=>STATIC_URL . '/images/onenice_slide_2.jpg',
                                'title'=>'xenice',
                                'desc'=>''
                            ],
                            [
                                'url'=>'https://www.xenice.com/',
                                'src'=>STATIC_URL . '/images/onenice_slide_3.jpg',
                                'title'=>'xenice',
                                'desc'=>''
                            ],
                        ],
                    ],
                ]
            ],// home
            [
                'id' => 'page',
                'title' => _t('页面'),
                'fields'=>[
                    [
                        'name' => _t('Advanced Options'),
                        'fields'=>[
                            [
                                'id'   => 'enable_sticky_articles',
                                'type'  => 'checkbox',
                                'value' => false,
                                'label'  => _t('Show top articles on the home page')
                            ],
                            [
                                'id'   => 'enable_like',
                                'type'  => 'checkbox',
                                'value' => true,
                                'label'  => _t('Give a like')
                            ],
                            [
                                'id'   => 'only_search_title',
                                'type'  => 'checkbox',
                                'value' => false,
                                'label'  => _t('Only search title')
                            ],
                            [
                                'id'   => 'enable_css_animation',
                                'type'  => 'checkbox',
                                'value' => true,
                                'label'  => _t('Enable css animation')
                            ],
                            [
                                'id'   => 'enable_photoswipe',
                                'type'  => 'checkbox',
                                'value' => true,
                                'label'  => _t('Enable PhotoSwipe')
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
                        'name' => _t('List page display fields'),
                        'fields'=>[
                            [
                                'id'   => 'list_show_author',
                                'type'  => 'checkbox',
                                'value' => true,
                                'label'  => _t('display author name')
                            ],
                            [
                                'id'   => 'list_show_desc',
                                'type'  => 'checkbox',
                                'value' => true,
                                'label'  => _t('display article description')
                            ],
                            [
                                'id'   => 'list_show_views',
                                'type'  => 'checkbox',
                                'value' => true,
                                'label'  => _t('display article views')
                            ]
                        ]
                    ],
                    [
                        'name' => _t('Single page display fields'),
                        'fields'=>[
                            [
                                'id'   => 'single_show_author',
                                'type'  => 'checkbox',
                                'value' => true,
                                'label'  => _t('display author name')
                            ],
                            [
                                'id'   => 'single_show_views',
                                'type'  => 'checkbox',
                                'value' => true,
                                'label'  => _t('display article views')
                            ],
                            [
                                'id'   => 'single_show_comments',
                                'type'  => 'checkbox',
                                'value' => true,
                                'label'  => _t('display article comments')
                            ],
                            
                        ]
                    ],
                    [
                        'id'   => 'recent_articles_alias',
                        'name' => _t('Recent Articles Alias'),
                        'type'  => 'text',
                        'value'=>_t('Recent Articles')
                    ],
                    [
                        'id'   => 'tags_alias',
                        'name' => _t('Tags Alias'),
                        'type'  => 'text',
                        'value' => ''
                    ],
                    [
                        'id'   => 'related_articles_alias',
                        'name' => _t('Related Articles Alias'),
                        'type'  => 'text',
                        'value' => ''
                    ],
                ]
            ],// page
            [
                'id'=>'advertise',
                'title'=>_t('Advertise'),
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
            ] // advertise
        ]
    ],
    
];