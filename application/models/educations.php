<?php

class Educations extends CI_Model {
	//check trùng tên
	function getname( $id){
		if( $id > 0 ){
			$this->db->select('name_education');
			$this->db->where('id !=', $id);
			$this->db->where('deleted',0);
			$this->db->from('education');
			$query= $this->db->get();
		}elseif( $id =-1 ){
			$this->db->select('name_education');
			$this->db->where('deleted',0);
			$this->db->from('education');
			$query= $this->db->get();
		}
		foreach($query->result_array() as $q)
		{
			$result[] =	$q;
		}
		return $result;
	}
	
	

	function get_all()
	{			
		$this->db->where('deleted',0);
		$query = $this->db->get('education');		
		if($query->num_rows()>0)
		{			
			return $query->result_array();		
		}
		else return null;	
	}	
	function get_all1($limit=100, $offset=0,$col='name_education',$order='asc')
	{
		$this->db->where('deleted',0);
		$this->db->from('education');
		$this->db->order_by($col, $order);
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();
	}// End ga
	function count_all(){
			$this->db->from('education');
			$this->db->where('deleted',0);
			return $this->db->count_all_results();
	}// End count	
	function insert($data){
		$this->db->insert('education',$data);
	}// Insert a education
	function exists($id)
	{
		$this->db->from('education');
		$this->db->where('id',$id);
		$query = $this->db->get();

		return ($query->num_rows()==1);
	}// why not me		
	function update_education($id,$values){
		$this->db->where('id',$id);	
		$this->db->update('education',$values);	
	}// update a education
		
	function save(&$item_data,$id=false){
 	 	if (!$id or !$this->exists($id)){
	   		if($this->db->insert('education',$item_data)){
				$item_data['id']=$this->db->insert_id();
				return true;
	  	 	}
	   		return false;
	 	}else{
	  		$this->db->where('id',$id);
	  		return $this->db->update('education',$item_data);
	 	}
 	}// End function save


	public function get_search_suggestions($search,$limit=10){
		$suggestions = array();		
		$this->db->from('education');		
		$this->db->where('deleted',0);
		$this->db->like("name_education",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->order_by("name_education", "asc");		
		$by_company_name = $this->db->get();
		foreach($by_company_name->result() as $row)
		{
			$suggestions[]=array('label' => $row->name_education);		
		}
		
		$this->db->from('education');
		$this->db->like('id', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->where('deleted',0);
		$this->db->order_by("id", "asc");
		$by_item_number = $this->db->get();
		foreach($by_item_number->result() as $row)
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
	public function search($search, $limit=10,$offset=0,$column='name_education',$orderby='asc')
	{
			$this->db->where('deleted',0);
			$this->db->from('education');
			$this->db->where("name_education LIKE '%".$this->db->escape_like_str($search)."%'  ");	
			$this->db->order_by($column, $orderby);
			$this->db->limit($limit);
			$this->db->offset($offset);
			return $this->db->get();	
	}
	public function search_count_all($search, $limit=10000)
	{	
			$this->db->where('deleted',0);
			$this->db->from('education');		
			$this->db->where("name_education LIKE '%".$this->db->escape_like_str($search)."%'  ");		
			$this->db->order_by("name_education", "asc");
			$result=$this->db->get();				
			return $result->num_rows();
	}

	function get_info($id){
		$this->db->where('deleted',0);
		$this->db->from('education');
		$this->db->where('id',$id);
		
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
			$fields = $this->db->list_fields('education');

			foreach ($fields as $field)
			{
				$item_obj->$field='';
			}

			return $item_obj;
		}
	} 
	
	function item_info($id){
		$this->db->where('deleted',0);
		$query = $this->db->get('education');
		if($query->num_rows()>0){
			return $query->result_array();
		}
		else return null;
	}//End info
	function delete_list($id_education)
	{
		if(!$select_inventory){
		$this->db->where_in('id',$id_education);
		}
		return $this->db->update('education', array('deleted' => 1));
 	}

}// END CLASS EDUCATION

/* End of file educations.php */
/* Location: ./application/models/educations.php */