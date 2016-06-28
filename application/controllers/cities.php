<?php
require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");
class cities extends Secure_area
{
	function __construct()
	{
		parent::__construct('cities');
	}
	function index() {
		$config['base_url'] = site_url('cities/sorting');
		$config['total_rows'] = $this->City->count_all();
		$config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['controller_name'] = strtolower(get_class());
		$data['total_rows'] = $this->City->count_all();
		$data['per_page'] = $config['per_page'];
		$data['manage_table'] = get_city2_manage_table($this->City->get_all($data['per_page']), $this);
		$this->load->view('cities/manage', $data);
	}
	function sorting() {
		$search = $this->input->post('search');
		$per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
		if ($search) {
			$config['total_rows'] = $this->City->search_count_all($search);
			$table_data = $this->City->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id_city', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
		} else {
			$config['total_rows'] = $this->City->count_all();
			$table_data = $this->City->get_all($per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id_city', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
		}
		$config['base_url'] = site_url('cities/sorting');
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table'] = get_city2_manage_table_data_rows($table_data, $this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
	}
	function search() {
		$search = $this->input->post('search');
		$per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
		$search_data = $this->City->search(
			$search, $per_page, 
			$this->input->post('offset') ? $this->input->post('offset') : 0, 
			$this->input->post('order_col') ? $this->input->post('order_col') : 'id_city', 
			$this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc'
		);
		$config['base_url'] = site_url('cities/search');
		$config['total_rows'] = $this->City->search_count_all($search);
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table'] = get_city2_manage_table_data_rows($search_data, $this);

		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
	}

	function suggest() {
		$suggestions = $this->City->get_search_suggestions($this->input->get('term'), 100);
		echo json_encode($suggestions);
	}
	function view($id_city = -1) {
		$this->check_action_permission('add_update');
		$data = array();
		$data['item_info'] = $this->City->get_info($id_city);
		$this->load->view("cities/form", $data);
	}
	function save($id_city = -1) {
		$this->check_action_permission('add_update');
		$item_data = array(
            'zip_code' => $this->input->post('zip_code'),
			'name' => $this->input->post('name'),
			'type' => $this->input->post('type'),
		);

		if ($this->City->save($item_data, $id_city)) {
			if ($id_city == -1) {
				echo json_encode(array('success' => true, 'message' => 'Bạn đã thêm thành phố/ tên nước thành công (' .
				$item_data['name'].')', 'id_city' => $item_data['id_city']));
				$id_city = $item_data['id_city'];
			} else {
				echo json_encode(array('success' => true, 'message' => 'Bạn đã cập nhật thành phố/ tên nước thành công (' .
				$item_data['name'].')', 'id_city' => $id_city));
			}
		} else {//failure
			echo json_encode(array('success' => false, 'message' => 'Lỗi thêm hoặc cập nhật thành phố/ tên nước ' .
			$item_data['name'], 'id_city' => -1));
		}
	}
	//check trùng tên
	function checkname($id) {
		$name = $this->input->post('name');
		$d['name'] = $this->City->getname($id);
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
	//check trùng zip_code
	function check_zip_code($id) {
		$name = $this->input->post('zip_code');
		$d['zip_code'] = $this->City->get_zip_code($id);
		foreach ($d['zip_code'] as $d2) {
			$d3[] = $d2['zip_code'];
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
	function delete() {
		$this->check_action_permission('delete');
		$city_to_delete = $this->input->post('ids');
		foreach ($city_to_delete as $city){}
		
		if( $this->City->get_people_by_city($city)->num_rows() > 0){
			echo json_encode(array('success' => false, 'message' => 'Không thể xóa thành phố/ đất nước đã chọn vì đã có nhân viên/ khách hàng/ nhà cung cấp ở đó rồi !'));
		}else if ($this->City->delete_list($city_to_delete)) {
			echo json_encode(array('success' => true, 'message' => 'Bạn đã xóa thành công !'));
		} else {
			echo json_encode(array('success' => false, 'message' => 'Có lỗi xẩy ra khi xóa !'));
		}
	}

}
?>