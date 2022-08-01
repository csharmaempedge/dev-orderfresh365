
<aside class="right-side">
   <section class="content-header">
      <h1>Dashboard</h1>
        <ol class="breadcrumb">
           <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
           <li class="active">dashboard</li>
        </ol>
      <?php
      if(!empty($role_id))
      {
        if($role_id == '2')
        {
          
          ?>
          <!-- Main content -->
            <section class="content">       
                <div class="box box-success">
                    <div class="box-header">
                        <div class="pull-left">
                            <h3 class="box-title">Order Details</h3>
                        </div>
                        <div class="pull-right">
                           
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
                                  <div class="form-group col-md-4">
                                     <div class="input text">
                                         <label>To Date</label>
                                            <input autocomplete="off" type="text" name="start_date" id="start_date" class="form-control date_val" value="<?php echo (!empty($start_date)) ? $start_date : ''; ?>" onchange="assignEndDate(this.value)">
                                     </div>
                                  </div>
                                  <div class="form-group col-md-4">
                                     <div class="input text">
                                         <label>From Date</label>
                                         <div  id="show_end_date">
                                            <input autocomplete="off" type="text" name="end_date" id="end_date" class="form-control" value="<?php echo (!empty($end_date)) ? $end_date : ''; ?>" >
                                         </div>
                                     </div>
                                  </div>
                                  <div class="form-group col-md-4" style="margin-top: 30px;">
                                     <div class="input text">
                                          <button class="btn btn-success btn-sm" type="submit" name="Submit" value="search" >Filter</button>
                                          <a class="btn btn-danger btn-sm" href="<?php echo base_url().MODULE_NAME;?>dashboard">Cancel</a>
                                          <span class="btn btn-info btn-sm " target="_blank" title="Print" onclick="printInvoice();">Print</span>
                                     </div>
                                  </div> 
                              </div>
                            </div>
                            <div id="print_div">
                              <table class="table table-bordered table-striped" id="example_new">
                                  <thead>
                                      <tr>
                                        <th style="background-color: #c8c9e3; color: #22255a;">Order Date</th>
                                        <th style="background-color: #c8c9e3; color: #22255a;">Item</th>
                                        <th style="background-color: #c8c9e3; color: #22255a;">Total Ordered Plus(pound)</th>
                                        <th style="background-color: #c8c9e3; color: #22255a;">Total Raw (pound)</th>
                                        <th style="background-color: #c8c9e3; color: #22255a;">Cooked Portions</th>
                                        
                                      </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <th class="text-right" colspan="2"></th>
                                      <td>
                                        <?php
                                        if(!empty($start_date) && !empty($end_date))
                                        {
                                        $cart_res = $this->common_model->getData('tbl_order_product', array('delivery_status'=>'Pending', 'order_product_created_date >='=>$start_date, 'order_product_created_date <= '=>$end_date), 'multi',NULL,NULL,NULL,'product_id');
                                        }
                                        else
                                        {
                                        $cart_res = $this->common_model->getData('tbl_order_product', array('delivery_status'=>'Pending'), 'multi',NULL,NULL,NULL,'product_id');
                                        }
                                        if(!empty($cart_res))
                                        {   
                                            foreach ($cart_res as $res) 
                                            {
                                                if(!empty($start_date) && !empty($end_date))
                                                {
                                                $opder_res = $this->common_model->getData('tbl_order_product', array('delivery_status'=>'Pending', 'order_product_created_date >='=>$start_date, 'order_product_created_date <= '=>$end_date, 'product_id'=>$res->product_id), 'multi');
                                                }
                                                else
                                                {
                                                $opder_res = $this->common_model->getData('tbl_order_product', array('delivery_status'=>'Pending', 'product_id'=>$res->product_id), 'multi');
                                                }
                                                $cc=0;
                                                foreach ($opder_res as $oo_res) 
                                                {
                                                    if(!empty($start_date) && !empty($end_date))
                                                    {
                                                    $op_res = $this->common_model->getData('tbl_order_product', array('delivery_status'=>'Pending', 'order_product_created_date >='=>$start_date, 'order_product_created_date <= '=>$end_date,'qty !='=>0,'unique_no'=>$oo_res->unique_no), 'single');
                                                    }
                                                    else
                                                    {
                                                      $op_res = $this->common_model->getData('tbl_order_product', array('delivery_status'=>'Pending',  'qty !='=>0,'unique_no'=>$oo_res->unique_no), 'single');
                                                    }
                                                    $product_res = $this->common_model->getData('tbl_product', array('product_id'=>$oo_res->product_id), 'single');
                                                    $aa = $oo_res->macro_value_id * $op_res->qty;
                                                    $cc = $cc + $aa;
                                                    $product_plus_percentage = ($product_res->product_plus_percentage * $cc)/100;
                                                    $plus_percentage = $product_plus_percentage + $cc;
                                                    $product_row_amount = $plus_percentage * $product_res->product_row_amount;
                                                    $plus_percentage_new = $plus_percentage/16;
                                                    $no_of_portions = (!empty($product_res->no_of_portions)) ? $product_res->no_of_portions : '0' ;
                                                    if($no_of_portions == 0)
                                                    {
                                                      $no_of_portions_new = 'NA';
                                                    }
                                                    else
                                                    {
                                                      $no_of_portions_new = ($plus_percentage/$no_of_portions);
                                                    }
                                                    $product_row_amount_new = $product_row_amount/16;
                                                }
                                                ?>
                                                <tr>
                                                    <td width="25%" style="background-color: #bad59c; color: #22255a;"><b>
                                                      <?php echo date("m-d-Y", strtotime($op_res->order_product_created_date));?></b>
                                                    </td>
                                                    <td width="25%" style="background-color: #bad59c; color: #22255a;"><b><?php echo $product_res->product_name; ?></b></td>
                                                    <!-- <td style="background-color: #bad59c; color: #22255a;"><b><?php echo $cc; ?></b></td> -->
                                                    <td width="25%"style="background-color: #bad59c; color: #22255a;"><b><?php echo round($plus_percentage_new, 2); ?></b></td>
                                                    <td width="25%"style="background-color: #bad59c; color: #22255a;"><b><?php echo round($product_row_amount_new, 2); ?></b></td>
                                                    <td width="25%"style="background-color: #bad59c; color: #22255a;"><b><?php echo $no_of_portions_new; ?></b></td>
                                                    
                                                </tr>
                                                <?php
                                            }
                                        }
                                            ?>
                                      </td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                    </tr>

                                    <div class="clearfix" ></div>
                                <hr>
                                  </tbody>
                              </table>
                            </div> 
                        </div>
                    </form>
                </div>

                <!-- /.box -->
            </section>
            <!-- /.content -->
          <?php
        }
      }
      ?>
   </section>
</aside>
<script type="text/javascript">
   function printInvoice()
    {
        var divToPrint=document.getElementById('print_div');
        var newWin=window.open('','Print-Window');
        newWin.document.open();
        newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
        newWin.document.close();
        setTimeout(function(){newWin.close();},50);
    }
</script>
<script type="text/javascript">
  function assignEndDate(str)
    {
       $('#show_end_date').html('<input  autocomplete="off" type="text" name="end_date" id="end_date" class="form-control date_val">');
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
</script>

