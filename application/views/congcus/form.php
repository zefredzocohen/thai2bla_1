<?= form_open('congcus/save/'.$var_info->id,array('id'=>'assets_form')) ?>
<div id="required_fields_message"><?= lang('common_fields_required_message') ?></div>
<ul id="error_message_box"></ul>
<fieldset id="supplier_basic_info">
<legend><?= lang("var_information") ?></legend>
<div class="field_row clearfix">	
<?= form_label('Mã công cụ/Dụng cụ:', ' congcu_number', array('class'=>'required')) ?>
	<div class='form_field'>
	<?= form_input(array(
		'name'=>'congcu_number',
		'id'=>'congcu_number',
		'value'=>$var_info->congcu_number
    ))?>
	</div>
</div>
<div class="field_row clearfix">	
<?= form_label('Tên công cụ/Dụng cụ:', ' assets_name', array('class'=>'required')) ?>
	<div class='form_field'>
	<?= form_input(array(
		'name'=>'assets_name',
		'id'=>'assets_name',
		'value'=>$var_info->name
    ))?>
	</div>
</div>
<div class="field_row clearfix">	
<?= form_label('Giá trị công cụ/Dụng cụ:', ' value', array('class'=>'')) ?>
	<div class='form_field'>
	<?= form_input(array(
		'name'=>'value',
		'id'=>'value',
		'value'=>$var_info->value
    ))?>
	</div>
</div>
<div class="field_row clearfix">	
<?= form_label('Giá trị công cụ/Dụng cụ còn lại:', ' value_remain', array('class'=>'')) ?>
	<div class='form_field'>
	<?= form_input(array(
		'name'=>'value_remain',
		'id'=>'value_remain',
		'value'=> $var_info->value_remain == 0 ? $var_info->value : $var_info->value_remain
    ))?>
	</div>
</div>
<!-- 12/02/2014-->
<?php 
	$this->load->model('Nhomts_thietbis');
	$data['drop']=$this->Nhomts_thietbis->get_select_dropdown();
?>
<div class="field_row clearfix">
    <?= form_label('Nhóm công cụ/Dụng cụ:', 'group',array('class'=>'')) ?>
 	<div class='form_field'>
		<select id="tstb_name" name="tbts_nhom">
            <option value="" selected="selected">Chọn tài sản - thiết bị</option> 
            <?php  
            foreach ($data['drop'] as  $value) { ?>
                <option value="<?= $value['id_tstb'] ?>">
                    <?= $value['name_tstb'] ?>
                </option>
            <?php 
            }?>
		</select>
	</div>
</div>
<!-- END 12/02/2014-->
<div class="field_row clearfix">
<?= form_label(lang('assets_lydo_tang').':', 'description',array('class'=>'wide')) ?>
<?= form_textarea(array(
		'name'=>'description',
		'id'=>'description',
		'value'=>$var_info->lydotang,
		'rows'=>'5',
		'cols'=>'17'
    ))?>
</div>
<div class="field_row clearfix">	
<?= form_label(lang('assets_date_tang').':', 'date_tang') ?>
	<div class='form_field'>
	<?= form_input(array(
		'name'=>'date_tang',
		'id'=>'date_tang',
		'value'=> $var_info->date_tang != '1950-01-01'
                    ? date(
                        get_date_format(),
                        strtotime(
                            $var_info->date_tang != '' ? $var_info->date_tang : date('d-m-Y')
                        )
                    )
                    : '',
    ))?>
	</div>
</div>
<div class="field_row clearfix">	
<?= form_label(lang('assets_date_kh').':', 'date_kh') ?>
	<div class='form_field'>
	<?= form_input(array(
		'name'=>'date_kh',
		'id'=>'date_kh',
		'value'=> $var_info->date_kh != '1950-01-01'
                    ? date(
                        get_date_format(),
                        strtotime(
                            $var_info->date_kh != '' ? $var_info->date_kh : date('d-m-Y')
                        )
                    )
                    : '',
		)
	)?>
	</div>
</div>
<div class="field_row clearfix">	
<?= form_label(lang('assets_kykh').':', 'kykh') ?>
	<div class='form_field'>
	<?= form_input(array(
		'name'=>'ky_khauhao',
		'id'=>'ky_khauhao',
		'value'=>$var_info->ky_khauhao
    ))?>
	</div>
</div>
<div class="field_row clearfix">
    <?= form_label(lang('assets_ppkh').':', 'ppkh',array('class'=>'')) ?>
    <div class='form_field' style="color: blue">&nbsp; Theo đường thẳng</div>
</div>
<!-- so tien kh ts 1 ky -->
<div class="field_row clearfix">	
<?= form_label('Số tiền kh ts 1 kỳ:', 'kh1ky') ?>
	<div class='form_field'>
	<?= form_input(array(
		'name'=>'kh1ky',
		'id'=>'kh1ky',
		'value'=> $var_info->value / $var_info->ky_khauhao
    ))?>
	</div>
</div>
<!-- end so tien kh ts 1 ky -->
<!-- bo phan su dung 12/02/2014 -->
<?php 
	$this->load->model('Bpsds');
	$data['drop_bpsd'] = $this->Bpsds->get_select_dropdown_bp();
?>
<div class="field_row clearfix">
    <?= form_label(lang('assets_bp').':', 'assets_bp',array('class'=>'')) ?>
    <div class='form_field'>
		<select id="bpsd_id" name="bpsd_name">
            <option value="">Chọn tên bộ phận</option> 
            <?php  
            foreach ($data['drop_bpsd'] as  $value) { ?>
                <option value="<?= $value['id_bpsd'] ?>">
                    <?= $value['name_bpsd'] ?>
                </option>
            <?php 
            }?>
		</select>
	</div>
</div>
<!-- end bo phan su dung -->
<!--<div class="field_row clearfix">	
<?= form_label(lang('assets_tktk').':', 'tktk') ?>
	<div class='form_field'>
	<?= form_input(array(
		'name'=>'tktk',
		'id'=>'tktk',
		'value'=>$var_info->tktk
    ))?>
	</div>
</div>-->

<div class="field_row clearfix">	
<?= form_label(lang('assets_tkkh').':', 'tkkh') ?>
	<div class='form_field'>
	<?= form_input(array(
		'name'=>'tkkh',
		'id'=>'tkkh',
		'value'=>$var_info->tkkh
    ))?>
	</div>
</div>
<div class="field_row clearfix">	
<?= form_label(lang('assets_tkcp').':', 'tkcp') ?>
	<div class='form_field'>
	<?= form_input(array(
		'name'=>'tkcp',
		'id'=>'tkcp',
		'value'=>$var_info->tkcp
    ))?>
	</div>
</div>
<?= form_submit(array(
	'name'=>'submit',
	'id'=>'submit',
	'value'=>lang('common_submit'),
	'class'=>'submit_button float_right'
))?>
</fieldset>
<?= form_close() ?>
<script type='text/javascript'>
$(document).ready(function(){
    $('#ky_khauhao').blur(function(){
        var vnd_one_exam = $('#value').val() / $('#ky_khauhao').val();
        $('#kh1ky').val(vnd_one_exam);
    });
    $('#value_remain').blur(function(){
        var vnd_one_exam = $('#value').val() / $('#ky_khauhao').val();
        $('#kh1ky').val(vnd_one_exam);
    });
    
    
	$( "#tktk" ).autocomplete({
		source: '<?= site_url("assets/tkdu_search"); ?>',
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
		source: '<?= site_url("assets/tkdu_search"); ?>',
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
		source: '<?= site_url("assets/tkdu_search"); ?>',
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
			if (submitting) return;
			submitting = true;
			$(form).mask(<?= json_encode(lang('common_wait')); ?>);
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
			assets_name: "required",
   		},
		messages: 
		{
     		assets_name: "Bạn cần nhập tên loại khách hàng",
		}
	});
});
</script>