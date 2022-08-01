<aside class="right-side">
    <!-- Content Header (Page header) -->
     <section class="content-header">
        <h1>Order List</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url().MODULE_NAME;?>cart">Order </a></li>
            <li class="active">Order  List</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box box-success">
            <div class="box-header">
                <div>
                    <div id="msg_div">
                        <?php echo $this->session->flashdata('message'); ?>
                    </div>
                </div>
                <div class="pull-right box-tools"><br>                    
                </div>
                
            </div>  
            <div class="box-body">
                <div class="pull-right box-tools">
                    <?php
                        if($user_id == '2'){
                        ?>
                            <a href="<?php echo base_url().MODULE_NAME;?>order/bulkPrintView" class="btn btn-info btn-sm">Bulk Label Print</a>              
                        <?php
                        }
                    ?>  
                </div>
                <br><br>
                  <div class="row">
                      <div>
                <form action="<?php echo base_url(); ?>admin/order/downloadPDF" id="login_form" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                <?php  $csrf = array( 'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash() ); ?>
                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                <?php
                    if($user_id == '2'){
                    ?>
                        <div class="pull-right box-tools">
                          <!-- <button style=" margin-right: 18px;" class="btn btn-warning btn-sm" type="submit" name="Submit" value="Export" >Download PDF</button> -->
                          <a style=" margin-right: 18px;" href="<?php echo base_url().MODULE_NAME;?>order/downloadDeliverySheet" class="btn btn-danger btn-sm">Download Delivery Sheet</a>
                      </div>              
                    <?php
                    }
                ?>
                
                          <div class="form-group col-md-3">
                             <div class="input text">
                                 <label>To Date</label>
                                 <div class='input-group'>
                                     <input autocomplete="off" type="text" name="start_date" id="start_date" class="form-control date_val" value="" onchange="assignEndDate(this.value)">
                                     <span class="input-group-addon">
                                      <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                 </div>
                             </div>
                          </div>
                          <div class="form-group col-md-3">
                             <div class="input text">
                                 <label>From Date</label>
                                 <div class='input-group' id="show_end_date">
                                    <input autocomplete="off" type="text" name="end_date" id="end_date" class="form-control" value="" >
                                     <span class="input-group-addon">
                                         <span class="glyphicon glyphicon-calendar"></span>
                                     </span>
                                 </div>
                             </div>
                          </div>
                          <div class="form-group col-md-3">
                              <div class="input text">
                                  <label>Order Patient List</label>
                                  <select name="order_patient_id" id="order_patient_id" class="form-control">
                                      <option value="">-- Select --</option>
                                      <?php
                                          $user_res = $this->common_model->getData('tbl_user', array('user_status'=>1), 'multi');
                                          if(!empty($user_res)){
                                              foreach($user_res as $res){
                                                  $order_res = $this->common_model->getData('tbl_order', array('patient_id'=>$res->user_id), 'single');
                                                  if(!empty($order_res))
                                                  {
                                                      ?>
                                                      <option value="<?php echo $res->user_id; ?>"><?php echo $res->user_fname.' '.$res->user_lname; ?></option>
                                                      <?php

                                                  }
                                              }
                                          }
                                      ?>
                                  </select>
                              </div>
                          </div>
                      </form>
                          <div class="form-group col-md-2" style="margin-top: -3px;">
                               <div class="input text">
                                    <button class="btn btn-success btn-sm search-btn" id="search_btn">SEARCH</button>

                               </div>
                            </div> 
                      </div>
                  </div>
            </div>
            <div class="box box-success">
                <div class="box-header">
                    <div class="pull-right box-tools">                  
                    </div>
                </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="load_Data" class="table table-bordered table-striped">
                    <thead>
                        <tr class="label-primary1">
                            <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">S.No.</th>                          
                                <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Number</th>
                                <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Order Number</th>
                                <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Total Quantity</th>
                                <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Order Date</th>
                                <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Status</th>
                                <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Action</th>
                                <?php
                                if($user_id == '2')
                                {
                                    ?>
                                    <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Delivery Status</th>
                                    <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Print Label</th>
                                    <?php
                                }
                                ?>
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
<div id="approvalModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header" style="background-color: #008DBB;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color: #fff;">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Change Delivery Status</h4>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                   <form method="POST" action="<?php echo base_url(); ?>admin/order/orderStatusChange">
                        <input type="hidden" name="order_id" class="order_id" value="">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="input text">
                                    <label>Delivery Status<span class="text-danger">*</span></label>
                                       <select required name="delivery_status" id="delivery_status"class="form-control">
                                           <option value="">-- Select --</option>
                                           <option value="Complete">Complete</option>
                                           <option value="Pending">Pending</option>
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
                </div>
            </div>
        </div>
    </div>
<!-- /.right-side -->
<script type="text/javascript">
    function orderStatusChange(order_id)
    {
        $('.order_id').val(order_id);
        $('#approvalModal').modal('show');
    }
    $(document).ready(function() {
        //datatables
        table = $('#load_Data').DataTable({ 
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' servermside processing mode.
            "order": [], //Initial no order.
            "ordering": false, "searching": false,
            "ajax": {
                "url": "<?php echo base_url(MODULE_NAME.'order/loadOrderListData')?>",
                "type": "POST",
                "dataType": "json",
                "data":{},
                "data": function ( data ) {
                data.filter_by = {'start_date':$('#start_date').val(),'end_date':$('#end_date').val(),'order_patient_id':$('#order_patient_id').val(), '<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'};
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

    function assignEndDate(str)
    {
       $('#show_end_date').html('<input  autocomplete="off" type="text" name="end_date" id="end_date" class="form-control date_val"><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>');
       min1 = new Date(str);
       min = new Date(str);
       var numberOfDaysToAdd = 0;
       min.setDate(min.getDate() + numberOfDaysToAdd);
       var dd = min.getDate();
       var mm = min.getMonth() + 1;
       var y = min.getFullYear();
       var aa = y+'-'+mm+'-'+dd;
       max = new Date(aa); 

       $( "#end_date" ).datepicker({ 
          minDate: min1,
          //maxDate: max,
          dateFormat : 'dd-mm-yy',
          changeMonth : true,
          changeYear : true,
       });
    }
</script>