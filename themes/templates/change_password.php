<?php include('header.php'); ?>
<?php ?>
<script>
	$(function() {
		$('#username').focus();
		$("#confirm_password").live('keyup', function(e) {
		 	if(e.keyCode == 13) {
		 		$('#reset_password').submit();
		 	}
		});

		$('#reset_password').ajaxForm({
			success:function(o) {
				window.location.href = base_url + "login";
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
					<li><h3>Reset Password</h3></li>
					<li class="signindash"><img src="<?php echo BASE_FOLDER; ?>themes/images/signindash.png"></li>
				</ul><!--divider-->
				<form id="reset_password" name="signinform" class="signinform" method="post" action="<?php echo url("login/reset_password"); ?>">
					<input type="hidden" id="user_id" name="user_id" value="<?php echo $cp['user_id']; ?>">
					<input type="hidden" id="key" name="key" value="<?php echo $cp['url_key']; ?>">
	
					<label>PASSWORD</label>
					<input type="password" id="password" name="password" class="signintextfield"/>
					<br/><br/>
					<label>Confirm Password</label>
					<input type="password" id="confirm_password" name="confirm_password" class="signintextfield"/>
					<a class="signinbutton" type="submit" href="javascript:void(0);" onclick="$('#reset_password').submit();" style="width:250px !important;">Reset Password</a>
				</form>
				
				<br>
				<br>
				<br>
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
