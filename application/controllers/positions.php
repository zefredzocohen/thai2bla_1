<?php
require_once ("person_controller.php");
class Positions extends Person_controller
{
    function __construct(){
        parent::__construct();
        $this->_item = $this->session->userdata('person_id');
        $this->_controller = strtolower(get_class());
    }


    /*
     * Show information of the table status
     * */
    function index()
    {
        $this->check_action_permission('search');
        $config['base_url'] = site_url($this->_controller.'/sorting');
        $config['total_rows'] = $this->Jobs_positions->count_all();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name']= strtolower(get_class());
        $data['form_width']= $this->get_form_width();
        $data['form_width_module']= $this->get_form_module_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_positions_table($this->Jobs_positions->get_all($data['per_page']),$this);

        $this->load->view('jobs/'.$this->_controller.'/index',$data);
    }

    /* module status */
    function view($id = -1)
    {
        $this->check_action_permission('add_update');
        $data['jobs_positions'] = $this->Jobs_positions->get_info($id);

        $this->load->view("jobs/".$this->_controller."/form",$data);
    }

    function sorting()
    {
        $this->check_action_permission('search');
        $search=$this->input->post('search');
        $per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        if ($search)
        {
            $config['total_rows'] = $this->Jobs_positions->search_count_all($search);
            $table_data = $this->Jobs_positions->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_positions_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'ASC');
        }
        else
        {
            $config['total_rows'] = $this->Jobs_positions->count_all();
            $table_data = $this->Jobs_positions->get_all($per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_positions_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'ASC');
        }
        $config['base_url'] = site_url( $this->_controller.'/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table']= get_positions_manage_table_data_rows($table_data,$this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }
    /**/

    function search()
    {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $search_data=$this->Jobs_positions->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_positions_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'DESC');
        $config['base_url'] = site_url($this->_controller.'/search');
        $config['total_rows'] = $this->Jobs_positions->search_count_all($search);
        $config['per_page'] = $per_page ;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table']= get_positions_manage_table_data_rows($search_data,$this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));

    }


    function suggest()
    {
        $suggestions = $this->Jobs_positions->get_search_suggestions($this->input->get('term'),100);
        echo json_encode($suggestions);
    }


   public function save($id = -1)
    {
        $jobs_data = array(
            'jobs_positions_name' => $this->input->post('jobs_positions_name'), 
            'jobs_positions_description' => $this->input->post('jobs_positions_description') == '' ? '' : $this->input->post('jobs_positions_description'),
            'jobs_positions_date' => date('Y-m-d',strtotime($this->input->post('jobs_positions_date'))) == '' ? date('Y-m-d') : date('Y-m-d',strtotime($this->input->post('jobs_positions_date'))),
            'jobs_positions_color' => $this->input->post('jobs_positions_color') == '' ? "#000" : $this->input->post('jobs_positions_color')
        );

        if($this->Jobs_positions->checkRegionsName($jobs_data['jobs_positions_name'],$id) > 0){
            echo json_encode(array('error'=> 'false','message'=>lang($this->_controller.'_message_error').$jobs_data['jobs_positions_name'] .') đã được sử dụng !'));
        }else{
			$checkSave = $this->input->post('check_hidden');
			if($checkSave == 1){
				if($this->Jobs_positions->save($jobs_data, $id)){
					echo json_encode(array('success'=>true,'message'=>lang($this->_controller.'_successful_adding').' '.$jobs_data['jobs_positions_name']. ")"));
				}else{
					echo json_encode(array(('message')=>lang($this->_controller.'_message_success').$jobs_data['jobs_positions_name'] .' ) này !'));
				}
			}else{
				echo json_encode(array('error'=>'false','message'=>'Bạn có thể sử dụng tên chức danh này !'));
			}
		}   
    }


//    function delete()
//    {
//        $this->check_action_permission('delete');
//        $id = $this->input->post('ids');
//
//        if($this->Jobs_positions->delete_list($id))
//        {
//            echo json_encode(array('success'=>true,'message'=>lang($this->_controller.'_successful_deleted').'( '.
//                count($id).' ) '.lang($this->_controller.'_one_or_multiple')));
//        }else{
//            echo json_encode(array('success'=>false,'message'=>lang($this->_controller.'_cannot_be_deleted')));
//        }
//    }
    function delete() {

        $this->check_action_permission('delete');
        $categories_to_delete = $this->input->post('ids');
        $select_inventory = $this->get_select_inventory();
        $total_rows = $select_inventory ? $this->Jobs_positions->count_all() : count($categories_to_delete);
        //clears the total inventory selection
        $this->clear_select_inventory();
        if ($this->Jobs_positions->delete_list($categories_to_delete)) {

            echo json_encode(array('success' => true, 'message' => lang($this->_controller.'_successful_deleted') . ' ' .
                $total_rows . ' ' . lang($this->_controller.'_one_or_multiple')));
        } else {
            echo json_encode(array('success' => false, 'message' => lang($this->_controller.'_cannot_be_deleted')));
        }
    }
    /*

   /*
   get the width for the add/edit form
   */
    function get_row() {
        $id = $this->input->post('row_id');
        $info = $this->Jobs_positions->get_info($id);
        $data_row = get_item_data_row($info, $this);
        echo $data_row;
    }
    
    function get_form_width()
    {
        return 800;
    }
    function get_form_module_width()
    {
        return 400;
    }
    function get_name($id)
    {
        return $this->Jobs_positions->get_name_info($id);
    }

}
