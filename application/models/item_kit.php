<?php

class Item_kit extends CI_Model {

    //check trùng tên
    function getname($id) {
        if ($id > 0) {
            $this->db->select('name');
            $this->db->where('item_kit_id !=', $id);
            $this->db->where('deleted', 0);
            $this->db->from('item_kits');
            $query = $this->db->get();
        } elseif ($id = -1) {
            $this->db->select('name');
            $this->db->where('deleted', 0);
            $this->db->from('item_kits');
            $query = $this->db->get();
        }
        foreach ($query->result_array() as $q) {
            $result[] = $q;
        }
        return $result;
    }

    /*
      Determines if a given item_id is an item kit
     */

    function exists($item_kit_id) {
        $this->db->from('item_kits');
        $this->db->where('item_kit_id', $item_kit_id);
        $this->db->where('deleted', 0);
        $query = $this->db->get();

        return ($query->num_rows() == 1);
    }

    /*
      Returns all the item kits
     */

    function get_all($limit = 10000, $offset = 0, $col = 'item_kit_id', $ord = 'desc') {
        $this->db->from('item_kits');
        $this->db->where('deleted', 0);
        $this->db->order_by($col, $ord);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function count_all() {
        $this->db->from('item_kits');
        $this->db->where('deleted', 0);
        return $this->db->count_all_results();
    }

    /*
      Gets information about a particular item kit
     */

    function get_info($item_kit_id) {
        $this->db->from('item_kits');
        $this->db->where('item_kit_id', $item_kit_id);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //Get empty base parent object, as $item_kit_id is NOT an item kit
            $item_obj = new stdClass();

            //Get all the fields from items table
            $fields = $this->db->list_fields('item_kits');

            foreach ($fields as $field) {
                $item_obj->$field = '';
            }

            return $item_obj;
        }
    }

    /*
      Get an item_kit_id given an item kit number
     */

    function get_item_kit_id($item_kit_number) {
        $this->db->from('item_kits');
        $this->db->where('item_kit_number', $item_kit_number);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row()->item_kit_id;
        }

        return false;
    }

    /*
      Gets information about multiple item kits
     */

    function get_multiple_info($item_kit_ids) {
        $this->db->from('item_kits');
        $this->db->where_in('item_kit_id', $item_kit_ids);
        $this->db->order_by("name", "asc");
        return $this->db->get();
    }

    /*
      Inserts or updates an item kit
     */

    function save(&$item_kit_data, $item_kit_id = false) {
        if (!$item_kit_id or ! $this->exists($item_kit_id)) {
            if ($this->db->insert('item_kits', $item_kit_data)) {
                $item_kit_data['item_kit_id'] = $this->db->insert_id();
                return true;
            }
            return false;
        }
        $this->db->where('item_kit_id', $item_kit_id);
        return $this->db->update('item_kits', $item_kit_data);
    }

    /*
      Deletes one item kit
     */

    function delete($item_kit_id) {
        $this->db->where('item_kit_id', $item_kit_id);
        return $this->db->update('item_kits', array('deleted' => 1));
    }

    /*
      Deletes a list of item kits
     */

    function delete_list($item_kit_ids) {
        $this->db->where_in('item_kit_id', $item_kit_ids);
        return $this->db->update('item_kits', array('deleted' => 1));
    }

    /*
      Get search suggestions to find kits
     */

    function get_search_suggestions($search, $limit = 25) {
        $suggestions = array();

        $this->db->from('item_kits');
        $this->db->like('name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->where('deleted', 0);
        $this->db->order_by("name", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('label' => $row->name);
        }

        $this->db->from('item_kits');
        $this->db->like('item_kit_number', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->where('deleted', 0);
        $this->db->order_by("item_kit_number", "asc");
        $by_item_kit_number = $this->db->get();
        foreach ($by_item_kit_number->result() as $row) {
            $suggestions[] = array('label' => $row->item_kit_number);
        }

        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    function get_item_kit_search_suggestions($search, $limit = 25) {
        $suggestions = array();

        $this->db->from('item_kits');
        $this->db->like('name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->where('deleted', 0);
        $this->db->order_by("name", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('value' => 'KIT ' . $row->item_kit_id, 'label' => $row->name);
        }

        $this->db->from('item_kits');
        $this->db->like('item_kit_number', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->where('deleted', 0);
        $this->db->order_by("item_kit_number", "asc");
        $by_item_kit_number = $this->db->get();
        foreach ($by_item_kit_number->result() as $row) {
            $suggestions[] = array('value' => 'KIT ' . $row->item_kit_id, 'label' => $row->item_kit_number);
        }

        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    /*
      Preform a search on items kits
     */

    function search11($search, $cat = '', $limit = 20, $offset = 0, $column = 'name', $orderby = 'asc') {
        if ($cat)
            $cat_id = "and category = $cat ";
        else
            $cat_id = '';
        if ($this->config->item('speed_up_search_queries')) {
            $query = "
	   select *
	   from (
				(select *
				from " . $this->db->dbprefix('items') . "
				where name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
				order by `" . $column . "`)
		 union
				(select *
				from " . $this->db->dbprefix('items') . "
				where item_number like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
				order by `" . $column . "`)
		
	   ) as search_results
	   order by `" . $column . "` limit " . $offset . ',' . $limit;
            return $this->db->query($query);
        } else {
            $str_search = str_replace(array('_', '@', '#', '$', '%', '-'), ' ', $search);

            $search_terms_array = explode(" ", $this->db->escape_like_str($str_search));

            //to keep track of which search term of the array we're looking at now 
            $search_name_criteria_counter = 0;
            $sql_search_name_criteria = '';
            //loop through array of search terms
            foreach ($search_terms_array as $x) {

                $sql_search_name_criteria.=
                        ($search_name_criteria_counter > 0 ? " or " : "") .
                        "item_number LIKE '%" . $this->db->escape_like_str($x) . "%'";

                $search_name_criteria_counter++;
            }

            $this->db->from('items');
            $this->db->where("((" .
                    $sql_search_name_criteria . ") or
		   name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		   CONCAT(`name`,'',`item_number`) LIKE '%" . $this->db->escape_like_str($search) . "' or 
		   item_number LIKE '%" . $this->db->escape_like_str($search) . "') $cat_id and deleted=0");
            $this->db->order_by($column, $orderby);
            $this->db->limit($limit);
            $this->db->offset($offset);
            return $this->db->get();
        }
    }

    function search($search, $cat = ' ', $status = ' ', $limit = 16, $offset = 0, $column = 'name', $orderby = 'asc') {
        if ($cat)
            $cat_id = "and category = $cat ";
        else
            $cat_id = '';

        $status_8 = $status ? "and status = $status " : '';

        $this->db->from('item_kits');

        if ($this->config->item('speed_up_search_queries')) {
            $this->db->where("name LIKE '" . $this->db->escape_like_str($search) . "%' or 
			description LIKE '" . $this->db->escape_like_str($search) . "%'");
        } else {
            $this->db->where("(name LIKE '%" . $this->db->escape_like_str($search) .
                    "%' or item_kit_number LIKE '%" . $this->db->escape_like_str($search) . "%' or
			description LIKE '%" . $this->db->escape_like_str($search) . "%') $cat_id  $status_8 and deleted=0");
        }
        $this->db->order_by($column, $orderby);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function search_count_all($search, $cat, $status) {
        if ($cat)
            $cat_id = "and category = $cat ";
        else
            $cat_id = '';

        $status_8 = $status ? "and status = $status " : '';

        $this->db->from('item_kits');

        if ($this->config->item('speed_up_search_queries')) {
            $this->db->where("name LIKE '" . $this->db->escape_like_str($search) . "%' or 
			description LIKE '" . $this->db->escape_like_str($search) . "%'");
        } else {
            $this->db->where("(name LIKE '%" . $this->db->escape_like_str($search) .
                    "%' or item_kit_number LIKE '%" . $this->db->escape_like_str($search) . "%' or
			description LIKE '%" . $this->db->escape_like_str($search) . "%') $cat_id $status_8 and deleted=0");
        }
        $this->db->order_by("name", "asc");
        $result = $this->db->get();
        return $result->num_rows();
    }

    function find_item_kit_follow_cat($id_cat_item) {
        $this->db->where('id_cat_item', $id_cat_item);
        $this->db->where('deleted', 0);
        $this->db->where('order', 0);
        $query = $this->db->get('item_kits');
        return $query->result_array();
    }

    //====Create by San 03/03/2015
    //Luu thong tin san pham can san xuat duoc tao moi
    function save_product(&$item_kit_data, $item_kit_id = false) {
        if (!$item_kit_id or ! $this->exists($item_kit_id)) {
            if ($this->db->insert('item_kits', $item_kit_data)) {
                $item_kit_data['item_kit_id'] = $this->db->insert_id();
                return true;
            }
            return false;
        }
        $this->db->where('item_kit_id', $item_kit_id);
        return $this->db->update('item_kits', $item_kit_data);
    }

    //Check trung ma san pham
    function getItemKitNumber($id) {
        if ($id > 0) {
            $this->db->select('item_kit_number');
            $this->db->where('item_kit_id !=', $id);
            $this->db->where('deleted', 0);
            $this->db->from('item_kits');
            $query = $this->db->get();
        } elseif ($id = -1) {
            $this->db->select('item_kit_number');
            $this->db->where('deleted', 0);
            $this->db->from('item_kits');
            $query = $this->db->get();
        }
        foreach ($query->result_array() as $q) {
            $result[] = $q;
        }
        return $result;
    }

    //Cap nhat thong tin lenh san xuat
    function update_item_production($data, $id, $item_kit_id) {
        $this->db->where('id', $id);
        $this->db->where('item_kit_id', $item_kit_id);
        $this->db->update("item_production", $data);
    }

    //Luu thong tin nguyen vat lieu san xuat theo lenh san xuat
    function save_item_history_production($data) {
        $this->db->insert("item_history_production", $data);
    }

    //Lay thong tin lenh san xuat
    function get_info_item_production($id) {
        $this->db->where("id", $id);
        $query = $this->db->get("item_production");
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //Get empty base parent object, as $item_kit_id is NOT an item kit
            $item_obj = new stdClass();

            //Get all the fields from items table
            $fields = $this->db->list_fields('item_kits');

            foreach ($fields as $field) {
                $item_obj->$field = '';
            }

            return $item_obj;
        }
    }
    //Check su ton tai cua san pham co trong bang luu chuyen kho (warehouse_item) hay chua
    function check_item_in_warehouse_item($store, $item_id) {
        $this->db->where("warehouse_id", $store);
        $this->db->where("item_id", $item_id);
        $query = $this->db->get("warehouse_items");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    //Them moi thanh pham vao kho thanh pham
    function save_product_in_store_product($data) {
        $this->db->insert("warehouse_items", $data);
    }

    //Cap nhat thanh pham trong kho thanh pham
    function update_product_in_store_product($data, $store, $id) {
        $this->db->where("warehouse_id", $store);
        $this->db->where("item_id", $id);
        $this->db->update("warehouse_items", $data);
    }

    //Cap nhat lai trang thai click trong bang item_kits
    function update_click($data, $id) {
        $this->db->where('item_kit_id !=', $id);
        $this->db->update('item_kits', $data);
    }

    function count_all_design_template($item_kit_id) {
        $this->db->from("item_kit_design_template");
        $this->db->where('item_kit_id', $item_kit_id);
        $this->db->where('delete', 0);
        return $this->db->count_all_results();
    }

    function get_all_design_template($item_kit_id, $limit = 10000, $offset = 0, $col = 'id_design_template', $ord = 'desc') {
        $this->db->from("item_kit_design_template");
        $this->db->where("item_kit_id", $item_kit_id);
        $this->db->where('delete', 0);
        $this->db->order_by($col, $ord);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function get_info_design_template($id_design_template) {
        $this->db->from('item_kit_design_template');
        $this->db->where('id_design_template', $id_design_template);
        $this->db->where('delete', 0);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //Get empty base parent object, as $item_kit_id is NOT an item kit
            $item_obj = new stdClass();

            //Get all the fields from items table
            $fields = $this->db->list_fields('item_kit_design_template');

            foreach ($fields as $field) {
                $item_obj->$field = '';
            }

            return $item_obj;
        }
    }

    function exists_design_template($id_design_template) {
        $this->db->from('item_kit_design_template');
        $this->db->where('id_design_template', $id_design_template);
        $this->db->where('delete', 0);
        $query = $this->db->get();

        return ($query->num_rows() == 1);
    }

    function save_design_template(&$design_template_data, $id_design_template = false) {
        if (!$id_design_template or ! $this->exists_design_template($id_design_template)) {
            if ($this->db->insert('item_kit_design_template', $design_template_data)) {
                $design_template_data['id_design_template'] = $this->db->insert_id();
                return true;
            }
            return false;
        }
        $this->db->where('id_design_template', $id_design_template);
        return $this->db->update('item_kit_design_template', $design_template_data);
    }

    function get_search_suggestions_design_template($item_kit_id, $search, $limit = 25) {
        $suggestions = array();
        $this->db->from('item_kit_design_template');
        $this->db->where('item_kit_id', $item_kit_id);
        $this->db->where('delete', 0);
        $this->db->like('code_design_template', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("code_design_template", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('label' => $row->code_design_template);
        }

        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    function search_design_template($item_kit_id, $search, $limit = 10000, $offset = 0, $column = 'id_design_template', $orderby = 'desc') {
        $this->db->from('item_kit_design_template');
        $this->db->where("(code_design_template LIKE '%" . $this->db->escape_like_str($search) . "%')");
        $this->db->where('item_kit_id', $item_kit_id);
        $this->db->where('delete', 0);
        $this->db->order_by($column, $orderby);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function search_count_all_design_template($item_kit_id, $search) {
        $this->db->from('item_kit_design_template');
        $this->db->where('item_kit_id', $item_kit_id);
        $this->db->where("(code_design_template LIKE '%" . $this->db->escape_like_str($search) . "%')");
        $this->db->where('delete', 0);
        $result = $this->db->get();
        return $result->num_rows();
    }

    function delete_list_design_template($id_design_templates) {
        $this->db->where_in('id_design_template', $id_design_templates);
        return $this->db->update('item_kit_design_template', array('delete' => 1));
    }

    function check_code_design_template($id_design_template, $code_design_template) {
        if ($id_design_template) {
            $this->db->where("id_design_template !=", $id_design_template);
        }
        $this->db->where("code_design_template", $code_design_template);
        $this->db->where('delete', 0);
        $query = $this->db->get("item_kit_design_template");
        if ($query->num_rows() == 0) {
            return true;
        } else {
            return false;
        }
    }

    function get_info_formula_materials($feature_id) {
        $this->db->where("feature_id", $feature_id);
        $query = $this->db->get("item_kit_formula_materials");
        return $query->result_array();
    }

    function get_info_formula_materials_item($item_id) {
        return $this->db->where("item_id", $item_id)
                        ->get("item_kit_formula_materials")
                        ->row();
    }

    function save_formula_materials(&$item_kit_formula_materials, $feature_id) {
        $this->db->trans_start();
        $this->delete_formula_materials($feature_id);
        foreach ($item_kit_formula_materials as $row) {
            $row['feature_id'] = $feature_id;
            $this->db->insert('item_kit_formula_materials', $row);
        }
        $this->db->trans_complete();
        return true;
    }

    function delete_formula_materials($feature_id) {
        return $this->db->delete('item_kit_formula_materials', array('feature_id' => $feature_id));
    }

    function get_all_production_flow_template($id_design_template, $limit = 10000, $offset = 0, $col = 'production_order', $ord = 'asc') {
        $this->db->join("processes", "production_flow_template.id_processes = processes.id_processes", "join");
        $this->db->where("id_design_template", $id_design_template);
        $this->db->order_by($col, $ord);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get("production_flow_template");
    }

    function count_all_production_flow_template($id_design_template) {
        $this->db->join("processes", "production_flow_template.id_processes = processes.id_processes", "join");
        $this->db->from("production_flow_template");
        $this->db->where('id_design_template', $id_design_template);
        return $this->db->count_all_results();
    }

    function get_info_production_flow_template($id_production_flow_template) {
        $this->db->from('production_flow_template');
        $this->db->where('id_production_flow_template', $id_production_flow_template);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //Get empty base parent object, as $item_kit_id is NOT an item kit
            $item_obj = new stdClass();

            //Get all the fields from items table
            $fields = $this->db->list_fields('production_flow_template');

            foreach ($fields as $field) {
                $item_obj->$field = '';
            }

            return $item_obj;
        }
    }

    function exist_production_flow_template($id_production_flow_template) {
        $this->db->from('production_flow_template');
        $this->db->where('id_production_flow_template', $id_production_flow_template);
        $query = $this->db->get();

        return ($query->num_rows() == 1);
    }

    function save_production_flow_template(&$data_production_flow_template, $id_production_flow_template = false) {
        if (!$id_production_flow_template or ! $this->exist_production_flow_template($id_production_flow_template)) {
            if ($this->db->insert('production_flow_template', $data_production_flow_template)) {
                $data_production_flow_template['id_production_flow_template'] = $this->db->insert_id();
                return true;
            }
            return false;
        }
        $this->db->where('id_production_flow_template', $id_production_flow_template);
        return $this->db->update('production_flow_template', $data_production_flow_template);
    }

    function search_production_flow_template($id_design_template, $search, $limit = 10000, $offset = 0, $column = 'production_order', $orderby = 'asc') {
        $this->db->from('production_flow_template');
        $this->db->join("processes", "production_flow_template.id_processes = processes.id_processes", "join");
        $this->db->where("(name_processes LIKE '%" . $this->db->escape_like_str($search) . "%')");
        $this->db->where('id_design_template', $id_design_template);
        $this->db->order_by($column, $orderby);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function search_count_all_production_flow_template($id_design_template, $search) {
        $this->db->from('production_flow_template');
        $this->db->join("processes", "production_flow_template.id_processes = processes.id_processes", "join");
        $this->db->where('id_design_template', $id_design_template);
        $this->db->where("(name_processes LIKE '%" . $this->db->escape_like_str($search) . "%')");
        $result = $this->db->get();
        return $result->num_rows();
    }

    function get_search_suggestions_production_flow_template($id_design_template, $search, $limit = 25) {
        $suggestions = array();
        $this->db->from('production_flow_template');
        $this->db->join("processes", "production_flow_template.id_processes = processes.id_processes", "join");
        $this->db->where('id_design_template', $id_design_template);
        $this->db->like('name_processes', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("name_processes", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('label' => $row->name_processes);
        }

        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    function get_info_production_flow_template_by_order($id_design_template, $production_order) {
        $this->db->where("id_design_template", $id_design_template);
        $this->db->where("production_order", $production_order);
        $query = $this->db->get("production_flow_template");
        return $query->row_array();
    }

    //processes
    function get_list_processes() {
        $this->db->from("processes");
        $this->db->where("deleted", 0);
        $query = $this->db->get();
        return $query->result_array();
    }

    function count_all_processes() {
        $this->db->from("processes");
        $this->db->where("deleted", 0);
        return $this->db->count_all_results();
    }

    function get_all_processes($limit = 10000, $offset = 0, $col = "id_processes", $ord = "desc") {
        $this->db->from("processes");
        $this->db->where("deleted", 0);
        $this->db->order_by($col, $ord);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function get_info_processes($id_processes) {
        $q = $this->db->where('id_processes', $id_processes)
                ->get('processes');
        if ($q->num_rows() == 1) {
            return $q->row();
        } else {
            //Get empty base parent object, as $item_kit_id is NOT an item kit
            $item_obj = new stdClass();

            //Get all the fields from items table
            $fields = $this->db->list_fields('processes');

            foreach ($fields as $field) {
                $item_obj->$field = '';
            }

            return $item_obj;
        }
    }

    function save_processes(&$data_processes, $id_processes = false) {
        if (!$id_processes || !$this->exist_processes($id_processes)) {
            if ($this->db->insert('processes', $data_processes)) {
                $data_processes['id_processes'] = $this->db->insert_id();
                return true;
            }
            return false;
        }
        $this->db->where("id_processes", $id_processes);
        return $this->db->update("processes", $data_processes);
    }

    function exist_processes($id_processes) {
        $this->db->from("processes");
        $this->db->where("id_processes", $id_processes);
        $query = $this->db->get();
        return ($query->num_rows() == 1);
    }

    function search_processes($search, $cat_pro, $limit = 10000, $offset = 0, $column = 'id_processes', $orderby = 'desc') {
        $this->db->from('processes');
        $this->db->where("(name_processes LIKE '%" . $search . "%' or id_processes LIKE '%" . $search . "%')");
        $this->db->where("deleted", 0);
        if ($cat_pro) {
            $this->db->where("cat_pro_id", $cat_pro);
        }
        $this->db->order_by($column, $orderby);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function search_count_all_processes($search, $cat_pro) {
        $this->db->from('processes');
        $this->db->where("(name_processes LIKE '%" . $search . "%' or id_processes LIKE '%" . $search . "%')");
        $this->db->where("deleted", 0);
        if ($cat_pro) {
            $this->db->where("cat_pro_id", $cat_pro);
        }
        $result = $this->db->get();
        return $result->num_rows();
    }

    function get_search_suggestions_processes($search, $limit = 25) {
        $suggestions = array();
        if ($search) {
            $this->db->from('processes');
            $this->db->like('name_processes', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
            $this->db->where("deleted", 0);
            $this->db->order_by("name_processes", "asc");
            $by_name = $this->db->get();
            foreach ($by_name->result() as $row) {
                $suggestions[] = array(
                    'label' => $row->name_processes
                );
            }

            $this->db->from('processes');
            $this->db->like('id_processes', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
            $this->db->where("deleted", 0);
            $this->db->order_by("name_processes", "asc");
            $by_name = $this->db->get();
            foreach ($by_name->result() as $row) {
                $suggestions[] = array(
                    'label' => $row->id_processes
                );
            }
        } else {
            $this->db->from('processes');
            $this->db->like('name_processes', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
            $this->db->where("deleted", 0);
            $this->db->order_by("name_processes", "asc");
            $by_name = $this->db->get();
            foreach ($by_name->result() as $row) {
                $suggestions[] = array(
                    'label' => $row->name_processes
                );
            }
        }

        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    function delete_processes($id_processes) {
        $this->db->where_in("id_processes", $id_processes);
        return $this->db->update("processes", array("deleted" => 1));
    }

    function save_request_production_template($data, $id_design_template) {
        $request_production_template = $this->get_info_request_production_template($id_design_template);
        if (!$request_production_template->feature_id) {
            if ($this->db->insert("item_kit_request_production_template", $data)) {
                return true;
            }
            return false;
        }
        $this->db->where('id_design_template', $id_design_template);
        return $this->db->update('item_kit_request_production_template', $data);
    }

    function update_request_production_template($data, $id) {
        $this->db->where("id_request", $id);
        $this->db->update("request_production_template", $data);
    }

    function delete_request_production_template($id) {
        $this->db->where("id_request", $id);
        return $this->db->delete("request_production_template");
    }

    function get_info_request_production_template($id_design_template) {
        $this->db->where("id_design_template", $id_design_template);
        $query = $this->db->get("item_kit_request_production_template");
        return $query->row();
    }

    function get_info_request_production_template_by_request_id($request_id) {
        $this->db->where("request_id", $request_id);
        $query = $this->db->get("item_kit_request_production_template");
        return $query->row();
    }

    //END SAN
    ///hung audi 9-3
    function get_all_item_production($item_kit_id, $limit = 10000, $offset = 0, $col = 'id', $ord = 'desc') {
        $this->db->from('item_production');
        $this->db->where('item_kit_id', $item_kit_id);
        $this->db->order_by($col, $ord);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function count_all_item_production($item_kit_id) {
        $this->db->from('item_production');
        $this->db->where('item_kit_id', $item_kit_id);
        return $this->db->count_all_results();
    }

    function get_item_history_production($item_production_id) {
        $this->db->from('item_history_production');
        $this->db->where('item_production_id', $item_production_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function search_item_production($item_kit_id, $search, $limit = 10, $offset = 0, $column = 'id', $orderby = 'asc') {
        $this->db->from('item_production');

        $this->db->where("(id LIKE '%" . $this->db->escape_like_str($search) . "%' 
				or date_begin LIKE '%" . $this->db->escape_like_str($search) . "%' 
				or date_end LIKE '%" . $this->db->escape_like_str($search) . "%'
				or quantity_production LIKE '%" . $this->db->escape_like_str($search) . "%'
			)");

        $this->db->where('item_kit_id', $item_kit_id);
        $this->db->order_by($column, $orderby);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function search_count_all_item_production($item_kit_id, $search) {
        $this->db->from('item_production');
        $this->db->where('item_kit_id', $item_kit_id);
        $this->db->where("(id LIKE '%" . $this->db->escape_like_str($search) . "%' 
				or date_begin LIKE '%" . $this->db->escape_like_str($search) . "%' 
				or date_end LIKE '%" . $this->db->escape_like_str($search) . "%'
				or quantity_production LIKE '%" . $this->db->escape_like_str($search) . "%'
			)");
        $this->db->order_by("id", "asc");
        $result = $this->db->get();
        return $result->num_rows();
    }

    function get_search_suggestions_item_production($item_kit_id, $search, $limit = 25) {
        $suggestions = array();
        $this->db->from('item_production');
        $this->db->where('item_kit_id', $item_kit_id);
        $this->db->like('id', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("id", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('label' => $row->id);
        }

        $this->db->from('item_production');
        $this->db->where('item_kit_id', $item_kit_id);
        $this->db->like('date_begin', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("id", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('label' => $row->date_begin);
        }

        $this->db->from('item_production');
        $this->db->where('item_kit_id', $item_kit_id);
        $this->db->like('date_end', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("id", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('label' => $row->date_begin);
        }

        $this->db->from('item_production');
        $this->db->where('item_kit_id', $item_kit_id);
        $this->db->like('quantity_production', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("id", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('label' => $row->quantity_production);
        }

        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    //July 08, 2015 Hưng Audi item_kit_feature
    function get_all_item_kit_feature($id_design_template, $limit = 10000, $offset = 0, $col = 'feature_id', $ord = 'desc') {
        $this->db->from('item_kit_feature');
        $this->db->where('id_design_template', $id_design_template);
        $this->db->where('delete', 0);
        $this->db->order_by($col, $ord);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function count_all_item_kit_feature($id_design_template) {
        $this->db->from('item_kit_feature');
        $this->db->where('id_design_template', $id_design_template);
        $this->db->where('delete', 0);
        return $this->db->count_all_results();
    }

    function get_search_suggestions_item_kit_feature($id_design_template, $search, $limit = 25) {
        $suggestions = array();
        $this->db->from('item_kit_feature');
        $this->db->where('id_design_template', $id_design_template);
        $this->db->where('delete', 0);
        $this->db->like('number_feature', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("feature_id", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('label' => $row->number_feature);
        }

        $this->db->from('item_kit_feature');
        $this->db->where('id_design_template', $id_design_template);
        $this->db->where('delete', 0);
        $this->db->like('name_feature', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("feature_id", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('label' => $row->name_feature);
        }
        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    function search_item_kit_feature($id_design_template, $search, $limit = 10000, $offset = 0, $column = 'feature_id', $orderby = 'desc') {
        $this->db->from('item_kit_feature');
        $this->db->where("(name_feature LIKE '%" . $this->db->escape_like_str($search) . "%' "
                . "or number_feature LIKE '%" . $this->db->escape_like_str($search) . "%' )");
        $this->db->where('id_design_template', $id_design_template);
        $this->db->where('delete', 0);
        $this->db->order_by($column, $orderby);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function search_count_all_item_kit_feature($id_design_template, $search) {
        $this->db->from('item_kit_feature');
        $this->db->where('id_design_template', $id_design_template);
        $this->db->where("(name_feature LIKE '%" . $this->db->escape_like_str($search) . "%' "
                . "or number_feature LIKE '%" . $this->db->escape_like_str($search) . "%')");
        $this->db->where('delete', 0);
        $result = $this->db->get();
        return $result->num_rows();
    }

    function delete_list_item_kit_feature($feature_ids) {

        $this->db->where_in('feature_id', $feature_ids);
        return $this->db->update('item_kit_feature', array('delete' => 1));
    }

    function get_info_item_kit_feature($feature_id) {
        $this->db->from('item_kit_feature');
        $this->db->where('feature_id', $feature_id);
        $this->db->where('delete', 0);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //Get empty base parent object, as $item_kit_id is NOT an item kit
            $item_obj = new stdClass();
            //Get all the fields from items table
            $fields = $this->db->list_fields('item_kit_feature');
            foreach ($fields as $field) {
                $item_obj->$field = '';
            }
            return $item_obj;
        }
    }

    function save_item_kit_feature(&$item_kit_feature_data, $feature_id = false) {
        if (!$feature_id or ! $this->exists_item_kit_feature($feature_id)) {
            if ($this->db->insert('item_kit_feature', $item_kit_feature_data)) {
                $item_kit_feature_data['feature_id'] = $this->db->insert_id();
                return true;
            }
            return false;
        }
        $this->db->where('feature_id', $feature_id);
        return $this->db->update('item_kit_feature', $item_kit_feature_data);
    }

    function exists_item_kit_feature($feature_id) {
        $this->db->from('item_kit_feature');
        $this->db->where('feature_id', $feature_id);
        $query = $this->db->get();
        return ($query->num_rows() == 1);
    }

    function check_number_feature($id_design_template, $feature_id, $number_feature) {
        if ($feature_id) {
            $this->db->where("feature_id !=", $feature_id);
        }
        $this->db->where("id_design_template", $id_design_template);
        $this->db->where("number_feature", $number_feature);
        $query = $this->db->get("item_kit_feature");
        if ($query->num_rows() == 0) {
            return true;
        } else {
            return false;
        }
    }

    function check_name_feature($id_design_template, $feature_id, $name_feature) {
        if ($feature_id) {
            $this->db->where("feature_id !=", $feature_id);
        }
        $this->db->where("id_design_template", $id_design_template);
        $this->db->where("name_feature", $name_feature);
        $query = $this->db->get("item_kit_feature");
        if ($query->num_rows() == 0) {
            return true;
        } else {
            return false;
        }
    }

    //end H.A
    //11-7-15 hung audi
    //Them moi vao bang mau san xuat
    function save_item_kit_production_template($data, $id_design_template) {
        if (!$this->exists_item_kit_production_template($id_design_template)) {
            if ($this->db->insert('item_kit_production_template', $data)) {
                return true;
            }
            return false;
        }
        $this->db->where('id_design_template', $id_design_template);
        return $this->db->update('item_kit_production_template', $data);
    }

    function exists_item_kit_production_template($id_design_template) {
        $this->db->from('item_kit_production_template');
        $this->db->where('id_design_template', $id_design_template);
        $query = $this->db->get();
        return ($query->num_rows() == 1);
    }

    function check_id_design_template($id_design_template) {
        $this->db->from('item_kit_production_template');
        $this->db->where('id_design_template', $id_design_template);
        $query = $this->db->get();
        return ($query->num_rows() == 1);
    }

    function check_code_production_template($id_design_template, $code_production_template) {
        if ($id_design_template) {
            $this->db->where("id_design_template !=", $id_design_template);
        }
        $this->db->where("code_production_template", $code_production_template);
        $query = $this->db->get("item_kit_production_template");
        if ($query->num_rows() == 0) {
            return true;
        } else {
            return false;
        }
    }

    function get_info_production_template($id_design_template) {
        return $this->db->where('id_design_template', $id_design_template)
                        ->where('delete', 0)
                        ->get('item_kit_production_template')
                        ->row();
    }

    //July 13, Hưng Audi estimate
    function get_all_estimate($item_kit_id, $limit = 10000, $offset = 0, $col = 'pt.id_design_template', $ord = 'desc') {
        $this->db->from("item_kit_design_template dt")
                ->join('item_kit_production_template pt', 'pt.id_design_template = dt.id_design_template')
                ->where("item_kit_id", $item_kit_id)
                ->where("pt.delete", 0)
                ->order_by($col, $ord)
                ->limit($limit)
                ->offset($offset);
        return $this->db->get();
    }

    function count_all_estimate($item_kit_id) {
        $this->db->from("item_kit_design_template dt")
                ->join('item_kit_production_template pt', 'pt.id_design_template = dt.id_design_template')
                ->where('item_kit_id', $item_kit_id)
                ->where("pt.delete", 0);
        return $this->db->count_all_results();
    }

    function get_search_suggestions_estimate($item_kit_id, $search, $limit = 25) {
        $suggestions = array();
        $this->db->from("item_kit_design_template dt")
                ->join('item_kit_production_template pt', 'pt.id_design_template = dt.id_design_template')
                ->where('item_kit_id', $item_kit_id)
                ->where("pt.delete", 0)
                ->like('code_production_template', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both')
                ->order_by("code_production_template", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('label' => $row->code_production_template);
        }
        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    function search_estimate($item_kit_id, $search, $limit = 10000, $offset = 0, $column = 'pt.id_design_template', $orderby = 'desc') {
        $this->db->from("item_kit_design_template dt")
                ->join('item_kit_production_template pt', 'pt.id_design_template = dt.id_design_template')
                ->where('item_kit_id', $item_kit_id)
                ->where("pt.delete", 0)
                ->where("(code_production_template LIKE '%" . $this->db->escape_like_str($search) . "%')")
                ->order_by($column, $orderby)
                ->limit($limit)
                ->offset($offset);
        return $this->db->get();
    }

    function search_count_all_estimate($item_kit_id, $search) {
        $this->db->from("item_kit_design_template dt")
                ->join('item_kit_production_template pt', 'pt.id_design_template = dt.id_design_template')
                ->where('item_kit_id', $item_kit_id)
                ->where("pt.delete", 0)
                ->where("(code_production_template LIKE '%" . $this->db->escape_like_str($search) . "%')");
        $result = $this->db->get();
        return $result->num_rows();
    }

    function delete_list_estimate($id_design_templates) {
        $this->db->where_in('id_design_template', $id_design_templates);
        return $this->db->update('item_kit_production_template', array('delete' => 1));
    }

    //hung audi July 14 
    function exist_item_kit_feature($id_design_template) {
        $query = $this->db->from('item_kit_request_production_template rpt')
                ->join('item_kit_feature f', 'rpt.feature_id = f.feature_id')
                ->where('rpt.id_design_template', $id_design_template)
                ->where('delete', 0)
                ->get();
        return ($query->num_rows() == 1);
    }

    function get_info_request_production_template_feature($id_design_template) {
        $query = $this->db->from('item_kit_request_production_template rpt')
                ->join('item_kit_feature f', 'rpt.feature_id = f.feature_id')
                ->where('rpt.id_design_template', $id_design_template)
                ->where('delete', 0)
                ->get();
        return $query->row();
    }

    /*     * ** July 16 Beautiful Day *** */

    function get_production_join_design($item_kit_id) {
        return $this->db->from('item_kit_production_template pt')
                        ->join('item_kit_design_template dt', 'dt.id_design_template = pt.id_design_template')
                        ->where('item_kit_id', $item_kit_id)
                        ->where('pt.status', 6)
                        ->where('pt.delete', 0)
                        ->get();
    }

    /*     * ** July 17 Wonderful Day *** */

    function get_info_design_template_by_item_kit_id($item_kit_id) {
        return $this->db->from('item_kit_design_template')
                        ->where('item_kit_id', $item_kit_id)
                        ->where('delete', 0)
                        ->get()
                        ->result();
    }

    function exist_status_production_template($id_design_templates) {
        return $this->db->where("id_design_template in ($id_design_templates)")
                        ->where('status', 6)
                        ->where('delete', 0)
                        ->get('item_kit_production_template');
    }

    /*     * ** July 18 Camp Festival Day *** */

    function save_item_kit_request_production(&$data, $request_id = false) {
        if (!$this->exists_item_kit_request_production($request_id)) {
            if ($this->db->insert('item_kit_request_production', $data)) {
                $data['request_id'] = $this->db->insert_id();
                return true;
            }
            return false;
        }
        $this->db->where('request_id', $request_id);
        return $this->db->update('item_kit_request_production', $data);
    }

    function exists_item_kit_request_production($request_id) {
        $this->db->from('item_kit_request_production');
        $this->db->where('request_id', $request_id);
        $query = $this->db->get();
        return ($query->num_rows() == 1);
    }

    function save_item_kit_request_feature(&$data, $request_id) {
        $this->db->trans_start();
        $this->delete_request_feature($request_id);
        foreach ($data as $r) {
            $this->db->insert('item_kit_request_feature', $r);
        }
        $this->db->trans_complete();
        return true;
    }

    function delete_request_feature($request_id) {
        $this->db->delete('item_kit_request_feature', array('request_id' => $request_id));
    }

    function get_info_item_kit_request_production($item_kit_id) {
        return $this->db->where('item_kit_id', $item_kit_id)
                        ->where('delete', 0)
                        ->get('item_kit_request_production')
                        ->row();
    }

    function get_info_item_kit_request_feature($request_id, $feature_id) {
        return $this->db->where('request_id', $request_id)
                        ->where('feature_id', $feature_id)
                        ->get('item_kit_request_feature')
                        ->row();
    }

    //Hung Audi 21-7-15
    function get_item_kit_request_feature_by_feature_id($request_id, $feature_id) {
        return $this->db->where('request_id', $request_id)
                        ->where('feature_id', $feature_id)
                        ->get('item_kit_request_feature');
    }

    //27-7 Viet Nam - Man City 
    function get_info_item_size($feature_id, $item_id) {
        return $this->db->select('sum(rf.quantity) quantity_size, fm.*')
                        ->from('item_kit_request_feature rf')
                        ->join('item_kit_formula_materials fm', 'rf.feature_id = fm.feature_id')
                        ->where('fm.feature_id', $feature_id)
                        ->where('item_id', $item_id)
                        ->get()->row();
    }

    function get_info_size_item_kit_request_feature($feature_id) {
        return $this->db->from('item_kit_request_feature')
                        ->where("feature_id", $feature_id)
                        ->get();
    }

    function count_formula_materials($feature_id) {
        $this->db->where("feature_id", $feature_id);
        $query = $this->db->get("item_kit_formula_materials");
        return $query->num_rows();
    }

    //request_production
    function get_all_request_production($item_kit_id, $limit = 10000, $offset = 0, $col = 'request_id', $ord = 'desc') {
        $this->db->from("item_kit_request_production");
        $this->db->where("item_kit_id", $item_kit_id);
        $this->db->where("delete", 0);
        $this->db->order_by($col, $ord);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function count_all_request_production($item_kit_id) {
        $this->db->from("item_kit_request_production");
        $this->db->where('item_kit_id', $item_kit_id);
        $this->db->where("delete", 0);
        return $this->db->count_all_results();
    }

    function get_info_request_production($request_id) {
        $this->db->from('item_kit_request_production');
        $this->db->where('request_id', $request_id);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //Get empty base parent object, as $item_kit_id is NOT an item kit
            $item_obj = new stdClass();

            //Get all the fields from items table
            $fields = $this->db->list_fields('item_kit_request_production');

            foreach ($fields as $field) {
                $item_obj->$field = '';
            }

            return $item_obj;
        }
    }

    function search_request_production($item_kit_id, $search, $limit = 10000, $offset = 0, $column = 'request_id', $orderby = 'desc') {
        $this->db->from('item_kit_request_production');
        $this->db->where("(request_id LIKE '%" . $this->db->escape_like_str($search) . "%')");
        $this->db->where('item_kit_id', $item_kit_id);
        $this->db->where('delete', 0);
        $this->db->order_by($column, $orderby);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function search_count_all_request_production($item_kit_id, $search) {
        $this->db->from('item_kit_request_production');
        $this->db->where("(request_id LIKE '%" . $this->db->escape_like_str($search) . "%')");
        $this->db->where('item_kit_id', $item_kit_id);
        $this->db->where('delete', 0);
        $result = $this->db->get();
        return $result->num_rows();
    }

    function get_search_suggestions_request_production($item_kit_id, $search) {
        $suggestions = array();
        $this->db->from('item_kit_request_production');
        $this->db->where('item_kit_id', $item_kit_id);
        $this->db->like('request_id', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("request_id", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('label' => $row->request_id);
        }

        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    function delete_request_production($request_id) {
        $this->db->where_in('request_id', $request_id);
        return $this->db->update('item_kit_request_production', array('delete' => 1));
    }

    function get_feature_in_request_feature($request_id) {
        $this->db->where("request_id", $request_id);
        $this->db->group_by("feature_id");
        $query = $this->db->get("item_kit_request_feature");
        return $query->result();
    }

    function get_size_by_request_feature($request_id, $feature_id) {
        $this->db->where("request_id", $request_id);
        $this->db->where("feature_id", $feature_id);
        $query = $this->db->get("item_kit_request_feature");
        return $query->result();
    }

    //Hưng Audi hêlô August 8888
    function get_all_item_kit_processes($request_id) {
        return $this->db->where('request_id', $request_id)
                        ->group_by('id_processes')
                        ->order_by('pro_id', 'asc')
                        ->get('item_kit_processes');
    }

    function get_info_processes_cost($request_id, $id_processes) {
        return $this->db->where('request_id', $request_id)
                        ->where('id_processes', $id_processes)
                        ->get('item_kit_processes_cost');
    }

    function get_all_processes_new() {
        return $this->db->where('deleted', 0)
                        ->get('processes');
    }

    function save_item_kit_processes($processes_data, $request_id) {
        $this->db->trans_start();
        $this->delete_item_kit_processes($request_id);
        foreach ($processes_data as $r) {
            $this->db->insert('item_kit_processes', $r);
        }
        $this->db->trans_complete();
        return true;
    }

    function delete_item_kit_processes($request_id) {
        return $this->db->delete('item_kit_processes', array('request_id' => $request_id));
    }

    function save_item_kit_processes_cost($processes_cost_data, $request_id) {
        $this->db->trans_start();
        $this->delete_item_kit_processes_cost($request_id);
        foreach ($processes_cost_data as $r) {
            $this->db->insert('item_kit_processes_cost', $r);
        }
        $this->db->trans_complete();
        return true;
    }

    function delete_item_kit_processes_cost($request_id) {
        return $this->db->delete('item_kit_processes_cost', array('request_id' => $request_id));
    }

    //Thursday 6-8-15, Thứ Năm ngày lộc phát (68)
    function get_info_item_production_by_request_id($request_id) {
        $this->db->where("request_id", $request_id);
        $query = $this->db->get("item_production");
        if ($query->num_rows() == 1) {
            return $query->row();
        }
    }

    function save_item_production(&$data, $request_id = false) {
        if (!$request_id or ! $this->exists_item_production($request_id)) {
            if ($this->db->insert('item_production', $data)) {
                return true;
            }
            return false;
        }
        $this->db->where('request_id', $request_id);
        return $this->db->update('item_production', $data);
    }

    function exists_item_production($request_id) {
        $this->db->from('item_production');
        $this->db->where('request_id', $request_id);
        $query = $this->db->get();
        return ($query->num_rows() == 1);
    }

    //Hưng Audi August 12, 2015
    //save kcs
    function get_request_feature_by_request_id($request_id) {
        return $this->db->where('request_id', $request_id)
                        ->get('item_kit_request_feature')
                        ->result();
    }

    function get_pro_id_min_in_item_kit_processes($request_id) {
        return $this->db->select_min('pro_id')
                        ->where('request_id', $request_id)
                        ->get('item_kit_processes')
                        ->row();
    }

    function get_pro_id_max_in_item_kit_processes($request_id) {
        return $this->db->select_max('pro_id')
                        ->where('request_id', $request_id)
                        ->get('item_kit_processes')
                        ->row();
    }

    function get_info_item_kit_processes($request_id, $pro_id) {
        return $this->db->where('request_id', $request_id)
                        ->where('pro_id', $pro_id)
                        ->get('item_kit_processes')
                        ->row();
    }

    function get_info_request_feature_by_id($id) {
        return $this->db->where('id', $id)
                        ->get('item_kit_request_feature')
                        ->row();
    }

    function save_kcs($kcs_data, $kcs_id) {
        $this->delete_kcs($kcs_id);
        foreach ($kcs_data as $r) {
            $this->db->insert('kcs', $r);
        }
    }

    function delete_kcs($kcs_id) {
        return $this->db->delete('kcs', array('kcs_id' => $kcs_id));
    }

    function save_kcs2($data) {
        $this->db->insert('kcs', $data);
    }

    function get_info_kcs($request_id, $feature_size_id, $id_processes) {
        return $this->db->where('request_id', $request_id)
                        ->where('feature_size_id', $feature_size_id)
                        ->where('id_processes', $id_processes)
                        ->get('kcs')
                        ->row();
    }

    //August 14, 2015
    function get_info_item_kit_processes_audi($request_id, $id_processes) {
        return $this->db->where('request_id', $request_id)
                        ->where('id_processes', $id_processes)
                        ->get('item_kit_processes')
                        ->row();
    }

    function get_info_kcs_audi($request_id, $id_processes) {
        return $this->db->where('request_id', $request_id)
                        ->where('id_processes', $id_processes)
                        ->get('kcs');
    }

    function get_info_kcs_next($kcs_id_min) {
        return $this->db->select_min('kcs_id')
                        ->where('kcs_id >', $kcs_id_min)
                        ->get('kcs')->row();
    }

    function save_kcs_next($kcs_data, $kcs_id) {
        foreach ($kcs_data as $r) {
            $this->db->where('kcs_id', $kcs_id)
                    ->update('kcs', $r);
        }
    }

    function save_kcs_history($data) {
        $this->db->insert('kcs_history', $data);
    }

    function get_info_kcs_history($request_id, $feature_size_id, $id_processes, $date_kcs) {
        return $this->db->where('date_kcs', $date_kcs)
                        ->where('request_id', $request_id)
                        ->where('feature_size_id', $feature_size_id)
                        ->where('id_processes', $id_processes)
                        ->get('kcs_history')
                        ->row();
    }

    //August 15 
    function get_info_kcs_new($request_id, $feature_size_id, $id_processes) {
        return $this->db->where('request_id', $request_id)
                        ->where('feature_size_id', $feature_size_id)
                        ->where('id_processes', $id_processes)
                        ->get('kcs')->row();
    }

    function get_info_kcs_history_phase($request_id, $id_processes) {
        return $this->db->where('request_id', $request_id)
                        ->where('id_processes', $id_processes)
                        ->group_by('date_kcs')
                        ->get('kcs_history');
    }

    //August 17
    function get_info_kcs_by_kcs_id($kcs_id) {
        return $this->db->where('kcs_id', $kcs_id)
                        ->get('kcs')->row();
    }

    //August 18
    function get_info_kcs_history_phase_new($request_id, $id_processes) {
        return $this->db->where('request_id', $request_id)
                        ->where('id_processes', $id_processes)
                        ->group_by('kcs_history_id')
                        ->get('kcs_history')
                        ->result();
    }

    //Hưng Audi
    function get_info_kcs_history_audi($request_id, $id_processes, $kcs_history_id) {
        return $this->db->select("sum(quantity_success) quantity_success2")
                        ->where('request_id', $request_id)
                        ->where('id_processes', $id_processes)
                        ->where('kcs_history_id', $kcs_history_id)
                        ->get('kcs_history')
                        ->row();
    }

    //Dũng BMW
    function get_info_kcs_history_bmw($request_id, $id_processes, $kcs_history_id, $date_kcs) {
        return $this->db->select("sum(quantity_success) quantity_success2")
                        ->where('request_id', $request_id)
                        ->where('id_processes', $id_processes)
                        ->where('kcs_history_id', $kcs_history_id)
                        ->where('date_kcs <=', $date_kcs)
                        ->get('kcs_history')
                        ->row();
    }

    function get_info_kcs_history_phase_max_date($request_id, $id_processes) {
        return $this->db->select_max('date_kcs')
                        ->where('request_id', $request_id)
                        ->where('id_processes', $id_processes)
                        ->get('kcs_history')->row();
    }

    function get_info_kcs_history_phase_by_date($request_id, $id_processes, $date_kcs) {
        return $this->db->where('request_id', $request_id)
                        ->where('id_processes', $id_processes)
                        ->where('date_kcs', $date_kcs)
                        ->group_by('date_kcs')
                        ->get('kcs_history');
    }

    function get_info_kcs_prev($kcs_id) {
        return $this->db->select_max('kcs_id')
                        ->where('kcs_id <', $kcs_id)
                        ->get('kcs')->row();
    }

    //August 19-8
    function update_kcs($data, $kcs_id) {
        foreach ($data as $r) {
            $this->db->where('kcs_id', $kcs_id)
                    ->update('kcs', $r);
        }
    }

    //August 20
    function get_item_kit_request_feature($request_id, $feature_id) {
        return $this->db->where('request_id', $request_id)
                        ->where('feature_id', $feature_id)
                        ->get('item_kit_request_feature');
    }

    //august 22
    function get_item_fm($feature_ids, $item_id) {
        return $this->db->where('item_id', $item_id)
                        ->where("feature_id in ($feature_ids)")
                        ->group_by('feature_id')
                        ->get('item_kit_formula_materials');
    }

    //august 29
    function get_info_kcs_status($request_id, $id_processes) {
        return $this->db->where('request_id', $request_id)
                        ->where('id_processes', $id_processes)
                        ->get('kcs');
    }

    function get_info_kcs_status_join_history_in_time($request_id, $id_processes, $status, $date_kcs_max, $date_begin, $date_end) {
        return $this->db->from('kcs k')
                        ->join('kcs_history kh', 'kh.kcs_history_id = k.kcs_id')
                        ->where('k.request_id', $request_id)
                        ->where('k.id_processes', $id_processes)
                        ->where('status', $status)
                        ->where('date_kcs', $date_kcs_max)
                        ->where('date_kcs > ', $date_begin)
                        ->where('date_kcs < ', $date_end)
                        ->get();
    }

    function get_info_kcs_status_join_history_out_time($request_id, $id_processes, $status, $date_kcs_max, $date_end) {
        return $this->db->from('kcs k')
                        ->join('kcs_history kh', 'kh.kcs_history_id = k.kcs_id')
                        ->where('k.request_id', $request_id)
                        ->where('k.id_processes', $id_processes)
                        ->where('status', $status)
                        ->where('date_kcs', $date_kcs_max)
                        ->where('date_kcs > ', $date_end)
                        ->get();
    }

    function check_exist_kcs_history($request_id, $id_processes) {
        return $this->db->where('request_id', $request_id)
                        ->where('id_processes', $id_processes)
                        ->get('kcs_history');
    }

    //hi September 2015
    //norms_item
    function save_item_kit_norms_item($norms_item_data, $request_id) {
        $this->db->trans_start();
        $this->delete_item_kit_norms_item($request_id);
        foreach ($norms_item_data as $r) {
            $this->db->insert('item_kit_norms_item', $r);
        }
        $this->db->trans_complete();
        return true;
    }

    function delete_item_kit_norms_item($request_id) {
        return $this->db->delete('item_kit_norms_item', array('request_id' => $request_id));
    }

    function get_info_item_kit_norms_item($request_id, $item_id) {
        return $this->db->where('request_id', $request_id)
                        ->where('item_id', $item_id)
                        ->get('item_kit_norms_item')
                        ->row();
    }

    function get_info_norms_item_by_request_id($request_id) {
        $this->db->where("request_id", $request_id);
        $query = $this->db->get("item_kit_norms_item");
        return $query->result();
    }

    /* ~~~~ Hưng Audi 8-9-15 >>>> */

    //Sep 8, birthday Cty
    function get_search_processes_suggestions($search, $limit = 25) {
        $suggestions = array();
        $by_name = $this->db->like('name_processes', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both')
                ->where('deleted', 0)
                ->order_by("name_processes", "asc")
                ->get('processes');
        foreach ($by_name->result() as $row) {
            $suggestions[] = array(
                'label' => $row->name_processes,
                'value' => $row->id_processes
            );
        }
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    function save_processes_item_kit($data, $item_kit_id) {
        $this->delete_processes_item_kit($item_kit_id);
        foreach ($data as $d) {
            $this->db->insert('processes_item_kit', $d);
        }
    }

    function delete_processes_item_kit($item_kit_id) {
        return $this->db->delete('processes_item_kit', array('item_kit_id' => $item_kit_id));
    }

    function get_info_processes_item_kit($item_kit_id) {
        return $this->db->where('item_kit_id', $item_kit_id)
                        ->get('processes_item_kit');
    }

    function get_info_processes_item_kit_audi($item_kit_id, $id_processes) {
        return $this->db->where('item_kit_id', $item_kit_id)
                        ->where('id_processes', $id_processes)
                        ->get('processes_item_kit')->row();
    }

    //end H.A 8-9
    function save_processes_design_template($data, $id_design_template) {
        $this->delete_processes_design_template($id_design_template);
        foreach ($data as $d) {
            $this->db->insert('processes_design_template', $d);
        }
    }

    function delete_processes_design_template($id_design_template) {
        return $this->db->delete('processes_design_template', array('id_design_template' => $id_design_template));
    }

    function get_row_min_processes_design_template($id_design_template) {
        return $this->db->select_min('id')
                        ->where('id_design_template', $id_design_template)
                        ->where('status', 0)
                        ->get('processes_design_template')->row();
    }

    function get_info_processes_design_template($id) {
        return $this->db->where(id, $id)
                        ->get('processes_design_template')->row();
    }

    function check_processes_design_template($id_design_template) {
        return $this->db->where('id_design_template', $id_design_template)
                        ->where('status', 0)
                        ->get('processes_design_template');
    }

    function get_processes_design_template($id_design_template, $id_processes) {
        return $this->db->where('id_design_template', $id_design_template)
                        ->where('id_processes', $id_processes)
                        ->get('processes_design_template')->row();
    }

    function save_confirm_processes($data, $id) {
        $this->db->where('id', $id)
                ->update('processes_design_template', $data);
    }

    function check_processes_design_template_audi($item_kit_id, $id_processes) {
        return $this->db->where('item_kit_id', $item_kit_id)
                        ->where('id_processes', $id_processes)
                        ->where('status', 1)
                        ->get('processes_design_template');
    }

    function get_processes_design_template_audi($item_kit_id, $id_design_template, $id_processes) {
        return $this->db->where('item_kit_id', $item_kit_id)
                        ->where('id_design_template', $id_design_template)
                        ->where('id_processes', $id_processes)
                        ->get('processes_design_template')->row();
    }

    function save_processes_design_template_audi($data, $item_kit_id) {
        $this->delete_processes_design_template_audi($item_kit_id);
        foreach ($data as $d) {
            $this->db->insert('processes_design_template', $d);
        }
    }

    function delete_processes_design_template_audi($item_kit_id) {
        return $this->db->delete('processes_design_template', array('item_kit_id' => $item_kit_id));
    }

    function check_design_template_by_item_kit_id($item_kit_id) {
        return $this->db->where('item_kit_id', $item_kit_id)
                        ->where('status', 3)
                        ->where('delete', 0)
                        ->get('item_kit_design_template');
    }

    //end H.A 9-9
    //lay id lon nhat cua truong id trong bang kcs_history_id
    //theo kcs_history_id, request_id, feature_size_id
    function select_max_id_in_kcs_history($kcs_history_id, $request_id, $feature_size_id) {
        $this->db->select_max("id");
        $this->db->where("kcs_history_id", $kcs_history_id);
        $this->db->where("request_id", $request_id);
        $this->db->where("feature_size_id", $feature_size_id);
        $query = $this->db->get("kcs_history");
        return $query->row();
    }

    function get_info_kcs_history_by_id($id) {
        $this->db->where("id", $id);
        $query = $this->db->get("kcs_history");
        return $query->row();
    }

    function get_list_processes_by_cat_pro_id($cat_pro_id) {
        $this->db->where("cat_pro_id", $cat_pro_id);
        $query = $this->db->get("processes");
        return $query->result();
    }

    function get_feature_design_template($id_design_template) {
        $this->db->where("id_design_template", $id_design_template);
        $this->db->where("delete", 0);
        $query = $this->db->get("item_kit_feature");
        return $query;
    }

    //Hưng Audi Sep 24
    function get_processes_cost_by_request($request_id) {
        return $this->db->where('request_id', $request_id)
                        ->get('item_kit_processes_cost');
    }

    //Hưng Audi Sep 25
    function get_all_item_production_finish($item_kit_id) {
        return $this->db->where('item_kit_id', $item_kit_id)
                        ->where('status', 3)
                        ->get('item_production')
                        ->result();
    }

    //Hưng Audi Sep 26
    //tinh gia von san pham
    function get_processes_cost_labor($request_ids, $start_date, $end_date) {
        return $this->db->select('sum(cost_money) money_labor')
                        ->join('costs', 'processes_cost_id = id')
                        ->where('date >= ', $start_date)
                        ->where('date <= ', $end_date)
                        ->where('labor !=', 0)
                        ->where("request_id in ($request_ids)")
                        ->get('item_kit_processes_cost')->row();
    }

    function get_processes_cost_machine($request_ids, $start_date, $end_date) {
        return $this->db->select('sum(cost_money) money_machine ')
                        ->join('costs', 'processes_cost_id = id')
                        ->where('date >= ', $start_date)
                        ->where('date <= ', $end_date)
                        ->where('machine !=', 0)
                        ->where("request_id in ($request_ids)")
                        ->get('item_kit_processes_cost')->row();
    }

    function get_processes_cost_outsource($request_ids, $start_date, $end_date) {
        return $this->db->select('sum(cost_money) money_outsource ')
                        ->join('costs', 'processes_cost_id = id')
                        ->where('date >= ', $start_date)
                        ->where('date <= ', $end_date)
                        ->where('outsource !=', 0)
                        ->where("request_id in ($request_ids)")
                        ->get('item_kit_processes_cost')->row();
    }

    function get_processes_cost_other($request_ids, $start_date, $end_date) {
        return $this->db->select('sum(cost_money) money_other ')
                        ->join('costs', 'processes_cost_id = id')
                        ->where('date >= ', $start_date)
                        ->where('date <= ', $end_date)
                        ->where('cost_name !=', '')
                        ->where("request_id in ($request_ids)")
                        ->get('item_kit_processes_cost')->row();
    }

    //Hưng Audi Sep 29
    function check_kcs($request_id) {
        return $this->db->where('request_id', $request_id)
                        ->where('status', 0)
                        ->get('kcs');
    }

    function insert_item_kit_cost_price(&$data) {
        $this->db->insert('item_kit_cost_price', $data);
    }

    function exists_item_kit_cost_price($item_kit_id) {
        return $this->db->where('item_kit_id', $item_kit_id)
                        ->get('item_kit_cost_price')
                        ->num_rows() == 1;
    }
    //play boy << Hưng Audi >> 2-10-15
    //tinh gia von lenh sx
    function get_info_item_kit_request_cost_price($request_id) {
        return $this->db->where('request_id', $request_id)
                        ->get('item_kit_request_cost_price')->row();
    }

    function get_processes_cost_labor_request($request_id) {
        return $this->db->select('sum(cost_money) money_labor')
                        ->where('labor !=', 0)
                        ->where('request_id', $request_id)
                        ->get('item_kit_processes_cost')->row();
    }

    function get_processes_cost_machine_request($request_id) {
        return $this->db->select('sum(cost_money) money_machine ')
                        ->where('machine !=', 0)
                        ->where('request_id', $request_id)
                        ->get('item_kit_processes_cost')->row();
    }

    function get_processes_cost_outsource_request($request_id) {
        return $this->db->select('sum(cost_money) money_outsource ')
                        ->where('outsource !=', 0)
                        ->where('request_id', $request_id)
                        ->get('item_kit_processes_cost')->row();
    }

    function get_processes_cost_other_request($request_id) {
        return $this->db->select('sum(cost_money) money_other ')
                        ->where('cost_name !=', '')
                        ->where('request_id', $request_id)
                        ->get('item_kit_processes_cost')->row();
    }

    function insert_item_kit_request_cost_price(&$data) {
        $this->db->insert('item_kit_request_cost_price', $data);
    }

    function check_item_production_finish($request_id) {
        return $this->db->where('request_id', $request_id)
                        ->where('status', 3)
                        ->get('item_production');
    }
    
    //Hưng Audi 0000 Oct 27
    // hello HallOweeN (^_^)   
    function get_info_item_kit_cost_price($item_kit_id) {
        $id_max = $this->db->select_max('id')
                        ->where('item_kit_id', $item_kit_id)
                        ->get('item_kit_cost_price')->row()->id;
        
        return $this->db->where('id', $id_max)
                        ->get('item_kit_cost_price')->row();
    }
    function get_info_request_production_by_request_Christmas($request_id) {
        return $this->db->where('request_id', $request_id)
                        ->where('delete', 0)
                        ->get('item_kit_request_production')->row();
    }
    function get_info_request_production_by_request_HallOweeN($request_ids) {
        return $this->db->select('sum(total_money_norms) total_money_norms')
                        ->where("request_id in ($request_ids)")
                        ->where('delete', 0)
                        ->get('item_kit_request_production')->row();
    }
    //Oct 28
    function get_all_product_store($limit = 10000, $offset = 0, $col = 'trans_items', $ord = 'desc') {
        return $this->db->select('*, sum(trans_inventory) quantity')
                        ->where('trans_comment', 'PRO')
                        ->group_by('trans_items')
                        ->get('inventory');
    }
    function count_all_product_store() {
        return $this->db->from('inventory')
                        ->where('trans_comment', 'PRO')
                        ->group_by('trans_items')
                        ->count_all_results();
    }    
    //Oct 29
    function insert_import_product($data){
        $this->db->insert('import_product', $data);
        return $this->db->insert_id();
    }
    //Oct 30
    function list_kcs($item_production_id) {
        return $this->db->where("request_id", $item_production_id)
                        ->get("kcs");
    }
    
    //Nov 12
    function get_item_product($item_kit_id) {
        return $this->db->where("item_kit_id", $item_kit_id)
                        ->get("items");
    }    
    function get_item_product_search_suggestions($search, $item_kit_id, $limit = 25) {
        $suggestions = array();
        
        $by_name = $this->db->where('item_kit_id', $item_kit_id)
                            ->where('deleted', 0)
                            ->like('name', $search)
                            ->order_by("name", "asc")
                            ->get(items);
        foreach ($by_name->result() as $somi) {
            $suggestions[] = array(
                'value' => $somi->item_id,
                'label' => $somi->name
            );
        }
        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }
    //Hưng Audi November 13
    function check_kit() {
        return $this->db->where('status', $status)
                        ->where('status !=', 3)
                        ->get('item_kits');
    }
    
}

?>