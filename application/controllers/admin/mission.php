<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mission extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		if(!empty(MODULE_NAME))
		{
			$this->load->model(MODULE_NAME.'mission_model');
		}
	}

	public function index()
	{
		if($this->checkViewPermission())
		{			
			$this->show_view(MODULE_NAME.'mission/mission_view', $this->data);
		}
		else
		{	
			redirect( base_url().MODULE_NAME.'dashboard/error/1');
		}
    }

    public function loadMissionListData()
    {
    	$c_date = date(('Y-m-d'));
    	$mission_list = $this->mission_model->getAllMissionList();
    	$data = array();
        $no = $_POST['start'];
        foreach ($mission_list as $res) 
	    {
			$no++;
			$row   = array();
			$row[] = $no;
			$row[] = '<a data-toggle="modal" data-target="#myModal" href="javascript:void(0)"><img width="50px"  onclick ="getFullSizePic(this.src)" src="'.base_url().''.$res->mission_img.'"></a>';
			$row[] = $res->mission_title;
			$mission_status = '';
            if($res->mission_status==1)
            {  
                  $mission_status  .='<label class="switch">
                        <input type="checkbox"  checked class="switch_on" onchange="inActiveStatus('.$res->mission_id.');">
                        <span class="slider round"></span>
                      </label>';
            }
            else
            {
                $mission_status  .='<label class="switch">
                    <input type="checkbox" class="switch_off" onchange="activeStatus('.$res->mission_id.');">
                    <span class="slider round"></span>
                  </label>';
              
            }
            $row[] = $mission_status;

	 		$btn = '';
	 		if($this->checkViewPermission())
	 		{
	 			$btn .= '<a class="btn btn-warning btn-sm" href="'.base_url().MODULE_NAME.'mission/missionFullView/'.$res->mission_id.'" title="Mission Full view"><i class="fa fa-eye fa-1x "></i></a>&nbsp;&nbsp;';

	 			$btn .= '<a class="btn btn-info btn-sm" href="'.base_url().MODULE_NAME.'mission/addMission/'.$res->mission_id.'" title="Edit"><i class="fa fa-edit fa-1x "></i></a>&nbsp;&nbsp;';
	 		}
	 		if($this->checkDeletePermission())
	 		{
	 			$btn .= '<a class="confirm btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to Delete\')" href="'.base_url().''.MODULE_NAME.'mission/delete_mission/'.$res->mission_id.'" title="Remove"><i class="fa fa-trash-o fa-1x" data-toggle="modal" data-target=".bs-example-modal-sm"></i></a>';
	 		}
	 		$row[] = $btn;
            $data[] = $row;
        }

        $output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => count($mission_list),
			"recordsFiltered" => $this->mission_model->count_missionfiltered(),
			"data" => $data,
		);
       	//output to json format
       	echo json_encode($output);
    }

    public function activeStatus()
    {
        $mission_id = $this->input->post('mission_id');
        
        $post['mission_status'] = '1';
        $this->common_model->updateData('cm_mission', array('mission_id'=>$mission_id), $post);           
    }
    
    public function inActiveStatus()
    {
        $mission_id = $this->input->post('mission_id');
        
        $post['mission_status'] = '0';
        $this->common_model->updateData('cm_mission', array('mission_id'=>$mission_id), $post);               
    }
    /* Add & update */
    public function addMission()
    {
    	$mission_id = $this->uri->segment(4);
		if($mission_id)
		{
			if($this->checkEditPermission())
			{
				if (isset($_POST['Submit']) && $_POST['Submit'] == "Edit") 
				{
					$post['mission_title'] 				= $this->input->post('mission_title');
					$post['mission_small_description'] 	= $this->input->post('mission_small_description');
					$post['mission_long_description'] 	= $this->input->post('mission_long_description');
					$post['mission_status'] 				= $this->input->post('mission_status');
					$post['mission_created_by'] 			= $this->data['session']->user_id;
					if($_FILES["mission_img"]["name"]){
                       $mission_img = 'mission_img';
                       $fieldName = "mission_img";
                       $Path = 'webroot/upload/admin/mission/';
                       $mission_img = $this->ImageUpload($_FILES["mission_img"]["name"], $mission_img, $Path, $fieldName);
                       $post['mission_img'] = $Path.'/'.$mission_img;
                   	}
					$post['mission_updated_date']	 		= date('Y-m-d');
					$n_post = $this->xssCleanValidate($post);
                   	$this->common_model->updateData('cm_mission', array('mission_id'=>$mission_id), $n_post);
 
                   	$msg = 'Mission Updated Successfully!!';					
					$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
					redirect(base_url().MODULE_NAME.'mission');
				}
				else
				{
					$this->data['mission_res'] = $this->common_model->getData('cm_mission', array('mission_id'=>$mission_id), 'single');
					if(!empty($this->data['mission_res']))
					{
						$this->show_view(MODULE_NAME.'mission/mission_update', $this->data);
					}
					else
					{
						redirect(base_url().MODULE_NAME.'mission');
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
					$post['mission_title'] 				= $this->input->post('mission_title');
					$post['mission_small_description'] 	= $this->input->post('mission_small_description');
					$post['mission_long_description'] 	= $this->input->post('mission_long_description');
					$post['mission_status'] 				= $this->input->post('mission_status');
					$post['mission_created_by'] 			= $this->data['session']->user_id;
					if($_FILES["mission_img"]["name"]){
                       $mission_img = 'mission_img';
                       $fieldName = "mission_img";
                       $Path = 'webroot/upload/admin/mission/';
                       $mission_img = $this->ImageUpload($_FILES["mission_img"]["name"], $mission_img, $Path, $fieldName);
                       $post['mission_img'] = $Path.'/'.$mission_img;
                   	}
                   	else
                   	{
                   		$post['mission_img'] = 'webroot/placeholder.png';	
                   	}
					$post['mission_created_date'] 		= date('Y-m-d');
					$post['mission_updated_date']	 		= date('Y-m-d');
					$n_post = $this->xssCleanValidate($post);
					$mission_id = $this->common_model->addData('cm_mission', $n_post);
			
                   	$msg = 'Mission Added Successfully!!';					
					$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
					redirect(base_url().MODULE_NAME.'mission');
				}
				else
				{
					$this->show_view(MODULE_NAME.'mission/mission_add', $this->data);
				}
			}
			else
			{	
				redirect( base_url().MODULE_NAME.'dashboard/error/1');
			}
		}
    }

    public function missionFullView(){		
		if($this->checkViewPermission()){
			$mission_id = $this->uri->segment(4);
			$this->data['mission_res'] = $this->common_model->getData('cm_mission', array('mission_id'=>$mission_id), 'single');
			if(!empty($this->data['mission_res'])){
				$this->show_view(MODULE_NAME.'mission/mission_full_view', $this->data);
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
	public function delete_mission()
	{
		if($this->checkDeletePermission())
		{	
			$mission_id 	= $this->uri->segment(4);	
			$this->common_model->deleteData('cm_mission' ,array('mission_id'=>$mission_id));
				
			$msg = 'Mission remove successfully...!';					
			$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-danger alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
			 redirect(base_url().MODULE_NAME.'mission');
		}
		else
		{
			redirect( base_url().MODULE_NAME.'dashboard/error/1');
		}
	}

}

/* End of file */?>