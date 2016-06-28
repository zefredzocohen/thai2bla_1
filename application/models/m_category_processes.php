<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class M_category_processes extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_all($limit = 100, $offset = 0, $col = 'cat_pro_id', $order = 'desc') {
        $this->db->from('category_processes');
        $this->db->where('deleted', 0);
        $this->db->order_by($col, $order);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function count_all() {
        $this->db->from('category_processes');
        $this->db->where('deleted', 0);
        return $this->db->count_all_results();
    }

    function get_info($cat_pro_id) {
        $this->db->where('cat_pro_id', $cat_pro_id);
        $query = $this->db->get('category_processes');

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //Get empty base parent object, as $item_id is NOT an item
            $item_obj = new stdClass();

            //Get all the fields from items table
            $fields = $this->db->list_fields('category_processes');

            foreach ($fields as $field) {
                $item_obj->$field = '';
            }
            return $item_obj;
        }
    }

    function save(&$data, $cat_pro_id = false) {
        if (!$cat_pro_id or ! $this->exists($cat_pro_id)) {
            if ($this->db->insert('category_processes', $data)) {
                $data['cat_pro_id'] = $this->db->insert_id();
                return true;
            }
            return false;
        } else {
            $this->db->where('cat_pro_id', $cat_pro_id);
            return $this->db->update('category_processes', $data);
        }
    }

    function exists($cat_pro_id) {
        $this->db->from('category_processes');
        $this->db->where('cat_pro_id', $cat_pro_id);
        $query = $this->db->get();

        return ($query->num_rows() == 1);
    }

    function search($search, $limit = 20, $offset = 0, $column = 'cat_pro_id', $orderby = 'desc') {
        $this->db->from('category_processes');
        $this->db->like("cat_pro_name", $search);
        $this->db->where("deleted", 0);
        $this->db->order_by($column, $orderby);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function search_count_all($search) {
        $this->db->from('category_processes');
        $this->db->like("cat_pro_name", $search);
        $this->db->where("deleted", 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_search_suggestions($search, $limit = 25) {
        $suggestions = array();

        $this->db->from('category_processes');
        $this->db->like('cat_pro_name', $search);
        $this->db->where('deleted', 0);
        $this->db->order_by("cat_pro_name", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('label' => $row->cat_pro_name);
        }
        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    function get_cat_pro_in_processes($cat_pro_id) {
        $this->db->where("cat_pro_id", $cat_pro_id);
        $query = $this->db->get("processes");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function delete_list($cat_pro_ids) {
        $this->db->where_in('cat_pro_id', $cat_pro_ids);
        return $this->db->update('category_processes', array('deleted' => 1));
    }

    function get_list_all_cat_pro() {
        $this->db->where("deleted", 0);
        $query = $this->db->get("category_processes");
        return $query->result();
    }

}
