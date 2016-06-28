<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class default_home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        session_start();
        $this->load->helper(array('url', 'form'));
        $this->load->model('site/category_model');
        $this->load->model('Sliders');
        $this->load->model('Clips_model');
        $this->load->model('Contacts_admin');
        $this->load->model('Create_invetory');
        $this->load->model('Support_model');
        $this->load->library("pagination");
    }

    /*
     *
     */

    public function index() {
        $data['template'] = 'site/index/index';
        $data['sliders'] = $this->Sliders->get_all_active();
        $data['cooker'] = $this->Sliders->get_slider_cooker_active();
        /* Get 5 categories */
        $data['categories']  = $this->Category->getFiveActiveCategories();
        /* Get Video and Social */
        $data['video'] = $this->Clips_model->video_by_id();
        $data['socials'] = $this->Clips_model->video_by_social();

        $data['hotline'] = $this->Support_model->get_hotline();


        $this->load->view('site/layout', $data);
    }

    public function category() {
        $id = $this->uri->segment(3);

        $start = $this->uri->segment(4);
        $per_page = 7;
        $config['base_url'] = base_url() . 'site/default_home/category/' . $id . '/';
        $config['total_rows'] = $this->category_model->getTotal();
        $config['uri_segment'] = 5;
        $config['per_page'] = $per_page;
        $config['prev_link'] = '<<';
        $config['next_link'] = '>>';
        $config['last_link'] = 'Cuối';
        $config['first_link'] = 'Đầu';
        $this->pagination->initialize($config);

        $data['category_product'] = $this->category_model->get_item_category($id, $per_page, $start);
        $data['template'] = 'site/index/category_product';
        $this->load->view('site/layout', $data);
    }

    public function product_detail() {
        $proid = $this->uri->segment(3);
        $data['product_detail'] = $this->category_model->product_detail($proid);
        $data['template'] = 'site/product/product_detail';
        $this->load->view('site/layout', $data);
    }

    public function search() {
        $keyword = $this->input->post('search');
        $data['search'] = $this->category_model->search_items($keyword);
        $data['template'] = 'site/product/search';
        $this->load->view('site/layout', $data);
    }

    public function contact(){
        /* Get all inventories */
        $data['inventories'] = $this->Create_invetory->get_all_stores_1();
        $data['template'] = 'site/contact/index';
        $data['socials'] = $this->Clips_model->video_by_social();
        $data['hotline'] = $this->Support_model->get_hotline();
        $data['title'] = 'Lien he - Thai2bla';
        $this->load->view('site/layout', $data);
    }

   /*
    *
    */
    public function save_contact(){
         $datacontact = array(
             'fullname'=>$this->input->post('fullname'),
             'title'=>$this->input->post('title'),
             'email'=>$this->input->post('email'),
             'tel'=>$this->input->post('tel'),
             'content'=>$this->input->post('content'),
         );

         $this->Contacts_admin->insert_contact($datacontact);
         $data['template'] = 'site/contact/success';
         $this->load->view('site/layout', $data);
    }
    public function save_abc(){
        $data = array(
        'fullname' => $this->input->post('dfullname'),
        'email' => $this->input->post('demail'),
        'title' => $this->input->post('dtitle'),
        'tel' => $this->input->post('dtel'),
        'content' => $this->input->post('dcontent')
        );
        $this->Contacts_admin->insert_contact($data); // Calling Insert Model and its function.
        $data['template'] = 'site/contact/index';
       // echo "<script>alert('Liên hệ thành công....!!!! ');</script>";
        redirect('lien-he.html', 'refresh');
    }
}
