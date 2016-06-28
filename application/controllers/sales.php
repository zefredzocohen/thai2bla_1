<?php

require_once(APPPATH . 'third_party/Classes/PHPExcel/IOFactory.php');
require_once(APPPATH . 'libraries/php-excel.class.php');
require_once ("secure_area.php");

class Sales extends Secure_area {

    function __construct() {
        parent::__construct('sales');
        $this->load->library('sale_lib');
    }

    function index() {
        if ($this->config->item('track_cash')) {
            if ($this->input->post('opening_amount') != '') {
                $now = date('Y-m-d H:i:s');
                $cash_register = new stdClass();
                $cash_register->employee_id = $this->session->userdata('person_id');
                $cash_register->shift_start = $now;
                $cash_register->open_amount = $this->input->post('opening_amount');
                $cash_register->close_amount = 0;
                $cash_register->cash_sales_amount = 0;
                $this->Sale->insert_register($cash_register);
                redirect(site_url('sales'));
            } else if ($this->Sale->is_register_log_open()) {
                $this->_reload(array(), false);
            } else {
                $this->load->view('sales/opening_amount');
            }
        } else {
            $this->_reload(array(), false);
        }
    }

    function closeregister() {
        if (!$this->Sale->is_register_log_open()) {
            redirect(site_url('home'));
            return;
        }
        $cash_register = $this->Sale->get_current_register_log();
        $continueUrl = $this->input->get('continue');
        if ($this->input->post('closing_amount') != '') {
            $now = date('Y-m-d H:i:s');
            $cash_register->shift_end = $now;
            $cash_register->close_amount = $this->input->post('closing_amount');
            $cash_register->cash_sales_amount = $this->Sale->get_cash_sales_total_for_shift($cash_register->shift_start, $cash_register->shift_end);
            unset($cash_register->register_log_id);
            $this->Sale->update_register_log($cash_register);
            if ($continueUrl == 'logout') {
                redirect(site_url('home/logout'));
            } else {
                redirect(site_url('home'));
            }
        } else {
            $this->load->view('sales/closing_amount', array(
                'continue' => $continueUrl ? "?continue=$continueUrl" : '',
                'closeout' => to_currency($cash_register->open_amount + $this->Sale->get_cash_sales_total_for_shift($cash_register->shift_start, date("Y-m-d H:i:s")))
            ));
        }
    }

    function item_search1() {
        $suggestions = $this->Item->get_item_search_suggestions($this->input->get('term'), 100);
        $suggestions = array_merge($suggestions, $this->Item_kit->get_item_kit_search_suggestions($this->input->get('term'), 100));
        echo json_encode($suggestions);
    }

    function item_search() {
        $store = $this->sale_lib->get_store();
        if ($this->Employee->get_logged_in_employee_info()->person_id == 1) {
            if ($store != '' && $store != '1999') {
                $suggestions = $this->Item->get_item_search_suggestions_stored($this->input->get('term'), $store, 100);
                echo json_encode($suggestions);
            } elseif ($store == '1999') {
                $suggestions = $this->Pack->get_pack_search_suggestions($this->input->get('term'), 100);
                echo json_encode($suggestions);
            } else {
                $suggestions = $this->Item->get_item_search_suggestions_sales($this->input->get('term'), 100);
                echo json_encode($suggestions);
            }
        } else {
            if ($store != '' || $store == '1999') {
                $suggestions = $this->Item->get_item_search_suggestions_stored($this->input->get('term'), $store, 100);
                echo json_encode($suggestions);
            }else{
                $suggestions = $this->Pack->get_pack_search_suggestions($this->input->get('term'), 100);
                echo json_encode($suggestions);
            }
        }
    }

    function customer_search() {
        $suggestions = $this->Customer->get_info_customer_thu_chi($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    //hung audi 8-4-15
    function supplier_search_cost() {
        $suggestions = $this->Supplier->get_supplier_search_cost($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    function select_customer() {
        $data = array();
        $customer_id = $this->input->post("customer");
        if ($this->Customer->exists($customer_id)) {
            $this->sale_lib->set_customer($customer_id);
        } else {
            $data['error'] = lang('sales_unable_to_add_customer');
        }

        $this->_reload($data);
    }

    function change_mode() {
        $mode = $this->input->post("mode");
        $this->sale_lib->set_mode($mode);
        $this->_reload();
    }

    function set_comment() {
        $this->sale_lib->set_comment($this->input->post('comment'));
    }

    //huyenlt^^
    function set_employees_id() {
        $this->sale_lib->set_employees_id($this->input->post('employees_id'));
    }

    function set_store() {
        $this->sale_lib->set_store($this->input->post('store'));
    }

    function set_employees_delivery() {
        $this->sale_lib->set_employees_delivery($this->input->post('delivery_employee'));
    }

    function set_discount_money() {

        $this->sale_lib->set_discount_money($this->input->post('discount_money'));
    }

    /* phan lam 02/09/2013 */

    function add_date_debt() {
        $date_debt = date('Y-m-d', strtotime($this->input->post('date_debt')));
        $this->sale_lib->set_date_debt($date_debt);
    }

     function add_date_debt1() {
        $date_debt1 = date('Y-m-d', strtotime($this->input->post('date_debt1')));
        $this->sale_lib->set_date_debt1($date_debt1);
    }

    function set_comment_on_receipt() {
        $this->sale_lib->set_comment_on_receipt($this->input->post('show_comment_on_receipt'));
    }

    function set_email_receipt() {
        $this->sale_lib->set_email_receipt($this->input->post('email_receipt'));
    }

    function set_symbol_order() {

        $this->sale_lib->set_symbol_order($this->input->post('symbol_order'));
    }


    function set_number_order() {

        $this->sale_lib->set_number_order($this->input->post('number_order'));
    }

    //Alain Multiple Payments
    function add_payment() {
        $tienchietkhau = $this->input->post('tienkhauhao');
        //$discount_money = $this->input->post('discount_money');
        $data['discount_money'] = $this->sale_lib->get_discount_money();
        //echo $tienchietkhau;
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
        if ($payment_type == lang('sales_giftcard')) {
            if (!$this->Giftcard->exists($this->Giftcard->get_giftcard_id($this->input->post('amount_tendered')))) {
                $data['error'] = lang('sales_giftcard_does_not_exist');
                $this->_reload($data);
                return;
            }
            $payments = $this->sale_lib->get_payments();
            $payment_type = $this->input->post('payment_type') . ':' . $this->input->post('amount_tendered');
            $current_payments_with_giftcard = isset($payments[$payment_type]) ? $payments[$payment_type]['payment_amount'] : 0;
            $cur_giftcard_value = $this->Giftcard->get_giftcard_value($this->input->post('amount_tendered')) - $current_payments_with_giftcard;
            if ($cur_giftcard_value <= 0 && $this->sale_lib->get_total() > 0) {
                $data['error'] = lang('sales_giftcard_balance_is') . ' ' . to_currency($this->Giftcard->get_giftcard_value($this->input->post('amount_tendered'))) . ' !';
                $this->_reload($data);
                return;
            } elseif (( $this->Giftcard->get_giftcard_value($this->input->post('amount_tendered')) - $this->sale_lib->get_total() ) > 0) {
                $data['warning'] = lang('sales_giftcard_balance_is') . ' ' . to_currency($this->Giftcard->get_giftcard_value($this->input->post('amount_tendered')) - $this->sale_lib->get_total()) . ' !';
            }
            $payment_amount = min($this->sale_lib->get_amount_due(), $this->Giftcard->get_giftcard_value(to_un_currency($this->input->post('amount_tendered'))));
        } else {
            $payment_amount = str_replace(array(',', '.'), '', $this->input->post('amount_tendered'));
            $discount_money = str_replace(array(',', '.'), '', $this->input->post('discount_money'));
        }
        //add money
        if (!$this->sale_lib->add_payment($payment_type, $payment_amount, $discount_money)) {
            $data['error'] = lang('sales_unable_to_add_payment');
        }
        $this->_reload($data);
    }

    //Alain Multiple Payments
    function delete_payment($payment_id) {
        $this->sale_lib->delete_payment(rawurldecode($payment_id));
        $this->_reload();
    }

    function add() {
        $data = array();
        $mode = $this->sale_lib->get_mode();
        $item_id_or_number_or_item_kit_or_receipt = $this->input->post("item");
        $quantity = $mode == "sale" ? 1 : -1;
        $kho = $this->sale_lib->get_store();

        if ($this->sale_lib->is_valid_receipt($item_id_or_number_or_item_kit_or_receipt) && $mode == 'return') {
            $this->sale_lib->return_entire_sale($item_id_or_number_or_item_kit_or_receipt);
        } elseif ($this->sale_lib->is_valid_item_kit($item_id_or_number_or_item_kit_or_receipt)) {
            $this->sale_lib->add_item_kit($item_id_or_number_or_item_kit_or_receipt, $quantity);

            $item_kit_id = $this->sale_lib->get_valid_item_kit_id($item_id_or_number_or_item_kit_or_receipt);
            if ($this->sale_lib->out_of_stock_kit($item_kit_id)) {
                $data['warning'] = lang('sales_quantity_less_than_zero');
            }
        } elseif ($this->sale_lib->is_valid_pack($item_id_or_number_or_item_kit_or_receipt)) {
            $this->sale_lib->add_pack($item_id_or_number_or_item_kit_or_receipt, $quantity);

            $pack_id = $this->sale_lib->get_valid_pack_id($item_id_or_number_or_item_kit_or_receipt);
            if ($this->sale_lib->out_of_stock_pack($pack_id)) {
                $data['warning'] = lang('sales_quantity_less_than_zero');
            }
        } elseif (!$this->sale_lib->add_item($item_id_or_number_or_item_kit_or_receipt, $quantity)) {
            $data['error'] = lang('sales_unable_to_add_item');
        }
        if ($this->sale_lib->out_of_stock($item_id_or_number_or_item_kit_or_receipt)) {
            $data['warning'] = lang('sales_quantity_less_than_zero');
        }
        $this->_reload($data);
    }

    function edit_item678($line) {
        $data = array();
        $this->form_validation->set_rules('price', 'lang:items_price', 'required|numeric');
        $this->form_validation->set_rules('quantity', 'lang:items_quantity', 'required|numeric');

        $description = $this->input->post("description");
        $serialnumber = $this->input->post("serialnumber");
        $price = $this->input->post("price");
        $quantity = $this->input->post("quantity");
        $discount = $this->input->post("discount");



        if ($this->form_validation->run() != FALSE) {
            $this->sale_lib->edit_item($line, $description, $serialnumber, $quantity, $discount, $price);
        } else {
            $data['error'] = lang('sales_error_editing_item');
        }

        if ($this->sale_lib->is_kit_or_item($line) == 'item') {
            if ($this->sale_lib->out_of_stock($this->sale_lib->get_item_id($line))) {
                $data['warning'] = lang('sales_quantity_less_than_zero');
            }
        } elseif ($this->sale_lib->is_kit_or_item($line) == 'kit') {
            if ($this->sale_lib->out_of_stock_kit($this->sale_lib->get_kit_id($line))) {
                $data['warning'] = lang('sales_quantity_less_than_zero');
            }
        }
        $this->_reload($data);
    }

    function edit_item($line) {
        $data = array();
        $this->form_validation->set_rules('quantity', 'lang:items_quantity', 'required|numeric');
        $this->form_validation->set_rules('discount', 'lang:items_discount', 'required|numeric');
        $store = $this->sale_lib->get_store();
        $item_id = $this->input->post("item_id");
        $type_item = $this->input->post("type_item");
        $info_item = $this->Item->get_info($item_id);
        $unit = $this->input->post("unit");
        $description = $this->input->post("description");
        $serialnumber = $this->input->post("serialnumber");
        $price = str_replace(array(',', '.00'), '', $this->input->post('price'));
        $price_rate = str_replace(array(',', '.00'), '', $this->input->post('price_rate'));

        $quantity = $this->input->post("quantity");
        $discount = $this->input->post("discount");
        $taxes = $this->input->post("taxes");


        if ($this->session->userdata('unit_' . $line)) {
            $this->session->unset_userdata('unit_' . $line);
            $this->session->set_userdata('unit_' . $line, $unit);
        } else {

            $this->session->set_userdata('unit_' . $line, $unit);
        }
        if ($unit == 'unit') {
            if ($store != '1999') {
                if ($info_item->quantity_first != 0) {
                    if ($store != "") {
                        $info_item_store = $this->Item->get_Stores_Items($item_id, $store);
                        $so_nguyen = FLOOR($info_item_store->quantity / $info_item->unit_rate);
                        $abs = abs($info_item_store->quantity / $info_item->unit_rate);
                    } else {
                        $so_nguyen = FLOOR($info_item->quantity_total / $info_item->unit_rate);
                        $abs = abs($info_item->quantity_total / $info_item->unit_rate);
                    }
                    $so_du = abs($info_item->quantity_total % $info_item->unit_rate);
                    if ($abs < 1) {
                        $data['warning'] = "Cảnh báo, số lượng mong muốn không đủ. Bạn vẫn có thể thực hiện đơn hàng này, nhưng hãy kiểm tra hàng tồn kho của của bạn.";
//                        $data['warning'] = "Không thể bán theo đơn vị trước quy đổi. Số lượng theo đơn vị trước quy đổi là " . $so_nguyen;
//                        $unit = "unit_from";
                    } elseif ($quantity > $so_nguyen) {
                        $data['warning'] = "Cảnh báo, số lượng mong muốn không đủ. Bạn vẫn có thể thực hiện đơn hàng này, nhưng hãy kiểm tra hàng tồn kho của của bạn.";
//                        $data['warning'] = "Số lượng mong muốn không đúng. Số lượng tối đa có thể bán theo đơn vị trước quy đổi là " . $so_nguyen;
//                        $unit = "unit_from";
                    } else {
                        $unit = "unit";
                    }
                }
            }
        } elseif ($this->sale_lib->is_kit_or_item($line) == 'item') {
            if ($this->sale_lib->out_of_stock($this->sale_lib->get_item_id($line))) {
                $data['warning'] = lang('sales_quantity_less_than_zero');
            }
        } elseif ($this->sale_lib->is_kit_or_item($line) == 'kit') {
            if ($this->sale_lib->out_of_stock_kit($this->sale_lib->get_kit_id($line))) {
                $data['warning'] = lang('sales_quantity_less_than_zero');
            }
        }
        if ($this->form_validation->run() != FALSE) {
            $this->sale_lib->edit_item($line, $description, $serialnumber, $quantity, $discount, $price, $price_rate, $unit, $taxes);
        } else {
            $data['error'] = lang('sales_error_editing_item');
        }
        $this->_reload($data);
    }

    function delete_item($item_number) {
        $this->sale_lib->delete_item($item_number);
        $this->_reload();
    }

    function delete_customer() {
        $this->sale_lib->delete_customer();
        $this->_reload();
    }

    function start_cc_processing() {
        $service_url = (!defined("ENVIRONMENT") or ENVIRONMENT == 'development') ? 'https://hc.mercurydev.net/hcws/hcservice.asmx?WSDL' : 'https://hc.mercurypay.com/hcws/hcservice.asmx?WSDL';
        $payments = $this->sale_lib->get_payments();
        $cc_amount = number_format($payments[lang('sales_credit')]['payment_amount'], 2);
        $tax_amount = number_format(($this->sale_lib->get_total() - $this->sale_lib->get_subtotal()) * ($payments[lang('sales_credit')]['payment_amount'] / $this->sale_lib->get_total()), 2);
        $customer_id = $this->sale_lib->get_customer();
        $customer_name = '';
        if ($customer_id != -1) {
            $customer_info = $this->Customer->get_info($customer_id);
            $customer_name = $customer_info->first_name . ' ' . $customer_info->last_name;
        }
        $invoice_number = substr((date('mdy')) . (time() - strtotime("today")) . ($this->Employee->get_logged_in_employee_info()->person_id), 0, 16);
        $parameters = array(
            'request' => array(
                'MerchantID' => $this->config->item('merchant_id'),
                'Password' => $this->config->item('merchant_password'),
                'TranType' => $cc_amount > 0 ? 'Sale' : 'Return',
                'TotalAmount' => abs($cc_amount),
                'PartialAuth' => 'On',
                'Frequency' => 'OneTime',
                'OperatorID' => (!defined("ENVIRONMENT") or ENVIRONMENT == 'development') ? 'test' : $this->Employee->get_logged_in_employee_info()->person_id,
                'Invoice' => $invoice_number,
                'Memo' => 'PHP POS ' . APPLICATION_VERSION,
                'TaxAmount' => abs($tax_amount),
                'CardHolderName' => $customer_name,
                'ProcessCompleteUrl' => site_url('sales/finish_cc_processing'),
                'ReturnUrl' => site_url('sales/cancel_cc_processing'),
            )
        );

        if (isset($customer_info) && $customer_info->zip) {
            $parameters['request']['AVSZip'] = $customer_info->zip;
        }

        $client = new SoapClient($service_url, array('trace' => TRUE));
        $result = $client->InitializePayment($parameters);
        $response_code = $result->InitializePaymentResult->ResponseCode;

        if ($response_code == 0) {
            $payment_id = $result->InitializePaymentResult->PaymentID;
            $hosted_checkout_url = (!defined("ENVIRONMENT") or ENVIRONMENT == 'development') ? 'https://hc.mercurydev.net/CheckoutPOS.aspx' : 'https://hc.mercurypay.com/CheckoutPOS.aspx';
            $this->load->view('sales/hosted_checkout', array('payment_id' => $payment_id, 'hosted_checkout_url' => $hosted_checkout_url));
        } else {
            $this->_reload(array('error' => lang('sales_credit_card_processing_is_down')), false);
        }
    }

    function finish_cc_processing() {
        $return_code = $this->input->get("ReturnCode");
        $service_url = (!defined("ENVIRONMENT") or ENVIRONMENT == 'development') ? 'https://hc.mercurydev.net/hcws/hcservice.asmx?WSDL' : 'https://hc.mercurypay.com/hcws/hcservice.asmx?WSDL';
        $parameters = array(
            'request' => array(
                'MerchantID' => $this->config->item('merchant_id'),
                'PaymentID' => $this->input->get('PaymentID'),
                'Password' => $this->config->item('merchant_password'),
            )
        );
        $client = new SoapClient($service_url, array('trace' => TRUE));
        $result = $client->VerifyPayment($parameters);
        $response_code = $result->VerifyPaymentResult->ResponseCode;
        $status = $result->VerifyPaymentResult->Status;
        $total_amount = $result->VerifyPaymentResult->Amount;
        $auth_amount = $result->VerifyPaymentResult->AuthAmount;

        $auth_code = $result->VerifyPaymentResult->AuthCode;
        $acq_ref_data = $result->VerifyPaymentResult->AcqRefData;
        $ref_no = $result->VerifyPaymentResult->RefNo;
        $token = $result->VerifyPaymentResult->Token;
        $process_data = $result->VerifyPaymentResult->ProcessData;

        if ($response_code == 0 && $status == 'Approved') {
            $result = $client->AcknowledgePayment($parameters);
            $response_code = $result->AcknowledgePaymentResult;

            if ($response_code == 0 && $auth_amount == $total_amount) {
                $this->session->set_flashdata('ref_no', $ref_no);
                redirect(site_url('sales/complete'));
            } elseif ($response_code == 0 && $auth_amount < $total_amount) {
                $invoice_number = substr((date('mdy')) . (time() - strtotime("today")) . ($this->Employee->get_logged_in_employee_info()->person_id), 0, 16);

                $partial_transaction = array(
                    'AuthCode' => $auth_code,
                    'Frequency' => 'OneTime',
                    'Memo' => 'PHP POS ' . APPLICATION_VERSION,
                    'Invoice' => $invoice_number,
                    'MerchantID' => $this->config->item('merchant_id'),
                    'OperatorID' => (!defined("ENVIRONMENT") or ENVIRONMENT == 'development') ? 'test' : $this->Employee->get_logged_in_employee_info()->person_id,
                    'PurchaseAmount' => $auth_amount,
                    'RefNo' => $ref_no,
                    'Token' => $token,
                    'AcqRefData' => $acq_ref_data,
                    'ProcessData' => $process_data,
                );

                $this->sale_lib->delete_payment(lang('sales_credit'));
                $this->sale_lib->add_payment(lang('sales_partial_credit'), $auth_amount);
                $this->sale_lib->add_partial_transaction($partial_transaction);
                $this->_reload(array('warning' => lang('sales_credit_card_partially_charged_please_complete_sale_with_another_payment_method')), false);
            } else {
                $this->_reload(array('error' => lang('sales_acknowledge_payment_failed_please_contact_support')), false);
            }
        } else {
            $client->AcknowledgePayment($parameters);
            $this->_reload(array('error' => $result->VerifyPaymentResult->DisplayMessage), false);
        }
    }

    function cancel_cc_processing() {
        $this->sale_lib->delete_payment(lang('sales_credit'));
        $this->_reload(array('error' => lang('sales_cc_processing_cancelled')), false);
    }

    //Created by San
    function download_matarial() {
        header('Content-Type: text/html; charset=utf-8');
        $file = $_GET['file'];
        $data = file_get_contents(APPPATH . "/../excel_materials/" . $file);
        force_download($file, $data);
    }

    // phan lam bao gia hop dong
    function baogia($sale_id) {
        $id_quotes_contract = $this->input->get("quotes");
        $data['info_quotes_contract'] = $this->M_quotes_contract->get_info($id_quotes_contract);
        $data['is_sale'] = FALSE;
        $sale_info = $this->Sale->get_info($sale_id)->row_array();
        $this->sale_lib->copy_entire_sale($sale_id);
        $data['cart'] = $this->sale_lib->get_cart();
        $data['payments'] = $this->sale_lib->get_payments();
        $data['subtotal'] = $this->sale_lib->get_subtotal();
        $data['taxes'] = $this->sale_lib->get_taxes($sale_id);
        $data['total'] = $this->sale_lib->get_total($sale_id);
        $data['receipt_title'] = lang('sales_receipt');
        $data['comment'] = $this->Sale->get_comment($sale_id);
        $data['show_comment_on_receipt'] = $this->Sale->get_comment_on_receipt($sale_id);
        $data['transaction_time'] = date(get_date_format() . ' ' . get_time_format(), strtotime($sale_info['sale_time']));
        $customer_id = $this->sale_lib->get_customer();
        $emp_info = $this->Employee->get_info($sale_info['employee_id']);
        $info_empss = $this->Employee->get_info($sale_info['employees_id']);
        $data['employees_id'] = $info_empss->first_name . ' ' . $info_empss->last_name;
        $data['phone_number1'] = $info_empss->phone_number;
        $data['email1'] = $info_empss->email;
        $data['payment_type'] = $sale_info['payment_type'];
        $data['amount_change'] = $this->sale_lib->get_amount_due($sale_id) * -1;
        $data['employee'] = $emp_info->first_name . ' ' . $emp_info->last_name;
        $data['phone_number'] = $emp_info->phone_number;
        $data['email'] = $emp_info->email;
        $data['ref_no'] = $sale_info['cc_ref_no'];
        $this->load->helper('string');
        $data['payment_type'] = str_replace(array('<sup>VNĐ</sup><br />', ''), ' .VNĐ', $sale_info['payment_type']);
        $data['amount_due'] = $this->sale_lib->get_amount_due();

        if ($customer_id != -1) {
            $cust_info = $this->Customer->get_info($customer_id);
            $data['customer'] = $cust_info->first_name . ' ' . $cust_info->last_name;
            $data['cus_name'] = $cust_info->company_name == '' ? '' : $cust_info->company_name;
            $data['code_tax'] = $cust_info->code_tax;
            $data['address'] = $cust_info->address_1;
            $data['account_number'] = $cust_info->account_number;
        }
        $data['sale_id'] = $sale_id;
        $word = $this->input->get('baogiabutton');
        $cat_baogia = $this->input->get("cat_baogia");
        $data['word'] = $word;
        $data['cat_baogia'] = $cat_baogia;
        if ($word == 0) {
            $this->load->view("sales/report_quotes", $data);
        } else {
            $file_name = "BG_" . $sale_id . "_" . str_replace(" ", "", replace_character($data['customer'])) . "_" . date('dmYHis') . ".doc";
            $fp = fopen("excel_materials/" . $file_name, 'w+');
            $arr_item = array();
            $arr_service = array();
            foreach ($data['cart'] as $line => $val) {
                if ($val['item_id']) {
                    $info_item = $this->Item->get_info($val['item_id']);
                    if ($info_item->service == 0) {
                        $arr_item[] = array(
                            'item_id' => $val['item_id'],
                            'line' => $line,
                            'name' => $val['name'],
                            'item_number' => $val['item_number'],
                            'description' => $val['description'],
                            'serialnumber' => $val['serialnumber'],
                            'allow_alt_description' => $val['allow_alt_description'],
                            'is_serialized' => $val['is_serialized'],
                            'quantity' => $val['quantity'],
                            'stored_id' => $val['stored_id'],
                            'discount' => $val['discount'],
                            'price' => $val['price'],
                            'price_rate' => $val['price_rate'],
                            'taxes' => $val['taxes'],
                            'unit' => $val['unit']
                        );
                    } else {
                        $arr_service[] = array(
                            'item_id' => $val['item_id'],
                            'line' => $line,
                            'name' => $val['name'],
                            'item_number' => $val['item_number'],
                            'description' => $val['description'],
                            'serialnumber' => $val['serialnumber'],
                            'allow_alt_description' => $val['allow_alt_description'],
                            'is_serialized' => $val['is_serialized'],
                            'quantity' => $val['quantity'],
                            'stored_id' => $val['stored_id'],
                            'discount' => $val['discount'],
                            'price' => $val['price'],
                            'price_rate' => $val['price_rate'],
                            'taxes' => $val['taxes'],
                            'unit' => $val['unit']
                        );
                    }
                } else {
                    $arr_item[] = array(
                        'pack_id' => $val['pack_id'],
                        'line' => $val['line'],
                        'pack_number' => $val['pack_number'],
                        'name' => $val['name'],
                        'description' => $val['description'],
                        'quantity' => $val['quantity'],
                        'discount' => $val['discount'],
                        'price' => $val['price'],
                        'taxes' => $val['taxes'],
                        'unit' => $val['unit']
                    );
                }
            }
            $str = "";
            $str .= "<table style='border-collapse: collapse; width: 100%; margin: 0px auto; font-size: 14px;'>";
            $str .= "<tr>";
            $str .= "<th style='text-align: center; border: 1px solid #000000; padding: 10px 0px;'>STT</th>";
            $str .= "<th style='text-align: center; border: 1px solid #000000; padding: 10px 0px;'>Mã/Tên HH, DC, Gói SP</th>";
            $str .= "<th style='text-align: center; border: 1px solid #000000; padding: 10px 0px;' colspan='2'>Mô tả/Hình ảnh</th>";
            $str .= "<th style='text-align: center; border: 1px solid #000000; padding: 10px 0px;'>ĐVT</th>";
            $str .= "<th style='text-align: center; border: 1px solid #000000; padding: 10px 0px;'>SL</th>";
            $str .= "<th style='text-align: center; border: 1px solid #000000; padding: 10px 0px;'>Đơn giá</th>";
            $str .= "<th style='text-align: center; border: 1px solid #000000; padding: 10px 0px;'>CK(%)</th>";
            $str .= "<th style='text-align: center; border: 1px solid #000000; padding: 10px 0px;'>Thuế(%)</th>";
            $str .= "<th style='text-align: center; border: 1px solid #000000; padding: 10px 0px;'>Thành tiền</th>";
            $str .= "</tr>";
            $str .= "<tr>";
            $str .= "<td style='text-align: center; border: 1px solid #000000; font-style: italic; padding: 5px 0px; width: 5%;'>(No.)</td>";
            $str .= "<td style='text-align: center; border: 1px solid #000000; font-style: italic; padding: 5px 0px; width: 17.5%;'>(Code/Name)</td>";
            $str .= "<td style='text-align: center; border: 1px solid #000000; font-style: italic; padding: 5px 0px; width: 17.5%;'>(Description)</td>";
            $str .= "<td style='text-align: center; border: 1px solid #000000; font-style: italic; padding: 5px 0px; width: 10%;'>(Images)</td>";
            $str .= "<td style='text-align: center; border: 1px solid #000000; font-style: italic; padding: 5px 0px; width: 10%;'>(Units)</td>";
            $str .= "<td style='text-align: center; border: 1px solid #000000; font-style: italic; padding: 5px 0px; width: 10%;'>(Quantity)</td>";
            $str .= "<td style='text-align: center; border: 1px solid #000000; font-style: italic; padding: 5px 0px; width: 10%;'>(Unit price)</td>";
            $str .= "<td style='text-align: center; border: 1px solid #000000; font-style: italic; padding: 5px 0px; width: 5%;'>(Discount)</td>";
            $str .= "<td style='text-align: center; border: 1px solid #000000; font-style: italic; padding: 5px 0px; width: 5%;'>(Tax)</td>";
            $str .= "<td style='text-align: center; border: 1px solid #000000; font-style: italic; padding: 5px 0px; width: 10%;'>(Amount)</td>";
            $str .= "</tr>";
            $stt = 1;
            $total = 0;
            if ($cat_baogia == 1) {
                foreach ($arr_item as $line => $item) {
                    if ($item['pack_id']) {
                        $info_pack = $this->Pack->get_info($item['pack_id']);
                        $pack_item = $this->Pack_items->get_info($item['pack_id']);
                        $info_sale_pack = $this->Sale->get_sale_pack_by_sale_pack($sale_id, $item['pack_id']);
                        $info_unit = $this->Unit->get_info($info_sale_pack->unit_pack);
                        $thanh_tien = $item['quantity'] * $item['price'] - $item['quantity'] * $item['price'] * $item['discount'] / 100 + ($item['quantity'] * $item['price'] - $item['quantity'] * $item['price'] * $item['discount'] / 100) * $item['taxes'] / 100;
                        $str .= "<tr>";
                        $str .= "<td style='text-align: center; border: 1px solid #000000; padding: 10px 5px'>" . $stt . "</td>";
                        $str .= "<td style='border: 1px solid #000000; padding: 10px 5px'>";
                        $str .= "<strong>" . $info_pack->pack_number . "/" . $info_pack->name . "(Gói SP)</strong><br>";
                        foreach ($pack_item as $val) {
                            $info_item = $this->Item->get_info($val->item_id);
                            $str .= "<p>- <strong>" . $info_item->item_number . "</strong>/" . $info_item->name . "</p>";
                        }

                        $str .= "</td>";
                        $str .= "<td style='border: 1px solid #000000; padding: 10px 5px'>" . $item['description'] . "</td>";
                        $str .= "<td style='text-align: center; border: 1px solid #000000; padding: 10px 5px'>";
                        if ($info_pack->images) {
                            $str .= "<img src='" . base_url('packs/' . $info_pack->images) . "' style='width:45px; height:45px'/>";
                        }
                        $str .= "</td>";
                        $str .= "<td style='border: 1px solid #000000; padding: 10px 5px'>" . $info_unit->name . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . format_quantity($item['quantity']) . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($item['price']) . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($item['discount']) . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($item['taxes']) . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($thanh_tien) . "</td>";
                        $str .= "</tr>";
                        $stt++;
                        $total += $thanh_tien;
                    } else {
                        $info_item = $this->Item->get_info($item['item_id']);
                        $info_sale_item = $this->Sale->get_sale_item_by_sale_item($sale_id, $item['item_id']);
                        $info_unit = $this->Unit->get_info($info_sale_item->unit_item);
                        $thanh_tien = $item['quantity'] * ($item['unit'] == 'unit_from' ? $item['price_rate'] : $item['price']) - $item['quantity'] * ($item['unit'] == 'unit_from' ? $item['price_rate'] : $item['price']) * $item['discount'] / 100 + ($item['quantity'] * ($item['unit'] == 'unit_from' ? $item['price_rate'] : $item['price']) - $item['quantity'] * ($item['unit'] == 'unit_from' ? $item['price_rate'] : $item['price']) * $item['discount'] / 100) * $item['taxes'] / 100;
                        $str .= "<tr>";
                        $str .= "<td style='text-align: center; border: 1px solid #000000; padding: 10px 5px'>" . $stt . "</td>";
                        $str .= "<td style='border: 1px solid #000000; padding: 10px 5px'><strong>" . $info_item->item_number . "</strong>/" . $info_item->name . "</td>";
                        $str .= "<td style='border: 1px solid #000000; padding: 10px 5px'>" . $item['description'] . "</td>";
                        $str .= "<td style='text-align: center; border: 1px solid #000000; padding: 10px 5px'>";
                        if ($info_item->images) {
                            $str .= "<img src='" . base_url('item/' . $info_item->images) . "' style='width:45px; height:45px'/>";
                        }
                        $str .= "</td>";
                        $str .= "<td style='border: 1px solid #000000; padding: 10px 5px'>" . $info_unit->name . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . format_quantity($item['quantity']) . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format(($item['unit'] == 'unit_from' ? $item['price_rate'] : $item['price'])) . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($item['discount']) . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($item['taxes']) . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($thanh_tien) . "</td>";
                        $str .= "</tr>";
                        $stt++;
                        $total += $thanh_tien;
                    }
                }
            } else if ($cat_baogia == 2) {
                foreach ($arr_service as $line => $item) {
                    $info_item = $this->Item->get_info($item['item_id']);
                    $info_sale_item = $this->Sale->get_sale_item_by_sale_item($sale_id, $item['item_id']);
                    $info_unit = $this->Unit->get_info($info_sale_item->unit_item);
                    $thanh_tien = $item['quantity'] * $item['price'] - $item['quantity'] * $item['price'] * $item['discount'] / 100 + ($item['quantity'] * $item['price'] - $item['quantity'] * $item['price'] * $item['discount'] / 100) * $item['taxes'] / 100;
                    $str .= "<tr>";
                    $str .= "<td style='text-align: center; border: 1px solid #000000; padding: 10px 5px'>" . $stt . "</td>";
                    $str .= "<td style='border: 1px solid #000000; padding: 10px 5px'><strong>" . $info_item->item_number . "</strong/" . $info_item->name . "</td>";
                    $str .= "<td style='border: 1px solid #000000; padding: 10px 5px'>" . $item['description'] . "</td>";
                    $str .= "<td style='text-align: center; border: 1px solid #000000; padding: 10px 5px'>";
                    if ($info_item->images) {
                        $str .= "<img src='" . base_url('item/' . $info_item->images) . "' style='width:45px; height:45px'/>";
                    }
                    $str .= "</td>";
                    $str .= "<td style='border: 1px solid #000000; padding: 10px 5px'>" . $info_unit->name . "</td>";
                    $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . format_quantity($item['quantity']) . "</td>";
                    $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($item['price']) . "</td>";
                    $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($item['discount']) . "</td>";
                    $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($item['taxes']) . "</td>";
                    $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($thanh_tien) . "</td>";
                    $str .= "</tr>";
                    $stt ++;
                    $total += $thanh_tien;
                }
            } else {
                foreach ($data['cart'] as $line => $item) {
                    if ($item['pack_id']) {
                        $info_pack = $this->Pack->get_info($item['pack_id']);
                        $pack_item = $this->Pack_items->get_info($item['pack_id']);
                        $info_sale_pack = $this->Sale->get_sale_pack_by_sale_pack($sale_id, $item['pack_id']);
                        $info_unit = $this->Unit->get_info($info_sale_pack->unit_pack);
                        $thanh_tien = $item['quantity'] * $item['price'] - $item['quantity'] * $item['price'] * $item['discount'] / 100 + ($item['quantity'] * $item['price'] - $item['quantity'] * $item['price'] * $item['discount'] / 100) * $item['taxes'] / 100;
                        $str .= "<tr>";
                        $str .= "<td style='text-align: center; border: 1px solid #000000; padding: 10px 5px'>" . $stt . "</td>";
                        $str .= "<td style='border: 1px solid #000000; padding: 10px 5px'>";
                        $str .= "<strong>" . $info_pack->pack_number . "/" . $info_pack->name . "(Gói SP)</strong><br>";
                        foreach ($pack_item as $val) {
                            $info_item = $this->Item->get_info($val->item_id);
                            $str .= "<p>- <strong>" . $info_item->item_number . "</strong>/" . $info_item->name . "</p>";
                        }

                        $str .= "</td>";
                        $str .= "<td style='border: 1px solid #000000; padding: 10px 5px'>" . $item['description'] . "</td>";
                        $str .= "<td style='text-align: center; border: 1px solid #000000; padding: 10px 5px'>";
                        if ($info_pack->images) {
                            $str .= "<img src='" . base_url('packs/' . $info_pack->images) . "' width='20px' height='20px'/>";
                        }
                        $str .= "</td>";
                        $str .= "<td style='border: 1px solid #000000; padding: 10px 5px'>" . $info_unit->name . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . format_quantity($item['quantity']) . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($item['price']) . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($item['discount']) . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($item['taxes']) . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($thanh_tien) . "</td>";
                        $str .= "</tr>";
                        $total += $thanh_tien;
                    } else {
                        $info_item = $this->Item->get_info($item['item_id']);
                        $info_sale_item = $this->Sale->get_sale_item_by_sale_item($sale_id, $item['item_id']);
                        $info_unit = $this->Unit->get_info($info_sale_item->unit_item);
                        $thanh_tien = $item['quantity'] * ($item['unit'] == 'unit_from' ? $item['price_rate'] : $item['price']) - $item['quantity'] * ($item['unit'] == 'unit_from' ? $item['price_rate'] : $item['price']) * $item['discount'] / 100 + ($item['quantity'] * ($item['unit'] == 'unit_from' ? $item['price_rate'] : $item['price']) - $item['quantity'] * ($item['unit'] == 'unit_from' ? $item['price_rate'] : $item['price']) * $item['discount'] / 100) * $item['taxes'] / 100;
                        $str .= "<tr>";
                        $str .= "<td style='text-align: center; border: 1px solid #000000; padding: 10px 5px'>" . $stt . "</td>";
                        $str .= "<td style='border: 1px solid #000000; padding: 10px 5px'><strong>" . $info_item->item_number . "</strong>/" . $info_item->name . "</td>";
                        $str .= "<td style='border: 1px solid #000000; padding: 10px 5px'>" . $item['description'] . "</td>";
                        $str .= "<td style='text-align: center; border: 1px solid #000000; padding: 10px 5px'>";
                        if ($info_item->images) {
                            $str .= "<img src='" . base_url('item/' . $info_item->images) . "' width='20px' height='20px'/>";
                        }
                        $str .= "</td>";
                        $str .= "<td style='border: 1px solid #000000; padding: 10px 5px'>" . $info_unit->name . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . format_quantity($item['quantity']) . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format(($item['unit'] == 'unit_from' ? $item['price_rate'] : $item['price'])) . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($item['discount']) . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($item['taxes']) . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($thanh_tien) . "</td>";
                        $str .= "</tr>";
                        $total += $thanh_tien;
                    }
                    $stt++;
                }
            }
            $str .= "<tr>";
            $str .= "<td colspan='5' style='text-align: center; border: 1px solid #000000; padding: 10px 5px; font-weight: bold'>Tổng</td>";
            $str .= "<td colspan='5' style='text-align: right; border: 1px solid #000000; padding: 10px 5px; font-weight: bold'>" . number_format($total) . "</td>";
            $str .= "</tr>";
            $str .= "</table>";
            $str .= "<p>Tổng giá trị (Bằng chữ): <strong><em>" . $this->Cost->get_string_number($total) . "</em></strong></p>";
            $content1 = "<html>";
            $content1 .= "<meta charset='utf-8'/>";
            $content1 .= "<body style='font-size: 100% !important'>";
            $content1 .= $data['info_quotes_contract']->content_quotes_contract;
            $content1 .= "</body>";
            $content1 .= "</html>";
            $info_sale = $this->Sale->get_info_sale_order($sale_id);
            $d = $info_sale->date_debt != '0000-00-00' ? date('d', strtotime($info_sale->date_debt)) : '...';
            $m = $info_sale->date_debt != '0000-00-00' ? date('m', strtotime($info_sale->date_debt)) : '...';
            $y = $info_sale->date_debt != '0000-00-00' ? date('Y', strtotime($info_sale->date_debt)) : '...';
            $content1 = str_replace('{TITLE}', $data['info_quotes_contract']->title_quotes_contract, $content1);
            $content1 = str_replace('{TABLE_DATA}', $str, $content1);
            $content1 = str_replace('{LOGO}', "<img src='" . base_url('images/logoreport/' . $this->config->item('report_logo')) . "'/>", $content1);
            $content1 = str_replace('{TEN_NCC}', $this->config->item('company'), $content1);
            $content1 = str_replace('{DIA_CHI_NCC}', $this->config->item('address'), $content1);
            $content1 = str_replace('{SDT_NCC}', $this->config->item('phone'), $content1);
            $content1 = str_replace('{DD_NCC}', $this->config->item('corp_master_account'), $content1);
            $content1 = str_replace('{CHUCVU_NCC}', '', $content1);
            $content1 = str_replace('{TKNH_NCC}', $this->config->item('corp_number_account'), $content1);
            $content1 = str_replace('{NH_NCC}', $this->config->item('corp_bank_name'), $content1);
            $content1 = str_replace('{TEN_KH}', $data['cus_name'], $content1);
            $content1 = str_replace('{DIA_CHI_KH}', $data['address'], $content1);
            $content1 = str_replace('{SDT_KH}', '', $content1);
            $content1 = str_replace('{DD_KH}', $data['customer'], $content1);
            $content1 = str_replace('{CHUCVU_KH}', $data['positions'], $content1);
            $content1 = str_replace('{TKNH_KH}', $data['code_tax'], $content1);
            $content1 = str_replace('{NH_KH}', '', $content1);
            $content1 = str_replace('{CODE}', $sale_id, $content1);
            $content1 = str_replace('{DATE}', $d, $content1);
            $content1 = str_replace('{MONTH}', $m, $content1);
            $content1 = str_replace('{YEAR}', $y, $content1);
            fwrite($fp, $content1);
            fclose($fp);

            /* phan lam mail */
            $cust_info = $this->Customer->get_info($customer_id);
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
            $this->email->to($cust_info->email);
            $this->email->subject($this->config->item('company') . " xin chân trọng gửi tới quý khách thư báo giá");
            $content = "<p>Dear anh/chị:" . $data['customer'] . "</p>";
            $content .= "<p>Dựa vào nhu cầu của Quý khách hàng.</p>";
            $content .= "<p><b>" . $this->config->item('company') . "</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p>";
            $content .= "<p>Xin vui lòng xem ở file đính kèm</p>";
            $content .= "<p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: " . $this->config->item("phone") . "</i></p>";
            $content .= "<i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i>";
            $content .= "<p>-----</p>";
            $content .= "<p><i>Thanks and Regards!</i></p>";
            if ($sale_info['employees_id'] != 0) {
                $content .= "<p><i>" . $data['employees_id'] . "</i></p>";
                $content .= "<p>Mobile: " . $data['phone_number1'] . "</p>";
                $content .= "<p>Email: " . $data['email1'] . "</p>";
            } else {
                $content .= "<p><i>" . $data['employee'] . "</i></p>";
                $content .= "<p>Mobile: " . $data['phone_number'] . "</p>";
                $content .= "<p>Email: " . $data['email'] . "</p>";
            }
            $content .= "<p style='text-transform: uppercase;'>" . $this->config->item("company") . "</p>";
            $content .= "<p>Rep Off  :" . $this->config->item('address') . "</p>";
            $content .= "<p>Email    :" . $this->config->item('email') . "</p>";
            $content .= "<p>Tel      :" . $this->config->item('phone') . " | Fax: " . $this->config->item('fax') . "</p>";
            $content .= "<p>Web      :" . $this->config->item('website') . "</p>";
            $this->email->message($content);
            $file = APPPATH . "/../excel_materials/" . $file_name;
            $this->email->attach($file);
            if ($this->email->send()) {
                $send_success[] = $cust_info->email;
                $data = array(
                    'sale_id' => $sale_id,
                    'name' => $file_name,
                );
                $this->Sale->insert_sale_material($data);
                $data_history = array(
                    'person_id' => $customer_id,
                    'employee_id' => $this->session->userdata('person_id'),
                    'title' => 'Báo giá',
                    'content' => $content,
                    'time' => date('Y-m-d H:i:s'),
                    'file' => $file_name,
                    'status' => 1,
                );
                $this->Customer->add_mail_history($data_history);
                $this->sale_lib->clear_all();
                redirect('sales');
            } else {
                $data_history = array(
                    'person_id' => $customer_id,
                    'employee_id' => $this->session->userdata('person_id'),
                    'title' => 'Báo giá',
                    'content' => $content,
                    'time' => date('Y-m-d H:i:s'),
                    'file' => $file_name,
                    'status' => 0,
                );
                $this->Customer->add_mail_history($data_history);
                $send_fail[] = $cust_info->email;
                show_error($this->email->print_debugger());
            }
            /* end phan lam mail */
        }
        $this->sale_lib->clear_all();
    }

    function baogia1($sale_id) {

        $data['is_sale'] = FALSE;
        $sale_info = $this->Sale->get_info($sale_id)->row_array();

        $this->sale_lib->copy_entire_sale($sale_id);

        $data['cart'] = $this->sale_lib->get_cart();

        $data['payments'] = $this->sale_lib->get_payments();

        $data['subtotal'] = $this->sale_lib->get_subtotal();

        $data['taxes'] = $this->sale_lib->get_taxes($sale_id);

        $data['total'] = $this->sale_lib->get_total($sale_id);

        $data['receipt_title'] = lang('sales_receipt');

        $data['comment'] = $this->Sale->get_comment($sale_id);

        $data['show_comment_on_receipt'] = $this->Sale->get_comment_on_receipt($sale_id);

        $data['transaction_time'] = date(get_date_format() . ' ' . get_time_format(), strtotime($sale_info['sale_time']));

        $customer_id = $this->sale_lib->get_customer();

        $emp_info = $this->Employee->get_info($sale_info['employee_id']);
//nhân viên báo giá
        $info_empss = $this->Employee->get_info($sale_info['employees_id']);
        $data['employees_id'] = $info_empss->first_name . ' ' . $info_empss->last_name;

        $data['payment_type'] = $sale_info['payment_type'];

        $data['amount_change'] = $this->sale_lib->get_amount_due($sale_id) * -1;

        $data['employee'] = $emp_info->first_name . ' ' . $emp_info->last_name;

        $data['ref_no'] = $sale_info['cc_ref_no'];

        $this->load->helper('string');

        $data['payment_type'] = str_replace(array('<sup>VNĐ</sup><br />', ''), ' .VNĐ', $sale_info['payment_type']);

        $data['amount_due'] = $this->sale_lib->get_amount_due();

        foreach ($data['payments'] as $payment_id => $payment) {

            $payment_amount = $payment['payment_amount'];
        }

        $k = 28;

        $tongtienhang = 0;

        foreach (array_reverse($data['cart'], true) as $line => $item) {

            $tongtienhang_1 += $item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100;

            $k++;
        }

        $payments_cost = $tongtienhang_1 - $payment_amount;

        if ($customer_id != -1) {

            $cust_info = $this->Customer->get_info($customer_id);

            $data['customer'] = $cust_info->first_name . ' ' . $cust_info->last_name;

            $data['cus_name'] = $cust_info->company_name == '' ? '' : $cust_info->company_name;

            $data['code_tax'] = $cust_info->code_tax;

            $data['address'] = $cust_info->address_1;

            $data['account_number'] = $cust_info->account_number;
        }

        $data['sale_id'] = 'VH ' . $sale_id;

// $this->load->view("sales/receipt",$data);
// $this->sale_lib->clear_all();

        $cities = $this->City->get_all();

        $excel = $this->input->get('baogiabutton');

        if ($excel == 1) {

//require_once APPPATH . "/third_party/Classes/export_baogia.php";
            /* lam bao gia mau excel */
            $excel_info = $this->Template->get_info_cat(2);
            $excel_link = $excel_info->link;
            $excel_name_cus = $excel_info->name_cus;
            $excel_add_cus = $excel_info->add_cus;
            $this->load->library('Excel');
            $objPHPExcel = new PHPExcel();
//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);
            define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
            $link = base_url() . "application/controllers/sales.xlsx";
            date_default_timezone_set('Europe/London');
            print_r(str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)));
            require_once APPPATH . '/third_party/Classes/PHPExcel.php';
            echo date('H:i:s'), " Load Excel2007 template file", EOL;
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');
            $objPHPExcel = $objReader->load("$excel_link");
            $objPHPExcel->getActiveSheet()->setCellValue($excel_name_cus, $data['customer']);
            $objPHPExcel->getActiveSheet()->setCellValue($excel_add_cus, $data['address']);
            $k_row = 25;
            $stt = 1;
            $tongtienhang = 0;
            foreach (array_reverse($data['cart'], true) as $line => $item) {
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $k_row, $stt);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $k_row, $item['name']);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $k_row, $this->Unit->item_unit($this->Item->get_info($item['item_id'])->unit)->name);
                $objPHPExcel->getActiveSheet()->getStyle('F' . $k_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $k_row, $item['quantity']);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $k_row, to_currency_unVND_nomar($item['price']));
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $k_row, to_currency_unVND_nomar($item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100));
                $this->excel->getActiveSheet()->getStyle('I' . $k_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $tongtienhang += $item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100;
                $k_row++;
                $stt++;
                $objPHPExcel->getActiveSheet()->insertNewRowBefore($k_row, 1);
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C' . $k_row . ':E' . $k_row);
                $objPHPExcel->getActiveSheet()->getStyle('C' . $k_row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            }
            echo date('H:i:s'), " Write to Excel5 format", EOL;
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save(str_replace('.php', '.xlsx', __FILE__));
            echo str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)), EOL;
            echo "<a href=$link>tai ve</a>";
            /* end lam bao gia excel */
        } else {

            /* phan lam mail */

            $customer_ids = array($customer_id);
            $mail_id = $this->input->post('mail_id');

            $mail_info = $this->Customer->get_info_mail($mail_id);

            $ses = new SimpleEmailService($this->config->item('amazon_access_key'), $this->config->item('amazon_secret_key'));

            $ses->enableVerifyHost(false);

            $ses->enableVerifyPeer(false);
//get list_email of customer from multi ids

            $list_customer_email = array();

            $send_success = array();

            $send_fail = array();
            foreach ($customer_ids as $c_ids) {

                if ($this->Customer->get_info($c_ids)->email != '') {

                    $list_customer_email[] = $this->Customer->get_info($c_ids)->email;

                    $list_customer = $this->Customer->get_info($c_ids);



                    $m = new SimpleEmailServiceMessage();

                    $m->setFrom('gs.daycon@gmail.com');

                    $m->addCC($this->config->item('email'));

//set mail title

                    $m->setSubject("Công ty " . $this->config->item('company') . " xin chân trọng gửi tới quý khách " . $list_customer->first_name . " thư báo giá");

                    $m->addTo($this->Customer->get_info($c_ids)->email);



//set mall content

                    $content = $this->load->view('sales/baogia', $data, true);

                    $content = str_replace('__FIRST_NAME__', $list_customer->first_name, $content);

                    $content = str_replace('__LAST_NAME__', $list_customer->last_name, $content);

                    $content = str_replace('__PHONE_NUMBER__', $list_customer->phone_number, $content);

                    $content = str_replace('__EMAIL__', $list_customer->email, $content);



                    $m->setMessageFromString('', $content);

                    if ($ses->sendEmail($m) === false) {

                        $send_fail[] = $this->Customer->get_info($c_ids)->email;

//echo json_encode(array('success'=>false,'message'=>'Không gửi được mail'));
                    } else {

                        $send_success[] = $this->Customer->get_info($c_ids)->email;

                        $this->sale_lib->clear_all();

                        redirect('sales');
                    }
                }
            }

            /* end phan lam mail */
        }

        $this->sale_lib->clear_all();
    }

// phan lam hop dong
    function contract($sale_id) {
        $id_quotes_contract = $this->input->get("contract");
        $data['info_quotes_contract'] = $this->M_quotes_contract->get_info($id_quotes_contract);
        $data['is_sale'] = FALSE;
        $sale_info = $this->Sale->get_info($sale_id)->row_array();
        $this->sale_lib->copy_entire_sale($sale_id);
        $data['cart'] = $this->sale_lib->get_cart();
        $data['payments'] = $this->sale_lib->get_payments();
        $data['subtotal'] = $this->sale_lib->get_subtotal();
        $data['taxes'] = $this->sale_lib->get_taxes($sale_id);
        $data['total'] = $this->sale_lib->get_total($sale_id);
        $data['receipt_title'] = lang('sales_receipt');
        $data['comment'] = $this->Sale->get_comment($sale_id);
        $data['show_comment_on_receipt'] = $this->Sale->get_comment_on_receipt($sale_id);
        $data['transaction_time'] = date(get_date_format() . ' ' . get_time_format(), strtotime($sale_info['sale_time']));
        $customer_id = $this->sale_lib->get_customer();
        $emp_info = $this->Employee->get_info($sale_info['employee_id']);
        $info_empss = $this->Employee->get_info($sale_info['employees_id']);
        $data['payment_type'] = $sale_info['payment_type'];
        $data['amount_change'] = $this->sale_lib->get_amount_due($sale_id) * -1;
        $data['employee'] = $emp_info->first_name . ' ' . $emp_info->last_name;
        $data['phone'] = $emp_info->phone_number;
        $data['email'] = $emp_info->email;
        $data['ref_no'] = $sale_info['cc_ref_no'];
        $this->load->helper('string');
        $data['payment_type'] = str_replace(array('<sup>VNĐ</sup><br />', ''), ' .VNĐ', $sale_info['payment_type']);
        $data['amount_due'] = $this->sale_lib->get_amount_due();
        foreach ($data['payments'] as $payment_id => $payment) {
            $payment_amount = $payment['payment_amount'];
        }
        $k = 28;
        $tongtienhang = 0;
        foreach (array_reverse($data['cart'], true) as $line => $item) {
            $tongtienhang_1 += $item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100;
            $k++;
        }
        $payments_cost = $tongtienhang_1 - $payment_amount;
        if ($customer_id != -1) {
            $cust_info = $this->Customer->get_info($customer_id);
            $data['customer'] = $cust_info->first_name . ' ' . $cust_info->last_name;
            $data['cus_name'] = $cust_info->company_name == '' ? '' : $cust_info->company_name;
            $data['code_tax'] = $cust_info->code_tax;
            $data['address'] = $cust_info->address_1;
            $data['account_number'] = $cust_info->account_number;
            $data['positions'] = $cust_info->positions;
        }
        $data['sale_id'] = $sale_id;
        $cities = $this->City->get_all();
        $word = $this->input->get('hopdongbutton');
        $cat_hopdong = $this->input->get("cat_hopdong");
        $data['word'] = $word;
        $data['cat_hopdong'] = $cat_hopdong;
        if ($word == 0) {
            $this->load->view("sales/report_contract", $data);
        } else {
            $file_name = "HD_" . $sale_id . "_" . str_replace(" ", "", replace_character($data['customer'])) . "_" . date('dmYHis') . ".doc";
            $fp = fopen("excel_materials/" . $file_name, 'w+');
            $arr_item = array();
            $arr_service = array();
            foreach ($data['cart'] as $line => $val) {
                if ($val['item_id']) {
                    $info_item = $this->Item->get_info($val['item_id']);
                    if ($info_item->service == 0) {
                        $arr_item[] = array(
                            'item_id' => $val['item_id'],
                            'line' => $line,
                            'name' => $val['name'],
                            'item_number' => $val['item_number'],
                            'description' => $val['description'],
                            'serialnumber' => $val['serialnumber'],
                            'allow_alt_description' => $val['allow_alt_description'],
                            'is_serialized' => $val['is_serialized'],
                            'quantity' => $val['quantity'],
                            'stored_id' => $val['stored_id'],
                            'discount' => $val['discount'],
                            'price' => $val['price'],
                            'price_rate' => $val['price_rate'],
                            'taxes' => $val['taxes'],
                            'unit' => $val['unit']
                        );
                    } else {
                        $arr_service[] = array(
                            'item_id' => $val['item_id'],
                            'line' => $line,
                            'name' => $val['name'],
                            'item_number' => $val['item_number'],
                            'description' => $val['description'],
                            'serialnumber' => $val['serialnumber'],
                            'allow_alt_description' => $val['allow_alt_description'],
                            'is_serialized' => $val['is_serialized'],
                            'quantity' => $val['quantity'],
                            'stored_id' => $val['stored_id'],
                            'discount' => $val['discount'],
                            'price' => $val['price'],
                            'price_rate' => $val['price_rate'],
                            'taxes' => $val['taxes'],
                            'unit' => $val['unit']
                        );
                    }
                } else {
                    $arr_item[] = array(
                        'pack_id' => $val['pack_id'],
                        'line' => $val['line'],
                        'pack_number' => $val['pack_number'],
                        'name' => $val['name'],
                        'description' => $val['description'],
                        'quantity' => $val['quantity'],
                        'discount' => $val['discount'],
                        'price' => $val['price'],
                        'taxes' => $val['taxes'],
                        'unit' => $val['unit']
                    );
                }
            }
            $str .= "<table style='width: 100%; border-collapse: collapse'>";
            $str .= "<tr>";
            $str .= "<th style='text-align: center; border: 1px solid #000; padding: 8px 0px; width: 5%'>STT</th>";
            $str .= "<th style='text-align: center; border: 1px solid #000; padding: 8px 0px; width: 30%'>Tên hàng</th>";
            $str .= "<th style='text-align: center; border: 1px solid #000; padding: 8px 0px; width: 5%'>ĐVT</th>";
            $str .= "<th style='text-align: center; border: 1px solid #000; padding: 8px 0px; width: 8%'>SL</th>";
            $str .= "<th style='text-align: center; border: 1px solid #000; padding: 8px 0px; width: 14%'>Đơn giá</th>";
            $str .= "<th style='text-align: center; border: 1px solid #000; padding: 8px 0px; width: 14%'>CK(%)</th>";
            $str .= "<th style='text-align: center; border: 1px solid #000; padding: 8px 0px; width: 14%'>Thuế(%)</th>";
            $str .= "<th style='text-align: center; border: 1px solid #000; padding: 8px 0px; width: 14%'>Thành tiền</th>";
            $str .= "</tr>";

            $stt = 1;
            $total = 0;
            if ($cat_hopdong == 1) {
                foreach ($arr_item as $line => $item) {
                    if ($item['pack_id']) {
                        $info_pack = $this->Pack->get_info($item['pack_id']);
                        $pack_item = $this->Pack_items->get_info($item['pack_id']);
                        $info_sale_pack = $this->Sale->get_sale_pack_by_sale_pack($sale_id, $item['pack_id']);
                        $info_unit = $this->Unit->get_info($info_sale_pack->unit_pack);
                        $thanh_tien = $item['quantity'] * $item['price'] - $item['quantity'] * $item['price'] * $item['discount'] / 100 + ($item['quantity'] * $item['price'] - $item['quantity'] * $item['price'] * $item['discount'] / 100) * $item['taxes'] / 100;
                        $str .= "<tr>";
                        $str .= "<td style='text-align: center; border: 1px solid #000000; padding: 10px 5px'>" . $stt . "</td>";
                        $str .= "<td style='border: 1px solid #000000; padding: 10px 5px'>";
                        $str .= "<strong>" . $info_pack->pack_number . "/" . $info_pack->name . "(Gói SP)</strong><br>";
                        foreach ($pack_item as $val) {
                            $info_item = $this->Item->get_info($val->item_id);
                            $str .= "<p>- <strong>" . $info_item->item_number . "</strong>/" . $info_item->name . "</p>";
                        }

                        $str .= "</td>";
                        $str .= "<td style='border: 1px solid #000000; padding: 10px 5px'>" . $info_unit->name . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . format_quantity($item['quantity']) . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($item['price']) . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($item['discount']) . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($item['taxes']) . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($thanh_tien) . "</td>";
                        $str .= "</tr>";
                        $total += $thanh_tien;
                    } else {
                        $info_item = $this->Item->get_info($item['item_id']);
                        $info_sale_item = $this->Sale->get_sale_item_by_sale_item($sale_id, $item['item_id']);
                        $info_unit = $this->Unit->get_info($info_sale_item->unit_item);
                        $thanh_tien = $item['quantity'] * ($item['unit'] == 'unit_from' ? $item['price_rate'] : $item['price']) - $item['quantity'] * ($item['unit'] == 'unit_from' ? $item['price_rate'] : $item['price']) * $item['discount'] / 100 + ($item['quantity'] * ($item['unit'] == 'unit_from' ? $item['price_rate'] : $item['price']) - $item['quantity'] * ($item['unit'] == 'unit_from' ? $item['price_rate'] : $item['price']) * $item['discount'] / 100) * $item['taxes'] / 100;
                        $str .= "<tr>";
                        $str .= "<td style='text-align: center; border: 1px solid #000000; padding: 10px 5px'>" . $stt . "</td>";
                        $str .= "<td style='border: 1px solid #000000; padding: 10px 5px'><strong>" . $info_item->item_number . "</strong>/" . $info_item->name . "</td>";
                        $str .= "<td style='border: 1px solid #000000; padding: 10px 5px'>" . $info_unit->name . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . format_quantity($item['quantity']) . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format(($item['unit'] == 'unit_from' ? $item['price_rate'] : $item['price'])) . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($item['discount']) . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($item['taxes']) . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($thanh_tien) . "</td>";
                        $str .= "</tr>";
                        $total += $thanh_tien;
                    }
                    $stt++;
                }
            } else if ($cat_hopdong == 2) {
                foreach ($arr_service as $line => $item) {
                    $info_item = $this->Item->get_info($item['item_id']);
                    $info_sale_item = $this->Sale->get_sale_item_by_sale_item($sale_id, $item['item_id']);
                    $info_unit = $this->Unit->get_info($info_sale_item->unit_item);
                    $thanh_tien = $item['quantity'] * $item['price'] - $item['quantity'] * $item['price'] * $item['discount'] / 100 + ($item['quantity'] * $item['price'] - $item['quantity'] * $item['price'] * $item['discount'] / 100) * $item['taxes'] / 100;
                    $str .= "<tr>";
                    $str .= "<td style='text-align: center; border: 1px solid #000000; padding: 10px 5px'>" . $stt . "</td>";
                    $str .= "<td style='border: 1px solid #000000; padding: 10px 5px'><strong>" . $info_item->item_number . "</strong>/" . $info_item->name . "</td>";
                    $str .= "<td style='border: 1px solid #000000; padding: 10px 5px'>" . $info_unit->name . "</td>";
                    $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . format_quantity($item['quantity']) . "</td>";
                    $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($item['price']) . "</td>";
                    $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($item['discount']) . "</td>";
                    $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($item['taxes']) . "</td>";
                    $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($thanh_tien) . "</td>";
                    $str .= "</tr>";
                    $total += $thanh_tien;
                    $stt++;
                }
            } else {
                foreach ($data['cart'] as $line => $item) {
                    if ($item['pack_id']) {
                        $info_pack = $this->Pack->get_info($item['pack_id']);
                        $pack_item = $this->Pack_items->get_info($item['pack_id']);
                        $info_sale_pack = $this->Sale->get_sale_pack_by_sale_pack($sale_id, $item['pack_id']);
                        $info_unit = $this->Unit->get_info($info_sale_pack->unit_pack);
                        $thanh_tien = $item['quantity'] * $item['price'] - $item['quantity'] * $item['price'] * $item['discount'] / 100 + ($item['quantity'] * $item['price'] - $item['quantity'] * $item['price'] * $item['discount'] / 100) * $item['taxes'] / 100;
                        $str .= "<tr>";
                        $str .= "<td style='text-align: center; border: 1px solid #000000; padding: 10px 5px'>" . $stt . "</td>";
                        $str .= "<td style='border: 1px solid #000000; padding: 10px 5px'>";
                        $str .= "<strong>" . $info_pack->pack_number . "/" . $info_pack->name . "(Gói SP)</strong><br>";
                        foreach ($pack_item as $val) {
                            $info_item = $this->Item->get_info($val->item_id);
                            $str .= "<p>- <strong>" . $info_item->item_number . "</strong>/" . $info_item->name . "</p>";
                        }

                        $str .= "</td>";
                        $str .= "<td style='border: 1px solid #000000; padding: 10px 5px'>" . $info_unit->name . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . format_quantity($item['quantity']) . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($item['price']) . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($item['discount']) . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($item['taxes']) . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($thanh_tien) . "</td>";
                        $str .= "</tr>";
                        $total += $thanh_tien;
                    } else {
                        $info_item = $this->Item->get_info($item['item_id']);
                        $info_sale_item = $this->Sale->get_sale_item_by_sale_item($sale_id, $item['item_id']);
                        $info_unit = $this->Unit->get_info($info_sale_item->unit_item);
                        $thanh_tien = $item['quantity'] * ($item['unit'] == 'unit_from' ? $item['price_rate'] : $item['price']) - $item['quantity'] * ($item['unit'] == 'unit_from' ? $item['price_rate'] : $item['price']) * $item['discount'] / 100 + ($item['quantity'] * ($item['unit'] == 'unit_from' ? $item['price_rate'] : $item['price']) - $item['quantity'] * ($item['unit'] == 'unit_from' ? $item['price_rate'] : $item['price']) * $item['discount'] / 100) * $item['taxes'] / 100;
                        $str .= "<tr>";
                        $str .= "<td style='text-align: center; border: 1px solid #000000; padding: 10px 5px'>" . $stt . "</td>";
                        $str .= "<td style='border: 1px solid #000000; padding: 10px 5px'><strong>" . $info_item->item_number . "</strong>/" . $info_item->name . "</td>";
                        $str .= "<td style='border: 1px solid #000000; padding: 10px 5px'>" . $info_unit->name . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . format_quantity($item['quantity']) . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format(($item['unit'] == 'unit_from' ? $item['price_rate'] : $item['price'])) . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($item['discount']) . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($item['taxes']) . "</td>";
                        $str .= "<td style='text-align: right; border: 1px solid #000000; padding: 10px 5px'>" . number_format($thanh_tien) . "</td>";
                        $str .= "</tr>";
                        $total += $thanh_tien;
                    }
                    $stt++;
                }
            }
            $str .= "<tr>";
            $str .= "<td colspan='3' style='text-align: center; font-weight: bold; border: 1px solid #000000; padding: 10px 5px'>Tổng</td>";
            $str .= "<td colspan='5' style='text-align: right; font-weight: bold; border: 1px solid #000000; padding: 10px 5px'>" . number_format($total) . "</td>";
            $str .= "</tr>";
            $str .= "</table>";
            $str .= "<p>Tổng giá trị (Bằng chữ): <strong><em>" . $this->Cost->get_string_number($total) . "</em></strong></p>";
            $content1 = "<html>";
            $content1 .= "<meta charset='utf-8'/>";
            $content1 .= "<body style='font-size: 100% !important'>";
            $content1 .= $data['info_quotes_contract']->content_quotes_contract;
            $content1 .= "</body>";
            $content1 .= "</html>";
            $info_sale = $this->Sale->get_info_sale_order($sale_id);
            $d = $info_sale->date_debt != '0000-00-00' ? date('d', strtotime($info_sale->date_debt)) : '...';
            $m = $info_sale->date_debt != '0000-00-00' ? date('m', strtotime($info_sale->date_debt)) : '...';
            $y = $info_sale->date_debt != '0000-00-00' ? date('Y', strtotime($info_sale->date_debt)) : '...';
            $content1 = str_replace('{TITLE}', $data['info_quotes_contract']->title_quotes_contract, $content1);
            $content1 = str_replace('{TABLE_DATA}', $str, $content1);
            $content1 = str_replace('{LOGO}', "<img src='" . base_url('images/logoreport/' . $this->config->item('report_logo')) . "'/>", $content1);
            $content1 = str_replace('{TEN_NCC}', $this->config->item('company'), $content1);
            $content1 = str_replace('{DIA_CHI_NCC}', $this->config->item('address'), $content1);
            $content1 = str_replace('{SDT_NCC}', $this->config->item('phone'), $content1);
            $content1 = str_replace('{DD_NCC}', $this->config->item('corp_master_account'), $content1);
            $content1 = str_replace('{CHUCVU_NCC}', '', $content1);
            $content1 = str_replace('{TKNH_NCC}', $this->config->item('corp_number_account'), $content1);
            $content1 = str_replace('{NH_NCC}', $this->config->item('corp_bank_name'), $content1);
            $content1 = str_replace('{TEN_KH}', $data['cus_name'], $content1);
            $content1 = str_replace('{DIA_CHI_KH}', $data['address'], $content1);
            $content1 = str_replace('{SDT_KH}', '', $content1);
            $content1 = str_replace('{DD_KH}', $data['customer'], $content1);
            $content1 = str_replace('{CHUCVU_KH}', $data['positions'], $content1);
            $content1 = str_replace('{TKNH_KH}', $data['code_tax'], $content1);
            $content1 = str_replace('{NH_KH}', '', $content1);
            $content1 = str_replace('{CODE}', $sale_id, $content1);
            $content1 = str_replace('{DATE}', $d, $content1);
            $content1 = str_replace('{MONTH}', $m, $content1);
            $content1 = str_replace('{YEAR}', $y, $content1);
            fwrite($fp, $content1);
            fclose($fp);
            /* phan lam mail */
            $cust_info = $this->Customer->get_info($customer_id);
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
            $this->email->to($cust_info->email);
            $this->email->subject($this->config->item('company') . " xin chân trọng gửi tới quý khách hợp đồng");
            $content = "<p>Dear anh/chị:" . $data['customer'] . "</p>";
            $content .= "<p>Dựa vào nhu cầu của Quý khách hàng.</p>";
            $content .= "<p><b>" . $this->config->item('company') . "</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p>";
            $content .= "<p>Xin vui lòng xem ở file đính kèm</p>";
            $content .= "<p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: " . $this->config->item("phone") . "</i></p>";
            $content .= "<i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i>";
            $content .= "<p>-----</p>";
            $content .= "<p><i>Thanks and Regards!</i></p>";
            $content .= "<p><i>" . $data['employee'] . "</i></p>";
            $content .= "<p>Mobile: " . $data['phone'] . "</p>";
            $content .= "<p>Email: " . $data['email'] . "</p>";

            $content .= "------------------------------------------------------------------------";
            $content .= "<img src='" . base_url() . "images/logoreport/11.png'>";
            $content .= "<p style='text-transform: uppercase;'>" . $this->config->item("company") . "</p>";
            $content .= "<p>Rep Off  :" . $this->config->item('address') . "</p>";
            $content .= "<p>Email    :" . $this->config->item('email') . "</p>";
            $content .= "<p>Tel      :" . $this->config->item('phone') . " | Fax: " . $this->config->item('fax') . "</p>";
            $content .= "<p>Web      :" . $this->config->item('website') . "</p>";
            $this->email->message($content);
            $file = APPPATH . "/../excel_materials/" . $file_name;
            $this->email->attach($file);
            if ($this->email->send()) {
                $send_success[] = $cust_info->email;
                $data_history = array(
                    'person_id' => $customer_id,
                    'employee_id' => $this->session->userdata('person_id'),
                    'title' => 'Hợp đồng',
                    'content' => $content,
                    'time' => date('Y-m-d H:i:s'),
                    'file' => $file_name,
                    'status' => 1,
                );
                $this->Customer->add_mail_history($data_history);
                $this->sale_lib->clear_all();
                redirect('sales');
            } else {
                $send_fail[] = $cust_info->email;
                $data_history = array(
                    'person_id' => $customer_id,
                    'employee_id' => $this->session->userdata('person_id'),
                    'title' => 'Hợp đồng',
                    'content' => $content,
                    'time' => date('Y-m-d H:i:s'),
                    'file' => $file_name,
                    'status' => 0,
                );
                $this->Customer->add_mail_history($data_history);
                show_error($this->email->print_debugger());
            }
            /* end phan lam mail */
        }
        $this->sale_lib->clear_all();
    }

    function contract1($sale_id) {
        $data['is_sale'] = FALSE;

        $sale_info = $this->Sale->get_info($sale_id)->row_array();

        $this->sale_lib->copy_entire_sale($sale_id);

        $data['cart'] = $this->sale_lib->get_cart();

        $data['payments'] = $this->sale_lib->get_payments();

        $data['subtotal'] = $this->sale_lib->get_subtotal();

        $data['taxes'] = $this->sale_lib->get_taxes($sale_id);

        $data['total'] = $this->sale_lib->get_total($sale_id);

        $data['receipt_title'] = lang('sales_receipt');

        $data['comment'] = $this->Sale->get_comment($sale_id);

        $data['show_comment_on_receipt'] = $this->Sale->get_comment_on_receipt($sale_id);

        $data['transaction_time'] = date(get_date_format() . ' ' . get_time_format(), strtotime($sale_info['sale_time']));

        $customer_id = $this->sale_lib->get_customer();

        $emp_info = $this->Employee->get_info($sale_info['employee_id']);

        $data['payment_type'] = $sale_info['payment_type'];

        $data['amount_change'] = $this->sale_lib->get_amount_due($sale_id) * -1;

        $data['employee'] = $emp_info->first_name . ' ' . $emp_info->last_name;

        $data['ref_no'] = $sale_info['cc_ref_no'];

        $this->load->helper('string');

        $data['payment_type'] = str_replace(array('<sup>VNĐ</sup><br />', ''), ' .VNĐ', $sale_info['payment_type']);

        $data['amount_due'] = $this->sale_lib->get_amount_due();

        foreach ($data['payments'] as $payment_id => $payment) {

            $payment_amount = $payment['payment_amount'];
        }

        $k = 28;

        $tongtienhang = 0;

        foreach (array_reverse($data['cart'], true) as $line => $item) {

            $tongtienhang_1 += $item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100;

            $k++;
        }

        $payments_cost = $tongtienhang_1 - $payment_amount;

        if ($customer_id != -1) {

            $cust_info = $this->Customer->get_info($customer_id);

            $data['customer'] = $cust_info->first_name . ' ' . $cust_info->last_name;

            $data['cus_name'] = $cust_info->company_name == '' ? '' : $cust_info->company_name;

            $data['code_tax'] = $cust_info->code_tax;

            $data['address'] = $cust_info->address_1;

            $data['account_number'] = $cust_info->account_number;
        }

        $data['sale_id'] = 'VH ' . $sale_id;

// $this->load->view("sales/receipt",$data);
// $this->sale_lib->clear_all();

        $cities = $this->City->get_all();

        $excel = $this->input->get('hopdongbutton');


        if ($excel == 1) {

            require_once APPPATH . "/third_party/Classes/export_contract_in.php";
        } elseif ($excel == 2) {
            require_once APPPATH . "/third_party/Classes/export_contract_may.php";
        } elseif ($excel == 3) {
            require_once APPPATH . "/third_party/Classes/export_contract_bang.php";
        } else {

            /* phan lam mail */
            $customer_ids = array($customer_id);
            $mail_id = $this->input->post('mail_id');
            $mail_info = $this->Customer->get_info_mail($mail_id);
            $ses = new SimpleEmailService($this->config->item('amazon_access_key'), $this->config->item('amazon_secret_key'));
            $ses->enableVerifyHost(false);
            $ses->enableVerifyPeer(false);
//get list_email of customer from multi ids
            $list_customer_email = array();
            $send_success = array();
            $send_fail = array();
            foreach ($customer_ids as $c_ids) {
                if ($this->Customer->get_info($c_ids)->email != '') {
                    $list_customer_email[] = $this->Customer->get_info($c_ids)->email;
                    $list_customer = $this->Customer->get_info($c_ids);
                    $m = new SimpleEmailServiceMessage();
                    $m->setFrom('gs.daycon@gmail.com');
//set mail title
                    $m->setSubject("Công ty " . $this->config->item('company') . " xin chân trọng gửi tới quý khách " . $list_customer->first_name . " thư hợp đồng");
                    $m->addTo($this->Customer->get_info($c_ids)->email);
                    $m->addCC($this->config->item('email'));
//set mall content
                    $content = $this->load->view('sales/contract', $data, true);
                    $content = str_replace('__FIRST_NAME__', $list_customer->first_name, $content);
                    $content = str_replace('__LAST_NAME__', $list_customer->last_name, $content);
                    $content = str_replace('__PHONE_NUMBER__', $list_customer->phone_number, $content);
                    $content = str_replace('__EMAIL__', $list_customer->email, $content);
                    $m->setMessageFromString('', $content);
                    if ($ses->sendEmail($m) === false) {
                        $send_fail[] = $this->Customer->get_info($c_ids)->email;
//echo json_encode(array('success'=>false,'message'=>'Không gửi được mail'));
                    } else {
                        $send_success[] = $this->Customer->get_info($c_ids)->email;
                        $this->sale_lib->clear_all();
                        redirect('sales');
                    }
                }
            }
            /* end phan lam mail */
        }
        $this->sale_lib->clear_all();
    }

// phan lam biên bản
    function bienban($sale_id) {
        $data['is_sale'] = FALSE;

        $sale_info = $this->Sale->get_info($sale_id)->row_array();
        $this->sale_lib->copy_entire_sale($sale_id);
        $data['cart'] = $this->sale_lib->get_cart();
        $data['payments']  = $this->sale_lib->get_payments();
        $data['subtotal'] = $this->sale_lib->get_subtotal();
        $data['taxes'] = $this->sale_lib->get_taxes($sale_id);
        $data['total'] = $this->sale_lib->get_total($sale_id);
        $data['receipt_title'] = lang('sales_receipt');
        $data['comment'] = $this->Sale->get_comment($sale_id);
        $data['show_comment_on_receipt'] = $this->Sale->get_comment_on_receipt($sale_id);
        $data['transaction_time'] = date(get_date_format() . ' ' . get_time_format(), strtotime($sale_info['sale_time']));
        $customer_id = $this->sale_lib->get_customer();
        $emp_info = $this->Employee->get_info($sale_info['employee_id']);
        $data['payment_type'] = $sale_info['payment_type'];
        $data['amount_change'] = $this->sale_lib->get_amount_due($sale_id) * -1;
        $data['employee'] = $emp_info->first_name . ' ' . $emp_info->last_name;
        $data['ref_no'] = $sale_info['cc_ref_no'];
        $this->load->helper('string');
        $data['payment_type'] = str_replace(array('<sup>VNĐ</sup><br />', ''), ' .VNĐ', $sale_info['payment_type']);
        $data['amount_due'] = $this->sale_lib->get_amount_due();
        foreach ($data['payments'] as $payment_id => $payment) {
            $payment_amount = $payment['payment_amount'];
        }
        $k = 28;
        $tongtienhang = 0;
        foreach (array_reverse($data['cart'], true) as $line => $item) {
            $tongtienhang_1 += $item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100;
            $k++;
        }
        $payments_cost = $tongtienhang_1 - $payment_amount;
        if ($customer_id != -1) {
            $cust_info = $this->Customer->get_info($customer_id);
            $data['customer'] = $cust_info->first_name . ' ' . $cust_info->last_name;
            $data['cus_name'] = $cust_info->company_name == '' ? '' : $cust_info->company_name;
            $data['code_tax'] = $cust_info->code_tax;
            $data['address'] = $cust_info->address_1;
            $data['account_number'] = $cust_info->account_number;
            $data['code_tax'] = $cust_info->code_tax;
            $data['positions'] = $cust_info->positions;
        }
        $data['sale_id'] = 'VH ' . $sale_id;
// $this->load->view("sales/receipt",$data);
// $this->sale_lib->clear_all();
        $cities = $this->City->get_all();
// $excel = $this->input->get('hopdongbutton');
// if ($excel == 1){
        require_once APPPATH . "/third_party/Classes/export_nghiemthu.php";
//  }
// else {
        /* phan lam mail */
        $customer_ids = array($customer_id);

        $mail_id = $this->input->post('mail_id');
        $mail_info = $this->Customer->get_info_mail($mail_id);


        $ses = new SimpleEmailService($this->config->item('amazon_access_key'), $this->config->item('amazon_secret_key'));
        $ses->enableVerifyHost(false);
        $ses->enableVerifyPeer(false);

//get list_email of customer from multi ids
        $list_customer_email = array();
        $send_success = array();
        $send_fail = array();

        foreach ($customer_ids as $c_ids) {
            if ($this->Customer->get_info($c_ids)->email != '') {
                $list_customer_email[] = $this->Customer->get_info($c_ids)->email;
                $list_customer = $this->Customer->get_info($c_ids);

                $m = new SimpleEmailServiceMessage();
                $m->setFrom('gs.daycon@gmail.com');
//set mail title
                $m->setSubject("Công ty " . $this->config->item('company') . " xin chân trọng gửi tới quý khách " . $list_customer->first_name . " thư hợp đồng");
                $m->addTo($this->Customer->get_info($c_ids)->email);
                $m->addCC($this->config->item('email'));

//set mall content
                $content = $this->load->view('sales/contract', $data, true);
                $content = str_replace('__FIRST_NAME__', $list_customer->first_name, $content);
                $content = str_replace('__LAST_NAME__', $list_customer->last_name, $content);
                $content = str_replace('__PHONE_NUMBER__', $list_customer->phone_number, $content);
                $content = str_replace('__EMAIL__', $list_customer->email, $content);

                $m->setMessageFromString('', $content);
                if ($ses->sendEmail($m) === false) {
                    $send_fail[] = $this->Customer->get_info($c_ids)->email;
//echo json_encode(array('success'=>false,'message'=>'Không gửi được mail'));
                } else {
                    $send_success[] = $this->Customer->get_info($c_ids)->email;
                    $this->sale_lib->clear_all();
                    redirect('sales');
                }
            }
//  }
            /* end phan lam mail */
        }
        $this->sale_lib->clear_all();
    }

// phan lam thanh lý hợp đồng
    function thanhly($sale_id) {
        $data['is_sale'] = FALSE;

        $sale_info = $this->Sale->get_info($sale_id)->row_array();
        $this->sale_lib->copy_entire_sale($sale_id);
        $data['cart'] = $this->sale_lib->get_cart();
        $data['payments'] = $this->sale_lib->get_payments();
        $data['subtotal'] = $this->sale_lib->get_subtotal();
        $data['taxes'] = $this->sale_lib->get_taxes($sale_id);
        $data['total'] = $this->sale_lib->get_total($sale_id);
        $data['receipt_title'] = lang('sales_receipt');
        $data['comment'] = $this->Sale->get_comment($sale_id);
        $data['show_comment_on_receipt'] = $this->Sale->get_comment_on_receipt($sale_id);
        $data['transaction_time'] = date(get_date_format() . ' ' . get_time_format(), strtotime($sale_info['sale_time']));
        $customer_id = $this->sale_lib->get_customer();
        $emp_info = $this->Employee->get_info($sale_info['employee_id']);
        $data['payment_type'] = $sale_info['payment_type'];
        $data['amount_change'] = $this->sale_lib->get_amount_due($sale_id) * -1;
        $data['employee'] = $emp_info->first_name . ' ' . $emp_info->last_name;
        $data['ref_no'] = $sale_info['cc_ref_no'];
        $this->load->helper('string');
        $data['payment_type'] = str_replace(array('<sup>VNĐ</sup><br />', ''), ' .VNĐ', $sale_info['payment_type']);
        $data['amount_due'] = $this->sale_lib->get_amount_due();
        foreach ($data['payments'] as $payment_id => $payment) {
            $payment_amount = $payment['payment_amount'];
        }
        $k = 28;
        $tongtienhang = 0;
        foreach (array_reverse($data['cart'], true) as $line => $item) {
            $tongtienhang_1 += $item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100;
            $k++;
        }
        $payments_cost = $tongtienhang_1 - $payment_amount;
        if ($customer_id != -1) {
            $cust_info = $this->Customer->get_info($customer_id);
            $data['customer'] = $cust_info->first_name . ' ' . $cust_info->last_name;
            $data['cus_name'] = $cust_info->company_name == '' ? '' : $cust_info->company_name;
            $data['code_tax'] = $cust_info->code_tax;
            $data['address'] = $cust_info->address_1;
            $data['account_number'] = $cust_info->account_number;
            $data['code_tax'] = $cust_info->code_tax;
            $data['positions'] = $cust_info->positions;
        }
        $data['sale_id'] = 'VH ' . $sale_id;
// $this->load->view("sales/receipt",$data);
// $this->sale_lib->clear_all();
        $cities = $this->City->get_all();
        require_once APPPATH . "/third_party/Classes/export_thanhly.php";
        $this->sale_lib->clear_all();
    }

// phan lam đề nghị thanh toán
    function thanhtoan($sale_id) {
        $data['is_sale'] = FALSE;

        $sale_info = $this->Sale->get_info($sale_id)->row_array();
        $this->sale_lib->copy_entire_sale($sale_id);
        $data['cart'] = $this->sale_lib->get_cart();
        $data['payments'] = $this->sale_lib->get_payments();
        $data['subtotal'] = $this->sale_lib->get_subtotal();
        $data['taxes'] = $this->sale_lib->get_taxes($sale_id);
        $data['total'] = $this->sale_lib->get_total($sale_id);
        $data['receipt_title'] = lang('sales_receipt');
        $data['comment'] = $this->Sale->get_comment($sale_id);
        $data['show_comment_on_receipt'] = $this->Sale->get_comment_on_receipt($sale_id);
        $data['transaction_time'] = date(get_date_format() . ' ' . get_time_format(), strtotime($sale_info['sale_time']));
        $customer_id = $this->sale_lib->get_customer();
        $emp_info = $this->Employee->get_info($sale_info['employee_id']);
        $data['payment_type'] = $sale_info['payment_type'];
        $data['amount_change'] = $this->sale_lib->get_amount_due($sale_id) * -1;
        $data['employee'] = $emp_info->first_name . ' ' . $emp_info->last_name;
        $data['ref_no'] = $sale_info['cc_ref_no'];
        $this->load->helper('string');
        $data['payment_type'] = str_replace(array('<sup>VNĐ</sup><br />', ''), ' .VNĐ', $sale_info['payment_type']);
        $data['amount_due'] = $this->sale_lib->get_amount_due();
        foreach ($data['payments'] as $payment_id => $payment) {
            $payment_amount = $payment['payment_amount'];
        }
        $k = 28;
        $tongtienhang = 0;
        foreach (array_reverse($data['cart'], true) as $line => $item) {
            $tongtienhang_1 += $item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100;
            $k++;
        }
        $payments_cost = $tongtienhang_1 - $payment_amount;
        if ($customer_id != -1) {
            $cust_info = $this->Customer->get_info($customer_id);
            $data['customer'] = $cust_info->first_name . ' ' . $cust_info->last_name;
            $data['cus_name'] = $cust_info->company_name == '' ? '' : $cust_info->company_name;
            $data['code_tax'] = $cust_info->code_tax;
            $data['address'] = $cust_info->address_1;
            $data['account_number'] = $cust_info->account_number;
            $data['code_tax'] = $cust_info->code_tax;
            $data['positions'] = $cust_info->positions;
        }
        $data['sale_id'] = 'VH ' . $sale_id;
// $this->load->view("sales/receipt",$data);
// $this->sale_lib->clear_all();
        $cities = $this->City->get_all();
        require_once APPPATH . "/third_party/Classes/export_thanhtoan.php";
        $this->sale_lib->clear_all();
    }

    function hoihang($sale_id) {
        $data['is_sale'] = FALSE;

        $suppliers = array();

        $sale_items = $this->Sale->get_sale_items($sale_id)->result_array();


        foreach ($sale_items as $sale_item) {

            $suppliers[$sale_item['item_id']] = $this->Item->get_info($sale_item['item_id'])->supplier_id;
        }


        /* phan lam mail */

        $mail_id = $this->input->post('mail_id');

        $mail_info = $this->Customer->get_info_mail($mail_id);

        $ses = new SimpleEmailService($this->config->item('amazon_access_key'), $this->config->item('amazon_secret_key'));


        $ses->enableVerifyHost(false);

        $ses->enableVerifyPeer(false);

//get list_email of customer from multi ids
// $list_customer_email = array();

        $send_success = array();

        $send_fail = array();

        foreach ($suppliers as $id_item => $id_supplier) {

            if ($this->Supplier->get_info($id_supplier)->email != '') {

//  $list_customer_email[] = $this->Supplier->get_info($id_supplier)->email;

                $m = new SimpleEmailServiceMessage();

                $m->setFrom('gs.daycon@gmail.com');

//set mail title

                $m->setSubject("Công ty " . $this->config->item('company') . " xin chân trọng gửi tới nhà cung cấp " . $list_customer->first_name . " thư hỏi hàng");

                $m->addTo($this->Supplier->get_info($id_supplier)->email);

                $m->addCC($this->config->item('email'));

                $data['item'] = $this->Item->get_info($id_item)->name;

//set mall content

                $content = $this->load->view('sales/hoihang', $data, true);

                $m->setMessageFromString('', $content);

                if ($ses->sendEmail($m) === false) {

                    $send_fail[] = $this->Customer->get_info($c_ids)->email;

//echo json_encode(array('success'=>false,'message'=>'Không gửi được mail'));
                } else {

                    $send_success[] = $this->Customer->get_info($c_ids)->email;
                }
            }
        }

        /* end phan lam mail */

        redirect('sales');
    }

// end lam bao gia hop dong

    function complete() {
        $data['is_sale'] = TRUE;
        $mode = $this->sale_lib->get_mode();
        $data['mode'] = $mode;
        $data['cart'] = $this->sale_lib->get_cart();

        $data['subtotal'] = $this->sale_lib->get_subtotal();

        $data['taxes'] = $this->sale_lib->get_taxes();

        $data['total'] = $this->sale_lib->get_total();

        $data['receipt_title'] = 'Hóa Đơn Bán Hàng';

        $data['transaction_time'] = $this->sale_lib->get_date_debt();

        $customer_id = $this->sale_lib->get_customer();

        $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;

        $data['comment'] = $this->input->post("comment");
        $data['employees_id'] = $this->sale_lib->get_employees_id();

        $data['delivery_employee'] = $this->sale_lib->get_employees_delivery();

        $data['show_comment_on_receipt'] = $this->sale_lib->get_comment_on_receipt();

        $emp_info = $this->Employee->get_info($employee_id);

        $data['payments'] = $this->sale_lib->get_payments();

        $data['amount_change'] = $this->sale_lib->get_amount_due() * -1;
        $data['amount_due'] = $this->sale_lib->get_amount_due();

        $data['employee'] = $emp_info->first_name . ' ' . $emp_info->last_name;

        $data['store'] = $this->sale_lib->get_store();

        $data['address'] = $emp_info->address_1;

        $data['ref_no'] = $this->session->flashdata('ref_no') ? $this->session->flashdata('ref_no') : '';

        $data['item_info'] = $this->Item->get_info($item_id);

        $data['total_order'] = $this->sale_lib->get_total_order_of_item();
        $data['total_discount'] = $this->sale_lib->get_total_discount_of_item();
        $data['total_taxes'] = $this->sale_lib->get_total_taxes();

         $symbol_order = $this->sale_lib->get_symbol_order();
        $number_order = $this->sale_lib->get_number_order();

        $date_debt1 = $this->sale_lib->get_date_debt1();
        $co_1331 = 1331;
        $co_1331_money = $this->sale_lib->get_total_taxes();

        $no_131 = 131;
        $no_131_money = $this->sale_lib->get_total_taxes()+ $this->sale_lib->get_total_order_of_item();

         $load_account = $this->sale_lib->get_load_account();
        $bank_account = $this->sale_lib->get_bank_account();
        if ($customer_id != -1) {

            $cust_info = $this->Customer->get_info($customer_id);

            $data['customer'] = $cust_info->first_name . ' ' . $cust_info->last_name;

            $data['cus_name'] = $cust_info->company_name == '' ? '' : ($cust_info->company_name);

            $data['account_number'] = $cust_info->account_number;

            $data['tax_code'] = $cust_info->tax_code;

            $data['address1'] = $cust_info->address_1;
        }

//SAVE sale to database
        $data['discount_money'] = $this->sale_lib->get_discount_money();
        $total_taxes_percent = 0;
        foreach ($data['cart'] as $item) {
            if ($item['unit'] == 'unit') {
                $total_taxes_percent += $item['taxes'] * ($item['price'] * $item['quantity'] - $item['discount'] * $item['price'] * $item['quantity'] / 100) / 100;
            } else {
                $total_taxes_percent += $item['taxes'] * ($item['price_rate'] * $item['quantity'] - $item['discount'] * $item['price_rate'] * $item['quantity'] / 100) / 100;
            }
        }
        $total_owe = 0;
        foreach ($data['payments'] as $payment) {
            $total_owe += $payment['payment_amount'] + $payment['discount_money'];
        }
        $data['amount_due1'] = $data['total_order'] + $total_taxes_percent - $total_owe;
        $later_cost_price = $data['total_order'] + $total_taxes_percent - $discount_money;
        $actual_money = $later_cost_price;
        if ($this->sale_lib->get_suspended_sale_id() != '') {
            $stt = 1;
            $data['sale_id'] = $this->Sale->save($data['cart'], $customer_id, $employee_id, $data['comment'], $data['employees_id'], $data['show_comment_on_receipt'], $data['payments'], $data['discount_money'], $later_cost_price, $actual_money, $data['amount_due'], $data['amount_due1'], $this->sale_lib->get_suspended_sale_id(), 0, 0, $stt, $data['transaction_time'],$data['ref_no'], $mode, $data['delivery_employee'], $bank_account,$symbol_order,$number_order ,$date_debt1, $co_1331, $co_1331_money, $no_131, $no_131_money);
        } else {
            $stt = 0;
            $data['sale_id'] = $this->Sale->save($data['cart'], $customer_id, $employee_id, $data['comment'], $data['employees_id'], $data['show_comment_on_receipt'], $data['payments'], $data['discount_money'], $later_cost_price, $actual_money, $data['amount_due'], $data['amount_due1'], $this->sale_lib->get_suspended_sale_id(), 0, 0, $stt, $data['transaction_time'],$data['ref_no'], $mode, $data['delivery_employee'], $bank_account,$symbol_order,$number_order ,$date_debt1, $co_1331, $co_1331_money, $no_131, $no_131_money);
        }

//lay ten nv giao hang
        $sale_info1 = $this->Sale->get_info($data['sale_id'])->row_array();
        $info_empss1 = $this->Employee->get_info($sale_info1['delivery_employee']);
        $data['delivery_employee1'] = $info_empss1->first_name . ' ' . $info_empss1->last_name;
       //tổng nợ cũ-----------------------------------------------------------------------------------------------------------
            $data['congno'] = $this->Sale->get_money_sale($customer_id);
            $data['no'] = $this->Inventory->cost_customer($customer_id);
            //end tổng nợ ---------------------------------------------------------------------------------------------------------
        if ($data['sale_id'] == 'VH -1') {

            $data['error_message'] = lang('sales_transaction_failed');
        } else {

            if ($this->sale_lib->get_email_receipt() && !empty($cust_info->email)) {

                $this->load->library('email');

                $config['mailtype'] = 'html';

                $this->email->initialize($config);

                $this->email->from($this->config->item('email'), $this->config->item('company'));

                $this->email->to($cust_info->email);

                $this->email->subject(lang('sales_receipt'));

                $this->email->message($this->load->view("sales/receipt_email", $data, true));

                $this->email->send();
            }
        }
        if ($this->config->item('print_excel') == 'print') {
            $this->load->view("sales/receipt", $data);
            $this->sale_lib->clear_all();
        } else if ($this->config->item('print_excel') == 'print_a5') {
            $this->load->view("sales/receipt_a5", $data);
            $this->sale_lib->clear_all();
        } else {
            $this->sale_lib->clear_all();
            require_once APPPATH . "/third_party/Classes/export_receipt.php";
            redirect('sales');
            $this->sale_lib->clear_all();
            $this->_reload();
        }
    }

    function email_receipt($sale_id) {
        $sale_info = $this->Sale->get_info($sale_id)->row_array();
        $this->sale_lib->copy_entire_sale($sale_id);
        $data['cart'] = $this->sale_lib->get_cart();
        $data['payments'] = $this->sale_lib->get_payments();
        $data['subtotal'] = $this->sale_lib->get_subtotal();
        $data['taxes'] = $this->sale_lib->get_taxes($sale_id);
        $data['total'] = $this->sale_lib->get_total($sale_id);
        $data['receipt_title'] = lang('sales_receipt');
        $data['transaction_time'] = date(get_date_format() . ' ' . get_time_format(), strtotime($sale_info['sale_time']));
        $customer_id = $this->sale_lib->get_customer();
        $emp_info = $this->Employee->get_info($sale_info['employee_id']);
        $data['payment_type'] = $sale_info['payment_type'];
        $data['amount_change'] = $this->sale_lib->get_amount_due($sale_id) * -1;
        $data['employee'] = $emp_info->first_name . ' ' . $emp_info->last_name;

        if ($customer_id != -1) {
            $cust_info = $this->Customer->get_info($customer_id);
            $data['customer'] = $cust_info->first_name . ' ' . $cust_info->last_name . ($cust_info->company_name == '' ? '' : ' (' . $cust_info->company_name . ')');
        }
        $data['sale_id'] = 'POS ' . $sale_id;
        if (!empty($cust_info->email)) {
            $this->load->library('email');
            $config['mailtype'] = 'html';
            $this->email->initialize($config);
            $this->email->from($this->config->item('email'), $this->config->item('company'));
            $this->email->to($cust_info->email);

            $this->email->subject(lang('sales_receipt'));
            $this->email->message($this->load->view("sales/receipt_email", $data, true));
            $this->email->send();
        }

        $this->sale_lib->clear_all();
    }

    function receipt($sale_id) {
        $data['is_sale'] = FALSE;

        $sale_info = $this->Sale->get_info($sale_id)->row_array();
        $this->sale_lib->copy_entire_sale($sale_id);
        $data['cart'] = $this->sale_lib->get_cart();
        $data['payments'] = $this->sale_lib->get_payments();
        $data['subtotal'] = $this->sale_lib->get_subtotal();
        $data['taxes'] = $this->sale_lib->get_taxes($sale_id);
        $data['total'] = $this->sale_lib->get_total($sale_id);
        $data['receipt_title'] = lang('sales_receipt');
        $data['comment'] = $this->Sale->get_comment($sale_id);
        $data['show_comment_on_receipt'] = $this->Sale->get_comment_on_receipt($sale_id);
        $data['transaction_time'] = date(get_date_format() . ' ' . get_time_format(), strtotime($sale_info['sale_time']));
        $customer_id = $this->sale_lib->get_customer();
        $emp_info = $this->Employee->get_info($sale_info['employee_id']);
        $data['payment_type'] = $sale_info['payment_type'];
        $data['amount_change'] = $this->sale_lib->get_amount_due($sale_id) * -1;
        $data['employee'] = $emp_info->first_name . ' ' . $emp_info->last_name;
        $data['ref_no'] = $sale_info['cc_ref_no'];
        $this->load->helper('string');
        $data['payment_type'] = str_replace(array('<sup>VNĐ</sup><br />', ''), ' .VNĐ', $sale_info['payment_type']);
        $data['amount_due'] = $this->sale_lib->get_amount_due();
        foreach ($data['payments'] as $payment_id => $payment) {
            $payment_amount = $payment['payment_amount'];
        }
        $k = 28;
        $tongtienhang = 0;
        foreach (array_reverse($data['cart'], true) as $line => $item) {
            $tongtienhang_1 += $item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100;
            $k++;
        }
        $payments_cost = $tongtienhang_1 - $payment_amount;
        if ($customer_id != -1) {
            $cust_info = $this->Customer->get_info($customer_id);
            $data['customer'] = $cust_info->first_name . ' ' . $cust_info->last_name;
            $data['cus_name'] = $cust_info->company_name == '' ? '' : $cust_info->company_name;
            $data['code_tax'] = $cust_info->code_tax;
            $data['address'] = $cust_info->address_1;
            $data['account_number'] = $cust_info->account_number;
        }
        $data['sale_id'] = 'VH ' . $sale_id;
// $this->load->view("sales/receipt",$data);
// $this->sale_lib->clear_all();
        $cities = $this->City->get_all();
        require_once APPPATH . "/third_party/Classes/export_sales.php";
        $this->sale_lib->clear_all();
    }

    function edit($sale_id) {
        $data = array();

        $data['customers'] = array('' => 'No Customer');
        foreach ($this->Customer->get_all()->result() as $customer) {
            $data['customers'][$customer->person_id] = $customer->first_name . ' ' . $customer->last_name;
        }

        $data['employees'] = array();
        foreach ($this->Employee->get_all_receiving()->result() as $employee) {
            $data['employees'][$employee->person_id] = $employee->first_name . ' ' . $employee->last_name;
        }

        $data['sale_info'] = $this->Sale->get_info($sale_id)->row_array();


        $this->load->view('sales/edit', $data);
    }

    function delete($sale_id) {
        $data = array();

        if ($this->Sale->delete($sale_id)) {
            $data['success'] = true;
        } else {
            $data['success'] = false;
        }

        $this->load->view('sales/delete', $data);
    }

    function undelete($sale_id) {
        $data = array();

        if ($this->Sale->undelete($sale_id)) {
            $data['success'] = true;
        } else {
            $data['success'] = false;
        }

        $this->load->view('sales/undelete', $data);
    }

    function save($sale_id) {
        $sale_data = array(
            'sale_time' => date('Y-m-d', strtotime($this->input->post('date'))),
            'customer_id' => $this->input->post('customer_id') ? $this->input->post('customer_id') : null,
            'employee_id' => $this->input->post('employee_id'),
            'comment' => $this->input->post('comment'),
            'show_comment_on_receipt' => $this->input->post('show_comment_on_receipt') ? 1 : 0
        );

        if ($this->Sale->update($sale_data, $sale_id)) {
            echo json_encode(array('success' => true, 'message' => lang('sales_successfully_updated')));
        } else {
            echo json_encode(array('success' => false, 'message' => lang('sales_unsuccessfully_updated')));
        }
    }

    function _payments_cover_total1() {

        $total_payments = 0;
        foreach ($this->sale_lib->get_payments() as $payment) {

            $total_payments += $payment['payment_amount'] + $payment['discount_money'];
        }

        /* Changed the conditional to account for floating point rounding */
        $total_order = $this->sale_lib->get_total_order_of_item();
        $total_taxes_percent = 0;
        foreach ($this->sale_lib->get_cart() as $item) {
            if ($item['unit'] == "unit") {
                $total_taxes_percent += $item['taxes'] * ($item['price'] * $item['quantity'] - $item['discount'] * $item['price'] * $item['quantity'] / 100) / 100;
            } else {
                $total_taxes_percent += $item['taxes'] * ($item['price_rate'] * $item['quantity'] - $item['discount'] * $item['price_rate'] * $item['quantity'] / 100) / 100;
            }
        }
        if (( $this->sale_lib->get_mode() == 'sale' ) && (($total_order + $total_taxes_percent - $total_payments ) > 1e-6 )) {
            return false;
        }
        return true;
    }

    function _payments_cover_total() {
        $total_payments = 0;

        foreach ($this->sale_lib->get_payments() as $payment) {
            $total_payments += $payment['payment_amount'];
        }

        /* Changed the conditional to account for floating point rounding */
        if (( $this->sale_lib->get_mode() == 'sale' ) && ( ( to_currency_no_money($this->sale_lib->get_total()) - $total_payments ) > 1e-6 )) {
            return false;
        }

        return true;
    }

    function reload() {
        $this->_reload();
    }

    function _reload($data = array(), $is_ajax = true) {
        $person_info = $this->Employee->get_logged_in_employee_info();
        $data['controller_name'] = strtolower(get_class());
        $data['cart'] = $this->sale_lib->get_cart();
        $data['modes'] = array('sale' => lang('sales_sale'), 'return' => lang('sales_return'));
        $data['mode'] = $this->sale_lib->get_mode();
        $data['items_in_cart'] = $this->sale_lib->get_items_in_cart();
        $data['subtotal'] = $this->sale_lib->get_subtotal();
        $data['taxes'] = $this->sale_lib->get_taxes();
        $data['total'] = $this->sale_lib->get_total();
        $data['items_module_allowed'] = $this->Employee->has_module_permission('items', $person_info->person_id);
        $data['comment'] = $this->sale_lib->get_comment();
        $data['sale_id'] = $this->sale_lib->get_suspended_sale_id();
        $data['date_debt'] = $this->sale_lib->get_date_debt();
        $data['show_comment_on_receipt'] = $this->sale_lib->get_comment_on_receipt();
        $data['email_receipt'] = $this->sale_lib->get_email_receipt();
        $data['payments_total'] = $this->sale_lib->get_payments_total();
        $data['amount_due'] = $this->sale_lib->get_amount_due();
        $data['amount_due1'] = $this->sale_lib->get_amount_owe();
//Creted by San
        $data['total_order'] = $this->sale_lib->get_total_order_of_item();
        $data['total_discount'] = $this->sale_lib->get_total_discount_of_item();
        $data['inventory'] = $this->Create_invetory->get_all2()->result_array();
        $data['total_taxes'] = $this->sale_lib->get_total_taxes();
//End San
        $data['payments'] = $this->sale_lib->get_payments();
//huyenlt^^
//dungbv lấy nv báo giá ,giao hàng
        $employees_id = $this->sale_lib->get_employees_id();
        $info_employeess = $this->Employee->get_info($employees_id);
        $data['employees'] = $info_employeess->first_name . ' ' . $info_employeess->last_name;

        $delivery_employee = $this->sale_lib->get_employees_delivery();
        $info_delivery = $this->Employee->get_info($delivery_employee);
        $data['delivery'] = $info_delivery->first_name . ' ' . $info_delivery->last_name;
//end dung
        $data['selected_employees'] = $this->Item->get_info($item_id)->supplier_id;
        $data['symbol_order'] = $this->sale_lib->get_symbol_order();
        $data['number_order'] = $this->sale_lib->get_number_order();
        $data['date_debt1'] = $this->sale_lib->get_date_debt1();
        if ($this->config->item('enable_credit_card_processing')) {
            $data['payment_options'] = array(
                '' => '-- Chọn --',
                lang('sales_cash') => lang('sales_cash'),
                lang('sales_credit') => lang('sales_credit'),
                'COD' => 'COD'
            );
        } else {
            $data['payment_options'] = array(
                '' => '-- Chọn --',
                lang('sales_cash') => lang('sales_cash'),
                lang('sales_credit') => lang('sales_credit'),
                'COD' => 'COD'
            );
        }
        foreach ($this->Appconfig->get_additional_payment_types() as $additional_payment_type) {
            $data['payment_options'][$additional_payment_type] = $additional_payment_type;
        }
        $customer_id = $this->sale_lib->get_customer();
        if ($customer_id != -1) {
            $info = $this->Customer->get_info($customer_id);
            $data['customer'] = $info->company_name == '' ? '' . (' (' . $info->first_name . ' ' . $info->last_name . ')') : $info->company_name . (' (' . $info->first_name . ' ' . $info->last_name . ')');
            $data['customer_email'] = $info->email;
            $data['customer_id'] = $customer_id;
        }
        $data['payments_cover_total'] = $this->_payments_cover_total();
        $data['payments_cover_total1'] = $this->_payments_cover_total1();

        //Hưng Audi Nov 3
        $bank_list = array('' => '-- Chọn tài khoản ngân hàng --');
        foreach ($this->Tkdu->get_bank_list()->result() as $bank){
            $bank_list[$bank->id] = $bank->id.' - '.$bank->name;
        }
        $data['bank_list'] = $bank_list;
        $data['bank_account'] = $this->sale_lib->get_bank_account();
        $data['payment_type'] = $this->sale_lib->get_payment_type();

        if ($is_ajax) {
            $this->load->view("sales/register", $data);
        } else {
            $this->load->view("sales/register_initial", $data);
        }
    }

    function cancel_sale() {
        if (!$this->_void_partial_transactions()) {
            $this->_reload(array('error' => lang('sales_attempted_to_reverse_partial_transactions_failed_please_contact_support')), true);
        }

        $this->sale_lib->clear_all();
        $this->_reload();
    }

    function _void_partial_transactions() {
        $void_success = true;

        if ($partial_transactions = $this->sale_lib->get_partial_transactions()) {
            $service_url = (!defined("ENVIRONMENT") or ENVIRONMENT == 'development') ? 'https://hc.mercurydev.net/tws/transactionservice.asmx?WSDL' : 'https://hc.mercurypay.com/tws/transactionservice.asmx?WSDL';

            foreach ($partial_transactions as $partial_transaction) {
                $parameters = array(
                    'request' => $partial_transaction,
                    'password' => $this->config->item('merchant_password'),
                );

                $client = new SoapClient($service_url, array('trace' => TRUE));
                $result = $client->CreditReversalToken($parameters);

                $status = $result->CreditReversalTokenResult->Status;
                if ($status != 'Approved') {
                    unset($parameters['AcqRefData']);
                    unset($parameters['ProcessData']);
                    $result = $client->CreditVoidSaleToken($parameters);
                    $status = $result->CreditVoidSaleTokenResult->Status;

                    if ($status != 'Approved') {
                        $void_success = false;
                    }
                }
            }
        }

        return $void_success;
    }

    function suspend() {
        $customer_id = $this->sale_lib->get_customer();
        $symbol_order = $this->sale_lib->get_symbol_order();
        $number_order = $this->sale_lib->get_number_order();

        $date_debt1 = $this->sale_lib->get_date_debt1();
        $co_1331 = 1331;
        $co_1331_money = $this->sale_lib->get_total_taxes();

        $no_131 = 131;
        $no_131_money = $this->sale_lib->get_total_taxes()+ $this->sale_lib->get_total_order_of_item();
        $load_account = $this->sale_lib->get_load_account();

        $bank_account = $this->sale_lib->get_bank_account();

        if ($this->sale_lib->get_date_debt() == null) {
            echo "<script>alert('Bạn cần chọn ngày trả nợ');
                window.location = '" . base_url() . "sales';</script>";
        } elseif ($customer_id == -1) {
            echo "<script>alert('Bạn cần chọn khách hàng để hoàn thành lưu vào sổ nợ');
                window.location = '" . base_url() . "sales';</script>";
        } else {
            $data['discount_money'] = $this->sale_lib->get_discount_money();
            $actual = $this->input->post('actual_money_post');
            $data['cart'] = $this->sale_lib->get_cart();
            $data['subtotal'] = $this->sale_lib->get_subtotal();
            $data['taxes'] = $this->sale_lib->get_taxes();
//Created by San
            $data['total_order'] = $this->sale_lib->get_total_order_of_item();
            $data['total_discount'] = $this->sale_lib->get_total_discount_of_item();
            $data['total_taxes'] = $this->sale_lib->get_total_taxes();
//End
            $data['total'] = $this->sale_lib->get_total();
            $data['receipt_title'] = lang('sales_receipt');
            $data['transaction_time'] = $this->sale_lib->get_date_debt();
            $customer_id = $this->sale_lib->get_customer();
            $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
            $comment = $this->sale_lib->get_comment();
            $date_debt = $this->sale_lib->get_date_debt();
            $show_comment_on_receipt = $this->sale_lib->get_comment_on_receipt();
            $emp_info = $this->Employee->get_info($employee_id);
            $data['employees_id'] = $this->sale_lib->get_employees_id();
            $data['delivery_employee'] = $this->sale_lib->get_employees_delivery();
            $data['payments'] = $this->sale_lib->get_payments();
            $data['amount_change'] = $this->sale_lib->get_amount_due() * -1;
            $data['amount_due'] = $this->sale_lib->get_amount_due();
            $data['employee'] = $emp_info->first_name;
            $data['customer_id'] = $this->sale_lib->get_customer();

            $data['store'] = $this->sale_lib->get_store();
            if ($customer_id != -1) {
                $cust_info = $this->Customer->get_info($customer_id);
                $data['customer'] = $cust_info->first_name . ' ' . $cust_info->last_name;
                $data['cus_name'] = $cust_info->company_name == '' ? '' : $cust_info->company_name;
                $data['code_tax'] = $cust_info->code_tax;
                $data['address'] = $cust_info->address_1;
                $data['account_number'] = $cust_info->account_number;
            }
            $total_payments = 0;
            foreach ($data['payments'] as $payment) {
                $total_payments += $payment['payment_amount'];
            }
            $sale_id = $this->sale_lib->get_suspended_sale_id();
            $total_taxes_percent = 0;
            foreach ($data['cart'] as $item) {
                if ($item['unit'] == 'unit') {
                    $total_taxes_percent += $item['taxes'] * ($item['price'] * $item['quantity'] - $item['discount'] * $item['price'] * $item['quantity'] / 100) / 100;
                } else {
                    $total_taxes_percent += $item['taxes'] * ($item['price_rate'] * $item['quantity'] - $item['discount'] * $item['price_rate'] * $item['quantity'] / 100) / 100;
                }
            }
            $total_owe = 0;
            foreach ($data['payments'] as $payment) {
                $total_owe += $payment['payment_amount'] + $payment['discount_money'];
            }
            $data['amount_due1'] = $data['total_order'] + $total_taxes_percent - $total_owe;
            $later_cost_price = $data['total_order'] + $total_taxes_percent - $discount_money;
            $actual_money = $later_cost_price;
            if ($sale_id != '') {
                $stt = 1;
                $data['sale_id'] = $this->Sale->save($data['cart'], $customer_id, $employee_id, $comment, $data['employees_id'], $show_comment_on_receipt, $data['payments'], $data['discount_money'], $later_cost_price, $actual_money, $data['amount_due'], $data['amount_due1'], $sale_id, 1, 0, $stt, $date_debt, '', '', $data['delivery_employee'], $bank_account,$symbol_order,$number_order ,$date_debt1, $co_1331, $co_1331_money, $no_131, $no_131_money, $load_account);
            } else {
                $stt = 0;
                $data['sale_id'] = $this->Sale->save($data['cart'], $customer_id, $employee_id, $comment, $data['employees_id'], $show_comment_on_receipt, $data['payments'], $data['discount_money'], $later_cost_price, $actual_money, $data['amount_due'], $data['amount_due1'], $sale_id, 1, 0, $stt, $date_debt, '', '', $data['delivery_employee'], $bank_account,$symbol_order,$number_order ,$date_debt1, $co_1331, $co_1331_money, $no_131, $no_131_money, $load_account);
            }

            //tổng nợ cũ-----------------------------------------------------------------------------------------------------------
            $data['congno'] = $this->Sale->get_money_sale($customer_id);
            $data['no'] = $this->Inventory->cost_customer($customer_id);
            //end tổng nợ ---------------------------------------------------------------------------------------------------------
            if ($data['sale_id'] == 'VH -1') {
                $data['error_message'] = lang('sales_transaction_failed');
            }
            if ($this->config->item('print_excel') == 'print_a5') {
                $this->load->view('sales/print_now_congno_a5', $data);
            } else {
                $this->load->view('sales/print_now_congno', $data);
            }
            $this->sale_lib->clear_all();
        }
    }

//ghi nợ
    function suspended() {
        $data = array();
        $data['suspended_sales'] = $this->Sale->get_all_suspended()->result_array();
        $this->load->view('sales/suspended', $data);
    }

//báo giá
    function materialed() {
        $data = array();
        $data['material_sales'] = $this->Sale->get_all_materials()->result_array();
        $data['quotes'] = $this->M_quotes_contract->get_list_template_quotes_contract(2);
        $data['contract'] = $this->M_quotes_contract->get_list_template_quotes_contract(1);
        $this->load->view('sales/materials', $data);
    }

//huyenlt^^
    function liabilityed() {
        $data = array();
        $data['liability_sales'] = $this->Sale->get_all_liability()->result_array();
        $this->load->view('sales/liability', $data);
    }

//đặt hàng
    function liability() {
        $customer_id = $this->sale_lib->get_customer();
        $date_debt1 = $this->sale_lib->get_date_debt1();
        $co_1331 = 1331;
        $co_1331_money = $this->sale_lib->get_total_taxes();

        $no_131 = 131;
        $no_131_money = $this->sale_lib->get_total_taxes()+ $this->sale_lib->get_total_order_of_item();
        $load_account = $this->sale_lib->get_load_account();
        $bank_account = $this->sale_lib->get_bank_account();
        $symbol_order = $this->sale_lib->get_symbol_order();
        $number_order = $this->sale_lib->get_number_order();
        if ($this->sale_lib->get_date_debt() == null) {
            echo "<script>alert('Bạn cần chọn ngày đưa hàng cho khách!');
                window.location = '" . base_url() . "sales';</script>";
        } elseif ($customer_id == -1) {
            echo "<script>alert('Bạn cần chọn khách hàng để hoàn thành đặt hàng');
                window.location = '" . base_url() . "sales';</script>";
        } else {
//$discount_money = $this->input->post('discount_money');
            $mode = $this->sale_lib->get_mode();
            $data['discount_money'] = $this->sale_lib->get_discount_money();
            $data['cart'] = $this->sale_lib->get_cart();

            $data['subtotal'] = $this->sale_lib->get_subtotal();

            $data['taxes'] = $this->sale_lib->get_taxes();
            $data['total_taxes'] = $this->sale_lib->get_total_taxes();
//Created by San
            $data['total_order'] = $this->sale_lib->get_total_order_of_item();
            $data['total_discount'] = $this->sale_lib->get_total_discount_of_item();
//End
            $data['total'] = $this->sale_lib->get_total();

            $data['store'] = $this->sale_lib->get_store();

            $data['receipt_title'] = lang('sales_receipt');

            $data['transaction_time'] = $this->sale_lib->get_date_debt();
            $customer_id = $this->sale_lib->get_customer();

            $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;

            $comment = $this->sale_lib->get_comment();

            $date_debt = $this->sale_lib->get_date_debt();

            $show_comment_on_receipt = $this->sale_lib->get_comment_on_receipt();

            $emp_info = $this->Employee->get_info($employee_id);

            $data['amount_due'] = $this->sale_lib->get_amount_due();

//Alain Multiple payments
            $data['employees_id'] = $this->sale_lib->get_employees_id();
            $data['delivery_employee'] = $this->sale_lib->get_employees_delivery();
            $data['payments'] = $this->sale_lib->get_payments();
            $data['amount_change'] = $this->sale_lib->get_amount_due() * -1;

            $data['employee'] = $emp_info->first_name . ' ' . $emp_info->last_name;

            if ($customer_id != -1) {
                $cust_info = $this->Customer->get_info($customer_id);

                $data['customer'] = $cust_info->first_name . ' ' . $cust_info->last_name;

                $data['cus_name'] = $cust_info->company_name == '' ? '' : $cust_info->company_name;

                $data['code_tax'] = $cust_info->code_tax;

                $data['address'] = $cust_info->address_1;

                $data['account_number'] = $cust_info->account_number;
            }
            $total_payments = 0;
            foreach ($data['payments'] as $payment) {
                $total_payments += $payment['payment_amount'];
            }
            $sale_id = $this->sale_lib->get_suspended_sale_id();
//SAVE sale to database
            $total_taxes_percent = 0;
            foreach ($data['cart'] as $item) {
                $total_taxes_percent += $item['taxes'] * ($item['price'] * $item['quantity'] - $item['discount'] * $item['price'] * $item['quantity'] / 100) / 100;
            }
            $total_owe = 0;
            foreach ($data['payments'] as $payment) {
                $total_owe += $payment['payment_amount'] + $payment['discount_money'];
            }
            $data['amount_due1'] = $data['total_order'] + $total_taxes_percent - $total_owe;
            $later_cost_price = $data['total_order'] + $total_taxes_percent - $discount_money;
//$later_cost_price = $data['total'] - $discount_money;
            $actual_money = $payment['payment_amount'];
            if ($sale_id != '') {
                $stt = 0;
                $data['sale_id'] = $this->Sale->save_liability($data['cart'], $customer_id, $employee_id, $comment, $data['employees_id'], $show_comment_on_receipt, $data['payments'], $data['discount_money'], $later_cost_price, $actual_money, $data['amount_due'], $data['amount_due1'], $sale_id, 0, 1, $stt, 1,$date_debt, $data['delivery_employee'],'',$symbol_order,$number_order ,$date_debt1, $co_1331, $co_1331_money, $no_131, $no_131_money);
            } else {
                $stt = 0;
                $data['sale_id'] = $this->Sale->save_liability($data['cart'], $customer_id, $employee_id, $comment, $data['employees_id'], $show_comment_on_receipt, $data['payments'], $data['discount_money'], $later_cost_price, $actual_money, $data['amount_due'], $data['amount_due1'], $sale_id, 0, 1, $stt, 1, $date_debt, $data['delivery_employee'],'',$symbol_order,$number_order ,$date_debt1, $co_1331, $co_1331_money, $no_131, $no_131_money);
            }
            //tổng nợ cũ-----------------------------------------------------------------------------------------------------------
            $data['congno'] = $this->Sale->get_money_sale($customer_id);
            $data['no'] = $this->Inventory->cost_customer($customer_id);
            //end tổng nợ ---------------------------------------------------------------------------------------------------------
            if ($data['sale_id'] == 'VH -1') {
                $data['error_message'] = lang('sales_transaction_failed');
            }
            if ($this->config->item('print_excel') == 'print_a5') {
                $this->load->view('sales/print_dat_hang_a5', $data);
            } else {
                $this->load->view('sales/print_dat_hang', $data);
            }
            $this->sale_lib->clear_all();
        }
    }

//materials
    function materials() {
        $customer_id = $this->sale_lib->get_customer();
        $date_debt1 = $this->sale_lib->get_date_debt1();
        $co_1331 = 1331;
        $co_1331_money = $this->sale_lib->get_total_taxes();

        $no_131 = 131;
        $no_131_money = $this->sale_lib->get_total_taxes()+ $this->sale_lib->get_total_order_of_item();
        $load_account = $this->sale_lib->get_load_account();
        $bank_account = $this->sale_lib->get_bank_account();
        $symbol_order = $this->sale_lib->get_symbol_order();
        $number_order = $this->sale_lib->get_number_order();
        if ($this->sale_lib->get_date_debt() == null) {
            echo "<script>alert('Bạn cần chọn ngày báo giá!');
                window.location = '" . base_url() . "sales';</script>";
        } elseif ($customer_id == -1) {
            echo "<script>alert('Bạn cần chọn khách hàng để hoàn thành báo giá!');
                window.location = '" . base_url() . "sales';</script>";
        } else {
//$discount_money = $this->input->post('discount_money');
            $data['discount_money'] = $this->sale_lib->get_discount_money();
            $data['cart'] = $this->sale_lib->get_cart();

            $data['subtotal'] = $this->sale_lib->get_subtotal();

            $data['taxes'] = $this->sale_lib->get_taxes();

            $data['total'] = $this->sale_lib->get_total();

            $data['receipt_title'] = lang('sales_receipt');

            $data['transaction_time'] = date(get_date_format() . ' ' . get_time_format());

            $customer_id = $this->sale_lib->get_customer();

            $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;

            $comment = $this->sale_lib->get_comment();

            $date_debt = $this->sale_lib->get_date_debt();

            $show_comment_on_receipt = $this->sale_lib->get_comment_on_receipt();

            $emp_info = $this->Employee->get_info($employee_id);

            $data['amount_due'] = $this->sale_lib->get_amount_due();
            $data['amount_due1'] = $this->sale_lib->get_amount_due1();

//Alain Multiple payments
            $data['employees_id'] = $this->sale_lib->get_employees_id();
            $data['payments'] = $this->sale_lib->get_payments();
//		print_r($data['payments']);
//		die('xxxxx');
            $data['amount_change'] = $this->sale_lib->get_amount_due() * -1;

            $data['employee'] = $emp_info->first_name;


            if ($customer_id != -1) {
                $cust_info = $this->Customer->get_info($customer_id);

                $data['customer'] = $cust_info->first_name . ' ' . $cust_info->last_name;

                $data['cus_name'] = $cust_info->company_name == '' ? '' : $cust_info->company_name;

                $data['code_tax'] = $cust_info->code_tax;

                $data['address'] = $cust_info->address_1;

                $data['account_number'] = $cust_info->account_number;
            }
            $total_payments = 0;
            foreach ($data['payments'] as $payment) {
                $total_payments += $payment['payment_amount'];
            }
            $sale_id = $this->sale_lib->get_suspended_sale_id();
//SAVE sale to database
            $later_cost_price = $data['total'] - $discount_money;
            $actual_money = $payment['payment_amount'];

            if ($sale_id != '') {
                $stt = 0;
                $data['sale_id'] = $this->Sale->save_materials($data['cart'], $customer_id, $employee_id, $comment, $data['employees_id'], $show_comment_on_receipt, $data['payments'], $data['discount_money'], $later_cost_price, $actual_money, $data['amount_due'], $data['amount_due1'], $sale_id, 0, 0, $stt, 1 ,$date_debt,'',$date_debt1,$symbol_order,$number_order , $co_1331, $co_1331_money, $no_131, $no_131_money);
            } else {
                $stt = 0;
                $data['sale_id'] = $this->Sale->save_materials($data['cart'], $customer_id, $employee_id, $comment, $data['employees_id'], $show_comment_on_receipt, $data['payments'], $data['discount_money'], $later_cost_price, $actual_money, $data['amount_due'], $data['amount_due1'], $sale_id, 0, 0, $stt, 1,$date_debt,'',$date_debt1,$symbol_order,$number_order , $co_1331, $co_1331_money, $no_131, $no_131_money);
            }
            if ($data['sale_id'] == 'VH -1') {
                $data['error_message'] = lang('sales_transaction_failed');
            }

// $this->load->view('sales/print_dat_hang', $data);
//require_once APPPATH . "/third_party/Classes/export_liability.php";
            $this->sale_lib->clear_all();
            $this->_reload(array('success' => lang('sales_successfully_liability_sale')));
//die('aaaaa');
//redirect('sales');
// die('sssss');
        }
    }

//end huyenlt^^

    function unsuspend() {
        $sale_id = $this->input->post('suspended_sale_id');
        $this->session->set_userdata('store', $this->Sale->get_store_by_sale($sale_id));// set_session 
        $this->sale_lib->clear_all();
        $this->sale_lib->copy_entire_sale($sale_id);
        $this->sale_lib->set_suspended_sale_id($sale_id);
       $this->_reload(array(), false);
    }

    function delete_all() {
        $this->sale_lib->empty_cart();
        $this->_reload();
    }

    function delete_suspended_sale() {
        $suspended_sale_id = $this->input->post('suspended_sale_id');
        if ($suspended_sale_id) {
            $this->sale_lib->delete_suspended_sale_id();
            $info_sale_liablity = $this->Sale->get_sales_tam($suspended_sale_id);
            $info_sale = $this->Sale->get_info_sale($suspended_sale_id);
            $info_cus = $this->Customer->get_info($info_sale['customer_id']);
            $total_pay_money = 0;
            foreach ($info_sale_liablity as $sale_liablity) {
                $total_pay_money += $sale_liablity['pays_amount'];
            }
            $name = ($info_cus->company_name != "") ? $info_cus->company_name : ($info_cus->first_name . " " . $info_cus->last_name);
            $command = "Chi tiền trả lại tiền cho " . $name . " khi hủy đơn đặt hàng số " . $suspended_sale_id;
            $data_inser_cost = array(
                'id_customer' => $info_sale['customer_id'],
                'name' => 1,
                'money' => $total_pay_money,
                'form_cost' => 1,
                'date' => date('Y-m-d H:i:s'),
                'cost_date_ct' => date('Y-m-d'),
                'comment' => $command,
                'deleted' => 0,
                'id_sale' => $suspended_sale_id,
                'cost_employees' => $this->session->userdata('person_id'),
                'tk_no' => 131,
                'tk_co' => 111
            );
            $this->Cost->save($data_inser_cost, (-1));
            $this->Sale->delete_liablity($suspended_sale_id);
        }
        $this->sale_lib->clear_all();
        redirect('sales');
        $this->_reload(array('success' => lang('sales_successfully_deleted')), false);
    }

    function delete_detail_materials() {
        header('Content-Type: text/html; charset=utf-8');
        $suspended_sale_id = $this->input->post('suspended_sale_id');
        $customer_id = $this->input->post('suspended_customer_id');
        $info_sale_material = $this->Sale->get_sale_material($suspended_sale_id);
        if ($suspended_sale_id) {
            $this->sale_lib->delete_suspended_sale_id();
            $this->Sale->delete($suspended_sale_id);
            $this->load->model('Cost');
            $this->Cost->delete_sale_id($suspended_sale_id);
            foreach ($info_sale_material as $item) {
                unlink(APPPATH . "/../excel_materials/" . $item['name']);
            }
            $this->Sale->delete_sale_material($suspended_sale_id);
        }
        $this->sale_lib->clear_all();
        redirect('customers/detail_customer_sale/' . $customer_id);
        $this->_reload(array('success' => lang('sales_successfully_deleted')), false);
    }

    function check_cong_no() {
        $customer_id = $_POST['customer_id'];
        $info_cus = $this->Customer->get_info($customer_id);
        $amount_final = $_POST['amount_final'];
        $sales = $this->Inventory->find_sale_complete_by_customer($customer_id);
        $total = 0;
        $to = 0;
        foreach ($sales as $sale) {
            $total += $sale['later_cost_price'];
            $sale_payments = $this->Sale->get_payment_sale_by_sale_id($sale['sale_id']);
            foreach ($sale_payments as $val) {
                $to += $val['payment_amount'];
            }
        }
        $cong_no = $total - $to;
        if ($info_cus->debt != 0 && ($cong_no + $amount_final) > $info_cus->debt) {
            echo "0";
        } else {
            echo "1";
        }
    }

    function send_mail() {
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => $this->config->item('email'),
            'smtp_pass' => $this->config->item('pass_email'),
            'charset' => 'utf-8',
            'mailtype' => 'html',
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $mail_info = $this->Customer->get_info_mail($this->config->item('mail_template_birthday'));
        $this->email->subject($mail_info->mail_title);
        $content = $mail_info->mail_content;
        $cus_info = $this->Customer->get_info(16);
        $this->email->from($this->config->item('email'), $this->config->item('company'));
        $this->email->to($cus_info->email);
        $content = str_replace('__FIRST_NAME__', $cus_info->first_name, $content);
        $content = str_replace('__LAST_NAME__', $cus_info->last_name, $content);
        $content = str_replace('__PHONE_NUMBER__', $cus_info->phone_number, $content);
        $content = str_replace('__EMAIL__', $cus_info->email, $content);
//Thong tin chu ky cong ty gui mail
        $content = str_replace('__NAME_COMPANY__', '<b>' . $this->config->item('company') . '</b>', $content);
        $content = str_replace('__ADDRESS_COMPANY__', $this->config->item('address'), $content);
        $content = str_replace('__EMAIL_COMPANY__', $this->config->item('email'), $content);
        $content = str_replace('__FAX_COMPANY__', $this->config->item('fax'), $content);
        $content = str_replace('__WEBSITE_COMPANY__', $this->config->item('website'), $content);
        $this->email->message($content);
        if (!$this->email->send()) {
            show_error($this->email->print_debugger());
        } else {
            echo 'Your e-mail has been sent!';
            echo date('d-m-Y H:i:s');
        }
    }

//hung audi 29-6-15
    function customer_search_reports() {
        $suggestions = $this->Customer->get_customer_search_reports($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

//hoa don ban hang dungbv
    public function sales_order() {
        $this->check_action_permission('sales_order');
        $config['base_url'] = site_url('sales/sale_order_sorting');
        $config['total_rows'] = $this->Sale->count_all();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_sales_orders_manage_table($this->Sale->get_all($data['per_page']), $this);
        
//        echo "<pre>";
//        print_r( $data['manage_table']);
//        echo"</pre>";
//        exit();
        
        
        $this->load->view('sales_order/manage', $data);
    }

    function sale_order_sorting() {
        $this->check_action_permission('sales_order');
        $start_date1 = $this->input->post('start_date');
        $end_date1 = $this->input->post('end_date');
        $tam = $end_date1;
        $tam .='23:59:59';
        $start_date = date('Y-m-d H:i:s', strtotime($start_date1));
        $end_date = date('Y-m-d H:i:s', strtotime($tam));

        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search || $start_date || $end_date) {
            $config['total_rows'] = $this->Sale->search_count_all($start_date, $end_date, $search);
            $table_data = $this->Sale->search(
                    $start_date, $end_date, $search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'sale_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
            );
        } else {
            $config['total_rows'] = $this->Sale->count_all();
            $table_data = $this->Sale->get_all(
                    $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'sale_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
            );
        }
        $config['base_url'] = site_url('sales/sale_order_sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_sales_orders_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function sale_order_suggest() {
        $suggestions = $this->Sale->get_search_suggestions($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    function sale_order_search() {
        $this->check_action_permission('sales_order');
        $start_date1 = $this->input->post('start_date');
        $end_date1 = $this->input->post('end_date');
        $tam = $end_date1;
        $tam .='23:59:59';
        $start_date = date('Y-m-d H:i:s', strtotime($start_date1));
        $end_date = date('Y-m-d H:i:s', strtotime($tam));

        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Sale->search(
                $start_date, $end_date, $search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'sale_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
        );
        $config['base_url'] = site_url('sales/sale_order_search');
        $config['total_rows'] = $this->Sale->search_count_all($start_date, $end_date, $search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_sales_orders_manage_table_data_rows($search_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

//load order_view
    function view_order($sale_id = -1) {
        $data['sale_id'] = $sale_id;
        $data['info_sale'] = $this->Sale->get_info_sale_order($sale_id);
        $data['info_sale_item'] = $this->Sale->get_sale_item_order();
        $this->load->view('sales_order/view_order', $data);
    }

//delete sale_order
    public function delete_sale() {
        $this->check_action_permission('delete_sale');
        $ids = $this->input->post('ids');
        foreach ($ids as $id) {
            $data_delete = array('deleted' => 1);
            $this->Sale->delete_sale_order($data_delete, $id);
        }
        echo json_encode(array('success' => true, 'message' => 'Bạn đã xóa thành công hóa đơn số - ' . $id));
    }

    public function print_order($sale_id) {
        $this->check_action_permission("print_order");
        $data['sale_id'] = $sale_id;
        $customer_id = $this->sale_lib->get_customer();
        $cust_info = $this->Customer->get_info($customer_id);
        $data['address1'] = $cust_info->address_1;
        $data['info_sale'] = $this->Sale->get_info_sale_order($sale_id);
        $data['info_sale_item'] = $this->Sale->get_sale_item_order();
        if ($this->config->item('print_excel') == 'print_a5') {
            $this->load->view('sales_order/print_order_a5', $data);
        } elseif ($this->config->item('print_excel') == 'print') {
            $this->load->view("sales_order/print_a8", $data);
        } else {
            require_once APPPATH . "/third_party/Classes/export_receipt_order.php";
            redirect('sales/sales_order');
        }
    }

//end dungbv
    //Nov 3
    function set_bank_account() {
        $this->sale_lib->set_bank_account($this->input->post('bank_account'));
    }
    function set_payment_type() {
        $this->sale_lib->set_payment_type($this->input->post('payment_type'));
    }

    function add_load_account(){
        $load_account = $this->input->post('load_account');
        $this->sale_lib->set_load_account($load_account);
	}
}

?>
