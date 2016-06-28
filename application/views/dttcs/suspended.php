<SCRIPT LANGUAGE="JavaScript">
function checkall(class_name, obj) {
	var items = document.getElementsByClassName(class_name);
	if(obj.checked == true) 
	{
		for(i=0; i < items.length ; i++)
			items[i].checked = true;
	}
	else { 
		for(i=0; i < items.length ; i++)
			items[i].checked = false;
	}
}
</script>
<table id="contents" style="width: 800px;">
	<tr>
		<td id="item_table">
<?php 
	echo form_open('dttcs/do_chonhopdong/'.$id_dttc);
?>
			<table  id="suspended_sales_table">
				<tr>
					<th><?php echo lang('sales_suspended_sale_id'); ?></th>
					<th><?php echo lang('sales_date'); ?></th>
					<th><?php echo lang('sales_customer'); ?></th>
					<th>
						<input type="checkbox" onclick="checkall('checkbox', this)" name="check"/>
					</th>
				</tr>
				
				<?php
				$d = 0;
				foreach ($suspended_sales as $suspended_sale)
				{ $d++;
				?>
					<tr>
						<td ><?php echo $suspended_sale['sale_id'];?></td>
						<td><?php echo date(get_date_format(),strtotime($suspended_sale['sale_time']));?></td>
						<td>
							<?php
							if (isset($suspended_sale['customer_id']))
							{
								$customer = $this->Customer->get_info($suspended_sale['customer_id']);
								echo $customer->first_name. ' '. $customer->last_name;
							}
							else
							{
							?>
								&nbsp;
							<?php
							}
							?>
						</td>
						<td>
							<input name="checkbox_<?php echo $d; ?>" type="checkbox" class="checkbox" value="<?php echo $suspended_sale['sale_id'];?>">
						</td>
					</tr>
				<?php
				}
				?>
			</table>
	<input type="hidden" value="<?php echo $d; ?>" name="count" />
	<input style="margin-left:400px;margin-top:20px; width:81px; height:41px;" type="submit"  value="chọn" />
</form>
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