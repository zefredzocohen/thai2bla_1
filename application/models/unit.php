<?php

class Unit extends CI_Model {

    //check trùng tên
    function getname($id) {
        if ($id > 0) {
            $this->db->select('name');
            $this->db->where('id_unit !=', $id);
            $this->db->where('delete', 0);
            $this->db->from('units');
            $query = $this->db->get();
        } elseif ($id = -1) {
            $this->db->select('name');
            $this->db->where('delete', 0);
            $this->db->from('units');
            $query = $this->db->get();
        }
        foreach ($query->result_array() as $q) {
            $result[] = $q;
        }
        return $result;
    }

    function get_all1($limit = 100, $offset = 0, $col = 'id_unit', $order = 'desc') {
        $this->db->from('units');
        $this->db->where('delete', 0);
        $this->db->order_by($col, $order);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function count_all() {
        $this->db->from('units');
        $this->db->where('delete', 0);
        return $this->db->count_all_results();
    }

    function insert($data) {
        $this->db->insert('units', $data);
    }

    function get_info($id_unit) {
        $this->db->from('units');
        $this->db->where('id_unit', $id_unit);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            $item_obj = new stdClass();
            $fields = $this->db->list_fields('units');
            foreach ($fields as $field) {
                $customertype_obj->$field = '';
            }
            return $customertype_obj;
        }
    }

    function account_number_exists($id_unit) {
        $this->db->from('units');
        $this->db->where('id_unit', $id_unit);
        $query = $this->db->get();

        return ($query->num_rows() == 1);
    }

    function exists($id_unit) {
        $this->db->from('units');
        $this->db->where('id_unit', $id_unit);
        $query = $this->db->get();

        return ($query->num_rows() == 1);
    }

    function get_all() {
        $this->db->where('delete', 0);
        $query = $this->db->get('units');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    //trùng tên
    function name_exists($id) {



        if ($id > 0) {
            $name_post = $this->input->post('name');

            $this->db->select('name');
            $this->db->from('units');
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
        $this->db->where('id_unit', $id);
        $this->db->update('units', $value);
    }

    function save(&$item_data, $id_unit = false) {
        if (!$id_unit or ! $this->exists($id_unit)) {
            if ($this->db->insert('units', $item_data)) {
                $item_data['id_unit'] = $this->db->insert_id();
                return true;
            }
            return false;
        } else {
            $this->db->where('id_unit', $id_unit);
            return $this->db->update('units', $item_data);
        }
    }

    //------------------------------------------------------------------
    /////search
    // xo chu khi nhap gtri search
    function get_search_suggestions($search, $limit = 25) {
        $suggestions = array();
        $this->db->from('units');
        $this->db->where('delete', 0);
        $this->db->like('name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("name", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('label' => $row->name);
        }

        $this->db->from('units');
        $this->db->like('id_unit', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->where('delete', 0);
        $this->db->order_by("id_unit", "asc");
        $by_item_number = $this->db->get();
        foreach ($by_item_number->result() as $row) {
            $suggestions[] = array('label' => $row->id_unit);
        }

        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    /* 	function get_unit_search_suggestions($search,$limit=25)
      {
      $suggestions = array();

      $this->db->from('units');
      $this->db->where('delete',0);
      $this->db->like('name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
      $this->db->order_by("name", "asc");
      $by_name = $this->db->get();
      foreach($by_name->result() as $row)
      {
      $suggestions[]=array('value' => $row->id_unit, 'label' => $row->name);
      }

      $this->db->from('units');
      $this->db->where('delete',0);
      $this->db->like('id_unit', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
      $this->db->order_by("id_unit", "asc");
      if(count($suggestions > $limit))
      {
      $suggestions = array_slice($suggestions, 0,$limit);
      }
      return $suggestions;

      }

      function search12($search ,$cat='', $limit=20,$offset=0,$column='name',$orderby='asc')
      {
      if($cat) $cat_id = "and parentid = $cat ";
      else $cat_id = '';
      if ($this->config->item('speed_up_search_queries'))
      {
      $query = "
      select *
      from (
      (select *
      from ".$this->db->dbprefix('units')."
      where name like '".$this->db->escape_like_str($search)."%' and delete = 0
      order by `".$column."`)
      union
      (select *
      from ".$this->db->dbprefix('units')."
      where id_unit like '".$this->db->escape_like_str($search)."%' and delete = 0
      order by `".$column."`)

      ) as search_results
      order by `".$column."` limit ".$offset.','.$limit;
      return $this->db->query($query);
      }

      else
      {
      $str_search = str_replace( array('_', '@', '#', '$', '%') , ' ', $search );

      $search_terms_array=explode(" ", $this->db->escape_like_str($str_search));

      //to keep track of which search term of the array we're looking at now
      $search_name_criteria_counter=0;
      $sql_search_name_criteria = '';
      //loop through array of search terms
      foreach ($search_terms_array as $x){

      $sql_search_name_criteria.=
      ($search_name_criteria_counter > 0 ? " AND " : "").
      "name LIKE '%".$this->db->escape_like_str($x)."%'";

      $search_name_criteria_counter++;
      }

      $this->db->from('units');
      $this->db->where("((".
      $sql_search_name_criteria. ") or
      id_unit LIKE '%".$this->db->escape_like_str($search)."%') $cat_id and delete=0");
      //location LIKE '%".$this->db->escape_like_str($search)."%') $cat_id and delete=0");
      $this->db->order_by($column, $orderby);
      $this->db->limit($limit);
      $this->db->offset($offset);
      return $this->db->get();
      }

      }



      function search_count_all213($search,$cat='')
      {		if($cat) $cat_id = "and parentid = $cat ";
      else $cat_id = '';

      function search_count_all($search,$cat='')
      {		if($cat) $cat_id = "and parentid = $cat ";
      else $cat_id = '';

      if ($this->config->item('speed_up_search_queries'))
      {
      $query = "
      select *
      from (
      (select *
      from ".$this->db->dbprefix('units')."
      where name like '".$this->db->escape_like_str($search)."%' and delete = 0
      order by `name` )
      union
      (select *
      from ".$this->db->dbprefix('units')."
      where id_unit like '".$this->db->escape_like_str($search)."%' and delete = 0
      order by `name`)

      ) as search_results
      order by `name`";
      $result=$this->db->query($query);
      return $result->num_rows();
      }
      else
      {
      $this->db->from('units');
      $this->db->where("(name LIKE '%".$this->db->escape_like_str($search)."%' or
      id_unit LIKE '%".$this->db->escape_like_str($search)."%') $cat_id and delete=0");
      $this->db->order_by("name", "asc");
      $result=$this->db->get();
      return $result->num_rows();
      }
      }


      function search($search ,$cat='', $limit=20,$offset=0,$column='name',$orderby='asc')
      {
      if($cat) $cat_id = "and parentid = $cat ";
      else $cat_id = '';
      if ($this->config->item('speed_up_search_queries'))
      {
      $query = "
      select *
      from (
      (select *
      from ".$this->db->dbprefix('units')."
      where name like '".$this->db->escape_like_str($search)."%' and delete = 0
      order by `".$column."`)
      union
      (select *
      from ".$this->db->dbprefix('units')."
      where id_unit like '".$this->db->escape_like_str($search)."%' and delete = 0
      order by `".$column."`)

      ) as search_results
      order by `".$column."` limit ".$offset.','.$limit;
      return $this->db->query($query);
      }

      else
      {
      $str_search = str_replace( array('_', '@', '#', '$', '%') , ' ', $search );

      $search_terms_array=explode(" ", $this->db->escape_like_str($str_search));

      //to keep track of which search term of the array we're looking at now
      $search_name_criteria_counter=0;
      $sql_search_name_criteria = '';
      //loop through array of search terms
      foreach ($search_terms_array as $x){

      $sql_search_name_criteria.=
      ($search_name_criteria_counter > 0 ? " AND " : "").
      "name LIKE '%".$this->db->escape_like_str($x)."%'";

      $search_name_criteria_counter++;
      }

      $this->db->from('units');
      $this->db->where("((".
      $sql_search_name_criteria. ") or
      id_unit LIKE '%".$this->db->escape_like_str($search)."%' ) $cat_id and delete=0");

      $this->db->order_by($column, $orderby);
      $this->db->limit($limit);
      $this->db->offset($offset);
      return $this->db->get();
      }

      }


      function search_count_all($search,$cat='')
      {		if($cat) $cat_id = "and parentid = $cat ";
      else $cat_id = '';
      if ($this->config->item('speed_up_search_queries'))
      {
      $query = "
      select *
      from (
      (select *
      from ".$this->db->dbprefix('units')."
      where name like '".$this->db->escape_like_str($search)."%' and delete = 0
      order by `name` )
      union
      (select *
      from ".$this->db->dbprefix('units')."
      where id_unit like '".$this->db->escape_like_str($search)."%' and delete = 0
      order by `name`)

      ) as search_results
      order by `name`";
      $result=$this->db->query($query);
      return $result->num_rows();
      }
      else
      {
      $this->db->from('units');
      $this->db->where("(name LIKE '%".$this->db->escape_like_str($search)."%' or
      id_unit LIKE '%".$this->db->escape_like_str($search)."%') $cat_id and delete=0");

      $this->db->order_by("name", "asc");
      $result=$this->db->get();
      return $result->num_rows();
      }
      }

      function get_unit_suggestions($search)//
      {
      $suggestions = array();
      //$this->db->distinct();
      //$this->db->select('parentid');
      $this->db->from('units');
      $this->db->like('name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
      $this->db->where('delete', 0);
      $this->db->order_by("name", "asc");
      $by_category = $this->db->get();
      foreach($by_category->result() as $row)
      {
      $suggestions[]=array('label' => $row->name);
      }

      return $suggestions;
      } */

    function get_info1($id_unit) {

        $this->db->where('id_unit', $id_unit);
        $query = $this->db->get('units');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else
            return null;
    }

    function search($search, $limit = 10, $offset = 0, $column = 'name', $orderby = 'asc') {
        $this->db->where('delete', 0);
        $this->db->from('units');
        $this->db->where("name LIKE '%" . $this->db->escape_like_str($search) . "%'  ");
        $this->db->order_by($column, $orderby);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function search_count_all($search) {
        $this->db->where('delete', 0);
        $this->db->from('units');
        $this->db->where("name LIKE '%" . $this->db->escape_like_str($search) . "%'  ");
        $this->db->order_by("name", "asc");
        $result = $this->db->get();
        return $result->num_rows();
    }

    function item_unit($id) {
        $this->db->where('id_unit', $id);
        $query = $this->db->get('units');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else
            return null;
    }

    function delete_list($id_unit) {
        if (!$select_inventory) {
            $this->db->where_in('id_unit', $id_unit);
        }
        return $this->db->update('units', array('delete' => 1));
    }

    function check_exist_unit($id_unit) {
        $this->db->where("id_unit", $id_unit);
        $query = $this->db->get("units");
        return $query->num_rows();
    }

}

?>
