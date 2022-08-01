<aside class="right-side">

    <section class="content-header">

        <h1>Order Setting</h1>

        <ol class="breadcrumb">

            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i>Home</a></li>

            <li><a href="<?php echo base_url().MODULE_NAME;?>orderSetting">Order Setting</a></li>

            <li class="active">Order Setting Add</li>

        </ol>

    </section>

    <section class="content">       

        <div class="box box-success">

            <div class="box-header">

                <div class="tab-content">

                    <div class="pull-left">

                        <!-- <h3 class="box-title">Create Order Setting</h3> -->

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

                                        <div class="panel-heading" style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Create Order Setting

                                        </div>

                                        <div class="panel-body">

                                            <div class="row">

                                                <div class="form-group col-md-4">

                                                    <div class="input text">

                                                        <label>Order Status</label>

                                                        <select class="form-control" name="order_status" id="order_status" onchange="showOrderAmount(this.value)">

                                                                <option value="0">Select Order Status</option>

                                                                <option <?php echo (!empty($gs_setting) && $gs_setting->order_status == 'Open') ? 'selected' : '' ;?> value="Open">Open</option>

                                                                <option <?php echo (!empty($gs_setting) && $gs_setting->order_status == 'Close') ? 'selected' : '' ;?> value="Close">Close</option>

                                                        </select>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="row" id="show_late_div" style="

                                                <?php

                                                if(!empty($gs_setting))

                                                {

                                                    if($gs_setting->order_status =='Close' || $gs_setting->order_status == ''){ echo "display: none"; };

                                                }

                                                else

                                                {

                                                    echo "display: none";

                                                }

                                                ?>

                                                ">

                                            

                                                <div class='form-group col-md-4' id="end_date_div">

                                                    <label>Deadline Date/Time<span class="text-danger">*</span></label>


                                                        <input autocomplete="off" type="text" class="form-control datetimepicker1" name="deadline_date" id="deadline_date" value="<?php echo (!empty($gs_setting)) ? $gs_setting->deadline_date : ''; ?>" >


                                                </div>

                                                    <div class="form-group col-md-4">

                                                    <label>Closing Date/Time</label>


                                                        <input autocomplete="off" type="text" class="form-control datetimepicker1" name="closeing_date" id="closeing_date" value="<?php echo (!empty($gs_setting)) ? $gs_setting->closeing_date : ''; ?>" required="required">

                                                   <span class="text-danger"></span>

                                                </div>

                                                <div class="form-group col-md-4">

                                                    <label>Enter Late Charge<span class="text-danger">*</span></label>

                                                    <div class='input-group'>

                                                        <span class="input-group-addon">

                                                            $

                                                        </span>

                                                        <input required data-validation="custom" data-validation-regexp="^([0-9]+)$" type="text" name="late_charge" id="late_charge" class="form-control" value="<?php echo (!empty($gs_setting)) ? $gs_setting->late_charge : ''; ?>">

                                                        </div>

                                                </div>

                                            </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="box-footer">

                            <button class="btn btn-success btn-sm" type="submit" name="Submit" value="<?= (!empty($gs_setting)) ? 'Edit' : 'Add' ?>" >Submit</button>

                            <a class="btn btn-danger btn-sm" href="<?php echo base_url().MODULE_NAME;?>orderSetting">Cancel</a>

                        </div>

                    </form>

                </div>

            </div>

    </section>

</aside>

<div id="myModal" class="modal fade" role="dialog">

</div>

<link href="<?php echo base_url();?>webroot/css/bootstrap-datetimepicker.css" rel="stylesheet">

<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>webroot/css/bootstrap.min.css" />

<script src="<?php echo base_url(); ?>webroot/js/moment-with-locales.js"></script>

<script src="<?php echo base_url(); ?>webroot/js/bootstrap-datetimepicker.js"></script>

<script type="text/javascript">

    $(function () {

      /*  $('body').on('focus', ".datetimepicker1", function(){

           $(this).datetimepicker({

               format: 'YYYY-MM-DD HH:ss',

               useCurrent: true

            });

        });



        $('.datetimepicker1').on('dp.change', function(){

            var from_date = $('.datetimepicker1').val();

            $('#end_date_div').html('<label>End Date<span class="text-danger">*</span></label><input autocomplete="off" type="text" class="form-control datetimepicker1" name="deadline_date" id="deadline_date" value="" required="required">');

            $("#deadline_date" ).datetimepicker({

                   format: 'YYYY-MM-DD HH:ss',

                   useCurrent: true,

                   minDate: new Date(from_date)

               });

           });*/
           var date = new Date();
   var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
           $('#deadline_date,#closeing_date').datetimepicker({
            format: 'YYYY-MM-DD HH:ss',            
           useCurrent: true,                        
           minDate: today
            });
            $('#deadline_date').datetimepicker().on('dp.change', function (e) {
                var incrementDay = moment(new Date(e.date));
                incrementDay.add(1, 'days');
                $('#closeing_date').data('DateTimePicker').minDate(incrementDay);
                $(this).data("DateTimePicker").hide();
            });

            $('#closeing_date').datetimepicker().on('dp.change', function (e) {
                var decrementDay = moment(new Date(e.date));
                decrementDay.subtract(1, 'days');
                $('#deadline_date').data('DateTimePicker').maxDate(decrementDay);
                 $(this).data("DateTimePicker").hide();
            });


    });

    function showOrderAmount(str)

    {

        if(str == 'Open')

        {

            $('#show_late_div').show();

        }

        else if(str == 'Close')

        {

            $('#show_late_div').hide();

        }

        else

        {

            $('#show_late_div').hide();

        }

    }


</script>

