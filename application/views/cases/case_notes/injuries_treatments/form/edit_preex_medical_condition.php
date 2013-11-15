<script>
  $(function() {
      if($('.tipsy-inner')) {
        $('.tipsy-inner').remove();
      }

       $('#edit_when_preex_medical_condition').datetimepicker({
        pickTime: false
      });
      
      $("#edit_preex_medical_condition_form").ajaxForm({
          success: function(o) {
              if(o.is_successful) {

                $('#edit_preex_medical_condition_modal_wrapper').modal('hide');
                preex_medical_condition_list();
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
          <h4 class="modal-title">Edit Pre-Existing Medical Condition</h4>
        </div>
        <div class="modal-body">
          <section id="form">
            <form id="edit_preex_medical_condition_form" name="edit_preex_medical_condition_form" method="post" action="<?php echo url('cases/save_preex_medical_condition'); ?>">
            <input type="hidden" id="id" name="id" value="<?php echo $pre['id']; ?>">
            <input type="hidden" id="update" name="update" value="<?php echo true; ?>">
                <p>Pre-Existing Medical Condition</p>
                <input type="text" id="preex_medical_condition" name="preex_medical_condition" class="textbox" value="<?php echo $pre['preex_medical_condition']; ?>">
                <section class="clear"></section>

                <p>When</p>
                <div id="edit_when_preex_medical_condition" class="input-append">
                  <input type="text" id="when" name="when" class="party_form" data-format="yyyy-MM-dd" value="<?php echo $pre['when']; ?>"></input>
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
          <a href="javascript:void(0);" onclick="$('#edit_preex_medical_condition_form').submit();" class="btn btn-primary">Save changes</a>
        </div>
      </div><!-- /.modal-content -->
</div>
