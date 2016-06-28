<?php 
   class Dttc extends CI_Model
   {
   	
   	public function __construct()
   	{
   	   parent::__construct();
   	}

   	public function count_all()
   	{
   		$query=$this->db->get('dttcs');
		return $query->num_rows();
   	}
	function get_dttcs(){
		$query = $this->db->get('dttcs');
		if($query->num_rows()>0){
			return $query->result_array();
		}else return null;
	}
	public function get_all($limit=10000,$offset=0)
	{
		  $this->db->from('dttcs');
		  $this->db->limit($limit);
		  $this->db->offset($offset);
		  return  $this->db->get();		 
	}

	public function search_count_all($search, $limit=10000)
	{	
			$this->db->from('dttcs');		
			$this->db->where("name LIKE '%".$this->db->escape_like_str($search)."%'  ");		
			$this->db->order_by("name", "asc");
			$result=$this->db->get();				
			return $result->num_rows();
	}
	public function search($search, $limit=20,$offset=0,$column='name',$orderby='asc')
	{
			$this->db->from('dttcs');
			$this->db->where("name LIKE '%".$this->db->escape_like_str($search)."%'  ");	
			$this->db->order_by($column, $orderby);
			$this->db->limit($limit);
			$this->db->offset($offset);
			return $this->db->get();	
	}
	public function get_search_suggestions($search,$limit=25){
		$suggestions = array();		
		$this->db->from('dttcs');		
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
		$query=$this->db->get('dttcs');
		return $query->row_array();
	}
 	public  function get_list_customer_types()
 	{
            $this->db->select(array('id', 'name'));
            $this->db->from('dttcs');
            $this->db->distinct();
            $this->db->order_by("name", "asc");
            return $this->db->get();
     }
    public function exists($custometype_id)
	{
		$this->db->from('dttcs');	
		$this->db->where('id',$custometype_id);
		$query = $this->db->get();	
		return ($query->num_rows()==1);
	}

	
	public function save(&$customertype_data,$customertype_id=false)
	{
		if (!$customertype_id or !$this->exists($customertype_id))
		{
			if($this->db->insert('dttcs',$customertype_data))
			{
				$customertype_data['id']=$this->db->insert_id();
				return true;
			}
			return false;
		}
		$this->db->where('id', $customertype_id);

		return $this->db->update('dttcs',$customertype_data);
	}

	public 	function get_info($var_id)
	{
		$this->db->from('dttcs');
		$this->db->where('id',$var_id);
		$query = $this->db->get();
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			$customertype_obj=new stdClass();
			$fields = $this->db->list_fields('dttcs');
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

		return $this->db->delete('dttcs');

 	}
	function get_all_dttc_details_thu($id){
		$this->db->where('id_dttc',$id);
		$this->db->where('method',0);
		$query = $this->db->get('dttcs_detail');
		if($query!=null){
			return $query->result_array();
		}else return null;
	}
	
	function get_all_dttc_details($id){
		$this->db->where('id_dttc',$id);
		$query = $this->db->get('dttcs_detail');
		if($query!=null){
			return $query->result_array();
		}else return null;
	}
	
	function get_all_dttc_details_chi($id){
		$this->db->where('id_dttc',$id);
		$this->db->where('method',1);
		$query = $this->db->get('dttcs_detail');
		if($query!=null){
			return $query->result_array();
		}else return null;
	}
	function save_dttc_detail($save_data){
		$this->db->insert('dttcs_detail',$save_data);
	}
	function get_detail_dttc($id){
		$this->db->where('id',$id);
		$query = $this->db->get('dttcs_detail');
		if($query!=null){
			return $query->row();
		}else return null;
	}
	function update_lapkehoach($id_dttc_detail,$save_data){
		$this->db->where('id',$id_dttc_detail);
		$this->db->update('dttcs_detail',$save_data);
	}
   } 
?>