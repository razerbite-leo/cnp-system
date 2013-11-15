<script>
  $(function() {
      if($('.tipsy-inner')) {
        $('.tipsy-inner').remove();
      }

      $('#edit_when_urgent_care_clinic_dtp').datetimepicker({
        pickTime: false
      });
      
      $("#edit_urgent_care_clinic_form").ajaxForm({
          success: function(o) {
              if(o.is_successful) {

                $('#edit_urgent_care_clinic_modal_wrapper').modal('hide');
                urgent_care_clinic_list();
               
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
          <h4 class="modal-title">Edit Urgent Care Clinic</h4>
        </div>
        <div class="modal-body">
          <section id="form">
            <form id="edit_urgent_care_clinic_form" name="edit_urgent_care_clinic_form" method="post" action="<?php echo url('cases/save_urgent_care_clinic'); ?>">
            <input type="hidden" id="id" name="id" value="<?php echo $clinic['id']; ?>">
            <input type="hidden" id="update" name="update" value="<?php echo true; ?>">
                <p>Clinic Name</p>
                <input type="text" id="clinic_name" name="clinic_name" class="textbox" value="<?php echo $clinic['clinic_name']; ?>">
                <section class="clear"></section>

                <p>When</p>
                <div id="edit_when_urgent_care_clinic_dtp" class="input-append">
                  <input type="text" id="when" name="when" class="party_form" data-format="yyyy-MM-dd" value="<?php echo $clinic['when']; ?>"></input>
                  <span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                </div>
                <section class="clear"></section>

                <div class="hospital_er_modal">
                <?php $exam = $clinic['exam']; ?>
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
          <a href="javascript:void(0);" onclick="$('#edit_urgent_care_clinic_form').submit();" class="btn btn-primary">Save changes</a>
        </div>
      </div><!-- /.modal-content -->
</div>
