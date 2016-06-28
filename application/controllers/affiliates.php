<?php
require_once ("person_controller.php");
class Affiliates extends Person_controller
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
 	    		$jobs_city_id= $this->Jobs_affiliates->get_aff3($jobs_regions_id);
    		
    		}elseif($this->Employee->get_city_id($this->_item)->num_rows() > 0){
    			$jobs_city_id= $this->Employee->get_city_id($this->_item)->row()->jobs_city_id;
    		}
    	} 
        $this->check_action_permission('search');
        $config['base_url'] = site_url($this->_controller.'/sorting');
        $config['total_rows'] = $this->Jobs_affiliates->count_all($jobs_city_id, $this->_item);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name']= strtolower(get_class());
        $data['form_width']= $this->get_form_width();
        $data['form_width_module']= $this->get_form_module_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_affiliates_table($this->Jobs_affiliates->get_all($jobs_city_id, $this->_item,$data['per_page']),$this);

        $this->load->view('jobs/'.$this->_controller.'/index',$data);
    }

    /* module status */
    function view($id = -1)
    {
        $regions_id = '';
        $city_id = '';
        $this->check_action_permission('add_update');
        $data['jobs_affiliates']= $this->Jobs_affiliates->get_row($id);
        $data['name_peron_info']= $this->Jobs_affiliates->get_person_info();
        $data['city_info']= $this->Jobs_affiliates->get_city_action($regions_id);
        $data['city_regions']= $this->Jobs_affiliates->getCityAffiliates($id);
        $data['affiliates_parent']= $this->Jobs_affiliates->get_affiliates_parent($id,$city_id);
        $data['regions_info']= $this->Jobs_affiliates->get_regions_info();

        $this->load->view("jobs/".$this->_controller."/form",$data);
    }
    function loadCity($id = -1)
    {
        $regions_id = $this->input->post('jobs_regions_id');
        $data['jobs_affiliates']= $this->Jobs_affiliates->get_row($id);
        $data['city_info']= $this->Jobs_affiliates->get_city_action($regions_id);
        $items = array();
        foreach( $data['city_info'] AS $key => $values){
            $items[] = $values->jobs_city_id;
        }
        $data['affiliates_parent']= $this->Jobs_affiliates->get_affiliates_parent($id,$items);


        $this->load->view("jobs/".$this->_controller."/form_select",$data);
    }
    function loadAffiliates($id = -1)
    {
        $city_id = $this->input->post('jobs_city_id');
        $data['jobs_affiliates']= $this->Jobs_affiliates->get_row($id);
        $data['affiliates_parent']= $this->Jobs_affiliates->get_affiliates_parent($id,$city_id);

        $this->load->view("jobs/".$this->_controller."/form_select_affiliates",$data);
    }

    function sorting()
    {	
    	if($this->_item != 1){
    		if( $this->Employee->get_regions_id($this->_item)->num_rows() > 0){
		    	$jobs_regions_id= $this->Employee->get_regions_id($this->_item)->row()->jobs_regions_id;
 	    		$jobs_city_id= $this->Jobs_affiliates->get_aff3($jobs_regions_id);
    		
    		}elseif($this->Employee->get_city_id($this->_item)->num_rows() > 0){
    			$jobs_city_id= $this->Employee->get_city_id($this->_item)->row()->jobs_city_id;
    		}
    	}
    	 
        $this->check_action_permission('search');
        $search=$this->input->post('search');
        $per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        if ($search)
        {
            $config['total_rows'] = $this->Jobs_affiliates->search_count_all($jobs_city_id, $this->_item,$search);
            $table_data = $this->Jobs_affiliates->search($jobs_city_id, $this->_item,$search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_affiliates_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'ASC');
        }
        else
        {
            $config['total_rows'] = $this->Jobs_affiliates->count_all($jobs_city_id, $this->_item);
            $table_data = $this->Jobs_affiliates->get_all($jobs_city_id, $this->_item, $per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_affiliates_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'ASC');
        }
        $config['base_url'] = site_url( $this->_controller.'/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table']= get_affiliates_manage_table_data_rows($table_data,$this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }
    /**/

    function search()
    {
    	if($this->_item != 1){
    		if( $this->Employee->get_regions_id($this->_item)->num_rows() > 0){
		    	$jobs_regions_id= $this->Employee->get_regions_id($this->_item)->row()->jobs_regions_id;
 	    		$jobs_city_id= $this->Jobs_affiliates->get_aff3($jobs_regions_id);
    		}elseif($this->Employee->get_city_id($this->_item)->num_rows() > 0){
    			$jobs_city_id= $this->Employee->get_city_id($this->_item)->row()->jobs_city_id;
    		}
    	}
    	 
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $search_data=$this->Jobs_affiliates->search($jobs_city_id, $this->_item,$search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_affiliates_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'DESC');
        $config['base_url'] = site_url($this->_controller.'/search');
        $config['total_rows'] = $this->Jobs_affiliates->search_count_all($jobs_city_id, $this->_item,$search);
        $config['per_page'] = $per_page ;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table']= get_affiliates_manage_table_data_rows($search_data,$this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }


    function suggest()
    {
    	if($this->_item != 1){
    		if( $this->Employee->get_regions_id($this->_item)->num_rows() > 0){
		    	$jobs_regions_id= $this->Employee->get_regions_id($this->_item)->row()->jobs_regions_id;
 	    		$jobs_city_id= $this->Jobs_affiliates->get_aff3($jobs_regions_id);
    		
    		}elseif($this->Employee->get_city_id($this->_item)->num_rows() > 0){
    			$jobs_city_id= $this->Employee->get_city_id($this->_item)->row()->jobs_city_id;
    		}
    	}    	 
        $suggestions = $this->Jobs_affiliates->get_search_suggestions($jobs_city_id, $this->_item,$this->input->get('term'),100);
        echo json_encode($suggestions);
    }


    public function save($id = -1)
    {
        $jobs_data = array(
            'jobs_affiliates_name' => $this->input->post('jobs_affiliates_name'),
            'jobs_affiliates_parent_id' => $this->input->post('jobs_parent_id') == null ? null : $this->input->post('jobs_parent_id'),
            'jobs_affiliates_place' => $this->input->post('jobs_affiliates_description') == '' ? '' : $this->input->post('jobs_affiliates_description'),
            'jobs_affiliates_date' => date('Y-m-d',strtotime($this->input->post('jobs_affiliates_date'))) == '' ? date('Y-m-d') : date('Y-m-d',strtotime($this->input->post('jobs_affiliates_date'))),
            'person_id' => $this->input->post('person_id'),
            'jobs_city_id' => $this->input->post('jobs_city_id'),
            'jobs_affiliates_status' => $this->input->post('jobs_affiliates_status') == '' ? 0 : $this->input->post('jobs_affiliates_status') ,
            'jobs_affiliates_color' => $this->input->post('jobs_affiliates_color') == '' ? "#000" : $this->input->post('jobs_affiliates_color'),
        );

        if($this->Jobs_affiliates->checkRegionsName($jobs_data['jobs_affiliates_name'],$id) > 0){
            echo json_encode(array(('message')=>lang($this->_controller.'_message_error').$jobs_data['jobs_affiliates_name'] .' ) đã được sử dụng !'));
        }else{
            if(empty($jobs_data['person_id'])){
                echo json_encode(array(('message')=>'Bạn có thể sử dụng tên chi nhánh này !'));
            }else{
                if($id_name = $this->Jobs_affiliates->save($jobs_data, $id) > 0){
                    echo json_encode(array('success'=>true,'message'=>lang($this->_controller.'_successful_adding').' '.$jobs_data['jobs_affiliates_name'].') !'));
                }else{
                    echo json_encode(array('success'=>false,'message'=>'Cảnh báo: Người Quản lý chi nhánh không được là người Quản lý thành phố nếu có chỉ có thể Quản lý chi nhánh trực thuộc thành phố họ đang quản lý ! '));
                }
            }
        }

    }

    function delete()
    {
        $this->check_action_permission('delete');
        $id = $this->input->post('ids');

        if($this->Jobs_affiliates->delete_list($id))
        {
            echo json_encode(array('success'=>true,'message'=>lang($this->_controller.'_successful_deleted').'  '.
                count($id).')'.lang($this->_controller.'_one_or_multiple')));
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
        return 420;
    }

    function get_manager_info()
    {
        return $this->Jobs_affiliates->get_person_info();
    }
    function get_city()
    {
        return $this->Jobs_affiliates->get_city_info();
    }

    function get_parent_affiliates($affiliates_id)
    {
        return $this->Jobs_affiliates->get_parent_affiliates($affiliates_id);
    }
}
