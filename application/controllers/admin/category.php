<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Category extends MY_Controller {
	function __construct(){
		parent::__construct();
		if(!empty(MODULE_NAME))
		{
			$this->load->model(MODULE_NAME.'category_model');
		}
	}
	/* Details */
	public function index(){
		if($this->checkViewPermission()){
			$this->show_view(MODULE_NAME.'category/category_view',$this->data);
		}else{	
			redirect(base_url().MODULE_NAME.'dashboard/error/1');
		}
    }
    public function loadCategoryListData()
    {
    	$customer_list = $this->category_model->getAllCategoryList();
    	$data = array();
        $no = $_POST['start'];
        foreach ($customer_list as $c_res) 
	    {
	    	$check_product_res = $this->common_model->getData('tbl_product', array('category_id'=>$c_res->category_id), 'single');
			$no++;
			$row   = array();
			$row[] = $no;
			$row[] = $c_res->category_name;
			$category_status = '';
            if($c_res->category_status==1)
            {  
                  $category_status  .='<label class="switch">
                        <input type="checkbox"  checked class="switch_on" onchange="inActiveStatus('.$c_res->category_id.');">
                        <span class="slider round"></span>
                      </label>';
            }
            else
            {
                $category_status  .='<label class="switch">
                    <input type="checkbox" class="switch_off" onchange="activeStatus('.$c_res->category_id.');">
                    <span class="slider round"></span>
                  </label>';
              
            }
            $row[] = $category_status;
	 		$btn = '';
	 		if($this->checkViewPermission())
	 		{
	 			if(!empty($check_product_res))
	 			{
	 				$btn .= '<a class="btn btn-success btn-sm" href="'.base_url().''.MODULE_NAME.'category/productList/'.$c_res->category_id.'" title="Product List"><i class="fa fa-eye fa-1x "></i></a>&nbsp;&nbsp;';
	 			}
	 			$btn .= '<a class="btn btn-primary btn-sm" href="'.base_url().''.MODULE_NAME.'category/categoryView/'.$c_res->category_id.'" title="View"><i class="fa fa-eye fa-1x "></i></a>&nbsp;&nbsp;';
	 		}
	 		if($this->checkEditPermission())
	 		{
	 			$btn .= '<a class="btn btn-success btn-sm" href="'.base_url().''.MODULE_NAME.'category/addCategory/'.$c_res->category_id.'" title="Edit"><i class="fa fa-edit fa-1x "></i></a>&nbsp;&nbsp;';
	 		}
	 		/*if($this->checkDeletePermission())
	 		{
	 			$btn .= '<a class="confirm btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to Delete\')" href="'.base_url().''.MODULE_NAME.'category/deleteCategory/'.$c_res->category_id.'" title="Remove"><i class="fa fa-trash-o fa-1x" data-toggle="modal" data-target=".bs-example-modal-sm"></i></a>';
	 		}*/
	 		$row[] = $btn;
            $data[] = $row;
        }
        $output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => count($customer_list),
			"recordsFiltered" => $this->category_model->count_filtered(),
			"data" => $data,
		);
       	//output to json format
       	echo json_encode($output);
    }
    /* Add and Update */
	public function addCategory($category_id = ''){
     	if($category_id)
		{
			if($this->checkEditPermission())
			{
				if (isset($_POST['Submit']) && $_POST['Submit'] == "Edit") 
				{
					$post['category_name'] 		= trim($this->input->post('category_name'));
					$post['category_status'] 	= $this->input->post('category_status');
					$post['category_created_date'] 			= date('Y-m-d');
					$post['category_updated_date'] 			= date('Y-m-d');
					$cat_id = $this->common_model->updateData('tbl_category',array('category_id'=>$category_id),$post);
                    if($cat_id)
                    {                        	
                        $msg = 'Category Updated successfully!';	
						$this->session->set_flashdata('message', '<section class="content"><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
						redirect(MODULE_NAME.'category');
					}
				}
				else
				{
					$this->data['category_edit'] = $this->common_model->getData('tbl_category',array('category_id'=>$category_id), 'single');		
					$this->show_view(MODULE_NAME.'category/category_edit', $this->data);
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
					$post['category_name'] 		 	= trim($this->input->post('category_name'));
					$post['category_status'] 		= $this->input->post('category_status');
					$post['category_created_date']  	= date('Y-m-d');
					$post['category_updated_date']  	= date('Y-m-d');
					$post['category_created_datetime'] 	= date('Y-m-d H:i:s');
					$cat_id = $this->common_model->addData('tbl_category',$post);
                    if($cat_id){
                        $msg = 'Category added successfully!';	
						$this->session->set_flashdata('message', '<section class="content"><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
						redirect(MODULE_NAME.'category');
				  	}else{
					  	$msg = 'Process failed !!';					
						$this->session->set_flashdata('message', '<section class="content"><div class="col-xs-12"><div class="alert alert-danger alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
						redirect(base_url().MODULE_NAME.'category');
				  	}		
				}
				else
				{
					$this->show_view(MODULE_NAME.'category/category_add', $this->data);
				}
			}
			else
			{
				redirect( base_url().MODULE_NAME.'dashboard/error/1');
			}
		}
	}

	public function productList($category_id = ''){
		if($category_id){
			$this->data['category_id'] = $category_id;
			$this->show_view(MODULE_NAME.'category/category_product_view',$this->data);
		}
	}
	public function categoryView($category_id = ''){
		if($category_id){
			$this->data['category_edit'] = $this->common_model->getData('tbl_category',array('category_id'=>$category_id), 'single');
			$this->show_view(MODULE_NAME.'category/category_full_view',$this->data);
		}
	}

	public function deleteCategory($category_id = ''){
		$category_id = $this->uri->segment(4);
    	if(!empty($category_id)){
    		if($this->checkDeletePermission()){
    			$post['category_status'] = 2;
    			$post['category_updated_date']	=	date('Y-m-d');
    			$cate_res = $this->common_model->updateData('tbl_category' , array('category_id'=>$category_id) , $post);
    			if(!empty($cate_res)){
					$msg = 'Category Removed successfully!!';					
					$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-danger alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
					redirect(base_url().MODULE_NAME.'category');
				}
    		}
    	}
	}

	public function activeStatus()
    {
        $category_id = $this->input->post('category_id');
        
        $post['category_status'] = '1';
        $this->common_model->updateData('tbl_category', array('category_id'=>$category_id), $post);
        /*$msg = 'successfully Update...!'; 
        echo '<section class="content"><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>';*/           
    }
    
    public function inActiveStatus()
    {
        $category_id = $this->input->post('category_id');
        
        $post['category_status'] = '0';
        $this->common_model->updateData('tbl_category', array('category_id'=>$category_id), $post);
        /*$msg = 'successfully Update...!'; 
        echo '<section class="content"><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>';  */               
    }

    public function loadCategoryProductListData()
    {
    	$customer_list = $this->category_model->getAllCategoryProductList();
    	$data = array();
        $no = $_POST['start'];
        foreach ($customer_list as $c_res) 
	    {
			$no++;
			$row   = array();
			$row[] = $no;
			$row[] = $c_res->product_name;
			$row[] = $c_res->product_price;
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
            if($this->checkEditPermission())
	 		{
	 			$row[] =  '<a class="btn btn-success btn-sm" href="'.base_url().''.MODULE_NAME.'category/updateProduct/'.$c_res->product_id.'/'.$c_res->category_id.'" title="Edit"><i class="fa fa-edit fa-1x "></i></a>&nbsp;&nbsp;';
	 		}
	 		if($c_res->category_id =='1')
	 		{
		 		if($this->checkEditPermission())
		 		{
		 			$row[] =  '<a class="btn btn-warning btn-sm" href="'.base_url().''.MODULE_NAME.'category/AssignProduct/'.$c_res->product_id.'/'.$c_res->category_id.'/category'.'" title="Assign Veggies & Carb"><i class="fa fa-plus fa-1x "></i></a>&nbsp;&nbsp;';
		 		}
	 			
	 		}
            $data[] = $row;
        }
        $output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => count($customer_list),
			"recordsFiltered" => $this->category_model->count_filtered_pp(),
			"data" => $data,
		);
       	//output to json format
       	echo json_encode($output);
    }

     public function AssignProduct(){
		if($this->checkViewPermission()){			
			$product_id = $this->uri->segment(4);
			$category_id = $this->uri->segment(5);
			$slug_type = $this->uri->segment(6);
			if (isset($_POST['Submit']) && $_POST['Submit'] == "Edit") 
			{
				if(!empty($product_id))
               	{
					$veggies_id_arr  	= $this->input->post('veggies_id');
					$carb_id_arr  	= $this->input->post('carb_id');
					if(!empty($veggies_id_arr))
					{
						foreach ($veggies_id_arr as $veggies_id) 
						{
							$veggies_res = $this->common_model->getData('tbl_product', array('product_id'=>$veggies_id), 'single');
							$post_mc['macro_id']  						= $veggies_res->category_id;
							$post_mc['assign_product_id']  						= $veggies_id;
		       				$post_mc['product_id'] 	=$product_id;
		       				$post_mc['product_veggies_created_date'] 	= date('Y-m-d');
							$nmc_post = $this->xssCleanValidate($post_mc);
							$this->common_model->addData('tbl_product_wise_veggies', $nmc_post);              
						}
					}
					if(!empty($carb_id_arr))
					{
						foreach ($carb_id_arr as $carb_id) 
						{
							$carb_res = $this->common_model->getData('tbl_product', array('product_id'=>$carb_id), 'single');
							$post_mca['macro_id']  						= $carb_res->category_id;
							$post_mca['assign_product_id']  						= $carb_id;
		       				$post_mca['product_id'] 	=$product_id;
		       				$post_mca['product_veggies_created_date'] 	= date('Y-m-d');
							$nmca_post = $this->xssCleanValidate($post_mca);
							$this->common_model->addData('tbl_product_wise_veggies', $nmca_post);              
						}
					}
               	}
               	$msg = 'Assign Successfully!!';					
				$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
				redirect(base_url().MODULE_NAME.'category/AssignProduct/'.$product_id.'/'.$category_id.'/'.$slug_type);
			}
			else
			{
				$this->data['category_id'] = $category_id;
				$this->data['product_id'] = $product_id;
				$this->data['slug_type'] = $slug_type;
				$this->show_view(MODULE_NAME.'category/assign_product', $this->data);
			}
		}
		else{	
			redirect( base_url().MODULE_NAME.'dashboard/error/1');
		}
	}

	public function removeVeggies(){
        $product_veggies_id = $this->input->post('product_veggies_id'); 
        echo $del_res = $this->common_model->deleteData('tbl_product_wise_veggies', array('product_veggies_id'=>$product_veggies_id));      
    }
    public function updateProduct($product_id = '', $category_id = ''){
     	if($product_id)
		{
			if($this->checkEditPermission())
			{
				if (isset($_POST['Submit']) && $_POST['Submit'] == "Edit") 
				{
					$post['product_name'] 		= trim($this->input->post('product_name'));
					$post['product_status'] 	= $this->input->post('product_status');
					$post['category_id'] 	= $this->input->post('category_id');
					$post['product_price'] 	= $this->input->post('product_price');
					$post['product_created_date'] 			= date('Y-m-d');
					$post['product_updated_date'] 			= date('Y-m-d');
					$cat_id = $this->common_model->updateData('tbl_product',array('product_id'=>$product_id),$post);
                    if($cat_id)
                    {                        	
                        $msg = 'Product Updated successfully!';	
						$this->session->set_flashdata('message', '<section class="content"><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
						redirect(MODULE_NAME.'category/productList/'.$category_id);
					}
				}
				else
				{
					$this->data['category_id'] = $category_id;		
					$this->data['product_edit'] = $this->common_model->getData('tbl_product',array('product_id'=>$product_id), 'single');		
					$this->show_view(MODULE_NAME.'category/product_edit', $this->data);
				}
			}
			else
			{
				redirect(base_url().MODULE_NAME.'dashboard/error/1');
			}
		}
	}
}
