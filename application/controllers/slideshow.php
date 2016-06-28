<?php
require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");
class Slideshow extends Secure_area {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('slideshows');
	}
	function index()
	{		
		//$config['base_url'] = site_url('categories/sorting');
		//$config['total_rows'] = $this->Category->count_all();
		//$config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20; 
		//$this->pagination->initialize($config);
		//$data['pagination'] = $this->pagination->create_links();
		
		$data['controller_name']=strtolower(get_class());

		//$data['form_width']=$this->get_form_width();
		//$data['form_height']=$this->get_form_height();
		//$data['total_rows'] = $this->slideshows->count_all();
		//$data['per_page'] = $config['per_page'];
		//$data['manage_table']=get_slide_manage_table($this->slideshows->get_all());
		
		$data['slides'] = $this->slideshows->get_all();	
		print_r($this->slideshows->get_all());
		$this->load->view('slideshow/manage',$data);	
	}
	// function suggest()
	// {
	// 	$suggestions = $this->Category->get_search_suggestions($this->input->get('term'),100);
	// 	echo json_encode($suggestions);
	// }
	// function item_search()
	// {
	// 	$suggestions = $this->Category->get_category_search_suggestions($this->input->get('term'),100);
	// 	echo json_encode($suggestions);
	// }
	
	// function sorting()
	// {
	// 	$this->check_action_permission('search');
	// 	$search=$this->input->post('search');
	// 	$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
	// 	if ($search)
	// 	{
	// 		$config['total_rows'] = $this->Category->search_count_all($search);
	// 		$table_data = $this->Category->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
	// 	}
	// 	else
	// 	{
	// 		$config['total_rows'] = $this->Category->count_all();
	// 		$table_data = $this->Category->get_all1($per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
	// 	}
	// 	$config['base_url'] = site_url('categories/sorting');
	// 	$config['per_page'] = $per_page; 
	// 	$this->pagination->initialize($config);
	// 	$data['pagination'] = $this->pagination->create_links();
	// 	$data['manage_table']=get_categories_manage_table_data_rows($table_data,$this);
	// 	echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));	
	// }
	

}

/* End of file slideshow.php */
/* Location: ./application/controllers/slideshow.php */