<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">
<table id="title_bar_new">
	<tr>
		<td id="title_icon">
			<img src='<?php echo base_url()?>images/menubar/reports.png' alt='<?php echo lang('reports_reports'); ?> - <?php //echo $title; ?>' />
		</td>
		<td id="title" style="font-size: 20px;"><?php echo lang('reports_reports'); ?> - <?php echo $title ?></td>
		<td><a style="font-size:18px;text-decoration: underline; float: right;margin-right:30px; color: #FFF" href=<?php echo base_url().$link; ?>>Trở lại</a></td>
	</tr>
	<tr style="margin-top: 8px;">
		<td>&nbsp;</td>
		<td><small style="font-size: 15px; font-style: italic"><?php echo $subtitle ?></small></td>
		<td>&nbsp;</td>
	</tr>
	
</table>
<table id="contents">
    <tr>
        <td id="item_table">
            <div id="table_holder" style="width: 960px;">
                <table class="tablesorter report" id="sortable_table">
                    <thead>
                        <tr>
                            <th style="text-align: center; font-size: 13px;">Hình thức thanh toán</th>
                            <th style="text-align: center; font-size: 13px;">Tổng tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total_money = 0;
                        $data_p = $this->Sale->get_payment_sumary($start_date, $end_date, $sale_type);
                        $data_pay = $this->Sale->get_payment_money_sumary($start_date, $end_date, $sale_type);
                        foreach ($data_p as $row){
                            echo '<tr>';
                            echo '<td align="center">'.$row['payment_type'].'</td>';
                            $pay_amount = 0;
                            foreach ($data_pay as $row1){  
                                if(trim($row1['payment_type']) == trim($row['payment_type'])){
                                    $pay_amount += $row1['payment_amount'];
                                }
                            }
                            echo '<td style="text-align: right;">'.to_currency_unVND_nomar($pay_amount).'</td>';
                            echo '</tr>';
                            $total_money += $pay_amount;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div id="report_summary" class="tablesorter report" style="margin-right: 10px;">
                <div class="summary_row"><?php echo '<strong>Tổng tiền thanh toán</strong>: '.to_currency($total_money) ; ?></div>
            </div>
        </td>
    </tr>
</table>
<br /><div style="color:#000">

<div id="feedback_bar"></div>
</div></div></div>
<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript" language="javascript">
function init_table_sorting()
{
	//Only init if there is more than one row
	if($('.tablesorter tbody tr').length >1)
	{
		$("#sortable_table").tablesorter(); 
	}
}
$(document).ready(function()
{
	init_table_sorting();
});
</script>
