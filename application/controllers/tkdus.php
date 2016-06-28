<?php
require_once ("secure_area.php");
class Tkdus extends secure_area
{
public $model_name = "Tkdu" ;
public function __construct()
	{
		parent::__construct();
	}
public function index()
	{  
		$model = $this->model_name;
		$config['base_url'] = site_url('tkdus/sorting');
		$config['total_rows'] = $this->$model->count_all();
		$config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 10; 
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['controller_name']=strtolower(get_class());
		$data['form_width']=$this->get_form_width();
		$data['per_page'] = $config['per_page'];
        
        $result = $this->$model->get_tkdu_parent_audi();
		$data['manage_table']=get_tkdu_manage_table_audi($result, $this);
		$this->load->view('tkdus/manage',$data);		
	}
    function sorting(){
		$model = $this->model_name;
		$search=$this->input->post('search');
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		if ($search){
			$config['total_rows'] = $this->$model->search_count_all($search);
			$table_data = $this->$model->search(
                $search,$per_page,
                $this->input->post('offset') ? $this->input->post('offset') : 0, 
                $this->input->post('order_col') ? $this->input->post('order_col') : 'name' ,
                $this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc'
            );
		}else{
			$config['total_rows'] = $this->$model->count_all();
			$table_data = $this->$model->get_all(
                $per_page,
                $this->input->post('offset') ? $this->input->post('offset') : 0, 
                $this->input->post('order_col') ? $this->input->post('order_col') : 'name' ,
                $this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc'
            );
		}
		$config['base_url'] = site_url('tkdus/sorting');
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_tkdu_manage_table_data_rows($table_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));	
		
	}
function search()
	{
		$this->check_action_permission('search');
		$model = $this->model_name;
		$search=$this->input->post('search');
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		$search_data=$this->$model->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		$config['base_url'] = site_url('tkdus/search');
		$config['total_rows'] = $this->$model->search_count_all($search);
		$config['per_page'] = $per_page ;
		$this->pagination->initialize($config);				
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_tkdu_manage_table_data_rows($search_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
	}
	
public function view($var_id=-1)
	{
		$model = $this->model_name;
                $list_acc_cat = array('' => 'Chọn loại tài khoản');
                $list_tkdu_parents = $this->$model->get_tkdu_parent();
                foreach ($this->$model->get_account_type() as $list_acc) {
                    $list_acc_cat[$list_acc['type_id']] = $list_acc['type_name'];
                }
                $data['list_acc_cat'] = $list_acc_cat;
		$data['list_tkdu_parents'] = $list_tkdu_parents;
		$data['var_info']= $this->$model->get_info($var_id);
		$this->load->view("tkdus/form",$data);
	}	
public function save($var_id=-1)
	{
		$model = $this->model_name;
                $id_tam = $this->input->post('id_parent');
                $tam_level = $this->$model->get_info($id_tam)->level;
                $level = $tam_level + 1;		
		$var_data=array(
		'id'=>$this->input->post('tkdu_id'),
		'name'=> $this->input->post('chungtu_name'),
                'acc_cat_id'=> $this->input->post('id_cat'),
		'id_parent'=>$this->input->post('id_parent'),
                'level'=>$level,
                'comment'=>$this->input->post('comment'),
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
		function suggest()
	{
		
		$suggestions = $this->Tkdu->get_search_suggestions($this->input->get('term'),100);
		echo json_encode($suggestions);
	}
public function get_form_width()
	{			
		return 550;
	}
    
    //2h47' am 17-11-15
    //begin_balance
    //Hưng Audi say gOOdbye \/
    function begin_balance(){
        $this->load->view('tkdus/begin_balance');
    }
    //tkdu_showbiz
    function tkdu_showbiz(){
        $data['list_tkdu'] = $this->Tkdu->get_tkdu_parent_fashion();    
        $this->load->view('tkdus/tkdu_showbiz', $data);
    }
    function update_tkdu(){
		$model = $this->model_name;
        $du_nos = $this->input->post('du_no');
        $du_cos = $this->input->post('du_co');
        
        foreach ($du_nos as $id => $du_no) {
            foreach ($du_cos as $id8 => $du_co) {
                if($id == $id8){
                    $data[] = array(
                        'du_no' => str_replace(',', '', $du_no),
                        'du_co' => str_replace(',', '', $du_co)
                    );
                    $this->$model->update_tkdu($data,$id);
                }
            }
        }
        redirect('tkdus/begin_balance');
	}
    
    //cong_no_ncc
    function cong_no_ncc(){
        $data['suppliers'] = $this->Tkdu->get_all_cong_no_ncc();
        foreach ($data['suppliers']->result() as $s){
            $happy_new_year = $s->oh_year;
        }
        $data['happy_new_year'] = $happy_new_year;
        
        $oh_year_list = array('' => '--/--');
        for($k=2010; $k < 2081; $k++){
            $oh_year_list[$k] = $k;
        }
        $data['oh_year_list'] = $oh_year_list;
        $this->load->view('tkdus/cong_no_ncc', $data);
    }
    function save_cong_no_ncc(){   
		$model = $this->model_name;
        $person_ids = $this->input->post('person_id');
        $du_nos = $this->input->post('du_no');
        $du_cos = $this->input->post('du_co');
        
        foreach ($person_ids as $id => $person_id) {        
            foreach ($du_nos as $id1 => $du_no) {
                if($id == $id1){
                    foreach ($du_cos as $id2 => $du_co) {
                        if($id1 == $id2){
                            $data[] = array(
                                'person_id' => $person_id,
                                'du_no' => str_replace(',', '', $du_no),
                                'du_co' => str_replace(',', '', $du_co),
                                'oh_year' => $this->input->post('oh_year')
                            );
                        }
                    }
                }
            }
        }
        $this->$model->save_cong_no_ncc($data);
        redirect('tkdus/begin_balance');
	}
    //cong_no_kh
    function cong_no_kh(){
        $data['customers'] = $this->Tkdu->get_all_cong_no_kh();
        foreach ($data['customers']->result() as $s){
            $happy_new_year = $s->oh_year;
        }
        $data['happy_new_year'] = $happy_new_year;
        
        $oh_year_list = array('' => '--/--');
        for($k=2010; $k < 2081; $k++){
            $oh_year_list[$k] = $k;
        }
        $data['oh_year_list'] = $oh_year_list;
        $this->load->view('tkdus/cong_no_kh', $data);
    } 
    function save_cong_no_kh(){   
		$model = $this->model_name;
        $person_ids = $this->input->post('person_id');
        $du_nos = $this->input->post('du_no');
        $du_cos = $this->input->post('du_co');

        foreach ($person_ids as $id => $person_id) {        
            foreach ($du_nos as $id1 => $du_no) {
                if($id == $id1){
                    foreach ($du_cos as $id2 => $du_co) {
                        if($id1 == $id2){
                            $data[] = array(
                                'person_id' => $person_id,
                                'du_no' => str_replace(',', '', $du_no),
                                'du_co' => str_replace(',', '', $du_co),
                                'oh_year' => $this->input->post('oh_year')
                            );
                        }
                    }
                }
            }
        }
        $this->$model->save_cong_no_kh($data);
        redirect('tkdus/begin_balance');
	}
    function customer_search() {
        $suggestions = $this->Tkdu->get_customer_search($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }
    
    //cong_no_khac
    function cong_no_khac(){
        $data['nguoi_khac'] = $this->Tkdu->get_all_cong_no_khac();
        $this->load->view('tkdus/cong_no_khac', $data);
    }
    function save_cong_no_khac(){   
		$model = $this->model_name;
        $accounts = $this->input->post('account');
        $codes = $this->input->post('code');
        $names = $this->input->post('name');
        $du_nos = $this->input->post('du_no');
        $du_cos = $this->input->post('du_co');
        $data = array();
        foreach ($accounts as $id => $account) {
            foreach ($codes as $id2 => $code) {
                if($id == $id2){
                    foreach ($names as $id3 => $name) {
                        if($id2 == $id3){
                            foreach ($du_nos as $id4 => $du_no) {
                                if($id3 == $id4){
                                    foreach ($du_cos as $id5 => $du_co) {
                                        if($id4 == $id5){
                                            $data[] = array(
                                                'account' => $account,
                                                'code' => $code,                                                
                                                'name' => $name,
                                                'du_no' => str_replace(',', '', $du_no),
                                                'du_co' => str_replace(',', '', $du_co)
                                            );
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $this->$model->save_cong_no_khac($data);
        echo 'OK ';
        redirect('tkdus/begin_balance');
	}
    
    //ton_kho
    function ton_kho(){
        $data['item'] = $this->Item->get_all();
        $this->load->view('tkdus/ton_kho', $data);
    }
    function update_item(){   
		$model = $this->model_name;
        $quantity_invs = $this->input->post('quantity_inv');
        $money_invs = $this->input->post('money_inv');
        
        foreach ($quantity_invs as $id => $quantity_inv) {
            foreach ($money_invs as $id8 => $money_inv) {
                if($id == $id8){
                    $data[] = array(
                        'quantity_inv' => str_replace(',', '', $quantity_inv),
                        'money_inv' => str_replace(',', '', $money_inv)
                    );
                    $this->$model->update_item($data,$id);
                }
            }
        }
        redirect('tkdus/begin_balance');
	}
    
}
