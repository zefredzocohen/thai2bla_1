<?php
$info_production = $this->Item_kit->get_info_item_production($id_production);
$info_item = $this->Item_kit->get_info($info_request->item_kit_id);
$unit = $this->Unit->get_info($info_item->unit);
$item_request_feature = $this->Item_kit->get_feature_in_request_feature($info_request->request_id); //Lay danh sach kieu san pham
?>
<html>
    <head>
        <meta charset='utf-8'>
        <title>Phiếu yêu cầu sản xuất</title>
    </head>
    <body>        
        <div id="content_order">
            <div id="title_header">
                <div id="info_company"><?php echo $this->config->item('company'); ?></div>
                <div id="info_order_request">Số phiếu: <?= $request_id; ?><br>Ngày tháng: <?= date("d-m-Y"); ?></div>
            </div>
            <div style="clear: both"></div>
            <div style='text-align: center;  text-transform: uppercase;font-weight: bold; margin: 10px auto; font-size: 18px'>Phiếu yêu cầu sản xuất</div>
            <p>Căn cứ chức năng nhiệm vụ của Phòng Kinh doanh. </p>
            <p>Để đảm bảo thực hiện sản xuất theo yêu cầu của khách hàng, Phòng Kinh doanh yêu cầu bộ phận sản xuất với nội dung công việc như sau:</p>
            <p class="title_table">I. Thông tin thành phẩm</p>
            <p>Mã: <?= $info_item->item_kit_number; ?></p>
            <p>Tên: <?= $info_item->name; ?></p>
            <p>ĐVT: <?= $unit->name; ?></p>           
            <p class="title_table">II. Kiểu thành phẩm và công thức NVL</p>
            <table class="table_order">
                <tr>
                    <th>Tên kiểu</th>
                    <th>Size - Số lượng</th>
                    <th>Mã NVL</th>
                    <th>Tên NVL</th>
                    <th>ĐVT</th>
                    <th>Định mức</th>                   
                </tr>
                <?php
                $arr = array();
                $total_size = 0;
                foreach ($item_request_feature as $request_feature) {
                    $request_feature_size = $this->Item_kit->get_size_by_request_feature($info_request->request_id, $request_feature->feature_id);
                    $i = count($request_feature_size);
                    $info_feature = $this->Item_kit->get_info_item_kit_feature($request_feature->feature_id);
                    $info_material = $this->Item_kit->get_info_formula_materials($request_feature->feature_id);
                    $j = count($info_material);
                    $k = 0;
                    $total_quantity = 0;

                    foreach ($info_material as $material) {
                        $total_quantity += $material['quantity'];
                    }
                    foreach ($info_material as $material) {
                        $k++;
                        echo "<tr>";
                        if ($j > 1) {
                            if ($k == 1) {
                                echo "<td rowspan='" . $j . "' style='width: 20%'>$info_feature->name_feature</td>";
                                echo "<td style='text-align: center; width: 15%' rowspan='" . $j . "'>";
                                foreach ($request_feature_size as $val) {
                                    if ($i > 1) {
                                        echo $val->size . " - " . $val->quantity . "<br>";
                                    } else {
                                        echo $val->size . " - " . $val->quantity;
                                    }
                                    $total_size += $val->quantity;
                                }
                                echo "</td>";
                            }
                        } else {
                            echo "<td style='width: 20%'>$info_feature->name_feature</td>";
                            echo "<td style='text-align: center; width: 15%'>";
                            foreach ($request_feature_size as $val) {
                                if ($i > 1) {
                                    echo $val->size . " - " . $val->quantity . "<br>";
                                } else {
                                    echo $val->size . " - " . $val->quantity;
                                }
                                $total_size += $val->quantity;
                            }
                            echo "</td>";
                        }
                        $info_item = $this->Item->get_info($material['item_id']);
                        echo "<td style='text-align: center; width: 10%'>" . $info_item->item_number . "</td>";
                        echo "<td style='width: 35%'>" . $info_item->name . "</td>";
                        $info_item_formula_materials = $this->Item_kit->get_info_formula_materials_item($material['item_id']);
                        $unit = $this->Unit->get_info($info_item_formula_materials->unit);
                        echo "<td style='width: 10%'>" . $unit->name . "</td>";
                        echo "<td style='text-align: right; width: 10%'>" . format_quantity($material['quantity']) . "</td>";
                        echo "</tr>";
                        $arr[$material['item_id']] += $total_size * $material['quantity'];
                    }
                }
                ?>
                <tr style="font-weight: bold">
                    <td style="text-align: center">Tổng</td>
                    <td style='text-align: center'><?= $total_size; ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            <p class="title_table">III. Tổng hợp NVL</p>
<?php $list_item = $this->Item_kit->get_item_history_production($id_production); ?>           
            <table class="table_order">
                <tr>
                    <th>Mã NVL</th>
                    <th>Tên NVL</th>
                    <th>ĐVT</th>
                    <th>Số lượng</th>
                </tr>
                <?php
                foreach ($arr as $key => $val) {
                    $info_item = $this->Item->get_info($key);
                    $info_item_formula_materials = $this->Item_kit->get_info_formula_materials_item($key);
                    $unit = $this->Unit->get_info($info_item_formula_materials->unit);
                    $norms_item_info = $this->Item_kit->get_info_item_kit_norms_item($request_id, $key);
                    $qty_total = number_format($norms_item_info->quantity_total ? $norms_item_info->quantity_total : $val);
                    echo "<tr>";
                    echo "<td style='text-align: center; width: 15%;'>$info_item->item_number</td>";
                    echo "<td style='width: 45%;'>$info_item->name</td>";
                    echo "<td style='width: 20%;'>$unit->name</td>";
                    echo "<td style='text-align: right; width: 20%;'>$qty_total</td>";
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
            <a href = "<?php echo site_url('/item_kits/manager_request_production'); ?>" id="submit" style="width:100px;" class="print_report" onclick = "window.print();
                    window.close()">In phiếu</a>
        </div><br>	
    </body>
</html>
<style>
    * {
        margin: 0px;
        padding: 0px;
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
    .title_table {
        font-weight: bold;
        margin: 5px 0px;
    }
</style>