<?php //$this->load->view("partial/header"); ?>
<div id="required_fields_message"><?= lang('common_fields_required_message') ?></div>
<ul id="error_message_box"></ul>
<fieldset id="supplier_basic_info">
<legend><?= lang("var_information") ?></legend>
<div class="field_row clearfix">	
<?= form_label('Thời gian:', ' lovetime', array('class'=>'required')) ?>
	<div class='form_field'>
        <?php echo form_dropdown('halloween_month',$months, $selected_month, 'id="halloween_month"'); ?>
        <?php echo form_dropdown('halloween_year',$years, $selected_year, 'id="halloween_year"'); ?>
	</div>
</div>
<div>
    <div id="add_payment_button" class="small_button" >
        <span class="kissing-you" name="kissing-you" style="width: 50px" >Tính</span>
    </div>          
</div>
<table class="wedding-dress-S2">
    <thead>
        <tr style="height: 26px !important">
            <th style="width: 10%">Mã CC</th>
            <th style="width: 30%">Tên CC</th>
            <th style="width: 15%">Số tiền</th>
            <th style="width: 15%">TK nợ</th>
            <th style="width: 15%">TK có</th>
            <th style="width: 15%">Hạn khấu hao</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table> <br>

<?php// echo form_submit(array(
//	'name'=>'submit',
//	'id'=>'submit',
//	'value'=>lang('common_submit'),
//	'class'=>'submit_button float_right'
//))?>
</fieldset>
<?= form_close() ?>
<script type='text/javascript'>
$(document).ready(function(){
    $('.kissing-you').click(function(){
        var halloween_month = $('#halloween_month').val();
        var halloween_year = $('#halloween_year').val();
        $(".wedding-dress-S2 tbody tr").remove();
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: "<?= site_url('assets/get_assets_halloween'); ?>",
            data: {halloween_month: halloween_month, halloween_year: halloween_year},
            success: function (data) {
                $(data).each(function (i, e) {
                    $(".wedding-dress-S2 tbody").append(
                        '<tr>'
                            +'<td style="text-align: center">' + e.id + '</td>'
                            +'<td>' + e.name + '</td>'
                            +'<td style="text-align: right">' + e.money + '</td>'
                            +'<td style="text-align: right">' + e.tkcp + '</td>'
                            +'<td style="text-align: right">' + e.tkkh + '</td>'
                            +'<td>' + e.han_khauhao + '</td>'
                        + '</tr>'
                    )
                });
                return false;
            }
        })
    });
    
    
    setTimeout(function(){$(":input:visible:first","#customer_type_form").focus();},100);
	var submitting = false;
	$('#assets_form').validate({
		submitHandler:function(form){
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
		rules: {
			allocate: "required",
   		},
		messages: {
     		allocate: "Bạn chưa tích vào ô chọn",
		}
	});
});
</script>
<style>
#halloween_month{
    width: 101px
}
#halloween_year{
    width: 80px
}    
.wedding-dress-S2{
    width: 98%;
    margin: 0px auto;
    border-collapse: collapse;
}
.wedding-dress-S2 tr th{
    text-align: center;
    padding: 3px;
    border: 1px solid #CDCDCD;
    color: #FFFFFF;
    background: #428BCA;
}
.wedding-dress-S2 tr td{
    padding: 3px 10px;
    border: 1px solid #CDCDCD;
}
</style>
<?php //$this->load->view("partial/footer"); ?>