<script>
	$(function() {
		$("#add_user_form").validationEngine({scroll:false});
		$("#add_user_form").ajaxForm({
            success: function(o) {
          		if(o.is_successful) {
          			IS_ADD_USER_FORM_CHANGE = false;
          			default_success_confirmation({message : o.message, alert_type: "alert-success"});
          		} else {
          			default_success_confirmation({message : o.message, alert_type: "alert-error"});
          		}
          		window.location.hash = "manage-user"
    			reload_content("manage-user");
    			$('html,body').animate({scrollTop: $("#alert_confirmation_wrapper").offset().top},10);
            },
            beforeSubmit: function(o) {
            	if(!ADD_USER_EMAIL_ADDRESS_VALID) {
            		default_success_confirmation({message : "Error : Cannot save the current data. Please make sure that the username and email address fields is entered correctly!", alert_type: "alert-error"});
            		return false;
            	}
              
            },
            dataType : "json"
        });

        $(".add_user_form").live('change', function(e) {
			if($(this).val()) {
				IS_ADD_USER_FORM_CHANGE = true;
			}
		});

        upload_user_photo();
	});
</script>
<section class="data">
	<form id="add_user_form" name="add_user_form" method="post" action="<?php echo url("firms/save_firm_user"); ?>" enctype="multipart/form-data">
		<div id="form">
			<p>First Name<span><b>*</b></span></p>
			<input type="text" id="firstname" name="firstname" class="textbox validate[required] add_user_form" >
			<section class="clear"></section>

			<p>Middle Name</p>
			<input type="text" id="middlename" name="middlename" class="textbox add_user_form">
			<section class="clear"></section>

			<p>Last Name<span><b>*</b></span></p>
			<input type="text" id="lastname" name="lastname" class="textbox validate[required] add_user_form">
			<section class="clear"></section>
		
			<input type="hidden" id="firm_name" name="firm_name" value="<?php echo $firm_id; ?>">

			<br/>
			<br/>

			<p>Email Address<span><b>*</b></span></p>
			<input type="text" id="email_address" name="email_address" class="textbox validate[required,custom[email]] add_user_form">
			<span id="email_address_checker_wrapper"></span>
			<section class="clear"></section>

			<p>New Password<span><b>*</b></span></p>
			<input type="password" id="password" name="password" class="textbox validate[required,minSize[6]] add_user_form">
			<section class="clear"></section>
		
			<p>Confirm Password<span><b>*</b></span></p>
			<input type="password" id="confirm_password" name="confirm_password" class="textbox validate[required,minSize[6],equals[password]] add_user_form">
			<section class="clear"></section>

			<br/>
			<br/>

			<p>Account Type<span><b>*</b></span></p>
			<select id="account_type" name="account_type" class="select validate[required] add_user_form">
				<option value="">Choose Account Type</option>
				<option value="<?php echo FIRM_ADMIN; ?>">Firm Administrator</option>
				<option value="<?php echo USER_LEVEL; ?>">User Level</option>
			</select>
			<section class="clear"></section>
		
			<p>Account Status</p>
			<ul class="radio">
			    <li><input type="radio" id="account_status" name="account_status" value="Active" checked="checked" class="add_user_form">Active</li>
				<li><input type="radio" id="account_status" name="account_status" value="Inactive" class="add_user_form">Inactive</li>
				<li><input type="checkbox" id="email_account_details" name="email_account_details" class="add_user_form">Email Account Details</li>
			</ul>
			<section class="clear"></section>

			<section id="form02">
				<p>Display Picture</p>
				<ul>
					<li>
						<div id="display_image_wrapper" class="hidden"></div>
						<input type="file" id="user_display_picture_file" name="user_display_picture_file" class="textbox02">
					</li>
					<li><img id="user_display_picture" name="user_display_picture" class="display_image_holder" src="<?php echo BASE_FOLDER; ?>themes/images/photo.png"></li>
				</ul>
			</section>
			<section class="clear"></section>

			<section id="form_address">
				<p>Current Address<span><b>*</b></span></p>
				<input type="text" id="address_street_1" name="address_street_1" class="textbox validate[required] add_user_form"><br/>
				<input type="text" id="address_street_2" name="address_street_2" class="textbox02 validate[required] add_user_form"><br/>
				<ul>
					<li><input type="text" id="city" name="city" class="textbox03 add_user_form" placeholder="City"></li>
					<li>
						<select id="state" name="state" class="select validate[required] add_user_form">
							<?php foreach($state as $key=>$val): ?>
								<option value="<?php echo $key; ?>" ><?php echo $key; ?></option>
							<?php endforeach; ?>
						</select>
					</li>
					<li><input type="text" id="zip_code" name="zip_code" class="textbox03 add_user_form" placeholder="Zip"></li>
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
			</section>
			<section class="clear"></section>

			<br/>
			<button id="big_save" class="big_save_inner" onclick="$('#add_user_form').submit();" type="button">
				<ul>
					<li><img width="17px" height="17px" src="<?php echo BASE_FOLDER . "themes/images/" ?>/icon-save-white.png"></li>
					<li>Save User Account</li>
				</ul>
			</button>
		</div>
	</form>
</section>