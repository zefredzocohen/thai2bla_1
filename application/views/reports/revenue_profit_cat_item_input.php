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
                        <?php echo "Báo cáo doanh thu lợi nhuận theo nhóm mặt hàng"?>

                    </td>
                    <td><a style="font-size:18px;text-decoration: underline; margin-right: 5px; color: white;" href="<?php echo base_url(); ?>reports">Trở lại</a></td>
                </tr>
            </table>

            <?php
            if (isset($error)) {
                echo "<div class='error_message'>" . $error . "</div>";
            }
            ?>            
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
            <div style="margin: 10px 0px 0px 10px">
                <?php echo form_label('Chọn nhóm mặt hàng', 'choose_cat', array('class' => 'required')); ?>
                <br>
                <select  style="margin-top: 5px;"name="category" id="category">
                    <option value="0">Tất cả</option>
                    <?php 
                    foreach ($cats as $cat){
                        echo "<option value='".$cat['id_cat']."'>".$cat['name']."</option>";
                    }  
                    ?>
                </select>
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
                    'id' => 'generate_report_revenue_cat',
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
