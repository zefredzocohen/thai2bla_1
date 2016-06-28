<?php

require_once ("secure_area.php");

class Projects_tasks extends secure_area {

    public function __construct() {
        parent::__construct();
        $this->load->library('sale_lib');
        $this->load->library('receiving_lib');
    }

    public function index() {
        $this->check_action_permission('search');
        $config['base_url'] = site_url('projects_tasks/sorting');
        $config['total_rows'] = $this->Projects_task->count_all();
        $data['result_array'] = $this->Projects_task->get_all();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 10;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_projects_tasks_type_manage_table($this->Projects_task->get_all($data['per_page']), $this);
        $this->load->view('projects_tasks/manage', $data);
    }

    public function sorting() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search) {
            $config['total_rows'] = $this->Projects_task->search_count_all($search);
            $table_data = $this->Projects_task->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'text', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        } else {
            $config['total_rows'] = $this->Projects_task->count_all();
            $table_data = $this->Projects_task->get_all($per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'text', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        }
        $config['base_url'] = site_url('projects_tasks/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_projects_tasks_type_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function search() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Projects_task->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'text', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        $config['base_url'] = site_url('projects_tasks/search');
        $config['total_rows'] = $this->Projects_task->search_count_all($search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_projects_tasks_type_manage_table_data_rows($search_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function suggest() {
        $suggestions = $this->Projects_task->get_search_suggestions($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    public function view($customertype = -1) {
        $this->check_action_permission('add_update');
        $data['projects_tasks'] = $this->Projects_task->get_info($customertype);
        $this->load->view("projects_tasks/form", $data);
    }

    public function save($customertype_id = -1) {
        $config = array(
            'upload_path' => './file/contract',
            'allowed_types' => 'doc|docx|pdf',
        );
        $this->load->library('upload', $config);
        $this->upload->do_upload('contract_file');
        // $file_data_contract_vitae=$this->upload->data(); 
        if (!$this->upload->do_upload('contract_file')) {
            $error = array(
                'errors' => $this->upload->display_errors(),
            );
        } else {
            $file_data_contract_vitae = $this->upload->data();
        }
        if ($id != -1) {
            $data = $this->Contractcustomers->get_info_one_more_contract($id);
            if (empty($file_data_contract_vitae)) {
                $file_data_contract_vitae['file_name'] = $data->contract_file;
            }
        }
        $this->check_action_permission('add_update');
        $emp_name = $this->input->post('emp_name');
        $customertype_data = array(
            'text' => $this->input->post('projects_tasks_name'),
            'start_date' => date('Y-m-d', strtotime($this->input->post('project_task_start_date'))),
            'duration' => $this->input->post('duration'),
            'progress' => $this->input->post('progress')/100,
            'parent' => $this->input->post('projects_tasks_desc'),
            'emp_id' => $emp_name
        );
        if ($this->Projects_task->save($customertype_data, $customertype_id)) {
            if ($customertype_id == -1) {
                echo json_encode(array('success' => true, 'message' => lang('projects_tasks_successful_adding') . ' ' .$customertype_data['text'], 'id' => $customertype_data['id']));
                    $customertype_id = $customertype_data['id'];
            } else { //previous giftcard

                echo json_encode(array('success' => true, 'message' => lang('projects_tasks_successful_updating') . ' ' .
                    $customertype_data['text'], 'id' => $customertype_id));
            }
        } else {//failure
            echo 'that bai';
            echo json_encode(array('success' => false, 'message' => lang('projects_tasks_error_adding_updating') . ' ' .
                $customertype_data['text'], 'id' => -1));
        }
    }

    function get_row() {
        $item_id = $this->input->post('row_id');
        $data_row = get_item_data_row($this->Projects_task->get_info($item_id), $this);
        echo $data_row;
    }

    public function delete() {
        $id = $this->input->post('ids');
        if ($this->Projects_task->delete_list($id)) {
            echo json_encode(array('success' => true, 'message' => lang('giftcards_successful_deleted')));
        } else {
            echo json_encode(array('success' => false, 'message' => lang('giftcards_cannot_be_deleted')));
            echo 'that bai';
        }
    }

    public function get_form_width() {
        return 500;
    }

}

