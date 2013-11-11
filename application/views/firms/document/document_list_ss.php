<input type="hidden" id="current_parent_id" name="current_parent_id" class="current_parent_id" value="<?php echo $parent_id; ?>">

<div class="document_breadcrumbs" style="">You are here : <?php echo $show_breadcrumbs; ?></div>
<br/><br/>




<script>
	$(function() {
		$('#document_list_dt_filter').hide();
		var current_parent_id = $('#current_parent_id').val();
		$('#document_list_dt').dataTable({
			"bJQueryUI": true,
	        "sPaginationType": "full_numbers",
	        "bPaginate": true,
	        "bLengthChange": false,
	        "bFilter": true,
	        "bInfo": false,     
	        "bScrollCollapse": false,
			"bProcessing": true,
			"bServerSide": true,
			"iDisplayLength": 50,
			"sAjaxSource": base_url + "firms/get_document_list?current_parent_id="+ current_parent_id,
			"fnDrawCallback": function( oSettings ) {
				$('.edit_receipt').tipsy({gravity: 's'});
				$('.delete_user').tipsy({gravity: 's'});
				$('.print_receipt').tipsy({gravity: 's'});
				$('.approve_user').tipsy({gravity: 's'});
		    }
		});
	});
</script>

<table id="document_list_dt" class="datatable" style="min-width: 90%;">
    <thead>
	<tr>
		<th align="left" valign="top" width="7%"></th>
		<th align="left" valign="top" width="7%">Visible</th>
		<th align="left" valign="top" width="25%">Title</th>
		<th align="left" valign="top" width="25%">Description</th>
		<th align="left" valign="top" width="10%">Type</th>
		<th align="left" valign="top" width="15%">Last Modified</th>
	</tr>
    </thead>
    <tbody>
    </tbody>
</table>

<style>
table.datatable td, th {padding-left:5px;}
.table_cb {vertical-align: middle; display: block; margin-left:10px;}
</style>

<!--

<table id="document_list_dt" class="datatable" style="min-width: 90%;">
    <thead>
	<tr>
		<th align="left" valign="top" width="10%"></th>
		<th align="left" valign="top" width="25%">Title</th>
		<th align="left" valign="top" width="25%">Description</th>
		<th align="left" valign="top" width="10%">Assigned</th>
		<th align="left" valign="top" width="15%">Type</th>
		<th align="left" valign="top" width="15%">Last Modified</th>
	</tr>
    </thead>
    <tbody>
    <tr>
    	<td align="left" valign="top" width="7%" colspan="6">
	    	<?php $parent = Document::findById($parent_id); ?>
	    	<?php if($parent) { ?>
	    		<a href="javascript:void(0);" onclick="javascript:document_list(<?php echo $parent['parent_id'] ?>);">Up to <?php echo $parent['title']; ?></a>
	    	<?php } else { echo "Root"; } ?>
    	</td>
    </tr>
    <?php foreach($documents as $key=>$value): ?>
    	<tr>
    		<td align="left" valign="top" width="10%">
    			<?php if($value['file_type'] == DOCUMENT_SET) { ?>
					<a href="javascript:void(0);" class="edit_firm_current_contact" original-title="Edit" onclick="javascript:edit_document_set(<?php echo $value['id'] ?>);"><i class="icon-pencil"></i></a>
					<a href="javascript:void(0);" class="delete_firm_current_contact" original-title="Delete" onclick="javascript:delete_document_set(<?php echo $value['id'] ?>);"><i class="icon-trash"></i></a>
				<?php } else if($value['file_type'] == DOCUMENT) { ?>
					<a href="javascript:void(0);" class="edit_firm_current_contact" original-title="Edit" onclick="javascript:edit_document(<?php echo $value['id'] ?>);"><i class="icon-pencil"></i></a>
					<a href="javascript:void(0);" class="delete_firm_current_contact" original-title="Delete" onclick="javascript:delete_document(<?php echo $value['id'] ?>);"><i class="icon-trash"></i></a>
				<?php } else if($value['file_type'] == DOCUMENT_IMAGE) { ?>
					<a href="javascript:void(0);" class="edit_firm_current_contact" original-title="Edit" onclick="javascript:edit_document_image(<?php echo $value['id'] ?>);"><i class="icon-pencil"></i></a>
					<a href="javascript:void(0);" class="delete_firm_current_contact" original-title="Delete" onclick="javascript:delete_document_image(<?php echo $value['id'] ?>);"><i class="icon-trash"></i></a>
				<?php } ?>
			</td>
    		<td align="left" valign="top" width="25%">
    			<?php if($value['file_type'] == DOCUMENT_SET) { ?>
    				<a href="javascript:void(0);" onclick="javascript:document_list(<?php echo $value['id']; ?>);"><?php echo $value['title']; ?></a>
    			<?php } else { echo $value['title']; } ?>
    		</td>
	    	<td align="left" valign="top" width="25%"><?php echo $value['description']; ?></td>
	    	<td align="left" valign="top" width="10%">
	    		<?php
	    			if($value['file_type'] != FILE) {
	    				echo $total_assigned = Document::countAllActiveFileByParentId($value['id']);
	    			}
	    			 
	    		?>
	    	</td>
			<td align="left" valign="top" width="15%"><?php echo $value['file_type']; ?></td>
			<td align="left" valign="top" width="15%"><small><?php echo date("M d, Y h:i:s a",strtotime($value['last_modified'])); ?></small></td>
		</tr>
    <?php endforeach; ?>
    </tbody>	
</table>
-->
<div id="edit_document_set_form_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:47%;"></div>
<div id="delete_document_set_form_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:47%;"></div>

<div id="edit_document_form_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:47%;"></div>
<div id="delete_document_form_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:30%;"></div>

<div id="edit_document_image_form_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:47%;"></div>
<div id="delete_document_image_form_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:30%;"></div>