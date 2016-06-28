<?= form_open('assets/save_allocate/'.$var_info->id,array('id'=>'assets_form')) ?>
<div id="required_fields_message"><?= lang('common_fields_required_message') ?></div>
<ul id="error_message_box"></ul>
<fieldset id="supplier_basic_info">
<legend><?= lang("var_information") ?></legend>
<div class="field_row clearfix">	
<?= form_label('Ngừng phân bổ:', ' allocate') ?>
	<div class='form_field'>
	<?= form_checkbox(array(
		'name'=>'allocate',
		'id'=>'allocate',
		'value' => 1,
        'checked' => $var_info->allocate ? 1 : 0
    ))?>
	</div>
</div>
<?= form_submit(array(
	'name'=>'submit',
	'id'=>'submit',
	'value'=>lang('common_submit'),
	'class'=>'submit_button float_right'
))?>
</fieldset>
<?= form_close() ?>
<script type='text/javascript'>
$(document).ready(function(){
    setTimeout(function(){$(":input:visible:first","#customer_type_form").focus();},100);
	var submitting = false;
	$('#assets_form').validate({
		submitHandler:function(form){
			if (submitting) return;
			submitting = true;
			$(form).mask(<?= json_encode(lang('common_wait')); ?>);
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
//		rules: {
//			allocate: "required",
//   		},
//		messages: {
//     		allocate: "Bạn chưa tích vào ô chọn",
//		}
	});
});
</script>
