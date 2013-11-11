<?php include('themes/templates/profile.php'); ?>

<section class="data">
	<div id="form">
		<div id="edit_profile_form_wrapper">
			<h4>General Profile Information</h4>
			
			<section id="form02">
				<p>Photo</p>
				<?php 
					$name 		= $session['firstname'] . " " . $session['lastname'];
					$username 	= strtolower(url_title($user['username']));
					$img 		= ($user['display_image_url'] == "" ? MEDIA_FOLDER ."images/nodefaultphoto.png" : MEDIA_FOLDER . "user/{$username}/resize/" . $user['display_image_url']); 
				?>
				<ul>
					<li><img width="150px" height="150px" src="<?php echo $img; ?>"></li>
					<!--li><input type="file" name="file"></li-->
				</ul>
			</section>
				
			<section class="clear"></section>
			
			<p>Name</p>
			<div class="filled"><?php echo $user['firstname'] . " " . $user['lastname']; ?></div>
			
			<section class="clear"></section>
			
			<?php if($session['account_type'] != SUPER_ADMIN) { ?>
				<p>Name of Firm</p>
				<div class="filled">
					<?php
						$firm_id 	= $user['firm_id'];
						$firm 		= Firm::findById($firm_id);
						echo $firm['firm_name']
					?>
				</div>
				<section class="clear"></section>
			<?php } ?>

			<p>Email Address</p>
			<div class="filled"><?php echo $user['email_address']; ?></div>
			
			<section class="clear"></section>
			
			<p>Account Status</p>
			<div class="filled"><?php echo $user['account_status']; ?></div>
				
			<section class="clear"></section>
			
			<p>Type Password</p>
			<div class="filled"><?php echo (!$user['last_change_password'] ? "You haven't changed your password yet" : date("M d, Y h:i:s a",strtotime($user['last_change_password']))); ?></div>
		</div>
	</div>
</section>














<?php include('themes/templates/footer/profile.php'); ?>
