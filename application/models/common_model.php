<?php

class Common_model extends CI_Model{	

	public function getTabIdByRolePermission($role_id){

		$this->db->select('a.*, b.*');

		$this->db->from('tbl_user_permission a'); 

		$this->db->join('tbl_sidebar_tabs b','a.tab_id = b.tab_id','inner');

		$this->db->where('a.role_id', $role_id);

		$this->db->where('a.userView', '1');

		$this->db->where('b.status', '1');

		$this->db->where('b.tab_id !=', '1');

		$this->db->order_by('b.tab_number', 'ASC');

		$query = $this->db->get();

		return $query->result() ;

	}



	public function getAllParentRole($role_id, $tbl_prefix){

		$this->db->select('a.*, b.*');

		$this->db->from($tbl_prefix.'user_permission a'); 

		$this->db->join($tbl_prefix.'sidebar_tabs b','a.tab_id = b.tab_id','inner');

		$this->db->where('a.role_id', $role_id);

		$this->db->where('a.user_permission_status', '1');

		$this->db->order_by('b.tab_number', 'ASC');

		$query = $this->db->get();

		return $query->result() ;

	}



	public function getAllTabAsPerRole($role_id, $tbl_prefix){

		$this->db->select('a.*, b.*');

		$this->db->from($tbl_prefix.'user_permission a'); 

		$this->db->join($tbl_prefix.'sidebar_tabs b','a.tab_id = b.tab_id','inner');

		$this->db->where('a.role_id', $role_id);

		$this->db->where('a.user_permission_status', '1');

		$this->db->order_by('b.tab_number', 'ASC');

		$query = $this->db->get();

		return $query->result() ;

	}



	public function getSubmenuById($child_id, $user_tbl_prefix){

		$this->db->select('*');

		$this->db->from($user_tbl_prefix.'sidebar_tabs');

		$this->db->where('child_id', $child_id);

		$this->db->where('status', 1);

		$this->db->order_by('tab_number', 'ASC');

		$query = $this->db->get();	

		return $query->result() ;

	}



	public function getAllCountry(){

		$this->db->select('*');

		$this->db->from('tbl_country');

		$this->db->where('country_status', '1');

		$this->db->where('country_id', '223');

		$query = $this->db->get();

		return $query->result() ;

	}



	public function getAllState(){

		$this->db->select('*');

		$this->db->from('tbl_state');

		$this->db->where('state_status', '1');

		$this->db->where('country_id', '99');

		$query = $this->db->get();

		return $query->result() ;

	}



	public function getStateListByCountryID($country_id){

		$this->db->select('*');

		$this->db->from('tbl_state');

		$this->db->where('state_status', '1');

		$this->db->where('country_id', $country_id);

		$query = $this->db->get();

		return $query->result() ;

	}



	public function checkUniqueValue($table_name,$column_name,$value, $column_name_id, $value_id){

		$this->db->select('*');

		$this->db->from($table_name);

		$this->db->where($column_name, $value);

		$this->db->where($column_name_id.' !=', $value_id);

		$query = $this->db->get();

		return $query->row() ;

	}

	public function checkUniqueValueNew($table_name,$column_name,$value, $column_name_id, $value_id, $column_status){

		$this->db->select('*');

		$this->db->from($table_name);

		$this->db->where($column_name, $value);

		$this->db->where($column_name_id.' !=', $value_id);
		$this->db->where($column_status.' !=', 2);

		$query = $this->db->get();

		return $query->row() ;

	}



	public function getAllRole(){

		$this->db->select('*');

		$this->db->from('it_role');

		$this->db->where('role_status', '1');

		$this->db->where('role_id !=', '1');

		$query = $this->db->get();

		return $query->result() ;

	}



	public function commonLoginTableUpdate($post,$user_id){ 

		$this->db->where('user_id',$user_id);

		$this->db->update('com_user_login_tbl', $post);

		return true;

	}



	public function addData($table_name , $post){

		$this->db->insert($table_name, $post);

		$this->result = $this->db->insert_id() ; 

		return $this->result;

	}



	public function getData($tbl_name , $where_array = NULL , $fetch_type = 'multi', $find_set = NULL, $order_by = NULL , $limit = NULL, $group_by = NULL){

		$this->db->select('*');

		$this->db->from($tbl_name);

		if($where_array != NULL){

			$this->db->where($where_array);

		}

		if($find_set != NULL){

			$this->db->where($find_set);

		}

		if($order_by != NULL){

			$this->db->order_by($order_by);

		}	

		if($group_by != NULL){

			$this->db->group_by($group_by);

		}	

		if($limit != NULL){

			$this->db->limit($limit);

		}

		$query = $this->db->get();

		if($fetch_type == 'single'){

			return $query->row();

		}

		else if( $fetch_type == 'multi'){

			return $query->result();

		}

		else if( $fetch_type == 'array'){

			return $query->result_array();

		}

		else if( $fetch_type == 'count'){

			return $query->num_rows();

		}

	}



	public function deleteData($table_name = '' , $where_array = ''){

		if($table_name != '' && $where_array != ''){

			$this->db->delete($table_name,$where_array);		

			return true;	

		}

		else{

			return false;

		}

	}



	public function updateData($table_name , $where_array , $post){

		$this->db->where($where_array);

		$this->db->update($table_name, $post);

		return true;

	}



	public function checkDistanceRange($total_distance)

	{

	    $this->db->select('*');

	    $this->db->from('tbl_distance');

	    $this->db->where('distance_range_start <=', $total_distance);

	    $this->db->where('distance_range_end >=', $total_distance);

	    $query = $this->db->get();

	    /*echo $this->db->last_query();*/

	    return $query->row() ;

	}



	public function productWiseVeggies($product_id, $macro_id){

		$this->db->select('a.*, b.*');

		$this->db->from('tbl_product_wise_veggies a'); 

		$this->db->join('tbl_product b','a.assign_product_id = b.product_id','inner');

		$this->db->where('b.product_status', '1');
		$this->db->where('a.product_id', $product_id);

		$this->db->where('a.macro_id', '3');

		$query = $this->db->get();

		return $query->result() ;

	}

	public function productWiseCarb($product_id, $macro_id){

		$this->db->select('a.*, b.*');

		$this->db->from('tbl_product_wise_veggies a'); 

		$this->db->join('tbl_product b','a.assign_product_id = b.product_id','inner');
		$this->db->where('b.product_status', '1');
		$this->db->where('a.product_id', $product_id);

		$this->db->where('a.macro_id', '2');

		$query = $this->db->get();

		return $query->result() ;

	}

}

?>

