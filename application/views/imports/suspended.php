<table id="contents" style="width: 1120px;font-size: 14px!important">
	<tr>
		<td id="item_table">
			<table  id="suspended_sales_table" class="receiving_suspended">
				<tr>
					<th><span style="width:15px;"><?php echo 'Mã ĐH'; ?></span></th>
					<th style="width:85px"><?php echo lang('sales_date'); ?></th>
					<th style="width: 14%"><?php echo 'Nhân viên giao dịch'; ?></th>
					<th style="width: 14%"><?php echo 'Nhà cung cấp'; ?></th>
					<th style="width: 12%"><?php echo 'Nhập vào kho'; ?></th>
					<th style="width: 10%"><?php echo 'Tiền đã thanh toán'; ?></th>
					<th style="width: 14%"><?php echo lang('sales_comments'); ?></th>
					<th style="width: 9%"><?php echo 'Thanh toán nợ'; ?></th>
                    <th style="width: 8%"><?php echo 'Hóa đơn nhập hàng'; ?></th>
					<th style="width: 8%"><?php echo lang('common_delete'); ?></th>
				</tr>
				
				<?php
				foreach ($suspended_receivings as $suspended_receiving)
				{
				?>
				<tr style="font-size: 15px!important; height: 40px;">
						<td style="font-size:12px; text-align: center;"><?php echo $suspended_receiving['receiving_id'];?></td>
						<td style="font-size:12px;text-align: center; width:57px !important;"><?php echo ($suspended_receiving['receiving_time']);?></td>
						<td style="font-size:12px;text-align: center;">
							<?php
							if (isset($suspended_receiving['employee_id']))
							{
								$employee = $this->Employee->get_info($suspended_receiving['employee_id']);
								echo $employee->first_name. ' '. $employee->last_name;
							}
							else
							{
							?>
								&nbsp;
							<?php
							}
							?>
						</td>
						
						<td style="font-size:12px;text-align: center;">
							<?php
							if (isset($suspended_receiving['supplier_id']))
							{
								$supplier = $this->Supplier->get_info($suspended_receiving['supplier_id']);
								echo $supplier->company_name.' <br/> ('.$supplier->first_name. ' '. $supplier->last_name.')';
							}
							else
							{
							?>
								&nbsp;
							<?php
							}
							?>
						</td>
						<td style="font-size:12px;text-align: center;">
							<?php
							if (isset($suspended_receiving['inventory_id']))
							{
								$inventory = $this->Create_invetory->get_info($suspended_receiving['inventory_id']);
								echo $inventory->name_inventory;
							}
							else
							{
							?>
								&nbsp;
							<?php
							}
							?>
						</td>
						<td style="font-size:12px;text-align: center;"><?php echo $suspended_receiving['payment_type'];?></td>
						<td style="font-size:12px;margin-left:5px !important;padding-left: 8px !important;"><?php echo '  '.$suspended_receiving['comment'];?></td>
						<td style="font-size:12px;text-align: center;"><a href="<?php echo base_url();?>suppliers/detail_supplier/<?php echo $suspended_receiving['supplier_id'];?>" title="Thanh toán công nợ nhà cung cấp" style="margin-bottom: 7px;margin-top: 7px;">Thanh toán</a></td>
						<!--<td>
							<?php 
							echo form_open('sales/unsuspend');
							echo form_hidden('suspended_receiving_id', $suspended_receiving['receiving_id']);
							?>
							<input type="submit" name="submit" value="<?php echo lang('sales_unsuspend'); ?>" id="submit_unsuspend" class="submit_button float_right">
							</form>
						</td>
						-->
						
                       <td>
							<?php 
							echo form_open('receivings/receipt/'.$suspended_receiving['receiving_id'], array('method'=>'get', 'id' => 'form_receipt_suspended_sale'));
							?>
							<input type="submit" style="font-size: 11px;" name="submit" value="<?php echo lang('sales_recp'); ?>" id="submit_receipt" class="submit_button float_right">
							
							</form>
						</td>
                        
                        
						<!-- end phan lam-->
						<td>
							<?php 
							echo form_open('receivings/delete_suspended_receiving', array('id' => 'form_delete_suspended_sale'));
							echo form_hidden('suspended_receiving_id', $suspended_receiving['receiving_id']);
							?>
							
							<input type="submit" name="submit" value="<?php echo lang('common_delete'); ?>" id="submit_delete" class="submit_button float_right">
							</form>
						</td>
					</tr>
				<?php
				}
				?>
			</table>
		</td>
	</tr>
</table>

<script type="text/javascript">

$(document).ready(function()
{
	$("#form_delete_suspended_sale").submit(function()
	{
		if (!confirm(<?php echo json_encode(lang("sales_delete_confirmation")); ?>))
		{
			return false;
		}
	});
});
</script>