<?php
class Hrm extends CI_Controller 
{	
	public function index()
	{
		$this->load->view('timekeeping/manage');
	}
}
?>