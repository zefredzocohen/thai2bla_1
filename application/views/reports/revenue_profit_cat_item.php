<?php $this->load->view("partial/header"); ?>
<style>
    #profit {
        font-size: 12px;
        width: 960px;
        margin: 0px auto;
    }
    #profit tr td{
        padding: 5px 10px;
        border: 1px solid #CCCCCC;
    }
    #profit tr td:first-child{
        border-left: none;
    }
    #profit tr td:last-child{
        border-right: none;
    }
    #profit thead tr th{
        background: #428BCA;
        padding: 5px 10px;
        color: #FFFFFF;
        border: 1px solid #CCCCCC;
    } 
    .cats{
        background: lightgray;
    }

</style>
<div id="content_area_wrapper">
    <div id="content_area">
        <table id="title_bar_new">
            <tr>
                <td id="title_icon">
                    <img src='<?php echo base_url() ?>images/menubar/reports.png' alt='<?php echo lang('reports_reports'); ?>' />
                </td>
                <td id="title" style="font-size: 20px;"> <?php echo $title ?></td>
                <td><a style="font-size:18px;text-decoration: underline; float: right;margin-right:30px; color: #FFF" href=<?php echo base_url() . $link; ?>>Trở lại</a></td>
            </tr>
            <tr style="margin-top: 8px;">
                <td>&nbsp;</td>
                <td><small style="font-size: 15px; font-style: italic"><?php echo $subtitle ?></small></td>
                <td>&nbsp;</td>
            </tr>

        </table>
        <?php
        $this->load->model('Inventory');
        ?>
        <br />
        <table id="profit" >

                <thead>
                    <tr>
                        <th>Mã mặt hàng</th>
                        <th>Tên mặt hàng</th>
                        <th>ĐVT</th>
                        <th>Số lượng</th>
                        <th>Doanh thu</th>
                        <th>Lợi nhuận</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($data_cat as $cat) {
                        $cat_so_luong = 0;
                        $cat_doanh_thu = 0;
                        $cat_loi_nhuan = 0;
                        $gia_nhap_trung_binh = 0;
                        $gia_ban_trung_binh = 0;
                        $doanh_thu = 0;
                        $loi_nhuan = 0;
                        $cong_so_luong = 0;
                        $cong_loi_nhuan = 0;
                        $cong_doanh_thu = 0;
                        $data_item = $this->Inventory->get_inventory_group_by_category($start_date, $end_date, $cat['category']);
                        foreach ($data_item as $item) {
                            $quantity_sale = 0;
                            $quantity_recv = 0;
                            $price_recv = 0;
                            $price_sale = 0;
                            $dis_per = 0;
                            $tax_per = 0;
                            $term_nhap = $this->Inventory->get_price_receving($item['trans_items']);
                            foreach ($term_nhap as $term1) {
                                $quantity_recv += $term1['trans_inventory'];
                                $price_recv += $term1['trans_inventory'] * $term1['trans_money'];
                            }
                            $gia_nhap_trung_binh = $price_recv / $quantity_recv;
                            $term_ban = $this->Inventory->get_price_sale($start_date, $end_date, $item['trans_items']);
                            foreach ($term_ban as $term2) {
                                $quantity_sale += $term2['trans_inventory'] * (-1);
                                $price_sale += $term2['trans_inventory'] * $term2['trans_money'] * (-1);
                                $tam_data = $this->Sale->get_sale_item_by_trans_sale($item['trans_items'], $term2['trans_sale']);
                                $dis_per += $term2['trans_inventory'] * $term2['trans_money'] * $tam_data['discount_percent'] / 100 * (-1);
                                $tax_per += ($term2['trans_inventory'] * $term2['trans_money'] * (-1) - $term2['trans_inventory'] * $term2['trans_money'] * $tam_data['discount_percent'] / 100 * (-1)) * $tam_data['taxes_percent'] / 100;
                            }
                            $doanh_thu = $price_sale - $dis_per + $tax_per;
                            $gia_ban_trung_binh = $price_sale / $quantity_sale;
                            $loi_nhuan = ($gia_ban_trung_binh - $gia_nhap_trung_binh) * $quantity_sale - $dis_per + $tax_per;
                            $cong_doanh_thu += $doanh_thu;
                            $cong_loi_nhuan += $loi_nhuan;
                            $cong_so_luong += $quantity_sale;
                        }
                        $cat_so_luong += $cong_so_luong;
                        $cat_doanh_thu += $cong_doanh_thu;
                        $cat_loi_nhuan += $cong_loi_nhuan;
                        ?>                                  
                        <tr style="font-weight: bold">                                        
                            <td class="cats" style="text-align: left;" colspan="3"><?php echo "Nhóm mặt hàng: " . $this->Category->get_info($cat['category'])->name ?></td> 
                            <td class="cats" style="text-align: right;"><?php echo format_quantity($cat_so_luong); ?></td>
                            <td class="cats" style="text-align: right;"><?php echo number_format($cat_doanh_thu); ?></td>
                            <td class="cats" style="text-align: right;"><?php echo number_format($cat_loi_nhuan); ?></td>
                        </tr>
                        <?php
                        $gia_nhap_trung_binh = 0;
                        $gia_ban_trung_binh = 0;
                        $doanh_thu = 0;
                        $loi_nhuan = 0;
                        $data_item = $this->Inventory->get_inventory_group_by_category($start_date, $end_date, $cat['category']);
                        foreach ($data_item as $item) {
                            $quantity_sale = 0;
                            $quantity_recv = 0;
                            $price_recv = 0;
                            $price_sale = 0;
                            $dis_per = 0;
                            $tax_per = 0;
                            $term_nhap = $this->Inventory->get_price_receving($item['trans_items']);
                            foreach ($term_nhap as $term1) {
                                $quantity_recv += $term1['trans_inventory'];
                                $price_recv += $term1['trans_inventory'] * $term1['trans_money'];
                            }
                            $gia_nhap_trung_binh = $price_recv / $quantity_recv;
                            $term_ban = $this->Inventory->get_price_sale($start_date, $end_date, $item['trans_items']);
                            foreach ($term_ban as $term2) {
                                $quantity_sale += $term2['trans_inventory'] * (-1);
                                $price_sale += $term2['trans_inventory'] * $term2['trans_money'] * (-1);
                                $tam_data = $this->Sale->get_sale_item_by_trans_sale($item['trans_items'], $term2['trans_sale']);
                                $dis_per += $term2['trans_inventory'] * $term2['trans_money'] * $tam_data['discount_percent'] / 100 * (-1);
                                $tax_per += ($term2['trans_inventory'] * $term2['trans_money'] * (-1) - $term2['trans_inventory'] * $term2['trans_money'] * $tam_data['discount_percent'] / 100 * (-1)) * $tam_data['taxes_percent'] / 100;
                            }
                            $doanh_thu = $price_sale - $dis_per + $tax_per;
                            $gia_ban_trung_binh = $price_sale / $quantity_sale;
                            $loi_nhuan = ($gia_ban_trung_binh - $gia_nhap_trung_binh) * $quantity_sale - $dis_per + $tax_per;
                            $tong_doanh_thu += $doanh_thu;
                            $tong_loi_nhuan += $loi_nhuan;
                            $tong_so_luong += $quantity_sale;
//                                        if($term_ban){
                            ?>
                            <tr>
                                <td style="text-align: left"><?php echo $this->Item->get_info($item['trans_items'])->item_number ?></td>
                                <td style="text-align: left"><?php echo $this->Item->get_info($item['trans_items'])->name ?></td>
                                <td style="text-align: left">
                                    <?php
                                    if ($this->Item->get_info($item['trans_items'])->quantity_first) {
                                        $unit = $this->Item->get_info($item['trans_items'])->unit_from;
                                    } else {
                                        $unit = $this->Item->get_info($item['trans_items'])->unit;
                                    }
                                    echo $this->Unit->get_info($unit)->name;
                                    ?>
                                </td>
                                <td style="text-align: right"><?php echo format_quantity($quantity_sale); ?></td>
                                <td style="text-align: right"><?php echo number_format($doanh_thu); ?></td>
                                <td style="text-align: right"><?php echo number_format($loi_nhuan); ?></td>
                            </tr>
                            <?php
                            $j++;
//                                        }
                        }
                        $i++;
                    }
                    ?>
                    <tr style="font-weight: bold;">
                        <td style="text-align: right" colspan="3">Tổng</td>
                        <td style="text-align: right"><?php echo format_quantity($tong_so_luong); ?></td>
                        <td style="text-align: right"><?php echo number_format($tong_doanh_thu); ?></td>
                        <td style="text-align: right"><?php echo number_format($tong_loi_nhuan); ?></td>
                    </tr>
                </tbody>

            </table>
            <!--<div id="feedback_bar"></div>-->
        </div></div>
<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript" language="javascript">
    function init_table_sorting()
    {
        //Only init if there is more than one row
        if ($('.tablesorter tbody tr').length > 1)
        {
            $("#sortable_table").tablesorter();
        }
    }
    $(document).ready(function ()
    {
        init_table_sorting();
    });
</script>