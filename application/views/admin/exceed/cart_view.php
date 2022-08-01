<?php
$cart_list = $this->common_model->getData('tbl_cart', array('patient_id'=>$patient_id, 'qty !='=>0), 'multi',NULL,NULL,NULL, 'unique_no');
$global_res = $this->common_model->getData('tbl_global_setting', NULL, 'single');
$totalQty = $this->dashboard_model->gettotalQty($patient_id);
$totalBreakfastQty = $this->dashboard_model->gettotalBreakfastQty($patient_id);
$toTalQTY = $totalQty->qty + $totalBreakfastQty->qty;

?>
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Exceed Quantity Order's Details</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url().MODULE_NAME;?>exceed">Exceed Quantity Order's Details </a></li>
            <li class="active">Exceed Quantity Order's Details </li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">       
        <div class="box box-success">
            <div class="box-header">
                <!-- <div class="pull-left">
                    <h3 class="box-title">Exceed Quantity Order's Details</h3>
                </div> -->
              <div id="msg_div">
                    <?php echo $this->session->flashdata('message');?>
                </div>
                <div class="pull-right box-tools">
                    <a href="<?php echo base_url().MODULE_NAME;?>exceed" class="btn btn-info btn-sm">Back</a>
                </div>
                <br>
            </div>
            
            <form action="#" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                <?php  $csrf = array( 'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash() ); ?>
                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                <div class="box-body">
                    <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="example">
                          <thead>
                              <tr class="label-primary">                  
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
                                        <td>
                                          <?php echo $crt_res->qty; ?>
                                        </td>
                                        <td>
                                          <?php 
                                            $price = $product_wise_amount_res->total_product_price * $crt_res->qty;
                                          echo $price; ?>
                                        </td>
                                        
                                            <?php
                                            foreach ($patient_macro_res as $p_res)
                                            {
                                                $cart_res = $this->common_model->getData('tbl_cart', array('patient_id'=>$patient_id,'macro_id'=>$p_res->macro_id,'unique_no'=>$crt_res->unique_no), 'multi');
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
                                <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Breakfast Quantity</th>
                                <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Breakfast Price</th>
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
                            $breakfast_cart_res = $this->common_model->getData('tbl_breakfast_cart', array('patient_id'=>$patient_id), 'multi');
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
                                        
                                        <td>
                                          <?php echo $b_res->qty; ?>
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


                          
                    </table>
                    
                    </div> 
                </div>
            </form>
        </div>

        <!-- /.box -->
    </section>
    <!-- /.content -->
</aside>
</div>