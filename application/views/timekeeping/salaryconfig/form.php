<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<?php
echo form_open('salaryconfig/save/'.$item_info->id,array('id'=>'salaryconfig_form'));
?>
<fieldset id="item_basic_info" style="height: 350px;">
<legend><?php echo lang("items_salaryconfig_information"); ?></legend>

<div class="field_row clearfix">
<?php echo form_label(lang('items_salaryconfig_name').':', 'name',array('class'=>'required wide','style'=>'width: 110px')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'name',
		'id'=>'name',
		'value'=>$item_info->name)
	);?>
   	</div>
</div>

<div class="field_row clearfix">
<?php echo form_label(lang('items_salaryconfig_description').':', 'description',array('class'=>'required wide','style'=>'width:110px')); ?>
	<div class='form_field'>
	<?php echo form_textarea(array(
		'name'=>'description',
        'style'=>'height:100px!important',
		'id'=>'description',
		'value'=>$item_info->description)
	);?>
	</div>
</div>

<!--<div class="field_row clearfix">
<?php /*echo form_label(lang('items_salaryconfig_value').':', 'value',array('class'=>' wide')); */?>
	<div class='form_field'>
	<?php /*echo form_input(array(
		'name'=>'value',
		'id'=>'value',
		'value'=>$item_info->value)
	);*/?>
	</div>
</div>
-->

<?php
echo form_submit(array(
	'name'=>'submit',
	'id'=>'submit',
    'style'=>'margin-right: 33px',
	'value'=>lang('common_submit'),
	'class'=>'submit_button float_right')
);
?>
</fieldset><?php
echo form_close();
?>
<script type='text/javascript'>

    //validation and submit handling
    $(document).ready(function()
    {
        setTimeout(function(){$(":input:visible:first","#salaryconfig_form").focus();},100);


        $('#start_year,#start_month,#start_day,#end_year,#end_month,#end_day').change(function()
        {
            $("#hdn_start_date").val($("#start_year").val()+'-'+$("#start_month").val()+'-'+$('#start_day').val());
            $("#hdn_end_date").val($("#end_year").val()+'-'+$("#end_month").val()+'-'+$('#end_day').val());
        });

        $( "#category" ).autocomplete({
            source: "<?php echo site_url('items/suggest_category');?>",
            delay: 10,
            autoFocus: false,
            minLength: 0
        });

        var submitting = false;

        $('#salaryconfig_form').validate({
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
                
                name:"required",
                description:"required",
               
            },
            messages:
            {
                
                name:{
                     required: 'Vui lòng nhập tên thuộc tính lương',
                },
                  description:{
                     required: 'Vui lòng nhập mô tả thuộc tính lương',
                },
              
            }
        });
    });
</script>