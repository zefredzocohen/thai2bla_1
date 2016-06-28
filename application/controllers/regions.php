<?php
require_once ("person_controller.php");
class Regions extends Person_controller
{
    function __construct()
    {
        parent::__construct();
        $this->_item = $this->session->userdata('person_id');
        $this->_controller = 'regions';
    }


    /*
     * Show information of the table status
     * */
    function index()
    {
        $this->check_action_permission('search');
        $config['base_url'] = site_url('regions/sorting');
        $config['total_rows'] = $this->Jobs_regions->count_all($this->_item);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name']= strtolower(get_class());
        $data['form_width']= $this->get_form_width();
        $data['form_width_module']= $this->get_form_module_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_regions_table($this->Jobs_regions->get_all($this->_item,$data['per_page']),$this);

        $this->load->view('jobs/'.$this->_controller.'/index',$data);
    }
    function checkUpdate()
    {
       return $this->Jobs_regions->checkUpdate($this->_item,$this->_controller);
    }

    /* module status */
    function view($jobs_regions_id = -1)
    {
        $this->check_action_permission('add_update');
        $data['jobs_regions']= $this->Jobs_regions->get_regions($jobs_regions_id);
        $data['name_peron_info']= $this->Jobs_regions->get_person_info();

        $this->load->view("jobs/".$this->_controller."/form",$data);
    }


    function sorting()
    {
        $this->check_action_permission('search');
        $search=$this->input->post('search');
        $per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        if ($search){
            $config['total_rows'] = $this->Jobs_regions->search_count_all($search);
            $table_data = $this->Jobs_regions->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_regions_id' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'ASC');
        }
        else {
            $config['total_rows'] = $this->Jobs_regions->count_all($this->_item);
            $table_data = $this->Jobs_regions->get_all($this->_item,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_regions_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'ASC');
        }
        $config['base_url'] = site_url('regions/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table']= get_regions_manage_table_data_rows($table_data,$this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }
    /**/

    function search()
    {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $search_data=$this->Jobs_regions->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_regions_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'DESC');
        $config['base_url'] = site_url('regions/search');
        $config['total_rows'] = $this->Jobs_regions->search_count_all($search);
        $config['per_page'] = $per_page ;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table']= get_regions_manage_table_data_rows($search_data,$this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));

    }


    function suggest()
    {
        $suggestions = $this->Jobs_regions->get_search_suggestions($this->input->get('term'),100);
        echo json_encode($suggestions);
    }


    public function save($regions_id = -1)
    {
        $jobs_data = array(
            'jobs_regions_name' => $this->input->post('jobs_regions_name'),
            'jobs_regions_description' => $this->input->post('jobs_regions_description') == '' ? '' : $this->input->post('jobs_regions_description'),
            'jobs_regions_date' => date('Y-m-d',strtotime($this->input->post('jobs_regions_date'))) == '' ? date('Y-m-d') : date('Y-m-d',strtotime($this->input->post('jobs_regions_date'))),
            'person_id' => $this->input->post('person_id'),
            'jobs_regions_color' => $this->input->post('jobs_regions_color') == '' ? "#000" : $this->input->post('jobs_regions_color'),
        );

        if($this->Jobs_regions->checkRegionsName($jobs_data['jobs_regions_name'],$regions_id) > 0){
            echo json_encode(array('message'=>lang($this->_controller.'_message_error').$jobs_data['jobs_regions_name'] .' ) đã được sử dụng'));
        }else{
            if(empty($jobs_data['person_id'])){
                echo json_encode(array('message'=>'Thêm mới khu vực không thành công!'));
            }else{
                if($regions_id == -1){
                    //echo json_encode(array('success'=>true,'message'=>lang($this->_controller.'_successful_adding').' '.$jobs_data['jobs_regions_name'].') !'));
                     echo json_encode(array('success'=>true,'message'=>'Thêm mới thành công khu vực: '.$jobs_data['jobs_regions_name'].'!'));
                }else{
                   // echo json_encode(array('success'=>false,'message'=>lang($this->_controller.'_message_success').$jobs_data['jobs_regions_name'] .' ) này !'));
                    echo json_encode(array('success'=>true,'message'=>'Sửa thành công khu vực: '.$jobs_data['jobs_regions_name']));
                }
            }
        }
    }


    function delete()
    {
        $this->check_action_permission('delete');
        $regions_id = $this->input->post('ids');

        if($this->Jobs_regions->delete_list($regions_id))
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

    function get_status()
    {
        return $this->Jobs_regions->get_jobs_status_info();
    }

    function get_important()
    {
        return $this->Jobs_regions->get_jobs_important_info();
    }

    function get_manager_info()
    {
        return $this->Jobs_regions->get_person_info();
    }
}
