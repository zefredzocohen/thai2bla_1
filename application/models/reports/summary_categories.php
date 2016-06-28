<?php
require_once("report.php");
class Summary_categories extends Report
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function getDataColumns()
	{
		return array(array('data'=>lang('reports_category'), 'align'=> 'left'), 
					array('data'=>lang('reports_subtotal'), 'align'=> 'right'), 
					array('data'=>lang('reports_tax'), 'align'=> 'right'), 
					array('data'=>lang('reports_total'), 'align'=> 'right'), 
					array('data'=>lang('reports_profit'), 'align'=> 'right'));
	}
	
	public function getData()
	{
		$this->db->select('ci.name as category, sum(subtotal) as subtotal,  
			sum(total) as total, sum(taxes*subtotal/100) tax, sum(profit) as profit, i.taxes');
		$this->db->from('sales_items_temp');
		$this->db->join('items i', 'sales_items_temp.item_id = i.item_id');
		$this->db->join('categories_item ci', 'sales_items_temp.category = ci.id_cat');
		if ($this->params['sale_type'] == 'sales')
		{
			$this->db->where('quantity_purchased > 0');
		}
		elseif ($this->params['sale_type'] == 'returns')
		{
			$this->db->where('quantity_purchased < 0');
		}
		
		if ($this->params['cat_service'] == 'items')
		{
			$this->db->where('cat_service = 0');
		}
		elseif ($this->params['cat_service'] == 'service')
		{
			$this->db->where('cat_service = 1');
		}		
		$this->db->where($this->db->dbprefix('sales_items_temp').'.deleted', 0);
		$this->db->group_by('category');
		$this->db->order_by('category');
		return $this->db->get()->result_array();		
	}
	
	public function getSummaryData()
	{
		$this->db->select('sum(subtotal) as subtotal, sum(taxes*subtotal/100) tax, 
			sum(total) as total, sum(profit) as profit');
		$this->db->from('sales_items_temp');
		$this->db->join('items i', 'sales_items_temp.item_id = i.item_id');
		$this->db->join('categories_item ci', 'sales_items_temp.category = ci.id_cat');
		if ($this->params['sale_type'] == 'sales')
		{
			$this->db->where('quantity_purchased > 0');
		}
		elseif ($this->params['sale_type'] == 'returns')
		{
			$this->db->where('quantity_purchased < 0');
		}
			
		if ($this->params['cat_service'] == 'items')
		{
			$this->db->where('cat_service = 0');
		}
		elseif ($this->params['cat_service'] == 'service')
		{
			$this->db->where('cat_service = 1');
		}		
		$this->db->where($this->db->dbprefix('sales_items_temp').'.deleted', 0);
		return $this->db->get()->row_array();
	}
}
?>