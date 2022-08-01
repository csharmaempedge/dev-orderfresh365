<?php
class Order_model extends CI_Model 
{
	function __construct()
	{
       parent::__construct();
	   $this->load->database();
	}
    /*========================================*/
    private function _get_query($param1 = NULL, $keyword = NULL)
    {
        $sql = array();
        $f_sql = '';
        $order_by = 'order_id DESC';
        $start_date = '';
        $end_date = '';
        $patient_id = $this->data['session']->user_id;
        if($patient_id !='2')
        {
            $sql[] = "patient_id = '".$patient_id."'";
        }
        if(isset($_POST['filter_by']) && $_POST['filter_by'] != '')
        {
			/**
			* sorting on columns **/
			$columns = array(0=> "", 1 => 'patient_id', 2 => 'order_no', 3 => 'total_qty', 4=> 'order_create_date');
			$order = isset($columns[$_POST['order'][0]['column']]) ? $columns[$_POST['order'][0]['column']] : "order_id";
			$dir = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : "DESC";
			$order_by = $order . " " . $dir;
			
			/**
			* search input value [ patient first name and last name, order no, total qty ] **/
			$orderNo = "";
			if($_POST['filter_by']['search'] != '')
            {
                $keyword   = $_POST['filter_by']['search'];
				$order_patient_id = $this->getPtientId($keyword); // get patient id form patient name from search input box
				if($order_patient_id != "")
				{
					$sql[] = "patient_id = '".$order_patient_id."'";
				}else{
					$sql[] = "order_no = '".$keyword."' OR total_qty = '".$keyword."'";
				}
            }

            if($_POST['filter_by']['order_patient_id'] != '')
            {
                $order_patient_id   = $_POST['filter_by']['order_patient_id'];
                $sql[] = "patient_id = '".$order_patient_id."'";
            }
            if($_POST['filter_by']['start_date'] != '')
            {
                $start_date   = $_POST['filter_by']['start_date'];
            }
            if($_POST['filter_by']['end_date'] != '')
            {
                $end_date   = $_POST['filter_by']['end_date'];
            }
            if(!empty($start_date) && !empty($end_date))
            {
                $start_date = date('Y-m-d', strtotime($start_date));
                $end_date   = date('Y-m-d', strtotime($end_date));
                $start_date = $start_date;
                $sql[] = "order_create_date >= '".$start_date."'";
                $end_date = $end_date;
                $sql[]  = "order_create_date <= '".$end_date."'";
            }
        }

        if(sizeof($sql) > 0)
        $f_sql = implode(' AND ', $sql);
        if($param1 == 'show_list' && isset($_POST["length"]) && $_POST["length"] > 0)
        {
            $limit = $_POST['length'];
            $offset = $_POST['start'];
            if($f_sql)
            {
                return "SELECT *  FROM (`tbl_order`) WHERE $f_sql ORDER BY $order_by LIMIT $limit OFFSET $offset";
            }
            else
            {
                return "SELECT *  FROM (`tbl_order`) ORDER BY $order_by LIMIT $limit OFFSET $offset";        
            }
        }else{
			if($f_sql)
            {
                return "SELECT *  FROM (`tbl_order`) WHERE $f_sql ORDER BY $order_by";
            }
            else
            {
                return "SELECT *  FROM (`tbl_order`) ORDER BY $order_by";    
            }
		}
    }

    function count_filtered()
    {
       $query = $this->_get_query();
       return $result = $this->db->query($query)->num_rows();
    }

    public function getAllOrderList($keyword=null)
    {
        $query = $this->_get_query('show_list', $keyword);
        return $result = $this->db->query($query)->result();
    }

    public function gettotalOrderQty($patient_id, $order_id)
    {
        $this->db->select('SUM(total_qty) as qty');
        $this->db->from('tbl_order');
        if(!empty($patient_id))
        {
            $this->db->where('patient_id', $patient_id);
        }
        $this->db->where('order_id', $order_id);
        $query = $this->db->get();
        return $query->row() ;
    }
    public function gettotalBreakfastOrderQty($patient_id, $order_id)
    {
        $this->db->select('SUM(qty) as qty');
        $this->db->from('tbl_breakfast_order');
        if(!empty($patient_id))
        {
            $this->db->where('patient_id', $patient_id);
        }
        $this->db->where('order_id', $order_id);
        $query = $this->db->get();
        return $query->row() ;
    }
	
	function getPtientId($pname)
	{
		$this->db->select('user_id');
        $this->db->from('tbl_user');
		$this->db->where('user_fname', $pname);
		$this->db->or_where('user_lname', $pname);
		$query = $this->db->get();
		if(!empty($query->row()))
			return $query->row()->user_id;
	}
	
	function getPtientPhoneNumber($patient_id)
	{
		$this->db->select('*');
        $this->db->from('tbl_user');
		$this->db->where('user_id', $patient_id);
		$query = $this->db->get();
		if(!empty($query->row()))
			return $query->row();
	}
}
?>
