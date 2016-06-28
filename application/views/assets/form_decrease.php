<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
    <div id="content_area">
<?php echo form_open('assets/save_decrease',array('id'=>'assets_form'));
?>
<div id="required_fields_message"><?= lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<fieldset id="supplier_basic_info">
<legend><?= lang("var_information"); ?></legend>
<?= form_input(array(
    name    => 'thoi_han',
    id      => 'thoi_han',
    type    => hidden
))?>
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
<?= form_label('Số lượng:', ' quantity', array('class'=>'required')); ?>
    <div class='form_field'>
    <?= form_input(array(
            'name'=>'quantity',
            'id'=>'quantity',
        ));?>
    </div>
</div>
<div class="field_row clearfix">	
<?= form_label('Ngày ghi giảm:', 'date', array('class'=>'')); ?>
    <div class='form_field'>
    <?= form_input(array(
            'name'=>'date',
            'id'=>'date',
        ));?>
    </div>
</div><br>
<table class="table_order" style="width: 80%; border: 1px solid">
    <tr>    
        <th>Mã tài sản</th>
        <th>Tên tài sản</th>
        <th>Tài khoản nợ</th>
        <th>Tài khoản có</th>
        <th>Số tiền</th>
    </tr>
    
</table>
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
$('.table_order').hide();    
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
                    +'<td style="border: none; width=20%">'
                        +'<input type=hidden id=asset_id name=asset_id value=' + ui.item.value + ' />' 
                        + ui.item.label 
                    + '</td>'
                    +'<td style="border: none"><a href=# style="text-decoration: underline" onclick="return deleteRow(this)">Xóa</a></td>'
                +'</tr>'
            );
            $('#assets_name_input').val(68);
            $('#han_kh').val(ui.item.han_kh);
            $('#date_now').val(ui.item.date_now);
            if(ui.item.han_kh > ui.item.date_now){
                $('#thoi_han').val(1);
                //alert('chua het');
                
                $('.table_order').show(); 
                $(".table_order").append(
                    '<tr id=asset_tr1>'
                        +'<td>'
                            +'<input type=hidden id=asset_id name=asset_id1 />' + ui.item.asset_number 
                        + '</td>'
                        +'<td>' +ui.item.label
                        + '</td>'
                        +'<td>'
                            +'<input id=tk_no name=tk_no1 value=2141 readonly />'
                        + '</td>'
                        +'<td>'
                            +'<input id=tk_co name=tk_co1 value='+ui.item.tk_co+' readonly />'
                        + '</td>'
                        +'<td>'
                            +'<input id=asset_money name=asset_money1 value='+ui.item.asset_money.toFixed(2)+' readonly />'
                        + '</td>'
                    +'</tr>'
                    +'<tr id=asset_tr2>'
                        +'<td>'
                            +'<input type=hidden id=asset_id name=asset_id2 />' + ui.item.asset_number 
                        + '</td>'
                        +'<td>' +ui.item.label
                        + '</td>'
                        +'<td>'
                            +'<input id=tk_no name=tk_no2 value=811 readonly />'
                        + '</td>'
                        +'<td>'
                            +'<input id=tk_co name=tk_co2 value='+ui.item.tk_co+' readonly />'
                        + '</td>'
                        +'<td>'
                            +'<input id=asset_money name=asset_money2 value='+ui.item.asset_money_remain.toFixed(2)+' readonly />'
                        + '</td>'
                    +'</tr>'
                );
                
            }else{
                $('#thoi_han').val(0);
                //alert('het');                
                $('.table_order').hide(); 
                
                
                
            }
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
    $('#asset_tr1').remove();
    $('#asset_tr2').remove();
    $('.table_order').hide();
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
<style>
.table_order tr td, .table_order tr th{
    padding: 3px 5px 
}     
.table_order{
    border-collapse: collapse;
    width: 100%;
}
.table_order tr th{
    background: #e8e8e8;
}
.table_order th, .table_order td{
    border: 1px solid #CCCCCC;
}    
#tk_no, #tk_co, #asset_money{
    border: 0px;
    text-align: center
}
</style>