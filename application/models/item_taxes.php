<?php
class Item_taxes extends CI_Model
{
	/*
	Gets tax info for a particular item
	*/
	function get_info($item_id)
	{
		$this->db->from('items_taxes');
		$this->db->where('item_id',$item_id);
		$this->db->order_by('cumulative');
		//return an array of taxes for an item
		return $this->db->get()->result_array();
	}
	function get_info1($item_id)
	{
		$this->db->from('items_taxes');
		$this->db->where('item_id',$item_id);
		
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
			$fields = $this->db->list_fields('items_taxes');

			foreach ($fields as $field)
			{
				$item_obj->$field='';
			}

			return $item_obj;
		}
	}
	
	/*
	Inserts or updates an item's taxes
	*/
	function save(&$items_taxes_data, $item_id)
	{
		//Run these queries as a transaction, we want to make sure we do all or nothing
		$this->db->trans_start();

		$this->delete($item_id);
		
		foreach ($items_taxes_data as $row)
		{
			$row['item_id'] = $item_id;
			$this->db->insert('items_taxes',$row);		
		}
		
		$this->db->trans_complete();
		return true;
	}
	
	function save_multiple(&$items_taxes_data, $item_ids)
	{
		foreach($item_ids as $item_id)
		{
			$this->save($items_taxes_data, $item_id);
		}
	}

	/*
	Deletes taxes given an item
	*/
	function delete($item_id)
	{
		return $this->db->delete('items_taxes', array('item_id' => $item_id)); 
	}
}
?>
