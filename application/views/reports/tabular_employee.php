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
                                    <th>Nhân viên</th>
                                    <th>Thành tiền</th>
                                    <th>Thuế</th>
                                    <th>CK tiền mặt</th>
                                    <?php if($item_type ==4){?>
                                    <th>Tổng tiền thanh toán</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody><?php 
                            $tong_cong_don_hang = 0;
                            $tong_cong_thue = 0;
                            $tong_cong_chiet_khau = 0;
                            $tong_cong_thanh_toan = 0;    
                           	$employees_all = $this->Sale->get_employee_in_sale_all($start_date, $end_date, $sale_type, $item_type);
                           	foreach ($employees_all as $employee_all){
                           		
                                $tong_tien_don_hang = 0;
                                $tong_thue = 0;
                                $employees = $this->Sale->get_employee_in_sale($start_date, $end_date, $sale_type, $item_type, $employee_all['employee_id']);
                                foreach ($employees as $employee){
                                    
                                	$datas = $this->Sale->get_sale_item_by_summary_employee($start_date, $end_date, $sale_type,$employee_all['employee_id'], $employee['sale_id'],$item_type);
                                    $payments = $this->Sale->get_sale_tam_by_summary_employee($start_date, $end_date,$employee_all['employee_id'],$sale_type);
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
                                   	 		$tien_don_hang += $data['pack_unit_price'] * $data['quantity_purchased'];
                                   	 		$tien_thue_item = 0;
                                   	 		$pack_infos = $this->Pack_items->get_info($data['pack_id']);
                                   	 		foreach($pack_infos as $pack_info){
                                   	 			$item_info = $this->Item->get_info($pack_info->item_id);
                                   	 			$tien_thue_item += $pack_info->price * $pack_info->quantity * $item_info->taxes / 100;
                                   	 		}
                                            $tien_thue += $tien_thue_item * $data['quantity_purchased'];
                                        }
                                    } 
                                	if($item_type ==4){
                                        $tong_tien_thanh_toan = 0;
                                        $tong_tien_chiet_khau = 0;
                                        foreach ($payments as $payment){
                                            $tong_tien_thanh_toan += $payment['pays_amount'];
                                        	$tong_tien_chiet_khau += $payment['discount_money'];
                                        }
                                    }
                                    $tong_tien_don_hang += $tien_don_hang;
                                    $tong_thue += $tien_thue;
                                }?>
                                    <tr>
                                        <td style="text-align: left">
                                            <?php 
                                                $employee = $this->Person->get_info($employee_all['employee_id']);
                                                echo $employee->first_name.' '.$employee->last_name;
                                            ?></td>
                                        <td style="text-align: right"><?php echo number_format($tong_tien_don_hang) ?></td>
                                        <td style="text-align: right"><?php echo number_format($tong_thue) ?></td>
                                        <td style="text-align: right"><?php echo number_format($tong_tien_chiet_khau) ?></td>
                                        <?php if($item_type ==4){?>
                                        <td style="text-align: right"><?php echo number_format($tong_tien_thanh_toan) ?></td>
                                        <?php }?>
                                    </tr>
                                    <?php
                                    $tong_cong_don_hang += $tong_tien_don_hang;
                                    $tong_cong_thue += $tong_thue;
                                    $tong_cong_chiet_khau += $tong_tien_chiet_khau;
                                    $tong_cong_thanh_toan += $tong_tien_thanh_toan;
                           	}?>
                            </tbody>
                        </table>
                        <div id="report_summary" class="tablesorter report" style="margin-right: 10px;">
                            <div class="summary_row"><strong>Tổng tiền hàng: </strong><?= to_currency($tong_cong_don_hang) ?>
                            <div class="summary_row"><strong>Tổng thuế: </strong><?= to_currency($tong_cong_thue) ?>
                            <div class="summary_row"><strong>Tổng chiết khấu: </strong><?= to_currency($tong_cong_chiet_khau) ?>
                            <?php if($item_type ==4){?>
                            	<div class="summary_row"><strong>Tổng tiền thanh toán: </strong><?= to_currency($tong_cong_thanh_toan) ?>
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