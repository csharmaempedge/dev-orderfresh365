<aside class="right-side">
    <section class="content-header">
        <h1>Doctor</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url().MODULE_NAME;?>doctor">Doctor</a></li>
            <li class="active">Create Doctor</li>
        </ol>
    </section>
    <section class="content">       
        <div class="box box-success">
            <div class="box-header">
                <div class="pull-left">
                    <h3 class="box-title">Create Doctor</h3>
                </div>
                <div class="pull-right box-tools">
                    <a href="<?php echo base_url().MODULE_NAME;?>doctor" class="btn btn-info btn-sm">Back</a>                           
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info" style="box-shadow: none; background-color: #dfe7f1;">
                        <div class="panel-heading" style="background-color: #bad59c; color: #22255a;">Doctor</div>
                        <div class="panel-body">
                            <form action="" id="login_form" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                <?php  $csrf = array( 'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash() ); ?>
                                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                    <div>
                                        <div id="msg_div">
                                            <?php echo $this->session->flashdata('message');?>
                                        </div>
                                    </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <div class="input text">
                                                <label>First Name<span class="text-danger">*</span></label>
                                                <input required data-validation="custom" data-validation-regexp="^([a-zA-z -]+)$" data-validation-allowing="- _" name="user_fname" id="user_fname" class="form-control" type="text" value="<?php echo set_value('user_fname'); ?>" />
                                                <?php echo form_error('user_fname','<span class="text-danger">','</span>'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="input text">
                                                <label>Last Name<span class="text-danger">*</span></label>
                                                <input required data-validation="custom" data-validation-regexp="^([a-zA-z -]+)$" data-validation-allowing="- _" name="user_lname" id="user_lname" class="form-control" type="text" value="<?php echo set_value('user_lname'); ?>" />
                                                <?php echo form_error('user_lname','<span class="text-danger">','</span>'); ?>
                                            </div>
                                        </div>
                                        <!-- <div class="form-group col-md-4">
                                            <div class="input text">
                                                <label>Role<span class="text-danger">*</span></label>
                                                <select data-validation="required" name="role_id" id="role_id" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                                                    <?php
                                                        $role_list= $this->common_model->getData('tbl_role', array('role_status'=>'1'), 'multi');
                                                        if(!empty($role_list)){
                                                            foreach ($role_list as $val){
                                                                if($val->role_id !='1'){
                                                                ?>
                                                                   <option value="<?php echo $val->role_id; ?>"><?php echo $val->role_name; ?></option>
                                                                <?php 
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                                <?php echo form_error('role_id','<span class="text-danger">','</span>'); ?>
                                            </div>
                                        </div> -->
                                        <div class="form-group col-md-4">
                                            <div class="input text">
                                                <label>Username (Small letters only)<span class="text-danger">*</span></label>
                                                <input required data-validation="custom" data-validation-regexp="^([a-z]+)$" data-validation-allowing="- _" name="user_name" id="user_name" class="form-control" type="text" value="<?php echo set_value('user_name'); ?>" />
                                                <?php echo form_error('user_name','<span class="text-danger">','</span>'); ?>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <div class="input text">
                                                <label>Email<span class="text-danger">*</span></label>
                                                <input onchange="check_user_email_address(this.value)" required="required" data-validation="email" name="user_email" id="user_email" class="form-control" type="email" value="<?php echo set_value('user_email'); ?>" />
                                                <?php echo form_error('user_email','<span class="text-danger">','</span>'); ?>
                                                <span id="error_user_Rmail" style="color:red;"></span>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="input text">
                                                <label>Password<span class="text-danger">*</span></label>
                                                <input required="required" name="user_password" id="user_password" class="form-control" type="password" value="" />
                                                <?php echo form_error('user_password','<span class="text-danger">','</span>'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="input text">
                                                <label>Confirm Password<span class="text-danger">*</span></label>
                                                <input required="required" data-validation="confirmation" data-validation-confirm="user_password" name="user_cpassword" id="user_cpassword" class="form-control" type="password" value="" />
                                                <?php echo form_error('user_cpassword','<span class="text-danger">','</span>'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <div class="input text">
                                                <label>Phone Number<span class="text-danger">*</span></label>
                                                <input onchange="checkMobileNo(this.value)" required="required" data-validation="number length" data-validation-length="10"  data-validation-error-msg="Phone no. has to be 10 chars" name="user_mobile_no" id="user_mobile_no" class="form-control" type="number" min="0" value="<?php echo set_value('user_mobile_no'); ?>" />
                                                <?php echo form_error('user_mobile_no','<span class="text-danger">','</span>'); ?>
                                                <span id="error_user_Rmob" style="color:red;"></span>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="input text">
                                                <label>Date of Birth<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control date_val" name="user_dob" id="user_dob" placeholder="" value="<?php echo set_value('user_dob'); ?>">
                                                <?php echo form_error('user_dob','<span class="text-danger">','</span>'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="input text">
                                                <label>Status<span class="text-danger">*</span></label>
                                                <select data-validation="required" name="user_status" id="user_status" class="form-control">
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>
                                        </div>  
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <div class="input text">
                                                <label>Country<span class="text-danger">*</span></label>
                                                <select data-validation="required" name="country_id" id="country_id" class="form-control" onchange="getStateListByCountryID(this.value)">
                                                    <option value="">-- Select --</option>
                                                    <?php
                                                        $country_res = $this->common_model->getData('tbl_country', array('country_status'=>'1', 'country_id'=>223), 'multi');
                                                        if(!empty($country_res)){
                                                            foreach($country_res as $c_val){
                                                                ?>
                                                                <option value="<?php echo $c_val->country_id; ?>"><?php echo $c_val->country_name; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="input text">
                                                <label>State<span class="text-danger">*</span></label>
                                                <select data-validation="required" name="state_id" class="form-control" id="state_id" ?>
                                                    <option value="">-- Select --</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="input text">
                                                <label>Postal Code<span class="text-danger">*</span></label>
                                                <input required data-validation="custom" data-validation-regexp="^([0-9]+)$" min="0" name="user_postal_code" id="user_postal_code" class="form-control" type="text" value="<?php echo set_value('user_postal_code'); ?>" />
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <div class="input text">
                                                <label>City<span class="text-danger">*</span></label>
                                                <input required data-validation="custom" data-validation-regexp="^([a-zA-z -]+)$" data-validation-allowing="- _" name="user_city" id="user_city" class="form-control" type="text" value="<?php echo set_value('user_city'); ?>" />
                                            </div>
                                        </div> 
                                        <div class="form-group col-md-8">
                                            <div class="input text">
                                                <label>Address<span class="text-danger">*</span></label>
                                                <textarea data-validation="required" name="user_address" id="user_address" class="form-control"><?php echo set_value('user_address'); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <div class="input text">
                                                <label>Profile Image</label>
                                                <input data-validation="mime size" data-validation-allowing="jpg, png, gif, jpeg, jpe" data-validation-max-size="3M" name="user_profile_img" type="file" id="user_profile_img" value="" />
                                                <small>Max upload size is 3MB</small>
                                            </div>
                                            <span class="text-danger" id="error_id"></span>
                                        </div>  
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <button class="btn btn-success btn-sm" type="submit" name="Submit" value="Add" >Submit</button>
                                    <a class="btn btn-danger btn-sm" href="<?php echo base_url().MODULE_NAME;?>doctor">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>
<script type="text/javascript">
    function  getStateListByCountryID(country_id){
        var str = 'country_id='+country_id+'&<?php echo $this->security->get_csrf_token_name(); ?>='+'<?php echo $this->security->get_csrf_hash(); ?>';
        var PAGE = '<?php echo base_url().MODULE_NAME; ?>common/getStateListByCountryID';
        jQuery.ajax({
            type :"POST",
            url  :PAGE,
            data : str,
            success:function(data){        
                $('#state_id').html(data);
            } 
        });
    } 

    $("#login_form").submit(function(){
        if(!checkFiletype()){
            return false;
        }
        var user_password = $('[name=user_password]').val();
        if(user_password){
            $('[name=user_password]').val(sha256(user_password));
        }
        var user_cpassword = $('[name=user_cpassword]').val();
        if(user_cpassword){
            $('[name=user_cpassword]').val(sha256(user_cpassword));
        }
    });

    function checkFiletype(){      
        if($('#user_profile_img').val() == ''){
            return true;
        }
        var filename = $('#user_profile_img').val();
        var extension = filename.replace(/^.*\./, '');
        extension = extension.toLowerCase();
        if(extension == 'png' || extension == 'gif' || extension == 'jpe' || extension == 'jpe' || extension == 'jpeg' || extension == 'jpg'){  
            $('#error_id').html("");
            return true;             
        }
        else{
            $('#user_profile_img').val('');
            $('#error_id').html("<p></p>Invalid file type please choose only image file!");
            return false; 
        }
    }
    function check_user_email_address(emailId){

    var action_check_emailId = 'check_email';

    var check_dataString = 'action_check_emailId=' + action_check_emailId + '&user_email=' + emailId;   

    var check_PAGE = '<?php echo base_url();?>user/checkEmailId'; 

        $.ajax({

        type: "POST",

        url: check_PAGE,

        data: check_dataString,

        cache: false,           

        success: function(check_data){

        //alert(check_data); return false;               

           if(check_data == parseInt(1)){



            $('#error_user_Rmail').html('This email id allready ragistered!.');

            $('#submit_btn').hide();

            $("#user_email").focus();

            document.getElementById('user_email').style.border='1px solid red';

            return false;

           }else{  



              $('#error_user_Rmail').html('');

              $('#submit_btn').show();

              document.getElementById('user_email').style.border='1px solid green';

                

           }    

         }

      });



     }

     function checkMobileNo(mobileNo){

        var action_check_mobile = 'check_mobile';

        var check_dataString = 'action_check_mobile=' + action_check_mobile + '&user_mobile_no=' + mobileNo;    

        var check_PAGE = '<?php echo base_url();?>user/checkMobileNo'; 

            $.ajax({

            type: "POST",

            url: check_PAGE,

            data: check_dataString,

            cache: false,           

            success: function(check_data){

            //alert(check_data); return false;               

               if(check_data == parseInt(1)){



                $('#error_user_Rmob').html('This Mobile Number id allready ragistered!.');

                $('#submit_btn').hide();

                $("#user_mobile_no").focus();

                document.getElementById('user_mobile_no').style.border='1px solid red';

                return false;

               }else{  



                  $('#error_user_Rmob').html('');

                  $('#submit_btn').show();

                  document.getElementById('user_mobile_no').style.border='1px solid green';

                    

               }    

             }

          });



     }
</script>