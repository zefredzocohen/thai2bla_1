<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">
<a style="font-size:18px;text-decoration: underline; margin-left:800px" href="<?php echo base_url();?>reports">Trở lại</a>
<div id="page_title" style="margin-bottom:8px;color:#000; font-size: 24px !important;"><?php echo $tille; ?></div>
<?php
if(isset($error))
{
	echo "<div class='error_message'>".$error."</div>";
}
?>
<br>
	<?php echo form_label(lang('reports_date_range'), 'report_date_range_label', array('class'=>'required')); ?>
	<div id='report_date_range_simple' style="margin-top: 8px;">
		<input type="radio" name="report_type" id="simple_radio" value='simple' checked='checked'/>
		<?php echo form_dropdown('report_date_range_simple',$report_date_range_simple, '', 'id="report_date_range_simple"'); ?>
	</div>
	
     <div id='report_date_range_complex'>
     	<input type="radio" name="report_type" id="complex_radio" value='complex' />
     	<?php echo form_dropdown('start_hour',$hours, 0, 'id="start_hour"'); ?>
          :
          <?php echo form_dropdown('start_minute',$minutes, '0', 'id="start_minute"'); ?>
          
          <?php echo form_dropdown('start_month',$months, $selected_month, 'id="start_month"'); ?>
          <?php echo form_dropdown('start_day',$days, $selected_day, 'id="start_day"'); ?>
          <?php echo form_dropdown('start_year',$years, $selected_year, 'id="start_year"'); ?>
          
          -
           <?php echo form_dropdown('end_hour',$hours, 23, 'id="end_hour"'); ?>
          :
          <?php echo form_dropdown('end_minute',$minutes, '59', 'id="end_minute"'); ?>
          <?php echo form_dropdown('end_month',$months, $selected_month, 'id="end_month"'); ?>
          <?php echo form_dropdown('end_day',$days, $selected_day, 'id="end_day"'); ?>
          <?php echo form_dropdown('end_year',$years, $selected_year, 'id="end_year"'); ?>
         
       </div>
	
	<?php //echo form_label(lang('reports_sale_type'), 'reports_sale_type_label', array('class'=>'required')); ?>
	<div id='report_sale_type' style="display:none">
		<?php echo form_dropdown('sale_type',array('all' => lang('reports_all'), 'sales' => lang('reports_sales'), 'returns' => lang('reports_returns')), 'all', 'id="sale_type"'); ?>
	</div> 
	<div style="margin-top:10px">
		<?php  echo lang('reports_export_to_excel'); ?>: 
		<label><input type="radio" name="export_excel" id="export_excel_yes" value='1' /> <?php  echo lang('common_yes'); ?></label>
		<label><input type="radio" name="export_excel" id="export_excel_no" value='0' checked='checked' /> <?php  echo lang('common_no'); ?></label>
	</div>

</br>
<?php //echo form_dropdown('item_type',array('4'=>'Tất cả','0' => 'Mặt hàng', '1' => 'Dịch vụ', '2' => 'Gói sản phẩm', '3' => 'Thành phẩm'), 'all', 'id="item_type"'); ?>
<?php
echo form_button(array(
	'name'=>'generate_report',
	'id'=>'generate_report_sale',
	'content'=>lang('common_submit'),
	'style'=>'margin-top:15px;margin-right: 886px;',
	'class'=>'submit_button')
);
?>

</div></div></div>
<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript" language="javascript">
$(document).ready(function()
{
	$("#generate_report1").click(function()
	{
            
//		var sale_type = $("#sale_type").val();
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
			var start_date = $("#start_year").val()+'-'+$("#start_month").val()+'-'+$('#start_day').val()+' '+$('#start_hour').val()+':'+$('#start_minute').val()+':00';
			var end_date = $("#end_year").val()+'-'+$("#end_month").val()+'-'+$('#end_day').val()+' '+$('#end_hour').val()+':'+$('#end_minute').val()+':00';

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