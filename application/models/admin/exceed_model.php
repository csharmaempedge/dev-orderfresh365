<?php
class Exceed_model extends CI_Model 
{
	function __construct()
	{
       parent::__construct();
	   $this->load->database();
	}
	/*	Show all User */
	private function _get_query($param1 = NULL)
    {  
		$column_order = array(NULL,NULL, NULL, NULL, NULL,NULL);  
	    //set column field database for datatable searchable 
	    $order = array('cart_id' => 'ASC'); // default order 
    	$sql = array();
    	$f_sql = '';
    	$order_by = 'cart_id ASC';     
    	$group_by = 'patient_id';     
		$sql[] = "cart_approval_status != ''";
		if(isset($_POST['filter_by']) && $_POST['filter_by'] != '')
        {
            if($_POST['filter_by']['patient_id'] != '')
            {
                $patient_id   = $_POST['filter_by']['patient_id'];
                $sql[] = "patient_id = '".$patient_id."'";
            }
            if($_POST['filter_by']['cart_approval_status'] != '')
            {
                $cart_approval_status   = $_POST['filter_by']['cart_approval_status'];
                $sql[] = "cart_approval_status = '".$cart_approval_status."'";
            }
        }
		if(isset($_POST['order'])) // here order processing
		{
			$order_by = $column_order[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'];
		} 
		else
		{
			$order_by = 'cart_id ASC';
		}
		if(sizeof($sql) > 0)
		$f_sql = implode(' AND ', $sql);
		if($param1 == 'show_list' && isset($_POST["length"]) && $_POST["length"] != -1)  
       	{  
            $limit = $_POST['length'];
            $offset = $_POST['start'];
            if($f_sql)
            { 
				return "SELECT * FROM `tbl_cart` WHERE $f_sql GROUP BY $group_by LIMIT $limit OFFSET $offset";
            }
            else
            {
				return "SELECT * FROM `tbl_cart` GROUP BY $group_by LIMIT $limit OFFSET $offset";	
            }
       	}  
       	else
       	{
       		if($f_sql)
            {
				return "SELECT * FROM `tbl_cart` WHERE $f_sql GROUP BY $group_by";
            }
            else
            {	
				return "SELECT * FROM `tbl_cart` GROUP BY $group_by";	
            }
       	}
    }
    public function count_filtered()
    {
       $query = $this->_get_query();
       return $result = $this->db->query($query)->num_rows();
    }
	public function getAllExceedList($e_limit = NULL,$s_limit = NULL)
	{		
		$query = $this->_get_query('show_list');
       	return $result = $this->db->query($query)->result();
	}
}
?>