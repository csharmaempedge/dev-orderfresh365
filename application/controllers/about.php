<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About extends My_Controller 
{
	function __construct()
	{
		parent::__construct();
        $this->load->model('home_model'); 
	}
	  
	public function index()
	{
		$this->show_view_front('front/about', $this->data);
    }
	
	
}