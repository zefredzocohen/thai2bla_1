<?php

require_once ("secure_area.php");

class Imports extends Secure_area {

    function __construct() {
        parent::__construct('Imports');
        $this->load->library('import_lib');
        $this->load->model('Receiving_order');
        $this->load->library('sale_lib');
        $this->load->model('Import');
    }

    function index() {
    
        $this->_reload(array(), false);
    }

    function item_search() {
        $suggestions = $this->Item->get_item_search_suggestions_receiving($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    function supplier_search() {
        $suggestions = $this->Supplier->get_suppliers_search_suggestions($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    function select_supplier() {
        $supplier_id = $this->input->post("supplier");
        $this->import_lib->set_supplier($supplier_id);
        $this->_reload();
    }

    function set_discount_money() {
        $this->import_lib->set_discount_money($this->input->post('discount_money'));
    }

    function set_comment() {
        $this->import_lib->set_comment($this->input->post('comment'));
    }

    function set_currency_id() {
        $this->import_lib->set_currency_id($this->input->post('currency_id'));
    }
    
    function set_rate_value() {
        $this->import_lib->set_rate_value($this->input->post('rate'));
    }
    
    function set_rate() {
//        $recv_id = $this->import_lib->get_rate();
//        if ($recv_id) {
            $this->import_lib->set_rate(str_replace(array(',', '.00'), '', ($this->input->post('rate_currency'))));
            $this->_reload();
//        } else {
//            $this->import_lib->set_rate(str_replace(array(',', '.00'), '', ($this->input->post('rate_currency'))));
//            
//        }
    }

     
    
   function set_payment_type() {
        $this->import_lib->set_payment_type($this->input->post('payment_type'));
    }
    
    function set_inventory() {
        //$this->import_lib->set_inventory($this->input->post('inventory'));
        $recv_id = $this->import_lib->get_recv();
        if ($recv_id) {
            $this->import_lib->set_inventory($this->input->post('inventory'));
            $this->_reload();
        } else {
            $this->import_lib->set_inventory($this->input->post('inventory'));
            $this->delete_all();
        }
    }

    function change_mode() {
        $mode = $this->input->post("mode");
        $this->import_lib->set_mode($mode);
        $this->import_lib->empty_cart();
        $this->_reload();
    }

    function add() {
        $data = array();
        $mode = $this->import_lib->get_mode();
        $item_id_or_number_or_item_kit_or_receipt = $this->input->post("item");
        $quantity = $mode == "receive" ? 1 : -1;

        if ($this->import_lib->is_valid_receipt($item_id_or_number_or_item_kit_or_receipt) && $mode == 'return') {
            $this->import_lib->return_entire_receiving($item_id_or_number_or_item_kit_or_receipt);
        } elseif ($this->import_lib->is_valid_item_kit($item_id_or_number_or_item_kit_or_receipt)) {
            $this->import_lib->add_item_kit($item_id_or_number_or_item_kit_or_receipt);
        } elseif (!$this->import_lib->add_item($item_id_or_number_or_item_kit_or_receipt, $quantity)) {
            $data['error'] = lang('receivings_unable_to_add_item');
        }
        $this->_reload($data);
    }

    function edit_item($item_id) {
        $data = array();

        //$this->form_validation->set_rules('price', 'lang:items_price', 'required|numeric');
        $this->form_validation->set_rules('quantity', 'lang:items_quantity', 'required|integer');
        $this->form_validation->set_rules('discount', 'lang:items_discount', 'required|integer');

        $description = $this->input->post("description");
        $serialnumber = $this->input->post("serialnumber");
        //$price = to_un_currency($this->input->post("price"));
        $price = str_replace(array(',', '.00'), '', $this->input->post('price'));
        $quantity = $this->input->post("quantity");
        $discount = $this->input->post("discount");
        $taxe = $this->input->post("taxe");

        if ($this->form_validation->run() != FALSE) {
            $this->import_lib->edit_item($item_id, $description, $serialnumber, $quantity, $discount, $price, $taxe);
        } else {
            $data['error'] = lang('receivings_error_editing_item');
        }

        $this->_reload($data);
    }

    function delete_item($item_number) {
        $this->import_lib->delete_item($item_number);
        $this->_reload();
    }

    function delete_supplier() {
        $this->import_lib->delete_supplier();
        $this->_reload();
    }

    function set_amount_tendered() {
        $this->import_lib->set_amount_tendered($this->input->post('amount_tendered'));
    }

    function complete() {
        $data['cart_import'] = $this->import_lib->get_cart();
        $data['total'] = $this->import_lib->get_total();
        $data['receipt_title'] = lang('receivings_receipt');
        $data['transaction_time'] = date(get_date_format() . ' ' . get_time_format());
        $supplier_id = $this->import_lib->get_supplier();
        $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
        $comment = $this->input->post('comment');

        $emp_info = $this->Employee->get_info($employee_id);
        $data['payment_type'] = $this->input->post('payment_type');
        
        $currency_id = $this->import_lib->get_currency_id();
        $status_currency = 1;
        $inventory_id = intval($this->input->post('inventory'));

        $data['amount_tendered2'] = $this->import_lib->get_amount_tendered();
        $data['amount_tendered'] = str_replace(array(',', '.'), '', $this->input->post('amount_tendered'));
        $data['discount_money'] = $this->import_lib->get_discount_money();

        if ($data['amount_tendered']) {
            $data['amount_tendered'] = str_replace(array(',', '.'), '', $this->input->post('amount_tendered'));
            $data['amount_change'] = to_currency($data['amount_tendered'] - round($data['total'], 2));
        }
        $data['employee'] = $emp_info->first_name . ' ' . $emp_info->last_name;

        if ($supplier_id != -1) {
            $suppl_info = $this->Supplier->get_info($supplier_id);
            $data['supplier'] = $suppl_info->first_name . ' ' . $suppl_info->last_name;
        }
        //SAVE receiving to database
        if ($data['total'] < $data['amount_tendered']) {
            $data['amount_tendered1'] = $data['total'];
            $data['receiving_id'] = 'RECV ' . $this->Import->save($data['cart_import'], $supplier_id, $employee_id, $comment, $data['payment_type'], $inventory_id, $data['amount_tendered1'], 0, $currency_id, $status_currency);
        } else if ($data['total'] > $data['amount_tendered']) {          //chưa ttoan hết tiền 
            if ($supplier_id == -1) {
                echo "<script>alert('Bạn cần chọn nhà cung cấp!');window.location='" . base_url() . "imports';</script>";
            } else {
                $data['receiving_id'] = 'RECV ' . $this->Import->save($data['cart_import'], $supplier_id, $employee_id, $comment, $data['payment_type'], $inventory_id, $data['amount_tendered'], 1, $currency_id, $status_currency);
            }
        } else {
            $data['receiving_id'] = 'RECV ' . $this->Import->save($data['cart_import'], $supplier_id, $employee_id, $comment, $data['payment_type'], $inventory_id, $data['amount_tendered'], 0, $currency_id, $status_currency);
        }

        if ($data['receiving_id'] == 'RECV -1') {
            $data['error_message'] = lang('receivings_transaction_failed');
        }
        $this->load->view("imports/receipt1", $data);
        $this->import_lib->clear_all();
    }

      function suspend() {
        $supplier_id = $this->import_lib->get_supplier();
        $mode = $this->import_lib->get_mode();
        $data['mode'] = $mode;
        $rev_id = $this->import_lib->get_recv();
       
        if ($supplier_id == -1) {
            echo "<script>alert('Bạn cần chọn nhà cung cấp!');window.location='" . base_url() . "imports';</script>";
        } else {
            $data['cart_import'] = $this->import_lib->get_cart();
            $data['total'] = $this->import_lib->get_total();
            $data['receipt_title'] = lang('imports_receipt');
            $data['transaction_time'] = date(get_date_format() . ' ' . get_time_format());

            $currency_id = $this->import_lib->get_currency_id();
            $status_currency = 1;
            
            $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
            $emp_info = $this->Employee->get_info($employee_id);

            $comment = $this->import_lib->get_comment();
            $data['comment'] = $comment;
            $data['payment_type'] = $this->import_lib->get_payment_type();
            $inventory_id = $this->import_lib->get_inventory();

            $data['amount_tendered1'] = str_replace(",", "", $this->input->post('amount_tendered'));
            $data['amount_tendered'] = (str_replace(',', '.', str_replace(',', '', $this->import_lib->get_amount_tendered())));

            $data['employee'] = $emp_info->first_name . ' ' . $emp_info->last_name;
            $supplier_id = $this->import_lib->get_supplier();
            $data['company_name'] = $this->Supplier->get_info($supplier_id)->company_name;
            if ($supplier_id != -1) {
                $suppl_info = $this->Supplier->get_info($supplier_id);
                $data['supplier'] = $suppl_info->first_name . ' ' . $suppl_info->last_name;
            }

            //SAVE receiving to database
            $suspended = (($data['total'] - $data['amount_tendered1']) == 0) ? 0 : 1;
            $data['receiving_id'] = 'RECV ' . $this->Import->save($data['cart_import'], $supplier_id, $employee_id, $comment, $data['payment_type'], $inventory_id, $data['amount_tendered'], $suspended, $rev_id, $mode, $currency_id, $status_currency);

            if ($data['receiving_id'] == 'RECV -1') {
                $data['error_message'] = lang('receivings_transaction_failed');
            }
            if ($this->config->item('print_excel') == 'print_a5') {
                
                $this->load->view("imports/receipt_liabilities_a5", $data);
                $this->import_lib->clear_all();
            } elseif ($this->config->item('print_excel') == 'print') {
                $this->load->view("imports/receipt_liabilities", $data);
                $this->import_lib->clear_all();
            } else {
                
                $this->load->view("imports/receipt_liabilities", $data);
                $this->import_lib->clear_all();
            }
        }
    }

    function add_payment() {

        $data = array();
        //$this->form_validation->set_rules('amount_tendered', 'lang:sales_amount_tendered', 'required');
        $this->form_validation->set_rules('amount_tendered', 'lang:sales_amount_tendered', '');
        if ($this->form_validation->run() == FALSE) {
            if ($this->input->post('payment_type') == lang('sales_giftcard'))
                $data['error'] = lang('sales_must_enter_numeric_giftcard');
            else
                $data['error'] = lang('sales_must_enter_numeric');
            $this->_reload($data);
            return;
        }
        $payment_type = $this->input->post('payment_type');
        $payment_amount = str_replace(array(',', '.'), '', $this->input->post('amount_tendered'));
        //$discount_money = str_replace(array(',', '.'), '', $this->input->post('discount_money'));
        if (!$this->import_lib->add_payment($payment_type, $payment_amount)) {
            $data['error'] = lang('sales_unable_to_add_payment');
        }
        $this->_reload($data);
    }

    function suspended() {
        $data = array();
        $data['suspended_receivings'] = $this->Import->get_all_suspended()->result_array();
        $this->load->view('imports/suspended', $data);
    }

    function receipt($receiving_id) {

        $receiving_info = $this->Import->get_info($receiving_id)->row_array();
        $this->import_lib->copy_entire_receiving($receiving_id);
        $data['cart_import'] = $this->import_lib->get_cart();
        $data['total'] = $this->import_lib->get_total();

        $data['amount_tendered'] = $this->Import->get_info2($receiving_id)->row()->payment_types; //$receiving_info['payment_type'];
        $data['receipt_title'] = 'HÓA ĐƠN NHẬP HÀNG';
        $data['transaction_time'] = date(get_date_format() . ' ' . get_time_format(), strtotime($receiving_info['receiving_time']));

        $supplier_id = $this->import_lib->get_supplier();
        $emp_info = $this->Employee->get_info($receiving_info['employee_id']);
        $data['payment_type'] = $receiving_info['payment_type'];

        $data['employee'] = $emp_info->first_name . ' ' . $emp_info->last_name;

        if ($supplier_id != -1) {
            $suppl_info = $this->Supplier->get_info($supplier_id);
            $data['supplier'] = $suppl_info->first_name . ' ' . $suppl_info->last_name;
        }
        $data['receiving_id'] = 'RECV ' . $receiving_id;
        $this->load->view("imports/receipt", $data);
        //require_once APPPATH . "/third_party/Classes/export_receivings.php";
        $this->import_lib->clear_all();
    }

    function receipt123($receiving_id) {
        $receiving_info = $this->Import->get_info($receiving_id)->row_array();
        $this->import_lib->copy_entire_receiving($receiving_id);
        $data['cart_import'] = $this->import_lib->get_cart();
        $data['total'] = $this->import_lib->get_total();
        $data['receipt_title'] = lang('receivings_receipt');
        $data['transaction_time'] = date(get_date_format() . ' ' . get_time_format(), strtotime($receiving_info['receiving_time']));
        $supplier_id = $this->import_lib->get_supplier();
        $emp_info = $this->Employee->get_info($receiving_info['employee_id']);
        $data['payment_type'] = $receiving_info['payment_type'];

        $data['employee'] = $emp_info->first_name . ' ' . $emp_info->last_name;

        if ($supplier_id != -1) {
            $supplier_info = $this->Supplier->get_info($supplier_id);
            $data['supplier'] = $supplier_info->first_name . ' ' . $supplier_info->last_name;
        }
        $data['receiving_id'] = 'RECV ' . $receiving_id;
        $this->load->view("imports/receipt", $data);
        //require_once APPPATH . "/third_party/Classes/export_receivings.php";
        $this->import_lib->clear_all();
    }

    function edit($receiving_id) {
        $data = array();

        $data['suppliers'] = array('' => 'No Supplier');
        foreach ($this->Supplier->get_all()->result() as $supplier) {
            $data['suppliers'][$supplier->person_id] = $supplier->company_name . ' (' . $supplier->first_name . ' ' . $supplier->last_name . ')';
        }

        $data['employees'] = array();
        foreach ($this->Employee->get_all_receiving()->result() as $employee) {
            $data['employees'][$employee->person_id] = $employee->first_name . ' ' . $employee->last_name;
        }

        $data['receiving_info'] = $this->Receiving->get_info($receiving_id)->row_array();
        $this->load->view('imports/edit', $data);
    }

    function delete($receiving_id) {
        $data = array();

        if ($this->Import->delete($receiving_id)) {
            $data['success'] = true;
        } else {
            $data['success'] = false;
        }

        $this->load->view('imports/delete', $data);
    }

    function undelete($receiving_id) {
        $data = array();

        if ($this->Import->undelete($receiving_id)) {
            $data['success'] = true;
        } else {
            $data['success'] = false;
        }

        $this->load->view('imports/undelete', $data);
    }

    function save($receiving_id) {
        $receiving_data = array(
            'receiving_time' => date('Y-m-d', strtotime($this->input->post('date'))),
            'supplier_id' => $this->input->post('supplier_id') ? $this->input->post('supplier_id') : null,
            'employee_id' => $this->input->post('employee_id'),
            'comment' => $this->input->post('comment')
        );
        if ($this->Import->update($receiving_data, $receiving_id)) {
            echo json_encode(array('success' => true, 'message' => lang('receivings_successfully_updated')));
        } else {
            echo json_encode(array('success' => false, 'message' => lang('receivings_unsuccessfully_updated')));
        }
    }

    function set_store() {
        $recv_id = $this->import_lib->get_recv();
        if ($recv_id) {
            $this->import_lib->set_inventory($this->input->post('inventory'));
            $this->_reload();
        } else {
            $this->import_lib->set_inventory($this->input->post('inventory'));
            $this->delete_all();
        }
    }

    function _reload($data = array(), $is_ajax = true) {
        $this->load->model('create_invetory', 'Create_inventory');
        $person_info = $this->Employee->get_logged_in_employee_info();
        $data['cart_import'] = $this->import_lib->get_cart();
        $data['modes'] = array('receive' => lang('receivings_receiving'), 'return' => lang('receivings_return'));
        $data['mode'] = $this->import_lib->get_mode();
        $data['total'] = $this->import_lib->get_total();
        $data['amount_tendered'] = $this->import_lib->get_amount_tendered();

        $data['items_module_allowed'] = $this->Employee->has_module_permission('items', $person_info->person_id);
        $data['payment_options'] = array(
            lang('sales_cash') => lang('sales_cash'),
            lang('sales_credit') => lang('sales_credit')
        );
        //$data['inventory'] = $this->Create_invetory->get_inventory_view2();
        //load chọn kho 
        $data['stores'] = $this->Create_invetory->get_all()->result_array();
        $data['store_active'] = $this->import_lib->get_inventory();
       
        $data['active_currency'] = $this->import_lib->get_currency_id();
        //$data['currency'] = $this->Import->getCurrency(); 
        foreach ($this->Appconfig->get_additional_payment_types() as $additional_payment_type) {
            $data['payment_options'][$additional_payment_type] = $additional_payment_type;
        }
        $supplier_id = $this->import_lib->get_supplier();
        if ($supplier_id != -1) {
            $info = $this->Supplier->get_info($supplier_id);
            $data['supplier'] = $info->company_name . ' (' . $info->first_name . ' ' . $info->last_name . ')';
            $data['supplier_id'] = $supplier_id;
        }
        if ($is_ajax) {
            $this->load->view("imports/receiving", $data);
        } else {
            $this->load->view("imports/receiving_initial", $data);
        }
    }

    function delete_all() {
        $this->import_lib->empty_cart();
        $this->_reload();
    }

    function cancel_receiving() {
        $this->import_lib->clear_all();
        $this->_reload();
    }

    function delete_suspended_receiving() {
        $suspended_receiving_id = $this->input->post('suspended_receiving_id');
        if ($suspended_receiving_id) {
            $this->import_lib->delete_suspended_receiving_id();
            $this->Receiving->delete($suspended_receiving_id);
            $this->load->model('Cost');
            $this->Cost->delete_receiving_id($suspended_receiving_id);
        }
        $this->_reload(array('success' => lang('sales_successfully_deleted')), false);
    }

    //hoa đơn nhập hàng

    function switch_recv($recv_ids) {
        $items = $this->Import->get_receiving_items($recv_ids)->result();

        $this->import_lib->copy_entire_receiving2($recv_ids);

        foreach ($items as $item) {

            $item_id_or_number_or_item_kit_or_receipt = $item->item_id;

            $price = $this->Import->get_receiving_items3($recv_ids, $item->item_id)->item_unit_price;

            $quantity = $this->Import->get_receiving_items3($recv_ids, $item->item_id)->quantity_purchased;
            $discount = $this->Import->get_receiving_items3($recv_ids, $item->item_id)->discount_percent;
            $this->import_lib->add_item($item_id_or_number_or_item_kit_or_receipt, $quantity, $discount, $price);
        }
        $this->import_lib->set_recv($recv_ids);

        //$this->import_lib->clear_all();

        $info_receiving = $this->Import->get_info($recv_ids)->row_array();
        // die('1');
        $this->import_lib->set_inventory($info_receiving['inventory_id']);

        redirect('receivings');
    }

    function receiving_order() {
        $this->check_action_permission('receiving_order');
        $config['base_url'] = site_url('receivings/receiving_order_sorting');
        $config['total_rows'] = $this->Receiving_order->count_all();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_receiving_orders_manage_table($this->Receiving_order->get_all($data['per_page']), $this);
        $this->load->view('receiving_orders/manage', $data);
    }

    function receiving_order_sorting() {
        $this->check_action_permission('receiving_order');
        $start_date1 = $this->input->post('start_date');
        $end_date1 = $this->input->post('end_date');
        $tam = $end_date1;
        $tam .='23:59:59';
        $start_date = date('Y-m-d H:i:s', strtotime($start_date1));
        $end_date = date('Y-m-d H:i:s', strtotime($tam));

        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search || $start_date || $end_date) {
            $config['total_rows'] = $this->Receiving_order->search_count_all($start_date, $end_date, $search);
            $table_data = $this->Receiving_order->search(
                    $start_date, $end_date, $search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'receiving_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
            );
        } else {
            $config['total_rows'] = $this->Receiving_order->count_all();
            $table_data = $this->Receiving_order->get_all(
                    $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'receiving_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
            );
        }
        $config['base_url'] = site_url('receivings/receiving_order_sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_receiving_orders_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function receiving_order_suggest() {
        $suggestions = $this->Receiving_order->get_search_suggestions($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    function receiving_order_search() {
        $this->check_action_permission('receiving_order');
        $start_date1 = $this->input->post('start_date');
        $end_date1 = $this->input->post('end_date');
        $tam = $end_date1;
        $tam .='23:59:59';
        $start_date = date('Y-m-d H:i:s', strtotime($start_date1));
        $end_date = date('Y-m-d H:i:s', strtotime($tam));

        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Receiving_order->search(
                $start_date, $end_date, $search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'receiving_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
        );
        $config['base_url'] = site_url('receivings/receiving_order_search');
        $config['total_rows'] = $this->Receiving_order->search_count_all($start_date, $end_date, $search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_receiving_orders_manage_table_data_rows($search_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function approve($receiving_id = -1) {
        $data['receiving_id'] = $receiving_id;
        $data['info_receiving'] = $this->Receiving_order->get_info_receving($receiving_id);
        $data['info_receiving_item'] = $this->Receiving_order->get_receiving_item();
        $this->load->view('receiving_orders/approve', $data);
    }

    public function save_approve($receiving_id) {
        $data = array('status' => 1);
        $this->Receiving_order->update_receiving_status($data, $receiving_id);
        echo json_encode(array('success' => true, 'message' => 'Xác nhận hóa đơn nhập hàng thành công - ' . $receiving_id));
    }

    public function delete_receiving() {
        $this->check_action_permission('delete_receiving');
        $ids = $this->input->post('ids');
        foreach ($ids as $id) {
            $data_delete = array('deleted' => 1);
            $this->Receiving_order->update_receiving_status($data_delete, $id);
        }
        echo json_encode(array('success' => true, 'message' => 'Bạn đã xóa thành công hóa đơn - ' . $id));
    }
  
   public function load_rate()  
   {  
      echo $id = $this->input->post('id',TRUE);  
      $rate['data_rate'] = $this->Create_invetory->getCurrency_By_Rate($id);  
      $output = "";  
      $get_rate = $this->import_lib->get_rate_value();
      foreach ($rate['data_rate'] as $row)  
      {  
        if($get_rate == $row->id){
           $output .= "<option value='".number_format($row->currency_rate,2)."' selected='selected'>".number_format($row->currency_rate,2)."</option>";  
        }else{
            $output .= "<option value='".number_format($row->currency_rate,2)."'>".number_format($row->currency_rate,2)."</option>"; 
        }
         
      }  
      echo $output;  
      
     
   } 
   
}

?>