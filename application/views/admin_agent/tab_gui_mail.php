<?php
if ($num_rows > 0) {
    //if($mail_history){
    foreach ($mail_history as $value) {
        ?>
        <tr>
            <td style='text-align: left'><?php echo $value['title'] ?></td>
            <td style='text-align: center;'><?php echo $value['time'] ?></td>
            <td><?php echo $value['note'] ?></td>
            <td><?php echo $info_emp = $this->Employee->get_info_one_hit($value['employee_id']);
        echo $info_emp->first_name . " " . $info_emp->last_name;
        ?>
            </td>
            <td><?php
                if ($value['status'] == 1) {
                    echo "Gửi thành công";
                } else {
                    echo "Gửi thất bại";
                }
                ?>
            </td>
            <td style='text-align: center;'>
                <a class='thickbox' href="<?php echo site_url() . '/customers/view_mail_history/' . $value['id'] . '/width~700' ?>">Xem</a>
                <a class='delete_mail_history' id='<?php echo $value['id'] ?>' style='margin-left: 10px; cursor: pointer; color: #2400FF'>Xóa</a>
            </td>
        </tr>
        <?php
    }
    //}
}
if ($num_rows == $resultsPerPage) {
    $loadpage = $paged + 1;
    echo "<tr class='loadbutton6'>
        <td colspan = '7'>
        <div class='loadmore6' data-page='" . $loadpage . "'>Xem thêm</div>
        </td>
        </tr>";
}
?>

<script src="<?php echo base_url(); ?>js/all.js" type="text/javascript"></script>			  	
<script type="text/javascript">
    $(".delete_mail_history").click(function () {
        var id = $(this).attr("id");
        var parent = $(this).parent().parent();
        var data = "id=" + id;
        if (confirm("Bạn có chắc chắn muốn xóa?")) {
            $.ajax({
                type: "post",
                url: "<?php echo site_url() . '/customers/remove_mail_history'; ?>",
                data: data,
                success: function (data) {
                    $(parent).remove();
                }
            });
        }
        return false;
    });
</script>						  	