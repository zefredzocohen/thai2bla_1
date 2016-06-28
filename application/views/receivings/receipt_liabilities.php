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
                width: 120px;
                height: 50px;
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
            #diachi{
                text-transform: uppercase;
            }            
        </style>

        <?php
        if (isset($error_message)) {
            echo '<h1 style="text-align: center;">' . $error_message . '</h1>';
            exit;
        }
        ?>

        <div style="height: auto; width: 280px;">
            <div id="receipt_wrapper" style="width: 280px;font-family: Arial; margin-top: -15px;">
                <div id="logo" style="text-align: center; width: 280px">
                    <?php
                    echo img(array(
                        'src' => $this->Appconfig->get_logo_image()
                    ));
                    ?>
                </div>
                <div style="width: 280px; text-align: center; font-size: 10px">
                    <div id="diachi">
                        <?php echo $this->config->item('company') ?>
                    </div>
                    <div id="phone_number"> 
                        Địa chỉ: <?php echo $this->config->item('address') ?>
                    </div>
                    <div id="phone_number"> 
                        Điện thoại: <?php echo $this->config->item('phone') ?>
                    </div>        
                    <div id="phone_number">
                        Email: <?php echo $this->config->item('email') ?>
                    </div>        
                </div>
                <div id="abc" style="clear:both;"></div>
                <div id="receipt_header" style="width: 280px;">
                    <div id="sale_receipt" style="text-transform: uppercase;text-align: center;font-weight: bold; margin: 10px auto;font-size: 12px;">
                        <?php echo $receipt_title ?>
                    </div>   
                </div>                
                <div id="receipt_general_info" style="font-family: Arial; font-size: 10px; width: 280px;">
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
                         <?php 
                           $this->load->model('Create_invetory');
                           $inventory_id = $this->receiving_lib->get_inventory();
                           $info_warehouse = $this->Create_invetory->get_info($inventory_id); 
                         ?>
                        <div id="employee"><?php echo "Kho".": <b>".$info_warehouse->name_inventory."</b>"; ?></div>
                        <div id="employee"><?php echo "Địa chỉ kho".": <b>".$info_warehouse->address."</b>"; ?></div>
                        <div id="employee"><?php echo "Ngày".": <b>".  date('d-m-Y',  strtotime($transaction_time))."</b>"; ?></div>
                </div>
                <table id="receipt_items" style="width: 280px !important; font-size:10px; font-family: Arial;">
                    <tr>
                        <th style="width:10%; border:1px solid #000000;">Mã MH</th>
                        <th style="width:23%; border:1px solid #000000;"><?php echo lang('items_item'); ?></th>
                        <th style="width:8%; border:1px solid #000000;">ĐVT</th>
                        <th style="width:8%; border:1px solid #000000;"><?php echo "SL"; ?></th>
                        <th style="width:16%; border:1px solid #000000;"><?php echo lang('common_price'); ?></th>                        
<!--                        <th style="width:8%; border:1px solid #000000;"><?php //echo "CK (%)"; ?></th>-->
                        <th style="width:17%; border:1px solid #000000;">Thành tiền</th>
                    </tr>
                    <?php
                    $total1 = 0;
                    $subtotal = 0;
                    $net_price = 0;
                    $tax = 0;
                    $total_cost = 0;
                    foreach(array_reverse($cart, true) as $line=>$item){
                        $net_price = $item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount']/100;
                        $total1 += $net_price;
                        $tax = $net_price * $item['taxes'] / 100;
                        
                        $subtotal+= $tax;
                        
                        $cost = ($net_price / $total1) * $this->receiving_lib->get_other_cost();
                        $total_cost += $cost;
                        if($item['item_id']){
                            $term= $this->Item->get_info($item['item_id']);
                            $unit= $this->Unit->get_info($term->unit);                    
                            $number_code = $term->item_number;
                        }else{
                            $term = $this->Item_kit->get_info($item['item_kit_id']);
                            $unit = $this->Unit->get_info($term->category);
                            $number_code = $term->item_kit_number;
                        }
                    ?>
                    <tr>
                        <td style="border:1px solid #000000;">                            
                            <?php echo $number_code; ?>
                        </td>
                        <td style="border:1px solid #000000;">                            
                            <?php echo $item['name']; ?>
                        </td>
                        <td style="border:1px solid #000000; text-align: right;">
                            <?php echo $unit->name; ?>
                        <td style="border:1px solid #000000; text-align: right;">
                            <?php echo $item['quantity']; ?>
                        </td>
                        <?php
                          if($item['discount'] > 0){

                        ?>
                        <td style="border:1px solid #000000; text-align: right;">
                            <?php echo number_format($item['price']-(($item['price']*$item['discount'])/100)); ?>
                        </td> 
                    <?php }else{?>
                         <td style="border:1px solid #000000; text-align: right;">
                            <?php echo number_format($item['price']); ?>
                        </td> 
                    <?php }?>
                        </td>
<!--                        <td style="border:1px solid #000000; text-align: right;">
                            <?php //echo $item['discount']; ?>
                        </td>-->
                        <td style="border:1px solid #000000; text-align: right;">
                            <?php echo number_format($item['price']*$item['quantity']-$item['price']*$item['quantity']*$item['discount']/100); ?>
                        </td>
                    </tr>	    
                    <?php
                    }
                    ?>	
                     <tr>
                        <td colspan="4" style='text-align:right;'>Tổng tiền hàng</td>
                        <td colspan="3" style='text-align:right'><?php echo to_currency($total1); ?></td>
                    </tr>
                    <tr>
                        <td colspan="4" style='text-align:right;'>Tiền chi phí</td>
                        <td colspan="3" style='text-align:right'><?php echo to_currency($this->receiving_lib->get_other_cost()); ?></td>
                    </tr>
                    <tr>
                        <td colspan="4" style='text-align:right;'>Tiền thuế</td>
                        <td colspan="3" style='text-align:right'><?php echo to_currency($total_taxes); ?></td>
                    </tr>
                    <tr>
                        <td colspan="4" style='text-align:right;'>Tổng tiền thành toán</td>
                        <td colspan="3" style='text-align:right'><?php echo to_currency($total1 + $this->receiving_lib->get_other_cost() + $total_taxes); ?></td>
                    </tr>

                    <tr>
                            <td colspan="4" style='text-align:right;'><?php echo 'Đã thanh toán: '; ?></td>
                            <td colspan="3" style='text-align:right'><?php echo ($amount_tendered>0)?to_currency($amount_tendered):to_currency(0); ?></td>
                    </tr>
                    <tr>
                            <td colspan="4" style='text-align:right;'><?php echo 'Tiền còn nợ: '; ?></td>
                            <td colspan="3" style='text-align:right'><?php echo to_currency(($total1 + $this->receiving_lib->get_other_cost() + $total_taxes) - $amount_tendered); ?></td>
                    </tr>
            </table>
            </div>
            <a href = "<?= site_url() . '/receivings' ?>" id="submit" style="width:100px; color:#FFFFFF;" class="print_report" onclick = "this.style.display = 'none';javascript:printDiv('receipt_wrapper')">In hóa đơn</a>            
        </div>
    </div>
</div>
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
<script type="text/javascript">
    $(document).ready(function () {
        //window.print ();
//    	window.location="<?= site_url() . '/sales' ?>";
        $(".print_report1").click(function () {
            alert('chay ham 1');
            var money_dis1 = $(".money_discount").val();
            var total1 = $(".total").val();
            var sale_id1 = $(".sale_id").val();
            jQuery.ajax({
                type: 'Post',
                url: '<?php echo site_url("sales/update_all_sales_table") ?>',
                data: "sale_id=" + sale_id1 + "&total=" + total1 + "&money_discount=" + money_dis1,
                success: function (html) {
                    if (html == "true") {
                        window.print();
                    }
                    else {
                        $("#result_update").html("Bạn nên thực hiện lại đơn hàng này ");
                    }
                }
            });

        });
        $(".print_report1").click(function ()
        {
            alert('chay ham 1');
            var money_dis1 = $(".money_discount").val();
            var type_pay1 = $(".type_payment").val();
            var total1 = $(".total").val();
            var sale_id1 = $(".sale_id").val();
            jQuery.ajax({
                type: 'Post',
                url: '<?php echo site_url("sales/update_sales_sales_payments_cost_inventory") ?>',
                data: "sale_id=" + sale_id1 + "&total=" + total1 + "&payment_type=" + type_pay1 + "&money_discount=" + money_dis1,
                success: function (html) {
                    if (html == "true") {

                        window.print();
                    }
                    else {
                        $("#result_update").html("Bạn nên thực hiện lại đơn hàng này ");
                    }
                }
            });

            //alert(type_pay);
        });

    });
</script>
