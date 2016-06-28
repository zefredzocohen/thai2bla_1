<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class category_model extends CI_Model{

    /*
     *
     */
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    /*
     *
     */
    public function get_all($service){
      
        $this->db->where('cat_service',$service);
        $this->db->where('deleted',0);
        $this->db->where('active',1);
        
        return $this->db->get('categories_item')->result_array();
    }

    /*
     *
     */
    public function get_new_item(){
        $this->db->order_by('item_id','desc');
        $this->db->where('deleted',0);
        $this->db->limit(4);
        return $this->db->get('items')->result();
    }
    /*
     *
     */
    public function get_advenced(){
        $this->db->order_by('top','desc');
        $this->db->where('deleted',0);
        $this->db->where('top !=',0);
        return $this->db->get('items');
    }
    
    public function get_advenced_promo($now_date = ''){
        if($now_date==''){
            $now_date = date('Y/m/d');
        }
        $this->db->order_by('top','desc');
        $this->db->where('deleted',0);
        $this->db->where('top !=',0);
        $this->db->where('start_date <=',$now_date);
        $this->db->where('end_date >=',$now_date);
        return $this->db->get('items');
//        return $this->db->last_query();
    }
    
    /*
     *
     */
    public function get_item_category($id_cat,$per_page='',$start=0){
        $this->db->limit($per_page, $start);
        $this->db->where('category',$id_cat);
        $this->db->where('deleted',0);
        return $this->db->get('items')->result();
    }

    /*
     *
     */
     public function getTotal() {
        return $this->db->count_all($this->items);
    }
    /*
     *
     */
    function get_info($item_id) {
        $this->db->from('items');
        $this->db->where('item_id', $item_id);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //Get empty base parent object, as $item_id is NOT an item
            $item_obj = new stdClass();

            //Get all the fields from items table
            $fields = $this->db->list_fields('items');

            foreach ($fields as $field) {
                $item_obj->$field = '';
            }

            return $item_obj;
        }
    }
    /*
     *
     */
    function get_info1($id_unit) {
        $this->db->from('units');
        $this->db->where('id_unit', $id_unit);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            $item_obj = new stdClass();
            $fields = $this->db->list_fields('units');
            foreach ($fields as $field) {
                $customertype_obj->$field = '';
            }
            return $customertype_obj;
        }
    }
    /*
     *
     */
    function get_search_suggestions_code($person_id, $search, $limit = 25) {
        $suggestions = array();
        $this->db->from('customers');
        $this->db->where('deleted', 0);
         $this->db->where('status',1);
        // if ($person_id != 1) {
           // $this->db->where('person_id', $person_id);
         //}
        $this->db->like("code_customer", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $by_email = $this->db->get();
        foreach ($by_email->result() as $row) {
            if($row->code_customer!=''){
             $suggestions[] = array(
                 'label' => $row->code_customer,
                 'value' => $row->person_id,
                 );
            }
        }


        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }
    /*
     *
     */
    public function register_people($data){
        $this->db->insert('people',$data);
        $person_id = $this->db->insert_id();
        return (isset($person_id)) ? $person_id : FALSE;
    }
    /*
     *
     */
    public function register_customer($data){
         $this->db->insert('customers',$data);
    }
    /*
     *
     */
    public function check_login($email, $password){
		$this->db->from('people');
                $this->db->join('customers','people.person_id = customers.person_id');
                $this->db->where('deleted',0);
		$this->db->where('email', $email);
		$this->db->where('password', md5($password));
		$query = $this->db->get();
		if($query->num_rows() == 1)
		{
			//return true;
                    return $query->result();
		}
		else
		{
			return false;
		}
	}

        public function insert_sale($data) {
        $this->db->insert('sales', $data);
        $sale_id = $this->db->insert_id();
        return (isset($sale_id)) ? $sale_id : FALSE;
    }
/*
 *
 */
   public function insert_sale_item($data) {
        $this->db->insert('sales_items', $data);
    }
/*
 *
 */
    public function insert_sale_payment($data) {
        $this->db->insert('sales_payments', $data);
    }
/*
 *
 */
    public function insert_sale_tam($data) {
        $this->db->insert('sales_tam', $data);
    }
  /*
   *
   */
    public function insert_inventory($data) {
        $this->db->insert('inventory', $data);
    }
    /*
     *
     */
    public function product_detail($item_id){
        $this->db->where('item_id',$item_id);
        return $this->db->get('items')->row();
    }

    /*
     *
     */
    public function similar($category){
        $this->db->where('category',$category);
        $this->db->where('deleted',0);
        $this->db->limit(3);
        return $this->db->get('items')->result();
    }
    /*
     *
     */
     function get_Customer_type() {
        $this->db->where('status_agent',1);
        $query = $this->db->get('customer_type');
        return $query->result_array();
    }
    /*
     *
     */
    public function list_news(){
        $this->db->where('category_id',20);
        $this->db->where('active',1);
        return $this->db->get('news')->result();
    }
    /*
     *
     */
    public function list_news_baochi(){
        $this->db->where('category_id',17);
        $this->db->where('active',1);
        return $this->db->get('news')->result();
    }
    /*
     *
     */
    public function list_news_tuyendung(){
        $this->db->where('category_id',18);
        $this->db->where('active',1);
        return $this->db->get('news')->result();
    }
    /*
     *
     */
    public function detail(){
        return $this->db->get('news')->row();
    }

    public function getNewsByUrl($url){
        $this->db->where('url', $url);
        return $this->db->get('news')->row();
    }
    /*
     *
     */
      public function search_items($keyword){
        $this->db->like('name',$keyword);
        $this->db->where('deleted',0);
        return $this->db->get('items')->result();
    }

    /*
     *
     */
     public function support(){
        $this->db->from('support');
        return $this->db->get()->result();
    }

     /*
     *
     */
    public function list_resellers(){
        return $this->db->get('resellers')->result();
    }
    /*
     *
     */
    public function detail_resellers(){
        return $this->db->get('resellers')->row();
    }

     /*
     *
     */
    public function list_sulotions(){
        return $this->db->get('solutions')->result();
    }
    /*
     *
     */
    public function detail_solutions(){
        return $this->db->get('solutions')->row();
    }

          /*
     *
     */
    public function list_introductions(){
        return $this->db->get('introductions')->result();
    }
    /*
     *
     */
    public function detail_introductions(){
        return $this->db->get('introductions')->row();
    }
}
