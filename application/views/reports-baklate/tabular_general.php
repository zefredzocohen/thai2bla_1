<?php
if($export_excel == 1)
{
	$excelXml = new Excel_XML();
	$excelXml->setWorksheetTitle($title);
	$rows = array();
	
	$row = array();
        if($name_store<>""){
            $row[] = strip_tags("Kho: ".$name_store);
        }
        $rows[] = $row;
        
        $row = array();
	foreach ($headers['general'] as $header)
	{
		$row[] = strip_tags($header['data']);
	}
	$rows[] = $row;
	
	foreach ($summary_data as $key=>$datarow) 
	{
		$row = array();
		foreach($datarow as $cell)
		{
			$row[] = strip_tags($cell['data']);
		}
		$rows[] = $row;

//		$row = array();
//		foreach ($headers['details'] as $header)
//		{
//			$row[] = strip_tags($header['data']);
//		}
//		$rows[] = $row;
		
//		foreach($details_data[$key] as $datarow2)
//		{
//			$row = array();
//			foreach($datarow2 as $cell)
//			{
//				$row[] = strip_tags($cell['data']);
//			}
//			$rows[] = $row;
//		}
	}
	
	$excelXml->addArray($rows);
	$excelXml->generateXML($title);
	exit;
}
?>
<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">
<div>
<img src='<?php echo base_url()?>images/menubar/reports.png' alt='<?php echo lang('reports_reports'); ?> - <?php echo lang('reports_welcome_message'); ?>' />
<span id="title_bar"><?php echo lang('reports_reports'); ?> - <?php echo $title ?></span> - <?php echo $subtitle ?>
</div>
<?php echo $input_html;?>
<br />

<table id="contents">
	<tr>
		<td id="item_table">
			<div id="table_holder" style="width: 960px;">
				<table class="tablesorter report" id="sortable_table">
					<thead>
						<tr>
							<?php foreach ($headers['general'] as $header) { ?>
							<th align="<?php echo $header['align']; ?>"><?php echo $header['data']; ?></th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($summary_data as $key=>$row) { ?>
						<tr>
							<?php foreach ($row as $cell) { ?>
							<td align="<?php echo $cell['align']; ?>"><?php echo $cell['data']; ?></td>
							<?php } ?>
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