<script>
	 $(function() {
        $('#hospital_er_list_dt').dataTable( {
	        "bJQueryUI": true,
	        "sPaginationType": "full_numbers",
	        "bPaginate": false,
	        "bLengthChange": false,
	        "bFilter": true,
	        "bInfo": false,     
	        "bScrollCollapse": false
        });

       $('#hospital_er_list_dt_length').hide();
       $('#hospital_er_list_dt_filter').hide();
       $('.edit_hospital_er').tipsy({gravity: 's'});
       $('.delete_hospital_er').tipsy({gravity: 's'});


	});
</script>

<table id="hospital_er_list_dt" class="datatable" style="min-width: 60%;">
    <thead>
	<tr>
		<th align="left" valign="top" width="5%"></th>
		<th align="left" valign="top" width="15%">Hospital</th>
		<th align="left" valign="top" width="10%">X-Ray</th>
		<th align="left" valign="top" width="10%">CT Scan</th>
		<th align="left" valign="top" width="10%">MRI</th>
		<th align="left" valign="top" width="10%">Prescription Medication</th>
	</tr>
    </thead>
    <tbody>
    <?php foreach($list as $key=>$value): ?>
    <?php $exam = $value['exam']; ?>
    	<tr>
    		<td align="center" valign="top" width="5%">
				<a href="javascript:void(0);" class="edit_hospital_er" original-title="Edit" onclick="javascript:edit_hospital_er(<?php echo $value['id']; ?>);"><i class="icon-pencil"></i></a>
				<a href="javascript:void(0);" class="delete_hospital_er" original-title="Delete" onclick="javascript:delete_hospital_er(<?php echo $key; ?>);"><i class="icon-trash"></i></a>
			</td>
			<td align="left" valign="top" width="15%"><?php echo $value['hospital_name']. " - " . date("m/d/Y",strtotime($value['when'])); ?></td>
    		<td align="center" valign="top" width="10%"><?php echo ($exam['x_rays'] != "" ? $exam['x_rays'] : "No"); ?></td>
	    	<td align="center" valign="top" width="10%"><?php echo ($exam['ct_scan'] != "" ? $exam['ct_scan'] : "No"); ?></td>
	    	<td align="center" valign="top" width="10%"><?php echo ($exam['mri'] != "" ? $exam['mri'] : "No"); ?></td>
	    	<td align="center" valign="top" width="10%"><?php echo ($exam['prescription_medication'] != "" ? $exam['prescription_medication'] : "No"); ?></td>
		</tr>
    <?php endforeach; ?>
    </tbody>	
</table>