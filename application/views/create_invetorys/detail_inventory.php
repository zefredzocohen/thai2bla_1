<?php $this->load->view('partial/header'); ?>
<div id="content_area_wrapper">
    <div id="content_area" style="height: auto;float: left;">
        <div style="width: 500px;float:left">
            <h4>Tên kho :  <span style="font-size:18px; color:#F23118"><?php echo $name_inventory; ?></span></h4>
            <h4>Địa chỉ :  <span><?php echo $address_warehouse; ?></span></h4>
            <h4>Ngày tạo kho  :  <span><?php echo date('d/m/Y', strtotime($created_date)); ?></span></h4>
        </div>
        <div>
            <h5><?php echo anchor('create_invetorys', 'Trờ lại', array('style' => 'text-decoration: underline;')); ?></h5>
        </div>
        <table id="contents" style="margin-top:50px;">
            <tr>
                <td id="item_table">
                    <div id="table_holder" style="width: 960px;">
                        <table class="tablesorter report" id="sortable_table">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên SP</th>
                                    <th>Giá SP</th>
                                    <th>Kho chuyển</th>
                                    <th>Số lượng</th>	
                                </tr>
                            </thead>
                            <tbody>
                                <?php $stt = 1; ?>
                                <?php foreach ($infoma_item as $key): ?>

                                    <tr>
                                        <td><?php echo $stt; ?></td>
                                        <td><?php echo $key['name'] ?></td>
                                        <td style="text-align: right"><?php echo number_format($key['cost_price']) ?></td>
                                        <?php if ($key['store_id'] != 0): ?>
                                            <td><?php echo $this->Create_invetory->get_info($key['store_id'])->name_inventory ?></td>
                                        <?php else: ?>
                                            <td><?php echo 'kho tổng' ?></td>
                                        <?php endif ?>

                                        <td style="text-align: right"><?php echo format_quantity($key['total_transfer']) ?></td>	
                                    </tr>
                                    <?php $stt++; ?>
                                    <?php $subtotal_quan += $key['total_transfer'] ?>
                                <?php endforeach ?>
                            </tbody>
                            <tbody>

                                <?php
                                // $subtotal_quan=$this->Item->total_quantity_transfer()->quantity;
                                // var_dump($subtotal_quan);exit();
                                ?>
                                <tr>
                                    <td colspan="4" style="font-weight: bold;text-align:center">Tổng SL trong kho</td>
                                    <td colspan="" style="font-weight: bold; text-align: right" ><?php echo format_quantity($subtotal_quan) ?></td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
        </table>			
    </div>
</div>			
<?php $this->load->view('partial/footer'); ?>	