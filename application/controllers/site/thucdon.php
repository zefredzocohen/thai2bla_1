<?php

class Thucdon extends CI_Controller {

    public function __construct() {
        parent::__construct();
        session_start();
        $this->load->helper(array('url', 'form'));
        $this->load->model('category');
        $this->load->model('Clips_model');
        $this->load->model('Support_model');
        $this->load->model('item');
    }

    public function index($page = 1) {
        $data['template']    = 'site/thucdon/index';
        /* Get 5 categories */
        $data['categories']  = $this->Category->getFiveActiveCategories();
        /* Get all items */
        $data['items']       = $this->Item->getListItems($page);
        /* Get all inventories */
        $inventories = array('' => 'Tỉnh/Thành phố');
        foreach ($this->Create_invetory->get_all()->result() as $row) {
            $inventories[$row->id] = $row->name_inventory;
        }
        $data['inventories'] = $inventories;
        /* Init pagination */
        $this->load->library("pagination");
        $this->pagination->initialize($this->configPagination(site_url('thuc-don'), $this->Item->count_all(), $page, 6));
        $data['pagination'] = $this->pagination->create_links();
        /* Get session cart data */
        if ( isset( $_SESSION['cart'] ) ) {
            $data['cart'] = $_SESSION['cart'];
        }
        $data['socials'] = $this->Clips_model->video_by_social();
        $data['hotline'] = $this->Support_model->get_hotline();
        $data['title'] = 'Thuc don - Thai2bla';
        $this->load->view('site/layout', $data);
    }

    function getListItemsByCategoryUrl($cat_url = '', $page = 1) {
        $data['template']   = 'site/thucdon/index';
        /* Get 5 categories */
        $data['categories'] = $this->Category->getFiveActiveCategories();
        /* Get all items */
        $data['items']      = $this->Item->getListItemsByCategoryUrl($cat_url, $page);
        /* Get all inventories */
        $inventories = array('' => 'Tỉnh/Thành phố');
        foreach ($this->Create_invetory->get_all()->result() as $row) {
            $inventories[$row->id] = $row->name_inventory;
        }
        $data['inventories'] = $inventories;
        /* Init pagination */
        $this->pagination->initialize($this->configPaginationCategory(site_url('thuc-don/'.$cat_url), $this->Item->countAllItemsByCategoryUrl($cat_url), $page, 6));
        $data['pagination'] = $this->pagination->create_links();
        /* Get session cart data */
        if ( isset( $_SESSION['cart'] ) ) {
            $data['cart'] = $_SESSION['cart'];
        }

        $this->load->view('site/layout', $data);
    }

    function configPagination($base_url, $total_rows, $cur_page, $per_page) {
        $config['base_url']         = $base_url;
        $config['cur_page']         = $cur_page;
        $config['suffix']           = '.html';
        $config['first_url']        = '1.html';
        $config['total_rows']       = $total_rows;
        $config['per_page']         = $per_page;
        $config['use_page_numbers'] = true;
        $config['uri_segment']      = 2;
        /* Config full tag */
        $config['full_tag_open']    = '<ul class="pagination">';
        $config['full_tag_close']   = '</ul>';
        /* Config first link */
        $config['first_link']       = 'Trang đầu';
        $config['first_tag_open']   = '<li class="first-page">';
        $config['first_tag_close']  = '</li>';
        /* Config last link */
        $config['last_link']        = 'Trang cuối';
        $config['last_tag_open']    = '<li class="last-page">';
        $config['last_tag_close']   = '</li>';
        /* Config next link */
        $config['next_link']        = '';
        $config['next_tag_open']    = '<li class="next-page">';
        $config['next_tag_close']   = '</li>';
        /* Config previous link */
        $config['prev_link']        = '';
        $config['prev_tag_open']    = '<li class="prev-page">';
        $config['prev_tag_close']   = '</li>';
        /* Config current link */
        $config['cur_tag_open']     = '<li><a href="" class="active">';
        $config['cur_tag_close']    = '</a></li>';
        /* Config digit link */
        $config['num_tag_open']     = '<li class="page">';
        $config['num_tag_close']    = '</li>';

        return $config;
    }

    function configPaginationCategory($base_url, $total_rows, $cur_page, $per_page) {
        $config['base_url']         = $base_url;
        $config['cur_page']         = $cur_page;
        $config['suffix']           = '.html';
        $config['first_url']        = '1.html';
        $config['total_rows']       = $total_rows;
        $config['per_page']         = $per_page;
        $config['use_page_numbers'] = true;
        $config['uri_segment']      = 3;
        /* Config full tag */
        $config['full_tag_open']    = '<ul class="pagination">';
        $config['full_tag_close']   = '</ul>';
        /* Config first link */
        $config['first_link']       = 'Trang đầu';
        $config['first_tag_open']   = '<li class="first-page">';
        $config['first_tag_close']  = '</li>';
        /* Config last link */
        $config['last_link']        = 'Trang cuối';
        $config['last_tag_open']    = '<li class="last-page">';
        $config['last_tag_close']   = '</li>';
        /* Config next link */
        $config['next_link']        = '';
        $config['next_tag_open']    = '<li class="next-page">';
        $config['next_tag_close']   = '</li>';
        /* Config previous link */
        $config['prev_link']        = '';
        $config['prev_tag_open']    = '<li class="prev-page">';
        $config['prev_tag_close']   = '</li>';
        /* Config current link */
        $config['cur_tag_open']     = '<li><a href="" class="active">';
        $config['cur_tag_close']    = '</a></li>';
        /* Config digit link */
        $config['num_tag_open']     = '<li class="page">';
        $config['num_tag_close']    = '</li>';

        return $config;
    }
}
