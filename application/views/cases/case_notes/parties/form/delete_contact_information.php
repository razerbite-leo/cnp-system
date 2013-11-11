<script>
	$(function() {
		$('#delete_contact_information_form').ajaxForm({
			success:function(o) {
				$('#delete_contact_information_form_wrapper').modal('hide');
				contact_information_list("<?php echo $contact['party_id']; ?>");
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
	<form id="delete_contact_information_form" name="delete_contact_information_form" method="post" action="<?php echo url('cases/delete_contact_information'); ?>">
		<input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
            <input type="hidden" id="edit_contact_party_id" name="party_id" value="<?php echo $contact['party_id']; ?>">
		Are you sure you want to delete contact?
	</form>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button class="btn btn-danger submit_button" onclick="$('#delete_contact_information_form').submit();">Delete</button>
</div>

