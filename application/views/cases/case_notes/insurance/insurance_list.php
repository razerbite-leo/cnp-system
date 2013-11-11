<?php $insurance = $_SESSION['tmp_cases']['insurance']; ?>
<?php if($insurance) { ?>

<script>
	$(function() {
		 //$('.delete_party').tipsy({gravity: 's'});
	});
</script>
<div class="vehicle_content">
	<h3 class="vehicle_name_sidebar">Insurance List </h3>
	<table>
		<tr>
			<th align="left" width="50%">Name</th>
			<th align="left" width="50%">Insurance</th>
		</tr>
	
	<?php foreach($insurance as $key=>$value): ?>
		<tr>
			<!--<td align="left"><a href="javascript:void(0);" class="delete_party" original-title="Delete" onclick="javascript:delete_insurance(<?php echo $value['id']; ?>);"><i class="icon-trash"></i></a></td>-->
			<td align="left" width="50%"><a class="vehicle_item" href="javascript:void(0);" onclick="javascript:edit_insurance(<?php echo $value['id']; ?>)"><span class="vehicle_value"><?php echo character_limiter($value['name_insured'],5); ?></span></a></td>
			<td align="left" width="50%"><span class="vehicle_value"><?php echo character_limiter($value['insurance_type'],5); ?></span></td>
		</tr>
	<?php endforeach; ?>
	</table>
</div>
<?php } else { ?>
	<center>No available insurance</center>
<?php } ?>