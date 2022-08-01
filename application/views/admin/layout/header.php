<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>CIRCADIAN FOOD</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="<?php echo base_url(); ?>webroot/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>webroot/css/jquery-ui.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>webroot/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>webroot/plugins/fullcalendar/fullcalendar.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>webroot/plugins/fullcalendar/fullcalendar.print.css" media="print">
        <link rel="stylesheet" href="<?php echo base_url(); ?>webroot/plugins/timepicker/bootstrap-timepicker.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>webroot/css/AdminLTE.min.css">
        <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>webroot/css/skin-blue.css"> -->
        <?php require 'application/views/admin/layout/skin_blue.php'; ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>webroot/css/custom.css">
        <script src="<?php echo base_url(); ?>webroot/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url();?>webroot/css/bootstrap-select.min.css" />
        <link rel="stylesheet" href="<?php echo base_url();?>webroot/plugins/datatables/dataTables.bootstrap.css">
        <link rel="stylesheet" href="<?php echo base_url();?>webroot/js/tagit/bootstrap-tagsinput.css">
        <script src="<?php echo base_url();?>webroot/js/tagit/bootstrap-tagsinput.min.js"></script>
        <script src="<?php echo base_url();?>webroot/js/ajax_jquery.min.js" type="text/javascript"></script>
        <link rel="stylesheet" href="<?php echo base_url();?>webroot/calendar/jquery-ui.css"> 
        <link rel="stylesheet" href="<?php echo base_url();?>webroot/css/app.css">
        <link href="<?php echo base_url();?>webroot/css/summernote-bs4.css" rel="stylesheet">
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
        <link href="<?php echo base_url();?>webroot/css/toster.min.css" rel="stylesheet" />
        <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
        <script
          src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBRzUFxKZlyVppkwsQEYqo3wPLqQw5W1SY&callback=initAutocomplete&libraries=places&v=weekly"
          async
        ></script>
        <style type="text/css">
            .textarea_view{
                background-color: #eee;
                border: 1px solid #eee;
                padding: 5px;
                display:inline-block;
                width: 100%
            }
            #map {
                  height: 320px;
                  width: 100%;
                }
        </style>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                <a href="<?php echo base_url().MODULE_NAME; ?>dashboard" class="logo"><img width="120px;" src="<?php echo base_url(); ?>webroot/login/logo.png" alt=""></a>
                <nav class="navbar navbar-static-top">
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <h3 style="margin: 0px auto; text-align: center; width: auto; float: left; padding: 10px; color: #22255a; ">CIRCADIAN FOOD</h3>
                    <?php
                    if($role_id == '4')
                    {
                        $sess=$this->session->all_userdata();
                        if(!empty($sess['back_to_admin']))
                        {
                            if($sess['back_to_admin'])
                            {
                                ?>
                                <span  style="margin: 0px 0px 0px 400px; text-align: center; width: auto; float: left; padding: 10px; ">
                                   <a class="btn btn-warning btn-sm" href="<?php echo base_url(); ?>admin/patient/backToAdmin/<?php echo $sess['back_to_admin']; ?>">Back To Portal</a>
                                </span>
                                <?php
                             }

                        }

                    }
                  ?>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <?php
                            if($role_id == '4')
                            {
                                $cart_res = $this->common_model->getData('tbl_cart', array('patient_id'=>$user_id,'qty !='=>0), 'count',NULL,NULL,NULL, 'unique_no');
                                if($cart_res != '0')
                                {
                                    ?>
                                    <li class="dropdown notifications-menu">
                                        <a class="msg-notification-list" href="<?php echo base_url();?>admin/cart ">
                                          <i class="fa fa-shopping-cart"></i>
                                          <span class="label label-danger"><?php echo
                                          $cart_res; ?></span>
                                        </a>
                                      </li> 
                                    <?php
                                }
                            }
                            ?>
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <span class=""><img width="28px;" src="<?php echo base_url(); ?>webroot/upload/admin/users/user.png" alt=""></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="user-header">
                                        <p><?php echo $user_name; ?></p>
                                    </li>
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="<?php echo base_url().MODULE_NAME; ?>profile/index" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="<?php echo base_url(); ?>login/logout" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>