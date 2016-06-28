

<?php
if ($num_rows > 0) {
    foreach ($sale_all_invs as $sale_all) {
        if (!(($sale_all['suspended'] == 0) && ($sale_all['liability'] == 0) && ($sale_all['materials'] == 1))) {  // th báo giá
            ?>
            <tr>
                <td><a href="<?php echo base_url(); ?>customers/switch_sale/<?php echo $sale_all['sale_id']; ?>" ><?php echo $sale_all['sale_id']; ?></a></td>
                <td><?php echo date('d-m-Y h:i:s', strtotime($sale_all['sale_time'])); ?></td>
                <?php foreach ($detail_sale_all as $key => $val) {
                    if ($key == $sale_all['sale_id']) {
                        ?>
                        <td>
                            <?php
                            foreach ($val as $val1) {
                                foreach ($val1 as $val2) {
                                    echo $val2['name'] . "<br /> ";
                                }
                            }
                            ?>
                        </td>&nbsp;
                        <td><?= $val['total_item'] ?>&nbsp;</td>
                <?php }
            } ?>
                <td><?php echo $this->Employee->get_info($sale_all['employee_id'])->first_name; ?>&nbsp;</td>

                <td style="text-align: right;">
                    <?php
                    foreach ($sale_data_all as $key2 => $val2) {
                        if ($val2->sale_id == $sale_all['sale_id']) {
                            $total_cost = $val2->later_cost_price;
                            echo number_format($total_cost);
                            break;
                        }
                    }
                    ?>&nbsp;</td>


                <?php
                $data_sale = $this->Sale->get_sales_tam($sale_all['sale_id']);
                $data_sale_payment = $this->Sale->get_payment_sale_by_sale_id($sale_all['sale_id']);
                $to = 0;
                $do = 0;
                foreach ($data_sale as $key => $val) {
                    $to = $to + $val['pays_amount'];
                    $do = $do + $val['discount_money'];
                }
                ?>
                <td style="text-align: right;"><?= number_format($do) ?>&nbsp;</td>
                <td style="text-align: right;"><?= number_format($total_cost - $to) ?>&nbsp;</td>
                <td style=""><?php foreach ($data_sale as $key => $val) { ?>
                <?= $val['pays_type'] . ': ' . number_format($val['pays_amount']) ?> 
                        <br>
            <?php } ?>
                </td>

            </tr>
        <?php
        }//end if 
    }//end foreach
}
if ($num_rows == $resultsPerPage) {
    $loadpage = $paged + 1;
    echo "<tr class='loadbutton'>
			    		<td colspan = '9'><div class='loadmore' data-page='" . $loadpage . "'>Xem thêm</div>
			    		</td></tr>";
} else {
    echo "<tr class='loadbutton'> </tr>";
}
?>

