<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js" type="text/javascript"></script>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<?php
echo form_open('salaryoption/save/'.$item_info->id,array('id'=>'salaryoption_form'));
?>
<fieldset id="item_basic_info" style="height: 420px">
<legend><?php echo lang("salaryoption_basic_information"); ?></legend>

<div class="field_row clearfix">
<?php echo form_label(lang('salaryoption_numberdays').':', 'numberdays',array('class'=>'required wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'numberdays',
		'id'=>'numberdays',
		'value'=>$item_info->numberdays)
	);?>
	</div>
</div>

<div class="field_row clearfix">
<?php echo form_label(lang('salaryoption_numberhours').' :', 'numberhours',array('class'=>'required wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'numberhours',
		'id'=>'numberhours',
		'value'=>$item_info->numberhours)
	);?>
	</div>
</div>
<style>
    .field_row input{
        width: 80px!important;
        margin-left: 10px;
    }
</style>
<div class="field_row clearfix">
<?php echo form_label(lang('salaryoption_percent_overtime_weekdays').' :', 'percent_overtime_weekdays',array('class'=>'required wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'percent_overtime_weekdays',
		'id'=>'percent_overtime_weekdays',
		'value'=>$item_info->percent_overtime_weekdays)
	);?>
	</div>
</div>

<div class="field_row clearfix">
<?php echo form_label(lang('salaryoption_percent_overtime_sunday').' :', 'percent_overtime_sunday'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'percent_overtime_sunday',
		'id'=>'percent_overtime_sunday',
		'value'=>$item_info->percent_overtime_sunday)
	);?>
	</div>
</div>

<div class="field_row clearfix">
<?php echo form_label(lang('salaryoption_percent_overtime_holiday').' :', 'percent_overtime_holiday'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'percent_overtime_holiday',
		'id'=>'percent_overtime_holiday',
		'value'=>$item_info->percent_overtime_holiday)
	);?>
	</div>
</div>

<div class="field_row clearfix">
<?php echo form_label(lang('salaryoption_union_dues').' :', 'union_dues'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'union_dues',
		'id'=>'union_dues',
		'value'=>$item_info->union_dues)
	);?>
	</div>
</div>

<div class="field_row clearfix">
<?php echo form_label(lang('salaryoption_exemption_amount').' :', 'exemption_amount'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'exemption_amount',
		'id'=>'exemption_amount',
		'value'=>$item_info->exemption_amount)
	);?>
	</div>
</div>

<?php
echo form_submit(array(
	'name'=>'submit',
	'id'=>'submit',
    'style'=>'margin-right: 25px',
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
    setTimeout(function(){$(":input:visible:first","#salaryoption_form").focus();},100);
    
    $('#start_year,#start_month,#start_day,#end_year,#end_month,#end_day').change(function()
    {
        $("#hdn_start_date").val($("#start_year").val()+'-'+$("#start_month").val()+'-'+$('#start_day').val());
        $("#hdn_end_date").val($("#end_year").val()+'-'+$("#end_month").val()+'-'+$('#end_day').val());
    });

	$( "#category" ).autocomplete({
		source: "<?php echo site_url('Salaryoption/suggest');?>",
		delay: 10,
		autoFocus: false,
		minLength: 0
	});

	var submitting = false;

	$('#salaryoption_form').validate({ /*sau khi them submit no se goi lai manage*/
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
			<?php if(!$item_info->item_id) {  ?>
			item_number:
			{
				remote: <?php echo json_encode(lang('items_item_number_exists')); ?>
				   
			},
			<?php } ?>
			website:<?php echo json_encode(lang('salaryoption_website_required')); ?>,
			//phone_number:<?php echo json_encode(lang('salaryoption_phone_number_required')); ?>,
			//email:<?php echo json_encode(lang('salaryoption_email_required')); ?>,
			 // cost_price:
			 // {
				 // number:<?php echo json_encode(lang('items_cost_price_number')); ?>
			 // },
			// unit_price:
			// {
				// required:<?php echo json_encode(lang('items_unit_price_required')); ?>,
				// number:<?php echo json_encode(lang('items_unit_price_number')); ?>
			// },
			tax_percent:
			{
				required:<?php echo json_encode(lang('items_tax_percent_required')); ?>,
				number:<?php echo json_encode(lang('items_tax_percent_number')); ?>
			},
			phone_number:
			{
				required:<?php echo json_encode(lang('salaryoption_phone_number_required')); ?>,
				number:<?php echo json_encode(lang('salaryoption_phone_number_number')); ?>
			},
			email:
			{
				required:<?php echo json_encode(lang('salaryoption_email_required')); ?>,
				email:<?php echo json_encode(lang('salaryoption_email_mail')); ?>
			}

		}
	});
});
</script>
<script type="text/javascript">
  $(function() { 
    $("#unit_price").maskMoney();
	 $("#cost_price").maskMoney();
  });
</script>
