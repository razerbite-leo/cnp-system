<script>
	 $(function() {
        $('#referred_client_list_dt').dataTable( {
	        "bJQueryUI": true,
	        "sPaginationType": "full_numbers",
	        "bPaginate": false,
	        "bLengthChange": false,
	        "bFilter": true,
	        "bInfo": false,     
	        "bScrollCollapse": false
        });

       $('#referred_client_list_dt_length').hide();
       $('#referred_client_list_dt_filter').hide();
       $('.edit_referred_client').tipsy({gravity: 's'});
       $('.delete_referred_client').tipsy({gravity: 's'});
	});
</script>

<table id="referred_client_list_dt" class="datatable" style="min-width: 85%;">
    <thead>
	<tr>
		<th align="left" valign="top" width="5%"></th>
		<th align="left" valign="top" width="45%">Client Name</th>
		<th align="left" valign="top" width="45%">When</th>
	</tr>
    </thead>
    <tbody>
    <?php foreach($list as $key=>$value): ?>
    	<tr>
    		<td align="center" valign="top" width="5%">
				<a href="javascript:void(0);" class="edit_referred_client" original-title="Edit" onclick="javascript:edit_referred_client(<?php echo $value['id']; ?>);"><i class="icon-pencil"></i></a>
				<a href="javascript:void(0);" class="delete_referred_client" original-title="Delete" onclick="javascript:delete_referred_client(<?php echo $value['id']; ?>);"><i class="icon-trash"></i></a>
			</td>
    		<td align="left" valign="top" width="45%"><?php echo $value['referred_client']; ?></td>
	    	<td align="left" valign="top" width="45%"><?php echo date("m/d/Y",strtotime($value['when'])); ?></td>
		</tr>
    <?php endforeach; ?>
    </tbody>	
</table>