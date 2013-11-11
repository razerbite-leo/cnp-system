// Injuries and Treatments

function ambulance_list() {
	$('#ambulance_list_wrapper').html(default_ajax_loader);
	$.post(base_url + "cases/ambulance_list",{},function(o){
		$('#ambulance_list_wrapper').html(o);
	});
}

function add_ambulance() {
	$.post(base_url + 'cases/add_ambulance_form',{},function(o) {
		$('#add_ambulance_modal_wrapper').html(o);
		$('#add_ambulance_modal_wrapper').modal();
		
		$('#add_ambulance_modal_wrapper').on('hidden', function () {
		  $("#add_ambulance_form").validationEngine('hide');
		});
	});
}

function edit_ambulance(id) {
	var id = parseInt(id);
	$.post(base_url + 'cases/edit_ambulance_form',{id:id},function(o) {
		$('#edit_ambulance_modal_wrapper').html(o);
		$('#edit_ambulance_modal_wrapper').modal();
		
		$('#edit_ambulance_modal_wrapper').on('hidden', function () {
		  $("#edit_ambulance_form").validationEngine('hide');
		});
	});
}

function delete_ambulance(id) {
	if($('.tipsy-inner')) {
		$('.tipsy-inner').remove();
	}

	var id = parseInt(id);
	$.post(base_url + 'cases/delete_ambulance',{id:id},function(o) {
		ambulance_list();
	});
}

function hospital_er_list() {
	$('#hospital_er_list_wrapper').html(default_ajax_loader);
	$.post(base_url + "cases/hospital_er_list",{},function(o){
		$('#hospital_er_list_wrapper').html(o);
	});
}

function add_hospital_er() {
	$.post(base_url + 'cases/add_hospital_er_form',{},function(o) {
		$('#add_hospital_er_modal_wrapper').html(o);
		$('#add_hospital_er_modal_wrapper').modal();
		
		$('#add_hospital_er_modal_wrapper').on('hidden', function () {
		  $("#add_hospital_er_form").validationEngine('hide');
		});
	});
}

function edit_hospital_er(id) {
	var id = parseInt(id);
	$.post(base_url + 'cases/edit_hospital_er_form',{id:id},function(o) {
		$('#edit_hospital_er_modal_wrapper').html(o);
		$('#edit_hospital_er_modal_wrapper').modal();
		
		$('#edit_hospital_er_modal_wrapper').on('hidden', function () {
		  $("#edit_hospital_form").validationEngine('hide');
		});
	});
}

function delete_hospital_er(id) {
	if($('.tipsy-inner')) {
		$('.tipsy-inner').remove();
	}

	var id = parseInt(id);
	$.post(base_url + 'cases/delete_hospital_er',{id:id},function(o) {
		hospital_er_list();
	});
}

function urgent_care_clinic_list() {
	$('#urgent_care_clinic_list_wrapper').html(default_ajax_loader);
	$.post(base_url + "cases/urgent_care_clinic_list",{},function(o){
		$('#urgent_care_clinic_list_wrapper').html(o);
	});
}

function add_urgent_care_clinic() {
	$.post(base_url + 'cases/add_urgent_care_clinic_form',{},function(o) {
		$('#add_urgent_care_clinic_modal_wrapper').html(o);
		$('#add_urgent_care_clinic_modal_wrapper').modal();
		
		$('#add_urgent_care_clinic_modal_wrapper').on('hidden', function () {
		  $("#add_urgent_care_clinic_form").validationEngine('hide');
		});
	});
}

function edit_urgent_care_clinic(id) {
	var id = parseInt(id);
	$.post(base_url + 'cases/edit_urgent_care_clinic_form',{id:id},function(o) {
		$('#edit_urgent_care_clinic_modal_wrapper').html(o);
		$('#edit_urgent_care_clinic_modal_wrapper').modal();
		
		$('#edit_urgent_care_clinic_modal_wrapper').on('hidden', function () {
		  $("#urgent_care_clinic").validationEngine('hide');
		});
	});
}

function delete_urgent_care_clinic(id) {
	if($('.tipsy-inner')) {
		$('.tipsy-inner').remove();
	}

	var id = parseInt(id);
	$.post(base_url + 'cases/delete_urgent_care_clinic',{id:id},function(o) {
		urgent_care_clinic_list();
	});
}

function imaging_center_list() {
	$('#imaging_center_list_wrapper').html(default_ajax_loader);
	$.post(base_url + "cases/imaging_center_list",{},function(o){
		$('#imaging_center_list_wrapper').html(o);
	});
}

function add_imaging_center() {
	$.post(base_url + 'cases/add_imaging_center_form',{},function(o) {
		$('#add_imaging_center_modal_wrapper').html(o);
		$('#add_imaging_center_modal_wrapper').modal();
		
		$('#add_imaging_center_modal_wrapper').on('hidden', function () {
		  $("#add_imaging_center_form").validationEngine('hide');
		});
	});
}

function edit_imaging_center_clinic(id) {
	var id = parseInt(id);
	$.post(base_url + 'cases/edit_imaging_center_form',{id:id},function(o) {
		$('#edit_imaging_center_modal_wrapper').html(o);
		$('#edit_imaging_center_modal_wrapper').modal();
		
		$('#edit_imaging_center_modal_wrapper').on('hidden', function () {
		  $("#edit_imaging_center_form").validationEngine('hide');
		});
	});
}

function delete_imaging_center(id) {
	if($('.tipsy-inner')) {
		$('.tipsy-inner').remove();
	}

	var id = parseInt(id);
	$.post(base_url + 'cases/delete_imaging_center',{id:id},function(o) {
		imaging_center_list();
	});
}

function doctor_list() {
	$('#doctor_list_wrapper').html(default_ajax_loader);
	$.post(base_url + "cases/doctor_list",{},function(o){
		$('#doctor_list_wrapper').html(o);
	});
}

function add_doctor() {
	$.post(base_url + 'cases/add_doctor_form',{},function(o) {
		$('#add_doctor_modal_wrapper').html(o);
		$('#add_doctor_modal_wrapper').modal();
		
		$('#add_doctor_modal_wrapper').on('hidden', function () {
		  $("#add_doctor_form").validationEngine('hide');
		});
	});
}

function edit_doctor(id) {
	var id = parseInt(id);
	$.post(base_url + 'cases/edit_doctor_form',{id:id},function(o) {
		$('#edit_doctor_modal_wrapper').html(o);
		$('#edit_doctor_modal_wrapper').modal();
		
		$('#edit_doctor_modal_wrapper').on('hidden', function () {
		  $("#edit_doctor_form").validationEngine('hide');
		});
	});
}

function delete_doctor(id) {
	if($('.tipsy-inner')) {
		$('.tipsy-inner').remove();
	}

	var id = parseInt(id);
	$.post(base_url + 'cases/delete_doctor',{id:id},function(o) {
		doctor_list();
	});
}

function chiropractor_list() {
	$('#chiropractor_list_wrapper').html(default_ajax_loader);
	$.post(base_url + "cases/chiropractor_list",{},function(o){
		$('#chiropractor_list_wrapper').html(o);
	});
}

function add_chiropractor() {
	$.post(base_url + 'cases/add_chiropractor_form',{},function(o) {
		$('#add_chiropractors_modal_wrapper').html(o);
		$('#add_chiropractors_modal_wrapper').modal();
		
		$('#add_chiropractors_modal_wrapper').on('hidden', function () {
		  $("#add_chiropractor_form").validationEngine('hide');
		});
	});
}


function edit_chiropractor(id) {
	var id = parseInt(id);
	$.post(base_url + 'cases/edit_chiropractor_form',{id:id},function(o) {
		$('#edit_chiropractors_modal_wrapper').html(o);
		$('#edit_chiropractors_modal_wrapper').modal();
		
		$('#edit_chiropractors_modal_wrapper').on('hidden', function () {
		  $("#edit_chiropractor_form").validationEngine('hide');
		});
	});
}

function delete_chiropractor(id) {
	if($('.tipsy-inner')) {
		$('.tipsy-inner').remove();
	}

	var id = parseInt(id);
	$.post(base_url + 'cases/delete_chiropractor',{id:id},function(o) {
		chiropractor_list();
	});
}

function therapist_list() {
	$('#therapist_list_wrapper').html(default_ajax_loader);
	$.post(base_url + "cases/therapist_list",{},function(o){
		$('#therapist_list_wrapper').html(o);
	});
}

function add_therapist() {
	$.post(base_url + 'cases/add_therapist_form',{},function(o) {
		$('#add_therapist_modal_wrapper').html(o);
		$('#add_therapist_modal_wrapper').modal();
		
		$('#add_therapist_modal_wrapper').on('hidden', function () {
		  $("#add_therapist_form").validationEngine('hide');
		});
	});
}

function edit_therapist(id) {
	var id = parseInt(id);
	$.post(base_url + 'cases/edit_therapist_form',{id:id},function(o) {
		$('#edit_therapist_modal_wrapper').html(o);
		$('#edit_therapist_modal_wrapper').modal();
		
		$('#edit_therapist_modal_wrapper').on('hidden', function () {
		  $("#edit_therapist_form").validationEngine('hide');
		});
	});
}

function delete_therapy(id) {
	if($('.tipsy-inner')) {
		$('.tipsy-inner').remove();
	}

	var id = parseInt(id);
	$.post(base_url + 'cases/delete_therapy',{id:id},function(o) {
		therapist_list();
	});
}

function referred_client_list() {
	$('#referred_client_list_wrapper').html(default_ajax_loader);
	$.post(base_url + "cases/referred_client_list",{},function(o){
		$('#referred_client_list_wrapper').html(o);
	});
}

function add_referred_client() {
	$.post(base_url + 'cases/add_referred_client_form',{},function(o) {
		$('#add_referred_client_modal_wrapper').html(o);
		$('#add_referred_client_modal_wrapper').modal();
		
		$('#add_referred_client_modal_wrapper').on('hidden', function () {
		  $("#add_referred_client_form").validationEngine('hide');
		});
	});
}

function edit_referred_client(id) {
	var id = parseInt(id);
	$.post(base_url + 'cases/edit_referred_client_form',{id:id},function(o) {
		$('#edit_referred_client_modal_wrapper').html(o);
		$('#edit_referred_client_modal_wrapper').modal();
		
		$('#edit_referred_client_modal_wrapper').on('hidden', function () {
		  $("#edit_referred_client_form").validationEngine('hide');
		});
	});
}

function delete_referred_client(id) {
	if($('.tipsy-inner')) {
		$('.tipsy-inner').remove();
	}

	var id = parseInt(id);
	$.post(base_url + 'cases/delete_referred_client',{id:id},function(o) {
		referred_client_list();
	});
}

function medical_provider_list() {
	$('#medical_provider_list_wrapper').html(default_ajax_loader);
	$.post(base_url + "cases/medical_provider_list",{},function(o){
		$('#medical_provider_list_wrapper').html(o);
	});
}

function add_medical_provider() {
	$.post(base_url + 'cases/add_medical_provider_form',{},function(o) {
		$('#add_medical_provider_modal_wrapper').html(o);
		$('#add_medical_provider_modal_wrapper').modal();
		
		$('#add_medical_provider_modal_wrapper').on('hidden', function () {
		  $("#add_medical_provider_form").validationEngine('hide');
		});
	});
}

function edit_medical_provider(id) {
	var id = parseInt(id);
	$.post(base_url + 'cases/edit_medical_provider_form',{id:id},function(o) {
		$('#edit_medical_provider_modal_wrapper').html(o);
		$('#edit_medical_provider_modal_wrapper').modal();
		
		$('#edit_medical_provider_modal_wrapper').on('hidden', function () {
		  $("#edit_medical_provider_form").validationEngine('hide');
		});
	});
}

function delete_medical_provider(id) {
	if($('.tipsy-inner')) {
		$('.tipsy-inner').remove();
	}

	var id = parseInt(id);
	$.post(base_url + 'cases/delete_medical_provider',{id:id},function(o) {
		medical_provider_list();
	});
}

function preex_medical_condition_list() {
	$('#preex_medical_condition_list_wrapper').html(default_ajax_loader);
	$.post(base_url + "cases/preex_medical_condition_list",{},function(o){
		$('#preex_medical_condition_list_wrapper').html(o);
	});
}

function add_preex_medical_condition() {
	$.post(base_url + 'cases/add_preex_medical_condition_form',{},function(o) {
		$('#add_preex_medical_condition_modal_wrapper').html(o);
		$('#add_preex_medical_condition_modal_wrapper').modal();
		
		$('#add_preex_medical_condition_modal_wrapper').on('hidden', function () {
		  $("#add_preex_medical_condition_modal_wrapper_form").validationEngine('hide');
		});
	});
}

function edit_preex_medical_condition(id) {
	var id = parseInt(id);
	$.post(base_url + 'cases/edit_preex_medical_condition_form',{id:id},function(o) {
		$('#edit_preex_medical_condition_modal_wrapper').html(o);
		$('#edit_preex_medical_condition_modal_wrapper').modal();
		
		$('#edit_preex_medical_condition_modal_wrapper').on('hidden', function () {
		  $("#edit_preex_medical_condition_form").validationEngine('hide');
		});
	});
}

function delete_preex_medical_condition(id) {
	if($('.tipsy-inner')) {
		$('.tipsy-inner').remove();
	}

	var id = parseInt(id);
	$.post(base_url + 'cases/delete_preex_medical_condition',{id:id},function(o) {
		preex_medical_condition_list();
	});
}

function subsequent_accident_list() {
	$('#subsequent_accident_list_wrapper').html(default_ajax_loader);
	$.post(base_url + "cases/subsequent_accident_list",{},function(o){
		$('#subsequent_accident_list_wrapper').html(o);
	});
}

function add_subsequent_accident() {
	$.post(base_url + 'cases/add_subsequent_accident_form',{},function(o) {
		$('#add_subsuquent_accident_modal_wrapper').html(o);
		$('#add_subsuquent_accident_modal_wrapper').modal();
		
		$('#add_subsuquent_accident_modal_wrapper').on('hidden', function () {
		  $("#add_subsuquent_accident_form").validationEngine('hide');
		});
	});
}

function edit_subsequent_accident(id) {
	var id = parseInt(id);
	$.post(base_url + 'cases/edit_subsequent_accident_form',{id:id},function(o) {
		$('#edit_subsuquent_accident_modal_wrapper').html(o);
		$('#edit_subsuquent_accident_modal_wrapper').modal();
		
		$('#edit_subsuquent_accident_modal_wrapper').on('hidden', function () {
		  $("#edit_subsuquent_accident_condition_form").validationEngine('hide');
		});
	});
}

function delete_subsequent_accident(id) {
	if($('.tipsy-inner')) {
		$('.tipsy-inner').remove();
	}

	var id = parseInt(id);
	$.post(base_url + 'cases/delete_subsequent_accident',{id:id},function(o) {
		subsequent_accident_list();
	});
}


