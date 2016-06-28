<?php 

class Slideshows extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}
	// public function get_all()
	// {
	// 	// $this->db->from('slide');
	// 	// $this->db->where('active',1);
	// 	// return $this->db->get();
	// 	$query=$this->db->get('slide');
	// 	return $query->result_array();
	//}
	// 
		function get_all()
	{
		
		// $this->db->from('slide');
		// $this->db->where('active',1);
		// $this->db->order_by($col, $order);
		// $this->db->limit($limit);
		// $this->db->offset($offset);
		// return $this->db->get();
		$this->db->where('active',1);
		$query=$this->db->get('slide');
	 	return $query->result_array();
	}

		function count_all()
	{
		$this->db->from('slide');
		$this->db->where('active',1);
		return $this->db->count_all_results();
	}

}

/* End of file slideshows.php */
/* Location: ./application/models/slideshows.php */