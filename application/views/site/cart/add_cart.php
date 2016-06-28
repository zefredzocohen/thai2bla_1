<?php

    $id = $this->uri->segment(4);
    $sql = "SELECT * FROM lifetek_items WHERE item_id='".$id."'";
    $query = mysql_query($sql);
    $data = mysql_fetch_assoc($query);
    //check promo_price
        $now_date = date('Y/m/d');
        if(strtotime($now_date)<=strtotime($data['end_date'])&&strtotime($now_date)>=strtotime($data['start_date'])){
                $real_price=$data['promo_price'];
            }
        else $real_price=$data['unit_price'];
        $data['real_price']=$real_price;
        
    if(!isset($_SESSION['cart']) || $_SESSION['cart'] == null ){
        $data['soluong'] = 1;
        $_SESSION['cart'][$data['item_id']] = $data;
    } else {
        if(array_key_exists($id,$_SESSION['cart'])){
            $_SESSION['cart'][$id]['soluong'] += 1;
        }else{
            $data['soluong'] = 1;
            $_SESSION['cart'][$data['item_id']] = $data;
        }
    }

// redirect(base_url('gio-hang.html'));
 redirect(base_url('thuc-don.html'));
