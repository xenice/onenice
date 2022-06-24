<?php

namespace app\web\module\inner;

use xenice\theme\Theme;

class Guest extends Base
{
	public function __construct()
	{
		parent::__construct();
		$this->loginScripts();
		Theme::bind('head', [$this, 'head']);
		Theme::bind('footer', [$this, 'footer']);
		
	}
    
    public function head($head)
    {
        $colors = explode(' ', take('color'));
        Theme::use('template')->colors = $colors;
        
        $head .= '<style>';
        $styles = $this->customColor($colors);
        foreach($styles as $key => $style){
            $head .= $key . $style;
        }
        $head .= '</style>';
        return $head;
    }
    
    public function customColor($colors)
    {
        list($a1, $a2, $b1, $b2, $b3, $b4) = $colors;
        $styles = [
            'a:hover'=>"{color:$a1;}",
            '.breadcrumb a:hover'=>"{color:$a2;}",
            '.btn-custom,.badge-custom'=>"{color:$b3!important;background-color:$b1;border-color:$b1;}",
            '.btn-custom:hover,.badge-custom:hover'=>"{color:$b3;background-color:$b2;border-color:$b2}",
            '.form-control:focus'=>"{border-color: $b4!important;}",
            
            '.navbar-nav .current-menu-item a'=>"{color:$a1}",
            '.fa-search:hover'=>"{color:$a2;}",
            '.user-login .nav-item .nav-link'=>"{color:$b4;}",
            '.user-login .nav-item .active'=>"{color:$a2;}",
            '.post-content a'=>"{color:$a1;}",
            '.post-content a:hover'=>"{color:$b2;}",
            '.rollbar .rollbar-item:hover'=>"{background-color: $b4;}",
            
            '.fa-weixin'=>"{color:#7BD172}",
            '.fa-qq'=>"{color:#f67585}",
            '.fa-weibo'=>"{color:#ff8d8d}",
        ];
        return $styles;
    }
    
    public function scripts()
    {
        wp_dequeue_style( 'wp-block-library' );
        wp_deregister_script( 'jquery' );
        parent::scripts();
    }
    
    public function addScripts()
    {
        $scripts = parent::addScripts();
        
        if(take('enable_cdn')){
            $cdn_url = take('cdn_url');
            $scripts['css'][10] = ['font-awesome', $cdn_url . '/font-awesome/4.7.0/css/font-awesome.min.css', [], '4.7.0'];
            $scripts['css'][20] = ['bootstrap-css', $cdn_url . '/twitter-bootstrap/4.4.1/css/bootstrap.min.css', [], '4.4.1'];
            
            $scripts['js'][10] = ['jquery', $cdn_url . '/jquery/3.2.1/jquery.min.js', [], '3.2.1',true];
            $scripts['js'][20] = ['popper', $cdn_url . '/popper.js/1.15.0/umd/popper.min.js', [], '1.15.0',true];
            $scripts['js'][30] = ['bootstrap-js', $cdn_url . '/twitter-bootstrap/4.4.1/js/bootstrap.min.js', [], '4.4.1',true];
            $scripts['js'][40] = ['gifffer', $cdn_url . '/gifffer/1.5.0/gifffer.min.js', [], '1.5.0',true];
            
        }
        else{
            $scripts['css'][30] = ['font-awesome', STATIC_URL . '/css/font-awesome.min.css', [], '4.7.0'];
            $scripts['css'][40] = ['bootstrap-css', STATIC_URL. '/lib/bootstrap/css/bootstrap.min.css', [], '4.4.1'];
            
            $scripts['js'][50] = ['jquery', STATIC_URL. '/lib/jquery/jquery.min.js', [], '3.2.1',true];
            $scripts['js'][60] = ['popper', STATIC_URL. '/lib/popper/popper.min.js', [], '1.15.0',true];
            $scripts['js'][70] = ['bootstrap-js', STATIC_URL. '/lib/bootstrap/js/bootstrap.min.js', [], '4.4.1',true];
            $scripts['js'][80] = ['gifffer', STATIC_URL. '/lib/gifffer/gifffer.min.js', [], '1.5.0',true];
            
        }
        $scripts['css'][50] = ['style', STATIC_URL . '/css/style.css', [], THEME_VER];
        $scripts['js'][90] = ['lazyload', STATIC_URL . '/lib/lazyload/lazyload.min.js', [], '2.0.0', true];
        $scripts['js'][100] = ['xenice', STATIC_URL . '/js/xenice.js', [], THEME_VER,true];
        $scripts['js'][110] = ['login', STATIC_URL . '/js/login.js', [], THEME_VER,true];
        return $scripts;
    }
    
    private function loginScripts()
    {
        $option = Theme::use('option');
        $nonce = [
            'login' => wp_create_nonce('login'),
            'register' => wp_create_nonce('register'),
            'check_username' => wp_create_nonce('check_username'),
            'check_email' => wp_create_nonce('check_email'),
            'send_captcha' => wp_create_nonce('send_captcha'),
            // Reset password
            'forget_password' => wp_create_nonce('forget_password'), 
            'reset_password' => wp_create_nonce('reset_password'), 
        ];
        
        $arr = [
            'Login',
            'Register',
            'Username or email cannot be empty',
            'Password cannot be empty',
            'Login...',
            'Register...',
            'Username or password wrong',
            'Entered passwords differ',
            'Username can only be 6-16 characters composed of alphanumeric or underlined characters',
            'Email format error',
            'Password length at least 6',
            'The captcha cannot be empty',
            'Registered successfully',
            'Username or email cannot be empty',
            'execute...',
            'The link has been successfully sent to your email, please check and confirm.',
            'Get New Password',
            'Change password',
            'Password changed successfully, please remember the password.',
            'Your operation too fast, please wait a moment.',
            'Send in...',
            'Resend captcha',
            'Email already exists',
            'Send captcha',
            'The captcha failed to send. Please try again later.',
            'Captcha has been sent to the email, may appear in the dustbin oh ~',
        ];
        
        $lang = [];
        foreach($arr as $key){
            $lang[$key] = _t($key);
        }
        
        $str  = 'xenice.url = "' . $option->info['url'] . '";' . "\r\n";
        $str .= 'xenice.action = "' . admin_url('admin-ajax.php') . '?action=";' . "\r\n";
        $str .= 'xenice.nonce = '.json_encode($nonce).';';
        $str .= 'xenice.lang = '.json_encode($lang).';';
        Theme::use('template')->js .= $str;
    }
    
    public function footer($footer)
    {
        // rollbar
        $str = '';
        
        $str && $footer .= '<div class="rollbar md-down-none">' . $str . '</div>';
        
        take('Baidu_statistics') && $footer .= take('Baidu_statistics');
        take('baidu_auto_push') && $footer .= take('baidu_auto_push');
        return $footer;
    }
}