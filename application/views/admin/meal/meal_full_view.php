<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> Standard Meal</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url().MODULE_NAME;?>meal"> Standard Meal</a></li>
            <li class="active">View  Standard Meal</li>
        </ol>
    </section>
   <!-- Main content -->
    <section class="content">       
        <div class="box box-success">
            <div class="box-header">
                <div class="pull-left">
                    <h3 class="box-title">View  Standard Meal</h3>
                </div>
                <div class="pull-right box-tools">
                    <a href="<?php echo base_url().MODULE_NAME;?>meal" class="btn btn-info btn-sm">Back</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info" style="box-shadow: none; background-color: #dfe7f1;">
                        <div class="panel-heading" style="background-color: #bad59c; color: #22255a;"> Standard Meal</div>
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
                                               <label>Protien Serving</label>
                                                <input disabled class="form-control" type="text" placeholder="Enter Protien Serving" value="<?php echo $meal_edit->protien_serving; ?>" />
                                            </div>
                                        </div>
                                        <div class="item form-group col-md-6">
                                            <div class="input text">
                                               <label>Carb Serving</label>
                                                <input disabled class="form-control" type="text" placeholder="Enter Carb Serving" value="<?php echo $meal_edit->carb_serving; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="item form-group col-md-6">
                                            <div class="input text">
                                               <label>Veg Serving</label>
                                                <input disabled class="form-control" type="text" placeholder="Enter Veg Serving" value="<?php echo $meal_edit->veg_serving; ?>" />
                                            </div>
                                        </div>
                                        <div class="item form-group col-md-6">
                                            <div class="input text">
                                                <label>Price </label>
                                                <input disabled class="form-control" type="text" placeholder="Enter Price" value="<?php echo $meal_edit->price; ?>" />
                                                <span id="error_amount_msg" class="text-danger"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <div class="input text">
                                                <label>Status</label>
                                                <select disabled name="meal_status" id="meal_status" class="form-control">
                                                   	<option <?php if($meal_edit->meal_status == 1){echo "selected"; } ?> value="1">Active</option>
                									<option <?php if($meal_edit->meal_status == 0){echo "selected"; } ?> value="0">InActive</option>
                                                </select> 
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                                <!-- /.box-body -->      
                                <div class="box-footer">
                                    <a class="btn btn-danger btn-sm" href="<?php echo base_url().MODULE_NAME;?>meal">Cancel</a>
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

