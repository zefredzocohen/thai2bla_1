<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">
<div style="color:#000">
    <table id="title_bar_new" style="color: #FFF">
        <tr>
            <td id="title_icon">
                <img src='<?php echo base_url()?>images/menubar/<?php echo 'report'; ?>.png' alt='title icon' />
            </td>
            <td id="title">
               Báo cáo công nợ khách hàng
            </td>
        </tr>
    </table>
<fieldset id="supplier_basic_info" class="report_snguyen_one" style="border: none">
<?php echo form_open("reports/report_congnokh",array('id'=>'excel_export','target'=>"_blank")); ?>
    <div class="field_row clearfix label_one_report">
        <?php echo form_label(lang('common_report_start_date').':', ' tkdu_id', array('class'=>'required','id'=>'label_one_report')); ?>
        <div class='form_field'>
            <input required="required" placeholder="Từ ngày" type="text" class="date-pick" id="start-date"  name="start_date" />
        </div>
    </div>
    <div class="field_row clearfix label_one_report">
        <?php echo form_label(lang('common_report_end_date').':', ' tkdu_id', array('class'=>'required','id'=>'label_one_report')); ?>
        <div class='form_field'>
            <input required="required" placeholder="Đến ngày" type="text" class="date-pick" id="end-date"  name="end_date" />
        </div>
    </div>
    <div id="report_ones" style="margin-left: 12px">
        <?php  echo lang('reports_export_to_excel'); ?>: 
		<input type="radio" name="export_excel" id="export_excel_yes" value='1' /> 
			<label for="export_excel_yes"><?php  echo lang('common_yes'); ?></label>
			&nbsp;
		<input type="radio" name="export_excel" id="export_excel_no" value='0' checked='checked' /> 
			<label for="export_excel_no"><?php  echo lang('common_no'); ?></label>
	</div>
    <?php
    echo form_button(array(
            'type' => 'submit',
            'name'=>'generate_report',
            'id'=>'generate_report',
            'style'=>'margin-right: 570px',
            'content'=>lang('common_submit'),
            'class'=>'submit_button')
    );
    ?>
</fieldset>
<?php echo form_close(); ?>
</div></div></div>
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

#generate_report 
{
	margin-left: 48px;
	margin-top: 10px;
}
</style>