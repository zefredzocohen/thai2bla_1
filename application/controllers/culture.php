<?php
require_once ("person_controller.php");
class Culture extends Person_controller
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
        $config['total_rows'] = $this->Em_culture->count_all();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name']= strtolower(get_class());
        $data['form_width']= $this->get_form_width();
        $data['form_width_module']= $this->get_form_module_width();
        $data['per_page'] = $config['per_page'];
        $data['manage_table'] = get_culture_table($this->Em_culture->get_all($data['per_page']),$this);

        $this->load->view($this->_controller.'/index',$data);
    }


    /* module status */
    function view($id = -1)
    {
        $this->check_action_permission('add_update');
        $data['jobs_positions'] = $this->Em_culture->get_info($id);
        $data['person_info'] = $this->Em_culture->get_person();

        $this->load->view($this->_controller."/form",$data);
    }

    function sorting()
    {
        $this->check_action_permission('search');
        $search=$this->input->post('search');
        $per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        if ($search)
        {
            $config['total_rows'] = $this->Em_culture->search_count_all($search);
            $table_data = $this->Em_culture->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'ASC');
        }
        else
        {
            $config['total_rows'] = $this->Em_culture->count_all();
            $table_data = $this->Em_culture->get_all($per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'ASC');
        }
        $config['base_url'] = site_url( $this->_controller.'/sorting');
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table']= get_positions_manage_table_data_rows($table_data,$this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }
    /**/

    function search()
    {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $search_data=$this->Em_culture->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'DESC');
        $config['base_url'] = site_url($this->_controller.'/search');
        $config['total_rows'] = $this->Em_culture->search_count_all($search);
        $config['per_page'] = $per_page ;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table']= get_positions_manage_table_data_rows($search_data,$this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));

    }


    function suggest()
    {
        $suggestions = $this->Em_culture->get_search_suggestions($this->input->get('term'),100);
        echo json_encode($suggestions);
    }


   public function save($id = -1)
    {
        $jobs_data = array(
            'name' => $this->input->post('name'),
            'jobs_positions_description' => $this->input->post('jobs_positions_description') == '' ? '' : $this->input->post('jobs_positions_description'),
            'jobs_positions_date' => date('Y-m-d',strtotime($this->input->post('jobs_positions_date'))) == '' ? date('Y-m-d') : date('Y-m-d',strtotime($this->input->post('jobs_positions_date'))),
            'person_id' => $this->input->post('person_id'),
            'jobs_positions_color' => $this->input->post('jobs_positions_color') == '' ? "#000" : $this->input->post('jobs_positions_color'),
        );

        if($this->Em_culture->checkRegionsName($jobs_data['name'],$id) > 0){
            echo json_encode(array(('message')=>lang($this->_controller.'_message_error').$jobs_data['name'] .') đã được sử dụng'));

        }else{
            if($this->Em_culture->save($jobs_data, $id)){
                echo json_encode(array('success'=>true,'message'=>lang($this->_controller.'_successful_adding').' '.$jobs_data['name']));
            }
            else{
                echo json_encode(array(('message')=>lang($this->_controller.'_message_success').$jobs_data['name'] .' ) này !'));
            }
        }

    }


    function delete()
    {
        $this->check_action_permission('delete');
        $id = $this->input->post('ids');

        if($this->Em_culture->delete_list($id))
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
        return 450;
    }
    function get_name($id)
    {
        return $this->Em_culture->get_name_info($id);
    }

}
