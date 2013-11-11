<?php include('header.php'); ?>
<!--[if gte IE 9]>
  <style type="text/css">
	.gradient {
	   filter: none;
	}
  </style>
<![endif]-->

<script>
	$(function() {
		reload_content();
	});
</script>
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
			<div id="account_settings_topbar" class="firm_admin_topbar active-bar hidden"><?php include("includes/firm_account_settings_topbar.php"); ?></div>
			<div id="manage_users_topbar" class="firm_admin_topbar hidden"><?php include("includes/manage_users_topbar.php"); ?></div>
			<div id="add_user_topbar" class="firm_admin_topbar hidden"><?php include("includes/add_user_topbar.php");  ?></div>
			<div id="edit_user_topbar" class="firm_admin_topbar ghost_top_bar hidden"><?php include("includes/edit_user_topbar.php");  ?></div>
			<div id="manage_document_topbar" class="firm_admin_topbar active-bar hidden"><?php include("includes/manage_document_topbar.php"); ?></div>
			<div id="add_document_topbar" class="firm_admin_topbar active-bar hidden"><?php include("includes/add_document_topbar.php"); ?></div>
			<div id="edit_document_topbar" class="firm_admin_topbar active-bar hidden"><?php include("includes/edit_document_topbar.php"); ?></div>
		</section>
		
		<section id="main_wrapper">
			<?php include("includes/firm_admin_sidebar.php"); ?>

			<section id="content">
				<!--div class="line"></div-->
				<br>

				<!-- content for views -->
				
