<?php

require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");

class Categories extends Secure_area {

    function __construct() {
        parent::__construct('categories');
        $this->load->library('sale_lib');
        $this->load->library('receiving_lib');
        $this->load->model('Category');
    }

    function view($id_cat = -1) {
        $this->check_action_permission('add_update');
        $data = array();
        $data['item_info'] = $this->Category->get_info($id_cat);
        $data['cat_service'] = $this->Service->get_all_cat_service();
        $this->load->view("category/form", $data);
    }

    function index() {
        $config['base_url'] = site_url('categories/sorting');
        $config['total_rows'] = $this->Category->count_all();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['form_height'] = $this->get_form_height();
        $data['total_rows'] = $this->Category->count_all();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_categories_manage_table($this->Category->get_all1($data['per_page']), $this);
        $data['categories'] = $this->Category->get_all();
        $this->load->view('category/manage', $data);
    }

    //check trùng tên
    function checkname($id) {
        $name = $this->input->post('name');
        $d['name'] = $this->Category->getname($id);
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

    function suggest() {
        $suggestions = $this->Category->get_search_suggestions($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    function item_search() {
        $suggestions = $this->Category->get_category_search_suggestions($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    function sorting() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search) {
            $config['total_rows'] = $this->Category->search_count_all($search);
            $table_data = $this->Category->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        } else {
            $config['total_rows'] = $this->Category->count_all();
            $table_data = $this->Category->get_all1($per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id_cat', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        }
        $config['base_url'] = site_url('categories/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_categories_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function search() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $cat_service = $this->input->post('cat');
        //$per_page= 50;
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;

        $search_data = $this->Category->search($search, $cat_service, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id_cat', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        $config['base_url'] = site_url('categories/search');
        $config['total_rows'] = $this->Category->search_count_all($search, $cat_service);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_categories_manage_table_data_rows($search_data, $this);

        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function save_cat() {
        $id = $_POST['id'];
        $value = array('name' => $_POST['value']);
        $this->Category->update_cat($id, $value);
    }

     function save($id_cat = -1) {
        $this->check_action_permission('add_update');
        $chuoi = $this->input->post('name_item');
        $str = $this->Category->vn_str_filter("$chuoi");
        $str = str_replace(" ", "-", $str); // replate khoang trang = dau -
        $str = strtolower($str); // bo viet hoa
        if ($this->input->post("submit_item")) {
            $item_data = array(
                'code_cat'    => $this->input->post("code_cat_item"),
                'name'        => $this->input->post('name_item'),
                'en_name'     => $this->input->post('en_name'),
                'parentid'    => $this->input->post('category_item'),
                'active'      => $this->input->post('active'),
                'cat_service' => 0,
                'url'         => $str,
            );

            /* Upload image */
            $config['upload_path'] = './upload/categories';
            $config['allowed_types'] = 'gif|jpg|png';

            $this->load->library('upload', $config);
            if ($this->upload->do_upload('image')) {
                $data_img = $this->upload->data();
                $item_data['image'] = 'upload/categories/'.$data_img['file_name'];
            }

            if ($this->Category->save($item_data, $id_cat)) {
                //New item
                if ($id_cat == -1) {
                    echo json_encode(array('success' => true, 'message' => 'Thêm mới nhóm mặt hàng (' . $item_data['name'] . ') thành công!', 'id_cat' => $item_data['id_cat']));
                    $id_cat = $item_data['id_cat'];
                } else { //previous item

                    echo json_encode(array('success' => true, 'message' => 'Sửa nhóm mặt hàng (' . $item_data['name'] . ') thành công!', 'id_cat' => $item_data['id_cat']));
                }
            } else {//failure
                echo json_encode(array('success' => false, 'message' => 'Lỗi thêm hoặc cập nhật nhóm mặt hàng (' . $item_data['name'] . ')!', 'id_cat' => -1));
            }
        } else {
            $ser_chuoi = $this->input->post('name_service');
            $str = $this->Category->vn_str_filter("$ser_chuoi");
            $str = str_replace(" ", "-", $str); // replate khoang trang = dau -
            $str = strtolower($str); // bo viet hoa
            $service_data = array(
                'code_cat'    => $this->input->post("code_cat_service"),
                'name'        => $this->input->post('name_service'),
                'en_name'     => $this->input->post('en_name_service'),
                'parentid'    => $this->input->post('category_service'),
                'active'      => $this->input->post('active'),
                'cat_service' => 1,
                'url'         => $str,
            );

            /* Upload image */
            $config['upload_path'] = './upload/categories';
            $config['allowed_types'] = 'gif|jpg|png';

            $this->load->library('upload', $config);
            if ($this->upload->do_upload('image')) {
                $data_img = $this->upload->data();
                $service_data['image'] = 'upload/categories/'.$data_img['file_name'];
            }

            if ($this->Category->save($service_data, $id_cat)) {
                //New item
                if ($id_cat == -1) {
                    echo json_encode(array('success' => true, 'message' => 'Thêm mới nhóm dịch vụ (' . $service_data['name'] . ') thành công!', 'id_cat' => $service_data['id_cat']));
                    $id_cat = $service_data['id_cat'];
                } else { //previous item
                    echo json_encode(array('success' => true, 'message' => 'Sửa nhóm dịch vụ (' . $service_data['name'] . ') thành công!', 'id_cat' => $service_data['id_cat']));
                }
            } else {//failure
                echo json_encode(array('success' => false, 'message' => 'Lỗi thêm hoặc cập nhật nhóm dịch vụ (' . $service_data['name'] . ')!', 'id_cat' => -1));
            }
        }
    }
    /*
      Gives search suggestions based on what is being searched for
     */

    function suggest_category() {
        $suggestions = $this->Category->get_category_suggestions($this->input->get('term'));
        echo json_encode($suggestions);
    }

    function get_row() {
        $id_cat = $this->input->post('row_id');
        $data_row = get_item_data_row($this->Category->get_info($id_cat), $this);
        echo $data_row;
    }

    function get_info($id_cat = -1) {
        echo json_encode($this->Category->get_info($id_cat));
    }

    // dem so dong khi check all
    function category_item_number_exists() {
        if ($this->Category->account_number_exists($this->input->post('id_cat')))
            echo 'false';
        else
            echo 'true';
    }

    function delete() {
        $this->check_action_permission('delete');
        $categories_to_delete = $this->input->post('ids');
        $select_inventory = $this->get_select_inventory();
        $total_rows = $select_inventory ? $this->Category->count_all1() : count($categories_to_delete);
        //clears the total inventory selection
        $this->clear_select_inventory();
        $name_category = array();
        foreach ($categories_to_delete as $value) {
            $check_item = $this->Category->check_exist_item_in_category($value);
            $check_item_kit = $this->Category->check_exist_item_kit_in_category($value);
            $info_category = $this->Category->get_info($value);
            if ($check_item || $check_item_kit) {
                $check = 0;
                $name_category[] = $info_category->name;
            } else {
                $check = 1;
            }
        }
        if ($check == 0) {
            $msg = "";
            for ($i = 0; $i < count($name_category); $i++) {
                $msg .= $name_category[$i] . ", ";
            }
            echo json_encode(array('success' => false, 'message' => 'Lỗi xóa không thành công! nhóm mặt hàng - dịch vụ (' . $msg . ') có chứa mặt hàng hoặc dịch vụ'));
        } else {
            $this->Category->delete_list($categories_to_delete);
            echo json_encode(array('success' => true, 'message' => 'Bạn đã xóa thành công nhóm mặt hàng - dịch vụ ' . $msg));
        }
//        if ($this->Category->delete_list($categories_to_delete)) {
//
//            echo json_encode(array('success' => true, 'message' => lang('items_cate_successful_deleted')));
//        } else {
//            echo json_encode(array('success' => false, 'message' => lang('items_cate_cannot_be_deleted')));
//        }
    }

    //khi chon all thong bao all so mat hang
    function select_inventory() {
        $this->session->set_userdata('select_inventory', 1);
    }

    function get_select_inventory() {
        return $this->session->userdata('select_inventory') ? $this->session->userdata('select_inventory') : 0;
    }

    function clear_select_inventory() {
        $this->session->unset_userdata('select_inventory');
    }

    function get_form_width() {
        return 400;
    }

    function get_form_height() {
        return 300;
    }

    function set_category() {
        $this->receiving_lib->set_cate($this->input->post("category"));
    }

}

?>
