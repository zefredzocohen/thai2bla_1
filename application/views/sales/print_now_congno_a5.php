<meta http-equiv="content-type" content="text/html; charset=utf-8" />

<style>
    #flip,.topheader, .header, .gn-menu-main-header, .gn-menu-main{
        display: none;
    }
    #register_container{
        margin: 0px;
        width: 100%;
    }
    body{
        padding: 0;
        margin: 0;
    }
    #print_a5{
        width: 793px;        
        display: block;
        overflow: hidden;        
        position: relative;
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
        width: 480px;
        float: left;
    }

    #info_company table td{
        padding: 2px 0px;
    }
    #info_order{
        float: right;
        width: 155px;
    }
    #info_order p{
        line-height: 25px;
    }
    #title_order{
        width: 100%;
        text-align: center;
        text-transform: uppercase;
        font-weight: bold;
        font-size: 16px;
        margin-top: 12px;
        margin-bottom: 10px;
    }
    .color{
        color: #002FC2;
    }
    #content_order{
        margin-top: 10px;
    }
    #table_items, #total_order{
        width: 99%;
        border-collapse: collapse;
        font-size: 12px;
        margin: 0px auto;
    }    
    #table_items tr th, #table_items tr td{        
        border: 1px solid #000000;
        padding: 3px;
    }
    #total_order tr td{
        padding: 3px;
        border-bottom: 1px dotted #000000;             
    }
    #table_items tr:last-child td, #total_order tr:last-child td{
        border-bottom: 1px solid #000000;
    }  

    #info_employee{
        margin-top: 15px;
    }
    #info_employee table{
        width: 100%;
    }
    #info_employee table th,#info_employee table td{
        width: 50%;
        text-align: center;
    }
    #info_employee table td{
        padding: 0px 0px 70px 0px;
    }
    #info_customer{
        display: block;
        overflow: hidden;
        padding-left: 10px;
    }
    #info_customer p{
        line-height: 20px;
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
<div id="print_a5">
    <div id="header_order">
        <div id="logo_print">
            <?php echo img(array('src' => $this->Appconfig->get_logo_image())); ?>
        </div>
        <div id="info_company">
            <table>
                <tr>
                    <td colspan="2">
                        <p style="text-transform: uppercase;  font-weight: bold; color: #002FC2;"><?php echo $this->config->item('company'); ?></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><p style='color: #002FC2'><?php echo $this->config->item('address'); ?></p></td>
                </tr>
                <tr>
                    <td>Điện thoại: <span style='color: #002FC2'><?php echo $this->config->item('phone'); ?></span></td>
                    <td>Fax: <span style='color: #002FC2'><?php echo $this->config->item('fax'); ?></span></td>
                </tr>
            </table>
        </div>
        <div id="info_order">
            <p>Số: <span style='color: #D50018; font-weight: bold'><?php echo $sale_id; ?></span></p>
            <p>Ngày: <span style='color: #002FC2'><?php echo date('d-m-Y',  strtotime($transaction_time)); ?></span></p>
        </div>
        <div style="clear: both"></div>
    </div>
    <div id="title_order">Hóa đơn ghi nợ</div>
    <div id="info_customer">
        <p>Họ tên người mua hàng: <span class="color"><?php echo (isset($customer) ? $customer : "KHÁCH LẺ"); ?></span></p>
        <?php if ($cus_name != "") { ?>
            <p>Tên đơn vị: <span class="color" style="text-transform: uppercase"><?php echo $cus_name; ?></span></p>
            <p>Địa chỉ: <span class="color"><?php echo $address; ?></span></p>
        <?php } ?>
        <p>Ghi chú: <span class="color"><?php echo (isset($comment) ? $comment : ""); ?></span></p>
        <?php $info_warehouse = $this->Create_invetory->get_info($store); ?>
        <p>Kho: <?= $info_warehouse->name_inventory; ?></p>
        <p>Địa chỉ kho: <?= $info_warehouse->address; ?></p>
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
                    <td style="text-align: center; width: 5%;"><?php echo $k; ?></td>
                    <td style="text-align: left; padding-left: 10px; width: 9%;"><?php echo $number_code; ?></td>
                    <td style="text-align: left; padding-left: 10px; width: 20%;"><?php echo $item['name']; ?></td>
                    <td style="text-align: center; padding-right: 5px; width: 8%;"><?php echo $unit_name->name; ?></td>
                    <td style="text-align: right; padding-right: 5px; width: 5%;"><?php echo $item['quantity']; ?></td>
                    <td style="text-align: right; padding-right: 5px; width: 14%;">
    <?php
    if ($item['unit'] == "unit") {
        echo to_currency_unVND_nomar($item['price']);
    } else {
        echo to_currency_unVND_nomar($item['price_rate']);
    }
    ?>
                    </td>
                    <td style="text-align: right; padding-right: 5px; width: 13%;"><?php echo to_currency_unVND_nomar($item['discount']); ?></td>
                    <td style="text-align: right; padding-right: 5px; width: 9%;"><?php echo $item['taxes']; ?></td>
                    <td style="text-align: right; padding-right: 5px; width: 20%;">
                        <?php
                        if ($item['unit'] == "unit") {
                            echo to_currency_unVND_nomar($item['price'] * $item['quantity'] - ($item['discount'] * $item['price'] * $item['quantity']) / 100);
                        } else {
                            echo to_currency_unVND_nomar($item['price_rate'] * $item['quantity'] - ($item['discount'] * $item['price_rate'] * $item['quantity']) / 100);
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
        <table id="total_order">
             <tr>
                <td style="border-left: 1px solid #000000;"></td>
                <td></td>                
                <td style="text-align: right; padding-right: 5px;"><b>Tổng tiền hàng:</b></td>
                <td style="text-align: right; border-right:1px solid #000000;"><?php echo to_currency_unVND_nomar($total_order) ?></td>
            </tr>
            <tr>
                <td style="border-left: 1px solid #000000;"></td>
                <td></td>                
                <td style="text-align: right; padding-right: 5px;"><b>Số tiền đã thanh toán:</b></td>
                <td style="text-align: right; border-right:1px solid #000000;"><?php echo to_currency_unVND_nomar($total_payment); ?></td>
            </tr>
            <tr>
                <td style="border-left: 1px solid #000000;"></td>
                <td></td>                
                <td style="text-align: right; padding-right: 5px;"><b>Số tiền còn nợ:</b></td>
                <td style="text-align: right; border-right:1px solid #000000;"><?php echo to_currency_unVND_nomar($total_order - $total_discount_money + $total_taxes_percent - $total_payment) ?></td>
            </tr>
            <tr>
                <td style="border-left: 1px solid #000000;"></td>
                <td></td>                
                <td style="text-align: right; padding-right: 5px;"><b>Tổng thuế:</b></td>
                <td style="text-align: right; border-right:1px solid #000000;"><?php echo to_currency_unVND_nomar($total_taxes_percent) ?></td>
            </tr>
           
            <tr>
                <td style="border-left: 1px solid #000000;"></td>
                <td></td>                
                <td style="text-align: right; padding-right: 5px;"><b>Chiết khấu đơn hàng:</b></td>
                <td style="text-align: right; border-right:1px solid #000000;"><?php echo to_currency_unVND_nomar($total_discount_money); ?></td>
            </tr>
            <tr>
                <td style="border-left: 1px solid #000000;"></td>
                <td></td>
                <td style="text-align: right; padding-right: 5px;"><b>Tổng cộng tiền thanh toán:</b></td>
                <td style="text-align: right; border-right:1px solid #000000;"><?php echo to_currency_unVND_nomar($total_order - $total_discount_money + $total_taxes_percent) ?></td>
            </tr>
            
           <?php
             if($this->config->item('cong_no') == 1){
           ?>
            <tr>
                <td style="border-left: 1px solid #000000;"></td>
                <td></td>
                <td style="text-align: right; padding-right: 5px;"><b>Tổng nợ cũ:</b></td>
                <td style="text-align: right; border-right:1px solid #000000;"> 
                   <?php
                       $tam = $this->Sale->money_get_sale_tam();
                       if($congno != NULL){
                           $total_no = 0;
                           $total_tam = 0;
                           $total_thu = 0;
                           foreach ($congno->result() as $kh){
                               $total_no += $kh->later_cost_price;
                               foreach ($tam as $v){
                                   if($kh->sale_id == $v->id_sale){
                                       $total_tam += $v->pays_amount;
                                   }
                               }
                           }
                           
                           foreach ($no as $v1){
                                   if($v1->form_cost == 0){
                                       $total_thu += $v1->money;
                                    }
                           }
                           
                           echo number_format(($total_no - $total_tam - $total_thu)-$total_order - $total_discount_money + $total_taxes_percent);
                       }
                   ?>
                </td>
            </tr>
            <tr>
                <td style="border-left: 1px solid #000000;"></td>
                <td></td>
                <td style="text-align: right; padding-right: 5px;"><b>Tổng nợ tất cả:</b></td>
                <td style="text-align: right; border-right:1px solid #000000;">
                    <?=  number_format($total_no - $total_tam - $total_thu)?>
                </td>
            </tr>
             <?php }?>
        </table>
    </div>
    <div id="text_money">
        <?php $this->load->model("Cost"); ?>
        Số tiền còn phải thanh toán : <span class="color" style="font-style: italic; font-weight: bold">(Bằng chữ: <?php echo $this->Cost->get_string_number(to_un_currency($total_order - $total_discount_money + $total_taxes_percent - $total_payment)); ?>)</span>
    </div>
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
    <a href="<?= site_url() . '/sales' ?>" id="submit" style="width:100px; text-align: center;" class="print_report" onclick = "this.style.display = 'none';
            window.print();">In hóa đơn</a>
</div>

