<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class GlobalSetting extends MY_Controller{



	function __construct(){



		parent::__construct();



	}	



    



    /* Add & update */



    public function index(){    	



		if($this->checkAddPermission()){



			if (isset($_POST['Submit'])){			



				$post['deliver_status'] 		= $this->input->post('deliver_status');



				$post['deliver_charge'] 		= $this->input->post('deliver_charge');



				$post['tax'] 					= $this->input->post('tax');



				$post['expire_date'] 			= $this->input->post('expire_date');



				$post['front_delivery_date'] 			= $this->input->post('front_delivery_date');



				$post['special_delivery_charge'] = $this->input->post('special_delivery_charge');



				$post['theme_color'] 			= $this->input->post('theme_color');



				/*$post['privacy_policy'] 		= $this->input->post('privacy_policy');



				$post['term_n_condition'] 		= $this->input->post('term_n_condition');*/



				$post['pending_order_mail_body'] = $this->input->post('pending_order_mail_body');



				$post['sms_Reminder_body']		= $this->input->post('sms_Reminder_body');



				$post['registration_message']		= $this->input->post('registration_message');
				$post['patient_registration_mail']		= $this->input->post('patient_registration_mail');

				$post['order_open_sms'] 			= $this->input->post('order_open_sms');
				$post['order_open_mail'] 			= $this->input->post('order_open_mail');
				$post['order_close_sms'] 			= $this->input->post('order_close_sms');
				$post['order_close_mail'] 			= $this->input->post('order_close_mail');

				$post['smtp_mail']		= $this->input->post('smtp_mail');



				$post['smtp_password']		= $this->input->post('smtp_password');
				$post['smtp_secure']		= $this->input->post('smtp_secure');
				$post['smtp_host']		= $this->input->post('smtp_host');
				$post['smtp_port']		= $this->input->post('smtp_port');



				$post['warning_message']		= $this->input->post('warning_message');



				$post['minimum_surcharge']		= $this->input->post('minimum_surcharge');



				$post['minimum_order_warning_message']		= $this->input->post('minimum_order_warning_message');



				$post['quantites_20_message']		= $this->input->post('quantites_20_message');



				$post['gs_updated_date'] 		= date('Y-m-d');



				if($_POST['Submit'] == 'Add' && $_POST['gs_id'] == ''){



					$post['gs_created_date'] = date('Y-m-d');



					$this->common_model->addData('tbl_global_setting' , $post);



				}



				else if($_POST['Submit'] == 'Edit' && $_POST['gs_id'] != ''){



					$this->common_model->updateData('tbl_global_setting' , array('gs_id' => $_POST['gs_id']) , $post);



	           	}



	           	$distance_res = $this->common_model->getData('tbl_distance', NULL, 'multi');



                if(!empty($distance_res))



                {



                    foreach($distance_res as $res)



                    {



                    	$dis_post['distance_amount'] = $this->input->post('distance_amount_'.$res->distance_id);



                    	$this->common_model->updateData('tbl_distance' , array('distance_id' => $res->distance_id) , $dis_post);



                    }



                }



	           	$msg = 'update successfully!!';					



				$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');



				redirect(base_url().MODULE_NAME.'globalSetting');



			}



			else{



				$this->data['gs_setting'] = $this->common_model->getData('tbl_global_setting' , NULL , 'single');



				$this->show_view(MODULE_NAME.'global_setting/global_setting_add', $this->data);



			}



		}



		else{	



			redirect( base_url().MODULE_NAME.'dashboard/error/1');



		}	



    }



}



?>