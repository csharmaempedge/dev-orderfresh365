<?php
class Coupon_model extends CI_Model{
	function __construct(){
       parent::__construct();
	   $this->load->database();
	}

	private function _get_query($param1 = NULL){  
		$column_order = array(null,null,'coupon_code_name');
	    $column_search = array('coupon_code_name');
    	$sql = array();
    	$f_sql = '';
    	$order_by = 'coupon_code_id DESC'; 
		$sql[] = "coupon_code_status != '2'";
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
				return "SELECT * FROM `tbl_coupon_code` WHERE $f_sql ORDER BY $order_by LIMIT $limit OFFSET $offset";
            }
            else{
				return "SELECT * FROM `tbl_coupon_code` ORDER BY $order_by LIMIT $limit OFFSET $offset";	
            }
       	}  
       	else{
       		if($f_sql){
				return "SELECT * FROM `tbl_coupon_code` WHERE $f_sql ORDER BY $order_by";
            }
            else{	
				return "SELECT * FROM `tbl_coupon_code` ORDER BY $order_by";	
            }
       	}
    }

    public function count_filtered(){
       $query = $this->_get_query();
       return $result = $this->db->query($query)->num_rows();
    }

	public function getAllCouponList(){		
		$query = $this->_get_query('show_list');
       	return $result = $this->db->query($query)->result();
	}

	public function getUnitSumData($coupon_code_id, $energy_resources_id)
	{
		$this->db->select('SUM(row_material_es_unit_sum) as row_material_es_unit_sum');
		$this->db->from('tbl_coupon_code_row_material_calclulation');
		$this->db->where('coupon_code_id', $coupon_code_id);
		$this->db->where('energy_resources_id', $energy_resources_id);
		$query = $this->db->get();
		return $query->row() ;
	}
	public function getSubUnitSumData($coupon_code_id, $energy_resources_id)
	{
		$this->db->select('SUM(row_material_es_sub_unit_sum) as row_material_es_sub_unit_sum');
		$this->db->from('tbl_coupon_code_row_material_calclulation');
		$this->db->where('coupon_code_id', $coupon_code_id);
		$this->db->where('energy_resources_id', $energy_resources_id);
		$query = $this->db->get();
		return $query->row() ;
	}
}
?>
