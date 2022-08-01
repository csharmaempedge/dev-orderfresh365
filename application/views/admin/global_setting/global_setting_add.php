<aside class="right-side">

    <section class="content-header">

        <h1>Global Setting</h1>

        <ol class="breadcrumb">

            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i>Home</a></li>

            <li><a href="<?php echo base_url().MODULE_NAME;?>globalSetting">Global Setting</a></li>

            <li class="active">Global Setting Add</li>

        </ol>

    </section>

    <section class="content">       

        <div class="box box-success">

            <div class="box-header">

                <div class="tab-content">

                    <div class="pull-left">

                        <!-- <h3 class="box-title">Create Global Setting</h3> -->

                    </div>

                    <form action="" method="post" accept-charset="utf-8" enctype="multipart/form-data">

                        <?php  $csrf = array( 'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash() ); ?>

                        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

                        <input type="hidden" name="gs_id" value="<?= (!empty($gs_setting)) ? $gs_setting->gs_id : ''; ?>">

                        <div class="pull-right">

                            <button class="btn btn-success btn-sm" type="submit" name="Submit" value="<?= (!empty($gs_setting)) ? 'Edit' : 'Add' ?>" >Submit</button>

                        </div>

                        <div class="box-body">

                            <div>

                                <div id="msg_div">

                                    <?php echo $this->session->flashdata('message');?>

                                </div>

                            </div> <br><br>

                            <div class="row">

                                <div class="col-md-12">

                                    <div class="panel panel-info" style="box-shadow: none; background-color: #dfe7f1;">

                                        <div class="panel-heading" style="background-color: #bad59c; color: #22255a;">Create Global Setting

                                        </div>

                                        <div class="panel-body">

                                            <div class="row">

                                                <div class="form-group col-md-4">

                                                    <div class="input text">

                                                        <label>Delivery Status</label>

                                                        <select class="form-control" name="deliver_status" id="deliver_status" onchange="showDeliveryAmount(this.value)">

                                                                <option value="0">Select Delivery Status</option>

                                                                <option <?php echo (!empty($gs_setting) && $gs_setting->deliver_status == 'On') ? 'selected' : '' ;?> value="On">On</option>

                                                                <option <?php echo (!empty($gs_setting) && $gs_setting->deliver_status == 'Off') ? 'selected' : '' ;?> value="Off">Off</option>

                                                        </select>

                                                    </div>

                                                </div>

                                                <div id="show_div" style="

                                                <?php

                                                if(!empty($gs_setting))

                                                {

                                                    if($gs_setting->deliver_status =='On' || $gs_setting->deliver_status == ''){ echo "display: none"; };

                                                }

                                                else

                                                {

                                                    echo "display: none";

                                                }

                                                ?>

                                                " class="form-group col-md-8">

                                                    <div class="input text">

                                                        <label>Enter Delivery Amount</label>

                                                        <input type="text" name="deliver_charge" id="deliver_charge" class="form-control" value="<?php echo (!empty($gs_setting)) ? $gs_setting->deliver_charge : ''; ?>">

                                                    </div>

                                                </div>

                                            </div> 

                                            <div class="row">

                                                <div class="form-group col-md-4">

                                                    <div class="input text">

                                                        <label>Enter Tax (Percentage) <span class="text-danger">*</span></label>

                                                        

                                                            <input required data-validation="number" data-validation-allowing="float" min="0" type="text" name="tax" id="tax" class="form-control" value="<?php echo (!empty($gs_setting)) ? $gs_setting->tax : ''; ?>">


                                                    </div>

                                                </div>

                                            </div> 

                                            <div class="row">

                                                <div class="form-group col-md-4">

                                                    <div class="input text">

                                                        <label>Expiry Date<span class="text-danger">*</span></label>

                                                         

                                                           <input autocomplete="off" data-validation="date" type="text" name="expire_date" id="expire_date" class="form-control current_date_val" value="<?php echo (!empty($gs_setting)) ? $gs_setting->expire_date : ''; ?>">

                                                        <?php echo form_error('expire_date  ','<span class="text-danger">','</span>'); ?>

                                                    </div>

                                                </div>

                                                <div class="form-group col-md-4">

                                                    <label>Set Theme Color<span class="text-danger">*</span></label>

                                                    <input type="color" name="theme_color" id="theme_color" class="form-control" value="<?php echo (!empty($gs_setting)) ? $gs_setting->theme_color : ''; ?>">

                                                </div>

                                                <div class="form-group col-md-4">

                                                    <div class="input text">

                                                        <label>Delivery Date<span class="text-danger">*</span></label>

                                                        

                                                           <input autocomplete="off" data-validation="date" type="text" name="front_delivery_date" id="front_delivery_date" class="form-control current_date_val" value="<?php echo (!empty($gs_setting)) ? $gs_setting->front_delivery_date : ''; ?>">


                                                        <?php echo form_error('front_delivery_date  ','<span class="text-danger">','</span>'); ?>

                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row">

<div class="form-group col-md-12">

    <div class="input text">

        <label>Order Open SMS Body<span class="text-danger">*</span></label>

        <textarea  required rows="4" name="order_open_sms" id="order_open_sms" class="form-control"><?php echo (!empty($gs_setting)) ? $gs_setting->order_open_sms : ''; ?></textarea>
       
    </div>
   
     

</div>

</div>

<div class="row">

<div class="form-group col-md-12">

    <div class="input text">

        <label>Order Open Mail Body<span class="text-danger">*</span></label>

        <textarea required rows="4" name="order_open_mail" id="order_open_mail" class="form-control"><?php echo (!empty($gs_setting)) ? $gs_setting->order_open_mail : ''; ?></textarea>

    </div>
     
</div>

</div>

<div class="row">

<div class="form-group col-md-12">

<div class="input text">

<label>Order Close SMS Body<span class="text-danger">*</span></label>

<textarea required rows="4" name="order_close_sms" id="order_close_sms" class="form-control"><?php echo (!empty($gs_setting)) ? $gs_setting->order_close_sms : ''; ?></textarea>

</div>

</div>

</div>
<div class="row">

<div class="form-group col-md-12">

<div class="input text">

<label>Order Close Mail Body<span class="text-danger">*</span></label>

<textarea required rows="4" name="order_close_mail" id="order_close_mail" class="form-control"><?php echo (!empty($gs_setting)) ? $gs_setting->order_close_mail : ''; ?></textarea>

</div>

</div>

</div>

                                            <div class="row">

	                                            <div class="form-group col-md-12">

	                                                <div class="input text">

	                                                    <label>Mail Reminder Body</label>

	                                                    <textarea rows="4" name="pending_order_mail_body" id="pending_order_mail_body" class="form-control"><?php echo (!empty($gs_setting)) ? $gs_setting->pending_order_mail_body : ''; ?></textarea>

	                                                </div>

	                                            </div>

	                                        </div> 

                                            <div class="row">

                                                <div class="form-group col-md-12">

                                                    <div class="input text">

                                                        <label>Sms Reminder Body</label>

                                                        <textarea rows="4" name="sms_Reminder_body" id="sms_Reminder_body" class="form-control"><?php echo (!empty($gs_setting)) ? $gs_setting->sms_Reminder_body : ''; ?></textarea>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="row">

                                                <div class="form-group col-md-12">

                                                    <div class="input text">

                                                        <label>Registration Message</label>

                                                        <textarea rows="4" name="registration_message" id="registration_message" class="form-control"><?php echo (!empty($gs_setting)) ? $gs_setting->registration_message : ''; ?></textarea>

                                                    </div>

                                                </div>

                                            </div>
                                            <div class="row">

                                                <div class="form-group col-md-12">

                                                    <div class="input text">

                                                        <label>Patient Registration Mail Body</label>

                                                        <textarea rows="4" name="patient_registration_mail" id="patient_registration_mail" class="form-control"><?php echo (!empty($gs_setting)) ? $gs_setting->patient_registration_mail : ''; ?></textarea>

                                                    </div>

                                                </div>

                                            </div>

             
                                        <div class="panel-heading" style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">SMTP SETTING

                                        </div>

                                        <br>
                                         <div class="row">

                                            <div class="form-group col-md-6">

                                                <div class="input text">

                                                    <label>Enter Host Name<span class="text-danger">*</span></label>

                                                    <input rdata-validation="required" type="text" name="smtp_host" id="smtp_host" class="form-control" value="<?php echo (!empty($gs_setting)) ? $gs_setting->smtp_host : ''; ?>">

                                                </div>

                                            </div>

                                            <div class="form-group col-md-6">

                                                <div class="input text">

                                                    <label>Enter SMTP Secure<span class="text-danger">*</span></label>

                                                    <input rdata-validation="required" type="text" name="smtp_secure" id="smtp_secure" class="form-control" value="<?php echo (!empty($gs_setting)) ? $gs_setting->smtp_secure : ''; ?>">

                                                </div>

                                            </div>

                                        </div>
                                        <div class="row">

                                            <div class="form-group col-md-4">

                                                <div class="input text">

                                                    <label>Enter Mail<span class="text-danger">*</span></label>

                                                    <input rdata-validation="required" type="mail" name="smtp_mail" id="smtp_mail" class="form-control" value="<?php echo (!empty($gs_setting)) ? $gs_setting->smtp_mail : ''; ?>">

                                                </div>

                                            </div>

                                            <div class="form-group col-md-4">

                                                <div class="input text">

                                                    <label>Enter Password<span class="text-danger">*</span></label>

                                                    <input rdata-validation="required" type="password" name="smtp_password" id="smtp_password" class="form-control" value="<?php echo (!empty($gs_setting)) ? $gs_setting->smtp_password : ''; ?>">

                                                </div>

                                            </div>
                                            <div class="form-group col-md-4">

                                                <div class="input text">

                                                    <label>Enter Port<span class="text-danger">*</span></label>

                                                    <input rdata-validation="required" type="text" name="smtp_port" id="smtp_port" class="form-control" value="<?php echo (!empty($gs_setting)) ? $gs_setting->smtp_port : ''; ?>">

                                                </div>

                                            </div>

                                        </div>



                                        <div class="panel-heading" style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">WARNING MESSAGE

                                        </div>

                                        <br>

                                        <div class="row">

                                            <div class="form-group col-md-12">

                                                <div class="input text">

                                                    <label>Warning Message (Above 30 Miles)</label>

                                                    <textarea rows="4" name="warning_message" id="warning_message" class="form-control"><?php echo (!empty($gs_setting)) ? $gs_setting->warning_message : ''; ?></textarea>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="panel-heading" style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">MINIMUM ORDER SURCHARGE

                                        </div>

                                        <br>

                                        <div class="row">

                                            <div class="form-group col-md-12">

                                                <label>Enter Minimum Order Surcharge</label>

                                                <div class='input-group'>

                                                    <span class="input-group-addon">

                                                        $

                                                    </span>

                                                    <input type="text" name="minimum_surcharge" id="minimum_surcharge" class="form-control" value="<?php echo (!empty($gs_setting)) ? $gs_setting->minimum_surcharge : ''; ?>">

                                                </div>

                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="form-group col-md-12">

                                                <div class="input text">

                                                    <label>Warning Message (Minimum Order)</label>

                                                    <textarea rows="4" name="minimum_order_warning_message" id="minimum_order_warning_message" class="form-control"><?php echo (!empty($gs_setting)) ? $gs_setting->minimum_order_warning_message : ''; ?></textarea>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="panel-heading" style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">MORE THAN 20 QUANTITES MESSAGE

                                        </div>

                                        <br>

                                        <div class="row">

                                            <div class="form-group col-md-12">

                                                <div class="input text">

                                                    <label>Message (20 Quantites)</label>

                                                    <textarea rows="4" name="quantites_20_message" id="quantites_20_message" class="form-control"><?php echo (!empty($gs_setting)) ? $gs_setting->quantites_20_message : ''; ?></textarea>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="panel-heading" style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Distance Amount

                                        </div>

                                        <div class="panel-body">

                                            <div class="row">
                                                <div class="form-group col-md-6">

                                                    <div class="input text">

                                                        <label>Enter Special Delivery Amount (Above 30 Miles)<span class="text-danger">*</span></label>

                                                        <input required data-validation="custom" data-validation-regexp="^([0-9]+)$" type="text" name="special_delivery_charge" id="special_delivery_charge" class="form-control" value="<?php echo (!empty($gs_setting)) ? $gs_setting->special_delivery_charge : ''; ?>">

                                                    </div>

                                                </div>

                                                <div class="col-md-12">

                                                    <div class="table-responsive">

                                                    <table id="load_categorylist" class="table table-bordered table-striped">

                                                        <thead>

                                                            <tr class="label-primary1">

                                                                <th>S.No.</th>

                                                                <th>Distance Range</th>

                                                                <th>Distance Amount</th>

                                                            </tr>

                                                        </thead>

                                                        <tbody>

                                                            <?php

                                                            $distance_res = $this->common_model->getData('tbl_distance', NULL, 'multi');

                                                            if(!empty($distance_res))

                                                            {

                                                                $i = 1;

                                                                foreach($distance_res as $res)

                                                                {

                                                                    ?>    

                                                                    <tr>

                                                                        <td><?php echo $i; ?></td>

                                                                        <?php

                                                                        if($res->distance_id != '5')

                                                                        {

                                                                            ?>

                                                                            <td><?php echo $res->distance_range_start.' -  '.$res->distance_range_end; ?></td>

                                                                            <?php

                                                                        }

                                                                        else

                                                                        {

                                                                            ?>

                                                                            <td><?php echo $res->distance_range_start.' -  '.'Above'; ?></td>

                                                                            <?php

                                                                        }

                                                                        ?>

                                                                        <td>

                                                                            <div class='input-group'>

                                                                                <span class="input-group-addon">

                                                                                    $

                                                                                </span>

                                                                                <input autocomplete="off" type="text" name="distance_amount_<?php echo $res->distance_id; ?>" class="form-control" value="<?php echo $res->distance_amount; ?>">

                                                                            </div>

                                                                        </td>

                                                                    </tr>

                                                                    <?php

                                                                    $i++;

                                                                }

                                                            }

                                                            else

                                                            {

                                                                ?>

                                                                <tr>

                                                                    <td colspan="12">No records found...</td>

                                                                </tr>

                                                                <?php

                                                            }

                                                            

                                                        ?>

                                                        </tbody>

                                                    </table>

                                                </div>

                                                </div>

                                            </div> 

                                        </div>



                                        <!-- <div class="row">

                                            <div class="form-group col-md-12">

                                                <div class="input text">

                                                    <label>PRIVACY POLICY</label>

                                                    <textarea rows="4" name="privacy_policy" id="privacy_policy" class="form-control tiny_textarea"><?php echo (!empty($gs_setting)) ? $gs_setting->privacy_policy : ''; ?></textarea>

                                                </div>

                                            </div>

                                        </div> 

                                        <div class="row">

                                            <div class="form-group col-md-12">

                                                <div class="input text">

                                                    <label>TERMS & CONDITIONS</label>

                                                    <textarea rows="4" name="term_n_condition" id="term_n_condition" class="form-control tiny_textarea"><?php echo (!empty($gs_setting)) ? $gs_setting->term_n_condition : ''; ?></textarea>

                                                </div>

                                            </div>

                                        </div> -->

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="box-footer">

                            <button class="btn btn-success btn-sm" type="submit" name="Submit" value="<?= (!empty($gs_setting)) ? 'Edit' : 'Add' ?>" >Submit</button>

                            <a class="btn btn-danger btn-sm" href="<?php echo base_url().MODULE_NAME;?>globalSetting">Cancel</a>

                        </div>

                    </form>

                </div>

            </div>

    </section>

</aside>


<script type="text/javascript">


    function showDeliveryAmount(str)

    {

        if(str == 'Off')

        {

            $('#show_div').show();

        }

        else if(str == 'On')

        {

            $('#show_div').hide();

        }

        else

        {

            $('#show_div').hide();

        }

    }

</script>

