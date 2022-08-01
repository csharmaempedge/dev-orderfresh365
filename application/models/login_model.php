<?php
class Login_model extends CI_Model {
	function __construct(){
       parent::__construct();
	   $this->load->database();
	}

	function checkUserLogin($data){
		$user_name = $data['user_name'];		
		$user_password = $data['user_password'];		
        $this->db->select('*');
		$this->db->from('com_user_login_tbl');	
		$this->db->where('user_name like binary',$user_name);
		$this->db->where('user_password',$user_password);
		$this->db->where('user_status','1');
		$query = $this->db->get();		
		return $query->row();
	}

	function checkUserDetails($data){
		$user_name = $data->user_name;		
		$user_password = $data->user_password;		
		$tbl_name = $data->tbl_name;
		if(!empty($tbl_name)){			
			$this->db->select('*');
			$this->db->from($tbl_name);
			$this->db->where('user_name',$user_name);
			$this->db->where('user_password',$user_password);
			$this->db->where('user_status','1');
			$query = $this->db->get();
			return $query->result();
		}
		else{
			return $data;
		}
	}
}
?>