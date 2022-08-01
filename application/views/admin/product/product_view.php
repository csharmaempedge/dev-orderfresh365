

<style>

.switch {

  position: relative;

  display: inline-block;

  width: 60px;

  height: 34px;

}



.switch input {display:none;}



.slider {

  position: absolute;

  cursor: pointer;

  top: 0;

  left: 0;

  right: 0;

  bottom: 0;

  background-color: #ccc;

  -webkit-transition: .4s;

  transition: .4s;

   width: 47%;

}



.slider:before {

  position: absolute;

  content: "";

  height: 26px;

  width: 26px;

  left: 4px;

  bottom: 4px;

  background-color: white;

  -webkit-transition: .4s;

  transition: .4s;



}



input:checked + .slider {

  background-color: #8bd040;

}



input:focus + .slider {

  box-shadow: 0 0 1px #8bd040;

}



input:checked + .slider:before {

  -webkit-transform: translateX(26px);

  -ms-transform: translateX(26px);

  transform: translateX(26px);

}



/* Rounded sliders */

.slider.round {

  border-radius: 34px;

}



.slider.round:before {

  border-radius: 50%;

}

</style>

<aside class="right-side">

    <!-- Content Header (Page header) -->

    <section class="content-header">

        <h1>Product Details</h1>

        <ol class="breadcrumb">

            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>

            <li class="active">Product</li>

        </ol>

    </section>   

    <!-- Main content -->

    <section class="content">       

        <div class="box box-success">

            <div class="box-header">

                <div id="msg_div">

                    <?php echo $this->session->flashdata('message');?>

                </div>

                <div class="pull-right box-tools">

                    <?php

                        if($myobj->checkAddPermission())

                        {

                            ?>

                                <a href="<?php echo base_url().MODULE_NAME;?>product/addProduct" class="btn btn-info btn-sm">Add New</a>              

                            <?php

                        }

                    ?>                    

                </div>

            </div>      

            <br>     

            <!-- /.box-header -->

            <div class="box-body">
                <div class="row">
                    <div class="form-group col-md-4">
                       <div class="input text">
                            <label>Category List</label>
                            <select name="category_id" id="category_id" class="form-control" >
                                <option value="">--select --</option>
                            <?php
                                $category_res = $this->common_model->getData('tbl_category', array('category_status'=>1), 'multi');
                                if(!empty($category_res)){
                                    foreach($category_res as $c_res){
                                        ?>
                                        <option value="<?php echo $c_res->category_id; ?>"><?php echo $c_res->category_name; ?></option>
                                        <?php
                                    }
                                }
                            ?>
                            </select>
                       </div>
                    </div>
                    <div class="form-group col-md-4">
                       <div class="input text">
                            <label>Status</label>
                            <select name="product_status" id="product_status" class="form-control"> 
                                <option value="">--select --</option>   
                                <option value="1">Active</option>
                                <option value="0">InActive</option>
                            </select> 
                       </div>
                    </div>
                    <div class="form-group col-md-4">
                       <div class="input text">
                            <button style="margin-top: 30px;" class="btn btn-success btn-sm search-btn" id="search_btn">FILTER</button>
                       </div>
                    </div>
                </div>
                <div class="table-responsive">

                    <table id="load_productlist" class="table table-bordered table-striped">

                        <thead>

                            <tr class="label-primary1">

                                <th width="45px;" style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">S.No.</th>

                								<th width="200px;" style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Product Name</th>

                                <th width="200px;" style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Category Name</th>

                								<th width="106Px;" style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Status</th>

                                <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Set Label</th>

                								<th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Action</th>

                            </tr>

                        </thead>

                        <tbody>

                            

                        </tbody>

                    </table>

                </div>

            </div>

            <!-- /.box-body -->

        </div>

        <!-- /.box -->

    </section>

    <!-- /.content -->

</aside>

<!-- /.right-side -->

<script type="text/javascript">

    $(document).ready(function() {

        //datatables

        table = $('#load_productlist').DataTable({ 

            "processing": true, //Feature control the processing indicator.

            "serverSide": true, //Feature control DataTables' servermside processing mode.

            "searching": true, //Feature control DataTables' servermside processing mode.

            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source

            "ajax": {

                "url": "<?php echo base_url(MODULE_NAME.'product/loadProductListData')?>",

                "type": "POST",

                "dataType": "json",

                "data":{},
                "data": function ( data ) {
                data.filter_by = {'category_id':$('#category_id').val(),'product_status':$('#product_status').val(), '<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'};
                },

                "dataSrc": function (jsonData) {

                  return jsonData.data;

                }

            },            

            //Set column definition initialisation properties.

            "columnDefs": [

            { 

                "targets": [0], //first column / numbering column

                "orderable": false, //set not orderable

            }],

        });
        $('#search_btn').on('click' , function(){
           table.ajax.reload(); 
         });

    });



    function  activeStatus(product_id)

    {

        var str = 'product_id='+product_id+'&<?php echo $this->security->get_csrf_token_name(); ?>='+'<?php echo $this->security->get_csrf_hash(); ?>';

        var PAGE = '<?php echo base_url().MODULE_NAME; ?>product/activeStatus';

        jQuery.ajax({

            type :"POST",

            url  :PAGE,

            data : str,

            success:function(data)

            {        

                 /*$("#message_dynamic").show();

                    $("#message_dynamic").html(data);

                    setTimeout(function(){

                        $("#message_dynamic").hide();

                  }, 1000);*/

            } 

        });

    }  



     function  inActiveStatus(product_id)

    {

        var str = 'product_id='+product_id+'&<?php echo $this->security->get_csrf_token_name(); ?>='+'<?php echo $this->security->get_csrf_hash(); ?>';

        var PAGE = '<?php echo base_url().MODULE_NAME; ?>product/inActiveStatus';

        jQuery.ajax({

            type :"POST",

            url  :PAGE,

            data : str,

            success:function(data)

            {        

                 /*$("#message_dynamic").show();

                    $("#message_dynamic").html(data);

                    setTimeout(function(){

                        $("#message_dynamic").hide();

                  }, 1000);*/

            } 

        });

    } 

</script>