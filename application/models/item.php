<?php

class Item extends CI_Model {

    public function add_post_verifying($post_data) {
        $this->db->insert('items_verifying', $post_data);
        return $this->db->insert_id();
    }

    public function kiemkho($id) {
        $this->db->select('si.item_id,si.quantity_purchased,
                            sum(si.quantity_purchased) buy,s.item_id id, s.*,
                            s.name,s.cost_price,s.quantity_total quantity_item');
        $this->db->from('items s');
        $this->db->join('sales_items si', 'si.item_id = s.item_id', 'left');
        $this->db->where('s.deleted', 0);
        $this->db->where('s.item_id', $id);
        $this->db->group_by('si.item_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function get_buy($item_id, $store) {
        $this->db->select('si.*, sum(quantity_purchased) buy2');
        $this->db->from('sales_items si');
        $this->db->join('sales s', 's.sale_id = si.sale_id', 'left');
        $this->db->where('s.materials', 0);
        $this->db->where('item_id', $item_id);
        $this->db->where('stored_id', $store);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function kiemkho_store($id, $store) {
        $this->db->select('s.*, s.name, s.cost_price, ci.id warehouse_id, s.quantity_total quantity_item,
                        wi.quantity quan, sum(si.quantity_purchased) buy, ci.*');
        $this->db->from('items s');
        $this->db->join('sales_items si', 'si.item_id = s.item_id', 'left');
        $this->db->join('warehouse_items wi', 'wi.item_id = s.item_id', 'left');
        $this->db->join('create_invetory ci', 'ci.id = wi.warehouse_id', 'left');
        $this->db->where('wi.item_id', $id);
        $this->db->where('wi.warehouse_id', $store);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    /* edit by : huyenlt^^
      date: 27/01/15
     */

    public function get_all_verifying() {
        $str_NextSundayDate = date('Y-m-d', strtotime('next Sunday')) . ' 23:59:59';
        $date_hientai = date('Y-m-d') . ' 00:00:00';
        $this->db->select('iv.*, i.*');
        $this->db->from('items_verifying as iv');
        $this->db->join('items as i', 'i.item_id = iv.item_id', 'left');
        $this->db->where('iv.date >= ', $date_hientai);
        $this->db->group_by('iv.id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    /* end edit by */

    public function get_new($id, $store) {

        $this->db->select('s.*, wi.*,sum(wi.quantity) as quan, wi.store_id');
        $this->db->from('items s');
        $this->db->join('warehouse_items wi', 'wi.item_id = s.item_id', 'left');
        $this->db->where('s.deleted', 0);
        $this->db->where('wi.item_id', $id);
        $this->db->where('wi.warehouse_id', $store);
        $this->db->group_by('wi.item_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function get_new_empty($id) {
        $this->db->select('items.*,items.item_id as id,items.quantity_total as quantity_item');
        $this->db->where('deleted', 0);
        $this->db->where('items.item_id', $id);
        $this->db->from('items');
        $this->db->group_by('items.item_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function get_id_Items_warehouse($store_id, $item_id) {//get id from warehouse
        $this->db->from('warehouse_items');
        $this->db->where('warehouse_id', $store_id);
        $this->db->where('item_id', $item_id);
        $query = $this->db->get();
        return $query->row();
    }

    function saveWarehouseItems(&$warehouse_item_data, $id = false) {//sl luu tru tung kho
        if (!$id) {
            if ($this->db->insert('warehouse_items', $warehouse_item_data)) {
                $warehouse_item_data['id'] = $this->db->insert_id();
                return true;
            }
            return false;
        }
        $this->db->where('id', $id);
        return $this->db->update('warehouse_items', $warehouse_item_data);
    }

    public function get_quantity_item_store($id, $store) {//get qty store
        $this->db->select('quantity');
        $this->db->from('warehouse_items');
        $this->db->where('item_id', $id);
        $this->db->where('warehouse_id', $store);
        return $this->db->get()->row()->quantity;
    }

    public function get_quantity_item($id) {//get qty total
        $this->db->select('quantity_total');
        $this->db->from('items');
        $this->db->where('item_id', $id);
        return $this->db->get()->row()->quantity_total;
    }

    public function update_quantiry($id, $data) {
        $this->db->where('item_id', $id);
        return $this->db->update('items', $data);
    }

    function update_quantity_store($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('warehouse_items', $data);
    }

    public function update_quantity($id, $data) {
        $this->db->where_in('item_id', $id);
        return $this->db->update('items', $data);
    }

    public function get_id_kho($id, $store) {//get qty store
        $this->db->select('id');
        $this->db->from('warehouse_items');
        $this->db->where('item_id', $id);
        $this->db->where('warehouse_id', $store);
        return $this->db->get()->row()->id;
    }

    public function get_id_Items_warehouse_total($item_id) {//get id from warehouse
        $this->db->from('items');
        $this->db->where('item_id', $item_id);
        $query = $this->db->get();
        return $query->row();
    }

    function saveWarehouseItems_total(&$warehouse_item_data, $id = false) {//sl luu tru tung kho
        $this->db->where('item_id', $id);
        return $this->db->update('items', $warehouse_item_data);
    }

    public function insert_stores_transfre($data) {//lich su chuyen kho
        $this->db->insert('transfer_stores', $data);
        return $this->db->insert_id();
    }

    //===
    public function get_item_search_suggestions_new($search, $cate, $limit = 25) {
        $suggestions = array();
        $this->db->from('items');
        $this->db->where('deleted', 0);
        $this->db->where('service', 0);
        if ($cate) {
            $this->db->where("category", $cate);
        }
        $this->db->like('name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->or_like('item_number', $search);
        $this->db->order_by("name", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $unit = $row->quantity_first == 0 ? $row->unit : $row->unit_from;
            $this->db->where("id_unit", $unit);
            $query = $this->db->get("units");
            $suggestions[] = array(
                'value' => $row->name,
                'label' => $row->item_number . " - " . $row->name,
                'cost_price_export' => number_format($row->quantity_first == 1 ? $row->cost_price_rate : $row->cost_price),
                'cost_price_export2' => $row->quantity_first == 1 ? $row->cost_price_rate : $row->cost_price,
                'item_number' => $row->item_number != null ? $row->item_number : '',
                'id' => $row->item_id,
                'unit' => $query->row()->name,
                'quantity' => format_quantity($row->quantity_total),
            );
        }

        $this->db->from('items');
        $this->db->where('deleted', 0);
        $this->db->where('service', 0);
        if ($cate) {
            $this->db->where("category", $cate);
        }
        $this->db->like('item_number', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("item_number", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $unit = $row->quantity_first == 0 ? $row->unit : $row->unit_from;
            $this->db->where("id_unit", $unit);
            $query = $this->db->get("units");
            $suggestions[] = array(
                'value' => $row->name,
                'label' => $row->item_number . " - " . $row->name,
                'cost_price_export' => number_format($row->quantity_first == 1 ? $row->cost_price_rate : $row->cost_price),
                'cost_price_export2' => $row->quantity_first == 1 ? $row->cost_price_rate : $row->cost_price,
                'item_number' => $row->item_number != null ? $row->item_number : '',
                'id' => $row->item_id,
                'unit' => $query->row()->name,
                'quantity' => format_quantity($row->quantity_total),
            );
        }

        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    function get_item_search_suggestions_new_and_store($search, $store, $cate, $limit = 25) {//search store
        $suggestions = array();
        //name
        $this->db->select("items.*, warehouse_items.quantity as quantity2");
        $this->db->from('items');
        $this->db->join('warehouse_items', "warehouse_items.item_id = items.item_id");
        $this->db->where('deleted', 0);
        $this->db->where('service', 0);
        $this->db->where('warehouse_items.warehouse_id', $store);
        if ($cate) {
            $this->db->where("category", $cate);
        }
        $this->db->like('name', $search);
        $by_name = $this->db->get();

        foreach ($by_name->result() as $row) {
            $unit = $row->quantity_first == 0 ? $row->unit : $row->unit_from;
            $this->db->where("id_unit", $unit);
            $query = $this->db->get("units");

            $suggestions[] = array(
                'value' => $row->name,
                'label' => $row->item_number . " - " .$row->name,
                'cost_price_export' => number_format($row->quantity_first == 1 ? $row->cost_price_rate : $row->cost_price),
                'cost_price_export2' => $row->quantity_first == 1 ? $row->cost_price_rate : $row->cost_price,
                'item_number' => $row->item_number != null ? $row->item_number : '',
                'id' => $row->item_id,
                'unit' => $query->row()->name,
                'quantity' => format_quantity($row->quantity2),
            );
        }

        //item_number
        $this->db->select("items.*, warehouse_items.quantity as quantity2");
        $this->db->from('items');
        $this->db->join('warehouse_items', "warehouse_items.item_id = items.item_id");
        $this->db->where('deleted', 0);
        $this->db->where('service', 0);
        $this->db->where('warehouse_items.warehouse_id', $store);
        if ($cate) {
            $this->db->where("category", $cate);
        }
        $this->db->like('item_number', $search);
        $by_name = $this->db->get();

        foreach ($by_name->result() as $row) {
            $unit = $row->quantity_first == 0 ? $row->unit : $row->unit_from;
            $this->db->where("id_unit", $unit);
            $query = $this->db->get("units");

            $suggestions[] = array(
                'value' => $row->name,
                'label' => $row->item_number . " - " .$row->name,
                'cost_price_export' => number_format($row->quantity_first == 1 ? $row->cost_price_rate : $row->cost_price),
                'cost_price_export2' => $row->quantity_first == 1 ? $row->cost_price_rate : $row->cost_price,
                'item_number' => $row->item_number != null ? $row->item_number : '',
                'id' => $row->item_id,
                'unit' => $query->row()->name,
                'quantity' => format_quantity($row->quantity2),
            );
        }

        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    function get_item_search_suggestions_stored22($search, $stored, $limit = 25) {//search in sale
        $suggestions = array();
        $this->db->select(array('items.*'));
        $this->db->from('items');
        $this->db->join('warehouse_items', "warehouse_items.item_id = items.item_id");

        $this->db->where('items.deleted', 0);
        $this->db->where('warehouse_items.warehouse_id', $stored);
        $this->db->like('items.name', $search);
        $this->db->order_by("items.name", "asc");

        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('value' => $row->item_id, 'label' => $row->name);
        }
        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    function get_item_search_suggestions_stored($search, $stored, $limit = 25) {
        $suggestions = array();
        $this->db->join('warehouse_items', "warehouse_items.item_id = items.item_id");
        $this->db->where('items.deleted', 0);
        $this->db->where('warehouse_items.warehouse_id', $stored);
        $this->db->where("(name LIKE '%" . $this->db->escape_like_str($search) . "%'
                or item_number LIKE '%" . $this->db->escape_like_str($search) . "%')");
        $this->db->order_by("items.name", "asc");
        $by_name1 = $this->db->get('items')->result();

        $this->db->where('deleted', 0);
        $this->db->where('service', 1);
        $this->db->where("(name LIKE '%" . $this->db->escape_like_str($search) . "%'
                or item_number LIKE '%" . $this->db->escape_like_str($search) . "%')");
        $this->db->order_by("name", "asc");
        $by_name2 = $this->db->get('items')->result();

        $by_name = array_merge($by_name1, $by_name2);

        foreach ($by_name as $row) {
            $suggestions[] = array(
                'value' => $row->item_id,
                'label' => $row->item_number . ' - ' . $row->name
            );
        }
        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    ///=======
    function get_search_suggestions($search, $limit = 25) {
        $suggestions = array();

        $this->db->from('items');
        $this->db->like('name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->where('deleted', 0);
        $this->db->where('service', 0);
        $this->db->order_by("name", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('label' => $row->name);
        }

        $this->db->from('items');
        $this->db->like('item_number', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->where('deleted', 0);
        $this->db->where('service', 0);
        $this->db->order_by("item_number", "asc");
        $by_item_number = $this->db->get();
        foreach ($by_item_number->result() as $row) {
            $suggestions[] = array('label' => $row->item_number);
        }

        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    public function get_join_transferand_warehouse($id) {//tổng số lượng NVL nhập và chuyển kho
        $this->db->select('items.item_id,items.name,items.cost_price,warehouse_items.*,sum(lifetek_warehouse_items.quantity) as total_transfer');
        $this->db->from('warehouse_items');
        $this->db->join('items', 'items.item_id = warehouse_items.item_id', 'left');
        $this->db->where('warehouse_items.warehouse_id', $id);
        $this->db->group_by('items.item_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    //check trùng tên
    function getname($name, $id) {
        if ($id > 0) {
            $this->db->where('name', $name);
            $this->db->where("item_id !=", $id);
            $this->db->where('deleted', 0);
            $query = $this->db->get('items');
        } elseif ($id = -1) {
            $this->db->where('name', $name);
            $this->db->where('deleted', 0);
            $query = $this->db->get('items');
        }
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /*
      Determines if a given item_id is an item
     */

    function exists($item_id) {
        $this->db->from('items');
        $this->db->where('item_id', $item_id);
        $query = $this->db->get();

        return ($query->num_rows() == 1);
    }

    /*
      Returns all the items
     */

    function get_all($limit = 10000, $offset = 0, $col = 'item_id', $order = 'desc') {
        $this->db->from('items');
        $this->db->where('deleted', 0);
        $this->db->order_by($col, $order);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function account_number_exists($item_number) {
        return $this->db->where('item_number', $item_number)
                        ->where('deleted', 0)
                        ->get('items')
                        ->num_rows() == 1;
    }

    function count_all() {
        $this->db->from('items');
        $this->db->where('deleted', 0);
        $this->db->where('service', 0);
        $this->db->where('product_view_home', 1);
        return $this->db->count_all_results();
    }

    /*
      Gets information about a particular item
     */

    function get_info($item_id) {
        $this->db->from('items');
        $this->db->where('item_id', $item_id);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //Get empty base parent object, as $item_id is NOT an item
            $item_obj = new stdClass();

            //Get all the fields from items table
            $fields = $this->db->list_fields('items');

            foreach ($fields as $field) {
                $item_obj->$field = '';
            }

            return $item_obj;
        }
    }

    /*
      Get an item id given an item number
     */

    function get_item_id($item_number) {
        $this->db->from('items');
        $this->db->where('item_number', $item_number);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row()->item_id;
        }
        return false;
    }

    /*
      Gets information about multiple items
     */

    function get_multiple_info($item_ids) {
        $this->db->from('items');
        $this->db->where_in('item_id', $item_ids);
        $this->db->order_by("item_id", "asc");
        return $this->db->get();
    }

    /*
      Inserts or updates a item
     */

    function save(&$item_data, $item_id = false) {
        if (!$item_id or ! $this->exists($item_id)) {
            if ($this->db->insert('items', $item_data)) {
                $item_data['item_id'] = $this->db->insert_id();
                return true;
            }
            return false;
        }
        $this->db->where('item_id', $item_id);
        return $this->db->update('items', $item_data);
    }

    function save_update(&$item_data, $item_id = false) {
        $this->db->where('item_id', $item_id);
        return $this->db->update('items', $item_data);
    }

    public function save_img_product($data) {
        $this->db->insert('img_product', $data);
    }

    /*
      Updates multiple items at once
     */

    function update_multiple($item_data, $item_ids, $select_inventory = 0) {
        if (!$select_inventory) {
            $this->db->where_in('item_id', $item_ids);
        }
        return $this->db->update('items', $item_data);
    }

    /*
      Deletes one item
     */

    function delete($item_id) {
        $this->db->where('item_id', $item_id);
        return $this->db->update('items', array('deleted' => 1));
    }

    /*
      Deletes a list of items
     */

    function delete_list($item_ids) {

        $this->db->where_in('item_id', $item_ids);
        return $this->db->update('items', array('deleted' => 1));
    }

//
    function get_all_item() {
        $this->db->where('service !=', 1);
        $this->db->where('produce !=', 1);
        $this->db->where('deleted', 0);
        return $this->db->get('items')->result();
    }

    function get_category_suggestions($search) {
        $suggestions = array();
        $this->db->distinct();
        $this->db->select('category');
        $this->db->from('items');
        $this->db->like('category', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->where('deleted', 0);
        $this->db->order_by("category", "asc");
        $by_category = $this->db->get();
        foreach ($by_category->result() as $row) {
            $suggestions[] = array('label' => $row->category);
        }

        return $suggestions;
    }

    /*
      Preform a search on items
      edit by : huyenlt^^
     */

    function search($search, $stores = '', $cat = '', $limit = 20, $offset = 0, $column = 'name', $orderby = 'asc') {
        if ($cat)
            $cat_id = "and category = $cat ";
        else
            $cat_id = '';
        if ($stores)
            $id = "and warehouse_id=$stores";
        else
            $id = '';

        if ($this->config->item('speed_up_search_queries')) {
            $query = "
            select *
            from (
                    (select " . $this->db->dbprefix('items') . ".*, " . $this->db->dbprefix('warehouse_items') . ".warehouse_id
                     , " . $this->db->dbprefix('items') . ".deleted
                     from " . $this->db->dbprefix('items') . "
                     join " . $this->db->dbprefix('warehouse_items') . " ON" . $this->db->dbprefix('items') . ".item_id = " . $this->db->dbprefix('warehouse_items') . ".item_id
                     where name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                     order by `" . $column . "` " . $orderby . ") union

                    (select " . $this->db->dbprefix('items') . ".*, " . $this->db->dbprefix('warehouse_items') . ".warehouse_id
                     , " . $this->db->dbprefix('items') . ".deleted
                     from " . $this->db->dbprefix('items') . "
                     join " . $this->db->dbprefix('warehouse_items') . " ON" . $this->db->dbprefix('items') . ".item_id = " . $this->db->dbprefix('warehouse_items') . ".item_id
                     where item_number like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                     order by `" . $column . "` " . $orderby . ") union

                     (select " . $this->db->dbprefix('items') . ".*, " . $this->db->dbprefix('warehouse_items') . ".warehouse_id
                     , " . $this->db->dbprefix('items') . ".deleted
                     from " . $this->db->dbprefix('items') . "
                     join " . $this->db->dbprefix('warehouse_items') . " ON" . $this->db->dbprefix('items') . ".item_id = " . $this->db->dbprefix('warehouse_items') . ".item_id
                     where category like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                     order by `" . $column . "` " . $orderby . ") union

            ) as search_results
            order by `" . $column . "` " . $orderby . "` limit " . $offset . ',' . $limit;
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

            if ($stores) {
                $this->db->select('items.*,sum(lifetek_warehouse_items.quantity) quantity');
                $this->db->from('items');
                $this->db->join('warehouse_items', 'items.item_id = warehouse_items.item_id', 'left');
                $this->db->group_by('items.item_id');
                $this->db->where("((" .
                        $sql_search_name_criteria . ") or
                item_number LIKE '%" . $this->db->escape_like_str($search) . "%' or
                category LIKE '%" . $this->db->escape_like_str($search) . "%' or
                warehouse_id LIKE '%" . $this->db->escape_like_str($search) . "%' or
                location LIKE '%" . $this->db->escape_like_str($search) . "%') $cat_id $id and deleted=0");
                $this->db->order_by($column, $orderby);
                $this->db->limit($limit);
                $this->db->offset($offset);
                return $this->db->get();
            } else {
                $this->db->select('items.*');
                $this->db->from('items');
                $this->db->group_by('items.item_id');
                $this->db->where("((" .
                        $sql_search_name_criteria . ") or
                item_number LIKE '%" . $this->db->escape_like_str($search) . "%' or
                category LIKE '%" . $this->db->escape_like_str($search) . "%' or
                location LIKE '%" . $this->db->escape_like_str($search) . "%') $cat_id and deleted=0");
                $this->db->order_by($column, $orderby);
                $this->db->limit($limit);
                $this->db->offset($offset);
                return $this->db->get();
            }
        }
    }

    function search_count_all($search, $stores = '', $cat = '') {//,$stores=''
        if ($cat)
            $cat_id = "and category = $cat ";
        else
            $cat_id = '';
        if ($stores)
            $id = "and warehouse_id=$stores";
        else
            $id = '';
        if ($this->config->item('speed_up_search_queries')) {
            $query = "
            select *
            from (
                     (select " . $this->db->dbprefix('items') . ".*, " . $this->db->dbprefix('warehouse_items') . ".warehouse_id
                     , " . $this->db->dbprefix('items') . ".deleted
                     from " . $this->db->dbprefix('items') . "
                     join " . $this->db->dbprefix('warehouse_items') . " ON" . $this->db->dbprefix('items') . ".item_id = " . $this->db->dbprefix('warehouse_items') . ".item_id
                     where name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                     order by `" . $column . "` " . $orderby . ") union

                     (select " . $this->db->dbprefix('items') . ".*, " . $this->db->dbprefix('warehouse_items') . ".warehouse_id
                     , " . $this->db->dbprefix('items') . ".deleted
                     from " . $this->db->dbprefix('items') . "
                     join " . $this->db->dbprefix('warehouse_items') . " ON" . $this->db->dbprefix('items') . ".item_id = " . $this->db->dbprefix('warehouse_items') . ".item_id
                     where item_number like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                     order by `" . $column . "` " . $orderby . ") union

                     (select " . $this->db->dbprefix('items') . ".*, " . $this->db->dbprefix('warehouse_items') . ".warehouse_id
                     , " . $this->db->dbprefix('items') . ".deleted
                     from " . $this->db->dbprefix('items') . "
                     join " . $this->db->dbprefix('warehouse_items') . " ON" . $this->db->dbprefix('items') . ".item_id = " . $this->db->dbprefix('warehouse_items') . ".item_id
                     where category like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                     order by `" . $column . "` " . $orderby . ") union

            ) as search_results
            order by `name`";
            $result = $this->db->query($query);
            return $result->num_rows();
        } else {
            if ($stores) {
                $this->db->select('items.*,sum(lifetek_warehouse_items.quantity) quantity');
                $this->db->from('items');
                $this->db->join('warehouse_items', 'items.item_id = warehouse_items.item_id', 'left');
                $this->db->group_by('items.item_id');
                $this->db->where("(name LIKE '%" . $this->db->escape_like_str($search) . "%' or
                item_number LIKE '%" . $this->db->escape_like_str($search) . "%' or
                category LIKE '%" . $this->db->escape_like_str($search) . "%' or
                warehouse_id LIKE '%" . $this->db->escape_like_str($search) . "%' or
                location LIKE '%" . $this->db->escape_like_str($search) . "%') $cat_id $id and deleted=0");
                $this->db->order_by("name", "asc");
                $result = $this->db->get();
                return $result->num_rows();
            } else {
                $this->db->select('items.*');
                $this->db->from('items');
                $this->db->group_by('items.item_id');
                $this->db->where("(name LIKE '%" . $this->db->escape_like_str($search) . "%' or
                item_number LIKE '%" . $this->db->escape_like_str($search) . "%' or
                category LIKE '%" . $this->db->escape_like_str($search) . "%' or
                location LIKE '%" . $this->db->escape_like_str($search) . "%') $cat_id and deleted=0");
                $this->db->order_by("name", "asc");
                $result = $this->db->get();
                return $result->num_rows();
            }
        }
    }

    /* end edit by: huyenlt^^ */

    function get_categories() {
        $this->db->select('category');
        $this->db->from('items');
        $this->db->where('deleted', 0);
        $this->db->distinct();
        $this->db->order_by("category", "asc");

        return $this->db->get();
    }

    function cleanup() {
        $item_data = array('item_number' => null);
        $this->db->where('deleted', 1);
        return $this->db->update('items', $item_data);
    }

    function get_item_category($id_cat, $start_date, $end_date) {
        $this->db->select('trans_items');
        $this->db->distinct('trans_items');
        $this->db->join('items', 'items.item_id=inventory.trans_items', 'inner');
        $this->db->where('items.deleted', 0);
        $this->db->where('trans_catid', $id_cat);
        $this->db->where('trans_date >= ', $start_date);
        $this->db->where('trans_date <= ', $end_date);
        $query = $this->db->get('inventory');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function get_item_category_start_number($id_item, $start_date) {
        $this->db->select_sum('trans_inventory');
        $this->db->where('trans_items', $id_item);
        $this->db->where('trans_date < ', $start_date);
        $query = $this->db->get('inventory');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else
            return null;
    }

    function get_item_category_start_money($id_item, $start_date) {
        $this->db->where('trans_items', $id_item);
        $this->db->where('trans_date < ', $start_date);
        $query = $this->db->get('inventory');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function get_item_category_end_number($id_item, $end_date) {
        $this->db->select_sum('trans_inventory');
        $this->db->where('trans_items', $id_item);
        $this->db->where('trans_date > ', $end_date);
        $query = $this->db->get('inventory');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else
            return null;
    }

    function get_item_category_end_money($id_item, $end_date) {
        $this->db->where('trans_items', $id_item);
        $this->db->where('trans_date > ', $end_date);
        $query = $this->db->get('inventory');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function get_item_category_between_number_nhap($id_item, $start_date, $end_date) {
        $this->db->select_sum('trans_inventory');
        $this->db->where('trans_items', $id_item);
        $this->db->where('trans_inventory >=', 0);
        $this->db->where('trans_date >= ', $start_date);
        $this->db->where('trans_date <= ', $end_date);
        $query = $this->db->get('inventory');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else
            return null;
    }

    function get_item_category_between_number_xuat($id_item, $start_date, $end_date) {
        $this->db->select_sum('trans_inventory');
        $this->db->where('trans_items', $id_item);
        $this->db->where('trans_inventory <', 0);
        $this->db->where('trans_date >= ', $start_date);
        $this->db->where('trans_date <= ', $end_date);
        $query = $this->db->get('inventory');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else
            return null;
    }

    function get_item_category_between_money_nhap($id_item, $start_date, $end_date) {
        $this->db->where('trans_items', $id_item);
        $this->db->where('trans_inventory >=', 0);
        $this->db->where('trans_date >= ', $start_date);
        $this->db->where('trans_date <= ', $end_date);
        $query = $this->db->get('inventory');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function get_item_category_between_money_xuat($id_item, $start_date, $end_date) {
        $this->db->where('trans_items', $id_item);
        $this->db->where('trans_inventory <', 0);
        $this->db->where('trans_date >= ', $start_date);
        $this->db->where('trans_date <= ', $end_date);
        $query = $this->db->get('inventory');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function get_price_sale_item($sale_id) {
        $this->db->select('(item_unit_price * quantity_purchased) as tienno');
        $this->db->where('sale_id', $sale_id);
        $query = $this->db->get('sales_items');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function item_info($id_cat) {
        $this->db->where('category', $id_cat);
        $this->db->where('deleted', 0);
        $query = $this->db->get('items');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function update_quantity_price($data) {
        $this->db->select('quantity');
        $this->db->update('items', $data);
    }

//huyenlt^^
    function get_info_warehouse_items($item_id, $warehouse_id) {
        $this->db->from('warehouse_items');
        $this->db->where('item_id', $item_id);
        $this->db->where('warehouse_id', $warehouse_id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //Get empty base parent object, as $item_id is NOT an item
            $item_obj = new stdClass();
            //Get all the fields from items table
            $fields = $this->db->list_fields('warehouse_items');
            foreach ($fields as $field) {
                $item_obj->$field = '';
            }
            return $item_obj;
        }
    }

    function get_Stores_Items($item_id, $warehouse_id) {
        $this->db->from('warehouse_items');
        $this->db->where('item_id', $item_id);
        $this->db->where('warehouse_id', $warehouse_id);
        $query = $this->db->get();
        return $query->row();
    }

    function saveStoresItems1221(&$store_item_data, $id = false) {
        if (!$id) {
            if ($this->db->insert('warehouse_items', $store_item_data)) {
                $store_item_data['id'] = $this->db->insert_id();
                return true;
            }
            return false;
        }
        $this->db->where('id', $id);
        return $this->db->update('warehouse_items', $store_item_data);
    }

    //end huyenlt^^
//huyenlt^^

    function get_item_search_suggestions_sales($search, $limit = 25) {
        $suggestions = array();
        $this->db->from('items');
        $this->db->where('deleted', 0);
        $this->db->like('name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->or_like('item_number', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("name", "asc");
        $by_name = $this->db->get($query);
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('value' => $row->item_id,
                'label' => $row->item_number . ' - ' . $row->name,
                'unit_price' => $row->unit_price,
                'quantity' => $row->quantity
            );
        }
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    //bc kiểm kho
    public function verifying_resport($store, $start_date, $end_date) {
        $this->db->select('items.*,items_verifying.*');
        $this->db->where('deleted', 0);
        $this->db->from('items');

        $this->db->join('items_verifying', 'items_verifying.item_id = items.item_id', 'left');
        $this->db->where('warehouse_id', $store);
        $this->db->where('items_verifying.date >=', $start_date);
        $this->db->where('items_verifying.date <=', $end_date);
        $this->db->order_by('items_verifying.date', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function verifying_resport_all($start_date, $end_date) {
        $this->db->select('items.*,items_verifying.*');
        $this->db->where('deleted', 0);
        $this->db->from('items');

        $this->db->join('items_verifying', 'items_verifying.item_id = items.item_id', 'left');
        $this->db->where('items_verifying.date >=', $start_date);
        $this->db->where('items_verifying.date <=', $end_date);
        $this->db->order_by('items_verifying.date', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    //end bc kiểm kho
    function get_transfer_warehouse_new($start_date, $end_date) {
        $this->db->select('items.*,transfer_stores.quantity as total,transfer_stores.*');
        $this->db->where('deleted', 0);
        $this->db->from('transfer_stores');
        $this->db->join('items', 'items.item_id = transfer_stores.item_id', 'left');
        $this->db->where('transfer_stores.date >=', $start_date);
        $this->db->where('transfer_stores.date <=', $end_date);
        $this->db->order_by('date', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    //Create by San
    function get_item_search_store_material_suggestions($search, $store, $limit = 25) {//search store
        $suggestions = array();
        if ($search) {
            $this->db->select('items.item_number,items.item_id,items.name,items.cost_price,items.unit_price,warehouse_items.quantity, items.quantity_first, items.unit_from, items.unit');
            $this->db->from('items');
            $this->db->join('warehouse_items', "warehouse_items.item_id = items.item_id");
            $this->db->where('items.deleted', 0);
            $this->db->where('warehouse_items.warehouse_id', $store);
            $this->db->like('items.name', $search);
            $this->db->order_by("items.name", "asc");
            $by_name = $this->db->get();
            foreach ($by_name->result() as $row) {
                $unit = ($row->quantity_first == 1) ? $row->unit_from : $row->unit;
                $unit_info = $this->Unit->get_info($unit);
                $suggestions[] = array(
                    'name' => $row->name,
                    'value' => $row->item_id,
                    'label' => $row->item_number . " - " . $row->name,
                    'cost_price' => number_format($row->cost_price),
                    'unit_price' => number_format($row->unit_price),
                    'quantity' => $row->quantity,
                    'unit' => $unit,
                    'unit_name' => $unit_info->name,
                    'item_number' => $row->item_number
                );
            }

            $this->db->select('items.item_number,items.item_id,items.name,items.cost_price,items.unit_price,warehouse_items.quantity, items.quantity_first, items.unit_from, items.unit');
            $this->db->from('items');
            $this->db->join('warehouse_items', "warehouse_items.item_id = items.item_id");
            $this->db->where('items.deleted', 0);
            $this->db->where('warehouse_items.warehouse_id', $store);
            $this->db->like('items.item_number', $search);
            $this->db->order_by("items.item_number", "asc");
            $by_name = $this->db->get();
            foreach ($by_name->result() as $row) {
                $unit = ($row->quantity_first == 1) ? $row->unit_from : $row->unit;
                $unit_info = $this->Unit->get_info($unit);
                $suggestions[] = array(
                    'name' => $row->name,
                    'value' => $row->item_id,
                    'label' => $row->item_number . " - " . $row->name,
                    'cost_price' => number_format($row->cost_price),
                    'unit_price' => number_format($row->unit_price),
                    'quantity' => $row->quantity,
                    'unit' => $unit,
                    'unit_name' => $unit_info->name,
                    'item_number' => $row->item_number
                );
            }
        } else {
            $this->db->select('items.item_number,items.item_id,items.name,items.cost_price,items.unit_price,warehouse_items.quantity, items.quantity_first, items.unit_from, items.unit');
            $this->db->from('items');
            $this->db->join('warehouse_items', "warehouse_items.item_id = items.item_id");
            $this->db->where('items.deleted', 0);
            $this->db->where('warehouse_items.warehouse_id', $store);
            $this->db->like('items.item_number', $search);
            $this->db->order_by("items.item_number", "asc");
            $by_name = $this->db->get();
            foreach ($by_name->result() as $row) {
                $unit = ($row->quantity_first == 1) ? $row->unit_from : $row->unit;
                $unit_info = $this->Unit->get_info($unit);
                $suggestions[] = array(
                    'name' => $row->name,
                    'value' => $row->item_id,
                    'label' => $row->item_number . " - " . $row->name,
                    'cost_price' => number_format($row->cost_price),
                    'unit_price' => number_format($row->unit_price),
                    'quantity' => $row->quantity,
                    'unit' => $unit,
                    'unit_name' => $unit_info->name,
                    'item_number' => $row->item_number
                );
            }
        }
        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    function get_info_in_store_material($item_id, $store) {
        $this->db->select('i.item_id, i.name, i.item_number, i.unit_price, i.unit_price_rate, i.cost_price, i.cost_price_rate, wi.quantity, i.quantity_first');
        $this->db->from('items i');
        $this->db->join('warehouse_items wi', "wi.item_id = i.item_id");
        $this->db->where('i.deleted', 0);
        $this->db->where('wi.warehouse_id', $store);
        $this->db->where('i.item_id', $item_id);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //Get empty base parent object, as $item_id is NOT an item
            $item_obj = new stdClass();

            //Get all the fields from items table
            $fields = $this->db->list_fields('items');

            foreach ($fields as $field) {
                $item_obj->$field = '';
            }

            return $item_obj;
        }
    }

    //Cap nhat lai thong tin item trong bang warehouse_item theo ma kho
    function update_warehouse_item_by_warehouse_id($data, $id, $store) {
        $this->db->where("warehouse_id", $store);
        $this->db->where("item_id", $id);
        $this->db->update("warehouse_items", $data);
    }

    //Them moi thong tin thanh pham vao kho thanh pham
    function save_item_production($data, $id, $store) {
        $this->db->insert("warehouse_item", $data);
    }

    //Kiem tra su ton tai ma thanh pham trng kho thanh pham
    function check_exist_item($id, $store) {
        $this->db->where("warehouse_id", $store);
        $this->db->where("item_id", $id);
        $query = $this->db->get("warehouse_items");
        if ($query->num_row() > 0) {
            return true;
        } else {
            return false;
        }
    }

    //Kiem tra su ton tai cua item theo item_number
    function get_info_item_by_item_number($item_number) {
        $this->db->where("item_number", $item_number);
        $query = $this->db->get("items");
        return $query->row_array();
    }

    //Them moi bang item de lay ma item_id tu sinh
    function save_item_get_item_id($data) {
        $this->db->insert("items", $data);
        return $this->db->insert_id();
    }

    //Lay tat ca item
    function get_all_items($limit = 10000, $offset = 0, $col = 'item_id', $order = 'desc') {
        $this->db->select('item_id,category,images,item_number,name,unit_price,quantity_total as quantity_warehouse, quantity, quantity_total,service, quantity_first, unit_price_rate, unit, product_view_home');
        $this->db->from('items');
        $this->db->where('deleted', 0);
        $this->db->where('service', 0);
        $this->db->order_by($col, $order);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function get_item_search_suggestions_receiving($search, $limit = 25) {
        $suggestions = array();
        if ($search) {
            $this->db->from('items');
            $this->db->where('deleted', 0);
            //$this->db->where('service', 0);
            $this->db->like('name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
            $this->db->order_by("name", "asc");
            $by_name = $this->db->get();
            foreach ($by_name->result() as $row) {
                $suggestions[] = array(
                    'value' => $row->item_id,
                    'label' => $row->item_number . ' - ' . $row->name,
                    'unit_price' => number_format($row->unit_price),
                    'quantity' => $row->quantity
                );
            }

            $this->db->from('items');
            $this->db->where('deleted', 0);
//            $this->db->where('service', 0);
            $this->db->like('item_number', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
            $this->db->order_by("item_number", "asc");
            $by_name = $this->db->get();
            foreach ($by_name->result() as $row) {
                $suggestions[] = array(
                    'value' => $row->item_id,
                    'label' => $row->item_number . ' - ' . $row->name,
                    'unit_price' => number_format($row->unit_price),
                    'quantity' => $row->quantity
                );
            }
        } else {
            $this->db->from('items');
            $this->db->where('deleted', 0);
            //$this->db->where('service', 0);
            $this->db->like('name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
            $this->db->order_by("name", "asc");
            $by_name = $this->db->get();
            foreach ($by_name->result() as $row) {
                $suggestions[] = array(
                    'value' => $row->item_id,
                    'label' => $row->item_number . ' - ' . $row->name,
                    'unit_price' => number_format($row->unit_price),
                    'quantity' => $row->quantity
                );
            }
        }
        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    function check_exist($item_id) {
        $this->db->from('items');
        $this->db->where('item_id', $item_id);
        $this->db->where('service', 0);
        $query = $this->db->get();
        return ($query->num_rows() == 1);
    }

    function get_item_by_store_and_cat($store, $cat) {
        if ($store) {
            $this->db->select("warehouse_items.item_id item_id, item_number, items.name name, description, category, unit, warehouse_items.quantity quantity_store, cost_price, unit_price, unit_from, unit_rate, reorder_level, quantity_first, taxes");
            $this->db->from("warehouse_items");
            $this->db->join("items", "warehouse_items.item_id = items.item_id", "inner");
            if ($cat) {
                $this->db->join("categories_item", "items.category = categories_item.id_cat", "inner");
                $this->db->where("categories_item.deleted", 0);
                $this->db->where("items.category", $cat);
            }
            $this->db->where("warehouse_id", $store);
            $this->db->where("items.deleted", 0);
            $this->db->where("items.service", 0);
            $this->db->order_by("warehouse_items.item_id");
            $query = $this->db->get();
        } else {
            $this->db->select("item_id, item_number, items.name name, description, category, unit, quantity_total as quantity_store, cost_price, unit_price, unit_from, unit_rate, reorder_level, quantity_first, taxes");
            $this->db->from("items");
            if ($cat) {
                $this->db->join("categories_item", "items.category = categories_item.id_cat", "inner");
                $this->db->where("items.category", $cat);
                $this->db->where("categories_item.deleted", 0);
            }
            $this->db->where("items.deleted", 0);
            $this->db->where("items.service", 0);
            $this->db->order_by("items.item_id");
            $query = $this->db->get();
        }
        return $query->result_array();
    }

    function get_item_search_export_store_by_store_cate($search, $store, $cate) {
        $suggestions = array();
        if ($store == 0) {
            $this->db->from('items');
            $this->db->where('deleted', 0);
            $this->db->where('service', 0);
            if ($cate) {
                $this->db->where('category', $cate);
            }
            $this->db->like('name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
            $this->db->order_by("name", "asc");
            $by_name = $this->db->get();
            foreach ($by_name->result() as $row) {
                $unit = $row->quantity_first == 0 ? $row->unit : $row->unit_from;
                $this->db->where("id_unit", $unit);
                $query = $this->db->get("units");
                $suggestions[] = array(
                    'value' => $row->name,
                    'label' => $row->name,
                    'cost_price_export' => number_format($row->quantity_first == 1 ? $row->cost_price_rate : $row->cost_price),
                    'cost_price_export2' => $row->quantity_first == 1 ? $row->cost_price_rate : $row->cost_price,
                    'item_number' => $row->item_number != null ? $row->item_number : '',
                    'id' => $row->item_id,
                    'unit' => $query->row()->name,
                    'quantity' => format_quantity($row->quantity_total),
                );
            }
        } else {
            $this->db->select("items.*, warehouse_items.quantity as quantity2");
            $this->db->from('items');
            $this->db->join('warehouse_items', "warehouse_items.item_id = items.item_id");
            $this->db->where('deleted', 0);
            $this->db->where('service', 0);
            $this->db->where('warehouse_items.warehouse_id', $store);
            if ($cate) {
                $this->db->where("category", $cate);
            }
            $this->db->like('items.name', $search);
            $this->db->order_by("items.name", "asc");
            $by_name = $this->db->get();

            foreach ($by_name->result() as $row) {
                $unit = $row->quantity_first == 0 ? $row->unit : $row->unit_from;
                $this->db->where("id_unit", $unit);
                $query = $this->db->get("units");

                $suggestions[] = array(
                    'value' => $row->name,
                    'label' => $row->name,
                    'cost_price_export' => number_format($row->quantity_first == 1 ? $row->cost_price_rate : $row->cost_price),
                    'cost_price_export2' => $row->quantity_first == 1 ? $row->cost_price_rate : $row->cost_price,
                    'item_number' => $row->item_number != null ? $row->item_number : '',
                    'id' => $row->item_id,
                    'unit' => $query->row()->name,
                    'quantity' => format_quantity($row->quantity2),
                );
            }
        }
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    //End San
    //hung audi 22-4-15
    function get_by_cat_parent($cat) {
        //$this->db->where();
        $sql = "SELECT * FROM lifetek_categories_item where parentid = $cat";
        $data = $this->db->query($sql);
        if ($data->num_rows() > 0) {
            $items = array();
            foreach ($data->result() as $values) {
                $items[] = $values->id_cat;
            }
            return $cat_child = implode($items, ',');
        } else {
            return $cat;
        }
    }

    //Tim kiem moi
    function search_items($search, $stores = '', $cat = '', $limit = 20, $offset = 0, $column = 'item_id', $orderby = 'desc') {
        if ($cat) {
            //hung audi 23-4-15
            //1
            $cat_child = $this->Item->get_by_cat_parent($cat);

            //2
            $cat_child2 = explode(',', $cat_child);
            foreach ($cat_child2 as $cat_child2a) {
                $cat_child2q[] = $this->Item->get_by_cat_parent($cat_child2a);
            }
            $cat_child2h = implode($cat_child2q, ',');

            //3
            $cat_child3 = explode(',', $cat_child2h);
            foreach ($cat_child3 as $cat_child3a) {
                $cat_child3q[] = $this->Item->get_by_cat_parent($cat_child3a);
            }
            $cat_child3h = implode($cat_child3q, ',');

            //4
            $cat_child4 = explode(',', $cat_child3h);
            foreach ($cat_child4 as $cat_child4a) {
                $cat_child4q[] = $this->Item->get_by_cat_parent($cat_child4a);
            }
            $cat_child4h = implode($cat_child4q, ',');

            //5
            $cat_child5 = explode(',', $cat_child);
            foreach ($cat_child5 as $cat_child5a) {
                $cat_child5q[] = $this->Item->get_by_cat_parent($cat_child5a);
            }
            $cat_child5h = implode($cat_child5q, ',');

            //6
            $cat_child6 = explode(',', $cat_child);
            foreach ($cat_child6 as $cat_child6a) {
                $cat_child6q[] = $this->Item->get_by_cat_parent($cat_child6a);
            }
            $cat_child6h = implode($cat_child6q, ',');

            //7
            $cat_child7 = explode(',', $cat_child);
            foreach ($cat_child7 as $cat_child7a) {
                $cat_child7q[] = $this->Item->get_by_cat_parent($cat_child7a);
            }
            $cat_child7h = implode($cat_child7q, ',');

            //8
            $cat_child8 = explode(',', $cat_child);
            foreach ($cat_child8 as $cat_child8a) {
                $cat_child8q[] = $this->Item->get_by_cat_parent($cat_child8a);
            }
            $cat_child8h = implode($cat_child8q, ',');

            //9
            $cat_child9 = explode(',', $cat_child);
            foreach ($cat_child9 as $cat_child9a) {
                $cat_child9q[] = $this->Item->get_by_cat_parent($cat_child9a);
            }
            $cat_child9h = implode($cat_child9q, ',');


            $cat_id = "and category in ( $cat, $cat_child, $cat_child2h, $cat_child3h, $cat_child4h,
                                        $cat_child5h, $cat_child6h, $cat_child7h, $cat_child8h, $cat_child9h)";
        } else {
            $cat_id = '';
        }
        if ($stores) {
            if ($stores != 0) {
                $id = "and warehouse_id=$stores";
            } else {
                $id = '';
            }
        } else {
            $id = '';
        }
        if ($this->config->item('speed_up_search_queries')) {
            $query = "
            select *
            from (
                    (select " . $this->db->dbprefix('items') . ".*, " . $this->db->dbprefix('warehouse_items') . ".warehouse_id
                     , " . $this->db->dbprefix('items') . ".deleted
                     from " . $this->db->dbprefix('items') . "
                     join " . $this->db->dbprefix('warehouse_items') . " ON" . $this->db->dbprefix('items') . ".item_id = " . $this->db->dbprefix('warehouse_items') . ".item_id
                     where name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                     order by `" . $column . "` " . $orderby . ") union

                    (select " . $this->db->dbprefix('items') . ".*, " . $this->db->dbprefix('warehouse_items') . ".warehouse_id
                     , " . $this->db->dbprefix('items') . ".deleted
                     from " . $this->db->dbprefix('items') . "
                     join " . $this->db->dbprefix('warehouse_items') . " ON" . $this->db->dbprefix('items') . ".item_id = " . $this->db->dbprefix('warehouse_items') . ".item_id
                     where item_number like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                     order by `" . $column . "` " . $orderby . ") union

                     (select " . $this->db->dbprefix('items') . ".*, " . $this->db->dbprefix('warehouse_items') . ".warehouse_id
                     , " . $this->db->dbprefix('items') . ".deleted
                     from " . $this->db->dbprefix('items') . "
                     join " . $this->db->dbprefix('warehouse_items') . " ON" . $this->db->dbprefix('items') . ".item_id = " . $this->db->dbprefix('warehouse_items') . ".item_id
                     where category like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                     order by `" . $column . "` " . $orderby . ") union

            ) as search_results
            order by `" . $column . "` " . $orderby . "` limit " . $offset . ',' . $limit;
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

            if ($stores) {
                if ($stores != 0) {
                    $this->db->select('items.*,sum(lifetek_warehouse_items.quantity) as quantity_warehouse');
                    $this->db->from('items');
                    $this->db->join('warehouse_items', 'items.item_id = warehouse_items.item_id', 'left');
                    $this->db->group_by('items.item_id');
                    $this->db->where("((" .
                            $sql_search_name_criteria . ") or
                                    item_number LIKE '%" . $this->db->escape_like_str($search) . "%' or
                                    category LIKE '%" . $this->db->escape_like_str($search) . "%' or
                                    warehouse_id LIKE '%" . $this->db->escape_like_str($search) . "%' or
                                    location LIKE '%" . $this->db->escape_like_str($search) . "%') $cat_id $id and deleted=0 and service=0");
                    $this->db->order_by($column, $orderby);
                    $this->db->limit($limit);
                    $this->db->offset($offset);
                    return $this->db->get();
                } else {
                    $this->db->select('item_id,category,images,item_number,name,unit_price,quantity_total as quantity_warehouse,product_view_home,quantity, quantity_total,deleted,servive, quantity_first, unit_price_rate, unit');
                    $this->db->from('items');
                    $this->db->group_by('items.item_id');
                    $this->db->where("((" .
                            $sql_search_name_criteria . ") or
                                    item_number LIKE '%" . $this->db->escape_like_str($search) . "%' or
                                    category LIKE '%" . $this->db->escape_like_str($search) . "%' or
                                    location LIKE '%" . $this->db->escape_like_str($search) . "%') $cat_id and deleted=0 and service=0");
                    $this->db->order_by($column, $orderby);
                    $this->db->limit($limit);
                    $this->db->offset($offset);
                    return $this->db->get();
                }
            } else {
                $this->db->select('item_id,category,images,item_number,name,unit_price,quantity_total as quantity_warehouse, quantity, product_view_home,quantity_total,deleted,service, quantity_first, unit_price_rate, unit');
                $this->db->from('items');
                $this->db->group_by('items.item_id');
                $this->db->where("((" .
                        $sql_search_name_criteria . ") or
                item_number LIKE '%" . $this->db->escape_like_str($search) . "%' or
                category LIKE '%" . $this->db->escape_like_str($search) . "%' or
                location LIKE '%" . $this->db->escape_like_str($search) . "%') $cat_id and deleted=0 and service=0");
                $this->db->order_by($column, $orderby);
                $this->db->limit($limit);
                $this->db->offset($offset);
                return $this->db->get();
            }
        }
    }

    function search_count_all_items($search, $stores = '', $cat = '') {//,$stores=''
        if ($cat) {
            //hung audi 23-4-15
            //1
            $cat_child = $this->Item->get_by_cat_parent($cat);

            //2
            $cat_child2 = explode(',', $cat_child);
            foreach ($cat_child2 as $cat_child2a) {
                $cat_child2q[] = $this->Item->get_by_cat_parent($cat_child2a);
            }
            $cat_child2h = implode($cat_child2q, ',');

            //3
            $cat_child3 = explode(',', $cat_child2h);
            foreach ($cat_child3 as $cat_child3a) {
                $cat_child3q[] = $this->Item->get_by_cat_parent($cat_child3a);
            }
            $cat_child3h = implode($cat_child3q, ',');

            //4
            $cat_child4 = explode(',', $cat_child3h);
            foreach ($cat_child4 as $cat_child4a) {
                $cat_child4q[] = $this->Item->get_by_cat_parent($cat_child4a);
            }
            $cat_child4h = implode($cat_child4q, ',');

            //5
            $cat_child5 = explode(',', $cat_child);
            foreach ($cat_child5 as $cat_child5a) {
                $cat_child5q[] = $this->Item->get_by_cat_parent($cat_child5a);
            }
            $cat_child5h = implode($cat_child5q, ',');

            //6
            $cat_child6 = explode(',', $cat_child);
            foreach ($cat_child6 as $cat_child6a) {
                $cat_child6q[] = $this->Item->get_by_cat_parent($cat_child6a);
            }
            $cat_child6h = implode($cat_child6q, ',');

            //7
            $cat_child7 = explode(',', $cat_child);
            foreach ($cat_child7 as $cat_child7a) {
                $cat_child7q[] = $this->Item->get_by_cat_parent($cat_child7a);
            }
            $cat_child7h = implode($cat_child7q, ',');

            //8
            $cat_child8 = explode(',', $cat_child);
            foreach ($cat_child8 as $cat_child8a) {
                $cat_child8q[] = $this->Item->get_by_cat_parent($cat_child8a);
            }
            $cat_child8h = implode($cat_child8q, ',');

            //9
            $cat_child9 = explode(',', $cat_child);
            foreach ($cat_child9 as $cat_child9a) {
                $cat_child9q[] = $this->Item->get_by_cat_parent($cat_child9a);
            }
            $cat_child9h = implode($cat_child9q, ',');


            $cat_id = "and category in ( $cat, $cat_child, $cat_child2h, $cat_child3h, $cat_child4h,
                                        $cat_child5h, $cat_child6h, $cat_child7h, $cat_child8h, $cat_child9h)";
        } else
            $cat_id = '';
        if ($stores) {
            if ($stores != 0) {
                $id = "and warehouse_id=$stores";
            } else {
                $id = '';
            }
        } else {
            $id = '';
        }
        if ($this->config->item('speed_up_search_queries')) {
            $query = "
            select *
            from (
                     (select " . $this->db->dbprefix('items') . ".*, " . $this->db->dbprefix('warehouse_items') . ".warehouse_id
                     , " . $this->db->dbprefix('items') . ".deleted
                     from " . $this->db->dbprefix('items') . "
                     join " . $this->db->dbprefix('warehouse_items') . " ON" . $this->db->dbprefix('items') . ".item_id = " . $this->db->dbprefix('warehouse_items') . ".item_id
                     where name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                     order by `" . $column . "` " . $orderby . ") union

                     (select " . $this->db->dbprefix('items') . ".*, " . $this->db->dbprefix('warehouse_items') . ".warehouse_id
                     , " . $this->db->dbprefix('items') . ".deleted
                     from " . $this->db->dbprefix('items') . "
                     join " . $this->db->dbprefix('warehouse_items') . " ON" . $this->db->dbprefix('items') . ".item_id = " . $this->db->dbprefix('warehouse_items') . ".item_id
                     where item_number like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                     order by `" . $column . "` " . $orderby . ") union

                     (select " . $this->db->dbprefix('items') . ".*, " . $this->db->dbprefix('warehouse_items') . ".warehouse_id
                     , " . $this->db->dbprefix('items') . ".deleted
                     from " . $this->db->dbprefix('items') . "
                     join " . $this->db->dbprefix('warehouse_items') . " ON" . $this->db->dbprefix('items') . ".item_id = " . $this->db->dbprefix('warehouse_items') . ".item_id
                     where category like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                     order by `" . $column . "` " . $orderby . ") union

            ) as search_results
            order by `name`";
            $result = $this->db->query($query);
            return $result->num_rows();
        } else {
            if ($stores) {
                if ($stores != 0) {
                    $this->db->select('items.*,sum(lifetek_warehouse_items.quantity) as quantity_warehouse');
                    $this->db->from('items');
                    $this->db->join('warehouse_items', 'items.item_id = warehouse_items.item_id', 'left');
                    $this->db->group_by('items.item_id');
                    $this->db->where("(name LIKE '%" . $this->db->escape_like_str($search) . "%' or
                                    item_number LIKE '%" . $this->db->escape_like_str($search) . "%' or
                                    category LIKE '%" . $this->db->escape_like_str($search) . "%' or
                                    warehouse_id LIKE '%" . $this->db->escape_like_str($search) . "%' or
                                    location LIKE '%" . $this->db->escape_like_str($search) . "%') $cat_id $id and deleted=0 and service=0");
                    $result = $this->db->get();
                    return $result->num_rows();
                } else {
                    $this->db->select('deleted,item_id,category,images,item_number,name,unit_price,quantity_total as quantity_warehouse, quantity, quantity_total,service');
                    $this->db->from('items');
                    $this->db->group_by('items.item_id');
                    $this->db->where("(name LIKE '%" . $this->db->escape_like_str($search) . "%' or
                                    item_number LIKE '%" . $this->db->escape_like_str($search) . "%' or
                                    category LIKE '%" . $this->db->escape_like_str($search) . "%' or
                                    location LIKE '%" . $this->db->escape_like_str($search) . "%') $cat_id and deleted=0 and service=0");
                    $result = $this->db->get();
                    return $result->num_rows();
                }
            } else {
                $this->db->select('deleted,item_id,category,images,item_number,name,unit_price,quantity_total as quantity_warehouse, quantity, quantity_total,service');
                $this->db->from('items');
                $this->db->group_by('items.item_id');
                $this->db->where("(name LIKE '%" . $this->db->escape_like_str($search) . "%' or
                item_number LIKE '%" . $this->db->escape_like_str($search) . "%' or
                category LIKE '%" . $this->db->escape_like_str($search) . "%' or
                location LIKE '%" . $this->db->escape_like_str($search) . "%') $cat_id and deleted=0 and service=0");
                $result = $this->db->get();
                return $result->num_rows();
            }
        }
    }

    //Lay danh sach item trong bang warehouse_items theo id
    function get_list_items_in_warehouse_items($item_id) {
        $this->db->where("item_id", $item_id);
        $this->db->where("warehouse_id !=", 0);
        $query = $this->db->get("warehouse_items");
        return $query->result_array();
    }

    //Lay thong tin item trong bang items theo id
    function get_info_item($item_id) {
        $this->db->select('item_id,category,images,item_number,name,unit_price,quantity_total as quantity_warehouse, quantity, quantity_total, quantity_first, unit_price_rate');
        $this->db->from('items');
        $this->db->where('item_id', $item_id);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //Get empty base parent object, as $item_id is NOT an item
            $item_obj = new stdClass();
            //Get all the fields from items table
            $fields = $this->db->list_fields('items');
            foreach ($fields as $field) {
                $item_obj->$field = '';
            }
            return $item_obj;
        }
    }

//hung audi 31-3-15
    function get_item_type_warehouse() {
        $this->db->from('items i');
        $this->db->join('warehouse_items wi', 'i.item_id = wi.item_id');
        $this->db->join('create_invetory ci', 'wi.warehouse_id = ci.id');

        $this->db->where('i.deleted', 0);
        $this->db->where('ci.type_warehouse', 1);
        $item_ids = $this->db->get()->result();

        foreach ($item_ids as $item_id) {
            $item[] = $item_id->item_id;
        }
        $item2 = implode($item, ',');

        return $item2;
    }

    function get_item_search_suggestions2($search, $limit = 25) {
        $suggestions = array();
        $item_id = $this->get_item_type_warehouse();
        if ($item_id) {
            $this->db->from('items i');
            $this->db->join('warehouse_items wi', 'i.item_id = wi.item_id');
            $this->db->join('create_invetory ci', 'wi.warehouse_id = ci.id');
            $this->db->where('i.deleted', 0);
            $this->db->where('i.service', 0);
            $this->db->where("i.item_id not IN ($item_id) ");
            $this->db->like('name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
            $this->db->order_by("name", "asc");
            $by_name2 = $this->db->get()->result();

            $this->db->from('items');
            $this->db->where('deleted', 0);
            $this->db->where('service', 0);
            $this->db->where("item_id NOT IN ($item_id) ");
            $this->db->like('name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
            $this->db->order_by("name", "asc");
            $by_name1 = $this->db->get()->result();

            $by_name = array_merge($by_name1, $by_name2);
            foreach ($by_name as $row) {
                $suggestions1[] = $row->item_id;
            }
            $suggestions2 = array_unique($suggestions1);
            foreach ($suggestions2 as $row2) {
                $suggestions[] = array(
                    'value' => $row2,
                    'label' => $this->get_item_id2($row2)->row()->name,
                );
            }
        } else {
            $this->db->from('items');
            $this->db->where('deleted', 0);
            $this->db->where('service', 0);
            $this->db->like('name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
            $this->db->order_by("name", "asc");
            $by_name = $this->db->get();
            foreach ($by_name->result() as $row) {
                $suggestions[] = array(
                    'value' => $row->item_id,
                    'label' => $row->item_number . ' - ' . $row->name,
                    'unit_price' => number_format($row->unit_price),
                    'quantity' => $row->quantity
                );
            }
            if (count($suggestions > $limit)) {
                $suggestions = array_slice($suggestions, 0, $limit);
            }
        }
        return $suggestions;
    }

    function get_item_id2($item_id) {
        $this->db->from('items');
        $this->db->where('item_id', $item_id);
        return $this->db->get();
    }

    function add_verifying(&$post_data) {
        if ($this->db->insert('items_verifying', $post_data)) {
            return true;
        } else {
            return false;
        }
    }

    //hung audi 13-4-15
    function get_item_category_between_money_nhap2($id_item, $start_date) {
        $this->db->where('trans_items', $id_item);
        $this->db->where('trans_inventory >=', 0);
        $this->db->where('trans_date < ', $start_date);
        $query = $this->db->get('inventory');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function get_item_category_between_money_xuat2($id_item, $start_date) {
        $this->db->where('trans_items', $id_item);
        $this->db->where('trans_inventory <', 0);
        $this->db->where('trans_date < ', $start_date);
        $query = $this->db->get('inventory');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function get_item_category2($id_cat, $start_date, $end_date) {
        if ($end_date >= date('Y-m-d')) {
            $this->db->select('trans_items');
            $this->db->distinct('trans_items');
            $this->db->join('items', 'items.item_id=inventory.trans_items', 'inner');
            $this->db->where('items.deleted', 0);
            $this->db->where('trans_catid', $id_cat);
            $query = $this->db->get('inventory')->result_array();
        } else {
            $this->db->select('trans_items');
            $this->db->distinct('trans_items');
            $this->db->join('items', 'items.item_id=inventory.trans_items', 'inner');
            $this->db->where('items.deleted', 0);
            $this->db->where('trans_catid', $id_cat);
            $this->db->where('trans_date >= ', $start_date);
            $this->db->where('trans_date <= ', $end_date);
            $query = $this->db->get('inventory')->result_array();
        }
        return $query;
    }

    //hung audi 24-4-15
    function update_item($item_data, $item_id) {
        $this->db->where('item_id', $item_id);
        return $this->db->update('items', $item_data);
    }

    function update_item_warehouse($item_data, $item_id, $warehouse_id) {
        $this->db->where('item_id', $item_id);
        $this->db->where('warehouse_id', $warehouse_id);
        return $this->db->update('warehouse_items', $item_data);
    }

    function get_info_warehouse($item_id, $warehouse_id) {
        $this->db->where('item_id', $item_id);
        $this->db->where('warehouse_id', $warehouse_id);
        return $this->db->get('warehouse_items')->row();
    }

    //    by Loi
    public function get_verifying($limit = 10000, $offset = 0, $col = 'id', $order = 'desc') {
        $this->db->select('iv.*, i.*');
        $this->db->from('items_verifying as iv');
        $this->db->join('items as i', 'iv.item_id = i.item_id', 'left');
        $this->db->order_by($col, $order);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    public function count_all_verifying() {
        $this->db->from('items_verifying');
        return $this->db->count_all_results();
    }

    public function count_all_verifying_by_date($start_date, $end_date) {
        $this->db->from('items_verifying');
        $this->db->where('date >=', $start_date);
        $this->db->where('date <=', $end_date);
        return $this->db->count_all_results();
    }

    public function get_verifying_by_date($start_date, $end_date, $limit = 10000, $offset = 0, $col = 'id', $order = 'desc') {
        $this->db->select('iv.*, i.*');
        $this->db->from('items_verifying as iv');
        $this->db->join('items as i', 'i.item_id = iv.item_id', 'left');
        $this->db->where('date >=', $start_date);
        $this->db->where('date <=', $end_date);
        $this->db->order_by($col, $order);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function get_all_item_in_store($store_id) {
        if ($store_id == 0) {
            $this->db->select("item_id, item_number, category, name, unit, unit_from, quantity_first, cost_price, cost_price_rate, quantity_total as quantity");
            $this->db->from("items");
            $query = $this->db->get();
            return $query->result_array();
        } else if ($store_id == "2000") {
            $this->db->select("item_id, item_number, category, name, unit, unit_from, quantity_first, cost_price, cost_price_rate, quantity");
            $this->db->from("items");
            $query = $this->db->get();
            return $query->result_array();
        } else {
            $this->db->select("items.item_id item_id, item_number, category, name, unit, unit_from, quantity_first, cost_price, cost_price_rate, warehouse_items.quantity as quantity");
            $this->db->from("warehouse_items");
            $this->db->join("items", "warehouse_items.item_id = items.item_id", "inner");
            $this->db->where("warehouse_items.warehouse_id", $store_id);
            $query = $this->db->get();
            return $query->result_array();
        }
    }

    function get_item_exim_category($id_cat, $start_date, $end_date, $store_id) {//print_r($store_id);exit();
        $this->db->select('trans_items');
        $this->db->distinct('trans_items');
        $this->db->join('items', 'items.item_id=inventory.trans_items', 'inner');
        $this->db->where('items.deleted', 0);
        $this->db->where('items.hanghoa', 0);
        $this->db->where('trans_catid', $id_cat);
        $this->db->where('trans_date <= ', $end_date);
        if ($store_id != 'all') {
            $this->db->where('store_id', $store_id);
        }
        $query = $this->db->get('inventory');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function get_item_by_category_store($id_item, $start_date, $end_date, $store_id, $term, $exim) {
        $this->db->select('sum(trans_inventory) trans_inventory, sum(trans_inventory * trans_money) money ');
        $this->db->where('trans_items', $id_item);

        if ($term == 'before') {
            $this->db->where('trans_date < ', $start_date);
        } else if ($term == 'between') {
            $this->db->where('trans_date >= ', $start_date);
            $this->db->where('trans_date <= ', $end_date);
        }

        if ($exim == 'im') {
            $this->db->where('trans_inventory >=', 0);
        } else if ($exim == 'ex') {
            $this->db->where('trans_inventory <', 0);
        }

        if ($store_id != 'all') {
            $this->db->where('store_id', $store_id);
        }
        $query = $this->db->get('inventory');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else
            return null;
    }

//    end Loi
    //dungbv
    function item_info_store($id_cat = '', $stores) {
        if ($stores != '') {
            $this->db->from('items i');
            $this->db->join('warehouse_items wi', 'i.item_id = wi.item_id');
            $this->db->where('wi.warehouse_id', $stores);
            $this->db->where('category', $id_cat);
            $this->db->where('deleted', 0);
            $query = $this->db->get();
        } else {
            $this->db->from('items');
            $this->db->where('category', $id_cat);
            $this->db->where('deleted', 0);
            $query = $this->db->get();
        }
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    //hung 4-6-15
    function get_item_search_suggestions($search, $limit = 25) {
        $suggestions = array();

        $this->db->from('items');
        $this->db->where('deleted', 0);
        $this->db->like('name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("name", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $price = $row->quantity_first != 0 ? $row->unit_price_rate : $row->unit_price;
            $unit_item = $row->quantity_first != 0 ? $row->unit_from : $row->unit;
            $suggestions[] = array(
                'value' => $row->item_id,
                'label' => $row->name,
                'unit_price' => number_format($price),
                'quantity' => format_quantity($row->quantity_total),
                'unit_item' => $this->Unit->get_info($unit_item)->name,
                'taxes_item' => $row->taxes,
            );
        }
        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    //hung 5-6-15
    function get_item_search_suggestions_warehouse_inventory($search, $stored, $cat, $limit = 25) {
        $suggestions = array();
        if ($stored == 0) {  //kho tong & kho san pham
            $this->db->select('items.*,units.id_unit,units.name as name_unit,units.delete');
            $this->db->from('items');
            $this->db->join("units", "items.unit=units.id_unit", "inner");
            $this->db->where('items.deleted', 0);
            $this->db->where('units.delete', 0);
            $this->db->where('service', 0);
            if ($cat) {
                $this->db->where('items.category', $cat);
            }
            $this->db->like('items.name', $search);
            $this->db->order_by("items.name", "asc");
            $by_name = $this->db->get();

            foreach ($by_name->result() as $row) {
                $this->db->select(' sum(trans_inventory) buy');
                $this->db->from('inventory i');
                $this->db->join('sales s', 's.sale_id = i.trans_sale', 'left');
                $this->db->where('s.materials', 0);
                $this->db->where('liability !=', 1);
                $this->db->where('trans_items', $row->item_id);
                $query = $this->db->get();
                $suggestions[] = array(
                    'value' => $row->name,
                    'label' => $row->name,
                    'item_number' => $row->item_number,
                    'id' => $row->item_id,
                    'unit_id' => $row->id_unit,
                    'unit_name' => $this->Unit->get_info($row->unit_rate != 0 ? $row->unit_from : $row->unit)->name,
                    'cost_price' => number_format($row->cost_price),
                    'id_store' => 0,
                    'name_inventory' => 'Kho tổng',
                    'quantity' => format_quantity($row->quantity_total),
                    'quantity_sale' => format_quantity(0 - $query->row()->buy),
                );
            }
        } else { //kho #
            $this->db->select('items.*,warehouse_items.warehouse_id,warehouse_items.item_id as id_item,warehouse_items.quantity as quantity_inventory,units.id_unit,units.name as name_unit,units.delete,create_invetory.*');
            $this->db->from('create_invetory');
            $this->db->join('warehouse_items', "create_invetory.id = warehouse_items.warehouse_id", "inner");
            $this->db->join('items', "warehouse_items.item_id = items.item_id", "inner");
            $this->db->join("units", "items.unit=units.id_unit", "inner");
            $this->db->where('items.deleted', 0);
            $this->db->where('units.delete', 0);
            $this->db->where('service', 0);
            if ($cat) {
                $this->db->where('items.category', $cat);
            }
            $this->db->where('warehouse_items.warehouse_id', $stored);
            $this->db->like('items.name', $search);
            $this->db->order_by("items.name", "asc");
            $by_name = $this->db->get();

            foreach ($by_name->result() as $row) {
                $this->db->select('si.*, sum(quantity_purchased) buy');
                $this->db->from('sales_items si');
                $this->db->join('sales s', 's.sale_id = si.sale_id', 'left');
                $this->db->where('s.materials', 0);
                $this->db->where('item_id', $row->item_id);
                $this->db->where('stored_id', $stored);
                $this->db->where('liability !=', 1);
                $query = $this->db->get();
                $suggestions[] = array(
                    'value' => $row->name,
                    'label' => $row->name,
                    'item_number' => $row->item_number,
                    'id' => $row->item_id,
                    'unit_id' => $row->id_unit,
                    'unit_name' => $this->Unit->get_info($row->unit_rate != 0 ? $row->unit_from : $row->unit)->name,
                    'cost_price' => number_format($row->cost_price),
                    'id_store' => $stored,
                    'name_inventory' => $row->name_inventory,
                    'quantity' => format_quantity($row->quantity_inventory),
                    'quantity_sale' => format_quantity($query->row()->buy),
                );
            }
        }
        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    //insert kho
    function warehouse_item($data_warehouse_item) {
        $this->db->insert('warehouse_items', $data_warehouse_item);
    }

    function get_info_item_number($item_number) {
        $this->db->where("item_number", $item_number);
        $this->db->where("deleted", 0);
        return $this->db->get('items')->num_rows();
    }

    function get_info_name($name) {
        $this->db->where("name", $name);
        return $this->db->get('items')->num_rows();
    }

    /*
     *
     */

    //dungbv
    function count_all_inventory_by_item($item_id) {
        $this->db->from('inventory');
        $this->db->where('trans_items', $item_id);
        return $this->db->count_all_results();
    }

    function get_all_inventory_by_item($item_id, $limit = 10000, $offset = 0, $col = 'trans_date', $ord = 'desc') {
        $this->db->from('inventory');
        $this->db->where('trans_items', $item_id);
        $this->db->order_by($col, $ord);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function search_inventory_by_item($item_id, $start_date, $end_date, $limit = 10000, $offset = 0, $column = 'trans_date', $orderby = 'desc') {
        $this->db->from('inventory');
        $this->db->where('trans_items', $item_id);
        $this->db->where('trans_date >=', $start_date);
        $this->db->where('trans_date <=', $end_date);
        $this->db->order_by($column, $orderby);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function search_count_all_inventory_by_item($item_id, $start_date, $end_date) {
        $this->db->from('inventory');
        $this->db->where('trans_items', $item_id);
        $this->db->where('trans_date >=', $start_date);
        $this->db->where('trans_date <=', $end_date);
        $result = $this->db->get();
        return $result->num_rows();
    }

    function get_item_in_warehouse_item($item_id) {
        $this->db->where("item_id", $item_id);
        $query = $this->db->get("warehouse_items");
        return $query->result();
    }

    function update_quantity_store2($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('warehouse_items', $data);
    }

    public function all_items() {
        return $this->db->get('items')->result_array();
    }

    public function check_items_top($top, $item_id = '') {
        if ($item_id) {
            $this->db->where('item_id !=', $item_id);
        }
//        echo 'xxxxxxxx';
//        var_dump($_POST);die;
        $this->db->where('top!=', $top);
        $this->db->where('deleted', 0);
//        $this->db->where('top !=', 0);
        $this->db->get('items');
        return $this->db->last_query();
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
    function update_cost_price($data, $item_kit_id) {
        $this->db->where_in('item_kit_id', $item_kit_id);
        return $this->db->update('items', $data);
    }

    //Hưng Audi Oct 23
    function get_item_by_item_number($item_number) {
        $this->db->like("item_number", $item_number);
        $query = $this->db->get("items");
        return $query->result_array();
    }
    //1088 band
    function get_item_search_suggestions_receiving_1088($search, $warehouse_id, $limit = 25) {
        $suggestions = array();
        $this->db->from('items i')
                 ->join('warehouse_items w', 'i.item_id = w.item_id', 'left')
                 ->where('deleted', 0);
        if($warehouse_id != 0){
            $this->db->where('warehouse_id', $warehouse_id);
        }
        $by_name = $this->db->where("(item_number like '%".$this->db->escape_like_str($search)
                        ."%' or name like '%".$this->db->escape_like_str($search)."%') ")
                 ->order_by("name", "asc")
                 ->get()
                 ->result();
        foreach ($by_name as $row) {
            $suggestions[] = array(
                'value' => $row->item_id,
                'label' => $row->item_number . ' - ' . $row->name
            );
        }
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    function getListItemsByCategoryUrl($url, $page = 1, $limit = 6) {
        $offset = ($page - 1)  * $limit;
        $this->db->where('deleted', 0);
        $this->db->where('active', 1);
        $this->db->where('url', $url);
        $query = $this->db->get('categories_item');
        if ($query->num_rows() == 1) {
            $category = $query->row();

            $this->db->where('deleted', 0);
            $this->db->where('product_view_home',1);
            $this->db->where('category', $category->id_cat);
            $this->db->order_by('item_id', 'DESC');
            $this->db->limit($limit);
            $this->db->offset($offset);
            $query = $this->db->get('items');

            return $query->result();
        } else
            return null;
    }

    function countAllItemsByCategoryUrl($url) {
        $this->db->where('deleted', 0);
        $this->db->where('active', 1);
        $this->db->where('url', $url);
        $query = $this->db->get('categories_item');
        if ($query->num_rows() == 1) {
            $category = $query->row();

            $this->db->where('deleted', 0);
            $this->db->where('category', $category->id_cat);
            $query = $this->db->get('items');

            return $query->num_rows();
        } else
            return null;
    }

    function getListItems($page = 1, $limit = 6) {
        $offset = ($page - 1)  * $limit;
        $this->db->where('deleted', 0);
        $this->db->where('product_view_home', 1);
        $this->db->order_by('item_id', 'DESC');
        $this->db->limit($limit);
        $this->db->offset($offset);
        $query = $this->db->get('items');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else
            return null;
    } 
}

?>
