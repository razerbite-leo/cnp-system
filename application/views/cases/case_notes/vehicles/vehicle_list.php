<?php $vehicles = $_SESSION['tmp_cases']['vehicles']; ?>
<?php if($vehicles) { ?>

<script>
	$(function() {
		 //$('.delete_party').tipsy({gravity: 's'});
	});
</script>


<div class="insurance_content">
	<h3 class="insurance_name_sidebar">Vehicle List </h3>
	<table>
		<tr>
			<th align="left" width="50%">Name</th>
			<th align="left" width="50%">Vehicle Type</th>
		</tr>
	
	<?php foreach($vehicles as $key=>$value): ?>
		<tr>
			<!--<td align="left"><a href="javascript:void(0);" class="delete_party" original-title="Delete" onclick="javascript:delete_insurance(<?php echo $value['id']; ?>);"><i class="icon-trash"></i></a></td>-->
			<td align="left" width="50%"><a class="insurance_item" href="javascript:void(0);" onclick="javascript:edit_vehicle(<?php echo $value['id']; ?>)"><span class="insurance_value"><?php echo $value['party_type'] . " - " . $value['party_role']; ?></span></a></td>
			<td align="left" width="50%"><span class="insurance_value"><?php echo $value['vehicle_type']; ?></span></td>
		</tr>
	<?php endforeach; ?>
	</table>
</div>
<?php } else { ?>
	<center>No available party</center>
<?php } ?>