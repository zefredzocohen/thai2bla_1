<?php

class Bieudos extends CI_Model {
	 public function __construct()
	 {
	 	parent::__construct();
	 	
	 }
		
	  function get_data()
    {
         $this->db->select('month, wordpress, codeigniter, highcharts');
		$this->db->from('project_requests');
		$query = $this->db->get();
       	return $query->result();
    }
}

/* End of file bieudos.php */
/* Location: ./application/models/bieudos.php */