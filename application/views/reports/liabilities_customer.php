<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
    <div id="content_area" style="height: auto;float: left;">
        <script type="text/javascript">
            $(document).ready(function () {
                $(".print_report1").click(function () {
                    window.print();
                });
                $(".print_report").click(function () {
                    window.print();
                });
            });
        </script>
        <style type="text/css">
            #table_liabilities_customer {
                width: 960px;
                margin: 15px auto;
                border-collapse: collapse;
                font-size: 12px;
            }

            #table_liabilities_customer tr th {
                text-align: center;
                padding: 7px 5px;
                background: #1e5a96;
                color: #FFFFFF;
            }
            #table_liabilities_customer tr td {
                padding: 4px 5px;
                border: 1px solid #cdcdcd;
            }
            .print_report{
                background: none repeat scroll 0 0 #1E5A96;
                border: 1px solid #EEEEEE;
                color: #FFFFFF;
                font-size: 14px;
                font-weight: bold;
                line-height: 30px;
                margin-left: 9px;
                padding: 5px;
                text-align: center;
                width: 100px;
            }
        </style>
        <table id="title_bar">
            <tr>
                <td id="title_icon">
                    <img src='<?php echo base_url() ?>images/menubar/reports.png' alt='<?php echo lang('reports_reports'); ?> - <?php echo lang('reports_welcome_message'); ?>' />
                </td>
                <td id="title">Báo cáo công nợ khách hàng</td>
                <td>
                    <a style="font-size:18px;text-decoration: underline; color: #FFF" href="<?php echo base_url(); ?>reports/liabilities_customer">Trở lại</a>
                </td>
            </tr>            
        </table>        
        <div style="width: 100%;"><?= $subtitle; ?></div>
        <table id="table_liabilities_customer">
            <thead>
                <tr>
                    <th>Khách hàng/Mã ĐH</th>
                    <th>Tổng GT đơn hàng</th>
                    <th>CK ĐH</th>
                    <th>Tổng thanh toán</th>
                    <th>Đã thanh toán</th>
                    <th>Còn nợ</th>
                </tr>                                
            </thead>
            <tbody>
                <?php
                $data_cus = array();
                if ($customer_id) {
                    $data_cus[] = array("person_id" => $customer_id);
                } else {
                    $customer = $this->Customer->get_list_customer();
                    foreach ($customer as $c) {
                        $data_cus[] = array("person_id" => $c->person_id);
                    }
                }
                $total_gtdh = 0;
                $total_ckdh = 0;
                $total_tt = 0;
                $total_da_tt = 0;
                $total_con_no = 0;
                foreach ($data_cus as $cus) {
                    $data_sale_customer = $this->Sale->get_sale_suspended_by_customer($cus['person_id'], $start_date, $end_date);
                    $sub_total_price = 0;
                    $sub_tong_don_hang = 0;
                    $sub_ckdh = 0;
                    $sub_tong_thanh_toan = 0;
                    $sub_da_thanh_toan = 0;
                    $sub_con_no = 0;
                    if ($data_sale_customer) {
                        foreach ($data_sale_customer as $sale_cus) {
                            $sale_item = $this->Sale->get_item_in_sale($sale_cus->sale_id);
                            $sale_pack = $this->Sale->get_pack_in_sale($sale_cus->sale_id);
                            $data_sale_item_pack = array_merge($sale_item, $sale_pack);
                            $total_price = 0;
                            $tong_don_hang = 0;
                            $ckdh = 0;
                            $tong_thanh_toan = 0;
                            $da_thanh_toan = 0;
                            $con_no = 0;
                            foreach ($data_sale_item_pack as $val) {
                                if ($val->item_id) {
                                    $info_item = $this->Item->get_info($val->item_id);
                                    if ($info_item->unit_from) {
                                        if ($info_item->unit_from == $val->unit_item) {
                                            $total_price += $val->quantity_purchased * $val->item_unit_price_rate - $val->quantity_purchased * $val->item_unit_price_rate * $val->discount_percent / 100 + ($val->quantity_purchased * $val->item_unit_price_rate - $val->quantity_purchased * $val->item_unit_price_rate * $val->discount_percent / 100) * $val->taxes_percent / 100;
                                        } else {
                                            $total_price += $val->quantity_purchased * $val->item_unit_price - $val->quantity_purchased * $val->item_unit_price * $val->discount_percent / 100 + ($val->quantity_purchased * $val->item_unit_price - $val->quantity_purchased * $val->item_unit_price * $val->discount_percent / 100) * $val->taxes_percent / 100;
                                        }
                                    } else {
                                        $total_price += $val->quantity_purchased * $val->item_unit_price - $val->quantity_purchased * $val->item_unit_price * $val->discount_percent / 100 + ($val->quantity_purchased * $val->item_unit_price - $val->quantity_purchased * $val->item_unit_price * $val->discount_percent / 100) * $val->taxes_percent / 100;
                                    }
                                } else {
                                    $total_price += $val->quantity_purchased * $val->pack_unit_price - $val->quantity_purchased * $val->pack_unit_price * $val->discount_percent / 100 + ($val->quantity_purchased * $val->pack_unit_price - $val->quantity_purchased * $val->pack_unit_price * $val->discount_percent / 100) * $val->taxes->percent / 100;
                                }
                            }
                            //Lay tong tien chiet khau tren hoa don
                            $sales_tam = $this->Sale->get_sales_tam($val->sale_id);
                            foreach ($sales_tam as $s_t) {
                                $da_thanh_toan += $s_t['pays_amount'];
                                $ckdh += $s_t['discount_money'];
                            }
                            $sub_total_price += $total_price;
                            $sub_ckdh += $ckdh;
                            $sub_tong_thanh_toan += $total_price - $ckdh;
                            $sub_da_thanh_toan += $da_thanh_toan;
                            $sub_con_no += $total_price - $ckdh - $da_thanh_toan;
                        }
                        $total_gtdh += $sub_total_price;
                        $total_ckdh += $sub_ckdh;
                        $total_tt += $sub_tong_thanh_toan;
                        $total_da_tt += $sub_da_thanh_toan;
                        $total_con_no += $sub_con_no;
                        $info_cus = $this->Customer->get_info($cus['person_id']);
                        $cus_name = $info_cus->company_name != "" ? $info_cus->company_name : ($info_cus->first_name . " " . $info_cus->last_name);
                        echo "<tr style='font-weight: bold; background: #E2E2E2'>";
                        echo "<td>" . $cus_name . "</td>";
                        echo "<td style='text-align: right'>" . number_format($sub_total_price) . "</td>";
                        echo "<td style='text-align: right'>" . number_format($sub_ckdh) . "</td>";
                        echo "<td style='text-align: right'>" . number_format($sub_tong_thanh_toan) . "</td>";
                        echo "<td style='text-align: right'>" . number_format($sub_da_thanh_toan) . "</td>";
                        echo "<td style='text-align: right'>" . number_format($sub_con_no) . "</td>";
                        echo "</tr>";
                        foreach ($data_sale_customer as $sale_cus) {
                            $sale_item = $this->Sale->get_item_in_sale($sale_cus->sale_id);
                            $sale_pack = $this->Sale->get_pack_in_sale($sale_cus->sale_id);
                            $data_sale_item_pack = array_merge($sale_item, $sale_pack);
                            $total_price = 0;
                            $tong_don_hang = 0;
                            $ckdh = 0;
                            $tong_thanh_toan = 0;
                            $da_thanh_toan = 0;
                            $con_no = 0;
                            foreach ($data_sale_item_pack as $val) {
                                if ($val->item_id) {
                                    $info_item = $this->Item->get_info($val->item_id);
                                    if ($info_item->unit_from) {
                                        if ($info_item->unit_from == $val->unit_item) {
                                            $total_price += $val->quantity_purchased * $val->item_unit_price_rate - $val->quantity_purchased * $val->item_unit_price_rate * $val->discount_percent / 100 + ($val->quantity_purchased * $val->item_unit_price_rate - $val->quantity_purchased * $val->item_unit_price_rate * $val->discount_percent / 100) * $val->taxes_percent / 100;
                                        } else {
                                            $total_price += $val->quantity_purchased * $val->item_unit_price - $val->quantity_purchased * $val->item_unit_price * $val->discount_percent / 100 + ($val->quantity_purchased * $val->item_unit_price - $val->quantity_purchased * $val->item_unit_price * $val->discount_percent / 100) * $val->taxes_percent / 100;
                                        }
                                    } else {
                                        $total_price += $val->quantity_purchased * $val->item_unit_price - $val->quantity_purchased * $val->item_unit_price * $val->discount_percent / 100 + ($val->quantity_purchased * $val->item_unit_price - $val->quantity_purchased * $val->item_unit_price * $val->discount_percent / 100) * $val->taxes_percent / 100;
                                    }
                                } else {
                                    $total_price += $val->quantity_purchased * $val->pack_unit_price - $val->quantity_purchased * $val->pack_unit_price * $val->discount_percent / 100 + ($val->quantity_purchased * $val->pack_unit_price - $val->quantity_purchased * $val->pack_unit_price * $val->discount_percent / 100) * $val->taxes->percent / 100;
                                }
                            }
                            //Lay tong tien chiet khau tren hoa don
                            $sales_tam = $this->Sale->get_sales_tam($val->sale_id);
                            foreach ($sales_tam as $s_t) {
                                $da_thanh_toan += $s_t['pays_amount'];
                                $ckdh += $s_t['discount_money'];
                            }

                            echo "<tr>";
                            echo "<td style='width: 16%; text-align: center'>" . $sale_cus->sale_id . "</td>";
                            echo "<td style='width: 16%; text-align: right'>" . number_format($total_price) . "</td>";
                            echo "<td style='width: 16%; text-align: right'>" . number_format($ckdh) . "</td>";
                            echo "<td style='width: 16%; text-align: right'>" . number_format($total_price - $ckdh) . "</td>";
                            echo "<td style='width: 16%; text-align: right'>" . number_format($da_thanh_toan) . "</td>";
                            echo "<td style='width: 16%; text-align: right'>" . number_format($total_price - $ckdh - $da_thanh_toan) . "</td>";
                            echo "</tr>";
                        }
                    }
                }
                ?>
                <tr style='font-weight: bold; background: #9A9A9A'>
                    <td style='text-align: center'>Tổng</td>
                    <td style='text-align: right;'><?= number_format($total_gtdh) ?></td>
                    <td style='text-align: right;'><?= number_format($total_ckdh) ?></td>
                    <td style='text-align: right;'><?= number_format($total_tt) ?></td>
                    <td style='text-align: right;'><?= number_format($total_da_tt) ?></td>
                    <td style='text-align: right;'><?= number_format($total_con_no) ?></td>
                </tr>
            </tbody> 
        </table>
        <input id="submit" name="submit" class="print_report" value="In hóa đơn" onclick="this.style.display = 'none'" />
    </div>
</div>
<?php $this->load->view("partial/footer"); ?>
<script type="text/javascript" language="javascript">
    $(document).ready(function ()
    {
        $(".tablesorter a.expand").click(function (event)
        {
            console.log('abcd');
            $(event.target).parent().parent().next().find('td.innertable').toggle();

            if ($(event.target).text() == '+')
            {
                $(event.target).text('-');
            }
            else
            {
                $(event.target).text('+');
            }
            return false;
        });

        $(".tablesorter a.expand_all").click(function (event)
        {
            $('td.innertable').toggle();

            if ($(event.target).text() == '+')
            {
                $(event.target).text('-');
            }
            else
            {
                $(event.target).text('+');
            }
            return false;
        });
    });
</script>