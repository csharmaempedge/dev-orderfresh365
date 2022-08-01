<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

ob_start();

class MY_Controller extends CI_Controller {	

	public function __construct(){

		parent::__construct();

		date_default_timezone_set('Asia/Kolkata');

		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');

		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');

		$this->output->set_header('Pragma: no-cache');

		$this->data['session'] = $this->getSessionVal();		

		$this->data['myobj'] = $this;

		$global_res = $this->common_model->getData('tbl_global_setting', NULL, 'single');

		if(!empty($global_res->theme_color))

		{

			$theme_color = $global_res->theme_color;

		}

		else

		{

			$theme_color = '#c8c9e3';

		}

		define('THEME_COLOR', $theme_color);		

		define('MODULE_NAME', 'admin/');		

		if(!empty($_POST['lng'])){				

			$this->session->set_userdata($_POST);

		}

		else{

			$sess=$this->session->all_userdata();

			if(!empty($sess['lng'])){

				$data['lng'] = $sess['lng'];

				$this->session->set_userdata($data);

			}

			else{

				$data['lng'] = 'english';

				$this->session->set_userdata($data);

			}

		}

	}



	public function getSessionVal(){

		$sess_val = '';

		$session = $this->session->all_userdata();		

		if(!empty($session['admin'])){

			$sess_val = $session['admin']['0'];

		}

		return $sess_val;

	}

	

	public function show_view($view, $data = ''){

		if($this->getSessionVal()){

			$sess_val = $this->getSessionVal();

			$module_name 	= $sess_val->module_name;

			$role_id 		= $sess_val->role_id;

			$tbl_prefix 	= $sess_val->user_tbl_prefix;

			$data['getAllParentRole'] 	= $this->common_model->getAllParentRole($role_id, $tbl_prefix);

			$data['myobj'] 				= $this;

			if($sess_val->user_type == 'admin'){

				$data['user_name'] 	= $sess_val->user_fname.' '.$sess_val->user_lname;

				$data['user_id'] 	= $sess_val->user_id;

			}

			else{

				$data['user_name'] 	= $sess_val->people_title;

				$data['user_id'] 	= $sess_val->people_id;

			}

			$data['patient_doctor_id'] = $sess_val->doctor_id;

			$data['role_id'] = $sess_val->role_id;

			$data['user_tbl_prefix'] = $tbl_prefix;

			$this->load->view(MODULE_NAME.'layout/header',$data);

			$this->load->view(MODULE_NAME.'layout/sidebar',$data);

			$this->load->view($view, $data);

			$this->load->view(MODULE_NAME.'layout/footer',$data);

		}

		else{

			redirect(base_url());

		}

    }



    public function show_view_front($view, $data = ''){

    	$this->data['visitor_data'] = $this->session->userdata('cm_visitor');

		$this->data['myobj'] = $this;

		$this->load->view('front/layout/header',$this->data);

		$this->load->view($view, $this->data);

		$this->load->view('front/layout/footer',$this->data);

	}

	

	public function checkViewPermission()

	{

		$sess_val = $this->getSessionVal();

		if(!empty($sess_val)){

			$role_id_arr = explode(',', $sess_val->role_id);

			$tab_arr = array();

			$tab_arr[] = 'dashboard';

            foreach($role_id_arr as $r_id){

                $user_tab_res = $this->common_model->getTabIdByRolePermission($r_id);

                if(!empty($user_tab_res)){

                    foreach($user_tab_res as $ut_res){

                        if($ut_res->userView == '1'){

                        	if(!empty($ut_res->controller_name)){

                            	$tab_arr[] = $ut_res->controller_name;

                        	}

                        }

                    }

                }

            }

            $tab_arr = array_unique($tab_arr);

            if(in_array($this->uri->segment(2), $tab_arr)){

				return true;

			}

			else{

				return false;

			}

		}

		else{

			return false;

		}

	}



	public function checkApprovalPermission()

	{

		$sess_val = $this->getSessionVal();

		if(!empty($sess_val)){

			$role_id_arr = explode(',', $sess_val->role_id);

			$tab_arr = array();

			$tab_arr[] = 'dashboard';

            foreach($role_id_arr as $r_id){

                $user_tab_res = $this->common_model->getTabIdByRolePermission($r_id);

                if(!empty($user_tab_res)){

                    foreach($user_tab_res as $ut_res){

                        if($ut_res->userApproval == '1'){

                        	if(!empty($ut_res->controller_name)){

                            	$tab_arr[] = $ut_res->controller_name;

                        	}

                        }

                    }

                }

            }

            $tab_arr = array_unique($tab_arr);

            if(in_array($this->uri->segment(2), $tab_arr)){

				return true;

			}

			else{

				return false;

			}

		}

		else{

			return false;

		}

	}



	public function checkAddPermission()

	{

		$sess_val = $this->getSessionVal();

		if(!empty($sess_val)){

			$role_id_arr = explode(',', $sess_val->role_id);

			$tab_arr = array();

			$tab_arr[] = 'dashboard';

            foreach($role_id_arr as $r_id){

                $user_tab_res = $this->common_model->getTabIdByRolePermission($r_id);

                if(!empty($user_tab_res)){

                    foreach($user_tab_res as $ut_res){

                        if($ut_res->userAdd == '1'){

                        	if(!empty($ut_res->controller_name)){

                            	$tab_arr[] = $ut_res->controller_name;

                        	}

                        }

                    }

                }

            }

            $tab_arr = array_unique($tab_arr);

            if(in_array($this->uri->segment(2), $tab_arr)){

				return true;

			}

			else{

				return false;

			}

		}

		else{

			return false;

		}	

	}



	public function checkEditPermission()

	{

		$sess_val = $this->getSessionVal();

		if(!empty($sess_val)){

			$role_id_arr = explode(',', $sess_val->role_id);

			$tab_arr = array();

			$tab_arr[] = 'dashboard';

            foreach($role_id_arr as $r_id){

                $user_tab_res = $this->common_model->getTabIdByRolePermission($r_id);

                if(!empty($user_tab_res)){

                    foreach($user_tab_res as $ut_res){

                        if($ut_res->userEdit == '1'){

                        	if(!empty($ut_res->controller_name)){

                            	$tab_arr[] = $ut_res->controller_name;

                        	}

                        }

                    }

                }

            }

            $tab_arr = array_unique($tab_arr);

            if(in_array($this->uri->segment(2), $tab_arr)){

				return true;

			}

			else{

				return false;

			}

		}

		else{

			return false;

		}

	}	



	public function checkDeletePermission()

	{

		$sess_val = $this->getSessionVal();

		if(!empty($sess_val)){

			$role_id_arr = explode(',', $sess_val->role_id);

			$tab_arr = array();

			$tab_arr[] = 'dashboard';

            foreach($role_id_arr as $r_id){

                $user_tab_res = $this->common_model->getTabIdByRolePermission($r_id);

                if(!empty($user_tab_res)){

                    foreach($user_tab_res as $ut_res){

                        if($ut_res->userDelete == '1'){

                        	if(!empty($ut_res->controller_name)){

                            	$tab_arr[] = $ut_res->controller_name;

                        	}

                        }

                    }

                }

            }

            $tab_arr = array_unique($tab_arr);

            if(in_array($this->uri->segment(2), $tab_arr)){

				return true;

			}

			else{

				return false;

			}

		}

		else{

			return false;

		}		

	}



	public function xssCleanValidate($input_array){

		$out_array = array();

		foreach ($input_array as $key => $value) 

		{

			$out_array[$key] = $this->security->xss_clean($value); 

		}

		return $out_array;

	}



	public function ImageUpload($filename, $name, $imagePath, $fieldName){

		$temp = explode(".",$filename);

		$extension = end($temp);

		$filenew =  date('Y-m-d').'_'.str_replace($filename,$name,$filename).'_'.time(). "." .$extension;  	

		$config['file_name'] = $filenew;

		$config['upload_path'] = $imagePath;

		$config['allowed_types'] = 'GIF | gif | JPE | jpe | JPEG | jpeg | JPG | jpg | PNG | png';

		$this->upload->initialize($config);

		$this->upload->set_allowed_types('*');

		$this->upload->set_filename($config['upload_path'],$filenew);

		if(!$this->upload->do_upload($fieldName)){

			$data = array('msg' => $this->upload->display_errors());

		}

		else{ 

			$data = $this->upload->data();

			$imageName = $data['file_name'];	

			return $imageName;

		}	

	}



	public function FileUpload($filename, $name, $imagePath, $fieldName, $allowed_types){

		$temp = explode(".",$filename);

		$extension = end($temp);

		$filenew =  date('Y-m-d').'_'.str_replace($filename,$name,$filename).'_'.time(). "." .$extension; 	

		$config['file_name'] = $filenew;

		$config['upload_path'] = $imagePath;

		$this->upload->initialize($config);

		$this->upload->set_allowed_types('*');

		$this->upload->set_filename($config['upload_path'],$filenew);

		if(!$this->upload->do_upload($fieldName)){

			$data = array('msg' => $this->upload->display_errors());

		}

		else{ 

			$data = $this->upload->data();

			$imageName = $data['file_name'];	

			return $imageName;

		}	

	}



	public function alpha_dash_space($fullname){

		if (! preg_match('/^[a-zA-Z\s]+$/', $fullname)){

			$this->form_validation->set_message('alpha_dash_space', 'The %s field may only contain alpha characters & White spaces');

			return FALSE;

		} 

		else{

			return TRUE;

		}

	}



    public function removeSpecialChar($string){

        $string = str_replace(array('[\', \']'), '-', $string);

        $string = preg_replace('/\[.*\]/U', '', $string);

        $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);

      	$string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );

        $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);

        return strtolower(trim($string, '-'));

    }



    public function checkDuplicatePageSlug($table_name = '' , $where_arr){

        if($table_name && !empty($where_arr)){

            $check_slug_result = $this->common_model->getData($table_name , $where_arr);

            return count($check_slug_result);

        }

    }



    function loadPo($word){

		$sess=$this->session->all_userdata();

		if(isset($sess['lng'])){

			$filename='webroot/language/'.$sess['lng'].'.po';

		}else{

			$filename='webroot/language/english.po'; 

		}

		if (!$file = fopen($filename, 'r')){

			return false;

		}

		$type = 0;

		$translations = array();

		$translationKey = '';

		$plural = 0;

		$header = '';

		do {

			$line = trim(fgets($file));

			if ($line === '' || $line[0] === '#') {

				continue;

			}

			if (preg_match("/msgid[[:space:]]+\"(.+)\"$/i", $line, $regs)) {

				$type = 1;

				$translationKey = stripcslashes($regs[1]);

			} elseif (preg_match("/msgid[[:space:]]+\"\"$/i", $line, $regs)) {

				$type = 2;

				$translationKey = '';

			} elseif (preg_match("/^\"(.*)\"$/i", $line, $regs) && ($type == 1 || $type == 2 || $type == 3)) {

				$type = 3;

				$translationKey .= stripcslashes($regs[1]);

			} elseif (preg_match("/msgstr[[:space:]]+\"(.+)\"$/i", $line, $regs) && ($type == 1 || $type == 3) && $translationKey) {

				$translations[$translationKey] = stripcslashes($regs[1]);

				$type = 4;

			} elseif (preg_match("/msgstr[[:space:]]+\"\"$/i", $line, $regs) && ($type == 1 || $type == 3) && $translationKey) {

				$type = 4;

				$translations[$translationKey] = '';

			} elseif (preg_match("/^\"(.*)\"$/i", $line, $regs) && $type == 4 && $translationKey) {

				$translations[$translationKey] .= stripcslashes($regs[1]);

			} elseif (preg_match("/msgid_plural[[:space:]]+\".*\"$/i", $line, $regs)) {

				$type = 6;

			} elseif (preg_match("/^\"(.*)\"$/i", $line, $regs) && $type == 6 && $translationKey) {

				$type = 6;

			} elseif (preg_match("/msgstr\[(\d+)\][[:space:]]+\"(.+)\"$/i", $line, $regs) && ($type == 6 || $type == 7) && $translationKey) {

				$plural = $regs[1];

				$translations[$translationKey][$plural] = stripcslashes($regs[2]);

				$type = 7;

			} elseif (preg_match("/msgstr\[(\d+)\][[:space:]]+\"\"$/i", $line, $regs) && ($type == 6 || $type == 7) && $translationKey) {

				$plural = $regs[1];

				$translations[$translationKey][$plural] = '';

				$type = 7;

			} elseif (preg_match("/^\"(.*)\"$/i", $line, $regs) && $type == 7 && $translationKey) {

				$translations[$translationKey][$plural] .= stripcslashes($regs[1]);

			} elseif (preg_match("/msgstr[[:space:]]+\"(.+)\"$/i", $line, $regs) && $type == 2 && !$translationKey) {

				$header .= stripcslashes($regs[1]);

				$type = 5;

			} elseif (preg_match("/msgstr[[:space:]]+\"\"$/i", $line, $regs) && !$translationKey) {

				$header = '';

				$type = 5;

			} elseif (preg_match("/^\"(.*)\"$/i", $line, $regs) && $type == 5) {

				$header .= stripcslashes($regs[1]);

			} else {

				unset($translations[$translationKey]);

				$type = 0;

				$translationKey = '';

				$plural = 0;

			}

		}while (!feof($file));

		fclose($file);

		$merge[''] = $header;

		$translations= array_merge($merge, $translations);

		if (array_key_exists($word,$translations)){

			return $translations[$word];

		}else{

			return $word;

		}

	}





	public function getaddress($lat,$lng)

	{

		$url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($lng).'&sensor=false&key=AIzaSyDw3d0GfDlEg-aoiLuWqRyN9T5Zu8jFOw8';



		$json = @file_get_contents($url);

		if(!empty($json))

		{

			$data=json_decode($json);

			$status = $data->status;

			if($status=="OK")

			{

				return $data->results[0]->formatted_address;

			}

			else

			{

				return false;

			}

			

		}

	}





	/*	Mail Send */

    public function send_mail($email, $subject, $message, $file_to_attach='')    

    {

    	$global_res = $this->common_model->getData('tbl_global_setting', NULL, 'single');

        $this->load->library('PHPMailer/phpmailer');

		$mail = new PHPMailer();

		//$mail->IsSMTP();   

		$mail->Host = $global_res->smtp_host;  // specify main and backup server

		$mail->SMTPAuth = true;     // turn on SMTP authentication

		$mail->Username = $global_res->smtp_mail;  // SMTP username

		$mail->Password = $global_res->smtp_password; // SMTP password

		$mail->SMTPSecure = $global_res->smtp_secure;

		$mail->Port = $global_res->smtp_port;

		$mail->From = $global_res->smtp_mail;

		$mail->FromName = "Meal Booking";

		$email="dpr1001@empiricaledge.com";

		$mail->AddAddress($email);

		$mail->WordWrap = 50; 

		$mail->IsHTML(true); 

		$mail->Subject = $subject;

		$mail->Body    = $message;

		if(!empty($file_to_attach))

        {

            $mail->addAttachment($file_to_attach, '', 'base64', 'application/pdf');

        }

		if(!$mail->Send())

		{

		  return false;

		}

		else

		{

			return true;

		}

    }



    /*public function send_mail($email, $subject, $message)

    {

	    $mailto = $email;

	    $separator = md5(time());

	    $eol = "\r\n";

	    $headers = "From: Mr Harsh <orders@circadianfood365.com>" . $eol;

	    $headers .= "MIME-Version: 1.0" . $eol;

	    $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;

	    $headers .= "Content-Transfer-Encoding: 7bit" . $eol;

	    $headers .= "This is a MIME encoded message." . $eol;



	    // message

	    $body = "--" . $separator . $eol;

	    $body .= "Content-Type: text/plain; charset=\"iso-8859-1\"" . $eol;

	    $body .= "Content-Transfer-Encoding: 8bit" . $eol;

	    $body .= $message . $eol;





	    //SEND Mail

	    if (mail($mailto, $subject, $body, $headers)) {

	    	return true;

	    } else {

	        return false;

	    }

    }*/



    public function get_latlong_by_address($address)

	{

		

		$prepAddr = str_replace(' ','+',$address);

		$geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=true_or_false&key=AIzaSyBE_aeLnY9Oqwe43dd2swJO0zNcvy-Ac5g');

		$output     = json_decode($geocode);

		$latitude   = $output->results[0]->geometry->location->lat;

		$longitude  = $output->results[0]->geometry->location->lng;



		$address_data['latitude']   = $latitude;

		$address_data['longitude']  = $longitude;		

			return $address_data;	

	}



	public function clickSendMessage($user_mobile_no, $message)

    {

		$user_mobile_no='18564521619';

    	require 'vendor/autoload.php';



		// Configure HTTP basic authorization: BasicAuth

		$config = ClickSend\Configuration::getDefaultConfiguration()

		              ->setUsername('jmatrulli@circadianfood365.com')

		              ->setPassword('D13E2423-39E7-A330-612C-197F98E465D3');



		$apiInstance = new ClickSend\Api\SMSApi(new GuzzleHttp\Client(),$config);

		$msg = new \ClickSend\Model\SmsMessage();

		$msg->setBody($message); 

		$msg->setTo($user_mobile_no);

		$msg->setSource("sdk");



		// \ClickSend\Model\SmsMessageCollection | SmsMessageCollection model

		$sms_messages = new \ClickSend\Model\SmsMessageCollection(); 

		$sms_messages->setMessages([$msg]);



		try {

		   // $result = $apiInstance->smsSendPost($sms_messages);

		    /*print_r($result);*/

		} catch (Exception $e) {

		    echo 'Exception when calling SMSApi->smsSendPost: ', $e->getMessage(), PHP_EOL;

		}

    }



    function distanceCalculete($latitude1, $longitude1, $latitude2, $longitude2) 
	{		
		/*echo $latitude1.'---'.$longitude1.'---'.$latitude2.'---'.$longitude2;die;*/
		$unit = 'miles';
 		$theta = $longitude1 - $longitude2; 
		$distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta))); 
		$distance = acos($distance); 
		$distance = rad2deg($distance); 
		$miles = $distance * 60 * 1.1515;
		$distance_new = $miles * 1.609344; 
		/*$distance = $distance * 1.609344;*/ 
		return (round($distance_new,2));
	}



	

}

?>