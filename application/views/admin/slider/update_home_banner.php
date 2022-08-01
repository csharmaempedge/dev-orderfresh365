<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>	
			Home Slider<small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url().MODULE_NAME;?>discount">Home Slider</a></li>
            <li class="active">Slider Add</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">       
        <div class="box">
            <div class="box-header">
                <div class="pull-left">
                    <h3 class="box-title">Slider Add</h3>
                </div>
                <div class="pull-right box-tools">
                    <a href="<?php echo base_url().MODULE_NAME;?>slider" class="btn btn-info btn-sm">Back</a>                           
                </div>
            </div>
            <form action="" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                <?php  $csrf = array( 'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash() ); ?>
                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                <!-- /.box-header -->
                <div class="box-body">
                    <div>
                        <div id="msg_div">
                            <?php echo $this->session->flashdata('message');?>
                        </div>
                    </div>   
                        <div class="row">
                            <div class="form-group col-md-6">
                                <div class="input text">
                                    <label>Slider Heading<span class="text-danger">*</span></label>
                                    <input data-validation="required" name="home_banner_heading" class="form-control" type="text" id="home_banner_heading" value="<?php echo $edit_banner->home_banner_heading;?>" />
                                    <?php echo form_error('home_banner_heading','<span class="text-danger">','</span>'); ?>
                                </div>
                            </div>                        
                            <div class="form-group col-md-6">
                                <div class="input text">
                                    <label>Status</label>
                                    <select name="home_banner_status" id="home_banner_status" class="form-control">
                                        <option <?php if($edit_banner->home_banner_status == '1'){ echo "selected"; } ?> value="1">Active</option>
                                        <option <?php if($edit_banner->home_banner_status == '0'){ echo "selected"; } ?> value="0">Deactive</option>
                                    </select>
                                    <?php echo form_error('home_banner_status','<span class="text-danger">','</span>'); ?>
                                </div>
                            </div>         
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <div class="input text">
                                    <label>Slider Image<span class="text-danger">*</span></label>
                                   <input onchange="Upload(this);" data-validation="mime size" data-validation-allowing="jpg, png, gif, jpeg, jpe" data-validation-max-size="3M" type="file" name="home_banner_img_name" id="home_banner_img_name">
                                   <small>Max upload size is 3MB (Width 1728 * Height 766)</small>
                                </div>
                            </div>                      
                           <div class="form-group col-md-3">
                                <div class="input text">
                                   <img src="<?php echo base_url().$edit_banner->home_banner_img_name; ?>" width="120">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="input text">
                                    <label>Slider Description</label>
                                    <textarea rows="4" name="banner_description" id="banner_description" class="form-control"><?php echo $edit_banner->banner_description;?></textarea>
                                </div>
                            </div>                  
                        </div>                 
                </div>
                <!-- /.box-body -->      
                <div class="box-footer">
                    <button class="btn btn-success btn-sm" type="submit" name="Submit" value="Edit" >Submit</button>
                    <a class="btn btn-danger btn-sm" href="<?php echo base_url() ;?>admin/slider">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</aside>
<!-- /.right-side -->
<script type="text/javascript">
        function Upload() {
       //alert(img_no);
        var slider_height = '<?php echo slider_height; ?>';
        var slider_width = '<?php echo slider_width; ?>';
        //Get reference of FileUpload.
        var fileUpload = document.getElementById("home_banner_img_name");
        var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.png|.gif)$");
        if (regex.test(fileUpload.value.toLowerCase())) {
            //Check whether HTML5 is supported.
            if (typeof (fileUpload.files) != "undefined") {
                var reader = new FileReader();
                reader.readAsDataURL(fileUpload.files[0]);
                reader.onload = function (e) {
                    var image = new Image();
                    image.src = e.target.result;
                    image.onload = function () {
                        var height = this.height;
                        var width = this.width;
                        if (height == slider_height && width == slider_width) {
                          
                          alert('Uploaded image has valid Height and Width.!');
                          return true;
                        }
                        else
                        {
                          $('#img_show').attr('src', '');
                          alert('Height and Width must not exceed.');
                          $('#home_banner_img_name').val('');
                          return false; 
                        }
                        
                    };
     
                }
            } else {
                $('#home_banner_img_name').val('');
                alert('This browser does not support HTML5.');
                return false;
            }
        } else {
            $('#home_banner_img_name').val('');
            alert('Please select a valid Image file.');
            return false;
        }
        }

        $.validate({
            modules : 'date, security, file',
            onModulesLoaded : function() {}
        });
</script>
