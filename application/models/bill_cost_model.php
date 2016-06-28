<?php 
   class Bill_cost_model extends CI_Model
   {
   	/*9/11/2015
         * dungchip đẹp zai
         */
   	public function __construct()
   	{
   	   parent::__construct();
           
   	}

   	public function count_all()
   	{
   		$query=$this->db->get('bill_cost');
		return $query->num_rows();
   	}
	function get_chungtus(){
		$query = $this->db->get('bill_cost');
		if($query->num_rows()>0){
			return $query->result_array();
		}else return null;
	}
	public function get_all($limit=10000,$offset=0)
	{
		  $this->db->from('bill_cost');
		  $this->db->limit($limit);
		  $this->db->offset($offset);
                  $this->db->order_by('id','desc');
		  return  $this->db->get();		 
	}

	public function search_count_all($search, $limit=10000)
	{	
			$this->db->from('bill_cost');		
			$this->db->where("id LIKE '%".$this->db->escape_like_str($search)."%'  ");		
			$this->db->order_by("id", "asc");
			$result=$this->db->get();				
			return $result->num_rows();
	}
	public function search($search, $limit=20,$offset=0,$column='id',$orderby='asc')
	{
			$this->db->from('bill_cost');
			$this->db->where("id LIKE '%".$this->db->escape_like_str($search)."%'  ");	
			$this->db->order_by($column, $orderby);
			$this->db->limit($limit);
			$this->db->offset($offset);
			return $this->db->get();	
	}
	public function get_search_suggestions($search,$limit=25){
		$suggestions = array();		
		$this->db->from('bill_cost');		
		$this->db->like("id",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->order_by("id", "asc");		
		$by_company_name = $this->db->get();
		foreach($by_company_name->result() as $row)
		{
			$suggestions[]=array('label' => $row->id);		
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
		$query=$this->db->get('bill_cost');
		return $query->row_array();
	}
 	public  function get_list_customer_types()
 	{
            $this->db->from('bill_cost');
            $this->db->distinct();
            $this->db->order_by("id", "asc");
            return $this->db->get();
     }
    public function exists($custometype_id)
	{
		$this->db->from('bill_cost');	
		$this->db->where('id',$custometype_id);
		$query = $this->db->get();	
		return ($query->num_rows()==1);
	}

	
	public function save(&$customertype_data,$customertype_id=false)
	{
		if (!$customertype_id or !$this->exists($customertype_id))
		{
			if($this->db->insert('bill_cost',$customertype_data))
			{
				$customertype_data['id']=$this->db->insert_id();
				return true;
			}
			return false;
		}
		$this->db->where('id', $customertype_id);

		return $this->db->update('bill_cost',$customertype_data);
	}

	public 	function get_info($customertype_id)
	{
		$this->db->from('bill_cost');
		$this->db->where('id',$customertype_id);
		$query = $this->db->get();
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			$customertype_obj=new stdClass();
			$fields = $this->db->list_fields('bill_cost');
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

		return $this->db->delete('bill_cost');

 	}
	function get_chungtu_search($search,$limit=25){
		$suggestions = array();

		$this->db->from('bill_cost');
		$this->db->like('id', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->order_by("id", "asc");
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=array('value' => $row->id,'name'=>$row->id);
		}
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;
	}
    
        public function get_recv(){
            $this->db->from('costs');
            $this->db->where('deleted',0);
            $this->db->where('form_cost',1);
            $this->db->order_by('id_cost','desc');
            return $this->db->get();
        }
        
        function get_supplier_search_cost($search, $limit = 1000) {
        $suggestions = array();
        //suppliers
        $this->db->join('people', 'suppliers.person_id=people.person_id');
        $this->db->where("company_name LIKE '%" . $this->db->escape_like_str($search) . "%' and deleted=0");
        $this->db->order_by("company_name", "asc");
        $by_name = $this->db->get('suppliers')->result();

        foreach ($by_name as $row) {
            $suggestions[] = array(
                'value' => $row->person_id,
                'label' => $row->company_name,
            );
        }
       
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }
    
} 
?>