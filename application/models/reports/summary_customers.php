<?php
require_once("report.php");
class Summary_customers extends Report
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function getDataColumns()
	{
		return array(
                    array('data'=>lang('reports_customer'), 'align'=>'left'), 
                    array('data'=>lang('reports_subtotal'), 'align'=> 'right'),
                    array('data'=>lang('reports_tax'), 'align'=> 'right'),
                    array('data'=>lang('reports_total'), 'align'=> 'right'),
                    array('data'=>lang('reports_profit'), 'align'=> 'right'));
	}
	
	public function getData()
	{
		$this->db->select('CONCAT_WS(" ",first_name,last_name) as customer, sum(subtotal) as subtotal, 
			sum(total) as total, sum(taxes * subtotal/100) as tax, sum(profit) as profit', false);
		$this->db->from('sales_items_temp');
		$this->db->join('items', 'sales_items_temp.item_id = items.item_id');
		$this->db->join('customers', 'customers.person_id = sales_items_temp.customer_id');
		$this->db->join('people', 'customers.person_id = people.person_id');
		$this->db->join('sales', 'sales_items_temp.sale_id = sales.sale_id');
		if ($this->params['sale_type'] == 'sales')
		{
			$this->db->where('quantity_purchased > 0');
		}
		elseif ($this->params['sale_type'] == 'returns')
		{
			$this->db->where('quantity_purchased < 0');
		}
		
		if ($this->params['service'] == 'items')
		{
			$this->db->where('service = 0');
		}
		elseif ($this->params['service'] == 'service')
		{
			$this->db->where('service = 1');
		}
		
		$this->db->where($this->db->dbprefix('sales_items_temp').'.deleted', 0);
		$this->db->group_by('customer_id');
		$this->db->order_by('last_name');

		return $this->db->get()->result_array();		
	}
	
	public function getNoCustomerData()
	{
		$this->db->select('"'.lang('reports_no_customer').'" as customer, sum(subtotal) as subtotal, 
			sum(total) as total, sum(taxes * subtotal/100) as tax, sum(profit) as profit', false);
		$this->db->from('sales_items_temp');
		$this->db->join('items', 'sales_items_temp.item_id = items.item_id');
		if ($this->params['sale_type'] == 'sales')
		{
			$this->db->where('quantity_purchased > 0');
		}
		elseif ($this->params['sale_type'] == 'returns')
		{
			$this->db->where('quantity_purchased < 0');
		}
		
		if ($this->params['service'] == 'items')
		{
			$this->db->where('service = 0');
		}
		elseif ($this->params['service'] == 'service')
		{
			$this->db->where('service = 1');
		}

		$this->db->where($this->db->dbprefix('sales_items_temp').'.deleted', 0);
		$this->db->where('customer_id',NULL);
		$this->db->group_by('customer_id');		

		return $this->db->get()->result_array();		
	}
	
	public function getSummaryData()
	{
		$this->db->select('sum(subtotal) as subtotal, sum(total) as total,
			sum(taxes * subtotal/100) as tax, sum(profit) as profit');
		$this->db->from('sales_items_temp');
		$this->db->join('items', 'sales_items_temp.item_id = items.item_id');
		if ($this->params['sale_type'] == 'sales')
		{
			$this->db->where('quantity_purchased > 0');
		}
		elseif ($this->params['sale_type'] == 'returns')
		{
			$this->db->where('quantity_purchased < 0');
		}

		if ($this->params['service'] == 'items')
		{
			$this->db->where('service = 0');
		}
		elseif ($this->params['service'] == 'service')
		{
			$this->db->where('service = 1');
		}

		$this->db->where($this->db->dbprefix('sales_items_temp').'.deleted', 0);
		return $this->db->get()->row_array();
	}
	
	//hung audi 20-4-15
    public function getData2()
	{
		$this->db->select('CONCAT_WS(" ",first_name,last_name) as customer, sum(subtotal) as subtotal,  sum(taxes_percent * subtotal/100) as tax,(sum(total)+sum(taxes_percent * subtotal/100)) as total,sum(profit) as profit', false);
		$this->db->from('sales_items_temp');
		$this->db->join('items', 'sales_items_temp.item_id = items.item_id');
        $this->db->join('sales_items','items.item_id=sales_items.item_id');
		$this->db->join('customers', 'customers.person_id = sales_items_temp.customer_id');
		$this->db->join('people', 'customers.person_id = people.person_id');
		
		if ($this->params['sale_type'] == 'sales')
		{
			$this->db->where('quantity_purchased > 0');
		}
		elseif ($this->params['sale_type'] == 'returns')
		{
			$this->db->where('quantity_purchased < 0');
		}
		
		if ($this->params['service'] == 'items')
		{
			$this->db->where('service = 0');
		}
		elseif ($this->params['service'] == 'service')
		{
			$this->db->where('service = 1');
		}
		
		$this->db->where($this->db->dbprefix('sales_items_temp').'.deleted', 0);
		$this->db->group_by('customer_id');
		$this->db->order_by('last_name');

		return $this->db->get()->result_array();		
	}
	
	public function getNoCustomerData2()
	{
		$this->db->select('"'.lang('reports_no_customer').'" as customer, sum(subtotal) as subtotal, sum(taxes_percent * subtotal/100) as tax, (sum(total)+sum(taxes_percent * subtotal/100)) as total,sum(profit) as profit', false);
		$this->db->from('sales_items_temp');
		$this->db->join('items', 'sales_items_temp.item_id = items.item_id');
        $this->db->join('sales_items','items.item_id=sales_items.item_id');
        
		if ($this->params['sale_type'] == 'sales')
		{
			$this->db->where('quantity_purchased > 0');
		}
		elseif ($this->params['sale_type'] == 'returns')
		{
			$this->db->where('quantity_purchased < 0');
		}
		
		if ($this->params['service'] == 'items')
		{
			$this->db->where('service = 0');
		}
		elseif ($this->params['service'] == 'service')
		{
			$this->db->where('service = 1');
		}

		$this->db->where($this->db->dbprefix('sales_items_temp').'.deleted', 0);
		$this->db->where('customer_id',NULL);
		$this->db->group_by('customer_id');		

		return $this->db->get()->result_array();		
	}
	
	public function getSummaryData2()
	{
		$this->db->select('sum(subtotal) as subtotal, sum(taxes_percent * subtotal/100) as tax,(sum(total)+sum(taxes_percent * subtotal/100)) as total, sum(profit) as profit');
		$this->db->from('sales_items_temp');
		$this->db->join('items', 'sales_items_temp.item_id = items.item_id');
        $this->db->join('sales_items','items.item_id=sales_items.item_id');
        
		if ($this->params['sale_type'] == 'sales')
		{
			$this->db->where('quantity_purchased > 0');
		}
		elseif ($this->params['sale_type'] == 'returns')
		{
			$this->db->where('quantity_purchased < 0');
		}

		if ($this->params['service'] == 'items')
		{
			$this->db->where('service = 0');
		}
		elseif ($this->params['service'] == 'service')
		{
			$this->db->where('service = 1');
		}

		$this->db->where($this->db->dbprefix('sales_items_temp').'.deleted', 0);
		return $this->db->get()->row_array();
	}
}
?>