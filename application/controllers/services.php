<?php

require_once(APPPATH . 'third_party/Classes/PHPExcel/IOFactory.php');
require_once(APPPATH . 'libraries/php-excel.class.php');
require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");

class Services extends Secure_area implements iData_controller {

    function __construct() {
        parent::__construct('services');
        $this->load->library('sale_lib');
        $this->load->library('receiving_lib');
    }

    function index() {     
        $this->check_action_permission('search');
        $config['base_url'] = site_url('services/sorting');
        $config['total_rows'] = $this->Service->count_all();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['total_rows'] = $this->Service->count_all();
        $data['per_page'] = $config['per_page'];
        $data['categories'] = $this->Service->get_all_cat_service();
        $data['manage_table'] = get_services_manage_table($this->Service->get_all($data['per_page']), $this);
        $data['shopping_items'] = $this->sale_lib->get_cart();
        $this->load->view('services/manage', $data);
    }

    function sorting() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
//        $cat = $this->input->post('cat');
//        $stores = $this->input->post('stores');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search) {
            $config['total_rows'] = $this->Item->search_count_all_items($search, $stores, $cat);
            $table_data = $this->Item->search_items($search, $stores, $cat, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'item_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        } else {
            $config['total_rows'] = $this->Service->count_all();           
            $table_data = $this->Service->get_all($per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'item_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        }
        $config['base_url'] = site_url('services/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_services_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function find_item_info() {
        $item_number = $this->input->post('scan_item_number');
        echo json_encode($this->Item->find_item_info($item_number));
    }

    function item_number_exists() {
        if ($this->Item->account_number_exists($this->input->post('item_number')))
            echo 'false';
        else
            echo 'true';
    }

    function search() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $cat = $this->input->post('cat');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;        
        $search_data = $this->Service->search($search, $cat, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'item_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        $config['base_url'] = site_url('services/search');
        $config['total_rows'] = $this->Service->search_count_all($search,$cat);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_services_manage_table_data_rows($search_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    /*
      Gives search suggestions based on what is being searched for
     */

    function suggest() {
        $suggestions = $this->Service->get_search_suggestions($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }
    
    function view($item_id = -1) {
        $this->check_action_permission('add_update');
        $data['cats'] = $this->Service->get_all_cat_service();
        $data['units'] = $this->Unit->get_all();
        $data['item_info'] = $this->Service->get_info($item_id);
        $this->load->view("services/form", $data);
    }
    
    function save($item_id = -1) {
        $this->check_action_permission('add_update');
        /* phan them anh */
        $config = array(
            "upload_path" => "./items/",
            "allowed_types" => 'gif|jpg|png|bmp|jpeg',
            'max_size' => '6000'
        );
        $this->load->library('upload', $config);
        $anh = '';
        if (!$this->upload->do_upload('item_image')) {
            $item_data = array(
                'item_number' => $this->input->post('item_number'),
                'name' => $this->input->post('name'),
                'category' => $this->input->post('category'),
                'unit_price' => str_replace(array(',', '.00'), '', $this->input->post('unit_price')),
                'promo_price' => str_replace(array(',', '.00'), '', $this->input->post('promo_price')),
                'unit' => $this->input->post('unit'),
                'description' => $this->input->post('description'),
                'allow_alt_description' => $this->input->post('allow_alt_description') ? $this->input->post('allow_alt_description') : 0,
                'service' => 1,
            );
            //update
            $item_data1 = array(
                'item_number' => $this->input->post('item_number'),
                'name' => $this->input->post('name'),
                'category' => $this->input->post('category'),
                'unit_price' => str_replace(array(',', '.00'), '', $this->input->post('unit_price')),
                'promo_price' => str_replace(array(',', '.00'), '', $this->input->post('promo_price')),
                'unit' => $this->input->post('unit'),
                'description' => $this->input->post('description'),
                'allow_alt_description' => $this->input->post('allow_alt_description') ? $this->input->post('allow_alt_description') : 0,
            );
        } else {
            if ($item_id != -1) {
                $delimg = $this->Item->get_info($item_id);
                unlink("./items/" . $delimg->images);
            }
            $images = $this->upload->data();
            $config = array(
                "source_image" => $images['full_path'],
                "maintain_ration" => true,
                "width" => '157',
                "height" => "125"
            );
            $this->load->library("image_lib", $config);
            $this->image_lib->resize();
            if ($images != "") {
                $img = $images['file_name'];
            }
            $item_data = array(
                'item_number' => $this->input->post('item_number'),
                'name' => $this->input->post('name'),
                'category' => $this->input->post('category'),
                'unit_price' => str_replace(array(',', '.00'), '', $this->input->post('unit_price')),
                'promo_price' => str_replace(array(',', '.00'), '', $this->input->post('promo_price')),
                'unit' => $this->input->post('unit'),
                'description' => $this->input->post('description'),
                'allow_alt_description' => $this->input->post('allow_alt_description') ? $this->input->post('allow_alt_description') : 0,
                'images' => $img,
                'service' => 1,
            );
            $item_data1 = array(
                'item_number' => $this->input->post('item_number'),
                'name' => $this->input->post('name'),
                'category' => $this->input->post('category'),
                'unit_price' => str_replace(array(',', '.00'), '', $this->input->post('unit_price')),
                'promo_price' => str_replace(array(',', '.00'), '', $this->input->post('promo_price')),
                'unit' => $this->input->post('unit'),
                'description' => $this->input->post('description'),
                'allow_alt_description' => $this->input->post('allow_alt_description') ? $this->input->post('allow_alt_description') : 0,
                'images' => $img
            );
        }
        $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
        $cur_item_info = $this->Item->get_info($item_id);
        if ($item_id == -1) {
            if ($this->Item->save($item_data, $item_id)) {
                echo json_encode(array('success' => true, 'message' => lang('services_successful_adding') . ' ' .
                    $item_data['name'], 'item_id' => $item_data['item_id']));
            } else {//failure                    
                echo json_encode(array('success' => false, 'message' => lang('services_error_adding_updating') . ' ' .
                    $item_data['name'], 'item_id' => -1));
            }
        } else {
            if ($this->Item->save($item_data1, $item_id)) {
                echo json_encode(array('success' => true, 'message' => lang('services_successful_updating') . ' ' .
                    $item_data['name'], 'item_id' => $item_id));
            } else {//failure                 
                echo json_encode(array('success' => false, 'message' => lang('services_error_adding_updating') . ' ' .
                    $item_data['name'], 'item_id' => -1));
            }
        }
    }
    function get_row() {
        $item_id = $this->input->post('row_id');        
        $data_row = get_service_data_row($this->Service->get_info($item_id), $this);
        echo $data_row;
    }
    function delete() {
        $this->check_action_permission('delete');
        $items_to_delete = $this->input->post('ids');
        $select_inventory = $this->get_select_inventory();
        $total_rows = $select_inventory ? $this->Item->count_all() : count($items_to_delete);
        $this->clear_select_inventory();
        foreach ($items_to_delete as $item) {
            $check_inventory = $this->Inventory->check_exists_item_in_inventory($item);
            $check_receivings_items = $this->Receiving->check_exists_item_in_receivings_items($item);
            if ($check_inventory || $check_receivings_items) {
                $check = 1;
            } else {
                $check = 0;
            }
        }
        if ($check == 0) {
            $this->Item->delete_list($items_to_delete, $select_inventory);
            $this->Inventory->delete_in_inventory($items_to_delete);
            echo json_encode(array('success' => true, 'message' => lang('items_successful_deleted') . ' ' . $total_rows . ' ' . lang('items_one_or_multiple')));
        } else {
            echo json_encode(array('success' => false, 'message' => lang('items_cannot_be_deleted')));
        } 
    }
    
    function check_item_number_services(){
        if($this->Service->check_exists_item_number_services($this->input->post("item_number"))){
            echo "false";
        }else{
            echo "true";
        }
    }    

    function shopping($item_ids) {
        $item_ids = explode('~', $item_ids);
        // print_r($item_ids);
        foreach ($item_ids as $item_id) {
            $data = array();
            $mode = $this->sale_lib->get_mode();
            $item_id_or_number_or_item_kit_or_receipt = $item_id;
            $quantity = $mode == "sale" ? 1 : -1;

            if ($this->sale_lib->is_valid_receipt($item_id_or_number_or_item_kit_or_receipt) && $mode == 'return') {
                $this->sale_lib->return_entire_sale($item_id_or_number_or_item_kit_or_receipt);
            } elseif ($this->sale_lib->is_valid_item_kit($item_id_or_number_or_item_kit_or_receipt)) {
                $this->sale_lib->add_item_kit($item_id_or_number_or_item_kit_or_receipt, $quantity);

                //As surely a Kit item , do out of stock check
                $item_kit_id = $this->sale_lib->get_valid_item_kit_id($item_id_or_number_or_item_kit_or_receipt);

                if ($this->sale_lib->out_of_stock_kit($item_kit_id)) {
                    $data['warning'] = lang('sales_quantity_less_than_zero');
                }
            } elseif (!$this->sale_lib->add_item($item_id_or_number_or_item_kit_or_receipt, $quantity)) {
                $data['error'] = lang('sales_unable_to_add_item');
            }

            if ($this->sale_lib->out_of_stock($item_id_or_number_or_item_kit_or_receipt)) {
                $data['warning'] = lang('sales_quantity_less_than_zero');
            }
        }
        redirect('services');
    }

    function delete_shopping_item($item_number) {
        $this->sale_lib->delete_item($item_number);
        redirect('items');
    }

    function switch_receving($item_id) {
        $data = array();
        $mode = $this->receiving_lib->get_mode();
        $item_id_or_number_or_item_kit_or_receipt = $item_id;
        $quantity = $mode == "receive" ? 1 : -1;

        if ($this->receiving_lib->is_valid_receipt($item_id_or_number_or_item_kit_or_receipt) && $mode == 'return') {
            $this->receiving_lib->return_entire_receiving($item_id_or_number_or_item_kit_or_receipt);
        } elseif ($this->receiving_lib->is_valid_item_kit($item_id_or_number_or_item_kit_or_receipt)) {
            $this->receiving_lib->add_item_kit($item_id_or_number_or_item_kit_or_receipt);
        } elseif (!$this->receiving_lib->add_item($item_id_or_number_or_item_kit_or_receipt, $quantity)) {
            $data['error'] = lang('receivings_unable_to_add_item');
        }
        redirect('receivings');
    }

    function trading($item_ids) {
        $item_ids = explode('~', $item_ids);
        // print_r($item_ids);
        foreach ($item_ids as $item_id) {
            $data = array();
            $mode = $this->receiving_lib->get_mode();
            $item_id_or_number_or_item_kit_or_receipt = $item_id;
            $quantity = $mode == "receive" ? 1 : -1;

            if ($this->receiving_lib->is_valid_receipt($item_id_or_number_or_item_kit_or_receipt) && $mode == 'return') {
                $this->receiving_lib->return_entire_receiving($item_id_or_number_or_item_kit_or_receipt);
            } elseif ($this->receiving_lib->is_valid_item_kit($item_id_or_number_or_item_kit_or_receipt)) {
                $this->receiving_lib->add_item_kit($item_id_or_number_or_item_kit_or_receipt);
            } elseif (!$this->receiving_lib->add_item($item_id_or_number_or_item_kit_or_receipt, $quantity)) {
                $data['error'] = lang('receivings_unable_to_add_item');
            }
        }
        redirect('items');
    }

    function delete_trading_item($item_number) {
        $this->receiving_lib->delete_item($item_number);
        redirect('items');
    }

    function bulk_edit() {
        $this->check_action_permission('add_update');
        $this->load->helper('report');
        $data = array();
        $data['months'] = get_months();
        $data['days'] = get_days();
        $data['years'] = get_years();
        $data['end_years'] = array(date("Y") + 1 => date("Y") + 1) + $data['years'];
        $data['selected_start_year'] = 0;
        $data['selected_start_month'] = 0;
        $data['selected_start_day'] = 0;
        $data['selected_end_year'] = 0;
        $data['selected_end_month'] = 0;
        $data['selected_end_day'] = 0;

        $suppliers = array('' => lang('items_do_nothing'), '-1' => lang('items_none'));
        foreach ($this->Supplier->get_all()->result_array() as $row) {
            $suppliers[$row['person_id']] = $row['company_name'] . ' (' . $row['first_name'] . ' ' . $row['last_name'] . ')';
        }
        $data['suppliers'] = $suppliers;
        $data['allow_alt_desciption_choices'] = array(
            '' => lang('items_do_nothing'),
            1 => lang('items_change_all_to_allow_alt_desc'),
            0 => lang('items_change_all_to_not_allow_allow_desc'));


        $data['serialization_choices'] = array(
            '' => lang('items_do_nothing'),
            1 => lang('items_change_all_to_serialized'),
            0 => lang('items_change_all_to_unserialized'));
        $this->load->view("items/form_bulk", $data);
    }

    //Ramel Inventory Tracking
    function save_inventory($item_id = -1) {
        $this->check_action_permission('add_update');
        $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
        $cur_item_info = $this->Item->get_info($item_id);

//		$convert = $this->Convert->get_info_by_unit($cur_item_info->unit_from,$cur_item_info->unit);
        if ($cur_item_info->unit_rate > 0) {
            $quan = $cur_item_info->unit_rate * $this->input->post('newquantity') / $cur_item_info->quantity_first;
        } else {
            $quan = $this->input->post('newquantity');
        }

        $inv_data = array
            (
            'trans_date' => date('Y-m-d H:i:s'),
            'trans_items' => $item_id,
            'trans_user' => $employee_id,
            'trans_comment' => $this->input->post('trans_comment'),
            'trans_inventory' => $quan,
            'trans_catid' => $cur_item_info->category,
            'trans_money' => $cur_item_info->cost_price,
            'trans_people' => 0
        );
        $this->Inventory->insert($inv_data);

        $cost_comment = "Chi tiền nhập kho sản phẩm " . $this->Item->get_info($item_id)->name;
        $cost_date = array(
            'id_customer' => 0,
            'name' => 3,
            'tien_thu' => 0,
            'tien_chi' => $cur_item_info->cost_price * $this->input->post('newquantity'),
            //'date'=>date('Y-m-d'),
            'date' => date('Y-m-d H:i:s'),
            'cost_date_ct' => date('Y-m-d H:i:s'),
            'cost_employees' => $employee_id,
            'comment' => $cost_comment,
            'deleted' => 0
        );
        $this->db->insert('costs', $cost_date);
        //Update stock quantity

        $item_data = array(
            //'quantity'=>$cur_item_info->quantity + $this->input->post('newquantity')
            'quantity' => $cur_item_info->quantity + $quan,
            'quantity_total' => $cur_item_info->quantity_total + $quan,
        );
        if ($this->Item->save($item_data, $item_id)) {
            echo json_encode(array('success' => true, 'message' => lang('items_successful_updating') . ' ' .
                $cur_item_info->name, 'item_id' => $item_id));
        } else {//failure
            echo json_encode(array('success' => false, 'message' => lang('items_error_adding_updating') . ' ' .
                $cur_item_info->name, 'item_id' => -1));
        }
    }

//---------------------------------------------------------------------Ramel

    function bulk_update() {
        $this->check_action_permission('add_update');
        $items_to_update = $this->input->post('item_ids');
        $select_inventory = $this->get_select_inventory();

        //clears the total inventory selection
        $this->clear_select_inventory();

        $item_data = array();

        foreach ($_POST as $key => $value) {
            if ($key == 'submit') {
                continue;
            }

            //This field is nullable, so treat it differently
            if ($key == 'supplier_id') {
                if ($value != '') {
                    $item_data["$key"] = $value == '-1' ? null : $value;
                }
            } elseif ($value != '' and ! (in_array($key, array('item_ids', 'tax_names', 'tax_percents', 'tax_cumulatives', 'start_month', 'start_year', 'start_day', 'end_month', 'end_year', 'end_day', 'select_inventory')))) {
                $item_data["$key"] = $value;
            }
        }

        //Item data could be empty if tax information is being updated
        if (empty($item_data) || $this->Item->update_multiple($item_data, $items_to_update, $select_inventory)) {
            $items_taxes_data = array();
            $tax_names = $this->input->post('tax_names');
            $tax_percents = $this->input->post('tax_percents');
            $tax_cumulatives = $this->input->post('tax_cumulatives');

            for ($k = 0; $k < count($tax_percents); $k++) {
                if (is_numeric($tax_percents[$k])) {
                    $items_taxes_data[] = array('name' => $tax_names[$k], 'percent' => $tax_percents[$k], 'cumulative' => isset($tax_cumulatives[$k]) ? $tax_cumulatives[$k] : '0');
                }
            }

            if (!empty($items_taxes_data)) {
                $this->Item_taxes->save_multiple($items_taxes_data, $items_to_update);
            }

            echo json_encode(array('success' => true, 'message' => lang('items_successful_bulk_edit')));
        } else {
            echo json_encode(array('success' => false, 'message' => lang('items_error_updating_multiple')));
        }
    }
    function excel() {
        $data = file_get_contents("import_items.xlsx");
        $name = 'import_items.xlsx';
        force_download($name, $data);
    }

    /* added for excel expert */

    function excel_export($template = 0) {
        $categories = $this->Category->get_all();
        require_once APPPATH . "/third_party/Classes/export_items.php";
    }

    function excel_import() {
        $this->check_action_permission('add_update');
        $this->load->view("items/excel_import", null);
    }

    function do_excel_import() {
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
                //echo $highestRow;die;
                //$highestRow =11;
                $list_customer_duplicate_mail = array();
                $i = 0;
                for ($row = 4; $row <= $highestRow; ++$row) {
                    $array_info = array();
                    for ($col = 0; $col <= $highestColumnIndex; ++$col) {
                        $array_info[] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                    }
                    $item_data = array(
                        'name' => $array_info[1],
                        'category' => $array_info[2],
                        'unit' => $array_info[3],
                        'description' => $array_info[15],
                        'location' => $array_info[14],
                        'cost_price' => $array_info[5],
                        'unit_price' => $array_info[6],
                        'quantity' => $array_info[12],
                        'quantity_total' => $array_info[12],
                        'reorder_level' => $array_info[13],
                        //'supplier_id' => $this->Supplier->exists($array_info[3]) ? $array_info[3] : null,
                        'allow_alt_description' => $array_info[16] != '' ? '1' : '0',
                        'is_serialized' => $array_info[17] != '' ? '1' : '0',
                            //'category_id' => 4, 'unit_id' => 1, 'source_id' => 1, 'manufacture_id' => 3, 'supplier_id' => 8
                            )
                    ;

                    $item_supplier_id = $array_info[4];
                    $info_supplier = array('');
                    $info_supplier = $this->Supplier->get_supplier($item_supplier_id);

                    if ($info_supplier == '') {
                        $item_data['supplier_id'] = '';
                    } else {
                        $item_data['supplier_id'] = $info_supplier['person_id'];
                    }

                    $item_number = $array_info[0];
                    if ($item_number != "") {
                        $item_data['item_number'] = $item_number;
                    }
                    if ($this->Item->save($item_data)) {
                        $items_taxes_data = null;
                        //tax 1
                        if (is_numeric($array_info[8]) && $array_info[7] != '') {
                            $items_taxes_data[] = array(
                                'name' => $array_info[7],
                                'percent' => $array_info[8],
                                'cumulative' => '0'
                            );
                        }
                        //tax 2
                        if (is_numeric($array_info[10]) && $array_info[9] != '') {
                            $items_taxes_data[] = array(
                                'name' => $array_info[9],
                                'percent' => $array_info[10],
                                'cumulative' => $array_info[11] != '' ? '1' : '0',
                            );
                        }
                        // save tax values
                        if (count($items_taxes_data) > 0) {
                            $this->Item_taxes->save($items_taxes_data, $item_data['item_id']);
                        }
                        $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
                        $emp_info = $this->Employee->get_info($employee_id);
                        $comment = 'Qty CSV Imported';
                        $excel_data = array(
                            'trans_items' => $item_data['item_id'],
                            'trans_user' => $employee_id,
                            'trans_comment' => $comment,
                            'trans_inventory' => $array_info[12]
                        );
                        $this->db->insert('inventory', $excel_data);
                        //------------------------------------------------Ramel
                    } else {//insert or update item failure
                        $failCodes[] = $i;
                    }
                }
            } else {
                echo json_encode(array('success' => false, 'message' => lang('common_upload_file_not_supported_format')));
                return;
            }
        }
        $success = true;
        if (count($failCodes) > 1) {
            $msg = lang('items_most_imported_some_failed') . " (" . count($failCodes) . ": " . implode(", ", $failCodes);
            $success = false;
        } else {
            $msg = lang('items_import_successful');
        }
        echo json_encode(array('success' => $success, 'message' => $msg));
    }

    function excel_import_update() {
        $this->check_action_permission('add_update');
        $this->load->view("items/excel_import_update", null);
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
                    $item_data = array(
                        'name' => $data[1],
                        'description' => $data[15],
                        'location' => $data[14],
                        'category' => $data[2],
                        'unit' => $data[3],
                        'cost_price' => $data[5],
                        'unit_price' => $data[6],
                        'quantity' => $data[12],
                        'reorder_level' => $data[13],
                        'supplier_id' => $this->Supplier->exists($data[4]) ? $data[4] : $this->Supplier->find_supplier_id($data[4]),
                        'allow_alt_description' => $data[16] != '' and $data[16] != '0' and strtolower($data[16]) != 'n' ? '1' : '0',
                        'is_serialized' => $data[17] != '' and $data[17] != '0' and strtolower($data[17]) != 'n' ? '1' : '0',
                    );

                    $item_number = $data[0];
                    if ($item_number != "") {
                        $item_data['item_number'] = $item_number;
                    }

                    if ($this->Item->exists($data[18])) {
                        $this->Item->save($item_data, $data[18]);
                    } else if ($this->Item->save($item_data)) {
                        $items_taxes_data = null;
                        //tax 1
                        if (is_numeric($data[8]) && $data[7] != '') {
                            $items_taxes_data[] = array('name' => $data[7], 'percent' => $data[8], 'cumulative' => '0');
                        }

                        //tax 2
                        if (is_numeric($data[10]) && $data[9] != '') {
                            $items_taxes_data[] = array('name' => $data[9], 'percent' => $data[10], 'cumulative' => $data[11] != '' and $data[11] != '0' and $data[11] != 'n' ? '1' : '0',);
                        }

                        // save tax values
                        if (count($items_taxes_data) > 0) {
                            $this->Item_taxes->save($items_taxes_data, $item_data['item_id']);
                        }

                        $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
                        $emp_info = $this->Employee->get_info($employee_id);
                        $comment = 'Qty CSV Imported';
                        $excel_data = array
                            (
                            'trans_items' => $item_data['item_id'],
                            'trans_user' => $employee_id,
                            'trans_comment' => $comment,
                            'trans_inventory' => $data[12]
                        );

                        $this->db->insert('inventory', $excel_data);

                        //------------------------------------------------Ramel
                    } else {//insert or update item failure
                        echo json_encode(array('success' => false, 'message' => lang('items_duplicate_item_ids')));
                        return;
                    }
                }
            } else {
                echo json_encode(array('success' => false, 'message' => lang('common_upload_file_not_supported_format')));
                return;
            }
        }

        $this->db->trans_complete();
        echo json_encode(array('success' => true, 'message' => lang('items_import_successful')));
    }

    function cleanup() {
        $this->Item->cleanup();
        echo json_encode(array('success' => true, 'message' => lang('items_cleanup_sucessful')));
    }

    /*
      get the width for the add/edit form
     */

    function get_form_width() {
        return 1050;
    }

    function select_inventory() {
        $this->session->set_userdata('select_inventory', 1);
    }

    function get_select_inventory() {
        return $this->session->userdata('select_inventory') ? $this->session->userdata('select_inventory') : 0;
    }

    function clear_select_inventory() {
        $this->session->unset_userdata('select_inventory');
    }

    function updatequantity() {
        $data = array(
            'quantity' => 0
        );
        $this->Item->update_quantity_price($data);
    }

    /* =======edit by: hungdq  ======= */

    public function save_item_verifying() {
        if ($this->input->post("store")) {
            $data_verifying = array();
            foreach ($this->input->post("store") as $store => $st) {
                foreach ($this->input->post("quantity") as $quantity => $q) {
                    if ($store == $quantity) {
                        foreach ($this->input->post("quantity_sale") as $quantity_sale => $q_s) {
                            if ($quantity == $quantity_sale) {
                                foreach ($this->input->post("quantity_verifying") as $quantity_verifying => $q_v) {
                                    if ($quantity_sale == $quantity_verifying) {
                                        foreach ($this->input->post("command") as $command => $c) {
                                            if ($quantity_verifying == $command) {
                                                $data_verifying = array(
                                                    'item_id' => $store,
                                                    'quantity_input' => 0,
                                                    'quantity_inventory' => $q,
                                                    'quantity_verifying' => $q_v,
                                                    'quantity_sale' => $q_s,
                                                    'warehouse_id' => $st,
                                                    'command' => $c,
                                                    'date' => date("y-m-d H:i:s"),
                                                );
                                                $this->Item->add_verifying($data_verifying);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $this->session->unset_userdata('next_warehouse');
        $this->session->unset_userdata('category_item');
        redirect('items/warehouse');
//        if ($this->Item->add_verifying($data_verifying)) {
//            $this->warehouse();
//        } else {
//            $this->items();
//        }
    }

    public function warehouse() {
        $store = $this->input->post('next_warehouse');
        $data = $this->input->post('name_items');
        if ($store != 0) {
            $query['store'] = $this->Item->kiemkho_store($data, $store);
        } else {
            $query['store'] = $this->Item->kiemkho($data);
        }
        $query['get_buy'] = $this->Item->get_buy($data, $store);
        $query['verifying'] = $this->Item->get_all_verifying();
        $query['store_kho'] = $store;
        $this->load->view('items/warehouse', $query);
    }

    /* ====================================== */

    //Created by San 06/03/2015
    function item_search_product_store() {
        $info_store = $this->Create_invetory->check_exist_store_materials();
        $suggestions = $this->Item->get_item_search_store_material_suggestions($this->input->get('term'), $info_store['id'], 100);
        echo json_encode($suggestions);
    }

    function get_info_in_store_material($item_id = -1) {
        echo json_encode($this->Item->get_info_in_store_material($item_id));
    }

    function detail_quantity_item($item_id) {
        $data['info_item'] = $this->Item->get_info($item_id);
        $data['list_item_warehouse'] = $this->Item->get_list_items_in_warehouse_items($item_id);
        $this->load->view("items/detail_quantity_item", $data);
    }

    function set_category_item() {
        $category_item = $this->input->post("category_item");
        if ($category_item) {
            if ($this->session->userdata('category_item')) {
                $this->session->unset_userdata('category_item');
                $this->session->set_userdata('category_item', $category_item);
            } else {
                $this->session->set_userdata('category_item', $category_item);
            }
        } else {
            if ($this->session->userdata('category_item')) {
                $this->session->unset_userdata('category_item');
            }
        }
    }

    public function item_search_inventory() {
        $store = $this->sale_lib->get_next_warehouse();
        if ($this->session->userdata('category_item')) {
            $category = $this->session->userdata('category_item');
        }
        $suggestions = $this->Item->get_item_search_suggestions_warehouse_inventory($this->input->get('term'), $store, $category, 100);
        echo json_encode($suggestions);
    }

    //hung audi 6-4-15 CHUYEN KHO
    public function next_inventory() {
        $this->load->view('items/next_inventory', $data);
    }

    public function save_next_inventory() {
        $store = $this->sale_lib->get_next_warehouse();
        //die($store );
        $ids = $this->input->post('item_id');
        $quantity_inventorys = $this->input->post('quantity_inventory');
        $quantity_tranfs = $this->input->post('quantity_next');
        $inventory_id = $this->input->post('inven_transfer'); //kho nhan
        foreach ($ids as $id2 => $id) {
            foreach ($quantity_tranfs as $quantity_tranf2 => $quantity_tranf) {
                if ($id2 == $quantity_tranf2) {
                    foreach ($quantity_inventorys as $quantity_inventory2 => $quantity_inventory) {
                        if ($quantity_tranf2 == $quantity_inventory2) {
                            $warehouse_items[] = array(
                                'item_id' => $id,
                                'quantity' => $quantity_tranf,
                                'quantity_inventory' => $quantity_inventory,
                            );
                        }
                    }
                }
            }
        }
        foreach ($warehouse_items as $key => $val) {
            $stores_items_db = $this->Item->get_id_Items_warehouse($inventory_id, $val['item_id']); //warehouse_items

            if ($stores_items_db) {//sp trong bang warehouse_item
                if ($inventory_id != 0) {//kho nhan # kho tong
                    $warehouse_items['quantity'] = $stores_items_db->quantity + $val['quantity']; //qty kho #
                } else {//kho nhan la kho tong
                    $stores_items_db_total = $this->Item->get_id_Items_warehouse_total($val['item_id']); //items
                    $qty_total['quantity_total'] = $stores_items_db_total->quantity_total + $val['quantity'];

                    $warehouse_items['quantity'] = $qty_total['quantity_total']; //qty kho tong
                }
            } else {
                $warehouse_items['quantity'] = $val['quantity'];
            }

            $warehouse_items = array(
                'warehouse_id' => $inventory_id,
                'store_id' => $store,
                'item_id' => $val['item_id'],
                'quantity' => $warehouse_items['quantity'],
                'stt' => 0,
                'date' => date('Y-m-d H:i:s')
            );
            $this->Item->saveWarehouseItems($warehouse_items, $stores_items_db->id);   //save kho # warehouse
            $this->Item->saveWarehouseItems_total($qty_total, $stores_items_db_total->item_id); //save kho tong (.) items
            //save transfre
            $data_next_inven = array(
                'warehouse_id' => $inventory_id,
                'store_id' => $store,
                'item_id' => $val['item_id'],
                'quantity' => $val['quantity'],
                'stt' => 0,
                'date' => date('Y-m-d H:i:s')
            );
            $this->Item->insert_stores_transfre($data_next_inven); //save transfer stores
            //update lai so luong kho chuyen
            $info_item = $this->Item->get_quantity_item($val['item_id']);
            $query = $this->Item->get_quantity_item_store($val['item_id'], $store); //get qty kho #
            $id_kho = $this->Item->get_id_kho($val['item_id'], $store);    //get id kho #

            if ($store != 0) {
                $data = array('quantity' => $query - $val['quantity']);
                $this->Item->update_quantity_store($id_kho, $data);
            } else {
                $data = array('quantity_total' => $info_item - $val['quantity']);
                $this->Item->update_quantiry($val['item_id'], $data);
            }
        }
        redirect('items/next_inventory');
    }

    public function item_search_new() {
        $store = $this->sale_lib->get_next_warehouse();
        if ($store != 0) {
            $suggestions = $this->Item->get_item_search_suggestions_new_and_store($this->input->get('term'), $store, 100);
            echo json_encode($suggestions);
        } else {
            $suggestions = $this->Item->get_item_search_suggestions_new($this->input->get('term'), 100);
            echo json_encode($suggestions);
        }
    }

    function set_next_warehouse() {
        $this->sale_lib->set_next_warehouse($this->input->post('next_warehouse'));
    }

    function change_inv() {
        $store = $this->input->post('next_warehouse2');
        $suggestions = $this->Create_invetory->get_all3($store);
        echo json_encode($suggestions);
    }

}

?>