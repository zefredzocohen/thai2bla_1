<?php

session_start();
require_once(APPPATH . 'third_party/Classes/PHPExcel/IOFactory.php');
require_once(APPPATH . 'libraries/php-excel.class.php');
require_once ("person_controller.php");

class Customers extends Person_controller {

    function __construct() {
//        date_default_timezone_set('Asia/Ho_Chi_Minh');
        parent::__construct('customers');
        $this->load->library('sale_lib');
    }

    function index() {
        $this->check_action_permission('search');
        //phan lam don hang
        $data = array();
        $data['suspended_sales'] = $this->Sale->get_all_suspended()->result_array();
        //phan lam don hang web
        $data['payment_date'] = $this->Sale->get_all_suspended_web()->result_array();
        //end phan don hang
        //phan lam
        $data['customer'] = $this->Customer->findBirthDate();
        //lay danh sach khach hang sap het hop dong
        $day = date('d-m-Y', time());
        $day_int = strtotime($day);
        $contraccustomer = $this->Contractcustomers->get_contraccustomer_expried($this->session->userdata('person_id'));
        $list_id = array();
        foreach ($contraccustomer as $v) {
            $t = strtotime($v['end_date']);
            if ($t >= $day_int && $t <= ($day_int + (($this->config->item('expired_contract') - 1) * 86400))) {
                $list_id[] = $v['id'];
            }
        }
        $data['ids'] = $list_id;
        // end phan lam
        //phan lam san pham
        $items = array();
        $allitems = $this->Customer->findAllItem();
        foreach ($allitems as $allitem) {
            if ($allitem['quantity'] <= $allitem['reorder_level']) {
                $items[] = $allitem['item_id'];
            }
        }
        $data['items'] = $items;

        //end phan lam han san pham
        /* phan lam bao cao no */
        $data['suspends_date'] = $this->Inventory->find_suspends_date();
        /* end phan lam bao cao no */
        $config['base_url'] = site_url('customers/sorting');
//        $config['total_rows'] = $this->Customer->count_all();
        $config['total_rows'] = $this->Customer->count_all_by_employee_id($this->session->userdata('person_id'));
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_people_manage_table($this->Customer->get_all_by_employee_id($this->session->userdata('person_id'), $data['per_page']), $this);
        $data['register_date'] = $this->Customer->finddateregister();
        //BEGIN SMS
        $max_id_sms = $this->Customer->get_table_number_sms();
        $data['number_sms'] = $this->Customer->get_info_id_max_of_table_number_sms($max_id_sms['id']);
        //END SMS
        $this->load->view('people/manage', $data);
    }

    //check trùng tên
    function checkname($id) {
        $first_name = $this->input->post('first_name');
        $d['first_name'] = $this->Customer->getname($id);
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

    function sorting() {
//        echo json_encode(array($_POST,'test'=>'sorting'));die;
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $type_customer = $this->input->post('cat');
        $employee = $this->input->post('employee');
        
        $start_date =$this->input->post('start_date')? $this->input->post('start_date'):'';
        
        if($start_date!=''){
            if(date('d/m/Y',  strtotime($end_date)))$start_date= date ('Y/m/d',  strtotime ($start_date));
        }
        
        $start_money = $this->input->post('start_money')?$this->input->post('start_money'):'';
        if($start_money!=''){
            $start_money = str_replace(' ', '',$start_money);
        }
        
        
        
        $end_money = $this->input->post('end_money')?   $this->input->post('end_money'):'';
        
        if($end_money!=''){
            $end_money = str_replace(' ', '',$end_money);
        }
        
        $end_date =$this->input->post('end_date')?   $this->input->post('end_date'):'';
        if($end_date !=''){
            if(date('d/m/Y',  strtotime($end_date)))$end_date= date ('Y/m/d',  strtotime ($end_date));
        }
        
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search || $employee || $type_customer) {
//            $config['total_rows'] = $this->Customer->search_count_all($search);
//            $table_data = $this->Customer->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'last_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
            $config['total_rows'] = $this->Customer->search_count_all_by_employee_id(
                    $this->session->userdata('person_id'), $search, $employee, $type_customer,1000,
                    $start_date,
                    $end_date,
                    $start_money,
                    $end_money
                    );
            $table_data = $this->Customer->search_by_employee_id(
                    $this->session->userdata('person_id'), 
                    $search, $employee, $type_customer, $per_page, 
                    $this->input->post('offset') ? $this->input->post('offset') : 0, 
                    $this->input->post('order_col') ? $this->input->post('order_col') : 'lifetek_people.person_id', 
                    $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc',
                    $start_date,
                    $end_date,
                    $start_money,
                    $end_money
                );
        } 
        else {
            //$config['total_rows'] = $this->Customer->count_all();
            //$table_data = $this->Customer->get_all($per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'last_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
            $config['total_rows'] = $this->Customer->count_all_by_employee_id($this->session->userdata('person_id'));
            $table_data = $this->Customer->get_all_by_employee_id(
                    $this->session->userdata('person_id'), 
                    $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, 
                    $this->input->post('order_col') ? $this->input->post('order_col') : 'lifetek_people.person_id', 
                    $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc',
                    $start_date,
                    $end_date,
                    $start_money,
                    $end_money
                );
        }
//        echo $config['total_rows'];die;
        $config['base_url'] = site_url('customers/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
//        echo json_encode($table_data);die;
        $data['manage_table'] = get_people_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    /*
      Returns customer table data rows. This will be called with AJAX.
     */

    function search() {
//        echo json_encode(array($_POST,'test'=>'search','session'=>$this->session->userdata('person_id')));die();
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $type_customer = $this->input->post('cat');
        $employee = $this->input->post('employee');
        
        $start_date =$this->input->post('start_date')? $this->input->post('start_date'):'';
        $end_date =$this->input->post('end_date')? $this->input->post('end_date'):'';
        
        if($start_date!=''){
            if(date('d/m/Y',  strtotime($start_date)))$start_date= date ('Y/m/d',  strtotime ($start_date));
        }
        
        $end_date =$this->input->post('end_date')?   $this->input->post('end_date'):'';
        if($end_date !=''){
            if(date('d/m/Y',  strtotime($end_date)))$end_date= date ('Y/m/d',  strtotime ($end_date));
        }
         
        $start_money = $this->input->post('start_money')?$this->input->post('start_money'):'';
        if($start_money!=''){
            $start_money = str_replace(' ', '',$start_money);
        }
        
        $end_money = $this->input->post('end_money')?   $this->input->post('end_money'):'';
        
        if($end_money!=''){
            $end_money = str_replace(' ', '',$end_money);
        }
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
//            $search_data=$this->Customer->search($search,$type_customer,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'last_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
        $search_data = $this->Customer->search_by_employee_id($this->session->userdata('person_id'), 
                $search, $employee, $type_customer, $per_page, 
                $this->input->post('offset') ? $this->input->post('offset') : 0, 
                $this->input->post('order_col') ? $this->input->post('order_col') : 'lifetek_customers.person_id', 
                $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc',
                $start_date,
                $end_date,
                $start_money,
                $end_money);
        $config['base_url'] = site_url("customers/search");
//            $config['total_rows'] = $this->Customer->search_count_all($search,$type_customer);
        $config['total_rows'] = $this->Customer->search_count_all_by_employee_id(
                $this->session->userdata('person_id'), 
                $search, $employee, $type_customer,1000,
                $start_date,
                $end_date,
                $start_money,
                $end_money
                );
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_people_manage_table_data_rows($search_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    /*
      Gives search suggestions based on what is being searched for
     */

    function suggest() {
        $suggestions = $this->Customer->get_search_suggestions_by_employee_id($this->session->userdata('person_id'), $this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    /*
      Loads the customer edit form
     */

    function view($customer_id = -1) {
        $this->check_action_permission('add_update');
        $data['person_info'] = $this->Customer->get_info_customer($customer_id);
        $data['option'] = $this->Customer->get_option1();
        $data['option2'] = $this->Customer->get_option2();
        $this->load->view("customers/form", $data);
    }

    function account_number_exists() {
        if ($this->Customer->account_number_exists($this->input->post('account_number')))
            echo 'false';
        else
            echo 'true';
    }

    /* find date */

    function finddate() {
        //phan lem		
        $start_date = date('Y-m-d', strtotime($this->input->post('start_date')));
        $end_date = date('Y-m-d', strtotime($this->input->post('end_date')));
        $start_date_get = split("-", $start_date);
        $start_mon = $start_date_get[1];
        $start_year = $start_date_get[0];
        $start_day = $start_date_get[2];

        $end_date_get = split("-", $end_date);
        $end_mon = $end_date_get[1];
        $end_year = $end_date_get[0];
        $end_day = $end_date_get[2];



        if ($start_date_get[0] == $end_date_get[0]) {
            if ($start_mon == $end_mon) {
                $findper = $this->Customer->findperinmonth($start_mon, $start_day, $end_mon, $end_day);
            }
        };

        $data['manage_table'] = get_people_manage_table($findper, $this);
        $this->load->view('customers/finddate', $data);
        //end phan lam
    }

    function save($customer_id = -1) {
        $this->check_action_permission('add_update');
        $register_date = date('Y-m-d');
        $birth_date = date('Y-m-d', strtotime($this->input->post('birth_date')));
        $birth_date_1 = date('Y-m-d', strtotime($this->input->post('birth_date_1')));
        $sex = $this->input->post('sex');
        $person_data = array(
            'birth_date' => $birth_date,
            'first_name' => trim($this->input->post('first_name')),
            'last_name' => trim($this->input->post('last_name')),
            'email' => $this->input->post('email'),
            'phone_number' => $this->input->post('phone_number'),
            'phone' =>$this->input->post('phone'),
            'address_1' => $this->input->post('address_1'),
            'comments' => $this->input->post('comments'),
            'register_date' => $register_date,
        );
        //hung audi 10-4-15
        $choose = $this->input->post('type');
        if ($choose == 0) {
            $person_data['city'] = $this->input->post('city');
        } else {
            $person_data['city'] = $this->input->post('world');
        }

        $customer_data = array(
            'positions' => $this->input->post('positions'),
            'sex' => $sex,
            'company_name' => $this->input->post('company_name'),
            'manages_name' => $this->input->post('manages_name'),
            'birth_date_1' => $birth_date_1,
            'wife' => $this->input->post('wife'),
            'account_number' => $this->input->post('account_number') == '' ? null : $this->input->post('account_number'),
            'taxable' => $this->input->post('taxable') == '' ? 0 : 1,
            'code_tax' => $this->input->post('code_tax'),
            'type_customer' => $this->input->post('customer_type'),
            'debt' => str_replace(array(',', '.00'), '', $this->input->post('debt')),
            'account_implicit' => 131
        );
        if ($this->input->post('employee')) {
            $customer_data['employee_id'] = $this->input->post('employee');
        } else {
            $customer_data['employee_id'] = $this->session->userdata('person_id');
        }
        if ($this->Customer->save($person_data, $customer_data, $customer_id)) {
            if ($this->config->item('mailchimp_api_key')) {
                $this->Person->update_mailchimp_subscriptions($this->input->post('email'), $this->input->post('first_name'), $this->input->post('last_name'), $this->input->post('mailing_lists'));
            }
            //New customer
            if ($customer_id != -1) {
                echo json_encode(array('success' => true, 'message' => lang('customers_successful_updating') . ' ' .
                    $person_data['first_name'] . ' ' . $person_data['last_name'], 'person_id' => $customer_id));
            } else { //previous customer
                echo json_encode(array('success' => true, 'message' => lang('customers_successful_adding') . ' ' .
                    $person_data['first_name'] . ' ' . $person_data['last_name'], 'person_id' => $customer_data['person_id']));
            }
        } else {//failure
            echo json_encode(array('success' => false, 'message' => lang('customers_error_adding_updating') . ' ' .
                $person_data['first_name'] . ' ' . $person_data['last_name'], 'person_id' => -1));
        }
    }

    /*
      This deletes customers from the customers table
     */

    function delete() {
        $this->check_action_permission('delete');
        $customers_to_delete = $this->input->post('ids');

        if ($this->Customer->delete_list($customers_to_delete)) {
            echo json_encode(array('success' => true, 'message' => lang('customers_successful_deleted') . ' ' .
                count($customers_to_delete) . ' ' . lang('customers_one_or_multiple')));
        } else {
            echo json_encode(array('success' => false, 'message' => lang('customers_cannot_be_deleted')));
        }
    }

    function excel() {
        $data = file_get_contents("import_customers.xlsx");
        $name = 'import_customers.xlsx';
        force_download($name, $data);
    }

    function excel_import() {
        $this->check_action_permission('add_update');
        $this->load->view("customers/excel_import", null);
    }

    /* added for excel expert */

    function excel_export() {
        $cities = $this->City->get_all()->result_array();
        require_once APPPATH . "/third_party/Classes/export_customer.php";
    }

    function do_excel_import() {//$this->check_action_permission('add_update');
      
        $this->db->trans_start();
        $msg = 'do_excel_import';
        $failCodes = array();
        if ($_FILES['file_path']['error'] != UPLOAD_ERR_OK) {
            $msg = lang('items_excel_import_failed');
            echo json_encode(array('success' => false, 'message' => $msg));
            return;
        } else {
            if ($objPHPExcel = PHPExcel_IOFactory::load($_FILES['file_path']['tmp_name'])) {
                $objWorksheet = $objPHPExcel->getActiveSheet();

                $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
                $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'

                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5

                for ($row = 3; $row <= $highestRow; ++$row) {
                    $array_info = array();
                    for ($col = 0; $col <= $highestColumnIndex; ++$col) {
                        $array_info[] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                    }
                    $birth_date = date('Y-m-d', strtotime($array_info[7]));
                    $birth_date_1 = date('Y-m-d', strtotime($array_info[11]));
                    $person_data = array(
                        'first_name' => $array_info[0],
                        'last_name' => $array_info[1],
                        'email' => $array_info[3],
                        'phone_number' => $array_info[4],
                        'phone'=>$array_info[5],
                        'address_1' => $array_info[6],
                        'birth_date' => $birth_date,
                        'comments' => $array_info[9],
                        //'city'=>$array_info[7]
                    );
                    $customer_data = array(
                        'company_name' => $array_info[10],
                        'birth_date_1' => $birth_date_1,
                        'wife' => $array_info[12],
                        'account_number' => $array_info[14],
                        'code_tax' => $array_info[15],
                        'taxable' => strtolower($array_info[16]) == 'n' ? '0' : '1',
                        //'taxable' => 0,
                        'positions' => $array_info[17],
                        'sex' => $array_info[18],
                        //'employee_id'=>$array_info[2],
                        //'type_customer'=>$array_info[12]
                        
                    );
                    
                    if ($array_info[7] == NULL) {
                        $person_data['city'] = '';
                    } else {
                        $info_city = $this->City->get_city_by_zip_code($array_info[8]);
                        $person_data['city'] = $info_city['id_city'];
                    }
                    $cus_type = $this->M_customer_type->get_customer_type_by_code($array_info[13]);
                    $customer_data['type_customer'] = $cus_type['customer_type_id'];
                    $emp_info = $this->Employee->get_info_employee_by_id($array_info[2]);
                    $customer_data['employee_id'] = $emp_info['person_id'];
                    if (!$this->Customer->save($person_data,$customer_data)) {
                        echo json_encode(array('success' => true, 'message' => lang('customers_import_successfull')));
                        return;
                    }
                    
                }
            } else {
                echo json_encode(array('success' => false, 'message' => lang('common_upload_file_not_supported_format')));
                return;
            }
        }
        $this->db->trans_complete();
        echo json_encode(array('success' => false, 'message' => lang('customers_duplicate_account_id')));
        
    }



    function excel_import_update() {
        $this->check_action_permission('add_update');
        $this->load->view("customers/excel_import_update", null);
    }

    function do_excel_import_update() {
        $this->check_action_permission('add_update');
        $this->db->trans_start();

        $msg = 'do_excel_import';
        $failCodes = array();
        if ($_FILES['file_path']['error'] != UPLOAD_ERR_OK) {
            $msg = lang('items_excel_import_failed');
            echo json_encode(array('success' => false, 'message' => $msg));
            return;
        } else {
            if (($handle = fopen($_FILES['file_path']['tmp_name'], "r")) !== FALSE) {
                //Skip first row
                fgetcsv($handle);
                while (($data = fgetcsv($handle)) !== FALSE) {
                    $person_data = array(
                        'first_name' => $data[0],
                        'last_name' => $data[1],
                        'email' => $data[2],
                        'phone_number' => $data[3],
                        'address_1' => $data[4],
                        'address_2' => $data[5],
                        'city' => $data[6],
                        'state' => $data[7],
                        'zip' => $data[8],
                        'country' => $data[9],
                        'comments' => $data[10]
                    );

                    $customer_data = array(
                        'account_number' => $data[11] == '' ? null : $data[11],
                        'taxable' => $data[12] != '' and $data[12] != '0' and strtolower($data[12]) != 'n' ? '1' : '0',
                        'company_name' => $data[13],
                    );
                    if ($this->Customer->exists($data[14])) {
                        $this->Customer->save($person_data, $customer_data, $data[14]);
                    } else if (!$this->Customer->save($person_data, $customer_data)) {
                        echo json_encode(array('success' => false, 'message' => lang('customers_duplicate_account_id')));
                        return;
                    }
                }
            } else {
                echo json_encode(array('success' => false, 'message' => lang('common_upload_file_not_supported_format')));
                return;
            }
        }
        $this->db->trans_complete();
        echo json_encode(array('success' => true, 'message' => lang('customers_import_successfull')));
    }

    function updatebirthdate() {
        $data = array(
            'birth_date' => 0
        );
        $this->Customer->update_birth_date($data);
    }

    function updatecompany() {
        $data = array(
            'birth_date_1' => 0
        );
        $this->Customer->update_company($data);
    }

    function shopping($id_customer) {
        if ($this->Customer->exists($id_customer)) {
            $this->sale_lib->set_customer($id_customer);
        } else {
            $data['error'] = lang('sales_unable_to_add_customer');
        }
        redirect('items');
    }

    function detail_customer_sale($id_customer) {
        //hung dq 28-01
        $page_limit = 0;
        $resultsPerPage = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $data['number_of_items_per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $data['num_rows'] = $this->Inventory->get_total_row($id_customer);
        $data['num_rows2'] = $this->Inventory->get_total_row2($id_customer);
        $data['num_rows3'] = $this->Inventory->get_total_row3($id_customer);
        $data['num_rows4'] = $this->Inventory->get_total_row4($id_customer);
        $data['num_rows5'] = $this->Inventory->get_total_row5($id_customer);
        $data['num_rows6'] = $this->Customer->get_total_row6($id_customer);
        $data['num_row_history_sms'] = $this->Customer->get_total_row_history_sms($id_customer);
        $data['customer_info'] = $this->Customer->get_info($id_customer);
        //ban hang
        $data['sale_all_invs'] = $this->Inventory->find_sale_all_customer2($id_customer, $page_limit, $resultsPerPage);
        //thu chi
        $data['cost_complete'] = $this->Inventory->find_cost_complete_customer2($id_customer, $page_limit, $resultsPerPage);
        //giao dich
        $data['emp_trade'] = $this->Inventory->find_trade_complete_customer2($id_customer, $page_limit, $resultsPerPage);
        //cong no
        $data['sale_complete_invs'] = $this->Inventory->find_sale_complete_customer2($id_customer, $page_limit, $resultsPerPage);
        //bao gia
        $data['sale_materials'] = $this->Inventory->find_sale_complete_customer_materials2($id_customer, $page_limit, $resultsPerPage);
        //end hungdq

        $data['sms_history'] = $this->Customer->get_history_sms($id_customer, $page_limit, $resultsPerPage);
        $data['customer_info'] = $this->Customer->get_info($id_customer);
        $data['customer_id'] = $id_customer;
        foreach ($data['sale_materials'] as $val) {
            $data_sale_item = $this->Sale->get_sale_item_by_sale_id($val['sale_id']); // lay thong tin item trong don hang
            $data_sale_item_kit = $this->Sale->get_sale_item_kit_by_sale_id($val['sale_id']); //lay thong tin item_kit trong don hang
            $detail_sale_materials[$val['sale_id']][] = $data_sale_item;
            $detail_sale_materials[$val['sale_id']][] = $data_sale_item_kit;
            $sale_data[] = $this->Sale->get_info($val['sale_id'])->row();
            $total_item = 0;
            $total_item_kit = 0;
            foreach ($data_sale_item as $value) {  // tinh tong item
                $total_item = $total_item + $value['quantity_purchased'];
            }
            foreach ($data_sale_item_kit as $value) {
                $total_item_kit = $total_item_kit + $value['quantity_purchased'];
            }
            $detail_sale_materials[$val['sale_id']]['total_item'] = $total_item + $total_item_kit;
        }

        foreach ($data['sale_complete_invs'] as $val) {
            $data_sale_item = $this->Sale->get_sale_item_by_sale_id($val['sale_id']); // lay thong tin item trong don hang
            $data_sale_item_kit = $this->Sale->get_sale_item_kit_by_sale_id($val['sale_id']); //lay thong tin item_kit trong don hang
            $detail_sale[$val['sale_id']][] = $data_sale_item;
            $detail_sale[$val['sale_id']][] = $data_sale_item_kit;
            $sale_data[] = $this->Sale->get_info($val['sale_id'])->row();
            $total_item = 0;
            $total_item_kit = 0;
            foreach ($data_sale_item as $value) {  // tinh tong item
                $total_item = $total_item + $value['quantity_purchased'];
            }
            foreach ($data_sale_item_kit as $value) {
                $total_item_kit = $total_item_kit + $value['quantity_purchased'];
            }
            $detail_sale[$val['sale_id']]['total_item'] = $total_item + $total_item_kit;
        }
        //        echo '1111';exit();
        foreach ($data['sale_all_invs'] as $val) {
            $data_sale_item = $this->Sale->get_sale_item_by_sale_id($val['sale_id']); // lay thong tin item trong don hang
            $data_sale_item_kit = $this->Sale->get_sale_item_kit_by_sale_id($val['sale_id']); //lay thong tin item_kit trong don hang
            $detail_sale_all[$val['sale_id']][] = $data_sale_item;
            $detail_sale_all[$val['sale_id']][] = $data_sale_item_kit;
            $sale_data_all[] = $this->Sale->get_info($val['sale_id'])->row();
            $total_item = 0;
            $total_item_kit = 0;
            foreach ($data_sale_item as $value) {  // tinh tong item
                $total_item = $total_item + $value['quantity_purchased'];
            }
            foreach ($data_sale_item_kit as $value) {
                $total_item_kit = $total_item_kit + $value['quantity_purchased'];
            }
            $detail_sale_all[$val['sale_id']]['total_item'] = $total_item + $total_item_kit;
        }
        $data['mail_history'] = $this->Customer->find_mail_history_customer2($id_customer, $page_limit, $resultsPerPage);
        $data['detail_sale'] = $detail_sale;
        $data['sale_data'] = $sale_data;
        $data['sale_data_all'] = $sale_data_all;
        $data['detail_sale_all'] = $detail_sale_all;
        $data['detail_sale_materials'] = $detail_sale_materials;
        $data['cost'] = $this->Customer->get_customer_money_cost($id_customer);
        $this->load->view('customers/detail_customer_sale', $data);
    }

//hung dq 28-01
    //tab ban hang 1
    function load_more($id_customer) {
        $resultsPerPage = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $paged = $_POST['page'];

        if ($paged > 0) {
            $page_limit = $resultsPerPage * ($paged - 1);
        } else {
            $page_limit = 0;
        }
        $data['num_rows'] = $this->Inventory->get_row($id_customer, $page_limit, $resultsPerPage);
        $data['sale_all_invs'] = $this->Inventory->find_sale_all_customer2($id_customer, $page_limit, $resultsPerPage);
        foreach ($data['sale_all_invs'] as $val) {
            $data_sale_item = $this->Sale->get_sale_item_by_sale_id($val['sale_id']); // lay thong tin item trong don hang
            $data_sale_item_kit = $this->Sale->get_sale_item_kit_by_sale_id($val['sale_id']); //lay thong tin item_kit trong don hang
            $detail_sale_all[$val['sale_id']][] = $data_sale_item;
            $detail_sale_all[$val['sale_id']][] = $data_sale_item_kit;
            $sale_data_all[] = $this->Sale->get_info($val['sale_id'])->row();
            $total_item = 0;
            $total_item_kit = 0;
            foreach ($data_sale_item as $value) {  // tinh tong item
                $total_item = $total_item + $value['quantity_purchased'];
            }
            foreach ($data_sale_item_kit as $value) {
                $total_item_kit = $total_item_kit + $value['quantity_purchased'];
            }
            $detail_sale_all[$val['sale_id']]['total_item'] = $total_item + $total_item_kit;
        }
        $data['sale_data_all'] = $sale_data_all;
        $data['detail_sale_all'] = $detail_sale_all;

        $data['resultsPerPage'] = $resultsPerPage;
        $data['paged'] = $paged;

        $this->load->view('customers/tab_ban_hang', $data);
    }

    //tab thu chi 2
    function load_more2($id_customer) {
        $resultsPerPage = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $paged = $_POST['page'];

        if ($paged > 0) {
            $page_limit = $resultsPerPage * ($paged - 1);
        } else {
            $page_limit = 0;
        }
        $data['num_rows'] = $this->Inventory->get_row2($id_customer, $page_limit, $resultsPerPage);
        $data['cost_complete'] = $this->Inventory->find_cost_complete_customer2($id_customer, $page_limit, $resultsPerPage);
        $data['resultsPerPage'] = $resultsPerPage;
        $data['paged'] = $paged;

        $this->load->view('customers/tab_thu_chi', $data);
    }

    //tab giao dich 3
    function load_more3($id_customer) {
        $resultsPerPage = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $paged = $_POST['page'];

        if ($paged > 0) {
            $page_limit = $resultsPerPage * ($paged - 1);
        } else {
            $page_limit = 0;
        }
        $data['num_rows'] = $this->Inventory->get_row3($id_customer, $page_limit, $resultsPerPage);
        $data['emp_trade'] = $this->Inventory->find_trade_complete_customer2($id_customer, $page_limit, $resultsPerPage);
        $data['resultsPerPage'] = $resultsPerPage;
        $data['paged'] = $paged;

        $this->load->view('customers/tab_thu_chi', $data);
    }

    //tab cong no 4
    function load_more4($id_customer) {
        $resultsPerPage = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $paged = $_POST['page'];

        if ($paged > 0) {
            $page_limit = $resultsPerPage * ($paged - 1);
        } else {
            $page_limit = 0;
        }
        $data['num_rows'] = $this->Inventory->get_row4($id_customer, $page_limit, $resultsPerPage);
        $data['sale_complete_invs'] = $this->Inventory->find_sale_complete_customer2($id_customer, $page_limit, $resultsPerPage);
        $data['customer_id'] = $id_customer;

        foreach ($data['sale_complete_invs'] as $val) {
            $data_sale_item = $this->Sale->get_sale_item_by_sale_id($val['sale_id']); // lay thong tin item trong don hang
            $data_sale_item_kit = $this->Sale->get_sale_item_kit_by_sale_id($val['sale_id']); //lay thong tin item_kit trong don hang
            $detail_sale[$val['sale_id']][] = $data_sale_item;
            $detail_sale[$val['sale_id']][] = $data_sale_item_kit;
            $sale_data[] = $this->Sale->get_info($val['sale_id'])->row();
            $total_item = 0;
            $total_item_kit = 0;
            foreach ($data_sale_item as $value) {  // tinh tong item
                $total_item = $total_item + $value['quantity_purchased'];
            }
            foreach ($data_sale_item_kit as $value) {
                $total_item_kit = $total_item_kit + $value['quantity_purchased'];
            }

            $detail_sale[$val['sale_id']]['total_item'] = $total_item + $total_item_kit;
        }
        $data['detail_sale'] = $detail_sale;
        $data['sale_data'] = $sale_data;

        $data['resultsPerPage'] = $resultsPerPage;
        $data['paged'] = $paged;

        $this->load->view('customers/tab_cong_no', $data);
    }

//tab bao gia 5
    function load_more5($id_customer) {
        $resultsPerPage = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $paged = $_POST['page'];

        if ($paged > 0) {
            $page_limit = $resultsPerPage * ($paged - 1);
        } else {
            $page_limit = 0;
        }
        $data['num_rows'] = $this->Inventory->get_row5($id_customer, $page_limit, $resultsPerPage);

        $data['sale_materials'] = $this->Inventory->find_sale_complete_customer_materials2($id_customer, $page_limit, $resultsPerPage);
        $data['customer_id'] = $id_customer;
        foreach ($data['sale_materials'] as $val) {
            $data_sale_item = $this->Sale->get_sale_item_by_sale_id($val['sale_id']); // lay thong tin item trong don hang
            $data_sale_item_kit = $this->Sale->get_sale_item_kit_by_sale_id($val['sale_id']); //lay thong tin item_kit trong don hang
            $detail_sale_materials[$val['sale_id']][] = $data_sale_item;
            $detail_sale_materials[$val['sale_id']][] = $data_sale_item_kit;
            $sale_data[] = $this->Sale->get_info($val['sale_id'])->row();
            $total_item = 0;
            $total_item_kit = 0;
            foreach ($data_sale_item as $value) {  // tinh tong item
                $total_item = $total_item + $value['quantity_purchased'];
            }
            foreach ($data_sale_item_kit as $value) {
                $total_item_kit = $total_item_kit + $value['quantity_purchased'];
            }
            $detail_sale_materials[$val['sale_id']]['total_item'] = $total_item + $total_item_kit;
        }
        $data['sale_data'] = $sale_data;
        $data['detail_sale_materials'] = $detail_sale_materials;

        $data['resultsPerPage'] = $resultsPerPage;
        $data['paged'] = $paged;

        $this->load->view('customers/tab_bao_gia', $data);
    }

    //tab gui mail 6
    function load_more6($id_customer) {
        $resultsPerPage = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $paged = $_POST['page'];

        if ($paged > 0) {
            $page_limit = $resultsPerPage * ($paged - 1);
        } else {
            $page_limit = 0;
        }
        $data['num_rows'] = $this->Customer->get_row6($id_customer, $page_limit, $resultsPerPage);
        $data['mail_history'] = $this->Customer->find_mail_history_customer2($id_customer, $page_limit, $resultsPerPage);
        $data['resultsPerPage'] = $resultsPerPage;
        $data['paged'] = $paged;

        $this->load->view('customers/tab_gui_mail', $data);
    }

    //tab lich su gui mail
    function load_more_history_sms($id_customer) {
        $resultsPerPage = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $paged = $_POST['page'];

        if ($paged > 0) {
            $page_limit = $resultsPerPage * ($paged - 1);
        } else {
            $page_limit = 0;
        }
        $data['num_rows'] = $this->Customer->get_row_history_sms($id_customer, $page_limit, $resultsPerPage);
        $data['sms_history'] = $this->Customer->get_history_sms($id_customer, $page_limit, $resultsPerPage);
        $data['resultsPerPage'] = $resultsPerPage;
        $data['paged'] = $paged;

        $this->load->view('customers/tab_history_sms', $data);
    }

    //end hung dq

    function add_sale_payment() {
        $sale_id = $this->input->post('sale_id');
        $consideration_paid = $this->input->post('consideration_paid');
        if ($_SESSION['sale_payment_paid'] == null) {
            session_start();
            session_register("sale_payment_paid");
            $_SESSION['sale_payment_paid'][$sale_id] = $consideration_paid;
        } else {
            $_SESSION['sale_payment_paid'][$sale_id] = $consideration_paid;
        }
        var_dump($_SESSION['sale_payment_paid']);
    }

    function del_sale_payment() {
        session_start();
        foreach ($_SESSION['sale_payment_paid'] as $key => $value) {
            if ($key == $this->input->post('sale_id')) {
                unset($_SESSION['sale_payment_paid'][$key]);
            }
        }
//    	var_dump($_SESSION['sale_payment_paid']);
//    	unset($_SESSION['sale_payment_paid']);
    }

    public function customers_check_payment() {
        $customer_id = $this->input->post('customers_id');
        $discount_money = $this->input->post('discount_money') ? str_replace(",", "", $this->input->post('discount_money')) : 0;
        $discount_money_total = str_replace(",", "", $this->input->post('discount_money'));
        $employees = $this->session->userdata('person_id');
        $money_cus = str_replace(',', '', $this->input->post('money_cus'));
        $data['money_total'] = $money_cus; //So tien khach tra no
        //data['sum_money'] la tong gia tri cac don hang
        /* giang 18/6/2014 */
        session_start();
        $data['liabilities'] = array();
        if ($_SESSION['sale_payment_paid'] == null) { // kt neu khong don hang nao duoc chon
            $data['sale_complete_invs'] = $this->Inventory->find_sale_complete_customer($customer_id); // tim cac don hang chua thanh toan het
            foreach ($data['sale_complete_invs'] as $val) {
                $data_sale_tam1 = $this->Sale->get_sales_tam($val['sale_id']);
                $to = 0;
                foreach ($data_sale_tam1 as $key => $val1) {
                    $to = $to + $val1['pays_amount'] + $val1['discount_money'];
                }
                //$data['liabilities'][$val['sale_id']] = $this->Sale->get_sumary($val['sale_id'])->total - $to;
                $data['liabilities'][] = array(
                    'key' => $val['sale_id'],
                    'val' => $this->Sale->get_sumary($val['sale_id'])->total - $to,
                );
                $data['sum_money'] = $this->input->post('sum_money');
            }
        } else {//Co chon don hang
            $data['sum_money'] = 0;
            foreach ($_SESSION['sale_payment_paid'] as $key => $val) {
//                $data['liabilities'][$key] = $val;
                $data['liabilities'][] = array(
                    'key' => $key,
                    'val' => $val,
                );
                $data['sum_money'] = $data['sum_money'] + $val;
            }
        }
        /* giang end */
        $data['customer_info'] = $this->Customer->get_info($customer_id);
        $abc = $this->input->post('check_customer');
        $payment_type_post = $this->input->post('check_payment_type');
        $comma_separated = implode(",", $abc);
        $string = str_replace(",", "", $comma_separated);
        $str = substr($string, 0, 5);
        $payment_type = "Tiền mặt";
        $tongtien = 0;
        $tongno_am = 0;
        $tongno = 0;
        $sotiendatra = 0;
        $tientrahomnay = 0;
        $this->session->set_userdata('userInfo' . $customer_id . '_' . $str, $session_pay_amount);
        $data_employess = $this->session->all_userdata();
        $emp_info = $this->Employee->get_info($data_employess['person_id']);
        $data['employees_name'] = $emp_info->first_name . ' ' . $emp_info->last_name;
        $data['tongno_am1'] = $tongno_am;
        $data['tongtienno'] = $tongno;
        $data['tong_tien_khach'] = $tong_tien_am_duong;
        $data['receipt_title'] = 'THANH TOÁN CÔNG NỢ';
        $data['transaction_time'] = date('Y-m-d H:i:s');
        $data['id_customer'] = $customer_id;
        $data['tien_tra_hom_truoc'] = $sotiendatra;
        $data['tien_hom_nay'] = $tientrahomnay;
        /* giang -> */
        $sale_complete = $this->Inventory->find_sale_complete_customer($customer_id);

        if (!$_SESSION['amortization']) {
            $_SESSION['amortization'] = $money_cus;
        } else {
            $_SESSION['amortization'] = $_SESSION['amortization'] + $money_cus;
        }
        $data['sale_payment_paid_ok'] = array();
        $data['sale_payment_paid_no'] = array();
        $total_pay = 0;
        $k = count($data['liabilities']);
        foreach ($data['liabilities'] as $key => $value) {
            //$val la so tien con no            
            if ($discount_money <= 0) {
                $money_cus = $money_cus - $value['val'];
                $discount = 0;
                if ($money_cus >= 0) {
                    $sus = array(
                        'suspended' => 0,
                        'liability' => 0
                    );
                    $this->Sale->update_suspend((int) $value['key'], $sus);
                    $data_tam = array(
                        'id_sale' => (int) $value['key'],
                        'pays_type' => "Trả góp",
                        'pays_amount' => $value['val'],
                        'discount_money' => 0,
                        'employees_id' => $employees,
                        'date_tam' => date('Y-m-d H:i:s'),
                        'stt' => 1
                    );
                    $this->Sale->insert_sales_tam($data_tam);
                    //$data['sale_payment_paid_ok'][$value['key']] = $value['val'];
                    $data['sale_payment_paid_ok'][] = array(
                        'key' => $value['key'],
                        'val' => $value['val'],
                        'money' => $value['val'],
                    );
                    $data_payment_sale = array(
                        'sale_id' => (int) $value['key'],
                        'payment_type' => "Trả góp",
                        'payment_amount' => $value['val'],
                        'discount_money' => 0,
                    );
                    $this->Sale->insert_payment_sale($data_payment_sale);
                    $cost_comment = "Thu tiền thanh toán nợ của khách hàng " . $this->Customer->get_info($customer_id)->first_name . ' ' . $this->Customer->get_info($customer_id)->last_name;
                    $cost_data = array(
                        'id_customer' => $customer_id,
                        'name' => 4,
                        'money' => $value['val'],
                        'form_cost' => 0,
                        'date' => date('Y-m-d H:i:s'),
                        'cost_date_ct' => date('Y-m-d'),
                        'comment' => $cost_comment,
                        'deleted' => 0,
                        'id_sale' => (int) $value['key'],
                        'cost_employees' => $data_employess['person_id'],
                        'stt'=>1
                    );
                    $this->Sale->insert_cost($cost_data);
                } else {
                    $money_cus = abs($money_cus);
                    $data['residual'] = $value['val'] - $money_cus;
                    $data_tam = array(
                        'id_sale' => (int) $value['key'],
                        'pays_type' => "Trả góp",
                        'pays_amount' => $value['val'] - $money_cus,
                        'discount_money' => 0,
                        'employees_id' => $employees,
                        'date_tam' => date('Y-m-d H:i:s'),
                        'stt' => 1
                    );
                    $this->Sale->insert_sales_tam($data_tam);
                    $data['sale_payment_paid_no'][] = array(
                        'key' => $value['key'],
                        'val' => $value['val'],
                    );
                    $data_payment_sale = array(
                        'sale_id' => (int) $value['key'],
                        'payment_type' => "Trả góp",
                        'payment_amount' => $value['val'] - $money_cus,
                        'discount_money' => 0,
                    );
                    $this->Sale->insert_payment_sale($data_payment_sale);
                    $cost_comment = "Thu tiền thanh toán nợ của khách hàng " . $this->Customer->get_info($customer_id)->first_name . ' ' . $this->Customer->get_info($customer_id)->last_name . ' hình thức trả góp';
                    $cost_data = array(
                        'id_customer' => $customer_id,
                        'name' => 4,
                        'money' => $value['val'] - $money_cus,
                        'form_cost' => 0,
                        'date' => date('Y-m-d H:i:s'),
                        'cost_date_ct' => date('Y-m-d'),
                        'comment' => $cost_comment,
                        'deleted' => 0,
                        'id_sale' => (int) $value['key'],
                        'cost_employees' => $data_employess['person_id'],
                        'stt'=>1
                    );
                    $this->Sale->insert_cost($cost_data);
                    break;
                }
            } else {
//                if($key == 0){
//                    if($discount_money >= $value['val']){
//                        $money_cus = $money_cus + ($discount_money - $value['val']);
//                    }else{
//                        $money_cus = $money_cus - ($value['val'] - $discount_money);                        
//                    }
//                    $discount_money = $discount_money;
//                    $discount = $discount_money;
//                }else{
//                    $discount = $discount_money;
//                    $discount_money = 0;
//                    $money_cus = $money_cus - $value['val'];
//                }               
                if ($discount_money >= $value['val']) {
                    $discount = $value['val'];
                    $money_cus = $money_cus;
                    $discount_money = $discount_money - $value['val'];
                } else {
                    if (($money_cus + $discount_money) >= $value['val']) {
                        $money_cus = $money_cus - $value['val'] + $discount_money;
                    } else {
                        $money_cus = $money_cus - $value['val'];
                    }
                    $discount = $discount_money;
                    $discount_money = 0;
                }
                if ($money_cus >= 0) {
                    $sus = array(
                        'suspended' => 0,
                        'liability' => 0
                    );
                    $this->Sale->update_suspend((int) $value['key'], $sus);
                    if ($discount_money >= $value['val']) {
                        $money = 0;
                    } else {
                        $money = $value['val'] - $discount;
                    }
                    $data_tam = array(
                        'id_sale' => (int) $value['key'],
                        'pays_type' => "Trả góp",
                        'pays_amount' => $money,
                        'discount_money' => $discount,
                        'employees_id' => $employees,
                        'date_tam' => date('Y-m-d H:i:s'),
                        'stt' => 1
                    );
                    $this->Sale->insert_sales_tam($data_tam);
                    $data['sale_payment_paid_ok'][] = array(
                        'key' => $value['key'],
                        'val' => $value['val'],
                        'money' => $money,
                    );
                    $data_payment_sale = array(
                        'sale_id' => (int) $value['key'],
                        'payment_type' => "Trả góp",
                        'payment_amount' => $money,
                        'discount_money' => $discount,
                    );
                    $this->Sale->insert_payment_sale($data_payment_sale);
                    $cost_comment = "Thu tiền thanh toán nợ của khách hàng " . $this->Customer->get_info($customer_id)->first_name . ' ' . $this->Customer->get_info($customer_id)->last_name;
                    $cost_data = array(
                        'id_customer' => $customer_id,
                        'name' => 4,
                        'money' => $money,
                        'form_cost' => 0,
                        'date' => date('Y-m-d H:i:s'),
                        'cost_date_ct' => date('Y-m-d'),
                        'comment' => $cost_comment,
                        'deleted' => 0,
                        'id_sale' => (int) $value['key'],
                        'cost_employees' => $data_employess['person_id'],
                        'stt'=>1
                    );
                    $this->Sale->insert_cost($cost_data);
                } else {
                    $money_cus = abs($money_cus);
                    if ($discount_money < $value['val']) {
                        $residual = $value['val'] - $money_cus;
                        $pays_amount = $value['val'] - $money_cus - $discount_money;
                    } else {
                        $residual = $value['val'] - $money_cus - $discount_money;
                        $pays_amount = $value['val'] - $money_cus;
                    }
                    $data['residual'] = $residual;
                    $data_tam = array(
                        'id_sale' => (int) $value['key'],
                        'pays_type' => "Trả góp",
                        'pays_amount' => $pays_amount,
                        'discount_money' => $discount,
                        'employees_id' => $employees,
                        'date_tam' => date('Y-m-d H:i:s'),
                        'stt' => 1
                    );
                    $this->Sale->insert_sales_tam($data_tam);
//                    $data['sale_payment_paid_no'][$value['key']] = $value['val'];
                    $data['sale_payment_paid_no'][] = array(
                        'key' => $value['key'],
                        'val' => $value['val'],
                    );
                    $data_payment_sale = array(
                        'sale_id' => (int) $value['key'],
                        'payment_type' => "Trả góp",
                        'payment_amount' => $pays_amount,
                        'discount_money' => $discount,
                    );
                    $this->Sale->insert_payment_sale($data_payment_sale);
                    $cost_comment = "Thu tiền thanh toán nợ của khách hàng " . $this->Customer->get_info($customer_id)->first_name . ' ' . $this->Customer->get_info($customer_id)->last_name . ' hình thức trả góp';
                    $cost_data = array(
                        'id_customer' => $customer_id,
                        'name' => 4,
                        'money' => $pays_amount,
                        'form_cost' => 0,
                        'date' => date('Y-m-d H:i:s'),
                        'cost_date_ct' => date('Y-m-d'),
                        'comment' => $cost_comment,
                        'deleted' => 0,
                        'id_sale' => (int) $value['key'],
                        'cost_employees' => $data_employess['person_id'],
                        'stt'=>1
                    );
                    $this->Sale->insert_cost($cost_data);
                    break;
                }
            }
        }
        $session_thutrano_new = array(
            'payamount_ttn' => $data['money_total'],
        );
        $this->session->set_userdata('payamount_ttn' . $customer_id . '_' . $str, $session_thutrano_new);
        unset($_SESSION['sale_payment_paid']);
        $data['discount_money'] = $discount;
        $data['discount_money_total'] = $discount_money_total;
        $this->load->view('sales/thanhtoanno', $data);
    }

    function switch_sale($id_sale) {
        $this->sale_lib->clear_all();
        $this->sale_lib->copy_entire_sale($id_sale);
        $this->sale_lib->set_suspended_sale_id($id_sale);
        $employee = $this->Employee->get_logged_in_employee_info();
        if ($employee->person_id == 1) {
            redirect('sales');
        } else {
            redirect('customers');
        }
    }

    function cleanup() {
        $this->Customer->cleanup();
        echo json_encode(array('success' => true, 'message' => lang('customers_cleanup_sucessful')));
    }

    /*
      get the width for the add/edit form
     */

    function get_form_width() {
        return 750;
    }

    /**
     * Function manage email template
     */
    function manage_mail() {

        $config['total_rows'] = $this->Customer->count_all_mail();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $config['base_url'] = site_url('customers/sorting_mail');
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['per_page'] = $config['per_page'];

        $data['manage_table'] = get_mail_manage_table($this->Customer->get_all_mail($data['per_page']), $this);
        //$data['list_mails'] = $this->Customer->get_all_mail($data['per_page'])->result();
        //print_r($data['list_mails']);die;
        $this->load->view("customers/manage_mail", $data);
    }

    function sorting_mail() {
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;

        $config['total_rows'] = $this->Customer->count_all_mail();
        $table_data = $this->Customer->get_all_mail($per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'mail_title', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');

        $config['base_url'] = site_url('customers/sorting_mail');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_mail_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    /**
     * Function create new mail template
     */
    function create_mail() {
        $this->load->helper('ckeditor');
        $this->load->view("customers/create_mail", $data);
    }

    /**
     * Function edit/add mail template
     */
    function view_mail($mail_id = -1) {
        $config['global_xss_filtering'] = FALSE;
        $this->form_validation->set_rules('inhoud', 'inhoud', 'xss|clean');
        $data['mail_info'] = $this->Customer->get_info_mail($mail_id);
        $this->load->helper('ckeditor');

        //Ckeditor's configuration
        $data['ckeditor'] = array(
            //ID of the textarea that will be replaced
            'id' => 'mail_content',
            'path' => 'js/ckeditor',
            'value' => $_POST['mail_content'],
            //Optionnal values
            'config' => array(
                'toolbar' => "Full", //Using the Full toolbar
                'width' => "750px", //Setting a custom width
                'height' => '200px', //Setting a custom height
            ),
            //Replacing styles from the "Styles tool"
            'styles' => array(
                //Creating a new style named "style 1"
                'style 1' => array(
                    'name' => 'Blue Title',
                    'element' => 'h2',
                    'styles' => array(
                        'color' => 'Blue',
                        'font-weight' => 'bold'
                    )
                ),
                //Creating a new style named "style 2"
                'style 2' => array(
                    'name' => 'Red Title',
                    'element' => 'h2',
                    'styles' => array(
                        'color' => 'Red',
                        'font-weight' => 'bold',
                        'text-decoration' => 'underline'
                    )
                )
            )
        );


        $this->load->view("customers/create_mail", $data);
    }

    /**
     * function save mail template
     */
    function save_mail($mail_id = -1) {

        $mail_data = array(
            'mail_title' => $this->input->post('mail_title'),
            'mail_content' => $this->input->post('mail_content')
        );
        //print_r($mail_data);die;
        if ($this->Customer->save_mail($mail_data, $mail_id)) {
            if ($mail_id == -1) {
//                echo json_encode(array('success' => true, 'message' => 'Đã thêm mail mới: ' .
//                    $mail_data['mail_title'], 'mail_id' => $mail_data['mail_id']));
            } else { //previous customer
//                echo json_encode(array('success' => true, 'message' => 'Đã cập nhật email: ' .
//                    $mail_data['mail_title'], 'mail_id' => $mail_data['mail_id']));
            }
        } else {//failure
            echo json_encode(array('success' => false, 'message' => 'Lỗi khi thêm email mới ', 'mail_id' => -1));
        }
        redirect('/customers/manage_mail', 'location');
    }

    /**
     * Function delete email template
     */
    function delete_mail() {
        $check = true;
        $mails_to_delete = $this->input->post('ids');
        $list_mail_template = array();
        $list_mail_template[] = $this->config->item('mail_template_birthday');
        $list_mail_template[] = $this->config->item('mail_template_contact');
        $list_mail_template[] = $this->config->item('mail_template_calendar');
        $title_mail = array();
        foreach ($list_mail_template as $key => $value) {
            $info_mail = $this->Customer->get_info_mail($value);
            $title_mail[] = $info_mail->mail_title;
            foreach ($mails_to_delete as $key1 => $value1) {
                if ($value == $value1) {
                    $check = false;
                }
            }
        }
        if ($check) {
            if ($this->Customer->delete_mail_list($mails_to_delete)) {
                echo json_encode(array('success' => true, 'message' => ' Đã xóa!' . count($mails_to_delete) . ' email!'));
            } else {
                echo json_encode(array('success' => false, 'message' => 'Lỗi! Không xóa được, vui lòng thử lại!'));
            }
        } else {
            $msg = "<br>(";
            for ($i = 0; $i < count($title_mail); $i++) {
                $msg .= $title_mail[$i] . "), ";
            }
            echo json_encode(array('success' => false, 'message' => 'Lỗi! Không được xóa mail tempalte config tự động!' . substr($msg, 0, strlen($msg) - 2) . ")"));
        }
    }

    /**
     * Function send email
     */
    function send_mail() {
        $mails_to_send = $this->input->post('ids');
        $config['global_xss_filtering'] = FALSE;
        $this->form_validation->set_rules('inhoud', 'inhoud', 'xss|clean');
        $data['list_mail'] = $this->Customer->get_all_mail();
        $data['list_customer'] = $this->Customer->get_all();
        $list_mail = array('' => lang('items_none'));
        foreach ($this->Customer->get_all_mail()->result_array() as $lm) {
            $list_mail[$lm['mail_id']] = $lm['mail_title'];
        }
        $data['list_mail'] = $list_mail;
        $list_mail_content = array('' => lang('items_none'));
        foreach ($this->Customer->get_all_mail()->result_array() as $lm) {
            $list_mail_content[$lm['mail_id']] = $lm['mail_content'];
        }
        $data['list_mail_content'] = $list_mail_content;
        $this->load->helper('ckeditor');
        $this->load->view("customers/send_mail", $data);
    }

    /**
     * Function send email
     */
    function do_send_mail() {
        $check = $this->input->post("type_send");
        $customer_ids = $this->input->post('customer_ids');
        $mail_id = $this->input->post('mail_id');
        $mail_info = $this->Customer->get_info_mail($mail_id);
        $info_emp = $this->Employee->get_info($this->session->userdata('person_id'));
        $list_email = array();
        $send_success = array();
        $send_fail = array();
        if ($check == 1) {
            if (isset($_SESSION['mail']) && $_SESSION['mail'] != NULL) {
                foreach ($_SESSION['mail'] as $mail) {
                    $list_email[] = $mail['email'];
                    if ($mail['email'] != "") {
                        $config = Array(
                            'protocol' => 'smtp',
                            'smtp_host' => 'ssl://smtp.googlemail.com',
                            'smtp_port' => 465,
                            'smtp_user' => $this->config->item('email'),
                            'smtp_pass' => $this->config->item('pass_email'),
                            'charset' => 'utf-8',
                            'mailtype' => 'html'
                        );
                        $this->load->library('email', $config);
                        $this->email->set_newline("\r\n");
                        $this->email->from($this->config->item('email'), $this->config->item('company'));
                        $this->email->subject($mail_info->mail_title);
                        $user_info = $this->Customer->get_info_person_by_id($mail['person_id']);
                        $info_contraccustomer = $this->Contractcustomers->get_info_contraccustomer_by_customer($mail['person_id']);
                        $content = $mail_info->mail_content;
                        //Thong tin khach hang duoc gui mail
                        $content = str_replace('__FIRST_NAME__', $user_info['first_name'], $content);
                        $content = str_replace('__LAST_NAME__', $user_info['last_name'], $content);
                        $content = str_replace('__PHONE_NUMBER__', $user_info['phone_number'], $content);
                        $content = str_replace('__EMAIL__', $user_info['email'], $content);
                        $content = str_replace('__COMPANY_CUSTOMER__', $user_info['company_name'], $content);
                        //Thong tin chu ky cong ty gui mail
                        $content = str_replace('__NAME_COMPANY__', '<b>' . $this->config->item('company') . '</b>', $content);
                        $content = str_replace('__ADDRESS_COMPANY__', $this->config->item('address'), $content);
                        $content = str_replace('__EMAIL_COMPANY__', $this->config->item('email'), $content);
                        $content = str_replace('__FAX_COMPANY__', $this->config->item('fax'), $content);
                        $content = str_replace('__WEBSITE_COMPANY__', $this->config->item('website'), $content);
                        //Thong tin nhan vien
                        $content = str_replace('__FIRST_NAME_EMPLOYEE__', '<b>' . $info_emp->first_name . '</b>', $content);
                        $content = str_replace('__LAST_NAME_EMPLOYEE__', $info_emp->last_name, $content);
                        $content = str_replace('__PHONE_NUMBER_EMPLOYEE__', $info_emp->phone_number, $content);
                        $content = str_replace('__EMAIL_EMPLOYEE__', $info_emp->email, $content);
                        //Thong tin hop dong
                        if ($info_contraccustomer) {
                            $content = str_replace('__NAME_CONTRACT__', '<b>' . $info_contraccustomer['name'] . '</b>', $content);
                            $content = str_replace('__NUMBER_CONTRACT__', $info_contraccustomer['number_contract'], $content);
                            $content = str_replace('__START_DATE__', date('d-m-Y', strtotime($info_contraccustomer['start_date'])), $content);
                            $content = str_replace('__EXPIRATION_DATE__', date('d-m-Y', strtotime($info_contraccustomer['end_date'])), $content);
                        } else {
                            $content = str_replace('__NAME_CONTRACT__', '', $content);
                            $content = str_replace('__NUMBER_CONTRACT__', '', $content);
                            $content = str_replace('__START_DATE__', '', $content);
                            $content = str_replace('__EXPIRATION_DATE__', '', $content);
                        }
                        $this->email->message($content);
                        $this->email->to($mail['email']);
                        if ($this->email->send()) {
                            $send_success[] = $mail['email'];
                            $data_history = array(
                                'person_id' => $mail['person_id'],
                                'employee_id' => $this->session->userdata('person_id'),
                                'title' => $mail_info->mail_title,
                                'content' => $content,
                                'time' => date('Y-m-d H:i:s'),
                                'status' => 1,
                            );
                            $this->Customer->add_mail_history($data_history);
                            unset($_SESSION['mail'][$mail['person_id']]);
                        } else {
                            $send_fail[] = $mail['email'];
                            $data_history = array(
                                'person_id' => $mail['person_id'],
                                'employee_id' => $this->session->userdata('person_id'),
                                'title' => $mail_info->mail_title,
                                'content' => $content,
                                'time' => date('Y-m-d H:i:s'),
                                'status' => 0,
                            );
                            $this->Customer->add_mail_history($data_history);
                            show_error($this->email->print_debugger());
                            unset($_SESSION['mail'][$mail['person_id']]);
                        }
                    }
                }
            }
        } else {
            foreach ($customer_ids as $item) {
                $info_cus = $this->Customer->get_info($item);
                $info_contraccustomer = $this->Contractcustomers->get_info_contraccustomer_by_customer($info_cus->person_id);
                if ($info_cus->email != "") {
                    $config = Array(
                        'protocol' => 'smtp',
                        'smtp_host' => 'ssl://smtp.googlemail.com',
                        'smtp_port' => 465,
                        'smtp_user' => $this->config->item('email'),
                        'smtp_pass' => $this->config->item('pass_email'),
                        'charset' => 'utf-8',
                        'mailtype' => 'html'
                    );
                    $this->load->library('email', $config);
                    $this->email->set_newline("\r\n");
                    $this->email->from($this->config->item('email'), $this->config->item('company'));
                    $this->email->subject($mail_info->mail_title);
                    $this->email->message($mail_info->mail_content);
                    $content = $mail_info->mail_content;
                    //Thong tin khach hang duoc gui mail           
                    $content = str_replace('__FIRST_NAME__', $info_cus->first_name, $content);
                    $content = str_replace('__LAST_NAME__', $info_cus->last_name, $content);
                    $content = str_replace('__PHONE_NUMBER__', $info_cus->phone_number, $content);
                    $content = str_replace('__EMAIL__', $info_cus->email, $content);
                    $content = str_replace('__COMPANY_CUSTOMER__', $info_cus->company_name, $content);
                    //Thong tin chu ky cong ty gui mail
                    $content = str_replace('__NAME_COMPANY__', '<b>' . $this->config->item('company') . '</b>', $content);
                    $content = str_replace('__ADDRESS_COMPANY__', $this->config->item('address'), $content);
                    $content = str_replace('__EMAIL_COMPANY__', $this->config->item('email'), $content);
                    $content = str_replace('__FAX_COMPANY__', $this->config->item('fax'), $content);
                    $content = str_replace('__WEBSITE_COMPANY__', $this->config->item('website'), $content);
                    //Thong tin nhan vien
                    $content = str_replace('__FIRST_NAME_EMPLOYEE__', '<b>' . $info_emp->first_name . '</b>', $content);
                    $content = str_replace('__LAST_NAME_EMPLOYEE__', $info_emp->last_name, $content);
                    $content = str_replace('__PHONE_NUMBER_EMPLOYEE__', $info_emp->phone_number, $content);
                    $content = str_replace('__EMAIL_EMPLOYEE__', $info_emp->email, $content);
                    //Thong tin hop dong
                    if ($info_contraccustomer) {
                        $content = str_replace('__NAME_CONTRACT__', '<b>' . $info_contraccustomer['name'] . '</b>', $content);
                        $content = str_replace('__NUMBER_CONTRACT__', $info_contraccustomer['number_contract'], $content);
                        $content = str_replace('__START_DATE__', date('d-m-Y', strtotime($info_contraccustomer['start_date'])), $content);
                        $content = str_replace('__EXPIRATION_DATE__', date('d-m-Y', strtotime($info_contraccustomer['end_date'])), $content);
                    } else {
                        $content = str_replace('__NAME_CONTRACT__', '', $content);
                        $content = str_replace('__NUMBER_CONTRACT__', '', $content);
                        $content = str_replace('__START_DATE__', '', $content);
                        $content = str_replace('__EXPIRATION_DATE__', '', $content);
                    }
                    $this->email->message($content);
                    $this->email->to($info_cus->email);
                    if ($this->email->send()) {
                        $send_success[] = $info_cus->email;
                        $data_history = array(
                            'person_id' => $item,
                            'employee_id' => $this->session->userdata('person_id'),
                            'title' => $mail_info->mail_title,
                            'content' => $content,
                            'time' => date('Y-m-d H:i:s'),
                            'status' => 1,
                        );
                        $this->Customer->add_mail_history($data_history);
                    } else {
                        $send_fail[] = $info_cus->email;
                        $data_history = array(
                            'person_id' => $item,
                            'employee_id' => $this->session->userdata('person_id'),
                            'title' => $mail_info->mail_title,
                            'content' => $content,
                            'time' => date('Y-m-d H:i:s'),
                            'status' => 0,
                        );
                        $this->Customer->add_mail_history($data_history);
                        show_error($this->email->print_debugger());
                    }
                }
            }
        }

        if (empty($send_success)) {
            echo json_encode(array('success' => false, 'message' => 'Không gửi được mail: '));
        } else if (empty($send_fail)) {
            echo json_encode(array(
                'success' => true,
                'message' => 'Đã gửi mail thành công! '));
        } else {
            $list_success = '';
            foreach ($send_success as $s) {
                $list .= $s . ', ';
            }
            $list_fail = '';
            foreach ($send_fail as $s) {
                $list .= $s . ', ';
            }
            echo json_encode(array('success' => true, 'message' => 'Đã gửi mail thành công: ' . $list_success)) .
            json_encode(array('success' => false, 'message' => 'Không gửi được mail: ' . $list_fail));
        }
    }

    public function auto_send_mail() {
        //get current day
        //$birthday = '0000-00-00';
        $date = new DateTime();
        $birthday = $date->format('m-d');
        //get all customer has birthday on current day
        $list_customer = $this->Customer->get_multiple_birthday_info($birthday)->result();
        //get list_email of customer from multi ids
        $list_customer_email = array();
        foreach ($list_customer as $l_c) {
            if ($l_c->email != '')
                $list_customer_email[] = $l_c->email;
        }

        $ses = new SimpleEmailService('AKIAJE5YLNPAORD6YITA', 'X59R6xbOpdJwtVT5MVEsbyCPYD8SL3e0iTP4Al7i');
        $ses->enableVerifyHost(false);
        $ses->enableVerifyPeer(false);

        $m = new SimpleEmailServiceMessage();
        $m->setFrom('gs.daycon@gmail.com');

        foreach ($list_customer_email as $l) {
            $m->addTo($l);
        }

        $m->setSubject('Chúc mừng sinh nhật');
        $mail_content = 'Kính chào quý khách hàng!';
        $mail_content .= '<br/>Xin chúc mừng sinh nhật quý khách. Chúc quý khách sang tuổi mới thật nhiều niềm vui, hạnh phúc, đạt được nhiều thành công!';
        $m->setMessageFromString('', $mail_content);
        if ($ses->sendEmail($m) === false) {
            $send_success = 0;
            echo json_encode(array('success' => false, 'message' => 'Không gửi được mail'));
        } else {
            $send_success = 1;
            echo json_encode(array('success' => true, 'message' => 'Đã gửi mail'));
        }
    }

    /*
      Gets one row for a person manage table. This is called using AJAX to update one row.
     */

    function get_row_mail() {
        $mail_id = $this->input->post('row_id');
        $data_row = get_mail_data_row($this->Customer->get_info_mail($mail_id), $this);
        echo $data_row;
    }

    //Created by San
    function save_list_send_mail($item_ids) {
        $item_ids = explode('~', $item_ids);
        foreach ($item_ids as $item) {
            $info_cus = $this->Customer->get_info_person_by_id($item);
            if (isset($_SESSION['mail'][$item])) {
                continue;
            } else {
                $_SESSION['mail'][$info_cus['person_id']] = array(
                    'person_id' => $item,
                    'name' => $info_cus['first_name'] . " " . $info_cus['last_name'],
                    'email' => $info_cus['email'],
                );
            }
        }
        redirect('customers');
    }

    function remove_mail_list() {
        $person_id = $_POST['id'];
        if ($person_id == 0) {
            unset($_SESSION['mail']);
        } else {
            unset($_SESSION['mail'][$person_id]);
            echo count($_SESSION['mail']);
        }
    }

    function save_session_employee() {
        $employee_id = $_POST['employee_id'];
        if ($employee_id) {
            if ($this->session->userdata('ma_nhan_vien')) {
                $this->session->unset_userdata('ma_nhan_vien');
                $this->session->set_userdata('ma_nhan_vien', $employee_id);
            } else {
                $this->session->set_userdata('ma_nhan_vien', $employee_id);
            }
        } else {
            if ($this->session->userdata('ma_nhan_vien')) {
                $this->session->unset_userdata('ma_nhan_vien');
                $this->session->set_userdata('ma_nhan_vien', 1);
            }
        }
    }
    
    function save_session_filter(){
        $filter_enable = $_POST['filter_id'];
        if($filter_enable){
            if ($this->session->userdata('ma_nhan_vien')) {
                $this->session->unset_userdata('ma_nhan_vien');
                $this->session->set_userdata('ma_nhan_vien', $employee_id);
            } else {
                $this->session->set_userdata('ma_nhan_vien', $employee_id);
            }
        }else{
            if ($this->session->userdata('ma_nhan_vien')) {
                $this->session->unset_userdata('ma_nhan_vien');
                $this->session->set_userdata('ma_nhan_vien', 1);
            }
        }
    }

    function view_mail_history($id) {
        $data['mail_history'] = $this->Customer->get_info_mail_history($id);
        $this->load->view("customers/form_mail_history", $data);
    }

    function remove_mail_history($id) {
        $id = $_POST['id'];
        $mail_history = $this->Customer->get_info_mail_history($id);
        if ($mail_history['file'] != "" && $mail_history['status'] == 0) {
            unlink(APPPATH . "/../excel_materials/" . $mail_history['file']);
        }
        $this->Customer->delete_mail_history($id);
    }

    function save_session_type_customer() {
        $type_customer = $_POST['type_customer'];
        if ($type_customer) {
            if ($this->session->userdata('loai_khach_hang')) {
                $this->session->unset_userdata('loai_khach_hang');
                $this->session->set_userdata('loai_khach_hang', $type_customer);
            } else {
                $this->session->set_userdata('loai_khach_hang', $type_customer);
            }
        } else {
            if ($this->session->userdata('loai_khach_hang')) {
                $this->session->unset_userdata('loai_khach_hang');
                $this->session->set_userdata('loai_khach_hang', 0);
            }
        }
    }

    function get_number_birthday() {
        $customer_birthday = array();
        $customer = $this->Customer->findBirthDate();
        foreach ($customer as $cus) {
            $cus_mail_auto = $this->Customer->get_customer_mail_auto($cus['person_id']);
            $active = ($cus_mail_auto['active'] == 1) ? "Đã gửi" : "Chưa gửi";
            $birth_date = date("d-m-Y", strtotime($cus['birth_date']));
            $url = site_url("reports/specific_customer/" . date('d-m-Y', 0) . "/" . date('d-m-Y') . "/" . $cus['person_id'] . "/all/0");
            $customer_birthday[] = array(
                'person_id' => $cus['person_id'],
                'first_name' => $cus['first_name'],
                'last_name' => $cus['last_name'],
                'birth_date' => $birth_date,
                'active' => $active,
                'start_of_time' => date('d-m-Y', 0),
                'today' => date('d-m-Y'),
                'url' => $url,
            );
        }
        $k = count($customer);
        echo json_encode(array("number" => $k, "customers_birthday" => $customer_birthday));
    }

    //SMS
    function save_list_contacts($item_ids) {
        $item_ids = explode('~', $item_ids);
        foreach ($item_ids as $item) {
            $info_cus = $this->Customer->get_info_person_by_id($item);
            if (isset($_SESSION['SMS'][$item])) {
                continue;
            } else {
                $_SESSION['SMS'][$info_cus['person_id']] = array(
                    'person_id' => $item,
                    'name' => $info_cus['first_name'] . " " . $info_cus['last_name'],
                    'phone_number' => $info_cus['phone_number'],
                );
            }
        }
        redirect('customers');
    }

    function remove_contacts_list() {
        $person_id = $_POST['id'];
        if ($person_id == 0) {
            unset($_SESSION['SMS']);
        } else {
            unset($_SESSION['SMS'][$person_id]);
            echo count($_SESSION['SMS']);
        }
    }

    /**
     * Function manage Brandname
     */
    function manage_sms() {
        $config['total_rows'] = $this->Customer->count_all_sms();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $config['base_url'] = site_url('customers/sorting_sms');
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_sms_manage_table($this->Customer->get_all_sms($data['per_page']), $this);
        $this->load->view("customers/manage_sms", $data);
    }

    function sorting_sms() {
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $config['total_rows'] = $this->Customer->count_all_sms();
        $table_data = $this->Customer->get_all_sms($per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'DESC');

        $config['base_url'] = site_url('customers/sorting_sms');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_sms_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    /**
     * Function edit/add mail template
     */
    function view_sms($id = -1) {
        $data['info_sms'] = $this->Customer->get_info_sms($id);
        $this->load->view("customers/form_sms", $data);
    }

    /**
     * function save mail template
     */
    function save_sms($id = -1) {
        $sms_data = array(
            'title' => $this->input->post('title'),
            'message' => $this->input->post('message'),
			'number_char' => $this->input->post('char'),
            'number_message' => $this->input->post('number_message'),
        );
        if ($this->Customer->save_sms($sms_data, $id)) {
            if ($id == -1) {
                echo json_encode(array('success' => true, 'message' => 'Tạo mới SMS (' .
                    $sms_data['title'] . ') thành công!', 'id' => $sms_data['id']));
            } else { //previous customer
                echo json_encode(array('success' => true, 'message' => 'Cập nhật SMS (' .
                    $sms_data['title'] . ') thành công!', 'id' => $sms_data['id']));
            }
        } else {//failure
            echo json_encode(array('success' => false, 'message' => 'Lỗi thêm mới hoặc cập nhật SMS', 'id' => -1));
        }
    }

    function get_row_sms() {
        $id = $this->input->post('row_id');
        $data_row = get_sms_data_row($this->Customer->get_info_sms($id), $this);
        echo $data_row;
    }

    /**
     * Function delete email template
     */
    function delete_sms() {
        $sms_to_delete = $this->input->post('ids');
        if ($this->Customer->delete_sms_list($sms_to_delete)) {
            echo json_encode(array('success' => true, 'message' => ' Đã xóa!' . count($sms_to_delete) . ' SMS!'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Lỗi! Không xóa được, vui lòng thử lại!'));
        }
    }

    function send_sms() {
        $sms_to_send = $this->input->post('ids');
        $data['list_sms'] = $this->Customer->get_all_sms();
        $this->load->view("customers/send_sms", $data);
    }

    function do_send_sms() {
        $customer_ids = $this->input->post('customer_ids');
        $sms_id = $this->input->post('sms_id');
        $info_sms = $this->Customer->get_info_sms($sms_id);
        $message = $info_sms->message;
        $max_id_table_number_sms = $this->Customer->get_table_number_sms();
        $info_max_id = $this->Customer->get_info_id_max_of_table_number_sms($max_id_table_number_sms['id']);
        if($info_max_id['quantity_sms'] > 0){
            foreach ($customer_ids as $id_cus) {
                $info_cus = $this->Customer->get_info($id_cus);
                $mobile = '84' . substr($info_cus->phone_number, 1, strlen($info_cus->phone_number));
                $getdata = http_build_query(array(
                    'username' => $this->config->item('user_sms'),
                    'password' => $this->config->item('pass_sms'),
                    'source_addr' => $this->config->item('brandname'),
                    'dest_addr' => $mobile,
                    'message' => $message,
                ));
                $opts = array(
                    'http' => array(
                        'method' => 'GET',
                        'content' => $getdata
                    )
                );
                $context = stream_context_create($opts);
                $result = file_get_contents('http://sms.vnet.vn:8082/api/sent?' . $getdata, false, $context);
                if ($result) {
                    $data_insert = array(
                        'id_cus' => $id_cus,
                        'mobile' => $mobile,
                        'content_message' => $message,
                        'equals' => $result,
                        'date_send' => date('Y-m-d H:i:s'),
                    );
                    $this->Customer->save_message($data_insert);
                    if($result > 0){                    
                        $data_update_table_number_sms = array(
                            'quantity_sms' => ($info_max_id['quantity_sms'] - $info_sms->number_message),
                        );
                        $this->Customer->update_number_sms($max_id_table_number_sms['id'],$data_update_table_number_sms);                    
                    }
                    echo json_encode(array("success" => true, "message" => "Thực hiện thành công"));
                } else {
                    echo json_encode(array("success" => false, "message" => "Thực hiện không thành công"));
                }
            }
        }else{
            echo json_encode(array("success" => false, "message" => "Tin nhắn không đủ để thực hiện! Vui lòng liên hệ với nhà cung cấp để mua thêm tin nhắn"));
        }
    }

    function search_sms() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Customer->search_sms($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        $config['base_url'] = site_url("customers/search_sms");
        $config['total_rows'] = $this->Customer->search_count_sms($search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_sms_manage_table_data_rows($search_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function suggest_sms() {
        $suggestions = $this->Customer->get_search_suggestions_sms($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }
    function get_number_sms(){
        $max_id_sms = $this->Customer->get_table_number_sms();
        $sms = $this->Customer->get_info_id_max_of_table_number_sms($max_id_sms['id']);
        echo json_encode(array("quantity_sms" => $sms['quantity_sms']));
    }
//    By Loi
     function phone_number_exists() {
        $person_id = $this->input->post("person_id");
        $phone_number = $this->input->post("phone_number");
        echo ($this->Customer->phone_number_exists($phone_number,$person_id)?"false":"true");
    }
//    end Loi
}

?>