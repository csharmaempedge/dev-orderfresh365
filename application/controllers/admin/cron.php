<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cron extends MY_Controller{
	function __construct(){
		parent::__construct();
		if(!empty(MODULE_NAME)){
			$this->load->model('common_model');
		}
	}
	
	/* CRON JOB */
	public function index(){
		$c_date = date('Y-m-d');
		$global_res = $this->common_model->getData('tbl_global_setting', NULL, 'single');
		$check_macros = $this->common_model->getData('tbl_patient_macro', array('cron_date'=>$c_date), 'multi',NULL,NULL,NULL,'patient_id');
		if(!empty($check_macros))
		{
			foreach ($check_macros as $c_res) 
			{
				$check_order_res = $this->common_model->getData('tbl_order', array('patient_id'=>$c_res->patient_id), 'single');
				if(!empty($check_order_res))
				{
					$check_order_date_res = $this->common_model->getData('tbl_order', array('patient_id'=>$c_res->patient_id,'cron_date'=>$c_res->cron_date), 'single');
					if(empty($check_order_date_res))
					{
						$patient_res = $this->common_model->getData('tbl_user', array('user_id'=>$c_res->patient_id), 'single');
						$mail_msg  = $global_res->pending_order_mail_body;
				       	$subject = "Cron Job";
				       	if($patient_res->email_reminder =='ON')
				       	{
				       		$this->send_mail($patient_res->user_email, $subject, $mail_msg);
				       	}
				       	if($patient_res->text_reminder =='ON')
				       	{
				       		$sms_message = $global_res->sms_Reminder_body;
							$this->clickSendMessage($patient_res->user_mobile_no, $sms_message);
				       	}
					}
				}
				else
				{
					$patient_res = $this->common_model->getData('tbl_user', array('user_id'=>$c_res->patient_id), 'single');
					$mail_msg  = $global_res->pending_order_mail_body;
			       	$subject = "Cron Job";
			       	if($patient_res->email_reminder =='ON')
			       	{
			       		$this->send_mail($patient_res->user_email, $subject, $mail_msg);
			       	}
			       	if($patient_res->text_reminder =='ON')
			       	{
			       		$sms_message = $global_res->sms_Reminder_body;
						$this->clickSendMessage($patient_res->user_mobile_no, $sms_message);
			       	}
				}
			}
		}
	}
}
?>