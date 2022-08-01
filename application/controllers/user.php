<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Razorpay\Api\Api;

use Razorpay\Api\Errors\SignatureVerificationError;

class User extends My_Controller 

{

	function __construct()

	{

		parent::__construct();

        $this->load->model('admin/doc_patient_model'); 

	}

	  

    

    public function index()

	{

		if (isset($_POST['Submit']) && $_POST['Submit'] == "Add") 

		{
			$post['user_fname'] = $this->input->post('user_fname');

			$post['user_lname'] = $this->input->post('user_lname');

			$post['role_id'] = '4';

			$post['user_name'] = $this->input->post('user_name');

			/*$password 			= $this->generateRandomStringPassword(6);*/
			$password 			= $this->input->post('user_password');;

			$sha_password 		= hash('sha256', $password);

	       	$post['user_password'] 	= md5($sha_password);

			$post['user_email'] = $this->input->post('user_email');

			$post['user_mobile_no'] = $this->input->post('user_mobile_no');

			$post['user_dob'] = $this->input->post('user_dob');

			/*$post['country_id'] = $this->input->post('country_id');

			$post['state_id'] = $this->input->post('state_id');

			$post['user_postal_code'] = $this->input->post('user_postal_code');

			$post['user_city'] = $this->input->post('user_city');*/

			$post['state_id'] = $this->input->post('state_id');

			$post['user_postal_code'] = $this->input->post('user_postal_code');

			$post['user_city'] = $this->input->post('user_city');

			$user_address1 = $this->input->post('user_address1');

			$user_address2 = $this->input->post('user_address2');

			$post['user_address'] = $user_address1.' '.$user_address2;

			$post['email_reminder'] = $this->input->post('email_reminder');

			$post['text_reminder'] = $this->input->post('text_reminder');
			$post['user_latitude'] = $this->input->post('txtLat');
            $post['user_longitude'] = $this->input->post('txtLng');
            /*$post['user_address'] = $this->input->post('item_location');*/
			/*if(!empty($post['user_address']))

            {

                $address_data = $this->get_latlong_by_address($post['user_address']);

               if(!empty($address_data))

               {

                   $post['user_latitude'] = $address_data['latitude'];

                   $post['user_longitude'] = $address_data['longitude'];

               } 

            }*/

			$post['user_status'] = '1';							

			$post['doctor_id'] = '0';

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

				$post_l['user_status'] = '1';

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

				$global_res = $this->common_model->getData('tbl_global_setting', NULL, 'single');

				$registration_message = (!empty($global_res->registration_message)) ? $global_res->registration_message : '';
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



	       		$this->send_mail($post['user_email'], $subject, $credential_msg);



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

				$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$registration_message.'</div></div></section>');

				redirect(base_url().'login');                     

           	}

           	else

           	{

           		$msg = 'Email id allready ragistered!.';

				$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-danger alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');

					redirect(base_url().'user');	

           	}

            

		}

		else

		{

			$this->show_view_front('front/user', $this->data);

		}

    }



 	function checkEmailId(){



   		$user_email = $this->input->post('user_email');

	  	$check_user = $this->common_model->getData('tbl_user', array('user_email'=>$user_email, 'user_status !='=>'2'), 'single');

	    if(empty($check_user))

	    {						

		   echo "0";

		}

		else

		{

			echo "1";

		}

	}



	function check_user_name(){



   		$user_name = $this->input->post('user_name');

	  	$check_user = $this->common_model->getData('tbl_user', array('user_name'=>$user_name, 'user_status !='=>'2'), 'single');
	    if(empty($check_user))

	    {						

		   echo "0";

		}

		else

		{

			echo "1";

		}

	}



	function checkMobileNo(){



   		$user_mobile_no = $this->input->post('user_mobile_no');

	  	$check_user = $this->common_model->getData('tbl_user', array('user_mobile_no'=>$user_mobile_no, 'user_status !='=>'2'), 'single');

	    if(empty($check_user))

	    {						

		   echo "0";

		}

		else

		{

			echo "1";

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