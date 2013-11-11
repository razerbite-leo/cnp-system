<script>
	$(function() {


        var opts=$("#source").html(), opts2="<option></option>"+opts;
        $("select.populate").each(function() { var e=$(this); e.html(e.hasClass("placeholder")?opts2:opts); });
        $("#add_document_set").val([<?php echo $available_sets; ?>]).select2({});
        serialize_value();

		var current_parent_id = $('#current_parent_id').val();
		var form_data;
		$("#uploader").pluploadQueue({
			// General settings
			runtimes : 'html5',
			url : 'firms/upload_case_document_image?cpi='+current_parent_id,
			max_file_size : '10mb',
			chunk_size : '1mb',
			unique_names : true,
			multipart_params: {cpi : current_parent_id, document_set : localStorage.document_set },

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

    function serialize_value() {
    	var a = $('#add_document_set').val();
    	if(a) {
    		$.post(base_url + 'firms/serialize_document_set',{a:a},function(o) {});
    	}
    }

</script>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 id="myModalLabel">Upload Document</h4>
</div>
<div class="modal-body">
	<form id="file_uploader_form" name="file_uploader_form" enctype="multipart/form-data">
		<div id="form">
			<p>Add to Document Set<span><b>*</b></span></p>
			<select multiple id="add_document_set" name="add_document_set[]" class="populate" style="width:400px" onchange="javascript:serialize_value();"></select>
			<section class="clear"></section>
		</div>
		<div id="uploader"></div>

		<br/>
		
	</form>
	
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>

<select id="source" style="display:none">
	<?php foreach($document_sets as $key=>$value): ?>
		<option value="<?php echo $value['id']; ?>"><?php echo $value['title']; ?></option>
	<?php endforeach; ?>
</select>


