/**
 * Login
 *
 * @package YYThemes
 */

jQuery(
	function($){

		document.onkeydown = function() {
			if (event.keyCode == 13) {
				$( ".submit" ).click();
			}
		};

		var _loginTipstimer;
		function logtips(str, success){
			if ( ! str ) {
				return false;
			}
			success = arguments[1] ? arguments[1] : false;
			if (success) {
				$( '.sign-tips' ).removeClass( 'alert-danger' );
				$( '.sign-tips' ).addClass( 'alert-success' );
			} else {
				$( '.sign-tips' ).removeClass( 'alert-success' );
				$( '.sign-tips' ).addClass( 'alert-danger' );
			}
			_loginTipstimer && clearTimeout( _loginTipstimer );
			$( '.sign-tips' ).html( str ).slideDown();
			_loginTipstimer = setTimeout(
				function(){
					$( '.sign-tips' ).slideUp();
				},
				10000
			);
		}

		$( '#login' ).on(
			'click',
			function(){

				if ( ! $( "#username" ).val() ) {
					logtips( _t( 'Username or email cannot be empty' ) );
					return;
				}

				if ( ! $( "#password" ).val() ) {
					logtips( _t( 'Password cannot be empty' ) );
					return;
				}

				var currbtn = $( this );
				currbtn.html( _t( 'Login...' ) );
				$.post(
					xenice.action + 'login',
					{
						login_nonce: xenice.nonce.login,
						username: $( "#username" ).val(),
						password: $( "#password" ).val(),
					},
					function (data) {
						if ($.trim( data ) != "1") {
							console.log( data );
							logtips( _t( 'Username or password wrong' ) );
							currbtn.html( _t( 'Login' ) );
						} else {
							if ($( ".modal" ).length) {
								location.reload();
							} else {
								location.href = xenice.url;
							}
						}
					}
				);
			}
		);

		$( "#r_username" ).bind(
			"blur",
			function(){
				var currInput = $( this );
				$.post(
					xenice.action + 'check',
					{
						username_nonce: xenice.nonce.check_username,
						username: $( "#r_username" ).val(),
					},
					function (data) {
						if ($.trim( data ) == "1") {
							currInput.next( ".sign-tip" ).remove();
						} else {
							/*currInput.focus();*/
							if (currInput.next( ".sign-tip" ).length) {
								currInput.next( ".sign-tip" ).text( data );
							} else {
								currInput.after( "<span class='sign-tip'>" + data + "</span>" );
							}
						}
					}
				);
			}
		);

		$( "#r_email" ).bind(
			"blur",
			function(){
				var currInput = $( this );
				$.post(
					xenice.action + 'check',
					{
						email_nonce: xenice.nonce.check_email,
						email: $( "#r_email" ).val()
					},
					function (data) {
						if ($.trim( data ) == "1") {
							currInput.next( ".sign-tip" ).remove();
						} else {
							/*currInput.focus();*/
							if (currInput.next( ".sign-tip" ).length) {
								currInput.next( ".sign-tip" ).text( data );
							} else {
								currInput.after( "<span class='sign-tip'>" + data + "</span>" );
							}
						}
					}
				);
			}
		);

		$( "#r_repassword" ).bind(
			"blur",
			function(){
				var currInput = $( this );
				if ($( "#r_password" ).val() == currInput.val()) {
					currInput.next( ".sign-tip" ).remove();
				} else {
					/*currInput.focus();*/
					if (currInput.next( ".sign-tip" ).length) {
						currInput.next( ".sign-tip" ).text( _t( 'Entered passwords differ' ) );
					} else {
						currInput.after( "<span class='sign-tip'>" + _t( 'Entered passwords differ' ) + "</span>" );
					}
				}
			}
		);

		$( '#register' ).on(
			'click',
			function(){
				if ( ! is_check_name( $( "#r_username" ).val() ) ) {
					logtips( _t( 'Username can only be 6-16 characters composed of alphanumeric or underlined characters' ) );
					return;
				}

				if ( ! is_check_mail( $( "#r_email" ).val() ) ) {
					logtips( _t( 'Email format error' ) );
					return;
				}

				if ( $( "#r_password" ).val().length < 6 ) {
					logtips( _t( 'Password length at least 6' ) );
					return;
				}

				if ( ! $( "#r_captcha" ).val() ) {
					logtips( _t( 'The captcha cannot be empty' ) );
					return;
				}

				var currbtn = $( this );
				currbtn.html( _t( "Register..." ) );
				$.post(
					xenice.action + 'register',
					{
						register_nonce: xenice.nonce.register,
						username: $( "#r_username" ).val(),
						email: $( "#r_email" ).val(),
						password: $( "#r_password" ).val(),
						repassword: $( "#r_repassword" ).val(),
						captcha: $( "#r_captcha" ).val(),
					},
					function (data) {
						if ($.trim( data ) == "1") {
							currbtn.html( _t( "Registered successfully" ) );
							setTimeout(
								function(){
									if ($( ".modal" ).length) {
										location.reload();
									} else {
										location.href = xenice.url;
									}
								},
								1000
							);
						} else {
							logtips( data );
							currbtn.html( _t( "Register" ) );
						}
					}
				);
			}
		);

		$( '#forget_password' ).on(
			'click',
			function(){
				if ( ! $( "#fp_username" ).val() ) {
					logtips( _t( 'Username or email cannot be empty' ) );
					return;
				}
				if ( ! $( "#fp_captcha" ).val() ) {
					logtips( _t( 'The captcha cannot be empty' ) );
					return;
				}
				var currbtn = $( this );
				currbtn.html( _t( "execute..." ) );
				$.post(
					xenice.action + 'forgetPassword',
					{
						forget_password_nonce: xenice.nonce.forget_password,
						username: $( "#fp_username" ).val(),
						captcha: $( "#fp_captcha" ).val(),

					},
					function (data) {
						if ($.trim( data ) == "1") {
							$( "form" ).remove();
							$( ".success-tips" ).html( _t( 'The link has been successfully sent to your email, please check and confirm.' ) ).slideDown();
						} else {
							logtips( data );
							$( "#fp_captcha_image" ).trigger( "click" );
							currbtn.html( _t( 'Get New Password' ) );
						}
					}
				);
			}
		);

		$( '#reset_password' ).on(
			'click',
			function(){
				if ( ! $( "#rp_captcha" ).val() ) {
					logtips( _t( 'The captcha cannot be empty' ) );
					return;
				}

				if ( $( "#rp_password" ).val().length < 6 ) {
					logtips( _t( 'Password length at least 6' ) );
					return;
				}

				if ( $( "#rp_password" ).val() != $( "#rp_repassword" ).val()) {
					logtips( _t( 'Entered passwords differ' ) );
					return;
				}
				var currbtn = $( this );
				currbtn.html( _t( "execute..." ) );
				$.post(
					xenice.action + 'resetPassword',
					{
						reset_password_nonce: xenice.nonce.reset_password,
						captcha: $( "#rp_captcha" ).val(),
						password: $( "#rp_password" ).val(),
						repassword: $( "#rp_repassword" ).val(),
						username: $( "#rp_username" ).val(),
						key: $( "#rp_key" ).val()
					},
					function (data) {
						if ($.trim( data ) == "1") {
							$( "form" ).remove();
							$( ".success-tips" ).html( _t( 'Password changed successfully, please remember the password.' ) ).slideDown();
						} else {
							logtips( data );
							$( "#rp_captcha_image" ).trigger( "click" );
							currbtn.html( _t( 'Change password' ) );
						}
					}
				);
			}
		);

		$( '#r_captcha_clk' ).bind(
			'click',
			function(){

				var captcha = $( this );

				if (captcha.hasClass( "disabled" )) {

					logtips( _t( 'Your operation too fast, please wait a moment.' ) );

				} else {

					captcha.addClass( "disabled" );

					captcha.html( _t( "Send in..." ) );

					$.post(
						xenice.action + 'captcha&rand=' + Math.random(),
						{
							email_nonce: xenice.nonce.send_captcha,
							email:$( "#r_email" ).val()
						},
						function (data) {
							if ($.trim( data ) == "1") {
								logtips( _t( 'Captcha has been sent to the email, may appear in the dustbin oh ~' ), true );
								var countdown = 60;
								settime( captcha );
								function settime() {
									if (countdown === 0) {
										captcha.removeClass( "disabled" );
										captcha.html( _t( "Resend captcha" ) );
										countdown = 60;
										return;
									} else {
										captcha.addClass( "disabled" );
										captcha.html( _t( "Resend captcha" ) + "(" + countdown + ")" );
										countdown--;
									}
									setTimeout( function() { settime() },1000 )

								}
							} else if ($.trim( data ) == "2") {
								logtips( _t( 'Email already exists' ) );
								captcha.html( _t( "Send captcha" ) );
								captcha.removeClass( "disabled" );
							} else {
								console.log( data );
								logtips( _t( 'The captcha failed to send. Please try again later.' ) );
								captcha.html( _t( "Send captcha" ) );
								captcha.removeClass( "disabled" );
							}

						}
					);

				}

			}
		);

	}
);
