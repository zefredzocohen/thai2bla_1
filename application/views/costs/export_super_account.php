<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">
    <div style="color:#000">
    <a style="font-size:18px;text-decoration: underline; margin-left:850px" href=" <?php echo site_url()?>/costs/detail_account">Trở lại</a>
    <div><?php echo $company?></div>
    <div><?php echo $C_address?></div>
    <br>
    <div style="font-size: 15px; text-align:center; font-weight:bold;">SỔ CÁI TÀI KHOẢN</div>
    <div style="font-size: 15px; text-align:center; font-weight:bold;padding: 5px;"><?php echo $acc_id.' - '.$this->Tkdu->get_info($acc_id)->name?></div>
    <div colspan ="11" style="text-align:center; font-style:italic; font-size:13px">Từ ngày : <?php echo date('d-m-Y H:i:s', strtotime($start_date)); ?> đến ngày: <?php echo date('d-m-Y H:i:s', strtotime($end_date)); ?></div>
    <table class="detail_acc">
    <tr style="text-align:center;background-color: #999999">
        <th colspan="2" >CHỨNG TỪ</th>
        <th rowspan="2" style="width: 45%">DIỄN GIẢI</th>
        <th rowspan="2" style="width: 10%">TK Đ.ỨNG</th>
        <th colspan="2">SỐ PHÁT SINH</th>
    </tr>
    <br>
    <tr style="text-align:center; background-color: #999999">
        <th style="width: 15%">NGÀY</th>
        <th style="width: 10%">SỐ</th>
        <th style="width: 10%">NỢ</th>
        <th style="width: 10%">CÓ</th>    
    </tr>
    <?php 
    
    if(count($diary)>0){
        foreach ($diary as $data_diary){
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
                $total_no += $data_diary['money'];
            }elseif($data_diary['tk_co']==$acc_id ||$chek_co == 1 ){
                $total_co += $data_diary['money'];
            }
            ?>
    <tr style="font-size: 12px;">
        <td style="text-align: center;"> <?php echo date('d-m-Y H:i:s',strtotime($data_diary['date']))?></td>
        <td style="text-align: center;"><?php echo $data_diary['id_cost']?></td>
        <td><?php echo $data_diary['comment']?></td>
        <td style="text-align: center;"><?php if($data_diary['tk_no']==$acc_id || $chek_no == 1){echo $data_diary['tk_co'];}else{echo $data_diary['tk_no'];}?></td>
        <td style="text-align: right;"><?php if($data_diary['tk_no']==$acc_id || $chek_no == 1){echo number_format($data_diary['money']);}?></td>
        <td style="text-align: right;"><?php if($data_diary['tk_co']==$acc_id || $chek_co == 1){echo number_format($data_diary['money']);}?></td>
    </tr>
        <?php }
    }else{?>
    <tr>
        <td colspan="11">Không có dữ liệu</td>
    </tr>
    <?php }
    ?>
    <tr style="font-weight: bold">
        <td colspan="5" style="text-align: right;">Tổng phát sinh nợ</td>
        <td style="text-align: right;"> <?php echo number_format($total_no)?></td>
    </tr>
    <tr style="font-weight: bold">
        <td colspan="5" style="text-align: right;">Tổng phát sinh có</td>
        <td style="text-align: right;"> <?php echo number_format($total_co)?></td>
    </tr>
    <tr style="font-weight: bold">
        <td colspan="5" style="text-align: right;">Số dư nợ cuối kỳ</td>
        <td style="text-align: right;"> <?php echo number_format($total_no-$total_co)?></td>
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
        <a href = "<?= site_url() ?>/accountings" id="submit" class="print_report" onclick = "this.style.display = 'none'; window.print();">In sổ</a>
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