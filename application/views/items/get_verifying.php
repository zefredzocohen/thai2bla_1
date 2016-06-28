	

<?php if (isset($verifying)): ?>

    <h3 style="color:#3B3A35;font-size:13px;">Sản phẩm đã kiểm kê trong ngày</h3>
    <table id="contents" style="margin-top:15px;">
        <tr>
            <td id="item_table">
                <div id="table_holder" style="width: 960px;">
                    <table class="tablesorter report" id="sortable_table">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Mã SP</th>
                                <th>Tên SP</th>
                                <th>Loại SP</th>
                                <th>Giá nhập</th>
                                <th style="display:none">SL nhập</th>
                                <th>Kho</th>
                                <th>SL kho</th>
                                <th>SL bán</th>
                                <th>SL kiểm</th>
                                <th> SL chêch lệch</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $stt = 1; ?>
                            <?php foreach ($verifying as $key): ?>
                                <?php
                                $kho = $key['quantity_inventory'];
                                $kt = $key['quantity_verifying'];
                                $chech = $key['quantity_inventory'] - $key['quantity_verifying']
                                ?>
                                <tr>
                                    <td><?php echo $stt; ?></td>
                                    <td><?php echo $key['item_id'] ?></td>
                                    <td><?php echo $key['name'] ?></td>
                                    <td><?php echo $this->Category->get_info($key['category'])->name ?></td>
                                    <td><?php echo number_format($key['cost_price']) ?></td>
                                    <td style="display:none"><?php echo format_quantity($key['quantity_input']); ?></td>

                                    <td>
                                        <?php
                                        if ($key['warehouse_id'] == 0) {
                                            echo 'Kho tổng';
                                        }
                                        echo $this->Create_invetory->get_info($key['warehouse_id'])->name_inventory;
                                        ?>						                        
                                    </td>

                                    <td colspan="" rowspan="" headers="" >
                                        <?php if ($store_kho != 0) { ?>
                                            <?php foreach ($store as $key) { ?>
                                                <?php echo format_quantity($key['quan']) ?>
                                            <?php } ?>    
                                        <?php } else { ?>
                                            <?php echo format_quantity($key['quantity_inventory']) ?>
                                        <?php } ?>      
                                    </td>  

                                    <td>
                                        <?php if ($store_kho != 0) { ?>

                                            <?php foreach ($get_buy as $gb) { ?>
                                                <?php echo $gb['buy2']; ?>
                                                <input type="hidden" name="txtbuys" value="<?php echo $gb['buy2']; ?>">
                                            <?php } ?>	

                                        <?php } else { ?>

                                            <?php echo format_quantity($key['quantity_sale']) ?>
                                            <input type="hidden" name="txtbuys" value="<?php echo $key['buy'] ?>">

                                        <?php } ?>	
                                    </td>


                                    <td><?php echo format_quantity($key['quantity_verifying']) ?></td>
                                    <td><?php echo format_quantity($chech); ?></td>
                                </tr>
                                <?php $stt++ ?>
                            <?php endforeach ?>

                        </tbody>
                    </table>
                </div>
            </td>
        </tr>

    </table>
    <?php
 endif ?>
