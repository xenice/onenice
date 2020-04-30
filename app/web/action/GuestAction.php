<?php
namespace app\web\action;

use xenice\theme\Theme;

class GuestAction extends GlobalAction
{
	public function __construct()
	{
		parent::__construct();
		$this->loginScripts();
		Theme::bind('head', [$this, 'customColor']);
		Theme::bind('footer', [$this, 'footer']);
		add_action( 'wp_enqueue_scripts', [$this, 'scripts']);
		add_filter('body_class',[$this, 'customClasses']);
		
	}
    
    public function customColor($head)
    {
        list($a1, $a2, $b1, $b2, $b3, $b4) = explode(' ', take('color'));
        $head .= '<style>';
        $head .= "a:hover{color:$a1;}.breadcrumb a:hover{color:$a2;}.btn-custom,.badge-custom{color:$b3!important;background-color:$b1;border-color:$b1;}.btn-custom:hover,.badge-custom:hover{color:$b3;background-color:$b2;border-color:$b2}.form-control:focus {border-color: $b4!important;}.navbar-nav .current-menu-item a{color:$a1}.search-form .fa-search:hover{color:$a2;}.user-login .nav-item .nav-link{color:$b4;}.user-login .nav-item .active{color:$a2;}";
        $head .= ".fa-weixin{color:#7BD172}.fa-qq{color:#f67585}.fa-weibo{color:#ff8d8d}";
        
        $head .= '</style>';
        return $head;
    }
    
    public function scripts()
    {
        wp_dequeue_style( 'wp-block-library' );
        wp_deregister_script( 'jquery' );
        if(take('enable_cdn')){
            wp_enqueue_style( 'font-awesome', 'https://cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.min.css', [], '4.7.0');
            wp_enqueue_style( 'bootstrap-css', 'https://cdn.staticfile.org/twitter-bootstrap/4.4.1/css/bootstrap.min.css', [], '4.4.1');
            
            wp_enqueue_script( 'jquery', 'https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js', [], '3.2.1',true);
            wp_enqueue_script( 'popper', 'https://cdn.staticfile.org/popper.js/1.15.0/umd/popper.min.js', [], '1.15.0',true);
            wp_enqueue_script( 'bootstrap-js', 'https://cdn.staticfile.org/twitter-bootstrap/4.4.1/js/bootstrap.min.js', [], '4.4.1',true);
            wp_enqueue_script( 'gifffer', 'https://cdn.staticfile.org/gifffer/1.5.0/gifffer.min.js', [], '1.5.0',true);
            
        }
        else{
            wp_enqueue_style( 'font-awesome', STATIC_URL . '/css/font-awesome.min.css', [], '4.7.0');
            wp_enqueue_style( 'bootstrap-css', STATIC_URL. '/lib/bootstrap/css/bootstrap.min.css', [], '4.4.1');
            
            wp_enqueue_script( 'jquery', STATIC_URL. '/lib/jquery/jquery.min.js', [], '3.2.1',true);
            wp_enqueue_script( 'popper', STATIC_URL. '/lib/popper/popper.min.js', [], '1.15.0',true);
            wp_enqueue_script( 'bootstrap-js', STATIC_URL. '/lib/bootstrap/js/bootstrap.min.js', [], '4.4.1',true);
            wp_enqueue_script( 'gifffer', STATIC_URL. '/lib/gifffer/gifffer.min.js', [], '1.5.0',true);
            
        }
        wp_enqueue_style( 'style', STATIC_URL . '/css/style.css', [], THEME_VER);
        wp_enqueue_script('lazyload', STATIC_URL . '/lib/lazyload/lazyload.min.js', [], '2.0.0', true);
        wp_enqueue_script( 'xenice', STATIC_URL . '/js/xenice.js', [], THEME_VER,true);
        wp_enqueue_script( 'login', STATIC_URL . '/js/login.js', [], THEME_VER,true);
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
        take('Baidu_statistics') && $footer .= take('Baidu_statistics');
        take('baidu_auto_push') && $footer .= take('baidu_auto_push');
        return $footer;
    }
    
    function customClasses($classes)
    {
        $classes [] = take( 'color' );
    
        if( take( 'full-content' ) ){
            $classes [] = 'full-content';
        }
        return $classes;
    }
}