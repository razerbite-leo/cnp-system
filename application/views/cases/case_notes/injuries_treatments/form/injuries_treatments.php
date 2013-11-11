<?php $injtrtmnt = $_SESSION['tmp_cases']['injuries_treatments']; ?>
<script>
	$(function() {
		$("#add_injuries_treatment_form").ajaxForm({
		    success: function(o) {
		    	if(o.is_successful) {
		    		IS_INJURIES_TREATMENTS_TAB_CHANGE = false;
		    		$('#injuries_treatments_sidebar_check').show();

		    		window.location.hash = "economic-damages";
					reload_content("economic-damages");

		  		}
		    },
		    beforeSubmit: function(o) {
		    	
		    },
		    dataType: "json"
		});

		$(".injuries_treatments_form").live('change', function(e) {
			if($(this).val()) {
				IS_INJURIES_TREATMENTS_TAB_CHANGE = true;
			}
		});

		ambulance_list();
		hospital_er_list();
		urgent_care_clinic_list();
		imaging_center_list();
		doctor_list();
		chiropractor_list();
		therapist_list();
		referred_client_list();
		medical_provider_list();
		preex_medical_condition_list();
		subsequent_accident_list();

	});
</script>
<section id="content">
	<br/>

	<hgroup class="content-header">
		<h1>Injuries & Treatments</h1>
		<ul>
			<li><a class="icon" href="javascript:void(0);" onclick="$('#add_injuries_treatment_form').submit();"><img src="<?php echo BASE_FOLDER; ?>themes/images/icon-save.png"></a></li>
			<li style="margin: 0 5px 0 5px; text-align: center;"><img src="<?php echo BASE_FOLDER; ?>themes/images/line.png" ></li>
			<li><a class="icon" href="#"><img src="<?php echo BASE_FOLDER; ?>themes/images/icon-trash.png"></a></li>
		</ul>
	</hgroup>
	<div class="line"></div>
	<br>
	<section class="data">
		<section id="form">
			<form id="add_injuries_treatment_form" name="add_injuries_treatment_form" method="post" action="<?php echo url('cases/add_injuries_treatments'); ?>">
				<p>List all injuries and symptoms client relates to the accident</p>
				<textarea id="symptoms_relates_accident" name="symptoms_relates_accident" style="height: 200px; width:540px;" class="injuries_treatments_form validate[required]" placeholder="List all injuries and symptoms here"><?php echo $injtrtmnt['symptoms_relates_accident']; ?></textarea>
				<section class="clear"></section>

				<hr/>

				<p><a href="javascript:void(0);" onclick="javascript:add_ambulance();">Add Ambulance</a></p>
				<div id="ambulance_list_wrapper"></div>
				<section class="clear"></section>

				<p><a href="javascript:void(0);" onclick="javascript:add_hospital_er();">Add Hospital ER</a></p>
				<div id="hospital_er_list_wrapper"></div>
				<section class="clear"></section>

				<p><a href="javascript:void(0);" onclick="javascript:add_urgent_care_clinic();">Add Urgent Care Clinic</a></p>
				<div id="urgent_care_clinic_list_wrapper"></div>
				<section class="clear"></section>

				<p><a href="javascript:void(0);" onclick="javascript:add_imaging_center();">Add Imaging Center</a></p>
				<div id="imaging_center_list_wrapper"></div>
				<section class="clear"></section>

				<hr/>

				<p><a href="javascript:void(0);" onclick="javascript:add_doctor();">Add Doctors</a></p>
				<div id="doctor_list_wrapper"></div>
				<section class="clear"></section>

				<p><a href="javascript:void(0);" onclick="javascript:add_chiropractor();">Add Chiropractors</a></p>
				<div id="chiropractor_list_wrapper"></div>
				<section class="clear"></section>

				<p><a href="javascript:void(0);" onclick="javascript:add_therapist();">Add Therapists</a></p>
				<div id="therapist_list_wrapper"></div>
				<section class="clear"></section>

				<p><a href="javascript:void(0);" onclick="javascript:add_referred_client();">Add referred client</a></p>
				<br/>
				<div id="referred_client_list_wrapper"></div>
				<section class="clear"></section>

				<p class="no-width"><a href="javascript:void(0);" onclick="javascript:add_medical_provider();">Add Medical Providers</a> (Client was treated by medical providers prior to the accident)</p>
				<br/>
				<div id="medical_provider_list_wrapper"></div>
				<section class="clear"></section>

				<hr/>
				
				<p class="no-width"><a href="javascript:void(0);" onclick="javascript:add_preex_medical_condition();">Add Pre-Existing Medical Conditions</a> (Describe all pre-existing medical conditions and prior injuries)</p>
				<br/>
				<div id="preex_medical_condition_list_wrapper"></div>
				<section class="clear"></section>

				<p class="no-width"><a href="javascript:void(0);" onclick="javascript:add_subsequent_accident();">Add Subsequent Accidents</a> (Describe all prior or subsequent accidents, wether or not they involved injuries)</p>
				<br/>
				<div id="subsequent_accident_list_wrapper"></div>
				<section class="clear"></section>



				<br/>
			</form>
		</section>
		<br/>
		<button id="big_save" class="big_save_add_general">
			<ul>
				<li><img width="17px" height="17px" src="<?php echo BASE_FOLDER . "themes/images/" ?>/icon-save-white.png"></li>
				<li>Add to Case</li>
			</ul>
		</button>
	</section>
	<br>
</section>

<div id="add_ambulance_modal_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<div id="edit_ambulance_modal_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

<div id="add_hospital_er_modal_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<div id="edit_hospital_er_modal_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

<div id="add_urgent_care_clinic_modal_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<div id="edit_urgent_care_clinic_modal_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

<div id="add_imaging_center_modal_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<div id="edit_imaging_center_modal_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

<div id="add_doctor_modal_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<div id="edit_doctor_modal_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

<div id="add_chiropractors_modal_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<div id="edit_chiropractors_modal_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

<div id="add_therapist_modal_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<div id="edit_therapist_modal_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

<div id="add_referred_client_modal_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<div id="edit_referred_client_modal_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

<div id="add_medical_provider_modal_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<div id="edit_medical_provider_modal_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

<div id="add_subsuquent_accident_modal_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<div id="edit_subsuquent_accident_modal_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

