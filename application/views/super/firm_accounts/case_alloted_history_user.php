<script>
	$(function() {
		$('#case_availability_user_detailed_form').ajaxForm({
			success:function(o) {
				if(o.is_successful) {
          			default_success_confirmation({message : o.message, alert_type: "alert-success"});
          		} else {
          			default_success_confirmation({message : o.message, alert_type: "alert-error"});
          		}

				$('.delete_firm_top_form_wrapper').modal('hide');
				$('#case_availability_user_detailed_form_wrapper').modal('hide');
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
    <h4 id="myModalLabel">User Case History </h4>
</div>
<div class="modal-body">
	<form id="case_availability_user_detailed_form" name="case_availability_user_detailed_form" method="post" action="<?php echo url('super/delete_firm'); ?>">
		<table class="datatable" style="width:100%;">
		    <thead>
			<tr>
				<th align="left" valign="top" width="10%">Case Number</th>
				<th align="left" valign="top" width="10%">Status</th>
				<th align="left" valign="top" width="10%">State</th>
				<th align="left" valign="top" width="10%">Date</th>
				<th align="left" valign="top" width="10%"></th>
			</tr>
		    </thead>
		    <tbody>
		    	<tr>
		    		<td align="left" valign="top" width="10%">0001</td>
			    	<td align="left" valign="top" width="10%">Active</td>
					<td align="left" valign="top" width="10%">Credited</td>
					<td align="left" valign="top" width="10%">Sep 23, 2013</td>
					<td align="left" valign="top" width="10%">
						<a href="javascript:void(0);" class="edit_firm" original-title="Edit"><i class="icon-check"></i></a>
					</td>
				</tr>
				<tr>
		    		<td align="left" valign="top" width="10%">0001</td>
			    	<td align="left" valign="top" width="10%">Active</td>
					<td align="left" valign="top" width="10%">Credited</td>
					<td align="left" valign="top" width="10%">Sep 23, 2013</td>
					<td align="left" valign="top" width="10%">
						<a href="javascript:void(0);" class="edit_firm" original-title="Edit"><i class="icon-check"></i></a>
					</td>
				</tr>
				<tr>
		    		<td align="left" valign="top" width="10%">0001</td>
			    	<td align="left" valign="top" width="10%">Active</td>
					<td align="left" valign="top" width="10%">Credited</td>
					<td align="left" valign="top" width="10%">Sep 23, 2013</td>
					<td align="left" valign="top" width="10%">
						<a href="javascript:void(0);" class="edit_firm" original-title="Edit"><i class="icon-check"></i></a>
					</td>
				</tr>
				<tr>
		    		<td align="left" valign="top" width="10%">0001</td>
			    	<td align="left" valign="top" width="10%">Active</td>
					<td align="left" valign="top" width="10%">Credited</td>
					<td align="left" valign="top" width="10%">Sep 23, 2013</td>
					<td align="left" valign="top" width="10%">
						<a href="javascript:void(0);" class="edit_firm" original-title="Edit"><i class="icon-check"></i></a>
					</td>
				</tr>
		    </tbody>	
		</table>
	</form>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>

