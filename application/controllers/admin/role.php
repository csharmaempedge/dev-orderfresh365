<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Role extends MY_Controller{
	function __construct(){
		parent::__construct();
		if(!empty(MODULE_NAME)){
		  $this->load->model(MODULE_NAME.'role_model');
		}
	}
	
	/*	Validation Rules */
	protected $validation_rules = array(
        'roleAdd' => array(
            array(
                'field' => 'role_name',
                'label' => 'Role name',
                'rules' => 'trim|required'
            ),
           array(
                'field' => 'role_status',
                'label' => 'Role status',
                'rules' => 'trim|required'
            )
        ),
		'roleUpdate' => array(
            array(
                'field' => 'role_name',
                'label' => 'Role name',
                'rules' => 'trim|required'
            ),
			array(
                'field' => 'role_status',
                'label' => 'Role status',
                'rules' => 'trim|required'
            )
        )
    );

	public function index(){
		if($this->checkViewPermission()){	
			$this->show_view(MODULE_NAME.'role/role_view', $this->data);
		}
		else{	
			redirect( base_url().MODULE_NAME.'dashboard/error/1');
		}
    }
    
    public function loadRoleListData()
    {
    	$role_list = $this->role_model->getAllRoleList();
    	$data = array();
        $no = $_POST['start'];
        foreach ($role_list as $e_res) 
	    {
			$no++;
			$row   = array();
			$row[] = $no;
			$row[] = $e_res->role_name;
			$row[] = viewStatus ($e_res->role_status);
	 		$btn = '';
	 		if($this->checkViewPermission())
	 		{
	 			$btn .= '<a class="btn btn-success btn-sm" href="'.base_url().''.MODULE_NAME.'role/roleView/'.$e_res->role_id.'" title="View"><i class="fa fa-eye fa-1x "></i></a>&nbsp;&nbsp;';
	 		}
	 		if($this->checkEditPermission())
	 		{
	 			$btn .= '<a class="btn btn-success btn-sm" href="'.base_url().''.MODULE_NAME.'role/addRole/'.$e_res->role_id.'" title="Edit"><i class="fa fa-edit fa-1x "></i></a>&nbsp;&nbsp;';
	 		}
	 		if($this->checkDeletePermission())
	 		{
	 			$btn .= '<a class="confirm btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to Delete\')" href="'.base_url().''.MODULE_NAME.'role/delete_role/'.$e_res->role_id.'" title="Remove"><i class="fa fa-trash-o fa-1x" data-toggle="modal" data-target=".bs-example-modal-sm"></i></a>';
	 		}
	 		$row[] = $btn;
            $data[] = $row;
        }

        $output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => count($role_list),
			"recordsFiltered" => $this->role_model->count_filtered(),
			"data" => $data,
		);
       	//output to json format
       	echo json_encode($output);
    }

    public function roleView(){
		if($this->checkViewPermission()){			
			$role_id = $this->uri->segment(4);
			$this->data['role_edit'] = $this->role_model->editRole($role_id);
			if(!empty($this->data['role_edit'])){
				$this->show_view(MODULE_NAME.'role/role_full_view', $this->data);
			}
			else{
				redirect(base_url().MODULE_NAME.'role');
			}
		}
		else{	
			redirect( base_url().MODULE_NAME.'dashboard/error/1');
		}
    }

    /* Add and Update */
	public function addRole(){
		$role_id = $this->uri->segment(4);
		if($role_id){
			if($this->checkEditPermission()){
				if (isset($_POST['Submit']) && $_POST['Submit'] == "Edit"){
					$this->form_validation->set_rules($this->validation_rules['roleUpdate']);
					if($this->form_validation->run()){
						$s_role_id = $this->data['session']->role_id;
						$post['role_name'] = $this->input->post('role_name');
						$post['role_type'] = $this->input->post('role_type');
						$post['role_status'] = $this->input->post('role_status');
						$post['role_updated_date'] = date('Y-m-d');
						$post['center_id'] = $this->data['session']->center_id;
						$n_post = $this->xssCleanValidate($post);
						$this->role_model->updateRole($n_post, $role_id);

						$tab_list = $this->common_model->getData('tbl_sidebar_tabs', array('status'=>'1', 'child_id'=>'0', 'tab_id >'=>'1'), 'multi', NULL, 'tab_number ASC');
						foreach ($tab_list as $t_l){
							$u_permission_res = $this->common_model->getData('tbl_user_permission', array('role_id'=>$s_role_id, 'tab_id'=>$t_l->tab_id, 'userView'=>'1'), 'single');
							if(!empty($u_permission_res))
							{
								$post_permission['role_id'] = $role_id;
								$post_permission['tab_id'] = $t_l->tab_id;
								if($u_permission_res->userView == '1')
								{
									$post_permission['userView'] = $this->input->post('view_'.$t_l->tab_id);
								}
								if($u_permission_res->userAdd == '1')
								{
									$post_permission['userAdd'] = $this->input->post('add_'.$t_l->tab_id);
								}
								if($u_permission_res->userEdit == '1')
								{
									$post_permission['userEdit'] = $this->input->post('edit_'.$t_l->tab_id);
								}
								if($u_permission_res->userDelete == '1')
								{
									$post_permission['userDelete'] = $this->input->post('delete_'.$t_l->tab_id);
								}
								$n_post = $this->xssCleanValidate($post_permission);

								$permission_t_l = $this->common_model->getData('tbl_user_permission', array('role_id'=>$role_id, 'tab_id'=>$t_l->tab_id), 'single');
								if(!empty($permission_t_l))
								{
									$this->common_model->updateData('tbl_user_permission', array('user_permission_id'=>$permission_t_l->user_permission_id), $n_post);
								}
								else
								{
									$this->role_model->addRolePermission($n_post);
								}

			                    $sub_tab_list = $this->common_model->getData('tbl_sidebar_tabs', array('status'=>'1', 'child_id'=>$t_l->tab_id), 'multi', NULL, 'tab_number ASC');
			                    if(!empty($sub_tab_list))
			                    {
			                        foreach($sub_tab_list as $s_t_l) {
			                        	$s_u_permission_res = $this->common_model->getData('tbl_user_permission', array('role_id'=>$s_role_id, 'tab_id'=>$s_t_l->tab_id, 'userView'=>'1'), 'single');
			                        	if(!empty($s_u_permission_res))
			                        	{
				                        	$post_permission['role_id'] = $role_id;
											$post_permission['tab_id'] = $s_t_l->tab_id;
											if($s_u_permission_res->userView == '1')
											{
												$post_permission['userView'] = $this->input->post('view_'.$s_t_l->tab_id);
											}
											if($s_u_permission_res->userAdd == '1')
											{
												$post_permission['userAdd'] = $this->input->post('add_'.$s_t_l->tab_id);
											}
											if($s_u_permission_res->userEdit == '1')
											{
												$post_permission['userEdit'] = $this->input->post('edit_'.$s_t_l->tab_id);
											}
											if($s_u_permission_res->userDelete == '1')
											{
												$post_permission['userDelete'] = $this->input->post('delete_'.$s_t_l->tab_id);
											}
											$n_post = $this->xssCleanValidate($post_permission);
											$permission_s_t_l = $this->common_model->getData('tbl_user_permission', array('role_id'=>$role_id, 'tab_id'=>$s_t_l->tab_id), 'single');
											if(!empty($permission_s_t_l))
											{
												$this->common_model->updateData('tbl_user_permission', array('user_permission_id'=>$permission_s_t_l->user_permission_id), $n_post);
											}
											else
											{
												$this->role_model->addRolePermission($n_post);
											}
			                        	}
			                        }
			                    }
							}
		                }
						$msg = 'Role update successfully!!';					
						$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
						redirect(base_url().MODULE_NAME.'role');
					}
					else{
						$this->data['role_edit'] = $this->role_model->editRole($role_id);
						if(!empty($this->data['role_edit'])){
							$this->show_view(MODULE_NAME.'role/role_update', $this->data);
						}
						else{
							redirect(base_url().'role');
						}
					}
				}
				else{
					$this->data['role_edit'] = $this->role_model->editRole($role_id);
					if(!empty($this->data['role_edit'])){
						$this->show_view(MODULE_NAME.'role/role_update', $this->data);
					}
					else{
						redirect(base_url().MODULE_NAME.'role');
					}
				}
			}
			else{
				redirect( base_url().MODULE_NAME.'dashboard/error/1');
			}
		}
		else{
			if($this->checkAddPermission()){
				if (isset($_POST['Submit']) && $_POST['Submit'] == "Add"){
					$this->form_validation->set_rules($this->validation_rules['roleAdd']);
					if($this->form_validation->run()){
						$s_role_id = $this->data['session']->role_id;
						$last_role = $this->role_model->getLastRole();
						$post['role_name'] = $this->input->post('role_name');
						$post['role_type'] = $this->input->post('role_type');
						$post['role_status'] = $this->input->post('role_status');
						$post['role_created_date'] = date('Y-m-d');
						$post['role_updated_date'] = date('Y-m-d');
						$post['role_level'] = $last_role[0]->role_level + 1;
						$post['center_id'] = $this->data['session']->center_id;
						$n_post = $this->xssCleanValidate($post);
						$role_id =  $this->role_model->addRole($n_post);

						$post_permission['role_id'] = $role_id;
						$post_permission['tab_id'] = '1';
						$post_permission['userView'] = '1';
						$post_permission['userAdd'] = '1';
						$post_permission['userEdit'] = '1';
						$post_permission['userDelete'] = '1';
						$n_post = $this->xssCleanValidate($post_permission);
						$this->role_model->addRolePermission($n_post);

						$tab_list = $this->common_model->getData('tbl_sidebar_tabs', array('status'=>'1', 'child_id'=>'0', 'tab_id >'=>'1'), 'multi', NULL, 'tab_number ASC');
						foreach ($tab_list as $t_l){
							$u_permission_res = $this->common_model->getData('tbl_user_permission', array('role_id'=>$s_role_id, 'tab_id'=>$t_l->tab_id, 'userView'=>'1'), 'single');
							if(!empty($u_permission_res))
							{
								$post_permission['role_id'] = $role_id;
								$post_permission['tab_id'] = $t_l->tab_id;
								if($u_permission_res->userView == '1')
								{
									$post_permission['userView'] = $this->input->post('view_'.$t_l->tab_id);
								}
								if($u_permission_res->userAdd == '1')
								{
									$post_permission['userAdd'] = $this->input->post('add_'.$t_l->tab_id);
								}
								if($u_permission_res->userEdit == '1')
								{
									$post_permission['userEdit'] = $this->input->post('edit_'.$t_l->tab_id);
								}
								if($u_permission_res->userDelete == '1')
								{
									$post_permission['userDelete'] = $this->input->post('delete_'.$t_l->tab_id);
								}
								$n_post = $this->xssCleanValidate($post_permission);
								$this->role_model->addRolePermission($n_post);

			                    $sub_tab_list = $this->common_model->getData('tbl_sidebar_tabs', array('status'=>'1', 'child_id'=>$t_l->tab_id), 'multi', NULL, 'tab_number ASC');
			                    if(!empty($sub_tab_list))
			                    {
			                        foreach($sub_tab_list as $s_t_l) {
			                        	$s_u_permission_res = $this->common_model->getData('tbl_user_permission', array('role_id'=>$s_role_id, 'tab_id'=>$s_t_l->tab_id, 'userView'=>'1'), 'single');
			                        	if(!empty($s_u_permission_res))
			                        	{
				                        	$post_permission['role_id'] = $role_id;
											$post_permission['tab_id'] = $s_t_l->tab_id;
											if($s_u_permission_res->userView == '1')
											{
												$post_permission['userView'] = $this->input->post('view_'.$s_t_l->tab_id);
											}
											if($s_u_permission_res->userAdd == '1')
											{
												$post_permission['userAdd'] = $this->input->post('add_'.$s_t_l->tab_id);
											}
											if($s_u_permission_res->userEdit == '1')
											{
												$post_permission['userEdit'] = $this->input->post('edit_'.$s_t_l->tab_id);
											}
											if($s_u_permission_res->userDelete == '1')
											{
												$post_permission['userDelete'] = $this->input->post('delete_'.$s_t_l->tab_id);
											}
											$n_post = $this->xssCleanValidate($post_permission);
											$this->role_model->addRolePermission($n_post);
			                        	}
			                        }
			                    }
							}
		                }
  
						$msg = 'Role added successfully!!';					
						$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
						redirect(base_url().MODULE_NAME.'role');
					}
					else{
						$this->data['tab_list'] = $this->role_model->getAllTabs();
						$this->show_view(MODULE_NAME.'role/role_add', $this->data);
					}		
				}
				else{
					$this->show_view(MODULE_NAME.'role/role_add', $this->data);
				}
			}
			else{
				redirect( base_url().MODULE_NAME.'admin/dashboard/error/1');
			}
		}
	}
	
	public function delete_role(){
		if($this->checkDeletePermission()){
			$role_id = $this->uri->segment(4);
			$n_post['role_status'] = '2';
			$this->role_model->updateRole($n_post, $role_id);
			$n_post_n['user_permission_status'] = '2';
			$this->role_model->deleteRolePermission($n_post_n, $role_id);
			$msg = 'Role remove successfully...!';					
			$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
			redirect(base_url().MODULE_NAME.'role');
		}
		else{
			redirect( base_url().MODULE_NAME.'dashboard/error/1');
		}		
	}

	public function getTabList()
	{
		$role_type = $this->input->post('role_type');
		$this->data['role_type'] = $role_type;
		$this->load->view(MODULE_NAME.'role/role_tab_list', $this->data);
	}
}
?>