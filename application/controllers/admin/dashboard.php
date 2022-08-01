<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends MY_Controller{
	function __construct(){
		parent::__construct();
		if(!empty(MODULE_NAME)){
		   $this->load->model(MODULE_NAME.'dashboard_model');
		}
	}

    public function index(){
     	$role_id = $this->data['session']->role_id;
     	if($role_id == '2')
     	{
     		$this->chefDashboard();
     	}
     	else
     	{
	     	$doctor_id = $this->data['session']->doctor_id;
	     	if($doctor_id != '0')
	     	{
	     		$this->doctorPatient();
	     	}
	     	else
	     	{
				
	     		$this->selfPatient();
	     	}
     	}
	}

	public function chefDashboard(){
     	if($this->checkAddPermission())
		{
			if (isset($_POST['Submit']) && $_POST['Submit'] == "search")
			{
				$start_date 	= $this->input->post('start_date');
				$end_date 		= $this->input->post('end_date');
			}
			else
			{
				$start_date 	= '';
				$end_date 		= '';
			}
			$this->data['start_date'] 	= $start_date;
			$this->data['end_date'] 	= $end_date;
			$this->show_view(MODULE_NAME.'chef_dashboard', $this->data);
		}
		else
		{
			redirect( base_url().MODULE_NAME.'dashboard/error/1');
		}
	}
	public function doctorPatient(){
     	if($this->checkAddPermission())
		{
			if (isset($_POST['Submit']) && $_POST['Submit'] == "Add")
			{
				$patient_id = $this->data['session']->user_id;
				$patient_res = $this->common_model->getData('tbl_user', array('user_id'=>$patient_id), 'single');
				if(!empty($patient_res))
				{
					$address_tbl_res = $this->common_model->getData('tbl_address', array('default_address'=>1, 'address_approval_status'=>'Approved','user_id'=>$patient_id), 'single');
					$chef_res = $this->common_model->getData('tbl_user', array('user_id'=>'2'), 'single');
					if(!empty($address_tbl_res))
					{
						$total_distance = (!empty($address_tbl_res)) ? $address_tbl_res->total_distance : '0';
						$distance_charge = (!empty($address_tbl_res)) ? $address_tbl_res->distance_charge : '0';
						$address_id = (!empty($address_tbl_res)) ? $address_tbl_res->address_id : '0';
						$user_address = (!empty($address_tbl_res)) ? $address_tbl_res->user_address : '0';
						$post_f['user_address']  =$user_address;
						$post_f['address_id']  =$address_id;
						$post_f['total_distance']  = round($total_distance);
						$post_f['distance_charge'] =  $distance_charge;
						$extra_delivery_res = $this->common_model->getData('tbl_global_setting', NULL, 'single');
						if(!empty($extra_delivery_res))
						{
							if($extra_delivery_res->deliver_status == 'Off')
							{
								$post_f['extra_delivery_charge'] =  $extra_delivery_res->deliver_charge;
							}
							else
							{
								$post_f['extra_delivery_charge'] =  '0';
							}
						}

						if(!empty($extra_delivery_res))
						{
							if($extra_delivery_res->order_status == 'Open')
							{
								/*$current_date_time = date('2021-09-16 12:22');*/
								$current_date_time = date('Y-m-d H:i');
								$closeing_date  = $extra_delivery_res->closeing_date;
								$deadline_date  = $extra_delivery_res->deadline_date;
								if($current_date_time <= $closeing_date)
								{
									$post_f['late_charge'] =  '0';
								}
								else
								{
									/*if($current_date_time <= $deadline_date)
									{
										echo "cc";
									}
									else
									{
										echo "DD";
									}*/
									$post_f['late_charge'] =  $extra_delivery_res->late_charge;
									/*Chef Send to sms with multipale no*/
									/*$no_of_phone_no = $this->common_model->getData('tbl_phone_no', array('user_id'=>$chef_res->user_id), 'multi');
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
									}*/
								}
							}
						}
						/*echo "<pre>";
						print_r($_POST);die;*/
						$product_id 	= $this->input->post('product_id');
						$macro_id 		= $this->input->post('macro_id');
						$macro_value_id = $this->input->post('macro_value_id');
						if(!empty($product_id)){
							for ($i=0; $i<count($product_id); $i++){
								if(!empty($product_id[$i])){
									$qty  = $this->input->post('qty');
									$product_res = $this->common_model->getData('tbl_product', array('product_id'=>$product_id[$i]), 'single');
									$post_f['product_price']  	= $product_res->product_price;

									$post_f['total_product_price']  = $macro_value_id[$i] * $post_f['product_price'];


									$post_f['product_id']  		= $product_id[$i];
									$post_f['macro_id']  		= $macro_id[$i];
									$post_f['macro_value_id']  	= $macro_value_id[$i];
									$post_f['qty']  			= $qty[$i];
									$post_f['patient_id']  		= $this->data['session']->user_id;

									$post_f['cart_created_date'] = date('Y-m-d');
									$post_f['cart_updated_date'] = date('Y-m-d');
									if($post_f['qty'] != 0)
									{
										$cart_check = $this->common_model->getData('tbl_cart', NULL, 'single', NULL, 'cart_id DESC');
										if(!empty($cart_check))
										{
											$post_f['unique_no'] = $cart_check->unique_no + 1;
										}
										else
										{
											$post_f['unique_no'] = 1;
										}
									}
									$post_f['note'] = $this->input->post('note');
									$nnn_post = $this->xssCleanValidate($post_f);
									$this->common_model->addData('tbl_cart', $nnn_post);
								}
							}	
						}
						/*breakfast*/
						$bre_post['qty'] = $this->input->post('break_fast_qty');
						if(!empty($bre_post['qty']))
						{
							$bre_post['breakfast_id_1'] = $this->input->post('breakfast_id_1');
							$bre_post['breakfast_qty_1'] = $this->input->post('breakfast_value_1');
							$bre_post['breakfast_product_id_1'] = $this->input->post('breakfast_product_id_1');
							$bre_post['breakfast_id_2'] = $this->input->post('breakfast_id_2');
							$bre_post['breakfast_qty_2'] = $this->input->post('breakfast_value_2');
							$bre_post['breakfast_product_id_2'] = $this->input->post('breakfast_product_id_2');
							$bre_post['patient_id'] = $patient_id;
							$bre_post['breakfast_cart_create_date'] = date('Y-m-d');

							$product_res1 = $this->common_model->getData('tbl_product', array('product_id'=>$bre_post['breakfast_product_id_1']), 'single');
							$product_price1  	= $product_res1->product_price;

							$product_res2 = $this->common_model->getData('tbl_product', array('product_id'=>$bre_post['breakfast_product_id_2']), 'single');
							$product_price2  	= $product_res2->product_price;

							$product_price = $bre_post['breakfast_qty_1'] * $product_price1 + $bre_post['breakfast_qty_2'] * $product_price2;
							$bre_post['breakfast_price'] = $product_price * $bre_post['qty'];
							$this->common_model->addData('tbl_breakfast_cart', $bre_post);
						}
						$msg = 'Cart added successfully!';	
						$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
						redirect(MODULE_NAME.'cart');
					}
					else
					{
						$msg = 'Please select your address..!';	
						$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-danger alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
						redirect(MODULE_NAME.'dashboard');
					}

				}	
			}
			else
			{
				$this->show_view(MODULE_NAME.'dashboard', $this->data);
			}
		}
		else
		{
			redirect( base_url().MODULE_NAME.'dashboard/error/1');
		}
	}

	public function selfPatient(){	
     	if($this->checkAddPermission())
		{
			if (isset($_POST['Submit']) && $_POST['Submit'] == "Add")
			{
				$patient_id = $this->data['session']->user_id;
				$patient_res = $this->common_model->getData('tbl_user', array('user_id'=>$patient_id), 'single');
				if(!empty($patient_res))
				{
					$address_tbl_res = $this->common_model->getData('tbl_address', array('default_address'=>1, 'address_approval_status'=>'Approved','user_id'=>$patient_id), 'single');
					$chef_res = $this->common_model->getData('tbl_user', array('user_id'=>'2'), 'single');
					if(!empty($address_tbl_res))
					{
						$total_distance = (!empty($address_tbl_res)) ? $address_tbl_res->total_distance : '0';
						$distance_charge = (!empty($address_tbl_res)) ? $address_tbl_res->distance_charge : '0';
						$address_id = (!empty($address_tbl_res)) ? $address_tbl_res->address_id : '0';
						$user_address = (!empty($address_tbl_res)) ? $address_tbl_res->user_address : '0';
						$post_f['user_address']  =$user_address;
						$post_f['address_id']  =$address_id;
						$post_f['total_distance']  = round($total_distance);
						$post_f['distance_charge'] =  $distance_charge;
						$extra_delivery_res = $this->common_model->getData('tbl_global_setting', NULL, 'single');
						if(!empty($extra_delivery_res))
						{
							if($extra_delivery_res->deliver_status == 'Off')
							{
								$post_f['extra_delivery_charge'] =  $extra_delivery_res->deliver_charge;
							}
							else
							{
								$post_f['extra_delivery_charge'] =  '0';
							}
						}
						if(!empty($extra_delivery_res))
						{
							if($extra_delivery_res->order_status == 'Open')
							{
								/*$current_date_time = date('2021-09-16 12:22');*/
								$current_date_time = date('Y-m-d H:i');
								$closeing_date  = $extra_delivery_res->closeing_date;
								$deadline_date  = $extra_delivery_res->deadline_date;
								if($current_date_time <= $closeing_date)
								{
									$post_f['late_charge'] =  '0';
								}
								else
								{
									/*if($current_date_time <= $deadline_date)
									{
										echo "cc";
									}
									else
									{
										echo "DD";
									}*/
									$post_f['late_charge'] =  $extra_delivery_res->late_charge;
									/*$no_of_phone_no = $this->common_model->getData('tbl_phone_no', array('user_id'=>$chef_res->user_id), 'multi');
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
									}*/
								}
							}
						}

						/*echo "<pre>";
						print_r($_POST);die;*/
						$product_id 	= $this->input->post('product_id');
						$macro_id 		= $this->input->post('macro_id');
						$macro_value_id = $this->input->post('macro_value_id');
						if(!empty($product_id)){
							for ($i=0; $i<count($product_id); $i++){
								if(!empty($product_id[$i])){
									$qty  = $this->input->post('qty');
									$product_res = $this->common_model->getData('tbl_product', array('product_id'=>$product_id[$i]), 'single');
									$post_f['product_price']  	= $product_res->product_price;

									$post_f['total_product_price']  = $macro_value_id[$i] * $post_f['product_price'];


									$post_f['product_id']  		= $product_id[$i];
									$post_f['macro_id']  		= $macro_id[$i];
									$post_f['macro_value_id']  	= $macro_value_id[$i];
									$post_f['qty']  			= $qty[$i];
									$post_f['patient_id']  		= $this->data['session']->user_id;

									$post_f['cart_created_date'] = date('Y-m-d');
									$post_f['cart_updated_date'] = date('Y-m-d');
									if($post_f['qty'] != 0)
									{
										$cart_check = $this->common_model->getData('tbl_cart', NULL, 'single', NULL, 'cart_id DESC');
										if(!empty($cart_check))
										{
											$post_f['unique_no'] = $cart_check->unique_no + 1;
										}
										else
										{
											$post_f['unique_no'] = 1;
										}

									}
									$post_f['note'] = $this->input->post('note');
									$nnn_post = $this->xssCleanValidate($post_f);
									$this->common_model->addData('tbl_cart', $nnn_post);
								}
							}	
						}
						/*breakfast*/
						$break_fast_qty = $this->input->post('break_fast_qty');
						if(!empty($break_fast_qty))						
						{
							$break_fast_qty = $this->input->post('break_fast_qty');
							$breakfast_id_1 = $this->input->post('breakfast_id_1');
							$breakfast_qty_1 = $this->input->post('breakfast_value_1');
							$breakfast_product_id_1 = $this->input->post('breakfast_product_id_1');
							$breakfast_id_2 = $this->input->post('breakfast_id_2');
							$breakfast_qty_2 = $this->input->post('breakfast_value_2');
							$breakfast_product_id_2 = $this->input->post('breakfast_product_id_2');							 
							$breakfast_cart_create_date = date('Y-m-d');

							for ($j=0; $j<count($break_fast_qty); $j++){
							$bre_post['qty'] = $break_fast_qty[$j];
							$bre_post['breakfast_id_1'] = $breakfast_id_1[$j];
							$bre_post['breakfast_qty_1'] = $breakfast_qty_1[$j];
							$bre_post['breakfast_product_id_1'] = $breakfast_product_id_1[$j];
							$bre_post['breakfast_id_2'] =  $breakfast_id_2[$j];
							$bre_post['breakfast_qty_2'] = $breakfast_qty_2[$j];
							$bre_post['breakfast_product_id_2'] = $breakfast_product_id_2[$j];
							$bre_post['patient_id'] = $patient_id;
							$bre_post['breakfast_cart_create_date'] = $breakfast_cart_create_date;

					

							
								$product_res1 = $this->common_model->getData('tbl_product', array('product_id'=>$bre_post['breakfast_product_id_1']), 'single');
								$product_price1  	= $product_res1->product_price;
	
								$product_res2 = $this->common_model->getData('tbl_product', array('product_id'=>$bre_post['breakfast_product_id_2']), 'single');
								$product_price2  	= $product_res2->product_price;
	
								$product_price = $bre_post['breakfast_qty_1'] * $product_price1 + $bre_post['breakfast_qty_2'] * $product_price2;
								$bre_post['breakfast_price'] = $product_price * $bre_post['qty'];
								$this->common_model->addData('tbl_breakfast_cart', $bre_post);
							 


							}



						}
						$msg = 'Cart added successfully!';	
							$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
							redirect(MODULE_NAME.'cart');
					}
					else
					{
						$msg = 'Please select your address..!';	
						$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-danger alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
						redirect(MODULE_NAME.'dashboard');
					}
				}
					
			}
			else
			{
				$this->show_view(MODULE_NAME.'self_patient_dashboad', $this->data);
			}
		}
		else
		{
			redirect( base_url().MODULE_NAME.'dashboard/error/1');
		}
	}
	public function error(){	
		$value = $this->uri->segment(4);
		if($value == '1'){	
			$this->show_view(MODULE_NAME.'error/error_permission', $this->data);
		}		
    }

    /* State List by Country ID */
	public function productWiseVeggies(){
		$product_id = $this->input->post('product_id');
		$macro_id 	= $this->input->post('macro_id');
		$veggies_list = $this->common_model->productWiseVeggies($product_id, $macro_id);
		$html = '';
		$html .= '<option value="">Veggies</option>';
		if(!empty($veggies_list)){
			foreach ($veggies_list as $v_list){
				$html .= '<option value="'.$v_list->product_id.'">'.$v_list->product_name.'</option>';
			}
		}
		else
		{
			$veggies_all_list = $this->common_model->getData('tbl_product', array('category_id'=>3,'product_status'=>1), 'multi');
			if(!empty($veggies_all_list)){
				foreach ($veggies_all_list as $v_list){
					$html .= '<option value="'.$v_list->product_id.'">'.$v_list->product_name.'</option>';
				}
			}
		}
		echo $html;
	}
	public function productWiseCarb(){
		$product_id = $this->input->post('product_id');
		$macro_id 	= $this->input->post('macro_id');
		$carb_list = $this->common_model->productWiseCarb($product_id, $macro_id);
		$html = '';
		$html .= '<option value="">Carb</option>';
		if(!empty($carb_list)){
			foreach ($carb_list as $v_list){
				$html .= '<option value="'.$v_list->product_id.'">'.$v_list->product_name.'</option>';
			}
		}
		else
		{
			$carb_all_list = $this->common_model->getData('tbl_product', array('category_id'=>2,'product_status'=>1), 'multi');
			if(!empty($carb_all_list)){
				foreach ($carb_all_list as $v_list){
					$html .= '<option value="'.$v_list->product_id.'">'.$v_list->product_name.'</option>';
				}
			}
		}
		echo $html;
	}
}
?>