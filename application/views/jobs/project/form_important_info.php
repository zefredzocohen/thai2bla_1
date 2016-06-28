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
    #status_module input{
        width: 180px;
    }

    #status_module label{
        float: left;
        display: inline-block;
        width: 120px;
    }

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
        background-color: #F5F5F5;
    }
    #jobs_reports_result{
        width: 50px;
    }
    #jobs_reports_name{
        width: 313px;
    }
    .field_row #radio_result{
        position: relative;
        margin-left:  190px;
        list-style: none;
    }
    .field_row #radio_result li{
        float: left;
    }
    .field_row #radio_result li span{
        display: inline-block;
        font-weight: normal;
        font-size: 12px;
        float: left;
    }
    #jobs_reports_status{
        margin-left: -58px;
    }

</style>

<div class="field_row clearfix" id="status_module">
    <?php echo form_label(lang('common_jobs_important_name').':', 'jobs_status_name',array('class'=>'required')); ?>
    <div class='form_field'>
        <?php echo form_input(array(
                'name'=>'jobs_important_name',
                'id'=>'jobs_important_name',
                'required'=>'',
                'value'=>$jobs_important->jobs_important_name)
        );?>
    </div>
</div>


<div class="field_row clearfix" id="status_module">
    <?php echo form_label(lang('common_jobs_report_date').':', 'jobs_status_date'); ?>
    <div class='form_field'>
        <?php
        echo form_input(array(
                'name'=>'jobs_important_date',
                'id'=>'jobs_important_date',
                'value'=>$jobs_important->jobs_important_date != '1950-01-01'? date(get_date_format(),strtotime($jobs_important->jobs_important_date != '' ? $jobs_important->jobs_important_date : date('Y-m-d'))) : ''
            )
        )
        ;?>
    </div>
</div>

<div class="field_row clearfix" id="jobs_reports_change_status" style="display: block">
    <?php echo form_label(lang('jobs_project_status_show').':', 'jobs_project_status_show',array('class'=>'')); ?>
    <ul id="radio_result">
        <li><span> Hiện : </span><input type="radio" name="jobs_important_show" id="jobs_reports_status" value="1" style="margin-left: -63px" checked="checked"/></li>
        <li><span style="display: inline-block;margin-left: 30px;display: inline-block;float: left">Ẩn: </span><input type="radio" name="jobs_important_show" id="jobs_reports_status" value="0"  /></li>
    </ul>
</div>
<style>
    #radio_result{
        list-style: none;
    }

    #radio_result li{
        margin-left: -59px;
        margin-top: 5px;
    }
</style>


<script type='text/javascript'>

    //validation and submit handling
    $(document).ready(function()
    {
        $('#jobs_important_date').datePicker({startDate: '01-01-1960'});
    });
</script>

