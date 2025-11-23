<?php
/**
 * @name        xenice options
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-09-26
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace vessel;


class Config extends Options
{
    protected $key = 'yy';
    protected $name = ''; // Database option name
    protected $defaults = [];
    
    public function __construct()
    {
        // #FF5E52 #f13c2f #fc938b Red
		// #1fae67 #229e60 #35dc89 Green
		// #ff4979 #f2295e #fb94af Pink
        $defaults = [
            'main_color' => '#0099FF',
            'dark_color' => '#007bff',
            'light_color'=> '#99CCFF',
            'link_color' => '#555555',
            'bg_color'   => '#FFFFFF',
            'fg_color'   => '#333333',
            
            'hf_main_color' => '#0099FF',
            'hf_dark_color' => '#007bff',
            'hf_light_color'=> '#99CCFF',
            'hf_link_color' => '#555555',
            'hf_bg_color'   => '#FFFFFF',
            'hf_fg_color'   => '#333333',
            
            'page_width' => 1200,
            
        ];
        $this->name = 'xenice_' . $this->key;
        /**
    	 * Filter default values
    	 */
        $defaults = apply_filters('yy_default_values', $defaults);
        
        $this->defaults[] = [
            'id'=>'settings',
            'name'=> esc_html__('Theme settings','onenice'),
            'submit'=>esc_html__('Save Changes','onenice'),
            'title'=> esc_html__('Theme settings','onenice'),
            'tabs' => [
                [
                    'id' => 'global',
                    'title' => esc_html__('Global', 'onenice'),
                    'fields'=>[
                        [
                            'name' => esc_html__('Global Colors', 'onenice'),
                            'inline' => true,
                            'fields'=>[
                                [
                                    'id'   => 'main_color',
                                    'label' =>esc_html__('Main', 'onenice'),
                                    'type' => 'color',
                                    'value' => $defaults['main_color']
                                ],
                                [
                                    'id'   => 'dark_color',
                                    'label' =>esc_html__('Dark', 'onenice'),
                                    'type' => 'color',
                                    'value' => $defaults['dark_color']
                                ],
                                [
                                    'id'   => 'light_color',
                                    'label' =>esc_html__('Light', 'onenice'),
                                    'type' => 'color',
                                    'value' => $defaults['light_color']
                                ],
                                [
                                    'id'   => 'link_color',
                                    'label' =>esc_html__('Link', 'onenice'),
                                    'type' => 'color',
                                    'value' => $defaults['link_color']
                                ],
                                [
                                    'id'   => 'bg_color',
                                    'label' =>esc_html__('Background ', 'onenice'),
                                    'type' => 'color',
                                    'value' => $defaults['bg_color']
                                ],
                                [
                                    'id'   => 'fg_color',
                                    'label' =>esc_html__('Foreground', 'onenice'),
                                    'type' => 'color',
                                    'value' => $defaults['fg_color']
                                ],
                            ]
                        ],
                        [
                            'name' => esc_html__('Header and footer colors', 'onenice'),
                            'inline' => true,
                            'fields'=>[
                                [
                                    'id'   => 'hf_main_color',
                                    'label' =>esc_html__('Main', 'onenice'),
                                    'type' => 'color',
                                    'value' => $defaults['hf_main_color']
                                ],
                                [
                                    'id'   => 'hf_dark_color',
                                    'label' =>esc_html__('Dark', 'onenice'),
                                    'type' => 'color',
                                    'value' => $defaults['hf_dark_color']
                                ],
                                [
                                    'id'   => 'hf_light_color',
                                    'label' =>esc_html__('Light', 'onenice'),
                                    'type' => 'color',
                                    'value' => $defaults['hf_light_color']
                                ],
                                [
                                    'id'   => 'hf_link_color',
                                    'label' =>esc_html__('Link', 'onenice'),
                                    'type' => 'color',
                                    'value' => $defaults['hf_link_color']
                                ],
                                [
                                    'id'   => 'hf_bg_color',
                                    'label' =>esc_html__('Background ', 'onenice'),
                                    'type' => 'color',
                                    'value' => $defaults['hf_bg_color']
                                ],
                                [
                                    'id'   => 'hf_fg_color',
                                    'label' =>esc_html__('Foreground', 'onenice'),
                                    'type' => 'color',
                                    'value' => $defaults['hf_fg_color']
                                ],
                            ]
                        ],
                        [
                            'id'   => 'page_width',
                            'name' => esc_html__('Page Width', 'onenice'),
                            'type' => 'number',
                            'min'  =>0,
                            'label'=>'PX',
                            'value' => $defaults['page_width']
                        ],
                        [
                            'id'   => 'site_icon',
                            'name' => esc_html__('Site Icon', 'onenice'),
                            'type'  => 'img',
                            'value' => STATIC_URL . '/images/icon.ico'
                        ],
                        [
                            'id'   => 'static_lib_cdn',
                            'name' => esc_html__('Static library CDN', 'onenice' ),
                            'type' => 'select',
                            'opts' =>[
            					''                                  => esc_html__( 'Defalut', 'onenice' ),
            					'https://cdn.staticfile.org'        => 'https://cdn.staticfile.org',
            					'https://cdn.bootcdn.net/ajax/libs' => 'https://cdn.bootcdn.net/ajax/libs',
            					'https://libs.cdnjs.net'            => 'https://libs.cdnjs.net',
                            ],
                            'value' => ''
                        ],
                        [
                            'name'=> esc_html__('Auxiliary functions', 'onenice'),
                            'fields'=>[
                                [
                                    'id'    => 'enable_theme_widgets',
                                    'label' => esc_html__('Enable theme widgets', 'onenice'),
                                    'type'  => 'checkbox',
                                    'value' => true
                                ],
                                [
                                    'id'    => 'enable_theme_login_interface',
                                    'label' => esc_html__('Enable theme login interface', 'onenice'),
                                    'type'  => 'checkbox',
                                    'value' => true
                                ],
                                [
                                    'id'    => 'single_enable_highlight',
                                    'label' => esc_html__('Enable Code Highlight', 'onenice'),
                                    'type'  => 'checkbox',
                                    'value' => true
                                ],
                                [
                                    'id'    => 'use_post_first_image_as_thumbnail',
                                    'label' => esc_html__('When the post does not have a thumbnail, use the first image of the post as a thumbnail', 'onenice'),
                                    'type'  => 'checkbox',
                                    'value' => true
                                ],
                                [
                                    'id'   => 'enable_css_animation',
                                    'type'  => 'checkbox',
                                    'value' => true,
                                    'label'  => esc_html__('Enable css animation', 'onenice')
                                ],
                                [
                                    'id'   => 'enable_like',
                                    'type'  => 'checkbox',
                                    'value' => true,
                                    'label'  => esc_html__('Give a like', 'onenice')
                                ],
                                [
                                    'id'    => 'enable_back_to_top',
                                    'label' => esc_html__('Enable back to top button', 'onenice'),
                                    'type'  => 'checkbox',
                                    'value' => false
                                ],
                            ]
                        ],
                        
                    ]
                ],  #tab global
                [
                    'id' => 'header',
                    'title' => esc_html__('Header', 'onenice'),
                    'fields'=>[
                        [
                            'id'   => 'site_logo',
                            'name' => esc_html__('Site Logo', 'onenice'),
                            'type'  => 'img',
                            'value' => STATIC_URL . '/images/logo.png',
                        ],
                        [
                            'id'    => 'show_search',
                            'name'  => esc_html__('Show Search', 'onenice'),
                            'label' => esc_html__('Enable', 'onenice'),
                            'type'  => 'checkbox',
                            'value' => true
                        ],
                        [
                            'id'    => 'show_login_button',
                            'name'  => esc_html__('Show Login Button', 'onenice'),
                            'label' => esc_html__('Enable', 'onenice'),
                            'type'  => 'checkbox',
                            'value' => true
                        ],
                    ]
                ], #tab header
                [
                    'id' => 'footer',
                    'title' => esc_html__('Footer', 'onenice'),
                    'fields'=>[
                        [
                            'id'   => 'icp_number',
                            'name' => esc_html__('ICP Number', 'onenice'),
                            'type'  => 'text',
                            'value' => ''
                        ],
                        [
                            'id'    => 'delete_theme_copyright',
                            'name'  => esc_html__('Delete Theme Copyright', 'onenice'),
                            'label' => esc_html__('Enable', 'onenice'),
                            'type'  => 'checkbox',
                            'value' => false
                        ],
                    ]
                ], #tab footer
                [
                    'id' => 'slides',
                    'title' => esc_html__('Slides', 'onenice'),
                    'fields'=>[
                        [
                            'id'    => 'enable_slides',
                            'name'  => esc_html__('Slides', 'onenice'),
                            'label' => esc_html__('Enable', 'onenice'),
                            'type'  => 'checkbox',
                            'value' => true
                        ],
                        [
                            'id'   => 'slides',
                            'name' => esc_html__('Slides Settings', 'onenice'),
                            'type'  => 'slide',
                            'value' => [
                                [
                                    'url'=>'https://www.xenice.com/',
                                    'src'=>STATIC_URL . '/images/yy_slide_1.jpg',
                                    'title'=>esc_html__( 'OneNice Theme', 'onenice' ),
                                    'desc'=>esc_html__('OneNice is a super concise WordPress theme, supporting both Chinese and English, free open source, no encryption, no redundant code, no authorization restrictions, can be used freely.', 'onenice')
                                ],
                                [
                                    'url'=>'https://www.xenice.com/',
                                    'src'=>STATIC_URL . '/images/yy_slide_2.jpg',
                                    'title'=>esc_html__( 'OneNice Theme', 'onenice' ),
                                    'desc'=>esc_html__('OneNice is a super concise WordPress theme, supporting both Chinese and English, free open source, no encryption, no redundant code, no authorization restrictions, can be used freely.', 'onenice')
                                ],
                                [
                                    'url'=>'https://www.xenice.com/',
                                    'src'=>STATIC_URL . '/images/yy_slide_3.jpg',
                                    'title'=>esc_html__( 'OneNice Theme', 'onenice' ),
                                    'desc'=>esc_html__('OneNice is a super concise WordPress theme, supporting both Chinese and English, free open source, no encryption, no redundant code, no authorization restrictions, can be used freely.', 'onenice')
                                ],
                            ],
                        ],
                        
                    ]
                ], #tab slides
                [
                    'id' => 'archive',
                    'title' => esc_html__('Archive', 'onenice'),
                    'fields'=>[
                        [
                            'id'   => 'list_style',
                            'name' => esc_html__('List Style', 'onenice'),
                            'type' => 'radio',
                            'opts' =>[
            					'text' => esc_html__( 'Text', 'onenice' ),
            					'thumbnail' => esc_html__( 'Thumbnail', 'onenice' ),
                            ],
                            'value' => 'thumbnail'
                        ],
                        [
                            'id'   => 'excerpt_length',
                            'name' => esc_html__('Excerpt Length', 'onenice'),
                            'type' => 'number',
                            'min'  =>0,
                            'value' => 100,
                        ],
                        [
                            'id'   => 'site_thumbnail',
                            'name' => esc_html__('Site Thumbnail', 'onenice'),
                            'type'  => 'img',
                            'value' => STATIC_URL . '/images/thumbnail.png'
                        ],
                        [
                            'id'   => 'site_loading_image',
                            'name' => esc_html__('Site Loading Image', 'onenice'),
                            'type'  => 'img',
                            'value' => STATIC_URL . '/images/loading.png'
                        ],
                        [
                            'id'    => 'archive_show_date',
                            'name'  => esc_html__('Show Date', 'onenice'),
                            'label' => esc_html__('Enable', 'onenice'),
                            'type'  => 'checkbox',
                            'value' => true
                        ],
                        [
                            'id'    => 'archive_show_author',
                            'name'  => esc_html__('Show Author', 'onenice'),
                            'label' => esc_html__('Enable', 'onenice'),
                            'type'  => 'checkbox',
                            'value' => true
                        ],
                        
                    ]
                ], #tab archive
                [
                    'id' => 'posts',
                    'title' => esc_html__('Posts', 'onenice'),
                    'fields'=>[
                        [
                            'id'    => 'single_show_date',
                            'name'  => esc_html__('Show Date', 'onenice'),
                            'label' => esc_html__('Enable', 'onenice'),
                            'type'  => 'checkbox',
                            'value' => true
                        ],
                        [
                            'id'    => 'single_show_author',
                            'name'  => esc_html__('Show Author', 'onenice'),
                            'label' => esc_html__('Enable', 'onenice'),
                            'type'  => 'checkbox',
                            'value' => true
                        ],
                        [
                            'id'    => 'single_show_tags',
                            'name'  => esc_html__('Show Tags', 'onenice'),
                            'label' => esc_html__('Enable', 'onenice'),
                            'type'  => 'checkbox',
                            'value' => true
                        ],
                        [
                            'id'    => 'single_show_previous_next',
                            'name'  => esc_html__('Show Previous/Next Posts', 'onenice'),
                            'label' => esc_html__('Enable', 'onenice'),
                            'type'  => 'checkbox',
                            'value' => true
                        ],
                        [
                            'id'    => 'show_related_posts',
                            'name'  => esc_html__('Show Related Posts', 'onenice'),
                            'label' => esc_html__('Enable', 'onenice'),
                            'type'  => 'checkbox',
                            'value' => true
                        ],
                        [
                            'id'    => 'single_show_share',
                            'name'  => esc_html__('Show Share', 'onenice'),
                            'label' => esc_html__('Enable', 'onenice'),
                            'type'  => 'checkbox',
                            'value' => true
                        ],
                        [
                            'id'    => 'single_disable_share_buttons',
                            'name'  => esc_html__('Disable Share Buttons', 'onenice'),
                            'desc'  => esc_html__('weibo,wechat,qq,douban,qzone,tencent,linkedin,diandian,google,twitter,facebook', 'onenice'),
                            'type'  => 'textarea',
                            'rows'  => 4,
                            'value' => 'qzone,tencent,linkedin,diandian,google,twitter,facebook'
                        ],
                    ]
                ], #tab posts
            ]
        ];
	    parent::__construct();
    }

}