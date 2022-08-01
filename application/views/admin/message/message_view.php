
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Message Details</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Message</li>
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
                                <a href="<?php echo base_url().MODULE_NAME;?>message/addMessage" class="btn btn-info btn-sm">Add New</a>              
                            <?php
                        }
                    ?>                    
                </div>
            </div>      
            <br>     
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table id="load_messagelist" class="table table-bordered table-striped">
                        <thead>
                            <tr class="label-primary1">
                                <th width="200px;" style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">S.No.</th>
                								<th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Message Send Date</th>
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
        $('#load_messagelist').DataTable({ 
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' servermside processing mode.
            "searching": true, //Feature control DataTables' servermside processing mode.
            "order": [], //Initial no order.
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo base_url(MODULE_NAME.'message/loadMessageListData')?>",
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
                "targets": [0,2], //first column / numbering column
                "orderable": false, //set not orderable
            }],
        });
    });
</script>