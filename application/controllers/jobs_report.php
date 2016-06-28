<?php
require_once ("person_controller.php");
class Jobs_report extends Person_controller
{
    function __construct()
    {
        parent::__construct();
        $this->_item = $this->session->userdata('person_id');
        $this->num_rows();
    }
    private $_total_manager_success;
    private $_total_manager_error;

    function num_rows()
    {
        $this->_total_manager_success = $this->Jobs_reports->count_number_manager_success($this->_item);
        $this->_total_manager_error = $this->Jobs_reports->count_number_manager_error($this->_item);
    }
    function index()
    {
        $this->check_action_permission('search');
        $config['base_url'] = site_url('jobs/sorting');
        $config['total_rows'] = $this->Jobs_reports->count_all($this->_item);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name']= strtolower(get_class());
        $data['form_width']= $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_jobs_report_manage_table($this->Jobs_reports->get_all($this->_item,$data['per_page']),$this);

        $data['total_manager_success'] = $this->_total_manager_success;
        $data['total_manager_error'] = $this->_total_manager_error;

        $this->load->view('jobs/report/index',$data);
    }
    /*
     * Load file báo cáo tuần
     * */

    function report()
    {
        $this->load->view('jobs/report/report_exel/form');
    }
    function getReport()
    {
        $start_date = date('d-m-Y', strtotime( $this->input->post('start_date')));
        $end_date = date('d-m-Y', strtotime( $this->input->post('end_date')));
        $data['job_finished'] = $this->Jobs_reports->getReportExel($this->_item,$start_date,$end_date);

        require_once APPPATH . "/third_party/Classes/export_report.php";
    }
    function view_manager()
    {
        $this->check_action_permission('search');
        $config['base_url'] = site_url('jobs/sorting');
        $config['total_rows'] = $this->Jobs_reports->count_all_manager($this->_item);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name']= strtolower(get_class());
        $data['form_width']= $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_jobs_report_child_manage_table($this->Jobs_reports->get_all_jobs_report_manager($this->_item,$data['per_page']),$this);

        $data['total_manager_success'] = $this->_total_manager_success;
        $data['total_manager_error'] = $this->_total_manager_error;

        $this->load->view('jobs/report/index',$data);
    }
    function index_success()
    {
        $this->check_action_permission('search');
        $config['base_url'] = site_url('jobs/sorting');
        $config['total_rows'] = $this->Jobs_reports->count_all_success($this->_item);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name']= strtolower(get_class());
        $data['form_width']= $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_jobs_report_child_manage_table($this->Jobs_reports->get_all_success($this->_item,$data['per_page']),$this);

        $data['total_manager_success'] = $this->_total_manager_success;
        $data['total_manager_error'] = $this->_total_manager_error;

        $this->load->view('jobs/report/index',$data);
    }
    function index_error()
    {
        $this->check_action_permission('search');
        $config['base_url'] = site_url('jobs/sorting');
        $config['total_rows'] = $this->Jobs_reports->count_all_error($this->_item);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name']= strtolower(get_class());
        $data['form_width']= $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_jobs_report_child_manage_table($this->Jobs_reports->get_all_error($this->_item,$data['per_page']),$this);

        $data['total_manager_success'] = $this->_total_manager_success;
        $data['total_manager_error'] = $this->_total_manager_error;

        $this->load->view('jobs/report/index',$data);
    }
    function view_success()
    {
        $this->check_action_permission('search');
        $config['base_url'] = site_url('jobs/sorting');
        $config['total_rows'] = $this->Jobs_reports->count_all_manager_success($this->_item);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name']= strtolower(get_class());
        $data['form_width']= $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_jobs_report_child_manage_table($this->Jobs_reports->get_all_jobs_report_manager_success($this->_item,$data['per_page']),$this);

        $data['total_manager_success'] = $this->_total_manager_success;
        $data['total_manager_error'] = $this->_total_manager_error;

        $this->load->view('jobs/report/index',$data);
    }
    function view_error()
    {
            $this->check_action_permission('search');
            $config['base_url'] = site_url('jobs/sorting');
            $config['total_rows'] = $this->Jobs_reports->count_all_manager_error($this->_item);
            $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['controller_name']= strtolower(get_class());
            $data['form_width']= $this->get_form_width();
            $data['per_page'] = $config['per_page'];
            $data['manage_table'] = get_jobs_report_child_manage_table($this->Jobs_reports->get_all_jobs_report_manager_error($this->_item,$data['per_page']),$this);

            $data['total_manager_success'] = $this->_total_manager_success;
            $data['total_manager_error'] = $this->_total_manager_error;

            $this->load->view('jobs/report/index',$data);
    }

    function sorting()
    {
        $this->check_action_permission('search');
        $search=$this->input->post('search');
        $per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        if ($search)
        {
            $config['total_rows'] = $this->Jobs_reports->search_count_all($search);
            $table_data = $this->Jobs_reports->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_important' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
        }
        else
        {
            $config['total_rows'] = $this->Jobs_reports->count_all();
            $table_data = $this->Jobs_reports->get_all($per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_important' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
        }
        $config['base_url'] = site_url('jobs/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table']= get_jobs_report_manage_table_data_rows($table_data,$this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }
    /* added for excel expert */
    function excel_export() {
        $data = $this->Employee->get_all()->result_object();
        $this->load->helper('report');
        $rows = array();
        $row = array("User Name", "First Name", "Last Name", "E-Mail", "Phone Number", "Address 1", "Address 2", "City", "State", "Zip", "Country", "Comments");
        $rows[] = $row;
        foreach ($data as $r) {
            $row = array(
                $r->username,
                $r->first_name,
                $r->last_name,
                $r->email,
                $r->phone_number,
                $r->address_1,
                $r->address_2,
                $r->city,
                $r->state,
                $r->zip,
                $r->country,
                $r->comments
            );
            $rows[] = $row;
        }

        $content = array_to_csv($rows);
        force_download('employees_export' . '.csv', $content);
        exit;
    }



    /*
    Returns employee table data rows. This will be called with AJAX.
    */
    function search()
    {
        $this->check_action_permission('search');
        $search=$this->input->post('search');
        $per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $search_data=$this->Jobs_reports->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_important' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'DESC');
        $config['base_url'] = site_url('jobs/search');
        $config['total_rows'] = $this->Jobs_reports->search_count_all($search);
        $config['per_page'] = $per_page ;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table']= get_jobs_report_manage_table_data_rows($search_data,$this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));

    }


    /*
    Gives search suggestions based on what is being searched for
    */
    function suggest()
    {
        $suggestions = $this->Jobs_reports->get_search_suggestions($this->input->get('term'),500);
        echo json_encode($suggestions);
    }
    function get_name_people_parent()
    {
        return $this->Jobs_employees->get_parent_jobs($this->_item);
    }
    /*
    Loads the employee edit form
    */
    function view($jobs_id = -1)
    {
        $this->check_action_permission('add_update');

        $data['jobs_info']= $this->Jobs_reports->get_report_info($this->_item);
        $data['jobs_report']= $this->Jobs_reports->get_jobs_report_info($jobs_id);

        $this->load->view("jobs/report/my_report/form",$data);
    }
    /*
    Loads the employee edit form
    */
    function report_week($jobs_id = -1)
    {
        $this->check_action_permission('search');
        $config['base_url'] = site_url('jobs/sorting');
        $config['total_rows'] = $this->Jobs_reports->count_all($this->_item);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name']= strtolower(get_class());
        $data['form_width']= $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_jobs_report_manage_table($this->Jobs_reports->get_all($this->_item,$data['per_page']),$this);

        $data['total_manager_success'] = $this->_total_manager_success;
        $data['total_manager_error'] = $this->_total_manager_error;

        $this->load->view("jobs/report/report_week",$data);

    }/*
    Loads the employee edit form
    */
    function report_month($jobs_id = -1)
    {

        $this->check_action_permission('search');
        $config['base_url'] = site_url('jobs/sorting');
        $config['total_rows'] = $this->Jobs_reports->count_all($this->_item);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name']= strtolower(get_class());
        $data['form_width']= $this->get_form_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_jobs_report_manage_table($this->Jobs_reports->get_all($this->_item,$data['per_page']),$this);

        $data['total_manager_success'] = $this->_total_manager_success;
        $data['total_manager_error'] = $this->_total_manager_error;

        $this->load->view("jobs/report/report_month",$data);
    }
     /*
    Loads the employee edit form
    */
    function show($jobs_id = -1)
    {
        $this->check_action_permission('add_update');

        $data['get_info_jobs']= $this->Jobs_reports->get_report_info($this->_item);
        $data['get_jobs_report']= $this->Jobs_reports->get_jobs_report_info($jobs_id);

        $this->load->view("jobs/report/form_manager",$data);
    }


    public function save($jobs_report_id = -1)
    {
        $jobs_data = array(
            'jobs_reports_name' => $this->input->post('jobs_reports_name'),
            'jobs_reports_content' => $this->input->post('jobs_reports_content'),
            'jobs_reports_date' => date('Y-m-d',strtotime($this->input->post('jobs_reports_date'))) == '' ? date('Y-m-d') : date('Y-m-d',strtotime($this->input->post('jobs_reports_date'))),
            'jobs_reports_result' => $this->input->post('jobs_reports_result'),
             'employees_jobs_id' => $this->input->post('employees_jobs_id')
        );


        if($this->Jobs_reports->save($jobs_data, $jobs_report_id))
        {
            //New employee
            if($jobs_report_id == -1)
            {
                echo json_encode(array('success'=>true,'message'=>lang('jobs_report_successful_adding').' '.
                    $jobs_data['name'],'jobs_id'=>$jobs_data['jobs_id']));
            }
            else //previous employee
            {
                echo json_encode(array('success'=>true,'message'=>lang('jobs_report_successful_updating').' '.
                    $jobs_data['name'],'jobs_id'=>$jobs_data['jobs_id']));
            }
        }
        else//failure
        {
            echo json_encode(array('success'=>false,'message'=>lang('jobs_report_error_adding_updating').' '.
                $jobs_data['name'],'jobs_id'=>$jobs_data['jobs_id']));
        }
    }
    public function save_manager($jobs_report_id = -1)
    {
        $jobs_id = $this->input->post('jobs_id');
        $jobs_data = array(
            'jobs_reports_status' => $this->input->post('jobs_reports_status'),
            'jobs_reports_comment' => $this->input->post('jobs_reports_comment') == '' ? '' : $this->input->post('jobs_reports_comment') ,
            'jobs_reports_result_manager' => $this->input->post('jobs_reports_result_manager')== '' ? '' : $this->input->post('jobs_reports_result_manager') ,
            'jobs_status_id' => $this->input->post('jobs_status'),
            'jobs_important' => $this->input->post('jobs_important')
        );

        if($this->Jobs_reports->save_manager($jobs_data, $jobs_report_id, $jobs_id))
        {
            //New employee
            if($jobs_report_id == -1)
            {
                echo json_encode(array('success'=>true,'message'=>lang('employees_successful_adding').' '.
                    $jobs_data['name'],'jobs_id'=>$jobs_data['jobs_id']));
            }
            else //previous employee
            {
                echo json_encode(array('success'=>true,'message'=>lang('jobs_project_successful_updating').' '.
                    $jobs_data['name'],'jobs_id'=>$jobs_data['jobs_id']));
            }
        }
        else//failure
        {
            echo json_encode(array('success'=>false,'message'=>lang('jobs_report_error_adding_updating').' '.
                $jobs_data['name'],'jobs_id'=>$jobs_data['jobs_id']));
        }
    }

    /*
    This deletes employees from the employees table
    */
    function delete()
    {
        $this->check_action_permission('delete');
        $jobs_reports_id = $this->input->post('ids');

        if($this->Jobs_reports->delete_list($jobs_reports_id))
        {
            echo json_encode(array('success'=>true,'message'=>lang('report_jobs_successful_deleted').'  '.
                count($jobs_reports_id).' '.lang('report_jobs_one_or_multiple')));
        }else{
            echo json_encode(array('success'=>false,'message'=>lang('employees_cannot_be_deleted')));
        }

    }
    /*
    get the width for the add/edit form
    */
    function get_form_width()
    {
        return 500;
    }
        /*
      get the width for the add/edit form
      */

}
