<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class introductions extends CI_Controller {
/*
 * 
 */
    public function __construct() {
        parent::__construct();
        $this->load->helper(array('url', 'form'));
        $this->load->model('site/category_model');
        $this->load->model('Clips_model');
        $this->load->model('Support_model');
        $this->load->library("pagination");
        $this->load->model('introduction');
    }
    /*
     * 
     */
    public function index(){
        $data['template'] = 'site/introductions/index';
        $data['list_rese'] = $this->category_model->list_introductions();
        $data['videos'] = $this->Clips_model->video_by_id();
        $data['socials'] = $this->Clips_model->video_by_social();
        $data['hotline'] = $this->Support_model->get_hotline();
        $data['title'] = 'Gioi thieu - Thai2bla';
        $this->load->view('site/layout',$data);
    }
    /*
     * 
     */
    public function detail(){
        $newid = $this->uri->segment(4);
        $data['detail'] = $this->category_model->detail_introductions($newid);
        $data['template'] = 'site/introductions/detail';
        //$data['video'] = $this->Clips_model->get_all();
        $data['title'] = 'Thai2bla - '.$newid;
        $this->load->view('site/layout',$data);
    }
}
