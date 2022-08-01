
<aside class="right-side">
   <section class="content-header">
      <h1>Bulk Label Print</h1>
        <ol class="breadcrumb">
           <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
           <li class="active">dashboard</li>
        </ol>
            <section class="content">       
                <div class="box box-success">
                    <div class="box-header">
                        <div class="pull-left">
                            <h3 class="box-title">Bulk Label Print</h3>
                        </div>
                        <div class="pull-right">
                          <a href="<?php echo base_url().MODULE_NAME;?>order" class="btn btn-info btn-sm">Back</a>
                           
                       </div>
                    </div>
                    <form action="" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        <?php  $csrf = array( 'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash() ); ?>
                        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                        <div class="box-body">
                            <div>
                                <div id="msg_div">
                                    <?php echo $this->session->flashdata('message');?>
                                </div>
                            </div>
                            <div class="row">
                              <div >
                                  <div class="form-group col-md-3">
                                     <div class="input text">
                                         <label>To Date</label>
                                         <div class='input-group'>
                                             <input autocomplete="off" type="text" name="start_date" id="start_date" class="form-control date_val" value="<?php echo (!empty($start_date)) ? $start_date : ''; ?>" onchange="assignEndDate(this.value)">
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
                                            <input autocomplete="off" type="text" name="end_date" id="end_date" class="form-control" value="<?php echo (!empty($end_date)) ? $end_date : ''; ?>" >
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
                                            <option value="All">ALL</option>
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
                                  <div class="form-group col-md-2" style="margin-top: 30px;">
                                     <div class="input text">
                                          <!-- <button class="btn btn-success btn-sm" type="submit" name="Submit" value="search" >Filter</button> -->
                                          <a class="btn btn-danger btn-sm" href="<?php echo base_url().MODULE_NAME;?>order/bulkPrintView">Refresh</a>
                                     </div>
                                  </div> 
                              </div>
                            </div>
                            <div class="table-responsive">
                              <table class="table table-bordered table-striped">
                                  <thead>
                                      <tr>
                                        <th style="background-color: #bad59c; color: #22255a;">Label Print.</th>
                                        <th style="background-color: #bad59c; color: #22255a;">Breakfast Label Print</th>
                                      </tr>
                                      <hr>
                                  <tbody>
                                    <tr>
                                      <td>
                                        <span class="btn btn-success btn-sm" id="Search" onclick="bulkPrintLabel();">Label Print</span>
                                      </td>
                                      <td>
                                        <span class="btn btn-danger btn-sm" id="Search" onclick="bulkBreakfastPrintLabel();">Breakfast Label Print</span>

                                      </td>
                                    </tr>
                                  </tbody>
                              </table>
                            </div> 
                        </div>
                    </form>
                </div>
                <div id="view_print_Data"></div>
                <div id="view_bulk_print_Data"></div>

                <!-- /.box -->
            </section>
   </section>
</aside>
<script type="text/javascript">
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
          dateFormat : 'yy-mm-dd',
          changeMonth : true,
          changeYear : true,
       });
    }

    function  bulkPrintLabel()
    {
        var start_date  = $('#start_date').val();
        var end_date    = $('#end_date').val();
        var order_patient_id    = $('#order_patient_id').val();
        if(start_date == '')
        {
          alert('please select  start date');return false;
        }
        if(end_date == '')
        {
          alert('please select  end date');return false;
        }
        var str = 'start_date='+start_date+'&end_date='+end_date+'&order_patient_id='+order_patient_id+'&<?php echo $this->security->get_csrf_token_name(); ?>='+'<?php echo $this->security->get_csrf_hash(); ?>';
        var PAGE = '<?php echo base_url().MODULE_NAME; ?>order/bulkPrintLabel';
        jQuery.ajax({
            type :"POST",
            url  :PAGE,
            data : str,
            success:function(data)
            {
              $('#view_bulk_print_Data').html('');        
               $('#view_print_Data').html(data);
            } 
        });
    } 

    function  bulkBreakfastPrintLabel()
    {
        var start_date  = $('#start_date').val();
        var end_date    = $('#end_date').val();
        var order_patient_id    = $('#order_patient_id').val();
        if(start_date == '')
        {
          alert('please select  start date');return false;
        }
        if(end_date == '')
        {
          alert('please select  end date');return false;
        }
        var str = 'start_date='+start_date+'&end_date='+end_date+'&order_patient_id='+order_patient_id+'&<?php echo $this->security->get_csrf_token_name(); ?>='+'<?php echo $this->security->get_csrf_hash(); ?>';
        var PAGE = '<?php echo base_url().MODULE_NAME; ?>order/bulkBreakfastPrintLabel';
        jQuery.ajax({
            type :"POST",
            url  :PAGE,
            data : str,
            success:function(data)
            {        
               $('#view_print_Data').html('');
               $('#view_bulk_print_Data').html(data);
            } 
        });
    } 
</script>

