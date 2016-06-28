<?php

require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");

class Bill_cost extends secure_area {

    public function __construct() {
        parent::__construct('bill_cost');
        $this->load->model('Bill_cost_model');
        $this->load->library('Receiving_lib');
        $this->load->model('Item');
        $this->load->model('Receiving_order');
    }

    public function index() {
        $this->check_action_permission('search');

        $config['base_url'] = site_url('bill_cost/sorting');
        $config['total_rows'] = $this->Bill_cost_model->count_all();
        $data['result_array'] = $this->Bill_cost_model->get_all($data['per_page']);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 10;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_bill_cost_manage_table($this->Bill_cost_model->get_all($data['per_page']), $this);
        $this->load->view('bill_cost/manage', $data);
    }

    public function sorting() {
        //$this->check_action_permission('search');

        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search) {
            $config['total_rows'] = $this->Bill_cost_model->search_count_all($search);
            $table_data = $this->Bill_cost_model->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        } else {
            $config['total_rows'] = $this->Bill_cost_model->count_all();
            $table_data = $this->Bill_cost_model->get_all($per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        }
        $config['base_url'] = site_url('bill_cost/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_bill_cost_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function search() {
        $this->check_action_permission('search');

        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Bill_cost_model->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        $config['base_url'] = site_url('bill_cost/search');
        $config['total_rows'] = $this->Bill_cost_model->search_count_all($search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_bill_cost_manage_table_data_rows($search_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function view($var_id = -1) {
        $data['chungtu_id'] = $var_id;
        $data['var_info'] = $this->Bill_cost_model->get_info($var_id);
        $this->load->view("bill_cost/form", $data);
    }

    /* 20/10/15     --;{(@  */

    function save($var_id = -1) {
        $ngay_lap = date('Y-m-d', strtotime($this->input->post('ngay_lap')));
        $date_order = date('Y-m-d', strtotime($this->input->post('date_order')));
        $var_data = array(
            'id_cus' => $this->input->post('person_id'),
            'date' => $ngay_lap,
            'content' => $this->input->post('content_ctu'),
            'id_recv' => $this->input->post('id_cost'),
            'tk_co' => $this->input->post('tk_co'),
            'symbol_order' => $this->input->post('symbol_order'),
            'number_order' => $this->input->post('number_order'),
            'date_order' => $date_order,
            'code_taxe' => $this->input->post('code_taxe'),
            'money' => str_replace(array(',', '.00'), '', $this->input->post('money')),
            'taxe_percent' => $this->input->post('taxe_percent'),
        );
        if ($this->Bill_cost_model->save($var_data, $var_id)) {

            if ($var_id == -1) {
                echo json_encode(array('success' => true, 'message' => 'Thêm mới thành công'));
            } else {
                echo json_encode(array('success' => true, 'message' => 'Cập nhật thành công'));
            }
        } else {
            echo json_encode(array('success' => true, 'message' => 'Có lỗi xảy ra'));
        }
    }

//	function get_row(){
//		$item_id = $this->input->post('row_id');
//		$data_row=get_item_data_row($this->Item->get_info($item_id),$this);
//		echo $data_row;
//	}
    public function get_row() {
        $item_id = $this->input->post('row_id');
        $data_row = get_item_data_row($this->Item->get_info($item_id), $this);
        echo $data_row;
    }

    public function delete() {

        $id = $this->input->post('ids');
        if ($this->Bill_cost_model->delete_list($id)) {
            echo json_encode(array('success' => true, 'message' => 'Xóa thành công'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Có lỗi xảy ra khi xóa'));
            echo 'that bai';
        }
    }

    function suggest() {

        $suggestions = $this->Chungtu->get_search_suggestions($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    function chungtu_search() {

        $suggestions = $this->Bill_cost_model->get_chungtu_search($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    public function get_form_width() {
        return 550;
    }

    //Hưng Audi 19-10-15 ~~~ vấn vương kỷ niệm
    function person_search_cost() {
        $suggestions = $this->Bill_cost_model->get_supplier_search_cost($this->input->get('term'), 1000);
        echo json_encode($suggestions);
    }

    function set_id_recv() {
        $this->Receiving_lib->set_id_recv($this->input->post('id_cost'));
    }

    function view_bill() {
        $this->load->view('bill_cost/view');
    }

     function approve($receiving_id) {
        $data['receiving_id'] = $receiving_id;
        $data['info_receiving'] = $this->Receiving_order->get_info_receving($receiving_id);
        $data['info_receiving_item'] = $this->Receiving_order->get_receiving_item();
        
        
        $this->load->view('bill_cost/approve', $data);
    }
    
     function info_cost(){
        $id_cost = $this->input->post('id_cost');
        $info_cost = $this->Cost->get_info($id_cost);
        echo $info_cost->id_receiving;
    }
}

?>