<?php
require_once ("secure_area.php");
class Header extends Secure_area 
{
	function __construct()
	{
		parent::__construct();	
	}
	
	function index()
	{
		$data = array();
		$data['suspended_sales'] = $this->Sale->get_all_suspended()->result_array();
		$data['payment_date'] = $this->Sale->get_all_suspended_web()->result_array();
		$data['customer'] = $this->Customer->findBirthDate();
		$data['register_date'] = $this->Customer->finddateregister();
		$data['suspends_date'] = $this->Inventory->find_suspends_date();
		$this->load->view("partial/header");
	}
}
?>