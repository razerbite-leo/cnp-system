<script>
	 $(function() {
        $('#current_contact_list_dt').dataTable( {
	        "bJQueryUI": true,
	        "sPaginationType": "full_numbers",
	        "bPaginate": false,
	        "bLengthChange": false,
	        "bFilter": true,
	        "bInfo": false,     
	        "bScrollCollapse": false
        });

       $('#current_contact_list_dt_length').hide();
       $('#current_contact_list_dt_filter').hide();
       $('.edit_user_current_contact').tipsy({gravity: 's'});
       $('.delete_user_current_contact').tipsy({gravity: 's'});


	});
</script>

<table id="current_contact_list_dt" class="datatable" style="min-width: 90%;">
    <thead>
	<tr>
		<th align="left" valign="top" width="7%"></th>
		<th align="left" valign="top" width="30%">Contact Type</th>
		<th align="left" valign="top" width="30%">Value</th>
		<th align="left" valign="top" width="30%">Extension</th>
	</tr>
    </thead>
    <tbody>
    <?php foreach($contact_list as $key=>$values): ?>
    	<tr>
    		<td align="left" valign="top" width="7%">
				<a href="javascript:void(0);" class="edit_user_current_contact" original-title="Edit" onclick="javascript:edit_user_contact(<?php echo $values['id'] ?>);"><i class="icon-pencil"></i></a>
				<a href="javascript:void(0);" class="delete_user_current_contact" original-title="Delete" onclick="javascript:delete_user_contact(<?php echo $values['id'] ?>);"><i class="icon-trash"></i></a>
			</td>
    		<td align="left" valign="top" width="30%"><?php echo $values['contact_type']; ?></td>
	    	<td align="left" valign="top" width="30%"><?php echo $values['contact_value']; ?></td>
			<td align="left" valign="top" width="30%"><?php echo $values['extension']; ?></td>
		</tr>
    <?php endforeach; ?>
    </tbody>	
</table>