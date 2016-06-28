<?php

require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");

class Vendors extends Secure_area {

    function __construct() {
        parent::__construct('vendors');
        $this->load->model('Vendor_model');
    }

    function index() {

        $config['base_url'] = site_url('vendors/sorting');
        $config['total_rows'] = $this->Vendor_model->count_all();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['form_height'] = $this->get_form_height();
        $data['total_rows'] = $this->Vendor_model->count_all();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_vendors_manage_table($this->Vendor_model->get_all1($data['per_page']), $this);
        $data['units'] = $this->Vendor_model->get_all();
        $this->load->view('vendors/manage', $data);
    }

    //check trùng tên
    function checkname($id) {
        $name = $this->input->post('title');
        $d['name'] = $this->Vendor_model->getname($id);
        foreach ($d['name'] as $d2) {
            $d3[] = $d2['name'];
        }
        $c2 = $d3;
        $e1 = implode(',', $c2);
        $e2 = explode(',', $e1);

        if (in_array($name, $e2)) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    function suggest234() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search) {
            $config['total_rows'] = $this->Vendor_model->search_count_all($search);
            $table_data = $this->Vendor_model->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        } else {
            $config['total_rows'] = $this->Vendor_model->count_all();
            $table_data = $this->Vendor_model->get_all1($per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        }
        $config['base_url'] = site_url('vendors/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_vendors_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function sorting() {
        //$this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search) {
            $config['total_rows'] = $this->Vendor_model->search_count_all($search);
            $table_data = $this->Vendor_model->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        } else {
            $config['total_rows'] = $this->Vendor_model->count_all();
            $table_data = $this->Vendor_model->get_all1($per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        }
        $config['base_url'] = site_url('vendors/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_vendors_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function search123() {
        //$this->check_action_permission('search');
        $search = $this->input->post('search');
        $cat = $this->input->post('cat');
        //$per_page= 50;
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Vendor_model->search($search, $cat, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        $config['base_url'] = site_url('vendors/search');
        $config['total_rows'] = $this->Vendor_model->search_count_all($search, $cat);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_vendors_manage_table_data_rows($search_data, $this);

        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function search() {
        //$this->check_action_permission('search');
        $search = $this->input->post('search');
        //$cat=$this->input->post('cat');
        //$per_page= 50;
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Vendor_model->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        $config['base_url'] = site_url('vendors/search');
        $config['total_rows'] = $this->Vendor_model->search_count_all($search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_vendors_manage_table_data_rows($search_data, $this);

        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function suggest() {
        $suggestions = $this->Vendor_model->get_search_suggestions($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    function save($id_support = -1) {
        $this->check_action_permission('add_update');
        /* phan them anh */
        $item_data = array(
            'link' => $this->input->post('link')
        );
        if (isset($_FILES['img']['name']) && $_FILES['img']['name'] != null) {

            $config['upload_path'] = './vendors/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '100000';
            $config['max_width'] = '10000';
            $config['max_height'] = '1024';
            $this->load->library('upload', $config);

            if ($this->upload->do_upload("img")) {
                $fileInfo = $this->upload->data();

                $item_data['images'] = $fileInfo['file_name'];
            }
        }
        if ($this->Vendor_model->save($item_data, $id_support)) {
            //New item
            if ($id_support == -1) {
                echo json_encode(array('success' => true, 'message' => 'Thêm mới thành công'));
            } else { //previous item
                echo json_encode(array('success' => true, 'message' => 'Cập nhật thành công'));
            }
        } else {//failure
            echo json_encode(array('success' => false, 'message' => 'Có lỗi xảy ra'));
        }
        redirect('./vendors');
    }

    function suggest_unit() {
        $suggestions = $this->Vendor_model->get_unit_suggestions($this->input->get('term'));
        echo json_encode($suggestions);
    }

    function view($id_support = -1) {

        $this->check_action_permission('add_update');
        $data = array();
        $data['support_info'] = $this->Vendor_model->get_info($id_support);
        $this->load->view("vendors/form", $data);
    }

    function delete() {

        $this->check_action_permission('delete');
        $id = $this->input->post('ids');
        foreach ($id as $ids) {
            $this->Vendor_model->delete_list($ids);
            echo json_encode(array('success' => true, 'message' => 'Bạn đã xóa thành công '));
        }
    }

    function get_select_inventory() {
        return $this->session->userdata('select_inventory') ? $this->session->userdata('select_inventory') : 0;
    }

    function clear_select_inventory() {
        $this->session->unset_userdata('select_inventory');
    }

    function get_info($id_unit = -1) {
        echo json_encode($this->Vendor_model->get_info($id_unit));
    }

    function get_form_width() {
        return 1190;
    }

    function get_form_height() {
        return 500;
    }

}
