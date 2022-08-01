<aside class="main-sidebar">
   <!-- sidebar: style can be found in sidebar.less -->
   <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
         <div class="pull-left image">
            
         </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
         <?php
            if(!empty($getAllParentRole))
            {
               foreach ($getAllParentRole as $tab_list) 
               {
                  if($tab_list->userView == '1' && $tab_list->status == '1')
                  {
                     if($tab_list->child_status == '0' && $tab_list->child_id == '0')
                     {
                        ?>
                        <li class="<?php echo ($this->uri->segment(2)== $tab_list->controller_name)?'active':''?>">
                           <a href="<?php echo base_url().MODULE_NAME.$tab_list->controller_name; ?>">
                              <i class="<?php echo $tab_list->tab_icon; ?>"></i>
                              <span><?php 
                              if($role_id == '4')
                              {
                                 if($tab_list->tabname =='Dashboard')
                                 {
                                    echo str_replace("Dashboard","","Order");
                                 }
                                 elseif($tab_list->tabname =='Order')
                                 {
                                    echo str_replace("","","  My Orders");
                                 }
                                 else
                                 {
                                    echo $tab_list->tabname;
                                 }
                              }
                              elseif($role_id == '3')
                              {
                                 if($tab_list->tabname =='Doctor')
                                 {
                                    echo str_replace("Doctor","","My Patients");
                                 }
                                 else
                                 {
                                    echo $tab_list->tabname;
                                 }
                              }
                              else
                              {
                                 echo $tab_list->tabname;
                              }
                               ?></span>
                           </a>
                        </li>
                        <?php
                     }
                     elseif($tab_list->child_status == '1' && $tab_list->child_id == '0')
                     {
                        $sub_memu_res = $this->common_model->getSubmenuById($tab_list->tab_id, $user_tbl_prefix);
                        ?>
                        <li class="treeview <?php foreach($sub_memu_res as $t_value){
                                  echo ($this->uri->segment(2) == $t_value->controller_name) ? 'active' : ''; 
                                } ?>">
                           <a href="<?php echo base_url().MODULE_NAME.$tab_list->controller_name; ?>">
                              <i class="<?php echo $tab_list->tab_icon; ?>"></i><span><?php echo $tab_list->tabname; ?></span>
                                 <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                 </span>
                              </a>
                              <ul class="treeview-menu">
                                 <?php 
                                 foreach ($sub_memu_res as $sub_val)
                                 {
                                    if($sub_val->child_status == '2' && $sub_val->child_id == $tab_list->tab_id)
                                    {
                                       $sub_sub_memu_res = $this->common_model->getSubmenuById($sub_val->tab_id, $user_tbl_prefix);
                                       ?>
                                       <li class="treeview">
                                          <a href="#">
                                             <i class="fa fa-share"></i> <span><?php echo $sub_val->tabname; ?></span>
                                             <span class="pull-right-container">
                                                 <i class="fa fa-angle-left pull-right"></i>
                                             </span>
                                          </a>
                                          <ul class="treeview-menu">
                                             <?php
                                             foreach($sub_sub_memu_res as $sub_sub_val) 
                                             {
                                                 ?>
                                                 <li><a href="#"><i class="fa fa-circle-o"></i> <?php echo $sub_sub_val->tabname; ?></a></li>
                                                 <?php
                                             }
                                             ?>
                                          </ul>
                                       </li>
                                       <?php
                                    }
                                    else
                                    {
                                       $ch_status = $this->common_model->getData('tbl_user_permission', array('role_id'=>$tab_list->role_id, 'tab_id'=>$sub_val->tab_id, 'userView'=>'1'), 'single');
                                       if(!empty($ch_status))
                                       { 
                                          ?>
                                          <li class="<?php echo ($this->uri->segment(2) == $sub_val->controller_name) ? 'active' : ''?>">
                                             <a href="<?php echo base_url().MODULE_NAME.$sub_val->controller_name; ?>"><i class="fa fa-tag"></i><span><?php echo $sub_val->tabname; ?></span></a>
                                          </li>
                                          <?php
                                       }
                                    }
                                 }
                                 ?>
                            </ul>
                        </li>
                        <?php
                     }
                  }
               }
            }
         ?>
      </ul><br><br><br>
   </section>
   <!-- /.sidebar -->
</aside>
<!-- Content Wrapper. Contains page content -->