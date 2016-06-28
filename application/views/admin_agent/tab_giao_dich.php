
<?php
if ($num_rows > 0) {
    foreach ($emp_trade as $emp_trades) {
        ?>
        <tr>
            <td><a href="#" ><?php echo $emp_trades['id']; ?></a></td>
            <td><?php echo $emp_trades['start_date']; ?></td>
            <td><?php echo $this->Employee->get_info($emp_trades['person_id'])->first_name; ?></td>
            <td><?php echo mb_convert_encoding($emp_trades['text'], 'ISO-8859-1', 'UTF-8'); ?></td>
            <td><?php echo mb_convert_encoding($emp_trades['report'], 'ISO-8859-1', 'UTF-8'); ?></td>
            <?php if ($emp_trades['progress'] == 1) { ?>
                <td>Hoàn thành</td>
            <?php } else { ?>
                <td><?php echo $emp_trades['progress'] * 100; ?>%</td>
            <?php } ?>
        </tr>
        <?php
    }
}
if ($num_rows == $resultsPerPage) {
    $loadpage = $paged + 1;
    echo "<tr class='loadbutton3'>
	<td colspan = '6'><div class='loadmore3' data-page='" . $loadpage . "'>Xem thêm</div>
	</td></tr>";
} else {
    echo "<tr class='loadbutton3'> </tr>";
}
?> 