<?php

class Account_type_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function count_all() {
        $query = $this->db->get('account_type');
        return $query->num_rows();
    }

    public function get_all($limit = 10000, $offset = 0) {
        $this->db->from('account_type');
        $this->db->limit($limit);
        $this->db->offset($offset);
        $this->db->order_by('type_id', 'desc');
        return $this->db->get();
    }

    public function search_count_all($search, $limit = 10000) {
        $this->db->from('account_type');
        $this->db->where("type_name LIKE '%" . $this->db->escape_like_str($search) . "%'  ");
        $this->db->order_by("type_name", "desc");
        $result = $this->db->get();
        return $result->num_rows();
    }

    public function search($search, $limit = 20, $offset = 0, $column = 'name', $orderby = 'desc') {
        $this->db->from('account_type');
        $this->db->where("type_name LIKE '%" . $this->db->escape_like_str($search) . "%'  ");
        $this->db->order_by($column, $orderby);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    public function get_search_suggestions($search, $limit = 25) {
        $suggestions = array();
        $this->db->from('account_type');
        $this->db->like("type_name", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("type_name", "asc");
        $by_company_name = $this->db->get();
        foreach ($by_company_name->result() as $row) {
            $suggestions[] = array('label' => $row->type_name);
        }
        
        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    public function get_data() {
        $query = $this->db->get('account_type');
        return $query->row_array();
    }

    public function get_info($type_id) {
        $this->db->from('account_type');
        $this->db->where('type_id', $type_id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            $customertype_obj = new stdClass();
            $fields = $this->db->list_fields('account_type');
            foreach ($fields as $field) {
                $customertype_obj->$field = '';
            }
            return $customertype_obj;
        }
    }

    public function exists($type_id) {
        $this->db->from('account_type');
        $this->db->where('type_id', $type_id);
        $query = $this->db->get();

        return ($query->num_rows() == 1);
    }

    public function save(&$type_data, $type_id = false) {
        if (!$type_id or ! $this->exists($type_id)) {
            if ($this->db->insert('account_type', $type_data)) {
                $type_data['type_id'] = $this->db->insert_id();
                return true;
            }
            return false;
        } else {
            $this->db->where('type_id', $type_id);
            return $this->db->update('account_type', $type_data);
        }
    }

    public function delete_list($type_id) {
        $this->db->where('type_id', $type_id);
        $this->db->delete('account_type');
    }

    public function check_account_type($type_id) {
        $this->db->where('acc_cat_id', $type_id);
        return $this->db->get('tkdu')->num_rows();
    }

   
    //check trùng tên dungbv
    public function get_name($type_name, $type_id='') {
       if($type_id){
           $this->db->where('type_id !=',$type_id);
       }
       $this->db->where('type_name',$type_name);
       return $this->db->get('account_type')->num_rows();
    }

}

?>