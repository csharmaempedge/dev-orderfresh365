<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends My_Controller{

	function __construct(){

		parent::__construct();

        if(!empty(MODULE_NAME)){

            $this->load->model(MODULE_NAME.'profile_model');

        }

	}

	

	/*	Validation Rules */

	protected $validation_rules = array(

        'profile' => array(

            array(

                'field' => 'user_fname',

                'label' => 'First Name',

                'rules' => 'trim|required'

            ),

			array(

                'field' => 'user_lname',

                'label' => 'Last Name',

                'rules' => 'trim|required'

            ),

            array(

                'field' => 'country_id',

                'label' => 'Country',

                'rules' => 'trim|required'

            ),

            array(

                'field' => 'state_id',

                'label' => 'State',

                'rules' => 'trim|required'

            ),

            array(

                'field' => 'user_city',

                'label' => 'City',

                'rules' => 'trim|required'

            ),

            array(

                'field' => 'user_email',

                'label' => 'Email',

                'rules' => 'trim|required'

            ),

            array(

                'field' => 'user_address',

                'label' => 'Address',

                'rules' => 'trim|required'

            ),

            array(

                'field' => 'user_postal_code',

                'label' => 'Postal Code',

                'rules' => 'trim|required|integer'

            ),

            array(

                'field' => 'user_dob',

                'label' => 'Date Of Birth',

                'rules' => 'trim|required'

            )

        ),

        'changePassword' => array(

            array(

                'field' => 'new_password',

                'label' => 'New Password',

                'rules' => 'xss_clean|callback_valid_password'

            ),

           	array(

                'field' => 'conf_new_password',

                'label' => 'Confirm Password',

                'rules' => 'trim|required|matches[new_password]|xss_clean'

            )

        )

    );



	public function index(){ 

        $session = $this->session->all_userdata();

        $user_id = $this->data['session']->user_id;

        $role_id = $this->data['session']->role_id;

        if(isset($_POST['Submit']) && $_POST['Submit'] =='Profile'){

			$this->form_validation->set_rules($this->validation_rules['profile']);

			if ($this->form_validation->run()){

				$post['user_fname'] = $this->input->post('user_fname');

                $post['user_lname'] = $this->input->post('user_lname');

                $post['user_email'] = $this->input->post('user_email');

                if($role_id != '2')

                {

                    $post['user_mobile_no'] = '';

                }

                else

                {

				    $post['user_mobile_no'] = $this->input->post('user_mobile_no');

                }

				$post['country_id'] = $this->input->post('country_id');

				$post['state_id'] = $this->input->post('state_id');

				$post['user_city'] = $this->input->post('user_city');

				$post['user_address'] = $this->input->post('user_address');
                $post['user_latitude'] = $this->input->post('txtLat');
                $post['user_longitude'] = $this->input->post('txtLng');

                /*if(!empty($post['user_address']))

                {

                    $address_data = $this->get_latlong_by_address($post['user_address']);

                   if(!empty($address_data))

                   {

                       $post['user_latitude'] = $address_data['latitude'];

                       $post['user_longitude'] = $address_data['longitude'];

                   } 

                }*/

				$post['user_postal_code'] = $this->input->post('user_postal_code');

                if($role_id == '4')

                {

                    $post['email_reminder'] = $this->input->post('email_reminder');

                    $post['text_reminder'] = $this->input->post('text_reminder');

                }

				$post['user_dob'] = $this->input->post('user_dob');

				$user_password = $this->input->post('user_password');

                if($user_password){

                    $post['user_password'] = md5($user_password);

                }

				if($_FILES["user_profile_img"]["name"]){

                   $user_profile_img = 'user_profile_img';

                   $fieldName = "user_profile_img";

                   $Path = 'webroot/upload/admin/users/profile';

                   $user_profile_img = $this->ImageUpload($_FILES["user_profile_img"]["name"], $user_profile_img, $Path, $fieldName);

                   $post['user_profile_img'] = $Path.'/'.$user_profile_img;

                }

                $n_post = $this->xssCleanValidate($post);

				$res = $this->profile_model->updateProfile($n_post,$user_id);

                $user_name = 'tbl_'.$user_id;

                if($user_password){

                    $post_l['user_password'] = md5($this->input->post('user_password'));

                }

                $post_l['user_status'] = '1';

                $post_l['module_name'] = 'admin';

                $post_l['user_type'] = 'admin';

                $post_l['tbl_name'] = 'tbl_user';

                $post_l['created_date'] = date('Y-m-d');

                $post_l['updated_date'] = date('Y-m-d');

                $n_post = $this->xssCleanValidate($post_l);

                $this->common_model->commonLoginTableUpdate($n_post,$user_name);

                /*ADdress Table*/

                $address_tbl_res = $this->common_model->getData('tbl_address', array('profile_address'=>1,'user_id'=>$user_id), 'single');

               if(!empty($address_tbl_res))

               {
                    $chef_res = $this->common_model->getData('tbl_user', array('user_id'=>'2'), 'single');

                    $global_res = $this->common_model->getData('tbl_global_setting', NULL, 'single');
                    if(!empty($chef_res))

                    {

                        $lat1 = $chef_res->user_latitude;

                        $lon1 = $chef_res->user_longitude;

                        $lat2 = $post['user_latitude'];

                        $lon2 = $post['user_longitude'];

                        $distanc_res = $this->distanceCalculete($lat1, $lon1, $lat2, $lon2);

                        if(!empty($distanc_res))

                        {

                            $post_addr['total_distance']  = round($distanc_res);

                            $check_distance = $this->common_model->checkDistanceRange($post_addr['total_distance']);

                            if(!empty($check_distance))

                            {

                                $post_addr['distance_charge'] =  $check_distance->distance_amount;

                            }

                        }

                    }
                    $post_addr['user_latitude'] = $post['user_latitude'];

                    $post_addr['user_longitude'] = $post['user_longitude'];

                    $post_addr['address_approval_status'] = 'Pending';
                    $post_addr['user_address'] = $post['user_address'];

                    $this->common_model->updateData('tbl_address', array('user_id'=>$user_id, 'profile_address'=>1),$post_addr);

               }

               if($role_id == '2')

               {

                   $no_of_phone_no = $this->common_model->getData('tbl_phone_no', array('user_id'=>$user_id), 'multi');

                    foreach ($no_of_phone_no  as  $res) {

                        $u_post_f = array();

                        $u_post_f['user_mobile_no']       = $_POST['f_user_mobile_no_'.$res->phone_id];

                        $u_nnn_post = $this->xssCleanValidate($u_post_f);

                        $this->common_model->updateData('tbl_phone_no', array('phone_id'=>$res->phone_id), $u_nnn_post);

                    }

                    $user_mobile_no_n = $this->input->post('user_mobile_no_n');

                    if(!empty($user_mobile_no_n)){

                        for ($i=0; $i<count($user_mobile_no_n); $i++){

                            if(!empty($user_mobile_no_n[$i])){

                                $post_f['user_mobile_no']           = $user_mobile_no_n[$i];

                                $post_f['user_id']                  = $user_id;

                                $post_f['address_created_date']     = date('Y-m-d');

                                $nnn_post = $this->xssCleanValidate($post_f);

                                $this->common_model->addData('tbl_phone_no', $nnn_post);

                            }

                        }

                    }

               }

				$user_details = $this->profile_model->getUserDetails($user_id);

				if(!empty($user_details)){

					if($user_details[0]->user_type == 'admin'){

						$this->session->unset_userdata('admin');

						$this->session->set_userdata('admin', $user_details);

					}

					redirect(base_url().MODULE_NAME.'dashboard');

				}

				$msg = 'Profile update successfully!!';					

				$this->session->set_flashdata('message', '<section class="content"><div class="col-xs-12"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div></div></section>');

				redirect(base_url().MODULE_NAME.'dashboard');

			}

			else{	

				$this->data['user_details'] = $this->profile_model->getUserDetails($user_id);	

				$this->data['country_list'] = $this->common_model->getAllCountry();

				$this->data['state_list'] = $this->common_model->getAllState();

				$this->show_view(MODULE_NAME.'profile_view', $this->data);

			}

		}

		else{

			$this->data['user_details'] = $this->profile_model->getUserDetails($user_id);

			$this->data['country_list'] = $this->common_model->getAllCountry();

			$this->data['state_list'] = $this->common_model->getAllState();

			$this->show_view(MODULE_NAME.'profile_view', $this->data);

		}

    }



    public function removePhoneNo(){

        $phone_id = $this->input->post('phone_id');             

        echo $del_res = $this->common_model->deleteData('tbl_phone_no', array('phone_id'=>$phone_id));     

    }

}