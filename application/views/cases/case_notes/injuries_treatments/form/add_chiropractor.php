<script>
  $(function() {
      if($('.tipsy-inner')) {
        $('.tipsy-inner').remove();
      }

       $('#when_chiropractor_dtp').datetimepicker({
        pickTime: false
      });
      
      $("#add_chiropractor_form").ajaxForm({
          success: function(o) {
              if(o.is_successful) {

                $('#add_chiropractors_modal_wrapper').modal('hide');
                chiropractor_list();
               
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
          <h4 class="modal-title">Add Chiropractor</h4>
        </div>
        <div class="modal-body">
          <section id="form">
            <form id="add_chiropractor_form" name="add_chiropractor_form" method="post" action="<?php echo url('cases/save_chiropractor'); ?>">
                <p>Chiropractor</p>
                <input type="text" id="chiropractor" name="chiropractor" class="textbox">
                <section class="clear"></section>

                <p>When</p>
                <div id="when_chiropractor_dtp" class="input-append">
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
          <a href="javascript:void(0);" onclick="$('#add_chiropractor_form').submit();" class="btn btn-primary">Save changes</a>
        </div>
      </div><!-- /.modal-content -->
</div>
