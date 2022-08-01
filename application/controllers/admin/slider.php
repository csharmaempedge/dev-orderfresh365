<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Slider extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->data['banner_list'] = $this->common_model->getData('cm_home_banner', array('home_banner_status'=>1), 'multi');
		$this->show_view(MODULE_NAME.'slider/home_banner', $this->data);	
	}

	public function addHomeBanner($home_banner_id = '')
	{
		if($home_banner_id != '')
		{
			if (isset($_POST['Submit']) && $_POST['Submit'] == "Edit") 
			{
				$post['home_banner_heading'] 		= $this->input->post('home_banner_heading');
				$post['home_banner_status'] 		= $this->input->post('home_banner_status');				
				$post['banner_description'] 		= $this->input->post('banner_description');		
				$post['home_banner_update_date'] = date('Y-m-d');
				$post['home_banner_id'] = $home_banner_id;

				//Banner Image Uplaod
				if ($_FILES["home_banner_img_name"]["name"]) 
				{
					$res = $this->common_model->getData('cm_home_banner' , array('home_banner_id' => $home_banner_id) , 'single');
					unlink($res->home_banner_img_name);
					$home_banner_img_name  	= 'home_banner_img_name';
					$fieldName            	= "home_banner_img_name";
					$Path                 	= 'webroot/upload/admin/home_page_banner/';
					$home_banner_img_name   = $this->ImageUpload($_FILES["home_banner_img_name"]["name"], $home_banner_img_name, $Path, $fieldName);
					$post['home_banner_img_name'] = $Path.$home_banner_img_name;
                }
				$update_res = $this->common_model->updateData('cm_home_banner', array('home_banner_id'=>$home_banner_id), $post);
				if($update_res)
				{
					$msg = 'Slider Updated successfully!';			
					$this->session->set_flashdata('message', '<div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div>');
					redirect(base_url().MODULE_NAME.'slider');
				}
			}
			$this->data['edit_banner'] = $this->common_model->getData('cm_home_banner', array('home_banner_id'=>$home_banner_id,), 'single');
			$this->show_view(MODULE_NAME.'slider/update_home_banner',$this->data);
		}
		else
		{
			if (isset($_POST['Submit']) && $_POST['Submit'] == "Add")
			{
				$post['home_banner_status'] 		= $this->input->post('home_banner_status');
				$post['home_banner_heading']		= $this->input->post('home_banner_heading');
				$post['banner_description'] 		= $this->input->post('banner_description');
				$post['home_banner_created_data'] 	= date('Y-m-d');
				$post['home_banner_update_date'] 	= date('Y-m-d');

				//Banner Image Uplaod
				if ($_FILES["home_banner_img_name"]["name"]) 
				{
                   $home_banner_img_name = 'home_banner_img_name';
                   $fieldName = "home_banner_img_name";
                   $Path = 'webroot/upload/admin/home_page_banner/';
                   $home_banner_img_name = $this->ImageUpload($_FILES["home_banner_img_name"]["name"], $home_banner_img_name, $Path, $fieldName);
                   $post['home_banner_img_name'] = $Path.$home_banner_img_name;
                }
				$add_res = $this->common_model->addData('cm_home_banner', $post);
				if($add_res)
				{
					$msg = 'Slider added successfully!';					
					$this->session->set_flashdata('message', '<div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div>');
					redirect(base_url().MODULE_NAME.'slider');
				}
			}
			$this->show_view(MODULE_NAME.'slider/add_home_banner',$this->data);
		}

	}

	public function deleteHomeBanner($home_banner_id = '')
	{
		if($home_banner_id)
		{
			$del_res = 0;
			$res = $this->common_model->getData('cm_home_banner' , array('home_banner_id' => $home_banner_id) , 'single');
			$del_res = $this->common_model->deleteData('cm_home_banner', array('home_banner_id'=>$home_banner_id));
			if(unlink($res->home_banner_img_name))

			if($del_res)
			{
				$msg = 'Home Slider remove successfully...!';	
				$this->session->set_flashdata('message', '<div class="col-xs-12"><div class="alert alert-danger alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div>');
				redirect(base_url().MODULE_NAME.'slider');
			}
		}
	}

}
?>