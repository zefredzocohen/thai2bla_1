<?php
require_once(APPPATH . 'third_party/Classes/PHPExcel/IOFactory.php');
require_once(APPPATH . 'libraries/php-excel.class.php');
require_once ("secure_area.php");
class Accountings extends Secure_area 
{
	function __construct()
	{
		parent::__construct('');
	}
	

	function index()
	{	
        $this->load->view('accountings/manage');
        //redirect('costs');
	}
	function account_reports()
	{	
        $this->load->view('accountings/manage');
	}
    function get_form_width()
	{
		return 550;
	}
    function tien(){	
        $this->load->view('accountings/tien');
	}
    function mua_hang(){	
        $this->load->view('accountings/mua_hang');
	}    
    function ban_hang(){	
        $this->load->view('accountings/ban_hang');
	}       
    function hang_ton_kho(){	
        $this->load->view('accountings/hang_ton_kho');
	} 
    function thue(){	
        $this->load->view('accountings/thue');
	}    
    function tong_hop(){	
        $this->load->view('accountings/tong_hop');
	}    
    
    
}
?>