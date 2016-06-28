<?php

class Inventory extends CI_Model {

    function insert($inventory_data) {
        return $this->db->insert('inventory', $inventory_data);
    }

    public function get_item_unit_price_dauky($item_id, $start_date) {
        $this->db->from('sales_items');
        $this->db->distinct('date');
        $this->db->where('item_id', $item_id);
        $this->db->where('date <', $start_date);
        $query = $this->db->get();
        return $query->result_array();
    }

    function find_cost_complete_customer($id_customer) {
        $this->db->where('id_customer = ', $id_customer);
        $this->db->where('deleted = ', 0);
        $this->db->order_by("date", "desc");
        $query = $this->db->get('costs');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function find_trade_complete_customer($id_customer) {
        $this->db->where('customer_id = ', $id_customer);
        //$this->db->where('progress = ',0);
        $this->db->order_by("duration", "desc");
        $query = $this->db->get('gantt_project');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function get_inventory_data_for_item($item_id) {
        $this->db->from('inventory');
        $this->db->where('trans_items', $item_id);
        $this->db->order_by("trans_date", "desc");
        return $this->db->get();
    }

    function get_date($start_date, $end_date) {
        $this->db->select('trans_date');
        $this->db->distinct('trans_date');
        $this->db->where('trans_date >= ', $start_date);
        $this->db->where('trans_date <= ', $end_date);
        $query = $this->db->get('inventory');
        //var_dump($this->db->last_query());exit();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function select_supplier_distinct($select_date) {
        $this->db->select('trans_people');
        $this->db->distinct('trans_people');
        $this->db->where('trans_date = ', $select_date);
        $query = $this->db->get('inventory');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function select_items_receiving($select_date, $select_supplier) {
        $this->db->where('trans_date = ', $select_date);
        $this->db->where('trans_people = ', $select_supplier);
//            $this->db->where('trans_inventory > ', 0);
//            $this->db->where('trans_recevings > ', 0);
        $query = $this->db->get('inventory');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function select_items_export($select_date, $select_supplier) {
        $this->db->where('trans_date = ', $select_date);
        $this->db->where('trans_people = ', $select_supplier);
        $this->db->where('trans_inventory < ', 0);
        $this->db->where('trans_sale > ', 0); //xđ đơn hàng bán
        $query = $this->db->get('inventory');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function find_suspends_date() {
        //$this->db->where('date_debt = ',date('Y-m-d'));
        $this->db->where('suspended = ', 1);
        $this->db->where('deleted = ', 0);
        $query = $this->db->get('sales');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function find_sale_id($sale_id, $item) {
        $this->db->where('trans_items = ', $item);
        $this->db->where('trans_sale = ', $sale_id);
        $query = $this->db->get('inventory');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function update($sale_id, $item, $inv_data) {
        $this->db->where('trans_sale = ', $sale_id);
        $this->db->where('trans_items = ', $item);
        $this->db->update('inventory', $inv_data);
    }

    function find_sale_complete_customer($id_customer) {
        $this->db->where('customer_id = ', $id_customer);
        $this->db->where('suspended = ', 1);
        $this->db->order_by("sale_time", "desc");
        $query = $this->db->get('sales');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function find_sale_complete_customer_materials($id_customer) {
        $this->db->where('customer_id = ', $id_customer);
        $this->db->where('materials', 1);
        $this->db->where('deleted', 0);
        $this->db->order_by("sale_time", "desc");
        $query = $this->db->get('sales');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function find_item_sale_customer($id_sale) {
        $this->db->where('sale_id = ', $id_sale);
        $query = $this->db->get('sales_items');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function find_sale_all_customer($id_customer) {
        $this->db->where('customer_id = ', $id_customer);
        $this->db->where('deleted = ', 0);
        $this->db->order_by("sale_time", "desc");
        $query = $this->db->get('sales');
        //$this->db->join('sales_items', 'sales_items.sale_id=sales.sale_id');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    //hung dq 28-01
    //ban hang 1
    function find_sale_all_customer2($id_customer, $page_limit, $resultsPerPage) {//sales
        $sql = "select * from lifetek_sales 
			where customer_id = " . $id_customer . " and deleted = 0 ORDER BY sale_id DESC
			limit $page_limit,$resultsPerPage
			";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function get_row($id_customer, $page_limit, $resultsPerPage) {//sales
        $sql = "select * from lifetek_sales 
			where customer_id = " . $id_customer . " and deleted = 0 
			limit $page_limit,$resultsPerPage
			";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else
            return null;
    }

    function get_total_row($id_customer) {//sales
        $sql = "select * from lifetek_sales 
			where customer_id = " . $id_customer . " and deleted = 0 
			";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else
            return null;
    }

    //thu chi 2
    function find_cost_complete_customer2($id_customer, $page_limit, $resultsPerPage) {//costs
        $sql = "select * from lifetek_costs 
			where id_customer = " . $id_customer . " and deleted = 0 and money != 0 ORDER BY id_cost DESC
			limit $page_limit,$resultsPerPage
			";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function get_row2($id_customer, $page_limit, $resultsPerPage) {//sales
        $sql = "select * from lifetek_costs 
			where id_customer = " . $id_customer . " and deleted = 0 
			limit $page_limit,$resultsPerPage
			";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else
            return null;
    }

    function get_total_row2($id_customer) {//sales
        $sql = "select * from lifetek_costs 
			where id_customer = " . $id_customer . " and deleted = 0 
			";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else
            return null;
    }

    //giao dich 3
    function find_trade_complete_customer2($id_customer, $page_limit, $resultsPerPage) {//costs
        $sql = "select * from lifetek_gantt_project 
			where customer_id = " . $id_customer . " 
			limit $page_limit,$resultsPerPage
			";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function get_row3($id_customer, $page_limit, $resultsPerPage) {//sales
        $sql = "select * from lifetek_gantt_project 
			where customer_id = " . $id_customer . "  
			limit $page_limit,$resultsPerPage
			";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else
            return null;
    }

    function get_total_row3($id_customer) {//sales
        $sql = "select * from lifetek_gantt_project 
			where customer_id = " . $id_customer . "  
			";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else
            return null;
    }

    //cong no 4
    function find_sale_complete_customer2($id_customer, $page_limit, $resultsPerPage) {//costs
        $sql = "select * from lifetek_sales 
			where customer_id = " . $id_customer . " and deleted = 0 
			and suspended = 1 ORDER BY sale_id DESC
			limit $page_limit,$resultsPerPage
			";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function get_row4($id_customer, $page_limit, $resultsPerPage) {//sales
        $sql = "select * from lifetek_sales 
			where customer_id = " . $id_customer . " and deleted = 0
			and suspended = 1 
			limit $page_limit,$resultsPerPage
			";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else
            return null;
    }

    function get_total_row4($id_customer) {//sales
        $sql = "select * from lifetek_sales 
			where customer_id = " . $id_customer . " and deleted = 0
			and suspended = 1 
			";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else
            return null;
    }

    //bao gia 5
    function find_sale_complete_customer_materials2($id_customer, $page_limit, $resultsPerPage) {
        $sql = "select * from lifetek_sales 
			where customer_id = " . $id_customer . " and deleted = 0
			and materials != 0 ORDER BY sale_id DESC
			limit $page_limit,$resultsPerPage";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function get_row5($id_customer, $page_limit, $resultsPerPage) {//sales
        $sql = "select * from lifetek_sales 
			where customer_id = " . $id_customer . " and deleted = 0
			and materials = 1 
			limit $page_limit,$resultsPerPage
			";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else
            return null;
    }

    function get_total_row5($id_customer) {//sales
        $sql = "select * from lifetek_sales 
			where customer_id = " . $id_customer . " and deleted = 0
			and materials = 1 
			";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else
            return null;
    }

    //end hung dq
    //lấy ngày cho báo cáo nhập hàng trong inventory
    function get_date_receiving($start_date, $end_date, $sale_type) {
        $this->db->select('trans_date,trans_recevings');
        $this->db->distinct('trans_date');
        $this->db->where('trans_date >= ', $start_date);
        $this->db->where('trans_date <= ', $end_date);
        $this->db->where('trans_recevings > ', 0);
        if ($sale_type == 'sales') {
            $this->db->where('trans_comment', 'RECV');
        } elseif ($sale_type == 'returns') {
            $this->db->where('trans_comment', 'RETURN_RECV');
        }
        $query = $this->db->get('inventory');
        //var_dump($this->db->last_query());exit();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    //Created by San
    //=====Lay ca don hang theo khach hang khong co phan trang
    function find_sale_complete_by_customer($customer_id) {
        $this->db->where('customer_id', $customer_id);
        $this->db->where('suspended', 1);
        $this->db->where('deleted', 0);
        $query = $this->db->get('sales');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    //Kiem tra mat hang da co giao dich trong bang inventory (Them bot)
    function check_exists_item_in_inventory($item_id) {
        $this->db->where("trans_items", $item_id);
        $this->db->where("trans_inventory !=", 0);
        $query = $this->db->get("inventory");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    //Xoa mat hang vua tao nhung chua phat sinh giao dich
    function delete_in_inventory($item_id) {
        $this->db->where_in('trans_items', $item_ids);
        $this->db->where("trans_inventory", 0);
        $this->db->delete("inventory");
    }

    //End By San
    //hung audi 11-4-15
    function get_date_by_item_service($start_date, $end_date, $item_type) {//die($item_type);
        $this->db->from('inventory');
        $this->db->join('items', 'items.item_id = inventory.trans_items');
        $this->db->distinct('inventory.trans_date');
        $this->db->where('inventory.trans_date >= ', $start_date);
        $this->db->where('inventory.trans_date <= ', $end_date);
        $this->db->group_by('inventory.trans_date');
        if ($item_type == 0) {
            $this->db->where('items.service', 0);
        } else if ($item_type == 1) {
            $this->db->where('items.service', 1);
        } else {
            
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    //hung audi 23-4-15
    //thu chi 3 nha cung cap
    function find_cost_complete_customer8($supplier_id, $page_limit, $resultsPerPage) {
        $sql = "select * from lifetek_costs 
			where supplier_id = " . $supplier_id . " and deleted = 0 and money != 0 ORDER BY id_cost DESC
			limit $page_limit,$resultsPerPage
			";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function get_row8($supplier_id, $page_limit, $resultsPerPage) {
        $sql = "select * from lifetek_costs 
			where supplier_id = " . $supplier_id . " and deleted = 0 
			limit $page_limit,$resultsPerPage
			";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else
            return null;
    }

    function get_total_row8($supplier_id) {
        $sql = "select * from lifetek_costs 
			where supplier_id = " . $supplier_id . " and deleted = 0 
			";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else
            return null;
    }

    //    By Loi
    function get_date_by_item_by_service($start_date, $end_date, $item_type) {//die($item_type)
        $this->db->from('inventory');
        $this->db->join('items', 'items.item_id = inventory.trans_items');
        $this->db->distinct('inventory.trans_date');
        $this->db->where('inventory.trans_date >= ', $start_date);
        $this->db->where('inventory.trans_date <= ', $end_date);
        $this->db->group_by('inventory.trans_date');
        if ($item_type == 3) {
            $this->db->where('items.produce', 1);
        } elseif ($item_type == 1 || $item_type == 0) {
            $this->db->where('items.service', $item_type);
            $this->db->where('items.produce', 0);
            $this->db->where('inventory.trans_packs', NULL);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function get_sales_packs_by_service($start_date, $end_date) {
        $this->db->from('inventory');
        $this->db->join('packs', 'packs.pack_id = inventory.trans_packs');
        $this->db->distinct('inventory.trans_date');
        $this->db->where('inventory.trans_date >= ', $start_date);
        $this->db->where('inventory.trans_date <= ', $end_date);
        $this->db->group_by('inventory.trans_date');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function get_all_item_in_inventory($start_date, $end_date) {
        $this->db->select('trans_items');
        $this->db->from('inventory');
        $this->db->where('trans_date >=', $start_date);
        $this->db->where('trans_date <=', $end_date);
        $this->db->distinct('trans_items');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_price_receving($item_id) {
        $this->db->select('trans_money,trans_inventory');
        $this->db->from('inventory');
        $this->db->where('trans_recevings >', 0);
        $this->db->where('trans_items', $item_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_price_sale($start_date, $end_date, $item_id) {
        $this->db->select('trans_money,trans_inventory,trans_sale');
        $this->db->from('inventory');
        $this->db->where('trans_date >=', $start_date);
        $this->db->where('trans_date <=', $end_date);
        $this->db->where('trans_sale >', 0);
        $this->db->where('trans_items', $item_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_cat_item($start_date, $end_date, $cat_id) {
        $this->db->select('i.category');
        $this->db->from('inventory iv');
        $this->db->join('items i', 'iv.trans_items = i.item_id');
        $this->db->where('trans_date >=', $start_date);
        $this->db->where('trans_date <=', $end_date);
        if ($cat_id != 0) {
            $this->db->where('i.category', $cat_id);
        }
        $this->db->group_by('i.category');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_inventory_group_by_category($start_date, $end_date, $cat_id) {
        $this->db->select('iv.trans_items');
        $this->db->from('inventory iv');
        $this->db->join('items i', 'iv.trans_items = i.item_id');
        $this->db->where('trans_date >=', $start_date);
        $this->db->where('trans_date <=', $end_date);
        $this->db->where('i.category', $cat_id);
        $this->db->distinct('iv.trans_items');
        $query = $this->db->get();
        return $query->result_array();
    }

//    end Loi
    function get_trans_recevings_return($trans_recevings) {
        $q = $this->db->where('trans_recevings', $trans_recevings)
                ->where('trans_comment', 'RETURN')
                ->get('inventory');
        if ($q->num_rows > 0) {
            return 1;
        }
    }

    function get_trans_sale_return($trans_sale) {
        $q = $this->db->where('trans_sale', $trans_sale)
                ->where('trans_comment', 'POS')
                ->get('inventory');
        if ($q->num_rows > 0) {
            return 1;
        }
    }

    function receiving_import($start_date, $end_date) {
        $this->db->from('receivings');
        $this->db->where('receiving_time >= ', $start_date);
        $this->db->where('receiving_time <= ', $end_date);
        $this->db->where('status_currency', 1);
        $this->db->order_by('receivings.receiving_id', 'desc');

        return $this->db->get()->result_array();
    }

    function receiving_items_import($sale_type) {
        if ($sale_type == 'sales') {
            $this->db->where('quantity_purchased >', 0);
        } elseif ($sale_type == 'returns') {
            $this->db->where('quantity_purchased <', 0);
        }
        return $this->db->get('receivings_items')->result_array();
    }

    public function getCurrency() {
        $this->db->from('currency');
        return $this->db->get()->result();
    }
    //Sep 25 Hưng Audi
    function get_product_inventory($request_id, $start_date, $end_date) {
        return $this->db->select('sum(trans_inventory) quantity')
                        ->where("request_id in ($request_id)")
                        ->where('trans_date >= ', $start_date)
                        ->where('trans_date <= ', $end_date)
                        ->get('inventory')->row();
    }    
    //play boy << Hưng Audi >> 2-10-15
    function get_product_inventory_request($request_id) {
        return $this->db->select('sum(trans_inventory) quantity')
                        ->where('request_id', $request_id)
                        ->get('inventory')->row();
    } 
    //Hưng Audi Oct 23
    function update_by_item($inv_data, $item) {
        $this->db->where('trans_items', $item)
                ->update('inventory', $inv_data);
    }
    //Oct 30
    function get_inventory_by_import_product_id($import_product_id){
        return $this->db->where('import_product_id', $import_product_id)
                        ->get('inventory');
    }
    function get_inventory_by_import_product_id_2016($import_product_id){
        return $this->db->select('sum(trans_inventory) quantity')
                        ->where('import_product_id', $import_product_id)
                        ->get('inventory')->row();
    }   
    function get_inventory_by_request_id($request_id) {
        return $this->db->where('request_id', $request_id)
                        ->group_by('import_product_id')
                        ->get('inventory');
    } 
    function get_inventory_by_request_id_2016($request_id) {
        return $this->db->select('sum(trans_inventory) quantity')
                        ->where('request_id', $request_id)
                        ->get('inventory')->row();
    }
    
    function get_all_inventory_product($limit = 10000, $offset = 0, $col = 'import_product_id', $ord = 'desc') {
        return $this->db->order_by($col, $ord)
                        ->limit($limit)
                        ->offset($offset)
                        ->where('import_product_id !=', 0)
                        ->group_by('import_product_id')
                        ->get('inventory');
    }
    function count_all_inventory_product() {
        return $this->db->where('import_product_id !=', 0)
                        ->group_by('import_product_id')
                        ->get('inventory')
                        ->num_rows();
    }
    
     function cost_customer($id_customer) {//costs
        $sql = "select * from lifetek_costs 
			where id_customer = " . $id_customer . " and deleted = 0 and stt = 1 ORDER BY id_cost DESC
			";
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else
            return null;
    }
    
}

?>