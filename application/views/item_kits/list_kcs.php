<?php $this->load->view("partial/header"); ?>  
<div id="content_area_wrapper">
    <div id="content_area">
        <table id="title_bar_new">
            <tr>
                <td id="title_icon">
                    <a href="<?php echo base_url()?>item_kits/follow_bom" ><div class="newface_back"></div></a>
                </td>
                <td id="title" style="width: 600px">&nbsp; Theo dõi sản xuất
                </td>
                <td id="title_search_new" style="width: 200px;">
                </td>
            </tr>
        </table>
        <div id="content_order">
            <?php
            $stt = 0;
            foreach ($item_kit_processes->result() as $ip) {
                $processes = $this->Item_kit->get_info_processes($ip->id_processes);
                $stt ++;
                $request_id = $ip->request_id;
                $id_processes = $ip->id_processes;
                $info_history_kcs = $this->Item_kit->get_info_kcs_history_phase($request_id, $id_processes)->result();
                ?>
                <table class="title_processes">
                    <tr>
                        <td style="width: 5%;"><?= $stt ?></td>
                        <td style="width: 35%; border-right: none"><?= $processes->name_processes ?></td>
                        <?php
                        foreach ($info_history_kcs as $ihk) {
                            $array_kcs_id = array();
                            foreach ($request_feature as $f) {
                                $pro_id_min = $this->Item_kit->get_pro_id_min_in_item_kit_processes($request_id)->pro_id;
                                $info_processes_min = $this->Item_kit->get_info_item_kit_processes($request_id, $pro_id_min);
                                $info_sizes = $this->Item_kit->get_size_by_request_feature($request_id, $f->feature_id);
                                foreach ($info_sizes as $is) {
                                    $info_kcs = $this->Item_kit->get_info_kcs_new($request_id, $is->id, $id_processes);
                                    $kcs_id = $info_kcs->kcs_id;
                                    $kcs_id_prev = $this->Item_kit->get_info_kcs_prev($kcs_id)->kcs_id;
                                    $info_kcs_prev = $this->Item_kit->get_info_kcs_by_kcs_id($kcs_id_prev);

                                    $info_kcs_history_audi8 = $this->Item_kit->get_info_kcs_history_audi($request_id, $info_kcs_prev->id_processes, $kcs_id_prev);
                                    $info_kcs_history_audi = $this->Item_kit->get_info_kcs_history_audi($request_id, $id_processes, $kcs_id);
                                    if ($info_kcs->status == 0) {
                                        $array_kcs_id[] = $info_kcs->kcs_id;
                                    }
                                }
                            }
                        }
                        $data_total_kcs = $this->Item_kit->get_info_kcs_audi($request_id, $id_processes)->result();
                        $quantity_production_total = 0;
                        $quantity_request_total = 0;
                        foreach ($data_total_kcs as $val) {
                            $quantity_production_total += $val->quantity_production;
                            $quantity_request_total += $val->quantity_request;
                        }
                        $qty_percent = $quantity_production_total / $quantity_request_total * 100;
                        ?>
                        <td style="width: 10%; border-left: none; border-right: none">
                            <?php
                            if (!$info_history_kcs || count($array_kcs_id) > 0) {
                                echo anchor("item_kits/view_form_kcs/$id/$request_id/$id_processes/width~888/height~500", 'Cập nhật', array(
                                    'class' => 'thickbox button2',
                                    'title' => 'Cập nhật công đoạn'
                                        )
                                );
                            }
                            ?>
                        </td>                
                        <td style="width: 50%; border-left: none;">Tỉ lệ hoàn thành:
                            <div class="main_div" style="font: 13px solid; margin-top: -16px; margin-left: 130px; background: #E0522F; display: block; overflow: hidden; position: relative;">&nbsp;
                                <em style="color: white;"><?= number_format($qty_percent, 2) ?> %</em>
                                <div style="margin-top: -16px; background: green; width: <?= $qty_percent ?>%">&nbsp;</div>
                                <?php
                                if (!$info_history_kcs || count($array_kcs_id) > 0) { ?>
                                    <div style="margin-top: -16px; background: #6BB61D; width: <?= $qty_percent?>%">&nbsp;</div>
                                <?php } ?>
                                    <span class="display_scale"><?= ($quantity_production_total . "/" . $quantity_request_total); ?></span>
                            </div>
                        </td>
                    </tr>
                </table><br>
                <table class="table_order">
    <?php
    $i = 1;
    if ($info_history_kcs) {
        ?>
                        <tr style="height: 26px">
                            <th style="width: 15%">Tên mẫu</th>
                            <th style="width: 8%">Size</th>
                            <th style="width: 10%">SL yêu cầu</th>
                            <th style="width: 10%">SL sản xuất</th>
                            <th style="width: 10%">SL KCS</th>
                            <th style="width: 10%">SL đạt</th>
                            <th style="width: 10%">SL lỗi</th>
                            <th style="width: 15%">Lí do lỗi</th>
                            <th style="width: 12%">Trạng thái</th>
                        </tr>
                        <?php
                    }
                    $total_quantity_success = 0;
                    foreach ($info_history_kcs as $ihk) {
                        ?>
                        <tr>
                            <td colspan="9" class="date_kcs">Lần <?= $i ?>:
                                Ngày <?= date('d-m-Y H:i:s', strtotime($ihk->date_kcs)) ?>
                            </td>
                        </tr>
                        <?php
                        foreach ($request_feature as $f) {
                            $info_feature = $this->Item_kit->get_info_item_kit_feature($f->feature_id);
                            $info_sizes = $this->Item_kit->get_size_by_request_feature($request_id, $f->feature_id);

                            $pro_id_min = $this->Item_kit->get_pro_id_min_in_item_kit_processes($request_id)->pro_id; //pro_id cong doan dau tien
                            $info_processes_min = $this->Item_kit->get_info_item_kit_processes($request_id, $pro_id_min);
                            $count = $this->Item_kit->get_item_kit_request_feature($request_id, $f->feature_id)->num_rows();
                            ?>
                            <tr>
                                <td rowspan="<?= $count ?>" >
                                    <?= $info_feature->name_feature ?></td>
                                <?php
                                foreach ($info_sizes as $is) {
                                    $info_kcs = $this->Item_kit->get_info_kcs_new($request_id, $is->id, $id_processes);
                                    $kcs_id = $info_kcs->kcs_id;
                                    $kcs_id_prev = $this->Item_kit->get_info_kcs_prev($kcs_id)->kcs_id;
                                    $info_kcs_prev = $this->Item_kit->get_info_kcs_by_kcs_id($kcs_id_prev);
                                    $info_kcs_history_audi8 = $this->Item_kit->get_info_kcs_history_audi($request_id, $info_kcs_prev->id_processes, $kcs_id_prev);
                                    $info_kcs_history_audi = $this->Item_kit->get_info_kcs_history_audi($request_id, $id_processes, $kcs_id);
                                    $info_kcs_history = $this->Item_kit->get_info_kcs_history($request_id, $is->id, $id_processes, $ihk->date_kcs);
                                    $kcs_history_id = $info_kcs_history->kcs_history_id;
                                    $quantity_production = $this->Item_kit->get_info_kcs_history_bmw($request_id, $id_processes, $kcs_id, $ihk->date_kcs);
                                    ?>
                                    <td><?= $is->size ?></td>                
                                    <td class="quantity_request2">
                                        <?= $info_processes_min->id_processes == $id_processes ? $is->quantity : $info_kcs_history_audi8->quantity_success2 ?>
                                    </td>
                                    <td class="quantity_production2"> 
                                        <?= $quantity_production->quantity_success2 ?>
                                    </td>
                                    <td class="quantity_kcs2">
                                        <?= $info_kcs_history->quantity_kcs ?>
                                    </td>
                                    <td class="quantity_success2">
                                        <?= $info_kcs_history->quantity_success ?>
                                    </td>
                                    <td class="quantity_error2">
                                        <?= $info_kcs_history->quantity_error ?>
                                    </td>
                                    <td>
                                        <?= $info_kcs_history->cause_error ? $info_kcs_history->cause_error : '&nbsp' ?>
                                    </td>
                                    <td><?= $info_kcs->status == 1 ? 'Hoàn thành' : 'Chưa hoàn thành' ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        $i++;
                    }
                    ?>
                </table><br><br>
                <?php }
            ?>
        </div>
    </div></div>
<?php $this->load->view("partial/footer"); ?>
<style>
    .button2 {
        background:#E0522F;
        color: #FFFFFF;
        padding: 4px;
        text-align: left;
        text-decoration: none;
        width: 190px;
        text-shadow:1px 1px 1px #000;
        border-bottom:1px solid #FFFFFF;
        font-size: 15px;
    }
    .title_processes{
        width: 100%;
    }
    .title_processes tr td{
        border: 1px solid #CCCCCC
    }
    .title_processes tr, .title_processes td{
        padding: 4px 5px 
    }
    .quantity_production2, .quantity_success2{
        color: green
    }    
    .date_kcs{
        padding-top: 10px !important; 
        height: 26px
    }    
    .quantity_request2, .quantity_production2, .quantity_kcs2, .quantity_success2, .quantity_error2{
        text-align: right
    }
    .table_order tr td, .table_order tr th{
        padding: 3px 5px 
    }    
    #content_order{
        width: 800px;
        margin: 0px auto;
        font-size: 12px;
    }

    .table_order{
        border-collapse: collapse;
        width: 100%;
    }
    .table_order tr th{
        background: #e8e8e8;
    }
    .table_order th, .table_order td{
        border: 1px solid #CCCCCC;
    }
    .display_scale{
        display: none;
        color: #FFFFFF;
    }
    .main_div:hover .display_scale{
        display: block;
        position: absolute;
        top: 0px;
        left: 50%;
    }
</style>