<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Patient extends MY_Controller{

	function __construct(){

		parent::__construct();

		if(!empty(MODULE_NAME)){

			$this->load->model(MODULE_NAME.'patient_model');

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

                'rules' => 'trim|required'

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

            )

        ),

		'patientUpdate' => array(

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

                'rules' => 'trim|required'

            )

        )

    );



	public function index(){

		if($this->checkViewPermission()){			

			$this->data['user_res'] = $this->patient_model->getAllUserList();		

			$this->show_view(MODULE_NAME.'patient/patient_view', $this->data);

		}

		else{	

			redirect( base_url().MODULE_NAME.'dashboard/error/1');

		}

    }



    public function loadUserListData(){

    	$user_list = $this->patient_model->getAllUserList();

    	$data = array();

        $no = $_POST['start'];

        foreach ($user_list as $u_res){

        	$check_patient_macro = $this->common_model->getData('tbl_patient_macro', array('patient_id'=>$u_res->user_id), 'single');

        	$check_patient_macro_history = $this->common_model->getData(' tbl_patient_macro_history', array('patient_id'=>$u_res->user_id), 'single');

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

			$row[] = $u_res->user_name;

			$row[] = $u_res->user_email;

			$row[] = $u_res->user_mobile_no;

			$row[] = viewStatus($u_res->user_status);

			

	 		/*$btn2 = '';

	 		if($this->checkViewPermission()){

	 			if(!empty($check_patient_macro_history))

	 			{

	 				$btn2 .= '<a class="btn btn-warning btn-sm" href="'.base_url().''.MODULE_NAME.'patient/patientMacroHistory/'.$u_res->user_id.'" title="Macro History"><i class="fa fa-eye fa-1x "></i></a>&nbsp;&nbsp;';

	 			}

	 			else

	 			{

	 				$btn2 .= '';

	 			}

	 		}

	 		$row[] = $btn2;*/

	 		$btn = '';

	 		if($this->checkViewPermission()){

	 			$btn .= '<a class="btn btn-success btn-sm" href="'.base_url().''.MODULE_NAME.'patient/patientView/'.$u_res->user_id.'" title="View"><i class="fa fa-eye fa-1x "></i></a>&nbsp;';

	 			$btn .= '<a class="btn btn-info btn-sm" href="'.base_url().''.MODULE_NAME.'patient/updatePatient/'.$u_res->user_id.'" title="edit"><i class="fa fa-edit fa-1x "></i></a>&nbsp;';

	 			$btn .= '<a class="btn btn-warning btn-sm" href="'.base_url().''.MODULE_NAME.'patient/updateAddressRoute/'.$u_res->user_id.'" title="Set Address Route"><i class="fa fa-edit fa-1x "></i></a>&nbsp;';

	 		}

	 		if($this->checkDeletePermission()){

	 			$btn .= '<a class="confirm btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to Delete\')" href="'.base_url().''.MODULE_NAME.'patient/delete_patient/'.$u_res->user_id.'" title="Remove"><i class="fa fa-trash-o fa-1x" data-toggle="modal" data-target=".bs-example-modal-sm"></i></a>';

	 		}

	 		$row[] = $btn;

            $data[] = $row;

        }

        $output = array(

			"draw" => $_POST['draw'],

			"recordsTotal" => count($user_list),

			"recordsFiltered" => $this->patient_model->count_filtered(),

			"data" => $data,

		);

       	echo json_encode($output);

    }



    public function updateAddressRoute(){

    	$user_id = $this->uri->segment(4);

		if($user_id){

			if($this->checkEditPermission()){

				if (isset($_POST['Submit']) && $_POST['Submit'] == "Edit"){

					$address_res = $this->common_model->getData('tbl_address', array('user_id'=>$user_id), 'multi');

					foreach ($address_res as  $res) 

           			{

	               		$post_his['address_route']  	= $this->input->post('address_route_'.$res->address_id);

	               		$post_his['distance_charge']  	= $this->input->post('distance_charge_'.$res->address_id);

						$nhis_post = $this->xssCleanValidate($post_his);

						$this->common_model->updateData('tbl_address',array('address_id'=>$res->address_id), $nhis_post);

					}

                   	$msg = 'Route updated successfully!!';					

					$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');

					redirect(base_url().MODULE_NAME.'patient/');

					

				}

				else{

					$this->data['patient_id'] 	= $user_id;

					$this->show_view(MODULE_NAME.'patient/patient_address_view', $this->data);

				}

			}

			else{	

				redirect( base_url().MODULE_NAME.'dashboard/error/1');

			}

		}

    }

	/*public function patientMacroHistory(){

		if($this->checkViewPermission()){			

			$user_id = $this->uri->segment(4);

			$edit_user = $this->common_model->getData('tbl_user', array('user_id'=>$user_id), 'single');

			if(!empty($edit_user))

			{

				$this->data['edit_user'] = $edit_user;

				$this->data['patient_id'] = $user_id;

				$this->show_view(MODULE_NAME.'patient/patient_macro_history', $this->data);

			}

			else

			{

				redirect(base_url().MODULE_NAME.'patient');

			}

		}

		else{	

			redirect( base_url().MODULE_NAME.'dashboard/error/1');

		}

	}*/



	public function patientView(){

		if($this->checkViewPermission()){			

			$user_id = $this->uri->segment(4);

			$edit_user = $this->patient_model->editUser($user_id);

			if(!empty($edit_user)){

				$this->data['edit_user'] = $edit_user;

				$this->data['country_list'] = $this->common_model->getAllCountry();

				$this->data['patient_id'] = $user_id;

				$this->show_view(MODULE_NAME.'patient/patient_full_view', $this->data);

			}

			else{

				redirect(base_url().MODULE_NAME.'patient');

			}

		}

		else{	

			redirect( base_url().MODULE_NAME.'dashboard/error/1');

		}

	}

	public function updatePatient(){

    	$user_id = $this->uri->segment(4);

		if($user_id){

			if($this->checkEditPermission()){

				if (isset($_POST['Submit']) && $_POST['Submit'] == "Edit"){

					$this->form_validation->set_rules($this->validation_rules['patientUpdate']);

					$post['user_email'] = $this->input->post('user_email');			

					$res = $this->common_model->checkUniqueValueNew('tbl_user', 'user_email', $post['user_email'], 'user_id', $user_id, 'user_status');

					if($res){

						$this->form_validation->set_rules('user_email','User Email','trim|xss_clean|required|is_unique[tbl_user.user_email]|valid_email');

					}

					if($this->form_validation->run()){

						$post['role_id'] = '4';

						$post['user_fname'] = $this->input->post('user_fname');

						$post['user_lname'] = $this->input->post('user_lname');

						$post['user_mobile_no'] = $this->input->post('user_mobile_no');

						$user_password = $this->input->post('user_password');

						if($user_password){

							$post['user_password'] = md5($user_password);

						}

						$post['user_city'] = $this->input->post('user_city');

						$post['state_id'] = $this->input->post('state_id');

						$post['user_postal_code'] = $this->input->post('user_postal_code');

						$post['user_address'] = $this->input->post('user_address');

						if(!empty($post['user_address']))

                        {
                        	$post['user_latitude'] = $this->input->post('txtLat');
            				$post['user_longitude'] = $this->input->post('txtLng');

                            /*$address_data = $this->get_latlong_by_address($post['user_address']);

                           if(!empty($address_data))

                           {

                               $post['user_latitude'] = $address_data['latitude'];

                               $post['user_longitude'] = $address_data['longitude'];

                           }*/ 





                           $address_tbl_res = $this->common_model->getData('tbl_address', array('profile_address'=>1,'user_id'=>$user_id), 'single');

                           if(!empty($address_tbl_res))

                           {

                           	$chef_res = $this->common_model->getData('tbl_user', array('user_id'=>'2'), 'single');

                           	$global_res = $this->common_model->getData('tbl_global_setting', NULL, 'single');

                       		if(!empty($chef_res))

                       		{

                       			$lat1 = $chef_res->user_latitude;

								$lon1 = $chef_res->user_longitude;

								$lat2 = $post['user_latitude'];

								$lon2 = $post['user_longitude'];

								$distanc_res = $this->distanceCalculete($lat1, $lon1, $lat2, $lon2);

								if(!empty($distanc_res))

								{

									$post_adddr['total_distance']  = round($distanc_res);

									$check_distance = $this->common_model->checkDistanceRange($post_adddr['total_distance']);

									if(!empty($check_distance))

									{

										$post_adddr['distance_charge'] =  $check_distance->distance_amount;

									}

								}

                       		}
                       		if($post_adddr['total_distance'] <= '25')
							{
								$post_adddr['default_address'] 			='1';
								$post_adddr['address_approval_status'] 	= 'Approved';
							}
							else
							{
								$post_adddr['default_address'] 			='0';
								$post_adddr['address_approval_status'] 	= 'Pending';
							}
                       		$post_adddr['user_latitude'] = $post['user_latitude'];

                       		$post_adddr['user_longitude'] = $post['user_longitude'];

                       		/*$post_adddr['special_delivery_charge'] = $global_res->special_delivery_charge ;*/

                           	$post_adddr['user_address'] = $post['user_address'];

                           	$this->common_model->updateData('tbl_address', array('user_id'=>$user_id, 'profile_address'=>1),$post_adddr);

                           }

                        }

						$post['user_dob'] = $this->input->post('user_dob');

						$post['user_status'] = $this->input->post('user_status');						

						$post['email_reminder'] = $this->input->post('email_reminder');						

						$post['text_reminder'] = $this->input->post('text_reminder');						

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

						$this->patient_model->updateUser($n_post,$user_id);      

						$user_name = 'tbl_'.$user_id;

	                   	if($user_password){

							$post_l['user_password'] = md5($this->input->post('user_password'));

						}						

						$post_l['user_status'] = $this->input->post('user_status');

						$post_l['updated_date'] = date('Y-m-d');

						$n_post = $this->xssCleanValidate($post_l);

						$this->common_model->commonLoginTableUpdate($n_post,$user_name); 

	                   	$msg = 'Patient updated successfully!!';					

						$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');

						redirect(base_url().MODULE_NAME.'patient');

					}

					else{

						$edit_user = $this->patient_model->editUser($user_id);

						if(!empty($edit_user)){

							$this->data['edit_user'] = $edit_user;

							$this->data['patient_id'] = $user_id;

							$this->show_view(MODULE_NAME.'patient/patient_edit', $this->data);

						}

						else{

							redirect(base_url().MODULE_NAME.'patient/docpatientView/'.$doctor_id);

						}

					}

				}

				else{

					$edit_user = $this->patient_model->editUser($user_id);

					if(!empty($edit_user)){

						$this->data['edit_user'] 	= $edit_user;

						$this->data['patient_id'] 	= $user_id;

						

						$this->show_view(MODULE_NAME.'patient/patient_edit', $this->data);

					}

					else{

						redirect(base_url().MODULE_NAME.'patient/docpatientView/'.$doctor_id);

					}

				}

			}

			else{	

				redirect( base_url().MODULE_NAME.'dashboard/error/1');

			}

		}

    }



    public function delete_patient(){

		if($this->checkDeletePermission()){

			$user_id = $this->uri->segment(4);	

			$user_name = 'tbl_'.$user_id;	

			$n_post['user_status'] = '2';

			$this->common_model->updateData('tbl_user', array('user_id'=>$user_id), $n_post);

			$this->common_model->commonLoginTableUpdate($n_post,$user_name);

			$msg = 'Patient remove successfully...!';					

			$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-danger alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');

			redirect(base_url().MODULE_NAME.'patient');

		}

		else{

			redirect( base_url().MODULE_NAME.'dashboard/error/1');

		}		

	}

}

?>