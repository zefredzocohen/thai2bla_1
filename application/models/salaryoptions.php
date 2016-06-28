<?php 
class Salaryoptions extends CI_Model
{
	function exists($id)
	{
		$this->db->from('salary_option');
		$this->db->where('id',$id);
		$query = $this->db->get();

		return ($query->num_rows()==1);
		
	}
	
	function get_all($limit=1000, $offset=0,$col='id',$order='asc')
	{
		$this->db->from('salary_option');
		$this->db->order_by($col, $order);
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();
	}
	
	
	function count_all(){
		$this->db->from('salary_option');
		return $this->db->count_all_results();
	}
	
	 
	function save(&$item_data,$id=false)
	{
		if (!$id or !$this->exists($id))
		{
			if($this->db->insert('salary_option',$item_data))
			{
				$item_data['id']=$this->db->insert_id();
				return true;
			}
			return false;
		}		
		$this->db->where('id',$id);
		return $this->db->update('salary_option',$item_data);
			
	}
	
	//lay thong tin form :)
	function get_info($id = -1)
	{
		$this->db->from('salary_option');
		$this->db->where('id',$id);
		$query = $this->db->get();

		if($query->num_rows()==1){
			return $query->row();
		}
		else
		{
			//Get empty base parent object, as $item_id is NOT an item
			$item_obj=new stdClass();

			//Get all the fields from items table
			$fields = $this->db->list_fields('salary_option');

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
			$this->db->from('salary_option');		
			$this->db->where("numberdays LIKE '%".$this->db->escape_like_str($search)."%'  ");		
			$this->db->order_by("numberdays", "asc");
			$result=$this->db->get();				
			return $result->num_rows();
	}
	
	 function search($search, $limit=50,$offset=0,$column='numberdays',$orderby='asc')

    {

       		$this->db->from('salary_option');
			$this->db->where("numberdays LIKE '%".$this->db->escape_like_str($search)."%'  ");	
			$this->db->order_by($column, $orderby);
			$this->db->limit($limit);
			$this->db->offset($offset);
			return $this->db->get();

    }
	// xo chu khi nhap gtri search
	function get_search_suggestions($search,$limit=10000)
	{
		$suggestions = array();

		$this->db->from('salary_option');
		$this->db->like('numberdays', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->where('deleted',0);
		$this->db->order_by("numberdays", "asc");
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=array('label' => $row->numberdays);
		}

		$this->db->from('salary_option');
		$this->db->like('id', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->where('deleted',0);
		$this->db->order_by("id", "asc");
		$by_item_number = $this->db->get();
		foreach($by_item_number->result() as $row)
		{
			$suggestions[]=array('label' => $row->id);
		}
		
		$this->db->from('salary_option');
		$this->db->like('numberhours', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->where('deleted',0);
		$this->db->order_by("numberhours", "asc");
		$by_item_number = $this->db->get();
		foreach($by_item_number->result() as $row)
		{
			$suggestions[]=array('label' => $row->numberhours);
		}
		
		$this->db->from('salary_option');
		$this->db->like('percent_overtime_weekdays', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->where('deleted',0);
		$this->db->order_by("percent_overtime_weekdays", "asc");
		$by_item_number = $this->db->get();
		foreach($by_item_number->result() as $row)
		{
			$suggestions[]=array('label' => $row->percent_overtime_weekdays);
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

		$this->db->from('salary_option');
		$this->db->where('deleted',0);
		$this->db->like('numberdays', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->order_by("numberdays", "asc");
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=array('value' => $row->id, 'label' => $row->numberdays);
		}

		$this->db->from('salary_option');
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
        $this->db->trans_start();
        $this->db->where_in('id',$id);

        if($this->db->delete('salary_option')){
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
		return $this->db->update('salary_option',$item_data);
	}
}
?>