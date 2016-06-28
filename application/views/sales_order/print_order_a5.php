<meta http-equiv="content-type" content="text/html; charset=utf-8" />


<style>
    body{
        padding: 0;
        margin: 0;
    }
    #print_a5{
        width: 797px;        
        display: block;
        overflow: hidden;       
        position: relative;
        margin-left: 10px;
        font-size: 12px;
    }
    #header_order{
        position: relative;
        width: 100%;
    }
    #logo_print{
        width: 150px;
        float: left;
        text-align: center;
    }
    #info_company{
        width: 500px;
        float: left;
    }
    #info_company tr td{
        font-size: 12px;
    }
    #info_order{
        float: right;
        width: 143px;
    }
    #info_order p{
        line-height: 6px;
    }
    #title_order{
        width: 100%;
        text-align: center;
        text-transform: uppercase;
        font-weight: bold;
        font-size: 16px;
        margin-top: 12px;
    }
    .color{
        color: #002FC2;
    }
    #table_items, #total_order{
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }
    #table_items th{
        border: 1px solid #000000;
        padding: 3px;
    }
    #table_items tr td{
        border: 1px solid #000000;       
        padding: 3px;
    }
    #total_order tr td{
        padding: 3px;        
        border-bottom: 1px dotted #000000;
    }
    #total_order tr td:first-child{
        border-left: 1px solid #000000;
    }
    #total_order tr td:last-child{
        border-right: 1px solid #000000;
    }
    #total_order tr:last-child td{
        border-bottom: 1px solid #000000;
    }
    #info_employee table{
        width: 100%;
    }
    #info_employee table th,#info_employee table td{
        width: 33%;
        text-align: center;
    }
    #info_employee table td{
        padding: 0px 0px 80px 0px;
    }
    #info_customer{
        display: block;
        overflow: hidden;
        padding-left: 10px;
    }
    #info_customer p{
        line-height: 6px;
    }
    #text_money{
        margin-top: 5px;
        padding: 5px;
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
<?php $this->load->model('item');
$this->load->model('unit');
?>
<div id="print_a5">
    <div id="header_order">
        <div id="logo_print">
<?php echo img(array('src' => $this->Appconfig->get_logo_image())); ?>
        </div>
        <div id="info_company">
            <table style="width: 100%">
                <tr>
                    <td colspan="2">
                        <span style="text-transform: uppercase;  font-weight: bold; color: #002FC2;">
<?php echo $this->config->item('company'); ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><span style='color: #002FC2'><?php echo $this->config->item('address'); ?></span></td>
                </tr>
                <tr>
                    <td style="width: 70%;">Điện thoại: <span style='color: #002FC2'><?php echo $this->config->item('phone'); ?></span></td>
                    <td style="width: 30%;">Fax: <span style='color: #002FC2'><?php echo $this->config->item('fax'); ?></span></td>
                </tr>
            </table>
        </div>
        <div id="info_order">
            <p>Số: <span style='color: #D50018; font-weight: bold'><?php echo $sale_id; ?></span></p>
            <p>Ngày: <span style='color: #002FC2'><?php echo date("d-m-Y H:i:s"); ?></span></p>
        </div>
        <div style="clear: both"></div>
    </div>
    <div id="title_order">
        <?php
        if ($info_sale->suspended == 1) {
            echo "HÓA ĐƠN GHI NỢ";
        } elseif ($info_sale->liability == 1) {
            echo 'HÓA ĐƠN ĐẶT HÀNG';
        } elseif ($info_sale->materials == 1) {
            echo 'HÓA ĐƠN BÁO GIÁ';
        } elseif ($info_sale->later_cost_price < 0) {
            echo "HÓA ĐƠN TRẢ HÀNG";
        } else {
            echo "HÓA ĐƠN BÁN HÀNG";
        }
        ?>
    </div>
    <div id="info_customer">
        <?php
        if ($info_sale->customer_id == NULL) {
            $cus_name = "KHÁCH LẺ";
        } else {
            $cus_name = $this->Customer->get_info($info_sale->customer_id)->first_name . ' ' . $cus_name = $this->Customer->get_info($info_sale->customer_id)->last_name;
        }
        ?>
        <p>Họ tên khách hàng: <span class="color"><?= $cus_name; ?></span></p>

        <p>Địa chỉ: <span class="color"><?= $address1; ?></span></p>

        <p>Ghi chú: <span class="color"></span></p>
        <?php
        $cus_emp = $this->Employee->get_info($info_sale->employee_id)->first_name . ' ' . $cus_emp = $this->Employee->get_info($info_sale->employee_id)->last_name;
        ?>
        <p>Nhân viên bán hàng: <span class="color">
<?= $cus_emp; ?>
            </span></p>

    </div>
    <div id="content_order">
        <table id="table_items">
            <tr>
                <th>STT</th>
                <th>Mã MH</th>
                <th>Tên HH, DV</th>
                <th>ĐVT</th>
                <th>SL</th>
                <th>Đơn giá</th>                
                <th>Chiết khấu (%)</th>
                <th>Thuế (%)</th>
                <th>Thành tiền</th>
            </tr>
            <?php
            //số tiền khách thanh toán
            $this->load->model('Sale');
            $payment = 0;
            $discount_money = 0;
            $pay = $this->Sale->pay_amount_order();
            foreach ($pay as $value) {
                if ($sale_id == $value['id_sale']) {
                    $payment = $value['pays_amount'];
                    $discount_money = $value['discount_money'];
                }
            }

            //cac mat hang trong hóa đơn
            $stt = 1;
            $total_quantity = 0;
            $total_discount = 0;
            $total_money = 0;
            $total_tax = 0;
            $tt = 0;
            $taxs = 0;
     if($this->Sale->get_info($sale_id)->row()->sale_status == 0){
            $get_taxes_item = $this->Sale->get_taxes_item();
            if ($info_sale_item != null):
                foreach ($info_sale_item as $key => $val):
                    if ($sale_id == $val['sale_id']):
                        foreach ($get_taxes_item as $get_value):
                            if ($val['item_id'] == $get_value['item_id']):
                                if ($val['unit_item'] == $get_value['unit_from']) {
                                    $item_price = $val['item_unit_price_rate'];
                                } else {
                                    $item_price = $val['item_unit_price'];
                                }
                                $total_tax = ($item_price * $val['quantity_purchased'] - $item_price * $val['quantity_purchased'] * $val['discount_percent'] / 100) * $val['taxes_percent'] / 100;
                                ?>

                                <tr>
                                    <td style="text-align: center; width: 5%"><?= $stt++; ?></td>
                                    <td style="text-align: center; width: 5%"><?= $this->Item->get_info($val['item_id'])->item_number; ?></td>
                                    <?php
                                    if ($val['unit_item'] == $get_value['unit_from']) {
                                        $item_unit = $get_value['unit_from'];
                                    } else {
                                        $item_unit = $get_value['unit'];
                                    }
                                    ?>
                                    <td style="text-align: left; padding-left: 10px; width: 35%"><?= $this->Item->get_info($val['item_id'])->name; ?></td>
                                    <td style="text-align: center; padding-right: 5px; width: 8%"><?= $this->Unit->get_info($item_unit)->name; ?></td>
                                    <td style="text-align: right; padding-right: 5px; width: 5%"><?= number_format($val['quantity_purchased']); ?></td>
                                    <td style="text-align: right; padding-right: 5px; width: 10%">
                    <?= number_format($val['item_unit_price']); ?>
                                    </td>
                                    <td style="text-align: right; padding-right: 5px; width: 10%"><?= $val['discount_percent']; ?></td>
                                    <td style="text-align: right; padding-right: 5px; width: 10%"><?= $val['taxes_percent']; ?></td>
                                    <td style="text-align: right; padding-right: 5px; width: 12%"><?= number_format($val['quantity_purchased'] * ($val['item_unit_price'] - ($val['item_unit_price'] * $val['discount_percent'] / 100))); ?></td>
                                </tr>
                                <?php
                                $total_quantity += $val['quantity_purchased'];
                                $total_discount += $val['discount_percent'];
                                $total_money += $val['quantity_purchased'] * ($item_price - ($item_price * $val['discount_percent'] / 100));
                                $tt += $total_tax;
                                $taxs += $get_value['taxes'];
                            endif;
                        endforeach;
                    endif;
                endforeach;
            endif;
             }else{
                $sale_all_pack = $this->Sale->all_sales_pack($sale_id);
                foreach ($sale_all_pack as $pack){
            ?>
                                <tr>
                                <td style="width: 5%; text-align: center"><?= $stt++; ?></td>
                                <td style="width: 10%; text-align: center"><?= $this->Pack->get_info($pack->pack_id)->pack_number ?></td>
                                <td style="width: 37%"><?= $this->Pack->get_info($pack->pack_id)->name; ?></td>
                                <td style="width: 8%; text-align: left"><?= $this->Unit->get_info($pack->unit_pack)->name; ?></td>
                                <?php
                                    $item_price = $pack->pack_unit_price;
                                    $total_tax = ($item_price * $pack->quantity_purchased - $item_price * $pack->quantity_purchased * $pack->discount_percent / 100)*0;
                                ?>
                                <td style=" text-align: right"><?= number_format($item_price); ?></td>
                                <td style="width: 10%; text-align: right"><?= abs($pack->quantity_purchased) ?></td>
                                <td style=" text-align: right"><?= $pack->discount_percent; ?></td>
                                <td style=" text-align: right">0</td>
                                <td style="width: 10%; text-align: right">
                                    <?= number_format(($pack->quantity_purchased * ($item_price - ($item_price * $pack->discount_percent / 100)))) ?></td>

                            </tr> 
             <?php 
                    $total_quantity += $pack->quantity_purchased;
                    $total_discount += $pack->discount_percent;
                    $total_money += $pack->quantity_purchased * ($item_price - ($item_price * $pack->discount_percent / 100));
                    $tt += $total_tax;
                    $taxs += 0;
                  }
                }
                ?>

        </table>
        <table id="total_order">
            <tr>
                <td style="text-align: right; padding-right: 5px;"><b>Tổng giá trị đơn hàng : <?= to_currency($total_money); ?></b></td>

            </tr>            
            <tr>
                <td style="text-align: right; padding-right: 5px;"><b>Tổng thuế : <?= to_currency($tt); ?></b></td>

            </tr>
            <?php
//           $discount = $this->Sale->get_discount_money();
//           foreach ($discount as $discount_value){
//               if($sale_id == $discount_value['sale_id']){
//                   $discount_money = $discount_value['discount_money'];
//               }
//           }
            ?>
            <tr>
                <td style="text-align: right; padding-right: 5px;"><b>Chiết khấu tiền mặt : <?= to_currency($discount_money); ?></b></td>

            </tr>
              <tr>
                <td style="text-align: right; padding-right: 5px;"><b>Tổng giá trị thanh toán : <?= to_currency($total_money + $tt); ?></b></td>

            </tr>
            <tr>
                <td style="text-align: right; padding-right: 5px;"><b>Đã thanh toán : <?= to_currency($payment); ?></b></td>

            </tr>
            <?php
            if ($info_sale->suspended == 1 || $info_sale->liability == 1 || $info_sale->materials == 1) {
                ?>
                <tr>
                    <td style="text-align: right; padding-right: 5px;"><b>Còn nợ : <?= to_currency(($total_money + $tt) - $payment - $discount_money); ?></b></td>

                </tr>
<?php } else { ?>
                <tr>
                    <td style="text-align: right; padding-right: 5px;"><b>Tiền trả lại khách : <?= to_currency($payment-($total_money + $tt)); ?></b></td>

                </tr>
    <?php } ?>
        </table>
    </div>
    <?php $this->load->model("Cost");
    ?>
    Số tiền viết bằng chữ: <span class="color" style="font-style: italic">(<?php echo $this->Cost->get_string_number($payment); ?>)</span>


    <div id="info_employee">
        <table>
            <tr>
                <th>Khách hàng</th>
                <th>Nhân viên bán hàng</th>            
            </tr>
            <tr>
                <td style="font-style: italic;">(Ký, ghi rõ họ tên)</td>
                <td style="font-style: italic;">(Ký, ghi rõ họ tên)</td>
            </tr>
        </table>
    </div>
    <div style="text-align: center; width: 100%; font-style: italic; position: absolute; bottom: 0px;">(Cần kiểm tra đối chiếu khi lập, giao, nhận hàng hóa)</div>
</div>
<div style="width: 793px; margin: 10px 0; text-align: right;">
    <a href = "<?= site_url() . '/sales/sales_order' ?>" id="submit" style="width:100px; text-align: center;" class="print_report" onclick = "this.style.display = 'none';
            window.print()">In hóa đơn</a>
</div>

