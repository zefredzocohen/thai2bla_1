<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">
<div style="color:#000" id="report_news">
    <table id="title_bar_new" style="color: #FFF;">
        <tr>
            <td id="title_icon">
                <img src='<?php echo base_url()?>images/menubar/<?php echo 'reports'; ?>.png' alt='title icon' />
            </td>
            <td id="title">
                <?php echo lang('reports_report_input').' - '.$tille; ?>
                
            </td>
            <td><a style="font-size:18px;text-decoration: underline; margin-right: 5px; color: white;" href="<?php echo base_url();?>reports">Trở lại</a></td>
        </tr>
    </table>
    
<?php
//if(isset($error))
//{
//	echo "<div class='error_message'>".$error."</div>";
//}
?>
    <?php echo form_label('Chọn kho', 'choose_store', array('class' => 'required')); ?>
    <div>
        <select  style="margin-top: 5px;"name="store" id="store">
            <option value="2000">Tất cả</option>
            <option value="0">Kho tổng</option>
            <?php 
            foreach ($stores as $store){
                echo "<option value='".$store['id']."'>".$store['name_inventory']."</option>";
            }
            ?>
        </select>
    </div>
	
    <div style="margin-top:10px;margin-left:10px">
            <?php  echo lang('reports_export_to_excel'); ?>: 
            <input type="radio" name="export_excel" id="export_excel_yes" value='1' /> 
                    <label for="export_excel_yes"><?php  echo lang('common_yes'); ?></label>
                    &nbsp;
            <input type="radio" name="export_excel" id="export_excel_no" value='0' checked='checked' /> 
                    <label for="export_excel_no"><?php  echo lang('common_no'); ?></label>
    </div>


	<fieldset id="supplier_basic_info" style="border: none">
    <?php
	    echo form_button(array(
	            'name'=>'generate_report',
	            'id'=>'generate_report_inventory',
	            'content'=>lang('common_submit'),
				'style'=>'margin-left:5px',
	            'class'=>'submit_button')
	    );
    ?>
	</fieldset>
</div></div></div>
<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript" language="javascript">
$(document).ready(function()
{
	$("#generate_report").click(function()
	{
		var sale_type = $("#sale_type").val();
		var export_excel = 0;
		if ($("#export_excel_yes").attr('checked'))
		{
			export_excel = 1;
		}
		
		if ($("#simple_radio").attr('checked'))
		{
			window.location = window.location+'/'+$("#report_date_range_simple option:selected").val() + '/'+sale_type+'/'+export_excel;
		}
		else
		{
			var start_date = $("#start_year").val()+'-'+$("#start_month").val()+'-'+$('#start_day').val()+' '+$('#start_hour').val()+':'+$('#start_minute').val()+':00';
			var end_date = $("#end_year").val()+'-'+$("#end_month").val()+'-'+$('#end_day').val()+' '+$('#end_hour').val()+':'+$('#end_minute').val()+':00';

			window.location = window.location+'/'+start_date + '/'+ end_date + '/'+sale_type+'/'+ export_excel;
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