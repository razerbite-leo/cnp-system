<?php $incident = $_SESSION['tmp_cases']['incident_description']; ?>
<script>
	$(function() {
		$('#date_time_accident_wrapper').datetimepicker({
	      language: 'en',
	      pick12HourFormat: true
	    });

		$("#add_incident_description_form").ajaxForm({
		    success: function(o) {
		    	if(o.is_successful) {
		    		IS_INCIDENT_DESCRIPTION_CHANGE = false;
		    		$('#incident_description_sidebar_check').show();

		    		window.location.hash = "insurance";
					reload_content("insurance");

		  		}
		    },
		    beforeSubmit: function(o) {
		    	
		    },
		    dataType: "json"
		});

		$(".incident_description_form").live('change', function(e) {
			if($(this).val()) {
				IS_INCIDENT_DESCRIPTION_CHANGE = true;
			}
		});

		$(".noother").live('click', function() {
			$('.other_wrapper').hide();
		});

		$("#cp_passenger").live('click', function() {
			$('.other_wrapper').hide();
			$('#cp_passenger_wrapper').show();
		});

		$("#cp_other").live('click', function() {
			$('.other_wrapper').hide();
			$('#cp_other_wrapper').show();
		});
	});
</script>
<section id="content">
	<br/>

	<hgroup class="content-header">
		<h1>Incident Description</h1>
		<ul>
			<li><a class="action-icon icon" href="javascript:void(0);" onclick="$('#add_incident_description_form').submit();"><img src="<?php echo BASE_FOLDER; ?>themes/images/icon-save.png"></a></li>
			<li style="margin: 0 5px 0 5px; text-align: center;"><img src="<?php echo BASE_FOLDER; ?>themes/images/line.png" ></li>
			<li><a class="action-icon icon" href="#"><img src="<?php echo BASE_FOLDER; ?>themes/images/icon-trash.png"></a></li>
		</ul>
	</hgroup>
	<div class="line"></div>
	<br>
	<section class="data">
		<section id="form">
			<form id="add_incident_description_form" name="add_incident_description_form" method="post" action="<?php echo url('cases/add_incident_description'); ?>">

				<p>Date / Time of Accident</p>
				<div id="date_time_accident_wrapper" class="input-append">
					<input id="date_time_accident" name="date_time_accident" data-format="MM/dd/yyyy HH:mm:ss PP" type="text" value="<?php echo $incident['date_time_accident']; ?>"></input>
					<span class="add-on">
					  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
					  </i>
					</span>
				</div>
				<section class="clear"></section>

				<p>Location</p>
				<textarea id="location" name="location" style="height: 90px; width:270px;" class="incident_description_form validate[required]"><?php echo $incident['location']; ?></textarea>
				<section class="clear"></section>
			
				<p>Client Position</p>
				<div class="id-cp">
					<label class="no-bootsrap"><input type="radio" id="cp_driver" name="client_position" class="check noother client_position incident_description_form" value="Driver" <?php echo ($incident['client_position'] == "Driver" ? 'checked="checked"' : ''); ?> > Driver </label>
					<label class="no-bootsrap"><input type="radio" id="cp_passenger" name="client_position" class="check incident_description_form" value="Passenger" <?php echo ($incident['client_position'] == "Passenger" ? 'checked="checked"' : ''); ?>> Passenger </label>
					<label class="no-bootsrap"><input type="radio" id="cp_bicyclist" name="client_position" class="check noother client_position incident_description_form" value="Bicyclist" <?php echo ($incident['client_position'] == "Bicyclist" ? 'checked="checked"' : ''); ?>> Bicyclist </label>
					<label class="no-bootsrap"><input type="radio" id="cp_pedestrian" name="client_position" class="check noother client_position incident_description_form" value="Pedestrian" <?php echo ($incident['client_position'] == "Pedestrian" ? 'checked="checked"' : ''); ?>> Pedestrian </label>
					<label class="no-bootsrap"><input type="radio" id="cp_other" name="client_position" class="check incident_description_form" value="Other" <?php echo ($incident['client_position'] == "Other" ? 'checked="checked"' : ''); ?>> Other </label>
				</div>
				<div id="cp_passenger_wrapper" class="other_wrapper hidden">
					<p><input type="text" id="client_position_passenger" name="client_position_passenger" class="textbox incident_description_form" placeholder="Specify other positions" value="<?php echo $incident['client_position_passenger']; ?>"></p>
				</div>
				<div id="cp_other_wrapper" class="other_wrapper hidden">
					<p><input type="text" id="client_position_other" name="client_position_other" class="textbox incident_description_form" placeholder="Provide Host Driver's Name" value="<?php echo $incident['client_position_other']; ?>"></p>
				</div>
				<section class="clear"></section>
			
				<p>Purpose of Trip</p>
				<input type="text" id="trip_purpose" name="trip_purpose" class="textbox general_form" value="<?php echo $incident['trip_purpose']; ?>">
				<div class="trip_purpose_wrapper">
					<label class="no-bootsrap"><input type="checkbox" id="involves_worker_compensation" name="involves_worker_compensation" class="check incident_description_form" value="Yes" <?php echo ($incident['involves_worker_compensation'] == "Yes" ? 'checked="checked"' : ''); ?>> Claim involves Workers Compensation</label><br/>
					<label class="no-bootsrap"><input type="checkbox" id="police_investigated" name="police_investigated" class="check incident_description_form" value="Yes" <?php echo ($incident['police_investigated'] == "Yes" ? 'checked="checked"' : ''); ?> > Police Investigated </label>
				</div>
				<section class="clear"></section>
			
				<p>Agency</p>
				<input type="text" id="agency" name="agency" class="textbox incident_description_form" value="<?php echo $incident['agency']; ?>">
				<section class="clear"></section>

				<p>Case or Report Number </p>
				<input type="text" id="case_report_number" name="case_report_number" class="textbox incident_description_form" value="<?php echo $incident['case_report_number']; ?>">
				<section class="clear"></section>

				<p>Citations issued to</p>
				<br/>
				<div class="citations_item_wrapper">
					<label class="no-bootsrap">
						<input type="checkbox" id="ci_client_check" name="ci_client_check" class="check incident_description_form" value="Yes" <?php echo ($incident['ci_client_check'] == "Yes" ? 'checked="checked"' : ''); ?>>
						<span>Client</span>
					</label>
					<input type="text" id="ci_client_text" name="ci_client_text" class="textbox incident_description_form" value="<?php echo $incident['ci_client_text']; ?>">
					<br/><br/>
					<label class="no-bootsrap">
						<input type="checkbox" id="ci_host_driver_check" name="ci_host_driver_check" class="check incident_description_form" value="Yes" <?php echo ($incident['ci_host_driver_check'] == "Yes" ? 'checked="checked"' : ''); ?>>
						Host Driver
					</label>
					<input type="text" id="ci_host_driver_text" name="ci_host_driver_text" class="textbox incident_description_form" value="<?php echo $incident['ci_host_driver_text']; ?>">
					<br/><br/>
					<label class="no-bootsrap">
						<input type="checkbox" id="ci_host_adverse_driver_check" name="ci_host_adverse_driver_check" class="check incident_description_form" value="Yes" <?php echo ($incident['ci_host_adverse_driver_check'] == "Yes" ? 'checked="checked"' : ''); ?>>
						Adverse Driver
					</label>
					<input type="text" id="ci_host_adverse_driver_text" name="ci_host_adverse_driver_text" class="textbox incident_description_form" value="<?php echo $incident['ci_host_adverse_driver_text']; ?>">
				</div>
				<br/>
				<p>Accident Description</p>
				<br/><br/>
				<textarea id="accident_description" name="accident_description" style="height: 235px; width:700px;" class="incident_description_form validate[required]"><?php echo $incident['accident_description']; ?></textarea>
				<section class="clear"></section>

				<p>Vehicles Involved </p>
				<input type="text" id="vehicles_involved" name="vehicles_involved" class="textbox incident_description_form" value="<?php echo $incident['vehicles_involved']; ?>" style="width: 100px;">
				<label class="no-bootsrap"><input type="checkbox" id="accident_uncontrolled_intersection" name="accident_uncontrolled_intersection" class="incident_description_form" value="Yes" style="margin-bottom:5px; margin-left:5%" <?php echo ($incident['accident_uncontrolled_intersection'] == "Yes" ? 'checked="checked"' : ''); ?>> Accident occured in Uncontrolled Intersection</label>
				<section class="clear"></section>

				<p>Witnesses </p>
				<input type="text" id="witnesses" name="witnesses" class="textbox incident_description_form" value="<?php echo $incident['witnesses']; ?>">
				<section class="clear"></section>
	
			</form>
		</section>
		<br/>
		<button id="big_save" class="big_save_add_incident_description">
			<ul>
				<li><img width="17px" height="17px" src="<?php echo BASE_FOLDER . "themes/images/" ?>/icon-save-white.png"></li>
				<li>Add to Case</li>
			</ul>
		</button>
	</section>
	<br>
</section>