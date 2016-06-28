<?php
echo form_open('contractcustomer_type/save/'.$contractcustomer_type->id,array('id'=>'contractcustomer_type_form'));
?>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<fieldset id="supplier_basic_info" style="width: 104%;height:380px;">
<legend><?php echo lang("customer_type_information"); ?></legend>
<div class="field_row clearfix">	
<?php echo form_label(lang('contractcustomer_type_code').':', ' contractcustomer_type_name', array('class'=>'required','style'=>'width:143px')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'contractcustomer_type_code',
		'id'=>'contractcustomer_type_code',
		'value'=>$contractcustomer_type->code)
	);?>
	</div>
</div>

<div class="field_row clearfix">
<?php echo form_label(lang('contractcustomer_type_name').':', ' contractcustomer_type_name', array('class'=>'required','style'=>'width:143px')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'contractcustomer_type_name',
		'id'=>'contractcustomer_type_name',
		'value'=>$contractcustomer_type->name)
	);?>
	</div>
</div>
<div class="field_row clearfix">	
<?php echo form_label(lang('contractcustomer_type_desc').':', 'contractcustomer_type_desc', array('class'=>'','style'=>'width: 143px')); ?>
	<div class='form_field'>
	<?php echo form_textarea(array(
            'name'=>'contractcustomer_type_desc',
            'id'=>'contractcustomer_type_desc',
            'rows'=>'5',
            'cols'=>'17',
            'value'=>$contractcustomer_type->description)
	);?>
	</div>
</div>
<?php
echo form_submit(array(
	'name'=>'submit',
	'id'=>'submit',
    'style'=>'margin-right:16px;',
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
    setTimeout(function(){$(":input:visible:first","#contractcustomer_type_form").focus();},100);
	var submitting = false;

	$('#contractcustomer_type_form').validate({
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
			customer_type_name: "required"
   		},
		messages:
		{
     		customer_type_name: "Bạn cần nhập tên loại khách hàng"
		}
	});
});
</script>