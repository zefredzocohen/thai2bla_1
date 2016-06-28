<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
    <div id="content_area" style="height: auto;float: left;">

<div style="color:#000">
    <table id="title_bar_new" style="color: #FFF">
        <tr>
            <td id="title_icon">
                <img src='<?php echo base_url() ?>images/menubar/<?php echo 'reports'; ?>.png' alt='title icon' />
            </td>
            <td id="title" style="color:#FFF; font-size: 22px !important;">
                <?php echo $title; ?>
            </td>
            <td><a style="font-size:18px;text-decoration: underline; margin-right: 5px; color: white;" href="<?php echo base_url();?>reports">Trở lại</a></td>
        </tr>
    </table>
    <?php
    if (isset($error)) {
        echo "<div class='error_message'>" . $error . "</div>";
    }
    ?>
    <?php echo form_label(lang('reports_date_range'), 'report_date_range_label', array('class' => 'required', 'id' => 'label_new', 'style'=>'margin-left:8px;')); ?>
    <div id='report_date_range_simple' style="margin-left:8px;">
        <input type="radio" name="report_type" id="simple_radio" value='simple' checked='checked'/>
        <?php echo form_dropdown('report_date_range_simple', $report_date_range_simple, '', 'id="report_date_range_simple"'); ?>
    </div>
    <div id='report_date_range_complex' style="margin-left:8px;">
        <input type="radio" name="report_type" id="complex_radio" value='complex' />
        <select id="start_hour">
        	<option value="00">00</option>
        	<?php for($i=1;$i<24;$i++){?>
        		<option value="<?= $i ?>"><?= $i ?></option>
        	<?php }?>
        </select>:
        <select id="start_minute">
        	<option value="00">00</option>
        	<?php for($i=1;$i<60;$i++){?>
        		<option value="<?= $i ?>"><?= $i ?></option>
        	<?php }?>
        </select>
        <?php echo form_dropdown('start_day', $days, $selected_day, 'id="start_day"'); ?>
        <?php echo form_dropdown('start_month', $months, $selected_month, 'id="start_month"'); ?>
        <?php echo form_dropdown('start_year', $years, $selected_year, 'id="start_year"'); ?>
        -
        <select id="end_hour">
        	<option value="00">00</option>
        	<?php for($i=1;$i<24;$i++){?>
        		<option value="<?= $i ?>"><?= $i ?></option>
        	<?php }?>
        </select>:
        <select id="end_minute">
        	<option value="00">00</option>
        	<?php for($i=1;$i<60;$i++){?>
        		<option value="<?= $i ?>"><?= $i ?></option>
        	<?php }?>
        </select>
        <?php echo form_dropdown('end_day', $days, $selected_day, 'id="end_day"'); ?>
        <?php echo form_dropdown('end_month', $months, $selected_month, 'id="end_month"'); ?>
        <?php echo form_dropdown('end_year', $years, $selected_year, 'id="end_year"'); ?>
    </div>
    <?php echo form_label($specific_input_name, 'specific_input_name_label', array('class' => 'required', 'id' => 'label_new', 'style'=>'margin-left:8px;')); ?>
    <div id='report_ones' style="margin-left:8px;">
		<?php echo form_dropdown('specific_input_data', $specific_input_data, '', 'id="specific_input_data"'); ?>
    </div>
    
    <?php echo form_label(lang('reports_sale_type'), 'reports_sale_type_label', array('class' => 'required', 'id' => 'label_new', 'style'=>'margin-left:8px;')); ?>
    <div id='report_ones' style="margin-left:8px;">
        <?php echo form_dropdown('sale_type', array('all' => lang('reports_all'), 'sales' => lang('reports_sales'), 'returns' => lang('reports_returns')), 'all', 'id="sale_type"'); ?>
    </div>
    <?php echo form_label('Mặt hàng - sản phẩm - thành phẩm - dịch vụ', 'report_type', array('class' => 'required', 'id' => 'label_new', 'style'=>'margin-left:8px;')); ?>
    <div id='report_ones' style="margin-left:8px;">      
        <?php echo form_dropdown('report_type', array(
        	'all' => lang('reports_all'), 
        	'product' => 'Mặt hàng', 
        	'service' => 'Dịch vụ', 
        	'pack' => 'Gói sản phẩm', 
        	'produce' => 'Thành phẩm'
        ), 'all', 'id="report_type"'); ?>
    </div>

    <div id="report_ones" style="margin-left:8px;">
        <?php  echo lang('reports_export_to_excel'); ?>: 
		<input type="radio" name="export_excel" id="export_excel_yes" value='1' /> 
			<label for="export_excel_yes"><?php  echo lang('common_yes'); ?></label>
			&nbsp;
		<input type="radio" name="export_excel" id="export_excel_no" value='0' checked='checked' /> 
			<label for="export_excel_no"><?php  echo lang('common_no'); ?></label>
	</div>
    <?php
    echo form_button(array(
        'name' => 'generate_report',
        'id' => 'generate_report6',
        'content' => lang('common_submit'),
    	'style' => 'margin-left:8px',
        'class' => 'submit_button')
    );
    ?>
</div>
</div>
</div>
<?php $this->load->view("partial/footer"); ?>
<script type="text/javascript" language="javascript">
    $(document).ready(function(){      
        $("#generate_report6").click(function(){
            var sale_type = $("#sale_type").val();
            var export_excel = 0;
            if ($("#export_excel_yes").attr('checked')){
                export_excel = 1;
            }
            if ($("#simple_radio").attr('checked')){
                window.location = window.location + '/' + $("#report_date_range_simple option:selected").val() + '/' + $('#specific_input_data').val() + '/' + sale_type
                        + '/' + export_excel;
            }else{
                var start_date = $("#start_year").val() + '-' + $("#start_month").val() + '-' + $('#start_day').val() + ' ' + $('#start_hour').val() + ':' + $('#start_minute').val() + ':00';
                var end_date = $("#end_year").val() + '-' + $("#end_month").val() + '-' + $('#end_day').val() + ' ' + $('#end_hour').val() + ':' + $('#end_minute').val() + ':59';
                window.location = window.location + '/' + start_date + '/' + end_date + '/' + $('#specific_input_data').val() + '/' + sale_type + '/' + export_excel;
            }
        });
        $("#start_month, #start_day, #start_year, #end_month, #end_day, #end_year, #start_hour, #start_minute, #end_hour, #end_minute").click(function(){
            $("#complex_radio").attr('checked', 'checked');
        });
        $("#report_date_range_simple").click(function(){
            $("#simple_radio").attr('checked', 'checked');
        });
    });
</script>