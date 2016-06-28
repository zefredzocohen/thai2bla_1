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
            <a style="font-size:18px;text-decoration: underline; float: right;margin-right:30px;margin-bottom: 41px; margin-top: -34px" href="<?php echo base_url(); ?>reports/do_transfer_ware">Trở lại</a>
            <h3 style="margin: 20px 200px 5px 250px;text-align: center;">BÁO CÁO CHUYỂN KHO</h3>
            <h5 style="margin: 5px 200px 10px 250px;text-align:center; font-style: italic; font-size: 13px;"><?php echo 'Từ ' . date('d-m-Y H:i:s', strtotime($start_date)) . ' đến ' . date('d-m-Y H:i:s', strtotime($end_date)) ?></h4>
        </div>
        <div style="margin-top:20px;">
            <table id="contents" style="margin-top:5px;">
                <tr>
                    <td id="item_table">
                        <div id="table_holder" style="width: 960px;">
                            <table class="tablesorter report" id="sortable_table">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên mặt hàng</th>
                                        <th>Kho chuyển</th>
                                        <th>Kho nhận</th>
                                        <th>Số lượng</th>
                                        <th>Thời gian</th>

                                    </tr>
                                </thead>    
                                <tbody>
                                    <?php
                                    $stt = 1;
                                    $total = 0;
                                    ?>
<?php foreach ($value as $key => $values): ?>
                                        <tr>
                                            <td><?php echo $stt; ?></td>
                                            <td><?php echo $this->Item->get_info($values['item_id'])->name ?></td> 
                                            <?php if ($values['store_id'] == 0): ?>
                                                <td><?php echo 'Kho tổng' ?></td>
                                            <?php else: ?>
                                                <td><?php echo $this->Create_invetory->get_info($values['store_id'])->name_inventory; ?></td>
    <?php endif ?>
                                            <td><?php echo $this->Create_invetory->get_info($values['warehouse_id'])->name_inventory ?></td>
                                            <td style="text-align: right"><?php echo format_quantity($values['total']) ?></td>
                                            <td style="text-align: center"><?php echo date("d-m-Y H:i:s", strtotime($values['date'])) ?></td>
                                        <?php $stt++; ?>
                                        </tr>
<?php endforeach ?>
                                </tbody>

                            </table>
                        </div>
                    </td>
                </tr>
            </table> 
        </div>
    </div></div>
<?php $this->load->view('partial/footer'); ?>