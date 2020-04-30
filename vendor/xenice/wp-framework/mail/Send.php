<?php
/**
 * @name        Xenice Send Mail
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-10-14
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\mail;

use xenice\theme\Base;
use xenice\theme\Theme;

class Send extends Base
{
    public function __construct()
    {
        if(is_admin()){
            Theme::bind('xenice_options_init', [$this,'set']);
            Theme::bind('xenice_options_save', [$this,'save']);
        }
        
    }
    
    public function set($options)
    {
        $defaults   = [];
        $defaults[] = [
            'id'=>'send',
            'name'=> _t('Send'),
            'title'=> _t('Send Mail'),
            'submit'=> _t('Send'),
            'fields'=>[
                [
                    'id'   => 'mail_title',
                    'name' => _t('Mail Title'),
                    'type'  => 'text',
                    'value' => ''
                ],
                [
                    'id'   => 'mail_content',
                    'name' => _t('Mail Content'),
                    'type'  => 'textarea',
                    'value' => '',
                    'style' => 'regular',
                    'rows' => 12
                ]
            ]
        ];
        return array_merge($options, $defaults);
    }
    
    public function save($key, $data)
    {
        if($key == 'send'){
            global $current_user;
            $bool = wp_mail($current_user->user_email, $data['mail_title']??'', $data['mail_content']??'');
            if($bool)
                $result = ['success' => 'true', 'message'=>_t('Send successfully')];
            else
                $result = ['success' => 'false', 'message'=>_t('Send failure')];
            Theme::call('xenice_options_result', $result);
        }
        else{
            return $key;
        }
        
    }
}