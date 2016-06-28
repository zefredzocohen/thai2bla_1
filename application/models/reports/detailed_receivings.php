<?php

require_once("report.php");

class Detailed_receivings extends Report {

    function __construct() {
        parent::__construct();
    }

    public function getDataColumns() {
        return array('summary' => array(
                array('data' => lang('reports_receiving_id'), 'align' => 'center'),
                array('data' => lang('reports_date'), 'align' => 'center'),
                array('data' => 'Nhân viên', 'align' => 'center'),
                array('data' => 'Nhà cung cấp', 'align' => 'center'),
                array('data' => 'SL nhập', 'align' => 'center'),
                array('data' => lang('reports_total').('(Bao gồm chi phí và thuế)'), 'align' => 'center'),
                //array('data'=>lang('reports_payment_type'), 'align'=>'left'), 
                array('data' => lang('reports_comments'), 'align' => 'center')),
            'details' => array(
                array('data' => lang('reports_name'), 'align' => 'center'),
                array('data' => 'Loại', 'align' => 'center'),
                array('data' => 'ĐVT', 'align' => 'center'),
                array('data' => lang('reports_quantity_purchased'), 'align' => 'center'),
                array('data' => 'Giá nhập', 'align' => 'center'),
                array('data' => lang('reports_total'), 'align' => 'center'),
                array('data' => 'Chiết khấu (%)', 'align' => 'center'))
        );
    }

    public function getData() {
        $this->db->select('supplier_id ,receiving_id, receiving_date, other_cost, money_1331, sum(quantity_purchased) as items_purchased, supplier_id,CONCAT_WS(employee.first_name," ",employee.last_name) as employee_name, supplier.first_name as supplier_name, sum(total) as total, sum(profit) as profit, payment_type, comment, status_currency', false);
        $this->db->from('receivings_items_temp');
        $this->db->join('people as supplier', 'receivings_items_temp.supplier_id = supplier.person_id', 'left');
        $this->db->join('people as employee', 'receivings_items_temp.employee_id = employee.person_id');
        if ($this->params['sale_type'] == 'sales') {
            $this->db->where('quantity_purchased > 0');
        } elseif ($this->params['sale_type'] == 'returns') {
            $this->db->where('quantity_purchased < 0');
        }
        //$this->db->where('deleted', 0);
        $this->db->where('status_currency',0);
        $this->db->group_by('receiving_id');
        $this->db->order_by('receiving_date','desc');
        $data = array();
        $data['summary'] = $this->db->get()->result_array();

        $data['details'] = array();

        foreach ($data['summary'] as $key => $value) {
            $this->db->select('items.name as name,units.name as units_name, categories_item.name as cat_name,item_unit_price, quantity_purchased, serialnumber,total, discount_percent');
            $this->db->from('receivings_items_temp');
            $this->db->join('items', 'receivings_items_temp.item_id = items.item_id');
            $this->db->join('units', 'items.unit = units.id_unit');
            $this->db->join('categories_item', 'items.category = categories_item.id_cat');
            $this->db->where('receiving_id = ' . $value['receiving_id']);
            $data['details'][$key] = $this->db->get()->result_array();
        }

        return $data;
    }

    public function getSummaryData() {
        $this->db->select('sum(total) as total');
        $this->db->from('receivings_items_temp');
        if ($this->params['sale_type'] == 'sales') {
            $this->db->where('quantity_purchased > 0');
        } elseif ($this->params['sale_type'] == 'returns') {
            $this->db->where('quantity_purchased < 0');
        }
        //$this->db->where('deleted', 0);
         $this->db->where('status_currency',0);
        return $this->db->get()->row_array();
    }

}

?>