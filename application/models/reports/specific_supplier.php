<?php

require_once("report.php");

class Specific_supplier extends Report {

    function __construct() {
        parent::__construct();
    }

    public function getDataColumns() {
        return array('summary' => array(
                array('data' => lang('reports_receiving_id'), 'align' => 'center'),
                array('data' => lang('reports_date'), 'align' => 'center'),
                array('data' => "Nhà cung cấp", 'align' => 'center'),
                array('data' => lang('reports_received_by'), 'align' => 'center'),
                array('data' => 'SL nhập', 'align' => 'center'),
                array('data' => 'Tổng tiền hàng', 'align' => 'center'),
                array('data' => 'Chi phí', 'align' => 'center'),
                array('data' => 'Thuế', 'align' => 'center'),
                array('data' => lang('reports_total'), 'align' => 'center'),
                //array('data'=>lang('reports_payment_type'), 'align'=>'left'), 
                array('data' => lang('reports_comments'), 'align' => 'center')),
            'details' => array(
                array('data' => 'Mã sản phẩm', 'align' => 'center'),
                array('data' => lang('reports_name'), 'align' => 'center'),
                array('data' => lang('reports_category'), 'align' => 'center'),
                array('data' => 'ĐVT', 'align' => 'center'),
                array('data' => 'SL nhập', 'align' => 'center'),
                array('data' => lang('reports_total'), 'align' => 'center'),
                array('data' => lang('reports_discount'), 'align' => 'center'),
                array('data' => 'Tổng sau CK', 'align' => 'center'),
                array('data' => 'Ghi chú', 'align' => 'center'))
        );
    }

    public function getData() {
        $this->db->select('receiving_id, receiving_date, money_1331, other_cost, sum(quantity_purchased) as items_purchased, CONCAT_WS(" ",employee.first_name,employee.last_name) as employee_name, CONCAT_WS(" ",supplier.first_name,supplier.last_name) as supplier_name,sum(subtotal) as subtotal,discount_percent, sum(total) as total, sum(profit) as profit, payment_type as payment, comment', false);
        $this->db->from('receivings_items_temp');
        $this->db->join('people as employee', 'receivings_items_temp.employee_id = employee.person_id');
        $this->db->join('people as supplier', 'receivings_items_temp.supplier_id = supplier.person_id', 'left');
        $this->db->where('supplier_id = ' . $this->params['supplier_id']);
        if($this->params['sale_type'] != 'all'){
            if ($this->params['sale_type'] == 'sales') {
                $this->db->where('quantity_purchased > 0');
            } else {
                $this->db->where('quantity_purchased < 0');
            }
        }
        $this->db->where('deleted', 0);
        $this->db->group_by('receiving_id');
        $this->db->order_by('receiving_date','desc');

        $data = array();
        $data['summary'] = $this->db->get()->result_array();
        $data['details'] = array();

        foreach ($data['summary'] as $key => $value) {
            $this->db->select('unit ,items.item_number, items.name, ci.name as category, quantity_purchased,receivings_items_temp.description as description, serialnumber,subtotal,total, discount_percent');
            $this->db->from('receivings_items_temp');
            $this->db->join('items', 'receivings_items_temp.item_id = items.item_id');
            $this->db->join('categories_item ci', 'receivings_items_temp.cat_id = ci.id_cat');
            $this->db->where('receiving_id = ' . $value['receiving_id']);
            $data['details'][$key] = $this->db->get()->result_array();
        }

        return $data;
    }

    public function getSummaryData() {
        $this->db->select('sum(subtotal) as subtotal,sum(total) as total');
        $this->db->from('receivings_items_temp');
        $this->db->where('supplier_id = ' . $this->params['supplier_id']);
        //$this->db->where('receiving_date BETWEEN "'. $this->params['start_date']. '" and "'. $this->params['end_date'].'" and supplier_id='.$this->params['supplier_id']);
        if ($this->params['sale_type'] == 'receivings') {
            $this->db->where('quantity_purchased > 0');
        } elseif ($this->params['sale_type'] == 'returns') {
            $this->db->where('quantity_purchased < 0');
        }
        $this->db->where('deleted', 0);
        return $this->db->get()->row_array();
    }

}

?>