<?php
require_once ("secure_area.php");
class Assets extends secure_area {
    public $model_name = "Asset";
    public function __construct() {
        parent::__construct();
        $this->load->helper('report');
    }
    function index() {
        $config['base_url'] = site_url('assets/sorting');
        $config['total_rows'] = $this->Asset->count_all();
        $data['result_array'] = $this->Asset->get_all($data['per_page']);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 10;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_asset_manage_table($this->Asset->get_all($data['per_page']), $this);
        $this->load->view('assets/manage', $data);
    }
    function sorting() {
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        if ($search) {
            $config['total_rows'] = $this->Asset->search_count_all($search);
            $table_data = $this->Asset->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        } else {
            $config['total_rows'] = $this->Asset->count_all();
            $table_data = $this->Asset->get_all($per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        }
        $config['base_url'] = site_url('assets/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_asset_manage_table_data_rows($table_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }
    function search() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $search_data = $this->Asset->search($search, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'asc');
        $config['base_url'] = site_url('assets/search');
        $config['total_rows'] = $this->Asset->search_count_all($search);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_asset_manage_table_data_rows($search_data, $this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }
    function view($var_id = -1) {
        $model = $this->model_name;
        $list_group_type = array('' => 'Chọn loại tài sản');
        foreach ($this->$model->get_list_group_type()->result_array() as $list_type) {
            $list_group_type[$list_type['id']] = $list_type['name'];
        }
        $data['list_group_type'] = $list_group_type;
        $list_ppkh_type = array('' => 'Chọn phương pháp khấu hao');
        foreach ($this->$model->get_list_ppkh_type()->result_array() as $list_type) {
            $list_ppkh_type[$list_type['id']] = $list_type['name'];
        }
        $data['list_ppkh_type'] = $list_ppkh_type;
        $data['var_info'] = $this->$model->get_info($var_id);

        $this->load->view("assets/form", $data);
    }
    function update_value_asset() {
        $model = $this->model_name;
        $assets = $this->$model->get_all_info();
        if ($assets != null) {
            foreach ($assets as $asset) {
                $year = date('Y') - date('Y', strtotime($asset['date_kh']));
                $month = date('m', strtotime($asset['date_kh']));
                $ky = $year * 12 + date('m') - $month;
                $value_remain = $asset['value'] - $ky * ($asset['value'] / $asset['ky_khauhao']);
                $this->$model->update_value_asset($asset['id'], $value_remain);
            }
        }
        redirect('assets');
    }
    function save($var_id = -1) {
        $model = $this->model_name;
        $ky_khauhao = $this->input->post('ky_khauhao');
        $date_kh = $this->input->post('date_kh');
        $var_data = array(
            'asset_number' => $this->input->post('assets_number'),
            'name' => $this->input->post('assets_name'),
            'value' => $this->input->post('value'),
            'value_remain' => $this->input->post('value_remain'),
//            'quantity' => $this->input->post('quantity'),
            'id_parent' => $this->input->post('group'),
            'lydotang' => $this->input->post('description'),
            'date_tang' => format_date($this->input->post('date_tang')),
            'date_kh' => format_date($date_kh),
            'ky_khauhao' => $ky_khauhao,
            'han_khauhao'=> date("Y-m-d H:i:s", strtotime("+$ky_khauhao month", strtotime( $date_kh ) ) ),
            'ppkh' => $this->input->post('ppkh'),
//            'tktk' => $this->input->post('tktk'),
            'tkkh' => $this->input->post('tkkh'),
            'tkcp' => $this->input->post('tkcp'),
//            'id_tstb' => $this->input->post('tbts_nhom'),
//            'id_bpsd' => $this->input->post('bpsd_name')
        );
        if ($this->$model->save($var_data, $var_id)) {
            if ($var_id == -1) {
                echo json_encode(array('success' => true, 'message' => lang('common_successful_adding') . ' ' .
                    $var_data['name'], 'id' => $var_data['id']));
                $var_id = $var_data['id'];
            } else { //previous giftcard
                echo json_encode(array('success' => true, 'message' => lang('common_successful_updating') . ' ' .
                    $var_data['name'], 'id' => $var_id));
            }
        } else {//failure
            echo json_encode(array('success' => false, 'message' => lang('common_error_adding_updating') . ' ' .
                $customertype_data['name'], 'id' => -1));
        }
    }
    function get_row() {
        $item_id = $this->input->post('row_id');
        $data_row = get_item_data_row($this->Item->get_info($item_id), $this);
        echo $data_row;
    }
    function delete() {
        $model = $this->model_name;
        $id = $this->input->post('ids');
        if ($this->$model->delete_list($id)) {
            echo json_encode(array('success' => true, 'message' => lang('giftcards_successful_deleted')));
        } else {
            echo json_encode(array('success' => false, 'message' => lang('giftcards_cannot_be_deleted')));
            echo 'that bai';
        }
    }
    function suggest() {

        $suggestions = $this->Asset->get_search_suggestions($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }
    function tkdu_search() {
        $model = $this->model_name;
        $suggestions = $this->$model->get_tkdu_search($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }
    function get_form_width() {
        return 550;
    }
    //Hưng Audi lovely OOOO 15-9-15
    function view_buy_increase() {
        $this->load->view("assets/form_buy_increase");
    }
    function save_buy_increase() {
        $asset_id = $this->input->post('asset_id');
        $cost_employees = $this->input->post('cost_employees');
        
        //save costs part 1
        $date = date('Y-m-d', strtotime($this->input->post('date')));
        $costs_data = array(
            'money' => $this->input->post('price') * $this->input->post('quantity'),
            'tk_no' => $this->input->post('tk_no'),
            'tk_co' => $this->input->post('tk_co'),
            'date' => $this->input->post('date') ? $date : date("Y-m-d H:i:s"),
            'cost_date_ct' => date('Y-m-d'),
            'cost_employees' => $cost_employees ? $cost_employees : 1,
            'asset_id' => $asset_id
        );
        $this->Cost->save($costs_data, -1);
            
        //save costs part 2
        $depreciat_month = $this->input->post('depreciat_month');
        $love = 0;
        for($i=1; $i <= $depreciat_month; $i++){
            $costs_data = array(
                'money' => $this->input->post('price') * $this->input->post('quantity') / $depreciat_month,
                'tk_no' => 627,
                'tk_co' => 214,
                'date' => date("Y-m-d H:i:s", strtotime("+$love month")),
                'cost_date_ct' => date('Y-m-d'),
                'cost_employees' => $cost_employees ? $cost_employees : 1,
                'asset_id' => $asset_id
            );
            $love ++;
            $this->Cost->save($costs_data, -1);
        }
        
        //save assets
        $info_assets = $this->Asset->get_info($asset_id);
        $assets_data = array(
            'quantity' => $info_assets->quantity + $this->input->post('quantity')
        );
        if ($this->Asset->save($assets_data, $asset_id)) {
            redirect('assets');
//            echo json_encode(array(
//                'success' => true, 
//                'message' => 'Ghi tăng/ mua tài sản thành công !'
//            ));
        }
        
    }    
    function view_decrease() {
        $this->load->view("assets/form_decrease");
    }
    function save_decrease() {
        $asset_id = $this->input->post('asset_id');
        $thoi_han = $this->input->post('thoi_han');
        $date_post = $this->input->post('date');
        $date = date('Y-m-d', strtotime($date_post));
        
        //save assets
        $info_assets = $this->Asset->get_info($asset_id);
        $assets_data = array(
            'quantity' => $info_assets->quantity - $this->input->post('quantity')
        );
        $this->Asset->save($assets_data, $asset_id);
        if($thoi_han == 1){//chua het thoi han
            //save costs part 1
            //save costs row 1
            $costs_data1 = array(
                'money' => $this->input->post('asset_money1'),
                'tk_no' => $this->input->post('tk_no1'),
                'tk_co' => $this->input->post('tk_co1'),
                'date' => $date_post ? $date : date("Y-m-d H:i:s"),
                'cost_date_ct' => date('Y-m-d'),
                'cost_employees' => 1,
                'asset_id' => $asset_id
            );
            $this->Cost->save($costs_data1, -1);
            
            //save costs row 2
            $costs_data2 = array(
                'money' => $this->input->post('asset_money2'),
                'tk_no' => $this->input->post('tk_no2'),
                'tk_co' => $this->input->post('tk_co2'),
                'date' => $date_post ? $date : date("Y-m-d H:i:s"),
                'cost_date_ct' => date('Y-m-d'),
                'cost_employees' => 1,
                'asset_id' => $asset_id
            );
            $this->Cost->save($costs_data2, -1);
            
            //save costs part 2
            $date_now = date('Y-m-d');
            $date_max = $this->Cost->get_info_max($asset_id)->date;
            $ts1 = strtotime($date_now);
            $ts2 = strtotime($date_max);
            $year1 = date('Y', $ts1);
            $year2 = date('Y', $ts2);
            $month1 = date('m', $ts1);
            $month2 = date('m', $ts2);
            $depreciat_month_decrease = (($year2 - $year1) * 12) + ($month2 - $month1);
            //print_r($depreciat_month_decrease);die();
            $love = 1;
            for($i=1; $i <= $depreciat_month_decrease; $i++){
                $costs_data = array(
                    'money' => 0,
                    'tk_no' => 214,
                    'tk_co' => 627,
                    'date' => $date_post ? date("Y-m-d H:i:s", strtotime("+$love month", strtotime( $date_post ) ) ) : date("Y-m-d H:i:s"),
                    'cost_date_ct' => date('Y-m-d'),
                    'cost_employees' => 1,
                    'asset_id' => $asset_id
                );
                $love ++;
                $this->Cost->save($costs_data, -1);
            }
        }
        redirect('assets');
//            echo json_encode(array(
//                'success' => true, 
//                'message' => 'Ghi tăng/ mua tài sản thành công !'
//            ));
        
    }
    //Hưng Audi 0000 Oct 31
    // hello Halloween (^_^) 
    function allocate($var_id){
		$model = $this->model_name;
		$data['var_info']= $this->$model->get_info($var_id);
		$this->load->view("assets/allocate",$data);
	}
    function save_allocate($var_id){
		$model = $this->model_name;
		$var_data=array(
            'allocate'=> $this->input->post('allocate')
		);
		if( $this->$model->save_allocate($var_data,$var_id)){
            echo json_encode(
                array(
                    'success'=>true,
                    'message'=> 'Ngừng phân bổ thành công !',
                )
            );
		}else{
			echo json_encode(
                array(
                    'success'=>false,
                    'message'=>lang('giftcards_error_adding_updating').' '.$customertype_data['name']
                )
            );
		}
	}
    function calculate_allocate(){
		$model = $this->model_name;
        $data['months'] = get_months();
        $data['years'] = get_years();
        $data['selected_month'] = date('m');
        $data['selected_year'] = date('Y');
		$this->load->view("assets/calculate_allocate",$data);
	}
    function get_assets_halloween() {
        $halloween_month = $this->input->post("halloween_month");
        $halloween_year = $this->input->post("halloween_year");
        $halloween_time = "$halloween_year-$halloween_month";
        $data = $this->Asset->get_assets_halloween($halloween_time);
        echo json_encode($data);
    }    
    
}

?>