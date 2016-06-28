<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
    <div id="content_area">
<style>
#price, #tk_no, #depreciat_month{
    border: none;
}

</style>        
<?php echo form_open('assets/save_buy_increase',array('id'=>'assets_form'));
?>
<div id="required_fields_message"><?= lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<fieldset id="supplier_basic_info">
<legend><?= lang("var_information"); ?></legend>
<div class="field_row clearfix">	
<?= form_label(lang('assets_name').':', ' assets_name', array('class'=>'required')); ?>
    <div class='form_field'>
    <?= form_input(array(
            name        => 'assets_name_input',
            id          => 'assets_name_input',
            placeholder => "Nhập tên tài sản.."
    ));?>
    <table id="row_selected" >
    </table>
    </div>
</div>
<div class="field_row clearfix">	
<?= form_label('Nhân viên mua hàng:', 'cost_employees', array('class'=>'')); ?>
    <div class='form_field'>
    <?= form_input(array(
            'name'=>'cost_employees_input',
            'id'=>'cost_employees_input',
            placeholder => "Nhập tên nhân viên.."
    ));?>
    <table id="row_selected8" >
    </table>
    </div>
</div>
<div class="field_row clearfix">	
<?= form_label('Số lượng:', ' quantity', array('class'=>'required')); ?>
    <div class='form_field'>
    <?= form_input(array(
            'name'=>'quantity',
            'id'=>'quantity',
        ));?>
    </div>
</div>
<div class="field_row clearfix">	
<?= form_label('Ngày ghi tăng:', 'date', array('class'=>'')); ?>
    <div class='form_field'>
    <?= form_input(array(
            'name'=>'date',
            'id'=>'date',
        ));?>
    </div>
</div>
<div class="field_row clearfix">	
<?= form_label('Tài khoản có:', ' tk_co', array('class'=>'required')); ?>
    <div class='form_field'>
    <?php 
    $pay_way = array(
        ''  => '-- Chọn hình thức thanh toán --',
        1111   => 'Tiền mặt - 1111', 
        1121   => 'CKNH - 1121'
    );
    echo form_dropdown("tk_co", $pay_way, '', "id=tk_co");?>
    </div>
</div>
<div class="field_row clearfix">	
<?= form_label('Tài khoản nợ:', ' tk_no', array('class'=>'')); ?>
    <div class='form_field'>
    <?= form_input(array(
            'name'=>'tk_no',
            'id'=>'tk_no',
            readonly=>''
        ));?>
    </div>
</div>
<div class="field_row clearfix">	
<?= form_label('Số tháng khấu hao:', 'depreciat_month', array('class'=>'')); ?>
    <div class='form_field'>
    <?= form_input(array(
            'name'=>'depreciat_month',
            'id'=>'depreciat_month',
            readonly=>''
        ));?>
    </div>
</div>
<div class="field_row clearfix">	
<?= form_label('Đơn giá:', ' value', array('class'=>'')); ?>
    <div class='form_field'>
    <?= form_input(array(
            'name'=>'price',
            'id'=>'price',
            readonly=>''
        ));?>
    </div>
</div>



<?= form_submit(array(
    'name'=>'submit',
    'id'=>'submit',
    'value'=>lang('common_submit'),
    'class'=>'submit_button float_right')
);?>
</fieldset>
<?= form_close();?>
</div></div>
<?php $this->load->view("partial/footer"); ?>
<script type='text/javascript'>
$("#cost_employees_input").autocomplete({
    source: '<?php echo site_url("employees/search_suggestions_audi"); ?>',
    delay: 10,
    autoFocus: false,
    minLength: 0,
    select: function (event, ui){
        $("#cost_employees_input").val("");
        if ($("#row_selected8" + ui.item.value).length == 1){
            $("#row_selected8" + ui.item.value).val(parseFloat($("#row_selected" + ui.item.value).val()) + 1);
        }else{
            $('#cost_employees_input').hide();
            $("#row_selected8").append(
                '<tr style="border: none">'
                    +'<td width="20%" style="border: none"><input type=hidden id=cost_employees name=cost_employees value=' + ui.item.value + ' />' + ui.item.label + '</td>'
                    +'<td style="border: none"><a href=# style="text-decoration: underline" onclick="return deleteRow8(this)">Xóa</a></td>'
                +'</tr>'
            );
        }
        return false;
    }
}); 
$("#assets_name_input").autocomplete({
    source: '<?php echo site_url("assets/suggest"); ?>',
    delay: 10,
    autoFocus: false,
    minLength: 0,
    select: function (event, ui){
        $("#assets_name_input").val("");
        if ($("#row_selected" + ui.item.value).length == 1){
            $("#row_selected" + ui.item.value).val(parseFloat($("#row_selected" + ui.item.value).val()) + 1);
        }else{
            $('#assets_name_input').hide();
            $("#row_selected").append(
                '<tr style="border: none">'
                    +'<td width="20%" style="border: none"><input type=hidden id=asset_id name=asset_id value=' + ui.item.value + ' />' + ui.item.label + '</td>'
                    +'<td style="border: none"><a href=# style="text-decoration: underline" onclick="return deleteRow(this)">Xóa</a></td>'
                +'</tr>'
            );
            $('#assets_name_input').val(68);
            $('#depreciat_month').val(ui.item.depreciat_month);
            $('#price').val(ui.item.price);
            $('#tk_no').val(ui.item.tk_no);
        }
        return false;
    }
}); 
function deleteRow8(link){
    $('#cost_employees_input').show();
    $(link).parent().parent().remove();
    return false;
} 
function deleteRow(link){
    $('#assets_name_input').show();
    $('#assets_name_input').val('');
    $(link).parent().parent().remove();
    return false;
} 
    
//$(document).ready(function(){
    setTimeout(function(){$(":input:visible:first","#customer_type_form").focus();},100);
    var submitting = false;
    $('#assets_form').validate({
//        submitHandler:function(form){
//            if (submitting) return;
//            submitting = true;
//            $(form).mask(<?= json_encode(lang('common_wait')); ?>);
//            $(form).ajaxSubmit({
//                success:function(response)
//                {
//                        submitting = false;
//                        tb_remove();
//                        post_type_cus_form_submit(response);
//                },
//                dataType:'json'
//            });
//        },
        errorLabelContainer: "#error_message_box",
        wrapper: "li",
        rules: {
            assets_name_input: 'required',
            quantity: 'required',
            tk_co: 'required'
        },
        messages: {
            assets_name_input: 'Bạn chưa nhập tên nhân tài sản',
            quantity: 'Bạn chưa điền số lượng',
            tk_co: 'Bạn cần chọn hình thức thanh toán'
        }
    });
//});
</script>