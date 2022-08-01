<?php
class Vision_model extends CI_Model 
{
	function __construct()
	{
       parent::__construct();
	   $this->load->database();
	}
    /*========================================*/
    private function _get_visionquery($param1 = NULL)
    {  
        $sql = array();
        $f_sql = '';
        $order_by = 'vision_id ASC';
        $column_search = array('vision_title');
        $search_arr = array();
        foreach ($column_search as $cmn){
            if(isset($_POST["search"]["value"]) && $_POST["search"]["value"] != ''){
                $search_arr[] = '('.$cmn.' LIKE '. "'".$_POST["search"]["value"]."%'" . ' OR  '.$cmn.' LIKE ' . "'%".$_POST["search"]["value"]."%'".' OR '.$cmn.' LIKE ' . "'%".$_POST["search"]["value"]."'".')';
            }
        }       
        if(!empty($search_arr)){
            $sql[] = '('.implode(' OR ', $search_arr).')';
        }
        if(sizeof($sql) > 0)
        $f_sql = implode(' AND ', $sql);

        
        if($param1 == 'show_list' && isset($_POST["length"]) && $_POST["length"] != -1)  
        {  
            $limit = $_POST['length'];
            $offset = $_POST['start'];
            if($f_sql)
            {
                return "SELECT *  FROM (`cm_vision`) WHERE $f_sql  ORDER BY $order_by LIMIT $limit OFFSET $offset";
            }
            else
            {
                return "SELECT *  FROM (`cm_vision`)  ORDER BY $order_by LIMIT $limit OFFSET $offset";        
            }
        }  
        else
        {
            if($f_sql)
            {
                return "SELECT *  FROM (`cm_vision`) WHERE $f_sql  ORDER BY $order_by";
            }
            else
            {
                return "SELECT *  FROM (`cm_vision`)  ORDER BY $order_by";    
            }
        }
    }

    function count_visionfiltered()
    {
       $query = $this->_get_visionquery();
       return $result = $this->db->query($query)->num_rows();
    }

    public function getAllVisionList()
    {
        $query = $this->_get_visionquery('show_list');
        return $result = $this->db->query($query)->result();
    }
}
?>
