<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Macro's</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url().MODULE_NAME;?>macro">Macro's</a></li>
            <li class="active">Update Macro's</li>
        </ol>
    </section>
   <!-- Main content -->
    <section class="content">       
        <div class="box box-success">
            <div class="box-header">
                <div class="pull-left">
                    <h3 class="box-title">Update Macro's</h3>
                </div>
                <div class="pull-right box-tools">
                    <a href="<?php echo base_url().MODULE_NAME;?>macro" class="btn btn-info btn-sm">Back</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info" style="box-shadow: none; background-color: #dfe7f1;">
                        <div class="panel-heading" style="background-color: #bad59c; color: #22255a;">Macro's</div>
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
                                               <label>Macro's Name<span class="text-danger">*</span></label>
                                                <input name="macro_name" required="required" class="form-control" type="text" id="macro_name" placeholder="Enter Macro's name" value="<?php echo $macro_edit->macro_name; ?>" />
                								<?php echo form_error('macro_name','<span class="text-danger">','</span>'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <div class="input text">
                                                <label>Macro's Value<span class="text-danger">*</span></label>
                                                <select data-validation="required" name="macro_value_id[]" id="macro_value_id" class="selectpicker form-control checkData" multiple="multiple" data-show-subtext="true" data-live-search="true" >
                                                    <option value="">-- Select --</option>
                                                    <?php
                                                        $macro_value_res = $this->common_model->getData('tbl_macro_value', NULL, 'multi');
                                                        $macro_value_id_arr = explode(',',$macro_edit->macro_value_id);
                                                        if(!empty($macro_value_res)){
                                                            foreach($macro_value_res as $res){
                                                                ?>
                                                                <option <?php if(in_array($res->macro_value_id, $macro_value_id_arr)){ echo "selected"; } ?> value="<?php echo $res->macro_value_id; ?>"><?php echo $res->macro_value_name; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <div class="input text">
                                                <label>Status<span class="text-danger">*</span></label>
                                                <select name="macro_status" id="macro_status" class="form-control">    
                                                   	<option <?php if($macro_edit->macro_status == 1){echo "selected"; } ?> value="1">Active</option>
                									<option <?php if($macro_edit->macro_status == 0){echo "selected"; } ?> value="0">InActive</option>
                                                </select> 
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                                <!-- /.box-body -->      
                                <div class="box-footer">
                                   <button class="btn btn-success btn-sm" type="Submit" name="Submit" value="Edit" >Update</button>
                                    <a class="btn btn-danger btn-sm" href="<?php echo base_url().MODULE_NAME;?>macro">Cancel</a>
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