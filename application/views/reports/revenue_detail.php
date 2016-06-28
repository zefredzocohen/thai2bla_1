<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
    <div id="content_area"><script type="text/javascript">

        $(document).ready(function () {
            $(".print_report1").click(function () {
                window.print();
            });

            $(".print_report").click(function ()
            {

                window.print();
            });

        });
        </script>
        <style type="text/css">
            .print_report {
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
                cursor: pointer;
            }
        </style>
        <table id="title_bar">
            <tr>
                <td id="title_icon"><img
                        src='<?php echo base_url() ?>images/menubar/reports.png'
                        alt='<?php echo lang('reports_reports'); ?> - <?php echo lang('reports_welcome_message'); ?>' />
                </td>
                <td id="title"><?php echo $title ?></td>
                <td><a
                        style="font-size: 18px; text-decoration: underline; color: #FFF;"
                        href="<?php echo base_url(); ?>reports/revenue_employee">Trở
                        lại</a></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><small><?php echo $subtitle ?></small></td>
                <td></td>
            </tr>
        </table>
        <br />

        <div style="margin-top: -8px; margin-bottom: 5px;">
            <h3>Lịch sử giao dịch</h3>
        </div>
        <table id="contents">
            <tr>
                <td id="item_table">
                    <div id="table_holder" style="width: 960px;">
                        <table class="tablesorter report" id="sortable_table">
                            <thead>
                                <tr>
                                    <th><a href="#" class="expand_all" style="font: 17px solid">+</a></th>
                                    <th>Mã ĐH</th>
                                    <th>Ngày</th>
                                    <th>Tên khách hàng</th>
                                    <th>Số lượng</th>
                                    <th>Giá trị đơn hàng</th>
                                    <th>Tổng chiết khấu</th>
                                    <th>Thuế</th>
                                    <th>Doanh thu</th>
                                    <?php if ($report_type == 'all') { ?>
                                        <th>Thực thu</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_cost = 0;
                                $total_discount = 0;
                                $total_real = 0;
                                foreach ($data_all_sale as $key => $val) {
                                    foreach ($val as $key1 => $val1) { 
                                        ?>
                                        <tr>
                                            <td><a href="#" class="expand" style="font: 17px solid">+</a></td>
                                            <td><a href="#">ĐH&nbsp;<?= $key ?></a></td>
                                            <td><?= date('d-m-Y H:i:s', strtotime($val1['date_tam'])) ?></td>
                                            <?php
                                               if($this->Customer->get_info($val1['pid'])->company_name != NULL){
                                                   $name = $this->Customer->get_info($val1['pid'])->company_name;
                                               }elseif($this->Customer->get_info($val1['pid'])->manages_name != NULL){
                                                   $name = $this->Customer->get_info($val1['pid'])->manages_name;
                                               }else{
                                                   $name = $val1['first_name'].' '.$val1['last_name'];
                                               }
                                            ?>
                                            <td><?= $name; ?></td>
                                            <?php
                                            foreach ($info_total_sale as $key2 => $val2) {
                                                if ($key2 == $key) {
                                                    $total_price = 0;
                                                    $total_item = 0;
                                                    $discount_money = 0;
                                                    foreach ($detail_sale as $key3 => $val3) {
                                                        if ($key3 == $key) {
                                                            foreach ($val3 as $key4 => $val4) {
                                                                foreach ($val4 as $key5 => $val5) {
                                                                    $price = $val5['unit_item'] == $val5['unit'] ? $val5['item_unit_price'] : $val5['item_unit_price_rate'];
                                                                    $total_item += $val5['quantity_purchased'];
                                                                    $discount_money += $price * $val5['discount_percent'] / 100 * $val5['quantity_purchased'];
                                                                    $total_price += ($price * $val5['quantity_purchased']);
                                                                }
                                                            }
                                                        }
                                                    }
                                                    //tien chiet khau = ( tong so luong * tien chiet khau % ) + chiet khau tien mat
                                                    $discount_money_total = $report_type == 'all' ? $discount_money + $val1['discount_money2'] : $discount_money;
                                                    ?>
                                            <td style="text-align: center"><?= format_quantity($total_item); ?></td>
                                                    <td style="text-align: right"><?= (($key1 == 0) && ($val1['liability'] == 0)) ? number_format($total_price) : '' ?></td>
                                                    <td style="text-align: right"><?= number_format($discount_money_total) ?></td>
                                                    <?php
                                                    $tien_thue = 0;
                                                    foreach ($detail_sale as $key3 => $val3) {
                                                        if ($key3 == $key) {
                                                            foreach ($val3 as $key4 => $val4) {
                                                                foreach ($val4 as $key5 => $val5) {
                                                                    $price = $val5['unit_item'] == $val5['unit'] ? $val5['item_unit_price'] : $val5['item_unit_price_rate'];
                                                                    $discount_money2 = $price * $val5['discount_percent'] / 100 * $val5['quantity_purchased'];
                                                                    $total_price2 = ($price * $val5['quantity_purchased']);
                                                                    $tien_thue += ($total_price2 - $discount_money2) / 100 * $val5['taxes'];
                                                                }
                                                            }
                                                        }
                                                    }
                                                    $doanh_thu = $total_price - $discount_money_total + $tien_thue;
                                                    ?>
                                                    <td style="text-align: right"><?= number_format($tien_thue) ?></td>
                                                    <td style="text-align: right"><?= (($key1 == 0) && ($val1['liability'] == 0)) ? number_format($doanh_thu) : '' ?></td>
                                                    <?php
                                                    if (($key1 == 0) && ($val1['liability'] == 0)) {
                                                        $total_cost += $doanh_thu;
                                                    }
                                                }
                                            }
                                            if ($report_type == 'all') {
                                                if($val1['pays_amount2'] >= $doanh_thu){
                                                ?>
                                                <td style="text-align: right"><?= number_format($doanh_thu) ?></td>
                                                <?php }else{?>
                                                <td style="text-align: right"><?= number_format($val1['pays_amount2']) ?></td>
                                                <?php }?>
                                            <?php
                                            }
                                            $total_real += $val1['pays_amount2'];
                                            $total_discount += $discount_money_total;
                                            ?>
                                        </tr>
                                        <tr>
                                            <td colspan="13" class="innertable"
                                                style="font-size: 0.95em !important;">
                                                <table class="innertable">
                                                    <thead>
                                                        <tr>
                                                            <th>Mã MH</th>
                                                            <th>Tên MH</th>
                                                            <th>ĐVT</th>
                                                            <th>Số lượng</th>
                                                            <th>Giá bán</th>
                                                            <th>CK %</th>
                                                            <th>Thuế %</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($detail_sale as $key3 => $val3) {
                                                            if ($key3 == $key) {
                                                                foreach ($val3 as $key4 => $val4) {
                                                                    foreach ($val4 as $key5 => $val5) {
                                                                        $price = $val5['unit_item'] == $val5['unit'] ? $val5['item_unit_price'] : $val5['item_unit_price_rate'];
                                                                        ?>
                                                                        <tr>
                                                                            <td style="text-align: center"><?= $val5['item_number'] ?></td>
                                                                            <td style="text-align: center"><?= $val5['name'] ?></td>
                                                                            <td style="text-align: center"><?= $this->Unit->get_info($val5['unit_item'] == $val5['unit'] ? $val5['unit'] : $val5['unit_from'])->name ?>
                                                                            </td>
                                                                            <td style="text-align: center"><?= format_quantity($val5['quantity_purchased']); ?></td>
                                                                            <td style="text-align: center"><?= number_format($price) ?></td>
                                                                            <td style="text-align: center"><?= $val5['discount_percent'] ?></td>
                                                                            <td style="text-align: center"><?= $val5['taxes']; ?></td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
        <?php
    }
}
?>
                            </tbody>
                        </table>
                    </div>
                    <div id="report_summary" class="tablesorter report"
                         style="margin-right: 10px;">
                        <div class="summary_row"><strong>Tổng doanh thu: </strong><?= to_currency($total_cost) ?></div>
                        <div class="summary_row"><strong>Tổng chiết khấu: </strong><?= to_currency($total_discount) ?></div>
<?php if ($report_type == 'all') { ?>
                            <div class="summary_row"><strong>Tổng thực thu: </strong><?= to_currency($total_real) ?></div>
<?php } ?>
                    </div>
                </td>
            </tr>
        </table>
        <input id="submit" name="submit" class="print_report" value="In hóa đơn"
               onclick="this.style.display = 'none'" /></div>
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
