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


	var preload_data = <?php echo $available_sets; ?>;
    $(function() {
    	$('#document_sets').select2({
            multiple: true
            ,query: function (query){
                var data = {results: []};

                $.each(preload_data, function(){
                    if(query.term.length == 0 || this.text.toUpperCase().indexOf(query.term.toUpperCase()) >= 0 ){
                        data.results.push({id: this.id, text: this.text });
                    }
                });

                query.callback(data);
            }
        });

         $('#document_sets').select2('data', preload_data );
        
    });


    function cancel_edit_document() {

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

<?php if($document['document_type'] == ORIGINAL_DOC) { ?>
	<div class="alert alert-error"><b>Note : </b> You are editing the original document. Any changes will be reflected to its branches.</div>
	<br/><br/>
<?php } ?>

<section class="data" style="height: 550px !important;">
	<form id="edit_document_form" name="edit_document_form" method="post" action="<?php echo url('firms/update_document'); ?>">
	<input type="hidden" id="id" name="id" value="<?php echo $document['id']; ?>">
	<input type="hidden" id="document_id" name="document_id" value="<?php echo $document['id']; ?>">
	<input type="hidden" id="doc_copies" name="doc_copies" value="<?php echo $doc_copies; ?>">
		<div id="form">
			<p>Title<span><b>*</b></span></p>
			<input type="text" id="title" name="title" class="textbox validate[required]" maxlength="50" value="<?php echo $document['title']; ?>">
			<section class="clear"></section>

			<p>Description<span><b>*</b></span></p>
			<textarea id="description" name="description" placeholder="Your description here..." style="height:130px; width: 570px;"><?php echo $document['description']; ?></textarea>
			<section class="clear"></section>
			
			<p>Document Text<span><b>*</b></span></p>
			<section class="clear"></section>
			<textarea class="ckeditor" cols="80" id="editor1" name="document_text" rows="10"><?php echo $document['document_text']; ?></textarea>
			<section class="clear"></section>

			<p>Add to Document Set</p>
			<input type="hidden" id="document_sets" name="document_sets" style="width:580px;">
			<br/>
			<br/>

			<button id="big_save" class="big_save_inner" onclick="javascript:submit_document_form();" type="button">
				<ul>
					<li><img width="17px" height="17px" src="<?php echo BASE_FOLDER . "themes/images/" ?>/icon-save-white.png"></li>
					<li>Save Document</li>
				</ul>
			</button>
			<br/>
			<br/>
		</div>
	</form>
</section>


