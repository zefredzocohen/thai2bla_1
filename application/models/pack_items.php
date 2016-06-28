<?php
class Pack_items extends CI_Model {
	function save(&$pack_items_data, $pack_id) {
        //Run these queries as a transaction, we want to make sure we do all or nothing
        $this->db->trans_start();
        $this->delete($pack_id);
        foreach ($pack_items_data as $row) {
            $row['pack_id'] = $pack_id;
            $this->db->insert('pack_items', $row);
        }
        $this->db->trans_complete();
        return true;
    }
    function delete($pack_id) {
        return $this->db->delete('pack_items', array('pack_id' => $pack_id));
    }
    function get_info($pack_id) {
        $this->db->from('pack_items');
        $this->db->where('pack_id', $pack_id);
        //return an array of item kit items for an item
        return $this->db->get()->result();
    }
    function get_packs_have_item($item_id) {
        $this->db->from('pack_items');
        $this->db->where('item_id', $item_id);
        return $this->db->get()->result_array();
    }
    
    public function get_all(){
        $this->db->from('pack_items');
        return $this->db->get()->result_array();
    }
    
}

?>
