<?php 
require_once ("secure_area.php");
class showrooms extends Secure_area 
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('sale_lib');
	}
	function index($customer_id){
			$this->sale_lib->set_customer($customer_id);	
		$data['customer_info']=$this->Customer->get_info($this->sale_lib->get_customer());
	$this->load->view('showrooms/view',$data);
	}
}
?>