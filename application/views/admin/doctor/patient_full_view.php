<aside class="right-side">
    <section class="content-header">
        <h1>Patient</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url().MODULE_NAME;?>doctor/docpatientView/<?php echo $doctor_id; ?>">Patient</a></li>
            <li class="active">View Patient</li>
        </ol>
    </section>
    <section class="content">       
        <div class="box box-success">
            <div class="box-header">
                <div class="pull-left">
                    <h3 class="box-title">View Patient</h3>
                </div>
                <div class="pull-right box-tools">
                    <a href="<?php echo base_url().MODULE_NAME;?>doctor/docpatientView/<?php echo $doctor_id; ?>" class="btn btn-info btn-sm">Back</a>                           
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info" style="box-shadow: none; background-color: #dfe7f1;">
                        <div class="panel-heading" style="background-color: #bad59c; color: #22255a;">Patient    
                            <?php
                              $patient_macro_res = $this->common_model->getData('tbl_patient_macro', array('patient_id'=>$patient_id), 'multi');
                              if(!empty($patient_macro_res))
                              {
                                $macro = array();
                                foreach ($patient_macro_res as $p_res) 
                                {
                                    $macro_res = $this->common_model->getData('tbl_macro', array('macro_id'=>$p_res->macro_id), 'single');
                                     $macro[] = $macro_res->macro_name.' '.$p_res->macro_value_id;
                                    $set_macro =  implode(',', $macro);
                                }
                              }
                              ?>
                              <input disabled style="color: #4f28e8f2;" type="" name="" value="<?php echo (!empty($set_macro)) ? $set_macro : ''; ?>" >
                        </div>
                        <div class="panel-body">
                        <?php
                            foreach ($edit_user as $value){
                            ?>
                                <form action="" method="post" accept-charset="utf-8" enctype="multipart/form-data" id="login_form">
                                    <?php  $csrf = array( 'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash() ); ?>
                                    <input type="hidden" disabled name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                    <div class="box-body">
                                        <div>
                                            <div id="msg_div">
                                                <?php echo $this->session->flashdata('message');?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <div class="input text">
                                                    <label>First Name</label>
                                                    <input disabled name="user_fname" id="user_fname" class="form-control" type="text" value="<?php echo $value->user_fname; ?>" />
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <div class="input text">
                                                    <label>Last Name</label>
                                                    <input disabled name="user_lname" id="user_lname" class="form-control" type="text" value="<?php echo $value->user_lname; ?>" />
                                                </div>
                                            </div>
                                            <!-- <div class="form-group col-md-4">
                                                <div class="input text">
                                                    <label>Role</label>
                                                    <select disabled data-validation="required" name="role_id" id="role_id" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                                                        <?php
                                                            $role_id_arr = explode(',', $value->role_id);
                                                            $role_list= $this->common_model->getData('tbl_role', array('role_status'=>'1'), 'multi'); 
                                                            foreach ($role_list as $val){
                                                                if($val->role_id !='1'){
                                                                    ?>
                                                                    <option <?php if(in_array($val->role_id, $role_id_arr)){ echo "selected"; } ?> value="<?php echo $val->role_id; ?>"><?php echo $val->role_name; ?></option>
                                                                    <?php       
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div> -->
                                            <div class="form-group col-md-4">
                                                <div class="input text">
                                                    <label>Username</label>
                                                    <input disabled name="user_name" id="user_name" class="form-control" type="text" value="<?php echo $value->user_name; ?>" />
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <div class="input text">
                                                    <label>Email</label>
                                                    <input disabled name="user_email" id="user_email" class="form-control" type="email" value="<?php echo $value->user_email; ?>" />
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <div class="input text">
                                                    <label>Phone Number</label>
                                                    <input disabled name="user_mobile_no" id="user_mobile_no" class="form-control" type="number" min="0" value="<?php echo $value->user_mobile_no; ?>" />
                                                </div>
                                            </div> 
                                            <div class="form-group col-md-4">
                                                <div class="input text">
                                                    <label>Date of Birth</label>
                                                    <input type="text" class="form-control" disabled name="user_dob" id="user_dob" placeholder="" value="<?php echo $value->user_dob; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <!-- <div class="form-group col-md-4">
                                                <div class="input text">
                                                    <label>Country</label>
                                                    <select disabled name="country_id" id="country_id" class="form-control" onchange="getStateListByCountryID(this.value)">
                                                        <option value="">-- Select --</option>
                                                        <?php
                                                        if(!empty($country_list)){
                                                            foreach($country_list as $c_list){
                                                                ?>
                                                                <option <?php if($value->country_id == $c_list->country_id){ echo "selected"; } ?> value="<?php echo $c_list->country_id; ?>"><?php echo $c_list->country_name; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div> -->
                                            <div class="form-group col-md-4">
                                                <div class="input text">
                                                    <label>State</label>
                                                    <select  disabled name="state_id" class="form-control" id="state_id" ?>
                                                        <option value="">-- Select --</option>
                                                        <?php
                                                            $state_res= $this->common_model->getData('tbl_state', array('country_id'=>$value->country_id), 'multi');
                                                            if(!empty($state_res)){
                                                                foreach ($state_res as $s_val){
                                                                    ?>
                                                                    <option <?php if($value->state_id == $s_val->state_id){ echo "selected"; } ?> value="<?php echo $s_val->state_id; ?>"><?php echo $s_val->state_name; ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <div class="input text">
                                                    <label>Postal Code</label>
                                                    <input disabled name="user_postal_code" id="user_postal_code" class="form-control" type="text" value="<?php echo $value->user_postal_code; ?>" />
                                                </div>
                                            </div> 
                                            <div class="form-group col-md-4">
                                                <div class="input text">
                                                    <label>City</label>
                                                    <input disabled name="user_city" id="user_city" class="form-control" type="text" value="<?php echo $value->user_city; ?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-8">
                                                <div class="input text">
                                                    <label>Address</label>
                                                    <textarea disabled name="user_address" id="user_address" class="form-control"><?php echo $value->user_address; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <div class="input text">
                                                    <label>Status</label>
                                                    <select disabled name="user_status" id="user_status" class="form-control">
                                                        <option <?php if($value->user_status == '1'){ echo "selected"; } ?> value="1">Active</option>
                                                        <option <?php if($value->user_status == '0'){ echo "selected"; } ?> value="0">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row"> 
                                            <div class="form-group col-md-4">
                                                <div class="input text">
                                                    <label>Email Reminder</label>
                                                    <br>
                                                    <label><input <?php if($value->email_reminder == 'ON'){ echo "checked"; } ?> disabled type="radio"  value="ON" /> <b>ON</b></label>&nbsp;&nbsp;&nbsp;&nbsp;  
                                                    <label><input <?php if($value->email_reminder == 'OFF'){ echo "checked"; } ?> disabled type="radio" value="OFF" /> <b>OFF</b></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <div class="input text">
                                                    <label>Sms Reminder</label>
                                                    <br>
                                                    <label><input <?php if($value->text_reminder == 'ON'){ echo "checked"; } ?> disabled type="radio"  value="ON" /> <b>ON</b></label>&nbsp;&nbsp;&nbsp;&nbsp;  
                                                    <label><input <?php if($value->text_reminder == 'OFF'){ echo "checked"; } ?> disabled type="radio" value="OFF" /> <b>OFF</b></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <div class="input text">
                                                    <label>Profile Image</label>
                                                    <?php
                                                        if(!empty($value->user_profile_img)){
                                                            ?>
                                                            <img width="100px" src="<?php echo base_url().''.$value->user_profile_img; ?>">
                                                            <?php
                                                        }
                                                        else{
                                                            ?>
                                                            <img width="100px" src="<?php echo base_url().'webroot/upload/admin/users/user.png'; ?>">
                                                            <?php
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>      
                                    <div class="box-footer">
                                        <a class="btn btn-danger btn-sm" href="<?php echo base_url().MODULE_NAME;?>doctor/docpatientView/<?php echo $doctor_id; ?>">Cancel</a>
                                    </div>
                                </form>                    
                            <?php
                        }
                        ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>