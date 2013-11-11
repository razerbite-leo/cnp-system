<script>
	$(function() {
		upload_firm_photo();
		load_firm_current_contact_list("<?php echo $firm['id']; ?>");
		$("#edit_firm_form").validationEngine({scroll:false});
		$("#edit_firm_form").ajaxForm({
            success: function(o) {
            	if(o.is_successful) {
            		load_firm_current_contact_list("<?php echo $firm['id']; ?>");
          			default_success_confirmation({message : o.message, alert_type: "alert-success"});
          		} else {
          			default_success_confirmation({message : o.message, alert_type: "alert-error"});
          		}
          	
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
	});
</script>
<section class="data">
	<section id="form">
		<form id="edit_firm_form" name="edit_firm_form" method="post" action="<?php echo url("firms/save_firm"); ?>">
		<input type="hidden" id="id" name="id" value="<?php echo $firm['id']; ?>">
		<input type="hidden" id="firm_id" name="firm_id" value="<?php echo $firm['id']; ?>">
		<h4>Firm Information</h4>

		<p>Name of Firm<span><b>*</b></span></p>
		<input type="text" id="firm_name" name="firm_name" class="textbox validate[required]" value="<?php echo $firm['firm_name']; ?>">

		<section class="clear"></section>

		<section id="form_address">
				<p>Current Address</p>
				<input type="text" id="address_street_1" name="address_street_1" class="textbox validate[required]" value="<?php echo $firm['address']; ?>">
				<br>
				<input type="text" id="address_street_2" name="address_street_2" class="textbox02" value="<?php echo $firm['address_2']; ?>">
				<ul>
					<li><input type="text" id="city" name="city" class="textbox03" placeholder="city" value="<?php echo $firm['city']; ?>"></li>
					<li>
						<select id="state" name="state" class="select validate[required]">
							<<?php foreach($state as $key=>$val): ?>
								<option <?php echo ($key == $firm['state'] ? 'selected="selected"' : '') ?> value="<?php echo $key; ?>" ><?php echo $key; ?></option>
							<?php endforeach; ?>
						</select>
					</li>
					<li><input type="text" id="zip" name="zip" class="textbox03 validate[required]" placeholder="zip" value="<?php echo $firm['zip']; ?>"></li>
				</ul>
			</section>

		<section class="clear"></section>

		<p>Firm URL</p>
		<input type="text" id="website_url" name="website_url" class="textbox" value="<?php echo $firm['website_url']; ?>" >

		<section class="clear"></section>

		<section id="form02">
		<?php
			$firm_name 	= strtolower(url_title($firm['firm_name']));
			$img 		= ($firm['firm_logo_url'] == "" ? BASE_FOLDER ."themes/images/logo.png" : MEDIA_FOLDER . "firm/{$firm_name}/resize/" . $firm['firm_logo_url']); 
		?>
			<p>Firm Logo</p>
			<ul>
				<li><img id="firm_display_picture" name="firm_display_picture" class="display_image_holder" src="<?php echo $img; ?>"></li>
				<li>
					<div id="image_photo_wrapper" class="hidden"></div>
					<input type="file" id="file" name="file" class="textbox02">
				</li>
			</ul>
		</section>

		<section class="clear"></section>

		<section id="theme">
			<p>Choose a Theme<span><b>*</b></span></p>
			<section class="colors">
				<button style="background-color: #85326d;"></button>
				<button style="background-color: #704095;"></button>
				<button style="background-color: #4173d3;"></button>
				<button style="background-color: #327d6b;"></button>
				<button style="background-color: #6bb724;"></button>
				<button style="background-color: #fec300;"></button>
				<button style="background-color: orange;"></button>
				<button style="background-color: red;"></button>
				<button style="background-color: pink;"></button>
			</section>
		</section>

		<section class="clear"></section>

		<section id="form_contact">
				<p>Contact Person</p>
				<input type="text" id="contact_person" name="contact_person" class="textbox validate[required]" value="<?php echo $firm['contact_person']; ?>">

				<div id="add_contact_list_firm_wrapper"></div>
				<ul style="margin-top: 15px;">
					<li>
						<select id="contact_type_firm" name="contact_type" class="select02" onchange="javascript:filter_extension_firm();">
							<option value="Mobile">Mobile</option>
							<option value="Work">Work</option>
							<option value="Home">Home</option>
							<option value="Fax">Fax</option>
						</select>
					</li>
					<li><input type="text" id="contact_value_firm" name="contact_value" class="textbox02" placeholder="(___) 000-0000"></li>
					<li><input type="text" id="contact_extension_firm" name="contact_extension" class="textbox03" style="display:none;" placeholder="Extension"></li>
					<li><button type="button" onclick="javascript:add_contact_list_firm();">+Add Number</button></li>
				</ul>
			</section>
			<section class="clear"></section>

			<br/>
			<div id="firm_current_contact_list_wrapper" style="width: 95%;"></div>

			<p>Email Address</p>
			<input type="text" id="email_address_firm" name="email_address" class="textbox validate[required]" value="<?php echo $firm['email_address']; ?>">
			<span id="email_address_checker_wrapper"></span>
			
			<section class="clear"></section>

			<p>Position in Firm</p>
			<input type="text" id="firm_position" name="firm_position" class="textbox validate[required]" value="<?php echo $firm['position_firm']; ?>">

			<section class="clear"></section>

		<div class="line"></div>

		<h4>You are Using <u>4</u> out of <u>10</u> Cases</h4>
		<section id="plan">
			<ul class="account">
				<li>Remaining Cases:</li>
				<li><b>6</b></li>
			</ul>
		</section>

		<section class="clear"></section>	

		<h4>Current Account</h4>
		<section id="plan">
			<ul class="account">
				<li>Free Account</li>
				<li><b>10 Cases</b></li>
				<li style="width: 130px;"></li>
				<li><button>Upgrade Account</button></li>
			</ul>
		</section>

		<div class="line"></div>

		<h4>Upgrade Account</h4>
		<section id="plan">
			<ul class="money">
				<p>Select a Plan</p>
				<li>
					<input type="radio" name="cost" value="$2,995.00">$2,995.00<br>
					<input type="radio" name="cost" value="$1,995.00">$1,995.00<br>
					<input type="radio" name="cost" value="$499.00">$499.00<br>
					<input type="radio" name="cost" value="$149.00">$149.00<br>
					<input type="radio" name="cost" value="Free">Free
				</li>
				<li>
					1000<br>
					500<br>
					100<br>
					25<br>
					10
				</li>
			</ul>
			<ul class="cases-used">
				<p>Cases Used</p>
				<li>
					0/1000<br>
					0/500<br>
					0/100<br>
					0/25<br>
					10/10
				</li>
			</ul>
			<ul class="cases-available">
				<p></p>
				<li><button>Upgrade</button></li>
				<li><button>Upgrade</button></li>
				<li><button>Upgrade</button></li>
				<li><button>Upgrade</button></li>
				<li><button>Upgrade</button></li>
			</ul>
		</section>
	</form>
	</section>
</section>

<div id="edit_firm_contact_form_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:40%;"></div>
<div id="delete_firm_contact_form_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:35%;"></div>