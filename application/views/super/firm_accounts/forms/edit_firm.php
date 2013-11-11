<div id="edit_firm_contact_form_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:40%;"></div>
<div id="delete_firm_contact_form_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:35%;"></div>
<div id="case_availability_user_detailed_form_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="left:36% !important; width:70%;"></div>
<script>
	$(function() {
		case_alloted_list();
		load_firm_current_contact_list("<?php echo $firm['id']; ?>");

		$('.tipsy-inner').remove();
		$("#edit_firm_form").validationEngine({scroll:false});
		$("#edit_firm_form").ajaxForm({
            success: function(o) {
            	if(o.is_successful) {
            		IS_EDIT_FIRM_FORM_CHANGE = false;
          			default_success_confirmation({message : o.message, alert_type: "alert-success"});
          		} else {
          			default_success_confirmation({message : o.message, alert_type: "alert-error"});
          		}
          		window.location.hash = "firm-accounts";
    			reload_content("firm-accounts");

    			$('html,body').animate({scrollTop: $("#alert_confirmation_wrapper").offset().top},10);
            },
            beforeSubmit: function(o) {
            	if(!EDIT_FIRM_EMAIL_ADDRESS_VALID) {
            		default_success_confirmation({message : "Error : Cannot save the current data. Please make sure that the username and email address fields is entered correctly!", alert_type: "alert-error"});
            		return false;
            	}
            },
            dataType: "json"
        });

        $(".edit_firm_form").live('change', function(e) {
			if($(this).val()) {
				IS_EDIT_FIRM_FORM_CHANGE = true;
			}
		});

        upload_firm_photo();
	});

</script>

<section class="data">
	<div id="form">
		<form id="edit_firm_form" name="edit_firm_form" method="post" action="<?php echo url("super/save_firm"); ?>">
		<input type="hidden" id="id" name="id" value="<?php echo $firm['id']; ?>">
		<input type="hidden" id="firm_id" name="firm_id" value="<?php echo $firm['id']; ?>">
			<h4>Firm Information</h4>

			<p>Name of Firm<span><b>*</b></span></p>
			<input type="text" id="firm_name" name="firm_name" class="textbox validate[required] edit_firm_form" value="<?php echo $firm['firm_name']; ?>">

			<section class="clear"></section>

			<section id="form_address">
				<p>Current Address</p>
	
				<input type="text" id="address_street_1" name="address_street_1" class="textbox validate[required] edit_firm_form" value="<?php echo $firm['address']; ?>"><br/>
				<input type="text" id="address_street_2" name="address_street_2" class="textbox02 validate[required] edit_firm_form" value="<?php echo $firm['address_2']; ?>"><br/>
				<ul>
					<li><input type="text" id="city" name="city" class="textbox03" placeholder="city" value="<?php echo $firm['city']; ?>"></li>
					<li>
						<select id="state" name="state" class="select validate[required] edit_firm_form">
							<<?php foreach($state as $key=>$val): ?>
								<option <?php echo ($key == $firm['state'] ? 'selected="selected"' : '') ?> value="<?php echo $key; ?>" ><?php echo $key; ?></option>
							<?php endforeach; ?>
						</select>
					</li>
					<li><input type="text" id="zip" name="zip" class="textbox03 validate[required] edit_firm_form" placeholder="zip" value="<?php echo $firm['zip']; ?>"></li>
				</ul>
			</section>
			<section class="clear"></section>


			<p>Firm URL</p>
			<input type="text" id="website_url" name="website_url" class="textbox edit_firm_form" value="<?php echo $firm['website_url']; ?>" >
			<section class="clear"></section>

			<section id="form02">
			<?php
				$firm_name 	= strtolower(url_title($firm['firm_name']));
				$img 		= ($firm['firm_logo_url'] == "" ? MEDIA_FOLDER ."images/nodefaultphoto.png" : MEDIA_FOLDER . "firm/{$firm_name}/" . $firm['firm_logo_url']); 
			?>

				<p>Firm Logo</p>
				<ul>
					<li>
						<div id="image_photo_wrapper" class="hidden"></div>
						<input type="file" id="file" name="file" class="textbox02 edit_firm_form">
					</li>
					<li><img id="firm_display_picture" name="firm_display_picture" class="display_firm_logo_holder" height="150" width="300" src="<?php echo $img; ?>"></li>
					
				</ul>
			</section>
			<section class="clear"></section>
			<section id="form_contact">
				<p>Contact Person<span><b>*</b></span></p>
				<input type="text" id="contact_person" name="contact_person" class="textbox validate[required] edit_firm_form" value="<?php echo $firm['contact_person']; ?>">

				<div id="add_contact_list_firm_wrapper"></div>
				<ul style="margin-top: 15px;">
					<li>
						<select id="contact_type_firm" name="contact_type" class="select02 edit_firm_form" onchange="javascript:filter_extension_firm();">
							<option value="Mobile">Mobile</option>
							<option value="Work">Work</option>
							<option value="Home">Home</option>
							<option value="Fax">Fax</option>
						</select>
					</li>
					<li><input type="text" id="contact_value_firm" name="contact_value" class="textbox02" placeholder="(___) 000-0000"></li>
					<li><input type="text" id="contact_extension_firm" name="contact_extension" class="textbox03" style="display:none;" placeholder="Extension"></li>
					<li><button class="add_contact_list_firm_button" type="button">+Add Number</button></li>
				</ul>
			</section>
			<section class="clear"></section>

			<br/>
			<div id="firm_current_contact_list_wrapper" style="width: 95%;"></div>

			<p>Email Address<span><b>*</b></span></p>
			<input type="text" id="email_address_firm" name="email_address" class="textbox validate[required] edit_firm_form" value="<?php echo $firm['email_address']; ?>">
			<span id="email_address_checker_wrapper"></span>
			<section class="clear"></section>

			<p>Position in Firm<span><b>*</b></span></p>
			<input type="text" id="firm_position" name="firm_position" class="textbox validate[required] edit_firm_form" value="<?php echo $firm['position_firm']; ?>">
			<section class="clear"></section>

			<p>Timezone<span><b>*</b></span></p>
			<select id="timezone_id" name="timezone_id" style="width:auto;">
				<?php foreach($timezone as $key=>$value): ?>
					<option value="<?php echo $value['id']; ?>" <?php echo ($value['id'] == $firm['timezone_id'] ? 'selected="selected"' : '') ?>><?php echo "GMT" . $value['offset'] . " - " . $value['timezone']; ?></option>
				<?php endforeach; ?>
			</select>

			</style>
			<div class="line"></div>

			<h4>Case Availability</h4>

			<div>
			   <div id="case_alloted_wrapper" class="case_availability_wrapper_l"></div>
			   <div id="case_alloted_history_wrapper" class="case_availability_wrapper_r"></div>
			</div>
			<div class="clear"></div>
			<br/>

			<p>Credit Case</p>
			<input type="text" id="credit_case" name="credit_case" class="edit_firm_form">
			<section class="clear"></section>

			<p>Account Status</p>
			<select id="account_staus" name="account_status">
				<option value="<?php echo ACTIVE; ?>">Active</option>
				<option value="<?php echo INACTIVE; ?>">Inactive</option>
			</select>
			<section class="clear"></section>

			<br/>

			<button type="button" id="big_save" class="big_save_inner" onclick="$('#edit_firm_form').submit();">
				<ul>
					<li><img width="17px" height="17px" src="<?php echo BASE_FOLDER; ?>themes/images/icon-save-white.png"></li>
					<li>Save Firm Account</li>
				</ul>
			</button>

			<!-- Case Availability Template -->
			<!--
			<div class="line"></div>

			<h4>Case Availability</h4>
			<section id="plan">
				<ul class="money">
					<p>Plan Name</p>
					<li>
						<?php foreach($subscriptions as $key=>$value): ?>
							<label><input id="subscription_id" name="subscription_id" type="radio" <?php echo ($value['id'] == $firm['subscription_id'] ? 'checked="checked"' : '') ?> value="<?php echo $value['id'] ?>"><?php echo $value['subscription_name']; ?></label><br>
						<?php endforeach;?>
					</li>
				</ul>
				<ul class="cases-used">
					<p>Cases Used</p>
					<li>
						<?php foreach($subscriptions as $key=>$value): ?>
							<?php echo $value['case_alloted']; ?> <br/>
						<?php endforeach;?>
					</li>
				</ul>
				<ul class="cases-available">
					<p>Cases Available to Open</p>
					<?php foreach($subscriptions as $key=>$value): ?>
						<li><input type="text" id="case_available_<?php echo $value['id']; ?>" name="case_available_<?php echo $value['id']; ?>" class="textbox case_available_open" value="<?php echo $value['case_alloted']; ?>" ><button type="button" id="<?php echo $value['id']; ?>" class="case_available_open_button" >Click to Increment</button></li>
					<?php endforeach;?>
				</ul>
			</section>

			<section class="clear"></section>
			<section id="plan">
				<ul class="auto-renew">
					<p>Auto-renewal</p>
					<li>Auto-renew when 5% of plan remains?<span><b>*</b></span></li>
					<li><input type="radio" name="renew" value="<?php echo YES; ?>" checked="checked">Yes</li>
					<li><input type="radio" name="renew" value="<?php echo NO; ?>">No</li>
				</ul>
				<sub><span><b>*</b></span>We renew subscriptions with 5% left to 
				     give firms time to deal with any temporary credit card issues 
					 that prevent them from setting up new cases</sub>
			</section>

			<div class="line"></div>

			<h4>Payment Method</h4>
			
			<label style="color: #464646;"><input type="radio" id="payment_method_radio" name="payment_method" checked="checked" onclick="javascript:select_payment_method('paypal');">Paypal</label>

			<section class="clear"></section>

			<div id="paypal_method_wrapper">
				<p>Email Address<span><b>*</b></span></p>
				<input type="text" class="textbox" name="">

				<section class="clear"></section>

				<p>Paypal Password<span><b>*</b></span></p>
				<input type="password" class="textbox" name="">

				<section class="clear"></section>
			</div>
			<br>

			<label style="color: #464646;"><input type="radio" id="payment_method_radio" name="payment_method" value="credit_card" onclick="javascript:select_payment_method('credit_card');">Credit Card</label>

			<section class="clear"></section>

			<div id="credit_card_method_wrapper" class="hidden">
				<p>Choose Credit Card<span><b>*</b></span></p>
				<select class="select" name="Party type">
					<option value="Option 1">Please Select One</option>
					<option value="Option 2">Visa</option>
					<option value="Option 3">MasterCard</option>
					<option value="Option 4">Amex</option>
				</select>
			
				<section class="clear"></section>

				<p>Card Number<span><b>*</b></span></p>
				<input type="text" value="**** **** **** ****" class="textbox" name="">

				<section class="clear"></section>

				<p>Security Code<span><b>*</b></span></p>
				<input type="text" value="Required" class="textbox" name="">

				<section class="clear"></section>

				<section id="form02">
					<p>Expiration Date<span><b>*</b></span></p>
					<select class="select" name="month">
						<option value="Option 2">Jan</option>
						<option value="Option 3">Feb</option>
						<option value="Option 4">Mar</option>
						<option value="Option 5">Apr</option>
						<option value="Option 6">May</option>
						<option value="Option 7">June</option>
						<option value="Option 8">July</option>
						<option value="Option 9">Aug</option>
						<option value="Option 10">Sept</option>
						<option value="Option 11">Oct</option>
						<option value="Option 12">Nov</option>
						<option value="Option 13">Dec</option>
					</select>
					
					<select class="select" name="Year">
						<option value="Option 1">2013</option>
						<option value="Option 1">2012</option>
						<option value="Option 1">2011</option>
						<option value="Option 1">2010</option>
						<option value="Option 1">2009</option>
						<option value="Option 1">2008</option>
						<option value="Option 1">2007</option>
						<option value="Option 1">2006</option>
						<option value="Option 1">2005</option>
						<option value="Option 1">2004</option>
						<option value="Option 1">2003</option>
						<option value="Option 1">2001</option>
						<option value="Option 1">2000</option>
						<option value="Option 1">1999</option>
						<option value="Option 1">1998</option>
						<option value="Option 1">1997</option>
						<option value="Option 1">1996</option>
						<option value="Option 1">1995</option>
						<option value="Option 1">1994</option>
						<option value="Option 1">1993</option>
						<option value="Option 1">1992</option>
					</select>
				</section>

				<section class="clear"></section>

				<section id="form02">
					<p>Name<span><b>*</b></span></p>
					<select class="select" name="Status">
						<option value="Option 1">Mr.</option>
						<option value="Option 2">Mrs.</option>
						<option value="Option 3">Ms.</option>
					</select>
					<input type="text" class="textbox" name="Address">
				</section>

				<section class="clear"></section>
			</div>
			<br>

			<h4>Billing Information</h4>
			<section id="form_address">
				<p>Billing Address<span><b>*</b></span></p>
				<input type="text" class="textbox" name="Address">
				<br>
				<input type="text" class="textbox02" name="Address">
				<ul>
					<li><input type="text" value="City" class="textbox03" name="Address"></li>
					<li>
						<select class="select" name="state">
							<option value="Option 1">State</option>
							<option value="Option 2">Option 1</option>
							<option value="Option 3">Option 2</option>
							<option value="Option 4">Option 3</option>
						</select>
					</li>
					<li><input type="text" value="Zip" class="textbox03" name="Address"></li>
				</ul>
			</section>

			<section class="clear"></section>

			<section id="form_contact">
				<p>Contact Information</p>
				<ul>
					<li>
						<select class="select" name="number">
							<option value="Option 1">Mobile</option>
							<option value="Option 2">Work</option>
							<option value="Option 3">Home</option>
							<option value="Option 4">Fax</option>
						</select>
					</li>
					<li><input type="text" class="textbox" name="contact"></li>
				</ul>
			</section>
		</form>
	</div>
</section>
<br/>
<button type="button" id="big_save"  onclick="$('#edit_firm_form').submit();">

	<ul>
		<li><img width="17px" height="17px" src="<?php echo BASE_FOLDER; ?>themes/images/icon-save-white.png"></li>
		<li>Save Firm Account</li>
	</ul>
</button>
-->

