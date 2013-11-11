var EDIT_USER_EMAIL_ADDRESS_VALID 	= true;

$("#edit_profile_settings").live('click', function() {
	edit_profile_settings();
});

function edit_profile_settings() {
	$.post(base_url + "settings/edit_profile_settings_form",{},function(o){
		$('#edit_profile_form_wrapper').html(o);
	});
}

$("#email_address").live('blur', function() {
 	var email_address 	= $('#email_address').val();
 	var user_id 		= $('#user_id').val();

 	if(email_address && validateEmail(email_address)) {
 		$('#email_address_checker_wrapper').html("<small class='gray'>Checking</small> "+default_ajax_loader);
 		$.post(base_url + "super/check_email_address_validity",{user_id:user_id, email_address:email_address},function(o) {
 			if(!o.is_successful) {
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

function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
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

	    xhr.open('post', base_url+'super/upload_user_photo', true);
	    xhr.send(fd);
	}, false);
}

$(".big_save_edit_user_button").live('click', function() {
	$('#edit_user_form').submit();
});

