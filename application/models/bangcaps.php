<?php
class Bangcaps extends CI_Model{	
	function insert($data)
	{		
		$this->db->insert('bangcap',$data);	
	}	
	
	function exists($id)
	{
		$this->db->from('bangcap');
		$this->db->where('id_bangcap',$id);
		$query = $this->db->get();

		return ($query->num_rows()==1);
	}	
	function get_all($limit=100, $offset=0,$col='id_bangcap',$order='asc')
	{
		$this->db->from('bangcap');
		$this->db->order_by($col, $order);
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();
	}
	function count_all()
	{
		$this->db->from('bangcap');
		$this->db->where('deleted',0);
		return $this->db->count_all_results();
	}	
	function update_cat($id,$value)
	{		
		$this->db->where('id_bangcap',$id);		
		$this->db->update('bangcap',$value);	
	}	
	/*
	Inserts or updates a item
	*/
	
	function save(&$item_data,$id=false)
	{
		if ($id ==-1 OR empty($id))
		{
			if($this->db->insert('bangcap',$item_data))
			{
				$item_data['id_bangcap']=$this->db->insert_id();
				return true;
			}
			return false;
		}
		
		$this->db->where('id_bangcap',$id);
		return $this->db->update('bangcap',$item_data);
			
	}	//
	public function search_count_all($search, $limit=10000)
	{	
			$this->db->from('bangcap');		
			$this->db->where("nam_bangcap LIKE '%".$this->db->escape_like_str($search)."%'  ");		
			$this->db->order_by("nam_bangcap", "asc");
			$result=$this->db->get();				
			return $result->num_rows();
	}
	public function search($search, $limit=20,$offset=0,$column='nam_bangcap',$orderby='asc')
	{
			$this->db->from('bangcap');
			$this->db->where("nam_bangcap LIKE '%".$this->db->escape_like_str($search)."%'  ");	
			$this->db->order_by($column, $orderby);
			$this->db->limit($limit);
			$this->db->offset($offset);
			return $this->db->get();	
	}
	public function get_search_suggestions($search,$limit=25){
		$suggestions = array();		
		$this->db->from('bangcap');		
		$this->db->like("nam_bangcap",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->order_by("nam_bangcap", "asc");		
		$by_company_name = $this->db->get();
		foreach($by_company_name->result() as $row)
		{
			$suggestions[]=array('label' => $row->nam_bangcap);		
		}		
		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;

	}
	
	function get_info($id){
		$this->db->from('bangcap');
		$this->db->where('id_bangcap',$id);		
		$query = $this->db->get();

		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			//Get empty base parent object, as $item_id is NOT an item
			$item_obj=new stdClass();

			//Get all the fields from items table
			$fields = $this->db->list_fields('bangcap');

			foreach ($fields as $field)
			{
				$item_obj->$field='';
			}

			return $item_obj;
		}
	} //End get_info
	
	function account_number_exists($id_cat)
	{
		$this->db->from('categories_item');	
		$this->db->where('id_cat',$id_cat);
		$query = $this->db->get();
		
		return ($query->num_rows()==1);
	}
	function item_info($id){
		
		$this->db->where('deleted',0);
		$query = $this->db->get('bangcap');
		if($query->num_rows()>0){
			return $query->result_array();
		}
		else return null;
	}
	function delete_list($id_cat)
	{
		if(!$select_inventory){
		$this->db->where_in('id_cat',$id_cat);
		}
		return $this->db->update('categories_item', array('deleted' => 1));
 	}
	
	
}?>