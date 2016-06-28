<?php 
require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");
class Language extends Secure_area {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('sale_lib');
		$this->load->library('receiving_lib');	
	}

	public function index()
	{	
		$config['base_url'] = site_url('language/sorting');
		$config['total_rows'] = $this->Languages->count_all();
		$data['result_array']=$this->Languages->get_all($data['per_page']);
		$config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 10; 
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['controller_name']=strtolower(get_class());
		$data['form_width']=$this->get_form_width();
		$data['per_page'] = $config['per_page'];
		$data['manage_table']=get_language_manage_table($this->Languages->get_all($data['per_page']),$this);	
		$this->load->view('language/manage',$data);	
	}//End index
	
	public function sorting() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search) {
            $config['total_rows'] = $this->Languages->search_count_all($search);
            $table_data = $this->Languages->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name_language', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        } else {
            $config['total_rows'] = $this->Languages->count_all();
            $table_data = $this->Languages->get_all($per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name_language', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        }
        $config['base_url'] = site_url('language/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_language_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function search() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Languages->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name_language', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        $config['base_url'] = site_url('Languages/search');
        $config['total_rows'] = $this->Languages->search_count_all($search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_language_manage_table_data_rows($search_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }	
	function save($id=-1)
	{
		$this->check_action_permission('add_update');		
		$item_data = array(
			'name_language'=>$this->input->post('name_language')
		);
	
		if($this->Languages->save($item_data,$id))
		{
			//New item
			if($id_cat==-1)
			{
				echo json_encode(array('success'=>true,'message'=>lang('bangcap_successful_adding').' '.
				$item_data['name_language'],'id_bangcap'=>$item_data['id_language']));
				$id_cat = $item_data['id_language'];
			}
			
			else //previous item
			{
				echo json_encode(array('success'=>true,'message'=>lang('bangcap_successful_updating').' '.
				$item_data['name_language'],'id_language'=>$id_cat));
			}

		}
		else//failure
		{
			echo json_encode(array('success'=>false,'message'=>lang('bangcap_error_adding_updating').' '.
			$item_data['name_language'],'id_language'=>-1));
		}

	}	//
	
	
	function suggest()
	{
		
		$suggestions = $this->Languages->get_search_suggestions($this->input->get('term'),100);
		echo json_encode($suggestions);
	}
	
	function view($id=-1)
	{
		$this->check_action_permission('add_update');
		if($id == -1)
		{
			$this->load->view("language/form");
		}
		else
		{
			$data['item_info']=$this->Languages->get_info($id);
			
			$this->load->view("language/form",$data);
			
		}
		
	}// End load form
	
		function delete()
	{
		$tinhoc_to_delete=$this->input->post('ids');

		if($this->Languages->delete_db($tinhoc_to_delete))
		{
			echo json_encode(array('success'=>true,'message'=>'Xóa thành công'));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>'Lỗi xảy ra'));
		}
	}
	// info 	
	function get_form_width()
	{
		return 500;
	}
	function get_form_height(){
		return 300;
	}
	function get_row()
	{
		$item_id = $this->input->post('row_id');
		$data_row=get_item_data_row($this->Languages->get_info($item_id),$this);
		echo $data_row;
	}

}

/* End of file language.php */
/* Location: ./application/controllers/language.php */