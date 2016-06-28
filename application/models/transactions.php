<?php

class Transactions extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_data1113($start_date, $end_date) {

        //	$this->db->select('Ngay_giaoca');

        $this->db->distinct('Ngay_giaoca');
        $this->db->where("(Ngay_giaoca > '$start_date') OR (Ngay_giaoca = '$start_date')");
        $this->db->where("(Ngay_giaoca < '$end_date') OR (Ngay_giaoca = '$end_date')");
        $query = $this->db->get('register_log');
        //var_dump($this->db->last_query());exit();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }
    
public function get_data($start_date, $end_date) {

        //	$this->db->select('Ngay_giaoca');

        $this->db->distinct('shift_start');
        $this->db->where("(shift_start >= '$start_date')");
        $this->db->where("(shift_start <='$end_date')");
        $query = $this->db->get('register_log');
       // var_dump($this->db->last_query());exit();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }
	
	//bc giao ca
	public function get_data_giaoca($start_date, $end_date) {

        //	$this->db->select('Ngay_giaoca');

        $this->db->distinct('Ngay_giaoca');
        $this->db->where("(Ngay_giaoca >= '$start_date')");
        $this->db->where("(Ngay_giaoca <='$end_date')");
        $query = $this->db->get('register_log');
       // var_dump($this->db->last_query());exit();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    //
    
public function get_data_cash($start_date, $end_date) {

        //	$this->db->select('Ngay_giaoca');

        //$this->db->distinct('Ngay_giaoca');
        $this->db->where("(shift_end >= '$start_date')");
        $this->db->where("(shift_end <='$end_date')");
        $query = $this->db->get('register_log');
       // var_dump($this->db->last_query());exit();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    public function get_sum_money_register_log($start_date, $end_date) {
        $this->db->select('SUM(Tien_boket) as Tien_boket1');
        $this->db->distinct('Ngay_giaoca');
//        $this->db->where('Ngay_giaoca >= ', $start_date);
//        $this->db->where('Ngay_giaoca <= ', $end_date);
        $this->db->where("(Ngay_giaoca > '$start_date') OR (Ngay_giaoca = '$start_date')");
        $this->db->where("(Ngay_giaoca < '$end_date') OR (Ngay_giaoca = '$end_date')");
        $query = $this->db->get('register_log');
        if ($query->num_rows() > 0) {
            return $query->row()->Tien_boket1;
        } else
            return null;
    }

}

?>