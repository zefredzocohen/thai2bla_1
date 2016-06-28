<?php

require_once(APPPATH . 'third_party/Classes/PHPExcel/IOFactory.php');
require_once(APPPATH . 'libraries/php-excel.class.php');
require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");

class Items extends Secure_area implements iData_controller {

    function __construct() {
        parent::__construct('items');
        $this->load->library('sale_lib');
        $this->load->library('receiving_lib');
    }

    function index() {
        //phan lam don hang
        $data = array();
        // co ghi no suspender=1 trong model
        $data['suspended_sales'] = $this->Sale->get_all_suspended()->result_array();
        //end
        //phan lam hạn san pham
        
                // lấy danh sách sản phẩm chưa bị xóa
        $items = array();
        $allitems = $this->Customer->findAllItem();
        foreach ($allitems as $allitem) {
            if ($allitem['quantity'] <= $allitem['reorder_level']) {
                $items[] = $allitem['item_id'];
               
            }
        }
         $data['items'] = $items;

        //end phan lam han san pham
         
                // kiểm tra xem người dùng có được sử dụng modul ko.
        $this->check_action_permission('search');
        $config['base_url'] = site_url('items/sorting');
        $config['total_rows'] = $this->Item->count_all();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
            // viet thuong ten cua module
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['total_rows'] = $this->Item->count_all();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_items_manage_table($this->Item->get_all_items($data['per_page']), $this);
        $data['categories'] = $this->Category->get_all();
        /* */
        $data['warehouse'] = $this->Create_invetory->get_warehouse();
        $data['shopping_items'] = $this->sale_lib->get_cart();
        $data['trading_items'] = $this->receiving_lib->get_cart();
        /* */
//        echo "<pre>";
//        print_r( $data['controller_name']);
//       
//        echo "</pre>";
//        die();
        $this->load->view('items/manage', $data);
    }

    function sorting() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $cat = $this->input->post('cat');
        $stores = $this->input->post('stores');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search || $stores || $cat) {
            $config['total_rows'] = $this->Item->search_count_all_items($search, $stores, $cat);
            $table_data = $this->Item->search_items($search, $stores, $cat, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'item_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        } else {
            $config['total_rows'] = $this->Item->count_all();
            $table_data = $this->Item->get_all_items($per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'item_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        }
        $config['base_url'] = site_url('items/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_items_manage_table_data_rows($table_data, $this);
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
        $stores = $this->input->post('stores');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;//10 ban ghi
        $search_data = $this->Item->search_items($search, $stores, $cat, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'item_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        $config['base_url'] = site_url('items/search');
        $config['total_rows'] = $this->Item->search_count_all_items($search, $stores, $cat);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_items_manage_table_data_rows($search_data,$this);
      echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    /*
      Gives search suggestions based on what is being searched for
     */

    function suggest() {
        $suggestions = $this->Item->get_search_suggestions($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    function item_search() {
        $suggestions = $this->Item->get_item_search_suggestions($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    /*
      Gives search suggestions based on what is being searched for
     */

    function suggest_category() {
        $suggestions = $this->Item->get_category_suggestions($this->input->get('term'));
        echo json_encode($suggestions);
    }

    //check trùng tên
    function checkname($id) {
        $name = $this->input->post('name');
        $d['name'] = $this->Item->getname($id);
        $d1 = $d['name'];
        $c = array();
        foreach ($d1 as $d2) {
            $d3 = $d2['name'];
            $c[] = $d3;
        }
        $c2 = $c;
        $e1 = implode(',', $c2);
        $e2 = explode(',', $e1);

        if (in_array($name, $e2)) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    function get_row() {
        $item_id = $this->input->post('row_id');
        $data_row = get_item_data_row($this->Item->get_info_item($item_id), $this);
        echo $data_row;
    }

    function get_info($item_id = -1) {
        echo json_encode($this->Item->get_info($item_id));
    }

    function view($item_id = -1) {
        $this->check_action_permission('add_update');
        // Alain promotion price...
        $this->load->model('Category');
        $this->load->model('Unit');
        $this->load->helper('report');
        $data = array();
        $data['months'] = get_months();
        $data['days'] = get_days();
        $data['years'] = get_years();
        $data['end_years'] = array(date("Y") + 1 => date("Y") + 1) + $data['years'];

        $data['item_info'] = $this->Item->get_info($item_id);
        $data['item_tax_info'] = $this->Item_taxes->get_info($item_id);

        //suppliers
        $suppliers = array('' => lang('items_none'));
        foreach ($this->Supplier->get_all()->result_array() as $row) {
            $suppliers[$row['person_id']] = $row['company_name'] . ' (' . $row['first_name'] . ' ' . $row['last_name'] . ')';
        }
        $data['suppliers'] = $suppliers;
        $data['selected_supplier'] = $this->Item->get_info($item_id)->supplier_id;

        //category
        $cats = array('' => ''); //kho tong
        $get_all = $this->Category->get_all();
        foreach ($get_all as $row2) {
            $cats[$row2['id_cat']] = $row2['name'];
        }
        $data['cats'] = $cats;
        $data['selected_cat'] = $this->Item->get_info($item_id)->category;

        $data['default_tax_1_rate'] = ($item_id == -1) ? $this->Appconfig->get('default_tax_1_rate') : '';
        $data['default_tax_2_rate'] = ($item_id == -1) ? $this->Appconfig->get('default_tax_2_rate') : '';
        $data['default_tax_2_cumulative'] = ($item_id == -1) ? $this->Appconfig->get('default_tax_2_cumulative') : '';
        //Alain Promo Price
        if ($item_id == -1) {
            $data['selected_start_year'] = 0;
            $data['selected_start_month'] = 0;
            $data['selected_start_day'] = 0;
            $data['selected_end_year'] = 0;
            $data['selected_end_month'] = 0;
            $data['selected_end_day'] = 0;
        } else {
            list($data['selected_start_year'], $data['selected_start_month'], $data['selected_start_day']) = explode('-', $data['item_info']->start_date);
            list($data['selected_end_year'], $data['selected_end_month'], $data['selected_end_day']) = explode('-', $data['item_info']->end_date);
        }
       
        $this->load->view("items/form", $data);
    }

    //Ramel Inventory Tracking
    function inventory($item_id = -1) {
        $this->check_action_permission('add_update');
        $data['item_info'] = $this->Item->get_info($item_id);
        $data['stores'] = $this->Create_invetory->get_all()->result_array();
        $data['store_active'] = $this->sale_lib->get_store();
        $this->load->view("items/inventory", $data);
    }

    function count_details($item_id) {
        $this->receiving_lib->set_detail_item($item_id);
        redirect("items/detail_info_item");
    }

    function detail_info_item() {
        $item_id = $this->receiving_lib->get_detail_item();
        $data['item_info'] = $this->Item->get_info($item_id);
        $config['base_url'] = site_url("items/sorting_detail_info_item");
        $config['total_rows'] = $this->Item->count_all_inventory_by_item($item_id);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_inventory_item_manage_table($this->Item->get_all_inventory_by_item($item_id, $data['per_page']), $this);
        $this->load->view('items/detail_quantity_change', $data);
    }

    function search_detail_info_item() {
        $item_id = $this->receiving_lib->get_detail_item();
        $start_date1 = $this->input->post('start_date');
        $end_date1 = $this->input->post('end_date');
        $tam = $end_date1;
        $tam .='23:59:59';
        $start_date = date('Y-m-d H:i:s', strtotime($start_date1));
        $end_date = date('Y-m-d H:i:s', strtotime($tam));

        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Item->search_inventory_by_item($item_id, $start_date, $end_date, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'trans_date', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
        );
        $config['base_url'] = site_url("items/search_detail_info_item");
        $config['total_rows'] = $this->Item->search_count_all_inventory_by_item($item_id, $start_date, $end_date);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_inventory_item_manage_table_data_rows($search_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function sorting_detail_info_item() {
        $item_id = $this->receiving_lib->get_detail_item();
        $start_date1 = $this->input->post('start_date');
        $end_date1 = $this->input->post('end_date');
        $tam = $end_date1;
        $tam .='23:59:59';
        $start_date = date('Y-m-d H:i:s', strtotime($start_date1));
        $end_date = date('Y-m-d H:i:s', strtotime($tam));
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($start_date || $end_date) {
            $config['total_rows'] = $this->Item->search_count_all_inventory_by_item($item_id, $start_date, $end_date); //search_count_all
            $table_data = $this->Item->search_inventory_by_item($item_id, $start_date, $end_date, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'trans_date', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        } else {
            $config['total_rows'] = $this->Item->count_all_inventory_by_item($item_id); //count_all
            $table_data = $this->Item->get_inventory_item_manage_table($item_id, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'trans_date', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        }//get_all
        $config['base_url'] = site_url("items/sorting_detail_info_item");
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);

        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_inventory_item_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

//------------------------------------------- Ramel



    function generate_barcodes($item_ids) {
        $result = array();

        $item_ids = explode('~', $item_ids);
        foreach ($item_ids as $item_id) {
            $item_info = $this->Item->get_info($item_id);

            $result[] = array('name' => $item_info->item_number . ': ' . to_currency_format($item_info->unit_price), 'id' => number_pad($item_id, 11));
        }

        $data['items'] = $result;
        $data['scale'] = 2;
        $this->load->view("barcode_sheet", $data);
    }

    function generate_barcode_labels($item_ids) {

        $result = array();

        $item_ids = explode('~', $item_ids);
        foreach ($item_ids as $item_id) {
            $item_info = $this->Item->get_info($item_id);

            $result[] = array('name' => $item_info->item_number . ': ' . to_currency_format($item_info->unit_price), 'id' => number_pad($item_id, 11));
        }
        $data['items'] = $result;
        $data['scale'] = 1;
        $this->load->view("barcode_labels", $data);
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
        redirect('items');
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
        $category = array('' => '');
        foreach ($this->Category->get_all() as $cat) {
            $category[$cat['id_cat']] = $cat['name'];
        }
        $data['category'] = $category;
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

    function save($item_id = -1) {
//        echo date('Y-m-d H:i:s',strtotime($this->input->post('start_year').'/'.$this->input->post('start_month').'/'.$this->input->post('start_day')));
//        echo 'xxxxxxxxxx<br/>';
//        strtotime($time, $now)
//        echo date('Y/m/d',$this->input->post('start_month').' '.$this->input->post('start_day').' '.$this->input->post('start_year')).'<br/>';
//        echo $this->input->post('end_month').' '.$this->input->post('end_day').' '.$this->input->post('end_year').'<br/>';
//        die;
        $this->check_action_permission('add_update');
        $check = $this->input->post("is");
        $quantity_first = ($check == 1) ? 1 : 0;
        /* phan them anh */
        $config = array(
            "upload_path" => "./item/",
            "allowed_types" => 'gif|jpg|png|bmp|jpeg',
            //'max_size' => '6000'
        );
         $chuoi = $this->input->post('name');
        $str = $this->Item->vn_str_filter("$chuoi");
        $str = str_replace(" ", "-", $str); // replate khoang trang = dau -
        $str = strtolower($str); // bo viet hoa
        $this->load->library('upload', $config);
        $anh = '';
        if (!$this->upload->do_upload('item_image')) {
            $item_data = array(
                'name' => $this->input->post('name'),
                'en_name' => $this->input->post('en_name'),
                'description' => $this->input->post('description'),
                'category' => $this->input->post('category'),
                'supplier_id' => $this->input->post('supplier_id') == '' ? null : $this->input->post('supplier_id'),
                'made_in' => $this->input->post('made_in'),
                'product_view_home' => $this->input->post('product_view_home'),
                'item_number' => $this->input->post('item_number') == '' ? null : $this->input->post('item_number'),
                'cost_price' => str_replace(array(',', '.00'), '', $this->input->post('cost_price')),
                'unit_price' => str_replace(array(',', '.00'), '', $this->input->post('unit_price')),
                'unit' => $this->input->post('unit'),
                'unit_from' => $this->input->post('unit_from'),
                'unit_rate' => $this->input->post('unit_rate'),
                'cost_price_rate' => str_replace(array(',', '.00'), '', ($this->input->post('cost_price_rate'))),
                'unit_price_rate' => str_replace(array(',', '.00'), '', ($this->input->post('unit_price_rate'))),
                'quantity_total' => $this->input->post('quantity'),
                'quantity_first' => $quantity_first,
                'promo_price' => str_replace(array(',', '.00'), '', $this->input->post('promo_price')),
                'start_date' => date('Y-m-d H:i:s',strtotime($this->input->post('start_year').'/'.$this->input->post('start_month').'/'.$this->input->post('start_day'))),
                'end_date' => date('Y-m-d H:i:s',strtotime($this->input->post('end_year').'/'.$this->input->post('end_month').'/'.$this->input->post('end_day'))),
                'reorder_level' => $this->input->post('reorder_level'),
                'allow_alt_description' => $this->input->post('allow_alt_description') ? $this->input->post('allow_alt_description') : 0,
                'taxes' => $this->input->post('taxes'),
                'top' => $this->input->post('top'),
                'en_description' => $this->input->post('en_description'),
                'url' => $str,
                'account_store' => $this->input->post('account_store'),
                'account_reven' => $this->input->post('account_reven'),
                'account_incomplete' => $this->input->post('account_incomplete'),
                'account_cos' => $this->input->post('account_cos'),
               
                
            );
            
            //update
            $item_data1 = array(
                'name' => $this->input->post('name'),
                 'en_name' => $this->input->post('en_name'),
                'description' => $this->input->post('description'),
                'category' => $this->input->post('category'),
                'supplier_id' => $this->input->post('supplier_id') == '' ? null : $this->input->post('supplier_id'),
                'made_in' => $this->input->post('made_in'),
                'product_view_home' => $this->input->post('product_view_home'),
                'item_number' => $this->input->post('item_number') == '' ? null : $this->input->post('item_number'),
                'cost_price' => str_replace(array(',', '.00'), '', $this->input->post('cost_price')),
                'unit_price' => str_replace(array(',', '.00'), '', $this->input->post('unit_price')),
                'unit' => $this->input->post('unit'),
                'unit_from' => $this->input->post('unit_from'),
                'unit_rate' => $this->input->post('unit_rate'),
                'cost_price_rate' => str_replace(array(',', '.00'), '', ($this->input->post('cost_price_rate'))),
                'unit_price_rate' => str_replace(array(',', '.00'), '', ($this->input->post('unit_price_rate'))),
                'quantity_first' => $quantity_first,
                'promo_price' => str_replace(array(',', '.00'), '', $this->input->post('promo_price')),
                'start_date' => date('Y-m-d H:i:s',strtotime($this->input->post('start_year').'/'.$this->input->post('start_month').'/'.$this->input->post('start_day'))),
                'end_date' => date('Y-m-d H:i:s',strtotime($this->input->post('end_year').'/'.$this->input->post('end_month').'/'.$this->input->post('end_day'))),
                'reorder_level' => $this->input->post('reorder_level'),
                'allow_alt_description' => $this->input->post('allow_alt_description') ? $this->input->post('allow_alt_description') : 0,
                'taxes' => $this->input->post('taxes'),
                 'top' => $this->input->post('top'),
                 'en_description' => $this->input->post('en_description'),
                'url' => $str,
                'account_store' => $this->input->post('account_store'),
                'account_reven' => $this->input->post('account_reven'),
                'account_incomplete' => $this->input->post('account_incomplete'),
                'account_cos' => $this->input->post('account_cos'),
               
            );
        } 
        else {
            
            
            
            
            if ($item_id != -1) {
                $delimg = $this->Item->get_info($item_id);
                unlink("./item/" . $delimg->images);
            }
            $images = $this->upload->data();
            $config = array(
                "source_image" => $images['full_path'],
                "maintain_ration" => true,
                "width" => '157',
                "height" => "230"
            );
            $this->load->library("image_lib", $config);
            $this->image_lib->resize();
            if ($images != "") {
                $img = $images['file_name'];
            }
            
            
            $item_data = array(
                'name' => $this->input->post('name'),
                 'en_name' => $this->input->post('en_name'),
                'description' => $this->input->post('description'),
                'category' => $this->input->post('category'),
                'supplier_id' => $this->input->post('supplier_id') == '' ? null : $this->input->post('supplier_id'),
                'made_in' => $this->input->post('made_in'),
                'product_view_home' => $this->input->post('product_view_home'),
                'item_number' => $this->input->post('item_number') == '' ? null : $this->input->post('item_number'),
                'cost_price' => str_replace(array(',', '.00'), '', $this->input->post('cost_price')),
                'unit_price' => str_replace(array(',', '.00'), '', $this->input->post('unit_price')),
                'unit' => $this->input->post('unit'),
                'unit_from' => $this->input->post('unit_from'),
                'unit_rate' => $this->input->post('unit_rate'),
                'cost_price_rate' => str_replace(array(',', '.00'), '', ($this->input->post('cost_price_rate'))),
                'unit_price_rate' => str_replace(array(',', '.00'), '', ($this->input->post('unit_price_rate'))),
                'quantity_total' => $this->input->post('quantity'),
                'quantity_first' => $quantity_first,
                'promo_price' => str_replace(array(',', '.00'), '', $this->input->post('promo_price')),
                'start_date' => date('Y-m-d H:i:s',strtotime($this->input->post('start_year').'/'.$this->input->post('start_month').'/'.$this->input->post('start_day'))),
                'end_date' => date('Y-m-d H:i:s',strtotime($this->input->post('end_year').'/'.$this->input->post('end_month').'/'.$this->input->post('end_day'))),
                'reorder_level' => $this->input->post('reorder_level'),
                'allow_alt_description' => $this->input->post('allow_alt_description') ? $this->input->post('allow_alt_description') : 0,
                'images' => $img,
                'taxes' => $this->input->post('taxes'),
                 'top' => $this->input->post('top'),
                 'en_description' => $this->input->post('en_description'),
                'url' => $str,
                'account_store' => $this->input->post('account_store'),
                'account_reven' => $this->input->post('account_reven'),
                'account_incomplete' => $this->input->post('account_incomplete'),
                'account_cos' => $this->input->post('account_cos'),
                
                
            );
//            mktime($hour, $minute, $second, $month, $day, $year, $is_dst)
            $item_data1 = array(
                'name' => $this->input->post('name'),
                 'en_name' => $this->input->post('en_name'),
                'description' => $this->input->post('description'),
                'category' => $this->input->post('category'),
                'supplier_id' => $this->input->post('supplier_id') == '' ? null : $this->input->post('supplier_id'),
                'made_in' => $this->input->post('made_in'),
                'product_view_home' => $this->input->post('product_view_home'),
                'item_number' => $this->input->post('item_number') == '' ? null : $this->input->post('item_number'),
                'cost_price' => str_replace(array(',', '.00'), '', $this->input->post('cost_price')),
                'unit_price' => str_replace(array(',', '.00'), '', $this->input->post('unit_price')),
                'unit' => $this->input->post('unit'),
                'unit_from' => $this->input->post('unit_from'),
                'unit_rate' => $this->input->post('unit_rate'),
                'cost_price_rate' => str_replace(array(',', '.00'), '', ($this->input->post('cost_price_rate'))),
                'unit_price_rate' => str_replace(array(',', '.00'), '', ($this->input->post('unit_price_rate'))),
                'quantity_total' => $this->input->post('quantity'),
                'quantity_first' => $quantity_first,
                'promo_price' => str_replace(array(',', '.00'), '', $this->input->post('promo_price')),
                'start_date' => date('Y-m-d H:i:s',strtotime($this->input->post('start_year').'/'.$this->input->post('start_month').'/'.$this->input->post('start_day'))),
                'end_date' => date('Y-m-d H:i:s',strtotime($this->input->post('end_year').'/'.$this->input->post('end_month').'/'.$this->input->post('end_day'))),
                'reorder_level' => $this->input->post('reorder_level'),
                'allow_alt_description' => $this->input->post('allow_alt_description') ? $this->input->post('allow_alt_description') : 0,
                'images' => $img,
                'taxes' => $this->input->post('taxes'),
                 'top' => $this->input->post('top'),
                 'en_description' => $this->input->post('en_description'),
                'url' => $str,
                'account_store' => $this->input->post('account_store'),
                'account_reven' => $this->input->post('account_reven'),
                'account_incomplete' => $this->input->post('account_incomplete'),
                'account_cos' => $this->input->post('account_cos'),
               
                
            );
            
          
            
            
        }
        $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
        $cur_item_info = $this->Item->get_info($item_id);
        if ($item_id == -1) {
            if ($this->Item->save($item_data, $item_id)) {
                echo json_encode(array('success' => true, 'message' => lang('items_successful_adding') . ' ' .
                    $item_data['name'], 'item_id' => $item_data['item_id']));
                $item_id = $item_data['item_id'];
               
                //thue
                $items_taxes_data = array();
                $tax_names = 'Thuế';
                $tax_percents = $this->input->post('taxes');
                $tax_cumulatives = $this->input->post('tax_cumulatives');
                if (is_numeric($tax_percents)) {
                    $items_taxes_data[] = array('name' => $tax_names, 'percent' => $tax_percents, 'cumulative' => isset($tax_cumulatives) ? $tax_cumulatives : '0');
                }
                $this->Item_taxes->save($items_taxes_data, $item_id);
            } else {//failure                    
                echo json_encode(array('success' => false, 'message' => lang('items_error_adding_updating') . ' ' .
                    $item_data['name'], 'item_id' => -1));
            }
            
            //them anh
            $name_array = array();
                    if(isset($_FILES['userfile'])){                      
                   $count = count($_FILES['userfile']['size']);                                  
                    foreach($_FILES as $key=>$value)                    
                    for($s=0; $s<=$count-1; $s++) {                   
                    $_FILES['userfile']['name']=$value['name'][$s];                    
                    $_FILES['userfile']['type']    = $value['type'][$s];                    
                    $_FILES['userfile']['tmp_name'] = $value['tmp_name'][$s];                    
                    $_FILES['userfile']['error']       = $value['error'][$s];                    
                    $_FILES['userfile']['size']    = $value['size'][$s];                          
                    $config['upload_path'] = './item/';                        
                    $config['allowed_types'] = 'gif|jpg|png';                        
                    $config['max_size']    = '100';                        
                    $config['max_width']  = '1024';                        
                    $config['max_height']  = '768';                    
                    $this->load->library('upload', $config);                    
                    $this->upload->do_upload();                    
                    $data_img = $this->upload->data();                   
                    $name_array[] = $data_img['file_name'];                        
                    }
                   //Dùng vòng lặp .insert các ảnh vào database                        
                       foreach($name_array as $img_pro){                                
                        $arr = array(                                        
                                       'item_id'=>$item_id,                                        
                                        'img_product'=>$img_pro                               
                                 );                                
                        $this->Item->save_img_product($arr);                        
                  }                   
              } 
            //
            
        } else {
            if ($this->Item->save($item_data1, $item_id)) {
                echo json_encode(array('success' => true, 'message' => lang('items_successful_updating') . ' ' .
                    $item_data['name'], 'item_id' => $item_id));

                $items_taxes_data = array();
                $tax_names = 'Thuế';
                $tax_percents = $this->input->post('taxes');
                $tax_cumulatives = $this->input->post('tax_cumulatives');
                if (is_numeric($tax_percents)) {
                    $items_taxes_data[] = array('name' => $tax_names, 'percent' => $tax_percents, 'cumulative' => isset($tax_cumulatives) ? $tax_cumulatives : '0');
                }
                $this->Item_taxes->save($items_taxes_data, $item_id);
            } else {//failure                 
                echo json_encode(array('success' => false, 'message' => lang('items_error_adding_updating') . ' ' .
                    $item_data['name'], 'item_id' => -1));
            }
        }
        
         
    }
    
     function save_update($item_id = -1) {
        $this->check_action_permission('add_update');
       
            $item_data1 = array(
                'details' => $this->input->post('details'),
                'en_details' => $this->input->post('en_details'),
                'technical' => $this->input->post('technical'),
                'en_technical' => $this->input->post('en_technical'),
                
            );

        if ($item_id != -1) {
            $this->Item->save($item_data1,$item_id);
            redirect(base_url('items'));
                   
        }
         
    }
    
    function technical($item_id = -1) {
        
        $this->check_action_permission('add_update');
       $data['item_info'] = $this->Item->get_info($item_id);
        $this->load->view("items/technical",$data);
    }

    //Ramel Inventory Tracking
    function save_inventory($item_id = -1) {
        $this->check_action_permission('add_update');
        $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
        $cur_item_info = $this->Item->get_info($item_id);

        if ($cur_item_info->unit_rate > 0) {
            $quan = $cur_item_info->unit_rate * $this->input->post('newquantity') / $cur_item_info->quantity_first;
        } else {
            $quan = $this->input->post('newquantity');
        }

        $receiving_id = $this->db->insert_id();
        $store = $this->input->post('store');

        if ($store != 0) {
            $warehouse_items = array(
                'warehouse_id' => $store,
                'item_id' => $item_id,
                'quantity' => $quan,
                'stt' => 1,
                'date' => date('Y-m-d H:i:s')
            );
            //get_id_warehouse ang get_id_item
            $stores_items_db = $this->Item->get_id_Items_warehouse($store, $item_id);
            if ($stores_items_db) {

                $warehouse_items['quantity'] = $stores_items_db->quantity + $quan;
            }
            $this->Item->saveWarehouseItems($warehouse_items, $stores_items_db->id);
            echo json_encode(array('success' => true, 'message' => lang('items_successful_updating') . ' ' .
                $cur_item_info->name, 'item_id' => $item_id));

            $item_data = array(
                'quantity' => $cur_item_info->quantity + $quan
            );
            $this->Item->save($item_data, $item_id);
            $inv_data = array(
                'trans_date' => date('Y-m-d H:i:s'),
                'trans_items' => $item_id,
                'trans_user' => $employee_id,
                'trans_comment' => 'ADD',
                'trans_inventory' => $quan,
                'trans_catid' => $cur_item_info->category,
                'trans_money' => $cur_item_info->quantity_first > 0 ? $cur_item_info->cost_price_rate : $cur_item_info->cost_price,
                'trans_people' => 0,
                'trans_recevings' => $receiving_id,
                'store_id' => $store
            );
            $this->Inventory->insert($inv_data);

            $cost_date = array(
                'id_customer' => 0,
                'name' => 3,
                'tien_thu' => 0,
                'tien_chi' => $cur_item_info->cost_price * $this->input->post('newquantity'),
                'cost_date_ct' => date('Y-m-d H:i:s'),
                'cost_employees' => $employee_id,
                'comment' => $cost_comment,
                'deleted' => 0
            );
            $this->db->insert('costs', $cost_date);
        } else {
            $inv_data = array(
                'trans_date' => date('Y-m-d H:i:s'),
                'trans_items' => $item_id,
                'trans_user' => $employee_id,
                'trans_comment' => 'ADD',
                'trans_inventory' => $quan,
                'trans_catid' => $cur_item_info->category,
                'trans_money' => $cur_item_info->quantity_first > 0 ? $cur_item_info->cost_price_rate : $cur_item_info->cost_price,
                'trans_people' => 0,
                'trans_recevings' => $receiving_id,
                'store_id' => $store
            );
            $this->Inventory->insert($inv_data);

            $cost_comment = "Chi tiền nhập kho sản phẩm " . $this->Item->get_info($item_id)->name;
            $cost_date = array(
                'id_customer' => 0,
                'name' => 3,
                'tien_thu' => 0,
                'tien_chi' => $cur_item_info->cost_price * $this->input->post('newquantity'),
                'cost_date_ct' => date('Y-m-d H:i:s'),
                'cost_employees' => $employee_id,
                'comment' => $cost_comment,
                'deleted' => 0
            );
            $this->db->insert('costs', $cost_date);

            $item_data = array(
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
            $tax_names = $this->input->post('tax_names1');
            $tax_percents = $this->input->post('tax_percents1');
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

    function delete() {
        $this->check_action_permission('delete');

        $items_to_delete = $this->input->post('ids');
        $select_inventory = $this->get_select_inventory();
        $total_rows = $select_inventory ? $this->Item->count_all() : count($items_to_delete);
        if ($select_inventory) {
            $data_item_all = array();
            $str_all = "";
            $get_all = $this->Item->get_all_item();
            foreach ($get_all as $item_all) {
                $check_item = $this->Inventory->check_exists_item_in_inventory($item_all->item_id);
                if ($check_item) {
                    $data_item_all[] = $item_all->item_id;
                }
            }

            if (count($data_item_all) > 0) {
                foreach ($data_item_all as $value1) {
                    $data1 = $this->Item->get_info($value1);
                    $str_all .= $data1->name . ', ';
                }
                $meg1 = substr($str_all, 0, strlen($str_all) - 2);
                echo json_encode(array('success' => false, 'message' => 'Lỗi không thể xóa! Một số mặt hàng (' . $meg1 . ') đã phát sinh giao dịch'));
            } else {
                $this->Item->delete_list($get_all);
                echo json_encode(array('success' => true, 'message' => lang('items_successful_deleted') . ' ' . $total_rows . ' ' . lang('items_one_or_multiple')));
            }
        } else {
            $check_data = array();
            $str = "";
            foreach ($items_to_delete as $item) {
                $check_inventory = $this->Inventory->check_exists_item_in_inventory($item);
                if ($check_inventory) {
                    $check_data[] = $item;
                }
            }
            if (count($check_data) > 0) {
                foreach ($check_data as $value) {
                    $data = $this->Item->get_info($value);
                    $str .= $data->name . ', ';
                }
                $meg = substr($str, 0, strlen($str) - 2);
                echo json_encode(array('success' => false, 'message' => 'Lỗi không thể xóa! Một số mặt hàng (' . $meg . ') đã phát sinh giao dịch'));
            } else {
                $this->Item->delete_list($items_to_delete);
                echo json_encode(array('success' => true, 'message' => lang('items_successful_deleted') . ' ' . $total_rows . ' ' . lang('items_one_or_multiple')));
            }
        }
    }

    function excel() {
        $data = file_get_contents("import_items.xlsx");
        $name = 'import_items.xlsx';
        force_download($name, $data);
    }

    /* added for excel expert */
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
                for ($row = 3; $row <= $highestRow; ++$row) {
                    $array_info = array();
                    for ($col = 0; $col <= $highestColumnIndex; ++$col) {
                        $array_info[] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                    }
                    //Check du lieu
                    $name = $this->Item->get_info_name(trim($array_info[1]));
                    $category = $this->Category->exists_id_cat($array_info[3]);
                    if (trim($array_info[0]) == "") {
                        $failCodes[] = $row . ' - Chưa nhập mã mặt hàng';
                        continue;
                    }
                    if (trim($array_info[1]) == "") {
                        $failCodes[] = $row . ' - Chưa nhập tên mặt hàng';
                        continue;
                    }
                    if ($category == 0) {
                        $failCodes[] = $row . ' - Mã nhóm mặt hàng không đúng';
                        continue;
                    }
                    $unit = $this->Unit->check_exist_unit($array_info[4]);
                    if ($unit == 0) {
                        $failCodes[] = $row . ' - Mã đơn vị tính không đúng';
                        continue;
                    }
                    if ($array_info[8] != 0) {
                        $unit_from = $this->Unit->check_exist_unit($array_info[8]);
                        if ($unit_from == 0) {
                            $failCodes[] = $row . ' - Mã đơn vị tính sau quy đổi không đúng';
                            continue;
                        }
                    }
                    if ($array_info[12] != 0) {
                        $invetory = $this->Create_invetory->exists($array_info[12]);
                        if (!$invetory) {
                            $failCodes[] = $row . ' - Mã kho không đúng';
                            continue;
                        }
                    }
                    //Insert du lieu vao kho
                    $id_cat = $this->Category->get_id_cat($array_info[3]);
                    if ($array_info[12] == 0) { //Neu insert vao kho tong                        
                        $item_data = array(
                            'item_number' => trim($array_info[0]) != "" ? trim($array_info[0]) : NULL,
                            'name' => trim($array_info[1]),
                            'description' => $array_info[2] != "" ? $array_info[2] : "",
                            'category' => $id_cat,
                            'unit' => $array_info[4],
                            'quantity' => $array_info[8] != 0 ? ($array_info[5] * $array_info[9]) : $array_info[5],
                            'cost_price' => $array_info[6],
                            'unit_price' => $array_info[7],
                            'unit_from' => $array_info[8],
                            'unit_rate' => $array_info[9],
                            'cost_price_rate' => ($array_info[6] / $array_info[9]),
                            'unit_price_rate' => ($array_info[7] / $array_info[9]),
                            'reorder_level' => $array_info[11],
                            'quantity_total' => $array_info[8] != 0 ? ($array_info[5] * $array_info[9]) : $array_info[5],
                            'quantity_first' => $array_info[8] > 0 ? 1 : 0,
                            'taxes' => $array_info[10]
                        );

                        $item_number = $this->Item->get_info_item_number($array_info[0]);
                        if ($item_number > 0) {
                            $failCodes[] = $row . ' - Mã mặt hàng đã tồn tại';
                            continue;
                        }
                        if ($this->Item->save($item_data)) {
                            $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
                            $emp_info = $this->Employee->get_info($employee_id);
                            $excel_data = array(
                                'trans_items' => $item_data['item_id'],
                                'trans_user' => $employee_id,
                                'trans_comment' => 'XLS',
                                'trans_catid' => $array_info[3],
                                'trans_inventory' => $array_info[8] != 0 ? ($array_info[5] * $array_info[9]) : $array_info[5],
                                'trans_date' => date('Y-m-d H:i:s'),
                                'trans_money' => $array_info[8] != 0 ? ($array_info[6] / $array_info[9]) : $array_info[6],
                                'store_id' => $array_info[12]
                            );
                            $this->db->insert('inventory', $excel_data);
                        }
                    } else { //Khong phai kho tong
                        $item_data = array(
                            'item_number' => trim($array_info[0]) != "" ? trim($array_info[0]) : NULL,
                            'name' => trim($array_info[1]),
                            'description' => $array_info[2] != "" ? $array_info[2] : "",
                            'category' => $id_cat,
                            'unit' => $array_info[4],
                            'quantity' => $array_info[8] != 0 ? ($array_info[5] * $array_info[9]) : $array_info[5],
                            'cost_price' => $array_info[6],
                            'unit_price' => $array_info[7],
                            'unit_from' => $array_info[8],
                            'unit_rate' => $array_info[9],
                            'cost_price_rate' => ($array_info[6] / $array_info[9]),
                            'unit_price_rate' => ($array_info[7] / $array_info[9]),
                            'reorder_level' => $array_info[11],
                            'quantity_total' => 0,
                            'quantity_first' => $array_info[8] > 0 ? 1 : 0
                        );
                        //Check xem mat hang da ton tai kho tong chua
                        //neu chua ton tai o kho tong thi import vao kho tong sau do import vao kho can import
                        //Neu da ton tai thi bo qua va check xem da ton tai o kho can import ko
                        //neu da ton tai thi thong bao loi
                        //Chua ton tai thi import
                        $item_number = $this->Item->get_info_item_number(trim($array_info[0]));
                        if ($item_number == 0) {//Chua co trong kho tong                           
                            if ($this->Item->save($item_data)) {
                                $data_warehouse_item = array(
                                    'warehouse_id' => $array_info[12],
                                    'store_id' => 0,
                                    'item_id' => $item_data['item_id'],
                                    'quantity' => $array_info[8] != 0 ? ($array_info[5] * $array_info[9]) : $array_info[5],
                                    'stt' => 0,
                                    'date' => date('Y-m-d H:i:s')
                                );
                                $this->Item->warehouse_item($data_warehouse_item);
                                $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
                                $emp_info = $this->Employee->get_info($employee_id);
                                $excel_data = array(
                                    'trans_items' => $item_data['item_id'],
                                    'trans_user' => $employee_id,
                                    'trans_comment' => 'XLS',
                                    'trans_catid' => $array_info[3],
                                    'trans_inventory' => $array_info[8] != 0 ? ($array_info[5] * $array_info[9]) : $array_info[5],
                                    'trans_date' => date('Y-m-d H:i:s'),
                                    'trans_money' => $array_info[8] != 0 ? ($array_info[6] / $array_info[9]) : $array_info[6],
                                    'store_id' => $array_info[12]
                                );
                                $this->db->insert('inventory', $excel_data);
                            }
                        } else {//da ton tai trong kho tong
                            $info_item = $this->Item->get_item_id(trim($array_info[0]));
                            $check_item_warehouse_item = $this->Item->get_Stores_Items($info_item, $array_info[12]);
                            $get_info = $this->Item->get_info($info_item);
                            if ($check_item_warehouse_item) {
                                $failCodes[] = $row . ' - Mặt hàng đã tồn tại';
                                continue;
                            } else {
                                $item_data = array(
                                    'quantity' => $get_info->quantity + ($array_info[8] != 0 ? ($array_info[5] * $array_info[9]) : $array_info[5]),
                                );
                                $this->Item->save($item_data, $info_item);
                                $data_warehouse_item = array(
                                    'warehouse_id' => $array_info[12],
                                    'store_id' => 0,
                                    'item_id' => $info_item,
                                    'quantity' => $array_info[8] != 0 ? ($array_info[5] * $array_info[9]) : $array_info[5],
                                    'stt' => 0,
                                    'date' => date('Y-m-d H:i:s')
                                );
                                $this->Item->warehouse_item($data_warehouse_item);
                                $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
                                $emp_info = $this->Employee->get_info($employee_id);
                                $excel_data = array(
                                    'trans_items' => $info_item,
                                    'trans_user' => $employee_id,
                                    'trans_comment' => 'XLS',
                                    'trans_catid' => $array_info[3],
                                    'trans_inventory' => $array_info[8] != 0 ? ($array_info[5] * $array_info[9]) : $array_info[5],
                                    'trans_date' => date('Y-m-d H:i:s'),
                                    'trans_money' => $array_info[8] != 0 ? ($array_info[6] / $array_info[9]) : $array_info[6],
                                    'store_id' => $array_info[12]
                                );
                                $this->db->insert('inventory', $excel_data);
                            }
                        }
                    }
                }
            } else {
                echo json_encode(array('success' => false, 'message' => lang('common_upload_file_not_supported_format')));
                return;
            }
        }
        $success = true;
        if (count($failCodes) > 0) {
            $msg = lang('items_most_imported_some_failed') . "<br> (" . implode(", ", $failCodes) . ")";
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
                foreach (str_replace(",", "", $this->input->post("quantity")) as $quantity => $q) {
                    if ($store == $quantity) {
                        foreach (str_replace(",", "", $this->input->post("quantity_sale")) as $quantity_sale => $q_s) {
                            if ($quantity == $quantity_sale) {
                                foreach (str_replace(",", "", $this->input->post("quantity_verifying")) as $quantity_verifying => $q_v) {
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

                                                //hung audi 24-4-15 update qty
                                                $item = $this->Item->get_info($store);
                                                $item_warehouse = $this->Item->get_info_warehouse($store, $st);

                                                $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
                                                $cur_item_info = $this->Item->get_info($store);

                                                if ($st == 0) {//kho tong
                                                    $data_item = array(
                                                        'quantity_total' => $q_v,
                                                        'quantity' => $item->quantity - $item->quantity_total + $q_v,
                                                    );
                                                    $this->Item->update_item($data_item, $store);

                                                    //save inv
                                                    if ($q_v != $item->quantity_total) {
                                                        $qty = $q_v - $item->quantity_total;
                                                    }
                                                } else {//kho #
                                                    $data_item_warehouse = array(
                                                        'quantity' => $q_v,
                                                    );
                                                    $this->Item->update_item_warehouse($data_item_warehouse, $store, $st);

                                                    $data_item = array(
                                                        'quantity' => $item->quantity - $item_warehouse->quantity + $q_v,
                                                    );
                                                    $this->Item->update_item($data_item, $store, $st);

                                                    //save inv
                                                    if ($q_v != $item_warehouse->quantity) {
                                                        $qty = $q_v - $item_warehouse->quantity;
                                                    }
                                                }
                                                //bao cao ton kho
                                                $inv_data = array(
                                                    'trans_date' => date('Y-m-d H:i:s'),
                                                    'trans_items' => $store,
                                                    'trans_user' => $employee_id,
                                                    'trans_comment' => 'CHECK',
                                                    'trans_inventory' => $qty,
                                                    'trans_catid' => $cur_item_info->category,
                                                    'trans_money' => $cur_item_info->cost_price,
                                                    'trans_people' => 0,
                                                    'trans_recevings' => 0,
                                                    'store_id' => $st,
                                                );
                                                $this->Inventory->insert($inv_data);
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
        $data['id_store'] = $this->sale_lib->get_next_warehouse();
        $data['category'] = $this->Category->get_all();
        $data['id_cate'] = $this->sale_lib->get_cate();
        $this->load->view('items/next_inventory', $data);
    }

    public function save_next_inventory() {
        $store = $this->sale_lib->get_next_warehouse();
        $ids = $this->input->post('item_id');
        $quantity_inventorys = str_replace(",", "", $this->input->post('quantity_inventory'));
        $quantity_tranfs = str_replace(",", "", $this->input->post('quantity_next'));
        $inventory_id = $this->input->post('inven_transfer'); //kho nhan
        $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
        $item_info = $this->Item->get_info($id);
        $warehouse_items = array();
        foreach ($ids as $id2 => $id) {
            foreach ($quantity_tranfs as $quantity_tranf2 => $quantity_tranf) {
                if ($id2 == $quantity_tranf2) {
                    foreach ($quantity_inventorys as $quantity_inventory2 => $quantity_inventory) {
                        if ($quantity_tranf2 == $quantity_inventory2) {
                            $warehouse_items[] = array(
                                'item_id' => $id,
                                'quantity' => str_replace(array(',', '.00'), '', $quantity_tranf),
                                'quantity_inventory' => $quantity_inventory,
                            );
                        }
                    }
                }
            }
        }

        foreach ($warehouse_items as $key => $val) {
            //insert kho chuyển
            $inv_data = array(
                'trans_items' => $val['item_id'],
                'trans_user' => $employee_id,
                'trans_date' => date('Y-m-d H:i:s'),
                'trans_money' => 0,
                'trans_catid' => $item_info->category,
                'trans_comment' => 'TRANS',
                'trans_inventory' => - $val['quantity'],
                'store_id' => $store,
            );
            $this->Inventory->insert($inv_data);

            //insert kho nhan
            $inv_data1 = array(
                'trans_items' => $val['item_id'],
                'trans_user' => $employee_id,
                'trans_date' => date('Y-m-d H:i:s'),
                'trans_money' => 0,
                'trans_catid' => $item_info->category,
                'trans_comment' => 'TRANS',
                'trans_inventory' => $val['quantity'],
                'store_id' => $inventory_id,
            );
            $this->Inventory->insert($inv_data1);
            $stores_items_db = $this->Item->get_id_Items_warehouse($inventory_id, $val['item_id']); //warehouse_items
            if ($inventory_id != 0) {//kho nhan # kho tong
                if ($stores_items_db) { //mat hang da ton tai trong kho => cap nhat so luong                    
                    $quantity = $stores_items_db->quantity + $val['quantity']; //qty kho #
                    $warehouse = array(
                        'quantity' => $quantity,
                        'date' => date('Y-m-d H:i:s')
                    );
                } else { // mat hang chua co trong kho => them moi
                    $warehouse = array(
                        'warehouse_id' => $inventory_id,
                        'store_id' => $store,
                        'item_id' => $val['item_id'],
                        'quantity' => $val['quantity'],
                        'stt' => 0,
                        'date' => date('Y-m-d H:i:s')
                    );
                }
                $this->Item->saveWarehouseItems($warehouse, $stores_items_db->id);
            } else {//kho nhan la kho tong
                $stores_items_db_total = $this->Item->get_id_Items_warehouse_total($val['item_id']); //items
                $qty_total = array(
                    'quantity_total' => $stores_items_db_total->quantity_total + $val['quantity']
                );
                $this->Item->saveWarehouseItems_total($qty_total, $stores_items_db_total->item_id); //save kho tong (.) items
            }

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
        $this->delete_all_store();
    }

    //huy session trong chuyển kho dunbv
    public function delete_all_store() {
        $this->sale_lib->clear_next_warehouse();
        $this->sale_lib->clear_cate();
        redirect('items/next_inventory');
    }

    public function item_search_new() {
        $store = $this->sale_lib->get_next_warehouse();
        $cate = $this->sale_lib->get_cate();
        if ($store != 0) {
            $suggestions = $this->Item->get_item_search_suggestions_new_and_store($this->input->get('term'), $store, $cate, 100);
            echo json_encode($suggestions);
        } else {
            $suggestions = $this->Item->get_item_search_suggestions_new($this->input->get('term'), $cate, 100);
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

    //By Loi 27-5-15
    public function history_warehouse() {
        $config['base_url'] = site_url('items/sorting_warehouse');
        $config['total_rows'] = $this->Item->count_all_verifying();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $data['per_page'] = $config['per_page'];
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['per_page'] = $config['per_page'];
        $data['total_rows'] = $this->Item->count_all_verifying();
        $data['manage_table'] = get_verifying_manage_table($this->Item->get_verifying($data['per_page']), $this);
        $this->load->view('items/history_warehouse', $data);
    }

    function sorting_warehouse() {
        $start_date1 = $this->input->post('start_date');
        $end_date1 = $this->input->post('end_date');
        $tam = $end_date1;
        $tam .='23:59:59';
        $start_date = date('Y-m-d H:i:s', strtotime($start_date1));
        $end_date = date('Y-m-d H:i:s', strtotime($tam));
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($start_date1 && $end_date1) {
            $config['total_rows'] = $this->Item->count_all_verifying_by_date($start_date, $end_date);
            $table_data = $this->Item->get_verifying_by_date($start_date, $end_date, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        } else {
            $config['total_rows'] = $this->Item->count_all_verifying();
            $table_data = $this->Item->get_verifying($per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        }
        $config['base_url'] = site_url('items/sorting_warehouse');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_verifying_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function get_verifying_by_date() {
        $start_date1 = $this->input->post('start_date');
        $end_date1 = $this->input->post('end_date');
        $tam = $end_date1;
        $tam .='23:59:59';
        $start_date = date('Y-m-d H:i:s', strtotime($start_date1));
        $end_date = date('Y-m-d H:i:s', strtotime($tam));
        $config['base_url'] = site_url('items/sorting_warehouse');
        $config['total_rows'] = $this->Item->count_all_verifying_by_date($start_date, $end_date);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $data['per_page'] = $config['per_page'];
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['per_page'] = $config['per_page'];
        $data['total_rows'] = $this->Item->count_all_verifying_by_date($start_date, $end_date);
        $data['manage_table'] = get_verifying_manage_table($this->Item->get_verifying_by_date($start_date, $end_date, $data['per_page']), $this);
        $data['start_date1'] = $start_date1;
        $data['end_date1'] = $end_date1;
        $this->load->view('items/history_warehouse', $data);
    }

    //    11/7/2015
    function item_search_item() {
        $store = $this->receiving_lib->get_inventory();
        $cate = $this->receiving_lib->get_cate();
        $suggestions = $this->Item->get_item_search_export_store_by_store_cate($this->input->get('term'), $store, $cate);
        echo json_encode($suggestions);
    }

//   end Loi
    //dungbv
    function set_stores() {
       $this->sale_lib->set_stores($this->input->post('stores'));
    }

    function set_cate() {
       $this->sale_lib->set_cate($this->input->post('categorysearch'));
    }

    function excel_export($template = 0) {
        $stores = $this->sale_lib->get_stores();
        $cate = $this->sale_lib->get_cate();
        $items = $this->Item->get_item_by_store_and_cat($stores, $cate);
        require_once APPPATH . "/third_party/Classes/export_items.php";
    }

    public function check_position($item_id) {
        $position_1 = $this->input->post('top');
        if ($item_id) {
            $check = $this->Item->check_items_top($position_1, $item_id);
        } else {
            $check = $this->Item->check_items_top($position_1);
        }
        if ($check > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

}

?>