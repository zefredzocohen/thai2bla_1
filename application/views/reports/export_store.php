<?php $this->load->view('partial/header'); ?>
<div id="content_area_wrapper">
    <div id="content_area">
        <style type="text/css">
            .submit_right{
                box-sizing: content-box;
                background-color: #4d90fe !important;
                background-image: -moz-linear-gradient(center top , #4d90fe, #4787ed) !important;
                border: 1px solid #3079ed !important;
                box-shadow: none !important;
                color: #fff !important;
                border-radius: 2px !important;
                cursor: default !important;
                font-size: 11px !important;
                font-weight: bold !important;
                height: 27px !important;
                line-height: 27px !important;
                margin-right: 16px !important;
                min-width: 54px !important;
                outline: 0 none !important;
                padding: 0 8px !important;
                text-align: center !important;
                white-space: nowrap !important;
                float: right;
            }
            #content_area > #myclass {
                font-size: 13px;
                font-style: italic;
            }
        </style>
        <div id="myclass">
            <h4><?php echo $company ?></h4>
            <h4><?php echo $address ?></h4>
        </div>
        <div>
            <a style="font-size:18px;text-decoration: underline; float: right;margin-bottom: 41px; margin-top: -34px" href="<?php echo base_url(); ?>reports/export_store">Trở lại</a>
            <h3 style="margin: 20px 200px 5px 250px;text-align: center;">BÁO CÁO XUẤT KHO</h3>
            <h5 style="margin: 5px 200px 10px 250px;text-align:center; font-style: italic; font-size: 13px;"><?php echo 'Từ ' . date('d-m-Y H:i:s', strtotime($start_date)) . ' đến ' . date('d-m-Y H:i:s', strtotime($end_date)) ?></h4>
        </div>
        <label style="margin-left: 10px;">Kho mặt hàng :  <?php
            if ($store_id == "0") {
                echo " Kho tổng";
            } elseif ($store_id == "all") {
                echo " Tất cả";
            } else {
                $info_store = $this->Create_invetory->get_info($store_id);
                echo $info_store->name_inventory;
            }
            ?></label>
        </br>
        <label style="margin-left: 10px;">Ngày báo cáo :<?php echo date('d-m-Y H:i:s') ?></label>
        <div style="margin-top:20px;">
            <table id="contents" style="margin-top:5px;border: 1px #ccc;border-collapse: collapse;">
                <tr>
                    <td id="item_table">
                        <div id="table_holder" style="width: 960px;">
                            <table class="tablesorter report" id="sortable_table">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã đơn hàng</th>
                                        <th>Mã mặt hàng</th>
                                        <th>Tên mặt hàng</th>
                                        <th>Ngày xuất</th>
                                        <th>Nhân viên xuất</th>
                                        <th>ĐVT</th>
                                        <th>Giá vốn</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền </th>

                                    </tr>
                                </thead>    
                                <tbody>
                                    <?php
                                    $stt = 1;
                                    $data_dh = $this->Create_invetory->get_export_store($start_date, $end_date, $store_id);
                                    $data_export = $this->Create_invetory->get_export_store_item($start_date, $end_date, $store_id);
                                    foreach ($data_dh as $val) {
                                        $data_tam = $this->Create_invetory->get_row_export_store_item($val['export_store_id']);
                                        $count = count($data_tam);
                                        ?>
                                        <tr>
<!--                                            <td><?php //echo $stt++ ?></td>
                                            <td style="text-align: center"><?php //echo'MĐH' . ($val['export_store_id']) ?></td> -->
                                            <?php
                                            foreach ($data_export as $val1) {
                                                if ($val1['export_store_id'] == $val['export_store_id']) {
                                                    $total_thanh_tien += $val1['cost_price_export'] * $val1['quantity_export'];
                                                    $total_quan += $val1['quantity_export'];

                                                    $name_employee = $this->Employee->get_info($val['employee_id'])->first_name . ' ' . $this->Employee->get_info($val['employee_id'])->last_name;
                                                    ?> 
                                                    <td><?php echo $stt++ ?></td>
                                                    <td style="text-align: center"><?php echo'MĐH' . ($val['export_store_id']) ?></td> 
                                                    <td><?php echo $this->Item->get_info($val1['item_id'])->item_number ?></td>
                                                    <td style="text-align: left"><?php echo $this->Item->get_info($val1['item_id'])->name ?></td>
                                                    <td><?php echo date('d-m-Y H:i:s', strtotime($val['date_export'])) ?></td>
                                                    <td><?php echo $name_employee; ?></td>
                                                    <td><?php echo $this->Unit->get_info($val1['unit_export'])->name ?></td>
                                                    <td style="text-align: right"><?php echo number_format($val1['cost_price_export']) ?></td>
                                                    <td style="text-align: right"><?php echo format_quantity($val1['quantity_export']) ?></td>
                                                    <td style="text-align: right"><?php echo number_format($val1['cost_price_export'] * $val1['quantity_export']) ?></td>

                                                </tr>
                                            <?php
                                            }
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="8" style="font-size: 14px; font-weight: bold; text-align: right;">Tổng cộng</td>
                                        <td style="font-size: 14px; font-weight: bold; text-align: right;"><?= format_quantity($total_quan); ?></td>
                                        <td style="font-size: 14px; font-weight: bold; text-align: right;"><?= to_currency($total_thanh_tien); ?></td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                    </td>
                </tr>
            </table> 
            </br>
            <input id="submit" name="submit" class="print_report" value="In" onclick="this.style.display = 'none'" />
        </div>
    </div></div>

<?php $this->load->view('partial/footer'); ?>
<script type="text/javascript" language="javascript">
    function init_table_sorting() {
        //Only init if there is more than one row
        if ($('.tablesorter tbody tr').length > 1) {
            $("#sortable_table").tablesorter();
        }
    }
    $(document).ready(function () {
        init_table_sorting();
        $(".print_report").click(function () {
            window.print();
        });
    });
</script>
<style type="text/css">
    .print_report{
        background: none repeat scroll 0 0 #1E5A96;
        border: 1px solid #EEEEEE;
        color: #FFFFFF;
        font-size: 14px;
        font-weight: bold;
        line-height: 30px;
        margin-left: 9px;
        padding: 5px;
        text-align: center;
        width: 100px;
        cursor: pointer;
    }
</style>