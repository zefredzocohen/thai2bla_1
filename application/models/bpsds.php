<?php 

class Bpsds extends CI_Model {

public function __construct()
	{
		parent::__construct();
		
	}

	function exists($bpsd_id)
	{
		$this->db->from('bpsd');
		$this->db->where('id_bpsd',$bpsd_id);
		//$this->db->where('deleted',0);
		$query = $this->db->get();

		return ($query->num_rows()==1);
	}

	function get_all($limit=100,$offset=0,$col='id_bpsd',$order='asc')
	{
		$this->db->from('bpsd');
		//$this->db->where('deleted',0);
		$this->db->order_by($col, $order);
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();
	}
	
	function count_all()
	{
		$this->db->from('bpsd');
		//$this->db->where('deleted',0);
		return $this->db->count_all_results();
	}

	public function get_info($id) {
        $this->db->from('bpsd');
        $this->db->where('id_bpsd', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            $customertype_obj = new stdClass();
            $fields = $this->db->list_fields('bpsd');
            foreach ($fields as $field) {
                $customertype_obj->$field = '';
            }
            return $customertype_obj;
        }
    }
	function save(&$sup_data,$bpsd_id=false)
	{
		if (!$bpsd_id or !$this->exists($bpsd_id))
		{
			if($this->db->insert('bpsd',$sup_data))
			{
				$sup_data['id_bpsd']=$this->db->insert_id();
				return true;
			}
			return false;
		}

		$this->db->where('id_bpsd', $bpsd_id);
		return $this->db->update('bpsd',$sup_data);
	}
	
	public function search_count_all($search, $limit=10000)
	{	
			$this->db->from('bpsd');		
			$this->db->where("name_bpsd LIKE '%".$this->db->escape_like_str($search)."%'  ");		
			$this->db->order_by("name_bpsd", "asc");
			$result=$this->db->get();				
			return $result->num_rows();
	}
	public function search($search, $limit=20,$offset=0,$column='name_bpsd',$orderby='asc')
	{
			$this->db->from('bpsd');
			$this->db->where("name_bpsd LIKE '%".$this->db->escape_like_str($search)."%'  ");	
			$this->db->order_by($column, $orderby);
			$this->db->limit($limit);
			$this->db->offset($offset);
			return $this->db->get();	
	}
	public function get_search_suggestions($search,$limit=25){
		$suggestions = array();		
		$this->db->from('bpsd');		
		$this->db->like("name_bpsd",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->order_by("name_bpsd", "asc");		
		$by_company_name = $this->db->get();
		foreach($by_company_name->result() as $row)
		{
			$suggestions[]=array('label' => $row->name_bpsd);		
		}		
		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;

	}
	
 	public function get_name_sup($id)
	     {
	     	$this->db->where('id_bpsd',$id);
	     	$query=$this->db->get('nhomts_thietbi');
	     	$data['result']=$query->row_array();
	     	return $data['result']['name_sup_type'];
	     }
 	public function delete_db($id)
	{
		$this->db->where_in('id_bpsd',$id);
		  if( $this->db->delete('bpsd')){
		   return true;
		  }else return $this->db->_error_message();
	}

	 public function get_select_dropdown_bp()
   {

		$this->db->from('bpsd');		
		return $this->db->get()->result_array();		

   }

	

}

/* End of file bpsds.php */
/* Location: ./application/models/bpsds.php */