<input type="hidden" id="current_parent_id" name="current_parent_id" class="current_parent_id" value="<?php echo $parent_id; ?>">

<!--
<div class="document_breadcrumbs">You are here : <?php echo $show_breadcrumbs; ?></div>
<br/><br/>
-->

<script>
	$(function() {
		var document_set_id = $('#document_set_id').val();

		$('#document_list_dt_filter').hide();
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
			"sAjaxSource": base_url + "cases/get_document_list?document_set_id=" + document_set_id,
			"fnDrawCallback": function( oSettings ) {
				$('.edit_receipt').tipsy({gravity: 's'});
				$('.delete_user').tipsy({gravity: 's'});
				$('.print_receipt').tipsy({gravity: 's'});
				$('.approve_user').tipsy({gravity: 's'});
		    }
		});

		$("#signature_form22").ajaxForm({
			success: function(o) {
				document_list();
			},
			beforeSubmit: function(o) {
			}
		});
	});
</script>

<table id="document_list_dt" class="datatable" style="min-width: 98%;">
    <thead>
	<tr>
		<th align="left" valign="top" width="3%"></th>
		<th align="left" valign="top" width="25%">Title</th>
		<th align="left" valign="top" width="25%">Description</th>
		<th align="left" valign="top" width="25%">Date Accepted</th>
	</tr>
    </thead>
    <tbody>
    </tbody>
</table>

<form id="signature_form22" name="signature_form" method="post" action="<?php echo url('cases/accept_document'); ?>">
	<div><a href="javascript:void(0);" id="clear_signaturepad" class="clear-signature">Clear Signature</a></div>
	<br/>
	<div id="signaturepad_wrapper" class="sigPad">
		<div class="canvas-wrapper">
			<div class="sig sigWrapper" style="height:auto; width:auto;">
			  <div class="typed"></div>
			  <canvas class="pad" width="450" height="90x"></canvas>
			  <input type="hidden" name="output" class="output">
			</div>
		</div>
	</div>
	<div class="disclaimer">
		<p><strong>Disclaimer</strong><p>
		<p>By signing this field, the client authorizes us to attach their signatures to all the documents above that have checkmarks.</p>
	</div>
	<div class="clear"></div>
</form>
<button id="big_save" type="button" style="width:775px;float:left;" onclick="$('#signature_form22').submit();">
  <ul>
    <li><img width="17px" height="17px" src="/razerbite/cnp/staging/cnp-system-v3/themes/images/icon-save-white.png"></li>
    <li>PREPARE DOCUMENT</li>
  </ul>
</button>

<script>
	$(function() {
		$('#signaturepad_wrapper').signaturePad({
			drawOnly: true,
			defaultAction: 'drawIt',
			validateFields: false,
			lineWidth: 0,
			sigNav: null,
			name: null,
			typed: null,
			clear: $('#clear_signaturepad'),
			typeIt: null,
			drawIt: null,
			typeItDesc: null,
			drawItDesc: null
		});
	});
</script>

<style>
table.datatable td, th {padding-left:5px;}
.table_cb {vertical-align: middle; display: block; margin-left:10px;}
</style>

<div id="preview_document_form_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:60%; left:40%;"></div>
<div id="delete_document_set_form_wrapper" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:47%;"></div>