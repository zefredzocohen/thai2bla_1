<div class="field_row clearfix" id="status_module">
    <?php echo form_label(lang('common_positions_name').':', 'common_positions_name',array('class'=>'required')); ?>
    <div class='form_field'>
        <?php echo form_input(array(
                'name'=>'jobs_positions_name',
                'id'=>'jobs_positions_name',
                'required'=>'',
                'value'=>$jobs_positions->jobs_positions_name)
        );?>
    </div>
</div>

<div class="field_row clearfix" id="status_module">
    <?php echo form_label(lang('common_positions_manager').':', 'jobs_positions_description'); ?>
    <div class='form_field'>
        <?php echo form_textarea(array(
                'name'=>'jobs_positions_description',
                'id'=>'jobs_positions_description',
                'value'=>$jobs_positions->jobs_positions_description,
                'rows'=>'5',
                'cols'=>'37')
        );?>
    </div>
</div>

<div class="field_row clearfix" id="status_module">
    <?php echo form_label(lang('common_jobs_report_date').':', 'jobs_status_date'); ?>
    <div class='form_field'>
        <?php
        echo form_input(array(
                'name'=>'jobs_positions_date',
                'id'=>'jobs_positions_date',
                'value'=>$jobs_positions->jobs_positions_date != '1950-01-01'? date(date('d-m-Y'),strtotime($jobs_positions->jobs_positions_date  != '' ? $jobs_positions->jobs_positions_date : date('d-m-Y'))) : ''
            )
        )
        ;?>
    </div>
</div>

<div class="field_row clearfix" style="border: none" id="status_module">
    <div class='form_field'>
        <?php echo form_label(lang('common_positions_manager_name').':', 'jobs_name',array('class'=>'')); ?>
        <select name='person_id' required="required">
            <?php foreach($person_info AS $key => $values): ?>
                <?php if($values->person_id == $jobs_positions->person_id ){?>
                    <option value="<?php echo $values->person_id;?>" selected="selected"><?php echo $values->first_name; ?></option>
                <?php } else{ ?>
                    <option value="<?php echo $values->person_id;?>"><?php echo $values->first_name; ?></option>
                <?php }endforeach; ?>
        </select>
    </div>
</div>

<div class="field_row clearfix" id="status_module">
    <?php echo form_label(lang('common_jobs_positions_color').':', 'jobs_name',array('class'=>'','style'=>'margin-left:3px;')); ?>
    <div class='form_field'>
        <?php
        echo form_input(array(
                'name'=>'jobs_positions_color',
                'id'=>'jobs_positions_color',
                'type'=>'color',
                'style'=>'width:20px',
                'value'=>$jobs_positions->jobs_positions_color
            )
        )
        ;?>
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



