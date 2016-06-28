<?php 
   class Template extends CI_Model
   {
   	
   	public function __construct()
   	{
   	   parent::__construct();
   	}

   	public function count_all()
   	{
   		$query=$this->db->get('templates_contract');
		return $query->num_rows();
   	}
	public function set_null_primary($cat){
		$this->db->where('category',$cat);
		$this->db->update('templates_contract',array('primary'=>0));
	}
	public function get_all($limit=10000,$offset=0)
	{
		  $this->db->from('templates_contract');
		  $this->db->limit($limit);
		  $this->db->offset($offset);
		  return  $this->db->get();		 
	}
	
	public function get_info_cat($cat)
	{
		$this->db->where('category',$cat);
		$this->db->where('primary',1);
		$query = $this->db->get('templates_contract');
		if($query->num_rows()>0){
			return $query->row();
		}else return null ;
	}
	
	public function search_count_all($search, $limit=10000)
	{	
			$this->db->from('templates_contract');		
			$this->db->where("name LIKE '%".$this->db->escape_like_str($search)."%'  ");		
			$this->db->order_by("name", "asc");
			$result=$this->db->get();				
			return $result->num_rows();
	}
	public function search($search, $limit=20,$offset=0,$column='name',$orderby='asc')
	{
			$this->db->from('templates_contract');
			$this->db->where("name LIKE '%".$this->db->escape_like_str($search)."%'  ");	
			$this->db->order_by($column, $orderby);
			$this->db->limit($limit);
			$this->db->offset($offset);
			return $this->db->get();	
	}
	public function get_search_suggestions($search,$limit=25){
		$suggestions = array();		
		$this->db->from('templates_contract');		
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
		$query=$this->db->get('templates_contract');
		return $query->row_array();
	}
	public  function get_list_group_type()
 	{
            $this->db->select(array('id', 'name'));
            $this->db->from('groups_asset');
            $this->db->distinct();
            $this->db->order_by("name", "asc");
            return $this->db->get();
     }
	public  function get_list_ppkh_type()
 	{
            $this->db->select(array('id', 'name'));
            $this->db->from('ppkh');
            $this->db->distinct();
            $this->db->order_by("name", "asc");
            return $this->db->get();
     }
 	public  function get_list_customer_types()
 	{
            $this->db->select(array('id', 'name'));
            $this->db->from('templates_contract');
            $this->db->distinct();
            $this->db->order_by("name", "asc");
            return $this->db->get();
     }
    public function exists($custometype_id)
	{
		$this->db->from('templates_contract');	
		$this->db->where('id',$custometype_id);
		$query = $this->db->get();	
		return ($query->num_rows()==1);
	}

	
	public function save(&$var_data,$var_id=false)
	{
		if (!$var_id or !$this->exists($var_id))
		{
			if($this->db->insert('templates_contract',$var_data))
			{
				$var_data['id']=$this->db->insert_id();
				return true;
			}
			return false;
		}
		$this->db->where('id', $var_id);

		return $this->db->update('templates_contract',$var_data);
	}

	public 	function get_info($customertype_id)
	{
		$this->db->from('templates_contract');
		$this->db->where('id',$customertype_id);
		$query = $this->db->get();
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			$customertype_obj=new stdClass();
			$fields = $this->db->list_fields('templates_contract');
			foreach ($fields as $field)
			{
				$customertype_obj->$field='';
			}
			return $customertype_obj;
		}

	}
	public function delete_list($var_id)

	{

		$this->db->where_in('id',$var_id);

		return $this->db->delete('templates_contract');

 	}

   } 
?>