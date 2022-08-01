<?php
class Profile_model extends CI_Model{
	function __construct(){
       parent::__construct();
	   $this->load->database();
	}

	public function updateProfile($post,$user_id){
		$this->db->where('user_id',$user_id);
		$this->db->update('tbl_user', $post);
		return true;
	}

	function getUserDetails($user_id){	
        $this->db->select('*');
		$this->db->from('tbl_user');	
		$this->db->where('user_id',$user_id);
		$this->db->where('user_status','1');
		$query = $this->db->get();		
		return $query->result(); ;
	}	
}
?>