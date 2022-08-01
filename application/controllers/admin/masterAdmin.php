<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MasterAdmin extends MY_Controller{
	function __construct(){
		parent::__construct();
		if(!empty(MODULE_NAME)){
			$this->load->model(MODULE_NAME.'masteradmin_model');
		}
	}
	
	/*	Validation Rules */
	protected $validation_rules = array(
        'userAdd' => array(
            array(
                'field' => 'user_fname',
                'label' => 'First Name',
                'rules' => 'trim|required|callback_alpha_dash_space'
            ),
            array(
                'field' => 'user_lname',
                'label' => 'Last Name',
                'rules' => 'trim|required|callback_alpha_dash_space'
            ),
            array(
                'field' => 'user_mobile_no',
                'label' => 'Phone Number',
                'rules' => 'trim|required|exact_length[10]|integer'
            ), 
			array(
                'field' => 'user_email',
                'label' => 'Email',
                'rules' => 'trim|required|is_unique[tbl_user.user_email]|valid_email'
            ),
            array(
                'field' => 'user_name',
                'label' => 'User Name',
                'rules' => 'trim|required|is_unique[tbl_user.user_name]|is_unique[com_user_login_tbl.user_name]'
            ),
            array( 
				'field' => 'user_password', 
				'label' => 'Password',   
				'rules' => 'trim|required'  
			),
			array(  
				'field' => 'user_cpassword',
				'label' => 'Confirm Password', 
				'rules' => 'trim|required|matches[user_password]'
            )
        ),
		'userUpdate' => array(
            array(
                'field' => 'user_fname',
                'label' => 'First Name',
                'rules' => 'trim|required|callback_alpha_dash_space'
            ),
            array(
                'field' => 'user_lname',
                'label' => 'Last Name',
                'rules' => 'trim|required|callback_alpha_dash_space'
            ),
            array(
                'field' => 'user_mobile_no',
                'label' => 'Phone Number',
                'rules' => 'trim|required|exact_length[10]|integer'
            )
        )
    );

	public function index(){
		if($this->checkViewPermission()){			
			$this->data['user_res'] = $this->masteradmin_model->getAllUserList();		
			$this->show_view(MODULE_NAME.'masterAdmin/masterAdmin_view', $this->data);
		}
		else{	
			redirect( base_url().MODULE_NAME.'dashboard/error/1');
		}
    }

    public function loadUserListData(){
    	$user_list = $this->masteradmin_model->getAllUserList();
    	$data = array();
        $no = $_POST['start'];
        foreach ($user_list as $u_res){
			$no++;
			$row   = array();
			$row[] = $no;
			if(!empty($u_res->user_profile_img)){
				$row[] = '<a data-toggle="modal" data-target="#myModal" href="javascript:void(0)"><img width="50px"  onclick ="getFullSizePic(this.src)" src="'.base_url().''.$u_res->user_profile_img.'"></a>';
			}	
			else{
				$row[] = '<a data-toggle="modal" data-target="#myModal" href="javascript:void(0)"><img width="50px"  onclick ="getFullSizePic(this.src)" src="'.base_url().'webroot/upload/admin/users/user.png"></a>';
			}
			$row[] = $u_res->user_fname.' '.$u_res->user_lname;
			$row[] = $u_res->user_email;
			$row[] = $u_res->user_mobile_no;
			$row[] = viewStatus($u_res->user_status);
	 		$btn = '';
	 		if($this->checkViewPermission()){
	 			$btn .= '<a class="btn btn-success btn-sm" href="'.base_url().''.MODULE_NAME.'masterAdmin/masterAdminView/'.$u_res->user_id.'" title="View"><i class="fa fa-eye fa-1x "></i></a>&nbsp;&nbsp;';
	 		}
	 		if($this->checkEditPermission()){
	 			$btn .= '<a class="btn btn-success btn-sm" href="'.base_url().''.MODULE_NAME.'masterAdmin/addMasterAdmin/'.$u_res->user_id.'" title="Edit"><i class="fa fa-edit fa-1x "></i></a>&nbsp;&nbsp;';
	 		}
	 		if($this->checkDeletePermission()){
	 			$btn .= '<a class="confirm btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to Delete\')" href="'.base_url().''.MODULE_NAME.'masterAdmin/delete_masterAdmin/'.$u_res->user_id.'" title="Remove"><i class="fa fa-trash-o fa-1x" data-toggle="modal" data-target=".bs-example-modal-sm"></i></a>';
	 		}
	 		$row[] = $btn;
            $data[] = $row;
        }
        $output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => count($user_list),
			"recordsFiltered" => $this->masteradmin_model->count_filtered(),
			"data" => $data,
		);
       	echo json_encode($output);
    }

	public function masterAdminView(){
		if($this->checkViewPermission()){			
			$user_id = $this->uri->segment(4);
			$edit_user = $this->masteradmin_model->editUser($user_id);
			if(!empty($edit_user)){
				$this->data['edit_user'] = $edit_user;
				$this->data['country_list'] = $this->common_model->getAllCountry();
				$this->show_view(MODULE_NAME.'masterAdmin/masterAdmin_full_view', $this->data);
			}
			else{
				redirect(base_url().MODULE_NAME.'masterAdmin');
			}
		}
		else{	
			redirect( base_url().MODULE_NAME.'dashboard/error/1');
		}
	}
 
    /* Add & update */
    public function addMasterAdmin(){
    	$user_id = $this->uri->segment(4);
		if($user_id){
			if($this->checkEditPermission()){
				if (isset($_POST['Submit']) && $_POST['Submit'] == "Edit"){
					$this->form_validation->set_rules($this->validation_rules['userUpdate']);
					$post['user_email'] = $this->input->post('user_email');			
					$res = $this->common_model->checkUniqueValue('tbl_user', 'user_email', $post['user_email'], 'user_id', $user_id);
					if($res){
						$this->form_validation->set_rules('user_email','User Email','trim|xss_clean|required|is_unique[tbl_user.user_email]|valid_email');
					}
					if($this->form_validation->run()){
						$post['role_id'] = '2';
						$post['user_fname'] = $this->input->post('user_fname');
						$post['user_lname'] = $this->input->post('user_lname');
						$post['user_mobile_no'] = $this->input->post('user_mobile_no');
						$user_password = $this->input->post('user_password');
						if($user_password){
							$post['user_password'] = md5($user_password);
						}
						$post['country_id'] = $this->input->post('country_id');
						$post['state_id'] = $this->input->post('state_id');
						$post['user_city'] = $this->input->post('user_city');
						$post['user_address'] = $this->input->post('user_address');
						$post['user_postal_code'] = $this->input->post('user_postal_code');
						$post['user_dob'] = $this->input->post('user_dob');
						$post['user_status'] = $this->input->post('user_status');						
						$post['user_all_level'] = $this->data['session']->user_all_level.','.$this->data['session']->user_id;
						$post['user_updated_date'] = date('Y-m-d');
						if($_FILES["user_profile_img"]["name"]){
	                       $user_profile_img = 'user_profile_img';
	                       $fieldName = "user_profile_img";
	                       $Path = 'webroot/upload/admin/users/profile';
	                       $user_profile_img = $this->ImageUpload($_FILES["user_profile_img"]["name"], $user_profile_img, $Path, $fieldName);
	                       $post['user_profile_img'] = $Path.'/'.$user_profile_img;
	                   	}
                        $n_post = $this->xssCleanValidate($post);
						$this->masteradmin_model->updateUser($n_post,$user_id);                         
	                   	$user_name = 'tbl_'.$user_id;
	                   	if($user_password){
							$post_l['user_password'] = md5($this->input->post('user_password'));
						}						
						$post_l['user_status'] = $this->input->post('user_status');
						$post_l['updated_date'] = date('Y-m-d');
						$n_post = $this->xssCleanValidate($post_l);
						$this->common_model->commonLoginTableUpdate($n_post,$user_name);
	                   	$msg = 'Sub admin updated successfully!!';					
						$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
						redirect(base_url().MODULE_NAME.'masterAdmin');
					}
					else{
						$edit_user = $this->masteradmin_model->editUser($user_id);
						if(!empty($edit_user)){
							$this->data['edit_user'] = $edit_user;
							$this->data['country_list'] = $this->common_model->getAllCountry();
							$this->show_view(MODULE_NAME.'masterAdmin/masterAdmin_update', $this->data);
						}
						else{
							redirect(base_url().MODULE_NAME.'masterAdmin');
						}
					}
				}
				else{
					$edit_user = $this->masteradmin_model->editUser($user_id);
					if(!empty($edit_user)){
						$this->data['edit_user'] = $edit_user;
						$this->data['country_list'] = $this->common_model->getAllCountry();
						$this->show_view(MODULE_NAME.'masterAdmin/masterAdmin_update', $this->data);
					}
					else{
						redirect(base_url().MODULE_NAME.'masterAdmin');
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
					$this->form_validation->set_rules($this->validation_rules['userAdd']);
					if($this->form_validation->run()){
						$post['user_fname'] = $this->input->post('user_fname');
						$post['user_lname'] = $this->input->post('user_lname');
						$post['role_id'] 	= '2';
						$post['user_name'] = $this->input->post('user_name');
						$post['user_password'] = md5($this->input->post('user_password'));
						$post['user_email'] = $this->input->post('user_email');
						$post['user_mobile_no'] = $this->input->post('user_mobile_no');
						$post['user_dob'] = $this->input->post('user_dob');
						$post['country_id'] = $this->input->post('country_id');
						$post['state_id'] = $this->input->post('state_id');
						$post['user_postal_code'] = $this->input->post('user_postal_code');
						$post['user_city'] = $this->input->post('user_city');
						$post['user_address'] = $this->input->post('user_address');
						$post['user_status'] = $this->input->post('user_status');						
						$post['user_all_level'] = $this->data['session']->user_all_level.','.$this->data['session']->user_id;
						$post['module_name'] = 'admin';
						$post['user_type'] = 'admin';
						$post['user_tbl_prefix'] = 'tbl_';
						$post['user_created_date'] = date('Y-m-d');
						$post['user_updated_date'] = date('Y-m-d');
						if($_FILES["user_profile_img"]["name"]){
	                       	$user_profile_img = 'user_profile_img';
	                       	$fieldName = "user_profile_img";
	                       	$Path = 'webroot/upload/admin/users/profile';
	                       	$user_profile_img = $this->ImageUpload($_FILES["user_profile_img"]["name"], $user_profile_img, $Path, $fieldName);
	                       	if(!empty($user_profile_img)){
	                       		$post['user_profile_img'] = $Path.'/'.$user_profile_img;
	                       	}
	                   	}
	                   	else{
	                   		$post['user_profile_img'] = 'webroot/upload/admin/users/user.png';
	                   	}
                        $n_post = $this->xssCleanValidate($post);
	                   	$user_login_tbl_id = $this->masteradmin_model->addUser($n_post);
	                   	$post_l['user_name'] = $this->input->post('user_name');
						$post_l['user_password'] = md5($this->input->post('user_password'));
						$post_l['user_status'] = $this->input->post('user_status');
						$post_l['module_name'] = 'admin';
						$post_l['user_type'] = 'admin';
						$post_l['tbl_name'] = 'tbl_user';
						$post_l['user_id'] = 'tbl_'.$user_login_tbl_id;
						$post_l['created_date'] = date('Y-m-d');
						$post_l['updated_date'] = date('Y-m-d');
						$n_post_n = $this->xssCleanValidate($post_l);
						$this->masteradmin_model->addUserLogin ($n_post_n);                        
	                   	$msg = 'Sub admin added successfully!!';					
						$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
						redirect(base_url().MODULE_NAME.'masterAdmin');
	                }
					else{
						$this->data['country_list'] = $this->common_model->getAllCountry();
						$this->show_view(MODULE_NAME.'masterAdmin/masterAdmin_add', $this->data);
					}
				}
				else{
					$this->data['country_list'] = $this->common_model->getAllCountry();
					$this->show_view(MODULE_NAME.'masterAdmin/masterAdmin_add', $this->data);
				}
			}
			else{	
				redirect( base_url().MODULE_NAME.'dashboard/error/1');
			}
		}
    }

	public function delete_masterAdmin(){
		if($this->checkDeletePermission()){
			$user_id = $this->uri->segment(4);	
			$user_name = 'tbl_'.$user_id;	
			$n_post['user_status'] = '2';
			$this->masteradmin_model->updateUser($n_post,$user_id);
			$this->common_model->commonLoginTableUpdate($n_post,$user_name);
			$msg = 'Sub admin remove successfully...!';					
			$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
			redirect(base_url().MODULE_NAME.'masterAdmin');
		}
		else{
			redirect( base_url().MODULE_NAME.'dashboard/error/1');
		}		
	}
}
?>