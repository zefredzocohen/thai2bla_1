<?php
require_once ("person_controller.php");
class Jobs extends Person_controller
{
    function __construct()
    {
        parent::__construct();
        $this->_item = $this->session->userdata('person_id');
    }

    function index()
    {
        $this->check_action_permission('search');
        $config['base_url'] = site_url('jobs/sorting');
        $config['total_rows'] = $this->Jobs_projects->count_all($this->_item);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name']= strtolower(get_class());
        $data['form_width']= $this->get_form_width();
        $data['form_width_module']= $this->get_form_module_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_jobs_project_manage_table($this->Jobs_projects->get_all($data['per_page']),$this);

       $this->load->view('jobs/task/index',$data);
 		/* $this->load->view('jobs/project/index',$data); */
    }
    /*
     * Show information of the table status
     * */
    function show_status()
    {
        $this->check_action_permission('search');
        $config['base_url'] = site_url('jobs/sorting_status');
        $config['total_rows'] = $this->Jobs_projects->count_all_status();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name']= strtolower(get_class());
        $data['form_width']= $this->get_form_width();
        $data['form_width_module']= $this->get_form_module_width();
        $data['per_page'] = $config['per_page'];
        $data['status'] = 1;

        $data['manage_table'] = get_jobs_status_table($this->Jobs_projects->get_all_status($data['per_page']),$this);

        $this->load->view('jobs/project/index',$data);
    }

    /*
    * Show information of the table status
    * */
    function show_important()
    {
        $this->check_action_permission('search');
        $config['base_url'] = site_url('jobs/sorting_important');
        $config['total_rows'] = $this->Jobs_projects->count_all_important();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name']= strtolower(get_class());
        $data['form_width']= $this->get_form_width();
        $data['form_width_module']= $this->get_form_module_width();
        $data['per_page'] = $config['per_page'];
        $data['status'] = 2;

        $data['manage_table'] = get_jobs_important_table($this->Jobs_projects->get_all_important($data['per_page']),$this);

        $this->load->view('jobs/project/index',$data);
    }

    /*
    * Show information of the table status
    * */
    function show_security()
    {
        $this->check_action_permission('search');
        $config['base_url'] = site_url('jobs/sorting_security');
        $config['total_rows'] = $this->Jobs_projects->count_all_security();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name']= strtolower(get_class());
        $data['form_width']= $this->get_form_width();
        $data['form_width_module']= $this->get_form_module_width();
        $data['per_page'] = $config['per_page'];
        $data['status'] = 3;

        $data['manage_table'] = get_jobs_security_table($this->Jobs_projects->get_all_security($data['per_page']),$this);

        $this->load->view('jobs/project/index',$data);
    }

    function view($jobs_id = -1)
    {
        $this->check_action_permission('add_update');
        $config['base_url'] = site_url('jobs/sorting');
        $config['total_rows'] = $this->Jobs_projects->count_all($this->_item);
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name']= strtolower(get_class());
        $data['form_width']= $this->get_form_width();
        $data['form_width_module']= $this->get_form_module_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_jobs_project_manage_table_insert($this->Jobs_projects->get_all($data['per_page']),$this);


      //  $this->load->view('jobs/project/index',$data);
        $data['jobs_info']= $this->Jobs_projects->get_jobs_info($jobs_id);
        $data['jobs_parent']= $this->Jobs_projects->get_jobs_parent($jobs_id);
        $data['jobs_status_info']= $this->Jobs_projects->get_jobs_status_info();
        $data['jobs_security_info']= $this->Jobs_projects->get_all_security_info();
        $data['jobs_important_info']= $this->Jobs_projects->get_all_important_info();

        $this->load->view("jobs/project/form",$data);
    }
    /* module status */
    function view_status($jobs_status_id = -1)
    {
        $this->check_action_permission('add_update');
        $data['jobs_status']= $this->Jobs_projects->get_jobs_status($jobs_status_id);

        $this->load->view("jobs/project/form_status",$data);
    }
    /* module status */
    function view_important($jobs_important_id = -1)
    {
        $this->check_action_permission('add_update');
        $data['jobs_important']= $this->Jobs_projects->get_jobs_important($jobs_important_id);

        $this->load->view("jobs/project/form_important",$data);
    }

  /* module status */
    function view_security($jobs_security_id = -1)
    {
        $this->check_action_permission('add_update');
        $data['jobs_security']= $this->Jobs_projects->get_jobs_security($jobs_security_id);

        $this->load->view("jobs/project/form_security",$data);
    }


    function sorting()
    {
        $this->check_action_permission('search');
        $search=$this->input->post('search');
        $per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        if ($search)
        {
            $config['total_rows'] = $this->Jobs_projects->search_count_all($search);
            $table_data = $this->Jobs_projects->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_important' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'ASC');
        }
        else
        {
            $config['total_rows'] = $this->Jobs_projects->count_all();
            $table_data = $this->Jobs_projects->get_all($per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_important' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'ASC');
        }
        $config['base_url'] = site_url('jobs/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table']= get_jobs_project_manage_table_data_rows($table_data,$this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function sorting_status()
    {
        $this->check_action_permission('search');
        $search=$this->input->post('search');
        $per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        if ($search)
        {
            $config['total_rows'] = $this->Jobs_projects->search_count_all_status($search);
            $table_data = $this->Jobs_projects->search_status($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_status_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'ASC');
        }
        else
        {
            $config['total_rows'] = $this->Jobs_projects->count_all_status();
            $table_data = $this->Jobs_projects->get_all_status($per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_status_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'ASC');
        }
        $config['base_url'] = site_url('jobs/sorting_status');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table']= get_jobs_status_manage_table_data_rows($table_data,$this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }
    function sorting_important()
    {
        $this->check_action_permission('search');
        $search=$this->input->post('search');
        $per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        if ($search)
        {
            $config['total_rows'] = $this->Jobs_projects->search_count_all_important($search);
            $table_data = $this->Jobs_projects->search_important($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_important_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'ASC');
        }
        else
        {
            $config['total_rows'] = $this->Jobs_projects->count_all_important();
            $table_data = $this->Jobs_projects->get_all_important($per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_important_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'ASC');
        }
        $config['base_url'] = site_url('jobs/sorting_status');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table']= get_jobs_important_table_data_rows($table_data,$this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }
    function sorting_security()
    {
        $this->check_action_permission('search');
        $search=$this->input->post('search');
        $per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        if ($search)
        {
            $config['total_rows'] = $this->Jobs_projects->search_count_all_security($search);
            $table_data = $this->Jobs_projects->search_security($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_important_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'ASC');
        }
        else
        {
            $config['total_rows'] = $this->Jobs_projects->count_all_security();
            $table_data = $this->Jobs_projects->get_all_security($per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_important_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'ASC');
        }
        $config['base_url'] = site_url('jobs/sorting_status');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table']= get_jobs_security_table_data_rows($table_data,$this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    /*
    Returns employee table data rows. This will be called with AJAX.
    */
    function search_status()
    {
        $this->check_action_permission('search');
        $search=$this->input->post('search');
        $per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $search_data=$this->Jobs_projects->search_status($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_status_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'DESC');
        $config['base_url'] = site_url('jobs/search');
        $config['total_rows'] = $this->Jobs_projects->search_count_all_status($search);
        $config['per_page'] = $per_page ;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table']= get_jobs_status_manage_table_data_rows($search_data,$this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));

    } /*
    Returns employee table data rows. This will be called with AJAX.
    */
    function search_important()
    {
        $this->check_action_permission('search');
        $search=$this->input->post('search');
        $per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $search_data=$this->Jobs_projects->search_important($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_important_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'DESC');
        $config['base_url'] = site_url('jobs/search');
        $config['total_rows'] = $this->Jobs_projects->search_count_all_important($search);
        $config['per_page'] = $per_page ;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table']= get_jobs_important_table_data_rows($search_data,$this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));

    }
    /*
    Returns employee table data rows. This will be called with AJAX.
    */
    function search_security()
    {
        $this->check_action_permission('search');
        $search=$this->input->post('search');
        $per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $search_data=$this->Jobs_projects->search_security($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_security_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'DESC');
        $config['base_url'] = site_url('jobs/search');
        $config['total_rows'] = $this->Jobs_projects->search_count_all_security($search);
        $config['per_page'] = $per_page ;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table']= get_jobs_security_table_data_rows($search_data,$this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));

    }
    /*
    Returns employee table data rows. This will be called with AJAX.
    */
    function search()
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
    Returns employee table data rows. This will be called with AJAX.
    */
    function search_insert()
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
        $suggestions = $this->Jobs_projects->get_search_suggestions($this->input->get('term'),100);
        echo json_encode($suggestions);
    }
    /*
    Gives search suggestions based on what is being searched for
    */
    function suggest_status()
    {
        $suggestions = $this->Jobs_projects->get_search_suggestions_status($this->input->get('term'),100);
        echo json_encode($suggestions);
    }
 /*
    Gives search suggestions based on what is being searched for
    */
    function suggest_important()
    {
        $suggestions = $this->Jobs_projects->get_search_suggestions_important($this->input->get('term'),100);
        echo json_encode($suggestions);
    }
 /*
    Gives search suggestions based on what is being searched for
    */
    function suggest_security()
    {
        $suggestions = $this->Jobs_projects->get_search_suggestions_security($this->input->get('term'),100);
        echo json_encode($suggestions);
    }


    public function save($jobs_id='')
    {
	  /*upload file info contract customer*/
	
	 	$config=array(
	 		'upload_path'=>'./file/project',
	 		'allowed_types'=>'doc|docx|pdf',
	 	);
	 	$this->load->library('upload',$config);
            $this->upload->do_upload('jobs_url_file');
            // $file_data_contract_vitae=$this->upload->data(); 
		if (!$this->upload->do_upload('jobs_url_file')) {
			$error = array(
			'errors' => $this->upload->display_errors(),
			);
        }else {
            $file_data_jobs_file = $this->upload->data(); 
		}		
        $this->check_action_permission('add_update');     
        if ( !$this->upload->do_upload('jobs_file_url')){
            $jobs_data = array(
                'jobs_name' => $this->input->post('jobs_name'),
                'jobs_parent' => $this->input->post('parent_id_hidden') == '' ?  ($this->input->post('jobs_parent_id') == '' ? '' : $this->input->post('jobs_parent_id') ) : $this->input->post('jobs_parent_id'),
                'jobs_start_date' => date('Y-m-d',strtotime($this->input->post('jobs_start_date'))),
                'jobs_end_date' => date('Y-m-d',strtotime($this->input->post('jobs_end_date'))),
                'jobs_status_id' => $this->input->post('jobs_status_id'),
                'jobs_important'=>$this->input->post('jobs_important_id'),
                'jobs_security_id'=>$this->input->post('jobs_security_id'),
                'jobs_content'=>$this->input->post('jobs_content'),
                'person_id'=>$this->_item,
                'jobs_url_file'=>$file_data_jobs_file['file_name'],
                'project_status'=>'1',
                'jobs_approve'=>'0',
                'jobs_approve_content'=>'',
                'jobs_approve_date'=>'',
            );
        }
        else {
            $data =  $this->upload->data();
            $jobs_data = array(
                'jobs_name' => $this->input->post('jobs_name'),
                'jobs_parent' => $this->input->post('parent_id_hidden') == '' ?  ($this->input->post('jobs_parent_id') == '' ? '' : $this->input->post('jobs_parent_id') ) : $this->input->post('jobs_parent_id'),
                'jobs_start_date' => date('Y-m-d',strtotime($this->input->post('jobs_start_date'))),
                'jobs_end_date' => date('Y-m-d',strtotime($this->input->post('jobs_end_date'))),
                'jobs_status_id' => $this->input->post('jobs_status_id'),
                'jobs_important'=>$this->input->post('jobs_important_id'),
                'jobs_security_id'=>$this->input->post('jobs_security_id'),
                'jobs_content'=>$this->input->post('jobs_content'),
                'person_id'=>$this->_item,
                'jobs_url_file'=>$data['file_name'],
                'project_status'=>'1',
                'jobs_approve'=>'0',
                'jobs_approve_content'=>'',
                'jobs_approve_date'=>'',
            );
        }
        if($this->Jobs_employees->checkName($this->input->post('jobs_name'),$jobs_id) > 0){
            echo "Cảnh báo tên : (".$this->input->post('jobs_name').') đã được sử dụng .';
        }else{
            if($this->Jobs_projects->save($jobs_data, $jobs_id)){
                //echo "true";
               header('Location:'.base_url().'jobs'); 
            }
            else{
                echo 'Bạn có thể sử dụng tên công việc này';
            }
        }

    }

    public function save_status($status_id = -1)
    {
        $jobs_data = array(
            'jobs_status_name' => $this->input->post('jobs_status_name'),
            'jobs_status_date' => date('Y-m-d',strtotime($this->input->post('jobs_status_date'))),
            'person_id' => $this->_item,
            'jobs_status_show' => $this->input->post('jobs_status_show') == '' ? '1' : $this->input->post('jobs_status_show'),
            'jobs_status_color' => $this->input->post('jobs_status_color'),
        );

        if($this->Jobs_projects->save_status($jobs_data, $status_id))
        {
            //New employee
            if($status_id == -1)
            {
                echo json_encode(array('success'=>true,'message'=>lang('jobs_status_successful_adding').' '.
                    $jobs_data['name'],'jobs_id'=>$jobs_data['jobs_id']));
            }
            else //previous employee
            {
                echo json_encode(array('success'=>true,'message'=>lang('jobs_status_successful_updating').' '.
                    $jobs_data['name'],'jobs_id'=>$jobs_data['jobs_id']));
            }
        }
        else//failure
        {
            echo json_encode(array('success'=>false,'message'=>lang('jobs_status_error_adding_updating').' '.
                $jobs_data['name'],'jobs_id'=>$jobs_data['jobs_id']));
        }
    }

    public function save_important($jobs_security_id = -1)
    {
        $jobs_data = array(
            'jobs_important_name' => $this->input->post('jobs_important_name'),
            'jobs_important_date' => date('Y-m-d',strtotime($this->input->post('jobs_important_date'))),
            'person_id' => $this->_item,
            'jobs_important_show' => $this->input->post('jobs_important_show') == '' ? '1' : $this->input->post('jobs_important_show')
        );

        if($this->Jobs_projects->save_important($jobs_data, $jobs_security_id))
        {
            //New employee
            if($jobs_security_id == -1)
            {
                echo json_encode(array('success'=>true,'message'=>lang('jobs_important_successful_adding').' '.
                    $jobs_data['name'],'jobs_id'=>$jobs_data['jobs_id']));
            }
            else //previous employee
            {
                echo json_encode(array('success'=>true,'message'=>lang('jobs_important_successful_updating').' '.
                    $jobs_data['name'],'jobs_id'=>$jobs_data['jobs_id']));
            }
        }
        else//failure
        {
            echo json_encode(array('success'=>false,'message'=>lang('jobs_error_adding_updating').' '.
                $jobs_data['name'],'jobs_id'=>$jobs_data['jobs_id']));
        }
    }
    public function save_security($security_id = -1)
    {
        $jobs_data = array(
            'jobs_security_name' => $this->input->post('jobs_security_name'),
            'jobs_security_date' => date('Y-m-d',strtotime($this->input->post('jobs_security_date'))),
            'person_id' => $this->_item,
            'jobs_security_show' => $this->input->post('jobs_security_show') == '' ? '1' : $this->input->post('jobs_security_show')
        );

        if($this->Jobs_projects->save_security($jobs_data, $security_id))
        {
            //New employee
            if($security_id == -1)
            {
                echo json_encode(array('success'=>true,'message'=>lang('jobs_successful_adding').' '.
                    $jobs_data['name'],'jobs_id'=>$jobs_data['jobs_id']));
            }
            else //previous employee
            {
                echo json_encode(array('success'=>true,'message'=>lang('jobs_security_successful_updating').' '.
                    $jobs_data['name'],'jobs_id'=>$jobs_data['jobs_id']));
            }
        }
        else//failure
        {
            echo json_encode(array('success'=>false,'message'=>lang('jobs_error_adding_updating').' '.
                $jobs_data['name'],'jobs_id'=>$jobs_data['jobs_id']));
        }
    }
    /*
    This deletes employees from the employees table
    */
    function delete()
    {
        $this->check_action_permission('delete');
        $jobs_id = $this->input->post('ids');

        if($this->Jobs_projects->delete_list($jobs_id))
        {
            echo json_encode(array('success'=>true,'message'=>lang('successful_deleted').'  '.
                count($jobs_id).' '.lang('jobs_project_one_or_multiples')));
        }else{
            echo json_encode(array('success'=>false,'message'=>lang('jobs_cannot_be_deleted')));
        }
    }
     /*
    This deletes employees from the employees table
    */
    function delete_status()
    {
        $this->check_action_permission('delete');
        $jobs_id = $this->input->post('ids');

        if($this->Jobs_projects->delete_list_status($jobs_id))
        {
            echo json_encode(array('success'=>true,'message'=>lang('jobs_successful_deleted').'  '.
                count($jobs_id).' '.lang('jobs_one_or_multiple')));
        }else{
            echo json_encode(array('success'=>false,'message'=>lang('jobs_status_cannot_be_deleted')));
        }
    }
     /*
    This deletes employees from the employees table
    */
    function delete_important()
    {
        $this->check_action_permission('delete');
        $jobs_id = $this->input->post('ids');

        if($this->Jobs_projects->delete_list_important($jobs_id))
        {
            echo json_encode(array('success'=>true,'message'=>lang('jobs_successful_deleted').'  '.
                count($jobs_id).' '.lang('jobs_one_or_multiple')));
        }else{
            echo json_encode(array('success'=>false,'message'=>lang('jobs_status_cannot_be_deleted')));
        }
    }
    /*
    This deletes employees from the employees table
    */
    function delete_security()
    {
        $this->check_action_permission('delete');
        $jobs_id = $this->input->post('ids');

        if($this->Jobs_projects->delete_list_security($jobs_id))
        {
            echo json_encode(array('success'=>true,'message'=>lang('jobs_successful_deleted').'  '.
                count($jobs_id).' '.lang('jobs_one_or_multiple')));
        }else{
            echo json_encode(array('success'=>false,'message'=>lang('jobs_status_cannot_be_deleted')));
        }
    }
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
        return $this->Jobs_projects->get_jobs_status_info();
    }
}
