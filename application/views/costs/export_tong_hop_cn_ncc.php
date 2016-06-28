<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">
    <div style="color:#000">
    <a style="font-size:18px;text-decoration: underline; margin-left:850px" href=" <?php echo site_url()?>/costs/detail_account">Trở lại</a>
    <div><?php echo $company?></div>
    <div><?php echo $C_address?></div>
    <br>
    <div style="font-size: 15px; text-align:center; font-weight:bold;">TỔNG HỢP CÔNG NỢ PHẢI TRẢ</div>
    <div style="font-size: 15px; text-align:center; font-weight:bold;padding: 5px;"><?php echo $acc_id.' - '.$this->Tkdu->get_info($acc_id)->name?></div>
    <div colspan ="11" style="text-align:center; font-style:italic; font-size:13px">Từ ngày : <?php echo date('d-m-Y H:i:s', strtotime($start_date)); ?> đến ngày: <?php echo date('d-m-Y H:i:s', strtotime($end_date)); ?></div>
    <table class="detail_acc">
    <tr style="text-align:center;background-color: #999999">        
        <th rowspan="2" style="width: 7%">MÃ NHÀ CUNG CẤP</th>
        <th rowspan="2" style="width: 25%">NHÀ CUNG CẤP</th>
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
        //$customer_arr = $this->Cost->get_supplier_id($start_date,$end_date);        
        $customer_arr = $this->Cost->get_all_supplier();        
        foreach ($customer_arr as $customer_arr1){
            if($customer_arr1['person_id'] != 0){
                $total_no = 0;
                $total_co = 0;
                //dau ky
                $oh_year = date('Y', strtotime($start_date));
                $info_ncc_by_year = $this->Tkdu->get_info_cong_no_ncc_by_year($customer_arr1['person_id'], $oh_year);
                if($info_ncc_by_year->num_rows() > 0){
                    $info_ncc = $info_ncc_by_year->row();
                    $diary_before = $this->Cost->get_account_money('2008-08-08 08:08:08', $start_date, $acc_id, $acc_arr);      
                    $total_no8 = 0;
                    $total_co8 = 0;
                    if(count($diary_before)>0){       
                        foreach ($diary_before as $data_diary){
                            if($data_diary['person_id']==$customer_arr1['person_id']){
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
                    $tong_co8 = $info_ncc->du_no > 0 ? $total_co8                       : $total_co8 + $info_ncc->du_co;
                    $tong_no8 = $info_ncc->du_no > 0 ? $total_no8 + $info_ncc->du_no    : $total_no8;
                    $hieu_before = $tong_co8 - $tong_no8;
                }else{
                    $hieu_before = 0;
                }
                
                //giua ky
                $diary8 = $this->Cost->get_recv_cost_tkdu($customer_arr1['person_id'], $start_date, $end_date);
                foreach ($diary8 as $data_diary) {
                    $info_cost = $this->Cost->get_info($data_diary->id_cost);
                    $total_no += $data_diary->money_no;
                    $total_co += $data_diary->money_co;
                }
                $tong_co = $hieu_before > 0 ? $total_co + $hieu_before  : $total_co;
                $tong_no = $hieu_before > 0 ? $total_no                 : $total_no + $hieu_before;
                
                //cuoi ky
                $hieu = $tong_co - $tong_no;
                
                $total_no_dk += $hieu_before > 0 ? 0 : abs($hieu_before);
                $total_co_dk += $hieu_before > 0 ? $hieu_before : 0;
                $total_no_ps += $total_no;
                $total_co_ps += $total_co;
                $total_no_ck += $hieu > 0 ? 0 : abs($hieu);
                $total_co_ck += $hieu > 0 ? $hieu : 0;
                if($hieu_before == 0 && $tong_co == 0 && $tong_no == 0){
                    
                }else{
                    ?>
                    <tr style="font-size: 12px;">
                        <td style="text-align: center;"><?php echo $customer_arr1['person_id']?></td>
                        <td><?php echo $this->Supplier->get_info($customer_arr1['person_id'])->company_name?></td>

                        <td style="text-align: center;"><?php echo 331?></td>
                        <td style="text-align: right;"><?php echo number_format($hieu_before > 0 ? 0 : abs($hieu_before));?></td>
                        <td style="text-align: right;"><?php echo number_format($hieu_before > 0 ? $hieu_before : 0);?></td>
                        <td style="text-align: right;"><?php echo number_format($total_no);?></td>
                        <td style="text-align: right;"><?php echo number_format($total_co);?></td>
                        <td style="text-align: right;"><?php echo number_format($hieu > 0 ? 0 : abs($hieu));?></td>
                        <td style="text-align: right;"><?php echo number_format($hieu > 0 ? $hieu : 0);?></td>
                    </tr>
                <?php    
                }
            }
            
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