<script>
  $(function() {
      $('.tipsy-inner').remove();
      $("#edit_contact_person_form").ajaxForm({
          success: function(o) {
              
              $('#edit_contact_person_form_wrapper').modal('hide');
              contact_person_list("<?php echo $contact['party_id']; ?>");
          },
          beforeSubmit: function(o) {
          }
      });
  });

  function validate_extensions() {
    var contact_type = $('#edit_contact_information_type').val();
    if(contact_type == "Fax" || contact_type == "Work") {
      $('#edit_contact_information_extension').show();
    } else {  
       $('#edit_contact_information_extension').hide();
    }
  }
</script>
<div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Edit Contact</h4>
        </div>
        <div class="modal-body">
            <form id="edit_contact_person_form" name="edit_contact_person_form" method="post" action="<?php echo url('cases/save_contact_person'); ?>">
            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
            <input type="hidden" id="edit_contact_party_id" name="party_id" value="<?php echo $contact['party_id']; ?>">
                <ul class="inline_3" onchange="">
                  <li>
                    <select id="edit_contact_information_type" name="contact_type" style="width: auto;" onchange="javascript:validate_extensions();">
                      <option <?php echo ($contact['contact_type'] == "Mobile" ? 'selected="selected"' : ''); ?> value="Mobile">Mobile</option>
                      <option <?php echo ($contact['contact_type'] == "Work" ? 'selected="selected"' : ''); ?> value="Work">Work</option>
                      <option <?php echo ($contact['contact_type'] == "Home" ? 'selected="selected"' : ''); ?> value="Home">Home</option>
                      <option <?php echo ($contact['contact_type'] == "Fax" ? 'selected="selected"' : ''); ?> value="Fax">Fax</option>
                    </select>
                  </li>
                  <li><input type="text" id="edit_contact_information_type_value" name="contact_type_value" class="textbox02 validate[required]" value="<?php echo strtolower($contact['contact_type_value']); ?>"></li>
                  <li>
                    <?php
                      if(strtolower($contact['contact_type']) != "work" && strtolower($contact['contact_type']) != "fax") { $display = "display:none;"; }
                    ?>
                    <input type="text" id="edit_contact_information_extension" name="contact_extension" class="textbox03 validate[required]" style="<?php echo $display; ?> width: 100px;" placeholder="Extension" value="<?php echo $contact['extension']; ?>">
                  </li>
                </ul>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <a href="javascript:void(0);" onclick="$('#edit_contact_person_form').submit();" class="btn btn-primary">Save changes</a>
        </div>
      </div><!-- /.modal-content -->
</div>
