<?php
class Category_model extends CI_Model 
{
	function __construct()
	{
       parent::__construct();
	   $this->load->database();
	}
	/*	Show all User */
	private function _get_query($param1 = NULL)
    {  
		$column_order = array(null,'category_name', NULL, NULL, NULL); 
	    //set column field database for datatable orderable
	    $column_search = array('category_name'); 
	    //set column field database for datatable searchable 
	    $order = array('category_id' => 'ASC'); // default order 
    	$sql = array();
    	$f_sql = '';
    	$order_by = 'category_id ASC';     
		$sql[] = "category_status != '2'";
    	$search_arr = array();
    	foreach ($column_search as $cmn)
        {
	        if(isset($_POST["search"]["value"]) && $_POST["search"]["value"] != '')
			{
				$search_arr[] = '('.$cmn.' LIKE '. "'".$_POST["search"]["value"]."%'" . ' OR  '.$cmn.' LIKE ' . "'%".$_POST["search"]["value"]."%'".' OR '.$cmn.' LIKE ' . "'%".$_POST["search"]["value"]."'".')';
			}
		}       
		if(!empty($search_arr))
    	{
			$sql[] = '('.implode(' OR ', $search_arr).')';
    	} 
		if(isset($_POST['order'])) // here order processing
		{
			$order_by = $column_order[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'];
		} 
		else
		{
			$order_by = 'category_id ASC';
		}
		if(sizeof($sql) > 0)
		$f_sql = implode(' AND ', $sql);
		if($param1 == 'show_list' && isset($_POST["length"]) && $_POST["length"] != -1)  
       	{  
            $limit = $_POST['length'];
            $offset = $_POST['start'];
            if($f_sql)
            { 
				return "SELECT * FROM `tbl_category` WHERE $f_sql ORDER BY $order_by LIMIT $limit OFFSET $offset";
            }
            else
            {
				return "SELECT * FROM `tbl_category` ORDER BY $order_by LIMIT $limit OFFSET $offset";	
            }
       	}  
       	else
       	{
       		if($f_sql)
            {
				return "SELECT * FROM `tbl_category` WHERE $f_sql ORDER BY $order_by";
            }
            else
            {	
				return "SELECT * FROM `tbl_category` ORDER BY $order_by";	
            }
       	}
    }
    public function count_filtered()
    {
       $query = $this->_get_query();
       return $result = $this->db->query($query)->num_rows();
    }
	public function getAllCategoryList($e_limit = NULL,$s_limit = NULL)
	{		
		$query = $this->_get_query('show_list');
       	return $result = $this->db->query($query)->result();
	}

	private function _get_query_pp($param1 = NULL){  
		$column_order = array(null,null,'product_name');
	    $column_search = array('product_name');
    	$sql = array();
    	$f_sql = '';
    	$order_by = 'product_id DESC'; 
    	$category_id   = $_POST['category_id'];
        $sql[] = "category_id = '".$category_id."'";
		$sql[] = "product_status != '2'";
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
				return "SELECT * FROM `tbl_product` WHERE $f_sql ORDER BY $order_by LIMIT $limit OFFSET $offset";
            }
            else{
				return "SELECT * FROM `tbl_product` ORDER BY $order_by LIMIT $limit OFFSET $offset";	
            }
       	}  
       	else{
       		if($f_sql){
				return "SELECT * FROM `tbl_product` WHERE $f_sql ORDER BY $order_by";
            }
            else{	
				return "SELECT * FROM `tbl_product` ORDER BY $order_by";	
            }
       	}
    }

    public function count_filtered_pp(){
       $query = $this->_get_query_pp();
       return $result = $this->db->query($query)->num_rows();
    }

	public function getAllCategoryProductList(){		
		$query = $this->_get_query_pp('show_list');
       	return $result = $this->db->query($query)->result();
	}
}
?>