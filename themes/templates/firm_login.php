<?php include('header.php'); ?>
<script>
	function show_login_form() {
		$('#forgot_form_wrapper').hide();
		$('#login_form_wrapper').show();
	}

	function show_forgot_form() {
		$('#login_form_wrapper').hide();
		$('#forgot_form_wrapper').show();
	}
</script>

<body>
	<section id="wrapper">
		<header>
			<img src="<?php echo BASE_FOLDER; ?>themes/images/logo.png">
		</header>
		<section id="signincontent">
			<ul class="header">
				<li><img src="<?php echo BASE_FOLDER; ?>themes/images/RZRLGO.png"></li>
			</ul>
			
			<div id="login_form_wrapper">
				<ul class="divider">
					<li class="signindash"><img src="<?php echo BASE_FOLDER; ?>themes/images/signindash.png"></li>
					<li><h1>Welcome Back</h1></li>
					<li class="signindash"><img src="<?php echo BASE_FOLDER; ?>themes/images/signindash.png"></li>
				</ul><!--divider-->
				
				<form class="signinform" id="signinform" name="signinform" method="post" action="<?php echo url("login/authenticate_account"); ?>">
					<label>USERNAME</label>
					<input type="text" id="username" name="username" class="signintextfield" value="" />
					<br>
					<br>
					<label>PASSWORD</label>
					<input type="password" id="password" name="password" class="signintextfield"/>
					<a class="signinbutton" type="submit" href="javascript:void(0);" onclick="$('#signinform').submit();">SIGN IN</a>
				</form>
				
				<ul id="forgot">
					<li>Forgot your Username or Password?</li>
					<li><button class="click" onClick="javascript:show_forgot_form();">Click Here</button></li>
				</ul>
			</div>

			<div id="forgot_form_wrapper" style="display:none;">
				<ul class="divider">
					<li class="signindash"><img src="images/signindash.png"></li>
					<li><h3>Input Your Email Address</h3></li>
					<li class="signindash"><img src="images/signindash.png"></li>
				</ul><!--divider-->
				
				<form class="signinform" name="signinform">
					<p>Lorem ipsum dolor sit amet. Duis eget velit id magna imperdiet porta. 
					Nunc ut lectus sed odio ultrices.</p>
					<label>Email address</label>
					<input type="text" name="username" class="signintextfield"/>
					<ul>
						<li><button class="submit" onSubmit="window.location.href='insurance.html';">submit</button></li>
						<li>or</li>
						<li><a href="javascript:void(0);" onclick="javascript:show_login_form();">Go back</a></li>
					</ul>
				</form>
			</div>
		</section>
		<section class="push"></section>
		
	</section>
	<footer>
		<ul class="copyright">
			<li>Copyright ©2012-2013, CaseNotesPad</li>
			<li><a href="#">Privacy Policy</a></li>
			<li><a href="#">Terms & Conditions</a></li>
		</ul>
	</footer>	
</body>
</html>