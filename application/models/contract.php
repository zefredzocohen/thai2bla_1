<?php 
   class Contract extends CI_Model
   {
   	
   	public function __construct()
   	{
   	   parent::__construct();
   	}

   	public function count_all()
   	{
   		$query=$this->db->get('hopdong');
        //$this->db->where('active',0);
		return $query->num_rows();
   	}

	public function get_all($limit=10000,$offset=0)
	{
		  $this->db->from('hopdong');
		  $this->db->limit($limit);
		  $this->db->offset($offset);
		  return  $this->db->get();		 
	}

	public function search_count_all($search, $limit=10000)
	{	
			$this->db->from('hopdong');		
			$this->db->where("ma_hopdong LIKE '%".$this->db->escape_like_str($search)."%'  ");		
			$this->db->order_by("ma_hopdong", "asc");
			$result=$this->db->get();				
			return $result->num_rows();
	}
	public function search($search, $limit=20,$offset=0,$column='ma_hopdong',$orderby='asc')
	{
			$this->db->from('hopdong');
			$this->db->where("ma_hopdong LIKE '%".$this->db->escape_like_str($search)."%'  ");	
			$this->db->order_by($column, $orderby);
			$this->db->limit($limit);
			$this->db->offset($offset);
			return $this->db->get();	
	}
        
         public function get_search_suggestions($search, $limit = 25) {
        $suggestions = array();
        $this->db->from('hopdong');
        $this->db->like("ma_hopdong", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("ma_hopdong", "asc");
        $by_company_name = $this->db->get();
        foreach ($by_company_name->result() as $row) {
            $suggestions[] = array('label' => $row->ma_hopdong);
        }
        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }
    
	public function get_data()
	{
		$query=$this->db->get('hopdong');
		return $query->row_array();
	}
 	public  function get_list_hopdong()
 	{
            $this->db->select(array('id_hopdong', 'ma_hopdong'));
            $this->db->from('hopdong');
            $this->db->distinct();
            $this->db->order_by("ma_hopdong", "asc");
            return $this->db->get();
     }
    public function exists($hopdong_id)
	{
		$this->db->from('hopdong');	
		$this->db->where('id_hopdong',$hopdong_id);
		$query = $this->db->get();	
		return ($query->num_rows()==1);
	}

	
	public function save(&$hopdong_data,$hopdong_id=false)
	{
		if (!$hopdong_id or !$this->exists($hopdong_id))
		{
			if($this->db->insert('hopdong',$hopdong_data))
			{
				$hopdong_data['id_hopdong']=$this->db->insert_id();
				return true;
			}
			return false;
		}
		$this->db->where('id_hopdong', $hopdong_id);

		return $this->db->update('hopdong',$hopdong_data);
	}

	public 	function get_info($hopdong_id)
	{
		$this->db->from('hopdong');
		$this->db->where('id_hopdong',$hopdong_id);
		$query = $this->db->get();
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			$customertype_obj=new stdClass();
			$fields = $this->db->list_fields('hopdong');
			foreach ($fields as $field)
			{
				$customertype_obj->$field='';
			}
			return $customertype_obj;
		}

	}
	public function delete_list($hopdong_id)
	{
		$this->db->where_in('id_hopdong',$hopdong_id);
		return $this->db->delete('hopdong');
 	}
 	public  function get_all_maloai_hopdong()
	{		
		$query = $this->db->get('maloai_hopdong');		
		if($query->num_rows()>0)
		{		
			return $query->result_array();	
		}

		else return null;	
	}	

   } 
?>