<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends MY_Controller{
	function __construct(){
		parent::__construct();
	}	
    
    /* Add & update */
    public function index(){    	
		if($this->checkAddPermission()){
			if (isset($_POST['Submit'])){			
				$post['home_page_title'] 					= $this->input->post('home_page_title');
				$post['home_page_small_description'] 		= $this->input->post('home_page_small_description');
				$post['home_page_long_description'] 		= $this->input->post('home_page_long_description');
				if($_FILES["home_page_img"]["name"]){
                   $home_page_img = 'home_page_img';
                   $fieldName = "home_page_img";
                   $Path = 'webroot/upload/admin/home/';
                   $home_page_img = $this->ImageUpload($_FILES["home_page_img"]["name"], $home_page_img, $Path, $fieldName);
                   $post['home_page_img'] = $Path.'/'.$home_page_img;
               	}
               	if($_FILES["janta_party_img"]["name"]){
                   $janta_party_img = 'janta_party_img';
                   $fieldName = "janta_party_img";
                   $Path = 'webroot/upload/admin/home/';
                   $janta_party_img = $this->ImageUpload($_FILES["janta_party_img"]["name"], $janta_party_img, $Path, $fieldName);
                   $post['janta_party_img'] = $Path.'/'.$janta_party_img;
               	}
               	if($_FILES["logo"]["name"]){
                   $logo = 'logo';
                   $fieldName = "logo";
                   $Path = 'webroot/upload/admin/home/';
                   $logo = $this->ImageUpload($_FILES["logo"]["name"], $logo, $Path, $fieldName);
                   $post['logo'] = $Path.'/'.$logo;
               	}
               	$post['home_page_created_by'] 			= $this->data['session']->user_id;
				$post['home_page_updated_date'] 		= date('Y-m-d');
				if($_POST['Submit'] == 'Add' && $_POST['home_page_id'] == ''){
					$post['home_page_created_date'] = date('Y-m-d');
					$this->common_model->addData('cm_home_page' , $post);
				}
				else if($_POST['Submit'] == 'Edit' && $_POST['home_page_id'] != ''){
					$this->common_model->updateData('cm_home_page' , array('home_page_id' => $_POST['home_page_id']) , $post);
	           	}
	           	$msg = 'Home Page Added Successfully!!';					
				$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
				redirect( base_url().MODULE_NAME.'home');
			}
			else{
				$this->data['home_setting'] = $this->common_model->getData('cm_home_page' , NULL , 'single');
				$this->show_view(MODULE_NAME.'home_page/home_page_add', $this->data);
			}
		}
		else{	
			redirect( base_url().MODULE_NAME.'dashboard/error/1');
		}	
    }
}
?>