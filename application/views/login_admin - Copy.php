<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Meal Booking</title>
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
          border:1px solid #ccc;
          margin-top: 10px;
          padding: 20px;
          border-radius: 4px;
          background: rgb(39, 84, 162);
          box-shadow: 5px 10px 20px #635f5f;
        }
        .login_form .form-control{
          margin-bottom: 20px;
          height: 40px;
        }
        .sec_login{
          /*background: url(webroot/bg3.jpg);*/
          background: url(<?php echo base_url().'webroot/admin.png'; ?>);
          background-size: cover;
          background-position: top center;
          background-repeat: no-repeat;
          height: 100%;
        }
        .login_content_frame{
          display: table;
          width: 100%;
          height: 100vh;
        }
        .login_content{
          display: table-cell;
          /*margin-top: 30%;*/
          vertical-align: middle;
        }
        .login_form label{
          color: #fff;
        }
         .login_h3{
        color: #fff;
        text-align: center;
        font-weight: bold;
        margin: 0px;
        padding: 10px;
      }
      </style>
    </head>
    <body>
      <section class="sec_login">
        <div class="container">
          <div class="col-md-4 col-md-offset-4">
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
                    <h3 class="login_h3">Meal Booking</h3>
                    <p style="border: 1px solid #fff;"></p>
                    <label>Username</label>
                    <input required type="text" name="user_name" id="user_name" placeholder="Username" class="form-control">
                      <?php echo form_error('user_name','<span class="text-danger">','</span>'); ?>
                    <label>Password</label>
                    <input required type="password" name="user_password" id="user_password" placeholder="Password" class="form-control">
                      <?php echo form_error('user_password','<span class="text-danger">','</span>'); ?>
                    <button type="submit" name="Login" id="Login" value="Login" class="btn btn-default btn-sm">Submit</button>
                   <!-- <span class="pull-right" style="color:#fff; cursor: pointer;" data-toggle="modal" data-target="#forgot_model">Forgot password?</span> -->
                </form>
                </div>
              </div>
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