<style type="text/css">
	.open-front-end{
	background:#428BCA;
    border: 0 none;
    color: #FFFFFF !important;
    display: block;
    font-size: 12px;
    height: 24px;
    margin: 0 auto;
    text-align: center;
	line-height:24px;
    width: 70px;
	}
	.open-front-end a{
		color:#fff !important;
		text-decoration:none;	
	}
</style>
<table id="contents" style="width: 590px;">
	<tr>
		<td id="item_table" >
         
			<table  id="suspended_sales_table">
				<tr>
					<th><?php echo lang('sales_suspended_sale_id'); ?></th>
					<th><?php echo lang('sales_date'); ?></th>
					<th><?php echo lang('sales_customer'); ?></th>
					<th><?php echo lang('sales_total'); ?></th>
					<th><?php echo lang('sales_unsuspend'); ?></th>
					<th><?php echo lang('sales_receipt'); ?></th>
					<th><?php echo lang('common_delete'); ?></th>
				</tr>
				
				<?php
				foreach ($payment_date as $payment_dates)
				{
				?>
					<tr>
						<td><?php echo $payment_dates['order_id'];?></td>
						<td><?php echo date(get_date_format(),strtotime($payment_dates['order_date']));?></td>
						<td>
							<?php
							if (isset($payment_dates['customer_id']))
							{
								$customer = $this->Customer->omc_get_info($payment_dates['customer_id']);
								echo $customer->customer_first_name. ' '. $customer->customer_last_name;
							}
							else
							{
							?>
								&nbsp;
							<?php
							}
							?>
						</td>
						<td><?php echo $payment_dates['total'].' VNĐ';?></td>
						<td>
							<?php 
							echo form_open('sales/unsuspend_web');
							echo form_hidden('suspended_order_id', $payment_dates['order_id']);
							?>
                            <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/LIFETEK/POS2014/front-end/orders/control'?>" class="open-front-end" target="_blank">Mở lại</a>
							<?php /*?><input type="submit" name="submit" value="<?php echo lang('sales_unsuspend'); ?>" id="submit_unsuspend" class="submit_button float_right"><?php */?>
							</form>
						</td>
						<td>
							<?php 
							echo form_open('sales/receipt_web/'.$payment_dates['order_id'], array('method'=>'get', 'id' => 'form_receipt_suspended_sale'));
							?>
							<input type="submit" name="submit" value="<?php echo lang('sales_recp'); ?>" id="submit_receipt" class="submit_button float_right">
							</form>
						</td>
                        
						<td>
							<?php 
							echo form_open('sales/delete_suspended_order', array('id' => 'form_delete_suspended_sale'));
							echo form_hidden('suspended_order_id', $payment_dates['order_id']);
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