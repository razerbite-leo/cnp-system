<script>
	$(function() {
		$('#delete_user_contact_form').ajaxForm({
			success:function(o) {
				$('#delete_user_contact_form_wrapper').modal('hide');
				load_user_current_contact_list("<?php echo $cl['user_id']; ?>");
			}, beforeSubmit: function(o) {
			},
		});
	});
</script>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 id="myModalLabel">Delete Contact? </h4>
</div>
<div class="modal-body">
	<form id="delete_user_contact_form" name="delete_user_contact_form" method="post" action="<?php echo url('super/delete_user_contact'); ?>">
		<input type="hidden" id="id" name="id" value="<?php echo $cl['id']; ?>">
		Are you sure you want to delete contact?
	</form>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button class="btn btn-danger submit_button" onclick="$('#delete_user_contact_form').submit();">Delete</button>
</div>

