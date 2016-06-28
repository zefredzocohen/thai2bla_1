<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Hóa đơn thanh toán công nợ NCC</title>
<style type="text/css">
    #pay_money{
        padding:5px;
        border:none;
        text-align: right;
        width:70px;
    }
    .discount_money{
        width:110px !important;
        padding:5px;
        border:none;
        text-align: right;
    }
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
    .customer_name {
        border-bottom: 1px solid #fff;
        border-top: 1px solid #fff;
        float: left;
        height: 33px;
        line-height: 20px;
        margin-top: 0;
        width: 95%;
    }
    table{
        border-collapse: collapse;
        margin-top: 10px;
        margin-bottom: 20px;
    }
    table th, table td{
        border: 1px solid #000000;
    }
    table th{
        font-size: 12px;
    }
</style>
<div id="content_area_wrapper">
    <div id="content_area" style="height: auto;float: left;">
        <div style="height:auto">
            <div id="receipt_wrapper" style="width:350px;font-family:times new roman">
                <?php
                echo img(array(
                    'src' => $this->Appconfig->get_logo_image(),
                    'style' => 'text-align: center; margin-left: 142px;'
                ));
                ?>
                <div style="width: 100%; float: left; font-weight: bold; text-align: center;line-height: 26px">
                    <div id="diachi" style="width:100%;font-size:18pt"><?php echo $this->config->item('company') ?></div><br>
                    <div id="phone_number" style="margin:-18px 0px 12px -3px;width:100%;font-size:11pt"> Địa chỉ: <?php echo $this->config->item('address') ?></div>
                    <div id="phone_number" style="margin:-18px 0px 12px -3px;width:100%;font-size:11pt"> Điện thoại: <?php echo $this->config->item('phone') ?></div>        
                    <div id="phone_number" style="margin:-18px 0px 12px -3px;width:100%;font-size:11pt"> Email: <?php echo $this->config->item('email') ?></div>        
                </div>

                <div id="abc" style="clear:both;"></div>
                <div id="receipt_header" >
                    <div id="sale_receipt" style=" font-weight:bold; font-size:24px;width:100%;margin: 0px 0 0 0;text-align: center; text-transform: uppercase"><?php echo 'Thanh toán công nợ' ?></div>
                    <div id="abc1" style="clear:both;"></div>
                    <div id="sale_time" style="text-align: left;width:100%;font-size: 12pt; margin-top: 9px;"><?php echo "Ngày: " . date('d-m-Y'); ?></div>
                </div>
                <div id="receipt_general_info" style="width:100%; text-align:left;line-height: 20px;font-size: 13pt;">		
                    <div id="employee"><?php echo lang('employees_employee') . ": " . $employees->first_name ?></div>
                    <div class="customer_name">Nhà cung cấp: <b><?php echo $supplier->company_name; ?></b></div>  
                </div>
                <?php if (count($receiving_payment_paid_ok) > 0) { ?>
                    <span><b style="margin-left:2px;">Đơn hàng thanh toán hết</b></span>
                    <table style="width:100%">
                        <tr>
                            <th style="width: 50px">Đơn hàng</th>
                            <th style="width: 120px">Số tiền phải trả</th>
                            <th style="width: 180px">Số tiền đã trả sau CK</th>
                        </tr>
                        <?php
                        foreach ($receiving_payment_paid_ok as $key => $val) {                            
                            ?>
                            <tr>
                                <td style="text-align: center"><?= $val['key'] ?></td>
                                <td style="text-align: right;"><?= number_format($val['val']) ?></td>
                                <td style="text-align: right;"><?= number_format($val['money']) ?></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                    <?php if (count($receiving_payment_paid_no) > 0) { ?>
                        <span><b style="margin-left:2px;">Đơn hàng trả góp</b></span>
                        <table style="width:100%">
                            <tr>
                                <th style="width: 50px">Đơn hàng</th>
                                <th style="width: 120px">Số tiền phải trả</th>
                                <th style="width: 180px">Số tiền đã trả sau CK</th>
                            </tr>
                            <?php
                            foreach ($receiving_payment_paid_no as $key => $val) {                                
                                ?>
                                <tr>
                                    <td style="text-align: center"><?= $val['key'] ?></td>
                                    <td style="text-align: right;"><?= number_format($val['val']) ?></td>
                                    <td style="text-align: right;"><?= number_format($residual); ?></td>
                                </tr>
                            <?php } ?>
                    <?php } ?>
                        <tr>
                            <td colspan="2" style="border: none; margin-top: 10px;">Tiền thanh toán:</td>
                            <td style="border: none; text-align: right; margin-top: 10px;"><?= number_format($money_total); ?> VNĐ</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border: none;">Chiết khấu:</td>
                            <td style="border: none; text-align: right;"><?= number_format($discount_money_total); ?> VNĐ</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border: none;">Tiền nhận lại sau CK:</td>
                            <td style="border: none; text-align: right;"><?= ($sum_money - $discount_money_total - $money_total < 0)?number_format(abs($sum_money - $discount_money_total - $money_total)):0; ?> VNĐ</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border: none;">Tiền còn nợ sau CK:</td>
                            <td style="border: none; text-align: right;"><?= ($sum_money - $discount_money_total - $money_total > 0)?number_format($sum_money - $discount_money_total - $money_total):0; ?> VNĐ</td>
                        </tr>
                    </table>                   
                    <a href = "<?= site_url() ?>/costs/view" id="submit" style="width:100px; color:#FFFFFF;" class="print_report" onclick = "this.style.display = 'none'; window.print()";>In hóa đơn</a>
<?php echo form_close(); ?>	
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>js/jquery-1.9.1.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/jquery.number.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/jquery.number.min.js" type="text/javascript"></script>

