<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js" type="text/javascript"></script>
<div style="height:200px;">
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>

<?php
echo form_open('tinhoc/save/'.$tinhoc_info->id_tinhoc,array('id'=>'tinhoc_form'));
?>
<fieldset id="item_basic_info">
<legend><?php echo lang("tinhoc_basic"); ?></legend>

<div class="field_row clearfix">
<?php echo form_label(lang('tinhoc_name').':', 'name_tinhoc',array('class'=>'required wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'name_tinhoc',
		'id'=>'name_tinhoc',
		'value'=>$tinhoc_info->chungchi_tinhoc)
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
    
	var submitting = false;

	$('#tinhoc_form').validate({ /*sau khi them submit no se goi lai manage*/
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
				post_tinhoc_form_submit(response);
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules:
		{
		<?php if(!$item_info->id) {  ?>
			item_number:
			{
				remote: 
				    { 
					url: "<?php echo site_url('categories/item_number_exists');?>", 
					type: "post"
					
				    } 
			},
		<?php } ?>
			name:"required",
			category:"required",
			 // cost_price:
			 // {
				 // number:true
			 // },

			// unit_price:
			// {
				// required:true,
				// number:true
			// },
			tax_percent:
			{
				required:true,
				number:true
			},
			quantity:
			{
				required:true,
				number:true
			},
			reorder_level:
			{
				required:true,
				number:true
			}
   		},
		messages:
		{
			<?php if(!$item_info->id) {  ?>
			item_number:
			{
				remote: <?php echo json_encode(lang('items_item_number_exists')); ?>
				   
			},
			<?php } ?>
			name:<?php echo json_encode(lang('items_name_required')); ?>,
			category:<?php echo json_encode(lang('items_category_required')); ?>,
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
			quantity:
			{
				required:<?php echo json_encode(lang('items_quantity_required')); ?>,
				number:<?php echo json_encode(lang('items_quantity_number')); ?>
			},
			reorder_level:
			{
				required:<?php echo json_encode(lang('items_reorder_level_required')); ?>,
				number:<?php echo json_encode(lang('items_reorder_level_number')); ?>
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