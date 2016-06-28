<?php

/**
 * @author le xuan bac
 * @copyright 2013
 */

require_once ("secure_area.php");
class Profit extends Secure_area
{

    function __construct()
    {
        parent::__construct('profit');
        $this->load->library('sale_lib');
        //$this->load->library('receiving_lib');
    }

    function index()
    {
        $this->check_action_permission('search');
        $config['base_url'] = site_url('profit/sorting');
        $config['total_rows'] = $this->Profit_m->count_all();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->
            config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_profit_manage_table($this->Profit_m->get_all($data['per_page']),$this);
        $this->load->view('profit/manage', $data);
    }

    function sorting()
    {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int)$this->
            config->item('number_of_items_per_page') : 20;
        if ($search){
            $config['total_rows'] = $this->Profit_m->search_count_all($search);
            $table_data = $this->Profit_m->search($search, $per_page, $this->input->post('offset') ?
                $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->
                input->post('order_col') : 'name', $this->input->post('order_dir') ? $this->
                input->post('order_dir') : 'asc');
        } else {
            $config['total_rows'] = $this->Profit_m->count_all();
            //$config['total_rows']=100;
            $table_data = $this->Profit_m->get_all($per_page, $this->input->post('offset') ?
                $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->
                input->post('order_col') : 'name', $this->input->post('order_dir') ? $this->
                input->post('order_dir') : 'asc');
        }
        $config['base_url'] = site_url('profit/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_profit_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' =>
                $data['pagination']));
    }
    
   	function search()
	{
		$this->check_action_permission('search');
		$search=$this->input->post('search');
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		$search_data=$this->Profit_m->searchsai($search, $per_page, $this->input->
                post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ?
                $this->input->post('order_col') : 'lifetek_profit.id', $this->input->post('order_dir') ?
                $this->input->post('order_dir') : 'desc');
		$config['base_url'] = site_url('profit/search');
		$config['total_rows'] = $this->Profit_m->search_count_all($search);
		$config['per_page'] = $per_page ;
		$this->pagination->initialize($config);				
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_profit_manage_table_data_rows($search_data, $this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
		
	}
	
    
    /*
    Gives search suggestions based on what is being searched for
    */
    function suggest()
    {
        $suggestions = $this->Profit_m->get_search_suggestions($this->input->get('term'),
            100);
        echo json_encode($suggestions);
    }

    /*
    Loads the employee edit form
    */

    function view($profit_id = -1)
    {
        /*
        $this->check_action_permission('add_update');
        $data['person_info']=$this->Employee->get_info($employee_id);
        $data['all_modules']=$this->Module->get_all_modules();
        */
        $this->check_action_permission('add_update');
        if ($profit_id == -1) {
            $data['person_info'] = $this->Profit_m->get_info($profit_id);
            //$data['staff_info']=$this->Employee->count_all_salary();
            $data['staff_info'] = $this->Employee->get_name_salary();
            $data['staff_count'] = $this->Employee->count_all_salary();
            //print_r($data['staff_info']);
            $this->load->view("profit/form", $data); //truyen du lieu
            //$this->load->view("profit/manage",$data);//truyen du lieu
        } elseif ($profit_id == -2) {
            $data['person_info'] = $this->Profit_m->get_info($profit_id);
            $this->load->view("profit/form1", $data); //tao moi cong thuc loi nhuan
        } elseif ($profit_id == -3) {
            $data['person_info'] = $this->Profit_m->get_info($profit_id);
            $this->load->view("profit/form3", $data); //tao moi cong thuc loi nhuan
        } elseif ($profit_id == -4) {
            $data['person_info'] = $this->Profit_m->get_info($profit_id);
            $this->load->view("profit/form4", $data); //tao moi cong thuc loi nhuan
        } else {
            $data['person_info'] = $this->Profit_m->get_info($profit_id);
            $data['profit_info1'] = $this->Profit_m->get_info_other($profit_id);
            $data['profit_info2'] = $this->Profit_m->get_info_empl($profit_id);
            $this->load->view("profit/form5", $data); //truyen du lieu de e dit
        }
    }
	//check trùng tên
    function checkname($id){
        $last_name = $this->input->post('last_name');        
        $d['formula_name']=  $this->Profit_m->getname($id);
        foreach ( $d['formula_name'] as $d2){
            $d3[]= $d2['formula_name'];			
        } 
        $c2= $d3;
        $e1= implode(',', $c2);
        $e2= explode(',',$e1);

        if (in_array($last_name, $e2)){
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }
    /*
    Inserts/updates an employee
    */

    function save($profit_id = -1)
    {
        $this->check_action_permission('add_update');
        $price = $this->input->post('input_price') + $this->input->post('employees_salary') +
            $this->input->post('input_transport') + (($this->input->post('input_tax') * $this->
            input->post('input_price')) / 100) + $this->input->post('profit_price');
        $demfields = $this->input->post('demfield');

        $demtext = $this->input->post('textfield');
        $demtext1 = $this->input->post('textfield1');

        //print_r($demtext);

        //echo count($demtext);

        /*
        $tenfields='textbox';
        $txtbox='textbox2';
        $k=1;
        $tong=0;
        while($k<=$demfields)
        {
        $tenfields1=$tenfields.$k;
        $txtbox2=$txtbox.$k;
        $tong=$tong+($this->input->post($tenfields1))*1; 
        $k++;
        $profit_other=array(
        'f_name'=>$this->input->post('last_name'),
        'cost_name'=>$this->input->post($txtbox2),
        'price2'=>$this->input->post($tenfields1)
        );
        */
        $tong = 0;
        while ($k <= count($demtext)) {
            $tenfields1 = $demtext1[$k];
            $txtbox2 = $demtext[$k];
            $tong = $tong + ($this->input->post($tenfields1)) * 1;
            $k++;
            $profit_other = array(
                'f_name' => $this->input->post('last_name'),
                'cost_name' => $this->input->post($txtbox2),
                'price2' => $this->input->post($tenfields1));

            $this->Profit_m->save_profit_other($profit_other);

        }
        $price = $price + $tong;
        $profit_data = array(
            'formula_name' => $this->input->post('last_name'),
            'name' => $this->input->post('first_name'),
            'fixed_costs' => $this->input->post('input_price'),
            'transport' => $this->input->post('input_transport'),
            'tax' => $this->input->post('input_tax'),
            'commission' => $this->input->post('profit_price'),
            'sum_salary' => $this->input->post('employees_salary'),
            'deleted' => 0,
            'staff_id' => $tong,
            'price' => $price);

        $kiemtra = $this->input->post('last_name');
        if ($this->Profit_m->get_info_formula($kiemtra)) {

            if ($this->Profit_m->save_profit($profit_data)) {

                if ($profit_id == -1) {
                    echo json_encode(array(
                        'success' => true,
                        'message' => 'thanh cong' . ' ' . $profit_data['formula_name'] . ' ' . $profit_data['name'],
                        'person_id' => $profit_data['id']));
                } else //previous item
                {
                    echo json_encode(array(
                        'success' => true,
                        'message' => 'thanh cong' . ' ' . $profit_data['formula_name'] . ' ' . $profit_data['name'],
                        'person_id' => $profit_id));
                }
            } else
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Khong them duoc du lieu',
                    $profit_data['formula_name'] . ' ' . $profit_data['name'],
                    'person_id' => -1));

        } else
            echo json_encode(array(
                'success' => false,
                'message' => 'Khong them duoc du lieu',
                $profit_data['formula_name'] . ' ' . $profit_data['name'],
                'person_id' => -1));
    }

    //dung cho cong thuc 2
    /*
    function save_2($profit_id=-1)
    {
    $this->check_action_permission('add_update');
    
    if($profit_id==-1)
    {
    echo json_encode(array('success'=>true,'message'=>'thanh cong 234'
    ,'person_id'=>$profit_data['id']));
    }
    else //previous item
    {
    echo json_encode(array('success'=>true,'message'=>'that bai 234','person_id'=>$profit_id));
    }
    }
    */

    function save_2($profit_id = -1)
    {
        $this->check_action_permission('add_update');
        $price = $this->input->post('itemss_number') * ($this->input->post('new_price') -
            ($this->input->post('input_price') + $this->input->post('employees_salary') + $this->
            input->post('input_transport') + (($this->input->post('input_tax') * $this->
            input->post('input_price')) / 100)));
        $demfields = $this->input->post('demfield');
        $tenfields = 'textbox';
        $txtbox = 'textbox2';
        $k = 1;
        $tong = 0;
        while ($k <= $demfields) {
            $tenfields1 = $tenfields . $k;
            $txtbox2 = $txtbox . $k;
            $tong = $tong + ($this->input->post($tenfields1)) * 1;
            $k++;
            $profit_other = array(
                'f_name' => $this->input->post('last_name'),
                'cost_name' => $this->input->post($txtbox2),
                'price2' => $this->input->post($tenfields1));

            $this->Profit_m->save_profit_other($profit_other);

        }
        $price = $price - $tong;
        $profit_data1 = array(
            'formula_name' => $this->input->post('last_name'),
            'name' => $this->input->post('first_name'),
            'fixed_costs' => $this->input->post('input_price'),
            'transport' => $this->input->post('input_transport'),
            'tax' => $this->input->post('input_tax'),
            'commission' => $price,
            'sum_salary' => $this->input->post('employees_salary'),
            'deleted' => 0,
            'staff_id' => $tong,
            'price' => $this->input->post('new_price'),
            'estimated_number' => $this->input->post('itemss_number'));

        $kiemtra = $this->input->post('last_name');
        if ($this->Profit_m->get_info_formula($kiemtra)) {

            if ($this->Profit_m->save_profit($profit_data1)) {

                if ($profit_id == -1) {
                    echo json_encode(array(
                        'success' => true,
                        'message' => 'thanh cong' . ' ' . $profit_data['formula_name'] . ' ' . $profit_data['name'],
                        'person_id' => $profit_data['id']));
                } else //previous item
                {
                    echo json_encode(array(
                        'success' => true,
                        'message' => 'thanh cong' . ' ' . $profit_data['formula_name'] . ' ' . $profit_data['name'],
                        'person_id' => $profit_id));
                }
            } else
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Khong them duoc du lieu ',
                    $profit_data['formula_name'] . ' ' . $profit_data['name'],
                    'person_id' => -1));

        } else
            echo json_encode(array(
                'success' => false,
                'message' => 'Khong them duoc du lieu',
                $profit_data['formula_name'] . ' ' . $profit_data['name'],
                'person_id' => -1));
    }
    function save_3($item_kit_id = -1)
    {
        $this->check_action_permission('add_update');
        /*$price = $this->input->post('input_price') + $this->input->post('input_transport') + (($this->
            input->post('input_tax') * $this->input->post('input_price')) / 100) + $this->
            input->post('advertising_costs') + $this->input->post('customer_care') + $this->
            input->post('commission');*/
		$input_price = str_replace( ',', '', $this->input->post('input_price'));
        $input_transport = str_replace( ',', '', $this->input->post('input_transport'));
        $advertising_costs = str_replace( ',', '', $this->input->post('advertising_costs'));
        $customer_care = str_replace( ',', '', $this->input->post('customer_care'));
        
        $price = $input_price + $input_transport + 
        	(($this->input->post('input_tax') * $input_price) / 100) 
        	+ $advertising_costs + $customer_care + $this->input->post('commission');
        
        $demtext = $this->input->post('textfield');
        $demtext1 = $this->input->post('textfield1');
        $product_name = $this->input->post('product_name');
        $demtext_empl = $this->input->post('empl_name');
        $demtext_empl1 = $this->input->post('day_hour');
        $demtext_empl2 = $this->input->post('geofeld');
        $demtext_empl3 = $this->input->post('day_hour_num');
        
        $k = 0;
        while ($k < count($demtext)) {
            $tenfields1 = $demtext1[$k];
            $txtbox2 = $demtext[$k];
            $tong = $tong + $tenfields1;
            $k++;
            $profit_other = array(
                'f_name' => $this->input->post('last_name'),
                'cost_name' => $txtbox2,
                'price2' => $tenfields1);
            $this->Profit_m->save_profit_other($profit_other);
        }
        //xu ly danh sach nhan vien
        $z = 0;
        while ($z < count($demtext_empl)) {
            $demtext_empl_l = $demtext_empl[$z];
            $demtext_empl_l1 = $demtext_empl1[$z];
            $demtext_empl_l2 = $demtext_empl2[$z];
            $demtext_empl_l3 = $demtext_empl3[$z];
            $tong = $tong + $demtext_empl_l2;
            $profit_empl = array(
                'f_name' => $this->input->post('last_name'),
                'name_empl' => $demtext_empl_l,
                'day_hour' => $demtext_empl_l1,
                'day_hour_number' => $demtext_empl_l3,
                'salary_empl' => $demtext_empl_l2);
            $this->Profit_m->save_profit_empl($profit_empl);
            $z++;
        }

        $price1 = $price + $tong;
        $price2 = $price1 * (($this->input->post('profit_price')) / 100 + 1);
        $profit_data = array(
            'formula_name' => $this->input->post('last_name'),
            'name' => $product_name,
            'fixed_costs' => str_replace( ',', '', $this->input->post('input_price') ),
            'transport' => str_replace( ',', '', $this->input->post('input_transport') ),
            'tax' => $this->input->post('input_tax'),
            'commission' => $this->input->post('commission'),
            'advertising_costs' => str_replace( ',', '', $this->input->post('advertising_costs') ),
            'customer_care' => str_replace( ',', '', $this->input->post('customer_care') ),
            'other_costs' => $this->input->post('profit_price'),
            'deleted' => 0,
            'staff_id' => $price1,
            'price' => $price2,
            'flag'=>1
            );

        $kiemtra = $this->input->post('last_name');

        if ($this->Profit_m->get_info_formula($kiemtra)) {
            if ($this->Profit_m->save_profit($profit_data)) {
                if ($profit_id == -3) {
                    echo json_encode(array(
                        'success' => true,
                        'message' => 'Thêm thành công công thức ' . ' ' . $profit_data['formula_name'] . ' ' . $profit_data['name'],
                        'person_id' => $profit_data['id']));
                } else //previous item
                {
                    echo json_encode(array(
                        'success' => true,
                        'message' => 'Thêm thành công công thức' . ' ' . $profit_data['formula_name'] . ' ' . $profit_data['name'],
                        'person_id' => $profit_id));
                }
            } else
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Không thêm được dữ liệu',
                    $profit_data['formula_name'] . ' ' . $profit_data['name'],
                    'person_id' => -1));
        } else
            echo json_encode(array(
                'success' => false,
                'message' => 'Bị lỗi trùng công thức ',
                $profit_data['formula_name'] . ' ' . $profit_data['name'],
                'person_id' => -1));
    }
    
    function save_4($item_kit_id = -1)
    {
        $this->check_action_permission('add_update');
        // $price=$this->input->post('input_price')+$this->input->post('employees_salary')+$this->input->post('input_transport')+(($this->input->post('input_tax')*$this->input->post('input_price'))/100)+$this->input->post('profit_price');
        //$price=$this->input->post('input_price')+$this->input->post('input_transport')+(($this->input->post('input_tax')*$this->input->post('input_price'))/100)+$this->input->post('profit_price');
        //$demfields=$this->input->post('demfield');
        $price = $this->input->post('input_price') + $this->input->post('input_transport') + (($this->
            input->post('input_tax') * $this->input->post('input_price')) / 100) + $this->
            input->post('advertising_costs') + $this->input->post('customer_care') + $this->
            input->post('commission');

        $demtext = $this->input->post('textfield');
        $demtext1 = $this->input->post('textfield1');
        $product_name = $this->input->post('product_name');
        $demtext_empl = $this->input->post('empl_name');
        $demtext_empl1 = $this->input->post('day_hour');
        $demtext_empl2 = $this->input->post('geofeld');
        $demtext_empl3 = $this->input->post('day_hour_num');
        /*
        echo $product_name;
        print_r($demtext_empl);
        echo count($demtext_empl1);
        */
        //print_r($demtext_empl1);
        $k = 0;
        while ($k < count($demtext)) {
            $tenfields1 = $demtext1[$k];
            $txtbox2 = $demtext[$k];
            $tong = $tong + $tenfields1;
            $k++;
            /*
            echo $this->input->post('last_name');
            echo $txtbox2;
            echo $tenfields1;
            
            echo "<br/>";
            */

            $profit_other = array(
                'f_name' => $this->input->post('last_name'),
                'cost_name' => $txtbox2,
                'price2' => $tenfields1);
            $this->Profit_m->save_profit_other($profit_other);
        }
        //xu ly danh sach nhan vien

        $z = 0;
        while ($z < count($demtext_empl)) {
            $demtext_empl_l = $demtext_empl[$z];
            $demtext_empl_l1 = $demtext_empl1[$z];
            $demtext_empl_l2 = $demtext_empl2[$z];
            $demtext_empl_l3 = $demtext_empl3[$z];
            $tong = $tong + $demtext_empl_l2;
            $profit_empl = array(
                'f_name' => $this->input->post('last_name'),
                'name_empl' => $demtext_empl_l,
                'day_hour' => $demtext_empl_l1,
                'day_hour_number' => $demtext_empl_l3,
                'salary_empl' => $demtext_empl_l2);
            $this->Profit_m->save_profit_empl($profit_empl);
            $z++;
        }

        $price1 = $price + $tong;
        //$price2 = $price1 * (($this->input->post('profit_price')) / 100 + 1);
        $price3=$this->input->post('sale_price');
        $price4=$price3-$price1;
        $profit_price=($price4/$price1)*100;//tinh ra dang %
        $profit_data = array(
            'formula_name' => $this->input->post('last_name'),
            'name' => $product_name,
            'fixed_costs' => $this->input->post('input_price'),
            'transport' => $this->input->post('input_transport'),
            'tax' => $this->input->post('input_tax'),
            'commission' => $this->input->post('commission'),
            'advertising_costs' => $this->input->post('advertising_costs'),
            'customer_care' => $this->input->post('customer_care'),
            'other_costs' => $profit_price,
            'expected_profit'=>$price4,
            'deleted' => 0,
            'staff_id' => $price1,
            'price' => $price3,
            'flag'=>2
            );

        $kiemtra = $this->input->post('last_name');

        if ($this->Profit_m->get_info_formula($kiemtra)) {
            if ($this->Profit_m->save_profit($profit_data)) {
                if ($profit_id == -4) {
                    echo json_encode(array(
                        'success' => true,
                        'message' => 'Thêm thành công' . ' ' . $profit_data['formula_name'] . ' ' . $profit_data['name'],
                        'person_id' => $profit_data['id']));
                } else //previous item
                {
                    echo json_encode(array(
                        'success' => true,
                        'message' => 'Thêm thành công' . ' ' . $profit_data['formula_name'] . ' ' . $profit_data['name'],
                        'person_id' => $profit_id));
                }
            } else
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Không thêm được dữ liệu !',
                    $profit_data['formula_name'] . ' ' . $profit_data['name'],
                    'person_id' => -1));
        } else
            echo json_encode(array(
                'success' => false,
                'message' => 'Bị lỗi trùng công thức,không thêm được ',
                $profit_data['formula_name'] . ' ' . $profit_data['name'],
                'person_id' => -1));

    }

    function update_1($update_id=1)
    {
         $this->check_action_permission('add_update');
         /*
         $price = $this->input->post('input_price') + $this->input->post('input_transport') + (($this->
            input->post('input_tax') * $this->input->post('input_price')) / 100) + $this->
            input->post('advertising_costs') + $this->input->post('customer_care') + $this->
            input->post('commission');
         */

        $demtext = $this->input->post('textfield');
        $demtext1 = $this->input->post('textfield1');
        $product_name = $this->input->post('product_name');
        $demtext_empl = $this->input->post('empl_name');
        $demtext_empl1 = $this->input->post('day_hour');
        $demtext_empl2 = $this->input->post('geofeld');
        $demtext_empl3 = $this->input->post('day_hour_num');
        $delete= $this->input->post('last_name');//lay ten cong thuc de xoa
        
        $this->Profit_m->delete_profit_other($delete);
        $this->Profit_m->delete_profit_empl($delete);
        
        /*
        echo $product_name;
        print_r($demtext_empl);
        echo count($demtext_empl1);
        */
        //print_r($demtext_empl1);
        $k = 0;
        while ($k < count($demtext)) {
            $tenfields1 = $demtext1[$k];
            $txtbox2 = $demtext[$k];
            $tong = $tong + $tenfields1;
            $k++;
            /*
            echo $this->input->post('last_name');
            echo $txtbox2;
            echo $tenfields1;
            echo "<br/>";
            */

            $profit_other = array(
                'f_name' => $this->input->post('last_name'),
                'cost_name' => $txtbox2,
                'price2' => $tenfields1);
            $this->Profit_m->save_profit_other($profit_other);
        }
        //xu ly danh sach nhan vien

        $z = 0;
        while ($z < count($demtext_empl)) {
            $demtext_empl_l = $demtext_empl[$z];
            $demtext_empl_l1 = $demtext_empl1[$z];
            $demtext_empl_l2 = $demtext_empl2[$z];
            $demtext_empl_l3 = $demtext_empl3[$z];
            $tong = $tong + $demtext_empl_l2;
            $profit_empl = array(
                'f_name' => $this->input->post('last_name'),
                'name_empl' => $demtext_empl_l,
                'day_hour' => $demtext_empl_l1,
                'day_hour_number' => $demtext_empl_l3,
                'salary_empl' => $demtext_empl_l2);
            $this->Profit_m->save_profit_empl($profit_empl);
            $z++;
        }
         /*
        $price1 = $price + $tong;
        $price2 = $price1 * (($this->input->post('profit_price')) / 100 + 1);
        */
        $profit_data = array(
            'formula_name' => $this->input->post('last_name'),
            'name' => $product_name,
            'fixed_costs' => str_replace( ',', '', $this->input->post('input_price') ),
        	'transport' => str_replace( ',', '', $this->input->post('input_transport') ),
            'tax' => $this->input->post('input_tax'),
            'commission' => $this->input->post('commission'),
        	'advertising_costs' => str_replace( ',', '', $this->input->post('advertising_costs') ),
        	'customer_care' => str_replace( ',', '', $this->input->post('customer_care') ),
            'other_costs' => $this->input->post('profit_price'),
            'deleted' => 0,
            'staff_id' =>$this->input->post('chi_phi'),
            'price' => str_replace( ',', '', $this->input->post('result'))
        );
            
        //$kiemtra = $this->input->post('last_name');

      
            if ($this->Profit_m->update1_profit($update_id,$profit_data)){
               
                    echo json_encode(array(
                        'success' => true,
                        'message' => $profit_data['formula_name'] . ' ' . $profit_data['name'].' Update Thành công ',
                        'person_id' => $profit_data['id']));
                
            } else
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Update bị lỗi',
                    $profit_data['formula_name'] . ' ' . $profit_data['name'],
                    'person_id' => -1)); 
	
    }
    function detail_profit112($id)
    {
        //dung cho hien thi chi tiet
        $data['profit_info'] = $this->Profit_m->get_info($id);
        $data['staff_info'] = $this->Employee->get_name_salary(); //ten va luong nhan vien
        //print_r($data['staff_info']);
        $data['staff_count'] = $this->Employee->count_all_salary(); //so nhan vien
        //print_r($data['staff_count']);
        $data['profit_info1'] = $this->Profit_m->get_info_other($id);
        //print_r($data['profit_info1']);
        $this->load->view('profit/detail_profit', $data);
    }

    function detail_profit($id)
    {
        //dung cho hien thi chi tiet
        $data['profit_info'] = $this->Profit_m->get_info($id);
        $data['staff_info']  = $this->Employee->get_name_salary(); //ten va luong nhan vien
        $data['staff_count'] = $this->Employee->count_all_salary(); //so nhan vien
        //print_r($data['staff_count']);
        $data['profit_info1'] = $this->Profit_m->get_info_other($id);
        $data['profit_info2'] = $this->Profit_m->get_info_empl($id);
        $this->load->view('profit/detail_profit11', $data);
    }

    function get_row()
    {
        $item_id1 = $this->input->post('row_id'); //lay tu js
        $data_row = get_profit_data_row($this->Profit_m->get_info($item_id1), $this);
        echo $data_row;
    }

    /*
    This deletes formular from the profit table
    */
    function delete()
    {
        $this->check_action_permission('delete');
        $customers_to_delete = $this->input->post('ids');

        if ($this->Profit_m->delete_list($customers_to_delete)) {
            echo json_encode(array('success' => true, 'message' => lang('profit_successful_deleted') .
                    ' ' . count($customers_to_delete) . ' ' . lang('profit_one_or_multiple')));
        } else {
            echo json_encode(array('success' => false, 'message' => lang('customers_cannot_be_deleted')));
        }
    }

    /*
    get the width for the add/edit form
    */
    function get_form_width()
    {
        return 880;
    }
	
}

?>