<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Map extends My_Controller 

{

	function __construct()

	{

		parent::__construct();

        $this->load->model('admin/doc_patient_model'); 

	}

	  

    

    public function index()

	{

		$this->show_view_front('front/map', $this->data);

    }

	

}