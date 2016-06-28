<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class news_home extends CI_Controller {
/*
 *
 */
    public function __construct() {
        parent::__construct();
        $this->load->helper(array('url', 'form'));
        $this->load->model('site/category_model');
        $this->load->model('Clips_model');
    }
    /*
     *
     */
    public function index(){
        $data['list_news'] = $this->category_model->list_news();
        $data['list_news_baochi'] = $this->category_model->list_news_baochi();
        $data['list_news_tuyendung'] = $this->category_model->list_news_tuyendung();
        $data['socials'] = $this->Clips_model->video_by_social();
        $data['template'] = 'site/news/index';
        $data['title']='Tin tuc - Thai2bla';
        $this->load->view('site/layout',$data);
    }
    /*
     *
     */
    public function detail(){
        $url = $this->uri->segment(2);
        $data['detail'] = $this->category_model->getNewsByUrl($url);
		$url = strtolower($url);
        if(preg_match('/^(thai2.bla|thai.2bla|thai..bla)(.+?)$/', $url,$_title)){
            $data['title'] = $_title[2];
        }  else {
            $data['title'] =$url;
        }
        $data['title'] = trim(preg_replace('/[-]{1,}/', ' ', $data['title']));
		$data['title'] = trim(ucfirst(strtolower($data['title']))).' - Thai2bla';
        $data['template'] = 'site/news/detail';
        $this->load->view('site/layout',$data);
    }
}
