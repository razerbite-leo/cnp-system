<script>
	$(function() {
		$('#delete_user_form').ajaxForm({
			success:function(o) {
				if(o.is_successful) {
          			default_success_confirmation({message : o.message, alert_type: "alert-success"});
          		} else {
          			default_success_confirmation({message : o.message, alert_type: "alert-error"});
          		}

          		$('.delete_user_top_form_wrapper').modal('hide');
				$('#delete_user_form_modal_wrapper').modal('hide');
				window.location.hash = "manage-user";
    			reload_content("manage-user");
    			$('html,body').animate({scrollTop: $("#alert_confirmation_wrapper").offset().top},10);
				
			}, beforeSubmit: function(o) {

			},
			dataType : "json"

		});
	});
</script>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 id="myModalLabel">Delete User? </h4>
</div>
<div class="modal-body">
	<form id="delete_user_form" name="delete_user_form" method="post" action="<?php echo url('super/delete_user'); ?>">
		<input type="hidden" id="id" name="id" value="<?php echo $user['id']; ?>">
		Are you sure you want to delete <b><?php echo "{$user['firstname']} {$user['lastname']}"; ?></b> in the database? This will be permanently deleted.
	</form>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button class="btn btn-danger submit_button" onclick="$('#delete_user_form').submit();">Delete</button>
</div>

