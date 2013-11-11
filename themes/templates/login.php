<?php include('header.php'); ?>
<?php ?>
<script>
	function show_login_form() {
		$('#forgot_form_wrapper').hide();
		$('#login_form_wrapper').show();
	}

	function show_forgot_form() {
		$('#login_form_wrapper').hide();
		$('#forgot_form_wrapper').show();
	}

	$(function() {
		$('#username').focus();
		$("#password").live('keyup', function(e) {
		 	if(e.keyCode == 13) {
		 		$('#signinform').submit();
		 	}
		});

		$('#password_recovery_form').ajaxForm({
			success:function(o) {
				$('#email_address_forgot').val("");
				show_login_form();
				default_success_confirmation({alert_type: "alert-success", message: "Password recovery link has been sent. Please check your email."});
			},
			//dataType : "json"

		});
	});
</script>
<?php echo $error_message; ?>
<body>
	<section id="wrapper">
		<header>
			
		</header>
		<section id="signincontent">
			<ul class="header">
				<li>
					<?php if($firm['firm_logo_url']) { ?>
					<?php $img 	= ($firm['firm_logo_url'] == "" ? BASE_FOLDER ."themes/images/RZRLGO.png" : MEDIA_FOLDER . "images/firm/" . $firm['firm_logo_url']); ?>	
						<img class="login_logo_branding_holder" src="<?php echo $img; ?>">
					<?php } ?>
				</li>
			</ul>
			
			<div id="login_form_wrapper">
				<ul class="divider">
					<li><img src="<?php echo BASE_FOLDER; ?>themes/images/cnp-main-logo.png"></li>
					<li class="signindash"><img src="<?php echo BASE_FOLDER; ?>themes/images/signindash.png"></li>
					<li><h1>Welcome Back</h1></li>
					<li class="signindash"><img src="<?php echo BASE_FOLDER; ?>themes/images/signindash.png"></li>
				</ul><!--divider-->
				<form id="signinform" name="signinform" class="signinform" method="post" action="<?php echo url("login/authenticate_account"); ?>">
					<?php $style = ($is_username == true ? 'display:none;' : ''); ?>
					<div style="<?php echo $style; ?>">
						<label>Email Address</label>
						
						<input type="text" id="username" name="username" class="signintextfield" value="<?php echo $logged_user['username']; ?>" />
						<br>
						<br>
					</div>
					<label>PASSWORD</label>
					<input type="password" id="password" name="password" class="signintextfield"/>
					<a class="signinbutton" type="submit" href="javascript:void(0);" onclick="$('#signinform').submit();">SIGN IN</a>
				</form>
				
				<ul id="forgot">
					<li>Forgot your Email Address or Password?</li>
					<li><button class="click" onClick="javascript:show_forgot_form();">Click Here</button></li>
				</ul>
			</div>

			<div id="forgot_form_wrapper" style="display:none;">
				<ul class="divider">
					<li><img src="<?php echo BASE_FOLDER; ?>themes/images/cnp-main-logo.png"></li>
					<li class="signindash"><img src="<?php echo BASE_FOLDER; ?>themes/images/signindash.png"></li>
					<li><h3>Forgot Password</h3></li>
					<li class="signindash"><img src="<?php echo BASE_FOLDER; ?>themes/images/signindash.png"></li>
				</ul><!--divider-->
				<br/>
				<form id="password_recovery_form" name="signinform" class="signinform" method="post" action="<?php echo url("login/forgot_password"); ?>">
					<label>Email address</label>
					<input type="text" id="email_address_forgot" name="username" class="signintextfield"/>
					<button class="forgot_submit" onSubmit="window.location.href='insurance.html';">submit</button> or
					<a href="javascript:void(0);" onclick="javascript:show_login_form();">Go back</a>
					<!--
					<ul>
						<li><button class="submit" onSubmit="window.location.href='insurance.html';">submit</button></li>
						<li>or</li>
						<li><a href="javascript:void(0);" onclick="javascript:show_login_form();">Go back</a></li>
					</ul>
					-->
				</form>

				<br/>
				<br/>
				<br/>
				<br/>
				<br/>
			</div>
		</section>
		<section class="push"></section>
		
	</section>
	<footer>
		<ul class="copyright">
			<li>Copyright ©2012-2013, Case Notepad</li>
			<li><a href="#">Privacy Policy</a></li>
			<li><a href="#">Terms & Conditions</a></li>
		</ul>
	</footer>	
</body>
</html>
