<?php 
	$name 		= $session['firstname'] . " " . $session['lastname'];
	$username 	= strtolower(url_title($user['username']));
	$img 		= ($user['display_image_url'] == "" ? MEDIA_FOLDER ."images/nodefaultphoto.png" : MEDIA_FOLDER . "user/{$username}/thumb/" . $user['display_image_url']); 
?>

<aside id="sidebar">
	<section id="member">
		<section class="account-pic"><img src="<?php echo $img; ?>"></section>
		<ul>
			<li class="account-name">Welcome Back</li>
			<li><?php echo $name; ?></li>
		</ul>
	</section>

	<section id="info">
		<h3>Recent Events</h3>
		<ul>
			<!--<li class="updates"><a href="#">Updates</a> <sup>3</sup></li>-->
			<li class="settings"><a href="<?php echo url("settings/account"); ?>">Profile Settings</a></li>
			<li class=""><a href="<?php echo url("logout"); ?>">Log Out</a></li>
		</ul>
	</section>
	<nav id="side_bar_menu">
		<!--<section class="accordionButton firm_account_settings super_sidebar super-active">Account Settings</section>-->
		<section class="accordionButton firm_admin_manage_user super_sidebar">Manage Users</section>
			<section class="accordionContent">
				<button class="firm_admin_add_user add_user_button">+ Add a User</button>
			</section>
		<section class="accordionButton firm_admin_cases super_sidebar">Cases</section>
			<section class="accordionContent">
				<button>+ Add a Case</button>
			</section>
		<section class="accordionButton firm_admin_documents super_sidebar">Documents</section>
	</nav>
</aside>

