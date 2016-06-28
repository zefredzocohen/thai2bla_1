<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");

class Category_processes extends Secure_area {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $config['base_url'] = site_url('category_processes/sorting');
        $config['total_rows'] = $this->M_category_processes->count_all();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['total_rows'] = $this->M_category_processes->count_all();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_category_processes_manage_table($this->M_category_processes->get_all($data['per_page']), $this);
        $this->load->view('category_processes/manage', $data);
    }

    public function sorting() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search) {
            $config['total_rows'] = $this->M_category_processes->search_count_all($search);
            $table_data = $this->M_category_processes->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'cat_pro_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        } else {
            $config['total_rows'] = $this->M_category_processes->count_all();
            $table_data = $this->M_category_processes->get_all($per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'cat_pro_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        }
        $config['base_url'] = site_url('category_processes/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_category_processes_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    public function search() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;

        $search_data = $this->M_category_processes->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'cat_pro_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        $config['base_url'] = site_url('category_processes/search');
        $config['total_rows'] = $this->M_category_processes->search_count_all($search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_category_processes_manage_table_data_rows($search_data, $this);

        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    public function suggest() {
        $suggestions = $this->M_category_processes->get_search_suggestions($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    function get_row() {
        $cat_pro_id = $this->input->post('row_id');
        $data_row = get_category_processes_data_row($this->M_category_processes->get_info($cat_pro_id), $this);
        echo $data_row;
    }

    public function view($cat_pro_id = -1) {
        $this->check_action_permission('add_update');
        $data = array();
        $data['info_cat_pro'] = $this->M_category_processes->get_info($cat_pro_id);
        $this->load->view("category_processes/form", $data);
    }

    public function save($cat_pro_id = -1) {
        $this->check_action_permission('add_update');
        $data = array(
            'cat_pro_name' => $this->input->post('cat_pro_name')
        );

        if ($this->M_category_processes->save($data, $cat_pro_id)) {
            //New item
            if ($cat_pro_id == -1) {
                echo json_encode(array('success' => true, 'message' => 'Thêm mới nhóm công đoạn (' . $data['cat_pro_name'] . ') thành công!', 'cat_pro_id' => $data['cat_pro_id']));
                $cat_pro_id = $data['cat_pro_id'];
            } else { //previous item
                echo json_encode(array('success' => true, 'message' => 'Cập nhật nhóm công đoạn (' . $data['cat_pro_name'] . ') thành công!', 'cat_pro_id' => $data['cat_pro_id']));
            }
        } else {//failure
            echo json_encode(array('success' => false, 'message' => 'Lỗi thêm hoặc cập nhật nhóm công đoạn (' . $data['cat_pro_name'] . ')!', 'cat_pro_id' => -1));
        }
    }

    public function delete() {
        $this->check_action_permission('delete');
        $cat_pro_ids = $this->input->post("ids");
        $name_cat_pro = array();
        foreach ($cat_pro_ids as $cat_pro_id) {
            $check_processes = $this->M_category_processes->get_cat_pro_in_processes($cat_pro_id);
            $info_cat_pro = $this->M_category_processes->get_info($cat_pro_id);
            if ($check_processes) {
                $name_cat_pro[] = $info_cat_pro->cat_pro_name;
            }
        }
        if (count($name_cat_pro) > 0) {
            $msg = "";
            for ($i = 0; $i < count($name_cat_pro); $i++) {
                $msg .= $name_cat_pro[$i] . ", ";
            }
            echo json_encode(array('success' => false, 'message' => 'Lỗi xóa không thành công! nhóm công đoạn (' . rtrim(rtrim($msg),',') . ') đã được sử dụng'));
        } else {
            if ($this->M_category_processes->delete_list($cat_pro_ids)){
                echo json_encode(array('success' => true, 'message' => 'Bạn đã xóa thành công'));
            } else {
                echo json_encode(array('success' => false, 'message' => 'Lỗi xóa dữ liệu! Vui lòng kiểm tra lại'));
            }
        }        
    }

}
