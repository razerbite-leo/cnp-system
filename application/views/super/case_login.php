<?php include('themes/templates/header.php'); ?>


<script>
	$(function() {
		$('#authenticate_case_form_wrapper').modal({ backdrop: 'static', keyboard: false }) 
		$("#authenticate_case_form").ajaxForm({
			success: function(o) {
				if(o.is_successful) {
					window.location.href = base_url + "view/case";
				} else {
					alert("Not Successful");
				}
			},
			beforeSubmit: function(o) {
			},
			dataType: 'json'
		});
	});
</script>
<div id="authenticate_case_form_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:35%;">
	<div class="modal-header">
	    <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>-->
	    <h4 id="myModalLabel">Authenticate User </h4>
	</div>
	<div class="modal-body">
		<br/>
		<div id="form">
			<form id="authenticate_case_form" name="authenticate_case_form" method="post" action="<?php echo url('super_case_login/'.$segment_user_id); ?>">
				<input type="hidden" id="viewing_user_id" name="viewing_user_id" value="<?php echo $segment_user_id; ?>">
				<p style="margin-left:10%; width: 100px !important;">Email Address : </p>
				<span style="float:left; margin-top:4px; padding-left:10px; color:black"><?php echo $user['email_address']; ?></span>
				<section class="clear"></section>

				<p style="margin-left:10%; width: 100px !important;">Name  </p>
				<span style="float:left; margin-top:4px; padding-left:11px; color:black"><?php echo $user['firstname'] . " " . $user['lastname']; ?></span>
				<section class="clear"></section>
				<!--
				<p style="margin-left:10%; width: 100px !important;">Password<span><b>*</b></span></p>
				<input type="password" id="password" name="password" class="textbox validate[required]" maxlength="50" style="width: 50%;" placeholder="Enter your account password">
				<section class="clear"></section>
				-->
			</form>
		</div>
	</div>
	<div class="modal-footer">
	    <button class="btn btn-primary submit_button" onclick="$('#authenticate_case_form').submit();">Login</button>
	</div>
</div>