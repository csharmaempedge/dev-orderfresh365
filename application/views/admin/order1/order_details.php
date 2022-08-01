<?php
$order_list = $this->common_model->getData('tbl_order_product', array('patient_id'=>$patient_id,'order_id'=>$order_id, 'qty !='=>0), 'multi',NULL,NULL,NULL, 'unique_no');
$global_res = $this->common_model->getData('tbl_global_setting', NULL, 'single');
$totalQty = $this->order_model->gettotalOrderQty($patient_id, $order_id);
$totalBreakfastQty = $this->order_model->gettotalBreakfastOrderQty($patient_id, $order_id);
$toTalQTY = $totalQty->qty + $totalBreakfastQty->qty;

?>
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Order Details</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url().MODULE_NAME;?>orderList">Order </a></li>
            <li class="active">Order  Details</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">       
        <div class="box box-success">
            <div class="box-header">
                <div class="pull-left">
                    <h3 class="box-title">Order Details</h3>
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
                    <div class="table-responsive">
                      <table class="table table-bordered table-striped" id="example">
                          <thead>
                              <tr>
                                <th style="background-color: #bad59c; color: #22255a;">S.No.</th>
                                <th style="background-color: #bad59c; color: #22255a;">Quantity</th>
                                <th style="background-color: #bad59c; color: #22255a;">Price</th>
                                <?php
                                $patient_macro_res = $this->common_model->getData('tbl_macro', NULL, 'multi');
                                if(!empty($patient_macro_res))
                                {
                                    foreach ($patient_macro_res as $p_res) 
                                    {
                                        ?><th style="background-color: #bad59c; color: #22255a;"><?php echo $p_res->macro_name; ?></th><?php
                                    }
                                }
                                ?>
                                <th style="background-color: #bad59c; color: #22255a;">Note</th>
                                <?php
                                if($user_id == '2')
                                {
                                  ?>
                                  <th style="background-color: #bad59c; color: #22255a;">Set Expiry Date</th>
                                  <?php
                                }
                                ?>
                              </tr>
                          </thead>
                          <tbody>
                            <?php
                                
                            $total_product_price = 0;
                            if(!empty($order_list))
                            {
                                $i = 1;
                                foreach($order_list as $crt_res)
                                {
                                  $product_wise_amount_res = $this->dashboard_model->getOrderProductAmount($crt_res->unique_no);
                                    ?>    
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td>
                                          <?php echo $crt_res->qty;?>
                                        </td>
                                        <td>
                                          $ <?php 
                                          $price = $product_wise_amount_res->total_product_price * $crt_res->qty;
                                          echo number_format((float)$price,2,'.',''); ?>
                                        </td>
                                        
                                            <?php
                                            foreach ($patient_macro_res as $p_res)
                                            {
                                                $cart_res = $this->common_model->getData('tbl_order_product', array('patient_id'=>$patient_id,'macro_id'=>$p_res->macro_id,'unique_no'=>$crt_res->unique_no), 'multi');
                                                if(!empty($cart_res))
                                                {
                                                    foreach ($cart_res as $res) 
                                                    {
                                                        $product_res = $this->common_model->getData('tbl_product', array('product_id'=>$res->product_id), 'single');
                                                        ?><td><?php echo $res->macro_value_id.' - '.$product_res->product_name; ?></td><?php
                                                    }
                                                }
                                            }
                                            ?>                             
                                        <td>
                                          <?php echo (!empty($crt_res->note)) ? $crt_res->note : '';?>
                                        </td>
                                        <?php
                                        if($user_id == '2')
                                        {
                                          ?>
                                          <td>
                                            <!-- <?php echo (!empty($crt_res->expire_date)) ? $crt_res->expire_date : '';?> -->
                                            <?php
                                            if(!empty($crt_res->expire_date))
                                            {
                                              $expire_date = $crt_res->expire_date;
                                            }
                                            else
                                            {
                                              $expire_date = $global_res->expire_date;
                                            }
                                            ?>
                                            <input autocomplete="off" type="date" name="expire_date" id="expire_date" class="form-control" value="<?php echo $expire_date; ?>" onchange="addExpireDate(<?php echo $crt_res->order_id;?>,<?php echo $crt_res->unique_no;?>, this.value)">
                                          </td>
                                          <?php
                                        }
                                        ?>
                                    </tr>
                                    <?php
                                    $total_product_price = $price + $total_product_price;
                                    $i++;
                                }
                            }
                            else
                            {
                                ?>
                                <tr>
                                    <td colspan="12">No records found...</td>
                                </tr>
                                <?php
                            }
                            ?>
                          </tbody>
                          <thead>
                              <tr class="label-primary">
                                <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">S.No.</th>
                                <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Quantity</th>
                                <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Price</th>
                                <?php
                                $breakfast_res = $this->common_model->getData('tbl_breakfast', NULL, 'multi');
                                if(!empty($breakfast_res))
                                {
                                    foreach ($breakfast_res as $b_res) 
                                    {
                                        ?><th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;"><?php echo $b_res->breakfast_name; ?></th><?php
                                    }
                                }
                                ?>
                                <?php
                                if($user_id == '2')
                                {
                                  ?>
                                  <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Set Expiry Date</th>
                                  <?php
                                }
                                ?>
                                <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;"></th>
                                <?php
                                if($user_id == '2')
                                {
                                  ?>
                                  <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;"></th>
                                  <?php
                                }
                                else
                                {
                                  ?>
                                  <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;"></th>
                                  <?php
                                }
                                ?>
                              </tr>
                          </thead>
                          <tbody>
                            <?php
                            $breakfast_order_res = $this->common_model->getData('tbl_breakfast_order', array('patient_id'=>$patient_id, 'order_id'=>$order_id), 'multi');
                            $breakfast_price = 0;
                            if(!empty($breakfast_order_res))
                            {
                                $i = 1;
                                foreach($breakfast_order_res as $b_res)
                                {
                                  $product_res1 = $this->common_model->getData('tbl_product', array('product_id'=>$b_res->breakfast_product_id_1), 'single');
                                  $product_res2 = $this->common_model->getData('tbl_product', array('product_id'=>$b_res->breakfast_product_id_2), 'single');
                                    ?>    
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td>
                                          <?php echo $b_res->qty;?>
                                        </td>
                                        <td>
                                          $ <?php echo number_format((float)$b_res->breakfast_price,2,'.','');?>
                                        </td>
                                        <td>
                                          <?php 
                                          $product_name1 = (!empty($product_res1)) ? $product_res1->product_name : '';
                                            echo $b_res->breakfast_qty_1.' '.$product_name1; ?>
                                        </td>
                                        <td>
                                          <?php 
                                          $product_name2 = (!empty($product_res2)) ? $product_res2->product_name : '';
                                            echo $b_res->breakfast_qty_2.' '.$product_name2; ?>
                                        </td>
                                        <?php
                                        if($user_id == '2')
                                        {
                                          ?>
                                          <td>
                                            <!-- <?php echo $b_res->expire_date;?> -->
                                            <?php
                                            if(!empty($b_res->expire_date))
                                            {
                                              $expire_date = $b_res->expire_date;
                                            }
                                            else
                                            {
                                              $expire_date = $global_res->expire_date;
                                            }
                                            ?>
                                            <input autocomplete="off" type="date" name="expire_date" id="expire_date" class="form-control" value="<?php echo $expire_date ; ?>" onchange="addBreakfastExpireDate(<?php echo $b_res->order_id;?>,<?php echo $b_res->breakfast_order_id;?>, this.value)">
                                          </td>
                                          <?php
                                        }
                                        ?>
                                        
                                    </tr>
                                    <?php
                                    $breakfast_price = $b_res->breakfast_price + $breakfast_price;
                                    $i++;
                                }
                            }
                            ?>
                          </tbody>
                          <tbody>
                            <tr>
                              <th class="text-right" colspan="2"> Amount</th>
                              <td>
                                $ <?php $total_product_price = $total_product_price + $breakfast_price;
                                echo number_format((float)$total_product_price,2,'.',''); ?>
                              </td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr>
                              <th class="text-right" colspan="2">Delivery Distance</th>
                              <td>
                                $ <?php 
                                $distance_charge_new = (!empty($order_list[0]->distance_charge)) ? $order_list[0]->distance_charge : '0';
                                echo number_format((float)$distance_charge_new,2,'.','');
                                 ?>
                              </td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr>
                              <th class="text-right" colspan="2">Delivery Charge</th>
                              <td>
                                $ <?php 
                                $extra_delivery_charge_new = (!empty($order_list[0]->extra_delivery_charge)) ? $order_list[0]->extra_delivery_charge : '0'; 
                                echo number_format((float)$extra_delivery_charge_new,2,'.',''); 
                                ?>
                              </td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr>
                              <th class="text-right" colspan="2">Late Charge</th>
                              <td>
                                $ <?php 
                                $late_charge_new = (!empty($order_list[0]->late_charge)) ? $order_list[0]->late_charge : '0';
                                echo number_format((float)$late_charge_new,2,'.',''); 
                                 ?>
                              </td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <?php
                            if($toTalQTY <= '6')
                            {
                              ?>
                              <tr>
                                <th class="text-right" colspan="2">Minimum Order Surcharge</th>
                                <td>
                                  $ <?php 
                                  $minimum_surcharge = (!empty($order_result->minimum_surcharge)) ? $order_result->minimum_surcharge : '0';
                                  echo number_format((float)$minimum_surcharge,2,'.',''); ?>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                              </tr>
                              <?php
                            }
                            else
                            {
                              $minimum_surcharge = '0';
                            }
                            ?>
                            <tr>
                              <th class="text-right" colspan="2">Total Amount</th>
                              <td>
                                $ <?php 
                                $total_product_price    = (!empty($total_product_price)) ? $total_product_price : '0';
                                $distance_charge        = (!empty($order_list[0]->distance_charge)) ? $order_list[0]->distance_charge : '0';
                                $extra_delivery_charge  = (!empty($order_list[0]->extra_delivery_charge)) ? $order_list[0]->extra_delivery_charge : '0';
                                $late_charge  = (!empty($order_list[0]->late_charge)) ? $order_list[0]->late_charge : '0';
                                $final_amount = $total_product_price + $distance_charge + $extra_delivery_charge + $late_charge+$minimum_surcharge;
                                $final_amount_new1 = (!empty($final_amount)) ? $final_amount : '0';
                                echo number_format((float)$final_amount_new1,2,'.','');
                                 ?>
                              </td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr>
                              <th class="text-right" colspan="2">Apply Coupon Code</th>
                              <td>
                                <?php echo (!empty($order_result->apply_coupon_code)) ? $order_result->apply_coupon_code : '0'; ?>
                              </td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr>
                              <tr>
                              <th class="text-right" colspan="2">Coupon Amount</th>
                              <td>
                                $ <?php 
                                $coupon_code_amount_new = (!empty($order_result->coupon_code_amount)) ? $order_result->coupon_code_amount : '0';
                                echo number_format((float)$coupon_code_amount_new,2,'.',''); 
                                 ?>
                              </td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr>
                              <tr>
                              <th class="text-right" colspan="2">Total Amount</th>
                              <td>
                                $ <?php 
                                $actual_amount = (!empty($order_result->actual_amount)) ? $order_result->actual_amount : '0';
                                $coupon_code_amount = (!empty($order_result->coupon_code_amount)) ? $order_result->coupon_code_amount : '0';
                                $final_amount_new = $actual_amount - $coupon_code_amount;
                                $final_amount_new2 = (!empty($final_amount_new)) ? $final_amount_new : '0';
                                echo number_format((float)$final_amount_new2,2,'.','');  
                                ?>
                              </td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr>
                              <th class="text-right" colspan="2">Tax</th>
                              <td>
                                $ <?php 
                                      $tax = (!empty($global_res->tax)) ? $global_res->tax : '0' ;
                                      echo number_format((float)$tax,2,'.','');  
                                ?> %
                              </td> 
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr style="background-color: #bad59c; color:#22255a;">
                              <?php
                                if($user_id == '2')
                                {
                                  $colspan = '2';
                                }
                                else
                                {
                                  $colspan = '2';
                                }
                                ?>
                              <th class="text-right" colspan="<?php echo $colspan; ?>">Final Amount</th>
                              <td>
                                $ <?php 
                                    /*$percent_value = $final_amount * $tax/100;
                                    $checkout_amount = $percent_value + $final_amount;
                                    echo  round($checkout_amount, 2);*/
                                    $checkout_amount_1 = (!empty($order_result->checkout_amount)) ? $order_result->checkout_amount : '0'; 
                                    echo number_format((float)$checkout_amount_1,2,'.',''); 

                                ?> 
                              </td>
                              <td></td> 
                              <td></td> 
                              <td></td> 
                              <td></td> 
                              <td></td> 
                            </tr>
                            <tr>

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
</aside>
<script type="text/javascript">
  function  addExpireDate(order_id, unique_no, expire_date)
  {
      var str = 'order_id='+order_id+'&unique_no='+unique_no+'&expire_date='+expire_date+'&<?php echo $this->security->get_csrf_token_name(); ?>='+'<?php echo $this->security->get_csrf_hash(); ?>';
      var PAGE = '<?php echo base_url().MODULE_NAME; ?>order/addExpireDate';
      jQuery.ajax({
          type :"POST",
          url  :PAGE,
          data : str,
          success:function(data)
          {        
            alert('date successfully Update...!');
               /*$("#message_dynamic").show();
                  $("#message_dynamic").html(data);
                  setTimeout(function(){
                      $("#message_dynamic").hide();
                }, 1000);*/
          } 
      });
  } 
  function  addBreakfastExpireDate(order_id,breakfast_order_id, expire_date)
  {
      var str = 'order_id='+order_id+'&breakfast_order_id='+breakfast_order_id+'&expire_date='+expire_date+'&<?php echo $this->security->get_csrf_token_name(); ?>='+'<?php echo $this->security->get_csrf_hash(); ?>';
      var PAGE = '<?php echo base_url().MODULE_NAME; ?>order/addBreakfastExpireDate';
      jQuery.ajax({
          type :"POST",
          url  :PAGE,
          data : str,
          success:function(data)
          {        
            alert('date successfully Update...!');
               /*$("#message_dynamic").show();
                  $("#message_dynamic").html(data);
                  setTimeout(function(){
                      $("#message_dynamic").hide();
                }, 1000);*/
          } 
      });
  } 
</script>