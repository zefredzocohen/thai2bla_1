<?php

require_once(APPPATH . 'third_party/Classes/PHPExcel/IOFactory.php');
require_once(APPPATH . 'libraries/php-excel.class.php');
require_once ("secure_area.php");

class Reports extends Secure_area {

    function __construct() {
        parent::__construct('reports');
        $this->load->helper('report');
        $this->load->model("Transactions");
        $this->load->model("Inventory");
        $this->load->model("Cost");
    }

    //Initial report listing screen
    function index() {
        $this->load->view("reports/listing", array());
    }

//phan lam
    function view($customer_id) {
        $data['person_id'] = $customer_id;
        $this->load->view("customers/add_money", $data);
    }

    function save() {
        $start_of_time = date('Y-m-d', 0);
        $today = date('Y-m-d');
        $this->load->model('Money_birthdate');
        $mang = array(
            'noidung' => $this->input->post('noidung'),
            'chiphi' => $this->input->post('chiphi'),
            'person_id' => $this->input->post('personid'));
        $save = $this->Money_birthdate->save($mang);
        if ($save == true) {
            redirect(site_url('reports/specific_' . ( 'customer') . '/' . $start_of_time . '/' . $today . '/' . $this->input->post('personid') . '/all/0'));
        }
    }

//end phan lam	
    // Sales Generator Reports 
    function sales_generator() {
        if ($this->input->get('act') == 'autocomplete') { // Must return a json string
            if ($this->input->get('w') != '') { // From where should we return data
                if ($this->input->get('term') != '') { // What exactly are we searchin
                    switch ($this->input->get('w')) {
                        case 'customers':
                            $t = $this->Customer->search($this->input->get('term'), 100, 0, 'last_name', 'asc')->result_object();
                            $tmp = array();
                            foreach ($t as $k => $v) {
                                $tmp[$k] = array('id' => $v->person_id, 'name' => $v->last_name . ", " . $v->first_name . " - " . $v->email);
                            }
                            die(json_encode($tmp));
                            break;
                        case 'employees':
                            $t = $this->Employee->search($this->input->get('term'), 100, 0, 'last_name', 'asc')->result_object();
                            $tmp = array();
                            foreach ($t as $k => $v) {
                                $tmp[$k] = array('id' => $v->person_id, 'name' => $v->last_name . ", " . $v->first_name . " - " . $v->email);
                            }
                            die(json_encode($tmp));
                            break;
                        case 'itemsCategory':
                            $t = $this->Item->get_category_suggestions($this->input->get('term'));
                            $tmp = array();
                            foreach ($t as $k => $v) {
                                $tmp[$k] = array('id' => $v['label'], 'name' => $v['label']);
                            }
                            die(json_encode($tmp));
                            break;
                        case 'suppliers':
                            $t = $this->Supplier->search($this->input->get('term'), 100, 0, 'last_name', 'asc')->result_object();
                            $tmp = array();
                            foreach ($t as $k => $v) {
                                $tmp[$k] = array('id' => $v->person_id, 'name' => $v->last_name . ", " . $v->first_name . " - " . $v->company_name . " - " . $v->email);
                            }
                            die(json_encode($tmp));
                            break;
                        case 'itemsKitName':
                            $t = $this->Item_kit->search($this->input->get('term'), 100, 0, 'name', 'asc')->result_object();
                            $tmp = array();
                            foreach ($t as $k => $v) {
                                $tmp[$k] = array('id' => $v->item_kit_id, 'name' => $v->name . " / #" . $v->item_kit_number);
                            }
                            die(json_encode($tmp));
                            break;
                        case 'itemsName':
                            $t = $this->Item->search($this->input->get('term'), 100, 0, 'name', 'asc')->result_object();
                            $tmp = array();
                            foreach ($t as $k => $v) {
                                $tmp[$k] = array('id' => $v->item_id, 'name' => $v->name);
                            }
                            die(json_encode($tmp));
                            break;
                        case 'paymentType':
                            $t = array(lang('sales_cash'), lang('sales_check'), lang('sales_giftcard'), lang('sales_debit'), lang('sales_credit'));

                            foreach ($this->Appconfig->get_additional_payment_types() as $additional_payment_type) {
                                $t[] = $additional_payment_type;
                            }

                            $tmp = array();
                            foreach ($t as $k => $v) {
                                $tmp[$k] = array('id' => $v, 'name' => $v);
                            }
                            die(json_encode($tmp));
                            break;
                    }
                } else {
                    die;
                }
            } else {
                die(json_encode(array('value' => 'No such data found!')));
            }
        }

        $postData = array();
        $data = $this->_get_common_report_data();
        $data["title"] = lang('reports_sales_generator');
        $data["subtitle"] = lang('reports_sales_report_generator');

        $setValues = array('report_type' => '', 'sreport_date_range_simple' => '',
            'start_month' => date("m"), 'start_day' => date('d'), 'start_year' => date("Y"),
            'end_month' => date("m"), 'end_day' => date('d'), 'end_year' => date("Y"),
            'matchType' => '',
        );
        foreach ($setValues as $k => $v) {
            if (empty($v) && !isset($data[$k])) {
                $data[$k] = '';
            } else {
                $data[$k] = $v;
            }
        }

        if ($this->input->post('generate_report') == 1) { // Generate Custom Raport
            $data['report_type'] = $this->input->post('report_type');
            $data['sreport_date_range_simple'] = $this->input->post('report_date_range_simple');


            $data['start_month'] = $this->input->post('start_month');
            $data['start_day'] = $this->input->post('start_day');
            $data['start_year'] = $this->input->post('start_year');
            $data['end_month'] = $this->input->post('end_month');
            $data['end_day'] = $this->input->post('end_day');
            $data['end_year'] = $this->input->post('end_year');
            if ($data['report_type'] == 'simple') {
                $q = explode("/", $data['sreport_date_range_simple']);
                list($data['start_year'], $data['start_month'], $data['start_day']) = explode("-", $q[0]);
                list($data['end_year'], $data['end_month'], $data['end_day']) = explode("-", $q[1]);
            }
            $data['matchType'] = $this->input->post('matchType');

            $data['field'] = $this->input->post('field');
            $data['condition'] = $this->input->post('condition');
            $data['value'] = $this->input->post('value');

            $data['prepopulate'] = array();

            $field = $this->input->post('field');
            $condition = $this->input->post('condition');
            $value = $this->input->post('value');

            $tmpData = array();
            foreach ($field as $a => $b) {
                $uData = explode(",", $value[$a]);
                $tmp = $tmpID = array();
                switch ($b) {
                    case '1': // Customer
                        $t = $this->Customer->get_multiple_info($uData)->result_object();
                        foreach ($t as $k => $v) {
                            $tmpID[] = $v->person_id;
                            $tmp[$k] = array('id' => $v->person_id, 'name' => $v->last_name . ", " . $v->first_name . " - " . $v->email);
                        }
                        break;
                    case '2': // Item Serial Number
                        $tmpID[] = $value[$a];
                        break;
                    case '3': // Employees
                        $t = $this->Employee->get_multiple_info($uData)->result_object();
                        foreach ($t as $k => $v) {
                            $tmpID[] = $v->person_id;
                            $tmp[$k] = array('id' => $v->person_id, 'name' => $v->last_name . ", " . $v->first_name . " - " . $v->email);
                        }
                        break;
                    case '4': // Items Category
                        foreach ($uData as $k => $v) {
                            $tmpID[] = $v;
                            $tmp[$k] = array('id' => $v, 'name' => $v);
                        }
                        break;
                    case '5': // Suppliers 
                        $t = $this->Supplier->get_multiple_info($uData)->result_object();
                        foreach ($t as $k => $v) {
                            $tmpID[] = $v->person_id;
                            $tmp[$k] = array('id' => $v->person_id, 'name' => $v->last_name . ", " . $v->first_name . " - " . $v->company_name . " - " . $v->email);
                        }
                        break;
                    case '6': // Sale Type
                        $tmpID[] = $condition[$a];
                        break;
                    case '7': // Sale Amount
                        $tmpID[] = $value[$a];
                        break;
                    case '8': // Item Kits
                        $t = $this->Item_kit->get_multiple_info($uData)->result_object();
                        foreach ($t as $k => $v) {
                            $tmpID[] = $v->item_kit_id;
                            $tmp[$k] = array('id' => $v->item_kit_id, 'name' => $v->name . " / #" . $v->item_kit_number);
                        }
                        break;
                    case '9': // Items Name
                        $t = $this->Item->get_multiple_info($uData)->result_object();
                        foreach ($t as $k => $v) {
                            $tmpID[] = $v->item_id;
                            $tmp[$k] = array('id' => $v->item_id, 'name' => $v->name);
                        }
                        break;
                    case '10': // SaleID
                        if (strpos(strtoupper($value[$a]), 'POS') !== FALSE) {
                            $pieces = explode(' ', $value[$a]);
                            $value[$a] = (int) $pieces[1];
                        }
                        $tmpID[] = $value[$a];
                        break;
                    case '11': // Payment type
                        foreach ($uData as $k => $v) {
                            $tmpID[] = $v;
                            $tmp[$k] = array('id' => $v, 'name' => $v);
                        }
                        break;
                }
                $data['prepopulate']['field'][$a][$b] = $tmp;

                // Data for sql
                $tmpData[] = array('f' => $b, 'o' => $condition[$a], 'i' => $tmpID);
            }

            $params['matchType'] = $data['matchType'];
            $params['ops'] = array(
                1 => " = 'xx'",
                2 => " != 'xx'",
                5 => " IN ('xx')",
                6 => " NOT IN ('xx')",
                7 => " > xx",
                8 => " < xx",
                9 => " = xx",
                10 => '', // Sales
                11 => '', // Returns
            );

            $params['tables'] = array(
                1 => 'customer_id', // Customers
                2 => 'serialnumber', // Item Sale Serial number
                3 => 'employee_id', // Employees
                4 => 'sales_items_temp.category', // Item Category
                5 => 'supplier_id', // Suppliers
                6 => '', // Sale Type
                7 => '', // Sale Ammount
                8 => 'item_kit_id', // Item Kit Name
                9 => 'item_id', // Item Name
                10 => 'sale_id', // Sale ID
                11 => 'payment_type' // Payment Type
            );
            $params['values'] = $tmpData;

            $this->load->model('reports/Sales_generator');
            $model = $this->Sales_generator;
            $model->setParams($params);

            // Sales Interval Reports
            $interval = array(
                'start_date' => $data['start_year'] . '-' . $data['start_month'] . '-' . $data['start_day'],
                'end_date' => $data['end_year'] . '-' . $data['end_month'] . '-' . $data['end_day'] . ' 23:59:59',
            );
            $this->Sale->create_sales_items_temp_table($interval);
            $tabular_data = array();
            $report_data = $model->getData();

            $summary_data = array();
            $details_data = array();

            foreach ($report_data['summary'] as $key => $row) {
                $summary_data[] = array(
                    array('data' => anchor('sales/edit/' . $row['sale_id'], '<img src="' . base_url() . 'images/pieces/edit.gif" title="' . lang('common_edit') . '" >', array('target' => '_blank')) . ' ' . anchor('sales/receipt/' . $row['sale_id'], '<img src="' . base_url() . 'images/pieces/print.png" title="' . lang('common_print_receipt') . '" >', array('target' => '_blank')) . ' ' . anchor('sales/edit/' . $row['sale_id'], lang('common_edit') . ' ' . $row['sale_id'], array('target' => '_blank')), 'align' => 'left'),
                    array('data' => date(get_date_format() . '-' . get_time_format(), strtotime($row['sale_time'])), 'align' => 'left'),
                    array('data' => $row['items_purchased'], 'align' => 'left'),
                    array('data' => $row['employee_name'], 'align' => 'left'),
                    array('data' => $row['customer_name'], 'align' => 'left'),
                    array('data' => to_currency($row['subtotal']), 'align' => 'right'),
                    array('data' => to_currency($row['total']), 'align' => 'right'),
                    array('data' => to_currency($row['tax']), 'align' => 'right'),
                    array('data' => to_currency($row['profit']), 'align' => 'right'),
                    array('data' => $row['payment_type'], 'align' => 'right'),
                    array('data' => $row['comment'], 'align' => 'right'));

                foreach ($report_data['details'][$key] as $drow) {
                    $details_data[$key][] = array(array('data' => isset($drow['item_number']) ? $drow['item_number'] : $drow['item_kit_number'], 'align' => 'left'), array('data' => isset($drow['item_name']) ? $drow['item_name'] : $drow['item_kit_name'], 'align' => 'left'), array('data' => $drow['category'], 'align' => 'left'), array('data' => $drow['serialnumber'], 'align' => 'left'), array('data' => $drow['description'], 'align' => 'left'), array('data' => $drow['quantity_purchased'], 'align' => 'left'), array('data' => to_currency($drow['subtotal']), 'align' => 'right'), array('data' => to_currency($drow['total']), 'align' => 'right'), array('data' => to_currency($drow['tax']), 'align' => 'right'), array('data' => to_currency($drow['profit']), 'align' => 'right'), array('data' => $drow['discount_percent'] . '%', 'align' => 'left'));
                }
            }

            $reportdata = array(
                "title" => lang('reports_sales_generator'),
                "subtitle" => "(" . count($report_data['summary']) . ") " . lang('reports_sales_report_generator') . " : " . date(get_date_format(), strtotime($interval['start_date'])) . ' đến ' . date(get_date_format(), strtotime($interval['end_date'])) . "",
                "headers" => $model->getDataColumns(),
                "summary_data" => $summary_data,
                "details_data" => $details_data,
                "overall_summary_data" => $model->getSummaryData(),
            );

            // Fetch & Output Data 
            $data['results'] = $this->load->view("reports/sales_generator_tabular_details", $reportdata, true);
        }
        $this->load->view("reports/sales_generator", $data);
    }

    function _get_common_report_data($time = false) {
        $data = array();
        $data['report_date_range_simple'] = get_simple_date_ranges($time);
        $data['months'] = get_months();
        $data['days'] = get_days();
        $data['years'] = get_years();
        $data['hours'] = get_hours($this->config->item('time_format'));
        $data['minutes'] = get_minutes();
        $data['selected_month'] = date('m');
        $data['selected_day'] = date('d');
        $data['selected_year'] = date('Y');

        return $data;
    }

    //Input for reports that require only a date range and an export to excel. (see routes.php to see that all summary reports route here)
    //bán hàng
    function date_detailed_trading() {
        $data = $this->_get_common_report_data(TRUE);
        $data['tille'] = 'Báo cáo bán hàng';
        $this->load->view("reports/date_input_date", $data);
    }

    //end bán hàng
    //huyenlt^^ :bc đon hàng-nhap hang
    function date_input_excel_export_detail_sales() {
        $data = $this->_get_common_report_data(TRUE);
        $data['tille'] = 'Báo cáo đơn hàng';
        // $this->load->view("reports/date_input_excel_export_detail_sales", $data);
        $this->load->view("reports/date_input_excel_export", $data);
    }

    //input bc nhap khau
    function date_input_imports() {
        $data = $this->_get_common_report_data(TRUE);
        $data['tille'] = 'Báo cáo nhập khẩu';
        $this->load->view("reports/date_input_imports", $data);
    }

    //báo cáo kiểm kho
    function date_verifying_resport() {
        $data = $this->_get_common_report_data(TRUE);
        $data['tille'] = 'Báo cáo kiểm kho';
        $this->load->view("reports/date_input_all", $data);
    }

    //end báo cáo kiểm kho
    //báo cáo chuyển kho
    function date_transfer_ware() {
        $data = $this->_get_common_report_data(TRUE);
        $data['tille'] = 'Báo cáo chuyển kho';
        $this->load->view("reports/date_input_all", $data);
    }

    //end báo cáo chuyển kho
    function date_input_excel_export() {
        $data = $this->_get_common_report_data(TRUE);
        $data['tille'] = 'Báo cáo nhập hàng';
        $this->load->view("reports/date_input_excel_export", $data);
    }

    //bao cao nhap hang 
    //bao bao nhap hang
    function date_input_receivings() {
        $data = $this->_get_common_report_data(TRUE);
        $data['tille'] = 'Báo cáo nhập hàng';
        $this->load->view("reports/date_input_receivings", $data);
    }

    //bc đơn hàng bị xóa
    function date_input_excel_export_deleted() {
        $data = $this->_get_common_report_data(TRUE);
        $data['tille'] = 'Báo cáo đơn hàng bị xóa';
        $this->load->view("reports/date_input_all", $data);
    }

    function date_input_excel_export_items() {
        $data = $this->_get_common_report_data(TRUE);
        $data['tille'] = 'Các báo cáo tổng hợp';
        $this->load->view("reports/date_input_excel_export", $data);
    }

    //bc tổng hợp thanh toán input dungbv
    function date_input_excel_export_payments() {
        $data = $this->_get_common_report_data(TRUE);
        $data['tille'] = 'Báo cáo tổng hợp thanh toán';
        $this->load->view("reports/date_input_excel_export_payment", $data);
    }

    //bc tổng hợp chiết khấu input dungbv
    function date_input_excel_export_discounts() {
        $data = $this->_get_common_report_data(TRUE);
        $data['tille'] = 'Báo cáo tổng hợp chiết khấu';
        $this->load->view("reports/date_input_excel_export_discount", $data);
    }

    //hung audi 27-6-15
    function date_input_summary_suppliers() {
        $data = $this->_get_common_report_data(TRUE);
        $data['tille'] = 'Báo cáo tổng hợp nhà cung cấp';
        $this->load->view("reports/date_input_summary_suppliers", $data);
    }

    //chi tiết tồn kho NVL
    function date_item_inventory() {
        $data = $this->_get_common_report_data(TRUE);
        $data['tille'] = 'Báo cáo xuất nhập tồn';
        $data['specific_input_name'] = 'Chọn kho';
        $stores = array('all' => 'Tất cả', '0' => 'Kho tổng');
        foreach ($this->Create_invetory->get_all()->result_array() as $row) {
            $stores[$row['id']] = $row['name_inventory'];
        }
        $data['specific_input_data'] = $stores;
        $this->load->view("reports/date_input_all", $data);
    }

    //end huyenlt^^
    //huyenlt^^ date thu-chi
    function date_input_excel_export_cost() {
        $data = $this->_get_common_report_data(TRUE);
        $data['tille'] = 'Báo cáo chi tiết thu chi';
        $this->load->view("reports/date_input_all1", $data);
    }

    function choose_date_thu() {
        $data = $this->_get_common_report_data(TRUE);
        $data['tille'] = 'Báo cáo chi tiết thu';
        $this->load->view("reports/date_input_all", $data);
    }

    function choose_date_chi() {
        $data = $this->_get_common_report_data(TRUE);
        $data['tille'] = 'Báo cáo chi tiết chi';
        $this->load->view("reports/date_input_all", $data);
    }

    //end thu-chi  
    /** added for register log */
    function date_input_excel_export_register_log() {
        $data = $this->_get_common_report_data();
        $this->load->view("reports/date_input_excel_register_log.php", $data);
    }

    /** added for register log */
    function date_input_grap() {
        $data = $this->_get_common_report_data();
        $this->load->view("reports/date_input_grap.php", $data);
    }

    /** also added for register log */
    function detailed_register_log($start_date, $end_date, $export_excel = 0) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);

        $this->load->model('reports/Detailed_register_log');
        $model = $this->Detailed_register_log;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date));

        $headers = $model->getDataColumns();
        $report_data = $model->getData();

        $summary_data = array();
        $details_data = array();

        $overallSummaryData = array(
            'total_cash_sales' => 0,
            'total_shortages' => 0,
            'total_overages' => 0,
            'total_difference' => 0
        );

        foreach ($report_data['summary'] as $row) {
            $summary_data[] = array(
                array('data' => $row['first_name'] . ' ' . $row['last_name'], 'align' => 'left'),
                array('data' => date(get_date_format(), strtotime($row['shift_start'])) . ' ' . date(get_time_format(), strtotime($row['shift_start'])), 'align' => 'left'),
                array('data' => date(get_date_format(), strtotime($row['shift_end'])) . ' ' . date(get_time_format(), strtotime($row['shift_end'])), 'align' => 'left'),
                array('data' => to_currency($row['open_amount']), 'align' => 'right'),
                array('data' => to_currency($row['close_amount']), 'align' => 'right'),
                array('data' => to_currency($row['cash_sales_amount']), 'align' => 'right'),
                array('data' => to_currency($row['difference']), 'align' => 'right')
            );

            $overallSummaryData['total_cash_sales'] += $row['cash_sales_amount'];
            if ($row['difference'] > 0) {
                $overallSummaryData['total_overages'] += $row['difference'];
            } else {
                $overallSummaryData['total_shortages'] += $row['difference'];
            }

            $overallSummaryData['total_difference'] += $row['difference'];
        }

        $data = array(
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "title" => lang('reports_register_log_title'),
            "subtitle" => 'Từ ' . date(get_date_format(), strtotime($start_date)) . ' đến ' . date(get_date_format(), strtotime($end_date)),
            "headers" => $model->getDataColumns(),
            "data" => $summary_data,
            "details_data" => array(),
            "summary_data" => $overallSummaryData,
            "export_excel" => $export_excel
        );
        if ($export_excel == 0) {
            $this->load->view("reports/tabular", $data);
        } else {
            require_once APPPATH . "/third_party/Classes/detailed_register_log.php";
        }

        //$this->load->view("reports/tabular", $data);
    }

    //Summary sales report
    function summary_sales($start_date, $end_date, $sale_type, $export_excel = 0, $item_type) {
        $start_date = rawurldecode($start_date);
          $end_date = date('Y-m-d 23:59:59', strtotime(rawurldecode($end_date)));
        if ($item_type != 4) {
            if ($item_type != 2) {
                $datas = $this->Sale->get_date_in_sale_item($start_date, $end_date, $sale_type, $item_type);
            } else {
                $datas = $this->Sale->get_date_in_sale_pack($start_date, $end_date, $sale_type);
            }
        } else {
            $datas1 = $this->Sale->get_date_in_sale_item($start_date, $end_date, $sale_type, $item_type);
            $datas2 = $this->Sale->get_date_in_sale_pack($start_date, $end_date, $sale_type);
            $datas = array_merge($datas1, $datas2);
//            $datas =  $this->Sale->get_date_in_sale($start_date, $end_date, $sale_type);
        }
        foreach ($datas as $date) {
            $date_tam[] = date('d-m-Y', strtotime($date['sale_time']));
        }
        $dates = array_unique($date_tam);
        $data = array(
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "title" => lang('reports_sales_summary_report'),
            "subtitle" => 'Từ ' . date(get_date_format(), strtotime($start_date)) . ' đến ' . date(get_date_format(), strtotime($end_date)),
            "link" => "" . base_url() . "reports/summary_sales",
            'item_type' => $item_type,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'sale_type' => $sale_type,
            'dates' => $dates,
            'datas' => $datas,
        );
        if ($export_excel == 0) {
            $this->load->view("reports/tabular_sum_sale", $data);
        } else {
            require_once APPPATH . "/third_party/Classes/report_sum_sale.php";
        }
    }

    function summary_categories_input() {
        $data = $this->_get_common_report_data(TRUE);
        $data['tille'] = 'Các báo cáo tổng hợp';
        $this->load->view("reports/summary_categories_input", $data);
    }

    //Summary categories report
    function summary_categories($start_date, $end_date, $sale_type, $export_excel = 0) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);

        $data = array(
            "start_date" => $start_date,
            "end_date" => $end_date,
            "sale_type" => $sale_type,
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "title" => lang('reports_categories_summary_report'),
            "subtitle" => 'Từ ' . date(get_date_format(), strtotime($start_date)) . ' đến ' . date(get_date_format(), strtotime($end_date)),
            "link" => "" . base_url() . "reports/summary_categories",
        );
        if ($export_excel == 0) {
            $this->load->view("reports/summary_categories_report", $data);
        } else {
            require_once APPPATH . "/third_party/Classes/report_sum_catalogy.php";
        }
    }

    //Summary customers report
    function summary_customers($start_date, $end_date, $sale_type, $export_excel = 0, $item_type) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);
        $data = array(
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "title" => lang('reports_customers_summary_report'),
            "subtitle" => 'Từ ' . date(get_date_format(), strtotime($start_date)) . ' đến ' . date(get_date_format(), strtotime($end_date)),
            "link" => 'reports/summary_customers',
            'start_date' => $start_date,
            'end_date' => $end_date,
            'sale_type' => $sale_type,
            'item_type' => $item_type
        );
        if ($export_excel == 0) {
            $this->load->view("reports/tabular", $data);
        } else {
            require_once APPPATH . "/third_party/Classes/report_customer.php";
        }
    }

    function summary_suppliers($start_date, $end_date, $sale_type, $export_excel = 0) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);
        $data = array(
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "title" => lang('reports_suppliers_summary_report'),
            "subtitle" => "Từ " . date("d-m-Y H:i:s", strtotime($start_date)) . ' đến ' . date("d-m-Y H:i:s", strtotime($end_date)),
            'start_date' => $start_date,
            'end_date' => $end_date,
            "export_excel" => $export_excel,
            "sale_type" => $sale_type
        );
        if ($export_excel == 0) {
            $this->load->view("reports/tabular_supplier", $data);
        } else {
            require_once APPPATH . "/third_party/Classes/summary_suppliers.php";
        }
    }

    //Summary suppliers report
    function summary_suppliers123($start_date, $end_date, $sale_type, $export_excel = 0) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);

        $this->load->model('reports/Summary_suppliers');
        $model = $this->Summary_suppliers;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $this->Receiving->create_receivings_items_temp_table(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $tabular_data = array();
        $report_data = $model->getData();
        die('ssssss');
        //$no_customer = $model->getNoSuppliersData();
        //$report_data = array_merge($no_customer,$report_data);


        foreach ($report_data as $row) {
            $tabular_data[] = array(
                array('data' => $row['company_name'], 'align' => 'left'),
                array('data' => $row['supplier_name'], 'align' => 'left'),
                array('data' => $row['items_purchased'], 'align' => 'right'),
                array('data' => to_currency($row['total']), 'align' => 'right'),
                //array('data'=>to_currency($row['tax']), 'align' => 'right'),
                array('data' => to_currency($row['profit']), 'align' => 'right'));
        }

        $data = array(
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "title" => lang('reports_suppliers_summary_report'),
            "subtitle" => 'Từ ' . date(get_date_format(), strtotime($start_date)) . ' đến ' . date(get_date_format(), strtotime($end_date)),
            "headers" => $model->getDataColumns(),
            "data" => $tabular_data,
            "summary_data" => $model->getSummaryData(),
            "export_excel" => $export_excel
        );


        if ($export_excel == 0) {
            $this->load->view("reports/tabular", $data);
        } else {
            require_once APPPATH . "/third_party/Classes/summary_suppliers.php";
        }
        //$this->load->view("reports/tabular",$data);
    }

    //Summary items report
    function summary_items($start_date, $end_date, $sale_type, $export_excel = 0, $item_type) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);
        if ($item_type != 4) {
            if ($item_type != 2) {
                $data_item = $this->Sale->get_item_id_in_sale_item($start_date, $end_date, $sale_type, $item_type);
            } else {
                $data_item = $this->Sale->get_pack_id_in_sale_pack($start_date, $end_date, $sale_type);
            }
        } else {
            $data_item1 = $this->Sale->get_item_id_in_sale_item($start_date, $end_date, $sale_type, $item_type);
            $data_item2 = $this->Sale->get_pack_id_in_sale_pack($start_date, $end_date, $sale_type);
            $data_item = array_merge($data_item1, $data_item2);
        }
        $data = array(
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "title" => 'Báo cáo tổng hợp mặt hàng',
            "subtitle" => 'Từ ' . date('d-m-Y', strtotime($start_date)) . ' đến ' . date('d-m-Y', strtotime($end_date)),
            "data_item" => $data_item,
            "export_excel" => $export_excel,
            'link' => 'reports/summary_items',
            'start_date' => $start_date,
            'end_date' => $end_date,
            'sale_type' => $sale_type,
            'item_type' => $item_type,
        );
        if ($export_excel == 0) {
            $this->load->view("reports/tabular_sum_item", $data);
        } else {
            require_once APPPATH . "/third_party/Classes/summary_items.php";
        }
    }

    //Summary item kits report
    function summary_item_kits($start_date, $end_date, $sale_type, $export_excel = 0) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);

        $this->load->model('reports/Summary_item_kits');
        $model = $this->Summary_item_kits;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $this->Sale->create_sales_items_temp_table(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $tabular_data = array();
        $report_data = $model->getData();

        foreach ($report_data as $row) {
            $tabular_data[] = array(
                array('data' => $row['name'], 'align' => 'left'),
                array('data' => $row['quantity_purchased'], 'align' => 'left'),
                array('data' => to_currency($row['subtotal']), 'align' => 'right'),
                array('data' => to_currency($row['tax']), 'align' => 'right'),
                array('data' => to_currency($row['total']), 'align' => 'right'),
                array('data' => to_currency($row['profit']), 'align' => 'right'));
        }

        $data = array(
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "title" => lang('reports_item_kits_summary_report'),
            "subtitle" => 'Từ ' . date(get_date_format(), strtotime($start_date)) . ' đến ' . date(get_date_format(), strtotime($end_date)),
            "headers" => $model->getDataColumns(),
            "data" => $tabular_data,
            "summary_data" => $model->getSummaryData(),
            "export_excel" => $export_excel,
            "link" => "reports/summary_item_kits",
        );
        if ($export_excel == 0) {
            $this->load->view("reports/tabular", $data);
        } else {
            require_once APPPATH . "/third_party/Classes/summary_item_kits.php";
        }
        //$this->load->view("reports/tabular",$data);
    }

    function summary_item_kits1($start_date, $end_date, $sale_type, $export_excel = 0) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);

        $this->load->model('reports/Summary_item_kits');
        $model = $this->Summary_item_kits;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));
        $this->Sale->create_sales_items_temp_table(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));
        $tabular_data = array();
        $report_data = $model->getData();
        foreach ($report_data as $row) {
            $tabular_data[] = array(
                array('data' => $row['name'], 'align' => 'left'),
                array('data' => $row['quantity_purchased'], 'align' => 'left'),
                array('data' => to_currency($row['subtotal']), 'align' => 'right'),
                array('data' => to_currency($row['total']), 'align' => 'right'),
                array('data' => to_currency($row['tax']), 'align' => 'right'),
                array('data' => to_currency($row['profit']), 'align' => 'right'));
        }
        $data = array(
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "title" => lang('reports_item_kits_summary_report'),
            "subtitle" => 'Từ ' . date(get_date_format(), strtotime($start_date)) . ' đến ' . date(get_date_format(), strtotime($end_date)),
            "headers" => $model->getDataColumns(),
            "data" => $tabular_data,
            "summary_data" => $model->getSummaryData(),
            "export_excel" => $export_excel
        );
        //  $this->load->view("reports/tabular", $data);
        if ($export_excel == 0) {
            $this->load->view("reports/tabular", $data);
        } else {
            require_once APPPATH . "/third_party/Classes/summary_item_kits.php";
        }
    }

    //Summary employees report
    function summary_employees($start_date, $end_date, $sale_type, $export_excel = 0, $item_type) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);
        $data = array(
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "title" => lang('reports_employees_summary_report'),
            "subtitle" => 'Từ ' . date(get_date_format(), strtotime($start_date)) . ' đến ' . date(get_date_format(), strtotime($end_date)),
            "export_excel" => $export_excel,
            "link" => "reports/summary_employees",
            'start_date' => $start_date,
            'end_date' => $end_date,
            'sale_type' => $sale_type,
            'item_type' => $item_type
        );
        if ($export_excel == 0) {
            $this->load->view("reports/tabular_employee", $data);
        } else {
            require_once APPPATH . "/third_party/Classes/report_sum_employ.php";
        }
    }

    //Summary taxes report
    function summary_taxes($start_date, $end_date, $sale_type, $export_excel = 0) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);

        $this->load->model('reports/Summary_taxes');
        $model = $this->Summary_taxes;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $this->Sale->create_sales_items_temp_table(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $tabular_data = array();
        $report_data = $model->getData();

        foreach ($report_data as $row) {
            $tabular_data[] = array(
                array('data' => $row['name'], 'align' => 'left'),
                array('data' => to_currency($row['tax']), 'align' => 'right'));
        }

        $data = array(
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "title" => lang('reports_taxes_summary_report'),
            "subtitle" => 'Từ ' . date(get_date_format(), strtotime($start_date)) . ' đến ' . date(get_date_format(), strtotime($end_date)),
            "headers" => $model->getDataColumns(),
            "data" => $tabular_data,
            "summary_data" => $model->getSummaryData(),
            "export_excel" => $export_excel,
            "link" => "reports/summary_taxes"
        );
        if ($export_excel == 0) {
            $this->load->view("reports/tabular", $data);
        } else {
            require_once APPPATH . "/third_party/Classes/summary_taxes.php";
        }

        //$this->load->view("reports/tabular",$data);
    }

    //Summary discounts report
    function summary_discounts($start_date, $end_date, $sale_type, $export_excel = 0, $item_type) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);

        $this->load->model('reports/Summary_discounts');
        $model = $this->Summary_discounts;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $this->Sale->create_sales_items_temp_table2(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        if ($item_type == 0) {
            $discount_get = $this->Sale->get_total_discount($start_date, $end_date, $sale_type);
        } elseif ($item_type == 1) {
            $discount_get = $this->Sale->get_total_discount_recv($start_date, $end_date, $sale_type);
        } else {
            $d1 = $this->Sale->get_total_discount($start_date, $end_date, $sale_type);
            $d2 = $this->Sale->get_total_discount_recv($start_date, $end_date, $sale_type);
            $discount_get = array_merge($d1, $d2);
        }
        $tabular_data = array();
        $report_data = $model->getData();

        foreach ($report_data as $row) {
            $tabular_data[] = array(array('data' => $row['discount_percent'], 'align' => 'left'), array('data' => $row['count'], 'align' => 'left'));
        }
        $data = array(
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "title" => lang('reports_discounts_summary_report'),
            "subtitle" => 'Từ ' . date('d-m-Y H:i:s', strtotime($start_date)) . ' đến ' . date('d-m-Y H:i:s', strtotime($end_date)),
            "headers" => $model->getDataColumns(),
            "data" => $tabular_data,
            "summary_data" => $model->getSummaryData(),
            "export_excel" => $export_excel,
            "link" => "reports/summary_discounts",
            "dis_get" => $discount_get,
        );
        if ($export_excel == 0) {
            $this->load->view("reports/summary_discount", $data);
        } else {
            require_once APPPATH . "/third_party/Classes/summary_discounts.php";
        }

        //$this->load->view("reports/tabular",$data);
    }

    function summary_payments($start_date, $end_date, $sale_type, $export_excel = 0) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);

        $this->load->model('reports/Summary_payments');
        $model = $this->Summary_payments;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $this->Sale->create_sales_items_temp_table2(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $tabular_data = array();
        $report_data = $model->getData();

        foreach ($report_data as $row) {
            $tabular_data[] = array(array('data' => $row['payment_type'], 'align' => 'left'), array('data' => to_currency($row['payment_amount']), 'align' => 'right'));
        }

        $data = array(
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "title" => lang('reports_payments_summary_report'),
            "subtitle" => 'Từ ' . date('d-m-Y H:s:i', strtotime($start_date)) . ' đến ' . date('d-m-Y H:s:i', strtotime($end_date)),
            "headers" => $model->getDataColumns(),
            "data" => $tabular_data,
            "summary_data" => $model->getSummaryData(),
            "export_excel" => $export_excel,
            "report_data" => $report_data,
            "start_date" => $start_date,
            "end_date" => $end_date,
            "sale_type" => $sale_type
        );
        if ($export_excel == 0) {
            $this->load->view("reports/sumary_payment_export", $data);
        } else {
            require_once APPPATH . "/third_party/Classes/summary_payments.php";
        }
    }

    //Input for reports that require only a date range. (see routes.php to see that all graphical summary reports route here)
    function date_input() {
        $data = $this->_get_common_report_data();
        $this->load->view("reports/date_input", $data);
    }

    //Graphical summary sales report
    function graphical_summary_sales($start_date, $end_date, $sale_type) {
        $start_date = rawurldecode($start_date);
        $end_date = date('Y-m-d 23:59:59', strtotime(rawurldecode($end_date)));

        $this->load->model('reports/Summary_sales');
        $model = $this->Summary_sales;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $this->Sale->create_sales_items_temp_table(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $data = array(
            "title" => lang('reports_sales_summary_report'),
            "graph_file" => site_url("reports/graphical_summary_sales_graph/$start_date/$end_date/$sale_type"),
            "subtitle" => 'Từ ' . date(get_date_format(), strtotime($start_date)) . ' đến ' . date(get_date_format(), strtotime($end_date)),
            "summary_data" => $model->getSummaryData()
        );

        $this->load->view("reports/graphical", $data);
    }

    //The actual graph data
    function graphical_summary_sales_graph($start_date, $end_date, $sale_type) {
        $start_date = rawurldecode($start_date);
        $end_date = date('Y-m-d 23:59:59', strtotime(rawurldecode($end_date)));

        $this->load->model('reports/Summary_sales');
        $model = $this->Summary_sales;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $this->Sale->create_sales_items_temp_table(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));
        $report_data = $model->getData();

        $graph_data = array();
        foreach ($report_data as $row) {
            $graph_data[strtotime($row['sale_date'])] = $row['total'];
        }

        $data = array(
            "title" => lang('reports_sales_summary_report'),
            "data" => $graph_data
        );

        $this->load->view("reports/graphs/line", $data);
    }

    //Graphical summary items report
    function graphical_summary_items($start_date, $end_date, $sale_type) {
        $start_date = rawurldecode($start_date);
        $end_date = date('Y-m-d 23:59:59', strtotime(rawurldecode($end_date)));

        $this->load->model('reports/Summary_items');
        $model = $this->Summary_items;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $this->Sale->create_sales_items_temp_table(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $data = array(
            "title" => lang('reports_items_summary_report'),
            "graph_file" => site_url("reports/graphical_summary_items_graph/$start_date/$end_date/$sale_type"),
            "subtitle" => 'Từ ' . date(get_date_format(), strtotime($start_date)) . ' đến ' . date(get_date_format(), strtotime($end_date)),
            "summary_data" => $model->getSummaryData()
        );

        $this->load->view("reports/graphical", $data);
    }

    //The actual graph data
    function graphical_summary_items_graph($start_date, $end_date, $sale_type) {
        $start_date = rawurldecode($start_date);
        $end_date = date('Y-m-d 23:59:59', strtotime(rawurldecode($end_date)));

        $this->load->model('reports/Summary_items');
        $model = $this->Summary_items;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $this->Sale->create_sales_items_temp_table(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));
        $report_data = $model->getData();

        $graph_data = array();
        foreach ($report_data as $row) {
            $graph_data[$row['name']] = $row['total'];
        }

        $data = array(
            "title" => lang('reports_items_summary_report'),
            "data" => $graph_data
        );

        $this->load->view("reports/graphs/pie", $data);
    }

    //Graphical summary item kits report
    function graphical_summary_item_kits($start_date, $end_date, $sale_type) {
        $start_date = rawurldecode($start_date);
        $end_date = date('Y-m-d 23:59:59', strtotime(rawurldecode($end_date)));

        $this->load->model('reports/Summary_item_kits');
        $model = $this->Summary_item_kits;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $this->Sale->create_sales_items_temp_table(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $data = array(
            "title" => lang('reports_item_kits_summary_report'),
            "graph_file" => site_url("reports/graphical_summary_item_kits_graph/$start_date/$end_date/$sale_type"),
            "subtitle" => 'Từ ' . date(get_date_format(), strtotime($start_date)) . ' đến ' . date(get_date_format(), strtotime($end_date)),
            "summary_data" => $model->getSummaryData()
        );

        $this->load->view("reports/graphical", $data);
    }

    //The actual graph data
    function graphical_summary_item_kits_graph($start_date, $end_date, $sale_type) {
        $start_date = rawurldecode($start_date);
        $end_date = date('Y-m-d 23:59:59', strtotime(rawurldecode($end_date)));

        $this->load->model('reports/Summary_item_kits');
        $model = $this->Summary_item_kits;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $this->Sale->create_sales_items_temp_table(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));
        $report_data = $model->getData();

        $graph_data = array();
        foreach ($report_data as $row) {
            $graph_data[$row['name']] = $row['total'];
        }

        $data = array(
            "title" => lang('reports_item_kits_summary_report'),
            "data" => $graph_data
        );

        $this->load->view("reports/graphs/pie", $data);
    }

    //Graphical summary customers report
    function graphical_summary_categories($start_date, $end_date, $sale_type) {
        $start_date = rawurldecode($start_date);
        $end_date = date('Y-m-d 23:59:59', strtotime(rawurldecode($end_date)));

        $this->load->model('reports/Summary_categories');
        $model = $this->Summary_categories;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $this->Sale->create_sales_items_temp_table(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $data = array(
            "title" => lang('reports_categories_summary_report'),
            "graph_file" => site_url("reports/graphical_summary_categories_graph/$start_date/$end_date/$sale_type"),
            "subtitle" => 'Từ ' . date(get_date_format(), strtotime($start_date)) . ' đến ' . date(get_date_format(), strtotime($end_date)),
            "summary_data" => $model->getSummaryData()
        );
        $this->load->view("reports/graphical", $data);
    }

    //The actual graph data
    function graphical_summary_categories_graph($start_date, $end_date, $sale_type) {
        $start_date = rawurldecode($start_date);
        $end_date = date('Y-m-d 23:59:59', strtotime(rawurldecode($end_date)));

        $this->load->model('reports/Summary_categories');
        $model = $this->Summary_categories;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $this->Sale->create_sales_items_temp_table(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $report_data = $model->getData();

        $graph_data = array();
        foreach ($report_data as $row) {
            $graph_data[$row['category']] = $row['total'];
        }

        $data = array(
            "title" => lang('reports_categories_summary_report'),
            "data" => $graph_data
        );

        $this->load->view("reports/graphs/pie", $data);
    }

    function graphical_summary_suppliers($start_date, $end_date, $sale_type) {
        $start_date = rawurldecode($start_date);
        $end_date = date('Y-m-d 23:59:59', strtotime(rawurldecode($end_date)));

        $this->load->model('reports/Summary_suppliers_grap');
        $model = $this->Summary_suppliers_grap;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $this->Sale->create_sales_items_temp_table(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $data = array(
            "title" => lang('reports_suppliers_summary_report'),
            "graph_file" => site_url("reports/graphical_summary_suppliers_graph/$start_date/$end_date/$sale_type"),
            "subtitle" => 'Từ ' . date(get_date_format(), strtotime($start_date)) . ' đến ' . date(get_date_format(), strtotime($end_date)),
            "summary_data" => $model->getSummaryData()
        );

        $this->load->view("reports/graphical", $data);
    }

    //The actual graph data
    function graphical_summary_suppliers_graph($start_date, $end_date, $sale_type) {
        $start_date = rawurldecode($start_date);
        $end_date = date('Y-m-d 23:59:59', strtotime(rawurldecode($end_date)));

        $this->load->model('reports/Summary_suppliers_grap');
        $model = $this->Summary_suppliers_grap;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $this->Sale->create_sales_items_temp_table(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $report_data = $model->getData();

        $graph_data = array();
        foreach ($report_data as $row) {
            $graph_data[$row['supplier']] = $row['total'];
        }

        $data = array(
            "title" => lang('reports_suppliers_summary_report'),
            "data" => $graph_data
        );

        $this->load->view("reports/graphs/pie", $data);
    }

    function graphical_summary_suppliers1($start_date, $end_date, $sale_type) {
        $start_date = rawurldecode($start_date);
        $end_date = date('Y-m-d 23:59:59', strtotime(rawurldecode($end_date)));

        $this->load->model('reports/Summary_suppliers');
        $model = $this->Summary_suppliers;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $this->Sale->create_sales_items_temp_table(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $data = array(
            "title" => lang('reports_suppliers_summary_report'),
            "graph_file" => site_url("reports/graphical_summary_suppliers_graph/$start_date/$end_date/$sale_type"),
            "subtitle" => 'Từ ' . date(get_date_format(), strtotime($start_date)) . ' đến ' . date(get_date_format(), strtotime($end_date)),
            "summary_data" => $model->getSummaryData()
        );

        $this->load->view("reports/graphical", $data);
    }

    //The actual graph data
    function graphical_summary_suppliers_graph1($start_date, $end_date, $sale_type) {
        $start_date = rawurldecode($start_date);
        $end_date = date('Y-m-d 23:59:59', strtotime(rawurldecode($end_date)));

        $this->load->model('reports/Summary_suppliers');
        $model = $this->Summary_suppliers;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $this->Sale->create_sales_items_temp_table(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $report_data = $model->getData();

        $graph_data = array();
        foreach ($report_data as $row) {
            $graph_data[$row['supplier']] = $row['total'];
        }

        $data = array(
            "title" => lang('reports_suppliers_summary_report'),
            "data" => $graph_data
        );

        $this->load->view("reports/graphs/pie", $data);
    }

    function graphical_summary_employees($start_date, $end_date, $sale_type) {
        $start_date = rawurldecode($start_date);
        $end_date = date('Y-m-d 23:59:59', strtotime(rawurldecode($end_date)));

        $this->load->model('reports/Summary_employees');
        $model = $this->Summary_employees;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $this->Sale->create_sales_items_temp_table(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $data = array(
            "title" => lang('reports_employees_summary_report'),
            "graph_file" => site_url("reports/graphical_summary_employees_graph/$start_date/$end_date/$sale_type"),
            "subtitle" => 'Từ ' . date(get_date_format(), strtotime($start_date)) . ' đến ' . date(get_date_format(), strtotime($end_date)),
            "summary_data" => $model->getSummaryData()
        );

        $this->load->view("reports/graphical", $data);
    }

    //The actual graph data
    function graphical_summary_employees_graph($start_date, $end_date, $sale_type) {
        $start_date = rawurldecode($start_date);
        $end_date = date('Y-m-d 23:59:59', strtotime(rawurldecode($end_date)));

        $this->load->model('reports/Summary_employees');
        $model = $this->Summary_employees;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $this->Sale->create_sales_items_temp_table(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));
        $report_data = $model->getData();

        $graph_data = array();
        foreach ($report_data as $row) {
            $graph_data[$row['employee']] = $row['total'];
        }

        $data = array(
            "title" => lang('reports_employees_summary_report'),
            "data" => $graph_data
        );

        $this->load->view("reports/graphs/bar", $data);
    }

    function graphical_summary_taxes($start_date, $end_date, $sale_type) {
        $start_date = rawurldecode($start_date);
        $end_date = date('Y-m-d 23:59:59', strtotime(rawurldecode($end_date)));

        $this->load->model('reports/Summary_taxes');
        $model = $this->Summary_taxes;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $this->Sale->create_sales_items_temp_table(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $data = array(
            "title" => lang('reports_taxes_summary_report'),
            "graph_file" => site_url("reports/graphical_summary_taxes_graph/$start_date/$end_date/$sale_type"),
            "subtitle" => 'Từ ' . date(get_date_format(), strtotime($start_date)) . ' đến ' . date(get_date_format(), strtotime($end_date)),
            "summary_data" => $model->getSummaryData()
        );

        $this->load->view("reports/graphical", $data);
    }

    //The actual graph data
    function graphical_summary_taxes_graph($start_date, $end_date, $sale_type) {
        $start_date = rawurldecode($start_date);
        $end_date = date('Y-m-d 23:59:59', strtotime(rawurldecode($end_date)));

        $this->load->model('reports/Summary_taxes');
        $model = $this->Summary_taxes;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $this->Sale->create_sales_items_temp_table(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));
        $report_data = $model->getData();

        $graph_data = array();
        foreach ($report_data as $row) {
            $graph_data[$row['name']] = $row['tax'];
        }

        $data = array(
            "title" => lang('reports_taxes_summary_report'),
            "data" => $graph_data
        );

        $this->load->view("reports/graphs/bar", $data);
    }

    //Graphical summary customers report
    function graphical_summary_customers($start_date, $end_date, $sale_type) {
        $start_date = rawurldecode($start_date);
        $end_date = date('Y-m-d 23:59:59', strtotime(rawurldecode($end_date)));

        $this->load->model('reports/Summary_customers');
        $model = $this->Summary_customers;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $this->Sale->create_sales_items_temp_table(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $data = array(
            "title" => lang('reports_customers_summary_report'),
            "graph_file" => site_url("reports/graphical_summary_customers_graph/$start_date/$end_date/$sale_type"),
            "subtitle" => 'Từ ' . date(get_date_format(), strtotime($start_date)) . ' đến ' . date(get_date_format(), strtotime($end_date)),
            "summary_data" => $model->getSummaryData()
        );

        $this->load->view("reports/graphical", $data);
    }

    //The actual graph data
    function graphical_summary_customers_graph($start_date, $end_date, $sale_type) {
        $start_date = rawurldecode($start_date);
        $end_date = date('Y-m-d 23:59:59', strtotime(rawurldecode($end_date)));
        $this->load->model('reports/Summary_customers');
        $model = $this->Summary_customers;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $this->Sale->create_sales_items_temp_table(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $report_data = $model->getData();

        $graph_data = array();
        foreach ($report_data as $row) {
            $graph_data[$row['customer']] = $row['total'];
        }

        $data = array(
            "title" => lang('reports_customers_summary_report'),
            "data" => $graph_data
        );

        $this->load->view("reports/graphs/pie", $data);
    }

    //Graphical summary discounts report
    function graphical_summary_discounts($start_date, $end_date, $sale_type) {
        $start_date = rawurldecode($start_date);
        $end_date = date('Y-m-d 23:59:59', strtotime(rawurldecode($end_date)));

        $this->load->model('reports/Summary_discounts');
        $model = $this->Summary_discounts;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $this->Sale->create_sales_items_temp_table(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $data = array(
            "title" => lang('reports_discounts_summary_report'),
            "graph_file" => site_url("reports/graphical_summary_discounts_graph/$start_date/$end_date/$sale_type"),
            "subtitle" => 'Từ ' . date(get_date_format(), strtotime($start_date)) . ' đến ' . date(get_date_format(), strtotime($end_date)),
            "summary_data" => $model->getSummaryData()
        );

        $this->load->view("reports/graphical", $data);
    }

    //The actual graph data
    function graphical_summary_discounts_graph($start_date, $end_date, $sale_type) {
        $start_date = rawurldecode($start_date);
        $end_date = date('Y-m-d 23:59:59', strtotime(rawurldecode($end_date)));

        $this->load->model('reports/Summary_discounts');
        $model = $this->Summary_discounts;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $this->Sale->create_sales_items_temp_table(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));
        $report_data = $model->getData();

        $graph_data = array();
        foreach ($report_data as $row) {
            $graph_data[$row['discount_percent']] = $row['count'];
        }

        $data = array(
            "title" => lang('reports_discounts_summary_report'),
            "data" => $graph_data
        );

        $this->load->view("reports/graphs/bar", $data);
    }

    function graphical_summary_payments($start_date, $end_date, $sale_type) {
        $start_date = rawurldecode($start_date);
        $end_date = date('Y-m-d 23:59:59', strtotime(rawurldecode($end_date)));

        $this->load->model('reports/Summary_payments');
        $model = $this->Summary_payments;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $this->Sale->create_sales_items_temp_table(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $data = array(
            "title" => lang('reports_payments_summary_report'),
            "graph_file" => site_url("reports/graphical_summary_payments_graph/$start_date/$end_date/$sale_type"),
            "subtitle" => 'Từ ' . date(get_date_format(), strtotime($start_date)) . ' đến ' . date(get_date_format(), strtotime($end_date)),
            "summary_data" => $model->getSummaryData()
        );

        $this->load->view("reports/graphical", $data);
    }

    //The actual graph data
    function graphical_summary_payments_graph($start_date, $end_date, $sale_type) {
        $start_date = rawurldecode($start_date);
        $end_date = date('Y-m-d 23:59:59', strtotime(rawurldecode($end_date)));

        $this->load->model('reports/Summary_payments');
        $model = $this->Summary_payments;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $this->Sale->create_sales_items_temp_table(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));
        $report_data = $model->getData();

        $graph_data = array();
        foreach ($report_data as $row) {
            $graph_data[$row['payment_type']] = $row['payment_amount'];
        }

        $data = array(
            "title" => lang('reports_payments_summary_report'),
            "data" => $graph_data
        );

        $this->load->view("reports/graphs/bar", $data);
    }

    function specific_customer_input() {
        $data = $this->_get_common_report_data(TRUE);
        $data['specific_input_name'] = lang('reports_customer');
        $data['title'] = 'Báo cáo chi tiết khách hàng';
        $data['url'] = site_url() . '/reports/specific_customer';
        $customers = array();
        $customers[] = 'Khách lẻ';
        foreach ($this->Customer->get_all()->result() as $customer) {

            $customers[$customer->person_id] = $customer->first_name . ' ' . $customer->last_name;
        }
        $data['specific_input_data'] = $customers;
        $this->load->view("reports/specific_input", $data);
    }

    function specific_customer($start_date, $end_date, $customer_id, $sale_type, $report_type, $export_excel = 0) {
        $this->load->model('Money_birthdate');
        $this->load->model('Customer');
        $money_birth = $this->Customer->get_info($customer_id);
        $money_birth_date = $money_birth->money_birth;
        //end phần làm
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);

        /* OOOO Hưng Audi 6-4-15 */
        $data_sale_customer = $this->Sale->get_sale_by_customer_specific_customer($customer_id, $sale_type, $report_type);
        $data_all_sale = array();
        foreach ($data_sale_customer as $key => $val) {
            $sale_tam_data = $this->Sale->get_sales_tam_by_date_detail_specific_customer($start_date, $end_date, $val['sale_id'], $customer_id); //lay giao dich don hang trong khoang
            $data_all_sale[$val['sale_id']] = $sale_tam_data;
        }
        foreach ($data_all_sale as $val) {
            foreach ($val as $val1) {
                $data_sale_id[] = $val1['id_sale'];
            }
        }
        $sale_id_array = array_unique($data_sale_id); // lay mang cac don hang khong trung lap

        foreach ($sale_id_array as $val) {
            $data_sale_item = $this->Sale->get_sale_item_by_sale_id_specific_customer($val, $report_type); // lay thong tin item trong don hang
            $data_sale_item_kit = $this->Sale->get_sale_item_kit_by_sale_id($val); //lay thong tin item_kit trong don hang
            $detail_sale[$val][] = $data_sale_item;
            $data_sale_tam = $this->Sale->get_sales_tam($val);
            $total_discount = 0;
            $total_item = 0;
            $total_item_kit = 0;
            foreach ($data_sale_tam as $val1) { // tinh tong chiet khau
                $total_discount = $total_discount + $val1['discount_money'];
            }
            $sale_data = $this->Sale->get_info($val)->row();
            $total_tax_item = 0; // tong thue item
            $discount_item = 0; //tong giam gia
            $total_cost_item = 0; // tong gia tri item
            foreach ($data_sale_item as $value) {
                $total_item = $total_item + $value['quantity_purchased'];
                $cost_item = ($value['item_unit_price'] - $value['item_unit_price'] * $value['discount_percent'] / 100) * $value['quantity_purchased'];
                $cost_price[] = $cost_item . '-';
                $total_cost_item = $total_cost_item + $cost_item;
                $tax_array = $this->Sale->get_tax_item($value['item_id'], $val); //thue item
                $tax_item = 0;
                if (count($tax_array) > 0) {
                    foreach ($tax_array as $tax) {
                        $tax_item = $tax_item + $tax['percent'] * $cost_item / 100;
                        $tax_array[] = ($tax['percent'] * $cost_item / 100) . '-';
                    }
                }
                $total_tax_item = $total_tax_item + $tax_item;
            }
            $total_tax_item_kit = 0; //tong thue item_kit
            $discount_item_kit = 0; //tong thue item_kit
            $total_cost_item_kit = 0; // tong gia tri item_kit
            foreach ($data_sale_item_kit as $value) {
                $total_item_kit = $total_item_kit + $value['quantity_purchased'];
                $cost_item_kit = ($value['item_unit_price'] - ($value['item_unit_price'] * $value['discount_percent'] / 100)) * $value['quantity_purchased'];
                $total_cost_item_kit = $total_cost_item_kit + $cost_item_kit;
                $tax_array = $this->Sale->get_tax_item_kit($value['item_id'], $val); //thue item
                $tax_item_kit = 0;
                if (count($tax_array) > 0) {
                    foreach ($tax_array as $tax) {
                        $tax_item_kit = $tax_item_kit + $tax['percent'] * $cost_item_kit / 100;
                    }
                }
                $total_tax_item_kit = $total_tax_item_kit + $tax_item_kit;
            }
            $info_total_sale[$val]['total_item'] = $total_item + $total_item_kit;
            $info_total_sale[$val]['total_profit'] = $total_profit;
            $info_total_sale[$val]['later_cost_price'] = $total_cost_item_kit + $total_cost_item + $total_tax_item + $total_tax_item_kit;
            $info_total_sale[$val]['total_discount'] = $info_total_sale[$val]['later_cost_price'] - $total_discount;
        }
        $customer_info = $this->Customer->get_info($customer_id);
        $customer_city = $this->Customer->get_city_name($customer_info->city);
        $data = array(
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "full_name" => $customer_info->last_name,
            "title" => $this->Customer->get_info($customer_id)->company_name . ' ' . $this->Customer->get_info($customer_id)->manages_name . ' ' . $this->Customer->get_info($customer_id)->first_name . ' ' . $this->Customer->get_info($customer_id)->last_name,
            "subtitle" => 'Từ ' . date(get_date_format(), strtotime($start_date)) . ' đến ' . date(get_date_format(), strtotime($end_date)),
            "export_excel" => $export_excel,
            "cus" => $cus,
            "total" => $total,
            "money_total" => $money_birth_date,
            "person_id" => $customer_id,
            "city" => $customer_city->name,
            "phone_number" => $customer_info->phone_number,
            "email" => $customer_info->email,
            "address" => $customer_info->address_1,
            "name_customer" => $customer_info->first_name . ' ' . $customer_info->last_name,
            "info_total_sale" => $info_total_sale,
            "data_all_sale" => $data_all_sale,
            "detail_sale" => $detail_sale,
            'item_type' => $report_type
        );
        if ($export_excel == 0) {
            $this->load->view("reports/tabular_details", $data);
        } else {
            require_once APPPATH . "/third_party/Classes/report_detail_customer.php";
        }
    }

    function specific_employee_input() {

        $data = $this->_get_common_report_data(TRUE);
        $data['specific_input_name'] = lang('reports_employee');
        $data['title'] = 'Báo cáo chi tiết nhân viên';
        $data['url'] = site_url() . '/reports/specific_employee';
        $employees = array();
        foreach ($this->Employee->get_all_receiving()->result() as $employee) {
            $employees[$employee->person_id] = $employee->first_name . ' ' . $employee->last_name;
        }
        $data['specific_input_data'] = $employees;
        $this->load->view("reports/specific_employee_input", $data);
    }

    //bc cũ
    function specific_employee12($start_date, $end_date, $employee_id, $sale_type, $export_excel = 0) {

        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);

        $this->load->model('reports/Specific_employee');
        $model = $this->Specific_employee;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'employee_id' => $employee_id, 'sale_type' => $sale_type));

        $this->Sale->create_sales_items_temp_table(array('start_date' => $start_date, 'end_date' => $end_date, 'employee_id' => $employee_id, 'sale_type' => $sale_type));
        $headers = $model->getDataColumns();
        $report_data = $model->getData();

        $summary_data = array();
        $details_data = array();

        foreach ($report_data['summary'] as $key => $row) {
            $summary_data[] = array(array('data' => anchor('sales/edit/' . $row['sale_id'], lang('common_edit') . ' ' . $row['sale_id'], array('target' => '_blank')), 'align' => 'left'),
                array('data' => date(get_date_format() . '-' . get_time_format(), strtotime($row['sale_time'])), 'align' => 'left'),
                array('data' => $row['items_purchased'], 'align' => 'left'),
                array('data' => $row['customer_name'], 'align' => 'left'),
                array('data' => to_currency($row['subtotal']), 'align' => 'right'),
                array('data' => $row['discount_percent'], 'align' => 'right'),
                array('data' => to_currency($row['total']), 'align' => 'right'),
                array('data' => to_currency($row['tax']), 'align' => 'right'),
                array('data' => to_currency($row['profit']), 'align' => 'right'),
                array('data' => $row['payment_type'], 'align' => 'left'),
                array('data' => $row['comment'], 'align' => 'left'));

            foreach ($report_data['details'][$key] as $drow) {
                $details_data[$key][] = array(array('data' => isset($drow['item_name']) ? $drow['item_name'] : $drow['item_kit_name'], 'align' => 'left'), array('data' => $drow['category'], 'align' => 'left'), array('data' => $drow['serialnumber'], 'align' => 'left'), array('data' => $drow['description'], 'align' => 'left'), array('data' => $drow['quantity_purchased'], 'align' => 'left'), array('data' => to_currency($drow['subtotal']), 'align' => 'right'), array('data' => to_currency($drow['total']), 'align' => 'right'), array('data' => to_currency($drow['tax']), 'align' => 'right'), array('data' => to_currency($drow['profit']), 'align' => 'right'), array('data' => $drow['discount_percent'] . '%', 'align' => 'left'));
            }
        }

        $employee_info = $this->Employee->get_info($employee_id);
        $data = array(
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "title" => $employee_info->first_name . ' ' . $employee_info->last_name . ' ' . lang('reports_report'),
            "subtitle" => 'Từ ' . date(get_date_format(), strtotime($start_date)) . ' đến ' . date(get_date_format(), strtotime($end_date)),
            "headers" => $model->getDataColumns(),
            "summary_data" => $summary_data,
            "details_data" => $details_data,
            "overall_summary_data" => $model->getSummaryData(),
            "export_excel" => $export_excel
        );
        if ($export_excel == 0) {
            $this->load->view("reports/tabular_details", $data);
        } else {
            require_once APPPATH . "/third_party/Classes/specific_employee.php";
        }
        //$this->load->view("reports/tabular_details",$data);
    }

    //end bc cũ
    function specific_employee($start_date, $end_date, $employee_id, $sale_type, $report_type, $export_excel = 0) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);
        //hung audi 6-6-15
        $data_sale_employee = $this->Sale->get_sale_revenue_employee($employee_id, $sale_type, $report_type); // Lay don hang theo nhan vien  
        foreach ($data_sale_employee as $key => $val) {
            //lay giao dich don hang trong khoang
            $sale_tam_data = $this->Sale->get_sales_tam_by_date_detail_sale_revenue2($start_date, $end_date, $val['sale_id']);
            $data_all_sale[$val['sale_id']] = $sale_tam_data;
        }
        foreach ($data_all_sale as $val) {
            foreach ($val as $val1) {
                $data_sale_id[] = $val1['id_sale'];
            }
        }
        $sale_id_array = array_unique($data_sale_id); // lay mang cac don hang khong trung lap
        foreach ($sale_id_array as $val) {
            $data_sale_item = $this->Sale->get_sale_item_revenue_employee($val, $report_type); // lay thong tin item trong don hang
            $detail_sale[$val][] = $data_sale_item;
            $data_sale_tam = $this->Sale->get_sales_tam($val);
            $total_discount = 0;
            $total_item = 0;
            $total_item_kit = 0;
            foreach ($data_sale_tam as $val1) { // tinh tong chiet khau
                $total_discount = $total_discount + $val1['discount_money'];
            }
            $sale_data = $this->Sale->get_info($val)->row();
            $total_profit = 0;
            foreach ($data_sale_item as $value) {  // tinh tong loi nhuan item
                $total_profit = $total_profit + (($value['item_unit_price'] - $value['item_cost_price']) * $value['quantity_purchased']) - $total_discount;
                $total_item = $total_item + $value['quantity_purchased'];
            }

            foreach ($data_sale_item_kit as $value) {
                $total_item_kit = $total_item_kit + $value['quantity_purchased'];
            }
            $info_total_sale[$val]['total_item'] = $total_item + $total_item_kit;
            $info_total_sale[$val]['total_profit'] = $total_profit;
            $info_total_sale[$val]['later_cost_price'] = $sale_data->later_cost_price;
            $info_total_sale[$val]['total_discount'] = $sale_data->later_cost_price - $total_discount;
        }

        $employee_info = $this->Employee->get_info($employee_id);
        $customer_city = $this->Customer->get_city_name($customer_info->city);
        $data = array(
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "full_name" => $employee_info->last_name,
            "title" => lang('reports_report') . ' chi tiết nhân viên ' . $employee_info->first_name . ' ' . $employee_info->last_name,
            "subtitle" => 'Từ ' . date('d-m-Y H:i:s', strtotime($start_date)) . ' đến ' . date('d-m-Y H:i:s', strtotime($end_date)),
            "info_total_sale" => $info_total_sale,
            "data_all_sale" => $data_all_sale, //***
            "detail_sale" => $detail_sale,
            "report_type" => $report_type
        );
        if ($export_excel == 0) {
            $this->load->view("reports/tabular_details_employee", $data);
        } else {
            require_once APPPATH . "/third_party/Classes/specific_employee.php";
        }
    }

    //đơn hàng cũ
    function detailed_sales12($start_date, $end_date, $sale_type, $export_excel = 0) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);

        $this->load->model('reports/Detailed_sales');
        $model = $this->Detailed_sales;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $this->Sale->create_sales_items_temp_table(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $headers = $model->getDataColumns();
        $report_data = $model->getData();

        $summary_data = array();
        $details_data = array();

        foreach ($report_data['summary'] as $key => $row) {
            $summary_data[] = array(
                array('data' => anchor('sales/edit/' . $row['sale_id'], '<img src="' . base_url() . 'images/pieces/edit.gif" title="' . lang('common_edit') . '" >', array('target' => '_blank')) . ' ' . anchor('sales/edit/' . $row['sale_id'], lang('common_edit') . ' ' . $row['sale_id'], array('target' => '_blank')), 'align' => 'center'),
                array('data' => date(get_date_format() . '-' . get_time_format(), strtotime($row['sale_time'])), 'align' => 'center'),
                array('data' => $row['items_purchased'], 'align' => 'center'),
                array('data' => $row['employee_name'], 'align' => 'center'),
                array('data' => $row['customer_name'], 'align' => 'center'),
                array('data' => to_currency($row['subtotal']), 'align' => 'right'),
                array('data' => to_currency($row['total']), 'align' => 'right'),
                array('data' => to_currency($row['tax']), 'align' => 'right'),
                array('data' => to_currency($row['profit']), 'align' => 'right'),
                array('data' => $row['payment_type'], 'align' => 'center'),
                array('data' => $row['comment'], 'align' => 'center'));

            foreach ($report_data['details'][$key] as $drow) {
                $details_data[$key][] = array(
                    //array('data'=>isset($drow['item_number']) ? $drow['item_number'] : $drow['item_kit_number'], 'align'=>'center'),
                    array('data' => isset($drow['item_number']) ? $drow['item_number'] : $drow['item_kit_number'], 'align' => 'center'),
                    array('data' => isset($drow['item_name']) ? $drow['item_name'] : $drow['item_kit_name'], 'align' => 'center'),
                    array('data' => $drow['category'], 'align' => 'center'),
                    array('data' => $drow['serialnumber'], 'align' => 'center'),
                    array('data' => $drow['description'], 'align' => 'center'),
                    array('data' => $drow['quantity_purchased'], 'align' => 'center'),
                    array('data' => to_currency($drow['subtotal']), 'align' => 'right'),
                    array('data' => to_currency($drow['total']), 'align' => 'right'),
                    array('data' => to_currency($drow['tax']), 'align' => 'right'),
                    array('data' => to_currency($drow['profit']), 'align' => 'right'),
                    array('data' => $drow['discount_percent'] . '%', 'align' => 'center'));
            }
        }

        $data = array(
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "title" => lang('reports_detailed_sales_report'),
            "subtitle" => 'Từ ' . date(get_date_format(), strtotime($start_date)) . ' đến ' . date(get_date_format(), strtotime($end_date)),
            "headers" => $model->getDataColumns(),
            "summary_data" => $summary_data,
            "details_data" => $details_data,
            "overall_summary_data" => $model->getSummaryData(),
            "export_excel" => $export_excel
        );
        if ($export_excel == 0) {
            $this->load->view("reports/tabular_details", $data);
        } else {
            require_once APPPATH . "/third_party/Classes/detailed_sales.php";
        }

        //$this->load->view("reports/tabular_details",$data);
    }

    function detailed_sales($start_date, $end_date, $sale_type, $export_excel = 0, $item_type) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);
        $data['title'] = 'Báo cáo chi tiết đơn hàng';
        // loi
        if ($item_type != 4) {
            if ($item_type != 2) {
                $data_sale_detail_tam = $this->Sale->get_sale_by_detail_all_item($start_date, $end_date, $sale_type, $item_type);  // lay tat ca don hang
            } else {
                $data_sale_detail_tam = $this->Sale->get_sale_in_sale_pack($start_date, $end_date, $sale_type);  // lay tat ca don hang
            }
        } else {
            $data_sale_detail1 = $this->Sale->get_sale_by_detail_all_item($start_date, $end_date, $sale_type, $item_type);
            $data_sale_detail2 = $this->Sale->get_sale_in_sale_pack($start_date, $end_date, $sale_type);
            $data_sale_detail_tam = array_merge($data_sale_detail1, $data_sale_detail2);
        }
        foreach ($data_sale_detail_tam as $data) {
            $data_sale_detail_tam1[] = $data['sale_id'];
        }
        $data_sale_detail = array_unique($data_sale_detail_tam1);
        foreach ($data_sale_detail as $val) {
            if ($item_type != 4) {
                if ($item_type != 2) {
                    $data_sale_item_tam = $this->Sale->get_sale_item_by_sale_id_item2($val, $item_type);
                } else {
                    $data_sale_item_tam = $this->Sale->get_sale_pack_by_sale_id($val);
                }
            } else {
                $data_sale_item2 = $this->Sale->get_sale_pack_by_sale_id($val);
                $data_sale_item1 = $this->Sale->get_sale_item_by_sale_id_item2($val, $item_type);
                $data_sale_item_tam = array_merge($data_sale_item1, $data_sale_item2);
            }
            $data_sale_item[$val][] = $data_sale_item_tam;

            $data_sale_tam = $this->Sale->get_sales_tam($val);
            $total_discount = 0;
            foreach ($data_sale_tam as $val1) { // tinh tong chiet khau
                $total_discount = $total_discount + $val1['discount_money'];
            }
            $sale_data = $this->Sale->get_info($val)->row();
            $info_total_sale[$val]['total_discount'] = $sale_data->later_cost_price - $total_discount;
        }
        $customer_info = $this->Customer->get_info($customer_id);
        $customer_city = $this->Customer->get_city_name($customer_info->city);
        $data = array(
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "full_name" => $customer_info->last_name,
            "title" => lang('reports_detailed_sales_report'),
            "subtitle" => 'Từ ' . date('d-m-Y H:i:s', strtotime($start_date)) . ' đến ' . date('d-m-Y H:i:s', strtotime($end_date)),
            "info_total_sale" => $info_total_sale,
            "data_all_sale" => $data_sale_detail,
            "data_sale_item" => $data_sale_item,
            'item_type' => $item_type
        );
        if ($export_excel == 0) {
            $this->load->view("reports/tabular_details_sales", $data);
        } else {
            require_once APPPATH . "/third_party/Classes/detailed_sales.php";
        }
    }

    function specific_supplier_input() {
        $data = $this->_get_common_report_data(TRUE);
        $data['specific_input_name'] = lang('reports_supplier');
        $data['title'] = 'Báo cáo chi tiết nhà cung cấp';
        $data['url'] = site_url() . '/reports/specific_supplier';
        $suppliers = array();
        foreach ($this->Supplier->get_all()->result() as $supplier) {
            //$suppliers[$supplier->person_id] = $supplier->first_name .' '.$supplier->last_name;
            $suppliers[$supplier->person_id] = $supplier->company_name . ' - ' . $supplier->first_name;
        }
        $data['specific_input_data'] = $suppliers;
        //$this->load->view("reports/specific_input", $data);
        $this->load->view("reports/specific_input_suppliers", $data);
    }

    function specific_supplier($start_date, $end_date, $supplier_id, $sale_type, $export_excel = 0) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);

        $this->load->model('reports/Specific_supplier');
        $model = $this->Specific_supplier;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'supplier_id' => $supplier_id, 'sale_type' => $sale_type));

        $this->Receiving->create_receivings_items_temp_table(array('start_date' => $start_date, 'end_date' => $end_date, 'supplier_id' => $supplier_id, 'sale_type' => $sale_type));

        $headers = $model->getDataColumns();
        $report_data = $model->getData();

        $summary_data = array();
        $details_data = array();
                  
        foreach ($report_data['summary'] as $key => $row) {
            $summary_data[] = array(
                array('data' => anchor('receivings/edit/' . $row['receiving_id'], 'RECV ' . $row['receiving_id'], array('target' => '_blank')), 'align' => 'left'),
                array('data' => date(get_date_format(), strtotime($row['receiving_date'])), 'align' => 'left'),
                array('data' => $row['supplier_name'], 'align' => 'left'),
                array('data' => $row['employee_name'], 'align' => 'left'),
                array('data' => format_quantity($row['items_purchased']), 'align' => 'right'),
                array('data' => to_currency($row['total']), 'align' => 'right'),
                array('data' => number_format($this->Receiving->get_info($row['receiving_id'])->row()->other_cost), 'align' => 'right'),
                array('data' => number_format($this->Receiving->get_info($row['receiving_id'])->row()->money_1331), 'align' => 'right'),
               
                array('data' => to_currency($row['total']+$this->Receiving->get_info($row['receiving_id'])->row()->other_cost+$this->Receiving->get_info($row['receiving_id'])->row()->money_1331), 'align' => 'right'),
                array('data' => $row['comment'], 'align' => 'left'));

            foreach ($report_data['details'][$key] as $drow) {
                $name_unit = $this->Unit->get_info($drow['unit'])->name;
                $details_data[$key][] = array(
                    array('data' => $drow['item_number'], 'align' => 'center'),
                    array('data' => $drow['name'], 'align' => 'left'),
                    array('data' => $drow['category'], 'align' => 'left'),
                    array('data' => $name_unit, 'align' => 'left'),
                    array('data' => format_quantity($drow['quantity_purchased']), 'align' => 'right'),
                    array('data' => to_currency($drow['subtotal']), 'align' => 'right'),
                    array('data' => $drow['discount_percent'] . '%', 'align' => 'right'),
                    array('data' => to_currency($drow['total']), 'align' => 'right'),
                    array('data' => ($drow['description']), 'align' => 'left')
                );
            }
        }
        $suppliers_info = $this->Supplier->get_info($supplier_id);
        $data = array(
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "company_name" => $suppliers_info->company_name,
            "title" => 'Báo cáo chi tiết nhà sản xuất',
            //"subtitle" => 'Từ '.date(get_date_format(), strtotime($start_date)) .' đến '.date(get_date_format(), strtotime($end_date)),
            "subtitle" => 'Từ ' . date('d-m-Y H:i:s', strtotime($start_date)) . ' đến ' . date('d-m-Y H:i:s', strtotime($end_date)),
            "headers" => $model->getDataColumns(),
            "summary_data" => $summary_data,
            "details_data" => $details_data,
            "overall_summary_data" => $model->getSummaryData(),
            "export_excel" => $export_excel,
            "link" => "reports/specific_supplier",
        );
        if ($export_excel == 0) {
            $this->load->view("reports/tabular_details_supplier", $data);
        } else {
            require_once APPPATH . "/third_party/Classes/specific_supplier.php";
        }
    }

    function deleted_sales($start_date, $end_date, $sale_type, $export_excel = 0) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);

        $this->load->model('reports/Deleted_sales');
        $model = $this->Deleted_sales;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $this->Sale->create_sales_items_temp_table(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $headers = $model->getDataColumns();
        $report_data = $model->getData();

        $summary_data = array();
        $details_data = array();
        //print_r($report_data);
        //die('sssss');
        foreach ($report_data['summary'] as $key => $row) {
            $summary_data[] = array(
                array('data' => anchor('sales/edit/' . $row['sale_id'], lang('common_edit') . ' ' . $row['sale_id'], array('target' => '_blank')), 'align' => 'left'),
                array('data' => date(get_date_format() . '-' . get_time_format(), strtotime($row['sale_time'])), 'align' => 'left'),
                array('data' => $row['items_purchased'], 'align' => 'left'),
                array('data' => $row['employee_name'], 'align' => 'left'),
                array('data' => $row['customer_name'], 'align' => 'left'),
                array('data' => to_currency($row['subtotal']), 'align' => 'right'),
                array('data' => to_currency($row['total']), 'align' => 'right'),
                array('data' => to_currency($row['tax']), 'align' => 'right'),
                array('data' => to_currency($row['profit']), 'align' => 'right'),
                array('data' => $row['payment_type'], 'align' => 'left'),
                array('data' => $row['comment'], 'align' => 'left'));

            foreach ($report_data['details'][$key] as $drow) {
                $details_data[$key][] = array(
                    array('data' => isset($drow['item_name']) ? $drow['item_name'] : $drow['item_kit_name'], 'align' => 'left'),
                    array('data' => $drow['category'], 'align' => 'left'),
                    array('data' => $drow['serialnumber'], 'align' => 'left'),
                    array('data' => $drow['description'], 'align' => 'left'),
                    array('data' => $drow['quantity_purchased'], 'align' => 'left'),
                    array('data' => to_currency($drow['subtotal']), 'align' => 'right'),
                    array('data' => to_currency($drow['total']), 'align' => 'right'),
                    array('data' => to_currency($drow['tax']), 'align' => 'right'),
                    array('data' => to_currency($drow['profit']), 'align' => 'right'),
                    array('data' => $drow['discount_percent'] . '%', 'align' => 'left'));
            }
        }

        $data = array(
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "title" => lang('reports_deleted_sales_report'),
            "subtitle" => 'Từ ' . date(get_date_format(), strtotime($start_date)) . ' đến ' . date(get_date_format(), strtotime($end_date)),
            "headers" => $model->getDataColumns(),
            "summary_data" => $summary_data,
            "details_data" => $details_data,
            "overall_summary_data" => $model->getSummaryData(),
            "export_excel" => $export_excel
        );
        if ($export_excel == 0) {
            $this->load->view("reports/tabular_details_deleted", $data);
        } else {
            require_once APPPATH . "/third_party/Classes/deleted_sales.php";

            //$this->load->view("reports/tabular_details",$data);
        }
    }

    function excel_export() {
        $this->load->view("reports/excel_export", array());
    }

    function inventory_low1($export_excel = 0) {
        $this->load->model('reports/Inventory_low');
        $model = $this->Inventory_low;
        $model->setParams(array());
        $tabular_data = array();
        $report_data = $model->getData(array());
        foreach ($report_data as $row) {
            $tabular_data[] = array(array('data' => $row['name'], 'align' => 'left'), array('data' => $row['company_name'], 'align' => 'left'), array('data' => $row['item_number'], 'align' => 'left'), array('data' => $row['description'], 'align' => 'left'), array('data' => to_currency($row['cost_price']), 'align' => 'right'), array('data' => to_currency($row['unit_price']), 'align' => 'right'), array('data' => $row['quantity'], 'align' => 'left'), array('data' => $row['reorder_level'], 'align' => 'left'));
        }

        $data = array(
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "title" => lang('reports_low_inventory_report'),
            "subtitle" => '',
            "headers" => $model->getDataColumns(),
            "data" => $tabular_data,
            "summary_data" => $model->getSummaryData(array()),
            "export_excel" => $export_excel
        );
        if ($export_excel == 0) {
            $this->load->view("reports/tabular", $data);
        } else {
            require_once APPPATH . "/third_party/Classes/inventory_low.php";
        }

        //$this->load->view("reports/tabular",$data);
    }

    function inventory_low($export_excel = 0) {
        $this->load->model('reports/Inventory_low');
        $model = $this->Inventory_low;
        $model->setParams(array());
        $tabular_data = array();
        $report_data = $model->getData_no_customer(array());
        foreach ($report_data as $row) {
            $tabular_data[] = array(
                array(
                    'data' => $row['name'],
                    'align' => 'left'
                ),
                array(
                    'data' => $row['company_name'],
                    'align' => 'left'
                ),
                array(
                    'data' => $row['item_number'],
                    'align' => 'left'
                ),
                array(
                    'data' => $row['description'],
                    'align' => 'left'
                ),
                array(
                    'data' => to_currency($row['cost_price']),
                    'align' => 'right'
                ),
                array(
                    'data' => to_currency($row['unit_price']),
                    'align' => 'right'
                ),
                array(
                    'data' => $row['quantity'],
                    'align' => 'left'
                ), array(
                    'data' => $row['reorder_level'],
                    'align' => 'left'
                )
            );
        }
        $data = array(
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "title" => lang('reports_low_inventory_report'),
            "headers" => $model->getDataColumns(),
            "data" => $report_data,
            "summary_data" => $model->getSummaryData(array()),
            "export_excel" => $export_excel
        );
        if ($export_excel == 0) {
            $this->load->view("reports/tabular_inventory_low", $data);
        } else {
            require_once APPPATH . "/third_party/Classes/inventory_low.php";
        }
    }

    function inventory_summary($export_excel = 0) {
        $this->load->model('reports/Inventory_summary');
        $model = $this->Inventory_summary;
        $tabular_data = array();
        $report_data = $model->getData(array());
        foreach ($report_data as $row) {
            $tabular_data[] = array(
                array('data' => $row['item_number'], 'align' => 'left'),
                array('data' => $row['name'], 'align' => 'left'),
                array('data' => to_currency($row['cost_price']), 'align' => 'right'),
                array('data' => to_currency($row['unit_price']), 'align' => 'right'),
                array('data' => $row['quantity'], 'align' => 'right'),
                array('data' => $row['reorder_level'], 'align' => 'right'),
                array('data' => $row['description'], 'align' => 'left'));
        }

        $data = array(
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "title" => lang('reports_inventory_summary_report'),
            "subtitle" => '',
            "headers" => $model->getDataColumns(),
            "data" => $tabular_data,
            "summary_data" => $model->getSummaryData(array()),
            "export_excel" => $export_excel,
            "link" => "reports/inventory_summary"
        );
        if ($export_excel == 0) {
            $this->load->view("reports/tabular", $data);
        } else {
            require_once APPPATH . "/third_party/Classes/inventory_summary.php";
        }
        //$this->load->view("reports/tabular",$data);
    }

    function summary_giftcards($export_excel = 0) {
        $this->load->model('reports/Summary_giftcards');
        $model = $this->Summary_giftcards;
        $tabular_data = array();
        $report_data = $model->getData(array());
        foreach ($report_data as $row) {
            $tabular_data[] = array(array('data' => $row['giftcard_number'], 'align' => 'left'), array('data' => to_currency($row['value']), 'align' => 'left'), array('data' => $row['customer_name'], 'align' => 'left'));
        }

        $data = array(
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "title" => lang('reports_giftcard_summary_report'),
            "subtitle" => '',
            "headers" => $model->getDataColumns(),
            "data" => $tabular_data,
            "summary_data" => $model->getSummaryData(array()),
            "export_excel" => $export_excel
        );
        if ($export_excel == 0) {
            $this->load->view("reports/tabular", $data);
        } else {
            require_once APPPATH . "/third_party/Classes/summary_giftcards.php";
        }

        //	$this->load->view("reports/tabular",$data);
    }

    function detailed_giftcards_input() {
        $data['specific_input_name'] = lang('reports_customer');

        $customers = array();
        foreach ($this->Customer->get_all()->result() as $customer) {
            $customers[$customer->person_id] = $customer->first_name . ' ' . $customer->last_name;
        }
        $data['specific_input_data'] = $customers;
        $this->load->view("reports/detailed_giftcards_input", $data);
    }

    function detailed_giftcards1($customer_id, $export_excel = 0) {
        $this->load->model('reports/Detailed_giftcards');
        $model = $this->Detailed_giftcards;
        $model->setParams(array('customer_id' => $customer_id));

        $this->Sale->create_sales_items_temp_table(array('customer_id' => $customer_id));

        $headers = $model->getDataColumns();
        $report_data = $model->getData();

        $summary_data = array();
        $details_data = array();

        foreach ($report_data['summary'] as $key => $row) {
            $summary_data[] = array(
                array('data' => anchor('sales/edit/' . $row['sale_id'], lang('common_edit') . ' ' . $row['sale_id'], array('target' => '_blank')), 'align' => 'left'),
                array('data' => date(get_date_format() . '-' . get_time_format(), strtotime($row['sale_time'])), 'align' => 'left'),
                array('data' => $row['items_purchased'], 'align' => 'left'),
                array('data' => $row['employee_name'], 'align' => 'left'),
                array('data' => to_currency($row['subtotal']), 'align' => 'right'),
                array('data' => to_currency($row['total']), 'align' => 'right'),
                array('data' => to_currency($row['tax']), 'align' => 'right'),
                array('data' => to_currency($row['profit']), 'align' => 'right'),
                array('data' => $row['payment_type'], 'align' => 'left'),
                array('data' => $row['comment'], 'align' => 'left'));

            foreach ($report_data['details'][$key] as $drow) {
                $details_data[$key][] = array(array('data' => isset($drow['item_name']) ? $drow['item_name'] : $drow['item_kit_name'], 'align' => 'left'), array('data' => $drow['category'], 'align' => 'left'), array('data' => $drow['serialnumber'], 'align' => 'left'), array('data' => $drow['description'], 'align' => 'left'), array('data' => $drow['quantity_purchased'], 'align' => 'left'), array('data' => to_currency($drow['subtotal']), 'align' => 'right'), array('data' => to_currency($drow['total']), 'align' => 'right'), array('data' => to_currency($drow['tax']), 'align' => 'right'), array('data' => to_currency($drow['profit']), 'align' => 'right'), array('data' => $drow['discount_percent'] . '%', 'align' => 'left'));
            }
        }

        $customer_info = $this->Customer->get_info($customer_id);
        $data = array(
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "title" => $customer_info->first_name . ' ' . $customer_info->last_name . ' ' . lang('giftcards_giftcard') . ' ' . lang('reports_report'),
            "subtitle" => '',
            "headers" => $model->getDataColumns(),
            "summary_data" => $summary_data,
            "details_data" => $details_data,
            "overall_summary_data" => $model->getSummaryData(),
            "export_excel" => $export_excel
        );
        if ($export_excel == 0) {
            $this->load->view("reports/tabular_details", $data);
        } else {
            require_once APPPATH . "/third_party/Classes/detailed_giftcards.php";
        }

        //$this->load->view("reports/tabular_details",$data);
    }

    //28/03/2014
    function detailed_giftcards($export_excel = 0) {
        $this->load->model('reports/Detailed_giftcards');
        $model = $this->Detailed_giftcards;
        //$model->setParams(array('customer_id' =>$customer_id));
        $this->Sale->create_sales_items_temp_table(array('customer_id' => $customer_id));

        $headers = $model->getDataColumns();

        $report_data = $model->getData();
        $summary_data = array();
        $details_data = array();
        foreach ($report_data['summary'] as $key => $row) {
            $summary_data[] = array(
                array('data' => anchor('sales/edit/' . $row['sale_id'], lang('common_edit') . ' ' . $row['sale_id'], array('target' => '_blank')), 'align' => 'left'),
                array('data' => date(get_date_format() . '-' . get_time_format(), strtotime($row['sale_time'])), 'align' => 'left'),
                array('data' => $row['items_purchased'], 'align' => 'left'),
                array('data' => $row['employee_name'], 'align' => 'left'),
                array('data' => to_currency($row['subtotal']), 'align' => 'right'),
                array('data' => to_currency($row['total']), 'align' => 'right'),
                array('data' => to_currency($row['tax']), 'align' => 'right'),
                array('data' => to_currency($row['profit']), 'align' => 'right'),
                array('data' => $row['payment_type'], 'align' => 'left'),
                array('data' => $row['comment'], 'align' => 'left'));

            foreach ($report_data['details'][$key] as $drow) {
                $details_data[$key][] = array(
                    array('data' => isset($drow['item_name']) ? $drow['item_name'] : $drow['item_kit_name'], 'align' => 'left'),
                    array('data' => $drow['category'], 'align' => 'left'),
                    array('data' => $drow['serialnumber'], 'align' => 'left'),
                    array('data' => $drow['description'], 'align' => 'left'),
                    array('data' => $drow['quantity_purchased'], 'align' => 'left'),
                    array('data' => to_currency($drow['subtotal']), 'align' => 'right'),
                    array('data' => to_currency($drow['total']), 'align' => 'right'),
                    array('data' => to_currency($drow['tax']), 'align' => 'right'),
                    array('data' => to_currency($drow['profit']), 'align' => 'right'),
                    array('data' => $drow['discount_percent'] . '%', 'align' => 'left'));
            }
        }

        $customer_info = $this->Customer->get_info($customer_id);
        $data = array(
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "title" => $customer_info->first_name . ' ' . $customer_info->last_name . ' ' . lang('giftcards_giftcard') . ' ' . lang('reports_report'),
            "subtitle" => '',
            "headers" => $model->getDataColumns(),
            "summary_data" => $summary_data,
            "details_data" => $details_data,
            "overall_summary_data" => $model->getSummaryData(),
            "export_excel" => $export_excel
        );
        if ($export_excel == 0) {
            $this->load->view("reports/tabular_details", $data);
        } else {

            require_once APPPATH . "/third_party/Classes/detailed_giftcards.php";
        }
        //$this->load->view("reports/tabular_details",$data);
    }

    //end
    /* nhap hang 02/09/2012 */
    function detail_inventory($export_excel = 0, $store_id = 0) {
        $this->load->model('reports/Inventory_summary');
        $model = $this->Inventory_summary;
        $model->setParams(array('store_id' => $store_id));
        $this->Sale->create_sales_inventory_temp_table(array());
        $this->Sale->create_receiving_inventory_temp_table(array());
        $tabular_data = array();
        $report_data = $model->getGeneralData(array());
        foreach ($report_data as $row) {
            $tabular_data[] = array(
                array('data' => $row['item_id'], 'align' => 'left'),
                array('data' => anchor('items/count_details/' . $row['item_id'] . '/width~550', $row['name'], array('class' => 'thickbox')), 'align' => 'left'),
                array('data' => $row['item_number'], 'align' => 'left'),
                //array('data'=>to_currency($row['cost_price']), 'align'=> 'right'),
                array('data' => to_currency($row['unit_price']), 'align' => 'right'),
                array('data' => $row['quantity'], 'align' => 'left'),
                array('data' => $row['sale_quantity'], 'align' => 'left'),
                array('data' => $row['receiving_quantity'], 'align' => 'left'),
                array('data' => intval($row['receiving_quantity']) - intval($row['sale_quantity']) - $row['quantity'], 'align' => 'left')
            );
        }
        $tabular_data[] = array(
            array('data' => '', 'align' => 'left'),
            array('data' => '', 'align' => 'left'),
            array('data' => '', 'align' => 'left'),
            //array('data'=>'', 'align'=> 'right'),
            array('data' => '', 'align' => 'right'),
            array('data' => '', 'align' => 'left'),
            array('data' => '', 'align' => 'left'),
            array('data' => '', 'align' => 'left'),
            array('data' => '', 'align' => 'left')
        );
        $input_data['export_excel'] = $export_excel ? true : false;
        $person_info = $this->Employee->get_logged_in_employee_info();
        $input_data['stores'] = $this->Item->get_permission_stores($person_info->person_id);
        $input_data['store_selected'] = $store_id;
        $data = array(
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "title" => lang('reports_inventory_balance'),
            "subtitle" => '',
            "headers" => $model->getGeneralDataColumns(),
            "summary_data" => $tabular_data,
            "overall_summary_data" => $model->getSummaryData(array()),
            "export_excel" => $export_excel,
            "input_html" => $this->load->view("reports/store_input_excel_export_unheader", $input_data, true),
            "name_store" => $this->Item->get_stores_name($store_id)
        );
        echo $this->config->item('company');
        /* if ($export_excel == 0)
          {
          $this->load->view("reports/tabular_general", $data);
          }
          else {
          require_once APPPATH . "/third_party/Classes/detail_inventory.php";

          } */

        //  $this->load->view("reports/tabular_general", $data);
    }

//huyenlt^^ bc nhap hang
    function detailed_receiving() {
        $this->load->view("reports/detailed_receivings");
    }

    function do_detailed_receivings() {
        $data['company'] = $this->config->item('company');
        $data['address'] = $this->config->item('address');
        $start_date = date('d-m-Y', strtotime($this->input->post('start_date')));
        $end_date = date('d-m-Y', strtotime($this->input->post('end_date')));
        $select_dates = $this->Inventory->get_date($start_date, $end_date);

        require_once APPPATH . "/third_party/Classes/export_nhaphang.php";
    }

    function detailed_receivings($start_date, $end_date, $sale_type, $export_excel = 0) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);

        $this->load->model('reports/Detailed_receivings');
        $model = $this->Detailed_receivings;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $this->Receiving->create_receivings_items_temp_table(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $headers = $model->getDataColumns();
        $report_data = $model->getData();


        $summary_data = array();
        $details_data = array();
        foreach ($report_data['summary'] as $key => $row) {
            $company = $this->Supplier->get_info($row['supplier_id']);
            $company_name = $company->company_name;
            //tổng thuế và chi phí
            $total_taxe_other_cost = $this->Receiving->get_info($row['receiving_id'])->row()->other_cost + $this->Receiving->get_info($row['receiving_id'])->row()->money_1331;
            $summary_data[] = array(
                array('data' => anchor('receivings/edit/' . $row['receiving_id'], 'RECV ' . $row['receiving_id'], array('target' => '_blank')), 'align' => 'left'),
                array('data' => date('d-m-Y', strtotime($row['receiving_date'])), 'align' => 'center'),
                array('data' => $row['employee_name'], 'align' => 'left'),
                array('data' => $company_name, 'align' => 'left'),
                array('data' => $row['items_purchased'], 'align' => 'right'),
                array('data' => to_currency($row['total']+$total_taxe_other_cost), 'align' => 'right'),
                array('data' => $row['comment'], 'align' => 'left'));

            foreach ($report_data['details'][$key] as $drow) {
                $details_data[$key][] = array(
                    array('data' => $drow['name'], 'align' => 'left'),
                    array('data' => $drow['cat_name'], 'align' => 'left'),
                    array('data' => $drow['units_name'], 'align' => 'left'),
                    array('data' => $drow['quantity_purchased'], 'align' => 'right'),
                    array('data' => to_currency($drow['item_unit_price']), 'align' => 'right'),
                    array('data' => to_currency($drow['total']), 'align' => 'right'),
                    array('data' => $drow['discount_percent'] . '%', 'align' => 'right'));
            }
        }

        $data = array(
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "title" => lang('reports_detailed_receivings_report'),
            "subtitle" => 'Từ ' . date(get_date_format(), strtotime($start_date)) . ' đến ' . date(get_date_format(), strtotime($end_date)),
            "headers" => $model->getDataColumns(),
            "summary_data" => $summary_data,
            "details_data" => $details_data,
            "overall_summary_data" => $model->getSummaryData(),
            "export_excel" => $export_excel
        );
        if ($export_excel == 0) {
            $this->load->view("reports/tabular_details_receivings", $data);
        } else {
            //require_once APPPATH . "/third_party/Classes/detailed_receivings.php";
            $select_dates = $this->Inventory->get_date_receiving($start_date, $end_date, $sale_type);
//            print_r($select_dates);
//            die('ssssssss');
            require_once APPPATH . "/third_party/Classes/export_nhaphang.php";
        }
        //$this->load->view("reports/tabular_details",$data);
    }

    //and bcao nhap hang

    function general_receivings($start_date, $end_date, $sale_type, $export_excel = 0, $store_id = 0) {
        $this->load->model('reports/Detailed_receivings');
        $model = $this->Detailed_receivings;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type, 'store_id' => $store_id));
        $this->Receiving->create_receivings_items_temp_table(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));
        $headers = $model->getDataColumns();
        $report_data = $model->getGeneralData();
        $summary_data = array();
        $details_data = array();
        foreach ($report_data['summary'] as $key => $row) {
            $summary_data[] = array(array('data' => anchor('receivings/edit/' . $row['receiving_id'], 'RECV ' . $row['receiving_id'], array('target' => '_blank')), 'align' => 'left'), array('data' => date(get_date_format(), strtotime($row['receiving_date'])), 'align' => 'left'),
                array('data' => $row['item_number'], 'align' => 'left'),
                array('data' => $row['name'], 'align' => 'left'),
                array('data' => $row['items_purchased'], 'align' => 'left'),
                array('data' => $row['store_name'], 'align' => 'left'),
                array('data' => $row['employee_name'], 'align' => 'left'),
                array('data' => $row['supplier_name'], 'align' => 'left'), array('data' => to_currency($row['total']), 'align' => 'right'), array('data' => $row['payment_type'], 'align' => 'left'), array('data' => $row['comment'], 'align' => 'left'));
        }
        $input_data = $this->_get_common_report_data();
        $input_data['report_date_range_simple_selected'] = $start_date . "/" . $end_date;
        $input_data['export_excel'] = $export_excel ? true : false;
        $input_data['sale_type'] = $sale_type;
//        $input_data['stores'] = $this->Item->get_stores();
        $person_info = $this->Employee->get_logged_in_employee_info();
        $input_data['stores'] = $this->Item->get_permission_stores($person_info->person_id);
        $input_data['store_selected'] = $store_id;
        $data = array(
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "title" => lang('reports_detailed_receivings_report'),
            "subtitle" => 'Từ ' . date(get_date_format(), strtotime($start_date)) . ' đến ' . date(get_date_format(), strtotime($end_date)),
            "headers" => $headers,
            "summary_data" => $summary_data,
            //			"details_data" => $details_data,
            "overall_summary_data" => $model->getSummaryData(),
            "export_excel" => $export_excel,
            "input_html" => $this->load->view("reports/date_input_excel_export_unheader", $input_data, true)
        );
        //$this->load->view("reports/tabular_general", $data);
        if ($export_excel == 0) {
            $this->load->view("reports/tabular_general", $data);
        } else {
            require_once APPPATH . "/third_party/Classes/general_receivings.php";
        }
    }

    /* end nhap hang 02/09/2012 */
    /* xuat hang */

    function detailed_trading() {
        $this->load->view("reports/detailed_trading");
    }

    function do_detailed_trading($start_date, $end_date, $export_excel = 0) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);
        $data['company'] = $this->config->item('company');
        $data['address'] = $this->config->item('address');
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $sales = $this->Sale->get_all_sale_by_date($start_date, $end_date);
        $data['sales'] = $sales;
        
        if ($export_excel == 0) {
            $this->load->view('reports/do_detailed_trading_view', $data);
        } else {
            require_once APPPATH . "/third_party/Classes/export_xuathang.php";
        }
    }

    /* end xuat hang */

    function congnokh() {
        $this->load->view('reports/congnokh');
    }

    function report_congnokh() {
        $data['company'] = $this->config->item('company');
        $data['address'] = $this->config->item('address');
        if ($this->input->post('export_excel') == 0) {
            $start_date = date('d-m-Y', strtotime($this->input->post('start_date')));
            $end_date = date('d-m-Y', strtotime($this->input->post('end_date')));
            $data['code_cities'] = $this->Customer->find_code_city($start_date, $end_date);
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $this->load->view('reports/do_congnokh', $data);
        } else {
            $start_date = date('d-m-Y', strtotime($this->input->post('start_date')));
            $end_date = date('Y-m-d', strtotime($this->input->post('end_date')));
            $code_cities = $this->Customer->find_code_city($start_date, $end_date);
            require_once APPPATH . "/third_party/Classes/export_congno.php";
        }
    }

    function item_inventory() {
        $this->load->view('reports/item_inventory');
    }

    //báo cáo chi tiết nguyên vật liệu
    function do_item_inventory($start_date, $end_date, $export_excel = 0, $store_id) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);
        $info_store = $this->Create_invetory->get_info($store_id);
        $data['company'] = $this->config->item('company');
        $data['address'] = $this->config->item('address');
        $data['store_id'] = $store_id;

        if ($export_excel == 0) {
            $data['categories'] = $this->Category->get_all();
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['info_store'] = $info_store;
            $data['subtitle'] = "Báo cáo xuất nhập tồn từ " . date("d-m-Y H:i:s", strtotime($start_date)) . " đến " . date("d-m-Y H:i:s", strtotime($end_date));
            $this->load->view('reports/do_item_inventory', $data);
        } else {
            $categories = $this->Category->get_all();
            require_once APPPATH . "/third_party/Classes/export_tonkho.php";
        }
    }

    function input_reports_inventory() {
        $data = $this->_get_common_report_data(TRUE);
        $data['tille'] = 'Báo cáo hàng tồn kho';
        $data['stores'] = $this->Create_invetory->get_all_stores();
        $this->load->view("reports/input_reports_inventory", $data);
    }

    function reports_inventory($store, $export_excel = 0) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);
        $report_inventory = $this->Item->get_all_item_in_store($store);
        $data = array(
            "report_inventory" => $report_inventory,
            "title" => "Báo cáo hàng tồn kho",
            "store" => $store
        );
        if ($export_excel == 0) {
            $this->load->view("reports/view_report_inventory", $data);
        } else {
            require_once APPPATH . "/third_party/Classes/excel_report_inventory.php";
        }
    }

    function baocaothuyetminh() {
        $data = file_get_contents("reports.xlsx");
        $name = 'reports.xlsx';
        force_download($name, $data);
    }

    function report_bctc() {
        $objPHPExcel = new PHPExcel();
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        //$link = APPPATH."/controller/report.xlsx";
        define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        //$link = base_url()."reports.xlsx";
        $link1 = site_url() . "/reports/baocaothuyetminh";
        date_default_timezone_set('Europe/London');
        print_r(str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)));
        /** Include PHPExcel */
        require_once APPPATH . '/third_party/Classes/PHPExcel.php';
        echo date('H:i:s'), " Load Excel2007 template file", EOL;
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load("templates/thuyetminhtc.xlsx");
        echo date('H:i:s'), " Write to Excel5 format", EOL;
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save(str_replace('.php', '.xlsx', __FILE__));
        echo str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)), EOL;
        echo "<a href=$link1>Tai ve</a>";
    }

//gianghong^^
    function liabilities_customer_input() {
        $data = $this->_get_common_report_data(TRUE);
        $data['specific_input_name'] = lang('reports_customer');

        $customers = array();
        foreach ($this->Customer->get_all()->result() as $customer) {
            $customers[$customer->person_id] = $customer->first_name . ' ' . $customer->last_name;
        }
        $data['specific_input_data'] = $customers;
        $this->load->view("reports/liabilities_customer_input", $data);
    }

    function liabilities_customer($start_date, $end_date, $customer_id, $export_excel = 0) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);
        $data = array(
            "start_date" => $start_date,
            "end_date" => $end_date,
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "subtitle" => 'Từ ' . date("d-m-Y", strtotime($start_date)) . ' đến ' . date("d-m-Y", strtotime($end_date)),
            "export_excel" => $export_excel,
            "customer_id" => $customer_id,
        );
        if ($export_excel == 0) {
            $this->load->view("reports/liabilities_customer", $data);
        } else {
            require_once APPPATH . "/third_party/Classes/report_liabilities_customer.php";
        }
    }

    //doanh thu nhân viên
    function revenue_employee_input() {
        $data = $this->_get_common_report_data(TRUE);
        $data['specific_input_name'] = lang('reports_employee');
        $data['reports'] = 'Báo cáo chi tiết doanh thu nhân viên';
        $data['title'] = 'Báo cáo chi tiết doanh thu nhân viên';
        $data['url'] = site_url() . '/reports/revenue_employee';
        $employees = array();
        foreach ($this->Employee->get_all_receiving()->result() as $employee) {
            $employees[$employee->person_id] = $employee->first_name . ' ' . $employee->last_name;
        }
        $data['specific_input_data'] = $employees;
        $this->load->view("reports/specific_input", $data);
    }

    function revenue_employee($start_date, $end_date, $employee_id, $sale_type, $report_type, $export_excel = 0) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);
        $data_all_sale = array();
        //hung audi 6-6-15
        $data_sale_employee = $this->Sale->get_sale_revenue_employee($employee_id, $sale_type, $report_type); // Lay don hang theo nhan vien  
        foreach ($data_sale_employee as $key => $val) {
            //lay giao dich don hang trong khoang
            $sale_tam_data = $this->Sale->get_sales_tam_by_date_detail_sale_revenue2($start_date, $end_date, $val['sale_id']);
            $data_all_sale[$val['sale_id']] = $sale_tam_data;
        }
        foreach ($data_all_sale as $val) {
            foreach ($val as $val1) {
                $data_sale_id[] = $val1['id_sale'];
            }
        }
        $sale_id_array = array_unique($data_sale_id); // lay mang cac don hang khong trung lap
        foreach ($sale_id_array as $val) {
            $data_sale_item = $this->Sale->get_sale_item_revenue_employee($val, $report_type); // lay thong tin item trong don hang
            $detail_sale[$val][] = $data_sale_item;
            $data_sale_tam = $this->Sale->get_sales_tam($val);
            $total_discount = 0;
            $total_item = 0;
            $total_item_kit = 0;
            foreach ($data_sale_tam as $val1) { // tinh tong chiet khau
                $total_discount = $total_discount + $val1['discount_money'];
            }
            $sale_data = $this->Sale->get_info($val)->row();
            $total_profit = 0;
            foreach ($data_sale_item as $value) {  // tinh tong loi nhuan item
                $total_profit = $total_profit + (($value['item_unit_price'] - $value['item_cost_price']) * $value['quantity_purchased']) - $total_discount;
                $total_item = $total_item + $value['quantity_purchased'];
            }

            foreach ($data_sale_item_kit as $value) {
                $total_item_kit = $total_item_kit + $value['quantity_purchased'];
            }
            $info_total_sale[$val]['total_item'] = $total_item + $total_item_kit;
            $info_total_sale[$val]['total_profit'] = $total_profit;
            $info_total_sale[$val]['later_cost_price'] = $sale_data->later_cost_price;
            $info_total_sale[$val]['total_discount'] = $sale_data->later_cost_price - $total_discount;
        }
        $employee_info = $this->Employee->get_info($employee_id);
        $customer_city = $this->Customer->get_city_name($customer_info->city);
        $data = array(
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "full_name" => $employee_info->last_name,
            "title" => 'Báo cáo chi tiết doanh thu nhân viên - ' . $employee_info->first_name . ' ' . $employee_info->last_name,
            "subtitle" => 'Từ ' . date(get_date_format(), strtotime($start_date)) . ' đến ' . date(get_date_format(), strtotime($end_date)),
            "cus" => $cus,
            "total" => $total,
            "money_total" => $money_birth_date,
            "person_id" => $employee_info,
            "city" => $customer_city->name,
            "phone_number" => $employee_info->phone_number,
            "email" => $employee_info->email,
            "address" => $employee_info->address_1,
            "name_customer" => $employee_info->first_name . ' ' . $employee_info->last_name,
            "total_sum" => $total_sum,
            "info_total_sale" => $info_total_sale,
            "data_all_sale" => $data_all_sale,
            "detail_sale" => $detail_sale,
            "report_type" => $report_type
        );
        if ($export_excel == 0) {
            $this->load->view("reports/revenue_detail", $data);
        } else {
            require_once APPPATH . "/third_party/Classes/revenue_employee.php";
        }
    }

    //huyenlt^^ bao cao kho
    function specific_stored_input() {
        $data = $this->_get_common_report_data(TRUE);
        $data['specific_input_name'] = 'Chọn kho';
        $data['title'] = 'Báo cáo chi tiết từng kho';

        $stores = array('9999' => 'Tất cả', '8888' => 'Kho sản phẩm', '7777' => 'Kho tổng');
        foreach ($this->Create_invetory->get_all()->result_array() as $row) {
            $stores[$row['id']] = $row['name_inventory'];
        }

        $data['specific_input_data'] = $stores;
        $this->load->view("reports/specific_input_stored", $data);
    }

    function specific_stored($start_date, $end_date, $stored_id, $sale_type, $report_type, $export_excel = 0) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);

        $data_sale_employee = $this->Sale->get_sale_specific_stored($stored_id, $sale_type, $report_type); // Lay theo kho  
        foreach ($data_sale_employee as $key => $val) {
            $sale_tam_data = $this->Sale->get_sales_tam_specific_stored($start_date, $end_date, $val['sale_id']); //lay theo time
            $data_all_sale[$val['sale_id']] = $sale_tam_data;
        }
        foreach ($data_all_sale as $val) {
            foreach ($val as $val1) {
                $data_sale_id[] = $val1['id_sale'];
            }
        }
        $sale_id_array = array_unique($data_sale_id);
        foreach ($sale_id_array as $val) {
            $data_sale_item = $this->Sale->get_sale_item_specific_stored($val, $report_type, $stored_id); // lay item, pack trong sale_id
            $detail_sale[$val][] = $data_sale_item;
            $info_total_sale[$val][] = 0;
        }
        if ($stored_id == 9999) {
            $stored_info = 'Tất cả kho';
        } else if ($stored_id == 8888) {
            $stored_info = 'Kho sản phẩm';
        } else if ($stored_id == 7777) {
            $stored_info = 'Kho tổng';
        } else {
            $stored_info = $this->Create_invetory->get_info($stored_id)->name_inventory;
        }
        $data = array(
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "full_name" => $stored_info->name_inventory,
            "title" => 'Báo cáo chi tiết kho' . ' ' . $stored_info,
            "subtitle" => 'Từ ' . date(get_date_format(), strtotime($start_date)) . ' đến ' . date(get_date_format(), strtotime($end_date)),
            "city" => $customer_city->name,
            "info_total_sale" => $info_total_sale,
            "data_all_sale" => $data_all_sale,
            "detail_sale" => $detail_sale,
            "report_type" => $report_type
        );
        if ($export_excel == 0) {
            $this->load->view("reports/tabular_details_stored", $data);
        } else {
            require_once APPPATH . "/third_party/Classes/specific_stored.php";
        }
    }

    //end huyenlt^^
    //báo cáo kiểm kho
    function verifying_resport_input() {
        $data = $this->_get_common_report_data(TRUE);
        $data['specific_input_name'] = "Chọn kho";
        $data['reports'] = 'Báo cáo chi tiết kiểm kho';
        $data['title'] = 'Báo cáo chi tiết kiểm kho';

        $stores = array('9999' => 'Tất cả', '0' => 'Kho tổng');
        foreach ($this->Create_invetory->get_all()->result() as $store) {
            $stores[$store->id] = $store->name_inventory;
        }
        $data['specific_input_data'] = $stores;
        $this->load->view("reports/verifying_resport_input", $data);
    }

    public function do_verifying_resport($start_date, $end_date, $store, $sale_type, $export_excel = 0) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);

        $data['company'] = $this->config->item('company');
        $data['address'] = $this->config->item('address');
        $data['store'] = $store;
        if ($export_excel == 0) {

            if ($store == 9999) {
                $data['verifying'] = $this->Item->verifying_resport_all($start_date, $end_date);
            } else {
                $data['verifying'] = $this->Item->verifying_resport($store, $start_date, $end_date);
            }
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $this->load->view('reports/do_verifying_resport', $data);
        } else {
            if ($store == 9999) {
                $verifying = $this->Item->verifying_resport_all($start_date, $end_date);
            } else {
                $verifying = $this->Item->verifying_resport($store, $start_date, $end_date);
            }
            require_once APPPATH . "/third_party/Classes/export_verifying.php";
        }
    }

    //bc chuyển kho
    public function transfer_warehouse() {
        $this->load->view('reports/transfer_warehouse_input');
    }

    public function do_transfer_ware($start_date, $end_date, $sale_type, $export_excel = 0) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);

        $data['company'] = $this->config->item('company');
        $data['address'] = $this->config->item('address');

        if ($export_excel == 0) {
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['value'] = $this->Item->get_transfer_warehouse_new($start_date, $end_date);

            $this->load->view("reports/transfer_warehouse_view", $data);
        } else {
            $transfer_warehouse = $this->Item->get_transfer_warehouse_new($start_date, $end_date);
            require_once APPPATH . "/third_party/Classes/export_transfer.php";
        }
    }

    //end báo cáo chuyển kho
    //start báo cáo thu chi
    function excel_export_costs($start_date, $end_date, $export_excel = 0, $cost_type) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);

        if ($export_excel == 0) {
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            if ($cost_type == 'thu') {
                $data['cost_exports'] = $this->Cost->export_cost_thu($start_date, $end_date);
            } elseif ($cost_type == 'chi') {
                $data['cost_exports'] = $this->Cost->export_cost_chi($start_date, $end_date);
            } else {
                $data['cost_exports'] = $this->Cost->export_cost($start_date, $end_date);
            }
            $data['cost_tien_thu'] = 0;
            $data['cost_tien_chi'] = 0;
            $data['start_date'] = date('d-m-Y H:i:s', strtotime($start_date));
            $data['end_date'] = date('d-m-Y H:i:s', strtotime($end_date));
            $data['cost_type'] = $cost_type;
            foreach ($data['cost_exports'] as $cost) {
                if($cost['form_cost'] == 0){
                $data['cost_tien_thu'] += $cost['money'];
                }else{
                $data['cost_tien_chi'] += $cost['money'];
                }
            }
            //$data = array('report_type' => $report_type);
            $this->load->view('costs/do_excel_export', $data);
        } else {
            $start_date = rawurldecode($start_date);
            $end_date = rawurldecode($end_date);
            $data['cost_type'] = $cost_type;
            if ($cost_type == 'thu') {
                $data = $this->Cost->cost_export_excel_thu($start_date, $end_date)->result_object();
            } elseif ($cost_type == 'chi') {
                $data = $this->Cost->cost_export_excel_chi($start_date, $end_date)->result_object();
            } else {
                $data = $this->Cost->cost_export_excel($start_date, $end_date)->result_object();
            }
            $this->load->helper('report');
            $rows = array();
            $tien_thu_tong = 0;
            $tien_chi_tong = 0;
            // $row = array('date', 'chung tu', 'cost_date_ct', 'name', 'tk_du', 'tien_thu 1', 'tien_chi 2');
            if ($template) {
                $row = array_merge($row, array('Cost Id'));
            }

            $rows[] = $row;
            foreach ($data as $r) {
                $row = array(
                    date("d/m/Y", strtotime($r->date)),
                    $r->chungtu,
                    date("d/m/Y", strtotime($r->cost_date_ct)),
                    $r->name,
                    $r->comment,
                    $r->tk_du,
                    $r->form_cost == 0 ? to_currency_unVND_nomar($r->money) : null,
                    $r->form_cost == 1 ? to_currency_unVND_nomar($r->money) : null,
                );
                if ($template) {
                    $row = array_merge($row, array($r->id_cost));
                }
                $rows[] = $row;
                if($r->form_cost == 1){
                  $tien_chi_tong += $r->money;
                }else{
                 $tien_thu_tong += $r->money;
                }
            }
            require_once APPPATH . "/third_party/Classes/export_costs.php";
        }
    }

    //end
    //bc thu
    public function do_choose_date_thu($start_date, $end_date, $sale_type, $export_excel = 0) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);

        $data['company'] = $this->config->item('company');
        $data['address'] = $this->config->item('address');

        $data['thu_date'] = $this->Cost->get_date_thu_new($start_date, $end_date);
        $data['start_date'] = date('d-m-Y H:i:s', strtotime($start_date));
        $data['end_date'] = date('d-m-Y H:i:s', strtotime($end_date));
        if ($export_excel == 0) {
            $this->load->view('reports/do_choose_thu', $data);
        } else {
            $thu_date = $this->Cost->get_date_thu_new($start_date, $end_date);
//                var_dump($thu_date);exit();
            require_once APPPATH . "/third_party/Classes/export_date_thu.php";
        }
    }

    //end 
    //bc chi
    public function do_choose_date_chi($start_date, $end_date, $sale_type, $export_excel = 0) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);

        $data['company'] = $this->config->item('company');
        $data['address'] = $this->config->item('address');

        $data['chi_date'] = $this->Cost->get_date_chi_new($start_date, $end_date);
        $data['start_date'] = date('d-m-Y H:i:s', strtotime($start_date));
        $data['end_date'] = date('d-m-Y H:i:s', strtotime($end_date));
        if ($export_excel == 0) {
            $this->load->view('reports/do_choose_chi', $data);
        } else {
            $chi_date = $this->Cost->get_date_chi_new($start_date, $end_date);
            require_once APPPATH . "/third_party/Classes/export_date_chi.php";
        }
    }

    function liabilities_supplier_input() {
        $data = $this->_get_common_report_data(TRUE);
        $data['specific_input_name'] = 'Nhà cung cấp';
        $data['reports'] = 'Báo cáo chi tiết nợ nhà cung cấp';
        $suppliers = $this->Supplier->get_all()->result_array();
        $supplier = array();
        foreach ($suppliers as $val) {
            $supplier[$val['person_id']] = $val['company_name'];
        }
        $data['specific_input_data'] = $supplier;
        $this->load->view('reports/liabilities_supplier_input', $data);
    }

    function liabilities_supplier($start_date, $end_date, $supplier_id, $export_excel = 0) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);
        $data = array(
            "start_date" => $start_date,
            "end_date" => $end_date,
            "supplier_id" => $supplier_id,
            "title" => "Báo cáo công nợ nhà cung cấp",
            "subtitle" => "Từ " . date("d-m-Y", strtotime($start_date)) . " đến " . date("d-m-Y", strtotime($end_date))
        );
        if ($export_excel == 0) {
            $this->load->view("reports/liabilities_supplier", $data);
        } else {
            require_once APPPATH . "/third_party/Classes/report_liabilities_supplier.php";
        }
    }

    //Bao cao thu chi nhan vien Loi
    function cost_employees_input() {
        $data = $this->_get_common_report_data(TRUE);
        $data['specific_input_name'] = lang('reports_employee');
        $data['url'] = site_url() . '/reports/revenue_employee';
        $employees = array();
        foreach ($this->Employee->get_all_receiving()->result() as $employee) {
            $employees[$employee->person_id] = $employee->first_name . ' ' . $employee->last_name;
        }
        $data['specific_input_data'] = $employees;
        $data['tille'] = 'Báo cáo thu chi nhân viên';
        $this->load->view("reports/cost_employees", $data);
    }

    function cost_employee($start_date, $end_date, $employee_id, $cost_type, $export_excel = 0) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);
        if ($employee_id == 0)
            $employee_id = $this->session->userdata('person_id');
        if ($export_excel == 0) {
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['cost_type'] = $cost_type;
            if ($cost_type == 'thu') {
                $data['cost_exports'] = $this->Cost->find_export_by_employee_thu($start_date, $end_date, $employee_id);
            } elseif ($cost_type == 'chi') {
                $data['cost_exports'] = $this->Cost->find_export_by_employee_chi($start_date, $end_date, $employee_id);
            } else {
                $data['cost_exports'] = $this->Cost->find_export_by_employee($start_date, $end_date, $employee_id);
            }
            $data['cost_tien_thu'] = 0;
            $data['cost_tien_chi'] = 0;
            $data['start_date'] = date('d-m-Y H:i:s', strtotime($start_date));
            $data['end_date'] = date('d-m-Y H:i:s', strtotime($end_date));
            foreach ($data['cost_exports'] as $cost) {
                if($cost['form_cost'] == 0){
                   $data['cost_tien_thu'] += $cost['money'];
                }else{
                   $data['cost_tien_chi'] += $cost['money'];
                }
            }
            $this->load->view('reports/cost_employee_export', $data);
        } else {
            $start_date = rawurldecode($start_date);
            $end_date = rawurldecode($end_date);
            $data['cost_type'] = $cost_type;
            if ($cost_type == 'thu') {
                $data = $this->Cost->find_export_excel_by_employee_thu($start_date, $end_date, $employee_id)->result_object();
            } elseif ($cost_type == 'chi') {
                $data = $this->Cost->find_export_excel_by_employee_chi($start_date, $end_date, $employee_id)->result_object();
            } else {
                $data = $this->Cost->find_export_excel_by_employee($start_date, $end_date, $employee_id)->result_object();
            }
            $this->load->helper('report');
            $rows = array();
            $tien_thu_tong = 0;
            $tien_chi_tong = 0;
            // $row = array('date', 'chung tu', 'cost_date_ct', 'name', 'tk_du', 'tien_thu 1', 'tien_chi 2');
            if ($template) {
                $row = array_merge($row, array('Cost Id'));
            }
            $rows[] = $row;
            $i = 1;
            foreach ($data as $r) {
                $row = array(
                    $i,
                    date("d/m/Y", strtotime($r->cost_date_ct)),
                    $r->cost_employees,
                    $r->comment,
                    $r->id_customer,
                    $r->form_cost == 0 ? to_currency_unVND_nomar($r->money) : null,
                    $r->form_cost == 1 ? to_currency_unVND_nomar($r->money) : null,
                );
                if ($template) {
                    $row = array_merge($row, array($r->id_cost));
                }
                $rows[] = $row;
                $company = $this->config->item('company');
                if($r->form_cost == 1){
                  $tien_chi_tong += $r->money;
                }else{
                  $tien_thu_tong += $r->money;
                }
                $i++;
            }
            require_once APPPATH . "/third_party/Classes/export_costs_employee.php";
        }
    }

    //    Báo cáo doanh thu/ lợi nhuận
    function revenue_profit_input() {
        $data = $this->_get_common_report_data(TRUE);
        $data['url'] = site_url() . '/reports/revenue_profit';
        $this->load->view("reports/revenue_profit_input", $data);
    }

    function revenue_profit($start_date, $end_date, $export_excel = 0) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);
        $data_item = $this->Inventory->get_all_item_in_inventory($start_date, $end_date);
        $data = array(
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "title" => 'Báo cáo doanh thu-lợi nhuận theo mặt hàng',
            "subtitle" => 'Từ ' . date('d-m-Y', strtotime($start_date)) . ' đến ' . date('d-m-Y', strtotime($end_date)),
            'start_date' => $start_date,
            'end_date' => $end_date,
            'data_item' => $data_item
        );
        if ($export_excel == 0) {
            $this->load->view("reports/revenue_profit_item", $data);
        } else {
            require_once APPPATH . "/third_party/Classes/revenue_profit_item.php";
        }
    }

    function revenue_profit_cat_item_input() {
        $data = $this->_get_common_report_data(TRUE);
        $data['url'] = site_url() . '/reports/revenue_profit_cat_item';
        $data['cats'] = $this->Category->get_all();
        $this->load->view("reports/revenue_profit_cat_item_input", $data);
    }

    function revenue_profit_cat_item($start_date, $end_date, $cat_id, $export_excel = 0) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);
        $data_cat = $this->Inventory->get_cat_item($start_date, $end_date, $cat_id);
        $data = array(
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "title" => 'Báo cáo doanh thu-lợi nhuận theo nhóm mặt hàng',
            "subtitle" => 'Từ ' . date('d-m-Y', strtotime($start_date)) . ' đến ' . date('d-m-Y', strtotime($end_date)),
            'start_date' => $start_date,
            'end_date' => $end_date,
            'data_cat' => $data_cat
        );
        if ($export_excel == 0) {
            $this->load->view("reports/revenue_profit_cat_item", $data);
        } else {
            require_once APPPATH . "/third_party/Classes/revenue_profit_item.php";
        }
    }

    //End Loi
    //bc xuất kho
    function export_store_input() {
        $data = $this->_get_common_report_data(TRUE);
        $data['tille'] = 'Báo cáo xuất kho';
        $data['specific_input_name'] = 'Chọn kho';
        $stores = array('all' => 'Tất cả', '0' => 'Kho tổng');
        foreach ($this->Create_invetory->get_all()->result_array() as $row) {
            $stores[$row['id']] = $row['name_inventory'];
        }
        $data['specific_input_data'] = $stores;
        $this->load->view("reports/export_store_input", $data);
    }

    function export_store($start_date, $end_date, $export_excel = 0, $store_id) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);
        $data['company'] = $this->config->item('company');
        $data['address'] = $this->config->item('address');
        $info_store = $this->Create_invetory->get_info($store_id);
        if ($export_excel == 0) {
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['store_id'] = $store_id;
            $data['info_store'] = $info_store;
            $data['title'] = 'Báo cáo xuất kho';
            $data['subtitle'] = 'Từ ' . date("d-m-Y H:i:s", strtotime($start_date)) . " đến " . date("d-m-Y H:i:s", strtotime($end_date));
            $this->load->view('reports/export_store', $data);
        } else {
            $data['store_id'] = $store_id;
            $data['info_store'] = $info_store;
            $data['subtitle'] = 'Từ ' . date("d-m-Y H:i:s", strtotime($start_date)) . " đến " . date("d-m-Y H:i:s", strtotime($end_date));
            require_once APPPATH . "/third_party/Classes/excel_export_store.php";
        }
    }

    //bc nhập khẩu
    function detailed_imports($start_date, $end_date, $sale_type, $export_excel = 0) {
        $start_date = rawurldecode($start_date);
        $end_date = rawurldecode($end_date);

        $this->load->model('reports/Detailed_imports');
        $model = $this->Detailed_imports;
        $model->setParams(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $this->Receiving->create_imports_items_temp_table(array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type));

        $headers = $model->getDataColumns();
        $report_data = $model->getData();
        //die('1');


        $summary_data = array();
        $details_data = array();
        foreach ($report_data['summary'] as $key => $row) {
            $company = $this->Supplier->get_info($row['supplier_id']);
            $company_name = $company->company_name;
            $this->load->model('Currency');
            $currency = $this->Currency->get_info($row['currency_id'])->currency_name;
            $currency_id = $this->Currency->get_info($row['currency_id'])->currency_id;

            $summary_data[] = array(
                array('data' => anchor('receivings/edit/' . $row['receiving_id'], 'RECV ' . $row['receiving_id'], array('target' => '_blank')), 'align' => 'left'),
                array('data' => date('d-m-Y H:i:s', strtotime($row['receiving_date'])), 'align' => 'center'),
                array('data' => $row['employee_name'], 'align' => 'left'),
                array('data' => $company_name, 'align' => 'left'),
                array('data' => $currency, 'align' => 'left'),
                array('data' => $row['items_purchased'], 'align' => 'right'),
                array('data' => number_format($row['total'], 2), 'align' => 'right'),
                array('data' => $row['comment'], 'align' => 'left'));

            foreach ($report_data['details'][$key] as $drow) {
                $details_data[$key][] = array(
                    array('data' => $drow['name'], 'align' => 'left'),
                    array('data' => $drow['cat_name'], 'align' => 'left'),
                    array('data' => $drow['units_name'], 'align' => 'left'),
                    array('data' => $drow['quantity_purchased'], 'align' => 'right'),
                    array('data' => ($drow['item_unit_price']), 'align' => 'right'),
                    array('data' => number_format($drow['total'], 2), 'align' => 'right'),
                    array('data' => $drow['discount_percent'] . '%', 'align' => 'right'),
                    array('data' => $drow['taxes'] . '%', 'align' => 'right'),
                );
            }
        }

        $data = array(
            "company" => $this->config->item('company'),
            "address" => $this->config->item('address'),
            "title" => lang('reports_detailed_imports_report'),
            "subtitle" => 'Từ ' . date(get_date_format(), strtotime($start_date)) . ' đến ' . date(get_date_format(), strtotime($end_date)),
            "headers" => $model->getDataColumns(),
            "summary_data" => $summary_data,
            "details_data" => $details_data,
            "overall_summary_data" => $model->getSummaryData(),
            "export_excel" => $export_excel
        );
        if ($export_excel == 0) {
            $this->load->view("reports/tabular_details_imports", $data);
        } else {
            $data_receiving = $this->Inventory->receiving_import($start_date, $end_date);
            $data_item_recv = $this->Inventory->receiving_items_import($sale_type);
            require_once APPPATH . "/third_party/Classes/export_nhapkhau.php";
        }
        //$this->load->view("reports/tabular_details",$data);
    }

    //end nhập khẩu
}

?>