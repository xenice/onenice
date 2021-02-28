<?php
/**
 * @name        xenice social QQ login
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-12-14
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\login;

use xenice\theme\Theme;
use xenice\theme\Ajax;

class QQLogin extends Ajax
{
    use Part;
    
	private $callbackUrl;
	
	public function __construct()
	{
	    $this->callbackUrl = admin_url('admin-ajax.php') . '?action=qqCallback';
		$this->action('qq');
		$this->action('qqCallback');
	
	}

    public function qq()
    {
        $scope = 'get_user_info,add_share,list_album,add_album,upload_pic,add_topic,add_one_blog,add_weibo';
        $appid = take('qq_app_id');
        $this->login($appid,$scope,$this->callbackUrl);
        exit;
    }
    
    public function qqCallback()
    {
        $appid = take('qq_app_id');
        $appkey = take('qq_app_key');
        $this->callback($appid,$appkey,$this->callbackUrl);
        $this->get_openid();
        if(is_user_logged_in()){
        	$this->bind();
        }else{
        	$this->enter();
        }
        exit;
    }
    
	private function login($appid, $scope, $callback)
	{
		$_SESSION['rurl'] = $_REQUEST ["rurl"];
		$_SESSION ['state'] = md5 ( uniqid ( rand (), true ) ); //CSRF protection
		$login_url = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=" . $appid . "&redirect_uri=" . urlencode ( $callback ) . "&state=" . $_SESSION ['state'] . "&scope=" . $scope;
		header ( "Location:$login_url" );
	}

	private function callback($appid,$appkey,$path)
	{
	    if(empty($_REQUEST ['state']) || empty($_SESSION ['state'])){
	        exit;
	    }
		if ($_REQUEST ['state'] == $_SESSION ['state']) {
			$token_url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&" . "client_id=" . $appid . "&redirect_uri=" . urlencode ( $path ) . "&client_secret=" . $appkey . "&code=" . $_REQUEST ["code"];
			
			$response = $this->get( $token_url );
			if (strpos ( $response, "callback" ) !== false) {
				$lpos = strpos ( $response, "(" );
				$rpos = strrpos ( $response, ")" );
				$response = substr ( $response, $lpos + 1, $rpos - $lpos - 1 );
				$msg = json_decode ( $response );
				if (isset ( $msg->error )) {
					echo "<h3>error:</h3>" . $msg->error;
					echo "<h3>msg  :</h3>" . $msg->error_description;
					exit ();
				}
			}
			
			$params = array ();
			parse_str ( $response, $params );
			$_SESSION ['access_token'] = $params ["access_token"];
		} else {
			echo _t("The state does not match. You may be a victim of CSRF.");
			exit;
		}
	}

	private function get_openid()
	{
		$graph_url = "https://graph.qq.com/oauth2.0/me?access_token=" . $_SESSION ['access_token'];
		
		$str = $this->get( $graph_url );
		if (strpos ( $str, "callback" ) !== false) {
			$lpos = strpos ( $str, "(" );
			$rpos = strrpos ( $str, ")" );
			$str = substr ( $str, $lpos + 1, $rpos - $lpos - 1 );
		}

		$user = json_decode ( $str );
		if (isset ( $user->error )) {
			echo "<h3>error:</h3>" . $user->error;
			echo "<h3>msg2  :</h3>" . $user->error_description;
			exit ();
		}
		$_SESSION ['openid'] = $user->openid;
	}

	private function get_user_info() {
		$appid = take('qq_app_id');
		$get_user_info = "https://graph.qq.com/user/get_user_info?" . "access_token=" . $_SESSION ['access_token'] . "&oauth_consumer_key=".$appid."&openid=" . $_SESSION ['openid']."&format=json" ;		
		return $this->get( $get_user_info );
	}

	private function enter(){
		if(is_user_logged_in()){
			echo _t('You are logged in, please bind in the user page.');
			exit;
		}else{
			if(isset($_SESSION['openid'])){
				global $wpdb;
				
				$user_ID = $wpdb->get_var("SELECT ID FROM $wpdb->users WHERE user_qq='".$wpdb->escape($_SESSION['openid'])."'");
				//$user_ID = $wpdb->get_var("SELECT user_id FROM $wpdb->usermeta WHERE meta_key='qq' meta_value='".$wpdb->escape($_SESSION['openid'])."'");
				if($user_ID > 0){
				    Theme::call('social_login', $user_ID);
					Theme::new('user_pointer', $user_ID)->setValue('last_login_way', 'qq');
					wp_set_auth_cookie($user_ID,true,false);
					wp_redirect($_SESSION['rurl']);
					exit;
				}else{
					$pass = wp_create_nonce(rand(10,1000));
					$uinfo = json_decode($this->get_user_info());
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
						$ff = $wpdb->query("UPDATE $wpdb->users SET user_qq = '".$wpdb->escape($_SESSION['openid'])."' WHERE ID = '$user_id'");
						if ($ff) {
						    Theme::call('social_register', $user_id);
						    $data = [
						        'qq_avatar'=>$uinfo->figureurl_qq_1,
						        'qq_name'=>$username,
						        'last_login_way'=>'qq',
						        'register_way'=>'qq',
						    ];
						    Theme::new('user_pointer', $user_id)->setValue($data);
							wp_set_auth_cookie($user_id,true,false);
							wp_redirect($_SESSION['rurl']);
							
						}          
					}
					exit;
				}
			}
		}
	}

	private function bind(){
		if(is_user_logged_in()){
			if(isset($_SESSION['openid'])){
				
				global $wpdb;
				$hasuser_ID = $wpdb->get_var("SELECT ID FROM $wpdb->users WHERE user_qq='".$wpdb->escape($_SESSION['openid'])."'");
				//$hasuser_ID = $wpdb->get_var("SELECT user_id FROM $wpdb->usermeta WHERE meta_key='qq' meta_value='".$wpdb->escape($_SESSION['openid'])."'");
				if($hasuser_ID){
				    echo _t('The binding failed. It may have been bound to other accounts. Please log in to other accounts to unbind.');
				    exit;
				}else{
					global $current_user;
					$userid = $current_user->ID;
					$wpdb->query("UPDATE $wpdb->users SET user_qq = '".$wpdb->escape($_SESSION['openid'])."' WHERE ID = $userid");
					$uinfo = json_decode($this->get_user_info());
					Theme::new('user_pointer', $user_ID)->setValue('qq_name', $uinfo->nickname);
					wp_redirect($_SESSION['rurl']);
					exit();
				}
				
			}
		}else{
		    echo _t('Binding failed, please login first');
		    exit;
		}
	}
}