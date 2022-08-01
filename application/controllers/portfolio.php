<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Portfolio extends My_Controller 
{
	function __construct()
	{
		parent::__construct();
        $this->load->model('home_model'); 
	}
	  
	public function index()
	{
		$this->show_view_front('front/portfolio', $this->data);
    }

    public function portfolioDetails()
	{
		$this->show_view_front('front/portfolio_details', $this->data);
    }

	
	
}