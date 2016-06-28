<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * created by Hunght
 * edit by huyenlt 2/20/14
 */

require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");

class Contractcustomer extends Secure_area {
    function __construct() {
        parent::__construct('');
        $this->_controller = 'contractcustomer';
    }

    function index() {
        $this->check_action_permission('search');
        $config['base_url'] = site_url('contractcustomer/sorting');
//        $config['total_rows'] = $this->Contractcustomers->count_all();
        $config['total_rows'] = $this->Contractcustomers->count_all_by_employee_id($this->session->userdata('person_id'));
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        $data['per_page'] = $config['per_page'];
//        $data['manage_table'] = get_contract_customer_manage_table($this->Contractcustomers->get_all($data['per_page']), $this);
        $data['manage_table'] = get_contract_customer_manage_table($this->Contractcustomers->get_all_by_employee($this->session->userdata('person_id'),$data['per_page']), $this);
        $this->load->view('contractcustomer/manage', $data);
    }

    //load form them and sua
    function view($id = -1) {
        $this->check_action_permission('add_update');
        if ($id == -1) {
            $this->load->view("contractcustomer/form");
        } else {
            $data['item_info'] = $this->Contractcustomers->get_info($id);
            $this->load->view("contractcustomer/form", $data);
        }
    }

    public function type_sup_search() {
        $suggestions = $this->Customer->get_customner_search_suggestions_contract($this->session->userdata('person_id'),$this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    function select_customer() {
        $data = array();
        $customer_id = $this->input->post("customer");
        if ($this->Customer->exists($customer_id)) {
            $this->sale_lib->set_customer($customer_id);
        } else {
            $data['error'] = lang('sales_unable_to_add_customer');
        }

        $this->_reload($data);
    }

    function get_info($id = -1) {
        echo json_encode($this->Contractcustomers->get_info($id));
    }
	
    function save($id = -1) {
        /* upload file info contract customer */
        $config = array(
            'upload_path' => './file/contract',
            'allowed_types' => 'xlsx|docx|doc|pdf|png|jpg|jpeg|gif|xls',        	
        );
        $this->load->library('upload', $config);
        $this->upload->do_upload('contract_file');
        //$file_data_contract_vitae=$this->upload->data(); 
        if (!$this->upload->do_upload('contract_file')) {
            $error = array(
                'errors' => $this->upload->display_errors(),
            );
        } else {
            $file_data_contract_vitae = $this->upload->data();
        }
        if ($id != -1) 
        {
            $data = $this->Contractcustomers->get_info_one_more_contract($id);
            if (empty($file_data_contract_vitae)) {
                $file_data_contract_vitae['file_name'] = $data->contract_file;
            }
        }
        $aa = $this->input->post('id_sup1');
        if ($id != -1)  
        {
            $data = $this->Contractcustomers->get_info_one_more_person_id($id);
            if ($aa == '') 
            {
                $aa = $data->person_id;
            }
        }
        $this->check_action_permission('add_update');
        $start_date = date('Y-m-d', strtotime($this->input->post('contract_start_date')));
        $end_date = date('Y-m-d', strtotime($this->input->post('contract_end_date')));
        $item_data = array(
            'name' => $this->input->post('contractcustomer_name'),
            'description' => $this->input->post('description'),
            'code_contract' => $this->input->post('contractcustomer_code'),
            'number_contract' => $this->input->post('contractcustomer_number'),
            'start_date' => $start_date,
            'end_date' => $end_date,
            'person_id' => $aa,
            'catecontract_id' => $this->input->post('contract_type'),
            'contract_file' => $file_data_contract_vitae['file_name'],
        );

        if ($this->Contractcustomers->save($item_data, $id)) 
        {
            if ($id == -1) 
            {
                echo json_encode(array('success'=>true,'message'=>lang('contractcustomers_successful_adding') . ' ' . 
				$item_data['name'], 'id'=>$item_data['id']));
                $id = $item_data['id'];				
            } 
            else 
            { //previous contract
                echo json_encode(array('success' => true, 'message' => lang('contractcustomers_successful_updating') . ' ' .
                    $item_data['name'], 'id' => $id));
            }
        } else {//failure
            echo json_encode(array('success' => false, 'message' => lang('contractcustomers_error_adding_updating') . ' ' .
                $item_data['name'], 'id' => -1));
        }
        /* 	//New item
          if($id==-1)
          {
          echo json_encode(array('success'=>true,'message'=>lang('contractcustomers_successful_adding').' '.$item_data['name'],'id'=>$item_data['id']));
          $id = $item_data['id'];
          }

          else //previous item
          {
          echo json_encode(array('success'=>true,'message'=>lang('contractcustomers_successful_updating').' '.
          $item_data['name'],'id'=>$id));
          }

          }
          else//failure
          {
          echo json_encode(array('success'=>false,'message'=>lang('contractcustomers_error_adding_updating').' '.
          $item_data['name'],'id'=>-1));
          } */
    }
	
    function save1($id = -1) {
        /* upload file info contract customer */
        $config = array(
            'upload_path' => './file/contract',
            'allowed_types' => 'doc|docx|pdf',
        );
        $this->load->library('upload', $config);
        $this->upload->do_upload('contract_file');
        // $file_data_contract_vitae=$this->upload->data(); 
        if (!$this->upload->do_upload('contract_file')) {
            $error = array(
                'errors' => $this->upload->display_errors(),
            );
        } else {
            $file_data_contract_vitae = $this->upload->data();
        }
        if ($id != -1) {
            $data = $this->Contractcustomers->get_info_one_more_contract($id);
            if (empty($file_data_contract_vitae)) {
                $file_data_contract_vitae['file_name'] = $data->contract_file;
            }
        }
		$cus_names=$this->input->post('id_sup1');
		if ($id != -1)  
		{
            $data = $this->Contractcustomers->get_info_one_more_person_id($id);
            if ($cus_names == '') 
			{
                $cus_names = $data->person_id;
            }
        }
        $this->check_action_permission('add_update');
        $start_date = date('Y-m-d', strtotime($this->input->post('contract_start_date')));
        $end_date = date('Y-m-d', strtotime($this->input->post('contract_end_date')));
        $item_data = array(
            'name' => $this->input->post('contractcustomer_name'),
            'description' => $this->input->post('description'),
            'code_contract' => $this->input->post('contractcustomer_code'),
            'number_contract' => $this->input->post('contractcustomer_number'),
            'start_date' => $start_date,
            'end_date' => $end_date,
            'person_id' => $cus_names,
            'catecontract_id' => $this->input->post('contract_type'),
            'contract_file' => $file_data_contract_vitae['file_name'],
        );
        if ($this->Contractcustomers->save($item_data, $id)) 
		{
            if ($id == -1) {
                echo json_encode(array('success' => true, 'message' => lang('contractcustomers_successful_adding') . ' ' . $item_data['name'], 'id' => $item_data['id']));
                $id = $item_data['id'];
            } 
			else { //previous contract
                echo json_encode(array('success' => true, 'message' => lang('contractcustomers_successful_updating') . ' ' .
                    $item_data['name'], 'id' => $id));
            }
        } else {//failure
            echo json_encode(array('success' => false, 'message' => lang('contractcustomers_error_adding_updating') . ' ' .
                $item_data['name'], 'id' => -1));
        }
        /* 	//New item
          if($id==-1)
          {
          echo json_encode(array('success'=>true,'message'=>lang('contractcustomers_successful_adding').' '.$item_data['name'],'id'=>$item_data['id']));
          $id = $item_data['id'];
          }

          else //previous item
          {
          echo json_encode(array('success'=>true,'message'=>lang('contractcustomers_successful_updating').' '.
          $item_data['name'],'id'=>$id));
          }

          }
          else//failure
          {
          echo json_encode(array('success'=>false,'message'=>lang('contractcustomers_error_adding_updating').' '.
          $item_data['name'],'id'=>-1));
          } */
    }

    function sorting()
    {
        $this->check_action_permission('search');
        $search=$this->input->post('search');
        $per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        if ($search)
        {
//            $config['total_rows'] = $this->Contractcustomers->search_count_all($search);
//            $table_data = $this->Contractcustomers->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
            $config['total_rows'] = $this->Contractcustomers->search_count_all_by_employee($this->session->userdata('person_id'),$search);
            $table_data = $this->Contractcustomers->search_by_employee($this->session->userdata('person_id'),$search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
        }
        else
        {
//            $config['total_rows'] = $this->Contractcustomers->count_all();
            $config['total_rows'] = $this->Contractcustomers->count_all_by_employee_id($this->session->userdata('person_id'));
//            $table_data = $this->Contractcustomers->get_all($per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
            $table_data = $this->Contractcustomers->get_all_by_employee($this->session->userdata('person_id'),$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
        }
        $config['base_url'] = site_url('contractcustomer/sorting');
        $config['per_page'] = $per_page; 
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table']=get_contract_customer_manage_table_data_rows($table_data,$this);
        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));	
    }
		
	function search()
	{
            $this->check_action_permission('search');
            $search=$this->input->post('search');
            //$cat=$this->input->post('cat');
            $per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;           
//            $search_data=$this->Contractcustomers->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
            $search_data=$this->Contractcustomers->search_by_employee($this->session->userdata('person_id'),$search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
            $config['base_url'] = site_url('contractcustomer/search');
//            $config['total_rows'] = $this->Contractcustomers->search_count_all($search);
            $config['total_rows'] = $this->Contractcustomers->search_count_all_by_employee($this->session->userdata('person_id'),$search);
            $config['per_page'] = $per_page ;
            $this->pagination->initialize($config);				
            $data['pagination'] = $this->pagination->create_links();
            $data['manage_table']=get_contract_customer_manage_table_data_rows($search_data,$this);
            echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));		
	}

    /// - tro nhung tu tuowng tu trong he thong co san maf ng dung mun tim
    function suggest() {
//        $suggestions = $this->Contractcustomers->get_search_suggestions($this->input->get('term'), 100);
        $suggestions = $this->Contractcustomers->get_search_suggestions_by_employee($this->session->userdata('person_id'),$this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    function item_search() {
        $suggestions = $this->Contractcustomers->get_category_search_suggestions($this->input->get('term'), 100);
        echo json_encode($suggestions);
    }

    function get_row() {
        $id_cat = $this->input->post('row_id');
        $info = $this->Contractcustomers->get_info($id_cat);
        $data_row = get_item_data_row($info, $this);
        echo $data_row;
    }

    //delete
    function delete() {

        $this->check_action_permission('delete');
        $categories_to_delete = $this->input->post('ids');
        $select_inventory = $this->get_select_inventory();
        $total_rows = $select_inventory ? $this->Contractcustomers->count_all() : count($categories_to_delete);
        //clears the total inventory selection
        $this->clear_select_inventory();
//        if ($this->Contractcustomers->delete_list($categories_to_delete)) {
//            echo json_encode(array('success' => true, 'message' => lang('contractcustomers_successful_deleted') . ' ' .
//                $total_rows . ' ' . lang('abouts_one_or_multiple')));
//        } else {
//            echo json_encode(array('success' => false, 'message' => lang('contractcustomers_cannot_be_deleted')));
//        }
         if ($this->Contractcustomers->delete_list($categories_to_delete)) {
            echo json_encode(array('success' => true, 'message' => 'Xóa thành công ' .
                $total_rows . ' ' . lang('abouts_one_or_multiple').' hợp đồng'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Xóa không thành công! '));
        }
    }

    function get_select_inventory() {
        return $this->session->userdata('select_inventory') ? $this->session->userdata('select_inventory') : 0;
    }

    function clear_select_inventory() {
        $this->session->unset_userdata('select_inventory');
    }

    //cleanup
    function cleanup() {
        $this->Contractcustomers->cleanup();
        echo json_encode(array('success' => true, 'message' => lang('contractcustomers_cleanup_sucessful')));
    }

    function get_form_width() {
        return 470;
    }
    function send_mail(){
        $person_id = $this->input->post('person_id');
        $id_contract = $this->input->post('id_contract');
        $info_contract = $this->Contractcustomers->get_info($id_contract);
        $info_cus = $this->Customer->get_info_person_by_id($person_id);
        $info_emp = $this->Employee->get_info($this->session->userdata('person_id'));
        $config = Array( 
            'protocol'  => 'smtp', 
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465, 
            'smtp_user' => $this->config->item('email'), 
            'smtp_pass' => $this->config->item('pass_email'),
            'charset'   => 'utf-8',
            'mailtype'  => 'html'
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from($this->config->item('email'), $this->config->item('company'));
        $mail_info = $this->Customer->get_info_mail($this->config->item('mail_template_contact'));
        $this->email->subject($mail_info->mail_title);
        $content = $mail_info->mail_content;
        //Thong tin khach hang
        $content = str_replace('__FIRST_NAME__', $info_cus['first_name'], $content);
        $content = str_replace('__LAST_NAME__', $info_cus['last_name'], $content);
        $content = str_replace('__PHONE_NUMBER__', $info_cus['phone_number'], $content);
        $content = str_replace('__EMAIL__', $info_cus['email'], $content);
        //Thong tin nhan vien
        $content = str_replace('__FIRST_NAME_EMPLOYEE__', '<b>' . $info_emp->first_name. '</b>', $content);
        $content = str_replace('__LAST_NAME_EMPLOYEE__', $info_emp->last_name, $content);
        $content = str_replace('__PHONE_NUMBER_EMPLOYEE__', $info_emp->phone_number, $content);
        $content = str_replace('__EMAIL_EMPLOYEE__', $info_emp->email, $content);
        //Thong tin hop dong
        $content = str_replace('__NAME_CONTRACT__', $info_contract->name, $content);
        $content = str_replace('__NUMBER_CONTRACT__', $info_contract->number_contract, $content);
        $content = str_replace('__START_DATE__', $info_contract->start_date, $content);
        $content = str_replace('__EXPIRATION_DATE__', $info_contract->end_date, $content);
        //Thong tin chu ky cong ty gui mail
        $content = str_replace('__NAME_COMPANY__', '<b>'.$this->config->item('company').'</b>', $content);
        $content = str_replace('__ADDRESS_COMPANY__',$this->config->item('address'), $content);
        $content = str_replace('__EMAIL_COMPANY__',$this->config->item('email'), $content);
        $content = str_replace('__FAX_COMPANY__', $this->config->item('fax'), $content);
        $content = str_replace('__WEBSITE_COMPANY__', $this->config->item('website'), $content);
        $this->email->message($content);
        $this->email->to($info_cus['email']);
        $this->email->cc($this->config->item('email_cc'));
        $send_success = array();
        $send_fail = array();
        $send_success = array();
        $send_fail = array();
        if($this->email->send()){
            $check = true;
            $data_history = array(
                'person_id'     => $info_cus['person_id'],
                'employee_id'   => 1,
                'title'         => $mail_info->mail_title,
                'content'       => $content,
                'time'          => date('Y-m-d H:i:s'),
                'status'        => 1,                              
            );
            $this->Customer->add_mail_history($data_history);
            redirect('customers');
        }else{
            $check = false;
            $send_fail[] = $info_cus['email'];
            $data_history = array(
                'person_id'     => $info_cus['person_id'],
                'employee_id'   => 1,
                'title'         => $mail_info->mail_title,
                'content'       => $content,
                'time'          => date('Y-m-d H:i:s'),
                'status'        => 0,                              
            );
            $this->Customer->add_mail_history($data_history);
            show_error($this->email->print_debugger());
        }        
    }
}

?>
