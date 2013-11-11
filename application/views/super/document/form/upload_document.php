<script>
	$(function() {
		var current_parent_id = $('#current_parent_id').val();
		$("#uploader").pluploadQueue({
			// General settings
			runtimes : 'html5',
			url : 'upload_case_document?cpi='+current_parent_id,
			max_file_size : '10mb',
			chunk_size : '1mb',
			unique_names : true,

			// Resize images on clientside if we can
			resize : {width : 320, height : 240, quality : 90},

			// Specify what files to browse for
			filters : [
				{title : "Image files", extensions : "jpg,gif,png"},
				{title : "Zip files", extensions : "zip"}
			],
		});

		// Client side form validation
		$('#file_uploader_form').submit(function(e) {
	        var uploader = $('#uploader').pluploadQueue();

	        // Files in queue upload them first
	        if (uploader.files.length > 0) {
	            // When all files are uploaded submit form
	            uploader.bind('StateChanged', function() {
	                if (uploader.files.length === (uploader.total.uploaded + uploader.total.failed)) {
	                    $('form')[0].submit();
	                }
	            });
	                
	            uploader.start();
	        } else {
	            alert('You must queue at least one file.');
	        }

	        return false;
	    });
	});

</script>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 id="myModalLabel">Upload Document</h4>
</div>
<div class="modal-body">
	<form id="file_uploader_form" name="file_uploader_form" enctype="multipart/form-data">
		<div id="uploader"></div>
	</form>
	
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>

