<?php

require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");

class Units extends Secure_area {

    function __construct() {
        parent::__construct('units');
        //$this->load->library('sale_lib');
        //$this->load->library('receiving_lib');              
    }

    function index() {
        $config['base_url'] = site_url('units/sorting');
        $config['total_rows'] = $this->Unit->count_all();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['form_height'] = $this->get_form_height();
        $data['total_rows'] = $this->Unit->count_all();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_units_manage_table($this->Unit->get_all1($data['per_page']), $this);
        $data['units'] = $this->Unit->get_all();
        $this->load->view('units/manage', $data);
    }

    //check trùng tên
    function checkname($id) {
        $name = $this->input->post('name');
        $d['name'] = $this->Unit->getname($id);
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

    function suggest234() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search) {
            $config['total_rows'] = $this->Unit->search_count_all($search);
            $table_data = $this->Unit->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        } else {
            $config['total_rows'] = $this->Unit->count_all();
            $table_data = $this->Unit->get_all1($per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        }
        $config['base_url'] = site_url('units/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_units_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function sorting() {
        //$this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search) {
            $config['total_rows'] = $this->Unit->search_count_all($search);
            $table_data = $this->Unit->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        } else {
            $config['total_rows'] = $this->Unit->count_all();
            $table_data = $this->Unit->get_all1($per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id_unit', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        }
        $config['base_url'] = site_url('units/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_units_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function search123() {
        //$this->check_action_permission('search');
        $search = $this->input->post('search');
        $cat = $this->input->post('cat');
        //$per_page= 50;
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Unit->search($search, $cat, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        $config['base_url'] = site_url('units/search');
        $config['total_rows'] = $this->Unit->search_count_all($search, $cat);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_units_manage_table_data_rows($search_data, $this);

        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function search() {
        //$this->check_action_permission('search');
        $search = $this->input->post('search');
        //$cat=$this->input->post('cat');
        //$per_page= 50;
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Unit->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id_unit', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        $config['base_url'] = site_url('units/search');
        $config['total_rows'] = $this->Unit->search_count_all($search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_units_manage_table_data_rows($search_data, $this);

        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function suggest() {
        $suggestions = $this->Unit->get_search_suggestions($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    /* function save_unit()
      {
      $id = $_POST['id'];
      $value = array(		 'name'=> $_POST['value']);		$this->Unit->update_unit($id,$value);

      } */

//	function item_search()
//	{
//		$suggestions = $this->Unit->get_unit_search_suggestions($this->input->get('term'),100);
//		echo json_encode($suggestions);
//	}    
//	function checkname( $id){
//		
//        if( $this->Unit->name_exists( $this->input->post('name'), $id ) == TRUE){
//            echo json_encode(FALSE); 	
//        } else{
//        	echo json_encode(TRUE);
//        }     
//	}
//	function save_unit()
//	{		
//		$id = $_POST['id'];		 
//		$value = array(		 'name'=> $_POST['value']);		$this->Unit->update_unit($id,$value);	
//	}
    function save($id_unit = -1) {
        $this->check_action_permission('add_update');
        $item_data = array(
            'name' => $this->input->post('name'),
        );

        if ($this->Unit->save($item_data, $id_unit)) {
            //New item
            if ($id_unit == -1) {
                echo json_encode(array('success' => true, 'message' => lang('items_successful_adding_unit') . ' (' .
                    $item_data['name'].')', 'id_unit' => $item_data['id_unit']));
                $id_unit = $item_data['id_unit'];
            } else { //previous item
                echo json_encode(array('success' => true, 'message' => lang('items_successful_updating_unit') . ' (' .
                    $item_data['name'].')', 'id_unit' => $id_unit));
            }
        } else {//failure
            echo json_encode(array('success' => false, 'message' => lang('items_error_adding_updating') . ' ' .
                $item_data['name'], 'id_unit' => -1));
        }
    }

    function suggest_unit() {
        $suggestions = $this->Unit->get_unit_suggestions($this->input->get('term'));
        echo json_encode($suggestions);
    }

//	function get_row()
//	{
//		$id_unit = $this->input->post('row_id');
//		$data_row=get_item_data_row($this->Unit->get_info($id_unit),$this);
//		echo $data_row;
//	}
//	function get_info($id_unit=-1)
//	{
//		echo json_encode($this->Unit->get_info($id_unit));
//	}	

    function view($id_unit = -1) {
        $this->check_action_permission('add_update');
        //$this->load->model('Unit');
        $data = array();
        $data['item_info'] = $this->Unit->get_info($id_unit);
//		print_r($data['item_info']);
//		die('sssssss');
        $this->load->view("units/form", $data);
    }

    // dem so dong khi check all
//	function unit_item_number_exists()
//	{
//		if($this->Unit->account_number_exists($this->input->post('id_unit')))
//		echo 'false';
//		else
//		echo 'true';
//		
//	}

    /* function suggest()
      {
      $suggestions = $this->Unit->get_search_suggestions($this->input->get('term'),100);
      echo json_encode($suggestions);
      } */

    function delete() {

        $this->check_action_permission('delete');
        $units_to_delete = $this->input->post('ids');
        $select_inventory = $this->get_select_inventory();
        $total_rows = $select_inventory ? $this->Unit->count_all1() : count($units_to_delete);
        //clears the total inventory selection
        $this->clear_select_inventory();
        if ($this->Unit->delete_list($units_to_delete)) {
            echo json_encode(array('success' => true, 'message' => 'Bạn đã xóa thành công '.$total_rows.' đơn vị sản phẩm'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Có lỗi xẩy ra khi xóa đơn vị sản phẩm'));
        }
    }

    //khi chon all thong bao all so mat hang
//	function select_inventory() 
//	{
//		$this->session->set_userdata('select_inventory', 1);
//	}
//	
//	function get_select_inventory() 
//	{
//		return $this->session->userdata('select_inventory') ? $this->session->userdata('select_inventory') : 0;
//	}
//
//	function clear_select_inventory() 	
//	{
//		$this->session->unset_userdata('select_inventory');
//		
//	}


    function get_select_inventory() {
        return $this->session->userdata('select_inventory') ? $this->session->userdata('select_inventory') : 0;
    }

    function clear_select_inventory() {
        $this->session->unset_userdata('select_inventory');
    }

    function get_info($id_unit = -1) {
        echo json_encode($this->Unit->get_info($id_unit));
    }

    function get_form_width() {
        return 360;
    }

    function get_form_height() {
        return 300;
    }

}
