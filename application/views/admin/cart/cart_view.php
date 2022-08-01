<?php

$cart_list = $this->common_model->getData('tbl_cart', array('patient_id'=>$user_id, 'qty !='=>0), 'multi',NULL,NULL,NULL, 'unique_no');

$global_res = $this->common_model->getData('tbl_global_setting', NULL, 'single');

$totalQty = $this->dashboard_model->gettotalQty($user_id);

$totalBreakfastQty = $this->dashboard_model->gettotalBreakfastQty($user_id);

$toTalQTY = $totalQty->qty + $totalBreakfastQty->qty;



$default_address_res = $this->common_model->getData('tbl_address', array('default_address'=>1,'user_id'=>$user_id, 'address_approval_status'=>'Approved'), 'single');



$user_address = (!empty($default_address_res->user_address)) ? $default_address_res->user_address : '0';

$address_id = (!empty($default_address_res->address_id)) ? $default_address_res->address_id : '0';

$address_special_delivery_charge = (!empty($default_address_res->special_delivery_charge)) ? $default_address_res->special_delivery_charge : '0';

$address_distance_charge = (!empty($default_address_res->distance_charge)) ? $default_address_res->distance_charge : '0';

?>
<?php
if(!empty($cart_list))
{
  ?>
    <aside class="right-side">

        <!-- Content Header (Page header) -->

        <section class="content-header">

            <h1>Cart View</h1>

            <ol class="breadcrumb">

                <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>

                <li><a href="<?php echo base_url().MODULE_NAME;?>cart">Cart </a></li>

                <li class="active">Cart  View</li>

            </ol>

        </section>

        <!-- Main content -->

        <section class="content">       

            <div class="box box-success">

                <div class="box-header">

                  <div id="msg_div">

                        <?php echo $this->session->flashdata('message');?>

                    </div>

                </div>

                

                <form action="<?php echo base_url().MODULE_NAME; ?>order/square" method="post" accept-charset="utf-8" enctype="multipart/form-data">

                    <?php  $csrf = array( 'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash() ); ?>

                    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                    <br>
                    <div class="box-body" >

                        <div class="table-responsive">
                          <div class="form-group col-md-12">

                              <div class="panel-heading" style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Delivery Address

                              </div>
                              <div class="pull-right box-tools" >
                                 <a style="margin-top: -64px; margin-right: 6px;"href="<?php echo base_url().MODULE_NAME;?>address" class="btn btn-danger btn-sm">Change Your Delivery Address</a>


                                 <a style="margin-top: -64px; margin-right: 6px;" class="confirm btn btn-danger btn-sm" onClick="return confirm('Are you sure you want to clear cart?')" href="<?php echo base_url().MODULE_NAME;?>cart/clearCart/<?php echo $user_id;?>" title="Clear Cart">Clear Cart &nbsp;<i class="fa fa-trash-o fa-1x" data-toggle="modal" data-target=".bs-example-modal-sm"></i></a>
                              </div>
                              <br>
                                <!-- <span class="textarea_view"><?php echo $user_address; ?></span> -->
                                <textarea rows="2" disabled class="form-control"><?php echo $user_address; ?></textarea>

                            </div>
                        <table class="table table-bordered table-striped" id="example">
                          <p >

                              <thead>

                                  <tr class="label-primary">

                                    <!-- <th style="background-color: #bad59c; color: #22255a;">S.No.</th>  -->                         

                                    <th style="background-color: #bad59c; color: #22255a;">Remove</th>

                                    <th style="background-color: #bad59c; color: #22255a;">Quantity</th>

                                    <th style="background-color: #bad59c; color: #22255a;">Price Per Meal</th>
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

                                  </tr>

                              </thead>

                              <tbody>

                                <?php

                                if(!empty($cart_list))

                                {

                                    $i = 1;

                                    $total_product_price = 0;

                                    foreach($cart_list as $crt_res)

                                    {

                                      $product_wise_amount_res = $this->dashboard_model->getProductAmount($crt_res->unique_no);

                                        ?>    

                                        <tr>

                                            <!-- <td><?php echo $i; ?></td> -->

                                            <td>

                                                <a onclick="removeCartItem('<?php echo $crt_res->unique_no;?>')" class="confirm btn btn-danger btn-sm"title="Remove"><i class="fa fa-trash-o fa-1x" data-toggle="modal" data-target=".bs-example-modal-sm"></i></a>  

                                            </td>

                                            <td>

                                              <!-- <?php echo $crt_res->qty.'----'.$crt_res->cart_id;?> -->

                                              <input onkeyup="updateCartItem('<?php echo $crt_res->cart_id;?>',this.value)" autocomplete="off" type="number" name="qty" id="qty" class="form-control" value="<?php echo $crt_res->qty; ?>">

                                            </td>

                                            <td>
                                              $

                                              <?php 

                                              $cart_res_meal = $this->common_model->getData('tbl_cart', array('patient_id'=>$user_id,'unique_no'=>$crt_res->unique_no), 'multi');
                                              if(!empty($cart_res_meal))
                                              {
                                                $pcv_meal = $cart_res_meal[0]->macro_value_id.''.$cart_res_meal[1]->macro_value_id.''.$cart_res_meal[2]->macro_value_id;
                                                $standard_meal_carb_res = $this->common_model->getData('tbl_standard_meal', array('pcv_meal'=>$pcv_meal,'meal_status'=>1), 'single');
                                                if(!empty($standard_meal_carb_res))
                                                {
                                                  if($product_wise_amount_res->total_product_price < $standard_meal_carb_res->price)
                                                  {
                                                    $price_per_ounce = $standard_meal_carb_res->price;
                                                    $price = $standard_meal_carb_res->price* $crt_res->qty;
                                                  }
                                                  else
                                                  {
                                                    $price_per_ounce = $product_wise_amount_res->total_product_price;
                                                    $price = $product_wise_amount_res->total_product_price * $crt_res->qty;
                                                  }
                                                }
                                                else
                                                {
                                                  $price_per_ounce = $product_wise_amount_res->total_product_price;
                                                  $price = $product_wise_amount_res->total_product_price * $crt_res->qty;
                                                }

                                              }
                                              ?>

                                                
                                              <span ><?php echo number_format((float)$price_per_ounce,2,'.','');?></span>
                                              
                                            </td>
                                            <td>
                                              $
                                              <span id="special_coupon_code_new_<?php echo $i; ?>"><?php echo number_format((float)$price,2,'.','');?></span>
                                              
                                            </td>

                                            

                                                <?php

                                                foreach ($patient_macro_res as $p_res)

                                                {

                                                    $cart_res = $this->common_model->getData('tbl_cart', array('patient_id'=>$user_id,'macro_id'=>$p_res->macro_id,'unique_no'=>$crt_res->unique_no), 'multi');

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

                                    <!-- <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">S.No.</th> -->                          

                                    <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Remove</th>

                                    <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Quantity</th>

                                    <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Price Per Meal</th>
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

                                    <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;"></th>

                                    <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;"></th>

                                  </tr>

                              </thead>

                              <tbody>

                                <?php

                                $breakfast_cart_res = $this->common_model->getData('tbl_breakfast_cart', array('patient_id'=>$user_id), 'multi');

                                $breakfast_price = 0;

                                if(!empty($breakfast_cart_res))

                                {

                                    $i = 1;

                                    foreach($breakfast_cart_res as $b_res)

                                    {

                                      $product_res1 = $this->common_model->getData('tbl_product', array('product_id'=>$b_res->breakfast_product_id_1), 'single');

                                      $product_res2 = $this->common_model->getData('tbl_product', array('product_id'=>$b_res->breakfast_product_id_2), 'single');
                                      $breakfast_product_per_ounce1 = $product_res1->product_price * $b_res->breakfast_qty_1;
                                      $breakfast_product_per_ounce2 = $product_res2->product_price * $b_res->breakfast_qty_2;
                                      $breakfast_product_per_ounce = $breakfast_product_per_ounce1 +  $breakfast_product_per_ounce2;

                                        ?>    

                                        <tr>

                                            <!-- <td><?php echo $i; ?></td> -->

                                            <td>

                                                <a onclick="removeBreakfastCartItem('<?php echo $b_res->breakfast_cart_id;?>')" class="confirm btn btn-danger btn-sm"title="Remove"><i class="fa fa-trash-o fa-1x" data-toggle="modal" data-target=".bs-example-modal-sm"></i></a>  

                                            </td>

                                            <td>

                                              <!-- <?php echo $b_res->qty.'------------'.$b_res->breakfast_cart_id;?> -->

                                              <input onkeyup="updateBreakfastCartItem('<?php echo $b_res->breakfast_cart_id;?>',this.value)" autocomplete="off" type="number" name="qty" id="qty" class="form-control" value="<?php echo $b_res->qty; ?>">

                                            </td>

                                            <td>

                                              $ <?php 

                                              echo  number_format((float)$breakfast_product_per_ounce,2,'.','');

                                              ?>

                                            </td>
                                            <td>

                                              $ <?php 

                                              echo  number_format((float)$b_res->breakfast_price,2,'.','');

                                              ?>

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

                                            

                                        </tr>

                                        <?php

                                        $breakfast_price = $b_res->breakfast_price + $breakfast_price;

                                        $i++;

                                    }

                                }

                                ?>

                              </tbody>





                              <tbody>

                                <tr id="specialCouponReload">

                                  <th class="text-right" colspan="3">Sub Total Amount</th>

                                  <td id="amount_special_coupon_code">

                                    $ <?php 



                                    $total_product_price = $total_product_price + $breakfast_price;

                                    echo number_format((float)$total_product_price,2,'.',''); ?>

                                  </td>

                                  <td></td>

                                  <td></td>

                                </tr>

                                <tr>

                                  <th class="text-right" colspan="3">Delivery Distance</th>

                                  <td>

                                    $ <?php echo number_format((float)$address_distance_charge,2,'.',''); ?>

                                  </td>

                                  <td></td>

                                  <td></td>

                                </tr>

                                <tr>

                                  <th class="text-right" colspan="3">Delivery Charge</th>

                                  <td>

                                    $ <?php  $extra_delivery_charge_new = (!empty($cart_list[0]->extra_delivery_charge)) ? $cart_list[0]->extra_delivery_charge : '0';

                                      echo number_format((float)$extra_delivery_charge_new,2,'.','');

                                     ?>

                                  </td>

                                  <td></td>

                                  <td></td>

                                </tr>

                                <tr>

                                  <th class="text-right" colspan="3">Late Charge</th>

                                  <td>

                                    $ <?php

                                      $late_charge_new = (!empty($cart_list[0]->late_charge)) ? $cart_list[0]->late_charge : '0';

                                      echo number_format((float)$late_charge_new,2,'.','');

                                    ?>

                                  </td>

                                  <td></td>

                                  <td></td>

                                </tr>

                                <?php

                                if($toTalQTY < '6')

                                {

                                  ?>

                                  <tr>

                                    <th class="text-right" colspan="3">Minimum Order Surcharge</th>

                                    <td>

                                      $ <?php 

                                       $minimum_surcharge = (!empty($global_res->minimum_surcharge)) ? $global_res->minimum_surcharge : '0';

                                      echo number_format((float)$minimum_surcharge,2,'.',''); ?>

                                    </td>

                                    <input type="hidden" name="minimum_surcharge" value="<?php echo $minimum_surcharge ?>">

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

                                  <th class="text-right" colspan="3">Total Amount</th>

                                  <td id="final_amount_new">

                                    $ <?php 

                                    $total_product_price    = (!empty($total_product_price)) ? $total_product_price : '0';

                                    $extra_delivery_charge  = (!empty($cart_list[0]->extra_delivery_charge)) ? $cart_list[0]->extra_delivery_charge : '0';

                                    $late_charge  = (!empty($cart_list[0]->late_charge)) ? $cart_list[0]->late_charge : '0';

                                    $final_amount = $total_product_price + $address_distance_charge + $extra_delivery_charge + $late_charge +$minimum_surcharge;

                                     $final_amount_new = (!empty($final_amount)) ? $final_amount : '0';

                                    echo number_format((float)$final_amount_new,2,'.',''); ?>

                                    <input type="hidden" name="actual_amount" id="actual_amount" value="<?php echo $final_amount ?>">

                                    <input type="hidden" name="actual_amount" id="actual_amount" value="<?php echo $final_amount ?>">

                                    

                                  </td>

                                  <td></td>

                                  <td></td>

                                </tr>



                                <tr>

                                  <th class="text-right" colspan="3">Apply Coupon Code</th>

                                  <td>

                                    <input onchange="checkCouponCode(this.value, '<?php echo $final_amount ?>')" autocomplete="off" type="text" name="apply_coupon_code" id="apply_coupon_code" class="form-control" value="">

                                    <p id="coupon_code_error" style="color:red;"></p>

                                    <p id="apply_coupon_code_msg" style="color:#15d015; "></p>

                                  </td>

                                </tr>

                                <tr>

                                <tr style="display: none;" id="coupon_div">

                                  <th class="text-right" colspan="3">Total Amount</th>

                                  <td>

                                    $ <span id="apply_coupon_code_msg1"></span>

                                  </td>

                                </tr>

                                <tr>

                                  <th class="text-right" colspan="3">Tax</th>

                                  <td>

                                    $ <?php 

                                          $tax = (!empty($global_res->tax)) ? $global_res->tax : '0' ;

                                          echo number_format((float)$tax,2,'.','');

                                    ?> %

                                  </td> 

                                  <td></td>

                                  <td></td>

                                </tr>
                                <tr>

                                  <th class="text-right" colspan="3">Tax Amount</th>

                                  <td id="tax_amount">

                                  </td> 

                                  <td></td>

                                  <td></td>

                                </tr>

                                <tr style="background-color: #bad59c; color:#22255a;">

                                  <th class="text-right" colspan="3">Final Amount </th>

                                  <td>

                                    <input type="hidden" name="sub_total_amount" id="sub_total_amount" value="<?php echo $total_product_price ?>">
                                    <input type="hidden" name="final_amount_" id="final_amount_" value="<?php echo $final_amount ?>">

                                    <input type="hidden" name="tax_" id="tax_" value="<?php echo $tax ?>">

                                    <input type="hidden" name="checkout_new_amount" id="checkout_amount_"value="">

                                    $ <span id="checkout_amount__"></span>

                                    <!-- <?php 

                                        $percent_value = $final_amount * $tax/100;

                                        $chk_amount = $percent_value + $final_amount;

                                        $checkout_amount = round($chk_amount, 2);

                                        echo  $checkout_amount;

                                    ?>  -->

                                  </td>

                                  <td></td>

                                  <td></td>

                                  <td></td>

                                  <td></td> 

                                </tr>

                                <tr>



                                <div class="clearfix" ></div>

                            <hr>

                              </tbody>
                          </p>
                        </table>

                        <div class="row">

                          <?php

                          if($toTalQTY < '6')

                          {

                            ?>

                            <div class="form-group col-md-12">

                              <div class="panel-heading" style="background-color: #df0c0c; color: #fff;">MINIMUM ORDER WARNING MESSAGE

                              </div>

                              <br>

                                <textarea style="color: #df0c0c;" rows="4" name="minimum_order_warning_message" id="minimum_order_warning_message" class="form-control"><?php echo (!empty($global_res)) ? $global_res->minimum_order_warning_message : ''; ?></textarea>

                            </div>

                            

                            <?php

                          }

                          ?>

                        </div>

                        <div class="row">

                          <div class="form-group col-md-12">

                              <div class="panel-heading" style="background-color:<?PHP echo THEME_COLOR; ?>; color: #000;">DELIVERY ADDRESS

                              </div>

                              <br>

                              <input type="hidden" name="address_id" id="address_id" value="<?php echo $address_id ?>">

                              <input type="hidden" name="address_special_delivery_charge" id="address_special_delivery_charge" value="<?php echo $address_special_delivery_charge ?>">

                                <textarea readonly rows="4" name="user_address" id="user_address" class="form-control"><?php echo $user_address; ?></textarea>

                            </div>

                        </div>

                        

                        </div> 

                    </div>

                    <!-- /.box-body -->      

                    <div class="box-footer">

                       <?php

                        if($cart_list[0]->total_distance >= '25' || $toTalQTY >= '20')

                        {

                          if($toTalQTY >= '20')

                          {

                            if($cart_list[0]->cart_approval_status == 'Approved')

                            {

                              ?>

                               <button type="submit" name="Submit" value="Order" class="btn btn-success payment" id="check_address_approval">Payment Now</button>

                              <?php

                            }

                            else

                            {

                              ?>

                                <span class="btn btn-danger" title="Alert" onclick="openModel(<?php echo $user_id; ?>);">Notification</span>

                                <?php

                            }

                          }

                          elseif($cart_list[0]->total_distance >= '25')

                          {

                            ?>

                              <span class="btn btn-danger" title="Alert" onclick="openDistanceModel(<?php echo $user_id; ?>);">Notification</span>

                            <?php

                          }

                          

                        }

                        else

                        {

                          ?>

                           <button type="submit" name="Submit" id="check_address_approval" value="Order" class="btn btn-success payment">Payment Now</button>

                          <?php

                        }

                      ?> 

                    </div>

                </form>

            </div>



            <!-- /.box -->

        </section>

        <!-- /.content -->

    </aside>

    <div id="processModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <!-- Modal Header -->

                <div class="modal-header" style="background-color: <?PHP echo THEME_COLOR; ?>;">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color: #fff;">&times;</span></button>

                    <h4 class="modal-title" id="myModalLabel">Notification</h4>

                </div>

                <!-- Modal Body -->

                <div class="modal-body">

                   <form method="POST" action="<?php echo base_url().MODULE_NAME; ?>order/sendMailTotalQTY">

                        <?php  $csrf = array( 'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash() ); ?>

                        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

                        <input type="hidden" name="patient_id" id="patient_id" value="<?php echo $user_id; ?>">

                        

                        <div class="row">

                            <div class="form-group col-md-12">

                                <div class="input text">

                                    <label>Message</label>

                                    <textarea rows="6" disabled class="form-control"><?php echo (!empty($global_res->quantites_20_message)) ? $global_res->quantites_20_message : ''; ?></textarea>



                                    <!-- <label>Note<span class="text-danger">*</span></label>

                                    <textarea required name="mail_content" id="mail_content " class="form-control"></textarea> -->

                                </div>

                            </div>

                        </div>

                        <!-- Modal Footer -->

                        <div class="modal-footer">

                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>

                            <!-- <button type="submit" name="submit" value="Add" class="btn btn-primary">Contact Us</button> -->

                        </div>

                    </form>

                </div>

            </div>

        </div>

    <!-- /panel footer -->

    </div> 

    <div id="processdistanceModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <!-- Modal Header -->

                <div class="modal-header" style="background-color: <?PHP echo THEME_COLOR; ?>;">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color: #fff;">&times;</span></button>

                    <h4 class="modal-title" id="myModalLabel">Notification</h4>

                </div>

                <!-- Modal Body -->

                <div class="modal-body">

                   <form method="POST" action="<?php echo base_url().MODULE_NAME; ?>order/square">

                        <?php  $csrf = array( 'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash() ); ?>

                        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

                        <input type="hidden" name="patient_id" id="patient_id" value="<?php echo $user_id; ?>">

                        <div class="row">

                          <div class="form-group col-md-6">

                            <div class="input text">

                              <label> Amount </label>

                              <div class='input-group'>

                                  <span class="input-group-addon">

                                      $

                                  </span>

                                  <input readonly type="text" class="form-control" name="checkout_amount" id="checkout_amount" value="">

                              </div>

                              <input readonly type="hidden" class="form-control" name="actual_amount_" id="actual_amount_" value="">

                              <input readonly type="hidden" class="form-control" name="minimum_surcharge_" id="minimum_surcharge_" value="">

                              <input readonly type="hidden" class="form-control" name="address_id_new" id="address_id_new" value="">

                              <input type="hidden" class="form-control" name="apply_coupon_code_" id="apply_coupon_code_" value="">

                            </div>

                          </div>

                          <div class="form-group col-md-6">

                            <div class="input text">

                              <label>Special Delivery Amount </label>

                              <div class='input-group'>

                                  <span class="input-group-addon">

                                      $

                                  </span>

                                  <input readonly type="text" class="form-control" name="special_delivery_charge" id="special_delivery_charge" value="">

                              </div>

                            </div>

                          </div>

                        </div>

                        <div class="row">

                          <div class="form-group col-md-6">

                            <div class="input text">

                              <label> Final Amount </label>

                              <div class='input-group'>

                                  <span class="input-group-addon">

                                      $

                                  </span>

                                  <input readonly type="text" class="form-control" name="notification_Amount" id="notification_Amount" value="">

                              </div>

                            </div>

                          </div>

                        </div>

                        <div class="row">

                          <div class="form-group col-md-12">

                            <label> Deliver Address </label>

                            <textarea readonly name="user_address_new" id="user_address_new" class="form-control"></textarea>

                          </div>

                        </div>

                        <div class="row">

                          <div class="form-group col-md-12">

                            <label> Warning Message </label>

                            <textarea readonly id="warning_message" class="form-control"></textarea>

                          </div>

                        </div>

                        <!-- Modal Footer -->

                        <div class="modal-footer">

                            <button type="button" class="btn btn-success" data-dismiss="modal">Edit</button>

                            <button type="submit" name="Submit" value="Accept" id="check_address_approval" class="btn btn-primary">Ok To Accept Pickup </button>

                            <button type="submit" name="Submit" value="Payment" id="check_address_approval1" class="btn btn-success">Contact For Special Delivery Charge</button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    <!-- /panel footer -->

    </div> 
    <script type="text/javascript">
      function applyCouponCode(apply_coupon_code, final_amount){
        var str = 'apply_coupon_code='+apply_coupon_code+'&final_amount='+final_amount;        

        var PAGE = '<?php echo base_url();?>admin/cart/applyCouponCode';        

            jQuery.ajax({

            type :"POST",

            url  :PAGE,

            data : str,

            cache: false,        

            success:function(data)

            { 
              if(data == 404)
              {
                applySpecialCouponCode(apply_coupon_code);
              }
              else
              {
                <?php
                 $cci = 1;
                  foreach($cart_list as $crt_res)
                  {
                    $product_wise_amount_res = $this->dashboard_model->getProductAmount($crt_res->unique_no);
                    $price1 = $product_wise_amount_res->total_product_price * $crt_res->qty;
                    $price_new = number_format((float)$price1,2,'.','');
                    ?>
                      $('#special_coupon_code_new_<?php echo $cci; ?>').val(<?php echo $price_new; ?>);
                      $('#special_coupon_code_new_<?php echo $cci; ?>').text(<?php echo $price_new; ?>);
                    <?php
                    $cci ++;
                  }
                ?>
                  $('#coupon_div').show();

                  var final_amount_ = parseFloat(final_amount)-parseFloat(data);

                  $('#apply_coupon_code_msg').text(data);

                  $('#apply_coupon_code_msg1').text(final_amount_);

                  $('#final_amount_').val(final_amount_);

                  $('#coupon_code_error').html('');

                  $('.payment').show();

                  calculation();
              }

            }

        });

    }
      function applySpecialCouponCode(apply_coupon_code){
        var str = 'apply_coupon_code='+apply_coupon_code;                

        var PAGE = '<?php echo base_url();?>admin/cart/applySpecialCouponCode';        

            jQuery.ajax({

            type :"POST",

            url  :PAGE,

            data : str,

            cache: false,        

            success:function(data)

            { 
              if(data != '')
              {
                  finalSpecialCoupanCode(data);
                  $('#coupon_div').hide();
                  $('#apply_coupon_code_msg').text('');

                  $('#apply_coupon_code_msg1').text('');
                    
              }
              else
              { 
                 $('#coupon_div').hide();

                  $('#apply_coupon_code_msg').text(final_amount);

                  $('#apply_coupon_code_msg1').text(final_amount);

                  $('#final_amount_').val(final_amount);

                $('.payment').hide();
              }

            }

        });

    }
    </script>
    <script type="text/javascript">

        calculation();

        function openModel(id)

        {

            sendMailMoreThan20QTY(id);/*

            var checkout_amount = $('#checkout_amount_').val();

            var actual_amount = $('#actual_amount').val();

            var special_delivery_charge = $('#address_special_delivery_charge').val();

            var user_address = $('#user_address').text();

            alert(user_address);

            var notification_Amount = parseFloat(checkout_amount)+parseFloat(special_delivery_charge);

            $('#patient_id').val(id);

            $('#checkout_amount').val(checkout_amount);

            $('#actual_amount_').val(actual_amount);

            

            $('#special_delivery_charge').val(special_delivery_charge);

            $('#user_address_new').text(user_address);

            $('#notification_Amount').val(notification_Amount);*/

            $('#processModal').modal('show');

        }

        function sendMailMoreThan20QTY(id){

          var str = 'patient_id='+id;        

            var PAGE = '<?php echo base_url();?>admin/order/sendMailMoreThan20QTY';        

            jQuery.ajax({

                type :"POST",

                url  :PAGE,

                data : str,

                cache: false,        

                success:function(data)

                { 

                  /*showTostMsg('error', 'update Cart.');

                    setTimeout(function(){

                       location.reload(); 

                  }, 3000);

                  return true;*/

                }

            });

        }

        function openDistanceModel(id)

        {

            var checkout_amount = $('#checkout_amount_').val();

            var actual_amount   = $('#actual_amount').val();

            var apply_coupon_code = $('#apply_coupon_code').val();

            var special_delivery_charge = $('#address_special_delivery_charge').val();

            var user_address = $('#user_address').text();

            var address_id = $('#address_id').val();

            var minimum_surcharge = '<?php echo $global_res->minimum_surcharge ;?>';

            var warning_message = '<?php echo $global_res->warning_message ;?>';

            var notification_Amount = parseFloat(checkout_amount)+parseFloat(special_delivery_charge);

            $('#patient_id').val(id);

            $('#checkout_amount').val(checkout_amount);

            $('#actual_amount_').val(actual_amount);

            $('#apply_coupon_code_').val(apply_coupon_code);

            $('#special_delivery_charge').val(special_delivery_charge);

            $('#user_address_new').text(user_address);

            $('#address_id_new').val(address_id);

            $('#minimum_surcharge_').val(minimum_surcharge);

            $('#warning_message').text(warning_message);

            $('#notification_Amount').val(notification_Amount);

            $('#processdistanceModal').modal('show');

        }

        function showTostMsg(type, msg){

            $.toast({

                heading:'Success',

                text:msg,

                icon:'success',

                loader: true,

                loaderBg: '#fff',

                showHideTransition: 'fade',

                hideAfter: 9000,

                allowToastClose: false,

                position: {

                    left:0,

                    right:10,

                    top:5

                }

            })

        }

        function removeCartItem(unique_no){

          var str = 'unique_no='+unique_no;        

            var PAGE = '<?php echo base_url();?>admin/cart/removeCartItem';        

            jQuery.ajax({

                type :"POST",

                url  :PAGE,

                data : str,

                cache: false,        

                success:function(data)

                { 

                  showTostMsg('error', 'Remove Cart.');

                    setTimeout(function(){

                       location.reload(); 

                  }, 3000);

                  return true;

                }

            });

        }

        function updateCartItem(cart_id,qty){

          if(qty == '' || qty == '0')

          {

            alert('please enter qty');return false;

          }

          var str = 'cart_id='+cart_id+'&qty='+qty;        

            var PAGE = '<?php echo base_url();?>admin/cart/updateCartItem';        

            jQuery.ajax({

                type :"POST",

                url  :PAGE,

                data : str,

                cache: false,        

                success:function(data)

                { 

                  showTostMsg('error', 'update Cart.');

                    setTimeout(function(){

                       location.reload(); 

                  }, 3000);

                  return true;

                }

            });

        }

        function updateBreakfastCartItem(breakfast_cart_id,qty){

          if(qty == '' || qty == '0')

          {

            alert('please enter qty');return false;

          }

          var str = 'breakfast_cart_id='+breakfast_cart_id+'&qty='+qty;        

            var PAGE = '<?php echo base_url();?>admin/cart/updateBreakfastCartItem';        

            jQuery.ajax({

                type :"POST",

                url  :PAGE,

                data : str,

                cache: false,        

                success:function(data)

                { 

                  showTostMsg('error', 'update Cart.');

                    setTimeout(function(){

                       location.reload(); 

                  }, 3000);

                  return true;

                }

            });

        }

        function removeBreakfastCartItem(breakfast_cart_id){

          var str = 'breakfast_cart_id='+breakfast_cart_id;        

            var PAGE = '<?php echo base_url();?>admin/cart/removeBreakfastCartItem';        

            jQuery.ajax({

                type :"POST",

                url  :PAGE,

                data : str,

                cache: false,        

                success:function(data)

                { 

                  showTostMsg('error', 'Remove Cart.');

                    setTimeout(function(){

                       location.reload(); 

                  }, 3000);

                  return true;

                }

            });

        }



        function updateCartProductqty(qty_value,cart_id,cart_product_price){



        /*alert(cart_product_price);return false;*/

           var str = 'cart_id='+cart_id+'&qty_value='+qty_value+'&cart_product_price='+cart_product_price;        

            var PAGE = '<?php echo base_url();?>admin/cart/updateCartProductqty';        

            jQuery.ajax({

                type :"POST",

                url  :PAGE,

                data : str,

                cache: false,        

                success:function(data)

                { 

                  showTostMsg('success', 'Update Cart.');

                    setTimeout(function(){

                       location.reload(); 

                  }, 3000);

                  return true;

                }

            });



       }



        function checkCouponCode(apply_coupon_code, final_amount){

            var str = 'apply_coupon_code='+apply_coupon_code;        

            var PAGE = '<?php echo base_url();?>admin/cart/checkCouponCode';        

                jQuery.ajax({

                type :"POST",

                url  :PAGE,

                data : str,

                cache: false,        

                success:function(data)

                { 

                    if(data == 1)

                    {
                        applyCouponCode(apply_coupon_code, final_amount);
                    }

                    else

                    {

                        $('#coupon_div').hide();

                        $('#coupon_code_error').html(data);

                        $('#apply_coupon_code_msg').html('');

                        $('#apply_coupon_code_msg1').html('');

                        $('.payment').hide();

                    }

                }

            });

        }



        

        

        function finalSpecialCoupanCode(special_coupon_code) 
          {
            <?php
            if(!empty($cart_list))
            {
              $i = 1;
              foreach($cart_list as $crt_res)
              {
                $product_wise_amount_res = $this->dashboard_model->getProductAmount($crt_res->unique_no);
                $base_price = $product_wise_amount_res->total_product_price;
                ?>
                  if(parseFloat(special_coupon_code) >= <?php echo $base_price; ?>)
                  {
                    <?php
                    $price = $product_wise_amount_res->total_product_price * $crt_res->qty;
                    $price_new = number_format((float)$price,2,'.','');
                    ?>
                    $('#special_coupon_code_new_<?php echo $i; ?>').val(<?php echo $price_new; ?>);
                    $('#special_coupon_code_new_<?php echo $i; ?>').text(<?php echo $price_new; ?>);
                  }
                  else if(parseFloat(special_coupon_code) <= <?php echo $base_price; ?>)
                  {
                    var QTY = '<?php echo $crt_res->qty; ?>';
                    var qtyamount = parseFloat(special_coupon_code) * parseFloat(QTY);
                    $('#special_coupon_code_new_<?php echo $i; ?>').val(qtyamount);
                    $('#special_coupon_code_new_<?php echo $i; ?>').text(qtyamount);
                  }
                  else
                  {
                    $('#special_coupon_code_new_<?php echo $i; ?>').val(parseFloat(special_coupon_code));
                    $('#special_coupon_code_new_<?php echo $i; ?>').text(parseFloat(special_coupon_code));
                  }



                  <?php 
                  if($i == count($cart_list))
                  {
                      $extra_delivery_charge  = (!empty($cart_list[0]->extra_delivery_charge)) ? $cart_list[0]->extra_delivery_charge : '0';

                      $late_charge  = (!empty($cart_list[0]->late_charge)) ? $cart_list[0]->late_charge : '0';

                    ?>
                      const num1 = $('#special_coupon_code_new_1').val();
                      const num2 = $('#special_coupon_code_new_2').val();
                      const breakfast_price = <?php echo $breakfast_price; ?>;
                      const amount_special_coupon_code = parseFloat(num1) + parseFloat(num2) + parseFloat(breakfast_price);
                      $('#amount_special_coupon_code').text(amount_special_coupon_code);
                      const extra_delivery_charge = <?php echo $extra_delivery_charge; ?>;
                      const address_distance_charge = <?php echo $address_distance_charge; ?>;
                      const minimum_surcharge = <?php echo $minimum_surcharge; ?>;
                      const late_charge = <?php echo $late_charge; ?>;
                      const final_amount_new = parseFloat(amount_special_coupon_code) + parseFloat(address_distance_charge) + parseFloat(extra_delivery_charge)+ parseFloat(late_charge)+ parseFloat(minimum_surcharge);
                      
                      $('#final_amount_new').text(final_amount_new);

                      
                      const tax_ = $('#tax_').val();

                      /*const tax_amount = parseFloat(final_amount_new)*parseFloat(tax_/100);*/
                      const tax_amount = parseFloat(amount_special_coupon_code)*parseFloat(tax_/100);

                      var chk_amount_new = parseFloat(tax_amount)+parseFloat(final_amount_new);
                     
                      /*var tax_amount_new = Math.round((tax_amount + Number.EPSILON) * 100) / 100;*/
                      var tax_amount_new =  tax_amount.toFixed(2);
                      $('#tax_amount').text('$ '+tax_amount_new);

                      $('#checkout_amount_').val(parseFloat(chk_amount_new));

                      $('#checkout_amount__').text(Math.round((chk_amount_new + Number.EPSILON) * 100) / 100);
                      
                    <?php
                  }

                   ?>
                <?php
                $i ++;
              }


            }
            ?>
          }

        function calculation()

        {

          var sub_total_amount = $('#sub_total_amount').val();
          var final_amount_ = $('#final_amount_').val();

          var tax_ = $('#tax_').val();

          var tax_amount = parseFloat(sub_total_amount)*parseFloat(tax_/100);

          var chk_amount = parseFloat(tax_amount)+parseFloat(final_amount_);

          /*var tax_amount_new = Math.round((tax_amount + Number.EPSILON) * 100) / 100;*/
          var tax_amount_new =  tax_amount.toFixed(2);
          $('#tax_amount').text('$ '+tax_amount_new);
          $('#checkout_amount_').val(chk_amount);

          $('#checkout_amount__').text(Math.round((chk_amount + Number.EPSILON) * 100) / 100);

        }

      </script>
      <script type="text/javascript">
        $("#check_address_approval, #check_address_approval1").click(function () {
          <?php
          if(empty($default_address_res))
          {
            ?>
            alert('Please select your address..!');return false;
            <?PHP
          }
          ?>
        });
      </script>
  <?php
}
else
{
  echo redirect(base_url().MODULE_NAME.'dashboard');
}
?>