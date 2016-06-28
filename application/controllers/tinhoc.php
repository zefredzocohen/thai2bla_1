<?php require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");

class Tinhoc extends Secure_area 
{	function __construct()	{		
		parent::__construct('Tinhoc');  
		$this->load->library('sale_lib');
		$this->load->library('receiving_lib');              
		//$this->load->model('Tinhocs');	
	}	
	function index()
	{		
		$config['base_url'] = site_url('Tinhoc/sorting');
		$config['total_rows'] = $this->Tinhocs->count_all();
		$config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20; 
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		
		$data['controller_name']=strtolower(get_class());

		$data['form_width']=$this->get_form_width();
		$data['form_height']=$this->get_form_height();
		$data['total_rows'] = $this->Tinhocs->count_all();
		$data['per_page'] = $config['per_page'];
		$data['manage_table']=get_tinhoc_manage_table($this->Tinhocs->get_all($data['per_page']),$this);
		
		$data['categories'] = $this->Tinhocs->get_all();
		$this->load->view('tinhoc/manage',$data);	
	}
	function suggest()
	{
		$suggestions = $this->Tinhocs->get_search_suggestions($this->input->get('term'),100);
		echo json_encode($suggestions);
	}
	
	
	function sorting()
	{
		$this->check_action_permission('search');
		$search=$this->input->post('search');
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		if ($search)
		{
			$config['total_rows'] = $this->Tinhocs->search_count_all($search);
			$table_data = $this->Tinhocs->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'chungchi_tinhoc' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		else
		{
			$config['total_rows'] = $this->Tinhocs->count_all();
			$table_data = $this->Tinhocs->get_all1($per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'chungchi_tinhoc' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		$config['base_url'] = site_url('tinhoc/sorting');
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_tinhoc_manage_table_data_rows($table_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));	
	}
	
	function search() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Tinhocs->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'chungchi_tinhoc', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        $config['base_url'] = site_url('tinhoc/search');
        $config['total_rows'] = $this->Tinhocs->search_count_all($search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_tinhoc_manage_table_data_rows($search_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }	
	
	function save($id_cat=-1)
	{
		$this->check_action_permission('add_update');		
		$item_data = array(
		'chungchi_tinhoc'=>$this->input->post('name_tinhoc'));
	
		if($this->Tinhocs->save($item_data,$id_cat))
		{
			//New item
			if($id_cat==-1)
			{
				echo json_encode(array('success'=>true,'message'=>lang('tinhoc_successful_adding').' '.
				$item_data['name_tinhoc'],'id_tinhoc'=>$item_data['id_tinhoc']));
				$id_cat = $item_data['id_tinhoc'];
			}
			
			else //previous item
			{
				echo json_encode(array('success'=>true,'message'=>lang('tinhoc_successful_updating').' '.
				$item_data['name_tinhoc'],'id_tinhoc'=>$id_cat));
			}

		}
		else//failure
		{
			echo json_encode(array('success'=>false,'message'=>lang('tinhoc_error_adding_updating').' '.
			$item_data['name_tinhoc'],'id_tinhoc'=>-1));
		}

	}	
	
	/*
	Gives search suggestions based on what is being searched for
	*/

	function get_row()
	{
		$id_cat = $this->input->post('row_id');
		$data_row=get_tinhoc_data_row($this->Tinhocs->get_info($id_cat),$this);
		echo $data_row;
	}

	function get_info($id_cat=-1)
	{
		echo json_encode($this->Tinhocs->get_info($id_cat));
	}	
	
	function view($id_cat=-1)
	{
		$this->check_action_permission('add_update');
		//$this->load->model('Tinhocs');
		$data = array();
		$data['tinhoc_info']=$this->Tinhocs->get_info($id_cat);
		$this->load->view("tinhoc/form",$data);
	}
	
	

	// dem so dong khi check all
	function Tinhocs_item_number_exists()
	{
		if($this->Tinhocs->account_number_exists($this->input->post('id_cat')))
		echo 'false';
		else
		echo 'true';
		
	}
	// function delete()
	// {

		// $this->check_action_permission('delete');		
		// $categories_to_delete=$this->input->post('ids');
		// $select_inventory=$this->get_select_inventory();
		// $total_rows= $select_inventory ? $this->Tinhocs->count_all1() : count($categories_to_delete);
			//clears the total inventory selection
		// $this->clear_select_inventory();
		// if($this->Tinhocs->delete_list($categories_to_delete))
		// {
			
			// echo json_encode(array('success'=>true,'message'=>lang('items_successful_deleted').' '.
			// $total_rows.' '.lang('items_one_or_multiple')));
		// }
		// else
		// {
			// echo json_encode(array('success'=>false,'message'=>lang('items_cannot_be_deleted')));
		// }
	// }
		function delete()
	{
		$giftcards_to_delete=$this->input->post('ids');

		if($this->Tinhocs->delete_db($giftcards_to_delete))
		{
			echo json_encode(array('success'=>true,'message'=>lang('tinhoc_successful_deleted')));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>lang('tinhoc_cannot_be_deleted')));
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
		
}?>