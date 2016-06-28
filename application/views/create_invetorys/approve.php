<?= form_open("create_invetorys/save_approve/$export_store_id", array('id' => 'approve'));?>
<fieldset id="info_order">
    <?php $info_emp = $this->Employee->get_info($info_export_store->employee_id);?>
    <legend>Thông tin hóa đơn xuất kho</legend>
    <p>Mã hóa đơn: <?= $export_store_id; ?></p>
    <p>Người tạo hóa đơn: <?= $info_emp->first_name." ".$info_emp->last_name;?></p>
    <p>Ngày tháng: <?= date("d-m-Y H:i:s", strtotime($info_export_store->date_export)); ?></p>
    <p>Kho: <?php echo ($info_export_store->store_id == 0 ? "Kho tổng" : $this->Create_invetory->get_info($info_export_store->store_id)->name_inventory); ?></p>
    <p>Ghi chú: <?= $info_export_store->comment; ?></p>
</fieldset>
<fieldset>
    <legend>Danh sách mặt hàng xuất kho</legend>
    <table id="table_export_item">
        <tr>
            <th>STT</th>
            <th>Mã MH</th>
            <th>Tên MH</th>
            <th>ĐVT</th>
            <th>Số lượng</th>
            <th>Giá vốn</th>
            <th>Thành tiền</th>
        </tr>
        <?php
        $total_quantity = 0;
        $total_money = 0;
        foreach ($info_export_store_item as $key=>$val){
            $info_item = $this->Item->get_info($val->item_id);
            $unit = $this->Unit->get_info($val->unit_export);
            $total_quantity += $val->quantity_export;
            $total_money += $val->quantity_export * $val->cost_price_export;
        ?>
        <tr>
            <td style="width: 5%; text-align: center"><?= ($key + 1); ?></td>
            <td style="width: 10%; text-align: center"><?= $info_item->item_number; ?></td>
            <td style="width: 37%"><?= $info_item->name; ?></td>
            <td style="width: 10%;"><?= $unit->name; ?></td>
            <td style="width: 8%; text-align: right"><?= format_quantity($val->quantity_export); ?></td>
            <td style="width: 10%; text-align: right"><?= format_quantity($val->cost_price_export); ?></td>
            <td style="width: 10%; text-align: right"><?= number_format($val->quantity_export * $val->cost_price_export);?></td>
        </tr>        
        <?php
        }
        ?>
        <tr>
            <td colspan="4" style="text-align: right; font-weight: bold">Tổng</td>
            <td style="width: 10%; text-align: right"><?= format_quantity($total_quantity); ?></td>
            <td style="width: 10%;"></td>
            <td style="width: 10%; text-align: right"><?= number_format($total_money); ?></td>
        </tr>
    </table>   
    <?php echo form_submit(array(
        'name' => 'submit',
        'id' => 'submit',
        'value' => lang('common_submit'),
        'class' => 'submit_button float_right',
        'style' => "float: right; margin-right: 20px;",
    ));?>
</fieldset>
</form>
<script>
$(document).ready(function(){
    setTimeout(function () {
        $(":input:visible:first", "#approve").focus();
    }, 100);
    var submitting = false;
    $('#approve').validate({
        submitHandler: function (form){
            if (submitting)
                return;
            submitting = true;
            $(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
            $(form).ajaxSubmit({
                success: function (response){
                    submitting = false;
                    tb_remove();
                    post_inventory_form_submit(response);
                },
                dataType: 'json'
            });
        }
    });
});
</script>
<style>  
    #info_order p{
        padding-left: 10px;
        font-size: 14px;
    }
    #table_export_item{
        border-collapse: collapse;
        width: 95%;
        margin: 0px auto;
    }
    #table_export_item tr th{
        border: 1px solid #999999;
        padding: 3px 0px;
        background: #666666;
        color: #FFFFFF;
        text-align: center;
    }
    #table_export_item tr td{
        border: 1px solid #999999;
        padding: 3px 5px;
    }
</style>