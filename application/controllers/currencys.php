<?php

require_once ("secure_area.php");

class Currencys extends secure_area {

    public function __construct() {
        parent::__construct();
        $this->load->model('Currency');
        $this->load->model('Item');
    }

    public function index() {
        $this->check_action_permission('search');
        $config['base_url'] = site_url('currencys/sorting');
        $config['total_rows'] = $this->Currency->count_all();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 10;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_currency_manage_table($this->Currency->get_all($data['per_page']), $this);
        $this->load->view('currency/manage', $data);
    }

    public function sorting() {
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search) {
            $config['total_rows'] = $this->Currency->search_count_all($search);
            $table_data = $this->Currency->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'currency_name', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        }
        else {
            $config['total_rows'] = $this->Currency->count_all();
            $table_data = $this->Currency->get_all($per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        }
        $config['base_url'] = site_url('currencys/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_currency_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    public function search() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Currency->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'currency_name', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');        
        $config['base_url'] = site_url('currencys/search');
        $config['total_rows'] = $this->Currency->search_count_all($search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_currency_manage_table_data_rows($search_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    public function view($id = -1) {
        $data['info_currency'] = $this->Currency->get_info($id);
        $this->load->view("currency/form", $data);
    }

    public function save($type_id = -1) {
        $this->check_action_permission('add_update');
        $type_data = array(
            'currency_id' => $this->input->post('currency_id'),
            'currency_name' => $this->input->post('currency_name'),
            'currency_rate' => $this->input->post('currency_rate')
        );

        if ($this->Currency->save($type_data, $type_id)) {
            if ($type_id == -1) {
                echo json_encode(array('success' => true, 'message' => 'Thêm mới thành công ngoại tệ' . ' (' .
                    $type_data['currency_name'] . ')', 'id' => $type_data['type_id']));
                //$type_id = $type_data['type_id'];
            } else { //update
                echo json_encode(array('success' => true, 'message' => 'Cập nhật thành công ngoại tệ' . ' (' .
                    $type_data['currency_name'] . ')', 'id' => $type_id));
            }
        } else {//error
            echo json_encode(array('success' => false, 'message' => 'Đã xảy ra lỗi' . ' ' .
                $type_data['currency_name'], 'id' => -1));
        }
    }

    public function get_row() {
        $item_id = $this->input->post('row_id');
        $data_row = get_item_data_row($this->Item->get_info($item_id), $this);
        echo $data_row;
    }

    public function delete() {
        $this->check_action_permission('delete');
        $id = $this->input->post('ids');
        foreach ($id as $del) {
            if ($this->Currency->delete_list($del)) {
                echo json_encode(array('success' => false, 'message' => 'Xảy ra lỗi khi xóa '));
            } else {
                echo json_encode(array('success' => true, 'message' => 'Xóa thành công ngoại tệ '));
            }
        }
    }

    public function suggest() {

        $suggestions = $this->Currency->get_search_suggestions($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    public function get_form_width() {
        return 550;
    }


    public function check_name($type_id) {
        $type_name = $this->input->post('currency_name');
        if($type_id){
            $check = $this->Currency->get_name($type_name,$type_id);
        }else{
            $check = $this->Currency->get_name($type_name);
        }
        if($check > 0){
           echo json_encode(false);
        }else{
           echo json_encode(true);
        }
    }

     public function check_id($type_id) {
        $type_name = $this->input->post('currency_id');
        if($type_id){
            $check = $this->Currency->get_id($type_name,$type_id);
        }else{
            $check = $this->Currency->get_id($type_name);
        }
        if($check > 0){
           echo json_encode(false);
        }else{
           echo json_encode(true);
        }
    }
}

?>
