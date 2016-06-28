<?php

class Sale_lib {

    var $CI;

    function __construct() {
        $this->CI = & get_instance();
    }

    function get_cart() {
        if ($this->CI->session->userdata('cart') === false)
            $this->set_cart(array());

        return $this->CI->session->userdata('cart');
    }

    function set_cart($cart_data) {
        $this->CI->session->set_userdata('cart', $cart_data);
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

    function get_comment() {
        return $this->CI->session->userdata('comment') ? $this->CI->session->userdata('comment') : '';
    }

    function get_employees_id() {
        return $this->CI->session->userdata('employees_id') ? $this->CI->session->userdata('employees_id') : '';
    }

    function get_employees_delivery() {
        return $this->CI->session->userdata('delivery_employee') ? $this->CI->session->userdata('delivery_employee') : '';
    }

    function get_date_debt() {
        return $this->CI->session->userdata('date_debt') ? $this->CI->session->userdata('date_debt') : '';
    }

    //huyenlt^^
    function get_store() {
        return $this->CI->session->userdata('store') ? $this->CI->session->userdata('store') : '';
    }

    function get_discount_money() {

        return $this->CI->session->userdata('discount_money') ? $this->CI->session->userdata('discount_money') : '';
    }

    function get_comment_on_receipt() {
        return $this->CI->session->userdata('show_comment_on_receipt') ? $this->CI->session->userdata('show_comment_on_receipt') : '';
    }

    function set_comment($comment) {
        $this->CI->session->set_userdata('comment', $comment);
    }

    function get_date_debt1() {
        return $this->CI->session->userdata('date_debt1') ? $this->CI->session->userdata('date_debt1') : '';
    }
    
     function set_date_debt1($date_debt1) {
        $this->CI->session->set_userdata('date_debt1', $date_debt1);
    }
    
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
    
    //dungbv
    function set_employees_id($employees_id) {
        $this->CI->session->set_userdata('employees_id', $employees_id);
    }

    function set_employees_delivery($delivery_employee) {
        $this->CI->session->set_userdata('delivery_employee', $delivery_employee);
    }

    function set_store($store) {
        $this->CI->session->set_userdata('store', $store);
    }

    function set_discount_money($discount_money) {
        $this->CI->session->set_userdata('discount_money', $discount_money);
    }

    function set_date_debt($date_debt) {
        $this->CI->session->set_userdata('date_debt', $date_debt);
    }

    function set_comment_on_receipt($comment_on_receipt) {
        $this->CI->session->set_userdata('show_comment_on_receipt', $comment_on_receipt);
    }

    function clear_comment() {
        $this->CI->session->unset_userdata('comment');
    }

    
     function clear_date_debt1() {
        $this->CI->session->unset_userdata('date_debt1');
    }
    
     function clear_symbol_order() {
        $this->CI->session->unset_userdata('symbol_order');
    }
    
     function clear_number_order() {
        $this->CI->session->unset_userdata('number_order');
    }
    function clear_date_debt() {
        $this->CI->session->unset_userdata('date_debt');
    }

    function clear_show_comment_on_receipt() {
        $this->CI->session->unset_userdata('show_comment_on_receipt');
    }

    function get_email_receipt() {
        return $this->CI->session->userdata('email_receipt');
    }

    function set_email_receipt($email_receipt) {
        $this->CI->session->set_userdata('email_receipt', $email_receipt);
    }

    function clear_email_receipt() {
        $this->CI->session->unset_userdata('email_receipt');
    }

    function get_partial_transactions() {
        return $this->CI->session->userdata('partial_transactions');
    }

    function add_partial_transaction($partial_transaction) {
        $partial_transactions = $this->CI->session->userdata('partial_transactions');
        $partial_transactions[] = $partial_transaction;
        $this->CI->session->set_userdata('partial_transactions', $partial_transactions);
    }

    function delete_partial_transactions() {
        $this->CI->session->unset_userdata('partial_transactions');
    }

    function add_payment($payment_id, $payment_amount, $discount_money) {
        $payments = $this->get_payments();
        $payment = array($payment_id =>
            array(
                'payment_type' => $payment_id,
                'payment_amount' => $payment_amount,
                'discount_money' => $discount_money, //huyenlt^^
            ),
        );

        //payment_method already exists, add to payment_amount
        if (isset($payments[$payment_id])) {
            $payments[$payment_id]['payment_amount'] += $payment_amount; //huyenlt^^
            $payments[$payment_id]['discount_money'] += $discount_money;
        } else {
            //add to existing array
            $payments+=$payment;
        }

        $this->set_payments($payments);
        return true;
    }

    //Alain Multiple Payments
    function edit_payment($payment_id, $payment_amount, $discount_money) {
        $payments = $this->get_payments();
        if (isset($payments[$payment_id])) {
            $payments[$payment_id]['payment_type'] = $payment_id;
            $payments[$payment_id]['payment_amount'] = $payment_amount;
            $payments[$payment_id]['discount_money'] = $discount_money;
            $this->set_payments($payment_id);
        }

        return false;
    }

    //Alain Multiple Payments
    function delete_payment($payment_id) {
        $payments = $this->get_payments();
        unset($payments[$payment_id]);
        $this->set_payments($payments);
    }

    //Alain Multiple Payments
    function empty_payments() {
        $this->CI->session->unset_userdata('payments');
    }

    function clear_store() {
        $this->CI->session->unset_userdata('store');
    }

    //Alain Multiple Payments
    function get_payments_total() {
        $subtotal = 0;
        foreach ($this->get_payments() as $payments) {
            $subtotal+= ($payments['payment_amount']);
            //$subtotal+= $payments['discount_money'];
        }
        return to_currency_no_money($subtotal);
    }

    function get_payments_total1() {
        $subtotal = 0;
        foreach ($this->get_payments() as $payments) {
            //bỏ dấu phẩy mới tính toán đc
            //$subtotal+= str_replace(array(',', '.'), '', $payments['payment_amount']) + str_replace(array(',', '.'), '', $payments['discount_money']);
            $subtotal+= $payments['payment_amount'] + $payments['discount_money'];
            // print_r($subtotal);
            // die('ssssss');
            //$subtotal+= $payments['payment_amount'];
        }
        return to_currency_no_money($subtotal);
    }

    //Alain Multiple Payments
    function get_amount_due($sale_id = false) {
        $amount_due = 0;
        $payment_total = $this->get_payments_total();
        $sales_total = $this->get_total($sale_id);
        $amount_due = to_currency_no_money($sales_total - $payment_total);
        return $amount_due;
    }

    function get_amount_due1($sale_id = false) {
        $amount_due = 0;
        $payment_total = $this->get_payments_total1();
        $sales_total = $this->get_total($sale_id);
        $amount_due = to_currency_no_money($sales_total - $payment_total);

        return $amount_due;
    }

    function get_customer() {
        if (!$this->CI->session->userdata('customer'))
            $this->set_customer(-1);

        return $this->CI->session->userdata('customer');
    }

    function set_customer($customer_id) {
        $this->CI->session->set_userdata('customer', $customer_id);
    }

    function get_mode() {
        if (!$this->CI->session->userdata('sale_mode'))
            $this->set_mode('sale');

        return $this->CI->session->userdata('sale_mode');
    }

    function set_mode($mode) {
        $this->CI->session->set_userdata('sale_mode', $mode);
    }

    //function add_item($item_id,$quantity=1,$discount=0,$price=null,$description=null,$serialnumber=null)
    function add_item($item_id, $quantity = 1, $discount = 0, $taxes = 0, $unit = '', $price = null, $price_rate = null, $description = null, $serialnumber = null, $stored_id = null) {
        //make sure item exists
        if (!$this->CI->Item->exists(is_numeric($item_id) ? (int) $item_id : -1)) {
            //try to get item id given an item_number
            $item_id = $this->CI->Item->get_item_id($item_id);

            if (!$item_id)
                return false;
        }
        else {
            $item_id = (int) $item_id;
        }
        //Alain Serialization and Description
        //Get all items in the cart so far...
        $items = $this->get_cart();

        //We need to loop through all items in the cart.
        //If the item is already there, get it's key($updatekey).
        //We also need to get the next key that we are going to use in case we need to add the
        //item to the cart. Since items can be deleted, we can't use a count. we use the highest key + 1.

        $maxkey = 0;                       //Highest key so far
        $itemalreadyinsale = FALSE;        //We did not find the item yet.
        $insertkey = 0;                    //Key to use for new entry.
        $updatekey = 0;                    //Key to use to update(quantity)

        foreach ($items as $item) {
            //We primed the loop so maxkey is 0 the first time.
            //Also, we have stored the key in the element itself so we can compare.

            if ($maxkey <= $item['line']) {
                $maxkey = $item['line'];
            }

            if (isset($item['item_id']) && $item['item_id'] == $item_id) {
                $itemalreadyinsale = TRUE;
                $updatekey = $item['line'];
            }
        }

        $insertkey = $maxkey + 1;

        $today = date('Y-m-d');
        $price_to_use = ( isset($this->CI->Item->get_info($item_id)->start_date) && isset($this->CI->Item->get_info($item_id)->end_date) && isset($this->CI->Item->get_info($item_id)->promo_price) && (strtotime( $this->CI->Item->get_info($item_id)->start_date) <=  strtotime($this->CI->Sale->get_info_date($this->CI->input->post('suspended_sale_id'))->sale_time)) && (strtotime($this->CI->Item->get_info($item_id)->end_date) >= strtotime($this->CI->Sale->get_info_date($this->CI->input->post('suspended_sale_id'))->sale_time)) ? $this->CI->Item->get_info($item_id)->promo_price : $this->CI->Item->get_info($item_id)->unit_price);

        //array/cart records are identified by $insertkey and item_id is just another field.
        if ($unit == "") {
            if ($this->CI->Item->get_info($item_id)->quantity_first != 0) {
                $unit = "unit_from";
            } else {
                $unit = "unit";
            }
        } 
        
        if(strtotime($this->CI->Item->get_info($item_id)->start_date)< strtotime($this->CI->Sale->get_info_date($this->CI->input->post('suspended_sale_id'))->sale_time)&&
          strtotime($this->CI->Item->get_info($item_id)->end_date)> strtotime($this->CI->Sale->get_info_date($this->CI->input->post('suspended_sale_id'))->sale_time))
            {
          $price =$this->CI->Item->get_info($item_id)->promo_price;
             }
             else{
         $price= $this->CI->Item->get_info($item_id)->unit_price;
            }
           
        $item = array(($insertkey) =>
            array(
                'item_id' => $item_id,
                'line' => $insertkey,
                'name' => $this->CI->Item->get_info($item_id)->name,
                'item_number' => $this->CI->Item->get_info($item_id)->item_number,
                'description' => $description != null ? $description : $this->CI->Item->get_info($item_id)->description,
                'serialnumber' => $serialnumber != null ? $serialnumber : '',
                'allow_alt_description' => $this->CI->Item->get_info($item_id)->allow_alt_description,
                'is_serialized' => $this->CI->Item->get_info($item_id)->is_serialized,
                'quantity' => $quantity,
                'stored_id' => $this->get_store(),
                'discount' => $discount,
                'price' => $price ,
                'price_rate' => $price_rate != null ? $price_rate : $this->CI->Item->get_info($item_id)->unit_price_rate,
                'taxes' => $taxes,
                'unit' => $unit,
            )
        );

        //Item already exists and is not serialized, add to quantity
        if ($itemalreadyinsale && ($this->CI->Item->get_info($item_id)->is_serialized == 0)) {
            $items[$updatekey]['quantity']+=$quantity;
        } else {
            //add to existing array
            $items+=$item;
        }

        $this->set_cart($items);
        return true;
    }

    function add_item_kit($external_item_kit_id_or_item_number, $quantity = 1, $discount = 0, $price = null, $description = null) {
        if (strpos($external_item_kit_id_or_item_number, 'KIT') !== FALSE) {
            //KIT #
            $pieces = explode(' ', $external_item_kit_id_or_item_number);
            $item_kit_id = (int) $pieces[1];
        } else {
            $item_kit_id = $this->CI->Item_kit->get_item_kit_id($external_item_kit_id_or_item_number);
        }

        //make sure item exists
        if (!$this->CI->Item_kit->exists($item_kit_id)) {
            return false;
        }

        if ($this->CI->Item_kit->get_info($item_kit_id)->unit_price == null) {
            foreach ($this->CI->Item_kit_items->get_info($item_kit_id) as $item_kit_item) {
                for ($k = 0; $k < $item_kit_item->quantity; $k++) {
                    $this->add_item($item_kit_item->item_id, 1);
                }
            }

            return true;
        } else {
            $items = $this->get_cart();

            //We need to loop through all items in the cart.
            //If the item is already there, get it's key($updatekey).
            //We also need to get the next key that we are going to use in case we need to add the
            //item to the cart. Since items can be deleted, we can't use a count. we use the highest key + 1.

            $maxkey = 0;                       //Highest key so far
            $itemalreadyinsale = FALSE;        //We did not find the item yet.
            $insertkey = 0;                    //Key to use for new entry.
            $updatekey = 0;                    //Key to use to update(quantity)

            foreach ($items as $item) {
                //We primed the loop so maxkey is 0 the first time.
                //Also, we have stored the key in the element itself so we can compare.

                if ($maxkey <= $item['line']) {
                    $maxkey = $item['line'];
                }

                if (isset($item['item_kit_id']) && $item['item_kit_id'] == $item_kit_id) {
                    $itemalreadyinsale = TRUE;
                    $updatekey = $item['line'];
                }
            }

            $insertkey = $maxkey + 1;

            //array/cart records are identified by $insertkey and item_id is just another field.
            $item = array(($insertkey) =>
                array(
                    'item_kit_id' => $item_kit_id,
                    'line' => $insertkey,
                    'item_kit_number' => $this->CI->Item_kit->get_info($item_kit_id)->item_kit_number,
                    'name' => $this->CI->Item_kit->get_info($item_kit_id)->name,
                    'description' => $description != null ? $description : $this->CI->Item_kit->get_info($item_kit_id)->description,
                    'quantity' => $quantity,
                    'discount' => $discount,
                    'price' => $price != null ? $price : $this->CI->Item_kit->get_info($item_kit_id)->unit_price
                )
            );

            //Item already exists and is not serialized, add to quantity
            if ($itemalreadyinsale) {
                $items[$updatekey]['quantity']+=$quantity;
            } else {
                //add to existing array
                $items+=$item;
            }

            $this->set_cart($items);
            return true;
        }
    }

    function out_of_stock($item_id) {
        //make sure item exists
        if (!$this->CI->Item->check_exist($item_id)) {
            //try to get item id given an item_number
            $item_id = $this->CI->Item->get_item_id($item_id);

            if (!$item_id)
                return false;
        }

        $item = $this->CI->Item->get_info($item_id);
        $quanity_added = $this->get_quantity_already_added($item_id);

        if ($item->quantity - $quanity_added < 0) {
            return true;
        }

        return false;
    }

    function out_of_stock_kit($kit_id) {
        //Make sure Item kit exist
        if (!$this->CI->Item_kit->exists($kit_id))
            return FALSE;

        //Get All Items for Kit
        $kit_items = $this->CI->Item_kit_items->get_info($kit_id);

        //Check each item
        foreach ($kit_items as $itm) {
            $item = $this->CI->Item->get_info($itm->item_id);
            $item_already_added = $this->get_quantity_already_added($itm->item_id);

            if ($item->quantity - $item_already_added < 0) {
                return true;
            }
        }
        return false;
    }

    function get_kit_quantity_already_added($kit_id) {
        $items = $this->get_cart();
        $quanity_already_added = 0;
        foreach ($items as $item) {
            if (isset($item['item_kit_id']) && $item['item_kit_id'] == $kit_id) {
                $quanity_already_added+=$item['quantity'];
            }
        }

        return $quanity_already_added;
    }

    function get_item_id($line_to_get) {
        $items = $this->get_cart();

        foreach ($items as $line => $item) {
            if ($line == $line_to_get) {
                return isset($item['item_id']) ? $item['item_id'] : -1;
            }
        }

        return -1;
    }

    function get_kit_id($line_to_get) {
        $items = $this->get_cart();

        foreach ($items as $line => $item) {
            if ($line == $line_to_get) {
                return isset($item['item_kit_id']) ? $item['item_kit_id'] : -1;
            }
        }
        return -1;
    }

    function is_kit_or_item($line_to_get) {
        $items = $this->get_cart();
        foreach ($items as $line => $item) {
            if ($line == $line_to_get) {
                if (isset($item['item_id'])) {
                    return 'item';
                } elseif ($item['item_kit_id']) {
                    return 'kit';
                }
            }
        }
        return -1;
    }

    function edit_item($line, $description, $serialnumber, $quantity, $discount, $price, $price_rate, $unit, $taxes) {
        $items = $this->get_cart();
        if (isset($items[$line])) {
            $items[$line]['description'] = $description;
            $items[$line]['serialnumber'] = $serialnumber;
            $items[$line]['quantity'] = $quantity;
            $items[$line]['discount'] = $discount;
            $items[$line]['price'] = $price;
            $items[$line]['price_rate'] = $price_rate;
            $items[$line]['unit'] = $unit;
            $items[$line]['taxes'] = $taxes;
            $this->set_cart($items);
        }

        return false;
    }

    function is_valid_receipt($receipt_sale_id) {
        //POS #
        $pieces = explode(' ', $receipt_sale_id);

        if (count($pieces) == 2 && $pieces[0] == 'POS') {
            return $this->CI->Sale->exists($pieces[1]);
        }

        return false;
    }

    function is_valid_item_kit($item_kit_id) {
        //KIT #
        $pieces = explode(' ', $item_kit_id);

        if (count($pieces) == 2 && $pieces[0] == 'KIT') {
            return $this->CI->Item_kit->exists($pieces[1]);
        } else {
            return $this->CI->Item_kit->get_item_kit_id($item_kit_id) !== FALSE;
        }
    }

    function get_valid_item_kit_id($item_kit_id) {
        //KIT #
        $pieces = explode(' ', $item_kit_id);

        if (count($pieces) == 2 && $pieces[0] == 'KIT') {
            return $pieces[1];
        } else {
            return $this->CI->Item_kit->get_item_kit_id($item_kit_id);
        }
    }

    function return_entire_sale($receipt_sale_id) {
        //POS #
        $pieces = explode(' ', $receipt_sale_id);
        $sale_id = $pieces[1];

        $this->empty_cart();
        $this->delete_customer();

        foreach ($this->CI->Sale->get_sale_items($sale_id)->result() as $row) {
            $this->add_item($row->item_id, -$row->quantity_purchased, $row->discount_percent, $row->item_unit_price, $row->description, $row->serialnumber);
        }
        foreach ($this->CI->Sale->get_sale_item_kits($sale_id)->result() as $row) {
            $this->add_item_kit('KIT ' . $row->item_kit_id, -$row->quantity_purchased, $row->discount_percent, $row->item_kit_unit_price, $row->description);
        }
        $this->set_customer($this->CI->Sale->get_customer($sale_id)->person_id);
    }

    function get_suspended_sale_id() {
        return $this->CI->session->userdata('suspended_sale_id');
    }

    function set_suspended_sale_id($suspended_sale_id) {
        $this->CI->session->set_userdata('suspended_sale_id', $suspended_sale_id);
    }

    function delete_suspended_sale_id() {
        $this->CI->session->unset_userdata('suspended_sale_id');
    }

    function delete_item($line) {
        $items = $this->get_cart();
        unset($items[$line]);
        $this->set_cart($items);
    }

    function empty_delete_suspended_sale_id() {
        $this->CI->session->unset_userdata('suspended_sale_id');
    }

    function empty_cart() {
        $this->CI->session->unset_userdata('cart');
    }

    function delete_customer() {
        $this->CI->session->unset_userdata('customer');
    }

    function delete_employee() {
        $this->CI->session->unset_userdata('employees_id');
    }

    function clear_mode() {
        $this->CI->session->unset_userdata('sale_mode');
    }

    function clear_discount_money() {
        $this->CI->session->unset_userdata('discount_money');
    }

    function clear_payments() {
        $this->CI->session->unset_userdata('payments');
    }

    function delete_delivery_employee() {
        $this->CI->session->unset_userdata('delivery_employee');
    }
    
     
    
   

    function clear_all() {
        $this->clear_mode();
        $this->empty_cart();
        $this->clear_comment();
        $this->clear_discount_money();
        $this->clear_date_debt();
        $this->clear_show_comment_on_receipt();
        $this->clear_email_receipt();
        $this->empty_payments();
        $this->clear_payments();
        $this->delete_customer();
        $this->delete_suspended_sale_id();
        $this->empty_delete_suspended_sale_id();
        $this->delete_partial_transactions();
        $this->delete_item();
        $this->delete_employee();
        $this->delete_delivery_employee();
        $this->clear_payment_type();
        $this->clear_bank_account();
        
         $this->clear_date_debt1();
        $this->clear_symbol_order();
        $this->clear_number_order();
    }

    function get_taxes($sale_id = false) {
        $taxes = array();

        if ($sale_id) {
            $taxes_from_sale = array_merge($this->CI->Sale->get_sale_items_taxes($sale_id), $this->CI->Sale->get_sale_item_kits_taxes($sale_id));

            foreach ($taxes_from_sale as $key => $tax_item) {
                $name = $tax_item['percent'] . '% ' . $tax_item['name'];

                if ($tax_item['cumulative']) {
                    $prev_tax = ($tax_item['price'] * $tax_item['quantity'] - $tax_item['price'] * $tax_item['quantity'] * $tax_item['discount'] / 100) * (($taxes_from_sale[$key - 1]['percent']) / 100);
                    $tax_amount = (($tax_item['price'] * $tax_item['quantity'] - $tax_item['price'] * $tax_item['quantity'] * $tax_item['discount'] / 100) + $prev_tax) * (($tax_item['percent']) / 100);
                } else {
                    $tax_amount = ($tax_item['price'] * $tax_item['quantity'] - $tax_item['price'] * $tax_item['quantity'] * $tax_item['discount'] / 100) * (($tax_item['percent']) / 100);
                }

                if (!isset($taxes[$name])) {
                    $taxes[$name] = 0;
                }
                $taxes[$name] += $tax_amount;
            }
        } else {
            $customer_id = $this->get_customer();
            $customer = $this->CI->Customer->get_info($customer_id);

            //Do not charge sales tax if we have a customer that is not taxable
            if (!$customer->taxable and $customer_id != -1) {
                return array();
            }

            foreach ($this->get_cart() as $line => $item) {
                $tax_info = isset($item['item_id']) ? $this->CI->Item_taxes->get_info($item['item_id']) : $this->CI->Item_kit_taxes->get_info($item['item_kit_id']);
                foreach ($tax_info as $key => $tax) {
                    $name = $tax['percent'] . '% ' . $tax['name'];

                    if ($tax['cumulative']) {
                        $prev_tax = ($item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100) * (($tax_info[$key - 1]['percent']) / 100);
                        $tax_amount = (($item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100) + $prev_tax) * (($tax['percent']) / 100);
                    } else {
                        $tax_amount = ($item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100) * (($tax['percent']) / 100);
                    }

                    if (!isset($taxes[$name])) {
                        $taxes[$name] = 0;
                    }
                    $taxes[$name] += $tax_amount;
                }
            }
        }

        return $taxes;
    }

    function get_items_in_cart() {
        $items_in_cart = 0;
        foreach ($this->get_cart() as $item) {
            $items_in_cart+=$item['quantity'];
        }

        return $items_in_cart;
    }

    function get_subtotal() {
        $subtotal = 0;
        foreach ($this->get_cart() as $item) {
            $subtotal+=($item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100);
        }
        return to_currency_no_money($subtotal);
    }

    function get_total($sale_id = false) {
        $total = 0;
        foreach ($this->get_cart() as $item) {
            $total+=($item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100);
        }

        foreach ($this->get_taxes($sale_id) as $tax) {
            $total+=$tax;
        }

        return to_currency_no_money($total);
    }

    // ghep vietlong 07112014

    function get_next_warehouse() {
        return $this->CI->session->userdata('next_warehouse') ? $this->CI->session->userdata('next_warehouse') : '';
    }

    function set_next_warehouse($next_warehouse) {
        $this->CI->session->set_userdata('next_warehouse', $next_warehouse);
    }

    function clear_next_warehouse() {
        $this->CI->session->unset_userdata("next_warehouse");
    }

    // end
    //Created by San
    function get_total_order_of_item() {
        $subtotal = 0;
        foreach ($this->get_cart() as $item) {
            if ($item['unit'] == 'unit') {
                $subtotal+=($item['price'] * $item['quantity'] - ($item['discount'] * $item['price'] * $item['quantity']) / 100);
            } else {
                $subtotal+=($item['price_rate'] * $item['quantity'] - ($item['discount'] * $item['price_rate'] * $item['quantity']) / 100);
            }
        }
        return to_currency_no_money($subtotal);
    }

    function get_total_discount_of_item() {
        $subtotal = 0;
        foreach ($this->get_cart() as $item) {
            if ($item['unit'] == "unit") {
                $subtotal+= $item['price'] * $item['quantity'] * $item['discount'] / 100;
            } else {
                $subtotal+= $item['price_rate'] * $item['quantity'] * $item['discount'] / 100;
            }
        }
        return to_currency_no_money($subtotal);
    }

    function get_total_taxes() {
        $subtotal = 0;
        foreach ($this->get_cart() as $item) {
            if ($item['unit'] == 'unit') {
                $subtotal+= ($item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100) * $item['taxes'] / 100;
            } else {
                $subtotal+= ($item['price_rate'] * $item['quantity'] - $item['price_rate'] * $item['quantity'] * $item['discount'] / 100) * $item['taxes'] / 100;
            }
        }
        return to_currency_no_money($subtotal);
    }

    function get_amount_owe($sale_id = false) {
        $amount_due = 0;
        $payment_total = $this->get_payments_total1();
        $sales_total = $this->get_total_order_of_item($sale_id);
        $total_taxes = $this->get_total_taxes();
        $amount_due = to_currency_no_money($sales_total + $total_taxes - $payment_total);

        return $amount_due;
    }

    //End San
    //stores
    function get_stores() {
        return $this->CI->session->userdata('stores') ? $this->CI->session->userdata('stores') : '';
    }

    function set_stores($stores) {
        $this->CI->session->set_userdata('stores', $stores);
    }

    //cate
    function get_cate() {
        return $this->CI->session->userdata('categorysearch') ? $this->CI->session->userdata('categorysearch') : '';
    }

    function set_cate($cate) {
        $this->CI->session->set_userdata('categorysearch', $cate);
    }

    function clear_cate() {
        $this->CI->session->unset_userdata('categorysearch');
    }

    //hung audi 2-6-15
    //ghep pack ( tuong tu item_kit)
    function add_pack($external_pack_id_or_item_number, $quantity = 1, $discount = 0, $price = null, $description = null) {
        if (strpos($external_pack_id_or_item_number, 'PACK') !== FALSE) {
            //PACK #
            $pieces = explode(' ', $external_pack_id_or_item_number);
            $pack_id = (int) $pieces[1];
        } else {
            $pack_id = $this->CI->Pack->get_pack_id($external_pack_id_or_item_number);
        }

        //make sure item exists
        if (!$this->CI->Pack->exists($pack_id)) {
            return false;
        }

        if ($this->CI->Pack->get_info($pack_id)->unit_price == null) {
            foreach ($this->CI->Pack_items->get_info($pack_id) as $pack_item) {
                for ($k = 0; $k < $pack_item->quantity; $k++) {
                    $this->add_item($pack_item->item_id, 1);
                }
            }

            return true;
        } else {
            $items = $this->get_cart();

            //We need to loop through all items in the cart.
            //If the item is already there, get it's key($updatekey).
            //We also need to get the next key that we are going to use in case we need to add the
            //item to the cart. Since items can be deleted, we can't use a count. we use the highest key + 1.

            $maxkey = 0;                       //Highest key so far
            $itemalreadyinsale = FALSE;        //We did not find the item yet.
            $insertkey = 0;                    //Key to use for new entry.
            $updatekey = 0;                    //Key to use to update(quantity)

            foreach ($items as $item) {
                //We primed the loop so maxkey is 0 the first time.
                //Also, we have stored the key in the element itself so we can compare.

                if ($maxkey <= $item['line']) {
                    $maxkey = $item['line'];
                }

                if (isset($item['pack_id']) && $item['pack_id'] == $pack_id) {
                    $itemalreadyinsale = TRUE;
                    $updatekey = $item['line'];
                }
            }

            $insertkey = $maxkey + 1;

            //array/cart records are identified by $insertkey and item_id is just another field.
            $item = array(($insertkey) =>
                array(
                    'pack_id' => $pack_id,
                    'line' => $insertkey,
                    'pack_number' => $this->CI->Pack->get_info($pack_id)->pack_number,
                    'name' => $this->CI->Pack->get_info($pack_id)->name,
                    'description' => $description != null ? $description : $this->CI->Pack->get_info($pack_id)->description,
                    'quantity' => $quantity,
                    'discount' => $discount,
                    'price' => $price != null ? $price : $this->CI->Pack->get_info($pack_id)->unit_price,
                    'taxes' => $this->CI->Pack->get_info($pack_id)->taxes,
                    'unit' => 'unit',
                )
            );

            //Item already exists and is not serialized, add to quantity
            if ($itemalreadyinsale) {
                $items[$updatekey]['quantity']+=$quantity;
            } else {
                //add to existing array
                $items+=$item;
            }

            $this->set_cart($items);
            return true;
        }
    }

    function out_of_stock_pack($pack_id) {
        //Make sure Pack exist
        if (!$this->CI->Pack->exists($pack_id))
            return FALSE;

        //Get All Items for PACK
        $pack_items = $this->CI->Pack_items->get_info($pack_id);

        //Check each item
        foreach ($pack_items as $itm) {
            $item = $this->CI->Item->get_info($itm->item_id);
            $item_already_added = $this->get_quantity_already_added($itm->item_id);
            if ($item->quantity - $item_already_added < 0) {
                return true;
            }
        }
        return false;
    }

    function get_quantity_already_added($item_id) {
        $items = $this->get_cart();
        $quanity_already_added = 0;
        foreach ($items as $item) {
            if (isset($item['item_id']) && $item['item_id'] == $item_id) {
                $quanity_already_added+=$item['quantity'];
            }
        }
        //Check Item Kist for this item
        $all_kits = $this->CI->Item_kit_items->get_kits_have_item($item_id);

        foreach ($all_kits as $kits) {
            $kit_quantity = $this->get_kit_quantity_already_added($kits['item_kit_id']);
            if ($kit_quantity > 0) {
                $quanity_already_added += ($kit_quantity * $kits['quantity']);
            }
        }
        //hung audi
        //Check Packs for this item
        $all_packs = $this->CI->Pack_items->get_packs_have_item($item_id);

        foreach ($all_packs as $packs) {
            $pack_quantity = $this->get_pack_quantity_already_added($packs['pack_id']);
            if ($pack_quantity > 0) {
                $quanity_already_added += ($pack_quantity * $packs['quantity']);
            }
        }

        return $quanity_already_added;
    }

    function get_pack_quantity_already_added($pack_id) {
        $items = $this->get_cart();
        $quanity_already_added = 0;
        foreach ($items as $item) {
            if (isset($item['pack_id']) && $item['pack_id'] == $pack_id) {
                $quanity_already_added+=$item['quantity'];
            }
        }
        return $quanity_already_added;
    }

    function is_valid_pack($pack_id) {
        //PACK #
        $pieces = explode(' ', $pack_id);
        if (count($pieces) == 2 && $pieces[0] == 'PACK') {
            return $this->CI->Pack->exists($pieces[1]);
        } else {
            return $this->CI->Pack->get_pack_id($pack_id) !== FALSE;
        }
    }

    function get_valid_pack_id($pack_id) {
        //PACK #
        $pieces = explode(' ', $pack_id);

        if (count($pieces) == 2 && $pieces[0] == 'PACK') {
            return $pieces[1];
        } else {
            return $this->CI->Pack->get_pack_id($pack_id);
        }
    }

    function copy_entire_sale($sale_id) {
        $this->empty_cart();
        $this->delete_customer();

        foreach ($this->CI->Sale->get_sale_items($sale_id)->result() as $row) {
            $info_item = $this->CI->Item->get_info($row->item_id);
            if ($row->unit_item == $info_item->unit_from) {
                $unit = "unit_from";
            } else {
                $unit = "unit";
            }
            $this->add_item($row->item_id, $row->quantity_purchased, $row->discount_percent, $row->taxes_percent, $unit, $row->item_unit_price, $row->item_unit_price_rate, $row->description, $row->serialnumber);
        }
        //hung audi 2-6-15 pack
        foreach ($this->CI->Sale->get_sale_packs($sale_id)->result() as $row) {
            $this->add_pack('PACK ' . $row->pack_id, $row->quantity_purchased, $row->discount_percent, $row->pack_unit_price, $row->description);
        }//end hung

        foreach ($this->CI->Sale->get_sale_payments($sale_id)->result() as $row) {
            $this->add_payment($row->payment_type, $row->payment_amount, $row->discount_money);
        }
        $this->set_customer($this->CI->Sale->get_customer($sale_id)->person_id);
        $this->set_comment($this->CI->Sale->get_comment($sale_id));
        $this->set_employees_id($this->CI->Sale->get_employees_id($sale_id));

        $this->set_employees_delivery($this->CI->Sale->get_employees_delivery($sale_id));

        $this->set_date_debt($this->CI->Sale->get_date_debt($sale_id));
        $this->set_date_debt1($this->CI->Sale->get_date_debt1($sale_id));
        
        $this->set_symbol_order($this->CI->Sale->get_symbol_order($sale_id));
        $this->set_number_order($this->CI->Sale->get_number_order($sale_id));
        
        $this->set_comment_on_receipt($this->CI->Sale->get_comment_on_receipt($sale_id));
        $this->set_suspended_sale_id($this->CI->Sale->get_sale_id($sale_id));
    }
    
    //Nov 4 hƯnG aUdI
    function get_payment_type() {
        return $this->CI->session->userdata('payment_type') ? $this->CI->session->userdata('payment_type') : '';
    }

    function set_payment_type($payment_type) {
        $this->CI->session->set_userdata('payment_type', $payment_type);
    }
    function clear_payment_type() {
        $this->CI->session->unset_userdata('payment_type');
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
    
    function set_load_account($load_account) {
        $this->CI->session->set_userdata('load_account', $load_account);
    }    
    function get_load_account() {
        return $this->CI->session->userdata('load_account') ? $this->CI->session->userdata('load_account') : '';
    }

}

?>