<script>
	$(function() {
		$('#delete_firm_contact_form').ajaxForm({
			success:function(o) {
				$('#delete_firm_contact_form_wrapper').modal('hide')
				load_firm_current_contact_list("<?php echo $cl['firm_id']; ?>");
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
<form id="delete_firm_contact_form" name="delete_firm_contact_form" method="post" action="<?php echo url('firms/delete_firm_contact'); ?>">
<input type="hidden" id="id" name="id" value="<?php echo $cl['id']; ?>">
Are you sure you want to delete contact?

</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button class="btn btn-danger submit_button" onclick="$('#delete_firm_contact_form').submit();">Delete</button>
</div>

</form>