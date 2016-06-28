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
                                    <th>Khách hàng</th>
                                    <th>Tổng tiền hàng</th>
                                    <th>Tổng thuế</th>
                                    <?php if($item_type ==4){?>
                                    <th>Tổng tiền thanh toán</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody><?php 
                            $tong_cong_don_hang = 0;
                            $tong_cong_thue = 0;
                            $tong_cong_thanh_toan = 0;    
                           	$customers_all = $this->Sale->get_customer_in_sale_all($start_date, $end_date, $sale_type, $item_type);
                           	foreach ($customers_all as $customer_all){
                           		
                                $tong_tien_don_hang = 0;
                                $tong_thue = 0;
                                $customers = $this->Sale->get_customer_in_sale($start_date, $end_date, $sale_type, $item_type, $customer_all['customer_id']);
                                foreach ($customers as $customer){
                                    
                                	$datas = $this->Sale->get_sale_item_by_summary_customer($start_date, $end_date, $sale_type,$customer_all['customer_id'], $customer['sale_id'],$item_type);
                                    $payments = $this->Sale->get_sale_tam_by_summary_customer($start_date, $end_date,$customer_all['customer_id'],$sale_type);
                                    $tien_don_hang = 0;
                                    $tien_thue = 0;
                                    foreach ($datas as $data){
                                        
                                    	if($data['item_id']){
                                        	$price = ($data['unit_item']== $data['unit_from']) ? $data['item_unit_price_rate'] : $data['item_unit_price'];
                                        	$tien_discount_percent = $price * $data['discount_percent'] / 100;
                                        	$tien_don_hang += ($price - $tien_discount_percent) * $data['quantity_purchased'];
                                        	$tien_thue += ($price - $tien_discount_percent) * $data['quantity_purchased'] * $data['taxes_percent'] / 100;
                                        }
                                        if($data['pack_id']){
                                   	 		$tien_don_hang += $data['pack_unit_price'] * $data['quantity_purchased']-$data['pack_unit_price'] * $data['quantity_purchased'] *$data['discount_percent']/100;
                                   	 		$tien_thue_item = 0;
                                   	 		$pack_infos = $this->Pack_items->get_info($data['pack_id']);
                                   	 		foreach($pack_infos as $pack_info){
                                   	 			$item_info = $this->Item->get_info($pack_info->item_id);
                                   	 			$tien_thue_item += 0;
                                   	 		}
                                            $tien_thue += $tien_thue_item * $data['quantity_purchased'];
                                        }
                                    } 
                                	if($item_type ==4){
                                        $tong_tien_thanh_toan = 0;
                                        foreach ($payments as $payment){
                                            $tong_tien_thanh_toan += $payment['pays_amount'];
                                        }
                                    }
                                    $tong_tien_don_hang += $tien_don_hang;
                                    $tong_thue += $tien_thue;
                                }?>
                                    <tr>
                                        <td style="text-align: left">
                                            <?php 
                                            if($customer_all['customer_id'] == -1 || $customer_all['customer_id'] == NULL){
                                                echo "Khách lẻ";
                                            }else{
                                                if( $this->Customer->get_info($customer_all['customer_id'])->company_name != NULL){
                                                    echo $this->Customer->get_info($customer_all['customer_id'])->company_name ;
                                                }elseif($this->Customer->get_info($customer_all['customer_id'])->manages_name != NULL){
                                                      echo $this->Customer->get_info($customer_all['customer_id'])->manages_name ;
                                                }else{
                                                    $customer = $this->Person->get_info($customer_all['customer_id']);
                                                    echo $customer->first_name.' '.$customer->last_name;
                                                }
                                            } ?>
                                        </td>
                                        <td style="text-align: right"><?php echo number_format($tong_tien_don_hang) ?></td>
                                        <td style="text-align: right"><?php echo number_format($tong_thue) ?></td>
                                        <?php if($item_type ==4){?>
                                        <td style="text-align: right"><?php echo number_format($tong_tien_don_hang) ?></td>
                                        <?php }?>
                                    </tr>
                                    <?php
                                    $tong_cong_don_hang += $tong_tien_don_hang;
                                    $tong_cong_thue += $tong_thue;
                                    $tong_cong_thanh_toan += $tong_tien_thanh_toan;
                           	}?>
                            </tbody>
                        </table>
                        <div id="report_summary" class="tablesorter report" style="margin-right: 10px;">
                            <div class="summary_row"><strong>Tổng tiền hàng: </strong><?= to_currency($tong_cong_don_hang) ?>
                            <div class="summary_row"><strong>Tổng thuế: </strong><?= to_currency($tong_cong_thue) ?>
                            <?php if($item_type ==4){?>
                            	<div class="summary_row"><strong>Tổng tiền thanh toán: </strong><?= to_currency($tong_cong_don_hang) ?>
                            <?php } ?>
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
	//Only init if there is more than one row-
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