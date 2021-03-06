<?php

class Receiving extends CI_Model {

    public function get_info($receiving_id) {
        $this->db->from('receivings');
        $this->db->where('receiving_id', $receiving_id);
        return $this->db->get();
    }

    function exists($receiving_id) {
        $this->db->from('receivings');
        $this->db->where('receiving_id', $receiving_id);
        $query = $this->db->get();

        return ($query->num_rows() == 1);
    }

    function update($receiving_data, $receiving_id) {
        $this->db->where('receiving_id', $receiving_id);
        $success = $this->db->update('receivings', $receiving_data);
//		var_dump($this->db->last_query());exit();
        return $success;
    }

    //NCC - huyenlt^^
    function get_all_suspended() {
        $this->db->from('receivings');
        $this->db->where('deleted', 0);
        $this->db->where('suspended', 1);
        $this->db->order_by('receiving_id', desc);
        //$this->db->order_by('sale_id');
        return $this->db->get();
    }

    function exists_receiving_inventory($receiving_id) {
        $this->db->from('receivings_inventory');
        $this->db->where('id_receiving', $receiving_id);
        $query = $this->db->get();
        return ($query->num_rows() == 1);
    }

    //end 
    function save($items, $supplier_id, $employee_id, $comment, $payment_type, $inventory_id = 0, $amount_tendered, $suspended = 0, $receiving_id = false, $mode, $date_debt, $bank_account, $total_order, $symbol_order, $number_order, $number_taxes, $date_debt1,$other_cost ,$no_1331, $money_1331, $co_331, $money_331, $load_account) {
        if (count($items) == 0)
            return -1;
        
        if ($amount_tendered > 0 && $payment_type == "Tiền mặt"){
            $tk_no = 156;
            $tk_co = 111;
        }else{
            $tk_no = 0;
            $tk_co = 0;
        }
        
        //payment_type costs
        if($payment_type == 'Tiền mặt')
            $payment_type_cost = 1;
        else if($payment_type == 'CKNH')
            $payment_type_cost = 2;
        else if($payment_type == 'COD')
            $payment_type_cost = 3;
        else if($payment_type == 'trả góp')
            $payment_type_cost = 4;
        else if($payment_type == 'trả nhiều lần')
            $payment_type_cost = 5;

        
        if (!$receiving_id) {
            $amount_tendered1 = number_format($amount_tendered);
            //th:trả hàng NCC

            if ($amount_tendered1 < 0) {
                if ($payment_type == 'CKNH') {
                    $receivings_data = array(
                        'supplier_id' => $this->Supplier->exists($supplier_id) ? $supplier_id : null,
                        'employee_id' => $employee_id,
                        'payment_type' => $payment_type . ':' . $amount_tendered1,
                        'comment' => $comment,
                        'inventory_id' => $inventory_id,
                        'suspended' => $suspended,
                        'clause' => 112,
                        'reciprocal' => 156,
                        'later_cost_price' => $total_order
                    );
                } else {
                    $receivings_data = array(
                        'supplier_id' => $this->Supplier->exists($supplier_id) ? $supplier_id : null,
                        'employee_id' => $employee_id,
                        'payment_type' => ($payment_type == '') ? ('Tiền mặt' . ':' . $amount_tendered1) : $payment_type . ':' . $amount_tendered1,
                        'comment' => $comment,
                        'inventory_id' => $inventory_id,
                        'suspended' => $suspended,
                        'clause' => 111, //gtri hang hoa , ghi nợ
                        'reciprocal' => 156, //tiền mặt
                        'later_cost_price' => $total_order
                    );
                }
            }


            //th:nhập hàng
            else {
                if ($payment_type == 'CKNH') {
                    $receivings_data = array(
                        'receiving_time' => $date_debt,
                        'supplier_id' => $this->Supplier->exists($supplier_id) ? $supplier_id : null,
                        'employee_id' => $employee_id,
                        'payment_type' => $payment_type . ':' . $amount_tendered1,
                        'comment' => $comment,
                        'inventory_id' => $inventory_id,
                        'suspended' => $suspended,
                        'clause' => ($suspended == 1) ? 331 : 156,
                        'reciprocal' => 112,
                        'date_debt' => $date_debt,
                        'later_cost_price' => $total_order,
                        'symbol_order' => $symbol_order,
                        'number_order' => $number_order,
                        'number_taxes' => $number_taxes,
                         'date_debt1' => $date_debt1,
                        'other_cost' => $other_cost,
                         'no_1331' => $no_1331,
                        'money_1331' => $money_1331,
                        'co_331' => $co_331,
                        'money_331' => $money_331
                    );
                } else {
                    $receivings_data = array(
                        'receiving_time' => $date_debt,
                        'supplier_id' => $this->Supplier->exists($supplier_id) ? $supplier_id : null,
                        'employee_id' => $employee_id,
                        'payment_type' => ($payment_type == '') ? ('Tiền mặt' . ':' . $amount_tendered1) : $payment_type . ':' . $amount_tendered1,
                        'comment' => $comment,
                        'inventory_id' => $inventory_id,
                        'suspended' => $suspended,
                        'clause' => ($suspended == 1) ? 331 : 156, //gtri hang hoa , ghi nợ , 331 là tk xđ ghi nợ NCC
                        'reciprocal' => 111, //tiền mặt
                        'date_debt' => $date_debt,
                        'later_cost_price' => $total_order,
                        'symbol_order' => $symbol_order,
                        'number_order' => $number_order,
                        'number_taxes' => $number_taxes,
                         'date_debt1' => $date_debt1,
                        'other_cost' => $other_cost,
                         'no_1331' => $no_1331,
                        'money_1331' => $money_1331,
                        'co_331' => $co_331,
                        'money_331' => $money_331
                    );
                }
            }
            //Run these queries as a transaction, we want to make sure we do all or nothing
            $this->db->trans_start();
            
            //save receivings
            $this->db->insert('receivings', $receivings_data);
            $receiving_id = $this->db->insert_id();
            
            //save receivings_tam
            $receivings_tam = array(
                'pays_type' => $payment_type,
                'pays_amount' => $amount_tendered,
                'id_receiving' => $receiving_id,
                'date_tam' => date('Y-m-d H:i:s'),
                'employees_id' => $employee_id,
            );
            $this->db->insert('receivings_tam', $receivings_tam);
            
            //save receivings_inventory
            if ($suspended == 1) {
                if (!$this->exists_receiving_inventory($receiving_id)) {
                    $receiving_cus_inventory = array(
                        'id_receiving' => $receiving_id,
                        'pay_type' => $payment_type,
                        'pay_amount' => $amount_tendered,
                        'id_supplier' => $this->Supplier->exists($supplier_id) ? $supplier_id : null,
                        'date' => date('Y-m-d'),
                        'deleted' => 0
                    );
                    $this->db->insert('receivings_inventory', $receiving_cus_inventory);
                } else {
                    $receiving_cus_inventory = array(
                        'pay_amount' => $amount_tendered,
                        'date' => date('Y-m-d'),
                    );
                    $this->db->where('id_receiving', $receiving_id);
                    $this->db->update('receivings_inventory', $receiving_cus_inventory);
                }
            }

            foreach ($items as $line => $item) {
                $cur_item_info = $this->Item->get_info($item['item_id']);
                if (($cur_item_info->unit_rate > 0) && ($cur_item_info->quantity_first > 0)) {
                    $quan = $cur_item_info->unit_rate * $item['quantity'] / $cur_item_info->quantity_first;
                } else {
                    $quan = $item['quantity'];
                }
                 $net_price = $item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100;
                $x = ($net_price / $this->receiving_lib->get_total_order_of_item()) * $this->receiving_lib->get_other_cost();
                $receivings_items_data = array(
                    'receiving_id' => $receiving_id,
                    'item_id' => $item['item_id'],
                    'line' => $item['line'],
                    'description' => $item['description'],
                    'serialnumber' => $item['serialnumber'],
                    'quantity_purchased' => $item['quantity'],
                    'discount_percent' => $item['discount'],
                    'taxes' => $item['taxes'],
                    'item_cost_price' => $item['price'],
                    'item_unit_price' => $item['price'],
                    'date' => date('Y-m-d'),
                    'cat_id' => $cur_item_info->category,
                     'tk_no_recv' => $this->Item->get_info($item['item_id'])->account_store,
                    'money_tk_no' => $net_price+$x
                );
                $this->db->insert('receivings_items', $receivings_items_data);

                //Update stock quantity
                $item_data = array('quantity' => $cur_item_info->quantity + $quan);
                $this->Item->save($item_data, $item['item_id']);

                //insert_update to database of table warehouse_items
                if ($inventory_id != 0) {
                    $warehouse_items = array(
                        'warehouse_id' => $inventory_id,
                        'item_id' => $item['item_id'],
                        'quantity' => $quan,
                        'stt' => 1,
                        'date' => date('Y-m-d H:i:s')
                    );
                    //get_id_warehouse ang get_id_item
                    $stores_items_db = $this->Item->get_id_Items_warehouse($inventory_id, $item['item_id']);

                    if ($stores_items_db) {

                        $warehouse_items['quantity'] = $stores_items_db->quantity + $quan;
                    }
                    $this->Item->saveWarehouseItems($warehouse_items, $stores_items_db->id);
                } else {
                    $item_data_no_stored = array('quantity_total' => $cur_item_info->quantity_total + $quan);
                    $this->Item->save($item_data_no_stored, $item['item_id']);
                }

                $qty_recv1 = $item['quantity'];
                $qty_recv = $quan;
                //$recv_remarks = 'RECV ' . $receiving_id;
                $inv_data = array(
                    'trans_date' => date('Y-m-d H:i:s'),
                    'trans_items' => $item['item_id'],
                    'trans_user' => $employee_id,
                    'trans_comment' => $mode == 'return' ? 'RETURN_RECV' : 'RECV',
                    'trans_inventory' => $qty_recv,
                    'trans_catid' => $cur_item_info->category,
                    'trans_money' => $cur_item_info->quantity_first > 0 ? $cur_item_info->cost_price_rate : $cur_item_info->cost_price,
                    'trans_people' => $this->Supplier->exists($supplier_id) ? $supplier_id : 0,
                    'trans_recevings' => $receiving_id,
                    'store_id' => $inventory_id
                );
                $this->Inventory->insert($inv_data);
                $supplier = $this->Supplier->get_info($supplier_id);
            }
            /* ----------------------------------------------------------------------------- */
            $cost_comment = "Chi tiền nhập kho sản phẩm " . $this->Item->get_info($item['item_id'])->name 
                . " của nhà SX " . $this->Supplier->get_info($supplier_id)->company_name;
            $cost_comment_mode = "Thu tiền trả lại sản phẩm " . $this->Item->get_info($item['item_id'])->name 
                . " của nhà SX " . $this->Supplier->get_info($supplier_id)->company_name;
            $thue_nhap = 0;
            foreach ($items as $line => $item) {
                if (isset($item['item_id'])) {
                    $cur_item_info = $this->Item->get_info($item['item_id']);
                    $tien_don_hang += $item['quantity'] * $item['price'] - $item['quantity'] * $item['price'] * $item['discount'] / 100;
                    $thue_nhap += $item['quantity'] * $item['price'] * $cur_item_info->taxes / 100;
                }
            }
            //save costs
            if ($mode == 'return') {
                //Hưng Audi 2015 Nov 05, at 3h45'60s pm
                /* Zenda * NEM * Chicland fashions in Cau Giay street */
                $S2____cost_data_05_11_15_kiSSing_you____S2 = array(
                    'supplier_id' => $supplier_id,
                    'name' => 3,
                    'money' => $amount_tendered,//$tien_don_hang,
                    'form_cost' => 1,
                    'cost_date_ct' => $date_debt,
                    'date' => $date_debt,
                    'cost_employees' => $employee_id,
                    'comment' => $cost_comment_mode,
                    'stt_thu' => ($mode == "return") ? 1 : 0,
                    'deleted' => 0,
                    'tk_no' => $tk_no,
                    'tk_co' => $tk_co,
                    'VAT_acount' => 33311,
                    'VAT_money' => $thue_nhap,
                    'payment_type' => $payment_type_cost
                );
            } else {
                $S2____cost_data_05_11_15_kiSSing_you____S2 = array(
                    'supplier_id' => $supplier_id,
                    'name' => 3,
                    'form_cost' => 1,
                    'money' => $amount_tendered,//$tien_don_hang,
                    'cost_date_ct' => $date_debt,
                    'date' => $date_debt,
                    'cost_employees' => $employee_id,
                    'comment' => $cost_comment,
                    'deleted' => 0,
                    'id_receiving' => $receiving_id, //ma don NH
                    'tk_no' => $tk_no,
                    'tk_co' => $tk_co,
                    'VAT_acount' => 133,
                    'VAT_money' => $thue_nhap,
                    'payment_type' => $payment_type_cost
                );
            }
            $this->db->insert('costs', $S2____cost_data_05_11_15_kiSSing_you____S2);    
            $id_cost_Sirius_Nouvo = $this->db->insert_id();
            //Nov 3
            //save bank_account
            if ($payment_type == 'CKNH') {
                //save bank_account
                $bank_account_data = array(
                    'id_cost' => $id_cost_Sirius_Nouvo,
                    'receiving_id' => $receiving_id,
                    'bank_account' => $bank_account
                );
                $this->save_bank_account_recv($bank_account_data, $receiving_id);
            }
            //insert_cost_detail
            $money_debt = $tien_don_hang - $amount_tendered;
            $data_cost_detail = array(
                'id_cost' => $id_cost_Sirius_Nouvo,
                'receiving_id' => $receiving_id,
                'money_debt' => $money_debt
            );
            $this->Cost->insert_cost_detail($data_cost_detail);
            
            //say gOObye Hưng Audi
            $arr = array();
            $gia_ca = array();
            foreach ($items as $line => $item) {
                $net_price = $item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100;
                $x = ($net_price / $total_order) * $other_cost;
                $gia_ca[$this->Item->get_info($item['item_id'])->account_store] += $net_price + $x;
                foreach ($gia_ca as $k1 => $v1){
                     $arr[$k1] = $v1;
                }
            } 
            foreach ($arr as $k => $v){
                $data_recv_cost_tkdu = array(
                    'id_cost' => $id_cost_Sirius_Nouvo,
                    'tkdu' => $k,
                    'money_no' => 0,
                    'money_co' => $v,
                    'date' => date('Y-m-d H:i:s'),
                    'supplier_id' => $supplier_id
                );
                $this->Cost->save_recv_cost_tkdu($data_recv_cost_tkdu);
            }
            if($load_account > 0){
                $data_recv_cost_tkdu = array(
                    'id_cost' => $id_cost_Sirius_Nouvo,
                    'tkdu' => 1331,
                    'money_no' => 0,
                    'money_co' => $load_account,
                    'date' => date('Y-m-d H:i:s'),
                    'supplier_id' => $supplier_id
                );
                $this->Cost->save_recv_cost_tkdu($data_recv_cost_tkdu);
            }
            if($amount_tendered > 0){
                if ($payment_type == "Tiền mặt"){
                    $tk_du = 111;
                }elseif($payment_type == "CKNH"){
                    $tk_du = $bank_account;
                }
                $data_recv_cost_tkdu = array(
                    'id_cost' => $id_cost_Sirius_Nouvo,
                    'tkdu' => $tk_du,
                    'money_no' => $amount_tendered,
                    'money_co' => 0,
                    'date' => date('Y-m-d H:i:s'),
                    'supplier_id' => $supplier_id
                );
                $this->Cost->save_recv_cost_tkdu($data_recv_cost_tkdu);
            }
            $this->db->trans_complete();
        } else {//update //-------------------------------------------
            $amount_tendered1 = number_format($amount_tendered);            
            $info_recv_id_old = $this->get_info($receiving_id)->row_array();
            $receivings_data = array(
                'receiving_time' => $date_debt,
                'supplier_id' => $this->Supplier->exists($supplier_id) ? $supplier_id : null,
                'employee_id' => $employee_id,
                'comment' => $comment,
                'payment_type' => $payment_type . ':' . $amount_tendered1,
                'inventory_id' => $inventory_id,
                'date_debt' => $date_debt,
                'later_cost_price' => $total_order,
                'symbol_order' => $symbol_order,
                        'number_order' => $number_order,
                        'number_taxes' => $number_taxes,
                        'date_debt1' => $date_debt1,
                        'other_cost' => $other_cost,
                        'no_1331' => $no_1331,
                        'money_1331' => $money_1331,
                        'co_331' => $co_331,
                        'money_331' => $money_331
            );
            $this->db->trans_start();
            $this->db->where('receiving_id', $receiving_id);
            $this->db->update('receivings', $receivings_data);

            foreach ($items as $item2) {
                $cur_item_info = $this->Item->get_info($item2['item_id']);

                if ($cur_item_info->quantity_first > 0) {
                    $quantity = $this->get_receiving_items3($receiving_id, $item2['item_id'])->quantity_purchased * $cur_item_info->unit_rate; //so luong trc khi sua da quy doi
                    $quan = $cur_item_info->unit_rate * $item2['quantity']; //so luong sau khi sua ( da quy doi)
                    $price_receiving = $item2['price'] / $cur_item_info->unit_rate; // Gia nhap tinh theo don vi sau quy doi neu co quy doi
                } else {
                    $quantity = $this->get_receiving_items3($receiving_id, $item2['item_id'])->quantity_purchased; //so luong trc khi sua da quy doi
                    $quan = $item2['quantity']; //so luong sau khi sua
                    $price_receiving = $item2['price']; // gia nhap tinh theo don vi truoc quy doi neu ko co quy doi
                }
                $quantity_not_rate = $this->get_receiving_items3($receiving_id, $item2['item_id'])->quantity_purchased; //Số lượng chưa quy đổi truoc khi sua
                $price = $this->get_receiving_items3($receiving_id, $item2['item_id'])->item_unit_price; //giá nhập trc khi sua
                $discount_percent = $this->get_receiving_items3($receiving_id, $item2['item_id'])->discount_percent; //chiết khấu trc khi sua
                $discount_money_truoc = $quantity * $price * $discount_percent / 100;

                //update items table
                $item_data = array(
                    'quantity' => $cur_item_info->quantity - $quantity + $quan
                );
                $this->Item->save($item_data, $item2['item_id']);

                //Neu kho sau khi sua khac kho tong
                if ($inventory_id) {
                    if ($info_recv_id_old['inventory_id'] == $inventory_id) { //Kho truoc khi sua = kho sau khi sua
                        $warehouse_items = array(
                            'warehouse_id' => $inventory_id,
                            'item_id' => $item2['item_id'],
                            'quantity' => $quan - $quantity,
                            'stt' => 1,
                            'date' => date('Y-m-d H:i:s')
                        );

                        //get_id_warehouse ang get_id_item
                        $stores_items_db = $this->Item->get_id_Items_warehouse($inventory_id, $item2['item_id']);

                        if ($stores_items_db) {
                            $warehouse_items = array(
                                'quantity' => $stores_items_db->quantity - $quantity + $quan
                            );
                        }
                        $this->Item->saveWarehouseItems($warehouse_items, $stores_items_db->id);
                    } else { //Kho truoc khi sua != kho sau khi sua
                        if ($info_recv_id_old['inventory_id'] != 0) {
                            //get_id_warehouse ang get_id_item
                            $stores_items_db = $this->Item->get_id_Items_warehouse($info_recv_id_old['inventory_id'], $item2['item_id']);
                            $warehouse_items = array(
                                'quantity' => $stores_items_db->quantity - $quantity,
                                'date' => date('Y-m-d H:i:s')
                            );
                            $this->Item->saveWarehouseItems($warehouse_items, $stores_items_db->id);
                        } else {
                            $item_data_no_stored = array(
                                'quantity_total' => $cur_item_info->quantity_total - $quantity
                            );
                            $this->Item->save($item_data_no_stored, $item2['item_id']);
                        }
                        $stores_items_db = $this->Item->get_id_Items_warehouse($inventory_id, $item2['item_id']);
                        if ($stores_items_db) {
                            $warehouse_items = array(
                                'quantity' => $stores_items_db->quantity + $quan,
                                'date' => date('Y-m-d H:i:s')
                            );
                        } else {
                            $warehouse_items = array(
                                'warehouse_id' => $inventory_id,
                                'item_id' => $item2['item_id'],
                                'quantity' => $quan,
                                'stt' => 1,
                                'date' => date('Y-m-d H:i:s')
                            );
                        }
                        $this->Item->saveWarehouseItems($warehouse_items, $stores_items_db->id);
                    }
                } else { //Kho sau khi sua la kho tong
                    if ($info_recv_id_old['inventory_id'] != 0) { //Kho truoc khi sua khac kho tong
                        $stores_items_db = $this->Item->get_id_Items_warehouse($info_recv_id_old['inventory_id'], $item2['item_id']);
                        $warehouse_items = array(
                            'quantity' => $stores_items_db->quantity - $quantity,
                            'date' => date('Y-m-d H:i:s')
                        );
                        $this->Item->saveWarehouseItems($warehouse_items, $stores_items_db->id);
                        $item_data_no_stored = array(
                            'quantity_total' => $cur_item_info->quantity_total + $quan
                        );
                        $this->Item->save($item_data_no_stored, $item2['item_id']);
                    } else {
                        $item_data_no_stored = array(
                            'quantity_total' => $cur_item_info->quantity_total - $quantity + $quan
                        );
                        $this->Item->save($item_data_no_stored, $item2['item_id']);
                    }
                }
                //update inventory table
                $qty_recv1 = $item2['quantity'];
                $qty_recv = $quan;
                $inv_data = array(
                    'trans_date' => date('Y-m-d H:i:s'),
                    'trans_items' => $item2['item_id'],
                    'trans_user' => $employee_id,
                    'trans_comment' => $mode == 'return' ? 'RETURN_RECV' : 'RECV',
                    'trans_inventory' => $qty_recv,
                    'trans_catid' => $cur_item_info->category,
                    'trans_money' => str_replace(",", "", $item2['price']),
                    'trans_people' => $this->Supplier->exists($supplier_id) ? $supplier_id : 0,
                    'trans_recevings' => $receiving_id,
                    'store_id' => $inventory_id
                );

                $this->db->where('trans_recevings', $receiving_id);
                $this->db->where('trans_items', $item2['item_id']);
                $this->db->update('inventory', $inv_data);

                $discount_money_sau = $qty_recv1 * $item2['price'] * $item2['discount'] / 100;
                $tien_truoc = $quantity_not_rate * $price - $discount_money_truoc;
                //tien sau = (sl sau - sl truoc )				* don gia - tien chiet khau %
                $tien_sau = $qty_recv1 * $item2['price'] - $discount_money_sau;

                //save costs
                $hieu = $tien_sau - $tien_truoc;
                $thue_hieu = $hieu * $cur_item_info->taxes / 100;
                $cost_comment = "Chi tiền nhập mặt hàng " . $this->Item->get_info($item2['item_id'])->name;
                $cost_comment_mode = "Thu tiền trả lại mặt hàng " . $this->Item->get_info($item2['item_id'])->name;
                if ($mode == 'return') {
                    $S2____cost_data_05_11_15_kiSSing_you____S2 = array(
                        'id_customer' => $supplier_id,
                        'name' => 3,
                        'money' => $tien_sau,
                        'form_cost' => $qty_recv1 < $quantity_not_rate ? 1 : 0,
                        'cost_date_ct' => $date_debt,
                        'date' => $date_debt,
                        'cost_employees' => $employee_id,
                        'comment' => $cost_comment_mode,
                        'stt_thu' => ($mode == "return") ? 1 : 0,
                        'deleted' => 0,
                        'tk_no' => $tk_no,
                        'tk_co' => $tk_co,
                        'payment_type' => $payment_type_cost                    
                    );
                } else {
                    if ($hieu != 0) {
                        $S2____cost_data_05_11_15_kiSSing_you____S2 = array(
                            'id_customer' => $supplier_id,
                            'name' => 3,
                            'form_cost' => $hieu > 0 ? 1 : 0,
                            'money' => abs($hieu),
                            'cost_date_ct' => $date_debt,
                            'date' => $date_debt,
                            'cost_employees' => $employee_id,
                            'comment' => $hieu > 0 ? $cost_comment : $cost_comment_mode,
                            'deleted' => 0,
                            'tk_no' => $tk_no,
                            'tk_co' => $tk_co,
                            'VAT_acount' => $hieu > 0 ? 133 : 33311,
                            'VAT_money' => abs($thue_hieu),
                            'payment_type' => $payment_type_cost
                        );
                    }
                }
                $this->db->insert('costs', $S2____cost_data_05_11_15_kiSSing_you____S2);
                $id_cost_Sirius_Nouvo = $this->db->insert_id();
                
                //insert_cost_detail
                $money_debt = $mode == 'return' ? $tien_sau - $amount_tendered : $hieu - $amount_tendered;
                $data_cost_detail = array(
                    'id_cost' => $id_cost_Sirius_Nouvo,
                    'receiving_id' => $receiving_id,
                    'money_debt' => $money_debt
                );
                $this->Cost->insert_cost_detail($data_cost_detail);
            }//end foreach
            $this->db->delete('receivings_items', array('receiving_id' => $receiving_id));

            $discount_money = 0;
            foreach ($items as $line => $item) {
                $cur_item_info = $this->Item->get_info($item['item_id']);
                //update receivings_items table
                //tỷ lệ chuyển đổi
                     $net_price = $item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100;
                $x = ($net_price / $this->receiving_lib->get_total_order_of_item()) * $this->receiving_lib->get_other_cost();
                $receivings_items_data = array(
                    'receiving_id' => $receiving_id,
                    'item_id' => $item['item_id'],
                    'line' => $item['line'],
                    'description' => $item['description'],
                    'serialnumber' => $item['serialnumber'],
                    'quantity_purchased' => $item['quantity'],
                    'discount_percent' => $item['discount'],
                    'taxes' => $item['taxes'],
                    'item_cost_price' => $cur_item_info->cost_price,
                    'item_unit_price' => $item['price'],
                    'date' => date('Y-m-d'),
                    'cat_id' => $cur_item_info->unit,
                    'tk_no_recv' => $this->Item->get_info($item['item_id'])->account_store,
                    'money_tk_no' => ($net_price+$x)
                );

                $discount_money += $item['discount'] * $item['price'] * $item['quantity'] / 100;

                $check = $this->check($receiving_id, $item['item_id']);
                if ($check > 0) {
                    $this->db->where('receiving_id', $receiving_id);
                    $this->db->where('item_id', $item['item_id']);
                    $this->db->update('receivings_items', $receivings_items_data);
                } else {
                    $this->db->insert('receivings_items', $receivings_items_data);
                }
            }
            //hung audi 27-4-15
            $amount_tendered2 = str_replace(array(',', '.'), '', $amount_tendered);
            if ($payment_type == '') {
                $payment_type = 'Tiền mặt';
                $receivings_tam = array(
                    'pays_type' => $payment_type,
                    'pays_amount' => $amount_tendered2,
                    'id_receiving' => $receiving_id,
                    'date_tam' => date('Y-m-d H:i:s'),
                    'discount_money' => $discount_money,
                    'employees_id' => $employee_id,
                );
                $this->db->where('id_receiving', $receiving_id);
                $this->db->update('receivings_tam', $receivings_tam);
            } else {
                $receivings_tam = array(
                    'pays_type' => $payment_type,
                    'pays_amount' => $amount_tendered2,
                    'id_receiving' => $receiving_id,
                    'date_tam' => date('Y-m-d H:i:s'),
                    'discount_money' => $discount_money,
                    'employees_id' => $employee_id,
                );
                $this->db->where('id_receiving', $receiving_id);
                $this->db->update('receivings_tam', $receivings_tam);
            }//end hung
            //Nov 3
            //save bank_account
            if ($payment_type == 'CKNH') {
                //save bank_account
                $bank_account_data = array(
                    'id_cost' => $id_cost_Sirius_Nouvo,
                    'receiving_id' => $receiving_id,
                    'bank_account' => $bank_account
                );
                $this->save_bank_account_recv($bank_account_data, $receiving_id);
            }
            $this->db->trans_complete();
            //-------------------------------------------
        }

        if ($this->db->trans_status() === FALSE) {
            return -1;
        }

        return $receiving_id;
    }

    function delete($receiving_id) {
        $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;

        $this->db->select('item_id, quantity_purchased');
        $this->db->from('receivings_items');
        $this->db->where('receiving_id', $receiving_id);

        foreach ($this->db->get()->result_array() as $receiving_item_row) {
            $cur_item_info = $this->Item->get_info($receiving_item_row['item_id']);
            $item_data = array(
                'quantity' => $cur_item_info->quantity - $receiving_item_row['quantity_purchased']);

            $this->Item->save($item_data, $receiving_item_row['item_id']);

            $sale_remarks = 'RECV ' . $receiving_id;
            $inv_data = array
                (
                'trans_date' => date('Y-m-d H:i:s'),
                'trans_items' => $receiving_item_row['item_id'],
                'trans_user' => $employee_id,
                'trans_comment' => $sale_remarks,
                'trans_inventory' => $receiving_item_row['quantity_purchased'] * -1,
                'trans_catid' => $cur_item_info->category,
                'trans_money' => $item['price'] == 0 ? $cur_item_info->unit_price : $item['price'],
                'trans_people' => $this->Supplier->exists($supplier_id) ? $supplier_id : 0
            );
            $this->Inventory->insert($inv_data);
        }
        $this->db->where('receiving_id', $receiving_id);
        return $this->db->update('receivings', array('deleted' => 1));
    }

    function undelete($receiving_id) {
        $this->db->where('receiving_id', $receiving_id);
        return $this->db->update('receivings', array('deleted' => 0));
    }

    function get_receiving_items($receiving_id) {
        $this->db->from('receivings_items ri');
        $this->db->join('items i', 'ri.item_id=i.item_id', 'left');
        $this->db->where('receiving_id', $receiving_id);
        return $this->db->get();
    }

    function get_supplier($receiving_id) {
        $this->db->from('receivings');
        $this->db->where('receiving_id', $receiving_id);
        return $this->Supplier->get_info($this->db->get()->row()->supplier_id);
    }

    //We create a temp table that allows us to do easy report/receiving queries
    public function create_receivings_items_temp_table($params) {
        $where = '';

        if (isset($params['start_date']) && isset($params['end_date'])) {
            $where = 'WHERE (receiving_time) BETWEEN "' . $params['start_date'] . '" and "' . $params['end_date'] . '"';
        } else {
            //If we don't pass in a date range, we don't need data from the temp table
            $where = 'WHERE 1=2';
        }

        $this->db->query("CREATE TEMPORARY TABLE " . $this->db->dbprefix('receivings_items_temp') . "
		(SELECT " . $this->db->dbprefix('receivings') . ".deleted as deleted,status_currency as status_currency,(receiving_time) as receiving_date, other_cost, money_1331, " . $this->db->dbprefix('receivings_items') . ".receiving_id, comment,payment_type, employee_id,cat_id, 
		" . $this->db->dbprefix('items') . ".item_id, " . $this->db->dbprefix('receivings') . ".supplier_id, quantity_purchased, item_cost_price, item_unit_price,
		discount_percent, (item_unit_price*quantity_purchased) as subtotal,
		" . $this->db->dbprefix('receivings_items') . ".line as line, serialnumber, " . $this->db->dbprefix('receivings_items') . ".description as description,
		ROUND((item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100),2) as total,
		(item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100) - (item_cost_price*quantity_purchased) as profit
		FROM " . $this->db->dbprefix('receivings_items') . "
		INNER JOIN " . $this->db->dbprefix('receivings') . " ON  " . $this->db->dbprefix('receivings_items') . '.receiving_id=' . $this->db->dbprefix('receivings') . '.receiving_id' . "
		INNER JOIN " . $this->db->dbprefix('items') . " ON  " . $this->db->dbprefix('receivings_items') . '.item_id=' . $this->db->dbprefix('items') . '.item_id' . "
		$where
		GROUP BY receiving_id, item_id, line)");
    }

    public function create_imports_items_temp_table($params) {
        $where = '';

        if (isset($params['start_date']) && isset($params['end_date'])) {
            $where = 'WHERE (receiving_time) BETWEEN "' . $params['start_date'] . '" and "' . $params['end_date'] . '"';
        } else {
            //If we don't pass in a date range, we don't need data from the temp table
            $where = 'WHERE 1=2';
        }

        $this->db->query("CREATE TEMPORARY TABLE " . $this->db->dbprefix('receivings_items_temp') . "
		(SELECT " . $this->db->dbprefix('receivings') . ".deleted as deleted,status_currency as status_currency, currency_id as currency_id,(receiving_time) as receiving_date, " . $this->db->dbprefix('receivings_items') . ".receiving_id, " . $this->db->dbprefix('receivings_items') . ".taxes as taxes, comment, payment_type, employee_id,cat_id, 
		" . $this->db->dbprefix('items') . ".item_id, " . $this->db->dbprefix('receivings') . ".supplier_id, quantity_purchased, item_cost_price, item_unit_price,
		discount_percent, (item_unit_price*quantity_purchased) as subtotal,
		" . $this->db->dbprefix('receivings_items') . ".line as line, serialnumber, " . $this->db->dbprefix('receivings_items') . ".description as description, 
		((((item_unit_price*rate_currency)*quantity_purchased-(item_unit_price*rate_currency)*quantity_purchased*discount_percent/100)*" . $this->db->dbprefix('receivings_items') . ".taxes/100) + ((item_unit_price*rate_currency)*quantity_purchased-(item_unit_price*rate_currency)*quantity_purchased*discount_percent/100)) as total,
		((item_unit_price*rate_currency)*quantity_purchased-(item_unit_price*rate_currency)*quantity_purchased*discount_percent/100) - (item_cost_price*quantity_purchased) as profit
		FROM " . $this->db->dbprefix('receivings_items') . "
		INNER JOIN " . $this->db->dbprefix('receivings') . " ON  " . $this->db->dbprefix('receivings_items') . '.receiving_id=' . $this->db->dbprefix('receivings') . '.receiving_id' . "
		INNER JOIN " . $this->db->dbprefix('items') . " ON  " . $this->db->dbprefix('receivings_items') . '.item_id=' . $this->db->dbprefix('items') . '.item_id' . "
		$where
		GROUP BY receiving_id, item_id, line)");
    }

//   (((item_unit_price*rate_currency/1000)*quantity_purchased-(item_unit_price*rate_currency/1000)*quantity_purchased*discount_percent/100)*" . $this->db->dbprefix('receivings_items') . ".taxes/100)
//    ((item_unit_price*rate_currency/1000)*quantity_purchased-(item_unit_price*rate_currency/1000)*quantity_purchased*discount_percent/100)
    // giang 22/12
    function get_supplier_owe($supplier_id, $start_date = '', $end_date = '') {
        $this->db->select('*');
        $this->db->from('receivings');
        $this->db->where('deleted', 0);
        $this->db->where('suspended', 1);
        $this->db->where('supplier_id', $supplier_id);
        if ($start_date != '' && $end_date != '') {
            $this->db->where('receiving_time >=', $start_date);
            $this->db->where('receiving_time <=', $end_date);
        }
        $this->db->order_by('receiving_time', 'desc');
        $query = $this->db->get();
        //var_dump($this->db->last_query());exit(0);
        return $query->result_array();
    }

    function get_receiving_tam($receiving_id, $start_date = '', $end_date = '') {
        $this->db->select('*');
        $this->db->from('receivings_tam');
        $this->db->where('id_receiving', $receiving_id);
        if ($start_date != '' && $end_date != '') {
            $this->db->where('date_tam >=', $start_date);
            $this->db->where('date_tam <=', $end_date);
        }
        $query = $this->db->get();
        //var_dump($this->db->last_query());exit();
        return $query->result_array();
    }

    //
    function get_receiving_items2($receiving_id) {
        $this->db->from('receivings_items ri');
        $this->db->join('items i', 'ri.item_id=i.item_id', 'left');
        $this->db->where('receiving_id', $receiving_id);
        return $this->db->get();
    }

    // lay tong gia tri 1 don hang nhap
    function get_total_receiving($receiving_id) {
        $this->db->select('*,SUM(item_unit_price*quantity_purchased - item_unit_price*quantity_purchased*discount_percent/100) as total_price');
        $this->db->from('receivings_items');
        $this->db->where('receiving_id', $receiving_id);
        $this->db->group_by('receiving_id');
        $query = $this->db->get();

        //var_dump($this->db->last_query());exit();
        return $query->row_array();
    }
    
    /*
     * 
     */
    function update_recv_congno($data, $receiving_id){
        $this->db->where('receiving_id',$receiving_id);
        $this->db->update('receivings',$data);
    }
            
    function insert_receiving_tam($data) {
        $this->db->insert('receivings_tam', $data);
        return $this->db->insert_id();
    }

    function get_all_by_supplier($supplier_id, $limit = '10000', $offset = '0') {
        $this->db->select('*');
        $this->db->from('receivings');
        $this->db->where('deleted', 0);
//		$this->db->where('suspended',1);
        $this->db->where('supplier_id', $supplier_id);              //huyenlt^^
        $this->db->order_by('receiving_time', 'desc');
//		$this->db->limit($limit,$offset);
        $query = $this->db->get();
        //var_dump($this->db->last_query());exit();
        return $query->result_array();
    }

    function get_total_all_by_supplier($supplier) {
        $this->db->select('*');
        $this->db->from('receivings');
        $this->db->where('supplier_id', $supplier_id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_item_receiving($receiving_id) {
        $this->db->select('*');
        $this->db->from('receivings_items r');
        $this->db->join('items i', 'r.item_id = i.item_id', 'left');
        $this->db->where('r.receiving_id', $receiving_id);
        $query = $this->db->get();
//		var_dump($this->db->last_query());exit();
        return $query->result_array();
    }

    function get_tax_item($item_id, $receiving_id) {
        $this->db->select('item_id,percent');
        $this->db->from('receivings_items_taxes');
        $this->db->where('item_id', $item_id);
        $this->db->where('receiving_id', $receiving_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    //Created by San
    function check_exists_item_in_receivings_items($item_id) {
        $this->db->where("item_id", $item_id);
        $query = $this->db->get("receivings_items");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    //End by San
    //hung audi 
    //tab cong no
    function get_supplier_owe2($supplier_id, $page_limit, $resultsPerPage) {
        $sql = "select * from lifetek_receivings 			
			where supplier_id = " . $supplier_id . " and deleted = 0 
				and suspended = 1 order by receiving_id DESC
			limit $page_limit,$resultsPerPage
			";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function get_row($supplier_id, $page_limit, $resultsPerPage) {
        $sql = "select * from lifetek_receivings where supplier_id = " . $supplier_id . " and deleted = 0 
                    and suspended = 1
                    limit $page_limit, $resultsPerPage
                    ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else
            return null;
    }

    function get_total_row($supplier_id) {
        $sql = "select * from lifetek_receivings
			where supplier_id = " . $supplier_id . " and deleted = 0 
				and suspended = 1 
			";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else
            return null;
    }

    //tab nhap hang
    function get_all_by_supplier2($supplier_id, $page_limit, $resultsPerPage) {
        $sql = "select * from lifetek_receivings
			where supplier_id = " . $supplier_id . " and deleted = 0 order by receiving_id DESC
			limit $page_limit,$resultsPerPage
			";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function get_row2($supplier_id, $page_limit, $resultsPerPage) {
        $sql = "select * from lifetek_receivings
			where supplier_id = " . $supplier_id . " and deleted = 0
			limit $page_limit,$resultsPerPage
			";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else
            return null;
    }

    function get_total_row2($supplier_id) {
        $sql = "select * from lifetek_receivings
			where supplier_id = " . $supplier_id . " and deleted = 0
			";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else
            return null;
    }

    // 31-3-15
    function get_item_receiving2($receiving_id) {
        $this->db->from('receivings_items');
        $this->db->where('receiving_id', $receiving_id);
        $query = $this->db->get();
        return $query;
    }

    public function get_info2($receiving_id) {
        $sql = "SELECT SUBSTRING( payment_type, 10 ) as payment_types
				FROM lifetek_receivings
				WHERE receiving_id= $receiving_id";
        return $this->db->query($sql);
    }

    //end hung

    function get_receiving_items3($receiving_id, $item_id) {
        $this->db->from('receivings_items ri');
        $this->db->join('receivings r', 'ri.receiving_id = r.receiving_id');
        $this->db->where('ri.receiving_id', $receiving_id);
        $this->db->where('ri.item_id', $item_id);
        return $this->db->get()->row();
    }

    //check receiving_id,item_id in receiving_item
    public function check($receiving_id, $item_id) {
        $this->db->where('receiving_id', $receiving_id);
        $this->db->where('item_id', $item_id);
        return $this->db->get('receivings_items')->num_rows();
    }

    function get_receiving_tam_by_id($receiving_id) {
        $this->db->where("id_receiving", $receiving_id);
        $query = $this->db->get("receivings_tam");
        return $query->result();
    }
    

    function get_receivings_HallOweeN($start_date, $end_date) {
        return $this->db->from('receivings')
                        ->where('receiving_time >=', $start_date)
                        ->where('receiving_time <=', $end_date)
                        ->order_by('receiving_id', 'desc')
                        ->get();
    }

    function getall_receiving_items(){
        $this->db->from('receivings_items');
        return $this->db->get();
    }
            
    function get_info_bank_account_by_receiving_id($receiving_id) {
        return $this->db->where("receiving_id", $receiving_id)
                        ->get("bank_account")
                        ->row();
    }
    function get_info_bank_account_by_id_cost($id_cost) {
        return $this->db->where("id_cost", $id_cost)
                        ->get("bank_account")
                        ->row();
    }
    //save recv
    function save_bank_account_recv(&$data, $receiving_id = false) {
        if (!$receiving_id or ! $this->exists_bank_account_recv($receiving_id)) {
            if ($this->db->insert('bank_account', $data)) {
                return true;
            }
            return false;
        } else {
            $this->db->where('receiving_id', $receiving_id);
            return $this->db->update('bank_account', $data);
        }
    }
    function exists_bank_account_recv($receiving_id) {
        return $this->db->where('receiving_id', $receiving_id)
                        ->get('bank_account')
                        ->num_rows() == 1;

    }
    //save sale
    function save_bank_account_sale(&$data, $sale_id = false) {
        if (!$sale_id or ! $this->exists_bank_account_sale($sale_id)) {
            if ($this->db->insert('bank_account', $data)) {
                return true;
            }
            return false;
        } else {
            $this->db->where('sale_id', $sale_id);
            return $this->db->update('bank_account', $data);
        }
    }
    function exists_bank_account_sale($sale_id) {
        return $this->db->where('sale_id', $sale_id)
                        ->get('bank_account')
                        ->num_rows() == 1;

    }
    //save cost
    function save_bank_account(&$data, $id_cost = false) {
        if (!$id_cost or ! $this->exists_bank_account($id_cost)) {
            if ($this->db->insert('bank_account', $data)) {
                return true;
            }
            return false;
        } else {
            $this->db->where('id_cost', $id_cost);
            return $this->db->update('bank_account', $data);
        }
    }
    function exists_bank_account($id_cost) {
        return $this->db->where('id_cost', $id_cost)
                        ->get('bank_account')
                        ->num_rows() == 1;

    }
    //NoV 6
    function get_info_cost_by_date_HallOweeN($id_receiving, $date) {
        return $this->db->where('id_receiving', $id_receiving)
                        ->where('date', $date)
                        ->get('costs')->row();
    }

     function update_recv_customer($data_recv, $recv_id){
        $this->db->where('receiving_id',$recv_id);
        $this->db->update('receivings',$data_recv);
    }
}

?>
