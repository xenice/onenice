<?php
/**
 * @name        xenice optimize
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-09-26
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\optimize;

use xenice\theme\Base;
use xenice\theme\Theme;

class Optimize extends Base
{
    public function __construct()
    {
        new GlobalOptimize;
        if(is_admin()){
            Theme::bind('xenice_options_init', [$this,'set']);
            new AdminOptimize;
        }
        else{
            new GuestOptimize;
        }
    }
    
    public function set($options)
    {
        $defaults   = [];
        $defaults[] = [
            'id'=>'optimize',
            'name'=> _t('Optimize'),
            'title'=> _t('Optimize Options'),
            'fields'=>[
                [
                    'name' => _t('Global optimization'),
                    'fields'=>[
                        [
                            'id'   => 'disable_widgets',
                            'type'  => 'checkbox',
                            'value' => true,
                            'label'  => _t('Disable all built-in widgets')
                        ],
                        [
                            'id'   => 'disable_pingback',
                            'type'  => 'checkbox',
                            'value' => true,
                            'label'  => _t('Disable the pingback')
                        ],
                        [
                            'id'   => 'disable_emoji',
                            'type'  => 'checkbox',
                            'value' => true,
                            'label'  => _t('Disable the emoji')
                        ],
                        [
                            'id'   => 'disable_rest_api',
                            'type'  => 'checkbox',
                            'value' => false,
                            'label'  => _t('Disable the restapi')
                        ],
                        [
                            'id'   => 'disable_embeds',
                            'type'  => 'checkbox',
                            'value' => true,
                            'label'  => _t('Disable the embeds')
                        ],
                        [
                            'id'   => 'disable_open_sans',
                            'type'  => 'checkbox',
                            'value' => true,
                            'label'  => _t('Disable the opensans')
                        ],
                        [
                            'id'   => 'remove_category_pre',
                            'type'  => 'checkbox',
                            'value' => true,
                            'label'  => _t('Remove the category link prefix')
                        ],
                        [
                            'id'   => 'remove_child_categories',
                            'type'  => 'checkbox',
                            'value' => true,
                            'label'  => _t('Remove the article link subcategory, leaving only the parent category')
                        ],
                        [
                            'id'   => 'enable_ssl_avatar',
                            'type'  => 'checkbox',
                            'value' => false,
                            'label'  => _t('Enable official Gravatar SSL avatar links')
                        ],
                        [
                            'id'   => 'enable_user_register_login_info',
                            'type'  => 'checkbox',
                            'value' => true,
                            'label'  => _t('The user list display registration and last login information')
                        ],
                        [
                            'id'   => 'enable_custom_avatar',
                            'type'  => 'checkbox',
                            'value' => true,
                            'label'  => _t('Enable custom avatar')
                        ],
                    ]
                ],
                [
                    'name' => _t('Back-end optimization'),
                    'fields'=>[
                        [
                            'id'   => 'disable_auto_save',
                            'type'  => 'checkbox',
                            'value' => true,
                            'label'  => _t('Disable auto save')
                        ],
                        [
                            'id'   => 'disable_post_revision',
                            'type'  => 'checkbox',
                            'value' => true,
                            'label'  => _t('Disable revision')
                        ],
                        [
                            'id'   => 'enable_empty_email_save',
                            'type'  => 'checkbox',
                            'value' => true,
                            'label'  => _t('Profile can also be saved when user email is empty')
                        ],
                        [
                            'id'   => 'only_display_current_user',
                            'type'  => 'checkbox',
                            'value' => true,
                            'label'  => _t('Only current user articles and comments are displayed, except for administrators')
                        ],
                        [
                            'id'   => 'remove_w_icon',
                            'type'  => 'checkbox',
                            'value' => false,
                            'label'  => _t('Remove backstage at the top of the W icon in the upper left corner')
                        ],
                        [
                            'id'   => 'disable_update_remind',
                            'type'  => 'checkbox',
                            'value' => false,
                            'label'  => _t('Disable update reminders')
                        ],
                        [
                            'id'   => 'enable_link',
                            'type'  => 'checkbox',
                            'value' => false,
                            'label'  => _t('Enable the link')
                        ],
                        [
                            'id'   => 'enable_code_escape',
                            'type'  => 'checkbox',
                            'value' => false,
                            'label'  => _t('Convert the html within the code tag to entity before saving article')
                        ],
                    ]
                ],
                [
                    'name' => _t('Front-end optimization'),
                    'fields'=>[
                        [
                            'id'   => 'disable_admin_bar',
                            'type'  => 'checkbox',
                            'value' => true,
                            'label'  => _t('Disable the front admin bar')
                        ],
                        [
                            'id'   => 'disable_head_links',
                            'type'  => 'checkbox',
                            'value' => true,
                            'label'  => _t('Disable useless links to the front wp_head')
                        ],
                    ]
                ]
                
            ]
        ];
        return array_merge($options, $defaults);
    }
}