<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Exceed extends MY_Controller {
	function __construct(){
		parent::__construct();
		if(!empty(MODULE_NAME))
		{
			$this->load->model(MODULE_NAME.'dashboard_model');
			$this->load->model(MODULE_NAME.'exceed_model');
		}
	}
	/* Details */
	public function index(){
		if($this->checkViewPermission()){
			$this->show_view(MODULE_NAME.'exceed/exceed_view',$this->data);
		}else{	
			redirect(base_url().MODULE_NAME.'dashboard/error/1');
		}
    }
    public function loadExceedListData()
    {
    	$cart_list = $this->exceed_model->getAllExceedList();
    	$data = array();
        $no = $_POST['start'];
        foreach ($cart_list as $c_res) 
	    {
	    	$patient_res = $this->common_model->getData('tbl_user', array('user_id'=>$c_res->patient_id), 'single');
	    	$totalQty = $this->dashboard_model->gettotalQty($c_res->patient_id);
	        $totalBreakfastQty = $this->dashboard_model->gettotalBreakfastQty($c_res->patient_id);
	        $toTalQTY = $totalQty->qty + $totalBreakfastQty->qty;
	        if($toTalQTY >= '20')
	        {
	        	$no++;
				$row   = array();
				$row[] = $no;
				$row[] = (!empty($patient_res->user_fname)) ? $patient_res->user_fname.' '.$patient_res->user_lname : '';
				$row[] = (!empty($patient_res->user_mobile_no)) ? $patient_res->user_mobile_no : '';
				$row[] = $toTalQTY;
				$row[] = date("m-d-Y", strtotime($c_res->cart_created_date));;
				$cart_approval_status = '';
		 		if($c_res->cart_approval_status == 'Pending')
	            {
	            	$cart_approval_status .= '<span class="label label-danger">'.$c_res->cart_approval_status.'</span>&nbsp;&nbsp;';
	            	$cart_approval_status .= '<span class="btn btn-primary btn-sm" title="Status" onclick="approvalModel('.$c_res->patient_id.');"><i class="fa fa-plus fa-1x "></i></span>&nbsp;&nbsp;';
	            }
	            else
	            {
	            	if($c_res->cart_approval_status == 'Approved')
	            	{
	            		$classname = 'success';
	            	}
	            	else
	            	{	
	            		$classname = 'danger';
	            	}
	            	$cart_approval_status .= '<span class="label label-'.$classname.'">'.$c_res->cart_approval_status.'</span>&nbsp;&nbsp;';
	            }
		 	    $row[] = $cart_approval_status;
		 		$btn = '';
		 		if($this->checkViewPermission())
		 		{
		 			$btn .= '<a class="btn btn-primary btn-sm" href="'.base_url().''.MODULE_NAME.'exceed/cartDetails/'.$c_res->patient_id.'" title="View"><i class="fa fa-eye fa-1x "></i></a>&nbsp;&nbsp;';
		 		}
		 		$row[] = $btn;
	            $data[] = $row;
	        }
			
        }
        $output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => count($cart_list),
			"recordsFiltered" => $this->exceed_model->count_filtered(),
			"data" => $data,
		);
       	//output to json format
       	echo json_encode($output);
    }

	public function cartDetails($patient_id = ''){
		if($patient_id){
			$this->data['patient_id'] = $patient_id;
			$this->show_view(MODULE_NAME.'exceed/cart_view',$this->data);
		}
	}
	public function approvalModel()
	{
	    $patient_id = $this->input->post('patient_id');
	    $this->data['patient_id'] = $patient_id;
	    $this->load->view(MODULE_NAME.'exceed/approval_model', $this->data);
	}

	public function approvalStatus()
    {
    	if (isset($_POST['Submit']) && $_POST['Submit'] == "Update" && isset($_POST['patient_id'])) 
        {
            $patient_id 							= $this->input->post('patient_id');
			$post_u['cart_approval_status'] 	= $this->input->post('cart_approval_status');
			$this->common_model->updateData('tbl_cart', array('patient_id'=>$patient_id), $post_u); 
			/*NOTIFICATION*/
			$patient_res = $this->common_model->getData('tbl_user', array('user_id'=>$patient_id), 'single');
			$sendMail  = $patient_res->user_email;
			$credential_msg  = '';
			$credential_msg .= '<html><body bgcolor="#f6f8f1" style="min-width: 100% !important;color:#111 ; margin: 0; padding: 0;">';
			$credential_msg .= 'Dear "'.$patient_res->user_fname.' '.$patient_res->user_lname.'", Your order of more than 20 quantities has been approved, please visit the website and complete the order process';
			$credential_msg .= '<p><b>Thanks & Regards</b></p>';
			$credential_msg .= '</body></html>';
	       	$subject = "Order Approved";

	   		$message = 'Dear "'.$patient_res->user_fname.' '.$patient_res->user_lname.'", Your order of more than 20 quantities has been approved, please visit the website and complete the order process';
	   		$this->clickSendMessage($patient_res->user_mobile_no, $message);
	   		$mail_send = $this->send_mail($sendMail, $subject, $credential_msg);  
            $msg = 'Status Update successfully!!';					
			$this->session->set_flashdata('message', '<section class="content"><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
            redirect(base_url().MODULE_NAME.'exceed');	
        }
    }
}
