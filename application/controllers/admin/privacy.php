<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Privacy extends MY_Controller{
	function __construct(){
		parent::__construct();
	}	
    
    /* Add & update */
    public function index(){    	
		if($this->checkAddPermission()){
			if (isset($_POST['Submit'])){			
				$post['privacy_policy'] 				= $this->input->post('privacy_policy');
				$post['term_n_condition'] 				= $this->input->post('term_n_condition');
				$post['return_police'] 					= $this->input->post('return_police');
               	$post['privacy_created_by'] 			= $this->data['session']->user_id;
				$post['privacy_updated_date'] 		= date('Y-m-d');
				if($_POST['Submit'] == 'Add' && $_POST['privacy_id'] == ''){
					$post['privacy_created_date'] = date('Y-m-d');
					$this->common_model->addData('cm_privacy' , $post);
				}
				else if($_POST['Submit'] == 'Edit' && $_POST['privacy_id'] != ''){
					$this->common_model->updateData('cm_privacy' , array('privacy_id' => $_POST['privacy_id']) , $post);
	           	}
	           	$msg = 'Global Setting Added Successfully!!';					
				$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
				redirect( base_url().MODULE_NAME.'privacy');
			}
			else{
				$this->data['privacy_setting'] = $this->common_model->getData('cm_privacy' , NULL , 'single');
				$this->show_view(MODULE_NAME.'privacy_page/privacy_page_add', $this->data);
			}
		}
		else{	
			redirect( base_url().MODULE_NAME.'dashboard/error/1');
		}	
    }
}
?>