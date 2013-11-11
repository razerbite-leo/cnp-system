<script>
	$(function() {

		$('.topbar-icons').hide();
		$('.tipsy-inner').remove();
		$('#edit_profile_icon').show();
		$("#edit_user_form").validationEngine({scroll:false});
		$("#edit_user_form").ajaxForm({
            success: function(o) {
          		if(o.is_successful) {
          			default_success_confirmation({message : o.message, alert_type: "alert-success"});
          		} else {
          			default_success_confirmation({message : o.message, alert_type: "alert-error"});
          		}

          		$('html,body').animate({scrollTop: $("#alert_confirmation_wrapper").offset().top},10);
            },
            beforeSubmit: function(o) {
            	if(!EDIT_USER_EMAIL_ADDRESS_VALID) {
            		default_success_confirmation({message : "Error : Cannot save the current data. Please make sure that the username and email address fields is entered correctly!", alert_type: "alert-error"});
            		return false;
            	}
            },
            dataType : "json"
        });

        upload_user_photo();
	});
</script>

<section id="form" class="data">
	<form id="edit_user_form" name="edit_user_form" method="post" action="<?php echo url("settings/save_profile"); ?>" enctype="multipart/form-data">
		<input type="hidden" id="id" name="id" value="<?php echo $user['id']; ?>">
		<input type="hidden" id="user_id" name="user_id" value="<?php echo $user['id']; ?>">
		
		<h4>General User Information</h4>

		<section id="form02">
			<?php 
				$name 		= $session['firstname'] . " " . $session['lastname'];
				$username 	= strtolower(url_title($user['username']));
				$img 		= ($user['display_image_url'] == "" ? MEDIA_FOLDER ."images/nodefaultphoto.png" : MEDIA_FOLDER . "user/{$username}/resize/" . $user['display_image_url']); 
			?>
			<p>Display Picture</p>
			<ul>
				<li>
					<div id="display_image_wrapper" class="hidden"></div>
					<input type="file" id="user_display_picture_file" name="user_display_picture_file" class="textbox02">
				</li>
				<li><img id="user_display_picture" name="user_display_picture" style="height:80px; width:80px;" src="<?php echo $img; ?>"></li>
			</ul>
		</section>
		<section class="clear"></section>

		<p>First Name<span><b>*</b></span></p>
		<input type="text" id="firstname" name="firstname" class="textbox validate[required]" value="<?php echo $user['firstname']; ?>" >
		
		<section class="clear"></section>
		<p>Middle Name</p>
		<input type="text" id="middlename" name="middlename" class="textbox" value="<?php echo $user['middlename']; ?>">
			
		<section class="clear"></section>

		<p>Last Name<span><b>*</b></span></p>
		<input type="text" id="lastname" name="lastname" class="textbox validate[required]" value="<?php echo $user['lastname']; ?>">
		
		<section class="clear"></section>
		
		<p>Email Address<span><b>*</b></span></p>
		<input type="text" id="email_address" name="email_address" class="textbox validate[required,custom[email]]" value="<?php echo $user['email_address']; ?>">
		<span id="email_address_checker_wrapper"></span>

		<div class="line"></div>

		<p>New Password<span><b>*</b></span></p>
		<input type="password" id="password" name="password" class="textbox validate[optional,minSize[6]]" placeholder="Leave it blank to ignore">
		
		<section class="clear"></section>
		
		<p>Confirm Password<span><b>*</b></span></p>
		<input type="password" id="confirm_password" name="confirm_password" class="textbox validate[optional,minSize[6],equals[password]]" placeholder="Leave it blank to ignore">
		
		<section class="clear"></section>
		
	</form>
	<button id="big_save" class="big_save_edit_user_button">
		<ul>
			<li><img width="17px" height="17px" src="<?php echo BASE_FOLDER . "themes/images/" ?>/icon-save-white.png"></li>
			<li>Save User Account</li>
		</ul>
	</button>
</section>
















<?php include('themes/templates/footer/profile.php'); ?>
