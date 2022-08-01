<aside class="right-side">
    <section class="content-header">
        <h1>Home Page Setting</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo base_url().MODULE_NAME;?>home">Home Page Setting</a></li>
            <li class="active">Home Page Setting Add</li>
        </ol>
    </section>
    <section class="content">       
        <div class="box box-success">
            <div class="box-header">
                <div class="tab-content">
                    <div class="pull-left">
                        <!-- <h3 class="box-title">Create Home Page Setting</h3> -->
                    </div>
                    <form action="" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        <?php  $csrf = array( 'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash() ); ?>
                        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                        <input type="hidden" name="home_page_id" value="<?= (!empty($home_setting)) ? $home_setting->home_page_id : ''; ?>">
                        <div class="pull-right">
                            <button class="btn btn-success btn-sm" type="submit" name="Submit" value="<?= (!empty($home_setting)) ? 'Edit' : 'Add' ?>" >Submit</button>
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
                                        <div class="panel-heading" style="background-color:  <?php echo THEME_COLOR;?>; color: #f9f9ff;">Create Home Page
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="item form-group col-md-6">
                                                    <div class="input text">
                                                        <label> Title <span class="text-danger">*</span></label>
                                                        <input autocomplete="off" name="home_page_title" data-validation="required" class="form-control" type="text" id="home_page_title" placeholder="Enter  Title" value="<?php echo (!empty($home_setting)) ? $home_setting->home_page_title : ''; ?>" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <div class="input text">
                                                        <label> Image<span class="text-danger">*</span></label>
                                                       <input data-validation="mime size" data-validation-allowing="jpg, png, gif, jpeg, jpe" data-validation-max-size="3M" type="file" name="home_page_img">
                                                    </div>
                                                    <small>Max upload size is 3MB</small>
                                                </div>
                                                <?php
                                                if(!empty($home_setting) && file_exists($home_setting->home_page_img))
                                                {
                                                    ?>
                                                        <div class="form-group col-md-3">
                                                            <div class="input text">
                                                               <img src="<?php echo base_url().$home_setting->home_page_img; ?>" width="120">
                                                            </div>
                                                        </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <div class="input text">
                                                        <label> Small Description</label>
                                                        <textarea rows="4" name="home_page_small_description" id="home_page_small_description" class="form-control"><?php echo (!empty($home_setting)) ? $home_setting->home_page_small_description : ''; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <div class="input text">
                                                        <label> Long Description</label>
                                                        <textarea rows="4" name="home_page_long_description" id="home_page_long_description" class="form-control tiny_textarea"><?php echo (!empty($home_setting)) ? $home_setting->home_page_long_description : ''; ?></textarea>
                                                    </div>
                                                </div>
                                            </div> 
                                            <br>
                                            <div class="row">
                                                <div class="form-group col-md-3">
                                                    <div class="input text">
                                                        <label>Center HD Image<span class="text-danger">*</span></label>
                                                       <input data-validation="mime size" data-validation-allowing="jpg, png, gif, jpeg, jpe" data-validation-max-size="3M" type="file" name="janta_party_img">
                                                    </div>
                                                    <small>Max upload size is 3MB</small>
                                                </div>
                                                <?php
                                                if(!empty($home_setting) && file_exists($home_setting->janta_party_img))
                                                {
                                                    ?>
                                                        <div class="form-group col-md-3">
                                                            <div class="input text">
                                                               <img src="<?php echo base_url().$home_setting->janta_party_img; ?>" width="120">
                                                            </div>
                                                        </div>
                                                    <?php
                                                }
                                                ?>
                                                <div class="form-group col-md-3">
                                                    <div class="input text">
                                                        <label> Logo<span class="text-danger">*</span></label>
                                                       <input data-validation="mime size" data-validation-allowing="jpg, png, gif, jpeg, jpe" data-validation-max-size="3M" type="file" name="logo">
                                                    </div>
                                                    <small>Max upload size is 3MB</small>
                                                </div>
                                                <?php
                                                if(!empty($home_setting) && file_exists($home_setting->logo))
                                                {
                                                    ?>
                                                        <div class="form-group col-md-3">
                                                            <div class="input text">
                                                               <img src="<?php echo base_url().$home_setting->logo; ?>" width="120">
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
                        </div>
                        <div class="box-footer">
                            <button class="btn btn-success btn-sm" type="submit" name="Submit" value="<?= (!empty($home_setting)) ? 'Edit' : 'Add' ?>" >Submit</button>
                            <a class="btn btn-danger btn-sm" href="<?php echo base_url().MODULE_NAME;?>home">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
    </section>
</aside>
