<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coupon extends MY_Controller {

	function __construct(){

		parent::__construct();

		if(!empty(MODULE_NAME))

		{

			$this->load->model(MODULE_NAME.'coupon_model');

		}

	}

	/*	Validation Rules */

	protected $validation_rules = array(

        'userAdd' => array(

			array(

                'field' => 'coupon_code',

                'label' => 'Coupon Code',

                'rules' => 'trim|required|is_unique[tbl_coupon_code.coupon_code]'

            )

        )

    );

	/* Details */

	public function index(){

		if($this->checkViewPermission()){

			$this->show_view(MODULE_NAME.'coupon/coupon_view',$this->data);

		}else{	

			redirect(base_url().MODULE_NAME.'dashboard/error/1');

		}

    }

    public function loadCouponListData()

    {

    	$customer_list = $this->coupon_model->getAllCouponList();

    	$data = array();

        $no = $_POST['start'];

        foreach ($customer_list as $c_res) 

	    {

			$no++;

			$row   = array();

			$row[] = $no;

			$row[] = $c_res->coupon_code_name;

			$row[] = $c_res->coupon_code;

			$row[] = date("m-d-Y", strtotime($c_res->coupon_code_expiry_date));

			$coupon_code_status = '';

            if($c_res->coupon_code_status==1)

            {  

                  $coupon_code_status  .='<label class="switch">

                        <input type="checkbox"  checked class="switch_on" onchange="inActiveStatus('.$c_res->coupon_code_id.');">

                        <span class="slider round"></span>

                      </label>';

            }

            else

            {

                $coupon_code_status  .='<label class="switch">

                    <input type="checkbox" class="switch_off" onchange="activeStatus('.$c_res->coupon_code_id.');">

                    <span class="slider round"></span>

                  </label>';

              

            }

            $row[] = $coupon_code_status;

            $btn1 = '';

	 		if($this->checkAddPermission()){

	 			$btn1 .= '<a class="btn btn-success btn-sm" href="'.base_url().''.MODULE_NAME.'coupon/assignCoupon/'.$c_res->coupon_code_id.'" title="Assign Coupon Code "><i class="fa fa-plus fa-1x "></i></a>&nbsp;&nbsp;';

	 		}

	 		$row[] = $btn1;

	 		$btn = '';

	 		if($this->checkViewPermission())

	 		{

	 			$btn .= '<a class="btn btn-primary btn-sm" href="'.base_url().''.MODULE_NAME.'coupon/couponView/'.$c_res->coupon_code_id.'" title="View"><i class="fa fa-eye fa-1x "></i></a>&nbsp;&nbsp;';

	 		}

	 		if($this->checkEditPermission())

	 		{

	 			$btn .= '<a class="btn btn-success btn-sm" href="'.base_url().''.MODULE_NAME.'coupon/addCoupon/'.$c_res->coupon_code_id.'" title="Edit"><i class="fa fa-edit fa-1x "></i></a>&nbsp;&nbsp;';

	 		}

	 		if($this->checkDeletePermission())

	 		{

	 			$btn .= '<a class="confirm btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to Delete\')" href="'.base_url().''.MODULE_NAME.'coupon/deleteCoupon/'.$c_res->coupon_code_id.'" title="Remove"><i class="fa fa-trash-o fa-1x" data-toggle="modal" data-target=".bs-example-modal-sm"></i></a>';

	 		}

	 		$row[] = $btn;

            $data[] = $row;

        }

        $output = array(

			"draw" => $_POST['draw'],

			"recordsTotal" => count($customer_list),

			"recordsFiltered" => $this->coupon_model->count_filtered(),

			"data" => $data,

		);

       	//output to json format

       	echo json_encode($output);

    }



    public function assignCoupon(){

		if($this->checkViewPermission()){			

			$coupon_code_id = $this->uri->segment(4);

			if (isset($_POST['Submit']) && $_POST['Submit'] == "Edit") 

			{

				if(!empty($coupon_code_id))

               	{

					$patient_id_arr  	= $this->input->post('patient_id');

					if(!empty($patient_id_arr))

					{

						foreach ($patient_id_arr as $patient_id) 

						{

							$post_mc['patient_id']  						= $patient_id;

							$post_mc['coupon_code']  						= $this->input->post('coupon_code');

		       				$post_mc['coupon_code_id']  					= $coupon_code_id;

		       				$post_mc['coupon_code_assign_status'] 			= '1';

		       				$post_mc['coupon_code_assign_created_date'] 	= date('Y-m-d');

							$nmc_post = $this->xssCleanValidate($post_mc);

							$this->common_model->addData('tbl_coupon_code_assign', $nmc_post);              

						}

					}

               	}

               	$msg = 'Assign Coupon successfully!!';					

				$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');

				redirect(base_url().MODULE_NAME.'coupon/assignCoupon/'.$coupon_code_id);

			}

			else

			{

				$this->data['coupon_code_id'] = $coupon_code_id;

				$this->show_view(MODULE_NAME.'coupon/assign_coupon', $this->data);

			}

		}

		else{	

			redirect( base_url().MODULE_NAME.'dashboard/error/1');

		}

	}



	public function RandomString($length = 6)

	{

	  $randstr = '';

	  /*srand((double) microtime(TRUE) * 1000000);*/

	  //our array add all letters and numbers if you wish

	  $chars = array('0','1', '2', '3', '4', '5',

	      '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K',

	      'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

	  for ($rand = 0; $rand <= $length; $rand++) {

	      $random = rand(0, count($chars) - 1);

	      $randstr .= $chars[$random];

	  }

	  return $randstr;

	}

    /* Add and Update */

	public function addCoupon($coupon_code_id = ''){

     	if($coupon_code_id)

		{

			if($this->checkEditPermission())

			{

				if (isset($_POST['Submit']) && $_POST['Submit'] == "Edit") 

				{

					$post['coupon_code_name'] 			= trim($this->input->post('coupon_code_name'));

					$post['coupon_code'] 				= $this->input->post('coupon_code');

					$post['coupon_code_expiry_date'] 	= $this->input->post('coupon_code_expiry_date');

					$post['coupon_code_type'] 			= $this->input->post('coupon_code_type');

					$post['coupon_code_amount'] 		= $this->input->post('coupon_code_amount');

					$post['coupon_code_status'] 		= $this->input->post('coupon_code_status');

					$post['coupon_code_updated_date']  	= date('Y-m-d');

					$cat_id = $this->common_model->updateData('tbl_coupon_code',array('coupon_code_id'=>$coupon_code_id),$post);

                    if($cat_id)

                    {                        	

                        $msg = 'Coupon Updated successfully!';	

						$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');

						redirect(MODULE_NAME.'coupon');

					}

				}

				else

				{

					$this->data['coupon_code_edit'] = $this->common_model->getData('tbl_coupon_code',array('coupon_code_id'=>$coupon_code_id), 'single');		

					$this->show_view(MODULE_NAME.'coupon/coupon_edit', $this->data);

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

						$post['coupon_code_name'] 			= trim($this->input->post('coupon_code_name'));

						$post['coupon_code'] 				= $this->input->post('coupon_code');

						$post['coupon_code_expiry_date'] 	= $this->input->post('coupon_code_expiry_date');

						$post['coupon_code_type'] 			= $this->input->post('coupon_code_type');

						$post['coupon_code_amount'] 		= $this->input->post('coupon_code_amount');

						$post['coupon_code_status'] 		= $this->input->post('coupon_code_status');

						$post['coupon_code_created_date']  	= date('Y-m-d');

						$post['coupon_code_updated_date']  	= date('Y-m-d');

						$cat_id = $this->common_model->addData('tbl_coupon_code',$post);

	                    if($cat_id){

	                        $msg = 'Coupon added successfully!';	

							$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');

							redirect(MODULE_NAME.'coupon');

					  	}else{

						  	$msg = 'Process failed !!';					

							$this->session->set_flashdata('message', '<section class="content"><div class="col-xs-12"><div class="alert alert-danger alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');

							redirect(base_url().MODULE_NAME.'coupon');

					  	}	

					}

					else

					{

						$RandomString = $this->RandomString();

						$this->data['RandomString'] = $RandomString;

						$this->show_view(MODULE_NAME.'coupon/coupon_add', $this->data);

					}	

				}

				else

				{

					$RandomString = $this->RandomString();

					$this->data['RandomString'] = $RandomString;

					$this->show_view(MODULE_NAME.'coupon/coupon_add', $this->data);

				}

			}

			else

			{

				redirect( base_url().MODULE_NAME.'dashboard/error/1');

			}

		}

	}



	public function couponView($coupon_code_id = ''){

		if($coupon_code_id){

			$this->data['coupon_code_edit'] = $this->common_model->getData('tbl_coupon_code',array('coupon_code_id'=>$coupon_code_id), 'single');

			$this->show_view(MODULE_NAME.'coupon/coupon_full_view',$this->data);

		}

	}



	public function deleteCoupon($coupon_code_id = ''){

		$coupon_code_id = $this->uri->segment(4);

    	if(!empty($coupon_code_id)){

    		if($this->checkDeletePermission()){

    			$post['coupon_code_status'] = 2;

    			$post['coupon_code_updated_date']	=	date('Y-m-d');

    			$cate_res = $this->common_model->updateData('tbl_coupon_code' , array('coupon_code_id'=>$coupon_code_id) , $post);
    			$post_u['coupon_code_assign_status'] = '2';

       			$this->common_model->updateData('tbl_coupon_code_assign', array('coupon_code_id'=>$coupon_code_id), $post_u);



    			if(!empty($cate_res)){

					$msg = 'Coupon Removed successfully!!';					

					$this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-danger alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');

					redirect(base_url().MODULE_NAME.'coupon');

				}

    		}

    	}

	}



	public function activeStatus()

    {

        $coupon_code_id = $this->input->post('coupon_code_id');

        

        $post['coupon_code_status'] = '1';

        $this->common_model->updateData('tbl_coupon_code', array('coupon_code_id'=>$coupon_code_id), $post);



        $post_u['coupon_code_assign_status'] = '1';

        $this->common_model->updateData('tbl_coupon_code_assign', array('coupon_code_id'=>$coupon_code_id), $post_u);

        /*$msg = 'successfully Update...!'; 

        echo '<section class="content"><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>';*/           

    }

    

    public function inActiveStatus()

    {

        $coupon_code_id = $this->input->post('coupon_code_id');

        

        $post['coupon_code_status'] = '0';

        $this->common_model->updateData('tbl_coupon_code', array('coupon_code_id'=>$coupon_code_id), $post);



        $post_u['coupon_code_assign_status'] = '0';

        $this->common_model->updateData('tbl_coupon_code_assign', array('coupon_code_id'=>$coupon_code_id), $post_u);

        /*$msg = 'successfully Update...!'; 

        echo '<section class="content"><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>';  */               

       

    }



    public function removeCoupon(){

        $coupon_code_assign_id = $this->input->post('coupon_code_assign_id'); 

        echo $del_res = $this->common_model->deleteData('tbl_coupon_code_assign', array('coupon_code_assign_id'=>$coupon_code_assign_id));      

    }

}

