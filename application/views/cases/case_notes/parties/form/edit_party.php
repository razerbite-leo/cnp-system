<?php $parties = $_SESSION['tmp_cases']['parties']; ?>
<script>
	$(function() {
		$('#birthdate_dtp').datetimepicker({
		  pickTime: false
		});

		$("#edit_party_form").ajaxForm({
		    success: function(o) {
		    	if(o.is_successful) {
		    		IS_PARTY_TAB_CHANGE = false;
		    		party_list();
		  		}
		    },
		    beforeSubmit: function(o) {
		    	
		    },
		    dataType: "json"
		});

		$('#party_type').val("<?php echo $party['party_type']; ?>");
		$('#party_role').val("<?php echo $party['party_role']; ?>");
		$('#relationship').val("<?php echo $party['relationship']; ?>");
		$('#state').val("<?php echo $party['state']; ?>");

		contact_information_list(<?php echo $party['id']; ?>);;
		contact_person_list(<?php echo $party['id']; ?>);
		show_client_form();

		$(".party_form").live('change', function(e) {
			if($(this).val()) {
				IS_PARTY_TAB_CHANGE = true;
			}
		});

		upload_party_image();
	});

	function show_client_form() {
		var party_type = $('#party_type').val();
		if(party_type == "Client") {
			$('.client_group_form').show();
			$('.defendant_group_form').hide();
		} else {
			$('.client_group_form').hide();
			$('.defendant_group_form').show();
		}
		
	}
</script>

<section id="content">
	<hgroup class="content-header">
		<h1>Parties Involved</h1>
		<ul>
			<li><a class="icon" href="javascript:void(0);" onclick="$('#edit_party_form').submit();"><img src="<?php echo BASE_FOLDER; ?>themes/images/icon-save.png"></a></li>
			<li style="margin: 0 5px 0 5px; text-align: center;"><img src="<?php echo BASE_FOLDER; ?>themes/images/line.png" ></li>
			<li><a class="icon" href="#"><img src="<?php echo BASE_FOLDER; ?>themes/images/icon-trash.png"></a></li>
		</ul>
	</hgroup>
	<div class="line"></div>
	<br>
	<section class="data">
		<section id="form">
			<form id="edit_party_form" name="edit_party_form" method="post" action="<?php echo url('cases/add_party'); ?>" enctype="multipart/form-data">
			<input type="hidden" id="id" name="id" value="<?php echo $party['id']; ?>">
			<input type="hidden" id="update" name="update" value="true">
				<p>Party Type</p>
				<select id="party_type" name="party_type" class="select party_form" onchange="javascript:show_client_form();">
					<option value="Client">Client</option>
					<option value="Defendant">Defendant</option>
				</select>
				<section class="clear"></section>

				<div class="hidden defendant_group_form">
					<p>Role of Party</p>
					<select id="party_role" name="party_role" class="select party_form">
						<option value="Option 1">Please Select One</option>
						<option value="Option 2">Owner</option>
					</select>
					<section class="clear"></section>
				</div>

				<section id="form02">
					<p>Client Name</p>
					<select id="prefix_title" name="prefix_title" class="select party_form">
						<option value="Mr">Mr.</option>
						<option value="Mrs">Mrs.</option>
						<option value="Ms">Ms.</option>
					</select>
					<input type="text" id="client_name" name="client_name" class="textbox party_form" value="<?php echo $party['client_name']; ?>">
				</section>
				<section class="clear"></section>

				<p>Gender</p>
				<label class="no-bootsrap"><input type="radio" class="party_form" name="gender" <?php echo ($party['gender'] == "Male" ? 'checked="checked"' : ''); ?> value="Male" checked="checked" style="margin-bottom:1%; margin-right:0.5%;">Male</label>
				<label class="no-bootsrap"><input type="radio" class="party_form" name="gender" <?php echo ($party['gender'] == "Female" ? 'checked="checked"' : ''); ?> value="Female" style="margin-bottom:1%; margin-right:0.5%;">Female</label>
				<section class="clear"></section>

				<div class="client_group_form">
					<section id="form02">
						<p>Client Photo</p>
						<ul>
							<li><img id="party_display_picture" class="display_image_holder party_form" src="<?php echo BASE_FOLDER; ?>themes/images/photo.png"></li>
							<li>
								<div id="display_image_wrapper" class="hidden"></div>
								<input type="file" id="party_image_file" name="file" class="textbox02 party_form">
							</li>
						</ul>
					</section>
					<section class="clear"></section>
				</div>
						
				<p>Relationship</p>
				<select id="relationship" name="relationship" class="select party_form">
					<option value="">Please Select One</option>
					<option value="Spouse">Spouse</option>
					<option value="Parent">Parent</option>
					<option value="Other">Other</option>
				</select>
				<br>
				<p></p>
				<input style="margin-top: 10px;" type="text" name="relationship_other" class="textbox party_form" value="<?php echo $party['relationship_other']; ?>" placeholder="If Other is selected, please indicate">
				<section class="clear"></section>

				<p>Social Security No.</p>
				<input type="text" id="ssn" name="ssn" class="textbox" value="<?php echo $party['ssn']; ?>">
				<section class="clear"></section>

				<p>Date of Birth</p>
				<div id="birthdate_dtp" class="input-append">
					<input type="text" id="birthdate" name="birthdate" class="party_form" data-format="yyyy-MM-dd" value="<?php echo $party['birthdate']; ?>"></input>
					<span class="add-on">
					  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
					  </i>
					</span>
				</div>
				<section class="clear"></section>

				<section id="form_address">
					<p>Current Address</p>
					<textarea id="address" name="address" style="height: 90px; width:270px;" class="party_form validate[required]"><?php echo $party['address']; ?></textarea>
					<ul>
						<li><input type="text" class="party_form" id="city" name="city" class="textbox03" value="<?php echo $party['city']; ?>" placeholder="City"></li>
						<li>
							<select id="state" name="state" class="select party_form" style="margin-top: -10px !important;">
								<?php foreach($state as $key=>$val): ?>
									<option value="<?php echo $key; ?>" ><?php echo $key; ?></option>
								<?php endforeach; ?>
							</select>
						</li>
						<li><input type="text" id="zip" name="zip" class="textbox03 party_form" value="<?php echo $party['zip']; ?>" placeholder="Zip" style="margin-top: -10px !important;"></li>
					</ul>
				</section>
				<section class="clear"></section>

				<section id="form_contact">
					<p>Contact Information</p>
					<div id="add_contact_information_wrapper">
						<ul>
							<li>
								<select id="contact_information_type" name="contact_type" class="select party_form" onchange="javascript:filter_contact_extension();">
									<option value="Mobile">Mobile</option>
									<option value="Work">Work</option>
									<option value="Home">Home</option>
									<option value="Fax">Fax</option>
								</select>
							</li>
							<li><input type="text" id="contact_information_value" name="contact_value" class="textbox02"></li>
							<li><input type="text" id="contact_information_extension" name="contact_extension" class="textbox03" style="display:none;" placeholder="Extension"></li>
							<li><button id="add_contact_information_button" type="button">+Add Number</button></li>
						</ul>
					</div>
				</section>
				<section class="clear"></section>
				<div id="contact_information_list_wrapper" style="width: 95%;"></div>

				<br/>

				<p>Occupation</p>
				<input type="text" id="occupation" name="occupation" class="textbox party_form" value="<?php echo $party['occupation']; ?>">
				<section class="clear"></section>

				<section id="form_contact">
					<p>Contact Person</p>
					<input type="text" id="contact_person_text" name="contact_person_text" class="textbox party_form" value="<?php echo $party['contact_person_text']; ?>">
					<div id="add_contact_person_wrapper">
						<ul>
							<li>
								<select id="contact_person_type" name="contact_person_type" class="select party_form" onchange="javascript:filter_contact_person_extension();">
									<option value="Mobile">Mobile</option>
									<option value="Work">Work</option>
									<option value="Home">Home</option>
									<option value="Fax">Fax</option>
								</select>
							</li>
							<li><input type="text" id="contact_person_value" name="contact_person_value" class="textbox02 party_form"></li>
							<li><input type="text" id="contact_person_extension" name="contact_person_extension" class="textbox03 party_form" style="display:none;" placeholder="Extension"></li>
							<li><button id="add_contact_person_button" type="button">+Add Number</button></li>
						</ul>
					</div>
				</section>
				<section class="clear"></section>
				<div id="contact_person_list_wrapper" style="width: 95%;"></div>

				<br/>

				<p>E-mail Address</p>
				<input type="text" id="email_address" name="email_address" class="textbox party_form" value="<?php echo $party['email_address']; ?>">
				<section class="clear"d></section>

				<p>Relationship</p>
				<input type="text" id="contact_relationship" name="contact_relationship" class="textbox party_form" value="<?php echo $party['contact_relationship']; ?>">
				<section class="clear"></section>

				<div class="client_group_form">
					<p>Client currently receives Public	Benefits</p>
					<ul class="checkboxes">
						<li><label class="no-bootsrap"><input type="checkbox" class="check party_form" id="pb[ss]" name="pb[ss]" value="Yes" <?php echo ($party['pb']['ss'] == "Yes" ? 'checked="checked"' : ""); ?> >SS</label></li>
						<li><label clas="no-bootsrap"><input type="checkbox" class="check party_form" id="pb[ssd]" name="pb[ssd]" value="Yes" <?php echo ($party['pb']['ssd'] == "Yes" ? 'checked="checked"' : ""); ?> >SSD</label></li>
						<li><label class="no-bootsrap"><input type="checkbox" class="check party_form" id="pb[medical_id]" name="pb[medical_id]" value="Yes" <?php echo ($party['pb']['medical_id'] == "Yes" ? 'checked="checked"' : ""); ?>>Medical ID</label></li>
					</ul>
					<ul class="checkboxes">
						<li><label class="no-bootsrap"><input type="checkbox" class="check party_form" id="pb[medicare]" name="pb[medicare]" value="Yes" <?php echo ($party['pb']['medicare'] == "Yes" ? 'checked="checked"' : ""); ?> >Medicare</label></li>
						<li><label class="no-bootsrap"><input type="checkbox" class="check party_form" id="pb[housing_food]" name="pb[housing_food]" value="Yes" <?php echo ($party['pb']['housing_food'] == "Yes" ? 'checked="checked"' : ""); ?> >Housing / Food</label></li>
						<li><label class="no-bootsrap"><input type="checkbox" class="check party_form" id="ck_other" name="ck_other" value="Yes" <?php echo ($party['ck_other'] == "Yes" ? 'checked="checked"' : ""); ?> >Others</label></li>
					</ul>
					<div class="clear">
					<input style="margin: 10px 0 0 170px;" type="text" id="pb_other" name="pb_other" class="textbox party_form" value="<?php echo $party['pb_other']; ?>" placeholder="If Other is selected, please indicate">
				</div>

			</form>
		</section>
	</section>
</section>

<div id="edit_contact_information_form_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:40%;"></div>
<div id="delete_contact_information_form_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:35%;"></div>

<div id="edit_contact_person_form_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:40%;"></div>
<div id="delete_contact_person_form_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:35%;"></div>