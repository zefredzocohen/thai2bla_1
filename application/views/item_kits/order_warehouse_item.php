<?php
$info_production = $this->Item_kit->get_info_item_production($id_production);
$info_request = $this->Item_kit->get_info_item_production_by_request_id($request_id);
$info_item = $this->Item_kit->get_info($info_request->item_kit_id);
$item_request_feature = $this->Item_kit->get_feature_in_request_feature($request_id);
?>
<html>
    <head>
        <meta charset='utf-8'>
        <title>Phiếu yêu cầu xuất nguyên vật liệu</title>
    </head>
    <body>        
        <div id="content_order">
            <div id="title_header">
                <div id="info_company"><?php echo $this->config->item('company'); ?></div>
                <div id="info_order_request">Số phiếu: <?= $info_request->id;?><br>Ngày tháng: <?= date("d-m-Y");?></div>
            </div>
            <div style="clear: both"></div>
            <div style='text-align: center;  text-transform: uppercase;font-weight: bold; font-size: 20px; margin: 20px 0px 5px 0px;'>Phiếu yêu cầu xuất nguyên vật liệu</div>
            <p>Bên yêu cầu: Bộ phận sản xuất</p>
            <p>Mục đích sử dụng: Sản xuất thành phẩm "<strong><?php echo $info_item->name; ?></strong>"</p>
            <p>Danh sách nguyên vật liệu</p>
            <table class="table_order">
                <tr>
                    <th>STT</th>
                    <th>Mã NVL</th>
                    <th>Tên NVL</th>
                    <th>ĐVT</th>
                    <th>Số lượng</th>
                </tr>
                <?php                
                $arr = array();
                foreach ($item_request_feature as $request_feature){
                    $request_feature_size = $this->Item_kit->get_size_by_request_feature($info_request->request_id, $request_feature->feature_id);
                    $info_material = $this->Item_kit->get_info_formula_materials($request_feature->feature_id);
                    foreach ($info_material as $material){
                        $total_size = 0;
                        foreach ($request_feature_size as $val){
                            $total_size += $val->quantity;
                        }                    
                        $arr[$material['item_id']] += $total_size * $material['quantity'];
                    }                    
                }
                $stt = 1;
                $tong = 0;
                foreach ($arr as $key => $value){
                    $info_item_formula_materials = $this->Item_kit->get_info_formula_materials_item($key);
                    $unit = $this->Unit->get_info($info_item_formula_materials->unit);
                    
                    $norms_item_info = $this->Item_kit->get_info_item_kit_norms_item($request_id, $key);
                    $qty_total = $norms_item_info->quantity_total ? $norms_item_info->quantity_total : $value;
                    $tong += $qty_total;
                    echo "<tr>";
                        echo "<td style='text-align: center; width: 5%;'>".$stt."</td>";
                        $info_item = $this->Item->get_info($key);
                        echo "<td style='text-align: center; width: 15%;'>".$info_item->item_number."</td>";
                        echo "<td style='width: 50%;'>".$info_item->name."</td>";                        
                        echo "<td style='width: 15%;'>".$unit->name."</td>";
                        echo "<td style='text-align: right; width: 15%;'>".format_quantity($qty_total)."</td>";
                    echo "</tr>";
                    $stt++;
                }
                ?>
                <tr style='font-weight: bold'>
                    <td colspan="4" style='text-align: center;'>Tổng</td>
                    <td style='text-align: right;'><?= format_quantity($tong);?></td>
                </tr>
            </table>
            <div style="text-align: right; width: 100%; font-style: italic;"> 
                <p style="margin-right: 80px">Ngày..... tháng..... năm.....</p>
            </div>
            <table id="table_button">
                <tr>
                    <td>Giám đốc<br><i>(Ký tên)</i></td>
                    <td>Quản lý kho<br><i>(Ký tên)</i></td>
                    <td>Phụ trách sản xuất<br><i>(Ký tên)</i></td>
                </tr>
                
            </table>
            <a href = "<?php echo site_url('/item_kits/follow_bom/'.$info_production->item_kit_id);?>" id="submit" style="width:100px;" class="print_report" onclick = "window.print(); window.close();">In phiếu</a>
        </div>	
    </body>
</html>
<style>
    *{
        margin: 0;
        padding: 0;
        font-size: 14px;
    }
    #content_order{
        width: 800px;
        margin: 0px auto;
    }
    #content_order p{
        line-height: 24px;        
    }
    #info_company{
        width: 30%;
        float: left;
    }
    #info_order_request{
        width: 30%;
        float: right;
    }
    .table_order,#table_button{
        border-collapse: collapse;
        width: 100%;
    }
    .table_order th, .table_order td{
        border: 1px solid #CCCCCC;
        padding: 3px;
    }
    #table_button td{
        width: 33%;
        text-align: center;
    }
</style>