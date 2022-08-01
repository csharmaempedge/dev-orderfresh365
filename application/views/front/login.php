<script src="<?php echo base_url(); ?>webroot/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<section class="breadcrumbs overlay" style="background-image: url(<?php echo base_url();?>webroot/front/assets/images/breadcrumb.jpg);">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<!-- Bread Menu -->
						<div class="bread-menu">
							<ul>
								<li><a href="<?php echo base_url(); ?>">Home</a></li>
								<li><a href="<?php echo base_url(); ?>singIn">Member Ship</a></li>
							</ul>
						</div>
						<!-- Bread Title -->
						<div class="bread-title"><h2 class="csi-heading text-success" style="font-family: 'Playfair Display', serif; line-height: 2.8rem; color: #3c763d;">My&nbsp;<span style="box-sizing: border-box; color: #f48123;">Member Ship Login</span></h2></div>
					</div>
				</div>
			</div>
		</div>
	</section>
<section class="section-bg sec-profile sec-gap">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class=" my-5">
					<div class="section-title default text-center">
				</div>
				</div>
			</div>
			<form action="" class="form d-content" method="post" accept-charset="utf-8" enctype="multipart/form-data">
				<?php  $csrf = array( 'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash() ); ?>
            	<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
				<div class="col-lg-12 col-md-12 col-12">
					<div>
				        <div id="msg_div_new">
				            <?php echo $this->session->flashdata('message_new');?>
				        </div>
				     </div>
					<div class="profile-right bg-white p-3">
						
						<div class="section">
							<h4 class="title"><h2 class="csi-heading text-success" style="font-family: 'Playfair Display', serif; line-height: 2.8rem; color: #3c763d;">Lo<span style="box-sizing: border-box; color: #f48123;">gin</span></h2></h4>
							<div class="forms-elements">
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
											<label> Mobile No.<span class="text-danger">*</span></label>
											<input autocomplete="off" type="text"  name="member_mobile_no" class="form-control" placeholder="Enter Mobile No." value="<?php echo set_value('member_mobile_no'); ?>">
											<?php echo form_error('member_mobile_no','<span class="text-danger">','</span>'); ?>
										</div>
									</div>
									<div class="col-lg-12">
										<div class="form-group">
											<label>Password</label>
											<input type="password" name="member_password" class="form-control" placeholder="Enter Password" value="<?php echo set_value('member_password'); ?>">
											<?php echo form_error('member_password','<span class="text-danger">','</span>'); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="bg-white p-2 text-center">
						<button  type="submit" name="Submit" value="Add" class="ss-btn theme-2">Login</button>

						<div class="text-center mt-5">
							<h6>Don't have an account? <a href="<?php echo base_url(); ?>membership">Signup Now</a></h6>
						</div>
					</div>
				</div>
			</form>
			
		</div>
	</div>
</section>
<div id="uploadimageModal" class="modal" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content" style="width: 120%;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="text-align: center;">Upload & Crop Image</h4>
        </div>
        <div class="modal-body">
          <div class="row">
       <div class="col-md-8 text-center">
        <div id="image_demo" style="width:350px; margin-top:30px"></div>
       </div>
       <div class="col-md-4" style="padding-top:30px;">
        <br />
        <br />
        <br/>
        <button class="btn btn-success crop_image" style="margin: -57px">Crop & Upload Image</button>
     </div>
    </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
     </div>
    </div>
</div>
    <script type="text/javascript">
        $("#msg_div_new").fadeOut(10000);
        function Upload() {
	   //alert(img_no);
	    var membership_height = '<?php echo membership_height; ?>';
	    var membership_width = '<?php echo membership_width; ?>';
	    //Get reference of FileUpload.
	    var fileUpload = document.getElementById("member_profile_img");
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
	                    if (height == membership_height && width == membership_width) {
	                      $('#img_show')
	                      .attr('src', e.target.result);
	                      alert('Uploaded image has valid Height and Width.!');
	                      return true;
	                    }
	                    else
	                    {
	                      $('#img_show').attr('src', '');
	                      alert('Height and Width must not exceed.');
	                      $('#member_profile_img').val('');
	                      return false; 
	                    }
	                    
	                };
	 
	            }
	        } else {
	            $('#img_show').attr('src', '');
	            $('#member_profile_img').val('');
	            alert('This browser does not support HTML5.');
	            return false;
	        }
	    } else {
	        $('#img_show').attr('src', '');
	        $('#member_profile_img').val('');
	        alert('Please select a valid Image file.');
	        return false;
	    }
	    }

	    $.validate({
	        modules : 'date, security, file',
	        onModulesLoaded : function() {}
	    });
    </script>