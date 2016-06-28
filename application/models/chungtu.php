<?php 
   class Chungtu extends CI_Model
   {
   	
   	public function __construct()
   	{
   	   parent::__construct();
   	}

   	public function count_all()
   	{
   		$query=$this->db->get('chungtus');
		return $query->num_rows();
   	}
	function get_chungtus(){
		$query = $this->db->get('chungtus');
		if($query->num_rows()>0){
			return $query->result_array();
		}else return null;
	}
	public function get_all($limit=10000,$offset=0)
	{
		  $this->db->from('chungtus');
		  $this->db->limit($limit);
		  $this->db->offset($offset);
		  return  $this->db->get();		 
	}

	public function search_count_all($search, $limit=10000)
	{	
			$this->db->from('chungtus');		
			$this->db->where("name LIKE '%".$this->db->escape_like_str($search)."%'  ");		
			$this->db->order_by("name", "asc");
			$result=$this->db->get();				
			return $result->num_rows();
	}
	public function search($search, $limit=20,$offset=0,$column='name',$orderby='asc')
	{
			$this->db->from('chungtus');
			$this->db->where("name LIKE '%".$this->db->escape_like_str($search)."%'  ");	
			$this->db->order_by($column, $orderby);
			$this->db->limit($limit);
			$this->db->offset($offset);
			return $this->db->get();	
	}
	public function get_search_suggestions($search,$limit=25){
		$suggestions = array();		
		$this->db->from('chungtus');		
		$this->db->like("name",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->order_by("name", "asc");		
		$by_company_name = $this->db->get();
		foreach($by_company_name->result() as $row)
		{
			$suggestions[]=array('label' => $row->name);		
		}		
		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;

	}
	public function get_data()
	{
		$query=$this->db->get('chungtus');
		return $query->row_array();
	}
 	public  function get_list_customer_types()
 	{
            $this->db->select(array('id', 'name'));
            $this->db->from('chungtus');
            $this->db->distinct();
            $this->db->order_by("name", "asc");
            return $this->db->get();
     }
    public function exists($custometype_id)
	{
		$this->db->from('chungtus');	
		$this->db->where('id',$custometype_id);
		$query = $this->db->get();	
		return ($query->num_rows()==1);
	}

	
	public function save(&$customertype_data,$customertype_id=false)
	{
		if (!$customertype_id or !$this->exists($customertype_id))
		{
			if($this->db->insert('chungtus',$customertype_data))
			{
				$customertype_data['id']=$this->db->insert_id();
				return true;
			}
			return false;
		}
		$this->db->where('id', $customertype_id);

		return $this->db->update('chungtus',$customertype_data);
	}

	public 	function get_info($customertype_id)
	{
		$this->db->from('chungtus');
		$this->db->where('id',$customertype_id);
		$query = $this->db->get();
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			$customertype_obj=new stdClass();
			$fields = $this->db->list_fields('chungtus');
			foreach ($fields as $field)
			{
				$customertype_obj->$field='';
			}
			return $customertype_obj;
		}

	}
	public function delete_list($customertype_id)

	{

		$this->db->where_in('id',$customertype_id);

		return $this->db->delete('chungtus');

 	}
        
        public function get_all_sale_cost(){
            $this->db->from('sale_cost_tkdu');
            return $this->db->get();
        }
        
	function get_chungtu_search($search,$limit=25){
		$suggestions = array();

		$this->db->from('chungtus');
		$this->db->like('name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->order_by("name", "asc");
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=array('value' => $row->id,'name'=>$row->name,'label' => $row->id.' '.$row->name);
		}
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;
	}
    
    /* --;{(@  --;{(@  --;{(@  --;{(@  --;{(@  --;{(@  --;{(@  --;{(@
         * HAPPY WOMEN'S DAY VIETNAM 20/10/15  
         * from Hưng Audi 
         */
    function save_chungtu_detail($data, $chungtu_id) {
        $this->delete_chungtu_detail($chungtu_id);
        foreach ($data as $r) {
            $this->db->insert('chungtu_detail', $r);
        }
        return true;
    }
    function delete_chungtu_detail($chungtu_id) {
        return $this->db->where('mark', 0)
                        ->delete('chungtu_detail', array('chungtu_id' => $chungtu_id));
    }
    function get_chungtu_detail($chungtu_id) {
        return $this->db->where('chungtu_id', $chungtu_id)
                        ->where('mark', 0)
                        ->get(chungtu_detail);
    }
    
} 
?>