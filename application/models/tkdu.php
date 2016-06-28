<?php

class Tkdu extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    public function get_all($limit = 10000, $offset = 0, $col = 'name', $order = 'asc') {
        $this->db->from('tkdu');
        $this->db->order_by($col, $order);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }
    public function count_all() {
        $query = $this->db->get('tkdu');
        return $query->num_rows();
    }

    function get_tkdu() {
        $query = $this->db->get('tkdu');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }



    public function get_tkdu_parent() {
        $this->db->where('level', 1);
        $query = $this->db->get('tkdu');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    public function search_count_all($search, $limit = 10000) {
        $this->db->from('tkdu');
        $this->db->where("name LIKE '%" . $this->db->escape_like_str($search) . "%'  ");
        $this->db->order_by("name", "asc");
        $result = $this->db->get();
        return $result->num_rows();
    }

    public function search($search, $limit = 20, $offset = 0, $column = 'name', $orderby = 'asc') {
        $this->db->from('tkdu');
        $this->db->where("name LIKE '%" . $this->db->escape_like_str($search) . "%'  ");
        $this->db->order_by($column, $orderby);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    public function get_search_suggestions($search, $limit = 25) {
        $suggestions = array();
        $this->db->from('tkdu');
        $this->db->like("name", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("name", "asc");
        $by_company_name = $this->db->get();
        foreach ($by_company_name->result() as $row) {
            if ($row->id) {
                $suggestions[] = array(
                    'value' => $row->name,
                    'label' => $row->name);
            }
        }
        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    public function get_data() {
        $query = $this->db->get('tkdu');
        return $query->row_array();
    }

    public function get_list_customer_types() {
        $this->db->select(array('id', 'name'));
        $this->db->from('tkdu');
        $this->db->distinct();
        $this->db->order_by("name", "asc");
        return $this->db->get();
    }

    public function exists($custometype_id) {
        $this->db->from('tkdu');
        $this->db->where('id', $custometype_id);
        $query = $this->db->get();
        return ($query->num_rows() == 1);
    }

    public function save(&$customertype_data, $customertype_id = false) {
        if (!$customertype_id or ! $this->exists($customertype_id)) {
            if ($this->db->insert('tkdu', $customertype_data)) {
                $customertype_data['id'] = $this->db->insert_id();
                return true;
            }
            return false;
        }
        $this->db->where('id', $customertype_id);

        return $this->db->update('tkdu', $customertype_data);
    }

    public function get_info($customertype_id) {
        $this->db->from('tkdu');
        $this->db->where('id', $customertype_id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            $customertype_obj = new stdClass();
            $fields = $this->db->list_fields('tkdu');
            foreach ($fields as $field) {
                $customertype_obj->$field = '';
            }
            return $customertype_obj;
        }
    }

    public function delete_list($customertype_id) {

        $this->db->where_in('id', $customertype_id);

        return $this->db->delete('tkdu');
    }

//        Loi
    function get_account_type() {
        $this->db->from('account_type');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_info_account_type($id) {
        $this->db->from('account_type');
        $this->db->where('type_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            $customertype_obj = new stdClass();
            $fields = $this->db->list_fields('tkdu');
            foreach ($fields as $field) {
                $customertype_obj->$field = '';
            }
            return $customertype_obj;
        }
    }

    function get_all_tk2_by_tk1($id) {
        $this->db->from('tkdu');
        $this->db->where('id_parent', $id);
        return $this->db->get();
    }

//        end Loi
    /* Sep 11, 2015 Hưng Audi OOOO */
    //account_plan
    function count_all_account_plan() {
        return $this->db->get(account_plan)
                        ->num_rows();
    }
    function get_all_account_plan($limit = 10000, $offset = 0) {
        return $this->db->limit($limit)
                        ->offset($offset)
                        ->get(account_plan);
    }
    function search_count_all_account_plan($search, $limit = 10000) {
        return $this->db->from(account_plan)
                        ->where("name LIKE '%" . $this->db->escape_like_str($search) . "%'  ")
                        ->order_by("name", "asc")
                        ->get()
                        ->num_rows();
    }
    function search_account_plan($search, $limit = 20, $offset = 0, $column = 'name', $orderby = 'asc') {
        return $this->db->where("name LIKE '%" . $this->db->escape_like_str($search) . "%'  ")
                ->order_by($column, $orderby)
                ->limit($limit)
                ->offset($offset)
                ->get(account_plan);
    }   
    function get_search_suggestions_account_plan($search, $limit = 25) {
        $suggestions = array();
        $by_company_name = $this->db->like("name", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both')
                ->order_by("name", "asc")
                ->get(account_plan);
        foreach ($by_company_name->result() as $row) {
            $suggestions[] = array('label' => $row->name);
        }
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }
    function delete_list_account_plan($customertype_id) {
        return $this->db->where_in(id, $customertype_id)
                        ->delete(account_plan);
    }
    function get_info_account_plan($id){
        return $this->db->where(id, $id)
                        ->get(account_plan)
                        ->row();
    }
    function save_account_plan($data, $id = false) {
        if (!$id or ! $this->exists_account_plan($id)) {
            if ($this->db->insert(account_plan, $data)) {
                $data['id'] = $this->db->insert_id();
                return true;
            }
            return false;
        }
        return $this->db->where(id, $id)
                        ->update(account_plan, $data);
    }
    function exists_account_plan($id) {
        return $this->db->where(id, $id)
                        ->get(account_plan)
                        ->num_rows() == 1;
    }
    //Hưng Audi 19-9-15
    function get_tk_no_limit() {
        $ids = '621,622,623,627';
        $query = $this->db->where('level', 1)
                            ->where("id in ($ids)")
                            ->get('tkdu');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }
    //Hưng Audi Nov 3
    function get_bank_list() {
        return $this->db->where('id !=', 1121)
                        ->where("id like '1121%'")
                        ->get('tkdu');
    }
    //Hưng Audi say gOOdbye \/
    function get_tkdu_parent_fashion() {
        $this->db->where('level', 1);
        $this->db->where('id < ', 500);
        $query = $this->db->get('tkdu');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }
    function update_tkdu($data, $id) {
        foreach ($data as $r) {
            $this->db->where('id', $id)
                    ->update('tkdu', $r);
        }
    }
    //cong_no_khac
    function save_cong_no_khac(&$data) {
        $this->db->trans_start();
        $this->delete_cong_no_khac();
        foreach ($data as $r) {
            $this->db->insert('cong_no_khac', $r);
        }
        $this->db->trans_complete();
        return true;
    }

    function delete_cong_no_khac() {
        $this->db->delete('cong_no_khac', "id != 0");
    }
    function get_all_cong_no_khac(){
        return $this->db->get('cong_no_khac');
    }
    //item
    function update_item($data, $id) {
        foreach ($data as $r) {
            $this->db->where('item_id', $id)
                    ->update('items', $r);
        }
    }
    //____________________________________say gOOdbye Hưng Audi___________________________________
    function get_tkdu_parent_audi($limit = 1000, $offset=0) {
        return $this->db
                        ->where('level', 1)
                        ->limit($limit)
                        ->offset($offset)
                        ->get('tkdu');
    }
    
    //ncc
    function get_all_cong_no_ncc(){
        return $this->db->get('cong_no_ncc');
    }
    function save_cong_no_ncc(&$data) {
        $this->db->trans_start();
        $this->delete_cong_no_ncc();
        foreach ($data as $r) {
            $this->db->insert('cong_no_ncc', $r);
        }
        $this->db->trans_complete();
        return true;
    }
    function delete_cong_no_ncc() {
        $this->db->delete('cong_no_ncc', "id != 0");
    }
    function get_info_cong_no_ncc_by_year($person_id, $start_date){
        return $this->db->where('person_id', $person_id)
                        ->where('oh_year <=', $start_date)
                        ->get('cong_no_ncc');
    }
    //kh
    function get_all_cong_no_kh(){
        return $this->db->get('cong_no_kh');
    }
    function save_cong_no_kh(&$data) {
        $this->db->trans_start();
        $this->delete_cong_no_kh();
        foreach ($data as $r) {
            $this->db->insert('cong_no_kh', $r);
        }
        $this->db->trans_complete();
        return true;
    }
    function delete_cong_no_kh() {
        $this->db->delete('cong_no_kh', "id != 0");
    }
    function get_customer_search($search, $limit = 25) {
        $suggestions = array();
        $this->db->from('customers');
        $this->db->join('people', 'customers.person_id=people.person_id');
        $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' 
            or CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0");
        $this->db->order_by("last_name", "asc");
        $by_name = $this->db->get()->result();
        foreach ($by_name as $row) {
            $lable = $row->first_name . ' ' . $row->last_name;
            if ($row->first_name) {
                $suggestions[] = array(
                    'value' => $row->person_id,
                    'label' => $lable,
                    'cost_phone' => $row->phone_number,
                );
            }
        }
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }
    function get_info_cong_no_kh_by_year($person_id, $start_date){
        return $this->db->where('person_id', $person_id)
                        ->where('oh_year <=', $start_date)
                        ->get('cong_no_kh');
    }
    
}

?>