<?php
require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");
class Web extends Secure_area 
{	
	public function index()
	{
		$this->load->view('web/manage');
	}
}
?>