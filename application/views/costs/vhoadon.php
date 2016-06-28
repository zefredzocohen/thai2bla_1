<meta charset="utf8">
<title>In phiếu chứng từ</title>
<style>
    .italic{
        font-style: italic;
    }
    .width{
        width: 700px;
        display: block;
        overflow: hidden;
        position: relative;
    }
    .left{
        margin-left: 480px;
    }
    .bold{
        font-weight: bold;
        margin-bottom: 0px;
    }
    .center{
        text-align: center;
    }    
    .print_report{
        background: none repeat scroll 0 0 #1E5A96;
        border: 1px solid #EEEEEE;
        color: #FFFFFF;
        font-size: 14px;
        font-weight: bold;
        line-height: 30px;
        padding: 5px;
        text-align: center;
        text-decoration: none;
        margin: 10px;
        float: right;
    }
    .info_company{
        width: 100%;
    }
    .info_company td p {
        line-height: 8px;
    }
    #info_user{
        display: block;
        overflow: hidden;
        position: relative;
    }
    #info_user div{
        line-height: 25px;
    }
    .info_employee{
        width: 100%;
    }
</style>
<div class="width">
    <table class="info_company">
        <tr>
            <td style="float: left; font-size: 13px; margin-top:0px;">
                <p class='bold'><?php echo $company ?></p>
                <p class="italic"><?php echo $C_address ?></p>
            </td>
            <td style="float: right; font-size: 13; text-align: center;">
                <p class='bold'>Mẫu số 01 - TT</p>
                <p>Ban hành theo QĐ số 48/2006/QĐ - BTC</p>
                <p>Ngày 14 tháng 9 năm 2006</p>
                <p style="font-size: 16;">Liên: 1</p>
            </td>
        </tr>
    </table>
    <div style="margin-top: -30px; display: block; overflow: hidden; position: relative">
        <?php
        if ($form_cost == 0) {
            $tieude = 'PHIẾU THU';
        } else {
            $tieude = 'PHIẾU CHI';
        }
        ?>
        <h2 class='bold center'><?php echo $tieude ?></h2>       

        <p style="text-align:center;font-style: italic; line-height: 0px;">Ngày <?php echo date('d'); ?> tháng <?php echo date('m'); ?> năm <?php echo date('Y'); ?></p>

        <p style="float: right; margin: 0px 0px 0px 0px;">
            Số: <?php echo $cost->id_cost ?><br>
            Nợ: <?php echo $tk_no ?> ---- 
            Có: <?php echo $tk_co ?>               

        </p>       

    </div>
    <div id="info_user">
        <div>Họ và tên: <?php echo $name_person ?></div>
        <div>Địa chỉ: <?php echo $address ?></div>
        <div><?php
            if ($form_cost == 0) {
                echo "Lý do thu: " . $cost->comment;
            } else {
                echo "Lý do chi: " . $cost->comment;
            }
            ?>
        </div>
        <?php
        //$total = $this->Sale->get_info($cost->id_sale)->row()->later_cost_price;
        ?>
        <?php
          if($this->Cost->get_info($id)->id_customer == 0 && $this->Cost->get_info($id)->supplier_id !=0){
        ?>
        <div>Số tiền: <?php echo to_currency_unVND($cost->money_du); ?> VNĐ</div>
         <?php }else{?>
        <div>Số tiền: <?php echo to_currency_unVND($cost->money); ?> VNĐ</div>
         <?php }?>
        
        <div><i>(Bằng chữ: <?php echo $money_text; ?> )</i></div>
        <div>Kèm theo: <?php echo $cost->chungtu ?></div>

        <?php
            if($form_cost == 0){
             $id = $cost->id_cost;
            $sale_id = $this->Cost->get_info($id)->id_sale;
            $data_sale_payment1 = $this->Sale->get_payment_sale_by_sale_id($cost->id_sale);
            $to = 0; //Tiền khách còn nợ của đơn hàng tương ứng
            $do = 0; //Tiền chiết khấu cho khách hàng của đơn hàng tương ứng
           
            $total_cost_sale = 0;//tổng chi phí
            foreach ($data_sale_payment1 as $val1) {
                $to = $to + $val1['payment_amount'];
                $do = $do + $val1['discount_money'];
            }
            $id = $cost->id_cost;
            
           $total = $this->Sale->get_info($sale_id)->row()->later_cost_price;
            if($this->Cost->get_info($id)->id_customer == 0 && $this->Cost->get_info($id)->supplier_id !=0){
                echo "";
            }else{
                if ($total <= ($to+$do)) {
                    $data_sale_customer = array(
                            'suspended' => 0
                         );
                    $this->Sale->update_sale_customer($data_sale_customer,$cost->id_sale);
                    ?>
                <div>Tiền trả lại: <?php echo number_format($cost->money_du - $cost->money) ?></div>
                <?php 
                
                } 
            }
        }else{
             $id1 = $cost->id_cost;
            $total_recv = $this->Receiving->get_info($cost->id_receiving)->row()->later_cost_price;
                $data_sale_payment1 = $this->Sale->get_tam_receiving_by_receiving_id($cost->id_receiving);
            $to = 0; //Tiền khách còn nợ của đơn hàng tương ứng
            $do = 0; //Tiền chiết khấu cho khách hàng của đơn hàng tương ứng
            $total_cost_sale = 0;//tổng chi phí
            foreach ($data_sale_payment1 as $val1) {
                $to = $to + $val1['pays_amount'];
                $do = $do + $val1['discount_money'];
            }
            
            
            if($this->Cost->get_info($id1)->id_customer != 0 && $this->Cost->get_info($id1)->supplier_id ==0){
                echo "";
            }else{
                if ($total_recv['total_price']-$to-$do <=0) {
                     $data_sale_recv = array(
                            'suspended' => 0
                         );
                    $this->Receiving->update_recv_customer($data_sale_recv,$cost->id_receiving);
                    ?>
                <div>Tiền trả lại: <?php echo number_format($this->Cost->get_info($cost->id_cost)->money_du - $this->Cost->get_info($cost->id_cost)->money) ?></div>
                <?php
                }
            }
              
        }
        ?>
    </div>
    <div class="left italic">Ngày.....tháng.....năm.......</div>
    <br>
    <table class="info_employee">
        <tr class='bold'>
            <td>Giám đốc</td>
            <td>Kế toán trưởng</td>
            <td>Thủ quỹ</td>
            <td>Người lập biểu</td>
            <?php if ($form_cost == 0) { ?>
                <td>Người nộp tiền</td>
            <?php } else { ?>
                <td>Người nhận tiền</td>
            <?php } ?>

        </tr>
        <tr>
            <td>(ký, họ tên, đóng dấu)</td>
            <td>(ký, họ tên)</td>
            <td>(ký, họ tên)</td>
            <td>(ký, họ tên)</td>
            <td>(ký, họ tên)</td>
        </tr>
    </table>
    <div style="font-size: 14px; text-align: center;">
        <a href = "<?= site_url() ?>/costs" id="submit" class='print_report' onclick = "this.style.display = 'none';
                window.print();">In hóa đơn</a>
    </div>    
</div>