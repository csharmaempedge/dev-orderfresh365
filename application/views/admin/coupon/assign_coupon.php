<aside class="right-side">

    <section class="content-header">

        <h1>Product</h1>

        <ol class="breadcrumb">

            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>

            <li><a href="<?php echo base_url().MODULE_NAME;?>coupon">Product</a></li>

            <li class="active"> Assign Coupon Code</li>

        </ol>

    </section>

    <section class="content">       

        <div class="box box-success">

            <div class="box-header">

                <div id="msg_div">

                    <?php echo $this->session->flashdata('message');?>

                </div>

                <div class="pull-right box-tools">

                    <a href="<?php echo base_url().MODULE_NAME;?>coupon" class="btn btn-info btn-sm">Back</a>                           

                </div>

            </div>

            <br> 

            <div class="row">

                <div class="item form-group col-md-12">

                    <table class="table">

                      <tbody>

                        <?php 

                        $coupon_code_res = $this->common_model->getData('tbl_coupon_code', array('coupon_code_id'=>$coupon_code_id), 'single');

                        ?>

                          <tr>

                              <th style="color: #046c71" width="35%">Coupon Code Name</th>

                              <td style="color: #046c71"><?php echo !empty($coupon_code_res->coupon_code_name) ? $coupon_code_res->coupon_code_name : ''; ?></td>

                              <th style="color: #046c71" width="35%">Coupon Code</th>

                              <td style="color: #046c71"><?php echo !empty($coupon_code_res->coupon_code) ? $coupon_code_res->coupon_code : ''; ?></td>

                          </tr>

                          <tr>

                              <th style="color: #046c71" width="35%">Expiry Date</th>

                              <td style="color: #046c71"><?php echo !empty($coupon_code_res->coupon_code_expiry_date) ? $coupon_code_res->coupon_code_expiry_date : ''; ?></td>

                              <th style="color: #046c71" width="35%">Coupon Code Amount</th>

                              <td style="color: #046c71">$<?php echo !empty($coupon_code_res->coupon_code_amount) ? $coupon_code_res->coupon_code_amount : ''; ?></td>

                          </tr>

                      </tbody>

                  </table>

              </div>

            </div>

            <br>

            <div class="row">

                <div class="col-md-12">

                    <div class="panel panel-info" style="box-shadow: none; background-color: #dfe7f1;">

                        <div class="panel-heading" style="background-color: #bad59c; color: #22255a;">Assign Coupon Code</div>

                        <div class="panel-body">

                                <form action="" method="post" accept-charset="utf-8" enctype="multipart/form-data" id="login_form">

                                    <?php  $csrf = array( 'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash() ); ?>

                                    <input type="hidden" disabled name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

                                    <div class="box-body">

                                        <?php

                                         $coupon_code_assign_res = $this->common_model->getData('tbl_coupon_code_assign', array('coupon_code_id'=>$coupon_code_id), 'multi');

                                         if(!empty($coupon_code_assign_res))

                                         {

                                            ?>

                                                <div class="row">

                                                  <div class="col-md-12">

                                                      <div class="table-responsive">

                                                          <table id="load_data" class="table table-bordered table-striped">

                                                              <thead>

                                                                  <tr class="label-primary1">

                                                                      <th style="background-color: #007775; color: #fff;">S. No.</th>

                                                                      <th style="background-color: #007775; color: #fff;">Patient Name</th>

                                                                      <th style="background-color: #007775; color: #fff;">Assign Date</th>

                                                                      <th style="background-color: #007775; color: #fff;">Remove</th>

                                                                  </tr>

                                                              </thead>

                                                              <tbody>

                                                                  <?php

                                                                  if(!empty($coupon_code_assign_res))

                                                                  {

                                                                      $i = 1;

                                                                      foreach ($coupon_code_assign_res as $res) 

                                                                      {

                                                                          $patient_res = $this->common_model->getData('tbl_user', array('user_id'=>$res->patient_id), 'single');

                                                                          ?>

                                                                          <tr id="remove_div_<?php echo $res->coupon_code_assign_id; ?>">

                                                                              <td width="100px;"><?php echo  $i; ?></td>

                                                                              <td width="200px;"><?php echo $patient_res->user_fname.' '.$patient_res->user_lname; ?></td>

                                                                              <td width="200px;"><?php echo !empty($res->coupon_code_assign_created_date) ? $res->coupon_code_assign_created_date : ''; ?></td>

                                                                              <td width="15px;">

                                                                                <button class="btn btn-danger btn-xs" type="button" onclick="removeCoupon('<?php echo $res->coupon_code_assign_id; ?>')"><i class="fa fa-trash"></i></button>

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

                                            <?php

                                         }

                                        ?>

                                        <div class="row">

                                            <input type="hidden" name="coupon_code" value="<?php echo !empty($coupon_code_res->coupon_code) ? $coupon_code_res->coupon_code : ''; ?>">

                                            <div class="form-group col-md-6">

                                                <div class="input text">

                                                    <label>Assign Patient<span class="text-danger">*</span></label>

                                                    <select data-validation="required" name="patient_id[]" id="patient_id" multiple="multiple" class="selectpicker form-control patient_id" data-show-subtext="true" data-live-search="true">

                                                       <option value="">-- Select --</option>

                                                       <?php

                                                          $patient_res = $this->common_model->getData('tbl_user', array('role_id'=>'4','user_status'=>'1'), 'multi');

                                                          if(!empty($patient_res))

                                                          {

                                                            foreach ($patient_res as $e_res) 

                                                            {

                                                                $coupon_code_assign_res = $this->common_model->getData('tbl_coupon_code_assign', array('coupon_code_id'=>$coupon_code_id, 'patient_id'=>$e_res->user_id), 'single');

                                                                if(empty($coupon_code_assign_res))

                                                                {

                                                                  ?>



                                                                  <option value="<?php echo $e_res->user_id; ?>"><?php echo $e_res->user_fname.' '.$e_res->user_lname; ?></option>

                                                                  <?php



                                                                }

                                                            }

                                                          }

                                                        ?>

                                                   </select>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="box-footer">

                                        <button class="btn btn-success btn-sm" type="submit" name="Submit" value="Edit" >Assign</button>

                                        <a class="btn btn-danger btn-sm" href="<?php echo base_url();?>admin/coupon">Cancel</a>

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

    function removeCoupon(coupon_code_assign_id){

        var PAGE = '<?php echo base_url().MODULE_NAME; ?>coupon/removeCoupon/'+coupon_code_assign_id;        

        var str = 'coupon_code_assign_id='+coupon_code_assign_id+'&<?php echo $this->security->get_csrf_token_name(); ?>='+'<?php echo $this->security->get_csrf_hash(); ?>';

        $.ajax({

            url: PAGE,

            type: 'POST',

            data: str,

            success: function(response){                

                if(response){

                    $('#remove_div_'+coupon_code_assign_id).remove();

                }

                else{

                    $('#error_image_'+coupon_code_assign_id).html('Image removing faild please try again!')

                }

            }

        });

    }

</script>