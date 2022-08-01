<?php
$cart_list = $this->common_model->getData('tbl_cart', array('patient_id'=>$user_id, 'qty !='=>0), 'multi',NULL,NULL,NULL, 'unique_no');
$global_res = $this->common_model->getData('tbl_global_setting', NULL, 'single');
$totalQty = $this->dashboard_model->gettotalQty($user_id);
$totalBreakfastQty = $this->dashboard_model->gettotalBreakfastQty($user_id);
$toTalQTY = $totalQty->qty + $totalBreakfastQty->qty;

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
                <!-- <div class="pull-left">
                    <h3 class="box-title">Cart View</h3>
                </div> -->
              <div id="msg_div">
                    <?php echo $this->session->flashdata('message');?>
                </div>
                <!-- <div class="pull-right">
                  <h3 class="text-danger pull-right" style="border: 1px solid #00a65a; padding: 10px; border-radius: 5px;">
                    <?php
                       echo !empty($cart_list) ? 'Total Product: '.count($cart_list) : 'Total Product: 0';
                    ?>
                  </h3>
               </div> -->
            </div>
            
            <form action="<?php echo base_url().MODULE_NAME; ?>order/square" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                <?php  $csrf = array( 'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash() ); ?>
                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                <div class="box-body">
                    <p id="cart_dynamic_div"></p>
                    <div class="row">
                      <div class="col-md-12">
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
                                $address_res = $this->common_model->getData('tbl_address', array('user_id'=>$user_id), 'multi', null, 'address_id DESC');
                                if(!empty($address_res))
                                {
                                    foreach ($address_res as $add_res) 
                                    {
                                        if($add_res->address_approval_status != 'Approved')
                                        {
                                          $bg_color = 'red';
                                          $address_status = 'disabled';
                                        }
                                        else
                                        {
                                          $bg_color = 'green';
                                          $address_status = '';
                                        }
                                        ?>
                                        <tr class="odd gradeX">
                                            <td width="10px;"><input <?php echo $address_status; ?> required type="radio" onclick="addressWiseDataShow(<?php echo $add_res->total_distance.','.$add_res->special_delivery_charge; ?>);" name="user_address" id="user_address" value="<?php echo $add_res->address_id; ?>"></td>
                                            <td style="color: <?php echo $bg_color; ?>;"><?php echo $add_res->user_address; ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                        <span class="btn btn-primary" title="Alert" onclick="openNewAddressModel(<?php echo $user_id; ?>);">Add New Address</span>
                        <hr>
                      </div>
                    </div> 
                </div>
                <!-- /.box-body -->      
                <div class="box-footer">
                  <input type="hidden" id="address_wise_special_delivery_charge">
                  <input type="hidden" id="cart_total_distance" value="<?php echo $cart_list[0]->total_distance; ?>">
                  <input type="hidden" id="cart_cart_approval_status" value="<?php echo $cart_list[0]->cart_approval_status; ?>">
                  <input type="hidden" id="cart_toTalQTY" value="<?php echo $toTalQTY; ?>">
                    <!-- <?php
                      if($cart_list[0]->total_distance >= '30' || $toTalQTY >= '20')
                      {
                        if($toTalQTY >= '20')
                        {
                          if($cart_list[0]->cart_approval_status == 'Approved')
                          {
                            ?>
                             <button style="display: none;" id="show_address_btn" type="submit" name="Submit" value="Order" class="btn btn-success payment">Payment Now</button>
                            <?php
                          }
                          else
                          {
                            ?>
                              <span style="display: none;" id="show_address_btn" class="btn btn-danger" title="Alert" onclick="openModel(<?php echo $user_id; ?>);">Notification</span>
                              <?php
                          }
                        }
                        elseif($cart_list[0]->total_distance >= '30')
                        {
                          ?>
                            <span style="display: none;" id="show_btn_30_mile" class="btn btn-danger" title="Alert" onclick="openDistanceModel(<?php echo $user_id; ?>);">Notification</span>
                          <?php
                        }
                      }
                      else
                      {
                        ?>
                          <button style="display: none;" id="show_address_btn" type="submit" name="Submit" value="Order" class="btn btn-success payment">Payment Now</button>
                        <?php
                      }
                    ?>  -->
                  <span style="display: none;" id="show_notification_btn" class="btn btn-danger" title="Alert" onclick="openModel(<?php echo $user_id; ?>);">Notification</span>
                  <span style="display: none;" id="show_btn_30_mile" class="btn btn-danger" title="Alert" onclick="openDistanceModel(<?php echo $user_id; ?>);">Notification</span>
                  <button style="display: none;" id="show_order_btn" type="submit" name="Submit" value="Order" class="btn btn-success payment">Payment Now</button>
                  
                </div>
            </form>
        </div>

        <!-- /.box -->
    </section>
    <!-- /.content -->
</aside>
</div> 
<div id="distanse_realod_sec3">
  <script type="text/javascript">

    function addressWiseDataShow(address_total_distance, special_delivery_charge)
    {
      addressWiseDistanceCharge();
      $('#address_wise_special_delivery_charge').val(special_delivery_charge);
      var cart_total_distance = $('#cart_total_distance').val();
      var cart_cart_approval_status = $('#cart_cart_approval_status').val();
      var cart_toTalQTY = $('#cart_toTalQTY').val();
      if(address_total_distance >= '30')
      {
        if(parseFloat(cart_toTalQTY) >= '20')
        {
          if(cart_cart_approval_status == 'Approved')
          {
            $('#show_btn_30_mile').show();
            $('#show_notification_btn').hide();
            $('#show_order_btn').hide();
          }
          else
          {
            $('#show_notification_btn').show();
            $('#show_order_btn').hide();
            $('#show_btn_30_mile').hide();
          }
        }
        else
        {
          $('#show_btn_30_mile').show();
          $('#show_notification_btn').hide();
          $('#show_order_btn').hide();
        }
      }
      else
      {
        if(parseFloat(cart_toTalQTY) >= '20')
        {
          if(cart_cart_approval_status == 'Approved')
          {
            $('#show_order_btn').show();
            $('#show_notification_btn').hide();
            $('#show_btn_30_mile').hide();
          }
          else
          {
            $('#show_notification_btn').show();
            $('#show_order_btn').hide();
            $('#show_btn_30_mile').hide();
          }
        }
        else
        {
          $('#show_order_btn').show();
          $('#show_notification_btn').hide();
          $('#show_btn_30_mile').hide();
        }
      }
      /*var sale_address      = $('input[name="sale_address"]:checked').val();*/
    }
  </script>
</div>
<div id="addressModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header" style="background-color: <?PHP echo THEME_COLOR; ?>;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color: #fff;">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Address</h4>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
               <form method="POST" action="<?php echo base_url().MODULE_NAME; ?>order/addNewAddress">
                    <?php  $csrf = array( 'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash() ); ?>
                    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                    <input type="hidden" name="address_patient_id" id="address_patient_id" value="<?php echo $user_id; ?>">
                    
                    <div class="row">
                        <div class="form-group col-md-12">
                            <div class="input text">
                                <label>Enter Address<span class="text-danger">*</span></label>
                                <textarea required name="new_user_address" id="new_user_address" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="submit" value="Add" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- /panel footer -->
</div>
<script type="text/javascript">
  addressWiseDistanceCharge();
  function openNewAddressModel(id)
    {
        $('#address_patient_id').val(id);
        $('#addressModal').modal('show');
    }
    function addressWiseDistanceCharge(){
      var user_selected_address      = $('input[name="user_address"]:checked').val();
      var session_patient_id      = $('#session_patient_id').val();
        var str = 'address_id='+user_selected_address+'&session_patient_id='+session_patient_id;        
        var PAGE = '<?php echo base_url();?>admin/cart/addressWiseDistanceCharge';        
            jQuery.ajax({
            type :"POST",
            url  :PAGE,
            data : str,
            cache: false,        
            success:function(data)
            { 
              $('#cart_dynamic_div').html(data);
                
            }
        });
    }
  </script>