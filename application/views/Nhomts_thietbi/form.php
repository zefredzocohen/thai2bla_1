<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<?php
echo form_open('Nhomts_thietbi/save/'.$nhom_info->id_tstb,array('id'=>'tstb_form'));
?>
<fieldset id="dichvu_basic_info">
<legend><?php echo 'Thông tin nhóm tài sản và thiết bị' ?></legend>

<div class="field_row clearfix">
<?php echo form_label(lang('name_tstb_label').':', 'tstb_name',array('class'=>'required wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'tstb_name',
		'size'=>'30',
		'id'=>'tstb_name',
		'value'=>$nhom_info->tstb_name)
	);?>
	</div>
</div>


<div class="field_row clearfix">
<?php echo form_label(lang('desc_tstb_label').':', 'tstb_desc',array('class'=>'')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'tstb_desc',
		'size'=>'30',
		'id'=>'tstb_desc',
		'value'=>$nhom_info->tstb_desc)
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
    setTimeout(function(){$(":input:visible:first","#tstb_form").focus();},100);
	var submitting = false;
	
	$('#tstb_form').validate({
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
				tstb_form_submit(response);
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules: 
		{
			tstb_name: "required",
   		},
		messages: 
		{
     		tstb_name: "Bạn cần nhập tên nhóm tài sản , thiết bị",
		}
	});
});
</script>