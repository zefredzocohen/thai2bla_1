<?php

class News_category_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    // check parentid (select option)
    function check($parentid = 0) {
        $this->db->where('deleted', 0);
        $this->db->where('parentid', $parentid);
        $query = $this->db->get('news_category');
        return $query;
    }

    //check trùng tên
    function getname($id) {
        if ($id > 0) {
            $this->db->select('name');
            $this->db->where('deleted', 0);
            $this->db->where('id_cat !=', $id);
            $this->db->from('news_category');
            $query = $this->db->get();
        } elseif ($id = -1) {
            $this->db->select('name');
            $this->db->where('deleted', 0);
            $this->db->from('news_category');
            $query = $this->db->get();
        }
        foreach ($query->result_array() as $q) {
            $result[] = $q;
        }
        return $result;
    }

    function get_all() {
        $this->db->where('deleted', 0);
        $query = $this->db->get('news_category');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function getAllActiveCats() {
        $this->db->where('deleted', 0);
        $this->db->where('active', 1);
        $query = $this->db->get('news_category');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else
            return null;
    }

    function get_all1($limit = 100, $offset = 0, $col = 'id_cat', $order = 'desc') {
        $this->db->from('news_category');
        $this->db->where('deleted', 0);
        $this->db->order_by($col, $order);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function count_all() {
        $this->db->from('news_category');
        $this->db->where('deleted', 0);
        return $this->db->count_all_results();
    }

    function insert($data) {
        $this->db->insert('news_category', $data);
    }

    function exists($id_cat) {
        $this->db->from('news_category');
        $this->db->where('id_cat', $id_cat);
        $query = $this->db->get();

        return ($query->num_rows() == 1);
    }

    function update_cat($id, $value) {
        $this->db->where('id_cat', $id);
        $this->db->update('news_category', $value);
    }

    /*
      Inserts or updates a item
     */

    function save1(&$item_data, $id_cat = false) {
        if (!$id_cat or ! $this->exists($id_cat)) {
            //if($this->db->insert('news_category',$item_data))
            //{
            //  $item_data['id_cat']= $this->db->insert_id();
            //  return true;
            //}
            //return false;
            //$this->db->insert('news_category',$item_data);
        } else {
            $this->db->where('id_cat', $id_cat);
            return $this->db->update('news_category', $item_data);
        }
    }

    function save(&$item_data, $id_cat = false) {
        if (!$id_cat or ! $this->exists($id_cat)) {
            if ($this->db->insert('news_category', $item_data)) {
                $item_data['id_cat'] = $this->db->insert_id();
                return true;
            }
            return false;
        } else {
            $this->db->where('id_cat', $id_cat);
            return $this->db->update('news_category', $item_data);
        }
    }

    // xo chu khi nhap gtri search
    function get_search_suggestions($search, $limit = 25) {
        $suggestions = array();

        $this->db->from('news_category');
        $this->db->like('name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->where('deleted', 0);
        $this->db->order_by("name", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('label' => $row->name);
        }

        $this->db->select('parentid');
        $this->db->from('news_category');
        $this->db->where('deleted', 0);
        $this->db->distinct();
        $this->db->like('parentid', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("parentid", "asc");
        $by_category = $this->db->get();
        foreach ($by_category->result() as $row) {
            $suggestions[] = array('label' => $row->parentid);
        }

        $this->db->from('news_category');
        $this->db->like('id_cat', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->where('deleted', 0);
        $this->db->order_by("id_cat", "asc");
        $by_item_number = $this->db->get();
        foreach ($by_item_number->result() as $row) {
            $suggestions[] = array('label' => $row->id_cat);
        }

        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    function get_category_search_suggestions($search, $limit = 25) {
        $suggestions = array();

        $this->db->from('news_category');
        $this->db->where('deleted', 0);
        $this->db->like('name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("name", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('value' => $row->id_cat, 'label' => $row->name);
        }

        $this->db->from('news_category');
        $this->db->where('deleted', 0);
        $this->db->like('id_cat', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("id_cat", "asc");
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    function search($search, $cat_service = '', $limit = 20, $offset = 0, $column = 'name', $orderby = 'asc') {
        if ($cat_service != '') {
            if ($cat_service == 1 || $cat_service == 0) {
                $cat_id = "and cat_service = $cat_service ";
            }
        } else {
            $cat_id = '';
        }
        if ($this->config->item('speed_up_search_queries')) {

            $query = "
            select *
            from (
                     (select *
                     from " . $this->db->dbprefix('news_category') . "
                     where name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                     order by `" . $column . "`)
                    union
                     (select *
                     from " . $this->db->dbprefix('news_category') . "
                     where id_cat like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                     order by `" . $column . "`)
                    union
                     (select *
                     from " . $this->db->dbprefix('news_category') . "
                     where parentid like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                     order by `" . $column . "`)
            ) as search_results
            order by `" . $column . "` limit " . $offset . ',' . $limit;
            return $this->db->query($query);
        } else {
            $str_search = str_replace(array('_', '@', '#', '$', '%'), ' ', $search);

            $search_terms_array = explode(" ", $this->db->escape_like_str($str_search));

            //to keep track of which search term of the array we're looking at now
            $search_name_criteria_counter = 0;
            $sql_search_name_criteria = '';
            //loop through array of search terms
            foreach ($search_terms_array as $x) {

                $sql_search_name_criteria.=
                        ($search_name_criteria_counter > 0 ? " AND " : "") .
                        "name LIKE '%" . $this->db->escape_like_str($x) . "%'";

                $search_name_criteria_counter++;
            }

            $this->db->from('news_category');
            $this->db->where("((" .
                    $sql_search_name_criteria . ") or
            id_cat LIKE '%" . $this->db->escape_like_str($search) . "%' or
            parentid LIKE '%" . $this->db->escape_like_str($search) . "%') $cat_id and deleted=0");
            $this->db->order_by($column, $orderby);
            $this->db->limit($limit);
            $this->db->offset($offset);
            return $this->db->get();
        }
    }

    function search_count_all($search, $cat_service = '') {
        if ($cat_service != '') {
            if ($cat_service == 1 || $cat_service == 0) {
                $cat_id = "and cat_service = $cat_service ";
            }
        } else {
            $cat_id = '';
        }
        if ($this->config->item('speed_up_search_queries')) {
            $query = "
            select *
            from (
                     (select *
                     from " . $this->db->dbprefix('news_category') . "
                     where name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                     order by `name` )
                    union
                     (select *
                     from " . $this->db->dbprefix('news_category') . "
                     where id_cat like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                     order by `name`)
                    union
                     (select *
                     from " . $this->db->dbprefix('news_category') . "
                     where parentid like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                     order by `name` )
            ) as search_results
            order by `name`";
            $result = $this->db->query($query);
            return $result->num_rows();
        } else {
            $this->db->from('news_category');
            $this->db->where("(name LIKE '%" . $this->db->escape_like_str($search) . "%' or
            id_cat LIKE '%" . $this->db->escape_like_str($search) . "%' or
            parentid LIKE '%" . $this->db->escape_like_str($search) . "%') $cat_id and deleted=0");
            $this->db->order_by("name", "asc");
            $result = $this->db->get();
            return $result->num_rows();
        }
    }

    function get_category_suggestions($search) {
        $suggestions = array();
        $this->db->distinct();
        $this->db->select('parentid');
        $this->db->from('news_category');
        $this->db->like('parentid', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->where('deleted', 0);
        $this->db->order_by("parentid", "asc");
        $by_category = $this->db->get();
        foreach ($by_category->result() as $row) {
            $suggestions[] = array('label' => $row->parentid);
        }

        return $suggestions;
    }

    function get_info1($id_cat) {

        $this->db->where('id_cat', $id_cat);
        $query = $this->db->get('news_category');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else
            return null;
    }

    function get_info($id_cat) {
        $this->db->where('id_cat', $id_cat);
        $query = $this->db->get('news_category');

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //Get empty base parent object, as $item_id is NOT an item
            $item_obj = new stdClass();

            //Get all the fields from items table
            $fields = $this->db->list_fields('news_category');

            foreach ($fields as $field) {
                $item_obj->$field = '';
            }
            return $item_obj;
        }
    }

    function account_number_exists($id_cat) {
        $this->db->from('news_category');
        $this->db->where('id_cat', $id_cat);
        $query = $this->db->get();

        return ($query->num_rows() == 1);
    }

    function item_info($id_cat) {
        $this->db->where('deleted', 0);
        $query = $this->db->get('news_category');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function delete_list($id_cat) {
        if (!$select_inventory) {
            $this->db->where_in('id_cat', $id_cat);
        }
        return $this->db->update('news_category', array('deleted' => 1));
    }

    //Create by San
    //Check xem loai san pham co ton tai san pham nao ko
    function check_exist_item_in_category($id) {
        $this->db->from("items");
        $this->db->where("category", $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    //Check xem loai san pham co ton tai thanh pham nao ko
    function check_exist_item_kit_in_category($id) {
        $this->db->from("item_kits");
        $this->db->where("category", $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    //hung audi 16-4-15
    function get_id_cat($code_cat){
        $this->db->where('code_cat', $code_cat);
        $d= $this->db->get('news_category');
        return $d->row()->id_cat;
    }

    //dungbv
    function get_all_category_items(){
        $this->db->where('cat_service',0);
        $this->db->where('deleted',0);
        $query = $this->db->get('news_category');
        return $query->result_array();
    }

    function get_category_items($cate){
        $this->db->where('id_cat',$cate);
        $this->db->where('cat_service',0);
        $this->db->where('deleted',0);
        $query = $this->db->get('news_category');
        return $query->result_array();
    }

    function exists_id_cat($id_cat) {
        $this->db->where('code_cat', $id_cat);
        $this->db->where('cat_service', 0);
        $this->db->where('deleted',0);
        return $query = $this->db->get('news_category')->num_rows();
    }
    //end dung
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

    function getFiveActiveCategories() {
        $this->db->where('deleted', 0);
        $this->db->where('cat_service', 0);
        $this->db->where('active', 1);
        $this->db->limit(5);
        $this->db->offset(0);
        $query = $this->db->get('news_category');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else
            return null;
    }
}

?>
