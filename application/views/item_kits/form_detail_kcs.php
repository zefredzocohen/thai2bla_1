<table class="tablesorter" id="detail_kcs_table" >
    <tr>
        <th>Số phiếu</th>
        <th>Số lượng</th>
        <th>Ngày tháng</th>
        <th></th>
    </tr>
    <?php
    foreach ($inventory_product->result() as $HallOweeN_AeOn) {
        $quantity = $this->Inventory->get_inventory_by_import_product_id_2016($HallOweeN_AeOn->import_product_id)->quantity;
        ?>
        <tr>
            <td style="text-align: center"><?= $HallOweeN_AeOn->import_product_id ?></td>
            <td style="text-align: center"><?= $quantity ?></td>
            <td style="text-align: center"><?= date('d-m-Y H:i:s', strtotime($HallOweeN_AeOn->trans_date)) ?></td>
            <td style="text-align: center">
                <a href="<?php echo site_url('item_kits/switch_order_warehouse_six/'.$HallOweeN_AeOn->import_product_id);?>" target="brank_">Phiếu nhập kho</a>
            </td>
        </tr>
        <?php
    }?>
</table>
<style>
    #detail_kcs_table{
        border-collapse: collapse;
    }
    #detail_kcs_table th{
        text-align: center;
        background: #C0C0C0;
    }
    #detail_kcs_table th, #detail_kcs_table td{
        border: 1px solid #CCCCCC;
        padding: 4px;
    }
</style>