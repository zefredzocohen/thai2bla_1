<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js" type="text/javascript"></script>
<?php
echo form_open('costs/save_emp_cost',array('id'=>'item_form'));
?>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>

<fieldset id="item_basic_info">
<legend><?php echo "Thông tin chi phí"; ?></legend>
<div class="field_row clearfix" style="margin-bottom: 10px">
	<?php echo form_label('Tên nhân viên :', 'name_customer',array('class'=>'')); ?>
	<div class='form_field' >
		<?php echo $this->Person->get_info($id_customer)->first_name;?> 
	</div>
	<input type="hidden" value="<?php echo $id_customer ; ?>" name="id_customer" />
</div>
<div class="field_row clearfix">	
<?php echo form_label(lang('costs_date').':', 'cost_date'); ?>
	<div class='form_field'>
	<?php
        echo form_input(array(
		'name'=>'cost_date',
		'id'=>'cost_date',
		'value'=>$cost_info->date != '1950-01-01'?date(get_date_format(),strtotime($cost_info->date != ''?$cost_info->date: date('d-m-Y'))):''
		)
	)
        ;?>
	</div>
</div>
<?php if($cost_info->id_cost != null){ ?>
<div class="field_row clearfix">
<?php echo form_label(lang('costs_method').':', 'costs_method'); ?>
	<?php if($cost_info->tien_thu > 0) { ?>
	<div class='form_field'>
	<select name="costs_method" style="width:112px;">
		<option value="1" selected="selected" >Thu</option>
		<option value="2">Chi</option>
	</select>
	</div>
	<?php } else { ?>
	<select name="costs_method" style="width:112px;">
		<option value="1">Thu</option>
		<option value="2" selected="selected" >Chi</option>
	</select>
	<?php } ?>
</div>
<?php } else { ?>
<div class="field_row clearfix">
<?php echo form_label(lang('costs_method').':', 'costs_method'); ?>
	<div class='form_field'>
	<select name="costs_method" style="width:112px;">
		<option value="1">Thu</option>
		<option value="2">Chi</option>
	</select>
	</div>
</div>
<?php } ?>
<!-- hao -->
<?php if($cost_info->id_cost != null){ ?>
<div class="field_row clearfix">
	<?php echo form_label('Tên chi phí:', 'name',array('class'=>'required wide')); ?>
	<div class='form_field'>
			<select name="name">
					<?php foreach($option_cost as $option_costs){ 
						
						if($cost_info->name == $option_costs['cost_id']){ ?>
							
							<option value="<?php echo $option_costs['cost_id'] ?>" selected="selected"><?php echo $option_costs['cost_name'] ?></option>
							
						<?php }else { ?>
							<option value="<?php echo $option_costs['cost_id'] ?>"><?php echo $option_costs['cost_name'] ?></option>
					<?php }} ?>
			</select>
	</div>
</div>
<?php }else{ ?>
	<div class="field_row clearfix">
	<?php echo form_label('Tên chi phí:', 'name',array('class'=>'required wide')); ?>
	<div class='form_field'>
			<select name="name">
				<?php foreach($option_cost as $option_costs){  ?>
				<option value="<?php echo $option_costs['cost_id'] ?>"><?php echo $option_costs['cost_name'] ?></option>
				<?php } ?>
			</select>
		</div>
</div>
	
	<?php } ?>	
<!-- end hao -->
<div class="field_row clearfix">
	<?php echo form_label('Số tiền :', 'price_cost',array('class'=>'required wide')); ?>
	<div class='form_field' >
	<?php echo form_input(array(
		'name'=>'price_cost',
		'id'=>'price_cost',
		'value'=>$cost_info->tien_thu > 0 ? to_currency_unVND($cost_info->tien_thu) : to_currency_unVND($cost_info->tien_chi))
	);?> VND
	</div>
</div>

<div class="field_row clearfix">	
	<?php echo form_label('Tài khoản đối ứng :', 'tk_du',array('class'=>'wide')); ?>
	<div class='form_field' >
	<?php echo form_input(array(
		'name'=>'tk_du',
		'id'=>'tk_du',
		'value'=>$cost_info->tk_du)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
	<?php echo form_label('Số chứng từ :', 'chungtu'); ?>
	<div class='form_field' >
	<?php echo form_input(array(
		'name'=>'chungtu',
		'id'=>'chungtu',
		'value'=>$cost_info->chungtu)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label(lang('costs_date_ct').':', 'cost_date_ct'); ?>
	<div class='form_field'>
	<?php
        echo form_input(array(
		'name'=>'cost_date_ct',
		'id'=>'cost_date_ct',
		'value'=>$cost_info->cost_date_ct != '1950-01-01'?date(get_date_format(),strtotime($cost_info->cost_date_ct != ''?$cost_info->cost_date_ct: date('d-m-Y'))):''
		)
	)
        ;?>
	</div>
</div>
<div class="field_row clearfix">	
	<?php echo form_label('Thêm mô tả: ', 'description',array('class'=>'wide')); ?>
	<div class='form_field' >
	<?php echo form_textarea(array(
		'name'=>'description',
		'id'=>'description',
		'value'=>$cost_info->comment,
		'rows'=>'5',
		'cols'=>'17')
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
	$('#cost_date').datePicker({startDate: '01-01-1950'});
	$('#cost_date_ct').datePicker({startDate: '01-01-1950'});
	 
});
</script>
<script type="text/javascript">
  $(function() { 
    $("#price_cost").maskMoney();
  });
</script>