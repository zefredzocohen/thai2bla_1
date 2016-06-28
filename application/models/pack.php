<?php
class Pack extends CI_Model{
	function get_all($limit=10000, $offset=0,$col='pack_id',$ord='desc'){
		$this->db->from('packs');
		$this->db->where('deleted',0);
		$this->db->order_by($col, $ord);
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();
	}
	function count_all(){
		$this->db->from('packs');
		$this->db->where('deleted',0);
		return $this->db->count_all_results();
	}
	function get_search_suggestions($search,$limit=25){
		$suggestions = array();

		$this->db->from('packs');
		$this->db->like('name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->where('deleted',0);
		$this->db->order_by("name", "asc");
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=array('label' => $row->name);
		}
		
		$this->db->from('packs');
		$this->db->like('pack_number', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->where('deleted',0);
		$this->db->order_by("pack_number", "asc");
		$by_pack_number = $this->db->get();
		foreach($by_pack_number->result() as $row)
		{
			$suggestions[]=array('label' => $row->pack_number);
		}

		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;

	}
	function search($search, $cat=' ', $limit=16,$offset=0,$column='pack_id',$orderby='desc'){
		if($cat) $cat_id = "and category = $cat "; 
            else $cat_id = '';
		$this->db->from('packs');
		
		if ($this->config->item('speed_up_search_queries')){
			$this->db->where("name LIKE '".$this->db->escape_like_str($search)."%' or 
			description LIKE '".$this->db->escape_like_str($search)."%'");
		}else{
			$this->db->where("(name LIKE '%".$this->db->escape_like_str($search).
			"%' or pack_number LIKE '%".$this->db->escape_like_str($search)."%' or
			description LIKE '%".$this->db->escape_like_str($search)."%') $cat_id and deleted=0");	
		}
		$this->db->order_by($column, $orderby);
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();	
	}
	function search_count_all($search, $cat){
		if($cat) $cat_id = "and category = $cat "; 
        else $cat_id = '';
		$this->db->from('packs');
		
		if ($this->config->item('speed_up_search_queries')){
			$this->db->where("name LIKE '".$this->db->escape_like_str($search)."%' or 
			description LIKE '".$this->db->escape_like_str($search)."%'");
		}else{
			$this->db->where("(name LIKE '%".$this->db->escape_like_str($search).
			"%' or pack_number LIKE '%".$this->db->escape_like_str($search)."%' or
			description LIKE '%".$this->db->escape_like_str($search)."%') $cat_id and deleted=0");	
		}
		$this->db->order_by("name", "asc");
		$result=$this->db->get();				
		return $result->num_rows();	
	}
	
	function get_info($pack_id){
		$this->db->from('packs');
		$this->db->where('pack_id',$pack_id);
		
		$query = $this->db->get();

		if($query->num_rows()==1){
			return $query->row();
		}else{
			$item_obj=new stdClass();
			$fields = $this->db->list_fields('packs');
			foreach ($fields as $field){
				$item_obj->$field='';
			}
			return $item_obj;
		}
	}
	function save(&$pack_data,$pack_id=false){
		if (!$pack_id or !$this->exists($pack_id)){
			if($this->db->insert('packs',$pack_data)){
				$pack_data['pack_id']=$this->db->insert_id();
				return true;
			}
			return false;
		} 
		$this->db->where('pack_id', $pack_id);
		return $this->db->update('packs',$pack_data);
	}
	function exists($pack_id){
		$this->db->from('packs');
		$this->db->where('pack_id',$pack_id);
		$query = $this->db->get();
		return ($query->num_rows()==1);
	}
	//check trùng tên
	function getname( $id){
		if( $id > 0 ){
			$this->db->select('name');
			$this->db->where('pack_id !=', $id);
			$this->db->where('deleted',0);
			$this->db->from('packs');
			$query= $this->db->get();
		}elseif( $id =-1 ){
			$this->db->select('name');
			$this->db->where('deleted',0);
			$this->db->from('packs');
			$query= $this->db->get();
		}
		foreach($query->result_array() as $q){
			$result[] =	$q;
		}
		return $result;
	}
	function delete_list($pack_ids){
		$this->db->where_in('pack_id',$pack_ids);
		return $this->db->update('packs', array('deleted' => 1));
 	}
	function get_pack_search_suggestions($search, $limit=25){
		$suggestions = array();

		$this->db->from('packs');
		$this->db->like('name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->where('deleted',0);
		$this->db->order_by("name", "asc");
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=array('value' => 'PACK '.$row->pack_id, 'label' => $row->pack_number.' - '.$row->name);
		}
		
		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;
		
	}
	function get_pack_id($pack_number){
		$this->db->from('packs');
		$this->db->where('pack_number',$pack_number);

		$query = $this->db->get();

		if($query->num_rows()==1)
		{
			return $query->row()->pack_id;
		}

		return false;
	}
	
        public function all_pack(){
            return $this->db->get('packs')->result_array();
        }
        
         public function all_sales_pack($sale_id){
            $this->db->where('sale_id',$sale_id);
            return $this->db->get('sales_packs')->result();
        }
	
}