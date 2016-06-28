<?php
class Website extends Secure_area
{
	function __construct()
	{
		parent::__construct('website');
	}
	
	function index()
	{		
				$this->load->view('website/register');		
	}
}
?>