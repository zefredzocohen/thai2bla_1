<?php 
require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");
class Visa extends Secure_area {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('sale_lib');
		$this->load->library('receiving_lib');  
	}
	public function index()
	{	$config['base_url'] = site_url('visa/sorting');
		$config['total_rows'] = $this->Visas->count_all();
	
		$config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20; 
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		
		$data['controller_name']=strtolower(get_class());

		$data['form_width']=$this->get_form_width();
		$data['form_height']=$this->get_form_height();
		$data['total_rows'] = $this->Visas->count_all();
		$data['per_page'] = $config['per_page'];
		$data['manage_table']=get_visa_manage_table($this->Visas->get_all($data['per_page']),$this);
		
		$data['visa'] = $this->Visas->get_all();	
		$this->load->view('visa/manage', $data);
	}//End index
	
	function save($id_cat=-1)
	{
		$this->check_action_permission('add_update');		
		$item_data = array(
			'name_visa'=>$this->input->post('name_visa')
			);
	
		if($this->Visas->save($item_data,$id_cat))
		{
			//New item
			if($id_cat==-1)
			{
				echo json_encode(array('success'=>true,'message'=>lang('visa_successful_adding').' '.
				$item_data['name_visa'],'id_visa'=>$item_data['id_visa']));
				$id_cat = $item_data['id_visa'];
			}
			
			else //previous item
			{
				echo json_encode(array('success'=>true,'message'=>lang('visa_successful_updating').' '.
				$item_data['name_visa'],'id_visa'=>$id_cat));
			}

		}
		else//failure
		{
			echo json_encode(array('success'=>false,'message'=>lang('visa_error_adding_updating').' '.
			$item_data['name_visa'],'id_visa'=>-1));
		}

	}	//Save
	function get_info($id=-1)
	{
		echo json_encode($this->Visas->get_info($id));
	}//End thông tin	
	function sorting()
	{
		$this->check_action_permission('search');
		$search=$this->input->post('search');
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		if ($search)
		{
			$config['total_rows'] = $this->Visas->search_count_all($search);
			$table_data = $this->Visas->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name_visa' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		else
		{
			$config['total_rows'] = $this->Visas->count_all();
			$table_data = $this->Visas->get_all($per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name_visa' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		$config['base_url'] = site_url('visa/sorting');
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_visa_manage_table_data_rows($table_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));	
	}
	function search()
	{
		$this->check_action_permission('search');
		$search=$this->input->post('search');
		//$cat=$this->input->post('cat');
		$per_page= 50;
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		
		$search_data=$this->Visas->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name_visa' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		$config['base_url'] = site_url('visa/search');
		$config['total_rows'] = $this->Visas->search_count_all($search,$cat);
		$config['per_page'] = $per_page ;
		$this->pagination->initialize($config);				
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_visa_manage_table_data_rows($search_data,$this);

		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
		
	}
	function suggest()
	{
		$suggestions = $this->Visas->get_search_suggestions($this->input->get('term'),100);
		echo json_encode($suggestions);
	}
	function view($id=-1)
	{
		$this->check_action_permission('add_update');
		//$this->load->model('Category');
		$data = array();
		$data['item_info']=$this->Visas->get_info($id);
		$this->load->view("visa/form",$data);
	}// End Load Form
	
	function get_form_width()
	{
		return 500;
	}
	function get_form_height(){
		return 300;
	}

}

/* End of file visa.php */
/* Location: ./application/controllers/visa.php */