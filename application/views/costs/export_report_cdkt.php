<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">
    <div style="color:#000">
    <a style="font-size:18px;text-decoration: underline; margin-left:850px" href=" <?php echo site_url()?>/costs/result_business">Trở lại</a>
    <div><?php echo $company?></div>
    <div><?php echo $C_address?></div>
    <br>
    <div style="font-size: 15px; text-align:center; font-weight:bold;">BẢNG CÂN ĐỐI KẾ TOÁN</div>
    <div colspan ="11" style="text-align:center; font-style:italic; font-size:13px">Tại, ngày <?php echo date('d-m-Y', strtotime($end_date)); ?></div>
    <table class="detail_acc">
    <tr style="text-align:center;background-color: #999999">
        <th style="width: 50%">CHỈ TIÊU</th>
        <th style="width: 10%">MÃ SỐ</th>
        <th style="width: 10%">THUYẾT MINH</th>
        <th style="width: 15%">SỐ CUỐI NĂM</th>
        <th style="width: 15%">SỐ ĐẦU NĂM</th>
    </tr>
    <br>
    <?php
    $acc_id = array(111,112,121,1591,131,331,1388,334,338,1592,152,153,154,155,156,157,1593,133,333,1381,141,142,211,2141,2142,2143,241,217,2147,221,229,138,242,244,311,315,3387,334,335,352,3411,3412,34131,34132,34133,351,3414,4111,4112,4118,419,413,418,421,431);
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
    $n110 = ($money_no[111]-$money_co[111])+ ($money_no[112]-$money_co[112]);
    $n120 = ($money_no[121]-$money_co[121])+ ($money_no[1591]-$money_co[1591]);
    $n130 = (($money_no[131]-$money_co[131])+($money_no[331]-$money_co[331])+(($money_no[1388]-$money_co[1388])+($money_no[334]-$money_co[334])+($money_no[338]-$money_co[338]))+($money_co[1592]-$money_no[1592]));
    $n141 = (($money_no[152]-$money_co[152])+($money_no[153]-$money_co[153])+($money_no[154]-$money_co[154])+($money_no[155]-$money_co[155])+($money_no[156]-$money_co[156])+($money_no[157]-$money_co[157]));
    $n140 = $n141+ ($money_co[1539]-$money_no[1539]);
    $n158 = (($money_co[1381]-$money_no[1381])+($money_co[141]-$money_no[141])+($money_co[142]-$money_no[142])+($money_co[1388]-$money_no[1388]));
    $n150 = ($money_no[133]-$money_co[133])+($money_no[333]-$money_co[333])+$n158;
    $n220 = (($money_co[2141]-$money_no[2141])+($money_co[2142]-$money_no[2142])+($money_co[2143]-$money_no[2143]))+($money_no[211]-$money_co[211])+($money_no[241]-$money_co[241]);
    $n240 = ($money_no[217]-$money_co[217])+($money_co[2147]-$money_no[2147]);
    $n250 = ($money_no[221]-$money_co[221])+($money_co[229]-$money_no[229]);
    $n261 = ($money_no[131]-$money_co[131])+($money_no[138]-$money_co[138])+($money_no[331]-$money_co[331])+($money_no[338]-$money_co[338]);
    $n262 = ($money_no[242]-$money_co[242])+($money_no[244]-$money_co[244]);
    $n260 = $n261+$n262+($money_co[1592]-$money_no[1592]);
    $n100 = $n110+$n120+$n130+$n140+$n150;
    $n200 = $n220+$n240+$n250+$n260;
    $n270 = $n100+$n200;
    $n310 = (($money_co[311]-$money_no[311])+($money_co[315]-$money_no[315]))+ ($money_co[331]-$money_no[331])+(($money_co[131]-$money_no[131])+($money_co[3387]-$money_no[3387])) +($money_co[333]-$money_no[333])+($money_co[334]-$money_no[334])+($money_co[335]-$money_no[335])+(($money_co[338]-$money_no[338])+($money_co[138]-$money_no[138]))+($money_co[352]-$money_no[352]);
    $n334 = ($money_co[3411]-$money_no[3411])+($money_co[3412]-$money_no[3412])+(($money_co[34131]-$money_no[34131])-($money_no[34132]-$money_co[34132])+($money_co[34133]-$money_no[34133]));
    $n333 = (($money_co[331]-$money_no[331])+($money_co[338]-$money_no[338])+($money_co[138]-$money_no[138])+($money_co[131]-$money_no[131])+($money_co[3414]-$money_no[3414]));
    $n330 = $n333 + $n334 +($money_co[351]-$money_no[351])+($money_co[352]-$money_no[352]);
    $n300 = $n310+$n330;
    $n410 = ($money_co[4111]-$money_no[4111])+($money_co[4112]-$money_no[4112])+($money_co[4118]-$money_no[4118])+($money_no[419]-$money_co[419])+($money_co[413]-$money_no[413])+($money_co[418]-$money_no[418])+($money_co[421]-$money_no[421]);
    $n430 = ($money_co[431]-$money_no[431]);
    $n400 = $n410+$n430;
    $n440 = $n300+$n400;
    ?>
    <tr class="bold">
        <td>A. Tài sản ngắn hạn(100=110+120+130+140+150)</td>
        <td>100</td>
        <td></td>
        <td><?php echo number_format($n100)?></td>
        <td></td>        
    </tr>
    <tr class="bold">
        <td>I. Tiền và các khoản tương đương tiền</td>
        <td>110</td>
        <td></td>
        <td><?php echo number_format($n110)?></td>
        <td></td>
    </tr>
    <tr>
        <td> 1. Tiền</td>
        <td>111</td>
        <td></td>
        <td><?php echo number_format($money_no[111]-$money_co[111])?></td>
        <td></td>
    </tr>
    <tr>
        <td> 2. Các khoản tương đương tiền</td>
        <td>112</td>
        <td></td>
        <td><?php echo number_format($money_no[112]-$money_co[112])?></td>
        <td></td>
    </tr>
    <tr class="bold">
        <td>II. Các khoản đầu tư tài chính ngắn hạn</td>
        <td>120</td>
        <td></td>
        <td><?php echo number_format($n120)?></td>
        <td></td>
    </tr>
    <tr>
        <td> 1. Đầu tư ngắn hạn</td>
        <td>121</td>
        <td></td>
        <td><?php echo number_format($money_no[121]-$money_co[121])?></td>
        <td></td>
    </tr>
    <tr>
        <td> 2. Dự phòng giảm giá đầu tư ngắn hạn (*) (2)</td>
        <td>129</td>
        <td></td>
        <td><?php echo number_format($money_no[1591]-$money_co[1591])?></td>
        <td></td>
    </tr>
     <tr class="bold">
        <td>III. Các khoản phải thu ngắn hạn</td>
        <td>130</td>
        <td></td>
        <td><?php echo number_format($n130)?></td>
        <td></td>
    </tr>
    <tr>
        <td> 1. Phải thu của khách hàng</td>
        <td>131</td>
        <td></td>
        <td><?php echo number_format($money_no[131]-$money_co[131])?></td>
        <td></td>
    </tr>
    <tr>
        <td> 2. Trả trước cho người bán</td>
        <td>132</td>
        <td></td>
        <td><?php echo number_format($money_no[331]-$money_co[331])?></td>
        <td></td>
    </tr>
    <tr>
        <td> 3. Phải thu nội bộ ngắn hạn</td>
        <td>133</td>
        <td></td>
        <td><?php echo number_format()?></td>
        <td></td>
    </tr>
    <tr>
        <td> 4. Phải thu theo tiến độ kế hoạch hợp đồng xây dựng</td>
        <td>134</td>
        <td></td>
        <td><?php echo number_format()?></td>
        <td></td>
    </tr>
    <tr>
        <td> 5. Các khoản phải thu khác</td>
        <td>135</td>
        <td></td>
        <td><?php echo number_format(($money_no[1388]-$money_co[1388])+($money_no[334]-$money_co[334])+($money_no[338]-$money_co[338]))?></td>
        <td></td>
    </tr>
    <tr>
        <td> 6. Dự phòng phải thu ngắn hạn khó đòi (*)</td>
        <td>139</td>
        <td></td>
        <td><?php echo number_format($money_co[1592]-$money_no[1592])?></td>
        <td></td>
    </tr>
    <tr class="bold">
        <td>IV. Hàng tồn kho</td>
        <td>140</td>
        <td></td>
        <td><?php echo number_format($n140)?></td>
        <td></td>
    </tr>
    <tr>
        <td> 1. Hàng tồn kho</td>
        <td>141</td>
        <td></td>
        <td><?php echo number_format($n141)?></td>
        <td></td>
    </tr>
    <tr>
        <td> 2. Dự phòng giảm giá hàng tồn kho (*)</td>
        <td>149</td>
        <td></td>
        <td><?php echo number_format($money_co[1539]-$money_no[1539])?></td>
        <td></td>
    </tr>
    <tr class="bold">
        <td>V. Tài sản ngắn hạn khác</td>
        <td>150</td>
        <td></td>
        <td><?php echo number_format($n150)?></td>
        <td></td>
    </tr>
    <tr>
        <td> 1. Chi phí trả trước ngắn hạn</td>
        <td>151</td>
        <td></td>
        <td><?php echo number_format()?></td>
        <td></td>
    </tr>
    <tr>
        <td> 2. Thuế GTGT được khấu trừ</td>
        <td>152</td>
        <td></td>
        <td><?php echo number_format($money_no[133]-$money_co[133])?></td>
        <td></td>
    </tr>
    <tr>
        <td> 3. Thuế và các khoản khác phải thu nhà nước</td>
        <td>154</td>
        <td></td>
        <td><?php echo number_format($money_no[333]-$money_co[333])?></td>
        <td></td>
    </tr>
    <tr>
        <td> 4. Tài sản ngắn hạn khác</td>
        <td>158</td>
        <td></td>
        <td><?php echo number_format($n158)?></td>
        <td></td>
    </tr>
    <tr class="bold">
        <td>B. Tài sản dài hạn (200=210+220+240+250+260)</td>
        <td>200</td>
        <td></td>
        <td><?php echo number_format($n200)?></td>
        <td></td>
    </tr>
    <tr class="bold">
        <td>I. Các khoản phải thu dài hạn</td>
        <td>210</td>
        <td></td>
        <td><?php echo number_format()?></td>
        <td></td>
    </tr>
    <tr>
        <td> 1. Phải thu dài hạn của khách hàng</td>
        <td>211</td>
        <td></td>
        <td><?php echo number_format()?></td>
        <td></td>
    </tr>
    <tr>
        <td> 2. Vốn kinh doanh ở đơn vị trực thuộc</td>
        <td>212</td>
        <td></td>
        <td><?php echo number_format()?></td>
        <td></td>
    </tr>
    <tr>
        <td> 3. Phải thu dài hạn nội bộ</td>
        <td>213</td>
        <td></td>
        <td><?php echo number_format()?></td>
        <td></td>
    </tr>
    <tr>
        <td> 4. Phải thu dài hạn khác</td>
        <td>218</td>
        <td></td>
        <td><?php echo number_format()?></td>
        <td></td>
    </tr>
    <tr>
        <td> 5. Dự phòng phải thu dài hạn khó đòi (*)</td>
        <td>219</td>
        <td></td>
        <td><?php echo number_format()?></td>
        <td></td>
    </tr>
     <tr class="bold">
        <td>II. Tài sản cố định</td>
        <td>220</td>
        <td></td>
        <td><?php echo number_format($n220)?></td>
        <td></td>
    </tr>
    <tr>
        <td> 1. Nguyên giá</td>
        <td>221</td>
        <td></td>
        <td><?php echo number_format($money_no[211]-$money_co[211])?></td>
        <td></td>
    </tr>
    <tr>
        <td> 2. Giá trị hao mòn lũy kế(*)</td>
        <td>222</td>
        <td></td>
        <td><?php echo number_format(($money_co[2141]-$money_no[2141])+($money_co[2142]-$money_no[2142])+($money_co[2143]-$money_no[2143]))?></td>
        <td></td>
    </tr>    
    <tr>
        <td> 3. Chi phí xây dựng cơ bản dở dang</td>
        <td>223</td>
        <td></td>
        <td><?php echo number_format($money_no[241]-$money_co[241])?></td>
        <td></td>
    </tr>
    <tr class="bold">
        <td>III. Bất động sản đầu tư</td>
        <td>240</td>
        <td></td>
        <td><?php echo number_format($n240)?></td>
        <td></td>
    </tr>
     <tr>
        <td> - Nguyên giá</td>
        <td>241</td>
        <td></td>
        <td><?php echo number_format($money_no[217]-$money_co[217])?></td>
        <td></td>
    </tr>
    <tr>
        <td> - Giá trị hao mòn lũy kế(*)</td>
        <td>242</td>
        <td></td>
        <td><?php echo number_format($money_co[2147]-$money_no[2147])?></td>
        <td></td>
    </tr>
    <tr class="bold">
        <td>IV. Các khoản đầu tư tài chính dài hạn</td>
        <td>250</td>
        <td></td>
        <td><?php echo number_format($n250)?></td>
        <td></td>
    </tr>
     <tr>
        <td> 1. Đầu tư vào công ty con</td>
        <td>251</td>
        <td></td>
        <td><?php echo number_format()?></td>
        <td></td>
    </tr>
    <tr>
        <td> 2. Đầu tư vào công ty liên kết, liên doanh</td>
        <td>252</td>
        <td></td>
        <td><?php echo number_format()?></td>
        <td></td>
    </tr>
    <tr>
        <td> 3. Đầu tư dài hạn khác</td>
        <td>258</td>
        <td></td>
        <td><?php echo number_format($money_no[221]-$money_co[221])?></td>
        <td></td>
    </tr>
    <tr>
        <td> 4. Dự phòng giảm giá đầu tư dài hạn</td>
        <td>259</td>
        <td></td>
        <td><?php echo number_format($money_co[229]-$money_no[229])?></td>
        <td></td>
    </tr>
    <tr class="bold">
        <td>V. Tài sản dài hạn khác</td>
        <td>260</td>
        <td></td>
        <td><?php echo number_format($n260)?></td>
        <td></td>
    </tr>
    <tr>
        <td> 1. Phải thu dài hạn</td>
        <td>261</td>
        <td></td>
        <td><?php echo number_format($n261)?></td>
        <td></td>
    </tr>
    <tr>
        <td> 2. Tài sản dài hạn khác</td>
        <td>262</td>
        <td></td>
        <td><?php echo number_format($n262)?></td>
        <td></td>
    </tr>
    <tr>
        <td> 3. Dự phòng phải thu dài hạn khó đòi</td>
        <td>268</td>
        <td></td>
        <td><?php echo number_format($money_co[1592]-$money_no[1592])?></td>
        <td></td>
    </tr>
    <tr class="bold">
        <td>Tổng tài sản(270=100+200)</td>
        <td>270</td>
        <td></td>
        <td><?php echo number_format($n270)?></td>
        <td></td>
    </tr>
     <tr class="bold">
        <td>A. Nợ phải trả(300=310+330)</td>
        <td>300</td>
        <td></td>
        <td><?php echo number_format($n300)?></td>
        <td></td>
    </tr>
    <tr class="bold">
        <td>I. Nợ ngắn hạn</td>
        <td>310</td>
        <td></td>
        <td><?php echo number_format($n310)?></td>
        <td></td>
    </tr>
    <tr>
        <td> 1. Vay và nợ ngắn hạn</td>
        <td>311</td>
        <td></td>
        <td><?php echo number_format(($money_co[311]-$money_no[311])+($money_co[315]-$money_no[315]))?></td>
        <td></td>
    </tr>
     <tr>
        <td> 2. Phải trả người bán</td>
        <td>312</td>
        <td></td>
        <td><?php echo number_format($money_co[331]-$money_no[331])?></td>
        <td></td>
    </tr>
    <tr>
        <td> 3. Người mua trả tiền trước</td>
        <td>313</td>
        <td></td>
        <td><?php echo number_format(($money_co[131]-$money_no[131])+($money_co[3387]-$money_no[3387]))?></td>
        <td></td>
    </tr>
    <tr>
        <td> 4. Thuế và các khoản phải nộp nhà nước</td>
        <td>314</td>
        <td></td>
        <td><?php echo number_format($money_co[333]-$money_no[333])?></td>
        <td></td>
    </tr>
    <tr>
        <td> 5. Phải trả người lao động</td>
        <td>315</td>
        <td></td>
        <td><?php echo number_format($money_co[334]-$money_no[334])?></td>
        <td></td>
    </tr>
     <tr>
        <td> 6. Chi phí phải trả</td>
        <td>316</td>
        <td></td>
        <td><?php echo number_format($money_co[335]-$money_no[335])?></td>
        <td></td>
    </tr>
    <tr>
        <td> 7. Phải trả nội bộ</td>
        <td>317</td>
        <td></td>
        <td><?php echo number_format()?></td>
        <td></td>
    </tr>
    <tr>
        <td> 8. Phải trả theo tiến độ hợp đồng xây dựng</td>
        <td>318</td>
        <td></td>
        <td><?php echo number_format()?></td>
        <td></td>
    </tr>
    <tr>
        <td> 9. Các khoản phải trả phải nộp ngắn hạn khác</td>
        <td>319</td>
        <td></td>
        <td><?php echo number_format(($money_co[338]-$money_no[338])+($money_co[138]-$money_no[138]))?></td>
        <td></td>
    </tr>
    <tr>
        <td> 10. Dự phòng phải trả ngắn hạn</td>
        <td>320</td>
        <td></td>
        <td><?php echo number_format($money_co[352]-$money_no[352])?></td>
        <td></td>
    </tr>
    <tr class="bold">
        <td>II. Nợ dài hạn</td>
        <td>330</td>
        <td></td>
        <td><?php echo number_format($n330)?></td>
        <td></td>
    </tr>
    <tr>
        <td> 1. Phải trả dài hạn người bán</td>
        <td>331</td>
        <td></td>
        <td><?php echo number_format()?></td>
        <td></td>
    </tr>
     <tr>
        <td> 2. Phải trả dài hạn nội bộ</td>
        <td>332</td>
        <td></td>
        <td><?php echo number_format()?></td>
        <td></td>
    </tr>
    <tr>
        <td> 3. Phải trả dài hạn khác</td>
        <td>333</td>
        <td></td>
        <td><?php echo number_format($n333)?></td>
        <td></td>
    </tr>
    <tr>
        <td> 4. Vay và nợ dài hạn</td>
        <td>334</td>
        <td></td>
        <td><?php echo number_format($n334)?></td>
        <td></td>
    </tr>
    <tr>
        <td> 5. Thuế thu nhập hoãn lại phải trả</td>
        <td>335</td>
        <td></td>
        <td><?php echo number_format()?></td>
        <td></td>
    </tr>
     <tr>
        <td> 6. Dự phòng trợ cấp mất việc làm</td>
        <td>336</td>
        <td></td>
        <td><?php echo number_format($money_co[351]-$money_no[351])?></td>
        <td></td>
    </tr>
    <tr>
        <td> 7. Dự phòng phải trả dài hạn</td>
        <td>337</td>
        <td></td>
        <td><?php echo number_format($money_co[352]-$money_no[352])?></td>
        <td></td>
    </tr>
    <tr class="bold">
        <td>B. Vốn chủ sở hữu(400=410+430)</td>
        <td>400</td>
        <td></td>
        <td><?php echo number_format($n400)?></td>
        <td></td>
    </tr>
    <tr class="bold">
        <td>I. Vốn chủ sở hữu</td>
        <td>410</td>
        <td></td>
        <td><?php echo number_format($n410)?></td>
        <td></td>
    </tr>
    <tr>
        <td> 1. Vốn đầu tư của chủ sở hữu</td>
        <td>411</td>
        <td></td>
        <td><?php echo number_format($money_co[4111]-$money_no[4111])?></td>
        <td></td>
    </tr>
    <tr>
        <td> 1. Thặng dư vốn cổ phần</td>
        <td>412</td>
        <td></td>
        <td><?php echo number_format($money_co[4112]-$money_no[4112])?></td>
        <td></td>
    </tr>
    <tr>
        <td> 2. Vốn khác của chủ sở hữu</td>
        <td>413</td>
        <td></td>
        <td><?php echo number_format($money_co[4118]-$money_no[4118])?></td>
        <td></td>
    </tr>
    <tr>
        <td> 4. Cổ phiếu quỹ</td>
        <td>414</td>
        <td></td>
        <td><?php echo number_format($money_no[419]-$money_co[419])?></td>
        <td></td>
    </tr>
    <tr>
        <td> 5. Chênh lệch đánh giá lại tài sản</td>
        <td>415</td>
        <td></td>
        <td><?php echo number_format()?></td>
        <td></td>
    </tr>
    <tr>
        <td> 6. Chênh lệch tỷ giá hối đoái</td>
        <td>416</td>
        <td></td>
        <td><?php echo number_format($money_co[413]-$money_no[413])?></td>
        <td></td>
    </tr>
    <tr>
        <td> 7. Quỹ đầu tư phát triển</td>
        <td>417</td>
        <td></td>
        <td><?php echo number_format()?></td>
        <td></td>
    </tr>
    <tr>
        <td> 8. Quỹ dự phòng tài chính</td>
        <td>418</td>
        <td></td>
        <td><?php echo number_format()?></td>
        <td></td>
    </tr>
    <tr>
        <td> 9. Quỹ khác thuộc vốn chủ sở hữu</td>
        <td>419</td>
        <td></td>
        <td><?php echo number_format($money_co[418]-$money_no[418])?></td>
        <td></td>
    </tr>
    <tr>
        <td> 10. Lợi nhuận chưa phân phối</td>
        <td>420</td>
        <td></td>
        <td><?php echo number_format($money_co[421]-$money_no[421])?></td>
        <td></td>
    </tr>
    <tr>
        <td> 11. Nguồn vốn đầu tư xây dựng cơ bản</td>
        <td>421</td>
        <td></td>
        <td><?php echo number_format()?></td>
        <td></td>
    </tr>
    <tr class="bold">
        <td>II. Nguồn kinh phí và quỹ khác</td>
        <td>430</td>
        <td></td>
        <td><?php echo number_format($n430)?></td>
        <td></td>
    </tr>
    <tr>
        <td> 1. Quỹ khen thưởng phúc lợi</td>
        <td>431</td>
        <td></td>
        <td><?php echo number_format($money_co[431]-$money_no[431])?></td>
        <td></td>
    </tr>
    <tr>
        <td> 2. Nguồn kinh phí</td>
        <td>432</td>
        <td></td>
        <td><?php echo number_format()?></td>
        <td></td>
    </tr>
     <tr>
        <td> 3. Nguồn kinh phí đã hình thành TSCĐ</td>
        <td>433</td>
        <td></td>
        <td><?php echo number_format()?></td>
        <td></td>
    </tr>
    <tr class="bold">
        <td>Tổng cộng nguồn vốn(440=300+400)</td>
        <td>440</td>
        <td></td>
        <td><?php echo number_format($n440)?></td>
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