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
                                    <th style="text-align: center">Loại mặt hàng</th>
                                    <th style="text-align: center">Thành tiền</th>
                                    <th style="text-align: center">Thuế</th>
                                    <th style="text-align: center">Tổng cộng</th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php
                               $cat_id1 = $this->Sale->get_cat_in_sale_item();
                               $cat_id2 = $this->Sale->get_cat_in_sale_pack();
                               $cat_id_tam = array_merge($cat_id1,$cat_id2);
                               $cat_id = array_unique($cat_id_tam);                              
                               $data_by_cat1 = $this->Sale->get_sale_item_by_cat_id($start_date, $end_date, $sale_type);
                               $data_by_cat2 = $this->Sale->get_sale_pack_by_cat_id($start_date, $end_date, $sale_type);
                               $data_by_cat = array_merge($data_by_cat1,$data_by_cat2);
                               foreach ($cat_id as $key =>$val){
                                   $thanh_tien = 0;
                                   $thue = 0;
                                   $tong_cong = 0;
                                   foreach ($data_by_cat as $val1){
                                       if($val1['cat_id'] == $val['cat_id']){
                                           if($val1['item_id']){
                                               if($val1['unit_from']==$val1['unit_item']){
                                                   $thanh_tien += $val1['unit_price_rate']*$val1['quantity_purchased']- $val1['unit_price_rate']*$val1['quantity_purchased']*$val1['discount_percent']/100;
                                                   $thue += $val1['unit_price_rate']*$val1['quantity_purchased']*$val1['taxes_percent']/100;
                                                   $tong_cong += $val1['unit_price_rate']*$val1['quantity_purchased']- $val1['unit_price_rate']*$val1['quantity_purchased']*$val1['discount_percent']/100 + $val1['unit_price_rate']*$val1['quantity_purchased']*$val1['taxes_percent']/100;
                                               }else{
                                                    $thanh_tien += $val1['unit_price']*$val1['quantity_purchased']- $val1['unit_price']*$val1['quantity_purchased']*$val1['discount_percent']/100;
                                                   $thue += $val1['unit_price']*$val1['quantity_purchased']*$val1['taxes_percent']/100;
                                                   $tong_cong += $val1['unit_price']*$val1['quantity_purchased']- $val1['unit_price']*$val1['quantity_purchased']*$val1['discount_percent']/100 + $val1['unit_price']*$val1['quantity_purchased']*$val1['taxes_percent']/100;
                                               }                                             
                                           }else{
                                               $thanh_tien += $val1['pack_unit_price']*$val1['quantity_purchased'] - $val1['pack_unit_price']*$val1['quantity_purchased']*$val1['discount_percent']/100;
                                               $tong_cong += $val1['pack_unit_price']*$val1['quantity_purchased'] - $val1['pack_unit_price']*$val1['quantity_purchased']*$val1['discount_percent']/100;
                                           }
                                       }
                                   }
                                    $total_money += $tong_cong;
                                    $total_tax_money += $thue;
                                    $total_thanhtien += $thanh_tien;
                                   $name = $this->Category->get_info($val['cat_id']);?>
                                   <tr>
                                       <td style="text-align: left"><?php echo $name->name;?></td>
                                       <td style="text-align: right"><?php echo number_format($thanh_tien);?></td>
                                       <td style="text-align: right"><?php echo number_format($thue);?></td>
                                       <td style="text-align: right"><?php echo number_format($tong_cong);?></td>
                                    </tr>
                               <?php }
                               
                               ?>
                            </tbody>
                        </table>
                        <div id="report_summary" class="tablesorter report" style="margin-right: 10px;">
                            <div class="summary_row"><strong>Tổng thành tiền: </strong><?= to_currency($total_thanhtien) ?>
                            <div class="summary_row"><strong>Tổng thuế: </strong><?= to_currency($total_tax_money) ?>
                            <div class="summary_row"><strong>Tổng cộng: </strong><?= to_currency($total_money) ?>
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