<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> Category</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url().MODULE_NAME;?>category"> Category</a></li>
            <li class="active">View  Category</li>
        </ol>
    </section>
   <!-- Main content -->
    <section class="content">       
        <div class="box box-success">
            <div class="box-header">
                <div class="pull-left">
                    <h3 class="box-title">View  Category</h3>
                </div>
                <div class="pull-right box-tools">
                    <a href="<?php echo base_url().MODULE_NAME;?>category" class="btn btn-info btn-sm">Back</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info" style="box-shadow: none; background-color: #dfe7f1;">
                        <div class="panel-heading" style="background-color: #bad59c; color: #22255a;"> Category</div>
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
                                               <label>Category Name</label>
                                                <input disabled class="form-control" type="text" id="category_name" placeholder="Enter Category name" value="<?php echo $category_edit->category_name; ?>" />
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <div class="input text">
                                                <label>Status</label>
                                                <select disabled name="category_status" id="category_status" class="form-control">
                                                   	<option <?php if($category_edit->category_status == 1){echo "selected"; } ?> value="1">Active</option>
                									<option <?php if($category_edit->category_status == 0){echo "selected"; } ?> value="0">InActive</option>
                                                </select> 
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                                <!-- /.box-body -->      
                                <div class="box-footer">
                                    <a class="btn btn-danger btn-sm" href="<?php echo base_url().MODULE_NAME;?>category">Cancel</a>
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

