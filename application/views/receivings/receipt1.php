<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<script src="<?php echo base_url(); ?>js/jquery-1.9.1.js"></script>
<div id="content_area_wrapper">
<div id="content_area" style="padding: 10px 4px 0 5px">
<style type="text/css">
    .mavach-table td {
        height: 30px;
        margin-bottom: 3px;
        font-weight: bold;
    }
    #form_excel_export{

        width: 271px;
        margin: 30px 0 0;
    }
    .submit_button_export_excel{
        background: none repeat scroll 0 0 #1E5A96;
        border: 1px solid #EEEEEE;
        color: #FFFFFF;
        font-size: 14px;
        font-weight: bold;
        line-height: 30px;
        padding: 5px;
    }
    #value_to_update{
        float: left;
        margin:0 15px;
        width: 100px;
    }
    #value_to_update input{
        background: none repeat scroll 0 0 #1E5A96;
        border: 1px solid #EEEEEE;
        color: #FFFFFF;
        font-size: 14px;
        font-weight: bold;
        line-height: 30px;
        padding: 5px;
        margin-left: 9px;
        width: 100px;
        text-align: center;
    }
    #logo img{
        width: 175px;
        height: 85px;
    }
    .new-font-size tr td{
        font-size: 11pt;
    }
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
		margin-left: 140px;
    }
</style>

<?php
if (isset($error_message)) {
    echo '<h1 style="text-align: center;">' . $error_message . '</h1>';
    exit;
}
?>

<div style="height:auto;">
    <div id="receipt_wrapper" style="width:385px;font-family:times new roman">
        <div id="logo" style="text-align: center; width: 385px;margin-bottom: 10px;">
            <?php
            echo img(array(
                'src' => $this->Appconfig->get_logo_image()
            ));
            ?>
        </div>
        <div style="width: 385px; float: left; font-weight: bold; text-align: center;line-height: 26px">
            <div id="diachi" style="width:385px;font-size:23pt"><?php echo $this->config->item('company') ?></div><br>
            <div id="phone_number" style="margin:-18px 0px 12px -3px;width:385px;font-size:11pt"> Địa chỉ: <?php echo $this->config->item('address') ?></div>
            <div id="phone_number" style="margin:-18px 0px 12px -3px;width:385px;font-size:11pt"> Điện thoại: <?php echo $this->config->item('phone') ?></div>        
            <div id="phone_number" style="margin:-18px 0px 12px -3px;width:385px;font-size:11pt"> Email: <?php echo $this->config->item('email') ?></div>        
        </div>
        <div id="abc" style="clear:both;"></div>
        <div id="receipt_header" >
        	<div id="sale_receipt" style=" font-weight:bold; font-size:24px;width:385px;margin: 0px 0 0 0;text-align: center; text-transform: uppercase"><?php echo 'Hóa đơn nhập hàng' ?></div>
        	<div id="abc1" style="clear:both;"></div>
       		<div id="sale_time" style="text-align: left;width:100%;font-size: 13pt;"><?php echo "Phiếu nhập: ". $receiving_id ?>&nbsp;&nbsp;&nbsp;<?php echo "Ngày: " . $transaction_time ?></div>
        </div>
        <div id="kc" style="clear:both;"></div>
        <div id="receipt_general_info" style="width:100%; text-align:left;line-height: 25px;font-size: 13pt;">		
        <div id="employee"><?php echo lang('employees_employee') . ": " . $employee; ?></div>
            <?php
            if (isset($supplier)) {
                ?>
                <div id="customer" style="width:400px;"><?php echo lang('suppliers_supplier') . ": " . $supplier; ?></div>
                <?php
            } else {
                ?>
                <div id="customer" style="width:400px;"><?php echo lang('suppliers_supplier') . ": " . ' '; ?></div>
			<?php } ?>
       <!--  <div id="store"><?php //echo lang('sales_store').": ".$store;  ?></div> -->
        </div>
        <table style="width:380px;margin:15px 0px;font-size:13pt" class="new-font-size" >
            <tr style="font-weight:bold;">
                <td style="width:170px;text-align: center;border-top:1px solid;border-left:1px solid;border-right:1px solid;border-bottom:1px solid; font-size: 13pt !important" ><?php echo 'NVL' ?></td>	
                <td style="width:30px;text-align: center;border-top:1px solid;border-right:1px solid;border-bottom:1px solid; font-size: 13pt !important"><?php echo 'SL'; ?></td>
                <td style="width:80px;text-align: center;border-top:1px solid;border-right:1px solid;border-bottom:1px solid; font-size: 13pt !important"><?php echo 'Đ.GIÁ'; ?></td>
         		<td style="width:16%;text-align:center;border-top:1px solid;border-right:1px solid;border-bottom:1px solid;"><?php  echo 'CK'.'(%)';  ?></td>          
        		<td style="border-right:1px solid;border-top:1px solid;border-bottom:1px solid;text-align:right;width:80px;text-align: center; font-size: 13pt !important"><?php echo 'T.TIỀN'; ?></td>
            </tr>
            <?php
            foreach (array_reverse($cart, true) as $line => $item) {
	        ?>
                <tr style="font-weight: bold;font-size:11pt;">
                    <td style="border-left:1px solid;border-right:1px solid;border-bottom: 1px solid;"><span class='short_name'><?php echo character_limiter($item['name'], 45); ?></span></td>

                    <td style='text-align:center;border-right:1px solid;border-bottom: 1px solid;'><?php echo $item['quantity'] . ' ' . $item['unit']; ?></td>
                    
                    <td style="text-align: right;border-right:1px solid;border-bottom: 1px solid;"><?php echo to_currency_unVND_nomar($item['price']); ?></td>	
                    
                    <td style="text-align: right;border-right:1px solid;border-bottom: 1px solid;"><?php echo to_currency_unVND_nomar($item['discount']); ?></td>
                    
                    <td style='text-align:right;border-right:1px solid;border-bottom: 1px solid;'><?php echo to_currency_unVND_nomar($item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100); ?></td>
                    
                </tr>
  
                <?php
            }
            ?>
            
            <tr>
            	<td colspan="3" style='text-align:right; font-size: 13pt !important'><?php echo lang('sales_payment').': '; ?></td>
            	<td colspan="2" style='text-align:right;font-size: 13pt !important'><?php echo $payment_type; ?></td>
            </tr>
           <tr>
            	<td colspan="3" style='text-align:right;font-size: 13pt !important'><?php echo 'Tổng thanh toán: '; ?></td>
            	<td colspan="2" style='text-align:right; font-size: 13pt !important'><?php echo to_currency($total); ?></td>
           </tr> 
           <tr>
            	<td colspan="3" style='text-align:right;font-size: 13pt !important'><?php echo 'Tiền đưa: '; ?></td>
            	<td colspan="2" style='text-align:right; font-size: 13pt !important'><?php echo to_currency($amount_tendered); ?></td>
           </tr> 
           <?php if($total > $amount_tendered){?>
           <tr>
            	<td colspan="3" style='text-align:right;font-size: 13pt !important'><?php echo 'Tiền còn nợ: '; ?></td>
            	<td colspan="2" style='text-align:right; font-size: 13pt !important'><?php echo to_currency($total - $amount_tendered); ?></td>
           </tr> 
           <?php } else {?>
           <tr>
            	<td colspan="3" style='text-align:right;font-size: 13pt !important'><?php echo 'Tiền dư: '; ?></td>
            	<td colspan="2" style='text-align:right; font-size: 13pt !important'><?php echo to_currency($amount_tendered - $total); ?></td>
           </tr>
           <?php }?>
        
        </table>
     <a href = "<?= site_url().'/receivings'?>" id="submit" style="width:100px; color:#FFFFFF;" class="print_report" onclick = "this.style.display = 'none';javascript:printDiv('receipt_wrapper')">In hóa đơn</a>
    </div>
    
</div></div></div>
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

 