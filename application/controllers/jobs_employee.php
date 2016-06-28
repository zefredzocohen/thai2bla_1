<?php
require_once ("person_controller.php");
class Jobs_employee extends Person_controller
{
    function __construct()
    {
        parent::__construct();
        $this->_item = $this->session->userdata('person_id');
       // $this->autoLoad();

    }
    function autoLoad()
    {
        $this->_total_rows_index = $this->Jobs_employees->count_all_jobs_person($this->_item);
        $this->_total_rows_success = $this->Jobs_employees->count_all_jobs_success($this->_item);
        $this->_total_rows_start = $this->Jobs_employees->count_all_jobs_start($this->_item);
        $this->_total_rows_doing = $this->Jobs_employees->count_all_jobs_doing($this->_item);
        $this->_total_rows_expired = $this->Jobs_employees->count_all_jobs_expired($this->_item);
        $this->_total_rows_manage = $this->Jobs_employees->count_all_jobs_manager($this->_item);

    }
    function loader()
    {
        $data['total_rows_index'] =  $this->_total_rows_index;
        $data['total_rows_success'] = $this->_total_rows_success;
        $data['total_rows_start'] =  $this->_total_rows_start;
        $data['total_rows_doing'] =  $this->_total_rows_doing;
        $data['total_rows_expired'] = $this->_total_rows_expired;
        $data['total_rows_manage'] = $this->_total_rows_manage;
    }
    function detail_index_jobs($jobs_id){
        $data['jobs_info']= $this->Jobs_employees->get_detail_jobs($jobs_id);
        $data['jobs_important']= $this->Jobs_employees->get_jobs_important();
        $data['jobs_status']= $this->Jobs_employees->get_jobs_status();

        $this->load->view('jobs/detail_index',$data);
    }
    function view_success()
    {
        $this->check_action_permission('search');
        $config['base_url'] = site_url('jobs_project/sorting');
        $config['total_rows'] = $this->Jobs_employees->count_all_success($this->_item);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name']= strtolower(get_class());
        $data['form_width']= $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        //Number all rows

        $data['total_rows_index'] =  $this->_total_rows_index;
        $data['total_rows_success'] = $this->_total_rows_success;
        $data['total_rows_start'] =  $this->_total_rows_start;
        $data['total_rows_doing'] =  $this->_total_rows_doing;
        $data['total_rows_expired'] = $this->_total_rows_expired;
        $data['total_rows_manage'] = $this->_total_rows_manage;
        $data['total_view_approve'] = $this->Jobs_employees->count_all_jobs_approve($this->_item);
        $data['total_view_not_approve'] = $this->Jobs_employees->count_all_jobs_not_approve($this->_item);
        $data['total_view_manager_not_approve'] = $this->Jobs_employees->count_all_jobs_manager_not_approve($this->_item);
        $data['total_view_manager_approve'] = $this->Jobs_employees->count_all_jobs_manager_approve($this->_item);

       $data['manage_table'] = get_jobs_employees_child_manage_table($this->Jobs_employees->get_jobs_success($this->_item,$data['per_page']),$this);

        $this->load->view('jobs/employees/index',$data);
    }
    function view_near_expired()
    {
        $this->check_action_permission('search');
        $config['base_url'] = site_url('jobs_project/sorting');
        $config['total_rows'] = $this->Jobs_employees->count_all_near_expired($this->_item);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name']= strtolower(get_class());
        $data['form_width']= $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        //Number all rows

        $data['total_rows_index'] =  $this->_total_rows_index;
        $data['total_rows_success'] = $this->_total_rows_success;
        $data['total_rows_start'] =  $this->_total_rows_start;
        $data['total_rows_doing'] =  $this->_total_rows_doing;
        $data['total_rows_expired'] = $this->_total_rows_expired;
        $data['total_rows_manage'] = $this->_total_rows_manage;
        $data['total_view_approve'] = $this->Jobs_employees->count_all_jobs_approve($this->_item);
        $data['total_view_not_approve'] = $this->Jobs_employees->count_all_jobs_not_approve($this->_item);
        $data['total_view_manager_not_approve'] = $this->Jobs_employees->count_all_jobs_manager_not_approve($this->_item);
        $data['total_view_manager_approve'] = $this->Jobs_employees->count_all_jobs_manager_approve($this->_item);

        $data['manage_table'] = get_jobs_employees_child_manage_table($this->Jobs_employees->get_jobs_near_expired($this->_item,$data['per_page']),$this);

        $this->load->view('jobs/employees/index',$data);
    }
    function index()
    {
        $this->check_action_permission('search');
        $config['base_url'] = site_url('jobs_employee/sorting');
        $config['total_rows'] = $this->Jobs_employees->count_all_my_jobs($this->_item);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name']= strtolower(get_class());
        $data['form_width']= $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        //Number all rows

        $data['total_rows_index'] =  $this->_total_rows_index;
        $data['total_rows_success'] = $this->_total_rows_success;
        $data['total_rows_start'] =  $this->_total_rows_start;
        $data['total_rows_doing'] =  $this->_total_rows_doing;
        $data['total_rows_expired'] = $this->_total_rows_expired;
        $data['total_rows_manage'] = $this->_total_rows_manage;
        $data['total_view_approve'] = $this->Jobs_employees->count_all_jobs_approve($this->_item);
        $data['total_view_not_approve'] = $this->Jobs_employees->count_all_jobs_not_approve($this->_item);
        $data['total_view_manager_not_approve'] = $this->Jobs_employees->count_all_jobs_manager_not_approve($this->_item);
        $data['total_view_manager_approve'] = $this->Jobs_employees->count_all_jobs_manager_approve($this->_item);

       $data['manage_table'] = get_my_jobs_employees_manage_table($this->Jobs_employees->get_jobs_success_one($this->_item,$data['per_page']),$this);

        $this->load->view('jobs/employees/index',$data);
    }

     function view_manager()
     {
            $this->check_action_permission('search');
            $config['base_url'] = site_url('jobs_project/sorting');
            $config['total_rows'] = $this->Jobs_employees->count_all_manage($this->_item);
            $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['controller_name']= strtolower(get_class());
            $data['form_width']= $this->get_form_width();
            $data['per_page'] = $config['per_page'];
            //Number all rows

             $data['total_rows_index'] =  $this->_total_rows_index;
             $data['total_rows_success'] = $this->_total_rows_success;
             $data['total_rows_start'] =  $this->_total_rows_start;
             $data['total_rows_doing'] =  $this->_total_rows_doing;
             $data['total_rows_expired'] = $this->_total_rows_expired;
             $data['total_rows_manage'] =  $this->session->userdata('total_number') + $this->Jobs_employees->count_all_jobs_manager($this->_item);
             $data['total_view_approve'] = $this->Jobs_employees->count_all_jobs_approve($this->_item);
             $data['total_view_not_approve'] = $this->Jobs_employees->count_all_jobs_not_approve($this->_item);
             $data['total_view_manager_not_approve'] = $this->Jobs_employees->count_all_jobs_manager_not_approve($this->_item);
             $data['total_view_manager_approve'] = $this->Jobs_employees->count_all_jobs_manager_approve($this->_item);

            $data['manage_table'] = get_jobs_employees_manage_table($this->Jobs_employees->get_jobs_manager($this->_item,$data['per_page']),$this);

            $this->load->view('jobs/employees/index',$data);
     }

    /*
     * Call view jobs start
     * */
    function view_start()
    {
        $this->check_action_permission('search');
        $config['base_url'] = site_url('jobs_project/sorting');
        $config['total_rows'] = $this->Jobs_employees->count_all_jobs_start($this->_item);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name']= strtolower(get_class());
        $data['form_width']= $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        //Number all rows
        //Number all rows
        $data['total_rows_index'] =  $this->_total_rows_index;
        $data['total_rows_success'] = $this->_total_rows_success;
        $data['total_rows_start'] =  $this->_total_rows_start;
        $data['total_rows_doing'] =  $this->_total_rows_doing;
        $data['total_rows_expired'] = $this->_total_rows_expired;
        $data['total_rows_manage'] = $this->_total_rows_manage;
        $data['total_view_approve'] = $this->Jobs_employees->count_all_jobs_approve($this->_item);
        $data['total_view_not_approve'] = $this->Jobs_employees->count_all_jobs_not_approve($this->_item);
        $data['total_view_manager_not_approve'] = $this->Jobs_employees->count_all_jobs_manager_not_approve($this->_item);
        $data['total_view_manager_approve'] = $this->Jobs_employees->count_all_jobs_manager_approve($this->_item);

        $data['manage_table'] = get_jobs_employees_child_manage_table($this->Jobs_employees->get_jobs_start($this->_item,$data['per_page']),$this);

        $this->load->view('jobs/employees/index',$data);
    }
    function get_name_people_parent()
    {
        return $this->Jobs_employees->get_parent_jobs($this->_item);
    }
     /*
     * Call view jobs start
     * */
    function view_doing()
    {
        $this->check_action_permission('search');
        $config['base_url'] = site_url('jobs_project/sorting');
        $config['total_rows'] = $this->Jobs_employees->count_all_jobs_doing($this->_item);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name']= strtolower(get_class());
        $data['form_width']= $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        //Number all rows
        $data['total_rows_index'] =  $this->_total_rows_index;
        $data['total_rows_success'] = $this->_total_rows_success;
        $data['total_rows_start'] =  $this->_total_rows_start;
        $data['total_rows_doing'] =  $this->_total_rows_doing;
        $data['total_rows_expired'] = $this->_total_rows_expired;
        $data['total_rows_manage'] = $this->_total_rows_manage;
        $data['total_view_approve'] = $this->Jobs_employees->count_all_jobs_approve($this->_item);
        $data['total_view_not_approve'] = $this->Jobs_employees->count_all_jobs_not_approve($this->_item);
        $data['total_view_manager_not_approve'] = $this->Jobs_employees->count_all_jobs_manager_not_approve($this->_item);
        $data['total_view_manager_approve'] = $this->Jobs_employees->count_all_jobs_manager_approve($this->_item);

        $data['manage_table'] = get_jobs_employees_child_manage_table($this->Jobs_employees->get_jobs_doing($this->_item,$data['per_page']),$this);

        $this->load->view('jobs/employees/index',$data);
    }
    /*
     * Call view jobs expired
     * */
    function view_expired()
    {
        $this->check_action_permission('search');
        $config['base_url'] = site_url('jobs_project/sorting');
        $config['total_rows'] = $this->Jobs_employees->count_all_jobs_expired($this->_item);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name']= strtolower(get_class());
        $data['form_width']= $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        //Number all rows
        //Number all rows
        $data['total_rows_index'] =  $this->_total_rows_index;
        $data['total_rows_success'] = $this->_total_rows_success;
        $data['total_rows_start'] =  $this->_total_rows_start;
        $data['total_rows_doing'] =  $this->_total_rows_doing;
        $data['total_rows_expired'] = $this->_total_rows_expired;
        $data['total_rows_manage'] = $this->_total_rows_manage;
        $data['total_view_approve'] = $this->Jobs_employees->count_all_jobs_approve($this->_item);
        $data['total_view_not_approve'] = $this->Jobs_employees->count_all_jobs_not_approve($this->_item);
        $data['total_view_manager_not_approve'] = $this->Jobs_employees->count_all_jobs_manager_not_approve($this->_item);
        $data['total_view_manager_approve'] = $this->Jobs_employees->count_all_jobs_manager_approve($this->_item);

        $data['manage_table'] = get_jobs_employees_child_manage_table($this->Jobs_employees->get_jobs_expired($this->_item,$data['per_page']),$this);

        $this->load->view('jobs/employees/index',$data);
    }
    /*
     * Call view jobs expired
     * */
    function view_approve()
    {
        $this->check_action_permission('search');
        $config['base_url'] = site_url('jobs_project/sorting');
        $config['total_rows'] = $this->Jobs_employees->count_all_jobs_approve($this->_item);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name']= strtolower(get_class());
        $data['form_width']= $this->get_form_width();
        $data['per_page'] = $config['per_page'];

        $data['total_rows_index'] =  $this->_total_rows_index;
        $data['total_rows_success'] = $this->_total_rows_success;
        $data['total_rows_start'] =  $this->_total_rows_start;
        $data['total_rows_doing'] =  $this->_total_rows_doing;
        $data['total_rows_expired'] = $this->_total_rows_expired;
        $data['total_rows_manage'] = $this->_total_rows_manage;
        $data['total_view_approve'] = $this->Jobs_employees->count_all_jobs_approve($this->_item);
        $data['total_view_not_approve'] = $this->Jobs_employees->count_all_jobs_not_approve($this->_item);
        $data['total_view_manager_not_approve'] = $this->Jobs_employees->count_all_jobs_manager_not_approve($this->_item);
        $data['total_view_manager_approve'] = $this->Jobs_employees->count_all_jobs_manager_approve($this->_item);

        $data['manage_table'] = get_my_jobs_employees_manage_table($this->Jobs_employees->get_jobs_approve($this->_item,$data['per_page']),$this);

        $this->load->view('jobs/employees/index',$data);
    } /*
     * Call view jobs expired
     * */
    function view_manager_approve()
    {
        $this->check_action_permission('search');
        $config['base_url'] = site_url('jobs_project/sorting');
        $config['total_rows'] = $this->Jobs_employees->count_all_jobs_manager_approve($this->_item);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name']= strtolower(get_class());
        $data['form_width']= $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        //Number all rows
        //Number all rows
        $data['total_rows_index'] =  $this->_total_rows_index;
        $data['total_rows_success'] = $this->_total_rows_success;
        $data['total_rows_start'] =  $this->_total_rows_start;
        $data['total_rows_doing'] =  $this->_total_rows_doing;
        $data['total_rows_expired'] = $this->_total_rows_expired;
        $data['total_rows_manage'] = $this->_total_rows_manage;
        $data['total_view_approve'] = $this->Jobs_employees->count_all_jobs_approve($this->_item);
        $data['total_view_not_approve'] = $this->Jobs_employees->count_all_jobs_not_approve($this->_item);
        $data['total_view_manager_not_approve'] = $this->Jobs_employees->count_all_jobs_manager_not_approve($this->_item);
        $data['total_view_manager_approve'] = $this->Jobs_employees->count_all_jobs_manager_approve($this->_item);

        $data['manage_table'] = get_approve_table($this->Jobs_employees->getManagerApprove($this->_item,$data['per_page']),$this);

        $this->load->view('jobs/employees/index',$data);
    }
    /*
     * Call view jobs expired
     * */
    function view_manager_not_approve()
    {
        $this->check_action_permission('search');
        $config['base_url'] = site_url('jobs_project/sorting');
        $config['total_rows'] = $this->Jobs_employees->count_all_jobs_manager_not_approve($this->_item);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name']= strtolower(get_class());
        $data['form_width']= $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        //Number all rows
        $data['total_rows_index'] =  $this->_total_rows_index;
        $data['total_rows_success'] = $this->_total_rows_success;
        $data['total_rows_start'] =  $this->_total_rows_start;
        $data['total_rows_doing'] =  $this->_total_rows_doing;
        $data['total_rows_expired'] = $this->_total_rows_expired;
        $data['total_rows_manage'] = $this->_total_rows_manage;
        $data['total_view_approve'] = $this->Jobs_employees->count_all_jobs_approve($this->_item);
        $data['total_view_not_approve'] = $this->Jobs_employees->count_all_jobs_not_approve($this->_item);
        $data['total_view_manager_not_approve'] = $this->Jobs_employees->count_all_jobs_manager_not_approve($this->_item);
        $data['total_view_manager_approve'] = $this->Jobs_employees->count_all_jobs_manager_approve($this->_item);

        $data['manage_table'] = get_approve_manage_table($this->Jobs_employees->getManagerNotApprove($this->_item,$data['per_page']),$this);

        $this->load->view('jobs/employees/index',$data);
    }
    /*
     *  Hàm get information for check approve(duyệt công việc được quản lý)
     *
     * */
    function save_manager_approve($jobs_id)
    {
        $data = array(
            'jobs_approve'=>1,
            'jobs_approve_content' => $this->input->post('approve_content'),
            'jobs_approve_date' => date('Y-m-d')
        );
        if($this->Jobs_employees->save_approve($data,$jobs_id)){
            header('location: '.site_url('jobs_employee/view_manager_not_approve'));
        }

    }
    /*
     * Call view jobs expired
     * */
    function view_not_approve()
    {
        $this->check_action_permission('search');
        $config['base_url'] = site_url('jobs_project/sorting');
        $config['total_rows'] = $this->Jobs_employees->count_all_jobs_not_approve($this->_item);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name']= strtolower(get_class());
        $data['form_width']= $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        //Number all rows
        //Number all rows
        $data['total_rows_index'] =  $this->_total_rows_index;
        $data['total_rows_success'] = $this->_total_rows_success;
        $data['total_rows_start'] =  $this->_total_rows_start;
        $data['total_rows_doing'] =  $this->_total_rows_doing;
        $data['total_rows_expired'] = $this->_total_rows_expired;
        $data['total_rows_manage'] = $this->_total_rows_manage;
        $data['total_view_approve'] = $this->Jobs_employees->count_all_jobs_approve($this->_item);
        $data['total_view_not_approve'] = $this->Jobs_employees->count_all_jobs_not_approve($this->_item);
        $data['total_view_manager_not_approve'] = $this->Jobs_employees->count_all_jobs_manager_not_approve($this->_item);
        $data['total_view_manager_approve'] = $this->Jobs_employees->count_all_jobs_manager_approve($this->_item);

        $data['manage_table'] = get_my_jobs_employees_manage_table($this->Jobs_employees->get_jobs_not_approve($this->_item,$data['per_page']),$this);

        $this->load->view('jobs/employees/index',$data);
    }
    function sorting()
    {
        $this->check_action_permission('search');
        $search=$this->input->post('search');
        $per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        if ($search)
        {
            $config['total_rows'] = $this->Jobs_employees->search_count_all($search,$this->_item);
            $table_data = $this->Jobs_employees->my_search($search,$this->_item,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_important' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'DESC');
        }
        else
        {
            $config['total_rows'] = $this->Jobs_employees->count_all_my_manager_jobs($this->_item);
            $table_data = $this->Jobs_employees->get_my_manager_jobs_all($this->_item,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_important' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'DESC');
        }
        $config['base_url'] = site_url('jobs_employee/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table']= get_my_jobs_employees_manage_table_data_rows($table_data,$this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }
    function sorting_manager()
    {
        $this->check_action_permission('search');
        $search=$this->input->post('search');
        $per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        if ($search)
        {
            $config['total_rows'] = $this->Jobs_employees->search_count_all($search,$this->_item);
            $table_data = $this->Jobs_employees->my_search($search,$this->_item,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_important' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'DESC');
        }
        else
        {
            $config['total_rows'] = $this->Jobs_employees->count_all_my_manager_jobs($this->_item);
            $table_data = $this->Jobs_employees->get_my_manager_jobs_all($this->_item,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_important' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'DESC');
        }
        $config['base_url'] = site_url('jobs_employee/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table']= get_my_jobs_employees_manage_table_data_rows($table_data,$this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }
     function sorting_employees()
     {
            $this->check_action_permission('search');
            $search=$this->input->post('search_employees');
            $per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
            if ($search)
            {
                $config['total_rows'] = $this->Jobs_employees->search_one_count_all($search,$this->_item);
                $table_data = $this->Jobs_employees->my_search($search,$this->_item,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'first_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'DESC');
            }
            else
            {
                $config['total_rows'] = $this->Jobs_employees->count_all_my_manager_jobs($this->_item);
                $table_data = $this->Jobs_employees->get_my_manager_jobs_all($this->_item,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'first_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'DESC');
            }
            $config['base_url'] = site_url('jobs_employee/sorting_employees');
            $config['per_page'] = $per_page;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['manage_table_employees']= get_jobs_manage_table_data_rows_one($table_data,$this);
            echo json_encode(array('manage_table_employees' => $data['manage_table_employees'], 'pagination' => $data['pagination']));
     }

  function my_sorting()
  {
        $this->check_action_permission('search');
        $search=$this->input->post('search');
        $per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        if ($search)
        {
            $config['total_rows'] = $this->Jobs_employees->search_count_all($search,$this->_item);
            $table_data = $this->Jobs_employees->my_search($search,$this->_item,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_important' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'DESC');
        }
        else
        {
            $config['total_rows'] = $this->Jobs_employees->count_all_my_jobs($this->_item);
            $table_data = $this->Jobs_employees->get_my_jobs_all($this->_item,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_important' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'DESC');
        }
        $config['base_url'] = site_url('jobs_employee/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table']= get_my_jobs_employees_manage_table_data_rows($table_data,$this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }



    /*
    Returns employee table data rows. This will be called with AJAX.
    */

    function my_search()
    {
        $this->check_action_permission('search');
        $search=$this->input->post('search');
        $per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $search_data=$this->Jobs_employees->my_search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_important' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'DESC');
        $config['base_url'] = site_url('jobs_employee/search');
        $config['total_rows'] = $this->Jobs_employees->search_my_count_all($search);
        $config['per_page'] = $per_page ;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table']= get_jobs_employees_manage_table_data_rows($search_data,$this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }
    function search()
    {
        $this->check_action_permission('search');
        $search=$this->input->post('search');
        $per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 1;
        $search_data=$this->Jobs_employees->my_search($search,$this->_item,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_important' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'DESC');
        $config['base_url'] = site_url('jobs_employee/search');
        $config['total_rows'] = $this->Jobs_employees->search_my_count_all($search,$this->_item);
        $config['per_page'] = $per_page ;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table']= get_jobs_employees_manage_table_data_rows($search_data,$this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }
    function search_employees()
    {
        $this->check_action_permission('search');
        $search=$this->input->post('search_employees');
        $per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 1;
        $search_data=$this->Jobs_employees->one_search($search,$this->_item,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'first_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'DESC');
        $config['base_url'] = site_url('jobs_employee/search');
        $config['total_rows'] = $this->Jobs_employees->search_one_count_all($search,$this->_item);
        $config['per_page'] = $per_page ;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table_employees']= get_jobs_manage_table_data_rows_one($search_data,$this);
        echo json_encode(array('manage_table_employees' => $data['manage_table_employees'], 'pagination' => $data['pagination']));

    }
     /*
    Returns employee table data rows. This will be called with AJAX.
    */
    function search_index()
    {
        $this->check_action_permission('search');
        $search=$this->input->post('search');
        $per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $search_data=$this->Jobs_projects->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_important' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'DESC');
        $config['base_url'] = site_url('jobs/search');
        $config['total_rows'] = $this->Jobs_projects->search_count_all($search);
        $config['per_page'] = $per_page ;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table']= get_jobs_project_manage_table_data_rows($search_data,$this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }


    /*
    Gives search suggestions based on what is being searched for
    */
    function suggest()
    {
        $suggestions = $this->Jobs_employees->get_search_my_suggestions($this->input->get('term'),$this->_item,100);
        echo json_encode($suggestions);
    } /*
    Gives search suggestions based on what is being searched for
    */
    function my_suggest()
    {
        $suggestions = $this->Jobs_employees->get_search_my_suggestions($this->input->get('term'),$this->_item,100);
        echo json_encode($suggestions);
    }
    /*
    Gives search suggestions based on what is being searched for
    */
    function suggest_manager()
    {
        $suggestions = $this->Jobs_employees->get_search_manager_suggestions($this->input->get('term'),$this->_item,100);
        echo json_encode($suggestions);
    }
    /*
    Gives search suggestions based on what is being searched for
    */
    function suggest_employees()
    {
        $suggestions = $this->Jobs_employees->get_search_employees_suggestions($this->input->get('term'),$this->_item,100);
        echo json_encode($suggestions);
    }

    /*
    Loads the employee edit form
    */
    function view($jobs_id = -1)
    {
        $data['jobs_employees']= $this->Jobs_employees->get_jobs_employees_info($jobs_id);
       //$data['employees_info']= $this->Jobs_employees->get_manager_employees($this->_item);
        $data['jobs_info']= $this->Jobs_employees->getJobsManager($this->_item);
        $data['name_peron_info']= $this->Jobs_department->get_person_info();
        $data['city_info']= $this->Jobs_department->get_city_action();
        $data['affiliates_info']= $this->Jobs_department->get_affiliates_name();
        $data['regions_info']= $this->Jobs_department->get_regions_info();
        $data['department_info'] = $this->Jobs_department->get_department_name();

        $this->load->view("jobs/employees/jobs_employees/form",$data);
    }

    function loadRegions($id = -1)
    {
        $regions_id = $this->input->post('jobs_regions_id');

        $data['city_info'] = $this->Jobs_employees->getAllCity($regions_id);
        $items = array();
        foreach( $data['city_info'] AS $key => $values){
            $items[] = $values->jobs_city_id;
        }
        $data['affiliates_info']= $this->Jobs_employees->getActionAffiliates($id,$items);
        $item_department = array();

        foreach( $data['affiliates_info'] AS $values){
            $item_department[]= $values->jobs_affiliates_id;
        }
        $item_department = implode($item_department,',');
        $data['department_info'] =  $this->Jobs_employees->getActionsDepartment($id,$item_department);

        $item_employees = array();

        foreach($data['department_info'] AS $values){
            $item_employees[]=$values->department_id;
        }
        $item_employees = implode($item_employees,',');
        $data['employees_info'] =  $this->Jobs_employees->getActionsEmployees($id,$item_employees);

        $this->load->view("jobs/employees/jobs_employees/form_action_regions",$data);
    }
    function loadCity($id = -1)
    {
        $city_id = $this->input->post('jobs_city_id');

        $data['affiliates_info']= $this->Jobs_employees->getActionAffiliates($id,$city_id);
        $item_department = array();

        foreach( $data['affiliates_info'] AS $values){
            $item_department[]= $values->jobs_affiliates_id;
        }
        $item_department = implode($item_department,',');
        $data['department_info'] =  $this->Jobs_employees->getActionsDepartment($id,$item_department);

        $item_employees = array();

        foreach($data['department_info'] AS $values){
            $item_employees[]=$values->department_id;
        }
        $item_employees = implode($item_employees,',');
        $data['employees_info'] =  $this->Jobs_employees->getActionsEmployees($id,$item_employees);

        $this->load->view("jobs/employees/jobs_employees/form_action_city",$data);
    }
    function loadAffiliates($id = -1)
    {
            $affiliates_id = $this->input->post('jobs_affiliates_id');

            $data['department_info'] =  $this->Jobs_employees->getActionsDepartment($id,$affiliates_id);
            $item_employees = array();

            foreach($data['department_info'] AS $values){
                $item_employees[]=$values->department_id;
            }
            $item_employees = implode($item_employees,',');
            $data['employees_info'] =  $this->Jobs_employees->getActionsEmployees($id,$item_employees);

            $this->load->view("jobs/employees/jobs_employees/form_action_affiliates",$data);
    }
    function loadDepartment($id = -1)
    {
            $department_id = $this->input->post('department_id');
            $data['employees_info'] =  $this->Jobs_employees->getActionsEmployees($id,$department_id);

            $this->load->view("jobs/employees/jobs_employees/form_action_department",$data);
    }

    function my_view($jobs_id=-1)
    {
        $this->check_action_permission('add_update');
        $config['base_url'] = site_url('jobs_employee/sorting');
        $config['total_rows'] = $this->Jobs_employees->count_all_my_jobs($this->_item);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name']= strtolower(get_class());
        $data['form_width']= $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        //Number all rows

        $data['total_rows_index'] =  $this->_total_rows_index;
        $data['total_rows_success'] = $this->_total_rows_success;
        $data['total_rows_start'] =  $this->_total_rows_start;
        $data['total_rows_doing'] =  $this->_total_rows_doing;
        $data['total_rows_expired'] = $this->_total_rows_expired;
        $data['total_rows_manage'] = $this->_total_rows_manage;

        $data['manage_table'] = get_my_jobs_employees_index_table($this->Jobs_employees->get_jobs_success_one($this->_item,$data['per_page']),$this);

        $data['jobs_info']= $this->Jobs_projects->get_jobs_info($jobs_id);
        $data['jobs_parent']= $this->Jobs_employees->get_jobs_parent($this->_item);
        $data['jobs_status_info']= $this->Jobs_projects->get_jobs_status_info();
        $data['jobs_security_info']= $this->Jobs_projects->get_all_security_info();
        $data['jobs_important_info']= $this->Jobs_projects->get_all_important_info();

        $this->load->view("jobs/employees/form_one",$data);
    }
    public function save_one($jobs_id = '')
    {
        $this->check_action_permission('add_update');
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png|doc|txt|xls|pdf|php|sql|xml|htm|html';
        $config['max_size']	= '1000';
        $config['max_width']  = '1024';
        $config['max_height']  = '768';

        $this->load->library('upload', $config);


        if ( !$this->upload->do_upload('jobs_file_url')){
            $jobs_data = array(
                'jobs_id'=> $jobs_id == '' ? '' : $jobs_id,
                'jobs_name' => $this->input->post('jobs_name'),
                'jobs_parent' => $this->input->post('parent_id_hidden') == '' ?  ($this->input->post('jobs_parent_id') == '' ? '' : $this->input->post('jobs_parent_id') ) : $this->input->post('jobs_parent_id'),
                'jobs_start_date' => date('Y-m-d',strtotime($this->input->post('jobs_start_date'))) == '' ? '' : date('Y-m-d',strtotime($this->input->post('jobs_start_date'))) ,
                'jobs_end_date' => date('Y-m-d',strtotime($this->input->post('jobs_end_date')))== '' ? '' : date('Y-m-d',strtotime($this->input->post('jobs_end_date'))),
                'jobs_status_id' => $this->input->post('jobs_status_id'),
                'jobs_important'=>$this->input->post('jobs_important_id'),
                'jobs_security_id'=>$this->input->post('jobs_security_id'),
                'jobs_content'=>$this->input->post('jobs_content'),
                'person_id'=>$this->_item == '' ? '' : $this->_item,
                'jobs_url_file'=>'',
                'project_status'=>'0',
                'jobs_approve'=>'0',
                'jobs_approve_content'=>'',
                'jobs_approve_date'=>'',
            );
        }
        else {
            $data =  $this->upload->data();
            $jobs_data = array(
                'jobs_id'=> $jobs_id == '' ? '' : $jobs_id,
                'jobs_name' => $this->input->post('jobs_name'),
                'jobs_parent' => $this->input->post('parent_id_hidden') == '' ?  ($this->input->post('jobs_parent_id') == '' ? '' : $this->input->post('jobs_parent_id') ) : $this->input->post('jobs_parent_id'),
                'jobs_start_date' => date('Y-m-d',strtotime($this->input->post('jobs_start_date'))) == '' ? '' : date('Y-m-d',strtotime($this->input->post('jobs_start_date'))) ,
                'jobs_end_date' => date('Y-m-d',strtotime($this->input->post('jobs_end_date')))== '' ? '' : date('Y-m-d',strtotime($this->input->post('jobs_end_date'))),
                'jobs_status_id' => $this->input->post('jobs_status_id'),
                'jobs_important'=>$this->input->post('jobs_important_id'),
                'jobs_security_id'=>$this->input->post('jobs_security_id'),
                'jobs_content'=>$this->input->post('jobs_content'),
                'person_id'=>$this->_item == '' ? '' : $this->_item,
                'jobs_url_file'=>$data['file_name'],
                'project_status'=>'0',
                'jobs_approve'=>'0',
                'jobs_approve_content'=>'',
                'jobs_approve_date'=>'',

            );
        }
        if($this->Jobs_employees->checkName($this->input->post('jobs_name'),$jobs_id) > 0){
           echo "Tên này: (".$this->input->post('jobs_name').') đã được sử dụng .';
        }else{
            if($this->Jobs_employees->save_one($jobs_data, $jobs_id,$this->_item))
            {
                header('Location:'.base_url().'jobs');
            }
            else{
                echo 'Bạn có thể sử dụng tên công việc này';
            }
        }

    }


    function save($employee_jobs_id=-1)
    {
        if($this->check_save($employee_jobs_id))
        {
            $this->autoLoad();
            if($employee_jobs_id == -1){
                echo json_encode(array('success'=>true,'message'=>lang('jobs_employee_successful_adding')));
            }
            else {
                echo json_encode(array('success'=>true,'message'=>lang('jobs_employee_successful_updating')));
            }
        } else{
            echo json_encode(array('success'=>false,'message'=>lang('jobs_error_adding_updating')));
        }
    }


    function check_save($employee_jobs_id)
    {
        $success = false;
        $this->check_action_permission('add_update');
        $person_id = $this->input->post("jobs_person_name")!= false ? $this->input->post("jobs_person_name"): array();

        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png|doc|txt|exel|pdf|php|sql|xml|htm|html';
        $config['max_size']	= '1000';
        $config['max_width']  = '1024';
        $config['max_height']  = '768';
        $this->load->library('upload', $config);

        $this->upload->do_upload('jobs_file_url');
        $data =  $this->upload->data();
        foreach($person_id AS $person_id_values):
            $person_data = array(
                'jobs_id'=>$this->input->post('jobs_name'),
                'employees_jobs_parent_id'=> $this->_item,
                'person_id'=> $person_id_values,
                'employees_jobs_date'=>date('Y-m-d',strtotime($this->input->post('employees_jobs_date'))),
                'employees_jobs_content'=>$this->input->post('employees_jobs_content'),
                'employees_jobs_file'=> $data['file_name'] == ''  ?  '' :  $data['file_name']
            );

            if($this->Jobs_employees->save($person_data, $employee_jobs_id)){
                $success = true;
            }else{
                $success = false;
            }
        endforeach;
        return $success;
    }
    /*
    This deletes employees from the employees table
    */
    function delete()
    {
        $this->check_action_permission('delete');
        $employees_to_delete = $this->input->post('ids');

        if($this->Jobs_employees->delete_list($employees_to_delete))
        {
            echo json_encode(array('success'=>true,'message'=>lang('jobs_employee_successful_deleted').'  '.
                count($employees_to_delete).' '.lang('jobs_one_or_multiple')));
        }else{
            echo json_encode(array('success'=>false,'message'=>lang('jobs_employee_cannot_be_deleted')));
        }

    }

    /*
    get the width for the add/edit form
    */
    function get_form_width()
    {
        return 450;
    }

    function get($number)
    {
        $this->session->set_userdata('total_number',count($number));
        return $this->session->userdata('total_number');
    }
    function get_status()
    {
        return $this->Jobs_projects->get_jobs_status_info();
    }

}
