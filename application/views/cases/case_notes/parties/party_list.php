<?php $parties = $_SESSION['tmp_cases']['parties']; ?>
<?php if($parties) { ?>

<script>
	$(function() {
		 $('.delete_party').tipsy({gravity: 's'});
	});
</script>

	<ul class="accordionList">
	<?php foreach($parties as $key=>$value): ?>
		<!--<li><a href="javascript:void(0);" class="delete_party" original-title="Delete" onclick="javascript:delete_party(<?php echo $value['id']; ?>);"><i class="icon-trash"></i></a></li>-->
		<li><a class="" href="javascript:void(0);" onclick="javascript:edit_party(<?php echo $value['id']; ?>)"><?php echo $value['client_name']; ?></a></li>	
	<?php endforeach; ?>
	</ul>
<?php } else { ?>
	<center>No available party</center>
<?php } ?>
