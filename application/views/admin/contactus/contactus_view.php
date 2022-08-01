
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Contact Us Details</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url() . MODULE_NAME; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Contact Us View</li>
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
                    </div>
                </div>
                <br>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="load_Data" class="table table-bordered table-striped">
                    <thead>
                        <tr class="label-primary1">
                            <th style="background-color: #1b5f79; color: #fff;">S.No.</th>
                            <th style="background-color: #1b5f79; color: #fff;"> Name</th>
                            <th style="background-color: #1b5f79; color: #fff;"> Contact No</th>
                            <th style="background-color: #1b5f79; color: #fff;"> Email</th>
                            <th style="background-color: #1b5f79; color: #fff;"> Subject</th>
                            <th style="background-color: #1b5f79; color: #fff;">Message</th>
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
                "url": "<?php echo base_url(MODULE_NAME.'contactus/loadContactusListData')?>",
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
        document.getElementById('myModal').innerHTML ='<div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Contactus Member</h4></div><div class="modal-body"><img src ="'+Imgurl+'" style="width:100%;height:100%"></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div></div></div>"';
    }
</script>