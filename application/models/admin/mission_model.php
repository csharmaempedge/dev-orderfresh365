<?php
class Mission_model extends CI_Model 
{
	function __construct()
	{
       parent::__construct();
	   $this->load->database();
	}
    /*========================================*/
    private function _get_missionquery($param1 = NULL)
    {  
        $sql = array();
        $f_sql = '';
        $order_by = 'mission_id ASC';
        $column_search = array('mission_title');
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
                return "SELECT *  FROM (`cm_mission`) WHERE $f_sql  ORDER BY $order_by LIMIT $limit OFFSET $offset";
            }
            else
            {
                return "SELECT *  FROM (`cm_mission`)  ORDER BY $order_by LIMIT $limit OFFSET $offset";        
            }
        }  
        else
        {
            if($f_sql)
            {
                return "SELECT *  FROM (`cm_mission`) WHERE $f_sql  ORDER BY $order_by";
            }
            else
            {
                return "SELECT *  FROM (`cm_mission`)  ORDER BY $order_by";    
            }
        }
    }

    function count_missionfiltered()
    {
       $query = $this->_get_missionquery();
       return $result = $this->db->query($query)->num_rows();
    }

    public function getAllMissionList()
    {
        $query = $this->_get_missionquery('show_list');
        return $result = $this->db->query($query)->result();
    }
}
?>
