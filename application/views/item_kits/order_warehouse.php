<html>
    <head>
        <meta charset='utf-8'>
        <title>Phiếu nhập kho thành phẩm</title>
    </head>
    <body>
        <div id="content_order">
            <p><?php echo $this->config->item('company'); ?></p>
            <div style='text-align: center; text-transform: uppercase;font-weight: bold;'>Phiếu nhập kho thành phẩm</div>
            <em style="font-weight: 600; margin-left: 300px">
                <?php $HallOweeN_NighT = strtotime($inventory_product->row()->trans_date);?>
                Ngày <?= date('d', $HallOweeN_NighT) ?>
                tháng <?= date('m', $HallOweeN_NighT) ?>
                năm <?= date('Y', $HallOweeN_NighT) ?>
            </em>
            <p>Số phiếu: <span style="color: red"><?= $import_product_id ?></span></p>
            <p>Bên giao: Bộ phận sản xuất</p>
            <p>Bên nhận: Kho thành phẩm</p>
            <table id="table_order">
                <tr>
                    <th style="width: 5%">STT</th>
                    <th style="width: 40%">Tên thành phẩm</th>
                    <th style="width: 15%">Số lượng</th>
                    <th style="width: 20%">Đơn giá</th>
                    <th>Thành tiền</th>
                </tr>
                <?php $total_money = 0;
                foreach ($inventory_product->result() as $key => $AEON) {
                    $money_total = $request_production_Christmas->total_money_norms 
                                    + $processes_cost_labor->money_labor 
                                    + $processes_cost_machine->money_machine 
                                    + $processes_cost_outsource->money_outsource 
                                    + $processes_cost_other->money_other;
                    $price = $money_total / $inventory_product_row->quantity;
                    $total_money += $price * $AEON->trans_inventory;
                    ?>
                    <tr>
                        <td style="text-align: center;"><?= $key+1 ?></td>
                        <td style=""><?= $this->Item->get_info($AEON->trans_items)->name ?></td>
                        <td style="text-align: right;"><?= $AEON->trans_inventory ?></td>
                        <td style="text-align: right;"><?= number_format($price, 2) ?></td>
                        <td style="text-align: right;">
                            <?= number_format($price * $AEON->trans_inventory, 2) ?>
                        </td>
                    </tr>
                <?php
                }?>    
                <tr>
                    <td colspan="4" style="text-align: right; font-weight: 600">Tổng tiền</td>
                    <td style="text-align: right;"><?= number_format($total_money, 2) ?></td>
                
                </tr>                    
            </table>	
            <div style="text-align: right; width: 100%; font-style: italic;"> 
                <p style="margin-right: 20px">Ngày ... tháng ... năm ...</p>
            </div> 
            <div id="info_employee">
                <table>
                    <tr>
                        <th>Người lập phiếu</th>
                        <th>Người nhận</th>
                        <th>Nhân viên xuất kho</th>
                        <th>Kế toán trưởng</th>
                    </tr>
                    <tr>
                        <td style="font-style: italic;">(Ký, họ tên)</td>
                        <td style="font-style: italic;">(Ký, họ tên)</td>
                        <td style="font-style: italic;">(Ký, họ tên)</td>
                        <td style="font-style: italic;">(Ký, họ tên)</td>
                    </tr>
                </table>
            </div>
            <div style="clear: both"></div>
            <a href="<?= $number == 6 
                    ? site_url().'item_kits/follow_bom/'.$item_kit_id
                    : site_url().'item_kits/import_product' ?>" 
                id="submit" class="print_report" style="width:100px; text-align: center; margin-left: 8px"  
                onclick = "this.style.display = 'none'; window.print();">In phiếu</a>
        </div>	
    </body>
</html>
<style>
#table_order tr td{
    padding: 2 7px
}
#info_employee table{
    width: 100%;
}
#info_employee table th,#info_employee table td{
    width: 25%;
    text-align: center;
}
#info_employee table td{
    padding: 0px 0px 80px 0px;
}
.print_report{
    background: none repeat scroll 0 0 #1E5A96;
    border: 1px solid #EEEEEE;
    color: #FFFFFF;
    font-size: 14px;
    font-weight: bold;
    line-height: 30px;
    padding: 5px;
}
#content_order{
    width: 800px;
    margin: 0px auto;
}
#table_order{
    border-collapse: collapse;
    width: 100%;
}
#table_order th, #table_order td{
    border: 1px solid #CCCCCC;
}
</style>