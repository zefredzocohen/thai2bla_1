<?php
class Sliders extends CI_Model
{
    function exists($id)
    {
        $this->db->from('slider');
        $this->db->where('id',$id);
        $query = $this->db->get();

        return ($query->num_rows()==1);
    }
    public function get_img()
     {
      $query=$this->db->get('slider');

      return $query->result_array();
     }
    function get_all($limit=100, $offset=0)
    {
        $this->db->from('slider');
        // $this->db->where('active',1);
        $this->db->where('deleted !=','1');
        $this->db->where('id !=',5);
        // $this->db->order_by($col, $order);,$col='name',$order='asc'
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }
    function get_by_id()
    {
        $this->db->from('slider');
        // $this->db->where('active',1);
        $this->db->where('id',5);
        return $this->db->get();
    }
    function get_slider_cooker_active($limit=1, $offset=0)
    {
        $this->db->from('slider');
        $this->db->where('active',1);
        $this->db->where('id',5);
        $this->db->where('deleted',0);
        // $this->db->order_by($col, $order);,$col='name',$order='asc'
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get()->result();
    }

    function count_all()
    {
        $this->db->from('slider');
        $this->db->where('active',1);
        return $this->db->count_all_results();
    }

    function save(&$item_data,$id=false)
    {
        if (!$id or !$this->exists($id))
        {
            if($this->db->insert('slider',$item_data))
            {
                $item_data['id']=$this->db->insert_id();
                return true;
            }
            return false;
        }
        else{
        $this->db->where('id',$id);
        return $this->db->update('slider',$item_data);}

    }

    function get_info($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('slider');

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //Get empty base parent object, as $item_id is NOT an item
            $item_obj = new stdClass();

            //Get all the fields from items table
            $fields = $this->db->list_fields('slider');

            foreach ($fields as $field) {
                $item_obj->$field = '';
            }
            return $item_obj;
        }
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
                     from " . $this->db->dbprefix('slider') . "
                     where name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                     order by `" . $column . "`)
                    union
                     (select *
                     from " . $this->db->dbprefix('slider') . "
                     where id like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                     order by `" . $column . "`)
                    union
                     (select *
                     from " . $this->db->dbprefix('slider') . "
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

            $this->db->from('slider');
            $this->db->where("((" .
                    $sql_search_name_criteria . ") or
            id LIKE '%" . $this->db->escape_like_str($search) . "%' or
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
                     from " . $this->db->dbprefix('slider') . "
                     where name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                     order by `name` )
                    union
                     (select *
                     from " . $this->db->dbprefix('slider') . "
                     where id like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                     order by `name`)
                    union
                     (select *
                     from " . $this->db->dbprefix('slider') . "
                     where parentid like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                     order by `name` )
            ) as search_results
            order by `name`";
            $result = $this->db->query($query);
            return $result->num_rows();
        } else {
            $this->db->from('slider');
            $this->db->where("(name LIKE '%" . $this->db->escape_like_str($search) . "%' or
            id LIKE '%" . $this->db->escape_like_str($search) . "%' or
            parentid LIKE '%" . $this->db->escape_like_str($search) . "%') $cat_id and deleted=0");
            $this->db->order_by("name", "asc");
            $result = $this->db->get();
            return $result->num_rows();
        }
    }

    function delete_list($id) {
        $this->db->where_in('id', $id);
        return $this->db->update('slider', array('deleted' => 1));
    }

    function get_all_active($limit=100, $offset=0)
    {
        $this->db->from('slider');
        $this->db->where('active',1);
        $this->db->where('id !=',5);
        $this->db->where('deleted',0);
        // $this->db->order_by($col, $order);,$col='name',$order='asc'
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get()->result();
    }

}
?>
