<div class="field_row clearfix" id="status_module">
    <?php echo form_label(lang('common_file_tile').':', 'jobs_file_name',array('class'=>'required')); ?>
    <div class='form_field'>
        <?php echo form_input(array(
                'name'=>'jobs_file_title',
                'id'=>'jobs_file_title',
                'required'=>'',
                'value'=>$jobs_file->jobs_file_title)
        );?>
    </div>
</div>

<div class="field_row clearfix" id="status_module">
    <?php echo form_label(lang('common_file_description').':', 'jobs_file_description'); ?>
    <div class='form_field'>
        <?php echo form_textarea(array(
                'name'=>'jobs_file_description',
                'id'=>'jobs_file_description',
                'value'=>$jobs_file->jobs_file_description,
                'rows'=>'5',
                'cols'=>'37')
        );?>
    </div>
</div>

<div class="field_row clearfix" id="status_module">
    <?php echo form_label(lang('common_file_date').':', 'jobs_status_date'); ?>
    <div class='form_field'>
        <?php
        echo form_input(array(
                'name'=>'jobs_file_date',
                'id'=>'jobs_file_date',
                'value'=>$jobs_file->jobs_file_date != '1950-01-01'? date(get_date_format(),strtotime($jobs_file->jobs_file_date  != '' ? $jobs_file->jobs_file_date : date('d-m-Y'))) : ''
            )
        )
        ;?>
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
    #status_module input,textarea{
        width: 220px;
    }
    #status_module select{
        width: 232px;
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

    #radio_result{
        list-style: none;
    }

    #radio_result li{
        margin-left: -59px;
        margin-top: 5px;
    }

</style>



