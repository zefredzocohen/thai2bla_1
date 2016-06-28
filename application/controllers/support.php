<?php

require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");

class Support extends Secure_area {

    function __construct() {
        parent::__construct('support'); 
        $this->load->model('Support_model');
        $this->load->model('Clips_model');
    }

    function index() {
       
        $config['base_url'] = site_url('support/sorting');
        $config['total_rows'] = $this->Support_model->count_all();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['form_height'] = $this->get_form_height();
        $data['total_rows'] = $this->Support_model->count_all();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_support_manage_table($this->Support_model->get_all1($data['per_page']), $this);
        $data['units'] = $this->Support_model->get_all();
        
        $data['video_controller_name'] = 'clip';
        $data['total_rows_video'] = $this->Clips_model->count_all();
        $data['manage_video'] = get_video_manage_table($this->Clips_model->get_all1($data['per_page']), $this);
        $data['units_video'] = $this->Clips_model->get_all();
        
        $this->load->view('supports/manage', $data);
    }

    //check trùng tên
    function checkname($id) {
        $name = $this->input->post('name_support');
        $d['name'] = $this->Support_model->getname($id);
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
            $config['total_rows'] = $this->Support_model->search_count_all($search);
            $table_data = $this->Support_model->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name_support', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        } else {
            $config['total_rows'] = $this->Support_model->count_all();
            $table_data = $this->Support_model->get_all1($per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name_support', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        }
        $config['base_url'] = site_url('support/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_support_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function sorting() {
        //$this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search) {
            $config['total_rows'] = $this->Support_model->search_count_all($search);
            $table_data = $this->Support_model->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name_support', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        } else {
            $config['total_rows'] = $this->Support_model->count_all();
            $table_data = $this->Support_model->get_all1($per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name_support', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        }
        $config['base_url'] = site_url('support/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_support_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function search123() {
        //$this->check_action_permission('search');
        $search = $this->input->post('search');
        $cat = $this->input->post('cat');
        //$per_page= 50;
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Support_model->search($search, $cat, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name_support', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        $config['base_url'] = site_url('support/search');
        $config['total_rows'] = $this->Support_model->search_count_all($search, $cat);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_support_manage_table_data_rows($search_data, $this);

        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function search() {
        //$this->check_action_permission('search');
        $search = $this->input->post('search');
        //$cat=$this->input->post('cat');
        //$per_page= 50;
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Support_model->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id_support', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        $config['base_url'] = site_url('support/search');
        $config['total_rows'] = $this->Support_model->search_count_all($search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_support_manage_table_data_rows($search_data, $this);

        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function suggest() {
        $suggestions = $this->Support_model->get_search_suggestions($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }


    function savevideo($id_support = -1) {
        $this->check_action_permission('add_update');
        $item_data = array(
            'name' => $this->input->post('name'),
            'url' => $this->input->post('url'),
            'des' => $this->input->post('des'),
            'anh' => $this->input->post('anh'),
        );

        if ($this->Clips_model->save($item_data, $id_support)) {
            //New item
            if ($id_support == -1) {
                echo json_encode(array('success' => true, 'message' => 'Thêm mới Video thành công' . ' (' .
                    $item_data['name'].')', 'id' => $item_data['id']));
                $id_support = $item_data['id'];
            } else { //previous item
                echo json_encode(array('success' => true, 'message' => 'Cập nhật Video thành công' . ' (' .
                    $item_data['name'].')', 'id' => $id_support));
            }
        } else {//failure
            echo json_encode(array('success' => false, 'message' => 'Có lỗi xảy ra với video' . ' ' .
                $item_data['name'], 'id' => -1));
        }
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
    function save($id_support = -1) {
        $this->check_action_permission('add_update');
        $item_data = array(
            'name_support' => $this->input->post('name_support'),
            'yahoo' => $this->input->post('yahoo'),
            'skype' => $this->input->post('skype'),
            'phone' => $this->input->post('phone'),
        );

        if ($this->Support_model->save($item_data, $id_support)) {
            //New item
            if ($id_support == -1) {
                echo json_encode(array('success' => true, 'message' => 'Thêm mới hỗ trợ thành công' . ' (' .
                    $item_data['name_support'].')', 'id_support' => $item_data['id_support']));
                $id_support = $item_data['id_support'];
            } else { //previous item
                echo json_encode(array('success' => true, 'message' => 'Cập nhật thành công' . ' (' .
                    $item_data['name_support'].')', 'id_support' => $id_support));
            }
        } else {//failure
            echo json_encode(array('success' => false, 'message' => 'Có lỗi xảy ra' . ' ' .
                $item_data['name_support'], 'id_support' => -1));
        }
    }

    function suggest_unit() {
        $suggestions = $this->Support_model->get_unit_suggestions($this->input->get('term'));
        echo json_encode($suggestions);
    }

    function view($id_support = -1) { 
        $this->check_action_permission('add_update');   
        $data = array();  
        $data['support_info'] = $this->Support_model->get_info($id_support);
        $this->load->view("supports/form", $data);
    }
    function video_view($id_support = -1) {
        $this->check_action_permission('add_update');          
        $data_video = array();  
        $data_video['video_info'] = $this->Clips_model->get_info($id_support);
        $this->load->view("clip/form", $data_video);
    }
   

    function delete() {

        $this->check_action_permission('delete');
        $id = $this->input->post('ids');
        foreach ($id as $ids){
                $this->Support_model->delete_list($ids);
                echo json_encode(array('success' => true, 'message' => 'Bạn đã xóa thành công hỗ trợ'));
            
        }
    }




    function get_select_inventory() {
        return $this->session->userdata('select_inventory') ? $this->session->userdata('select_inventory') : 0;
    }

    function clear_select_inventory() {
        $this->session->unset_userdata('select_inventory');
    }

    function get_info($id_unit = -1) {
        echo json_encode($this->Support_model->get_info($id_unit));
    }

    function get_form_width() {
        return 360;
    }

    function get_form_height() {
        return 300;
    }

}
