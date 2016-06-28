<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<script src="<?php echo base_url(); ?>js/jquery-1.9.1.js"></script>
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
        /*//width: 793px;*/   
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
        border: 1px solid #000000;
        border-top: none;
    }
    #table_items tr:last-child td{
        border-bottom: 1px solid #000000;
    }  

    #info_employee{
        margin-top: 15px;
    }
    #info_employee table{
        width: 100%;
    }
    #info_employee table th,#info_employee table td{
        width: 25%;
        text-align: center;
    }
    #info_employee .love_you td{
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
    #text_money_audi{
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
            <p>Số: <span style='color: #D50018; font-weight: bold'><?= $receiving_id; ?></span></p>
            <p>Ngày: <span style='color: #002FC2'><?php echo date("d-m-Y H:i:s",  strtotime($transaction_time)); ?></span></p>
        </div>
        <div style="clear: both"></div>
    </div>
    <div id="title_order">
        <?php
        if ($mode == 'receive') {
            echo "phiếu nhập kho ";
        } else {
            echo "Hóa đơn trả hàng";
        }
        ?>
    </div>
    <div id="info_customer">
        <p>Đơn vị cung cấp: <span class="color"><?php echo $company_name; ?></span></p>
        <p>Ghi chú: <span class="color"><?php echo (isset($comment) ? $comment : ""); ?></span></p>
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
            $total1 = 0;
            $subtotal = 0;
            $net_price = 0;
            $tax = 0;
            $total_cost = 0;
            foreach (array_reverse($cart, true) as $line => $item) {
                $net_price = $item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100;
                $total1 += $net_price;
                $tax = $net_price * $item['taxes'] / 100;

                $subtotal+= $tax;

                if ($item['item_id']) {
                    $term = $this->Item->get_info($item['item_id']);
                    $unit = $this->Unit->get_info($term->unit);
                    $number_code = $term->item_number;
                } else {
                    $term = $this->Item_kit->get_info($item['item_kit_id']);
                    $unit = $this->Unit->get_info($term->category);
                    $number_code = $term->item_kit_number;
                }
                $quantity = $mode == "receive" ? $item['quantity'] : ($item['quantity'] * (-1));
                ?>
                <tr>
                    <td style="text-align: center; width: 5%;"><?php echo $k; ?></td>
                    <td style="text-align: left; padding-left: 10px; width: 15%;"><?php echo $number_code; ?></td>
                    <td style="text-align: left; padding-left: 10px; width: 25%;"><?php echo $item['name']; ?></td>
                    <td style="text-align: center; padding-right: 5px; width: 8%;"><?php echo $unit->name; ?></td>
                    <td style="text-align: right; padding-right: 5px; width: 5%;"><?php echo $quantity; ?></td>
                    <?php
                      if($item['discount'] > 0){
                    ?>
                    <td style="text-align: right; padding-right: 5px; width: 8%;"><?php echo to_currency_unVND_nomar($item['price']-($item['price']*$item['discount']/100)); ?></td> 
                      <?php }else{?>
                    <td style="text-align: right; padding-right: 5px; width: 8%;"><?php echo to_currency_unVND_nomar($item['price']); ?></td> 

                      <?php }?>
    <!--                    <td style="text-align: right; padding-right: 5px; width: 12%;"><?php //echo to_currency_unVND_nomar($item['discount']);  ?></td>-->
                    <td style="text-align: right; padding-right: 5px; width: 15%;"><?php echo to_currency_unVND_nomar($item['price'] * $quantity - (($item['discount'] * $item['price'] * $quantity) / 100)); ?></td>
                </tr>
                <?php
                $k ++;
            }
            ?>
        </table>
        <table id="total_order"> 
            <tr>
                <td style="text-align: right; padding-right: 5px; border-bottom: 1px solid #000000; border-right: none;">
                    <b>Tổng tiền hàng:</b>
                </td>
                <td style="text-align: right; border-bottom: 1px solid #000000; width: 150px; border-left: none;">
                    <?php
                    if ($mode == "receive") {
                        echo to_currency_unVND_nomar($total1);
                    } else {
                        echo to_currency_unVND_nomar($total_order * (-1));
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td style="text-align: right; padding-right: 5px; border-bottom: 1px solid #000000; border-right: none;">
                    <b>Tiền chi phí
                <td style="text-align: right; border-bottom: 1px solid #000000; width: 150px; border-left: none;">
                    <?php
                    
                        echo to_currency_unVND_nomar($this->receiving_lib->get_other_cost());
                    
                    ?>
                </td>
            </tr>
             <tr>
                <td style="text-align: right; padding-right: 5px; border-bottom: 1px solid #000000; border-right: none;">
                    <b>Tiền thuế
                <td style="text-align: right; border-bottom: 1px solid #000000; width: 150px; border-left: none;">
                    <?php
                    
                        echo to_currency_unVND_nomar($total_taxes);
                    
                    ?>
                </td>
            </tr>
            <tr>
                <td style="text-align: right; padding-right: 5px; border-bottom: 1px solid #000000; border-right: none;">
                    <b>Tổng tiền hàng:</b>
                </td>
                <td style="text-align: right; border-bottom: 1px solid #000000; width: 150px; border-left: none;">
                    <?php
                    if ($mode == "receive") {
                        echo to_currency_unVND_nomar($total1 + $this->receiving_lib->get_other_cost() + $total_taxes);
                    } else {
                        echo to_currency_unVND_nomar($total_order * (-1));
                    }
                    ?>
                </td>
            </tr>
        </table>
    </div>
    <div id="text_money">
        Số tiền viết bằng chữ: <span class="color" style="font-style: italic;">
            <?php
            
            $x = $total1 + $this->receiving_lib->get_other_cost();
            
            $Text = array("không", "một", "hai", "ba", "bốn", "năm", "sáu", "bảy", "tám", "chín");
            $TextLuythua = array("", "nghìn", "triệu", "tỷ", "ngàn tỷ", "triệu tỷ", "tỷ tỷ");
            $textnumber = "";
            $x = $mode == "receive" ? $x : ($x * (-1));
            $length = strlen($x);

            for ($i = 0; $i < $length; $i++)
                $unread[$i] = 0;

            for ($i = 0; $i < $length; $i++) {
                $so = substr($x, $length - $i - 1, 1);

                if (($so == 0) && ($i % 3 == 0) && ($unread[$i] == 0)) {
                    for ($j = $i + 1; $j < $length; $j ++) {
                        $so1 = substr($x, $length - $j - 1, 1);
                        if ($so1 != 0)
                            break;
                    }

                    if (intval(($j - $i ) / 3) > 0) {
                        for ($k = $i; $k < intval(($j - $i) / 3) * 3 + $i; $k++)
                            $unread[$k] = 1;
                    }
                }
            }

            for ($i = 0; $i < $length; $i++) {
                $so = substr($x, $length - $i - 1, 1);
                if ($unread[$i] == 1)
                    continue;

                if (($i % 3 == 0) && ($i > 0))
                    $textnumber = $TextLuythua[$i / 3] . " " . $textnumber;

                if ($i % 3 == 2)
                    $textnumber = 'trăm ' . $textnumber;

                if ($i % 3 == 1)
                    $textnumber = 'mươi ' . $textnumber;


                $textnumber = $Text[$so] . " " . $textnumber;
            }

            //Phai de cac ham replace theo dung thu tu nhu the nay
            $textnumber = str_replace("không mươi", "lẻ", $textnumber);
            $textnumber = str_replace("lẻ không", "", $textnumber);
            $textnumber = str_replace("mươi không", "mươi", $textnumber);
            $textnumber = str_replace("một mươi", "mười", $textnumber);
            $textnumber = str_replace("mươi năm", "mươi lăm", $textnumber);
            $textnumber = str_replace("mươi một", "mươi mốt", $textnumber);
            $textnumber = str_replace("mười năm", "mười lăm", $textnumber);
            echo ucfirst($textnumber . "đồng chẵn");
            ?>
        </span>
    </div>
    <div id="text_money_audi">
        Đã thanh toán bằng <?= $payment_type ?>: <?= to_currency_unVND_nomar($amount_tendered1) ?> vnđ
    </div>
    <div id="info_employee">
        <table style="margin-bottom: 10px">
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
            </tr>
            <tr>
                <td style="font-style: italic;">(Ký, họ tên)</td>
                <td style="font-style: italic;">(Ký, họ tên)</td>
                <td style="font-style: italic;">(Ký, họ tên)</td>
                <td style="font-style: italic;">(Ký, họ tên)</td>            
            </tr>
        </table>
    </div>
    <div style="text-align: center; width: 100%; font-style: italic; position: absolute; bottom: 0px;">(Cần kiểm tra đối chiếu khi lập, giao, nhận hàng hóa)</div>
</div>
<div style="width: 793px; margin: 10px 0; text-align: right;">
    <a href = "<?= site_url() . 'receivings' ?>" id="submit" style="width:100px; text-align: center;" class="print_report" onclick = "this.style.display = 'none';
            window.print();">In hóa đơn</a>
</div>