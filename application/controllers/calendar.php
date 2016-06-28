<?php 
require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");
class Calendar extends Secure_area {
	public function index()
	{
		//grid's view
		$this->load->view('calendar/index');
	}
	
}