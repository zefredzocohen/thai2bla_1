<?php

class Nhomts_thietbis extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}
	
	function exists($tstb_id)
	{
		$this->db->from('nhomts_thietbi');
		$this->db->where('id_tstb',$tstb_id);
		//$this->db->where('deleted',0);
		$query = $this->db->get();

		return ($query->num_rows()==1);
	}

	function get_all($limit=100,$offset=0,$col='id_tstb',$order='asc')
	{
		$this->db->from('nhomts_thietbi');
		//$this->db->where('deleted',0);
		$this->db->order_by($col, $order);
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();
	}
	
	function count_all()
	{
		$this->db->from('nhomts_thietbi');
		//$this->db->where('deleted',0);
		return $this->db->count_all_results();
	}

	function get_info($tstb_id)
	{
		$this->db->from('nhomts_thietbi');
		$this->db->where('id_tstb',$tstb_id);
		//$this->db->where('deleted',0);
		$query = $this->db->get();

		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			//Get empty base parent object, as $giftcard_id is NOT an giftcard
			$giftcard_obj=new stdClass();

			//Get all the fields from giftcards table
			$fields = $this->db->list_fields('nhomts_thietbi');

			foreach ($fields as $field)
			{
				$giftcard_obj->$field='';
			}

			return $giftcard_obj;
		}
	}
	function save(&$sup_data,$tstb_id=false)
	{
		if (!$tstb_id or !$this->exists($tstb_id))
		{
			if($this->db->insert('nhomts_thietbi',$sup_data))
			{
				$sup_data['id_tstb']=$this->db->insert_id();
				return true;
			}
			return false;
		}

		$this->db->where('id_tstb', $tstb_id);
		return $this->db->update('nhomts_thietbi',$sup_data);
	}

	// function delete_list($id)
	// {
	// 	if(!$select_inventory){
	// 	$this->db->where_in('id_tstb',$id);
	// 	}
	// 	return $this->db->update('nhomts_thietbi');
 // 	}
 	public function get_name_sup($id)
	     {
	     	$this->db->where('id_tstb',$id);
	     	$query=$this->db->get('nhomts_thietbi');
	     	$data['result']=$query->row_array();
	     	return $data['result']['name_sup_type'];
	     }
 	public function delete_db($id)
	{
		$this->db->where_in('id_tstb',$id);
		  if( $this->db->delete('nhomts_thietbi')){
		   return true;
		  }else return $this->db->_error_message();
	}

	 public function get_select_dropdown()
   {
		//$this->db->from('nhomts_thietbi');		
		$query=$this->db->get('nhomts_thietbi');
		return $query->result_array();		

   }


}

/* End of file supplier_type.php */
/* Location: ./application/models/supplier_type.php */
/* End of file Nhomts_thietbis.php */
/* Location: ./application/models/Nhomts_thietbis.php */