<script>
  $(function() {
      if($('.tipsy-inner')) {
        $('.tipsy-inner').remove();
      }

       $('#edit_when_medical_provider_dtp').datetimepicker({
        pickTime: false
      });
      
      $("#edit_medical_provider_form").ajaxForm({
          success: function(o) {
              if(o.is_successful) {

                $('#edit_medical_provider_modal_wrapper').modal('hide');
                medical_provider_list();
               
              }
          },
          beforeSubmit: function(o) {
          },
          dataType: 'json'
      });
  });
</script>

<div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Edit Medical Provider</h4>
        </div>
        <div class="modal-body">
          <section id="form">
            <form id="edit_medical_provider_form" name="edit_medical_provider_form" method="post" action="<?php echo url('cases/save_medical_provider'); ?>">
            <input type="hidden" id="id" name="id" value="<?php echo $mp['id']; ?>">
            <input type="hidden" id="update" name="update" value="<?php echo true; ?>">
                <p>Medical Provider</p>
                <input type="text" id="medical_provider" name="medical_provider" class="textbox" value="<?php echo $mp['medical_provider']; ?>">
                <section class="clear"></section>

                <p>When</p>
                <div id="edit_when_medical_provider_dtp" class="input-append">
                  <input type="text" id="when" name="when" class="party_form" data-format="yyyy-MM-dd" value="<?php echo $mp['when']; ?>"></input>
                  <span class="add-on">
                    <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                    </i>
                  </span>
                </div>
                <section class="clear"></section>
            </form>
          </section>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <a href="javascript:void(0);" onclick="$('#edit_medical_provider_form').submit();" class="btn btn-primary">Save changes</a>
        </div>
      </div><!-- /.modal-content -->
</div>
