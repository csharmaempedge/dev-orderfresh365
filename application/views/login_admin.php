<!DOCTYPE html>

<html lang="en">

    <head>

      <meta charset="utf-8">

      <meta http-equiv="X-UA-Compatible" content="IE=edge">

      <title>Circadian Food</title>

      <meta name="viewport" content="width=device-width, initial-scale=1">

      <meta name = "format-detection" content = "telephone=no">

      <!-- Latest compiled and minified CSS -->

      <link rel="stylesheet" href="<?php echo base_url(); ?>webroot/login/bootstrap.min.css">

      <!-- jQuery library -->

      <script src="<?php echo base_url(); ?>webroot/login/jquery.min.js"></script>

      <!-- Latest compiled JavaScript -->

      <script src="<?php echo base_url(); ?>webroot/login/bootstrap.min.js"></script>

      <style type="text/css">

        .login_form{

          border: 1px solid #ccc;

          margin-top: 0;

          padding: 40px 25px;

          border-radius: 6px;

          background: #fff;

        }

        .login_form .form-control{

          margin-bottom: 20px;

          height: 40px;

        }

        .sec_login{

          /*background: url(webroot/bg3.jpg);*/

          background: url(<?php echo base_url().'webroot/login_bg.jpg'; ?>);

          background-size: cover;

          background-position: center;

          background-repeat: no-repeat;

          min-height: 100vh;

          display: flex;

          align-items: center;

          justify-content: center;

          padding: 40px 15px;

        }

        .login_content_frame{

          display: flex;

          width: 100%;

          height: auto;

          position: relative;

          max-width: 350px;

          flex-direction: column;

        }

        .login_content{

          display: table-cell;

          /*margin-top: 30%;*/

          vertical-align: middle;

        }

        .login_form label{

          color: #22255a;

        }

         .login_h3{

        color: #22255a;

        text-align: center;

        font-weight: bold;

        margin: 0px;

        padding: 0;

      }

      .sec_login:before {

        content: "";

        position: absolute;

        left: 0;

        right: 0;

        top: 0;

        bottom: 0;

        background: rgb(0 0 0 / 72%);

      }

      h3.login_h3 img {

          max-width: 220px;

          width: 100% !important;

          margin-bottom: 30px;

      }

      form#login_form input.form-control {

        height: 50px;

        border: 1px solid #ddd;

        box-shadow: none;

      }

      button#Login {

          background: #f3a712;

          border: 1px solid #f3a712;

          display: block;

          width: 100%;

          height: 50px;

          font-size: 18px;

          text-transform: uppercase;

      }

      </style>

    </head>

    <body>

      <section class="sec_login">

        <div class="login_content_frame">

          <div class="login_content">

            <div class="login_form">

              <form action="<?php echo base_url(); ?>login/admin" method="post" id="login_form" accept-charset="utf-8">

                  <?php  $csrf = array( 'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash() ); ?>

                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

                <div id="msg_div">

                  <p style="color:red;font-weight:bold">

                    <?php echo $this->session->flashdata('message'); ?>

                  </p>

              </div>

                <h3 class="login_h3"><img width="300px;" src="<?php echo base_url(); ?>webroot/login/logo.png" alt=""></h3>

                <p style="border: 1px solid #fff;"></p>

                <label>Username</label>

                <input required type="text" name="user_name" id="user_name" placeholder="Username" class="form-control">

                  <?php echo form_error('user_name','<span class="text-danger">','</span>'); ?>

                <label>Password</label>

                <input required type="password" name="user_password" id="user_password" placeholder="Password" class="form-control">

                  <?php echo form_error('user_password','<span class="text-danger">','</span>'); ?>

                <button type="submit" name="Login" id="Login" value="Login" class="btn btn-primary btn-sm">Submit</button>

               <span class="pull-right" style="color:#22255a;">Don't have an account?<a href="<?php echo base_url(); ?>user" style="color:#22255a; cursor: pointer;">  Registration Now</a></span>

            </form>

            </div>

          </div>

        </div>

      </section>

      <script src="<?php echo base_url(); ?>webroot/plugins/jQuery/jquery-2.2.3.min.js"></script>

    <script src="<?php echo base_url();?>webroot/js/dataencrypt.js" type="text/javascript"></script>

    <script>

      $("#login_form").submit(function() 

      {

        var sh_pass = $('[name=user_password]').val();

        $('[name=user_password]').val(sha256(sh_pass));

      });



      $("#msg_div").fadeOut(7000);

      $("#err_msg").fadeOut(7000);

      $("#scue_msg").fadeOut(7000);

      

    </script>



    </body>

</html>