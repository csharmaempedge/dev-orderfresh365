<aside class="right-side">
    <section class="content-header">
        <h1>Patient</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url().MODULE_NAME;?>doctor/docpatientView/<?php echo $doctor_id; ?>">Patient</a></li>
            <li class="active">History Patient</li>
        </ol>
    </section>
    <section class="content">       
        <div class="box box-success">
            <div class="box-header">
                <div class="pull-left">
                    <h3 class="box-title"> Patient History Details</h3>
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
                    <table class="table" >
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
                        <div class="panel-heading" style="background-color: #bad59c; color: #22255a;">Patient Breakfast History</div>
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
                                        <?php
                                        $patient_breakfast_his_res = $this->common_model->getData('tbl_patient_breakfast_history', array('patient_id'=>$patient_id), 'multi',NULL, NULL, NULL, 'patient_breakfast_from_date');
                                        if(!empty($patient_breakfast_his_res))
                                        {
                                            ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table id="example" class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr class="label-primary1">
                                                                    <th style="background-color: #007775; color: #fff;">S. No.</th>
                                                                    <th style="background-color: #007775; color: #fff;">Date</th>
                                                                    <th style="background-color: #007775; color: #fff;">Breakfast</th>
                                                                    <th style="background-color: #007775; color: #fff;">Note</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                    $i = 1;
                                                                    foreach ($patient_breakfast_his_res as  $res) 
                                                                    {
                                                                        
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo  $i; ?></td>
                                                                            <td>
                                                                                <?php
                                                                                echo $res->patient_breakfast_from_date.'<b> To </b>'.$res->patient_breakfast_to_date;
                                                                                ?>
                                                                            </td>
                                                                            <td>
                                                                              <?php
                                                                              $breakfast_date_res = $this->common_model->getData('tbl_patient_breakfast_history', array('patient_breakfast_from_date'=>$res->patient_breakfast_from_date,'patient_id'=>$patient_id), 'multi');
                                                                              if(!empty($breakfast_date_res))
                                                                              {
                                                                                $breakfast = array();
                                                                                foreach ($breakfast_date_res as $p_res) 
                                                                                {
                                                                                    $breakfast_res = $this->common_model->getData('tbl_breakfast', array('breakfast_id'=>$p_res->breakfast_id), 'single');
                                                                                    $product_res = $this->common_model->getData('tbl_product', array('product_id'=>$p_res->product_id), 'single');
                                                                                    echo $breakfast[] = '<b style="color: red;">'.$breakfast_res->breakfast_name.'</b> <b> '.$product_res->product_name.' '.$p_res->qty.' </b>';
                                                                                }
                                                                              }
                                                                              ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php
                                                                                    echo $res->note;
                                                                                ?>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                        $i++;
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
                                </form> 
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>