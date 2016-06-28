
<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/resizeimg.js" type="text/javascript"></script>
<div style="height:200px;">
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>

<?php 
//if(isset($debug)&&$debu)
echo form_open('slider/save/'.$item_info->id,array('id'=>'slider_form'));
?>
<fieldset id="item_basic_info">
<legend><?php echo lang("items_basic_information"); ?></legend>

<div class="field_row clearfix">
<?php echo form_label(lang('slider_name').':', 'name',array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'name',
		'id'=>'name',
		'value'=>$item_info->name)
	);?>
	</div>
</div>

<div class="field_row clearfix">
<?php
    echo form_open('slider/checkimage/'.$item_info->id,array('id'=>'slider_form'));
    echo form_label(lang('slider_img').':', 'img',array('class'=>'required')); 
    echo form_close();

?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'img',
		'id'=>'img',
		'type'=>'file',)
	);
        ?>
	</div>
</div>

<div class="field_row clearfix">
<?php echo form_label(lang('slider_description').':', 'description'); ?>
	<div class='form_field'>
	<?php echo form_textarea(array(
		'name'=>'description',
		'id'=>'description',
		'value'=>$item_info->description,
		'rows'=>'5',
		'cols'=>'17')
	);?>
	</div>
</div>

<div class="field_row clearfix">
<?php echo form_label(lang('slider_active').':', 'active'); ?>
    <div class='form_field'>
    <?php
    echo form_checkbox(array(
        'name' => 'active',
        'id'   => 'active',
        'type' => 'checkbox'
        ), true, $item_info->active == 1 ? true : false
    );
    ?>
    </div>
</div>

<?php
echo form_submit(array(
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
	$('#birth_date').datePicker({startDate: '01-01-1950'});
	// $('#phone_number').keyup(function () {
     // this.value = this.value.replace(/[^0-9\.]/g,'');
	 // });
});
</script>
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

	$( "#slider" ).autocomplete({
		source: "<?php echo site_url('slider/suggest_category');?>",
		delay: 10,
		autoFocus: false,
		minLength: 0
	});

	var submitting = false;

	$('#slider_form').validate({ /*sau khi them submit no se goi lai manage*/
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
		<?php if(!$item_info->id_cat) {  ?>
			item_number:
			{
				remote:
				    {
					url: "<?php echo site_url('slider/item_number_exists');?>",
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
			<?php if(!$item_info->item_id) {  ?>
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
