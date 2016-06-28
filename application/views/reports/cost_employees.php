<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
    <div id="content_area">
        <div style="color:#000" id="report_news">
            <table id="title_bar_new" style="color: #FFF;">
                <tr>
                    <td id="title_icon">
                        <img src='<?php echo base_url() ?>images/menubar/<?php echo 'reports'; ?>.png' alt='title icon' />
                    </td>
                    <td id="title">
                        <?php echo lang('reports_cost_reports') . ' - ' . $tille; ?>

                    </td>
                    <td><a style="font-size:18px;text-decoration: underline; margin-right: 5px; color: white;" href="<?php echo base_url(); ?>reports">Trở lại</a></td>
                </tr>
            </table>

            <?php
            if (isset($error)) {
                echo "<div class='error_message'>" . $error . "</div>";
            }
            ?>
            <?php echo form_label(lang('reports_cost_reports'), 'report_date_range_label', array('class' => 'required', 'style' => 'margin-left:10px;')); ?>
            <div id='report_date_range_simple' style="margin-top:10px; margin-left: 10px">
                <input type="radio" name="report_type" id="simple_radio" value='simple' checked='checked'/>
                <?php echo form_dropdown('report_date_range_simple', $report_date_range_simple, '', 'id="report_date_range_simple"'); ?>
            </div>

            <div id='report_date_range_complex' style="margin-left:10px">
                <input type="radio" name="report_type" id="complex_radio" value='complex' />
                <?php echo form_dropdown('start_hour', $hours, 0, 'id="start_hour"'); ?>
                :
                <?php echo form_dropdown('start_minute', $minutes, '0', 'id="start_minute"'); ?>

                <?php echo form_dropdown('start_day', $days, $selected_day, 'id="start_day"'); ?>          
                <?php echo form_dropdown('start_month', $months, $selected_month, 'id="start_month"'); ?>
                <?php echo form_dropdown('start_year', $years, $selected_year, 'id="start_year"'); ?>

                -
                <?php echo form_dropdown('end_hour', $hours, 23, 'id="end_hour"'); ?>
                :
                <?php echo form_dropdown('end_minute', $minutes, '59', 'id="end_minute"'); ?>
                <?php echo form_dropdown('end_day', $days, $selected_day, 'id="end_day"'); ?>
                <?php echo form_dropdown('end_month', $months, $selected_month, 'id="end_month"'); ?>
                <?php echo form_dropdown('end_year', $years, $selected_year, 'id="end_year"'); ?>

            </div>
            <div id="employee_label">
            <?php 
            if($this->session->userdata('person_id')==1){
                echo form_label($specific_input_name, 'specific_input_name_label', array('class' => 'required', 'id' => 'label_new', 'style' => 'margin-left:8px;')); ?>
	            <div id='report_ones' style="margin-left:8px;">
	                <?php 	echo form_input(array(
		            'name' => 'specific_input',
		            'id' => 'specific_input',
		            'size' => '30', 
		            'placeholder' => ' Nhập tên nhân viên ... ' 
			   	)); 
				?>
				<table id="row_selected"></table>
			    </div><br>
            </div>
            <?php }else{
            ?>
            <input type="hidden" name="specific_input_data" id="specific_input_data" value="<?php echo $this->session->userdata('person_id')?>"/>
            <?php }?>
            
            <div style="color: red; margin-top: 10px; margin-left: 10px;">
                <?php echo form_label('Loại tiền', 'reports_cost_type_label', array('class' => 'required')); ?><br>
            </div>
            <div id='report_cost_type' style="color: red; margin-top: 10px; margin-left: 10px;">
                <?php echo form_dropdown('cost_type', array('all' => 'Tất cả', 'thu' => 'Tiền thu', 'chi' => 'Tiền chi'), 'all', 'id="cost_type"'); ?>
            </div>
            <div style="margin-top:10px;margin-left:10px">
                <?php echo lang('reports_export_to_excel'); ?>: 
                <input type="radio" name="export_excel" id="export_excel_yes" value='1' /> 
                <label for="export_excel_yes"><?php echo lang('common_yes'); ?></label>
                &nbsp;
                <input type="radio" name="export_excel" id="export_excel_no" value='0' checked='checked' /> 
                <label for="export_excel_no"><?php echo lang('common_no'); ?></label>
            </div>
            <fieldset id="supplier_basic_info" style="border: none">
                <?php
                echo form_button(array(
                    'name' => 'generate_report',
                    'id' => 'generate_report13',
                    'content' => lang('common_submit'),
                    'style' => 'margin-left:5px',
                    'class' => 'submit_button')
                );
                ?>
            </fieldset>
        </div></div></div>
<style type="text/css">
.disable_input_cost {
	display: none;
}
</style>        
<?php $this->load->view("partial/footer"); ?>
<script type="text/javascript" language="javascript">
    	//hung audi 5-6-15 
    	var notice = 'Bạn chưa chọn nhân viên hoặc nhân viên không hợp lệ ! Vui lòng chọn lại';    	
        $("#specific_input").autocomplete({
	        	source: '<?php echo site_url("employees/info_name_employee_suggest"); ?>',
                delay: 10,
                autoFocus: false,
                minLength: 0,
                select: function (event, ui){
                    $("#specific_input").val("");
                    if ($("#row_selected" + ui.item.value).length == 1){
                        $("#row_selected" + ui.item.value).val(parseFloat($("#row_selected" + ui.item.value).val()) + 1);
                    }else{
                        $("#specific_input").addClass("disable_input_cost");
                        $("#row_selected").append("<tr><td width='200px'>" + ui.item.label + "</td><td><a href='#' style='text-decoration: underline' onclick='return deleteRow(this);'>Xóa</a></td><td><input type='hidden' size='3' id='specific_input_data' name='specific_input_data' value='" + ui.item.value + "'/></td></tr>");
                    }
                    return false;
                }
        });
    	function deleteRow(link){
    	    $("#specific_input").removeClass("disable_input_cost");
    	    $(link).parent().parent().remove();
    	    return false;
    	}
    	//end hung
    $(document).ready(function(){        
        $("#generate_report13").click(function(){
			var tam= ($("#employee_label").find("#specific_input_data"));
        	if(tam){
        		var employee_id = $("#specific_input_data").val();
        	}else var employee_id = 0;
        	var cost_type = $("#cost_type").val();
        	var export_excel = 0;
        	if ($("#export_excel_yes").attr('checked')){
				export_excel = 1;
        	}
        	if ($("#simple_radio").attr('checked')){
				window.location = window.location + '/' + $("#report_date_range_simple option:selected").val()+ '/'+employee_id + '/' + cost_type + '/' + export_excel;
        	}else{
        	    var start_date = $("#start_year").val() + '-' + $("#start_month").val() + '-' + $('#start_day').val() + ' ' + $('#start_hour').val() + ':' + $('#start_minute').val() + ':00';
        	    var end_date = $("#end_year").val() + '-' + $("#end_month").val() + '-' + $('#end_day').val() + ' ' + $('#end_hour').val() + ':' + $('#end_minute').val() + ':00';
				window.location = window.location + '/' + start_date + '/' + end_date+ '/'+employee_id + '/' + cost_type + '/' + export_excel;
        	}
        });
		$("#start_month, #start_day, #start_year, #end_month, #end_day, #end_year").change(function(){
        	$("#complex_radio").attr('checked', 'checked');
		});

		$("#report_date_range_simple").change(function(){
			$("#simple_radio").attr('checked', 'checked');
		});
    });
</script>