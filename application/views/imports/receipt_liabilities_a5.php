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
            <p>Số: <span style='color: #D50018; font-weight: bold'><?php echo $receiving_id; ?></span></p>
            <p>Ngày: <span style='color: #002FC2'><?php echo date("d-m-Y H:i:s"); ?></span></p>
        </div>
        <div style="clear: both"></div>
    </div>
    <div id="title_order">
        <?php
        if ($mode == 'receive') {
            echo "Hóa đơn nhập khẩu";
        } else {
            echo "Hóa đơn trả hàng nhập khẩu";
        }
        ?>
    </div>
    <div id="info_customer">
        <p>Đơn vị cung cấp: <span class="color"><?php echo $company_name; ?></span></p>
        <p>Ghi chú: <span class="color"><?php echo (isset($comment) ? $comment : ""); ?></span></p>
        <p>Nhân viên: <span class="color"><?php echo (isset($employee) ? $employee : ""); ?></span></p>
        <?php
        $currency = $this->Inventory->getCurrency();
        foreach ($currency as $rate) {
            if ($this->import_lib->get_currency_id() == $rate->id) {
                $name_curv = $rate->currency_name;
            }
        }
        ?>
        <p>Ngoại tệ: <span class="color"><?php echo $name_curv; ?></span></p>
    </div>
    <div id="content_order">
        <table id="table_items">
            <tr>
                <th>STT</th>
                <th>Mã #</th>
                <th>Tên HH, DV</th>
                <th>ĐVT</th>
                <th>SL</th>
                <th>Đơn giá</th>   
                <th>CK (%)</th>
                <th>Thuế (%)</th>
                <th>Thành tiền</th>
            </tr>
            <?php
            $k = 1;
            foreach (array_reverse($cart_import, true) as $line => $item) {
                if ($item['item_id']) {
                    $term = $this->Item->get_info($item['item_id']);
                    $unit = $this->Unit->get_info($term->unit);
                    $number_code = $term->item_number;
                }
                $quantity = $mode == "receive" ? $item['quantity'] : ($item['quantity'] * (-1));
                ?>
                <tr>
                    <td style="text-align: center; width: 5%;"><?php echo $k; ?></td>
                    <td style="text-align: left; padding-left: 10px; width: 15%;"><?php echo $number_code; ?></td>
                    <td style="text-align: left; padding-left: 10px; width: 25%;"><?php echo $item['name']; ?></td>
                    <td style="text-align: center; padding-right: 5px; width: 8%;"><?php echo $unit->name; ?></td>
                    <td style="text-align: right; padding-right: 5px; width: 5%;"><?php echo $quantity; ?></td>
                    <td style="text-align: right; padding-right: 5px; width: 8%;"><?php echo to_currency_unVND_nomar($item['price']); ?></td>
                    <td style="text-align: right; padding-right: 5px; width: 12%;"><?php echo ($item['discount']);   ?></td>
                    <td style="text-align: right; padding-right: 5px; width: 12%;"><?php echo ($item['taxe']);   ?></td>
                    <td style="text-align: right; padding-right: 5px; width: 15%;">
                        <?php
                        $this->load->library('import_lib');
                        $price_curv = ($this->import_lib->get_rate() * $item['price']);
                        $tax = ($price_curv * $item['quantity'] - $price_curv * $item['quantity'] * $item['discount'] / 100) * $item['taxe'] / 100;
                        echo $tax + ($price_curv * $item['quantity'] - $price_curv * $item['quantity'] * $item['discount'] / 100);
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
                <td style="text-align: right; padding-right: 5px; border-bottom: 1px solid #000000; border-right: none;">
                    <b>Tổng tiền thanh toán:</b>
                </td>
                <?php
                $total1 = 0;
                foreach (array_reverse($cart_import, true) as $line => $item) {
                    $price = ($this->import_lib->get_rate() * $item['price']);
                    $tax = ($price * $item['quantity'] - $price * $item['quantity'] * $item['discount'] / 100) * $item['taxe'] / 100;
                    number_format($total1 += $tax + ($price * $item['quantity'] - $price * $item['quantity'] * $item['discount'] / 100));
                }
                ?> 
                <td style="text-align: right; border-bottom: 1px solid #000000; width: 150px; border-left: none;">
                    <?php
                    if ($mode == "receive") {
                        echo to_currency_unVND_nomar($total1);
                    } else {
                        echo to_currency_unVND_nomar($total1 * (-1));
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td style="text-align: right; padding-right: 5px; border-bottom: 1px solid #000000; border-right: none;"><?php echo 'Đã thanh toán: '; ?></td>
                <td style="text-align: right; border-bottom: 1px solid #000000; width: 150px; border-left: none;"><?php echo ($amount_tendered > 0) ? to_currency($amount_tendered) : to_currency(0); ?></td>
            </tr>
            <tr>
                 <?php
                           if($total1 > $amount_tendered){
                        ?>
                <td style="text-align: right; padding-right: 5px; border-bottom: 1px solid #000000; border-right: none;"><?php echo 'Còn nợ: '; ?></td>
                <td style="text-align: right; border-bottom: 1px solid #000000; width: 150px; border-left: none;"><?php echo to_currency($total1-$amount_tendered ); ?></td>
                           <?php }else{?>
                           <td style="text-align: right; padding-right: 5px; border-bottom: 1px solid #000000; border-right: none;"><?php echo 'Tiền trả lại khách: '; ?></td>
                <td style="text-align: right; border-bottom: 1px solid #000000; width: 150px; border-left: none;"><?php echo to_currency($amount_tendered - $total1); ?></td>
                           <?php }?>
            </tr>

        </table>
    </div>
    <div id="text_money">
        Số tiền viết bằng chữ: <span class="color" style="font-style: italic;">
            <?php
            $Text = array("không", "một", "hai", "ba", "bốn", "năm", "sáu", "bảy", "tám", "chín");
            $TextLuythua = array("", "nghìn", "triệu", "tỷ", "ngàn tỷ", "triệu tỷ", "tỷ tỷ");
            $textnumber = "";
            $total = $mode == "receive" ? $total : ($total * (-1));
            $length = strlen($total);

            for ($i = 0; $i < $length; $i++)
                $unread[$i] = 0;

            for ($i = 0; $i < $length; $i++) {
                $so = substr($total, $length - $i - 1, 1);

                if (($so == 0) && ($i % 3 == 0) && ($unread[$i] == 0)) {
                    for ($j = $i + 1; $j < $length; $j ++) {
                        $so1 = substr($total, $length - $j - 1, 1);
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
                $so = substr($total, $length - $i - 1, 1);
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
    <div id="info_employee">
        <table>
            <tr>
                <th>Nhân viên mua hàng</th>
                <th>Đại diện nhà cung cấp</th>
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
    <a href = "<?= site_url() . '/imports' ?>" id="submit" style="width:100px; text-align: center;" class="print_report" onclick = "this.style.display = 'none';
            window.print();">In hóa đơn</a>
</div>