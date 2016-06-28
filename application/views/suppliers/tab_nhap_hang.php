<?php
if ($num_rows > 0) {
    foreach ($receiving_all as $val) {
        ?>
        <tr class="row_inventory_sale">
            <td class="row_sale_id" style="text-align: center;"><?= $val['receiving_id']; ?></td>
            <td style="text-align: center;"><?= date('d-m-Y H:i:s', strtotime($val['receiving_time'])); ?></td>
            <td  style="text-align: left;">
                <?php
                foreach ($payment_order_all as $key1 => $val1) {
                    foreach ($val1 as $val2) {
                        if ($val2['receiving_id'] == $val['receiving_id']) {
                            echo $val2['name'] . "<br /> ";
                        }
                    }
                }
                ?>&nbsp;
            </td>
            <td><?php echo $this->Employee->get_info($val['employee_id'])->first_name.' '.$this->Employee->get_info($val['employee_id'])->last_name;; ?>&nbsp;</td>
            <td style="text-align: right;">
                <?php
                $total_receiving = $this->Receiving->get_total_receiving($val['receiving_id']);
                echo number_format($total_receiving['total_price']);
                ?>&nbsp;
            </td>
            <?php
            $discount = 0;
            $payment = 0;
            foreach ($receiving_tam_all as $val3) {
                foreach ($val3 as $val4) {
                    if ($val4['id_receiving'] == $val['receiving_id']) {
                        ?>
                        <?php
                        $discount = $discount + $val4['discount_money'];
                        $payment = $payment + $val4['pays_amount'];
                    }
                }
                ?>
            <?php } ?>
            <td style="text-align: right;"><?= number_format($discount); ?>&nbsp;</td>
            <td>
                <label>
                    <?php
                    $discount = 0;
                    $payment = 0;
                    foreach ($receiving_tam_all as $val3) {
                        foreach ($val3 as $val4) {
                            if ($val4['id_receiving'] == $val['receiving_id']) {                              
                                echo $val4['pays_type'] . ': ' . number_format($val4['pays_amount']).'<br>';                    
                                $discount = $discount + $val4['discount_money'];
                                $payment = $payment + $val4['pays_amount'];
                            }
                        }
                    } ?>
                </label>
                &nbsp;
            </td>
            <td style="text-align: right;" class="consideration_paid">
                <?php echo number_format($total_receiving['total_price'] - $payment - $discount); ?>&nbsp;
            </td>            
        </tr>
        <?php
    }
}
if ($num_rows == $resultsPerPage) {
    $loadpage = $paged + 1;
    echo "<tr class='loadbutton2'><td colspan = '9'><div class='loadmore2' data-page='" . $loadpage . "'>Xem thêm</div></td></tr>";
} else {
    echo "<tr class='loadbutton2'> </tr>";
}
?>