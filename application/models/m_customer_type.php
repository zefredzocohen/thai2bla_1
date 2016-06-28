<?php 
   class M_customer_type extends CI_Model
   {
	//check trùng tên
   	function getname( $id){
		if( $id > 0 ){
			$this->db->select('name');
			$this->db->where('customer_type_id !=', $id);
			$this->db->from('customer_type');
			$query= $this->db->get();
		}elseif( $id =-1 ){
			$this->db->select('name');
			$this->db->from('customer_type');
			$query= $this->db->get();
		}
		foreach($query->result_array() as $q)
		{
			$result[] =	$q;
		}
		return $result;
	}
   	
   	public function count_all()
   	{
   		$query=$this->db->get('customer_type');
		return $query->num_rows();
   	}
   	function get_all2($limit=10000, $offset=0,$col='customer_type_id',$order='desc')
	{
		$this->db->from('customer_type');
		$this->db->order_by($col, $order);
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();
	}
	public function get_all($limit=10000,$offset=0)
	{
		  $this->db->from('customer_type');
		  $this->db->limit($limit);
		  $this->db->offset($offset);
		  return  $this->db->get();		 
	}

	public function search_count_all($search, $limit=10000)
	{	
			$this->db->from('customer_type');		
			$this->db->where("name LIKE '%".$this->db->escape_like_str($search)."%'  ");		
			$this->db->order_by("name", "asc");
			$result=$this->db->get();				
			return $result->num_rows();
	}
	public function search($search, $limit=20,$offset=0,$column='name',$orderby='asc')
	{
			$this->db->from('customer_type');
			$this->db->where("name LIKE '%".$this->db->escape_like_str($search)."%'  ");	
			$this->db->order_by($column, $orderby);
			$this->db->limit($limit);
			$this->db->offset($offset);
			return $this->db->get();	
	}
	public function get_search_suggestions($search,$limit=25){
		$suggestions = array();		
		$this->db->from('customer_type');		
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
		$query=$this->db->get('customer_type');
		return $query->row_array();
	}
 	public  function get_list_customer_types()
 	{
            $this->db->select(array('customer_type_id', 'name'));
            $this->db->from('customer_type');
            $this->db->distinct();
            $this->db->order_by("name", "asc");
            return $this->db->get();
     }
    public function exists($custometype_id)
	{
		$this->db->from('customer_type');	
		$this->db->where('customer_type_id',$custometype_id);
		$query = $this->db->get();	
		return ($query->num_rows()==1);
	}

	
	public function save(&$customertype_data,$customertype_id=false)
	{
		if ($customertype_id == -1)
		{
			if($this->db->insert('customer_type',$customertype_data))
			{
				$customertype_data['customer_type_id'] = $this->db->insert_id();
				return true;
			}
			return false;
		}
		$this->db->where('customer_type_id', $customertype_id);
		return $this->db->update('customer_type',$customertype_data);
	}

	public 	function get_info($customertype_id)
	{
		$this->db->from('customer_type');
		$this->db->where('customer_type_id',$customertype_id);
		$query = $this->db->get();
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			$customertype_obj=new stdClass();
			$fields = $this->db->list_fields('customer_type');
			foreach ($fields as $field)
			{
				$customertype_obj->$field='';
			}
			return $customertype_obj;
		}

	}
	public function delete_list($customertype_id)

	{

		$this->db->where_in('customer_type_id',$customertype_id);

		return $this->db->delete('customer_type');

 	}
        //Created by San
        //Lay thong tin loai khach hang theo ma loai khach hang
        function get_customer_type_by_code($code){
            $this->db->where("code",$code);
            $query = $this->db->get("customer_type");
            return $query->row_array();
        }
   } 
?>