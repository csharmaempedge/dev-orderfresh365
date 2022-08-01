<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Macro extends MY_Controller {
	function __construct(){
		parent::__construct();
		if(!empty(MODULE_NAME))
		{
			$this->load->model(MODULE_NAME.'macro_model');
		}
	}
	/* Details */
	public function index(){
		if($this->checkViewPermission()){
			$this->show_view(MODULE_NAME.'macro/macro_view',$this->data);
		}else{	
			redirect(base_url().MODULE_NAME.'dashboard/error/1');
		}
    }
    public function loadMacroListData()
    {
    	$customer_list = $this->macro_model->getAllMacroList();
    	$data = array();
        $no = $_POST['start'];
        foreach ($customer_list as $c_res) 
	    {
			$no++;
			$row   = array();
			$row[] = $no;
			$row[] = $c_res->macro_name;
			$macro_status = '';
            if($c_res->macro_status==1)
            {  
                  $macro_status  .='<label class="switch">
                        <input type="checkbox"  checked class="switch_on" onchange="inActiveStatus('.$c_res->macro_id.');">
                        <span class="slider round"></span>
                      </label>';
            }
            else
            {
                $macro_status  .='<label class="switch">
                    <input type="checkbox" class="switch_off" onchange="activeStatus('.$c_res->macro_id.');">
                    <span class="slider round"></span>
                  </label>';
              
            }
            $row[] = $macro_status;
	 		$btn = '';
	 		if($this->checkViewPermission())
	 		{
	 			$btn .= '<a class="btn btn-primary btn-sm" href="'.base_url().''.MODULE_NAME.'macro/macroView/'.$c_res->macro_id.'" title="View"><i class="fa fa-eye fa-1x "></i></a>&nbsp;&nbsp;';
	 		}
	 		if($this->checkEditPermission())
	 		{
	 			$btn .= '<a class="btn btn-success btn-sm" href="'.base_url().''.MODULE_NAME.'macro/addMacro/'.$c_res->macro_id.'" title="Edit"><i class="fa fa-edit fa-1x "></i></a>&nbsp;&nbsp;';
	 		}
	 		/*if($this->checkDeletePermission())
	 		{
	 			$btn .= '<a class="confirm btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to Delete\')" href="'.base_url().''.MODULE_NAME.'macro/deleteMacro/'.$c_res->macro_id.'" title="Remove"><i class="fa fa-trash-o fa-1x" data-toggle="modal" data-target=".bs-example-modal-sm"></i></a>';
	 		}*/
	 		$row[] = $btn;
            $data[] = $row;
        }
        $output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => count($customer_list),
			"recordsFiltered" => $this->macro_model->count_filtered(),
			"data" => $data,
		);
       	//output to json format
       	echo json_encode($output);
    }
    /* Add and Update */
	public function addMacro($macro_id = ''){
     	if($macro_id)
		{
			if($this->checkEditPermission())
			{
				if (isset($_POST['Submit']) && $_POST['Submit'] == "Edit") 
				{
					$post['macro_name'] 		= trim($this->input->post('macro_name'));
					$post['macro_value_id'] 	= !empty($this->input->post('macro_value_id')) ? implode(',', $this->input->post('macro_value_id')) : '';
					$post['macro_status'] 	= $this->input->post('macro_status');
					$post['macro_created_date'] 			= date('Y-m-d');
					$post['macro_updated_date'] 			= date('Y-m-d');
					$cat_id = $this->common_model->updateData('tbl_macro',array('macro_id'=>$macro_id),$post);
                    if($cat_id)
                    {                        	
                        $msg = 'Macro Updated successfully!';	
						$this->session->set_flashdata('message', '<section class="content"><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
						redirect(MODULE_NAME.'macro');
					}
				}
				else
				{
					$this->data['macro_edit'] = $this->common_model->getData('tbl_macro',array('macro_id'=>$macro_id), 'single');		
					$this->show_view(MODULE_NAME.'macro/macro_edit', $this->data);
				}
			}
			else
			{
				redirect(base_url().MODULE_NAME.'dashboard/error/1');
			}
		}
		else
		{
			if($this->checkAddPermission())
			{
				if (isset($_POST['Submit']) && $_POST['Submit'] == "Add")
				{
					$post['macro_name'] 		= trim($this->input->post('macro_name'));
					$post['macro_value_id'] 	= !empty($this->input->post('macro_value_id')) ? implode(',', $this->input->post('macro_value_id')) : '';
					$post['macro_status'] 		= $this->input->post('macro_status');
					$post['macro_created_date']  	= date('Y-m-d');
					$post['macro_updated_date']  	= date('Y-m-d');
					$post['macro_created_datetime'] 	= date('Y-m-d H:i:s');
					$cat_id = $this->common_model->addData('tbl_macro',$post);
                    if($cat_id){
                        $msg = 'Macro added successfully!';	
						$this->session->set_flashdata('message', '<section class="content"><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
						redirect(MODULE_NAME.'macro');
				  	}else{
					  	$msg = 'Process failed !!';					
						$this->session->set_flashdata('message', '<section class="content"><div class="col-xs-12"><div class="alert alert-danger alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
						redirect(base_url().MODULE_NAME.'macro');
				  	}		
				}
				else
				{
					$this->show_view(MODULE_NAME.'macro/macro_add', $this->data);
				}
			}
			else
			{
				redirect( base_url().MODULE_NAME.'dashboard/error/1');
			}
		}
	}

	public function macroView($macro_id = ''){
		if($macro_id){
			$this->data['macro_edit'] = $this->common_model->getData('tbl_macro',array('macro_id'=>$macro_id), 'single');
			$this->show_view(MODULE_NAME.'macro/macro_full_view',$this->data);
		}
	}

	public function deleteMacro($macro_id = ''){
		$macro_id = $this->uri->segment(4);
    	if(!empty($macro_id)){
    		if($this->checkDeletePermission()){
    			$post['macro_status'] = 2;
    			$post['macro_updated_date']	=	date('Y-m-d');
    			$cate_res = $this->common_model->updateData('tbl_macro' , array('macro_id'=>$macro_id) , $post);
    			if(!empty($cate_res)){
					$msg = 'Macro Removed successfully!!';					
					$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-danger alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
					redirect(base_url().MODULE_NAME.'macro');
				}
    		}
    	}
	}

	public function activeStatus()
    {
        $macro_id = $this->input->post('macro_id');
        
        $post['macro_status'] = '1';
        $this->common_model->updateData('tbl_macro', array('macro_id'=>$macro_id), $post);
        /*$msg = 'successfully Update...!'; 
        echo '<section class="content"><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>';*/           
    }
    
    public function inActiveStatus()
    {
        $macro_id = $this->input->post('macro_id');
        
        $post['macro_status'] = '0';
        $this->common_model->updateData('tbl_macro', array('macro_id'=>$macro_id), $post);
        /*$msg = 'successfully Update...!'; 
        echo '<section class="content"><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>';  */               
       
    }
}
