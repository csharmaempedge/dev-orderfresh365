<?php
class Product_model extends CI_Model{
	function __construct(){
       parent::__construct();
	   $this->load->database();
	}


	private function _get_query($param1 = NULL){  

		$column_order = array(null,'product_name','category_id','product_status');

	    $column_search = array('product_name');

    	$sql = array();

    	$f_sql = '';
    	if(isset($_POST['filter_by']) && $_POST['filter_by'] != '')
        {
            if($_POST['filter_by']['category_id'] != '')
            {
                $category_id   = $_POST['filter_by']['category_id'];
                $sql[] = "category_id = '".$category_id."'";
            }
            if($_POST['filter_by']['product_status'] != '')
            {
                $product_status   = $_POST['filter_by']['product_status'];
                $sql[] = "product_status = '".$product_status."'";
            }
        }
    	$order_by = 'product_id DESC'; 

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



    public function count_filtered(){

       $query = $this->_get_query();

       return $result = $this->db->query($query)->num_rows();

    }



	public function getAllProductList(){		

		$query = $this->_get_query('show_list');

       	return $result = $this->db->query($query)->result();

	}
}
?>