<?php

require_once ("secure_area.php");

class Account_type extends secure_area {

    public function __construct() {
        parent::__construct();
        $this->load->model('Account_type_model');
        $this->load->model('Item');
    }

    public function index() {
        $this->check_action_permission('search');
        $config['base_url'] = site_url('account_type/sorting');
        $config['total_rows'] = $this->Account_type_model->count_all();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 10;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_account_type_manage_table($this->Account_type_model->get_all($data['per_page']), $this);
        $this->load->view('account_type/manage', $data);
    }

    public function sorting() {
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search) {
            $config['total_rows'] = $this->Account_type_model->search_count_all($search);
            $table_data = $this->Account_type_model->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'type_name', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        }
        else {
            $config['total_rows'] = $this->Account_type_model->count_all();
            $table_data = $this->Account_type_model->get_all($per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'type_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        }
        $config['base_url'] = site_url('account_type/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_account_type_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    public function search() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Account_type_model->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'type_name', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');        
        $config['base_url'] = site_url('account_type/search');
        $config['total_rows'] = $this->Account_type_model->search_count_all($search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_account_type_manage_table_data_rows($search_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    public function view($var_id = -1) {
        $data['type_info'] = $this->Account_type_model->get_info($var_id);
        $this->load->view("account_type/form", $data);
    }

    public function save($type_id = -1) {
        $this->check_action_permission('add_update');
        $type_data = array(
            'type_name' => $this->input->post('type_name')
        );

        if ($this->Account_type_model->save($type_data, $type_id)) {
            if ($type_id == -1) {
                echo json_encode(array('success' => true, 'message' => 'Thêm mới thành công loại tài khoản' . ' (' .
                    $type_data['type_name'] . ')', 'type_id' => $type_data['type_id']));
                //$type_id = $type_data['type_id'];
            } else { //update
                echo json_encode(array('success' => true, 'message' => 'Cập nhật thành công loại tài khoản' . ' (' .
                    $type_data['type_name'] . ')', 'type_id' => $type_id));
            }
        } else {//error
            echo json_encode(array('success' => false, 'message' => 'Đã xảy ra lỗi' . ' ' .
                $type_data['type_name'], 'type_id' => -1));
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
            $check_type = $this->Account_type_model->check_account_type($del);
            $info_name = $this->Account_type_model->get_info($del)->type_name;
            if ($check_type > 0) {
                echo json_encode(array('success' => false, 'message' => 'Loại tài khoản(' . $info_name . ') đã tồn tại loại tài khoản con ! Bạn không được xóa'));
                return;
            }

            if ($this->Account_type_model->delete_list($del)) {
                echo json_encode(array('success' => false, 'message' => 'Xảy ra lỗi khi xóa loại tài khoản ' . $info_name));
            } else {
                echo json_encode(array('success' => true, 'message' => 'Xóa thành công loại tài khoản (' . $info_name.')'));
            }
        }
    }

    public function suggest() {

        $suggestions = $this->Account_type_model->get_search_suggestions($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    public function get_form_width() {
        return 550;
    }

    //check trùng tên dungbv
    public function check_name($type_id) {
        $type_name = $this->input->post('type_name');
        if($type_id){
            $check = $this->Account_type_model->get_name($type_name,$type_id);
        }else{
            $check = $this->Account_type_model->get_name($type_name);
        }
        if($check > 0){
           echo json_encode(false);
        }else{
           echo json_encode(true);
        }
    }

}

?>
