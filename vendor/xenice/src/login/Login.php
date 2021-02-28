<?php
/**
 * @name        xenice social login
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-12-14
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\login;

use xenice\theme\Base;
use xenice\theme\Theme;

class Login extends Base
{
    public function __construct()
    {
        add_action('admin_footer',[$this, 'footer']);
        add_filter('get_avatar_url', [$this, 'avatar'] ,10, 2);
        
        if(is_admin()){
            Theme::bind('xenice_options_init', [$this,'set']);
            Theme::bind('xenice_options_save', [$this,'save']);
        }
        take('enable_qq_login') && QQLogin::instance();
        take('enable_wechat_login') && WechatLogin::instance();
        take('enable_weibo_login') && WeiboLogin::instance();
    }
    
    public function set($options)
    {
        $defaults   = [];
        $defaults[] = [
            'id'=>'login',
            'pos'=>100,
            'name'=> _t('Login'),
            'title'=> _t('Social Login Settings'),
            'fields'=>[
                [
                    'name' => _t('QQ Login'),
                    'desc' => sprintf(_t('<a href="%s" target="_blank">Register</a> a QQ social login account. <a onclick="copyLink(this);return false;" href="%s?action=qqCallback">Copy</a> the callback url.'),'https://connect.qq.com/',admin_url('admin-ajax.php')),
                    'fields'=>[
                        [
                            'id'   => 'enable_qq_login',
                            'type'  => 'checkbox',
                            'value' => false,
                            'label'  => _t('Enable')
                        ],
                        [
                            'id'   => 'qq_app_id',
                            'type'  => 'text',
                            'value' => '',
                            'label'  => _t('APP ID')
                        ],
                        [
                            'id'   => 'qq_app_key',
                            'type'  => 'text',
                            'value' => '',
                            'label'  => _t('APP Key')
                        ],
                    ]  
                ],
                [
                    'name' => _t('WeChat Login'),
                    'desc' => sprintf(_t('<a href="%s" target="_blank">Register</a> a WeChat social login account. <a onclick="copyLink(this);return false;" href="%s?action=wechatCallback">Copy</a> the callback url.'),'https://open.weixin.qq.com/',admin_url('admin-ajax.php')),
                    'fields'=>[
                        [
                            'id'   => 'enable_wechat_login',
                            'type'  => 'checkbox',
                            'value' => false,
                            'label'  => _t('Enable')
                        ],
                        [
                            'id'   => 'wechat_app_id',
                            'type'  => 'text',
                            'value' => '',
                            'label'  => _t('APP ID')
                        ],
                        [
                            'id'   => 'wechat_app_secret',
                            'type'  => 'text',
                            'value' => '',
                            'label'  => _t('APP Secret')
                        ],
                    ]  
                ],
                [
                    'name' => _t('WeiBo Login'),
                    'desc' => sprintf(_t('<a href="%s" target="_blank">Register</a> a WeiBo social login account. <a onclick="copyLink(this);return false;" href="%s?action=weiboCallback">Copy</a> the callback url.'),'http://open.weibo.com',admin_url('admin-ajax.php')),
                    'fields'=>[
                        [
                            'id'   => 'enable_weibo_login',
                            'type'  => 'checkbox',
                            'value' => false,
                            'label'  => _t('Enable')
                        ],
                        [
                            'id'   => 'weibo_app_id',
                            'type'  => 'text',
                            'value' => '',
                            'label'  => _t('APP Key')
                        ],
                        [
                            'id'   => 'weibo_app_key',
                            'type'  => 'text',
                            'value' => '',
                            'label'  => _t('APP Secret')
                        ],
                    ]  
                ],
            ]
        ];
        return array_merge($options, $defaults);
    }
    
    public function save($key, $tab, $data)
    {
        global $wpdb;
        if($key == 'login'){
            if(isset($data['enable_qq_login'])){
                $var = $wpdb->query("SELECT user_qq FROM $wpdb->users");
                if(!$var){
                    $wpdb->query("ALTER TABLE $wpdb->users ADD user_qq varchar(100)");
                }
            }
            if(isset($data['enable_wechat_login'])){
                $var = $wpdb->query("SELECT user_wechat FROM $wpdb->users");
                if(!$var){
                    $wpdb->query("ALTER TABLE $wpdb->users ADD user_wechat varchar(100)");
                }
            }
            
            if(isset($data['enable_weibo_login'])){
                $var = $wpdb->query("SELECT user_weibo FROM $wpdb->users");
                if(!$var){
                    $wpdb->query("ALTER TABLE $wpdb->users ADD user_weibo varchar(100)");
                }
            }
        }
        return $key;
    }
    
    public function footer()
    {
        $msg = [
            'success' => _t('Successfully copied to clipboard'),
            'failed' => _t('The browser does not support link clicks to copy to the clipboard')
        ];
        echo <<<EOT
<script>

function copyLink (obj) {
    var text = obj.href;
    var textArea = document.createElement("textarea");
      textArea.style.position = 'fixed';
      textArea.style.top = '0';
      textArea.style.left = '0';
      textArea.style.width = '2em';
      textArea.style.height = '2em';
      textArea.style.padding = '0';
      textArea.style.border = 'none';
      textArea.style.outline = 'none';
      textArea.style.boxShadow = 'none';
      textArea.style.background = 'transparent';
      textArea.value = text;
      document.body.appendChild(textArea);
      textArea.select();

      try {
        var successful = document.execCommand('copy');
        var msg = successful ? '{$msg['success']}' : '{$msg['failed']}';
       alert(msg);
      } catch (err) {
        alert('{$msg['failed']}');
      }

      document.body.removeChild(textArea);
}
</script>';
EOT;
        
    }
    
    public function avatar($url, $id_or_email)
    {
        // param is id
        if(is_numeric($id_or_email)){
            $user_id = $id_or_email;
            if(!empty($user_id)){
                $data = Theme::new('user_pointer', $user_id)->getValue();
                //$data = get_user_meta($user_id, 'xenice_value',true);
                if(!empty($data['last_login_way'])){
                    $way = $data['last_login_way'];
                    $avatar = $data[$way . '_avatar'];
                    if(!empty($avatar)){
                        $_SERVER['HTTPS'] && $avatar = str_replace('http://','https://',$avatar);
                        return $avatar;
                    }
                }
            }
        }
        
        return $url;
    }
}