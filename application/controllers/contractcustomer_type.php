<?php

require_once ("secure_area.php");

class Contractcustomer_type extends secure_area {

    public function __construct() {
        parent::__construct();
        $this->load->library('sale_lib');
        $this->load->library('receiving_lib');
    }

    public function index() {
        $this->check_action_permission('search');
        $config['base_url'] = site_url('contractcustomer_type/sorting');
        $config['total_rows'] = $this->Contractcustomer_types->count_all();
        $data['result_array'] = $this->Contractcustomer_types->get_all();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 10;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_contract_customer_type_manage_table($this->Contractcustomer_types->get_all($data['per_page']), $this);
        $this->load->view('contractcustomer_type/manage', $data);
    }

    public function sorting() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search) {
            $config['total_rows'] = $this->Contractcustomer_types->search_count_all($search);
            $table_data = $this->Contractcustomer_types->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'last_name', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        } else {
            $config['total_rows'] = $this->Contractcustomer_types->count_all();
            $table_data = $this->Contractcustomer_types->get_all($per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        }
        $config['base_url'] = site_url('contractcustomer_type/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_contract_customer_type_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function search() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Contractcustomer_types->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        $config['base_url'] = site_url('contractcustomer_type/search');
        $config['total_rows'] = $this->Contractcustomer_types->search_count_all($search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_contract_customer_type_manage_table_data_rows($search_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function suggest() {
        $suggestions = $this->Contractcustomer_types->get_search_suggestions($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    public function view($customertype = -1) {
        $this->check_action_permission('add_update');
        $data['contractcustomer_type'] = $this->Contractcustomer_types->get_info($customertype);
        $this->load->view("contractcustomer_type/form", $data);
    }

    public function save($customertype_id = -1) {
        $customertype_data = array(
            'name' => $this->input->post('contractcustomer_type_name'),
            'code' => $this->input->post('contractcustomer_type_code'),
            'description' => $this->input->post('contractcustomer_type_desc')
        );
        if ($this->Contractcustomer_types->save($customertype_data, $customertype_id)) {
            if ($customertype_id == -1) {
                echo json_encode(array('success' => true, 'message' => lang('contractcustomers_successful_adding') . ' ' .$customertype_data['name'], 'id' => $customertype_data['id']));
                    $customertype_id = $customertype_data['id'];
            } else { //previous giftcard

                echo json_encode(array('success' => true, 'message' => lang('contractcustomers_successful_updating') . ' ' .
                    $customertype_data['name'], 'id' => $customertype_id));
            }
        } else {//failure
            echo 'that bai';
            echo json_encode(array('success' => false, 'message' => lang('contractcustomers_error_adding_updating') . ' ' .
                $customertype_data['name'], 'id' => -1));
        }
    }

    function get_row() {
        $item_id = $this->input->post('row_id');
        $data_row = get_item_data_row($this->Contractcustomer_types->get_info($item_id), $this);
        echo $data_row;
    }

    public function delete() {
        $id = $this->input->post('ids');
        if ($this->Contractcustomer_types->delete_list($id)) {
            echo json_encode(array('success' => true, 'message' => lang('giftcards_successful_deleted')));
        } else {
            echo json_encode(array('success' => false, 'message' => lang('giftcards_cannot_be_deleted')));
            echo 'that bai';
        }
    }

    public function get_form_width() {
        return 400;
    }

}

