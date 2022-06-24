<?php
return [
    [
        'id'=>'advanced',
        'pos'=>110,
        'name'=>_t('advanced'),
        'title'=>_t('Advanced Settings'),
        'tabs' => [
            [
                'id' => 'article',
                'title' => _t('Article Settings'),
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
            ],
            
        ],
        
        
    ]
];

                    