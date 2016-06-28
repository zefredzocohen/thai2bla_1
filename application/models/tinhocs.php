<?php
class Tinhocs extends CI_Model{	
	function insert($data)
	{		
		$this->db->insert('tinhoc',$data);	
	}	
	
	function exists($id)
	{
		$this->db->from('tinhoc');
		$this->db->where('id_tinhoc',$id);
		$query = $this->db->get();
		return ($query->num_rows()==1);
	}//	
	function get_all($limit=100, $offset=0,$col='id_tinhoc',$order='asc')
	{
		$this->db->from('tinhoc');
		$this->db->order_by($col, $order);
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();
	}
	function count_all()
	{
		$this->db->from('tinhoc');
		$this->db->where('deleted',0);
		return $this->db->count_all_results();
	}	
	function update_cat($id,$value)
	{		
		$this->db->where('id_tinhoc',$id);		
		$this->db->update('tinhoc',$value);	
	}	
	/*
	Inserts or updates a item
	
	function save1(&$item_data,$id_cat=false)
	{
		if (!$id_cat or !$this->exists($id_cat))
		{
			//if($this->db->insert('categories_item',$item_data))
			//{
			//	$item_data['id_cat']= $this->db->insert_id();
			//	return true;
			//}
			//return false;
			//$this->db->insert('categories_item',$item_data);
			
		}
		else{
			$this->db->where('id_cat', $id_cat);
			return $this->db->update('categories_item',$item_data);
		}
	}
	*/
	function save(&$item_data,$id=false)
	{
		if (!$id or !$this->exists($id))
		{
			if($this->db->insert('tinhoc',$item_data))
			{
				$item_data['id_tinhoc']=$this->db->insert_id();
				return true;
			}
			return false;
		}
		else{
		$this->db->where('id_tinhoc',$id);
		return $this->db->update('tinhoc',$item_data);}
			
	}	
	
	// xo chu khi nhap gtri search
	public function search_count_all($search, $limit=10000)
	{	
			$this->db->from('tinhoc');		
			$this->db->where("chungchi_tinhoc LIKE '%".$this->db->escape_like_str($search)."%'  ");		
			$this->db->order_by("chungchi_tinhoc", "asc");
			$result=$this->db->get();				
			return $result->num_rows();
	}
	
	public function search($search, $limit=10,$offset=0,$column='chungchi_tinhoc',$orderby='asc')
	{
			$this->db->from('tinhoc');
			$this->db->where("chungchi_tinhoc LIKE '%".$this->db->escape_like_str($search)."%'  ");	
			$this->db->order_by($column, $orderby);
			$this->db->limit($limit);
			$this->db->offset($offset);
			return $this->db->get();	
	}
	public function get_search_suggestions($search,$limit=10){
		$suggestions = array();		
		$this->db->from('tinhoc');		
		$this->db->like("chungchi_tinhoc",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->order_by("chungchi_tinhoc", "asc");		
		$by_company_name = $this->db->get();
		foreach($by_company_name->result() as $row)
		{
			$suggestions[]=array('label' => $row->chungchi_tinhoc);		
		}		
		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;

	}
	function get_info($id_cat)
	{
		$this->db->select('id_tinhoc,chungchi_tinhoc');
		$this->db->where('id_tinhoc',$id_cat);
		$query = $this->db->get('tinhoc');

		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			//Get empty base parent object, as $item_id is NOT an item
			$item_obj=new stdClass();

			//Get all the fields from items table
			$fields = $this->db->list_fields('tinhoc');

			foreach ($fields as $field)
			{
				$item_obj->$field='';
			}

			return $item_obj;
		}
	}
	function account_number_exists($id_cat)
	{
		$this->db->from('categories_item');	
		$this->db->where('id_cat',$id_cat);
		$query = $this->db->get();
		
		return ($query->num_rows()==1);
	}
	function item_info($id_cat){
		
		$this->db->where('deleted',0);
		$query = $this->db->get('categories_item');
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
	
	function checkname($name,$id){
		  if(empty($id) OR $id == -1){
            $this->db->where("chungchi_tinhoc' check LIKE '".$this->db->escape_like_str($name)."'");
        }
		else{
		$this->db->where("chungchi_tinhoc' LIKE '".$this->db->escape_like_str($name)."' AND id != ".$id);
			$result = $this->db->get('tinhoc');
			return $result->num_rows();
		}
	
	}
	public function delete_db($id)
	{
		$this->db->where_in('id_tinhoc',$id);
		  if( $this->db->delete('tinhoc')){
		   return true;
		  }else return $this->db->_error_message();
	}
}


?>