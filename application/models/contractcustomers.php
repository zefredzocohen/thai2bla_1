<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * created by Hunght
 * edit by huyenlt 2/20/14
 */

class Contractcustomers extends CI_Model {

    function exists($id) {
        $this->db->from('contraccustomer');
        $this->db->where('id', $id);
        $query = $this->db->get();


        return ($query->num_rows() == 1);
    }

    function get_all($limit = 10000, $offset = 0, $col = 'id', $order = 'desc') {
        $this->db->from('contraccustomer');
        $this->db->where('deleted', 0);
        $this->db->order_by($col, $order);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function count_all() {
        $this->db->from('contraccustomer');
        $this->db->where('deleted', 0);
        return $this->db->count_all_results();
    }

    function get_info_one_more_person_id($id = -1) {
        $table_contract = $this->db->dbprefix('contraccustomer');
        $sql = "SELECT  person_id FROM " . $table_contract . " WHERE id = $id";
        $data = $this->db->query($sql);
        return $data->row();
    }

    function save(&$item_data, $id = false) {
        if (!$id or ! $this->exists($id)) {
            if ($this->db->insert('contraccustomer', $item_data)) {
                $item_data['id'] = $this->db->insert_id();
                return true;
            }
            return false;
        }
        $this->db->where('id', $id);
        return $this->db->update('contraccustomer', $item_data);
    }

    public function get_sup_type_search_suggestions($search, $limit = 25) {
        $suggestions = array();
        $this->db->from('suppliers_type');
        $this->db->like('name_sup_type', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('value' => $row->name_sup_type, 'label' => $row->name_sup_type, 'id' => $row->id);
        }
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    function get_info_one_more_contract($id = -1) {
        $table_contract = $this->db->dbprefix('contraccustomer');
        $sql = "SELECT  contract_file FROM " . $table_contract . " WHERE id = $id";
        $data = $this->db->query($sql);

        return $data->row();
    }

    //lay thong tin form :)
    function get_info($id) {
        //$this->db->select('id,name , parentid');
        $this->db->from('contraccustomer');
        $this->db->where('id', $id);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //Get empty base parent object, as $item_id is NOT an item
            $item_obj = new stdClass();

            //Get all the fields from items table
            $fields = $this->db->list_fields('contraccustomer');

            foreach ($fields as $field) {
                $item_obj->$field = '';
            }

            return $item_obj;
        }
    }

    function get_Contract_type() {
        $query = $this->db->get('contract_type');
        return $query->result_array();
    }

    //sorting goi
    function search_count_all($search) {
        if ($this->config->item('speed_up_search_queries')) {
            $query = "
			select *
			from (
			         (select *
			         from " . $this->db->dbprefix('contraccustomer') . "
			         where name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
			         order by `name` )
					union
			         (select *
			         from " . $this->db->dbprefix('contraccustomer') . "
			         where id like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
			         order by `name`)
					union
					(select *
			         from " . $this->db->dbprefix('contraccustomer') . "
			         where number_contract like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
			         order by `name`)
					 
			) as search_results
			order by `name`";
            $result = $this->db->query($query);
            return $result->num_rows();
        } else {
            $this->db->from('contraccustomer');
            $this->db->where("(name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			id LIKE '%" . $this->db->escape_like_str($search) . "%' or 		
			number_contract LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0");
            //location LIKE '%".$this->db->escape_like_str($search)."%') $cat_id and deleted=0");
            $this->db->order_by("name", "asc");
            $result = $this->db->get();
            return $result->num_rows();
        }
    }

    /// - tim kiem

    function search($search, $limit = 20, $offset = 0, $column = 'name', $orderby = 'asc') {
        if ($this->config->item('speed_up_search_queries')) {
            $query = "
                select *
                from (
                    (select *
                    from " . $this->db->dbprefix('contraccustomer') . "
                    where name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                    order by `" . $column . "`)
                           union
                    (select *
                    from " . $this->db->dbprefix('contraccustomer') . "
                    where id like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                    order by `" . $column . "`)
                           union
                    (select *
                    from " . $this->db->dbprefix('contraccustomer') . "
                    where number_contract like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                    order by `" . $column . "`)
                ) as search_results
                order by `" . $column . "` limit " . $offset . ',' . $limit;
            return $this->db->query($query);
        } else {
            $str_search = str_replace(array('_', '@', '#', '$', '%'), ' ', $search);
            $search_terms_array = explode(" ", $this->db->escape_like_str($str_search));
            //to keep track of which search term of the array we're looking at now	
            $search_name_criteria_counter = 0;
            $sql_search_name_criteria = '';
            //loop through array of search terms
            foreach ($search_terms_array as $x) {
                $sql_search_name_criteria.=
                        ($search_name_criteria_counter > 0 ? " AND " : "") .
                        "name LIKE '%" . $this->db->escape_like_str($x) . "%'";
                $search_name_criteria_counter++;
            }
            $this->db->from('contraccustomer');
            $this->db->where("((" .
                    $sql_search_name_criteria . ") or 
                id LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                number_contract LIKE '%" . $this->db->escape_like_str($search) . "%')  and deleted=0");
            //location LIKE '%".$this->db->escape_like_str($search)."%') $cat_id and deleted=0");
            $this->db->order_by($column, $orderby);
            $this->db->limit($limit);
            $this->db->offset($offset);
            return $this->db->get();
        }
    }

    // xo chu khi nhap gtri search
    function get_search_suggestions($search, $limit = 10000) {
        $suggestions = array();

        $this->db->from('contraccustomer');
        $this->db->like('name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->where('deleted', 0);
        $this->db->order_by("name", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('label' => $row->name);
        }

        $this->db->from('contraccustomer');
        $this->db->like('id', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->where('deleted', 0);
        $this->db->order_by("id", "asc");
        $by_item_number = $this->db->get();
        foreach ($by_item_number->result() as $row) {
            $suggestions[] = array('label' => $row->id);
        }

        $this->db->from('contraccustomer');
        $this->db->like('start_date', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->where('deleted', 0);
        $this->db->order_by("start_date", "asc");
        $by_item_start = $this->db->get();
        foreach ($by_item_start->result() as $row) {
            $suggestions[] = array('label' => $row->value);
        }

        $this->db->from('contraccustomer');
        $this->db->like('code_contract', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->where('deleted', 0);
        $this->db->order_by("code_contract", "asc");
        $by_item_code = $this->db->get();
        foreach ($by_item_code->result() as $row) {
            $suggestions[] = array('label' => $row->description);
        }
        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    function get_category_search_suggestions($search, $limit = 25) {
        $suggestions = array();

        $this->db->from('contraccustomer');
        $this->db->where('deleted', 0);
        $this->db->like('name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("name", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('value' => $row->id, 'label' => $row->name);
        }

        $this->db->from('contraccustomer');
        $this->db->where('deleted', 0);
        $this->db->like('id', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("id", "asc");
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    function delete_list($id) {
        if (!$select_inventory) {
            $this->db->where_in('id', $id);
        }
        return $this->db->update('contraccustomer', array('deleted' => 1));
    }

    function cleanup() {
        $item_data = array('id' => null);
        $this->db->where('deleted', 1);
        return $this->db->update('contraccustomer', $item_data);
    }

    function get_contractcustomer_type() {
        $query = $this->db->get('contract_type');
        return $query->result_array();
    }

    function get_info_typecontract($id_typecontract) {
        $this->db->where('id', $id_typecontract);
        $query = $this->db->get('contract_type');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else
            return null;
    }

    //Created by San
    function get_contraccustomer_expried($employee_id) {
        if ($employee_id == 1) {
            $this->db->where("deleted", 0);
            $query = $this->db->get("contraccustomer");
        } else {
            $this->db->select("customers.*,contraccustomer.*");
            $this->db->join('customers', 'contraccustomer.person_id=customers.person_id', 'inner');
            $this->db->where('customers.employee_id', $employee_id);
            $this->db->where("contraccustomer.deleted", 0);
            $query = $this->db->get("contraccustomer");
        }
        return $query->result_array();
    }

    function get_info_contraccustomer_expried($id) {
        $this->db->select("contraccustomer.*,people.first_name,people.last_name");
        $this->db->join('people', 'contraccustomer.person_id=people.person_id', 'left');
        $this->db->where('id', $id);
        $this->db->where("deleted", 0);
        $query = $this->db->get('contraccustomer');
        return $query->row_array();
    }

    function get_all_by_employee($employee_id, $limit = 10000, $offset = 0, $col = 'id', $order = 'desc') {
        if ($employee_id == 1) {
            $this->db->from('contraccustomer');
            $this->db->where('deleted', 0);
            $this->db->order_by($col, $order);
            $this->db->limit($limit);
            $this->db->offset($offset);
            return $this->db->get();
        } else {
            $this->db->select('contraccustomer.*,customers.*');
            $this->db->join('customers', 'contraccustomer.person_id=customers.person_id', 'inner');
            $this->db->where('customers.employee_id', $employee_id);
            $this->db->where('contraccustomer.deleted', 0);
            $this->db->order_by($col, $order);
            $this->db->limit($limit);
            $this->db->offset($offset);
            return $this->db->get('contraccustomer');
        }
    }

    function count_all_by_employee_id($employee_id) {
        if ($employee_id == 1) {
            $this->db->where('deleted', 0);
            $query = $this->db->get('contraccustomer');
            return $query->num_rows();
//		return $this->db->count_all_results();               
        } else {
            $this->db->select('contraccustomer.*,customers.*');
            $this->db->join('customers', 'contraccustomer.person_id=customers.person_id', 'inner');
            $this->db->where('customers.employee_id', $employee_id);
            $this->db->where('contraccustomer.deleted', 0);
            $query = $this->db->get('contraccustomer');
            return $query->num_rows();
//                return $this->db->count_all_results();
        }
//            $query = $this->db->get("contraccustomer");
//            return $query->num_rows();
    }

    function get_search_suggestions_by_employee($employee_id, $search, $limit = 10000) {
        $suggestions = array();

        $this->db->select('contraccustomer.*,customers.*');
        $this->db->from('contraccustomer');
        $this->db->join("customers", "contraccustomer.person_id=customers.person_id", "inner");
        $this->db->like('name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        if ($employee_id != 1) {
            $this->db->where('customers.employee_id', $employee_id);
        }
        $this->db->where('contraccustomer.deleted', 0);
        $this->db->order_by("name", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('label' => $row->name);
        }

        $this->db->select('contraccustomer.*,customers.*');
        $this->db->from('contraccustomer');
        $this->db->join("customers", "contraccustomer.person_id=customers.person_id", "inner");
        $this->db->like('contraccustomer.id', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        if ($employee_id != 1) {
            $this->db->where('customers.employee_id', $employee_id);
        }
        $this->db->where('contraccustomer.deleted', 0);
        $this->db->order_by("number_contract", "asc");
        $by_item_number = $this->db->get();
        foreach ($by_item_number->result() as $row) {
            $suggestions[] = array('label' => $row->number_contract);
        }

        $this->db->select('contraccustomer.*,customers.*');
        $this->db->from('contraccustomer');
        $this->db->join("customers", "contraccustomer.person_id=customers.person_id", "inner");
        $this->db->like('start_date', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        if ($employee_id != 1) {
            $this->db->where('customers.employee_id', $employee_id);
        }
        $this->db->where('contraccustomer.deleted', 0);
        $this->db->order_by("start_date", "asc");
        $by_item_start = $this->db->get();
        foreach ($by_item_start->result() as $row) {
            $suggestions[] = array('label' => $row->start_date);
        }
//            
        $this->db->select('contraccustomer.*,customers.*');
        $this->db->from('contraccustomer');
        $this->db->join("customers", "contraccustomer.person_id=customers.person_id", "inner");
        $this->db->like('code_contract', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        if ($employee_id != 1) {
            $this->db->where('customers.employee_id', $employee_id);
        }
        $this->db->where('contraccustomer.deleted', 0);
        $this->db->order_by("code_contract", "asc");
        $by_item_code = $this->db->get();
        foreach ($by_item_code->result() as $row) {
            $suggestions[] = array('label' => $row->code_contract);
        }
        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    function search_by_employee($employee_id, $search, $limit = 20, $offset = 0, $column = 'name', $orderby = 'asc') {
        if ($this->config->item('speed_up_search_queries')) {
            $query = "
                select *
                from (
                    (select *
                    from " . $this->db->dbprefix('contraccustomer') . "
                    where name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                    order by `" . $column . "`)
                           union
                    (select *
                    from " . $this->db->dbprefix('contraccustomer') . "
                    where id like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                    order by `" . $column . "`)
                           union
                    (select *
                    from " . $this->db->dbprefix('contraccustomer') . "
                    where number_contract like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                    order by `" . $column . "`)

                ) as search_results
                order by `" . $column . "` limit " . $offset . ',' . $limit;
            return $this->db->query($query);
        } else {
            if ($employee_id == 1) {
                $str_search = str_replace(array('_', '@', '#', '$', '%'), ' ', $search);
                $search_terms_array = explode(" ", $this->db->escape_like_str($str_search));
                //to keep track of which search term of the array we're looking at now	
                $search_name_criteria_counter = 0;
                $sql_search_name_criteria = '';
                //loop through array of search terms
                foreach ($search_terms_array as $x) {
                    $sql_search_name_criteria.=
                            ($search_name_criteria_counter > 0 ? " AND " : "") .
                            "name LIKE '%" . $this->db->escape_like_str($x) . "%'";
                    $search_name_criteria_counter++;
                }
                $this->db->from('contraccustomer');
                $this->db->where("((" .
                        $sql_search_name_criteria . ") or 
                    code_contract LIKE '%" . $this->db->escape_like_str($search) . "%' or start_date LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                    number_contract LIKE '%" . $this->db->escape_like_str($search) . "%')");
                $this->db->where("deleted", 0);
                //location LIKE '%".$this->db->escape_like_str($search)."%') $cat_id and deleted=0");
                $this->db->order_by($column, $orderby);
                $this->db->limit($limit);
                $this->db->offset($offset);
                return $this->db->get();
            } else {
                $str_search = str_replace(array('_', '@', '#', '$', '%'), ' ', $search);
                $search_terms_array = explode(" ", $this->db->escape_like_str($str_search));
                //to keep track of which search term of the array we're looking at now	
                $search_name_criteria_counter = 0;
                $sql_search_name_criteria = '';
                //loop through array of search terms
                foreach ($search_terms_array as $x) {
                    $sql_search_name_criteria.=
                            ($search_name_criteria_counter > 0 ? " AND " : "") .
                            "name LIKE '%" . $this->db->escape_like_str($x) . "%'";
                    $search_name_criteria_counter++;
                }
                $this->db->from('contraccustomer');
                $this->db->join('customers', 'contraccustomer.person_id=customers.person_id', 'inner');
                $this->db->where("((" .
                        $sql_search_name_criteria . ") or 
                    code_contract LIKE '%" . $this->db->escape_like_str($search) . "%' or start_date LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                    number_contract LIKE '%" . $this->db->escape_like_str($search) . "%')");
                $this->db->where('contraccustomer.deleted', 0);
                $this->db->where('employee_id', $employee_id);
                //location LIKE '%".$this->db->escape_like_str($search)."%') $cat_id and deleted=0");
                $this->db->order_by($column, $orderby);
                $this->db->limit($limit);
                $this->db->offset($offset);
                return $this->db->get();
            }
        }
    }

    function search_count_all_by_employee($employee_id, $search) {
        if ($this->config->item('speed_up_search_queries')) {
            $query = "
                select *
                from (
                    (select *
                    from " . $this->db->dbprefix('contraccustomer') . "
                    where name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                    order by `name` )
                           union
                    (select *
                    from " . $this->db->dbprefix('contraccustomer') . "
                    where id like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                    order by `name`)
                           union
                           (select *
                    from " . $this->db->dbprefix('contraccustomer') . "
                    where number_contract like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                    order by `name`)

                ) as search_results
                order by `name`";
            $result = $this->db->query($query);
            return $result->num_rows();
        } else {
            if ($employee_id == 1) {
                $str_search = str_replace(array('_', '@', '#', '$', '%'), ' ', $search);
                $search_terms_array = explode(" ", $this->db->escape_like_str($str_search));
                //to keep track of which search term of the array we're looking at now	
                $search_name_criteria_counter = 0;
                $sql_search_name_criteria = '';
                //loop through array of search terms
                foreach ($search_terms_array as $x) {
                    $sql_search_name_criteria.=
                            ($search_name_criteria_counter > 0 ? " AND " : "") .
                            "name LIKE '%" . $this->db->escape_like_str($x) . "%'";
                    $search_name_criteria_counter++;
                }
                $this->db->from('contraccustomer');
                $this->db->where("((" .
                        $sql_search_name_criteria . ") or 
                    code_contract LIKE '%" . $this->db->escape_like_str($search) . "%' or start_date LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                    number_contract LIKE '%" . $this->db->escape_like_str($search) . "%')");
                $this->db->where("deleted", 0);
                //location LIKE '%".$this->db->escape_like_str($search)."%') $cat_id and deleted=0");

                $query = $this->db->get();
                return $query->num_rows();
            } else {
                $str_search = str_replace(array('_', '@', '#', '$', '%'), ' ', $search);
                $search_terms_array = explode(" ", $this->db->escape_like_str($str_search));
                //to keep track of which search term of the array we're looking at now	
                $search_name_criteria_counter = 0;
                $sql_search_name_criteria = '';
                //loop through array of search terms
                foreach ($search_terms_array as $x) {
                    $sql_search_name_criteria.=
                            ($search_name_criteria_counter > 0 ? " AND " : "") .
                            "name LIKE '%" . $this->db->escape_like_str($x) . "%'";
                    $search_name_criteria_counter++;
                }
                $this->db->from('contraccustomer');
                $this->db->join('customers', 'contraccustomer.person_id=customers.person_id', 'inner');
                $this->db->where("((" .
                        $sql_search_name_criteria . ") or 
                    code_contract LIKE '%" . $this->db->escape_like_str($search) . "%' or start_date LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                    number_contract LIKE '%" . $this->db->escape_like_str($search) . "%')");
                $this->db->where('contraccustomer.deleted', 0);
                $this->db->where('employee_id', $employee_id);
                //location LIKE '%".$this->db->escape_like_str($search)."%') $cat_id and deleted=0");
                $query = $this->db->get();
                return $query->num_rows();
            }
        }
    }
    //Lay thong tin hop dong theo ma khach hang
    function get_info_contraccustomer_by_customer($person_id){
        $this->db->where("person_id",$person_id);
        $query = $this->db->get("contraccustomer");
        return $query->row_array();
    }
}
?>