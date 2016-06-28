<?php

class Employee extends Person {

    function __construct() {
        parent::__construct();
        $this->_table_employees = $this->db->dbprefix('employees');
        $this->_table_people = $this->db->dbprefix('people');
        $this->_table_language = $this->db->dbprefix('language');
        $this->_table_department = $this->db->dbprefix('jobs_department');
        $this->_table_affiliates = $this->db->dbprefix('jobs_affiliates');
        $this->_table_city = $this->db->dbprefix('jobs_city');
        $this->_table_regions = $this->db->dbprefix('jobs_regions');
        $this->_table_welfare_rewards = $this->db->dbprefix('welfare_rewards');
    }

    //check trùng tên
    function getname($id) {
        if ($id > 0) {
            $this->db->select('people.first_name');
            $this->db->where('employees.person_id !=', $id);
            $this->db->where('deleted', 0);
            $this->db->join('people', 'people.person_id = employees.person_id');
            $this->db->from('employees');
            $query = $this->db->get();
        } elseif ($id = -1) {
            $this->db->select('people.first_name');
            $this->db->where('deleted', 0);
            $this->db->join('people', 'people.person_id = employees.person_id');
            $this->db->from('employees');
            $query = $this->db->get();
        }
        foreach ($query->result_array() as $q) {
            $result[] = $q;
        }
        return $result;
    }

    //check trùng mã nv
    function get_emp_code($id) {
        if ($id > 0) {
            $this->db->where('person_id !=', $id);
            $this->db->where('deleted', 0);
            $this->db->from('employees');
            $query = $this->db->get();
        } elseif ($id = -1) {
            $this->db->where('deleted', 0);
            $this->db->from('employees');
            $query = $this->db->get();
        }
        foreach ($query->result_array() as $q) {
            $result[] = $q;
        }
        return $result;
    }

    /*
     * Function SnguyenOne test đệ quy
     * */

    public function get_all_visa() {
        $query = $this->db->get('visa');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    public function get_all_tinhoc() {
        $query = $this->db->get('tinhoc');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    public function get_all_language() {
        $sql = "SELECT * FROM " . $this->_table_language;
        $data = $this->db->query($sql);

        return $data->result_array();
    }

    public function get_all_bangcap() {
        $query = $this->db->get('bangcap');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    public function get_all_education() {
        $query = $this->db->get('education');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    public function get_all_city() {
        $query = $this->db->get('cities');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    // thanh pho
    public function get_all_jobs_city() {
        $query = $this->db->get('jobs_city');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    //chi nhanh 
    public function get_all_jobs_affiliates() {
        $query = $this->db->get('jobs_affiliates');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    //phong ban
    public function get_department_info() {
        $query = $this->db->get('jobs_department');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else
            return null;
    }

    /*
     *  Ham lấy tất cả các thành phố thuộc Khu vực lựa chọn
     * */

    function getAllCity($regions_id) {
        $sql = "SELECT jobs_city_name,jobs_city_id FROM " . $this->_table_city . ' WHERE jobs_regions_id = ' . $regions_id;
        // echo $sql;
        $data = $this->db->query($sql);

        return $data->result();
    }

    /**
      Lấy thông tin từ bảng chi nhánh
     */
    function getActionsDepartment($id, $array_id) {
        $sql = "SELECT department_name,department_id FROM " . $this->_table_department . " WHERE jobs_affiliates_id IN ($array_id)";
        $data = $this->db->query($sql);

        return $data->result();
    }

    /*
     * Lấy thông tin tu các chi nhánh
     * */

    function getActionAffiliates($id, $array_id) {
        $sql = "SELECT jobs_affiliates_id,jobs_affiliates_name FROM " . $this->_table_affiliates . " WHERE jobs_city_id IN ($array_id)";
        $data = $this->db->query($sql);

        return $data->result();
    }

    /**
      Lấy toàn bộ thông tin nhân viên thuộc phòng đó
     */
    function getActionsEmployees($id, $array_id) {
        $sql = "SELECT first_name,a.person_id FROM " . $this->_table_employees . ' AS a,' . $this->_table_people . " AS b
                WHERE a.person_id = b.person_id AND a.deleted = 0 AND a.department_id IN ($array_id)";
        $data = $this->db->query($sql);

        return $data->result_array();
    }

// chuc vu 
    public function get_all_positions() {
        $query = $this->db->get('jobs_positions');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    public function get_info_first_name($em_chucvu) {
        $this->db->select('people.first_name,people.person_id,employees.em_chucvu');
        $this->db->from('people');
        $this->db->join('employees', 'people.person_id = employees.person_id');
        $this->db->where('employees.em_chucvu', $em_chucvu);
        return $this->db->get();
    }

    /*
      Determines if a given person_id is an employee
     */

    function exists($person_id) {
        $this->db->from('employees');
        $this->db->join('people', 'people.person_id = employees.person_id');
        $this->db->where('employees.person_id', $person_id);
        $query = $this->db->get();

        return ($query->num_rows() == 1);
    }

    function employee_username_exists($username) {
        $this->db->from('employees');
        $this->db->join('people', 'people.person_id = employees.person_id');
        $this->db->where('employees.username', $username);
        $query = $this->db->get();


        if ($query->num_rows() == 1) {
            return $query->row()->username;
        }
    }

    /*
      Returns all the employees
     */

    function get_all($person_id, $limit = 10000, $offset = 0, $col = 'last_name', $order = 'asc') {
        $data = $this->getPersonId($person_id);
        $employees = $this->db->dbprefix('employees');
        $people = $this->db->dbprefix('people');
        $sql = "SELECT *FROM " . $people . "
		STRAIGHT_JOIN " . $employees . " ON
		" . $people . ".person_id = " . $employees . ".person_id
	WHERE deleted = 0 AND $employees.person_id IN ($data) ORDER BY " . $col . " " . $order . "
			LIMIT  " . $offset . "," . $limit;
        $data = $this->db->query($sql);

        return $data;
    }

    function get_all22($person_id, $limit = 10000, $offset = 0, $col = 'lifetek_employees.person_id', $order = 'desc') {
        //die($person_id);
        $data = $this->getPersonId($person_id);
        $employees = $this->db->dbprefix('employees');
        $people = $this->db->dbprefix('people');
        $sql = "SELECT *FROM " . $people . "
		STRAIGHT_JOIN " . $employees . " ON
		" . $people . ".person_id = " . $employees . ".person_id
	WHERE deleted = 0 AND $employees.person_id IN ($data) ORDER BY " . $col . " " . $order . "
			LIMIT  " . $offset . "," . $limit;
        $data = $this->db->query($sql);

        return $data;
    }

    function get_all11111111($person_id, $limit = 10000, $offset = 0, $col = 'last_name', $order = 'asc') {
        //$data = $this->getPersonId($person_id);
        $employees = $this->db->dbprefix('employees');
        $people = $this->db->dbprefix('people');
        $sql = "SELECT *
						FROM " . $people . "
						STRAIGHT_JOIN " . $employees . " ON
						" . $people . ".person_id = " . $employees . ".person_id
						WHERE deleted = 0  ORDER BY " . $col . " " . $order . "
						LIMIT  " . $offset . "," . $limit;
        $data = $this->db->query($sql);

        return $data;
    }

    function get_all_receiving($person_id, $limit = 10000, $offset = 0, $col = 'last_name', $order = 'asc') {
        //$data = $this->getPersonId($person_id);
        $employees = $this->db->dbprefix('employees');
        $people = $this->db->dbprefix('people');
        $sql = "SELECT *
			FROM " . $people . "
			STRAIGHT_JOIN " . $employees . " ON
			" . $people . ".person_id = " . $employees . ".person_id
			WHERE deleted = 0  ORDER BY " . $col . " " . $order . "
			LIMIT  " . $offset . "," . $limit;
        $data = $this->db->query($sql);

        return $data;
    }

    function count_all22() {
        $this->db->from('employees');
        $this->db->where('deleted', 0);
        return $this->db->count_all_results();
    }

    /*
      Gets information about a particular employee
     */

    function get_info_one_hit($employee_id = -1) {
        $sql = "SELECT * FROM " . $this->_table_employees . " AS a,$this->_table_people AS b
                   WHERE a.person_id = b.person_id AND a.person_id = $employee_id";
        $data = $this->db->query($sql);

        return $data->row();
    }

    function get_info_one_hit2($employee_id = -1) {
        $sql = "SELECT * FROM " . $this->_table_employees . " AS a,$this->_table_people AS b
                   WHERE a.person_id = b.person_id AND a.person_id = $employee_id
                   AND a.deleted = 0 ";
        $data = $this->db->query($sql);

        return $data->row();
    }

    function get_info_one_more($employee_id = -1) {
        $sql = "SELECT  labor_contract,curiculum_vitae FROM " . $this->_table_employees . " WHERE person_id = $employee_id";
        $data = $this->db->query($sql);

        return $data->row();
    }

    function getInformationAll($person_id) {
        $sql = " SELECT a.person_id,b.department_id,c.jobs_affiliates_id,d.jobs_city_id,e.jobs_regions_id
                 FROM " . $this->_table_employees . " AS a,$this->_table_department AS b,
                 $this->_table_affiliates AS c,$this->_table_city AS d,$this->_table_regions AS e
                 WHERE a.person_id = $person_id AND a.department_id = b.department_id AND b.jobs_affiliates_id = c.jobs_affiliates_id AND c.jobs_city_id = d.jobs_city_id AND d.jobs_regions_id = e.jobs_regions_id  ";
        $data = $this->db->query($sql);

        return $data->row();
    }

    function getTablePC($person_id) {
        $sql = "SELECT b.person_id,pc_seniority,pc_position FROM " . $this->_table_employees . " AS a,   $this->_table_welfare_rewards  AS b
                WHERE a.person_id = b.person_id AND a.person_id = $person_id";
        $data = $this->db->query($sql);

        return $data->row();
    }

    /*
      Function get information image
     */

    function getInfoOne($person_id) {
        $sql = "SELECT image_face FROM $this->_table_employees WHERE person_id = $person_id";
        $data = $this->db->query($sql);

        return $data->row();
    }

    /*
      Gets information about multiple employees
     */

    function get_multiple_info($employee_ids) {
        $this->db->from('employees');
        $this->db->join('people', 'people.person_id = employees.person_id');
        $this->db->where_in('employees.person_id', $employee_ids);
        $this->db->order_by("last_name", "asc");
        return $this->db->get();
    }

    function getPersonDepartment($department_id) {
        $sql = "SELECT person_id FROM " . $this->_table_department . ' WHERE department_id = ' . $department_id;
        $data = $this->db->query($sql);

        if ($data->num_rows() > 0)
            return $data->row();
    }

    /*
     * Hàm thực hiện kiểm tra xem nhân viên này có phải là nhân viên quản lý của khu vực nào hay không
     * */

    function getPersonOneRegions($person_id) {
        $sql = "SELECT person_id FROM " . $this->_table_regions . " WHERE person_id = $person_id ";
        $data = $this->db->query($sql);
        return $data->num_rows();
    }

    /*
     * Hàm thực hiện kiểm tra xem nhân viên này có phải là nhân viên quản lý của thành phố nào hay không
     * */

    function getPersonOneCity($person_id) {
        $sql = "SELECT person_id FROM " . $this->_table_city . " WHERE person_id = $person_id ";
        $data = $this->db->query($sql);
        return $data->num_rows();
    }

    /*
     * Hàm thực hiện kiểm tra xem nhân viên này có phải là nhân viên quản lý của chi nhánh nào hay không
     * */

    function getPersonOneAfiliates($person_id) {
        $sql = "SELECT person_id FROM " . $this->_table_affiliates . " WHERE person_id = $person_id ";
        $data = $this->db->query($sql);
        return $data->num_rows();
    }

    /*
     * Hàm thực hiện kiểm tra xem nhân viên này có phải là nhân viên quản lý của phòng ban nào hay không
     * */

    function getPersonOneDepartment($person_id) {
        $sql = "SELECT person_id FROM " . $this->_table_department . " WHERE person_id = $person_id ";
        $data = $this->db->query($sql);
        return $data->num_rows();
    }

    /*
     * Hàm kiểm tra tổng quan xem nhân vien có phải là quản lý của khu vực,phòng ban,chi nhánh,thành phố hay không
     * Nếu phải thì không thực hiện update parent_id hay không
     * */

    function getCheckOneAll($person_id) {
        $reusltDepartment = $this->getPersonOneDepartment($person_id);
        $reusltCity = $this->getPersonOneCity($person_id);
        $reusltAffiliates = $this->getPersonOneAfiliates($person_id);
        $reusltRegions = $this->getPersonOneRegions($person_id);
        if ($reusltAffiliates > 0 || $reusltCity > 0 || $reusltDepartment > 0 || $reusltRegions > 0 || $person_id == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    //chang pass - hung audi 27-2-15
    function get_employee_info() {
        if ($this->is_logged_in()) {
            return $this->get_info($this->session->userdata('person_id'));
        }

        return false;
    }

    function save_change_pass($person_data, $employee_id) {
        $this->db->where('person_id', $employee_id);
        $success = $this->db->update('employees', $person_data);
        return $success;
    }

    /*
      Inserts or updates an employee
     */

    function save2(&$person_data, &$employee_data, $employee_id = false, &$pc_table, &$contract_data) {
        $success = false;

        //Run these queries as a transaction, we want to make sure we do all or nothing
        $this->db->trans_start();
//		$order = parent::save($person_data, $employee_id);
//		echo json_encode($order);exit();
        if (parent::save($person_data, $employee_id)) {
            if ($employee_id == -1) {
                $employee_data['person_id'] = $employee_id = $person_data['person_id'];
//                echo json_encode($employee_data['person_id']);exit();
                $success = $this->db->insert('employees', $employee_data);
//                echo json_encode($this->db->last_query());exit();
                if ($success) {
                    $pc_table['person_id'] = $person_data['person_id'];
                    $this->db->insert('welfare_rewards', $pc_table);
                    $contract_data['id_employess'] = $person_data['person_id'];
                    $this->db->insert('hopdong', $contract_data);
                }
            } else {
                $this->db->where('person_id', $employee_id);
                $success = $this->db->update('employees', $employee_data);
//                echo json_encode($this->db->last_query());exit();
                $reusltOne = parent::getInformationPerson('welfare_rewards', 'person_id', $employee_id);
                if (count($resultOne) > 0) {
                    $this->db->update('welfare_rewards', $pc_table);
                }
            }
        }

        $this->db->trans_complete();
        return $success;
    }

    function save(&$person_data, &$employee_data, &$permission_data, &$permission_action_data, $employee_id = false, &$pc_table, &$contract_data) {
        $success = false;

        //Run these queries as a transaction, we want to make sure we do all or nothing
        $this->db->trans_start();
//		$order = parent::save($person_data, $employee_id);
//		echo json_encode($order);exit();
        if (parent::save($person_data, $employee_id)) {
            if ($employee_id == -1) {
                $employee_data['person_id'] = $employee_id = $person_data['person_id'];
//                echo json_encode($employee_data['person_id']);exit();
                $success = $this->db->insert('employees', $employee_data);
//                echo json_encode($this->db->last_query());exit();
                if ($success) {
                    $pc_table['person_id'] = $person_data['person_id'];
                    $this->db->insert('welfare_rewards', $pc_table);
                    $contract_data['id_employess'] = $person_data['person_id'];
                    $this->db->insert('hopdong', $contract_data);
                }
            } else {
                $this->db->where('person_id', $employee_id);
                $success = $this->db->update('employees', $employee_data);
//                echo json_encode($this->db->last_query());exit();
                $reusltOne = parent::getInformationPerson('welfare_rewards', 'person_id', $employee_id);
                if (count($resultOne) > 0) {
                    $this->db->update('welfare_rewards', $pc_table);
                }
            }

            //We have either inserted or updated a new employee, now lets set permissions. 
            if ($success) {

                //if($permission_data != '' && $permission_action_data != ''){
                //First lets clear out any permissions the employee currently has.
                $success = $this->db->delete('permissions', array('person_id' => $employee_id));

                //Now insert the new permissions
                if ($success) {
                    foreach ($permission_data as $allowed_module) {
                        $success = $this->db->insert('permissions', array(
                            'module_id' => $allowed_module,
                            'person_id' => $employee_id));
                    }
                }

                //First lets clear out any permissions actions the employee currently has.
                $success = $this->db->delete('permissions_actions', array('person_id' => $employee_id));

                //Now insert the new permissions actions
                if ($success) {
                    foreach ($permission_action_data as $permission_action) {
                        list($module, $action) = explode('|', $permission_action);
                        $success = $this->db->insert('permissions_actions', array(
                            'module_id' => $module,
                            'action_id' => $action,
                            'person_id' => $employee_id));
                    }
                }
                //}
            }
        }

        $this->db->trans_complete();
        return $success;
    }

    /*
      Deletes one employee
     */

    function delete($employee_id) {
        $success = false;

        //Don't let employee delete their self
        if ($employee_id == $this->get_logged_in_employee_info()->person_id)
            return false;

        //Run these queries as a transaction, we want to make sure we do all or nothing
        $this->db->trans_start();

        //Delete permissions
        if ($this->db->delete('permissions', array('person_id' => $employee_id)) && $this->db->delete('permissions_actions', array('person_id' => $employee_id))) {
            $this->db->where('person_id', $employee_id);
            $success = $this->db->update('employees', array('deleted' => 1));
        }
        $this->db->trans_complete();
        return $success;
    }

    /*
      Deletes a list of employees
     */

    /*
      Deletes a list of employees
     */

    function delete_list2($employee_ids) {
        $row = $this->Jobs_regions->get_region_id($employee_ids)->num_rows();
        $em2 = $this->Jobs_regions->get_region_id($employee_ids)->row()->person_id;

        $this->db->where_in('person_id', $employee_ids);

        if ($this->db->delete('permissions')) {
            $this->db->where_in('person_id !=', $employee_ids);
            $success = $this->db->update('employees', array('deleted' => 1));
        }

        return $success;
    }

    function delete_list($employee_ids, $department_id = '') {
        $success = false;

        if (in_array($this->get_logged_in_employee_info()->person_id, $employee_ids))
            return false;

        $this->db->trans_start();
        $this->db->where_in('person_id', $employee_ids);
        if ($this->db->delete('permissions')) {

            $this->db->where_in('person_id', $employee_ids);

            $success = $this->db->update('employees', array('deleted' => 1));
        }
        $this->db->trans_complete();
        return $success;
    }

    function get_emp_search_suggestions($search, $limit = 25) {
        $suggestions = array();



        $this->db->from('employees');
        $this->db->where("( emp_luong_coban LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			username LIKE '%" . $this->db->escape_like_str($search) . "%' or
		CONCAT(`emp_luong_coban`,' ',`username`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0 ");
        $by_item_number = $this->db->get();
        foreach ($by_item_number->result() as $row) {
            $suggestions[] = array('salary' => $row->emp_luong_coban, 'label' => $row->username . ' ' . $row->username);
        }

        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    /*
      Get search suggestions to find employees
     */

    function get_search_suggestions11($search, $limit = 5) {
        $suggestions = array();

        $this->db->from('employees');
        $this->db->join('people', 'employees.person_id=people.person_id');

        if ($this->config->item('speed_up_search_queries')) {
            $this->db->where("(first_name LIKE '" . $this->db->escape_like_str($search) . "%' or 
			last_name LIKE '" . $this->db->escape_like_str($search) . "%' or 
			CONCAT(`first_name`,' ',`last_name`) LIKE '" . $this->db->escape_like_str($search) . "%') and deleted=0");
        } else {
            $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0");
        }

        $this->db->order_by("last_name", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('label' => $row->first_name . ' ' . $row->last_name, 'value' => $row->person_id);
        }



        $this->db->from('employees');
        $this->db->join('people', 'employees.person_id=people.person_id');
        $this->db->where('deleted', 0);
        $this->db->like("email", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("email", "asc");
        $by_email = $this->db->get();
        foreach ($by_email->result() as $row) {
            $suggestions[] = array('label' => $row->email);
        }

        $this->db->from('employees');
        $this->db->join('people', 'employees.person_id=people.person_id');
        $this->db->where('deleted', 0);
        $this->db->like("username", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("username", "asc");
        $by_username = $this->db->get();
        foreach ($by_username->result() as $row) {
            $suggestions[] = array('label' => $row->username);
        }


        $this->db->from('employees');
        $this->db->join('people', 'employees.person_id=people.person_id');
        $this->db->where('deleted', 0);
        $this->db->like("phone_number", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("phone_number", "asc");
        $by_phone = $this->db->get();
        foreach ($by_phone->result() as $row) {
            $suggestions[] = array('value' => $row->person_id, 'label' => $row->phone_number);
        }


        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    function get_search_suggestions22($search, $limit = 5) {
        $suggestions = array();

        $this->db->from('employees');
        $this->db->join('people', 'employees.person_id=people.person_id');

        if ($this->config->item('speed_up_search_queries')) {
            $this->db->where("(first_name LIKE '" . $this->db->escape_like_str($search) . "%' or 
			last_name LIKE '" . $this->db->escape_like_str($search) . "%' or 
			CONCAT(`first_name`,' ',`last_name`) LIKE '" . $this->db->escape_like_str($search) . "%') and deleted=0");
        } else {
            $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0");
        }

        $this->db->order_by("last_name", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('label' => $row->first_name . ' ' . $row->last_name, 'value' => $row->person_id, 'salary' => $row->em_salary_basic);
        }



        $this->db->from('employees');
        $this->db->join('people', 'employees.person_id=people.person_id');
        $this->db->where('deleted', 0);
        $this->db->like("email", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("email", "asc");
        $by_email = $this->db->get();
        foreach ($by_email->result() as $row) {
            $suggestions[] = array('label' => $row->email);
        }

        $this->db->from('employees');
        $this->db->join('people', 'employees.person_id=people.person_id');
        $this->db->where('deleted', 0);
        $this->db->like("username", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("username", "asc");
        $by_username = $this->db->get();
        foreach ($by_username->result() as $row) {
            $suggestions[] = array('label' => $row->username);
        }


        $this->db->from('employees');
        $this->db->join('people', 'employees.person_id=people.person_id');
        $this->db->where('deleted', 0);
        $this->db->like("phone_number", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("phone_number", "asc");
        $by_phone = $this->db->get();
        foreach ($by_phone->result() as $row) {
            $suggestions[] = array('value' => $row->person_id, 'label' => $row->phone_number, 'salary' => $row->em_salary_basic);
        }


        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    /*
      Preform a search on employees
     */

    function search22($search, $limit = 20, $offset = 0, $column = 'last_name', $orderby = 'asc') {
        if ($this->config->item('speed_up_search_queries')) {

            $query = "
				select *
			from (
           	(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('employees') . ".username, " . $this->db->dbprefix('employees') . ".deleted
           	from " . $this->db->dbprefix('employees') . "
           	join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('employees') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
           	where first_name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
           	order by `" . $column . "` " . $orderby . ") union

		 	(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('employees') . ".username, " . $this->db->dbprefix('employees') . ".deleted
           	from " . $this->db->dbprefix('employees') . "
           	join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('employees') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
           	where last_name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
           	order by `" . $column . "` " . $orderby . ") union

			(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('employees') . ".username, " . $this->db->dbprefix('employees') . ".deleted
         	from " . $this->db->dbprefix('employees') . "
          	join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('employees') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
          	where email like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
          	order by `" . $column . "` " . $orderby . ") union

			(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('employees') . ".username, " . $this->db->dbprefix('employees') . ".deleted
        	from " . $this->db->dbprefix('employees') . "
        	join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('employees') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
        	where phone_number like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
        	order by `" . $column . "` " . $orderby . ") union

			(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('employees') . ".username, " . $this->db->dbprefix('employees') . ".deleted
      		from " . $this->db->dbprefix('employees') . "
      		join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('employees') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
      		where username like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
      		order by `" . $column . "` " . $orderby . ") union

			(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('employees') . ".username, " . $this->db->dbprefix('employees') . ".deleted
    		from " . $this->db->dbprefix('employees') . "
    		join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('employees') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
    		where CONCAT(`first_name`,' ',`last_name`)  like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
    		order by `" . $column . "` " . $orderby . ")
			) as search_results
			order by `" . $column . "` " . $orderby . " limit " . $this->db->escape((int) $offset) . ', ' . $this->db->escape((int) $limit);

            return $this->db->query($query);
        } else {
            $this->db->from('employees');
            $this->db->join('people', 'employees.person_id=people.person_id');
            $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			email LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			phone_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			username LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0");
            $this->db->order_by($column, $orderby);
            $this->db->limit($limit);
            $this->db->offset($offset);
            return $this->db->get();
        }
    }

    function search_count_all22($search, $limit = 10000) {
        if ($this->config->item('speed_up_search_queries')) {

            $query = "
				select *
			from (
           	(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('employees') . ".username, " . $this->db->dbprefix('employees') . ".deleted
           	from " . $this->db->dbprefix('employees') . "
           	join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('employees') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
           	where first_name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
           	order by `last_name` asc limit " . $this->db->escape($limit) . ") union

		 	(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('employees') . ".username, " . $this->db->dbprefix('employees') . ".deleted
           	from " . $this->db->dbprefix('employees') . "
           	join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('employees') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
           	where last_name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
           	order by `last_name` asc limit " . $this->db->escape($limit) . ") union

			(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('employees') . ".username, " . $this->db->dbprefix('employees') . ".deleted
         	from " . $this->db->dbprefix('employees') . "
          	join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('employees') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
          	where email like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
          	order by `last_name` asc limit " . $this->db->escape($limit) . ") union

			(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('employees') . ".username, " . $this->db->dbprefix('employees') . ".deleted
        	from " . $this->db->dbprefix('employees') . "
        	join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('employees') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
        	where phone_number like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
        	order by `last_name` asc limit " . $this->db->escape($limit) . ") union

			(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('employees') . ".username, " . $this->db->dbprefix('employees') . ".deleted
      		from " . $this->db->dbprefix('employees') . "
      		join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('employees') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
      		where username like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
      		order by `last_name` asc limit " . $this->db->escape($limit) . ") union

			(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('employees') . ".username, " . $this->db->dbprefix('employees') . ".deleted
    		from " . $this->db->dbprefix('employees') . "
    		join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('employees') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
    		where CONCAT(`first_name`,' ',`last_name`)  like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
    		order by `last_name` asc limit " . $this->db->escape($limit) . ")
			) as search_results
			order by `last_name` asc limit " . $this->db->escape($limit);

            $result = $this->db->query($query);
            return $result->num_rows();
        } else {
            $this->db->from('employees');
            $this->db->join('people', 'employees.person_id=people.person_id');
            $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			email LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			phone_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			username LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0");
            $this->db->order_by("last_name", "asc");
            $result = $this->db->get();
            return $result->num_rows();
        }
    }

    /*
      Attempts to login employee and set session. Returns boolean based on outcome.
     */

    function login($username, $password) {
        $query = $this->db->get_where('employees', array('username' => $username, 'password' => md5($password), 'deleted' => 0), 1);
        if ($query->num_rows() == 1) {
            $row = $query->row();
            $this->session->set_userdata('person_id', $row->person_id);
            return true;
        }
        return false;
    }

    /*
      Logs out a user by destorying all session data and redirect to login
     */

    function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }

    /*
      Determins if a employee is logged in
     */

    function is_logged_in() {
        return $this->session->userdata('person_id') != false;
    }

    /*
      Gets information about the currently logged in employee.
     */

    function get_logged_in_employee_info() {
        if ($this->is_logged_in()) {
            return $this->get_info($this->session->userdata('person_id'));
        }

        return false;
    }

    function authentication_check($password) {
        $pd = $this->session->userdata('person_id');
        $pass = md5($password);
        $query = $this->db->get_where('employees', array('person_id' => $pd, 'password' => $pass), 1);
        return $query->num_rows() == 1;
    }

    /*
      Determins whether the employee specified employee has access the specific module.
     */

    function has_module_permission($module_id, $person_id) {
        //if no module_id is null, allow access
        if ($module_id == null) {
            return true;
        }

        $query = $this->db->get_where('permissions', array('person_id' => $person_id, 'module_id' => $module_id), 1);
        return $query->num_rows() == 1;
    }

    function has_module_action_permission($module_id, $action_id, $person_id) {
        //if no module_id is null, allow access
        if ($module_id == null) {
            return true;
        }

        $query = $this->db->get_where('permissions_actions', array('person_id' => $person_id, 'module_id' => $module_id, 'action_id' => $action_id), 1);
        return $query->num_rows() == 1;
    }

    function get_employee_by_username_or_email($username_or_email) {
        $this->db->from('employees');
        $this->db->join('people', 'people.person_id = employees.person_id');
        $this->db->where('username', $username_or_email);
        $this->db->or_where('email', $username_or_email);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row();
        }

        return false;
    }

    function update_employee_password($employee_id, $password) {
        $employee_data = array('password' => $password);
        $this->db->where('person_id', $employee_id);
        $success = $this->db->update('employees', $employee_data);

        return $success;
    }

    function get_info_contractemp($id_contractemp) {
        $this->db->where('person_id', $id_contractemp);
        $query = $this->db->get('employees');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return null;
        }
    }

    //Created by San
    function get_list_employee() {
        $this->db->from("employees");
        $this->db->join("people", "employees.person_id=people.person_id", "inner");
        //$this->db->where("employees.person_id !=", 1);
        $this->db->where("deleted", 0);
        $this->db->order_by("employees.person_id", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_info_employee_by_id($emp_code) {
        $this->db->where('emp_code', $emp_code);
        $this->db->where("deleted", 0);
        $query = $this->db->get('employees');
        return $query->row_array();
    }

    function get_search_info_name_employee_suggestions($search, $limit = 5) {
        $suggestions = array();

        $this->db->from('employees');
        $this->db->join('people', 'employees.person_id=people.person_id');

        if ($this->config->item('speed_up_search_queries')) {
            $this->db->where("(first_name LIKE '" . $this->db->escape_like_str($search) . "%' or 
			last_name LIKE '" . $this->db->escape_like_str($search) . "%' or 
			CONCAT(`first_name`,' ',`last_name`) LIKE '" . $this->db->escape_like_str($search) . "%') and deleted=0");
        } else {
            $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0");
        }

        $this->db->order_by("last_name", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array(
                'label' => $row->first_name . ' ' . $row->last_name,
                'value' => $row->person_id,
                'salary' => $row->em_salary_basic,
                'phone' => $row->phone_number,
            );
        }
        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    //hung audi 20-3
    function get_all2($person_id, $limit = 10000, $offset = 0, $col = 'lifetek_employees.person_id', $ord = 'desc') {
        if ($person_id == 1) {
            $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                    ->from($this->_table_people)
                    ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                    ->where('deleted', 0)
                    ->order_by($col, $ord)
                    ->limit($limit)
                    ->offset($offset);
            $data = $this->db->get();
        } else {
            if ($this->Jobs_regions->get_region_id($person_id)->num_rows() > 0) {
                $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                        ->from($this->_table_people)
                        ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                        ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                        ->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id")
                        ->join($this->_table_city, "$this->_table_affiliates.jobs_city_id = $this->_table_city.jobs_city_id")
                        ->join($this->_table_regions, "$this->_table_city.jobs_city_id = $this->_table_regions.jobs_regions_id")
                        ->where("$this->_table_regions.person_id", $person_id)
                        ->where('deleted', 0)
                        ->order_by($col, $ord)
                        ->limit($limit)
                        ->offset($offset);
                $data = $this->db->get();
            } else
            if ($this->Jobs_city->get_city_id($person_id)->num_rows() > 0) {
                $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                        ->from($this->_table_people)
                        ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                        ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                        ->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id")
                        ->join($this->_table_city, "$this->_table_affiliates.jobs_city_id = $this->_table_city.jobs_city_id")
                        ->where("$this->_table_city.person_id", $person_id)
                        ->where('deleted', 0)
                        ->order_by($col, $ord)
                        ->limit($limit)
                        ->offset($offset);
                $data = $this->db->get();
            } else
            if ($this->Jobs_affiliates->get_aff_id($person_id)->num_rows() > 0) {
                $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                        ->from($this->_table_people)
                        ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                        ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                        ->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id")
                        ->where("$this->_table_affiliates.person_id", $person_id)
                        ->where('deleted', 0)
                        ->order_by($col, $ord)
                        ->limit($limit)
                        ->offset($offset);
                $data = $this->db->get();
            } else
            if ($this->Jobs_department->get_dep_id($person_id)->num_rows() > 0) {
                $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                        ->from($this->_table_people)
                        ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                        ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                        ->where("$this->_table_department.person_id", $person_id)
                        ->where('deleted', 0)
                        ->order_by($col, $ord)
                        ->limit($limit)
                        ->offset($offset);
                $data = $this->db->get();
            } else {
                $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                        ->from($this->_table_people)
                        ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                        ->where('deleted', 0)
                        ->where("$this->_table_employees.person_id", $person_id)
                        ->order_by($col, $ord)
                        ->limit($limit)
                        ->offset($offset);
                $data = $this->db->get();
            }
        }
        return $data;
    }

    function count_all($person_id) {
        if ($person_id == 1) {
            $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                    ->from($this->_table_people)
                    ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                    ->where('deleted', 0);
        } else {
            if ($this->Jobs_regions->get_region_id($person_id)->num_rows() > 0) {
                $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                        ->from($this->_table_people)
                        ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                        ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                        ->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id")
                        ->join($this->_table_city, "$this->_table_affiliates.jobs_city_id = $this->_table_city.jobs_city_id")
                        ->join($this->_table_regions, "$this->_table_city.jobs_city_id = $this->_table_regions.jobs_regions_id")
                        ->where("$this->_table_regions.person_id", $person_id)
                        ->where('deleted', 0);
            } else
            if ($this->Jobs_city->get_city_id($person_id)->num_rows() > 0) {
                $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                        ->from($this->_table_people)
                        ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                        ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                        ->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id")
                        ->join($this->_table_city, "$this->_table_affiliates.jobs_city_id = $this->_table_city.jobs_city_id")
                        ->where("$this->_table_city.person_id", $person_id)
                        ->where('deleted', 0);
            } else
            if ($this->Jobs_affiliates->get_aff_id($person_id)->num_rows() > 0) {
                $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                        ->from($this->_table_people)
                        ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                        ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                        ->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id")
                        ->where("$this->_table_affiliates.person_id", $person_id)
                        ->where('deleted', 0);
            } else
            if ($this->Jobs_department->get_dep_id($person_id)->num_rows() > 0) {  //die($this->_table_city);
                $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                        ->from($this->_table_people)
                        ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                        ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                        ->where("$this->_table_department.person_id", $person_id)
                        ->where('deleted', 0);
            } else {
                $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                        ->from($this->_table_people)
                        ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                        ->where('deleted', 0)
                        ->where("$this->_table_employees.person_id", $person_id);
            }
        }
        return $this->db->count_all_results();
    }

    function get_search_suggestions($person_id, $search, $limit = 5) {
        $suggestions = array();
        if ($person_id == 1) {
            $this->db->from('employees');
            $this->db->join('people', 'employees.person_id=people.person_id');

            if ($this->config->item('speed_up_search_queries')) {
                $this->db->where("(first_name LIKE '" . $this->db->escape_like_str($search) . "%' or 
				last_name LIKE '" . $this->db->escape_like_str($search) . "%' or 
				CONCAT(`first_name`,' ',`last_name`) LIKE '" . $this->db->escape_like_str($search) . "%') and deleted=0");
            } else {
                $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
				last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
				CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0");
            }

            $this->db->order_by("last_name", "asc");
            $by_name = $this->db->get();

            foreach ($by_name->result() as $row) {
                if ($row->first_name != '' || $row->last_name != '') { //
                    $suggestions[] = array('label' => $row->first_name . ' ' . $row->last_name, 'value' => $row->person_id, 'salary' => $row->em_salary_basic);
                }
            }

            $this->db->from('employees');
            $this->db->join('people', 'employees.person_id=people.person_id');
            $this->db->where('deleted', 0);
            $this->db->like("email", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
            $this->db->order_by("email", "asc");
            $by_email = $this->db->get();
            foreach ($by_email->result() as $row) {
                if ($row->email != '') { //
                    $suggestions[] = array('label' => $row->email);
                }
            }

            $this->db->from('employees');
            $this->db->join('people', 'employees.person_id=people.person_id');
            $this->db->where('deleted', 0);
            $this->db->like("username", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
            $this->db->order_by("username", "asc");
            $by_username = $this->db->get();
            foreach ($by_username->result() as $row) {
                if ($row->username != '') {//
                    $suggestions[] = array('label' => $row->username);
                }
            }


            $this->db->from('employees');
            $this->db->join('people', 'employees.person_id=people.person_id');
            $this->db->where('deleted', 0);
            $this->db->like("phone_number", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
            $this->db->order_by("phone_number", "asc");
            $by_phone = $this->db->get();
            foreach ($by_phone->result() as $row) {
                if ($row->phone_number != '') {//
                    $suggestions[] = array('value' => $row->person_id, 'label' => $row->phone_number, 'salary' => $row->em_salary_basic);
                }
            }
        } else {
            if ($this->Jobs_regions->get_region_id($person_id)->num_rows() > 0) {
                //first_name
                $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                        ->from($this->_table_people)
                        ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                        ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                        ->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id")
                        ->join($this->_table_city, "$this->_table_affiliates.jobs_city_id = $this->_table_city.jobs_city_id")
                        ->join($this->_table_regions, "$this->_table_city.jobs_city_id = $this->_table_regions.jobs_regions_id")
                        ->where("$this->_table_regions.person_id", $person_id);

                if ($this->config->item('speed_up_search_queries')) {
                    $this->db->where("(first_name LIKE '" . $this->db->escape_like_str($search) . "%' or 
					last_name LIKE '" . $this->db->escape_like_str($search) . "%' or 
					CONCAT(`first_name`,' ',`last_name`) LIKE '" . $this->db->escape_like_str($search) . "%') and deleted=0");
                } else {
                    $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
					last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
					CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0");
                }
                $this->db->order_by("last_name", "asc");
                $by_name = $this->db->get();
                foreach ($by_name->result() as $row) {
                    if ($row->first_name != '' || $row->last_name != '') { //
                        $suggestions[] = array('label' => $row->first_name . ' ' . $row->last_name, 'value' => $row->person_id, 'salary' => $row->em_salary_basic);
                    }
                }

                //email
                $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                        ->from($this->_table_people)
                        ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                        ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                        ->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id")
                        ->join($this->_table_city, "$this->_table_affiliates.jobs_city_id = $this->_table_city.jobs_city_id")
                        ->join($this->_table_regions, "$this->_table_city.jobs_city_id = $this->_table_regions.jobs_regions_id")
                        ->where("$this->_table_regions.person_id", $person_id)
                        ->where('deleted', 0)
                        ->like("email", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both')
                        ->order_by("email", "asc");
                $by_email = $this->db->get();
                foreach ($by_email->result() as $row) {
                    if ($row->email != '') {//
                        $suggestions[] = array('label' => $row->email);
                    }
                }

                //username
                $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                        ->from($this->_table_people)
                        ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                        ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                        ->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id")
                        ->join($this->_table_city, "$this->_table_affiliates.jobs_city_id = $this->_table_city.jobs_city_id")
                        ->join($this->_table_regions, "$this->_table_city.jobs_city_id = $this->_table_regions.jobs_regions_id")
                        ->where("$this->_table_regions.person_id", $person_id)
                        ->where('deleted', 0)
                        ->like("username", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both')
                        ->order_by("username", "asc");
                $by_username = $this->db->get();
                foreach ($by_username->result() as $row) {
                    if ($row->username != '') {//
                        $suggestions[] = array('label' => $row->username);
                    }
                }

                //fone
                $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                        ->from($this->_table_people)
                        ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                        ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                        ->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id")
                        ->join($this->_table_city, "$this->_table_affiliates.jobs_city_id = $this->_table_city.jobs_city_id")
                        ->join($this->_table_regions, "$this->_table_city.jobs_city_id = $this->_table_regions.jobs_regions_id")
                        ->where("$this->_table_regions.person_id", $person_id)
                        ->where('deleted', 0)
                        ->like("phone_number", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both')
                        ->order_by("phone_number", "asc");
                $by_phone = $this->db->get();
                foreach ($by_phone->result() as $row) {
                    if ($row->phone_number != '') {//
                        $suggestions[] = array('value' => $row->person_id, 'label' => $row->phone_number, 'salary' => $row->em_salary_basic);
                    }
                }
            } else
            if ($this->Jobs_city->get_city_id($person_id)->num_rows() > 0) {
                //first_name
                $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                        ->from($this->_table_people)
                        ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                        ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                        ->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id")
                        ->join($this->_table_city, "$this->_table_affiliates.jobs_city_id = $this->_table_city.jobs_city_id")
                        ->where("$this->_table_city.person_id", $person_id);

                if ($this->config->item('speed_up_search_queries')) {
                    $this->db->where("(first_name LIKE '" . $this->db->escape_like_str($search) . "%' or 
					last_name LIKE '" . $this->db->escape_like_str($search) . "%' or 
					CONCAT(`first_name`,' ',`last_name`) LIKE '" . $this->db->escape_like_str($search) . "%') and deleted=0");
                } else {
                    $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
					last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
					CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0");
                }
                $this->db->order_by("last_name", "asc");
                $by_name = $this->db->get();
                foreach ($by_name->result() as $row) {
                    if ($row->first_name != '' || $row->last_name) {//
                        $suggestions[] = array('label' => $row->first_name . ' ' . $row->last_name, 'value' => $row->person_id, 'salary' => $row->em_salary_basic);
                    }
                }

                //email
                $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                        ->from($this->_table_people)
                        ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                        ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                        ->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id")
                        ->join($this->_table_city, "$this->_table_affiliates.jobs_city_id = $this->_table_city.jobs_city_id")
                        ->where("$this->_table_city.person_id", $person_id)
                        ->where('deleted', 0)
                        ->like("email", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both')
                        ->order_by("email", "asc");
                $by_email = $this->db->get();
                foreach ($by_email->result() as $row) {
                    if ($row->email != '') {//
                        $suggestions[] = array('label' => $row->email);
                    }
                }

                //username
                $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                        ->from($this->_table_people)
                        ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                        ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                        ->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id")
                        ->join($this->_table_city, "$this->_table_affiliates.jobs_city_id = $this->_table_city.jobs_city_id")
                        ->where("$this->_table_city.person_id", $person_id)
                        ->where('deleted', 0)
                        ->like("username", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both')
                        ->order_by("username", "asc");
                $by_username = $this->db->get();
                foreach ($by_username->result() as $row) {
                    if ($row->username != '') {//
                        $suggestions[] = array('label' => $row->username);
                    }
                }

                //fone
                $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                        ->from($this->_table_people)
                        ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                        ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                        ->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id")
                        ->join($this->_table_city, "$this->_table_affiliates.jobs_city_id = $this->_table_city.jobs_city_id")
                        ->where("$this->_table_city.person_id", $person_id)
                        ->where('deleted', 0)
                        ->like("phone_number", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both')
                        ->order_by("phone_number", "asc");
                $by_phone = $this->db->get();
                foreach ($by_phone->result() as $row) {
                    if ($row->phone_number != '') {//
                        $suggestions[] = array('value' => $row->person_id, 'label' => $row->phone_number, 'salary' => $row->em_salary_basic);
                    }
                }
            } else
            if ($this->Jobs_affiliates->get_aff_id($person_id)->num_rows() > 0) {
                //first_name
                $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                        ->from($this->_table_people)
                        ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                        ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                        ->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id")
                        ->where("$this->_table_affiliates.person_id", $person_id);

                if ($this->config->item('speed_up_search_queries')) {
                    $this->db->where("(first_name LIKE '" . $this->db->escape_like_str($search) . "%' or 
					last_name LIKE '" . $this->db->escape_like_str($search) . "%' or 
					CONCAT(`first_name`,' ',`last_name`) LIKE '" . $this->db->escape_like_str($search) . "%') and deleted=0");
                } else {
                    $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
					last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
					CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0");
                }
                $this->db->order_by("last_name", "asc");
                $by_name = $this->db->get();
                foreach ($by_name->result() as $row) {
                    if ($row->first_name != '' || $row->last_name != '') {//
                        $suggestions[] = array('label' => $row->first_name . ' ' . $row->last_name, 'value' => $row->person_id, 'salary' => $row->em_salary_basic);
                    }
                }

                //email
                $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                        ->from($this->_table_people)
                        ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                        ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                        ->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id")
                        ->where("$this->_table_affiliates.person_id", $person_id)
                        ->where('deleted', 0)
                        ->like("email", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both')
                        ->order_by("email", "asc");
                $by_email = $this->db->get();
                foreach ($by_email->result() as $row) {
                    if ($row->email != '') {//
                        $suggestions[] = array('label' => $row->email);
                    }
                }

                //username
                $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                        ->from($this->_table_people)
                        ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                        ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                        ->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id")
                        ->where("$this->_table_affiliates.person_id", $person_id)
                        ->where('deleted', 0)
                        ->like("username", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both')
                        ->order_by("username", "asc");
                $by_username = $this->db->get();
                foreach ($by_username->result() as $row) {
                    if ($row->username != '') {//
                        $suggestions[] = array('label' => $row->username);
                    }
                }

                //fone
                $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                        ->from($this->_table_people)
                        ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                        ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                        ->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id")
                        ->where("$this->_table_affiliates.person_id", $person_id)
                        ->where('deleted', 0)
                        ->like("phone_number", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both')
                        ->order_by("phone_number", "asc");
                $by_phone = $this->db->get();
                foreach ($by_phone->result() as $row) {
                    if ($row->phone_number != '') {
                        $suggestions[] = array('value' => $row->person_id, 'label' => $row->phone_number, 'salary' => $row->em_salary_basic);
                    }
                }
            } else
            if ($this->Jobs_department->get_dep_id($person_id)->num_rows() > 0) {
                //first_name
                $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                        ->from($this->_table_people)
                        ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                        ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                        ->where("$this->_table_department.person_id", $person_id);

                if ($this->config->item('speed_up_search_queries')) {
                    $this->db->where("(first_name LIKE '" . $this->db->escape_like_str($search) . "%' or 
					last_name LIKE '" . $this->db->escape_like_str($search) . "%' or 
					CONCAT(`first_name`,' ',`last_name`) LIKE '" . $this->db->escape_like_str($search) . "%') and deleted=0");
                } else {
                    $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
					last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
					CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0");
                }
                $this->db->order_by("last_name", "asc");
                $by_name = $this->db->get();
                foreach ($by_name->result() as $row) {
                    if ($row->first_name != '' || $row->last_name != '') {//
                        $suggestions[] = array('label' => $row->first_name . ' ' . $row->last_name, 'value' => $row->person_id, 'salary' => $row->em_salary_basic);
                    }
                }

                //email
                $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                        ->from($this->_table_people)
                        ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                        ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                        ->where("$this->_table_department.person_id", $person_id)
                        ->where('deleted', 0)
                        ->like("email", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both')
                        ->order_by("email", "asc");
                $by_email = $this->db->get();
                foreach ($by_email->result() as $row) {
                    if ($row->email != '') {
                        $suggestions[] = array('label' => $row->email);
                    }
                }

                //username
                $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                        ->from($this->_table_people)
                        ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                        ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                        ->where("$this->_table_department.person_id", $person_id)
                        ->where('deleted', 0)
                        ->like("username", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both')
                        ->order_by("username", "asc");
                $by_username = $this->db->get();
                foreach ($by_username->result() as $row) {
                    if ($row->username != '') {
                        $suggestions[] = array('label' => $row->username);
                    }
                }

                //fone
                $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                        ->from($this->_table_people)
                        ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                        ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                        ->where("$this->_table_department.person_id", $person_id)
                        ->where('deleted', 0)
                        ->like("phone_number", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both')
                        ->order_by("phone_number", "asc");
                $by_phone = $this->db->get();
                foreach ($by_phone->result() as $row) {
                    if ($row->phone_numer != '') {
                        $suggestions[] = array('value' => $row->person_id, 'label' => $row->phone_number, 'salary' => $row->em_salary_basic);
                    }
                }
            }
        }


        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    function search($person_id, $search, $limit = 20, $offset = 0, $column = 'lifetek_employees.person_id', $orderby = 'asc') {
        if ($this->config->item('speed_up_search_queries')) {
            $query = "
				select *
			from (
           	(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('employees') . ".username, " . $this->db->dbprefix('employees') . ".deleted
           	from " . $this->db->dbprefix('employees') . "
           	join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('employees') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
           	where first_name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
           	order by `" . $column . "` " . $orderby . ") union

		 	(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('employees') . ".username, " . $this->db->dbprefix('employees') . ".deleted
           	from " . $this->db->dbprefix('employees') . "
           	join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('employees') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
           	where last_name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
           	order by `" . $column . "` " . $orderby . ") union

			(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('employees') . ".username, " . $this->db->dbprefix('employees') . ".deleted
         	from " . $this->db->dbprefix('employees') . "
          	join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('employees') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
          	where email like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
          	order by `" . $column . "` " . $orderby . ") union

			(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('employees') . ".username, " . $this->db->dbprefix('employees') . ".deleted
        	from " . $this->db->dbprefix('employees') . "
        	join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('employees') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
        	where phone_number like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
        	order by `" . $column . "` " . $orderby . ") union

			(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('employees') . ".username, " . $this->db->dbprefix('employees') . ".deleted
      		from " . $this->db->dbprefix('employees') . "
      		join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('employees') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
      		where username like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
      		order by `" . $column . "` " . $orderby . ") union

			(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('employees') . ".username, " . $this->db->dbprefix('employees') . ".deleted
    		from " . $this->db->dbprefix('employees') . "
    		join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('employees') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
    		where CONCAT(`first_name`,' ',`last_name`)  like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
    		order by `" . $column . "` " . $orderby . ")
			) as search_results
			order by `" . $column . "` " . $orderby . " limit " . $this->db->escape((int) $offset) . ', ' . $this->db->escape((int) $limit);

            return $this->db->query($query);
        } else {
            if ($person_id == 1) {
                $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                        ->from($this->_table_people)
                        ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                        ->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									email LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									phone_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									username LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0")
                        ->order_by($column, $orderby)
                        ->limit($limit)
                        ->offset($offset);
            } else {
                if ($this->Jobs_regions->get_region_id($person_id)->num_rows() > 0) {
                    $this->db->select("$this->_table_employees.*, $this->_table_people.*,$this->_table_department.*,$this->_table_affiliates.*,$this->_table_city.*,$this->_table_regions.*")
                            ->from($this->_table_people)
                            ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                            ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                            ->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id")
                            ->join($this->_table_city, "$this->_table_affiliates.jobs_city_id = $this->_table_city.jobs_city_id")
                            ->join($this->_table_regions, "$this->_table_city.jobs_city_id = $this->_table_regions.jobs_regions_id")
                            ->where("$this->_table_regions.person_id", $person_id)
                            ->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									email LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									phone_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									username LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0")
                            ->order_by($column, $orderby)
                            ->limit($limit)
                            ->offset($offset);
                } else
                if ($this->Jobs_city->get_city_id($person_id)->num_rows() > 0) {
                    $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                            ->from($this->_table_people)
                            ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                            ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                            ->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id")
                            ->join($this->_table_city, "$this->_table_affiliates.jobs_city_id = $this->_table_city.jobs_city_id")
                            ->where("$this->_table_city.person_id", $person_id)
                            ->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									email LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									phone_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									username LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0")
                            ->order_by($column, $orderby)
                            ->limit($limit)
                            ->offset($offset);
                } else
                if ($this->Jobs_affiliates->get_aff_id($person_id)->num_rows() > 0) {
                    $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                            ->from($this->_table_people)
                            ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                            ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                            ->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id")
                            ->where("$this->_table_affiliates.person_id", $person_id)
                            ->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									email LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									phone_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									username LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0")
                            ->order_by($column, $orderby)
                            ->limit($limit)
                            ->offset($offset);
                } else
                if ($this->Jobs_department->get_dep_id($person_id)->num_rows() > 0) {
                    $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                            ->from($this->_table_people)
                            ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                            ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                            ->where("$this->_table_department.person_id", $person_id)
                            ->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									email LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									phone_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									username LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0")
                            ->order_by($column, $orderby)
                            ->limit($limit)
                            ->offset($offset);
                }
            }
            return $this->db->get();
        }
    }

    function search_count_all($person_id, $search, $limit = 10000) {
        if ($this->config->item('speed_up_search_queries')) {
            $query = "
				select *
			from (
           	(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('employees') . ".username, " . $this->db->dbprefix('employees') . ".deleted
           	from " . $this->db->dbprefix('employees') . "
           	join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('employees') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
           	where first_name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
           	order by `" . $column . "` " . $orderby . ") union

		 	(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('employees') . ".username, " . $this->db->dbprefix('employees') . ".deleted
           	from " . $this->db->dbprefix('employees') . "
           	join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('employees') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
           	where last_name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
           	order by `" . $column . "` " . $orderby . ") union

			(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('employees') . ".username, " . $this->db->dbprefix('employees') . ".deleted
         	from " . $this->db->dbprefix('employees') . "
          	join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('employees') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
          	where email like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
          	order by `" . $column . "` " . $orderby . ") union

			(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('employees') . ".username, " . $this->db->dbprefix('employees') . ".deleted
        	from " . $this->db->dbprefix('employees') . "
        	join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('employees') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
        	where phone_number like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
        	order by `" . $column . "` " . $orderby . ") union

			(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('employees') . ".username, " . $this->db->dbprefix('employees') . ".deleted
      		from " . $this->db->dbprefix('employees') . "
      		join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('employees') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
      		where username like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
      		order by `" . $column . "` " . $orderby . ") union

			(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('employees') . ".username, " . $this->db->dbprefix('employees') . ".deleted
    		from " . $this->db->dbprefix('employees') . "
    		join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('employees') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
    		where CONCAT(`first_name`,' ',`last_name`)  like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
    		order by `" . $column . "` " . $orderby . ")
			) as search_results
			order by `" . $column . "` " . $orderby . " limit " . $this->db->escape((int) $offset) . ', ' . $this->db->escape((int) $limit);

            $result = $this->db->query($query);
            return $result->num_rows();
        } else {
            if ($person_id == 1) {
                $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                        ->from($this->_table_people)
                        ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                        ->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									email LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									phone_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									username LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0")
                        ->order_by("last_name", "asc");
            } else {
                if ($this->Jobs_regions->get_region_id($person_id)->num_rows() > 0) {
                    $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                            ->from($this->_table_people)
                            ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                            ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                            ->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id")
                            ->join($this->_table_city, "$this->_table_affiliates.jobs_city_id = $this->_table_city.jobs_city_id")
                            ->join($this->_table_regions, "$this->_table_city.jobs_city_id = $this->_table_regions.jobs_regions_id")
                            ->where("$this->_table_regions.person_id", $person_id)
                            ->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									email LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									phone_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									username LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0")
                            ->order_by("last_name", "asc");
                } else
                if ($this->Jobs_city->get_city_id($person_id)->num_rows() > 0) {
                    $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                            ->from($this->_table_people)
                            ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                            ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                            ->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id")
                            ->join($this->_table_city, "$this->_table_affiliates.jobs_city_id = $this->_table_city.jobs_city_id")
                            ->where("$this->_table_city.person_id", $person_id)
                            ->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									email LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									phone_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									username LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0")
                            ->order_by("last_name", "asc");
                } else
                if ($this->Jobs_affiliates->get_aff_id($person_id)->num_rows() > 0) {
                    $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                            ->from($this->_table_people)
                            ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                            ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                            ->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id")
                            ->where("$this->_table_affiliates.person_id", $person_id)
                            ->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									email LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									phone_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									username LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0")
                            ->order_by("last_name", "asc");
                } else
                if ($this->Jobs_department->get_dep_id($person_id)->num_rows() > 0) {
                    $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                            ->from($this->_table_people)
                            ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                            ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                            ->where("$this->_table_department.person_id", $person_id)
                            ->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									email LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									phone_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									username LIKE '%" . $this->db->escape_like_str($search) . "%' or 
									CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0")
                            ->order_by("last_name", "asc");
                }
            }
            return $this->db->count_all_results();
        }
    }

//hung audi 24-3-15
    //region_detail
    function get_info_regions($jobs_regions_id) {
        $query = $this->db->where('jobs_regions_id', $jobs_regions_id)
                ->get($this->_table_regions);
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    function get_regions_id($person_id) {
        $sql = "SELECT * FROM $this->_table_regions
                WHERE person_id = $person_id ";
        $query = $this->db->query($sql);
        return $query;
    }

    function get_all_regions_detail($jobs_regions_id, $limit = 10000, $offset = 0, $col = 'lifetek_employees.person_id', $ord = 'DESC') {
        $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                ->from($this->_table_people)
                ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                ->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id")
                ->join($this->_table_city, "$this->_table_affiliates.jobs_city_id = $this->_table_city.jobs_city_id")
                ->where("$this->_table_city.jobs_regions_id", $jobs_regions_id)
                ->where('deleted', 0)
                ->order_by($col, $ord)
                ->limit($limit)
                ->offset($offset);
        $data = $this->db->get();
        return $data;
    }

    public function count_all_regions_detail($jobs_regions_id) {
        $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                ->from($this->_table_people)
                ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                ->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id")
                ->join($this->_table_city, "$this->_table_affiliates.jobs_city_id = $this->_table_city.jobs_city_id")
                ->where("$this->_table_city.jobs_regions_id", $jobs_regions_id)
                ->where('deleted', 0);
        return $this->db->count_all_results();
    }

    function search_regions_detail($jobs_regions_id, $search, $limit = 10, $offset = 0, $column = 'lifetek_employees.person_id', $orderby = 'asc') {

        $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                ->from($this->_table_people)
                ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                ->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id")
                ->join($this->_table_city, "$this->_table_affiliates.jobs_city_id = $this->_table_city.jobs_city_id")
                ->where("$this->_table_city.jobs_regions_id", $jobs_regions_id)
                ->where('deleted', 0)
                ->like("first_name", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both')
                ->order_by($column, $orderby)
                ->limit($limit)
                ->offset($offset);
        return $this->db->get();
    }

    function search_count_all_regions_detail($jobs_regions_id, $search) {
        $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                ->from($this->_table_people)
                ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                ->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id")
                ->join($this->_table_city, "$this->_table_affiliates.jobs_city_id = $this->_table_city.jobs_city_id")
                ->where("$this->_table_city.jobs_regions_id", $jobs_regions_id)
                ->where('deleted', 0)
                ->like("first_name", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        return $this->db->count_all_results();
    }

    function get_search_suggestions_regions_detail($jobs_regions_id, $search, $limit = 1000) {
        $suggestions = array();
        $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                ->from($this->_table_people)
                ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                ->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id")
                ->join($this->_table_city, "$this->_table_affiliates.jobs_city_id = $this->_table_city.jobs_city_id")
                ->where("$this->_table_city.jobs_regions_id", $jobs_regions_id)
                ->where('deleted', 0)
                ->like("first_name", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both')
                ->order_by("first_name", "DESC");
        $by_regions_detail = $this->db->get();
        foreach ($by_regions_detail->result() as $row) {
            $suggestions[] = array('label' => $row->first_name);
        }

        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    //city_detail
    function get_info_city($jobs_city_id) {
        $query = $this->db->where('jobs_city_id', $jobs_city_id)
                ->get($this->_table_city);
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    function get_city_id($person_id) {
        $sql = "SELECT * FROM $this->_table_city
                WHERE person_id = $person_id ";
        $query = $this->db->query($sql);
        return $query;
    }

    function get_city_id2($jobs_regions_id) {
        $sql = "SELECT * FROM " . $this->_table_city . "
                WHERE jobs_regions_id = " . $jobs_regions_id;
        $query = $this->db->query($sql);
        return $query;
    }

    function get_all_city_detail($jobs_city_id, $limit = 10000, $offset = 0, $col = 'lifetek_employees.person_id', $ord = 'DESC') {
        $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                ->from($this->_table_people)
                ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                ->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id")
                ->where("$this->_table_affiliates.jobs_city_id", $jobs_city_id)
                ->where('deleted', 0)
                ->order_by($col, $ord)
                ->limit($limit)
                ->offset($offset);
        $data = $this->db->get();
        return $data;
    }

    public function count_all_city_detail($jobs_city_id) {
        $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                ->from($this->_table_people)
                ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                ->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id")
                ->where("$this->_table_affiliates.jobs_city_id", $jobs_city_id)
                ->where('deleted', 0);
        return $this->db->count_all_results();
    }

    function search_city_detail($jobs_city_id, $search, $limit = 10, $offset = 0, $column = 'lifetek_employees.person_id', $orderby = 'asc') {

        $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                ->from($this->_table_people)
                ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                ->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id")
                ->where("$this->_table_affiliates.jobs_city_id", $jobs_city_id)
                ->where('deleted', 0)
                ->like("first_name", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both')
                ->order_by($column, $orderby)
                ->limit($limit)
                ->offset($offset);
        return $this->db->get();
    }

    function search_count_all_city_detail($jobs_city_id, $search) {
        $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                ->from($this->_table_people)
                ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                ->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id")
                ->where("$this->_table_affiliates.jobs_city_id", $jobs_city_id)
                ->where('deleted', 0)
                ->like("first_name", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        return $this->db->count_all_results();
    }

    function get_search_suggestions_city_detail($jobs_city_id, $search, $limit = 1000) {
        $suggestions = array();
        $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                ->from($this->_table_people)
                ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                ->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id")
                ->where("$this->_table_affiliates.jobs_city_id", $jobs_city_id)
                ->where('deleted', 0)
                ->like("first_name", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both')
                ->order_by("first_name", "DESC");
        $by_city_detail = $this->db->get();
        foreach ($by_city_detail->result() as $row) {
            $suggestions[] = array('label' => $row->first_name);
        }

        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    //affiliates_detail
    function get_info_affiliates($jobs_affiliates_id) {
        $query = $this->db->where('jobs_affiliates_id', $jobs_affiliates_id)
                ->get($this->_table_affiliates);
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    function get_affiliates_id($person_id) {
        $sql = "SELECT * FROM $this->_table_affiliates
                WHERE person_id = $person_id ";
        $query = $this->db->query($sql);
        return $query;
    }

    function get_aff_id2($jobs_city_id) {
        $sql = "SELECT * FROM " . $this->_table_affiliates . "
                WHERE jobs_city_id = " . $jobs_city_id;
        $query = $this->db->query($sql);
        return $query;
    }

    function get_all_affiliates_detail($jobs_affiliates_id, $limit = 10000, $offset = 0, $col = 'lifetek_employees.person_id', $ord = 'DESC') {
        $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                ->from($this->_table_people)
                ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                ->where("$this->_table_department.jobs_affiliates_id", $jobs_affiliates_id)
                ->where('deleted', 0)
                ->order_by($col, $ord)
                ->limit($limit)
                ->offset($offset);
        $data = $this->db->get();
        return $data;
    }

    public function count_all_affiliates_detail($jobs_affiliates_id) {
        $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                ->from($this->_table_people)
                ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                ->where("$this->_table_department.jobs_affiliates_id", $jobs_affiliates_id)
                ->where('deleted', 0);
        return $this->db->count_all_results();
    }

    function search_affiliates_detail($jobs_affiliates_id, $search, $limit = 10, $offset = 0, $column = 'lifetek_employees.person_id', $orderby = 'asc') {

        $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                ->from($this->_table_people)
                ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                ->where("$this->_table_department.jobs_affiliates_id", $jobs_affiliates_id)
                ->where('deleted', 0)
                ->like("first_name", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both')
                ->order_by($column, $orderby)
                ->limit($limit)
                ->offset($offset);
        return $this->db->get();
    }

    function search_count_all_affiliates_detail($jobs_affiliates_id, $search) {
        $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                ->from($this->_table_people)
                ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                ->where("$this->_table_department.jobs_affiliates_id", $jobs_affiliates_id)
                ->where('deleted', 0)
                ->like("first_name", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        return $this->db->count_all_results();
    }

    function get_search_suggestions_affiliates_detail($jobs_affiliates_id, $search, $limit = 1000) {
        $suggestions = array();
        $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                ->from($this->_table_people)
                ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                ->join($this->_table_department, "$this->_table_employees.department_id = $this->_table_department.department_id")
                ->where("$this->_table_department.jobs_affiliates_id", $jobs_affiliates_id)
                ->where('deleted', 0)
                ->like("first_name", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both')
                ->order_by("first_name", "DESC");
        $by_affiliates_detail = $this->db->get();
        foreach ($by_affiliates_detail->result() as $row) {
            $suggestions[] = array('label' => $row->first_name);
        }

        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    //department_detail
    function get_info_department($department_id) {
        $query = $this->db->where('department_id', $department_id)
                ->get($this->_table_department);
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    function get_department_id($person_id) {
        $sql = "SELECT * FROM $this->_table_department
                WHERE person_id = $person_id ";
        $query = $this->db->query($sql);
        return $query;
    }

    function get_all_department_detail($department_id, $limit = 10000, $offset = 0, $col = 'lifetek_employees.person_id', $ord = 'DESC') {
        $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                ->from($this->_table_people)
                ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                ->where("$this->_table_employees.department_id", $department_id)
                ->where('deleted', 0)
                ->order_by($col, $ord)
                ->limit($limit)
                ->offset($offset);
        $data = $this->db->get();
        return $data;
    }

    public function count_all_department_detail($department_id) {
        $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                ->from($this->_table_people)
                ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                ->where("$this->_table_employees.department_id", $department_id)
                ->where('deleted', 0);
        return $this->db->count_all_results();
    }

    function search_department_detail($department_id, $search, $limit = 10, $offset = 0, $column = 'lifetek_employees.person_id', $orderby = 'asc') {

        $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                ->from($this->_table_people)
                ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                ->where("$this->_table_employees.department_id", $department_id)
                ->where('deleted', 0)
                ->like("first_name", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both')
                ->order_by($column, $orderby)
                ->limit($limit)
                ->offset($offset);
        return $this->db->get();
    }

    function search_count_all_department_detail($department_id, $search) {
        $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                ->from($this->_table_people)
                ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                ->where("$this->_table_employees.department_id", $department_id)
                ->where('deleted', 0)
                ->like("first_name", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        return $this->db->count_all_results();
    }

    function get_search_suggestions_department_detail($department_id, $search, $limit = 1000) {
        $suggestions = array();
        $this->db->select("$this->_table_employees.*, $this->_table_people.*")
                ->from($this->_table_people)
                ->join($this->_table_employees, "$this->_table_people.person_id = $this->_table_employees.person_id")
                ->where("$this->_table_employees.department_id", $department_id)
                ->where('deleted', 0)
                ->like("first_name", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both')
                ->order_by("first_name", "DESC");
        $by_department_detail = $this->db->get();
        foreach ($by_department_detail->result() as $row) {
            $suggestions[] = array('label' => $row->first_name);
        }

        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    //end hung audi
    //15-9-15 Hưng Audi
    function get_search_suggestions_audi($search, $limit = 6996) {
        $suggestions = array();
        $by_name = $this->db->from('employees')
                ->join('people', 'employees.person_id=people.person_id')
                ->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0")
                ->order_by("last_name", "asc")
                ->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array(
                'label' => $row->first_name . ' ' . $row->last_name,
                'value' => $row->person_id,
                'cost_money' => $row->em_salary_basic / 26
            );
        }
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    function get_info_in_table_employee($employee_id) {
        $this->db->where("person_id", $employee_id);
        $query = $this->db->get("employees");
        return $query->row();
    }

    function update_permission_warehouse($data, $person_id) {
        $this->db->where("person_id", $person_id);
        return $this->db->update("employees", $data);
    }

}

?>
