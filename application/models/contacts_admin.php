<?php

class Contacts_admin extends CI_Model {

  

    function get_all1($limit = 100, $offset = 0, $col = 'id', $order = 'desc') {
        $this->db->from('contact_home');
        $this->db->order_by($col, $order);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function count_all() {
        $this->db->from('contact_home');
        return $this->db->count_all_results();
    }



    function get_all() {
        $query = $this->db->get('contact_home');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

   
    //------------------------------------------------------------------
    /////search
    // xo chu khi nhap gtri search
    function get_search_suggestions($search, $limit = 25) {
        $suggestions = array();
        $this->db->from('contact_home');
        $this->db->like('fullname', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("fullname", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('label' => $row->fullname);
        }

        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

   
    function get_info1($id_unit) {

        $this->db->where('id', $id_unit);
        $query = $this->db->get('contact_home');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else
            return null;
    }

    function get_info($id)
    {
        $this->db->from('contact_home');
        $this->db->where('id',$id);
        $query = $this->db->get();

        if($query->num_rows()==1)
        {
            return $query->row();
        }
        else
        {
            //Get empty base parent object, as $supplier_id is NOT an supplier
            $person_obj=parent::get_info(-1);
                
            //Get all the fields from supplier table
            $fields = $this->db->list_fields('contact_home');
                
            //append those fields to base parent object, we we have a complete empty object
            foreach ($fields as $field)
            {
                $person_obj->$field='';
            }
                
            return $person_obj;
        }
    }
    function search($search, $limit = 10, $offset = 0, $column = 'fullname', $orderby = 'asc') {
        $this->db->from('contact_home');
        $this->db->where("fullname LIKE '%" . $this->db->escape_like_str($search) . "%'  ");
        $this->db->order_by($column, $orderby);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function search_count_all($search) {
        $this->db->from('contact_home');
        $this->db->where("fullname LIKE '%" . $this->db->escape_like_str($search) . "%'  ");
        $this->db->order_by("fullname", "asc");
        $result = $this->db->get();
        return $result->num_rows();
    }


    function delete_list($id) {
        $this->db->where('id',$id);
        $this->db->delete('contact_home');
    }

    function update_contact($data,$id){
        $this->db->where('id',$id);
        $this->db->update('contact_home',$data);
    }

    public function insert_contact($data){
        $this->db->insert('contact_home', $data);
    }
}

?>
