<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * created by Hunght
 */

class Contractemp_types extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function count_all() {
        $query = $this->db->get('maloai_hopdong');
        return $query->num_rows();
    }

    public function get_all($limit = 10000, $offset = 0) {
        $this->db->from('maloai_hopdong');
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    public function search_count_all($search, $limit = 10000) {
        $this->db->from('maloai_hopdong');
        $this->db->where("ten_maloai_hopdong LIKE '%" . $this->db->escape_like_str($search) . "%'  ");
        $this->db->order_by("ten_maloai_hopdong", "asc");
        $result = $this->db->get();
        return $result->num_rows();
    }

    public function search($search, $limit = 20, $offset = 0, $column = 'ten_maloai_hopdong', $orderby = 'asc') {
        $this->db->from('maloai_hopdong');
        $this->db->where("ten_maloai_hopdong LIKE '%" . $this->db->escape_like_str($search) . "%'  ");
        $this->db->order_by($column, $orderby);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    public function get_search_suggestions($search, $limit = 25) {
        $suggestions = array();
        $this->db->from('maloai_hopdong');
        $this->db->like("ten_maloai_hopdong", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("ten_maloai_hopdong", "asc");
        $by_company_name = $this->db->get();
        foreach ($by_company_name->result() as $row) {
            $suggestions[] = array('label' => $row->ten_maloai_hopdong);
        }
        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    public function get_data() {
        $query = $this->db->get('maloai_hopdong');
        return $query->row_array();
    }

    public function get_list_maloai_hopdongs() {
        $this->db->select(array('id_ma_hopdong', 'ten_maloai_hopdong'));
        $this->db->from('maloai_hopdong');
        $this->db->distinct();
        $this->db->order_by("id_ma_hopdong", "asc");
        return $this->db->get();
    }

    public function exists($custometype_id) {
        $this->db->from('maloai_hopdong');
        $this->db->where('id_ma_hopdong', $custometype_id);
        $query = $this->db->get();
        return ($query->num_rows() == 1);
    }

    public function save(&$customertype_data, $customertype_id = false) {
        if (!$customertype_id or !$this->exists($customertype_id)) {
            if ($this->db->insert('maloai_hopdong', $customertype_data)) {
                $customertype_data['id_ma_hopdong'] = $this->db->insert_id();
                return true;
            }
            return false;
        }
        $this->db->where('id_ma_hopdong', $customertype_id);

        return $this->db->update('maloai_hopdong', $customertype_data);
    }

    public function get_info($id) {
        $this->db->from('maloai_hopdong');
        $this->db->where('id_ma_hopdong', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            $customertype_obj = new stdClass();
            $fields = $this->db->list_fields('maloai_hopdong');
            foreach ($fields as $field) {
                $customertype_obj->$field = '';
            }
            return $customertype_obj;
        }
    }

    public function delete_list($customertype_id) {

        $this->db->where_in('id_ma_hopdong', $customertype_id);

        return $this->db->delete('maloai_hopdong');
    }

    function get_Contractemp_types() {
        $query = $this->db->get('maloai_hopdong');
        return $query->result_array();
    }

    function get_info_typeempcontract($id_typecontract) {
        $this->db->where('id_ma_hopdong', $id_typecontract);
        $query = $this->db->get('maloai_hopdong');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else{
            return null;
        }
        
    }

}

?>
