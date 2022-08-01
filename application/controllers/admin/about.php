<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class About extends MY_Controller{
	function __construct(){
		parent::__construct();
	}	
    
    /* Add & update */
    public function index(){    	
		if($this->checkAddPermission()){
			if (isset($_POST['Submit'])){			
				$post['about_fbox_title'] 				= $this->input->post('about_fbox_title');
				$post['about_fbox_description'] 		= $this->input->post('about_fbox_description');
				$post['about_sbox_title'] 				= $this->input->post('about_sbox_title');
				$post['about_sbox_description'] 		= $this->input->post('about_sbox_description');
				$post['about_tbox_title'] 				= $this->input->post('about_tbox_title');
				$post['about_tbox_description'] 		= $this->input->post('about_tbox_description');
				$post['about_long_description'] 		= $this->input->post('about_long_description');
				if($_FILES["about_img"]["name"]){
                   $about_img = 'about_img';
                   $fieldName = "about_img";
                   $Path = 'webroot/upload/admin/about/';
                   $about_img = $this->ImageUpload($_FILES["about_img"]["name"], $about_img, $Path, $fieldName);
                   $post['about_img'] = $Path.'/'.$about_img;
               	}
               	$post['about_created_by'] 			= $this->data['session']->user_id;
				$post['about_updated_date'] 		= date('Y-m-d');
				if($_POST['Submit'] == 'Add' && $_POST['about_id'] == ''){
					$post['about_created_date'] = date('Y-m-d');
					$this->common_model->addData('cm_about' , $post);
				}
				else if($_POST['Submit'] == 'Edit' && $_POST['about_id'] != ''){
					$this->common_model->updateData('cm_about' , array('about_id' => $_POST['about_id']) , $post);
	           	}
	           	$msg = 'About Page Added Successfully!!';					
				$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
				redirect( base_url().MODULE_NAME.'about');
			}
			else{
				$this->data['about_setting'] = $this->common_model->getData('cm_about' , NULL , 'single');
				$this->show_view(MODULE_NAME.'about_page/about_page_add', $this->data);
			}
		}
		else{	
			redirect( base_url().MODULE_NAME.'dashboard/error/1');
		}	
    }
}
?>