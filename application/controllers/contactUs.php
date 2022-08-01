<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ContactUs extends My_Controller 
{
	function __construct()
	{
		parent::__construct();
        $this->load->model('home_model'); 
	}
	  
    

	public function index()
	{
		if (isset($_POST['Submit']) && $_POST['Submit'] == "Add") 
		{
			$post['contact_us_name'] 			= $this->input->post('contact_us_name');
			$post['contact_us_subject'] 		= $this->input->post('contact_us_subject');
			$post['contact_us_email'] 			= $this->input->post('contact_us_email');
			$post['contact_us_message'] 		= $this->input->post('contact_us_message');
			$post['contact_us_phone_no'] 		= $this->input->post('contact_us_phone_no');
			$post['contact_us_created_datetime']= date('Y-m-d H:i:s');
			$n_post = $this->xssCleanValidate($post);
			$agenda_id = $this->common_model->addData('cm_contact_us', $n_post);
	
           	$msg = 'Contact Form Added Successfully!!';					
			$this->session->set_flashdata('message_new', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
			redirect(base_url().'contactUs');
		}
		else
		{
			$this->show_view_front('front/contact_us', $this->data);
		}
    }

    /* Add ContactUs */
    public function addContactUs()
    {
    	if (isset($_POST['Submit']) && $_POST['Submit'] == "Add") 
		{
			$post['contact_us_name'] 			= $this->input->post('contact_us_name');
			$post['contact_us_subject'] 		= $this->input->post('contact_us_subject');
			$post['contact_us_email'] 			= $this->input->post('contact_us_email');
			$post['contact_us_message'] 		= $this->input->post('contact_us_message');
			$post['contact_us_phone_no'] 		= $this->input->post('contact_us_phone_no');
			$post['contact_us_created_datetime']= date('Y-m-d H:i:s');
			$n_post = $this->xssCleanValidate($post);
			$agenda_id = $this->common_model->addData('cm_contact_us', $n_post);
	
           	$msg = 'Contact Form Added Successfully!!';					
			$this->session->set_flashdata('message_new', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
			redirect(base_url().'home');
		}
    }
	
	
}