<script>
	$(function() {
		<?php if($can_update) { ?>
			$('.update_user_link').hide();
		<?php } else { ?>
			$('.update_user_link').show();
		<?php } ?>
		load_user_current_contact_list("<?php echo $user['id']; ?>");

		$('.tipsy-inner').remove();
		$("#edit_user_form").validationEngine({scroll:false});
		$("#edit_user_form").ajaxForm({
            success: function(o) {
            	
          		if(o.is_successful) {
          			IS_EDIT_USER_FORM_CHANGE = false;
          			default_success_confirmation({message : o.message, alert_type: "alert-success"});
          		} else {
          			default_success_confirmation({message : o.message, alert_type: "alert-error"});
          		}

          		$('html,body').animate({scrollTop: $("#alert_confirmation_wrapper").offset().top},10);

          		window.location.hash = "manage-user"
    			reload_content("manage-user");
            },
            beforeSubmit: function(o) {
            	if(!EDIT_USER_EMAIL_ADDRESS_VALID) {
            		default_success_confirmation({message : "Error : Cannot save the current data. Please make sure that the username and email address fields is entered correctly!", alert_type: "alert-error"});
            		return false;
            	}
              
            },
            dataType : "json"
        });

        $(".edit_user_form").live('change', function(e) {
			if($(this).val()) {
				IS_EDIT_USER_FORM_CHANGE = true;
			}
		});
		
        upload_user_photo();
	});
</script>
<section class="data">
	<form id="edit_user_form" name="edit_user_form" method="post" action="<?php echo url("firms/save_firm_user"); ?>" enctype="multipart/form-data">
	<input type="hidden" id="id" name="id" value="<?php echo $user['id']; ?>">
	<input type="hidden" id="user_id" name="user_id" value="<?php echo $user['id']; ?>">
		<div id="form">
			<p>First Name<span><b>*</b></span></p>
			<input type="text" id="firstname" name="firstname" class="textbox validate[required] edit_user_form" value="<?php echo $user['firstname']; ?>" >
			<section class="clear"></section>

			<p>Middle Name</p>
			<input type="text" id="middlename" name="middlename" class="textbox edit_user_form" value="<?php echo $user['middlename']; ?>">
			<section class="clear"></section>

			<p>Last Name<span><b>*</b></span></p>
			<input type="text" id="lastname" name="lastname" class="textbox validate[required] edit_user_form" value="<?php echo $user['lastname']; ?>">
			<section class="clear"></section>
			
			<input type="hidden" id="firm_name" name="firm_name" value="<?php echo $user['firm_id']; ?>">
			<br/>
			<br/>
			<p>Email Address<span><b>*</b></span></p>
			<input type="text" id="email_address" name="email_address" class="textbox validate[required,custom[email]] edit_user_form" value="<?php echo $user['email_address']; ?>">
			<span id="email_address_checker_wrapper"></span>
			<section class="clear"></section>

			<p>New Password<span><b>*</b></span></p>
			<input type="password" id="password" name="password" class="textbox validate[optional,minSize[6]] edit_user_form" placeholder="Leave it blank to ignore">
			<section class="clear"></section>
		
			<p>Confirm Password<span><b>*</b></span></p>
			<input type="password" id="confirm_password" name="confirm_password" class="textbox validate[optional,minSize[6],equals[password]] edit_user_form" placeholder="Leave it blank to ignore">
			<section class="clear"></section>

			<br/><br/>

			<p>Account Type<span><b>*</b></span></p>
			<select id="account_type" name="account_type" class="select validate[required] edit_user_form">
				<option value="">Choose Account Type</option>
				<option <?php echo ($user['account_type'] == FIRM_ADMIN ? 'selected="selected"' : ''); ?> value="<?php echo FIRM_ADMIN; ?>">Firm Administrator</option>
				<option <?php echo ($user['account_type'] == USER_LEVEL ? 'selected="selected"' : ''); ?> value="<?php echo USER_LEVEL; ?>">User Level</option>
			</select>
			<section class="clear"></section>
		
			<p>Account Status</p>
			<ul class="radio">
			    <li><input type="radio" id="account_status" name="account_status" value="Active" checked="checked" class="edit_user_form">Active</li>
				<li><input type="radio" id="account_status" name="account_status" value="Inactive" class="edit_user_form">Inactive</li>
				<!--<li><input type="checkbox" id="email_account_details" name="email_account_details">Email Account Details</li>-->
			</ul>
			<section class="clear"></section>
		
			<section id="form_address">
				<p>Current Address</span></p>
				<input type="text" id="address_street_1" name="address_street_1" class="textbox validate[required] edit_user_form" value="<?php echo $user['address']; ?>"><br/>
				<input type="text" id="address_street_2" name="address_street_2" class="textbox02 validate[required] edit_user_form" value="<?php echo $user['address_2']; ?>"><br/>
				<ul>
					<li><input type="text" id="city" name="city" class="textbox03 edit_user_form" placeholder="City" value="<?php echo $user['city']; ?>"></li>
					<li>
						<select id="state" name="state" class="select validate[required] edit_user_form">
							<?php foreach($state as $key=>$val): ?>
								<option <?php echo ($key == $user['state'] ? 'selected="selected"' : '') ?> value="<?php echo $key; ?>"><?php echo $key; ?></option>
							<?php endforeach; ?>
						</select>
					</li>
					<li><input type="text" id="zip_code" name="zip_code" class="textbox03 edit_user_form" placeholder="Zip" value="<?php echo $user['zip']; ?>"></li>
				</ul>
			</section>
			<section class="clear"></section>

			<section id="form02">
				<?php 
					$username 	= strtolower($user['username']);
					$img 		= ($user['display_image_url'] == "" ? MEDIA_FOLDER ."images/nodefaultphoto.png" : MEDIA_FOLDER . "user/{$username}/resize/" . $user['display_image_url']); 
				?>
				<p>Display Picture</p>
				<ul>
					<li>
						<div id="display_image_wrapper" class="hidden"></div>
						<input type="file" id="user_display_picture_file" name="user_display_picture_file" class="textbox02">
					</li>
					<li><img id="user_display_picture" name="user_display_picture" class="display_image_holder" src="<?php echo $img; ?>"></li>
				</ul>
			</section>
			<section class="clear"></section>

			<section id="form_contact">
				<p>Contact Information</p>
				<div id="other_contact_list_wrapper">
					<ul>
						<li>
							<select id="contact_type" name="contact_type" class="select" onchange="javascript:filter_extension_user();">
								<option value="Mobile">Mobile</option>
								<option value="Work">Work</option>
								<option value="Home">Home</option>
								<option value="Fax">Fax</option>
							</select>
						</li>
						<li><input type="text" id="contact_type_value" name="contact" class="textbox02"></li>
						<li><input type="text" id="contact_extension_user" name="contact_extension" class="textbox03" style="display:none;" placeholder="Extension"></li>
						<li><button id="add_number_btn" type="button">+Add Number</button></li>
					</ul>
				</div>
				<br/>
			</section>
			<div id="user_current_contact_list_wrapper" style="width: 95%;"></div>
			<section class="clear"></section>
			<br/>
			<button id="big_save" class="big_save_inner" onclick="$('#edit_user_form').submit();" type="button">
				<ul>
					<li><img width="17px" height="17px" src="<?php echo BASE_FOLDER . "themes/images/" ?>/icon-save-white.png"></li>
					<li>Save User Account</li>
				</ul>
			</button>
		</div>
	</form>
</section>
<br/>

<div id="edit_user_contact_form_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:40%;"></div>
<div id="delete_user_contact_form_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:35%;"></div>