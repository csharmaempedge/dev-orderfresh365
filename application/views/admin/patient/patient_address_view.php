<aside class="right-side">







    <section class="content-header">







        <h1>Patient</h1>







        <ol class="breadcrumb">







            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>







            <li><a href="<?php echo base_url().MODULE_NAME;?>patient">Patient</a></li>







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







                    <a href="<?php echo base_url().MODULE_NAME;?>patient" class="btn btn-info btn-sm">Back</a>                           







                </div>







            </div>







            <div class="row">







                <div class="item form-group col-md-12">







                    <table class="table">







                      <tbody>







                        <?php 







                        $patient_res = $this->common_model->getData('tbl_user', array('user_id'=>$patient_id), 'single');







                        ?>







                          <tr>







                              <th style="color: #046c71" width="35%">Patient First Name</th>







                              <td style="color: #046c71"><?php echo !empty($patient_res->user_fname) ? $patient_res->user_fname : ''; ?></td>







                              <th style="color: #046c71" width="35%">Patient Last Name</th>







                              <td style="color: #046c71"><?php echo !empty($patient_res->user_lname) ? $patient_res->user_lname : ''; ?></td>







                          </tr>







                      </tbody>







                  </table>







              </div>







            </div>







            <br>







            <div class="row">







                <div class="col-md-12">







                    <div class="panel panel-info" style="box-shadow: none; background-color: #dfe7f1;">







                        <div class="panel-heading" style="background-color: #bad59c; color: #22255a;">Patient Address</div>







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







                                                              <th style="background-color: #007775; color: #fff;">Address </th>







                                                              <th style="background-color: #007775; color: #fff;">Set Route</th>







                                                              <th style="background-color: #007775; color: #fff;">Set Delivery Distance Amount</th>







                                                              <th style="background-color: #007775; color: #fff;">Approval</th>







                                                          </tr>







                                                      </thead>







                                                      <tbody>







                                                          <?php







                                                          $address_res = $this->common_model->getData('tbl_address', array('user_id'=>$patient_id, 'user_address !='=>'Pickup'), 'multi');







                                                          if(!empty($address_res))







                                                          {







                                                              $i = 1;







                                                              foreach ($address_res as $res) 







                                                              {







                                                                  ?>







                                                                  <tr>







                                                                      <td width="100px;"><?php echo  $i; ?></td>







                                                                      <td width="200px;"><?php echo $res->user_address; ?></td>







                                                                      <td width="350px;">







                                                                          <input type="text" data-validation="required" name="address_route_<?php echo $res->address_id; ?>" class="form-control" value="<?php echo (!empty($res->address_route)) ? $res->address_route : '0'; ?>">







                                                                      </td>







                                                                      <td width="300px;">







                                                                        <div class='input-group'>







                                                                            <span class="input-group-addon">







                                                                                $







                                                                            </span>







                                                                            <input type="text"  placeholder="0.00" type="text" required data-validation="number" data-validation-allowing="float" min="0"  name="distance_charge_<?php echo $res->address_id; ?>" class="form-control" value="<?php echo (!empty($res->distance_charge)) ? $res->distance_charge : '0'; ?>">







                                                                        </div>







                                                                      </td>







                                                                      <td width="200px;">







                                                                        <?php







                                                                        $address_approval_status = '';







                                                                        if($res->address_approval_status != 'Approved')







                                                                        {  







                                                                            echo $address_approval_status  .='<span title="Approve this address"  style="cursor: pointer;font-size: 15px;" onclick="approvedAddress('.$res->address_id.','.$patient_id.');" class="label label-danger fa-1x">Pending</span>';







                                                                            /*echo $approved_img = '<img width="40px"src="'.base_url().'webroot/address_img/not_approved.jpg'.'">';*/







                                                                        }   







                                                                        else







                                                                        {







                                                                            echo $address_approval_status  .='<span class="label label-success fa-1x" style="font-size: 15px;">Approved</span>';







                                                                            /*echo $approved_img = '<img width="40px"src="'.base_url().'webroot/address_img/approved.jpg'.'">';*/







                                                                        }







                                                                        ?>







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







                                    <div class="box-footer">







                                        <button class="btn btn-success btn-sm" type="submit" name="Submit" value="Edit" >Submit</button>







                                        <a class="btn btn-danger btn-sm" href="<?php echo base_url();?>admin/patient">Cancel</a>







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







  function approvedAddress(address_id, patient_id)







  {







      if(confirm('Are you sure you want to Approved this address?') === false){







          return false;







          }  







      var str = 'address_id='+address_id+'&patient_id='+patient_id;







      var PAGE = '<?php echo base_url().MODULE_NAME; ?>doctor/approvedAddress';







      $.ajax({







        type :"POST",







        url  :PAGE,







        data : str,







        success:function(data)







        {  







          location.reload();







          /*$('#milestone_done_sec_'+address_id).show();







          $('#milestone_pending_sec_'+address_id).hide();*/







        } 







      });







  }







    function assignEndDate(str)







    {







       $('#show_end_date').html('<input autocomplete="off" type="text" name="patient_macro_to_date" id="patient_macro_to_date" class="form-control date_val"><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>');







       min1 = new Date(str);







       min = new Date(str);







       var numberOfDaysToAdd = 0;







       min.setDate(min.getDate() + numberOfDaysToAdd);







       var dd = min.getDate();







       var mm = min.getMonth() + 1;







       var y = min.getFullYear();







       var aa = y+'-'+mm+'-'+dd;







       max = new Date(aa); 















       $( "#patient_macro_to_date" ).datepicker({ 







          minDate: min1,







          //maxDate: max,







          dateFormat : 'yy-mm-dd',







          changeMonth : true,







          changeYear : true,







       });







    }







</script>