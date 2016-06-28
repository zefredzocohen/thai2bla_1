<?php
class Profit_m extends CI_Model
{
    //check trùng tên
    function getname( $id){
        if( $id > 0 ){
            $this->db->select('formula_name');
            $this->db->where('id !=', $id);
            $this->db->where('deleted', 0);
            $this->db->from('profit');
            $query= $this->db->get();
        }elseif( $id =-3 ){
            $this->db->select('formula_name');
            $this->db->where('deleted', 0);
            $this->db->from('profit');
            $query= $this->db->get();
        }
        foreach($query->result_array() as $q)
        {
            $result[] =	$q;
        }
        return $result;
    }

    /*
	Returns all the item kits
	*/
	function get_all($limit=10000, $offset=0,$col='id',$ord='desc')
	{
		$this->db->from('profit');
		$this->db->where('deleted',0);
		$this->db->order_by($col, $ord);
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();
	}
	
	function count_all()
	{
		$this->db->from('profit');
		$this->db->where('deleted',0);
		return $this->db->count_all_results();
	}

	/*
	Gets information about a particular item kit
	*/
	function get_info($profit_id)
	{
		$this->db->from('profit');
		$this->db->where('id',$profit_id);
		
		$query = $this->db->get();

		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			//Get empty base parent object, as $item_kit_id is NOT an item kit
			$item_obj=new stdClass();

			//Get all the fields from items table
			$fields = $this->db->list_fields('profit');

			foreach ($fields as $field)
			{
				$item_obj->$field='';
			}

			return $item_obj;
		}
	}
    
    function get_info_other($f_id)
    {
        $resut=$this->db->query("SELECT cost_name,price2 FROM `lifetek_profit` LEFT OUTER JOIN `lifetek_profit_other` ON f_name=formula_name WHERE `lifetek_profit`.id=$f_id");
        return $resut->result_array();
    }
    
    function get_info_empl($f_id)
    {
        $resut_el=$this->db->query("SELECT `name_empl`,`day_hour`,`day_hour_number`,`salary_empl` FROM `lifetek_profit` LEFT OUTER JOIN `lifetek_profit_empl` ON f_name=formula_name WHERE `lifetek_profit`.id=$f_id");
        return $resut_el->result_array();
    }
    
    function update1_profit($id, $data){
    
    $this->db->where('id', $id);
    $this->db->update('profit', $data); 
    return true;
    }
    
    //kiem tra ten cong thuc co trung khong
    function get_info_formula($f_name)
    {
       $this->db->from('profit');
	   $this->db->where('formula_name',$f_name);
	   $query = $this->db->get();
	   if($query->num_rows()==1)
		{
			return false;
		}
        else return true;
    }
	
	/*
	Get an item_kit_id given an item kit number
	*/
	function get_item_kit_id($item_kit_number)
	{
		$this->db->from('item_kits');
		$this->db->where('item_kit_number',$item_kit_number);

		$query = $this->db->get();

		if($query->num_rows()==1)
		{
			return $query->row()->item_kit_id;
		}

		return false;
	}

	/*
	Gets information about multiple item kits
	*/
	function get_multiple_info($item_kit_ids)
	{
		$this->db->from('item_kits');
		$this->db->where_in('item_kit_id',$item_kit_ids);
		$this->db->order_by("name", "asc");
		return $this->db->get();
	}

	/*
	Inserts or updates an item kit
	
	function save(&$item_kit_data,$item_kit_id=false)
	{
		if (!$item_kit_id or !$this->exists($item_kit_id))
		{
			if($this->db->insert('item_kits',$item_kit_data))
			{
				$item_kit_data['item_kit_id']=$this->db->insert_id();
				return true;
			}
			return false;
		}

		$this->db->where('item_kit_id', $item_kit_id);
		return $this->db->update('item_kits',$item_kit_data);
	}
    */
    
    function save_profit(&$item_kit_data)
	{
	   //$this->db->trans_start();
	   /*
		if (!$item_kit_id or !$this->exists($item_kit_id))
		{
		  
			if($this->db->insert('profit',$item_kit_data))
			{
				$item_kit_data['id']=$this->db->insert_id();
				return true;
			}
			return false;
            
            
		}
		$this->db->where('item_kit_id', $item_kit_id);
		return $this->db->update('item_kits',$item_kit_data);
      */
      $success=$this->db->insert('profit',$item_kit_data);
      return $success;
	}
    
    function save_profit_other(&$item_data)
	{
        //$this->db->trans_start();
       $this->db->insert('profit_other',$item_data);
	}
    
    function save_profit_empl(&$p_empl_data)
	{
        //$this->db->trans_start();
       $this->db->insert('profit_empl',$p_empl_data);
	}
    
	/*
	Deletes one item kit
	*/
	function delete($item_kit_id)
	{
		$this->db->where('id', $item_kit_id);
		return $this->db->update('profit', array('deleted' => 1));
	}
    
   	function delete_profit_other($profit_other_id)
	{
		$this->db->where('f_name', $profit_other_id);
		return $this->db->delete('profit_other');
	}
    
    function delete_profit_empl($profit_empl_id)
	{
		$this->db->where('f_name', $profit_empl_id);
		return $this->db->delete('profit_empl');
	}
    
	/*
	Deletes a list of item kits
	*/
	function delete_list($item_kit_ids)
	{
		$this->db->where_in('id',$item_kit_ids);
		return $this->db->update('profit', array('deleted' => 1));
 	}

 	/*
	Get search suggestions to find kits
	
	function get_search_suggestions($search,$limit=25)
	{
		$suggestions = array();

		$this->db->from('item_kits');
		$this->db->like('name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->where('deleted',0);
		$this->db->order_by("name", "asc");
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=array('label' => $row->name);
		}
		
		$this->db->from('item_kits');
		$this->db->like('item_kit_number', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->where('deleted',0);
		$this->db->order_by("item_kit_number", "asc");
		$by_item_kit_number = $this->db->get();
		foreach($by_item_kit_number->result() as $row)
		{
			$suggestions[]=array('label' => $row->item_kit_number);
		}

		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;

	}
    */
    
   	function get_search_suggestions($search,$limit=25)
	{
		$suggestions = array();

		$this->db->from('profit');
		$this->db->like('formula_name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->where('deleted',0);
		$this->db->order_by("formula_name", "asc");
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=array('label' => $row->formula_name);
		}
		
		$this->db->from('profit');
		$this->db->like('name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->where('deleted',0);
		$this->db->order_by("name", "asc");
		$by_item_kit_number = $this->db->get();
		foreach($by_item_kit_number->result() as $row)
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
	
	/*
	Preform a search on items kits
	
	function search($search, $limit=16,$offset=0,$column='name',$orderby='asc')
	{
		$this->db->from('item_kits');
		
		if ($this->config->item('speed_up_search_queries'))
		{
			$this->db->where("name LIKE '".$this->db->escape_like_str($search)."%' or 
			description LIKE '".$this->db->escape_like_str($search)."%'");
		}
		else
		{
			$this->db->where("(name LIKE '%".$this->db->escape_like_str($search).
			"%' or item_kit_number LIKE '%".$this->db->escape_like_str($search)."%' or
			description LIKE '%".$this->db->escape_like_str($search)."%') and deleted=0");	
		}
		$this->db->order_by($column, $orderby);
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();	
	}
    */
    
   	function searchsai($search, $limit=16,$offset=0,$column='name',$orderby='asc')
	{
	   /*
	   //$this->db->select('*');
		$this->db->from('profit');	
		//$this->db->where("name LIKE '%".$this->db->escape_like_str($search)."%' and deleted=0");
        $this->db->where('name',$search);
        $this->db->or_where('formula_name',$search);
        $this->db->where('deleted',0);
		//$this->db->order_by($column, $orderby);
		//$this->db->limit($limit);
		//$this->db->offset($offset);
		return $this->db->get();
        
        */	
        
        $this->db->from('profit');		
			$this->db->where("(formula_name LIKE '%".$this->db->escape_like_str($search)."%' or 
			name LIKE '%".$this->db->escape_like_str($search)."%' or 
			CONCAT(`formula_name`,' ',`name`) LIKE '%".$this->db->escape_like_str($search)."%') and deleted=0");		
			$this->db->order_by($column, $orderby);
			$this->db->limit($limit);
			$this->db->offset($offset);
			return $this->db->get();
        
	}
	
    /*
	function search_count_all($search)
	{
		$this->db->from('item_kits');
		
		if ($this->config->item('speed_up_search_queries'))
		{
			$this->db->where("name LIKE '".$this->db->escape_like_str($search)."%' or 
			description LIKE '".$this->db->escape_like_str($search)."%'");
		}
		else
		{
			$this->db->where("(name LIKE '%".$this->db->escape_like_str($search).
			"%' or item_kit_number LIKE '%".$this->db->escape_like_str($search)."%' or
			description LIKE '%".$this->db->escape_like_str($search)."%') and deleted=0");	
		}
		$this->db->order_by("name", "asc");
		$result=$this->db->get();				
		return $result->num_rows();	
	}
    */
    
    /*
   	function search_count_all($search)
	{
		$this->db->from('profit');
		
		if ($this->config->item('speed_up_search_queries'))
		{
			$this->db->where("name LIKE '".$this->db->escape_like_str($search)."%' or 
			formular_name LIKE '".$this->db->escape_like_str($search)."%'");
		}
		else
		{
			$this->db->where("(name LIKE '%".$this->db->escape_like_str($search).
			"%' or tax LIKE '%".$this->db->escape_like_str($search)."%' or
			formular_name LIKE '%".$this->db->escape_like_str($search)."%') and deleted=0");	
		}
		$this->db->order_by("name", "asc");
		$result=$this->db->get();				
		return $result->num_rows();	
	}
    */
    
    function search_count_all($search)
	{
		$this->db->from('profit');
		$this->db->where('name',$search);
		$this->db->order_by("name", "asc");
		$result=$this->db->get();				
		return $result->num_rows();	
	}
    
	/*
   	function search1($search, $limit=20,$offset=0,$column='last_name',$orderby='asc')
	{
		if ($this->config->item('speed_up_search_queries'))
		{

			$query = "
				select *
			from (
           	(select ".$this->db->dbprefix('people').".*, ".$this->db->dbprefix('employees').".username, ".$this->db->dbprefix('employees').".deleted
           	from ".$this->db->dbprefix('employees')."
           	join ".$this->db->dbprefix('people')." ON ".$this->db->dbprefix('employees').".person_id = ".$this->db->dbprefix('people').".person_id
           	where first_name like '".$this->db->escape_like_str($search)."%' and deleted = 0
           	order by `".$column."` ".$orderby.") union

		 	(select ".$this->db->dbprefix('people').".*, ".$this->db->dbprefix('employees').".username, ".$this->db->dbprefix('employees').".deleted
           	from ".$this->db->dbprefix('employees')."
           	join ".$this->db->dbprefix('people')." ON ".$this->db->dbprefix('employees').".person_id = ".$this->db->dbprefix('people').".person_id
           	where last_name like '".$this->db->escape_like_str($search)."%' and deleted = 0
           	order by `".$column."` ".$orderby.") union

			(select ".$this->db->dbprefix('people').".*, ".$this->db->dbprefix('employees').".username, ".$this->db->dbprefix('employees').".deleted
         	from ".$this->db->dbprefix('employees')."
          	join ".$this->db->dbprefix('people')." ON ".$this->db->dbprefix('employees').".person_id = ".$this->db->dbprefix('people').".person_id
          	where email like '".$this->db->escape_like_str($search)."%' and deleted = 0
          	order by `".$column."` ".$orderby.") union

			(select ".$this->db->dbprefix('people').".*, ".$this->db->dbprefix('employees').".username, ".$this->db->dbprefix('employees').".deleted
        	from ".$this->db->dbprefix('employees')."
        	join ".$this->db->dbprefix('people')." ON ".$this->db->dbprefix('employees').".person_id = ".$this->db->dbprefix('people').".person_id
        	where phone_number like '".$this->db->escape_like_str($search)."%' and deleted = 0
        	order by `".$column."` ".$orderby.") union

			(select ".$this->db->dbprefix('people').".*, ".$this->db->dbprefix('employees').".username, ".$this->db->dbprefix('employees').".deleted
      		from ".$this->db->dbprefix('employees')."
      		join ".$this->db->dbprefix('people')." ON ".$this->db->dbprefix('employees').".person_id = ".$this->db->dbprefix('people').".person_id
      		where username like '".$this->db->escape_like_str($search)."%' and deleted = 0
      		order by `".$column."` ".$orderby.") union

			(select ".$this->db->dbprefix('people').".*, ".$this->db->dbprefix('employees').".username, ".$this->db->dbprefix('employees').".deleted
    		from ".$this->db->dbprefix('employees')."
    		join ".$this->db->dbprefix('people')." ON ".$this->db->dbprefix('employees').".person_id = ".$this->db->dbprefix('people').".person_id
    		where CONCAT(`first_name`,' ',`last_name`)  like '".$this->db->escape_like_str($search)."%' and deleted = 0
    		order by `".$column."` ".$orderby.")
			) as search_results
			order by `".$column."` ".$orderby." limit ".$this->db->escape((int)$offset).', '.$this->db->escape((int)$limit);

			return $this->db->query($query);
		}
		else
		{
			$this->db->from('employees');
			$this->db->join('people','employees.person_id=people.person_id');		
			$this->db->where("(first_name LIKE '%".$this->db->escape_like_str($search)."%' or 
			last_name LIKE '%".$this->db->escape_like_str($search)."%' or 
			email LIKE '%".$this->db->escape_like_str($search)."%' or 
			phone_number LIKE '%".$this->db->escape_like_str($search)."%' or 
			username LIKE '%".$this->db->escape_like_str($search)."%' or 
			CONCAT(`first_name`,' ',`last_name`) LIKE '%".$this->db->escape_like_str($search)."%') and deleted=0");		
			$this->db->order_by($column, $orderby);
			$this->db->limit($limit);
			$this->db->offset($offset);
			return $this->db->get();
		}
	}
	*/
}
?>
