<?php 
require_once("secure_area.php");
require_once("interfaces/idata_controller.php");
class Education extends Secure_area {
	public function __construct()
	{
		parent::__construct('Education');
		$this->load->library('sale_lib');
		$this->load->library('receiving_lib');  
		$this->load->database();    	
	}
	public function index()
	{
		$config['base_url'] = site_url('education/sorting');
		$config['total_rows'] = $this->Educations->count_all();
		$config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 10;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['controller_name']=strtolower(get_class());	
		$data['form_width']=$this->get_form_width();
		$data['form_height']=$this->get_form_height();
		$data['total_rows'] = $this->Educations->count_all();
		$data['per_page'] = $config['per_page'];
		$data['manage_table']=get_education_manage_table($this->Educations->get_all1($config	['per_page']),$this);		
		$data['education'] = $this->Educations->get_all();	
		$this->load->view('education/manage',$data);
	}// End index
	//check trùng tên
	function checkname( $id){
        $name_education = $this->input->post('name_education');        
        $d['name_education']=  $this->Educations->getname($id);
        foreach ( $d['name_education'] as $d2){
			$d3[]= $d2['name_education'];			
		} 
		$c2= $d3;
		$e1= implode(',', $c2);
		$e2= explode(',',$e1);
		
	    if (in_array($name_education, $e2)){
		    echo json_encode(false);
		} else {
			echo json_encode(true);
		}
	}		
	function sorting()
	{
		$this->check_action_permission('search');
		$search=$this->input->post('search');
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		if ($search)
		{
			$config['total_rows'] = $this->Educations->search_count_all($search);
			$table_data = $this->Educations->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name_education' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		else
		{
			$config['total_rows'] = $this->Educations->count_all();
			$table_data = $this->Educations->get_all1($per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name_education' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		$config['base_url'] = site_url('education/sorting');
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_educations_manage_table_data_rows($table_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));	
	}
	
	function search() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Educations->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name_education', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        $config['base_url'] = site_url('education/search');
        $config['total_rows'] = $this->Educations->search_count_all($search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_educations_manage_table_data_rows($search_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }
   	function save($id=-1)
	{
		$this->check_action_permission('add_update');		
		$item_data = array(
			'name_education'=>$this->input->post('name_education'));
	
		if($this->Educations->save($item_data,$id))
		{
			//New item
			if($id==-1)
			{
				echo json_encode(array('success'=>true,'message'=>lang('education_successful_adding').' '.
				$item_data['name_education'],'id'=>$item_data['id']));
				$id = $item_data['id'];
			}
			
			else //previous item
			{
				echo json_encode(array('success'=>true,'message'=>lang('education_successful_updating').' '.
				$item_data['name_education'],'id'=>$id));
			}

		}
		else//failure
		{
			echo json_encode(array('success'=>false,'message'=>lang('education_error_adding_updating').' '.
			$item_data['name_education'],'id'=>-1));
		}

	}	//save
	function view($id=-1)
	{
		$this->check_action_permission('add_update');
		if($id == -1)
		{
			$this->load->view("education/form");
		}
		else
		{
			$data['item_info']=$this->Educations->get_info($id);
			
			$this->load->view("education/form",$data);
			
		}
		
	}
	 function suggest()
	{
		$suggestions = $this->Educations->get_search_suggestions($this->input->get('term'),100);
		echo json_encode($suggestions);
	}
	function delete()
	{
		$this->check_action_permission('delete');		
		$education_to_delete=$this->input->post('ids');
		$select_inventory=$this->get_select_inventory();
		$total_rows= $select_inventory ? $this->Educations->count_all1() : count($education_to_delete);
		//clears the total inventory selection
		$this->clear_select_inventory();
		if($this->Educations->delete_list($education_to_delete))
		{
			
			echo json_encode(array('success'=>true,'message'=>lang('items_cate_successful_deleted')));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>lang('items_cate_cannot_be_deleted')));
		}
 	}//End delete
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
		
	}//end select inventory
 	
	function get_info($id=-1)
	{
		echo json_encode($this->Education->get_info($id));
	}	

	function get_form_width()
	{
		return 550;
	}
	
	function get_form_height(){
		return 300;
	}
	

}

/* End of file education.php */
/* Location: ./application/controllers/education.php */