<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Print Bags Label</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url().MODULE_NAME;?>order">Print Bags Label</a></li>
            <li class="active">Create Print Bags Label</li>
        </ol>
    </section>
   <!-- Main content -->
    <section class="content">       
        <div class="box box-success">
            <div class="box-header">
                <div class="pull-left">
                    <h3 class="box-title">Print Bags Label</h3>
                </div>
                <div class="pull-right box-tools">
                    <a href="<?php echo base_url().MODULE_NAME;?>order" class="btn btn-info btn-sm">Back</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info" style="box-shadow: none; background-color: #dfe7f1;">
                        <div class="panel-heading" style="background-color: #bad59c; color: #22255a;">Set Bags</div>
                        <div class="panel-body">
                            <form action="" id="login_form" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                <?php  $csrf = array( 'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash() ); ?>
                                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                <div class="box-body">
                                    <div>
                                        <div id="msg_div">
                                            <?php echo $this->session->flashdata('message');?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="item form-group col-md-12">
                                            <div class="input text">
                                               <label>No. Of Product</label>
                                                <input readonly name="total_qty" class="form-control" type="text" value="<?php echo $toTalQTY; ?>" />
                                                <input name="order_id" class="form-control" type="hidden" value="<?php echo $order_id; ?>" />
                                                <input name="patient_id" class="form-control" type="hidden" value="<?php echo $patient_id; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="item form-group col-md-6">
                                            <div class="input text">
                                               <label>Set Per Bag<span class="text-danger">*</span></label>
                                                <input name="qty" required data-validation="custom" data-validation-regexp="^([0-9]+)$" class="form-control" type="text" id="qty" placeholder="Enter Set Per Bag" value="<?php echo set_value('qty'); ?>" />
                                            </div>
                                        </div>
                                        <button class="btn btn-success btn-sm" type="submit" name="Submit" value="Add" style="margin-top: 29px;margin-left: 15px;">Add</button>
                                    </div>
                                </div>
                            </form>
                            <?php
                            $bags_res = $this->common_model->getData('tbl_print_bags', array('order_id'=>$order_id), 'multi');
                            if(!empty($bags_res))
                            {
                                ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="pull-right box-tools">
                                            <a style="margin-right: 18px;" href="<?php echo base_url().MODULE_NAME;?>order/printBagsLabel/<?php echo $order_id.'/'.$patient_id; ?>" class="btn btn-info btn-sm">Print Label</a>
                                        </div>
                                        <br><br>
                                        <div class="nav-tabs-custom">
                                            <div class="col-md-12">                   
                                                <div class="table-responsive">         
                                                    <table id="example" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr  class="label-primary1" style="color: #fff;">
                                                            <th style="background-color: #c8c9e3; color: #22255a;">Bags.No.</th>
                                                            <th style="background-color: #c8c9e3; color: #22255a;">Qty</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        
                                                            if(!empty($bags_res))
                                                            {
                                                                $i = 1;
                                                                foreach($bags_res as $res)
                                                                {
                                                                    ?>    
                                                                    <tr>
                                                                        <td> Bags - <?php echo $i; ?></td>
                                                                        <td><?php echo $res->qty; ?></td>
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
                                        </div>
                                    </div> 
                                </div>
                                <?php
                            }
                            ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</aside>
<!-- /.right-side -->
