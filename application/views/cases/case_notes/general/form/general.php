<?php $general = $_SESSION['tmp_cases']['general']; ?>
<script>
	$(function() {
		$('#investigation_dtp').datetimepicker({
		  pickTime: false
		});

		$("#add_general_form").ajaxForm({
		    success: function(o) {
		    	if(o.is_successful) {
		    		IS_GENERAL_TAB_CHANGE = false;
		    		$('#general_sidebar_check').show();

		    		window.location.hash = "parties";
					reload_content("parties");
					

		  		}
		    },
		    beforeSubmit: function(o) {
		    	
		    },
		    dataType: "json"
		});

		$('#case_source').val("<?php echo $general['case_source']; ?>");
		$(".general_form").live('change', function(e) {
			if($(this).val()) {
				IS_GENERAL_TAB_CHANGE = true;
			}
		});
	});
</script>
<section id="content">
	<br/>

	<hgroup class="content-header">
		<h1>General Information</h1>
		<ul>
			<li><a class="icon" href="javascript:void(0);" onclick="$('#add_general_form').submit();"><img src="<?php echo BASE_FOLDER; ?>themes/images/icon-save.png"></a></li>
			<li style="margin: 0 5px 0 5px; text-align: center;"><img src="<?php echo BASE_FOLDER; ?>themes/images/line.png" ></li>
			<li><a class="icon" href="#"><img src="<?php echo BASE_FOLDER; ?>themes/images/icon-trash.png"></a></li>
		</ul>
	</hgroup>
	<div class="line"></div>
	<br>
	<section class="data">
		<section id="form">
			<form id="add_general_form" name="add_general_form" method="post" action="<?php echo url('cases/add_general'); ?>">
				<p>Name of Investigator</p>
				<input type="text" id="investigator_name" name="investigator_name" class="textbox general_form" value="<?php echo $general['investigator_name']; ?>" >
				<section class="clear"></section>

				<p>Date</p>
				<div id="investigation_dtp" class="input-append">
					<input type="text" id="investigation_date" name="investigation_date" class="general_form" data-format="yyyy-MM-dd" value="<?php echo $general['investigation_date']; ?>"></input>
					<span class="add-on">
					  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
					  </i>
					</span>
				</div>
				<section class="clear"></section>
			
				<p>How did you find us</p>
				<select id="case_source" name="case_source" class="select general_form">
					<option value="">Please Select One</option>
					<option value="Television">Television</option>
					<option value="Radio">Radio</option>
					<option value="Billboard">Billboard</option>
					<option value="Direct Mail">Direct Mail</option>
					<option value="Phonebook">Phonebook</option>
					<option value="Past or Current Client">Past or Current Client</option>
					<option value="Friend / Relative">Friend / Relative</option>
					<option value="Firm Employee">Firm Employee</option>
					<option value="Medical Provider">Medical Provider</option>
				</select>
				<section class="clear"></section>
			
				<p>Referral Source</p>
				<input type="text" id="referral_source" name="referral_source" class="textbox general_form" value="<?php echo $general['referral_source']; ?>">
				<section class="clear"></section>
			
				<p>Previous Representation</p>
				<input type="text" id="previous_representation" name="previous_representation" class="textbox general_form" value="<?php echo $general['previous_representation']; ?>">
			
			<section class="clear"></section>			
				<section id="form_contact">
					<p>Reasons prior representation<br> was terminated</p>
					<textarea id="reasons_representation_terminated" name="reasons_representation_terminated" class="general_form"><?php echo $general['reasons_representation_terminated']; ?></textarea>
				</section>
				
				<section class="clear"></section>	
				
				<p>Settlement Recieved</p>
				<input type="text" id="settlement_received" name="settlement_received" class="textbox general_form" value="<?php echo $general['settlement_received']; ?>">
			</form>
		</section>
		<br/>
		<button id="big_save" class="big_save_add_general">
			<ul>
				<li><img width="17px" height="17px" src="<?php echo BASE_FOLDER . "themes/images/" ?>/icon-save-white.png"></li>
				<li>Add to Case</li>
			</ul>
		</button>
	</section>
	<br>
</section>