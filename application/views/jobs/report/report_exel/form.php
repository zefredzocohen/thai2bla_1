<?php
echo form_open('jobs_report/getReport/',array('id'=>''));
?>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<div id="error"></div>
<fieldset id="" style="width: 100%;height: 500px">
    <legend><?php echo lang("department_information_info"); ?></legend>
    <?php $this->load->view("jobs/report/report_exel/form_info");
    echo form_submit(array(
            'name'=>'submit',
            'id'=>'submit',
            'style'=>'margin-left: 278px',
            'value'=>lang('common_submit'),
            'class'=>'submit_button float_right')
    );

    ?>
</fieldset>
<?php
echo form_close();
?>
<script type='text/javascript'>

        $(document).ready(function()
        {
            $('#start_date').datePicker({startDate: '01-01-1960'});
            $('#end_date').datePicker({startDate: '01-01-1960'});
        });
</script>
<script type="text/javascript" src="<?php echo base_url()?>js/jsForm.js"></script>
<style>
    #error h4.alert_warning {
        display: block;
        width: 100%;
        background-position: 10px 10px;
        border: 1px solid #F5F5F5;
        color: #796616;
        text-indent: 10px;
        font-size: 13px;
        position: relative;
        height: 25px;
        line-height: 25px;
        left: 0px;
        top: -1px;
    }
</style>


