
<aside class="right-side">
   <section class="content-header">
      <h1>Deliver Sheet Print</h1>
        <ol class="breadcrumb">
           <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
           <li class="active">dashboard</li>
        </ol>
            <section class="content">       
                <div class="box box-success">
                    <div class="box-header">
                        <div class="pull-left">
                            <h3 class="box-title">Deliver Sheet Print</h3>
                        </div>
                        <div class="pull-right">
                          <a href="<?php echo base_url().MODULE_NAME;?>order" class="btn btn-info btn-sm">Back</a>
                           
                       </div>
                    </div>
                    <form action="" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        <?php  $csrf = array( 'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash() ); ?>
                        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                        <div class="box-body">
                            <div>
                                <div id="msg_div">
                                    <?php echo $this->session->flashdata('message');?>
                                </div>
                            </div>
                            <div class="row">
                              <div >
                                  <div class="form-group col-md-12">
                                    <div class="input text">
                                        <label>Order Patient List</label>
                                        <select onchange="bulkDeliverSheetPrintLabel(this.value);" name="delivery_person_id" id="delivery_person_id" class="form-control">
                                            <option value="">--Select--</option>
                                            <?php
                                                $delivery_person_res = $this->common_model->getData('tbl_delivery_person', array('delivery_person_status'=>1), 'multi');
                                                if(!empty($delivery_person_res)){
                                                    foreach($delivery_person_res as $res){
                                                        ?>
                                                          <option value="<?php echo $res->delivery_person_id; ?>"><?php echo $res->delivery_person_name; ?></option>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                  <!-- <div class="form-group col-md-2" style="margin-top: 30px;">
                                     <div class="input text">
                                          <button class="btn btn-success btn-sm" type="submit" name="Submit" value="search" >Filter</button>
                                          <a class="btn btn-danger btn-sm" href="<?php echo base_url().MODULE_NAME;?>order/bulkPrintView">Refresh</a>
                                     </div>
                                  </div> --> 
                              </div>
                            </div> 
                        </div>
                    </form>
                </div>
                <div id="view_print_Data"></div>

                <!-- /.box -->
            </section>
   </section>
</aside>
<script type="text/javascript">
    function  bulkDeliverSheetPrintLabel(delivery_person_id)
    {
        var str = 'delivery_person_id='+delivery_person_id+'&<?php echo $this->security->get_csrf_token_name(); ?>='+'<?php echo $this->security->get_csrf_hash(); ?>';
        var PAGE = '<?php echo base_url().MODULE_NAME; ?>order/bulkDeliverSheetPrintLabel';
        jQuery.ajax({
            type :"POST",
            url  :PAGE,
            data : str,
            success:function(data)
            {        
               $('#view_print_Data').html(data);
            } 
        });
    } 
</script>

