
<?php $sum_money = 0; ?>
<?php
if ($num_rows > 0) {
    foreach ($sale_complete_invs as $sale_complete) {
        ?>
        <tr class="row_inventory_sale">

            <td class="row_sale_id" style="text-align: center;"><a href="<?php echo base_url(); ?>customers/switch_sale/<?php echo $sale_complete['sale_id']; ?>" ><?php echo $sale_complete['sale_id']; ?></a></td>

            <td style="text-align: center;"><?php echo $sale_complete['sale_time']; ?></td>

            <td  style="text-align: left;"><?php
                foreach ($detail_sale as $key => $val) {
                    if ($key == $sale_complete['sale_id']) {
                        foreach ($val as $val1) {
                            foreach ($val1 as $val2) {
                                echo $val2['name'] . "<br /> ";
                            }
                        }
                    }
                }
                ?>&nbsp;
            </td>
            <td style="text-align: center;"><?php echo $this->Employee->get_info($sale_complete['employee_id'])->first_name; ?>&nbsp;</td>
            <td style="text-align: right;"><?php
                foreach ($sale_data as $key2 => $val2) {
                    if ($val2->sale_id == $sale_complete['sale_id']) {
                        $total_cost = $val2->later_cost_price;
                        echo number_format($total_cost);
                        break;
                    }
                }
                ?>&nbsp;</td>

            <?php
            $data_sale_tam = $this->Sale->get_sales_tam($sale_complete['sale_id']);
            $data_sale_payment = $this->Sale->get_payment_sale_by_sale_id($sale_complete['sale_id']);
            $to = 0;
            $do = 0;
            ?>
            <td style="text-align: left">

                <label>

                    <?php foreach ($data_sale_payment as $key => $val) { ?>

                        <?= $val['payment_type'] . ': ' . number_format($val['payment_amount']) ?>

                        <?php
                        $to = $to + $val['payment_amount'];
                        $do = $do + $val['discount_money'];
                        ?>
                        <br>
        <?php } ?>

                </label>
            </td>

            <td><?= $do; ?>&nbsp;</td>
            <td style="text-align: right;" class="consideration_paid"><?php echo number_format($total_cost - $to); ?></td>

                <?php
                $sum_money = $sum_money + $total_cost - $to;
                ?>
            <td>
                <?php if ($total_cost - $to > 0) { ?>
                    <?php if ($sale_complete['suspended'] == 1) { ?>
                        <input type="checkbox"  name="check_customer[]" value="<?php echo $sale_complete['sale_id']; ?>" class="chk" >
                        <input type="hidden"  name="check_payment_type" value="1" class="chk1" >
                    <?php } else { ?>
                        <input type="checkbox"  name="check_customer[]" value="<?php echo $sale_complete['sale_id']; ?>" class="chk" >
                        <input type="hidden"  name="check_payment_type" value="2" class="chk1" >
            <?php } ?>
        <?php } ?>&nbsp;
            </td>
        </tr>
        <?php
    }
}
if ($num_rows == $resultsPerPage) {
    $loadpage = $paged + 1;
    echo "<tr class='loadbutton4'>
	<td colspan = '9'><div class='loadmore4' data-page='" . $loadpage . "'>Xem thêm</div>
	</td></tr>";
} else {
    echo "<tr class='loadbutton4'> </tr>";
}
?>