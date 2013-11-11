<?php include('themes/templates/header.php'); ?>

<script>
	function create_case() {
		window.location.href = base_url + "cases/create";
	}

	function log_out() {
		window.location.href = base_url + "logout";
	}
</script>
<body>
	<section id="wrapper">
		<header>
			<?php
				$firm_name 	= strtolower(url_title($firm['firm_name']));
				$img 		= ($firm['firm_logo_url'] == "" ? BASE_FOLDER ."themes/images/logo.png" : MEDIA_FOLDER . "firm/{$firm_name}/resize/" . $firm['firm_logo_url']); 
			?>
			<a href="<?php echo url("user_gateway"); ?>"><img class="case_logo_holder" src="<?php echo $img; ?>"></a>
		</header>
		<section id="signincontent">
			
			<ul class="divider">
				<li class="welcome"><h1>Welcome Back, <?php echo $user['firstname']; ?></h1><br>
					What do you want to do?</li>
			</ul><!--divider-->
			
			<button class="admin" type="button" onclick="javascript:create_case();">Add New Case</button>
			<button class="admin" type="button" onclick="">Access Current Cases</button>
			<button class="admin" type="button" onclick="javascript:log_out();">Log Out</button>
		</section>
	</section>
	<footer>
		<ul class="copyright">
			<li>Copyright ©2012-2013, Case Notepad</li>
			<li><a href="#">Privacy Policy</a></li>
			<li><a href="#">Terms & Conditions</a></li>
		</ul>
	</footer>
</body>