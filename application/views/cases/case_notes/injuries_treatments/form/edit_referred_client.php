<script>
  $(function() {
      if($('.tipsy-inner')) {
        $('.tipsy-inner').remove();
      }

       $('#edit_when_referred_client_dtp').datetimepicker({
        pickTime: false
      });
      
      $("#edit_referred_client_form").ajaxForm({
          success: function(o) {
              if(o.is_successful) {

                $('#edit_referred_client_modal_wrapper').modal('hide');
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
          <h4 class="modal-title">Edit Referred Client</h4>
        </div>
        <div class="modal-body">
          <section id="form">
            <form id="edit_referred_client_form" name="edit_referred_client_form" method="post" action="<?php echo url('cases/save_referred_client'); ?>">
            <input type="hidden" id="id" name="id" value="<?php echo $rc['id']; ?>">
            <input type="hidden" id="update" name="update" value="<?php echo true; ?>">
                <p>Referred Client</p>
                <input type="text" id="referred_client" name="referred_client" class="textbox" value="<?php echo $rc['referred_client']; ?>">
                <section class="clear"></section>

               <p>When</p>
                <div id="edit_when_referred_client_dtp" class="input-append">
                  <input type="text" id="when" name="when" class="party_form" data-format="yyyy-MM-dd" value="<?php echo $rc['when']; ?>"></input>
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
          <a href="javascript:void(0);" onclick="$('#edit_referred_client_form').submit();" class="btn btn-primary">Save changes</a>
        </div>
      </div><!-- /.modal-content -->
</div>
