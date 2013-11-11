<script>
	$(function() {
		$('#delete_document_form').ajaxForm({
			success:function(o) {
				$('#delete_document_top_form_wrapper').modal('hide');
				$('#edit_document_topbar').hide();
				manage_document(<?php echo $document['parent_id']; ?>);
			}, beforeSubmit: function(o) {
			},
		});
	});
</script>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 id="myModalLabel">Delete Case Document? </h4>
</div>
<div class="modal-body">
	<form id="delete_document_form" name="delete_document_form" method="post" action="<?php echo url('firms/delete_document'); ?>">
		<input type="hidden" id="id" name="id" value="<?php echo $document['id']; ?>">
		Are you sure you want to delete the case document?
	</form>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button class="btn btn-danger submit_button" onclick="$('#delete_document_form').submit();">Delete</button>
</div>

