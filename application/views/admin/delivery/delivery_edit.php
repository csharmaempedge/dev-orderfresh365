<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Delivery Person</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url().MODULE_NAME;?>coupon">Delivery Person</a></li>
            <li class="active">Update Delivery Person</li>
        </ol>
    </section>
   <!-- Main content -->
    <section class="content">       
        <div class="box box-success">
            <div class="box-header">
                <div class="pull-left">
                    <h3 class="box-title">Update Delivery Person</h3>
                </div>
                <div class="pull-right box-tools">
                    <a href="<?php echo base_url().MODULE_NAME;?>delivery" class="btn btn-info btn-sm">Back</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info" style="box-shadow: none; background-color: #dfe7f1;">
                        <div class="panel-heading" style="background-color: #bad59c; color: #22255a;">Delivery Person</div>
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
                                               <label>Delivery Person Name<span class="text-danger">*</span></label>
                                                <input name="delivery_person_name" required="required" class="form-control" type="text" id="delivery_person_name" placeholder="Enter Delivery Person name" value="<?php echo $delivery_person_edit->delivery_person_name; ?>" />
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <div class="input text">
                                                <label>Status<span class="text-danger">*</span></label>
                                                <select name="delivery_person_status" id="delivery_person_status" class="form-control">    
                                                    <option <?php if($delivery_person_edit->delivery_person_status == 1){echo "selected"; } ?> value="1">Active</option>
                                                    <option <?php if($delivery_person_edit->delivery_person_status == 0){echo "selected"; } ?> value="0">InActive</option>
                                                </select> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <div class="input text">
                                                <label>Address</label>
                                                <textarea  name="delivery_person_address" id="delivery_person_address" class="form-control"><?php echo $delivery_person_edit->delivery_person_address; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-body -->      
                                <div class="box-footer">
                                   <button class="btn btn-success btn-sm" type="submit" name="Submit" value="Edit" >Update</button>
                                    <a class="btn btn-danger btn-sm" href="<?php echo base_url().MODULE_NAME;?>delivery">Cancel</a>
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
