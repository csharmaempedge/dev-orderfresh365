
<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
   width: 29%;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;

}

input:checked + .slider {
  background-color: #8bd040;
}

input:focus + .slider {
  box-shadow: 0 0 1px #8bd040;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Exceed Quantity Order's Details</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Exceed Quantity Order's</li>
        </ol>
    </section>   
    <!-- Main content -->
    <section class="content">       
        <div class="box box-success">
            <div class="box-header">
                <div class="pull-right box-tools">                 
                </div>
            </div>           
            <!-- /.box-header -->
            <div class="box-body"><br><br>
                <div>
                    <div id="msg_div">
                        <?php echo $this->session->flashdata('message');?>
                    </div>
                </div>
                
                <div class="pull-right box-tools">
                </div>
                  <div class="row">
                      <div class="form-group col-md-4">
                        <div class="input text">
                            <label>Patient List</label>
                              <select name="patient_id" id="patient_id" class="form-control">
                              <option value="">Select Patient</option>
                              <?php
                              $patient_res     = $this->common_model->getData('tbl_user', array('user_status'=>1, 'role_id'=>4), 'multi');
                                  if(!empty($patient_res)){
                                      foreach ($patient_res as $res){
                                          ?>
                                          <option value="<?php echo $res->user_id; ?>"><?php echo $res->user_fname.' '.$res->user_lname; ?></option>
                                          <?php
                                      }
                                  }
                              ?>  
                            </select>
                        </div>
                      </div>
                      <div class="form-group col-md-4">
                        <div class="input text">
                            <label>Status</label>
                              <select name="cart_approval_status" id="cart_approval_status" class="form-control">
                              <option value="">Select Status</option>
                              <option value="Approved">Approved</option>
                              <option value="Pending">Pending</option>
                              <option value="Rejected">Rejected</option>
                            </select>
                        </div>
                      </div>
                      <div class="form-group col-md-2">
                         <div class="input text">
                              <button style="margin-top: 29px;" class="btn btn-success btn-sm search-btn" id="search_btn">SEARCH</button>
                         </div>
                      </div>
                  </div>
                <br>  
                <div class="table-responsive">
                    <table id="load_exceedlist" class="table table-bordered table-striped">
                        <thead>
                            <tr class="label-primary1">
                              <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">S.No.</th>
              								<th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Patient Name</th>
              								<th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Mobile No.</th>
                              <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Total Quantity</th>
                              <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Date</th>
                              <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Approval</th>
              								<th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</aside>
<div id="approvalModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: <?PHP echo THEME_COLOR; ?>;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Approval Model</h4>
            </div>
            <div class="modal-body" id="view_Data">
            </div>
        </div>
    </div>
</div>
<!-- /.right-side -->
<script type="text/javascript">
  function approvalModel(patient_id)
    {
      var str = 'patient_id='+patient_id;
      var PAGE = '<?php echo base_url().MODULE_NAME; ?>exceed/approvalModel';
      $.ajax({
          type :"POST",
          url  :PAGE,
          data : str,
          success:function(data)
          {     
            $('#approvalModal').modal('show');
            $('#view_Data').html(data);
          } 
        });
    }
    $(document).ready(function() {
        //datatables
        table = $('#load_exceedlist').DataTable({ 
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' servermside processing mode.
            "searching": true, //Feature control DataTables' servermside processing mode.
            "order": [], //Initial no order.
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo base_url(MODULE_NAME.'exceed/loadExceedListData')?>",
                "type": "POST",
                "dataType": "json",
                "data":{},
                "data": function ( data ) {
                data.filter_by = {'patient_id':$('#patient_id').val(),'cart_approval_status':$('#cart_approval_status').val(), '<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'};
                },
                "dataSrc": function (jsonData) {
                  return jsonData.data;
                }
            },     
        });
        $('#search_btn').on('click' , function(){
           table.ajax.reload(); 
         });
    });
</script>