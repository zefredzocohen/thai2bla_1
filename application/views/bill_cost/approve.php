<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<?php
$this->load->library('Receiving_lib');
$receiving_id = $this->uri->segment(3);
$id = $this->uri->segment(4);

$id_edit = $this->uri->segment(5);

$taxe_percent = $this->uri->segment(6);
?>
<fieldset id="info_order">
    <?php $info_emp = $this->Employee->get_info($info_receiving->employee_id); ?>
    <legend>Thông tin hóa đơn nhập hàng</legend>
    <p>Mã hóa đơn: <?php echo $receiving_id; ?></p>
    <p>Người tạo hóa đơn: <?= $info_emp->first_name . " " . $info_emp->last_name; ?></p>
    <p>Ngày tháng: <?= date("d-m-Y H:i:s"); ?></p>
    <p>Ghi chú: <?php echo $info_receiving->comment ?></p>

    <p>Kho nhận : <font color='red'><?= $info_receiving->inventory_id == 0 ? "Kho tổng" : $this->Create_invetory->get_info($info_receiving->inventory_id)->name_inventory; ?></font></p>
</fieldset>
<fieldset id="info_order">
    <legend>Danh sách mặt hàng đã nhập</legend>
     <?php
        $this->load->model('Bill_cost_model');
        $stt = 1;
        $total_quan = 0;
        $total_money = 0;
        $total_dis = 0;
        if ($info_receiving_item != null) {
            foreach ($info_receiving_item as $val) {
                if ($val['receiving_id'] == $receiving_id) {
                    $item_name = $this->Item->get_info($val['item_id'])->name;
                    $unit = $this->Item->get_info($val['item_id'])->unit;
                    $unit_name = $this->Unit->get_info($unit)->name;
            $money = $val['quantity_purchased'] * ($val['item_unit_price'] - ($val['item_unit_price'] * $val['discount_percent'] / 100));
            $total_money += $val['quantity_purchased'] * ($val['item_unit_price'] - ($val['item_unit_price'] * $val['discount_percent'] / 100));
                }
            }
        }
            ?>
    <table id="table_export_item">
        <tr>
            <th>STT</th>
            <th>Mã MH</th>
            <th>Tên MH</th>
            <th>ĐVT</th>
            <th>Đơn giá</th>
            <th>Số lượng</th>
            <th>Tiền hàng</th>
            <th>Chi phí</th>
        </tr>
        <?php
        $this->load->model('Bill_cost_model');
        $stt = 1;
        $total_quan = 0;
        $total_dis = 0;
        if ($info_receiving_item != null) {
            foreach ($info_receiving_item as $val) {
                if ($val['receiving_id'] == $receiving_id) {
                    $item_name = $this->Item->get_info($val['item_id'])->name;
                    $unit = $this->Item->get_info($val['item_id'])->unit;
                    $unit_name = $this->Unit->get_info($unit)->name;
                    ?>
                    <tr>
                        <td style="width: 5%; text-align: center"><?php echo $stt++; ?></td>
                        <td style="width: 10%; text-align: center"><?php echo $val['item_id'] ?></td>
                        <td style="width: 37%"><?php echo $item_name; ?></td>
                        <td style="width: 8%; text-align: left"><?php echo $unit_name; ?></td>
                        <td style=" text-align: right"><?php echo number_format($val['item_unit_price']) ?></td>
                        <td style="width: 10%; text-align: right"><?php echo number_format($val['quantity_purchased']) ?></td>
            <?php
            //giá.. = so luong * ( giá - (giá * ck % / 100 ) )
            $money = $val['quantity_purchased'] * ($val['item_unit_price'] - ($val['item_unit_price'] * $val['discount_percent'] / 100));
            ?>
                        <td style="width: 10%; text-align: right"><?php echo number_format($money); ?></td>
                        <?php
                        if ($id == 1) {
                            $cost_money = ($money / $total_money) * $id_edit;
                        } else {
                            $cost_money = ($money / $total_money) * $this->Bill_cost_model->get_info($id)->money;
                        }
                        ?>
                        <td style="width: 10%; text-align: right"><?php echo number_format($cost_money) ?></td>
                    </tr>   
            <?php
        }
    }
}
?>


        <tr>
<?php
if ($id == 1) {
    $cost = $id_edit;
} else {
    $cost = $this->Bill_cost_model->get_info($id)->money;
}
?>
            <td colspan="8">Chi phí: <?php echo number_format($cost); ?></td>
        </tr>
        <tr>
            <td colspan="8">Tổng thuế: 
<?php
if ($id == 1) {
    $taxes_total = ($cost * $taxe_percent) / 100;
    echo number_format($taxes_total);
} else {
    $taxes_total = ($cost * $this->Bill_cost_model->get_info($id)->taxe_percent) / 100;
    echo number_format($taxes_total);
}
?>
            </td>
        </tr>
        <tr>
            <td colspan="8">Tổng thanh toán: 
<?php
echo number_format($cost + $taxes_total);
?>
            </td>
        </tr>
    </table>
</fieldset>

<script>
    $(document).ready(function () {
        setTimeout(function () {
            $(":input:visible:first", "#approve_form").focus();
        }, 100);
        var submitting = false;
        $('#approve_form').validate({
            submitHandler: function (form) {
                if (submitting)
                    return;
                submitting = true;
                $(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
                $(form).ajaxSubmit({
                    success: function (response) {
                        submitting = false;
                        tb_remove();
                        post_receiving_form_submit(response);
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
    #info_order{
        width: 50%;
        margin: 0px auto;
    }
    #table_export_item{
        border-collapse: collapse;
        width: 100%;
        margin: 0px auto;
        font-size: 12px;
    }
    #table_export_item tr th{
        border: 1px solid #999999;
        padding: 3px 0px;
        background: #158ca0 ;
        color: #FFFFFF;
        text-align: center;
    }
    #table_export_item tr td{
        border: 1px solid #999999;
        padding: 3px 5px;
    }
</style>