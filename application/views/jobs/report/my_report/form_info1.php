<style>
    fieldset div.field_row{
        border-bottom: none;
    }

    .field_row input{
        border: none;
        width: 150px;
        height: 15px;
    }
    .field_row select{
        height: 27px;
        padding: 0;
    }
    .field_row label{
        font-family: "Helvetica";
        font-size: 13px;
        display: inline-block;
    }
    label{
        float: left;
        display: inline-block;
        width: 150px;
    }
    #jobs_name{
        float: left;
        border: 1px solid #CCC;
        height: 27px;
        width: 325px;
    }
    #jobs_reports_name{
        width: 313px;
    }
</style>
<div class="field_row clearfix">
    <?php echo form_label(lang('common_jobs_date_report_name').':', 'jobs_reports_name',array('class'=>'required')); ?>
    <div class='form_field'>
        <?php echo form_input(array(
                'name'=>'jobs_reports_name',
                'id'=>'jobs_reports_name',
                'require'=>'',
                'value'=>$get_jobs_report->jobs_reports_name)
        );?>
    </div>
</div>

<div class="field_row clearfix">
    <div class='form_field'>
        <?php echo form_label(lang('common_jobs_name').':', 'jobs_name',array('class'=>'required')); ?>
        <select name='employees_jobs_id' id="jobs_name" required="required">
            <?php if(count($get_info_jobs) > 0){?>
                <?php foreach($get_info_jobs AS $key => $values): ?>
                    <?php if($values['jobs_employees_id'] == $get_jobs_report->jobs_employees_id ){?>
                        <option value="<?php echo $values['employees_jobs_id'];?>" selected="selected"><?php echo $values['jobs_name']; ?></option>
                    <?php } else{ ?>
                        <option value="<?php echo $values['employees_jobs_id'];?>"><?php echo $values['jobs_name']; ?></option>
                    <?php }endforeach; ?>
            <?php }else{ ?>
                <option value="">Bạn không có công việc nào đề báo cáo</option>
            <?php } ?>
        </select>
    </div>
</div>


<div class="field_row clearfix">
    <?php echo form_label(lang('common_jobs_date_report').':', 'first_name',array('class'=>'required')); ?>
    <div class='form_field'>
        <?php echo form_input(array(
                'name'=>'jobs_reports_result',
                'id'=>'jobs_reports_result',
                'value'=>$get_jobs_report->jobs_reports_result)
        );?>

    </div>
</div>


<div class="field_row clearfix">
    <?php echo form_label(lang('common_jobs_report_date').':', 'jobs_reports_date'); ?>
    <div class='form_field'>
        <?php
        echo form_input(array(
                'name'=>'jobs_reports_date',
                'id'=>'jobs_reports_date',
                'value'=>$get_jobs_report->jobs_reports_date != '1950-01-01'? date(get_date_format(),strtotime($get_jobs_report->jobs_reports_date != '' ? $get_jobs_report->jobs_reports_date : date('Y-m-d'))) : ''
            )
        )
        ;?>
    </div>
</div>

<div class="field_row clearfix">
    <?php echo form_label(lang('common_jobs_content').':', 'jobs_reports_content'); ?>
    <div class='form_field'>
        <?php echo form_textarea(array(
                'name'=>'jobs_reports_content',
                'id'=>'jobs_reports_content',
                'value'=>$get_jobs_report->jobs_reports_content,
                'rows'=>'5',
                'cols'=>'37')
        );?>
    </div>
</div>

<script type='text/javascript'>

    $(document).ready(function()
    {
        $('#jobs_reports_date').datePicker({startDate: '01-01-1960'});
    });
</script>