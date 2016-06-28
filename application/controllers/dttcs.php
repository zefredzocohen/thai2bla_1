<?php
require_once(APPPATH . 'third_party/Classes/PHPExcel/IOFactory.php');
require_once(APPPATH . 'libraries/php-excel.class.php');
require_once ("secure_area.php");
class Dttcs extends secure_area
{
public $model_name = "Dttc" ;
public function __construct()
	{
		parent::__construct();
	}
public function index()
	{
		//$this->check_action_permission('search');
		$model = $this->model_name;
		$config['base_url'] = site_url('dttcs/sorting');
		$config['total_rows'] = $this->$model->count_all();
		$data['result_array']=$this->$model->get_all($data['per_page']);
		$config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 10; 
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['controller_name']=strtolower(get_class());
		$data['form_width']=$this->get_form_width();
		$data['per_page'] = $config['per_page'];
		$data['manage_table']=get_dttc_manage_table($this->$model->get_all($data['per_page']),$this);	
		$this->load->view('dttcs/manage',$data);		
	}
public function sorting()
	{
		//$this->check_action_permission('search');
		$model = $this->model_name;
		$search=$this->input->post('search');
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		if ($search)
		{
			$config['total_rows'] = $this->$model->search_count_all($search);
			$table_data = $this->$model->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'last_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		else
		{
			$config['total_rows'] = $this->$model->count_all();
			$table_data = $this->$model->get_all($per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		$config['base_url'] = site_url('dttcs/sorting');
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_dttc_manage_table_data_rows($table_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));	
		
	}
function search()
	{
		$this->check_action_permission('search');
		$model = $this->model_name;
		$search=$this->input->post('search');
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		$search_data=$this->$model->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		$config['base_url'] = site_url('dttcs/search');
		$config['total_rows'] = $this->$model->search_count_all($search);
		$config['per_page'] = $per_page ;
		$this->pagination->initialize($config);				
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_dttc_manage_table_data_rows($search_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
	}
	
public function view($var_id=-1)
	{
		$model = $this->model_name;
		$data['var_info']= $this->$model->get_info($var_id);
		$this->load->view("dttcs/form",$data);
	}	
public function save($var_id=-1)
	{
		$model = $this->model_name;
		$var_data=array(
		'name'=> $this->input->post('dttc_name'),
		'date_1'=> format_date($this->input->post('date_1')),
		'date_2'=> format_date($this->input->post('date_2')),
		'date_3'=> format_date($this->input->post('date_3')),
		'date_4'=> format_date($this->input->post('date_4')),
		'date_5'=> format_date($this->input->post('date_5')),
		'date_6'=> format_date($this->input->post('date_6')),
		);
		if( $this->$model->save($var_data,$var_id))
		{
		if($var_id==-1)
			{
				echo json_encode(array('success'=>true,'message'=>lang('common_successful_adding').' '.
				$var_data['name'],'id'=>$var_data['id']));
				$var_id = $var_data['id'];
			}
			else //previous giftcard
			{
				
				echo json_encode(array('success'=>true,'message'=>lang('common_successful_updating').' '.
				$var_data['name'],'id'=>$var_id));
			}
		}
		else//failure
		{
			echo json_encode(array('success'=>false,'message'=>lang('giftcards_error_adding_updating').' '.
			$customertype_data['name'],'id'=>-1));
		}
	}
	function get_row()
	{
		$model = $this->model_name;	
		$item_id = $this->input->post('row_id');
		$data_row=get_item_data_row($this->Item->get_info($item_id),$this);
		echo $data_row;
	}
	public function delete()
	{
		$model = $this->model_name;	
		$id=$this->input->post('ids');
		if($this->$model->delete_list($id))
		{
			echo json_encode(array('success'=>true,'message'=>lang('giftcards_successful_deleted')));
		}
		else
		{
		echo json_encode(array('success'=>false,'message'=>lang('giftcards_cannot_be_deleted')));
			echo 'that bai';
		}
	}
public function lapkehoach($id){
	$model = $this->model_name;
	$data['suspended_sales'] = $this->Sale->get_all_suspended()->result_array();
	$data['dttc'] = $this->$model->get_info($id);
	$data['dttc_details']= $this->$model->get_all_dttc_details($id);
	$data['id']=$id;
	$this->load->view('dttcs/lapkehoach',$data);
}

public function do_lapkehoach($id){
	$model = $this->model_name;
	$save_data = array(
		'name'=> $this->input->post('name_detail'),
		'date_1'=> $this->input->post('date_1'),
		'date_2'=> $this->input->post('date_2'),
		'date_3'=> $this->input->post('date_3'),
		'date_4'=> $this->input->post('date_4'),
		'date_5'=> $this->input->post('date_5'),
		'date_6'=> $this->input->post('date_6'),
		'id_sale'=>$this->input->post('id_sale'),
		'id_dttc'=>$id,
		'cost_contract'=>$this->input->post('cost_contract'),
		'name_customer'=>$this->input->post('name_customer'),
		'method'=>$this->input->post('method')
	);
	$this->$model->save_dttc_detail($save_data);
	redirect('dttcs/lapkehoach/'.$id);
}
public function export_lapkehoach($id){
	$model = $this->model_name;
	$dttc_info = $this->$model->get_info($id);
	$dttc_details_thu = $this->$model->get_all_dttc_details_thu($id);
	$dttc_details_chi = $this->$model->get_all_dttc_details_chi($id);
	require_once APPPATH . "/third_party/Classes/export_lapkehoach.php";
}
function suspended($id)
	{
		
		$model = $this->model_name;
		$data = array();
		$data['id_dttc'] = $id;
		$data['suspended_sales'] = $this->Sale->get_all_suspended()->result_array();
		$this->load->view('dttcs/suspended', $data);
	}
function do_chonhopdong($id_dttc){
	$model = $this->model_name;
	$count = $this->input->post("count");
	for($i=1; $i <= $count; $i++){
	$selected_id = $this->input->post("checkbox_$i");
	if($selected_id){
		$get_sale_info = $this->Sale->get_info_sale($selected_id);
		$nam_cus = $this->Customer->get_info($get_sale_info->customer_id)->first_name;
		$sale_items = $this->Sale->get_sale_items($selected_id)->result_array();
		foreach($sale_items as $sale_item){
			$cost_contract += $sale_item['quantity_purchased']*$sale_item['item_unit_price'] - ($sale_item['quantity_purchased']*$sale_item['item_unit_price']*($sale_item['discount_percent']/100));
		}
		$sale_payments = $this->Sale->get_sale_payments($selected_id)->result_array();
		foreach($sale_payments as $sale_payment){
			$cost_done += $sale_payment['payment_amount'];
		}
		$data_array= array(
			"name_customer"=>$nam_cus,
			"id_sale"=>$selected_id,
			"method"=>0,
			"id_dttc"=>$id_dttc,
			"cost_contract"=>$cost_contract,
			'cost_done'=>$cost_done,
			'name'=>"hợp đồng số ".$selected_id
		);
		$this->$model->save_dttc_detail($data_array);
	}			
	}
	redirect('dttcs/lapkehoach/'.$id_dttc);
}
	function edit_dttc_detail($id_dttc,$id_dttc_detail){
		$model = $this->model_name;
		$data['id_dttc']= $id_dttc;
		$data['detail_dttc'] = $this->$model->get_detail_dttc($id_dttc_detail);
		$this->load->view('dttcs/edit_lapkehoach',$data);
	}
	function do_edit_lapkehoach($id_dttc){
		$model = $this->model_name;
		$id_dttc_detail = $this->input->post('id_detail_dttc');
		$save_data = array(
		'name'=> $this->input->post('name_detail'),
		'date_1'=> $this->input->post('date_1'),
		'date_2'=> $this->input->post('date_2'),
		'date_3'=> $this->input->post('date_3'),
		'date_4'=> $this->input->post('date_4'),
		'date_5'=> $this->input->post('date_5'),
		'date_6'=> $this->input->post('date_6'),
		'id_sale'=>$this->input->post('id_sale'),
		'cost_contract'=>$this->input->post('cost_contract'),
		'name_customer'=>$this->input->post('name_customer'),
	);
		$this->$model->update_lapkehoach($id_dttc_detail,$save_data);
		redirect('dttcs/lapkehoach/'.$id_dttc);
	}
public function get_form_width()
	{			
		return 550;
	}
}

?>