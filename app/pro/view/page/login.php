<?php 
/**
 * template name: Login Page
 * description: template for onenice theme 
 */
 
if($user->login()){
    if($p = $page->first('user')){
        header("Location:". $p->url());
    }
    else{
        header("Location:".$option->info['url']);
    }
    exit;
}

$action = $_GET['action']??'login';

?>
<!DOCTYPE html>
<html>

<head>
    <title><?=_t($title)?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no">
    <?=$template->head()?>
    <style>
        body{
            background-color: #fafafa;
        }
        h1{
            text-align: center;
            margin:20px 0;
        }
        .logo{
            max-height: 35px;
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
        
        @media screen and (min-width:769px){
            .container{
                width:400px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h1><a class="navbar-brand" href="<?=$option->info['url']?>"><?=$template->logo()?></a></h1>
    <?php if($action == 'login'): ?>
        <div class="sign-tips alert alert-danger"></div>
        <form class="rounded">
            <div class="form-group">
                <input id="username" type="text" class="form-control" name="username" placeholder="<?=_t('Username or Email')?>">
            </div>
            <div class="form-group">
                <input id="password" type="password" class="form-control" name="password" placeholder="<?=_t('Password')?>">
            </div>
            <div class="form-group">
                <button id="login" type="button" class="btn btn-custom"><?=_t('Login')?></button>
            </div>
        </form>
        <div class='bottom'>
            <a href="<?=$page->url()?>?action=forget_password"><?=_t('Forget password ?')?></a> &nbsp;
            <a href="<?=$page->url()?>?action=register"><?=_t('Register')?></a>
        </div>
    <?php elseif($action == 'register'): ?>
        <div class="sign-tips alert alert-danger"></div>
        <form class="rounded">
            <div class="form-group">
                <input id="r_username" type="text" class="form-control" name="username" placeholder="<?=_t('Username')?>">
            </div>
            <div class="form-group">
                <input id="r_email" type="text" class="form-control" name="email" placeholder="<?=_t('Email')?>">
            </div>
            <div class="form-group">
                <input id="r_password" type="password" class="form-control" name="password" placeholder="<?=_t('Password')?>">
            </div>
            <div class="form-group">
                <input id="r_repassword" type="password" class="form-control" name="repassword" placeholder="<?=_t('Confirm password')?>">
            </div>
            <div class="input-group form-group">
				<input id="r_captcha" type="text" class="form-control" placeholder="<?=_t('Captcha')?>">
				<div class="input-group-append">
                    <span id="r_captcha_clk" class="input-group-text"><?=_('Send captcha')?></span>
                </div>
			</div>
            <div class="form-group">
                <button id="register" type="button" class="btn btn-custom"><?=_t('Register')?></button>
            </div>
        </form>
        <div class='bottom'>
            <a href="<?=$page->url()?>"><?=_t('Login')?></a>
        </div>
    <?php elseif($action == 'forget_password'): ?>
        <div class="alert alert-info">
            <?=_t('Please enter your username or email address. You will receive a link to create a new password via email.')?>
        </div>
        <div class="sign-tips alert alert-danger"></div>
        <div class="success-tips alert alert-success"></div>
        <form class="rounded">
            <div class="form-group">
                <input id="fp_username" type="text" class="form-control" name="username" placeholder="<?=_t('Username or Email')?>">
            </div>
            <div class="input-group form-group">
				<input id="fp_captcha" type="text" class="form-control" placeholder="<?=_t('Captcha')?>">
				<div class="input-group-append">
				    <img id="fp_captcha_image" class="input-group-text" style="padding:0" src="<?=admin_url('admin-ajax.php')?>?action=forgetPasswordCaptcha" onclick="this.src=this.src+'&amp;k='+Math.random();">
             
                </div>
			</div>
            <div class="form-group">
                <button id="forget_password" type="button" class="btn btn-custom"><?=_t('Get New Password')?></button>
            </div>
        </form>
        <div class='bottom'>
            <a href="<?=$page->url()?>"><?=_t('Login')?></a> &nbsp;
            <a href="<?=$page->url()?>?action=register"><?=_t('Register')?></a>
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
            <input type="hidden" id="rp_key" value="<?=$reset_key;?>">
            <input type="hidden" id="rp_username" value="<?=$user_login;?>">
            <div class="form-group">
                <input id="rp_password" type="password" class="form-control" name="password" placeholder="<?=_t('New password')?>">
            </div>
            <div class="form-group">
                <input id="rp_repassword" type="password" class="form-control" name="repassword" placeholder="<?=_t('Confirm password')?>">
            </div>
            <div class="input-group form-group">
				<input id="rp_captcha" type="text" class="form-control" placeholder="<?=_t('Captcha')?>">
				<div class="input-group-append">
				    <img id="rp_captcha_image" class="input-group-text" style="padding:0" src="<?=admin_url('admin-ajax.php')?>?action=resetPasswordCaptcha" onclick="this.src=this.src+'&amp;k='+Math.random();">
             
                </div>
			</div>
            <div class="form-group">
                <button id="reset_password" type="button" class="btn btn-custom"><?=_t('Change password')?></button>
            </div>
        </form>
        <div class='bottom'>
            <a href="<?=$page->url()?>"><?=_t('Login')?></a> &nbsp;
            <a href="<?=$page->url()?>?action=register"><?=_t('Register')?></a>
        </div>
    <?php else:?>
        <div class="alert alert-danger">
            <?=_t('Error request, please check email for reset password link')?>
        </div>
    <?php endif;endif;?>
    <div class='back'><a href="<?=$option->info['url']?>">←<?=_t('Back to home')?></a></div>
</div>
<?=$template->footer()?>
</body>
</html>