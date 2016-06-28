<?php
require_once("report.php");
class Summary_suppliers extends Report
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function getDataColumns()
	{
		return array(
					array('data'=>lang('reports_supplier'), 'align'=>'left'), 
					array('data'=>"Nhân viên giao dịch", 'align'=>'left'), 
					
					array('data'=>'Số lượng', 'align'=> 'right'), 
					array('data'=>lang('reports_total'), 'align'=> 'right'),
					//array('data'=>lang('reports_tax'), 'align'=> 'right'), 
					array('data'=>lang('reports_profit'), 'align'=> 'right'));
	}
	
	public function getData()
	{
		$this->db->select('supplier.first_name as supplier_name,CONCAT_WS(" ",employee.first_name, employee.last_name) as employee, suppliers.company_name as company_name,sum(quantity_purchased) as items_purchased,sum(subtotal) as subtotal , sum(total) as total, sum(profit) as profit', false);
		$this->db->from('receivings_items_temp');
		$this->db->join('people as employee', 'receivings_items_temp.employee_id = employee.person_id');
		$this->db->join('people as supplier', 'receivings_items_temp.supplier_id = supplier.person_id', 'left');
		$this->db->join('suppliers as suppliers', 'receivings_items_temp.supplier_id = suppliers.person_id', 'left');
		if ($this->params['sale_type'] == 'receivings')
		{
			$this->db->where('quantity_purchased > 0');
		}
		elseif ($this->params['sale_type'] == 'returns')
		{
			$this->db->where('quantity_purchased < 0');
		}
		$this->db->where('receivings_items_temp.deleted', 0);
		$this->db->where('receivings_items_temp.supplier_id IS NOT NULL');
		$this->db->group_by('receiving_id');
		$this->db->order_by('receiving_date');
		
		return $this->db->get()->result_array();
	}
	
	public function getNoSuppliersData()
	{
		$this->db->select('"'."Không có tên người giao dịch".'" as supplier_name,"Không có nhà cung cấp" as company_name,CONCAT_WS(" ",employee.first_name, employee.last_name) as employee,sum(quantity_purchased) as items_purchased,sum(subtotal) as subtotal ,sum(total) as total, sum(profit) as profit', false);
		$this->db->from('receivings_items_temp');
		$this->db->join('people as employee', 'receivings_items_temp.employee_id = employee.person_id');
		$this->db->join('suppliers as suppliers', 'receivings_items_temp.supplier_id = suppliers.person_id', 'left');
		if ($this->params['sale_type'] == 'receivings')
		{
			$this->db->where('quantity_purchased > 0');
		}
		elseif ($this->params['sale_type'] == 'returns')
		{
			$this->db->where('quantity_purchased < 0');
		}
		
		$this->db->where($this->db->dbprefix('receivings_items_temp').'.deleted', 0);
		$this->db->where('receivings_items_temp.supplier_id IS NULL');
		$this->db->group_by('supplier_id');		

		return $this->db->get()->result_array();		
	}
	
	public function getSummaryData()
	{
		$this->db->select('sum(total) as total, sum(profit) as profit');
		$this->db->from('receivings_items_temp');
		//$this->db->join('suppliers', 'suppliers.person_id = receivings_items_temp.supplier_id');
		//$this->db->join('people', 'suppliers.person_id = people.person_id');
		$this->db->join('people as supplier', 'receivings_items_temp.supplier_id = supplier.person_id', 'left');
		if ($this->params['sale_type'] == 'receivings')
		{
			$this->db->where('quantity_purchased > 0');
		}
		elseif ($this->params['sale_type'] == 'returns')
		{
			$this->db->where('quantity_purchased < 0');
		}
		
		$this->db->where($this->db->dbprefix('receivings_items_temp').'.deleted', 0);
		//$this->db->where('deleted', 0);
		return $this->db->get()->row_array();
	}
}
?>