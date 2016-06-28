<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">
    <div style="color:#000">
    <a style="font-size:18px;text-decoration: underline; margin-left:850px" href=" <?php echo site_url()?>/costs/result_business">Trở lại</a>
    <div><?php echo $company?></div>
    <div><?php echo $C_address?></div>
    <br>
    <div style="font-size: 15px; text-align:center; font-weight:bold;">BÁO CÁO KẾT QUẢ HOẠT ĐỘNG KINH DOANH</div>
    <div colspan ="11" style="text-align:center; font-style:italic; font-size:13px">Từ ngày : <?php echo date('d-m-Y H:i:s', strtotime($start_date)); ?> đến ngày: <?php echo date('d-m-Y H:i:s', strtotime($end_date)); ?></div>
    <table class="detail_acc">
    <tr style="text-align:center;background-color: #999999">
        <th style="width: 50%">CHỈ TIÊU</th>
        <th style="width: 10%">MÃ SỐ</th>
        <th style="width: 10%">THUYẾT MINH</th>
        <th style="width: 15%">NĂM NAY</th>
        <th style="width: 15%">NĂM TRƯỚC</th>
    </tr>
    <br>
    <?php
    $acc_id = array(511,515,711,632,642,635,811,821,421);
    foreach ($acc_id as $acc){
        $acc_arr = $this->Cost->get_child_acc_by_id($acc);
        $diary = $this->Cost->get_account_money($start_date, $end_date,$acc, $acc_arr);
        if(count($diary)>0){
            foreach ($diary as $data_diary){
                $chek_no = 0;
                $chek_co = 0;
                foreach ($acc_arr as $acc_arr1){
                    if($data_diary['tk_no']==$acc_arr1['id']){
                        $chek_no = 1;
                    }elseif($data_diary['tk_co']==$acc){
                        $chek_co = 1;
                    }
                }
                if($data_diary['tk_no']==$acc || $chek_no == 1){
                    $money_no[$acc] += $data_diary['money'];
                }elseif($data_diary['tk_co']==$acc ||$chek_co == 1 ){
                    $money_co[$acc] += $data_diary['money'];
                }
            } 
        } 
    }
    ?>
    <tr>
        <td>1. Doanh thu bán hàng và cung cấp dịch vụ</td>
        <td>01</td>
        <td></td>
        <td><?php echo number_format($money_co[511])?></td>
        <td></td>        
    </tr>
    <tr>
        <td>2. Các khoản giảm trừ doanh thu</td>
        <td>02</td>
        <td></td>
        <td><?php echo number_format($money_no[511])?></td>
        <td></td>
    </tr>
    <tr>
        <td>3. Doanh thu thuần về BH và cung cấp DV (10=01-02)</td>
        <td>10</td>
        <td></td>
        <td><?php echo number_format($money_co[511]-$money_no[511])?></td>
        <td></td>
    </tr>
    <tr>
        <td>4. Giá vốn hàng bán</td>
        <td>11</td>
        <td></td>
        <td><?php echo number_format($money_no[632]-$money_co[632])?></td>
        <td></td>
    </tr>
    <tr>
        <td>5. Lợi nhuận gộp về bán hàng và cung cấp DV (20=10-11)</td>
        <td>20</td>
        <td></td>
        <td><?php echo number_format(($money_co[511]-$money_no[511])-($money_no[632]))?></td>
        <td></td>
    </tr>
    <tr>
        <td>6. Doanh thu hoạt động tài chính</td>
        <td>21</td>
        <td></td>
        <td><?php echo number_format($money_no[515])?></td>
        <td></td>
    </tr>
    <tr>
        <td>7. Chi phí tài chính</td>
        <td>22</td>
        <td></td>
        <td><?php echo number_format($money_co[635])?></td>
        <td></td>
    </tr>
     <tr>
        <td>8. Chi phí quản lý kinh doanh</td>
        <td>24</td>
        <td></td>
        <td><?php echo number_format($money_co[642])?></td>
        <td></td>
    </tr>
    <tr>
        <td>9. Lợi nhuận thuần từ hoạt động kinh doanh  {30=20+(21-22)-24}</td>
        <td>30</td>
        <td></td>
        <td><?php echo number_format(($money_co[511]-$money_no[511])-($money_no[632])+($money_no[515]-$money_co[635])-$money_co[642])?></td>
        <td></td>
    </tr>
    <tr>
        <td>10. Thu nhập khác</td>
        <td>31</td>
        <td></td>
        <td><?php echo number_format($money_no[711])?></td>
        <td></td>
    </tr>
    <tr>
        <td>11. Chi phí khác</td>
        <td>32</td>
        <td></td>
        <td><?php echo number_format($money_co[811])?></td>
        <td></td>
    </tr>
    <tr>
        <td>12. Lợi nhuận khác (40=31-32)</td>
        <td>40</td>
        <td></td>
        <td><?php echo number_format($money_no[711]-$money_co[811])?></td>
        <td></td>
    </tr>
    <tr>
        <td>13. Tổng lợi tức trước thuế (50=30+40)</td>
        <td>50</td>
        <td></td>
        <td><?php echo number_format(($money_co[511]-$money_no[511])-($money_no[632])+($money_no[515]-$money_co[635])-$money_co[642]+$money_no[711]-$money_co[811])?></td>
        <td></td>
    </tr>
    <tr>
        <td>14. Chi phí thuế thu nhập doanh nghiệp hiện hành</td>
        <td>51</td>
        <td></td>
        <td><?php echo number_format($money_co[821])?></td>
        <td></td>
    </tr>
    <tr>
        <td>15. Lợi nhuận sau thuế thu nhập doanh nghiệp(60=50-51-52)</td>
        <td>60</td>
        <td></td>
        <td><?php echo number_format(($money_co[511]-$money_no[511])-($money_no[632])+($money_no[515]-$money_co[635])-$money_co[642]+$money_no[711]-$money_co[811]-$money_co[821])?></td>
        <td></td>
    </tr>
    </table>
    <br>
    <table id="ky_ten">
        <tr>
            <td></td>
            <td></td>
            <td style="text-align: center; font-weight: bold">Ngày ... tháng ... năm ...  </td>
        </tr>
        <tr style="text-align: center; margin-top:5px;">
            <td style="width: 33%">NGƯỜI GHI SỔ</td>
            <td style="width: 33%">KẾ TOÁN</td>
            <td style="width: 34%">GIÁM ĐỐC</td>
        </tr>
        <tr style="text-align: center;">
            <td>(ký, họ tên)</td>
            <td>(ký, họ tên)</td>
            <td>(ký, họ tên, đóng dấu)</td>
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
    text-align: right;
    }
    .detail_acc tr td:first-child{
        text-align: left;
    }
    .detail_acc tr td:nth-child(2){
        text-align: center;
    }
    .detail_acc tr td:nth-child(3){
        text-align: center;
    }
    
    .detail_acc tr th{
    border: 1px solid #000000;
    }
</style>