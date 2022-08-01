<style type="text/css">
    img{
    max-width:120px;
    }
    input[type=file]{
    padding:10px;}
</style>
<aside class="right-side">
    <section class="content-header">
        <h1>Product</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo base_url().MODULE_NAME;?>product">Product</a></li>
            <li class="active">View Product </li>
        </ol>
    </section>
    <section class="content">       
        <div class="box box-success">
            <div class="box-header">
                <div class="pull-left">
                    <h3 class="box-title">View Product </h3>
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
                            <form action="" method="post" accept-charset="utf-8" enctype="multipart/form-data" id="checkFiletype">
                                <?php  $csrf = array( 'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash() ); ?>
                                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                <div class="box-body">
                                    <div>
                                        <div id="msg_div">
                                            <?php echo $this->session->flashdata('message');?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <div class="input text">
                                                <label> Name</label>
                                                <input disabled class="form-control" type="text" value="<?php echo $product_edit->product_name; ?>" />
                                            </div>
                                        </div>
                                        <div class="item form-group col-md-6">
                                            <div class="input text">
                                                <label>Price per Ounce </label>
                                                <input disabled class="form-control" type="number" placeholder="Enter Price per Ounce" value="<?php echo $product_edit->product_price; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <div class="input text">
                                                <label> Category</label>
                                                <?php
                                                    $parent_category = $this->common_model->getData('tbl_category', array('category_id'=>$product_edit->category_id), 'single');
                                                ?>  
                                                <input class="form-control" type="text" disabled value="<?php echo (!empty($parent_category->category_name)) ? $parent_category->category_name : ''; ?>">     
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6" id="breakfast_type_div" style="<?php if($product_edit->category_id != '4' ){ echo 'display:none'; }else{ echo 'display:block'; } ?>">
                                            <div class="input text">
                                                <label>Breakfast Type<span class="text-danger">*</span></label>
                                                <input disabled class="form-control" type="text" value="<?php echo ($product_edit->breakfast_type == 'Protien') ? 'Protien' : 'Other'; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <div class="input text">
                                                <label> Status</label>
                                                <input disabled class="form-control" type="text" value="<?php echo ($product_edit->product_status == '1') ? 'Active' : 'Inactive'; ?>" />
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Ordered Plus (Percentage)</label>
                                            <div class='input-group'>
                                                <input disabled type="text" min="0"  class="form-control" value="<?php echo $product_edit->product_plus_percentage; ?>">
                                                <span class="input-group-addon">
                                                    %
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Product Raw Amount</label><small> (Minimum value 1)</small>
                                            <div class="input text">
                                                <input disabled type="text" min="1" name="product_row_amount" class="form-control" value="<?php echo $product_edit->product_row_amount; ?>">

                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Number of portions</label>
                                            <div class="input text">
                                                <input disabled type="text"  class="form-control" value="<?php echo $product_edit->no_of_portions; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="item form-group col-md-6">
                                            <div class="input text">
                                               <label>Product Label Print Name</label>
                                                <input disabled class="form-control" type="text" id="product_label_print_name" placeholder="Enter Product Label Print Name" value="<?php echo $product_edit->product_label_print_name; ?>" />
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="box-footer">
                                        <a class="btn btn-danger btn-sm" href="<?php echo base_url().MODULE_NAME;?>product">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>