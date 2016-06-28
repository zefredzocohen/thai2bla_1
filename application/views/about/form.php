<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js" type="text/javascript"></script>
<div style="height:200px;">
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>

<?php

echo form_open('abouts/save/'.$item_info->id,array('id'=>'abouts_form'));
//echo form_open('categories/save/'.$item_info->id_cat,array('id'=>'categories_form'));
?>
<fieldset id="item_basic_info">
<legend><?php echo lang("items_basic_information"); ?></legend>

<div class="field_row clearfix">
<?php echo form_label(lang('abouts_id').':', 'name',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'id',
		'id'=>'id',
		'Disabled'=>'true',
		'value'=>$item_info->id)
	);?>
    
   	</div>
</div>

<div class="field_row clearfix">
<?php echo form_label(lang('abouts_website').':', 'website',array('class'=>'required wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'website',
		'id'=>'website',
		'value'=>$item_info->website)
	);?>
	</div>
</div>

<div class="field_row clearfix">
<?php echo form_label(lang('abouts_phone_number').':', 'phone_number',array('class'=>'required wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'phone_number',
		'id'=>'phone_number',
		'value'=>$item_info->phone_number)
	);?>
	</div>
</div>

<div class="field_row clearfix">
<?php echo form_label(lang('abouts_email').':', 'email',array('class'=>'required wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'email',
		'id'=>'email',
		'value'=>$item_info->email)
	);?>
	</div>
</div>

<div class="field_row clearfix">
<?php echo form_label(lang('abouts_address').':', 'address'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'address',
		'id'=>'address',
		'value'=>$item_info->address)
	);?>
	</div>
</div>

<div class="field_row clearfix">
<?php echo form_label(lang('abouts_yahoo').':', 'yahoo'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'yahoo',
		'id'=>'yahoo',
		'value'=>$item_info->yahoo)
	);?>
	</div>
</div>

<div class="field_row clearfix">
<?php echo form_label(lang('abouts_skype').':', 'skype'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'skype',
		'id'=>'skype',
		'value'=>$item_info->skype)
	);?>
	</div>
</div>

<div class="field_row clearfix">
<?php echo form_label(lang('abouts_name_eployee').':', 'name_eployee'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'name_eployee',
		'id'=>'name_eployee',
		'value'=>$item_info->name_eployee)
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

	$( "#category" ).autocomplete({
		source: "<?php echo site_url('categories/suggest_category');?>",
		delay: 10,
		autoFocus: false,
		minLength: 0
	});

	var submitting = false;

	$('#abouts_form').validate({ /*sau khi them submit no se goi lai manage*/
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
		<?php /*?><?php if(!$item_info->id_cat) {  ?>
			item_number:
			{
				remote: 
				    { 
					url: "<?php echo site_url('categories/item_number_exists');?>", 
					type: "post"
					
				    } 
			},
		<?php } ?><?php */?>
			website:"required",
			//category:"required",
			 // cost_price:
			 // {
				 // number:true
			 // },

			// unit_price:
			// {
				// required:true,
				// number:true
			// },
			//tax_percent:
			//{
			//	required:true,
			//	number:true
			//},
			phone_number:
			{
				required:true,
				number:true,
			},
			email:
			{
				required:true,
			 	email:"email",
			},
			//reorder_level:
			//{
			//	required:true,
			//	number:true
			//}
   		},
		messages:
		{
			<?php if(!$item_info->item_id) {  ?>
			item_number:
			{
				remote: <?php echo json_encode(lang('items_item_number_exists')); ?>
				   
			},
			<?php } ?>
			website:<?php echo json_encode(lang('abouts_website_required')); ?>,
			//phone_number:<?php echo json_encode(lang('abouts_phone_number_required')); ?>,
			//email:<?php echo json_encode(lang('abouts_email_required')); ?>,
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
				required:<?php echo json_encode(lang('abouts_phone_number_required')); ?>,
				number:<?php echo json_encode(lang('abouts_phone_number_number')); ?>
			},
			email:
			{
				required:<?php echo json_encode(lang('abouts_email_required')); ?>,
				email:<?php echo json_encode(lang('abouts_email_mail')); ?>
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
</div>