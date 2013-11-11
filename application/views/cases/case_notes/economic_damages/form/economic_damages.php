<?php $ed = $_SESSION['tmp_cases']['economic_damages']; ?>
<script>
	$(function() {
		$('#date_restricted_dtp').datetimepicker({
		  pickTime: false
		});

		$("#add_economic_damages").ajaxForm({
		    success: function(o) {
		    	if(o.is_successful) {
		    		IS_ECONOMIC_DAMAGE_TAB_CHANGE = false;
		    		$('#economic_damages_count_sidebar').show();

		    		window.location.hash = "notes";
					reload_content("notes");
					

		  		}
		    },
		    beforeSubmit: function(o) {
		    	
		    },
		    dataType: "json"
		});

		$(".economic_damages_form").live('change', function(e) {
			if($(this).val()) {
				IS_ECONOMIC_DAMAGE_TAB_CHANGE = true;
			}
		});
	});
</script>
<section id="content">
	<br/>

	<hgroup class="content-header">
		<h1>Economic Damages</h1>
		<ul>
			<li><a class="icon" href="javascript:void(0);" onclick="$('#add_economic_damages').submit();"><img src="<?php echo BASE_FOLDER; ?>themes/images/icon-save.png"></a></li>
			<li style="margin: 0 5px 0 5px; text-align: center;"><img src="<?php echo BASE_FOLDER; ?>themes/images/line.png" ></li>
			<li><a class="icon" href="#"><img src="<?php echo BASE_FOLDER; ?>themes/images/icon-trash.png"></a></li>
		</ul>
	</hgroup>
	<div class="line"></div>
	<br>
	<section class="data">
		<section id="form">
			<form id="add_economic_damages" name="add_economic_damages" method="post" action="<?php echo url('cases/add_economic_damages'); ?>">
				<p>Employer</p>
				<input type="text" id="employer" name="employer" class="textbox economic_damages_form" value="<?php echo $ed['employer']; ?>" >
				<section class="clear"></section>

				<section id="form_address">
					<p>Current Address</p>
					<textarea id="address" name="address" style="height: 90px; width:270px;" class="economic_damages_form validate[required]" value="<?php echo $ed['address']; ?>"></textarea>
					<ul>
						<li><input type="text" class="economic_damages_form" id="city" name="city" class="textbox03" placeholder="City" value="<?php echo $ed['city']; ?>"></li>
						<li>
							<select id="state" name="state" class="select economic_damages_form" style="margin-top: -10px !important;">
								<?php foreach($state as $key=>$val): ?>
									<option <?php echo ($key==$ed['state'] ? 'selected="selected"' : ''); ?> value="<?php echo $key; ?>" ><?php echo $key; ?></option>
								<?php endforeach; ?>
							</select>
						</li>
						<li><input type="text" id="zip" name="zip" class="textbox03 economic_damages_form" placeholder="Zip" style="margin-top: -10px !important;" value="<?php echo $ed['zip']; ?>"></li>
					</ul>
				</section>
				<section class="clear"></section>

				<p>Supervisor's Name </p>
				<input type="text" id="supervisor_name" name="supervisor_name" class="textbox economic_damages_form" value="<?php echo $ed['supervisor_name']; ?>" >
				<section class="clear"></section>

				<p>Salaries or Wages</p>
				$ <input type="text" id="salary_wages" name="salary_wages" class="textbox economic_damages_form" value="<?php echo $ed['salary_wages']; ?>" >
				<section class="clear"></section>

				<p>Doctor who restricted work</p>
				<input type="text" id="doctor_restricted" name="doctor_restricted" class="textbox economic_damages_form" value="<?php echo $ed['doctor_restricted']; ?>" >
				<section class="clear"></section>

				<p>Date Restricted</p>
				<div id="date_restricted_dtp" class="input-append">
					<input type="text" id="date_restricted" name="date_restricted" class="economic_damages_form" data-format="yyyy-MM-dd" value="<?php echo $ed['date_restricted']; ?>"></input>
					<span class="add-on">
					  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
					  </i>
					</span>
				</div>
				<section class="clear"></section>
			</form>
		</section>
		<br/>
		<button id="big_save" class="big_save_add_ed">
			<ul>
				<li><img width="17px" height="17px" src="<?php echo BASE_FOLDER . "themes/images/" ?>/icon-save-white.png"></li>
				<li>Add to Case</li>
			</ul>
		</button>
	</section>
	<br>
</section>