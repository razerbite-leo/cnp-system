<script>
	$(function() {
		$('#delete_document_form').ajaxForm({
			success:function(o) {
				$('#delete_document_image_form_wrapper').modal('hide');
				var current_parent_id = $('#current_parent_id').val();
				document_list(current_parent_id);
			}, beforeSubmit: function(o) {
			},
		});
	});
</script>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 id="myModalLabel">Delete Case Document Image? </h4>
</div>
<div class="modal-body">
	<form id="delete_document_form" name="delete_document_form" method="post" action="<?php echo url('firms/delete_document_image'); ?>">
		<input type="hidden" id="id" name="id" value="<?php echo $document['id']; ?>">
		Are you sure you want to delete?
		<br/>
		<br/>
		<?php $src = $document['path']."resize/".$document['filename']; ?>
		<div class="delete_document_image_modal">
			<img class="modal_image_placeholder" src="<?php echo $src; ?>">
		</div>
	</form>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button class="btn btn-danger submit_button" onclick="$('#delete_document_form').submit();">Delete</button>
</div>

<style>
	.delete_document_image_modal img {border: 1px solid #CCCCCC;border-radius: 5px 5px 5px 5px;margin: 0;padding: 2%; position: relative; left: 30%; height: 120px; width: 120px;}

</style>