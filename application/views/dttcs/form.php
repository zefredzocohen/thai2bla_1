<?php
echo form_open('dttcs/save/'.$var_info->id,array('id'=>'dttcs_form'));
?>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<fieldset id="supplier_basic_info">
<legend><?php echo lang("var_information"); ?></legend>


<div class="field_row clearfix">	
<?php echo form_label(lang('common_name').':', ' dttc_name', array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'dttc_name',
		'id'=>'dttc_name',
		'value'=>$var_info->name)
	);?>
	</div>
</div>
<div class="field_row clearfix">	
<?php echo form_label(lang('common_date_1').':', 'date_1'); ?>
	<div class='form_field'>
	<?php
        echo form_input(array(
		'name'=>'date_1',
		'id'=>'date_1',
		'value'=>$var_info->date_1 != '1950-01-01'?date(get_date_format(),strtotime($var_info->date_1 != ''?$var_info->date_1: date('d-m-Y'))):'',
		)
	)
        ;?>
	</div>
</div>
<div class="field_row clearfix">	
<?php echo form_label(lang('common_date_2').':', 'date_2'); ?>
	<div class='form_field'>
	<?php
        echo form_input(array(
		'name'=>'date_2',
		'id'=>'date_2',
		'value'=>$var_info->date_2 != '1950-01-01'?date(get_date_format(),strtotime($var_info->date_2 != ''?$var_info->date_2: date('d-m-Y'))):'',
		)
	)
        ;?>
	</div>
</div>
<div class="field_row clearfix">	
<?php echo form_label(lang('common_date_3').':', 'date_3'); ?>
	<div class='form_field'>
	<?php
        echo form_input(array(
		'name'=>'date_3',
		'id'=>'date_3',
		'value'=>$var_info->date_3 != '1950-01-01'?date(get_date_format(),strtotime($var_info->date_3 != ''?$var_info->date_3: date('d-m-Y'))):'',
		)
	)
        ;?>
	</div>
</div>
<div class="field_row clearfix">	
<?php echo form_label(lang('common_date_4').':', 'date_4'); ?>
	<div class='form_field'>
	<?php
        echo form_input(array(
		'name'=>'date_4',
		'id'=>'date_4',
		'value'=>$var_info->date_4 != '1950-01-01'?date(get_date_format(),strtotime($var_info->date_4 != ''?$var_info->date_4: date('d-m-Y'))):'',
		)
	)
        ;?>
	</div>
</div>
<div class="field_row clearfix">	
<?php echo form_label(lang('common_date_5').':', 'date_5'); ?>
	<div class='form_field'>
	<?php
        echo form_input(array(
		'name'=>'date_5',
		'id'=>'date_5',
		'value'=>$var_info->date_5 != '1950-01-01'?date(get_date_format(),strtotime($var_info->date_5 != ''?$var_info->date_5: date('d-m-Y'))):'',
		)
	)
        ;?>
	</div>
</div>
<div class="field_row clearfix">	
<?php echo form_label(lang('common_date_6').':', 'date_6'); ?>
	<div class='form_field'>
	<?php
        echo form_input(array(
		'name'=>'date_6',
		'id'=>'date_6',
		'value'=>$var_info->date_6 != '1950-01-01'?date(get_date_format(),strtotime($var_info->date_6 != ''?$var_info->date_6: date('d-m-Y'))):'',
		)
	)
        ;?>
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
$('#date_6').datePicker({startDate: '01-01-1950'});
$('#date_5').datePicker({startDate: '01-01-1950'});
$('#date_4').datePicker({startDate: '01-01-1950'});
$('#date_3').datePicker({startDate: '01-01-1950'});
$('#date_2').datePicker({startDate: '01-01-1950'});
$('#date_1').datePicker({startDate: '01-01-1950'});
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
	
	$('#dttcs_form').validate({
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
			chungtu_name: "required",
   		},
		messages: 
		{
     		chungtu_name: "Bạn cần nhập tên loại khách hàng",
		}
	});
});
</script>