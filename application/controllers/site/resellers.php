<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class resellers extends CI_Controller {
/*
 * 
 */
    public function __construct() {
        parent::__construct();
        $this->load->helper(array('url', 'form'));
        $this->load->model('site/category_model');
        $this->load->model('Clips_model');
        $this->load->library("pagination");
    }
    /*
     * 
     */
    public function index(){
        $data['list_rese'] = $this->category_model->list_resellers();
        $data['socials'] = $this->Clips_model->video_by_social();
        $data['template'] = 'site/resellers/index';
        $this->load->view('site/layout',$data);
    }
    /*
     * 
     */
    public function detail(){
        $newid = $this->uri->segment(4);
        $data['detail'] = $this->category_model->detail_resellers($newid);
        $data['template'] = 'site/resellers/detail';
        $this->load->view('site/layout',$data);
    }
}
