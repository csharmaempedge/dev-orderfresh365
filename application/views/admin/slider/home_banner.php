<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>    
            Home Slider<small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Home Slider</li>
        </ol>
    </section>   
    <!-- Main content -->
    <section class="content">       
        <div class="box">
            <div class="box-header">
                <div class="pull-left">
                    <h3 class="box-title">Home Slider Details</h3>
                </div>
                <div class="pull-right box-tools">
                    <?php
                    $session = $this->session->all_userdata();
                    if(!empty($session))
                    {
                        ?>
                            <a href="<?php echo base_url().MODULE_NAME;?>slider/addHomeBanner" class="btn btn-info btn-sm">Add New</a> 
                        <?php                             
                    }                       
                    ?>                    
                </div>
            </div>           
            <!-- /.box-header -->
            <div class="box-body">
                <div>
                    <div id="msg_div">
                        <?php echo $this->session->flashdata('message');?>
                    </div>
                </div>                
                <table id="example" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="background-color: #c8c9e3; color: #22255a;">Slider Image</th>                           
                            <th style="background-color: #c8c9e3; color: #22255a;">Slider Heading</th>                          
                            <th style="background-color: #c8c9e3; color: #22255a;">Status</th>
                            <th style="background-color: #c8c9e3; color: #22255a;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(!empty($banner_list))
                            {
                                foreach($banner_list as $res)
                                {
                                    ?>
                                    <tr>
                                        <td> <a data-toggle="modal" data-target="#myModal" href="javascript:void(0)"><img  onclick ="getFullSizePic(this.src)" width="50px" src="<?php echo base_url().''.$res->home_banner_img_name; ?>"></a></td>                                
                                        <td><?php echo $res->home_banner_heading ; ?></td> 
                                        <td  width="10%">
                                            <?php
                                                if($res->home_banner_status == '1')
                                                {
                                                    ?>
                                                    <span class="text-success">Active</span>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <span class="text-danger">Deactive</span>
                                                    <?php
                                                }
                                            ?>
                                        </td>   
                                        <td width="15%">                        
                                        <a class="btn btn-success btn-sm" href="<?php echo base_url().MODULE_NAME;?>slider/addHomeBanner/<?php echo $res->home_banner_id; ?>" title="Edit"><i class="fa fa-edit fa-1x "></i></a>&nbsp;&nbsp;

                                        <a class="confirm btn btn-danger btn-sm" class="confirm" onclick="return delete_home_Banner('<?php echo $res->home_banner_id;?>');" href="javascript:;" title="Remove"><i class="fa fa-trash-o fa-1x" data-toggle="modal" data-target=".bs-example-modal-sm"></i></a>
                                        </a>  
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
                                <tr>
                                    <td colspan="10">No records found...</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <?php
                            }
                            
                        ?>
                       
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</aside>
<!-- /.right-side -->

<div id="myModal" class="modal fade" role="dialog">
</div>
<script type="text/javascript">

    function delete_home_Banner(home_banner_id)
    {     
        if(confirm('are you sure you want to delete Home Slider details') === true)
        { 
            location.href="<?php echo base_url().MODULE_NAME;?>slider/deleteHomeBanner/"+home_banner_id;
        }
        else
        {
            return false;
        }
    }   
</script>>
<script type="text/javascript">
    function getFullSizePic(Imgurl){
        document.getElementById('myModal').innerHTML ='<div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Slider</h4></div><div class="modal-body"><img src ="'+Imgurl+'" style="width:100%;height:100%"></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div></div></div>"';
    }
</script>