<?php
  class Controller_demo1 extends CI_Controller
  {	
  	public function __construct()
	  	{
	  		parent::__construct();
	  	}
	 public function index(){
	 
	 	$this->load->view('employees/form');
	 }
	 public function upload_file(){
	 	$config=array(
	 		'upload_path'=>'./file',
	 		'allowed_types'=>'jpg|jpeg|png|gif|doc|docx',
	 	);
	 	$this->load->library('upload',$config);
	 	if(!$this->upload->do_upload('userfile')){
	 		$error=array(
	 			'errors'=>$this->upload->display_errors(),
	 	);
	 		$this->load->view('employees/form',$error);
	 	}
	 	else{
	 		$file_data=$this->upload->data();
	 		//$data['img']=base_url().'/file/'.$file_data['file_name'];
	 		$this->load->view('controller_demo/success_upload',$data);

	 	}
	 }
  } 
?>