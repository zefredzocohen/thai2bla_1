<?php
class City extends CI_Model {
	function get_all1() {
		$this->db->order_by("name", "inc");
		$query = $this->db->get('cities');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else
		return null;
	}
	function get_all($limit = 100, $offset = 0, $col = 'id_city', $order = 'desc') {
		$this->db->from('cities');
		$this->db->where('delete', 0);
		$this->db->order_by($col, $order);
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();
	}
	function count_all() {
        $this->db->from('cities');
        $this->db->where('delete', 0);
        return $this->db->count_all_results();
    }
	function get_search_suggestions($search, $limit = 25) {
        $suggestions = array();
        $this->db->from('cities');
        $this->db->where('delete', 0);
        $this->db->like('name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("name", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('label' => $row->name);
        }

        $this->db->from('cities');
        $this->db->like('id_city', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->where('delete', 0);
        $this->db->order_by("id_city", "asc");
        $by_item_number = $this->db->get();
        foreach ($by_item_number->result() as $row) {
            $suggestions[] = array('label' => $row->id_city);
        }

        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }
	function search_count_all($search) {
        $this->db->where('delete', 0);
        $this->db->from('cities');
        $this->db->where("name LIKE '%" . $this->db->escape_like_str($search) . "%'  ");
        $this->db->order_by("name", "asc");
        $result = $this->db->get();
        return $result->num_rows();
    }
	function search($search, $limit = 10, $offset = 0, $column = 'name', $orderby = 'asc') {
        $this->db->where('delete', 0);
        $this->db->from('cities');
        $this->db->where("name LIKE '%" . $this->db->escape_like_str($search) . "%'  ");
        $this->db->order_by($column, $orderby);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }
	function save(&$item_data, $id_city = false) {
        if (!$id_city or ! $this->exists($id_city)) {
            if ($this->db->insert('cities', $item_data)) {
                $item_data['id_city'] = $this->db->insert_id();
                return true;
            }
            return false;
        } else {
            $this->db->where('id_city', $id_city);
            return $this->db->update('cities', $item_data);
        }
    }
    function exists($id_city) {
        $this->db->from('cities');
        $this->db->where('id_city', $id_city);
        $query = $this->db->get();

        return ($query->num_rows() == 1);
    }
	//check trùng tên
    function getname($id) {
        if ($id > 0) {
            $this->db->where('id_city !=', $id);
            $this->db->where('delete', 0);
            $this->db->from('cities');
            $query = $this->db->get();
        } elseif ($id = -1) {
            $this->db->where('delete', 0);
            $this->db->from('cities');
            $query = $this->db->get();
        }
        foreach ($query->result_array() as $q) {
            $result[] = $q;
        }
        return $result;
    }
	//check trùng zip_code
    function get_zip_code($id) {
        if ($id > 0) {
            $this->db->where('id_city !=', $id);
            $this->db->where('delete', 0);
            $this->db->from('cities');
            $query = $this->db->get();
        } elseif ($id = -1) {
            $this->db->where('delete', 0);
            $this->db->from('cities');
            $query = $this->db->get();
        }
        foreach ($query->result_array() as $q) {
            $result[] = $q;
        }
        return $result;
    }
	function delete_list($id_city) {
        if (!$select_inventory) {
            $this->db->where_in('id_city', $id_city);
        }
        return $this->db->update('cities', array('delete' => 1));
    }
    
	function get_info($id_city) {
		$this->db->where('id_city', $id_city);
		$query = $this->db->get('cities');
		if ($query->num_rows() > 0) {
			return $query->row();
		} else
		return null;
	}

	function customer_info($id_city) {
		$this->db->from('people');
		$this->db->join('customers', 'customers.person_id = people.person_id');
		$this->db->where('people.city', $id_city);
		$this->db->where('customers.deleted', 0);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else
		return null;
	}

	//Created by San
	//Lay thong tin khach hang theo thanh pho, phan loai theo nv quan ly, theo loai khach hang
	function customer_info_in_city_by_employee($id_city, $employee_id, $employee_select, $type_customer) {
		if ($employee_id == 1) {
			if ($employee_select && ($employee_select != 1)) {
				if ($type_customer == 0) {
					$this->db->from('people');
					$this->db->join('customers', 'customers.person_id = people.person_id');
					$this->db->where('people.city', $id_city);
					$this->db->where('customers.employee_id', $employee_select);
					$this->db->where('customers.deleted', 0);
				} else {
					$this->db->from('people');
					$this->db->join('customers', 'customers.person_id = people.person_id');
					$this->db->where('people.city', $id_city);
					$this->db->where('customers.employee_id', $employee_select);
					$this->db->where('customers.type_customer', $type_customer);
					$this->db->where('customers.deleted', 0);
				}
				$query = $this->db->get();
			} else {
				if ($type_customer == 0) {
					$this->db->from('people');
					$this->db->join('customers', 'customers.person_id = people.person_id');
					$this->db->where('people.city', $id_city);
					$this->db->where('customers.deleted', 0);
				} else {
					$this->db->from('people');
					$this->db->join('customers', 'customers.person_id = people.person_id');
					$this->db->where('people.city', $id_city);
					$this->db->where('customers.type_customer', $type_customer);
					$this->db->where('customers.deleted', 0);
				}
				$query = $this->db->get();
			}
		} else {
			if ($type_customer == 0) {
				$this->db->from('people');
				$this->db->join('customers', 'customers.person_id = people.person_id');
				$this->db->where('people.city', $id_city);
				$this->db->where('customers.employee_id', $employee_id);
				$this->db->where('customers.deleted', 0);
			} else {
				$this->db->from('people');
				$this->db->join('customers', 'customers.person_id = people.person_id');
				$this->db->where('people.city', $id_city);
				$this->db->where('customers.employee_id', $employee_id);
				$this->db->where('customers.type_customer', $type_customer);
				$this->db->where('customers.deleted', 0);
			}
			$query = $this->db->get();
		}
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else
		return null;
	}
	function get_people_by_city($id_city){
		$query=$this->db->where('city',$id_city)
				->get('people');
		return $query;				
	}
    //Lay thong tin city theo zip_code
    function get_city_by_zip_code($zip_code){
        $this->db->where('zip_code',$zip_code);
        $this->db->where('delete', 0);
        $query = $this->db->get('cities');

        return $query->row_array();
    }
}

?>