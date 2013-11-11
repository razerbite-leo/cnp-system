<?php $general = $_SESSION['tmp_cases']['general']; ?>
<script>
	$(function() {
		$('#investigation_dtp').datetimepicker({
		  pickTime: false
		});

		$("#add_vehicles_form").ajaxForm({
		    success: function(o) {
		    	if(o.is_successful) {
		    		IS_VEHICLES_TAB_CHANGE = false;
		    		$('#vehicles_count_sidebar').html(o.total_vehicles);
		    		$('#vehicles_count_sidebar').show();

		    		reload_content("vehicles");
		    		vehicle_list();
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
	});
</script>
<section id="content">
	<br/>

	<hgroup class="content-header">
		<h1>Vehicles</h1>
		<ul>
			<li><a class="icon" href="javascript:void(0);" onclick="$('#add_vehicles_form').submit();"><img src="<?php echo BASE_FOLDER; ?>themes/images/icon-save.png"></a></li>
			<li style="margin: 0 5px 0 5px; text-align: center;"><img src="<?php echo BASE_FOLDER; ?>themes/images/line.png" ></li>
			<li><a class="icon" href="#"><img src="<?php echo BASE_FOLDER; ?>themes/images/icon-trash.png"></a></li>
		</ul>
	</hgroup>
	<div class="line"></div>
	<br>
	<section class="data">
		<section id="form">
			<form id="add_vehicles_form" name="add_vehicles_form" method="post" action="<?php echo url('cases/add_vehicles'); ?>">
				<p>Vehicles Type</p>
				<select id="vehicle_type" name="vehicle_type" class="select vehicles_form">
					<option value="Host Vehicles">Host Vehicles</option>
					<option value="Adverse Vehicle">Adverse Vehicle</option>
				</select>
				<div class="vehicle_rental_wrapper">
					<label class="no-bootsrap"><input type="checkbox" id="vehicle_rental" name="vehicle_rental" class="check vehicles_form" value="Yes"> This vehicle is a Rental</label>
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
				<input type="text" id="vehicle" name="vehicle" class="textbox vehicles_form">
				<section class="clear"></section>

				<p>Registered Owner</p>
				<input type="text" id="registered_owner" name="registered_owner" class="textbox vehicles_form">
				<section class="clear"></section>

				<p>Vehicle Year</p>
				<select id="vehicle_year" name="vehicle_year" class="select vehicles_form">
					<?php for($i=date("Y",time()); $i>=1894; $i--): ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
				</select>
				<section class="clear"></section>

				<p>Make and Model</p>
				<input type="text" id="make_model" name="make_model" class="textbox vehicles_form">
				<section class="clear"></section>

				<p>License Plate</p>
				<input type="text" id="license_plate" name="license_plate" class="textbox vehicles_form">
				<section class="clear"></section>

				<p>Vehicle Color</p>
				<input type="text" id="vehicle_color" name="vehicle_color" class="textbox vehicles_form">
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
					<ul class="checkboxes">
						<li><label class="no-bootsrap"><input type="checkbox" class="check vehicles_form" id="vh[police]" name="vh[police]" value="Yes">Police</label></li>
						<li><label clas="no-bootsrap"><input type="checkbox" class="check vehicles_form" id="vh[investigator]" name="vh[investigator]" value="Yes">Investigator</label></li>
					</ul>
					<ul class="checkboxes">
						<li><label class="no-bootsrap"><input type="checkbox" class="check vehicles_form" id="vh[insurance_company]" name="vh[insurance_company]" value="Yes">Insurance Company</label></li>
						<li><label class="no-bootsrap"><input type="checkbox" class="check vehicles_form" id="vh[other]" name="vh[other]" value="Yes">Other</label></li>
					</ul>
					<ul class="checkboxes">
						<li><label class="no-bootsrap"><input type="checkbox" class="check vehicles_form" id="vh[client]" name="vh[client]" value="Yes">Client</label></li>
					</ul>
					<div class="clear">
				</div>

				<p></p>
				<textarea id="no_photos_reason" name="no_photos_reason" style="height: 170px; width:370px;" class="vehicles_form validate[required]" placeholder="If Investigator didn't take photos, why?"></textarea>
				<section class="clear"></section>

				<p>Vehicle Condition</p>
				<br/>
				<div class="vehicle_condition_wrapper">
					<label class="no-bootsrap">
						<input type="radio" id="vehicle_condition" name="vehicle_condition" class="check2 vehicles_form" value="Repairable" checked="checked"> 
						Vehicle is repairable
					</label>
					<br/>
					<input type="text" id="estimated_cost" name="estimated_cost" class="textbox vehicles_form" value="<?php echo $incident['ci_client_text']; ?>" placeholder="Estimated Cost">
					<br/><br/>
					<label class="no-bootsrap">
						<input type="radio" id="vehicle_condition" name="vehicle_condition" class="check2 vehicles_form" value="Total Loss">
						Vehicle is a total loss
					</label>
					<br/>
					<input type="text" id="fair_market_value" name="fair_market_value" class="textbox vehicles_form" value="<?php echo $incident['ci_client_text']; ?>" placeholder="Estimated Fair Market Value">
					<br/><br/>

					<label class="no-bootsrap">
						<input type="checkbox" id="property_damage_claim_paid" name="property_damage_claim_paid" class="check2 vehicles_form" value="Yes">
						Property damage claim was paid
					</label>
					<br/>
					<input type="text" id="paid_by" name="paid_by" class="textbox vehicles_form" value="<?php echo $incident['ci_client_text']; ?>" placeholder="Paid By">
					<br/><br/>
				</div>
				<br/>

			</form>
		</section>
		<br/>
		<button id="big_save" class="big_save_add_general" onclick="$('#add_vehicles_form').submit();">
			<ul>
				<li><img width="17px" height="17px" src="<?php echo BASE_FOLDER . "themes/images/" ?>/icon-save-white.png"></li>
				<li>Add to Case</li>
			</ul>
		</button>
	</section>
	<br>
</section>