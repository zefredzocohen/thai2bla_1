<?php

require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");

class Contracts extends Secure_area {

    function __construct() {
        parent::__construct();
        $this->load->library('sale_lib');
        $this->load->library('receiving_lib');
    }

    public function index() {
        $config['total_rows'] = $this->Contract->count_all();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['form_width'] = $this->get_form_width();
        $data['form_height'] = $this->get_form_height();
        $data['total_rows'] = $this->Contract->count_all();
        $data['per_page'] = $config['per_page'];
        $data['controller_name'] = strtolower(get_class());
        $data['manage_table'] = get_hopdong_manage_table($this->Contract->get_all($data['per_page']), $this);
        $this->load->view('contract/manage', $data);
    }

    /*
      Loads the employee edit form
     */

    function view($jobs_id = -1) {
        $data['jobs_employees'] = $this->Jobs_employees->get_jobs_employees_info($jobs_id);
        //$data['employees_info']= $this->Jobs_employees->get_manager_employees($this->_item);
        $data['name_peron_info'] = $this->Jobs_department->get_person_info();
        $data['city_info'] = $this->Jobs_department->get_city_action();
        $data['affiliates_info'] = $this->Jobs_department->get_affiliates_name();
        $data['regions_info'] = $this->Jobs_department->get_regions_info();
        $data['department_info'] = $this->Jobs_department->get_department_name();
        $data['contract_info'] = $this->Contract->get_info($jobs_id);

        $this->load->view("contract/jobs_employees/form", $data);
    }

    function loadRegions($id = -1) {
        $regions_id = $this->input->post('jobs_regions_id');

        $data['city_info'] = $this->Jobs_employees->getAllCity($regions_id);
        $items = array();
        foreach ($data['city_info'] AS $key => $values) {
            $items[] = $values->jobs_city_id;
        }
        $data['affiliates_info'] = $this->Jobs_employees->getActionAffiliates($id, $items);
        $item_department = array();

        foreach ($data['affiliates_info'] AS $values) {
            $item_department[] = $values->jobs_affiliates_id;
        }
        $item_department = implode($item_department, ',');
        $data['department_info'] = $this->Jobs_employees->getActionsDepartment($id, $item_department);

        $item_employees = array();

        foreach ($data['department_info'] AS $values) {
            $item_employees[] = $values->department_id;
        }
        $item_employees = implode($item_employees, ',');
        $data['employees_info'] = $this->Jobs_employees->getActionsEmployees($id, $item_employees);

        $this->load->view("jobs/employees/jobs_employees/form_action_regions", $data);
    }

    function loadCity($id = -1) {
        $city_id = $this->input->post('jobs_city_id');

        $data['affiliates_info'] = $this->Jobs_employees->getActionAffiliates($id, $city_id);
        $item_department = array();

        foreach ($data['affiliates_info'] AS $values) {
            $item_department[] = $values->jobs_affiliates_id;
        }
        $item_department = implode($item_department, ',');
        $data['department_info'] = $this->Jobs_employees->getActionsDepartment($id, $item_department);

        $item_employees = array();

        foreach ($data['department_info'] AS $values) {
            $item_employees[] = $values->department_id;
        }
        $item_employees = implode($item_employees, ',');
        $data['employees_info'] = $this->Jobs_employees->getActionsEmployees($id, $item_employees);

        $this->load->view("jobs/employees/jobs_employees/form_action_city", $data);
    }

    function loadAffiliates($id = -1) {
        $affiliates_id = $this->input->post('jobs_affiliates_id');

        $data['department_info'] = $this->Jobs_employees->getActionsDepartment($id, $affiliates_id);
        $item_employees = array();

        foreach ($data['department_info'] AS $values) {
            $item_employees[] = $values->department_id;
        }
        $item_employees = implode($item_employees, ',');
        $data['employees_info'] = $this->Jobs_employees->getActionsEmployees($id, $item_employees);

        $this->load->view("jobs/employees/jobs_employees/form_action_affiliates", $data);
    }

    function loadDepartment($id = -1) {
        $department_id = $this->input->post('department_id');
        $data['employees_info'] = $this->Jobs_employees->getActionsEmployees($id, $department_id);

        $this->load->view("jobs/employees/jobs_employees/form_action_department", $data);
    }

    /* public function view($hopdong_id=-1){
      $this->check_action_permission('add_update');
      $data['jobs_city']=$this->Employee->get_all_jobs_city();
      $data['loai_hopdong']=$this->Contract->get_all_maloai_hopdong();
      $data['jobs_position']=$this->Employee->get_all_positions();
      $data['city']=$this->Employee->get_all_city();
      $data['contract_info']=$this->Contract->get_info($hopdong_id);
      $this->load->view("contract/form",$data);
      } */

    public function delete() {
        $this->check_action_permission('delete');
        $contract_id = $this->input->post('ids');
        if ($this->Contract->delete_list($contract_id)) {
            echo json_encode(array('success' => true, 'message' => lang('contracts_successful_deleted') . ' ' .
                count($contract_id) . ' ' . lang('contracts_one_or_multiple')));
        } else {
            echo json_encode(array('success' => false, 'message' => lang('contracts_cannot_be_deleted')));
        }
    }

    public function save($hopdong_id = -1) {
        $date_start=date('Y-m-d', strtotime( $this->input->post('date_start')));
		$date_end=date('Y-m-d', strtotime( $this->input->post('date_end')));
        $hopdong_data = array(
            'ma_hopdong	' => $this->input->post('jobs_regions_name'),
            'id_employess' => $this->input->post('jobs_person_name'),
            'date_start' => $date_start,
            'date_end' => $date_end,
            'loai_hopdong' => $this->input->post('customer_type'),
        );
        if ($this->Contract->save($hopdong_data, $hopdong_id)) {
            if ($hopdong_id == -1) {
                echo json_encode(array('success' => true, 'message' => lang('contractcustomers_successful_adding') . ' ' .
                    $hopdong_data['ma_hopdong'], 'id_hopdong' => $hopdong_data['id_hopdong']));
                $hopdong_id = $hopdong_data['id_hopdong'];
            } else { //previous giftcard

                echo json_encode(array('success' => true, 'message' => lang('contractcustomers_successful_updating') . ' ' .
                    $hopdong_data['ma_hopdong'], 'id_hopdong' => $hopdong_id));
            }
        } else {//failure

            echo json_encode(array('success' => false, 'message' => lang('contractcustomers_error_adding_updating') . ' ' .
                $hopdong_data['ma_hopdong'], 'id_hopdong' => -1));
        }
    }
    
    public function sorting() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search) {
            $config['total_rows'] = $this->Contract->search_count_all($search);
            $table_data = $this->Contract->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'ma_hopdong', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        } else {
            $config['total_rows'] = $this->Contract->count_all();
            $table_data = $this->Contract->get_all($per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id_hopdong', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        }
        $config['base_url'] = site_url('contracts/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_hopdong_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function search() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Contract->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id_hopdong', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        $config['base_url'] = site_url('contracts/search');
        $config['total_rows'] = $this->Contract->search_count_all($search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_hopdong_manage_table_data_rows($search_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }
    
    function suggest() {
        $suggestions = $this->Contract->get_search_suggestions($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }
    
    function get_info($id = -1) {
        echo json_encode($this->Contract->get_info($id));
    }

    function get_form_width() {
        return 450;
    }

    function get_form_height() {
        return 300;
    }

}

?>