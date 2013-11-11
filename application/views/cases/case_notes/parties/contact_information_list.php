<script>
	 $(function() {
        $('#contact_information_list_dt').dataTable( {
	        "bJQueryUI": true,
	        "sPaginationType": "full_numbers",
	        "bPaginate": false,
	        "bLengthChange": false,
	        "bFilter": true,
	        "bInfo": false,     
	        "bScrollCollapse": false
        });

       $('#contact_information_list_dt_length').hide();
       $('#contact_information_list_dt_filter').hide();
       $('.edit_user_current_contact').tipsy({gravity: 's'});
       $('.delete_user_current_contact').tipsy({gravity: 's'});


	});
</script>

<input type="hidden" id="party_id" name="party_id" value="<?php echo $party_id; ?>">
<table id="contact_information_list_dt" class="datatable" style="min-width: 85%;">
    <thead>
	<tr>
		<th align="left" valign="top" width="7%"></th>
		<th align="left" valign="top" width="30%">Contact Type</th>
		<th align="left" valign="top" width="30%">Value</th>
		<th align="left" valign="top" width="30%">Extension</th>
	</tr>
    </thead>
    <tbody>
    <?php foreach($contact_information as $key=>$value): ?>
    <?php //if($value['contact_type'] && $value['contact_type_value'] && $value['contact_extension']) ?>
    	<tr>
    		<td align="left" valign="top" width="7%">
				<a href="javascript:void(0);" class="edit_user_current_contact" original-title="Edit" onclick="javascript:edit_contact_information(<?php echo $key; ?>);"><i class="icon-pencil"></i></a>
				<a href="javascript:void(0);" class="delete_user_current_contact" original-title="Delete" onclick="javascript:delete_contact_information_data(<?php echo $key; ?>);"><i class="icon-trash"></i></a>
			</td>
    		<td align="left" valign="top" width="30%"><?php echo $value['contact_type']; ?></td>
	    	<td align="left" valign="top" width="30%"><?php echo $value['contact_type_value']; ?></td>
			<td align="left" valign="top" width="30%"><?php echo $value['contact_extension']; ?></td>
		</tr>
    <?php endforeach; ?>
    </tbody>	
</table>