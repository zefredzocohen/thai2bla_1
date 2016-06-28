<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


class agent extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        session_start();
        $this->load->helper(array('url','form'));
        $this->load->model('site/category_model');
        $this->load->model('Clips_model');
        $this->load->model('Support_model');
        $this->load->model('Agent_model');
        $this->load->library('sale_lib');
        $this->load->helper("security");
    }
    
    public function index(){
        $data['cus_type'] = $this->category_model->get_Customer_type();
        $data['socials'] = $this->Clips_model->video_by_social();
        $data['hotline'] = $this->Support_model->get_hotline();
        $data['template'] = 'site/agent/register';
        $this->load->view('site/layout',$data);
    }
    
    public function register(){
         $people = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'phone_number' => $this->input->post('phone'),
            'email' => $this->input->post('email'),
            'password' => md5($this->input->post('password')),
            'address_1' => $this->input->post('address'),
            'comments' => $this->input->post('comment'),
            'register_date' => date('Y-m-d')
        );

        $person_id = $this->category_model->register_people($people);
        
       
        $customner = array(
            'person_id' => $person_id,
            'account_number' => $this->input->post('account_number'),
            'code_tax' => $this->input->post('code_tax'),
            'company_name' => $this->input->post('company'),
            'sex' => $this->input->post('sex'),
            'type_customer' => $this->input->post('cus_type'),
            'manages_name' => $this->input->post('manage_name'),
            'agent' => $this->sale_lib->get_agent() ? $this->sale_lib->get_agent() :0,
            'status'=>1,
            'status_register' => 0,
            
        );
         $this->sale_lib->clear_all();
        $this->category_model->register_customer($customner);

        $data['template'] = 'site/agent/register_success';
        $this->load->view('site/layout', $data);
    
    }
    
    function suggest_code() {
        $suggestions = $this->Agent_model->get_search_suggestions_code($this->session->userdata('person_id'), $this->input->get('term'), 100);
        echo json_encode($suggestions);
    }
    
    
     function set_agent() {
        $this->sale_lib->set_agent($this->input->post('agent'));
    }
    
    public function login(){
        $data['template'] = 'site/agent/login';
        $this->load->view('site/layout', $data);
    }
    
     public function check_login() {
        $email = $this->security->xss_clean($this->input->post('email'));
        $password = $this->security->xss_clean($this->input->post('password'));
                $query = $this->category_model->check_login($email, $password);
                if($query) {
                       foreach($query as $row){
                        $_SESSION['user'] = $row->person_id;                
                        redirect(base_url());
                     }
                    
                } else{
                     
                    echo "<script>alert('Sai Email hoặc Mật Khẩu')</script>";
                    $data['template'] = 'site/agent/login';
                    $this->load->view('site/layout', $data);
                }
        
    }
     public function logout(){
        session_destroy();
        redirect(base_url());
    }
    
    public function tag_log(){
        $data['template'] = 'site/agent/tag_log';
        $this->load->view('site/layout', $data);
    }
}