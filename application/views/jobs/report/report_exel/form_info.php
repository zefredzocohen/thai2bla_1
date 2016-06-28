
<div class="field_row clearfix" id="status_module">
    <?php echo form_label(lang('common_start_date').':', 'jobs_status_date'); ?>
    <div class='form_field'>
        <?php
        echo form_input(array(
                'name'=>'start_date',
                'id'=>'start_date',
                'placeholder'=>'--- Chọn ngày bắt đầu ---',
                'required'=>'required'
            )
        )
        ;?>
    </div>
</div>

<div class="field_row clearfix" id="status_module">
    <?php echo form_label(lang('common_end_date').':', 'jobs_status_date'); ?>
    <div class='form_field'>
        <?php
        echo form_input(array(
                'name'=>'end_date',
                'id'=>'end_date',
                 'placeholder'=>'--- Chọn ngày kết thúc --- ',
                'required'=>'required'
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



