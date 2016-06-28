<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js" type="text/javascript"></script>
<div style="height:200px;">
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>


<?php
echo form_open('support/save/'.$support_info->id_support,array('id'=>'categories_form'));
?>
<fieldset id="item_basic_info">
<legend><?php echo 'Thông tin hỗ trợ trực tuyến'; ?></legend>

<div class="field_row clearfix">
<?php echo form_label('Tên hỗ trợ'.':', 'name',array('class'=>'required wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'name_support',
		'id'=>'name_support',
		'value'=>$support_info->name_support)
	);?>
    
   	</div>
</div>

<div class="field_row clearfix">
<?php echo form_label('Yahoo'.':', 'name',array('class'=>'required wide')); 	?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'yahoo',
		'id'=>'yahoo',
		'value'=>$support_info->yahoo)
	);?>
	</div>
</div>
<div class="field_row clearfix">
<?php echo form_label('Skype'.':', 'name',array('class'=>'required wide')); 	?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'skype',
		'id'=>'skype',
		'value'=>$support_info->skype)
	);?>
	</div>
</div>
<div class="field_row clearfix">
<?php echo form_label('Số điện thoại'.':', 'name',array('class'=>'required wide')); 	?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'phone',
		'id'=>'phone',
		'value'=>$support_info->phone)
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
</fieldset><?php
echo form_close();
?>
<script type='text/javascript'>

//validation and submit handling
$(document).ready(function()
{
    setTimeout(function(){$(":input:visible:first","#item_form").focus();},100);
    
    $('#start_year,#start_month,#start_day,#end_year,#end_month,#end_day').change(function()
    {
        $("#hdn_start_date").val($("#start_year").val()+'-'+$("#start_month").val()+'-'+$('#start_day').val());
        $("#hdn_end_date").val($("#end_year").val()+'-'+$("#end_month").val()+'-'+$('#end_day').val());
    });

	$( "#unit" ).autocomplete({
		source: "<?php echo site_url('units/suggest_unit');//	?>",
		delay: 10,
		autoFocus: false,
		minLength: 0
	});

	var submitting = false;

	$('#categories_form').validate({ /*sau khi them submit no se goi lai manage*/
		submitHandler:function(form)
		{
			if (submitting) return;
			submitting = true;
			$(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
			$(form).ajaxSubmit({
			success:function(response)
			{
				location.reload(); 
				// submitting = false;
				// tb_remove();
				// post_item_form_submit(response);
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",

	});
});
</script>

</div>
