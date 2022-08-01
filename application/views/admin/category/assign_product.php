<aside class="right-side">
    <section class="content-header">
        <h1>Assign Veggies & Carb</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url().MODULE_NAME;?>category">Assign Veggies & Carb</a></li>
            <li class="active"> Assign Veggies & Carb</li>
        </ol>
    </section>
    <section class="content">       
        <div class="box box-success">
            <div class="box-header">
                <div id="msg_div">
                    <?php echo $this->session->flashdata('message');?>
                </div>
                <div class="pull-right box-tools">
                  <?php
                  if($slug_type == 'product')
                  {
                    ?>
                    <a href="<?php echo base_url().MODULE_NAME;?>product" class="btn btn-info btn-sm">Back</a>
                    <?php
                  }
                  else
                  {
                    ?>
                    <a href="<?php echo base_url().MODULE_NAME;?>category/productList/<?php echo $category_id; ?>" class="btn btn-info btn-sm">Back</a>
                    <?php
                  }
                  ?>                           
                </div>
            </div>
            <br> 
            <div class="row">
                <div class="item form-group col-md-12">
                    <table class="table">
                      <tbody>
                        <?php 
                        $category_res = $this->common_model->getData('tbl_category', array('category_id'=>$category_id), 'single');
                        $product_res = $this->common_model->getData('tbl_product', array('product_id'=>$product_id), 'single');
                        ?>
                          <tr>
                              <th style="color: #046c71" width="35%">Category Name</th>
                              <td style="color: #046c71"><?php echo !empty($category_res->category_name) ? $category_res->category_name : ''; ?></td>
                              <th style="color: #046c71" width="35%">Product Name</th>
                              <td style="color: #046c71"><?php echo !empty($product_res->product_name) ? $product_res->product_name : ''; ?></td>
                          </tr>
                      </tbody>
                  </table>
              </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info" style="box-shadow: none; background-color: #dfe7f1;">
                        <div class="panel-heading" style="background-color: #bad59c; color: #22255a;">Assign Veggies & Carb</div>
                        <div class="panel-body">
                                <form action="" method="post" accept-charset="utf-8" enctype="multipart/form-data" id="login_form">
                                    <?php  $csrf = array( 'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash() ); ?>
                                    <input type="hidden" disabled name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                    <div class="box-body">
                                      <div class="row">
                                        <div class="col-md-6">
                                          <div class="form-group col-md-12">
                                            <div class="input text">
                                                <label>Assign Veggies<span class="text-danger">*</span></label>
                                                <select data-validation="required" name="veggies_id[]" id="veggies_id" multiple="multiple" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                                                   <option value="">-- Select --</option>
                                                   <?php
                                                      $veggies_res = $this->common_model->getData('tbl_product', array('category_id'=>3), 'multi');
                                                      if(!empty($veggies_res))
                                                      {
                                                        foreach ($veggies_res as $v_res) 
                                                        {
                                                            $assign_veggies_res = $this->common_model->getData('tbl_product_wise_veggies', array('product_id'=>$product_id, 'assign_product_id'=>$v_res->product_id), 'single');
                                                            if(empty($assign_veggies_res))
                                                            {
                                                              ?>

                                                              <option value="<?php echo $v_res->product_id; ?>"><?php echo $v_res->product_name; ?></option>
                                                              <?php

                                                            }
                                                        }
                                                      }
                                                    ?>
                                               </select>
                                            </div>
                                          </div>
                                          <div class="form-group col-md-12">
                                            <?php
                                             $assign_veggies_res = $this->common_model->getData('tbl_product_wise_veggies', array('product_id'=>$product_id,'macro_id'=>'3'), 'multi');
                                             if(!empty($assign_veggies_res))
                                             {
                                                ?>
                                                    <div class="row">
                                                      <div class="col-md-12">
                                                          <div class="table-responsive">
                                                              <table id="load_data" class="table table-bordered table-striped" style="background-color: #ffffff;">
                                                                  <thead>
                                                                      <tr class="label-primary1">
                                                                          <th style="background-color: #007775; color: #fff;">S. No.</th>
                                                                          <th style="background-color: #007775; color: #fff;">Veggies Name</th>
                                                                          <th style="background-color: #007775; color: #fff;">Remove</th>
                                                                      </tr>
                                                                  </thead>
                                                                  <tbody>
                                                                      <?php
                                                                      if(!empty($assign_veggies_res))
                                                                      {
                                                                          $i = 1;
                                                                          foreach ($assign_veggies_res as $v_res) 
                                                                          {
                                                                              $product_res = $this->common_model->getData('tbl_product', array('product_id'=>$v_res->assign_product_id), 'single');
                                                                              ?>
                                                                              <tr id="remove_div_<?php echo $v_res->product_veggies_id; ?>">
                                                                                  <td width="100px;"><?php echo  $i; ?></td>
                                                                                  <td width="200px;"><?php echo $product_res->product_name; ?></td>
                                                                                  <td width="15px;">
                                                                                    <button class="btn btn-danger btn-xs" type="button" onclick="removeVeggies('<?php echo $v_res->product_veggies_id; ?>')"><i class="fa fa-trash"></i></button>
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
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group col-md-12">
                                            <div class="input text">
                                                <label>Assign Carb<span class="text-danger">*</span></label>
                                                <select data-validation="required" name="carb_id[]" id="carb_id" multiple="multiple" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                                                   <option value="">-- Select --</option>
                                                   <?php
                                                      $carb_res = $this->common_model->getData('tbl_product', array('category_id'=>2), 'multi');
                                                      if(!empty($carb_res))
                                                      {
                                                        foreach ($carb_res as $c_res) 
                                                        {
                                                            $assign_carb_res = $this->common_model->getData('tbl_product_wise_veggies', array('product_id'=>$product_id, 'assign_product_id'=>$c_res->product_id), 'single');
                                                            if(empty($assign_carb_res))
                                                            {
                                                              ?>

                                                              <option value="<?php echo $c_res->product_id; ?>"><?php echo $c_res->product_name; ?></option>
                                                              <?php

                                                            }
                                                        }
                                                      }
                                                    ?>
                                               </select>
                                            </div>
                                          </div>
                                          <div class="form-group col-md-12">
                                            <?php
                                             $assign_carb_res = $this->common_model->getData('tbl_product_wise_veggies', array('product_id'=>$product_id,'macro_id'=>'2'), 'multi');
                                             if(!empty($assign_carb_res))
                                             {
                                                ?>
                                                    <div class="row">
                                                      <div class="col-md-12">
                                                          <div class="table-responsive">
                                                              <table id="load_data" class="table table-bordered table-striped" style="background-color: #ffffff;">
                                                                  <thead>
                                                                      <tr class="label-primary1">
                                                                          <th style="background-color: #007775; color: #fff;">S. No.</th>
                                                                          <th style="background-color: #007775; color: #fff;">Carb Name</th>
                                                                          <th style="background-color: #007775; color: #fff;">Remove</th>
                                                                      </tr>
                                                                  </thead>
                                                                  <tbody>
                                                                      <?php
                                                                      if(!empty($assign_carb_res))
                                                                      {
                                                                          $i = 1;
                                                                          foreach ($assign_carb_res as $v_res) 
                                                                          {
                                                                              $product_res = $this->common_model->getData('tbl_product', array('product_id'=>$v_res->assign_product_id), 'single');
                                                                              ?>
                                                                              <tr id="remove_div_carb_<?php echo $v_res->product_veggies_id; ?>">
                                                                                  <td width="100px;"><?php echo  $i; ?></td>
                                                                                  <td width="200px;"><?php echo $product_res->product_name; ?></td>
                                                                                  <td width="15px;">
                                                                                    <button class="btn btn-danger btn-xs" type="button" onclick="removeCarb('<?php echo $v_res->product_veggies_id; ?>')"><i class="fa fa-trash"></i></button>
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
                                          </div>
                                        </div>
                                      </div>
                                        
                                    </div>
                                    <div class="box-footer">
                                        <button class="btn btn-success btn-sm" type="submit" name="Submit" value="Edit" >Assign</button>
                                        <?php
                                        if($slug_type == 'product')
                                        {
                                          ?>
                                           <a class="btn btn-danger btn-sm" href="<?php echo base_url();?>admin/product">Cancel</a>
                                          <?php
                                        }
                                        else
                                        {
                                          ?>
                                           <a class="btn btn-danger btn-sm" href="<?php echo base_url();?>admin/category/productList/<?php echo $category_id; ?>">Cancel</a>
                                          <?php
                                        }
                                        ?>  
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
    function removeVeggies(product_veggies_id){
        var PAGE = '<?php echo base_url().MODULE_NAME; ?>category/removeVeggies/'+product_veggies_id;        
        var str = 'product_veggies_id='+product_veggies_id+'&<?php echo $this->security->get_csrf_token_name(); ?>='+'<?php echo $this->security->get_csrf_hash(); ?>';
        $.ajax({
            url: PAGE,
            type: 'POST',
            data: str,
            success: function(response){                
                if(response){
                    $('#remove_div_'+product_veggies_id).remove();
                }
                else{
                    $('#error_image_'+product_veggies_id).html('Image removing faild please try again!')
                }
            }
        });
    }
    function removeCarb(product_veggies_id){
        var PAGE = '<?php echo base_url().MODULE_NAME; ?>category/removeVeggies/'+product_veggies_id;        
        var str = 'product_veggies_id='+product_veggies_id+'&<?php echo $this->security->get_csrf_token_name(); ?>='+'<?php echo $this->security->get_csrf_hash(); ?>';
        $.ajax({
            url: PAGE,
            type: 'POST',
            data: str,
            success: function(response){                
                if(response){
                    $('#remove_div_carb_'+product_veggies_id).remove();
                }
                else{
                    $('#error_image_'+product_veggies_id).html('Image removing faild please try again!')
                }
            }
        });
    }
</script>