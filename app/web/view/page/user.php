<?php 
/**
 * template name: User Page
 * description: template for onenice theme 
 */
 
if(!$user->login()){
    header("Location:". $user->loginUrl());
}

$page->msg = function($str, $error = false){
    if($error){
        echo '<div class="alert alert-danger">' . $str . '</div>';
    }
    else{
        echo '<div class="alert alert-success">' . $str . '</div>';
    }
};

$action = $_GET['action']??'profile';

import('header');

?>
<style>


footer{
    margin-top:0;
}

.user-left, .content{
    padding-top:20px;
    padding-bottom:30px;
}
.input-group-prepend span{
    width: 100px;
}
.user-head{
    margin-bottom:15px;
    
}

.user-head .user-title{
    vertical-align: middle;
   font-size:18px;
}

.shade{
    display: none;
}

@media screen and (max-width:768px) {
    .user-left{
        width:200px;
        position:absolute;
        background: #fff;
        z-index:3;
        left:-200px;
        
    }
    .user-right{
        position: relative;
    }
    
    .shade{
        
        width:100%;
        height:100%;
        position: absolute;
        background: #212529;
        opacity: .5;
        z-index:2;
    }
}

</style>
<script>


</script>
<div class="container">
    <div class="row">
      <div class="user-left col-md-2">
          <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="<?=$page->url()?>"><?=_t('Profile')?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?=$page->url()?>?action=security"><?=_t('Security')?></a>
          </li>
        </ul>
      </div>
      
      <div class="user-right col-md-10">
        <div class="shade"></div>
        <div class="content">
            <?php if($action == 'profile'): 
                 if(isset($_POST['profile_nonce']) && wp_verify_nonce($_POST['profile_nonce'], 'profile_nonce')){
                    $arr = [];
                    $error = '';
                    if(!empty($_POST['nicename'])){
                        $arr['display_name'] = esc_sql($_POST['nicename']);
                    }
                    if(!empty($_POST['url'])){
                        if(preg_match("/^http(s)?:\\/\\/.+/", $_POST['url'])){
                            $arr['user_url'] = esc_sql($_POST['url']);
                        }
                        else{
                            $error = _t('The url is invalid');
                        }
                    }
                    if($error){
                        echo $page->msg($error, true);
                    }
                    else{
                        if($arr){
                            if($user->update($arr)){
                                echo $page->msg(_t('Save success'));
                            }
                            else{
                                echo $page->msg(_t('Save failed'), true);
                            }
                        }
                    }
                }
            
            ?>
                
                <div class='user-head'>
                    <span class="arrow btn d-md-none"><i class="fa fa-arrow-right"></i></span>
                    <span class="user-title"><?=_t('Profile')?></span>
                </div>
                
                <form class="rounded" action="<?=$page->url()?>?action=profile" method="post">
                    <input type="hidden" name="profile_nonce" value="<?=wp_create_nonce( 'profile_nonce' );?>">
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><?=_t('Username')?></span>
                        </div>
                        <input name="username" type="text" class="form-control disabled" value="<?=$user->name()?>" disabled>
                    </div>
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><?=_t('Email')?></span>
                        </div>
                        <input name="email" type="text" class="form-control" value="<?=$user->email()?>" disabled>
                    </div>
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><?=_t('Nicename')?></span>
                        </div>
                        <input name="nicename" type="text" class="form-control" value="<?=$user->nicename()?>">
                    </div>
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><?=_t('URL')?></span>
                        </div>
                        <input name="url" type="text" class="form-control" value="<?=$user->url()??''?>">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-custom"><?=_t('Save changes')?></button>
                    </div>
                </form>
            <?php elseif($action == 'security'): 
                (function()use($user, $page){
                    if(!isset($_POST['password_nonce'])) return;
                    if(!wp_verify_nonce($_POST['password_nonce'], 'password_nonce')) return;
                    if(!$user->auth($user->name(), esc_sql($_POST['original_password']))){
                        echo $page->msg(_t('Original password error'), true);
                        return;
                    }
                    if(empty($_POST['new_password'])){
                        echo $page->msg(_t('Password cannot be empty'), true);
                        return;
                    }
                    if($_POST['new_password'] != $_POST['confirm_password']){
                        echo $page->msg(_t('Entered passwords differ'), true);
                        return;
                    }
                    wp_set_password(esc_sql($_POST['new_password']), $user->id());
                    echo $page->msg(_t('Password changed successfully'));
                })();
            ?>
                <div class='user-head'>
                    <span class="arrow btn d-md-none"><i class="fa fa-arrow-right"></i></span>
                    <span class="user-title"><?=_t('Change password')?></span>
                </div>
                <form class="rounded" action="<?=$page->url()?>?action=security" method="post">
                    <input type="hidden" name="password_nonce" value="<?=wp_create_nonce( 'password_nonce' );?>">
                    <div class="form-group">
                        <input name="original_password" type="password" class="form-control" placeholder="<?=_t('Original password')?>">
                    </div>
                    <div class="form-group">
                        <input name="new_password" type="password" class="form-control" placeholder="<?=_t('New password')?>">
                    </div>
                    <div class="form-group">
                        <input name="confirm_password" type="password" class="form-control" placeholder="<?=_t('Confirm password')?>">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-custom"><?=_t('Submit')?></button>
                    </div>
                </form>
            <?php endif;?>
        </div><!-- #content -->
      </div>
    </div>
</div>
<?php 
echo '<script type="text/javascript" src="' . STATIC_URL . '/js/user.js"></script>';
import('footer'); 
?>