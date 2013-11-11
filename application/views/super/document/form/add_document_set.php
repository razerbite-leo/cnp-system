<script>
	$(function() {
		$("#add_document_set_form").validationEngine({scroll:false});
		$('#add_document_set_form').ajaxForm({
			success:function(o) {
				if(o.is_successful) {
          			default_success_confirmation({message : o.message, alert_type: "alert-success"});
          		} else {
          			default_success_confirmation({message : o.message, alert_type: "alert-error"});
          		}

				$('#add_document_set_form_wrapper').modal('hide');
				$('html,body').animate({scrollTop: $("#alert_confirmation_wrapper").offset().top},10);

				document_list(current_parent_id);
				
			}, beforeSubmit: function(o) {

			},
			dataType : "json"

		});
		var current_parent_id = $('#current_parent_id').val();
		$('#parent').val(current_parent_id);
	});

	$(function() {
        //var opts=$("#source").html(), opts2="<option></option>"+opts;
        //$("select.populate").each(function() { var e=$(this); e.html(e.hasClass("placeholder")?opts2:opts); });
        //$("#visible_to").select2({});
    });
</script>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 id="myModalLabel">Add Document Set</h4>
</div>
<div class="modal-body">
	<form id="add_document_set_form" name="add_document_set_form" method="post" action="<?php echo url('save_document_set'); ?>">
		<div id="form">
			<p>Parent </p>
			<select id="parent" name="parent">
			<option value="0">Parent</option>
				<?php foreach($parent_set as $key=>$val): ?>
					<option value="<?php echo $val['id']; ?>" ><?php echo $val['title']; ?></option>
				<?php endforeach; ?>
			</select>
			<section class="clear"></section>

			<p>Title<span><b>*</b></span></p>
			<input type="text" id="title" name="title" class="textbox validate[required]" maxlength="50" style="width: 50%;">
			<section class="clear"></section>

			<p>Description<span><b>*</b></span></p>
			<textarea id="description" name="description" placeholder="Your description here..." style="height:130px; width: 340px;"></textarea>
			<section class="clear"></section>

			<p>Show to Firms?<span><b>*</b></span></p>
			<select id="show_to_firms" name="show_to_firms">
				<option value="No">No</option>
				<option value="Yes">Yes</option>
			</select>
			<section class="clear"></section>

			<!--
				<p>Visible to<span><b>*</b></span></p>
				<select multiple id="visible_to" name="visible_to[]" class="populate" style="width:355px"></select>
				<section class="clear"></section>
				<br/>
			-->
		</div>
	</form>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  <a href="javascript:void(0);" onclick="$('#add_document_set_form').submit();" class="btn btn-primary">Save changes</a>
</div>

<!--
<select id="source" style="display:none">
	<?php foreach($firms as $key=>$value): ?>
		<option value="<?php echo $value['id']; ?>"><?php echo $value['firm_name']; ?></option>
	<?php endforeach; ?>
</select>
-->
