<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Vision extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		if(!empty(MODULE_NAME))
		{
			$this->load->model(MODULE_NAME.'vision_model');
		}
	}

	public function index()
	{
		if($this->checkViewPermission())
		{			
			$this->show_view(MODULE_NAME.'vision/vision_view', $this->data);
		}
		else
		{	
			redirect( base_url().MODULE_NAME.'dashboard/error/1');
		}
    }

    public function loadVisionListData()
    {
    	$c_date = date(('Y-m-d'));
    	$vision_list = $this->vision_model->getAllVisionList();
    	$data = array();
        $no = $_POST['start'];
        foreach ($vision_list as $res) 
	    {
			$no++;
			$row   = array();
			$row[] = $no;
			$row[] = '<a data-toggle="modal" data-target="#myModal" href="javascript:void(0)"><img width="50px"  onclick ="getFullSizePic(this.src)" src="'.base_url().''.$res->vision_img.'"></a>';
			$row[] = $res->vision_title;
			$vision_status = '';
            if($res->vision_status==1)
            {  
                  $vision_status  .='<label class="switch">
                        <input type="checkbox"  checked class="switch_on" onchange="inActiveStatus('.$res->vision_id.');">
                        <span class="slider round"></span>
                      </label>';
            }
            else
            {
                $vision_status  .='<label class="switch">
                    <input type="checkbox" class="switch_off" onchange="activeStatus('.$res->vision_id.');">
                    <span class="slider round"></span>
                  </label>';
              
            }
            $row[] = $vision_status;

	 		$btn = '';
	 		if($this->checkViewPermission())
	 		{
	 			$btn .= '<a class="btn btn-warning btn-sm" href="'.base_url().MODULE_NAME.'vision/visionFullView/'.$res->vision_id.'" title="Vision Full view"><i class="fa fa-eye fa-1x "></i></a>&nbsp;&nbsp;';

	 			$btn .= '<a class="btn btn-info btn-sm" href="'.base_url().MODULE_NAME.'vision/addVision/'.$res->vision_id.'" title="Edit"><i class="fa fa-edit fa-1x "></i></a>&nbsp;&nbsp;';
	 		}
	 		if($this->checkDeletePermission())
	 		{
	 			$btn .= '<a class="confirm btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to Delete\')" href="'.base_url().''.MODULE_NAME.'vision/delete_vision/'.$res->vision_id.'" title="Remove"><i class="fa fa-trash-o fa-1x" data-toggle="modal" data-target=".bs-example-modal-sm"></i></a>';
	 		}
	 		$row[] = $btn;
            $data[] = $row;
        }

        $output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => count($vision_list),
			"recordsFiltered" => $this->vision_model->count_visionfiltered(),
			"data" => $data,
		);
       	//output to json format
       	echo json_encode($output);
    }

    public function activeStatus()
    {
        $vision_id = $this->input->post('vision_id');
        
        $post['vision_status'] = '1';
        $this->common_model->updateData('cm_vision', array('vision_id'=>$vision_id), $post);           
    }
    
    public function inActiveStatus()
    {
        $vision_id = $this->input->post('vision_id');
        
        $post['vision_status'] = '0';
        $this->common_model->updateData('cm_vision', array('vision_id'=>$vision_id), $post);               
    }

    /* Add & update */
    public function addVision()
    {
    	$vision_id = $this->uri->segment(4);
		if($vision_id)
		{
			if($this->checkEditPermission())
			{
				if (isset($_POST['Submit']) && $_POST['Submit'] == "Edit") 
				{
					$post['vision_title'] 				= $this->input->post('vision_title');
					$post['vision_small_description'] 	= $this->input->post('vision_small_description');
					$post['vision_long_description'] 	= $this->input->post('vision_long_description');
					$post['vision_status'] 				= $this->input->post('vision_status');
					$post['vision_created_by'] 			= $this->data['session']->user_id;
					if($_FILES["vision_img"]["name"]){
                       $vision_img = 'vision_img';
                       $fieldName = "vision_img";
                       $Path = 'webroot/upload/admin/vision/';
                       $vision_img = $this->ImageUpload($_FILES["vision_img"]["name"], $vision_img, $Path, $fieldName);
                       $post['vision_img'] = $Path.'/'.$vision_img;
                   	}
					$post['vision_updated_date']	 		= date('Y-m-d');
					$n_post = $this->xssCleanValidate($post);
                   	$this->common_model->updateData('cm_vision', array('vision_id'=>$vision_id), $n_post);
 
                   	$msg = 'Vision Updated Successfully!!';					
					$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
					redirect(base_url().MODULE_NAME.'vision');
				}
				else
				{
					$this->data['vision_res'] = $this->common_model->getData('cm_vision', array('vision_id'=>$vision_id), 'single');
					if(!empty($this->data['vision_res']))
					{
						$this->show_view(MODULE_NAME.'vision/vision_update', $this->data);
					}
					else
					{
						redirect(base_url().MODULE_NAME.'vision');
					}
				}
			}
			else
			{	
				redirect( base_url().MODULE_NAME.'dashboard/error/1');
			}
		}
		else
		{
			if($this->checkAddPermission())
			{
				if (isset($_POST['Submit']) && $_POST['Submit'] == "Add") 
				{
					$post['vision_title'] 				= $this->input->post('vision_title');
					$post['vision_small_description'] 	= $this->input->post('vision_small_description');
					$post['vision_long_description'] 	= $this->input->post('vision_long_description');
					$post['vision_status'] 				= $this->input->post('vision_status');
					$post['vision_created_by'] 			= $this->data['session']->user_id;
					if($_FILES["vision_img"]["name"]){
                       $vision_img = 'vision_img';
                       $fieldName = "vision_img";
                       $Path = 'webroot/upload/admin/vision/';
                       $vision_img = $this->ImageUpload($_FILES["vision_img"]["name"], $vision_img, $Path, $fieldName);
                       $post['vision_img'] = $Path.'/'.$vision_img;
                   	}
                   	else
                   	{
                   		$post['vision_img'] = 'webroot/placeholder.png';	
                   	}
					$post['vision_created_date'] 		= date('Y-m-d');
					$post['vision_updated_date']	 		= date('Y-m-d');
					$n_post = $this->xssCleanValidate($post);
					$vision_id = $this->common_model->addData('cm_vision', $n_post);
			
                   	$msg = 'Vision Added Successfully!!';					
					$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
					redirect(base_url().MODULE_NAME.'vision');
				}
				else
				{
					$this->show_view(MODULE_NAME.'vision/vision_add', $this->data);
				}
			}
			else
			{	
				redirect( base_url().MODULE_NAME.'dashboard/error/1');
			}
		}
    }

    public function visionFullView(){		
		if($this->checkViewPermission()){
			$vision_id = $this->uri->segment(4);
			$this->data['vision_res'] = $this->common_model->getData('cm_vision', array('vision_id'=>$vision_id), 'single');
			if(!empty($this->data['vision_res'])){
				$this->show_view(MODULE_NAME.'vision/vision_full_view', $this->data);
			}
			else{
				redirect(base_url().MODULE_NAME.'alert');
			}
		}
		else{
			redirect( base_url().'admin/dashboard/error/1' );
		}
    }

	/* Delete */
	public function delete_vision()
	{
		if($this->checkDeletePermission())
		{	
			$vision_id 	= $this->uri->segment(4);	
			$this->common_model->deleteData('cm_vision' ,array('vision_id'=>$vision_id));
				
			$msg = 'Vision remove successfully...!';					
			$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-danger alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
			 redirect(base_url().MODULE_NAME.'vision');
		}
		else
		{
			redirect( base_url().MODULE_NAME.'dashboard/error/1');
		}
	}

}

/* End of file */?>