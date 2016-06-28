<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
    <div id="content_area">
        <div style="color:#000">
            <a style="font-size:18px;text-decoration: underline; margin-left:850px" href=" <?php echo site_url() ?>/costs/detail_account">Trở lại</a>
            <div><?php echo $company ?></div>
            <div><?php echo $C_address ?></div>
            <br>
            <div style="font-size: 15px; text-align:center; font-weight:bold;">SỔ CHI TIẾT CÔNG NỢ PHẢI TRẢ</div>
            <div style="font-size: 15px; text-align:center; font-weight:bold;padding: 5px;"><?php echo $acc_id . ' - ' . $this->Tkdu->get_info($acc_id)->name ?></div>
            <div style="font-size: 15px; text-align:center; font-weight:bold;padding: 5px;">
                <?php
                if ($supplier_id != 0) {
                    echo 'Nhà cung cấp: ' . $this->Supplier->get_info($supplier_id)->company_name;
                } else {
                    echo "Nhà cung cấp: Tất cả";
                }?>
            </div>
            <div colspan ="11" style="text-align:center; font-style:italic; font-size:13px">Từ ngày : <?php echo date('d-m-Y H:i:s', strtotime($start_date)); ?> đến ngày: <?php echo date('d-m-Y H:i:s', strtotime($end_date)); ?></div>
            <?php
            if ($supplier_id != 0) {?>
                <div style="font-size: 14px;float: right; margin-right: 80px">
                    <?php
                    $oh_year = date('Y', strtotime($start_date));
                    $info_ncc_by_year = $this->Tkdu->get_info_cong_no_ncc_by_year($supplier_id, $oh_year);

                    if($info_ncc_by_year->num_rows() > 0){
                        $info_ncc = $info_ncc_by_year->row();
                        $diary_before = $this->Cost->get_account_money('2008-08-08 08:08:08', $start_date, $acc_id, $acc_arr);      
                        $total_no8 = 0;
                        $total_co8 = 0;
                        if(count($diary_before)>0){       
                            foreach ($diary_before as $data_diary){
                                if($data_diary['supplier_id']==$supplier_id){
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
                        $show = $hieu_before > 0 
                            ? 'Dư có đầu kỳ: '.number_format(abs($hieu_before))
                            : 'Dư nợ đầu kỳ: '.number_format(abs($hieu_before));
                    }else{
                        $hieu_before = 0;
                    }
                    echo $show;?>
                </div><br>
            <?php
            }?>
            <table class="detail_acc">
                <tr style="text-align:center;background-color: #999999">
                    <th colspan="2" style="width: 30%" >CHỨNG TỪ</th>
                    <th rowspan="2" style="width: 10%">TK Đ.ỨNG</th>
                    <th rowspan="2" style="width: 30%">Diễn giải</th>
                    <th colspan="2" style="width: 30%" >SỐ PHÁT SINH</th>
                </tr>
                <br>
                <tr style="text-align:center; background-color: #999999">
                    <th style="width: 20%">NGÀY</th>
                    <th style="width: 10%">SỐ</th>        
                    <th style="width: 15%">NỢ</th>
                    <th style="width: 15%">CÓ</th>
                </tr>
                <?php
                $this->load->model('Cost');
                $this->load->model('Supplier');
                if ($supplier_id == 0) {
                    ?>
                    <!--tất cả ncc xxxxxxxxxxxxxxxxxxxxxxxxxx-->
                    <?php
                    $all_supplier = $this->Supplier->get_all_supplier();
                    foreach ($all_supplier as $data_all) {
                        ?>
                        <tr>
                            <td colspan="6">
                                <?php
                                foreach ($diary1 as $data_diary1) {
                                    if ($data_diary1['supplier_id'] == $data_all['person_id']) {?>
                                        <b>Nhà cung cấp: </b>
                                        <?= $this->Supplier->get_info($data_all['person_id'])->company_name ?>
                                        <?php
                                    }
                                }?>
                            </td>
                        </tr>
                        <?php
                        foreach ($diary as $data_diary) {
                            if ($data_diary['supplier_id'] == $data_all['person_id']) {
                                $chek_no = 0;
                                $chek_co = 0;
                                foreach ($acc_arr as $acc_arr1) {
                                    if ($data_diary['tk_no'] == $acc_arr1['id']) {
                                        $chek_no = 1;
                                    } elseif ($data_diary['tk_co'] == $acc_arr1['id']) {
                                        $chek_co = 1;
                                    }
                                }
                                if ($data_diary['tk_no'] == $acc_id || $chek_no == 1) {
                                    $total_no += $data_diary['money'];
                                } elseif ($data_diary['tk_co'] == $acc_id || $chek_co == 1) {
                                    $total_co += $data_diary['money'];
                                }?>
                                <tr style="font-size: 12px;">
                                    <td style="text-align: center;"> <?php echo date('d-m-Y H:i:s', strtotime($data_diary['date'])) ?></td>
                                    <td style="text-align: center;"><?php echo $data_diary['id_cost'] ?></td>
                                    <td style="text-align: center;"><?php
                                        if ($data_diary['tk_no'] == $acc_id || $chek_no == 1) {
                                            echo $data_diary['tk_co'];
                                        } else {
                                            echo $data_diary['tk_no'];
                                        }?>
                                    </td>
                                    <td><?php echo $data_diary['comment'] ?></td>
                                    <td style="text-align: right;"><?php
                                        if ($data_diary['tk_no'] == $acc_id || $chek_no == 1) {
                                            echo number_format($data_diary['money']);
                                        }?>
                                    </td>
                                    <td style="text-align: right;"><?php
                                        if ($data_diary['tk_co'] == $acc_id || $chek_co == 1) {
                                            echo number_format($data_diary['money']);
                                        }?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                    }
                    ?>
                    <!--end xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->
                <?php } else { ?>
                    <?php
                    if (count($diary8) > 0) {
                        foreach ($diary8 as $data_diary) {
                            $info_cost = $this->Cost->get_info($data_diary->id_cost);
                            $total_no += $data_diary->money_no;
                            $total_co += $data_diary->money_co;?>
                            <tr style="font-size: 12px;">
                                <td style="text-align: center;"> 
                                    <?php echo date('d-m-Y H:i:s', strtotime($data_diary->date)) ?>
                                </td>
                                <td style="text-align: center;">
                                    <?= $data_diary->id_cost ?>
                                </td>
                                <td style="text-align: center;">
                                    <?= $data_diary->tkdu ?>
                                </td>
                                <td>
                                    <?= $info_cost->comment ?>
                                </td>
                                <td style="text-align: right;">
                                    <?= number_format($data_diary->money_no) ?>
                                </td>
                                <td style="text-align: right;">
                                    <?= number_format($data_diary->money_co) ?>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {?>
                        <tr>
                            <td colspan="8">Không có dữ liệu</td>
                        </tr>
                    <?php }
                    } ?>
                <tr style="font-weight: bold">
                    <td colspan="5" style="text-align: right;">Tổng phát sinh nợ</td>
                    <td style="text-align: right;"> <?php echo number_format($total_no) ?></td>
                </tr>
                <tr style="font-weight: bold">
                    <td colspan="5" style="text-align: right;">Tổng phát sinh có</td>
                    <td style="text-align: right;"> <?php echo number_format($total_co) ?></td>
                </tr>
                <tr style="font-weight: bold">
                    <td colspan="5" style="text-align: right;">
                        <?php
                        if ($supplier_id != 0) {
                            $tong_co = $hieu_before > 0 ? $total_co + $hieu_before  : $total_co;
                            $tong_no = $hieu_before > 0 ? $total_no                 : $total_no + $hieu_before;
                            $hieu = $tong_co - $tong_no;
                            $text = $hieu > 0 
                                ? 'Số dư có cuối kỳ: '
                                : 'Số dư nợ cuối kỳ: ';
                            echo $text; 
                        }else{ ?>
                            Số dư nợ cuối kỳ
                            <?php
                        }?>
                        </td>
                    <td style="text-align: right;"> 
                        <?php if($supplier_id != 0){
                            echo number_format(abs($hieu));
                        }?>
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
                <a href = "<?= site_url() ?>/accountings" id="submit" class="print_report" onclick = "this.style.display = 'none';
                        window.print();">In sổ</a>
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