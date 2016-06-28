<?php

class Reseller_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    //check trùng tên
    function getname($id) {
        if ($id > 0) {
            $this->db->select('title');
            $this->db->where('id !=', $id);
            $this->db->from('resellers');
            $query = $this->db->get();
        } elseif ($id = -1) {
            $this->db->select('title');
            $this->db->from('resellers');
            $query = $this->db->get();
        }
        foreach ($query->result_array() as $q) {
            $result[] = $q;
        }
        return $result;
    }

    function get_all1($limit = 100, $offset = 0, $col = 'id', $order = 'desc') {
        $this->db->from('resellers');
        $this->db->order_by($col, $order);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function count_all() {
        $this->db->from('resellers');
        return $this->db->count_all_results();
    }

    function insert($data) {
        $this->db->insert('resellers', $data);
    }

    function get_info($id_support) {
        $this->db->from('resellers');
        $this->db->where('id', $id_support);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            $item_obj = new stdClass();
            $fields = $this->db->list_fields('resellers');
            foreach ($fields as $field) {
                $customertype_obj->$field = '';
            }
            return $customertype_obj;
        }
    }

    function account_number_exists($id_unit) {
        $this->db->from('resellers');
        $this->db->where('id', $id_unit);
        $query = $this->db->get();

        return ($query->num_rows() == 1);
    }

    function exists($id_unit) {
        $this->db->from('resellers');
        $this->db->where('id', $id_unit);
        $query = $this->db->get();

        return ($query->num_rows() == 1);
    }

    function get_all() {
        $query = $this->db->get('resellers');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    //trùng tên
    function name_exists($id) {



        if ($id > 0) {
            $name_post = $this->input->post('title');

            $this->db->select('title');
            $this->db->from('resellers');
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
        $this->db->update('resellers', $value);
    }

    function save(&$item_data, $id_unit = false) {
        if (!$id_unit or ! $this->exists($id_unit)) {
            if ($this->db->insert('resellers', $item_data)) {
                $item_data['id'] = $this->db->insert_id();
                return true;
            }
            return false;
        } else {
            $this->db->where('id', $id_unit);
            return $this->db->update('resellers', $item_data);
        }
    }

    //------------------------------------------------------------------
    /////search
    // xo chu khi nhap gtri search
    function get_search_suggestions($search, $limit = 25) {
        $suggestions = array();
        $this->db->from('resellers');
        $this->db->like('title', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("title", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('label' => $row->title);
        }

        $this->db->from('resellers');
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
        $query = $this->db->get('resellers');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else
            return null;
    }

    function search($search, $limit = 10, $offset = 0, $column = 'title', $orderby = 'asc') {
        $this->db->from('resellers');
        $this->db->where("title LIKE '%" . $this->db->escape_like_str($search) . "%'  ");
        $this->db->order_by($column, $orderby);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function search_count_all($search) {
        $this->db->from('resellers');
        $this->db->where("title LIKE '%" . $this->db->escape_like_str($search) . "%'  ");
        $this->db->order_by("title", "asc");
        $result = $this->db->get();
        return $result->num_rows();
    }

    function item_unit($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('resellers');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else
            return null;
    }

    function delete_list($id_support) {
          $this->db->where('id',$id_support);
          $this->db->delete('resellers');
    }

    function check_exist_unit($id_unit) {
        $this->db->where("id", $id_unit);
        $query = $this->db->get("resellers");
        return $query->num_rows();
    }
    
    public function vn_str_filter($str) {

        $unicode = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd' => 'đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D' => 'Đ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );

        foreach ($unicode as $nonUnicode => $uni) {

            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }

        return $str;
    }

}

?>
