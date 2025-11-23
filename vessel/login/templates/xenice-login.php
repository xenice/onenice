<?php 
/**
 * template name: xenice-login
 * description: login page template
 */
 
 
if(is_user_logged_in()){
    header("Location:".home_url());
    exit;
}

$action = $_GET['action']??'login';

?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no">
    <?php wp_head(); ?>
    <style>
        body{
            background-color: #fafafa;
        }
        h1{
            text-align: center;
            margin:40px 0;
        }
        .navbar-brand{
            font-size:30px;
        }
        form{
            width:100%;
            background-color:#fff;
            padding:40px 30px 20px 30px;
            box-shadow:2px 2px 5px #eee;
        }
        button{
            width:100%;
        }
        .back, .bottom{
            margin:20px;
            font-size:13px;
        }
        .user-login{
            margin-left: auto;
        }
        @media screen and (min-width:768px){
            .container{
                width:400px;
            }
        }
        
      @media screen and (max-width: 767px){
          .user-login {
              right: auto;
            }
      }
        
    </style>
</head>
<body>
<div class="container user-login">
    <h1><a class="navbar-brand" href="<?php echo esc_url(home_url());?>"><?php echo bloginfo('name');?></a></h1>
    <?php if($action == 'login'): ?>
        <div class="sign-tips alert alert-danger"></div>
        <form class="rounded">
            <div class="form-group">
                <input id="username" type="text" class="form-control" name="username" placeholder="<?php esc_attr_e('Username or Email', 'onenice')?>">
            </div>
            <div class="form-group">
                <input id="password" type="password" class="form-control" name="password" placeholder="<?php esc_attr_e('Password', 'onenice')?>">
            </div>
            <div class="form-group">
                <button id="login" type="button" class="btn btn-custom"><?php esc_html_e('Login', 'onenice')?></button>
            </div>
        </form>
        <div class='bottom'>
            <a href="<?php echo get_permalink()?>?action=forget_password"><?php esc_html_e('Forget password ?', 'onenice')?></a> &nbsp;
            <a href="<?php echo get_permalink()?>?action=register"><?php esc_html_e('Register', 'onenice')?></a>
        </div>
    <?php elseif($action == 'register'): ?>
        <div class="sign-tips alert alert-danger"></div>
        <form class="rounded">
            <div class="form-group">
                <input id="r_username" type="text" class="form-control" name="username" placeholder="<?php esc_attr_e('Username', 'onenice')?>">
            </div>
            <div class="form-group">
                <input id="r_email" type="text" class="form-control" name="email" placeholder="<?php esc_attr_e('Email', 'onenice')?>">
            </div>
            <div class="form-group">
                <input id="r_password" type="password" class="form-control" name="password" placeholder="<?php esc_attr_e('Password', 'onenice')?>">
            </div>
            <div class="form-group">
                <input id="r_repassword" type="password" class="form-control" name="repassword" placeholder="<?php esc_attr_e('Confirm password', 'onenice')?>">
            </div>
            <div class="input-group form-group">
				<input id="r_captcha" type="text" class="form-control" placeholder="<?php esc_attr_e('Captcha', 'onenice')?>">
				<div class="input-group-append">
                    <span id="r_captcha_clk" class="input-group-text"><?php esc_html_e('Send captcha', 'onenice')?></span>
                </div>
			</div>
            <div class="form-group">
                <button id="register" type="button" class="btn btn-custom"><?php esc_html_e('Register', 'onenice')?></button>
            </div>
        </form>
        <div class='bottom'>
            <a href="<?php echo get_permalink()?>"><?php esc_html_e('Login', 'onenice')?></a>
        </div>
    <?php elseif($action == 'forget_password'): ?>
        <div class="alert alert-info">
            <?php esc_html_e('Please enter your username or email address. You will receive a link to create a new password via email.', 'onenice')?>
        </div>
        <div class="sign-tips alert alert-danger"></div>
        <div class="success-tips alert alert-success"></div>
        <form class="rounded">
            <div class="form-group">
                <input id="fp_username" type="text" class="form-control" name="username" placeholder="<?php esc_attr_e('Username or Email', 'onenice')?>">
            </div>
            <div class="input-group form-group">
				<input id="fp_captcha" type="text" class="form-control" placeholder="<?php esc_attr_e('Captcha', 'onenice')?>">
				<div class="input-group-append">
				    <img id="fp_captcha_image" class="input-group-text" style="padding:0" src="<?php echo admin_url('admin-ajax.php')?>?action=forgetPasswordCaptcha" onclick="this.src=this.src+'&amp;k='+Math.random();">
             
                </div>
			</div>
            <div class="form-group">
                <button id="forget_password" type="button" class="btn btn-custom"><?php esc_html_e('Get New Password', 'onenice')?></button>
            </div>
        </form>
        <div class='bottom'>
            <a href="<?php echo get_permalink()?>"><?php esc_html_e('Login', 'onenice')?></a> &nbsp;
            <a href="<?php echo get_permalink()?>?>?action=register"><?php esc_html_e('Register', 'onenice')?></a>
        </div>
    <?php elseif($action == 'reset_password'): 
        global $wpdb;
        $reset_key = esc_sql($_GET['key']); 
		$user_login = esc_sql($_GET['login']); 
		$user_data = $wpdb->get_row($wpdb->prepare("SELECT ID, user_login, user_email, user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));   
		$user_login = $user_data->user_login;   
		$user_email = $user_data->user_email;   
		if(!empty($reset_key) && !empty($user_data) && md5('xenice'.$user_data->user_activation_key) == $reset_key):
    ?>
        <div class="sign-tips alert alert-danger"></div>
        <div class="success-tips alert alert-success"></div>
        <form class="rounded">
            <input type="hidden" id="rp_key" value="<?php echo $reset_key;?>">
            <input type="hidden" id="rp_username" value="<?php echo $user_login;?>">
            <div class="form-group">
                <input id="rp_password" type="password" class="form-control" name="password" placeholder="<?php esc_attr_e('New password', 'onenice')?>">
            </div>
            <div class="form-group">
                <input id="rp_repassword" type="password" class="form-control" name="repassword" placeholder="<?php esc_attr_e('Confirm password', 'onenice')?>">
            </div>
            <div class="input-group form-group">
				<input id="rp_captcha" type="text" class="form-control" placeholder="<?php esc_attr_e('Captcha', 'onenice')?>">
				<div class="input-group-append">
				    <img id="rp_captcha_image" class="input-group-text" style="padding:0" src="<?php echo admin_url('admin-ajax.php')?>?action=resetPasswordCaptcha" onclick="this.src=this.src+'&amp;k='+Math.random();">
             
                </div>
			</div>
            <div class="form-group">
                <button id="reset_password" type="button" class="btn btn-custom"><?php esc_html_e('Change password', 'onenice')?></button>
            </div>
        </form>
        <div class='bottom'>
            <a href="<?php echo get_permalink()?>"><?php esc_html_e('Login', 'onenice')?></a> &nbsp;
            <a href="<?php echo get_permalink()?>?action=register"><?php esc_html_e('Register', 'onenice')?></a>
        </div>
    <?php else:?>
        <div class="alert alert-danger">
            <?php esc_html_e('Error request, please check email for reset password link', 'onenice')?>
        </div>
    <?php endif;endif;?>
    <div class='back'><a href="<?php echo esc_url(home_url());?>">←<?php esc_html_e('Back to home', 'onenice')?></a></div>
</div>
<?php wp_footer(); ?>
</body>
</html>