<?php if(!$user->login()):?>
 <!-- Login-modal -->
  <div class="modal fade" id="login-modal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
            <ul class="nav justify-content-center">
                <li class="nav-item">
                  <span class="nav-link active"><?=_t('Login')?></span>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="javascript:;" id="register-trigger"><?=_t('Register')?></a>
                </li>
            </ul>
            <div class="sign-tips alert alert-danger"></div>
            <form >
                <div class="form-group">
                    <input id="username" type="text" class="form-control" name="username" placeholder="<?=_t('Username or Email')?>">
                </div>
                <div class="form-group">
                    <input id="password" type="password" class="form-control" name="password" placeholder="<?=_t('Password')?>">
                </div>
                <div class="form-group">
                    <button id="login" type="button" class="btn btn-custom"><?=_t('Login')?></button>
                </div>
                <?=$template->socialLogin()?>
                <?php if($login = $page->first('login')): ?>
                <div style="font-size:12px;text-align:right">
                    <a href="<?=$login->url()?>?action=forget_password" id="forget-password-trigger" class="forget-password"><?=_t('Forget password?')?></a>
                </div>
                <?php endif; ?>
            </form>
        </div>
   
      </div>
    </div>
</div>
<!-- #Login-modal -->
<!-- Register-modal -->
  <div class="modal fade" id="register-modal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
            <ul class="nav justify-content-center">
              <li class="nav-item">
                  <a class="nav-link" href="javascript:;" id="login-trigger"><?=_t('Login')?></a>
              </li>
              <li class="nav-item">
                  <span class="nav-link active" ><?=_t('Register')?></span>
              </li>
            </ul>
            <div class="sign-tips alert alert-danger"></div>
            <form >
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
					<input id="r_captcha" type="text" class="form-control" id="captcha" name="captcha" placeholder="<?=_t('Captcha')?>">
					<div class="input-group-append">
                        <span id="r_captcha_clk" class="input-group-text"><?=_t('Get captcha')?></span>
                    </div>
				</div>
                <div class="form-group">
                    <button id="register" type="button" class="btn btn-custom"><?=_t('Register')?></button>
                </div>
                <?=$template->socialLogin()?>
            </form>
        </div>
   
      </div>
    </div>
</div>
<!-- #Register-modal -->
<?php
$template->js .= <<<js
function cutModal(id1, id2)
{
    $(id1).removeClass('fade');
    $(id1).modal('hide');
    $(id1).addClass('fade');
    $(id2).modal('show');
}

$("#login-trigger").on('click',function(){
    cutModal('#register-modal', '#login-modal');
});

$("#register-trigger").on('click',function(){
    cutModal('#login-modal', '#register-modal');
});

$("#forget-password-trigger").on('click',function(){
    cutModal('#login-modal', '#forget-password-modal');
});

js;

?>
<?php endif; ?>
