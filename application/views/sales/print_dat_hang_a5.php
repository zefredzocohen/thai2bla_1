<meta http-equiv="content-type" content="text/html; charset=utf-8" />

<style>
    #flip,.topheader,.header,.control,#gn-menu-header,#gn-menu{
        display: none;
    }
    #register_container{
        width: 100%;
        margin: 0px;
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
</style>
<div id="print_a5" style="width: 793px; display: block; overflow: hidden; position: relative; font-size: 12px; ">
    <div id="header_order" style="position: relative; width: 100%;">
        <div id="logo_print"  style="width: 150px; float: left; text-align: center;">
            <?php echo img(array('src' => $this->Appconfig->get_logo_image())); ?>
        </div>
        <div id="info_company" style=" width: 480px; float: left;">
            <table style="border-collapse: collapse">
                <tr>
                    <td colspan="2" style="padding: 2px 0px;">
                        <p style="text-transform: uppercase;  font-weight: bold; color: #002FC2;"><?php echo $this->config->item('company'); ?></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding: 2px 0px;"><p style='color: #002FC2'><?php echo $this->config->item('address'); ?></p></td>
                </tr>
                <tr>
                    <td style="padding: 2px 0px;">Điện thoại: <span style='color: #002FC2'><?php echo $this->config->item('phone'); ?></span></td>
                    <td style="padding: 2px 0px;">Fax: <span style='color: #002FC2'><?php echo $this->config->item('fax'); ?></span></td>
                </tr>
            </table>
        </div>
        <div id="info_order" style="float: right; width: 155px;">
            <p style="line-height: 25px;">Số: <span style='color: #D50018; font-weight: bold'><?php echo $sale_id; ?></span></p>
            <p style="line-height: 25px;">Ngày: <span style='color: #002FC2'><?php echo date('d-m-Y',  strtotime($transaction_time)); ?></span></p>
        </div>
        <div style="clear: both"></div>
    </div>
    <div id="title_order" style="width: 100%;text-align: center; text-transform: uppercase;font-weight: bold;font-size: 16px;margin-top: 12px;margin-bottom: 10px;">Hóa đơn đặt hàng</div>
    <div id="info_customer" style="display: block;overflow: hidden;padding-left: 10px;">
        <p style="line-height: 20px">Họ tên người đặt hàng: <span style="color:#002FC2"><?php echo (isset($customer) ? $customer : "KHÁCH LẺ"); ?></span></p>
        <?php if ($cus_name != "") { ?>
            <p style="line-height: 20px">Tên đơn vị: <span style="text-transform: uppercase;color:#002FC2"><?php echo $cus_name; ?></span></p>
            <p style="line-height: 20px">Địa chỉ: <span style="color:#002FC2"><?php echo $address; ?></span></p>
        <?php } ?>
        <p>Ghi chú: <span class="color"><?php echo (isset($comment) ? $comment : ""); ?></span></p>
        <?php $info_warehouse = $this->Create_invetory->get_info($store); ?>
        <p>Kho: <?= $info_warehouse->name_inventory; ?></p>
        <p>Địa chỉ kho: <?= $info_warehouse->address; ?></p>
    </div>
    <div id="content_order" style="margin-top: 10px;">
        <table id="table_items" style="width: 99%; border-collapse: collapse; font-size: 12px; margin: 0px auto;">
            <tr>
                <th style="border: 1px solid #000000; padding: 3px;">STT</th>
                <th style="border: 1px solid #000000; padding: 3px;">Mã MH</th>
                <th style="border: 1px solid #000000; padding: 3px;">Tên HH, DV</th>
                <th style="border: 1px solid #000000; padding: 3px;">ĐVT</th>
                <th style="border: 1px solid #000000; padding: 3px;">SL</th>
                <th style="border: 1px solid #000000; padding: 3px;">Đơn giá</th>                
                <th style="border: 1px solid #000000; padding: 3px;">Chiết khấu (%)</th>
                <th style="border: 1px solid #000000; padding: 3px;">Thuế (%)</th>
                <th style="border: 1px solid #000000; padding: 3px;">Thành tiền</th>
            </tr>
            <?php
            $k = 1;
            $total_taxes_percent = 0;
            foreach (array_reverse($cart, true) as $line => $item) {
                if ($item['unit'] == 'unit') {
                    $total_taxes_percent += $item['taxes'] * ($item['price'] * $item['quantity'] - $item['discount'] * $item['price'] * $item['quantity'] / 100) / 100;
                } else {
                    $total_taxes_percent += $item['taxes'] * ($item['price_rate'] * $item['quantity'] - $item['discount'] * $item['price_rate'] * $item['quantity'] / 100) / 100;
                }
                if ($item['item_id']) {
                    $term = $this->Item->get_info($item['item_id']);
                    if ($item['unit'] == 'unit') {
                        $unit_name = $this->Unit->get_info($term->unit);
                    } else {
                        $unit_name = $this->Unit->get_info($term->unit_from);
                    }
                    $number_code = $term->item_number;
                } else {
                    $term = $this->Item_kit->get_info($item['item_kit_id']);
                    $unit_name = $this->Unit->get_info($term->unit);
                    $number_code = $term->item_kit_number;
                }

                if ($item['pack_id']) {
                    $term = $this->Pack->get_info($item['pack_id']);
                    $unit_name = $this->Unit->get_info($term->unit);
                }
                ?>
                <tr>
                    <td style="text-align: center; width: 5%; border: 1px solid #000000; padding: 3px;">
    <?php echo $k; ?>
                    </td>
                    <td style="text-align: center; width: 5%; border: 1px solid #000000; padding: 3px;"><?php echo $number_code; ?></td>
                    <td style="text-align: left; padding-left: 10px;  width: 23%;border: 1px solid #000000; padding: 3px;">
    <?php echo $item['name']; ?>
                    </td>
                    <td style="text-align: right; padding-right: 5px; width: 14%;border: 1px solid #000000; padding: 3px;">
    <?php echo $unit_name->name; ?>                        
                    </td>
                    <td style="text-align: right; padding-right: 5px; width: 9%;border: 1px solid #000000; padding: 3px;">
    <?php echo $item['quantity']; ?>                        
                    </td>
                    <td style="text-align: right; padding-right: 5px; width: 8%;border: 1px solid #000000; padding: 3px;">
    <?php
    if ($item['unit'] == "unit") {
        echo to_currency_unVND_nomar($item['price']);
    } else {
        echo to_currency_unVND_nomar($item['price_rate']);
    }
    ?>
                    </td>
                    <td style="text-align: right; padding-right: 5px; width: 13%;border: 1px solid #000000; padding: 3px;">
                        <?php echo to_currency_unVND_nomar($item['discount']); ?>
                    </td>
                    <td style="text-align: right; padding-right: 5px; width: 9%;border: 1px solid #000000; padding: 3px;">
                        <?php echo $item['taxes']; ?>
                    </td>
                    <td style="text-align: right; padding-right: 5px; width:19%;border: 1px solid #000000; padding: 3px;">
                        <?php
                        if ($item['unit'] == "unit") {
                            echo to_currency_unVND_nomar($item['price'] * $item['quantity'] - (($item['discount'] * $item['price'] * $item['quantity']) / 100));
                        } else {
                            echo to_currency_unVND_nomar($item['price_rate'] * $item['quantity'] - (($item['discount'] * $item['price_rate'] * $item['quantity']) / 100));
                        }
                        ?>
                    </td>
                </tr>
                <?php
                $k ++;
            }
            ?>
        </table>
        <?php
        $total_discount_money = 0;
        $total_payment = 0;
        foreach ($payments as $payment) {
            $total_payment += $payment['payment_amount'];
            $total_discount_money += $payment['discount_money'];
        }
        ?>
        <table id="total_order" style="width: 99%; border-collapse: collapse; font-size: 12px; margin: 0px auto;">
            <tr>
                <td style="width: 130px;border-left: 1px solid #000000; border-bottom: 1px dotted #000000"><b>Số tiền đã đặt:</b></td>
                <td style="border-bottom: 1px dotted #000000"><b><?php echo to_currency_unVND_nomar($total_payment); ?></b></td>
                <td style="text-align: right; padding: 5px;border-bottom: 1px dotted #000000"><b>Tổng tiền hàng:</b></td>
                <td style="text-align: right; padding-right: 5px; border-right:1px solid #000000; border-bottom: 1px dotted #000000"><?php echo to_currency_unVND_nomar($total_order) ?></td>
            </tr>
            <tr>
                <td style="width: 130px;border-left: 1px solid #000000; border-bottom: 1px dotted #000000"></td>
                <td style="border-bottom: 1px dotted #000000"></td>
                <td style="text-align: right; padding-right: 5px; border-bottom: 1px dotted #000000"><b>Tổng thuế:</b></td>
                <td style="text-align: right; padding-right: 5px; border-right:1px solid #000000; border-bottom: 1px dotted #000000"><?php echo to_currency_unVND_nomar($total_taxes_percent) ?></td>
            </tr>
            <tr>
                <td style="border-left: 1px solid #000000; border-bottom: 1px dotted #000000"></td>
                <td style="border-bottom: 1px dotted #000000"></td>                
                <td style="text-align: right; padding-right: 5px; border-bottom: 1px dotted #000000"><b>Chiết khấu đơn hàng:</b></td>
                <td style="text-align: right; padding-right: 5px; border-right:1px solid #000000; border-bottom: 1px dotted #000000"><?php echo to_currency_unVND_nomar($total_discount_money); ?></td>
            </tr>
            <tr>
                <td style="border-left: 1px solid #000000; border-bottom: 1px solid #000000"></td>
                <td style="border-bottom: 1px solid #000000"></td>
                <td style="text-align: right; padding-right: 5px; border-bottom: 1px solid #000000"><b>Tổng cộng tiền thanh toán:</b></td>
                <td style="text-align: right; padding-right: 5px; border-right:1px solid #000000; border-bottom: 1px solid #000000"><?php echo to_currency_unVND_nomar($total_order - $total_discount_money + $total_taxes_percent) ?></td>
            </tr>
        </table>
    </div>
    <div id="text_money" style=" margin-top: 5px; padding: 5px;">
        <?php $this->load->model("Cost"); ?>
        Số tiền đã đặt: <span class="color" style="font-style: italic; font-weight: bold">(Bằng chữ: <?php echo $this->Cost->get_string_number(to_un_currency($total_payment)); ?>)</span>
    </div>
    <div id="info_employee">
        <table>
            <tr>
                <th>Khách hàng</th>
                <th>Nhân viên bán hàng</th>
            </tr>
            <tr>
                <td style="font-style: italic; padding: 0px 0px 70px 0px; text-align: center">(Ký, ghi rõ họ tên)</td>
                <td style="font-style: italic; padding: 0px 0px 70px 0px;  text-align: center">(Ký, ghi rõ họ tên)</td>
            </tr>
        </table>
    </div>
    <div style="text-align: center; width: 100%; font-style: italic; position: absolute; bottom: 0px;">(Cần kiểm tra đối chiếu khi lập, giao, nhận hàng hóa)</div>
</div>
<div style="width: 793px; margin: 10px 0; text-align: right;">
    <a href = "<?= site_url() . '/sales' ?>" id="submit" style="width:100px; text-align: center;" class="print_report" onclick = "this.style.display = 'none';
            window.print();">In hóa đơn</a>
</div>

