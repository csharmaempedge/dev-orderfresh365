<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> Vision View</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url().MODULE_NAME;?>vision"> Vision</a></li>
            <li class="active">View  Vision</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">       
        <div class="box box-success">
            <div class="box-header">
                <div class="pull-left">
                    <h3 class="box-title">View  Vision</h3>
                </div>
                <div class="pull-right box-tools">
                    <a href="<?php echo base_url().MODULE_NAME;?>vision" class="btn btn-info btn-sm">Back</a>                           
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
                                <label>Vision Title </label>
                                <input disabled class="form-control" type="text" placeholder="Enter Vision Title" value="<?php echo !empty($vision_res->vision_title) ? $vision_res->vision_title : ''; ?>" />
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <div class="input text">
                                <label>Vision Status</label>
                                <select disabled class="form-control">
                                    <option <?php if($vision_res->vision_status == '1'){ echo "selected"; } ?> value="1">Active</option>
                                    <option <?php if($vision_res->vision_status == '0'){ echo "selected"; } ?> value="0">Deactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                          <label>Vision Cover Image</label>
                            <div class="input text">
                               <img src="<?php echo base_url().$vision_res->vision_img; ?>" width="120">
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="form-group col-md-12">
                            <div class="input text">
                                <label>Vision Small Description</label>
                                <textarea disabled placeholder="Enter Vision Small Description" class="form-control"><?php echo !empty($vision_res->vision_small_description) ? $vision_res->vision_small_description : ''; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <div class="input text">
                                <label>Vision Long Description</label>
                                <span class="textarea_view">
                                  <?php echo !empty($vision_res->vision_long_description) ? $vision_res->vision_long_description : ''; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->      
                    <div class="box-footer">
                        <a class="btn btn-danger btn-sm" href="<?php echo base_url().MODULE_NAME;?>vision">Cancel</a>
                    </div>
                </div>
                </form>
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</aside>
