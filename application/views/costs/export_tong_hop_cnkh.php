<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">
    <div style="color:#000">
    <a style="font-size:18px;text-decoration: underline; margin-left:850px" href=" <?php echo site_url()?>/costs/detail_account">Trở lại</a>
    <div><?php echo $company?></div>
    <div><?php echo $C_address?></div>
    <br>
    <div style="font-size: 15px; text-align:center; font-weight:bold;">TỔNG HỢP CÔNG NỢ PHẢI THU</div>
    <div style="font-size: 15px; text-align:center; font-weight:bold;padding: 5px;"><?php echo $acc_id.' - '.$this->Tkdu->get_info($acc_id)->name?></div>
    <div colspan ="11" style="text-align:center; font-style:italic; font-size:13px">Từ ngày : <?php echo date('d-m-Y H:i:s', strtotime($start_date)); ?> đến ngày: <?php echo date('d-m-Y H:i:s', strtotime($end_date)); ?></div>
    <table class="detail_acc">
    <tr style="text-align:center;background-color: #999999">        
        <th rowspan="2" style="width: 7%">MÃ KHÁCH HÀNG</th>
        <th rowspan="2" style="width: 25%">TÊN KHÁCH HÀNG</th>
        <th rowspan="2" style="width: 8%">TK GHI NỢ</th>
        <th colspan="2">SỐ ĐẦU KỲ</th>
        <th colspan="2">SỐ PHÁT SINH</th>
        <th colspan="2">SỐ CUỐI KỲ</th>
    </tr>
    <br>
    <tr style="text-align:center; background-color: #999999">      
        <th style="width: 10%">NỢ</th>
        <th style="width: 10%">CÓ</th>
        <th style="width: 10%">NỢ</th>
        <th style="width: 10%">CÓ</th>
        <th style="width: 10%">NỢ</th>
        <th style="width: 10%">CÓ</th> 
    </tr>
    <?php 
    
    if(count($diary)>0){ 
        $customer_arr = $this->Cost->get_customer_id($start_date,$end_date);        
        foreach ($customer_arr as $customer_arr1){
            if($customer_arr1['id_customer'] != Null){
                $no_dk = 0;
                $co_dk = 0;
                $no_ps = 0;
                $co_ps = 0;
                $no_ck = 0;
                $co_ck = 0;
                $total_no = 0;
                $total_co = 0;
               foreach ($diary as $data_diary){
                    if($data_diary['id_customer']==$customer_arr1['id_customer']){
                        $chek_no = 0;
                        $chek_co = 0;
                        $money_co_dk = 0;
                        $money_no_dk = 0;
                        
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
                        $this->load->model('Cost');
                        $no = $this->Cost->get_no_dau_ky_acc($start_date,$acc_id,$acc_arr);                        
                        foreach ($no as $no1){
                            if($no1['id_customer']==$customer_arr1['id_customer']){
                                $money_no_dk += $no1['money'];
                            }                
                        }            
                        $co = $this->Cost->get_co_dau_ky_acc($start_date,$acc_id,$acc_arr);
                        foreach ($co as $co1){
                            if($co1['id_customer']==$customer_arr1['id_customer']){
                                $money_co_dk += $co1['money'];
                            }
                        }
                    }
                } 
                if($money_no_dk > $money_co_dk){
                    $no_dk += $money_no_dk-$money_co_dk;
                }
                if($money_no_dk < $money_co_dk){
                    $co_dk += $money_co_dk-$money_no_dk;                    
                }
                if($total_no >= $total_co){
                    if($money_no_dk >= $money_co_dk){
                        $no_ck  += ($total_no-$total_co) + ($money_no_dk - $money_co_dk);
                    }else{
                        $no_ck += ($total_no-$total_co) - ($money_co_dk - $money_no_dk);
                    }
                }
                if($total_no < $total_co){
                    if($money_no_dk >= $money_co_dk){
                        $co_ck += ($total_no-$total_co) - ($money_no_dk - $money_co_dk);
                    }else{
                        $co_ck += ($total_no-$total_co) + ($money_co_dk - $money_no_dk);
                    }
                }
                $no_ps += $total_no;       
                $co_ps += $total_co; 
                $total_no_dk += $no_dk;
                $total_co_dk += $co_dk;
                $total_no_ps += $no_ps;
                $total_co_ps += $co_ps;
//                $total_no_ck += $no_ck;
//                $total_co_ck += $co_ck;
                
                //ck = no + no - co; 
                $ck = $no_dk + $total_no - $total_co;
                $total_no_ck += $ck < 0 ? abs($ck) : 0;
                $total_co_ck += $ck > 0 ? $ck : 0;
                ?>
                <tr style="font-size: 12px;">
                    <td style="text-align: center;"><?php echo $customer_arr1['id_customer']?></td>
                    <td><?php echo $this->Person->get_info($customer_arr1['id_customer'])->first_name.' '.$this->Person->get_info($customer_arr1['id_customer'])->last_name?></td>

                    <td style="text-align: center;"><?php echo 131?></td>
                    <td style="text-align: right;"><?php echo number_format($no_dk);?></td>
                    <td style="text-align: right;">0<?php //echo number_format($co_dk);?></td>
                    <td style="text-align: right;"><?php echo number_format($total_no);?></td>
                    <td style="text-align: right;"><?php echo number_format($total_co);?></td>
                    <td style="text-align: right;"><?php echo number_format($ck > 0 ? $ck : 0);?></td>
                    <td style="text-align: right;"><?php echo number_format($ck < 0 ? abs($ck) : 0);?></td>
                </tr>
        <?php    }
            
         } 
    }else{?>
    <tr>
        <td colspan="8">Không có dữ liệu</td>
    </tr>
    <?php }
    ?>
    <tr style="font-weight: bold">
        <td colspan="3" style="text-align: right;">Tổng</td>
        <td style="text-align: right;"> <?php echo number_format($total_no_dk)?></td>
        <td style="text-align: right;"> <?php echo number_format($total_co_dk)?></td>
        <td style="text-align: right;"> <?php echo number_format($total_no_ps)?></td>
        <td style="text-align: right;"> <?php echo number_format($total_co_ps)?></td>
        <td style="text-align: right;"> <?php echo number_format($total_no_ck)?></td>
        <td style="text-align: right;"> <?php echo number_format($total_co_ck)?></td>
    </table>
    <br>
    <table id="ky_ten">
        <tr>
            <td></td>
            <td></td>
            <td style="text-align: center; font-weight: bold">Ngày ... tháng ... năm ...  </td>
        </tr>
        <tr style="text-align: center; margin-top:5px;">
            <td style="width: 33%">KẾ TOÁN</td>
            <td style="width: 33%">NGƯỜI GHI SỔ</td>
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
    }
    .detail_acc tr th{
    border: 1px solid #000000;
    }
</style>