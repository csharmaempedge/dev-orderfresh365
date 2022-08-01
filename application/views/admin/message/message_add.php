<aside class="right-side">

    <!-- Content Header (Page header) -->

    <section class="content-header">

        <h1>Message</h1>

        <ol class="breadcrumb">

            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>

            <li><a href="<?php echo base_url().MODULE_NAME;?>message">Message</a></li>

            <li class="active">Send Message</li>

        </ol>

    </section>

   <!-- Main content -->

    <section class="content">       

        <div class="box box-success">

            <div class="box-header">

                <div class="pull-left">

                    <h3 class="box-title">Send Message</h3>

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

                                                <label>Patient Type<span class="text-danger">*</span></label>

                                                <select onchange="showPatientDiv(this.value)" name="patient_type" id="patient_type" class="form-control">    

                                                    <option value="">Select Patient Type</option>

                                                    <option value="Patient">All Patient</option>

                                                    <option value="Order_Patient">Patients whose orders are done</option>
                                                    <option value="pending_Order_Patient">patients who havn't order</option>

                                                </select> 

                                            </div>

                                        </div>

                                        <div class="form-group col-md-6">

                                            <div class="input text">

                                                <label>Message Type<span class="text-danger">*</span></label>

                                                <select name="message_type[]" id="message_type" multiple="multiple" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">

                                                    <option value="Mail">Mail</option>

                                                    <option value="Text">Text</option>

                                                </select> 

                                            </div>

                                        </div>

                                    </div>

                                    <div class="row"> 

                                        <div class="form-group col-md-6" style="display: none;" id="patient_div">

                                            <div class="input text">

                                                <label>Patient List<span class="text-danger">*</span></label>

                                                <select data-validation="required" name="patient_id[]" id="patient_id" multiple="multiple" class="selectpicker form-control patient_id" data-show-subtext="true" data-live-search="true">

                                                    <option value="">-- Select --</option>
                                                    <option value="All">ALL</option>

                                                    <?php

                                                        $user_res = $this->common_model->getData('tbl_user', array('user_status'=>1, 'role_id'=>4), 'multi');

                                                        if(!empty($user_res)){

                                                            foreach($user_res as $res){

                                                                ?>

                                                                <option value="<?php echo $res->user_id; ?>"><?php echo $res->user_fname.' '.$res->user_lname; ?></option>

                                                                <?php

                                                            }

                                                        }

                                                    ?>

                                                </select>

                                            </div>

                                        </div>

                                        <div class="form-group col-md-6" style="display: none;" id="order_patient_div">

                                            <div class="input text">

                                                <label>Order Patient List<span class="text-danger">*</span></label>

                                                <select data-validation="required" name="order_patient_id[]" id="order_patient_id" multiple="multiple" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">

                                                    <option value="">-- Select --</option>
                                                    <option value="All">ALL</option>
                                                    <?php

                                                        $user_res = $this->common_model->getData('tbl_user', array('user_status'=>1), 'multi');

                                                        if(!empty($user_res)){

                                                            foreach($user_res as $res){

                                                                $order_res = $this->common_model->getData('tbl_order', array('patient_id'=>$res->user_id), 'single');

                                                                if(!empty($order_res))

                                                                {

                                                                    ?>

                                                                    <option value="<?php echo $res->user_id; ?>"><?php echo $res->user_fname.' '.$res->user_lname; ?></option>

                                                                    <?php



                                                                }

                                                            }

                                                        }

                                                    ?>

                                                </select>

                                            </div>

                                        </div>
                                        <div class="form-group col-md-6" style="display: none;" id="pending_order_patient_div">

                                            <div class="input text">

                                                <label>Pending Order Patient List<span class="text-danger">*</span></label>

                                                <select data-validation="required" name="pending_order_patient_id[]" id="pending_order_patient_id" multiple="multiple" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">

                                                    <option value="">-- Select --</option>
                                                    <option value="All">ALL</option>
                                                    <?php

                                                        $user_res = $this->common_model->getData('tbl_user', array('user_status'=>1), 'multi');

                                                        if(!empty($user_res)){

                                                            foreach($user_res as $res){

                                                                $order_res = $this->common_model->getData('tbl_cart', array('patient_id'=>$res->user_id), 'single');

                                                                if(!empty($order_res))

                                                                {

                                                                    ?>

                                                                    <option value="<?php echo $res->user_id; ?>"><?php echo $res->user_fname.' '.$res->user_lname; ?></option>

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

                                                <label>Mail/Text Body<span class="text-danger">*</span></label>

                                                <textarea data-validation="required" name="message" id="message" class="form-control"><?php echo set_value('message'); ?></textarea>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <!-- /.box-body -->      

                                <div class="box-footer">

                                   <button class="btn btn-success btn-sm" type="submit" name="Submit" value="Add" >Send</button>

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

<!-- /.right-side -->

<script type="text/javascript">

    function showPatientDiv(str) 

    {

        if(str == 'Patient')

        {

            $('#patient_div').show();

            $('#order_patient_div').hide();
            $('#pending_order_patient_div').hide();

        }

        else if(str == 'Order_Patient')

        {

            $('#patient_div').hide();

            $('#pending_order_patient_div').hide();
            $('#order_patient_div').show();

        }
        else if(str == 'pending_Order_Patient')

        {

            $('#patient_div').hide();

            $('#order_patient_div').hide();
            $('#pending_order_patient_div').show();

        }

        else

        {

            $('#patient_div').hide();

            $('#order_patient_div').hide();

        }

    }

</script>

