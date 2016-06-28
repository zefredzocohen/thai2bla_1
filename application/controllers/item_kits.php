<?php

require_once(APPPATH . 'third_party/Classes/PHPExcel/IOFactory.php');
require_once(APPPATH . 'libraries/php-excel.class.php');
require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");

class Item_kits extends Secure_area implements iData_controller {

    function __construct() {
        parent::__construct('item_kits');
        $this->load->library('receiving_lib');
    }

    function index() {
        $this->check_action_permission('search');
        $config['base_url'] = site_url('item_kits/sorting');
        $config['total_rows'] = $this->Item_kit->count_all();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_item_kits_manage_table($this->Item_kit->get_all($data['per_page']), $this);
        $data['categories'] = $this->Category->get_all();
        $this->load->view('item_kits/manage', $data);
    }

    //check trùng tên
    function checkname($id) {
        $name = $this->input->post('name');
        $d['name'] = $this->Item_kit->getname($id);
        foreach ($d['name'] as $d2) {
            $d3[] = $d2['name'];
        }
        $c2 = $d3;
        $e1 = implode(',', $c2);
        $e2 = explode(',', $e1);

        if (in_array($name, $e2)) {
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
            $config['total_rows'] = $this->Item_kit->search_count_all($search);
            $table_data = $this->Item_kit->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        } else {
            $config['total_rows'] = $this->Item_kit->count_all();
            $table_data = $this->Item_kit->get_all($per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'item_kit_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        }
        $config['base_url'] = site_url('item_kits/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_Item_kits_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    /* added for excel expert */

    function excel_export() {
        $category_item_kits = $this->Category->get_all();
        $data = $this->Item_kit->get_all()->result_object();
        require_once APPPATH . "/third_party/Classes/export_item_kit.php";
    }

    function search() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $cat = $this->input->post('cat');
        $status = $this->input->post('status');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Item_kit->search(
                $search, $cat, $status, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'item_kit_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
        );
        $config['base_url'] = site_url('item_kits/search');
        $config['total_rows'] = $this->Item_kit->search_count_all($search, $cat, $status);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_Item_kits_manage_table_data_rows($search_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    /*
      Gives search suggestions based on what is being searched for
     */

    function suggest() {
        $suggestions = $this->Item_kit->get_search_suggestions($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    function get_row() {
        $item_kit_id = $this->input->post('row_id');
        $data_row = get_item_kit_data_row($this->Item_kit->get_info($item_kit_id), $this);
        echo $data_row;
    }

    function view($item_kit_id = -1) {
        $this->check_action_permission('add_update');
        $data['unit'] = $this->Unit->get_all();
        $data['item_kit_info'] = $this->Item_kit->get_info($item_kit_id);
        $data['processes_item_kit'] = $this->Item_kit->get_info_processes_item_kit($item_kit_id);
        $data['category_processes'] = $this->M_category_processes->get_list_all_cat_pro();
        $this->load->view("item_kits/form", $data);
    }

    function save($item_kit_id = -1) {
        $this->check_action_permission('add_update');
        /* phan them anh */
        $config = array(
            "upload_path" => "./item_kit/",
            "allowed_types" => 'gif|jpg|png|bmp|jpeg',
            'max_size' => '6000'
        );
        $this->load->library('upload', $config);
        $images = '';
        if (!$this->upload->do_upload('item_kit_image')) {
            $erros = array($this->upload->display_errors());
            $item_kit_data = array(
                'item_kit_number' => $this->input->post('item_kit_number'),
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'unit' => $this->input->post('unit'),
                'category' => $this->input->post('category'),
                'unit_price' => 0,
                'status' => 1, //đang TK mẫu
            );
        } else {
            if ($item_kit_id != -1) {
                $delimg = $this->Item_kit->get_info($item_kit_id);
                unlink("./item_kit/" . $delimg->images);
            }
            $images = $this->upload->data();
            $config = array("source_image" => $images['full_path'],
                "maintain_ration" => true,
                "width" => '157',
                "height" => "125");
            $this->load->library("image_lib", $config);
            $this->image_lib->resize();
            if ($images != "") {
                $img = $images['file_name'];
            }
            $item_kit_data = array(
                'item_kit_number' => $this->input->post('item_kit_number'),
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'unit' => $this->input->post('unit'),
                'category' => $this->input->post('category'),
                'unit_price' => 0,
                'images' => $img,
                'status' => 1, //đang TK mẫu
            );
        }
        /* end phan them anh */
        if ($this->Item_kit->save($item_kit_data, $item_kit_id)) {

            /* ~~~~ Hưng Audi 8-9-15 >>>> See U Again */
            //save processes_item_kit
            $processes_ik_data = array();
            foreach ($this->input->post(id_processes) as $s5 => $id_processes) {//samsung galaxy s5
                foreach ($this->input->post(date_finish) as $s6 => $date_finish) {//samsung galaxy s6
                    if ($s5 == $s6) {
                        $processes_ik_data[] = array(
                            item_kit_id => $item_kit_data['item_kit_id'],
                            id_processes => $id_processes,
                            date_finish => date('Y-m-d', strtotime($date_finish))
                        );
                    }
                }
            }
            $this->Item_kit->save_processes_item_kit($processes_ik_data, $item_kit_id);
            //end H.A
            //New item kit
            if ($item_kit_id == -1) {
                echo json_encode(array('success' => true, 'message' => lang('item_kits_successful_adding') . ' ' .
                    $item_kit_data['name'], 'item_kit_id' => $item_kit_data['item_kit_id']));
                $item_kit_id = $item_kit_data['item_kit_id'];
            } else { //previous item
                echo json_encode(array('success' => true, 'message' => lang('item_kits_successful_updating') . ' ' .
                    $item_kit_data['name'], 'item_kit_id' => $item_kit_id));
            }
        } else {//failure			
            echo json_encode(array('success' => false, 'message' => lang('item_kits_error_adding_updating') . ' ' .
                $item_kit_data['name'], 'item_kit_id' => -1));
        }
    }

    function delete() {
        $this->check_action_permission('delete');
        $item_kits_to_delete = $this->input->post('ids');

        if ($this->Item_kit->delete_list($item_kits_to_delete)) {
            echo json_encode(array('success' => true, 'message' => lang('item_kits_successful_deleted') . ' ' .
                count($item_kits_to_delete) . ' ' . lang('item_kits_one_or_multiple')));
        } else {
            echo json_encode(array('success' => false, 'message' => lang('item_kits_cannot_be_deleted')));
        }
    }

    function generate_barcodes($item_kit_ids) {
        $result = array();

        $item_kit_ids = explode('~', $item_kit_ids);
        foreach ($item_kit_ids as $item_kid_id) {
            $item_kit_info = $this->Item_kit->get_info($item_kid_id);

            $result[] = array('name' => $item_kit_info->name . ': ' . to_currency($item_kit_info->unit_price), 'id' => 'KIT ' . number_pad($item_kid_id, 7));
        }

        $data['items'] = $result;
        $data['scale'] = 2;
        $this->load->view("barcode_sheet", $data);
    }

    function generate_barcode_labels($item_kit_ids) {
        $result = array();

        $item_kit_ids = explode('~', $item_kit_ids);
        foreach ($item_kit_ids as $item_kid_id) {
            $item_kit_info = $this->Item_kit->get_info($item_kid_id);

            $result[] = array('name' => $item_kit_info->name . ': ' . to_currency_format($item_kit_info->unit_price), 'id' => 'KIT ' . number_pad($item_kid_id, 7));
        }

        $data['items'] = $result;
        $data['scale'] = 1;
        $this->load->view("barcode_labels", $data);
    }

    /*
      get the width for the add/edit form
     */

    function get_form_width() {
        return 770;
    }

    //Create by San 5/3/2015   
    //check mã sản phẩm
    function checkItemKitNumber($id) {
        $item_kit_number = $this->input->post('item_kit_number');
        $d['item_kit_number'] = $this->Item_kit->getItemKitNumber($id);
        foreach ($d['item_kit_number'] as $d2) {
            $d3[] = $d2['item_kit_number'];
        }
        $c2 = $d3;
        $e1 = implode(',', $c2);
        $e2 = explode(',', $e1);
        $check_item_number = $this->Item->account_number_exists($this->input->post('item_kit_number'));
        if (in_array($item_kit_number, $e2) || $check_item_number) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    function save_estimate($item_kit_id = -1) {
        $this->check_action_permission('add_update');
        if ($this->input->post('price')) {
            $item_kit_items = array();
            foreach ($this->input->post('price') as $item_id => $price) {
                foreach ($this->input->post("item_kit_item") as $key => $a) {
                    if ($item_id == $key) {
                        foreach ($this->input->post("product_as_item") as $product_as_item => $p) {
                            if ($key == $product_as_item) {
                                foreach ($this->input->post("quantity_inventory") as $quantity_inventory => $q_i) {
                                    if ($product_as_item == $quantity_inventory) {
                                        foreach ($this->input->post('cost') as $cost => $c) {
                                            if ($product_as_item == $cost) {
                                                foreach ($this->input->post("quantity_loss") as $quantity_loss => $q_l) {
                                                    if ($cost == $quantity_loss) {
                                                        foreach ($this->input->post('quantity_now') as $quantity_now => $q_n) {
                                                            if ($quantity_loss == $quantity_now) {
                                                                $item_kit_items[] = array(
                                                                    'item_id' => $item_id,
                                                                    'quantity_begin' => $q_n,
                                                                    'quantity' => $a,
                                                                    'quantity_loss' => $q_l,
                                                                    'cost' => str_replace(",", "", $c),
                                                                    'price' => str_replace(",", "", $price),
                                                                    'product_as_item' => $p,
                                                                    'quantity_inventory' => $q_i
                                                                );
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
                    }
                }
            }
            if ($this->Item_kit_items->save($item_kit_items, $item_kit_id)) {
                if ($item_kit_id == -1) {
                    echo json_encode(array('success' => true, 'message' => 'Tạo mới dự tính sản xuất thành công'));
                } else { //previous item
                    echo json_encode(array('success' => true, 'message' => 'Cập nhật thành công'));
                }
                $data_item_kit = array(
                    'quantity_max' => $this->input->post('total_product'),
                    'unit_price' => str_replace(",", "", $this->input->post('price_item_kit')),
                    'cost_labor' => str_replace(",", "", $this->input->post('cost_labor')),
                    'cost_other' => str_replace(",", "", $this->input->post('cost_other')),
                    'cost_item_kit' => str_replace(",", "", $this->input->post('cost_price')),
                );
                $this->Item_kit->save($data_item_kit, $item_kit_id);
            } else {
                echo json_encode(array('success' => false, 'message' => 'Lỗi! Không thành công'));
            }
        }
    }

    function check_number_production($number_max) {
        $number_regex = '/[1-9]+/';
        $number_product = $this->input->post('number_product');
        if (!preg_match($number_regex, $number_product)) {
            echo json_encode(false);
        } else if ($number_product > $number_max) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    function get_row_item_production() {
        $id = $this->input->post('row_id');
        $data_row = get_follow_bom_data_row($this->Item_kit->get_info_item_production($id), $this);
        echo $data_row;
    }
    function view_order_production($id) {
        $data['id_production'] = $id;
        $this->load->view("item_kits/order_production", $data);
    }

    function view_order_warehouse_item($id) {
        $data['request_id'] = $id;
        $this->load->view("item_kits/order_warehouse_item", $data);
    }

    function update_item_kit($item_kit_id) {
        $this->check_action_permission('add_update');
        $item_number = $this->input->post("item_number");
        $info_item = $this->Item->get_info_item_by_item_number($item_number);
        $data_update_item_kit = array(
            'unit' => $this->input->post('unit'),
            'category' => $this->input->post('category'),
            'description' => $this->input->post('description')
        );
        if ($this->Item_kit->save_product($data_update_item_kit, $item_kit_id)) {
            foreach ($info_item as $ii){
                $data_update_items = array(
                    'unit' => $this->input->post('unit'),
                    'category' => $this->input->post('category'),
                    'description' => $this->input->post('description')
                );
                $this->Item->save($data_update_items, $ii['item_id']);
            }
            /* ~~~~ Hưng Audi 8-9-15 >>>> */
            //save processes_item_kit
            $processes_ik_data = array();
            foreach ($this->input->post(id_processes) as $s5 => $id_processes) {//samsung galaxy s5
                foreach ($this->input->post(date_finish) as $s6 => $date_finish) {//samsung galaxy s6
                    if ($s5 == $s6) {
                        $processes_ik_data[] = array(
                            item_kit_id => $item_kit_id,
                            id_processes => $id_processes,
                            date_finish => date('Y-m-d', strtotime($date_finish))
                        );

                        //save processes_design_template
                        $info_design_template = $this->Item_kit->get_info_design_template_by_item_kit_id($item_kit_id);
                        foreach ($info_design_template as $design_template) {
                            $info_processes_design_template = $this->Item_kit->get_processes_design_template_audi($item_kit_id, $design_template->id_design_template, $id_processes);
                            $processes_dt_data[] = array(
                                item_kit_id => $item_kit_id,
                                id_design_template => $design_template->id_design_template,
                                id_processes => $id_processes,
                                status => $info_processes_design_template->status == 1 ? 1 : 0,
                                date_confirm => $info_processes_design_template->date_confirm ? $info_processes_design_template->date_confirm : '0000-00-00'
                            );
                        }
                    }
                }
            }
            $this->Item_kit->save_processes_design_template_audi($processes_dt_data, $item_kit_id);
            $this->Item_kit->save_processes_item_kit($processes_ik_data, $item_kit_id);
            
            //save inventory
            foreach ($info_item as $ii){
                $inv_data = array(
                    'trans_catid' => $this->input->post('category'),
                );
                $this->Inventory->update_by_item($inv_data, $ii['item_id']);
            }
            //end H.A

            echo json_encode(array('success' => true, 'message' => 'Cập nhật thành công'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Lỗi! Cập nhật thất bại'));
        }
    }

    //Nhap hang NVL
    function trading($item_ids) {
        $item_ids = explode('~', $item_ids);
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
        redirect('receivings');
    }

    function checkQuantityPerfect($quantity_request, $quantity_production) {
        $quantity_perfect = (int) $this->input->post('quantity_perfect');
        if ($quantity_perfect > ($quantity_request - $quantity_production)) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    function checkQuantityKcs() {
        $number_regex = '/[0-9]+/';
        $quantity_perfect = (int) $this->input->post('quantity_perfect');
        $quantity_kcs = (int) $this->input->post('quantity_kcs');
        if (!preg_match($number_regex, $quantity_kcs)) {
            echo json_encode(false);
        } elseif ($quantity_kcs > $quantity_perfect) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    function checkQuantityKcsErr() {
        $number_regex = '/[0-9]+/';
        $quantity_perfect = $this->input->post('quantity_perfect');
        $quantity_kcs = $this->input->post('quantity_kcs');
        $quantity_kcs_error = $this->input->post('quantity_kcs_error');
        if (!preg_match($number_regex, $quantity_kcs_error)) {
            echo json_encode(false);
        } elseif ($quantity_kcs_error != ($quantity_perfect - $quantity_kcs)) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    function check_date_begin() {
        $date_begin = strtotime($this->input->post("begin1"));
        $date_end = strtotime($this->input->post("end1"));
        if ($date_begin > $date_end) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    function check_date_end() {
        $date_begin = strtotime($this->input->post("begin2"));
        $date_end = strtotime($this->input->post("end2"));
        if ($date_begin > $date_end) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    //design_template
    function design_template_item_kits($item_kit_id) {
        $this->receiving_lib->add_item_kits($item_kit_id);
        redirect('item_kits/design_template');
    }

    function design_template() {
        $item_kit_id = $this->receiving_lib->get_item_kits();
        $config['base_url'] = site_url("item_kits/sorting_design_template");
        $config['total_rows'] = $this->Item_kit->count_all_design_template($item_kit_id);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_design_template_manage_table($this->Item_kit->get_all_design_template($item_kit_id, $data['per_page']), $this);
        $data['info_item_kit'] = $this->Item_kit->get_info($item_kit_id);
        $this->load->view('item_kits/design_template', $data);
    }

    function sorting_design_template() {
        $item_kit_id = $this->receiving_lib->get_item_kits();
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search) {
            $config['total_rows'] = $this->Item_kit->search_count_all_design_template($item_kit_id, $search); //search_count_all
            $table_data = $this->Item_kit->search_design_template($item_kit_id, $search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id_design_template', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
            );
        } else {
            $config['total_rows'] = $this->Item_kit->count_all_design_template($item_kit_id); //count_all
            $table_data = $this->Item_kit->get_all_design_template($item_kit_id, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id_design_template', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        }//get_all
        $config['base_url'] = site_url("item_kits/sorting_design_template");
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);

        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_design_template_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function suggest_design_template() {
        $item_kit_id = $this->receiving_lib->get_item_kits();
        $suggestions = $this->Item_kit->get_search_suggestions_design_template($item_kit_id, $this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    function search_design_template() {
        $item_kit_id = $this->receiving_lib->get_item_kits();
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Item_kit->search_design_template($item_kit_id, $search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id_design_template', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
        );
        $config['base_url'] = site_url('item_kits/search_design_template/' . $item_kit_id);
        $config['total_rows'] = $this->Item_kit->search_count_all_design_template($item_kit_id, $search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_design_template_manage_table_data_rows($search_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function delete_design_template() {
        $id_design_templates = $this->input->post('ids');
        if ($this->Item_kit->delete_list_design_template($id_design_templates)) {
            $this->Item_kit->delete_list_estimate($id_design_templates);
            echo json_encode(array(
                'success' => true,
                'message' => lang('item_kits_successful_deleted') . ' ' . count($id_design_templates) . ' mẫu thiết kế, <br> đồng thời mẫu sản xuất tương ứng cũng sẽ bị xóa !',
            ));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Không thể xóa mẫu thiết kế này !'));
        }
    }

    function view_design_template($id_design_template = -1) {
        $data['item_kit_id'] = $this->receiving_lib->get_item_kits();
        $data['design_template'] = $this->Item_kit->get_info_design_template($id_design_template);
        $this->load->view("item_kits/form_design_template", $data);
    }

    function save_design_template($id_design_template = -1) {
        $this->check_action_permission('add_update');
        $config = array(
            "upload_path" => "./item_kit/design_template/",
            'allowed_types' => 'gif|jpg|png',
        );
        $this->load->library('upload', $config);
        if ($this->upload->do_upload("image_design_template")) {
            if ($id_design_template != -1) {
                $delimg = $this->Item_kit->get_info_design_template($id_design_template);
                unlink("./item_kit/design_template/" . $delimg->image_design_template);
            }
            $images = $this->upload->data();
            $config1 = array(
                "source_image" => $images['full_path'],
                "maintain_ration" => true,
                "width" => '157',
                "height" => "125");
            $this->load->library("image_lib", $config1);
            $this->image_lib->resize();
            $img = $images['file_name'];
            $design_template = array(
                "item_kit_id" => $this->input->post("item_kit_id"),
                "code_design_template" => $this->input->post('code_design_template'),
                "image_design_template" => $img,
                "date_create" => date("Y-m-d H:i:s"),
                "description" => $this->input->post("description_design_template"),
                "person_id" => $this->session->userdata("person_id"),
                "status" => 0
            );
        } else {
            $design_template = array(
                "item_kit_id" => $this->input->post("item_kit_id"),
                "code_design_template" => $this->input->post('code_design_template'),
                "description" => $this->input->post("description_design_template"),
            );
        }
        //28-8
        $data_item_kit = array(
            "status" => 2, //đang sx mẫu
        );
        $this->Item_kit->save($data_item_kit, $this->input->post("item_kit_id"));

        if ($this->Item_kit->save_design_template($design_template, $id_design_template)) {

            /* ~~~~ Hưng Audi 9-9-15 >>>> */
            //save processes_design_template
            if ($id_design_template == -1) {
                $processes_item_kit = $this->Item_kit->get_info_processes_item_kit($this->input->post("item_kit_id"));

                foreach ($processes_item_kit->result() as $pig) {//pig: con nhợn (o_o)
                    $processes_dt_data[] = array(
                        item_kit_id => $this->input->post("item_kit_id"),
                        id_design_template => $id_design_template == -1 ? $design_template['id_design_template'] : $id_design_template,
                        id_processes => $pig->id_processes,
                        status => 0
                    );
                }
                $this->Item_kit->save_processes_design_template($processes_dt_data, $id_design_template);
            }
            /* end H.A */

            if ($id_design_template == -1) {
                echo json_encode(array("success" => true, "message" => lang("insert_success_design_template")));
            } else {
                echo json_encode(array("success" => true, "message" => lang("update_success_design_template")));
            }
        } else {
            echo json_encode(array("success" => false, "message" => lang("insert_update_failed_design_template")));
        }
    }

    function check_code_design_template($id_design_template) {
        $code_design_template = $this->input->post("code_design_template");
        $check = $this->Item_kit->check_code_design_template($id_design_template, $code_design_template);
        if ($check) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    function feedback_design_template($id_design_template) {
        $data['info_design_template'] = $this->Item_kit->get_info_design_template($id_design_template);
        $this->load->view("item_kits/form_feedback_design_template", $data);
    }

    function save_feedback_design_template($id_design_template) {
        $status = $this->input->post("status");
        $command = $this->input->post("command");
        $data_design_template = array(
            "status" => $status,
            "command" => $command
        );
        if ($this->Item_kit->save_design_template($data_design_template, $id_design_template)) {
            echo json_encode(array("success" => TRUE, "message" => lang("item_kits_perform_successfull")));
        } else {
            echo json_encode(array("success" => FALSE, "message" => lang("item_kits_perform_error")));
        }
    }

    //end design_template
    //production_flow_template
    function switch_production_flow_template($id_design_template) {
        $this->receiving_lib->add_design_template($id_design_template);
        redirect('item_kits/production_flow_template');
    }

    function production_flow_template() {
        $id_design_template = $this->receiving_lib->get_design_template();
        $config['base_url'] = site_url("item_kits/sorting_production_flow_template");
        $config['total_rows'] = $this->Item_kit->count_all_production_flow_template($id_design_template);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_production_flow_template_manage_table($this->Item_kit->get_all_production_flow_template($id_design_template, $data['per_page']), $this);
        $data['info_design_template'] = $this->Item_kit->get_info_design_template($id_design_template);
        $data['info_item_kit'] = $this->Item_kit->get_info($data['info_design_template']->item_kit_id);
        $this->load->view('item_kits/production_flow_template', $data);
    }

    function sorting_production_flow_template() {
        $id_design_template = $this->receiving_lib->get_design_template();
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search) {
            $config['total_rows'] = $this->Item_kit->search_count_all_production_flow_template($id_design_template, $search); //search_count_all
            $table_data = $this->Item_kit->search_production_flow_template($id_design_template, $search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'production_order', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc'
            );
        } else {
            $config['total_rows'] = $this->Item_kit->count_all_production_flow_template($id_design_template); //count_all
            $table_data = $this->Item_kit->get_all_production_flow_template($id_design_template, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'production_order', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        }//get_all
        $config['base_url'] = site_url("item_kits/sorting_production_flow_template");
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);

        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_production_flow_template_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function suggest_production_flow_template() {
        $id_design_template = $this->receiving_lib->get_design_template();
        $suggestions = $this->Item_kit->get_search_suggestions_production_flow_template($id_design_template, $this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    function search_production_flow_template() {
        $id_design_template = $this->receiving_lib->get_design_template();
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Item_kit->search_production_flow_template($id_design_template, $search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'production_order', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc'
        );
        $config['base_url'] = site_url('item_kits/search_production_flow_template/' . $id_design_template);
        $config['total_rows'] = $this->Item_kit->search_count_all_production_flow_template($id_design_template, $search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_production_flow_template_manage_table_data_rows($search_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function view_production_flow_template($id = -1) {
        $data['id_design_template'] = $this->receiving_lib->get_design_template();
        $data['info_production_flow_template'] = $this->Item_kit->get_info_production_flow_template($id);
        $data['processes'] = $this->Item_kit->get_list_processes();
        $this->load->view("item_kits/form_production_flow_template", $data);
    }

    function save_production_flow_template($id = -1) {
        $id_design_template = $this->input->post("id_design_template");
        $id_processes = $this->input->post("processes");
        $time_processes = $this->input->post("time_processes");
        $unit_time = $this->input->post("unit_time");
        $production_order = $this->input->post("production_order");
        $all_production_flow_template = $this->Item_kit->count_all_production_flow_template($id_design_template);
        $data_production_flow_template = array(
            "id_design_template" => $id_design_template,
            "id_processes" => $id_processes,
            "time_processes" => $time_processes,
            "unit_time" => $unit_time,
            "production_order" => $all_production_flow_template + 1,
            "status" => 0
        );

        $data_production_flow_template_update = array(
            "id_processes" => $id_processes,
            "time_processes" => $time_processes,
            "unit_time" => $unit_time,
            "production_order" => $production_order
        );
        if ($id == -1) {
            if ($this->Item_kit->save_production_flow_template($data_production_flow_template, $id)) {
                echo json_encode(array("success" => TRUE, "message" => lang("item_kits_add_production_flow_successfully")));
            } else {
                echo json_encode(array("success" => FALSE, "message" => lang("item_kits_production_flow_failed")));
            }
        } else {
            $info = $this->Item_kit->get_info_production_flow_template_by_order($id_design_template, $production_order); //Thong tin cdsx co thu tu nhap tu o textbox
            $info1 = $this->Item_kit->get_info_production_flow_template($id); //Thong tin cdsx can sua
            $order_info1 = $info1->production_order;
            $data = array(
                "production_order" => $order_info1
            );
            if ($this->Item_kit->save_production_flow_template($data_production_flow_template_update, $id)) {
                $this->Item_kit->save_production_flow_template($data, $info['id_production_flow_template']);
                echo json_encode(array("success" => TRUE, "message" => lang("item_kits_update_production_flow_successfully")));
            } else {
                echo json_encode(array("success" => FALSE, "message" => lang("item_kits_production_flow_failed")));
            }
        }
    }

    //end production_flow_template
    //begin processes
    function processes() {
        $config['base_url'] = site_url("item_kits/sorting_processes");
        $config['total_rows'] = $this->Item_kit->count_all_processes();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_processes_manage_table($this->Item_kit->get_all_processes($data['per_page']), $this);
        $data['category_processes'] = $this->M_category_processes->get_list_all_cat_pro();
        $this->load->view('item_kits/processes_manage', $data);
    }

    function sorting_processes() {
        $cat_pro = $this->input->post("cat_pro");
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search || $cat_pro) {
            $config['total_rows'] = $this->Item_kit->search_count_all_processes($search, $cat_pro); //search_count_all
            $table_data = $this->Item_kit->search_processes($search, $cat_pro, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id_processes', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
            );
        } else {
            $config['total_rows'] = $this->Item_kit->count_all_processes(); //count_all
            $table_data = $this->Item_kit->get_all_processes($per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id_processes', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        }//get_all
        $config['base_url'] = site_url("item_kits/sorting_processes");
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);

        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_processes_manage_table_data_rows($table_data, $this);


        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function search_processes() {
        $cat_pro = $this->input->post("cat_pro");
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Item_kit->search_processes($search, $cat_pro, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id_processes', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
        );
        $config['base_url'] = site_url('item_kits/search_processes');
        $config['total_rows'] = $this->Item_kit->search_count_all_processes($search, $cat_pro);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_processes_manage_table_data_rows($search_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function suggest_processes() {
        $suggestions = $this->Item_kit->get_search_suggestions_processes($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    function view_processes($id_processes = -1) {
        $data['info_processes'] = $this->Item_kit->get_info_processes($id_processes);
        $data['category_processes'] = $this->M_category_processes->get_list_all_cat_pro();
        $this->load->view("item_kits/form_processes", $data);
    }

    function save_processes($id_processes = -1) {
        $data_processes = array(
            "name_processes" => $this->input->post("name_processes"),
            "cat_pro_id" => $this->input->post("cat_pro_id")
        );
        if ($this->Item_kit->save_processes($data_processes, $id_processes)) {
            if ($id_processes == -1) {
                echo json_encode(array("success" => TRUE, "message" => lang("item_kits_add_processes_successfull")));
            } else {
                echo json_encode(array("success" => TRUE, "message" => lang("item_kits_update_processes_successfull")));
            }
        } else {
            echo json_encode(array("success" => FALSE, "message" => lang("item_kits_add_update_processes_failed")));
        }
    }

    function delete_process() {
        $process_delete = $this->input->post('ids');
        if ($this->Item_kit->delete_processes($process_delete)) {
            echo json_encode(array('success' => true, 'message' => lang('item_kits_successful_deleted') . ' ' .
                count($process_delete) . ' ' . 'công đoạn'));
        } else {
            echo json_encode(array('success' => false, 'message' => lang('item_kits_cannot_be_deleted')));
        }
    }

    //end processes
    //request_production_template
    function request_production_template($id_design_template) {
        $data['info_design_template'] = $this->Item_kit->get_info_design_template($id_design_template);
        $data['info_formula_material'] = $this->Item_kit->get_info_formula_materials($id_design_template);
        $data['request_production_template'] = $this->Item_kit->get_info_request_production_template_feature($id_design_template);
        $item_kit_feature = array('' => 'Chọn kiểu sản phẩm');
        foreach ($this->Item_kit->get_all_item_kit_feature($id_design_template)->result() as $row) {
            $item_kit_feature[$row->feature_id] = $row->name_feature;
        }
        $data['item_kit_feature'] = $item_kit_feature;
        $data['name_feature'] = $this->Item_kit->get_info_item_kit_feature($data['request_production_template']->feature_id)->name_feature;
        $this->load->view("item_kits/request_production_template", $data);
    }

    function check_number_request() {
        $quantity_request = $this->input->post("quantity_request");
        if ((float) $quantity_request <= 0) {
            echo "false";
        } else {
            echo "true";
        }
    }

    function save_request_production_template($id_design_template) {
        $info_design_template = $this->Item_kit->get_info_design_template($id_design_template);
        $request_production_template = $this->Item_kit->get_info_request_production_template($id_design_template);
        $data = array(
            "id_design_template" => $id_design_template,
            'feature_id' => $this->input->post("item_kit_feature"),
            "quantity_request" => $this->input->post("quantity_request")
        );
        if ($this->Item_kit->save_request_production_template($data, $id_design_template)) {
            if (!$request_production_template->feature_id) {
                echo json_encode(array("success" => TRUE, "message" => "Tạo yêu cầu sản xuất thành công mẫu (" . $info_design_template->code_design_template . ")"));
            } else {
                echo json_encode(array("success" => TRUE, "message" => "Cập nhật yêu cầu sản xuất thành công mẫu (" . $info_design_template->code_design_template . ")"));
            }
        } else {
            echo json_encode(array("success" => FALSE, "message" => "Lỗi! Vui lòng kiểm tra lại"));
        }
    }

    function update_request_production_template() {
        $data = array(
            "number_request" => str_replace(",", "", $this->input->post("number_request")),
            "date" => date("Y-m-d H:i:s")
        );
        if ($this->Item_kit->update_request_production_template($data, $this->input->post("id_request"))) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    function delete_request_production_template() {
        $id_request = $this->input->post("id");
        if ($this->Item_kit->delete_request_production_template($id_request)) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    //end request_production_template
    //hung audi 9-3 follow_bom
    function switch_item_kits($item_kit_id) {
        $this->check_action_permission('manage_production');
        $this->receiving_lib->add_item_kits($item_kit_id);
        redirect('item_kits/follow_bom');
    }

    function follow_bom() {
        $item_kit_id = $this->receiving_lib->get_item_kits();
        $this->check_action_permission('search');

        $config['base_url'] = site_url("item_kits/sorting_follow_bom");
        $config['total_rows'] = $this->Item_kit->count_all_item_production($item_kit_id);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_follow_bom_manage_table($this->Item_kit->get_all_item_production($item_kit_id, $data['per_page']), $this);
        $data['info_item_kit'] = $this->Item_kit->get_info($item_kit_id);
        $this->load->view('item_kits/follow_bom', $data);
    }

    function sorting_follow_bom() {
        $item_kit_id = $this->receiving_lib->get_item_kits();
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search) {
            $config['total_rows'] = $this->Item_kit->search_count_all_item_production($item_kit_id, $search); //search_count_all
            $table_data = $this->Item_kit->search_item_production(
                    $item_kit_id, $search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
            );
        }//search
        else {
            $config['total_rows'] = $this->Item_kit->count_all_item_production($item_kit_id); //count_all
            $table_data = $this->Item_kit->get_all_item_production($item_kit_id, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        }//get_all
        $config['base_url'] = site_url("item_kits/sorting_follow_bom");
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);

        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_follow_bom_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function suggest_follow_bom() {
        $item_kit_id = $this->receiving_lib->get_item_kits();
        $suggestions = $this->Item_kit->get_search_suggestions_item_production($item_kit_id, $this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    function search_follow_bom() {
        $item_kit_id = $this->receiving_lib->get_item_kits();
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Item_kit->search_item_production(
                $item_kit_id, $search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
        );
        $config['base_url'] = site_url('item_kits/search_follow_bom/' . $item_kit_id);
        $config['total_rows'] = $this->Item_kit->search_count_all_item_production($item_kit_id, $search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_follow_bom_manage_table_data_rows($search_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    //End Hung follow_bom
    //July 08, 2015 Hưng Audi item_kit_feature
    function switch_item_kit_feature($id_design_template) {
        $this->receiving_lib->add_design_template($id_design_template);
        redirect('item_kits/item_kit_feature');
    }

    function item_kit_feature() {
        $id_design_template = $this->receiving_lib->get_design_template();
        $config['base_url'] = site_url("item_kits/sorting_item_kit_feature");
        $config['total_rows'] = $this->Item_kit->count_all_item_kit_feature($id_design_template);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_item_kit_feature_manage_table($this->Item_kit->get_all_item_kit_feature($id_design_template, $data['per_page']), $this);
        $data['info_design_template'] = $this->Item_kit->get_info_design_template($id_design_template);
        $this->load->view('item_kits/item_kit_feature', $data);
    }

    function sorting_item_kit_feature() {
        $id_design_template = $this->receiving_lib->get_design_template();
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search) {
            $config['total_rows'] = $this->Item_kit->search_count_all_item_kit_feature($id_design_template, $search); //search_count_all
            $table_data = $this->Item_kit->search_item_kit_feature(
                    $id_design_template, $search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'feature_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
            );
        } else {
            $config['total_rows'] = $this->Item_kit->count_all_item_kit_feature($id_design_template); //count_all
            $table_data = $this->Item_kit->get_all_item_kit_feature(
                    $id_design_template, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'feature_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
            );
        }
        $config['base_url'] = site_url("item_kits/sorting_item_kit_feature");
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_item_kit_feature_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function suggest_item_kit_feature() {
        $id_design_template = $this->receiving_lib->get_design_template();
        $suggestions = $this->Item_kit->get_search_suggestions_item_kit_feature($id_design_template, $this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    function search_item_kit_feature() {
        $id_design_template = $this->receiving_lib->get_design_template();
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Item_kit->search_item_kit_feature(
                $id_design_template, $search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'feature_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
        );
        $config['base_url'] = site_url('item_kits/search_item_kit_feature/' . $id_design_template);
        $config['total_rows'] = $this->Item_kit->search_count_all_item_kit_feature($id_design_template, $search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_item_kit_feature_manage_table_data_rows($search_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function delete_item_kit_feature() {
        $feature_ids_to_delete = $this->input->post('ids');
        if ($this->Item_kit->delete_list_item_kit_feature($feature_ids_to_delete)) {
            echo json_encode(array(
                'success' => true,
                'message' => lang('item_kits_successful_deleted') . ' ' . count($feature_ids_to_delete) . ' kiểu sản phẩm',
            ));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Không thể xóa kiểu sản phẩm này !'));
        }
    }

    function view_item_kit_feature($feature_id = -1) {
        $data['feature_id'] = $feature_id;
        $data['id_design_template'] = $this->receiving_lib->get_design_template();
        $data['item_kit_feature'] = $this->Item_kit->get_info_item_kit_feature($feature_id);

        $id_design_template = $this->receiving_lib->get_design_template();
        $data['info_design_template'] = $this->Item_kit->get_info_design_template($id_design_template);
        $data['info_formula_material'] = $this->Item_kit->get_info_formula_materials($feature_id);
        $data['feature_design_template'] = $this->Item_kit->get_feature_design_template($id_design_template);
        $this->load->view("item_kits/form_item_kit_feature", $data);
    }

    function save_item_kit_feature($feature_id = -1) {
        //save_item_kit_feature
        $item_kit_feature = array(
            "id_design_template" => $this->input->post("id_design_template"),
            "number_feature" => $this->input->post('number_feature'),
            "name_feature" => $this->input->post("name_feature"),
        );
        if ($this->Item_kit->save_item_kit_feature($item_kit_feature, $feature_id)) {
            //save_formula_materials
            $quantitys = str_replace(',', '', $this->input->post("quantity"));
            if ($quantitys) {
                $data_formula_materials = array();
                foreach ($quantitys as $key => $quantity) {
                    foreach ($this->input->post("unit") as $item_id => $unit) {
                        if ($key == $item_id) {
                            $data_formula_materials[] = array(
                                "item_id" => $item_id,
                                "quantity" => $quantity,
                                "unit" => $unit
                            );
                        }
                    }
                }
            }
            if ($feature_id == -1) {
                $this->Item_kit->save_formula_materials($data_formula_materials, $item_kit_feature['feature_id']);
                echo json_encode(array("success" => true, "message" => lang("insert_success_design_template")));
            } else {
                $this->Item_kit->save_formula_materials($data_formula_materials, $feature_id);
                echo json_encode(array("success" => true, "message" => lang("update_success_design_template")));
            }
        } else {
            echo json_encode(array("success" => false, "message" => lang("insert_update_failed_design_template")));
        }
    }

    function check_number_feature($feature_id) {
        $id_design_template = $this->receiving_lib->get_design_template();
        $number_feature = $this->input->post("number_feature");
        $check = $this->Item_kit->check_number_feature($id_design_template, $feature_id, $number_feature);
        if ($check) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    function check_name_feature($feature_id) {
        $id_design_template = $this->receiving_lib->get_design_template();
        $name_feature = $this->input->post("name_feature");
        $check = $this->Item_kit->check_name_feature($id_design_template, $feature_id, $name_feature);
        if ($check) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    //end H.A item_kit_feature
    //hung audi 11-7-15 production_template
    function view_production_template($id_design_template) {
        $data['info_design_template'] = $this->Item_kit->get_info_design_template($id_design_template);
        $data['request_production_template'] = $this->Item_kit->get_info_request_production_template($id_design_template);
        $data['name_feature'] = $this->Item_kit->get_info_item_kit_feature($data['request_production_template']->feature_id)->name_feature;
        $data['info_formula_material'] = $this->Item_kit->get_info_formula_materials($data['request_production_template']->feature_id);
        $data['production_template'] = $this->Item_kit->get_info_production_template($id_design_template);
        $this->load->view("item_kits/view_production_template", $data);
    }

    function save_production_template($id_design_template) {
        $start_date1 = $this->input->post('start_date');
        $end_date1 = $this->input->post('end_date');
        $tam = $end_date1;
        $tam .='23:59:59';
        $start_date = date('Y-m-d H:i:s', strtotime($start_date1));
        $end_date = date('Y-m-d H:i:s', strtotime($tam));
        $data = array(
            "id_design_template" => $id_design_template,
            "code_production_template" => $this->input->post('code_production_template'),
            "image_production_template" => '',
            "date_create" => date('Y-m-d H:i:s'),
            "start_date" => $start_date,
            "end_date" => $end_date,
            "status" => 0,
            'delete' => 0,
        );
        $check = $this->Item_kit->check_id_design_template($id_design_template);
        if ($this->Item_kit->save_item_kit_production_template($data, $id_design_template)) {
            if (!$check) {
                $data_request_production_template = array(
                    'status' => 1
                );
                $this->Item_kit->save_request_production_template($data_request_production_template, $id_design_template);
                echo json_encode(array("success" => true, "message" => 'Thêm lệnh sản xuất thành công !'));
            } else {
                echo json_encode(array("success" => true, "message" => 'Cập nhật lệnh sản xuất thành công !'));
            }
        } else {
            echo json_encode(array("success" => false, "message" => lang("insert_update_failed_design_template")));
        }
    }

    function check_code_production_template($id_design_template) {
        $code_production_template = $this->input->post("code_production_template");
        $check = $this->Item_kit->check_code_production_template($id_design_template, $code_production_template);
        if ($check) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    //end production_template
    //Monday - July 13, Hưng Audi view_estimate
    function view_estimate($item_kit_id) {
        $this->receiving_lib->add_item_kits($item_kit_id);
        redirect('item_kits/estimate');
    }

    function estimate() {
        $item_kit_id = $this->receiving_lib->get_item_kits();
        $config['base_url'] = site_url("item_kits/sorting_estimate");
        $config['total_rows'] = $this->Item_kit->count_all_estimate($item_kit_id);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_estimate_manage_table($this->Item_kit->get_all_estimate($item_kit_id, $data['per_page']), $this);
        $data['info_item_kit'] = $this->Item_kit->get_info($item_kit_id);
        $this->load->view('item_kits/estimate', $data);
    }

    function sorting_estimate() {
        $item_kit_id = $this->receiving_lib->get_item_kits();
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search) {
            $config['total_rows'] = $this->Item_kit->search_count_all_estimate($item_kit_id, $search);
            $table_data = $this->Item_kit->search_estimate(
                    $item_kit_id, $search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'pt.id_design_template', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
            );
        } else {
            $config['total_rows'] = $this->Item_kit->count_all_estimate($item_kit_id); //count_all
            $table_data = $this->Item_kit->get_all_estimate(
                    $item_kit_id, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'pt.id_design_template', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
            );
        }
        $config['base_url'] = site_url("item_kits/sorting_estimate");
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_estimate_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function suggest_estimate() {
        $item_kit_id = $this->receiving_lib->get_item_kits();
        $suggestions = $this->Item_kit->get_search_suggestions_estimate($item_kit_id, $this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    function search_estimate() {
        $item_kit_id = $this->receiving_lib->get_item_kits();
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Item_kit->search_estimate(
                $item_kit_id, $search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'pt.id_design_template', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
        );
        $config['base_url'] = site_url('item_kits/search_estimate/' . $item_kit_id);
        $config['total_rows'] = $this->Item_kit->search_count_all_estimate($item_kit_id, $search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_estimate_manage_table_data_rows($search_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function delete_estimate() {
        $id_design_templates = $this->input->post('ids');
        if ($this->Item_kit->delete_list_estimate($id_design_templates)) {
            echo json_encode(array(
                'success' => true,
                'message' => lang('item_kits_successful_deleted') . ' ' . count($id_design_templates) . ' mẫu sản xuất',
            ));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Không thể xóa mẫu sản xuất này !'));
        }
    }

    function confirm_estimate($id_design_template) {
        $data['info_design_template'] = $this->Item_kit->get_info_design_template($id_design_template);
        $request_production_template = $this->Item_kit->get_info_request_production_template($id_design_template);
        $data['request_production_template'] = $request_production_template;
        $data['name_feature'] = $this->Item_kit->get_info_item_kit_feature($request_production_template->feature_id)->name_feature;
        $data['info_formula_material'] = $this->Item_kit->get_info_formula_materials($request_production_template->feature_id);
        $data['production_template'] = $this->Item_kit->get_info_production_template($id_design_template);
        $this->load->view("item_kits/confirm_estimate", $data);
    }

    function save_confirm_estimate($id_design_template) {
        /* phan them anh */
        $config = array(
            "upload_path" => "./item_kit/",
            'allowed_types' => 'gif|jpg|png|bmp|jpeg',
        );
        $this->load->library('upload', $config);
        $this->upload->do_upload("estimate_image"); //inputttttttt
        $images = $this->upload->data();
        $config1 = array(
            "source_image" => $images['full_path'],
            "maintain_ration" => true,
            "width" => '157',
            "height" => "125");
        $this->load->library("image_lib", $config1);
        $this->image_lib->resize();
        $img = $images['file_name'];
        //end img  
        $data = array(
            "status" => $this->input->post('status'),
            'image_production_template' => $img
        );
        if ($this->Item_kit->save_item_kit_production_template($data, $id_design_template)) {
            echo json_encode(array("success" => true, "message" => 'Xác nhận thành công !'));
        }
    }

    /*     * ** July 16 Beautiful Day *** */

    //approve_estimate
    function approve_estimate($id_design_template) {
        $item_kit_id = $this->Item_kit->get_info_design_template($id_design_template)->item_kit_id;
        $design_templates = $this->Item_kit->get_info_design_template_by_item_kit_id($item_kit_id);
        $id_design_template_status = array();
        foreach ($design_templates as $design_template) {
            $id_design_template_status[] = $design_template->id_design_template;
        }
        $id_design_template_status = implode(',', $id_design_template_status);

        $data['id_design_template_status_6'] = $this->Item_kit->exist_status_production_template($id_design_template_status)->row()->id_design_template;
        $data['production_template'] = $this->Item_kit->get_info_production_template($id_design_template);
        $data['id_design_template'] = $id_design_template;
        $this->load->view("item_kits/approve_estimate", $data);
    }

    function save_approve_estimate($id_design_template) {
        $data = array(
            "status" => $this->input->post("status"),
            "comment" => $this->input->post("comment")
        );
        if ($this->Item_kit->save_item_kit_production_template($data, $id_design_template)) {
            if ($this->input->post("status") == 6) {
                //save item_kit ( nên để phần save ở dưới json_encode để ko bị đụng phần trả về bên model )
                $item_kit_id = $this->Item_kit->get_info_design_template($id_design_template)->item_kit_id;
                $production_template = $this->Item_kit->get_info_production_template($id_design_template);
                $data_item_kit = array(
                    "images" => $production_template->image_production_template,
                    'status' => 3, //duyệt sx
                );
                $this->Item_kit->save($data_item_kit, $item_kit_id);
            }
            echo json_encode(array("success" => TRUE, "message" => lang("item_kits_perform_successfull")));
        } else {
            echo json_encode(array("success" => FALSE, "message" => lang("item_kits_perform_error")));
        }
    }

    /*     * ** July 16, 2015 Wonderful Day    Hưng Audi *** */

    //request_estimate
    function switch_request_production($item_kit_id) {
        $this->receiving_lib->add_item_kits($item_kit_id);
        redirect('item_kits/manager_request_production');
    }

    function manager_request_production() {
        $item_kit_id = $this->receiving_lib->get_item_kits();
        $config['base_url'] = site_url("item_kits/sorting_request_production");
        $config['total_rows'] = $this->Item_kit->count_all_request_production($item_kit_id);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_request_production_manage_table($this->Item_kit->get_all_request_production($item_kit_id, $data['per_page']), $this);
        $data['info_item_kit'] = $this->Item_kit->get_info($item_kit_id);
        $this->load->view('item_kits/manager_request_production', $data);
    }

    function sorting_request_production() {
        $item_kit_id = $this->receiving_lib->get_item_kits();
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search) {
            $config['total_rows'] = $this->Item_kit->search_count_all_request_production($item_kit_id, $search); //search_count_all
            $table_data = $this->Item_kit->search_request_production($item_kit_id, $search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'request_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
            );
        } else {
            $config['total_rows'] = $this->Item_kit->count_all_request_production($item_kit_id); //count_all
            $table_data = $this->Item_kit->get_all_request_production($item_kit_id, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'request_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        }//get_all
        $config['base_url'] = site_url("item_kits/sorting_request_production");
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);

        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_request_production_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function search_request_production() {
        $item_kit_id = $this->receiving_lib->get_item_kits();
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Item_kit->search_request_production($item_kit_id, $search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'request_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
        );
        $config['base_url'] = site_url('item_kits/search_request_production');
        $config['total_rows'] = $this->Item_kit->search_count_all_request_production($item_kit_id, $search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_request_production_manage_table_data_rows($search_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function request_estimate($request_id = -1) {
        $item_kit_id = $this->receiving_lib->get_item_kits();
        $data['info_request_production'] = $this->Item_kit->get_info_request_production($request_id);
        $data['item_kit_info'] = $this->Item_kit->get_info($item_kit_id);
        $data['item_kit_id'] = $item_kit_id;
        $data['production_design'] = $this->Item_kit->get_production_join_design($item_kit_id);

        $design_templates = $this->Item_kit->get_info_design_template_by_item_kit_id($item_kit_id);
        $id_design_template_status = array();
        foreach ($design_templates as $design_template) {
            $id_design_template_status[] = $design_template->id_design_template;
        }
        $id_design_template_status = implode(',', $id_design_template_status);
        $id_design_template_status_6 = $this->Item_kit->exist_status_production_template($id_design_template_status)->row()->id_design_template;
        $data['item_kit_feature'] = $this->Item_kit->get_all_item_kit_feature($id_design_template_status_6);
        $data['request_production'] = $this->Item_kit->get_info_item_kit_request_production($item_kit_id);

        $request_feature = $this->Item_kit->get_feature_in_request_feature($request_id);
        $feature_ids = array();
        foreach ($request_feature as $rf) {
            $feature_ids[] = $rf->feature_id;
        }
        $data['feature_ids'] = implode(',', $feature_ids);
        $this->load->view("item_kits/request_estimate", $data);
    }

    function save_request_estimate($request_id = -1) {
        //save_item_kit_request_production
        $item_kit_id = $this->input->post("item_kit_id");
        $request_production_data = array(
            'item_kit_id' => $item_kit_id,
            'comment' => $this->input->post('comment'),
            'status' => 0,
            'delete' => 0,
        );
        if ($this->Item_kit->save_item_kit_request_production($request_production_data, $request_id)) {


            //save_item_kit_request_feature

            $request_feature_data = array();

            if ($this->input->post('request_estimate_size')) {
                if ($this->input->post('request_estimate_checkbox')) {
                    foreach ($this->input->post('request_estimate_checkbox') as $feature_id => $request_estimate_checkbox) {

                        if ($this->input->post('request_estimate_id')) {
                            foreach ($this->input->post('request_estimate_id') as $feature_id2 => $request_estimate_id) {

                                if ($feature_id == $feature_id2) {

                                    if ($this->input->post('request_estimate_size')) {
                                        foreach ($this->input->post('request_estimate_size') as $feature_id3 => $request_estimate_size) {
                                            $length = strlen($feature_id2);
                                            $size = substr($feature_id3, 0, $length);
                                            if ($feature_id2 == $size) {

                                                if ($this->input->post('request_estimate_quantity')) {
                                                    foreach ($this->input->post('request_estimate_quantity') as $feature_id4 => $request_estimate_quantity) {
                                                        if ($feature_id3 == $feature_id4) {
                                                            $request_feature_data[] = array(
                                                                'request_id' => ($request_id != -1) ? $request_id : $request_production_data['request_id'],
                                                                'feature_id' => $feature_id2,
                                                                'size' => $request_estimate_size,
                                                                'quantity' => str_replace(',', '', $request_estimate_quantity)
                                                            );
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
                }
            }
            //28-8
            $data_item_kit = array(
                'status' => 4, //đang sx
            );
            $this->Item_kit->save($data_item_kit, $item_kit_id);

            $this->Item_kit->save_item_kit_request_feature($request_feature_data, $request_id);
            echo json_encode(array("success" => TRUE, "message" => lang("item_kits_perform_successfull")));
        } else {
            echo json_encode(array("success" => FALSE, "message" => lang("item_kits_perform_error")));
        }
    }

    function suggest_request_production() {
        $item_kit_id = $this->receiving_lib->get_item_kits();
        $suggestions = $this->Item_kit->get_search_suggestions_request_production($item_kit_id, $this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    function delete_request_production() {
        $request_id = $this->input->post("ids");
        if ($this->Item_kit->delete_request_production($request_id)) {
            echo json_encode(array("success" => TRUE, "message" => "Xóa thành công " . count($request_id) . " yêu cầu"));
        } else {
            echo json_encode(array("success" => FALSE, "message" => "Xóa thất bại!"));
        }
    }

    //July 27, Hưng Audi calculate_estimate
    function view_calculate($request_id) {
        $info_request_production = $this->Item_kit->get_info_request_production($request_id);
        $item_kit_id = $info_request_production->item_kit_id;

        $data['item_kit_info'] = $this->Item_kit->get_info($item_kit_id); //Lay thong tin san pham
        $data['production_design'] = $this->Item_kit->get_production_join_design($item_kit_id); //Lay thong tin mau san xuat
        //$design_templates = $this->Item_kit->get_info_design_template_by_item_kit_id($item_kit_id); //Lay thong tin mau thiet ke
        $data['request_feature'] = $this->Item_kit->get_feature_in_request_feature($request_id);

        //processes
        $processes = array('' => '-- Chọn công đoạn --');
        foreach ($this->Item_kit->get_all_processes_new()->result_array() as $r) {
            $processes[$r['id_processes']] = $r[name_processes];
        }
        $data['processes'] = $processes;
        $data['request_id'] = $request_id;
        $data['item_kit_processes'] = $this->Item_kit->get_all_item_kit_processes($request_id);
        $data['info_request_production'] = $info_request_production;

        $design_templates = $this->Item_kit->get_info_design_template_by_item_kit_id($item_kit_id);
        $id_design_template_status = array();
        foreach ($design_templates as $design_template) {
            $id_design_template_status[] = $design_template->id_design_template;
        }
        $id_design_template_status = implode(',', $id_design_template_status);
        $id_design_template_status_6 = $this->Item_kit->exist_status_production_template($id_design_template_status)->row()->id_design_template;
        $data['item_kit_feature'] = $this->Item_kit->get_all_item_kit_feature($id_design_template_status_6);
        $request_feature_info = $this->Item_kit->get_feature_in_request_feature($request_id);
        $feature_ids = array();
        foreach ($request_feature_info as $rf) {
            $feature_ids[] = $rf->feature_id;
        }
        $data['feature_ids'] = implode(',', $feature_ids);

        //tk_no & co
        $data['list_tk_no'] = $this->Tkdu->get_tkdu_parent();
        $data['list_tk_co'] = $this->Tkdu->get_tkdu_parent();

        $this->load->view('item_kits/form_calculate', $data);
    }

    function save_item_kit_processes($request_id) {
        //save item_kit_request_production
        $HallOweeN_data = array(
            'total_money_norms' => str_replace(',', '', $this->input->post('total_money_norms'))
        );
        $this->Item_kit->save_item_kit_request_production($HallOweeN_data, $request_id);
        
        //save item_kit_norms_item
        $norms_item_data = array();
        foreach ($this->input->post('item_id') as $h => $item_id) {
            foreach ($this->input->post('quantity_total') as $h2 => $quantity_total) {
                if ($h == $h2) {
                    $norms_item_data[] = array(
                        'request_id' => $request_id,
                        'item_id' => $item_id,
                        'quantity_total' => str_replace(',', '', $quantity_total)
                    );
                }
            }
        }
        $this->Item_kit->save_item_kit_norms_item($norms_item_data, $request_id);

        //save item_kit_processes
        $chks = array();
        $processes_data = array();
        $processes_cost_data = array();
        foreach ($this->input->post('pro_id') as $r => $pro_id) {
            foreach ($this->input->post('id_processes') as $r2 => $id_processes) {
                if ($r == $r2) {
                    foreach ($this->input->post('time_processes') as $r3 => $time_processes) {
                        if ($r2 == $r3) {
                            foreach ($this->input->post('unit_time') as $r4 => $unit_time) {
                                if ($r3 == $r4) {
                                    foreach ($this->input->post('processes_money') as $r5 => $processes_money) {
                                        if ($r4 == $r5) {
                                            $processes_data[] = array(
                                                'pro_id' => $r,
                                                'request_id' => $request_id,
                                                'id_processes' => $id_processes,
                                                'time_processes' => $time_processes,
                                                'unit_time' => $unit_time,
                                                'processes_money' => str_replace(',', '', $processes_money),
                                            );
                                            //thue ngoai
                                            foreach ($this->input->post('outsource') as $r6 => $outsource) {
                                                $length = strlen($r5);
                                                $str_r6 = substr($r6, 0, $length);
                                                if ($str_r6 == $r5) {
                                                    foreach ($this->input->post('cost_money_outsource') as $r7 => $cost_money_outsource) {
                                                        if ($r6 == $r7) {
                                                            foreach ($this->input->post('tk_no_outsource') as $r8 => $tk_no_outsource) {
                                                                if ($r7 == $r8) {
                                                                    foreach ($this->input->post('tk_co_outsource') as $r9 => $tk_co_outsource) {
                                                                        if ($r8 == $r9) {
                                                                            foreach ($this->input->post('comment') as $r10 => $comment) {
                                                                                if ($r9 == $r10) {
                                                                                    $processes_cost_data[] = array(
                                                                                        'request_id' => $request_id,
                                                                                        'id_processes' => $id_processes,
                                                                                        'cost_name' => '',
                                                                                        'outsource' => $outsource,
                                                                                        'labor' => 0,
                                                                                        'machine' => 0,
                                                                                        'cost_money' => str_replace(',', '', $cost_money_outsource),
                                                                                        'tk_no' => $tk_no_outsource,
                                                                                        'tk_co' => $tk_co_outsource,
                                                                                        'comment' => $comment
                                                                                    );
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
                                            //chi phi #
                                            foreach ($this->input->post('cost_name') as $r6 => $cost_name) {
                                                $length = strlen($r5);
                                                $str_r6 = substr($r6, 0, $length);
                                                if ($str_r6 == $r5) {
                                                    foreach ($this->input->post('cost_money') as $r7 => $cost_money) {
                                                        if ($r6 == $r7) {
                                                            foreach ($this->input->post('tk_no') as $r8 => $tk_no) {
                                                                if ($r7 == $r8) {
                                                                    foreach ($this->input->post('tk_co') as $r9 => $tk_co) {
                                                                        if ($r8 == $r9) {
                                                                            foreach ($this->input->post('comment') as $r10 => $comment) {
                                                                                if ($r9 == $r10) {
                                                                                    $processes_cost_data[] = array(
                                                                                        'request_id' => $request_id,
                                                                                        'id_processes' => $id_processes,
                                                                                        'cost_name' => $cost_name,
                                                                                        'outsource' => 0,
                                                                                        'labor' => 0,
                                                                                        'machine' => 0,
                                                                                        'cost_money' => str_replace(',', '', $cost_money),
                                                                                        'tk_no' => $tk_no,
                                                                                        'tk_co' => $tk_co,
                                                                                        'comment' => $comment
                                                                                    );
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
                                            //nhan cong
                                            foreach ($this->input->post('labor') as $r6 => $labor) {
                                                $length = strlen($r5);
                                                $str_r6 = substr($r6, 0, $length);
                                                if ($str_r6 == $r5) {
                                                    foreach ($this->input->post('cost_money_labor') as $r7 => $cost_money_labor) {
                                                        if ($r6 == $r7) {
                                                            foreach ($this->input->post('tk_no_labor') as $r8 => $tk_no_labor) {
                                                                if ($r7 == $r8) {
                                                                    foreach ($this->input->post('tk_co_labor') as $r9 => $tk_co_labor) {
                                                                        if ($r8 == $r9) {
                                                                            foreach ($this->input->post('comment') as $r10 => $comment) {
                                                                                if ($r9 == $r10) {
                                                                                    $processes_cost_data[] = array(
                                                                                        'request_id' => $request_id,
                                                                                        'id_processes' => $id_processes,
                                                                                        'cost_name' => '',
                                                                                        'outsource' => 0,
                                                                                        'labor' => $labor,
                                                                                        'machine' => 0,
                                                                                        'cost_money' => str_replace(',', '', $cost_money_labor),
                                                                                        'tk_no' => $tk_no_labor,
                                                                                        'tk_co' => $tk_co_labor,
                                                                                        'comment' => $comment
                                                                                    );
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
                                            //may moc
                                            foreach ($this->input->post('machine') as $r6 => $machine) {
                                                $length = strlen($r5);
                                                $str_r6 = substr($r6, 0, $length);
                                                if ($str_r6 == $r5) {
                                                    foreach ($this->input->post('cost_money_machine') as $r7 => $cost_money_machine) {
                                                        if ($r6 == $r7) {
                                                            foreach ($this->input->post('tk_no_machine') as $r8 => $tk_no_machine) {
                                                                if ($r7 == $r8) {
                                                                    foreach ($this->input->post('tk_co_machine') as $r9 => $tk_co_machine) {
                                                                        if ($r8 == $r9) {
                                                                            foreach ($this->input->post('comment') as $r10 => $comment) {
                                                                                if ($r9 == $r10) {
                                                                                    $processes_cost_data[] = array(
                                                                                        'request_id' => $request_id,
                                                                                        'id_processes' => $id_processes,
                                                                                        'cost_name' => '',
                                                                                        'outsource' => 0,
                                                                                        'labor' => 0,
                                                                                        'machine' => $machine,
                                                                                        'cost_money' => str_replace(',', '', $cost_money_machine),
                                                                                        'tk_no' => $tk_no_machine,
                                                                                        'tk_co' => $tk_co_machine,
                                                                                        'comment' => $comment
                                                                                    );
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
                                            $this->Item_kit->save_item_kit_processes_cost($processes_cost_data, $request_id);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        if ($this->Item_kit->save_item_kit_processes($processes_data, $request_id)) {
            redirect('item_kits/manager_request_production');
            //echo json_encode(array(success => true, message => 'Thành Công !'));
        } else {
            echo json_encode(array(success => false, message => 'Thất Bại !'));
        }
    }

    //4-8
    function view_item_production($request_id) {
        $info_request_production = $this->Item_kit->get_info_request_production($request_id);
        $item_kit_id = $info_request_production->item_kit_id;

        $data['item_kit_info'] = $this->Item_kit->get_info($item_kit_id); //Lay thong tin san pham
        $data['production_design'] = $this->Item_kit->get_production_join_design($item_kit_id); //Lay thong tin mau san xuat
        $design_templates = $this->Item_kit->get_info_design_template_by_item_kit_id($item_kit_id); //Lay thong tin mau thiet ke
        $data['request_feature'] = $this->Item_kit->get_feature_in_request_feature($request_id);

        $data['request_id'] = $request_id;
        $data['item_kit_processes'] = $this->Item_kit->get_all_item_kit_processes($request_id);
        $data['info_request_production'] = $info_request_production;
        $data['item_production'] = $this->Item_kit->get_info_item_production_by_request_id($request_id);

        $design_templates = $this->Item_kit->get_info_design_template_by_item_kit_id($item_kit_id);
        $id_design_template_status = array();
        foreach ($design_templates as $design_template) {
            $id_design_template_status[] = $design_template->id_design_template;
        }
        $id_design_template_status = implode(',', $id_design_template_status);
        $id_design_template_status_6 = $this->Item_kit->exist_status_production_template($id_design_template_status)->row()->id_design_template;
        $data['item_kit_feature'] = $this->Item_kit->get_all_item_kit_feature($id_design_template_status_6);

        $request_feature_info = $this->Item_kit->get_feature_in_request_feature($request_id);
        $feature_ids = array();
        foreach ($request_feature_info as $rf) {
            $feature_ids[] = $rf->feature_id;
        }
        $data['feature_ids'] = implode(',', $feature_ids);
        $this->load->view("item_kits/form_item_production", $data);
    }

    function save_item_production($request_id) {
        $info_request_production = $this->Item_kit->get_info_request_production($request_id);
        $item_kit_id = $info_request_production->item_kit_id;
        $data_production = array(
            'item_kit_id' => $item_kit_id,
            'request_id' => $request_id,
            'date_begin' => date('Y-m-d', strtotime($this->input->post('date_begin'))),
            'date_end' => date('Y-m-d', strtotime($this->input->post('date_end'))),
        );
        if ($this->Item_kit->save_item_production($data_production, $request_id)) {
            //update item_kit_request_production
            $request_production_data = array(
                'status' => 1, //chờ tiếp nhận,
            );
            $this->Item_kit->save_item_kit_request_production($request_production_data, $request_id);
            //save kcs
            $kcs_data = array();
            $request_feature = $this->Item_kit->get_request_feature_by_request_id($request_id);
            $item_kit_processes = $this->Item_kit->get_all_item_kit_processes($request_id);
            foreach ($request_feature as $f) {
                foreach ($item_kit_processes->result() as $ip) {
                    $info_size = $this->Item_kit->get_info_request_feature_by_id($f->id);
                    $pro_id_min = $this->Item_kit->get_pro_id_min_in_item_kit_processes($request_id)->pro_id; //pro_id cong doan dau tien
                    $info_processes = $this->Item_kit->get_info_item_kit_processes($request_id, $pro_id_min);

                    if ($info_processes->id_processes == $ip->id_processes) {//cong doan dau tien co sl yeu cau
                        $kcs_data = array(
                            'request_id' => $request_id,
                            'feature_size_id' => $f->id,
                            'id_processes' => $ip->id_processes,
                            'quantity_request' => $info_size->quantity,
                            'quantity_production' => 0,
                            'status' => 0
                        );
                    } else {
                        $kcs_data = array(
                            'request_id' => $request_id,
                            'feature_size_id' => $f->id,
                            'id_processes' => $ip->id_processes,
                            'quantity_request' => 0,
                            'quantity_production' => 0,
                            'status' => 0
                        );
                    }
                    $this->Item_kit->save_kcs2($kcs_data);
                }
            }
            echo json_encode(array('success' => true, 'message' => 'Tạo lệnh thành công'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Lỗi! Vui lòng kiểm tra lại'));
        }
    }

    //end item_production
    //Thursday 6-8-15, Thứ Năm ngày lộc phát (68)
    function detail_quantity_size() {
        $request_id = $this->uri->segment(3);
        $data['type'] = $this->uri->segment(4);
        $data["request_feature"] = $this->Item_kit->get_feature_in_request_feature($request_id);
        $data["request_id"] = $request_id;
        $this->load->view("item_kits/detail_quantity_size", $data);
    }

    function print_request_estimate($request_id) {
        $data['request_id'] = $request_id;
        $data['info_request'] = $this->Item_kit->get_info_request_production($request_id);
        $this->load->view("item_kits/print_request_estimate", $data);
    }

    function confirm_production($request_id) {
        //save costs
        $info_item_production = $this->Item_kit->get_info_item_production_by_request_id($request_id);
        $processes_cost = $this->Item_kit->get_processes_cost_by_request($request_id);
        foreach ($processes_cost->result() as $pc) {
            $costs_data = array(
                'money' => $pc->cost_money,
                'date' => date('Y-m-d H:i:s'),
                'tk_no' => $pc->tk_no,
                'tk_co' => $pc->tk_co,
                'item_kit_id' => $info_item_production->item_kit_id,
                'processes_cost_id' => $pc->id
            );
            $this->Cost->save($costs_data, -1);
        }
        //save item_kit_request_production
        $data = array(
            'status' => 2
        );
        if ($this->Item_kit->save_item_kit_request_production($data, $request_id)) {
            //save item_production
            $data2 = array(
                'status' => 2
            );
            $this->Item_kit->save_item_production($data2, $request_id);
            echo json_encode(array("success" => TRUE, "message" => "Xác nhận thành công"));
        } else {
            echo json_encode(array("success" => FALSE, "message" => "Lỗi! Xác nhận thất bại"));
        }
    }

    //August 12, 2015
    //kcs
    function view_list_kcs($id) {
        $info_item_history = $this->Item_kit->get_info_item_production($id);
        $data["id"] = $id;
        $data["request_feature"] = $this->Item_kit->get_feature_in_request_feature($info_item_history->request_id);
        $data["item_kit_processes"] = $this->Item_kit->get_all_item_kit_processes($info_item_history->request_id);
        $this->load->view("item_kits/list_kcs", $data);
    }

    function view_form_kcs() {
        $data["id"] = $this->uri->segment(3);
        $request_id = $this->uri->segment(4);
        $id_processes = $this->uri->segment(5);
        $data["request_id"] = $request_id;
        $data["id_processes"] = $id_processes;

        $item_kit_processes_audi = $this->Item_kit->get_info_item_kit_processes_audi($request_id, $id_processes);
        $data["pro_id"] = $item_kit_processes_audi->pro_id;
        $data["request_feature"] = $this->Item_kit->get_feature_in_request_feature($request_id);
        
        //Enchanteur charming ~~~~
        $item_kit_id = 172;
        $item_products = $this->Item_kit->get_item_product($item_kit_id);
        $item_product = array('' => '-- Chọn thành phẩm --');
        foreach ($item_products->result() as $iphone8){
            $item_product[$iphone8->item_id] = $iphone8->name;
        }
        $data["item_product"] = $item_product;
        
        $this->load->view("item_kits/form_kcs", $data);
    }
    function item_product_search($item_kit_id) {
        $suggestions = $this->Item_kit->get_item_product_search_suggestions($this->input->get('term'), $item_kit_id, 100);
        echo json_encode($suggestions);
    }

    function save_kcs() {
        $id = $this->uri->segment(3);
        $request_id = $this->uri->segment(4);
        $id_processes = $this->uri->segment(5);
        $kcs_data = array();
        $kcs_data2 = array();
        $kcs_data_next = array();
        $info_kcs_audi = $this->Item_kit->get_info_kcs_audi($request_id, $id_processes);
        $date_now = date("Y-m-d H:i:s");

        $info_item_history = $this->Item_kit->get_info_item_production($id);
        $info_item_kit = $this->Item_kit->get_info($info_item_history->item_kit_id);
        $pro_id_max = $this->Item_kit->get_pro_id_max_in_item_kit_processes($request_id)->pro_id; //pro_id cong doan cuoi cung
        $info_processes_max = $this->Item_kit->get_info_item_kit_processes($request_id, $pro_id_max);
        
        //cong doan cuoi them ma nhap kho
        $data = array(
            'comment' => 'PRO'
        );
        if($info_processes_max->id_processes == $id_processes){
            $import_product_id = $this->Item_kit->insert_import_product($data);
        }
        
        foreach ($this->input->post("size_id") as $r0 => $size_id) {
            foreach ($this->input->post("quantity_request") as $r => $quantity_request) {
                if ($r0 == $r) {
                    foreach ($this->input->post("quantity_production") as $r2 => $quantity_production) {
                        if ($r == $r2) {
                            $kcs_id = $r0;
                            $info_kcs_by_kcs_id = $this->Item_kit->get_info_kcs_by_kcs_id($r);

                            foreach ($this->input->post("quantity_kcs") as $r4 => $quantity_kcs) {
                                if ($r2 == $r4) {
                                    foreach ($this->input->post("quantity_success") as $r5 => $quantity_success) {
                                        if ($r4 == $r5) {
                                            foreach ($this->input->post("quantity_error") as $r6 => $quantity_error) {
                                                if ($r5 == $r6) {
                                                    foreach ($this->input->post("cause_error") as $r7 => $cause_error) {
                                                        if ($r6 == $r7) {
                                                            $kcs_history_data = array(
                                                                "kcs_history_id" => $kcs_id,
                                                                "request_id" => $request_id,
                                                                "feature_size_id" => $info_kcs_by_kcs_id->feature_size_id,
                                                                "id_processes" => $id_processes,
                                                                "quantity_kcs" => $quantity_kcs,
                                                                "quantity_success" => $quantity_success,
                                                                "quantity_error" => $quantity_error,
                                                                "cause_error" => $cause_error,
                                                                "date_kcs" => $date_now,
                                                                "import_product_id" => $info_processes_max->id_processes == $id_processes 
                                                                                        ? $import_product_id : 0
                                                            );
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            $this->Item_kit->save_kcs_history($kcs_history_data);

                            $info_kcs_history_audi = $this->Item_kit->get_info_kcs_history_audi($request_id, $id_processes, $kcs_id);
                            $kcs_data[] = array(
                                "kcs_id" => $kcs_id,
                                "request_id" => $request_id,
                                "feature_size_id" => $info_kcs_by_kcs_id->feature_size_id,
                                "id_processes" => $id_processes,
                                "quantity_request" => $quantity_request,
                                "quantity_production" => $info_kcs_history_audi->quantity_success2,
                                "import_product_id" => $info_processes_max->id_processes == $id_processes ? $import_product_id : 0
                            );
                            
                            //save kcs next
                            $info_kcs_now = $this->Item_kit->get_info_kcs_by_kcs_id($kcs_id); //lay thong tin cong doan hien tai
                            $info_kcs_next = $this->Item_kit->get_info_kcs_next($kcs_id); //Lay id cua cong doan tiep theo
                            $info_kcs_next_audi = $this->Item_kit->get_info_kcs_by_kcs_id($info_kcs_next->kcs_id); //Lay thong tin cong doan tiep theo

                            $kcs_data_next[] = array(
                                "quantity_request" => $info_kcs_history_audi->quantity_success2
                            );
                            //neu day la cong doan cuoi cung thi ko co cong doan sau de luu
                            $pro_id_min = $this->Item_kit->get_pro_id_min_in_item_kit_processes($request_id)->pro_id;
                            $info_processes_min = $this->Item_kit->get_info_item_kit_processes($request_id, $pro_id_min);
                            if ($info_processes_min->id_processes != $info_kcs_next_audi->id_processes) {
                                $this->Item_kit->save_kcs_next($kcs_data_next, $info_kcs_next->kcs_id);
                            }
                        }
                    }
                }
            }
            $this->Item_kit->save_kcs($kcs_data, $size_id);

            $pro_id_min = $this->Item_kit->get_pro_id_min_in_item_kit_processes($request_id)->pro_id; //pro_id cong doan dau tien
            $info_processes_min = $this->Item_kit->get_info_item_kit_processes($request_id, $pro_id_min);

            if ($info_processes_min->id_processes == $id_processes) {//checkbox status cd 1
                foreach ($this->input->post("status") as $r3 => $status) {
                    $kcs_id = $r3;
                    if ($r0 == $r3) {
                        $kcs_data2[] = array(
                            "status" => 1
                        );
                    }
                    $this->Item_kit->update_kcs($kcs_data2, $kcs_id);
                }
            } else {//checkbox status cd #
                foreach ($this->input->post("quantity_request") as $r => $quantity_request) {
                    $kcs_id = $r;
                    $kcs_id_prev = $this->Item_kit->get_info_kcs_prev($kcs_id)->kcs_id; //Lay id cong doan truoc
                    $info_kcs_prev = $this->Item_kit->get_info_kcs_by_kcs_id($kcs_id_prev); //Thong tin cong doan truoc

                    $info_kcs_by_kcs_id = $this->Item_kit->get_info_kcs_by_kcs_id($r);
                    //Kiem tra xem cd truoc da hoan thanh chua
                    //Da hoan thanh thi cong doan nay cung hoan thanh
                    $info_kcs_status = $this->Item_kit->get_info_kcs_new($request_id, $info_kcs_by_kcs_id->feature_size_id, $info_kcs_prev->id_processes);
                    $info_kcs_history_audi = $this->Item_kit->get_info_kcs_history_audi($request_id, $id_processes, $kcs_id);
                    $status = $info_kcs_status->status == 1 && ($quantity_request == $info_kcs_history_audi->quantity_success2) ? 1 : 0;
                    $kcs_data2[] = array(
                        "status" => $status
                    );
                    $this->Item_kit->update_kcs($kcs_data2, $kcs_id);
                }
            }

            //nhap kho thanh pham
            if ($info_processes_max->id_processes == $id_processes) {
                foreach ($this->input->post("item_number") as $r8 => $item_number) {
                    if ($r0 == $r8) {//audi r8
                        foreach ($this->input->post("name") as $r9 => $name) {
                            if ($r8 == $r9) {
                                $info_kcs = $this->Item_kit->get_info_kcs_by_kcs_id($r8);
                                $id_max_kcs_history = $this->Item_kit->select_max_id_in_kcs_history($r8, $info_kcs->request_id, $info_kcs->feature_size_id);
                                $info_kcs_history = $this->Item_kit->get_info_kcs_history_by_id($id_max_kcs_history->id);
                                //save items
                                $item_info = $this->Item->get_info_item_by_item_number($item_number);
                                $kho_thanh_pham = $this->Create_invetory->check_exist_product_store();

                                if ($item_info) {
                                    $item_id = $item_info["item_id"];
                                    $info_warehouse_item = $this->Item->get_info_warehouse_items($item_id, $kho_thanh_pham['id']);
                                    $item_data = array(
                                        "item_number" => $item_number,
                                        "name" => $name,
                                        "quantity" => $info_warehouse_item->quantity + $info_kcs_history->quantity_success,
                                        "produce" => 1,
                                        "category" => $info_item_kit->category,
                                        "unit" => (int) $info_item_kit->unit,
                                        'item_kit_id' => $info_item_history->item_kit_id
                                    );
                                    $this->Item->save($item_data, $item_info["item_id"]);
                                    //save warehouse_items
                                    $warehouse_item_data = array(
                                        "warehouse_id" => $kho_thanh_pham["id"],
                                        "store_id" => 0,
                                        "item_id" => $item_info["item_id"],
                                        "quantity" => $info_warehouse_item->quantity + $info_kcs_history->quantity_success,
                                        "stt" => 0,
                                        "date" => date("Y-m-d H:i:s"),
                                    );
                                    $warehouse_items = $this->Item->get_id_Items_warehouse($kho_thanh_pham["id"], $item_info["item_id"]);
                                    $this->Item->saveWarehouseItems($warehouse_item_data, $warehouse_items->id);
                                } else {
                                    $item_data = array(
                                        "item_number" => $item_number,
                                        "name" => $name,
                                        "quantity" => $info_kcs_history->quantity_success,
                                        "produce" => 1,
                                        "category" => $info_item_kit->category,
                                        'item_kit_id' => $info_item_history->item_kit_id
                                    );
                                    $this->Item->save($item_data, $item_info["item_id"]);
                                    $item_id = $item_data['item_id'];
                                    $warehouse_item_data = array(
                                        "warehouse_id" => $kho_thanh_pham["id"],
                                        "store_id" => 0,
                                        "item_id" => $item_data['item_id'],
                                        "quantity" => $info_kcs_history->quantity_success,
                                        "stt" => 0,
                                        "date" => date("Y-m-d H:i:s"),
                                    );
                                    $warehouse_items = $this->Item->get_id_Items_warehouse($kho_thanh_pham["id"], $item_data['item_id']);
                                    $this->Item->saveWarehouseItems($warehouse_item_data, $warehouse_items->id);
                                }
                                $inv_data_trans = array(
                                    'trans_items' => $item_id,
                                    'trans_user' => $this->session->userdata("person_id"),
                                    'trans_date' => date('Y-m-d H:i:s'),
                                    'trans_money' => 0,
                                    'trans_catid' => $info_item_kit->category,
                                    'trans_comment' => 'PRO',
                                    'trans_inventory' => $info_kcs_history->quantity_success,
                                    'store_id' => $kho_thanh_pham["id"],
                                    "request_id" => $request_id,
                                    'import_product_id' => $import_product_id
                                );
                                $this->Inventory->insert($inv_data_trans);
                            }
                        }
                    }
                }
            }
            $check_processes = $this->Item_kit->check_kcs($request_id);
            if ($check_processes->num_rows() == 0) {
                $data = array(
                    'status' => 3
                );
                $this->Item_kit->save_item_production($data, $request_id);
            }
            //
            $check_kit = $this->Item_kit->check_kit();
            if ($check_kit->num_rows() == 0) {
                $data_kit = array(
                    'status' => 5
                );
                $this->Item_kit->save($data_kit, $info_item_history->item_kit_id);
            }
            
        }
        
        if($info_processes_max->id_processes == $id_processes){
            
            /* save item_product_old */
            $quantity_apply = $this->input->post('quantity_apply');
            if($this->input->post('item_product_old_id')){
                foreach ($this->input->post('item_product_old_id') as $k => $item_product_old_id){
                    $kho_thanh_pham_old = $this->Create_invetory->check_exist_product_store();
                    $info_warehouse_item_old = $this->Item->get_info_warehouse_items($item_product_old_id, $kho_thanh_pham_old['id']);

                    //save items
                    $item_data_old = array(
                        "quantity" => $info_warehouse_item_old->quantity + $quantity_apply,
                    );
                    $this->Item->save($item_data_old, $item_product_old_id);

                    //save warehouse_items
                    $warehouse_item_data_old = array(
                        "quantity" => $info_warehouse_item_old->quantity + $quantity_apply,
                        "date" => date("Y-m-d H:i:s"),
                    );
                    $warehouse_items_old = $this->Item->get_id_Items_warehouse($kho_thanh_pham_old["id"], $item_product_old_id);
                    $this->Item->saveWarehouseItems($warehouse_item_data_old, $warehouse_items_old->id);

                    //save inv
                    $inv_data_trans_old = array(
                        'trans_items' => $item_product_old_id,
                        'trans_user' => $this->session->userdata("person_id"),
                        'trans_date' => date('Y-m-d H:i:s'),
                        'trans_money' => 0,
                        'trans_catid' => $info_item_kit->category,
                        'trans_comment' => 'PRO',
                        'trans_inventory' => $quantity_apply,
                        'store_id' => $kho_thanh_pham_old["id"],
                        "request_id" => $request_id,
                        'import_product_id' => $import_product_id
                    );
                    $this->Inventory->insert($inv_data_trans_old);
                }
            }
            /* end save item_product_old */
            
            $this->receiving_lib->set_number(6);
            $this->receiving_lib->set_item_production_id($id);
            redirect("item_kits/view_order_warehouse/$import_product_id");
        }else{
            $this->print_kcs($id, $request_id, $id_processes);
        }
    }

    function print_kcs($id, $request_id, $id_processes) {
        $data["id"] = $id;
        $data["request_id"] = $request_id;
        $data["id_processes"] = $id_processes;
        $info_item_history = $this->Item_kit->get_info_item_production($id);
        $data["request_feature"] = $this->Item_kit->get_feature_in_request_feature($info_item_history->request_id);
        $this->load->view('item_kits/print_kcs', $data);
    }

    //Nhap hang kho thanh pham
    function trading_product($item_ids) {
        $item_ids = explode('~', $item_ids);
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
        $info_store = $this->Create_invetory->check_exist_store_materials();
        $this->receiving_lib->set_inventory($info_store['id']);
        redirect('receivings');
    }

    //Sep 8, birthday Cty
    function processes_suggest() {
        $suggestions = $this->Item_kit->get_search_processes_suggestions($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    function confirm_processes($id_design_template) {//die('q');
        $row_min_processes_design_template = $this->Item_kit->get_row_min_processes_design_template($id_design_template);
        $id_processes = $this->Item_kit->get_info_processes_design_template($row_min_processes_design_template->id)->id_processes;
        $data['id'] = $this->Item_kit->get_processes_design_template($id_design_template, $id_processes)->id;
        $data['id_processes'] = $id_processes;
        $this->load->view("item_kits/confirm_processes", $data);
    }

    function save_confirm_processes($id) {
        $data = array(
            'status' => 1,
            'date_confirm' => date('Y-m-d')
        );
        $this->Item_kit->save_confirm_processes($data, $id);
        echo json_encode(array('success' => true, 'message' => 'Xác nhận thành công !'));
    }

    function get_list_processes_by_cat_pro_id() {
        $cat_pro_id = $this->input->post("cat_pro_id");
        $data = $this->Item_kit->get_list_processes_by_cat_pro_id($cat_pro_id);
        echo json_encode($data);
    }

    //19-9-15
    function tk_no_list() {
        $data['tk_no'] = 680000; //R8 0000
        $data['list_tk_no'] = $this->Tkdu->get_tkdu_parent();
        $this->load->view('item_kits/tk_no_list', $data);
    }
    function tk_no_list_full() {
        $data['tk_no'] = 680000; //R8 0000
        $data['list_tk_no'] = $this->Tkdu->get_tkdu_parent();
        $this->load->view('item_kits/tk_no_list', $data);
    }
    function tk_co_list() {
        $data['tk_no'] = 860000;
        $data['list_tk_co'] = $this->Tkdu->get_tkdu_parent();
        $this->load->view('item_kits/tk_co_list', $data);
    }

    function get_info_formula_materials() {
        $feature_id = $this->input->post("feature_id");
        $data = array();
        foreach ($this->Item_kit->get_info_formula_materials($feature_id) as $value) {
            $info_item = $this->Item->get_info($value['item_id']);
            if ($info_item->quantity_first == 0) {
                $unit = $info_item->unit;
            } else {
                $unit = $info_item->unit_from;
            }
            $unit_info = $this->Unit->get_info($unit);
            $data[] = array(
                "item_id" => $value['item_id'],
                "item_number" => $info_item->item_number,
                "name" => $info_item->name,
                "unit" => $unit,
                "unit_name" => $unit_info->name,
                "quantity" => $value['quantity']
            );
        }
        echo json_encode($data);
    }

    function order_request_estimate($id) {
        $data['info_request_prodcution_template'] = $this->Item_kit->get_info_request_production_template($id);
        $data['feature_id'] = $this->Item_kit->get_info_formula_materials($data['info_request_prodcution_template']->feature_id);
        $data['info_design_template'] = $this->Item_kit->get_info_design_template($id);
        $this->load->view("item_kits/order_request_template", $data);
    }

    //Sep 25 birthday Hưng Audi
    function set_start_date() {
        $this->receiving_lib->set_start_date($this->input->post('start_date'));
    }

    function set_end_date() {
        $this->receiving_lib->set_end_date($this->input->post('end_date'));
    }

    function set_item_kit_id() {
        $this->receiving_lib->set_item_kit_id($this->input->post('item_kit_id'));
    }

    function product_search_item_kit() {
        $item_kit_id = $this->receiving_lib->get_item_kit_id();
        $item_production_finish = $this->Item_kit->get_all_item_production_finish($item_kit_id);
        $request_ids = array();
        foreach ($item_production_finish as $finish) {
            $request_ids[] = $finish->request_id;
        }
        $request_ids = implode(',', $request_ids);

        $start_date_post = $this->receiving_lib->get_start_date();
        $end_date_post = $this->receiving_lib->get_end_date();
        $start_date = date('Y-m-d 00:00:00', strtotime($start_date_post));
        $end_date = date('Y-m-d 23:59:59', strtotime($end_date_post));
        $product_inventory = $this->Inventory->get_product_inventory($request_ids, $start_date, $end_date);
        //Hưng Audi 0000 Oct 27
        // hello HallOweeN (^_^)
        $info_request_production_HallOweeN = $this->Item_kit->get_info_request_production_by_request_HallOweeN($request_ids);
        $processes_cost_labor = $this->Item_kit->get_processes_cost_labor($request_ids, $start_date, $end_date);
        $processes_cost_machine = $this->Item_kit->get_processes_cost_machine($request_ids, $start_date, $end_date);
        $processes_cost_outsource = $this->Item_kit->get_processes_cost_outsource($request_ids, $start_date, $end_date);
        $processes_cost_other = $this->Item_kit->get_processes_cost_other($request_ids, $start_date, $end_date);
        $money_total = $info_request_production_HallOweeN->total_money_norms 
                        + $processes_cost_labor->money_labor 
                        + $processes_cost_machine->money_machine 
                        + $processes_cost_outsource->money_outsource 
                        + $processes_cost_other->money_other;

        echo json_encode(array(
            'quantity' => $product_inventory->quantity,
            'money_norm' => $info_request_production_HallOweeN->total_money_norms,
            'money_labor' => $processes_cost_labor->money_labor,
            'money_machine' => $processes_cost_machine->money_machine,
            'money_outsource' => $processes_cost_outsource->money_outsource,
            'money_other' => $processes_cost_other->money_other,
            'money_total' => $money_total,
            'cost_price' => $money_total / $product_inventory->quantity,
        ));
    }

    function view_cost_price($item_kit_id) {
        $data['item_kit_id'] = $item_kit_id;
        $data['info_cp'] = $this->Item_kit->get_info_item_kit_cost_price($item_kit_id);
        $this->load->view('item_kits/view_cost_price', $data);
    }

    function save_item_kit_cost_price($item_kit_id) {
        $data = array(
            "item_kit_id" => $item_kit_id,
            "quantity" => str_replace(",", "", $this->input->post("quantity")),
            "money_norm" => str_replace(",", "", $this->input->post("money_norm")),
            "money_labor" => str_replace(",", "", $this->input->post("money_labor")),
            "money_machine" => str_replace(",", "", $this->input->post("money_machine")),
            "money_outsource" => str_replace(",", "", $this->input->post("money_outsource")),
            "money_other" => str_replace(",", "", $this->input->post("money_other")),
            "cost_price" => str_replace(",", "", $this->input->post("cost_price")),
            "start_date" => date('Y-m-d', strtotime($this->input->post("start_date"))),
            "end_date" => date('Y-m-d', strtotime($this->input->post("end_date")))
        );
        $this->Item_kit->insert_item_kit_cost_price($data);
        
        //update cost_price in items
        $item_data = array(
            "cost_price" => str_replace(",", "", $this->input->post("cost_price")),
        );
        $this->Item->update_cost_price($item_data, $item_kit_id);
        
        echo json_encode(array("success" => TRUE, "message" => 'Bạn đã cập nhật giá vốn thành công !'));
    }

    //play boy << Hưng Audi >> 1-10-15
    function view_request_cost_price($request_id) {
        $data['request_id'] = $request_id;
        $data['product_inventory'] = $this->Inventory->get_inventory_by_request_id_2016($request_id);
        $data['request_production_Christmas'] = $this->Item_kit->get_info_request_production_by_request_Christmas($request_id);
        $data['processes_cost_labor'] = $this->Item_kit->get_processes_cost_labor_request($request_id);
        $data['processes_cost_machine'] = $this->Item_kit->get_processes_cost_machine_request($request_id);
        $data['processes_cost_outsource'] = $this->Item_kit->get_processes_cost_outsource_request($request_id);
        $data['processes_cost_other'] = $this->Item_kit->get_processes_cost_other_request($request_id);
        $this->load->view('item_kits/view_request_cost_price', $data);
    }
    //Hưng Audi 0000 Oct 28
    // hello HallOweeN (^_^)   
    function import_product() {
        $config['base_url'] = site_url('item_kits/sorting_import_product');
        $config['total_rows'] = $this->Inventory->count_all_inventory_product();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['per_page'] = $config['per_page'];
        //print_r($config['per_page']);die();
        $data['manage_table'] = get_import_product_manage_table($this->Inventory->get_all_inventory_product($data['per_page']), $this);
        $this->load->view('item_kits/import_product', $data);
    }
    function sorting_import_product() {
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $config['total_rows'] = $this->Inventory->count_all_inventory_product();
        $table_data = $this->Inventory->get_all_inventory_product(
            $per_page, 
            $this->input->post('offset') ? $this->input->post('offset') : 0, 
            $this->input->post('order_col') ? $this->input->post('order_col') : 'import_product_id', 
            $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
        );
        $config['base_url'] = site_url('item_kits/sorting_import_product');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_import_product_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }
    //Oct 30
    // hello HallOweeN (^_^)   
    function view_detail_kcs($request_id) {
        $data['request_id'] = $request_id;
        $data['inventory_product'] = $this->Inventory->get_inventory_by_request_id($request_id);
        $this->load->view("item_kits/form_detail_kcs", $data);
    }
    function switch_order_warehouse($import_product_id){
        $this->receiving_lib->set_number(8);
        redirect("item_kits/view_order_warehouse/$import_product_id");
    }
    function switch_order_warehouse_six($import_product_id){
        $this->receiving_lib->set_number(6);
        redirect("item_kits/view_order_warehouse/$import_product_id");
    }
    function view_order_warehouse($import_product_id) {
        $data['number'] = $this->receiving_lib->get_number();
        $data['item_production_id'] = $this->receiving_lib->get_item_production_id();
        
        $data['import_product_id'] = $import_product_id;
        $data['inventory_product'] = $this->Inventory->get_inventory_by_import_product_id($import_product_id);
        $data['inventory_product_row'] = $this->Inventory->get_inventory_by_import_product_id_2016($import_product_id);
        
        $request_id = $data['inventory_product']->row()->request_id;
        $data['item_kit_id'] = $this->Item_kit->get_info_item_production_by_request_id($request_id)->item_kit_id;
        $data['request_production_Christmas'] = $this->Item_kit->get_info_request_production_by_request_Christmas($request_id);
        $data['processes_cost_labor'] = $this->Item_kit->get_processes_cost_labor_request($request_id);
        $data['processes_cost_machine'] = $this->Item_kit->get_processes_cost_machine_request($request_id);
        $data['processes_cost_outsource'] = $this->Item_kit->get_processes_cost_outsource_request($request_id);
        $data['processes_cost_other'] = $this->Item_kit->get_processes_cost_other_request($request_id);
        
        $this->load->view("item_kits/order_warehouse", $data);
    }
    

}
