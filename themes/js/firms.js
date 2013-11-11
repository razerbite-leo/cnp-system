var ADD_USER_EMAIL_ADDRESS_VALID 	= true;
var EDIT_USER_EMAIL_ADDRESS_VALID 	= true;
var ADD_USER_USERNAME_VALID 		= true;
var ADD_FIRM_EMAIL_ADDRESS_VALID 	= true
var EDIT_FIRM_EMAIL_ADDRESS_VALID 	= true;

var IS_ADD_USER_FORM_CHANGE 	= false;
var IS_EDIT_USER_FORM_CHANGE 	= false;
var IS_ADD_FIRM_FORM_CHANGE 	= false;
var IS_EDIT_FIRM_FORM_CHANGE 	= false;


function reset_topbar() {
	$('.firm_admin_topbar').removeClass('hidden');
	$('.firm_admin_topbar').addClass('hidden');
	$('.firm_admin_topbar').removeClass('active-bar');
}

function reset_sidebar() {
	$('.super_sidebar').removeClass("super-active");
}

function hide_edit_topbar() {
	$('#edit_user_topbar').hide();
	$('#edit_firm_topbar').hide();
	$('#edit_document_topbar').hide();
	$('#add_document_topbar').hide();
}

function reload_content(fragment) {
	var hash = window.location.hash;

	if(
		IS_ADD_USER_FORM_CHANGE ||
		IS_EDIT_USER_FORM_CHANGE ||
		IS_ADD_FIRM_FORM_CHANGE ||
		IS_EDIT_FIRM_FORM_CHANGE
		
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

	IS_ADD_USER_FORM_CHANGE 	= false;
	IS_EDIT_USER_FORM_CHANGE 	= false;
	IS_ADD_FIRM_FORM_CHANGE 	= false;
	IS_EDIT_FIRM_FORM_CHANGE	= false;

	reset_topbar();
	reset_sidebar();
	hide_edit_topbar();
	$('#main_content_wrapper').html("");

	if(hash == "#account-settings") {
		$('#account_settings_topbar').removeClass("hidden");
		$('#account_settings_topbar').addClass('active-bar');
		$('.firm_account_settings').addClass('super-active');

		account_settings();

	} else if(hash == "#manage-user" || hash == "") {
		$('#manage_users_topbar').removeClass("hidden");
		$('#manage_users_topbar').addClass('active-bar');
		$('.firm_admin_manage_user').addClass('super-active');

		manage_user_list();
	} else if (hash == "#add-user") {
		$('#add_user_topbar').removeClass("hidden");
		$('#add_user_topbar').addClass('active-bar');
		$('.firm_admin_manage_user').addClass('super-active');

		add_user_form();
	} else if(hash == "#cases") {
		$('.firm_admin_cases').addClass('super-active');

	} else if(hash == "#manage-document") {
		$('#manage_document_topbar').removeClass("hidden");
		$('#manage_document_topbar').addClass('active-bar');
		$('.firm_admin_documents').addClass('super-active');

		manage_document(0);
	}
}

function account_settings() {
	$('#main_content_wrapper').html(default_ajax_loader);
	$.post(base_url + "firms/account_settings",{},function(o) {
		$("#main_content_wrapper").html(o);
	});
}

function add_user_form() {
	$('#main_content_wrapper').html(default_ajax_loader);
	$.post(base_url + "firms/add_user",{},function(o) {
		$("#main_content_wrapper").html(o);
	});
}

function manage_user_list() {
	$('#main_content_wrapper').html(default_ajax_loader);
	$.post(base_url + "firms/manage_user_list",{},function(o) {
		$("#main_content_wrapper").html(o);
	});
}

var contact_info_counter = 0;
function add_other_contact_info() {
	//var contact_type = "<span>" + $("#contact_type option:selected").text() + "</span>";

	var contact_type_id 		= "contact_type_" + contact_info_counter;
	var contact_type_select 	= '<select id="' + contact_type_id + '" name="other_contact['+contact_info_counter+'][contact_type]" class="select"><option value="Mobile">Mobile</option><option value="Work">Work</option><option value="Home">Home</option><option value="Fax">Fax</option></select>';

	var contact_type_value_id 	= "contact_type_value_" + contact_info_counter;
	var contact_type_value_text = '<input type="text" id="' + contact_type_value_id + '" name="other_contact['+contact_info_counter+'][contact_type_value]" class="textbox02">';

	var contact_type = $('#contact_type').val();
	if(contact_type == "Fax" || contact_type == "Work") {
		var extension_id 			= "contact_extension_user_" + contact_info_counter;
		var extension_text 			= ' <input type="text" id="' + extension_id + '" name="other_contact['+contact_info_counter+'][contact_extension]" class="textbox03" placeholder="Extension">';
	} else {
		var extension_text = "";	
	}

	var delete_button_id 		= "delete_button_" + contact_info_counter;
	var delete_button 			= '<button id="' + delete_button_id + '" name="' + delete_button_id + '" type="button" onclick="javacript:delete_other_contact_info('+contact_info_counter+')">Delete</button>';

	var element_id	= "other_contact_"+contact_info_counter;
	var element 	= "<ul id='"+element_id+"'><li>" + contact_type_select + "</li><li> " + contact_type_value_text + "</li><li>" + extension_text + " </li><li> " + delete_button + "</li></ul>";
	contact_info_counter++;
	//$("#other_contact_list_wrapper").before('<input type="text" name="inputName" size="10" maxlength="10" class="someClass" />');
	$("#other_contact_list_wrapper").before(element);

	$('#'+contact_type_id).val($('#contact_type').val());
	$('#'+contact_type_value_id).val($('#contact_type_value').val());
	$('#'+extension_id).val($('#contact_extension_user').val());

	$('#contact_type_value').val("")
	$('#contact_extension_user').val("");
}

function delete_other_contact_info(element) {
	$('#other_contact_'+element).remove();
}

 $(".add_user_button").live('click', function() {
 	window.location.hash = "add-user"
    reload_content("add-user");
 });

$(".firm_admin_manage_user").live('click', function() {
	window.location.hash = "manage-user"
	reload_content("add-user");
});

$(".firm_account_settings").live('click', function() {
	window.location.hash = "account-settings"
	reload_content("account-settings");
});

$(".firm_admin_documents").live('click', function() {
	window.location.hash = "manage-document"
	reload_content("manage-document");
});


$("#add_user_link").live('click', function() {
	$('#add_user_form').submit();
});


$(".firm_admin_cases").live('click', function() {
	window.location.hash = "cases"
	reload_content("cases");
});

$("#add_number_btn").live('click', function() {
	add_other_contact_info();
});



$("#email_address").live('blur', function() {
 	var email_address 	= $('#email_address').val();
 	var user_id 		= $('#user_id').val();

 	if(email_address && validateEmail(email_address)) {
 		$('#email_address_checker_wrapper').html("<small class='gray'>Checking</small> "+default_ajax_loader);
 		$.post(base_url + "firms/check_email_address_validity",{user_id:user_id, email_address:email_address},function(o) {
 			if(!o.is_successful) {
	 			ADD_USER_EMAIL_ADDRESS_VALID = o.is_successful;
	 			EDIT_USER_EMAIL_ADDRESS_VALID = o.is_successful;
				$('#email_address_checker_wrapper').html("<small>"+o.message+"</small>");
			} else {
				$('#email_address_checker_wrapper').html("");		
			}
		},'json');
 	} else {
 		$('#email_address_checker_wrapper').html("");
 	}

});


 $("#username").live('blur', function() {
 	var username = $('#username').val();
 	if(username) {
 		$('#username_checker_wrapper').html("<small class='gray'>Checking</small> "+default_ajax_loader);
 		$.post(base_url + "firms/check_username_validity",{username:username},function(o) {
 			if(!o.is_successful) {
	 			ADD_USER_USERNAME_VALID = o.is_successful;
				$('#username_checker_wrapper').html("<small>"+o.message+"</small>");
			} else {
				$('#username_checker_wrapper').html("");		
			}
		},'json');
 	}
 });


function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
} 


$(".add_contact_list_firm_button").live('click', function() {
 	add_contact_list_firm();
});

function filter_extension_user() {
 	var contact_type = $('#contact_type').val();
 	if(contact_type == "Fax" || contact_type == "Work") { 
 		$('#contact_extension_user').show();
 	} else {
 		$('#contact_extension_user').hide();
 	}
}

function edit_user(param_id) {
	var id = parseInt(param_id);
	$('.firm_admin_topbar').addClass("hidden");
	$('#edit_user_topbar').show();
	$('#main_content_wrapper').html(default_ajax_loader);
	$.post(base_url + "firms/edit_user",{id:id},function(o) {
		$('#main_content_wrapper').html(o);
	});
}

function error_404() {
	$('.tipsy-inner').remove();
	$.blockUI({message : '<h3>Oops! Error occured. Please refresh the page!</h3>', width: 50 });
}

function load_user_current_contact_list(user_id) {
	$('#user_current_contact_list_wrapper').html(default_ajax_loader);
	$.post(base_url + "firms/user_current_contact_list",{user_id:user_id},function(o){
		$('#user_current_contact_list_wrapper').html(o);
	});
}

function edit_user_contact(id) {
	$.post(base_url + 'super/edit_user_contact_form',{id:id},function(o) {
		$('#edit_user_contact_form_wrapper').html(o);
		$('#edit_user_contact_form_wrapper').modal();
		
		$('#edit_user_contact_form_wrapper').on('hidden', function () {
		  $("#edit_user_contact_form").validationEngine('hide');
		});
	});
}

function delete_user_contact(id) {
	$.post(base_url + 'firms/delete_user_contact_form',{id:id},function(o) {
		$('#delete_user_contact_form_wrapper').html(o);
		$('#delete_user_contact_form_wrapper').modal();
	});
}

function delete_user(id) {
	$.post(base_url + 'firms/delete_user_form',{id:id},function(o) {
		$('#delete_user_form_wrapper').html(o);
		$('#delete_user_form_wrapper').modal();
	});
}

function upload_firm_photo() {
	document.getElementById('file').addEventListener('change', function(e) {
		$('#image_photo_wrapper').show();
    	$('#image_photo_wrapper').html("Uploading "+default_ajax_loader);
    	$('#file').hide();

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
	            $('#image_photo_wrapper').hide();
	            $('#file').val("");
    			$('#file').show();
    			$("#firm_display_picture").attr("src", xhr.responseText);
	        }
	    };

	    var fd = new FormData;
	    fd.append('photo', file);

	    xhr.open('post', base_url+'firms/upload_firm_photo', true);
	    xhr.send(fd);
	}, false);
}

function upload_user_photo() {
	document.getElementById('user_display_picture_file').addEventListener('change', function(e) {
		$('#display_image_wrapper').show();
    	$('#display_image_wrapper').html("Uploading "+default_ajax_loader);
    	$('#user_display_picture_file').hide();

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
	            $('#user_display_picture_file').val("");
    			$('#user_display_picture_file').show();
    			$("#user_display_picture").attr("src", xhr.responseText);
	        }
	    };

	    var fd = new FormData;
	    fd.append('photo', file);

	    xhr.open('post', base_url+'firms/upload_user_photo', true);
	    xhr.send(fd);
	}, false);
}


var add_contact_list_firm_counter = 0;
function add_contact_list_firm() {
	var contact_type_id 		= "contact_type_firm_" + add_contact_list_firm_counter;
	var contact_type_select 	= '<select id="' + contact_type_id + '" name="other_contact['+add_contact_list_firm_counter+'][contact_type]" class="select02" ><option value="Mobile">Mobile</option><option value="Work">Work</option><option value="Home">Home</option><option value="Fax">Fax</option></select>';

	var contact_type_value_id 	= "contact_value_firm_" + add_contact_list_firm_counter;
	var contact_type_value_text = '<input type="text" id="' + contact_type_value_id + '" name="other_contact['+add_contact_list_firm_counter+'][contact_type_value]" class="textbox02" placeholder="(___) 000-0000">';


	var contact_type_firm = $('#contact_type_firm').val();
	if(contact_type_firm == "Fax" || contact_type_firm == "Work") {
		var extension_id 			= "contact_extension_firm_" + add_contact_list_firm_counter;
		var extension_text 			= ' <input type="text" id="' + extension_id + '" name="other_contact['+add_contact_list_firm_counter+'][contact_extension]" class="textbox03" placeholder="Extension">';
	} else {
		var extension_text = "";	
	}

	var delete_button_id 		= "delete_button_" + add_contact_list_firm_counter;
	var delete_button 			= '<button id="' + delete_button_id + '" name="' + delete_button_id + '" type="button" onclick="javacript:delete_other_contact_info('+add_contact_list_firm_counter+')">Delete</button>';

	var element_id	= "other_contact_"+add_contact_list_firm_counter;
	var element 	= "<ul id='"+element_id+"'><li>" + contact_type_select + "</li> <li> " + contact_type_value_text + "</li><li>" + extension_text + " </li><li> " + delete_button + " </li></ul>";
	add_contact_list_firm_counter++;
	
	$("#add_contact_list_firm_wrapper").before(element);

	$('#'+contact_type_id).val($('#contact_type_firm').val());
	$('#'+contact_type_value_id).val($('#contact_value_firm').val());
	$('#'+extension_id).val($('#contact_extension_firm').val());

	$('#contact_value_firm').val("")
	$('#contact_extension_firm').val("")
}

function filter_extension_firm() {
 	var contact_type_firm = $('#contact_type_firm').val();
 	if(contact_type_firm == "Fax" || contact_type_firm == "Work") { 
 		$('#contact_extension_firm').show();
 	} else {
 		$('#contact_extension_firm').hide();
 	}
}

$("#email_address_firm").live('blur', function() {
	var email_address 	= $('#email_address_firm').val();
	var firm_id 		= $('#firm_id').val();

	if(email_address && validateEmail(email_address)) {
		$('#email_address_checker_wrapper').html("<small class='gray'>Checking</small> "+default_ajax_loader);
		$.post(base_url + "super/check_email_address_firm_validity",{firm_id:firm_id, email_address:email_address},function(o) {
			if(!o.is_successful) {
			$('#email_address_checker_wrapper').html("<small>"+o.message+"</small>");
		} else {
			$('#email_address_checker_wrapper').html("");		
		}
		EDIT_FIRM_EMAIL_ADDRESS_VALID = o.is_successful;
	},'json');
	} else {
		$('#email_address_checker_wrapper').html("");
	}

});

function load_firm_current_contact_list(firm_id) {
	$('#firm_current_contact_list_wrapper').html(default_ajax_loader);
	$.post(base_url + "firms/firm_current_contact_list",{firm_id:firm_id},function(o){
		$('#firm_current_contact_list_wrapper').html(o);
	});
}

function edit_firm_contact(id) {
	$.post(base_url + 'firms/edit_firm_contact_form',{id:id},function(o) {
		$('#edit_firm_contact_form_wrapper').html(o);
		$('#edit_firm_contact_form_wrapper').modal();
		
		$('#edit_firm_contact_form_wrapper').on('hidden', function () {
		  $("#edit_firm_contact_form").validationEngine('hide');
		});
	});
}

function delete_firm_contact(id) {
	$.post(base_url + 'firms/delete_firm_contact_form',{id:id},function(o) {
		$('#delete_firm_contact_form_wrapper').html(o);
		$('#delete_firm_contact_form_wrapper').modal();
	});
}

$("#edit_firm_link").live('click', function() {
	$('#edit_firm_form').submit();
});

function manage_document(parent_id) {
	$('#manage_document_topbar').removeClass("hidden");
	$('#manage_document_topbar').addClass('active-bar');
	$('.firm_admin_documents').addClass('super-active');

	$('#main_content_wrapper').html(default_ajax_loader);
	$.post(base_url + "firms/manage_document",{parent_id:parent_id},function(o) {
		$("#main_content_wrapper").html(o);
	});
}

function document_list(parent_id) {
	var parent_id = parseInt(parent_id);
	$('#document_list_dt_wrapper').html(default_ajax_loader);
	$.post(base_url + "firms/document_list_dt",{parent_id:parent_id},function(o) {
		$("#document_list_dt_wrapper").html(o);
	});
}

function shared_document_list(parent_id) {
	var parent_id = parseInt(parent_id);
	$('#shared_document_list_dt_wrapper').html(default_ajax_loader);
	$.post(base_url + "firms/shared_document_list_dt",{parent_id:parent_id},function(o) {
		$("#shared_document_list_dt_wrapper").html(o);
	});
}

$(".upload_document_image_button").live('click', function() {
	upload_document_image();
});

function upload_document_image() {
	var current_parent_id = $('#current_parent_id').val();
	$.post(base_url + 'firms/upload_document_image_form',{current_parent_id:current_parent_id},function(o) {
		$('#upload_document_image_form_wrapper').html(o);
		$('#upload_document_image_form_wrapper').modal();

		$('#upload_document_image_form_wrapper').on('hidden', function () {
			document_list(current_parent_id);
		});
	});
}

$(".add_document_set_button").live('click', function() {
	add_document_set();
});

function add_document_set() {
	$.post(base_url + 'firms/add_document_set_form',{},function(o) {
		$('#add_document_set_form_wrapper').html(o);
		$('#add_document_set_form_wrapper').modal();
		
		$('#add_document_set_form_wrapper').on('hidden', function () {
		  $("#add_document_set_form").validationEngine('hide');
		});
	});
}

function edit_document_set(id) {
	var id = parseInt(id);
	$.post(base_url + 'firms/edit_document_set_form',{id:id},function(o) {
		$('#edit_document_set_form_wrapper').html(o);
		$('#edit_document_set_form_wrapper').modal();
		
		$('#edit_document_set_form_wrapper').on('hidden', function () {
		  $("#edit_document_set_form").validationEngine('hide');
		});
	});
}

$(".add_document_button").live('click', function() {
	add_document();
});

function add_document() {
	var current_parent_id 	= parseInt($('#current_parent_id').val());
	$('.firm_admin_topbar').addClass("hidden");
	$('#add_document_topbar').show();
	$('#main_content_wrapper').html(default_ajax_loader);
	$.post(base_url + 'firms/add_document_form',{current_parent_id:current_parent_id},function(o) {
		$('#main_content_wrapper').html(o);
	});
}

function edit_document(document_id) {
	var id = parseInt(document_id);
	var current_parent_id = parseInt($('#current_parent_id').val());
	$('.firm_admin_topbar').addClass("hidden");
	$('#edit_document_topbar').show();
	$('#main_content_wrapper').html(default_ajax_loader);
	$.post(base_url + 'firms/edit_document_form',{id:id,current_parent_id:current_parent_id},function(o) {
		$('#main_content_wrapper').html(o);
	});
}

function delete_document(id) {
	var id = parseInt(id);
	var current_parent_id = parseInt($('#current_parent_id').val());
	$.post(base_url + 'firms/delete_document_form',{id:id},function(o) {
		$('#delete_document_form_wrapper').html(o);
		$('#delete_document_form_wrapper').modal();
	});
}

function delete_document_set(id) {
	$.post(base_url + 'firms/delete_document_set_form',{id:id},function(o) {
		$('#delete_document_set_form_wrapper').html(o);
		$('#delete_document_set_form_wrapper').modal();
	});
}

function upload_document_image_edit() {

	document.getElementById('document_image_file').addEventListener('change', function(e) {
		$('#document_image_wrapper').show();
    	$('#document_image_wrapper').html("Uploading "+default_ajax_loader);
    	

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
	            $('#document_image_wrapper').hide();
	            $('#document_image_file').val("");
    			$('#document_image_file').show();
    			$("#document_image").attr("src", xhr.responseText);
	        }
	    };

	    var fd = new FormData;
	    fd.append('photo', file);

	    xhr.open('post', base_url+'firms/upload_document_image', true);
	    xhr.send(fd);
	}, false);
}

function edit_document_image(id) {
	var id = parseInt(id);
	$.post(base_url + 'firms/edit_document_image_form',{id:id},function(o) {
		$('#edit_document_image_form_wrapper').html(o);
		$('#edit_document_image_form_wrapper').modal();
		
		$('#edit_document_image_form_wrapper').on('hidden', function () {
		  $("#edit_document_image_form").validationEngine('hide');
		});
	});
}


function delete_document_image(id) {
	var id = parseInt(id);
	var current_parent_id = parseInt($('#current_parent_id').val());
	$.post(base_url + 'firms/delete_document_image_form',{id:id},function(o) {
		$('#delete_document_image_form_wrapper').html(o);
		$('#delete_document_image_form_wrapper').modal();
	});
}

function case_alloted_list() {
	$('#case_alloted_wrapper').html(default_ajax_loader);
	$.post(base_url + "super/case_alloted_list",{},function(o) {
		$("#case_alloted_wrapper").html(o);
	});
}

function case_alloted_history_list(firm_id) {
	$('.case_rows').removeClass("case_alloted_active");
	$('.row_'+firm_id).addClass("case_alloted_active");
	
	var firm_id = parseInt(firm_id);
	$('#case_alloted_history_wrapper').html(default_ajax_loader);
	$.post(base_url + "super/case_alloted_history_list",{firm_id:firm_id},function(o) {
		$("#case_alloted_history_wrapper").html(o);
	});
}

function openWindow(user_id) {
	var user_id = parseInt(user_id);
	var url = base_url + "authenticate/case/"+user_id;
	window.open(url, '_blank');
	window.focus();
}

function show_breadcrumbs(parent_id) {
	var parent_id = parseInt(parent_id);
}

function change_document_visibility(id) {

	var id = parseInt(id);
	var is_visible = ($("#cb_visible_"+id).prop("checked") == true ? "Yes" : "No");

	$.post(base_url + "firms/change_document_visibility",{id:id,is_visible:is_visible},function(o) {
		
	});
}