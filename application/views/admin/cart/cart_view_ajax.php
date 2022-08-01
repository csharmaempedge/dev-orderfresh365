<?php
$cart_list = $this->common_model->getData('tbl_cart', array('patient_id'=>$user_id, 'qty !='=>0), 'multi',NULL,NULL,NULL, 'unique_no');
$global_res = $this->common_model->getData('tbl_global_setting', NULL, 'single');
$totalQty = $this->dashboard_model->gettotalQty($user_id);
$totalBreakfastQty = $this->dashboard_model->gettotalBreakfastQty($user_id);
$toTalQTY = $totalQty->qty + $totalBreakfastQty->qty;

?>

    <div class="table-responsive" >
    <table class="table table-bordered table-striped" id="example">
          <thead>
              <tr class="label-primary">
                <!-- <th style="background-color: #bad59c; color: #22255a;">S.No.</th>  -->                         
                <th style="background-color: #bad59c; color: #22255a;">Remove</th>
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
                        <td width="15%">
                            <a onclick="removeCartItem('<?php echo $crt_res->unique_no;?>')" class="confirm btn btn-danger btn-sm"title="Remove"><i class="fa fa-trash-o fa-1x" data-toggle="modal" data-target=".bs-example-modal-sm"></i></a>  
                        </td>
                        <td>
                          <!-- <?php echo $crt_res->qty.'----'.$crt_res->cart_id;?> -->
                          <input onkeyup="updateCartItem('<?php echo $crt_res->cart_id;?>',this.value)" autocomplete="off" type="number" name="qty" id="qty" class="form-control" value="<?php echo $crt_res->qty; ?>">
                        </td>
                        <td>
                          <?php 
                            $price = $product_wise_amount_res->total_product_price * $crt_res->qty;
                          echo $price; ?>
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
                    ?>    
                    <tr>
                        <!-- <td><?php echo $i; ?></td> -->
                        <td width="15%">
                            <a onclick="removeBreakfastCartItem('<?php echo $b_res->breakfast_cart_id;?>')" class="confirm btn btn-danger btn-sm"title="Remove"><i class="fa fa-trash-o fa-1x" data-toggle="modal" data-target=".bs-example-modal-sm"></i></a>  
                        </td>
                        <td>
                          <!-- <?php echo $b_res->qty.'------------'.$b_res->breakfast_cart_id;?> -->
                          <input onkeyup="updateBreakfastCartItem('<?php echo $b_res->breakfast_cart_id;?>',this.value)" autocomplete="off" type="number" name="qty" id="qty" class="form-control" value="<?php echo $b_res->qty; ?>">
                        </td>
                        <td>
                          <?php echo $b_res->breakfast_price;?>
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
            <tr>
              <th class="text-right" colspan="2">Amount</th>
              <td>
                <?php 

                $total_product_price = $total_product_price + $breakfast_price;
                echo $total_product_price; ?>
              </td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <th class="text-right" colspan="2">Delivery Distance</th>
              <td id="distanse_realod_sec">
                <?php echo (!empty($cart_list[0]->distance_charge)) ? $cart_list[0]->distance_charge : '0'; ?>
              </td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <th class="text-right" colspan="2">Delivery Charge</th>
              <td>
                <?php echo (!empty($cart_list[0]->extra_delivery_charge)) ? $cart_list[0]->extra_delivery_charge : '0'; ?>
              </td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <th class="text-right" colspan="2">Late Charge</th>
              <td>
                <?php echo (!empty($cart_list[0]->late_charge)) ? $cart_list[0]->late_charge : '0'; ?>
              </td>
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
                  <?php 
                  $minimum_surcharge = (!empty($global_res->minimum_surcharge)) ? $global_res->minimum_surcharge : '0';
                  echo $minimum_surcharge; ?>
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
              <th class="text-right" colspan="2">Total Amount</th>
              <td id="distanse_realod_sec1">
                <?php 
                $total_product_price    = (!empty($total_product_price)) ? $total_product_price : '0';
                $distance_charge        = (!empty($cart_list[0]->distance_charge)) ? $cart_list[0]->distance_charge : '0';
                $extra_delivery_charge  = (!empty($cart_list[0]->extra_delivery_charge)) ? $cart_list[0]->extra_delivery_charge : '0';
                $late_charge  = (!empty($cart_list[0]->late_charge)) ? $cart_list[0]->late_charge : '0';
                $final_amount = $total_product_price + $distance_charge + $extra_delivery_charge + $late_charge +$minimum_surcharge;
                echo (!empty($final_amount)) ? $final_amount : '0'; ?>
                <input type="hidden" name="session_patient_id" id="session_patient_id" value="<?php echo $user_id; ?>">
                <input type="hidden" name="actual_amount" id="actual_amount" value="<?php echo $final_amount ?>">
                <input type="hidden" name="actual_amount" id="actual_amount" value="<?php echo $final_amount ?>">
              </td>
              <td></td>
              <td></td>
            </tr>

            <tr>
              <th class="text-right" colspan="2">Apply Coupon Code</th>
              <td>
                <input onchange="checkCouponCode(this.value, '<?php echo $final_amount ?>')" autocomplete="off" type="text" name="apply_coupon_code" id="apply_coupon_code" class="form-control" value="">
                <p id="coupon_code_error" style="color:red;"></p>
                <p id="apply_coupon_code_msg" style="color:#15d015; "></p>
              </td>
            </tr>
            <tr>
            <tr style="display: none;" id="coupon_div">
              <th class="text-right" colspan="2">Total Amount</th>
              <td>
                <span id="apply_coupon_code_msg1"></span>
              </td>
            </tr>
            <tr>
              <th class="text-right" colspan="2">Tax</th>
              <td>
                <?php 
                    echo  $tax = (!empty($global_res->tax)) ? $global_res->tax : '0' ;
                ?> %
              </td> 
              <td></td>
              <td></td>
            </tr>
            <tr style="background-color: #bad59c; color:#22255a;">
              <th class="text-right" colspan="6">Final Amount</th>
              <td id="distanse_realod_sec2">
                <input type="hidden" name="final_amount_" id="final_amount_" value="<?php echo $final_amount ?>">
                <input type="hidden" name="tax_" id="tax_" value="<?php echo $tax ?>">
                <input type="hidden" name="checkout_new_amount" id="checkout_amount_" value="">
                <p id="checkout_amount__"></p>
                <!-- <?php 
                    $percent_value = $final_amount * $tax/100;
                    $chk_amount = $percent_value + $final_amount;
                    $checkout_amount = round($chk_amount, 2);
                    echo  $checkout_amount;
                ?>  -->
              </td> 
            </tr>
            <tr>

            <div class="clearfix" ></div>
        <hr>
          </tbody>
    </table>
    
    <div class="row">
      <?php
      if($toTalQTY <= '6')
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
    
    </div>

</form>

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
                          <input readonly type="text" class="form-control" name="checkout_amount" id="checkout_amount" value="">
                          <input readonly type="hidden" class="form-control" name="actual_amount_" id="actual_amount_" value="">
                          <input readonly type="hidden" class="form-control" name="minimum_surcharge_" id="minimum_surcharge_" value="">
                          <input type="hidden" class="form-control" name="apply_coupon_code_" id="apply_coupon_code_" value="">
                          <input type="hidden" class="form-control" name="user_address_new" id="user_selected_address" value="">
                        </div>
                      </div>
                      <div class="form-group col-md-6">
                        <div class="input text">
                          <label>Special Delivery Amount </label>
                          <input readonly type="text" class="form-control" name="special_delivery_charge" id="special_delivery_charge" value="">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-md-6">
                        <div class="input text">
                          <label> Final Amount </label>
                          <input readonly type="text" class="form-control" name="notification_Amount" id="notification_Amount" value="">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-md-12">
                        <label> Warning Message </label>
                        <textarea readonly id="warning_message" class="form-control"></textarea>
                      </div>
                    </div>
                    <!-- <div class="row" >
                        <div id="realod_sec">
                        <h4 class="label-success" style="margin-bottom: 18px; color: #fff; padding: 6px;"><b>Delivery Address  Details:</b></h4>
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Select </th>
                                        <th>Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $address_res = $this->common_model->getData('tbl_address', array('user_id'=>$user_id), 'multi', null, 'address_id DESC', 5);
                                    if(!empty($address_res))
                                    {
                                        foreach ($address_res as $add_res) 
                                        {
                                            ?>
                                            <tr class="odd gradeX">
                                                <td width="10px;"><input checked required type="radio" name="user_address_new" id="user_address_new" value="<?php echo $add_res->user_address; ?>"></td>
                                                <td><?php echo $add_res->user_address; ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <div class="form-group col-md-12">
                                <div class="input text">
                                    <label>Enter New Address<span class="text-danger">*</span></label>
                                    <textarea name="ajax_user_address" id="ajax_user_address" onchange="addAjaxAddress()" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Edit</button>
                        <button type="submit" name="Submit" value="Accept" class="btn btn-primary">Ok To Accept Pickup </button>
                        <button type="submit" name="Submit" value="Payment" class="btn btn-success">Contact For Special Delivery Charge</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- /panel footer -->
</div> 
<div id="distanse_realod_sec3">
  <script type="text/javascript">
    calculation();
    function addAjaxAddress(){
      var ajax_user_address = $('#ajax_user_address').val();
      var str = 'ajax_user_address='+ajax_user_address;          
        var PAGE = '<?php echo base_url();?>admin/order/addAjaxAddress';        
        jQuery.ajax({
            type :"POST",
            url  :PAGE,
            data : str,
            cache: false,        
            success:function(data)
            { 
                $("#realod_sec").load(" #realod_sec");
            }
        });
    }
    function openModel(id)
    {
        sendMailMoreThan20QTY(id);
        var checkout_amount = $('#checkout_amount_').val();
        var actual_amount = $('#actual_amount').val();
        
        var special_delivery_charge = '<?php echo $global_res->special_delivery_charge ;?>';
        var notification_Amount = parseFloat(checkout_amount)+parseFloat(special_delivery_charge);
        $('#patient_id').val(id);
        $('#checkout_amount').val(checkout_amount);
        $('#actual_amount_').val(actual_amount);
        
        $('#special_delivery_charge').val(special_delivery_charge);
        $('#notification_Amount').val(notification_Amount);
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
        var user_selected_address      = $('input[name="user_address"]:checked').val();
        var address_wise_special_delivery_charge = $('#address_wise_special_delivery_charge').val();
        var checkout_amount = $('#checkout_amount_').val();
        var actual_amount   = $('#actual_amount').val();
        var apply_coupon_code = $('#apply_coupon_code').val();
        /*var special_delivery_charge = '<?php echo $global_res->special_delivery_charge ;?>';*/
        var minimum_surcharge = '<?php echo $global_res->minimum_surcharge ;?>';
        var warning_message = '<?php echo $global_res->warning_message ;?>';
        var notification_Amount = parseFloat(checkout_amount)+parseFloat(address_wise_special_delivery_charge);
        $('#patient_id').val(id);
        $('#checkout_amount').val(checkout_amount);
        $('#actual_amount_').val(actual_amount);
        $('#apply_coupon_code_').val(apply_coupon_code);
        $('#special_delivery_charge').val(address_wise_special_delivery_charge);
        $('#user_selected_address').val(user_selected_address);
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
                if(data == 'success')
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
                $('#coupon_div').show();
                var final_amount_ = parseFloat(final_amount)-parseFloat(data);
                $('#apply_coupon_code_msg').text(data);
                $('#apply_coupon_code_msg1').text(final_amount_);
                $('#final_amount_').val(final_amount_);
                $('#coupon_code_error').html('');
                $('.payment').show();
                calculation();
            }
        });
    }

    
    function calculation()
    {
      var final_amount_ = $('#final_amount_').val();
      var tax_ = $('#tax_').val();
      var percent_value = parseFloat(final_amount_)*parseFloat(tax_/100);
      var chk_amount = parseFloat(percent_value)+parseFloat(final_amount_);
      $('#checkout_amount_').val(chk_amount);
      $('#checkout_amount__').text(chk_amount);
    }
  </script>
</div>