
<div class="field_row clearfix" style="border: none" id="status_module">
    <div class='form_field'>
        <?php echo form_label(lang('common_jobs_name').':', 'jobs_name',array('class'=>'required')); ?>
        <select name='employees_jobs_id' id="jobs_name" required="required">
            <?php if(count($jobs_info) > 0){?>
                <?php foreach($jobs_info AS $key => $values): ?>
                    <?php if($values['jobs_employees_id'] == $jobs_report->jobs_employees_id ){?>
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

<div class="field_row clearfix" id="status_module">
    <?php echo form_label(lang('common_jobs_date_report_name').':', 'jobs_reports_name',array('class'=>'required')); ?>
    <div class='form_field'>
        <?php echo form_input(array(
                'name'=>'jobs_reports_name',
                'id'=>'jobs_reports_name',
                'require'=>'',
                'value'=>$jobs_report->jobs_reports_name)
        );?>
    </div>
</div>

<div class="field_row clearfix" id="status_module">
    <?php echo form_label(lang('common_jobs_jobs_jobs_employees_place').':', 'jobs_affiliates_description'); ?>
    <div class='form_field'>
        <?php echo form_textarea(array(
                'name'=>'employees_jobs_content',
                'id'=>'employees_jobs_content',
                'value'=>$jobs_employees->jobs_employees_place,
                'rows'=>'5',
                'cols'=>'37')
        );?>
    </div>
</div>


<div class="field_row clearfix" id="status_module">
    <?php echo form_label(lang('common_jobs_employee_date').':', 'employees_jobs_date'); ?>
    <div class='form_field'>
        <?php
        echo form_input(array(
                'name'=>'employees_jobs_date',
                'id'=>'jobs_employees_date',
                'value'=>$jobs_employees->jobs_employees_date != '1950-01-01'? date(get_date_format(),strtotime($jobs_employees->jobs_employees_date  != '' ? $jobs_employees->jobs_employees_date : date('Y-m-d'))) : ''
            )
        )
        ;?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#jobs_employees_date').datePicker({startDate: '01-01-1960'});
    });
</script>


<div class="field_row clearfix" id="status_module" style="position: relative;bottom:-15px" >
    <?php echo form_label(lang('common_jobs_file').':', 'jobs_reports_content'); ?>
    <div class='form_field' >
        <?php echo form_input(array(
            'name'=>'jobs_file_url',
            'id'=>'jobs_file_url',
            'style'=>'border:none;height:24px',
            'type'=>'file',
            'value'=>$jobs_info->jobs_url_file
        ));?>
    </div>
</div>

<a href="<?php echo site_url('jobs_employee/loadRegions/'.$jobs_employees->jobs_employees_id)?>" style="display: none" id="hrefview"></a>
<a href="<?php echo site_url('jobs_employee/loadCity/'.$jobs_employees->jobs_employees_id)?>" style="display: none" id="showCity"></a>
<a href="<?php echo site_url('jobs_employee/loadAffiliates/'.$jobs_employees->jobs_employees_id)?>" style="display: none" id="showAffiliates"></a>
<a href="<?php echo site_url('jobs_employee/loadDepartment/'.$jobs_employees->jobs_employees_id)?>" style="display: none" id="showDepartment"></a>

<script type="text/javascript">
    /*
     * Th?c  hi?n load toàn b? thông tin khi ta th?c hiên ch?n select Khu v?c
     * */
    function clickSendRegions()
    {
        var url = $("#hrefview").attr('href');
        var jobs_regions_id = $("#jobs_regions_id").val();

        $.post(url,{jobs_regions_id:jobs_regions_id},function(data,success){
            if(success){
                $(".action_show").html(data);
            }
        });
    }
    /*
     * Th?c hi?n load thông tin khi ch?n thành ph?
     */
    function clickSendCity()
    {
        var jobs_city_id = $("#jobs_city_id").val();
        var url = $("#showCity").attr('href');
        $.post(url,{jobs_city_id:jobs_city_id},function(data,success){
            if(success){
                $("#city_show").html(data);
            }
        });
    }
    /*
     * Th?c hi?n load thông tin khi ch?n thành ph?
     */
    function clickSendAffiliates()
    {
        var jobs_affiliates_id = $("#jobs_affiliates_id").val();
        var url = $("#showAffiliates").attr('href');
        $.post(url,{jobs_affiliates_id:jobs_affiliates_id},function(data,success){
            if(success){
                $("#affiliates_show").html(data);
            }
        });
    }
    /*
     * Th?c hi?n load thông tin khi ch?n thành ph?
     */
    function clickSendDepartment()
    {
        var department_id = $("#department_id").val();
        var url = $("#showDepartment").attr('href');
        $.post(url,{department_id:department_id},function(data,success){
            if(success){
                $("#showEmployees").html(data);
            }
        });
    }
    /*
    *  Function th?c hiên l?y ten department trong khu v?c
    * */
    function getDepartment()
    {
        var department_id = $("#department_id").val();

        alert(department_id);
    }
</script>
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



