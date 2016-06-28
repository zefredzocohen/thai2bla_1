<?php
require_once ("secure_area.php");
class Account_plan extends Secure_area {
    function __construct() {
        parent::__construct('account_plan');
        $this->load->model('Tkdu');
    }
    function index() {
        $config['base_url'] = site_url('account_plan/sorting');
        $config['total_rows'] = $this->Tkdu->count_all_account_plan();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_account_plan_manage_table($this->Tkdu->get_all_account_plan($data['per_page']), $this);
        $this->load->view('account_plan/manage', $data);
    }
    function sorting() {
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search) {
            $config['total_rows'] = $this->Tkdu->search_count_all_account_plan($search);
            $table_data = $this->Tkdu->search_account_plan(
                $search, $per_page, 
                $this->input->post('offset') ? $this->input->post('offset') : 0, 
                $this->input->post('order_col') ? $this->input->post('order_col') : 'id', 
                $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
            );
        } else {
            $config['total_rows'] = $this->Tkdu->count_all_account_plan();
            $table_data = $this->Tkdu->get_all_account_plan(
                $per_page, 
                $this->input->post('offset') ? $this->input->post('offset') : 0, 
                $this->input->post('order_col') ? $this->input->post('order_col') : 'id', 
                $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
            );
        }
        $config['base_url'] = site_url('account_plan/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_account_plan_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }
    function search() {
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Tkdu->search_account_plan(
            $search, $per_page, 
            $this->input->post('offset') ? $this->input->post('offset') : 0, 'id', 
            $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
        );
        $config['base_url'] = site_url('account_plan/search');
        $config['total_rows'] = $this->Tkdu->search_count_all_account_plan($search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_account_plan_manage_table_data_rows($search_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }
    function suggest() {
        $suggestions = $this->Tkdu->get_search_suggestions_account_plan($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }
    function view($id = -1) {
        $data['id'] = $id;
        $data['cost_info'] = $this->Tkdu->get_info_account_plan($id);
        $data['list_tkdu_parents'] = $this->Tkdu->get_tkdu_parent();
        $this->load->view("account_plan/form", $data);
    }
    function save($id=-1){
        $data=array(
            'name'=> $this->input->post('name'),
            'tk_co'=>$this->input->post('tk_co'),
            'tk_no'=>$this->input->post('tk_no'),
        );
        if( $this->Tkdu->save_account_plan($data,$id)){
            if($id==-1){
                echo json_encode(array(
                    'success'=>true,
                    'message'=>lang('common_successful_adding'),
                ));
            }else{
                echo json_encode(array(
                    'success'=>true,
                    'message'=>lang('common_successful_updating'),
                ));
            }
        }else{
            echo json_encode(array(
                'success'=>false,
                'message'=>lang('items_error_adding_updating')
            ));
        }
    }
    function delete() {
        $cost_to_delete = $this->input->post('ids');
        if ($this->Tkdu->delete_list_account_plan($cost_to_delete)) {
            echo json_encode(array('success' => true, 'message' => lang('items_successful_deleted')));
        } else {
            echo json_encode(array('success' => false, 'message' => lang('items_cannot_be_deleted')));
        }
    }


     
}

?>