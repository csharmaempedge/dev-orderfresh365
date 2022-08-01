<?php
class Dashboard_model extends CI_Model{
	function __construct(){
       parent::__construct();
	   $this->load->database();
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

	public function getProductAmount($unique_no)
	{
		$this->db->select('SUM(total_product_price) as total_product_price');
		$this->db->from('tbl_cart');
		$this->db->where('unique_no', $unique_no);
		$query = $this->db->get();
		return $query->row() ;
	}

	public function getOrderProductAmount($unique_no)
	{
		$this->db->select('SUM(total_product_price) as total_product_price');
		$this->db->from('tbl_order_product');
		$this->db->where('unique_no', $unique_no);
		$query = $this->db->get();
		return $query->row() ;
	}

	public function getOrderProductAmountFilter($unique_no,$start_date,$end_date)
	{
		$this->db->select('SUM(total_product_price) as total_product_price');
		$this->db->from('tbl_order_product');
		$this->db->where('order_product_created_date >=', $start_date);
		$this->db->where('order_product_created_date <= ', $end_date);
		$this->db->where('unique_no', $unique_no);
		$query = $this->db->get();
		return $query->row() ;
	}

	public function gettotalQty($patient_id)
	{
		$this->db->select('SUM(qty) as qty');
		$this->db->from('tbl_cart');
		$this->db->where('patient_id', $patient_id);
		$query = $this->db->get();
		return $query->row() ;
	}
	public function gettotalBreakfastQty($patient_id)
	{
		$this->db->select('SUM(qty) as qty');
		$this->db->from('tbl_breakfast_cart');
		$this->db->where('patient_id', $patient_id);
		$query = $this->db->get();
		return $query->row() ;
	}
}
?>
