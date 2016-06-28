<?php
	require_once ("secure_area.php");
	require_once ("interfaces/idata_controller.php");
class Salaryconfig extends Secure_area
{	
	function __construct()	
	{		
		parent::__construct('');  
        $this->_controller = 'salaryconfig';
	}	
	function index()
	{	
    	$this->check_action_permission('search');
		$config['base_url'] = site_url('salaryconfig/sorting');
		$config['total_rows'] = $this->Salaryconfigs->count_all();
		$config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20; 
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();		
		$data['controller_name']=strtolower(get_class());
		$data['form_width']=$this->get_form_width();
		$data['total_rows'] = $this->Salaryconfigs->count_all();
		$data['per_page'] = $config['per_page'];
		$data['manage_table']= get_salary_manage_table($this->Salaryconfigs->get_all($data['per_page']),$this);
	    $this->load->view('timekeeping/'.$this->_controller.'/index',$data);
	}

    //load form them and sua
	function view($id=-1)
	{
		$this->check_action_permission('add_update');
		$data['item_info'] = $this->Salaryconfigs->get_info($id);
		$this->load->view("timekeeping/salaryconfig/form",$data);

	}
	
	function get_info($id=-1)
	{
		echo json_encode($this->Salaryconfigs->get_info($id));
	}

	function save($id=-1)
	{
		$this->check_action_permission('add_update');		
		$item_data = array(
			'name'=>$this->input->post('name'),
			'description'=>$this->input->post('description'),
			'deleted'=> 0
        );
	
		if($this->Salaryconfigs->save($item_data,$id))
		{
			//New item
			if($id==-1)
			{
				echo json_encode(array('success'=>true,'message'=>lang('salaryconfig_successful_adding').' '.
				$item_data['name'],'id'=>$item_data['id']));
				$id = $item_data['id'];
			}
			
			else //previous item
			{
				echo json_encode(array('success'=>true,'message'=>lang('salaryconfig_successful_updating').' '.
				$item_data['name'],'id'=>$id));
			}

		}
		else//failure
		{
			echo json_encode(array('success'=>false,'message'=>lang('salaryconfig_error_adding_updating').' '.
			$item_data['name'],'id'=>-1));
		}

	}
	
	function sorting()
	{
		$this->check_action_permission('search');
		$search=$this->input->post('search');
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		if ($search)
		{
			$config['total_rows'] = $this->Salaryconfigs->search_count_all($search);
			$table_data = $this->Salaryconfigs->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		else
		{
			$config['total_rows'] = $this->Salaryconfigs->count_all();
			$table_data = $this->Salaryconfigs->get_all($per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		$config['base_url'] = site_url('salaryconfig/sorting');
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_salary_manage_table_data_rows($table_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));	
	}
		
	function search()
	{
		$this->check_action_permission('search');
		$search=$this->input->post('search');		
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		
		$search_data=$this->Salaryconfigs->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		$config['base_url'] = site_url('salaryconfig/search');
		
		$config['total_rows'] = $this->Salaryconfigs->search_count_all($search);
		$config['per_page'] = $per_page ;
		$this->pagination->initialize($config);				
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_salary_manage_table_data_rows($search_data,$this);

		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
		
		
	}
	
	/// - tro nhung tu tuowng tu trong he thong co san maf ng dung mun tim
	function suggest()
	{
		$suggestions = $this->Salaryconfigs->get_search_suggestions($this->input->get('term'),100);
		echo json_encode($suggestions);
	}
	
	function item_search()
	{
		$suggestions = $this->Salaryconfigs->get_category_search_suggestions($this->input->get('term'),100);
		echo json_encode($suggestions);
	}
	function get_row()
	{
		$id_cat = $this->input->post('row_id');
		$data_row=get_salary_data_row($this->Salaryconfigs->get_info($id_cat),$this);
		echo $data_row;
	}

	//delete
	function delete()
	{

		$this->check_action_permission('delete');		
		$categories_to_delete=$this->input->post('ids');
		$select_inventory=$this->get_select_inventory();
		$total_rows= $select_inventory ? $this->Salaryconfigs->count_all() : count($categories_to_delete);
		//clears the total inventory selection
		$this->clear_select_inventory();
		if($this->Salaryconfigs->delete_list($categories_to_delete))
		{
			
			echo json_encode(array('success'=>true,'message'=>lang('salaryconfig_successful_deleted').' '.
			$total_rows.' '.lang('salaryconfig_one_or_multiple')));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>lang('salaryconfig_cannot_be_deleted')));
		}
	}
	
	function get_select_inventory() 
	{
		return $this->session->userdata('select_inventory') ? $this->session->userdata('select_inventory') : 0;
	}
	
	function clear_select_inventory() 	
	{
		$this->session->unset_userdata('select_inventory');
		
	}
	//cleanup
	function cleanup()
	{
		$this->Salaryconfigs->cleanup();
		echo json_encode(array('success'=>true,'message'=>lang('salaryconfig_cleanup_sucessful')));
	}
	
	function get_form_width()
	{
		return 450;
	}
}
?>