<?php

require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");

class Contact_admin extends Secure_area {

    function __construct() {
        parent::__construct('contact_admin');
        $this->load->model('Contacts_admin');
             
    }

    function index() {
        $config['base_url'] = site_url('contact_admin/sorting');
        $config['total_rows'] = $this->Contacts_admin->count_all();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['form_height'] = $this->get_form_height();
        $data['total_rows'] = $this->Contacts_admin->count_all();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_contact_admin_manage_table($this->Contacts_admin->get_all1($data['per_page']), $this);
        $data['units'] = $this->Contacts_admin->get_all();
        $this->load->view('contact_admin/manage', $data);
    }

   

    function suggest234() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search) {
            $config['total_rows'] = $this->Contacts_admin->search_count_all($search);
            $table_data = $this->Contacts_admin->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'fullname', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        } else {
            $config['total_rows'] = $this->Contacts_admin->count_all();
            $table_data = $this->Contacts_admin->get_all1($per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'fullname', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        }
        $config['base_url'] = site_url('contact_admin/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_contact_admin_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function sorting() {
        //$this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search) {
            $config['total_rows'] = $this->Contacts_admin->search_count_all($search);
            $table_data = $this->Contacts_admin->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'fullname', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        } else {
            $config['total_rows'] = $this->Contacts_admin->count_all();
            $table_data = $this->Contacts_admin->get_all1($per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        }
        $config['base_url'] = site_url('contact_admin/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_contact_admin_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function search123() {
        //$this->check_action_permission('search');
        $search = $this->input->post('search');
        $cat = $this->input->post('cat');
        //$per_page= 50;
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Contacts_admin->search($search, $cat, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        $config['base_url'] = site_url('contact_admin/search');
        $config['total_rows'] = $this->Contacts_admin->search_count_all($search, $cat);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_contact_admin_manage_table_data_rows($search_data, $this);

        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function search() {
        //$this->check_action_permission('search');
        $search = $this->input->post('search');
        //$cat=$this->input->post('cat');
        //$per_page= 50;
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Contacts_admin->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        $config['base_url'] = site_url('contact_admin/search');
        $config['total_rows'] = $this->Contacts_admin->search_count_all($search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_contact_admin_manage_table_data_rows($search_data, $this);

        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function suggest() {
        $suggestions = $this->Contacts_admin->get_search_suggestions($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    
    function suggest_unit() {
        $suggestions = $this->Contacts_admin->get_unit_suggestions($this->input->get('term'));
        echo json_encode($suggestions);
    }

	

    function view($id = -1) {
        $data = array();
        $data['contact_info'] = $this->Contacts_admin->get_info($id);
        $this->load->view("contact_admin/view",$data);
    }



    function delete() {

        //$this->check_action_permission('delete');
        $units_to_delete = $this->input->post('ids');
        foreach ($units_to_delete as $id){
            $this->Contacts_admin->delete_list($id);
            echo json_encode(array('success' => true, 'message' => 'Bạn đã xóa liên hệ thành công'));
        }

    }




    function get_select_inventory() {
        return $this->session->userdata('select_inventory') ? $this->session->userdata('select_inventory') : 0;
    }

    function clear_select_inventory() {
        $this->session->unset_userdata('select_inventory');
    }

    function get_info($id_unit = -1) {
        echo json_encode($this->Contacts_admin->get_info($id_unit));
    }

    function get_form_width() {
        return 360;
    }

    function get_form_height() {
        return 300;
    }

}
