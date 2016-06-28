<?php
require_once(APPPATH . 'third_party/Classes/PHPExcel/IOFactory.php');
require_once(APPPATH . 'libraries/php-excel.class.php');
require_once ("secure_area.php");
class Packs extends Secure_area {
    function __construct() {
        parent::__construct('packs');
    }
	function index() {
        $this->check_action_permission('search');
        $config['base_url'] = site_url('packs/sorting');
        $config['total_rows'] = $this->Pack->count_all();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = 780;
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_packs_manage_table($this->Pack->get_all($data['per_page']), $this);
        $data['categories'] = $this->Category->get_all();
        $this->load->view('packs/manage', $data);
    }
	function sorting() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search) {
            $config['total_rows'] = $this->Pack->search_count_all($search);
            $table_data = $this->Pack->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        } else {
            $config['total_rows'] = $this->Pack->count_all();
            $table_data = $this->Pack->get_all($per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'pack_id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        }
        $config['base_url'] = site_url('packs/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_packs_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }
    function search() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $cat = $this->input->post('cat');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Pack->search(
        	$search, $cat, $per_page, 
        	$this->input->post('offset') ? $this->input->post('offset') : 0, 
        	$this->input->post('order_col') ? $this->input->post('order_col') : 'pack_id', 
        	$this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
        );
        $config['base_url'] = site_url('packs/search');
        $config['total_rows'] = $this->Pack->search_count_all($search, $cat);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_packs_manage_table_data_rows($search_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }    
	function suggest() {
        $suggestions = $this->Pack->get_search_suggestions($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }
    function view($pack_id = -1) {
        $this->check_action_permission('add_update');
        $data['pack_info'] = $this->Pack->get_info($pack_id);
        $data['default_tax_1_rate'] = ($pack_id == -1) ? $this->Appconfig->get('default_tax_1_rate') : '';
        $data['default_tax_2_rate'] = ($pack_id == -1) ? $this->Appconfig->get('default_tax_2_rate') : '';
        $data['default_tax_2_cumulative'] = ($pack_id == -1) ? $this->Appconfig->get('default_tax_2_cumulative') : '';
        $this->load->view("packs/form", $data);
    }
    function save($pack_id = -1) {//tm
    	//die('s');
        $this->check_action_permission('add_update');
        // phan them anh
        $config = array(
            "upload_path" => "./packs/",
            "allowed_types" => 'gif|jpg|png|bmp|jpeg',
            'max_size' => '6000'
        );
        $this->load->library('upload', $config);
        $images = '';
        if (!$this->upload->do_upload('pack_image')) {
            $erros = array($this->upload->display_errors());
            $pack_data = array(
                'pack_number' => $this->input->post('pack_number') == '' ? null : $this->input->post('pack_number'),
                'name' => $this->input->post('name'),
                'unit_price' => $this->input->post('unit_price') == '' ? 0 : str_replace(",", "", $this->input->post('unit_price')),
                'cost_price' => $this->input->post('cost_price') == '' ? null : str_replace(",", "", $this->input->post('cost_price')),
                'value_price' => $this->input->post('value_price') == '' ? null : str_replace(",", "", $this->input->post('value_price')),
            	'description' => $this->input->post('description'),
                'category' => $this->input->post('category'),
            	'unit' => $this->input->post('unit'),
                'location' => $this->input->post('location'),
                'discount' => $this->input->post('discount'),
                'total_quantity' => $this->input->post('total_product'),
                'total_cost' => str_replace(",", "", $this->input->post('total_cost')),
                'total_sale_price' => str_replace(",", "", $this->input->post('total_sale_price')),
                'taxes' => $this->input->post('taxes'),
                 'status_material' => $this->input->post('status_material') ? $this->input->post('status_material') : 0,
            );
        } else {
            if ($pack_id != -1) {
                $delimg = $this->Pack->get_info($pack_id);
                unlink("./packs/" . $delimg->images);
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
            $pack_data = array(
                'pack_number' => $this->input->post('pack_number') == '' ? null : $this->input->post('pack_number'),
                'name' => $this->input->post('name'),
                'unit_price' => $this->input->post('unit_price') == '' ? 0 : str_replace(",", "", $this->input->post('unit_price')),
                'cost_price' => $this->input->post('cost_price') == '' ? null : str_replace(",", "", $this->input->post('cost_price')),
                'value_price' => $this->input->post('value_price') == '' ? null : str_replace(",", "", $this->input->post('value_price')),
            	'description' => $this->input->post('description'),
                'category' => $this->input->post('category'),
            	'unit' => $this->input->post('unit'),
                'location' => $this->input->post('location'),
                'discount' => $this->input->post('discount'),
                'images' => $img,
                'total_quantity' => $this->input->post('total_product'),
                'total_cost' => str_replace(",", "", $this->input->post('total_cost')),
                'total_sale_price' => str_replace(",", "", $this->input->post('total_sale_price')),
                'taxes' => $this->input->post('taxes'),
                 'status_material' => $this->input->post('status_material') ? $this->input->post('status_material') : 0,
            );
        }
        // end phan them anh 
        if ($this->Pack->save($pack_data, $pack_id)) {
            //New item kit
            if ($pack_id == -1) {
                echo json_encode(array('success' => true, 'message' => lang('packs_successful_adding') . ' ' .
                    $pack_data['name'], 'pack_id' => $pack_data['pack_id']));
                $pack_id = $pack_data['pack_id'];
            } else { //previous item
                echo json_encode(array('success' => true, 'message' => lang('packs_successful_updating') . ' ' .
                    $pack_data['name'], 'pack_id' => $pack_id));
            }
        	if ($this->input->post('price')) {
                $pack_items = array();
                foreach ($this->input->post('price') as $item_id => $price) {
                    foreach ($this->input->post("pack_item") as $key => $a) {
                        if ($item_id == $key) {
                            foreach ($this->input->post("product_as_item") as $product_as_item => $p) {
                                if ($key == $product_as_item) {
                                    foreach ($this->input->post("quantity_inventory") as $quantity_inventory => $q_i) {
                                        if ($product_as_item == $quantity_inventory) {
                                            $pack_items[] = array(
                                               	'item_id' => $item_id,
                                                'quantity' => $a,
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
                $this->Pack_items->save($pack_items, $pack_id);
            }
        } else {//failure		
            echo json_encode(array('success' => false, 'message' => lang('packs_error_adding_updating') . ' ' .
                $pack_data['name'], 'pack_id' => -1));
        }
    }
    function delete() {
        $this->check_action_permission('delete');
        $packs_to_delete = $this->input->post('ids');
        if ($this->Pack->delete_list($packs_to_delete)) {
            echo json_encode(array('success' => true, 'message' => lang('packs_successful_deleted') . ' ' .
                count($packs_to_delete) . ' ' . lang('packs_one_or_multiple')));
        } else {
            echo json_encode(array('success' => false, 'message' => lang('packs_cannot_be_deleted')));
        }
    } 
    function get_row() {
        $pack_id = $this->input->post('row_id');
        $data_row = get_pack_data_row($this->Pack->get_info($pack_id), $this);
        echo $data_row;
    }
    //check trùng tên
    function checkname($id) {
        $name = $this->input->post('name');
        $d['name'] = $this->Pack->getname($id);
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
    function generate_barcodes($pack_ids) {
        $result = array();

        $pack_ids = explode('~', $pack_ids);
        foreach ($pack_ids as $item_kid_id) {
            $pack_info = $this->Pack->get_info($item_kid_id);

            $result[] = array('name' => $pack_info->name . ': ' . to_currency($pack_info->unit_price), 'id' => 'KIT ' . number_pad($item_kid_id, 7));
        }

        $data['items'] = $result;
        $data['scale'] = 2;
        $this->load->view("barcode_sheet", $data);
    }

    function generate_barcode_labels($pack_ids) {
        $result = array();

        $pack_ids = explode('~', $pack_ids);
        foreach ($pack_ids as $item_kid_id) {
            $pack_info = $this->Pack->get_info($item_kid_id);

            $result[] = array('name' => $pack_info->name . ': ' . to_currency($pack_info->unit_price), 'id' => 'KIT ' . number_pad($item_kid_id, 7));
        }

        $data['items'] = $result;
        $data['scale'] = 1;
        $this->load->view("barcode_labels", $data);
    }
    
    
	
}
