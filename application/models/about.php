<?php 
class About extends CI_Model
{
	function exists($id)
	{
		$this->db->from('abouts');
		$this->db->where('id',$id);
		$query = $this->db->get();

		return ($query->num_rows()==1);
	}
	
	function get_all($limit=100, $offset=0,$col='email',$order='asc')
	{
		$this->db->from('abouts');
		$this->db->where('deleted',0);
		$this->db->order_by($col, $order);
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();
		
	}
	function count_all()
	{
		$this->db->from('abouts');
		$this->db->where('deleted',0);
		return $this->db->count_all_results();
	}
	
	public function get_about_header()
	 {
	 $this->db->from('abouts');
	 $this->db->where('active',1);
	 $query = $this->db->get();
	  
	  return $query->result_array();
	 }
	 
	function save(&$item_data,$id=false)
	{
		if (!$id or !$this->exists($id))
		{
			if($this->db->insert('abouts',$item_data))
			{
				$item_data['id']=$this->db->insert_id();
				return true;
			}
			return false;
		}
		
		$this->db->where('id',$id);
		return $this->db->update('abouts',$item_data);
			
	}
	
	//lay thong tin form :)
	function get_info($id)
	{
		//$this->db->select('id,name , parentid');
		$this->db->from('abouts');
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
			$fields = $this->db->list_fields('abouts');

			foreach ($fields as $field)
			{
				$item_obj->$field='';
			}

			return $item_obj;
		}
	}	
	
	
	//sorting goi
	function search_count_all($search, $cat='')
	{		if($cat) $cat_id = "and id = $cat "; 
            else $cat_id = '';
		if ($this->config->item('speed_up_search_queries'))
		{
			$query = "
			select *
			from (
			         (select *
			         from ".$this->db->dbprefix('abouts')."
			         where email like '".$this->db->escape_like_str($search)."%' and deleted = 0
			         order by `email` )
					union
			         (select *
			         from ".$this->db->dbprefix('abouts')."
			         where id like '".$this->db->escape_like_str($search)."%' and deleted = 0
			         order by `email`)
					union
					(select *
			         from ".$this->db->dbprefix('abouts')."
			         where website like '".$this->db->escape_like_str($search)."%' and deleted = 0
			         order by `email`)
					 union
					(select *
			         from ".$this->db->dbprefix('abouts')."
			         where name_eployee like '".$this->db->escape_like_str($search)."%' and deleted = 0
			         order by `email`)
					union
			         (select *
			         from ".$this->db->dbprefix('abouts')."
			         where phone_number like '".$this->db->escape_like_str($search)."%' and deleted = 0
			         order by `email` )
			) as search_results
			order by `email`";
			$result=$this->db->query($query);
			return $result->num_rows();
		}
		else
		{
			$this->db->from('abouts');
			$this->db->where("(email LIKE '%".$this->db->escape_like_str($search)."%' or 
			id LIKE '%".$this->db->escape_like_str($search)."%' or 
			website LIKE '%".$this->db->escape_like_str($search)."%' or 
			name_eployee LIKE '%".$this->db->escape_like_str($search)."%' or 
			
			phone_number LIKE '%".$this->db->escape_like_str($search)."%') $cat_id and deleted=0");
			//location LIKE '%".$this->db->escape_like_str($search)."%') $cat_id and deleted=0");
			$this->db->order_by("email", "asc");
			$result=$this->db->get();				
			return $result->num_rows();
		}
	}
	
	/// - tim kiem
	
	function search($search ,$cat='', $limit=20,$offset=0,$column='email',$orderby='asc')
	{
			if($cat) $cat_id = "and id = $cat "; 
            else $cat_id = '';
		if ($this->config->item('speed_up_search_queries'))
		{
			
			$query = "
			select *
			from (
			         (select *
			         from ".$this->db->dbprefix('abouts')."
			         where email like '".$this->db->escape_like_str($search)."%' and deleted = 0
			         order by `".$column."`)
					union
			         (select *
			         from ".$this->db->dbprefix('abouts')."
			         where id like '".$this->db->escape_like_str($search)."%' and deleted = 0
			         order by `".$column."`)
					union
			         (select *
			         from ".$this->db->dbprefix('abouts')."
			         where website like '".$this->db->escape_like_str($search)."%' and deleted = 0
			         order by `".$column."`)
					union
			         (select *
			         from ".$this->db->dbprefix('abouts')."
			         where name_eployee like '".$this->db->escape_like_str($search)."%' and deleted = 0
			         order by `".$column."`)
					union
			         (select *
			         from ".$this->db->dbprefix('abouts')."
			         where phone_number like '".$this->db->escape_like_str($search)."%' and deleted = 0
			         order by `".$column."`)
			) as search_results
			order by `".$column."` limit ".$offset.','.$limit;
			return $this->db->query($query);
		}
		
		else
		{
		$str_search = str_replace( array('_', '@', '#', '$', '%') , ' ', $search );

			$search_terms_array=explode(" ", $this->db->escape_like_str($str_search));
	
			//to keep track of which search term of the array we're looking at now	
			$search_name_criteria_counter=0;
			$sql_search_name_criteria = '';
			//loop through array of search terms
			foreach ($search_terms_array as $x){
	
				$sql_search_name_criteria.=
				($search_name_criteria_counter > 0 ? " AND " : "").
				"email LIKE '%".$this->db->escape_like_str($x)."%'";
				
				$search_name_criteria_counter++;
			}
	
			$this->db->from('abouts');
			$this->db->where("((".
			$sql_search_name_criteria. ") or 
			id LIKE '%".$this->db->escape_like_str($search)."%' or 
			phone_number LIKE '%".$this->db->escape_like_str($search)."%' or 
			website LIKE '%".$this->db->escape_like_str($search)."%' or 
			name_eployee LIKE '%".$this->db->escape_like_str($search)."%') $cat_id and deleted=0"); 
			//location LIKE '%".$this->db->escape_like_str($search)."%') $cat_id and deleted=0");
			$this->db->order_by($column, $orderby);
			$this->db->limit($limit);
			$this->db->offset($offset);
			return $this->db->get();	
		}
				 
	}
	// xo chu khi nhap gtri search
	function get_search_suggestions($search,$limit=25)
	{
		$suggestions = array();

		$this->db->from('abouts');
		$this->db->like('email', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->where('deleted',0);
		$this->db->order_by("email", "asc");
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=array('label' => $row->email);
		}

		$this->db->from('abouts');
		$this->db->like('id', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->where('deleted',0);
		$this->db->order_by("id", "asc");
		$by_item_number = $this->db->get();
		foreach($by_item_number->result() as $row)
		{
			$suggestions[]=array('label' => $row->id);
		}
		
		$this->db->from('abouts');
		$this->db->like('phone_number', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->where('deleted',0);
		$this->db->order_by("phone_number", "asc");
		$by_item_number = $this->db->get();
		foreach($by_item_number->result() as $row)
		{
			$suggestions[]=array('label' => $row->phone_number);
		}
		
		$this->db->from('abouts');
		$this->db->like('website', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->where('deleted',0);
		$this->db->order_by("website", "asc");
		$by_item_number = $this->db->get();
		foreach($by_item_number->result() as $row)
		{
			$suggestions[]=array('label' => $row->website);
		}
		
		$this->db->from('abouts');
		$this->db->like('name_eployee', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->where('deleted',0);
		$this->db->order_by("name_eployee", "asc");
		$by_item_number = $this->db->get();
		foreach($by_item_number->result() as $row)
		{
			$suggestions[]=array('label' => $row->name_eployee);
		}
		
		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;

	}
	
	function get_category_search_suggestions($search,$limit=25)
	{
		$suggestions = array();

		$this->db->from('abouts');
		$this->db->where('deleted',0);
		$this->db->like('email', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->order_by("email", "asc");
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=array('value' => $row->id, 'label' => $row->email);
		}

		$this->db->from('abouts');
		$this->db->where('deleted',0);
		$this->db->like('id', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->order_by("id", "asc");
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;

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