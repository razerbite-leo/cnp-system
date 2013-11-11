<?php include('themes/templates/header.php'); ?>
	<script>
		function manage_users_url() {
			window.location.href = base_url + "firm/manage_users";
		}
	</script>
	<section id="wrapper">
		<header>
			<img src="<?php echo BASE_FOLDER; ?>themes/images/logo.png">
		</header>
		<section id="signincontent">
			
			<ul class="divider">
				<li class="welcome"><h1>Welcome Back, <?php echo $session['firstname']; ?></h1><br>
					What do you want to do?</li>
			</ul><!--divider-->
			
			<button class="admin" onclick="javascript:manage_users_url();">Manage Users</button>
			<button class="admin">Manage Firm accounts</button>
			<button class="admin">Manage Scene</button>
			<button class="admin">Manage Cases</button>
			<button class="admin">Manage Documents</button>
		</section>
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