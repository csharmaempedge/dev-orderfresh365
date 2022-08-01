<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ob_start();
class Home extends My_Controller 
{
	function __construct()
	{
		parent::__construct();
        $this->load->model('home_model'); 
	}
	  
    
    /*  Validation Rules */
    protected $validation_rules = array(
        'visitorAdd' => array(
            array(
                'field' => 'visitor_email',
                'label' => 'Email',
                'rules' => 'trim|required'//|is_unique[cm_visitor.visitor_email]|valid_email
            )
        )
    );
	public function index()
	{
		$this->show_view_front('front/home', $this->data);
    }


    public function commonFullView($type = '',$id = '')
    {
        if($type == 'mission')
        {
            $this->data['mission_id'] = $id;
            $this->data['mission_res'] = $this->common_model->getData('cm_mission', array('mission_id'=>$id), 'single');
        }
        if($type == 'vision')
        {
            $this->data['vision_id'] = $id;
            $this->data['vision_res'] = $this->common_model->getData('cm_vision', array('vision_id'=>$id), 'single');
        }
        if($type == 'home_page')
        {
            $this->data['home_pages_res'] = $this->common_model->getData('cm_home_page', NULL, 'single');
        }
        if($type == 'privacyPolicy')
        {
            $this->data['privacy_res'] = $this->common_model->getData('tbl_global_setting', NULL, 'single');
        }
        if($type == 'termsCondition')
        {
            $this->data['privacy_res'] = $this->common_model->getData('tbl_global_setting', NULL, 'single');
        }
        
        $this->data['type'] = $type;
        $this->show_view_front('front/common_details_view', $this->data);
    }
    
	
	
}