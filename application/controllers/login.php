<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends My_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('login_model');
	}
	
	/*	Validation Rules */
	protected $validation_rules = array(
        'login' => array(
            array(
                'field' => 'user_name',
                'label' => 'Username',
                'rules' => 'trim|required'
            ),
			 array(
                'field' => 'user_password',
                'label' => 'Password',
                'rules' => 'trim|required'
            )
        ),
        'forgotPassword' => array(
            array(
                'field' => 'user_email',
                'label' => 'Email Id',
                'rules' => 'trim|required'
            )
        ),
        'changePassword' => array(
            array(
                'field' => 'new_password',
                'label' => 'New Password',
                'rules' => 'trim|required'
            ),
            array(  
				'field' => 'conf_new_password',
				'label' => 'Confirm Password', 
				'rules' => 'trim|required|matches[new_password]'
            ),	
        )
    );   
    
    function validate_captcha(){
        $captcha = $this->input->post('g-recaptcha-response');
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6Lfp5bgUAAAAAAIr4hEXrF4JMkdudNYzBZTB8pbS&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
        if ($response . 'success' == false){
            return FALSE;
        } else {
            return TRUE;
        }
    }

	public function index(){
		if($this->getSessionVal()){
			$this->admin();
		}
		else{
			$this->admin();	
		}
    }
	
	public function admin(){
		if($this->getSessionVal()){
			$session_val = $this->getSessionVal();			
			if($session_val->user_type == 'admin'){
				redirect(base_url().$session_val->module_name.'/dashboard');
			}
			else{
				$this->logout();
				redirect(base_url().'login');
			}
		}
		else{	
			try{
				if(isset($_POST['Login']) && $_POST['Login'] =='Login'){
		            $lock_session = $this->session->all_userdata();
		            if(isset($lock_session) && !empty($lock_session['qc_lockdown'])){
		                if($lock_session['qc_lockdown'] >= time()){
		                    throw new Exception('Your account has been locked for 30 minutes.');
		                }
		                else{
		                    $this->session->unset_userdata('qc_lockdown');
		                }
			        }
					$this->form_validation->set_rules($this->validation_rules['login']);
					// $this->form_validation->set_rules('g-recaptcha-response', 'recaptcha validation', 'required|callback_validate_captcha');
	    //         	$this->form_validation->set_message('validate_captcha', 'Please check the the captcha form');
					if(!$this->form_validation->run()){
		                throw new Exception(validation_errors());
		            }
					$post['user_name'] = $_POST['user_name'];
					$post['user_password'] = md5($_POST['user_password']);
					$user_login_res = $this->login_model->checkUserLogin($post);
					if(empty($user_login_res)){
	                    throw new Exception('Invalid Username And Password');
	                }
					$user_details = $this->login_model->checkUserDetails($user_login_res);
	                if(empty($user_details)){
	                    throw new Exception('Invalid Username And Password');
	                }
					$this->session->set_userdata('admin', $user_details);
					redirect(base_url().$user_login_res->module_name.'/dashboard');
				}
				$this->load->view('login_admin', $this->data);
			}
			catch(Exception $e){
	            $ipLockAction = ipLockAction();
	            if(!empty($ipLockAction)){
	                $error = $ipLockAction;
	            }
	            else{
	               $error = $e->getMessage();
	            }
				$this->session->set_flashdata('message', $error);
				redirect(base_url().'login');
			}
        }	
	}

	public function getStateList(){
		$country_id = $this->input->post('country_id');
		$state_list = $this->common_model->getStateListByCountryID($country_id);
		$html = '';
		$html .= '<option value="">Select State</option>';
		if(count($state_list) > 0){
			foreach ($state_list as $s_list){
				$html .= '<option value="'.$s_list->state_id.'">'.$s_list->state_name.'</option>';
			}
		}
		echo $html; 
	}
	
	public function logout() 
	{   
        $this->session->sess_destroy();		
        redirect( base_url());
    }
}
?>