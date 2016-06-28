<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">
    <div style="color:#000">
    <a style="font-size:18px;text-decoration: underline; margin-left:850px" href=" <?php echo site_url()?>/costs/report_dongtien">Trở lại</a>
    <div><?php echo $company?></div>
    <div><?php echo $C_address?></div>
    <br>
    <div style="font-size: 15px; text-align:center; font-weight:bold;">BÁO CÁO LƯU CHUYỂN TIỀN TỆ</div>
    <div style="font-size: 15px; text-align:center;">(Theo phương pháp trực tiếp)</div>
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
    $acc_id = array(5111,5112,5113,131,3387,521,532,152,153,156,6278,642,641,627,334,635,335,3334,711,144,344,133,811,13311,431,3331,3333,3337,3338,211,212,213,241,222,221,515,421,341,411,311,342);
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
                $acc_1 = $this->Cost->get_child_acc_by_id(111);
                $acc_2 = $this->Cost->get_child_acc_by_id(112);
                $acc_3 = $this->Cost->get_child_acc_by_id(113);
                $acc_t = array_merge($acc_1,$acc_2);
                $acc_all = array_merge($acc_t,$acc_3);                               
                if($data_diary['tk_no']==$acc || $chek_no == 1){
                    foreach ($acc_all as $acc1){
                        if($data_diary['tk_co']=='111' || $data_diary['tk_co'] =='112' || $data_diary['tk_co'] =='113' ||$data_diary['tk_co']==$acc1['id']){
                            $n[$acc] += $data_diary['money'];                           
                        }
                    }
                }elseif($data_diary['tk_co']==$acc ||$chek_co == 1 ){
                    foreach ($acc_all as $acc){
                        if($data_diary['tk_no']=='111' || $data_diary['tk_no'] =='112' || $data_diary['tk_no'] == '113' ||$data_diary['tk_no']==$acc1['id'] ){
                            $c[$acc] += $data_diary['money'];
                        }
                    }
                }
            } 
        }
    }
    $ms01 = $c[5111]+$c[5112]+$c[5113]+$c[131]+$c[3387]-($n[521]+$n[33311]+$n[532]);
    $ms02 = $n[152]+$n[153]+$n[156]+$n[13311]+$n[6278]+$n[642]+$n[641]+$n[331];
    $ms06 = $c[711]+$c[33311]+$c[344]+$c[133]+$c[144];
    $ms07 = $n[811]+$n[13311]+$n[144]+$n[344]+$n[431]+$n[3331]+$n[3333]+$n[3337]+$n[3338];
    $ms20 = $ms01+$ms02+$ms06+$ms07+$n[334]+$n[635]+$n[335]+$n[3334];
    $ms21 = $n[211]+$n[212]+$n[213]+$n[241];
    $ms22 = $c[211]+$c[212]+$c[213]+$c[241]+$c[711];
    $ms30 = $ms21+$ms22+$n[222]+$n[221]+$c[222]+$c[515]+$c[421];
    $ms40 = $c[411]+$n[411]+$c[311]+$c[341]+$c[342]+$n[311]+$n[341]+$n[342];
    $ms50 =$ms20+$ms30+$ms40;
    
    ?>
    <tr class="bold">
        <td>I. Lưu chuyển tiền từ hoạt động kinh doanh</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>        
    </tr>
    <tr>
        <td>1. Thu tiền từ bán hàng, cung cấp dịch vụ và doanh thu khác </td>
        <td>01</td>
        <td></td>
        <td><?php echo number_format($ms01)?></td>
        <td></td>
    </tr>
    <tr>
        <td> 2. Tiền chi trả cho người cung cấp hàng hoá, dịch vụ</td>
        <td>02</td>
        <td></td>
        <td><?php echo number_format($ms02)?></td>
        <td></td>
    </tr>
    <tr>
        <td> 3. Tiền chi trả cho người lao động</td>
        <td>03</td>
        <td></td>
        <td><?php echo number_format($n[334])?></td>
        <td></td>
    </tr>
    <tr>
        <td>4. Tiền chi trả lãi vay</td>
        <td>04</td>
        <td></td>
        <td><?php echo number_format($n[635]+$n[335])?></td>
        <td></td>
    </tr>
    <tr>
        <td> 5. Tiền chi nộp thuế TNDN</td>
        <td>05</td>
        <td></td>
        <td><?php echo number_format($n[3334])?></td>
        <td></td>
    </tr>
    <tr>
        <td> 6. Tiền thu khác từ hoạt động kinh doanh</td>
        <td>06</td>
        <td></td>
        <td><?php echo number_format($ms06)?></td>
        <td></td>
    </tr>
     <tr>
        <td>7. Tiền chi khác do hoạt động kinh doanh</td>
        <td>07</td>
        <td></td>
        <td><?php echo number_format($ms07)?></td>
        <td></td>
    </tr>
    <tr class="bold">
        <td>Lưu chuyển tiền thuần từ hoạt động kinh doanh(20 = 01+ 02+ 03+ 04+ 05+ 06+ 07)</td>
        <td>20</td>
        <td></td>
        <td><?php echo number_format($ms20)?></td>
        <td></td>
    </tr>
    <tr class="bold">
        <td> II. Lưu chuyển tiền từ hoạt động đầu tư</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td> 1. Tiền chi để mua sắm, xây dựng TSCĐ và các tài sản dài hạn khác</td>
        <td>21</td>
        <td></td>
        <td><?php echo number_format($ms21)?></td>
        <td></td>
    </tr>
    <tr>
        <td> 2. Tiền thu từ thanh lý, nhượng bán TSCĐ và các tài sản dài hạn khác</td>
        <td>22</td>
        <td></td>
        <td><?php echo number_format($ms22)?></td>
        <td></td>
    </tr>
    <tr>
        <td> 3. Tiền chi cho vay, mua  các công cụ nợ của đơn vị khác</td>
        <td>23</td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td> 4. Tiền thu hồi cho vay, bán lại các công cụ nợ của đơn vị khác</td>
        <td>24</td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>5. Tiền chi đầu tư góp vốn vào đơn vị khác</td>
        <td>25</td>
        <td></td>
        <td><?php echo number_format($n[222]+$n[221])?></td>
        <td></td>
    </tr>
    <tr>
        <td> 6. Tiền thu hồi đầu tư góp vốn vào đơn vị khác</td>
        <td>26</td>
        <td></td>
        <td><?php echo number_format($c[222])?></td>
        <td></td>
    </tr>
    <tr>
        <td> 7. Tiền thu lãi cho vay, cổ tức và lợi nhuận được chia</td>
        <td>27</td>
        <td></td>
        <td><?php echo number_format($c[515]+$c[421])?></td>
        <td></td>
    </tr>
    <tr class="bold">
        <td>Lưu chuyển tiền thuần từ hoạt động đầu tư(30 = 21+22+23+24+25+26+27)</td>
        <td>30</td>
        <td></td>
        <td><?php echo number_format($ms30)?></td>
        <td></td>
    </tr>
    <tr class="bold">
        <td> III. Lưu chuyển tiền từ hoạt động tài chính</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td> 1.Tiền thu từ phát hành cổ phiếu, nhận vốn góp của chủ sở hữu</td>
        <td>31</td>
        <td></td>
        <td><?php echo number_format($c[411])?></td>
        <td></td>
    </tr>
    <tr>
        <td> 2. Tiền chi trả vốn góp cho các chủ sở hữu, mua lại cổ phiếu của các doanh nghiệp đã phát hành</td>
        <td>32</td>
        <td></td>
        <td><?php echo number_format($n[411])?></td>
        <td></td>
    </tr>
    <tr>
        <td> 3. Tiền vay ngắn hạn, dài hạn nhận được</td>
        <td>33</td>
        <td></td>
        <td><?php echo number_format($c[311]+$c[341]+$c[342])?></td>
        <td></td>
    </tr>
    <tr>
        <td>4. Tiền chi trả nợ gốc vay</td>
        <td>34</td>
        <td></td>
        <td><?php echo number_format($n[311]+$n[341]+$n[342])?></td>
        <td></td>
    </tr>
    <tr>
        <td>5. Tiền chi trả nợ thuê tài chính</td>
        <td>35</td>
        <td></td>
        <td><?php echo number_format()?></td>
        <td></td>
    </tr>
    <tr>
        <td> 6. Cổ tức, lợi nhuận đã chi trả cho chũ sở hữu</td>
        <td>36</td>
        <td></td>
        <td><?php echo number_format()?></td>
        <td></td>
    </tr>
    <tr class="bold">
        <td> Lưu chuyển tiền thuần từ hoạt động tài chính(40= 31+32+33+34+35+36)</td>
        <td>40</td>
        <td></td>
        <td><?php echo number_format($ms40)?></td>
        <td></td>
    </tr>
    <tr class="bold">
        <td> Lưu chuyển tiền thuần trong kỳ (50= 20+30+40)</td>
        <td>50</td>
        <td></td>
        <td><?php echo number_format($ms50)?></td>
        <td></td>
    </tr>
    <tr class="bold">
        <td> Tiền và tương đương tiền đầu kỳ</td>
        <td>60</td>
        <td></td>
        <td><?php echo number_format($ms60)?></td>
        <td></td>
    </tr>
    <tr>
        <td>Ảnh hưởng của thay đổi tỷ giá hối đoái quy đổi ngoại tệ</td>
        <td>61</td>
        <td></td>
        <td><?php echo number_format($ms61)?></td>
        <td></td>
    </tr>
     <tr class="bold">
        <td>Tiền và tương đương tiền cuối kỳ (50+60+61)</td>
        <td>70</td>
        <td></td>
        <td><?php echo number_format($ms70)?></td>
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
    .bold {
        font-weight: bold;
    }
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