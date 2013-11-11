<?php $note = $_SESSION['tmp_cases']['notes']; ?>
<script>
	$(function() {

		$("#add_notes").ajaxForm({
		    success: function(o) {
		    	if(o.is_successful) {
		    		IS_NOTES_TAB_CHANGE = false;
		    		$('#notes_sidebar_check').show();
		  		}
		    },
		    beforeSubmit: function(o) {
		    	
		    },
		    dataType: "json"
		});

		$(".notes_form").live('change', function(e) {
			if($(this).val()) {
				IS_NOTES_TAB_CHANGE = true;
			}
		});
	});
</script>
<section id="content">
	<br/>

	<hgroup class="content-header">
		<h1>Investigator's Notes</h1>
		<ul>
			<li><a class="icon" href="javascript:void(0);" onclick="$('#add_notes').submit();"><img src="<?php echo BASE_FOLDER; ?>themes/images/icon-save.png"></a></li>
			<li style="margin: 0 5px 0 5px; text-align: center;"><img src="<?php echo BASE_FOLDER; ?>themes/images/line.png" ></li>
			<li><a class="icon" href="#"><img src="<?php echo BASE_FOLDER; ?>themes/images/icon-trash.png"></a></li>
		</ul>
	</hgroup>
	<div class="line"></div>
	<br>
	<section class="data">
		<section id="form">
			<form id="add_notes" name="add_notes" method="post" action="<?php echo url('cases/add_notes'); ?>">
				
				<textarea id="investigator_note" name="investigator_note" style="height: 430px; width:750px;" class="notes_form validate[required]"><?php echo $note['investigator_note']; ?></textarea>
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