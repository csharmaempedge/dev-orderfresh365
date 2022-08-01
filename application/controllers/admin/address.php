<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Address extends MY_Controller {

	function __construct(){

		parent::__construct();

		if(!empty(MODULE_NAME))

		{

			$this->load->model(MODULE_NAME.'address_model');

		}

	}

	/* Details */

	public function index(){

		if($this->checkViewPermission()){

			$this->show_view(MODULE_NAME.'address/address_view',$this->data);

		}else{	

			redirect(base_url().MODULE_NAME.'dashboard/error/1');

		}

    }

    public function loadAddressListData()

    {

    	$customer_list = $this->address_model->getAllAddressList();

    	$data = array();

        $no = $_POST['start'];

        foreach ($customer_list as $c_res) 

	    {

			$no++;

			$row   = array();

			$row[] = $no;

			$row[] = $c_res->user_address;

			$default_address = '';

			if($c_res->default_address==1)

	            {  

	                  $default_address  .='<label class="switch">

	                        <input type="checkbox"  checked class="switch_on" onchange="inActiveStatus('.$c_res->address_id.');">

	                        <span class="slider round"></span>

	                      </label>';

	            }

	            else

	            {

	                $default_address  .='<label class="switch">

	                    <input type="checkbox" class="switch_off" onchange="activeStatus('.$c_res->address_id.');">

	                    <span class="slider round"></span>

	                  </label>';

	            }

            

            $row[] = $default_address;

            if($c_res->address_approval_status == 'Approved')

			{

				$approved_img = '<img width="40px"src="'.base_url().'webroot/address_img/approved.jpg'.'">';

			}

			else

			{

				$approved_img = '<img width="40px"src="'.base_url().'webroot/address_img/not_approved.jpg'.'">';

			}

			$row[] = $approved_img;

	 		$btn = '';

	 		if($this->checkViewPermission())

	 		{

	 			$btn .= '<a class="btn btn-primary btn-sm" href="'.base_url().''.MODULE_NAME.'address/addressView/'.$c_res->address_id.'" title="View"><i class="fa fa-eye fa-1x "></i></a>&nbsp;&nbsp;';

	 		}

	 		if($this->checkEditPermission())

	 		{

	 			$btn .= '<a class="btn btn-success btn-sm" href="'.base_url().''.MODULE_NAME.'address/addAddress/'.$c_res->address_id.'" title="Edit"><i class="fa fa-edit fa-1x "></i></a>&nbsp;&nbsp;';

	 		}

	 		if($this->checkDeletePermission())

	 		{

	 			/*$btn .= '<a class="confirm btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to Delete\')" href="'.base_url().''.MODULE_NAME.'address/deleteAddress/'.$c_res->address_id.'" title="Remove"><i class="fa fa-trash-o fa-1x" data-toggle="modal" data-target=".bs-example-modal-sm"></i></a>';*/

	 		}

	 		$row[] = $btn;

            $data[] = $row;

        }

        $output = array(

			"draw" => $_POST['draw'],

			"recordsTotal" => count($customer_list),

			"recordsFiltered" => $this->address_model->count_filtered(),

			"data" => $data,

		);

       	//output to json format

       	echo json_encode($output);

    }

    /* Add and Update */

	public function addAddress($address_id = ''){

		$patient_id = $this->data['session']->user_id;

     	if($address_id)

		{

			if($this->checkEditPermission())

			{

				if (isset($_POST['Submit']) && $_POST['Submit'] == "Edit") 

				{

					$post['user_address'] 		 	= $this->input->post('user_address');
					$post['user_latitude'] = $this->input->post('txtLat');
            		$post['user_longitude'] = $this->input->post('txtLng');

					$chef_res = $this->common_model->getData('tbl_user', array('user_id'=>'2'), 'single');

					$global_res = $this->common_model->getData('tbl_global_setting', NULL, 'single');

					/*$address_data = $this->get_latlong_by_address($post['user_address']);*/

						$user_latitude = $post['user_latitude'];

               			$user_longitude = $post['user_longitude'];

		           		if(!empty($chef_res))

		           		{

		           			$lat1 = $chef_res->user_latitude;

							$lon1 = $chef_res->user_longitude;

							$lat2 = $user_latitude;

							$lon2 = $user_longitude;

							$distanc_res = $this->distanceCalculete($lat1, $lon1, $lat2, $lon2);

							if(!empty($distanc_res))

							{

								$post['total_distance']  = round($distanc_res);

								$check_distance = $this->common_model->checkDistanceRange($post['total_distance']);

								if(!empty($check_distance))

								{

									$post['distance_charge'] =  $check_distance->distance_amount;

								}

							}

		           		}

					if($post['total_distance'] <= '25')
					{
						$post['default_address'] 			='1';
						$post['address_approval_status'] 	= 'Approved';
					}
					else
					{
						$post['default_address'] 			='0';
						$post['address_approval_status'] 	= 'Pending';
					}

	           		$post['user_latitude'] = $user_latitude;

	           		$post['user_longitude'] = $user_longitude;


	           		$post['special_delivery_charge'] = $global_res->special_delivery_charge ;

					$post['user_id'] 				= $patient_id;

					$this->common_model->updateData('tbl_address',array('address_id'=>$address_id),$post);

					/*CHEF NOTIFICATION*/

					$patient_res = $this->common_model->getData('tbl_user',array('user_id'=>$patient_id), 'single');

					$subject_chef = "New Address Registration";

			   		$chef_credential_msg  = '';

					$chef_credential_msg .= '<html><body bgcolor="#f6f8f1" style="min-width: 100% !important;color:#111 ; margin: 0; padding: 0;">';

					$chef_credential_msg .= 'Dear Chef, "'.$patient_res->user_fname.' '.$patient_res->user_lname.'" "'.$patient_res->user_mobile_no.'" have added a new address into the system please review that address and give the specific charge of that address and give acceptance to that address';

					$chef_credential_msg .= '<p><b>Thanks & Regards</b></p>';

					$chef_credential_msg .= '<p><b>Team CIRCADIAN FOOD </b></p>';

					$chef_credential_msg .= '</body></html>';



					$message = 'Dear Chef, "'.$patient_res->user_fname.' '.$patient_res->user_lname.'" "'.$patient_res->user_mobile_no.'" have added a new address into the system please review that address and give the specific charge of that address and give acceptance to that address';

					$this->clickSendMessage($chef_res->user_mobile_no, $message);

					$this->send_mail($chef_res->user_email, $subject_chef, $chef_credential_msg);

                    $msg = 'Address Updated successfully!';	

					$this->session->set_flashdata('message', '<section class="content"><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');

					redirect(MODULE_NAME.'address');

				}

				else

				{

					$this->data['address_edit'] = $this->common_model->getData('tbl_address',array('address_id'=>$address_id), 'single');		

					$this->show_view(MODULE_NAME.'address/address_edit', $this->data);

				}

			}

			else

			{

				redirect(base_url().MODULE_NAME.'dashboard/error/1');

			}

		}

		else

		{

			if($this->checkAddPermission())

			{

				if (isset($_POST['Submit']) && $_POST['Submit'] == "Add")

				{

					$post['user_address'] 		 	= $this->input->post('user_address');
					$post['user_latitude'] = $this->input->post('txtLat');
            		$post['user_longitude'] = $this->input->post('txtLng');

					$post['profile_address'] 		 = '0';

					$post['address_created_date']  	= date('Y-m-d');

					$chef_res = $this->common_model->getData('tbl_user', array('user_id'=>'2'), 'single');

					$global_res = $this->common_model->getData('tbl_global_setting', NULL, 'single');

					/*$address_data = $this->get_latlong_by_address($post['user_address']);*/

					

						$user_latitude = $post['user_latitude'];

               			$user_longitude = $post['user_longitude'];

		           		if(!empty($chef_res))

		           		{

		           			$lat1 = $chef_res->user_latitude;

							$lon1 = $chef_res->user_longitude;

							$lat2 = $user_latitude;

							$lon2 = $user_longitude;

							$distanc_res = $this->distanceCalculete($lat1, $lon1, $lat2, $lon2);

							if(!empty($distanc_res))

							{

								$post['total_distance']  = round($distanc_res);

								$check_distance = $this->common_model->checkDistanceRange($post['total_distance']);

								if(!empty($check_distance))

								{

									$post['distance_charge'] =  $check_distance->distance_amount;

								}

							}

		           		}

					
		           	if($post['total_distance'] <= '25')
					{
						$post['default_address'] 			='1';
						$post['address_approval_status'] 	= 'Approved';
					}
					else
					{
						$post['default_address'] 			='0';
						$post['address_approval_status'] 	= 'Pending';
					}
	           		$post['user_latitude'] = $user_latitude;

	           		$post['user_longitude'] = $user_longitude;

	           		$post['special_delivery_charge'] = $global_res->special_delivery_charge ;

					$post['user_id'] 				= $patient_id;

					$address_id = $this->common_model->addData('tbl_address',$post);

					/*CHEF NOTIFICATION*/

					$patient_res = $this->common_model->getData('tbl_user',array('user_id'=>$patient_id), 'single');

					$subject_chef = "New Address Registration";

			   		$chef_credential_msg  = '';

					$chef_credential_msg .= '<html><body bgcolor="#f6f8f1" style="min-width: 100% !important;color:#111 ; margin: 0; padding: 0;">';

					$chef_credential_msg .= 'Dear Chef, "'.$patient_res->user_fname.' '.$patient_res->user_lname.'" "'.$patient_res->user_mobile_no.'" have added a new address into the system please review that address and give the specific charge of that address and give acceptance to that address';

					$chef_credential_msg .= '<p><b>Thanks & Regards</b></p>';

					$chef_credential_msg .= '<p><b>Team CIRCADIAN FOOD </b></p>';

					$chef_credential_msg .= '</body></html>';



					$message = 'Dear Chef, "'.$patient_res->user_fname.' '.$patient_res->user_lname.'" "'.$patient_res->user_mobile_no.'" have added a new address into the system please review that address and give the specific charge of that address and give acceptance to that address';

					$this->clickSendMessage($chef_res->user_mobile_no, $message);

					$this->send_mail($chef_res->user_email, $subject_chef, $chef_credential_msg);

                    if($address_id){

                        $msg = 'Address added successfully!';	

						$this->session->set_flashdata('message', '<section class="content"><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');

						redirect(MODULE_NAME.'address');

				  	}else{

					  	$msg = 'Process failed !!';					

						$this->session->set_flashdata('message', '<section class="content"><div class="col-xs-12"><div class="alert alert-danger alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');

						redirect(base_url().MODULE_NAME.'address');

				  	}		

				}

				else

				{

					$this->show_view(MODULE_NAME.'address/address_add', $this->data);

				}

			}

			else

			{

				redirect( base_url().MODULE_NAME.'dashboard/error/1');

			}

		}

	}



	public function addressView($address_id = ''){

		if($address_id){

			$this->data['address_edit'] = $this->common_model->getData('tbl_address',array('address_id'=>$address_id), 'single');

			$this->show_view(MODULE_NAME.'address/address_full_view',$this->data);

		}

	}



	public function deleteAddress($address_id = ''){

		$address_id = $this->uri->segment(4);

    	if(!empty($address_id)){

    		if($this->checkDeletePermission()){

    			$address_res = $this->common_model->deleteData('tbl_address' , array('address_id'=>$address_id));

    			if(!empty($address_res)){

					$msg = 'Address Removed successfully!!';					

					$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-danger alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');

					redirect(base_url().MODULE_NAME.'address');

				}

    		}

    	}

	}



	public function activeStatus()

    {

        $address_id = $this->input->post('address_id');
        $patient_id = $this->data['session']->user_id;
        

        $post['default_address'] = '1';

        $this->common_model->updateData('tbl_address', array('address_id'=>$address_id), $post);



        $post1['default_address'] = '0';

        $this->common_model->updateData('tbl_address', array('address_id !='=>$address_id, 'user_id'=>$patient_id), $post1);

        $msg = 'Set Default Address Successfully...!'; 

        /*echo '<section class="content"><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>'; */          

    }

    

    public function inActiveStatus()

    {

        $address_id = $this->input->post('address_id');
        $patient_id = $this->data['session']->user_id;
        

        $post['default_address'] = '0';

        $this->common_model->updateData('tbl_address', array('address_id'=>$address_id), $post);


        $msg = 'Set Default Address Successfully...!'; 

        

        /*$post['address_status'] = '0';

        $this->common_model->updateData('tbl_address', array('address_id'=>$address_id), $post);*/

        /*$msg = 'successfully Update...!'; 

        echo '<section class="content"><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>';  */               

    }



}

