<?php
/**
 * @name        xenice social wechat login
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-12-14
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\login;

use xenice\theme\Ajax;

class WechatLogin extends Ajax
{
    use Part;
	
	public function __construct()
	{
		$this->action('wechat');
		$this->action('wechatBind');
	}

    public function wechat()
    {
        $scope = 'snsapi_login';
        $appid = take('wechat_app_id');
        $appsecret = take('wechat_app_secret');
        if(isset($_REQUEST['code']) && isset($_REQUEST['state'])){
        	$this->login($appid,$appsecret,$_REQUEST['code']);
        	$this->enter();
        }
        exit;
    }
    
    public function wechatBind()
    {
        $scope = 'snsapi_login';
        $appid = take('wechat_app_id');
        $appsecret = take('wechat_app_secret');
        if(isset($_REQUEST['code']) && isset($_REQUEST['state'])){
        	$this->login($appid,$appsecret,$_REQUEST['code']);
        	$this->weixin_bd();
        }
        exit;
    }
    
	private function login($appid,$appkey,$code)
	{
		if($_REQUEST ['state'] == 'MBT_weixin_login'){
		
			$token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appkey."&code=".$code."&grant_type=authorization_code";
			$response = $this->get( $token_url );
			$msg = json_decode ( $response );
			if (isset ( $msg->errcode )) {
				echo "<h3>error:</h3>" . $msg->errcode;
				echo "<h3>msg  :</h3>" . $msg->errmsg;
				exit ();
			}else{
				
				$_SESSION ['weixin_access_token'] = $msg->access_token;
				$_SESSION ['weixin_open_id'] = $msg->openid;
			}
		}else{
			echo _t("The state does not match. You may be a victim of CSRF.");
			exit;
		}
	}
	
	private function enter()
	{
		if(is_user_logged_in()){
			echo _t('You are logged in, please bind in the user page.');
			exit;
		}else{
			global $wpdb;
			if(isset($_SESSION ['weixin_open_id'])){
				
				$user_ID = $wpdb->get_var("SELECT ID FROM $wpdb->users WHERE wechat='".$wpdb->escape($_SESSION['weixin_open_id'])."'");
				if($user_ID){
				    Theme::call('social_login', $user_ID);
				    Theme::new('user_pointer', $user_ID)->setValue('last_login_way', 'wechat');
					wp_set_auth_cookie($user_ID,true,false);
					wp_redirect(get_bloginfo('url'));
					exit();
				}else{
				
					$uinfo = $this->wx_oauth2_get_user_info($_SESSION ['weixin_access_token'],$_SESSION ['weixin_open_id']);
					$pass = wp_create_nonce(rand(10,1000));
					$login_name = "u".mt_rand(1000,9999).mt_rand(1000,9999).mt_rand(1000,9999).mt_rand(1000,9999);
					$username = $uinfo->nickname;
					$userdata=array(
					  'user_login' => $login_name,
					  'display_name' => $username,
					  'nickname' => $username,
					  'user_pass' => $pass,
					  'role' => get_option('default_role'),
					  'first_name' => $username
					);
					$user_id = wp_insert_user( $userdata );
					if ( is_wp_error( $user_id ) ) {
						echo $user_id->get_error_message();
					}else{
		
						$ff = $wpdb->query("UPDATE $wpdb->users SET wechat = '".$wpdb->escape($_SESSION['weixin_open_id'])."' WHERE ID = '$user_id'");
						if($ff){
						    Theme::call('social_register', $user_id);
						    $data = [
						        'wechat_avatar'=>$uinfo->headimgurl,
						        'wechat_name'=>$username,
						        'last_login_way'=>'wechat',
						        'register_way'=>'wechat'
						    ];
						    Theme::new('user_pointer', $user_id)->setValue($data);
							wp_set_auth_cookie($user_id,true,false);
							wp_redirect(get_bloginfo('url'));
						}
			   
					}
					exit();
				}
				
			}
		}
	}

	private function bind()
	{
		if(is_user_logged_in()){
			global $wpdb;
			if(isset($_SESSION ['weixin_open_id'])){
				
				$hsauser_ID = $wpdb->get_var("SELECT ID FROM $wpdb->users WHERE wechat='".$wpdb->escape($_SESSION['weixin_open_id'])."'");
				if($hsauser_ID){
				    echo _t('The binding failed. It may have been bound to other accounts. Please log in to other accounts to unbind.');
				    exit;
				}else{
					global $current_user;
					$userid = $current_user->ID;
					$uinfo = $this->wx_oauth2_get_user_info($_SESSION ['weixin_access_token'],$_SESSION ['weixin_open_id']);
					
					$wpdb->query("UPDATE $wpdb->users SET wechat = '".$wpdb->escape($_SESSION['weixin_open_id'])."' WHERE ID = $userid");
					Theme::new('user_pointer', $user_ID)->setValue('wechat_name', $uinfo->nickname);
					wp_redirect(get_bloginfo('url'));
				}

			}
		}else{
		    echo _t('Binding failed, please login first');
		    exit;
		}
	}
	
	
	private function wx_oauth2_get_user_info($access_token, $openid)
	{
		$url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
		$res = $this->get($url);
		return json_decode($res);
	}
}