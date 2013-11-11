<div class="table-wrapper">
<table class="table table-bordered">
<th>Filename</th>
<th>Size</th>
<th>Date Uploaded</th>
<?php if($files) { ?>
	<?php foreach($files as $key=>$value): ?>
		<tr>
			<td><?php echo $value['upload_name']; ?></td>
			<td><?php echo Tool::formatSizeUnits($value['size']); ?></td>
			<td><?php echo $value['filename']; ?></td>
		</tr>
	<?php endforeach;?>
	
<?php } else { ?>
<tr>
	<td colspan="3"><b>No uploaded files</b></td>
</tr>
<?php } ?>
</div>
</table>