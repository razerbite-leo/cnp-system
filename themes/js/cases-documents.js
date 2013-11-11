function document_list() {
	$('#document_list_dt_wrapper').html(default_ajax_loader);
	$.post(base_url + "cases/document_list_dt",{},function(o) {
		$("#document_list_dt_wrapper").html(o);
	});
}

function preview_document(id) {
	$.post(base_url + 'cases/preview_document',{id:id},function(o) {
		$('#preview_document_form_wrapper').html(o);
		$('#preview_document_form_wrapper').modal();
		
		$('#preview_document_form_wrapper').on('hidden', function () {
		  $("#preview_document_form").validationEngine('hide');
		});
	});
}

function preapproved_document(id) {
	var is_approved = $('#ck_'+id).prop('checked');
	var is_approved = (is_approved ? 1 : 2);

	$.post(base_url + "cases/preprocess_document",{id:id, is_approved:is_approved},function(o) {
		//document_list();
	});
}