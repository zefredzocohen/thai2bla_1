<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class cart extends CI_Controller{
    /*
     *
     */
     public function __construct() {
        parent::__construct();
         session_start();
        $this->load->helper(array('form', 'url'));
        $this->load->library('cart');
        $this->load->model('site/category_model');
        $this->load->model('Unit');
        $this->load->model('Item');
    }

     public function index() {
        foreach ($_POST['number'] as $key => $value) {
            $_SESSION['cart'][$key]['soluong'] = $value;
        }
        $data["template"] = "site/cart/index";
        $this->load->view('site/layout', $data);
    }

    /*
     *
     */
    public function add(){
        $this->load->view('site/cart/add_cart');
    }

     public function remove_all() {
        $this->load->view('site/cart/remove_all');
    }

     public function del_cart() {
        $this->load->view('site/cart/del_cart');
    }

     public function update_cart() {
        $this->load->view('site/cart/update_cart');
    }

    public function save_order() {
        $person_id = $_SESSION['user'];

        $taxes = 0;
        $total_taxes = 0;
        foreach ($_SESSION['cart'] as $listNumber) {
            if ($this->category_model->get_info($listNumber['item_id'])->promo_price > 0) {
                 $unit = $this->category_model->get_info1($this->category_model->get_info($listNumber['item_id'])->unit);
                $price = $listNumber['promo_price'];
            } else {
                if ($this->category_model->get_info($listNumber['item_id'])->unit_from == 0) {
                    $unit = $this->category_model->get_info1($this->category_model->get_info($listNumber['item_id'])->unit);
                    $price = $listNumber['unit_price'];
                } else {
                    $unit = $this->category_model->get_info1($this->category_model->get_info($listNumber['item_id'])->unit_from);
                    $price = $listNumber['unit_price_rate'];
                }
            }


            $taxes = ($price * $listNumber['soluong'] - $price * $listNumber['soluong'] * 0) * $this->category_model->get_info($listNumber['item_id'])->taxes / 100;
            $total_taxes += $taxes;
            $total_money += $listNumber['soluong'] * $price + $total_taxes;
            $data_sale = array(
                'sale_time' => date('Y-m-d H:i:s'),
                'date_debt' => date('Y-m-d'),
                'customer_id' => $person_id,
                'employee_id' => 1,
                'payment_type' => 'Tiền mặt:' . $total_money,
                'later_cost_price' => $total_money,
                'actual_money' => $total_money,
                'liability'=>1,
                'sale_status'=>1,
                'comment'=>"Đơn hàng từ website"
            );
        }
       $sale_id = $this->category_model->insert_sale($data_sale);
        if (isset($_SESSION['cart']) && $_SESSION['cart'] != null) {
            foreach ($_SESSION['cart'] as $listNumber) {
                //insert sale
                if ($this->Item->get_info($listNumber['item_id'])->promo_price > 0) {
                    $unit = $this->Unit->get_info($this->Item->get_info($listNumber['item_id'])->unit);
                    $price = $listNumber['promo_price'];
                } else {
                    if ($this->Item->get_info($listNumber['item_id'])->unit_from == 0) {
                        $unit = $this->Unit->get_info($this->Item->get_info($listNumber['item_id'])->unit);
                        $price = $listNumber['unit_price'];
                    } else {
                        $unit = $this->Unit->get_info($this->Item->get_info($listNumber['item_id'])->unit_from);
                        $price = $listNumber['unit_price_rate'];
                    }
                }

                $taxes = ($price * $listNumber['soluong'] - $price * $listNumber['soluong'] * 0) * $this->category_model->get_info($listNumber['item_id'])->taxes / 100;
                $total_taxes += $taxes;
                $total_money += $listNumber['soluong'] * $price + $total_taxes;
                //insert sale_item
                $info_taxes = $this->category_model->get_info($listNumber['item_id'])->taxes;
                $cat_id = $this->category_model->get_info($listNumber['item_id'])->category;

                if ($this->Item->get_info($listNumber['item_id'])->unit_from == 0) {
                    $sales_item = array(
                        'sale_id' => $sale_id,
                        'item_id' => $listNumber['item_id'],
                        'id_customer' => $person_id,
                        'quantity_purchased' => str_replace(array(',', '.00'), '', $listNumber['soluong']),
                        'unit_item' => $this->Item->get_info($listNumber['item_id'])->unit,
                        'item_cost_price' => 0,
                        'item_unit_price' => $listNumber['unit_price'],
                        'item_unit_price_rate' => 0,
                        'discount_percent' => 0,
                        'taxes_percent' => $info_taxes,
                        'date' => date('Y-m-d H:i:s'),
                        'cat_id' => $cat_id
                    );
                } else {
                    $sales_item = array(
                        'sale_id' => $sale_id,
                        'item_id' => $listNumber['item_id'],
                        'id_customer' => $person_id,
                        'quantity_purchased' => str_replace(array(',', '.00'), '', $listNumber['soluong']),
                        'unit_item' => $this->Item->get_info($listNumber['item_id'])->unit_from,
                        'item_cost_price' => 0,
                        'item_unit_price' => $listNumber['unit_price'],
                        'item_unit_price_rate' => $listNumber['unit_price_rate'],
                        'discount_percent' => 0,
                        'taxes_percent' => $info_taxes,
                        'date' => date('Y-m-d H:i:s'),
                        'cat_id' => $cat_id
                    );
                }

                $this->category_model->insert_sale_item($sales_item);


                //insert sale_payment
                $sale_payment = array(
                    'sale_id' => $sale_id,
                    'payment_type' => 'Tiền mặt',
                    'payment_amount' => 0,
                    'discount_money' => 0
                );

                $this->category_model->insert_sale_payment($sale_payment);

                $sale_tam = array(
                    'pays_type' => 'Tiền mặt',
                    'pays_amount' => $total_money,
                    'id_sale' => $sale_id,
                    'date_tam' => date('Y-m-d H:i:s'),
                    'discount_money' => 0,
                );

                $this->category_model->insert_sale_tam($sale_tam);

                $sale_inventory = array(
                    'trans_items' => $listNumber['item_id'],
                    'trans_user' => 1,
                    'trans_people' => $person_id,
                    'trans_date' => date('Y-m-d H:i:s'),
                    'trans_money' => $total_money,
                    'trans_catid' => $cat_id,
                    'trans_comment' => 'POS',
                    'trans_inventory' => 0,
                    'trans_sale' => $sale_id
                );

                $this->category_model->insert_inventory($sale_inventory);
                unset($_SESSION['cart']);
            }
        }
        $data['template'] = 'site/cart/success_session';
        $this->load->view('site/layout', $data);
    }

    public function save_order_customer() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('first_name', 'Họ tên đệm', 'required');
//         $this->form_validation->set_rules('last_name', 'Tên', 'required');
        $this->form_validation->set_rules('phone_number', 'Điện thoại', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('address_1', 'Địa chỉ', 'required');
        $this->form_validation->set_rules('stored_id', 'Cửa hàng', 'required');
        $this->form_validation->set_message('required', '%s không được để trống...');
        if ($this->form_validation->run() !== FALSE)
        {
            //save people and customer
            $people = array(
                'first_name'    => $this->input->post('first_name'),
                'last_name'     => $this->input->post('last_name'),
                'phone_number'  => $this->input->post('phone_number'),
                'email'         => $this->input->post('email'),
                'address_1'     => $this->input->post('address_1'),
                'register_date' => date('Y-m-d')
            );

            $person_id = $this->category_model->register_people($people);
            $customner = array(
                'person_id' => $person_id,
                'account_number' => $this->input->post('account_number'),
                'status'=>0,
            );

            $this->category_model->register_customer($customner);

            //save sale

            $taxes = 0;
            $total_taxes = 0;
            foreach ($_SESSION['cart'] as $listNumber) {
                //insert sale


                if ($this->Item->get_info($listNumber['item_id'])->promo_price > 0) {
                    $unit = $this->Unit->get_info($this->Item->get_info($listNumber['item_id'])->unit);
                    $price = $listNumber['promo_price'];
                } else {
                    if ($this->Item->get_info($listNumber['item_id'])->unit_from == 0) {
                        $unit = $this->Unit->get_info($this->Item->get_info($listNumber['item_id'])->unit);
                        $price = $listNumber['unit_price'];
                    } else {
                        $unit = $this->Unit->get_info($this->Item->get_info($listNumber['item_id'])->unit_from);
                        $price = $listNumber['unit_price_rate'];
                    }
                }


                $taxes = ($price * $listNumber['soluong'] - $price * $listNumber['soluong'] * 0) * $this->category_model->get_info($listNumber['item_id'])->taxes / 100;
                $total_taxes += $taxes;
                $total_money += $listNumber['soluong'] * $price + $total_taxes;
                $data_sale = array(
                    'sale_time' => date('Y-m-d H:i:s'),
                    'date_debt' => date('Y-m-d'),
                    'customer_id' => $person_id,
                    'employee_id' => 1,
                    'payment_type' => 'Tiền mặt:' . $total_money,
                    'later_cost_price' => $total_money,
                    'actual_money' => $total_money,
                    'liability'=>1,
                    'sale_status'=>1,
                    'comment'=>"Đơn hàng từ website"
                );
            }
            $sale_id = $this->category_model->insert_sale($data_sale);
            if (isset($_SESSION['cart']) && $_SESSION['cart'] != null) {
                foreach ($_SESSION['cart'] as $listNumber) {
                    //insert sale
                    if ($this->Item->get_info($listNumber['item_id'])->promo_price > 0) {
                        $unit = $this->Unit->get_info($this->Item->get_info($listNumber['item_id'])->unit);
                        $price = $listNumber['promo_price'];
                    } else {
                        if ($this->Item->get_info($listNumber['item_id'])->unit_from == 0) {
                            $unit = $this->Unit->get_info($this->Item->get_info($listNumber['item_id'])->unit);
                            $price = $listNumber['unit_price'];
                        } else {
                            $unit = $this->Unit->get_info($this->Item->get_info($listNumber['item_id'])->unit_from);
                            $price = $listNumber['unit_price_rate'];
                        }
                    }

                    $taxes = ($price * $listNumber['soluong'] - $price * $listNumber['soluong'] * 0) * $this->category_model->get_info($listNumber['item_id'])->taxes / 100;
                    $total_taxes += $taxes;
                    $total_money += $listNumber['soluong'] * $price + $total_taxes;
                    //insert sale_item
                    $info_taxes = $this->category_model->get_info($listNumber['item_id'])->taxes;
                    $cat_id = $this->category_model->get_info($listNumber['item_id'])->category;

                    if ($this->Item->get_info($listNumber['item_id'])->unit_from == 0) {
                        $sales_item = array(
                            'sale_id' => $sale_id,
                            'item_id' => $listNumber['item_id'],
                            'id_customer' => $person_id,
                            //'quantity_purchased' => $listNumber['soluong'],
                            'quantity_purchased' => str_replace(array(',', '.00'), '', $listNumber['soluong']),
                            'unit_item' => $this->Item->get_info($listNumber['item_id'])->unit,
                            'item_cost_price' => 0,
                            'item_unit_price' => $listNumber['unit_price'],
                            'item_unit_price_rate' => 0,
                            'discount_percent' => 0,
                            'taxes_percent' => $info_taxes,
                            'date' => date('Y-m-d H:i:s'),
                            'cat_id' => $cat_id,
                            'stored_id' => $this->input->post('stored_id')
                        );
                    } else {
                        $sales_item = array(
                            'sale_id' => $sale_id,
                            'item_id' => $listNumber['item_id'],
                            'id_customer' => $person_id,
                             'quantity_purchased' => str_replace(array(',', '.00'), '', $listNumber['soluong']),
                            'unit_item' => $this->Item->get_info($listNumber['item_id'])->unit_from,
                            'item_cost_price' => 0,
                            'item_unit_price' => $listNumber['unit_price'],
                            'item_unit_price_rate' => $listNumber['unit_price_rate'],
                            'discount_percent' => 0,
                            'taxes_percent' => $info_taxes,
                            'date' => date('Y-m-d H:i:s'),
                            'cat_id' => $cat_id,
                            'stored_id' => $this->input->post('stored_id')
                        );
                    }

                    $this->category_model->insert_sale_item($sales_item);


                    //insert sale_payment
                    $sale_payment = array(
                        'sale_id' => $sale_id,
                        'payment_type' => 'Tiền mặt',
                        'payment_amount' => 0,
                        'discount_money' => 0
                    );

                    $this->category_model->insert_sale_payment($sale_payment);

                    $sale_tam = array(
                        'pays_type' => 'Tiền mặt',
                        'pays_amount' => $total_money,
                        'id_sale' => $sale_id,
                        'date_tam' => date('Y-m-d H:i:s'),
                        'discount_money' => 0,
                    );

                    $this->category_model->insert_sale_tam($sale_tam);

                    $sale_inventory = array(
                        'trans_items' => $listNumber['item_id'],
                        'trans_user' => 1,
                        'trans_people' => $person_id,
                        'trans_date' => date('Y-m-d H:i:s'),
                        'trans_money' => $total_money,
                        'trans_catid' => $cat_id,
                        'trans_comment' => 'POS',
                        'trans_inventory' => 0,
                        'trans_sale' => $sale_id,
                        'store_id' => $this->input->post('stored_id')
                    );

                    $this->category_model->insert_inventory($sale_inventory);
                    unset($_SESSION['cart']);
                }
            }
            //and save
            $data['template'] = 'site/cart/success';
            // echo json_encode($_SESSION['cart']);
            echo json_encode(array(
                'success' => true
            ));
        }
        else
        {
            echo json_encode(array(
                'error' => $this->form_validation->error_string(' ', ' ')
            ));
        }


        // $this->load->view('site/layout', $data);
    }

    function addItemToCart() {
        $item_id = $this->input->post('item_id');
        $sql = "SELECT * FROM lifetek_items WHERE item_id='".$item_id."'";
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
            $_SESSION['cart'][$item_id]['sub_total_price'] = number_format($data['unit_price'] * $data['soluong']);
        } else {
            if(array_key_exists($item_id,$_SESSION['cart'])){
                $_SESSION['cart'][$item_id]['soluong'] += 1;
                $_SESSION['cart'][$item_id]['sub_total_price'] = number_format($_SESSION['cart'][$item_id]['unit_price'] * $_SESSION['cart'][$item_id]['soluong']);
            }else{
                $data['soluong'] = 1;
                $_SESSION['cart'][$data['item_id']] = $data;
                $_SESSION['cart'][$item_id]['sub_total_price'] = number_format($data['unit_price'] * $data['soluong']);
            }
        }
        echo json_encode($_SESSION['cart']);
    }

    function removeItemFromCart() {
        $item_id = $this->input->post('item_id');
        $sql = "SELECT * FROM lifetek_items WHERE item_id='".$item_id."'";
        $query = mysql_query($sql);
        $data = mysql_fetch_assoc($query);
        
        //check promo_price
        $now_date = date('Y/m/d');
        if(strtotime($now_date)<=strtotime($data['end_date'])&&strtotime($now_date)>=strtotime($data['start_date'])){
                $real_price=$data['promo_price'];
            }
        else $real_price=$data['unit_price'];
        $data['real_price']=$real_price;
        
        if(isset($_SESSION['cart'])){
            if (isset($_SESSION['cart'][$item_id])) {
                unset($_SESSION['cart'][$item_id]);
            }
        }
        echo json_encode($_SESSION['cart']);
    }

    function changeQuantityItemFromCart() {
        $item_id = $this->input->post('item_id');
        $quantity = $this->input->post('quantity');
        $_SESSION['cart'][$item_id]['soluong'] = $quantity;
        $_SESSION['cart'][$item_id]['sub_total_price'] = number_format($_SESSION['cart'][$item_id]['unit_price'] * $_SESSION['cart'][$item_id]['soluong']);
        echo json_encode($_SESSION['cart']);
    }

}
