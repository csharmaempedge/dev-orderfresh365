<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

ob_start();

class Message extends MY_Controller {



	function __construct(){



		parent::__construct();



		if(!empty(MODULE_NAME))



		{



			$this->load->model(MODULE_NAME.'message_model');



		}



	}



	/* Details */

	public function sendSMS()
	{
		$email = 'rahulpatidar356@gmail.com';
		$subject = 'Mail Test';
		$msg = 'Hello';
		$mail_send = $this->send_mail($email, $subject, $msg);

		echo "<pre>";
		print_r($mail_send);
	}

	public function index(){



		if($this->checkViewPermission()){



			$this->show_view(MODULE_NAME.'message/message_view',$this->data);



		}else{	



			redirect(base_url().MODULE_NAME.'dashboard/error/1');



		}



    }



    public function loadMessageListData()



    {



    	$message_list = $this->message_model->getAllMessageList();



    	$data = array();



        $no = $_POST['start'];



        foreach ($message_list as $c_res) 



	    {



			$no++;



			$row   = array();



			$row[] = $no;



			$row[] = $c_res->message_send_date;



	 		$btn = '';



	 		if($this->checkViewPermission())



	 		{



	 			$btn .= '<a class="btn btn-primary btn-sm" href="'.base_url().''.MODULE_NAME.'message/messageView/'.$c_res->message_id.'" title="View"><i class="fa fa-eye fa-1x "></i></a>&nbsp;&nbsp;';



	 		}



	 		$row[] = $btn;



            $data[] = $row;



        }



        $output = array(



			"draw" => $_POST['draw'],



			"recordsTotal" => count($message_list),



			"recordsFiltered" => $this->message_model->count_filtered(),



			"data" => $data,



		);



       	//output to json format



       	echo json_encode($output);



    }



    /*public function clickSendMessage($user_mobile_no, $message)



    {



    	require 'vendor/autoload.php';







		// Configure HTTP basic authorization: BasicAuth



		$config = ClickSend\Configuration::getDefaultConfiguration()



		              ->setUsername('jmatrulli@circadianfood365.com')



		              ->setPassword('D13E2423-39E7-A330-612C-197F98E465D3');







		$apiInstance = new ClickSend\Api\SMSApi(new GuzzleHttp\Client(),$config);



		$msg = new \ClickSend\Model\SmsMessage();



		$msg->setBody($message); 



		$msg->setTo($user_mobile_no);



		$msg->setSource("sdk");







		// \ClickSend\Model\SmsMessageCollection | SmsMessageCollection model



		$sms_messages = new \ClickSend\Model\SmsMessageCollection(); 



		$sms_messages->setMessages([$msg]);







		try {



		    $result = $apiInstance->smsSendPost($sms_messages);



		    print_r($result);



		} catch (Exception $e) {



		    echo 'Exception when calling SMSApi->smsSendPost: ', $e->getMessage(), PHP_EOL;



		}



    }*/



	public function addMessage($message_id = ''){
		/*$email = 'rahulpatidar356@gmail.com';
		$subject = 'Mail Test';
		$msg = 'Hello';
		$mail_send = $this->send_mail($email, $subject, $msg);

		echo "<pre>";
		print_r($mail_send);

		die;*/


     	if($this->checkAddPermission())



		{



			if (isset($_POST['Submit']) && $_POST['Submit'] == "Add")



			{

				



				$post['message'] 					= $this->input->post('message');



				$post['message_type'] 				= implode(',', $this->input->post('message_type'));

				$post['patient_type'] 				= $this->input->post('patient_type');

				if($post['patient_type'] == 'Patient')

				{

					$patient_id_arr                 = $this->input->post('patient_id');

					if($patient_id_arr[0] == 'All')

					{

						$patient_res   = $this->common_model->getData('tbl_user', array('role_id'=>'4'),'multi');

						$patient_id_arr_new = array();

						foreach ($patient_res as  $res) 

						{

							$patient_id_arr_new[] = $res->user_id;

						}

						$patient_id_arr = (!empty($patient_id_arr_new)) ? implode(',', $patient_id_arr_new) : '';



					}

					else

					{

						$patient_id_arr 			= implode(',', $this->input->post('patient_id'));

					}

					



				}

				elseif($post['patient_type'] == 'Order_Patient')



				{



					$patient_id_arr                 = $this->input->post('order_patient_id');

					if($patient_id_arr[0] == 'All')

					{

						$patient_res   = $this->common_model->getData('tbl_user', array('role_id'=>'4'),'multi');

						$patient_id_arr_new = array();

						foreach ($patient_res as  $res) 

						{

							$patient_id_arr_new[] = $res->user_id;

						}

						$patient_id_arr = (!empty($patient_id_arr_new)) ? implode(',', $patient_id_arr_new) : '';



					}

					else

					{

						$patient_id_arr 			= implode(',', $this->input->post('order_patient_id'));

					}



				}

				else

				{

					$patient_id_arr                 = $this->input->post('pending_order_patient_id');

					if($patient_id_arr[0] == 'All')

					{

						$patient_res   = $this->common_model->getData('tbl_user', array('role_id'=>'4'),'multi');

						$patient_id_arr_new = array();

						foreach ($patient_res as  $res) 

						{

							$patient_id_arr_new[] = $res->user_id;

						}

						$patient_id_arr = (!empty($patient_id_arr_new)) ? implode(',', $patient_id_arr_new) : '';



					}

					else

					{

						$patient_id_arr 			= implode(',', $this->input->post('pending_order_patient_id'));

					}

				}

				

				foreach ($this->input->post('message_type') as  $message_type_arr) 

				{

					if($message_type_arr == 'Mail')

					{



						

						if(!empty($patient_id_arr))



						{

							

							$patient_id_arr_new = explode(',', $patient_id_arr);

							foreach ($patient_id_arr_new as $patient_id) 



							{

								$patient_res = $this->common_model->getData('tbl_user', array('user_status'=>1, 'user_id'=>$patient_id, 'email_reminder'=>'ON'), 'single');



								if(!empty($patient_res))



								{



									$credential_msg  = '';



									$credential_msg .= '<html><body bgcolor="#f6f8f1" style="min-width: 100% !important;color:#111 ; margin: 0; padding: 0;">';



									$credential_msg .= '<p><b>Dear  ' .$patient_res->user_fname.' '.$patient_res->user_lname.'</b></p>';



									$credential_msg .= $post['message'];



									$credential_msg .= '<p><b>Thanks & Regards</b></p>';



									$credential_msg .= '</body></html>';



							       	$subject = "CIRCADIAN FOOD";







							   		$mail_send = $this->send_mail($patient_res->user_email, $subject, $credential_msg);



								}



							}



						}

					}

					else

					{

						/*$patient_id_arr                 = $this->input->post('patient_id');*/



						if(!empty($patient_id_arr))



						{

							

							$patient_id_arr_new = explode(',', $patient_id_arr);

							foreach ($patient_id_arr_new as $patient_id) 



							{



								$patient_res = $this->common_model->getData('tbl_user', array('user_status'=>1, 'user_id'=>$patient_id, 'text_reminder'=>'ON'), 'single');



								if(!empty($patient_res))



								{



							   		$this->clickSendMessage($patient_res->user_mobile_no, $post['message']);



								}



							}



						}

					}

				}



				/*if($post['patient_type'] == 'Patient')



				{



					$post['patient_id'] 			= implode(',', $this->input->post('patient_id'));



				}



				elseif($post['patient_type'] == 'Order_Patient')



				{



					$post['patient_id'] 			= implode(',', $this->input->post('order_patient_id'));



				}

				else



				{



					$post['patient_id'] 			= implode(',', $this->input->post('pending_Order_Patient'));



				}*/



				

				$post['patient_id'] 			= $patient_id_arr;

				$post['message_send_date']  		= date('Y-m-d');



				$post['message_send_datetime'] 		= date('Y-m-d H:i:s');



				$message_id = $this->common_model->addData('tbl_message',$post);



                if($message_id){



                    $msg = 'Message Send successfully!';	



					$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');



					redirect(MODULE_NAME.'message');



			  	}else{



				  	$msg = 'Process failed !!';					



					$this->session->set_flashdata('message', '<section class="content"><div class="col-xs-12"><div class="alert alert-danger alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');



					redirect(base_url().MODULE_NAME.'message');



			  	}		



			}



			else



			{



				$this->show_view(MODULE_NAME.'message/message_add', $this->data);



			}



		}



		else



		{



			redirect( base_url().MODULE_NAME.'dashboard/error/1');



		}



	}







	public function messageView($message_id = ''){



		if($message_id){



			$this->data['message_edit'] = $this->common_model->getData('tbl_message',array('message_id'=>$message_id), 'single');



			$this->show_view(MODULE_NAME.'message/message_full_view',$this->data);



		}



	}



}



