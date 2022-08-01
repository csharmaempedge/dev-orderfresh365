<aside class="right-side">
    <section class="content-header">
        <h1>Assign Delivery Person</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url().MODULE_NAME;?>coupon">Assign Delivery Person</a></li>
            <li class="active"> Assign Delivery Person</li>
        </ol>
    </section>
    <section class="content">       
        <div class="box box-success">
            <div class="box-header">
                <div id="msg_div">
                    <?php echo $this->session->flashdata('message');?>
                </div>
                <div class="pull-right box-tools">
                    <a href="<?php echo base_url().MODULE_NAME;?>delivery" class="btn btn-info btn-sm">Back</a>                           
                </div>
            </div>
            <br> 
            <div class="row">
                <div class="item form-group col-md-12">
                    <table class="table">
                      <tbody>
                        <?php 
                        $delivery_person_res = $this->common_model->getData('tbl_delivery_person', array('delivery_person_id'=>$delivery_person_id), 'single');
                        ?>
                          <tr>
                              <th style="color: #046c71" width="35%">Delivery Person Name</th>
                              <td style="color: #046c71"><?php echo !empty($delivery_person_res->delivery_person_name) ? $delivery_person_res->delivery_person_name : ''; ?></td>
                              <th style="color: #046c71" width="35%">Delivery Person Address</th>
                              <td style="color: #046c71"><?php echo !empty($delivery_person_res->delivery_person_address) ? $delivery_person_res->delivery_person_address : ''; ?></td>
                          </tr>
                      </tbody>
                  </table>
              </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info" style="box-shadow: none; background-color: #dfe7f1;">
                        <div class="panel-heading" style="background-color: #bad59c; color: #22255a;">Assign Delivery Person</div>
                        <div class="panel-body">
                                <form action="" method="post" accept-charset="utf-8" enctype="multipart/form-data" id="login_form">
                                    <?php  $csrf = array( 'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash() ); ?>
                                    <input type="hidden" disabled name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                    <div class="box-body">
                                        <?php
                                         $delivery_person_assign_res = $this->common_model->getData('tbl_delivery_person_assign', array('delivery_person_id'=>$delivery_person_id, 'delivery_person_assign_status'=>1), 'multi');
                                         if(!empty($delivery_person_assign_res))
                                         {
                                            ?>
                                                <div class="row">
                                                  <div class="col-md-12">
                                                      <div class="table-responsive">
                                                          <table id="load_data" class="table table-bordered table-striped">
                                                              <thead>
                                                                  <tr class="label-primary1">
                                                                      <th style="background-color: #007775; color: #fff;">S. No.</th>
                                                                      <th style="background-color: #007775; color: #fff;">Address & Route</th>
                                                                      <th style="background-color: #007775; color: #fff;">Assign Date</th>
                                                                      <th style="background-color: #007775; color: #fff;">Remove</th>
                                                                  </tr>
                                                              </thead>
                                                              <tbody>
                                                                  <?php
                                                                  if(!empty($delivery_person_assign_res))
                                                                  {
                                                                      $i = 1;
                                                                      foreach ($delivery_person_assign_res as $res) 
                                                                      {
                                                                          ?>
                                                                          <tr id="remove_div_<?php echo $res->delivery_person_assign_id; ?>">
                                                                              <td width="100px;"><?php echo  $i; ?></td>
                                                                              <td width="200px;"><?php echo ' Route -  '.$res->address_route; ?></td>
                                                                              <td width="200px;"><?php echo !empty($res->delivery_person_assign_created_date) ? $res->delivery_person_assign_created_date : ''; ?></td>
                                                                              <td width="15px;">
                                                                                <button class="btn btn-danger btn-xs" type="button" onclick="removeDeliveryPerson('<?php echo $res->delivery_person_assign_id; ?>')"><i class="fa fa-trash"></i></button>
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
                                            <div class="form-group col-md-6">
                                                <div class="input text">
                                                    <label>Assign Address Route<span class="text-danger">*</span></label>
                                                    <select data-validation="required" name="address_route" id="address_route" class="form-control">
                                                       <option value="">-- Select --</option>
                                                       <?php
                                                          $address_res = $this->common_model->getData('tbl_address', array('address_approval_status'=>'Approved', 'address_route !='=>'0'), 'multi',NULL,NULL,NULL,'address_route');
                                                          if(!empty($address_res))
                                                          {
                                                            foreach ($address_res as $e_res) 
                                                            {
                                                                $delivery_person_assign_res = $this->common_model->getData('tbl_delivery_person_assign', array('address_route'=>$e_res->address_route), 'single');
                                                                if(empty($delivery_person_assign_res))
                                                                {
                                                                  ?>
                                                                    <option value="<?php echo $e_res->address_route; ?>"><?php echo ' Route - '.$e_res->address_route; ?></option>
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
                                        <a class="btn btn-danger btn-sm" href="<?php echo base_url();?>admin/delivery">Cancel</a>
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
    function removeDeliveryPerson(delivery_person_assign_id){
        var PAGE = '<?php echo base_url().MODULE_NAME; ?>delivery/removeDeliveryPerson/'+delivery_person_assign_id;        
        var str = 'delivery_person_assign_id='+delivery_person_assign_id+'&<?php echo $this->security->get_csrf_token_name(); ?>='+'<?php echo $this->security->get_csrf_hash(); ?>';
        $.ajax({
            url: PAGE,
            type: 'POST',
            data: str,
            success: function(response){                
                if(response){
                    $('#remove_div_'+delivery_person_assign_id).remove();
                }
                else{
                    $('#error_image_'+delivery_person_assign_id).html('Image removing faild please try again!')
                }
            }
        });
    }
</script>