<meta http-equiv="content-type" content="text/html; charset=utf-8" />

<div id="content_area_wrapper">
    <div id="content_area" style="padding: 10px 4px 0 5px">
        <style type="text/css">
            .mavach-table td {
                height: 30px;
                margin-bottom: 3px;
                font-weight: bold;
            }
            #form_excel_export{

                width: 271px;
                margin: 30px 0 0;
            }
            .submit_button_export_excel{
                background: none repeat scroll 0 0 #1E5A96;
                border: 1px solid #EEEEEE;
                color: #FFFFFF;
                font-size: 14px;
                font-weight: bold;
                line-height: 30px;
                padding: 5px;
            }
            #value_to_update{
                float: left;
                margin:0 15px;
                width: 100px;
            }
            #value_to_update input{
                background: none repeat scroll 0 0 #1E5A96;
                border: 1px solid #EEEEEE;
                color: #FFFFFF;
                font-size: 14px;
                font-weight: bold;
                line-height: 30px;
                padding: 5px;
                margin-left: 9px;
                width: 100px;
                text-align: center;
            }
            #logo img{
                width: 120px;
                height: 50px;
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
            #submit
            {
                width: 85px;
                text-align: center;
                margin-left: 140px;
            }
            #diachi{
                text-transform: uppercase;
            }

        </style>
        <div id="print_a8" style="height: auto; width: 280px;">
            <div id="receipt_wrapper" style="width:280px;font-family: Arial; margin-top: -15px;">
                <div id="logo" style="text-align: center; width: 280px">
                    <?php
                    echo img(array(
                        'src' => $this->Appconfig->get_logo_image()
                    ));
                    ?>
                </div>

                <div style="width: 280px; text-align: center; font-size: 10px">
                    <div id="diachi">
                        <?php echo $this->config->item('company') ?>
                    </div>
                    <div id="phone_number"> 
                        Địa chỉ: <?php echo $this->config->item('address') ?>
                    </div>
                    <div id="phone_number"> 
                        Điện thoại: <?php echo $this->config->item('phone') ?>
                    </div>        
                    <div id="phone_number">
                        Email: <?php echo $this->config->item('email') ?>
                    </div>        
                </div>
                <div id="receipt_header" >
                    <div id="sale_receipt" style="text-transform: uppercase !important;text-align: center;font-weight: bold; margin: 10px auto;font-size: 12px;">
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
                </div>
                <div id="sale_time" style="font-size: 10px !important">
                    <?php echo "Số phiếu: <b>" . $sale_id . "</b>" ?>&nbsp;&nbsp;&nbsp;<?php echo "Ngày: " . date('d-m-Y H:i:s') ?>
                </div>
                <div id="receipt_general_info" style="font-size: 10px !important">
                    <?php
                    $cus_emp = $this->Employee->get_info($info_sale->employee_id)->first_name . ' ' . $cus_emp = $this->Employee->get_info($info_sale->employee_id)->last_name;
                    ?>
                    <p>Nhân viên bán hàng: <span class="color"><?= $cus_emp; ?></span></p>
                    <?php
                    if ($info_sale->customer_id == NULL) {
                        $cus_name = "KHÁCH LẺ";
                    } else {
                        $cus_name = $this->Customer->get_info($info_sale->customer_id)->first_name . ' ' . $cus_name = $this->Customer->get_info($info_sale->customer_id)->last_name;
                    }
                    ?>
                    <p>Họ tên người mua hàng: <span class="color"><?= $cus_name; ?></span></p>

                    <p>Tên đơn vị: <span class="color" style="text-transform: uppercase"></span></p>
                    <p>Địa chỉ: <span class="color"><?= $address1; ?></span></p>

                </div>
                <table class="new-font-size" style="border-collapse: collapse; width: 280px; font-size: 9px; margin-top: 10px;">
                    <tr>
                        <th style="border: 1px solid #000000; padding: 3px;">STT</th>
                        <th style="border: 1px solid #000000; padding: 3px;">Mã MH</th>
                        <th style="border: 1px solid #000000; padding: 3px;">HH, DV</th>
                        <th style="border: 1px solid #000000; padding: 3px;">ĐVT</th>
                        <th style="border: 1px solid #000000; padding: 3px;">SL</th>
                        <th style="border: 1px solid #000000; padding: 3px;">Đơn giá</th>                        
                        <th style="border: 1px solid #000000; padding: 3px;">CK (%)</th>
                        <th style="border: 1px solid #000000; padding: 3px;">Thuế (%)</th>
                        <th style="border: 1px solid #000000; padding: 3px;">Thành tiền</th>
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
                    if ($this->Sale->get_info($sale_id)->row()->sale_status == 0) {
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
                                                <td style="width: 5%; border: 1px solid #000000; padding: 3px;">
                                            <?= $stt++; ?>
                                                </td>
                                                <td style="width: 5%; border: 1px solid #000000; padding: 3px;">
                                                    <?= $this->Item->get_info($val['item_id'])->item_number; ?>
                                                </td>
                                                <td style="width: 28%; border: 1px solid #000000; padding: 3px;">
                                                    <?= $this->Item->get_info($val['item_id'])->name; ?>
                                                </td>
                                                    <?php
                                                    if ($val['unit_item'] == $get_value['unit_from']) {
                                                        $item_unit = $get_value['unit_from'];
                                                    } else {
                                                        $item_unit = $get_value['unit'];
                                                    }
                                                    ?>
                                                <td style="width: 6%; text-align: right; border: 1px solid #000000; padding: 3px;">
                                                <?= $this->Unit->get_info($item_unit)->name; ?>
                                                </td>
                                                <td style="width: 6%; text-align: right; border: 1px solid #000000; padding: 3px;">
                                                    <?= number_format($val['quantity_purchased']); ?>
                                                </td>
                                                <td style="width: 16%; text-align: right; border: 1px solid #000000; padding: 3px;">
                                                    <?= number_format($val['item_unit_price']); ?>
                                                </td>                            
                                                <td style="width: 6%; text-align: right; border: 1px solid #000000; padding: 3px;">
                                                    <?= $val['discount_percent']; ?>
                                                </td>
                                                <td style="width: 6%; text-align: right; border: 1px solid #000000; padding: 3px;">
                                                    <?= $val['taxes_percent']; ?>
                                                </td>
                                                <td style="width: 17%; text-align: right; border: 1px solid #000000; padding: 3px;">
                                                    <?= number_format($val['quantity_purchased'] * ($val['item_unit_price'] - ($val['item_unit_price'] * $val['discount_percent'] / 100))); ?>
                                                </td>
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
                            } else {
                                $sale_all_pack = $this->Sale->all_sales_pack($sale_id);
                                foreach ($sale_all_pack as $pack) {
                                    ?>
                                              <tr>
                                                <td style="width: 5%; border: 1px solid #000000; padding: 3px;">
                                            <?= $stt++; ?>
                                                </td>
                                                <td style="width: 5%; border: 1px solid #000000; padding: 3px;">
                                                    <?= $this->Pack->get_info($pack->pack_id)->pack_number; ?>
                                                </td>
                                                <td style="width: 28%; border: 1px solid #000000; padding: 3px;">
                                                    <?= $this->Pack->get_info($pack->pack_id)->name; ?>
                                                </td>
                                                <?php
                                                  $item_price = $pack->pack_unit_price;
                                                ?>
                                                <td style="width: 6%; text-align: right; border: 1px solid #000000; padding: 3px;">
                                                <?= $this->Unit->get_info($pack->unit_pack)->name; ?>
                                                </td>
                                                <td style="width: 6%; text-align: right; border: 1px solid #000000; padding: 3px;">
                                                    <?= number_format($pack->quantity_purchased); ?>
                                                </td>
                                                <td style="width: 16%; text-align: right; border: 1px solid #000000; padding: 3px;">
                                                    <?= number_format($pack->pack_unit_price); ?>
                                                </td>                            
                                                <td style="width: 6%; text-align: right; border: 1px solid #000000; padding: 3px;">
                                                    <?= $pack->discount_percent; ?>
                                                </td>
                                                <td style="width: 6%; text-align: right; border: 1px solid #000000; padding: 3px;">
                                                    <?= 0; ?>
                                                </td>
                                                <td style="width: 17%; text-align: right; border: 1px solid #000000; padding: 3px;">
                                                    <?= number_format(($pack->quantity_purchased * ($item_price - ($item_price * $pack->discount_percent / 100)))) ?>
                                                </td>
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
                    <tr>
                        <td colspan="7" style="text-align: right;">Tổng giá trị đơn hàng:</td>
                        <td colspan="2" style="text-align: right;"><?= to_currency($total_money); ?></td>
                    </tr>

                    <tr>
                        <td colspan="7" style="text-align: right;">Tổng thuế:</td>
                        <td colspan="2" style="text-align: right"><?= to_currency($tt); ?></td>
                    </tr>
<?php
//                    $discount = $this->Sale->get_discount_money();
//                    foreach ($discount as $discount_value) {
//                        if ($sale_id == $discount_value['sale_id']) {
//                            $discount_money = $discount_value['discount_money'];
//                        }
//                    }
?>
                    <tr>
                        <td colspan="7" style="text-align: right;">Chiết khấu tiền mặt:</td>
                        <td colspan="2" style="text-align: right"><?= to_currency($discount_money); ?></td>
                    </tr>
                    <tr>
                        <td colspan="7" style="text-align: right;">Tổng giá trị thanh toán:</td>
                        <td colspan="2" style="text-align: right"><?= to_currency($total_money + $tt); ?></td>
                    </tr>
                    <tr>
                        <td colspan="7" style="text-align: right;">Đã thanh toán :</td>
                        <td colspan="2" style="text-align: right">                            
  <?php $data['payment']=$this->Sale->payment($sale_id);
                                                                                                                            echo to_currency($data['payment'][0]['sum']); ?>  
                        </td>
                    </tr>
                            <?php
                            if ($info_sale->suspended == 1 || $info_sale->liability == 1 || $info_sale->materials == 1) {
                                ?>
                        <tr>
                            <td colspan="7" style="text-align: right;">Còn nợ:</td>
                            <td colspan="2" style="text-align: right"><?php echo to_currency(($total_money + $tt) - $data['payment'][0]['sum'] - $discount_money); ?></td>
                        </tr>
<?php } else { ?>

                        <tr>
                            <td colspan="7" style="text-align: right;">Tiền trả lại khách:</td>
                            <td colspan="2" style="text-align: right"><?php  echo to_currency($data['payment'][0]['sum'] - ($total_money + $tt)); ?></td>
                        </tr>
<?php } ?>
<?php $this->load->model("Cost");
?>    
<!--                    <tr>
                    <td colspan="7" style="text-align: right;">Số tiền viết bằng chữ:</td>
                    <td colspan="2" style="text-align: right"><?= $this->Cost->get_string_number($payment); ?></td>
                </tr>-->

                    <tr>
                        <td colspan="9" style="text-align: center">
                            <div style="width: 100%; margin-top: 10px; border-top: 1px dotted #000000;"></div>
                            Quý khách vui lòng kiểm tra lại hóa đơn trước khi về.<br>
                            Giá chưa bao gồm HĐ VAT<br>
                            Xin cảm ơn quý khách. Hẹn gặp lại!
                        </td>
                    </tr>
                </table>
            </div>

            <!--huyenlt^^		-->
            <a href = "<?= site_url() . '/sales/sales_order' ?>" id="submit" style="width:100px; color:#FFFFFF;" class="print_report" onclick = "this.style.display = 'none';
                    javascript:printDiv('print_a8')">In hóa đơn</a>
        </div>
    </div>
</div>
<!--huyenlt^^ -->
<script language="javascript" type="text/javascript">
    function printDiv(divID) {
        //Get the HTML of div
        var divElements = document.getElementById(divID).innerHTML;
        //Get the HTML of whole page
        //var oldPage = document.body.innerHTML;
        //Reset the page's HTML with div's HTML only
        document.body.innerHTML = "<html><head><title></title></head><body>" + divElements + "</body>";
        //Print Page
        window.print();

    }
</script>
<!-- end huyenlt^^ -->
<script type="text/javascript">
    $(document).ready(function () {
        $(".print_report1").click(function () {
            alert('chay ham 1');
            var money_dis1 = $(".money_discount").val();
            var total1 = $(".total").val();
            var sale_id1 = $(".sale_id").val();
            jQuery.ajax({
                type: 'Post',
                url: '<?php echo site_url("sales/update_all_sales_table") ?>',
                data: "sale_id=" + sale_id1 + "&total=" + total1 + "&money_discount=" + money_dis1,
                success: function (html) {
                    if (html == "true") {
                        window.print();
                    }
                    else {
                        $("#result_update").html("Bạn nên thực hiện lại đơn hàng này ");
                    }
                }
            });

        });
        $(".print_report1").click(function ()
        {
            alert('chay ham 1');
            var money_dis1 = $(".money_discount").val();
            var type_pay1 = $(".type_payment").val();
            var total1 = $(".total").val();
            var sale_id1 = $(".sale_id").val();
            jQuery.ajax({
                type: 'Post',
                url: '<?php echo site_url("sales/update_sales_sales_payments_cost_inventory") ?>',
                data: "sale_id=" + sale_id1 + "&total=" + total1 + "&payment_type=" + type_pay1 + "&money_discount=" + money_dis1,
                success: function (html) {
                    if (html == "true") {

                        window.print();
                    }
                    else {
                        $("#result_update").html("Bạn nên thực hiện lại đơn hàng này ");
                    }
                }
            });
        });

    });
</script>
