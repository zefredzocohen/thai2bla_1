<?php
require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");
class Bangcap extends Secure_area{
		
		public function __construct()
		{
			parent::__construct();
			$this->load->library('sale_lib');
			$this->load->library('receiving_lib');   
			
			
		}
	function index()
	{		
		$config['base_url'] = site_url('bangcap/sorting');
		$config['total_rows'] = $this->Bangcaps->count_all();
		$config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20; 
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		
		$data['controller_name']=strtolower(get_class());

		$data['form_width']=$this->get_form_width();
		$data['form_height']=$this->get_form_height();
		$data['total_rows'] = $this->Bangcaps->count_all();
		$data['per_page'] = $config['per_page'];
		$data['manage_table']=get_bangcap_manage_table($this->Bangcaps->get_all($data['per_page']),$this);
		
		$data['bangcap'] = $this->Bangcaps->get_all();	
		$this->load->view('bangcap/manage',$data);	
	}//end index

	function save($id=-1)
	{
		$this->check_action_permission('add_update');		
		$item_data = array(
			'nam_bangcap'=>$this->input->post('name_bangcap')
		);
	
		if($this->Bangcaps->save($item_data,$id_cat))
		{
			//New item
			if($id_cat==-1)
			{
				echo json_encode(array('success'=>true,'message'=>lang('bangcap_successful_adding').' '.
				$item_data['nam_bangcap'],'id_bangcap'=>$item_data['id_bangcap']));
				$id_cat = $item_data['id_bangcap'];
			}
			
			else //previous item
			{
				echo json_encode(array('success'=>true,'message'=>lang('bangcap_successful_updating').' '.
				$item_data['nam_bangcap'],'id_bangcap'=>$id_cat));
			}

		}
		else//failure
		{
			echo json_encode(array('success'=>false,'message'=>lang('bangcap_error_adding_updating').' '.
			$item_data['nam_bangcap'],'id_bangcap'=>-1));
		}

	}	
	 function suggest()
	{
		$suggestions = $this->Bangcaps->get_search_suggestions($this->input->get('term'),100);
		echo json_encode($suggestions);
	}
	
	
	function sorting()
	{
		$this->check_action_permission('search');
		$search=$this->input->post('search');
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		if ($search)
		{
			$config['total_rows'] = $this->Bangcaps->search_count_all($search);
			$table_data = $this->Bangcaps->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'nam_bangcap' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		else
		{
			$config['total_rows'] = $this->Bangcaps->count_all();
			$table_data = $this->Bangcaps->get_all($per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'nam_bangcap' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		$config['base_url'] = site_url('bangcap/sorting');
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_bangcap_manage_table_data_rows($table_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));	
	}
	
	function search() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Bangcaps->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'nam_bangcap', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        $config['base_url'] = site_url('bangcap/search');
        $config['total_rows'] = $this->Bangcaps->search_count_all($search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_bangcap_manage_table_data_rows($search_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }	
	
	
	/*
	Gives search suggestions based on what is being searched for get_bangcap_manage_table_data_rows
	*/
	// function suggest_category()
	// {
	// 	$suggestions = $this->Category->get_category_suggestions($this->input->get('term'));
	// 	echo json_encode($suggestions);
	// }

	function get_row()
	{
		$id_cat = $this->input->post('row_id');
		$data_row=get_bangcap_data_row($this->Bangcaps->get_info($id_cat),$this);
		echo $data_row;
	}

	function get_info($id=-1)
	{
		echo json_encode($this->Bangcaps->get_info($id));
	}	
	
	function view($id=-1)
	{
		$this->check_action_permission('add_update');
		//$this->load->model('Category');
		$data = array();
		$data['item_info']=$this->Bangcaps->get_info($id);
		$this->load->view("bangcap/form",$data);
	}
	
	

	// dem so dong khi check all
	function category_item_number_exists()
	{
		if($this->Category->account_number_exists($this->input->post('id_cat')))
		echo 'false';
		else
		echo 'true';
		
	}
	function delete()
	{

		$this->check_action_permission('delete');		
		$categories_to_delete=$this->input->post('ids');
		$select_inventory=$this->get_select_inventory();
		$total_rows= $select_inventory ? $this->Category->count_all1() : count($categories_to_delete);
		//clears the total inventory selection
		$this->clear_select_inventory();
		if($this->Category->delete_list($categories_to_delete))
		{
			
			echo json_encode(array('success'=>true,'message'=>lang('items_successful_deleted').' '.
			$total_rows.' '.lang('items_one_or_multiple')));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>lang('items_cannot_be_deleted')));
		}
	}
	//khi chon all thong bao all so mat hang
	function select_inventory() 
	{
		$this->session->set_userdata('select_inventory', 1);
	}
	
	function get_select_inventory() 
	{
		return $this->session->userdata('select_inventory') ? $this->session->userdata('select_inventory') : 0;
	}

	function clear_select_inventory() 	
	{
		$this->session->unset_userdata('select_inventory');
		
	}
	
	
	function get_form_width()
	{
		return 500;
	}
	function get_form_height(){
		return 300;
	}
		
	}//End Class bangcap
?>