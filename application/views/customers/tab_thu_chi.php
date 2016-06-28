<?php
if ($num_rows > 0) {
    foreach ($cost_complete as $cost_completes) {
        ?>
        <tr>
            <td><a href="#" ><?php echo $cost_completes['id_cost']; ?></a></td>
            <td style="text-align: center"><?php echo date('d-m-Y H:i:s', strtotime($cost_completes['date'])); ?></td>
            <td><?php echo $cost_completes['comment']; ?></td>
            <?php if ($cost_completes['tien_thu'] <> 0) { ?>
                <td style="text-align: right"><?php echo number_format($cost_completes['tien_thu']); ?></td>
            <?php } else { ?>
                <td style="text-align: right">0</td>
            <?php } ?>
            <?php if ($cost_completes['tien_chi'] <> 0) { ?>
                <td style="text-align: right"><?php echo number_format($cost_completes['tien_chi']); ?></td>
            <?php } else { ?>
                <td style="text-align: right">0</td>
            <?php } ?>
        </tr>
        <?php
    }
}
if ($num_rows == $resultsPerPage) {
    $loadpage = $paged + 1;
    echo "<tr class='loadbutton2'>
						    		<td colspan = '5'><div class='loadmore2' data-page='" . $loadpage . "'>Xem thêm</div>
						    		</td></tr>";
}
?>
                            
