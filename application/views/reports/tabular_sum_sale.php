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

<br /><div style="color:#000">
<table id="contents">
            <tr>
                <td id="item_table">
                    <div id="table_holder" style="width: 960px;">
                        <table class="tablesorter report" id="sortable_table">
                            <thead>
                                <tr>
                                    <th>Ngày tháng</th>
                                    <th>Thành tiền</th>
                                    <th>Thuế</th>
                                    <?php if($item_type == 4){?>
                                        <th>CK tiền mặt</th>
                                    <?php }?> 
                                    <th>Tổng cộng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                 
                                foreach ($dates as $date){ 
                                    $thanh_tien = 0;
                                    $thue = 0;
                                    $tong_cong = 0;
                                    $cktm = 0;
                                    foreach ($datas as $data){
                                        if(date('d-m-Y',strtotime($data['sale_time']))== $date){
                                            if($data['unit_from']){
                                                if($data['unit_from'] == $data['unit_item']){
                                                    $thanh_tien += ($data['item_unit_price_rate']*$data['quantity_purchased'])-($data['item_unit_price_rate']*$data['quantity_purchased']*$data['discount_percent']/100);
                                                    $thue += ($data['item_unit_price_rate']*$data['quantity_purchased']-($data['item_unit_price_rate']*$data['quantity_purchased']*$data['discount_percent']/100))*$data['taxes_percent']/100;
                                                    $cktm += $data['discount_money2'];
                                                    $tong_cong += ($data['item_unit_price_rate']*$data['quantity_purchased'])-($data['item_unit_price_rate']*$data['quantity_purchased']*$data['discount_percent']/100) + ($data['item_unit_price_rate']*$data['quantity_purchased']-($data['item_unit_price_rate']*$data['quantity_purchased']*$data['discount_percent']/100))*$data['taxes_percent']/100 - $data['discount_money2'];
                                                }else{
                                                    $thanh_tien += $data['item_unit_price']*$data['quantity_purchased']-($data['item_unit_price']*$data['quantity_purchased']*$data['discount_percent']/100);
                                                    $thue += ($data['item_unit_price']*$data['quantity_purchased']-($data['item_unit_price']*$data['quantity_purchased']*$data['discount_percent']/100))*$data['taxes_percent']/100;
                                                    $cktm += $data['discount_money2'];
                                                    $tong_cong += ($data['item_unit_price']*$data['quantity_purchased'])-($data['item_unit_price']*$data['quantity_purchased']*$data['discount_percent']/100) +($data['item_unit_price']*$data['quantity_purchased']-($data['item_unit_price']*$data['quantity_purchased']*$data['discount_percent']/100))*$data['taxes_percent']/100 - $data['discount_money2'];
                                                }
                                            }else{
                                                $thanh_tien += ($data['item_unit_price']*$data['quantity_purchased'])-($data['item_unit_price']*$data['quantity_purchased']*$data['discount_percent']/100);
                                                $thue += ($data['item_unit_price']*$data['quantity_purchased']-($data['item_unit_price']*$data['quantity_purchased']*$data['discount_percent']/100))*$data['taxes_percent']/100;
                                                $cktm += $data['discount_money2'];
                                                $tong_cong += ($data['item_unit_price']*$data['quantity_purchased'])-($data['item_unit_price']*$data['quantity_purchased']*$data['discount_percent']/100) +($data['item_unit_price']*$data['quantity_purchased']-($data['item_unit_price']*$data['quantity_purchased']*$data['discount_percent']/100))*$data['taxes_percent']/100 - $data['discount_money2'];
                                            }
                                        }
                                    }
                                    $tong_thanh_tien += $thanh_tien;
                                    $tong_thue += $thue;
                                    $tong_cktm += $cktm;
                                    $tong_cong_tien += $tong_cong;
                                ?>
                                    <tr>
                                        <td style="text-align: left;width: 25%"><?php echo $date;?></td>
                                        <td style="text-align: right;width: 20%"><?php echo number_format($thanh_tien)?></td>
                                        <td style="text-align: right;width: 17%"><?php echo number_format($thue)?></td>
                                        <?php if($item_type == 4){?>
                                        <td style="text-align: right;width: 18%"><?php echo number_format($cktm) ?></td>
                                        <?php }?>
                                        <td style="text-align: right;width: 20%"><?php echo number_format($tong_cong) ?></td>
                                        
                                    </tr>    
                                <?php }?>
                            </tbody>
                        </table>
                        <div id="report_summary" class="tablesorter report" style="margin-right: 10px;">
                            <div class="summary_row"><strong>Tổng thành tiền: </strong><?= to_currency($tong_thanh_tien) ?>
                            <div class="summary_row"><strong>Tổng thuế: </strong><?= to_currency($tong_thue) ?>
                            <?php if($item_type == 4){?>
                                <div class="summary_row"><strong>Tổng CK tiền mặt: </strong><?= to_currency($tong_cktm) ?>
                            <?php } ?>
                            <div class="summary_row"><strong>Tổng cộng: </strong><?= to_currency($tong_cong_tien) ?>
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