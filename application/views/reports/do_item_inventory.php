<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<script src="<?php echo base_url(); ?>js/all.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
</head>
<body>
<div id="content_area_wrapper">
<div id="content_area">
<div style="color:#000">
<div id="wrapper" style="margin-bottom:200px;">
<p style="font-size:12px; margin-left:200px;"><?php echo $this->config->item('company'); ?></p>
<p style="font-size:12px; margin-left:200px;width:205px"><?php echo $this->config->item('address'); ?></p>
<a style="font-size:18px;margin-right: 252px;text-decoration: underline; float: right;margin-bottom: 41px; margin-top: -34px" href="<?php echo base_url();?>reports/do_item_inventory">Trở lại</a>
<h4 style="margin-left:200px;  width: 850px;">BẢNG TỔNG HỢP CHI TIẾT TỒN KHO <?php echo 'Từ '.date('d-m-Y H:i:s', strtotime($start_date)) .' đến '.date('d-m-Y H:i:s', strtotime($end_date)) ?></h4>
<p style="margin-left:200px;  width: 850px;">Tên kho: 
    <?php
    if ($store_id != "all") {
        if ($store_id == 0) {
            echo "Kho tổng";
        } else {
            echo $info_store->name_inventory;
        }
    } else {
        echo "Tất cả";
    }
    ?>
</p>

<table id="inventory_item">
    <tr>
        <td class="none" colspan="3" style="text-align: center;"><b>Mặt hàng</b></td>		
        <td class="besidetop" colspan="2" style="text-align: center;"><b>Tồn đầu kỳ<b></td>
        <td colspan="4" style="text-align: center;"><b>Phát sinh trong kỳ</b></td>
        <td class="besidetop" colspan="2" style="text-align: center;"><b>Tồn cuối kỳ</b></td>
        </tr>
        <tr>
            <td class="none" colspan="3"></td>
            <td class="beside"></td>
            <td class="none"></td>
            <td colspan="2" style="text-align: center;"><b>Nhập</b></td>
            <td colspan="2" style="text-align: center;"><b>Xuất</b></td>
            <td class="none"></td>
            <td class="none"></td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold">Mã HH</td>
            <td style="text-align: center; font-weight: bold">Tên hàng hóa</td>
            <td style="text-align: center; font-weight: bold">Đơn vị tính</td>
            <td style="text-align: center; font-weight: bold">Số Lượng</td>
            <td style="text-align: center; font-weight: bold">Thành Tiền</td>
            <td style="text-align: center; font-weight: bold">Số Lượng</td>
            <td style="text-align: center; font-weight: bold">Thành Tiền</td>
            <td style="text-align: center; font-weight: bold">Số Lượng</td>
            <td style="text-align: center; font-weight: bold">Thành Tiền</td>
            <td style="text-align: center; font-weight: bold">Số Lượng</td>
            <td style="text-align: center; font-weight: bold">Thành Tiền</td>
        </tr>
        <?php
        $tong_sl_dauky_all = 0;
        $tong_sl_nhap_all = 0;
        $tong_sl_xuat_all = 0;
        $tong_sl_cuoiky_all = 0;
        $tongcot_dauky_all = 0;
        $tongcot_cuoiky_all = 0;
        $tongcotnhap_phatsinh_all = 0;
        $tongcotxuat_phatsinh_all = 0;
        
        foreach ($categories as $category) {
            ?>
            <?php
            $queries = $this->Item->get_item_exim_category($category['id_cat'], $start_date, $end_date, $store_id);           
            if ($queries != null) {
                $tong_sl_dauky = 0;
                $tong_sl_nhap = 0;
                $tong_sl_xuat = 0;
                $tong_sl_cuoiky = 0;
                $tongtiencot_dauky = 0;
                $tongtiencot_phatsinhnhap = 0;
                $tongtiencot_phatsinhxuat = 0;
                $tongtiencot_cuoiky = 0;
                ?>	
<?php foreach ($queries as $query) { ?>	 
                    <tr> <?php $item_info = $this->Item->get_info($query['trans_items']); ?>
                        <td style="text-align: center;"><?php echo $item_info->item_number; ?> </td>
                        <td style="text-align: left;"><?php echo $item_info->name; ?> </td>
                        <?php if ($item_info->unit_rate != 0) { ?>
                            <td style="text-align: left;"><?php echo $this->Unit->item_unit($item_info->unit_from)->name; ?></td>
                        <?php } else { ?>
                            <td style="text-align: left;"><?php echo $this->Unit->item_unit($item_info->unit)->name; ?></td>
                            <?php } ?>

                        <td style="text-align: right;">
                            <?php
                            /* số lượng nhập trước kì */
                            $term_before = $this->Item->get_item_by_category_store($query['trans_items'], $start_date, $end_date, $store_id, 'before', 'both');
                            $soluong_tondauky = $term_before->trans_inventory != 0 ? $term_before->trans_inventory : 0;
                            $tong_sl_dauky += $soluong_tondauky;
                            echo format_quantity($soluong_tondauky);
                            ?>
                        </td>
                        <td style="text-align: right;">
                            <?php
                            /* tien nhap truoc ki */
                            $tiencot_dauky = $term_before->money;
                            $tongtiencot_dauky += $tiencot_dauky;
                            echo number_format($tiencot_dauky);
                            ?>
                        </td>

                        <td style="text-align: right;">
                            <?php
                            /* số lượng trong kì nhập */
                            $term_between_im = $this->Item->get_item_by_category_store($query['trans_items'], $start_date, $end_date, $store_id, 'between', 'im');
                            $soluongnhap_phatsinh = $term_between_im->trans_inventory != 0 ? $term_between_im->trans_inventory : 0;
                            $tong_sl_nhap += $soluongnhap_phatsinh;
                            echo format_quantity($soluongnhap_phatsinh);
                            ?>
                        </td>
                        <td style="text-align: right;"> 
                            <?php
                            /* tiền trong kì nhập */
                            $tien_giuaki_nhap_audi = $term_between_im->money;
                            $tongtiencot_phatsinhnhap += $tien_giuaki_nhap_audi;
                            echo number_format($tien_giuaki_nhap_audi);
                            ?>
                        </td>
                        <td style="text-align: right;">
                            <?php
                            /* số lượng trong kì xuất */
                            $term_between_ex = $this->Item->get_item_by_category_store($query['trans_items'], $start_date, $end_date, $store_id, 'between', 'ex');                                                  
                            $soluongxuat_phatsinh = abs($term_between_ex->trans_inventory);
                            $tong_sl_xuat += $soluongxuat_phatsinh;
                            echo format_quantity($soluongxuat_phatsinh);
                            ?>
                        </td> 
                        <td style="text-align: right;"> 
                            <?php
                            /* tiền trong kì xuất */
                            $tien_giuaki_xuat_audi = abs($term_between_ex->money);
                            $tongtiencot_phatsinhxuat += $tien_giuaki_xuat_audi;
                            echo number_format($tien_giuaki_xuat_audi);
                            ?>
                        </td> 

                        <td style="text-align: right;">
                        <?php //sl cuối kì = sl đầu kì + sl nhập - sl xuất
                        $soluong_toncuoiky = $soluong_tondauky + $soluongnhap_phatsinh - $soluongxuat_phatsinh;
                        $tong_sl_cuoiky += $soluong_toncuoiky;
                        echo format_quantity($soluong_toncuoiky);
                        ?>
                        </td>
                        <td style="text-align: right;">
                            <?php
                            //tiền cuối kì = tiền đầu kì + tiền nhập - tiền xuất
                            $tiencot_cuoiky = $tiencot_dauky + $tien_giuaki_nhap_audi - $tien_giuaki_xuat_audi;
                            $tongtiencot_cuoiky += $tiencot_cuoiky;
                            echo number_format($tiencot_cuoiky);
                            ?>
                        </td>
                    </tr>
                <?php } ?>
                <tr style="background:rgba(195, 196, 202, 0.7);">
                    <td colspan="3" style="text-align: right; font-weight: bold"><?php echo $category['name']; ?></td>
                    <td style="text-align: right;">
                        <?php 
                        $tong_sl_dauky_all += $tong_sl_dauky;
                        echo format_quantity($tong_sl_dauky);
                        ?>
                    </td>
                    <td style="text-align: right;">
                        <?php
                        $tongcot_dauky_all += $tongtiencot_dauky;
                        echo number_format($tongtiencot_dauky);
                        ?>
                    </td>
                    <td style="text-align: right;">
                        <?php 
                            $tong_sl_nhap_all += $tong_sl_nhap;
                            echo format_quantity($tong_sl_nhap);
                        ?>
                    </td>
                    <td style="text-align: right;">
                        <?php
                        $tongcotnhap_phatsinh_all += $tongtiencot_phatsinhnhap;
                        echo number_format($tongtiencot_phatsinhnhap);
                        ?>
                    </td>
                    <td style="text-align: right;">
                        <?php 
                            $tong_sl_xuat_all += $tong_sl_xuat;
                            echo format_quantity($tong_sl_xuat);
                        ?>
                    </td>
                    <td style="text-align: right;">
                    <?php
                    $tongcotxuat_phatsinh_all += $tongtiencot_phatsinhxuat;
                    echo number_format($tongtiencot_phatsinhxuat);
                    ?>
                    </td>
                    <td style="text-align: right;">
                        <?php 
                            $tong_sl_cuoiky_all += $tong_sl_cuoiky;
                            echo format_quantity($tong_sl_cuoiky);
                        ?>
                    </td>
                    <td style="text-align: right;">
                    <?php
                    $tongcot_cuoiky_all += $tongtiencot_cuoiky;
                    echo number_format($tongtiencot_cuoiky);
                    ?>
                    </td>
                </tr>
            <?php }
        }
        ?>	
        <tr>
            <td colspan="3" style="text-align: right; font-weight: bold">Tổng</td>
            <td style="text-align: right;"><?= format_quantity($tong_sl_dauky_all);?></td>
            <td style="text-align: right;"><?= number_format($tongcot_dauky_all); ?> </td>
            <td style="text-align: right;"><?= format_quantity($tong_sl_nhap_all);?></td>
            <td style="text-align: right;"><?= number_format($tongcotnhap_phatsinh_all); ?> </td>
            <td style="text-align: right;"><?= format_quantity($tong_sl_xuat_all);?></td>
            <td style="text-align: right;"><?= number_format($tongcotxuat_phatsinh_all); ?> </td>
            <td style="text-align: right;"><?= format_quantity($tong_sl_cuoiky_all);?></td>
            <td style="text-align: right;"><?= number_format($tongcot_cuoiky_all); ?></td>
        </tr>
        </table>
        <table style="margin:30px auto; width:70%">
            <tr>
                <td style="text-align:right;margin-right:20px;" colspan="3"><i>Ngày: <?php echo date('d-m-Y'); ?></i></td>
            </tr>
            <tr>
                <td width="30%">Người lập biểu
                    <p><i>(Ký tên)</i></p>
                </td>
                <td width="30%" style="text-align:center;">Kế toán trưởng<p><i>(Ký tên)</i></p></td>
                <td width="40%" style="text-align:right;">Giám đốc<p><i>(Ký tên)</i></p></td>
            </tr>
        </table>
<div>
<button style="margin-left:200px;width:87px;" class="submit_button" id="print_button" onClick="print_receipt()" > <?php echo lang('sales_print'); ?> </button>
</div></div></div></div>
</div>
</body>
</html>
<script type="text/javascript">
function print_receipt()
 {
	$('#print_button').hide();
  window.print();
 }
</script>
<style type="text/css">
#wrapper{
margin:10px auto;
}
table#inventory_item{
	border:1px solid black;
	margin:10px auto;
	border-collapse: collapse; 
}
table#inventory_item tr td{
	border:1px solid black;
	font-size:14px;
	padding:6px 6px;
}
table#inventory_item tr td.none{
	border:0px;
}
table#inventory_item tr td.beside{
	border-right:0px;
	border-top:0px;
}
table#inventory_item tr td.besidetop{
	border-bottom:0px;
}
</style>