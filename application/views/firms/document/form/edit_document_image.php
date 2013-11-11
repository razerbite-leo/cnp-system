<script>
	$(function() {
		$("#edit_document_image_form").validationEngine({scroll:false});
		$('#edit_document_image_form').ajaxForm({
			success:function(o) {
				if(o.is_successful) {
          			default_success_confirmation({message : o.message, alert_type: "alert-success"});
          		} else {
          			default_success_confirmation({message : o.message, alert_type: "alert-error"});
          		}

				$('#edit_document_image_form_wrapper').modal('hide');
				$('html,body').animate({scrollTop: $("#alert_confirmation_wrapper").offset().top},10);

				document_list(current_parent_id);
				
			}, beforeSubmit: function(o) {

			},
			dataType : "json"

		});
		var current_parent_id = $('#current_parent_id').val();
		$('#parent').val(current_parent_id);

		upload_document_image_edit();
	});

</script>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 id="myModalLabel">Edit Document Image</h4>
</div>
<div class="modal-body">
	<form id="edit_document_image_form" name="edit_document_image_form" method="post" action="<?php echo url('firms/save_document_set'); ?>" enctype="multipart/form-data">
	<input type="hidden" id="id" name="id" value="<?php echo $document['id']; ?>">
		<div id="form">
			<p>Title<span><b>*</b></span></p>
			<input type="text" id="title" name="title" class="textbox validate[required]" maxlength="50" style="width: 50%;" value="<?php echo $document['title']; ?>">
			<section class="clear"></section>

			<p>Description<span><b>*</b></span></p>
			<textarea id="description" name="description" placeholder="Your description here..." style="height:130px; width: 570px;"><?php echo $document['description']; ?></textarea>
			<section class="clear"></section>

			<br/>
			<br/>
			<p>Image Preview<span><b>*</b></span></p>
			<?php $src = $document['path']."resize/".$document['filename']; ?>
			
			<img id="document_image" class="modal_image_placeholder" style="height:68px; width:120px;" src="<?php echo $src; ?>">
			
			<input type="file" style="padding-left:1% !important; vertical-align:top;" id="document_image_file" name="document_image_file">
			<div id="document_image_wrapper" class="hidden"></div>

		</div>
	</form>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  <a href="javascript:void(0);" onclick="$('#edit_document_image_form').submit();" class="btn btn-primary">Save changes</a>
</div>

