<?php
if ($num_rows > 0) {
    foreach ($cost_complete as $cost_completes) {
        ?>
        <tr>
            <td><a href="#" ><?php echo $cost_completes['id_cost']; ?></a></td>
            <td style="text-align: center"><?php echo date('d-m-Y H:i:s', strtotime($cost_completes['date'])); ?></td>
            <td><?php echo $cost_completes['comment']; ?></td>
            <td style="text-align: right;">
                <?= number_format($cost_completes['form_cost'] == 0 ? $cost_completes['money'] : 0); ?></td>
            <td style="text-align: right;">
                <?= number_format($cost_completes['form_cost'] == 1 ? $cost_completes['money'] : 0); ?></td>
        </tr>
        <?php
    }
}
if ($num_rows == $resultsPerPage) {
    $loadpage = $paged + 1;
    echo "<tr class='loadbutton3'>
						    		<td colspan = '5'><div class='loadmore3' data-page='" . $loadpage . "'>Xem thêm</div>
						    		</td></tr>";
}
?>
                            
