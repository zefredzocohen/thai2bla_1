<?php
require_once ("person_controller.php");
class File extends Person_controller
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
        $this->check_action_permission('search');
        $config['base_url'] = site_url($this->_controller.'/sorting');
        $config['total_rows'] = $this->Jobs_file->count_all();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name']= strtolower(get_class());
        $data['form_width']= $this->get_form_width();
        $data['form_width_module']= $this->get_form_module_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_file_table($this->Jobs_file->getAllFileManager($this->_item,$data['per_page']),$this);

        $this->load->view('jobs/file/index',$data);
    }


    /* module status */
    function view($id = -1)
    {
        $this->check_action_permission('add_update');
        $data['jobs_file']= $this->Jobs_file->get_row($id);
       // $data['department_name']= $this->Jobs_file->getNameDepartmentUploadFile($this->_item);

        $this->load->view("jobs/file/form",$data);
    }


    function sorting()
    {
        $this->check_action_permission('search');
        $search=$this->input->post('search');
        $per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        if ($search)
        {
            $config['total_rows'] = $this->Jobs_file->search_count_all($search);
            $table_data = $this->Jobs_file->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_file_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'ASC');
        }
        else
        {
            $config['total_rows'] = $this->Jobs_file->count_all();
            $table_data = $this->Jobs_file->getAllFileManager($per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_file_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'ASC');
        }
        $config['base_url'] = site_url( $this->_controller.'/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table']= get_file_manage_table_data_rows($table_data,$this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }
    /**/

    function search()
    {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $search_data=$this->Jobs_file->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'jobs_file_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'DESC');
        $config['base_url'] = site_url($this->_controller.'/search');
        $config['total_rows'] = $this->Jobs_file->search_count_all($search);
        $config['per_page'] = $per_page ;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table']= get_file_manage_table_data_rows($search_data,$this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));

    }

    function suggest()
    {
        $suggestions = $this->Jobs_file->get_search_suggestions($this->input->get('term'),100);
        echo json_encode($suggestions);
    }


    public function save($id = -1)
    {
        /* upload file info contract customer */

        $config = array(
            'upload_path' => './file/file',
            'allowed_types' => 'doc|docx|pdf|rar|xls|xlsx',
        );
        $this->load->library('upload', $config);
        $this->upload->do_upload('jobs_file_name');
        // $file_data_contract_vitae=$this->upload->data(); 
        if (!$this->upload->do_upload('jobs_file_name')) {
            $error = array(
                'errors' => $this->upload->display_errors(),
            );
        } else {
            $file_data_file = $this->upload->data();
        }
        if ($id != -1) {
            $data = $this->Jobs_file->get_info_one_more_file($id);
            if (empty($file_data_file)) {
                $file_data_file['file_name'] = $data->jobs_file_name;
            }
        }

        $jobs_data = array(
            'jobs_file_title' => $this->input->post('jobs_file_title'),
            'jobs_file_name' => $file_data_file['file_name'],
            'jobs_file_description' => $this->input->post('jobs_file_description') == '' ? '' : $this->input->post('jobs_file_description'),
            'jobs_file_date' => date('Y-m-d',strtotime($this->input->post('jobs_file_date'))) == '' ? date('Y-m-d') : date('Y-m-d',strtotime($this->input->post('jobs_file_date'))),
            'person_id' => $this->_item,
        );

        if($this->Jobs_file->save($jobs_data, $id)){
            echo json_encode(array('success'=>true,'message'=>lang($this->_controller.'_successful_adding').' '.$jobs_data['jobs_file_name']));
        }
        else{
            echo json_encode(array(('message')=>lang($this->_controller.'_message_success').$jobs_data['jobs_file_name'] .' ) này !'));
        }

    }


    function delete()
    {
        $this->check_action_permission('delete');
        $id = $this->input->post('ids');

        if($this->Jobs_file->delete_list($id))
        {
            echo json_encode(array('success'=>true,'message'=>lang($this->_controller.'_successful_deleted').'  '.
                count($id).' '.lang($this->_controller.'_one_or_multiple')));
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
        return 500;
    }

   function getNamePersonUploadFile($id)
   {
      return $this->Jobs_file->getNamePersonUploadFile($id);
   }
   function getNameDepartmentUploadFile($id)
   {
      return $this->Jobs_file->getNameDepartmentUploadFile($id);
   }
}
