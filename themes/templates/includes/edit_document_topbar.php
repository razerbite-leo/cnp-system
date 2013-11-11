<section id="topbar">
	<h1>Edit Document</h1>
	<ul>
		<li><a id="edit_document_link" class="icon" href="javascript:void(0);" onclick="javascript:submit_document_form();" title="Save"><img src="<?php echo BASE_FOLDER; ?>themes/images/icon-save.png"></a></li>
		<li style="margin: 0 5px 0 5px; text-align: center;"><img src="<?php echo BASE_FOLDER; ?>themes/images/line.png"></li>
		<li><a class="icon" href="javascript:void(0);" onclick="javascript:delete_document_top();"><img src="<?php echo BASE_FOLDER; ?>themes/images/icon-trash.png" title="Trash"></a></li>
		<li style="margin: 0 5px 0 5px; text-align: center;"><img src="<?php echo BASE_FOLDER; ?>themes/images/line.png" ></li>
		<li><a class="icon" href="javascript:void(0);" onclick="javascript:cancel_edit_document();"><img src="<?php echo BASE_FOLDER; ?>themes/images/icon-cancel.png" title="Cancel"></a></li>
	</ul>
</section>
<div id="delete_document_top_form_wrapper" class="modal hide fade delete_document_top_form_wrapper" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:35%;"></div>
<script>
	function submit_document_form(){
	    for ( instance in CKEDITOR.instances ) {
	        CKEDITOR.instances[instance].updateElement();
	    }
	    $('#edit_document_form').submit();
	}

	function delete_document_top() {
		var id = $('#document_id').val();
		$.post(base_url + 'firms/delete_document_top_form',{id:id},function(o) {
			$('.delete_document_top_form_wrapper').html(o);
			$('.delete_document_top_form_wrapper').modal();
		});
	}
</script>