<script>
  $(function() {
      if($('.tipsy-inner')) {
        $('.tipsy-inner').remove();
      }

       $('#when_theraphist_dtp').datetimepicker({
        pickTime: false
      });
      
      $("#add_therapist_form").ajaxForm({
          success: function(o) {
              if(o.is_successful) {

                $('#add_therapist_modal_wrapper').modal('hide');
                therapist_list();
               
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
          <h4 class="modal-title">Add Therapist</h4>
        </div>
        <div class="modal-body">
          <section id="form">
            <form id="add_therapist_form" name="add_therapist_form" method="post" action="<?php echo url('cases/save_therapist'); ?>">
                <p>Therapist</p>
                <input type="text" id="therapist_name" name="therapist_name" class="textbox">
                <section class="clear"></section>

                <p>When</p>
                <div id="when_theraphist_dtp" class="input-append">
                  <input type="text" id="when" name="when" class="party_form" data-format="yyyy-MM-dd"></input>
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
          <a href="javascript:void(0);" onclick="$('#add_therapist_form').submit();" class="btn btn-primary">Save changes</a>
        </div>
      </div><!-- /.modal-content -->
</div>
