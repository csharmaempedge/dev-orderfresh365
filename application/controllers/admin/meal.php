<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Meal extends MY_Controller {
	function __construct(){
		parent::__construct();
		if(!empty(MODULE_NAME))
		{
			$this->load->model(MODULE_NAME.'meal_model');
		}
	}
	/* Details */
	public function index(){
		if($this->checkViewPermission()){
			$this->show_view(MODULE_NAME.'meal/meal_view',$this->data);
		}else{	
			redirect(base_url().MODULE_NAME.'dashboard/error/1');
		}
    }
    public function loadMealListData()
    {
    	$customer_list = $this->meal_model->getAllMealList();
    	$data = array();
        $no = $_POST['start'];
        foreach ($customer_list as $c_res) 
	    {
			$no++;
			$row   = array();
			$row[] = $no;
			$row[] = $c_res->protien_serving;
			$row[] = $c_res->carb_serving;
			$row[] = $c_res->veg_serving;
			$row[] = $c_res->price;
			$show_meal_status = '';
            if($c_res->show_meal_status==1)
            {  
                  $show_meal_status  .='<label class="switch">
                        <input type="checkbox"  checked class="switch_on" onchange="showInActiveStatus('.$c_res->meal_id.');">
                        <span class="slider round"></span>
                      </label>';
            }
            else
            {
                $show_meal_status  .='<label class="switch">
                    <input type="checkbox" class="switch_off" onchange="showActiveStatus('.$c_res->meal_id.');">
                    <span class="slider round"></span>
                  </label>';
              
            }
            $row[] = $show_meal_status;
			$meal_status = '';
            if($c_res->meal_status==1)
            {  
                  $meal_status  .='<label class="switch">
                        <input type="checkbox"  checked class="switch_on" onchange="inActiveStatus('.$c_res->meal_id.');">
                        <span class="slider round"></span>
                      </label>';
            }
            else
            {
                $meal_status  .='<label class="switch">
                    <input type="checkbox" class="switch_off" onchange="activeStatus('.$c_res->meal_id.');">
                    <span class="slider round"></span>
                  </label>';
              
            }
            $row[] = $meal_status;
	 		$btn = '';
	 		if($this->checkViewPermission())
	 		{
	 			$btn .= '<a class="btn btn-primary btn-sm" href="'.base_url().''.MODULE_NAME.'meal/mealView/'.$c_res->meal_id.'" title="View"><i class="fa fa-eye fa-1x "></i></a>&nbsp;&nbsp;';
	 		}
	 		if($this->checkEditPermission())
	 		{
	 			$btn .= '<a class="btn btn-success btn-sm" href="'.base_url().''.MODULE_NAME.'meal/addMeal/'.$c_res->meal_id.'" title="Edit"><i class="fa fa-edit fa-1x "></i></a>&nbsp;&nbsp;';
	 		}
	 		if($this->checkDeletePermission())
	 		{
	 			$btn .= '<a class="confirm btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to Delete\')" href="'.base_url().''.MODULE_NAME.'meal/deleteMeal/'.$c_res->meal_id.'" title="Remove"><i class="fa fa-trash-o fa-1x" data-toggle="modal" data-target=".bs-example-modal-sm"></i></a>';
	 		}
	 		$row[] = $btn;
            $data[] = $row;
        }
        $output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => count($customer_list),
			"recordsFiltered" => $this->meal_model->count_filtered(),
			"data" => $data,
		);
       	//output to json format
       	echo json_encode($output);
    }
    /* Add and Update */
	public function addMeal($meal_id = ''){
     	if($meal_id)
		{
			if($this->checkEditPermission())
			{
				if (isset($_POST['Submit']) && $_POST['Submit'] == "Edit") 
				{
					$post['protien_serving'] 	= $this->input->post('protien_serving');
					$post['carb_serving'] 		= $this->input->post('carb_serving');
					$post['veg_serving'] 		= $this->input->post('veg_serving');
					$post['pcv_meal'] 			= $post['protien_serving'].''.$post['carb_serving'].''.$post['veg_serving'];
					$post['price'] 				= $this->input->post('price');
					$post['meal_status'] 		= $this->input->post('meal_status');
					$post['meal_updated_date']  = date('Y-m-d');
					$cat_id = $this->common_model->updateData('tbl_standard_meal',array('meal_id'=>$meal_id),$post);
                    if($cat_id)
                    {                        	
                        $msg = 'Meal Updated successfully!';	
						$this->session->set_flashdata('message', '<section class="content"><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
						redirect(MODULE_NAME.'meal');
					}
				}
				else
				{
					$this->data['meal_edit'] = $this->common_model->getData('tbl_standard_meal',array('meal_id'=>$meal_id), 'single');		
					$this->show_view(MODULE_NAME.'meal/meal_edit', $this->data);
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
					$post['protien_serving'] 	= $this->input->post('protien_serving');
					$post['carb_serving'] 		= $this->input->post('carb_serving');
					$post['veg_serving'] 		= $this->input->post('veg_serving');
					$post['pcv_meal'] 			= $post['protien_serving'].''.$post['carb_serving'].''.$post['veg_serving'];
					$post['price'] 				= $this->input->post('price');
					$post['meal_status'] 		= $this->input->post('meal_status');
					$post['meal_created_date'] 	= date('Y-m-d');
					$post['meal_updated_date']  = date('Y-m-d');
					$post['meal_created_datetime'] 	= date('Y-m-d H:i:s');
					$cat_id = $this->common_model->addData('tbl_standard_meal',$post);
                    if($cat_id){
                        $msg = 'Meal added successfully!';	
						$this->session->set_flashdata('message', '<section class="content"><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
						redirect(MODULE_NAME.'meal');
				  	}else{
					  	$msg = 'Process failed !!';					
						$this->session->set_flashdata('message', '<section class="content"><div class="col-xs-12"><div class="alert alert-danger alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
						redirect(base_url().MODULE_NAME.'meal');
				  	}		
				}
				else
				{
					$this->show_view(MODULE_NAME.'meal/meal_add', $this->data);
				}
			}
			else
			{
				redirect( base_url().MODULE_NAME.'dashboard/error/1');
			}
		}
	}

	public function mealView($meal_id = ''){
		if($meal_id){
			$this->data['meal_edit'] = $this->common_model->getData('tbl_standard_meal',array('meal_id'=>$meal_id), 'single');
			$this->show_view(MODULE_NAME.'meal/meal_full_view',$this->data);
		}
	}

	public function deleteMeal($meal_id = ''){
		$meal_id = $this->uri->segment(4);
    	if(!empty($meal_id)){
    		if($this->checkDeletePermission()){
    			$post['meal_status'] = 2;
    			$post['meal_updated_date']	=	date('Y-m-d');
    			$cate_res = $this->common_model->updateData('tbl_standard_meal' , array('meal_id'=>$meal_id) , $post);
    			if(!empty($cate_res)){
					$msg = 'Meal Removed successfully!!';					
					$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-danger alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
					redirect(base_url().MODULE_NAME.'meal');
				}
    		}
    	}
	}

	public function activeStatus()
    {
        $meal_id = $this->input->post('meal_id');
        
        $post['meal_status'] = '1';
        $this->common_model->updateData('tbl_standard_meal', array('meal_id'=>$meal_id), $post);
        /*$msg = 'successfully Update...!'; 
        echo '<section class="content"><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>';*/           
    }
    
    public function inActiveStatus()
    {
        $meal_id = $this->input->post('meal_id');
        
        $post['meal_status'] = '0';
        $this->common_model->updateData('tbl_standard_meal', array('meal_id'=>$meal_id), $post);
        /*$msg = 'successfully Update...!'; 
        echo '<section class="content"><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>';  */               
       
    }

    public function showActiveStatus()
    {
        $meal_id = $this->input->post('meal_id');
        
        $post['show_meal_status'] = '1';
        $this->common_model->updateData('tbl_standard_meal', array('meal_id'=>$meal_id), $post);
        /*$msg = 'successfully Update...!'; 
        echo '<section class="content"><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>';*/           
    }
    
    public function showInActiveStatus()
    {
        $meal_id = $this->input->post('meal_id');
        
        $post['show_meal_status'] = '0';
        $this->common_model->updateData('tbl_standard_meal', array('meal_id'=>$meal_id), $post);
        /*$msg = 'successfully Update...!'; 
        echo '<section class="content"><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>';  */               
       
    }
}
