<?php

session_start();
require_once(APPPATH . 'third_party/Classes/PHPExcel/IOFactory.php');
require_once(APPPATH . 'libraries/php-excel.class.php');
require_once ("person_controller.php");
require_once ("secure_area.php");

class Suppliers extends Person_controller {

    function __construct() {
        parent::__construct('suppliers');
        $this->load->library('receiving_lib');
        $this->load->model('Receiving_order');
    }

    function index() {
        $this->check_action_permission('search');
        $config['base_url'] = site_url('suppliers/sorting');
        $config['total_rows'] = $this->Supplier->count_all();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_supplier_manage_table($this->Supplier->get_all($data['per_page']), $this);
        $data['option'] = $this->load->view('suppliers/manage', $data);
    }

    //check trùng tên
    function checkname($id) {
        $company_name = $this->input->post('company_name');
        $d['company_name'] = $this->Supplier->getname($id);
        foreach ($d['company_name'] as $d2) {
            $d3[] = $d2['company_name'];
        }
        $c2 = $d3;
        $e1 = implode(',', $c2);
        $e2 = explode(',', $e1);

        if (in_array($company_name, $e2)) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    function sorting() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search) {
            $config['total_rows'] = $this->Supplier->search_count_all($search);
            $table_data = $this->Supplier->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'last_name', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        } else {
            $config['total_rows'] = $this->Supplier->count_all();
            $table_data = $this->Supplier->get_all($per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'lifetek_suppliers.person_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        }
        $config['base_url'] = site_url('suppliers/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_supplier_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    //check trùng mã nhà cung cấp
    function check_account($id) {
        $account_number = $this->input->post('account_number');
        $d['account_number'] = $this->Supplier->get_account($id);
        foreach ($d['account_number'] as $d2) {
            $d3[] = $d2['account_number'];
        }
        $c2 = $d3;
        $e1 = implode(',', $c2);
        $e2 = explode(',', $e1);

        if (in_array($account_number, $e2)) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    /* added for excel expert */

    function excel_export() {
        $data = $this->Supplier->get_all()->result_object();
        $this->load->helper('report');
        $rows = array();
        $row = array("Company Name", "First Name", "Last Name", "E-Mail", "Phone Number", "Address 1", "Address 2", "City", "State", "Zip", "Country", "Comments", "Account Number");
        $rows[] = $row;
        foreach ($data as $r) {
            $row = array(
                $r->company_name,
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
                $r->comments,
                $r->account_number
            );
            $rows[] = $row;
        }

        $content = array_to_csv($rows);

        force_download('suppliers_export' . '.csv', $content);
        exit;
    }

    function excel() {
        $data = file_get_contents("import_suppliers.xlsx");
        $name = 'import_suppliers.xlsx';
        force_download($name, $data);
    }

    function excel_import() {
        $this->check_action_permission('add_update');
        $this->load->view("suppliers/excel_import", null);
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
                    $person_data = array(
                        'first_name' => $array_info[0],
                        'last_name' => $array_info[1],
                        'email' => $array_info[3],
                        'phone_number' => $array_info[4],
                        'phone' => $array_info[5],
                        'address_1' => $array_info[6],
                        'birth_date' => $birth_date,
                        //'city'=>$array_info[8],
                        'comments' => $array_info[9],
                    );

                    $suppliers_data = array(
                        'person_id' => $person_data['person_id'],
                        'company_name' => $array_info[2],
                        'account_number' => $array_info[10],
                    );

                    if ($array_info[8] == NULL) {
                        $person_data['city'] = '';
                    } else {
                        $info_city = $this->City->get_city_by_zip_code($array_info[8]);
                        $person_data['city'] = $info_city['id_city'];
                    }


                    if ($this->Supplier->save($person_data, $suppliers_data)) {
                        echo json_encode(array('success' => true, 'message' => 'Import nhà cung cấp thành công'));
                        return;
                        ////                       
                    } else {
                        echo json_encode(array('success' => false, 'message' => 'Import nhà cung cấp bị lỗi ! Bị trùng dữ liệu nhập (trùng tên công ty hoặc trùng số tài khoản , số điện thoại) vào hoặc sai mã thành phố .Vui lòng kiểm tra lại file excel'));
                        return;
                    }
                }
            } else {
                echo json_encode(array('success' => false, 'message' => lang('common_upload_file_not_supported_format')));
                return;
            }
        }

        $this->db->trans_complete();
        echo json_encode(array('success' => false, 'message' => lang('suppliers_duplicate_account_id')));
    }
    
    /*
      Returns supplier table data rows. This will be called with AJAX.
     */

    function search() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Supplier->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'lifetek_suppliers.person_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        $config['base_url'] = site_url('suppliers/search');
        $config['total_rows'] = $this->Supplier->search_count_all($search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_supplier_manage_table_data_rows($search_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    /*
      Gives search suggestions based on what is being searched for
     */

    function suggest() {
        $suggestions = $this->Supplier->get_search_suggestions($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    /*
      Loads the supplier edit form
     */

    function view($supplier_id = -1) {
        $this->check_action_permission('add_update');
        $data['person_info'] = $this->Supplier->get_info_supplier($supplier_id);
		$data['option'] = $this->Customer->get_option1();
		$data['option2'] = $this->Customer->get_option2();
		$this->load->view("suppliers/form", $data);
    }

    /*
      Inserts/updates a supplier
     */

    function save($supplier_id = -1) {
        $birth_date = date('Y-m-d', strtotime($this->input->post('birth_date')));
        $this->check_action_permission('add_update');
        $person_data = array(
            'birth_date' => $birth_date,
            'first_name' => $this->input->post('first_name'),
            'email' => $this->input->post('email'),
            'phone_number' => $this->input->post('phone_number'),
            'address_1' => $this->input->post('address_1'),
            'comments' => $this->input->post('comments')
        );
    	//hung audi 10-4-15
		$choose= $this->input->post('type');
		if($choose== 0){//nv
			$person_data['city']=$this->input->post('city');
		}elseif($choose== 1){//nv & kh
			$person_data['city']=$this->input->post('world');
		}
        
        $supplier_data = array(
            'company_name' => $this->input->post('company_name'),
            'account_number' => $this->input->post('account_number'),
            'account_implicit_sp' => 331
        );
        if ($this->Supplier->save($person_data, $supplier_data, $supplier_id)) {
            if ($this->config->item('mailchimp_api_key')) {
                $this->Person->update_mailchimp_subscriptions($this->input->post('email'), $this->input->post('first_name'), $this->input->post('last_name'), $this->input->post('mailing_lists'));
            }

            //New supplier
            if ($supplier_id == -1) {
                echo json_encode(array('success' => true, 'message' => lang('suppliers_successful_adding') . ' ' .
                    $supplier_data['company_name'], 'person_id' => $supplier_data['person_id']));
            } else { //previous supplier
                echo json_encode(array('success' => true, 'message' => lang('suppliers_successful_updating') . ' ' .
                    $supplier_data['company_name'], 'person_id' => $supplier_id));
            }
        } else {//failure
            echo json_encode(array('success' => false, 'message' => lang('suppliers_error_adding_updating') . ' ' .
                $supplier_data['company_name'], 'person_id' => -1));
        }
    }

    function account_number_exists() {
        if ($this->Supplier->account_number_exists($this->input->post('account_number')))
            echo 'false';
        else
            echo 'true';
    }

    /*
      This deletes suppliers from the suppliers table
     */

    function delete() {
        $this->check_action_permission('delete');
        $suppliers_to_delete = $this->input->post('ids');

        if ($this->Supplier->delete_list($suppliers_to_delete)) {
            echo json_encode(array('success' => true, 'message' => lang('suppliers_successful_deleted') . ' ' .
                count($suppliers_to_delete) . ' ' . lang('suppliers_one_or_multiple')));
        } else {
            echo json_encode(array('success' => false, 'message' => lang('suppliers_cannot_be_deleted')));
        }
    }

    /*
      Gets one row for a supplier manage table. This is called using AJAX to update one row.
     */

    function get_row() {
        $person_id = $this->input->post('row_id');
        $data_row = get_supplier_data_row($this->Supplier->get_info($person_id), $this);
        echo $data_row;
    }

    /*
      get the width for the add/edit form
     */

    function trading($supplier_id) {
        $this->receiving_lib->set_supplier($supplier_id);
        redirect('items');
    }

    function get_form_width() {
        return 710;
    }

    function detail_supplier($person_id) {
        $this->load->model('Receiving');
        $data['supplier_info'] = $this->Supplier->get_info($person_id);
        $data['supplier_id'] = $person_id;
        //hung dq 28-01
        $resultsPerPage = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $data['number_of_items_per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $page_limit = 0;
        //cong no
        $data['order_owe'] = $this->Receiving->get_supplier_owe2($person_id, $page_limit, $resultsPerPage);
        $data['num_rows'] = $this->Receiving->get_total_row($person_id);
        //nhap hang
        $data['receiving_all'] = $this->Receiving->get_all_by_supplier2($person_id, $page_limit, $resultsPerPage);
        $data['num_rows1'] = $this->Receiving->get_total_row2($person_id);
		//thu chi 
        $data['cost_complete'] = $this->Inventory->find_cost_complete_customer8($person_id, $page_limit, $resultsPerPage);
        $data['num_rows3'] = $this->Inventory->get_total_row8($person_id);
        
        foreach ($data['order_owe'] as $key => $val) {
            $data['receiving_tam'][] = $this->Receiving->get_receiving_tam($val['receiving_id']);
            $data['payment_order'][] = $this->Receiving->get_receiving_items($val['receiving_id'])->result_array();
        }
        foreach ($data['receiving_all'] as $key => $val) {
            $data['receiving_tam_all'][] = $this->Receiving->get_receiving_tam($val['receiving_id']);
            $data['payment_order_all'][] = $this->Receiving->get_receiving_items($val['receiving_id'])->result_array();
        }
        $data['info_receiving_item'] = $this->Receiving_order->get_receiving_item();
        $this->load->view('suppliers/detail_supplier_view', $data);
    }

//hung 28-01-15
    //tab cong no
    function load_more($person_id) {
        $resultsPerPage = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $paged = $_POST['page'];

        if ($paged > 0) {
            $page_limit = $resultsPerPage * ($paged - 1);
        } else {
            $page_limit = 0;
        }
        $data['order_owe'] = $this->Receiving->get_supplier_owe2($person_id, $page_limit, $resultsPerPage);
        $data['num_rows'] = $this->Receiving->get_row($person_id, $page_limit, $resultsPerPage);

        foreach ($data['order_owe'] as $key => $val) {
            $data['receiving_tam'][] = $this->Receiving->get_receiving_tam($val['receiving_id']);
            $data['payment_order'][] = $this->Receiving->get_receiving_items($val['receiving_id'])->result_array();
        }

        $data['resultsPerPage'] = $resultsPerPage;
        $data['paged'] = $paged;

        $this->load->view('suppliers/tab_cong_no', $data);
    }

    //tab nhap hang
    function load_more2($person_id) {
        $this->load->model('Receiving');
        $data['supplier_info'] = $this->Supplier->get_info($person_id);
        $resultsPerPage = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $paged = $_POST['page'];

        if ($paged > 0) {
            $page_limit = $resultsPerPage * ($paged - 1);
        } else {
            $page_limit = 0;
        }
        $data['receiving_all'] = $this->Receiving->get_all_by_supplier2($person_id, $page_limit, $resultsPerPage);
        $data['num_rows'] = $this->Receiving->get_row2($person_id, $page_limit, $resultsPerPage);

        foreach ($data['receiving_all'] as $key => $val) {
            $data['receiving_tam_all'][] = $this->Receiving->get_receiving_tam($val['receiving_id']);
            $data['payment_order_all'][] = $this->Receiving->get_receiving_items($val['receiving_id'])->result_array();
        }

        $data['resultsPerPage'] = $resultsPerPage;
        $data['paged'] = $paged;

        $this->load->view('suppliers/tab_nhap_hang', $data);
    }
	//tab thu chi 3
    function load_more3($id_customer) {
        $resultsPerPage = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $paged = $_POST['page'];

        if ($paged > 0) {
            $page_limit = $resultsPerPage * ($paged - 1);
        } else {
            $page_limit = 0;
        }
        $data['num_rows'] = $this->Inventory->get_row8($id_customer, $page_limit, $resultsPerPage);
        $data['cost_complete'] = $this->Inventory->find_cost_complete_customer8($id_customer, $page_limit, $resultsPerPage);
        $data['resultsPerPage'] = $resultsPerPage;
        $data['paged'] = $paged;

        $this->load->view('suppliers/tab_thu_chi', $data);
    }

    function add_receiving_payment() {
        $receiving_id = $this->input->post('receiving_id');
        $consideration_paid = $this->input->post('consideration_paid');
        if ($_SESSION['receiving_payment_paid'] == null) {
            session_start();
            session_register("receiving_payment_paid");
            $_SESSION['receiving_payment_paid'][$receiving_id] = $consideration_paid;
        } else {
            $_SESSION['receiving_payment_paid'][$receiving_id] = $consideration_paid;
        }
        var_dump($_SESSION['receiving_payment_paid']);
    }

    function del_receiving_payment() {
        session_start();
        foreach ($_SESSION['receiving_payment_paid'] as $key => $value) {
            if ($key == $this->input->post('receiving_id')) {
                unset($_SESSION['receiving_payment_paid'][$key]);
            }
        }
        var_dump($_SESSION['receiving_payment_paid']);
//    	unset($_SESSION['sale_payment_paid']);
    }

    public function receiving_check_payment() {
        $supplier_id = $this->input->post('supplier_id');

        $discount_money = $this->input->post('discount_money') ? str_replace(array(','), '', $this->input->post('discount_money')) : 0;
        $discount_money_total = $this->input->post('discount_money') ? str_replace(array(','), '', $this->input->post('discount_money')) : 0;
        $employees = $this->session->userdata('person_id');
        $data['employees'] = $this->Employee->get_info($employees);
        $data['supplier'] = $this->Supplier->get_info($supplier_id);
        /* giang 18/6/2014 */
        session_start();
        if ($_SESSION['receiving_payment_paid'] == null) { // kt neu khong don hang nao duoc chon
            $data['receiving_order'] = $this->Receiving->get_supplier_owe($supplier_id);
            foreach ($data['receiving_order'] as $val) {
                $data_receiving_tam = $this->Receiving->get_receiving_tam($val['receiving_id']);
                $to = 0;
                foreach ($data_receiving_tam as $key => $val1) {
                    $to = $to + $val1['pays_amount'] + $val1['discount_money'];
                }
                $total_price = $this->Receiving->get_total_receiving($val['receiving_id']);
                //$data['liabilities'][$val['receiving_id']] = $total_price['total_price'] - $to;
                $data['liabilities'][] = array(
                    'key'   => (int)$val['receiving_id'],
                    'val'   => (int)($total_price['total_price'] - $to),
                );
                $data['sum_money'] = $this->input->post('sum_money');
            }
        } else {
            $data['sum_money'] = 0;
            foreach ($_SESSION['receiving_payment_paid'] as $key => $val) {
                //$data['liabilities'][$key] = $val;
                $data['liabilities'][] = array(
                    'key'   => (int)$key,
                    'val'   => (int)$val,
                );
                $data['sum_money'] = $data['sum_money'] + $val;
            }
        }
       
        /* giang end */
        /* giang -> */
        $money_cus = str_replace(',', '', $this->input->post('money_cus'));
        $data['money_total'] = $money_cus;        
        $data['receiving_payment_paid_ok'] = array();
        $data['receiving_payment_paid_no'] = array();
        $total_pay = 0;
        $thue_nhap = 0;
            foreach ($items as $line => $item) {
                if (isset($item['item_id'])) {
                    $cur_item_info = $this->Item->get_info($item['item_id']);                    
                    $thue_nhap += $item['quantity']*$item['price']*$cur_item_info->taxes/100;
                }
            }
            if($payment['payment_type']== "CKNH"){
                $tkno = 112;
            }else{
                $tkno = 111;
            }
        foreach ($data['liabilities'] as $key => $value) {
            if($discount_money <= 0){
                $money_cus = $money_cus - $value['val'];
                $discount = 0;
                if($money_cus >= 0){
                    $sus = array('suspended' => 0);
                    $this->Receiving->update($sus, $value['key']);
                    $data_tam = array(
                        'id_receiving' => $value['key'],
                        'pays_type' => "Trả góp",
                        'pays_amount' => $value['val'],
                        'discount_money' => $discount,
                        'employees_id' => $employees,
                        'date_tam' => date('Y-m-d H:i:s'),
                    );
                    $this->Receiving->insert_receiving_tam($data_tam);
                    $cost_comment = "Thanh toán nợ đối tác " . $data['supplier']->company_name;                    
                    $cost_data = array(
                        'supplier_id' => $supplier_id,
                        'name' => 8,
                        'form_cost' => 1,
                        'money' => $value['val'],
                        'date' => date('Y-m-d H:i:s'),
                        'cost_date_ct' => date('Y-m-d'),
                        'comment' => $cost_comment,
                        'deleted' => 0,
                        'id_receiving' => $value['key'],
                        'cost_employees' => $employees,
                        'tk_no'=>131,
                        'tk_co'=> $tkno,
                    );
                    $this->Sale->insert_cost($cost_data);                    
                    $data['receiving_payment_paid_ok'][] = array(
                        'key' => $value['key'],
                        'val' => $value['val'],
                        'money' => $value['val'],
                    );                    
                }else{
                    $money_cus = abs($money_cus);
                    $data['residual'] = $value['val'] - $money_cus;
                    $data_tam = array(
                        'id_receiving' => $value['key'],
                        'pays_type' => "Trả góp",
                        'pays_amount' => $value['val'] - $money_cus,
                        'discount_money' => $discount,
                        'employees_id' => $employees,
                        'date_tam' => date('Y-m-d H:i:s'),
                    );
                    $this->Receiving->insert_receiving_tam($data_tam);
                    $cost_comment = "Thanh toán nợ đối tác " . $data['supplier']->first_name;
                    $cost_data = array(
                        'supplier_id' => $supplier_id,
                        'name' => 8,
                        'form_cost' => 1,
                        'money' => $value['val'] - $money_cus,
                        'date' => date('Y-m-d H:i:s'),
                        'cost_date_ct' => date('Y-m-d'),
                        'comment' => $cost_comment,
                        'deleted' => 0,
                        'id_receiving' => $value['key'],
                        'cost_employees' => $employees,
                        'tk_no'=>131,
                        'tk_co'=> $tkno,
                    );
                    $this->Sale->insert_cost($cost_data);
                    $data['receiving_payment_paid_no'][]= array(
                        'key' => $value['key'],
                        'val' => $value['val'],
                    );
                    break;
                }               
            }else{//Co CK
                if($discount_money >= $value['val']){
                    $discount = $value['val'];
                    $money_cus = $money_cus;
                    $discount_money = $discount_money - $value['val'];
                }else{
                    if(($money_cus + $discount_money)>= $value['val']){
                        $money_cus = $money_cus - $value['val'] + $discount_money;
                    }else{
                        $money_cus = $money_cus - $value['val'];
                    }
                    $discount = $discount_money;
                    $discount_money = 0;                    
                }
                if($money_cus >= 0){
                    $sus = array(
                        'suspended' => 0
                    );
                    $this->Receiving->update($sus, $value['key']);
                    if($discount_money >= $value['val']){
                        $money = 0;
                    }else{
                        $money = $value['val'] - $discount;
                    }
                    $cost_comment = "Thanh toán nợ đối tác " . $data['supplier']->company_name;
                    $cost_data = array(
                        'supplier_id' => $supplier_id,
                        'name' => 8,
                        'form_cost' => 1,
                        'money' => $money,
                        'date' => date('Y-m-d H:i:s'),
                        'cost_date_ct' => date('Y-m-d'),
                        'comment' => $cost_comment,
                        'deleted' => 0,
                        'id_receiving' => $value['key'],
                        'cost_employees' => $employees,
                        'tk_no'=>131,
                        'tk_co'=> $tkno,
                    );
                    $this->Sale->insert_cost($cost_data);
                    $data_tam = array(
                        'id_receiving' => $value['key'],
                        'pays_type' => "Trả góp",
                        'pays_amount' => $money,
                        'discount_money' => $discount,
                        'employees_id' => $employees,
                        'date_tam' => date('Y-m-d H:i:s'),
                    );
                    $this->Receiving->insert_receiving_tam($data_tam);
                    $data['receiving_payment_paid_ok'][] = array(
                        'key' => $value['key'],
                        'val' => $value['val'],
                        'money' => $money,
                    );                    
                }else{
                    $money_cus = abs($money_cus);
                    if($discount_money < $value['val']){
                        $residual = $value['val'] - $money_cus;
                        $pays_amount = $value['val'] - $money_cus - $discount_money;
                    }else{
                        $residual = $value['val'] - $money_cus - $discount_money;
                        $pays_amount = $value['val'] - $money_cus;
                    }
                    $data['residual'] = $residual;
                    $data_tam = array(
                        'id_receiving' => $value['key'],
                        'pays_type' => "Trả góp",
                        'pays_amount' => $pays_amount,
                        'discount_money' => $discount,
                        'employees_id' => $employees,
                        'date_tam' => date('Y-m-d H:i:s'),
                    );
                    $this->Receiving->insert_receiving_tam($data_tam);
                    $cost_comment = "Thanh toán nợ đối tác " . $data['supplier']->company_name;
                    $cost_data = array(
                        'supplier_id' => $supplier_id,
                        'name' => 8,
                        'form_cost' => 1,
                        'money' => $pays_amount,
                        'date' => date('Y-m-d H:i:s'),
                        'cost_date_ct' => date('Y-m-d'),
                        'comment' => $cost_comment,
                        'deleted' => 0,
                        'id_receiving' => $value['key'],
                        'cost_employees' => $employees,
                        'tk_no'=>131,
                        'tk_co'=> $tkno,
                    );
                    $this->Sale->insert_cost($cost_data);
                    $data['receiving_payment_paid_no'][]= array(
                        'key' => $value['key'],
                        'val' => $value['val'],
                    );
                    break;
                }
            }
        } 
        unset($_SESSION['receiving_payment_paid']);
        $data['discount_money_total'] = $discount_money_total;
        /* giang <- */
        $this->load->view('receivings/pay_bill_view', $data);
    }

}

?>