<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OrderSetting extends MY_Controller{

	function __construct(){

		parent::__construct();

	}	

    

    /* Add & update */

    public function index(){    	

		if($this->checkAddPermission()){

			if (isset($_POST['Submit'])){			

				$post['order_status'] 			= $this->input->post('order_status');
				
				$patient_res = $this->common_model->getData('tbl_user',array('role_id'=>'4'), 'multi');


			$open_close_data=	 $this->common_model->getData('tbl_global_setting' , NULL , 'single');

		
 


				if(!empty($patient_res))
				{
					foreach ($patient_res as $pp_res) 
					{
						/*MAIL*/
						$loginUrl  = base_url();
						$credential_msg  = '';
						$credential_msg .= '<html><body bgcolor="#f6f8f1" style="min-width: 100% !important;color:#111 ; margin: 0; padding: 0;">';
						$credential_msg .= '<p><b>Dear  ' .$pp_res->user_fname.' '.$pp_res->user_lname.'</b></p>';
						if($post['order_status'] == 'Open')
						{
							//$credential_msg .= '<p>The website '.$loginUrl.' is now open and accepting orders, please complete your orders by 12:00pm the day prior to delivery to avoid a late order charge. </p>';
							$credential_msg .='<p>'.$open_close_data->order_open_mail.'</p>';
							$subject = "We're open to accepting the orders now!";
							
						}
						else
						{							
							//$credential_msg .= '<p>The website '.$loginUrl.' is now close on accepting orders and you will get email once order accepting will be enable. </p>';
							$credential_msg .='<p>'.$open_close_data->order_close_mail.'</p>';
							$subject = "We're closed and not accepting the orders!";
						}
						$credential_msg .= '<p><b>Team CIRCADIAN FOOD </b></p>';
						$credential_msg .= '</body></html>';
				      
						 
			       		$this->send_mail($pp_res->user_email, $subject, $credential_msg);
						 


			       		/*MESSAGE*/
						   $message="";
			       		$message .= 'Dear  ' .$pp_res->user_fname.' '.$pp_res->user_lname.'<br> ';
						if($post['order_status'] == 'Open')
						{
							//$message .= 'The website '.$loginUrl.' is now open and accepting orders, please complete your orders by 12:00pm the day prior to delivery to avoid a late order charge.';
							$message .= $open_close_data->order_open_sms;
						}
						else
						{
							//$message .= 'The website '.$loginUrl.' is now close on accepting orders and you will get email once order accepting will be enable.';
							$message .= $open_close_data->order_close_sms;
						}
			       		$this->clickSendMessage($pp_res->user_mobile_no, $message);

						 
					}
				}
			

				$post['closeing_date'] 			= $this->input->post('closeing_date');

				$post['deadline_date'] 			= $this->input->post('deadline_date');

				$post['late_charge'] 			= $this->input->post('late_charge');

				$post['gs_updated_date'] 		= date('Y-m-d');

				if($_POST['Submit'] == 'Add' && $_POST['gs_id'] == ''){

					$post['gs_created_date'] = date('Y-m-d');

					$this->common_model->addData('tbl_global_setting' , $post);

				}

				else if($_POST['Submit'] == 'Edit' && $_POST['gs_id'] != ''){
					 

					$this->common_model->updateData('tbl_global_setting' , array('gs_id' => $_POST['gs_id']) , $post);

	           	}

	           	$msg = 'update successfully!!';					

				$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');

				redirect(base_url().MODULE_NAME.'orderSetting');

			}

			else{

				$this->data['gs_setting'] = $this->common_model->getData('tbl_global_setting' , NULL , 'single');

				$this->show_view(MODULE_NAME.'order_setting/order_setting_add', $this->data);

			}

		}

		else{	

			redirect( base_url().MODULE_NAME.'dashboard/error/1');

		}	

    }

}

?>