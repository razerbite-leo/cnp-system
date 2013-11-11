<?php include('themes/templates/profile.php'); ?>



<section class="data">
	<form id="form">
		<h4>General Profile Information</h4>
		
		<section id="form02">
			<p>Photo</p>
			<ul>
				<li><img width="150px" height="150px" ;="" src="<?php echo BASE_FOLDER; ?>themes/images/photo.png"></li>
				<!--li><input type="file" name="file"></li-->
			</ul>
		</section>
			
		<section class="clear"></section>
		
			<p>Name</p>
			<div class="filled"><?php echo $user['firstname'] . " " . $user['lastname']; ?></div>
			
		<section class="clear"></section>

			<p>Username</p>
			<div class="filled"><?php echo $user['username']; ?></div>
		
		<section class="clear"></section>
		
			<p>Name of Firm</p>
			<div class="filled">
				<?php
					$firm_id 	= $user['firm_id'];
					$firm 		= Firm::findById($firm_id);
					echo $firm['firm_name']
				?>
			</div>
		
		<section class="clear"></section>
		
			<p>Email Address</p>
			<div class="filled"><?php echo $user['email_address']; ?></div>
		
		<section class="clear"></section>
		
			<p>Account Status</p>
			<div class="filled"><?php echo $user['account_status']; ?></div>
			
		<section class="clear"></section>
		
			<p>Type Password</p>
			<div class="filled"><?php echo (!$user['last_change_password'] ? "You haven't changed your password yet" : date("Y-m-d H:i:s",strtotime($user['last_change_password']))); ?></div>
			
	</form>
</section>














<?php include('themes/templates/footer/profile.php'); ?>
