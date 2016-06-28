<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<?php
echo form_open('bpsd/save/'.$bpsd_info->id_bpsd,array('id'=>'bpsd_form'));
?>
<fieldset id="dichvu_basic_info">
<legend><?php echo 'Thông tin bộ phận sử dụng' ?></legend>

<div class="field_row clearfix">
<?php echo form_label(lang('name_bpsd_label').':', 'bpsd_name',array('class'=>'required wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'bpsd_name',
		'size'=>'30',
		'id'=>'bpsd_name',
		'value'=>$bpsd_info->name_bpsd)
	);?>
	</div>
</div>


<div class="field_row clearfix">
<?php echo form_label(lang('desc_bpsd_label').':', 'bpsd_desc',array('class'=>'')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'bpsd_desc',
		'size'=>'30',
		'id'=>'bpsd_desc',
		'value'=>$bpsd_info->desc_bpsd)
	);?>
	</div>
</div>


<?php
echo form_submit(array(
	'name'=>'submit',
	'id'=>'submit',
	'value'=>lang('common_submit'),
	'class'=>'submit_button float_right')
);
?>
</fieldset>
<?php
echo form_close();
?>
<script type='text/javascript'>
//validation and submit handling
$(document).ready(function()
{
    setTimeout(function(){$(":input:visible:first","#bpsd_form").focus();},100);
	var submitting = false;
	
	$('#bpsd_form').validate({
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
				post_type_cus_form_submit(response);
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules: 
		{
			bpsd_name: "required",
   		},
		messages: 
		{
     		bpsd_name: "Bạn cần nhập tên nhóm tài sản , thiết bị",
		}
	});
});
</script>