<?php

class Export_lib {

    var $CI;

    function __construct() {
        $this->CI = & get_instance();
    }

    function get_cart() {
        if ($this->CI->session->userdata('cartExp') === false)
            $this->set_cart(array());

        return $this->CI->session->userdata('cartExp');
    }

    function set_cart($cart_data) {
        $this->CI->session->set_userdata('cartExp', $cart_data);
    }

    function add_item($item_id, $quantity=1, $discount=0, $price=null, $description=null, $serialnumber=null, $is_per=false) {
        
        
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
                'discount' => $discount,
                'price' => $price != null ? $price : ($is_per ? $this->CI->Item->get_info($item_id)->cost_price : $this->CI->Item->get_info($item_id)->unit_price),
                'item_number' => $this->CI->Item->get_info($item_id)->item_number
            )
        );

        //Item already exists thì tăng số lượng cho mặt hàng đó
        if ($itemalreadyinsale) {
            $items[$updatekey]['quantity']+=$quantity;
        } else {
            //add to existing array
            $items+=$item;
        }

        $this->set_cart($items);
        return true;
    }

    function edit_item($line, $description, $serialnumber, $quantity, $discount, $price) {
        $items = $this->get_cart();
        if (isset($items[$line])) {
            $items[$line]['description'] = $description;
            $items[$line]['serialnumber'] = $serialnumber;
            $items[$line]['quantity'] = $quantity;
            $items[$line]['discount'] = $discount;
            $items[$line]['price'] = $price;
            $this->set_cart($items);
        }

        return false;
    }

    function is_valid_export($export_receiving_id) {
        //RECV #
        $pieces = explode(' ', $export_receiving_id);

        if (count($pieces) == 2 && $pieces[0] == 'RECV') {
            return $this->CI->Export->exists($pieces[1]);
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

    function return_entire_export($receipt_receiving_id,$store_id="") {
        //POS #
        $pieces = explode(' ', $receipt_receiving_id);
        $export_id = $pieces[1];

        $this->empty_cart();

        foreach ($this->CI->Export->get_export_items($export_id)->result() as $row) {
            $this->add_item($row->item_id, -$row->quantity_purchased, $row->discount_percent, $row->item_unit_price, $row->description, $row->serialnumber);
        }
    }

    function add_item_kit($external_item_kit_id) {
        //KIT #
        $pieces = explode(' ', $external_item_kit_id);
        $item_kit_id = $pieces[1];

        foreach ($this->CI->Item_kit_items->get_info($item_kit_id) as $item_kit_item) {
            $this->add_item($item_kit_item->item_id, $item_kit_item->quantity);
        }
    }

    function copy_entire_export($receiving_id) {
        $this->empty_cart();

        foreach ($this->CI->Export->get_receiving_items($receiving_id)->result() as $row) {
            $this->add_item($row->item_id, $row->quantity_purchased, $row->discount_percent, $row->item_unit_price, $row->description, $row->serialnumber);
        }
    }

    function delete_item($line) {
        $items = $this->get_cart();
        unset($items[$line]);
        $this->set_cart($items);
    }

    function empty_cart() {
        $this->CI->session->unset_userdata('cartExp');
        $this->CI->session->unset_userdata('store_exp');
    }

    function clear_store_exp() {
        $this->CI->session->unset_userdata('store_exp');
    }

    function clear_all() {
        $this->empty_cart();
    }

    function get_total() {
        $total = 0;
        foreach ($this->get_cart() as $item) {
            $total+=($item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100);
        }

        return $total;
    }
    function get_store_exp() {
        if (!$this->CI->session->userdata('store_exp'))
            $this->set_store_exp('1');

        return $this->CI->session->userdata('store_exp');
    }

    function set_store_exp($store) {
        $this->clear_all();
        $this->CI->session->set_userdata('store_exp', $store);
    }
}

?>