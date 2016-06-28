<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<?php
echo form_open('timekeeping/save/'.$item_info->id,array('id'=>'timekeepings_form'));
?>
<fieldset id="item_basic_info" style="height: 440px">
<legend><?php echo lang("items_salaryconfig_information"); ?></legend>

<div class="field_row clearfix">	
<?php echo form_label(lang('timekeeping_date').':', 'day_keeping'); ?>
	<div class='form_field'>
	<?php
        echo form_input(array(
		'name'=>'day_keeping',
		'id'=>'day_keeping',
		'value'=>$person_info->day_keeping != '1950-01-01'?date(get_date_format(),strtotime($person_info->day_keeping != ''?$person_info->day_keeping: date('d-m-Y'))):''
		)
	)
        ;?>
	</div>
</div>
    <div class="field_row clearfix" style="border: none" >
        <div class='form_field'>
            <?php echo form_label(lang('common_city_regions_name').':', 'jobs_name',array('class'=>'')); ?>
            <select name='jobs_regions_id' id='jobs_regions_id'  required="required" onchange="clickSendRegions()">
                <option value="">--- Chọn khu vực ---</option>
                <?php foreach($regions_info AS $key => $values): ?>
                    <?php if($values->jobs_regions_id == $all_info->jobs_regions_id ){?>
                        <option value="<?php echo $values->jobs_regions_id;?>" selected="selected"><?php echo $values->jobs_regions_name; ?></option>
                    <?php } else{ ?>
                        <option value="<?php echo $values->jobs_regions_id;?>"><?php echo $values->jobs_regions_name; ?></option>
                    <?php }endforeach; ?>
            </select>
        </div>
    </div>

    <div class="action_show">
        <div class="field_row clearfix_city" style="border: none" >
            <div class='form_field'>
                <?php echo form_label(lang('common_affiliates_city_name').':', 'jobs_name',array('class'=>'')); ?>
                <select name='jobs_city_id' id='jobs_city_id' required="required" onchange="clickSendCity();">
                    <option value="">--- Chọn thành phố ---</option>
                    <?php foreach($city_info AS $key => $values): ?>
                        <?php if($values->jobs_city_id == $all_info->jobs_city_id ){?>
                            <option value="<?php echo $values->jobs_city_id;?>" selected="selected"><?php echo $values->jobs_city_name; ?></option>
                        <?php } else{ ?>
                            <option value="<?php echo $values->jobs_city_id;?>"><?php echo $values->jobs_city_name; ?></option>
                        <?php }endforeach; ?>
                </select>
            </div>
        </div>
        <div id="city_show">
            <div class="field_row clearfix_affiliates" style="border: none;" >
                <div class='form_field'>
                    <?php echo form_label(lang('common_affiliates_name').':', 'jobs_name',array('class'=>'')); ?>
                    <select name='jobs_affiliates_id' id='jobs_affiliates_id'  required="" onchange="clickSendAffiliates()">
                        <option value="">--- Chọn chi nhánh ---</option>
                        <?php foreach($affiliates_info AS $key => $values): ?>
                            <?php if($values->jobs_affiliates_id == $all_info->jobs_affiliates_id ){?>
                                <option value="<?php echo $values->jobs_affiliates_id;?>" selected="selected"><?php echo $values->jobs_affiliates_name; ?></option>
                            <?php } else{ ?>
                                <option value="<?php echo $values->jobs_affiliates_id;?>"><?php echo $values->jobs_affiliates_name; ?></option>
                            <?php }endforeach; ?>
                    </select>
                </div>
            </div>
            <div id="affiliates_show">
                <div class="field_row clearfix_city" style="border: none" >
                    <div class='form_field'>
                        <?php echo form_label(lang('common_department_name').':', 'jobs_name',array('class'=>'')); ?>
                        <select name='department_id' id='department_id' required="required" onchange="clickSendDepartment()">
                            <option value="">--- Chọn phòng ban ---</option>
                            <?php foreach($department_info AS $key => $values): ?>
                                <?php if($values->department_id == $all_info->department_id ){?>
                                    <option value="<?php echo $values->department_id;?>" selected="selected"><?php echo $values->department_name; ?></option>
                                <?php } else{ ?>
                                    <option value="<?php echo $values->department_id;?>"><?php echo $values->department_name; ?></option>
                                <?php }endforeach; ?>
                        </select>
                    </div>
                </div>
                <div id="showEmployees">
                    <div class="field_row clearfix">
                        <div class='form_field'>
                            <?php echo form_label(lang('common_jobs_employees_name').':', 'jobs_person_name',array('class'=>'required')); ?>
                            <select name='person_id' id="jobs_person_name" >
                                <option value="" style="display: none"> -- Chọn tên nhân viên -- </option>
                                <?php foreach($employees_info AS $key => $values): ?>
                                    <?php if($values->person_id == $all_info->person_id){ ?>
                                        <option value="<?php echo $values->person_id; ?>" selected="selected"><?php echo $values->first_name ?></option>
                                    <?php }else{?>
                                        <option value="<?php echo $values->person_id;?>"><?php echo $values->first_name ?></option>
                                    <?php }endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div><!--end #showEmployees-->

            </div><!--end #affiliates_show-->
        </div><!--end #city_show-->

    </div><!--end #action_show-->

    <a href="<?php echo site_url('timekeeping/loadRegions/'.$timekeepings->timekeepings_id)?>" style="display: none" id="hrefview"></a>
    <a href="<?php echo site_url('timekeeping/loadCity/'.$timekeepings->timekeepings_id)?>" style="display: none" id="showCity"></a>
    <a href="<?php echo site_url('timekeeping/loadAffiliates/'.$timekeepings->timekeepings_id)?>" style="display: none" id="showAffiliates"></a>
    <a href="<?php echo site_url('timekeeping/loadDepartment/'.$timekeepings->timekeepings_id)?>" style="display: none" id="showDepartment"></a>

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
    <div class="field_row clearfix">
        <div class='form_field'>
            <?php echo form_label('Loại chấm công'.':', 'jobs_person_name',array('class'=>'required')); ?>
            <select name='salaryconfig' id="salaryconfig_id" >
                <option value="" style="display: none"> -- Chọn loại chấm công -- </option>
                <?php foreach($salaryconfig_info AS $key => $values): ?>
                    <?php if($values['id'] == $item_info->salaryconfig_id){ ?>
                        <option value="<?php echo $values['id'];?>" selected="selected" title="<?php echo $values['description'] ?>"><?php echo $values['name'] ?></option>
                    <?php }else{?>
                        <option value="<?php echo $values['id'];?>" title="<?php echo $values['description'] ?>"><?php echo $values['name'] ?></option>
                    <?php }endforeach; ?>
            </select>
        </div>
    </div>
<?php

echo form_submit(array(
	'name'=>'submit',
	'id'=>'submit',
     'style'=>'margin-right: 24px;margin-top: 20px!important',
	'value'=>lang('common_submit'),
	'class'=>'submit_button float_right')
);
?>
</fieldset><?php
echo form_close();
?>

<style type="text/css">
	.tb-timekeeping{
		border-collapse:collapse;
		width:100%;
		height:auto;
		float:left;	
		border:1px #000;
	}
	.tb-timekeepingtr{
	 background-image: url("<?php echo base_url();?>images/pieces/table_body.png");
		background-position: -15px -80px;
		border-right: 1px solid #BBBBBB;
		color: #FFFFFF;
		font-size: 13px;
		font-weight:bold;
		height: 30px;

		text-align: left;	
	}
	.tb-timekeeping label{
		padding-left:10px;
	}
	.tb-timekeeping-contaner td
	{
		background-color: #F9F9F9;
		border-bottom: 1px solid #CCCCCC;
		border-right: 1px solid #CCCCCC;
		color: #444444;
		font-size: 13px;
		height: 30px;
		padding: 0 10px;
		vertical-align: middle;	
	}
	.title-timekeeping{
		padding:0 10px;
		border-right:1px solid #ccc;
		float:left;
		line-height:28px;	
	}
</style>

<script>
//validation and submit handling
$(document).ready(function()
{
    $('#day_keeping').datePicker({startDate: '01-01-1950'});
    setTimeout(function(){$(":input:visible:first","#item_form").focus();},100);
    
    $('#start_year,#start_month,#start_day,#end_year,#end_month,#end_day').change(function()
    {
        $("#hdn_start_date").val($("#start_year").val()+'-'+$("#start_month").val()+'-'+$('#start_day').val());
        $("#hdn_end_date").val($("#end_year").val()+'-'+$("#end_month").val()+'-'+$('#end_day').val());
    });

	$( "#category" ).autocomplete({
		source: "<?php echo site_url('timekeeping/suggest');?>",
		delay: 10,
		autoFocus: false,
		minLength: 0
	});

	var submitting = false;

	$('#timekeepings_form').validate({ /*sau khi them submit no se goi lai manage*/
		submitHandler:function(form)
		{
			if (submitting) return;
			submitting = true;
			$(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
			$(form).ajaxSubmit({
			success:function(response)
			{
				submitting = false;
				tb_remove();
				post_item_form_submit(response);
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules:
		{
		

   		},
		messages:
		{
		
		}
	});
});
</script>


