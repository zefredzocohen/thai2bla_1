<?php

class Congcu extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function count_all() {
        $query = $this->db->get('congcus');
        return $query->num_rows();
    }

    public function get_all_info() {
        $query = $this->db->get('congcus');
        return $query->result_array();
    }

    public function update_value_asset($id, $value_remain) {
        $this->db->where('id', $id);
        $this->db->update('congcus', array('value_remain' => $value_remain));
    }

    public function get_all($limit = 10000, $offset = 0) {
        $this->db->from('congcus');
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    public function search_count_all($search, $limit = 10000) {
        $this->db->from('congcus');
        $this->db->where("name LIKE '%" . $this->db->escape_like_str($search) . "%'  ");
        $this->db->order_by("name", "asc");
        $result = $this->db->get();
        return $result->num_rows();
    }

    public function search($search, $limit = 20, $offset = 0, $column = 'name', $orderby = 'asc') {
        $this->db->from('congcus');
        $this->db->where("name LIKE '%" . $this->db->escape_like_str($search) . "%'  ");
        $this->db->order_by($column, $orderby);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    public function get_search_suggestions($search, $limit = 25) {
        $suggestions = array();
        $this->db->from('congcus');
        $this->db->like("name", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("name", "asc");
        $by_company_name = $this->db->get();
        foreach ($by_company_name->result() as $row) {
            $suggestions[] = array('label' => $row->name);
        }
        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    public function get_data() {
        $query = $this->db->get('congcus');
        return $query->row_array();
    }

    public function get_list_group_type() {
        $this->db->select(array('id', 'name'));
        $this->db->from('groups_asset');
        $this->db->distinct();
        $this->db->order_by("name", "asc");
        return $this->db->get();
    }

    public function get_list_ppkh_type() {
        $this->db->select(array('id', 'name'));
        $this->db->from('ppkh');
        $this->db->distinct();
        $this->db->order_by("name", "asc");
        return $this->db->get();
    }

    public function get_list_customer_types() {
        $this->db->select(array('id', 'name'));
        $this->db->from('congcus');
        $this->db->distinct();
        $this->db->order_by("name", "asc");
        return $this->db->get();
    }

    public function exists($custometype_id) {
        $this->db->from('congcus');
        $this->db->where('id', $custometype_id);
        $query = $this->db->get();
        return ($query->num_rows() == 1);
    }

    public function save(&$var_data, $var_id = false) {
        if (!$var_id or ! $this->exists($var_id)) {
            if ($this->db->insert('congcus', $var_data)) {
                $var_data['id'] = $this->db->insert_id();
                return true;
            }
            return false;
        }
        $this->db->where('id', $var_id);

        return $this->db->update('congcus', $var_data);
    }

    public function get_info($customertype_id) {
        $this->db->from('congcus');
        $this->db->where('id', $customertype_id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            $customertype_obj = new stdClass();
            $fields = $this->db->list_fields('congcus');
            foreach ($fields as $field) {
                $customertype_obj->$field = '';
            }
            return $customertype_obj;
        }
    }

    public function delete_list($var_id) {

        $this->db->where_in('id', $var_id);

        return $this->db->delete('congcus');
    }

    //Hưng Audi 0000 Oct 26
    // hello Halloween (^_^) 
    function save_allocate($var_data, $var_id) {
        return $this->db->where('id', $var_id)
                        ->update('congcus', $var_data);
    }
    function get_congcus_halloween($halloween_time) {
        $halloween_time_H = "$halloween_time-31";
        $sql = $this->db->where("han_khauhao >=", $halloween_time)
                        ->where("date_kh <=", $halloween_time_H)
                        ->where("allocate", 0)
                        ->get("congcus")
                        ->result();
        foreach($sql as $row){
            $suggestions[]=array(
                'id' => $row->id,
                'name' => $row->name,
                'money' => number_format($row->value / $row->ky_khauhao),
                'tkcp' => $row->tkcp,
                'tkkh' => $row->tkkh,
                'han_khauhao' => date('d-m-Y', strtotime($row->han_khauhao))
            );
        }
        if(count($suggestions > $limit)){
                $suggestions = array_slice($suggestions, 0,$limit);
        }
        return $suggestions;
    }
    
    
}

?>