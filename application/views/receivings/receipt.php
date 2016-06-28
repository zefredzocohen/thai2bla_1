<?php $this->load->view("partial/header"); ?>

<div id="content_area_wrapper">
<div id="content_area" style="padding: 10px 4px 0 5px">
<!--huyenlt^^ -->
 <script language="javascript" type="text/javascript">
        function printDiv(divID) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            //var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
            document.body.innerHTML = 
              "<html><head><title></title></head><body>" + 
              divElements + "</body>";
            //Print Page
            window.print();
            //Restore orignal HTML
            //document.body.innerHTML = oldPage;

        }
 </script>
<!-- end huyenlt^^ -->
<style type="text/css">
   .print_report{
        background: none repeat scroll 0 0 #1E5A96;
        border: 1px solid #EEEEEE;
        color: #FFFFFF;
        font-size: 14px;
        font-weight: bold;
        line-height: 30px;
        padding: 5px;
        
    }
    #submit
    {
    	width: 85px;
		text-align: center;	
		margin-left: 145px;
    }
    #receipt_items{
        border: 1px;
    }
</style>
<?php
        $total_taxes = 0;
        $totak = 0;
        $info_receiving_item = $this->Receiving_order->get_receiving_item();
        foreach ($info_receiving_item as $val){
               if($val['receiving_id'] == $receiving_id){
                        $net_price1 = $val['item_unit_price'] * $val['quantity_purchased'] - $val['item_unit_price'] * $val['quantity_purchased'] * $val['discount_percent']/100;
                        $totak += $net_price1;
               }
         }
         
        
         
if (isset($error_message))
{
	echo '<h1 style="text-align: center;">'.$error_message.'</h1>';
	exit;
}
?>
<div id="receipt_wrapper" style="margin-bottom: 50px;font-family: Arial;width:370px;">
	<div id="receipt_header" style="width:370px;">
		<div id="company_name" style="font-size: 11px;"><?php echo $this->config->item('company'); ?></div>
		<div id="company_address" style="font-size: 11px;"><?php echo nl2br($this->config->item('address')); ?></div>
		<?php if($this->config->item('company_logo')) {?>
		<div id="company_logo" style="margin: 5px;"><?php echo img(array('src' => $this->Appconfig->get_logo_image())); ?></div>
		<?php } ?>
<!--		<div id="company_phone"><?php echo $this->config->item('phone'); ?></div>-->
		<div id="sale_receipt" style="font-size: 23px;font-weight: bold;font-family: Arial;"><?php echo $receipt_title; ?></div>
		<div id="sale_time" style="font-size: 11px; margin-top:5px;"><?php echo $transaction_time ?></div>
	</div>

	<div id="receipt_general_info" style="font-family: Arial;">
		<?php
            if (isset($supplier)) {
                ?>
                <div id="customer"><?php echo lang('suppliers_supplier').": <b>".$supplier."</b>"; ?></div>
                <?php
            } else {
                ?>
               <div id="customer"><?php echo lang('suppliers_supplier').": <b>".''."</b>"; ?></div>
		<?php } ?>
		<div id="sale_id"><?php echo 'Mã nhập hàng'.": <b>".$receiving_id."</b>"; ?></div>
		<div id="employee"><?php echo lang('employees_employee').": <b>".$employee."</b>"; ?></div>
	</div>

	<table id="receipt_items" style="width: 370px!important;font-size:11pt;font-family: Arial;border: 1px">
		<tr style="border:1px solid #eee9e9;">
			<th style="width:50%;text-align:left; padding-left: 4px;border-right:1px solid #eee9e9;"><?php echo lang('items_item'); ?></th>
			<th style="width:17%;text-align:center;border-right:1px solid #eee9e9;"><?php echo lang('common_price'); ?></th>
			<th style="width:16%;text-align:center;border-right:1px solid #eee9e9;"><?php echo "SL"; ?></th>
			<th style="width:16%;text-align:center;border-right:1px solid #eee9e9;"><?php echo "CK (%)"; ?></th>
			<th style="width:17%;text-align:center;"><?php echo lang('sales_total'); ?></th>
		</tr>
		<?php
                $money = 0;
                $this->load->model('Item');
		foreach($info_receiving_item as $item)
		{   
                    if($item['receiving_id'] == $receiving_id){
                    $money += $item['item_unit_price']*$item['quantity_purchased']-$item['item_unit_price']*$item['quantity_purchased']*$item['discount_percent']/100;
                    
                    
                      //thuế
            $net_price = $item['item_unit_price'] * $item['quantity_purchased'] - $item['item_unit_price'] * $item['quantity_purchased'] * $item['discount_percent']/100;
            
            $cp = ($net_price / $totak) * $this->Receiving->get_info($receiving_id)->row()->other_cost;
            
            $tax = ($net_price + $cp) * $item['taxes'] / 100;
            
            $total_taxes += $tax;
                    
		?>
		<tr style="border:1px solid #eee9e9;">
			<td style="text-align:left;border-right:1px solid #eee9e9;"><?php echo $this->Item->get_info($item['item_id'])->name; ?></td>
			<td style="text-align:center;border-right:1px solid #eee9e9;"><?php echo number_format($item['item_unit_price']); ?></td>
			<td style='text-align:center;border-right:1px solid #eee9e9;'><?php echo $item['quantity_purchased']; ?></td>
			<td style='text-align:center;border-right:1px solid #eee9e9;'><?php echo $item['discount_percent']; ?></td>
			<td style='text-align:right;'><?php echo to_currency($item['item_unit_price']*$item['quantity_purchased']-$item['item_unit_price']*$item['quantity_purchased']*$item['discount_percent']/100); ?></td>
		</tr>

		<?php
                    }
		}
		?>	
		<tr>
                    
		<td colspan="3" style='text-align:right;'><?php echo lang('sales_total'); ?></td>
		<td colspan="2" style='text-align:right'><?php echo to_currency($money); ?></td>
		</tr>
                <tr>
                    
		<td colspan="3" style='text-align:right;'><?php echo 'Tổng thuế'; ?></td>
		<td colspan="2" style='text-align:right'><?php echo to_currency($total_taxes); ?></td>
		</tr>
                
                 <tr>
                    
		<td colspan="3" style='text-align:right;'><?php echo 'Tổng chi phí'; ?></td>
		<td colspan="2" style='text-align:right'><?php echo to_currency($this->Receiving->get_info($receiving_id)->row()->other_cost); ?></td>
		</tr>
                
                 <tr>
			<td colspan="3" style='text-align:right;'><?php echo 'Tổng tiền thanh toán'; ?></td>
                        <td colspan="2" style='text-align:right'><?php echo to_currency($total_taxes + $money + $this->Receiving->get_info($receiving_id)->row()->other_cost) ; ?></td>
		</tr>
                
		<tr>
			<td colspan="3" style='text-align:right;'><?php echo 'Đã thanh toán'; ?></td>
			<td colspan="2" style='text-align:right'><?php echo $amount_tendered; ?></td>
		</tr>
                
               
                
		<tr>
			<td colspan="3" style='text-align:right;'><?php echo 'Tiền còn nợ'; ?></td>
			<td colspan="2" style='text-align:right'><?php echo to_currency(($total_taxes + $money + $this->Receiving->get_info($receiving_id)->row()->other_cost) - str_replace(',', '',$amount_tendered)); ?></td>
		</tr>
		<?php //if(isset($amount_change))
		//{
		?>
			<!--<tr>
			<td colspan="3" style='text-align:right;'><?php echo lang('sales_amount_tendered'); ?></td>
			<td colspan="2" style='text-align:right'><?php echo to_currency($amount_tendered); ?></td>
			</tr>
	
			<tr>
			<td colspan="3" style='text-align:right;'><?php echo lang('sales_change_due'); ?></td>
			<td colspan="2" style='text-align:right'><?php echo $amount_change; ?></td>
			</tr>
		--><?php
		//}
		?>
	</table>

	<!--<div id="sale_return_policy">
	<?php echo nl2br($this->config->item('return_policy')); ?>
	</div>
	<div id='barcode'>
	<?php echo "<img src='".site_url('barcode')."?barcode=$receiving_id&text=$receiving_id' />"; ?>
	</div>
	-->
	
	<a href ="<?php echo base_url()?>receivings" id="submit" style="width:100px; color:#FFFFFF;" class="print_report" onclick="javascript:printDiv('receipt_wrapper')" >In hóa đơn</a>
</div>

</div></div>
<?php $this->load->view("partial/footer"); ?>

<?php if ($this->Appconfig->get('print_after_sale'))
{
?>
<script type="text/javascript">
$(window).load(function()
{
	//window.print();
});
</script>
<?php
}
?>