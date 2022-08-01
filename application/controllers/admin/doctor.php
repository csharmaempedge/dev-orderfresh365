<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Doctor extends MY_Controller{



	function __construct(){



		parent::__construct();



		if(!empty(MODULE_NAME)){



			$this->load->model(MODULE_NAME.'doctor_model');



			$this->load->model(MODULE_NAME.'doc_patient_model');



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



                'rules' => 'trim|required|valid_email'



            ),



            array(



                'field' => 'user_name',



                'label' => 'User Name',



                'rules' => 'trim|required'



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



        ),



        'patientAdd' => array(



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



                'rules' => 'trim|required|valid_email'



            ),



            array(



                'field' => 'user_name',



                'label' => 'User Name',



                'rules' => 'trim|required'



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







	



	public function loadDocPatientListData(){

		$session = $this->session->all_userdata();



        $role_id = $this->data['session']->role_id;

    	$user_list = $this->doc_patient_model->getAllUserList();



    	$data = array();



        $no = $_POST['start'];



        foreach ($user_list as $u_res){



        	$check_patient_macro = $this->common_model->getData(' tbl_patient_macro', array('patient_id'=>$u_res->user_id), 'single');



        	$patient_macro_res = $this->common_model->getData('tbl_patient_macro', array('patient_id'=>$u_res->user_id), 'multi');



        	$check_patient_macro_history = $this->common_model->getData(' tbl_patient_macro_history', array('patient_id'=>$u_res->user_id), 'single');







        	$check_patient_breakfast = $this->common_model->getData(' tbl_patient_breakfast', array('patient_id'=>$u_res->user_id), 'single');



        	$check_patient_breakfast_history = $this->common_model->getData(' tbl_patient_breakfast_history', array('patient_id'=>$u_res->user_id), 'single');



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



			if(!empty($patient_macro_res))



			{



				$macro = array();



				foreach ($patient_macro_res as $p_res) 



				{



					$macro_res = $this->common_model->getData('tbl_macro', array('macro_id'=>$p_res->macro_id), 'single');



					 $macro[] = $macro_res->macro_name.' '.$p_res->macro_value_id;



					$set_macro =  implode(',', $macro);



				}



			}



			$row[] = (!empty($set_macro)) ? $set_macro : '';



			$btn1 = '';



	 		if($this->checkAddPermission()){



	 			if(empty($check_patient_macro))



	 			{



	 				$btn1 .= '<a class="btn btn-danger btn-sm" href="'.base_url().''.MODULE_NAME.'doctor/doctorCreateMeal/'.$u_res->user_id.'/'.$u_res->doctor_id.'" title="Create Macro"><i class="fa fa-plus fa-1x "></i></a>&nbsp;&nbsp;';



	 			}



	 			else



	 			{



	 				$btn1 .= '<a class="btn btn-info btn-sm" href="'.base_url().''.MODULE_NAME.'doctor/doctorCreateMeal/'.$u_res->user_id.'/'.$u_res->doctor_id.'" title="Update Macro"><i class="fa fa-edit fa-1x "></i></a>&nbsp;&nbsp;';



	 			}



	 		}



	 		$btn2 = '';



	 		if($this->checkViewPermission()){



	 			if(!empty($check_patient_macro_history))



	 			{



	 				$btn2 .= '<a class="btn btn-success btn-sm" href="'.base_url().''.MODULE_NAME.'doctor/patientMacroHistory/'.$u_res->user_id.'/'.$u_res->doctor_id.'" title="Macro History"><i class="fa fa-eye fa-1x "></i></a>&nbsp;&nbsp;';



	 			}



	 			else



	 			{



	 				$btn2 .= '';



	 			}



	 		}



	 		$row[] = $btn1.' '.$btn2;



	 		$btn3 = '';



	 		if($this->checkAddPermission()){



	 			if(empty($check_patient_breakfast))



	 			{



	 				$btn3 .= '<a class="btn btn-danger btn-sm" href="'.base_url().''.MODULE_NAME.'doctor/doctorCreateBreakfast/'.$u_res->user_id.'/'.$u_res->doctor_id.'" title="Create Breakfast"><i class="fa fa-plus fa-1x "></i></a>&nbsp;&nbsp;';



	 			}



	 			else



	 			{



	 				$btn3 .= '<a class="btn btn-info btn-sm" href="'.base_url().''.MODULE_NAME.'doctor/doctorCreateBreakfast/'.$u_res->user_id.'/'.$u_res->doctor_id.'" title="Update Breakfast"><i class="fa fa-edit fa-1x "></i></a>&nbsp;&nbsp;';



	 			}



	 		}



	 		$btn4 = '';



	 		if($this->checkViewPermission()){



	 			if(!empty($check_patient_macro_history))



	 			{



	 				$btn4 .= '<a class="btn btn-success btn-sm" href="'.base_url().''.MODULE_NAME.'doctor/patientBreakfastHistory/'.$u_res->user_id.'/'.$u_res->doctor_id.'" title="Macro History"><i class="fa fa-eye fa-1x "></i></a>&nbsp;&nbsp;';



	 			}



	 			else



	 			{



	 				$btn4 .= '';



	 			}



	 		}



	 		$row[] = $btn3.' '.$btn4;



	 		$btn = '';



	 		if($this->checkViewPermission()){



	 			$btn .= '<a class="btn btn-success btn-sm" href="'.base_url().''.MODULE_NAME.'doctor/patientView/'.$u_res->user_id.'/'.$u_res->doctor_id.'" title="View"><i class="fa fa-eye fa-1x "></i></a>&nbsp;&nbsp;';



	 		}



	 		if($this->checkEditPermission()){



	 			$btn .= '<a class="btn btn-primary btn-sm" href="'.base_url().''.MODULE_NAME.'doctor/updatePatient/'.$u_res->user_id.'/'.$u_res->doctor_id.'" title="Edit"><i class="fa fa-edit fa-1x "></i></a>&nbsp;&nbsp;';



	 			$chk_address_tbl_res = $this->common_model->getData('tbl_address', array('user_id'=>$u_res->user_id), 'single');

	 			if(!empty($chk_address_tbl_res))



	 			{

	 				if($role_id !='3')

	 				{



	 					$btn .= '<a class="btn btn-warning btn-sm" href="'.base_url().''.MODULE_NAME.'doctor/updateAddressRoute/'.$u_res->user_id.'/'.$u_res->doctor_id.'" title="Set Address Route"><i class="fa fa-edit fa-1x "></i></a>&nbsp;&nbsp;';	

	 				}

	 			}



	 		}



	 		if($this->checkDeletePermission()){



	 			$btn .= '<a class="confirm btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to Delete\')" href="'.base_url().''.MODULE_NAME.'doctor/delete_doctor_patient/'.$u_res->user_id.'/'.$u_res->doctor_id.'" title="Remove"><i class="fa fa-trash-o fa-1x" data-toggle="modal" data-target=".bs-example-modal-sm"></i></a>';



	 		}



	 		$row[] = $btn;



            $data[] = $row;



        }



        $output = array(



			"draw" => $_POST['draw'],



			"recordsTotal" => count($user_list),



			"recordsFiltered" => $this->doc_patient_model->count_filtered(),



			"data" => $data,



		);



       	echo json_encode($output);



    }



    public function doctorCreateMeal(){



		if($this->checkViewPermission()){			



			$user_id = $this->uri->segment(4);



			$doctor_id = $this->uri->segment(5);



			$edit_user = $this->common_model->getData('tbl_user', array('user_id'=>$user_id), 'single');



			if (isset($_POST['Submit']) && $_POST['Submit'] == "Edit") 



			{



				if(!empty($user_id))



               	{



               		/*History Add*/



               		$patient_macro_res = $this->common_model->getData('tbl_patient_macro', array('patient_id'=>$user_id), 'multi');



               		if(!empty($patient_macro_res))



               		{



               			foreach ($patient_macro_res as  $res) 



               			{



		               		$post_his['patient_macro_id']  	= $res->patient_macro_id;



							$post_his['macro_id']  				= $res->macro_id;



							$post_his['macro_value_id']  			= $res->macro_value_id;



							$post_his['patient_id']  			= $res->patient_id;



							$post_his['doctor_id']  			= $res->doctor_id;



							$post_his['note'] 	= $res->note;



							$post_his['patient_macro_to_date'] 	= $res->patient_macro_to_date;



							$post_his['patient_macro_from_date'] = $res->patient_macro_from_date;



							$post_his['patient_macro_created_date'] 	= $res->patient_macro_created_date;



							$post_his['patient_macro_updated_date'] 	= $res->patient_macro_updated_date;



							$nhis_post = $this->xssCleanValidate($post_his);



							$this->common_model->addData('tbl_patient_macro_history', $nhis_post);



							$this->common_model->deleteData('tbl_patient_macro', array('patient_macro_id'=>$res->patient_macro_id));







               			}



               		}







               		$macro_res = $this->common_model->getData('tbl_macro', array('macro_status'=>1), 'multi');



               		if(!empty($macro_res))



               		{



               			foreach ($macro_res as $res) 



               			{



               				$post_mc['macro_id']  				= $this->input->post('macro_id_'.$res->macro_id);



               				$post_mc['macro_value_id']  		= $this->input->post('macro_value_id_'.$res->macro_id);



               				$post_mc['patient_id']  			= $user_id;



							$post_mc['doctor_id']  				= $doctor_id;



							$post_mc['note'] 	= $this->input->post('note');



							$post_mc['patient_macro_to_date'] 	= $this->input->post('patient_macro_to_date');



							$post_mc['patient_macro_from_date'] = $this->input->post('patient_macro_from_date');



							$patient_macro_created_date 	= date('Y-m-d');;



							$day_name = date('l', strtotime($patient_macro_created_date));



							if($day_name == 'Saturday')



							{



								$cron_date = date('Y-m-d', strtotime('+4 day', strtotime($patient_macro_created_date)));



								$cron_day = 'Wednesday';



							}



							if($day_name == 'Sunday')



							{



								$cron_date = date('Y-m-d', strtotime('+3 day', strtotime($patient_macro_created_date)));



								$cron_day = 'Wednesday';



							}



							if($day_name == 'Monday')



							{



								$cron_date = date('Y-m-d', strtotime('+2 day', strtotime($patient_macro_created_date)));



								$cron_day = 'Wednesday';



							}



							if($day_name == 'Tuesday')



							{



								$cron_date = date('Y-m-d', strtotime('+1 day', strtotime($patient_macro_created_date)));



								$cron_day = 'Wednesday';



							}



							if($day_name == 'Wednesday')



							{



								$cron_date = $patient_macro_created_date;



								$cron_day = 'Wednesday';



							}



							if($day_name == 'Thursday')



							{



								$cron_date = date('Y-m-d', strtotime('+1 day', strtotime($patient_macro_created_date)));



								$cron_day = 'Friday';



							}



							if($day_name == 'Friday')



							{



								$cron_date = $patient_macro_created_date;



								$cron_day = 'Friday';



							}







							$post_mc['patient_macro_created_date'] 	= $patient_macro_created_date;



							$post_mc['cron_date'] 	= $cron_date;



							$post_mc['cron_day'] 	= $cron_day;



							/*echo "<pre>";



							print_r($cron_date.'-----------'.$cron_day);die;*/











							$post_mc['patient_macro_updated_date'] 	= date('Y-m-d');



							$nmc_post = $this->xssCleanValidate($post_mc);



							$this->common_model->addData('tbl_patient_macro', $nmc_post);



               			}



               		}                



               	}



               	$msg = 'Macro Created successfully!!';					



				$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');



				redirect(base_url().MODULE_NAME.'doctor/docpatientView/'.$doctor_id);



			}



			else



			{



				if(!empty($edit_user))



				{



					$this->data['edit_user'] = $edit_user;



					$this->data['patient_id'] = $user_id;



					$this->data['doctor_id'] = $doctor_id;



					$this->show_view(MODULE_NAME.'doctor/create_macro', $this->data);



				}



				else



				{



					redirect(base_url().MODULE_NAME.'doctor/docpatientView/'.$doctor_id);



				}



			}



		}



		else{	



			redirect( base_url().MODULE_NAME.'dashboard/error/1');



		}



	}







	public function patientMacroHistory(){



		if($this->checkViewPermission()){			



			$user_id = $this->uri->segment(4);



			$doctor_id = $this->uri->segment(5);



			$edit_user = $this->common_model->getData('tbl_user', array('user_id'=>$user_id), 'single');



			if(!empty($edit_user))



			{



				$this->data['edit_user'] = $edit_user;



				$this->data['patient_id'] = $user_id;



				$this->data['doctor_id'] = $doctor_id;



				$this->show_view(MODULE_NAME.'doctor/patient_macro_history', $this->data);



			}



			else



			{



				redirect(base_url().MODULE_NAME.'doctor');



			}



		}



		else{	



			redirect( base_url().MODULE_NAME.'dashboard/error/1');



		}



	}







	public function doctorCreateBreakfast(){



		if($this->checkViewPermission()){			



			$user_id = $this->uri->segment(4);



			$doctor_id = $this->uri->segment(5);



			$edit_user = $this->common_model->getData('tbl_user', array('user_id'=>$user_id), 'single');



			if (isset($_POST['Submit']) && $_POST['Submit'] == "Edit") 



			{



				if(!empty($user_id))



               	{



               		/*History Add*/



               		$patient_breakfast_res = $this->common_model->getData('tbl_patient_breakfast', array('patient_id'=>$user_id), 'multi');



               		if(!empty($patient_breakfast_res))



               		{



               			foreach ($patient_breakfast_res as  $res) 



               			{



		               		$post_his['patient_breakfast_id']  	= $res->patient_breakfast_id;



							$post_his['breakfast_id']  				= $res->breakfast_id;



							$post_his['product_id']  			= $res->product_id;



							$post_his['qty']  			= $res->qty;



							$post_his['patient_id']  			= $res->patient_id;



							$post_his['doctor_id']  			= $res->doctor_id;



							$post_his['note'] 	= $res->note;



							$post_his['patient_breakfast_to_date'] 	= $res->patient_breakfast_to_date;



							$post_his['patient_breakfast_from_date'] = $res->patient_breakfast_from_date;



							$post_his['patient_breakfast_created_date'] 	= $res->patient_breakfast_created_date;



							$post_his['patient_breakfast_updated_date'] 	= $res->patient_breakfast_updated_date;



							$nhis_post = $this->xssCleanValidate($post_his);



							$this->common_model->addData('tbl_patient_breakfast_history', $nhis_post);



							$this->common_model->deleteData('tbl_patient_breakfast', array('patient_breakfast_id'=>$res->patient_breakfast_id));







               			}



               		}







               		$breakfast_res = $this->common_model->getData('tbl_breakfast', NULL, 'multi');



               		if(!empty($breakfast_res))



               		{



               			foreach ($breakfast_res as $res) 



               			{



               				$post_br['breakfast_id']  				= $this->input->post('breakfast_id_'.$res->breakfast_id);



               				$post_br['product_id']  		= $this->input->post('product_id_'.$res->breakfast_id);



               				$post_br['qty']  		= $this->input->post('qty_'.$res->breakfast_id);



               				$post_br['patient_id']  			= $user_id;



							$post_br['doctor_id']  				= $doctor_id;



							$post_br['note'] 	= $this->input->post('note');



							$post_br['patient_breakfast_to_date'] 	= $this->input->post('patient_breakfast_to_date');



							$post_br['patient_breakfast_from_date'] = $this->input->post('patient_breakfast_from_date');



							$post_br['patient_breakfast_created_date'] 	= date('Y-m-d');



							$post_br['patient_breakfast_updated_date'] 	= date('Y-m-d');



							$nmc_post = $this->xssCleanValidate($post_br);



							$this->common_model->addData('tbl_patient_breakfast', $nmc_post);



               			}



               		}                



               	}



               	$msg = 'Breakfast Created successfully!!';					



				$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');



				redirect(base_url().MODULE_NAME.'doctor/docpatientView/'.$doctor_id);



			}



			else



			{



				if(!empty($edit_user))



				{



					$this->data['edit_user'] = $edit_user;



					$this->data['patient_id'] = $user_id;



					$this->data['doctor_id'] = $doctor_id;



					$this->show_view(MODULE_NAME.'doctor/create_breakfast', $this->data);



				}



				else



				{



					redirect(base_url().MODULE_NAME.'doctor/docpatientView/'.$doctor_id);



				}



			}



		}



		else{	



			redirect( base_url().MODULE_NAME.'dashboard/error/1');



		}



	}







	public function patientBreakfastHistory(){



		if($this->checkViewPermission()){			



			$user_id = $this->uri->segment(4);



			$doctor_id = $this->uri->segment(5);



			$edit_user = $this->common_model->getData('tbl_user', array('user_id'=>$user_id), 'single');



			if(!empty($edit_user))



			{



				$this->data['edit_user'] = $edit_user;



				$this->data['patient_id'] = $user_id;



				$this->data['doctor_id'] = $doctor_id;



				$this->show_view(MODULE_NAME.'doctor/patient_breakfast_history', $this->data);



			}



			else



			{



				redirect(base_url().MODULE_NAME.'doctor');



			}



		}



		else{	



			redirect( base_url().MODULE_NAME.'dashboard/error/1');



		}



	}



    public function patientView(){



		if($this->checkViewPermission()){			



			$user_id = $this->uri->segment(4);



			$doctor_id = $this->uri->segment(5);



			$edit_user = $this->doc_patient_model->editUser($user_id);



			if(!empty($edit_user)){



				$this->data['edit_user'] = $edit_user;



				$this->data['country_list'] = $this->common_model->getAllCountry();



				$this->data['doctor_id'] = $doctor_id;



				$this->data['patient_id'] = $user_id;



				$this->show_view(MODULE_NAME.'doctor/patient_full_view', $this->data);



			}



			else{



				redirect(base_url().MODULE_NAME.'doctor');



			}



		}



		else{	



			redirect( base_url().MODULE_NAME.'dashboard/error/1');



		}



	}







	/* Add & update */



    public function updateAddressRoute(){



    	$user_id = $this->uri->segment(4);



    	$doctor_id = $this->uri->segment(5);



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



					redirect(base_url().MODULE_NAME.'doctor/updateAddressRoute/'.$user_id);



					



				}



				else{



					$this->data['patient_id'] 	= $user_id;



					$this->data['doctor_id'] 	= $doctor_id;



					$this->show_view(MODULE_NAME.'doctor/patient_address_view', $this->data);



				}



			}



			else{	



				redirect( base_url().MODULE_NAME.'dashboard/error/1');



			}



		}



    }







    public function approvedAddress()



    {



        $address_id 		= $this->input->post('address_id');



        $patient_id 		= $this->input->post('patient_id');



        $post['address_approval_status'] 	= 'Approved';



        $this->common_model->updateData('tbl_address',array('address_id'=>$address_id), $post);  







        /*PATIENT NOTIFICATION*/



		$patient_res = $this->common_model->getData('tbl_user',array('user_id'=>$patient_id), 'single');



		$subject_chef = "Address Approved";



   		$chef_credential_msg  = '';



		$chef_credential_msg .= '<html><body bgcolor="#f6f8f1" style="min-width: 100% !important;color:#111 ; margin: 0; padding: 0;">';



		$chef_credential_msg .= 'Dear "'.$patient_res->user_fname.' '.$patient_res->user_lname.'", your new address has been approved, your deliveries will be directed to this address.';



		$chef_credential_msg .= '<p><b>Team CIRCADIAN FOOD </b></p>';



		$chef_credential_msg .= '</body></html>';







		$message = 'Dear "'.$patient_res->user_fname.' '.$patient_res->user_lname.'", your new address has been approved, your deliveries will be directed to this address';



		$this->clickSendMessage($patient_res->user_mobile_no, $message);



		$this->send_mail($patient_res->user_email, $subject_chef, $chef_credential_msg);         



    }







    /* Add & update */



    public function updatePatient(){



    	$user_id = $this->uri->segment(4);



    	$doctor_id = $this->uri->segment(5);



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



						/*$post['country_id'] = $this->input->post('country_id');*/



						$post['state_id'] = $this->input->post('state_id');



						$post['user_city'] = $this->input->post('user_city');



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



                           } */



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



                           		$post_adddr['address_approval_status'] = 'Pending';



                           		/*$post_adddr['special_delivery_charge'] = $global_res->special_delivery_charge ;*/



                           		$post_adddr['user_address'] = $post['user_address'];



                           		$this->common_model->updateData('tbl_address', array('user_id'=>$user_id, 'profile_address'=>1),$post_adddr);



                           }



                        }



						$post['user_postal_code'] = $this->input->post('user_postal_code');



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



						$this->doc_patient_model->updateUser($n_post,$user_id);                         



	                   	$user_name = 'tbl_'.$user_id;



	                   	if($user_password){



							$post_l['user_password'] = md5($this->input->post('user_password'));



						}						



						$post_l['user_status'] = $this->input->post('user_status');



						$post_l['updated_date'] = date('Y-m-d');



						$n_post = $this->xssCleanValidate($post_l);



						$this->common_model->commonLoginTableUpdate($n_post,$user_name);



						/*Address Mail*/

						/*CHEF NOTIFICATION*/

						$pp_res = $this->common_model->getData('tbl_user',array('user_id'=>$user_id), 'single');



						$subject_address = "New Address Registration";



				   		$chef_message_address  = '';



						$chef_message_address .= '<html><body bgcolor="#f6f8f1" style="min-width: 100% !important;color:#111 ; margin: 0; padding: 0;">';



						$chef_message_address .= 'Dear Chef, "'.$pp_res->user_fname.' '.$pp_res->user_lname.'" "'.$pp_res->user_mobile_no.'" have added a new address into the system please review that address and give the specific charge of that address and give acceptance to that address';



						$chef_message_address .= '<p><b>Thanks & Regards</b></p>';



						$chef_message_address .= '<p><b>Team CIRCADIAN FOOD </b></p>';



						$chef_message_address .= '</body></html>';







						$message = 'Dear Chef, "'.$pp_res->user_fname.' '.$pp_res->user_lname.'" "'.$pp_res->user_mobile_no.'" have added a new address into the system please review that address and give the specific charge of that address and give acceptance to that address';



						$this->clickSendMessage($chef_res->user_mobile_no, $message);



						$this->send_mail($chef_res->user_email, $subject_address, $chef_message_address);



	                   	$msg = 'Patient updated successfully!!';					



						$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');



						redirect(base_url().MODULE_NAME.'doctor/docpatientView/'.$doctor_id);



					}



					else{



						$edit_user = $this->doc_patient_model->editUser($user_id);



						if(!empty($edit_user)){



							$this->data['edit_user'] = $edit_user;



							$this->data['patient_id'] = $user_id;



							$this->data['doctor_id'] = $doctor_id;



							$this->data['country_list'] = $this->common_model->getAllCountry();



							$this->show_view(MODULE_NAME.'doctor/patient_update', $this->data);



						}



						else{



							redirect(base_url().MODULE_NAME.'doctor/docpatientView/'.$doctor_id);



						}



					}



				}



				else{



					$edit_user = $this->doc_patient_model->editUser($user_id);



					if(!empty($edit_user)){



						$this->data['edit_user'] 	= $edit_user;



						$this->data['patient_id'] 	= $user_id;



						$this->data['doctor_id'] 	= $doctor_id;



						$this->data['country_list'] = $this->common_model->getAllCountry();



						$this->show_view(MODULE_NAME.'doctor/patient_update', $this->data);



					}



					else{



						redirect(base_url().MODULE_NAME.'doctor/docpatientView/'.$doctor_id);



					}



				}



			}



			else{	



				redirect( base_url().MODULE_NAME.'dashboard/error/1');



			}



		}



    }







    /* Add & update */



    public function addPatient(){



    	$doctor_id = $this->uri->segment(4);



		if($doctor_id){



			if($this->checkAddPermission()){



				if (isset($_POST['Submit']) && $_POST['Submit'] == "Add"){



					$this->form_validation->set_rules($this->validation_rules['patientAdd']);



					if($this->form_validation->run()){



						$post['user_fname'] = $this->input->post('user_fname');



						$post['user_lname'] = $this->input->post('user_lname');



						$post['role_id'] = '4';



						$post['user_name'] = $this->input->post('user_name');



						/*$password 			= $this->generateRandomStringPassword(6);*/

						$password 			= $this->input->post('user_password');



						$sha_password 		= hash('sha256', $password);



				       	$post['user_password'] 	= md5($sha_password);



						$post['user_email'] = $this->input->post('user_email');



						$post['user_mobile_no'] = $this->input->post('user_mobile_no');



						$post['user_dob'] = $this->input->post('user_dob');



						/*$post['country_id'] = $this->input->post('country_id');*/



						$post['state_id'] = $this->input->post('state_id');



						$post['user_postal_code'] = $this->input->post('user_postal_code');



						$post['user_city'] = $this->input->post('user_city');

						$user_address1 = $this->input->post('user_address');



						$user_address2 = $this->input->post('user_address2');



						$post['user_address'] = $user_address1.' '.$user_address2;

						$post['user_latitude'] = $this->input->post('txtLat');

            			$post['user_longitude'] = $this->input->post('txtLng');

						/*if(!empty($post['user_address']))



                        {



                            $address_data = $this->get_latlong_by_address($post['user_address']);



                           if(!empty($address_data))



                           {



                               $post['user_latitude'] = $address_data['latitude'];



                               $post['user_longitude'] = $address_data['longitude'];



                           } 



                        }*/



						$post['user_status'] = $this->input->post('user_status');						



						$post['text_reminder'] = $this->input->post('text_reminder');						



						$post['email_reminder'] = $this->input->post('email_reminder');						



						$post['doctor_id'] = $doctor_id;



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



	                   	$check_user_mail = $this->common_model->getData('tbl_user',array('user_email'=>$post['user_email'], 'user_status !='=>'2'), 'single');

	                   	if(empty($check_user_mail))

	                   	{

	                   		$n_post = $this->xssCleanValidate($post);



		                   	$user_login_tbl_id = $this->doc_patient_model->addUser($n_post);



		                   	$post_l['user_name'] = $this->input->post('user_name');



							$post_l['user_password'] = 	$post['user_password'];



							$post_l['user_status'] = $this->input->post('user_status');



							$post_l['module_name'] = 'admin';



							$post_l['user_type'] = 'admin';



							$post_l['tbl_name'] = 'tbl_user';



							$post_l['user_id'] = 'tbl_'.$user_login_tbl_id;



							$post_l['created_date'] = date('Y-m-d');



							$post_l['updated_date'] = date('Y-m-d');



							$n_post_n = $this->xssCleanValidate($post_l);



							$this->doc_patient_model->addUserLogin ($n_post_n);



							/*ADdress Table */



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



									$post_addr['total_distance']  = round($distanc_res);



									$check_distance = $this->common_model->checkDistanceRange($post_addr['total_distance']);



									if(!empty($check_distance))



									{



										$post_addr['distance_charge'] =  $check_distance->distance_amount;



									}



								}



	                   		}

	                   		if($post_addr['total_distance'] <= '25')

							{

								$post_addr['default_address'] 			='1';

								$post_addr['address_approval_status'] 	= 'Approved';

							}

							else

							{

								$post_addr['default_address'] 			='0';

								$post_addr['address_approval_status'] 	= 'Pending';

							}



	                   		$post_addr['user_latitude'] = $post['user_latitude'];



	                   		$post_addr['user_longitude'] = $post['user_longitude'];



	                   		$post_addr['special_delivery_charge'] = $global_res->special_delivery_charge ;



							$post_addr['user_id'] 				= $user_login_tbl_id;



							$post_addr['user_address'] 			= $post['user_address'];



							$post_addr['profile_address'] 		= 1;



							$post_addr['address_created_date'] 	= date('Y-m-d');



							$this->common_model->addData('tbl_address', $post_addr);



							/*SELF PIKUP ADDRESS*/



							$post_add_new['total_distance']  = '0';



							$post_add_new['distance_charge'] =  '0';



							$post_add_new['user_latitude'] = '';;



			           		$post_add_new['user_longitude'] = '';;



			           		$post_add_new['address_approval_status'] = 'Approved';



			           		$post_add_new['special_delivery_charge'] ='0';



							$post_add_new['user_id'] 				= $user_login_tbl_id;



							$post_add_new['user_address'] 			='Pickup';



							$post_add_new['default_address'] 			='1';



							$post_add_new['profile_address'] 		= 0;



							$post_add_new['address_created_date'] 	= date('Y-m-d');



							$this->common_model->addData('tbl_address', $post_add_new);



				       		$pp_res = $this->common_model->getData('tbl_user',array('user_id'=>$user_login_tbl_id), 'single');

				       		$patient_registration_mail = (!empty($global_res->patient_registration_mail)) ? $global_res->patient_registration_mail : '';

				       		/*SEND MAIL PATIENT*/



							$loginUrl  = base_url();



							$credential_msg  = '';



							$credential_msg .= '<html><body bgcolor="#f6f8f1" style="min-width: 100% !important;color:#111 ; margin: 0; padding: 0;">';



							$credential_msg .= '<p><b>Dear  ' .$pp_res->user_fname.' '.$pp_res->user_lname.'</b></p>';



							$credential_msg .= '<p>Your Login Url:  '.$loginUrl.' </p>';







							$credential_msg .= '<p><b>User Name :- </b> '.$pp_res->user_name.'</p>';



							$credential_msg .= '<p><b>Password :- </b> '.$password.'</p>';
							$credential_msg .= '<p>'.$patient_registration_mail.'</p>';



							$credential_msg .= '<p><b>Thanks & Regards</b></p>';



							$credential_msg .= '<p><b>Team CIRCADIAN FOOD </b></p>';



							$credential_msg .= '</body></html>';



					       	$subject = "Patient Login Details";







				       		$this->send_mail($pp_res->user_email, $subject, $credential_msg);







						    //CHEF SEND Mail



					    	$subject_chef = "New Patient Registration";







				       		$chef_credential_msg  = '';



							$chef_credential_msg .= '<html><body bgcolor="#f6f8f1" style="min-width: 100% !important;color:#111 ; margin: 0; padding: 0;">';



							$chef_credential_msg .= '<p><b>Patient  Name  ' .$pp_res->user_fname.' '.$pp_res->user_lname.'</b></p>';







							$chef_credential_msg .= '<p><b>User Name :- </b> '.$pp_res->user_name.'</p>';



							$chef_credential_msg .= '<p><b>Password :- </b> '.$password.'</p>';



							$chef_credential_msg .= '<p><b>Thanks & Regards</b></p>';



							$chef_credential_msg .= '<p><b>Team CIRCADIAN FOOD </b></p>';



							$chef_credential_msg .= '</body></html>';



							$this->send_mail($chef_res->user_email, $subject_chef, $chef_credential_msg);     



							/*Address Mail*/

							/*CHEF NOTIFICATION*/



							$subject_address = "New Address Registration";



					   		$chef_message_address  = '';



							$chef_message_address .= '<html><body bgcolor="#f6f8f1" style="min-width: 100% !important;color:#111 ; margin: 0; padding: 0;">';



							$chef_message_address .= 'Dear Chef, "'.$pp_res->user_fname.' '.$pp_res->user_lname.'" "'.$pp_res->user_mobile_no.'" have added a new address into the system please review that address and give the specific charge of that address and give acceptance to that address';



							$chef_message_address .= '<p><b>Thanks & Regards</b></p>';



							$chef_message_address .= '<p><b>Team CIRCADIAN FOOD </b></p>';



							$chef_message_address .= '</body></html>';







							$message = 'Dear Chef, "'.$pp_res->user_fname.' '.$pp_res->user_lname.'" "'.$pp_res->user_mobile_no.'" have added a new address into the system please review that address and give the specific charge of that address and give acceptance to that address';



							$this->clickSendMessage($chef_res->user_mobile_no, $message);



							$this->send_mail($chef_res->user_email, $subject_address, $chef_message_address);                  



		                   	$msg = 'Patient added successfully!!';					



							$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');



							redirect(base_url().MODULE_NAME.'doctor/docpatientView/'.$doctor_id);

	                   	}

	                   	else

	                   	{

	                   		$msg = 'Email id allready ragistered!.';



							$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-danger alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');



								redirect(base_url().MODULE_NAME.'doctor/docpatientView/'.$doctor_id);

	                   	}



                        



	                }



					else{



						$this->data['country_list'] = $this->common_model->getAllCountry();



						$this->data['doctor_id'] = $doctor_id;



						$this->show_view(MODULE_NAME.'doctor/patient_add', $this->data);



					}



				}



				else{



					$this->data['country_list'] = $this->common_model->getAllCountry();



					$this->data['doctor_id'] = $doctor_id;



					$this->show_view(MODULE_NAME.'doctor/patient_add', $this->data);



				}



			}



			else{	



				redirect( base_url().MODULE_NAME.'dashboard/error/1');



			}



		}



    }















    /*DOCTOR*/



     public function index(){



     	$session = $this->session->all_userdata();



        $role_id = $this->data['session']->role_id;



        $user_id = $this->data['session']->user_id;



        if($role_id == '2')



        {



        	$this->doctorIndex();



        }



        else



        {



        	$this->docpatientView($user_id);



        }



    }



    public function doctorIndex(){



		if($this->checkViewPermission()){			



			$this->data['user_res'] = $this->doctor_model->getAllUserList();		



			$this->show_view(MODULE_NAME.'doctor/doctor_view', $this->data);



		}



		else{	



			redirect( base_url().MODULE_NAME.'dashboard/error/1');



		}



    }







    public function loadUserListData(){



    	$user_list = $this->doctor_model->getAllUserList();



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



			$row[] = '<a href="'.base_url().''.MODULE_NAME.'doctor/docpatientView/'.$u_res->user_id.'" </a>'.$u_res->user_fname.' '.$u_res->user_lname.'&nbsp;&nbsp;';



			$row[] = $u_res->user_email;



			$row[] = $u_res->user_mobile_no;



			$row[] = viewStatus($u_res->user_status);



	 		$btn = '';



	 		if($this->checkViewPermission()){



	 			$btn .= '<a class="btn btn-success btn-sm" href="'.base_url().''.MODULE_NAME.'doctor/docpatientView/'.$u_res->user_id.'" title="Patient List"><i class="fa fa-eye fa-1x "></i></a>&nbsp;&nbsp;';







	 			$btn .= '<a class="btn btn-primary btn-sm" href="'.base_url().''.MODULE_NAME.'doctor/doctorView/'.$u_res->user_id.'" title="View"><i class="fa fa-eye fa-1x "></i></a>&nbsp;&nbsp;';



	 		}



	 		if($this->checkEditPermission()){



	 			$btn .= '<a class="btn btn-success btn-sm" href="'.base_url().''.MODULE_NAME.'doctor/addDoctor/'.$u_res->user_id.'" title="Edit"><i class="fa fa-edit fa-1x "></i></a>&nbsp;&nbsp;';



	 		}



	 		/*if($this->checkDeletePermission()){



	 			$btn .= '<a class="confirm btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to Delete\')" href="'.base_url().''.MODULE_NAME.'doctor/delete_doctor/'.$u_res->user_id.'" title="Remove"><i class="fa fa-trash-o fa-1x" data-toggle="modal" data-target=".bs-example-modal-sm"></i></a>';



	 		}*/



	 		$row[] = $btn;



            $data[] = $row;



        }



        $output = array(



			"draw" => $_POST['draw'],



			"recordsTotal" => count($user_list),



			"recordsFiltered" => $this->doctor_model->count_filtered(),



			"data" => $data,



		);



       	echo json_encode($output);



    }



    public function docpatientView($user_id = ''){



		if($this->checkViewPermission()){			



			/*$user_id = $this->uri->segment(4);*/



			$edit_user = $this->doc_patient_model->editUser($user_id);



			if(!empty($edit_user)){



				$this->data['edit_user'] = $edit_user;



				$this->data['country_list'] = $this->common_model->getAllCountry();



				$this->data['doctor_id'] = $user_id;



				$this->show_view(MODULE_NAME.'doctor/doc_patient_view', $this->data);



			}



			else{



				redirect(base_url().MODULE_NAME.'doctor');



			}



		}



		else{	



			redirect( base_url().MODULE_NAME.'dashboard/error/1');



		}



	}



	public function doctorView(){



		if($this->checkViewPermission()){			



			$user_id = $this->uri->segment(4);



			$edit_user = $this->doctor_model->editUser($user_id);



			if(!empty($edit_user)){



				$this->data['edit_user'] = $edit_user;



				$this->data['country_list'] = $this->common_model->getAllCountry();



				$this->show_view(MODULE_NAME.'doctor/doctor_full_view', $this->data);



			}



			else{



				redirect(base_url().MODULE_NAME.'doctor');



			}



		}



		else{	



			redirect( base_url().MODULE_NAME.'dashboard/error/1');



		}



	}



 



    /* Add & update */



    public function addDoctor(){



    	$user_id = $this->uri->segment(4);



		if($user_id){



			if($this->checkEditPermission()){



				if (isset($_POST['Submit']) && $_POST['Submit'] == "Edit"){



					$this->form_validation->set_rules($this->validation_rules['userUpdate']);



					$post['user_email'] = $this->input->post('user_email');			



					$res = $this->common_model->checkUniqueValueNew('tbl_user', 'user_email', $post['user_email'], 'user_id', $user_id, 'user_status');



					if($res){



						$this->form_validation->set_rules('user_email','User Email','trim|xss_clean|required|is_unique[tbl_user.user_email]|valid_email');



					}



					if($this->form_validation->run()){



						$post['role_id'] = '3';



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



						if(!empty($post['user_address']))



                        {



                            $address_data = $this->get_latlong_by_address($post['user_address']);



                           if(!empty($address_data))



                           {



                               $post['user_latitude'] = $address_data['latitude'];



                               $post['user_longitude'] = $address_data['longitude'];



                           } 



                        }



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



						$this->doctor_model->updateUser($n_post,$user_id);                         



	                   	$user_name = 'tbl_'.$user_id;



	                   	if($user_password){



							$post_l['user_password'] = md5($this->input->post('user_password'));



						}						



						$post_l['user_status'] = $this->input->post('user_status');



						$post_l['updated_date'] = date('Y-m-d');



						$n_post = $this->xssCleanValidate($post_l);



						$this->common_model->commonLoginTableUpdate($n_post,$user_name);



	                   	$msg = 'Doctor updated successfully!!';					



						$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');



						redirect(base_url().MODULE_NAME.'doctor');



					}



					else{



						$edit_user = $this->doctor_model->editUser($user_id);



						if(!empty($edit_user)){



							$this->data['edit_user'] = $edit_user;



							$this->data['country_list'] = $this->common_model->getAllCountry();



							$this->show_view(MODULE_NAME.'doctor/doctor_update', $this->data);



						}



						else{



							redirect(base_url().MODULE_NAME.'doctor');



						}



					}



				}



				else{



					$edit_user = $this->doctor_model->editUser($user_id);



					if(!empty($edit_user)){



						$this->data['edit_user'] = $edit_user;



						$this->data['country_list'] = $this->common_model->getAllCountry();



						$this->show_view(MODULE_NAME.'doctor/doctor_update', $this->data);



					}



					else{



						redirect(base_url().MODULE_NAME.'doctor');



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



						$post['role_id'] = '3';



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



						if(!empty($post['user_address']))



                        {



                            $address_data = $this->get_latlong_by_address($post['user_address']);



                           if(!empty($address_data))



                           {



                               $post['user_latitude'] = $address_data['latitude'];



                               $post['user_longitude'] = $address_data['longitude'];



                           } 



                        }



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



	                   	$user_login_tbl_id = $this->doctor_model->addUser($n_post);



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



						$this->doctor_model->addUserLogin ($n_post_n);                        



	                   	$msg = 'Doctor added successfully!!';					



						$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');



						redirect(base_url().MODULE_NAME.'doctor');



	                }



					else{



						$this->data['country_list'] = $this->common_model->getAllCountry();



						$this->show_view(MODULE_NAME.'doctor/doctor_add', $this->data);



					}



				}



				else{



					$this->data['country_list'] = $this->common_model->getAllCountry();



					$this->show_view(MODULE_NAME.'doctor/doctor_add', $this->data);



				}



			}



			else{	



				redirect( base_url().MODULE_NAME.'dashboard/error/1');



			}



		}



    }







	public function delete_doctor_patient(){



		if($this->checkDeletePermission()){



			$user_id = $this->uri->segment(4);



    		$doctor_id = $this->uri->segment(5);	



			$user_name = 'tbl_'.$user_id;	



			/*$n_post['user_status'] = '2';



			$this->doctor_model->updateUser($n_post,$user_id);



			$this->common_model->commonLoginTableUpdate($n_post,$user_name);*/

			$n_post['doctor_id'] = '0';



			$this->doctor_model->updateUser($n_post,$user_id);



			$msg = 'Patient remove successfully...!';					



			$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-danger alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');



			redirect(base_url().MODULE_NAME.'doctor/docpatientView/'.$doctor_id);



		}



		else{



			redirect( base_url().MODULE_NAME.'dashboard/error/1');



		}		



	}



	public function delete_doctor(){



		if($this->checkDeletePermission()){



			$user_id = $this->uri->segment(4);	



			$user_name = 'tbl_'.$user_id;	



			$n_post['user_status'] = '2';



			$this->doctor_model->updateUser($n_post,$user_id);



			$this->common_model->commonLoginTableUpdate($n_post,$user_name);



			$msg = 'Doctor remove successfully...!';					



			$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');



			redirect(base_url().MODULE_NAME.'doctor');



		}



		else{



			redirect( base_url().MODULE_NAME.'dashboard/error/1');



		}		



	}



	public function generateRandomStringPassword($length) 



  	{



       $characters = '0123456789';



       $charactersLength = strlen($characters);



       $randomString = '';



       for ($i = 0; $i < $length; $i++) 



       {



           $randomString .= $characters[rand(0, $charactersLength - 1)];



       }



       return $randomString;



 	}



}



?>