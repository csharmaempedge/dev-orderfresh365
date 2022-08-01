<aside class="right-side">
    <section class="content-header">
        <h1>Product</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url().MODULE_NAME;?>product">Product</a></li>
            <li class="active"> Product Label</li>
        </ol>
    </section>
    <section class="content">       
        <div class="box box-success">
            <div class="box-header">
                <div class="pull-left">
                    <h3 class="box-title"> Product Label</h3>
                </div>
                <div class="pull-right box-tools">
                    <a href="<?php echo base_url().MODULE_NAME;?>product" class="btn btn-info btn-sm">Back</a>                           
                </div>
            </div>
            <div>
                <div id="msg_div">
                    <?php echo $this->session->flashdata('message');?>
                </div>
            </div>
            <div class="row">
                <div class="item form-group col-md-12">
                    <table class="table">
                      <tbody>
                        <?php 
                        $product_res = $this->common_model->getData('tbl_product', array('product_id'=>$product_id), 'single');
                        $category_res = $this->common_model->getData('tbl_category', array('category_id'=>$product_res->category_id), 'single');
                        ?>
                          <tr>
                              <th style="color: #046c71" width="35%">Product Name</th>
                              <td style="color: #046c71"><?php echo !empty($product_res->product_name) ? $product_res->product_name : ''; ?></td>
                              <th style="color: #046c71" width="35%">Category Name</th>
                              <td style="color: #046c71"><?php echo !empty($category_res->category_name) ? $category_res->category_name : ''; ?></td>
                          </tr>
                      </tbody>
                  </table>
              </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info" style="box-shadow: none; background-color: #dfe7f1;">
                        <div class="panel-heading" style="background-color: #bad59c; color: #22255a;">Product Label</div>
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
                                                              <th style="background-color: #007775; color: #fff;">Product Label</th>
                                                              <th style="background-color: #007775; color: #fff;">Macro Per Ounce </th>
                                                          </tr>
                                                      </thead>
                                                      <tbody>
                                                          <?php
                                                          $label_res = $this->common_model->getData('tbl_label', NULL, 'multi');
                                                          if(!empty($label_res))
                                                          {
                                                              $i = 1;
                                                              foreach ($label_res as $res) 
                                                              {
                                                                  $label_product_res = $this->common_model->getData('tbl_product_label_price', array('label_id'=>$res->label_id, 'product_id'=>$product_id), 'single');
                                                                  ?>
                                                                  <tr>
                                                                      <input type="hidden" name="label_id_<?php echo $res->label_id; ?>" id="label_id_<?php echo $res->label_id; ?>" value="<?php echo $res->label_id; ?>" >
                                                                      <td width="100px;"><?php echo  $i; ?></td>
                                                                      <td width="200px;"><?php echo $res->label_name; ?></td>
                                                                      <td width="350px;">
                                                                          <input name="label_amount_<?php echo $res->label_id; ?>" required data-validation="number" data-validation-allowing="float" min="0" class="form-control" type="text" id="label_amount" placeholder="Enter Price per ounce" value="<?php echo (!empty($label_product_res->label_amount)) ? $label_product_res->label_amount : '0'; ?>" />
                                                                          <span id="error_amount_msg" class="text-danger"></span>
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
                                        <a class="btn btn-danger btn-sm" href="<?php echo base_url();?>admin/product">Cancel</a>
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