<?php
class Home_model extends CI_Model {
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

	function get_search_member($keyword=null,$member_solo_group_status=''){
        $this->db->select('*');
        $this->db->from('cm_member');
        $column_search = array('member_name', 'member_tags', 'member_about', 'member_education', 'member_work');
        if(!empty($keyword)){
            $search_arr = array();
            foreach ($column_search as $cmn){
                $search_arr[] = '('.$cmn.' LIKE '. "'".$keyword."%'" . ' OR  '.$cmn.' LIKE ' . "'%".$keyword."%'".' OR '.$cmn.' LIKE ' . "'%".$keyword."'".')';
            }       
            if(!empty($search_arr)){
                $where= '('.implode(' OR ', $search_arr).')';
                $this->db->where($where);
            }
        }
        if(!empty($member_solo_group_status)){
            $this->db->like('member_solo_group_status', $member_solo_group_status); 
        }
        $this->db->where('member_status','1');
        $this->db->order_by('member_id','ASC');
        $query = $this->db->get();
        /*echo $this->db->last_query();die;*/
        return $query->result();
    }

    function searchWithMemberFilter($min_age,$max_age,$country_id,$state_id,$member_language,$member_gender,$member_sexuality,$relationship_id,$member_work,$member_education,$status_type){
        $this->db->select('*');
        $this->db->from('cm_member');
        if(!empty($min_age)){
            $this->db->where('member_age BETWEEN "'.$min_age.'" and "'.$max_age.'"');
        }
        if(!empty($country_id)){
            $this->db->where('country_id',$country_id);
        }if(!empty($state_id)){
            $this->db->where('state_id',$state_id);
        }if(!empty($member_language)){
            $where_s = "FIND_IN_SET('".$member_language."', member_language)";
            $this->db->where($where_s);
        }if(!empty($member_gender)){
            $this->db->where('member_gender',$member_gender);
        }if(!empty($member_sexuality)){
            $this->db->where('member_sexuality',$member_sexuality);
        }if(!empty($relationship_id)){
            $this->db->where('relationship_id',$relationship_id);
        }if(!empty($member_work)){
            $this->db->where('member_work',$member_work);
        }if(!empty($member_education)){
            $this->db->where('member_education',$member_education);
        }
        if(!empty($status_type)){
            $this->db->where('live_chat_type',$status_type);
        }
        $this->db->where('member_status','1');
        /*$this->db->limit($limit);*/
        $this->db->order_by('member_id','ASC');
        $query = $this->db->get();
        /*echo $this->db->last_query();die;*/
        return $query->result();
    }
    function memberLogin($member_email, $member_password){		
        $this->db->select('member_id,member_name, member_email, member_password,member_status,member_profile_img,country_id,member_age,last_active_date,live_chat_type, member_paid_status');
		$this->db->from('cm_member');	
		$this->db->where('member_email',$member_email);
		$this->db->where('member_password',$member_password);
		/*$this->db->where('member_status','1');*/
		$query = $this->db->get();		
		return $query->row();
	}

    function get_search_menu($keyword=null,$limit){
        $this->db->select('*');
        $this->db->from('cm_menu');
        if(!empty($keyword)){
            $this->db->like("menu_name",$keyword);
        }
        $this->db->where('menu_status','1');
        $this->db->limit($limit);
        $this->db->order_by('menu_id','ASC');
        $query = $this->db->get();
        return $query->result();
    }
}
?>