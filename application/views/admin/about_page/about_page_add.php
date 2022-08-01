<aside class="right-side">
    <section class="content-header">
        <h1>About Page Setting</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i>About</a></li>
            <li><a href="<?php echo base_url().MODULE_NAME;?>about">About Page Setting</a></li>
            <li class="active">About Page Setting Add</li>
        </ol>
    </section>
    <section class="content">       
        <div class="box box-success">
            <div class="box-header">
                <div class="tab-content">
                    <div class="pull-left">
                        <!-- <h3 class="box-title">Create Global Setting</h3> -->
                    </div>
                    <form action="" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        <?php  $csrf = array( 'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash() ); ?>
                        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                        <input type="hidden" name="about_id" value="<?= (!empty($about_setting)) ? $about_setting->about_id : ''; ?>">
                        <div class="pull-right">
                            <button class="btn btn-success btn-sm" type="submit" name="Submit" value="<?= (!empty($about_setting)) ? 'Edit' : 'Add' ?>" >Submit</button>
                        </div>
                        <div class="box-body">
                            <div>
                                <div id="msg_div">
                                    <?php echo $this->session->flashdata('message');?>
                                </div>
                            </div> <br><br>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-info" style="box-shadow: none; background-color: #dfe7f1;">
                                        <div class="panel-heading" style="background-color:  <?php echo THEME_COLOR;?>; color: #f9f9ff;">Create About Page
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="item form-group col-md-6">
                                                    <div class="input text">
                                                        <label>First Box Title <span class="text-danger">*</span></label>
                                                        <input autocomplete="off" name="about_fbox_title" data-validation="required" class="form-control" type="text" id="about_fbox_title" placeholder="Enter First Box Title" value="<?php echo (!empty($about_setting)) ? $about_setting->about_fbox_title : ''; ?>" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <div class="input text">
                                                        <label>First Box Description</label>
                                                        <textarea rows="4" name="about_fbox_description" id="about_fbox_description" class="form-control"><?php echo (!empty($about_setting)) ? $about_setting->about_fbox_description : ''; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="item form-group col-md-6">
                                                    <div class="input text">
                                                        <label>Secound Box Title <span class="text-danger">*</span></label>
                                                        <input autocomplete="off" name="about_sbox_title" data-validation="required" class="form-control" type="text" id="about_sbox_title" placeholder="Enter Secound Box Title" value="<?php echo (!empty($about_setting)) ? $about_setting->about_sbox_title : ''; ?>" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <div class="input text">
                                                        <label>Secound Box Description</label>
                                                        <textarea rows="4" name="about_sbox_description" id="about_sbox_description" class="form-control"><?php echo (!empty($about_setting)) ? $about_setting->about_sbox_description : ''; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="item form-group col-md-6">
                                                    <div class="input text">
                                                        <label>Thired Box Title <span class="text-danger">*</span></label>
                                                        <input autocomplete="off" name="about_tbox_title" data-validation="required" class="form-control" type="text" id="about_tbox_title" placeholder="Enter Thired Box Title" value="<?php echo (!empty($about_setting)) ? $about_setting->about_tbox_title : ''; ?>" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <div class="input text">
                                                        <label>Thired Box Description</label>
                                                        <textarea rows="4" name="about_tbox_description" id="about_tbox_description" class="form-control"><?php echo (!empty($about_setting)) ? $about_setting->about_tbox_description : ''; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-3">
                                                    <div class="input text">
                                                        <label>About Page Image<span class="text-danger">*</span></label>
                                                       <input data-validation="mime size" data-validation-allowing="jpg, png, gif, jpeg, jpe" data-validation-max-size="3M" type="file" name="about_img">
                                                    </div>
                                                    <small>Max upload size is 3MB</small>
                                                </div>
                                                <?php
                                                if(!empty($about_setting) && file_exists($about_setting->about_img))
                                                {
                                                    ?>
                                                        <div class="form-group col-md-3">
                                                            <div class="input text">
                                                               <img src="<?php echo base_url().$about_setting->about_img; ?>" width="120">
                                                            </div>
                                                        </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <div class="input text">
                                                        <label>About Page Long Description</label>
                                                        <textarea rows="4" name="about_long_description" id="about_long_description" class="form-control tiny_textarea"><?php echo (!empty($about_setting)) ? $about_setting->about_long_description : ''; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button class="btn btn-success btn-sm" type="submit" name="Submit" value="<?= (!empty($about_setting)) ? 'Edit' : 'Add' ?>" >Submit</button>
                            <a class="btn btn-danger btn-sm" href="<?php echo base_url().MODULE_NAME;?>home">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
    </section>
</aside>
