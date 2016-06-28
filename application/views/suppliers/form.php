<?php
echo form_open('suppliers/save/'.$person_info->person_id,array('id'=>'supplier_form'));
?>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>

<fieldset id="customer_basic_info"><legend><?php echo lang("customers_basic_information"); ?></legend>
<table>
	<tr>
		<td>
		<div class="field_row clearfix"><?php echo form_label(lang('suppliers_company_name').':', 'company_name', array('class'=>'required')); ?>
		<div class='form_field'><?php echo form_input(array(
		'name'=>'company_name',
		'id'=>'company_name_input',
		'value'=>$person_info->company_name)
		);?></div>
		</div>
		</td>
		<td>

		<div class="field_row clearfix"><?php echo form_label(lang('suppliers_account_number').':', 'account_number', array('class'=>'required')); ?>

		<div class='form_field'><?php echo form_input(array(
		'name'=>'account_number',
		'id'=>'account_number',
		'value'=>$person_info->account_number)
		);?></div>
		</div>
		</td>
	</tr>
	<tr>
		<td>

		<div class="field_row clearfix"><?php echo form_label(lang('common_first_name').':', 'first_name',array('class'=>'required')); ?>
		<div class='form_field'><?php echo form_input(array(
		'name'=>'first_name',
		'id'=>'first_name',
		'value'=>$person_info->first_name.' '.$person_info->last_name)
		);?></div>
		</div>
		</td>
		<td>
		<div class="field_row clearfix"><?php echo form_label(lang('common_email').':', 'email'); ?>
		<div class='form_field'><?php echo form_input(array(
		'name'=>'email',
		'id'=>'email',
		'value'=>$person_info->email)
		);?></div>
		</div>
		</td>
	</tr>
	<tr>
		<td>
		<div class="field_row clearfix"><?php echo form_label(lang('common_phone_number').':', 'phone_number',array('class'=>'wide')); ?>
		<div class='form_field'><?php echo form_input(array(
		'name'=>'phone_number',
		'id'=>'phone_number',
		'value'=>$person_info->phone_number));?></div>
		</div>
		</td>
		<td>
		<div class="field_row clearfix"><?php echo form_label(lang('common_address_1').':', 'address_1'); ?>
		<div class='form_field'><?php echo form_input(array(
		'name'=>'address_1',
		'id'=>'address_1',
		'value'=>$person_info->address_1));?></div>
		</div>
		</td>
	</tr>
	<tr>
		<td><!-- phan lam ngay sinh khach hang -->
		<div class="field_row clearfix"><?php echo form_label(lang('common_birth_date').':', 'birth_date'); ?>
		<div class='form_field'><?php
		echo form_input(array(
		'name'=>'birth_date',
		'id'=>'birth_date',
		'value'=>$person_info->birth_date != '1950-01-01'?date(get_date_format(),strtotime($person_info->birth_date != ''?$person_info->birth_date: date('d-m-Y'))):''
		)
		)
		;?></div>
		</div>
		</td>



		<td><?php if($person_info->type == 0){?> <label style="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio" name="type" id="radio_city" value="0"
			checked="checked">Việt Nam&nbsp;</label> <label style=""> <input
			type="radio" name="type" id="radio_world" value="1">&nbsp;&nbsp;Quốc
		tế</label> <?php 	
		}else{?> <label style="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio" name="type" id="radio_city" value="0">Việt
		Nam&nbsp;</label> <label style=""> <input type="radio" name="type"
			id="radio_world" value="1" checked="checked">&nbsp;&nbsp;Quốc tế</label>

			<?php }?></td>



	</tr>
	<tr>
		<td>


		<div class="field_row clearfix"><?php echo form_label(lang('common_comments').':', 'comments'); ?>
		<div class='form_field'><?php echo form_textarea(array(
		'name'=>'comments',
		'id'=>'comments',
		'value'=>$person_info->comments,
		'rows'=>'5',
		'cols'=>'17')		
		);?></div>
		</div>
		</td>
		<td><!-- phan lam city -->
		<div id="city"><?php if($person_info->person_id != null){ ?>
		<div class="field_row clearfix"><?php echo form_label('Thành phố :', 'city'); ?>
		<div class='form_field'><select name="city">
		<?php
		foreach($option as $op){
			if($person_info->city == $op['id_city']){ ?>
			<option value="<?php echo $op['id_city']; ?>" selected="selected"><?php echo $op['name']; ?></option>
			<?php } else { ?>
			<option value="<?php echo $op['id_city']; ?>"><?php echo $op['name']; ?></option>
			<?php } } ?>
		</select></div>
		</div>
		<?php }else{ ?>
		<div class="field_row clearfix"><?php echo form_label('Thành phố :', 'world'); ?>
		<div class='form_field'><select name="city">
		<?php foreach($option as $op){ ?>
			<option value="<?php echo $op['id_city']; ?>"><?php echo $op['name']; ?></option>
			<?php } ?>
		</select></div>
		</div>
		<?php } ?></div>



		<div id="world" style="display: none"><?php if($person_info->person_id != null){ ?>
		<div class="field_row clearfix"><?php echo form_label('Đất nước :', 'world'); ?>
		<div class='form_field'><select name="world">
		<?php
		foreach($option2 as $op){
			if($person_info->city == $op['id_city']){ ?>
			<option value="<?php echo $op['id_city']; ?>" selected="selected"><?php echo $op['name']; ?></option>
			<?php } else { ?>
			<option value="<?php echo $op['id_city']; ?>"><?php echo $op['name']; ?></option>
			<?php } } ?>
		</select></div>
		</div>
		<?php }else{ ?>
		<div class="field_row clearfix"><?php echo form_label('Đất nước :', 'world'); ?>
		<div class='form_field'><select name="world">
		<?php foreach($option2 as $op){ ?>
			<option value="<?php echo $op['id_city']; ?>"><?php echo $op['name']; ?></option>
			<?php } ?>
		</select></div>
		</div>
		<?php } ?></div>
                <div class="field_row clearfix">	
                    <?php echo form_label('Tài khoản ngầm định:', 'debt'); ?>
                    <div class='form_field'>
                        <input type="text" name="account_implicit_sp" id="account_implicit_sp" value="331" disabled="true"/>
                    </div>
                </div>
		<?php
		echo form_submit(array(
	'name'=>'submit',
	'id'=>'submit',
	'style'=>'margin-right:48px',
	'value'=>lang('common_submit'),
	'class'=>'submit_button float_right')
		);
		?></td>
	</tr>

</table>
</fieldset>
		<?php
		echo form_close();
		?>
<script type='text/javascript'>


//validation and submit handling
$(document).ready(function()
{
	
    setTimeout(function(){$(":input:visible:first","#supplier_form").focus();},100);
	var submitting = false;
	
	$('#supplier_form').validate({
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
				post_person_form_submit(response);
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules: 
		{
			account_number:
			{
				required:true,
				remote: 
				    { 
					url: "<?php echo site_url('suppliers/check_account/'. $person_info->person_id);?>", 
					type: "post"
					
				    } 
			},
			company_name:
			{
				required:true,
				remote: 
			    { 
					url: "<?php echo site_url('suppliers/checkname/'. $person_info->person_id);?>", 
					type: "post"
				},
				
				
			},
			first_name: "required",
			last_name: "required",
    		email: "email"
   		},
		messages: 
		{
			account_number:
			{
				required: 'Vui lòng nhập mã nhà cung cấp #',
				remote: 'Mã nhà cung cấp đã tồn tại, vui lòng chọn mã khác'
			},
			company_name:{
     	    	required: 'Vui lòng nhập tên công ty',
     	    	remote: 'Tên công ty đã tồn tại, vui lòng chọn tên khác'    	
     	    }, 
     	   first_name: <?php echo json_encode(lang('common_last_name_required')); ?>,
     		email: <?php echo json_encode(lang('common_email_invalid_format')); ?>
		}
	});

	//hung audi 10-4-15
	if ($("#radio_city").is(':checked')) {
		$("#city").css({'display':'block'});
        $("#world").css({'display':'none'});        
    } else{
    	$("#world").css({'display':'block'});
        $("#city").css({'display':'none'});
    }


	$("#radio_world").click(function () {
	    if ($("#radio_world").is(':checked')) {
	    	$("#world").css({'display':'block'});
	        $("#city").css({'display':'none'});
	    }  
	});
	$("#radio_city").click(function () {
	    if ($("#radio_city").is(':checked')) {
	    	$("#city").css({'display':'block'});
	        $("#world").css({'display':'none'});
	    }  
	});
	
});
</script>
