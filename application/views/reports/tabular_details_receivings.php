<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">

<table id="title_bar"  style="height:70px">
	<tr>
		<td id="title_icon">
			<img src='<?php echo base_url()?>images/menubar/reports.png' alt='<?php echo lang('reports_reports'); ?> - <?php echo lang('reports_welcome_message'); ?>' />
		</td>
		<td id="title"><?php echo lang('reports_reports'); ?> - <?php echo $title ?></td>
		<td>
        	<a style="font-size:18px;text-decoration: underline;" href="<?php echo base_url();?>reports/detailed_receivings">Trở lại</a>
        </td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><small><?php echo $subtitle ?></small></td>
		<td></td>
	</tr>
</table>
<br />		
<div style="color:#000">		
<div style="margin:30px 0 10px 0;;"><h3>Lịch sử nhập hàng</h3></div>
<table id="contents">
	<tr>
		<td id="item_table">
			<div id="table_holder" style="width: 960px;">
				<table class="tablesorter report" id="sortable_table">
					<thead>
						<tr>
							<th><a href="#" class="expand_all" style="font: 17px solid">+</a></th>
							<?php foreach ($headers['summary'] as $header) { ?>
							<th style="font-size: 11px;" align="<?php echo $header['align']; ?>"><?php echo $header['data']; ?></th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($summary_data as $key=>$row) { ?>
						<tr>
							<td><a href="#" class="expand" style="font: 17px solid">+</a></td>
							<?php foreach ($row as $cell) { ?>
							<td style="font-size: 11px;" align="<?php echo $cell['align']; ?>"><?php echo $cell['data']; ?></td>
							<?php  } ?>
						</tr>
						<tr>
							<td colspan="12" class="innertable">
								<table class="innertable">
									<thead>
										<tr>
											<?php foreach ($headers['details'] as $header) { ?>
											<th style="font-size: 10px;" align="<?php echo $header['align']; ?>"><?php echo $header['data']; ?></th>
											<?php } ?>
										</tr>
									</thead>
								
									<tbody>
										<?php 
										 foreach ($details_data[$key] as $row2) { ?>
										
											<tr>
												<?php foreach ($row2 as $cell) { ?>
												<td style="font-size: 10px;" align="<?php echo $cell['align']; ?>"><?php echo $cell['data']; ?></td>
												<?php } ?>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			
			<div id="report_summary" class="tablesorter report" style="margin-right: 10px;">
			<?php foreach($overall_summary_data as $name=>$value) { ?>
				<div class="summary_row"><?php echo "<strong>".lang('reports_'.$name). '</strong>: '.to_currency($value); ?></div>
			<?php }?>
			</div>
		</td>
	</tr>
</table>

</div></div></div>

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
	
	$(".tablesorter a.expand_all").click(function(event)
	{
		$('td.innertable').toggle();
		
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