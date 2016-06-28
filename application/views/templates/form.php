<?php
echo form_open_multipart('templates/save/'.$var_info->id,array('id'=>'assets_form'));
?>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<fieldset id="supplier_basic_info">
<legend><?php echo lang("var_information"); ?></legend>
<div class="field_row clearfix">
<?php echo form_label('Up file mẫu báo cáo:', 'file_up', array('class'=>'')); ?>
<div class='form_field'>
<input type="file" name="file_up" size="20" />
</div></div>
<div class="field_row clearfix">	
<?php echo form_label('Tên mẫu báo cáo:', 'name', array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'name',
		'id'=>'name',
		'value'=>$var_info->name)
	);?>
	</div>
</div>


<div class="field_row clearfix">	
<?php echo form_label('Ô tên khách hàng:', 'name_cus', array('class'=>'')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'name_cus',
		'id'=>'name_cus',
		'value'=>$var_info->name_cus)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label('Ô địa chỉ khách hàng:', 'add_cus', array('class'=>'')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'add_cus',
		'id'=>'add_cus',
		'value'=>$var_info->add_cus)
	);?>
	</div>
</div>

<div class="field_row clearfix">
<?php echo form_label('Chọn loại mẫu:', 'category',array('class'=>'')); ?>
<div class='form_field'>
<select name="category">
	<option value="1">Mẫu hợp đồng</option>
	<option value="2">Mẫu báo giá</option>
</select>
</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label('Ô điện thoại khách hàng:', 'phone_cus', array('class'=>'')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'phone_cus',
		'id'=>'phone_cus',
		'value'=>$var_info->phone_cus)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label('Ô ms thuế khách hàng:', 'code_tax', array('class'=>'')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'code_tax',
		'id'=>'code_tax',
		'value'=>$var_info->code_tax)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label('Ô tên cty khách hàng:', 'company_cus', array('class'=>'')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'company_cus',
		'id'=>'company_cus',
		'value'=>$var_info->company_cus)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label('Ô bắt đầu liệt kê sp:', 'row', array('class'=>'')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'row',
		'id'=>'row',
		'value'=>$var_info->row)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label('Chọn làm mẫu chính:', 'primary', array('class'=>'')); ?>
	<div class='form_field'>
	<?php echo form_checkbox(array(
		'name'=>'primary',
		'id'=>'primary',
		'value'=>1,
		'checked'=>($var_info->primary==1)? 1 : 0
		)
	);?>
	</div>
</div>

<?php
echo form_submit(array(
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
	$('#date_tang').datePicker({startDate: '01-01-1950'});
	$('#date_kh').datePicker({startDate: '01-01-1950'});
    setTimeout(function(){$(":input:visible:first","#customer_type_form").focus();},100);
	var submitting = false;
	
	$('#assets_form').validate({
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
			name: "required",
   		},
		messages: 
		{
     		name: "Bạn cần nhập tên mẫu báo cáo",
		}
	});
});
</script>