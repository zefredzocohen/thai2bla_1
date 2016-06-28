<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js"
	type="text/javascript"></script>
<div style="height: 200px;">
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>

<?php
echo form_open('cities/save/'.$item_info->id_city,array('id'=>'categories_form'));
?>
<fieldset id="item_basic_info"><legend>Thông tin thành phố/ tên nước</legend>

<div class="field_row clearfix">
<?php echo form_label('Mã vùng/ mã nước'.':', 'zip_code',array('class'=>'required wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'zip_code',
		'id'=>'zip_code',
		'value'=>$item_info->zip_code)
	);?>
    
   	</div>
</div>

<div class="field_row clearfix"><?php echo form_label('Tên thành phố/ &nbsp; Tên nước'.':', 'name',array('class'=>'required wide')); 	?>
<div class='form_field'><?php echo form_input(array(
		'name'=>'name',
		'id'=>'name',
		'value'=>$item_info->name)
);?></div>
</div>

<div class="field_row clearfix"><?php echo form_label('Chọn loại'.':', 'name',array('class'=>'required wide')); 	?>

<?php if($item_info->type==0){?>
<label style="width: 100px"><input type="radio" name="type" value="0" checked="checked">Việt Nam</label>
<label style="width: 100px"><input type="radio" name="type" value="1">Quốc tế</label>
<?php }else{?>
<label style="width: 100px"><input type="radio" name="type" value="0">Việt Nam</label>
<label style="width: 100px"><input type="radio" name="type" value="1" checked="checked">Quốc tế</label>
<?php }?>
</div>
<?php
echo form_submit(array(
	'name'=>'submit',
	'id'=>'submit',
	'value'=>lang('common_submit'),
	'class'=>'submit_button float_right')
);
?></fieldset>
<?php
echo form_close();?>
</div>
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

	$( "#unit" ).autocomplete({
		source: "<?php echo site_url('units/suggest_unit');//	?>",
		delay: 10,
		autoFocus: false,
		minLength: 0
	});

	var submitting = false;

	$('#categories_form').validate({ /*sau khi them submit no se goi lai manage*/
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
		rules:{
			zip_code:{
				required:true,
				remote:{ 
					url: "<?php echo site_url('cities/check_zip_code/'. $item_info->id_city);?>", 
					type: "post"
				} 
			},
			name:{
				required:true,
				remote:{ 
					url: "<?php echo site_url('cities/checkname/'. $item_info->id_city);?>", 
					type: "post"
				} 
			},
   		},
		messages:{
   			zip_code:{
	     		required: 'Vui lòng nhập mã vùng/ mã nước',
		     	remote: 'Mã vùng/ mã nước đã tồn tại, vui lòng chọn mã khác'    	
	    	},
			name:{
		     	required: 'Vui lòng nhập tên thành phố/ tên nước',
		     	remote: 'Thành phố/ Tên nước đã tồn tại, vui lòng chọn tên khác'    	
		    },		
		}
	});
});
</script>
