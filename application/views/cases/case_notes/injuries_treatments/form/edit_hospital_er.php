<script>
  $(function() {
      if($('.tipsy-inner')) {
        $('.tipsy-inner').remove();
      }

      $('#edit_when_dtp').datetimepicker({
        pickTime: false
      });
      
      $("#edit_hospital_er_form").ajaxForm({
          success: function(o) {
              if(o.is_successful) {

                $('#edit_hospital_er_modal_wrapper').modal('hide');
                hospital_er_list();
               
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
          <h4 class="modal-title">Add Hospital ER</h4>
        </div>
        <div class="modal-body">
          <section id="form">
            <form id="edit_hospital_er_form" name="edit_hospital_er_form" method="post" action="<?php echo url('cases/save_hospital_er'); ?>">
            <input type="hidden" id="id" name="id" value="<?php echo $hospital['id']; ?>">
            <input type="hidden" id="update" name="update" value="<?php echo true; ?>">
                <p>Hospital Name</p>
                <input type="text" id="hospital_name" name="hospital_name" class="textbox" value="<?php echo $hospital['hospital_name']; ?>">
                <section class="clear"></section>

                <p>When</p>
                <div id="edit_when_dtp" class="input-append">
                  <input type="text" id="when" name="when" class="party_form" data-format="yyyy-MM-dd" value="<?php echo $hospital['when']; ?>"></input>
                  <span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                </div>
                <section class="clear"></section>

                <div class="hospital_er_modal">
                <?php $exam = $hospital['exam']; ?>
                  <p></p>
                  <ul class="checkboxes" style="width: 200px !important;">
                    <li><label class="no-bootsrap"><input type="checkbox" class="check" id="exam[x_rays]" name="exam[x_rays]" value="Yes" <?php echo ($exam['x_rays'] == "Yes" ? 'checked="checked"' : ''); ?> >X-Rays</label></li>
                    <li><label clas="no-bootsrap"><input type="checkbox" class="check" id="exam[ct_scan]" name="exam[ct_scan]" value="Yes" <?php echo ($exam['ct_scan'] == "Yes" ? 'checked="checked"' : ''); ?> >CT Scan</label></li>
                    <li><label class="no-bootsrap"><input type="checkbox" class="check" id="exam[mri]" name="exam[mri]" value="Yes" <?php echo ($exam['mri'] == "Yes" ? 'checked="checked"' : ''); ?> >MRI</label></li>
                    <li><label clas="no-bootsrap"><input type="checkbox" class="check" id="exam[prescription_medication]" name="exam[prescription_medication]" value="Yes" <?php echo ($exam['prescription_medication'] == "Yes" ? 'checked="checked"' : ''); ?> >Prescription Medication</label></li>
                  </ul>
                </div>

            </form>
          </section>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <a href="javascript:void(0);" onclick="$('#edit_hospital_er_form').submit();" class="btn btn-primary">Save changes</a>
        </div>
      </div><!-- /.modal-content -->
</div>
