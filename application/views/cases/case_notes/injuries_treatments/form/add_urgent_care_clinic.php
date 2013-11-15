<script>
  $(function() {
      if($('.tipsy-inner')) {
        $('.tipsy-inner').remove();
      }

      $('#when_urgent_care_clinic_dtp').datetimepicker({
        pickTime: false
      });
      
      $("#add_urgent_care_clinic_form").ajaxForm({
          success: function(o) {
              if(o.is_successful) {

                $('#add_urgent_care_clinic_modal_wrapper').modal('hide');
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
          <h4 class="modal-title">Add Urgent Care Clinic</h4>
        </div>
        <div class="modal-body">
          <section id="form">
            <form id="add_urgent_care_clinic_form" name="add_urgent_care_clinic_form" method="post" action="<?php echo url('cases/save_urgent_care_clinic'); ?>">
                <p>Clinic Name</p>
                <input type="text" id="clinic_name" name="clinic_name" class="textbox">
                <section class="clear"></section>

                <p>When</p>
                <div id="when_urgent_care_clinic_dtp" class="input-append">
                  <input type="text" id="when" name="when" class="party_form" data-format="yyyy-MM-dd"></input>
                  <span class="add-on">
                    <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                    </i>
                  </span>
                </div>
                <section class="clear"></section>

                <div class="hospital_er_modal">
                  <p></p>
                  <ul class="checkboxes" style="width: 200px !important;">
                    <li><label class="no-bootsrap"><input type="checkbox" class="check" id="exam[x_rays]" name="exam[x_rays]" value="Yes">X-Rays</label></li>
                    <li><label clas="no-bootsrap"><input type="checkbox" class="check" id="exam[ct_scan]" name="exam[ct_scan]" value="Yes">CT Scan</label></li>
                    <li><label class="no-bootsrap"><input type="checkbox" class="check" id="exam[mri]" name="exam[mri]" value="Yes">MRI</label></li>
                    <li><label clas="no-bootsrap"><input type="checkbox" class="check" id="exam[prescription_medication]" name="exam[prescription_medication]" value="Yes">Prescription Medication</label></li>
                  </ul>
                </div>

            </form>
          </section>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <a href="javascript:void(0);" onclick="$('#add_urgent_care_clinic_form').submit();" class="btn btn-primary">Save changes</a>
        </div>
      </div><!-- /.modal-content -->
</div>
