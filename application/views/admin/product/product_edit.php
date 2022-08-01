<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Product</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url().MODULE_NAME;?>product">Product</a></li>
            <li class="active">Update Product</li>
        </ol>
    </section>
   <!-- Main content -->
    <section class="content">       
        <div class="box box-success">
            <div class="box-header">
                <div class="pull-left">
                    <h3 class="box-title">Update Product</h3>
                </div>
                <div class="pull-right box-tools">
                    <a href="<?php echo base_url().MODULE_NAME;?>product" class="btn btn-info btn-sm">Back</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info" style="box-shadow: none; background-color: #dfe7f1;">
                        <div class="panel-heading" style="background-color: #bad59c; color: #22255a;">Product</div>
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
                                        <div class="item form-group col-md-6">
                                            <div class="input text">
                                               <label>Product Name<span class="text-danger">*</span></label>
                                                <input name="product_name" required="required" class="form-control" type="text" id="product_name" placeholder="Enter Product name" value="<?php echo $product_edit->product_name; ?>" />
                								<?php echo form_error('product_name','<span class="text-danger">','</span>'); ?>
                                            </div>
                                        </div>
                                        <div class="item form-group col-md-6">
                                            <div class="input text">
                                                <label>Price per Ounce <span class="text-danger">*</span></label>
                                                <input name="product_price"  required data-validation="number" data-validation-allowing="float" min="0" class="form-control" type="text" id="product_price" placeholder="0.00" value="<?php echo $product_edit->product_price; ?>" />
                                                <span id="error_amount_msg" class="text-danger"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <div class="input text">
                                                <label> Category</label>
                                                <select onchange="showBreakfastType(this.value)" data-validation="required" name="category_id" id="category_id" class="form-control">    
                                                    <option value="">-- Select --</option>
                                                    <?php
                                                        $category_res= $this->common_model->getData('tbl_category', array('category_status'=>1), 'multi');
                                                            foreach ($category_res as $ct_res) 
                                                            {
                                                                ?>
                                                                    <option <?php if($ct_res->category_id == $product_edit->category_id){ echo "selected"; } ?> value="<?php echo $ct_res->category_id; ?>"><?php echo $ct_res->category_name; ?></option>
                                                                <?php 
                                                            } 
                                                    ?>
                                                </select>    
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6" id="breakfast_type_div" style="<?php if($product_edit->category_id != '4' ){ echo 'display:none'; }else{ echo 'display:block'; } ?>">
                                            <div class="input text">
                                                <label>Breakfast Type<span class="text-danger">*</span></label>
                                                <select name="breakfast_type" id="breakfast_type" class="form-control">    
                                                    <option <?php if($product_edit->breakfast_type == 'Protien'){echo "selected"; } ?> value="Protien">Protien</option>
                                                    <option <?php if($product_edit->breakfast_type == 'Other'){echo "selected"; } ?> value="Other">Other</option>
                                                </select> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <div class="input text">
                                                <label>Status<span class="text-danger">*</span></label>
                                                <select name="product_status" id="product_status" class="form-control">    
                                                   	<option <?php if($product_edit->product_status == 1){echo "selected"; } ?> value="1">Active</option>
                									<option <?php if($product_edit->product_status == 0){echo "selected"; } ?> value="0">InActive</option>
                                                </select> 
                                            </div>
                                        </div> 
                                        <div class="form-group col-md-6">
                                            <label>Ordered Plus (Percentage)<span class="text-danger">*</span></label>
                                            <div class='input-group'>
                                                <input required data-validation="custom" data-validation-regexp="^([0-9]+)$" autocomplete="off" type="text" min="0" name="product_plus_percentage" class="form-control" value="<?php echo $product_edit->product_plus_percentage; ?>">
                                                <span class="input-group-addon">
                                                    %
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Product Raw Amount<span class="text-danger">*</span></label><small> (Minimum value 1)</small>
                                            <div class="input text">
                                                <input required data-validation="number" data-validation-allowing="float" autocomplete="off" type="text" min="1" name="product_row_amount" class="form-control" value="<?php echo $product_edit->product_row_amount; ?>">

                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Number of portions<span class="text-danger">*</span></label>
                                            <div class="input text">
                                                <input required data-validation="number" data-validation-allowing="float" autocomplete="off" type="text" min="0" name="no_of_portions" class="form-control" value="<?php echo $product_edit->no_of_portions; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="item form-group col-md-6">
                                            <div class="input text">
                                               <label>Product Label Print Name<span class="text-danger">*</span></label>
                                                <input maxlength="25" name="product_label_print_name" required="required" class="form-control" type="text" id="product_label_print_name" placeholder="Enter Product Label Print Name" value="<?php echo $product_edit->product_label_print_name; ?>" />
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <!-- /.box-body -->      
                                <div class="box-footer">
                                   <button class="btn btn-success btn-sm" type="Submit" name="Submit" value="Edit" >Update</button>
                                    <a class="btn btn-danger btn-sm" href="<?php echo base_url().MODULE_NAME;?>product">Cancel</a>
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
    function showBreakfastType(str) 
    {
        if(str == '4')
        {
            $('#breakfast_type_div').show();
        }
        else
        {
            $('#breakfast_type_div').hide();
        }
    }
</script>