<?php
namespace app\web\ajax;

use xenice\theme\Theme;
use xenice\theme\Ajax;
use app\web\helper\ImageCaptcha;

class LoginAjax extends Ajax
{
	public function __construct()
	{
		$this->action('login');
		$this->action('register');
		$this->action('check');
		$this->action('captcha');
		$this->action('forgetPassword');
		$this->action('forgetPasswordCaptcha');
		$this->action('resetPassword');
		$this->action('resetPasswordCaptcha');
		
	}
    
    public function login()
    {
        if(!wp_verify_nonce($_POST['login_nonce'],'login')){
            exit;
        }
		$login_data = [];   
		$login_data['user_login'] = esc_sql($_POST['username']);
		$login_data['user_password'] = esc_sql($_POST['password']);
		$login_data['remember'] = true;
		if(Theme::use('user')->signon($login_data)){
		    echo '1';
		}
		exit;
    }
    
    public function register()
    {
        if(!wp_verify_nonce($_POST['register_nonce'],'register')){
            exit;
        }
        
        $username = sanitize_user( $_POST['username']);
        $email =  $_POST['email'];
        $error = '';
		if ( $username == '' ) {
			$error .= _t('Please enter username') . ' ';
		}
		elseif(!validate_username( $username ) ){
		    $error .= _t('This username contains an invalid character') . ' ';
		}
		elseif (username_exists( $username ) ) {
		    $error .= _t('The username has been registered') . ' ';
		}
		
        if ( $email == '' ) {
            $error .= _t('Please fill in your email address') . ' ';
        }
        elseif ( ! is_email( $email ) ) {
            $error .= _t('The email address is incorrect') . ' ';
        }
        elseif ( email_exists( $email ) ) {
            $error .= _t('The email address has been registered') . ' ';
        }
		  
        if($_POST['password'] == ''){
            $error .= _t('Please enter password') . ' ';
        }
        
        if($_POST['password'] != $_POST['repassword']){
            $error .= _t('Entered passwords differ') . ' ';
        }
        
        elseif(strlen($_POST['password']) < 6){
            $error .= _t('Password length should not be less than 6') . ' ';
        }
        
        if(empty($_POST['captcha']) || empty($_SESSION['xenice_captcha']) || trim(strtolower($_POST['captcha'])) != $_SESSION['xenice_captcha']){
            $error .= _t('Captcha error') . ' ';
        }

        if(empty($_SESSION['xenice_captcha_email']) || $_SESSION['xenice_captcha_email'] != $email){
            $error .= _t('Captcha and email do not correspond') . ' ';
        }
		  
		if($error){
		    $error = str_replace(' ', '<br/>', trim($error));
		    echo $error;
		    exit;
		    
		}
		else{
		  	unset($_SESSION['xenice_captcha']);
		    unset($_SESSION['xenice_captcha_email']);
		  	$password = $_POST['password'];
		  	$userdata=array(
			  'ID' => '',
			  'user_login' => esc_sql($username),
			  'user_pass' => esc_sql($password),
			  'user_email' => esc_sql($email),
			  'role' => get_option('default_role'),
			);
			$user_id = wp_insert_user( $userdata );
			if ( is_wp_error( $user_id ) ) {
				echo _t("Server timeout, please try again later");
			}else{
				wp_set_auth_cookie($user_id,true,false);
				echo "1";
			}
		}
		
		exit;
    }
    
    public function check()
    {
    	$error = '';
    	if(isset($_POST['username'])){
            if(!wp_verify_nonce($_POST['username_nonce'],'check_username')){
                exit;
            }
    		$username = sanitize_user(esc_sql($_POST['username']));
    		if(strlen($username) < 6){
    		    $error .= _t('Username at least 6 characters') . ' ';
            }elseif ( $username == '' ) {
                $error .= _t('Please enter username') . ' ';
            } elseif ( ! validate_username( $username ) ) {
                $error .= _t('This username contains an invalid character') . ' ';
            } elseif ( username_exists( $username ) ) {
                $error .= _t('The username has been registered') . ' ';
            }
    	  
    	}elseif(isset($_POST['email'])){
    	    if(!wp_verify_nonce($_POST['email_nonce'],'check_email')){
                exit;
            }
    	    $email = $_POST['email'];
            if ( $email == '' ) {
                $error .= _t('Please fill in your email address') . ' ';
            }
            elseif (!is_email( $email )) {
                $error .= _t('The email format is incorrect') . ' ';
            } 
            elseif(email_exists($email)) {
                $error .= _t('This email address has been registered, please change it') . ' ';
            }
    	}
    	echo $error;
    	exit;
    }
    
    public function captcha()
    {
        if(!wp_verify_nonce($_POST['email_nonce'],'send_email')){
            exit;
        }
        $email = $_POST['email'];
        if(email_exists($email)){
            echo '2';
        }
        elseif($this->sendCaptcha($email)){
            echo '1';
        }
        exit;
    }
    
    private function sendCaptcha($email)
    {
    	$originalcode = '0,1,2,3,4,5,6,7,8,9';
    	$originalcode = explode(',',$originalcode);
    	$countdistrub = 10;
    	$_dscode = "";
    	$counts=6;
    	for($j=0;$j<$counts;$j++){
    		$dscode = $originalcode[rand(0,$countdistrub-1)];
    		$_dscode.=$dscode;
    	}
    	
    	$_SESSION['xenice_captcha']=strtolower($_dscode);
    	$_SESSION['xenice_captcha_email']=$email;
    	$message = _t('Captcha') . ': ' .$_dscode;   
    	return wp_mail($email, _t('Captcha') . '-' . get_bloginfo('name'), $message);    
    }
    
    /* Reset Password */
    
    public function forgetPassword()
    {
        if(!wp_verify_nonce($_POST['forget_password_nonce'],'forget_password')){
            exit;
        }
        
        $arr = $_SESSION['forget_password_captcha']??null;
        $time = time() - 60; // The captcha expires in 60 seconds
        if(empty($_POST['captcha']) || empty($arr) || $_POST['captcha'] != $arr['code'] || $arr['time'] < $time){
            echo _t('The captcha is incorrect');
            exit;
        }
        
        $username = esc_sql($_POST['username']);
		$user_login = '';
		$user_email = '';
		$error = '';
		if(!is_email($username)) {
			$user_login = $username;
			if(!username_exists( $user_login )){
				$error = _t("Username does not exist");
			}else{
				$user_data = get_user_by('login', $username);
				$user_email = $user_data->user_email;
				if(empty($user_email)){
					$error = _t("User does not set email");
				}
			}
		}else{
			$user_email = $username;
			if(!email_exists( $user_email )){
				$error = _t("Email does not exist");
			}else{
				$user_data = get_user_by('email', $username);
				$user_login = $user_data->user_login;
			}
		}
		if($error){
		    echo $error;
		    exit;
		    
		}
		else{
		    global $wpdb;
			$key = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login)); 
			if(empty($key)) {
				$key = wp_generate_password(20, false); 
				$wpdb->update($wpdb->users, array('user_activation_key' => $key), array('user_login' => $user_login)); 
			}   
		    
			$page = Theme::use('page');
			
			$verify_url = $page->first('login')->url() . "?action=reset_password&key=".md5('xenice'.$key)."&login=" . rawurlencode($user_login); 
			
			
			$subject = '[' . get_option('blogname') . '] ' . _t('Reset password');
			$message = '<table cellpadding="0" cellspacing="0" align="center" style="text-align:left;font-family:Microsoft Yahei,arial;" width="742"><tbody><tr><td><table cellpadding="0" cellspacing="0" style="text-align:left;border:1px solid #999;color:#fff;font-size:18px;" width="740"><tbody><tr height="45" style="background-color:#999;"><td style="padding-left:15px;font-family:Microsoft Yahei,arial;font-size:24px;">'.get_bloginfo("name").' </td></tr></tbody></table><table cellpadding="0" cellspacing="0" style="text-align:left;border:1px solid #f0f0f0;border-top:none;color:#585858;background-color:#fafafa;font-size:14px;" width="740"><tbody><tr height="25"><td></td></tr><tr height="40"><td style="padding-left:25px;padding-right:25px;font-size:18px;font-family:Microsoft Yahei,arial;"> '._t('Dear ') . $user_login . _t(':') . ' </td></tr><tr height="15"><td></td></tr><tr height="30"><td style="padding-left:55px;padding-right:55px;font-family:Microsoft Yahei,arial;font-size:14px;line-height:20px;">' . _t('You have just initiated a password reset request, please click the following link to reset your password:') . ' </td></tr><tr height="15"><td></td></tr><tr height="30"><td style="padding-left:55px;padding-right:55px;font-family:Microsoft Yahei,arial;font-size:14px;line-height:20px;"><a href="'.$verify_url.'" target="_blank">'.$verify_url.'</a> </td></tr><tr height="15"><td></td></tr><tr height="30"><td style="padding-left:55px;padding-right:55px;font-family:Microsoft Yahei,arial;font-size:14px;line-height:20px;"> '._t('If not you, please ignore this mail.').'</td></tr><tr height="20"><td></td></tr><tr><td style="padding-left:55px;padding-right:55px;font-family:Microsoft Yahei,arial;font-size:14px;"> '._t('With the best wishes') . '<br>'.get_bloginfo("name").'</td></tr><tr height="50"><td></td></tr></tbody></table><table cellpadding="0" cellspacing="0" style="color:#969696;font-size:12px;vertical-align:middle;text-align:center;" width="740"><tbody><tr height="5"><td></td></tr><tr height="20"><td width="680" style="text-align:left;font-family:Microsoft Yahei,arial"> '.date("Y").' <span>©</span> <a href="'.get_bloginfo("url").'" target="_blank" style="text-decoration:none;color:#969696;padding-left:5px;" title="'.get_bloginfo("name").'">'.get_bloginfo("url").'</a> </td><td width="30" style="text-align:right;font-family:Microsoft Yahei,arial"></td><td width="30" style="text-align:right;font-family:Microsoft Yahei,arial"></td></tr></tbody></table></td></tr></tbody></table>';   
			$headers = 'Content-Type: text/html; charset=' . get_option('blog_charset') . "\n";
			//echo $headers;
			//exit;
			if (wp_mail($user_email, $subject, $message, $headers) ) {   
		       	echo "1";
		    } else {   
		        echo _t("Send mail failed, please try again later");
		    }
		    exit();
		}
    }
    
    public function forgetPasswordCaptcha()
    {
        (new ImageCaptcha)->set('forget_password_captcha')->show(); 
        exit;
    }
    
    public function resetPassword()
    {
        if(!wp_verify_nonce($_POST['reset_password_nonce'],'reset_password')){
            exit;
        }
        
        $arr = $_SESSION['reset_password_captcha']??null;
        $time = time() - 60; 
        if(empty($_POST['captcha']) || empty($arr) || $_POST['captcha'] != $arr['code'] || $arr['time'] < $time){
            echo _t('The captcha is incorrect');
            exit;
        }
        
        if($_POST['password'] != $_POST['password']){
            echo _t('Entered passwords differ');
            exit;
        }
        $reset_key = esc_sql($_POST['key']); 
		$user_login = esc_sql($_POST['username']); 
		$newpass = $_POST['password'];
		global $wpdb;
		$user_data = $wpdb->get_row($wpdb->prepare("SELECT ID, user_login, user_email, user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));   
		$user_login = $user_data->user_login;   
		$user_email = $user_data->user_email;   
		if(!empty($reset_key) && !empty($user_data) && md5('xenice'.$user_data->user_activation_key) == $reset_key) {  
			wp_set_password( $newpass, $user_data->ID ); 
			$key = wp_generate_password(20, false); 
			$wpdb->update($wpdb->users, ['user_activation_key' => $key], ['user_login' => $user_login]); 
            $page = Theme::use('page');
			$verify_url = $page->first('login')->url();  
			$subject = '[' . get_option('blogname') . '] ' . _t('Password changed successfully');
			$message = '<table cellpadding="0" cellspacing="0" align="center" style="text-align:left;font-family:Microsoft Yahei,arial;" width="742"><tbody><tr><td><table cellpadding="0" cellspacing="0" style="text-align:left;border:1px solid #666;color:#fff;font-size:18px;" width="740"><tbody><tr height="45" style="background-color:#666;"><td style="padding-left:15px;font-family:Microsoft Yahei,arial;font-size:24px;">'.get_bloginfo("name").' </td></tr></tbody></table><table cellpadding="0" cellspacing="0" style="text-align:left;border:1px solid #f0f0f0;border-top:none;color:#585858;background-color:#fafafa;font-size:14px;" width="740"><tbody><tr height="25"><td></td></tr><tr height="40"><td style="padding-left:25px;padding-right:25px;font-size:18px;font-family:Microsoft Yahei,arial;">' . _t('Dear ') . $user_login . _t(':') . ' </td></tr><tr height="15"><td></td></tr><tr height="30"><td style="padding-left:55px;padding-right:55px;font-family:Microsoft Yahei,arial;font-size:14px;line-height:20px;"> ' . _t('Your password has been changed successfully, user name: ') . $user_login.'&nbsp;&nbsp;&nbsp;&nbsp; ' .  _t('New password: ') . $newpass.'</td></tr><tr height="15"><td></td></tr><tr height="30"><td style="padding-left:55px;padding-right:55px;font-family:Microsoft Yahei,arial;font-size:14px;line-height:20px;">'._t('Please remember the password, you can click the following link to log in: ') . ' </td></tr><tr height="15"><td></td></tr><tr height="30"><td style="padding-left:55px;padding-right:55px;font-family:Microsoft Yahei,arial;font-size:14px;line-height:20px;"><a href="'.$verify_url.'" target="_blank">'.$verify_url.'</a> </td></tr><tr height="20"><td></td></tr><tr><td style="padding-left:55px;padding-right:55px;font-family:Microsoft Yahei,arial;font-size:14px;"> ' . _t('With the best wishes') . '<br>'.get_bloginfo("name").'</td></tr><tr height="50"><td></td></tr></tbody></table><table cellpadding="0" cellspacing="0" style="color:#969696;font-size:12px;vertical-align:middle;text-align:center;" width="740"><tbody><tr height="5"><td></td></tr><tr height="20"><td width="680" style="text-align:left;font-family:Microsoft Yahei,arial"> '.date("Y").' <span>©</span> <a href="'.get_bloginfo("url").'" target="_blank" style="text-decoration:none;color:#969696;padding-left:5px;" title="'.get_bloginfo("name").'">'.get_bloginfo("url").'</a> </td><td width="30" style="text-align:right;font-family:Microsoft Yahei,arial"></td><td width="30" style="text-align:right;font-family:Microsoft Yahei,arial"></td></tr></tbody></table></td></tr></tbody></table>';   
			$headers = 'Content-Type: text/html; charset=' . get_option('blog_charset') . "\n";
			wp_mail($user_email, $subject, $message, $headers);
			echo "1";
		}else{
			echo _t("Illegal request");
		}
		exit;
    }
    
    public function resetPasswordCaptcha()
    {
        (new ImageCaptcha)->set('reset_password_captcha')->show(); 
        exit;
    }
    
}