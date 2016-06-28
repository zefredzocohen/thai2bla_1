<?php

class Create_invetory extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function count_all() {
        $query = $this->db->get('create_invetory');
        return $query->num_rows();
    }

    public function get_all($limit = 10000, $offset = 0, $col = 'id', $ord = 'desc') {
         
        $this->db->from('create_invetory');
        $this->db->where('deleted', 0);
        $this->db->limit($limit);
        $this->db->order_by($col, $ord);
        $this->db->offset($offset);
        return $this->db->get();
    }
    public function get_all_select() {
        $this->db->distinct();
        $this->db->select('name_province,id_province');
        $this->db->where('deleted', 0);
         
        
        return $this->db->get('create_invetory');
    }

     public function get_all_inventory() {
        $this->db->from('create_invetory');
        $this->db->where('deleted', 0);
        return $this->db->get();
    }
    
    public function get_all1($limit = 10000, $offset = 0) {
        $this->db->from('create_invetory');
        $this->db->where('deleted', 0);
        $this->db->where('id !=', 0);

        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    public function search_count_all($search, $limit = 10000) {
        $this->db->from('create_invetory');
        $this->db->where('deleted', 0);
        $this->db->where("name_inventory LIKE '%" . $this->db->escape_like_str($search) . "%'  ");
        $this->db->order_by("name_inventory", "asc");
        $result = $this->db->get();
        return $result->num_rows();
    }

    public function search($search, $limit = 20, $offset = 0, $column = 'name_inventory', $orderby = 'asc') {
        $this->db->from('create_invetory');
        $this->db->where('deleted', 0);
        $this->db->where("name_inventory LIKE '%" . $this->db->escape_like_str($search) . "%'  ");
        $this->db->order_by($column, $orderby);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    public function get_search_suggestions($search, $limit = 25) {
        $suggestions = array();
        $this->db->from('create_invetory');
        $this->db->where('deleted', 0);
        $this->db->like("name_inventory", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("name_inventory", "asc");
        $by_company_name = $this->db->get();
        foreach ($by_company_name->result() as $row) {
            $suggestions[] = array('label' => $row->name_inventory);
        }
        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    public function get_data() {
        $query = $this->db->get('create_invetory');
        return $query->row_array();
    }

    public function get_list_customer_types() {
        $this->db->select(array('id', 'name'));
        $this->db->from('create_invetory');
        $this->db->distinct();
        $this->db->order_by("name", "asc");
        return $this->db->get();
    }

    public function exists($custometype_id) {
        $this->db->from('create_invetory');
        $this->db->where('id', $custometype_id);
        $query = $this->db->get();
        return ($query->num_rows() == 1);
    }

    public function save(&$data, $id = false) {
        if (!$id or ! $this->exists($id)) {
            if ($this->db->insert('create_invetory', $data)) {
                $data['id'] = $this->db->insert_id();
                return true;
            }
            return false;
        }
        $this->db->where('id', $id);

        return $this->db->update('create_invetory', $data);
    }

    public function get_info($customertype_id) {
        $this->db->from('create_invetory');
        $this->db->where('id', $customertype_id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            $customertype_obj = new stdClass();
            $fields = $this->db->list_fields('create_invetory');
            foreach ($fields as $field) {
                $customertype_obj->$field = '';
            }
            return $customertype_obj;
        }
    }

    public function delete_list($id, $data) {
        if (!$data) {
            $this->db->where_in('id', $id);
        }
        return $this->db->update('create_invetory', array('deleted' => 1));
    }

    public function get_inventory_transfer($id) {
        $this->db->select('transfer_inventory.*,create_invetory.*,items.*');
        $this->db->where('create_invetory.id', $id);
        $this->db->from('create_invetory');
        $this->db->join('transfer_inventory', 'transfer_inventory.id_inven = create_invetory.id');
        $this->db->join('items', 'items.item_id = transfer_inventory.item_id');
        $query = $this->db->get();
        // var_dump($this->db->last_query());exit();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    // thangnn06102014
    public function get_warehouseinfo($id) {
        $this->db->select("warehouse_items.*,items.*,sum(phppos_warehouse_items.quantity) as quantity_warehouse");
        //$this->db->select_sum('age');
        $this->db->from('warehouse_items');
        $this->db->where('warehouse_items.warehouse_id', $id);
        $this->db->join('items', 'items.item_id=warehouse_items.item_id');
        //$this->db->join('receivings','receivings.inventory_id=warehouse_items.warehouse_id');
        $this->db->group_by('warehouse_id');
        $query = $this->db->get();
        //var_dump($this->db->last_query());exit();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function get_inventory_view() {
        $this->db->select('id,name_inventory');
        $this->db->from('create_invetory');
        $this->db->where('deleted', 0);
        $this->db->order_by('name_inventory', 'asc');
        $query = $this->db->get();
        // var_dump($this->db->last_query());exit();
        $invenorys = $query->result();
        $array_inventorys = array();
        $array_inventorys[''] = 'Chọn kho';
        foreach ($invenorys as $key) {
            $array_inventorys[$key->id] = $key->name_inventory;
        }
        return $array_inventorys;
    }

    public function get_warehouse() {
        $this->db->select('id,name_inventory');
        $this->db->from('create_invetory');
        $this->db->where('deleted', 0);
        $query = $this->db->get();
        // var_dump($this->db->last_query());exit();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    // thangnn13102014
    //======Create by San 03/02/2015=====
    //Kiem tra su ton tai cua kho thanh pham
    function check_exist_product_store() {
        $this->db->where("type_warehouse", 1);
        $this->db->where("deleted", 0);
        $query = $this->db->get("create_invetory");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    //Kiem tra su ton tai cua kho nguyen vat lieu
    function check_exist_store_materials() {
        $this->db->where("type_warehouse", 2);
        $this->db->where("deleted", 0);
        $query = $this->db->get("create_invetory");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    //Kiem tra trung ten kho
    function checkName($id) {
        if ($id > 0) {
            $this->db->select('name_inventory');
            $this->db->where('id !=', $id);
            $this->db->where('deleted', 0);
            $this->db->from('create_invetory');
            $query = $this->db->get();
        } elseif ($id = -1) {
            $this->db->select('name_inventory');
            $this->db->where('deleted', 0);
            $this->db->from('create_invetory');
            $query = $this->db->get();
        }
        foreach ($query->result_array() as $q) {
            $result[] = $q;
        }
        return $result;
    }

    //hung audi 31-3-15
    function get_inventory_view2() {
        $this->db->select('id,name_inventory');
        $this->db->from('create_invetory');
        $this->db->where('type_warehouse !=', 1);
        $this->db->order_by('name_inventory', 'asc');
        $query = $this->db->get();
        $invenorys = $query->result();
        $array_inventorys = array();
        $array_inventorys['0'] = 'Kho tổng';
        foreach ($invenorys as $key) {
            $array_inventorys[$key->id] = $key->name_inventory;
        }
        return $array_inventorys;
    }

//04-04-15 hung audi chuyen kho
    public function get_all3($store) {
        if ($store == 0) {
            $this->db->from('create_invetory');
            $this->db->where('deleted', 0);
            //$this->db->where('type_warehouse !=', 1);
            $this->db->where('id !=', $store);
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $suggestions[] = array(
                    'label' => $row->name_inventory,
                    'id' => $row->id,
                );
            }
        } else {
            $suggestions[0] = array(
                'label' => 'Kho tổng',
                'id' => '0',
            );
            $this->db->from('create_invetory');
            $this->db->where('deleted', 0);
            //$this->db->where('type_warehouse !=', 1);
            $this->db->where('id !=', $store);
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $suggestions[] = array(
                    'label' => $row->name_inventory,
                    'id' => $row->id,
                );
            }
        }
        return $suggestions;
    }

    public function get_all2($limit = 10000, $offset = 0, $col = 'id', $ord = 'desc') {
        $this->db->from('create_invetory');
        $this->db->where('deleted', 0);
        $this->db->where('type_warehouse !=', 2);
        $this->db->limit($limit);
        $this->db->order_by($col, $ord);
        $this->db->offset($offset);
        return $this->db->get();
    }

//    By Loi
    function get_all_stores() {
        $query = $this->db->get("create_invetory");
        return $query->result_array();
    }
    function get_all_stores_1() {//by tuandung
        return $this->db->get('create_invetory')->result();
    }

    function count_all_export_store() {
        $query = $this->db->get('export_store');
        return $query->num_rows();
    }

    function get_all_export_store($limit = 10000, $offset = 0, $col = 'export_store_id', $order = 'desc') {
        $this->db->from('export_store');
        $this->db->order_by($col, $order);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function get_all_export_store_item($export_store_id) {
        $this->db->from('export_store_item')
                ->where('export_store_id', $export_store_id);
        return $this->db->get();
    }

    function search_count_all_export_store($start_date, $end_date, $search) {
        $start_date2 = "and date_export >= '$start_date'";
        $end_date2 = "and date_export <= '$end_date'";
        $this->db->from('export_store')
                ->where("(export_store_id LIKE '%" . $this->db->escape_like_str($search) . "%' )
                $start_date2 $end_date2 ");
        $result = $this->db->get();
        return $result->num_rows();
    }

    function search_export_store($start_date, $end_date, $search, $limit = 20, $offset = 0, $column = 'export_store_id', $orderby = 'desc') {
        $start_date2 = "and date_export >= '$start_date'";
        $end_date2 = "and date_export <= '$end_date'";
        $this->db->from('export_store')
                ->where("( export_store_id LIKE '%" . $this->db->escape_like_str($search) . "%' )
                     $start_date2 $end_date2 ")
                ->order_by($column, $orderby)
                ->limit($limit)
                ->offset($offset);
        return $this->db->get();
    }

    function get_export_store_item_by_id($export_store_id) {
        $this->db->from('export_store_item');
        $this->db->where('export_store_id', $export_store_id);
        return $this->db->get();
    }

    function get_info_export_store($export_store_id) {
        $this->db->from('export_store');
        $this->db->where('export_store_id', $export_store_id);
        return $this->db->get()->row();
    }

    function exists_export_store($export_store_id) {
        $this->db->from('export_store');
        $this->db->where('export_store_id', $export_store_id);
        $query = $this->db->get();
        return ($query->num_rows() == 1);
    }

    function save_export_store(&$data, $id = false) {
        if (!$id or ! $this->exists_export_store($id)) {
            if ($this->db->insert('export_store', $data)) {
                $data['export_store_id'] = $this->db->insert_id();
                return true;
            }
            return false;
        }
        $this->db->where('export_store_id', $id);
        return $this->db->update('export_store', $data);
    }

    function save_export_store_item(&$export_store_item_data, $export_store_id) {
        $this->db->trans_start();
        $this->delete_export_store_item($export_store_id);

        foreach ($export_store_item_data as $row) {
            $row['export_store_id'] = $export_store_id;
            $this->db->insert('export_store_item', $row);
        }
        $this->db->trans_complete();
        return true;
    }

    function get_info_export_store_item($export_store_id, $item_id) {
        $this->db->from('export_store_item')
                ->where('export_store_id', $export_store_id)
                ->where('item_id', $item_id);
        return $this->db->get()->row();
    }

    function get_apple($warehouse_ids) {
        $this->db->where("warehouse_id in ($warehouse_ids)");
        $query = $this->db->get("warehouse_items");
        return $query;
    }

    function delete_export_store_item($export_store_id) {
        return $this->db->delete('export_store_item', array('export_store_id' => $export_store_id));
    }

    function delete_export_store($export_store_id) {
        return $this->db->delete("export_store", array("export_store_id" => $export_store_id));
    }

    function get_search_suggestions_export_store($search, $limit = 25) {
        $suggestions = array();
        $this->db->from('export_store')
                ->like('export_store_id', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both')
                ->order_by("export_store_id", "desc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('label' => $row->export_store_id);
        }

        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

//    end Loi


    function get_export_store($start_date, $end_date, $store_id) {
        $this->db->select('*');
        $this->db->from('export_store');
        $this->db->where('date_export >=', $start_date);
        $this->db->where('date_export <=', $end_date);
        if ($store_id != 'all') {
            $this->db->where('store_id', $store_id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_export_store_item($start_date, $end_date, $store_id) {
        $this->db->select('esi.*');
        $this->db->from('export_store_item esi');
        $this->db->join('export_store es', 'esi.export_store_id = es.export_store_id');
        $this->db->where('es.date_export >=', $start_date);
        $this->db->where('es.date_export <=', $end_date);
        if ($store_id != 'all') {
            $this->db->where('es.store_id', $store_id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_row_export_store_item($es_id) {
        $this->db->where("export_store_id", $es_id);
        $query = $this->db->get("export_store_item");
        return $query->result_array();
    }

    //kt xem kho con san pham hay khong dungbv
    public function check_store_item($store_id) {
        $this->db->where('warehouse_id', $store_id);
        return $this->db->get('warehouse_items')->num_rows();
    }

    function get_search_order_request($search, $limit = 25) {
        $suggestions = array();
        $this->db->from('item_production');
        $this->db->like('id', $search);
        $this->db->where('export_store', 0);
        $this->db->order_by("id", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array(
                'id' => $row->id,
                'label' => $row->id,
                'request_id' => $row->request_id
            );
        }

        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    function get_search_order_pro_template($search, $limit = 25) {
        $suggestions = array();
        $this->db->from('item_kit_request_production_template');
        $this->db->like('request_id', $search);
        $this->db->where('export_store', 0);
        $this->db->order_by("request_id", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array(
                'id' => $row->request_id,
                'label' => $row->request_id
            );
        }
        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    function get_suggest_list_item_of_request($request_id, $quantity_request) {
        $suggestions = array();
        $this->db->from('item_kit_formula_materials');
        $this->db->where('request_id', $request_id);
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $info_item = $this->Item->get_info($row->item_id);
            $info_store_material = $this->Create_invetory->check_exist_store_materials();
            $info_item_material = $this->Item->get_id_Items_warehouse($info_store_material['id'], $row->item_id);
            $unit = $info_item->quantity_first == 0 ? $info_item->unit : $info_item->unit_from;
            $info_unit = $this->Unit->get_info($unit);
            $suggestions[] = array(
                'value' => $info_item->name,
                'label' => $info_item->name,
                'cost_price_export' => number_format($info_item->quantity_first == 1 ? $info_item->cost_price_rate : $info_item->cost_price),
                'cost_price_export2' => $info_item->quantity_first == 1 ? $info_item->cost_price_rate : $info_item->cost_price,
                'item_number' => $info_item->item_number != null ? $info_item->item_number : '',
                'id' => $row->item_id,
                'unit' => $info_unit->name,
                'quantity' => format_quantity($info_item_material->quantity),
                'quantity_request' => format_quantity($row->quantity * $quantity_request)
            );
        }
        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    function get_export_store_by_item_production_id($item_production_id) {
        $this->db->where("item_production_id", $item_production_id);
        $query = $this->db->get("export_store");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_sum_quantity_exported($arr, $item_id) {
        $this->db->select("item_id, quantity_request, sum(quantity_export) as quantity_exported");
        $this->db->where("item_id", $item_id);
        $this->db->where_in("export_store_id", $arr);
        $this->db->group_by("item_id");
        $query = $this->db->get("export_store_item");
        return $query->row();
    }

    function update_item_production_by_id($data, $id) {
        $this->db->where("id", $id);
        return $this->db->update("item_production", $data);
    }

    function get_export_store_item_by_request_template_id($request_template_id) {
        $this->db->where("item_production_id", $request_template_id);
        $this->db->where("status", 1);
        $query = $this->db->get("export_store");
        return $query->result();
    }

    function update_request_production_template_by_request_id($data, $request_id) {
        $this->db->where("request_id", $request_id);
        return $this->db->update("item_kit_request_production_template", $data);
    }

    function get_export_store_by_request_template_id($request_template_id) {
        $this->db->where("request_template_id", $request_template_id);
        $query = $this->db->get("export_store");
        return $query->result();
    }

//Lay danh sach kho khac kho NVL va kho thanh pham
    function get_list_warehouse_not_material_and_finished() {
        $this->db->where("type_warehouse !=", 1);
        $this->db->where("type_warehouse !=", 2);
        $this->db->where("deleted", 0);
        $query = $this->db->get("create_invetory");
        return $query->result();
    }

}

/* End of file create_invetory.php */
/* Location: ./application/models/create_invetory.php */