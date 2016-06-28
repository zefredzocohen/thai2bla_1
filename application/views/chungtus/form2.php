<?php
echo form_open('chungtus/save/'.$var_info->id,array('id'=>'assets_form'));
?>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<fieldset id="supplier_basic_info">
<legend><?php echo lang("var_information"); ?></legend>


<div class="field_row clearfix">	
<?php echo form_label(lang('common_name').':', ' chungtu_name', array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'chungtu_name',
		'id'=>'chungtu_name',
		'value'=>$var_info->name)
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
	$( "#tktk" ).autocomplete({
		source: '<?php echo site_url("assets/tkdu_search"); ?>',
		delay: 10,
		autoFocus: false,
		minLength: 0,
		select: function( event, ui ) 
		{	
			$( "#tktk" ).val(ui.item.value)  ;
			return false;
		}
	});
	$( "#tkkh" ).autocomplete({
		source: '<?php echo site_url("assets/tkdu_search"); ?>',
		delay: 10,
		autoFocus: false,
		minLength: 0,
		select: function( event, ui ) 
		{	
			$( "#tkkh" ).val(ui.item.value)  ;
			return false;
		}
	});
	$( "#tkcp" ).autocomplete({
		source: '<?php echo site_url("assets/tkdu_search"); ?>',
		delay: 10,
		autoFocus: false,
		minLength: 0,
		select: function( event, ui ) 
		{	
			$( "#tkcp" ).val(ui.item.value)  ;
			return false;
		}
	});
	$('#date_tang').datePicker({startDate: '01-01-1950'});
	$('#date_kh').datePicker({startDate: '01-01-1950'});
    setTimeout(function(){$(":input:visible:first","#customer_type_form").focus();},100);
	var submitting = false;
	
	$('#assets_form').validate({
		submitHandler:function(form)
		{
			alert(0);
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
			chungtu_name: "required",
   		},
		messages: 
		{
     		chungtu_name: "Bạn cần nhập tên loại khách hàng",
		}
	});
});
</script>