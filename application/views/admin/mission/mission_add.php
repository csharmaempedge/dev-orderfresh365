<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> Mission</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url().MODULE_NAME;?>mission"> Mission</a></li>
            <li class="active">Create  Mission</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">       
        <div class="box box-success">
            <div class="box-header">
                <div class="pull-left">
                    <h3 class="box-title">Create  Mission</h3>
                </div>
                <div class="pull-right box-tools">
                    <a href="<?php echo base_url().MODULE_NAME;?>mission" class="btn btn-info btn-sm">Back</a>                           
                </div>
            </div>
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
                        <div class="item form-group col-md-4">
                            <div class="input text">
                                <label>Mission Title <span class="text-danger">*</span></label>
                                <input autocomplete="off" name="mission_title" data-validation="required" class="form-control" type="text" id="mission_title" placeholder="Enter Mission Title" value="<?php echo set_value('mission_title'); ?>" />
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <div class="input text">
                                <label>Mission Status</label>
                                <select name="mission_status" id="mission_status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Deactive</option>
                                </select>
                                <?php echo form_error('mission_status','<span class="text-danger">','</span>'); ?>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <div class="input text">
                                <label>Mission Cover Image<span class="text-danger">*</span></label>
                               <input data-validation="mime size required" data-validation-allowing="jpg, png, gif, jpeg, jpe" data-validation-max-size="3M" type="file" name="mission_img">
                            </div>
                            <small>Max upload size is 3MB</small>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="form-group col-md-12">
                            <div class="input text">
                                <label>Mission Small Description</label>
                                <textarea autocomplete="off" name="mission_small_description" id="mission_small_description" placeholder="Enter Mission Small Description" class="form-control"><?php echo set_value('mission_small_description'); ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <div class="input text">
                                <label>Mission Long Description</label>
                                <textarea autocomplete="off" name="mission_long_description" id="mission_long_description" placeholder="Enter Mission Long Description" class="form-control tiny_textarea"><?php echo set_value('mission_long_description'); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->      
                <div class="box-footer">
                    <button class="btn btn-success btn-sm" type="submit" name="Submit" value="Add" >Save</button>
                    <a class="btn btn-danger btn-sm" href="<?php echo base_url().MODULE_NAME;?>mission">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</aside>
