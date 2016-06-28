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
        border: 1px solid #F5F5F5;
        height: 27px;
        min-width: 330px;
        width: auto ;
    }
    #jobs_person_name{
        height: 100px;
        float: left;
    }
</style>

<div class="field_row clearfix">
    <div class='form_field'>
        <?php echo form_label(lang('common_jobs_name').':', 'jobs_name',array('class'=>'required')); ?>
        <select name='jobs_name' id="jobs_name">
            <?php foreach($get_info_jobs AS $key => $values): ?>
                <?php if($values['jobs_id'] == $employees_jobs_info->jobs_id ){?>
                    <option value="<?php echo $values['jobs_id'];?>" selected='selected'><?php echo $values['jobs_name']; ?></option>
            <?php }else{ ?>
                    <option value="<?php echo $values['jobs_id'];?>"><?php echo $values['jobs_name']; ?></option>
            <?php }endforeach; ?>
        </select>
    </div>
</div>

<div class="field_row clearfix">
    <div class='form_field'>
        <?php echo form_label(lang('common_jobs_employees_name').':', 'jobs_person_name',array('class'=>'required')); ?>
        <select name='jobs_person_name[]' id="jobs_person_name" multiple="multiple" size="5">
            <?php foreach($get_info_employees AS $key => $values): ?>
                <?php if($values['person_id'] == $employees_jobs_info->person_id){ ?>
                    <option value="<?php echo $values['person_id'];?>" selected="selected"><?php echo $values['first_name'] ?></option>
            <?php }else{?>
                    <option value="<?php echo $values['person_id'];?>"><?php echo $values['first_name'] ?></option>
            <?php }endforeach; ?>
        </select>
    </div>
</div>


<!-- phan lam ngay sinh khach hang -->
<div class="field_row clearfix">
    <?php echo form_label(lang('common_jobs_end_date').':', 'employees_jobs_date'); ?>
    <div class='form_field'>
        <?php
        echo form_input(array(
                'name'=>'employees_jobs_date',
                'id'=>'employees_jobs_date',
                'require'=>'',
                'value'=>$employees_jobs_info->employees_jobs_date != '1950-01-01'? date(get_date_format(),strtotime($employees_jobs_date->employees_jobs_date != '' ? $employees_jobs_date->employees_jobs_date : date('Y-m-d'))) : ''
            )
        )
        ;?>
    </div>
</div>

<div class="field_row clearfix">
    <?php echo form_label(lang('common_jobs_content').':', 'jobs_content'); ?>
    <div class='form_field'>
        <?php echo form_textarea(array(
                'name'=>'employees_jobs_content',
                'id'=>'employees_jobs_content',
                'value'=>$employees_jobs_info->employees_jobs_content,
                'rows'=>'5',
                'cols'=>'57')
        );?>
    </div>
</div>

<div class="field_row clearfix" id="status_module" style="position: relative;bottom:10px" >
    <?php echo form_label(lang('common_jobs_file').':', 'jobs_reports_content'); ?>
    <div class='form_field' >
        <?php echo form_input(array(
            'name'=>'jobs_file_url',
            'id'=>'jobs_file_url',
            'style'=>'border:none;',
            'type'=>'file',
            'value'=>$jobs_info->jobs_url_file
        ));?>
    </div>
</div>


<script type='text/javascript'>
    $(document).ready(function()
    {
        $('#employees_jobs_date').datePicker({startDate: '01-01-1960'});
    });
</script>