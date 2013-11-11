<script>
  $(function() {
      $("#preview_document_form").ajaxForm({
          success: function(o) {
              $('#preview_document_form_wrapper').modal('hide');
              document_list();
          },
          beforeSubmit: function(o) {
          }
      });
  });

</script>
<div class="modal-content">

  <img class="preview_logo" src="<?php echo $firm_logo; ?>" >
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

  <br/>
  <div class="modal-body">
    <form id="preview_document_form" name="preview_document_form" method="post" action="<?php echo url('cases/preprocess_document'); ?>">
    <input type="hidden" id="id" name="id" value="<?php echo $document['id']; ?>">
    <input type="hidden" id="is_approved" name="is_approved" value="<?php echo TRUE; ?>">
      Title : <?php echo $document['title']; ?>
      <br/><br/>
      <div id="">
        <?php echo $document['document_text']; ?>
      </div>
    </form>
  </div>
  <div class="modal-footer">
    <button id="big_save" style="width:775px;float:left;" onclick="$('#preview_document_form').submit();">
      <ul>
        <li><img width="17px" height="17px" src="/razerbite/cnp/staging/cnp-system-v3/themes/images/icon-save-white.png"></li>
        <li>ACCEPT</li>
      </ul>
    </button>
  </div>
</div><!-- /.modal-content -->

<style>
.preview_logo {
    height: 30px !important;
    padding-top:1%;
    padding-left:1%;
    width: 150px !important;
} 
</style>