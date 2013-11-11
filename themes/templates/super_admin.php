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
			<section class="logo" alt="casenotespad.com"><a href="<?php echo url("user_gateway"); ?>">
				<img src="<?php echo BASE_FOLDER; ?>themes/images/logo.png" ></a>
			</section>
			<div id="manage_users_topbar" class="super_admin_topbar active-bar hidden"><?php include("includes/manage_users_topbar.php"); ?></div>
			<div id="add_user_topbar" class="super_admin_topbar hidden"><?php include("includes/add_user_topbar.php");  ?></div>
			<div id="edit_user_topbar" class="super_admin_topbar ghost_top_bar hidden"><?php include("includes/edit_user_topbar.php");  ?></div>
			<div id="manage_firm_topbar" class="super_admin_topbar hidden"><?php include("includes/firm_accounts_topbar.php");  ?></div>
			<div id="add_firm_topbar" class="super_admin_topbar hidden"><?php include("includes/add_firm_account.php");  ?></div>
			<div id="edit_firm_topbar" class="super_admin_topbar ghost_top_bar hidden"><?php include("includes/edit_firm_account.php");  ?></div>
			<div id="manage_document_topbar" class="super_admin_topbar active-bar hidden"><?php include("includes/manage_document_topbar.php"); ?></div>
			<div id="edit_document_topbar" class="super_admin_topbar active-bar hidden"><?php include("includes/edit_document_topbar.php"); ?></div>
		</section>
		
		<section id="main_wrapper">
			<?php include("includes/super_admin_sidebar.php"); ?>

			<section id="content">
				<!--div class="line"></div-->
				<br>

				<!-- content for views -->
				
