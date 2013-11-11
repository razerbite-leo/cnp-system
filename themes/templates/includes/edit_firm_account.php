<section id="topbar">
	<h1>Edit Firm</h1>
	<ul>
		<li><a id="edit_firm_link" class="icon" href="javascript:void(0);" title="Save"><img src="<?php echo BASE_FOLDER; ?>themes/images/icon-save.png"></a></li>
		<li style="margin: 0 5px 0 5px; text-align: center;"><img src="<?php echo BASE_FOLDER; ?>themes/images/line.png" ></li>
		<li><a class="icon" href="javascript:void(0);" onclick="javascript:delete_firm_top();" title="Delete"><img src="<?php echo BASE_FOLDER; ?>themes/images/icon-trash.png"></a></li>
		<li style="margin: 0 5px 0 5px; text-align: center;"><img src="<?php echo BASE_FOLDER; ?>themes/images/line.png" ></li>
		<li><a class="icon" href="javascript:void(0);" onclick="javascript:load_page('#firm-accounts');" title="Cancel"><img src="<?php echo BASE_FOLDER; ?>themes/images/icon-cancel.png"></a></li>
	</ul>
</section>
<div id="delete_user_form_wrapper" class="modal hide fade delete_firm_top_form_wrapper" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:35%;"></div>
<script>
	function delete_firm_top() {
		var id = $('#firm_id').val();
		$.post(base_url + 'super/delete_firm_form',{id:id},function(o) {
			$('.delete_firm_top_form_wrapper').html(o);
			$('.delete_firm_top_form_wrapper').modal();
		});
	}
</script>