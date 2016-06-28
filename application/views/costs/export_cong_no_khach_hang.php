<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">
    <div style="color:#000">
    <a style="font-size:18px;text-decoration: underline; margin-left:850px" href="<?= site_url()?>costs/report_cong_no_khach_hang">Trở lại</a>
    <div><?= $company?></div>
    <div><?= $C_address?></div>
    <br>
    <div style="font-size: 15px; text-align:center; font-weight:bold;">SỔ CHI TIẾT CÔNG NỢ KHÁCH HÀNG</div>
    <div style="font-size: 15px; text-align:center; font-weight:bold;padding: 5px;">
        <?= $acc_id.' - '.$this->Tkdu->get_info($acc_id)->name?></div>
    <div style="font-size: 15px; text-align:center; font-weight:bold;padding: 5px;">
        <?= 'Khách hàng: '.$this->Person->get_info($customer_id)->first_name
                        .' '.$this->Person->get_info($customer_id)->last_name?>
    </div>
    <div colspan ="5" style="text-align:center; font-style:italic; font-size:13px">
        Từ ngày : <?= date('d-m-Y H:i:s', strtotime($start_date)); ?> 
        đến ngày: <?= date('d-m-Y H:i:s', strtotime($end_date)); ?>
    </div>
    <div style="font-size: 14px;float: right; margin-right: 80px">
        <?php
        $oh_year = date('Y', strtotime($start_date));
        $info_kh_by_year = $this->Tkdu->get_info_cong_no_kh_by_year($customer_id, $oh_year);

        $diary_before = $this->Cost->get_account_money('2008-08-08 08:08:08', $start_date, $acc_id, $acc_arr);      
        $total_no8 = 0;
        $total_co8 = 0;
        if(count($diary_before)>0){       
            foreach ($diary_before as $data_diary){
                if($data_diary['id_customer']==$customer_id){
                    $chek_no = 0;
                    $chek_co = 0;
                    foreach ($acc_arr as $acc_arr1){
                        if($data_diary['tk_no']==$acc_arr1['id']){
                            $chek_no = 1;
                        }elseif($data_diary['tk_co']==$acc_arr1['id']){
                            $chek_co = 1;
                        }
                    }
                    if($data_diary['tk_no']==$acc_id || $chek_no == 1){
                        $total_no8 += $data_diary['money'];
                    }elseif($data_diary['tk_co']==$acc_id ||$chek_co == 1 ){
                        $total_co8 += $data_diary['money'];
                    }
                }
            }
        }
        if($info_kh_by_year->num_rows() > 0){
            $info_kh = $info_kh_by_year->row();    
            $tong_co8 = $info_kh->du_no > 0 ? $total_co8                      : $total_co8 + $info_kh->du_co;
            $tong_no8 = $info_kh->du_no > 0 ? $total_no8 + $info_kh->du_no    : $total_no8;
        }else{
            $tong_co8 = $total_co8;
            $tong_no8 = $total_no8;
        }    
        $hieu_before = $tong_no8 - $tong_co8;
        if($total_no8 == 0 && $total_co8 == 0){
            $show = $info_kh->du_co > 0 
                ? 'Dư có đầu kỳ: '.number_format(abs($hieu_before))
                : 'Dư nợ đầu kỳ: '.number_format(abs($hieu_before));
        }else{
            $show = $hieu_before > 0 
                ? 'Dư có đầu kỳ: '.number_format(abs($hieu_before))
                : 'Dư nợ đầu kỳ: '.number_format(abs($hieu_before));
        }
        echo $hieu_before != 0 ? $show : '';?>
    </div> 
    <table class="detail_acc">
    <tr style="text-align:center;background-color: #999999">
        <th colspan="2" >CHỨNG TỪ</th>
<!--        <th rowspan="2" style="width: 10%">MÃ KHÁCH HÀNG</th>-->
      <th rowspan="2" style="width: 25%">DIỄN GIẢI</th>
        <th rowspan="2" style="width: 10%">TK Đ.ỨNG</th>
        <th colspan="3">SỐ PHÁT SINH</th>
    </tr>
    <br>
    <tr style="text-align:center; background-color: #999999">
        <th style="width: 15%">NGÀY</th>
        <th style="width: 10%">SỐ</th>        
        <th style="width: 10%">NỢ</th>
        <th style="width: 10%">CÓ</th>
<!--        <th style="width: 10%">TỒN</th>-->
    </tr>
    <br>
    <?php    
    if(count($diary8)>0){       
        foreach ($diary8 as $data_diary){
             $info_cost = $this->Cost->get_info($data_diary->id_cost);
                            $total_no += $data_diary->money_no;
                            $total_co += $data_diary->money_co;
//            if($data_diary['id_customer']==$customer_id){
//                $chek_no = 0;
//                $chek_co = 0;
//                foreach ($acc_arr as $acc_arr1){
//                    if($data_diary['tk_no']==$acc_arr1['id']){
//                        $chek_no = 1;
//                    }elseif($data_diary['tk_co']==$acc_arr1['id']){
//                        $chek_co = 1;
//                    }
//                }
//                if($data_diary['tk_no']==$acc_id || $chek_no == 1){
//                    $total_no += $data_diary['money'];
//                }elseif($data_diary['tk_co']==$acc_id ||$chek_co == 1 ){
//                    $total_co += $data_diary['money'];
//                }
//                $this->load->model('Cost');
//                $no = $this->Cost->get_no_111($data_diary['id_cost'],$acc_id,$acc_arr);
//                $money_no = 0;
//                $money_co = 0;
//                foreach ($no as $no1){
//                    if($no1['id_customer']==$customer_id){
//                        $money_no += $no1['money'];
//                    }                
//                }            
//                $co = $this->Cost->get_co_111($data_diary['id_cost'],$acc_id,$acc_arr);
//                foreach ($co as $co1){
//                    if($co1['id_customer']==$customer_id){
//                    $money_co += $co1['money'];
//                    }
//                }
                ?>
                <tr style="font-size: 12px;">
                    <td style="text-align: center;"> <?php echo date('d-m-Y H:i:s', strtotime($data_diary->date)) ?></td>
                    <td style="text-align: center;"><?= $data_diary->id_cost ?></td>
<!--                    <td style="text-align: center;"><?= $customer_id?></td>
                    <td><?= $this->Person->get_info($customer_id)->first_name.' '.$this->Person->get_info($customer_id)->last_name?></td>-->
                     <td style="text-align: left;"><?= $data_diary->stt_cmt == 1 ? $data_diary->comment : $info_cost->comment?></td>
                    <td style="text-align: center;"><?= $data_diary->tkdu ?></td>
                    
                    <td style="text-align: right;"> <?= number_format($data_diary->money_no) ?></td>
                    <td style="text-align: right;"> <?= number_format($data_diary->money_co) ?></td>
<!--                    <td style="text-align: right;"><?= number_format($money_no-$money_co)?></td>-->
                </tr>
                <?php 
            //}
        }
    }else{?>
        <tr>
            <td colspan="5">Không có dữ liệu</td>
        </tr>
    <?php 
    }?>
    <tr style="font-weight: bold">
        <td colspan="5" style="text-align: right;">Tổng phát sinh nợ</td>
        <td style="text-align: right;"> <?= number_format($total_no)?></td>
    </tr>
    <tr style="font-weight: bold">
        <td colspan="5" style="text-align: right;">Tổng phát sinh có</td>
        <td style="text-align: right;"> <?= number_format($total_co)?></td>
    </tr>
    <tr style="font-weight: bold">
        <?php 
        $tong_co = $hieu_before > 0 ? $total_co + $hieu_before  : $total_co;
        $tong_no = $hieu_before > 0 ? $total_no                 : $total_no + $hieu_before;
        $hieu = $tong_no - $tong_co;
        $text = $hieu > 0 
            ? 'Số dư nợ cuối kỳ: '
            : 'Số dư có cuối kỳ: ';
        ?>
        <td colspan="5" style="text-align: right;">
            <?= $text ?>
        </td>
        <td style="text-align: right;">
            <?= number_format(abs($hieu)) ?>
        </td>
    </tr>
    </table>
    <br>
    <table id="ky_ten">
        <tr>
            <td></td>
            <td style="text-align: center; font-weight: bold">Ngày ... tháng ... năm ...  </td>
        </tr>
        <tr style="text-align: center; margin-top:5px;">
            <td style="width: 50%">KẾ TOÁN</td>
            <td style="width: 50%">NGƯỜI GHI SỔ</td>        
        </tr>
        <tr style="text-align: center;">
            <td>(ký, họ tên)</td>
            <td>(ký, họ tên)</td>
        </tr>
    </table>
    <br>
    <br>
    <div style="font-size: 14px; text-align: center;">
        <a href = "<?= site_url() ?>/accountings" id="submit" class="print_report" 
           onclick = "this.style.display = 'none'; window.print();">In sổ</a>
    </div>   
    <br>
    </div>
</div>
</div>
<?php $this->load->view("partial/footer"); ?>
<style>
    table tr td {
        font-size: 12px;
        padding-left: 5px;
        padding-right: 5px;
    }
    div{
        font-size: 12px;
    }
    .detail_acc{
        border-collapse: collapse;
    }
    .detail_acc tr td{
    border: 1px solid #000000;
    -moz-box-sizing: border-box;
    }
    .detail_acc tr th{
    border: 1px solid #000000;
    }
</style>