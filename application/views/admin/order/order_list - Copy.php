
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
                <div id="msg_div">
                    <?php echo $this->session->flashdata('message');?>
                </div>
                <div class="pull-right">
                    <?php
                        if($user_id == '2'){
                        ?>
                            <a href="<?php echo base_url().MODULE_NAME;?>order/bulkPrintView" class="btn btn-info btn-sm">Bulk Label Print</a>              
                        <?php
                        }
                    ?>
               </div>
            </div>
            <form action="" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                <?php  $csrf = array( 'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash() ); ?>
                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                <div class="box-body">
                    <div class="table-responsive">
                      <table class="table table-bordered table-striped" id="example">
                          <thead>
                              <tr>
                                <th style="background-color: #c8c9e3; color: #22255a;">S.No.</th>                          
                                <th style="background-color: #c8c9e3; color: #22255a;">Number</th>
                                <th style="background-color: #c8c9e3; color: #22255a;">Order Number</th>
                                <th style="background-color: #c8c9e3; color: #22255a;">Total Quantity</th>
                                <th style="background-color: #c8c9e3; color: #22255a;">Order Date</th>
                                <th style="background-color: #c8c9e3; color: #22255a;">Status</th>
                                <th style="background-color: #c8c9e3; color: #22255a;">Action</th>
                                <?php
                                if($user_id == '2')
                                {
                                    ?>
                                    <th style="background-color: #c8c9e3; color: #22255a;">Print Label</th>
                                    <?php
                                }
                                ?>
                              </tr>
                          </thead>
                          <tbody>
                            <?php
                            if(!empty($order_res))
                            {
                                $i = 1;
                                foreach($order_res as $res)
                                {
                                    $patient_res = $this->common_model->getData('tbl_user', array('user_id'=>$res->patient_id), 'single');
                                    ?>    
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo (!empty($patient_res)) ? $patient_res->user_fname.' '.$patient_res->user_lname : '';?></td>                             
                                        <td><?php echo $res->order_no;?></td>                             
                                        <td><?php echo $res->total_qty;?></td>                             
                                        <td><?php echo $res->order_create_date;?></td>                             
                                        <td><?php echo $res->payment_status;?></td>                             
                                        <td>
                                            <a class="btn btn-success btn-sm" href="<?php echo base_url().MODULE_NAME;?>order/orderDetails/<?php echo $res->order_id.'/'.$res->patient_id; ?>" title="Order Details"><i class="fa fa-eye fa-1x "></i></a>&nbsp;&nbsp;
                                        </td> 
                                        <td>
                                            <?php
                                            if($user_id == '2')
                                            {
                                                ?>
                                                <a class="btn btn-primary btn-sm" href="<?php echo base_url().MODULE_NAME;?>order/printLabel/<?php echo $res->order_id.'/'.$res->patient_id; ?>" title="Label Print"><i class="fa fa-print fa-1x "></i></a>&nbsp;&nbsp;
                                                <?php
                                                $breakfast_order_res = $this->common_model->getData('tbl_breakfast_order',array('order_id'=>$res->order_id, 'patient_id'=>$res->patient_id), 'single');  
                                                if(!empty($breakfast_order_res))
                                                {
                                                    ?>
                                                    <a class="btn btn-success btn-sm" href="<?php echo base_url().MODULE_NAME;?>order/breakFastPrintLabel/<?php echo $res->order_id.'/'.$res->patient_id; ?>" title="BreakFast Label Print"><i class="fa fa-print fa-1x "></i></a>&nbsp;&nbsp;
                                                    <?php
                                                }
                                                ?>
                                                <?php
                                            }
                                            ?>
                                        </td>                             
                                        
                                    </tr>
                                    <?php
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
                      </table>
                    </div> 
                </div>
            </form>
        </div>

        <!-- /.box -->
    </section>
    <!-- /.content -->
</aside>