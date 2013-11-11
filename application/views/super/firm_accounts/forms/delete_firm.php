<script>
	$(function() {
		$('#delete_firm_form').ajaxForm({
			success:function(o) {
				if(o.is_successful) {
          			default_success_confirmation({message : o.message, alert_type: "alert-success"});
          		} else {
          			default_success_confirmation({message : o.message, alert_type: "alert-error"});
          		}

				$('.delete_firm_top_form_wrapper').modal('hide');
				$('#delete_firm_form_wrapper').modal('hide');
				window.location.hash = "firm-accounts";
    			reload_content("firm-accounts");
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
	<form id="delete_firm_form" name="delete_firm_form" method="post" action="<?php echo url('super/delete_firm'); ?>">
		<input type="hidden" id="id" name="id" value="<?php echo $firm['id']; ?>">
		Are you sure you want to delete <b><?php echo "{$firm['firm_name']}"; ?></b> in the database? This will be permanently deleted.
		</form>
	</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button class="btn btn-danger submit_button" onclick="$('#delete_firm_form').submit();">Delete</button>
</div>

