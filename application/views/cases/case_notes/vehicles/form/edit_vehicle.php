<script>
	$(function() {
		$("#edit_vehicles_form").ajaxForm({
		    success: function(o) {
		    	if(o.is_successful) {
		    		IS_VEHICLES_TAB_CHANGE = false;
		    		$('#vehicles_sidebar_check').show();

		    		party_list();
		  		}
		    },
		    beforeSubmit: function(o) {
		    	
		    },
		    dataType: "json"
		});

		$(".vehicles_form").live('change', function(e) {
			if($(this).val()) {
				IS_VEHICLES_TAB_CHANGE = true;
			}
		});

		$('#vehicle_type').val("<?php echo $vehicle['vehicle_type']; ?>");
		$('#party_type').val("<?php echo $vehicle['party_type']; ?>");
		$('#party_role').val("<?php echo $vehicle['party_role']; ?>");
		$('#vehicle_year').val("<?php echo $vehicle['vehicle_year']; ?>");
		$('#damage').val("<?php echo $vehicle['damage']; ?>");
		$('#vehicle_status').val("<?php echo $vehicle['vehicle_status']; ?>");
	});
</script>
<section id="content">
	<br/>

	<hgroup class="content-header">
		<h1>Vehicles</h1>
		<ul>
			<li><a class="icon" href="javascript:void(0);" onclick="$('#edit_vehicles_form').submit();"><img src="<?php echo BASE_FOLDER; ?>themes/images/icon-save.png"></a></li>
			<li style="margin: 0 5px 0 5px; text-align: center;"><img src="<?php echo BASE_FOLDER; ?>themes/images/line.png" ></li>
			<li><a class="icon" href="javascript:void(0);" onclick="javascript:delete_vehicle(<?php echo $vehicle['id']; ?>);"><img src="<?php echo BASE_FOLDER; ?>themes/images/icon-trash.png"></a></li>
		</ul>
	</hgroup>
	<div class="line"></div>
	<br>
	<section class="data">
		<section id="form">
			<form id="edit_vehicles_form" name="edit_vehicles_form" method="post" action="<?php echo url('cases/add_vehicles'); ?>">
			<input type="hidden" id="id" name="id" value="<?php echo $vehicle['id'] ;?>">
			<input type="hidden" id="update" name="update" value="<?php echo true; ;?>">
				<p>Vehicles Type</p>
				<select id="vehicle_type" name="vehicle_type" class="select vehicles_form">
					<option value="Host Vehicles">Host Vehicles</option>
					<option value="Adverse Vehicle">Adverse Vehicle</option>
				</select>
				<div class="vehicle_rental_wrapper">
					<label class="no-bootsrap"><input type="checkbox" id="vehicle_rental" name="vehicle_rental" class="check vehicles_form" value="Yes" <?php echo ($vehicle['vehicle_rental'] == "Yes" ? 'checked="checked"' : ''); ?> > This vehicle is a Rental</label>
				</div>
				<section class="clear"></section>

				<p>Party Type</p>
				<select id="party_type" name="party_type" class="select insurance_form" onchange="javascript:show_client_form();">
					<option value="Client">Client</option>
				</select>
				<section class="clear"></section>

				<p>Role of Party</p>
				<select id="party_role" name="party_role" class="select insurance_form">
					<option value="Owner">Owner</option>
				</select>
				<section class="clear"></section>
			
				<p>Vehicle</p>
				<input type="text" id="vehicle" name="vehicle" class="textbox vehicles_form" value="<?php echo $vehicle['vehicle']; ?>">
				<section class="clear"></section>

				<p>Registered Owner</p>
				<input type="text" id="registered_owner" name="registered_owner" class="textbox vehicles_form" value="<?php echo $vehicle['registered_owner']; ?>">
				<section class="clear"></section>

				<p>Vehicle Year</p>
				<select id="vehicle_year" name="vehicle_year" class="select vehicles_form">
					<?php for($i=date("Y",time()); $i>=1894; $i--): ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
				</select>
				<section class="clear"></section>

				<p>Make and Model</p>
				<input type="text" id="make_model" name="make_model" class="textbox vehicles_form" value="<?php echo $vehicle['make_model']; ?>">
				<section class="clear"></section>

				<p>License Plate</p>
				<input type="text" id="license_plate" name="license_plate" class="textbox vehicles_form" value="<?php echo $vehicle['license_plate']; ?>">
				<section class="clear"></section>

				<p>Vehicle Color</p>
				<input type="text" id="vehicle_color" name="vehicle_color" class="textbox vehicles_form" value="<?php echo $vehicle['vehicle_color']; ?>">
				<section class="clear"></section>

				<p>Damage</p>
				<select id="damage" name="damage" class="select insurance_form">
					<option value="None">None</option>
					<option value="None">Slight Scratches</option>
					<option value="None">Minor Crushing</option>
					<option value="None">Major Crushing</option>
				</select>
				<section class="clear"></section>

				<p>Vehicle was</p>
				<select id="vehicle_status" name="vehicle_status" class="select insurance_form">
					<option value="Still driveable">Still driveable</option>
				</select>
				<section class="clear"></section>

				<div class="photo_taken_wrapper">
					<p>Photo of Vehicle taken by</p>
					<?php $vh = $vehicle['vh']; ?>
					<ul class="checkboxes">
						<li><label class="no-bootsrap"><input type="checkbox" class="check vehicles_form" id="vh[police]" name="vh[police]" value="Yes" <?php echo ($vh['police'] == "Yes" ? 'checked="checked"' : ''); ?>>Police</label></li>
						<li><label clas="no-bootsrap"><input type="checkbox" class="check vehicles_form" id="vh[investigator]" name="vh[investigator]" value="Yes" <?php echo ($vh['investigator'] == "Yes" ? 'checked="checked"' : ''); ?> >Investigator</label></li>
					</ul>
					<ul class="checkboxes">
						<li><label class="no-bootsrap"><input type="checkbox" class="check vehicles_form" id="vh[insurance_company]" name="vh[insurance_company]" value="Yes" <?php echo ($vh['insurance_company'] == "Yes" ? 'checked="checked"' : ''); ?> >Insurance Company</label></li>
						<li><label class="no-bootsrap"><input type="checkbox" class="check vehicles_form" id="vh[other]" name="vh[other]" value="Yes" <?php echo ($vh['other'] == "Yes" ? 'checked="checked"' : ''); ?> >Other</label></li>
					</ul>
					<ul class="checkboxes">
						<li><label class="no-bootsrap"><input type="checkbox" class="check vehicles_form" id="vh[client]" name="vh[client]" value="Yes" <?php echo ($vh['client'] == "Yes" ? 'checked="checked"' : ''); ?> >Client</label></li>
					</ul>
					<div class="clear">
				</div>

				<p></p>
				<textarea id="no_photos_reason" name="no_photos_reason" style="height: 170px; width:370px;" class="vehicles_form validate[required]" placeholder="If Investigator didn't take photos, why?"><?php echo $no_photos_reason; ?></textarea>
				<section class="clear"></section>

				<p>Vehicle Condition</p>
				<br/>
				<div class="vehicle_condition_wrapper">
					<label class="no-bootsrap">
						<input type="radio" id="vehicle_condition" name="vehicle_condition" class="check2 vehicles_form" value="Repairable" <?php echo ($vehicle['vehicle_condition'] == "Repairable" ? 'checked="checked"' : ''); ?> > 
						Vehicle is repairable
					</label>
					<br/>
					<input type="text" id="estimated_cost" name="estimated_cost" class="textbox vehicles_form" value="<?php echo $vehicle['estimated_cost']; ?>" placeholder="Estimated Cost">
					<br/><br/>
					<label class="no-bootsrap">
						<input type="radio" id="vehicle_condition" name="vehicle_condition" class="check2 vehicles_form" value="Total Loss" <?php echo ($vehicle['vehicle_condition'] == "Total Loss" ? 'checked="checked"' : ''); ?> >
						Vehicle is a total loss
					</label>
					<br/>
					<input type="text" id="fair_market_value" name="fair_market_value" class="textbox vehicles_form" value="<?php echo $vehicle['fair_market_value']; ?>" placeholder="Estimated Fair Market Value">
					<br/><br/>

					<label class="no-bootsrap">
						<input type="checkbox" id="property_damage_claim_paid" name="property_damage_claim_paid" class="check2 vehicles_form" value="Yes" <?php echo ($vehicle['property_damage_claim_paid'] == "Yes" ? 'checked="checked"' : ''); ?> >
						Property damage claim was paid
					</label>
					<br/>
					<input type="text" id="paid_by" name="paid_by" class="textbox vehicles_form" value="<?php echo $vehicle['paid_by']; ?>" placeholder="Paid By">
					<br/><br/>
				</div>
				<br/>

			</form>
		</section>
		<br/>
		<button id="big_save" class="big_save_add_general" onclick="$('#edit_vehicles_form').submit();">
			<ul>
				<li><img width="17px" height="17px" src="<?php echo BASE_FOLDER . "themes/images/" ?>/icon-save-white.png"></li>
				<li>Add to Case</li>
			</ul>
		</button>
	</section>
	<br>
</section>