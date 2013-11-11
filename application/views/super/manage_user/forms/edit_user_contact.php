<script>
  $(function() {
      $("#edit_user_contact_form").ajaxForm({
          success: function(o) {
              //$('#edit_user_contact_form_wrapper').hide();
              $('#edit_user_contact_form_wrapper').modal('hide');
              load_user_current_contact_list("<?php echo $cl['user_id']; ?>");
          },
          beforeSubmit: function(o) {
          }
      });
  });

  function validate_extensions() {
    var contact_type = $('#edit_user_contact_type').val();
    if(contact_type == "Fax" || contact_type == "Work") {
      $('#edit_user_contact_extension').show();
    } else {  
       $('#edit_user_contact_extension').hide();
    }
  }
</script>
<div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Edit Contact</h4>
        </div>
        <div class="modal-body">
            <form id="edit_user_contact_form" name="edit_user_contact_form" method="post" action="<?php echo url('super/save_user_contact_form'); ?>">
            <input type="hidden" id="id" name="id" value="<?php echo $cl['id']; ?>">
                <ul class="inline_3" onchange="">
                  <li>
                    <select id="edit_user_contact_type" name="edit_user_contact_type" style="width: auto;" onchange="javascript:validate_extensions();">
                      <option <?php echo ($cl['contact_type'] == "Mobile" ? 'selected="selected"' : ''); ?> value="Mobile">Mobile</option>
                      <option <?php echo ($cl['contact_type'] == "Work" ? 'selected="selected"' : ''); ?> value="Work">Work</option>
                      <option <?php echo ($cl['contact_type'] == "Home" ? 'selected="selected"' : ''); ?> value="Home">Home</option>
                      <option <?php echo ($cl['contact_type'] == "Fax" ? 'selected="selected"' : ''); ?> value="Fax">Fax</option>
                    </select>
                  </li>
                  <li><input type="text" id="edit_user_contact_type_value" name="edit_user_contact_type_value" class="textbox02 validate[required]" value="<?php echo strtolower($cl['contact_value']); ?>"></li>
                  <li>
                    <?php
                      if(strtolower($cl['contact_type']) != "work" && strtolower($cl['contact_type']) != "fax") { $display = "display:none;"; }
                    ?>
                    <input type="text" id="edit_user_contact_extension" name="edit_user_contact_extension" class="textbox03 validate[required]" style="<?php echo $display; ?> width: 100px;" placeholder="Extension" value="<?php echo $cl['extension']; ?>">
                  </li>
                </ul>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <a href="javascript:void(0);" onclick="$('#edit_user_contact_form').submit();" class="btn btn-primary">Save changes</a>
        </div>
      </div><!-- /.modal-content -->
</div>
