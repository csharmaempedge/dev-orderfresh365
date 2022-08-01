<form method="POST" action="<?php echo base_url(); ?>admin/exceed/approvalStatus">
  <input type="hidden" name="patient_id" class="patient_id" value="<?php echo $patient_id; ?>">
  <div class="row">
      <div class="form-group col-md-12">
          <div class="input text">
              <label>Approval Status<span class="text-danger">*</span></label>
                 <select required name="cart_approval_status" id="cart_approval_status"class="form-control">
                     <option value="">-- Select --</option>
                     <option value="Approved">Approved</option>
                     <option value="Pending">Pending</option>
                     <option value="Rejected">Rejected</option>
                 </select>
          </div>
      </div>
  </div>
  <!-- Modal Footer -->
  <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <button type="submit" name="Submit" id="submit_btn" value="Update" class="btn btn-primary">Submit</button>
  </div>
</form>