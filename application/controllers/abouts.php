<?php
	require_once ("secure_area.php");
	require_once ("interfaces/idata_controller.php");
	
class Abouts extends Secure_area 
{	
	function __construct()	
	{		
		parent::__construct('abouts');  
		$this->load->library('sale_lib');
		$this->load->library('receiving_lib');              
		//$this->load->model('Slide');	
		
		
		
		
	}	
	function index()
	{		
		$this->check_action_permission('search');
		$config['base_url'] = site_url('abouts/sorting');
		$config['total_rows'] = $this->About->count_all();
		$config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20; 
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		
		$data['controller_name']=strtolower(get_class());

		$data['form_width']=$this->get_form_width();
		//$data['form_height']=$this->get_form_height();
		$data['total_rows'] = $this->About->count_all();
		$data['per_page'] = $config['per_page'];
		$data['manage_table']=get_abouts_manage_table($this->About->get_all($data['per_page']),$this);
		
		$this->load->view('about/manage',$data);	
	}
	//load form them and sua
	function view($id=-1)
	{
		$this->check_action_permission('add_update');
		if($id == -1)
		{
			$this->load->view("about/form");
		}
		else
		{
			$data['item_info']=$this->About->get_info($id);
			
			$this->load->view("about/form",$data);
			
		}
		
	}
	
	function get_info($id=-1)
	{
		echo json_encode($this->About->get_info($id));
	}
	
	function save($id=-1)
	{
		$this->check_action_permission('add_update');		
		$item_data = array(
			'phone_number'=>$this->input->post('phone_number'),
			'email'=>$this->input->post('email'),
			'website'=>$this->input->post('website'),
			'address'=>$this->input->post('address'),
			'yahoo'=>$this->input->post('yahoo'),
			'skype'=>$this->input->post('skype'),
			'name_eployee'=>$this->input->post('name_eployee'));
			//'parentid'=>$this->input->post('category'));
	
		if($this->About->save($item_data,$id))
		{
			//New item
			if($id==-1)
			{
				echo json_encode(array('success'=>true,'message'=>lang('abouts_successful_adding').' '.
				$item_data['name'],'id'=>$item_data['id']));
				$id = $item_data['id'];
			}
			
			else //previous item
			{
				echo json_encode(array('success'=>true,'message'=>lang('abouts_successful_updating').' '.
				$item_data['name'],'id'=>$id));
			}

		}
		else//failure
		{
			echo json_encode(array('success'=>false,'message'=>lang('abouts_error_adding_updating').' '.
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
			$config['total_rows'] = $this->About->search_count_all($search);
			$table_data = $this->About->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'email' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		else
		{
			$config['total_rows'] = $this->About->count_all();
			$table_data = $this->About->get_all($per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'email' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		$config['base_url'] = site_url('abouts/sorting');
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_abouts_manage_table_data_rows($table_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));	
	}
		
	function search()
	{
		$this->check_action_permission('search');
		$search=$this->input->post('search');
		$cat=$this->input->post('cat');
		
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		
		$search_data=$this->About->search($search,$cat,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'email' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		$config['base_url'] = site_url('abouts/search');
		
		$config['total_rows'] = $this->About->search_count_all($search,$cat);
		$config['per_page'] = $per_page ;
		$this->pagination->initialize($config);				
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_abouts_manage_table_data_rows($search_data,$this);

		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
		
		
	}
	
	/// - tro nhung tu tuowng tu trong he thong co san maf ng dung mun tim
	function suggest()
	{
		$suggestions = $this->About->get_search_suggestions($this->input->get('term'),100);
		echo json_encode($suggestions);
	}
	
	function item_search()
	{
		$suggestions = $this->About->get_category_search_suggestions($this->input->get('term'),100);
		echo json_encode($suggestions);
	}
	function get_row()
	{
		$id_cat = $this->input->post('row_id');
		$data_row=get_item_data_row($this->About->get_info($id),$this);
		echo $data_row;
	}

	//delete
	function delete()
	{

		$this->check_action_permission('delete');		
		$categories_to_delete=$this->input->post('ids');
		$select_inventory=$this->get_select_inventory();
		$total_rows= $select_inventory ? $this->About->count_all1() : count($categories_to_delete);
		//clears the total inventory selection
		$this->clear_select_inventory();
		if($this->About->delete_list($categories_to_delete))
		{
			
			echo json_encode(array('success'=>true,'message'=>lang('abouts_successful_deleted').' '.
			$total_rows.' '.lang('abouts_one_or_multiple')));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>lang('abouts_cannot_be_deleted')));
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
		$this->About->cleanup();
		echo json_encode(array('success'=>true,'message'=>lang('abouts_cleanup_sucessful')));
	}
	
	function get_form_width()
	{
		return 550;
	}
}
?>