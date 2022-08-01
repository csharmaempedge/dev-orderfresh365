<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart extends MY_Controller 

{

	function __construct()

	{

		parent::__construct();

		if(!empty(MODULE_NAME)){

		   $this->load->model(MODULE_NAME.'dashboard_model');

		}

	}



	/* Dashboard Show */

	public function index()

	{	

		$this->show_view(MODULE_NAME.'cart/cart_view', $this->data);

    }



    /* Dashboard Show */

	public function error()

	{	

		$value = $this->uri->segment(4);

		if($value == '1')

		{	

			$this->show_view(MODULE_NAME.'error/error_permission', $this->data);

		}		

    }



    public function removeCartItem(){



      	$unique_no = $this->input->post('unique_no');

      	echo $this->common_model->deleteData('tbl_cart', array('unique_no'=>$unique_no));

      }

      public function clearCart($patient_id = ''){
        $patient_id = $this->uri->segment(4);
          if(!empty($patient_id)){
              $this->common_model->deleteData('tbl_cart', array('patient_id'=>$patient_id));
              $this->common_model->deleteData('tbl_breakfast_cart', array('patient_id'=>$patient_id));
              $msg = 'Cart remove successfully!!';         
              $this->session->set_flashdata('message', '<section><div class="col-xs-12"><div class="alert alert-danger alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');
              redirect(base_url().MODULE_NAME.'dashboard');
          }
      }



      public function removeBreakfastCartItem(){



      	$breakfast_cart_id = $this->input->post('breakfast_cart_id');

      	echo $this->common_model->deleteData('tbl_breakfast_cart', array('breakfast_cart_id'=>$breakfast_cart_id));

      }



      public function updateCartItem(){



      	$cart_id 					= $this->input->post('cart_id');

      	$post['qty']  				= $this->input->post('qty');

      	echo $this->common_model->updateData('tbl_cart', array('cart_id'=>$cart_id), $post);

      }



      public function updateBreakfastCartItem(){

      	$breakfast_cart_id 	= $this->input->post('breakfast_cart_id');

      	$post['qty']  		= $this->input->post('qty');

      	$breakfast_cart_res = $this->common_model->getData('tbl_breakfast_cart', array('breakfast_cart_id'=>$breakfast_cart_id), 'single');

      	if(!empty($breakfast_cart_res))

      	{

      		$product_res1 = $this->common_model->getData('tbl_product', array('product_id'=>$breakfast_cart_res->breakfast_product_id_1), 'single');

    			$product_price1  	= $product_res1->product_price;



    			$product_res2 = $this->common_model->getData('tbl_product', array('product_id'=>$breakfast_cart_res->breakfast_product_id_2), 'single');

    			$product_price2  	= $product_res2->product_price;



    			$product_price = $breakfast_cart_res->breakfast_qty_1 * $product_price1 + $breakfast_cart_res->breakfast_qty_2 * $product_price2;

    			$post['breakfast_price'] = $product_price * $post['qty'];

      	}







      	

      	echo $this->common_model->updateData('tbl_breakfast_cart', array('breakfast_cart_id'=>$breakfast_cart_id), $post);

      }



      public function updateCartProductqty(){



      	$cart_id 			= $this->input->post('cart_id');

      	$qty_value 			= $this->input->post('qty_value');

      	$cart_product_price = $this->input->post('cart_product_price');

      	$update_product_price = $qty_value * $cart_product_price;



      	$data = array(

				'rowid'   => $cart_id,

				'qty'     => $qty_value,

				'price'	  => $update_product_price

			);

      	 echo $update_qty =$this->cart->update($data);

      }



    public function checkCouponCode()

    {

        $c_date               = date('Y-m-d');

        $apply_coupon_code    = $this->input->post('apply_coupon_code');

        $patient_id           = $this->data['session']->user_id;  

        $patient_coupon_res   = $this->common_model->getData('tbl_coupon_code_assign', array('patient_id'=>$patient_id, 'coupon_code'=>$apply_coupon_code, 'coupon_code_assign_status'=>1),'single');

        if(!empty($patient_coupon_res))

        {

            $check_coupon_code = $this->common_model->getData('tbl_coupon_code', array('coupon_code'=>$apply_coupon_code,'coupon_code_expiry_date >='=>$c_date), 'single');

            $check_coupon_order_code = $this->common_model->getData('tbl_order', array('apply_coupon_code'=>$apply_coupon_code,'patient_id'=>$patient_id), 'single');

            if(!empty($check_coupon_code))

            {

            	if(empty($check_coupon_order_code))

            	{

                	echo 1;

            	}

            	else

	            {

	                echo "coupon code expaired";

	            }

            }

            else

            {

                echo "coupon code expaired";

            }

        }

        else

        {

            echo "invalid coupon code";

        }

    }



    public function applyCouponCode()

    {

        $c_date               = date('Y-m-d');

        $apply_coupon_code    = $this->input->post('apply_coupon_code');

        $final_amount         = $this->input->post('final_amount');

        $patient_id           = $this->data['session']->user_id;  

        $patient_coupon_res   = $this->common_model->getData('tbl_coupon_code_assign', array('patient_id'=>$patient_id, 'coupon_code'=>$apply_coupon_code, 'coupon_code_assign_status'=>1),'single');

        if(!empty($patient_coupon_res))

        {

            $check_coupon_code = $this->common_model->getData('tbl_coupon_code', array('coupon_code'=>$apply_coupon_code,'coupon_code_expiry_date >='=>$c_date), 'single');

            if(!empty($check_coupon_code))

            {

                if($check_coupon_code->coupon_code_type == 'Fix')

                {

                    $coupon_code_amount =$check_coupon_code->coupon_code_amount;

                    /*$coupon_code_amount = $final_amount - $check_coupon_code->coupon_code_amount;*/

                    echo $coupon_code_amount =$check_coupon_code->coupon_code_amount;                

                }

                elseif($check_coupon_code->coupon_code_type == 'Percentage')

                {

                    $amount = ($final_amount*$check_coupon_code->coupon_code_amount)/ 100;

                    $coupon_code_amount = $final_amount - $amount;

                    echo $amount;
                }
                else

                {
                    echo 404;
                }

            }

        }

    }

    public function applySpecialCouponCode()

    {

        $c_date               = date('Y-m-d');

        $apply_coupon_code    = $this->input->post('apply_coupon_code');

        $patient_id           = $this->data['session']->user_id;  

        $patient_coupon_res   = $this->common_model->getData('tbl_coupon_code_assign', array('patient_id'=>$patient_id, 'coupon_code'=>$apply_coupon_code, 'coupon_code_assign_status'=>1),'single');

        if(!empty($patient_coupon_res))

        {

            $check_coupon_code = $this->common_model->getData('tbl_coupon_code', array('coupon_code'=>$apply_coupon_code,'coupon_code_expiry_date >='=>$c_date), 'single');

            if(!empty($check_coupon_code))

            {

                if($check_coupon_code->coupon_code_type == 'special_coupon_code')

                {

                    $coupon_code_amount =$check_coupon_code->coupon_code_amount;

                    echo $coupon_code_amount;                

                }

            }

        }

    }



    public function addressWiseDistanceCharge(){



        $address_id = $this->input->post('address_id');

        $session_patient_id = $this->data['session']->user_id;

        $address_res = $this->common_model->getData('tbl_address', array('address_id'=>$address_id), 'single');

        if(!empty($address_res))

        {

          $post['distance_charge']       = $address_res->distance_charge;

          $this->common_model->updateData('tbl_cart', array('patient_id'=>$session_patient_id), $post);

        }

        $this->data['user_id'] = $session_patient_id;

        $this->load->view(MODULE_NAME.'cart/cart_view_ajax',$this->data);

        

      }

}

/* End of file */?>