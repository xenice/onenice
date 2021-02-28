<?php
/**
 * @name        xenice social weibo login
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-12-14
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\login;

use xenice\theme\Ajax;

class WeiboLogin extends Ajax
{
    use Part;
    
	private $callbackUrl;
	
	public function __construct()
	{
	    $this->callbackUrl = admin_url('admin-ajax.php') . '?action=weiboCallback';
		$this->action('weibo');
		$this->action('weiboCallback');
	
	}

    public function weibo()
    {
        $appid = take('weibo_app_id');
        $this->login($appid,$this->callbackUrl);
        exit;
    }
    
    public function weiboCallback()
    {
        $appid = take('weibo_app_id');
        $appkey = take('weibo_app_key');
        $this->callback($appid,$appkey,$this->callbackUrl);
        if(is_user_logged_in()){
        	$this->bind();
        }else{
        	$this->enter();
        }
        exit;
    }
    
	private function login($appid, $callback)
	{
		$_SESSION['rurl'] = $_REQUEST ["rurl"];
		$_SESSION ['state'] = md5 ( uniqid ( rand (), true ) ); //CSRF protection
		$login_url = "https://api.weibo.com/oauth2/authorize?client_id=".$appid."&response_type=code&redirect_uri=".$callback."&state=".$_SESSION['state'];
		header ( "Location:$login_url" );
	}

	private function callback($appid,$appkey,$path)
	{
		if ($_REQUEST ['state'] == $_SESSION ['state']) {
			$url = "https://api.weibo.com/oauth2/access_token";
			$data = "client_id=".$appid."&client_secret=".$appkey."&grant_type=authorization_code&redirect_uri=".$path."&code=".$_REQUEST ["code"];
			$output = json_decode($this->post($url,$data));
			$_SESSION['access_token'] = $output->access_token;
			$_SESSION['uid'] = $output->uid;
		}else{
			echo _t("The state does not match. You may be a victim of CSRF.");
			exit;
		}
	}

	private function get_user_info()
	{
		$get_user_info = "https://api.weibo.com/2/users/show.json?uid=".$_SESSION['uid']."&access_token=".$_SESSION['access_token'];
		return $this->get( $get_user_info );
	}

	private function get_user_id()
	{
		$get_user_id = "https://api.weibo.com/2/account/get_uid.json?access_token=".$_SESSION['access_token'];
		return $this->get( $get_user_id );
	}
	
	private function enter()
	{
		if(is_user_logged_in()){
			echo _t('You are logged in, please bind in the user page.');
			exit;
		}else{
			global $wpdb;
			$uidArray = json_decode($this->get_user_id());
			if( isset($_SESSION['uid']) && $uidArray->uid == $wpdb->escape($_SESSION['uid']) && isset($_SESSION['access_token']) ){
				
				$user_ID = $wpdb->get_var("SELECT ID FROM $wpdb->users WHERE user_weibo='".$uidArray->uid."'");
				if ( $user_ID > 0 ) {
				    Theme::call('social_login', $user_ID);
				    Theme::new('user_pointer', $user_ID)->setValue('last_login_way', 'weibo');
					wp_set_auth_cookie($user_ID,true,false);
					wp_redirect($_SESSION['rurl']);
					exit();
				}else{
					
					$pass = wp_create_nonce(rand(10,1000));
					$str = json_decode($this->get_user_info());
					$login_name = "u".mt_rand(1000,9999).mt_rand(1000,9999).mt_rand(1000,9999).mt_rand(1000,9999);
					$username = $str->screen_name;
					$userimg = $str->avatar_large;
					$description = $str->description;

					$userdata=array(
					  'user_login' => $login_name,
					  'display_name' => $username,
					  'user_pass' => $pass,
					  'role' => get_option('default_role'),
					  'nickname' => $username,
					  'first_name' => $username,
					  'description'=> $description
					);
					$user_id = wp_insert_user( $userdata );
					if ( is_wp_error( $user_id ) ) {
						echo $user_id->get_error_message();
					}else{
						$ff = $wpdb->query("UPDATE $wpdb->users SET user_weibo = '".$uidArray->uid."' WHERE ID = '$user_id'");
						if ($ff) {
						    Theme::call('social_register', $user_id);
						    $data = [
						        'weibo_avatar'=>$userimg,
						        'weibo_name'=>$username,
						        'last_login_way'=>'weibo',
						        'register_way'=>'weibo'
						    ];
						    Theme::new('user_pointer', $user_id)->setValue($data);
							wp_set_auth_cookie($user_id,true,false);
							wp_redirect($_SESSION['rurl']);
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
			$uidArray = json_decode($this->get_user_id());
			if( isset($_SESSION['uid']) && $uidArray->uid == $wpdb->escape($_SESSION['uid']) && isset($_SESSION['access_token']) ){
				
				$hsauser_ID = $wpdb->get_var("SELECT ID FROM $wpdb->users WHERE user_weibo='".$uidArray->uid."'");
				if($hsauser_ID){
					echo _t('The binding failed. It may have been bound to other accounts. Please log in to other accounts to unbind.');
				    exit;
				}else{
					global $current_user;
					$userid = $current_user->ID;
					$wpdb->query("UPDATE $wpdb->users SET user_weibo = '".$uidArray->uid."' WHERE ID = $userid");
					$str = json_decode($this->get_user_info());
					Theme::new('user_pointer', $userid)->setValue('weibo_name', $str->screen_name);
					wp_redirect($_SESSION['rurl']);
					exit;
					
				}
				
			}
		}else{
			echo _t('Binding failed, please login first');
		    exit;
		}
	}
	
}