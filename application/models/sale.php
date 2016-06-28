<?php

class Sale extends CI_Model {

    public function get_sumary($sale_id) {
        $this->db->select('sum(quantity_purchased*item_unit_price) as total');
        $this->db->from('sales_items');
        $this->db->where('sale_id', $sale_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function check_payment_type_is_tienmat($sale_id) {
        $tbl_sales = $this->db->dbprefix("sales");
        $name = "Tiền mặt";
        $query = $this->db->query("select payment_type from " . $tbl_sales . " where sale_id=" . $sale_id . " and  payment_type LIKE'%" . $this->db->escape_like_str($name) . "%'");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_info_sales_inventory($sale_id) {
        $this->db->from('sales_inventory');
        $this->db->where('id_sale', $sale_id);
        $this->db->order_by("id", "desc");
        $this->db->limit('1');
        $query = $this->db->get();
        return $query->row();
    }

    public function check_payment_type_is_tragop_tbl_sales_payments($sale_id) {
        $tbl_sales = $this->db->dbprefix("sales_payments");
        $name = "Trả Góp";
        $query = $this->db->query("select payment_type from " . $tbl_sales . " where sale_id=" . $sale_id . " and  payment_type LIKE'%" . $this->db->escape_like_str($name) . "%'");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function check_payment_type_is_tragop_tbl_sales($sale_id) {
        $tbl_sales = $this->db->dbprefix("sales");
        $name = "Tiền mặt";
        $query = $this->db->query("select payment_type from " . $tbl_sales . " where sale_id=" . $sale_id . " and  payment_type LIKE'%" . $this->db->escape_like_str($name) . "%'");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
  function get_info_date($sale_id) {
        $this->db->from('sales');
        $this->db->where('sale_id',$sale_id);

        return $query = $this->db->get()->row();
}    
 function get_info_date2($sale_id) {
        $this->db->from('sales_items');
        $this->db->where('sale_id', $sale_id);

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

    function get_info_sale_complete_item($item_id, $sale_id) {
        $this->db->from('sales_items');
        $this->db->where('item_id', $item_id);
        $this->db->where('sale_id', $sale_id);
        return $this->db->get()->row()->item_unit_price;
    }

    function get_info_sale_complete_discount_percent($item_id, $sale_id) {

        $this->db->from('sales_items');
        $this->db->where('item_id', $item_id);
        $this->db->where('sale_id', $sale_id);
        return $this->db->get()->row()->discount_percent;
    }

    public function get_info($sale_id) {
        $this->db->from('sales');
        $this->db->where('sale_id', $sale_id);
        return $this->db->get();
    }

    public function get_info_web($order_id) {
        $this->db->from('omc_order');
        $this->db->where('order_id', $order_id);
        return $this->db->get();
    }

    function get_cash_sales_total_for_shift($shift_start, $shift_end) {
        $sales_totals = $this->get_sales_totaled_by_id($shift_start, $shift_end);
        $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;

        $this->db->select('sales_payments.sale_id, sales_payments.payment_type, payment_amount', false);
        $this->db->from('sales_payments');
        $this->db->join('sales', 'sales_payments.sale_id=sales.sale_id');
        $this->db->where('sale_time >=', $shift_start);
        $this->db->where('sale_time <=', $shift_end);
        $this->db->where('employee_id', $employee_id);
        $this->db->where($this->db->dbprefix('sales') . '.deleted', 0);

        $payments_by_sale = array();
        $sales_payments = $this->db->get()->result_array();

        foreach ($sales_payments as $row) {
            $payments_by_sale[$row['sale_id']][] = $row;
        }

        $payment_data = $this->Sale->get_payment_data($payments_by_sale, $sales_totals);

        if (isset($payment_data[lang('sales_cash')])) {
            return $payment_data[lang('sales_cash')]['payment_amount'];
        }

        return 0.00;
    }

    function get_payment_data($payments_by_sale, $sales_totals) {
        $payment_data = array();

        foreach ($payments_by_sale as $sale_id => $payment_rows) {
            $total_sale_balance = $sales_totals[$sale_id];
            usort($payment_rows, array('Sale', '_sort_payments_for_sale'));

            foreach ($payment_rows as $row) {
                $payment_amount = $row['payment_amount'] <= $total_sale_balance ? $row['payment_amount'] : $total_sale_balance;

                if (!isset($payment_data[$row['payment_type']])) {
                    $payment_data[$row['payment_type']] = array('payment_type' => $row['payment_type'], 'payment_amount' => 0);
                }

                if ($total_sale_balance != 0) {
                    $payment_data[$row['payment_type']]['payment_amount'] += $payment_amount;
                }

                $total_sale_balance-=$payment_amount;
            }
        }

        return $payment_data;
    }

    static function _sort_payments_for_sale($a, $b) {
        if ($a['payment_amount'] == $b['payment_amount']) {
            return 0;
        }

        if ($a['payment_amount'] < $b['payment_amount']) {
            return -1;
        }

        return 1;
    }

    function get_sales_totaled_by_id($shift_start, $shift_end) {
        $where = 'WHERE sale_time BETWEEN "' . $shift_start . '" and "' . $shift_end . '"';
        $this->_create_sales_items_temp_table_query($where);

        $sales_totals = array();

        $this->db->select('sale_id, SUM(total) as total', false);
        $this->db->from('sales_items_temp');
        $this->db->group_by('sale_id');

        foreach ($this->db->get()->result_array() as $sale_total_row) {
            $sales_totals[$sale_total_row['sale_id']] = $sale_total_row['total'];
        }

        return $sales_totals;
    }

    /**
     * added for cash register
     * insert a log for track_cash_log
     * @param array $data
     */
    function update_register_log($data) {
        $this->db->where('shift_end', '0000-00-00 00:00:00');
        $this->db->where('employee_id', $this->session->userdata('person_id'));
        return $this->db->update('register_log', $data) ? true : false;
    }

    function insert_register($data) {
        return $this->db->insert('register_log', $data) ? $this->db->insert_id() : false;
    }

    function is_register_log_open() {
        $this->db->from('register_log');
        $this->db->where('shift_end', '0000-00-00 00:00:00');
        $this->db->where('employee_id', $this->session->userdata('person_id'));
        $query = $this->db->get();
        if ($query->num_rows())
            return true;
        else
            return false;
    }

    function get_current_register_log() {
        $this->db->from('register_log');
        $this->db->where('shift_end', '0000-00-00 00:00:00');
        $this->db->where('employee_id', $this->session->userdata('person_id'));
        $query = $this->db->get();
        if ($query->num_rows())
            return $query->row();
        else
            return false;
    }

    function exists($sale_id) {
        $this->db->from('sales');
        $this->db->where('sale_id', $sale_id);
        $query = $this->db->get();

        return ($query->num_rows() == 1);
    }

    function update($sale_data, $sale_id) {
        $this->db->where('sale_id', $sale_id);
        $success = $this->db->update('sales', $sale_data);

        return $success;
    }

    //huyenlt^^
    function exists_sale_inventory($id_sale) {
        $this->db->from('sales_inventory');
        $this->db->where('id_sale', $id_sale);
        $query = $this->db->get();
        return ($query->num_rows() == 1);
    }

    function get_info_liability($sale_id) {
        $this->db->from('sales');
        $this->db->where('sale_id', $sale_id);
        return $this->db->get()->row()->liability;
    }

    function get_info_materials($sale_id) {
        $this->db->from('sales');
        $this->db->where('sale_id', $sale_id);
        return $this->db->get()->row()->materials;
    }

    function delete_sale($sale_id, $all_data = false) {
        $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;

        $this->db->select('item_id, quantity_purchased, stored_id, unit_item');
        $this->db->from('sales_items');
        $this->db->where('sale_id', $sale_id);

        foreach ($this->db->get()->result_array() as $sale_item_row) {
            $cur_item_info = $this->Item->get_info($sale_item_row['item_id']);

            if ($sale_item_row['unit_item'] == $cur_item_info->unit_from) {//đơn vị sau quy đổi
                $quantity = $cur_item_info->quantity + $sale_item_row['quantity_purchased'];
                $quantity_total = $cur_item_info->quantity_total + $sale_item_row['quantity_purchased'];
                $quantity_kho = $sale_item_row['quantity_purchased'];
            } else {//đơn vị trước quy đổi hoặc ko quy đổi đơn vị
                $unit_rate = $cur_item_info->unit_rate != 0 ? $cur_item_info->unit_rate : 1;

                $quantity = $cur_item_info->quantity + $sale_item_row['quantity_purchased'] * $unit_rate;
                $quantity_total = $cur_item_info->quantity_total + $sale_item_row['quantity_purchased'] * $unit_rate;
                $quantity_kho = $sale_item_row['quantity_purchased'] * $unit_rate;
            }
            if ($sale_item_row['stored_id'] == 0) {//kho tong
                $item_data = array(
                    'quantity' => $quantity,
                    'quantity_total' => $quantity_total
                );
                $this->Item->save($item_data, $sale_item_row['item_id']);
            } else {//kho #
                $item_data = array(
                    'quantity' => $quantity
                );
                $this->Item->save($item_data, $sale_item_row['item_id']);

                $stores_items_db = $this->Item->get_Stores_Items($sale_item_row['item_id'], $sale_item_row['stored_id']);
                $item_data2 = array(
                    'quantity' => $stores_items_db->quantity + $quantity_kho,
                );
                $this->Item->saveStoresItems1221($item_data2, $stores_items_db->id);
            }
        }


        $this->db->select('pack_id, quantity_purchased');
        $this->db->from('sales_packs');
        $this->db->where('sale_id', $sale_id);

        foreach ($this->db->get()->result_array() as $sale_pack_row) {
            foreach ($this->Pack_items->get_info($sale_pack_row['pack_id']) as $pack_item) {
                $cur_item_info = $this->Item->get_info($pack_item->item_id);

                $item_data = array('quantity' => $cur_item_info->quantity + ($sale_pack_row['quantity_purchased'] * $pack_item->quantity),
                    'quantity_total' => $cur_item_info->quantity_total + ($sale_pack_row['quantity_purchased'] * $pack_item->quantity),
                );
                $this->Item->save($item_data, $pack_item->item_id);
            }
        }

        if ($all_data) {
            //Run these queries as a transaction, we want to make sure we do all or nothing
            $this->db->trans_start();
            $this->db->delete('sales_payments', array('sale_id' => $sale_id));
            $this->db->delete('sales_items_taxes', array('sale_id' => $sale_id));
            $this->db->delete('sales_items', array('sale_id' => $sale_id));
            $this->db->delete('sales_item_kits_taxes', array('sale_id' => $sale_id));
            $this->db->delete('sales_packs', array('sale_id' => $sale_id));
            $this->db->delete('inventory', array('trans_sale' => $sale_id));
            $this->db->trans_complete();
        }
        $this->db->where('sale_id', $sale_id);
        return $this->db->update('sales', array('deleted' => 1));
    }

    function delete_sale_materials($sale_id, $all_data = false) {
        $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;

        $this->db->select('item_id, quantity_purchased');
        $this->db->from('sales_items');
        $this->db->where('sale_id', $sale_id);

        foreach ($this->db->get()->result_array() as $sale_item_row) {
            $cur_item_info = $this->Item->get_info($sale_item_row['item_id']);

            if ($sale_item_row['unit_item'] == $cur_item_info->unit_from) {//đơn vị sau quy đổi
                $quantity = $cur_item_info->quantity + $sale_item_row['quantity_purchased'];
                $quantity_total = $cur_item_info->quantity_total + $sale_item_row['quantity_purchased'];
                $quantity_kho = $sale_item_row['quantity_purchased'];
            } else {//đơn vị trước quy đổi hoặc ko quy đổi đơn vị
                $unit_rate = $cur_item_info->unit_rate != 0 ? $cur_item_info->unit_rate : 1;

                $quantity = $cur_item_info->quantity + $sale_item_row['quantity_purchased'] * $unit_rate;
                $quantity_total = $cur_item_info->quantity_total + $sale_item_row['quantity_purchased'] * $unit_rate;
                $quantity_kho = $sale_item_row['quantity_purchased'] * $unit_rate;
            }
            if ($sale_item_row['stored_id'] == 0) {//kho tong
                $item_data = array(
                    'quantity' => $quantity,
                    'quantity_total' => $quantity_total
                );
                $this->Item->save($item_data, $sale_item_row['item_id']);
            } else {//kho #
                $item_data = array(
                    'quantity' => $quantity
                );
                $this->Item->save($item_data, $sale_item_row['item_id']);

                $stores_items_db = $this->Item->get_Stores_Items($sale_item_row['item_id'], $sale_item_row['stored_id']);
                $item_data2 = array(
                    'quantity' => $stores_items_db->quantity + $quantity_kho,
                );
                $this->Item->saveStoresItems1221($item_data2, $stores_items_db->id);
            }
        }

        $this->db->select('pack_id, quantity_purchased');
        $this->db->from('sales_packs');
        $this->db->where('sale_id', $sale_id);

        foreach ($this->db->get()->result_array() as $sale_pack_row) {
            foreach ($this->Pack_items->get_info($sale_pack_row['pack_id']) as $pack_item) {
                $cur_item_info = $this->Item->get_info($pack_item->item_id);
                $item_data = array(
                    'quantity' => $cur_item_info->quantity,
                    'quantity_total' => $cur_item_info->quantity_total,
                );
                $this->Item->save($item_data, $pack_item->item_id);
            }
        }

        if ($all_data) {
            //Run these queries as a transaction, we want to make sure we do all or nothing
            $this->db->trans_start();
            $this->db->delete('sales_payments', array('sale_id' => $sale_id));
            $this->db->delete('sales_items_taxes', array('sale_id' => $sale_id));
            $this->db->delete('sales_items', array('sale_id' => $sale_id));
            $this->db->delete('sales_item_kits_taxes', array('sale_id' => $sale_id));
            $this->db->delete('sales_packs', array('sale_id' => $sale_id));
            $this->db->delete('inventory', array('trans_sale' => $sale_id));
            $this->db->trans_complete();
        }
        $this->db->where('sale_id', $sale_id);
        return $this->db->update('sales', array('deleted' => 0,'suspended' => 1,'materials' => 0));
    }

    function delete($sale_id, $all_data = false) {
        $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;

        $this->db->select('item_id,quantity_purchased,stored_id');
        $this->db->from('sales_items');
        $this->db->where('sale_id', $sale_id);

        foreach ($this->db->get()->result_array() as $sale_item_row) {
            $cur_item_info = $this->Item->get_info($sale_item_row['item_id']);
            $warehouse_items = array(
                'warehouse_id' => $sale_item_row['stored_id'],
                'item_id' => $sale_item_row['item_id'],
                'quantity' => $sale_item_row['quantity_purchased']
            );


            $stores_items_db = $this->Item->get_Stores_Items($sale_item_row['item_id'], $sale_item_row['stored_id']);


            if (!$stores_items_db) {
                //Update stock quantity
                $item_data = array('quantity' => $cur_item_info->quantity + $sale_item_row['quantity_purchased'],
                    'quantity_total' => $cur_item_info->quantity_total + $sale_item_row['quantity_purchased']);
                $this->Item->save($item_data, $sale_item_row['item_id']);
            } else {

                $item_data = array('quantity' => $cur_item_info->quantity + $sale_item_row['quantity_purchased']);
                $this->Item->save($item_data, $sale_item_row['item_id']);
                $warehouse_items['quantity'] = $stores_items_db->quantity + $sale_item_row['quantity_purchased'];
                $this->Item->saveStoresItems1221($warehouse_items, $stores_items_db->id);
            }
            //$item_data = array('quantity'=>$cur_item_info->quantity + $sale_item_row['quantity_purchased']);
            //$this->Item->save($item_data,$sale_item_row['item_id']);

            $sale_remarks = 'POS ' . $sale_id;
            // $inv_data = array
            // (
            // 'trans_date'=>date('Y-m-d H:i:s'),
            // 'trans_items'=>$sale_item_row['item_id'],
            // 'trans_user'=>$employee_id,
            // 'trans_comment'=>$sale_remarks,
            // 'trans_inventory'=>$sale_item_row['quantity_purchased']
            // );
            // $this->Inventory->insert($inv_data);
        }

        $this->db->select('item_kit_id, quantity_purchased');
        $this->db->from('sales_item_kits');
        $this->db->where('sale_id', $sale_id);

        foreach ($this->db->get()->result_array() as $sale_item_kit_row) {
            foreach ($this->Item_kit_items->get_info($sale_item_kit_row['item_kit_id']) as $item_kit_item) {
                $cur_item_info = $this->Item->get_info($item_kit_item->item_id);

                $item_data = array('quantity' => $cur_item_info->quantity + ($sale_item_kit_row['quantity_purchased'] * $item_kit_item->quantity),
                    'quantity_total' => $cur_item_info->quantity + ($sale_item_kit_row['quantity_purchased'] * $item_kit_item->quantity_total));
                $this->Item->save($item_data, $item_kit_item->item_id);

                $sale_remarks = 'POS ' . $sale_id;
                $inv_data = array
                    (
                    'trans_date' => date('Y-m-d H:i:s'),
                    'trans_items' => $item_kit_item->item_id,
                    'trans_user' => $employee_id,
                    'trans_comment' => $sale_remarks,
                    'trans_inventory' => $sale_item_kit_row['quantity_purchased'] * $item_kit_item->quantity
                );
                $this->Inventory->insert($inv_data);
            }
        }

        if ($all_data) {
            //Run these queries as a transaction, we want to make sure we do all or nothing
            $this->db->trans_start();
            $this->db->delete('sales_payments', array('sale_id' => $sale_id));
            $this->db->delete('sales_items_taxes', array('sale_id' => $sale_id));
            $this->db->delete('sales_items', array('sale_id' => $sale_id));
            $this->db->delete('sales_item_kits_taxes', array('sale_id' => $sale_id));
            $this->db->delete('sales_item_kits', array('sale_id' => $sale_id));
            $this->db->trans_complete();
        }
        $this->db->where('sale_id', $sale_id);
        return $this->db->update('sales', array('deleted' => 1));
    }

    function delete_web($order_id) {
        //if ($all_data)
        //{
        //Run these queries as a transaction, we want to make sure we do all or nothing
        //	$this->db->trans_start();
        $this->db->where('order_id', $order_id);
        $this->db->delete('omc_order_item');
        $this->db->where('order_id', $order_id);
        $this->db->delete('omc_order');
        //$this->db->delete('sales_item_kits', array('sale_id' => $sale_id));
        //	$this->db->trans_complete();
        //}
        //$this->db->where('order_id', $order_id);
        //return $this->db->update('omc_order',array('payment_date' => '2013-12-04 00:00:00' ));
    }

    function undelete($sale_id) {
        $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;

        $this->db->select('item_id, quantity_purchased');
        $this->db->from('sales_items');
        $this->db->where('sale_id', $sale_id);

        foreach ($this->db->get()->result_array() as $sale_item_row) {
            $cur_item_info = $this->Item->get_info($sale_item_row['item_id']);
            $item_data = array('quantity' => $cur_item_info->quantity - $sale_item_row['quantity_purchased']);
            $this->Item->save($item_data, $sale_item_row['item_id']);

            $sale_remarks = 'POS ' . $sale_id;
            $inv_data = array
                (
                'trans_date' => date('Y-m-d H:i:s'),
                'trans_items' => $sale_item_row['item_id'],
                'trans_user' => $employee_id,
                'trans_comment' => $sale_remarks,
                'trans_inventory' => -$sale_item_row['quantity_purchased']
            );
            $this->Inventory->insert($inv_data);
        }

        $this->db->select('item_kit_id, quantity_purchased');
        $this->db->from('sales_item_kits');
        $this->db->where('sale_id', $sale_id);

        foreach ($this->db->get()->result_array() as $sale_item_kit_row) {
            foreach ($this->Item_kit_items->get_info($sale_item_kit_row['item_kit_id']) as $item_kit_item) {
                $cur_item_info = $this->Item->get_info($item_kit_item->item_id);

                $item_data = array('quantity' => $cur_item_info->quantity - ($sale_item_kit_row['quantity_purchased'] * $item_kit_item->quantity));
                $this->Item->save($item_data, $item_kit_item->item_id);

                $sale_remarks = 'POS ' . $sale_id;
                $inv_data = array
                    (
                    'trans_date' => date('Y-m-d H:i:s'),
                    'trans_items' => $item_kit_item->item_id,
                    'trans_user' => $employee_id,
                    'trans_comment' => $sale_remarks,
                    'trans_inventory' => -$sale_item_kit_row['quantity_purchased'] * $item_kit_item->quantity
                );
                $this->Inventory->insert($inv_data);
            }
        }
        $this->db->where('sale_id', $sale_id);
        return $this->db->update('sales', array('deleted' => 0));
    }

    function get_sale_items($sale_id) {
        $this->db->from('sales_items');
        $this->db->where('sale_id', $sale_id);
        return $this->db->get();
    }

    function get_sale_item_kits($sale_id) {
        $this->db->from('sales_item_kits');
        $this->db->where('sale_id', $sale_id);
        return $this->db->get();
    }

    function get_sale_items_taxes($sale_id) {
        $query = $this->db->query('SELECT name, percent, cumulative, item_unit_price as price, quantity_purchased as quantity, discount_percent as discount ' .
                'FROM ' . $this->db->dbprefix('sales_items_taxes') . ' JOIN ' .
                $this->db->dbprefix('sales_items') . ' USING (sale_id, item_id, line) WHERE ' . $this->db->dbprefix('sales_items_taxes') . ".sale_id = $sale_id");
        return $query->result_array();
    }

    function get_sale_item_kits_taxes($sale_id) {
        $query = $this->db->query('SELECT name, percent, cumulative, item_kit_unit_price as price, quantity_purchased as quantity, discount_percent as discount ' .
                'FROM ' . $this->db->dbprefix('sales_item_kits_taxes') . ' JOIN ' .
                $this->db->dbprefix('sales_item_kits') . ' USING (sale_id, item_kit_id, line) WHERE ' . $this->db->dbprefix('sales_item_kits_taxes') . ".sale_id = $sale_id");
        return $query->result_array();
    }

    function get_sale_payments($sale_id) {
        $this->db->from('sales_payments');
        $this->db->where('sale_id', $sale_id);

        return $this->db->get();
    }

    function get_customer($sale_id) {
        $this->db->from('sales');
        $this->db->where('sale_id', $sale_id);
        return $this->Customer->get_info($this->db->get()->row()->customer_id);
    }

    function get_comment($sale_id) {
        $this->db->from('sales');
        $this->db->where('sale_id', $sale_id);
        return $this->db->get()->row()->comment;
    }

    function get_employees_id($sale_id) {
        $this->db->from('sales');
        $this->db->where('sale_id', $sale_id);
        return $this->db->get()->row()->employees_id;
    }

    function get_sale_id($sale_id) {
        $this->db->from('sales');
        $this->db->where('sale_id', $sale_id);
        return $this->db->get()->row()->sale_id;
    }

    function get_sale_id_liability($sale_id) {
        $this->db->from('sales');
        $this->db->where('sale_id', $sale_id);
        return $this->db->get()->row()->liability;
    }

    function get_sale_id_suspended($sale_id) {
        $this->db->from('sales');
        $this->db->where('sale_id', $sale_id);
        return $this->db->get()->row()->suspended;
    }

    function get_date_debt($sale_id) {
        $this->db->from('sales');
        $this->db->where('sale_id', $sale_id);
        return $this->db->get()->row()->date_debt;
    }

    function get_date_debt1($sale_id) {
        $this->db->from('sales');
        $this->db->where('sale_id', $sale_id);
        return $this->db->get()->row()->date_debt1;
    }

     function get_symbol_order($sale_id) {
        $this->db->from('sales');
        $this->db->where('sale_id', $sale_id);
        return $this->db->get()->row()->symbol_order;
    }

     function get_number_order($sale_id) {
        $this->db->from('sales');
        $this->db->where('sale_id', $sale_id);
        return $this->db->get()->row()->number_order;
    }


    function get_employees_delivery($sale_id) {
        $this->db->from('sales');
        $this->db->where('sale_id', $sale_id);
        return $this->db->get()->row()->delivery_employee;
    }

    function get_comment_on_receipt($sale_id) {
        $this->db->from('sales');
        $this->db->where('sale_id', $sale_id);
        return $this->db->get()->row()->show_comment_on_receipt;
    }

    function get_comment_on_receipt_web($order_id) {
        $this->db->from('omc_order');
        $this->db->where('order_id', $order_id);
        return $this->db->get()->row()->get_comment_on_receipt_web;
    }

    public function create_sales_items_temp_table123($params) {
        $where = '';

        if (isset($params['start_date']) && isset($params['end_date'])) {
            $where = 'WHERE sale_time BETWEEN "' . $params['start_date'] . '" and "' . $params['end_date'] . '"';

            if ($this->config->item('hide_suspended_sales_in_reports')) {
                $where .=' and suspended = 0';
            }
        } elseif ($this->config->item('hide_suspended_sales_in_reports')) {
            $where .='WHERE suspended = 0';
        }

        $this->_create_sales_items_temp_table_query($where);
    }

    function _create_sales_items_temp_table_query123($where) {
        $this->db->query("CREATE TEMPORARY TABLE " . $this->db->dbprefix('sales_items_temp') . "
		(SELECT " . $this->db->dbprefix('sales') . ".deleted as deleted, sale_time, date(sale_time) as sale_date, " . $this->db->dbprefix('sales_items') . ".sale_id, comment,payment_type, customer_id, employee_id,
		" . $this->db->dbprefix('items') . ".item_id, NULL as item_kit_id, supplier_id, quantity_purchased, item_cost_price, item_unit_price, category,
		discount_percent, (item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100) as subtotal,
		" . $this->db->dbprefix('sales_items') . ".line as line, serialnumber, " . $this->db->dbprefix('sales_items') . ".description as description,
		ROUND((item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100)+ROUND((item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100)*(SUM(CASE WHEN cumulative != 1 THEN percent ELSE 0 END)/100),2)
		+((ROUND((item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100)*(SUM(CASE WHEN cumulative != 1 THEN percent ELSE 0 END)/100),2) + (item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100))
		*(SUM(CASE WHEN cumulative = 1 THEN percent ELSE 0 END))/100),2) as total,
		ROUND((item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100)*(SUM(CASE WHEN cumulative != 1 THEN percent ELSE 0 END)/100),2)
		+((ROUND((item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100)*(SUM(CASE WHEN cumulative != 1 THEN percent ELSE 0 END)/100),2) + (item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100))
		*(SUM(CASE WHEN cumulative = 1 THEN percent ELSE 0 END))/100) as tax,
		(item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100) - (item_cost_price*quantity_purchased) as profit
		FROM " . $this->db->dbprefix('sales_items') . "
		INNER JOIN " . $this->db->dbprefix('sales') . " ON  " . $this->db->dbprefix('sales_items') . '.sale_id=' . $this->db->dbprefix('sales') . '.sale_id' . "
		INNER JOIN " . $this->db->dbprefix('items') . " ON  " . $this->db->dbprefix('sales_items') . '.item_id=' . $this->db->dbprefix('items') . '.item_id' . "
		LEFT OUTER JOIN " . $this->db->dbprefix('suppliers') . " ON  " . $this->db->dbprefix('items') . '.supplier_id=' . $this->db->dbprefix('suppliers') . '.person_id' . "
		LEFT OUTER JOIN " . $this->db->dbprefix('sales_items_taxes') . " ON  "
                . $this->db->dbprefix('sales_items') . '.sale_id=' . $this->db->dbprefix('sales_items_taxes') . '.sale_id' . " and "
                . $this->db->dbprefix('sales_items') . '.item_id=' . $this->db->dbprefix('sales_items_taxes') . '.item_id' . " and "
                . $this->db->dbprefix('sales_items') . '.line=' . $this->db->dbprefix('sales_items_taxes') . '.line' . "
		$where
		GROUP BY sale_id, item_id, line)
		UNION ALL
		(SELECT " . $this->db->dbprefix('sales') . ".deleted as deleted, sale_time, date(sale_time) as sale_date, " . $this->db->dbprefix('sales_item_kits') . ".sale_id, comment,payment_type, customer_id, employee_id,
		NULL as item_id, " . $this->db->dbprefix('item_kits') . ".item_kit_id, '' as supplier_id, quantity_purchased, item_kit_cost_price, item_kit_unit_price, category,
		discount_percent, (item_kit_unit_price*quantity_purchased-item_kit_unit_price*quantity_purchased*discount_percent/100) as subtotal,
		" . $this->db->dbprefix('sales_item_kits') . ".line as line, '' as serialnumber, " . $this->db->dbprefix('sales_item_kits') . ".description as description,
		ROUND((item_kit_unit_price*quantity_purchased-item_kit_unit_price*quantity_purchased*discount_percent/100)+ROUND((item_kit_unit_price*quantity_purchased-item_kit_unit_price*quantity_purchased*discount_percent/100)*(SUM(CASE WHEN cumulative != 1 THEN percent ELSE 0 END)/100),2)
		+((ROUND((item_kit_unit_price*quantity_purchased-item_kit_unit_price*quantity_purchased*discount_percent/100)*(SUM(CASE WHEN cumulative != 1 THEN percent ELSE 0 END)/100),2) + (item_kit_unit_price*quantity_purchased-item_kit_unit_price*quantity_purchased*discount_percent/100))
		*(SUM(CASE WHEN cumulative = 1 THEN percent ELSE 0 END))/100),2) as total,
		ROUND((item_kit_unit_price*quantity_purchased-item_kit_unit_price*quantity_purchased*discount_percent/100)*(SUM(CASE WHEN cumulative != 1 THEN percent ELSE 0 END)/100),2)
		+((ROUND((item_kit_unit_price*quantity_purchased-item_kit_unit_price*quantity_purchased*discount_percent/100)*(SUM(CASE WHEN cumulative != 1 THEN percent ELSE 0 END)/100),2) + (item_kit_unit_price*quantity_purchased-item_kit_unit_price*quantity_purchased*discount_percent/100))
		*(SUM(CASE WHEN cumulative = 1 THEN percent ELSE 0 END))/100) as tax,
		(item_kit_unit_price*quantity_purchased-item_kit_unit_price*quantity_purchased*discount_percent/100) - (item_kit_cost_price*quantity_purchased) as profit
		FROM " . $this->db->dbprefix('sales_item_kits') . "
		INNER JOIN " . $this->db->dbprefix('sales') . " ON  " . $this->db->dbprefix('sales_item_kits') . '.sale_id=' . $this->db->dbprefix('sales') . '.sale_id' . "
		INNER JOIN " . $this->db->dbprefix('item_kits') . " ON  " . $this->db->dbprefix('sales_item_kits') . '.item_kit_id=' . $this->db->dbprefix('item_kits') . '.item_kit_id' . "
		LEFT OUTER JOIN " . $this->db->dbprefix('sales_item_kits_taxes') . " ON  "
                . $this->db->dbprefix('sales_item_kits') . '.sale_id=' . $this->db->dbprefix('sales_item_kits_taxes') . '.sale_id' . " and "
                . $this->db->dbprefix('sales_item_kits') . '.item_kit_id=' . $this->db->dbprefix('sales_item_kits_taxes') . '.item_kit_id' . " and "
                . $this->db->dbprefix('sales_item_kits') . '.line=' . $this->db->dbprefix('sales_item_kits_taxes') . '.line' . "
		$where
		GROUP BY sale_id, item_kit_id, line) ORDER BY sale_id, line");
    }

    //We create a temp table that allows us to do easy report/sales queries
    public function create_sales_items_temp_table($params) {
        $where = '';

        if (isset($params['start_date']) && isset($params['end_date'])) {
            $where = 'WHERE sale_time BETWEEN "' . $params['start_date'] . '" and "' . $params['end_date'] . '" and materials = 0 and liability = 0';

            if ($this->config->item('hide_suspended_sales_in_reports')) {
                $where .=' and suspended = 0';
            }
        } elseif ($this->config->item('hide_suspended_sales_in_reports')) {
            $where .='WHERE suspended = 0';
        }
        $this->_create_sales_items_temp_table_query($where);
    }

    //hung audi 21-4-15
    public function create_sales_items_temp_table2($params) {
        $where = '';

        if (isset($params['start_date']) && isset($params['end_date'])) {
            $where = 'WHERE sale_time BETWEEN "' . $params['start_date'] . '" and "' . $params['end_date'] . '" and materials != 1';

            if ($this->config->item('hide_suspended_sales_in_reports')) {
                $where .=' and suspended = 0';
            }
        } elseif ($this->config->item('hide_suspended_sales_in_reports')) {
            $where .='WHERE suspended = 0';
        }
        $this->_create_sales_items_temp_table_query($where);
    }

    public function create_sales_items_temp_table3($params) {
        $where = '';

        if (isset($params['start_date']) && isset($params['end_date'])) {
            $where = 'WHERE sale_time BETWEEN "' . $params['start_date'] . '" and "' . $params['end_date'] . '" and materials != 1 and liability != 1';

            if ($this->config->item('hide_suspended_sales_in_reports')) {
                $where .=' and suspended = 0';
            }
        } elseif ($this->config->item('hide_suspended_sales_in_reports')) {
            $where .='WHERE suspended = 0';
        }
        $this->_create_sales_items_temp_table_query($where);
    }

    function _create_sales_items_temp_table_query($where) {
        $this->db->query("CREATE TEMPORARY TABLE " . $this->db->dbprefix('sales_items_temp') . "
		(SELECT " . $this->db->dbprefix('sales') . ".deleted as deleted, materials, liability, sale_time, date(sale_time) as sale_date, " . $this->db->dbprefix('sales_items') . ".sale_id, comment,payment_type, customer_id, employee_id,
		" . $this->db->dbprefix('items') . ".item_id, NULL as item_kit_id, supplier_id, quantity_purchased, item_cost_price, item_unit_price, category,
		discount_percent, (item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100) as subtotal,
		" . $this->db->dbprefix('sales_items') . ".line as line, serialnumber, " . $this->db->dbprefix('sales_items') . ".description as description,
		ROUND((item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100)+ROUND((item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100)*(SUM(CASE WHEN cumulative != 1 THEN percent ELSE 0 END)/100),2)
		+((ROUND((item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100)*(SUM(CASE WHEN cumulative != 1 THEN percent ELSE 0 END)/100),2) + (item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100))
		*(SUM(CASE WHEN cumulative = 1 THEN percent ELSE 0 END))/100),2) as total,
		ROUND((item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100)*(SUM(CASE WHEN cumulative != 1 THEN percent ELSE 0 END)/100),2)
		+((ROUND((item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100)*(SUM(CASE WHEN cumulative != 1 THEN percent ELSE 0 END)/100),2) + (item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100))
		*(SUM(CASE WHEN cumulative = 1 THEN percent ELSE 0 END))/100) as tax,
		(item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100) - (item_cost_price*quantity_purchased) as profit
		FROM " . $this->db->dbprefix('sales_items') . "
		INNER JOIN " . $this->db->dbprefix('sales') . " ON  " . $this->db->dbprefix('sales_items') . '.sale_id=' . $this->db->dbprefix('sales') . '.sale_id' . "
		INNER JOIN " . $this->db->dbprefix('items') . " ON  " . $this->db->dbprefix('sales_items') . '.item_id=' . $this->db->dbprefix('items') . '.item_id' . "
		LEFT OUTER JOIN " . $this->db->dbprefix('suppliers') . " ON  " . $this->db->dbprefix('items') . '.supplier_id=' . $this->db->dbprefix('suppliers') . '.person_id' . "
		LEFT OUTER JOIN " . $this->db->dbprefix('sales_items_taxes') . " ON  "
                . $this->db->dbprefix('sales_items') . '.sale_id=' . $this->db->dbprefix('sales_items_taxes') . '.sale_id' . " and "
                . $this->db->dbprefix('sales_items') . '.item_id=' . $this->db->dbprefix('sales_items_taxes') . '.item_id' . " and "
                . $this->db->dbprefix('sales_items') . '.line=' . $this->db->dbprefix('sales_items_taxes') . '.line' . "
		$where
		GROUP BY sale_id, item_id, line)
		UNION ALL
		(SELECT " . $this->db->dbprefix('sales') . ".deleted as deleted, materials, liability, sale_time, date(sale_time) as sale_date, " . $this->db->dbprefix('sales_item_kits') . ".sale_id, comment,payment_type, customer_id, employee_id,
		NULL as item_id, " . $this->db->dbprefix('item_kits') . ".item_kit_id, '' as supplier_id, quantity_purchased, item_kit_cost_price, item_kit_unit_price, category,
		discount_percent, (item_kit_unit_price*quantity_purchased-item_kit_unit_price*quantity_purchased*discount_percent/100) as subtotal,
		" . $this->db->dbprefix('sales_item_kits') . ".line as line, '' as serialnumber, " . $this->db->dbprefix('sales_item_kits') . ".description as description,
		ROUND((item_kit_unit_price*quantity_purchased-item_kit_unit_price*quantity_purchased*discount_percent/100)+ROUND((item_kit_unit_price*quantity_purchased-item_kit_unit_price*quantity_purchased*discount_percent/100)*(SUM(CASE WHEN cumulative != 1 THEN percent ELSE 0 END)/100),2)
		+((ROUND((item_kit_unit_price*quantity_purchased-item_kit_unit_price*quantity_purchased*discount_percent/100)*(SUM(CASE WHEN cumulative != 1 THEN percent ELSE 0 END)/100),2) + (item_kit_unit_price*quantity_purchased-item_kit_unit_price*quantity_purchased*discount_percent/100))
		*(SUM(CASE WHEN cumulative = 1 THEN percent ELSE 0 END))/100),2) as total,
		ROUND((item_kit_unit_price*quantity_purchased-item_kit_unit_price*quantity_purchased*discount_percent/100)*(SUM(CASE WHEN cumulative != 1 THEN percent ELSE 0 END)/100),2)
		+((ROUND((item_kit_unit_price*quantity_purchased-item_kit_unit_price*quantity_purchased*discount_percent/100)*(SUM(CASE WHEN cumulative != 1 THEN percent ELSE 0 END)/100),2) + (item_kit_unit_price*quantity_purchased-item_kit_unit_price*quantity_purchased*discount_percent/100))
		*(SUM(CASE WHEN cumulative = 1 THEN percent ELSE 0 END))/100) as tax,
		(item_kit_unit_price*quantity_purchased-item_kit_unit_price*quantity_purchased*discount_percent/100) - (item_kit_cost_price*quantity_purchased) as profit
		FROM " . $this->db->dbprefix('sales_item_kits') . "
		INNER JOIN " . $this->db->dbprefix('sales') . " ON  " . $this->db->dbprefix('sales_item_kits') . '.sale_id=' . $this->db->dbprefix('sales') . '.sale_id' . "
		INNER JOIN " . $this->db->dbprefix('item_kits') . " ON  " . $this->db->dbprefix('sales_item_kits') . '.item_kit_id=' . $this->db->dbprefix('item_kits') . '.item_kit_id' . "
		LEFT OUTER JOIN " . $this->db->dbprefix('sales_item_kits_taxes') . " ON  "
                . $this->db->dbprefix('sales_item_kits') . '.sale_id=' . $this->db->dbprefix('sales_item_kits_taxes') . '.sale_id' . " and "
                . $this->db->dbprefix('sales_item_kits') . '.item_kit_id=' . $this->db->dbprefix('sales_item_kits_taxes') . '.item_kit_id' . " and "
                . $this->db->dbprefix('sales_item_kits') . '.line=' . $this->db->dbprefix('sales_item_kits_taxes') . '.line' . "
		$where
		GROUP BY sale_id, item_kit_id, line) ORDER BY sale_id, line");
    }

    public function get_giftcard_value($giftcardNumber) {
        if (!$this->Giftcard->exists($this->Giftcard->get_giftcard_id($giftcardNumber)))
            return 0;

        $this->db->from('giftcards');
        $this->db->where('giftcard_number', $giftcardNumber);
        return $this->db->get()->row()->value;
    }

    //huyenlt^^
    function get_all_suspended() {
        $this->db->from('sales');
        $this->db->where('deleted', 0);
        $this->db->where('suspended', 1);
        $this->db->order_by('sale_id', desc);
        //$this->db->order_by('sale_id');
        return $this->db->get();
    }

    function get_all_materials() {
        $this->db->from('sales');
        $this->db->where('deleted', 0);
        $this->db->where('materials', 1);
        $this->db->order_by('sale_id', desc);
        //$this->db->order_by('sale_id');
        return $this->db->get();
    }

    function get_all_liability() {
        $this->db->from('sales');
        $this->db->where('deleted', 0);
        $this->db->where('liability', 1);
        $this->db->order_by('sale_id', desc);
        return $this->db->get();
    }

    //end huyenlt^^



    function get_all_suspended_web() {
        $this->db->from('sales');
        $this->db->where('deleted', 0);
        $this->db->where('liability', 1);
        $this->db->where('sale_status', 1);
        $this->db->order_by('sale_id', desc);
        return $this->db->get();
    }

//gianghong^^
    function get_sale_item_by_sale_id($id) {
        $this->db->select('s.*,i.name,i.unit_from as unit_from,i.unit as unit, i.unit_rate as unit_rate, i.taxes');
        $this->db->from('sales_items s');
        $this->db->join('items i', 'i.item_id=s.item_id', 'inner');
        $this->db->where('s.sale_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    //gianghong^^
    function get_sale_item_by_sale_id3($id, $service) {
        if ($service == 0) {
            $this->db->select('s.*,i.name,i.unit_from as unit_from,i.unit as unit, i.unit_rate as unit_rate, i.taxes');
            $this->db->from('sales_items s');
            $this->db->join('items i', 'i.item_id=s.item_id', 'inner');
            $this->db->where('s.sale_id', $id);
            $this->db->where('i.service', 0);
            $query = $this->db->get();
        } else if ($service == 1) {
            $this->db->select('s.*,i.name,i.unit_from as unit_from,i.unit as unit, i.unit_rate as unit_rate, i.taxes');
            $this->db->from('sales_items s');
            $this->db->join('items i', 'i.item_id=s.item_id', 'inner');
            $this->db->where('s.sale_id', $id);
            $this->db->where('i.service', 1);
            $query = $this->db->get();
        } else {
            $this->db->select('s.*,i.name,i.unit_from as unit_from,i.unit as unit, i.unit_rate as unit_rate, i.taxes');
            $this->db->from('sales_items s');
            $this->db->join('items i', 'i.item_id=s.item_id', 'inner');
            $this->db->where('s.sale_id', $id);
            $query = $this->db->get();
        }

        return $query->result_array();
    }

    function get_sale_item_kit_by_sale_id($id) {
//        $this->db->select('k.item_kit_id as item_id,k.item_kit_unit_price as item_unit_price,i.category as donvi,k.quantity_purchased,i.name,discount_percent');
        $this->db->from('sales_packs k');
        $this->db->join('packs i', 'k.pack_id = i.pack_id', 'inner');
        $this->db->where('k.sale_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    //
    function get_money_item($item_id, $sale_id) {
        $this->db->select('item_id,discount_percent');
        $this->db->from('sales_items');
        $this->db->where('item_id', $item_id);
        $this->db->where('sale_id', $sale_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_money_item_kit($item_id, $sale_id) {
        $this->db->select('item_kit_id,discount_percent');
        $this->db->from('sales_item_kits');
        $this->db->where('item_kit_id', $item_id);
        $this->db->where('sale_id', $sale_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    //
    function get_tax_item($item_id, $sale_id) {
        $this->db->select('item_id,percent');
        $this->db->from('sales_items_taxes');
        $this->db->where('item_id', $item_id);
        $this->db->where('sale_id', $sale_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_tax_item_kit($item_id, $sale_id) {
        $this->db->select('item_kit_id,percent');
        $this->db->from('sales_item_kits_taxes');
        $this->db->where('item_kit_id', $item_id);
        $this->db->where('sale_id', $sale_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sale_owe_by_customer($customer_id, $start_date, $end_date) {
        $this->db->select('*');
        $this->db->from('sales');
        $this->db->where('customer_id', $customer_id);
        $this->db->where('deleted', 0);
        $this->db->where('sale_time >=', $start_date);
        $this->db->where('sale_time <=', $end_date);
        $this->db->where('suspended', 1);
        $data_array[] = $this->db->get()->result_array();

        $this->db->select('*');
        $this->db->from('sales');
        $this->db->where('customer_id', $customer_id);
        $this->db->where('deleted', 0);
        $this->db->where('sale_time >=', $start_date);
        $this->db->where('sale_time <=', $end_date);
        $this->db->where('liability', 1);
        $data_array[] = $this->db->get()->result_array();
//        var_dump($this->db->last_query());exit();
        return $data_array;
    }

    function get_sales_tam_by_date($start_date, $end_date, $sale_id) {
        $this->db->select('s.*,p.first_name');
        $this->db->from('sales_tam s');
        $this->db->join('people p', 's.employees_id=p.person_id', 'inner');

        $this->db->where('s.date_tam >=', $start_date);
        $this->db->where('s.date_tam <=', $end_date);
        $this->db->where('s.id_sale', $sale_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sales_tam($sale_id) {
        $this->db->select('*');
        $this->db->from('sales_tam');
        $this->db->where('id_sale', $sale_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    /* giang 11/6/2014 */

    //huyen
//trả hàng về
    function get_sale_by_detail_trave() {
        $this->db->select('sale_id');
        $this->db->from('sales');
        //$this->db->where('employee_id', $employee_id);
        $this->db->where('later_cost_price < 0');
        $query = $this->db->get();
        //var_dump($this->db->last_query());exit();
        return $query->result_array();
    }

    //các đơn hàng bán
    function get_sale_by_detail() {
        $this->db->select('sale_id');
        $this->db->from('sales');
        //$this->db->where('employee_id', $employee_id);
        $this->db->where('later_cost_price >= 0');
        $query = $this->db->get();
        //var_dump($this->db->last_query());exit();
        return $query->result_array();
    }

    //all các đơn hàng
    function get_sale_by_detail_all() {
        $this->db->select('sale_id');
        $this->db->from('sales');
        $query = $this->db->get();
        //var_dump($this->db->last_query());exit();
        return $query->result_array();
    }

    //end

    function get_sales_tam_by_date_detail_sale_revenue($start_date, $end_date, $sale_id) {
        $this->db->select('s.*,p.first_name as first_name, pe.first_name as first_name1,p.last_name as last_name, pe.last_name as last_name1,sa.comment as comment,sa.liability');
        $this->db->from('sales_tam s');
        $this->db->join('sales sa', 'sa.sale_id=s.id_sale', 'inner');
        $this->db->join('people p', 'sa.customer_id=p.person_id', 'left');
        $this->db->join('people pe', 'sa.employee_id=pe.person_id', 'left');
        $this->db->where('sa.liability', 0);
        $this->db->where('s.date_tam >=', $start_date);
        $this->db->where('s.date_tam <=', $end_date);
        $this->db->where('s.id_sale', $sale_id);
        //$this->db->where('sa.sale_id', $sale_id);

        $query = $this->db->get();
        //var_dump($this->db->last_query());exit();
        return $query->result_array();
    }

    function get_sales_tam_by_date_detail_sale($start_date, $end_date, $sale_id) {
        $this->db->select('s.*, p.first_name as first_name, pe.first_name as first_name1,
        	p.last_name as last_name, pe.last_name as last_name1,sa.comment as comment,sa.liability');
        $this->db->from('sales_tam s');
        $this->db->join('sales sa', 'sa.sale_id=s.id_sale', 'inner');
        $this->db->join('people p', 'sa.customer_id=p.person_id', 'left');
        $this->db->join('people pe', 'sa.employee_id=pe.person_id', 'left');
        $this->db->where('s.date_tam >=', $start_date);
        $this->db->where('s.date_tam <=', $end_date);
        $this->db->where('s.id_sale', $sale_id);
        $query = $this->db->get();
        return $query->result_array();
    }

//huyenlt^^
    function get_sale_by_employee($employee_id, $service) {
        if ($service == 0) {
            $this->db->select('sales.sale_id as sale_id');
            $this->db->from('sales');
            $this->db->join('sales_items si', 'sales.sale_id=si.sale_id');
            $this->db->join('items', 'si.item_id=items.item_id');
            $this->db->where('employee_id', $employee_id);
            $this->db->where('items.service', 0);
        } elseif ($service == 1) {
            $this->db->select('sales.sale_id as sale_id');
            $this->db->from('sales');
            $this->db->join('sales_items si', 'sales.sale_id=si.sale_id');
            $this->db->join('items', 'si.item_id=items.item_id');
            $this->db->where('employee_id', $employee_id);
            $this->db->where('items.service', 1);
        } else {
            $this->db->select('sales.sale_id as sale_id');
            $this->db->from('sales');
            $this->db->join('sales_items si', 'sales.sale_id=si.sale_id');
            $this->db->join('items', 'si.item_id=items.item_id');
            $this->db->where('employee_id', $employee_id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sales_tam_by_date_detail_nocustomer($start_date, $end_date, $sale_id) {
        $this->db->select('s.*,pe.first_name as first_name1,sa.comment as comment,sa.liability');
        $this->db->from('sales_tam s');
        $this->db->join('sales sa', 'sa.sale_id=s.id_sale', 'inner');
        //$this->db->join('people p','sa.customer_id=p.person_id','inner');
        $this->db->join('people pe', 'sa.employee_id=pe.person_id', 'inner');
        $this->db->where('sa.liability <>', 1);
        $this->db->where('s.date_tam >=', $start_date);
        $this->db->where('s.date_tam <=', $end_date);
        $this->db->where('s.id_sale', $sale_id);
        $query = $this->db->get();
        //var_dump($this->db->last_query());exit();
        return $query->result_array();
    }

    function get_payment_sale_by_sale_id($sale_id) {
        $this->db->select('payment_amount,sale_id,discount_money,payment_type');
        $this->db->from('sales_payments');
        $this->db->where('sale_id', $sale_id);
        //$this->db->where('stt',0);
        $query = $this->db->get();
        return $query->result_array();
    }



    function get_payment_receiving_by_receiving_id($sale_id) {
        $this->db->select('payment_amount,receiving_id,discount_money,payment_type');
        $this->db->from('receivings_payments');
        $this->db->where('receiving_id', $sale_id);
        $query = $this->db->get();
        return $query->result_array();
    }

     function get_tam_receiving_by_receiving_id($sale_id) {
        $this->db->select('pays_amount,id_receiving,discount_money,pays_type');
        $this->db->from('receivings_tam');
        $this->db->where('id_receiving', $sale_id);
        $query = $this->db->get();
        return $query->result_array();
    }

     function get_payment_sale_by_sale_id1($sale_id) {
        $this->db->select('payment_amount,sale_id,discount_money,payment_type');
        $this->db->from('sales_payments');
        $this->db->where('sale_id', $sale_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function insert_sales_tam($data) {
        return ($this->db->insert('sales_tam', $data)) ? $this->db->insert_id() : false;
    }

    function insert_payment_sale($data) {
        return ($this->db->insert('sales_payments', $data)) ? $this->db->insert_id : false;
    }

    function update_suspend($sale_id, $data) {
        $this->db->where('sale_id', $sale_id);
        $this->db->update('sales', $data);
    }

    function insert_cost($data) {
        return ($this->db->insert('costs', $data)) ? $this->db->insert_id() : false;
    }

    function get_payment_sale($sale_id) {
        $this->db->select('payment_amount,sale_id');
        $this->db->from('sales_payments');
        $this->db->where('sale_id', $sale_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function insert_thutrano($data) {
        return ($this->db->insert('thutrano', $data)) ? $this->db->insert_id() : false;
    }

    function get_sales($sale_id) {
        $this->db->select('*');
        $this->db->from('sales');
        $this->db->where('sale_id', $sale_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function get_sale_by_customer($customer_id) {
        $this->db->select('sale_id');
        $this->db->from('sales');
        $this->db->where('customer_id', $customer_id);
//        $this->db->where('liability <> 1');
        $this->db->where('deleted', 0);
        $query = $this->db->get();
//        var_dump($this->db->last_query());exit();
        return $query->result_array();
    }

    function get_sales_tam_by_date_detail($start_date, $end_date, $sale_id) {
        $this->db->select('s.*,p.first_name as first_name, pe.first_name as first_name1,sa.comment as comment,sa.liability');
        $this->db->from('sales_tam s');
        $this->db->join('sales sa', 'sa.sale_id=s.id_sale', 'inner');
        $this->db->join('people p', 'sa.customer_id=p.person_id', 'inner');
        $this->db->join('people pe', 'sa.employee_id=pe.person_id', 'inner');
        $this->db->where('s.date_tam >=', $start_date);
        $this->db->where('s.date_tam <=', $end_date);
        $this->db->where('s.id_sale', $sale_id);
        $query = $this->db->get();
        //var_dump($this->db->last_query());exit();
        return $query->result_array();
    }

    //strart kho san pham items_kits
    function get_sale_by_stored_sales_item_kits($start_date, $end_date) {
        $this->db->select('sik.sale_id,sik.item_kit_id,sik.description,sik.quantity_purchased, sik.item_kit_cost_price,sik.item_kit_unit_price as item_unit_price,sik.discount_percent as discount_percent,i.name,s.sale_time,ik.percent as percent');
        $this->db->from('sales s');
        $this->db->join('sales_item_kits sik', 's.sale_id=sik.sale_id', 'inner');
        $this->db->join('item_kits i', 'i.item_kit_id=sik.item_kit_id', 'inner');
        $this->db->join('item_kits_taxes ik', 'i.item_kit_id=ik.item_kit_id', 'left');

        $this->db->where('s.sale_time >=', $start_date);
        $this->db->where('s.sale_time <=', $end_date);
        // $this->db->where('si.stored_id', $stored_id);
        $query = $this->db->get();
        //var_dump($this->db->last_query());exit();
        return $query->result_array();
    }

    //end kho sp item_kits
    //kho tổng
    function get_sale_by_stored_tong($start_date, $end_date, $stored_id) {
        // $this->db->select('si.*,i.name,p.first_name as first_name');
        $this->db->select('si.*,i.name,it.percent as percent');
        $this->db->from('sales_items si');
        $this->db->join('items i', 'i.item_id=si.item_id', 'inner');
        $this->db->join('items_taxes it', 'i.item_id=it.item_id', 'left');
        $this->db->where('si.stored_id', 0);
        $this->db->where('si.date >=', $start_date);
        $this->db->where('si.date <=', $end_date);

        $query = $this->db->get();
        //var_dump($this->db->last_query());exit();
        return $query->result_array();
    }

    //end kho tổng
    //lấy theo từng kho
    function get_sale_by_stored($start_date, $end_date, $stored_id) {
        // $this->db->select('si.*,i.name,p.first_name as first_name');
        $this->db->select('si.*,i.name,it.percent as percent');
        $this->db->from('sales_items si');
        $this->db->join('items i', 'i.item_id=si.item_id', 'inner');
        $this->db->join('items_taxes it', 'i.item_id=it.item_id', 'left');
        $this->db->where('si.stored_id', $stored_id);
        $this->db->where('si.date >=', $start_date);
        $this->db->where('si.date <=', $end_date);

        $query = $this->db->get();
        //var_dump($this->db->last_query());exit();
        return $query->result_array();
    }

    //kho all các kho

    function get_sale_by_stored_total($start_date, $end_date) {
        //$this->db->select('si.*,i.name,p.first_name as first_name');
        $this->db->select('si.*,i.name,it.percent as percent');
        $this->db->from('sales_items si');
        $this->db->join('sales s', 's.sale_id = si.sale_id', 'inner');
        $this->db->join('items i', 'i.item_id=si.item_id', 'inner');
        $this->db->join('items_taxes it', 'i.item_id=it.item_id', 'left');
        $this->db->where('si.date >=', $start_date);
        $this->db->where('si.date <=', $end_date);
        $this->db->where('s.materials', 0);
        // $this->db->where('si.stored_id', $stored_id);
        $query = $this->db->get();
        //var_dump($this->db->last_query());exit();
        return $query->result_array();
    }

    //end kho tong
    //Created by San
    function get_sale_material($id) {
        $this->db->where("sale_id", $id);
        $query = $this->db->get("sales_materials");
        return $query->result_array();
    }

    function insert_sale_material($data) {
        $this->db->insert("sales_materials", $data);
    }

    function delete_sale_material($sale_id) {
        $this->db->where("sale_id", $sale_id);
        $this->db->delete("sales_materials");
    }

    //7-04-2015
    function get_revenue_by_employee($employee_id) {
        if ($employee_id != 1) {
            $this->db->select('sale_id');
            $this->db->from('sales');
            $this->db->where('employee_id', $employee_id);
        } else {
            $this->db->select('sale_id');
            $this->db->from('sales');
        }
        $this->db->where('deleted', 0);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sale_tra_lai_by_employee($employee_id, $service) {
        if ($service == 0) {
            if ($employee_id != 1) {
                $this->db->select('sales.sale_id as sale_id');
                $this->db->from('sales');
                $this->db->join('sales_items si', 'sales.sale_id=si.sale_id');
                $this->db->join('items', 'si.item_id=items.item_id');
                $this->db->where('employee_id', $employee_id);
                $this->db->where('later_cost_price <', 0);
                $this->db->where('items.service', 0);
            } else {
                $this->db->select('sales.sale_id as sale_id');
                $this->db->from('sales');
                $this->db->join('sales_items si', 'sales.sale_id=si.sale_id');
                $this->db->join('items', 'si.item_id=items.item_id');
                $this->db->where('later_cost_price <', 0);
                $this->db->where('items.service', 0);
            }
            $this->db->where('sales.deleted', 0);
        } elseif ($service == 1) {
            if ($employee_id != 1) {
                $this->db->select('sales.sale_id as sale_id');
                $this->db->from('sales');
                $this->db->join('sales_items si', 'sales.sale_id=si.sale_id');
                $this->db->join('items', 'si.item_id=items.item_id');
                $this->db->where('employee_id', $employee_id);
                $this->db->where('later_cost_price <', 0);
                $this->db->where('items.service', 1);
            } else {
                $this->db->select('sales.sale_id as sale_id');
                $this->db->from('sales');
                $this->db->join('sales_items si', 'sales.sale_id=si.sale_id');
                $this->db->join('items', 'si.item_id=items.item_id');
                $this->db->where('later_cost_price <', 0);
                $this->db->where('items.service', 1);
            }
            $this->db->where('sales.deleted', 0);
        } else {
            if ($employee_id != 1) {
                $this->db->select('sales.sale_id as sale_id');
                $this->db->from('sales');
                $this->db->join('sales_items si', 'sales.sale_id=si.sale_id');
                $this->db->join('items', 'si.item_id=items.item_id');
                $this->db->where('employee_id', $employee_id);
                $this->db->where('later_cost_price <', 0);
            } else {
                $this->db->select('sales.sale_id as sale_id');
                $this->db->from('sales');
                $this->db->join('sales_items si', 'sales.sale_id=si.sale_id');
                $this->db->join('items', 'si.item_id=items.item_id');
                $this->db->where('later_cost_price <', 0);
                ;
            }
            $this->db->where('sales.deleted', 0);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sale_ban_hang_by_employee($employee_id, $service) {
        if ($service == 0) {
            if ($employee_id != 1) {
                $this->db->select('sales.sale_id as sale_id');
                $this->db->from('sales');
                $this->db->join('sales_items si', 'sales.sale_id=si.sale_id');
                $this->db->join('items', 'si.item_id=items.item_id');
                $this->db->where('employee_id', $employee_id);
                $this->db->where('later_cost_price >=', 0);
                $this->db->where('items.service', 0);
            } else {
                $this->db->select('sales.sale_id as sale_id');
                $this->db->from('sales');
                $this->db->join('sales_items si', 'sales.sale_id=si.sale_id');
                $this->db->join('items', 'si.item_id=items.item_id');
                $this->db->where('later_cost_price >=', 0);
                $this->db->where('items.service', 0);
            }
            $this->db->where('sales.deleted', 0);
            $query = $this->db->get();
        } else if ($service == 1) {
            if ($employee_id != 1) {
                $this->db->select('sales.sale_id as sale_id');
                $this->db->from('sales');
                $this->db->join('sales_items si', 'sales.sale_id=si.sale_id');
                $this->db->join('items', 'si.item_id=items.item_id');
                $this->db->where('employee_id', $employee_id);
                $this->db->where('later_cost_price >=', 0);
                $this->db->where('items.service', 1);
            } else {
                $this->db->select('sales.sale_id as sale_id');
                $this->db->from('sales');
                $this->db->join('sales_items si', 'sales.sale_id=si.sale_id');
                $this->db->join('items', 'si.item_id=items.item_id');
                $this->db->where('later_cost_price >=', 0);
                $this->db->where('items.service', 1);
            }
            $this->db->where('sales.deleted', 0);
            $query = $this->db->get();
        } else {
            if ($employee_id != 1) {
                $this->db->select('sales.sale_id as sale_id');
                $this->db->from('sales');
                $this->db->join('sales_items si', 'sales.sale_id=si.sale_id');
                $this->db->join('items', 'si.item_id=items.item_id');
                $this->db->where('employee_id', $employee_id);
                $this->db->where('later_cost_price >=', 0);
            } else {
                $this->db->select('sales.sale_id as sale_id');
                $this->db->from('sales');
                $this->db->join('sales_items si', 'sales.sale_id=si.sale_id');
                $this->db->join('items', 'si.item_id=items.item_id');
                $this->db->where('later_cost_price >=', 0);
            }
            $this->db->where('sales.deleted', 0);
            $query = $this->db->get();
        }
        return $query->result_array();
    }

    //11-04-2015
    //Bao cao don hang
    function get_sale_item_by_sale_id_item($id) {
        $this->db->select('s.*,i.name,i.unit_from as unit_from,i.unit as unit, i.unit_rate as unit_rate, i.service, i.taxes');
        $this->db->from('sales_items s');
        $this->db->join('items i', 'i.item_id=s.item_id', 'inner');
        $this->db->where('s.sale_id', $id);
        $this->db->where('i.service', 0);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sale_item_by_sale_id_service($id) {
        $this->db->select('s.*,i.name,i.unit_from as unit_from,i.unit as unit, i.unit_rate as unit_rate, i.service, i.taxes');
        $this->db->from('sales_items s');
        $this->db->join('items i', 'i.item_id=s.item_id', 'inner');
        $this->db->where('s.sale_id', $id);
        $this->db->where('i.service', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sale_by_detail_item() {
        $this->db->select('sales.sale_id as sale_id');
        $this->db->from('sales');
        $this->db->join('sales_items', 'sales.sale_id=sales_items.sale_id');
        $this->db->join('items', 'sales_items.item_id=items.item_id');
        $this->db->where('items.service', 0);
        $this->db->where('later_cost_price >= 0');
        $this->db->group_by("sales_items.sale_id");
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sale_by_detail_service() {
        $this->db->select('sales.sale_id as sale_id');
        $this->db->from('sales');
        $this->db->join('sales_items', 'sales.sale_id=sales_items.sale_id');
        $this->db->join('items', 'sales_items.item_id=items.item_id');
        $this->db->where('items.service', 1);
        $this->db->where('later_cost_price >= 0');
        $this->db->group_by("sales_items.sale_id");
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sale_by_detail_trave_item() {
        $this->db->select('sales.sale_id as sale_id');
        $this->db->from('sales');
        $this->db->join('sales_items', 'sales.sale_id=sales_items.sale_id');
        $this->db->join('items', 'sales_items.item_id=items.item_id');
        $this->db->where('items.service', 0);
        $this->db->where('later_cost_price < 0');
        $this->db->group_by("sales_items.sale_id");
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sale_by_detail_trave_service() {
        $this->db->select('sales.sale_id as sale_id');
        $this->db->from('sales');
        $this->db->join('sales_items', 'sales.sale_id=sales_items.sale_id');
        $this->db->join('items', 'sales_items.item_id=items.item_id');
        $this->db->where('items.service', 1);
        $this->db->where('later_cost_price < 0');
        $this->db->group_by("sales_items.sale_id");
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sale_by_detail_all_item($start_date, $end_date, $sale_type, $item_type) {
        $this->db->select('s.sale_id as sale_id');
        $this->db->from('sales s');
        $this->db->join('sales_items si', 's.sale_id = si.sale_id');
        $this->db->join('items i', 'si.item_id = i.item_id');
        if ($item_type == 3) {
            $this->db->where('i.produce', 1);
        } elseif ($item_type == 0 || $item_type == 1) {
            $this->db->where('i.service', $item_type);
            $this->db->where('i.produce', 0);
        }
        if ($sale_type == 'sales') {
            $this->db->where('s.later_cost_price >', 0);
        } elseif ($sale_type == 'returns') {
            $this->db->where('s.later_cost_price <', 0);
        }
        $this->db->where('s.deleted', 0);
        $this->db->where('s.materials !=', 1);
        $this->db->where('s.sale_time >=', $start_date);
        $this->db->where('s.sale_time <=', $end_date);
        $this->db->order_by('s.sale_id','desc');
        $this->db->group_by("si.sale_id");
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sale_by_detail_all_service() {
        $this->db->select('sales.sale_id as sale_id');
        $this->db->from('sales');
        $this->db->join('sales_items', 'sales.sale_id=sales_items.sale_id');
        $this->db->join('items', 'sales_items.item_id=items.item_id');
        $this->db->where('items.service', 1);
        $this->db->group_by("sales_items.sale_id");
        $query = $this->db->get();
        return $query->result_array();
    }

    //End bao cao don hang
    function get_info_sale($sale_id) {
        $this->db->where("sale_id", $sale_id);
        $query = $this->db->get("sales");
        return $query->row_array();
    }

    function get_max_id($sale_id) {
        $this->db->select_max("id");
        $this->db->where("id_sale", $sale_id);
        $query = $this->db->get("sales_tam");
        return $query->row_array();
    }

    function get_money_last_due($id) {
        $this->db->where("id", $id);
        $query = $this->db->get("sales_tam");
        return $query->row_array();
    }

    //lay thong tin hinh thuc thanh toan
    function get_form_payment($sale_id) {
        $this->db->select("pays_type");
        $this->db->where("id_sale", $sale_id);
        $this->db->distinct("pays_type");
        $query = $this->db->get("sales_tam");
        return $query->result();
    }

    //delete liablity
    function delete_liablity($sale_id, $all_data = false) {
        $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
        if ($all_data) {
            //Run these queries as a transaction, we want to make sure we do all or nothing
            $this->db->trans_start();
            $this->db->delete('sales_payments', array('sale_id' => $sale_id));
            $this->db->delete('sales_items_taxes', array('sale_id' => $sale_id));
            $this->db->delete('sales_items', array('sale_id' => $sale_id));
            $this->db->delete('sales_item_kits_taxes', array('sale_id' => $sale_id));
            $this->db->delete('sales_item_kits', array('sale_id' => $sale_id));
            $this->db->trans_complete();
        }
        $this->db->where('sale_id', $sale_id);
        return $this->db->update('sales', array('deleted' => 1));
    }

    //END SAN
    //hung audi 6-4-15
    //KHACH LE
    //tra ve
    function get_sale_by_nocustomer_returns() {
        $this->db->select('sale_id');
        $this->db->from('sales');
        $this->db->where('customer_id', NULL);
        $this->db->where('later_cost_price < 0');
        $query = $this->db->get();
        //var_dump($this->db->last_query());exit();
        return $query->result_array();
    }

    //don hang
    function get_sale_by_nocustomer_sales() {
        $this->db->select('sale_id');
        $this->db->from('sales');
        $this->db->where('customer_id', NULL);
        $this->db->where('later_cost_price >= 0');
        $query = $this->db->get();
        //var_dump($this->db->last_query());exit();
        return $query->result_array();
    }

    //all
    function get_sale_by_nocustomer_all() {
        $this->db->select('sale_id');
        $this->db->from('sales');
        $this->db->where('customer_id', NULL);
        $query = $this->db->get();
        //var_dump($this->db->last_query());exit();
        return $query->result_array();
    }

    //KHACH CO
    //tra ve
    function get_sale_by_customer_returns($customer_id) {
        $this->db->select('sale_id');
        $this->db->from('sales');
        $this->db->where('customer_id', $customer_id);
        $this->db->where('later_cost_price < 0');
        $query = $this->db->get();
        //var_dump($this->db->last_query());exit();
        return $query->result_array();
    }

    //don hang
    function get_sale_by_customer_sales($customer_id) {
        $this->db->select('sale_id');
        $this->db->from('sales');
        $this->db->where('customer_id', $customer_id);
        $this->db->where('later_cost_price >= 0');
        $query = $this->db->get();
        //var_dump($this->db->last_query());exit();
        return $query->result_array();
    }

    //all
    function get_sale_by_customer_all($customer_id) {
        $this->db->select('sale_id');
        $this->db->from('sales');
        $this->db->where('customer_id', $customer_id);
        $query = $this->db->get();
        //var_dump($this->db->last_query());exit();
        return $query->result_array();
    }

//hung audi 11-4
    function get_sale_item_by_sale_id2($id, $item_type) {
        $this->db->select('s.*,i.name,i.unit_from as unit_from,i.unit as unit, i.unit_rate as unit_rate, i.taxes');
        $this->db->from('sales_items s');
        $this->db->join('items i', 'i.item_id=s.item_id', 'inner');
        $this->db->where('s.sale_id', $id);

        if ($item_type == 0) {
            $this->db->where('i.service', 0);
        } else if ($item_type == 1) {
            $this->db->where('i.service', 1);
        } else {

        }

        $query = $this->db->get();
        return $query->result_array();
    }

    //Created BY Loi
    function get_sale_item_by_sale_id_by_service($id, $service) {
        $this->db->select('s.*,i.name,i.unit_from as unit_from,i.unit as unit, i.unit_rate as unit_rate');
        $this->db->from('sales_items s');
        $this->db->join('items i', 'i.item_id=s.item_id', 'inner');
        $this->db->where('s.sale_id', $id);
        if ($service != 2) {
            $this->db->where('service', $service);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sale_item_by_sale_id_new($id, $item_type) {
        $this->db->select('s.*,i.name,i.unit_from as unit_from,i.unit as unit, i.unit_rate as unit_rate, i.taxes');
        $this->db->from('sales_items s');
        $this->db->join('items i', 'i.item_id=s.item_id', 'inner');
        $this->db->where('s.sale_id', $id);
        if ($item_type == 3) {
            $this->db->where('i.produce', 1);
        } elseif ($item_type == 1 || $item_type == 0) {
            $this->db->where('i.service', $item_type);
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sale_pack_by_sale_id($id) {
        $this->db->select('k.*, k.pack_unit_price as item_unit_price,i.category as donvi,k.quantity_purchased,i.name,discount_percent, k.unit_pack as unit');
        $this->db->from('sales_packs k');
        $this->db->join('packs i', 'k.pack_id = i.pack_id', 'inner');
        $this->db->where('k.sale_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sale_by_customer_returns_by_service($customer_id, $service) {
        $this->db->select('sales.sale_id as sale_id');
        $this->db->from('sales');
        $this->db->join('sales_items si', 'sales.sale_id=si.sale_id');
        $this->db->join('items', 'si.item_id=items.item_id');
        if ($customer_id != 0) {
            $this->db->where('customer_id', $customer_id);
        }
        if ($service != 2) {
            $this->db->where('service', $service);
        }
        $this->db->where('later_cost_price <', 0);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sale_by_customer_sales_by_service($customer_id, $service) {
        $this->db->select('sales.sale_id as sale_id');
        $this->db->from('sales');
        $this->db->join('sales_items si', 'sales.sale_id=si.sale_id');
        $this->db->join('items', 'si.item_id=items.item_id');
        if ($customer_id != 0) {
            $this->db->where('customer_id', $customer_id);
        }
        if ($service != 2) {
            $this->db->where('service', $service);
        }
        $this->db->where('later_cost_price >=', 0);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sale_by_customer_all_by_service($customer_id, $service) {

        $this->db->select('sales.sale_id as sale_id');
        $this->db->from('sales');
        $this->db->join('sales_items si', 'sales.sale_id=si.sale_id');
        $this->db->join('items', 'si.item_id=items.item_id');
        $this->db->where('customer_id', $customer_id);
        if ($service != 2) {
            $this->db->where('items.service', $service);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sales_tam_by_date2($start_date, $end_date, $sale_id) {
        $this->db->select('s.*,p.first_name');
        $this->db->from('sales_tam s');
        $this->db->join('people p', 's.employees_id=p.person_id', 'inner');

        $this->db->where('s.date_tam >=', $start_date);
        $this->db->where('s.date_tam <=', $end_date);
        $this->db->where('s.id_sale', $sale_id);
        $this->db->where('s.dathang', 0);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_customer_in_sales($start_date, $end_date, $sale_type) {
        $this->db->select('customer_id');
        $this->db->from('sales s');
        $this->db->where('deleted', 0);
        if ($sale_type == 'sales') {
            $this->db->where('s.later_cost_price >', 0);
        } elseif ($sale_type == 'returns') {
            $this->db->where('s.later_cost_price <', 0);
        }
        $this->db->where('s.deleted', 0);
        $this->db->where('s.materials !=', 1);
        $this->db->where('s.sale_time >=', $start_date);
        $this->db->where('s.sale_time <=', $end_date);
        $this->db->group_by('customer_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_customer_in_sale_item($start_date, $end_date, $sale_type, $item_type) {
        $this->db->select('id_customer as customer_id');
        $this->db->from('sales_items si');
        $this->db->join('sales s', 'si.sale_id = s.sale_id');
        $this->db->join('items i', 'si.item_id = i.item_id');
        if ($sale_type == 'sales') {
            $this->db->where('s.later_cost_price >', 0);
        } elseif ($sale_type == 'returns') {
            $this->db->where('s.later_cost_price <', 0);
        }
        if ($item_type == 3) {
            $this->db->where('i.produce', 1);
        } elseif ($item_type == 0 || $item_type == 1) {
            $this->db->where('i.service', $item_type);
            $this->db->where('i.produce', 0);
        }
        $this->db->where('s.deleted', 0);
        $this->db->where('s.materials !=', 1);
        $this->db->where('s.sale_time >=', $start_date);
        $this->db->where('s.sale_time <=', $end_date);
        $this->db->group_by('customer_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_customer_in_sale_pack($start_date, $end_date, $sale_type) {
        $this->db->select('id_customer as customer_id');
        $this->db->from('sales_packs sp');
        $this->db->join('sales s', 'sp.sale_id = s.sale_id');
        if ($sale_type == 'sales') {
            $this->db->where('s.later_cost_price >', 0);
        } elseif ($sale_type == 'returns') {
            $this->db->where('s.later_cost_price <', 0);
        }
        $this->db->where('s.deleted', 0);
        $this->db->where('s.materials !=', 1);
        $this->db->where('s.sale_time >=', $start_date);
        $this->db->where('s.sale_time <=', $end_date);
        $this->db->group_by('customer_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sale_item_by_customer($start_date, $end_date, $sale_type, $customer_id, $item_type) {
        $this->db->select('si.*, sum(si.item_unit_price*si.quantity_purchased) as total_sale_price, sum(si.item_unit_price*si.quantity_purchased*si.taxes_percent/100) as total_taxes,sum(si.item_unit_price_rate*si.quantity_purchased*si.taxes_percent/100) as total_taxes_rate, sum(si.item_unit_price_rate*si.quantity_purchased) as total_sale_price_rate,sum(si.item_unit_price*si.quantity_purchased*si.discount_percent/100) as total_discount,sum(si.item_unit_price_rate*si.quantity_purchased*si.discount_percent/100) as total_discount_rate, i.unit as unit, i.unit_from as unit_from');

        $this->db->from('sales_items si');
        $this->db->join('sales s', 'si.sale_id = s.sale_id');
        $this->db->join('items i', 'si.item_id = i.item_id');
//        $this->db->join('sales_tam sp','s.sale_id = sp.id_sale');
        if ($customer_id == Null) {
            $this->db->where('si.id_customer <', 0);
        } else {
            $this->db->where('si.id_customer', $customer_id);
        }
        if ($item_type == 3) {
            $this->db->where('i.produce', 1);
        } elseif ($item_type == 0 || $item_type == 1) {
            $this->db->where('i.service', $item_type);
            $this->db->where('i.produce', 0);
        }
        if ($sale_type == 'sales') {
            $this->db->where('s.later_cost_price >', 0);
        } elseif ($sale_type == 'returns') {
            $this->db->where('s.later_cost_price <', 0);
        }
        $this->db->where('s.deleted', 0);
        $this->db->where('s.sale_time >=', $start_date);
        $this->db->where('s.sale_time <=', $end_date);
        $this->db->group_by('si.id_customer');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sale_pack_by_customer($start_date, $end_date, $sale_type, $customer_id) {
        $this->db->select('si.*, sum(si.pack_unit_price*si.quantity_purchased) as total_sale_pack_price, i.unit as unit,sum(si.pack_unit_price*si.quantity_purchased*si.discount_percent/100) as total_discount_pack');

        $this->db->from('sales_packs si');
        $this->db->join('sales s', 'si.sale_id = s.sale_id');
        $this->db->join('packs i', 'si.pack_id = i.pack_id');
//        $this->db->join('sales_tam sp','s.sale_id = sp.id_sale');
        if ($customer_id == Null) {
            $this->db->where('si.id_customer <', 0);
        } else {
            $this->db->where('si.id_customer', $customer_id);
        }
        if ($sale_type == 'sales') {
            $this->db->where('s.later_cost_price >', 0);
        } elseif ($sale_type == 'returns') {
            $this->db->where('s.later_cost_price <', 0);
        }
        $this->db->where('s.deleted', 0);
        $this->db->where('s.sale_time >=', $start_date);
        $this->db->where('s.sale_time <=', $end_date);
        $this->db->group_by('si.id_customer');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sale_tam_by_all($start_date, $end_date, $customer_id, $sale_type) {
        $this->db->select('sum(st.pays_amount) as pays_amount');
        $this->db->from('sales_tam st');
        $this->db->join('sales s', 'st.id_sale = s.sale_id');
        if ($customer_id == Null) {
            $this->db->where('s.customer_id', NULL);
        } else {
            $this->db->where('s.customer_id', $customer_id);
        }
        if ($sale_type == 'sales') {
            $this->db->where('s.later_cost_price >', 0);
        } elseif ($sale_type == 'returns') {
            $this->db->where('s.later_cost_price <', 0);
        }
        $this->db->where('s.deleted', 0);
        $this->db->where('s.sale_time >=', $start_date);
        $this->db->where('s.sale_time <=', $end_date);
        $this->db->group_by('s.customer_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_date_in_sale_item($start_date, $end_date, $sale_type, $item_type) {
        $this->db->select('s.*,si.*,i.*,st.discount_money as discount_money2');
        $this->db->from('sales_items si');
        $this->db->join('sales s', 'si.sale_id = s.sale_id');
        $this->db->join('items i', 'si.item_id = i.item_id');
        $this->db->join('sales_tam st', 's.sale_id = st.id_sale');
        $this->db->where('s.sale_time >=', $start_date);
        $this->db->where('s.sale_time <=', $end_date);
        if ($sale_type == 'sales') {
            $this->db->where('s.later_cost_price >', 0);
        } elseif ($sale_type == 'returns') {
            $this->db->where('s.later_cost_price <', 0);
        }
        if ($item_type == 3) {
            $this->db->where('i.produce', 1);
        } elseif ($item_type == 0 || $item_type == 1) {
            $this->db->where('i.service', $item_type);
            $this->db->where('i.produce', 0);
        }
        //$this->db->group_by('s.sale_time');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_date_in_sale_pack($start_date, $end_date, $sale_type) {
        $this->db->select('s.*,si.pack_unit_price as item_unit_price,si.*');
        $this->db->from('sales_packs si');
        $this->db->join('sales s', 'si.sale_id = s.sale_id');
        $this->db->join('packs i', 'si.pack_id = i.pack_id');
        $this->db->where('s.sale_time >=', $start_date);
        $this->db->where('s.sale_time <=', $end_date);
        if ($sale_type == 'sales') {
            $this->db->where('s.later_cost_price >', 0);
        } elseif ($sale_type == 'returns') {
            $this->db->where('s.later_cost_price <', 0);
        }
        //$this->db->group_by('s.sale_time');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sale_in_sale_pack($start_date, $end_date, $sale_type) {
        $this->db->select('sp.sale_id as sale_id');
        $this->db->from('sales_packs sp');
        $this->db->join('sales s', 'sp.sale_id = s.sale_id');
        if ($sale_type == 'sales') {
            $this->db->where('s.later_cost_price >', 0);
        } elseif ($sale_type == 'returns') {
            $this->db->where('s.later_cost_price <', 0);
        }
        $this->db->where('s.deleted', 0);
        $this->db->where('s.materials !=', 1);
        $this->db->where('s.sale_time >=', $start_date);
        $this->db->where('s.sale_time <=', $end_date);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_cat_in_sale_item() {
        $this->db->select('cat_id');
        $this->db->from('sales_items si');
        $this->db->join('items i', 'si.item_id = i.item_id');
        $this->db->where('i.service', 0);
        $this->db->group_by('si.cat_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_cat_in_sale_pack() {
        $this->db->select('i.category as cat_id');
        $this->db->from('sales_packs si');
        $this->db->join('packs i', 'si.pack_id = i.pack_id');
        $this->db->group_by('cat_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sale_item_by_cat_id($start_date, $end_date, $sale_type) {
        $this->db->select('si.*,i.*');
        $this->db->from('sales_items si');
        $this->db->join('items i', 'si.item_id = i.item_id');
        $this->db->join('sales s', 'si.sale_id = s.sale_id');
        $this->db->where('s.sale_time >=', $start_date);
        $this->db->where('s.sale_time <=', $end_date);
        if ($sale_type == 'sales') {
            $this->db->where('s.later_cost_price >', 0);
        } elseif ($sale_type == 'returns') {
            $this->db->where('s.later_cost_price <', 0);
        }
        $this->db->where('s.deleted', 0);
        $this->db->where('i.service', 0);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sale_pack_by_cat_id($start_date, $end_date, $sale_type) {
        $this->db->select('si.*, i.category as cat_id, i.*');
        $this->db->from('sales_packs si');
        $this->db->join('packs i', 'si.pack_id = i.pack_id');
        $this->db->join('sales s', 'si.sale_id = s.sale_id');
        $this->db->where('s.sale_time >=', $start_date);
        $this->db->where('s.sale_time <=', $end_date);
        if ($sale_type == 'sales') {
            $this->db->where('s.later_cost_price >', 0);
        } elseif ($sale_type == 'returns') {
            $this->db->where('s.later_cost_price <', 0);
        }
        $this->db->where('s.deleted', 0);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sale_item_by_trans_sale($item_id, $sale_id) {
        $this->db->select('taxes_percent,discount_percent');
        $this->db->from('sales_items');
        $this->db->where('sale_id', $sale_id);
        $this->db->where('item_id', $item_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    //End Loi
    function get_tax_item2($item_id, $sale_id) {
        $this->db->from('sales_items');
        $this->db->where('item_id', $item_id);
        $this->db->where('sale_id', $sale_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    //    tong hop don hang
    function get_item_id_in_sale_item($start_date, $end_date, $sale_type, $item_type) {
        $this->db->select('si.item_id');
        $this->db->from('sales_items si');
        $this->db->join('sales s', 'si.sale_id = s.sale_id');
        $this->db->join('items i', 'si.item_id = i.item_id');
        $this->db->join('sales_tam st', 's.sale_id = st.id_sale');
        $this->db->where('s.sale_time >=', $start_date);
        $this->db->where('s.sale_time <=', $end_date);
        if ($sale_type == 'sales') {
            $this->db->where('s.later_cost_price >', 0);
        } elseif ($sale_type == 'returns') {
            $this->db->where('s.later_cost_price <', 0);
        }
        if ($item_type == 3) {
            $this->db->where('i.produce', 1);
        } elseif ($item_type == 0 || $item_type == 1) {
            $this->db->where('i.service', $item_type);
            $this->db->where('i.produce', 0);
        }
        $this->db->group_by('si.item_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_pack_id_in_sale_pack($start_date, $end_date, $sale_type) {
        $this->db->select('si.pack_id');
        $this->db->from('sales_packs si');
        $this->db->join('sales s', 'si.sale_id = s.sale_id');
        $this->db->join('packs i', 'si.pack_id = i.pack_id');
        $this->db->where('s.sale_time >=', $start_date);
        $this->db->where('s.sale_time <=', $end_date);
        if ($sale_type == 'sales') {
            $this->db->where('s.later_cost_price >', 0);
        } elseif ($sale_type == 'returns') {
            $this->db->where('s.later_cost_price <', 0);
        }
        $this->db->group_by('si.pack_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_all_item_id_in_sale_item($start_date, $end_date, $sale_type, $item_type, $item_id) {
        $this->db->select('si.*,i.*');
        $this->db->from('sales_items si');
        $this->db->join('sales s', 'si.sale_id = s.sale_id');
        $this->db->join('items i', 'si.item_id = i.item_id');
        $this->db->join('sales_tam st', 's.sale_id = st.id_sale');
        $this->db->where('s.sale_time >=', $start_date);
        $this->db->where('s.sale_time <=', $end_date);
        $this->db->where('i.item_id', $item_id);
        if ($sale_type == 'sales') {
            $this->db->where('s.later_cost_price >', 0);
        } elseif ($sale_type == 'returns') {
            $this->db->where('s.later_cost_price <', 0);
        }
        if ($item_type == 3) {
            $this->db->where('i.produce', 1);
        } elseif ($item_type == 0 || $item_type == 1) {
            $this->db->where('i.service', $item_type);
            $this->db->where('i.produce', 0);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_all_pack_id_in_sale_pack($start_date, $end_date, $sale_type, $pack_id) {
        $this->db->select('si.*,i.*');
        $this->db->from('sales_packs si');
        $this->db->join('sales s', 'si.sale_id = s.sale_id');
        $this->db->join('packs i', 'si.pack_id = i.pack_id');
        $this->db->where('s.sale_time >=', $start_date);
        $this->db->where('s.sale_time <=', $end_date);
        $this->db->where('i.pack_id', $pack_id);
        if ($sale_type == 'sales') {
            $this->db->where('s.later_cost_price >', 0);
        } elseif ($sale_type == 'returns') {
            $this->db->where('s.later_cost_price <', 0);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

//hung audi 20-4-14
    function get_sales_tam_by_date_detail2($start_date, $end_date, $sale_id) {
        $this->db->select('s.*,p.first_name as first_name, pe.first_name as first_name1,sa.comment as comment,sa.liability,
        	 sum(s.pays_amount) pays_amount2, sum(s.discount_money) discount_money2');
        $this->db->from('sales_tam s');
        $this->db->join('sales sa', 'sa.sale_id=s.id_sale', 'inner');
        $this->db->join('people p', 'sa.customer_id=p.person_id', 'inner');
        $this->db->join('people pe', 'sa.employee_id=pe.person_id', 'inner');
        $this->db->where('s.date_tam >=', $start_date);
        $this->db->where('s.date_tam <=', $end_date);
        $this->db->where('s.id_sale', $sale_id);
        $this->db->group_by('s.id_sale');
        $query = $this->db->get();
        //var_dump($this->db->last_query());exit();
        return $query->result_array();
    }

    function get_sales_tam_by_date_detail_nocustomer2($start_date, $end_date, $sale_id) {
        $this->db->select('s.*,pe.first_name as first_name1,sa.comment as comment,sa.liability,
        	 sum(s.pays_amount) pays_amount2, sum(s.discount_money) discount_money2');
        $this->db->from('sales_tam s');
        $this->db->join('sales sa', 'sa.sale_id=s.id_sale', 'inner');
        $this->db->join('people pe', 'sa.employee_id=pe.person_id', 'inner');
        $this->db->where('sa.liability <>', 1);
        $this->db->where('s.date_tam >=', $start_date);
        $this->db->where('s.date_tam <=', $end_date);
        $this->db->where('s.id_sale', $sale_id);
        $this->db->group_by('s.id_sale');
        $query = $this->db->get();
        //var_dump($this->db->last_query());exit();
        return $query->result_array();
    }

    function get_sales_tam_by_date_detail_sale2($start_date, $end_date, $sale_id) {
        $this->db->select('s.*, p.first_name as first_name, pe.first_name as first_name1,p.last_name as last_name,
        	pe.last_name as last_name1,sa.comment as comment,sa.liability, sum(s.pays_amount) pays_amount2, sum(s.discount_money) discount_money2');
        $this->db->from('sales_tam s');
        $this->db->join('sales sa', 'sa.sale_id=s.id_sale', 'inner');
        $this->db->join('people p', 'sa.customer_id=p.person_id', 'left');
        $this->db->join('people pe', 'sa.employee_id=pe.person_id', 'left');
        $this->db->where('s.date_tam >=', $start_date);
        $this->db->where('s.date_tam <=', $end_date);
        $this->db->where('s.id_sale', $sale_id);
        $this->db->group_by('s.id_sale');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sale_item_by_sale_id22($id) {
        $this->db->select('s.*,i.name,i.unit_from as unit_from,i.unit as unit, i.unit_rate as unit_rate, i.taxes, i.*');
        $this->db->from('sales_items s');
        $this->db->join('items i', 'i.item_id=s.item_id', 'inner');
        $this->db->where('s.sale_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sale_item_by_sale_id32($id, $service) {
        if ($service == 0) {
            $this->db->select('s.*,i.name,i.unit_from as unit_from,i.unit as unit, i.unit_rate as unit_rate, i.taxes, i.*');
            $this->db->from('sales_items s');
            $this->db->join('items i', 'i.item_id=s.item_id', 'inner');
            $this->db->where('s.sale_id', $id);
            $this->db->where('i.service', 0);
            $query = $this->db->get();
        } else if ($service == 1) {
            $this->db->select('s.*,i.name,i.unit_from as unit_from,i.unit as unit, i.unit_rate as unit_rate, i.taxes, i.*');
            $this->db->from('sales_items s');
            $this->db->join('items i', 'i.item_id=s.item_id', 'inner');
            $this->db->where('s.sale_id', $id);
            $this->db->where('i.service', 1);
            $query = $this->db->get();
        } else {
            $this->db->select('s.*,i.name,i.unit_from as unit_from,i.unit as unit, i.unit_rate as unit_rate, i.taxes, i.*');
            $this->db->from('sales_items s');
            $this->db->join('items i', 'i.item_id=s.item_id', 'inner');
            $this->db->where('s.sale_id', $id);
            $query = $this->db->get();
        }

        return $query->result_array();
    }

    function get_sale_item_by_sale_id_item2($id, $item_type) {
        $this->db->select('s.*, i.*');
        $this->db->from('sales_items s');
        $this->db->join('items i', 'i.item_id = s.item_id');
        $this->db->where('s.sale_id', $id);
        $this->db->order_by('s.sale_id','desc');
        if ($item_type == 3) {
            $this->db->where('i.produce', 1);
        } elseif ($item_type == 0 || $item_type == 1) {
            $this->db->where('i.service', $item_type);
            $this->db->where('i.produce', 0);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sale_item_by_sale_id_service2($id) {
        $this->db->select('s.*,i.name,i.unit_from as unit_from,i.unit as unit, i.unit_rate as unit_rate, i.service, i.taxes, i.*');
        $this->db->from('sales_items s');
        $this->db->join('items i', 'i.item_id=s.item_id', 'inner');
        $this->db->where('s.sale_id', $id);
        $this->db->where('i.service', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sale_item_by_sale_id_by_service2($id, $service) {
        $this->db->select('s.*,i.name,i.unit_from as unit_from,i.unit as unit, i.unit_rate as unit_rate, i.*');
        $this->db->from('sales_items s');
        $this->db->join('items i', 'i.item_id=s.item_id', 'inner');
        $this->db->where('s.sale_id', $id);
        if ($service != 2) {
            $this->db->where('service', $service);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    //hung 2-6-15 ghép pack thay thế item_kit
    //save
    function save($items, $customer_id, $employee_id, $comment, $employees_id, $show_comment_on_receipt, $payments, $discount_money, $later_cost_price, $actual_money, $amount_due, $amount_due1, $sale_id = false, $suspended = 0, $liability = 0, $stt, $date_debt, $cc_ref_no = '', $mode, $delivery_employee, $bank_account,$symbol_order,$number_order ,$date_debt1, $co_1331, $co_1331_money, $no_131, $no_131_money) {
        if (count($items) == 0)
            return -1;

        $payment_types = '';
        foreach ($payments as $payment_id => $payment) {
            if ($liability == 1) {
                $payment_types = $payment_types . $payment['payment_type'] . ': ' . number_format($payment['payment_amount']) . '<br />';
            } else {
                if ($amount_due1 < 0) {
                    $payment_types = $payment_types . $payment['payment_type'] . ': ' . number_format($payment['payment_amount'] + $amount_due1) . '<br />';
                } else {
                    $payment_types = $payment_types . $payment['payment_type'] . ': ' . number_format($payment['payment_amount']) . '<br />';
                }
            }
        }
   if($this->session->userdata('store') == 1999){
        $sales_data = array(
            'sale_time' => $date_debt,
            'customer_id' => $this->Customer->exists($customer_id) ? $customer_id : null,
            'employee_id' => $employee_id,
            'payment_type' => $payment_types,
            'comment' => $comment,
            'show_comment_on_receipt' => $show_comment_on_receipt ? $show_comment_on_receipt : 0,
            'suspended' => $suspended,
            'deleted' => 0,
            'cc_ref_no' => $cc_ref_no,
            'date_debt' => $date_debt,
            'later_cost_price' => $later_cost_price,
            'discount_money' => $discount_money,
            'liability' => $liability,
            'actual_money' => $actual_money,
            'employees_id' => $employees_id,
            'delivery_employee' => $delivery_employee,
            'symbol_order' => $symbol_order,
            'number_order' => $number_order,
            'date_debt1' => $date_debt1,
            'co_1331' => $co_1331,
            'co_1331_money' => $co_1331_money,
            'no_131' => $no_131,
            'no_131_money' => $no_131_money,
            'sale_status' => 1
        );
        $sales_data1 = array(
            'customer_id' => $this->Customer->exists($customer_id) ? $customer_id : null,
            'employee_id' => $employee_id,
            'payment_type' => $payment_types,
            'comment' => $comment,
            'show_comment_on_receipt' => $show_comment_on_receipt ? $show_comment_on_receipt : 0,
            'suspended' => $suspended,
            'deleted' => 0,
            'cc_ref_no' => $cc_ref_no,
            'date_debt' => $date_debt,
            'later_cost_price' => $later_cost_price,
            'discount_money' => $discount_money,
            'liability' => $liability,
            'actual_money' => $actual_money,
            'employees_id' => $employees_id,
            'delivery_employee' => $delivery_employee,
            'symbol_order' => $symbol_order,
            'number_order' => $number_order,
            'date_debt1' => $date_debt1,
            'co_1331' => $co_1331,
            'co_1331_money' => $co_1331_money,
            'no_131' => $no_131,
            'no_131_money' => $no_131_money,
            'sale_status' => 1
        );
        $sales_data2 = array(
            'customer_id' => $this->Customer->exists($customer_id) ? $customer_id : null,
            'employee_id' => $employee_id,
            'payment_type' => $payment_types,
            'comment' => $comment,
            'show_comment_on_receipt' => $show_comment_on_receipt ? $show_comment_on_receipt : 0,
            'suspended' => $suspended,
            'deleted' => 0,
            'cc_ref_no' => $cc_ref_no,
            'date_debt' => $date_debt,
            'later_cost_price' => $later_cost_price,
            'discount_money' => $discount_money,
            'liability' => $liability,
            'actual_money' => $actual_money,
            'employees_id' => $employees_id,
            'delivery_employee' => $delivery_employee,
            'materials' => 2,
            'symbol_order' => $symbol_order,
            'number_order' => $number_order,
            'date_debt1' => $date_debt1,
            'co_1331' => $co_1331,
            'co_1331_money' => $co_1331_money,
            'no_131' => $no_131,
            'no_131_money' => $no_131_money,
            'sale_status' => 1
        );
        $sales_data3 = array(
            'sale_time' => $date_debt,
            'customer_id' => $this->Customer->exists($customer_id) ? $customer_id : null,
            'employee_id' => $employee_id,
            'payment_type' => $payment_types,
            'comment' => $comment,
            'show_comment_on_receipt' => $show_comment_on_receipt ? $show_comment_on_receipt : 0,
            'suspended' => $suspended,
            'deleted' => 0,
            'cc_ref_no' => $cc_ref_no,
            'date_debt' => $date_debt,
            'later_cost_price' => $later_cost_price,
            'discount_money' => $discount_money,
            'liability' => $liability,
            'actual_money' => $actual_money,
            'employees_id' => $employees_id,
            'materials' => 2,
            'symbol_order' => $symbol_order,
            'number_order' => $number_order,
            'date_debt1' => $date_debt1,
            'co_1331' => $co_1331,
            'co_1331_money' => $co_1331_money,
            'no_131' => $no_131,
            'no_131_money' => $no_131_money,
            'sale_status' => 1
        );
   }else{
       $sales_data = array(
            'sale_time' => $date_debt,
            'customer_id' => $this->Customer->exists($customer_id) ? $customer_id : null,
            'employee_id' => $employee_id,
            'payment_type' => $payment_types,
            'comment' => $comment,
            'show_comment_on_receipt' => $show_comment_on_receipt ? $show_comment_on_receipt : 0,
            'suspended' => $suspended,
            'deleted' => 0,
            'cc_ref_no' => $cc_ref_no,
            'date_debt' => $date_debt,
            'later_cost_price' => $later_cost_price,
            'discount_money' => $discount_money,
            'liability' => $liability,
            'actual_money' => $actual_money,
            'employees_id' => $employees_id,
            'delivery_employee' => $delivery_employee,
            'symbol_order' => $symbol_order,
            'number_order' => $number_order,
            'date_debt1' => $date_debt1,
            'co_1331' => $co_1331,
            'co_1331_money' => $co_1331_money,
            'no_131' => $no_131,
            'no_131_money' => $no_131_money,
            'sale_status' => 0
        );

       $sales_data1 = array(
            'customer_id' => $this->Customer->exists($customer_id) ? $customer_id : null,
            'employee_id' => $employee_id,
            'payment_type' => $payment_types,
            'comment' => $comment,
            'show_comment_on_receipt' => $show_comment_on_receipt ? $show_comment_on_receipt : 0,
            'suspended' => $suspended,
            'deleted' => 0,
            'cc_ref_no' => $cc_ref_no,
            'date_debt' => $date_debt,
            'later_cost_price' => $later_cost_price,
            'discount_money' => $discount_money,
            'liability' => $liability,
            'actual_money' => $actual_money,
            'employees_id' => $employees_id,
            'delivery_employee' => $delivery_employee,
            'symbol_order' => $symbol_order,
            'number_order' => $number_order,
            'date_debt1' => $date_debt1,
            'co_1331' => $co_1331,
            'co_1331_money' => $co_1331_money,
            'no_131' => $no_131,
            'no_131_money' => $no_131_money
        );
        $sales_data2 = array(
            'customer_id' => $this->Customer->exists($customer_id) ? $customer_id : null,
            'employee_id' => $employee_id,
            'payment_type' => $payment_types,
            'comment' => $comment,
            'show_comment_on_receipt' => $show_comment_on_receipt ? $show_comment_on_receipt : 0,
            'suspended' => $suspended,
            'deleted' => 0,
            'cc_ref_no' => $cc_ref_no,
            'date_debt' => $date_debt,
            'later_cost_price' => $later_cost_price,
            'discount_money' => $discount_money,
            'liability' => $liability,
            'actual_money' => $actual_money,
            'employees_id' => $employees_id,
            'delivery_employee' => $delivery_employee,
            'materials' => 2,
            'symbol_order' => $symbol_order,
            'number_order' => $number_order,
            'date_debt1' => $date_debt1,
            'co_1331' => $co_1331,
            'co_1331_money' => $co_1331_money,
            'no_131' => $no_131,
            'no_131_money' => $no_131_money
        );
        $sales_data3 = array(
            'sale_time' => $date_debt,
            'customer_id' => $this->Customer->exists($customer_id) ? $customer_id : null,
            'employee_id' => $employee_id,
            'payment_type' => $payment_types,
            'comment' => $comment,
            'show_comment_on_receipt' => $show_comment_on_receipt ? $show_comment_on_receipt : 0,
            'suspended' => $suspended,
            'deleted' => 0,
            'cc_ref_no' => $cc_ref_no,
            'date_debt' => $date_debt,
            'later_cost_price' => $later_cost_price,
            'discount_money' => $discount_money,
            'liability' => $liability,
            'actual_money' => $actual_money,
            'employees_id' => $employees_id,
            'materials' => 2,
            'symbol_order' => $symbol_order,
            'number_order' => $number_order,
            'date_debt1' => $date_debt1,
            'co_1331' => $co_1331,
            'co_1331_money' => $co_1331_money,
            'no_131' => $no_131,
            'no_131_money' => $no_131_money
        );
   }

        //Run these queries as a transaction, we want to make sure we do all or nothing
        $dathang = $this->Sale->get_info_liability($sale_id);
        $material = $this->Sale->get_info_materials($sale_id);
        $info_sale = $this->get_info_sale($sale_id);
        $ghi_no = $info_sale['suspended'];
        $this->db->trans_start();
        if ($sale_id) {
            //Delete previously sale so we can overwrite data
            if ($material == 1) {
                if ($ghi_no == 1) {
                    $this->delete_sale($sale_id, true);
                    $this->db->where('sale_id', $sale_id);
                    $this->db->update('sales', $sales_data1);
                } else {
                    $this->delete_sale_materials($sale_id, true);
                    $this->db->where('sale_id', $sale_id);
                    $this->db->update('sales', $sales_data3);
                }
            } elseif ($material == 2) {
                if ($dathang == 1) {
                    $this->delete_sale_materials($sale_id, true);
                    $this->db->where('sale_id', $sale_id);
                    $this->db->update('sales', $sales_data1);
                } else {
                    $this->delete_sale($sale_id, true);
                    $this->db->where('sale_id', $sale_id);
                    $this->db->update('sales', $sales_data1);
                }
            } else {
                if ($dathang == 1) {
                    $this->delete_sale_materials($sale_id, true);
                    $this->db->where('sale_id', $sale_id);
                    $this->db->update('sales', $sales_data);
                } else {
                    $this->delete_sale($sale_id, true);
                    $this->db->where('sale_id', $sale_id);
                    $this->db->update('sales', $sales_data1);
                }
            }
        } else {
            $this->db->insert('sales', $sales_data);
            $sale_id = $this->db->insert_id();
        }
        $cost_payment_amount = 0;

        //huyenlt^^ 11/09/14
        if ($liability == 1) {
            $sales_tam_Zenda = array(
                'id_sale' => $sale_id,
                'pays_type' => $payment['payment_type'] . ' ',
                'pays_amount' => $payment['payment_amount'],
                'date_tam' => $date_debt,
                'discount_money' => $payment['discount_money'],
                'employees_id' => $employee_id,
                'stt' => 0,
                'dathang' => 1,
            );
//            $this->db->insert('sales_tam', $sales_tam);
        } else {
            if ($dathang == 1) {
                $sales_tam_Zenda = array(
                    'id_sale' => $sale_id,
                    'pays_type' => $payment['payment_type'] . ' ',
                    'pays_amount' => $amount_due1 < 0 ? $payment['payment_amount'] + $amount_due : $payment['payment_amount'],
                    'date_tam' => $date_debt,
                    'discount_money' => $payment['discount_money'],
                    'employees_id' => $employee_id,
                    'stt' => 0,
                );
            } else {
                if ($amount_due1 <= 0 && $stt == 0) {
                    $sales_tam_Zenda = array(
                        'id_sale' => $sale_id,
                        'pays_type' => $payment['payment_type'] . ' ',
                        'pays_amount' => $payment['payment_amount'] + $amount_due1,
                        'date_tam' => $date_debt,
                        'discount_money' => $payment['discount_money'],
                        'employees_id' => $employee_id,
                        'stt' => 1,
                        'dathang' => 1
                    );
                } elseif ($amount_due1 <= 0 && $stt == 1) {
                    $sales_tam_Zenda = array(
                        'id_sale' => $sale_id,
                        'pays_type' => $payment['payment_type'] . ' ',
                        'pays_amount' => $payment['payment_amount'] + $amount_due1,
                        'date_tam' => $date_debt,
                        'discount_money' => $payment['discount_money'],
                        'employees_id' => $employee_id,
                        'stt' => 1,
                        'dathang' => 0
                    );
                } else {
                    $sales_tam_Zenda = array(
                        'id_sale' => $sale_id,
                        'pays_type' => $payment['payment_type'] . ' ',
                        'pays_amount' => str_replace(array(',', '.'), '', $payment['payment_amount']),
                        'date_tam' => $date_debt,
                        'discount_money' => str_replace(array(',', '.'), '', $payment['discount_money']),
                        'employees_id' => $employee_id,
                        'stt' => $stt,
                        'dathang' => 0
                    );
//                    $this->db->insert('sales_tam', $sales_tam6);
                }
            }
        }
        $this->db->insert('sales_tam', $sales_tam_Zenda);
        //end huyenlt^^ 11/09

        foreach ($payments as $payment_id => $payment) {

            $cost_payment_amount += $payment['payment_amount'];
            if (substr($payment['payment_type'], 0, strlen(lang('sales_giftcard'))) == lang('sales_giftcard')) {
                /* We have a gift card and we have to deduct the used value from the total value of the card. */
                $splitpayment = explode(':', $payment['payment_type']);
                $cur_giftcard_value = $this->Giftcard->get_giftcard_value($splitpayment[1]);
                if (!$suspended)
                    $this->Giftcard->update_giftcard_value($splitpayment[1], $cur_giftcard_value - $payment['payment_amount']);
            }

            //th kh dat tien save all in database
            if ($liability != 1 && $amount_due1 <= 0) {
                $sales_payments_Zenda = array(
                    'sale_id' => $sale_id,
                    'payment_type' => $payment['payment_type'] . ' ',
                    'payment_amount' => $payment['payment_amount'] + $amount_due1,
                    'discount_money' => $payment['discount_money'],
                );
                //tạo session khi có thanh toán bằng tiền mặt
                $session_pay_amount_tm = array(
                    'payamount_tm' => $payment['payment_amount'] - $payment['discount_money'],
                );
                $this->session->set_userdata('payment_types_tm' . $sale_id . date('Y-m-d H:i:s'), $session_pay_amount_tm);
            }else{
                $sales_payments_Zenda = array(
                    'sale_id' => $sale_id,
                    'payment_type' => $payment['payment_type'] . ' ',
                    'payment_amount' => $payment['payment_amount'],
                    'discount_money' => $payment['discount_money'],
                );
            }
            $this->db->insert('sales_payments', $sales_payments_Zenda);

            $ckbh = array(
                'chietkhaubanhang' => $discount_money,
            );
            $this->session->set_userdata('ckbh' . $sale_id, $ckbh);

            if ($suspended == 1) {
                if (!$this->exists_sale_inventory($sale_id)) {
                    $cur_customer_info = $this->Customer->get_info($sales_data['customer_id']);
                    $sales_cus_inventory = array(
                        'id_sale' => $sale_id,
                        'pay_type' => $payment['payment_type'],
                        'pay_amount' => $cost_payment_amount,
                        'id_customer' => $sales_data['customer_id'],
                        'date' => date('Y-m-d H:i:s',strtotime($date_debt)),
                        'id_city_code' => $cur_customer_info->city,
                        'deleted' => 0
                    );
                    $this->db->insert('sales_inventory', $sales_cus_inventory);
                } else {
                    $cur_customer_info = $this->Customer->get_info($sales_data['customer_id']);
                    $sales_cus_inventory = array(
                        'pay_type' => $payment['payment_type'],
                        'pay_amount' => $cost_payment_amount,
                        'date' => date('Y-m-d H:i:s',strtotime($date_debt)),
                    );
                    $this->db->where('id_sale', $sale_id);
                    $this->db->update('sales_inventory', $sales_cus_inventory);
                }
            } else {
                $array_sales_inventory = array('deleted' => 1);
                $this->db->where('id_sale', $sale_id);
                $this->db->update('sales_inventory', $array_sales_inventory);
            }
        }

        /* -------------------------------------------------------------- */
        $this->load->model('Cost');
        $cost_comment1 = "Thu tiền bán hàng từ " . $this->Customer->get_info($customer_id)->first_name . ' ' . $this->Customer->get_info($customer_id)->last_name . ' hình thức ' . $payment['payment_type'];
        $cost_comment2 = "Trả lại tiền dư khách hàng " . $this->Customer->get_info($customer_id)->first_name . ' ' . $this->Customer->get_info($customer_id)->last_name . ' đặt đơn đặt hàng ' . $sale_id;
        $cost_comment3 = "Chi tiền lấy lại hàng đã bán cho khách hàng " . $this->Customer->get_info($customer_id)->first_name . ' ' . $this->Customer->get_info($customer_id)->last_name;
        $thue_don_hang = 0;
        $gia_von = 0;
        foreach ($items as $line => $item) {
            if (isset($item['item_id'])) {
                $cur_item_info = $this->Item->get_info($item['item_id']);
                if ($item['unit'] == "unit") {
                    $thue_don_hang += ($item['quantity'] * $item['price'] - $item['quantity'] * $item['price'] * $item['discount'] / 100) * $item['taxes'] / 100;
                    $gia_von += $item['quantity'] * $cur_item_info->cost_price + $item['quantity'] * $cur_item_info->cost_price * $item['discount'] / 100;
                } else {
                    $thue_don_hang += ($item['quantity'] * $item['price_rate'] - $item['quantity'] * $item['price_rate'] * $item['discount'] / 100) * $item['taxes'] / 100;
                    $gia_von += $cur_item_info->cost_price * $item['quantity'] / $cur_item_info->unit_rate + ($item['quantity'] * $cur_item_info->cost_price / $cur_item_info->unit_rate * $item['discount'] / 100);
                }
            }
        }
        if($payment['payment_amount'] > 0){
            if ($payment['payment_type'] == "CKNH") {
                $tk_no = 112;
                $tk_co = 131;
            } else if ($payment['payment_type'] == "Tiền mặt"){
                $tk_no = 111;
                $tk_co = 511;
            }else{
                $tk_no = 0;
                $tk_co = 0;
            }
        }else{
            $tk_no = 0;
            $tk_co = 0;
        }
        //payment_type costs
        if($payment['payment_type'] == 'Tiền mặt')
            $payment_type_cost = 1;
        else if($payment['payment_type'] == 'CKNH')
            $payment_type_cost = 2;
        else if($payment['payment_type'] == 'COD')
            $payment_type_cost = 3;
        else if($payment['payment_type'] == 'trả góp')
            $payment_type_cost = 4;
        else if($payment['payment_type'] == 'trả nhiều lần')
            $payment_type_cost = 5;

        $id_max = $this->get_max_id($sale_id);
        $get_money_sale = $this->get_money_last_due($id_max['id']);
        if ($dathang == 1) {
            if ($amount_due1 >= 0) {
                $S2____cost_data_05_11_15_kiSSing_you____S2 = array(
                    'id_customer' => $customer_id,
                    'name' => 4,
                    'form_cost' => 0,
                    'money' => $payment['payment_amount'],// str_replace(array(',', '.'), '', $payment['payment_amount']),
                    'date' => $date_debt,
                    'cost_date_ct' => $date_debt,
                    'comment' => $cost_comment1,
                    'deleted' => 0,
                    'id_sale' => $sale_id,
                    'cost_employees' => $employee_id,
                    'tk_no' => $tk_no,
                    'tk_co' => $tk_co,
                    'VAT_acount' => 33311,
                    'VAT_money' => 0,
                    'payment_type' => $payment_type_cost
                );
            } elseif ($liability == 1) {   //Ä‘áº·t hÃ ng: Ä‘áº·t tiá»n láº§n thá»© 2
                $S2____cost_data_05_11_15_kiSSing_you____S2 = array(
                    'id_customer' => $customer_id,
                    'name' => 4,
                    'form_cost' => 0,
                    'money' => $payment['payment_amount'],// str_replace(array(',', '.'), '', $payment['payment_amount']),
                    'date' => $date_debt,
                    'cost_date_ct' => $date_debt,
                    'comment' => $cost_comment1,
                    'deleted' => 0,
                    'id_sale' => $sale_id,
                    'cost_employees' => $employee_id,
                    'tk_no' => $tk_no,
                    'tk_co' => $tk_co,
                    'VAT_acount' => 1331,
                    'VAT_money' => 0,
                    'payment_type' => $payment_type_cost
                );
            } else {
                $info_sale_tam = $this->get_sales_tam($sale_id);
                $total_money_due = 0; //Tong so tien khach da dat hang
                foreach ($info_sale_tam as $s) {
                    $total_order += $s['pays_amount'] + $s['discount_money'];
                }
                //Tinh so tien khach da dat chua ke so tien khach dua va so tien chiet khau lan thanh toan
                $total_money_not_last_due = $total_order - ($get_money_sale['pays_amount'] + $get_money_sale['discount_money']);
                if ($total_money_not_last_due > $later_cost_price) {
                    $S2____cost_data_05_11_15_kiSSing_you____S2 = array(
                        'id_customer' => $customer_id,
                        'name' => 4,
                        'form_cost' => 1,
                        'money' => $payment['payment_amount'],// (str_replace(array(',', '.'), '', ($total_money_not_last_due + $get_money_sale['discount_money'] - $later_cost_price))),
                        'date' => $date_debt,
                        'cost_date_ct' => $date_debt,
                        'comment' => $cost_comment2,
                        'deleted' => 0,
                        'id_sale' => $sale_id,
                        'stt_thu' => 2, //tien chi nay dc save vÃ o trong báº£ng chi n k Ä‘c tÃ­nh trong pháº§n giao ca^^
                        'cost_employees' => $employee_id,
                        'tk_no' => $tk_no,
                        'tk_co' => $tk_co,
                        'VAT_acount' => 33311,
                        'VAT_money' => 0,
                        'payment_type' => $payment_type_cost
                    );
                } else {
                    $Zenda_fashion = $total_money_not_last_due + $get_money_sale['discount_money'];
                    $S2____cost_data_05_11_15_kiSSing_you____S2 = array(
                        'id_customer' => $customer_id,
                        'name' => 4,
                        'form_cost' => $Zenda_fashion >= $later_cost_price ? 1 : 0,
                        'money' => $payment['payment_amount'],// $Zenda_fashion >= $later_cost_price ? (str_replace(array(',', '.'), '', ($Zenda_fashion - $later_cost_price))) : str_replace(array(',', '.'), '', $get_money_sale['pays_amount'] - $Zenda_fashion),
                        'date' => $date_debt,
                        'cost_date_ct' => $date_debt,
                        'comment' => $cost_comment2,
                        'deleted' => 0,
                        'id_sale' => $sale_id,
                        'stt_thu' => 2, //tien chi nay dc save vÃ o trong báº£ng chi n k Ä‘c tÃ­nh trong pháº§n giao ca^^
                        'cost_employees' => $employee_id,
                        'tk_no' => $tk_no,
                        'tk_co' => $tk_co,
                        'payment_type' => $payment_type_cost
                    );
                }
            }
        } else { // huyenlt^^:truong hop dat hang
            if ($liability == 1) {
                // k tiá»n Ä‘áº·t hÃ ng nhá» hÆ¡n tiá»n Ä‘Æ¡n hÃ ng
                $amount_due2 = str_replace(array('.00', '.'), '', $amount_due1);
                $S2____cost_data_05_11_15_kiSSing_you____S2 = array(
                    'id_customer' => $customer_id,
                    'name' => 4,
                    'money' => $payment['payment_amount'],
                    'date' => $date_debt,
                    'cost_date_ct' => $date_debt,
                    'comment' => $cost_comment1,
                    'deleted' => 0,
                    'id_sale' => $sale_id,
                    'cost_employees' => $employee_id,
                    'tk_no' => $tk_no,
                    'tk_co' => $tk_co,
                    'payment_type' => $payment_type_cost
                );
            } else {
                if (($amount_due1 < 0) && ($dathang != 1 )) {
                    if ($mode == "return") {
                        //Hưng Audi 2015 Nov 05, at 3h45'60s pm
                        /* Zenda * NEM * Chicland fashions in Cau Giay street */
                        $S2____cost_data_05_11_15_kiSSing_you____S2 = array(
                            'id_customer' => $customer_id,
                            'name' => 26,
                            'form_cost' => 1, //xet che do tra hang
                            'money' => $payment['payment_amount'],
                            'date' => $date_debt,
                            'cost_date_ct' => $date_debt,
                            'comment' => $cost_comment3,
                            'deleted' => 0,
                            'id_sale' => $sale_id,
                            'cost_employees' => $employee_id,
                            'stt_thu' => 2,
                            'tk_no' => $tk_no,
                            'tk_co' => $tk_co,
                            'VAT_acount' => 133,
                            'VAT_money' => $thue_don_hang,
                            'payment_type' => $payment_type_cost
                        );
                    } else {
                        $S2____cost_data_05_11_15_kiSSing_you____S2 = array(
                            'id_customer' => $customer_id,
                            'name' => 27,
                            'form_cost' => 0, //xet che do tra hang
                            'money' => $payment['payment_amount'],
                            'date' => $date_debt,
                            'cost_date_ct' => $date_debt,
                            'comment' => $cost_comment1,
                            'deleted' => 0,
                            'id_sale' => $sale_id,
                            'cost_employees' => $employee_id,
                            'stt_thu' => 0,
                            'tk_no' => $tk_no,
                            'tk_co' => $tk_co,
                            'VAT_acount' => 33311,
                            'VAT_money' => $thue_don_hang,
                            'payment_type' => $payment_type_cost
                        );
                    }
                } else {
                    $S2____cost_data_05_11_15_kiSSing_you____S2 = array(
                        'id_customer' => $customer_id,
                        'name' => 27,
                        'form_cost' => 0, //xet che do tra hang
                        'money' => $payment['payment_amount'],
                        'date' => $date_debt,
                        'cost_date_ct' => $date_debt,
                        'comment' => $cost_comment1,
                        'deleted' => 0,
                        'id_sale' => $sale_id,
                        'cost_employees' => $employee_id,
                        'stt_thu' => 0,
                        'tk_no' => $tk_no,
                        'tk_co' => $tk_co,
                        'VAT_acount' => 33311,
                        'VAT_money' => $thue_don_hang,
                        'payment_type' => $payment_type_cost
                    );
                }
            }
        }
        $this->db->insert('costs', $S2____cost_data_05_11_15_kiSSing_you____S2);
        $id_cost_Sirius_Nouvo = $this->db->insert_id();
        //insert sale_cost_tkdu
            $arr = array();
            $gia_ca = array();
            foreach ($items as $line => $item) {
                $net_price = $item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100;
                $gia_ca[$this->Item->get_info($item['item_id'])->account_cos] += $net_price;
                foreach ($gia_ca as $k1 => $v1){
                     $arr[$k1] = $v1;
                }
            }

            if($this->sale_lib->get_total_taxes() > 0){
                $data_recv_cost_tkdu = array(
                    'id_cost' => $id_cost_Sirius_Nouvo,
                    'tkdu' => 1331,
                    'money_no' => $this->sale_lib->get_total_taxes(),
                    'money_co' => 0,
                    'date' => date('Y-m-d H:i:s'),
                    'customer_id' => $customer_id
                );
                $this->Cost->save_sale_cost_tkdu($data_recv_cost_tkdu);
            }

            if($payment['payment_amount'] > 0){
                if ($payment['payment_type'] == "Tiền mặt"){
                     foreach ($arr as $k => $v){
                        $data_recv_cost_tkdu = array(
                            'id_cost' => $id_cost_Sirius_Nouvo,
                            'tkdu' => $k,
                            'money_no' => $v,
                            'money_co' => 0,
                            'date' => date('Y-m-d H:i:s'),
                            'customer_id' => $customer_id
                        );
                          $this->Cost->save_sale_cost_tkdu($data_recv_cost_tkdu);
                   }


                }elseif($payment['payment_type'] == "CKNH"){
                      foreach ($arr as $k => $v){
                        $data_recv_cost_tkdu = array(
                            'id_cost' => $id_cost_Sirius_Nouvo,
                            'tkdu' => $k,
                            'money_no' => $v,
                            'money_co' => 0,
                            'date' => date('Y-m-d H:i:s'),
                            'customer_id' => $customer_id
                        );
                          $this->Cost->save_sale_cost_tkdu($data_recv_cost_tkdu);
                   }
                }

            }else{
                    foreach ($arr as $k => $v){
                    if ($payment['payment_type'] == "Tiền mặt"){
                        $data_recv_cost_tkdu = array(
                            'id_cost' => $id_cost_Sirius_Nouvo,
                            'tkdu' => $k,
                            'money_no' => $v,
                            'money_co' => 0,
                            'date' => date('Y-m-d H:i:s'),
                            'customer_id' => $customer_id
                        );
                    }elseif($payment['payment_type'] == "CKNH"){
                         $data_recv_cost_tkdu = array(
                            'id_cost' => $id_cost_Sirius_Nouvo,
                            'tkdu' => $k,
                            'money_no' => $v,
                            'money_co' => 0,
                            'date' => date('Y-m-d H:i:s'),
                            'customer_id' => $customer_id
                        );
                    }

                    $this->Cost->save_sale_cost_tkdu($data_recv_cost_tkdu);
                }
            }


//            if ($payment['payment_type'] == 'Tiền mặt'){
//                     $data_recv_cost_tkdu = array(
//                    'id_cost' => $id_cost_Sirius_Nouvo,
//                    'tkdu' => 111,
//                    'money_no' => 0,
//                    'money_co' => $payment['payment_amount'],
//                    'date' => date('Y-m-d H:i:s'),
//                    'customer_id' => $customer_id
//                     );
//                     $this->Cost->save_sale_cost_tkdu($data_recv_cost_tkdu);
//                }elseif($payment['payment_type'] == 'CKNH'){
//                     $tk_du = $bank_account;
//                     $data_recv_cost_tkdu = array(
//                    'id_cost' => $id_cost_Sirius_Nouvo,
//                    'tkdu' => $tk_du,
//                    'money_no' => 0,
//                    'money_co' => $payment['payment_amount'],
//                    'date' => date('Y-m-d H:i:s'),
//                    'customer_id' => $customer_id
//                     );
//                     $this->Cost->save_sale_cost_tkdu($data_recv_cost_tkdu);
//                }


                $payment_types = '';
            foreach ($payments as $payment_id => $payment) {
                    if ($amount_due1 < 0) {
                    $payment_types = $payment_types . $payment['payment_type'] . ': ' . number_format($payment['payment_amount'] + $amount_due1) . '<br /> ';
                    } else {

                             if ($payment['payment_type'] == 'Tiền mặt'){
                                    $data_recv_cost_tkdu = array(
                                   'id_cost' => $id_cost_Sirius_Nouvo,
                                   'tkdu' => 111,
                                   'money_no' => 0,
                                   'money_co' => $payment['payment_amount'],
                                   'date' => date('Y-m-d H:i:s'),
                                   'customer_id' => $customer_id
                                    );
                                    $this->Cost->save_sale_cost_tkdu($data_recv_cost_tkdu);
                            }elseif($payment['payment_type'] == 'CKNH'){
                                 $tk_du = $bank_account;
                                 $data_recv_cost_tkdu = array(
                                'id_cost' => $id_cost_Sirius_Nouvo,
                                'tkdu' => $tk_du,
                                'money_no' => 0,
                                'money_co' => $payment['payment_amount'],
                                'date' => date('Y-m-d H:i:s'),
                                'customer_id' => $customer_id
                                 );
                                 $this->Cost->save_sale_cost_tkdu($data_recv_cost_tkdu);
                            }
                    }
            }


//end insert sal_cost_tk_du
        //Nov 3 hƯnG aUdI
        if ($payment['payment_type'] == 'CKNH') {
            //save bank_account
            $bank_account_data = array(
                'id_cost' => $id_cost_Sirius_Nouvo,
                'sale_id' => $sale_id,
                'bank_account' => $bank_account
            );
            $this->Receiving->save_bank_account_sale($bank_account_data, $sale_id);
        }
        //insert_cost_detail
        $money_debt = $later_cost_price - $payment['payment_amount'];
        $data_cost_detail = array(
            'id_cost' => $id_cost_Sirius_Nouvo,
            'sale_id' => $sale_id,
            'money_debt' => $money_debt
        );
        $this->Cost->insert_cost_detail($data_cost_detail);

        foreach ($items as $line => $item) {
            if (isset($item['item_id'])) {
                $cur_item_info = $this->Item->get_info($item['item_id']);
                if ($item['unit'] == "unit") {
                    $unit_item_sale = $cur_item_info->unit;
                } else {
                    $unit_item_sale = $cur_item_info->unit_from;
                }
         $net_price = $item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100;

                            $sales_items_data = array(
                                'id_customer' => $customer_id,
                                'sale_id' => $sale_id,
                                'item_id' => $item['item_id'],
                                'line' => $item['line'],
                                'description' => $item['description'],
                                'serialnumber' => $item['serialnumber'],
                                'quantity_purchased' => $item['quantity'],
                                'unit_item' => $unit_item_sale,
                                'taxes_percent' => $item['taxes'],
                                'discount_percent' => $item['discount'],
                                'item_cost_price' => $cur_item_info->cost_price,
                                'item_unit_price' => $item['price'],
                                'item_unit_price_rate' => $item['price_rate'],
                                'date' => date('Y-m-d H:i:s'),
                                'cat_id' => $cur_item_info->category,
                                'stored_id' => $item['stored_id'],
                                'co_tk_thu' => $this->Item->get_info($item['item_id'])->account_cos,
                                'co_tk_thu_money' => $net_price
                            );


                $this->db->insert('sales_items', $sales_items_data);
                $stock_recorder_check = false;
                $out_of_stock_check = false;
                $email = false;
                $message = '';

                //checks if the quantity is greater than reorder level
                if ($cur_item_info->quantity > $cur_item_info->reorder_level) {
                    $stock_recorder_check = true;
                }

                //checks if the quantity is greater than reorder level
                if ($cur_item_info->quantity > 0) {
                    $out_of_stock_check = true;
                }

                ////huyenlt^^ save
                if ($cur_item_info->unit_rate != 0) {
                    if ($item['unit'] == "unit") {
                        $quantity = $item['quantity'] * $cur_item_info->unit_rate;
                    } else {
                        $quantity = $item['quantity'];
                    }
                } else {
                    $quantity = $item['quantity'];
                }
                $warehouse_items = array(
                    'warehouse_id' => $item['stored_id'],
                    'item_id' => $item['item_id'],
                    'quantity' => 0 - $quantity
                );
                $stores_items_db = $this->Item->get_Stores_Items($item['item_id'], $item['stored_id']);
                if (!$stores_items_db) {
                    //Update stock quantity
                    $item_data = array(
                        'quantity' => $cur_item_info->quantity - $quantity,
                        'quantity_total' => $cur_item_info->quantity_total - $quantity
                    );
                    $this->Item->save_update($item_data, $item['item_id']);
                } else {
                    $item_data = array(
                        'quantity' => $cur_item_info->quantity - $quantity
                    );
                    $this->Item->save($item_data, $item['item_id']);
                    $warehouse_items = array(
                        'quantity' => $stores_items_db->quantity + $warehouse_items['quantity']
                    );
                    $this->Item->saveStoresItems1221($warehouse_items, $stores_items_db->id);
                }

                //checks if the quantity is out of stock
                if ($this->Item->get_info($item['item_id'])->quantity <= 0 and $out_of_stock_check) {
                    $message = $this->Item->get_info($item['item_id'])->name . ' ' . lang('sales_is_out_stock') . ' ' . $this->Item->get_info($item['item_id'])->quantity;
                    $email = true;
                }
                //checks if the quantity hits reorder level
                else if (($this->Item->get_info($item['item_id'])->quantity <= $this->Item->get_info($item['item_id'])->reorder_level) and $stock_recorder_check) {

                    $message = $this->Item->get_info($item['item_id'])->name . ' ' . lang('sales_hits_reorder_level') . ' ' . $this->Item->get_info($item['item_id'])->quantity;
                    $email = true;
                }

                //send email
                if ($this->config->item('receive_stock_alert') and $email) {
                    $this->load->library('email');
                    $config['mailtype'] = 'html';
                    $this->email->initialize($config);
                    $this->email->from($this->config->item('email'), $this->config->item('company'));
                    $this->email->to($this->config->item('stock_alert_email') ? $this->config->item('stock_alert_email') : $this->config->item('email'));

                    $this->email->subject(lang('sales_stock_alert_item_name') . $this->Item->get_info($item['item_id'])->name);
                    $this->email->message($message);
                    $this->email->send();
                }
                //Ramel Inventory Tracking
                //Inventory Count Details
                if ($cur_item_info->quantity_first > 0) {
                    if ($item['unit'] == "unit") {
                        $qty_buy = 0 - ($item['quantity'] * $cur_item_info->unit_rate);
                    } else {
                        $qty_buy = 0 - $item['quantity'];
                    }
                    $price = $item['price_rate'];
                } else {
                    $qty_buy = 0 - $item['quantity'];
                    $price = $item['price'];
                }
                $tam = $this->sale_lib->get_mode();
                if ($tam == 'sale') {
                    $sale_remarks = 'POS';
                } else {
                    $sale_remarks = 'RETURN_POS';
                }
                $inv_data = array(
                    'trans_date' => date('Y-m-d H:i:s'),
                    'trans_items' => $item['item_id'],
                    'trans_user' => $employee_id,
                    'trans_comment' => $sale_remarks,
                    'trans_inventory' => $qty_buy,
                    'trans_catid' => $cur_item_info->category,
                    'trans_money' => $price,
                    'trans_people' => $this->Customer->exists($customer_id) ? $customer_id : 0,
                    'trans_sale' => $sale_id,
                    'store_id' => $item['stored_id'],
                );
                $this->Inventory->insert($inv_data);
            } else {//hung audi 2-6-15 : ghép pack thay thế item_kit
                $cur_pack_info = $this->Pack->get_info($item['pack_id']);
                $sales_pack_data = array(
                    'sale_id' => $sale_id,
                    'pack_id' => $item['pack_id'],
                    'line' => $item['line'],
                    'description' => $item['description'],
                    'quantity_purchased' => $item['quantity'],
                    'unit_pack' => $cur_pack_info->unit,
                    'discount_percent' => $item['discount'],
                    'pack_cost_price' => $cur_pack_info->cost_price == NULL ? 0.00 : $cur_pack_info->cost_price,
                    'pack_unit_price' => $item['price'],
                    'id_customer' => $customer_id,
                    'date' => date('Y-m-d H:i:s'),
                );
                $this->db->insert('sales_packs', $sales_pack_data);

                foreach ($this->Pack_items->get_info($item['pack_id']) as $pack_item) {
                    $cur_item_info = $this->Item->get_info($pack_item->item_id);
                    $stock_recorder_check = false;
                    $out_of_stock_check = false;
                    $email = false;
                    $message = '';

                    //checks if the quantity is greater than reorder level
                    if ($cur_item_info->quantity > $cur_item_info->reorder_level) {
                        $stock_recorder_check = true;
                    }
                    //checks if the quantity is greater than reorder level
                    if ($cur_item_info->quantity > 0) {
                        $out_of_stock_check = true;
                    }

                    //Update stock quantity
                    $item_data = array(
                        'quantity' => $cur_item_info->quantity - ($item['quantity'] * $pack_item->quantity),
                        'quantity_total' => $cur_item_info->quantity_total - ($item['quantity'] * $pack_item->quantity)
                    );
                    $this->Item->save($item_data, $pack_item->item_id);

                    //checks if the quantity is out of stock
                    if ($this->Item->get_info($pack_item->item_id)->quantity <= 0 and $out_of_stock_check) {
                        $message = $this->Item->get_info($pack_item->item_id)->name . ' ' . lang('sales_is_out_stock') . ' ' . $this->Item->get_info($pack_item->item_id)->quantity;
                        $email = true;
                    }
                    //checks if the quantity hits reorder level
                    else if (($this->Item->get_info($pack_item->item_id)->quantity <= $this->Item->get_info($pack_item->item_id)->reorder_level) and $stock_recorder_check) {

                        $message = $this->Item->get_info($pack_item->item_id)->name . ' ' . lang('sales_hits_reorder_level') . ' ' . $this->Item->get_info($pack_item->item_id)->quantity;
                        $email = true;
                    }
                    //send email
                    if ($this->config->item('receive_stock_alert') and $email) {
                        $this->load->library('email');
                        $config['mailtype'] = 'html';
                        $this->email->initialize($config);
                        $this->email->from($this->config->item('email'), $this->config->item('company'));
                        $this->email->to($this->config->item('stock_alert_email') ? $this->config->item('stock_alert_email') : $this->config->item('email'));

                        $this->email->subject(lang('sales_stock_alert_item_name') . $this->Item->get_info($pack_item->item_id)->name);
                        $this->email->message($message);
                        $this->email->send();
                    }
                    //save inventory
                    $qty_buy = -$item['quantity'] * $pack_item->quantity;
                    $money = $pack_item->price;
                    $sale_remarks = 'POS';
                    $inv_data = array(
                        'trans_date' => date('Y-m-d H:i:s'),
                        'trans_items' => $pack_item->item_id,
                        'trans_packs' => $item['pack_id'],
                        'trans_user' => $employee_id,
                        'trans_comment' => $sale_remarks,
                        'trans_inventory' => $qty_buy,
                        'trans_catid' => $cur_item_info->category,
                        'trans_money' => $money,
                        'trans_people' => $this->Customer->exists($customer_id) ? $customer_id : 0,
                        'trans_sale' => $sale_id
                    );
                    $this->Inventory->insert($inv_data);

                }
            }

            $customer = $this->Customer->get_info($customer_id);
            if ($customer_id == -1 or $customer->taxable) {
                if (isset($item['item_id'])) {
                    foreach ($this->Item_taxes->get_info($item['item_id']) as $row) {
                        $this->db->insert('sales_items_taxes', array(
                            'sale_id' => $sale_id,
                            'item_id' => $item['item_id'],
                            'line' => $item['line'],
                            'name' => $row['name'],
                            'percent' => $row['percent'],
                            'cumulative' => $row['cumulative']
                        ));
                    }
                } else {//hung audi 2-6-15 pack
                    foreach ($this->Item_kit_taxes->get_info($item['pack_id']) as $row) {
                        $this->db->insert('sales_item_kits_taxes', array(
                            'sale_id' => $sale_id,
                            'item_kit_id' => $item['pack_id'],
                            'line' => $item['line'],
                            'name' => $row['name'],
                            'percent' => $row['percent'],
                            'cumulative' => $row['cumulative']
                        ));
                    }
                }
            }
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return -1;
        }
        return $sale_id;
    }

    //end save
    //materials
    function save_materials($items, $customer_id, $employee_id, $comment, $employees_id, $show_comment_on_receipt, $payments, $discount_money, $later_cost_price, $actual_money, $amount_due, $amount_due1, $sale_id = false, $suspended = 0, $liability = 0, $stt, $materials = 0, $date_debt, $cc_ref_no = '', $date_debt1, $symbol_order,$number_order , $co_1331, $co_1331_money, $no_131, $no_131_money) {
        if (count($items) == 0)
            return -1;

        $payment_types = '';
        foreach ($payments as $payment_id => $payment) {
            if ($liability == 1) {
                $payment_types = $payment_types . $payment['payment_type'] . ': ' . number_format($payment['payment_amount']) . '<br />';
            } else {
                if ($amount_due1 < 0) {
                    $payment_types = $payment_types . $payment['payment_type'] . ': ' . number_format($payment['payment_amount'] + $amount_due1) . '<br />';
                } else {
                    $payment_types = $payment_types . $payment['payment_type'] . ': ' . number_format($payment['payment_amount']) . '<br />';
                }
            }
        }

        $sales_data = array(
            'sale_time' => $date_debt,
            'customer_id' => $this->Customer->exists($customer_id) ? $customer_id : null,
            'employee_id' => $employee_id,
            'comment' => $comment,
            'show_comment_on_receipt' => $show_comment_on_receipt ? $show_comment_on_receipt : 0,
            'suspended' => $suspended,
            'deleted' => 0,
            'cc_ref_no' => $cc_ref_no,
            'date_debt' => $date_debt,
            'later_cost_price' => $later_cost_price,
            'discount_money' => $discount_money,
            'liability' => $liability,
            'materials' => $materials,
            'employees_id' => $employees_id,
            'symbol_order' => $symbol_order,
            'number_order' => $number_order,
            'date_debt1' => $date_debt1,
            'co_1331' => $co_1331,
            'co_1331_money' => $co_1331_money,
            'no_131' => $no_131,
            'no_131_money' => $no_131_money
        );

        //Run these queries as a transaction, we want to make sure we do all or nothing
        if ($sale_id) {
            $this->delete_sale_materials($sale_id, true);
            $this->db->where('sale_id', $sale_id);
            $this->db->update('sales', $sales_data);
        } else {
            $this->db->trans_start();
            $this->db->insert('sales', $sales_data);
            $sale_id = $this->db->insert_id();
        }

        foreach ($items as $line => $item) {
            if (isset($item['item_id'])) {
                $cur_item_info = $this->Item->get_info($item['item_id']);
                if ($item['unit'] == "unit") {
                    $unit_item_sale = $cur_item_info->unit;
                } else {
                    $unit_item_sale = $cur_item_info->unit_from;
                }
                $sales_items_data = array(
                    'id_customer' => $customer_id,
                    'sale_id' => $sale_id,
                    'item_id' => $item['item_id'],
                    'line' => $item['line'],
                    'description' => $item['description'],
                    'serialnumber' => $item['serialnumber'],
                    'quantity_purchased' => $item['quantity'],
                    'unit_item' => $unit_item_sale,
                    'discount_percent' => $item['discount'],
                    'taxes_percent' => $item['taxes'],
                    'item_cost_price' => $cur_item_info->cost_price,
                    'item_unit_price' => $item['price'],
                    'item_unit_price_rate' => $item['price_rate'],
                    'date' => date('Y-m-d H:i:s'),
                    'cat_id' => $cur_item_info->category,
                    'stored_id' => $item['stored_id'],
                );

                $this->db->insert('sales_items', $sales_items_data);
                $stock_recorder_check = false;
                $out_of_stock_check = false;
                $email = false;
                $message = '';

                //checks if the quantity is greater than reorder level
                if ($cur_item_info->quantity > $cur_item_info->reorder_level) {
                    $stock_recorder_check = true;
                }

                //checks if the quantity is greater than reorder level
                if ($cur_item_info->quantity > 0) {
                    $out_of_stock_check = true;
                }
                //checks if the quantity is out of stock
                if ($this->Item->get_info($item['item_id'])->quantity <= 0 and $out_of_stock_check) {
                    $message = $this->Item->get_info($item['item_id'])->name . ' ' . lang('sales_is_out_stock') . ' ' . $this->Item->get_info($item['item_id'])->quantity;
                    $email = true;
                }
                //checks if the quantity hits reorder level
                else if (($this->Item->get_info($item['item_id'])->quantity <= $this->Item->get_info($item['item_id'])->reorder_level) and $stock_recorder_check) {

                    $message = $this->Item->get_info($item['item_id'])->name . ' ' . lang('sales_hits_reorder_level') . ' ' . $this->Item->get_info($item['item_id'])->quantity;
                    $email = true;
                }

                //send email
                if ($this->config->item('receive_stock_alert') and $email) {
                    $this->load->library('email');
                    $config['mailtype'] = 'html';
                    $this->email->initialize($config);
                    $this->email->from($this->config->item('email'), $this->config->item('company'));
                    $this->email->to($this->config->item('stock_alert_email') ? $this->config->item('stock_alert_email') : $this->config->item('email'));

                    $this->email->subject(lang('sales_stock_alert_item_name') . $this->Item->get_info($item['item_id'])->name);
                    $this->email->message($message);
                    $this->email->send();
                }
                //Ramel Inventory Tracking
            } else {//hung audi 2-6-15 pack
                $cur_pack_info = $this->Pack->get_info($item['pack_id']);
                $sales_pack_data = array(
                    'sale_id' => $sale_id,
                    'pack_id' => $item['pack_id'],
                    'line' => $item['line'],
                    'description' => $item['description'],
                    'quantity_purchased' => $item['quantity'],
                    'unit_pack' => $cur_pack_info->unit,
                    'discount_percent' => $item['discount'],
                    'pack_cost_price' => $cur_pack_info->cost_price == NULL ? 0.00 : $cur_pack_info->cost_price,
                    'pack_unit_price' => $item['price'],
                    'id_customer' => $customer_id,
                    'date' => date('Y-m-d H:i:s'),
                );
                $this->db->insert('sales_packs', $sales_pack_data);

                foreach ($this->Pack_items->get_info($item['pack_id']) as $pack_item) {
                    $cur_item_info = $this->Item->get_info($pack_item->item_id);

                    $stock_recorder_check = false;
                    $out_of_stock_check = false;
                    $email = false;
                    $message = '';

                    //checks if the quantity is greater than reorder level
                    if ($cur_item_info->quantity > $cur_item_info->reorder_level) {
                        $stock_recorder_check = true;
                    }

                    //checks if the quantity is greater than reorder level
                    if ($cur_item_info->quantity > 0) {
                        $out_of_stock_check = true;
                    }

                    //Update stock quantity
                    //checks if the quantity is out of stock
                    if ($this->Item->get_info($pack_item->item_id)->quantity <= 0 and $out_of_stock_check) {
                        $message = $this->Item->get_info($pack_item->item_id)->name . ' ' . lang('sales_is_out_stock') . ' ' . $this->Item->get_info($pack_item->item_id)->quantity;
                        $email = true;
                    }
                    //checks if the quantity hits reorder level
                    else if (($this->Item->get_info($pack_item->item_id)->quantity <= $this->Item->get_info($pack_item->item_id)->reorder_level) and $stock_recorder_check) {

                        $message = $this->Item->get_info($pack_item->item_id)->name . ' ' . lang('sales_hits_reorder_level') . ' ' . $this->Item->get_info($pack_item->item_id)->quantity;
                        $email = true;
                    }
                    //send email
                    if ($this->config->item('receive_stock_alert') and $email) {
                        $this->load->library('email');
                        $config['mailtype'] = 'html';
                        $this->email->initialize($config);
                        $this->email->from($this->config->item('email'), $this->config->item('company'));
                        $this->email->to($this->config->item('stock_alert_email') ? $this->config->item('stock_alert_email') : $this->config->item('email'));

                        $this->email->subject(lang('sales_stock_alert_item_name') . $this->Item->get_info($pack_item->item_id)->name);
                        $this->email->message($message);
                        $this->email->send();
                    }
                }
            }

            $customer = $this->Customer->get_info($customer_id);
            if ($customer_id == -1 or $customer->taxable) {
                if (isset($item['item_id'])) {
                    foreach ($this->Item_taxes->get_info($item['item_id']) as $row) {
                        $this->db->insert('sales_items_taxes', array(
                            'sale_id' => $sale_id,
                            'item_id' => $item['item_id'],
                            'line' => $item['line'],
                            'name' => $row['name'],
                            'percent' => $row['percent'],
                            'cumulative' => $row['cumulative']
                        ));
                    }
                } else {//hung audi 2-6-15 pack
                    foreach ($this->Item_kit_taxes->get_info($item['pack_id']) as $row) {
                        $this->db->insert('sales_item_kits_taxes', array(
                            'sale_id' => $sale_id,
                            'item_kit_id' => $item['pack_id'],
                            'line' => $item['line'],
                            'name' => $row['name'],
                            'percent' => $row['percent'],
                            'cumulative' => $row['cumulative']
                        ));
                    }
                }
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return -1;
        }

        return $sale_id;
    }

    //end materials
    //liability
    function save_liability($items, $customer_id, $employee_id, $comment, $employees_id, $show_comment_on_receipt, $payments, $discount_money, $later_cost_price, $actual_money, $amount_due, $amount_due1, $sale_id = false, $suspended = 0, $liability = 0, $stt, $materials = 0, $date_debt, $cc_ref_no = '', $delivery_employee, $symbol_order,$number_order , $date_debt1, $co_1331, $co_1331_money, $no_131, $no_131_money) {
        if (count($items) == 0)
            return -1;

        $payment_types = '';
        foreach ($payments as $payment_id => $payment) {
            if ($liability == 1) {
                $payment_types = $payment_types . $payment['payment_type'] . ': ' . number_format($payment['payment_amount']) . '<br />';
            } else {
                if ($amount_due1 < 0) {
                    $payment_types = $payment_types . $payment['payment_type'] . ': ' . number_format($payment['payment_amount'] + $amount_due1) . '<br />';
                } else {
                    $payment_types = $payment_types . $payment['payment_type'] . ': ' . number_format($payment['payment_amount']) . '<br />';
                }
            }
        }

        $sales_data = array(
            'sale_time' => $date_debt,
            'customer_id' => $this->Customer->exists($customer_id) ? $customer_id : null,
            'employee_id' => $employee_id,
            'payment_type' => $payment_types,
            'comment' => $comment,
            'show_comment_on_receipt' => $show_comment_on_receipt ? $show_comment_on_receipt : 0,
            'suspended' => $suspended,
            'deleted' => 0,
            'cc_ref_no' => $cc_ref_no,
            'date_debt' => $date_debt,
            'later_cost_price' => $later_cost_price,
            'discount_money' => $discount_money,
            'liability' => $liability,
            'actual_money' => $actual_money,
            'employees_id' => $employees_id,
            'delivery_employee' => $delivery_employee,
            'symbol_order' => $symbol_order,
            'number_order' => $number_order,
            'date_debt1' => $date_debt1,
            'co_1331' => $co_1331,
            'co_1331_money' => $co_1331_money,
            'no_131' => $no_131,
            'no_131_money' => $no_131_money
        );

        $sales_data1 = array(
            'customer_id' => $this->Customer->exists($customer_id) ? $customer_id : null,
            'employee_id' => $employee_id,
            'payment_type' => $payment_types,
            'comment' => $comment,
            'show_comment_on_receipt' => $show_comment_on_receipt ? $show_comment_on_receipt : 0,
            'suspended' => $suspended,
            'deleted' => 0,
            'cc_ref_no' => $cc_ref_no,
            'date_debt' => $date_debt,
            'later_cost_price' => $later_cost_price,
            'discount_money' => $discount_money,
            'liability' => $liability,
            'actual_money' => $actual_money,
            'employees_id' => $employees_id,
            'delivery_employee' => $delivery_employee,
            'symbol_order' => $symbol_order,
            'number_order' => $number_order,
            'date_debt1' => $date_debt1,
            'co_1331' => $co_1331,
            'co_1331_money' => $co_1331_money,
            'no_131' => $no_131,
            'no_131_money' => $no_131_money
        );
        $sales_data2 = array(
            'customer_id' => $this->Customer->exists($customer_id) ? $customer_id : null,
            'employee_id' => $employee_id,
            'payment_type' => $payment_types,
            'comment' => $comment,
            'show_comment_on_receipt' => $show_comment_on_receipt ? $show_comment_on_receipt : 0,
            'suspended' => $suspended,
            'deleted' => 0,
            'cc_ref_no' => $cc_ref_no,
            'date_debt' => $date_debt,
            'later_cost_price' => $later_cost_price,
            'discount_money' => $discount_money,
            'liability' => $liability,
            'actual_money' => $actual_money,
            'employees_id' => $employees_id,
            'delivery_employee' => $delivery_employee,
            'materials' => 2,
            'symbol_order' => $symbol_order,
            'number_order' => $number_order,
            'date_debt1' => $date_debt1,
            'co_1331' => $co_1331,
            'co_1331_money' => $co_1331_money,
            'no_131' => $no_131,
            'no_131_money' => $no_131_money
        );
        //Run these queries as a transaction, we want to make sure we do all or nothing
        $dathang = $this->Sale->get_info_liability($sale_id);
        $material = $this->Sale->get_info_materials($sale_id);
        $this->db->trans_start();
        if ($sale_id) {
            $this->delete_sale_materials($sale_id, true);
            $this->db->where('sale_id', $sale_id);
            if ($material == 1) {
                $this->db->update('sales', $sales_data2);
            } else {
                $this->db->update('sales', $sales_data1);
            }
        } else {
            $this->db->trans_start();
            $this->db->insert('sales', $sales_data);
            $sale_id = $this->db->insert_id();
        }
        $cost_payment_amount = 0;
        //huyenlt^^ 11/09/14
        if ($liability == 1) {
            $sales_tam = array(
                'id_sale' => $sale_id,
                'pays_type' => $payment['payment_type'] . ' ',
                'pays_amount' => $payment['payment_amount'],
                'date_tam' => $date_debt,
                'discount_money' => $payment['discount_money'],
                'employees_id' => $employee_id,
                'stt' => 0,
                'dathang' => 1,
            );
            $this->db->insert('sales_tam', $sales_tam);
        } else {
            if ($dathang == 1) {
                if ($amount_due1 < 0) {
                    $sales_tam2 = array(
                        'id_sale' => $sale_id,
                        'pays_type' => $payment['payment_type'] . ' ',
                        'pays_amount' => $payment['payment_amount'] + $amount_due - $payment['discount_money'],
                        'date_tam' => $date_debt,
                        'discount_money' => $payment['discount_money'],
                        'employees_id' => $employee_id,
                        'stt' => 0,
                    );
                    $this->db->insert('sales_tam', $sales_tam2);
                } else {
                    $sales_tam3 = array(
                        'id_sale' => $sale_id,
                        'pays_type' => $payment['payment_type'] . ' ',
                        'pays_amount' => $payment['payment_amount'],
                        'date_tam' => $date_debt,
                        'discount_money' => $payment['discount_money'],
                        'employees_id' => $employee_id,
                        'stt' => 0,
                    );

                    $this->db->insert('sales_tam', $sales_tam3);
                }
            } else {
                if ($amount_due1 <= 0 && $stt == 0) {
                    // if($payment['payment_amount'] < 0 ){
                    $sales_tam4 = array(
                        'id_sale' => $sale_id,
                        'pays_type' => $payment['payment_type'] . ' ',
                        'pays_amount' => $payment['payment_amount'] + $amount_due1,
                        'date_tam' => $date_debt,
                        'discount_money' => $payment['discount_money'],
                        'employees_id' => $employee_id,
                        'stt' => 1,
                        'dathang' => 1
                    );
                    $this->db->insert('sales_tam', $sales_tam4);
                } elseif ($amount_due1 <= 0 && $stt == 1) {
                    $sales_tam5 = array(
                        'id_sale' => $sale_id,
                        'pays_type' => $payment['payment_type'] . ' ',
                        'pays_amount' => $payment['payment_amount'] + $amount_due1,
                        'date_tam' => $date_debt,
                        'discount_money' => $payment['discount_money'],
                        'employees_id' => $employee_id,
                        'stt' => 1,
                        'dathang' => 0
                    );
                    $this->db->insert('sales_tam', $sales_tam5);
                } else {
                    $sales_tam6 = array(
                        'id_sale' => $sale_id,
                        'pays_type' => $payment['payment_type'] . ' ',
                        'pays_amount' => str_replace(array(',', '.'), '', $payment['payment_amount']),
                        'date_tam' => $date_debt,
                        'discount_money' => str_replace(array(',', '.'), '', $payment['discount_money']),
                        'employees_id' => $employee_id,
                        'stt' => $stt,
                        'dathang' => 0
                    );

                    $this->db->insert('sales_tam', $sales_tam6);
                }
            }
        }
        //end huyenlt^^ 11/09

        foreach ($payments as $payment_id => $payment) {

            $cost_payment_amount += $payment['payment_amount'];
            if (substr($payment['payment_type'], 0, strlen(lang('sales_giftcard'))) == lang('sales_giftcard')) {
                /* We have a gift card and we have to deduct the used value from the total value of the card. */
                $splitpayment = explode(':', $payment['payment_type']);
                $cur_giftcard_value = $this->Giftcard->get_giftcard_value($splitpayment[1]);
                if (!$suspended)
                    $this->Giftcard->update_giftcard_value($splitpayment[1], $cur_giftcard_value - $payment['payment_amount']);
            }

            //th kh dat tien save all in database
            if ($liability == 1) {
                $sales_payments_data_later = array
                    (
                    'sale_id' => $sale_id,
                    'payment_type' => $payment['payment_type'] . ' ',
                    'payment_amount' => $payment['payment_amount'],
                    'discount_money' => $payment['discount_money'],
                );
                $this->db->insert('sales_payments', $sales_payments_data_later);
            } else {
                if ($amount_due1 <= 0) {
                    $sales_payments_data_later = array
                        (
                        'sale_id' => $sale_id,
                        'payment_type' => $payment['payment_type'] . ' ',
                        'payment_amount' => $payment['payment_amount'] + $amount_due1,
                        'discount_money' => $payment['discount_money'],
                    );

                    $this->db->insert('sales_payments', $sales_payments_data_later);
                    //tạo session khi có thanh toán bằng tiền mặt
                    $session_pay_amount_tm = array(
                        'payamount_tm' => $payment['payment_amount'] - $payment['discount_money'],
                    );
                    $this->session->set_userdata('payment_types_tm' . $sale_id . date('Y-m-d H:i:s'), $session_pay_amount_tm);
                } else {
                    $sales_payments_data = array
                        (
                        'sale_id' => $sale_id,
                        'payment_type' => $payment['payment_type'] . ' ',
                        'payment_amount' => $payment['payment_amount'],
                        'discount_money' => $payment['discount_money'],
                    );
                    $this->db->insert('sales_payments', $sales_payments_data);
                }
            }

            $ckbh = array(
                'chietkhaubanhang' => $discount_money,
            );
            $this->session->set_userdata('ckbh' . $sale_id, $ckbh);

            if ($suspended == 1) {
                if (!$this->exists_sale_inventory($sale_id)) {
                    $cur_customer_info = $this->Customer->get_info($sales_data['customer_id']);
                    $sales_cus_inventory = array(
                        'id_sale' => $sale_id,
                        'pay_type' => $payment['payment_type'],
                        'pay_amount' => $cost_payment_amount,
                        'id_customer' => $sales_data['customer_id'],
                        'date' => date('Y-m-d'),
                        'id_city_code' => $cur_customer_info->city,
                        'deleted' => 0
                    );
                    $this->db->insert('sales_inventory', $sales_cus_inventory);
                } else {
                    $cur_customer_info = $this->Customer->get_info($sales_data['customer_id']);
                    $sales_cus_inventory = array(
                        'pay_type' => $payment['payment_type'],
                        'pay_amount' => $cost_payment_amount,
                        'date' => date('Y-m-d'),
                    );
                    $this->db->where('id_sale', $sale_id);
                    $this->db->update('sales_inventory', $sales_cus_inventory);
                }
            } else {
                $array_sales_inventory = array('deleted' => 1);
                $this->db->where('id_sale', $sale_id);
                $this->db->update('sales_inventory', $array_sales_inventory);
            }
        }

        /* -------------------------------------------------------------- */
        $this->load->model('Cost');
        $cost_comment1 = "Thu tiền bán hàng từ " . $this->Customer->get_info($customer_id)->first_name . ' ' . $this->Customer->get_info($customer_id)->last_name . ' hình thức ' . $payment['payment_type'];
        $cost_comment2 = "Trả lại tiền dư khách hàng " . $this->Customer->get_info($customer_id)->first_name . ' ' . $this->Customer->get_info($customer_id)->last_name . ' đặt đơn đặt hàng ' . $sale_id;
        $cost_comment3 = "Chi tiền lấy lại hàng đã bán cho khách hàng " . $this->Customer->get_info($customer_id)->first_name . ' ' . $this->Customer->get_info($customer_id)->last_name;
        //huyenlt^^: th náº¿u khi láº¥y tiá»n mÃ  tiá»n Ä‘áº·t hÃ ng nhiá»u hÆ¡n
        if ($payment['payment_type'] == "CKNH") {
            $tkno = 1121;
        } else {
            $tkno = 1111;
        }
        if ($dathang == 1) {
            if ($amount_due1 >= 0) {
                $cost_data = array(
                    'id_customer' => $customer_id,
                    'name' => 4,
                    'form_cost' => 0,
                    'money' => str_replace(array(',', '.'), '', $payment['payment_amount']),
                    'date' => date('Y-m-d H:i:s'),
                    'cost_date_ct' => date('Y-m-d'),
                    'comment' => $cost_comment1,
                    'deleted' => 0,
                    'id_sale' => $sale_id,
                    'cost_employees' => $employee_id,
                );
                $this->db->insert('costs', $cost_data);
            } elseif ($liability == 1) {   //Ä‘áº·t hÃ ng: Ä‘áº·t tiá»n láº§n thá»© 2
                $cost_data = array(
                    'id_customer' => $customer_id,
                    'name' => 4,
                    'form_cost' => 0,
                    'money' => str_replace(array(',', '.'), '', $payment['payment_amount']),
                    'date' => date('Y-m-d H:i:s'),
                    'cost_date_ct' => date('Y-m-d'),
                    'comment' => $cost_comment1,
                    'deleted' => 0,
                    'id_sale' => $sale_id,
                    'cost_employees' => $employee_id,
                );
                $this->db->insert('costs', $cost_data);
            } else {
                $term = $this->get_max_id($sale_id);
                $term1 = $this->get_money_max_id($term->id);
                $term2 = $total_order - $discount_money;
                $term_money = $total_order - $term2;
                if ($term_money > 0) {
                    $cost_data = array(
                        'id_customer' => $customer_id,
                        'name' => 4,
                        'money' => (str_replace(array(',', '.'), '', $payment['payment_amount']) + $amount_due1),
                        'form_cost' => 0,
                        'date' => date('Y-m-d H:i:s'),
                        'cost_date_ct' => date('Y-m-d'),
                        'comment' => $cost_comment2,
                        'deleted' => 0,
                        'id_sale' => $sale_id,
                        'stt_thu' => 2, //tien chi nay dc save vÃ o trong báº£ng chi n k Ä‘c tÃ­nh trong pháº§n giao ca^^
                        'cost_employees' => $employee_id,
                    );
                    $this->db->insert('costs', $cost_data);
                } else {
                    $cost_data2 = array(
                        'id_customer' => $customer_id,
                        'name' => 4,
                        'form_cost' => 1,
                        'money' => (str_replace(array(',', '.'), '', $payment['payment_amount']) + $amount_due1) * (-1),
                        'date' => date('Y-m-d H:i:s'),
                        'cost_date_ct' => date('Y-m-d'),
                        'comment' => $cost_comment2,
                        'deleted' => 0,
                        'id_sale' => $sale_id,
                        'stt_thu' => 2, //tien chi nay dc save vÃ o trong báº£ng chi n k Ä‘c tÃ­nh trong pháº§n giao ca^^
                        'cost_employees' => $employee_id,
                    );
                    $this->db->insert('costs', $cost_data2);
                }
            }
        } else { // huyenlt^^:truong hop dat hang
            if ($liability == 1) {
                // k tiá»n Ä‘áº·t hÃ ng nhá» hÆ¡n tiá»n Ä‘Æ¡n hÃ ng
                if ($payment['payment_amount'] > 0) {
                    $amount_due2 = str_replace(array('.00', '.'), '', $amount_due1);
                    $cost_data1 = array(
                        'id_customer' => $customer_id,
                        'name' => 4,
                        'money' => ($payment['payment_amount']),
                        'form_cost' => 0,
                        'date' => date('Y-m-d H:i:s'),
                        'cost_date_ct' => date('Y-m-d'),
                        'comment' => $cost_comment1,
                        'deleted' => 0,
                        'id_sale' => $sale_id,
                        'cost_employees' => $employee_id,
                        'tk_no' => $tkno,
                        'tk_co' => 131
                    );
                    $this->db->insert('costs', $cost_data1);
                }
            } else {
                if (($amount_due1 < 0) && ($dathang == 0 )) {
                    $cost_data1 = array(
                        'id_customer' => $customer_id,
                        'name' => 27,
                        'money' => $payment['payment_amount'] + $amount_due1, //xet che do tra hang
                        'form_cost' => 0,
                        'date' => date('Y-m-d H:i:s'),
                        'cost_date_ct' => date('Y-m-d'),
                        'comment' => $cost_comment1,
                        'deleted' => 0,
                        'id_sale' => $sale_id,
                        'cost_employees' => $employee_id,
                        'stt_thu' => 0,
                    );

                    $this->db->insert('costs', $cost_data1);
                } else {
                    $cost_data2 = array(
                        'id_customer' => $customer_id,
                        'name' => 4,
                        'money' => $payment['payment_amount'],
                        'form_cost' => 0,
                        'date' => date('Y-m-d H:i:s'),
                        'cost_date_ct' => date('Y-m-d'),
                        'comment' => $cost_comment1,
                        'deleted' => 0,
                        'id_sale' => $sale_id,
                        'cost_employees' => $employee_id,
                    );

                    $this->db->insert('costs', $cost_data2);
                }
            }
        }

        foreach ($items as $line => $item) {
            if (isset($item['item_id'])) {
                $cur_item_info = $this->Item->get_info($item['item_id']);
                if ($item['unit'] == "unit") {
                    $unit_item_sale = $cur_item_info->unit;
                } else {
                    $unit_item_sale = $cur_item_info->unit_from;
                }
                $sales_items_data = array(
                    'id_customer' => $customer_id,
                    'sale_id' => $sale_id,
                    'item_id' => $item['item_id'],
                    'line' => $item['line'],
                    'description' => $item['description'],
                    'serialnumber' => $item['serialnumber'],
                    'discount_percent' => $item['discount'],
                     'taxes_percent' => $item['taxes'],
                    'quantity_purchased' => $item['quantity'],
                    'unit_item' => $unit_item_sale,
                    'taxes_percent' => $item['taxes'],
                    'item_cost_price' => $cur_item_info->cost_price,
                    'item_unit_price' => $item['price'],
                    'item_unit_price_rate' => $item['price_rate'],
                    'date' => date('Y-m-d H:i:s'),
                    'cat_id' => $cur_item_info->category,
                    'stored_id' => $item['stored_id'],
                );
                $this->db->insert('sales_items', $sales_items_data);

                $stock_recorder_check = false;
                $out_of_stock_check = false;
                $email = false;
                $message = '';

                //checks if the quantity is greater than reorder level
                if ($cur_item_info->quantity > $cur_item_info->reorder_level) {
                    $stock_recorder_check = true;
                }

                //checks if the quantity is greater than reorder level
                if ($cur_item_info->quantity > 0) {
                    $out_of_stock_check = true;
                }

                //checks if the quantity is out of stock
                if ($this->Item->get_info($item['item_id'])->quantity <= 0 and $out_of_stock_check) {
                    $message = $this->Item->get_info($item['item_id'])->name . ' ' . lang('sales_is_out_stock') . ' ' . $this->Item->get_info($item['item_id'])->quantity;
                    $email = true;
                }
                //checks if the quantity hits reorder level
                else if (($this->Item->get_info($item['item_id'])->quantity <= $this->Item->get_info($item['item_id'])->reorder_level) and $stock_recorder_check) {

                    $message = $this->Item->get_info($item['item_id'])->name . ' ' . lang('sales_hits_reorder_level') . ' ' . $this->Item->get_info($item['item_id'])->quantity;
                    $email = true;
                }

                //send email
                if ($this->config->item('receive_stock_alert') and $email) {
                    $this->load->library('email');
                    $config['mailtype'] = 'html';
                    $this->email->initialize($config);
                    $this->email->from($this->config->item('email'), $this->config->item('company'));
                    $this->email->to($this->config->item('stock_alert_email') ? $this->config->item('stock_alert_email') : $this->config->item('email'));

                    $this->email->subject(lang('sales_stock_alert_item_name') . $this->Item->get_info($item['item_id'])->name);
                    $this->email->message($message);
                    $this->email->send();
                }
            } else {//hung audi 2-6-15 pack
                $cur_pack_info = $this->Pack->get_info($item['pack_id']);
                $sales_pack_data = array(
                    'sale_id' => $sale_id,
                    'pack_id' => $item['pack_id'],
                    'line' => $item['line'],
                    'description' => $item['description'],
                    'quantity_purchased' => $item['quantity'],
                    'unit_pack' => $cur_pack_info->unit,
                    'discount_percent' => $item['discount'],
                    'pack_cost_price' => $cur_pack_info->cost_price == NULL ? 0.00 : $cur_pack_info->cost_price,
                    'pack_unit_price' => $item['price'],
                    'id_customer' => $customer_id,
                    'date' => date('Y-m-d H:i:s'),
                );
                $this->db->insert('sales_packs', $sales_pack_data);

                foreach ($this->Pack_items->get_info($item['pack_id']) as $pack_item) {
                    $cur_item_info = $this->Item->get_info($pack_item->item_id);

                    $stock_recorder_check = false;
                    $out_of_stock_check = false;
                    $email = false;
                    $message = '';

                    //checks if the quantity is greater than reorder level
                    if ($cur_item_info->quantity > $cur_item_info->reorder_level) {
                        $stock_recorder_check = true;
                    }

                    //checks if the quantity is greater than reorder level
                    if ($cur_item_info->quantity > 0) {
                        $out_of_stock_check = true;
                    }
                    //checks if the quantity is out of stock
                    if ($this->Item->get_info($pack_item->item_id)->quantity <= 0 and $out_of_stock_check) {
                        $message = $this->Item->get_info($pack_item->item_id)->name . ' ' . lang('sales_is_out_stock') . ' ' . $this->Item->get_info($pack_item->item_id)->quantity;
                        $email = true;
                    }
                    //checks if the quantity hits reorder level
                    else if (($this->Item->get_info($pack_item->item_id)->quantity <= $this->Item->get_info($pack_item->item_id)->reorder_level) and $stock_recorder_check) {

                        $message = $this->Item->get_info($pack_item->item_id)->name . ' ' . lang('sales_hits_reorder_level') . ' ' . $this->Item->get_info($pack_item->item_id)->quantity;
                        $email = true;
                    }

                    //send email
                    if ($this->config->item('receive_stock_alert') and $email) {
                        $this->load->library('email');
                        $config['mailtype'] = 'html';
                        $this->email->initialize($config);
                        $this->email->from($this->config->item('email'), $this->config->item('company'));
                        $this->email->to($this->config->item('stock_alert_email') ? $this->config->item('stock_alert_email') : $this->config->item('email'));
                        $this->email->subject(lang('sales_stock_alert_item_name') . $this->Item->get_info($pack_item->item_id)->name);
                        $this->email->message($message);
                        $this->email->send();
                    }
                }
            }

            $customer = $this->Customer->get_info($customer_id);
            if ($customer_id == -1 or $customer->taxable) {
                if (isset($item['item_id'])) {
                    foreach ($this->Item_taxes->get_info($item['item_id']) as $row) {
                        $this->db->insert('sales_items_taxes', array(
                            'sale_id' => $sale_id,
                            'item_id' => $item['item_id'],
                            'line' => $item['line'],
                            'name' => $row['name'],
                            'percent' => $row['percent'],
                            'cumulative' => $row['cumulative']
                        ));
                    }
                } else {//hung audi 2-6-15 pack
                    foreach ($this->Item_kit_taxes->get_info($item['pack_id']) as $row) {
                        $this->db->insert('sales_item_kits_taxes', array(
                            'sale_id' => $sale_id,
                            'item_kit_id' => $item['pack_id'],
                            'line' => $item['line'],
                            'name' => $row['name'],
                            'percent' => $row['percent'],
                            'cumulative' => $row['cumulative']
                        ));
                    }
                }
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return -1;
        }

        return $sale_id;
    }

    //end liability
    //6-6-15 hung audi reports revenue_employee
    function get_sale_revenue_employee($employee_id, $sale_type, $items_services) {
        $this->db->select('s.sale_id as sale_id');
        $this->db->from('sales s');

        if ($items_services == 'product') {
            $this->db->join('sales_items si', 's.sale_id=si.sale_id');
            $this->db->join('items i', 'si.item_id = i.item_id');
            $this->db->where('i.service', 0);
        } elseif ($items_services == 'service') {
            $this->db->join('sales_items si', 's.sale_id = si.sale_id');
            $this->db->join('items i', 'si.item_id = i.item_id');
            $this->db->where('i.service', 1);
        } elseif ($items_services == 'produce') {
            $this->db->join('sales_items si', 's.sale_id = si.sale_id');
            $this->db->join('items i', 'si.item_id = i.item_id');
            $this->db->where('i.produce', 1);
        } elseif ($items_services == 'pack') {
            $this->db->join('sales_packs sp', 's.sale_id = sp.sale_id');
        }

        if ($sale_type == 'sales') {
            $this->db->where('later_cost_price >=', 0);
        } else if ($sale_type == 'returns') {
            $this->db->where('later_cost_price <', 0);
        }

        $this->db->where('employee_id', $employee_id);
        $this->db->order_by('s.sale_id', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sales_tam_by_date_detail_sale_revenue2($start_date, $end_date, $sale_id) {
        $this->db->select('s.*,p.first_name as first_name, pe.first_name as first_name1,p.last_name as last_name, pe.last_name as last_name1,
        	sa.comment as comment,sa.liability, sum(s.pays_amount) pays_amount2, sum(s.discount_money) discount_money2,
                p.person_id as pid');
        $this->db->from('sales_tam s');
        $this->db->join('sales sa', 'sa.sale_id=s.id_sale', 'inner');
        $this->db->join('people p', 'sa.customer_id=p.person_id', 'left');
        $this->db->join('people pe', 'sa.employee_id=pe.person_id', 'left');
        $this->db->where('sa.liability', 0);
        $this->db->where('sa.sale_time >=', $start_date);
        $this->db->where('sa.sale_time <=', $end_date);
        $this->db->where('s.id_sale', $sale_id);
        $this->db->group_by('sa.sale_id');

        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sale_item_revenue_employee($id, $items_services) {
        if ($items_services == 'product') {
            $this->db->select('s.*,i.name,i.unit_from unit_from,i.unit unit, i.unit_rate unit_rate, i.*');
            $this->db->from('sales_items s');
            $this->db->join('items i', 'i.item_id=s.item_id', 'inner');
            $this->db->where('s.sale_id', $id);
            $this->db->where('i.service', 0);
            $query = $this->db->get()->result_array();
        } else if ($items_services == 'service') {
            $this->db->select('s.*,i.name,i.unit_from unit_from,i.unit unit, i.unit_rate unit_rate, i.*');
            $this->db->from('sales_items s');
            $this->db->join('items i', 'i.item_id=s.item_id', 'inner');
            $this->db->where('s.sale_id', $id);
            $this->db->where('i.service', 1);
            $query = $this->db->get()->result_array();
        } else if ($items_services == 'produce') {
            $this->db->select('s.*,i.name,i.unit_from unit_from,i.unit unit, i.unit_rate unit_rate, i.*');
            $this->db->from('sales_items s');
            $this->db->join('items i', 'i.item_id=s.item_id', 'inner');
            $this->db->where('s.sale_id', $id);
            $this->db->where('i.produce', 1);
            $query = $this->db->get()->result_array();
        } else if ($items_services == 'pack') {
            $this->db->select('sp.*, sp.pack_id item_id, sp.unit_pack unit_item,
        		sp.pack_unit_price item_unit_price, p.pack_number item_number, p.name name1, p.*');
            $this->db->from('sales_packs sp');
            $this->db->join('packs p', 'sp.pack_id = p.pack_id', 'inner');
            $this->db->join('units', 'units.id_unit = sp.unit_pack', 'inner');
            $this->db->where('sp.sale_id', $id);
            $query = $this->db->get()->result_array();
        } else {//all
            $this->db->select('s.*,i.name,i.unit_from unit_from,i.unit unit, i.unit_rate unit_rate, i.*');
            $this->db->from('sales_items s');
            $this->db->join('items i', 'i.item_id=s.item_id', 'inner');
            $this->db->where('s.sale_id', $id);
            $query1 = $this->db->get()->result_array();

            $this->db->select('sp.*, sp.pack_id item_id, sp.unit_pack unit_item,
	        	sp.pack_unit_price item_unit_price, p.pack_number item_number, p.name name1, p.*');
            $this->db->from('sales_packs sp');
            $this->db->join('packs p', 'sp.pack_id = p.pack_id', 'inner');
            $this->db->join('units', 'units.id_unit = sp.unit_pack', 'inner');
            $this->db->where('sp.sale_id', $id);
            $query2 = $this->db->get()->result_array();

            $query = array_merge($query1, $query2);
        }
        return $query;
    }

    //END revenue_emp
    //hung 10-6-15
    function get_sale_packs($sale_id) {
        $this->db->from('sales_packs');
        $this->db->where('sale_id', $sale_id);
        return $this->db->get();
    }

    //hung audi 11-6-15 report: specific_customer
    function get_sale_by_customer_specific_customer($customer_id, $sale_type, $report_type) {
        $this->db->select('sales.sale_id as sale_id');
        $this->db->from('sales');

        if ($customer_id != 0) {
            $this->db->where('customer_id', $customer_id);
        } else {
            $this->db->where('customer_id', NULL);
        }

        if ($sale_type == 'returns') {
            $this->db->where('later_cost_price <', 0);
        } elseif ($sale_type == 'sales') {
            $this->db->where('later_cost_price >=', 0);
        }

        if ($report_type == 'product') {
            $this->db->join('sales_items si', 'sales.sale_id=si.sale_id');
            $this->db->join('items', 'si.item_id=items.item_id');
            $this->db->where('items.service', 0);
        } elseif ($report_type == 'service') {
            $this->db->join('sales_items si', 'sales.sale_id=si.sale_id');
            $this->db->join('items', 'si.item_id=items.item_id');
            $this->db->where('items.service', 1);
        } elseif ($report_type == 'produce') {
            $this->db->join('sales_items si', 'sales.sale_id=si.sale_id');
            $this->db->join('items', 'si.item_id=items.item_id');
            $this->db->where('items.produce', 1);
        } elseif ($report_type == 'pack') {
            $this->db->join('sales_packs sp', 'sales.sale_id = sp.sale_id');
        }
        $this->db->order_by('sales.sale_id', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sales_tam_by_date_detail_specific_customer($start_date, $end_date, $sale_id, $customer_id) {
        $this->db->from('sales_tam s');
        $this->db->join('sales sa', 'sa.sale_id=s.id_sale', 'inner');
        $this->db->join('people pe', 'sa.employee_id=pe.person_id', 'inner');

        if ($customer_id != 0) {
            $this->db->select('s.*, pe.first_name as first_name1, pe.last_name as last_name1, sa.comment as comment,
				sa.liability, sum(s.pays_amount) pays_amount2, sum(s.discount_money) discount_money2, p.*');
            $this->db->join('people p', 'sa.customer_id=p.person_id', 'inner');
        } else {
            $this->db->select('s.*,pe.first_name as first_name1,  pe.last_name as last_name1, sa.comment as comment,
				sa.liability, sum(s.pays_amount) pays_amount2, sum(s.discount_money) discount_money2');
            $this->db->where('sa.liability <>', 1);
        }

        $this->db->where('sa.sale_time >=', $start_date);
        $this->db->where('sa.sale_time <=', $end_date);
        $this->db->where('s.id_sale', $sale_id);
        $this->db->group_by('s.id_sale');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sale_item_by_sale_id_specific_customer($id, $report_type) {
        if ($report_type == 'product') {
            $this->db->select('s.*,i.name,i.unit_from unit_from,i.unit unit, i.unit_rate unit_rate, i.*');
            $this->db->from('sales_items s');
            $this->db->join('items i', 'i.item_id=s.item_id', 'inner');
            $this->db->where('s.sale_id', $id);
            $this->db->where('i.service', 0);
            $query = $this->db->get()->result_array();
        } else if ($report_type == 'service') {
            $this->db->select('s.*,i.name,i.unit_from unit_from,i.unit unit, i.unit_rate unit_rate, i.*');
            $this->db->from('sales_items s');
            $this->db->join('items i', 'i.item_id=s.item_id', 'inner');
            $this->db->where('s.sale_id', $id);
            $this->db->where('i.service', 1);
            $query = $this->db->get()->result_array();
        } else if ($report_type == 'produce') {
            $this->db->select('s.*,i.name,i.unit_from unit_from,i.unit unit, i.unit_rate unit_rate, i.*');
            $this->db->from('sales_items s');
            $this->db->join('items i', 'i.item_id=s.item_id', 'inner');
            $this->db->where('s.sale_id', $id);
            $this->db->where('i.produce', 1);
            $query = $this->db->get()->result_array();
        } else if ($report_type == 'pack') {
            $this->db->select('sp.*, sp.pack_id item_id, sp.unit_pack unit_item,
        		sp.pack_unit_price item_unit_price, p.pack_number item_number, p.name name1, p.*');
            $this->db->from('sales_packs sp');
            $this->db->join('packs p', 'sp.pack_id = p.pack_id', 'inner');
            $this->db->join('units', 'units.id_unit = sp.unit_pack', 'inner');
            $this->db->where('sp.sale_id', $id);
            $query = $this->db->get()->result_array();
        } else {//all
            $this->db->select('s.*,i.name,i.unit_from unit_from,i.unit unit, i.unit_rate unit_rate, i.*');
            $this->db->from('sales_items s');
            $this->db->join('items i', 'i.item_id=s.item_id', 'inner');
            $this->db->where('s.sale_id', $id);
            $query1 = $this->db->get()->result_array();

            $this->db->select('sp.*, sp.pack_id item_id, sp.unit_pack unit_item,
	        	sp.pack_unit_price item_unit_price, p.pack_number item_number, p.name name1, p.*');
            $this->db->from('sales_packs sp');
            $this->db->join('packs p', 'sp.pack_id = p.pack_id', 'inner');
            $this->db->join('units', 'units.id_unit = sp.unit_pack', 'inner');
            $this->db->where('sp.sale_id', $id);
            $query2 = $this->db->get()->result_array();

            $query = array_merge($query1, $query2);
        }
        return $query;
    }

    //end specific_customer
    //15-6-15 hung audi reports summary_employees
    function get_employee_in_sale($start_date, $end_date, $sale_type, $item_type, $employee_id) {
        $this->db->from('sales s');
        if ($item_type == 3) {
            $this->db->join('sales_items si', 'si.sale_id = s.sale_id');
            $this->db->join('items i', 'si.item_id = i.item_id');
            $this->db->where('i.produce', 1);
        } elseif ($item_type == 0 || $item_type == 1) {
            $this->db->join('sales_items si', 'si.sale_id = s.sale_id');
            $this->db->join('items i', 'si.item_id = i.item_id');
            $this->db->where('i.service', $item_type);
            $this->db->where('i.produce', 0);
        } elseif ($item_type == 2) {
            $this->db->join('sales_packs sp', 'sp.sale_id = s.sale_id');
        }
        if ($sale_type == 'sales') {
            $this->db->where('s.later_cost_price >', 0);
        } elseif ($sale_type == 'returns') {
            $this->db->where('s.later_cost_price <', 0);
        }
        $this->db->where('s.deleted', 0);
        $this->db->where('s.materials !=', 1);
        $this->db->where('s.sale_time >=', $start_date);
        $this->db->where('s.sale_time <=', $end_date);
        $this->db->where('employee_id', $employee_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_employee_in_sale_all($start_date, $end_date, $sale_type, $item_type) {
        $this->db->from('sales s');
        if ($item_type == 3) {
            $this->db->join('sales_items si', 'si.sale_id = s.sale_id');
            $this->db->join('items i', 'si.item_id = i.item_id');
            $this->db->where('i.produce', 1);
        } elseif ($item_type == 0 || $item_type == 1) {
            $this->db->join('sales_items si', 'si.sale_id = s.sale_id');
            $this->db->join('items i', 'si.item_id = i.item_id');
            $this->db->where('i.service', $item_type);
            $this->db->where('i.produce', 0);
        } elseif ($item_type == 2) {
            $this->db->join('sales_packs sp', 'sp.sale_id = s.sale_id');
        }
        if ($sale_type == 'sales') {
            $this->db->where('s.later_cost_price >', 0);
        } elseif ($sale_type == 'returns') {
            $this->db->where('s.later_cost_price <', 0);
        }
        $this->db->where('s.deleted', 0);
        $this->db->where('s.materials !=', 1);
        $this->db->where('s.sale_time >=', $start_date);
        $this->db->where('s.sale_time <=', $end_date);
        $this->db->group_by('employee_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sale_item_by_summary_employee($start_date, $end_date, $sale_type, $employee_id, $sale_id, $item_type) {
        if ($item_type == 3) {//thanh pham
            $this->db->from('sales_items si');
            $this->db->join('sales s', 'si.sale_id = s.sale_id');
            $this->db->join('items i', 'si.item_id = i.item_id');
            $this->db->where('s.employee_id', $employee_id);
            if ($sale_type == 'sales') {
                $this->db->where('s.later_cost_price >', 0);
            } elseif ($sale_type == 'returns') {
                $this->db->where('s.later_cost_price <', 0);
            }
            $this->db->where('i.produce', 1);
            $this->db->where('s.sale_id', $sale_id);
            $this->db->where('s.deleted', 0);
            $this->db->where('s.sale_time >=', $start_date);
            $this->db->where('s.sale_time <=', $end_date);
            $query = $this->db->get()->result_array();
        } elseif ($item_type == 0 || $item_type == 1) {//sp || dv
            $this->db->from('sales_items si');
            $this->db->join('sales s', 'si.sale_id = s.sale_id');
            $this->db->join('items i', 'si.item_id = i.item_id');
            $this->db->where('s.employee_id', $employee_id);
            if ($sale_type == 'sales') {
                $this->db->where('s.later_cost_price >', 0);
            } elseif ($sale_type == 'returns') {
                $this->db->where('s.later_cost_price <', 0);
            }
            $this->db->where('i.service', $item_type);
            $this->db->where('i.produce', 0);
            $this->db->where('s.sale_id', $sale_id);
            $this->db->where('s.deleted', 0);
            $this->db->where('s.sale_time >=', $start_date);
            $this->db->where('s.sale_time <=', $end_date);
            $query = $this->db->get()->result_array();
        } elseif ($item_type == 2) {//goi sp
            $this->db->from('sales_packs si');
            $this->db->join('sales s', 'si.sale_id = s.sale_id');
            $this->db->join('packs i', 'si.pack_id = i.pack_id');
            $this->db->where('s.employee_id', $employee_id);
            if ($sale_type == 'sales') {
                $this->db->where('s.later_cost_price >', 0);
            } elseif ($sale_type == 'returns') {
                $this->db->where('s.later_cost_price <', 0);
            }
            $this->db->where('s.sale_id', $sale_id);
            $this->db->where('s.deleted', 0);
            $this->db->where('s.sale_time >=', $start_date);
            $this->db->where('s.sale_time <=', $end_date);
            $query = $this->db->get()->result_array();
        } elseif ($item_type == 4) {//all
            $this->db->from('sales_items si');
            $this->db->join('sales s', 'si.sale_id = s.sale_id');
            $this->db->join('items i', 'si.item_id = i.item_id');
            $this->db->where('s.employee_id', $employee_id);
            if ($sale_type == 'sales') {
                $this->db->where('s.later_cost_price >', 0);
            } elseif ($sale_type == 'returns') {
                $this->db->where('s.later_cost_price <', 0);
            }
            $this->db->where('s.sale_id', $sale_id);
            $this->db->where('s.deleted', 0);
            $this->db->where('s.sale_time >=', $start_date);
            $this->db->where('s.sale_time <=', $end_date);
            $query1 = $this->db->get()->result_array();

            $this->db->from('sales_packs sp');
            $this->db->join('sales s', 'sp.sale_id = s.sale_id');
            $this->db->join('packs p', 'sp.pack_id = p.pack_id');
            $this->db->where('s.employee_id', $employee_id);
            if ($sale_type == 'sales') {
                $this->db->where('s.later_cost_price >', 0);
            } elseif ($sale_type == 'returns') {
                $this->db->where('s.later_cost_price <', 0);
            }
            $this->db->where('s.sale_id', $sale_id);
            $this->db->where('s.deleted', 0);
            $this->db->where('s.sale_time >=', $start_date);
            $this->db->where('s.sale_time <=', $end_date);
            $query2 = $this->db->get()->result_array();

            $query = array_merge($query1, $query2);
        }
        return $query;
    }

    function get_sale_tam_by_summary_employee($start_date, $end_date, $employee_id, $sale_type) {
        $this->db->select('sum(st.pays_amount) as pays_amount, sum(st.discount_money) as discount_money');
        $this->db->from('sales_tam st');
        $this->db->join('sales s', 'st.id_sale = s.sale_id');
        $this->db->where('s.employee_id', $employee_id);
        if ($sale_type == 'sales') {
            $this->db->where('s.later_cost_price >', 0);
        } elseif ($sale_type == 'returns') {
            $this->db->where('s.later_cost_price <', 0);
        }
        $this->db->where('s.deleted', 0);
        $this->db->where('s.sale_time >=', $start_date);
        $this->db->where('s.sale_time <=', $end_date);
        $this->db->group_by('s.employee_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    //end summary_employees
    //hung audi 27-6-15 reports summary_suppliers
    //Lay ma nha cung cap co trong bang receiving
    function get_supplier_in_receiving($start_date, $end_date) {
        $this->db->from("receivings");
        $this->db->where('receiving_time >=', $start_date);
        $this->db->where('receiving_time <=', $end_date);
        $this->db->group_by("supplier_id");
        $query = $this->db->get();
        return $query->result_array();
    }

    //Lay thong tin cac don hang nhap hang theo ma nha cung cap
    function get_receiving_by_supplier($supplier_id, $sale_type, $start_date, $end_date) {
        $this->db->from("receivings");
        $this->db->join("receivings_items", "receivings.receiving_id = receivings_items.receiving_id", "inner");
        if ($sale_type == "sales") {
            $this->db->where("quantity_purchased >", 0);
        } elseif ($sale_type == "returns") {
            $this->db->where("quantity_purchased <", 0);
        }
        $this->db->where("supplier_id", $supplier_id);
        $this->db->where('receiving_time >=', $start_date);
        $this->db->where('receiving_time <=', $end_date);
        $query = $this->db->get();
        return $query->result_array();
    }

    ////Lay thong tin cac don hang nhap hang theo ma nha cung cap
    function get_receiving_by_supplier_other_taxes($supplier_id, $sale_type, $start_date, $end_date) {
        $this->db->from("receivings");
        $this->db->join("receivings_items", "receivings.receiving_id = receivings_items.receiving_id", "inner");
        if ($sale_type == "sales") {
            $this->db->where("quantity_purchased >", 0);
        } elseif ($sale_type == "returns") {
            $this->db->where("quantity_purchased <", 0);
        }
        $this->db->where("supplier_id", $supplier_id);
        $this->db->where('receiving_time >=', $start_date);
        $this->db->where('receiving_time <=', $end_date);
        $this->db->group_by('receivings.receiving_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    //29-6-15 hung audi reports specific_stored
    function get_sale_specific_stored($stored_id, $sale_type, $report_type) {
        $this->db->select('s.sale_id as sale_id');
        $this->db->from('sales s');

        if ($report_type == 'product') {//mặt hàng
            if ($stored_id == 9999) {  //all
                $this->db->join('sales_items si', 's.sale_id=si.sale_id');
                $this->db->join('items i', 'si.item_id = i.item_id');
                $this->db->where('i.service', 0);
            } elseif ($stored_id == 7777) { //kho tổng
                $this->db->join('sales_items si', 's.sale_id=si.sale_id');
                $this->db->join('items i', 'si.item_id = i.item_id');
                $this->db->where('i.service', 0);
                $this->db->where('si.stored_id', 0);
            } else {//kho #
                $this->db->join('sales_items si', 's.sale_id=si.sale_id');
                $this->db->join('items i', 'si.item_id = i.item_id');
                $this->db->where('i.service', 0);
                $this->db->where('si.stored_id', $stored_id);
            }
        } elseif ($report_type == 'service') {//dịch vụ
            if ($stored_id == 9999) {  //all
                $this->db->join('sales_items si', 's.sale_id=si.sale_id');
                $this->db->join('items i', 'si.item_id = i.item_id');
                $this->db->where('i.service', 1);
            } elseif ($stored_id == 7777) { //kho tổng
                $this->db->join('sales_items si', 's.sale_id=si.sale_id');
                $this->db->join('items i', 'si.item_id = i.item_id');
                $this->db->where('i.service', 1);
                $this->db->where('si.stored_id', 0);
            } else {//kho #
                $this->db->join('sales_items si', 's.sale_id=si.sale_id');
                $this->db->join('items i', 'si.item_id = i.item_id');
                $this->db->where('i.service', 1);
                $this->db->where('si.stored_id', $stored_id);
            }
        } elseif ($report_type == 'produce') {//thành phẩm
            if ($stored_id == 9999) {  //all
                $this->db->join('sales_items si', 's.sale_id = si.sale_id');
                $this->db->join('items i', 'si.item_id = i.item_id');
                $this->db->where('i.produce', 1);
            } elseif ($stored_id == 7777) { //kho tổng
                $this->db->join('sales_items si', 's.sale_id = si.sale_id');
                $this->db->join('items i', 'si.item_id = i.item_id');
                $this->db->where('i.produce', 1);
                $this->db->where('si.stored_id', 0);
            } else {//kho #
                $this->db->join('sales_items si', 's.sale_id = si.sale_id');
                $this->db->join('items i', 'si.item_id = i.item_id');
                $this->db->where('i.produce', 1);
                $this->db->where('si.stored_id', $stored_id);
            }
        } elseif ($report_type == 'pack') {//gói sản phẩm
            $this->db->join('sales_packs sp', 's.sale_id = sp.sale_id');
            if ($stored_id != 8888 && $stored_id != 9999) { //khác kho sản phẩm & all
                $this->db->where('sp.stored_id', $stored_id);
            }
        } else {//all
            if ($stored_id != 9999) {  //all
                if ($stored_id == 7777) { //kho tổng
                    $this->db->join('sales_items si', 's.sale_id = si.sale_id');
                    $this->db->join('items i', 'si.item_id = i.item_id');
                    $this->db->where('si.stored_id', 0);
                } elseif ($stored_id == 8888) { //kho san pham
                    $this->db->join('sales_packs sp', 's.sale_id = sp.sale_id');
                } else {//kho #
                    $this->db->join('sales_items si', 's.sale_id = si.sale_id');
                    $this->db->join('items i', 'si.item_id = i.item_id');
                    $this->db->where('si.stored_id', $stored_id);
                }
            }
        }
        if ($sale_type == 'sales') {
            $this->db->where('later_cost_price >=', 0);
        } else if ($sale_type == 'returns') {
            $this->db->where('later_cost_price <', 0);
        }
        $this->db->order_by('s.sale_id', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sales_tam_specific_stored($start_date, $end_date, $sale_id) {
        $this->db->select('s.*, sum(s.pays_amount) pays_amount2, sum(s.discount_money) discount_money2,
        	sa.comment as comment,sa.liability');
        $this->db->from('sales_tam s');
        $this->db->join('sales sa', 'sa.sale_id=s.id_sale', 'inner');
        $this->db->where('sa.liability', 0);
        $this->db->where('s.date_tam >=', $start_date);
        $this->db->where('s.date_tam <=', $end_date);
        $this->db->where('s.id_sale', $sale_id);
        $this->db->group_by('sa.sale_id');

        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sale_item_specific_stored($id, $report_type, $stored_id) {
        if ($report_type == 'product') {
            $this->db->select('s.*,i.name,i.unit_from unit_from,i.unit unit, i.unit_rate unit_rate, i.*');
            $this->db->from('sales_items s');
            $this->db->join('items i', 'i.item_id=s.item_id', 'inner');
            $this->db->where('s.sale_id', $id);
            $this->db->where('i.service', 0);
            $query = $this->db->get()->result_array();
        } else if ($report_type == 'service') {
            $this->db->select('s.*,i.name,i.unit_from unit_from,i.unit unit, i.unit_rate unit_rate, i.*');
            $this->db->from('sales_items s');
            $this->db->join('items i', 'i.item_id=s.item_id', 'inner');
            $this->db->where('s.sale_id', $id);
            $this->db->where('i.service', 1);
            $query = $this->db->get()->result_array();
        } else if ($report_type == 'produce') {
            $this->db->select('s.*,i.name,i.unit_from unit_from,i.unit unit, i.unit_rate unit_rate, i.*');
            $this->db->from('sales_items s');
            $this->db->join('items i', 'i.item_id=s.item_id', 'inner');
            $this->db->where('s.sale_id', $id);
            $this->db->where('i.produce', 0);
            $query = $this->db->get()->result_array();
        } else if ($report_type == 'pack') {
            $this->db->select('sp.*, sp.pack_id item_id, sp.unit_pack unit_item, sp.pack_unit_price item_unit_price,
        		 p.pack_number item_number, p.name name1, p.*');
            $this->db->from('sales_packs sp');
            $this->db->join('packs p', 'sp.pack_id = p.pack_id', 'inner');
            $this->db->join('units', 'units.id_unit = sp.unit_pack', 'inner');
            $this->db->where('sp.sale_id', $id);
            $query = $this->db->get()->result_array();
        } else {//all
            $this->db->select('s.*,i.name,i.unit_from unit_from,i.unit unit, i.unit_rate unit_rate, i.*');
            $this->db->from('sales_items s');
            $this->db->join('items i', 'i.item_id=s.item_id', 'inner');
            $this->db->where('s.sale_id', $id);
            if ($stored_id != 9999) {  //all
                if ($stored_id == 7777) { //kho tổng
                    $this->db->where('s.stored_id', 0);
                } else {//kho # & kho sp
                    $this->db->where('s.stored_id', $stored_id);
                }
            }
            $query1 = $this->db->get()->result_array();

            $this->db->select('sp.*, sp.pack_id item_id, sp.unit_pack unit_item, sp.pack_unit_price item_unit_price,
	        	 p.pack_number item_number, p.name name1, p.*');
            $this->db->from('sales_packs sp');
            $this->db->join('packs p', 'sp.pack_id = p.pack_id', 'inner');
            $this->db->join('units', 'units.id_unit = sp.unit_pack', 'inner');
            $this->db->where('sp.sale_id', $id);
            if ($stored_id != 9999 && $stored_id != 8888) {  //all & kho sp
                if ($stored_id == 7777) {
                    $this->db->where('sp.stored_id', $stored_id);
                } else {
                    $this->db->where('sp.stored_id', $stored_id);
                }
            }
            $query2 = $this->db->get()->result_array();

            $query = array_merge($query1, $query2);
        }
        return $query;
    }

    //END specific_stored
    //th thanh toan
    function get_payment_sumary($start_date, $end_date, $sale_type) {
        $this->db->select('sp.payment_type, sales.customer_id');
        $this->db->from('sales_payments sp');
        $this->db->join('sales', 'sp.sale_id=sales.sale_id');
        $this->db->where('sales.sale_time >=', $start_date);
        $this->db->where('sales.sale_time <=', $end_date);
        $this->db->where('sales.deleted', 0);
        if ($sale_type == 'sales') {
            $this->db->where('sales.later_cost_price >=', 0);
        } elseif ($sale_type == 'returns') {
            $this->db->where('sales.later_cost_price <=', 0);
        }
        $this->db->group_by('payment_type');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_payment_money_sumary($start_date, $end_date, $sale_type) {
        $this->db->select('sp.*,sales.customer_id');
        $this->db->from('sales_payments sp');
        $this->db->join('sales', 'sp.sale_id=sales.sale_id');
        $this->db->where('sales.sale_time >=', $start_date);
        $this->db->where('sales.sale_time <=', $end_date);
        $this->db->where('sales.deleted', 0);
        if ($sale_type == 'sales') {
            $this->db->where('sales.later_cost_price >=', 0);
        } elseif ($sale_type == 'returns') {
            $this->db->where('sales.later_cost_price <=', 0);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    //bc tổng hợp chiết khấu dungbv
    function get_total_discount($start_date, $end_date, $sale_type) {
        $this->db->select('*');
        $this->db->from('sales_items');
        $this->db->join('items', 'sales_items.item_id = items.item_id', 'inner');
        $this->db->join('sales', 'sales_items.sale_id = sales.sale_id', 'inner');
        $this->db->where('sales.sale_time >=', $start_date);
        $this->db->where('sales.sale_time <=', $end_date);
        $this->db->where('discount_percent >', 0);
        if ($sale_type == 'sales') {
            $this->db->where('sales.later_cost_price >=', 0);
        } elseif ($sale_type == 'returns') {
            $this->db->where('sales.later_cost_price <=', 0);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_total_discount_recv($start_date, $end_date, $sale_type) {
        $this->db->select('*');
        $this->db->from('receivings_items');
        $this->db->join('items', 'receivings_items.item_id = items.item_id', 'inner');
        $this->db->join('receivings', 'receivings_items.receiving_id = receivings.receiving_id', 'inner');
        $this->db->where('receivings.receiving_time  >=', $start_date);
        $this->db->where('receivings.receiving_time  <=', $end_date);
        $this->db->where('discount_percent >', 0);
        if ($sale_type == 'sales') {
            $this->db->where('receivings_items.quantity_purchased >', 0);
        } elseif ($sale_type == 'returns') {
            $this->db->where('receivings_items.quantity_purchased <', 0);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    //end dungbv
    //6-7-15 hung audi reports summary_customers
    function get_customer_in_sale($start_date, $end_date, $sale_type, $item_type, $customer_id) {
        $this->db->from('sales s');
        if ($item_type == 3) {
            $this->db->join('sales_items si', 'si.sale_id = s.sale_id');
            $this->db->join('items i', 'si.item_id = i.item_id');
            $this->db->where('i.produce', 1);
        } elseif ($item_type == 0 || $item_type == 1) {
            $this->db->join('sales_items si', 'si.sale_id = s.sale_id');
            $this->db->join('items i', 'si.item_id = i.item_id');
            $this->db->where('i.service', $item_type);
            $this->db->where('i.produce', 0);
        } elseif ($item_type == 2) {
            $this->db->join('sales_packs sp', 'sp.sale_id = s.sale_id');
        }
        if ($sale_type == 'sales') {
            $this->db->where('s.later_cost_price >', 0);
        } elseif ($sale_type == 'returns') {
            $this->db->where('s.later_cost_price <', 0);
        }
        $this->db->where('s.deleted', 0);
        $this->db->where('s.materials !=', 1);
        $this->db->where('s.sale_time >=', $start_date);
        $this->db->where('s.sale_time <=', $end_date);
        if ($customer_id == null) {
            $this->db->where('customer_id', NULL);
        } else {
            $this->db->where('customer_id', $customer_id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_customer_in_sale_all($start_date, $end_date, $sale_type, $item_type) {
        $this->db->from('sales s');
        if ($item_type == 3) {
            $this->db->join('sales_items si', 'si.sale_id = s.sale_id');
            $this->db->join('items i', 'si.item_id = i.item_id');
            $this->db->where('i.produce', 1);
        } elseif ($item_type == 0 || $item_type == 1) {
            $this->db->join('sales_items si', 'si.sale_id = s.sale_id');
            $this->db->join('items i', 'si.item_id = i.item_id');
            $this->db->where('i.service', $item_type);
            $this->db->where('i.produce', 0);
        } elseif ($item_type == 2) {
            $this->db->join('sales_packs sp', 'sp.sale_id = s.sale_id');
        }
        if ($sale_type == 'sales') {
            $this->db->where('s.later_cost_price >', 0);
        } elseif ($sale_type == 'returns') {
            $this->db->where('s.later_cost_price <', 0);
        }
        $this->db->where('s.deleted', 0);
        $this->db->where('s.materials !=', 1);
        $this->db->where('s.sale_time >=', $start_date);
        $this->db->where('s.sale_time <=', $end_date);
        $this->db->group_by('customer_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sale_item_by_summary_customer($start_date, $end_date, $sale_type, $customer_id, $sale_id, $item_type) {
        if ($item_type == 3) {//thanh pham
            $this->db->from('sales_items si');
            $this->db->join('sales s', 'si.sale_id = s.sale_id');
            $this->db->join('items i', 'si.item_id = i.item_id');
            if ($customer_id == null) {
                $this->db->where('s.customer_id', NULL);
            } else {
                $this->db->where('s.customer_id', $customer_id);
            }
            if ($sale_type == 'sales') {
                $this->db->where('s.later_cost_price >', 0);
            } elseif ($sale_type == 'returns') {
                $this->db->where('s.later_cost_price <', 0);
            }
            $this->db->where('i.produce', 1);
            $this->db->where('s.sale_id', $sale_id);
            $this->db->where('s.deleted', 0);
            $this->db->where('s.sale_time >=', $start_date);
            $this->db->where('s.sale_time <=', $end_date);
            $query = $this->db->get()->result_array();
        } elseif ($item_type == 0 || $item_type == 1) {//sp || dv
            $this->db->from('sales_items si');
            $this->db->join('sales s', 'si.sale_id = s.sale_id');
            $this->db->join('items i', 'si.item_id = i.item_id');
            if ($customer_id == null) {
                $this->db->where('s.customer_id', NULL);
            } else {
                $this->db->where('s.customer_id', $customer_id);
            }
            if ($sale_type == 'sales') {
                $this->db->where('s.later_cost_price >', 0);
            } elseif ($sale_type == 'returns') {
                $this->db->where('s.later_cost_price <', 0);
            }
            $this->db->where('i.service', $item_type);
            $this->db->where('i.produce', 0);
            $this->db->where('s.sale_id', $sale_id);
            $this->db->where('s.deleted', 0);
            $this->db->where('s.sale_time >=', $start_date);
            $this->db->where('s.sale_time <=', $end_date);
            $query = $this->db->get()->result_array();
        } elseif ($item_type == 2) {//goi sp
            $this->db->from('sales_packs si');
            $this->db->join('sales s', 'si.sale_id = s.sale_id');
            $this->db->join('packs i', 'si.pack_id = i.pack_id');
            if ($customer_id == null) {
                $this->db->where('s.customer_id', NULL);
            } else {
                $this->db->where('s.customer_id', $customer_id);
            }
            if ($sale_type == 'sales') {
                $this->db->where('s.later_cost_price >', 0);
            } elseif ($sale_type == 'returns') {
                $this->db->where('s.later_cost_price <', 0);
            }
            $this->db->where('s.sale_id', $sale_id);
            $this->db->where('s.deleted', 0);
            $this->db->where('s.sale_time >=', $start_date);
            $this->db->where('s.sale_time <=', $end_date);
            $query = $this->db->get()->result_array();
        } elseif ($item_type == 4) {//all
            $this->db->from('sales_items si');
            $this->db->join('sales s', 'si.sale_id = s.sale_id');
            $this->db->join('items i', 'si.item_id = i.item_id');
            if ($customer_id == null) {
                $this->db->where('s.customer_id', NULL);
            } else {
                $this->db->where('s.customer_id', $customer_id);
            }
            if ($sale_type == 'sales') {
                $this->db->where('s.later_cost_price >', 0);
            } elseif ($sale_type == 'returns') {
                $this->db->where('s.later_cost_price <', 0);
            }
            $this->db->where('s.sale_id', $sale_id);
            $this->db->where('s.deleted', 0);
            $this->db->where('s.sale_time >=', $start_date);
            $this->db->where('s.sale_time <=', $end_date);
            $query1 = $this->db->get()->result_array();

            $this->db->from('sales_packs sp');
            $this->db->join('sales s', 'sp.sale_id = s.sale_id');
            $this->db->join('packs p', 'sp.pack_id = p.pack_id');
            if ($customer_id == null) {
                $this->db->where('s.customer_id', NULL);
            } else {
                $this->db->where('s.customer_id', $customer_id);
            }
            if ($sale_type == 'sales') {
                $this->db->where('s.later_cost_price >', 0);
            } elseif ($sale_type == 'returns') {
                $this->db->where('s.later_cost_price <', 0);
            }
            $this->db->where('s.sale_id', $sale_id);
            $this->db->where('s.deleted', 0);
            $this->db->where('s.sale_time >=', $start_date);
            $this->db->where('s.sale_time <=', $end_date);
            $query2 = $this->db->get()->result_array();

            $query = array_merge($query1, $query2);
        }
        return $query;
    }

    function get_sale_tam_by_summary_customer($start_date, $end_date, $customer_id, $sale_type) {
        $this->db->select('sum(st.pays_amount) as pays_amount, sum(st.discount_money) as discount_money');
        $this->db->from('sales_tam st');
        $this->db->join('sales s', 'st.id_sale = s.sale_id');
        if ($customer_id == null) {
            $this->db->where('s.customer_id', NULL);
        } else {
            $this->db->where('s.customer_id', $customer_id);
        }
        if ($sale_type == 'sales') {
            $this->db->where('s.later_cost_price >', 0);
        } elseif ($sale_type == 'returns') {
            $this->db->where('s.later_cost_price <', 0);
        }
        $this->db->where('s.deleted', 0);
        $this->db->where('s.sale_time >=', $start_date);
        $this->db->where('s.sale_time <=', $end_date);
        $this->db->group_by('s.customer_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    //end summary_customers
    //hóa đơn bán hàng dungbv----------$$
    function get_all($limit = 10000, $offset = 0, $col = 'sale_id', $order = 'desc') {
        $this->db->from('sales')
                ->where('deleted', 0)
                ->where('liability',0)
                ->order_by($col, $order)
                ->limit($limit)
                ->offset($offset);
        return $this->db->get();
    }

    public function count_all() {
        $query = $this->db->where('deleted', 0)
                ->get('sales');
        return $query->num_rows();
    }

    // lay tong gia tri 1 don hang nhap
    function get_total_sale($sale_id) {
        $this->db->select('*,SUM(item_unit_price*quantity_purchased - item_unit_price*quantity_purchased*discount_percent/100) as total_price');
        $this->db->from('sales_items');
        $this->db->where('sale_id', $sale_id);
        $this->db->group_by('sale_id');
        $query = $this->db->get();
        return $query->row_array();
    }

    function get_sale_tam($sale_id, $start_date = '', $end_date = '') {
        $this->db->select('*');
        $this->db->from('sales_tam');
        $this->db->where('id_sale', $sale_id);
        $this->db->select_sum('pays_amount');
        $this->db->select_sum('discount_money');
        $this->db->group_by('id_sale');
        if ($start_date != '' && $end_date != '') {
            $this->db->where('date_tam >=', $start_date);
            $this->db->where('date_tam <=', $end_date);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sale_items2($sale_id) {
        $this->db->from('sales_items si');
        $this->db->join('items i', 'si.item_id=i.item_id', 'left');
        $this->db->where('sale_id', $sale_id);
        return $this->db->get();
    }

    function get_search_suggestions($search, $limit = 25) {
        $suggestions = array();
        $this->db->from('sales')
                ->like('sale_id', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both')
                ->where('deleted', 0)
                ->order_by("sale_id", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('label' => $row->sale_id);
        }

        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    function search_count_all($start_date, $end_date, $search) {
        $start_date2 = "and sale_time >= '$start_date'";
        $end_date2 = "and sale_time <= '$end_date'";
        $this->db->from('sales')
                ->where("(sale_id LIKE '%" . $this->db->escape_like_str($search) . "%' )
                $start_date2 $end_date2 ");
        $result = $this->db->get();
        return $result->num_rows();
    }

    function search($start_date, $end_date, $search, $limit = 20, $offset = 0, $column = 'sale_id', $orderby = 'desc') {
        $start_date2 = "and sale_time >= '$start_date'";
        $end_date2 = "and sale_time <= '$end_date'";
        $this->db->from('sales')
                ->where("( sale_id LIKE '%" . $this->db->escape_like_str($search) . "%' )
                	 $start_date2 $end_date2 ")
                ->order_by($column, $orderby)
                ->limit($limit)
                ->offset($offset);
        return $this->db->get();
    }

    // lấy sale_id
    function get_info_sale_order($sale_id) {
        $this->db->from('sales');
        $this->db->where('sale_id', $sale_id);
        return $this->db->get()->row();
    }

    //lấy các mặt hàng sale_id
    public function get_sale_item_order() {
        return $this->db->get('sales_items')->result_array();
    }

    public function delete_sale_order($data, $sale_id) {
        $this->db->where('sale_id', $sale_id);
        $this->db->update('sales', $data);
    }

        
    function payment($sale_id){
        $this->db->select('SUM(money)as sum');
        $this->db->where('id_sale',$sale_id);
         
        
         
       return  $this->db->get('costs')->result_array();
         //$this->db->last_query();
        
    }
        // tong thanh toan
    public function pay_amount_order() {
        $this->db->select('*');
        $this->db->from('sales_tam');
        $this->db->select_sum('pays_amount');
        $this->db->select_sum('discount_money');
        $this->db->group_by('id_sale');
        return $this->db->get()->result_array();
    }

    public function get_discount_money() {
        $this->db->group_by('sale_id');
        return $this->db->get('sales_payments')->result_array();
    }

    public function get_taxes_item() {
        $this->db->select('*');
        return $this->db->get('items')->result_array();
    }

     public function all_sales_pack($sale_id){
            $this->db->where('sale_id',$sale_id);
            return $this->db->get('sales_packs')->result();
        }
    //end dungbv
    //Bao cao ban hang
    function get_sale_by_date_item($start_date, $end_date, $item_type) {
        $this->db->from("sales");
        $this->db->join("sales_items", "sales.sale_id=sales_items.sale_id", "inner");
        $this->db->join("items", "sales_items.item_id=items.item_id", "inner");
        $this->db->where("sales.deleted", 0);
        $this->db->where("sale_time >=", $start_date);
        $this->db->where("sale_time <=", $end_date);
        if ($item_type == 3) {
            $this->db->where("items.produce", 1);
        } else {
            $this->db->where("items.service", $item_type);
            $this->db->where("items.produce", 0);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function get_sale_by_date_pack($start_date, $end_date) {
        $this->db->from("sales");
        $this->db->join("sales_packs", "sales.sale_id=sales_packs.sale_id", "inner");
        $this->db->join("packs", "sales_packs.pack_id=packs.pack_id", "inner");
        $this->db->where("sales.deleted", 0);
        $this->db->where("sale_time >=", $start_date);
        $this->db->where("sale_time <=", $end_date);
        $query = $this->db->get();
        return $query->result();
    }

    function get_all_sale_by_date($start_date, $end_date) {
        $this->db->from("sales");
        $this->db->where("sales.deleted", 0);
        $this->db->where("materials !=", 1);
        $this->db->where("sale_time >=", $start_date);
        $this->db->where("sale_time <=", $end_date);
        $this->db->order_by('sale_id','desc');
        $query = $this->db->get();
        return $query->result();
    }

    function get_item_in_sale($sale_id) {
        $this->db->from("sales");
        $this->db->join("sales_items", "sales.sale_id=sales_items.sale_id", "inner");
        $this->db->join("items", "sales_items.item_id=items.item_id", "inner");
        $this->db->where("sales.sale_id", $sale_id);
        $query = $this->db->get();
        return $query->result();
    }

    function get_pack_in_sale($sale_id) {
        $this->db->from("sales");
        $this->db->join("sales_packs", "sales.sale_id=sales_packs.sale_id", "inner");
        $this->db->join("packs", "sales_packs.pack_id=packs.pack_id", "inner");
        $this->db->where("sales.sale_id", $sale_id);
        $query = $this->db->get();
        return $query->result();
    }

    function get_sale_suspended_by_customer($customer_id, $start_date, $end_date) {
        $this->db->where("customer_id", $customer_id);
        $this->db->where("deleted", 0);
        $this->db->where("sale_time >=", $start_date);
        $this->db->where("sale_time <=", $end_date);
        $this->db->where('suspended', 1);
        $this->db->order_by('sale_id', 'asc');
        $query = $this->db->get("sales");
        return $query->result();
    }

    function get_sale_pack_by_sale_pack($sale_id, $pack_id){
        $this->db->where("sale_id", $sale_id);
        $this->db->where("pack_id", $pack_id);
        $query = $this->db->get("sales_packs");
        return $query->row();
    }

    function get_sale_item_by_sale_item($sale_id, $item_id) {
        $this->db->where("sale_id", $sale_id);
        $this->db->where("item_id", $item_id);
        $query = $this->db->get("sales_items");
        return $query->row();
    }

    function get_sale_nkbh($start_date, $end_date) {
        return $this->db->from('sales')
                        ->where('sale_time >=', $start_date)
                        ->where('sale_time <=', $end_date)
                        ->order_by('sale_time', 'desc')
                        ->get();
    }

    function get_order_service_bh($start_date, $end_date){
        $this->db->where('delete',0);
        $this->db->where('stt',1);
        $this->db->where('create_date >=',$start_date);
        $this->db->where('create_date <=',$end_date);
        return $this->db->get('order_service');
    }

     function get_chungtu_bh(){
        return $this->db->get('chungtu_detail');
    }

     function get_money_sale($customer_id){
        $this->db->where('customer_id',$customer_id);
        $this->db->where('suspended',1);
        $this->db->where('deleted',0);
        return $this->db->get('sales');
    }

    function money_get_sale_tam(){
        $this->db->from('sales_tam');
        $query = $this->db->get();
        return $query->result();
    }
    /*
     *
     */
    function update_sale_customer($data_customer, $sale_id){
        $this->db->where('sale_id',$sale_id);
        $this->db->update('sales',$data_customer);
    }

    function get_store_by_sale($sale_id) {
        $this->db->where("sale_id", $sale_id);
        $query = $this->db->get("sales_items");
         
        
        return $query->row()->stored_id;//$this->db->last_query();
    }

}

?>
