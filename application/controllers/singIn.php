<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class SingIn extends My_Controller 
{
	function __construct()
	{
		parent::__construct();
        $this->load->model('home_model'); 
	}
	 
	 /*	Validation Rules */
	protected $validation_rules = array(
        'login' => array(
            array(
                'field' => 'member_mobile_no',
                'label' => 'Mobile Number',
                'rules' => 'trim|required'
            ),
			 array(
                'field' => 'member_password',
                'label' => 'Password',
                'rules' => 'trim|required'
            )
        )
    ); 
    
    public function index()
	{
		if (isset($_POST['Submit']) && $_POST['Submit'] == "Add") 
		{
			$this->form_validation->set_rules($this->validation_rules['login']);
			if ($this->form_validation->run()) 
			{
				$member_mobile_no = $this->input->post('member_mobile_no');
				$member_password = md5($this->input->post('member_password'));
				$member_res = $this->common_model->getData('cm_member', array('member_mobile_no'=>$member_mobile_no, 'member_password'=>$member_password), 'single');
				if(!empty($member_res)){
					$this->session->set_userdata('member', $member_res);
					redirect(base_url());
				}
				else
				{
					$msg = ' Your Mobile Number & Password Not Match';	
					$this->session->set_flashdata('message_new', '<section><div class="col-xs-12"><div class="alert alert-danger alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' .$msg.'</div></div></section>');
					redirect('singIn');
				}
			}
			else
			{
				$this->show_view_front('front/login', $this->data);
			}
		}
		else
		{
			$this->show_view_front('front/login', $this->data);
		}
    }

    public function downloadPrint()
    {
    	$session = $this->session->all_userdata();
        $member_id = $session['member']->member_id;
        if(!empty($member_id))
        {
	        $member_res = $this->common_model->getData('cm_member', array('member_id'=>$member_id), 'single');
	        $this->data['member_res'] = $member_res;
	      	$this->load->view('admin/membership/download_print',$this->data);

        }
    }
	
	
}