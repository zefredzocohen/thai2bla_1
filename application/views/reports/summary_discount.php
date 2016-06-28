<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
    <div id="content_area">
        <table id="title_bar_new">
            <tr>
                <td id="title_icon">
                    <img src='<?php echo base_url() ?>images/menubar/reports.png' alt='<?php echo lang('reports_reports'); ?> - <?php //echo $title;  ?>' />
                </td>
                <td id="title" style="font-size: 20px;"><?php echo lang('reports_reports'); ?> - <?php echo $title ?></td>
                <td><a style="font-size:18px;text-decoration: underline; float: right;margin-right:30px; color: #FFF" href=<?php echo base_url() . $link; ?>>Trở lại</a></td>
            </tr>
            <tr style="margin-top: 8px;">
                <td>&nbsp;</td>
                <td><small style="font-size: 15px; font-style: italic"><?php echo $subtitle ?></small></td>
                <td>&nbsp;</td>
            </tr>

        </table>

        <br /><div style="color:#000">
            <table id="contents">
                <tr>
                    <td id="item_table">
                        <div id="table_holder" style="width: 960px;">
                            <table class="tablesorter report" id="sortable_table">
                                <thead>
                                    <tr>
                                        <th>Tên mặt hàng</th>
                                        <th>Số lượng</th>
                                        <th>Chiết khấu (%)</th>  
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_discount_precent = 0;
                                    if ($dis_get != NULL):
                                        foreach ($dis_get as $discount_get):
                                            ?>
                                            <tr>
                                                <td style="text-align: center"><?= $discount_get['name']; ?></td>
                                                <td align="center"><?= $discount_get['quantity_purchased'] > 0 ? format_quantity($discount_get['quantity_purchased']) : format_quantity($discount_get['quantity_purchased']) . ' (Trả hàng)' ?></td>
                                                <td style="text-align: center"><?= number_format($discount_get['discount_percent']) ?></td>
                                            </tr>
                                            <?php
                                            $total_discount_precent +=$discount_get['discount_percent'];
                                            ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            <div id="report_summary" class="tablesorter report" style="margin-right: 10px;">
                                <div class="summary_row"><strong>Tổng chiết khấu: <?= number_format($total_discount_precent) . '%' ?></strong>
                                </div>
                            </div>
                    </td>
                </tr>
            </table>
            <div id="feedback_bar"></div>
        </div></div></div>
<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript" language="javascript">
    function init_table_sorting()
    {
        //Only init if there is more than one row
        if ($('.tablesorter tbody tr').length > 1)
        {
            $("#sortable_table").tablesorter();
        }
    }
    $(document).ready(function ()
    {
        init_table_sorting();
    });
</script>


