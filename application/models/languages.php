<?php 
class Languages extends CI_Model
{
	function exists($id)
	{
		$this->db->from('language');
		$this->db->where('id_language',$id);
		$query = $this->db->get();

		return ($query->num_rows()==1);
	}
	
	function get_all($limit=100, $offset=0,$col='id_language',$order='asc')
	{
		$this->db->from('language');
		$this->db->order_by($col, $order);
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();
	}
	function count_all()
	{
		$this->db->from('language');
		$this->db->where('deleted',0);
		return $this->db->count_all_results();
	}
	
	function save(&$item_data,$id=false)
	{
		if ($id ==-1 OR empty($id))
		{
			if($this->db->insert('language',$item_data))
			{
				$item_data['id_language']=$this->db->insert_id();
				return true;
			}
			return false;
		}
		
		$this->db->where('id_language',$id);
		return $this->db->update('language',$item_data);
			
	}
	
	//lay thong tin form :)
	function get_info($id)
	{
		//$this->db->select('id,name , parentid');
		$this->db->from('language');
		$this->db->where('id_language',$id);
		$query = $this->db->get();

		if($query->num_rows()== 1)
		{
			return $query->row();
		}
		else
		{
			//Get empty base parent object, as $item_id is NOT an item
			$item_obj=new stdClass();

			//Get all the fields from items table
			$fields = $this->db->list_fields('language');

			foreach ($fields as $field)
			{
				$item_obj->$field='';
			}

			return $item_obj;
		}
	}	
	//sorting goi
	public function search_count_all($search, $limit=10000)
	{	
			$this->db->from('language');		
			$this->db->where("name_language LIKE '%".$this->db->escape_like_str($search)."%'  ");		
			$this->db->order_by("name_language", "asc");
			$result=$this->db->get();				
			return $result->num_rows();
	}
	
	public function search($search, $limit=10,$offset=0,$column='name_language',$orderby='asc')
	{
			$this->db->from('language');
			$this->db->where("name_language LIKE '%".$this->db->escape_like_str($search)."%'  ");	
			$this->db->order_by($column, $orderby);
			$this->db->limit($limit);
			$this->db->offset($offset);
			return $this->db->get();	
	}
	public function get_search_suggestions($search,$limit=10){
		$suggestions = array();		
		$this->db->from('language');		
		$this->db->like("name_language",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->order_by("name_language", "asc");		
		$by_company_name = $this->db->get();
		foreach($by_company_name->result() as $row)
		{
			$suggestions[]=array('label' => $row->name_language);		
		}		
		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;

	}
	/// - tim kiem
	
	
	// xo chu khi nhap gtri search
	
	
	public function delete_db($id)
	{
		$this->db->where_in('id_language',$id);
		  if( $this->db->delete('language')){
		   return true;
		  }else return $this->db->_error_message();
	}
	function delete_list($id)
	{
		if(!$select_inventory){
		$this->db->where_in('id',$id);
		}
		return $this->db->update('abouts', array('deleted' => 1));
 	}
	function cleanup()
	{
		$item_data = array('id' => null);
		$this->db->where('deleted', 1);
		return $this->db->update('abouts',$item_data);
	}
}
?>