<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">
<div style="color:#000">
    <table id="title_bar_new" style="color: #FFF">
        <tr>
            <td id="title_icon">
                <img src='<?php echo base_url()?>images/menubar/<?php echo 'reports'; ?>.png' alt='title icon' />
            </td>
            <td id="title">
                <?php echo lang('reports_report_input'); ?>
            </td>
        </tr>
    </table>
<?php
if(isset($error))
{
	echo "<div class='error_message'>".$error."</div>";
}
?>
	<?php echo form_label(lang('reports_date_range'), 'report_date_range_label', array('class'=>'required','id'=>'label_new')); ?>
	<div id='report_date_range_simple'>
		<input type="radio" name="report_type" id="simple_radio" value='simple' checked='checked'/>
		<?php echo form_dropdown('report_date_range_simple',$report_date_range_simple, '', 'id="report_date_range_simple"'); ?>
	</div>
	
	<div id='report_date_range_complex'>
		<input type="radio" name="report_type" id="complex_radio" value='complex' />
		<?php echo form_dropdown('start_day',$days, $selected_day, 'id="start_day"'); ?>
		<?php echo form_dropdown('start_month',$months, $selected_month, 'id="start_month"'); ?>
		<?php echo form_dropdown('start_year',$years, $selected_year, 'id="start_year"'); ?>
		-
		<?php echo form_dropdown('end_day',$days, $selected_day, 'id="end_day"'); ?>
		<?php echo form_dropdown('end_month',$months, $selected_month, 'id="end_month"'); ?>
		<?php echo form_dropdown('end_year',$years, $selected_year, 'id="end_year"'); ?>
	</div>
	
	<div id="report_ones">
		<?php  echo lang('reports_export_to_excel'); ?>: 
		<input type="radio" name="export_excel" id="export_excel_yes" value='1' /> 
			<label for="export_excel_yes"><?php  echo lang('common_yes'); ?></label>
			&nbsp;
		<input type="radio" name="export_excel" id="export_excel_no" value='0' checked='checked' /> 
			<label for="export_excel_no"><?php  echo lang('common_no'); ?></label>
	</div>

<?php
echo form_button(array(
	'name'=>'generate_report',
	'id'=>'generate_report3',
	'content'=>lang('common_submit'),
	'class'=>'submit_button')
);
?>
</div></div></div>
<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript" language="javascript">
$(document).ready(function()
{
	$("#generate_report3").click(function()
	{
		var export_excel = 0;
		if ($("#export_excel_yes").attr('checked'))
		{
			export_excel = 1;
		}
		
		if ($("#simple_radio").attr('checked'))
		{
			window.location = window.location+'/'+$("#report_date_range_simple option:selected").val() +'/'+export_excel;
		}
		else
		{
			var start_date = $("#start_year").val()+'-'+$("#start_month").val()+'-'+$('#start_day').val();
			var end_date = $("#end_year").val()+'-'+$("#end_month").val()+'-'+$('#end_day').val();
	
			window.location = window.location+'/'+start_date + '/'+ end_date +'/'+ export_excel;
		}
	});
	
	$("#start_month, #start_day, #start_year, #end_month, #end_day, #end_year").change(function()
	{
		$("#complex_radio").attr('checked', 'checked');
	});
	
	$("#report_date_range_simple").change(function()
	{
		$("#simple_radio").attr('checked', 'checked');
	});
	
});
</script>