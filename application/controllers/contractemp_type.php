<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of contractemp_type
 *
 * @author HUNG
 */
require_once ("secure_area.php");

class Contractemp_type extends secure_area {

    public function __construct() {
        parent::__construct();
        $this->load->library('sale_lib');
        $this->load->library('receiving_lib');
    }

    public function index() {
        
        $this->check_action_permission('search');
        $config['base_url'] = site_url('contractemp_type/sorting');
        $config['total_rows'] = $this->Contractemp_types->count_all();
        $data['result_array'] = $this->Contractemp_types->get_all();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 10;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_contract_employees_type_manage_table($this->Contractemp_types->get_all($data['per_page']), $this);
        $this->load->view('contractemp_type/manage', $data);
    }

    public function sorting() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search) {
            $config['total_rows'] = $this->Contractemp_types->search_count_all($search);
            $table_data = $this->Contractemp_types->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'code', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        } else {
            $config['total_rows'] = $this->Contractemp_types->count_all();
            $table_data = $this->Contractemp_types->get_all($per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'ten_maloai_hopdong', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        }
        $config['base_url'] = site_url('contractemp_type/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_contract_employees_type_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function search() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Contractemp_types->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'ten_maloai_hopdong', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        $config['base_url'] = site_url('contractemp_type/search');
        $config['total_rows'] = $this->Contractemp_types->search_count_all($search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_contract_employees_type_manage_table_data_rows($search_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }
    
    function suggest() {
        $suggestions = $this->Contractemp_types->get_search_suggestions($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    public function view($customertype = -1) {
        $this->check_action_permission('add_update');
        $data['contractemp_type'] = $this->Contractemp_types->get_info($customertype);
        $this->load->view("contractemp_type/form", $data);
    }

    public function save($customertype_id = -1) {
        $customertype_data = array(
            'ten_maloai_hopdong' => $this->input->post('contractemp_type_name'),
            'code' => $this->input->post('contractcustomer_type_code'),
            'mota_loaihopdong' => $this->input->post('contractemp_type_desc')
        );
        if ($this->Contractemp_types->save($customertype_data, $customertype_id)) {
            if ($customertype_id == -1) {
                echo json_encode(array('success' => true, 'message' => lang('contractcustomers_successful_adding') . ' ' .$customertype_data['ten_maloai_hopdong'], 'id_ma_hopdong' => $customertype_data['id_ma_hopdong']));
                    $customertype_id = $customertype_data['id_ma_hopdong'];
            } else { //previous giftcard
                echo json_encode(array('success' => true, 'message' => lang('contractcustomers_successful_updating') . ' ' .
                    $customertype_data['ten_maloai_hopdong'], 'id_ma_hopdong' => $customertype_id));
            }
        } else {//failure
            echo 'that bai';
            echo json_encode(array('success' => false, 'message' => lang('contractcustomers_error_adding_updating') . ' ' .
                $customertype_data['ten_maloai_hopdong'], 'id_ma_hopdong' => -1));
        }
    }

    function get_row() {
        $id = $this->input->post('row_id');
        $data_row = get_item_data_row($this->Contractemp_types->get_info($id), $this);
        echo $data_row;
    }

    public function delete() {
        $id = $this->input->post('ids');
        if ($this->Contractemp_types->delete_list($id)) {
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

