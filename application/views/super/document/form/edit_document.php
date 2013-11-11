<script>
	CKEDITOR.replace( 'editor1' );
	$(function() {
		
		$("#edit_document_form").validationEngine({scroll:false});
		$('#edit_document_form').ajaxForm({
			success:function(o) {
				
				if(o.is_successful) {
          			default_success_confirmation({message : o.message, alert_type: "alert-success"});
          		} else {
          			default_success_confirmation({message : o.message, alert_type: "alert-error"});
          		}

				$('#edit_document_form_wrapper').modal('hide');
				$('html,body').animate({scrollTop: $("#alert_confirmation_wrapper").offset().top},10);

			}, beforeSubmit: function(o) {
				
			},
			dataType : "json"

		});
	});

	$(function() {
        //var opts=$("#source").html(), opts2="<option></option>"+opts;
        //$("select.populate").each(function() { var e=$(this); e.html(e.hasClass("placeholder")?opts2:opts); });
        //$("#visible_to").select2({});
    });

</script>
<section class="data">
	<form id="edit_document_form" name="edit_document_form" method="post" action="<?php echo url('save_document_set'); ?>">
	<input type="hidden" id="id" name="id" value="<?php echo $document['id']; ?>">
		<div id="form">
			<p>Title<span><b>*</b></span></p>
			<input type="text" id="title" name="title" class="textbox validate[required]" maxlength="50" value="<?php echo $document['title']; ?>">
			<section class="clear"></section>

			<p>Description<span><b>*</b></span></p>
			<textarea id="description" name="description" placeholder="Your description here..." style="height:130px; width: 570px;"><?php echo $document['description']; ?></textarea>
			<section class="clear"></section>

            <p>Show to Firms?<span><b>*</b></span></p>
            <select id="show_to_firms" name="show_to_firms">
                <option <?php echo ($document['show_to_firms'] == "No" ? 'selected="selected"' : ''); ?> value="No">No</option>
                <option <?php echo ($document['show_to_firms'] == "Yes" ? 'selected="selected"' : ''); ?>value="Yes">Yes</option>
            </select>
            <section class="clear"></section>

            <!--
			<p>Visible to<span><b>*</b></span></p>
			<select multiple id="visible_to" name="visible_to[]" class="populate" style="width:580px"></select>
			<section class="clear"></section>
			<br/>
            -->

			<p>Document Text<span><b>*</b></span></p>
			<section class="clear"></section>
			<textarea class="ckeditor" cols="80" id="editor1" name="document_text" rows="10"><?php echo $document['document_text']; ?></textarea>
			<section class="clear"></section>
		</div>
	</form>
</section>

<!--
<select id="source" style="display:none">
	<?php foreach($firms as $key=>$value): ?>
		<option value="<?php echo $value['id']; ?>" <?php echo (in_array($value['id'],$visible_to) ? 'selected="selected"' : ""); ?> ><?php echo $value['firm_name']; ?></option>
	<?php endforeach; ?>
</select>
-->
<!--
<select style="width:300px; display:none;" id="source">
		<optgroup label="Firms">
            <option value="Razerbite Solutions">Razerbite Solutions</option>
            <option value="T-One Vision">T-One Vision</option>
            <option value="Another Firm">Another Firm</option>
            <option value="Oak Firm">Oak Firm</option>
        </optgroup>
        <optgroup label="Alaskan/Hawaiian Time Zone">
            <option value="AK">Alaska</option>
            <option value="HI">Hawaii</option>
        </optgroup>
        <optgroup label="Pacific Time Zone">
            <option value="CA">California</option>
            <option value="NV">Nevada</option>
            <option value="OR">Oregon</option>
            <option value="WA">Washington</option>
        </optgroup>
        <optgroup label="Mountain Time Zone">
            <option value="AZ">Arizona</option>
            <option value="CO">Colorado</option>
            <option value="ID">Idaho</option>
            <option value="MT">Montana</option><option value="NE">Nebraska</option>
            <option value="NM">New Mexico</option>
            <option value="ND">North Dakota</option>
            <option value="UT">Utah</option>
            <option value="WY">Wyoming</option>
        </optgroup>
        <optgroup label="Central Time Zone">
            <option value="AL">Alabama</option>
            <option value="AR">Arkansas</option>
            <option value="IL">Illinois</option>
            <option value="IA">Iowa</option>
            <option value="KS">Kansas</option>
            <option value="KY">Kentucky</option>
            <option value="LA">Louisiana</option>
            <option value="MN">Minnesota</option>
            <option value="MS">Mississippi</option>
            <option value="MO">Missouri</option>
            <option value="OK">Oklahoma</option>
            <option value="SD">South Dakota</option>
            <option value="TX">Texas</option>
            <option value="TN">Tennessee</option>
            <option value="WI">Wisconsin</option>
        </optgroup>
        <optgroup label="Eastern Time Zone">
            <option value="CT">Connecticut</option>
            <option value="DE">Delaware</option>
            <option value="FL">Florida</option>
            <option value="GA">Georgia</option>
            <option value="IN">Indiana</option>
            <option value="ME">Maine</option>
            <option value="MD">Maryland</option>
            <option value="MA">Massachusetts</option>
            <option value="MI">Michigan</option>
            <option value="NH">New Hampshire</option><option value="NJ">New Jersey</option>
            <option value="NY">New York</option>
            <option value="NC">North Carolina</option>
            <option value="OH">Ohio</option>
            <option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option>
            <option value="VT">Vermont</option><option value="VA">Virginia</option>
            <option value="WV">West Virginia</option>
        </optgroup>
    </select>
    --?

