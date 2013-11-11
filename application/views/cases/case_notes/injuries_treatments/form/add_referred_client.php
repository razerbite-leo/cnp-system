<script>
  $(function() {
      if($('.tipsy-inner')) {
        $('.tipsy-inner').remove();
      }

       $('#when_dtp').datetimepicker({
        pickTime: false
      });
      
      $("#add_referred_client_form").ajaxForm({
          success: function(o) {
              if(o.is_successful) {

                $('#add_referred_client_modal_wrapper').modal('hide');
                referred_client_list();
               
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
            <form id="add_referred_client_form" name="add_referred_client_form" method="post" action="<?php echo url('cases/save_referred_client'); ?>">
                <p>Referred Client</p>
                <input type="text" id="referred_client" name="referred_client" class="textbox">
                <section class="clear"></section>

                <p>When</p>
                <div id="when_dtp" class="input-append">
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
          <a href="javascript:void(0);" onclick="$('#add_referred_client_form').submit();" class="btn btn-primary">Save changes</a>
        </div>
      </div><!-- /.modal-content -->
</div>
