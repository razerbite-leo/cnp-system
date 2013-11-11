<script>
	$(function() {
		$("#insurance_form").ajaxForm({
		    success: function(o) {
		    	if(o.is_successful) {
		    		IS_INSURANCE_TAB_CHANGE = false;

		    		$('#insurance_count_sidebar').html(o.total_party);
		    		$('#insurance_count_sidebar').show();

		    		reload_content("insurance");
					insurance_list();
		  		}
		    },
		    beforeSubmit: function(o) {
		    	
		    },
		    dataType: "json"
		});

		$(".insurance_form").live('change', function(e) {
			if($(this).val()) {
				IS_INSURANCE_TAB_CHANGE = true;
			}
		});
	});

	function show_client_form() {
		var party_type = $('#party_type').val();
		if(party_type == "Client") {
			$('.client_group_form').show();
			$('.defendant_owner_group_form').hide();
		} else {
			$('.client_group_form').hide();
			$('.defendant_owner_group_form').show();
			$('#insurance_type').val("Liability Insurance");
		}
	}

</script>

<section id="content">
	<hgroup class="content-header">
		<h1>Insurance</h1>
		<ul>
			<li><a class="icon" href="javascript:void(0);" onclick="$('#insurance_form').submit();"><img src="<?php echo BASE_FOLDER; ?>themes/images/icon-save.png"></a></li>
			<li style="margin: 0 5px 0 5px; text-align: center;"><img src="<?php echo BASE_FOLDER; ?>themes/images/line.png" ></li>
			<li><a class="icon" href="#"><img src="<?php echo BASE_FOLDER; ?>themes/images/icon-trash.png"></a></li>
		</ul>
	</hgroup>
	<div class="line"></div>
	<br>
	<section class="data">
		<section id="form">
			<form id="insurance_form" name="insurance_form" method="post" action="<?php echo url('cases/add_insurance'); ?>">
				<p>Party Type</p>
				<select id="party_type" name="party_type" class="select insurance_form" onchange="javascript:show_client_form();">
					<option value="Defendant">Defendant Owner</option>
					<option value="Client">Client</option>
				</select>
				<section class="clear"></section>

				<div class="defendant_owner_group_form">
					<p>Insurance Type</p>
					<select id="insurance_type" name="insurance_type" class="select insurance_form">
						<option value="Medical Insurance">Medical Insurance</option>
						<option value="Auto Insurance">Auto Insurance</option>
						<option value="Workers Compensation Insurance">Workers Compensation Insurance</option>
					</select>
					<section class="clear"></section>
				</div>

				<div class="hidden client_group_form">
					<p>Role of Party</p>
					<select id="party_role" name="party_role" class="select insurance_form">
						<option value="Host">Host</option>
						<option value="Personal">Personal</option>
						<option value="Household Relative">Household Relative</option>
					</select>
					<section class="clear"></section>
				</div>

				<p>Name Insured</p>
				<input type="text" id="name_insured" name="name_insured" class="textbox insurance_form">
				<section class="clear"></section>

				<p>Insurance Company</p>
				<input type="text" id="insurance_company" name="insurance_company" class="textbox insurance_form">
				<section class="clear"></section>

				<p>Policy Number</p>
				<input type="text" id="policy_number" name="policy_number" class="textbox insurance_form">
				<section class="clear"></section>

				<p>Agent that sold Policy</p>
				<input type="text" id="agent_sold_policy" name="agent_sold_policy" class="textbox insurance_form">
				<section class="clear"></section>

				<p>Adjuster</p>
				<input type="text" id="adjuster" name="adjuster" class="textbox insurance_form">
				<section class="clear"></section>

				<section id="form_address">
					<p>Current Address</p>
					<textarea id="address" name="address" style="height: 90px; width:270px;" class="insurance_form validate[required]"></textarea>
					<ul>
						<li><input type="text" class="insurance_form" id="city" name="city" class="textbox03" placeholder="City"></li>
						<li>
							<select id="state" name="state" class="select insurance_form" style="margin-top: -10px !important;">
								<?php foreach($state as $key=>$val): ?>
									<option value="<?php echo $key; ?>" ><?php echo $key; ?></option>
								<?php endforeach; ?>
							</select>
						</li>
						<li><input type="text" id="zip" name="zip" class="textbox03 insurance_form" placeholder="Zip" style="margin-top: -10px !important;"></li>
					</ul>
				</section>
				<section class="clear"></section>

				<p>Phone</p>
				<input type="text" id="phone" name="phone" class="textbox insurance_form" placeholder="(___) 000-0000" style="width:150px;">
				<input type="text" id="extension" name="extension" class="textbox insurance_form" placeholder="Extension" style="width:150px;">
				<section class="clear"></section>

				<p>Claim Number</p>
				<input type="text" id="claim_number" name="claim_number" class="textbox insurance_form">
				<section class="clear"></section>

				<div class="hidden client_group_form">

					<p>PIP Limits (PIP)</p>
					<input type="text" id="pip_limits" name="pip_limits" class="textbox insurance_form">
					<section class="clear"></section>

					<p>Med Pay Limits (MP)</p>
					<input type="text" id="med_pay_limits" name="med_pay_limits" class="textbox insurance_form">
					<section class="clear"></section>

					<p>Uninsured Limits (UM)</p>
					<input type="text" id="uninsured_limits" name="uninsured_limits" class="textbox insurance_form">
					<section class="clear"></section>

					<p>Underinsured Limits (UM)</p>
					<input type="text" id="underinsured_limits" name="underinsured_limits" class="textbox insurance_form">
					<section class="clear"></section>
				</div>

				<div class="defendant_owner_group_form">
					<p>Liability Limits</p>
					<input type="text" id="liability_limits" name="liability_limits" class="textbox insurance_form">
					<section class="clear"></section>
				</div>
			</form>
		</section>
		<br/>
		<button id="big_save" class="big_save_add_party" onclick="$('#insurance_form').submit();">
			<ul>
				<li><img width="17px" height="17px" src="<?php echo BASE_FOLDER . "themes/images/" ?>/icon-save-white.png"></li>
				<li>Add to Case</li>
			</ul>
		</button>
	</section>
</section>