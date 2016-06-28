<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<script src="<?php echo base_url(); ?>js/jquery-1.10.1.min.js"></script>

<style>
    body{
        padding: 0;
        margin: 0;
    }
    #print_a5{
        width: 797px;        
        display: block;
        overflow: hidden;       
        position: relative;
        margin-left: 10px;
        font-size: 12px;
    }
    #header_order{
        position: relative;
        width: 100%;
    }
    #logo_print{
        width: 150px;
        float: left;
        text-align: center;
    }
    #info_company{
        width: 500px;
        float: left;
    }
    #info_company tr td{
        font-size: 12px;
    }
    #info_order{
        float: right;
        width: 143px;
    }
    #info_order p{
        line-height: 6px;
    }
    #title_order{
        width: 100%;
        text-align: center;
        text-transform: uppercase;
        font-weight: bold;
        font-size: 16px;
        margin-top: 12px;
    }
    .color{
        color: #002FC2;
    }
    #table_items, #total_order{
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }
    #table_items th{
        border: 1px solid #000000;
        padding: 3px;
    }
    #table_items tr td{
        border: 1px solid #000000;       
        padding: 3px;
    }
    #total_order tr td{
        padding: 3px;        
        border-bottom: 1px dotted #000000;
    }
    #total_order tr td:first-child{
        border-left: 1px solid #000000;
    }
    #total_order tr td:last-child{
        border-right: 1px solid #000000;
    }
    #total_order tr:last-child td{
        border-bottom: 1px solid #000000;
    }
    #info_employee table{
        width: 100%;
    }
    #info_employee table th,#info_employee table td{
        width: 33%;
        text-align: center;
    }
    #info_employee table td{
        padding: 0px 0px 80px 0px;
    }
    #info_customer{
        display: block;
        overflow: hidden;
        padding-left: 10px;
    }
    #info_customer p{
        line-height: 6px;
    }
    #text_money{
        margin-top: 5px;
        padding: 5px;
    }
    .print_report{
        background: none repeat scroll 0 0 #1E5A96;
        border: 1px solid #EEEEEE;
        color: #FFFFFF;
        font-size: 14px;
        font-weight: bold;
        line-height: 30px;
        padding: 5px;
    }
</style>
<?php $this->load->model('item');
$this->load->model('unit');
?>
<div id="print_a5">
    <div id="header_order">
        <div id="logo_print">
<?php echo img(array('src' => $this->Appconfig->get_logo_image())); ?>
        </div>
        <div id="info_company">
            <table style="width: 100%">
                <tr>
                    <td colspan="2">
                        <span style="text-transform: uppercase;  font-weight: bold; color: #002FC2;">
<?php echo $this->config->item('company'); ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><span style='color: #002FC2'><?php echo $this->config->item('address'); ?></span></td>
                </tr>
                <tr>
                    <td style="width: 50%;">Điện thoại: <span style='color: #002FC2'><?php echo $this->config->item('phone'); ?></span></td>
                    <td style="width: 50%;">Email: <span style='color: #002FC2'><?php echo $this->config->item('email'); ?></span></td>
                </tr>
            </table>
        </div>
        <div id="info_order">
            <p>Số: <span style='color: #D50018; font-weight: bold'><?php echo $export_store_id; ?></span></p>
            <p>Ngày: <span style='color: #002FC2'>
                <?php echo $HallOweeN == 8 ? date('d-m-Y H:i:s', strtotime($date_export)) : date("d-m-Y H:i:s"); ?>
            </span></p>
        </div>
        <div style="clear: both"></div>
    </div>
    <div id="title_order">
<?php echo 'Phiếu xuất kho'; ?>
    </div>
    <div id="info_customer">
        <p>Tên kho: <span class="color" style="text-transform: uppercase;"><?php echo $store != 0 ? $this->Create_invetory->get_info($store)->name_inventory : 'KHO TỔNG'; ?></span></p>
        <p>Ghi chú: <span class="color"><?php echo $comment; ?></span></p>
    </div>
    <div id="content_order">
        <table id="table_items">
            <tr>
                <th>STT</th>
                <th>Mã mặt hàng</th>
                <th>Tên mặt hàng</th>
                <th>ĐVT</th>
                <th>SL xuất</th>                
                <th>Giá vốn</th>
                <th>Thành tiền</th>
            </tr>
            <?php
            $k = 1;
            $total_quantity_export = 0;
            $total_money = 0;
            foreach ($export_store_item_data as $line => $item) {
                $term = $this->Item->get_info($item['item_id']);
                $unit_name = $this->Unit->get_info($term->quantity_first == 0 ? $term->unit : $term->unit_from)->name;
                ?>
                <tr>
                    <td style="text-align: center; width: 3%"><?php echo $k; ?></td>
                    <td style="text-align: center; width: 15%"><?php echo $term->item_number; ?></td>
                    <td style="width: 25%"><?= $term->name; ?></td>
                    <td style="text-align: center; width: 12%"><?= $unit_name; ?></td>
                    <td style="text-align: right; width: 10%"><?= format_quantity($item['quantity_export']); ?></td>
                    <td style="text-align: right; width: 15%"><?= to_currency_unVND_nomar($item['cost_price_export']); ?></td>
                    <td style="text-align: right; width: 20%"><?= to_currency_unVND_nomar($item['cost_price_export'] * $item['quantity_export']); ?>
                    </td>
                </tr>
                <?php
                $total_quantity_export += $item['quantity_export'];
                $total_money += $item['cost_price_export'] * $item['quantity_export'];
                $k ++;
            }
            ?>
        </table>
        <table id="total_order">
            <tr>
                <td style="text-align: right; padding-right: 5px;"><b>Tổng số lượng xuất:</b></td>
                <td style="text-align: right;"><?php echo format_quantity($total_quantity_export) ?></td>
            </tr>            
            <tr>
                <td style="text-align: right; padding-right: 5px;"><b>Tổng thành tiền:</b></td>
                <td style="text-align: right;"><?php echo to_currency_unVND_nomar($total_money) ?></td>
            </tr>      
        </table>
    </div>
    <br>
    <div id="info_employee">
        <table>
            <tr>
                <th>Người nhận</th>
                <th>Nhân viên xuất kho</th>
            </tr>
            <tr>
                <td style="font-style: italic;">(Ký, ghi rõ họ tên)</td>
                <td style="font-style: italic;">(Ký, ghi rõ họ tên)</td>
            </tr>
        </table>
    </div>
    <?php 
    if($HallOweeN == 8){?>
            <a href="<?= site_url().'create_invetorys/export_store_view'?>" id="submit" 
               style="width:100px; text-align: center; margin-left: 350px" class="print_report" 
               onclick = "this.style.display = 'none'; window.print();">In hóa đơn</a>
    <?php
    }?>
<script>
$(document).ready(function () {
    <?php if(!$HallOweeN){?>
        window.print();
        window.location = "<?= site_url() . 'create_invetorys/export_store_view' ?>";
    <?php }?>
});
</script>

