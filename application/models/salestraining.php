<?php
class Sale extends CI_Model
{
	public function get_info($sale_id)
	{
		$this->db->from('sales');
		$this->db->where('sale_id',$sale_id);
		return $this->db->get();
	}
	
    
	function get_cash_sales_total_for_shift($shift_start, $shift_end)
    {
		$sales_totals = $this->get_sales_totaled_by_id($shift_start, $shift_end);
        $employee_id=$this->Employee->get_logged_in_employee_info()->person_id;
        
		$this->db->select('sales_payments.sale_id, sales_payments.payment_type, payment_amount', false);
        $this->db->from('sales_payments');
        $this->db->join('sales','sales_payments.sale_id=sales.sale_id');
		$this->db->where('sale_time >=', $shift_start);
		$this->db->where('sale_time <=', $shift_end);
		$this->db->where('employee_id', $employee_id);
		$this->db->where($this->db->dbprefix('sales').'.deleted', 0);
		
		$payments_by_sale = array();
		$sales_payments = $this->db->get()->result_array();
		
		foreach($sales_payments as $row)
		{
        	$payments_by_sale[$row['sale_id']][] = $row;
		}
		
		$payment_data = $this->Sale->get_payment_data($payments_by_sale,$sales_totals);
		
		if (isset($payment_data[lang('sales_cash')]))
		{
			return $payment_data[lang('sales_cash')]['payment_amount'];
		}
		
		return 0.00;
    }
	
	function get_payment_data($payments_by_sale,$sales_totals)
	{
		$payment_data = array();
				
		foreach($payments_by_sale as $sale_id => $payment_rows)
		{
			$total_sale_balance = $sales_totals[$sale_id];
			usort($payment_rows, array('Sale', '_sort_payments_for_sale'));
			
			foreach($payment_rows as $row)
			{
				$payment_amount = $row['payment_amount'] <= $total_sale_balance ? $row['payment_amount'] : $total_sale_balance;
				
				if (!isset($payment_data[$row['payment_type']]))
				{
					$payment_data[$row['payment_type']] = array('payment_type' => $row['payment_type'], 'payment_amount' => 0 );
				}
				
				if ($total_sale_balance != 0)
				{
					$payment_data[$row['payment_type']]['payment_amount'] += $payment_amount;
				}
				
				$total_sale_balance-=$payment_amount;
			}
		}
		
		return $payment_data;
	}
	
	static function _sort_payments_for_sale($a,$b)
	{
		if ($a['payment_amount'] == $b['payment_amount']);
		{
			return 0;
		}
		
		if ($a['payment_amount']< $b['payment_amount'])
		{
			return -1;
		}
		
		return 1;

	function get_sales_totaled_by_id($shift_start, $shift_end)
	{
		$where = 'WHERE sale_time BETWEEN "'.$shift_start.'" and "'.$shift_end.'"';
		$this->_create_sales_items_temp_table_query($where);
		
		$sales_totals = array();
		
		$this->db->select('sale_id, SUM(total) as total', false);
		$this->db->from('sales_items_temp');
		$this->db->group_by('sale_id');
			
		foreach($this->db->get()->result_array() as $sale_total_row)
		{
			$sales_totals[$sale_total_row['sale_id']] = $sale_total_row['total'];
		}
		
		return $sales_totals;
	}

	/**
	 * added for cash register
	 * insert a log for track_cash_log
	 * @param array $data
	 */
	
	function update_register_log($data) {
		$this->db->where('shift_end','0000-00-00 00:00:00');
		$this->db->where('employee_id',$this->session->userdata('person_id'));
		return $this->db->update('register_log', $data) ? true : false;		
	}
	function insert_register($data) {
		return $this->db->insert('register_log', $data) ? $this->db->insert_id() : false;		
	}
	
	function is_register_log_open()
	{
		$this->db->from('register_log');
		$this->db->where('shift_end','0000-00-00 00:00:00');
		$this->db->where('employee_id',$this->session->userdata('person_id'));
		$query = $this->db->get();
		if($query->num_rows())
		return true	;
		else
		return false;
	
	 }

	function get_current_register_log()
	{
		$this->db->from('register_log');
		$this->db->where('shift_end','0000-00-00 00:00:00');
		$this->db->where('employee_id',$this->session->userdata('person_id'));
		$query = $this->db->get();
		if($query->num_rows())
		return $query->row();
		else
		return false;	
	 }
	function exists($sale_id)
	{
		$this->db->from('sales');
		$this->db->where('sale_id',$sale_id);
		$query = $this->db->get();

		return ($query->num_rows()==1);
	}
	
	function update($sale_data, $sale_id)
	{
		$this->db->where('sale_id', $sale_id);
		$success = $this->db->update('sales',$sale_data);
		
		return $success;
	}
	
	function save ($items,$customer_id,$employee_id,$comment,$show_comment_on_receipt,$payments,$sale_id=false, $suspended = 0, $date_debt = null, $cc_ref_no = '')
	{
		if(count($items)==0)
			return -1;

		$payment_types='';
		foreach($payments as $payment_id=>$payment)
		{
			$payment_types=$payment_types.$payment['payment_type'].': '.to_currency($payment['payment_amount']).'<br />';
		}

		$sales_data = array(
			'sale_time' => date('Y-m-d H:i:s'),
			'customer_id'=> $this->Customer->exists($customer_id) ? $customer_id : null,
			'employee_id'=>$employee_id,
			'payment_type'=>$payment_types,
			'comment'=>$comment,
			'show_comment_on_receipt'=> $show_comment_on_receipt ?  $show_comment_on_receipt : 0,
			'suspended'=>$suspended,
			'deleted' => 0,
			'cc_ref_no' => $cc_ref_no,
			'date_debt'=> $date_debt
		);

		//Run these queries as a transaction, we want to make sure we do all or nothing
		$this->db->trans_start();
		if ($sale_id)
		{
			//Delete previoulsy sale so we can overwrite data
			$this->delete($sale_id, true);
			
			$this->db->where('sale_id', $sale_id);
			$this->db->update('sales', $sales_data);
		}
		else
		{
			$this->db->insert('sales',$sales_data);
			$sale_id = $this->db->insert_id();
		}
		$cost_payment_amount = 0;
		foreach($payments as $payment_id=>$payment)
		{
			$cost_payment_amount += $payment['payment_amount'];
			if ( substr( $payment['payment_type'], 0, strlen( lang('sales_giftcard') ) ) == lang('sales_giftcard') )
			{
				/* We have a gift card and we have to deduct the used value from the total value of the card. */
				$splitpayment = explode( ':', $payment['payment_type'] );
				$cur_giftcard_value = $this->Giftcard->get_giftcard_value( $splitpayment[1] );
				if(!$suspended)
				$this->Giftcard->update_giftcard_value( $splitpayment[1], $cur_giftcard_value - $payment['payment_amount'] );
			}

			$sales_payments_data = array
			(
				'sale_id'=>$sale_id,
				'payment_type'=>$payment['payment_type'],
				'payment_amount'=>$payment['payment_amount']
			);
			$this->db->insert('sales_payments',$sales_payments_data);
			if($suspended == 1){
			$cur_customer_info = $this->Customer->get_info($sales_data['customer_id']);
			 $sales_cus_inventory = array(
				'id_sale'=>$sale_id,
				'pay_type'=>$payment['payment_type'],
				'pay_amount'=>$payment['payment_amount'],
				'id_customer'=>$sales_data['customer_id'],
				'date'=> date('Y-m-d'),
				'id_city_code'=>$cur_customer_info->city,
				'deleted'=> 0
			);
			$this->db->insert('sales_inventory',$sales_cus_inventory); 
		}else {
			$array_sales_inventory = array('deleted'=>1);
			$this->db->where('id_sale',$sale_id);
			$this->db->update('sales_inventory',$array_sales_inventory);
		}
		}
		/* -------------------------------------------------------------- */
		$this->load->model('Cost');
		$cost_comment1 = "Thu tiền xuất bh sản phẩm từ ".$this->Customer->get_info($customer_id)->first_name ;
		$cost_data1 = array(
						 'id_customer'=>$customer_id,
						 'name'=>4,
						 'tien_thu'=>$cost_payment_amount,
						 'tien_chi'=>0,
						 'date'=>date('Y-m-d'),
						 'comment'=> $cost_comment1,
						 'deleted'=>0,
						 'id_sale'=>$sale_id
					);
		if($suspended == 1){
			if($this->Cost->find_sale_id($sale_id) == true){
				$this->Cost->delete_sale_id($sale_id);
			}
			$this->db->insert('costs',$cost_data1);
		}
		elseif($suspended == 0){
			if($this->Cost->find_sale_id($sale_id) == true){
				$this->Cost->delete_sale_id($sale_id);
			}
			$this->db->insert('costs',$cost_data1);
		}
		
		foreach($items as $line=>$item)
		{
			if (isset($item['item_id']))
			{
				$cur_item_info = $this->Item->get_info($item['item_id']);

				$sales_items_data = array
				(
					'sale_id'=>$sale_id,
					'item_id'=>$item['item_id'],
					'line'=>$item['line'],
					'description'=>$item['description'],
					'serialnumber'=>$item['serialnumber'],
					'quantity_purchased'=>$item['quantity'],
					'discount_percent'=>$item['discount'],
					'item_cost_price' => $cur_item_info->cost_price,
					'item_unit_price'=>$item['price'],
					'date'=> date('Y-m-d'),
					'cat_id'=>$cur_item_info->category
				);

				$this->db->insert('sales_items',$sales_items_data);
				$stock_recorder_check=false;
				$out_of_stock_check=false;
				$email=false;
				$message = '';
				
				//checks if the quantity is greater than reorder level
				if($cur_item_info->quantity > $cur_item_info->reorder_level)
				{
					$stock_recorder_check=true;
				}
				
				//checks if the quantity is greater than reorder level
				if($cur_item_info->quantity > 0)
				{
					$out_of_stock_check=true;
				}
				
				//Update stock quantity
				$item_data = array('quantity'=>$cur_item_info->quantity - $item['quantity']);
				$this->Item->save($item_data,$item['item_id']);
				
				//checks if the quantity is out of stock
				if($this->Item->get_info($item['item_id'])->quantity <= 0 and $out_of_stock_check)
				{
					$message= $this->Item->get_info($item['item_id'])->name.' '.lang('sales_is_out_stock').' '.$this->Item->get_info($item['item_id'])->quantity ;
					$email=true;
					
				}	
				//checks if the quantity hits reorder level 
				else if(($this->Item->get_info($item['item_id'])->quantity <= $this->Item->get_info($item['item_id'])->reorder_level) and $stock_recorder_check)
				{
					
					$message= $this->Item->get_info($item['item_id'])->name.' '.lang('sales_hits_reorder_level').' '.$this->Item->get_info($item['item_id'])->quantity ;
					$email=true;
				}
				
				//send email 
				if($this->config->item('receive_stock_alert') and $email)
				{			
					$this->load->library('email');
					$config['mailtype'] = 'html';				
					$this->email->initialize($config);
					$this->email->from($this->config->item('email'), $this->config->item('company'));
					$this->email->to($this->config->item('stock_alert_email') ? $this->config->item('stock_alert_email') : $this->config->item('email')); 

					$this->email->subject(lang('sales_stock_alert_item_name').$this->Item->get_info($item['item_id'])->name);
					$this->email->message($message);	
					$this->email->send();
				}
				//Ramel Inventory Tracking
				//Inventory Count Details
				$qty_buy = -$item['quantity'];
				$sale_remarks ='POS '.$sale_id;
				 $inv_data = array
				 (
					 'trans_date'=>date('Y-m-d H:i:s'),
					 'trans_items'=>$item['item_id'],
					 'trans_user'=>$employee_id,
					 'trans_comment'=>$sale_remarks,
					 'trans_inventory'=>$qty_buy,
					  'trans_catid'=>$cur_item_info->category,
					  'trans_money'=>$cost_payment_amount,
					  'trans_people'=>$this->Customer->exists($customer_id) ? $customer_id : 0,
					  'trans_sale'=>$sale_id
				 );
				if($this->Inventory->find_sale_id($sale_id,$item['item_id']) == null){
				 $this->Inventory->insert($inv_data);
				 $cost_comment = "Thu tiền xuất bh sản phẩm ".$this->Item->get_info($item['item_id'])->name." tư ".$this->Customer->get_info($customer_id)->first_name ;
				
				$cost_data = array(
						 'id_customer'=>$customer_id,
						 'name'=>4,
						 'tien_thu'=>$cost_payment_amount,
						'tien_chi'=>0,
						 'date'=>date('Y-m-d'),
						 'comment'=> $cost_comment,
						 'deleted'=>0,
						 'id_sale'=>$sale_id
					);
				if($suspended == 0){
				$this->load->model('Cost');
				if($this->Cost->find_sale_id($sale_id) == true){
				$this->Cost->delete_sale_id($sale_id);
				}
				$this->db->insert('costs',$cost_data);}
				} else 
				{
				 $this->Inventory->update($sale_id,$item['item_id'],$inv_data);
				}
				 
			}
			else
			{
				$cur_item_kit_info = $this->Item_kit->get_info($item['item_kit_id']);
				$sales_item_kits_data = array
				(
					'sale_id'=>$sale_id,
					'item_kit_id'=>$item['item_kit_id'],
					'line'=>$item['line'],
					'description'=>$item['description'],
					'quantity_purchased'=>$item['quantity'],
					'discount_percent'=>$item['discount'],
					'item_kit_cost_price' => $cur_item_kit_info->cost_price == NULL ? 0.00 : $cur_item_kit_info->cost_price,
					'item_kit_unit_price'=>$item['price']
				);

				$this->db->insert('sales_item_kits',$sales_item_kits_data);
				
				foreach($this->Item_kit_items->get_info($item['item_kit_id']) as $item_kit_item)
				{
					$cur_item_info = $this->Item->get_info($item_kit_item->item_id);
					
				$stock_recorder_check=false;
				$out_of_stock_check=false;
				$email=false;
				$message = '';


				//checks if the quantity is greater than reorder level
				if($cur_item_info->quantity > $cur_item_info->reorder_level)
				{
							$stock_recorder_check=true;
				}

				//checks if the quantity is greater than reorder level
				if($cur_item_info->quantity > 0)
				{
					$out_of_stock_check=true;
				}


				//Update stock quantity
				$item_data = array('quantity'=>$cur_item_info->quantity - ($item['quantity'] * $item_kit_item->quantity));
				$this->Item->save($item_data,$item_kit_item->item_id);

				//checks if the quantity is out of stock
				if($this->Item->get_info($item_kit_item->item_id)->quantity <= 0 and $out_of_stock_check)
				{
					$message= $this->Item->get_info($item_kit_item->item_id)->name.' '.lang('sales_is_out_stock').' '.$this->Item->get_info($item_kit_item->item_id)->quantity ;
					$email=true;

				}	
				//checks if the quantity hits reorder level 
				else if(($this->Item->get_info($item_kit_item->item_id)->quantity <= $this->Item->get_info($item_kit_item->item_id)->reorder_level) and $stock_recorder_check)
				{

					$message= $this->Item->get_info($item_kit_item->item_id)->name.' '.lang('sales_hits_reorder_level').' '.$this->Item->get_info($item_kit_item->item_id)->quantity ;
					$email=true;
				}

				//send email 
				if($this->config->item('receive_stock_alert') and $email)
				{			
					$this->load->library('email');
					$config['mailtype'] = 'html';				
					$this->email->initialize($config);
					$this->email->from($this->config->item('email'), $this->config->item('company'));
					$this->email->to($this->config->item('stock_alert_email') ? $this->config->item('stock_alert_email') : $this->config->item('email')); 

					$this->email->subject(lang('sales_stock_alert_item_name').$this->Item->get_info($item_kit_item->item_id)->name);
					$this->email->message($message);	
					$this->email->send();
				}

					//Ramel Inventory Tracking
					//Inventory Count Details
					$qty_buy = -$item['quantity'] * $item_kit_item->quantity;
					$sale_remarks ='POS '.$sale_id;
					$inv_data = array
					(
						'trans_date'=>date('Y-m-d H:i:s'),
						'trans_items'=>$item_kit_item->item_id,
						'trans_user'=>$employee_id,
						'trans_comment'=>$sale_remarks,
						'trans_inventory'=>$qty_buy,
						'trans_catid'=>$cur_item_info->category,
					 'trans_money'=>$item['price'],
					 'trans_people'=>$this->Customer->exists($customer_id) ? $customer_id : 0
					);
					$this->Inventory->insert($inv_data);					
				}
			}
			
			$customer = $this->Customer->get_info($customer_id);
 			if ($customer_id == -1 or $customer->taxable)
 			{
				if (isset($item['item_id']))
				{
					foreach($this->Item_taxes->get_info($item['item_id']) as $row)
					{
						$this->db->insert('sales_items_taxes', array(
							'sale_id' 	=>$sale_id,
							'item_id' 	=>$item['item_id'],
							'line'      =>$item['line'],
							'name'		=>$row['name'],
							'percent' 	=>$row['percent'],
							'cumulative'=>$row['cumulative']
						));
					}
				}
				else
				{
					foreach($this->Item_kit_taxes->get_info($item['item_kit_id']) as $row)
					{
						$this->db->insert('sales_item_kits_taxes', array(
							'sale_id' 		=>$sale_id,
							'item_kit_id'	=>$item['item_kit_id'],
							'line'      	=>$item['line'],
							'name'			=>$row['name'],
							'percent' 		=>$row['percent'],
							'cumulative'	=>$row['cumulative']
						));
					}					
				}
			}
		} 
		
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE)
		{
			return -1;
		}
		
		return $sale_id;
	}
	
	function delete($sale_id, $all_data = false)
	{
		$employee_id=$this->Employee->get_logged_in_employee_info()->person_id;
		
		$this->db->select('item_id, quantity_purchased');
		$this->db->from('sales_items');
		$this->db->where('sale_id', $sale_id);
		
		foreach($this->db->get()->result_array() as $sale_item_row)
		{
			$cur_item_info = $this->Item->get_info($sale_item_row['item_id']);	
			$item_data = array('quantity'=>$cur_item_info->quantity + $sale_item_row['quantity_purchased']);
			$this->Item->save($item_data,$sale_item_row['item_id']);
		
			$sale_remarks ='POS '.$sale_id;
			// $inv_data = array
			// (
				// 'trans_date'=>date('Y-m-d H:i:s'),
				// 'trans_items'=>$sale_item_row['item_id'],
				// 'trans_user'=>$employee_id,
				// 'trans_comment'=>$sale_remarks,
				// 'trans_inventory'=>$sale_item_row['quantity_purchased']
				// );
			// $this->Inventory->insert($inv_data);
		}
		
		$this->db->select('item_kit_id, quantity_purchased');
		$this->db->from('sales_item_kits');
		$this->db->where('sale_id', $sale_id);
		
		foreach($this->db->get()->result_array() as $sale_item_kit_row)
		{
			foreach($this->Item_kit_items->get_info($sale_item_kit_row['item_kit_id']) as $item_kit_item)
			{
				$cur_item_info = $this->Item->get_info($item_kit_item->item_id);
				
				$item_data = array('quantity'=>$cur_item_info->quantity + ($sale_item_kit_row['quantity_purchased'] * $item_kit_item->quantity));
				$this->Item->save($item_data,$item_kit_item->item_id);

				$sale_remarks ='POS '.$sale_id;
				$inv_data = array
				(
					'trans_date'=>date('Y-m-d H:i:s'),
					'trans_items'=>$item_kit_item->item_id,
					'trans_user'=>$employee_id,
					'trans_comment'=>$sale_remarks,
					'trans_inventory'=>$sale_item_kit_row['quantity_purchased'] * $item_kit_item->quantity
				);
				$this->Inventory->insert($inv_data);					
			}
		}
		
		if ($all_data)
		{
			//Run these queries as a transaction, we want to make sure we do all or nothing
			$this->db->trans_start();
			$this->db->delete('sales_payments', array('sale_id' => $sale_id)); 
			$this->db->delete('sales_items_taxes', array('sale_id' => $sale_id)); 
			$this->db->delete('sales_items', array('sale_id' => $sale_id)); 
			$this->db->delete('sales_item_kits_taxes', array('sale_id' => $sale_id)); 
			$this->db->delete('sales_item_kits', array('sale_id' => $sale_id)); 
			$this->db->trans_complete();			
		}
		$this->db->where('sale_id', $sale_id);
		return $this->db->update('sales', array('deleted' => 1));
	}
	
	function undelete($sale_id)
	{
		$employee_id=$this->Employee->get_logged_in_employee_info()->person_id;
		
		$this->db->select('item_id, quantity_purchased');
		$this->db->from('sales_items');
		$this->db->where('sale_id', $sale_id);
		
		foreach($this->db->get()->result_array() as $sale_item_row)
		{
			$cur_item_info = $this->Item->get_info($sale_item_row['item_id']);	
			$item_data = array('quantity'=>$cur_item_info->quantity - $sale_item_row['quantity_purchased']);
			$this->Item->save($item_data,$sale_item_row['item_id']);
		
			$sale_remarks ='POS '.$sale_id;
			$inv_data = array
			(
				'trans_date'=>date('Y-m-d H:i:s'),
				'trans_items'=>$sale_item_row['item_id'],
				'trans_user'=>$employee_id,
				'trans_comment'=>$sale_remarks,
				'trans_inventory'=>-$sale_item_row['quantity_purchased']
				);
			$this->Inventory->insert($inv_data);
		}
		
		$this->db->select('item_kit_id, quantity_purchased');
		$this->db->from('sales_item_kits');
		$this->db->where('sale_id', $sale_id);
		
		foreach($this->db->get()->result_array() as $sale_item_kit_row)
		{
			foreach($this->Item_kit_items->get_info($sale_item_kit_row['item_kit_id']) as $item_kit_item)
			{
				$cur_item_info = $this->Item->get_info($item_kit_item->item_id);
				
				$item_data = array('quantity'=>$cur_item_info->quantity - ($sale_item_kit_row['quantity_purchased'] * $item_kit_item->quantity));
				$this->Item->save($item_data,$item_kit_item->item_id);

				$sale_remarks ='POS '.$sale_id;
				$inv_data = array
				(
					'trans_date'=>date('Y-m-d H:i:s'),
					'trans_items'=>$item_kit_item->item_id,
					'trans_user'=>$employee_id,
					'trans_comment'=>$sale_remarks,
					'trans_inventory'=>-$sale_item_kit_row['quantity_purchased'] * $item_kit_item->quantity
				);
				$this->Inventory->insert($inv_data);					
			}
		}	
		$this->db->where('sale_id', $sale_id);
		return $this->db->update('sales', array('deleted' => 0));
	}

	function get_sale_items($sale_id)
	{
		$this->db->from('sales_items');
		$this->db->where('sale_id',$sale_id);
		return $this->db->get();
	}

	function get_sale_item_kits($sale_id)
	{
		$this->db->from('sales_item_kits');
		$this->db->where('sale_id',$sale_id);
		return $this->db->get();
	}
	
	function get_sale_items_taxes($sale_id)
	{
		$query = $this->db->query('SELECT name, percent, cumulative, item_unit_price as price, quantity_purchased as quantity, discount_percent as discount '.
		'FROM '. $this->db->dbprefix('sales_items_taxes'). ' JOIN '.
		$this->db->dbprefix('sales_items'). ' USING (sale_id, item_id, line) WHERE '.$this->db->dbprefix('sales_items_taxes').".sale_id = $sale_id");
		return $query->result_array();
	}
	
	function get_sale_item_kits_taxes($sale_id)
	{
		$query = $this->db->query('SELECT name, percent, cumulative, item_kit_unit_price as price, quantity_purchased as quantity, discount_percent as discount '.
		'FROM '. $this->db->dbprefix('sales_item_kits_taxes'). ' JOIN '.
		$this->db->dbprefix('sales_item_kits'). ' USING (sale_id, item_kit_id, line) WHERE '.$this->db->dbprefix('sales_item_kits_taxes').".sale_id = $sale_id");
		return $query->result_array();		
	}

	function get_sale_payments($sale_id)
	{
		$this->db->from('sales_payments');
		$this->db->where('sale_id',$sale_id);
		return $this->db->get();
	}

	function get_customer($sale_id)
	{
		$this->db->from('sales');
		$this->db->where('sale_id',$sale_id);
		return $this->Customer->get_info($this->db->get()->row()->customer_id);
	}
	
	function get_comment($sale_id)
	{
		$this->db->from('sales');
		$this->db->where('sale_id',$sale_id);
		return $this->db->get()->row()->comment;
	}
	
	function get_date_debt($sale_id)
	{
		$this->db->from('sales');
		$this->db->where('sale_id',$sale_id);
		return $this->db->get()->row()->date_debt;
	}
	
		function get_comment_on_receipt($sale_id)
	{
		$this->db->from('sales');
		$this->db->where('sale_id',$sale_id);
		return $this->db->get()->row()->show_comment_on_receipt;
	}
	

	//We create a temp table that allows us to do easy report/sales queries
	 function create_sales_items_temp_table($params)
	{
		$where = '';
		
		if (isset($params['start_date']) && isset($params['end_date']))
		{
			$where = 'WHERE sale_time BETWEEN "'.$params['start_date'].'" and "'.$params['end_date'].'"';
			
			if ($this->config->item('hide_suspended_sales_in_reports'))
			{
				$where .=' and suspended = 0';
			}
		}
		elseif ($this->config->item('hide_suspended_sales_in_reports'))
		{
			$where .='WHERE suspended = 0';
		}
		
		$this->_create_sales_items_temp_table_query($where);
	}
	
	function _create_sales_items_temp_table_query($where)
	{
		$this->db->query("CREATE TEMPORARY TABLE ".$this->db->dbprefix('sales_items_temp')."
		(SELECT ".$this->db->dbprefix('sales').".deleted as deleted, sale_time, date(sale_time) as sale_date, ".$this->db->dbprefix('sales_items').".sale_id, comment,payment_type, customer_id, employee_id, 
		".$this->db->dbprefix('items').".item_id, NULL as item_kit_id, supplier_id, quantity_purchased, item_cost_price, item_unit_price, category, 
		discount_percent, (item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100) as subtotal,
		".$this->db->dbprefix('sales_items').".line as line, serialnumber, ".$this->db->dbprefix('sales_items').".description as description,
		ROUND((item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100)+ROUND((item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100)*(SUM(CASE WHEN cumulative != 1 THEN percent ELSE 0 END)/100),2) 
		+((ROUND((item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100)*(SUM(CASE WHEN cumulative != 1 THEN percent ELSE 0 END)/100),2) + (item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100))
		*(SUM(CASE WHEN cumulative = 1 THEN percent ELSE 0 END))/100),2) as total,
		ROUND((item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100)*(SUM(CASE WHEN cumulative != 1 THEN percent ELSE 0 END)/100),2) 
		+((ROUND((item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100)*(SUM(CASE WHEN cumulative != 1 THEN percent ELSE 0 END)/100),2) + (item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100))
		*(SUM(CASE WHEN cumulative = 1 THEN percent ELSE 0 END))/100) as tax,
		(item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100) - (item_cost_price*quantity_purchased) as profit
		FROM ".$this->db->dbprefix('sales_items')."
		INNER JOIN ".$this->db->dbprefix('sales')." ON  ".$this->db->dbprefix('sales_items').'.sale_id='.$this->db->dbprefix('sales').'.sale_id'."
		INNER JOIN ".$this->db->dbprefix('items')." ON  ".$this->db->dbprefix('sales_items').'.item_id='.$this->db->dbprefix('items').'.item_id'."
		LEFT OUTER JOIN ".$this->db->dbprefix('suppliers')." ON  ".$this->db->dbprefix('items').'.supplier_id='.$this->db->dbprefix('suppliers').'.person_id'."
		LEFT OUTER JOIN ".$this->db->dbprefix('sales_items_taxes')." ON  "
		.$this->db->dbprefix('sales_items').'.sale_id='.$this->db->dbprefix('sales_items_taxes').'.sale_id'." and "
		.$this->db->dbprefix('sales_items').'.item_id='.$this->db->dbprefix('sales_items_taxes').'.item_id'." and "
		.$this->db->dbprefix('sales_items').'.line='.$this->db->dbprefix('sales_items_taxes').'.line'. "
		$where
		GROUP BY sale_id, item_id, line) 
		UNION ALL
		(SELECT ".$this->db->dbprefix('sales').".deleted as deleted, sale_time, date(sale_time) as sale_date, ".$this->db->dbprefix('sales_item_kits').".sale_id, comment,payment_type, customer_id, employee_id, 
		NULL as item_id, ".$this->db->dbprefix('item_kits').".item_kit_id, '' as supplier_id, quantity_purchased, item_kit_cost_price, item_kit_unit_price, category, 
		discount_percent, (item_kit_unit_price*quantity_purchased-item_kit_unit_price*quantity_purchased*discount_percent/100) as subtotal,
		".$this->db->dbprefix('sales_item_kits').".line as line, '' as serialnumber, ".$this->db->dbprefix('sales_item_kits').".description as description,
		ROUND((item_kit_unit_price*quantity_purchased-item_kit_unit_price*quantity_purchased*discount_percent/100)+ROUND((item_kit_unit_price*quantity_purchased-item_kit_unit_price*quantity_purchased*discount_percent/100)*(SUM(CASE WHEN cumulative != 1 THEN percent ELSE 0 END)/100),2) 
		+((ROUND((item_kit_unit_price*quantity_purchased-item_kit_unit_price*quantity_purchased*discount_percent/100)*(SUM(CASE WHEN cumulative != 1 THEN percent ELSE 0 END)/100),2) + (item_kit_unit_price*quantity_purchased-item_kit_unit_price*quantity_purchased*discount_percent/100))
		*(SUM(CASE WHEN cumulative = 1 THEN percent ELSE 0 END))/100),2) as total,
		ROUND((item_kit_unit_price*quantity_purchased-item_kit_unit_price*quantity_purchased*discount_percent/100)*(SUM(CASE WHEN cumulative != 1 THEN percent ELSE 0 END)/100),2) 
		+((ROUND((item_kit_unit_price*quantity_purchased-item_kit_unit_price*quantity_purchased*discount_percent/100)*(SUM(CASE WHEN cumulative != 1 THEN percent ELSE 0 END)/100),2) + (item_kit_unit_price*quantity_purchased-item_kit_unit_price*quantity_purchased*discount_percent/100))
		*(SUM(CASE WHEN cumulative = 1 THEN percent ELSE 0 END))/100) as tax,
		(item_kit_unit_price*quantity_purchased-item_kit_unit_price*quantity_purchased*discount_percent/100) - (item_kit_cost_price*quantity_purchased) as profit
		FROM ".$this->db->dbprefix('sales_item_kits')."
		INNER JOIN ".$this->db->dbprefix('sales')." ON  ".$this->db->dbprefix('sales_item_kits').'.sale_id='.$this->db->dbprefix('sales').'.sale_id'."
		INNER JOIN ".$this->db->dbprefix('item_kits')." ON  ".$this->db->dbprefix('sales_item_kits').'.item_kit_id='.$this->db->dbprefix('item_kits').'.item_kit_id'."
		LEFT OUTER JOIN ".$this->db->dbprefix('sales_item_kits_taxes')." ON  "
		.$this->db->dbprefix('sales_item_kits').'.sale_id='.$this->db->dbprefix('sales_item_kits_taxes').'.sale_id'." and "
		.$this->db->dbprefix('sales_item_kits').'.item_kit_id='.$this->db->dbprefix('sales_item_kits_taxes').'.item_kit_id'." and "
		.$this->db->dbprefix('sales_item_kits').'.line='.$this->db->dbprefix('sales_item_kits_taxes').'.line'. "
		$where
		GROUP BY sale_id, item_kit_id, line) ORDER BY sale_id, line");
	}
	
	 function get_giftcard_value( $giftcardNumber )
	{
		if ( !$this->Giftcard->exists( $this->Giftcard->get_giftcard_id($giftcardNumber)))
			return 0;
		
		$this->db->from('giftcards');
		$this->db->where('giftcard_number',$giftcardNumber);
		return $this->db->get()->row()->value;
	}
	
	function get_all_suspended()
	{
		$this->db->from('sales');
		$this->db->where('deleted', 0);
		$this->db->where('suspended', 1);
		$this->db->order_by('sale_id');
		return $this->db->get();
	}
}
}
?>
