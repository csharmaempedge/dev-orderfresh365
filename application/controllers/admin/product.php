<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ob_start();
class Product extends MY_Controller {
	function __construct(){
		parent::__construct();
		if(!empty(MODULE_NAME))
		{
			$this->load->model(MODULE_NAME.'product_model');
		}
	}
	/* Details */
	public function index(){
		if($this->checkViewPermission()){
			$this->show_view(MODULE_NAME.'product/product_view',$this->data);
		}else{	
			redirect(base_url().MODULE_NAME.'dashboard/error/1');
		}
    }
    public function loadProductListData()
    {
    	$customer_list = $this->product_model->getAllProductList();
    	$data = array();
        $no = $_POST['start'];
        foreach ($customer_list as $c_res) 
	    {
	    	$category_res = $this->common_model->getData('tbl_category', array('category_id'=>$c_res->category_id), 'single');
	    	$check_product_label = $this->common_model->getData(' tbl_product_label_price', array('product_id'=>$c_res->product_id), 'single');
			$no++;
			$row   = array();
			$row[] = $no;
			$row[] = $c_res->product_name;
			$row[] = (!empty($category_res->category_name)) ? $category_res->category_name : '';
			$product_status = '';
            if($c_res->product_status==1)
            {  
                  $product_status  .='<label class="switch">
                        <input type="checkbox"  checked class="switch_on" onchange="inActiveStatus('.$c_res->product_id.');">
                        <span class="slider round"></span>
                      </label>';
            }
            else
            {
                $product_status  .='<label class="switch">
                    <input type="checkbox" class="switch_off" onchange="activeStatus('.$c_res->product_id.');">
                    <span class="slider round"></span>
                  </label>';
              
            }
            $row[] = $product_status;
            $btn1 = '';
	 		if($this->checkAddPermission()){
	 			if(empty($check_product_label))
	 			{
	 				$btn1 .= '<a class="btn btn-success btn-sm" href="'.base_url().''.MODULE_NAME.'product/productCreateLabel/'.$c_res->product_id.'" title="Create Product Label"><i class="fa fa-plus fa-1x "></i></a>&nbsp;&nbsp;';
	 			}
	 			else
	 			{
	 				$btn1 .= '<a class="btn btn-info btn-sm" href="'.base_url().''.MODULE_NAME.'product/productCreateLabel/'.$c_res->product_id.'" title="Update Product Label"><i class="fa fa-edit fa-1x "></i></a>&nbsp;&nbsp;';
	 			}
	 		}
	 		$row[] = $btn1;
	 		$btn = '';
	 		if($this->checkViewPermission())
	 		{
	 			$btn .= '<a class="btn btn-primary btn-sm" href="'.base_url().''.MODULE_NAME.'product/productView/'.$c_res->product_id.'" title="View"><i class="fa fa-eye fa-1x "></i></a>&nbsp;&nbsp;';
	 		}
	 		if($this->checkEditPermission())
	 		{
	 			$btn .= '<a class="btn btn-success btn-sm" href="'.base_url().''.MODULE_NAME.'product/addProduct/'.$c_res->product_id.'" title="Edit"><i class="fa fa-edit fa-1x "></i></a>&nbsp;&nbsp;';
	 		}
	 		if($c_res->category_id =='1')
	 		{
		 		if($this->checkEditPermission())
		 		{
		 			$btn .=   '<a class="btn btn-warning btn-sm" href="'.base_url().''.MODULE_NAME.'category/AssignProduct/'.$c_res->product_id.'/'.$c_res->category_id.'/product'.'" title="Assign Veggies & Carb"><i class="fa fa-plus fa-1x "></i></a>&nbsp;&nbsp;';
		 		}
	 			
	 		}
	 		if($this->checkDeletePermission())
	 		{
	 			$btn .= '<a class="confirm btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to Delete\')" href="'.base_url().''.MODULE_NAME.'product/deleteProduct/'.$c_res->product_id.'" title="Remove"><i class="fa fa-trash-o fa-1x" data-toggle="modal" data-target=".bs-example-modal-sm"></i></a>';
	 		}
	 		$row[] = $btn;
            $data[] = $row;
        }
        $output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => count($customer_list),
			"recordsFiltered" => $this->product_model->count_filtered(),
			"data" => $data,
		);
       	//output to json format
       	echo json_encode($output);
    }

    public function productCreateLabel(){
		if($this->checkViewPermission()){			
			$product_id = $this->uri->segment(4);
			if (isset($_POST['Submit']) && $_POST['Submit'] == "Edit") 
			{
				if(!empty($product_id))
               	{

               		$label_res = $this->common_model->getData('tbl_label',NULL, 'multi');
               		if(!empty($label_res))
               		{
               			foreach ($label_res as $res) 
               			{
               				$post_mc['label_id']  	= $this->input->post('label_id_'.$res->label_id);
               				$post_mc['label_amount'] = $this->input->post('label_amount_'.$res->label_id);
               				$post_mc['product_id']  = $product_id;
               				$post_mc['label_price_created_date'] 	= date('Y-m-d');
               				$post_mc['label_price_updated_date'] 	= date('Y-m-d');
							$nmc_post = $this->xssCleanValidate($post_mc);
							$label_product_res = $this->common_model->getData('tbl_product_label_price', array('label_id'=>$res->label_id, 'product_id'=>$product_id), 'single');
							if(!empty($label_product_res))
							{
								$this->common_model->updateData('tbl_product_label_price',array('label_id'=>$res->label_id, 'product_id'=>$product_id),  $nmc_post);
							}
							else
							{
								$this->common_model->addData('tbl_product_label_price', $nmc_post);

							}
               			}
               		}                
               	}
               	$msg = 'Product Label Created successfully!!';					
				$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
				redirect(base_url().MODULE_NAME.'product');
			}
			else
			{
				$this->data['product_id'] = $product_id;
				$this->show_view(MODULE_NAME.'product/create_product_label', $this->data);
			}
		}
		else{	
			redirect( base_url().MODULE_NAME.'dashboard/error/1');
		}
	}
    /* Add and Update */
	public function addProduct($product_id = ''){
     	if($product_id)
		{
			if($this->checkEditPermission())
			{
				if (isset($_POST['Submit']) && $_POST['Submit'] == "Edit") 
				{
					$post['product_name'] 		= $this->input->post('product_name');
					$post['product_label_print_name'] = $this->input->post('product_label_print_name');
					$post['product_status'] 	= $this->input->post('product_status');
					$post['category_id'] 		= $this->input->post('category_id');
					if($post['category_id'] == '4')
					{
						$post['breakfast_type'] 		= $this->input->post('breakfast_type');

					}
					else
					{
						$post['breakfast_type'] = '';
					}
					$post['product_plus_percentage'] 	= $this->input->post('product_plus_percentage');
					$post['product_row_amount'] 	= $this->input->post('product_row_amount');
					$post['product_price'] 	= $this->input->post('product_price');
					$post['no_of_portions'] 	= $this->input->post('no_of_portions');
					$post['product_created_date'] 			= date('Y-m-d');
					$post['product_updated_date'] 			= date('Y-m-d');
					$this->common_model->updateData('tbl_product',array('product_id'=>$product_id),$post);
                    $msg = 'Product Updated successfully!';	
					$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
					redirect(MODULE_NAME.'product');
				}
				else
				{
					$this->data['product_edit'] = $this->common_model->getData('tbl_product',array('product_id'=>$product_id), 'single');		
					$this->show_view(MODULE_NAME.'product/product_edit', $this->data);
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
					$post['product_name'] = $this->input->post('product_name');
					$post['product_label_print_name'] = $this->input->post('product_label_print_name');
					$post['category_id'] 				= $this->input->post('category_id');
					if($post['category_id'] == '4')
					{
						$post['breakfast_type'] 		= $this->input->post('breakfast_type');

					}
					else
					{
						$post['breakfast_type'] = '';
					}
					$post['product_price'] 				= $this->input->post('product_price');
					$post['product_plus_percentage'] 	= $this->input->post('product_plus_percentage');
					$post['no_of_portions'] 	= $this->input->post('no_of_portions');
					$post['product_row_amount'] 		= $this->input->post('product_row_amount');
					$post['product_status'] 			= $this->input->post('product_status');
					$post['product_created_date']  		= date('Y-m-d');
					$post['product_updated_date']  		= date('Y-m-d');
					$post['product_created_datetime'] 	= date('Y-m-d H:i:s');
					$cat_id = $this->common_model->addData('tbl_product',$post);
                    if($cat_id){
                        $msg = 'Product added successfully!';	
						$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
						redirect(MODULE_NAME.'product');
				  	}else{
					  	$msg = 'Process failed !!';					
						$this->session->set_flashdata('message', '<section class="content"><div class="col-xs-12"><div class="alert alert-danger alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
						redirect(base_url().MODULE_NAME.'product');
				  	}		
				}
				else
				{
					$this->show_view(MODULE_NAME.'product/product_add', $this->data);
				}
			}
			else
			{
				redirect( base_url().MODULE_NAME.'dashboard/error/1');
			}
		}
	}

	public function productView($product_id = ''){
		if($product_id){
			$this->data['product_edit'] = $this->common_model->getData('tbl_product',array('product_id'=>$product_id), 'single');
			$this->show_view(MODULE_NAME.'product/product_full_view',$this->data);
		}
	}

	public function deleteProduct($product_id = ''){
		$product_id = $this->uri->segment(4);
    	if(!empty($product_id)){
    		if($this->checkDeletePermission()){
    			$post['product_status'] = 2;
    			$post['product_updated_date']	=	date('Y-m-d');
    			$cate_res = $this->common_model->updateData('tbl_product' , array('product_id'=>$product_id) , $post);
    			if(!empty($cate_res)){
					$msg = 'Product Removed successfully!!';					
					$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-danger alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
					redirect(base_url().MODULE_NAME.'product');
				}
    		}
    	}
	}

	public function activeStatus()
    {
        $product_id = $this->input->post('product_id');
        
        $post['product_status'] = '1';
        $this->common_model->updateData('tbl_product', array('product_id'=>$product_id), $post);
        /*$msg = 'successfully Update...!'; 
        echo '<section class="content"><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>';*/           
    }
    
    public function inActiveStatus()
    {
        $product_id = $this->input->post('product_id');
        
        $post['product_status'] = '0';
        $this->common_model->updateData('tbl_product', array('product_id'=>$product_id), $post);
        /*$msg = 'successfully Update...!'; 
        echo '<section class="content"><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>';  */               
       
    }
}
