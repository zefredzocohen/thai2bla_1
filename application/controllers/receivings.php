<?php

require_once ("secure_area.php");

class Receivings extends Secure_area {

    function __construct() {
        parent::__construct('receivings');
        $this->load->library('receiving_lib');
        $this->load->model('Receiving_order');
        $this->load->library('sale_lib');
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
        $this->receiving_lib->set_supplier($supplier_id);
        $this->_reload();
    }

    function set_discount_money() {
        $this->receiving_lib->set_discount_money($this->input->post('discount_money'));
    }

    function set_comment() {
        $this->receiving_lib->set_comment($this->input->post('comment'));
    }

    function set_payment_type() {
        $this->receiving_lib->set_payment_type($this->input->post('payment_type'));
    }

    function set_symbol_order() {
        $this->receiving_lib->set_symbol_order($this->input->post('symbol_order'));
    }
    
    function set_number_order() {
        $this->receiving_lib->set_number_order($this->input->post('number_order'));
    }
    
    function set_number_taxes() {
        $this->receiving_lib->set_number_taxes($this->input->post('number_taxes'));
    }
    
    function set_other_cost() {
        $this->receiving_lib->set_other_cost($this->input->post('other_cost'));
        $this->_reload();
    }
    
    function set_inventory() {
        //$this->receiving_lib->set_inventory($this->input->post('inventory'));
        $recv_id = $this->receiving_lib->get_recv();
        if ($recv_id) {
            $this->receiving_lib->set_inventory($this->input->post('inventory'));
            $this->_reload();
        } else {
            $this->receiving_lib->set_inventory($this->input->post('inventory'));
            $this->delete_all();
        }
    }

    
   
    
    function change_mode() {
        $mode = $this->input->post("mode");
        $this->receiving_lib->set_mode($mode);
        $this->receiving_lib->empty_cart();
        $this->_reload();
    }

    function add() {
        $data = array();
        $mode = $this->receiving_lib->get_mode();
        $item_id_or_number_or_item_kit_or_receipt = $this->input->post("item");
        $quantity = $mode == "receive" ? 1 : -1;

        if ($this->receiving_lib->is_valid_receipt($item_id_or_number_or_item_kit_or_receipt) && $mode == 'return') {
            $this->receiving_lib->return_entire_receiving($item_id_or_number_or_item_kit_or_receipt);
        } elseif ($this->receiving_lib->is_valid_item_kit($item_id_or_number_or_item_kit_or_receipt)) {
            $this->receiving_lib->add_item_kit($item_id_or_number_or_item_kit_or_receipt);
        } elseif (!$this->receiving_lib->add_item($item_id_or_number_or_item_kit_or_receipt, $quantity)) {
            $data['error'] = lang('receivings_unable_to_add_item');
        }
        $this->_reload($data);
    }

    function edit_item($item_id) {
        $data = array();
        $this->form_validation->set_rules('quantity', 'lang:items_quantity', 'required|double');
        $this->form_validation->set_rules('discount', 'lang:items_discount', 'required|integer');
        $description = $this->input->post("description");
        $serialnumber = $this->input->post("serialnumber");
        $price = str_replace(array(',', '.00'), '', $this->input->post('price'));
        $quantity = $this->input->post("quantity");
        $discount = $this->input->post("discount");
        $taxes = $this->input->post("taxes");
        
        if ($this->form_validation->run() != FALSE) {
            $this->receiving_lib->edit_item($item_id, $description, $serialnumber, $quantity, $discount, $price, $taxes);
        } else {
            $data['error'] = lang('receivings_error_editing_item');
        }
        $this->_reload($data);
    }

    function delete_item($item_number) {
        $this->receiving_lib->delete_item($item_number);
        $this->_reload();
    }

    function delete_supplier() {
        $this->receiving_lib->delete_supplier();
        $this->_reload();
    }

    function set_amount_tendered() {
        $this->receiving_lib->set_amount_tendered($this->input->post('amount_tendered'));
    }

    function complete() {
        $data['cart'] = $this->receiving_lib->get_cart();
        $data['total'] = $this->receiving_lib->get_total();
        $data['receipt_title'] = lang('receivings_receipt');
        $data['transaction_time'] = $this->receiving_lib->get_date_debt();
        $supplier_id = $this->receiving_lib->get_supplier();
        $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
        $comment = $this->input->post('comment');

        $emp_info = $this->Employee->get_info($employee_id);
        $data['payment_type'] = $this->input->post('payment_type');
       // $inventory_id = intval($this->input->post('inventory'));
         $inventory_id = $this->receiving_lib->get_inventory();
        $data['amount_tendered2'] = $this->receiving_lib->get_amount_tendered();
        $data['amount_tendered'] = str_replace(array(',', '.'), '', $this->input->post('amount_tendered'));
        $data['discount_money'] = $this->receiving_lib->get_discount_money();
        $data['total_order'] = $this->receiving_lib->get_total_order_of_item();
        $data['total_taxes'] = $this->receiving_lib->get_total_taxes(); 
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
            $data['receiving_id'] = 'RECV ' . $this->Receiving->save($data['cart'], $supplier_id, $employee_id, $comment, $data['payment_type'], $inventory_id, $data['amount_tendered1'], 0);
        }else if ($data['total'] > $data['amount_tendered']) {          //chưa ttoan hết tiền 
            if ($supplier_id == -1) {
                echo "<script>alert('Bạn cần chọn nhà cung cấp!');window.location='" . base_url() . "receivings';</script>";
            } else {
                $data['receiving_id'] = 'RECV ' . $this->Receiving->save($data['cart'], $supplier_id, $employee_id, $comment, $data['payment_type'], $inventory_id, $data['amount_tendered'], 1);
            }
        } else {
            $data['receiving_id'] = 'RECV ' . $this->Receiving->save($data['cart'], $supplier_id, $employee_id, $comment, $data['payment_type'], $inventory_id, $data['amount_tendered'], 0);
        }

        if ($data['receiving_id'] == 'RECV -1') {
            $data['error_message'] = lang('receivings_transaction_failed');
        }
        $this->load->view("receivings/receipt1", $data);
        $this->receiving_lib->clear_all();
    }

   function suspend() {
        $supplier_id = $this->receiving_lib->get_supplier();
        //Nov 3
        $mode = $this->receiving_lib->get_mode();
        $date_debt = $this->receiving_lib->get_date_debt();
        $date_debt1 = $this->receiving_lib->get_date_debt1();
        $bank_account = $this->receiving_lib->get_bank_account();
        $data['payment_type'] = $this->receiving_lib->get_payment_type();
        
        $data['mode'] = $mode;
        $rev_id = $this->receiving_lib->get_recv();
        if ($date_debt == null) {
            echo "<script>alert('Bạn cần chọn ngày hoạch toán');
                window.location = '" . base_url() . "receivings';</script>";
        } elseif ($supplier_id == -1) {
            echo "<script>alert('Bạn cần chọn nhà cung cấp!');window.location='" . base_url() . "receivings';</script>";
        } else {
            $data['cart'] = $this->receiving_lib->get_cart();
            $data['total'] = $this->receiving_lib->get_total();
            $data['receipt_title'] = lang('receivings_receipt');
            $data['transaction_time'] = $this->receiving_lib->get_date_debt();

            $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
            $emp_info = $this->Employee->get_info($employee_id);
            $comment = $this->receiving_lib->get_comment();
            $data['comment'] = $comment;


            $inventory_id = $this->receiving_lib->get_inventory();
//            $inventory_id = 26;
            $data['amount_tendered1'] = str_replace(",", "", $this->input->post('amount_tendered'));
            $data['amount_tendered'] = (str_replace(',', '.', str_replace(',', '', $this->receiving_lib->get_amount_tendered())));

            $symbol_order = $this->receiving_lib->get_symbol_order();
            $number_order = $this->receiving_lib->get_number_order();
            $number_taxes = $this->receiving_lib->get_number_taxes();
            $other_cost = $this->receiving_lib->get_other_cost();
            $load_account = $this->receiving_lib->get_load_account();
            
            $data['employee'] = $emp_info->first_name . ' ' . $emp_info->last_name;
            $supplier_id = $this->receiving_lib->get_supplier();
            $data['company_name'] = $this->Supplier->get_info($supplier_id)->company_name;
            if ($supplier_id != -1) {
                $suppl_info = $this->Supplier->get_info($supplier_id);
                $data['supplier'] = $suppl_info->first_name . ' ' . $suppl_info->last_name;
            }
            $data['total_order'] = $this->receiving_lib->get_total_order_of_item() + $other_cost + $this->receiving_lib->get_total_taxes();
            $data['total_taxes'] = $this->receiving_lib->get_total_taxes();    
            
            $no_1331 = 1331;
            $money_1331 = $this->receiving_lib->get_total_taxes();
            $co_331 = 331;
            $money_331 = $this->receiving_lib->get_total() + $this->receiving_lib->get_other_cost();
            
            //SAVE receiving to database
            $suspended = (($data['total'] - $data['amount_tendered1']) == 0) ? 0 : 1;
            $data['receiving_id'] = 'RECV ' . $this->Receiving->save($data['cart'], $supplier_id, $employee_id, $comment, $data['payment_type'], $inventory_id, $data['amount_tendered'], $suspended, $rev_id, $mode, $date_debt, $bank_account, $data['total_order'], $symbol_order, $number_order, $number_taxes, $date_debt1, $other_cost, $no_1331, $money_1331, $co_331, $money_331, $load_account);

            if ($data['receiving_id'] == 'RECV -1') {
                $data['error_message'] = lang('receivings_transaction_failed');
            }
            if ($this->config->item('print_excel') == 'print_a5') {
                $this->load->view("receivings/receipt_liabilities_a5", $data);
                $this->receiving_lib->clear_all();
            } elseif ($this->config->item('print_excel') == 'print') {
                $this->load->view("receivings/receipt_liabilities", $data);
                $this->receiving_lib->clear_all();
            } else {
                $this->load->view("receivings/receipt_liabilities", $data);
                $this->receiving_lib->clear_all();
            }
        }
    }
    function audi(){
        $this->Receiving->get_info_receiving_tam_max();
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
        if (!$this->receiving_lib->add_payment($payment_type, $payment_amount)) {
            $data['error'] = lang('sales_unable_to_add_payment');
        }
        $this->_reload($data);
    }

    function suspended() {
        $data = array();
        $data['suspended_receivings'] = $this->Receiving->get_all_suspended()->result_array();
        $this->load->view('receivings/suspended', $data);
    }

    function receipt($receiving_id) {

        $receiving_info = $this->Receiving->get_info($receiving_id)->row_array();
        $this->receiving_lib->copy_entire_receiving($receiving_id);
        $data['cart'] = $this->receiving_lib->get_cart();
        $data['total'] = $this->receiving_lib->get_total();

        $data['amount_tendered'] = $this->Receiving->get_info2($receiving_id)->row()->payment_types; //$receiving_info['payment_type'];
        $data['receipt_title'] = 'HÓA ĐƠN NHẬP HÀNG';
        $data['transaction_time'] = date(get_date_format() . ' ' . get_time_format(), strtotime($receiving_info['receiving_time']));

        $supplier_id = $this->receiving_lib->get_supplier();
        $emp_info = $this->Employee->get_info($receiving_info['employee_id']);
        $data['payment_type'] = $receiving_info['payment_type'];

        $data['employee'] = $emp_info->first_name . ' ' . $emp_info->last_name;

        if ($supplier_id != -1) {
            $suppl_info = $this->Supplier->get_info($supplier_id);
            $data['supplier'] = $suppl_info->first_name . ' ' . $suppl_info->last_name;
        }
        $data['receiving_id'] = $receiving_id;
        $this->load->view("receivings/receipt", $data);
        $this->receiving_lib->clear_all();
    }

    function receipt123($receiving_id) {
        $receiving_info = $this->Receiving->get_info($receiving_id)->row_array();
        $this->receiving_lib->copy_entire_receiving($receiving_id);
        $data['cart'] = $this->receiving_lib->get_cart();
        $data['total'] = $this->receiving_lib->get_total();
        $data['receipt_title'] = lang('receivings_receipt');
        $data['transaction_time'] = date(get_date_format() . ' ' . get_time_format(), strtotime($receiving_info['receiving_time']));
        $supplier_id = $this->receiving_lib->get_supplier();
        $emp_info = $this->Employee->get_info($receiving_info['employee_id']);
        $data['payment_type'] = $receiving_info['payment_type'];

        $data['employee'] = $emp_info->first_name . ' ' . $emp_info->last_name;

        if ($supplier_id != -1) {
            $supplier_info = $this->Supplier->get_info($supplier_id);
            $data['supplier'] = $supplier_info->first_name . ' ' . $supplier_info->last_name;
        }
        $data['receiving_id'] = 'RECV ' . $receiving_id;
        $this->load->view("receivings/receipt", $data);
        //require_once APPPATH . "/third_party/Classes/export_receivings.php";
        $this->receiving_lib->clear_all();
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
        $this->load->view('receivings/edit', $data);
    }

    function delete($receiving_id) {
        $data = array();

        if ($this->Receiving->delete($receiving_id)) {
            $data['success'] = true;
        } else {
            $data['success'] = false;
        }

        $this->load->view('receivings/delete', $data);
    }

    function undelete($receiving_id) {
        $data = array();

        if ($this->Receiving->undelete($receiving_id)) {
            $data['success'] = true;
        } else {
            $data['success'] = false;
        }

        $this->load->view('receivings/undelete', $data);
    }

    function save($receiving_id) {
        $receiving_data = array(
            'receiving_time' => date('Y-m-d', strtotime($this->input->post('date'))),
            'supplier_id' => $this->input->post('supplier_id') ? $this->input->post('supplier_id') : null,
            'employee_id' => $this->input->post('employee_id'),
            'comment' => $this->input->post('comment')
        );
        if ($this->Receiving->update($receiving_data, $receiving_id)) {
            echo json_encode(array('success' => true, 'message' => lang('receivings_successfully_updated')));
        } else {
            echo json_encode(array('success' => false, 'message' => lang('receivings_unsuccessfully_updated')));
        }
    }

    function set_store() {
        $recv_id = $this->receiving_lib->get_recv();
        if ($recv_id) {
            $this->receiving_lib->set_inventory($this->input->post('inventory'));
            $this->_reload();
        } else {
            $this->receiving_lib->set_inventory($this->input->post('inventory'));
            $this->delete_all();
        }
    }

    function _reload($data = array(), $is_ajax = true) {
        $this->load->model('create_invetory', 'Create_inventory');
        $person_info = $this->Employee->get_logged_in_employee_info();
        $data['cart'] = $this->receiving_lib->get_cart();
        $data['modes'] = array('receive' => lang('receivings_receiving'), 'return' => lang('receivings_return'));
        $data['mode'] = $this->receiving_lib->get_mode();
        $data['total'] = $this->receiving_lib->get_total();
        $data['amount_tendered'] = $this->receiving_lib->get_amount_tendered();

        $data['items_module_allowed'] = $this->Employee->has_module_permission('items', $person_info->person_id);
        $data['payment_options'] = array(
            '' => '-- Chọn --',
            lang('sales_cash') => lang('sales_cash'),
            lang('sales_credit') => lang('sales_credit')
        );
        //load chọn kho 
        $data['stores'] = $this->Create_invetory->get_all()->result_array();
        $data['store_active'] = $this->receiving_lib->get_inventory();
        $data['total_order'] = $this->receiving_lib->get_total_order_of_item();
        $data['total_taxes'] = $this->receiving_lib->get_total_taxes();
        foreach ($this->Appconfig->get_additional_payment_types() as $additional_payment_type) {
            $data['payment_options'][$additional_payment_type] = $additional_payment_type;
        }
        $supplier_id = $this->receiving_lib->get_supplier();

//        $load_account = $this->receiving_lib->get_load_account();
        
        $data['date_debt'] = $this->receiving_lib->get_date_debt();
        $data['date_debt1'] = $this->receiving_lib->get_date_debt1();
       
        $data['symbol_order'] = $this->receiving_lib->get_symbol_order();
        $data['number_order'] = $this->receiving_lib->get_number_order();
        $data['number_taxes'] = $this->receiving_lib->get_number_taxes();
        $data['other_cost'] = $this->receiving_lib->get_other_cost();
        
        $data['comment'] = $this->receiving_lib->get_comment();
        
        $data['pays_type'] = $this->receiving_lib->get_payment_type();
        $data['bank_account'] = $this->receiving_lib->get_bank_account();
        
        $bank_list = array('' => '-- Chọn tài khoản ngân hàng --');
        foreach ($this->Tkdu->get_bank_list()->result() as $bank){
            $bank_list[$bank->id] = $bank->id.' - '.$bank->name;
        }
        $data['bank_list'] = $bank_list;
        
        
        if ($supplier_id != -1) {
            $info = $this->Supplier->get_info($supplier_id);
            $data['supplier'] = $info->company_name . ' (' . $info->first_name . ' ' . $info->last_name . ')';
            $data['supplier_id'] = $supplier_id;
        }
        if ($is_ajax) {
            $this->load->view("receivings/receiving", $data);
        } else {
            $this->load->view("receivings/receiving_initial", $data);
        }
    }

    function delete_all() {
        $this->receiving_lib->empty_cart();
        $this->_reload();
    }

    function cancel_receiving() {
        $this->receiving_lib->clear_all();
        $this->_reload();
    }

    function delete_suspended_receiving() {
        $suspended_receiving_id = $this->input->post('suspended_receiving_id');
        if ($suspended_receiving_id) {
            $this->receiving_lib->delete_suspended_receiving_id();
            $this->Receiving->delete($suspended_receiving_id);
            $this->load->model('Cost');
            $this->Cost->delete_receiving_id($suspended_receiving_id);
        }
        $this->_reload(array('success' => lang('sales_successfully_deleted')), false);
    }

    //hoa đơn nhập hàng

    function switch_recv($recv_ids) {
        $items = $this->Receiving->get_receiving_items($recv_ids)->result();

        $this->receiving_lib->copy_entire_receiving2($recv_ids);

        foreach ($items as $item) {

            $item_id_or_number_or_item_kit_or_receipt = $item->item_id;

            $price = $this->Receiving->get_receiving_items3($recv_ids, $item->item_id)->item_unit_price;

            $quantity = $this->Receiving->get_receiving_items3($recv_ids, $item->item_id)->quantity_purchased;
            $discount = $this->Receiving->get_receiving_items3($recv_ids, $item->item_id)->discount_percent;
            $taxes = $this->Receiving->get_receiving_items3($recv_ids, $item->item_id)->taxes;
            $this->receiving_lib->add_item($item_id_or_number_or_item_kit_or_receipt, $quantity, $discount, $taxes, $price);
        }
        $this->receiving_lib->set_recv($recv_ids);

        $info_receiving = $this->Receiving->get_info($recv_ids)->row_array();
        $this->receiving_lib->set_inventory($info_receiving['inventory_id']);
        //Nov 3
        $this->receiving_lib->set_date_debt($info_receiving['date_debt']);
        $this->receiving_lib->set_date_debt1($info_receiving['date_debt1']);
       
        $this->receiving_lib->set_symbol_order($info_receiving['symbol_order']);
        $this->receiving_lib->set_number_order($info_receiving['number_order']);
        $this->receiving_lib->set_number_taxes($info_receiving['number_taxes']);
        $this->receiving_lib->set_other_cost($info_receiving['other_cost']);
        $this->receiving_lib->set_comment($info_receiving['comment']);
        
        $info_bank_account = $this->Receiving->get_info_bank_account_by_receiving_id($recv_ids);
        $this->receiving_lib->set_bank_account($info_bank_account->bank_account);        
        
        $pays_type = substr($info_receiving['payment_type'], 0, strpos($info_receiving['payment_type'], ":"));
        $this->receiving_lib->set_payment_type($pays_type);
        
        $amount_tendered = substr($info_receiving['payment_type'], strpos($info_receiving['payment_type'], ":") + 1);
        $this->receiving_lib->set_amount_tendered($amount_tendered);

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
    //28-10-15 Opening AEON mall Long Bien (^_^)
    // hello HallOweeN (^_^)
    function add_date_debt(){	
        $date_debt = date('Y-m-d', strtotime($this->input->post('date_debt')));
        $this->receiving_lib->set_date_debt($date_debt);
	}
         function add_date_debt1(){	
        $date_debt1 = date('Y-m-d', strtotime($this->input->post('date_debt1')));
        $this->receiving_lib->set_date_debt1($date_debt1);
	}
    //Nov 3
    function set_bank_account() {
        $this->receiving_lib->set_bank_account($this->input->post('bank_account'));
    }
    //1088 band
    function item_search_recv() {
        $warehouse_id = $this->receiving_lib->get_inventory();
        $suggestions = $this->Item->get_item_search_suggestions_receiving_1088($this->input->get('term'), $warehouse_id, 100);
        echo json_encode($suggestions);
    }
    //load_account
    function add_load_account(){	
        $load_account = $this->input->post('load_account');
        $this->receiving_lib->set_load_account($load_account);
	}
}

?>