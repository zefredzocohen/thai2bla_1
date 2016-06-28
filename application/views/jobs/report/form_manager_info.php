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
<div class="field_row clearfix">
    <?php echo form_label(lang('common_jobs_date_report_name').':', 'jobs_reports_name',array('class'=>'required')); ?>
    <div class='form_field'>
        <?php echo form_input(array(
                'name'=>'jobs_reports_name',
                'id'=>'jobs_reports_name',
                'disabled'=>'disabled',
                'require'=>'',
                'value'=>$get_jobs_report->jobs_reports_name)
        );?>
    </div>
</div>
<div class="field_row clearfix">
    <div class='form_field'>
        <?php echo form_label(lang('common_jobs_name').':', 'jobs_name',array('class'=>'required')); ?>
        <select name='employees_jobs_id' id="jobs_name" >
            <?php if(count($get_info_jobs) > 0){?>
                <?php foreach($get_info_jobs AS $key => $values): ?>
                    <?php if($values['jobs_employees_id'] == $get_jobs_report->jobs_employees_id ){?>
                        <option value="<?php echo $values['employees_jobs_id'];?>" disabled="disabled" selected="selected"><?php echo $values['jobs_name']; ?></option>
                    <?php } else{ ?>
                        <option value="<?php echo $values['employees_jobs_id'];?>" disabled="disabled"><?php echo $values['jobs_name']; ?></option>
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
                'disabled'=>'disabled',
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
                'disabled'=>'disabled',
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
                'disabled'=>'disabled',
                'value'=>$get_jobs_report->jobs_reports_content,
                'rows'=>'5',
                'cols'=>'37')
        );?>
    </div>
</div>

<div class="field_row clearfix">
    <?php echo form_label(lang('common_jobs_reports_comment').':', 'jobs_reports_comment'); ?>
    <div class='form_field'>
        <?php echo form_textarea(array(
                'name'=>'jobs_reports_comment',
                'id'=>'jobs_reports_comment',
                'value'=>$get_jobs_report->jobs_reports_comment == 0 ? '' : $get_jobs_report->jobs_reports_comment ,
                'rows'=>'5',
                'cols'=>'37')
        );?>
    </div>
</div>

<div class="field_row clearfix">
   <ul id="radio_result">
       <?php if($get_jobs_report->jobs_reports_status == 1){ ?>
             <li><span>Duyệt : </span><input type="radio" name="jobs_reports_status" id="jobs_reports_status" value="1" checked="checked" onclick=" hideClick()"/></li>
             <li><span>Không duyệt : </span><input type="radio" name="jobs_reports_status" id="jobs_reports_status" value="0" onclick="onClick()"</li>
       <?php } else {?>
            <li><span>Duyệt : </span><input type="radio" name="jobs_reports_status" id="jobs_reports_status" value="1" onclick=" hideClick()"/></li>
            <li><span>Không duyệt : </span><input type="radio" name="jobs_reports_status" id="jobs_reports_status" value="0" onclick="onClick()" checked="checked"/></li>
       <?php }?>
   </ul>
</div>
<script type="text/javascript">

    function onClick()
    {
        $('#jobs_reports_result_manager').show('500');
        $('#jobs_reports_change_status').hide('500');


    }
    function hideClick()
    {
        $('#jobs_reports_result_manager').show('500');
        $('#jobs_reports_change_status').show('500');
    }
    function hideImportant()
    {
        $('#jobs_important').slideUp('500');
    }
    function showImportant()
    {
        $('#jobs_important').slideDown('500');
    }
</script>
<div class="field_row clearfix" id="jobs_reports_result_manager" style="display: none">
    <?php echo form_label(lang('jobs_reports_result_manager').':', 'first_name',array('class'=>'required')); ?>
    <div class='form_field'>
        <?php echo form_input(array(
                'name'=>'jobs_reports_result_manager',
                'id'=>'jobs_reports_result_manager',
                'class'=>'number',
                'value'=>$get_jobs_report->jobs_reports_result_manager)
        );?>

    </div>
</div>

<div class="field_row clearfix" id="jobs_reports_change_status" style="display: block">
    <?php echo form_label(lang('jobs_reports_jobs_manager').':', 'first_name',array('class'=>'required')); ?>
    <ul id="radio_result">
        <li><span> Hoàn thành : </span><input type="radio" name="jobs_status" id="jobs_reports_status" value="3" onclick="hideImportant()"/></li>
        <li><span style="display: inline-block;margin-left: -34px">Hủy bỏ: </span><input type="radio" name="jobs_status" id="jobs_reports_status" value="4" onclick="hideImportant()"/></li>
        <li style="position: absolute;right: -30px;"><span style="display: inline-block;float: left">Chưa hoàn thành: </span><input type="radio" name="jobs_status" id="jobs_reports_status" value="2" onclick="showImportant()" /></li>
    </ul>
</div>

<div class="field_row clearfix" id="jobs_important" style="display: none">
    <?php echo form_label(lang('jobs_reports_jobs_name_manager').':', 'first_name',array('class'=>'required')); ?>
     <select name='jobs_important' >
         <option value="2">Quan trọng</option>
         <option value="3">Ưu tiên hàng đầu</option>
     </select>
</div>
<?php echo form_hidden('jobs_id',$get_jobs_report->jobs_id); ?>