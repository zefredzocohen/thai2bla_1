<?php 
class Salaryconfigs extends CI_Model
{
	function exists($id)
	{
		$this->db->from('salary_config');
		$this->db->where('id',$id);
		$query = $this->db->get();

		return ($query->num_rows()==1);
	}
	
	function get_all($limit=10000, $offset=0,$col='id',$order='asc')
	{
		$this->db->from('salary_config');
		$this->db->order_by($col, $order);
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();
	}
	function count_all()
	{
		$this->db->from('salary_config');
		return $this->db->count_all_results();
	}
	
	 
	function save(&$item_data,$id)
	{
		if ($id == -1)
		{
			if($this->db->insert('salary_config',$item_data))
			{
				$item_data['id']= $this->db->insert_id();
				return true;
			}
			return false;
		}		
		$this->db->where('id',$id);
		return $this->db->update('salary_config',$item_data);
			
	}
	
	//Lay thong tin form :)
	function get_info($id = -1)
	{
        $table = $this->db->dbprefix('salary_config');
	    $sql = "SELECT * FROM ".$table. " WHERE id = ".$id;
        $data = $this->db->query($sql);
        return $data->row();
	}	
	
	
	//sorting goi
	function search_count_all($search)
	{		
		if ($this->config->item('speed_up_search_queries'))
		{
			$query = "
			select *
			from (
			         (select *
			         from ".$this->db->dbprefix('salary_config')."
			         where name like '".$this->db->escape_like_str($search)."%' and deleted = 0
			         order by `name` )
					union
			         (select *
			         from ".$this->db->dbprefix('salary_config')."
			         where id like '".$this->db->escape_like_str($search)."%' and deleted = 0
			         order by `name`)
					union
			         (select *
			         from ".$this->db->dbprefix('salary_config')."
			         where description like '".$this->db->escape_like_str($search)."%' and deleted = 0
			         order by `name` )
			) as search_results
			order by `name`";
			$result=$this->db->query($query);
			return $result->num_rows();
		}
		else
		{
			$this->db->from('salary_config');
			$this->db->where("(name LIKE '%".$this->db->escape_like_str($search)."%' OR
			description LIKE '%".$this->db->escape_like_str($search)."%')");
			$this->db->order_by("name", "asc");
			$result=$this->db->get();				
			return $result->num_rows();
		}
	}
	
	/// - tim kiem
	
	 function search($search, $limit=50,$offset=0,$column='name',$orderby='ASC')

    {

        if ($this->config->item('speed_up_search_queries'))

        {

            $this->db->from('salary_config');

            $this->db->where("name LIKE '%".$this->db->escape_like_str($search)."%'");

            $this->db->order_by($column, $orderby);

            $this->db->limit($limit);

            $this->db->offset($offset);



            return $this->db->get();

        }

        else

        {

            $this->db->from('salary_config');

            $this->db->where("name LIKE '%".$this->db->escape_like_str($search)."%'");

            $this->db->order_by($column, $orderby);

            $this->db->limit($limit);

            $this->db->offset($offset);



            return $this->db->get();

        }

    }
	// xo chu khi nhap gtri search
	function get_search_suggestions($search,$limit=10000)
	{
		$suggestions = array();

		$this->db->from('salary_config');
		$this->db->like('name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->order_by("name", "asc");
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=array('label' => $row->name);
		}

		$this->db->from('salary_config');
		$this->db->like('description', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->order_by("description", "asc");
		$by_item_number = $this->db->get();
		foreach($by_item_number->result() as $row)
		{
			$suggestions[]=array('label' => $row->description);
		}
		
		//only return $limit suggestions
		if(count($suggestions) > $limit)
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;

	}
	
	function get_category_search_suggestions($search,$limit=25)
	{
		$suggestions = array();

		$this->db->from('salary_config');
		$this->db->where('deleted',0);
		$this->db->like('name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->order_by("name", "asc");
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=array('value' => $row->id, 'label' => $row->name);
		}

		$this->db->from('salary_config');
		$this->db->where('deleted',0);
		$this->db->like('id', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->order_by("id", "asc");
		if(count($suggestions) > $limit)
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;

	}
	
	function delete_list($id)
	{
        $this->db->trans_start();
        $this->db->where_in('id',$id);

        if($this->db->delete('salary_config')){
            $this->db->trans_complete();
            return true;
        }else{
            $this->db->trans_complete();
            return false;
        }
 	}
	function cleanup()
	{
		$item_data = array('id' => null);
		$this->db->where('deleted', 1);
		return $this->db->update('salary_config',$item_data);
	}
}
?>