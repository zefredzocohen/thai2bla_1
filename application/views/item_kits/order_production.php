<?php
$info_production = $this->Item_kit->get_info_item_production($id_production);
$info_item = $this->Item_kit->get_info($info_production->item_kit_id);
?>
<html>
    <head>
        <meta charset='utf-8'>
        <title>Phiếu lệnh sản xuất</title>
    </head>
    <body>        
        <div id="content_order">
            <p><?php echo $this->config->item('company'); ?></p>
            <div style='text-align: center;  text-transform: uppercase;font-weight: bold;'>Lệnh sản xuất</div>
            <p>Căn cứ chức năng nhiệm vụ của Phòng Kinh doanh. </p>
            <p>Để đảm bảo thực hiện sản xuất theo yêu cầu của khách hàng, Phòng Kinh doanh yêu cầu bộ phận sản xuất với nội dung công việc như sau:</p>
            <p>I. Thành phẩm</p>
            <table class="table_order">
                <tr>
                    <th>Tên thành phẩm</th>
                    <th>Số lượng</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                    <th>Ghi chú</th>
                </tr>
                <tr>
                    <td style="width: 25%; padding-left: 10px;"><?php echo $info_item->name; ?></td>
                    <td style="width: 10%; padding-right: 10px; text-align: right;"><?php echo $info_production->quantity_production; ?></td>
                    <td style="width: 15%; text-align: center;"><?php echo date("d-m-Y",strtotime($info_production->date_begin)); ?></td>
                    <td style="width: 15%; text-align: center;"><?php echo date("d-m-Y",strtotime($info_production->date_end)); ?></td>
                    <td></td>
                </tr>
            </table>
            <p>II. Nguyên vật liệu</p>
            <?php $list_item = $this->Item_kit->get_item_history_production($id_production);?>           
            <table class="table_order">
                <tr>
                    <th>Tên nguyên vật liệu</th>
                    <th>Số lượng</th>
                    <th>Ghi chú</th>
                </tr>
                <?php
                foreach ($list_item as $value){
                    $info_item_of_list_item = $this->Item->get_info($value['item_id']);
                    echo "<tr>";
                        echo "<td style='width: 25%; padding-left: 10px;'>".$info_item_of_list_item->name."</td>";
                        echo "<td style='width: 25%; padding-right: 10px; text-align: right;'>".$value['quantity_production']."</td>";
                        echo "<td></td>";
                    echo "</tr>";
                }
                ?>               
            </table>
            <div style="text-align: right; width: 100%; font-style: italic;"> 
                <p style="margin-right: 80px"><?php echo "Ngày " . date('d') . " tháng " . date('m') . " năm " . date('Y'); ?></p>
            </div>
            <table id="table_button">
                <tr>
                    <td>Giám đốc<br><i>(Ký tên)</i></td>
                    <td>Phụ trách sản xuất<br><i>(Ký tên)</i></td>
                    <td>Phụ trách kinh doanh<br><i>(Ký tên)</i></td>
                </tr>
            </table>
            <a href = "<?php echo site_url('/item_kits/follow_bom/'.$info_production->item_kit_id);?>" id="submit" style="width:100px;" class="print_report" onclick = "window.print()">In phiếu</a>
        </div>	
    </body>
</html>
<style>
    #content_order{
        width: 800px;
        margin: 0px auto;
    }
    .table_order,#table_button{
        border-collapse: collapse;
        width: 100%;
    }
    .table_order th, .table_order td{
        border: 1px solid #CCCCCC;
    }
    #table_button td{
        width: 33%;
        text-align: center;
    }
</style>