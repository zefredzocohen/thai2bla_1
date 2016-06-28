<?php
require_once ("secure_area.php");

class Bpsd extends Secure_area {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('sale_lib');
		$this->load->library('receiving_lib');
		
	}
	public function index()
	{
		$config['base_url'] = site_url('bpsd/sorting');
		$config['total_rows'] = $this->Bpsds->count_all();
		$data['result_array']=$this->Bpsds->get_all($data['per_page']);
		$config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 10; 
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['controller_name']=strtolower(get_class());
		$data['form_width']=$this->get_form_width();
		$data['form_height']=$this->get_form_height();
		$data['per_page'] = $config['per_page'];
		$data['manage_table']=get_bpsd_manage_table($this->Bpsds->get_all($data['per_page']),$this);	
		$this->load->view('Bpsd/manage',$data);
	}


	public function sorting() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search) {
            $config['total_rows'] = $this->Bpsds->search_count_all($search);
            $table_data = $this->Bpsds->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name_bpsd', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        } else {
            $config['total_rows'] = $this->Bpsds->count_all();
            $table_data = $this->Bpsds->get_all($per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name_bpsd', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        }
        $config['base_url'] = site_url('bpsd/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_bpsd_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function search() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Bpsds->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name_bpsd', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        $config['base_url'] = site_url('bpsds/search');
        $config['total_rows'] = $this->Bpsds->search_count_all($search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_bpsd_manage_table_data_rows($search_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }	
	
	function bpsd_search()
	{
		$model = $this->model_name;
		$suggestions = $this->$model->get_search_suggestions($this->input->get('term'),100);
		echo json_encode($suggestions);
	}
	public function view($customertype=-1)
	{
		$this->check_action_permission('add_update');		
		$data['bpsd_info']=$this->Bpsds->get_info($customertype);
		$this->load->view("Bpsd/form",$data);
	}	
	public function save($customertype_id=-1)
	{
		$bpsd=array(
		'name_bpsd'=>$this->input->post('bpsd_name'),
		'desc_bpsd'=>$this->input->post('bpsd_desc')
		);
		if( $this->Bpsds->save($bpsd,$customertype_id))
		{
		if($customertype_id==-1)
			{
				echo json_encode(array('success'=>true,'message'=>lang('bpsd_successful_adding').' '.
				$bpsd['name_bpsd'],'id_bpsd'=>$bpsd['id_bpsd']));
				$customertype_id = $bpsd['id_bpsd'];
			}
			else //previous giftcard
			{
				
				echo json_encode(array('success'=>true,'message'=>lang('bpsd_successful_updating').' '.
				$bpsd['name_bpsd'],'id_bpsd'=>$customertype_id));
			}
		}
		else//failure
		{
			echo 'that bai';
			echo json_encode(array('success'=>false,'message'=>lang('bpsd_error_adding_updating').' '.
			$bpsd['name_bpsd'],'id_bpsd'=>-1));
		}
	}
	function get_row()
	{
		$item_id = $this->input->post('row_id');
		$data_row=get_item_data_row($this->Bpsds->get_info($item_id),$this);
		echo $data_row;
	}
        function suggest() {
        $suggestions = $this->Bpsds->get_search_suggestions($this->input->get('term'), 100);
        echo json_encode($suggestions);
        }
        
	public function delete()
	{
		$id=$this->input->post('ids');
		if($this->Bpsds->delete_db($id))
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

/* End of file bpsd.php */
/* Location: ./application/controllers/bpsd.php */