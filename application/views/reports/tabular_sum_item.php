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
                                    <th>Mặt hàng</th>
                                    <th>ĐVT</th>
                                    <th>Số lượng</th>
                                    <th>Số lượng đã bán</th>
                                    <th>Thành tiền</th>
                                    <th>Thuế</th>                                    
                                    <th>Tổng cộng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                
                                foreach ($data_item as $val){
                                    if($val['item_id']){
                                        $item_name = $this->Item->get_info($val['item_id']);
                                        $quan_total = $item_name->quantity_total;
                                    }else{
                                        $item_name = $this->Pack->get_info($val['pack_id']);
                                        $quan_total = $item_name->total_quantity;
                                    }
                                    if($item_type != 4){
                                        if($item_type != 2){
                                            $info_item = $this->Sale->get_all_item_id_in_sale_item($start_date, $end_date, $sale_type,$item_type,$val['item_id']);
                                        }else{
                                             $info_item = $this->Sale->get_all_pack_id_in_sale_pack($start_date, $end_date, $sale_type,$val['pack_id']);
                                        }
                                    }else{                                    
                                        $info_item1 = $this->Sale->get_all_item_id_in_sale_item($start_date, $end_date, $sale_type,$item_type,$val['item_id']);
                                        $info_item2 = $this->Sale->get_all_pack_id_in_sale_pack($start_date, $end_date, $sale_type,$val['pack_id']);
                                        $info_item = array_merge($info_item1,$info_item2);
                                    }
//                                    echo "<pre>"; print_r($info_item);
                                    $total_quan = 0;
                                    $thanh_tien = 0;
                                    $thue = 0;
                                    $tong_cong = 0;
                                    foreach ($info_item as $val1){
                                        $total_quan += $val1['quantity_purchased'];
                                        if($val['item_id']){
                                            if($item_name->quantity_first > 0){
                                                $thanh_tien += $val1['quantity_purchased']*$val1['item_unit_price_rate'] - $val1['quantity_purchased']*$val1['item_unit_price_rate']*$val1['discount_percent']/100;
                                                $thue += ($val1['quantity_purchased']*$val1['item_unit_price'] - $val1['quantity_purchased']*$val1['item_unit_price']*$val1['discount_percent']/100)*$val1['taxes_percent']/100;
                                                $tong_cong += $val1['quantity_purchased']*$val1['item_unit_price_rate'] - $val1['quantity_purchased']*$val1['item_unit_price_rate']*$val1['discount_percent']/100 + ($val1['quantity_purchased']*$val1['item_unit_price'] - $val1['quantity_purchased']*$val1['item_unit_price']*$val1['discount_percent']/100)*$val1['taxes_percent']/100;
                                            }else{
                                                $thanh_tien += $val1['quantity_purchased']*$val1['item_unit_price'] - $val1['quantity_purchased']*$val1['item_unit_price']*$val1['discount_percent']/100;
                                                $thue += ($val1['quantity_purchased']*$val1['item_unit_price'] - $val1['quantity_purchased']*$val1['item_unit_price']*$val1['discount_percent']/100)*$val1['taxes_percent']/100;
                                                $tong_cong += $val1['quantity_purchased']*$val1['item_unit_price'] - $val1['quantity_purchased']*$val1['item_unit_price']*$val1['discount_percent']/100 + ($val1['quantity_purchased']*$val1['item_unit_price'] - $val1['quantity_purchased']*$val1['item_unit_price']*$val1['discount_percent']/100)*$val1['taxes_percent']/100;
                                            }
                                        }else{
                                            $thanh_tien += $val1['pack_unit_price']*$val1['quantity_purchased']-$val1['pack_unit_price']*$val1['quantity_purchased']*$val1['discount_percent']/100;
                                             $tong_cong += $val1['pack_unit_price']*$val1['quantity_purchased']-$val1['pack_unit_price']*$val1['quantity_purchased']*$val1['discount_percent']/100;
                                        }
                                    }
                                    $tong_thanh_tien += $thanh_tien;
                                    $tong_thue += $thue;
                                    $tong_cong_tien += $tong_cong;
                                    ?>
                                <tr>
                                    <td><?php echo $item_name->name?></td>
                                    <td>
                                        <?php 
                                        if($item_name->unit_from){
                                            echo $this->Unit->get_info($item_name->unit)->name.'-'.$this->Unit->get_info($item_name->unit_from)->name;
                                        }else{
                                            echo $this->Unit->get_info($item_name->unit)->name;
                                        }?>
                                    </td>
                                    <td style="text-align: right"><?php echo format_quantity($quan_total); ?></td>
                                    <td style="text-align: right"><?php echo format_quantity($total_quan); ?></td>
                                    <td style="text-align: right"><?php echo number_format($thanh_tien); ?></td>
                                    <td style="text-align: right"><?php echo number_format($thue); ?></td>
                                    <td style="text-align: right"><?php echo number_format($tong_cong); ?></td>
                                </tr>
                                <?php }?>
                                
                            </tbody>
                        </table>
                        <div id="report_summary" class="tablesorter report" style="margin-right: 10px;">
                            <div class="summary_row"><strong>Tổng tiền hàng: </strong><?= to_currency($tong_thanh_tien) ?>
                            <div class="summary_row"><strong>Tổng thuế: </strong><?= to_currency($tong_thue) ?>
                            <div class="summary_row"><strong>Tổng tiền thanh toán: </strong><?= to_currency($tong_cong_tien) ?> 
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