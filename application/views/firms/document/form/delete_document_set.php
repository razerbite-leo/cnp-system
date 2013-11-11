<script>
	$(function() {
		$('#delete_document_set_form').ajaxForm({
			success:function(o) {
				$('#delete_document_set_form_wrapper').modal('hide');
				document_list(0);
			}, beforeSubmit: function(o) {
			},
		});
	});
</script>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 id="myModalLabel">Delete Document Set? </h4>
</div>
<div class="modal-body">
	<form id="delete_document_set_form" name="delete_document_set_form" method="post" action="<?php echo url('firms/delete_document_set'); ?>">
		<input type="hidden" id="id" name="id" value="<?php echo $document['id']; ?>">
		Are you sure you want to document set? Sub documents and file will be also deleted.
	</form>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button class="btn btn-danger submit_button" onclick="$('#delete_document_set_form').submit();">Delete</button>
</div>

