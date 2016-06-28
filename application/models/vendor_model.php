<?php

class Vendor_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }


    function get_all1($limit = 100, $offset = 0, $col = 'id', $order = 'desc') {
        $this->db->from('vendors');
        $this->db->order_by($col, $order);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function count_all() {
        $this->db->from('vendors');
        return $this->db->count_all_results();
    }

    function insert($data) {
        $this->db->insert('vendors', $data);
    }

    function get_info($id_support) {
        $this->db->from('vendors');
        $this->db->where('id', $id_support);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            $item_obj = new stdClass();
            $fields = $this->db->list_fields('vendors');
            foreach ($fields as $field) {
                $customertype_obj->$field = '';
            }
            return $customertype_obj;
        }
    }

    function account_number_exists($id_unit) {
        $this->db->from('vendors');
        $this->db->where('id', $id_unit);
        $query = $this->db->get();

        return ($query->num_rows() == 1);
    }

    function exists($id_unit) {
        $this->db->from('vendors');
        $this->db->where('id', $id_unit);
        $query = $this->db->get();

        return ($query->num_rows() == 1);
    }

    function get_all() {
        $query = $this->db->get('vendors');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    //trùng tên
    function name_exists($id) {



        if ($id > 0) {
            $name_post = $this->input->post('id');

            $this->db->select('id');
            $this->db->from('vendors');
            $query = $this->db->get();

            foreach ($query->result() as $q1) {

                //$q2= $q1->name;
                if ($q1 == $name_post) {
                    return FALSE;
                } else {
                    return TRUE;
                }
            }
        }
    }

    function update_unit($id, $value) {
        $this->db->where('id', $id);
        $this->db->update('vendors', $value);
    }

    function save(&$item_data, $id_unit = false) {
        if (!$id_unit or ! $this->exists($id_unit)) {
            if ($this->db->insert('vendors', $item_data)) {
                $item_data['id'] = $this->db->insert_id();
                return true;
            }
            return false;
        } else {
            $this->db->where('id', $id_unit);
            return $this->db->update('vendors', $item_data);
        }
    }

    //------------------------------------------------------------------
    /////search
    // xo chu khi nhap gtri search
    function get_search_suggestions($search, $limit = 25) {
        $suggestions = array();
        $this->db->from('vendors');
        $this->db->like('id', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("id", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('label' => $row->id);
        }

        $this->db->from('vendors');
        $this->db->like('id', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("id", "asc");
        $by_item_number = $this->db->get();
        foreach ($by_item_number->result() as $row) {
            $suggestions[] = array('label' => $row->id);
        }

        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

   
    function get_info1($id_unit) {

        $this->db->where('id', $id_unit);
        $query = $this->db->get('vendors');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else
            return null;
    }

    function search($search, $limit = 10, $offset = 0, $column = 'id', $orderby = 'asc') {
        $this->db->from('vendors');
        $this->db->where("id LIKE '%" . $this->db->escape_like_str($search) . "%'  ");
        $this->db->order_by($column, $orderby);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function search_count_all($search) {
        $this->db->from('vendors');
        $this->db->where("id LIKE '%" . $this->db->escape_like_str($search) . "%'  ");
        $this->db->order_by("id", "asc");
        $result = $this->db->get();
        return $result->num_rows();
    }

    function item_unit($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('vendors');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else
            return null;
    }

    function delete_list($id_support) {
          $this->db->where('id',$id_support);
          $this->db->delete('vendors');
    }

    function check_exist_unit($id_unit) {
        $this->db->where("id", $id_unit);
        $query = $this->db->get("vendors");
        return $query->num_rows();
    }
}

?>
