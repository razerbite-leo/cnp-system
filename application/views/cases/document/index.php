<?php include('themes/templates/cases.php'); ?>

<script>
	$(function() {
		document_list();
	});
</script>

<div id="main_content_wrapper" style="padding-left:10px;">
	<h3>Documents</h3>

	<div class="pull-left">
		Select from list of Available Document Sets <br/>
		<select id="document_set_id" name="document_set_id" onchange="javascript:document_list();">
			<?php foreach($document_sets as $key=>$value): ?>
				<option value="<?php echo $value['id']; ?>"><?php echo $value['title']; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<div class="clear"></div>

	<br/>

	<div id="document_list_dt_wrapper"></div>
</div>
















<?php include('themes/templates/footer/cases.php'); ?>
