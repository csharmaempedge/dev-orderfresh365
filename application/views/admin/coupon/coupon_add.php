<aside class="right-side">

    <!-- Content Header (Page header) -->

    <section class="content-header">

        <h1>Coupon Code</h1>

        <ol class="breadcrumb">

            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>

            <li><a href="<?php echo base_url().MODULE_NAME;?>coupon">Coupon Code</a></li>

            <li class="active">Create Coupon Code</li>

        </ol>

    </section>

   <!-- Main content -->

    <section class="content">       

        <div class="box box-success">

            <div class="box-header">

                <div class="pull-left">

                    <h3 class="box-title">Create Coupon Code</h3>

                </div>

                <div class="pull-right box-tools">

                    <a href="<?php echo base_url().MODULE_NAME;?>coupon" class="btn btn-info btn-sm">Back</a>

                </div>

            </div>

            <div class="row">

                <div class="col-md-12">

                    <div class="panel panel-info" style="box-shadow: none; background-color: #dfe7f1;">

                        <div class="panel-heading" style="background-color: #bad59c; color: #22255a;">Coupon Code</div>

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

                                        <div class="item form-group col-md-6">

                                            <div class="input text">

                                               <label>Coupon Code Name<span class="text-danger">*</span></label>

                                                <input name="coupon_code_name" required="required" class="form-control" type="text" id="coupon_code_name" placeholder="Enter Coupon Code name" value="<?php echo set_value('coupon_code_name'); ?>" />

                                            </div>

                                        </div>

                                        <div class="item form-group col-md-6">

                                            <div class="input text">

                                               <label>Coupon Code<span class="text-danger">*</span></label>

                                                <input readonly name="coupon_code" required="required" class="form-control" type="text" id="coupon_code" placeholder="Enter Coupon Code name" value="<?php echo $RandomString; ?>" />

                                            </div>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="form-group col-md-6">

                                            <div class="input text">

                                                <label>Coupon Code Type<span class="text-danger">*</span></label>

                                                <select name="coupon_code_type" id="coupon_code_type" class="form-control">    

                                                    <option value="">--select--</option>

                                                    <option value="Fix">Fix</option>

                                                    <option value="Percentage">Percentage</option>
                                                    <option value="special_coupon_code">Special Coupon Code (Fixed Amount)</option>

                                                </select>

                                            </div>

                                        </div>

                                        <div class="form-group col-md-6">

                                            <label>Coupon Code Amount<span class="text-danger">*</span></label>

                                            <div class='input-group'>

                                                <span class="input-group-addon">

                                                    $

                                                </span>

                                                <input required data-validation="custom" data-validation-regexp="^([0-9]+)$" autocomplete="off" type="text" min="0" name="coupon_code_amount" class="form-control" value="<?php echo set_value('coupon_code_amount'); ?>">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="form-group col-md-6">

                                            <label>Coupon Code Expiry Date<span class="text-danger">*</span></label>

                                               <input autocomplete="off" data-validation="date" type="text" name="coupon_code_expiry_date" id="coupon_code_expiry_date" class="form-control current_date_val" value="<?php echo set_value('coupon_code_expiry_date'); ?>">


                                        </div>

                                        <div class="form-group col-md-6">

                                            <div class="input text">

                                                <label>Status<span class="text-danger">*</span></label>

                                                <select name="coupon_code_status" id="coupon_code_status" class="form-control">    

                                                    <option value="1">Active</option>

                                                    <option value="0">InActive</option>

                                                </select> 

                                            </div>

                                        </div> 

                                    </div>

                                </div>

                                <!-- /.box-body -->      

                                <div class="box-footer">

                                   <button class="btn btn-success btn-sm" type="submit" name="Submit" value="Add" >Save</button>

                                    <a class="btn btn-danger btn-sm" href="<?php echo base_url().MODULE_NAME;?>coupon">Cancel</a>

                                </div>

                            </form>

                           

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

