<?php
class Money_birthdate extends Person
{
	function getReport($id){
		$this->db->where('person_id',$id);
		$query = $this->db->get('money_birthdate');
		if($query->num_rows()>0)
            {
                 return $query->result_array();
            }
		else return null ;
	}

	function save($data){
		$this->db->insert('money_birthdate',$data);
		return true;
	}
}
?>