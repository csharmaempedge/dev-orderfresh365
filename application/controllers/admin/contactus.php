<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Contactus extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		if(!empty(MODULE_NAME))
		{
			$this->load->model(MODULE_NAME.'contactus_model');
		}
	}

	public function index()
	{
		if($this->checkViewPermission())
		{			
			$this->show_view(MODULE_NAME.'contactus/contactus_view', $this->data);
		}
		else
		{	
			redirect( base_url().MODULE_NAME.'dashboard/error/1');
		}
    }

    public function loadContactusListData()
    {
    	$contactus_list = $this->contactus_model->getAllContactusList();
    	$data = array();
        $no = $_POST['start'];
        foreach ($contactus_list as $res) 
	    {
			$no++;
			$row   = array();
			$row[] = $no;
			$row[] = $res->contact_us_name;
			$row[] = $res->contact_us_phone_no;
			$row[] = $res->contact_us_email;
			$row[] = $res->contact_us_subject;
			$row[] = $res->contact_us_message;
            $data[] = $row;
        }

        $output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => count($contactus_list),
			"recordsFiltered" => $this->contactus_model->count_contactusfiltered(),
			"data" => $data,
		);
       	//output to json format
       	echo json_encode($output);
    }

}

/* End of file */?>