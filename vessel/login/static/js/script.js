jQuery(function($){

	document.onkeydown = function() {
		if (event.keyCode == 13) {
			$(".submit").click();
		}
	};

	var _loginTipstimer;
	function logtips(str, success){
		if( !str ) return false;
		success = arguments[1] ? arguments[1] : false;
		if(success){
		    $('.sign-tips').removeClass('alert-danger');
            $('.sign-tips').addClass('alert-success');
		}
		else{
		    $('.sign-tips').removeClass('alert-success');
            $('.sign-tips').addClass('alert-danger');
		}
		_loginTipstimer && clearTimeout(_loginTipstimer);
		$('.sign-tips').html(str).slideDown();
		_loginTipstimer = setTimeout(function(){
			$('.sign-tips').slideUp();
		}, 10000);
	}

	$('#login').on('click', function(){
											
		if( !$("#username").val() ){
			logtips(xenice_login_t('Username or email cannot be empty'));
			return;
		}
		
		if( !$("#password").val() ){
			logtips(xenice_login_t('Password cannot be empty'));
			return;
		}
		
		var currbtn = $(this);
		currbtn.html(xenice_login_t('Login...'));
		$.post(
			xenice_login_action_url + 'login',
			{
			    login_nonce: xenice_login_nonce.login,
				username: $("#username").val(),
				password: $("#password").val(),
			},
			function (data) {
				if ($.trim(data) != "1") {
				    console.log(data);
					logtips(xenice_login_t('Username or password wrong'));
					currbtn.html(xenice_login_t('Login'));
				}
				else {
				    if($(".modal").length){
				        location.reload(); 
				    }
					else{
					    location.href=xenice_login_home_url; 
					}           
				}
			}
		);
	});
	
	$("#r_username").bind("blur",function(){
		var currInput = $(this);		
		$.post(
			xenice_login_action_url + 'check',
			{
			    username_nonce: xenice_login_nonce.check_username,
				username: $("#r_username").val(),
			},
			function (data) {
				if ($.trim(data) == "1") {
					currInput.next(".sign-tip").remove();
				}else {
					/*currInput.focus();*/
					if(currInput.next(".sign-tip").length){
						currInput.next(".sign-tip").text(data);
					}else{
						currInput.after("<span class='sign-tip'>"+data+"</span>");
					}
				}
			}
		);	
	});
	
	$("#r_email").bind("blur",function(){
		var currInput = $(this);		
		$.post(
			xenice_login_action_url + 'check',
			{
			    email_nonce: xenice_login_nonce.check_email,
				email: $("#r_email").val()
			},
			function (data) {
				if ($.trim(data) == "1") {
					currInput.next(".sign-tip").remove();
				}else {
					/*currInput.focus();*/
					if(currInput.next(".sign-tip").length){
						currInput.next(".sign-tip").text(data);
					}else{
						currInput.after("<span class='sign-tip'>"+data+"</span>");
					}
				}
			}
		);	
	});
	
	$("#r_repassword").bind("blur",function(){
		var currInput = $(this);
		if ($("#r_password").val() == currInput.val()) {
			currInput.next(".sign-tip").remove();
		}else {
			/*currInput.focus();*/
			if(currInput.next(".sign-tip").length){
				currInput.next(".sign-tip").text(xenice_login_t('Entered passwords differ'));
			}else{
				currInput.after("<span class='sign-tip'>"+xenice_login_t('Entered passwords differ')+"</span>");
			}
		}
	});
	
	$('#register').on('click', function(){
		if( !xenice_login_check_name($("#r_username").val()) ){
			logtips(xenice_login_t('Username can only be 6-16 characters composed of alphanumeric or underlined characters'));
			return;
		}
		
		if( !xenice_login_check_mail($("#r_email").val()) ){
			logtips(xenice_login_t('Email format error'));
			return;
		}

		if( $("#r_password").val().length < 6 ){
			logtips(xenice_login_t('Password length at least 6'));
			return;
		}
		

		if( !$("#r_captcha").val() ){
			logtips(xenice_login_t('The captcha cannot be empty'));
			return;
		}
		
		var currbtn = $(this);				
		currbtn.html(xenice_login_t("Register..."));
		$.post(
			xenice_login_action_url+'register',
			{
			    register_nonce: xenice_login_nonce.register,
				username: $("#r_username").val(),
				email: $("#r_email").val(),
				password: $("#r_password").val(),
				repassword: $("#r_repassword").val(),
				captcha: $("#r_captcha").val(),
			},
			function (data) {
				if ($.trim(data) == "1") {
				    currbtn.html(xenice_login_t("Registered successfully"));
				    setTimeout(function(){
				        if($(".modal").length){
    				        location.reload(); 
    				    }
    					else{
    					    location.href= xenice_login_home_url; 
    					}
				    },1000);
				}
				else {
					logtips(data);
					currbtn.html(xenice_login_t("Register"));
				}
			}
		);										   
	});
	
	$('#forget_password').on('click', function(){
		if( !$("#fp_username").val() ){
			logtips(xenice_login_t('Username or email cannot be empty'));
			return;
		}
	    if( !$("#fp_captcha").val() ){
			logtips(xenice_login_t('The captcha cannot be empty'));
			return;
		}
		var currbtn = $(this);				
		currbtn.html(xenice_login_t("execute..."));
		$.post(
			xenice_login_action_url+'forgetPassword',
			{
			    forget_password_nonce: xenice_login_nonce.forget_password,
				username: $("#fp_username").val(),
				captcha: $("#fp_captcha").val(),
				
			},
			function (data) {
				if ($.trim(data) == "1") {
					$("form").remove();
					$(".success-tips").html(xenice_login_t('The link has been successfully sent to your email, please check and confirm.')).slideDown();
				}
				else {
					logtips(data);
					$("#fp_captcha_image").trigger("click");
					currbtn.html(xenice_login_t('Get New Password'));
				}
			}
		);								   
	});
	
	$('#reset_password').on('click', function(){
	    if( !$("#rp_captcha").val() ){
			logtips(xenice_login_t('The captcha cannot be empty'));
			return;
		}
		
		if( $("#rp_password").val().length < 6 ){
			logtips(xenice_login_t('Password length at least 6'));
			return;
		}
		
		if( $("#rp_password").val() != $("#rp_repassword").val()){
			logtips(xenice_login_t('Entered passwords differ'));
			return;
		}
		var currbtn = $(this);
		currbtn.html(xenice_login_t("execute..."));
		$.post(
			xenice_login_action_url+'resetPassword',
			{
			    reset_password_nonce: xenice_login_nonce.reset_password,
			    captcha: $("#rp_captcha").val(),
				password: $("#rp_password").val(),
				repassword: $("#rp_repassword").val(),
				username: $("#rp_username").val(),
				key: $("#rp_key").val()
			},
			function (data) {
				if ($.trim(data) == "1"){
					$("form").remove();
					$(".success-tips").html(xenice_login_t('Password changed successfully, please remember the password.')).slideDown();
				}
				else {
					logtips(data);
					$("#rp_captcha_image").trigger("click");
					currbtn.html(xenice_login_t('Change password'));
				}
			}
		);								   
	});

	$('#r_captcha_clk').bind('click',function(){

		var captcha = $(this);

		if(captcha.hasClass("disabled")){

			logtips(xenice_login_t('Your operation too fast, please wait a moment.'));

		}else{

			captcha.addClass("disabled");

			captcha.html(xenice_login_t("Send in..."));

			$.post(

				xenice_login_action_url+'captcha&rand='+Math.random(),
				{
				    email_nonce: xenice_login_nonce.send_captcha,
					email:$("#r_email").val()
				},

				function (data) {
					if($.trim(data) == "1"){
						logtips(xenice_login_t('Captcha has been sent to the email, may appear in the dustbin oh ~'), true);
						var countdown=60; 
						settime(captcha);
						function settime() { 
                        	if (countdown === 0) {
                        		captcha.removeClass("disabled");   
                        		captcha.html(xenice_login_t("Resend captcha"));
                        		countdown = 60; 
                        		return;
                        	} else { 
                        		captcha.addClass("disabled");
                        		captcha.html(xenice_login_t("Resend captcha") + "(" + countdown + ")");
                        		countdown--;
                        	} 
                        	setTimeout(function() { settime() },1000) 
                        
                        }
					}
					else if($.trim(data) == "2"){
						logtips(xenice_login_t('Email already exists'));
						captcha.html(xenice_login_t("Send captcha"));
						captcha.removeClass("disabled"); 
					}
					else{
					    console.log(data);
						logtips(xenice_login_t('The captcha failed to send. Please try again later.'));
						captcha.html(xenice_login_t("Send captcha"));
						captcha.removeClass("disabled"); 
					}

				}

			);

		}

	});

});