<meta http-equiv="content-type" content="text/html; charset=utf-8" />


<style>
    body{
        padding: 0;
        margin: 0;
    }
    #print_a5{
        width:700px;
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
        width: 17%;
        text-align: center;
    }
    #info_employee .love_you td{
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
            <p>Ngày: <span style='color: #002FC2'><?php echo date('d-m-Y',strtotime($transaction_time)); ?></span></p>
        </div>
        <div style="clear: both"></div>
    </div>
    <div id="title_order">
<?php echo ($mode == 'sale' ? "Hóa đơn bán hàng" : "Hóa đơn trả hàng"); ?>
    </div>
    <div id="info_customer">
        <p>Họ tên khách hàng hàng: <span class="color"><?php echo (isset($customer) ? $customer : "KHÁCH LẺ"); ?></span></p>
<?php if ($cus_name != "") { ?>
            <p>Tên đơn vị: <span class="color" style="text-transform: uppercase"><?php echo $cus_name; ?></span></p>
            <p>Địa chỉ: <span class="color"><?php echo $address1; ?></span></p>
        <?php } ?>
        <p>Ghi chú: <span class="color"><?php echo (isset($comment) ? $comment : ""); ?></span></p>
        <?php
        if ($this->config->item('delivery') == 1) {
            if ($delivery_employee != 0) {
                ?>

                <p>Nhân viên giao hàng: <span class="color">
                        <?php
                        echo $delivery_employee1;
                        ?>
                    </span></p>
            <?php }
        } ?>
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
                <th>Thành tiền</th>
            </tr>
            <?php
            $k = 1;
            foreach (array_reverse($cart, true) as $line => $item) {
                if ($item['item_id']) {
                    $term = $this->Item->get_info($item['item_id']);
                    if ($item['unit'] == 'unit') {
                        $unit_name = $this->Unit->get_info($term->unit);
                    } else {
                        $unit_name = $this->Unit->get_info($term->unit_from);
                    }
                    $number_code = $term->item_number;
                } else {
                    $term = $this->Pack->get_info($item['pack_id']);
                    $unit_name = $this->Unit->get_info($term->unit);
                    $number_code = $term->pack_number;
                }
                ?>
                <tr>
                    <td style="text-align: center; width: 5%"><?php echo $k; ?></td>
                    <td style="text-align: center; width: 15%"><?php echo $number_code; ?></td>
                    <td style="text-align: left; padding-left: 10px; width: 25%"><?php echo $item['name']; ?></td>
                    <td style="text-align: center; padding-right: 5px; width: 8%"><?php echo $unit_name->name; ?></td>
                    <td style="text-align: right; padding-right: 5px; width: 5%"><?php echo $item['quantity']; ?></td>
                    <td style="text-align: right; padding-right: 5px; width: 10%">
                        <?php
                         if($item['discount'] > 0){
                                        if($item['unit']=="unit"){
                                            echo to_currency_unVND_nomar($item['price']-($item['price']*$item['discount']/100));
                                        }else{
                                            echo to_currency_unVND_nomar($item['price_rate']-($item['price']*$item['discount']/100));
                                        } 
                                  }else{
                                      if($item['unit']=="unit"){
                                            echo to_currency_unVND_nomar($item['price']);
                                        }else{
                                            echo to_currency_unVND_nomar($item['price_rate']);
                                        } 
                                  }
                        ?>
                    </td>
                    <td style="text-align: right; padding-right: 5px; width: 12%">
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
        <table id="total_order">
            <tr>
                <td style="text-align: right; padding-right: 5px;"><b>Tổng tiền hàng:</b></td>
                <td style="text-align: right;"><?php echo to_currency_unVND_nomar($total_order) ?></td>
            </tr>            
            <tr>
                <td style="text-align: right; padding-right: 5px;"><b>Tổng thuế:</b></td>
                <td style="text-align: right;">
                    <?php
                    $total_taxes_percent = 0;
                    foreach ($cart as $item) {
                        if ($item['unit'] == 'unit') {
                            $total_taxes_percent += $item['taxes'] * ($item['price'] * $item['quantity'] - $item['discount'] * $item['price'] * $item['quantity'] / 100) / 100;
                        } else {
                            $total_taxes_percent += $item['taxes'] * ($item['price_rate'] * $item['quantity'] - $item['discount'] * $item['price_rate'] * $item['quantity'] / 100) / 100;
                        }
                    }
                    echo to_currency_unVND_nomar($total_taxes_percent);
                    ?>
                </td>
            </tr>
            <tr>
                <td style="text-align: right; padding-right: 5px;"><b>Chiết khấu đơn hàng:</b></td>
                <td style="text-align: right;">
                    <?php
                    $total_discount_money = 0;
                    foreach ($payments as $payment) {
                        $total_discount_money += $payment['discount_money'];
                    }
                    echo to_currency_unVND_nomar($total_discount_money);
                    ?>
                </td>
            </tr>
            <tr>
                <td style="text-align: right; padding-right: 5px;"><b>Tổng cộng tiền thanh toán:</b></td>
                <td style="text-align: right;"><?php echo to_currency_unVND_nomar($total_order - $total_discount_money + $total_taxes_percent) ?></td>
            </tr>
             <?php
               if($this->config->item('cong_no') == 1){
            ?>
            <tr>
                <td style="text-align: right; padding-right: 5px;"><b>Tổng nợ tất cả:</b></td>
                <td style="text-align: right;">
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
                           
                           echo number_format($total_no - $total_tam - $total_thu);
                       }
                   ?>
                </td>
            </tr>
           <?php }?>
        </table>
    </div>
    <div id="text_money">
<?php $this->load->model("Cost"); ?>
        Số tiền viết bằng chữ: <span class="color" style="font-style: italic">(<?php echo $this->Cost->get_string_number(to_un_currency($total_order - $total_discount_money + $total_taxes_percent)); ?>)</span>
    </div>
    <div id="info_employee">
        <table>
            <tr>
                <td style="width: 75%"></td>
                <td style="width: 25%"><em>Ngày ... tháng ... năm ......</em></td>
            </tr>
        </table>    
        <table class="love_you">
            <tr>
                <th>Người lập phiếu</th>
                <th>Người nhận hàng</th>
                <th>Thủ kho</th>
                <th>Kế toán trưởng</th>
                <th>Giám đốc/Thủ trưởng đơn vị</th>
                <?php
                if ($this->config->item('delivery') == 1) {
                    if ($delivery_employee != 0) {
                        ?>
                        <th>Nhân viên giao hàng</th>
    <?php }
} ?>
            </tr>
            <tr>
                <td style="font-style: italic;">(Ký, họ tên)</td>
                <td style="font-style: italic;">(Ký, họ tên)</td>
                <td style="font-style: italic;">(Ký, họ tên)</td>
                <td style="font-style: italic;">(Ký, họ tên)</td>
                <td style="font-style: italic;">(Ký, họ tên)</td>
                <?php
                if ($this->config->item('delivery') == 1) {
                    if ($delivery_employee != 0) {
                        ?>
                        <td style="font-style: italic;">(Ký, ghi rõ họ tên)</td>
    <?php }
} ?>
            </tr>
        </table>
    </div>
    <div style="text-align: center; width: 100%; font-style: italic; position: absolute; bottom: 0px;">(Cần kiểm tra đối chiếu khi lập, giao, nhận hàng hóa)</div>
</div>
<div style="width: 700px; margin: 10px 0; text-align: right;">
    <a href = "<?= site_url() . '/sales' ?>" id="submit" style="width:100px; text-align: center;" class="print_report" onclick = "this.style.display = 'none';
            window.print()">In hóa đơn</a>
</div>
