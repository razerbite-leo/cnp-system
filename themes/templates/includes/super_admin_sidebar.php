<aside id="sidebar">
	<section id="member">
		<section class="account-pic">
			<?php 
				$name 		= $session['firstname'] . " " . $session['lastname'];
				$username 	= strtolower(url_title($user['username']));
				$img 		= ($user['display_image_url'] == "" ? MEDIA_FOLDER ."images/nodefaultphoto.png" : MEDIA_FOLDER . "user/{$username}/thumb/" . $user['display_image_url']); 
			?>
			<img id="user_display_picture_sb" src="<?php echo $img; ?>" >
		</section>
		<ul>
			<li class="account-name">Welcome Back, <?php echo $session['firstname']; ?></li>
			<li><?php echo date("M d, Y"); ?></li>
		</ul>
	</section>

	<section id="info">
		<h3>Recent Events</h3>
		<ul>
			<!--<li class="updates"><a href="#">Updates</a> <sup>3</sup></li>-->
			<li class="settings"><a href="<?php echo url("settings/account"); ?>">Profile Settings</a></li>
			<li><a href="<?php echo url("logout"); ?>">Log Out</a></li>
		</ul>
	</section>
	<nav id="side_bar_menu">
		<section class="accordionButton super_admin_manage_user super_sidebar super-active">Manage Users</section>
		<section class="accordionContent">
			<button class="super_admin_add_user add_user_button">+ Add a User</button>
		</section>

		<section class="accordionButton super_admin_firm_accounts super_sidebar">Firm Accounts</section>
		<section class="accordionContent">
			<button class="super_admin_add_firm add_user_button">+ Add a Firm</button>
		</section>

		<section class="accordionButton super_admin_cases super_sidebar">Cases</section>
			<section class="accordionContent">
				<button>+ Add a Case</button>
			</section>
		<!--<section class="accordionButton super_admin_documents super_sidebar">Documents</section>-->
		<!--<section class="accordionButton super_admin_scene_assets super_sidebar">Scene Assets</section>-->
	</nav>
</aside>