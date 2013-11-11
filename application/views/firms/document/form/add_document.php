<script>
	
	$(function() {

		CKEDITOR.replace( 'editor_2' );
		
		$("#add_document_form").validationEngine({scroll:false});
		$('#add_document_form').ajaxForm({
			success:function(o) {
				
				if(o.is_successful) {
          			default_success_confirmation({message : o.message, alert_type: "alert-success"});
          		} else {
          			default_success_confirmation({message : o.message, alert_type: "alert-error"});
          		}
          		$('#add_document_topbar').hide();
          		manage_document(<?php echo $document['id']; ?>);
				$('html,body').animate({scrollTop: $("#alert_confirmation_wrapper").offset().top},10);

			}, beforeSubmit: function(o) {
				
			},
			dataType : "json"

		});
	});	

	$(function() {
        var opts=$("#source").html(), opts2="<option></option>"+opts;
        $(".add_document_set").each(function() { var e=$(this); e.html(e.hasClass("placeholder")?opts2:opts); });
        $(".add_document_set").val([<?php echo $available_sets; ?>]).select2({});
    });

    function cancel_add_document() {

    	reset_topbar();
		reset_sidebar();
		hide_edit_topbar();

		$('#main_content_wrapper').html("");	

    	$('#manage_document_topbar').removeClass("hidden");
		$('#manage_document_topbar').addClass('active-bar');
		$('.firm_admin_documents').addClass('super-active');

    	var current_parent_id = '<?php echo $current_parent_id; ?>';

    	manage_document(current_parent_id);
    }

</script>
<section class="data">
	<form id="add_document_form" name="add_document_form" method="post" action="<?php echo url('firms/save_document'); ?>">
	<input type="hidden" id="id" name="id" value="<?php echo $document['id']; ?>">
	<input type="hidden" id="parent" name="parent" value="<?php echo $current_parent_id; ?>">
		<div id="form">
			<p>Title<span><b>*</b></span></p>
			<input type="text" id="title" name="title" class="textbox validate[required]" maxlength="50" value="<?php echo $document['title']; ?>">
			<section class="clear"></section>

			<p>Description</p>
			<textarea id="description" name="description" placeholder="Your description here..." style="height:130px; width: 570px;"><?php echo $document['description']; ?></textarea>
			<section class="clear"></section>
			
			<p>Document Text</p>
			<section class="clear"></section>
			<textarea class="ckeditor" cols="80" id="editor_2" name="document_text" rows="10"><?php echo $document['document_text']; ?></textarea>
			<section class="clear"></section>

			<p>Add to Document Set</p>
			<select multiple id="add_document_set" name="add_document_set[]" class="add_document_set populate" style="width:580px"></select>
			<section class="clear"></section>
			<br/>

			<br/>
			<button id="big_save" class="big_save_inner" onclick="javascript:add_new_document();" type="button">
				<ul>
					<li><img width="17px" height="17px" src="<?php echo BASE_FOLDER . "themes/images/" ?>/icon-save-white.png"></li>
					<li>Save Document</li>
				</ul>
			</button>
		</div>
	</form>
</section>

<select id="source" style="display:none">
	<?php foreach($document_sets as $key=>$value): ?>
		<option value="<?php echo $value['id']; ?>"><?php echo $value['title']; ?></option>
	<?php endforeach; ?>
</select>


