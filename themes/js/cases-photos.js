function uploaded_file_list() {
	$('#uploaded_file_list_dt').html(default_ajax_loader);
	$.post(base_url + 'cases/uploaded_file_list',{},function(o) {
		$('#uploaded_file_list_dt').html(o);
	});
}
function upload_photo_form() {
	$.post(base_url + 'cases/upload_photo_form',{},function(o) {
		$('#upload_photo_form_wrapper').html(o);
		$('#upload_photo_form_wrapper').modal();
		
		$('#upload_photo_form_wrapper').on('hidden', function () {
		  uploaded_file_list();
		});
	});
}