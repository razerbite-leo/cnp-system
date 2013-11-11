<?php include('header.php'); ?>
<!--[if gte IE 9]>
  <style type="text/css">
	.gradient {
	   filter: none;
	}
  </style>
<![endif]-->

<?php if($case_notes_active) { ?>
<script>
	$(function() {
		reload_content();
	});
</script>
<?php } ?>
<?php if($viewing_user) {  ?>
	<?php $viewing_user_name = $viewing_user['firstname'] . " " . $viewing_user['lastname']; ?>
	<div class="alert alert-success"><button class="close" type="button" onclick="window.close();">Exit</button><b>You are viewing the case of <span style="color:red;"><?php echo $viewing_user_name; ?></span> as <span style="color:blue;"><?php echo $user['account_type']; ?></span></b></div>
<?php } ?>

<body>
	<section id="wrapper">
		<section id="top">
			<section class="logo" alt="casenotespad.com">
				<?php
					$firm_name 	= strtolower(url_title($firm['firm_name']));
					$img 		= ($firm['firm_logo_url'] == "" ? BASE_FOLDER ."themes/images/logo.png" : MEDIA_FOLDER . "firm/{$firm_name}/resize/" . $firm['firm_logo_url']); 
				?>
				<a href="<?php echo url("user_gateway"); ?>"><img class="logo_holder" src="<?php echo $img; ?>" ></a>
			</section>
			<section id="topbar">
				<ul id="tab">
					<li class="<?php echo $case_notes_active; ?>"><a href="<?php echo url("cases/create"); ?>">Case Notes</a></li>
					<li class="<?php echo $scene_active; ?>"><a href="#">Scene</a></li>
					<li class="<?php echo $documents_active; ?>"><a href="<?php echo url("cases/documents"); ?>">Documents</a></li>
					<li class="<?php echo $photos_active; ?>"><a href="<?php echo url("cases/photos"); ?>">Photos</a></li>
					<li><a href="#">Submit</a></li>
				</ul>
				<nav>
					<ul>
						<li class="admin">Firm Administrator</li>
						<li class="dropdown"><a class="menu" href="#">Settings</a>
							<ul>
								<li class="share">Share</li>
								<li class="photo">Take <br>Photos</li>
								<li class="settings">Settings</li>
								<li class="profile">Profile</li>
								<li class="logout"><a href="<?php echo url("logout"); ?>">Logout</a></li>
							</ul>
						</li>
					</ul>
				</nav>
				<section class="clear"></section>
			</section>
		</section>
		
		<section id="main_wrapper">
			<?php include("includes/case_sidebar.php"); ?>

			<section id="content">
				<!--div class="line"></div-->
				<br>

				<!-- content for views -->
				
