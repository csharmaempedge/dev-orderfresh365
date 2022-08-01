<div class="col-md-12">
    <div class="box-header">
        <label>Permission</label> 
    </div>
    <div class="table-responsive">
        <table id="aa" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Main Tab Name</th>
                    <th>Sub Tab Name</th>
                    <th><label><input type="checkbox" name="all_view" id="all_view" value="" onclick="checkedAllCheckboxVerticale('all_view', 'view_')" >&nbsp;&nbsp; View
                        </label></th>
                    <th><label><input type="checkbox" name="all_add" id="all_add" value="" onclick="checkedAllCheckboxVerticale('all_add', 'add_')" >&nbsp;&nbsp; Add</label></th>            
                    <th><label><input type="checkbox" name="all_edit" id="all_edit" value="" onclick="checkedAllCheckboxVerticale('all_edit', 'edit_')" >&nbsp;&nbsp; Edit</label></th>           
                    <th><label><input type="checkbox" name="all_delete" id="all_delete" value="" onclick="checkedAllCheckboxVerticale('all_delete', 'delete_')" >&nbsp;&nbsp; Delete</label></th>  
                </tr>
            </thead>
            <tbody>
            <?php
                $role_id = $this->data['session']->role_id;
                    $tab_list = $this->common_model->getData('tbl_sidebar_tabs', array('status'=>'1', 'child_id'=>'0', 'tab_id >'=>'1'), 'multi', NULL, 'tab_number ASC');
                    if(!empty($tab_list)){
                        foreach($tab_list as $res){
                            $u_permission_res = $this->common_model->getData('tbl_user_permission', array('role_id'=>$role_id, 'tab_id'=>$res->tab_id, 'userView'=>'1'), 'single');
                            if(!empty($u_permission_res))
                            {
                                ?>
                                <tr class="tab_list_<?php echo $res->tab_id; ?>">        
                                    <td>
                                        <?php 
                                            if($res->child_id == '0')
                                            {
                                                echo $res->tabname; 
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                            if($res->child_id != '0')
                                            {
                                                echo $res->tabname; 
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if($u_permission_res->userView == '1')
                                            {
                                                ?>
                                                <label><input type="checkbox" name="view_<?php echo $res->tab_id; ?>" id="view_<?php echo $res->tab_id; ?>" value="1" ></label>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <i class="fa fa-times fa-1x text-danger"></i>
                                                <?php
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if($u_permission_res->userAdd == '1')
                                            {
                                                ?>
                                                <label><input type="checkbox" name="add_<?php echo $res->tab_id; ?>" id="add_<?php echo $res->tab_id; ?>" value="1" ></label>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <i class="fa fa-times fa-1x text-danger"></i>
                                                <?php
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if($u_permission_res->userEdit == '1')
                                            {
                                                ?>
                                                <label><input type="checkbox" name="edit_<?php echo $res->tab_id; ?>" id="edit_<?php echo $res->tab_id; ?>" value="1" ></label>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <i class="fa fa-times fa-1x text-danger"></i>
                                                <?php
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if($u_permission_res->userDelete == '1')
                                            {
                                                ?>
                                                <label><input type="checkbox" name="delete_<?php echo $res->tab_id; ?>" id="delete_<?php echo $res->tab_id; ?>" value="1" ></label>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <i class="fa fa-times fa-1x text-danger"></i>
                                                <?php
                                            }
                                        ?>
                                    </td>
                                </tr> 
                                <?php
                                $sub_tab_list = $this->common_model->getData('tbl_sidebar_tabs', array('status'=>'1', 'child_id'=>$res->tab_id), 'multi', NULL, 'tab_number ASC');
                                if(!empty($sub_tab_list))
                                {
                                    foreach ($sub_tab_list as $ss_val) 
                                    {
                                        $s_u_permission_res = $this->common_model->getData('tbl_user_permission', array('role_id'=>$role_id, 'tab_id'=>$ss_val->tab_id, 'userView'=>'1'), 'single');
                                        if(!empty($s_u_permission_res))
                                        {
                                            ?>
                                            <tr class="tab_list_<?php echo $ss_val->tab_id; ?>">        
                                                <td>
                                                    <?php 
                                                        if($ss_val->child_id == '0')
                                                        {
                                                            echo $ss_val->tabname; 
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        if($ss_val->child_id != '0')
                                                        {
                                                            echo $ss_val->tabname; 
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        if($s_u_permission_res->userView == '1')
                                                        {
                                                            ?>
                                                            <label><input type="checkbox" name="view_<?php echo $ss_val->tab_id; ?>" id="view_<?php echo $ss_val->tab_id; ?>" value="1" ></label>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <i class="fa fa-times fa-1x text-danger"></i>
                                                            <?php
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        if($s_u_permission_res->userAdd == '1')
                                                        {
                                                            ?>
                                                            <label><input type="checkbox" name="add_<?php echo $ss_val->tab_id; ?>" id="add_<?php echo $ss_val->tab_id; ?>" value="1" ></label>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <i class="fa fa-times fa-1x text-danger"></i>
                                                            <?php
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        if($s_u_permission_res->userEdit == '1')
                                                        {
                                                            ?>
                                                            <label><input type="checkbox" name="edit_<?php echo $ss_val->tab_id; ?>" id="edit_<?php echo $ss_val->tab_id; ?>" value="1" ></label>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <i class="fa fa-times fa-1x text-danger"></i>
                                                            <?php
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        if($s_u_permission_res->userDelete == '1')
                                                        {
                                                            ?>
                                                            <label><input type="checkbox" name="delete_<?php echo $ss_val->tab_id; ?>" id="delete_<?php echo $ss_val->tab_id; ?>" value="1" ></label>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <i class="fa fa-times fa-1x text-danger"></i>
                                                            <?php
                                                        }
                                                    ?>
                                                </td>
                                            </tr> 
                                            <?php
                                        }
                                    }
                                }
                            }
                        }
                    }
                    else{
                        ?>
                        <tr>        
                            <td colspan="4" >No records found...</td>
                        </tr> 
                        <?php
                    }

                
            ?> 
            </tbody>
        </table>
    </div>
</div>