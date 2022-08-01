
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
   width: 48%;
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
        <h1> Mission Details</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url() . MODULE_NAME; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"> Mission View</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box box-success"> 
            <div class="box box-success">
                <div class="box-header">
                    <div id="msg_div">
                        <?php echo $this->session->flashdata('message'); ?>
                    </div>
                    <div class="pull-right box-tools">
                    <?php

                        $mission_count = $this->common_model->getData('cm_mission', NULL, 'count');
                        if ($mission_count < 5) 
                        {
                            ?>
                                 <a href="<?php echo base_url().MODULE_NAME;?>mission/addMission" class="btn btn-info btn-sm">Add New</a>              
                            <?php
                        }
                    ?>                
                    </div>
                </div>
                <br>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="load_Data" class="table table-bordered table-striped">
                    <thead>
                        <tr class="label-primary1">
                            <th style="background-color:  <?php echo THEME_COLOR;?>; color: #fff;">S.No.</th>
                            <th style="background-color:  <?php echo THEME_COLOR;?>; color: #fff;"> Cover Image</th>
                            <th style="background-color:  <?php echo THEME_COLOR;?>; color: #fff;"> Name</th>
                            <th style="background-color:  <?php echo THEME_COLOR;?>; color: #fff;"> Status</th>
                            <th style="background-color:  <?php echo THEME_COLOR;?>; color: #fff;">Action</th>
                            <!-- <th>Action</th> -->
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
<div id="myModal" class="modal fade" role="dialog">
</div>
<script type="text/javascript">
    $(document).ready(function() {
        //datatables
        table = $('#load_Data').DataTable({ 
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' servermside processing mode.
            "order": [], //Initial no order.
            "ordering": false, "searching": true,
            "ajax": {
                "url": "<?php echo base_url(MODULE_NAME.'mission/loadMissionListData')?>",
                "type": "POST",
                "dataType": "json",
                "data":{},
                "data": function ( data ) {
                data.filter_by = {'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'};
                },
                "dataSrc": function (jsonData) {
                  return jsonData.data;
                }
            },
        });
            $('#search_btn').on('click' , function(){
           table.ajax.reload(); 
         });
    });

    function getFullSizePic(Imgurl){
        document.getElementById('myModal').innerHTML ='<div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Mission</h4></div><div class="modal-body"><img src ="'+Imgurl+'" style="width:100%;height:100%"></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div></div></div>"';
    }

    function  activeStatus(mission_id)
    {
        var str = 'mission_id='+mission_id+'&<?php echo $this->security->get_csrf_token_name(); ?>='+'<?php echo $this->security->get_csrf_hash(); ?>';
        var PAGE = '<?php echo base_url().MODULE_NAME; ?>mission/activeStatus';
        jQuery.ajax({
            type :"POST",
            url  :PAGE,
            data : str,
            success:function(data)
            {        
            } 
        });
    }  

     function  inActiveStatus(mission_id)
    {
        var str = 'mission_id='+mission_id+'&<?php echo $this->security->get_csrf_token_name(); ?>='+'<?php echo $this->security->get_csrf_hash(); ?>';
        var PAGE = '<?php echo base_url().MODULE_NAME; ?>mission/inActiveStatus';
        jQuery.ajax({
            type :"POST",
            url  :PAGE,
            data : str,
            success:function(data)
            {        
            } 
        });
    } 
</script>