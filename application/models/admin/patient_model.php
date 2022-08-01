<?php
class Patient_model extends CI_Model{
	function __construct(){
       parent::__construct();
	   $this->load->database();
	}

	private function _get_query($param1 = NULL){  
		$column_order = array(null,null,'user_fname', 'user_email', 'user_mobile_no');
	    $column_search = array('user_fname', 'user_email', 'user_mobile_no', 'user_dob');
    	$sql = array();
    	$f_sql = '';
    	$order_by = 'user_id DESC'; 
		$sql[] = "role_id = '4'";
		$sql[] = "user_type = 'admin'";
		$sql[] = "user_status != '2'";
		$sql[] = "doctor_id = '0'";
    	$search_arr = array();
    	foreach ($column_search as $cmn){
	        if(isset($_POST["search"]["value"]) && $_POST["search"]["value"] != ''){
				$search_arr[] = '('.$cmn.' LIKE '. "'".$_POST["search"]["value"]."%'" . ' OR  '.$cmn.' LIKE ' . "'%".$_POST["search"]["value"]."%'".' OR '.$cmn.' LIKE ' . "'%".$_POST["search"]["value"]."'".')';
			}
		}       
		if(!empty($search_arr)){
			$sql[] = '('.implode(' OR ', $search_arr).')';
    	}
		if(isset($_POST['order'])){
			$order_by = $column_order[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'];
		}
		if(sizeof($sql) > 0){
			$f_sql = implode(' AND ', $sql);
		}
		if($param1 == 'show_list' && isset($_POST["length"]) && $_POST["length"] != -1){  
            $limit = $_POST['length'];
            $offset = $_POST['start'];
            if($f_sql){ 
				return "SELECT * FROM `tbl_user` WHERE $f_sql ORDER BY $order_by LIMIT $limit OFFSET $offset";
            }
            else{
				return "SELECT * FROM `tbl_user` ORDER BY $order_by LIMIT $limit OFFSET $offset";	
            }
       	}  
       	else{
       		if($f_sql){
				return "SELECT * FROM `tbl_user` WHERE $f_sql ORDER BY $order_by";
            }
            else{	
				return "SELECT * FROM `tbl_user` ORDER BY $order_by";	
            }
       	}
    }

    public function count_filtered(){
       $query = $this->_get_query();
       return $result = $this->db->query($query)->num_rows();
    }

	public function getAllUserList($e_limit = NULL,$s_limit = NULL){		
		$query = $this->_get_query('show_list');
       	return $result = $this->db->query($query)->result();
	}

	public function editUser($user_id){
		$this->db->select('*');
		$this->db->from('tbl_user');
		$this->db->where('user_id', $user_id);
		$query = $this->db->get();
		return $query->result();
	}

	public function updateUser($post,$user_id){ 
		$this->db->where('user_id',$user_id);
		$this->db->update('tbl_user', $post);
		return true;
	}

	public function addUser($post){
		$this->db->insert('tbl_user', $post);
		$this->result = $this->db->insert_id() ; 
		return $this->result ;
	}

	public function addUserLogin($post){
		$this->db->insert('com_user_login_tbl', $post);
		$this->result = $this->db->insert_id() ; 
		return $this->result ;
	}

	public function patientWiseEngery($energy_resources_id_arr)
    {
        $this->db->select('*');
        $this->db->from('tbl_energy_resources');
        $this->db->where_not_in('energy_resources_id', $energy_resources_id_arr); 
        $query = $this->db->get();
        return $query->result();
    }
}
?>
