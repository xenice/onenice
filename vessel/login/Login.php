<?php

namespace vessel\login;

class Login {

    /**
	 * Constructor
	 */
	public function __construct(){

        new ajax\LoginAjax;
        add_action( 'wp_enqueue_scripts', [$this, 'scripts']);
        add_action('wp_head', [$this, 'head'], 20);
        add_action('admin_footer', [$this, 'admin_footer']);
        add_action('wp_footer', [$this, 'footer'],99);
        add_filter( 'login_url', [$this, 'login_url'], 10, 3 );
        
        // load page templates
        add_action('init', function(){
            add_filter( 'page_template', function($page_template){
                if ( get_page_template_slug() == 'xenice-login' ) {
            		$page_template = dirname( __FILE__ ) . '/templates/xenice-login.php';
            	}
            	return $page_template;
            });
        
            add_filter( 'theme_page_templates', function($post_templates, $wp_theme, $post, $post_type){
                $post_templates['xenice-login'] = __( 'Xenice Login', 'onenice' );
            	return $post_templates;
            }, 10, 4 );
        });
	}
	
	public function scripts()
    {
        wp_enqueue_style('onenice', THEME_URL . '/vessel/login/static/css/style.css', [], '1.0.6');
        wp_enqueue_script('onenice', THEME_URL . '/vessel/login/static/js/script.js', ['jquery'], '1.0.4', true);
            
    }
    
    public function head(){

    }
    
    public function footer(){
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
                
        $lang = [
            'Login'=>__('Login', 'onenice'),
            'Register'=>__('Register', 'onenice'),
            'Username or email cannot be empty'=>__('Username or email cannot be empty', 'onenice'),
            'Password cannot be empty'=>__('Password cannot be empty', 'onenice'),
            'Login...'=>__('Login...', 'onenice'),
            'Register...'=>__('Register...', 'onenice'),
            'Username or password wrong'=>__('Username or password wrong', 'onenice'),
            'Entered passwords differ'=>__('Entered passwords differ', 'onenice'),
            'Username can only be 6-16 characters composed of alphanumeric or underlined characters'=>__('Username can only be 6-16 characters composed of alphanumeric or underlined characters', 'onenice'),
            'Email format error'=>__('Email format error', 'onenice'),
            'Password length at least 6'=>__('Password length at least 6', 'onenice'),
            'The captcha cannot be empty'=>__('The captcha cannot be empty', 'onenice'),
            'Registered successfully'=>__('Registered successfully', 'onenice'),
            'Username or email cannot be empty'=>__('Username or email cannot be empty', 'onenice'),
            'execute...'=>__('execute...', 'onenice'),
            'The link has been successfully sent to your email, please check and confirm.'=>__('The link has been successfully sent to your email, please check and confirm.', 'onenice'),
            'Get New Password'=>__('Get New Password', 'onenice'),
            'Change password'=>__('Change password', 'onenice'),
            'Password changed successfully, please remember the password.'=>__('Password changed successfully, please remember the password.', 'onenice'),
            'Your operation too fast, please wait a moment.'=>__('Your operation too fast, please wait a moment.', 'onenice'),
            'Send in...'=>__('Send in...', 'onenice'),
            'Resend captcha'=>__('Resend captcha', 'onenice'),
            'Email already exists'=>__('Email already exists', 'onenice'),
            'Send captcha'=>__('Send captcha', 'onenice'),
            'The captcha failed to send. Please try again later.'=>__('The captcha failed to send. Please try again later.', 'onenice'),
            'Captcha has been sent to the email, may appear in the dustbin oh ~'=>__('Captcha has been sent to the email, may appear in the dustbin oh ~', 'onenice'),
        ];
    
        $home_url = home_url();
        $action_url = admin_url('admin-ajax.php') . '?action=';
        $nonce = json_encode($nonce);
        $lang = json_encode($lang);
        $login_url = wp_login_url();
        
        
        
        echo <<<EOT
        <script>
        var xenice_login_home_url = "$home_url";
        var xenice_login_action_url = "$action_url";
        var xenice_login_nonce = $nonce;
        var xenice_login_lang = $lang;
        
        function xenice_login_t(key){
            return xenice_login_lang[key];
        }
        
        function xenice_login_show_modal(){
            jQuery('#login-modal').modal('show');
            return false;
        }
        
        function xenice_login_cut_modal(id1, id2)
        {
            jQuery(id1).removeClass('fade');
            jQuery(id1).modal('hide');
            jQuery(id1).addClass('fade');
            jQuery(id2).modal('show');
        }
        
        function xenice_login_check_name(str)
        {    
        	return /^[\w]{3,16}$/.test(str) ;
        }
        
        function xenice_login_check_mail(str)
        {
        	return /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/.test(str);
        }
        
        function xenice_login_check_url(str)
        {
            return /^((http|https)\:\/\/)([a-z0-9-]{1,}.)?[a-z0-9-]{2,}.([a-z0-9-]{1,}.)?[a-z0-9]{2,}$/.test(str);
        }
        
        
       
        </script>
EOT;

        include __DIR__ . '/templates/modal.php';
        
        echo <<<EOT
        <script>
        jQuery("#login-trigger").on('click',function(){
            xenice_login_cut_modal('#register-modal', '#login-modal');
        });
        
        jQuery("#register-trigger").on('click',function(){
            xenice_login_cut_modal('#login-modal', '#register-modal');
        });
        
        jQuery("#forget-password-trigger").on('click',function(){
            xenice_login_cut_modal('#login-modal', '#forget-password-modal');
        });
        
        // change login url
        jQuery(function(){
            var e = jQuery('a[href="$login_url"]');
            if(e.length>0){
                e.attr('data-toggle','modal');
                e.attr('data-target','#login-modal');
                e.attr('href','javascript:;');
            }
            
            var e = jQuery('a[href="$home_url/wp-login.php"]');
            if(e.length>0){
                e.attr('data-toggle','modal');
                e.attr('data-target','#login-modal');
                e.attr('href','javascript:;');
            }
            
        });

        </script>
EOT;
        
        
        
    }
    
    public function admin_footer()
    {
        $msg = [
            'success' => __('Successfully copied to clipboard', 'onenice'),
            'failed' => __('The browser does not support link clicks to copy to the clipboard', 'onenice')
        ];
        echo <<<EOT
    <script>
    
    function xenice_login_copy (obj) {
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
    </script>
EOT;
        
    }

	public function login_url( $login_url, $redirect, $force_reauth ){

        //Add login page
        $template = 'xenice-login';
        $row = yy_get_page($template);
        if($row){
            return get_permalink($row->ID);
            
        }

        yy_add_page($template);
        return $login_url;
    }
}










