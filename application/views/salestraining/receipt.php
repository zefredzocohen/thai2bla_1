<?php $this->load->view("partial/header"); ?>
<?php
$is_integrated_credit_sale = false;
if (isset($error_message))
{
	echo '<h1 style="text-align: center;">'.$error_message.'</h1>';
	exit;
}
?>
<div id="receipt_wrapper">
	<div id="receipt_header_sales" style="border:1px solid black; padding:10px 10px; margin-bottom: -11px;">
		<div id="receipt_company_info_left">
			<table class="receipt_table">
				<tr>
					<td><?php if($this->config->item('company_logo')) {?>
							<div id="company_logo_sale"><?php echo img(array('src' => $this->Appconfig->get_logo_image())); ?></div>
						<?php } ?>
					</td>
				</tr>
			</table>
		</div>
		<div id="receipt_company_info_right">
			<table>
				<tr><td class="span"><?php echo $receipt_title; ?></td><td>Mẫu</td><td>v02GTTT2/001</td></tr>
				<tr><td class="span"><?php echo 'Bản sao (Copy)' ?></td><td><?php echo 'kí hiệu'; ?></td><td><?php echo 'VH/12T'; ?></td></tr>
				<tr><td class="span"><?php echo $transaction_time ?></td><td><?php echo "Số:"; ?></php></td><td><?php echo $sale_id; ?></td></tr>
			</table>
		</div>
		<div style="clear:both;"></div> <!-- phan lam -->
	</div>
	<div id="receipt_company_info" style="border:1px solid black; width:97%; padding:10px 10px; margin-bottom: -11px;">
		<div id="receipt_company_info_left">
			<table>
				<tr><td><?php echo 'Đơn vị bán hàng(Sale Company):'; ?></td></tr>
				<tr><td><?php echo 'Mã số thuế(TAXcode):'; ?></td></tr>
				<tr><td><?php echo 'Địa chỉ(Address):'; ?></td></tr>
				<tr><td><?php echo 'Điện thoại(tel/Fax):'; ?></td></tr>
				<tr><td><?php echo 'Số tài khoản(Acount no):'; ?></td></tr>
			</table>
		</div>
		<div id="receipt_company_info_right">
			<table>
				<tr><td><?php echo $this->config->item('company'); ?></td></tr>
				<tr><td><?php echo '0102620355'; ?></td></tr>
				<tr><td><?php echo nl2br($this->config->item('address')); ?></td></tr>
				<tr><td><?php echo $this->config->item('phone'); ?></td></tr>
				<tr><td><?php echo '1440201015270'; ?></td></tr>
			</table>
		</div>
		<div style="clear:both;"></div> <!-- phan lam -->
	</div>
	<div id="customer_info" style="border:1px solid black; padding:10px 10px; margin-bottom: -11px;">
		<div id="receipt_company_info_left">
			<?php
				foreach(array_reverse($cart, true) as $line=>$item)
				{
					$discount_exists=false;
					if($item['discount']>0)
					{
						$discount_exists=true;
					}
	  
				}
			?>
			<table>
				<tr><td>Họ tên Người mua hàng:</td></tr>
				<tr><td>Tên đơn vị:</td></tr>
				<tr><td>Mã số thuế:</td></tr>
				<tr><td>Địa chỉ(Address):</td></tr>
				<tr><td>Số tài khoản(Acount no):</td></tr>
				<tr><td>Hình thức thanh toán:</td></tr>
			</table>
		</div>
		<div id="receipt_company_info_right">
			<table>
				<tr><td><?php echo $customer; ?></td></tr>
				<tr><td><?php echo $cus_name; ?></td></tr>
				<tr><td><?php echo $tax_code; ?></td></tr>
				<tr><td><?php echo $address; ?></td></tr>
				<tr><td><?php echo $account_number; ?></td></tr>
				<tr><td>Tại ngân hàng:</td><td>Đơn vị tiền tệ:</td></tr>
				<?php if ($amount_change >= 0) {?>
				<tr>
					<td><?php echo lang('sales_change_due'); ?></td>
				</tr>
			<?php }else{ ?>
			<tr>
				<td><?php echo lang('sales_amount_due'); ?></td>
			</tr>	
			<?php } 
			if ($ref_no){ ?>
			<tr>
				<td><?php echo lang('sales_ref_no'); ?></td>
			</tr>	
			<?php } ?>
			<tr>
				<td colspan="6" align="right">
					<?php if($show_comment_on_receipt==1)
					{
						echo $comment ;
					}
					?>
				</td>
			</tr>
			</table>
		</div>
		<div style="clear:both;"></div> <!-- phan lam -->
	</div>
	<div id="items_info"  style="border:1px solid black;">
		<table style="border:1px solid black;">
			<tr style="border:1px solid black;">
				<td>STT</td>
				<td>Tên hàng hóa, dịch vụ</td>
				<td>Đơn vị tính</td>
				<td>Số lượng</td>
				<td>Đơn giá</td>
				<td>Thành tiền</td>
			</tr>
			<?php $stt = 1;
			
				foreach(array_reverse($cart, true) as $line=>$item){ ?>
			<tr style="border:1px solid black;">
				<td class="span" style="border:1px solid black;"><?php echo $stt; ?></td>
				<td class="span" style="border:1px solid black;"><?php echo $item['name']; ?></td>
				<td class="span" style="border:1px solid black;"><?php echo $item_info->unit; ?></td>
				<td class="span" style="border:1px solid black;"><?php ?><?php echo $item['quantity']; ?></td>
				<td class="span" style="border:1px solid black;"><?php echo $item['price']; ?></td>	
				<td class="span" style="border:1px solid black;"><?php echo to_currency($item['price']*$item['quantity']-$item['price']*$item['quantity']*$item['discount']/100); ?></td>
			</tr>	
				<?php $stt++; } ?>
			
			<tr style="border:1px solid black;">
				<td style="border:1px solid black;">...</td>
				<td style="border:1px solid black;">...</td>
				<td style="border:1px solid black;">...</td>
				<td style="border:1px solid black;">...</td>
				<td style="border:1px solid black;">...</td>
				<td style="border:1px solid black;">...</td>
			</tr >
			<tr style="border:1px solid black;">
				<td style="border:1px solid black;">...</td>
				<td style="border:1px solid black;">...</td>
				<td style="border:1px solid black;">...</td>
				<td style="border:1px solid black;">...</td>
				<td style="border:1px solid black;">...</td>
				<td style="border:1px solid black;">...</td>
			</tr>
		</table>
	</div>
	<div id="customer_sale">
		<div id="receipt_company_info_left">
			<table>
				<tr><td>Số tiền viết bằng chữ:</td></tr>
				<tr><td>Người mua hàng:</td></tr>
				<tr><td>(Kí và ghi rõ họ tên)</td></tr>
				<tr><td>.....</td></tr>
			</table>
		</div>
		<div id="receipt_company_info_right">
			<table>
				<tr><td>......</td></tr>
				<tr><td>Người bán hàng</td><td>Người giao hàng</td></tr>
				<tr><td>(Kí và ghi rõ họ tên)</td><td>(Kí và ghi rõ họ tên)</td></tr>
				<tr><td><?php echo $employee; ?></td><td><?php echo $employee; ?></td></tr>
			</table>
		</div>
		<div style="clear:both;"></div>
	</div>

</div>
<div id="feedback_bar"></div>
<?php if ($this->Appconfig->get('print_after_sale'))
{
?>
<script type="text/javascript">
window.print();
</script>
<?php }  ?>



<?php if($is_integrated_credit_sale && $is_sale) { ?>
<script type="text/javascript">
set_feedback(<?php echo json_encode(lang('sales_credit_card_processing_success'))?>, 'success_message', false);
</script>
<?php } ?>
<?php $this->load->view("partial/footer"); ?>



