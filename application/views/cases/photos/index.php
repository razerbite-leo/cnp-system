<?php include('themes/templates/cases.php'); ?>
<script>
	$(function() {
		uploaded_file_list();
	});
</script>
<div id="main_content_wrapper" style="padding-left:10px;">
	<h3>Photos</h3>

	<div class="content">
		<div id="uploaded_file_list_dt"></div>
		<div class="upload-wrapper">
			<div class="fields-wrapper">
				<div class="fields">
					<a href="javascript:void(0);" onclick="javascript:upload_photo_form();" class="btn-upload btn btn-primary">From File</a>
					<!--
					<div class="input-append">
	                	<input id="appendedInput" size="16" type="text"><span class="add-on">Upload</span>
	            	</div>
	            	-->
	            </div>
            	<div class="fields"><a href="#" class="btn-upload btn btn-primary">From Camera Roll</a><div>
			</div>
		</div>
	</div>
</div>






<!-- <a href="javascript:void(0);" onclick="javascript:upload_photo_form();">asdas</a> -->



<div class="modal fade" id="upload_photo_form_wrapper" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>




<?php include('themes/templates/footer/cases.php'); ?>
