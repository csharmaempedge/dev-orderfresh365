<aside class="right-side">
    <section class="content-header">
        <h1>Patients Details</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Patients</li>
        </ol>
    </section>   
    <section class="content">       
        <div class="box box-success">
            <div class="box-header">
                <div class="pull-right box-tools">
                    <?php
                        if($myobj->checkAddPermission()){
                        ?>
                        <?php
                        if($role_id == '2')
                        {
                            ?> <a href="<?php echo base_url().MODULE_NAME;?>doctor" class="btn btn-danger btn-sm">Back</a>&nbsp;&nbsp;    <?php
                        }
                        ?>
                            <a href="<?php echo base_url().MODULE_NAME;?>doctor/addPatient/<?php echo $doctor_id; ?>" class="btn btn-info btn-sm">Add New</a>              
                        <?php
                        }
                    ?>                    
                </div>
            </div>
            <div class="box-body"><br>
                <div>
                    <div id="msg_div">
                        <?php echo $this->session->flashdata('message');?>
                    </div>
                </div>  
                <div class="table-responsive">
                    <table id="load_userlist" class="table table-bordered table-striped">
                        <thead>
                            <tr class="label-primary1">
                                <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">S. No.</th>
                                <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Image</th>
                                <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Full Name</th>
                                <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">User Name</th>
                                <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Email</th>
                                <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Phone Number</th> 
                                <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Status</th>
                                <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Current Macro</th>
                                <th width="25%" style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Set Macro</th>
                                <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Set Breakfast</th>
                                <!-- <th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Login Access</th> -->
                                <th width="100%" style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Action</th>
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
<div id="myModal" class="modal fade" role="dialog">
</div>
<script type="text/javascript">
    function getFullSizePic(Imgurl){
        document.getElementById('myModal').innerHTML ='<div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Patients</h4></div><div class="modal-body"><img src ="'+Imgurl+'" style="width:100%;height:100%"></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div></div></div>"';
    }
    $(document).ready(function() {
        $('#load_userlist').DataTable({ 
            "processing": true,
            "serverSide": true,
            "searching": true,
            "order": [],
            "ajax": {
                "url": "<?php echo base_url(MODULE_NAME.'doctor/loadDocPatientListData')?>",
                "type": "POST",
                "dataType": "json",
                "data":{'doctor_id': <?php echo $doctor_id; ?>,'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'},
                "dataSrc": function (jsonData) {
                    return jsonData.data;
                }
            },
            "columnDefs": [{ 
                "targets": [0,1,5,6,7],
                "orderable": false,
            }],
        });
    });
</script>