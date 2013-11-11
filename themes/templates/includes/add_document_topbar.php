<section id="topbar">
	<h1>Add Document</h1>
	<ul>
		<li><a class="icon" href="javascript:void(0);" onclick="javascript:add_new_document();"><img src="<?php echo BASE_FOLDER; ?>themes/images/icon-save.png"></a></li>
		<li style="margin: 0 5px 0 5px; text-align: center;"><img src="<?php echo BASE_FOLDER; ?>themes/images/line.png" ></li>
		<li><a class="icon" href="javascript:void(0);" onclick="javascript:cancel_add_document();"><img src="<?php echo BASE_FOLDER; ?>themes/images/icon-cancel.png"></a></li>
	</ul>
</section>
	
<script>
	function add_new_document(){
		
	    for ( instance in CKEDITOR.instances ) {
	        CKEDITOR.instances[instance].updateElement();
	    }
	    $('#add_document_form').submit();

	}

</script>