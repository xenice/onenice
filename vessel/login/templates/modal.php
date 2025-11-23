<?php
defined( 'ABSPATH' ) || exit;
?>
<div class='user-login'>
 <!-- Login-modal -->
  <div class="modal fade" id="login-modal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
            <ul class="nav justify-content-center">
                <li class="nav-item">
                  <span class="nav-link active"><?php esc_html_e('Login', 'onenice')?></span>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="javascript:;" id="register-trigger"><?php esc_html_e('Register', 'onenice')?></a>
                </li>
            </ul>
            <div class="sign-tips alert alert-danger"></div>
            <form >
                <div class="form-group">
                    <input id="username" type="text" class="form-control" name="username" placeholder="<?php esc_attr_e('Username or Email', 'onenice')?>">
                </div>
                <div class="form-group">
                    <input id="password" type="password" class="form-control" name="password" placeholder="<?php esc_attr_e('Password', 'onenice')?>" autocomplete >
                </div>
                <div class="form-group">
                    <button id="login" type="button" class="btn btn-custom"><?php esc_html_e('Login', 'onenice')?></button>
                </div>
                <div style="font-size:12px;text-align:right">
                    <a href="<?php echo wp_login_url()?>?action=forget_password" id="forget-password-trigger" class="forget-password"><?php esc_html_e('Forget password?', 'onenice')?></a>
                </div>
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
                  <a class="nav-link" href="javascript:;" id="login-trigger"><?php esc_html_e('Login', 'onenice')?></a>
              </li>
              <li class="nav-item">
                  <span class="nav-link active" ><?php esc_html_e('Register', 'onenice')?></span>
              </li>
            </ul>
            <div class="sign-tips alert"></div>
            <form >
                <div class="form-group">
                    <input id="r_username" type="text" class="form-control" name="username" placeholder="<?php esc_attr_e('Username', 'onenice')?>">
                </div>
                <div class="form-group">
                    <input id="r_email" type="text" class="form-control" name="email" placeholder="<?php esc_attr_e('Email', 'onenice')?>">
                </div>
                <div class="form-group">
                    <input id="r_password" type="password" class="form-control" name="password" placeholder="<?php esc_attr_e('Password', 'onenice')?>" autocomplete>
                </div>
                <div class="form-group">
                    <input id="r_repassword" type="password" class="form-control" name="repassword" placeholder="<?php esc_attr_e('Confirm password', 'onenice')?>" autocomplete >
                </div>
                <div class="input-group form-group">
					<input id="r_captcha" type="text" class="form-control" id="captcha" name="captcha" placeholder="<?php esc_attr_e('Captcha', 'onenice')?>">
					<div class="input-group-append">
                        <span id="r_captcha_clk" class="input-group-text"><?php esc_html_e('Get captcha', 'onenice')?></span>
                    </div>
				</div>
                <div class="form-group">
                    <button id="register" type="button" class="btn btn-custom"><?php esc_html_e('Register', 'onenice')?></button>
                </div>
            </form>
        </div>
   
      </div>
    </div>
</div>
    <!-- #Register-modal -->
</div>
