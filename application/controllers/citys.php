<?php
require_once ("person_controller.php");
class Citys extends Person_controller
{

    function __construct()
    {
        parent::__construct();
        $this->_item = $this->session->userdata('person_id');
        $this->_controller = 'citys';        
    }


    /*
     * Show information of the table status
     * */
    function index()
    {
    	$jobs_regions_id= $this->Jobs_regions->get_region_id($this->_item)->row()->jobs_regions_id;
    	$data['jobs_regions_name']= $this->Jobs_regions->get_region_id($this->_item)->row()->jobs_regions_name;
    	
        $this->check_action_permission('search');
        $config['base_url'] = site_url($this->_controller.'/sorting');
        $config['total_rows'] = $this->Jobs_city->count_all($jobs_regions_id, $this->_item);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name']= strtolower(get_class());
        $data['form_width']= $this->get_form_width();
        $data['form_width_module']= $this->get_form_module_width();
        $data['per_page'] = $config['per_page'];//die($this->_item);
        $data['manage_table'] = get_city_table($this->Jobs_city->get_all($jobs_regions_id, $this->_item,$data['per_page']),$this);
		
        $this->load->view('jobs/'.$this->_controller.'/index',$data);

    }
    function checkUpdate()
    {
       return $this->Jobs_city->checkUpdate($this->_item,'city');
    }

    /* module status */
    function view($city_id = -1)
    {
        $this->check_action_permission('add_update');

        $data['city_info']= $this->Jobs_city->getAllCity();
        $data['jobs_city']= $this->Jobs_city->get_city($city_id);
        $data['name_peron_info']= $this->Jobs_city->get_person_info();
        $data['regions_info']= $this->Jobs_city->get_regions_info();

        $this->load->view("jobs/".$this->_controller."/form",$data);
    }

    function sorting()
    {
    	$jobs_regions_id= $this->Jobs_regions->get_region_id($this->_item)->row()->jobs_regions_id;
        $this->check_action_permission('search');
        $search=$this->input->post('search');
        $per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        if ($search)
        {
            $config['total_rows'] = $this->Jobs_city->search_count_all($search);
            $table_data = $this->Jobs_city->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_city_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'ASC');
        }
        else
        {
            $config['total_rows'] = $this->Jobs_city->count_all($this->_item);
            $table_data = $this->Jobs_city->get_all($this->_item,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_city_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'ASC');
        }
        $config['base_url'] = site_url( $this->_controller.'/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table']= get_city_manage_table_data_rows($table_data,$this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }
    /**/

    function search()
    {
    	$jobs_regions_id= $this->Jobs_regions->get_region_id($this->_item)->row()->jobs_regions_id;
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $search_data=$this->Jobs_city->search($jobs_regions_id, $this->_item, $search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_city_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'DESC');
        $config['base_url'] = site_url($this->_controller.'/search');
        $config['total_rows'] = $this->Jobs_city->search_count_all($jobs_regions_id, $this->_item, $search);
        $config['per_page'] = $per_page ;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table']= get_city_manage_table_data_rows($search_data,$this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));

    }


    function suggest()
    {
    	$jobs_regions_id= $this->Jobs_regions->get_region_id($this->_item)->row()->jobs_regions_id;
        $suggestions = $this->Jobs_city->get_search_suggestions($jobs_regions_id, $this->_item, $this->input->get('term'),100);
        echo json_encode($suggestions);
    }

    public function save($city_id = -1)
    {
        $jobs_data = array(
            'jobs_city_name' => $this->input->post('jobs_city_name'),
            'jobs_city_description' => $this->input->post('jobs_city_description') == '' ? '' : $this->input->post('jobs_city_description'),
            'jobs_city_date' => date('Y-m-d',strtotime($this->input->post('jobs_city_date'))) == '' ? date('Y-m-d') : date('Y-m-d',strtotime($this->input->post('jobs_city_date'))),
            'person_id' => $this->input->post('person_id'),
            'jobs_regions_id' => $this->input->post('jobs_regions_id'),
            'jobs_city_status' => $this->input->post('jobs_city_status') == '' ? 0 : $this->input->post('jobs_city_status') ,
            'jobs_city_color' => $this->input->post('jobs_city_color') == '' ? "#000" : $this->input->post('jobs_city_color'),
        );

        if($this->Jobs_city->checkRegionsName($jobs_data['jobs_city_name'],$city_id) > 0){
            echo json_encode(array(('message')=>lang($this->_controller.'_message_error').$jobs_data['jobs_city_name'] .' ) đã được sử dụng !'));
        }else{
            if(empty($jobs_data['person_id'])){
                echo json_encode(array(('message')=>'Bạn có thể sử dụng tên thành phố này !'));
            }else{
                if($id_name = $this->Jobs_city->save($jobs_data, $city_id ) > 0){
                    echo json_encode(array('success'=>true,'message'=>lang($this->_controller.'_successful_adding').' '.$jobs_data['jobs_city_name'].') !'));
                }else{
                   /* if($jobs_data['jobs_city_name']){*/
                      /* echo json_encode(array('success'=>true,'message'=>lang($this->_controller.'_message_success').$jobs_data['jobs_city_name'] .' ) này !'));*/
                   echo json_encode(array('success'=>false,'message'=>'Bạn hãy xem lại thông tin đã thiết lập ( Chú ý: Nhân viên không được quản lý 2 thành phố thuộc 2 khu vực khác nhau nếu có các thành phố này phải thuộc các khu vực này phải có duy nhất 1 người quản lý !)'));
                   /* }else{

                    }*/
                }
            }
        }

    }


    function delete()
    {
        $this->check_action_permission('delete');
        $regions_id = $this->input->post('ids');
		//die('ff');
        if($this->Jobs_city->delete_list($regions_id))
        {
            echo json_encode(array('success'=>true,'message'=>lang($this->_controller.'_successful_deleted').'  '.
                count($regions_id).' '.lang($this->_controller.'_one_or_multiple')));
        }else{
            echo json_encode(array('success'=>false,'message'=>lang($this->_controller.'_cannot_be_deleted')));
        }
    }
    /*

   /*
   get the width for the add/edit form
   */
    function get_form_width()
    {
        return 800;
    }
    function get_form_module_width()
    {
        return 400;
    }

    function get_manager_info()
    {
        return $this->Jobs_city->get_person_info();
    }
    function get_regions()
    {
        return $this->Jobs_city->get_regions_info();
    } 
}
