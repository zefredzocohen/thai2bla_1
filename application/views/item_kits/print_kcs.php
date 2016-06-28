<script src="<?php echo base_url(); ?>js/jquery_1.js"></script>
<meta charset="utf8">
<title>In phiếu kcs</title>
<style>
.italic{
    font-style: italic;
}
.width{
    width: 700px;
    display: block;
    overflow: hidden;
    position: relative;
}
.left{
    margin-left: 480px;
}
.bold{
    font-weight: bold;
    margin-bottom: 0px;
}
.center{
    text-align: center;
}    
.print_report{
    background: none repeat scroll 0 0 #1E5A96;
    border: 1px solid #EEEEEE;
    color: #FFFFFF;
    font-size: 14px;
    font-weight: bold;
    line-height: 30px;
    padding: 5px;
    text-align: center;
    text-decoration: none;
    margin: 10px;
    float: right;
}
#info_user{
   display: block;
   overflow: hidden;
   position: relative;
}
.info_user, .info_kcs{
    width: 700px;
    }
.info_employee{
    width: 100%;
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
.quantity_production, .quantity_success{
    color: green
}    
.date_kcs{
    padding-top: 10px !important; 
    height: 26px
}    
.quantity_request, .quantity_production, .quantity_kcs, .quantity_success, .quantity_error{
    text-align: right
}
.table_order tr td, .table_order tr th{
    padding: 3px 5px 
}
</style>
<div class="width">
    <div style="display: block; overflow: hidden; position: relative">
        <?PHP $tieude = 'PHIẾU BÀN GIAO CÔNG ĐOẠN';?>
        <h2 class='bold center'><?php echo $tieude ?></h2>               
    </div><br>
    <?php
    $i = $this->Item_kit->get_info_kcs_history_phase($request_id, $id_processes)->num_rows();
    $date_kcs = $this->Item_kit->get_info_kcs_history_phase_max_date($request_id, $id_processes)->date_kcs;
    $processes = $this->Item_kit->get_info_processes($id_processes);
    $info_processes_cost = $this->Item_kit->get_info_processes_cost($request_id, $id_processes)->row();
    
    $pro_id_max = $this->Item_kit->get_pro_id_max_in_item_kit_processes($request_id)->pro_id;//pro_id cong doan cuoi cung
    $info_processes_max = $this->Item_kit->get_info_item_kit_processes($request_id, $pro_id_max);    
    ?>
    <div id="info_user">
        <table class="info_user">
            <tr>
                <td>Lần: <?= $i ?></td>
                <td>Ngày: <?= date('d-m-Y H:i:s', strtotime($date_kcs)) ?></td>
            </tr>
            <tr>
                <td>Người giao: </td>
                <td>Người nhận: <?= $info_processes_cost->outsource != 0 ? $this->Supplier->get_info($info_processes_cost->outsource)->company_name : '' ?></td>
            </tr>
            <tr>
                <td>Công đoạn: <?= $processes->name_processes ?></td>
                <td>Trưởng ca: </td>
            </tr>
            <tr>
                <td colspan="2">Tình trạng máy: </td>
            </tr>
            <tr>
                <td colspan="2">Chi tiết công việc: </td>
            </tr>
        </table><br>
        
        <table class="table_order">
            
            <tr>
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
            $info_history_kcs = $this->Item_kit->get_info_kcs_history_phase_by_date($request_id, $id_processes, $date_kcs)->result();
            foreach ($info_history_kcs as $ihk){
                foreach ($request_feature as $f){
                    $info_feature = $this->Item_kit->get_info_item_kit_feature($f->feature_id);
                    $info_sizes = $this->Item_kit->get_size_by_request_feature($request_id,$f->feature_id);

                    $pro_id_min = $this->Item_kit->get_pro_id_min_in_item_kit_processes($request_id)->pro_id;//pro_id cong doan dau tien
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
                                $info_kcs_history_audi = $this->Item_kit->get_info_kcs_history_audi($request_id, $id_processes, $kcs_id);

                                $info_kcs_history = $this->Item_kit->get_info_kcs_history($request_id, $is->id, $id_processes, $ihk->date_kcs);
                                $kcs_history_id = $info_kcs_history->kcs_history_id;                        
                                ?>
                                <td><?= $is->size ?></td>                
                                <td class="quantity_request">
                                    <?= $info_processes_min->id_processes == $id_processes ? $is->quantity : $info_kcs->quantity_request ?>
                                </td>
                                <td class="quantity_production"> 
                                    <?= $info_kcs_history_audi->quantity_success2 ?>
                                </td>
                                <td class="quantity_kcs">
                                    <?= $info_kcs_history->quantity_kcs ?>
                                </td>
                                <td class="quantity_success">
                                    <?= $info_kcs_history->quantity_success ?>
                                </td>
                                <td class="quantity_error">
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
            }?>
             
        </table>
    </div><br>
    <div class="left italic">Ngày.....tháng.....năm.......</div> 
    <table class="info_employee">
        <tr class='bold'>
            <td style="width: 75%"></td>
            <td style="width: 25%">Người lập</td>
        </tr>
        <tr>
            <td style="width: 75%"></td>
            <td style="width: 25%">(ký, họ tên)</td>
        </tr>
    </table>
</div>
<script>
$(document).ready(function() {       
    window.print();
    window.location = '<?= site_url() ."/item_kits/view_list_kcs/$id" ?>';
});
</script>