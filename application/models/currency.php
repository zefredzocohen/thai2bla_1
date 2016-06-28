<?php

class Currency extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function count_all() {
        $query = $this->db->get('currency');
        return $query->num_rows();
    }

    public function get_all($limit = 10000, $offset = 0) {
        $this->db->from('currency');
        $this->db->limit($limit);
        $this->db->offset($offset);
        $this->db->order_by('id', 'desc');
        return $this->db->get();
    }

    public function search_count_all($search, $limit = 10000) {
        $this->db->from('currency');
        $this->db->where("currency_name LIKE '%" . $this->db->escape_like_str($search) . "%'  ");
        $this->db->order_by("currency_name", "desc");
        $result = $this->db->get();
        return $result->num_rows();
    }

    public function search($search, $limit = 20, $offset = 0, $column = 'currency_name', $orderby = 'desc') {
        $this->db->from('currency');
        $this->db->where("currency_name LIKE '%" . $this->db->escape_like_str($search) . "%'  ");
        $this->db->order_by($column, $orderby);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    public function get_search_suggestions($search, $limit = 25) {
        $suggestions = array();
        $this->db->from('currency');
        $this->db->like("currency_name", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("currency_name", "asc");
        $by_company_name = $this->db->get();
        foreach ($by_company_name->result() as $row) {
            $suggestions[] = array('label' => $row->currency_name);
        }
        
        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    public function get_data() {
        $query = $this->db->get('currency');
        return $query->row_array();
    }

     function get_info($id) {
        $this->db->from('currency');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            $item_obj = new stdClass();
            $fields = $this->db->list_fields('currency');
            foreach ($fields as $field) {
                $customertype_obj->$field = '';
            }
            return $customertype_obj;
        }
    }

    public function exists($type_id) {
        $this->db->from('currency');
        $this->db->where('id', $type_id);
        $query = $this->db->get();

        return ($query->num_rows() == 1);
    }

    public function save(&$type_data, $type_id = false) {
        if (!$type_id or ! $this->exists($type_id)) {
            if ($this->db->insert('currency', $type_data)) {
                $type_data['id'] = $this->db->insert_id();
                return true;
            }
            return false;
        } else {
            $this->db->where('id', $type_id);
            return $this->db->update('currency', $type_data);
        }
    }

    public function delete_list($type_id) {
        $this->db->where('id', $type_id);
        $this->db->delete('currency');
    }


   
    //check trùng tên dungbv
    public function get_name($type_name, $type_id='') {
       if($type_id){
           $this->db->where('id !=',$type_id);
       }
       $this->db->where('currency_name',$type_name);
       return $this->db->get('currency')->num_rows();
    }
    
    public function get_id($currency_id, $type_id='') {
       if($type_id){
           $this->db->where('id !=',$type_id);
       }
       $this->db->where('currency_id',$currency_id);
       return $this->db->get('currency')->num_rows();
    }

}

?>