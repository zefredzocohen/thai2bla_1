<?php
class Receiving_order extends CI_Model{
	function get_all($limit=10000,$offset=0, $col = 'receiving_id', $order = 'desc'){
		 $this->db->from('receivings')
		 		->where('deleted', 0)
		 		->order_by($col, $order)
		 		->limit($limit)
		 		->offset($offset);
		 return $this->db->get();
	}
	public function count_all(){
   		$query=$this->db->where('deleted', 0)
   						->get('receivings');
		return $query->num_rows();
   	}
	function get_search_suggestions($search, $limit = 25) {
        $suggestions = array();
        $this->db->from('receivings')
        		->like('receiving_id', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both')
        		->where('deleted', 0)
        		->order_by("receiving_id", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('label' => $row->receiving_id);
        }

        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }
	function search_count_all( $start_date, $end_date, $search) {
		$start_date2 = "and receiving_time >= '$start_date'";
		$end_date2 = "and receiving_time <= '$end_date'"; 
        $this->db->from('receivings')
        		->where("(receiving_id LIKE '%" . $this->db->escape_like_str($search) . "%' )
                $start_date2 $end_date2 ");
        $this->db->where('deleted',0);
        $result = $this->db->get();
        return $result->num_rows();
    }
	function search( $start_date, $end_date, $search, $limit = 20, $offset = 0, $column = 'receiving_id', $orderby = 'desc') {    
		$start_date2 = "and receiving_time >= '$start_date'";
		$end_date2 = "and receiving_time <= '$end_date'";
		$this->db->from('receivings')
				->where("( receiving_id LIKE '%" . $this->db->escape_like_str($search) . "%' )
                	 $start_date2 $end_date2 ")
				->order_by($column, $orderby)
				->limit($limit)
				->offset($offset);
                $this->db->where('deleted',0);
        return $this->db->get();
    }
	
//xác nhận hóa đơn nhập	
    function get_info_receving($receiving_id) {
        $this->db->from('receivings');
        $this->db->where('receiving_id',$receiving_id);
        return $this->db->get()->row();
    }

    
    public function get_receiving_item(){
        return $this->db->get('receivings_items')->result_array();
    }
    
    public function update_receiving_status($data,$receiving_id){
        $this->db->where('receiving_id',$receiving_id);
        $this->db->update('receivings',$data);
    }
    
  
    
}
