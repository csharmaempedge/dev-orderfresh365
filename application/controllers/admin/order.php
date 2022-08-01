<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 

use Dompdf\Dompdf;

use Dompdf\Options;
use Square\SquareClient;
use Square\Environment;
use Square\Exceptions\ApiException; 
use Square\Models\CreatePaymentRequest;
use Square\Models\CreateCustomerRequest;
use Square\Models\SearchCustomersRequest;
use Square\Models\CustomerQuery;
use Square\Models\CustomerFilter;
use Square\Models\CustomerTextFilter;
use Square\Models\Money;
use Square\Models\Customer;

class Order extends MY_Controller 

{

	function __construct()

	{

		parent::__construct();

		if(!empty(MODULE_NAME)){

		   $this->load->model(MODULE_NAME.'dashboard_model');

		   $this->load->model(MODULE_NAME.'order_model');

		}

	}



	public function index(){			

		$this->show_view(MODULE_NAME.'order/order_list', $this->data);

    }



    public function loadOrderListData()

    {
    	$patient_id = $this->data['session']->user_id;	

    	$client_list = $this->order_model->getAllOrderList();

    	$data = array();

        $no = isset($_POST['start']) ? $_POST['start'] : "1";

        foreach ($client_list as $res) 

	    {

	    	$patient_res = $this->common_model->getData('tbl_user', array('user_id'=>$res->patient_id), 'single');

	    	if($patient_id == '2')

	    	{

		    	$totalQty = $this->order_model->gettotalOrderQty('', $res->order_id);

	            $totalBreakfastQty = $this->order_model->gettotalBreakfastOrderQty('', $res->order_id);

	    	}

	    	else

	    	{

	    		$totalQty = $this->order_model->gettotalOrderQty($patient_id, $res->order_id);

	            $totalBreakfastQty = $this->order_model->gettotalBreakfastOrderQty($patient_id, $res->order_id);

	    	}

            $toTalQTY = $totalQty->qty + $totalBreakfastQty->qty;

			$no++;

			$row   = array();

			$row[] = $no;

			$row[] = (!empty($patient_res)) ? $patient_res->user_fname.' '.$patient_res->user_lname : '';

			$row[] = $res->order_no;

			$row[] = $toTalQTY;

			$row[] = date("m-d-Y", strtotime($res->order_create_date));

			$row[] = $res->payment_status;

	 		$btn = '';

	 		if($this->checkViewPermission())

	 		{

	 			if($patient_id == '2')

	 			{

	 				$btn .= '<a class="btn btn-warning btn-sm" href="'.base_url().''.MODULE_NAME.'order/setBageLable/'.$res->order_id.'/'.$res->patient_id.'" title="Print Bags Label"><i class="fa fa-print fa-1x "></i></a>&nbsp;&nbsp;';

	 			}

	 			$btn .= '<a class="btn btn-success btn-sm" href="'.base_url().''.MODULE_NAME.'order/orderDetails/'.$res->order_id.'/'.$res->patient_id.'" title="Order Details"><i class="fa fa-eye fa-1x "></i></a>&nbsp;&nbsp;';

	 		}

	 		$row[] = $btn;

	 		if($patient_id == '2')

	 		{

		 		/*$delivery_status = '';

		 		if($res->delivery_status == 'Complete')

	            {

	            	$delivery_status .= '<span class="label label-success">Complete</span>';

	            }

	            else

	            {

	            	$delivery_status .= '<span class="label label-danger">Pending</span>&nbsp;&nbsp;';

	            	$delivery_status .= '<span class="btn btn-danger btn-sm" title="Status" onclick="orderStatusChange('.$res->order_id.');"><i class="fa fa-plus fa-1x "></i></span>&nbsp;&nbsp;';

	            }

		 	    $row[] = $delivery_status;*/

		 	    $delivery_status = '';
	            if($res->delivery_status=='Complete')
	            {  
	                 $delivery_status .= '<span class="label label-success">Complete</span>';
	            }
	            else
	            {
	                $delivery_status  .='<label class="switch" title="Pending">
	                    <input type="checkbox" class="switch_off" onchange="orderStatusChange('.$res->order_id.');">
	                    <span class="slider round"></span>
	                  </label>';
	              
	            }
	            $row[] = $delivery_status;

		 	}



	 		$btn1 = '';

	 		if($this->checkViewPermission())

	 		{

	 			if($patient_id == '2')

	 			{

	 				$btn1 .= '<a class="btn btn-primary btn-sm" href="'.base_url().''.MODULE_NAME.'order/printLabel/'.$res->order_id.'/'.$res->patient_id.'" title="Label Print"><i class="fa fa-print fa-1x "></i></a>&nbsp;&nbsp;';

	 				$breakfast_order_res = $this->common_model->getData('tbl_breakfast_order',array('order_id'=>$res->order_id, 'patient_id'=>$res->patient_id), 'single'); 

	 				if(!empty($breakfast_order_res))

	 				{

	 					$btn1 .= '<a class="btn btn-success btn-sm" href="'.base_url().''.MODULE_NAME.'order/breakFastPrintLabel/'.$res->order_id.'/'.$res->patient_id.'" title="BreakFast Label Print"><i class="fa fa-print fa-1x "></i></a>&nbsp;&nbsp;';



	 				}

	 			}

	 		}

	 		$row[] = $btn1;

            $data[] = $row;

        }

        $output = array(

			"draw" => isset($_POST['draw']) ? $_POST['draw'] : "1",

			"recordsTotal" => count($client_list),

			"recordsFiltered" => $this->order_model->count_filtered(),

			"data" => $data,

		);

       	//output to json format

       	echo json_encode($output);

    }



    public function orderStatusChange()

    {

    	 $order_id 				= $this->input->post('order_id');

		$post_u['delivery_status'] = 'Complete';

		$this->common_model->updateData('tbl_order', array('order_id'=>$order_id), $post_u);                  

		$this->common_model->updateData('tbl_order_product', array('order_id'=>$order_id), $post_u);   

    }

    public function setBageLable(){

    	$order_id = $this->uri->segment(4);

    	$patient_id = $this->uri->segment(5);

    	if(isset($_POST['Submit']) && $_POST['Submit'] =='Add')

		{

			$post['order_id'] 		= $this->input->post('order_id');

			$this->common_model->deleteData('tbl_print_bags',array('order_id'=>$post['order_id']));

			$post['patient_id'] 	= $this->input->post('patient_id');

			$post['total_qty'] 		= $this->input->post('total_qty');

			$post['qty'] 			= $this->input->post('qty');

	        $rows = $post['total_qty']/$post['qty'];

	        $no_of_rows = round($rows, 0, PHP_ROUND_HALF_EVEN);

	        for ($i=0; $i<$no_of_rows; $i++)

	        {

		        $post['created_date']	=date('Y-m-d');

		        $n_post = $this->xssCleanValidate($post);

	        	$this->common_model->addData('tbl_print_bags', $n_post);

	        }

	        

			$msg = 'Bag Label Added successfully!!';					

			$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');

	       	redirect(base_url().MODULE_NAME.'order/setBageLable/'.$order_id.'/'.$patient_id);

		}

		else

		{

			$totalQty = $this->order_model->gettotalOrderQty('', $order_id);

		    $totalBreakfastQty = $this->order_model->gettotalBreakfastOrderQty('', $order_id);

		    $toTalQTY = $totalQty->qty + $totalBreakfastQty->qty;

			$this->data['toTalQTY'] 	= $toTalQTY;		

			$this->data['order_id'] 	= $order_id;		

			$this->data['patient_id'] 	= $patient_id;		

			$this->show_view(MODULE_NAME.'order/order_bage_view', $this->data);

		}			

    }



    public function printBagsLabel(){

		$order_id = $this->uri->segment(4);	

		$patient_id = $this->uri->segment(5);	

		$this->data['bags_res'] = $this->common_model->getData('tbl_print_bags',array('order_id'=>$order_id), 'multi');	

		$this->data['bags_count'] = $this->common_model->getData('tbl_print_bags',array('order_id'=>$order_id), 'count');	

		$this->data['order_id'] = $order_id;	

		$this->data['patient_id'] = $patient_id;	

		$this->load->view(MODULE_NAME.'order/bags_label_print', $this->data);

    }





    public function orderDetails(){

    	$order_id = $this->uri->segment(4);

    	$patient_id = $this->uri->segment(5);			

		$this->data['order_result'] = $this->common_model->getData('tbl_order', array('order_id'=>$order_id, 'patient_id'=>$patient_id), 'single');	

		$this->data['order_res'] = $this->common_model->getData('tbl_order_product', array('order_id'=>$order_id, 'patient_id'=>$patient_id), 'multi');

		$this->data['order_id'] 	= $order_id;		

		$this->data['patient_id'] 	= $patient_id;		

		$this->show_view(MODULE_NAME.'order/order_details', $this->data);

    }



    



    public function square(){

           // print_r($_POST);
		 
	   
		if(isset($_POST['Submit']))
		{
			$this->session->set_userdata('square_form_data', $this->input->post());
		}
		else
		{
			$_POST=$this->session->userdata('square_form_data');
		}

    	if (isset($_POST['Submit']) && $_POST['Submit'] == "Payment") 

		{

			$this->data['btn_type'] 		 		= 'Payment';

			$this->data['label_type'] 		 		= '';

			$this->data['address_id'] 		 = (!empty($this->input->post('address_id_new'))) ? $this->input->post('address_id_new') : '0';

			$this->data['user_address'] 		 = (!empty($this->input->post('user_address_new'))) ? $this->input->post('user_address_new') : '0';

			$this->data['checkout_amount'] 		 	= (!empty($this->input->post('checkout_amount'))) ? $this->input->post('checkout_amount') : '0';

			$this->data['special_delivery_charge'] 	= (!empty($this->input->post('special_delivery_charge'))) ? $this->input->post('special_delivery_charge') : '0';

			$this->data['minimum_surcharge'] 	= (!empty($this->input->post('minimum_surcharge_'))) ? $this->input->post('minimum_surcharge_') : '0';

			$this->data['order_amount'] 	 = (!empty($this->input->post('notification_Amount'))) ? $this->input->post('notification_Amount') : '0';

			$this->data['apply_coupon_code'] 	 = (!empty($this->input->post('apply_coupon_code_'))) ? $this->input->post('apply_coupon_code_') : '0';

			$this->data['actual_amount'] 	 = (!empty($this->input->post('actual_amount_'))) ? $this->input->post('actual_amount_') : '0';

		}

		if (isset($_POST['Submit']) && $_POST['Submit'] == "Accept") 

		{

			$this->data['btn_type'] 		 		= 'Accept';

			$this->data['label_type'] 		 	 = 'Pickup';

			$this->data['address_id'] 		 = (!empty($this->input->post('address_id_new'))) ? $this->input->post('address_id_new') : '0';

			$this->data['user_address'] 		 = (!empty($this->input->post('user_address_new'))) ? $this->input->post('user_address_new') : '0';

			$this->data['checkout_amount'] 		 = (!empty($this->input->post('checkout_amount'))) ? $this->input->post('checkout_amount') : '0';

			$this->data['special_delivery_charge'] = '0';

			$this->data['minimum_surcharge'] 	= (!empty($this->input->post('minimum_surcharge_'))) ? $this->input->post('minimum_surcharge_') : '0';

			$this->data['order_amount'] 	 = (!empty($this->input->post('checkout_amount'))) ? $this->input->post('checkout_amount') : '0';

			$this->data['apply_coupon_code'] 	 = (!empty($this->input->post('apply_coupon_code_'))) ? $this->input->post('apply_coupon_code_') : '0';

			$this->data['actual_amount'] 	 = (!empty($this->input->post('actual_amount_'))) ? $this->input->post('actual_amount_') : '0';

		}

		if (isset($_POST['Submit']) && $_POST['Submit'] == "Order") 

		{

			$this->data['btn_type'] 		 		= 'Order';

			$this->data['label_type'] 		 	 = '';

			$this->data['address_id'] 		 = (!empty($this->input->post('address_id'))) ? $this->input->post('address_id') : '0';

			$this->data['user_address'] 		 = (!empty($this->input->post('user_address'))) ? $this->input->post('user_address') : '';

			$this->data['checkout_amount'] 		 = (!empty($this->input->post('checkout_new_amount'))) ? $this->input->post('checkout_new_amount') : '0';

			$this->data['checkout_amount'] 		 = (!empty($this->input->post('checkout_new_amount'))) ? $this->input->post('checkout_new_amount') : '0';

			$this->data['special_delivery_charge'] = '0';

			$this->data['minimum_surcharge'] 	= (!empty($this->input->post('minimum_surcharge'))) ? $this->input->post('minimum_surcharge') : '0';

			$this->data['order_amount'] 	 = (!empty($this->input->post('checkout_new_amount'))) ? $this->input->post('checkout_new_amount') : '0';

			$this->data['apply_coupon_code'] 	 = (!empty($this->input->post('apply_coupon_code'))) ? $this->input->post('apply_coupon_code') : '0';

			$this->data['actual_amount'] 	 = (!empty($this->input->post('actual_amount'))) ? $this->input->post('actual_amount') : '0';

		}		
		$this->data['order_amount']=number_format((float)$this->data['order_amount'], 2, '.', '');

		$this->show_view(MODULE_NAME.'cart/square', $this->data);

    }



    public function squarePayment()
	{
		$patient_id = $this->data['session']->user_id;
		
		// Initialize the Square client.
		$api_client = new SquareClient([
			'accessToken' =>SQUAREUP_ACCESS_TOKEN,
			//'environment' =>  SQUAREUP_ENVIRONMENT
			'environment' => Environment::SANDBOX
		]); // In production, the environment arg is 'production'

		/**
		* Date: 01/08/22
		* create new customer in squareup directory **/
		$customers_api = $api_client->getCustomersApi();
		$dbcustomer = (!$this->order_model->getPtientPhoneNumber($patient_id)) ? "" : $this->order_model->getPtientPhoneNumber($patient_id);

		try 
		{
			/**
			* search customer by email or phone number if already exists 
			* I have used email
			* set email value to filter
			**/
			$email_address = new CustomerTextFilter();
			$email_address->setExact($dbcustomer->user_email);
			
			/**
			* set email paramter for query
			**/
			$filter = new CustomerFilter();
			$filter->setEmailAddress($email_address);
				
			/**
			* sent query parameter to custoemr query class
			**/
			$query = new CustomerQuery();
			$query->setFilter($filter);
			
			/**
			* final search
			**/
			$search_customer_request = new SearchCustomersRequest();
			$search_customer_request->setQuery($query);
			
			$api_response = $api_client->getCustomersApi()->searchCustomers($search_customer_request);
			if ($api_response->isSuccess()) // check response if exist
			{
				$result = $api_response->getResult(); // result
				
				//echo "<pre>";
				//print_r($result->getCustomers()[0]->getId());
				//die;
				$customer = $result->getCustomers();
				if(empty($customer))
				{
					/** 
					* set parameter for customer 
					* only one parameter required for this, if you want all then we can
					**/
					$create_customer_request = new CreateCustomerRequest();
					$create_customer_request->setPhoneNumber($dbcustomer->user_mobile_no);
					$create_customer_request->setEmailAddress($dbcustomer->user_email);
					$create_customer_request->setNickname($dbcustomer->user_fname);
					
					/**
					* create customer **/
					$response = $customers_api->createCustomer($create_customer_request);
				}
			}else{
				$errors = $api_response->getErrors();
			}
		}catch (ApiException $e) {
			$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-danger  alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$e->getMessage().'</div></div></section>');
			redirect(MODULE_NAME.'order/square')->withInput();
		}
		
		//print_r($money);
		die;
		
		/**
		* payment request **/
		$payments_api = $api_client->getPaymentsApi();
		$money = new Money();
		$money->setAmount(floatval(($_POST['amount']*100)));
		$money->setCurrency('USD');

		$create_payment_request = new CreatePaymentRequest($nonce, uniqid(), $money);
		try 
		{
			$response = $payments_api->createPayment($create_payment_request);
			if ($response->isError()) 
			{
				$errors = $response->getErrors();
				$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-danger  alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'. $errors[0]->getDetail().'</div></div></section>');

				redirect(MODULE_NAME.'order/square');
			}

			if ($response->isSuccess()) 
			{
				$result = $response->getResult();

				 
				$patient_id = $this->data['session']->user_id;

				$post['patient_id'] 			= $patient_id;

				$post['order_amount'] 			= $_POST['amount'];

				//$post['minimum_surcharge'] 			= $_POST['amount'];

				$post['minimum_surcharge'] 			= $_POST['minimum_surcharge'];


				$post['checkout_amount'] 		= $_POST['checkout_amount'];

				$post['special_delivery_charge']= $_POST['special_delivery_charge'];

				$post['apply_coupon_code'] 		= $_POST['apply_coupon_code'];

				$post['actual_amount'] 			= $_POST['actual_amount'];

				$post['user_address'] 			= $_POST['user_address'];

				$post['address_id'] 			= $_POST['address_id'];

				$post['label_type'] 			= $_POST['label_type'];

				$post['transaction_id'] 		= $result->getPayment()->getId();

				$post['payment_status'] 		= 'Payment success';

				$post['temp_created_date'] 		= date('Y-m-d');

				 

				$temp_id = $this->common_model->addData('tbl_temp_data', $post);	 

				$this->createOrder($temp_id);


			}

		} catch (ApiException $e) {
		 

			$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-danger  alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$e->getMessage().'</div></div></section>');

			redirect(MODULE_NAME.'order/square')->withInput();
		 
		}
    }

	/* Dashboard Show */

	public function createOrder($temp_id =	 '')

	{	

		$patient_id = $this->data['session']->user_id;

		$temp_data_res = $this->common_model->getData('tbl_temp_data', array('temp_id'=>$temp_id, 'patient_id'=>$patient_id), 'single');





		$total_qty_res = $this->dashboard_model->gettotalQty($patient_id);

		$order_check = $this->common_model->getData('tbl_order', NULL, 'single', NULL, 'order_id DESC');

		if(!empty($order_check))

		{

			$post['order_no'] = $order_check->order_no + 1;

		}

		else

		{

			$post['order_no'] = 100;

		}

		$check_macros = $this->common_model->getData('tbl_patient_macro', array('patient_id'=>$patient_id), 'single');

		if(!empty($check_macros))

		{

			$post['cron_date'] = $check_macros->cron_date;

		}

		$post['patient_id'] 			= $patient_id;

		$post['total_qty'] 				= $total_qty_res->qty;

		$post['delivery_status'] 		= 'Pending';

		$post['order_create_date'] 		= date('Y-m-d');

		$post['order_create_datetime'] 	= date('Y-m-d H:i:s');

		

		$post['label_type'] 		 	= (!empty($temp_data_res)) ? $temp_data_res->label_type : '';

		$post['checkout_amount'] 		 = (!empty($temp_data_res)) ? $temp_data_res->checkout_amount : '';

		$post['special_delivery_charge'] = (!empty($temp_data_res)) ? $temp_data_res->special_delivery_charge : '';

		$post['order_amount'] 		 	= (!empty($temp_data_res)) ? $temp_data_res->order_amount : '';

		$post['minimum_surcharge'] 		 	= (!empty($temp_data_res)) ? $temp_data_res->minimum_surcharge : '';

		$post['apply_coupon_code'] 		= (!empty($temp_data_res)) ? $temp_data_res->apply_coupon_code : '';

		$post['actual_amount'] 		= (!empty($temp_data_res)) ? $temp_data_res->actual_amount : '';

		$post['user_address'] 		= (!empty($temp_data_res)) ? $temp_data_res->user_address : '';

		$post['address_id'] 		= (!empty($temp_data_res)) ? $temp_data_res->address_id : '';

		$post['payment_status'] 		= (!empty($temp_data_res)) ? $temp_data_res->payment_status : '';

		$post['transaction_id'] 		= (!empty($temp_data_res)) ? $temp_data_res->transaction_id : '';

		$check_coupon_code = $this->common_model->getData('tbl_coupon_code', array('coupon_code'=>$post['apply_coupon_code']), 'single');

        if(!empty($check_coupon_code))

        {

            if($check_coupon_code->coupon_code_type == 'Fix')

            {

                $post['coupon_code_amount'] 	 =  $check_coupon_code->coupon_code_amount;;                

            }

            else  if($check_coupon_code->coupon_code_type == 'Percentage')

            {

                $amount = ($post['actual_amount']*$check_coupon_code->coupon_code_amount)/ 100;

                $post['coupon_code_amount'] 	 =  $amount;

                 

            }
            else

            {

                $post['coupon_code_amount'] 	 =  '0';

                 

            }

        }

		$order_id = $this->common_model->addData('tbl_order', $post);

		if(!empty($order_id))

		{
			/*LATE ORDER NOTIFICATIONS*/
			/*Chef Send to sms with multipale no*/
			$gs_res = $this->common_model->getData('tbl_global_setting', NULL, 'single');
			$current_date_time = date('Y-m-d H:i');
			$closeing_date  = $gs_res->closeing_date;
			$deadline_date  = $gs_res->deadline_date;
			if($current_date_time <= $closeing_date)
			{
				/*NO Notification Send*/
			}
			else
			{
				$patient_res = $this->common_model->getData('tbl_user', array('user_id'=>$patient_id), 'single');
				$chef_res = $this->common_model->getData('tbl_user', array('user_id'=>'2'), 'single');
				$no_of_phone_no = $this->common_model->getData('tbl_phone_no', array('user_id'=>$chef_res->user_id), 'multi');
				$loginUrl = base_url();
				$message = 'Dear Team, on our website '.$loginUrl.', you got an late order from ' .$patient_res->user_fname.' '.$patient_res->user_lname.' Mobile Number '.$patient_res->user_mobile_no.' please visit website to check further details. Website link -'.$loginUrl.' ';
				$subject = "Late Order";

				$mail_send = $this->send_mail($chef_res->user_email, $subject, $message);
				if(!empty($no_of_phone_no))
				{
					foreach ($no_of_phone_no as $ph_res) 
					{
						$this->clickSendMessage($ph_res->user_mobile_no, $message);
					}
				}

			}
			/*END NOTIFICATION*/

			$order_res = $this->common_model->getData('tbl_order', array('order_id'=>$order_id), 'single');

			$cart_res = $this->common_model->getData('tbl_cart', array('patient_id'=>$patient_id), 'multi');

			$patient_address_res = $this->common_model->getData('tbl_address', array('address_id'=>$post['address_id']), 'single');

			$total_distance = (!empty($patient_address_res->total_distance)) ? $patient_address_res->total_distance : '0';

			$distance_charge = (!empty($patient_address_res->distance_charge)) ? $patient_address_res->distance_charge : '0';

			if(!empty($cart_res))

			{

				foreach ($cart_res as $c_res) 

				{

					$post_cart['order_id'] 			= $order_id;

					$post_cart['order_no'] 			= $order_res->order_no;

					$post_cart['note'] 				= $c_res->note;

					$post_cart['qty'] 				= $c_res->qty;

					$post_cart['unique_no'] 		= $c_res->unique_no;

					$post_cart['macro_id'] 			= $c_res->macro_id;

					$post_cart['macro_value_id'] 	= $c_res->macro_value_id;

					$post_cart['product_id'] 		= $c_res->product_id;

					$post_cart['product_price'] 	= $c_res->product_price;

					$post_cart['total_distance'] 	= $total_distance;

					$post_cart['distance_charge'] 	= $distance_charge;

					$post_cart['late_charge'] 		= $c_res->late_charge;

					$post_cart['extra_delivery_charge'] = $c_res->extra_delivery_charge;

					$post_cart['total_product_price'] 	= $c_res->total_product_price;

					$post_cart['patient_id'] 			= $c_res->patient_id;

					/*$post_cart['expire_date'] 			= (!empty($gs_res->expire_date)) ? $gs_res->expire_date : '';*/

					$post_cart['order_product_created_date'] = date('Y-m-d');

					$post_cart['delivery_status'] 		= 'Pending';

					$this->common_model->addData('tbl_order_product', $post_cart);

				}

				$post_pat['patient_id'] = '0';

				$this->common_model->updateData('tbl_cart', array('patient_id'=>$patient_id), $post_pat);

			}



			/*BREAKFAST*/



			$breakfast_cart_res = $this->common_model->getData('tbl_breakfast_cart', array('patient_id'=>$patient_id), 'multi');

			if(!empty($breakfast_cart_res))

			{

				foreach ($breakfast_cart_res as $b_res) 

				{

					if (isset($_POST['Submit']) && $_POST['Submit'] == "Accept") 

					{

						$post_br_cart['label_type'] 		 	 = 'Pickup';

					}

					$post_br_cart['order_id'] 			= $order_id;

					$post_br_cart['order_no'] 			= $order_res->order_no;

					$post_br_cart['qty'] 			= $b_res->qty;

					$post_br_cart['breakfast_id_1'] 			= $b_res->breakfast_id_1;

					$post_br_cart['breakfast_qty_1'] 			= $b_res->breakfast_qty_1;

					$post_br_cart['breakfast_product_id_1'] 			= $b_res->breakfast_product_id_1;

					$post_br_cart['breakfast_id_2'] 			= $b_res->breakfast_id_2;

					$post_br_cart['breakfast_qty_2'] 			= $b_res->breakfast_qty_2;

					$post_br_cart['breakfast_product_id_2'] 			= $b_res->breakfast_product_id_2;

					$post_br_cart['patient_id'] 				= $b_res->patient_id;

					$post_br_cart['breakfast_price'] 			= $b_res->breakfast_price;

					/*$post_br_cart['expire_date'] 				= (!empty($gs_res->expire_date)) ? $gs_res->expire_date : '';*/

					$post_br_cart['breakfast_order_create_date'] = date('Y-m-d');

					$this->common_model->addData('tbl_breakfast_order', $post_br_cart);

				}

				$this->common_model->deleteData('tbl_breakfast_cart', array('patient_id'=>$patient_id));

			}



			/*SEND MAIL*/

			if($post['total_qty'] >= 20)

			{

				$chef_res = $this->common_model->getData('tbl_user', array('user_id'=>'2'), 'single');

				$patient_res = $this->common_model->getData('tbl_user', array('user_id'=>$patient_id), 'single');

				$loginUrl  = base_url();

				$credential_msg  = '';

				$credential_msg .= '<html><body bgcolor="#f6f8f1" style="min-width: 100% !important;color:#111 ; margin: 0; padding: 0;">';

				$credential_msg .= '<p><b>Dear  ' .$chef_res->user_fname.' '.$chef_res->user_lname.'</b></p>';

				$credential_msg .= '<p>We have recevied an order of client ' .$patient_res->user_fname.' '.$patient_res->user_lname.' mobile number '.$patient_res->user_mobile_no.', With the quantity 0f ' .$post['total_qty'].' Quantity. Please login to '.$loginUrl.' to see in details.</p>';

				$credential_msg .= '<p><b>Thanks & Regards</b></p>';

				$credential_msg .= '</body></html>';

		       	$subject = "Order Notification";



	       		$this->send_mail($chef_res->user_email, $subject, $credential_msg); 

			}

			$this->common_model->deleteData('tbl_temp_data', array('temp_id'=>$temp_id));

		}

		$msg = 'Order successfully!';	

		$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');

		redirect(MODULE_NAME.'order');	

    }



    /*public function sendMailTotalQTY()

	{	

		$patient_id = $this->data['session']->user_id;

		$loginUrl  = base_url();

		$sendMail  = 'orders@circadianfood365.com';

		$mail_content  = (!empty($this->input->post('mail_content'))) ? $this->input->post('mail_content') : '0';

		$credential_msg  = '';

		$credential_msg .= '<html><body bgcolor="#f6f8f1" style="min-width: 100% !important;color:#111 ; margin: 0; padding: 0;">';

		$credential_msg .= '<p><b>'.$mail_content.'</b></p>';

		$credential_msg .= '<p><b>Thanks & Regards</b></p>';

		$credential_msg .= '</body></html>';

       	$subject = "Order Notification";



   		$mail_send = $this->send_mail($sendMail, $subject, $credential_msg);

   		if($mail_send)

   		{

   			$msg = 'Mail send successfully!';	

			$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');

			redirect(MODULE_NAME.'cart');

   		} 

   		else

   		{

   			$msg = 'Mail not send!';	

			$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-danger alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');

			redirect(MODULE_NAME.'cart');

   		}		

    }*/



    public function sendMailMoreThan20QTY()

	{	

		$patient_id = $this->data['session']->user_id;

		$post_cart['cart_approval_status'] = 'Pending';

		$this->common_model->updateData('tbl_cart', array('patient_id'=>$patient_id), $post_cart);



		$patient_res = $this->common_model->getData('tbl_user', array('user_id'=>$patient_id), 'single');

		$chef_res = $this->common_model->getData('tbl_user', array('user_id'=>'2'), 'single');

		$sendMail  = $chef_res->user_email;

		$credential_msg  = '';

		$credential_msg .= '<html><body bgcolor="#f6f8f1" style="min-width: 100% !important;color:#111 ; margin: 0; padding: 0;">';

		$credential_msg .= 'Dear Chef, "'.$patient_res->user_fname.' '.$patient_res->user_lname.'" "Mobile number" have put an order of more than 20 quantities, please review that order and give it the approval to complete the order';

		$credential_msg .= '<p><b>Thanks & Regards</b></p>';

		$credential_msg .= '</body></html>';

       	$subject = "Order Pending";

   		/*MESSAGE*/

   		$message = 'Dear Chef, "'.$patient_res->user_fname.' '.$patient_res->user_lname.'" "Mobile number" have put an order of more than 20 quantities, please review that order and give it the approval to complete the order';

   		$this->clickSendMessage($chef_res->user_mobile_no, $message);

   		/*MAIL*/

   		$mail_send = $this->send_mail($sendMail, $subject, $credential_msg);



   		if($mail_send)

   		{

   			$msg = 'Mail send successfully!';	

			$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');

			redirect(MODULE_NAME.'cart');

   		} 

   		else

   		{

   			$msg = 'Mail not send!';	

			$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-danger alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');

			redirect(MODULE_NAME.'cart');

   		}		

    }



    public function printLabel(){

		$order_id = $this->uri->segment(4);

    	$patient_id = $this->uri->segment(5);	

		$this->data['order_res'] = $this->common_model->getData('tbl_order',array('order_id'=>$order_id), 'single');

		$this->data['order_list'] = $this->common_model->getData('tbl_order_product', array('patient_id'=>$patient_id,'order_id'=>$order_id), 'multi');		

		$this->load->view(MODULE_NAME.'order/label_print', $this->data);

    }



    public function breakFastPrintLabel(){

		$order_id = $this->uri->segment(4);

    	$patient_id = $this->uri->segment(5);	

		$this->data['breakfast_order_res'] = $this->common_model->getData('tbl_breakfast_order',array('order_id'=>$order_id, 'patient_id'=>$patient_id), 'multi');	

		$this->load->view(MODULE_NAME.'order/breakfast_label_print', $this->data);

    }

    public function addExpireDate()

    {

        $order_id 				= $this->input->post('order_id');

        $unique_no 				= $this->input->post('unique_no');

        

        $post['expire_date'] 	= $this->input->post('expire_date');

        $this->common_model->updateData('tbl_order_product', array('order_id'=>$order_id, 'unique_no'=>$unique_no), $post);

        /*$msg = 'successfully Update...!'; 

        echo '<section class="content"><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>';*/           

    }



    public function addBreakfastExpireDate()

    {

        $order_id 				= $this->input->post('order_id');

        $breakfast_order_id 	= $this->input->post('breakfast_order_id');

        

        $post['expire_date'] 	= $this->input->post('expire_date');

        $this->common_model->updateData('tbl_breakfast_order', array('order_id'=>$order_id,'breakfast_order_id'=>$breakfast_order_id), $post);

        /*$msg = 'successfully Update...!'; 

        echo '<section class="content"><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>';*/           

    }



     public function bulkPrintView(){	

		$this->show_view(MODULE_NAME.'order/bulk_print_view', $this->data);

    }

    public function bulkPrintLabel(){		

		$start_date 	= $this->input->post('start_date');

		$end_date 		= $this->input->post('end_date');

		$order_patient_id 		= $this->input->post('order_patient_id');

		if($order_patient_id == 'All')

		{

			$order_list = $this->common_model->getData('tbl_order_product', array('order_product_created_date >='=>$start_date, 'order_product_created_date <= '=>$end_date), 'multi');

		}

		else

		{

			$order_list = $this->common_model->getData('tbl_order_product', array('order_product_created_date >='=>$start_date, 'order_product_created_date <= '=>$end_date, 'patient_id'=>$order_patient_id), 'multi');

		}

		if(!empty($order_list))

		{

			$this->data['order_list'] 	= $order_list;
			$this->load->view(MODULE_NAME.'order/bulk_label_print', $this->data);

		}

    }



    public function bulkBreakfastPrintLabel(){		

		$start_date 	= $this->input->post('start_date');

		$end_date 		= $this->input->post('end_date');

		$order_patient_id 		= $this->input->post('order_patient_id');

		if($order_patient_id == 'All')

		{

			$breakfast_order_res = $this->common_model->getData('tbl_breakfast_order', array('breakfast_order_create_date >='=>$start_date, 'breakfast_order_create_date <= '=>$end_date), 'multi');

		}

		else

		{

			$breakfast_order_res = $this->common_model->getData('tbl_breakfast_order', array('breakfast_order_create_date >='=>$start_date, 'breakfast_order_create_date <= '=>$end_date, 'patient_id'=>$order_patient_id), 'multi');



		}

		if(!empty($breakfast_order_res))

		{

			$this->data['breakfast_order_res'] 	= $breakfast_order_res;

			$this->load->view(MODULE_NAME.'order/bulk_breakfast_label_print', $this->data);

		}

    }



    public function addNewAddress()

	{	

		$patient_id 	= $this->data['session']->user_id;

		$user_address  	= (!empty($this->input->post('new_user_address'))) ? $this->input->post('new_user_address') : '0';

		$post['user_id'] 			 	 = $patient_id;

		$post['user_address'] 			 = $user_address;

		if(!empty($post['user_address']))

		{

			$address_data = $this->get_latlong_by_address($post['user_address']);

           if(!empty($address_data))

           {

               $user_latitude = $address_data['latitude'];

               $user_longitude = $address_data['longitude'];

               $chef_res = $this->common_model->getData('tbl_user', array('user_id'=>'2'), 'single');

               $global_res = $this->common_model->getData('tbl_global_setting', NULL, 'single');

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

           		$post['user_latitude'] = $post['user_latitude'];

           		$post['user_longitude'] = $post['user_longitude'];

           		$post['address_approval_status'] = 'Pending';

           		$post['special_delivery_charge'] = $global_res->special_delivery_charge ;

           } 

		}

		$post['profile_address'] 		 = '0';

		$post['address_created_date'] 	 = date('Y-m-d');

		$this->common_model->addData('tbl_address', $post);



		/*CHEF NOTIFICATION*/

		$patient_res = $this->common_model->getData('tbl_user',array('user_id'=>$patient_id), 'single');

		$subject_chef = "New Address Registration";

   		$chef_credential_msg  = '';

		$chef_credential_msg .= '<html><body bgcolor="#f6f8f1" style="min-width: 100% !important;color:#111 ; margin: 0; padding: 0;">';

		$chef_credential_msg .= '<p><b>Patient  Name  ' .$patient_res->user_fname.' '.$patient_res->user_lname.'</b></p>';

		$chef_credential_msg .= '<p><b>Thanks & Regards</b></p>';

		$chef_credential_msg .= '<p><b>Team CIRCADIAN FOOD </b></p>';

		$chef_credential_msg .= '</body></html>';



		$message = '';

		$this->clickSendMessage($chef_res->user_mobile_no, $message);

		$this->send_mail($chef_res->user_email, $subject_chef, $chef_credential_msg);

		$msg = 'Address add successfully!';	

			$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');

			redirect(MODULE_NAME.'cart');

   		

    }



    public function addAjaxAddress()

	{	

		$patient_id 	= $this->data['session']->user_id;

		$ajax_user_address  	= (!empty($this->input->post('ajax_user_address'))) ? $this->input->post('ajax_user_address') : '0';

		$post['user_id'] 			 	 = $patient_id;

		$post['user_address'] 			 = $ajax_user_address;

		if(!empty($post['user_address']))

		{

			$address_data = $this->get_latlong_by_address($post['user_address']);

           if(!empty($address_data))

           {

               $user_latitude = $address_data['latitude'];

               $user_longitude = $address_data['longitude'];

               $chef_res = $this->common_model->getData('tbl_user', array('user_id'=>'2'), 'single');

               $global_res = $this->common_model->getData('tbl_global_setting', NULL, 'single');

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

           		$post['user_latitude'] = $post['user_latitude'];

           		$post['user_longitude'] = $post['user_longitude'];

           		$post['address_approval_status'] = 'Pending';

           		$post['special_delivery_charge'] = $global_res->special_delivery_charge ;

           } 

		}

		$post['profile_address'] 		 = '0';

		$post['address_created_date'] 	 = date('Y-m-d');

		$address_id = $this->common_model->addData('tbl_address', $post);

		/*CHEF NOTIFICATION*/

		$patient_res = $this->common_model->getData('tbl_user',array('user_id'=>$patient_id), 'single');

		$subject_chef = "New Address Registration";

   		$chef_credential_msg  = '';

		$chef_credential_msg .= '<html><body bgcolor="#f6f8f1" style="min-width: 100% !important;color:#111 ; margin: 0; padding: 0;">';

		$chef_credential_msg .= '<p><b>Patient  Name  ' .$patient_res->user_fname.' '.$patient_res->user_lname.'</b></p>';

		$chef_credential_msg .= '<p><b>Thanks & Regards</b></p>';

		$chef_credential_msg .= '<p><b>Team CIRCADIAN FOOD </b></p>';

		$chef_credential_msg .= '</body></html>';



		$message = '';

		$this->clickSendMessage($chef_res->user_mobile_no, $message);

		$this->send_mail($chef_res->user_email, $subject_chef, $chef_credential_msg);

		echo $address_id;

    }



    public function downloadPDF()

    {

    	if (isset($_POST['Submit']) && $_POST['Submit'] == "Export") 

        {

            $start_date 	= $this->input->post('start_date');

            $end_date 		= $this->input->post('end_date');

            $end_date = date("Y-m-d", strtotime($end_date));

            if(!empty($start_date) && !empty($end_date))

            {

            	$order_res = $this->common_model->getData('tbl_order', array('order_create_date >='=>$start_date, 'order_create_date <= '=>$end_date, 'delivery_status'=>'Pending'), 'multi' );

            }

            else

            {

            	$order_res = $this->common_model->getData('tbl_order', array('delivery_status'=>'Pending'), 'multi' );

            }

			$this->data['order_res'] = $order_res;

			$this->load->view('admin/order/download_pdf', $this->data);

        



            /*$this->load->library('pdf'); 

			$filename = "order_pdf";

			$print_html = $this->load->view('admin/order/download_pdf', $this->data, TRUE);

			$this->pdf->create($print_html, $filename);*/





			/*$print_html = mb_convert_encoding($print_html, 'HTML-ENTITIES', 'UTF-8');

	      	$print_path = FCPATH.'webroot/upload/admin/';

	      	$print_name = 'pdf_.pdf';



	      	require_once(APPPATH . '/libraries/dompdf/autoload.inc.php');

	      	$options = new Options();

	      	$options->set('isRemoteEnabled', TRUE);

	        $dompdf = new Dompdf($options);

	        $dompdf->loadHtml($print_html);

	        $dompdf->setPaper('Legal', 'landscape');

	        $dompdf->set_option('isHtml5ParserEnabled', true);

	        $dompdf->render();

	        $dompdf->stream();*/



			/*$this->load->library('m_pdf');

			$this->data['this_obj'] = $this; 

			$print_html = $this->load->view('admin/order/download_pdf', $this->data, TRUE);

			$pdfFilePath = 'location_pdf'.'-'.time().".pdf";     

			$this->m_pdf->pdf->WriteHTML($print_html);

			$this->m_pdf->pdf->Output($pdfFilePath , 'D');*/

        }

    }



    /*DELIVER SHEET PRINT*/

	public function downloadDeliverySheet(){			

		$this->show_view(MODULE_NAME.'order/download_deliver_sheet_view', $this->data);

    }

    public function bulkDeliverSheetPrintLabel(){	

		$delivery_person_id 		= $this->input->post('delivery_person_id');

		$delivery_person_res = $this->common_model->getData('tbl_delivery_person_assign', array('delivery_person_id'=>$delivery_person_id), 'multi');

		if(!empty($delivery_person_res))

		{

			$this->data['delivery_person_res'] 	= $delivery_person_res;

			$this->load->view(MODULE_NAME.'order/bulk_deliver_sheet_label_print', $this->data);

		}

    }



    /*END DELIVER SHEET PRINT*/

    

}

/* End of file */?>