<?php
require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");
class Giftcards extends Secure_area implements iData_controller
{
	function __construct()
	{
		parent::__construct('giftcards');
	}

	function index()
	{
		$config['base_url'] = site_url('giftcards/sorting');
		$config['total_rows'] = $this->Giftcard->count_all();
		$config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20; 
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['controller_name']=strtolower(get_class());
		$data['form_width']=$this->get_form_width();
		$data['per_page'] = $config['per_page'];
		$data['manage_table']=get_giftcards_manage_table($this->Giftcard->get_all($data['per_page']),$this);
		$this->load->view('giftcards/manage',$data);
	}
	function sorting()
	{
		$search=$this->input->post('search');
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		if ($search)
		{
			$config['total_rows'] = $this->Giftcard->search_count_all($search);
			$table_data = $this->Giftcard->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'giftcard_number' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		else
		{
			$config['total_rows'] = $this->Giftcard->count_all();
			$table_data = $this->Giftcard->get_all($per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'giftcard_number' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		$config['base_url'] = site_url('giftcards/sorting');
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_Giftcards_manage_table_data_rows($table_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));	
	}
	
	/* added for excel expert */
	function excel_export() {
		$data = $this->Giftcard->get_all()->result_object();
		$this->load->helper('report');
		$rows = array();
		$row = array("Gift Card Number", "Value");
		$rows[] = $row;
		foreach ($data as $r) {
			$row = array(
				$r->giftcard_number,
				$r->value
			);
			$rows[] = $row;
		}
		
		$content = array_to_csv($rows);
		force_download('giftcards_export' . '.csv', $content);
		exit;
	}

	function search()
	{
		$search=$this->input->post('search');
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		$search_data=$this->Giftcard->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'giftcard_number' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		$config['base_url'] = site_url('giftcards/search');
		$config['total_rows'] = $this->Giftcard->search_count_all($search);
		$config['per_page'] = $per_page ;
		$this->pagination->initialize($config);				
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_giftcards_manage_table_data_rows($search_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
		
	}
	
	/*
	Gives search suggestions based on what is being searched for
	*/
	function suggest()
	{
		$suggestions = $this->Giftcard->get_search_suggestions($this->input->get('term'),100);
		echo json_encode($suggestions);
	}

	function get_row()
	{
		$giftcard_id = $this->input->post('row_id');
		$data_row=get_giftcard_data_row($this->Giftcard->get_info($giftcard_id),$this);
		echo $data_row;
	}
	//uyen them()
	// public function add_new_info_giftcard($giftcard_id=-1){
	// 	$id_cus=$this->input->post('customer_id')=='' ? null:$this->input->post('customer_id');
	// 	$val_gift=$this->input->post('value');
	// 	$num_gift=$this->input->post('giftcard_number');
	// 	$chiet_khau=$this->input->post('name_chietkhau') ? $this->input->post('name_chietkhau') :0;
	// 	//$discount=$this->input->post('');
	// 	$data_customer=array(
	// 	'giftcard_number'=>$num_gift,
	// 	'value'=>$val_gift,
	// 	'customer_id'=>$id_cus,
	// 	'chiet_khau'=>$chiet_khau
	// 	));
		
	// 	if ($this->Giftcard->save($giftcard_id,$data_customer)) {
	// 		echo 'thanh cong'
	// 	} else {
	// 		echo 'loi';
	// 	}
	// }

	public function update_get_money(){
		$id_giftcard=$this->input->post('id_giftcards');
		$sum_money=$this->input->post('sum_money');
		$giftcard_data=array(
			'value'=>$sum_money,
			'date_get_money'=>date('Y-m-d H:i:s'),
			//'date_update'=>date('Y-m-d'),
			);
		if($this->Giftcard->update_data_giftcard($giftcard_data,$id_giftcard)){
			echo 'true';
		}
		else{
			echo 'false';
		}
	}
	public function get_money($giftcard_ids){
		$result = array();
		$giftcard_ids = explode('~', $giftcard_ids);
		foreach ($giftcard_ids as $giftcard_id)
		{
			$giftcard_info = $this->Giftcard->get_info($giftcard_id);
			$result[] = array('name' =>$giftcard_info->giftcard_number. ': '.to_currency($giftcard_info->value), 'id'=> $giftcard_info->giftcard_number);
		}
		foreach ($result as $key ) {
			 $data['giftcards']=$this->Giftcard->get_info($this->Giftcard->get_giftcard_id($key['id']));
		}
	   $this->load->view('giftcards/form_get_money',$data);
	}
	
	
	public function return_money($giftcard_ids){
		$result = array();
		$giftcard_ids = explode('~', $giftcard_ids);
		foreach ($giftcard_ids as $giftcard_id)
		{
			$giftcard_info = $this->Giftcard->get_info($giftcard_id);
			$result[] = array('name' =>$giftcard_info->giftcard_number. ': '.to_currency($giftcard_info->value), 'id'=> $giftcard_info->giftcard_number);
		}
		foreach ($result as $key ) {
			 $data['giftcards']=$this->Giftcard->get_info($this->Giftcard->get_giftcard_id($key['id']));
		}
	//echo $data['giftcards']->customer_id;
 	 //$id_company=$this->Giftcard->get_company_customer($data['giftcards']->customer_id);
	   $this->load->view('giftcards/form_return_money',$data);
	}
	//end uyen them

	function view($giftcard_id=-1)
	{
		$data = array();

		$data['customers'] = array('' => 'No Customer');
		foreach ($this->Customer->get_all()->result() as $customer)	
		{
			$data['customers'][$customer->person_id] = $customer->first_name . ' '. $customer->last_name;
		}
		$data['company']=$this->Customer->get_company()->result_array();
		$data['giftcard_info']=$this->Giftcard->get_info($giftcard_id);

		$this->load->view("giftcards/form",$data);
	}
	public function create_new_giftcard()
	{
		$this->load->view('giftcards/form_add_new');
	}
	//23/01/2014
	public function new_giftcarded()
	{
		$giftcard_number=$this->input->post('id_g');
		$value_giftcards=$this->input->post('value_g');
		$cus=$this->input->post('cus_id')=='' ? null:$this->input->post('cus_id');
		$chietkhau=$this->input->post('check_dis');
		$data=array(
			'giftcard_number'=>$giftcard_number,
			'value'=>$value_giftcards,
			'customer_id'=>$cus,
			'chiet_khau'=>$chietkhau,
			'date_get_money'=>date('Y-m-d H:i:s')
		);
		if($this->Giftcard->save_new_giftcard($data)){
			echo 'true';
			
		}
		else{
			echo 'false';
		}
	}
	// End 23/01/2014
	function save($giftcard_id=-1)
	{
		$giftcard_data = array(
		'giftcard_number'=>$this->input->post('giftcard_number'),
		'value'=>$this->input->post('value'),
		'customer_id'=>$this->input->post('customer_id')=='' ? null:$this->input->post('customer_id'),
		);

		if( $this->Giftcard->save( $giftcard_data, $giftcard_id ) )
		{
			//New giftcard
			if($giftcard_id==-1)
			{
				echo json_encode(array('success'=>true,'message'=>lang('giftcards_successful_adding').' '.
				$giftcard_data['giftcard_number'],'giftcard_id'=>$giftcard_data['giftcard_id']));
				$giftcard_id = $giftcard_data['giftcard_id'];
			}
			else //previous giftcard
			{
				echo json_encode(array('success'=>true,'message'=>lang('giftcards_successful_updating').' '.
				$giftcard_data['giftcard_number'],'giftcard_id'=>$giftcard_id));
			}
		}
		else//failure
		{
			echo json_encode(array('success'=>false,'message'=>lang('giftcards_error_adding_updating').' '.
			$giftcard_data['giftcard_number'],'giftcard_id'=>-1));
		}

	}

	function delete()
	{
		$giftcards_to_delete=$this->input->post('ids');

		if($this->Giftcard->delete_list($giftcards_to_delete))
		{
			echo json_encode(array('success'=>true,'message'=>lang('giftcards_successful_deleted').' '.
			count($giftcards_to_delete).' '.lang('giftcards_one_or_multiple')));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>lang('giftcards_cannot_be_deleted')));
		}
	}
		
				
		function delete1()
	{
		$giftcards_to_delete=$this->input->post('ids');

		if($this->Giftcard->delete_db($giftcards_to_delete))
		{
			echo json_encode(array('success'=>true,'message'=>lang('giftcards_successful_deleted')));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>lang('giftcards_cannot_be_deleted')));
		}
	}
	/*
	get the width for the add/edit form
	*/
	function get_form_width()
	{
		return 550;
	}
	
	function generate_barcodes($giftcard_ids)
	{
		$result = array();

		$giftcard_ids = explode('~', $giftcard_ids);
		foreach ($giftcard_ids as $giftcard_id)
		{
			$giftcard_info = $this->Giftcard->get_info($giftcard_id);
			$result[] = array('name' =>$giftcard_info->giftcard_number. ': '.to_currency($giftcard_info->value), 'id'=> $giftcard_info->giftcard_number);
		}

		$data['items'] = $result;
		//print_r($result);
		$data['scale'] = 1;
		$this->load->view("barcode_sheet", $data);
	}
	
	function generate_barcode_labels($giftcard_ids)
	{
		$result = array();

		$giftcard_ids = explode('~', $giftcard_ids);
		foreach ($giftcard_ids as $giftcard_id)
		{
			$giftcard_info = $this->Giftcard->get_info($giftcard_id);
			$result[] = array('name' =>$giftcard_info->giftcard_number. ': '.to_currency($giftcard_info->value), 'id'=> $giftcard_info->giftcard_number);
		}

		$data['items'] = $result;
		$data['scale'] = 1;
		$this->load->view("barcode_labels", $data);
	}
}
?>