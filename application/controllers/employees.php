<?php

require_once ("person_controller.php");

class Employees extends Person_controller {

    function __construct() {
        parent::__construct('employees');
        $this->_item = $this->session->userdata('person_id');
        $this->_controller = 'employees';
        $this->load->library('receiving_lib');
    }

    function index() {
        $this->check_action_permission('search');
        $config['base_url'] = site_url('employees/sorting');
        $config['total_rows'] = $this->Employee->count_all($this->_item);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_emp_manage_table($this->Employee->get_all2($this->_item, $data['per_page']), $this);
        $data['total_rows'] = $config['total_rows'];
        $this->load->view('people/manage', $data);
    }

    function sorting() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search) {
            $config['total_rows'] = $this->Employee->search_count_all($this->_item, $search);
            $table_data = $this->Employee->search($this->_item, $search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'first_name', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        } else {
            $config['total_rows'] = $this->Employee->count_all($this->_item);
            $table_data = $this->Employee->get_all2($this->_item, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'lifetek_employees.person_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        }
        $config['base_url'] = site_url('employees/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_emp_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function search() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Employee->search($this->_item, $search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'lifetek_employees.person_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        $config['base_url'] = site_url('employees/search');
        $config['total_rows'] = $this->Employee->search_count_all($this->_item, $search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_emp_manage_table_data_rows($search_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    /*
      Gives search suggestions based on what is being searched for
     */

    function suggest() {
        $suggestions = $this->Employee->get_search_suggestions($this->_item, $this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    function emp_search() {
        $suggestions = $this->Employee->get_emp_search_suggestions($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    //check trùng tên
    function checkname($id) {
        $first_name = $this->input->post('first_name');
        $d['first_name'] = $this->Employee->getname($id);
        foreach ($d['first_name'] as $d2) {
            $d3[] = $d2['first_name'];
        }
        $c2 = $d3;
        $e1 = implode(',', $c2);
        $e2 = explode(',', $e1);

        if (in_array($first_name, $e2)) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    //check trùng mã nv
    function check_emp_code($id) {
        $emp_code = $this->input->post('id_employees');
        $d['emp_code'] = $this->Employee->get_emp_code($id);
        foreach ($d['emp_code'] as $d2) {
            $d3[] = $d2['emp_code'];
        }
        $c2 = $d3;
        $e1 = implode(',', $c2);
        $e2 = explode(',', $e1);

        if (in_array($emp_code, $e2)) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    function excel_export() {
        $data = $this->Employee->get_all()->result_object();
        $this->load->helper('report');
        $rows = array();
        $row = array("User Name", "First Name", "Last Name", "E-Mail", "Phone Number", "Address 1", "Address 2", "City", "State", "Zip", "Country", "Comments");
        $rows[] = $row;
        foreach ($data as $r) {
            $row = array(
                $r->username,
                $r->first_name,
                $r->last_name,
                $r->email,
                $r->phone_number,
                $r->address_1,
                $r->address_2,
                $r->city,
                $r->state,
                $r->zip,
                $r->country,
                $r->comments
            );
            $rows[] = $row;
        }

        $content = array_to_csv($rows);
        force_download('employees_export' . '.csv', $content);
        exit;
    }

    function checkpass_old($employee_id) {
        $user_info2 = $this->Employee->get_info_one_hit($employee_id);
        $pass_old = $this->input->post('password_old');
        if (md5($pass_old) == $user_info2->password) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    function checkpass_same($employee_id) {
        $user_info2 = $this->Employee->get_info_one_hit($employee_id);
        $pass_old = $this->input->post('password');
        if (md5($pass_old) == $user_info2->password) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    /*
      Loads the employee edit form
     */

    function view($employee_id = -1) {
        $this->check_action_permission('add_update');
        $data['person_info'] = $this->Employee->get_info_one_hit($employee_id);
        $data['all_modules'] = $this->Module->get_all_modules();
        $data['quoctich'] = $this->Employee->get_all_visa();
        $data['tinhoc'] = $this->Employee->get_all_tinhoc();
        $data['language'] = $this->Employee->get_all_language();
        $data['bangcap'] = $this->Employee->get_all_bangcap();
        $data['hocvan'] = $this->Employee->get_all_education();
        $data['jobs_city'] = $this->Employee->get_all_jobs_city();
        $data['jobs_position'] = $this->Employee->get_all_positions();
        $data['city_info'] = $this->Jobs_department->get_city_action();
        $data['city_regions'] = $this->Jobs_department->getInformationAll($employee_id);
        $data['pc_info'] = $this->Jobs_department->getTablePC($employee_id);
        $data['affiliates_info'] = $this->Jobs_department->get_affiliates_name();
        $data['regions_info'] = $this->Jobs_department->get_regions_info();
        $data['department_info'] = $this->Employee->get_department_info();

        $this->load->view("employees/form", $data);
    }

    function loadRegions($id = -1) {
        $regions_id = $this->input->post('jobs_regions_id');

        $data['city_info'] = $this->Employee->getAllCity($regions_id);
        $items = array();
        foreach ($data['city_info'] AS $key => $values) {
            $items[] = $values->jobs_city_id;
        }
        $items = implode($items, ',');
        if (!empty($items)) {
            $data['affiliates_info'] = $this->Employee->getActionAffiliates($id, $items);
            $item_department = array();
            foreach ($data['affiliates_info'] AS $values) {
                $item_department[] = $values->jobs_affiliates_id;
            }
            $item_department = implode($item_department, ',');
            if (!empty($item_department)) {
                $data['department_info'] = $this->Employee->getActionsDepartment($id, $item_department);
                $item_employees = array();
                foreach ($data['department_info'] AS $values) {
                    $item_employees[] = $values->department_id;
                }
                $item_employees = implode($item_employees, ',');
                $data['employees_info'] = $this->Employee->getActionsEmployees($id, $item_employees);
            }
        }

        $this->load->view("employees/form_one/form_action_regions", $data);
    }

    function loadCity($id = -1) {
        $city_id = $this->input->post('jobs_city_id');

        $data['affiliates_info'] = $this->Employee->getActionAffiliates($id, $city_id);
        if (count($city_id) > 0) {
            $item_department = array();
            foreach ($data['affiliates_info'] AS $values) {
                $item_department[] = $values->jobs_affiliates_id;
            }
            $item_department = implode($item_department, ',');
            if (!empty($item_department)) {
                $data['department_info'] = $this->Employee->getActionsDepartment($id, $item_department);

                $item_employees = array();

                foreach ($data['department_info'] AS $values) {
                    $item_employees[] = $values->department_id;
                }
                $item_employees = implode($item_employees, ',');
                $data['employees_info'] = $this->Employee->getActionsEmployees($id, $item_employees);
            }
        }

        $this->load->view("employees/form_one/form_action_city", $data);
    }

    function loadAffiliates($id = -1) {
        $affiliates_id = $this->input->post('jobs_affiliates_id');
        if (count($affiliates_id) > 0) {
            $data['department_info'] = $this->Employee->getActionsDepartment($id, $affiliates_id);
            $item_employees = array();

            foreach ($data['department_info'] AS $values) {
                $item_employees[] = $values->department_id;
            }
            $item_employees = implode($item_employees, ',');
            $data['employees_info'] = $this->Employee->getActionsEmployees($id, $item_employees);
        }
        $this->load->view("employees/form_one/form_action_affiliates", $data);
    }

    function exmployee_exists() {
        if ($this->Employee->employee_username_exists($this->input->post('username')))
            echo 'false';
        else
            echo 'true';
    }

    public function creat_contract() {
        redirect('contracts');
    }

    //change pass
    //hung audi 27-2-15 
//    function form_change_pass($employee_id) {
//        $this->check_action_permission('add_update');
//        $data['user_info'] = $this->Employee->get_employee_info($employee_id);
//        $this->load->view("employees/form_change_pass", $data);
//    }
//
//    function save_change_pass($employee_id) {
//        $checkPass = $this->input->post('password');
//        if (!empty($checkPass)) {
//            $person_data['password'] = md5($this->input->post('password'));
//        }
//        if ($this->Employee->save_change_pass($person_data, $employee_id)) {
//            echo json_encode(array('success' => true, 'message' => 'Đổi mật khẩu thành công !', 'person_id' => $employee_id));
//        }
//        redirect('home');
//    }

    /*
      This deletes employees from the employees table
     */
    function save($employee_id = -1) {
        $config = array(
            'upload_path' => './file',
            'allowed_types' => 'doc|docx|pdf|gif|jpg|png|bmp|jpeg|xlsx|xls',
        );
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('curiculum_vitae')) {
            $error = array(
                'errors' => $this->upload->display_errors(),
            );
        } else {
            $file_data_curiculum_vitae = $this->upload->data();
        }

        if (!$this->upload->do_upload('labor_contract')) {
            $error = array(
                'errors' => $this->upload->display_errors(),
            );
        } else {
            $file_data_labor_contract = $this->upload->data();
        }

        if ($employee_id != -1) {
            $data = $this->Employee->get_info_one_more($employee_id);
            if (empty($file_data_labor_contract)) {
                $file_data_labor_contract['file_name'] = $data->labor_contract;
            }
            if (empty($file_data_curiculum_vitae)) {
                $file_data_curiculum_vitae['file_name'] = $data->curiculum_vitae;
            }
            if (empty($file_data_image_face)) {
                $file_data_image_face['file_name'] = $data->image_face;
            }
        }

        $this->check_action_permission('add_update');

        if (!$this->upload->do_upload('image_face')) {

            $person_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email'),
                'birth_date' => date('Y-m-d', strtotime($this->input->post('birth_date'))) == '' ? date('Y-m-d') : date('Y-m-d', strtotime($this->input->post('birth_date'))),
                'phone_number' => $this->input->post('phone_number'),
                'address_1' => $this->input->post('address_1'),
                'city' => $this->input->post('city')
            );
            $permission_data = $this->input->post("permissions") != false ? $this->input->post("permissions") : array();
            $permission_action_data = $this->input->post("permissions_actions") != false ? $this->input->post("permissions_actions") : array();
            $employee_data = array(
                'username' => $this->input->post('username'),
                'identity_card' => $this->input->post('identity_card'),
                'date_identity_card' => date('Y-m-d', strtotime($this->input->post('date_identity_card'))) == '' ? date('Y-m-d') : date('Y-m-d', strtotime($this->input->post('date_identity_card'))),
                'date_working' => date('Y-m-d', strtotime($this->input->post('date_working'))) == '' ? date('Y-m-d') : date('Y-m-d', strtotime($this->input->post('date_working'))),
                'end_working' => date('Y-m-d', strtotime($this->input->post('end_working'))) == '' ? date('Y-m-d') : date('Y-m-d', strtotime($this->input->post('end_working'))),
                'hs_salary' => $this->input->post('hs_salary'),
                'bank_account' => $this->input->post('bank_account'),
                'name_bank' => $this->input->post('name_bank'),
                'id_language' => $this->input->post('id_language'),
                'id_education' => $this->input->post('id_education'),
                'id_visa' => $this->input->post('id_visa'),
                'name_nation' => $this->input->post('name_nation'),
                'id_diplomas' => $this->input->post('id_diplomas'),
                'id_informatics' => $this->input->post('id_informatics'),
                'check_petrol' => $this->input->post('check_petrol') == '' ? 0 : 1,
                'check_phone' => $this->input->post('check_phone') == '' ? 0 : 1,
                'positions_id' => $this->input->post('positions_id'),
                'curiculum_vitae' => $file_data_curiculum_vitae['file_name'],
                'labor_contract' => $file_data_labor_contract['file_name'],
                'em_salary_basic' => $this->input->post('em_salary_basic'),
                'positions_id' => $this->input->post('positions_id'),
                'em_social_insurance' => $this->input->post('em_social_insurance'),
                'emp_expense' => $this->input->post('emp_expense'),
                'emp_deposit' => $this->input->post('emp_deposit'),
                'emp_code' => $this->input->post('id_employees')
            );
        } else {
            $file_data_image_face = $this->upload->data();

            $person_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email'),
                'birth_date' => date('Y-m-d', strtotime($this->input->post('birth_date'))) == '' ? date('Y-m-d') : date('Y-m-d', strtotime($this->input->post('birth_date'))),
                'phone_number' => $this->input->post('phone_number'),
                'address_1' => $this->input->post('address_1'),
                'city' => $this->input->post('city')
            );
            $permission_data = $this->input->post("permissions") != false ? $this->input->post("permissions") : array();
            $permission_action_data = $this->input->post("permissions_actions") != false ? $this->input->post("permissions_actions") : array();
            $employee_data = array(
                'username' => $this->input->post('username'),
                'identity_card' => $this->input->post('identity_card'),
                'date_identity_card' => date('Y-m-d', strtotime($this->input->post('date_identity_card'))) == '' ? date('Y-m-d') : date('Y-m-d', strtotime($this->input->post('date_identity_card'))),
                'date_working' => date('Y-m-d', strtotime($this->input->post('date_working'))) == '' ? date('Y-m-d') : date('Y-m-d', strtotime($this->input->post('date_working'))),
                'end_working' => date('Y-m-d', strtotime($this->input->post('end_working'))) == '' ? date('Y-m-d') : date('Y-m-d', strtotime($this->input->post('end_working'))),
                'hs_salary' => $this->input->post('hs_salary'),
                'bank_account' => $this->input->post('bank_account'),
                'name_bank' => $this->input->post('name_bank'),
                'id_language' => $this->input->post('id_language'),
                'id_education' => $this->input->post('id_education'),
                'id_visa' => $this->input->post('id_visa'),
                'name_nation' => $this->input->post('name_nation'),
                'id_diplomas' => $this->input->post('id_diplomas'),
                'id_informatics' => $this->input->post('id_informatics'),
                'check_petrol' => $this->input->post('check_petrol') == '' ? 0 : 1,
                'check_phone' => $this->input->post('check_phone') == '' ? 0 : 1,
                'positions_id' => $this->input->post('positions_id'),
                'curiculum_vitae' => $file_data_curiculum_vitae['file_name'],
                'labor_contract' => $file_data_labor_contract['file_name'],
                'image_face' => $file_data_image_face['file_name'],
                'em_salary_basic' => $this->input->post('em_salary_basic'),
                'positions_id' => $this->input->post('positions_id'),
                'em_social_insurance' => $this->input->post('em_social_insurance'),
                'emp_expense' => $this->input->post('emp_expense'),
                'emp_deposit' => $this->input->post('emp_deposit'),
                'emp_code' => $this->input->post('id_employees')
            );
        }
        //hung audi 13-4-15
        if ($this->input->post('department_id')) {
            $parent_id = $this->Employee->getPersonDepartment($this->input->post('department_id'));
            $employee_data['department_id'] = $this->input->post('department_id');
            $resultOne = $this->Employee->getCheckOneAll($employee_id);
            if ($resultOne == 0 || $employee_id == -1) {
                $employee_data['parent_id'] = $parent_id->person_id;
            }
        }

        //Kiểm tra pass trong trường hợp update
        if ($employee_id != -1) {
            $checkPass = $this->input->post('password');
            if (!empty($checkPass)) {
                $employee_data['password'] = md5($this->input->post('password'));
            }
        } else {
            $employee_data['password'] = md5($this->input->post('password'));
        }

        $resultOne = $this->Employee->getCheckOneAll($employee_id);
        if ($resultOne == 0 || $employee_id == -1) {
            $employee_data['parent_id'] = $parent_id->person_id;
        }

        $pc_table = array(
            'pc_position' => $this->input->post('pc_position') == '' ? 0 : $this->input->post('pc_position'),
            'pc_seniority' => $this->input->post('pc_seniority') == '' ? 0 : $this->input->post('pc_seniority')
        );


        if (($_SERVER['HTTP_HOST'] == 'demo.phppointofsale.com' || $_SERVER['HTTP_HOST'] == 'demo.phppointofsalestaging.com') && $employee_id == 1) {
            //failure
            echo json_encode(array('success' => false, 'message' => lang('employees_error_updating_demo_admin') . ' ' .
                $person_data['first_name'] . ' ' . $person_data['last_name'], 'person_id' => -1));
        } elseif ($this->Employee->save($person_data, $employee_data, $permission_data, $permission_action_data, $employee_id, $pc_table, $contract_data)) {
            if ($this->config->item('mailchimp_api_key')) {
                $this->Person->update_mailchimp_subscriptions($this->input->post('email'), $this->input->post('first_name'), $this->input->post('last_name'), $this->input->post('mailing_lists'));
            }

            //New employee
            if ($employee_id == -1) {
                echo json_encode(array('success' => true, 'message' => lang('employees_successful_adding') . ' ' .
                    $person_data['first_name'] . ' ' . $person_data['last_name'] . ') !', 'person_id' => $employee_data['person_id']));
            } else { //previous employee
                echo json_encode(array('success' => true, 'message' => lang('employees_successful_updating') . ' ' .
                    $person_data['first_name'] . ' ' . $person_data['last_name'] . " ) !", 'person_id' => $employee_id));
            }
        } else {//failure
            echo json_encode(array('success' => false, 'message' => lang('employees_error_adding_updating') . ' ' .
                $person_data['first_name'] . ' ' . $person_data['last_name'], 'person_id' => -1));
        }
    }

    function delete() {
        $this->check_action_permission('delete');
        $employees_to_delete = $this->input->post('ids');
        foreach ($employees_to_delete as $em2) {
            
        }
        if (($_SERVER['HTTP_HOST'] == 'demo.phppointofsale.com' || $_SERVER['HTTP_HOST'] == 'demo.phppointofsalestaging.com') && in_array(1, $employees_to_delete)) {
            //failure
            echo json_encode(array('success' => false, 'message' => lang('employees_error_deleting_demo_admin')));
        } elseif ($this->Jobs_regions->get_region_id($em2)->num_rows() > 0 || $this->Jobs_regions->get_city_id($em2)->num_rows() > 0 || $this->Jobs_regions->get_affiliates_id($em2)->num_rows() > 0 || $this->Jobs_regions->get_department_id($em2)->num_rows() > 0
        ) {
            echo json_encode(array('success' => false, 'message' => lang('employees_cannot_be_deleted')));
        } elseif ($this->Employee->delete_list($employees_to_delete)) {
            echo json_encode(array('success' => true, 'message' => lang('employees_successful_deleted') . ' person_id: '
                . count($employees_to_delete) . ' ' . lang('employees_one_or_multiple')));
        } else {
            echo json_encode(array('success' => false, 'message' => lang('employees_cannot_be_deleted')));
        }
    }

    /*
      get the width for the add/edit form
     */

    function get_form_width() {
        return 1050;
    }

    //Create by San
    function info_name_employee_suggest() {
        $suggestions = $this->Employee->get_search_info_name_employee_suggestions($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    //hung audi 24-3-15
    //phan cap quan ly nhan vien 
//regions
    function switch_jobs_regions($jobs_regions_id) {
        $this->receiving_lib->add_jobs_regions($jobs_regions_id);
        redirect("$this->_controller/regions_detail");
    }

    function regions_detail() {
        $jobs_regions_id = $this->receiving_lib->get_jobs_regions();
        $this->check_action_permission('search');
        $config['base_url'] = site_url($this->_controller . '/sorting_regions_detail');
        $config['total_rows'] = $this->Employee->count_all_regions_detail($jobs_regions_id);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_emp_manage_table($this->Employee->get_all_regions_detail($jobs_regions_id, $data['per_page']), $this);
        $data['info_regions'] = $this->Employee->get_info_regions($jobs_regions_id);
        $this->load->view("$this->_controller/regions_detail", $data);
    }

    function sorting_regions_detail() {
        $jobs_regions_id = $this->receiving_lib->get_jobs_regions();
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;

        if ($search) {
            $config['total_rows'] = $this->Employee->search_count_all_regions_detail($jobs_regions_id, $search); //search_count_all
            $table_data = $this->Employee->search_regions_detail(
                    $jobs_regions_id, $search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'lifetek_employees.person_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
            );
        } else {
            $config['total_rows'] = $this->Employee->count_all_regions_detail($jobs_regions_id); //count_all
            $table_data = $this->Employee->get_all_regions_detail(
                    $jobs_regions_id, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'lifetek_employees.person_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
            );
        }
        $config['base_url'] = site_url("$this->_controller/sorting_regions_detail");
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_emp_manage_table_data_rows($table_data, $this);

        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function suggest_regions_detail() {
        $jobs_regions_id = $this->receiving_lib->get_jobs_regions();
        $suggestions = $this->Employee->get_search_suggestions_regions_detail($jobs_regions_id, $this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    function search_regions_detail() {
        $jobs_regions_id = $this->receiving_lib->get_jobs_regions();
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Employee->search_regions_detail(
                $jobs_regions_id, $search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'lifetek_employees.person_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
        );
        $config['base_url'] = site_url("$this->_controller/search_regions_detail");
        $config['total_rows'] = $this->Employee->search_count_all_regions_detail($jobs_regions_id, $search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links(); //die($per_page);
        $data['manage_table'] = get_emp_manage_table_data_rows($search_data, $this);

        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    //city
    function switch_jobs_city($jobs_city_id) {
        $this->receiving_lib->clear_all2();
        $this->receiving_lib->add_jobs_city($jobs_city_id);
        redirect("$this->_controller/city_detail");
    }

    function city_detail() {
        $jobs_city_id = $this->receiving_lib->get_jobs_city();
        $this->check_action_permission('search');
        $config['base_url'] = site_url($this->_controller . '/sorting_city_detail');
        $config['total_rows'] = $this->Employee->count_all_city_detail($jobs_city_id);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_emp_manage_table($this->Employee->get_all_city_detail($jobs_city_id, $data['per_page']), $this);
        $data['info_city'] = $this->Employee->get_info_city($jobs_city_id);
        $this->load->view("$this->_controller/city_detail", $data);
    }

    function sorting_city_detail() {
        $jobs_city_id = $this->receiving_lib->get_jobs_city();
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;

        if ($search) {
            $config['total_rows'] = $this->Employee->search_count_all_city_detail($jobs_city_id, $search); //search_count_all
            $table_data = $this->Employee->search_city_detail(
                    $jobs_city_id, $search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'lifetek_employees.person_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
            );
        } else {
            $config['total_rows'] = $this->Employee->count_all_city_detail($jobs_city_id); //count_all
            $table_data = $this->Employee->get_all_city_detail(
                    $jobs_city_id, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'lifetek_employees.person_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
            );
        }
        $config['base_url'] = site_url("$this->_controller/sorting_city_detail");
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_emp_manage_table_data_rows($table_data, $this);

        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function suggest_city_detail() {
        $jobs_city_id = $this->receiving_lib->get_jobs_city();
        $suggestions = $this->Employee->get_search_suggestions_city_detail($jobs_city_id, $this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    function search_city_detail() {
        $jobs_city_id = $this->receiving_lib->get_jobs_city();
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Employee->search_city_detail(
                $jobs_city_id, $search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'lifetek_employees.person_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
        );
        $config['base_url'] = site_url("$this->_controller/search_city_detail");
        $config['total_rows'] = $this->Employee->search_count_all_city_detail($jobs_city_id, $search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links(); //die($per_page);
        $data['manage_table'] = get_emp_manage_table_data_rows($search_data, $this);

        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    //affiliates
    function switch_jobs_affiliates($jobs_affiliates_id) {
        $this->receiving_lib->clear_all2();
        $this->receiving_lib->add_jobs_affiliates($jobs_affiliates_id);
        redirect("$this->_controller/affiliates_detail");
    }

    function affiliates_detail() {
        $jobs_affiliates_id = $this->receiving_lib->get_jobs_affiliates();
        $this->check_action_permission('search');
        $config['base_url'] = site_url($this->_controller . '/sorting_affiliates_detail');
        $config['total_rows'] = $this->Employee->count_all_affiliates_detail($jobs_affiliates_id);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_emp_manage_table($this->Employee->get_all_affiliates_detail($jobs_affiliates_id, $data['per_page']), $this);
        $data['info_affiliates'] = $this->Employee->get_info_affiliates($jobs_affiliates_id);
        $this->load->view("$this->_controller/affiliates_detail", $data);
    }

    function sorting_affiliates_detail() {
        $jobs_affiliates_id = $this->receiving_lib->get_jobs_affiliates();
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;

        if ($search) {
            $config['total_rows'] = $this->Employee->search_count_all_affiliates_detail($jobs_affiliates_id, $search); //search_count_all
            $table_data = $this->Employee->search_affiliates_detail(
                    $jobs_affiliates_id, $search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'lifetek_employees.person_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
            );
        } else {
            $config['total_rows'] = $this->Employee->count_all_affiliates_detail($jobs_affiliates_id); //count_all
            $table_data = $this->Employee->get_all_affiliates_detail(
                    $jobs_affiliates_id, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'lifetek_employees.person_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
            );
        }
        $config['base_url'] = site_url("$this->_controller/sorting_affiliates_detail");
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_emp_manage_table_data_rows($table_data, $this);

        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function suggest_affiliates_detail() {
        $jobs_affiliates_id = $this->receiving_lib->get_jobs_affiliates();
        $suggestions = $this->Employee->get_search_suggestions_affiliates_detail($jobs_affiliates_id, $this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    function search_affiliates_detail() {
        $jobs_affiliates_id = $this->receiving_lib->get_jobs_affiliates();
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Employee->search_affiliates_detail(
                $jobs_affiliates_id, $search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'lifetek_employees.person_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
        );
        $config['base_url'] = site_url("$this->_controller/search_affiliates_detail");
        $config['total_rows'] = $this->Employee->search_count_all_affiliates_detail($jobs_affiliates_id, $search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links(); //die($per_page);
        $data['manage_table'] = get_emp_manage_table_data_rows($search_data, $this);

        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    //department
    function switch_department($department_id) {
        $this->receiving_lib->clear_all2();
        $this->receiving_lib->add_department($department_id);
        redirect("$this->_controller/department_detail");
    }

    function department_detail() {
        $department_id = $this->receiving_lib->get_department();
        $this->check_action_permission('search');
        $config['base_url'] = site_url($this->_controller . '/sorting_department_detail');
        $config['total_rows'] = $this->Employee->count_all_department_detail($department_id);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_emp_manage_table($this->Employee->get_all_department_detail($department_id, $data['per_page']), $this);
        $data['info_department'] = $this->Employee->get_info_department($department_id);
        $this->load->view("$this->_controller/department_detail", $data);
    }

    function sorting_department_detail() {
        $department_id = $this->receiving_lib->get_department();
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;

        if ($search) {
            $config['total_rows'] = $this->Employee->search_count_all_department_detail($department_id, $search); //search_count_all
            $table_data = $this->Employee->search_department_detail(
                    $department_id, $search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'lifetek_employees.person_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
            );
        } else {
            $config['total_rows'] = $this->Employee->count_all_department_detail($department_id); //count_all
            $table_data = $this->Employee->get_all_department_detail(
                    $department_id, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'lifetek_employees.person_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
            );
        }
        $config['base_url'] = site_url("$this->_controller/sorting_department_detail");
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_emp_manage_table_data_rows($table_data, $this);

        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function suggest_department_detail() {
        $department_id = $this->receiving_lib->get_department();
        $suggestions = $this->Employee->get_search_suggestions_department_detail($department_id, $this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    function search_department_detail() {
        $department_id = $this->receiving_lib->get_department();
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Employee->search_department_detail(
                $department_id, $search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'lifetek_employees.person_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
        );
        $config['base_url'] = site_url("$this->_controller/search_department_detail");
        $config['total_rows'] = $this->Employee->search_count_all_department_detail($department_id, $search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links(); //die($per_page);
        $data['manage_table'] = get_emp_manage_table_data_rows($search_data, $this);

        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    //end hung audi
    //15-9-15 Hưng Audi
    function search_suggestions_audi() {
        $suggestions = $this->Employee->get_search_suggestions_audi($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    function permission_warehouse($person_id) {
        $data['person_id'] = $person_id;
        $data['info_emp'] = $this->Employee->get_info_in_table_employee($person_id);
        $data['warehouse'] = $this->Create_invetory->get_list_warehouse_not_material_and_finished();
        $this->load->view("employees/permission_warehouse", $data);
    }

    function save_permission_warehouse($person_id) {
        $data = array(
            "warehouse_sale" => $this->input->post("warehouse_sale"),
            "warehouse_import" => $this->input->post("warehouse_import"),
        );
        if ($this->Employee->update_permission_warehouse($data, $person_id)) {
            echo json_encode(array("success" => TRUE, "message" => "Phân quyền thành công"));
        } else {
            echo json_encode(array("success" => FALSE, "message" => "Phân quyền thất bại"));
        }
    }

}
