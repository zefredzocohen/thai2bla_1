<?php 
require_once ("secure_area.php");

class Nhomts_thietbi extends Secure_area {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('sale_lib');
		$this->load->library('receiving_lib');
		
	}
	public function index()
	{
		
		$config['base_url'] = site_url('Nhomts_thietbi/sorting');
		$config['total_rows'] = $this->Nhomts_thietbis->count_all();
		$data['result_array']=$this->Nhomts_thietbis->get_all($data['per_page']);
		$config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 10; 
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['controller_name']=strtolower(get_class());
		$data['form_width']=$this->get_form_width();
		$data['form_height']=$this->get_form_height();
		$data['per_page'] = $config['per_page'];
		$data['manage_table']=get_tstb_manage_table($this->Nhomts_thietbis->get_all($data['per_page']),$this);	
		$this->load->view('Nhomts_thietbi/manage',$data);		
		
	}


public function sorting()
	{
		$this->check_action_permission('search');
		$search=$this->input->post('search');
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		if ($search)
		{
			$config['total_rows'] = $this->Nhomts_thietbis->search_count_all($search);
			$table_data = $this->Nhomts_thietbis->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'last_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		else
		{
			$config['total_rows'] = $this->Nhomts_thietbis->count_all();
			$table_data = $this->Nhomts_thietbis->get_all($per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		$config['base_url'] = site_url('Nhomts_thietbi/sorting');
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_tstb_manage_table_data_rows($table_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));	
		
	}
	// public	function search()
	// {
	// 	$this->check_action_permission('search');
	// 	$search=$this->input->post('search');
	// 	$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
	// 	$search_data=$this->M_customer_type->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
	// 	$config['base_url'] = site_url('customer_type/search');
	// 	$config['total_rows'] = $this->M_customer_type->search_count_all($search);
	// 	$config['per_page'] = $per_page ;
	// 	$this->pagination->initialize($config);				
	// 	$data['pagination'] = $this->pagination->create_links();
	// 	$data['manage_table']=get_customer_type_manage_table_data_rows($search_data,$this);
	// 	echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
	// }
	
	public function view($customertype=-1)
	{
		$this->check_action_permission('add_update');		
		$data['nhom_info']=$this->Nhomts_thietbis->get_info($customertype);
		$this->load->view("Nhomts_thietbi/form",$data);
	}	
	public function save($customertype_id=-1)
	{
		$tstb=array(
		'name_tstb'=>$this->input->post('tstb_name'),
		'desc_tstb'=>$this->input->post('tstb_desc')
		);
		if( $this->Nhomts_thietbis->save($tstb,$customertype_id))
		{
		if($customertype_id==-1)
			{
				echo json_encode(array('success'=>true,'message'=>lang('tstb_successful_adding').' '.
				$tstb['name_tstb'],'id_tstb'=>$tstb['id_tstb']));
				$customertype_id = $tstb['id_tstb'];
			}
			else //previous giftcard
			{
				
				echo json_encode(array('success'=>true,'message'=>lang('tstb_successful_updating').' '.
				$tstb['name_tstb'],'id_tstb'=>$customertype_id));
			}
		}
		else//failure
		{
			echo 'that bai';
			echo json_encode(array('success'=>false,'message'=>lang('tstb_error_adding_updating').' '.
			$tstb['name_tstb'],'id_tstb'=>-1));
		}
	}
	function get_row()
	{
		$item_id = $this->input->post('row_id');
		$data_row=get_tstb_data_row($this->Nhomts_thietbis->get_info($tstb_id),$this);
		echo $data_row;
	}
	public function delete()
	{
		$id=$this->input->post('ids');
		if($this->Nhomts_thietbis->delete_db($id))
		{
			echo json_encode(array('success'=>true,'message'=>lang('tstb_successful_deleted')));
		}
		else
		{
		echo json_encode(array('success'=>false,'message'=>lang('tstb_cannot_be_deleted')));
			echo 'that bai';
		}
	}
	public function get_form_width()
	{			
		return 550;
	}
	public function get_form_height()
	{
		return 335;
	}
}

/* End of file nhomts_thietbi.php */
/* Location: ./application/controllers/nhomts_thietbi.php */