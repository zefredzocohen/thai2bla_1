<?php

require_once ("secure_area.php");

class Create_invetorys extends Secure_area {

    public function __construct() {
        parent::__construct();
        $this->load->library('receiving_lib');
    }

    public function index() {
        $this->check_action_permission('search');
        $config['base_url'] = site_url('create_invetorys/sorting');
        $config['total_rows'] = $this->Create_invetory->count_all();
        $data['result_array'] = $this->Create_invetory->get_all($data['per_page']);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 10;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_create_inventory_manage_table($this->Create_invetory->get_all1($data['per_page']), $this);
        $this->load->view('create_invetorys/manage', $data);
    }

    public function sorting() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search) {
            $config['total_rows'] = $this->Create_invetory->search_count_all($search);
            $table_data = $this->Create_invetory->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name_inventory', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        } else {
            $config['total_rows'] = $this->Create_invetory->count_all();
            $table_data = $this->Create_invetory->get_all($per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name_inventory', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        }
        $config['base_url'] = site_url('create_invetorys/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_create_inventory_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function search() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Create_invetory->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        $config['base_url'] = site_url('create_invetorys/search');
        $config['total_rows'] = $this->Create_invetory->search_count_all($search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_create_inventory_manage_table_data_rows($search_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    public function view($customertype = -1) {
        $this->check_action_permission('add_update');
        $data['create_invetorys'] = $this->Create_invetory->get_info($customertype);
        $data['check_product_inventory'] = $this->Create_invetory->check_exist_product_store();
        $data['check_store_materials'] = $this->Create_invetory->check_exist_store_materials();
        $this->load->view("create_invetorys/form", $data);
    }

    public function save($id = -1) {
        $create_invetorys = $this->Create_invetory->get_info($id);
        if ($create_invetorys->type_warehouse == 1 || $create_invetorys->type_warehouse == 2) {
            $data = array(
                'name_inventory' => $this->input->post('name_inventory'),
                'address' => $this->input->post('name_address'),
                'description' => $this->input->post('desc_inventory'),
                'id_province' => $this->input->post('id_province'),
                'name_province' => $this->input->post('name_province'),
                'id_district' => $this->input->post('id_district'),
                'map_x' => $this->input->post('map_x'),
                'map_y' => $this->input->post('map_y'),
                'created_date' => date('Y-m-d H:i:s'),
                'type_warehouse' => $create_invetorys->type_warehouse,
            );
            $this->Create_invetory->save($data, $id);
            echo json_encode(array('success' => true, 'message' => 'Bạn đã cập nhật thành công !' . ' ' .
                $data['name_inventory'], 'id' => $id));
        } else {
            if ($this->input->post('type_warehouse')) {
                $type_warehouse = $this->input->post('type_warehouse');
            } else {
                $type_warehouse = 0;
            }
            $data = array(
                'name_inventory' => $this->input->post('name_inventory'),
                'address' => $this->input->post('name_address'),
                'description' => $this->input->post('desc_inventory'),
                'id_province' => $this->input->post('id_province'),
                'name_province' => $this->input->post('name_province'),
                'id_district' => $this->input->post('id_district'),
                'map_x' => $this->input->post('map_x'),
                'map_y' => $this->input->post('map_y'),
                'created_date' => date('Y-m-d H:i:s'),
                'type_warehouse' => $type_warehouse,
            );
            if ($this->Create_invetory->save($data, $id)) {
                if ($id == -1) {
                    echo json_encode(array('success' => true, 'message' => 'Bạn đã thêm mới thành công !' . ' ' .
                        $data['name_inventory'], 'id' => $data['id']));
                    $id = $data['id'];
                } else { //previous giftcard
                    echo json_encode(array('success' => true, 'message' => 'Bạn đã cập nhật thành công !' . ' ' .
                        $data['name_inventory'], 'id' => $id));
                }
            } else {//failure
                // echo 'that bai';
                echo json_encode(array('success' => false, 'message' => 'Đã xảy ra lỗi !' . ' ' .
                    $data['name_inventory'], 'id' => -1));
            }
        }
    }

    function get_row() {
        $item_id = $this->input->post('row_id');
        $data_row = get_create_inventory_data_row($this->Create_invetory->get_info($item_id), $this);
        echo $data_row;
    }

    function suggest() {
        $suggestions = $this->Create_invetory->get_search_suggestions($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

//    public function delete() {
//        $id = $this->input->post('ids');
//        if ($this->Create_invetory->delete_list($id)) {
//            echo json_encode(array('success' => true, 'message' => 'Bạn đã xóa thành công !'));
//        } else {
//            echo json_encode(array('success' => false, 'message' => 'Đã xảy ra lỗi khi xóa'));
//            echo 'that bai';
//        }
//    }

    public function delete() {
        $id = $this->input->post('ids');
        foreach ($id as $ids) {
            $check_store = $this->Create_invetory->check_store_item($ids);
            if ($check_store > 0) {
                echo json_encode(array('success' => false, 'message' => 'Kho (' . $this->Create_invetory->get_info($ids)->name_inventory . ') đang có sản phẩm ! Bạn không thể xóa'));
                return;
            }
        }
        $this->Create_invetory->delete_list($id);
        echo json_encode(array('success' => true, 'message' => 'Bạn đã xóa thành công !'));
//        }else{
//            if ($this->Create_invetory->delete_list($id)) {
//                echo json_encode(array('success' => true, 'message' => 'Bạn đã xóa thành công !'));
//            } else {
//                echo json_encode(array('success' => false, 'message' => 'Đã xảy ra lỗi khi xóa'));
//                echo 'that bai';
//            }
//        }
    }

    public function get_form_width() {
        return 550;
    }

    // thang27082014 
    public function detail_inventory($id) {

        $data['name_inventory'] = $this->Create_invetory->get_info($id)->name_inventory;
        $data['address_warehouse'] = $this->Create_invetory->get_info($id)->address;
        $data['created_date'] = $this->Create_invetory->get_info($id)->created_date;

        // $data['infoma_item'] = $this->Create_invetory->get_warehouseinfo($id);
        // $data['quantity']=$this->Create_invetory->total_quantity_transfer($id);
        // var_dump($data['quantity']);exit();
        $data['infoma_item'] = $this->Item->get_join_transferand_warehouse($id);
        // $var_dump($data['infoma_item']);exit();

        $this->load->view('create_invetorys/detail_inventory', $data);
    }

    //Create by San 
    function check_name($id) {
        $name_inventory = trim($this->input->post('name_inventory'));
        $d['name_inventory'] = $this->Create_invetory->checkName($id);
        foreach ($d['name_inventory'] as $d2) {
            $d3[] = $d2['name_inventory'];
        }
        $c2 = $d3;
        $e1 = implode(',', $c2);
        $e2 = explode(',', $e1);

        if (in_array($name_inventory, $e2)) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    //    Loi
    function export_store_view() {

        $config['base_url'] = site_url('create_invetorys/sorting_export_store');
        $config['total_rows'] = $this->Create_invetory->count_all_export_store();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 10;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_export_store_manage_table($this->Create_invetory->get_all_export_store($data['per_page']), $this);

        $this->load->view('create_invetorys/export_store_view', $data);
    }

    function suggest_export_store() {
        $suggestions = $this->Create_invetory->get_search_suggestions_export_store($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    function sorting_export_store() {
        $start_date1 = $this->input->post('start_date');
        $end_date1 = $this->input->post('end_date');
        $tam = $end_date1;
        $tam .='23:59:59';
        $start_date = date('Y-m-d H:i:s', strtotime($start_date1));
        $end_date = date('Y-m-d H:i:s', strtotime($tam));

        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search || $start_date || $end_date) {
            $config['total_rows'] = $this->Create_invetory->search_count_all_export_store($start_date, $end_date, $search);
            $table_data = $this->Create_invetory->search_export_store(
                    $start_date, $end_date, $search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'export_store_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
            );
        } else {
            $config['total_rows'] = $this->Create_invetory->count_all_export_store();
            $table_data = $this->Create_invetory->get_all_export_store(
                    $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'export_store_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
            );
        }
        $config['base_url'] = site_url('create_invetorys/sorting_export_store');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_export_store_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function set_inventory() {
        $this->receiving_lib->set_inventory($this->input->post('next_warehouse'));
    }

    function switch_export_store($export_store_id) {
        $this->receiving_lib->set_export_store($export_store_id);
        $info_export_store = $this->Create_invetory->get_info_export_store($export_store_id);
        $this->receiving_lib->set_inventory($info_export_store->store_id);
        redirect('create_invetorys/export_store');
    }

//    function export_store($export_store_id = -1) {
//        if ($export_store_id != -1) {
//            $this->receiving_lib->set_export_store($export_store_id);
//            $info_export_store = $this->Create_invetory->get_info_export_store($export_store_id);
//            $this->receiving_lib->set_inventory($info_export_store->store_id);
//        } else {
//            $this->receiving_lib->clear_all();
//        }
//        $data['store'] = $this->receiving_lib->get_inventory();
//        $data['id_category'] = $this->receiving_lib->get_cate();
//        $data['export_store_id'] = $this->receiving_lib->get_export_store();
//        $data['export_store_item'] = $this->Create_invetory->get_export_store_item_by_id($data['export_store_id'])->result();
//        $data['info_export_store'] = $this->Create_invetory->get_info_export_store($data['export_store_id']);
//        $data['category'] = $this->Category->get_all();
//        //tk_no & co
//        $data['list_tk_no'] = $this->Tkdu->get_tkdu_parent();
//        $data['list_tk_co'] = $this->Tkdu->get_tkdu_parent();
//        $this->load->view('create_invetorys/export_store', $data);
//    }

    function export_store($export_store_id = -1) {
        if ($export_store_id != -1) {
            $this->receiving_lib->set_export_store($export_store_id);
            $info_export_store = $this->Create_invetory->get_info_export_store($export_store_id);
            $this->receiving_lib->set_inventory($info_export_store->store_id);
        } else {
            $this->receiving_lib->clear_all();
        }
        $data['store'] = $this->receiving_lib->get_inventory();
        $data['id_category'] = $this->receiving_lib->get_cate();
        $data['export_store_id'] = $this->receiving_lib->get_export_store();
        $data['export_store_item'] = $this->Create_invetory->get_export_store_item_by_id($data['export_store_id'])->result();
        $data['info_export_store'] = $this->Create_invetory->get_info_export_store($data['export_store_id']);
        $data['category'] = $this->Category->get_all();
        //tk_no & co
        $data['list_tk_no'] = $this->Tkdu->get_tkdu_parent();
        $data['list_tk_co'] = $this->Tkdu->get_tkdu_parent();
        $this->load->view('create_invetorys/export_store', $data);
    }
    
    function cancel_export_store() {
        $this->receiving_lib->clear_all();
        $this->receiving_lib->clear_cate();
        $this->export_store();
    }

    function save_export_store() {
        $form_export = $this->input->post("form_export");
        $export_store_item_data = array();
        $export_store_id = $this->receiving_lib->get_export_store();
        $ids = $this->input->post('item_id');
        $quantitys = str_replace(",", "", $this->input->post('quantity'));     //sl kho
        $comment = $this->input->post('comment');
        $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
        if ($form_export == 0) {
            $quantity_exports = str_replace(",", "", $this->input->post('quantity_export')); //sl xuat
            $store = $this->receiving_lib->get_inventory();
            $cost_price_exports = $this->input->post('cost_price_export2'); //gia xuat
            //save_export_store
            if ($export_store_id) {
                $export_store_data = array(
                    'date_export' => date('Y-m-d H:i:s'),
                    'status' => 0,
                    'follow' => 0,
                    'store_id' => $store,
                    'employee_id' => $employee_id,
                    'comment' => $comment
                );
                $this->Create_invetory->save_export_store($export_store_data, $export_store_id);
            } else {
                $export_store_data = array(
                    'date_export' => date('Y-m-d H:i:s'),
                    'status' => 0,
                    'follow' => 0,
                    'store_id' => $store,
                    'employee_id' => $employee_id,
                    'comment' => $comment
                );
                $this->Create_invetory->save_export_store($export_store_data, $export_store_id);
                $export_store_id = $export_store_data['export_store_id'];
            }

            foreach ($ids as $id2 => $id) {//vl id
                foreach ($quantitys as $quantity2 => $quantity) {//vl quantity
                    if ($id2 == $quantity2) {
                        foreach ($quantity_exports as $quantity_export2 => $quantity_export) {//vl quantity_export
                            if ($quantity2 == $quantity_export2) {
                                foreach ($cost_price_exports as $cost_price_export2 => $cost_price_export) {//vl cost_price_export
                                    if ($quantity_export2 == $cost_price_export2) {
                                        $item_info2 = $this->Item->get_info($id);
                                        $warehouse_items[] = array(
                                            'item_id' => $id,
                                            'quantity' => $quantity,
                                            'quantity_export' => $quantity_export,
                                            'cost_price_export' => $cost_price_export,
                                            'unit_export' => $item_info2->quantity_first == 0 ? $item_info2->unit : $item_info2->unit_from
                                        );
                                    }
                                }
                            }
                        }
                    }
                }
            }
            foreach ($warehouse_items as $key => $val) {
                $item_info = $this->Item->get_info($val['item_id']);
                //save export_store_item
                $export_store_item_data[] = array(
                    'export_store_id' => $export_store_id,
                    'item_id' => $val['item_id'],
                    'quantity_export' => $val['quantity_export'],
                    'cost_price_export' => $val['cost_price_export'],
                    'unit_export' => $val['unit_export'],
                    'unit_convert' => 0,
                );
                $this->Create_invetory->save_export_store_item($export_store_item_data, $export_store_id);
            }
        } else if ($form_export == 1) {
            $quantity_exports = str_replace(",", "", $this->input->post('quantity_export2')); //sl xuat
            $item_production_id = $this->input->post("item_production_id");
            $store = $this->input->post('store');
            $quantity_requests = str_replace(",", "", $this->input->post("quantity_request"));
            $cost_price_exports = str_replace(",", "", $this->input->post('cost_price_export')); //gia xuat
            $tk_no = $this->input->post('tk_no');
            $tk_co = $this->input->post('tk_co');
            $item_kit_id = $this->input->post('item_kit_id');
            $money = 0;
            foreach ($ids as $id2 => $id) {//vl id
                foreach ($quantitys as $quantity2 => $quantity) {//vl quantity
                    if ($id2 == $quantity2) {
                        foreach ($quantity_exports as $quantity_export2 => $quantity_export) {//vl quantity_export
                            if ($quantity2 == $quantity_export2) {
                                foreach ($cost_price_exports as $cost_price_export2 => $cost_price_export) {//vl cost_price_export
                                    if ($quantity_export2 == $cost_price_export2) {
                                        foreach ($quantity_requests as $key => $quantity_request) {
                                            if ($cost_price_export2 == $key) {
                                                $item_info2 = $this->Item->get_info($id);
                                                $warehouse_items[] = array(
                                                    'item_id' => $id,
                                                    'quantity' => $quantity,
                                                    'quantity_request' => $quantity_request,
                                                    'quantity_export' => $quantity_export,
                                                    'cost_price_export' => $cost_price_export,
                                                    'unit_export' => $item_info2->quantity_first == 0 ? $item_info2->unit : $item_info2->unit_from
                                                );
                                                $money += $quantity_export * $cost_price_export;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $export_store_data = array(
                'date_export' => date('Y-m-d H:i:s'),
                'status' => 0,
                'follow' => 0,
                'store_id' => $store,
                'employee_id' => $employee_id,
                'comment' => $comment,
                'form' => 1,
                'item_production_id' => $item_production_id,
                'tk_no' => $tk_no,
                'tk_co' => $tk_co
            );
            $this->Create_invetory->save_export_store($export_store_data, $export_store_id);
            if (!$export_store_id) {
                $export_store_id = $export_store_data['export_store_id'];
            }
            //save costs
            $cost_data = array(
                'money' => $money,
                'date' => date('Y-m-d H:i:s'),
                'tk_no' => $tk_no,
                'tk_co' => $tk_co,
                'cost_date_ct' => date('Y-m-d'),
                'comment' => "Thu tiền xuất kho từ mã đơn hàng $export_store_id",
                'cost_employees' => $this->session->userdata('person_id'),
                'export_store_id' => $export_store_id,
                'item_kit_id' => $item_kit_id
            );
            $id_cost = $export_store_id ? $this->Cost->get_info_by_export_store_id($export_store_id)->id_cost : -1;
            $this->Cost->save($cost_data, $id_cost);

            //save_export_store_item
            foreach ($warehouse_items as $key => $val) {
                $item_info = $this->Item->get_info($val['item_id']);
                //save export_store_item
                $export_store_item_data[] = array(
                    'export_store_id' => $export_store_id,
                    'item_id' => $val['item_id'],
                    'quantity_request' => $val['quantity_request'],
                    'quantity_export' => $val['quantity_export'],
                    'cost_price_export' => $val['cost_price_export'],
                    'unit_export' => $val['unit_export'],
                    'unit_convert' => 0,
                );
                $this->Create_invetory->save_export_store_item($export_store_item_data, $export_store_id);
            }
        } else {
            $quantity_exports = str_replace(",", "", $this->input->post('quantity_export2')); //sl xuat
            $request_template_id = $this->input->post("request_template_id");
            $store = $this->input->post('store');
            $quantity_requests = str_replace(",", "", $this->input->post("quantity_request"));
            $cost_price_exports = str_replace(",", "", $this->input->post('cost_price_export')); //gia xuat
            $money = 0;
            foreach ($ids as $id2 => $id) {//vl id
                foreach ($quantitys as $quantity2 => $quantity) {//vl quantity
                    if ($id2 == $quantity2) {
                        foreach ($quantity_exports as $quantity_export2 => $quantity_export) {//vl quantity_export
                            if ($quantity2 == $quantity_export2) {
                                foreach ($cost_price_exports as $cost_price_export2 => $cost_price_export) {//vl cost_price_export
                                    if ($quantity_export2 == $cost_price_export2) {
                                        foreach ($quantity_requests as $key => $quantity_request) {
                                            if ($cost_price_export2 == $key) {
                                                $item_info2 = $this->Item->get_info($id);
                                                $warehouse_items[] = array(
                                                    'item_id' => $id,
                                                    'quantity' => $quantity,
                                                    'quantity_request' => $quantity_request,
                                                    'quantity_export' => $quantity_export,
                                                    'cost_price_export' => $cost_price_export,
                                                    'unit_export' => $item_info2->quantity_first == 0 ? $item_info2->unit : $item_info2->unit_from
                                                );
                                                $money += $quantity_export * $cost_price_export;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $export_store_data = array(
                'date_export' => date('Y-m-d H:i:s'),
                'status' => 0,
                'follow' => 0,
                'store_id' => $store,
                'employee_id' => $employee_id,
                'comment' => $comment,
                'form' => 2,
                'request_template_id' => $request_template_id
            );
            $this->Create_invetory->save_export_store($export_store_data, $export_store_id);
            if (!$export_store_id) {
                $export_store_id = $export_store_data['export_store_id'];
            }
            //save costs
            $cost_data = array(
                'money' => $money,
                'date' => date('Y-m-d H:i:s'),
                'cost_date_ct' => date('Y-m-d'),
                'comment' => "Thu tiền xuất kho từ mã đơn hàng $export_store_id",
                'cost_employees' => $this->session->userdata('person_id'),
                'export_store_id' => $export_store_id
            );
            $id_cost = $export_store_id ? $this->Cost->get_info_by_export_store_id($export_store_id)->id_cost : -1;
            $this->Cost->save($cost_data, $id_cost);

            //save_export_store_item
            foreach ($warehouse_items as $key => $val) {
                $item_info = $this->Item->get_info($val['item_id']);
                //save export_store_item
                $export_store_item_data[] = array(
                    'export_store_id' => $export_store_id,
                    'item_id' => $val['item_id'],
                    'quantity_request' => $val['quantity_request'],
                    'quantity_export' => $val['quantity_export'],
                    'cost_price_export' => $val['cost_price_export'],
                    'unit_export' => $val['unit_export'],
                    'unit_convert' => 0,
                );
                $this->Create_invetory->save_export_store_item($export_store_item_data, $export_store_id);
            }
        }
        $data['export_store_id'] = $export_store_id;
        $data['store'] = $store;
        $data['export_store_item_data'] = $export_store_item_data;
        $data['comment'] = $comment;
        $this->load->view('create_invetorys/export_store_a5', $data);
        $this->receiving_lib->clear_all();
        $this->receiving_lib->clear_cate();
    }
    //Hưng Audi 0000 Oct 29
    // hello HallOweeN (^_^)  
    function view_export_store($export_store_id){
        $data['HallOweeN'] = 8;
        $info_export_store = $this->Create_invetory->get_info_export_store($export_store_id);
        $data['export_store_id'] = $export_store_id;
        $data['store'] = $info_export_store->store_id;
        $data['comment'] = $info_export_store->comment;
        $data['date_export'] = $info_export_store->date_export;
        $data['export_store_item_data'] = $this->Create_invetory->get_export_store_item_by_id($export_store_id)->result_array();
        $this->load->view('create_invetorys/export_store_a5', $data);
        $this->receiving_lib->clear_all();
        $this->receiving_lib->clear_cate();
    }
    

    function approve($export_store_id = -1) {
        $data['export_store_id'] = $export_store_id;
        $data['info_export_store'] = $this->Create_invetory->get_info_export_store($export_store_id);
        $data['info_export_store_item'] = $this->Create_invetory->get_export_store_item_by_id($export_store_id)->result();
        $this->load->view('create_invetorys/approve', $data);
    }

    function save_approve($export_store_id) {
        $export_store_info = $this->Create_invetory->get_info_export_store($export_store_id);
        $export_store_item = $this->Create_invetory->get_export_store_item_by_id($export_store_id)->result();
        $data_export_store = array(
            'status' => 1
        );
        if ($this->Create_invetory->save_export_store($data_export_store, $export_store_id)) {
            foreach ($export_store_item as $item) {
                $export_store_item = $this->Create_invetory->get_info_export_store_item($export_store_id, $item->item_id);
                $item_info = $this->Item->get_info($item->item_id);
                $quantity = $export_store_info->store_id == 0 ? $item_info->quantity_total : $this->Item->get_info_warehouse_items($item->item_id, $export_store_info->store_id)->quantity;
                //save tong sl
                $data_items = array(
                    'quantity' => $item_info->quantity - $item->quantity_export
                );
                $this->Item->saveWarehouseItems_total($data_items, $item->item_id);

                //save qty kho
                $id_kho = $this->Item->get_id_kho($item->item_id, $export_store_info->store_id);    //id kho #
                if ($export_store_info->store_id != 0) {
                    $data = array(
                        'quantity' => $quantity - $item->quantity_export
                    );
                    $this->Item->update_quantity_store($id_kho, $data);
                } else {
                    $data = array(
                        'quantity_total' => $quantity - $item->quantity_export
                    );
                    $this->Item->update_quantity($item->item_id, $data);
                }

                //save inventory
                $inv_data = array(
                    'trans_items' => $item->item_id,
                    'trans_user' => $export_store_info->employee_id,
                    'trans_date' => date('Y-m-d H:i:s'),
                    'trans_money' => $item->cost_price_export,
                    'trans_catid' => $item->unit_export,
                    'trans_comment' => 'EXP',
                    'trans_inventory' => (0 - $item->quantity_export),
                    'store_id' => $export_store_info->store_id,
                );
                $this->Inventory->insert($inv_data);
            }

            //Cap nhat lai trang thai phieu yeu cau san xuat da xuat kho het
            //Lay danh sach tat ca cac mat hang
            $info_item_production = $this->Item_kit->get_info_item_production($export_store_info->item_production_id);
            $info_request = $this->Item_kit->get_info_item_production_by_request_id($info_item_production->request_id);
            $item_request_feature = $this->Item_kit->get_feature_in_request_feature($info_item_production->request_id);
            $arr = array();
            $arr1 = array();
            foreach ($item_request_feature as $request_feature) {
                $request_feature_size = $this->Item_kit->get_size_by_request_feature($info_request->request_id, $request_feature->feature_id);
                $info_material = $this->Item_kit->get_info_formula_materials($request_feature->feature_id);
                foreach ($info_material as $material) {
                    $total_size = 0;
                    foreach ($request_feature_size as $val) {
                        $total_size += $val->quantity;
                    }
                    $arr1[$material['item_id']] += $total_size * $material['quantity'];
                }
            }
            //Lay tong so luong da duoc xuat cua tat ca cac mat hang
            $export_store_ids = $this->Create_invetory->get_export_store_by_item_production_id($export_store_info->item_production_id);
            $mang_ids = array();
            foreach ($export_store_ids as $val) {
                $mang_ids[] = $val->export_store_id;
            }
            foreach ($arr1 as $key => $val) {
                $get_sum_exported = $this->Create_invetory->get_sum_quantity_exported($mang_ids, $key);
                if ($get_sum_exported->quantity_exported == $get_sum_exported->quantity_request) {
                    $arr[] = $key;
                }
            }
            //so sanh so luong cac mat hang da xuat het voi so luong cac mat hang can xuat
            if (count($arr) == count($arr1)) {
                $data = array("export_store" => 1);
                $this->Create_invetory->update_item_production_by_id($data, $export_store_info->item_production_id);
            }

            //Cap nhat lai trang thai phieu yeu cau san xuat mau da xuat kho het
            //Lay danh sach tat ca cac mat hang/Lay so luong 
            if ($export_store_info->request_template_id) { //neu ton tai ma phieu yeu cau sx mau
                //Lay thong tin request_id trong bang item_kit_request_production_template => ma thuoc tinh, so luong yeu cau
                $data_request_production_template = $this->Item_kit->get_info_request_production_template_by_request_id($export_store_info->request_template_id);
                //Lay thong tin cac hoa don xuat kho theo ma phieu yeu cau sx mau da xac nhan
                $data_export_store_template = $this->Create_invetory->get_export_store_item_by_request_template_id($export_store_info->request_template_id);
                //Lay danh sach cac NVL co trong CT sx mau
                $info_item_formula_material = $this->Item_kit->get_info_formula_materials($data_request_production_template->feature_id);
                $arr_export_id = array(); //mang danh sach cac phieu xuat kho
                $check_arr = array();
                foreach ($data_export_store_template as $val) {
                    $arr_export_id[] = $val->export_store_id;
                }
                foreach ($info_item_formula_material as $val1) {
                    $get_sum_exported = $this->Create_invetory->get_sum_quantity_exported($arr_export_id, $val1['item_id']);
                    if ($get_sum_exported->quantity_exported != $get_sum_exported->quantity_request) {
                        $check_arr[] = $val1['item_id'];
                    }
                }
                if (count($check_arr) == 0) {
                    $data = array("export_store" => 1);
                    $this->Create_invetory->update_request_production_template_by_request_id($data, $export_store_info->request_template_id);
                }
            }
            echo json_encode(array('success' => true, 'message' => 'Xác nhận thành công hóa đơn xuất kho - ' . $export_store_id));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Lỗi xác nhận hóa đơn xuất kho' . $export_store_id));
        }
    }

    function search_export_store() {
        $start_date1 = $this->input->post('start_date');
        $end_date1 = $this->input->post('end_date');
        $tam = $end_date1;
        $tam .='23:59:59';
        $start_date = date('Y-m-d H:i:s', strtotime($start_date1));
        $end_date = date('Y-m-d H:i:s', strtotime($tam));

        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Create_invetory->search_export_store(
                $start_date, $end_date, $search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'export_store_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
        );
        $config['base_url'] = site_url('create_invetorys/search_export_store');
        $config['total_rows'] = $this->Create_invetory->search_count_all_export_store($start_date, $end_date, $search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_export_store_manage_table_data_rows($search_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function delete_export_store_item() {
        $ids = $this->input->post("ids");
        foreach ($ids as $id) {
            $this->Create_invetory->delete_export_store_item($id);
            $this->Create_invetory->delete_export_store($id);
        }
        echo json_encode(array("success" => true, "message" => "Xóa thành công " . count($ids) . " hóa đơn"));
    }

    function search_order_request() {
        $suggestions = $this->Create_invetory->get_search_order_request($this->input->get('term'));
        echo json_encode($suggestions);
    }

    function get_list_item_material() {
        $str = "";
        $str .= "<tbody>";
        $request_id = $this->input->post("request_id");
        $info_request = $this->Item_kit->get_info_item_production_by_request_id($request_id);
        $item_request_feature = $this->Item_kit->get_feature_in_request_feature($request_id);
        $arr = array();
        foreach ($item_request_feature as $request_feature) {
            $request_feature_size = $this->Item_kit->get_size_by_request_feature($info_request->request_id, $request_feature->feature_id);
            $info_material = $this->Item_kit->get_info_formula_materials($request_feature->feature_id);
            foreach ($info_material as $material) {
                $total_size = 0;
                foreach ($request_feature_size as $val) {
                    $total_size += $val->quantity;
                }
                $arr[$material['item_id']] += $total_size * $material['quantity'];
            }
        }


        foreach ($arr as $key => $value) {
            $info_item_formula_materials = $this->Item_kit->get_info_formula_materials_item($key);
            $info_item = $this->Item->get_info($key);
            $unit = $info_item->quantity_first == 0 ? $info_item->unit : $info_item->unit_from;
            $info_unit = $this->Unit->get_info($unit);
            $info_store_material = $this->Create_invetory->check_exist_store_materials();
            $info_item_material = $this->Item->get_id_Items_warehouse($info_store_material['id'], $key);
            $export_store_ids = $this->Create_invetory->get_export_store_by_item_production_id($info_request->id);
            $mang_ids = array();
            foreach ($export_store_ids as $val) {
                $mang_ids[] = $val->export_store_id;
            }
            $norms_item_info = $this->Item_kit->get_info_item_kit_norms_item($request_id, $key);
            $qty_total = $norms_item_info->quantity_total ? $norms_item_info->quantity_total : $value;

            if (count($mang_ids) > 0) {
                $get_sum_exported = $this->Create_invetory->get_sum_quantity_exported($mang_ids, $key);
                if ($get_sum_exported->quantity_exported < $get_sum_exported->quantity_request) {
                    $str .= "<tr><input type='hidden' value='$info_request->item_kit_id' name='item_kit_id' />";
                    $str .= "<td style='text-align: center'><a href='#' onclick='return deleteItemKitRow(this);' title='Xóa' id='delete'>X</a></td>";
                    $str .= "<td style='text-align: center'><input id='item_id_$key' type='hidden' value='$key' name='item_id[$key]' class='item_id' />$info_item->item_number</td>";
                    $str .= "<td>$info_item->name</td>";
                    $str .= "<td>$info_unit->name</td>";
                    $str .= "<td style='text-align: right'><input id='quantity_$key' type='text' value='" . format_quantity($info_item_material->quantity) . "' name='quantity[$key]' class='quantity' readonly size=8 /></td>";
                    $str .= "<td style='text-align: right'><input id='quantity_request_$key' type='text' value='" . format_quantity($qty_total) . "' name='quantity_request[$key]' class='quantity_request' readonly size=8 /></td>";
                    $str .= "<td style='text-align: right'><input id='quantity_exported_$key' type='text' value='" . format_quantity($get_sum_exported->quantity_exported) . "' name='quantity_exported[$key]' class='quantity_exported' readonly size='8'></td>";
                    $str .= "<td style='text-align: center'><input id='quantity_export_$key' type='text' value='0' size=6 name='quantity_export2[$key]' class='quantity_export' onchange='calculateSuggestedPricesRequest();' /></td>";
                    $str .= "<td style='text-align: right'><input id='cost_price_export_$key' type='text' size=16 value='" . number_format($info_item->quantity_first == 1 ? $info_item->cost_price_rate : $info_item->cost_price) . "' name='cost_price_export[$key]' class='cost_price_export' readonly onchange='calculateSuggestedPricesRequest();' /></td>";
                    $str .= "<td style='text-align: right'><input id='money_$key' type='text' size=20 value='0' name='money[$key]' class='money' onchange='calculateSuggestedPricesRequest();' readonly /></td>";
                    $str .= "</tr>";
                }
            } else {
                $str .= "<tr><input type='hidden' value='$info_request->item_kit_id' name='item_kit_id' class='item_kit_id'/>";
                $str .= "<td style='text-align: center'><a href='#' onclick='return deleteItemKitRow(this);' title='Xóa' id='delete'>X</a></td>";
                $str .= "<td style='text-align: center'><input id='item_id_$key' type='hidden' value='$key' name='item_id[$key]' class='item_id' />$info_item->item_number</td>";
                $str .= "<td>$info_item->name</td>";
                $str .= "<td>$info_unit->name</td>";
                $str .= "<td style='text-align: right'><input id='quantity_$key' type='text' value='" . format_quantity($info_item_material->quantity) . "' name='quantity[$key]' class='quantity' readonly size=8 /></td>";
                $str .= "<td style='text-align: right'><input id='quantity_request_$key' type='text' value='" . format_quantity($qty_total) . "' name='quantity_request[$key]' class='quantity_request' readonly size=8 /></td>";
                $str .= "<td style='text-align: right'><input id='quantity_exported_$key' type='text' value='0' name='quantity_exported[$key]' class='quantity_exported' readonly size='8'></td>";
                $str .= "<td style='text-align: center'><input id='quantity_export_$key' type='text' value='0' size=6 name='quantity_export2[$key]' class='quantity_export' onchange='calculateSuggestedPricesRequest();' /></td>";
                $str .= "<td style='text-align: right'><input id='cost_price_export_$key' type='text' size=16 value='" . number_format($info_item->quantity_first == 1 ? $info_item->cost_price_rate : $info_item->cost_price) . "' name='cost_price_export[$key]' class='cost_price_export' readonly onchange='calculateSuggestedPricesRequest();' /></td>";
                $str .= "<td style='text-align: right'><input id='money_$key' type='text' size=20 value='0' name='money[$key]' class='money' onchange='calculateSuggestedPricesRequest();' readonly /></td>";
                $str .= "</tr>";
            }
        }

        $str .= "</tbody>";
        echo $str;
    }

//    end Loi
    function search_order_pro_template() {
        $suggestions = $this->Create_invetory->get_search_order_pro_template($this->input->get('term'));
        echo json_encode($suggestions);
    }

    function get_list_item_of_request() {        
        $request_id = $this->input->post("request_id");        
        $info_request = $this->Item_kit->get_info_request_production_template_by_request_id($request_id);
        $feature = $this->Item_kit->get_info_formula_materials($info_request->feature_id);
        $str = "";
        foreach ($feature as $row) {
            $info_item = $this->Item->get_info($row['item_id']);
            $info_store_material = $this->Create_invetory->check_exist_store_materials();
            $info_item_material = $this->Item->get_id_Items_warehouse($info_store_material['id'], $row['item_id']);
            $unit = $info_item->quantity_first == 0 ? $info_item->unit : $info_item->unit_from;
            $info_unit = $this->Unit->get_info($unit);
            $export_store_ids = $this->Create_invetory->get_export_store_by_request_template_id($request_id);
            $mang_ids = array();
            foreach ($export_store_ids as $val) {
                $mang_ids[] = $val->export_store_id;
            }
            if (count($mang_ids) > 0) {
                $get_sum_exported = $this->Create_invetory->get_sum_quantity_exported($mang_ids, $row['item_id']);
                if ($get_sum_exported->quantity_exported < $get_sum_exported->quantity_request) {
                    $str .= "<tr> <input type='hidden' value='$request_id' name='request_template_id' />";
                    $str .= "<td style='text-align: center'><a href='#' onclick='return deleteItemKitRow(this);' title='Xóa' id='delete'>X</a></td>";
                    $str .= "<td style='text-align: center'><input id='item_id_" . $row['item_id'] . "' type='hidden' value='" . $row['item_id'] . "' name='item_id[" . $row['item_id'] . "]' class='item_id' />$info_item->item_number</td>";
                    $str .= "<td>$info_item->name</td>";
                    $str .= "<td>$info_unit->name</td>";
                    $str .= "<td style='text-align: right'><input id='quantity_" . $row['item_id'] . "' type='text' value='" . format_quantity($info_item_material->quantity) . "' name='quantity[" . $row['item_id'] . "]' class='quantity' readonly size=8 /></td>";
                    $str .= "<td style='text-align: right'><input id='quantity_request_" . $row['item_id'] . "' type='text' value='" . format_quantity($info_request->quantity_request * $row['quantity']) . "' name='quantity_request[" . $row['item_id'] . "]' class='quantity_request' readonly size=8 /></td>";
                    $str .= "<td style='text-align: right'><input id='quantity_exported_" . $row['item_id'] . "' type='text' value='" . format_quantity($get_sum_exported->quantity_exported) . "' name='quantity_exported[" . $row['item_id'] . "]' class='quantity_exported' readonly size=8 /></td>";
                    $str .= "<td style='text-align: center'><input id='quantity_export_" . $row['item_id'] . "' type='text' value='0' size=6 name='quantity_export2[" . $row['item_id'] . "]' class='quantity_export' onchange='calculateSuggestedPricesRequestTemplate();' /></td>";
                    $str .= "<td style='text-align: right'><input id='cost_price_export_" . $row['item_id'] . "' type='text' size=16 value='" . number_format($info_item->quantity_first == 1 ? $info_item->cost_price_rate : $info_item->cost_price) . "' name='cost_price_export[" . $row['item_id'] . "]' class='cost_price_export' readonly onchange='calculateSuggestedPricesRequestTemplate();' /></td>";
                    $str .= "<td style='text-align: right'><input id='money_" . $row['item_id'] . "' type='text' size=20 value='0' name='money[" . $row['item_id'] . "]' class='money' onchange='calculateSuggestedPricesRequestTemplate();' readonly /></td>";
                    $str .= "</tr>";
                }
            } else {
                $str .= "<tr> <input type='hidden' value='$request_id' name='request_template_id' />";
                $str .= "<td style='text-align: center'><a href='#' onclick='return deleteItemKitRow(this);' title='Xóa' id='delete'>X</a></td>";
                $str .= "<td style='text-align: center'><input id='item_id_" . $row['item_id'] . "' type='hidden' value='" . $row['item_id'] . "' name='item_id[" . $row['item_id'] . "]' class='item_id' />$info_item->item_number</td>";
                $str .= "<td>$info_item->name</td>";
                $str .= "<td>$info_unit->name</td>";
                $str .= "<td style='text-align: right'><input id='quantity_" . $row['item_id'] . "' type='text' value='" . format_quantity($info_item_material->quantity) . "' name='quantity[" . $row['item_id'] . "]' class='quantity' readonly size=8 /></td>";
                $str .= "<td style='text-align: right'><input id='quantity_request_" . $row['item_id'] . "' type='text' value='" . format_quantity($info_request->quantity_request * $row['quantity']) . "' name='quantity_request[" . $row['item_id'] . "]' class='quantity_request' readonly size=8 /></td>";
                $str .= "<td style='text-align: right'><input id='quantity_exported_" . $row['item_id'] . "' type='text' value='0' name='quantity_exported[" . $row['item_id'] . "]' class='quantity_exported' readonly size=8 /></td>";
                $str .= "<td style='text-align: center'><input id='quantity_export_" . $row['item_id'] . "' type='text' value='0' size=6 name='quantity_export2[" . $row['item_id'] . "]' class='quantity_export' onchange='calculateSuggestedPricesRequestTemplate();' /></td>";
                $str .= "<td style='text-align: right'><input id='cost_price_export_" . $row['item_id'] . "' type='text' size=16 value='" . number_format($info_item->quantity_first == 1 ? $info_item->cost_price_rate : $info_item->cost_price) . "' name='cost_price_export[" . $row['item_id'] . "]' class='cost_price_export' readonly onchange='calculateSuggestedPricesRequestTemplate();' /></td>";
                $str .= "<td style='text-align: right'><input id='money_" . $row['item_id'] . "' type='text' size=20 value='0' name='money[" . $row['item_id'] . "]' class='money' onchange='calculateSuggestedPricesRequestTemplate();' readonly /></td>";
                $str .= "</tr>";
            }
        }
        echo $str;
    }
}

/* End of file create_invetorys.php */
/* Location: ./application/controllers/create_invetorys.php */