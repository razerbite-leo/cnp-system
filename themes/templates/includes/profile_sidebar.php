<aside id="sidebar">
	<section id="member">
		<?php 
			$name 		= $session['firstname'] . " " . $session['lastname'];
			$username 	= strtolower(url_title($user['username']));
			$img = ($user['display_image_url'] == "" ? MEDIA_FOLDER ."images/nodefaultphoto.png" : MEDIA_FOLDER . "user/{$username}/thumb/" . $user['display_image_url']); 
		?>

		<section class="account-pic"><img src="<?php echo $img; ?>"></section>
		<ul>
			<li class="account-name">Welcome Back, <?php echo $session['firstname']; ?></li>
			<li><?php echo date("M d, Y"); ?></li>
		</ul>
	</section>

	<section id="info">
		<h3>Recent Events</h3>
		<br/>
		<div class="recent_events_sb recent_active"><a href="<?php echo url("settings/account"); ?>">Profile Settings</a> <img src="<?php echo BASE_FOLDER; ?>themes/images/settings.png"></div>
		<div class="recent_events_sb"><a href="<?php echo url("settings/user_logout"); ?>">Log Out</a></div>
	</section>

	<?php if($session['account_type'] == FIRM_ADMIN) { ?>
		<nav id="side_bar_menu">
			<section id="back_to_main_link" class="accordionButton <?php echo $account_settings; ?>"><a href="<?php echo url("settings/account"); ?>" style="color:#787878 !important;">Account Settings</a></section>
		</nav>
	<?php } ?>

	<nav id="side_bar_menu">
		<section class="accordionButton <?php echo $security_settings; ?>"><a href="<?php echo url("settings/profile"); ?>" style="color:#787878 !important;">Security Settings</a></section>
		<section id="back_to_main_link" class="accordionButton"><a href="<?php echo url("user_gateway"); ?>" style="color:#787878 !important;">Back to Main</a></section>
		<!--section class="accordionButton" onClick="window.location.href='admin.html';">Manage Users</section>
		<section class="accordionButton">Documents</section-->
	</nav>
</aside>