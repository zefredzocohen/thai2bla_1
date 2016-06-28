<meta http-equiv="content-type" content="text/html; charset=utf-8" />
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
            <div id="receipt_wrapper" style="width:350px;font-family:times new roman; font-size: 14px;">
                <div id="logo" style="text-align: center; width: 100%;margin-bottom: 10px;">
                    <?php
                    echo img(array(
                        'src' => $this->Appconfig->get_logo_image()
                    ));
                    ?>
                </div>
                <div style="width: 100%; float: left; font-weight: bold; text-align: center;line-height: 26px">
                    <div id="diachi" style="width:100%;font-size:20pt"><?php echo $this->config->item('company') ?></div><br>
                    <div id="phone_number" style="margin:-18px 0px 12px -3px;width:100%;font-size:11pt"> Địa chỉ: <?php echo $this->config->item('address') ?></div>
                    <div id="phone_number" style="margin:-18px 0px 12px -3px;width:100%;font-size:11pt"> Điện thoại: <?php echo $this->config->item('phone') ?></div>        
                    <div id="phone_number" style="margin:-18px 0px 12px -3px;width:100%;font-size:11pt"> Email: <?php echo $this->config->item('email') ?></div>        
                </div>

                <div id="abc" style="clear:both;"></div>
                <div id="receipt_header" >
                    <div id="sale_receipt" style=" font-weight:bold; font-size:24px;width:100%;margin: 0px 0 0 0;text-align: center; text-transform: uppercase"><?php echo 'Thanh toán công nợ' ?></div>
                    <div id="abc1" style="clear:both;"></div>           
                    <div id="sale_time" style="text-align: left;width:100%;font-size: 13pt;"><?php echo "Ngày: " . date("d-m-Y H:i:s", strtotime($transaction_time)) ?></div>
                </div>
                <div id="kc" style="clear:both;"></div>
                <div id="receipt_general_info" style="width:100%; text-align:left;line-height: 25px;font-size: 13pt;">		
                    <div id="employee"><?php echo lang('employees_employee') . ": " . $employees_name; ?></div>
                    <div id="customer_name">Tên khách hàng: <?php echo $customer_info->first_name . ' ' . $customer_info->last_name; ?></div>
                </div>
                </br>

                <?php if (count($sale_payment_paid_ok) > 0) { ?>
                    <span><b>Đơn hàng thanh toán hết</b></span>
                    <table style="width: 100%">
                        <tr>
                            <th style="width: 50px">Đơn hàng </th>
                            <th style="width: 130px">Số tiền phải trả</th>
                            <th style="width: 180px">Số tiền khách trả sau CK</th>
                        </tr>
                        <?php foreach ($sale_payment_paid_ok as $key => $val) { ?>
                            <?php $data_sale = $this->Sale->get_sales($key);
                            ?>
                            <tr>
                                <td style="text-align: center"><?= $val['key'] ?></td>
                                <td style="text-align: right"><?= number_format($val['val']) ?></td>
                                <td style="text-align: right"><?= number_format($val['money']) ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } ?>
                <?php if (count($sale_payment_paid_no) > 0) { ?>
                    <span><b>Đơn hàng trả góp</b></span>
                <?php } ?>
                <table style="width: 100%">
                <?php if (count($sale_payment_paid_no) > 0) { ?>                   
                    <tr>
                        <th style="width: 50px">Đơn hàng</th>
                        <th style="width: 130px">Số tiền phải trả</th>
                        <th style="width: 180px">Số tiền khách trả sau CK</th>
                    </tr>
                    <?php foreach ($sale_payment_paid_no as $key => $val) { ?>
                        <tr>
                            <td style="text-align: center"><?= $val['key'] ?></td>
                            <td style="text-align: right"><?= number_format($val['val']) ?></td>
                            <?php $data_sale = $this->Sale->get_sales($val['key']); ?>
                            <td style="text-align: right"><?= number_format($residual) ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
                    <tr>
                        <td colspan="2" style="padding-top: 5px; border: none;">Tiền khách đưa:</td>
                        <td style="border: none; text-align: right"><?= number_format($money_total); ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border: none;">Tiền chiết khấu:</td>
                        <td style="border: none; text-align: right"><?= $discount_money_total ? number_format($discount_money_total) : 0; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border: none;">Tổng tiền còn nợ sau CK:</td>
                        <td style="border: none; text-align: right">
                            <?= (($sum_money - $discount_money_total - $money_total)>0)?number_format($sum_money - $discount_money_total - $money_total):0; ?>
                        </td>
                    </tr>	
                    <tr>
                        <td colspan="2" style="border: none;">Trả lại khách:</td>
                        <td style="border: none; text-align: right">
                            <?= (($sum_money - $discount_money_total - $money_total) < 0) ? number_format(abs($sum_money - $discount_money_total - $money_total)) : '0' ?>
                        </td>
                    </tr>
                </table>
                <!-- huyenlt^^-->
                <a href = "<?php echo site_url() . "/customers/detail_customer_sale/$customer_info->person_id" ?>" id="submit" style="width:100px; color:#FFFFFF; margin-top: 20px;" class="print_report" onclick = "this.style.display = 'none'; window.print()";>In hóa đơn</a>
            </div>
            <!-- uyen lam  -->
        </div>
    </div>
</div>
 
    <script src="<?php echo base_url(); ?>js/jquery.number.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>js/jquery.number.min.js" type="text/javascript"></script>
    <script>
    $(document).ready(function () {
        $(".boket1").focusout(function ()
        {
            var c = confirm('Hãy chắc chắn là số tiền bạn xác nhận là đúng');
            if (c) {
                $('#money_hidden').show('slow', function () {
                    $('#money_show').hide();
                    $('.system_confirm').show();
                    $('#money_hidden_mi').show();
                    $('#money_mi_show').hide();
                    $('#conlai_hidden').show();
                    $('#conlai_show').hide();
                    $('.boket2').val($(".boket1").val());
                    $('.conlai1').val($(".conlai").val());
                });
            }
            else {
                $('.boket1').val('');
                //$('.boket').val();
                return false;
            }

        });
        $('.tong_tien_no').number(true);
        $('.must_pay').number(true);
        $('.tong_no_am').number(true);
        $('.discount_money').number(true);
        $('.discount_money').keyup(function () {
            $('.must_pay').val(Number($('.tong_tien_no').val()) - Number($('.tong_no_am').val()) - Number($('.discount_money').val()));
        });
        $('.submit_button_export_excel').click(function () {
            var tien_khach_tra = $(".tien_khach_tra").attr("value");
            var tien_chiet_khau = $(".discount_money").val();
            var tien_tra_khach = $('.tien_tra_khach').attr('value');
            var no_hom_truoc = $('.tien_tt').attr('value');
            //var no_hom_nay=$('.tien_hn').attr('value');+'&tien_no_hn='+no_hom_nay
            var customer_id = $('.customer_id').attr('value');
            jQuery.ajax({
                type: 'Post',
                url: '<?php echo site_url("customers/customer_check_payment_save"); ?>',
                data: 'tien_khach_tra1=' + tien_khach_tra + '&customer_id1=' + customer_id + '&chietkhau=' + tien_chiet_khau + '&tien_tra_khach1=' + tien_tra_khach + '&tien_no_ht=' + no_hom_truoc,
                success: function (html) {
                    if (html == "true") {
                        window.print();
                    }
                    else {
                        alert('Có lỗi trong quá trình thực hiện');
                    }
                }
            });
        });
    });
    </script>
