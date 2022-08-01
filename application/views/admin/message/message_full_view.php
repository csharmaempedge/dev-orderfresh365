<aside class="right-side">

    <!-- Content Header (Page header) -->

    <section class="content-header">

        <h1>Message</h1>

        <ol class="breadcrumb">

            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>

            <li><a href="<?php echo base_url().MODULE_NAME;?>message">Message</a></li>

            <li class="active">View Message</li>

        </ol>

    </section>

   <!-- Main content -->

    <section class="content">       

        <div class="box box-success">

            <div class="box-header">

                <div class="pull-left">

                    <h3 class="box-title">View Message</h3>

                </div>

                <div class="pull-right box-tools">

                    <a href="<?php echo base_url().MODULE_NAME;?>message" class="btn btn-info btn-sm">Back</a>

                </div>

            </div>

            <div class="row">

                <div class="col-md-12">

                    <div class="panel panel-info" style="box-shadow: none; background-color: #dfe7f1;">

                        <div class="panel-heading" style="background-color: #bad59c; color: #22255a;">Send Message</div>

                        <div class="panel-body">

                            <form action="" id="login_form" method="post" accept-charset="utf-8" enctype="multipart/form-data">

                                <?php  $csrf = array( 'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash() ); ?>

                                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

                                <div class="box-body">

                                    <div>

                                        <div id="msg_div">

                                            <?php echo $this->session->flashdata('message');?>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="form-group col-md-6">

                                            <div class="input text">

                                                <label>Patient Type</label>
                                                    <select disabled class="form-control">    

                                                        <option value="">Select Patient Type</option>

                                                        <option <?php if($message_edit->patient_type == 'Patient'){echo "selected"; } ?> value="Patient">All Patient</option>

                                                        <option <?php if($message_edit->patient_type == 'Order_Patient'){echo "selected"; } ?> value="Order_Patient">Patients whose orders are done</option>
                                                        <option <?php if($message_edit->patient_type == 'pending_Order_Patient'){echo "selected"; } ?> value="pending_Order_Patient">patients who havn't order</option>

                                                    </select> 

                                            </div>

                                        </div>

                                        <div class="form-group col-md-6">

                                            <div class="input text">

                                                <label>Message Type</label>

                                                <input disabled class="form-control" type="text" value="<?php echo ($message_edit->message_type == 'Mail') ? 'Mail' : 'Text'; ?>" />

                                            </div>

                                        </div>

                                    </div>

                                    <div class="row"> 

                                        <div class="form-group col-md-6" style="

                                                <?php

                                                if(!empty($message_edit))

                                                {

                                                    if($message_edit->patient_type =='Order_Patient'){ echo "display: none"; };

                                                }

                                                else

                                                {

                                                    echo "display: none";

                                                }

                                                ?>

                                                ">

                                            <div class="input text">

                                                <label>Patient List</label>

                                                <select disabled multiple="multiple" class="selectpicker form-control patient_id" data-show-subtext="true" data-live-search="true">

                                                    <option value="">-- Select --</option>

                                                    <?php

                                                        $user_res = $this->common_model->getData('tbl_user', array('user_status'=>1), 'multi');

                                                        $patient_id_arr = (!empty($message_edit)) ? explode(',',$message_edit->patient_id) : '';

                                                        if(!empty($user_res)){

                                                            foreach($user_res as $res){

                                                                ?>

                                                                <option <?php echo (!empty($patient_id_arr) && in_array($res->user_id, $patient_id_arr)) ? 'selected' : '' ;?> value="<?php echo $res->user_id; ?>"><?php echo $res->user_fname.' '.$res->user_lname; ?></option>

                                                                <?php

                                                            }

                                                        }

                                                    ?>

                                                </select>

                                            </div>

                                        </div>

                                        <div class="form-group col-md-6" style="

                                                <?php

                                                if(!empty($message_edit))

                                                {

                                                    if($message_edit->patient_type =='Patient'){ echo "display: none"; };

                                                }

                                                else

                                                {

                                                    echo "display: none";

                                                }

                                                ?>

                                                ">

                                            <div class="input text">

                                                <label>Order Patient List</label>

                                                <select disabled multiple="multiple" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">

                                                    <option value="">-- Select --</option>

                                                    <?php

                                                        $user_res = $this->common_model->getData('tbl_user', array('user_status'=>1), 'multi');

                                                        $patient_id_arr = (!empty($message_edit)) ? explode(',',$message_edit->patient_id) : '';

                                                        if(!empty($user_res)){

                                                            foreach($user_res as $res){

                                                                $order_res = $this->common_model->getData('tbl_order', array('patient_id'=>$res->user_id), 'single');

                                                                if(!empty($order_res))

                                                                {

                                                                    ?>

                                                                    <option <?php echo (!empty($patient_id_arr) && in_array($res->user_id, $patient_id_arr)) ? 'selected' : '' ;?> value="<?php echo $res->user_id; ?>"><?php echo $res->user_fname.' '.$res->user_lname; ?></option>

                                                                    <?php



                                                                }

                                                            }

                                                        }

                                                    ?>

                                                </select>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="form-group col-md-12">

                                            <div class="input text">

                                                <label>Mail/Text Body</label>

                                                <textarea disabled class="form-control"><?php echo $message_edit->message; ?></textarea>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <!-- /.box-body -->      

                                <div class="box-footer">

                                    <a class="btn btn-danger btn-sm" href="<?php echo base_url().MODULE_NAME;?>message">Cancel</a>

                                </div>

                            </form>

                           

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- /.box -->

    </section>

    <!-- /.content -->

</aside>

