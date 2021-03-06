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

        <?php
        if (isset($error_message)) {
            echo '<h1 style="text-align: center;">' . $error_message . '</h1>';
            exit;
        }
        ?>

        <div style="height: auto; width: 280px;">
            <div id="receipt_wrapper" style="width: 280px;font-family: Arial; margin-top: -15px;">
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
                <div id="abc" style="clear:both;"></div>
                <div id="receipt_header" style="width: 280px;">
                    <div id="sale_receipt" style="text-transform: uppercase;text-align: center;font-weight: bold; margin: 10px auto;font-size: 12px;">
                        <?php echo 'Hóa đơn đặt hàng' ?>
                    </div>   
                </div>
                <div id="sale_time" style="font-size: 10px; width: 280px;">
                    <?php echo "Số phiếu: <b>" . $sale_id . "</b>" ?>&nbsp;&nbsp;&nbsp;<?php echo "Ngày: " . date('d-m-Y',  strtotime($transaction_time)) ?>
                </div>
                <div id="receipt_general_info" style="font-size: 10px; width: 280px;">
                    <p>Nhân viên bán hàng: <span class="color"><?php echo $employee; ?></span></p>
                    <p>Họ tên người mua hàng: <span class="color"><?php echo (isset($customer) ? $customer : "KHÁCH LẺ"); ?></span></p>
                    <?php if ($cus_name != "") { ?>
                        <p>Tên đơn vị: <span class="color" style="text-transform: uppercase"><?php echo $cus_name; ?></span></p>
                        <p>Địa chỉ: <span class="color"><?php echo $address; ?></span></p>
                    <?php } ?>
                    <?php $info_warehouse = $this->Create_invetory->get_info($store); ?>
                    <p>Kho: <?= $info_warehouse->name_inventory; ?></p>
                    <p>Địa chỉ kho: <?= $info_warehouse->address; ?></p>
                </div>
                <table class="new-font-size" style="border-collapse: collapse; width: 280px; font-size: 10px; margin-top: 10px;">
                    <tr>
                        <th style="border: 1px solid #000000; padding: 3px;">Mã MH</th>
                        <th style="border: 1px solid #000000; padding: 3px;">Sản phẩm</th>
                        <th style="border: 1px solid #000000; padding: 3px;">ĐVT</th>
                        <th style="border: 1px solid #000000; padding: 3px;">SL</th>
                        <th style="border: 1px solid #000000; padding: 3px;"><?php echo lang('common_price'); ?></th>                        
                        <th style="border: 1px solid #000000; padding: 3px;">CK (%)</th>
                        <th style="border: 1px solid #000000; padding: 3px;">Thuế (%)</th>
                        <th style="border: 1px solid #000000; padding: 3px;">Thành tiền</th>
                    </tr>
                    <?php
                    $total_discount_money = 0;
                    $total_payment = 0;
                    $total_taxes_percent = 0;
                    foreach ($payments as $payment) {
                        $total_payment += $payment['payment_amount'];
                        $total_discount_money += $payment['discount_money'];
                    }
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
                            <td style="width: 5%; border: 1px solid #000000; padding: 3px;">
    <?php echo $number_code; ?>
                            </td>
                            <td style="width: 33%;border: 1px solid #000000; padding: 3px;">
    <?php echo $item['name']; ?>
                            </td>
                            <td style="width: 6%; text-align: right; border: 1px solid #000000; padding: 3px;">
    <?php echo $unit_name->name; ?>
                            </td>
                            <td style="width: 6%; text-align: right;border: 1px solid #000000; padding: 3px;">
    <?php echo $item['quantity']; ?>
                            </td>
                            <td style="width: 16%; text-align: right; border: 1px solid #000000; padding: 3px;">
    <?php
    if ($item['unit'] == "unit") {
        echo to_currency_unVND_nomar($item['price']);
    } else {
        echo to_currency_unVND_nomar($item['price_rate']);
    }
    ?>
                            </td>                            
                            <td style="width: 6%; text-align: right;border: 1px solid #000000; padding: 3px;">
                                <?php echo $item['discount']; ?>
                            </td>
                            <td style="width: 6%; text-align: right;border: 1px solid #000000; padding: 3px;">
                                <?php echo $item['taxes']; ?>
                            </td>
                            <td style="width: 17%; text-align: right;border: 1px solid #000000; padding: 3px;">
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
                    }
                    ?>
                    <tr>
                        <td colspan="5" style="text-align: right;">Tổng tiền hàng:</td>
                        <td colspan="3" style="text-align: right; border-bottom: none">
                            <?php echo to_currency_unVND_nomar($total_order); ?>
                        </td>
                    </tr> 
                    <tr>
                        <td colspan="5" style="text-align: right;">Tổng thuế:</td>
                        <td colspan="3" style="text-align: right;">
                            <?php echo to_currency_unVND_nomar($total_taxes_percent) ?>
                        </td>
                    </tr>                                      
                    <tr>
                        <td colspan="5" style="text-align: right;">Tổng thanh toán:</td>
                        <td colspan="3" style="text-align: right; border-bottom: 1px dotted #000000;">
                            <?php echo to_currency_unVND_nomar($total_order + $total_taxes_percent) ?>
                        </td>
                    </tr>
                    <?php
                    $k = 1;
                    foreach ($payments as $payment) {
                        ?>
                        <tr>
                            <td colspan="5" style="text-align: right;">Khách đưa lần <?php echo $k; ?>:</td>
                            <td colspan="3" style="text-align: right; border-bottom: none;">
                                <?php echo to_currency_unVND_nomar($payment['payment_amount']) ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align: right;">Chiết khấu tiền mặt:</td>
                            <td colspan="3" style="text-align: right; border-bottom: 1px dotted #000000;">
                                <?php echo to_currency_unVND_nomar($payment['discount_money']) ?>
                            </td>
                        </tr>
                        <?php
                        $k++;
                    }
                    ?>                    
                    <tr>
                        <td colspan="8" style="text-align: center">
                            <div style="width: 100%; margin-top: 10px; border-top: 1px dotted #000000;"></div>
                            Quý khách vui lòng kiểm tra lại hóa đơn trước khi về.<br>
                            Giá chưa bao gồm HĐ VAT<br>
                            Xin cảm ơn quý khách. Hẹn gặp lại!
                        </td>
                    </tr>
                </table>
            </div>

            <!--huyenlt^^		-->
            <a href = "<?= site_url() . '/sales' ?>" id="submit" style="width:100px; color:#FFFFFF;" class="print_report" onclick = "this.style.display = 'none';
                    javascript:printDiv('receipt_wrapper')">In hóa đơn</a>

            <!-- uyen lam  -->
            <div id="form_excel_export">
                <!-- form post value for update data  -->

                <div id="value_to_update">
                    <?php //echo form_open("sales/update_all_sales_table");  ?>
                    <input type='hidden' value='<?php echo $sale_id; ?>' name='sale_id' class="sale_id">
                    <input type='hidden' value='<?php echo $total; ?>' name='total' class="total" > 
                    <input type='hidden' value='<?php echo $discount_money; ?>' name='money_discount' class="money_discount">
                    <input type='hidden' value='<?php echo $payment["payment_type"]; ?>' name='payment_type' class="type_payment">



                    <div id="result_update"></div>
                    <?php echo form_close(); ?>
                </div>
                <!-- end form post   -->
                <?php echo form_open("sales/export_excel"); ?>
                <input type='hidden' value='<?php echo $sale_id; ?>' name='sale_id'>
                <input type='hidden' value='<?php echo $discount_money; ?>' name='discount' class='discount'>
                <?php
                /* echo form_submit(array(
                  'name'=>'submit',
                  'id'=>'submit',
                  'value'=>'Xuất file excel',
                  'class'=>'submit_button_export_excel')
                  ); */
                ?>
                <?php echo form_close(); ?>
            </div>
        </div></div></div>
<!--huyenlt^^ -->
<script language="javascript" type="text/javascript">
    function printDiv(divID) {
        //Get the HTML of div
        var divElements = document.getElementById(divID).innerHTML;
        //Get the HTML of whole page
        //var oldPage = document.body.innerHTML;									

        //Reset the page's HTML with div's HTML only
        document.body.innerHTML =
                "<html><head><title></title></head><body>" +
                divElements + "</body>";
        //Print Page
        window.print();
        //Restore orignal HTML
        //document.body.innerHTML = oldPage;

    }
</script>
<!-- end huyenlt^^ -->
<script type="text/javascript">
    $(document).ready(function () {
        //window.print ();
//    	window.location="<?= site_url() . '/sales' ?>";
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

            //alert(type_pay);
        });

    });
</script>
