<aside class="right-side">
    <section class="content-header">
        <h1>Role</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Role</li>
        </ol>
    </section>   
    <section class="content">       
        <div class="box box-success">
            <div class="box-header">               
                <div class="pull-right box-tools">
                    <?php
                        if($myobj->checkAddPermission()){
                           ?>
                                <a href="<?php echo base_url().MODULE_NAME;?>role/addRole" class="btn btn-info btn-sm">Add New</a>              
                            <?php
                        }
                    ?>                    
                </div>
            </div>           
            <div class="box-body"><br>
                <div id="msg_div">
                    <?php echo $this->session->flashdata('message');?>
                </div>
               <div class="table-responsive">
                    <table id="load_rolelist" class="table table-bordered table-striped">
                        <thead>
                            <tr class="label-primary1">
                                <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">S. No.</th>
                                <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Role Name</th>
                                <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Status</th>
                                <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</aside>
<script type="text/javascript">

    $(document).ready(function() {
        //datatables
        $('#load_rolelist').DataTable({ 
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' servermside processing mode.
            "order": [], //Initial no order.
            "ordering": false, "searching": false,
            "ajax": {
                "url": "<?php echo base_url(MODULE_NAME.'role/loadRoleListData')?>",
                "type": "POST",
                "dataType": "json",
                "data":{},
                "data": function ( data ) {
                data.filter_by = {'center_id':$('#center_id').val(),'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'};
                },
                "dataSrc": function (jsonData) {
                  return jsonData.data;
                }
            },
        });
    });
</script>