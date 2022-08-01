<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Delivery extends MY_Controller {
	function __construct(){
		parent::__construct();
		if(!empty(MODULE_NAME))
		{
			$this->load->model(MODULE_NAME.'delivery_model');
		}
	}
	/*	Validation Rules */
	protected $validation_rules = array(
        'userAdd' => array(
			array(
                'field' => 'delivery_person_name',
                'label' => 'Delivery Person NAme',
                'rules' => 'trim|required'
            )
        )
    );
	/* Details */
	public function index(){
		if($this->checkViewPermission()){
			$this->show_view(MODULE_NAME.'delivery/delivery_view',$this->data);
		}else{	
			redirect(base_url().MODULE_NAME.'dashboard/error/1');
		}
    }
    public function loadDeliveryListData()
    {
    	$customer_list = $this->delivery_model->getAllDeliveryList();
    	$data = array();
        $no = $_POST['start'];
        foreach ($customer_list as $c_res) 
	    {
			$no++;
			$row   = array();
			$row[] = $no;
			$row[] = $c_res->delivery_person_name;
			$row[] = $c_res->delivery_person_address;
			$delivery_person_status = '';
            if($c_res->delivery_person_status==1)
            {  
                  $delivery_person_status  .='<label class="switch">
                        <input type="checkbox"  checked class="switch_on" onchange="inActiveStatus('.$c_res->delivery_person_id.');">
                        <span class="slider round"></span>
                      </label>';
            }
            else
            {
                $delivery_person_status  .='<label class="switch">
                    <input type="checkbox" class="switch_off" onchange="activeStatus('.$c_res->delivery_person_id.');">
                    <span class="slider round"></span>
                  </label>';
              
            }
            $row[] = $delivery_person_status;
            $btn1 = '';
	 		if($this->checkAddPermission()){
	 			$btn1 .= '<a class="btn btn-success btn-sm" href="'.base_url().''.MODULE_NAME.'delivery/assignDelivery/'.$c_res->delivery_person_id.'" title="Assign Delivery Route"><i class="fa fa-plus fa-1x "></i></a>&nbsp;&nbsp;';
	 		}
	 		$row[] = $btn1;
	 		$btn = '';
	 		if($this->checkViewPermission())
	 		{
	 			$btn .= '<a class="btn btn-primary btn-sm" href="'.base_url().''.MODULE_NAME.'delivery/deliveryView/'.$c_res->delivery_person_id.'" title="View"><i class="fa fa-eye fa-1x "></i></a>&nbsp;&nbsp;';
	 		}
	 		if($this->checkEditPermission())
	 		{
	 			$btn .= '<a class="btn btn-success btn-sm" href="'.base_url().''.MODULE_NAME.'delivery/addDelivery/'.$c_res->delivery_person_id.'" title="Edit"><i class="fa fa-edit fa-1x "></i></a>&nbsp;&nbsp;';
	 		}
	 		/*if($this->checkDeletePermission())
	 		{
	 			$btn .= '<a class="confirm btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to Delete\')" href="'.base_url().''.MODULE_NAME.'delivery/deleteDelivery/'.$c_res->delivery_person_id.'" title="Remove"><i class="fa fa-trash-o fa-1x" data-toggle="modal" data-target=".bs-example-modal-sm"></i></a>';
	 		}*/
	 		$row[] = $btn;
            $data[] = $row;
        }
        $output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => count($customer_list),
			"recordsFiltered" => $this->delivery_model->count_filtered(),
			"data" => $data,
		);
       	//output to json format
       	echo json_encode($output);
    }

    public function assignDelivery(){
		if($this->checkViewPermission()){			
			$delivery_person_id = $this->uri->segment(4);
			if (isset($_POST['Submit']) && $_POST['Submit'] == "Edit") 
			{
				if(!empty($delivery_person_id))
               	{
               		$delivery_person_res = $this->common_model->getData('tbl_delivery_person',array('delivery_person_id'=>$delivery_person_id), 'single');
               		if($delivery_person_res->delivery_person_status == 1)
               		{
						$address_route  	= $this->input->post('address_route');
						$post_mc['address_route']  							= $address_route;
	       				$post_mc['delivery_person_id']  					= $delivery_person_id;
	       				$post_mc['delivery_person_assign_status'] 			= '1';
	       				$post_mc['delivery_person_assign_created_date'] 	= date('Y-m-d');
						$nmc_post = $this->xssCleanValidate($post_mc);
						$this->common_model->addData('tbl_delivery_person_assign', $nmc_post);
               		}
               		else
               		{
               			$msg = 'Inactive Delivery Person !!';					
						$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-danger alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
						redirect(base_url().MODULE_NAME.'delivery');
               		}
               	}
               	$msg = 'Assign Delivery successfully!!';					
				$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
				redirect(base_url().MODULE_NAME.'delivery/assignDelivery/'.$delivery_person_id);
			}
			else
			{
				$this->data['delivery_person_id'] = $delivery_person_id;
				$this->show_view(MODULE_NAME.'delivery/assign_delivery', $this->data);
			}
		}
		else{	
			redirect( base_url().MODULE_NAME.'dashboard/error/1');
		}
	}

	
    /* Add and Update */
	public function addDelivery($delivery_person_id = ''){
     	if($delivery_person_id)
		{
			if($this->checkEditPermission())
			{
				if (isset($_POST['Submit']) && $_POST['Submit'] == "Edit") 
				{
					$post['delivery_person_name'] = $this->input->post('delivery_person_name');
						$post['delivery_person_address'] = $this->input->post('delivery_person_address');
					$post['delivery_person_status'] 		= $this->input->post('delivery_person_status');
					$post['delivery_person_updated_date']  	= date('Y-m-d');
					$cat_id = $this->common_model->updateData('tbl_delivery_person',array('delivery_person_id'=>$delivery_person_id),$post);
                    if($cat_id)
                    {                        	
                        $msg = 'Delivery Updated successfully!';	
						$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
						redirect(MODULE_NAME.'delivery');
					}
				}
				else
				{
					$this->data['delivery_person_edit'] = $this->common_model->getData('tbl_delivery_person',array('delivery_person_id'=>$delivery_person_id), 'single');		
					$this->show_view(MODULE_NAME.'delivery/delivery_edit', $this->data);
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
					$this->form_validation->set_rules($this->validation_rules['userAdd']);
					if($this->form_validation->run())
					{
						$post['delivery_person_name'] = $this->input->post('delivery_person_name');
						$post['delivery_person_address'] = $this->input->post('delivery_person_address');
						$post['delivery_person_status'] = $this->input->post('delivery_person_status');
						$post['delivery_person_created_date']  	= date('Y-m-d');
						$post['delivery_person_updated_date']  	= date('Y-m-d');
						$cat_id = $this->common_model->addData('tbl_delivery_person',$post);
	                    if($cat_id){
	                        $msg = 'Delivery added successfully!';	
							$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
							redirect(MODULE_NAME.'delivery');
					  	}else{
						  	$msg = 'Process failed !!';					
							$this->session->set_flashdata('message', '<section class="content"><div class="col-xs-12"><div class="alert alert-danger alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
							redirect(base_url().MODULE_NAME.'delivery');
					  	}	
					}
					else
					{
						$this->show_view(MODULE_NAME.'delivery/delivery_add', $this->data);
					}	
				}
				else
				{
					$this->show_view(MODULE_NAME.'delivery/delivery_add', $this->data);
				}
			}
			else
			{
				redirect( base_url().MODULE_NAME.'dashboard/error/1');
			}
		}
	}

	public function deliveryView($delivery_person_id = ''){
		if($delivery_person_id){
			$this->data['delivery_person_edit'] = $this->common_model->getData('tbl_delivery_person',array('delivery_person_id'=>$delivery_person_id), 'single');
			$this->show_view(MODULE_NAME.'delivery/delivery_full_view',$this->data);
		}
	}

	public function deleteDelivery($delivery_person_id = ''){
		$delivery_person_id = $this->uri->segment(4);
    	if(!empty($delivery_person_id)){
    		if($this->checkDeletePermission()){
    			$post['delivery_person_status'] = 2;
    			$post['delivery_person_updated_date']	=	date('Y-m-d');
    			$cate_res = $this->common_model->updateData('tbl_delivery_person' , array('delivery_person_id'=>$delivery_person_id) , $post);
    			if(!empty($cate_res)){
					$msg = 'Delivery Removed successfully!!';					
					$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-danger alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
					redirect(base_url().MODULE_NAME.'delivery');
				}
    		}
    	}
	}

	public function activeStatus()
    {
        $delivery_person_id = $this->input->post('delivery_person_id');
        
        $post['delivery_person_status'] = '1';
        $this->common_model->updateData('tbl_delivery_person', array('delivery_person_id'=>$delivery_person_id), $post);

        $post_u['delivery_person_assign_status'] = '1';
        $this->common_model->updateData('tbl_delivery_person_assign', array('delivery_person_id'=>$delivery_person_id), $post_u);           
    }
    
    public function inActiveStatus()
    {
        $delivery_person_id = $this->input->post('delivery_person_id');
        
        $post['delivery_person_status'] = '0';
        $this->common_model->updateData('tbl_delivery_person', array('delivery_person_id'=>$delivery_person_id), $post);

        /*$post_u['delivery_person_assign_status'] = '0';
        $this->common_model->updateData('tbl_delivery_person_assign', array('delivery_person_id'=>$delivery_person_id), $post_u);*/              
        $this->common_model->deleteData('tbl_delivery_person_assign', array('delivery_person_id'=>$delivery_person_id));             
       
    }

    public function removeDeliveryPerson(){
        $delivery_person_assign_id = $this->input->post('delivery_person_assign_id'); 
        echo $del_res = $this->common_model->deleteData('tbl_delivery_person_assign', array('delivery_person_assign_id'=>$delivery_person_assign_id));      
    }
}
