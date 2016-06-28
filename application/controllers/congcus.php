<?php
require_once ("secure_area.php");
class Congcus extends secure_area
{
public $model_name = "Congcu" ;
public function __construct()
	{
		parent::__construct();
        $this->load->helper('report');
	}
public function index()
	{
		//$this->check_action_permission('search');
		$model = $this->model_name;
		$config['base_url'] = site_url('congcus/sorting');
		$config['total_rows'] = $this->$model->count_all();
		$data['result_array']=$this->$model->get_all($data['per_page']);
		$config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 10; 
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['controller_name']=strtolower(get_class());
		$data['form_width']=$this->get_form_width();
		$data['per_page'] = $config['per_page'];
		$data['manage_table']=get_congcu_manage_table($this->$model->get_all($data['per_page']),$this);	
		$this->load->view('congcus/manage',$data);		
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
			$table_data = $this->$model->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		else
		{
			$config['total_rows'] = $this->$model->count_all();
			$table_data = $this->$model->get_all($per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		$config['base_url'] = site_url('congcus/sorting');
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_congcu_manage_table_data_rows($table_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));	
		
	}
function search()
	{
		$this->check_action_permission('search');
		$model = $this->model_name;
		$search=$this->input->post('search');
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		$search_data=$this->$model->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		$config['base_url'] = site_url('congcus/search');
		$config['total_rows'] = $this->$model->search_count_all($search);
		$config['per_page'] = $per_page ;
		$this->pagination->initialize($config);				
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_congcu_manage_table_data_rows($search_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
	}
	
public function view($var_id=-1)
	{
		$model = $this->model_name;
		$list_group_type = array('' => 'Chọn loại thiết bị');
        foreach ($this->$model->get_list_group_type()->result_array() as $list_type) {
            $list_group_type[$list_type['id']] = $list_type['name'];
        }
		$data['list_group_type'] = $list_group_type;
		$list_ppkh_type = array('' => 'Chọn phương pháp khấu hao');
        foreach ($this->$model->get_list_ppkh_type()->result_array() as $list_type) {
            $list_ppkh_type[$list_type['id']] = $list_type['name'];
        }
		$data['list_ppkh_type'] = $list_ppkh_type;
		$data['var_info']= $this->$model->get_info($var_id);
		$this->load->view("congcus/form",$data);
	}	
	
	public function update_value_asset(){
	$model = $this->model_name;
	$assets= $this->$model->get_all_info();
	if($assets != null){
		foreach ($assets as $asset){
			 $year = date('Y') - date('Y', strtotime($asset['date_kh']));
			 $month = date('m', strtotime($asset['date_kh']));
			 $ky = $year*12 + date('m') - $month ;
			 $value_remain = $asset['value'] - $ky*($asset['value']/$asset['ky_khauhao']) ;
			 $this->$model->update_value_asset($asset['id'],$value_remain);
		}
	}
	redirect('congcus');
}
    function save($var_id=-1){
		$model = $this->model_name;
        $ky_khauhao = $this->input->post('ky_khauhao');
        $date_kh = $this->input->post('date_kh');
		$var_data=array(
		'congcu_number'=> $this->input->post('congcu_number'),
		'name'=> $this->input->post('assets_name'),
		'value'=> $this->input->post('value'),
		'value_remain'=> $this->input->post('value_remain'),
		'id_parent'=> $this->input->post('group'),
		'lydotang'=> $this->input->post('description'),
		'date_tang'=> format_date($this->input->post('date_tang')),
		'date_kh'=> format_date($date_kh),
		'ky_khauhao'=> $ky_khauhao,
		'han_khauhao'=> date("Y-m-d H:i:s", strtotime("+$ky_khauhao month", strtotime( $date_kh ) ) ),
		'ppkh'=> $this->input->post('ppkh'),
		//'tktk'=> $this->input->post('tktk'),
		'tkkh'=> $this->input->post('tkkh'),
		'tkcp'=> $this->input->post('tkcp')
		);
		if( $this->$model->save($var_data,$var_id)){
            if($var_id==-1){
				echo json_encode(array('success'=>true,'message'=>lang('common_successful_adding').' '.
				$var_data['name'],'id'=>$var_data['id']));
				$var_id = $var_data['id'];
			}else{
				echo json_encode(array('success'=>true,'message'=>lang('common_successful_updating').' '.
				$var_data['name'],'id'=>$var_id));
			}
		}else{
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
		function suggest()
	{
		
		$suggestions = $this->Congcu->get_search_suggestions($this->input->get('term'),100);
		echo json_encode($suggestions);
	}
public function get_form_width()
	{			
		return 550;
	}
    //Hưng Audi 0000 Oct 26
    // hello Halloween (^_^) 
    function allocate($var_id){
		$model = $this->model_name;
		$data['var_info']= $this->$model->get_info($var_id);
		$this->load->view("congcus/allocate",$data);
	}
    function save_allocate($var_id){
		$model = $this->model_name;
		$var_data=array(
            'allocate'=> $this->input->post('allocate')
		);
		if( $this->$model->save_allocate($var_data,$var_id)){
            echo json_encode(
                array(
                    'success'=>true,
                    'message'=> 'Ngừng phân bổ thành công !',
                )
            );
		}else{
			echo json_encode(
                array(
                    'success'=>false,
                    'message'=>lang('giftcards_error_adding_updating').' '.$customertype_data['name']
                )
            );
		}
	}
    function calculate_allocate(){
		$model = $this->model_name;
        $data['months'] = get_months();
        $data['years'] = get_years();
        $data['selected_month'] = date('m');
        $data['selected_year'] = date('Y');
		//$data['var_info']= $this->$model->get_info($var_id);
		$this->load->view("congcus/calculate_allocate",$data);
	}
    function get_congcus_halloween() {
        $halloween_month = $this->input->post("halloween_month");
        $halloween_year = $this->input->post("halloween_year");
        $halloween_time = "$halloween_year-$halloween_month";
        
        $data = $this->Congcu->get_congcus_halloween($halloween_time);
        echo json_encode($data);
    }
    
}

?>