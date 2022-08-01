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

                    <h3 class="box-title"> Patient Details</h3>

                </div>

                <div class="pull-right box-tools">

                    <a href="<?php echo base_url().MODULE_NAME;?>doctor/docpatientView/<?php echo $doctor_id; ?>" class="btn btn-info btn-sm">Back</a>                           

                </div>

            </div>

            <div>

                <div id="msg_div">

                    <?php echo $this->session->flashdata('message');?>

                </div>

            </div>

            <div class="row">

                <div class="item form-group col-md-12">

                    <table class="table">

                      <tbody>

                        <?php 

                        $doctor_res = $this->common_model->getData('tbl_user', array('user_id'=>$edit_user->doctor_id), 'single');

                        ?>

                          <tr>

                              <th style="color: #046c71" width="35%">Patient First Name</th>

                              <td style="color: #046c71"><?php echo !empty($edit_user->user_fname) ? $edit_user->user_fname : ''; ?></td>

                              <th style="color: #046c71" width="35%">Patient Last Name</th>

                              <td style="color: #046c71"><?php echo !empty($edit_user->user_lname) ? $edit_user->user_lname : ''; ?></td>

                          </tr>

                          <tr>

                              <th style="color: #046c71" width="35%">Doctor Name</th>

                              <td style="color: #046c71"><?php echo !empty($doctor_res->user_fname) ? $doctor_res->user_fname.' '.$doctor_res->user_lname : ''; ?></td>

                          </tr>

                      </tbody>

                  </table>

              </div>

            </div>

            <br>

            <div class="row">

                <div class="col-md-12">

                    <div class="panel panel-info" style="box-shadow: none; background-color: #dfe7f1;">

                        <div class="panel-heading" style="background-color: #bad59c; color: #22255a;">Patient Macro</div>

                        <div class="panel-body">

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

                                          <div class="col-md-12">

                                              <div class="table-responsive">

                                                  <table id="load_data" class="table table-bordered table-striped">

                                                      <thead>

                                                          <tr class="label-primary1">

                                                              <th style="background-color: #007775; color: #fff;">S. No.</th>

                                                              <th style="background-color: #007775; color: #fff;">Macro</th>

                                                              <th style="background-color: #007775; color: #fff;">Macro Value</th>

                                                          </tr>

                                                      </thead>

                                                      <tbody>

                                                          <?php

                                                          $macro_res = $this->common_model->getData('tbl_macro', array('macro_status'=>1), 'multi');

                                                          if(!empty($macro_res))

                                                          {

                                                              $i = 1;

                                                              foreach ($macro_res as $res) 

                                                              {

                                                                  $patient_macro_res = $this->common_model->getData('tbl_patient_macro', array('macro_id'=>$res->macro_id, 'patient_id'=>$patient_id), 'single');

                                                                  ?>

                                                                  <tr>

                                                                      <input type="hidden" name="macro_id_<?php echo $res->macro_id; ?>" id="macro_id_<?php echo $res->macro_id; ?>" value="<?php echo $res->macro_id; ?>" >

                                                                      <td width="100px;"><?php echo  $i; ?></td>

                                                                      <td width="200px;"><?php echo $res->macro_name; ?></td>

                                                                      <td width="350px;">

                                                                          <select data-validation="required" name="macro_value_id_<?php echo $res->macro_id; ?>" id="macro_value_id_<?php echo $res->macro_id; ?>" class="form-control">

                                                                              <option value="">-- Select --</option>

                                                                              <?php

                                                                              $macro_value_id_arr = explode(',', $res->macro_value_id);

                                                                                  if(!empty($macro_value_id_arr)){

                                                                                      foreach($macro_value_id_arr as $macro_value_id){

                                                                                          $macro_value_res = $this->common_model->getData('tbl_macro_value', array('macro_value_id'=>$macro_value_id), 'single');

                                                                                          ?>

                                                                                          <option <?php echo (!empty($patient_macro_res) && $patient_macro_res->macro_value_id == $macro_value_res->macro_value_id) ? 'selected' : '' ;?> value="<?php echo $macro_value_res->macro_value_id; ?>"><?php echo $macro_value_res->macro_value_name; ?></option>

                                                                                          <?php

                                                                                      }

                                                                                  }

                                                                              ?>

                                                                          </select>



                                                                      </td>

                                                                  </tr>

                                                                  <?php

                                                                  $i++;

                                                              }



                                                          }



                                                          ?>

                                                      </tbody>

                                                  </table>

                                              </div>

                                          </div>

                                      </div>       

                                    </div>

                                    <?php

                                    $patient_macro_data = $this->common_model->getData('tbl_patient_macro', array('patient_id'=>$patient_id), 'single');

                                    ?> 

                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="form-group col-md-6">

                                            <div class="input text">

                                                <label>From Date<span class="text-danger">*</span></label>
                                                   <input autocomplete="off" data-validation="date" type="text" name="patient_macro_from_date" id="patient_macro_from_date" class="form-control current_date_val" value="<?php echo (!empty($patient_macro_data->patient_macro_from_date)) ? $patient_macro_data->patient_macro_from_date : ''; ?>" onchange="assignEndDate(this.value)">

                                                <?php echo form_error('patient_macro_from_date','<span class="text-danger">','</span>'); ?>

                                            </div>

                                        </div> 

                                        <div class="form-group col-md-6">

                                            <div class="input text">

                                                <label>To Date<span class="text-danger">*</span></label>

                                                  <div id="show_end_date">

                                                  <input autocomplete="off" data-validation="date" type="text" name="patient_macro_to_date" id="patient_macro_to_date" class="form-control" value="<?php echo (!empty($patient_macro_data->patient_macro_to_date)) ? $patient_macro_data->patient_macro_to_date : ''; ?>" >

                                               </div>

                                                <?php echo form_error('patient_macro_to_date','<span class="text-danger">','</span>'); ?>

                                            </div>

                                        </div>

                                        </div>

                                    </div>  

                                    <div class="row">

                                        <div class="form-group col-md-12">

                                            <div class="input text">

                                                <label>Note</label>

                                                <textarea name="note" id="note" class="form-control"><?php echo (!empty($patient_macro_data->note)) ? $patient_macro_data->note : ''; ?></textarea>

                                            </div>

                                        </div>

                                    </div>  

                                    <div class="box-footer">

                                        <button class="btn btn-success btn-sm" type="submit" name="Submit" value="Edit" >Submit</button>

                                        <a class="btn btn-danger btn-sm" href="<?php echo base_url();?>admin/doctor/docpatientView/<?php echo $doctor_id; ?>">Cancel</a>

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

    function assignEndDate(str)

    {

       $('#show_end_date').html('<input autocomplete="off" type="text" name="patient_macro_to_date" id="patient_macro_to_date" class="form-control date_val">');

       min1 = new Date(str);

       min = new Date(str);

       var numberOfDaysToAdd = 0;

       min.setDate(min.getDate() + numberOfDaysToAdd);

       var dd = min.getDate();

       var mm = min.getMonth() + 1;

       var y = min.getFullYear();

       var aa = y+'-'+mm+'-'+dd;

       max = new Date(aa); 



       $( "#patient_macro_to_date" ).datepicker({ 

          minDate: min1,

          //maxDate: max,

          dateFormat : 'yy-mm-dd',

          changeMonth : true,

          changeYear : true,

       });

    }

</script>