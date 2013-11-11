<?php include('header.php'); ?>
<!--[if gte IE 9]>
  <style type="text/css">
	.gradient {
	   filter: none;
	}
  </style>
<![endif]-->
<body>
	<section id="wrapper">
		<section id="top">
			<section class="logo" alt="casenotespad.com">
				<?php

					if($session['account_type'] == SUPER_ADMIN) {
						$img = BASE_FOLDER ."themes/images/logo.png";
					} else {
						$firm_name 	= strtolower(url_title($firm['firm_name']));
						$img 	= ($firm['firm_logo_url'] == "" ? BASE_FOLDER ."themes/images/logo.png" : MEDIA_FOLDER . "firm/{$firm_name}/resize/" . $firm['firm_logo_url']); 
						$class 	= "logo_holder";
					}
					
				?>
				<a href="<?php echo url("user_gateway"); ?>"><img class="<?php echo $class; ?>" src="<?php echo $img; ?>" ></a>
			</section>
			<section id="topbar">
				<?php if($security_settings) { ?>
					<h1>My Profile</h1>
					<ul class="topbar-icons">
						<li><a id="edit_profile_settings" class="icon" title="edit"><img src="<?php echo BASE_FOLDER; ?>themes/images/icon-edit.png"></a></li>
					</ul>
					<ul id="edit_profile_icon" class="topbar-icons hidden">
						<li><a href="javascript:void(0);" onclick="$('#edit_user_form').submit();" class="icon" title="Save"><img src="<?php echo BASE_FOLDER; ?>themes/images/icon-save.png"></a></li>
						<li style="margin: 0 5px 0 5px; text-align: center;"><img src="<?php echo BASE_FOLDER; ?>themes/images/line.png" ></li>
						<li><a href="<?php echo url("settings/profile"); ?>" id="edit_profile_settings" class="icon" title="delete"><img src="<?php echo BASE_FOLDER; ?>themes/images/icon-cancel.png"></a></li>
					</ul>
				<?php } ?>

				<?php if($account_settings) { ?>
					<h1>My Account Settings</h1>
					<ul class="topbar-icons">
						<li><a id="edit_profile_settings" title="Save" class="icon" onclick="$('#edit_firm_form').submit();"><img src="<?php echo BASE_FOLDER; ?>themes/images/icon-save.png"></a></li>
					</ul>
				<?php } ?>
			</section>
		</section>
		
		<section id="main_wrapper">
			<?php include("includes/profile_sidebar.php"); ?>
			
			<section id="content">
				<!--div class="line"></div-->
				<br>

				<!-- content for views -->
				
