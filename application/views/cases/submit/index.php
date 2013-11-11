<?php include('themes/templates/cases.php'); ?>
<script>
	$(function() {
	});
</script>
<div id="main_content_wrapper" style="padding-left:10px;">
	<h3>Case Summary</h3>
	<div class="table-wrapper">
		<table class="table table-bordered" style="width:100%;">
			<tr> 
				<td width="100%" colspan="2"></td>
			</tr>
			<tr> 
				<td width="30%">Case ID</td>
				<td width="70%"><b><?php echo $case_code; ?></b></td>
			</tr>
			<tr> 
				<td width="100%" colspan="2">
					<span class="pull-left">General</span>
					<?php if($cn['general']) { ?>
					<div class="submit_general submit-is-check pull-right"></div>
					<?php } ?>
				</td>
			</tr>
			<tr> 
				<td width="100%" colspan="2">
					<span class="pull-left">Parties</span>
					<?php if($cn['parties']) { ?>
						<div class="submit_general submit-is-check pull-right"></div>
						<div class="submit_general submit-has-content pull-right"><?php echo count($cn['parties']); ?></div>
					<?php } ?>
				</td>
			</tr>
			<tr> 
				<td width="100%" colspan="2">
					<span class="pull-left">Incident Description</span>
					<?php if($cn['incident_description']) { ?>
						<div class="submit_general submit-is-check pull-right"></div>
					<?php } ?>
				</td>
			</tr>
			<tr> 
				<td width="100%" colspan="2">
					<span class="pull-left">Insurance</span>
					<?php if($cn['insurance']) { ?>
						<div class="submit_general submit-is-check pull-right"></div>
						<div class="submit_general submit-has-content pull-right"><?php echo count($cn['insurance']); ?></div>
					<?php } ?>
				</td>
			</tr>
			<tr> 
				<td width="100%" colspan="2">
					<span class="pull-left">Vehicles</span>
					<?php if($cn['vehicles']) { ?>
						<div class="submit_general submit-is-check pull-right"></div>
						<div class="submit_general submit-has-content pull-right"><?php echo count($cn['vehicles']); ?></div>
					<?php } ?>
				</td>
			</tr>
			<tr> 
				<td width="100%" colspan="2">
					<span class="pull-left">Injuries and Treatments</span>
					<?php if($cn['injuries_treatments']) { ?>
						<div class="submit_general submit-is-check pull-right"></div>
					<?php } ?>
				</td>
			</tr>
			<tr> 
				<td width="100%" colspan="2">
					<span class="pull-left">Economic Damages</span>
					<?php if($cn['economic_damages']) { ?>
						<div class="submit_general submit-is-check pull-right"></div>
					<?php } ?>
				</td>
			</tr>
			<tr> 
				<td width="100%" colspan="2">
					<span class="pull-left">Notes</span>
					<?php if($cn['notes']) { ?>
						<div class="submit_general submit-is-check pull-right"></div>
					<?php } ?>
				</td>
			</tr>
			<tr> 
				<td width="100%" colspan="2">
					<span class="pull-left">Accident Scene</span>
					<div class="submit_general submit-is-check pull-right"></div>
				</td>
			</tr>
			<tr> 
				<td width="100%" colspan="2">
					<span class="pull-left">Documents</span>
					<?php if($cn['document']) { ?>
						<div class="submit_general submit-is-check pull-right"></div>
					<?php } ?>
				</td>
			</tr>
			<tr> 
				<td width="100%" colspan="2">
					<span class="pull-left">Photos</span>
					<?php if($cn['photo']) { ?>
						<div class="submit_general submit-is-check pull-right"></div>
					<?php } ?>
				</td>
			</tr>
		</table>
		<div class="clear"></div>
		<button id="big_save" onclick="$('#signature_form22').submit();" style="width:775px;float:left;" type="button">
		    <ul>
		        <li><img width="17px" height="17px" src="<?php echo BASE_FOLDER; ?>themes/images/icon-save-white.png"></img></li>
		        <li> SUBMIT CASE </li>
		    </ul>
		</button>
	</div>
</div>

<div class="modal fade" id="upload_photo_form_wrapper" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>


<?php include('themes/templates/footer/cases.php'); ?>
