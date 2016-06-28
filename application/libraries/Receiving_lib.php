<?php

class Receiving_lib {

    var $CI;

    function __construct() {
        $this->CI = & get_instance();
    }

    function get_cart() {
        if ($this->CI->session->userdata('cartRecv') === false)
            $this->set_cart(array());

        return $this->CI->session->userdata('cartRecv');
    }

    function set_cart($cart_data) {
        $this->CI->session->set_userdata('cartRecv', $cart_data);
    }

    function get_supplier() {
        if (!$this->CI->session->userdata('supplier'))
            $this->set_supplier(-1);

        return $this->CI->session->userdata('supplier');
    }

    function set_supplier($supplier_id) {
        $this->CI->session->set_userdata('supplier', $supplier_id);
    }

    function get_amount_tendered() {
        return $this->CI->session->userdata('amount_tendered') ? $this->CI->session->userdata('amount_tendered') : '';
    }

    function set_amount_tendered($amount_tendered) {
        $this->CI->session->set_userdata('amount_tendered', $amount_tendered);
    }

    function get_amount_tendered_hidden() {
        return $this->CI->session->userdata('amount_tendered_hidden') ? $this->CI->session->userdata('amount_tendered_hidden') : '';
    }

    function set_amount_tendered_hidden($amount_tendered_hidden) {
        $this->CI->session->set_userdata('amount_tendered_hidden', $amount_tendered_hidden);
    }

     function get_id_recv() {
        return $this->CI->session->userdata('id_cost') ? $this->CI->session->userdata('id_cost') : '';
    }

    function set_id_recv($id_cost) {
        $this->CI->session->set_userdata('id_cost', $id_cost);
    }
    
    //
    function get_comment() {
        return $this->CI->session->userdata('comment') ? $this->CI->session->userdata('comment') : '';
    }

    function set_comment($comment) {
        $this->CI->session->set_userdata('comment', $comment);
    }

    //-----------^^$%%##
     function get_symbol_order() {
        return $this->CI->session->userdata('symbol_order') ? $this->CI->session->userdata('symbol_order') : '';
    }

    function set_symbol_order($symbol_order) {
        $this->CI->session->set_userdata('symbol_order', $symbol_order);
    }
    
     function get_number_order() {
        return $this->CI->session->userdata('number_order') ? $this->CI->session->userdata('number_order') : '';
    }

    function set_number_order($number_order) {
        $this->CI->session->set_userdata('number_order', $number_order);
    }
    
     function get_number_taxes() {
        return $this->CI->session->userdata('number_taxes') ? $this->CI->session->userdata('number_taxes') : '';
    }

    function set_number_taxes($number_taxes) {
        $this->CI->session->set_userdata('number_taxes', $number_taxes);
    }
    
     function get_other_cost() {
        return $this->CI->session->userdata('other_cost') ? $this->CI->session->userdata('other_cost') : '';
    }

    function set_other_cost($other_cost) {
        $this->CI->session->set_userdata('other_cost', $other_cost);
    }
     function set_date_debt1($date_debt1) {
        $this->CI->session->set_userdata('date_debt1', $date_debt1);
    }    
    function get_date_debt1() {
        return $this->CI->session->userdata('date_debt1') ? $this->CI->session->userdata('date_debt1') : '';
    }
    function clear_date_debt1() {
        $this->CI->session->unset_userdata('date_debt1');
    }
    
   //-----------------
    
//
    function get_discount_money() {
        return $this->CI->session->userdata('discount_money') ? $this->CI->session->userdata('discount_money') : '';
    }

    function set_discount_money($discount_money) {
        $this->CI->session->set_userdata('discount_money', $discount_money);
    }

//	
    function get_payment_type() {
        return $this->CI->session->userdata('payment_type') ? $this->CI->session->userdata('payment_type') : '';
    }

    function set_payment_type($payment_type) {
        $this->CI->session->set_userdata('payment_type', $payment_type);
    }

//	
    function get_inventory() {
        return $this->CI->session->userdata('inventory') ? $this->CI->session->userdata('inventory') : '';
    }

    function set_inventory($inventory) {
        $this->CI->session->set_userdata('inventory', $inventory);
    }

    function get_mode() {
        if (!$this->CI->session->userdata('recv_mode'))
            $this->set_mode('receive');

        return $this->CI->session->userdata('recv_mode');
    }

    function set_mode($mode) {
        $this->CI->session->set_userdata('recv_mode', $mode);
    }

    function add_item($item_id, $quantity = 1, $discount = 0, $taxes = 0, $price = null, $unit = '', $description = null, $serialnumber = null) {
        //make sure item exists in database.
        if (!$this->CI->Item->exists(is_numeric($item_id) ? (int) $item_id : -1)) {
            //try to get item id given an item_number
            $item_id = $this->CI->Item->get_item_id($item_id);

            if (!$item_id)
                return false;
        }

        //Get items in the receiving so far.
        $items = $this->get_cart();

        //We need to loop through all items in the cart.
        //If the item is already there, get it's key($updatekey).
        //We also need to get the next key that we are going to use in case we need to add the
        //item to the list. Since items can be deleted, we can't use a count. we use the highest key + 1.

        $maxkey = 0;                       //Highest key so far
        $itemalreadyinsale = FALSE;        //We did not find the item yet.
        $insertkey = 0;                    //Key to use for new entry.
        $updatekey = 0;                    //Key to use to update(quantity)

        foreach ($items as $item) {
            //We primed the loop so maxkey is 0 the first time.
            //Also, we have stored the key in the element itself so we can compare.
            //There is an array function to get the associated key for an element, but I like it better
            //like that!

            if ($maxkey <= $item['line']) {
                $maxkey = $item['line'];
            }

            if ($item['item_id'] == $item_id) {
                $itemalreadyinsale = TRUE;
                $updatekey = $item['line'];
            }
        }

        $insertkey = $maxkey + 1;

        //array records are identified by $insertkey and item_id is just another field.
        $item = array(($insertkey) =>
            array(
                'item_id' => $item_id,
                'line' => $insertkey,
                'name' => $this->CI->Item->get_info($item_id)->name,
                'description' => $description != null ? $description : $this->CI->Item->get_info($item_id)->description,
                'serialnumber' => $serialnumber != null ? $serialnumber : '',
                'allow_alt_description' => $this->CI->Item->get_info($item_id)->allow_alt_description,
                'is_serialized' => $this->CI->Item->get_info($item_id)->is_serialized,
                'quantity' => $quantity,
                'unit_rate' => $this->CI->Item->get_info($item_id)->unit_rate,
                'quantity_first' => $this->CI->Item->get_info($item_id)->quantity_first,
                'discount' => $discount,
                'price' => $price != null ? $price : $this->CI->Item->get_info($item_id)->cost_price,
                'taxes' => $taxes,
                'unit' => $this->CI->Item->get_info($item_id)->unit
            )
        );

        //Item already exists
        if ($itemalreadyinsale) {
            $items[$updatekey]['quantity']+=$quantity;
        } else {
            //add to existing array
            $items+=$item;
        }

        $this->set_cart($items);
        return true;
    }

    function edit_item($line, $description, $serialnumber, $quantity, $discount, $price, $taxes) {
        $items = $this->get_cart();
        if (isset($items[$line])) {
            $items[$line]['description'] = $description;
            $items[$line]['serialnumber'] = $serialnumber;
            $items[$line]['quantity'] = $quantity;
            $items[$line]['discount'] = $discount;
            $items[$line]['price'] = $price;
            $items[$line]['taxes'] = $taxes;
            //$items[$line]['unit'] = $unit;
            $this->set_cart($items);
        }

        return false;
    }

    function is_valid_receipt($receipt_receiving_id) {
        //RECV #
        $pieces = explode(' ', $receipt_receiving_id);

        if (count($pieces) == 2 && $pieces[0] == 'RECV') {
            return $this->CI->Receiving->exists($pieces[1]);
        }

        return false;
    }

    function is_valid_item_kit($item_kit_id) {
        //KIT #
        $pieces = explode(' ', $item_kit_id);

        if (count($pieces) == 2 && $pieces[0] == 'KIT') {
            return $this->CI->Item_kit->exists($pieces[1]);
        }

        return false;
    }

    function return_entire_receiving($receipt_receiving_id) {
        //POS #
        $pieces = explode(' ', $receipt_receiving_id);
        $receiving_id = $pieces[1];

        $this->empty_cart();
        $this->delete_supplier();

        foreach ($this->CI->Receiving->get_receiving_items($receiving_id)->result() as $row) {
            $this->add_item($row->item_id, -$row->quantity_purchased, $row->discount_percent, $row->item_unit_price, $row->description, $row->serialnumber);
        }
        $this->set_supplier($this->CI->Receiving->get_supplier($receiving_id)->person_id);
    }

    function add_item_kit($external_item_kit_id) {
        //KIT #
        $pieces = explode(' ', $external_item_kit_id);
        $item_kit_id = $pieces[1];

        foreach ($this->CI->Item_kit_items->get_info($item_kit_id) as $item_kit_item) {
            $this->add_item($item_kit_item->item_id, $item_kit_item->quantity);
        }
    }

    function copy_entire_receiving($receiving_id) {
        $this->empty_cart();
        $this->delete_supplier();

        foreach ($this->CI->Receiving->get_receiving_items($receiving_id)->result() as $row) {
            $this->add_item($row->item_id, $row->quantity_purchased, $row->discount_percent, $row->item_unit_price, $row->description, $row->serialnumber);
        }
        $this->set_supplier($this->CI->Receiving->get_supplier($receiving_id)->person_id);
    }

    //Alain Multiple Payments
    function get_payments() {
        if ($this->CI->session->userdata('payments') === false)
            $this->set_payments(array());

        return $this->CI->session->userdata('payments');
    }

    //Alain Multiple Payments
    function set_payments($payments_data) {
        $this->CI->session->set_userdata('payments', $payments_data);
    }

    function add_payment($payment_id, $payment_amount) {
        $payments = $this->get_payments();
        $payment = array($payment_id =>
            array(
                'payment_type' => $payment_id,
                'payment_amount' => $payment_amount,
            //'discount_money'=>$discount_money,    //huyenlt^^
            ),
        );
//		print_r($payment);
//		die('ssss');
        //payment_method already exists, add to payment_amount
        if (isset($payments[$payment_id])) {
            $payments[$payment_id]['payment_amount']+=($payment_amount); //huyenlt^^
        } else {
            //add to existing array
            $payments+=$payment;
        }

        $this->set_payments($payments);
        return true;
    }

    function delete_item($line) {
        $items = $this->get_cart();
        unset($items[$line]);
        $this->set_cart($items);
    }

    function empty_cart() {
        $this->CI->session->unset_userdata('cartRecv');
    }

    function delete_supplier() {
        $this->CI->session->unset_userdata('supplier');
    }

    function clear_mode() {
        $this->CI->session->unset_userdata('recv_mode');
    }

    function empty_payment_type() {
        $this->CI->session->unset_userdata('payment_type');
    }

    function clear_payment_type() {
        $this->CI->session->unset_userdata('payment_type');
    }

    function clear_comment() {
        $this->CI->session->unset_userdata('comment');
    }

    function clear_amount_tendered() {
        $this->CI->session->unset_userdata('amount_tendered');
    }

    function clear_inventory() {
        $this->CI->session->unset_userdata('inventory');
    }

    function clear_payments() {
        $this->CI->session->unset_userdata('payments');
    }

    function empty_payments() {
        $this->CI->session->unset_userdata('payments');
    }

    function clear_symbol_order() {
        $this->CI->session->unset_userdata('symbol_order');
    }
    
    function clear_number_order() {
        $this->CI->session->unset_userdata('number_order');
    }
    
    function clear_number_taxes() {
        $this->CI->session->unset_userdata('number_taxes');
    }
    
    function clear_other_cost() {
        $this->CI->session->unset_userdata('other_cost');
    }
    
    function clear_all() {
        $this->clear_mode();
        $this->empty_cart();
        $this->delete_supplier();
        $this->empty_payment_type();
        $this->clear_payment_type();
        $this->clear_comment();
        $this->clear_amount_tendered();
        $this->clear_inventory();
        $this->delete_suspended_receiving_id();
        $this->empty_payments();
        $this->clear_payments();
        $this->clear_item_store();
        $this->clear_export_store();
        $this->clear_recv();
        $this->clear_date_debt();
        $this->clear_bank_account();
        $this->clear_symbol_order();
        $this->clear_number_order();
        $this->clear_number_taxes();
        $this->clear_other_cost();
    }

    function clear_item_store() {
        $this->CI->session->unset_userdata('item_kit_items');
    }

    function get_total() {
        $total = 0;
        foreach ($this->get_cart() as $item) {
            $net_price = $item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount']/100;
            
            $cp = ($net_price / $this->get_total_order_of_item()) * $this->get_other_cost();
            
            $tax = ($net_price +$cp) * $item['taxes'] / 100;
            $total += $tax + $net_price;
        }

        return $total;
    }

    function get_suspended_receiving_id() {
        return $this->CI->session->userdata('suspended_receiving_id');
    }

    function set_suspended_receiving_id($suspended_receiving_id) {
        $this->CI->session->set_userdata('suspended_receiving_id', $suspended_receiving_id);
    }

    function delete_suspended_receiving_id() {
        $this->CI->session->unset_userdata('suspended_receiving_id');
    }

    ////hung audi 8-3
    function get_item_kits() {
        if (!$this->CI->session->userdata('item_kits'))
            $this->set_item_kits(-1);

        return $this->CI->session->userdata('item_kits');
    }

    function set_item_kits($item_kit_id) {
        $this->CI->session->set_userdata('item_kits', $item_kit_id);
    }

    function add_item_kits($item_kit_id) {
        $this->set_item_kits($item_kit_id);
        return true;
    }

    //hung audi 23-3 emp
    //regions
    function get_jobs_regions() {
        if (!$this->CI->session->userdata('jobs_regions'))
            $this->set_jobs_regions(-1);

        return $this->CI->session->userdata('jobs_regions');
    }

    function set_jobs_regions($jobs_regions_id) {
        $this->CI->session->set_userdata('jobs_regions', $jobs_regions_id);
    }

    function add_jobs_regions($jobs_regions_id) {//die('gg');
        $this->set_jobs_regions($jobs_regions_id);
        return true;
    }

    //city
    function get_jobs_city() {
        if (!$this->CI->session->userdata('jobs_city'))
            $this->set_jobs_city(-1);

        return $this->CI->session->userdata('jobs_city');
    }

    function set_jobs_city($jobs_city_id) {
        $this->CI->session->set_userdata('jobs_city', $jobs_city_id);
    }

    function add_jobs_city($jobs_city_id) {
        $this->set_jobs_city($jobs_city_id);
        return true;
    }

    function clear_all2() {
        $this->delete_city();
    }

    function delete_city() {
        $this->CI->session->unset_userdata('jobs_city');
    }

    //affiliates
    function get_jobs_affiliates() {
        if (!$this->CI->session->userdata('jobs_affiliates'))
            $this->set_jobs_affiliates(-1);

        return $this->CI->session->userdata('jobs_affiliates');
    }

    function set_jobs_affiliates($jobs_affiliates_id) {
        $this->CI->session->set_userdata('jobs_affiliates', $jobs_affiliates_id);
    }

    function add_jobs_affiliates($jobs_affiliates_id) {//die('gg');
        $this->set_jobs_affiliates($jobs_affiliates_id);
        return true;
    }

    //department
    function get_department() {
        if (!$this->CI->session->userdata('department'))
            $this->set_department(-1);

        return $this->CI->session->userdata('department');
    }

    function set_department($department_id) {
        $this->CI->session->set_userdata('department', $department_id);
    }

    function add_department($department_id) {//die('gg');
        $this->set_department($department_id);
        return true;
    }

    //end hung audi
    //BEGIN SAN
    //design template
    function get_design_template() {
        if (!$this->CI->session->userdata('design_template'))
            $this->set_item_kits(-1);

        return $this->CI->session->userdata('design_template');
    }

    function set_design_template($id_design_template) {
        $this->CI->session->set_userdata('design_template', $id_design_template);
    }

    function add_design_template($id_design_template) {
        $this->set_design_template($id_design_template);
        return true;
    }

    function set_cate($cate) {
        $this->CI->session->set_userdata("cate", $cate);
    }

    function get_cate() {
        return $this->CI->session->userdata("cate");
    }

    function clear_cate() {
        $this->CI->session->unset_userdata("cate");
    }

    //END SAN
    //    Loi
    function get_export_store() {
        return $this->CI->session->userdata('export_store');
    }

    function set_export_store($export_store_id) {
        $this->CI->session->set_userdata('export_store', $export_store_id);
    }

    function clear_export_store() {
        $this->CI->session->unset_userdata('export_store');
    }

    function get_inventory_tam() {
        return $this->CI->session->userdata('inventory');
    }

//    end Loi

    function copy_entire_receiving2($receiving_id) {
        $this->empty_cart();
        $this->delete_supplier();
        $this->set_supplier($this->CI->Receiving->get_supplier($receiving_id)->person_id);
    }

    function set_recv($recv_id) {
        $this->CI->session->set_userdata('recv', $recv_id);
    }

    function get_recv() {
        return $this->CI->session->userdata('recv');
    }

    function clear_recv() {
        $this->CI->session->unset_userdata('recv');
    }

    //detai_item
    function set_detail_item($item_id) {
        $this->CI->session->set_userdata('info_item', $item_id);
    }

    function get_detail_item() {
        return $this->CI->session->userdata('info_item') ? $this->CI->session->userdata('info_item') : '';
    }
    //Sep 25 Hưng Audi
    //start_date
    function get_start_date() {
        return $this->CI->session->userdata('start_date') ? $this->CI->session->userdata('start_date') : '';
    }
    function set_start_date($start_date) {
        $this->CI->session->set_userdata('start_date', $start_date);
    }
    //end_date
    function get_end_date() {
        return $this->CI->session->userdata('end_date') ? $this->CI->session->userdata('end_date') : '';
    }
    function set_end_date($end_date) {
        $this->CI->session->set_userdata('end_date', $end_date);
    } 
    //item_kit_id
    function get_item_kit_id() {
        return $this->CI->session->userdata('item_kit_id') ? $this->CI->session->userdata('item_kit_id') : '';
    }
    function set_item_kit_id($item_kit_id) {
        $this->CI->session->set_userdata('item_kit_id', $item_kit_id);
    }    
    
    //25-10-15 Hưng Audi
    function get_total_order_of_item() {
        $subtotal = 0;
        foreach ($this->get_cart() as $item) {
            $net_price = $item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount']/100;
            $subtotal+= $net_price;
        }
        return $subtotal;
    }
    function get_total_taxes() {
        $subtotal = 0;
        foreach ($this->get_cart() as $item) {
            $net_price = $item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount']/100;
            
            $cp = ($net_price / $this->get_total_order_of_item()) * $this->get_other_cost();
            
            $tax = ($net_price + $cp) * $item['taxes'] / 100;
            
            $subtotal+= $tax;
        }
        return $subtotal;
    }
    
    //Nov 3
    //date_debt
    function set_date_debt($date_debt) {
        $this->CI->session->set_userdata('date_debt', $date_debt);
    }    
    function get_date_debt() {
        return $this->CI->session->userdata('date_debt') ? $this->CI->session->userdata('date_debt') : '';
    }
    function clear_date_debt() {
        $this->CI->session->unset_userdata('date_debt');
    }
    //bank_account
    function set_bank_account($bank_account) {
        $this->CI->session->set_userdata('bank_account', $bank_account);
    }    
    function get_bank_account() {
        return $this->CI->session->userdata('bank_account') ? $this->CI->session->userdata('bank_account') : '';
    }
    function clear_bank_account() {
        $this->CI->session->unset_userdata('bank_account');
    }
    
    //Nov 12
    //number
    function set_number($number) {
        $this->CI->session->set_userdata('number', $number);
    }    
    function get_number() {
        return $this->CI->session->userdata('number') ? $this->CI->session->userdata('number') : '';
    }
    //item_production_id
    function set_item_production_id($item_production_id) {
        $this->CI->session->set_userdata('item_production_id', $item_production_id);
    }    
    function get_item_production_id() {
        return $this->CI->session->userdata('item_production_id') ? $this->CI->session->userdata('item_production_id') : '';
    }
    
    //load_account
    function set_load_account($load_account) {
        $this->CI->session->set_userdata('load_account', $load_account);
    }    
    function get_load_account() {
        return $this->CI->session->userdata('load_account') ? $this->CI->session->userdata('load_account') : '';
    }
}

?>