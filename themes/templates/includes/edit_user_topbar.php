<section id="topbar">
	<h1>Edit User</h1>
	<ul>
		<li><a id="edit_user_link" class="icon" href="javascript:void(0);" onclick="$('#edit_user_form').submit();" title="Save"><img src="<?php echo BASE_FOLDER; ?>themes/images/icon-save.png"></a></li>
		<li class="update_user_link" style="margin: 0 5px 0 5px; text-align: center; display:none !important;"><img src="<?php echo BASE_FOLDER; ?>themes/images/line.png" ></li>
		<li class="update_user_link" style="display:none !important;"><a class="icon" href="javascript:void(0);" onclick="javascript:delete_user_top();" title="Delete"><img src="<?php echo BASE_FOLDER; ?>themes/images/icon-trash.png"></a></li>
		<li style="margin: 0 5px 0 5px; text-align: center;"><img src="<?php echo BASE_FOLDER; ?>themes/images/line.png" ></li>
		<li><a id="edit_user_link" class="icon" href="javascript:void(0);" onclick="javascript:load_page('#manage-user');" title="Cancel"><img src="<?php echo BASE_FOLDER; ?>themes/images/icon-cancel.png"></a></li>
	</ul>
</section>
<div id="delete_user_top_form_wrapper" class="modal hide fade delete_user_top_form_wrapper" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:35%;"></div>

<script>
	function delete_user_top() {
		var id = $('#user_id').val();
		$.post(base_url + 'super/delete_user_form',{id:id},function(o) {
			$('.delete_user_top_form_wrapper').html(o);
			$('.delete_user_top_form_wrapper').modal();
		});
	}
</script>

