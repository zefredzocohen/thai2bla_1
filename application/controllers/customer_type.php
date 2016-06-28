<?php
require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");
class Customer_type extends secure_area
{
public function __construct()
	{
		parent::__construct();
		$this->load->library('sale_lib');
		$this->load->library('receiving_lib');
		$this->load->model('M_customer_type');
	}
    public function index()
	{
		$this->check_action_permission('search');
		$config['base_url'] = site_url('customer_type/sorting');
		$config['total_rows'] = $this->M_customer_type->count_all();
		$data['result_array']=$this->M_customer_type->get_all(20);
		$config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 10; 
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['controller_name']=strtolower(get_class());
		$data['form_width']=$this->get_form_width();
		$data['per_page'] = $config['per_page'];
		$data['manage_table']=get_customer_type_manage_table($this->M_customer_type->get_all2($data['per_page']),$this);	
		$this->load->view('customer_type/manage',$data);	
	}
	//check trùng tên
	function checkname( $id){
        $name = $this->input->post('customer_type_name');        
        $d['name']=  $this->M_customer_type->getname($id);
        foreach ( $d['name'] as $d2){
			$d3[]= $d2['name'];			
		} 
		$c2= $d3;
		$e1= implode(',', $c2);
		$e2= explode(',',$e1);
		
	    if (in_array($name, $e2)){
		    echo json_encode(false);
		} else {
			echo json_encode(true);
		}
	}
    public function sorting()
	{
		$this->check_action_permission('search');
		$search=$this->input->post('search');
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		if ($search)
		{
			$config['total_rows'] = $this->M_customer_type->search_count_all($search);
			$table_data = $this->M_customer_type->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		else
		{
			$config['total_rows'] = $this->M_customer_type->count_all();
			$table_data = $this->M_customer_type->get_all2($per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'customer_type_id' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'desc');
		}
		$config['base_url'] = site_url('customer_type/sorting');
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_customer_type_manage_table_data_rows($table_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));	
		
	}
    function search()
	{
		$this->check_action_permission('search');
		$search=$this->input->post('search');
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		$search_data=$this->M_customer_type->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'customer_type_id' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'desc');
		$config['base_url'] = site_url('customer_type/search');
		$config['total_rows'] = $this->M_customer_type->search_count_all($search);
		$config['per_page'] = $per_page ;
		$this->pagination->initialize($config);				
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_customer_type_manage_table_data_rows($search_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
	}
	
    public function view($customertype=-1)
	{
		$this->check_action_permission('add_update');		
		$data['customer_type_info']=$this->M_customer_type->get_info($customertype);
		$this->load->view("customer_type/form",$data);
	}	
    public function save($customertype_id=-1)
	{
		$customertype_data=array(
            'name'=>$this->input->post('customer_type_name'),
            'code'=>$this->input->post('customer_type_code'),
            'desc'=>$this->input->post('customer_type_desc'),
             'status_agent' => $this->input->post('customer_type_agent') ? 1 : 0,
		);
		if( $this->M_customer_type->save($customertype_data,$customertype_id))
		{
			if($customertype_id==-1)
			{
				echo json_encode(array('success'=>true,'message'=>lang('customer_type_successful_adding').' '.
				$customertype_data['name'],'customer_type_id'=>$customertype_data['customer_type_id']));
				$customertype_id = $customertype_data['customer_type_id'];
			}
			else //previous giftcard
			{
                echo json_encode(array('success'=>true,'message'=>lang('customer_type_successful_updating').' '.
				$customertype_data['name'],'customer_type_id'=>$customertype_id));
			}
		}
		else//failure
		{
			echo json_encode(array('success'=>false,'message'=>lang('customer_type_error_adding_updating').' '.
			$customertype_data['name'],'customer_type_id'=>-1));
		}
	}
	function get_row()
	{
		$item_id = $this->input->post('row_id');
		$data_row=get_item_data_row($this->Item->get_info($item_id),$this);
		echo $data_row;
	}
	public function delete()
	{
		$id=$this->input->post('ids');
		if($this->M_customer_type->delete_list($id))
		{
			echo json_encode(array('success'=>true,'message'=>lang('customer_type_successful_deleted')));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>lang('customer_type_cannot_be_deleted')));
		}
	}
    public function get_form_width()
    {
        return 360;
    }
}

?>