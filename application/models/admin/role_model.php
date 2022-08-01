<?php
class Role_model extends CI_Model{
	function __construct(){
       parent::__construct();
	   $this->load->database();
	}


	/*	Show all  */
	private function _get_query($param1 = NULL)
    {  
    	$sql = array();
    	$f_sql = '';
    	$order_by = 'role_id ASC';   
    	$sql[] = "role_status != '2'";
    	$sql[] = "role_id != '1'";
		if(sizeof($sql) > 0)
		$f_sql = implode(' AND ', $sql);

		if($param1 == 'show_list' && isset($_POST["length"]) && $_POST["length"] != -1)  
       	{  
            $limit = $_POST['length'];
            $offset = $_POST['start'];
            if($f_sql)
            { 
				return "SELECT * FROM `tbl_role` WHERE $f_sql ORDER BY $order_by LIMIT $limit OFFSET $offset";
            }
            else
            {
				return "SELECT * FROM `tbl_role` ORDER BY $order_by LIMIT $limit OFFSET $offset";	
            }
       	}  
       	else
       	{
       		if($f_sql)
            {
				return "SELECT * FROM `tbl_role` WHERE $f_sql ORDER BY $order_by";
            }
            else
            {	
				return "SELECT * FROM `tbl_role` ORDER BY $order_by";	
            }
       	}
    }

    function count_filtered()
    {
       $query = $this->_get_query();
       return $result = $this->db->query($query)->num_rows();
    }

	public function getAllRoleList($e_limit = NULL,$s_limit = NULL,$cat_id = '')
	{		
		$query = $this->_get_query('show_list');
       	return $result = $this->db->query($query)->result();
	}

	function getAllTabs(){
		$this->db->select('*');
		$this->db->from('tbl_sidebar_tabs');	
		$this->db->where('status', '1');
		$this->db->order_by('tab_number', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

	public function getLastRole(){
		$this->db->select('*');
		$this->db->from('tbl_role'); 
		$this->db->order_by('role_id', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->result() ;
	}

	function addRolePermission($post_permission){
		$this->db->insert('tbl_user_permission', $post_permission);
		$this->result = $this->db->insert_id() ; 
		return $this->result ;
	}

	public function addRole($post){
		$this->db->insert('tbl_role', $post);
		$this->result = $this->db->insert_id() ; 
		return $this->result ;
	}

	public function editRole($role_id){
		$this->db->select('*');
		$this->db->from('tbl_role');
		$this->db->where('role_id', $role_id);
		$query = $this->db->get();
		return $query->result();
	}
	
	function getRolePermissionByRoleID($role_id){
		$this->db->select('a.*,b.*');
		$this->db->from('tbl_user_permission a');
		$this->db->join('tbl_sidebar_tabs b','a.tab_id = b.tab_id','inner');
		$this->db->where('a.role_id', $role_id);
		$this->db->order_by('b.tab_number', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

	public function updateRole($post, $role_id){	
		$this->db->where('role_id', $role_id);
		$this->db->update('tbl_role', $post);
		return true;
	}

	public function updateRolePermission($post_permission, $user_permission_id){	
		$this->db->where('user_permission_id', $user_permission_id);
		$this->db->update('tbl_user_permission', $post_permission);
		return true;
	}

	public function getAllRole(){
		$this->db->select('*');
		$this->db->from('tbl_role'); 
		$this->db->where('role_id !=', '1');
		$this->db->where('role_status !=', '2');
		$this->db->order_by('role_level', 'DESC');
		$center_id_str = $this->data['session']->center_id;
		if($center_id_str != '0'){
			$center_id = substr($center_id_str, 2, 10);
			$find_set = "FIND_IN_SET('".$center_id."', center_id)";
			$this->db->where($find_set);
		}
		$query = $this->db->get();
		return $query->result() ;
	}

	function getAllSidebarTabValue(){
		$this->db->select('*');
		$this->db->from('tbl_sidebar_tabs');	
		$this->db->where('status', '1');
		$this->db->order_by('tab_number', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

	function getSidebarPermissionVal($tab_id, $role_id){
		$this->db->select('*');
		$this->db->from('tbl_user_permission');	
		$this->db->where('role_id', $role_id);
		$this->db->where('tab_id', $tab_id);
		$query = $this->db->get();
		return $query->row();
	}

	public function deleteRolePermission($post_permission, $role_id){	
		$this->db->where('role_id', $role_id);
		$this->db->update('tbl_user_permission', $post_permission);
		return true;
	}

	function delete_role($role_id){
		$this->db->delete('tbl_role', array('role_id' => $role_id));		
		return 1;		
	}

	function delete_rolePermissions($role_id){
		$this->db->delete('tbl_user_permission', array('role_id' => $role_id));		
		return 1;		
	}
}
?>
