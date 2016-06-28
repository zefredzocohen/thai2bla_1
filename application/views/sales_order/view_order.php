
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

    #info_employee table{
        margin-top: 10px;
        width: 100%;
    }
    #info_employee table th,#info_employee table td{
        width: 33%;
        text-align: center;
    }
    #info_employee table td{
        padding: 0px 0px 80px 0px;
    }
    #logo_print,  #info_company{
        float:left;
    }


</style>


<?= form_open(array('id' => 'approve_form')); ?>
<fieldset id="info_order">
    <div id="header_order">
        <div id="logo_print">
            <?php echo img(array('src' => $this->Appconfig->get_logo_image())); ?>
        </div>
        <div id="info_company">
            <table style="width: 100%">
                <tr>
                    <td colspan="2">
                        <span style="text-transform: uppercase;  font-weight: bold; color: #002FC2;">
                            <?php echo $this->config->item('company'); ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><span style='color: #002FC2'><?php echo $this->config->item('address'); ?></span></td>
                </tr>
                <tr>
                    <td style="width: 70%;">Điện thoại: <span style='color: #002FC2'><?php echo $this->config->item('phone'); ?></span></td>
                    <td style="width: 30%;">Fax: <span style='color: #002FC2'><?php echo $this->config->item('fax'); ?></span></td>
                </tr>
            </table>
        </div>
        <div id="info_company" style="padding-left: 50px">
            <table style="width: 100%">
                <tr>
                    <td colspan="2">
                        <p>Số: <span style='color: #D50018; font-weight: bold'><?php echo $sale_id; ?></span></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><p>Ngày: <span style='color: #002FC2'><?php echo date("d-m-Y H:i:s"); ?></span></p></td>
                </tr>

            </table>
        </div>
        <div style="clear: both"></div>
    </div>

    <?php $info_emp = $this->Employee->get_info($info_sale->employee_id); ?>
    <legend>Thông tin hóa đơn bán hàng</legend>
    <p>Người lập hóa đơn: <?= $info_emp->first_name . " " . $info_emp->last_name; ?></p>

    <?php
    if ($info_sale->customer_id == NULL) {
        $customer_name = "KHÁCH LẺ";
    } else {
        $customer_name = $this->Customer->get_info($info_sale->customer_id)->first_name . ' ' . $this->Customer->get_info($info_sale->customer_id)->last_name;
    }
    ?>

    <p>Tên khách hàng : <?php echo $customer_name; ?></p>
    <?php
    if ($info_sale->suspended == 1) {
        $cate_order = "Ghi nợ";
    } elseif ($info_sale->liability == 1) {
        $cate_order = 'Đặt hàng';
    } elseif ($info_sale->materials == 1) {
        $cate_order = 'Báo giá';
    } elseif ($info_sale->later_cost_price < 0) {
        $cate_order = "Trả hàng";
    } else {
        $cate_order = "Bán hàng";
    }
    ?>

    <?php
    $this->load->model('Sale');
    $payment = 0;
    $discount_money = 0;
    $pay = $this->Sale->pay_amount_order();
    foreach ($pay as $value) {
        if ($sale_id == $value['id_sale']) {
            $payment += $value['pays_amount'];
            $discount_money += $value['discount_money'];
        }
    }
    ?>

    <p>Loại hóa đơn :<font color="red"><?= $cate_order; ?></font></p>
    <p>Ghi chú: <?php echo $info_sale->comment ?></p>
</fieldset>
<fieldset>
    <legend>Danh sách mặt hàng đã bán</legend>
    <table id="table_export_item">
        <tr>
            <th>STT</th>
            <th>Mã MH</th>
            <th>Tên MH</th>
            <th>ĐVT</th>
            <th>Đơn giá</th>
            <th>Số lượng</th>
            <th>Chiết khấu(%)</th>
            <th>Thuế (%)</th>
            <th>Thành tiền</th>
        </tr>
        <?php
        $stt = 1;
        $total_quantity = 0;
        $total_discount = 0;
        $total_money = 0;
        $total_tax = 0;
        $tt = 0;
        $taxs = 0;
  if($this->Sale->get_info($sale_id)->row()->sale_status == 0){
        $get_taxes_item = $this->Sale->get_taxes_item();
        if ($info_sale_item != null):
            foreach ($info_sale_item as $key => $val):
                if ($sale_id == $val['sale_id']):
                    foreach ($get_taxes_item as $get_value):
                        if ($val['item_id'] == $get_value['item_id']):
                           
                            ?>
                              <?php
                                   if($val['unit_item'] == $get_value['unit_from']){
                                       $item_unit = $get_value['unit_from'];
                                   }else{
                                        $item_unit = $get_value['unit'];
                                   }
                               ?>
                            <tr>
                                <td style="width: 5%; text-align: center"><?= $stt++; ?></td>
                                <td style="width: 10%; text-align: center"><?= $this->Item->get_info($val['item_id'])->item_number ?></td>
                                <td style="width: 37%"><?= $this->Item->get_info($val['item_id'])->name; ?></td>
                                <td style="width: 8%; text-align: left"><?= $this->Unit->get_info($item_unit)->name; ?></td>
                                <?php
                                   if($val['unit_item'] == $get_value['unit_from']){
                                       $item_price = $val['item_unit_price_rate'];
                                   }else{
                                       $item_price = $val['item_unit_price'];
                                   }
                                    $total_tax = ($item_price * $val['quantity_purchased'] - $item_price * $val['quantity_purchased'] * $val['discount_percent'] / 100) * $val['taxes_percent'] / 100;
                                ?>
                                <td style=" text-align: right"><?= number_format($item_price); ?></td>
                                <td style="width: 10%; text-align: right"><?= abs($val['quantity_purchased']) ?></td>
                                <td style=" text-align: right"><?= $val['discount_percent']; ?></td>
                                <td style=" text-align: right"><?= $val['taxes_percent']; ?></td>
                                <td style="width: 10%; text-align: right">
                                    <?= number_format(($val['quantity_purchased'] * ($item_price - ($item_price * $val['discount_percent'] / 100)))) ?></td>

                            </tr>   
                    <?php
                    $total_quantity += $val['quantity_purchased'];
                    $total_discount += $val['discount_percent'];
                    $total_money += $val['quantity_purchased'] * ($item_price - ($item_price * $val['discount_percent'] / 100));
                    $tt += $total_tax;
                    $taxs += $get_value['taxes'];
                endif;
            endforeach;
        endif;
    endforeach;
endif;

  }else{
        $sale_all_pack = $this->Sale->all_sales_pack($sale_id);
        foreach ($sale_all_pack as $pack){
            
        
?>
      <tr>
                                <td style="width: 5%; text-align: center"><?= $stt++; ?></td>
                                <td style="width: 10%; text-align: center"><?= $this->Pack->get_info($pack->pack_id)->pack_number ?></td>
                                <td style="width: 37%"><?= $this->Pack->get_info($pack->pack_id)->name; ?></td>
                                <td style="width: 8%; text-align: left"><?= $this->Unit->get_info($pack->unit_pack)->name; ?></td>
                                <?php
                                    $item_price = $pack->pack_unit_price;
                                    $total_tax = ($item_price * $pack->quantity_purchased - $item_price * $pack->quantity_purchased * $pack->discount_percent / 100)*0;
                                ?>
                                <td style=" text-align: right"><?= number_format($item_price); ?></td>
                                <td style="width: 10%; text-align: right"><?= abs($pack->quantity_purchased) ?></td>
                                <td style=" text-align: right"><?= $pack->discount_percent; ?></td>
                                <td style=" text-align: right">0</td>
                                <td style="width: 10%; text-align: right">
                                    <?= number_format(($pack->quantity_purchased * ($item_price - ($item_price * $pack->discount_percent / 100)))) ?></td>

                            </tr>                         
  <?php
                    $total_quantity += $pack->quantity_purchased;
                    $total_discount += $pack->discount_percent;
                    $total_money += $pack->quantity_purchased * ($item_price - ($item_price * $pack->discount_percent / 100));
                    $tt += $total_tax;
                    $taxs += 0;
        }
    }
  ?>
    <tr>
            <td colspan="5" style="text-align: right; font-weight: bold">Tổng</td>
            <td style="width: 10%; text-align: right"><?= abs($total_quantity) ?></td>
            <td style="text-align:right"><?= $total_discount; ?></td>
            <td style="text-align:right"><?= $taxs; ?></td>
            <td style="width: 10%; text-align: right"><?= number_format(abs($total_money)) ?></td>
        </tr>
        <tr>
            <td colspan="9" style="text-align: right; font-weight: bold">Tổng giá trị đơn hàng : <?= to_currency(abs($total_money)) ?></td>
        </tr>
        <tr>
            <td colspan="9" style="text-align: right; font-weight: bold">Tổng thuế : <?= to_currency(abs($tt)) ?></td>
        </tr>
        <tr>
            <td colspan="9" style="text-align: right; font-weight: bold">Tổng thanh toán : <?= to_currency(abs($total_money + $tt)) ?></td>
        </tr>
        <tr>
            <td colspan="9" style="text-align: right; font-weight: bold">Chiết khấu tiền mặt : <?= to_currency($discount_money); ?></td>
        </tr>
<?php
$this->load->model('Sale');
$pay = $this->Sale->pay_amount_order();
foreach ($pay as $value) {
    if ($sale_id == $value['id_sale']) {
        if ($value['pays_amount'] > 0) {
            ?>
                    <tr>

                       <?php
                       $this->load->model('Sale');
    //foreach ($this->Sale->payment($sale_id) as $key) {?>
        
    <?php ?>
                       
                      
                        <td colspan="9" style="text-align: right; font-weight: bold">Đã thanh toán : <?php  $data['payment']=$this->Sale->payment($sale_id);
                                                                                                                            echo to_currency($data['payment'][0]['money']) ;?></td>
    <?php //}?> 
                   </tr>

                       <?php
                       $this->load->model('Sale');
    //foreach ($this->Sale->payment($sale_id) as $key) {?>
        
    <?php ?>
                       
                      
                        <td colspan="9" style="text-align: right; font-weight: bold">Đã thanh toán : <?php  $data['payment']=$this->Sale->payment($sale_id);
                                                                                                                            echo to_currency($data['payment'][0]['sum']) ;?></td>
    <?php //}?> 
                   </tr>

        <?php }
    }
} ?>

        <?php
        if ($info_sale->suspended == 1 || $info_sale->liability == 1 || $info_sale->materials == 1) {
            ?>
            <tr>
                <?php
                   if(($total_money + $tt) - $data['payment'][0]['money'] - $discount_money <= 0){
                ?>
                <td colspan="9" style="text-align: right; font-weight: bold">Còn nợ : 0
                </td>
                   <?php }else{?>

                <td colspan="9" style="text-align: right; font-weight: bold">Còn nợ : <?php echo to_currency(($total_money + $tt) - $data['payment'][0]['sum'] - $discount_money) ?>


                </td>
                   <?php }?>
                
            </tr>
        <?php } else { ?>
            <tr>
<<<<<<< .mine
                
=======
                <td colspan="9" style="text-align: right; font-weight: bold">Tiền trả lại khách : <?= to_currency($data['payment'][0]['sum']-($total_money + $tt)); ?></td>
>>>>>>> .r2460
            </tr>
        <?php }
        ?>

        <?php
        if ($dirh) {
            while (($dirElement = readdir($dirh)) !== false) {
                
            }
            closedir($dirh);
        }
        ?>
    </table>   

    <?php
    //echo form_submit(array(
//        'name' => 'submit',
//        'id' => 'submit',
//        'value' => lang('common_submit'),
//        'class' => 'submit_button float_right',
//        'style' => "float: right; margin-right: 20px;",
    // ));
   
    ?>
</fieldset>

</form>



<script>
    $(document).ready(function () {
        setTimeout(function () {
            $(":input:visible:first", "#approve_form").focus();
        }, 100);
        var submitting = false;
        $('#approve_form').validate({
            submitHandler: function (form) {
                if (submitting)
                    return;
                submitting = true;
                $(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
                $(form).ajaxSubmit({
                    success: function (response) {
                        submitting = false;
                        tb_remove();
                        post_receiving_form_submit(response);
                    },
                    dataType: 'json'
                });
            }
        });
    });
</script>
<style>  
    #info_order p{
        padding-left: 10px;
        font-size: 14px;
    }
    #table_export_item{
        border-collapse: collapse;
        width: 100%;
        margin: 0px auto;
    }
    #table_export_item tr th{
        border: 1px solid #999999;
        padding: 3px 0px;
        background: #158ca0 ;
        color: #FFFFFF;
        text-align: center;
    }
    #table_export_item tr td{
        border: 1px solid #999999;
        padding: 3px 5px;
    }
</style>