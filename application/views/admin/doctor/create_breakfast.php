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

                        <div class="panel-heading" style="background-color: #bad59c; color: #22255a;">Patient Breakfast</div>

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

                                                              <th style="background-color: #007775; color: #fff;">Breakfast</th>

                                                              <th style="background-color: #007775; color: #fff;">Product</th>

                                                              <th style="background-color: #007775; color: #fff;">QTY</th>

                                                          </tr>

                                                      </thead>

                                                      <tbody>

                                                          <?php

                                                          $breakfast_res = $this->common_model->getData('tbl_breakfast', NULL, 'multi');

                                                          if(!empty($breakfast_res))

                                                          {

                                                              $i = 1;

                                                              foreach ($breakfast_res as $res) 

                                                              {

                                                                  $patient_breakfast_res = $this->common_model->getData('tbl_patient_breakfast', array('breakfast_id'=>$res->breakfast_id, 'patient_id'=>$patient_id), 'single');

                                                                  ?>

                                                                  <tr>

                                                                      <input type="hidden" name="breakfast_id_<?php echo $res->breakfast_id; ?>" id="breakfast_id_<?php echo $res->breakfast_id; ?>" value="<?php echo $res->breakfast_id; ?>" >

                                                                      <td width="100px;"><?php echo  $i; ?></td>

                                                                      <td width="200px;"><?php echo $res->breakfast_name; ?></td>

                                                                      <td width="350px;">

                                                                          <select data-validation="required" name="product_id_<?php echo $res->breakfast_id; ?>" id="product_id_<?php echo $res->breakfast_id; ?>" class="form-control">

                                                                              <option value="">-- Select --</option>

                                                                              <?php

                                                                              if($res->breakfast_id == '1')

                                                                              {

                                                                                $product_res = $this->common_model->getData('tbl_product', array('category_id'=>'4','breakfast_type'=>'Protien','product_status'=>1), 'multi');

                                                                              }

                                                                              else

                                                                              {

                                                                                $product_res = $this->common_model->getData('tbl_product', array('breakfast_type'=>'Other','category_id'=>'4','product_status'=>1), 'multi');

                                                                              }

                                                                                  if(!empty($product_res)){

                                                                                      foreach($product_res as $p_res){

                                                                                          ?>

                                                                                          <option <?php echo (!empty($patient_breakfast_res) && $patient_breakfast_res->product_id == $p_res->product_id) ? 'selected' : '' ;?> value="<?php echo $p_res->product_id; ?>"><?php echo $p_res->product_name; ?></option>

                                                                                          <?php

                                                                                      }

                                                                                  }

                                                                              ?>

                                                                          </select>



                                                                      </td>

                                                                      <td width="350px;">

                                                                          <input type="number" data-validation="required" name="qty_<?php echo $res->breakfast_id; ?>" id="qty_<?php echo $res->breakfast_id; ?>" class="form-control" value="<?php echo (!empty($patient_breakfast_res)) ? $patient_breakfast_res->qty : ''; ?>">

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

                                    $patient_breakfast_data = $this->common_model->getData('tbl_patient_breakfast', array('patient_id'=>$patient_id), 'single');

                                    ?> 

                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="form-group col-md-6">

                                            <div class="input text">

                                                <label>From Date<span class="text-danger">*</span></label>

                                                

                                                   <input autocomplete="off" data-validation="date" type="text" name="patient_breakfast_from_date" id="patient_breakfast_from_date" class="form-control current_date_val" value="<?php echo (!empty($patient_breakfast_data->patient_breakfast_from_date)) ? $patient_breakfast_data->patient_breakfast_from_date : ''; ?>" onchange="assignEndDate(this.value)">


                                                <?php echo form_error('patient_breakfast_from_date','<span class="text-danger">','</span>'); ?>

                                            </div>

                                        </div> 

                                        <div class="form-group col-md-6">

                                            <div class="input text">

                                                <label>To Date<span class="text-danger">*</span></label>

                                                  <div id="show_end_date">

                                                  <input autocomplete="off" data-validation="date" type="text" name="patient_breakfast_to_date" id="patient_breakfast_to_date" class="form-control" value="<?php echo (!empty($patient_breakfast_data->patient_breakfast_to_date)) ? $patient_breakfast_data->patient_breakfast_to_date : ''; ?>" >


                                               </div>

                                                <?php echo form_error('patient_breakfast_to_date','<span class="text-danger">','</span>'); ?>

                                            </div>

                                        </div>

                                        </div>

                                    </div>  

                                    <div class="row">

                                        <div class="form-group col-md-12">

                                            <div class="input text">

                                                <label>Note</label>

                                                <textarea name="note" id="note" class="form-control"><?php echo (!empty($patient_breakfast_data->note)) ? $patient_breakfast_data->note : ''; ?></textarea>

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

       $('#show_end_date').html('<input autocomplete="off" type="text" name="patient_breakfast_to_date" id="patient_breakfast_to_date" class="form-control date_val">');

       min1 = new Date(str);

       min = new Date(str);

       var numberOfDaysToAdd = 0;

       min.setDate(min.getDate() + numberOfDaysToAdd);

       var dd = min.getDate();

       var mm = min.getMonth() + 1;

       var y = min.getFullYear();

       var aa = y+'-'+mm+'-'+dd;

       max = new Date(aa); 



       $( "#patient_breakfast_to_date" ).datepicker({ 

          minDate: min1,

          //maxDate: max,

          dateFormat : 'yy-mm-dd',

          changeMonth : true,

          changeYear : true,

       });

    }

</script>