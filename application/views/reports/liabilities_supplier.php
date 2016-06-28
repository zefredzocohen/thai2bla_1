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
            #table_liablity_supplier {
                width: 960px;
                margin: 15px auto;
                border-collapse: collapse;
                font-size: 12px;
            }

            #table_liablity_supplier tr th {
                text-align: center;
                padding: 7px 5px;
                background: #1e5a96;
                color: #FFFFFF;
            }
            #table_liablity_supplier tr td {
                padding: 4px 5px;
                border: 1px solid #cdcdcd;
            }
        </style>
        <table id="title_bar">
            <tr>
                <td id="title_icon">
                    <img src='<?php echo base_url() ?>images/menubar/reports.png' alt='<?php echo lang('reports_reports'); ?>'/>
                </td>
                <td id="title"><?php echo $title ?></td>
                <td>
                    <a style="font-size:18px;text-decoration: underline; color: #FFF" href="<?php echo base_url(); ?>reports/liabilities_supplier">Trở lại</a>
                </td>
            </tr>            
        </table>
        <div style="width: 100%;"><?= $subtitle; ?></div>
        <table id="table_liablity_supplier">            
            <thead>
                <tr>
                    <th>Nhà cung cấp/Mã ĐH</th>
                    <th>Giá trị ĐH</th>
                    <th>Chiết khấu ĐH</th>
                    <th>Tổng thanh toán (Bao gồm cả thuế và chi phí)</th>
                    <th>Đã thanh toán</th>
                    <th>Còn nợ </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $data_sup = array();
                if ($supplier_id) {
                    $data_sup[] = array("supplier_id" => $supplier_id);
                } else {
                    $data_list_supplier = $this->Supplier->get_all_supplier();
                    foreach ($data_list_supplier as $sup) {
                        $data_sup[] = array("supplier_id" => $sup['person_id']);
                    }
                }
                $total_gia_tri_dh = 0;
                $total_chiet_khau = 0;
                $total_tong_thanh_toan = 0;
                $total_da_thanh_toan = 0;
                $total_con_no = 0;
                $total_taxe = 0;//tổng thuế
                $total_other_cost = 0;//tổng chi phí
                foreach ($data_sup as $d_s) {
                    $data_receiving_supplier = $this->Receiving->get_supplier_owe($d_s['supplier_id'], $start_date, $end_date);
                    $sub_gia_tri_dh = 0;
                    $sub_chiet_khau = 0;
                    $sub_tong_thanh_toan = 0;
                    $sub_da_thanh_toan = 0;
                    $sub_con_no = 0;
                    if ($data_receiving_supplier) {
                        foreach ($data_receiving_supplier as $val) {
                            $total_taxe += $this->Receiving->get_info($val['receiving_id'])->row()->money_1331;
                            $total_other_cost += $this->Receiving->get_info($val['receiving_id'])->row()->other_cost;
                            $receiving_items = $this->Receiving->get_item_receiving2($val['receiving_id'])->result();
                            $gia_tri_dh = 0;
                            $chiet_khau = 0;
                            $da_thanh_toan = 0;
                            foreach ($receiving_items as $val1) {
                                if ($val1->rate_currency) {
                                    $gia_tri_dh += $val1->quantity_purchased * $val1->item_unit_price * $val1->rate_currency - $val1->quantity_purchased * $val1->item_unit_price * $val1->rate_currency * $val1->discount_percent / 100 + ($val1->quantity_purchased * $val1->item_unit_price * $val1->rate_currency - $val1->quantity_purchased * $val1->item_unit_price * $val1->rate_currency * $val1->discount_percent / 100) * $val1->taxes / 100;
                                } else {
                                    $gia_tri_dh += $val1->quantity_purchased * $val1->item_unit_price - $val1->quantity_purchased * $val1->item_unit_price * $val1->discount_percent / 100;
                                }
                            }
                            $receiving_tam = $this->Receiving->get_receiving_tam_by_id($val['receiving_id']);
                            foreach ($receiving_tam as $r_t) {
                                $da_thanh_toan += $r_t->pays_amount;
                                $chiet_khau += $r_t->discount_money;
                            }
                            $sub_gia_tri_dh += $gia_tri_dh;
                            $sub_chiet_khau += $chiet_khau;
                            $sub_tong_thanh_toan += ($gia_tri_dh + $this->Receiving->get_info($val['receiving_id'])->row()->money_1331 + $this->Receiving->get_info($val['receiving_id'])->row()->other_cost- $chiet_khau);
                            $sub_da_thanh_toan += $da_thanh_toan;
                            $sub_con_no += ($gia_tri_dh + $total_taxe + $total_other_cost - $chiet_khau - $da_thanh_toan);
                        }
                        $total_gia_tri_dh += $sub_gia_tri_dh;
                        $total_chiet_khau += $sub_chiet_khau;
                        $total_tong_thanh_toan += $sub_tong_thanh_toan;
                        $total_da_thanh_toan += $sub_da_thanh_toan;
                        $total_con_no += $sub_con_no;
                        $info_sup = $this->Supplier->get_info($d_s['supplier_id']);
                        echo "<tr style='font-weight: bold; background: #E2E2E2'>";
                        echo "<td>" .$info_sup->company_name . "</td>";
                        echo "<td style='text-align: right;'>" . number_format($sub_gia_tri_dh) . "</td>";
                        echo "<td style='text-align: right;'>" . number_format($sub_chiet_khau) . "</td>";
                        echo "<td style='text-align: right;'>" . number_format($sub_tong_thanh_toan) . "</td>";
                        echo "<td style='text-align: right;'>" . number_format($sub_da_thanh_toan) . "</td>";
                        echo "<td style='text-align: right;'>" . number_format($sub_con_no) . "</td>";
                        echo "</tr>";
                        foreach ($data_receiving_supplier as $val) {
                            $receiving_items = $this->Receiving->get_item_receiving2($val['receiving_id'])->result();
                            $gia_tri_dh1 = 0;
                            $chiet_khau1 = 0;
                            $da_thanh_toan = 0;
                            $con_no = 0;
                            foreach ($receiving_items as $val1) {
                                if ($val1->rate_currency) {
                                    $gia_tri_dh1 += $val1->quantity_purchased * $val1->item_unit_price * $val1->rate_currency - $val1->quantity_purchased * $val1->item_unit_price * $val1->rate_currency * $val1->discount_percent / 100 + ($val1->quantity_purchased * $val1->item_unit_price * $val1->rate_currency - $val1->quantity_purchased * $val1->item_unit_price * $val1->rate_currency * $val1->discount_percent / 100) * $val1->taxes / 100;
                                } else {
                                    $gia_tri_dh1 += $val1->quantity_purchased * $val1->item_unit_price - $val1->quantity_purchased * $val1->item_unit_price * $val1->discount_percent / 100 ;
                                }
                            }

                            $receiving_tam = $this->Receiving->get_receiving_tam_by_id($val['receiving_id']);
                            foreach ($receiving_tam as $r_t) {
                                $da_thanh_toan += $r_t->pays_amount;
                                $chiet_khau1 += $r_t->discount_money;
                            }
                            echo "<tr>";
                            echo "<td style='width: 10%; text-align: center'>" . $val['receiving_id'] . "</td>";
                            echo "<td style='width: 12%; text-align: right'>" . number_format($gia_tri_dh1 ) . "</td>";
                            echo "<td style='width: 12%; text-align: right'>" . number_format($chiet_khau) . "</td>";
                            echo "<td style='width: 12%; text-align: right'>" . number_format($gia_tri_dh1 + $this->Receiving->get_info($val['receiving_id'])->row()->money_1331 + $this->Receiving->get_info($val['receiving_id'])->row()->other_cost - $chiet_khau1) . "</td>";
                            echo "<td style='width: 12%; text-align: right'>" . number_format($da_thanh_toan) . "</td>";
                            echo "<td style='width: 12%; text-align: right'>" . number_format($gia_tri_dh1+ $this->Receiving->get_info($val['receiving_id'])->row()->money_1331 + $this->Receiving->get_info($val['receiving_id'])->row()->other_cost - $chiet_khau1 - $da_thanh_toan) . "</td>";
                            echo "</tr>";
                        }
                    }
                }
                echo "<tr style='background: #9A9A9A; font-weight: bold'>";
                echo "<td style='text-align: center'>Tổng</td>";
                echo "<td style='text-align: right'>" . number_format($total_gia_tri_dh) . "</td>";
                echo "<td style='text-align: right'>" . number_format($total_chiet_khau) . "</td>";
                echo "<td style='text-align: right'>" . number_format($total_tong_thanh_toan) . "</td>";
                echo "<td style='text-align: right'>" . number_format($total_da_thanh_toan) . "</td>";
                echo "<td style='text-align: right'>" . number_format($total_con_no) . "</td>";
                echo "</tr>";
                ?>    
            </tbody>

        </table>
        <input id="submit" name="submit" class="print_report" value="In hóa đơn" onclick="this.style.display = 'none'" />
    </div>
</div>
<?php $this->load->view("partial/footer"); ?>
<script type="text/javascript" language="javascript">
    $(document).ready(function () {
        $(".tablesorter a.expand").click(function (event) {
            console.log('abcd');
            $(event.target).parent().parent().next().find('td.innertable').toggle();

            if ($(event.target).text() == '+') {
                $(event.target).text('-');
            } else {
                $(event.target).text('+');
            }
            return false;
        });

        $(".tablesorter a.expand_all").click(function (event) {
            $('td.innertable').toggle();

            if ($(event.target).text() == '+') {
                $(event.target).text('-');
            } else {
                $(event.target).text('+');
            }
            return false;
        });
    });
</script>