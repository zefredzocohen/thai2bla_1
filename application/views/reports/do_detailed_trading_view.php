<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <script src="<?php echo base_url(); ?>js/all.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
    </head>
    <body>
        <div id="content_area_wrapper">
            <div id="content_area">
                <div style="color:#000">
                    <div id="wrapper" style="margin-bottom:200px;">
                        <p style="font-size:12px; margin-left:200px;"><?php echo $this->config->item('company'); ?></p>
                        <p style="font-size:12px; margin-left:200px;"><?php echo $this->config->item('address'); ?></p>
                        <a style="font-size:18px;margin-right: 252px;text-decoration: underline; float: right;margin-bottom: 41px; margin-top: -34px" href="<?php echo base_url(); ?>reports/do_detailed_trading">Trở lại</a>

                        <h4 style="margin-left:200px;">BẢNG BÁO CÁO BÁN HÀNG: <?php echo date("d-m-Y H:i:s", strtotime($start_date)); ?> ĐẾN <?php echo date("d-m-Y H:i:s", strtotime($end_date)); ?></h4>
                        <table id="inventory_item">                            
                            <tr>
                                <th>Thời gian</th>
                                <th>Mã ĐH</th>
                                <th>Khách hàng</th>
                                <th>Mã MH</th>
                                <th>Tên MH</th>
                                <th>ĐVT</th>
                                <?php
//                                   $this->load->model('sale');
//                                   $num_row = $this->Sale->item_num_rows();
//                                   if($num_row > 0){
                                ?>
<!--                                <th>Chiều dài</th>
                                <th>Chiều rộng</th>
                                <th>Số lượng</th>-->
                                
                                   <?php //}?>
                                <th>TổngSL</th>
                                <th>Đơn giá</th>
                                <th>CK %</th>
                                <th>Thuế %</th>
                                <th>Thành tiền</th>
                                <th>CK TM</th>
                                <th>Thực thu</th>                               
                                <th>HTTT</th>
                                <th>Ghi chú</th>
                            </tr>
                            <?php
                            if($sales){
                                $total_quantity = 0;
                                foreach ($sales as $sale) {
                                    $data_sale_item = $this->Sale->get_item_in_sale($sale->sale_id);
                                    $data_sale_pack = $this->Sale->get_pack_in_sale($sale->sale_id);
                                    $data_sale = array_merge($data_sale_item, $data_sale_pack);
                                    $i = count($data_sale);
                                    if ($sale->customer_id) {
                                        if ($this->Customer->get_info($sale->customer_id)->company_name != NULL) {
                                            $name_customer = $this->Customer->get_info($sale->customer_id)->company_name;
                                        } else{
                                            $name_customer = $this->Customer->get_info($sale->customer_id)->first_name . " " . $this->Customer->get_info($sale->customer_id)->last_name;
                                        }                                        
                                    } else {
                                        $name_customer = "KHÁCH LẺ";
                                    }
                                    $info_sale = $this->Sale->get_info_sale($sale->sale_id);
                                    $k = 0;
                                    foreach ($data_sale as $value){
                                        $total_quantity += $value->quantity_purchased;
                                        if ($value->pack_id) {
                                            $number_item = $this->Pack->get_info($value->pack_id)->pack_number;
                                            $unit_name = $this->Unit->get_info($value->unit)->name;
                                            $item_unit_price = $value->pack_unit_price;
                                        } else {
                                            $number_item = $this->Item->get_info($value->item_id)->item_number;                                            
                                                if ($value->unit_item == $value->unit_from) {
                                                    $unit_name = $this->Unit->get_info($value->unit_from)->name;
                                                    $item_unit_price = $value->item_unit_price_rate;
                                                } else {
                                                    $unit_name = $this->Unit->get_info($value->unit)->name;
                                                    $item_unit_price = $value->item_unit_price;
                                                }
                                        }
                                        
                                        $gia = $value->quantity_purchased * $item_unit_price;
                                        $chietkhau = ($value->quantity_purchased * $item_unit_price * $value->discount_percent) / 100;
                                        $total_money_tax = ($value->quantity_purchased * $item_unit_price - ($value->quantity_purchased * $item_unit_price * $value->discount_percent) / 100) * $value->taxes_percent / 100;
                                        $tong_cot += ($gia - $chietkhau + $total_money_tax);
                                        $k++;
                                        echo "<tr>";
                                        if ($i > 1) {
                                            if ($k == 1) {
                                                echo "<td rowspan=" . $i . " style='text-align: center; width: 7%'>" .date("d-m-Y", strtotime($sale->sale_time)) . "</td>";
                                                echo "<td rowspan=" . $i . " style='text-align: center; width: 3%'>" . $sale->sale_id . "</td>";
                                                echo "<td rowspan=" . $i . " style='width: 9%'>" . $name_customer . "</td>";
                                            }
                                        } else {
                                            echo "<td style='text-align: center; width: 7%'>" . date("d-m-Y H:i:s", strtotime($sale->sale_time)) . "</td>";
                                            echo "<td style='text-align: center; width: 3%'>" . $sale->sale_id . "</td>";
                                            echo "<td style='width: 9%'>" . $name_customer . "</td>";
                                        }                                        
                                        echo "<td style='text-align: center; width: 7%'>$number_item</td>";
                                        echo "<td style='width: 14%'>$value->name</td>";
                                        echo "<td style='width: 5%'>$unit_name</td>";
                                        
//                                        $this->load->model('sale');
//                                            $num_row = $this->Sale->item_num_rows();
//                                            if($num_row > 0){
//                                                
//                                                if($value->m2_length == 0){
//                                                      echo "<td style='text-align: right; width: 5%'>N/A</td>";
//                                                }else{
//                                                      echo "<td style='text-align: right; width: 5%'>".$value->m2_length."</td>";
//                                                }
//                                                                           
//                                               if($value->m2_width == 0){
//                                                      echo "<td style='text-align: right; width: 5%'>N/A</td>";
//                                                }else{
//                                                      echo "<td style='text-align: right; width: 5%'>".$value->m2_width."</td>";
//                                                }
//                                                
//                                                if($value->m2_quantity == 0){
//                                                      echo "<td style='text-align: right; width: 5%'>N/A</td>";
//                                                }else{
//                                                      echo "<td style='text-align: right; width: 5%'>".$value->m2_quantity."</td>";
//                                                }
//                                         }
//                                        
                                        echo "<td style='text-align: right; width: 3%'>".format_quantity($value->quantity_purchased)."</td>";
                                        echo "<td style='text-align: right; width: 7%'>".number_format($item_unit_price)."</td>";
                                        echo "<td style='text-align: right; width: 5%'>$value->discount_percent</td>";
                                        echo "<td style='text-align: right; width: 5%'>".($value->taxes ? $value->taxes : 0)."</td>";
                                        echo "<td style='text-align: right; width: 9%'>".number_format($gia - $chietkhau + $total_money_tax)."</td>";
                                        
                                        $form_payment = $this->Sale->get_form_payment($sale->sale_id);
                                        $form_payment_name = "";
                                        $pays_money = 0;
                                        $pays_discount = 0;
                                        foreach ($form_payment as $val) {
                                            $form_payment_name .= $val->pays_type . ", ";
                                        }
                                        $payments = $this->Sale->get_payment_sale_by_sale_id($sale->sale_id);
                                        foreach ($payments as $v) {
                                            $pays_money += $v['payment_amount'];
                                            $pays_discount += $v['discount_money'];
                                        }
                                        if ($i > 1) {
                                            if ($k == 1) {
                                                echo "<td rowspan='" . $i . "' style='text-align: right; width: 5%'>" . number_format($pays_discount) . "</td>";
                                                echo "<td rowspan='" . $i . "' style='text-align: right; width: 5%'>" . number_format($pays_money) . "</td>";
                                                echo "<td rowspan='" . $i . "' style='width: 7%'>" . rtrim($form_payment_name, ", ") . "</td>";
                                                echo "<td rowspan='" . $i . "' style='width: 10%'>" . $info_sale['comment'] . "</td>";
                                            }
                                        } else {
                                            echo "<td rowspan='" . $i . "' style='text-align: right; width: 5%'>" . number_format($pays_discount) . "</td>";
                                            echo "<td rowspan='" . $i . "' style='text-align: right; width: 5%'>" . number_format($pays_money) . "</td>";                                          
                                            echo "<td rowspan='" . $i . "' style='width: 7%'>" . rtrim($form_payment_name, ", ") . "</td>";
                                            echo "<td rowspan='" . $i . "' style='width: 10%'>" . $info_sale['comment'] . "</td>";
                                        }
                                        echo "</tr>";
                                    }
                                    $tong_pays_money += $pays_money;
                                    $tong_pays_discount += $pays_discount;
                                }
                            }
                            ?>
                            <tr style="font-weight: bold">
                                <td colspan="3" style="text-align: center">Tổng</td>
                               
                                <td></td>
                                <td></td>
                                <td></td>
                                 <td style="text-align: right"><?= format_quantity($total_quantity); ?></td>
                                 <td></td>
                                <td style="text-align: right"><?= number_format($tong_pays_discount); ?></td>
                                <td></td>
                                
                                <td style="text-align: right"><?= number_format($tong_cot); ?></td>
                                
                                <td></td>
                                <td style="text-align: right"><?= number_format($tong_pays_money); ?></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                        <table style="margin:30px auto; width:70%">
                            <tr>
                                <td style="text-align:right;margin-right:20px;" colspan="3"><i>Ngày: <?php echo date('d-m-Y'); ?></i></td>
                            </tr>
                            <tr>
                                <td width="30%">Người lập biểu
                                    <p><i>(Ký tên)</i></p>
                                </td>
                                <td width="30%" style="text-align:center;">Kế toán trưởng<p><i>(Ký tên)</i></p></td>
                                <td width="40%" style="text-align:right;">Giám đốc<p><i>(Ký tên)</i></p></td>
                            </tr>
                        </table>
                        <div>
                            <button style="margin-left:200px;width:87px;" class="submit_button" id="print_button" onClick="print_receipt()" > <?php echo lang('sales_print'); ?> </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<script type="text/javascript">
    function print_receipt()
    {
        $('#print_button').hide();
        window.print();
    }
</script>
<style type="text/css">
    #wrapper{
        margin:10px auto;
    }
    table#inventory_item{        
        margin:10px auto;
        border-collapse: collapse;
        font-size: 13px;
        width: 1024px;
    }
    #inventory_item tr th{
        border:1px solid #CCCCCC;
        padding:4px 3px;
        background: #428BCA;
        color: #FFFFFF;
    }
    table#inventory_item tr td{
        border:1px solid #CCCCCC;
        padding:3px 3px;
        /*background: #CCCCCC;*/
    }
    #inventory_item .alt td{
        background: #FFFFFF;
    }
</style>