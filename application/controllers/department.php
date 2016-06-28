<?php
require_once ("person_controller.php");
class Department extends Person_controller
{
    function __construct()
    {
        parent::__construct();
        $this->_item = $this->session->userdata('person_id');
        $this->_controller = strtolower(get_class());
    }


    /*
     * Show information of the table status
     * */
    function index()
    {
    	if($this->_item != 1){ 
    		if( $this->Employee->get_regions_id($this->_item)->num_rows() > 0){
    			$jobs_regions_id= $this->Employee->get_regions_id($this->_item)->row()->jobs_regions_id;
    			$jobs_affiliates_id= $this->Jobs_department->get_dep($jobs_regions_id);
    			
    		}elseif( $this->Employee->get_city_id($this->_item)->num_rows() > 0){
    			$jobs_city_id= $this->Employee->get_city_id($this->_item)->row()->jobs_city_id;
    			$jobs_affiliates_id= $this->Jobs_department->get_dep2($jobs_city_id);
    			
    		}elseif( $this->Employee->get_affiliates_id($this->_item)->num_rows() > 0){ 
    			$jobs_affiliates_id= $this->Employee->get_affiliates_id($this->_item)->row()->jobs_affiliates_id;
    		}
    	}
        $this->check_action_permission('search');
        $config['base_url'] = site_url($this->_controller.'/sorting');
        $config['total_rows'] = $this->Jobs_department->count_all($jobs_affiliates_id,$this->_item);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name']= strtolower(get_class());
        $data['form_width']= $this->get_form_width();
        $data['form_width_module']= $this->get_form_module_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_department_table($this->Jobs_department->get_all($jobs_affiliates_id,$this->_item,$data['per_page']),$this);

        $this->load->view('jobs/'.$this->_controller.'/index',$data);
    }


    /* module status */
    function view($id = -1)
    {
        $this->check_action_permission('add_update');
        $data['jobs_department']= $this->Jobs_department->get_row($id);
        $data['name_peron_info']= $this->Jobs_department->get_person_info();
        $data['city_info']= $this->Jobs_department->get_city_action();
        $data['city_regions']= $this->Jobs_department->getCityAffiliates($id);
        $data['affiliates_info']= $this->Jobs_department->get_affiliates_name();
        $data['regions_info']= $this->Jobs_department->get_regions_info();

        $this->load->view("jobs/".$this->_controller."/form",$data);
    }
    function loadCity($id = -1)
    {
        $regions_id = $this->input->post('jobs_regions_id');
        $data['jobs_department']= $this->Jobs_department->get_row($id);
        $data['city_info']= $this->Jobs_department->get_city_action($regions_id);
        $items = array();
        foreach( $data['city_info'] AS $key => $values){
            $items[] = $values->jobs_city_id;
        }
        $data['affiliates_parent']= $this->Jobs_department->get_department_parent($id,$items);

        //echo  $regions_id;
        $this->load->view("jobs/".$this->_controller."/form_select",$data);
    }
    function loadAffiliates($id = -1)
    {
        $city_id = $this->input->post('jobs_city_id');
        $data['jobs_department']= $this->Jobs_department->get_row($id);
        $data['affiliates_parent']= $this->Jobs_department->get_department_parent($id,$city_id);

        $this->load->view("jobs/".$this->_controller."/form_select_affiliates",$data);
    }

    function sorting()
    {
    	if($this->_item != 1){ 
    		if( $this->Employee->get_regions_id($this->_item)->num_rows() > 0){
    			$jobs_regions_id= $this->Employee->get_regions_id($this->_item)->row()->jobs_regions_id;
    			$jobs_affiliates_id= $this->Jobs_department->get_dep($jobs_regions_id);
    			
    		}elseif( $this->Employee->get_city_id($this->_item)->num_rows() > 0){
    			$jobs_city_id= $this->Employee->get_city_id($this->_item)->row()->jobs_city_id;
    			$jobs_affiliates_id= $this->Jobs_department->get_dep2($jobs_city_id);
    			
    		}elseif( $this->Employee->get_affiliates_id($this->_item)->num_rows() > 0){ 
    			$jobs_affiliates_id= $this->Employee->get_affiliates_id($this->_item)->row()->jobs_affiliates_id;
    		}
    	}
        $this->check_action_permission('search');
        $search=$this->input->post('search');
        $per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        if ($search)
        {
            $config['total_rows'] = $this->Jobs_department->search_count_all($jobs_affiliates_id, $this->_item, $search);
            $table_data = $this->Jobs_department->search($jobs_affiliates_id, $this->_item,$search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'department_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'ASC');
        }
        else
        {
            $config['total_rows'] = $this->Jobs_department->count_all($jobs_affiliates_id, $this->_item);
            $table_data = $this->Jobs_department->get_all($jobs_affiliates_id, $this->_item,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'department_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'ASC');
        }
        $config['base_url'] = site_url( $this->_controller.'/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table']= get_department_manage_table_data_rows($table_data,$this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }
    /**/

    function search()
    {
    	if($this->_item != 1){ 
    		if( $this->Employee->get_regions_id($this->_item)->num_rows() > 0){
    			$jobs_regions_id= $this->Employee->get_regions_id($this->_item)->row()->jobs_regions_id;
    			$jobs_affiliates_id= $this->Jobs_department->get_dep($jobs_regions_id);
    			
    		}elseif( $this->Employee->get_city_id($this->_item)->num_rows() > 0){
    			$jobs_city_id= $this->Employee->get_city_id($this->_item)->row()->jobs_city_id;
    			$jobs_affiliates_id= $this->Jobs_department->get_dep2($jobs_city_id);
    			
    		}elseif( $this->Employee->get_affiliates_id($this->_item)->num_rows() > 0){ 
    			$jobs_affiliates_id= $this->Employee->get_affiliates_id($this->_item)->row()->jobs_affiliates_id;
    		}
    	}
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $search_data=$this->Jobs_department->search($jobs_affiliates_id, $this->_item, $search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'department_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'DESC');
        $config['base_url'] = site_url($this->_controller.'/search');
        $config['total_rows'] = $this->Jobs_department->search_count_all($jobs_affiliates_id, $this->_item, $search);
        $config['per_page'] = $per_page ;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table']= get_department_manage_table_data_rows($search_data,$this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));

    }


    function suggest()
    {
    	if($this->_item != 1){ 
    		if( $this->Employee->get_regions_id($this->_item)->num_rows() > 0){
    			$jobs_regions_id= $this->Employee->get_regions_id($this->_item)->row()->jobs_regions_id;
    			$jobs_affiliates_id= $this->Jobs_department->get_dep($jobs_regions_id);
    			
    		}elseif( $this->Employee->get_city_id($this->_item)->num_rows() > 0){
    			$jobs_city_id= $this->Employee->get_city_id($this->_item)->row()->jobs_city_id;
    			$jobs_affiliates_id= $this->Jobs_department->get_dep2($jobs_city_id);
    			
    		}elseif( $this->Employee->get_affiliates_id($this->_item)->num_rows() > 0){ 
    			$jobs_affiliates_id= $this->Employee->get_affiliates_id($this->_item)->row()->jobs_affiliates_id;
    		}
    	}
        $suggestions = $this->Jobs_department->get_search_suggestions($jobs_affiliates_id,$this->_item,$this->input->get('term'),100);
        echo json_encode($suggestions);
    }


    public function save($id = -1)
    {
        $jobs_data = array(
            'department_name' => $this->input->post('department_name'),
            'department_place' => $this->input->post('department_place') == '' ? '' : $this->input->post('department_place'),
            'department_date' => date('Y-m-d',strtotime($this->input->post('department_date'))) == '' ? date('Y-m-d') : date('Y-m-d',strtotime($this->input->post('department_date'))),
            'jobs_affiliates_id' => $this->input->post('jobs_parent_id'),
            'person_id' => $this->input->post('person_id'),
            'department_status' => $this->input->post('department_status') == '' ? 0 : $this->input->post('department_status') ,
            'department_color' => $this->input->post('department_color') == '' ? "#000" : $this->input->post('department_color'),
        );

        if($this->Jobs_department->checkDepartmentName($jobs_data['department_name'],$id) > 0){
            echo json_encode(array('message'=>lang($this->_controller.'_message_error').$jobs_data['department_name'] .' ) đã được sử dụng'));
        }else{
            if(empty($jobs_data['person_id'])){
                echo json_encode(array('message'=>'Bạn có thể sử dụng tên phòng ban này !'));
            }else{
                if($this->Jobs_department->save($jobs_data, $id)){
                    echo json_encode(array('success'=>true,'message'=>lang($this->_controller.'_successful_adding').' ('.$jobs_data['department_name'].') !'));
                }else{
                    echo json_encode(array('success'=>false,'message'=>'Chú ý : Người Quản lý chi nhánh chỉ được phép làm Quản lý phòng ban trực thuộc chi nhánh họ đang quản lý !'));
                }
            }
        }
    }

    function delete()
    {
        $this->check_action_permission('delete');
        $id = $this->input->post('ids');

        if($this->Jobs_department->delete_list($id))
        {
            echo json_encode(array('success'=>true,'message'=>lang($this->_controller.'_successful_deleted').'  '.
                count($id).' '.lang($this->_controller.'_one_or_multiple')));
        }else{
            echo json_encode(array('success'=>false,'message'=>lang($this->_controller.'_cannot_be_deleted')));
        }
    }
    /*
    lang('common_affiliates_manager'),
   /*
   get the width for the add/edit form
   */
    function get_form_width()
    {
        return 800; 
    }
    function get_form_module_width()
    {
        return 410;
    }

    function get_affiliates()
    {
        return $this->Jobs_department->get_affiliates();
    }
    function get_city($id)
    {
        return $this->Jobs_department->get_city_info($id);
    }
    function get_manager_info()
    {
        return $this->Jobs_affiliates->get_person_info();
    }

}
