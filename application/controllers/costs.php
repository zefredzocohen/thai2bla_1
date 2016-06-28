<?php
require_once(APPPATH . 'third_party/Classes/PHPExcel/IOFactory.php');
require_once(APPPATH . 'libraries/php-excel.class.php');
require_once ("secure_area.php");
class Costs extends Secure_area {
    function __construct() {
        parent::__construct('costs');
        $this->load->library('receiving_lib');
        $this->load->model('Cost');
        $this->load->model('Receiving');
        $this->load->model('Receiving_order');
    }
    function index() {
        $config['base_url'] = site_url('costs/sorting');
        $config['total_rows'] = $this->Cost->count_all();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_costs_manage_table($this->Cost->get_all($data['per_page']), $this);
        $this->load->view('costs/manage', $data);
    }
    function sorting() {
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search) {
            $config['total_rows'] = $this->Cost->search_count_all($search);
            $table_data = $this->Cost->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id_cost', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        } else {
            $config['total_rows'] = $this->Cost->count_all();
            $table_data = $this->Cost->get_all($per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id_cost', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        }
        $config['base_url'] = site_url('costs/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_costs_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }
    function suggest() {
        $suggestions = $this->Cost->get_search_suggestions($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }
    function view($id_cost = -1) {
        $data['controller_name'] = strtolower(get_class());
        $data['cost_info'] = $this->Cost->get_info($id_cost);
        $data['option_cost'] = $this->Cost->get_info_option();
        $data['list_tkdu_parents'] = $this->Tkdu->get_tkdu_parent();
        
        //account_plan
        $account_plan = array('' => ' ---- Chọn hoạch định ----');
        foreach ($this->Tkdu->get_all_account_plan()->result_array() as $ac) {
            $account_plan[$ac['id']] = ' - '.$ac['name'];
        }
        $data['account_plan'] = $account_plan;
        
        //tk_no & co
        $data['list_tk_no'] = $this->Tkdu->get_tkdu_parent();
        $data['list_tk_co'] = $this->Tkdu->get_tkdu_parent();
        
        //Nov 3 bank_account
        $bank_list = array('' => '-- Chọn tài khoản ngân hàng --');
        foreach ($this->Tkdu->get_bank_list()->result() as $bank){
            $bank_list[$bank->id] = $bank->id.' - '.$bank->name;
        }
        $data['bank_list'] = $bank_list;
        $data['bank_account'] = $this->Receiving->get_info_bank_account_by_id_cost($id_cost);
        
        $this->load->view("costs/form", $data);
    }
    function set_tk_no() {
        echo $tk_no = $this->Tkdu->get_info_account_plan($this->input->post('account_plan'))->tk_no;
    }
    function set_tk_co() {
        echo $tk_co = $this->Tkdu->get_info_account_plan($this->input->post('account_plan'))->tk_co;
    }
    function save($id_cost = -1) {
        $supplier_id = $_POST['cost_supplier'];
        $time_now = date('H:i:s');
        $cost_date = date('Y-m-d', strtotime($this->input->post('cost_date')));
        $date_full = $cost_date . ' ' . $time_now;
        $cost_date_ct = date('Y-m-d', strtotime($this->input->post('cost_date_ct')));
        $costs_method = $this->input->post('costs_method');
        $customer_id = $_POST['cost_customer'];
        
        $discount_money = $this->input->post('discount_money') ? str_replace(array(','), '', $this->input->post('discount_money')) : 0;
        $discount_money_total = $this->input->post('discount_money') ? str_replace(array(','), '', $this->input->post('discount_money')) : 0;
        $employees = $this->session->userdata('person_id');
        $data['employees'] = $this->Employee->get_info($employees);
        $data['supplier'] = $this->Supplier->get_info($supplier_id);
        $data['customer'] = $this->Person->get_info($customer_id);
        $form_cost = $costs_method == 1 ? 0 : 1;
        $payment_type = $this->input->post('payment_type');
        $tien = str_replace(array(',', '.00'), '', $this->input->post('price_cost'));        
    	$choose= $this->input->post('radio');
        $total_pay = 0; 
        
        $money_cus = str_replace(',', '', $this->input->post('price_cost'));
        $money_cus_Zenda = str_replace(',', '', $this->input->post('price_cost'));
        $data['money_total'] = $money_cus;        
        $data['receiving_payment_paid_ok'] = array();
        $data['receiving_payment_paid_no'] = array();
        $tk_no = $this->input->post('tk_no');
        $tk_co = $this->input->post('tk_co');
        $tk_no_append = $this->input->post('tk_no_append');
        $tk_co_append = $this->input->post('tk_co_append');        
        $comment = $this->input->post('description');
        $money_debt = $_POST['money_debt'];
        $human = $this->input->post('human');
        $bank_account = $this->input->post('bank_account');
        $account_plan = $this->input->post('account_plan');
        
        if($choose == 1||$choose == 4){//nv     
            $cost_data['id_customer']=$this->input->post('cost_emp');
            $employees_id = $this->input->post('cost_emp');
            $cost_data = array(
                'date' => $date_full,
                'form_cost' => $form_cost,
                'money' => $tien,
                'tk_no' => $tk_no_append,
                'tk_co' => $tk_co_append,
                'cost_date_ct' => $cost_date_ct,
                'comment' => $comment,
                'cost_employees' => $this->Employee->get_logged_in_employee_info()->person_id,
                'employees_id' => $employees_id,
                'human' => $human,
                'payment_type' => $payment_type,
                'account_plan' => $account_plan
            );
            $person = $choose == 1 ? $employees_id : $human;               
            $this->Cost->save($cost_data, $id_cost);   
            
            
            
            if($id_cost == -1) {
                $id_cost2 = $this->Cost->get_max_id();
                if ($payment_type == 2) {
                    //save bank_account
                    $bank_account_data = array(
                        'id_cost' => $id_cost2['id_cost'],
                        'bank_account' => $bank_account
                    );
                    $this->Receiving->save_bank_account($bank_account_data, $id_cost2['id_cost']);
                }
                $this->vhoadon_sort($id_cost2['id_cost'], $employees_id);
            }else{
                if ($payment_type == 2) {
                    //save bank_account
                    $bank_account_data = array(
                        'id_cost' => $id_cost,
                        'bank_account' => $bank_account
                    );
                    $this->Receiving->save_bank_account($bank_account_data, $id_cost);
                }
                $this->vhoadon_sort($id_cost, $employees_id);
            }

        }elseif($choose== 2){//nv & kh
            $sale_id = $_POST['check_dh'];
            if ($sale_id == null) { // check neu khong don hang nao duoc chon
                $arr_sale = array();
                $data['receiving_order'] = $this->Cost->get_cong_no_khach_hang($customer_id);
                foreach ($data['receiving_order'] as $val) {
                    $data_receiving_tam = $this->Cost->get_payment_by_sale_id($val['sale_id']);
                    $to = 0;
                    foreach ($data_receiving_tam as $key => $val1) {
                        $to += $val1['pays_amount'] + $val1['discount_money'];
                    }
                    $total_price = $val['later_cost_price'];                    
                    $data['liabilities'][] = array(
                        'key'   => (int)$val['sale_id'],
                        'val'   => (float)($total_price - $to),
                    );                    
                    $data['sum_money'] =  $_POST['total_no'];
                    $arr_sale[] = $val['sale_id'];
                }       
                $arr_sale = implode(', ', $arr_sale);
            } else {
                $data['sum_money'] = 0;
                $arr_sale = array();
                foreach ($sale_id as $key1 => $val1) {
                    foreach ($val1 as $key2 =>$val2){
                        $data['liabilities'][] = array(
                            'key'   => (int)$key1,
                            'val'   => (float)$val2,
                            'thue' => (float)$key2
                        );
                        $arr_sale[] = $key1;
                    }
                    $data['sum_money'] = $data['sum_money'] + $val2;
                }
                $arr_sale = implode(', ', $arr_sale);
            }     
            if($costs_method == 2){//chi
                $info_customer = $this->Customer->get_info($customer_id);
                $cost_data = array(
                    'id_customer' => $customer_id,
                    'name' => 8,
                    'form_cost' => 1,
                    'money' => $tien,
                    'money_du' => $tien,
                    'date' =>$date_full,
                    'cost_date_ct' => $cost_date_ct,
                    'comment' => "Chi tiền cho khách hàng: $info_customer->first_name $info_customer->last_name",
                    'deleted' => 0,
                    'cost_employees' => $employees,
                    'tk_no'=> $tk_no,
                    'tk_co'=> $tk_co,
                    'payment_type' => $payment_type,
                   
                );
                //Oct 14 Hưng Audi
                if($id_cost == -1){
                    $id_cost_audi = $this->Sale->insert_cost($cost_data);
                }else{
                    $this->Cost->save($cost_data, $id_cost);
                }

                 $cost_id = $this->db->insert_id();
                 if($payment_type == 1){
                    $data_sale_cost1 = array(
                        'id_cost' => $cost_id,
                        'tkdu' => 111,
                        'money_no' => $tien,
                        'money_co' => 0,
                        'date' => date('Y-m-d H:i:s'),
                        'customer_id' => $customer_id
                    );
                 }elseif($payment_type == 2){
                      $data_sale_cost1 = array(
                        'id_cost' => $cost_id,
                        'tkdu' => $bank_account,
                        'money_no' => $tien,
                        'money_co' => 0,
                        'date' => date('Y-m-d H:i:s'),
                        'customer_id' => $customer_id
                    );
                 }

               $this->Cost->save_sale_cost_tkdu($data_sale_cost1); 
                 
                 
                
                //insert_cost_detail
                $data_customer = $this->Cost->get_cong_no_khach_hang($customer_id);
                if($data_customer){
                    foreach ($data_customer as $data1){
                        foreach ($money_debt as $key8 => $val8) {
                            if($data1['sale_id'] == $key8){
                                $data_cost_detail = array(
                                    'id_cost' => $id_cost_audi,
                                    'sale_id' => $data1['sale_id'],
                                    'money_debt' => $val8
                                );
                                $this->Cost->insert_cost_detail($data_cost_detail);
                            }
                        }
                    }
                }
            }
    //------------------------------------------------------------------------------------------------------------------------
    if($costs_method == 1){//thu
//                $info_customer = $this->Customer->get_info($customer_id);
//                $cost_data = array(
//                    'id_customer' => $customer_id,
//                    'name' => 8,
//                    'form_cost' => 0,
//                    'money' => $tien,
//                    'date' => $date_full,
//                    'cost_date_ct' => $cost_date_ct,
//                    'comment' => "Thu tiền khách hàng: $info_customer->first_name $info_customer->last_name",
//                    'deleted' => 0,
//                    'cost_employees' => $employees,
//                    'tk_no'=> $tk_no,
//                    'tk_co'=> $tk_co,
//                    'payment_type' => $payment_type,
//                    'stt' => 1
//                );
//                //Oct 14 Hưng Audi
//                if($id_cost == -1){
//                    $id_cost_audi = $this->Sale->insert_cost($cost_data);
//                }else{
//                    $this->Cost->save($cost_data, $id_cost);
//                }

                 //$cost_id = $this->db->insert_id();
                 if($payment_type == 1){
                    $data_sale_cost = array(
                        'id_cost' => $cost_id,
                        'tkdu' => 111,
                        'money_no' => 0,
                        'money_co' => $tien,
                        'date' => date('Y-m-d H:i:s'),
                        'customer_id' => $customer_id
                    );
                 }elseif($payment_type == 2){
                      $data_sale_cost = array(
                        'id_cost' => $cost_id,
                        'tkdu' => $bank_account,
                        'money_no' => 0,
                        'money_co' => $tien,
                        'date' => date('Y-m-d H:i:s'),
                        'customer_id' => $customer_id
                    );
                 }

               $this->Cost->save_sale_cost_tkdu($data_sale_cost); 
                 
                 
                
                //insert_cost_detail
                $data_customer = $this->Cost->get_cong_no_khach_hang($customer_id);
                if($data_customer){
                    foreach ($data_customer as $data1){
                        foreach ($money_debt as $key8 => $val8) {
                            if($data1['sale_id'] == $key8){
                                $data_cost_detail = array(
                                    'id_cost' => $id_cost_audi,
                                    'sale_id' => $data1['sale_id'],
                                    'money_debt' => $val8
                                );
                                $this->Cost->insert_cost_detail($data_cost_detail);
                            }
                        }
                    }
                }
            }
    //--------------------------------------------------------------------------------------------------------------------------------
            
//            $cost_id = $this->db->insert_id();
//            if($costs_method == 1){ //cost_method : thu hoặc chi 1 :thu ,2 : chi
//                  if($payment_type == 1){
//                    $data_sale_cost = array(
//                        'id_cost' => $cost_id,
//                        'tkdu' => 111,
//                        'money_no' => 0,
//                        'money_co' => $tien,
//                        'date' => date('Y-m-d H:i:s'),
//                        'customer_id' => $customer_id
//                    );
//                 }elseif($payment_type == 2){
//                      $data_sale_cost = array(
//                        'id_cost' => $cost_id,
//                        'tkdu' => $bank_account,
//                        'money_no' => 0,
//                        'money_co' => $tien,
//                        'date' => date('Y-m-d H:i:s'),
//                        'customer_id' => $customer_id
//                    );
//                 }
//                $this->Cost->save_sale_cost_tkdu($data_sale_cost);
//            }elseif($costs_method == 2){
//                     if($payment_type == 1){
//                    $data_sale_cost1 = array(
//                        'id_cost' => $cost_id,
//                        'tkdu' => 111,
//                        'money_no' => $tien,
//                        'money_co' => 0,
//                        'date' => date('Y-m-d H:i:s'),
//                        'customer_id' => $customer_id
//                    );
//                 }elseif($payment_type == 2){
//                      $data_sale_cost1 = array(
//                        'id_cost' => $cost_id,
//                        'tkdu' => $bank_account,
//                        'money_no' => $tien,
//                        'money_co' => 0,
//                        'date' => date('Y-m-d H:i:s'),
//                        'customer_id' => $customer_id
//                    );
//                 }
//
//               $this->Cost->save_sale_cost_tkdu($data_sale_cost1);
//            }
            //lấy đủ tiền thì thu thừa
            foreach ($data['liabilities'] as $key => $value) {
                if($costs_method == 1){//thu
                    if($discount_money <= 0){
                        //$money_cus -= $value['val'];
                        $discount = 0;
                        $cost_comment = "Thu tiền công nợ khách hàng" . $data['customer']->first_name.' '.$data['customer']->last_name;     
                        $cost_data = array(
                            'id_customer' => $customer_id,
                            'name' => 8,
                            'form_cost' => 0,
                            'money' => $money_cus >= $value['val'] ? $value['val'] : $money_cus,
                            'money_du' => $money_cus,
                            'date' => $date_full,
                            'cost_date_ct' => $cost_date_ct,
                            'comment' => $cost_comment,
                            'deleted' => 0,
                            'id_sale' => $value['key'],
                            'cost_employees' => $employees,
                            'tk_no'=> $tk_no,
                            'tk_co'=> $tk_co,
                            'payment_type' => $payment_type,
                            'stt' => 1
                        );
                        
                     
                        
                        //Oct 14 Hưng Audi
                        if($id_cost == -1){
                            $id_cost_audi = $this->Sale->insert_cost($cost_data);   
                            $data_tam = array(
                                'id_sale' => $value['key'],
                                'pays_type' => "Trả góp",
                                'pays_amount' => $money_cus,//$money_cus >= 0 ? $value['val'] : $value['val'] - abs($money_cus),
                                'discount_money' => $discount,
                                'employees_id' => $employees,
                                'date_tam' => date('Y-m-d H:i:s'),
                                'id_cost' => $id_cost_audi
                            );
                            $this->Sale->insert_sales_tam($data_tam);
                        }else{
                            $this->Cost->save($cost_data, $id_cost);
                            $data_tam = array(
                                'id_sale' => $value['key'],
                                'pays_type' => "Trả góp",
                                'pays_amount' => $money_cus,//$money_cus >= 0 ? $value['val'] : $value['val'] - abs($money_cus),
                                'discount_money' => $discount,
                                'employees_id' => $employees,
                                'date_tam' => date('Y-m-d H:i:s'),
                            );
                            $this->Cost->update_sales_tam($data_tam, $id_cost);
                        }
                        
                       $data_sale_payment = array(
                           'sale_id' => $value['key'],
                           'payment_type' => 'Tiền mặt',
                           'payment_amount' => $money_cus >= $value['val'] ? $value['val'] : $money_cus,
                           'discount_money' => $discount,
                           'stt' => 1
                       );
                                    
                       $this->Cost->save_sale_payment($data_sale_payment);
                    }else{//Co CK
                        if($discount_money >= $value['val']){
                            $discount = $value['val'];
                            $money_cus = $money_cus;
                            $discount_money = $discount_money - $value['val'];
                        }else{
                            $money_cus = ($money_cus + $discount_money)>= $value['val'] 
                                ? $money_cus - $value['val'] + $discount_money
                                : $money_cus - $value['val'];
                            $discount = $discount_money;
                            $discount_money = 0;                    
                        }
                        $money = $discount_money < $value['val'] ? $value['val'] - $discount : 0;
                        $hieu1 = $value['val'] - abs($money_cus);
                        $hieu2 = $value['val'] - abs($money_cus) - $discount_money;
                        $residual       = $discount_money < $value['val'] ? $hieu1: $hieu2;
                        $pays_amount    = $discount_money < $value['val'] ? $hieu2 : $hieu1;

                        $cost_comment = $money_cus >= 0 
                                        ? "Thu công nợ khách hàng " . $data['customer']->first_name.' '.$data['customer']->last_name
                                        : "Thu công nợ khách hàng " . $data['supplier']->company_name;
                        $cost_comment_d = $money_cus >= 0 
                                        ? "Chiết khấu cho khách hàng" . $data['customer']->first_name.' '.$data['customer']->last_name
                                        : "Chiết khấu cho khách hàng " . $data['supplier']->company_name;
                        $cost_data = array(
                            'id_customer' => $customer_id,
                            'name' => 8,
                            'form_cost' => 0,
                            'money' => $money_cus_Zenda,//$money_cus >= 0 ? $money : $pays_amount,
                            'date' => $date_full,
                            'cost_date_ct' => $cost_date_ct,
                            'comment' => $cost_comment,
                            'deleted' => 0,
                            'id_sale' => $value['key'],
                            'cost_employees' => $employees,
                            'tk_no'=> $tk_no,
                            'tk_co'=> $tk_co,
                            'payment_type' => $payment_type
                        );
                        //Oct 12 Hưng Audi
                        if($id_cost == -1){
                            $id_cost_audi = $this->Sale->insert_cost($cost_data);

//                            $this->Sale->insert_cost($cost_data_d);
                            $data_tam = array(
                                'id_sale' => $value['key'],
                                'pays_type' => "Trả góp",
                                'pays_amount' => $money_cus,//$money_cus >= 0 ? $money : $pays_amount,
                                'discount_money' => $discount,
                                'employees_id' => $employees,
                                'date_tam' => date('Y-m-d H:i:s'),
                                'id_cost' => $id_cost_audi
                            );
                            $this->Sale->insert_sales_tam($data_tam);

                            
                        }else{
                            $this->Cost->save($cost_data, $id_cost);
//                            $this->Cost->save($cost_data_d, $id_cost);
                            $data_tam = array(
                                'id_sale' => $value['key'],
                                'pays_type' => "Trả góp",
                                'pays_amount' => $money_cus,//$money_cus >= 0 ? $money : $pays_amount,
                                'discount_money' => $discount,
                                'employees_id' => $employees,
                                'date_tam' => date('Y-m-d H:i:s'),
                            );
                            $this->Cost->update_sales_tam($data_tam, $id_cost);
                        }
                        
                        
                        
                    }
                    
                                     
                    
                
                    
                    //Oct 12 Hưng Audi
                    //insert_cost_detail
                    $data_customer = $this->Cost->get_cong_no_khach_hang($customer_id);
                    if($data_customer){
                        foreach ($data_customer as $data1){
                            foreach ($money_debt as $key8 => $val8) {
                                if($data1['sale_id'] == $key8){
                                    $data_cost_detail = array(
                                        'id_cost' => $id_cost_audi,
                                        'sale_id' => $data1['sale_id'],
                                        'money_debt' => $val8
                                    );
                                    
                                    $this->Cost->insert_cost_detail($data_cost_detail);
                                }
                            }
                        }
                    }
                    
                     
                    
                    if($money_cus >= 0){
                        $data['receiving_payment_paid_ok'][] = array(
                            'key' => $value['key'],
                            'val' => $value['val'],
                            'money' => $discount_money <= 0 ? $value['val'] : $money,
                        );
                        $sus = array('suspended' => 1);
                        $this->Sale->update($sus, $value['key']);
                    }else{
                        $data['receiving_payment_paid_no'][]= array(
                            'key' => $value['key'],
                            'val' => $value['val'],
                        );
                        $data['residual'] = $discount_money <= 0 ? $value['val'] - abs($money_cus) : $residual;
                        $sus = array('suspended' => 1);
                        $this->Sale->update($sus, $value['key']);
                        break;
                    }
                }
            } 
            if($id_cost == -1){
                if ($payment_type == 2) {
                    //save bank_account
                    $bank_account_data = array(
                        'id_cost' => $id_cost_audi,
                        'bank_account' => $bank_account
                    );
                    $this->Receiving->save_bank_account($bank_account_data, $id_cost_audi);
                }
                $this->vhoadon_sort($id_cost_audi, $customer_id);
            }else{
                if ($payment_type == 2) {
                    //save bank_account
                    $bank_account_data = array(
                        'id_cost' => $id_cost,
                        'bank_account' => $bank_account
                    );
                    $this->Receiving->save_bank_account($bank_account_data, $id_cost);
                }
                $this->vhoadon_sort($id_cost, $customer_id);
            }
            
           
            
    	}elseif($choose== 3){//nv & ncc
            $recv_id = $_POST['check_dh'];
            $cost_data['id_customer']=$this->input->post('cost_supplier');            
            if ($recv_id == null) { // check neu khong don hang nao duoc chon
                $arr_recv = array();
                $data['receiving_order'] = $this->Receiving->get_supplier_owe($supplier_id);
                foreach ($data['receiving_order'] as $val) {
                    $data_receiving_tam = $this->Receiving->get_receiving_tam($val['receiving_id']);
                    $to = 0;
                    foreach ($data_receiving_tam as $key => $val1) {
                        $to += $val1['pays_amount'] + $val1['discount_money'];
                    }
                    $total_price = $this->Receiving->get_total_receiving($val['receiving_id']);
                    $data['liabilities'][] = array(
                        'key'   => (int)$val['receiving_id'],
                        'val'   => (int)($total_price['total_price'] - $to),
                        'money_debt' => $money_debt
                    );
                    $data['sum_money'] =  $_POST['total_no'];
                    $arr_recv[] = $val['receiving_id'];
                }
                $arr_recv = implode(', ', $arr_recv);
            } else {
                $arr_recv = array();
                $data['sum_money'] = 0;
                foreach ($recv_id as $key => $val) {
                    $data['liabilities'][] = array(
                        'key'   => (int)$key,
                        'val'   => (int)$val,
                        'money_debt' => $money_debt
                    );
                    $data['sum_money'] = $data['sum_money'] + $val;
                    $arr_recv[] = $key;
                }
                $arr_recv = implode(', ', $arr_recv);
            }
            if($costs_method == 1){//thu
                $info_supplier = $this->Supplier->get_info($supplier_id);
                $cost_data = array(
                    'supplier_id' => $supplier_id,
                    'name' => 8,
                    'form_cost' => 0,
                    'money' => $tien,
                    'date' => $date_full,
                    'cost_date_ct' => $cost_date_ct,
                    'comment' => "Thu tiền từ nhà cung cấp: $info_supplier->company_name",
                    'deleted' => 0,
                    'cost_employees' => $employees,
                    'tk_no'=> $tk_no,
                    'tk_co'=> $tk_co,
                    'payment_type' => $payment_type
                );
                //Oct 14 Hưng Audi
                if($id_cost == -1){
                    $id_cost_audi = $this->Sale->insert_cost($cost_data);
                }else{
                    $this->Cost->save($cost_data, $id_cost);
                }
                //insert_cost_detail
                $data_supplier = $this->Cost->get_cong_no_ncc($supplier_id);
                if($data_supplier){
                    foreach ($data_supplier as $data1){
                        foreach ($money_debt as $key8 => $val8) {
                            if($data1['receiving_id'] == $key8){
                                $data_cost_detail = array(
                                    'id_cost' => $id_cost_audi,
                                    'receiving_id' => $data1['receiving_id'],
                                    'money_debt' => $val8
                                );
                                $this->Cost->insert_cost_detail($data_cost_detail);
                            }
                        }
                    }
                }
            }
            
            
            
            
            $thue_nhap = 0;
            foreach ($items as $line => $item) {
                if (isset($item['item_id'])) {
                    $cur_item_info = $this->Item->get_info($item['item_id']);                    
                    $thue_nhap += $item['quantity']*$item['price']*$cur_item_info->taxes/100;
                }
            }
            foreach ($data['liabilities'] as $key => $value) {  
                if($costs_method == 2){//chi
                    if($discount_money <= 0){
//                        $money_cus -= $value['val'];
                        $discount = 0;
                        $cost_comment = $money_cus >= 0
                            ? "Thanh toán nợ đối tác " . $data['supplier']->company_name
                            : "Thanh toán nợ đối tác " . $data['supplier']->first_name;
                        $cost_data = array(
                            'supplier_id' => $supplier_id,
                            'name' => 8,
                            'form_cost' => 1,
                            //'money' => $money_cus,//$money_cus >= 0 ? $value['val'] : $value['val'] - abs($money_cus),
                            'money' => $money_cus >= $value['val'] ? $value['val'] : $money_cus,
                            'money_du' => $money_cus,
                            'date' => $date_full,
                            'cost_date_ct' => $cost_date_ct,
                            'comment' => $cost_comment,
                            'deleted' => 0,
                            'id_receiving' => $value['key'],
                            'cost_employees' => $employees,
                            'tk_no'=> $tk_no,
                            'tk_co'=> $tk_co,
                            'payment_type' => $payment_type
                        );
                        //Oct 14 Hưng Audi
                        if($id_cost == -1){
                            $id_cost_audi = $this->Sale->insert_cost($cost_data);
                            $data_tam = array(
                                'id_receiving' => $value['key'],
                                'pays_type' => "Trả góp",
                                'pays_amount' => $money_cus >= $value['val'] ? $value['val'] : $money_cus,//$money_cus >= 0 ? $value['val'] : $value['val'] - abs($money_cus),
                                'discount_money' => $discount,
                                'employees_id' => $employees,
                                'date_tam' => date('Y-m-d H:i:s'),
                                'id_cost' => $id_cost_audi
                            );
                            $this->Receiving->insert_receiving_tam($data_tam);
                        }else{
                            $this->Cost->save($cost_data, $id_cost);
                            $data_tam = array(
                                'id_receiving' => $value['key'],
                                'pays_type' => "Trả góp",
                                'pays_amount' => $money_cus >= $value['val'] ? $value['val'] : $money_cus,//$money_cus >= 0 ? $value['val'] : $value['val'] - abs($money_cus),
                                'discount_money' => $discount,
                                'employees_id' => $employees,
                                'date_tam' => date('Y-m-d H:i:s'),
                            );
                            $this->Cost->update_receivings_tam($data_tam, $id_cost);
                        }
                    }else{//Co CK
                        if($discount_money >= $value['val']){
                            $discount = $value['val'];
                            $money_cus = $money_cus;
                            $discount_money = $discount_money - $value['val'];
                        }else{
                            $money_cus = ($money_cus + $discount_money)>= $value['val']
                                ? $money_cus - $value['val'] + $discount_money
                                : $money_cus - $value['val'];
                            $discount = $discount_money;
                            $discount_money = 0;                    
                        }
                        if($money_cus >= 0){
                            $money = $discount_money >= $value['val'] ? 0 : $value['val'] - $discount;
                        }else{
                            $hieu1 = $value['val'] - abs($money_cus);
                            $hieu2 = $value['val'] - abs($money_cus) - $discount_money;
                            $residual       = $discount_money < $value['val'] ? $hieu1: $hieu2;
                            $pays_amount    = $discount_money < $value['val'] ? $hieu2 : $hieu1;
                        }
                        $cost_comment = "Thanh toán nợ đối tác " . $data['supplier']->company_name;
                        $cost_comment_d = "Khoản khấu trừ/chiết khấu từ " . $data['supplier']->company_name;
                        $cost_data = array(
                            'supplier_id' => $supplier_id,
                            'name' => 8,
                            'form_cost' => 1,
                            'money' => $money_cus_Zenda,//$money_cus >= 0 ? $money : $pays_amount,
                            'date' => $date_full,
                            'cost_date_ct' => $cost_date_ct,
                            'comment' => $cost_comment,
                            'deleted' => 0,
                            'id_receiving' => $value['key'],
                            'cost_employees' => $employees,
                            'tk_no'=> $tk_no,
                            'tk_co'=> $tk_co,
                            'payment_type' => $payment_type
                        );
                        //Oct 12 Hưng Audi
                        if($id_cost == -1){
                            $id_cost_audi = $this->Sale->insert_cost($cost_data);
//                            $this->Sale->insert_cost($cost_data_d);
                            $data_tam = array(
                                'id_receiving' => $value['key'],
                                'pays_type' => "Trả góp",
                                'pays_amount' => $money_cus,//$money_cus >= 0 ? $money : $pays_amount,
                                'discount_money' => $discount,
                                'employees_id' => $employees,
                                'date_tam' => date('Y-m-d H:i:s'),
                                'id_cost' => $id_cost_audi
                            );
                            $this->Receiving->insert_receiving_tam($data_tam);
                        }else{
                            $this->Cost->save($cost_data, $id_cost);
//                            $this->Cost->save($cost_data_d, $id_cost);
                            $data_tam = array(
                                'id_receiving' => $value['key'],
                                'pays_type' => "Trả góp",
                                'pays_amount' => $money_cus,//$money_cus >= 0 ? $money : $pays_amount,
                                'discount_money' => $discount,
                                'employees_id' => $employees,
                                'date_tam' => date('Y-m-d H:i:s'),
                            );
                            $this->Cost->update_receivings_tam($data_tam, $id_cost);
                        }
                    }
                    //Oct 12
                    //insert_cost_detail
                    $data_supplier = $this->Cost->get_cong_no_ncc($supplier_id);
                    if($data_supplier){
                        foreach ($data_supplier as $data1){
                            foreach ($money_debt as $key8 => $val8) {
                                if($data1['receiving_id'] == $key8){
                                    $data_cost_detail = array(
                                        'id_cost' => $id_cost_audi,
                                        'receiving_id' => $data1['receiving_id'],
                                        'money_debt' => $val8
                                    );
                                    $this->Cost->insert_cost_detail($data_cost_detail);
                                }
                            }
                        }
                    }
                    if($money_cus >= 0){
                        $data['receiving_payment_paid_ok'][] = array(
                            'key' => $value['key'],
                            'val' => $value['val'],
                            'money' => $discount_money <= 0 ? $value['val'] : $money,
                        );
                        $sus = array('suspended' => 1);
                        $this->Receiving->update($sus, $value['key']);
                    }else{
                        $data['receiving_payment_paid_no'][]= array(
                            'key' => $value['key'],
                            'val' => $value['val'],
                        );
                        $data['residual'] = $discount_money <= 0 ? $value['val'] - abs($money_cus) : $residual;
                        $sus = array('suspended' => 1);
                        $this->Receiving->update($sus, $value['key']);
                        break;
                    }
                }
            } 
            if($id_cost == -1){
                if ($payment_type == 2) {
                    //save bank_account
                    $bank_account_data = array(
                        'id_cost' => $id_cost_audi,
                        'bank_account' => $bank_account
                    );
                    $this->Receiving->save_bank_account($bank_account_data, $id_cost_audi);
                }
                $this->vhoadon_sort($id_cost_audi, $supplier_id);
            }else{
                if ($payment_type == 2) {
                    //save bank_account
                    $bank_account_data = array(
                        'id_cost' => $id_cost,
                        'bank_account' => $bank_account
                    );
                    $this->Receiving->save_bank_account($bank_account_data, $id_cost);
                }
                $this->vhoadon_sort($id_cost, $supplier_id);
            }
    	}
        
         
    }
    function vhoadon_sort($id_cost, $person_id){
        $data['cost'] = $this->Cost->get_info($id_cost);
        $data['person_id'] = $person_id;
        $data['name_person'] = $this->Person->get_info($person_id)->first_name
                            .' '.$this->Person->get_info($person_id)->last_name. ' '.$data['cost']->human;
        $data['address'] = $this->Person->get_info($person_id)->address_1;
        $data['money'] = $data['cost']->money;
        $data['form_cost'] = $data['cost']->form_cost;
        $data['money_text'] = $this->Cost->get_string_number($data['cost']->money);
        $data['company'] = $this->config->item('company');
        $data['C_address'] = $this->config->item('address');
        $data['tk_no'] = $data['cost']->tk_no;
        $data['tk_co'] = $data['cost']->tk_co;
        $this->load->view('costs/vhoadon', $data);
    }
    function cong_no_ncc(){

        $supplier_id = $this->input->post('supplier_id');
        $data_supplier = $this->Cost->get_cong_no_ncc($supplier_id);
        $info_receiving_item = $this->Receiving_order->get_receiving_item();
        /*
                 * Tính thuế và chi phí
                 */
        $total_taxes = 0;
//        foreach ($data_supplier as $v){
//              $total_receiving = $this->Receiving->get_total_receiving($v['receiving_id']);
//              foreach ($info_receiving_item as $kt1){
//                     if($v['receiving_id'] == $kt1['receiving_id']){
//                                                
//                         $total_taxes = ($total_receiving['total_price'] + $this->Receiving->get_info($v['receiving_id'])->row()->other_cost)*$kt1['taxes']/100;       
//                      }
//               
//            }
//     }    
               /*
                 * 
                 */
        $str .= "<table id='table_order' class=table_order_sup ><tr>";
        $str .= "<th style= 'width: 10%'>Chọn</td>";
        $str .= "<th style= 'width: 20%'>Mã đơn hàng</td>";
        $str .= "<th style= 'width: 35%'>Giá trị đơn hàng</td>";
        $str .= "<th style= 'width: 35%'>Còn nợ</td>";
        $str .= "</tr>";
         
                
        if($data_supplier != NULL){
            foreach ($data_supplier as $data1){
                $total_receiving = $this->Receiving->get_total_receiving($data1['receiving_id']);
              foreach ($info_receiving_item as $kt1){
                     if($data1['receiving_id'] == $kt1['receiving_id']){
                                                
                         $total_taxes = ($total_receiving['total_price'] + $this->Receiving->get_info($data1['receiving_id'])->row()->other_cost)*$kt1['taxes']/100;       
                      }
               
            }
                
                $receiving_money = $this->Cost->get_receiving_item_by_id($data1['receiving_id']);
                $money=0;
                foreach ($receiving_money as $tam1){
                    $money += $tam1['item_unit_price'] * $tam1['quantity_purchased']
                            - $tam1['item_unit_price'] * $tam1['quantity_purchased'] * $tam1['discount_percent'] / 100;
                    
                }
                
                $receving_pament = $this->Cost->get_payment_by_recv_id($data1['receiving_id']);
                $payment = 0;
                foreach ($receving_pament as $tam2){
                    $payment += $tam2['pays_amount']+$tam2['discount_money'];
                }       
               
                
                $total_no += $money-$payment + $total_taxes + $this->Receiving->get_info($data1['receiving_id'])->row()->other_cost;
                $str .= "<tr>";
                $str .= "<td class=td_center ><input type = 'checkbox' name = 'check_dh[".$data1['receiving_id']."]' value = '".abs($money-$payment + $this->Receiving->get_info($data1['receiving_id'])->row()->other_cost + $total_taxes)."'></td>";
                $str .= "<td class=td_center >".$data1['receiving_id']."</td>";
                $str .= "<td class=td_right >".number_format($money + $total_taxes + $this->Receiving->get_info($data1['receiving_id'])->row()->other_cost )."</td>";
                $str .= "<td class=td_right ><input type=hidden name=money_debt[".$data1['receiving_id']."] value=".abs($money-$payment + $this->Receiving->get_info($data1['receiving_id'])->row()->other_cost + $total_taxes)." >"
                            .number_format(abs($money-$payment + $total_taxes + $this->Receiving->get_info($data1['receiving_id'])->row()->other_cost))
                        ."</td>";
                $str .= "</tr>";
            }            
        }
        $str .= "<tr style='font-weight: bold;'>"
                . "<td class=td_right colspan ='3'>Tổng tiền đơn hàng nợ:&nbsp</td>"
                . "<td class=td_right >".number_format($total_no)."</td>"
                . "<input id='total_no' name ='total_no' type='hidden' value='".$total_no."'>"
            . "</tr>";
        $str .="</table>";
        echo $str;
    }
    function cong_no_khach_hang(){
        $customer_id = $this->input->post('customer_id');
        $data_customer = $this->Cost->get_cong_no_khach_hang($customer_id);
        $str .= "<table id='table_order' class=table_order_cus ><tr>";
        $str .= "<th style= 'width: 10%'>Chọn</td>";
        $str .= "<th style= 'width: 15%'>Mã đơn hàng</td>";
        $str .= "<th style= 'width: 30%'>Giá trị đơn hàng</td>";
        $str .= "<th style= 'width: 30%'>Thuế đơn hàng</td>";
        $str .= "<th style= 'width: 15%'>Còn nợ</td>";
        $str .= "</tr>";
        if($data_customer){
            foreach ($data_customer as $data1){                
                $customer_money = $this->Cost->get_sale_item_by_id($data1['sale_id']);
                $thue=0;
                foreach ($customer_money as $tam1){
                    $unit = $this->Item->get_info($tam['unit_item']);
                    if($unit->quantity_first == 0){                       
                        $thue += ( $tam1['item_unit_price_rate'] * $tam1['quantity_purchased']
                                    - $tam1['item_unit_price_rate'] * $tam1['quantity_purchased'] * $tam1['discount_percent']/100
                                ) * $tam1['taxes_percent']/100;
                    }else{
                        $thue += ( $tam1['item_unit_price_rate'] * $tam1['quantity_purchased']
                                    - $tam1['item_unit_price_rate'] * $tam1['quantity_purchased'] * $tam1['discount_percent']/100
                                ) * $tam1['taxes_percent']/100;
                    }
                }
                $customer_payment = $this->Cost->get_payment_by_sale_id($data1['sale_id']);
                $payment = 0;
                foreach ($customer_payment as $tam2){
                    $payment += $tam2['pays_amount']+$tam2['discount_money'];
                }
                $total_no += $data1['later_cost_price']-$payment;
                $str .= "<tr>";
                $str .= "<td class=td_center >"
                    . "<input type = 'checkbox' name = 'check_dh[".$data1['sale_id']."][".$thue."]' value = '".abs($data1['later_cost_price']-$payment)."'>"
                    . "</td>";
                $str .= "<td class=td_center >".$data1['sale_id']."</td>";
                $str .= "<td class=td_right >".number_format($data1['later_cost_price'])."</td>";
                $str .= "<td class=td_right >".number_format($thue)."</td>";
                $str .= "<td class=td_right ><input type=hidden name=money_debt[".$data1['sale_id']."] value=".abs($data1['later_cost_price']-$payment)." >"
                            .number_format(abs($data1['later_cost_price']-$payment))
                        ."</td>";
                $str .= "</tr>";
            }            
        }
        $str .= "<tr style='font-weight: bold;'>"
                . "<td class=td_right colspan ='4'>Tổng tiền đơn hàng nợ:&nbsp</td>"
                . "<td class=td_right >".number_format($total_no)."</td>"
                . "<input id='total_no' name ='total_no' type='hidden' value='".$total_no."'>"
            . "</tr>";
        $str .="</table>";
        echo $str;
        
    }
    function get_row() {
        $cost_id = $this->input->post('row_id');
        $data_row = get_item_data_row($this->Cost->get_info($cost_id), $this);
        echo $data_row;
    }
    function search() {
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Cost->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, 'id_cost', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        $config['base_url'] = site_url('costs/search');
        $config['total_rows'] = $this->Cost->search_count_all($search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_costs_manage_table_data_rows($search_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }
    function delete() {
        $cost_to_delete = $this->input->post('ids');
        if ($this->Cost->delete_list($cost_to_delete)) {
            echo json_encode(array('success' => true, 'message' => lang('items_successful_deleted') . ' ' .
                $total_rows . ' ' . lang('items_one_or_multiple_1')));
        } else {
            echo json_encode(array('success' => false, 'message' => lang('items_cannot_be_deleted')));
        }
    }

    function cleanup() {
        $this->Cost->cleanup();
        echo json_encode(array('success' => true, 'message' => lang('items_cleanup_sucessful')));
    }

    function excel_export() {
        $this->load->view('costs/excel_export');
    }
//    By Loi
    function public_diary(){
        $this->load->view('costs/public_diary_input');
    }
    function do_public_diary(){
         if ($this->input->post('export_excel') == 0) {
            $start_date = date('Y-m-d H:i:s', strtotime($this->input->post('start_date')));            
            $end_date_tam = date('Y-m-d', strtotime($this->input->post('end_date')));
            $end_date = $end_date_tam.' '. "23:59:59";
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['diary'] = $this->Cost->export_cost($start_date,$end_date);
            $this->load->view('costs/export_public_diary', $data);            
         }
    }
    function diary_proceeds(){
        $this->load->view('costs/diary_proceeds_input');
    }
    function do_diary_proceeds(){
        $start_date = date('Y-m-d H:i:s', strtotime($this->input->post('start_date')));            
        $end_date_tam = date('Y-m-d', strtotime($this->input->post('end_date')));
        $end_date = $end_date_tam.' '. "23:59:59";
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['company'] = $this->config->item('company');
        $data['C_address'] = $this->config->item('address');
        $acc = $this->Cost->get_child_acc();
        $thu_chi =0;
        $data['diary'] = $this->Cost->get_account_data($start_date,$end_date,$acc);
        $this->load->view('costs/export_diary_proceeds', $data);            
    }
    function diary_spending(){
        $this->load->view('costs/diary_spending_input');
    }
    function do_diary_spending(){
        if ($this->input->post('export_excel') == 0) {
            $start_date = date('Y-m-d H:i:s', strtotime($this->input->post('start_date')));            
            $end_date_tam = date('Y-m-d', strtotime($this->input->post('end_date')));
            $end_date = $end_date_tam.' '. "23:59:59";
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['company'] = $this->config->item('company');
            $data['C_address'] = $this->config->item('address');
            $acc = $this->Cost->get_child_acc();
            $thu_chi = 1;
            $data['diary'] = $this->Cost->get_account_data($start_date,$end_date,$acc,$thu_chi);
            $this->load->view('costs/export_diary_spending', $data);            
         }
    }
    function super_account(){        
        $this->load->view('costs/super_account_input');
    }
    function do_super_account(){
        if ($this->input->post('export_excel') == 0) {
            $start_date = date('Y-m-d H:i:s', strtotime($this->input->post('start_date')));            
            $end_date_tam = date('Y-m-d', strtotime($this->input->post('end_date')));            
            $end_date = $end_date_tam.' '. "23:59:59";
            $acc_id = $this->input->post('account');
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['company'] = $this->config->item('company');
            $data['C_address'] = $this->config->item('address');
            $data['acc_id'] = $acc_id;
            $acc_arr = $this->Cost->get_child_acc_by_id($acc_id);
            $data['acc_arr'] = $acc_arr;           
            $data['diary'] = $this->Cost->get_account_money($start_date, $end_date,$acc_id, $acc_arr);
            $this->load->view('costs/export_super_account', $data);            
         }
    }
    function detail_account(){        
        $this->load->view('costs/detail_account_input');         
    }
    function do_detail_account(){
        if ($this->input->post('export_excel') == 0) {
            $start_date = date('Y-m-d H:i:s', strtotime($this->input->post('start_date')));            
            $end_date_tam = date('Y-m-d', strtotime($this->input->post('end_date')));
            $account_id = $this->input->post('account');
            $end_date = $end_date_tam.' '. "23:59:59";
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['company'] = $this->config->item('company');
            $data['C_address'] = $this->config->item('address');
            $data['account_id'] =$account_id;
            $data['diary'] = $this->Cost->get_data_by_acc_id($start_date,$end_date,$account_id);
            $this->load->view('costs/export_detail_account', $data);            
         }
    }
    function bank_account_money() {
        $this->load->view('costs/bank_account_money_input');
    }
    function do_bank_account_money(){
        if ($this->input->post('export_excel') == 0) {
            $start_date = date('Y-m-d H:i:s', strtotime($this->input->post('start_date')));            
            $end_date_tam = date('Y-m-d', strtotime($this->input->post('end_date')));
            $end_date = $end_date_tam.' '. "23:59:59";
            $tkdu = $this->input->post('tkdu');
            $acc_id = 112;
            $data['acc_id'] = $acc_id;
            $acc_arr = $this->Cost->get_child_acc_by_id($acc_id);
            $data['acc_arr'] = $acc_arr;           
            $data['cost_exports'] = $this->Cost->get_account_money($start_date, $end_date,$acc_id, $acc_arr);           
            $data['cost_tien_thu'] = 0;
            $data['cost_tien_chi'] = 0;
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            foreach ($data['cost_exports'] as $cost) {
                if($cost['form_cost']==0){
                    $data['cost_tien_thu'] += $cost['money'];
                }else{
                    $data['cost_tien_chi'] += $cost['money'];
                }
            }
            $this->load->view('costs/export_bank_account_money', $data);
        }
    }
    function report_cong_no_khach_hang(){
        $this->load->view('costs/cong_no_khach_hang_input');
    }
    function do_report_cong_no_khach_hang(){
        $start_date = date('Y-m-d H:i:s', strtotime($this->input->post('start_date'))); 
        $end_date_tam = date('Y-m-d', strtotime($this->input->post('end_date')));
        $end_date = $end_date_tam.' '. "23:59:59";
        $customer_id = $this->input->post('customer_id');
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['company'] = $this->config->item('company');
        $data['C_address'] = $this->config->item('address');
        $data['customer_id'] =$customer_id;
        $acc_id = 131;
        $data['acc_id'] = $acc_id;
        $acc_arr = $this->Cost->get_child_acc_by_id($acc_id);
        $data['acc_arr'] = $acc_arr;           
        //$data['diary'] = $this->Cost->get_account_money($start_date, $end_date,$acc_id, $acc_arr);
        $data['diary8'] = $this->Cost->get_sale_cost_tkdu($customer_id, $start_date, $end_date);
        $this->load->view('costs/export_cong_no_khach_hang', $data);
    }
    function report_cong_no_ncc(){
        $this->load->view('costs/cong_no_ncc_input');
    }
    function do_report_cong_no_ncc(){
        $start_date = date('Y-m-d H:i:s', strtotime($this->input->post('start_date'))); 
        $end_date_tam = date('Y-m-d', strtotime($this->input->post('end_date')));
        $end_date = $end_date_tam.' '. "23:59:59";
        $supplier_id = $this->input->post('supplier_id');
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['company'] = $this->config->item('company');
        $data['C_address'] = $this->config->item('address');
        $data['supplier_id'] =$supplier_id;
        $acc_id = 331;
        $data['acc_id'] = $acc_id;
        $acc_arr = $this->Cost->get_child_acc_by_id($acc_id);
        $data['acc_arr'] = $acc_arr;           
        $data['diary'] = $this->Cost->get_account_money($start_date, $end_date,$acc_id, $acc_arr);
         $data['diary1'] = $this->Cost->get_account_money_all($start_date, $end_date,$acc_id, $acc_arr);
        $data['diary8'] = $this->Cost->get_recv_cost_tkdu($supplier_id, $start_date, $end_date);
        $this->load->view('costs/export_cong_no_ncc', $data);
    }
    function tong_hop_cnkh(){
        $this->load->view('costs/tong_hop_cnkh_input');
    }
    function do_tong_hop_cnkh(){
        if ($this->input->post('export_excel') == 0) {
            $start_date = date('Y-m-d H:i:s', strtotime($this->input->post('start_date'))); 
            $end_date_tam = date('Y-m-d', strtotime($this->input->post('end_date')));
            $end_date = $end_date_tam.' '. "23:59:59";
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['company'] = $this->config->item('company');
            $data['C_address'] = $this->config->item('address');           
            $acc_id = 131;
            $data['acc_id'] = $acc_id;
            $acc_arr = $this->Cost->get_child_acc_by_id($acc_id);
            $data['acc_arr'] = $acc_arr;           
            $data['diary'] = $this->Cost->get_account_money($start_date, $end_date,$acc_id, $acc_arr);
            $this->load->view('costs/export_tong_hop_cnkh', $data);
         }
    }
    function tong_hop_cn_ncc(){
        $this->load->view('costs/tong_hop_cn_ncc_input');
    }
    function do_tong_hop_cn_ncc(){
        if ($this->input->post('export_excel') == 0) {
            $start_date = date('Y-m-d H:i:s', strtotime($this->input->post('start_date'))); 
            $end_date_tam = date('Y-m-d', strtotime($this->input->post('end_date')));
            $end_date = $end_date_tam.' '. "23:59:59";
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['company'] = $this->config->item('company');
            $data['C_address'] = $this->config->item('address');           
            $acc_id = 331;
            $data['acc_id'] = $acc_id;
            $acc_arr = $this->Cost->get_child_acc_by_id($acc_id);
            $data['acc_arr'] = $acc_arr;           
            $data['diary'] = $this->Cost->get_account_money($start_date, $end_date,$acc_id, $acc_arr);
            $this->load->view('costs/export_tong_hop_cn_ncc', $data);
         }
    }
     function excel_export_thuchi() {
        $this->load->view('costs/excel_export_thuchi');
    }
    function do_excel_export() {
        if ($this->input->post('export_excel') == 0) {
            $start_date = date('Y-m-d H:i:s', strtotime($this->input->post('start_date')));            
            $end_date_tam = date('Y-m-d', strtotime($this->input->post('end_date')));
            $end_date = $end_date_tam.' '. "23:59:59";
            $tkdu = $this->input->post('tkdu');
            $acc_id = 111;
            $data['acc_id'] = $acc_id;
            $acc_arr = $this->Cost->get_child_acc_by_id($acc_id);
            $data['acc_arr'] = $acc_arr;
            if ($tkdu == 0) {
                $data['cost_exports'] = $this->Cost->get_account_money($start_date, $end_date,$acc_id, $acc_arr);
            } else {
                $data['cost_exports'] = $this->Cost->find_export_tkdu($start_date, $end_date, $tkdu);
            }
            $data['cost_tien_thu'] = 0;
            $data['cost_tien_chi'] = 0;
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            foreach ($data['cost_exports'] as $cost) {
                if($cost['form_cost']==0){
                    $data['cost_tien_thu'] += $cost['money'];
                }else{
                    $data['cost_tien_chi'] += $cost['money'];
                }
            }
            $this->load->view('costs/do_excel_export_account', $data);
        } else {
            /* phan lam 18/8/2013 */
            $start_date = date('Y-m-d', strtotime($this->input->post('start_date')));
            $end_date = date('Y-m-d', strtotime($this->input->post('end_date')));
            $tkdu = $this->input->post('tkdu');
            if ($tkdu == 0) {
                $data = $this->Cost->find_export_excel($start_date, $end_date)->result_object();
            } else {
                $data = $this->Cost->find_export_excel_tkdu($start_date, $end_date, $tkdu)->result_object();
            }
            $this->load->helper('report');
            $rows = array();
            $tien_thu_tong = 0;
            $tien_chi_tong = 0;
            if ($template) {
                $row = array_merge($row, array('Cost Id'));
            }
            $rows[] = $row;
            foreach ($data as $r) {
                $row = array(
                    date("d/m/Y", strtotime($r->date)),
                    $r->chungtu,
                    date("d/m/Y", strtotime($r->cost_date_ct)),
                    $r->name,
                    $r->comment,
                    $r->tk_du,
                    $r->tien_thu > 0 ? to_currency_unVND_nomar($r->tien_thu) : null,
                    $r->tien_chi > 0 ? to_currency_unVND_nomar($r->tien_chi) : null,
                );
                if ($template) {
                    $row = array_merge($row, array($r->id_cost));
                }
                $rows[] = $row;
                $tien_chi_tong += $r->tien_chi;
                $tien_thu_tong += $r->tien_thu;
            }
            require_once APPPATH . "/third_party/Classes/export_costs_account.php";
            /* end phan lam 18/8/2013 */
        }
    }
    function result_business(){
        $this->load->view('costs/result_business_input');
    }
    function do_result_business(){
       if ($this->input->post('export_excel') == 0) {
            $start_date = date('Y-m-d H:i:s', strtotime($this->input->post('start_date'))); 
            $end_date_tam = date('Y-m-d', strtotime($this->input->post('end_date')));
            $end_date = $end_date_tam.' '. "23:59:59";
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['company'] = $this->config->item('company');
            $data['C_address'] = $this->config->item('address');            
            $this->load->view('costs/export_result_business', $data);
         } 
    }
    function report_cdkts() {
        $this->load->view('costs/report_cdkt');
    }
    function do_report_cdkt() {
        if ($this->input->post('export_excel') == 0) {
            $start_date = date('Y-m-d H:i:s', strtotime($this->input->post('start_date'))); 
            $end_date_tam = date('Y-m-d', strtotime($this->input->post('end_date')));
            $end_date = $end_date_tam.' '. "23:59:59";
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['company'] = $this->config->item('company');
            $data['C_address'] = $this->config->item('address');            
            $this->load->view('costs/export_report_cdkt', $data);
        }
    }
    function report_dongtien() {
        $this->load->view('costs/report_dongtien');
    }
    function do_report_dongtien() {
        if ($this->input->post('export_excel') == 0) {
            $start_date = date('Y-m-d H:i:s', strtotime($this->input->post('start_date'))); 
            $end_date_tam = date('Y-m-d', strtotime($this->input->post('end_date')));
            $end_date = $end_date_tam.' '. "23:59:59";
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['company'] = $this->config->item('company');
            $data['C_address'] = $this->config->item('address');            
            $this->load->view('costs/export_report_dongtien', $data);
         }
    }
//end Loi
    function add_new_cost($id_customer) {
        $data['cost_info'] = $this->Cost->get_info($id_cost);
        $data['option_cost'] = $this->Cost->get_info_option();
        $data['id_customer'] = $id_customer;
        $this->load->view('costs/add_new_cost', $data);
    }
    function add_new_cost_emp($id_customer) {
        $data['cost_info'] = $this->Cost->get_info($id_cost);
        $data['option_cost'] = $this->Cost->get_info_option();
        $data['id_customer'] = $id_customer;
        $this->load->view('costs/add_new_cost_emp', $data);
    }
    function save_customer_cost() {
        $cost_date = date("Y-m-d H:i:s");
        $cost_date_ct = date("Y-m-d");
        $costs_method = $this->input->post('costs_method');
        if ($costs_method == 1) {
            $tien_chi = 0;
            $tien_thu = str_replace(array(',', '.00'), '', $this->input->post('price_cost'));
        } else {
            $tien_chi = str_replace(array(',', '.00'), '', $this->input->post('price_cost'));
            $tien_thu = 0;
        }
        $cost_data = array(
            'date' => $cost_date,
            'name' => $this->input->post('name'),
            'tien_chi' => $tien_chi,
            'tien_thu' => $tien_thu,
            'tk_du' => $this->input->post('tk_du'),
            'chungtu' => $this->input->post('chungtu'),
            'cost_date_ct' => $cost_date_ct,
            'comment' => $this->input->post('description'),
            'id_customer' => $this->input->post('id_customer'),
            'cost_employees' => $this->session->userdata('person_id'),
        );
        if ($this->Cost->save_customer_cost($cost_data)) {
            echo json_encode(array('success' => true, 'message' => 'Tạo thu chi thành công'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Lỗi tạo thu chi! Vui lòng kiểm tra lại'));
        }
    }
    function save_emp_cost() {
        $cost_date = date('Y-m-d', strtotime($this->input->post('cost_date')));
        $cost_date_ct = date('Y-m-d', strtotime($this->input->post('cost_date_ct')));
        $costs_method = $this->input->post('costs_method');
        if ($costs_method == 1) {
            $tien_chi = 0;
            $tien_thu = str_replace(array(',', '.00'), '', $this->input->post('price_cost'));
        } else {
            $tien_chi = str_replace(array(',', '.00'), '', $this->input->post('price_cost'));
            $tien_thu = 0;
        }
        $cost_data = array(
            'date' => $cost_date,
            'name' => $this->input->post('name'),
            'tien_chi' => $tien_chi,
            'tien_thu' => $tien_thu,
            'tk_du' => $this->input->post('tk_du'),
            'chungtu' => $this->input->post('chungtu'),
            'cost_date_ct' => $cost_date_ct,
            'comment' => $this->input->post('description'),
            'cost_employees' => $this->input->post('id_customer'),
        );
        $this->Cost->save_customer_cost($cost_data);
        redirect('costs');
    }
    function export_cost_one($id_cost) {
        $cost = $this->Cost->get_info($id_cost);
        if ($cost->tien_thu > 0) {
            require_once APPPATH . "/third_party/Classes/export_thu.php";
        } elseif ($cost->tien_chi > 0) {
            require_once APPPATH . "/third_party/Classes/export_chi.php";
        } else {
            redirect('costs');
        }
    }    
    function get_form_width() {
        return 799;
    }
    //Created by Loi
    function print_bill($id_cost) {
        $data['cost'] = $this->Cost->get_info($id_cost);
        $data['name_person'] = $this->Person->get_info($data['cost']->cost_employees)->first_name
                        .' '.$this->Person->get_info($data['cost']->cost_employees)->last_name;
        $data['address'] = $this->Person->get_info($data['cost']->cost_employees)->address_1;
        $data['money'] = $data['cost']->money;
        $data['form_cost']= $data['cost']->form_cost;
        $data['money_text'] = $this->Cost->get_string_number($data['cost']->money);
        $data['company'] = $this->config->item('company');
        $data['C_address'] = $this->config->item('address');
        $data['tk_no']=$data['cost']->tk_no;
        $data['tk_co']=$data['cost']->tk_co;
        $this->load->view('costs/vhoadon', $data);
    }

    //End by Loi
    
    function receiving_order(){	
        $this->load->view('accountings/tong_hop');
	}
    //28-10-15 Opening AEON mall Long Bien (^_^)
    // hello HallOweeN (^_^)
    
    function diary_recv(){
        $this->load->view('costs/diary_recv_input');
    }
    function do_diary_recv(){
        $start_date = date('Y-m-d H:i:s', strtotime($this->input->post('start_date')));            
        $end_date_tam = date('Y-m-d', strtotime($this->input->post('end_date')));
        $end_date = $end_date_tam.' '. "23:59:59";
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['receiving_HallOweeN'] = $this->Receiving->get_receivings_HallOweeN($start_date, $end_date);
        $this->load->view('costs/diary_recv', $data);          
    }

    function order_service(){
        $config['base_url'] = site_url('costs/sorting_order_service');
		$config['total_rows'] = $this->Cost->count_all_order_service();
		$config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 10; 
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['controller_name']=strtolower(get_class());
		$data['per_page'] = $config['per_page'];
		$data['manage_table']=get_order_service_manage_table($this->Cost->get_all_order_service($data['per_page']),$this);	
		$this->load->view('order_service/manage',$data);
    }
    function sorting_order_service(){
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $config['total_rows'] = $this->Cost->count_all_order_service();
        $table_data = $this->Cost->get_all_order_service(
            $per_page,
            $this->input->post('offset') ? $this->input->post('offset') : 0, 
            $this->input->post('order_col') ? $this->input->post('order_col') : 'id' ,
            $this->input->post('order_dir') ? $this->input->post('order_dir'): 'desc'
        );
		$config['base_url'] = site_url('costs/sorting_order_service');
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_order_service_manage_table_data_rows($table_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));	
	}
    function delete_order_service() {
        $bAbY = $this->input->post('ids');
        if ($this->Cost->delete_list_order_service($bAbY)) {
            echo json_encode(array('success' => true, 'message' => 'Bạn đã xóa thành công hóa đơn dịch vụ !'));
        } else {
            echo json_encode(array('success' => false, 'message' => lang('items_cannot_be_deleted')));
        }
    }
    function view_order_service($bAbY_id=-1){
        $data['id']= $bAbY_id;
		$data['var_info']= $this->Cost->get_info_order_service($bAbY_id);
        //tk_no & co
        $data['list_tk_no'] = $this->Tkdu->get_tkdu_parent();
        $data['list_tk_co'] = $this->Tkdu->get_tkdu_parent();
		$this->load->view("order_service/form",$data);
	}
    /* --;{(@  */
    function save_order_service($bAbY_id=-1){
        $create_date = date('Y-m-d', strtotime( $this->input->post('create_date')));
        $order_date = date('Y-m-d', strtotime( $this->input->post('order_date')));

        $bAbY_data=array(
            'person_id'     => $this->input->post('person_id'),
            'symbol'        => $this->input->post('symbol'),
            'number'        => $this->input->post('number'),
            'create_date'   => $create_date,
            'order_date'    => $order_date,
            'tax_percent'   => $this->input->post('tax_percent'),            
            'comment'       => $this->input->post('comment'),
            'stt' => 0
		);
		if( $this->Cost->save_order_service($bAbY_data,$bAbY_id)){
            
            /* --;{(@  --;{(@  --;{(@  --;{(@  --;{(@  --;{(@  --;{(@  --;{(@ 
            * HAPPY WOMEN'S DAY VIETNAM 20/10/15  
            * from Hưng Audi 
            */
            //save chungtu_detail
            $var_id_tulip = $bAbY_id == -1 ? $bAbY_data['id'] : $bAbY_id;
            $Flowers_data = array();
            foreach ($this->input->post('sotien') as $Tulip => $dollar) {
                foreach ($this->input->post('tk_no') as $Rose => $tk_no) {
                    if ($Tulip == $Rose) {
                        foreach ($this->input->post('tk_co') as $Violet => $tk_co) {
                            if ($Rose == $Violet) {
                                $Flowers_data[] = array(
                                    'chungtu_id' => $var_id_tulip,
                                    'sotien' => str_replace(',', '', $dollar),
                                    'tk_no' => $tk_no,
                                    'tk_co' => $tk_co,
                                    'mark'  => 1
                                );
                            }
                        }   
                    }
                }
            }
            $this->Cost->save_chungtu_detail_order_service($Flowers_data, $var_id_tulip);
            
            if($bAbY_id == -1){
				echo json_encode(array('success'=>true,'message'=>lang('chungtus_successful_adding')));
			}else{
				echo json_encode(array('success'=>true,'message'=>lang('chungtus_successful_updating')));
			}
		}else{
			echo json_encode(array('success'=>false,'message'=>lang('chungtus_error_adding_updating')));
		}
	}
    //end at 11h11'15s on 11/11/15
    
    
    
    //hóa đơn dịch vụ :Bán hàng
        
        function order_service_bh(){
        $config['base_url'] = site_url('costs/sorting_order_service_bh');
		$config['total_rows'] = $this->Cost->count_all_order_service_bh();
		$config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 10; 
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['controller_name']=strtolower(get_class());
		$data['per_page'] = $config['per_page'];
		$data['manage_table']=get_order_service_bh_manage_table($this->Cost->get_all_order_service_bh($data['per_page']),$this);	
		$this->load->view('order_service_bh/manage',$data);
    }
    function sorting_order_service_bh(){
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $config['total_rows'] = $this->Cost->count_all_order_service_bh();
        $table_data = $this->Cost->get_all_order_service_bh(
            $per_page,
            $this->input->post('offset') ? $this->input->post('offset') : 0, 
            $this->input->post('order_col') ? $this->input->post('order_col') : 'id' ,
            $this->input->post('order_dir') ? $this->input->post('order_dir'): 'desc'
        );
		$config['base_url'] = site_url('costs/sorting_order_service_bh');
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_order_service_bh_manage_table_data_rows($table_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));	
	}
    function delete_order_service_bh() {
        $bAbY = $this->input->post('ids');
        if ($this->Cost->delete_list_order_service_bh($bAbY)) {
            echo json_encode(array('success' => true, 'message' => 'Bạn đã xóa thành công hóa đơn dịch vụ !'));
        } else {
            echo json_encode(array('success' => false, 'message' => lang('items_cannot_be_deleted')));
        }
    }
    function view_order_service_bh($bAbY_id=-1){
        $data['id']= $bAbY_id;
        $data['var_info1']= $this->Cost->get_info_order_service_bh($bAbY_id);
        $data['list_tk_no'] = $this->Tkdu->get_tkdu_parent();
        $data['list_tk_co'] = $this->Tkdu->get_tkdu_parent();
        $this->load->view("order_service_bh/form",$data);
	}
    /* --;{(@  */
    function save_order_service_bh($bAbY_id=-1){
        $create_date = date('Y-m-d', strtotime( $this->input->post('create_date')));
        $order_date = date('Y-m-d', strtotime( $this->input->post('order_date')));
        $var_info1= $this->Cost->get_info_order_service_bh($bAbY_id);
        $bAbY_data=array(
            'person_id'     => $this->input->post('person_id'),
            'symbol'        => $this->input->post('symbol'),
            'number'        => $this->input->post('number'),
            'create_date'   => $create_date,
            'order_date'    => $order_date,
            'tax_percent'   => $this->input->post('tax_percent'),            
            'comment'       => $this->input->post('comment'),
            'stt' => 1
		);
		if( $this->Cost->save_order_service($bAbY_data,$bAbY_id)){
            

            //save chungtu_detail
            $var_id_tulip = $bAbY_id == -1 ? $bAbY_data['id'] : $bAbY_id;
            $Flowers_data = array();
            foreach ($this->input->post('sotien') as $Tulip => $dollar) {
                foreach ($this->input->post('tk_no') as $Rose => $tk_no) {
                    if ($Tulip == $Rose) {
                        foreach ($this->input->post('tk_co') as $Violet => $tk_co) {
                            if ($Rose == $Violet) {
                                $Flowers_data[] = array(
                                    'chungtu_id' => $var_id_tulip,
                                    'sotien' => str_replace(',', '', $dollar),
                                    'tk_no' => $tk_no,
                                    'tk_co' => $tk_co,
                                    'mark'  => 1
                                );
                            }
                            
                             //insert sale_cost_tkdu
                         if($bAbY_id == -1){
                                if($tk_no == 131){
                                    $data_recv_cost_tkdu = array(
                                       'id_cost' => $this->input->post('number'),
                                       'tkdu' => $tk_co,
                                       'money_no' => str_replace(',', '', $dollar),
                                       'money_co' => 0,
                                       'date' => $create_date,
                                       'customer_id' => $this->input->post('person_id'),
                                       'comment'=> $this->input->post('comment'),
                                        'stt' => 0,
                                        'stt_cmt'=>1
                                        );
                                   $this->Cost->save_sale_cost_tkdu($data_recv_cost_tkdu);
                                }
                                if($tk_co == 131){
                                     $data_recv_cost_tkdu = array(
                                       'id_cost' => $this->input->post('number'),
                                       'tkdu' => $tk_no,
                                       'money_no' => 0,
                                       'money_co' => str_replace(',', '', $dollar),
                                       'date' => $create_date,
                                       'customer_id' => $this->input->post('person_id'),
                                       'comment'=> $this->input->post('comment'),
                                       'stt' => 0,
                                         'stt_cmt'=>1
                                        );
                                   $this->Cost->save_sale_cost_tkdu($data_recv_cost_tkdu);
                                }
                            }else{

                                    if($tk_no == 131){
                                        $all = $this->Chungtu->get_all_sale_cost();
                                    foreach ($all->result() as $value){
                                        if($value->id_cost == $var_info1->number){
                                            $id = $value->id;
                                        }
                                    }
                                    $data_recv_cost_tkdu = array(
                                       'id_cost' => $var_info1->number,
                                       'tkdu' => $tk_co,
                                       'money_no' => str_replace(',', '', $dollar),
                                       'money_co' => 0,
                                       'date' => $create_date,
                                       'customer_id' => $this->input->post('person_id'),
                                       'comment'=> $this->input->post('comment'),
                                        'stt' => 0,
                                        'stt_cmt'=>1
                                        );
                                   $this->Cost->update_sale_cost_tkdu($data_recv_cost_tkdu,$id);
                                }
                                if($tk_co == 131){
                                    $all = $this->Chungtu->get_all_sale_cost();
                                    foreach ($all->result() as $value){
                                        if($value->id_cost == $var_info1->number){
                                            $id = $value->id;
                                        }
                                    }
                                     $data_recv_cost_tkdu = array(
                                       'id_cost' => $var_info1->number,
                                       'tkdu' => $tk_no,
                                       'money_no' => 0,
                                       'money_co' => str_replace(',', '', $dollar),
                                       'date' => $create_date,
                                       'customer_id' => $this->input->post('person_id'),
                                       'comment'=> $this->input->post('comment'),
                                       'stt' => 0,
                                         'stt_cmt'=>1
                                        );
                                   $this->Cost->update_sale_cost_tkdu($data_recv_cost_tkdu,$id);
                                }
                                if($tk_no != 131 && $tk_co != 131){
                                     $all = $this->Chungtu->get_all_sale_cost();
                                    foreach ($all->result() as $value){
                                        if($value->id_cost == $var_info1->number){
                                            $id = $value->id;
                                        }
                                    }
                                     $data_recv_cost_tkdu = array(
                                       'id_cost' => $var_info1->number,
                                       'tkdu' => $tk_no,
                                       'money_no' => 0,
                                       'money_co' => str_replace(',', '', $dollar),
                                       'date' => $create_date,
                                       'customer_id' => $this->input->post('person_id'),
                                       'comment'=> $this->input->post('comment'),
                                        'stt' => 1,
                                         'stt_cmt'=>1
                                        );
                                   $this->Cost->update_sale_cost_tkdu($data_recv_cost_tkdu,$id);
                                }
                                
                            }
                            //end
                        }   
                    }
                }
            }
            $this->Cost->save_chungtu_detail_order_service_bh($Flowers_data, $var_id_tulip);
            
            if($bAbY_id == -1){
				echo json_encode(array('success'=>true,'message'=>lang('chungtus_successful_adding')));
			}else{
				echo json_encode(array('success'=>true,'message'=>lang('chungtus_successful_updating')));
			}
		}else{
			echo json_encode(array('success'=>false,'message'=>lang('chungtus_error_adding_updating')));
		}
	}
    //end at 11h11'15s on 11/11/15
    
    function nkbh(){
        $this->load->view('costs/nkbh_input');
    }
    function do_nkbh(){
        $start_date = date('Y-m-d H:i:s', strtotime($this->input->post('start_date')));            
        $end_date_tam = date('Y-m-d', strtotime($this->input->post('end_date')));
        $end_date = $end_date_tam.' '. "23:59:59";
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['receiving_HallOweeN'] = $this->Sale->get_sale_nkbh($start_date, $end_date);
        $data['get_order_service'] = $this->Sale->get_order_service_bh();
        $this->load->view('costs/nkbh', $data);          
    }
}

?>