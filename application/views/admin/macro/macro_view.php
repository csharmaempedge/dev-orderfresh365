
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
   width: 29%;
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
        <h1>Macro's Details</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Macro's</li>
        </ol>
    </section>   
    <!-- Main content -->
    <section class="content">       
        <div class="box box-success">
            <div class="box-header">
                <div class="pull-right box-tools">
                    <!-- <?php
                        if($myobj->checkAddPermission())
                        {
                            ?>
                                <a href="<?php echo base_url().MODULE_NAME;?>macro/addMacro" class="btn btn-info btn-sm">Add New</a>              
                            <?php
                        }
                    ?> -->                    
                </div>
            </div>           
            <!-- /.box-header -->
            <div class="box-body"><br>
                <div>
                    <div id="msg_div">
                        <?php echo $this->session->flashdata('message');?>
                    </div>
                </div>  
                <div>
                    <div id="message_dynamic">
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="load_macrolist" class="table table-bordered table-striped">
                        <thead>
                            <tr class="label-primary1">
                                <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">S.No.</th>
								<th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Macro Name</th>
								<th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Status</th>
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
        $('#load_macrolist').DataTable({ 
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' servermside processing mode.
            "searching": true, //Feature control DataTables' servermside processing mode.
            "order": [], //Initial no order.
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo base_url(MODULE_NAME.'macro/loadMacroListData')?>",
                "type": "POST",
                "dataType": "json",
                "data":{'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'},
                "dataSrc": function (jsonData) {
                  return jsonData.data;
                }
            },            
            //Set column definition initialisation properties.
            "columnDefs": [
            { 
                "targets": [0,3], //first column / numbering column
                "orderable": false, //set not orderable
            }],
        });
    });

    function  activeStatus(macro_id)
    {
        var str = 'macro_id='+macro_id+'&<?php echo $this->security->get_csrf_token_name(); ?>='+'<?php echo $this->security->get_csrf_hash(); ?>';
        var PAGE = '<?php echo base_url().MODULE_NAME; ?>macro/activeStatus';
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

     function  inActiveStatus(macro_id)
    {
        var str = 'macro_id='+macro_id+'&<?php echo $this->security->get_csrf_token_name(); ?>='+'<?php echo $this->security->get_csrf_hash(); ?>';
        var PAGE = '<?php echo base_url().MODULE_NAME; ?>macro/inActiveStatus';
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