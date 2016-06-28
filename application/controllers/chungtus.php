<?php
require_once ("secure_area.php");
class Chungtus extends secure_area
{
public $model_name = "Chungtu" ;
public function __construct()
	{
		parent::__construct();
	}
public function index()
	{
		$this->check_action_permission('search');
		$model = $this->model_name;
		$config['base_url'] = site_url('chungtus/sorting');
		$config['total_rows'] = $this->$model->count_all();
		$data['result_array']=$this->$model->get_all($data['per_page']);
		$config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 10; 
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['controller_name']=strtolower(get_class());
		$data['form_width']=$this->get_form_width();
		$data['per_page'] = $config['per_page'];
		$data['manage_table']=get_chungtu_manage_table($this->$model->get_all($data['per_page']),$this);	
		$this->load->view('chungtus/manage',$data);		
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
		$config['base_url'] = site_url('chungtus/sorting');
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_chungtu_manage_table_data_rows($table_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));	
		
	}
function search()
	{
		$this->check_action_permission('search');
		$model = $this->model_name;
		$search=$this->input->post('search');
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		$search_data=$this->$model->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		$config['base_url'] = site_url('chungtus/search');
		$config['total_rows'] = $this->$model->search_count_all($search);
		$config['per_page'] = $per_page ;
		$this->pagination->initialize($config);				
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_chungtu_manage_table_data_rows($search_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
	}
	
    function view($var_id=-1){
		$model = $this->model_name;
        $data['chungtu_id']= $var_id;
		$data['var_info']= $this->$model->get_info($var_id);
        //tk_no & co
        $data['list_tk_no'] = $this->Tkdu->get_tkdu_parent();
        $data['list_tk_co'] = $this->Tkdu->get_tkdu_parent();
		$this->load->view("chungtus/form",$data);
	}	
    /* 20/10/15     --;{(@  */
    function save($var_id=-1){
		$model = $this->model_name;
        $ngay_lap=date('Y-m-d', strtotime( $this->input->post('ngay_lap')));
		$var_data=array(
            'name'=> $this->input->post('person_id'),
            'create_date'=>$ngay_lap,
            'noidung'=>$this->input->post('content_ctu')      
		);
		if( $this->$model->save($var_data,$var_id)){
            
            /* --;{(@  --;{(@  --;{(@  --;{(@  --;{(@  --;{(@  --;{(@  --;{(@ 
            * HAPPY WOMEN'S DAY VIETNAM 20/10/15  
            * from Hưng Audi 
            */
            //save chungtu_detail
            $var_id_tulip = $var_id == -1 ? $var_data['id'] : $var_id;
            $Flowers_data = array();
            foreach ($this->input->post('sotien') as $Tulip => $sotien) {
                foreach ($this->input->post('tk_no') as $Rose => $tk_no) {
                    if ($Tulip == $Rose) {
                        foreach ($this->input->post('tk_co') as $Violet => $tk_co) {
                            if ($Rose == $Violet) {
                                $Flowers_data[] = array(
                                    'chungtu_id' => $var_id_tulip,
                                    'sotien' => str_replace(',', '', $sotien),
                                    'tk_no' => $tk_no,
                                    'tk_co' => $tk_co
                                );
                            }
                            
                             //insert sale_cost_tkdu
                         if($var_id == -1){
                                if($tk_no == 131){
                                    $data_recv_cost_tkdu = array(
                                       'id_cost' => $var_id_tulip,
                                       'tkdu' => $tk_co,
                                       'money_no' => str_replace(',', '', $sotien),
                                       'money_co' => 0,
                                       'date' => date('Y-m-d H:i:s'),
                                       'customer_id' => $this->input->post('person_id'),
                                       'comment'=> $this->input->post('content_ctu'),
                                        'stt' => 0,
                                         'stt_cmt'=>1
                                        );
                                   $this->Cost->save_sale_cost_tkdu($data_recv_cost_tkdu);
                                }
                                if($tk_co == 131){
                                     $data_recv_cost_tkdu = array(
                                       'id_cost' => $var_id_tulip,
                                       'tkdu' => $tk_no,
                                       'money_no' => 0,
                                       'money_co' => str_replace(',', '', $sotien),
                                       'date' => date('Y-m-d H:i:s'),
                                       'customer_id' => $this->input->post('person_id'),
                                       'comment'=> $this->input->post('content_ctu'),
                                       'stt' => 0,
                                          'stt_cmt'=>1
                                        );
                                   $this->Cost->save_sale_cost_tkdu($data_recv_cost_tkdu);
                                }
                            }else{

                                    if($tk_no == 131){
                                        $all = $this->Chungtu->get_all_sale_cost();
                                    foreach ($all->result() as $value){
                                        if($value->id_cost == $var_id){
                                            $id = $value->id;
                                        }
                                    }
                                    $data_recv_cost_tkdu = array(
                                       'id_cost' => $var_id_tulip,
                                       'tkdu' => $tk_co,
                                       'money_no' => str_replace(',', '', $sotien),
                                       'money_co' => 0,
                                       'date' => date('Y-m-d H:i:s'),
                                       'customer_id' => $this->input->post('person_id'),
                                       'comment'=> $this->input->post('content_ctu'),
                                        'stt' => 0,
                                         'stt_cmt'=>1
                                        );
                                   $this->Cost->update_sale_cost_tkdu($data_recv_cost_tkdu,$id);
                                }
                                if($tk_co == 131){
                                    $all = $this->Chungtu->get_all_sale_cost();
                                    foreach ($all->result() as $value){
                                        if($value->id_cost == $var_id){
                                            $id = $value->id;
                                        }
                                    }
                                     $data_recv_cost_tkdu = array(
                                       'id_cost' => $var_id_tulip,
                                       'tkdu' => $tk_no,
                                       'money_no' => 0,
                                       'money_co' => str_replace(',', '', $sotien),
                                       'date' => date('Y-m-d H:i:s'),
                                       'customer_id' => $this->input->post('person_id'),
                                       'comment'=> $this->input->post('content_ctu'),
                                       'stt' => 0,
                                          'stt_cmt'=>1
                                        );
                                   $this->Cost->update_sale_cost_tkdu($data_recv_cost_tkdu,$id);
                                }
                                if($tk_no != 131 && $tk_co != 131){
                                     $all = $this->Chungtu->get_all_sale_cost();
                                    foreach ($all->result() as $value){
                                        if($value->id_cost == $var_id){
                                            $id = $value->id;
                                        }
                                    }
                                     $data_recv_cost_tkdu = array(
                                       'id_cost' => $var_id_tulip,
                                       'tkdu' => $tk_no,
                                       'money_no' => 0,
                                       'money_co' => str_replace(',', '', $sotien),
                                       'date' => date('Y-m-d H:i:s'),
                                       'customer_id' => $this->input->post('person_id'),
                                       'comment'=> $this->input->post('content_ctu'),
                                        'stt' => 1,
                                          'stt_cmt'=>1
                                        );
                                   $this->Cost->update_sale_cost_tkdu($data_recv_cost_tkdu,$id);
                                }
                                
                            }
                            //end
                        }   
                    }
                }
            }
            $this->$model->save_chungtu_detail($Flowers_data, $var_id_tulip);
            
            if($var_id==-1){
				echo json_encode(array('success'=>true,'message'=>lang('chungtus_successful_adding').' '.
				$var_data['name'],'id'=>$var_data['id']));
                $var_id = $var_data['id'];
			}else{
				echo json_encode(array('success'=>true,'message'=>lang('chungtus_successful_updating').' '.
				$var_data['name'],'id'=>$var_id));
			}
		}else{
			echo json_encode(array('success'=>false,'message'=>lang('chungtus_error_adding_updating').' '.
			$customertype_data['name'],'id'=>-1));
		}
	}
	function get_row(){
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
			echo json_encode(array('success'=>true,'message'=>lang('chungtus_successful_deleted')));
		}
		else
		{
		echo json_encode(array('success'=>false,'message'=>lang('giftcards_cannot_be_deleted')));
			echo 'that bai';
		}
	}
	function suggest()
	{
		
		$suggestions = $this->Chungtu->get_search_suggestions($this->input->get('term'),100);
		echo json_encode($suggestions);
	}
	function chungtu_search()
	{
		$model = $this->model_name;
		$suggestions = $this->$model->get_chungtu_search($this->input->get('term'),100);
		echo json_encode($suggestions);
	}
public function get_form_width()
	{			
		return 550;
	}
    //Hưng Audi 19-10-15 ~~~ vấn vương kỷ niệm
    function person_search_cost() {
        $suggestions = $this->Supplier->get_person_search_cost($this->input->get('term'), 1000);
        echo json_encode($suggestions);
    }
}

?>