<script>
	$(function() {
        $('#firm_list_dt').dataTable( {
	        "bJQueryUI": true,
	        "sPaginationType": "full_numbers",
	        "bPaginate": true,
	        "bLengthChange": true,
	        "bFilter": true,
	        "bInfo": false,     
	        "bScrollCollapse": false
        });

        $('#firm_list_dt_length').hide();
        //$('#firm_list_dt_filter').hide();
        $('.edit_firm').tipsy({gravity: 's'});
       	$('.delete_firm').tipsy({gravity: 's'});
	});
</script>

<div class="hidden">
<ul id="filter-search" style="display:none">
	<li>Filter Search by:</li>
	<li>
		<select id="filter_type" name="filter_type" class="select">
			<option value="firm">Firm</option>
			<option value="contact_person">Contact Person</option>
			<option value="firm">Firm</option>
		</select>
	</li>
</ul>
<ul id="text-search">
	<li><input type="text" id="query" name="query" class="textbox" placeholder="Search"><button type="button" id="search_firm_tags" name="search_firm_tags">Search</button></li>
</ul>
</div>
<table id="firm_list_dt" class="datatable">
    <thead>
	<tr>
		<th align="left" valign="top" width="5%"></th>
		<th align="left" valign="top" width="15%">Firm Name</th>
		<th align="left" valign="top" width="5%">Website</th>
		<th align="left" valign="top" width="10%">Contact Person</th>
		<th align="left" valign="top" width="10%">Membership Type</th>
		<th align="left" valign="top" width="10%">Start Date</th>
		<th align="left" valign="top" width="5%">Status</th>
	</tr>
    </thead>
    <tbody>
    <?php foreach($firms as $key=>$values): ?>
    	<tr>
    		<td align="left" valign="top" width="5%">
				<a href="javascript:void(0);" class="edit_firm" original-title="Edit" onclick="javascript:edit_firm(<?php echo $values['id'] ?>);"><i class="icon-pencil"></i></a>
				<a href="javascript:void(0);" class="delete_firm" original-title="Delete" onclick="javascript:delete_firm(<?php echo $values['id'] ?>);"><i class="icon-trash"></i></a>
			</td>
    		<td align="left" valign="top" width="15%"><?php echo $values['firm_name']; ?></td>
	    	<td align="left" valign="top" width="5%"><?php echo $values['website_url']; ?></td>
			<td align="left" valign="top" width="10%"><?php echo $values['contact_person']; ?></td>
			<td align="left" valign="top" width="10%"><?php echo $values['subscription_name']; ?></td>
			<td align="left" valign="top" width="10%"><?php echo date("Y-m-d",strtotime($values['date_created'])); ?></td>
			<td align="left" valign="top" width="5%"><?php echo $values['account_status']; ?></td>
		</tr>
    <?php endforeach; ?>
    </tbody>	
</table>

<div id="delete_firm_form_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:35%;"></div>