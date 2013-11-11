var IS_GENERAL_TAB_CHANGE 				= false;
var IS_PARTY_TAB_CHANGE 				= false;
var IS_INCIDENT_DESCRIPTION_CHANGE 		= false;
var IS_INSURANCE_TAB_CHANGE 			= false;
var IS_VEHICLES_TAB_CHANGE 				= false;
var IS_INJURIES_TREATMENTS_TAB_CHANGE 	= false;
var IS_ECONOMIC_DAMAGE_TAB_CHANGE 		= false;
var IS_NOTES_TAB_CHANGE 				= false;

function reset_sidebar() {
	$('.super_sidebar').removeClass("super-active");
}

function reload_content(fragment) {
	var hash = window.location.hash;

	if(
		IS_GENERAL_TAB_CHANGE || 
		IS_PARTY_TAB_CHANGE || 
		IS_INCIDENT_DESCRIPTION_CHANGE ||
		IS_INSURANCE_TAB_CHANGE ||
		IS_VEHICLES_TAB_CHANGE ||
		IS_INJURIES_TREATMENTS_TAB_CHANGE ||
		IS_ECONOMIC_DAMAGE_TAB_CHANGE ||
		IS_NOTES_TAB_CHANGE
	) {
		var con = confirm("Data is not yet saved. Do you want to continue?");

		if(con) {
			load_page(hash);
		}
		
	} else {
		load_page(hash);
	}
}

function load_page(hash) {

	IS_GENERAL_TAB_CHANGE 				= false;
	IS_PARTY_TAB_CHANGE 				= false;
	IS_INCIDENT_DESCRIPTION_CHANGE 		= false;
	IS_INSURANCE_TAB_CHANGE 			= false;
	IS_VEHICLES_TAB_CHANGE 				= false;
	IS_INJURIES_TREATMENTS_TAB_CHANGE 	= false;
	IS_ECONOMIC_DAMAGE_TAB_CHANGE 		= false;
	IS_NOTES_TAB_CHANGE 				= false;

	$('#main_content_wrapper').html("");
	reset_sidebar();
	if(hash == "#general" || hash == "") {
		$('.case_general').addClass('super-active');
		general();

	} else if(hash == "#parties") {
		$('.case_parties').addClass('super-active');
		parties();

	} else if (hash == "#incident-description") {
		$('.case_incident_description').addClass('super-active');
		incident_description();	

	} else if(hash == "#insurance") {	
		$('.case_insurance').addClass('super-active');
		insurance();

	} else if(hash == "#vehicles") {
		$('.case_vehicles').addClass('super-active');
		vehicles();

	} else if(hash == "#injuries-treatments") {
		$('.case_injuries_treatments').addClass('super-active');
		injuries_treatment();

	} else if(hash == "#economic-damages") {
		$('.case_economic_damages').addClass('super-active');
		case_economic_damages();

	} else if(hash == "#notes") {
		$('.case_notes').addClass('super-active');
		notes();
	}
}

$(".case_injuries_treatments").live('click', function() {
	window.location.hash = "injuries-and-treatments";
	reload_content("injuries-treatments");
});

function injuries_treatment() {
	$('#main_content_wrapper').html(default_ajax_loader);
	$.post(base_url + "cases/injuries_treatments",{},function(o) {
		$("#main_content_wrapper").html(o);
	});
}

$(".case_general").live('click', function() {
	window.location.hash = "general";
	reload_content("general");
});

function general() {
	$('#main_content_wrapper').html(default_ajax_loader);
	$.post(base_url + "cases/general",{},function(o) {
		$("#main_content_wrapper").html(o);
	});
}

$(".big_save_add_general").live('click', function() {
	$('#add_general_form').submit();
});

$(".case_injuries_treatments").live('click', function() {
	window.location.hash = "injuries-treatments";
	reload_content("injuries-treatments");
});

$(".case_economic_damages").live('click', function() {
	window.location.hash = "economic-damages";
	reload_content("economic-damages");
});

$(".case_notes").live('click', function() {
	window.location.hash = "notes";
	reload_content("notes");
});

$(".case_parties").live('click', function() {
	window.location.hash = "parties";
	reload_content("parties");
	party_list();
});

function party_list() {
	$('#party_list_wrapper').html(default_ajax_loader);
	$.post(base_url + "cases/party_list",{},function(o) {
		$("#party_list_wrapper").html(o);
	});
}

function parties() {
	$('#main_content_wrapper').html(default_ajax_loader);
	$.post(base_url + "cases/parties",{},function(o) {
		$("#main_content_wrapper").html(o);
	});
}

function filter_contact_extension() {
 	var contact_type = $('#contact_information_type').val();
 	if(contact_type == "Fax" || contact_type == "Work") { 
 		$('#contact_information_extension').show();
 	} else {
 		$('#contact_information_extension').hide();
 	}
}

$("#add_contact_information_button").live('click', function() {
	add_contact_information();
});

var contact_info_counter = 0;
function add_contact_information() {
	var contact_type_id 		= "contact_type_" + contact_info_counter;
	var contact_type_select 	= '<select id="' + contact_type_id + '" name="contact_information['+contact_info_counter+'][contact_type]" class="select"><option value="Mobile">Mobile</option><option value="Work">Work</option><option value="Home">Home</option><option value="Fax">Fax</option></select>';

	var contact_type_value_id 	= "contact_type_value_" + contact_info_counter;
	var contact_type_value_text = '<input type="text" id="' + contact_type_value_id + '" name="contact_information['+contact_info_counter+'][contact_type_value]" class="textbox02">';

	var contact_type = $('#contact_information_type').val();
	if(contact_type == "Fax" || contact_type == "Work") {
		var extension_id 			= "contact_information_extension_" + contact_info_counter;
		var extension_text 			= ' <input type="text" id="' + extension_id + '" name="contact_information['+contact_info_counter+'][contact_extension]" class="textbox03" placeholder="Extension">';
	} else {
		var extension_text = "";	
	}

	var delete_button_id 		= "delete_button_" + contact_info_counter;
	var delete_button 			= '<button id="' + delete_button_id + '" name="' + delete_button_id + '" type="button" onclick="javacript:delete_contact_information('+contact_info_counter+')">Delete</button>';

	var element_id	= "contact_information_"+contact_info_counter;
	var element 	= "<ul id='"+element_id+"'><li>" + contact_type_select + "</li><li> " + contact_type_value_text + "</li><li>" + extension_text + " </li><li> " + delete_button + "</li></ul>";
	contact_info_counter++;

	$("#add_contact_information_wrapper").before(element);

	$('#'+contact_type_id).val($('#contact_information_type').val());
	$('#'+contact_type_value_id).val($('#contact_information_value').val());
	$('#'+extension_id).val($('#contact_information_extension').val());

	$('#contact_information_value').val("")
	$('#contact_information_extension').val("");
}

function delete_contact_information(element) {
	$('#contact_information_'+element).remove();
}

function filter_contact_person_extension() {
 	var contact_type = $('#contact_person_type').val();
 	if(contact_type == "Fax" || contact_type == "Work") { 
 		$('#contact_person_extension').show();
 	} else {
 		$('#contact_person_extension').hide();
 	}
}

$("#add_contact_person_button").live('click', function() {
	add_contact_person();
});

var contact_person_counter = 0;
function add_contact_person() {
	var contact_type_id 		= "contact_person_type_" + contact_person_counter;
	var contact_type_select 	= '<select id="' + contact_type_id + '" name="contact_person['+contact_person_counter+'][contact_type]" class="select"><option value="Mobile">Mobile</option><option value="Work">Work</option><option value="Home">Home</option><option value="Fax">Fax</option></select>';

	var contact_type_value_id 	= "contact_person_type_value_" + contact_person_counter;
	var contact_type_value_text = '<input type="text" id="' + contact_type_value_id + '" name="contact_person['+contact_person_counter+'][contact_type_value]" class="textbox02">';

	var contact_type = $('#contact_person_type').val();
	if(contact_type == "Fax" || contact_type == "Work") {
		var extension_id 	= "contact_person_extension_" + contact_person_counter;
		var extension_text 	= ' <input type="text" id="' + extension_id + '" name="contact_person['+contact_person_counter+'][contact_extension]" class="textbox03" placeholder="Extension">';
	} else {
		var extension_text = "";	
	}

	var delete_button_id 		= "delete_contact_person_button_" + contact_person_counter;
	var delete_button 			= '<button id="' + delete_button_id + '" name="' + delete_button_id + '" type="button" onclick="javacript:delete_contact_person('+contact_person_counter+')">Delete</button>';

	var element_id	= "contact_person_"+contact_person_counter;
	var element 	= "<ul id='"+element_id+"'><li>" + contact_type_select + "</li><li> " + contact_type_value_text + "</li><li>" + extension_text + " </li><li> " + delete_button + "</li></ul>";
	contact_person_counter++;

	$("#add_contact_person_wrapper").before(element);

	$('#'+contact_type_id).val($('#contact_person_type').val());
	$('#'+contact_type_value_id).val($('#contact_person_value').val());
	$('#'+extension_id).val($('#contact_person_extension').val());

	$('#contact_person_value').val("")
	$('#contact_person_extension').val("");
}

function delete_contact_person(element) {
	$('#contact_person_'+element).remove();
}

function upload_party_image() {
	document.getElementById('party_image_file').addEventListener('change', function(e) {
		$('#display_image_wrapper').show();
    	$('#display_image_wrapper').html("Uploading "+default_ajax_loader);
    	$('#party_image_file').hide();

		var file = this.files[0];
	    var xhr = new XMLHttpRequest(); 
	    xhr.file = file; // not necessary if you create scopes like this
	    xhr.addEventListener('progress', function(e) {

	        var done = e.position || e.loaded, total = e.totalSize || e.total;
	        //console.log('xhr progress: ' + (Math.floor(done/total*1000)/10) + '%');

	    }, false);
	    if ( xhr.upload ) {
	        xhr.upload.onprogress = function(e) {
	            var done = e.position || e.loaded, total = e.totalSize || e.total;
	            //console.log('xhr.upload progress: ' + done + ' / ' + total + ' = ' + (Math.floor(done/total*1000)/10) + '%');

	        };
	    }
	    xhr.onreadystatechange = function(e) {
	        if ( 4 == this.readyState ) {
	            //console.log(['xhr upload complete', e]);
	            $('#display_image_wrapper').hide();
	            $('#party_image_file').val("");
    			$('#party_image_file').show();
    			$("#party_display_picture").attr("src", xhr.responseText);
	        }
	    };

	    var fd = new FormData;
	    fd.append('photo', file);

	    xhr.open('post', base_url+'cases/upload_party_image', true);
	    xhr.send(fd);
	}, false);
}

function delete_party(party_id) {
	var party_id = parseInt(party_id);
	$.post(base_url + "cases/delete_party",{party_id:party_id},function(o) {
		
		if($('.tipsy-inner')) {
			$('.tipsy-inner').remove();
		}
		if(o.total_party > 0) {
			$('#parties_count_sidebar').html(o.total_party);
		    $('#parties_count_sidebar').show();
		} else {
			$('#parties_count_sidebar').hide();
		}
		party_list();

	},'json');
}

function edit_party(party_id) {
	var party_id = parseInt(party_id);
	$('#main_content_wrapper').html(default_ajax_loader);
	$.post(base_url + "cases/edit_party",{party_id:party_id},function(o) {
		$("#main_content_wrapper").html(o);
	});
}

function error_404() {
	$('.tipsy-inner').remove();
	$.blockUI({message : '<h3>Oops! Error occured. Please refresh the page!</h3>', width: 50 });
}


function contact_information_list(party_id) {
	var party_id = parseInt(party_id);
	$('#contact_information_list_wrapper').html(default_ajax_loader);
	$.post(base_url + "cases/contact_information_list",{party_id:party_id},function(o){
		$('#contact_information_list_wrapper').html(o);
	});
}

function edit_contact_information(id) {
	var party_id = parseInt($('#party_id').val());
	$.post(base_url + 'cases/edit_contact_information_form',{id:id,party_id:party_id},function(o) {
		$('#edit_contact_information_form_wrapper').html(o);
		$('#edit_contact_information_form_wrapper').modal();
		
		$('#edit_contact_information_form_wrapper').on('hidden', function () {
		  $("#edit_contact_information_form").validationEngine('hide');
		});
	});
}

function delete_contact_information_data(id) {
	var id = parseInt(id);
	$.post(base_url + 'cases/delete_contact_information_form',{id:id},function(o) {
		$('#delete_contact_information_form_wrapper').html(o);
		$('#delete_contact_information_form_wrapper').modal();
	});
}

function contact_person_list(party_id) {
	var party_id = parseInt(party_id);
	$('#contact_person_list_wrapper').html(default_ajax_loader);
	$.post(base_url + "cases/contact_person_list",{party_id:party_id},function(o){
		$('#contact_person_list_wrapper').html(o);
	});
}

function edit_contact_person(id) {
	var party_id = parseInt($('#party_id').val());
	$.post(base_url + 'cases/edit_contact_person_form',{id:id,party_id:party_id},function(o) {
		$('#edit_contact_person_form_wrapper').html(o);
		$('#edit_contact_person_form_wrapper').modal();
		
		$('#edit_contact_person_form_wrapper').on('hidden', function () {
		  $("#edit_contact_person_form").validationEngine('hide');
		});
	});
}

function delete_contact_person_data(id) {
	var id = parseInt(id);
	$.post(base_url + 'cases/delete_contact_person_form',{id:id},function(o) {
		$('#delete_contact_person_form_wrapper').html(o);
		$('#delete_contact_person_form_wrapper').modal();
	});
}

$(".big_save_add_party").live('click', function() {
	$('#add_party_form').submit();
});

$(".case_incident_description").live('click', function() {
	window.location.hash = "incident-description";
	reload_content("incident-description");
});

function incident_description() {
	$('#main_content_wrapper').html(default_ajax_loader);
	$.post(base_url + "cases/incident_description",{},function(o) {
		$("#main_content_wrapper").html(o);
	});
}

$(".big_save_add_incident_description").live('click', function() {
	$('#add_incident_description_form').submit();
});

$(".case_insurance").live('click', function() {
	window.location.hash = "insurance";
	reload_content("insurance");
	insurance_list();
});

function insurance_list() {
	$('#insurance_list_wrapper').html(default_ajax_loader);
	$.post(base_url + "cases/insurance_list",{},function(o) {
		$("#insurance_list_wrapper").html(o);
	});
}

function insurance() {
	$('#main_content_wrapper').html(default_ajax_loader);
	$.post(base_url + "cases/insurance",{},function(o) {
		$("#main_content_wrapper").html(o);
	});
}

function edit_insurance(insurance_id) {
	var insurance_id = parseInt(insurance_id);
	$('#main_content_wrapper').html(default_ajax_loader);
	$.post(base_url + "cases/edit_insurance",{insurance_id:insurance_id},function(o) {
		$("#main_content_wrapper").html(o);
	});
}

function delete_insurance(insurance_id) {
	var insurance_id = parseInt(insurance_id);
	$.post(base_url + "cases/delete_insurance",{insurance_id:insurance_id},function(o) {
		if($('.tipsy-inner')) {
			$('.tipsy-inner').remove();
		}
		
		if(o.total_insurance > 0) {
			$('#insurance_count_sidebar').html(o.total_insurance);
		    $('#insurance_count_sidebar').show();
		} else {
			$('#insurance_count_sidebar').hide();
		}
		insurance_list();

	},'json');
}

$(".case_vehicles").live('click', function() {
	window.location.hash = "vehicles";
	reload_content("vehicles");
	vehicle_list();
});

function vehicles() {
	$('#main_content_wrapper').html(default_ajax_loader);
	$.post(base_url + "cases/vehicles",{},function(o) {
		$("#main_content_wrapper").html(o);
	});
}

function vehicle_list() {
	$('#vehicle_list_wrapper').html(default_ajax_loader);
	$.post(base_url + "cases/vehicle_list",{},function(o) {
		$("#vehicle_list_wrapper").html(o);
	});
}

function edit_vehicle(vehicle_id) {
	var vehicle_id = parseInt(vehicle_id);
	$('#main_content_wrapper').html(default_ajax_loader);
	$.post(base_url + "cases/edit_vehicle",{vehicle_id:vehicle_id},function(o) {
		$("#main_content_wrapper").html(o);
	});
}

function delete_vehicle(vehicle_id) {
	var vehicle_id = parseInt(vehicle_id);
	$.post(base_url + "cases/delete_vehicle",{vehicle_id:vehicle_id},function(o) {
		
		if($('.tipsy-inner')) {
			$('.tipsy-inner').remove();
		}
		if(o.total_vehicles > 0) {
			$('#vehicles_count_sidebar').html(o.total_vehicles);
		    $('#vehicles_count_sidebar').show();
		} else {
			$('#vehicles_count_sidebar').hide();
		}
		vehicle_list();

	},'json');
}



function case_economic_damages() {
	$('#main_content_wrapper').html(default_ajax_loader);
	$.post(base_url + "cases/economic_damages",{},function(o) {
		$("#main_content_wrapper").html(o);
	});
}

function notes() {
	$('#main_content_wrapper').html(default_ajax_loader);
	$.post(base_url + "cases/notes",{},function(o) {
		$("#main_content_wrapper").html(o);
	});
}