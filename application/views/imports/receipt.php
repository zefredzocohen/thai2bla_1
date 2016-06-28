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
</style>
<?php
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

	<table id="receipt_items" style="width: 370px!important;font-size:11pt;font-family: Arial;">
		<tr style="border:1px solid #eee9e9;">
			<th style="width:50%;text-align:left; padding-left: 4px;border-right:1px solid #eee9e9;"><?php echo lang('items_item'); ?></th>
			<th style="width:17%;text-align:center;border-right:1px solid #eee9e9;"><?php echo lang('common_price'); ?></th>
			<th style="width:16%;text-align:center;border-right:1px solid #eee9e9;"><?php echo "SL"; ?></th>
			<th style="width:16%;text-align:center;border-right:1px solid #eee9e9;"><?php echo "CK (%)"; ?></th>
			<th style="width:17%;text-align:center;"><?php echo lang('sales_total'); ?></th>
		</tr>
		<?php
		foreach(array_reverse($cart, true) as $line=>$item)
		{
		?>
		<tr style="border:1px solid #eee9e9;">
			<td style="text-align:left;border-right:1px solid #eee9e9;"><span class='long_name'><?php echo $item['name']; ?></span><span class='short_name'><?php echo character_limiter($item['name'],25); ?></span></td>
			<td style="text-align:center;border-right:1px solid #eee9e9;"><?php echo number_format($item['price']); ?></td>
			<td style='text-align:center;border-right:1px solid #eee9e9;'><?php echo $item['quantity']; ?></td>
			<td style='text-align:center;border-right:1px solid #eee9e9;'><?php echo $item['discount']; ?></td>
			<td style='text-align:right;'><?php echo to_currency($item['price']*$item['quantity']-$item['price']*$item['quantity']*$item['discount']/100); ?></td>
		</tr>
	    <!--<tr>

		    <td colspan="2" align="center"><?php echo $item['description']; ?></td>
			<td colspan="2" ><?php echo $item['serialnumber']; ?></td>
			<td colspan="1"><?php echo '---'; ?></td>
	    </tr>
		-->
		<?php
		}
		?>	
		<tr>
		<td colspan="3" style='text-align:right;'><?php echo lang('sales_total'); ?></td>
		<td colspan="2" style='text-align:right'><?php echo to_currency($total); ?></td>
		</tr>

		<tr>
			<td colspan="3" style='text-align:right;'><?php echo 'Đã thanh toán'; ?></td>
			<td colspan="2" style='text-align:right'><?php echo $amount_tendered; ?></td>
		</tr>
		<tr>
			<td colspan="3" style='text-align:right;'><?php echo 'Tiền còn nợ'; ?></td>
			<td colspan="2" style='text-align:right'><?php echo to_currency($total - str_replace(',', '',$amount_tendered)); ?></td>
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