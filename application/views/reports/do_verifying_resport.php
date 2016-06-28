<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">
<style type="text/css">
#content_area > #myclass {
    font-size: 13px;
    font-style: italic;
}
</style>
<div id="myclass">
<h4><?php echo $company ?></h4>
<h4><?php echo $address ?></h4>
</div>
<a style="font-size:18px;text-decoration: underline; float: right;margin-right:30px;margin-bottom: 41px; margin-top: -34px" href="<?php echo base_url();?>reports/do_verifying_resport">Trở lại</a>
<h3 style="margin: 20px 200px 5px 250px;text-align: center;">BÁO CÁO KIỂM KHO - Kho <?php echo $this->Create_invetory->get_info($store)->name_inventory;?></h3>
<h3 style="margin: 5px 200px 10px 250px;text-align: center; font-style: italic;font-size: 13px;"><?php echo 'Từ '.date('d-m-Y H:i:s', strtotime($start_date)) .' đến '.date('d-m-Y H:i:s', strtotime($end_date)); ?></h3>

<table id="contents">
	<tr>
		<td id="item_table">
			<div id="table_holder" style="width: 960px;">
				<table class="tablesorter report" id="sortable_table">
					<thead>
						<tr>
							<th>Số STT</th>
							<th>Mã SP</th>
							<th>Tên sản phẩm</th>
							<th>Loại sản phẩm</th>
							<th>Giá nhập</th>
							<th>SL nhập</th>
							<th>SL kho</th>
							<th>SL bán</th>
							<th>SL kiểm</th>
							<th> SL chêch lệch</th>
						</tr>
					</thead>
					<tbody>
						<?php $stt=1; ?>
						<?php foreach ($verifying as $key):
						
							$kho=$key['quantity_inventory'];
							$kt=$key['quantity_verifying'];
							$chech=$key['quantity_inventory']-$key['quantity_verifying']
						 ?>
							<tr>
							<td><?php echo $stt; ?></td>
							<td><?php echo  $key['item_number']?></td>
							<td><?php echo $key['name'] ?></td>
							<td><?php echo $this->Category->get_info($key['category'])->name ?></td>
							<td><?php echo number_format($key['cost_price']) ?></td>
                                                        <td><?php echo number_format($key['quantity_input']) ?></td>
							<td><?php echo number_format($key['quantity_inventory']) ?></td>
							<td><?php echo number_format($key['quantity_sale']) ?></td>
							<td><?php echo number_format($key['quantity_verifying']) ?></td>
							<td><?php echo $chech; ?></td>
							</tr>
							<?php $stt++ ?>
						<?php endforeach ?>

					</tbody>
				</table>
			</div>
		</td>
	</tr>

</table>
</div></div>
<?php $this->load->view("partial/footer"); ?>
<script type="text/javascript" language="javascript">
$(document).ready(function()
{
	$(".tablesorter a.expand").click(function(event)
	{
		$(event.target).parent().parent().next().find('td.innertable').toggle();
		
		if ($(event.target).text() == '+')
		{
			$(event.target).text('-');
		}
		else
		{
			$(event.target).text('+');
		}
		return false;
	});
	
});
</script>