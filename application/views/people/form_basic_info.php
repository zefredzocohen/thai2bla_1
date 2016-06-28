
<fieldset id="customer_basic_info">
    <legend><?php echo lang("customers_basic_information"); ?></legend>
<table>
<tr>
<td>
<div class="field_row clearfix">	
<?php echo form_label(lang('common_first_name').':', 'first_name',array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'first_name',
		'id'=>'first_name',
		'value'=>$person_info->first_name)
	);?>
	</div>
</div>
</td>
<td>
<div class="field_row clearfix">	
<?php echo form_label(lang('common_email').':', 'email'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'email',
		'id'=>'email',
		'value'=>$person_info->email)
	);?>
	</div>
</div>
</td>
</tr>
<tr>
<td>
<div class="field_row clearfix">	
<?php echo form_label(lang('common_phone_number').':', 'phone_number',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'phone_number',
		'id'=>'phone_number',
		'value'=>$person_info->phone_number));?>
	</div>
</div>
</td><td>
<div class="field_row clearfix">	
<?php echo form_label(lang('common_address_1').':', 'address_1'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'address_1',
		'id'=>'address_1',
		'value'=>$person_info->address_1));?>
	</div>
</div>
</td></tr><tr><td>
<!-- phan lam ngay sinh khach hang -->
<div class="field_row clearfix">	
<?php echo form_label(lang('common_birth_date').':', 'birth_date'); ?>
	<div class='form_field'>
	<?php
        echo form_input(array(
		'name'=>'birth_date',
		'id'=>'birth_date',
		'value'=>$person_info->birth_date != '1950-01-01'?date(get_date_format(),strtotime($person_info->birth_date != ''?$person_info->birth_date: date('d-m-Y'))):''
		)
	)
        ;?>
	</div>
</div>
</td><td>
<!-- phan lam city -->
<?php if($person_info->person_id != null){ ?>
<div class="field_row clearfix">
	<?php echo form_label(lang('common_city').':', 'city'); ?>
	<div class='form_field'>
			<select name="city">
			 <?php  print_r($option); ?>
			<?php foreach($option as $op){ ?>
				<?php if($person_info->city == $op['id_city']){ ?>
						<option value="<?php echo $op['id_city']; ?>" selected="selected"><?php echo $op['name']; ?></option>
				<?php } else { ?>
					<option value="<?php echo $op['id_city']; ?>"><?php echo $op['name']; ?></option>
			<?php } } ?>
			</select>
		</div>
</div>
<?php }else{ ?>
	<div class="field_row clearfix">
	<?php echo form_label(lang('common_city').':', 'city'); ?>
	<div class='form_field'>
			<select name="city">
			<?php foreach($option as $op){ ?>
					<option value="<?php echo $op['id_city']; ?>"><?php echo $op['name']; ?></option>
			<?php } ?>
			</select>
		</div>
</div>
<?php } ?>
</td></tr><tr><td>


<div class="field_row clearfix">	
<?php echo form_label(lang('common_comments').':', 'comments'); ?>
	<div class='form_field'>
	<?php echo form_textarea(array(
		'name'=>'comments',
		'id'=>'comments',
		'value'=>$person_info->comments,
		'rows'=>'5',
		'cols'=>'17')		
	);?>
	</div>
</div>
</td></tr>
</table>
</fieldset>
