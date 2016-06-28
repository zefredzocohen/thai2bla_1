<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">
<table id="title_bar_new">
	<tr>
		<td id="title_icon">
			<img src='<?php echo base_url()?>images/menubar/reports.png' alt='<?php echo lang('reports_reports'); ?> - <?php //echo $title; ?>' />
		</td>
                
		<td id="title" style="font-size: 20px;"><?php            
                if($store == 0){
                    echo $title." (Kho tổng)";
                }else if($store == "2000"){
                    echo $title." (Tất cả)";
                }else{
                    $info_store = $this->Create_invetory->get_info($store);
                    echo $title." (".$info_store->name_inventory.")";
                }?></td>
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
                                    <th style="text-align: center">Mã MH</th>
                                    <th style="text-align: center">Tên hàng hóa</th>
                                    <th style="text-align: center">Đơn vị tính</th>
                                    <th style="text-align: center">Giá nhập</th>
                                    <th style="text-align: center">Số lượng tồn</th>
                                    <th style="text-align: center">Giá trị tồn</th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php
                                    $total_quantity = 0;
                                    $total_value_inventory = 0;
                                    foreach ($report_inventory as $value){
                                        if($value['quantity_first'] == 0){
                                            $info_unit = $this->Unit->get_info($value['unit']);
                                            $cost_price = $value['cost_price'];
                                        }else{
                                            $info_unit = $this->Unit->get_info($value['unit_from']);
                                            $cost_price = $value['cost_price_rate'];
                                        }
                                        echo "<tr>";
                                            echo "<td style='text-align: center; width: 10%;'>".$value['item_number']."</td>";
                                            echo "<td style=' width: 30%;'>".$value['name']."</td>";                                
                                            echo "<td style=' width: 15%;'>".$info_unit->name."</td>";
                                            echo "<td style='text-align: right; width: 15%;'>".number_format($cost_price)."</td>";
                                            echo "<td style='text-align: right; width: 15%;'>".format_quantity($value['quantity'])."</td>";
                                            echo "<td style='text-align: right; width: 15%;'>".number_format($cost_price*$value['quantity'])."</td>";
                                        echo "</tr>";
                                        $total_quantity += $value['quantity'];
                                        $total_value_inventory += $cost_price*$value['quantity'];
                                    }
                                    ?>                                                                  
                            </tbody>
                        </table>
                        <table>
                            <tr>
                               <td style="font-size: 14px; font-weight: bold; text-align: right; width: 70%">Tổng</td>
                               <td style="text-align: right; font-weight: bold; width: 15%"><?= format_quantity($total_quantity); ?></td>
                               <td style="text-align: right; font-weight: bold; width: 15%"><?= number_format($total_value_inventory); ?></td>
                           </tr>
                       </table>
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