<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area" style="color:#000;line-height: 35px;height: 200px">
<h3 style="margin-left: 50px;padding-bottom: 10px;">Chọn ngày xuất</h3>
<?php echo form_open("costs/do_excel_export",array('id'=>'excel_export')); ?>
			<div>
			<input required="required" placeholder="chọn ngày" type="text" class="date-pick" id="start-date"  name="start_date" />
			<input required="required" placeholder="đến ngày" type="text" class="date-pick" id="end-date"  name="end_date" />
			</div>
			<br />
			<div style="margin-top:10px;margin-left: 48px;">
				<?php  echo lang('reports_export_to_excel'); ?>: 
				<input type="radio" name="export_excel" id="export_excel_yes" value='1' /> 
					<label for="export_excel_yes"><?php  echo lang('common_yes'); ?></label>
					&nbsp;
				<input type="radio" name="export_excel" id="export_excel_no" value='0' checked='checked' /> 
					<label for="export_excel_no"><?php  echo lang('common_no'); ?></label>
			</div>
			<input type="hidden" name="tkdu" value="0" />
			<?php
				echo form_button(array(
					'type' => 'submit',
					'name'=>'generate_report',
					'id'=>'generate_report',
					'style'=>'margin-right: 845px',
					'content'=>lang('common_submit'),
					'class'=>'submit_button')
				);
			?>
<?php echo form_close(); ?>
</div></div>
<?php $this->load->view("partial/footer"); ?>
<script>
$(document).ready(function()
{		
	$('#start-date').datePicker({startDate: '01-01-1950'}).bind(
		'dpClosed',
		function(e, selectedDates)
		{
			var d = selectedDates[0];
			if (d) {
				d = new Date(d);
				$('#end-date').dpSetStartDate(d.addDays(1).asString());
			}
		}
	);
	$('#end-date').datePicker().bind(
		'dpClosed',
		function(e, selectedDates)
		{
			var d = selectedDates[0];
			if (d) {
				d = new Date(d);
				$('#start-date').dpSetEndDate(d.addDays(-1).asString());
			}
		}
	);
	
});
</script>
<style type="text/css">
input#start-date,input#end-date{
height:26px;
width:123px;
margin-left:50px;
}

</style>