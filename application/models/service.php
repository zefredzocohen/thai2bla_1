<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Service extends CI_Model {

    function get_all($limit = 10000, $offset = 0, $col = 'item_id', $order = 'desc') {
        $this->db->from('items');
        $this->db->where('deleted', 0);
        $this->db->where('service', 1);
        $this->db->order_by($col, $order);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function count_all() {
        $this->db->from('items');
        $this->db->where('deleted', 0);
        $this->db->where('service', 1);
        return $this->db->count_all_results();
    }

    function get_info($item_id) {
        $this->db->from('items');
        $this->db->where('item_id', $item_id);
        $this->db->where('service', 1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //Get empty base parent object, as $item_id is NOT an item
            $item_obj = new stdClass();
            //Get all the fields from items table
            $fields = $this->db->list_fields('items');
            foreach ($fields as $field) {
                $item_obj->$field = '';
            }
            return $item_obj;
        }
    }

    function get_cat_services() {
        $this->db->where("deleted", 0);
        $query = $this->db->get("categories_item");
        return $query->result_array();
    }

    function get_search_suggestions($search, $limit = 25) {
        $suggestions = array();

        $this->db->from('items');
        $this->db->like('name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->where('deleted', 0);
        $this->db->where('service', 1);
        $this->db->order_by("name", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('label' => $row->name);
        }

        $this->db->from('items');
        $this->db->like('item_number', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->where('deleted', 0);
        $this->db->where('service', 1);
        $this->db->order_by("item_number", "asc");
        $by_item_number = $this->db->get();
        foreach ($by_item_number->result() as $row) {
            $suggestions[] = array('label' => $row->item_number);
        }

        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    function search($search, $cat = '', $limit = 20, $offset = 0, $column = 'item_id', $orderby = 'desc') {
        if ($cat)
            $cat_id = "and category = $cat ";
        else
            $cat_id = '';        
        if ($this->config->item('speed_up_search_queries')) {
            $query = "
                select *
                from (
                (select " . $this->db->dbprefix('items') . ".*, " . $this->db->dbprefix('warehouse_items') . ".warehouse_id
                , " . $this->db->dbprefix('items') . ".deleted
                from " . $this->db->dbprefix('items') . "
                join " . $this->db->dbprefix('warehouse_items') . " ON" . $this->db->dbprefix('items') . ".item_id = " . $this->db->dbprefix('warehouse_items') . ".item_id
                where name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                order by `" . $column . "` " . $orderby . ") union

               (select " . $this->db->dbprefix('items') . ".*, " . $this->db->dbprefix('warehouse_items') . ".warehouse_id
                , " . $this->db->dbprefix('items') . ".deleted
                from " . $this->db->dbprefix('items') . "
                join " . $this->db->dbprefix('warehouse_items') . " ON" . $this->db->dbprefix('items') . ".item_id = " . $this->db->dbprefix('warehouse_items') . ".item_id
                where item_number like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                order by `" . $column . "` " . $orderby . ") union

                (select " . $this->db->dbprefix('items') . ".*, " . $this->db->dbprefix('warehouse_items') . ".warehouse_id
                , " . $this->db->dbprefix('items') . ".deleted
                from " . $this->db->dbprefix('items') . "
                join " . $this->db->dbprefix('warehouse_items') . " ON" . $this->db->dbprefix('items') . ".item_id = " . $this->db->dbprefix('warehouse_items') . ".item_id
                where category like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                order by `" . $column . "` " . $orderby . ") union
                ) as search_results
                order by `" . $column . "` " . $orderby . "` limit " . $offset . ',' . $limit;
            return $this->db->query($query);
        } else {
            $str_search = str_replace(array('_', '@', '#', '$', '%'), ' ', $search);
            $search_terms_array = explode(" ", $this->db->escape_like_str($str_search));
            //to keep track of which search term of the array we're looking at now	
            $search_name_criteria_counter = 0;
            $sql_search_name_criteria = '';
            //loop through array of search terms
            foreach ($search_terms_array as $x) {
                $sql_search_name_criteria.=($search_name_criteria_counter > 0 ? " AND " : "") ."name LIKE '%" . $this->db->escape_like_str($x) . "%'";
                $search_name_criteria_counter++;
            }
            $this->db->select('item_id,category,images,item_number,name,unit_price,quantity_total as quantity_warehouse, quantity, quantity_total,deleted');
            $this->db->from('items');           
            $this->db->group_by('items.item_id');
            $this->db->where("((" .
            $sql_search_name_criteria . ") or 
                item_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                category LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                location LIKE '%" . $this->db->escape_like_str($search) . "%') $cat_id and deleted=0 and service=1");
            $this->db->order_by($column, $orderby);
            $this->db->limit($limit);
            $this->db->offset($offset);
            return $this->db->get();
        }
    }

    function search_count_all($search, $stores = '', $cat = '') {//,$stores=''
        if ($cat) $cat_id = "and category = $cat ";
        else $cat_id = '';       
        if ($this->config->item('speed_up_search_queries')) {
            $query = "
                select *
                from (
                    (select " . $this->db->dbprefix('items') . ".*, " . $this->db->dbprefix('warehouse_items') . ".warehouse_id
                    , " . $this->db->dbprefix('items') . ".deleted
                    from " . $this->db->dbprefix('items') . "
                    join " . $this->db->dbprefix('warehouse_items') . " ON" . $this->db->dbprefix('items') . ".item_id = " . $this->db->dbprefix('warehouse_items') . ".item_id
                    where name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                    order by `" . $column . "` " . $orderby . ") union

                    (select " . $this->db->dbprefix('items') . ".*, " . $this->db->dbprefix('warehouse_items') . ".warehouse_id
                    , " . $this->db->dbprefix('items') . ".deleted
                    from " . $this->db->dbprefix('items') . "
                    join " . $this->db->dbprefix('warehouse_items') . " ON" . $this->db->dbprefix('items') . ".item_id = " . $this->db->dbprefix('warehouse_items') . ".item_id
                    where item_number like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                    order by `" . $column . "` " . $orderby . ") union

                    (select " . $this->db->dbprefix('items') . ".*, " . $this->db->dbprefix('warehouse_items') . ".warehouse_id
                    , " . $this->db->dbprefix('items') . ".deleted
                    from " . $this->db->dbprefix('items') . "
                    join " . $this->db->dbprefix('warehouse_items') . " ON" . $this->db->dbprefix('items') . ".item_id = " . $this->db->dbprefix('warehouse_items') . ".item_id
                    where category like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                    order by `" . $column . "` " . $orderby . ") union

                ) as search_results
                order by `name`";
            $result = $this->db->query($query);
            return $result->num_rows();
        } else {
            $this->db->select('deleted,item_id,category,images,item_number,name,unit_price,quantity_total as quantity_warehouse, quantity, quantity_total');
            $this->db->from('items');
            $this->db->group_by('items.item_id');
            $this->db->where("(name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                item_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                category LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                location LIKE '%" . $this->db->escape_like_str($search) . "%') $cat_id and deleted=0 and service=1");
            $result = $this->db->get();
            return $result->num_rows();
        }
    }
    //Check item_number of services
    function check_exists_item_number_services($item_number_service){
        $this->db->where("item_number",$item_number_service);
        $this->db->where("service",1);
        $query = $this->db->get("items");
        if($query->num_rows() == 1){
            return true;
        }else{ 
            return false;
        }
    }
    //Lay loai dich vu
    function get_all_cat_service(){
        $this->db->where("cat_service", 1);
        $this->db->where("deleted", 0);
        $query = $this->db->get("categories_item");
        return $query->result_array();
    }
}

?>