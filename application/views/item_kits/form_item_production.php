<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js" type="text/javascript"></script>
<?php if( $production_design->num_rows() == 0){
    echo 'Chưa có mẫu sản xuất nào được phê duyệt !';exit();
}?>
<ul id="error_message_box"></ul>
<fieldset id="item_kit_info">
    <legend>Thông tin sản phẩm</legend>
    <table id="table_info_item_kit">
        <tr>
            <td class="left_table"><?php echo form_label('Mã sản phẩm:', name, array('class' => wide)); ?></td>
            <td class="right_table"><?=$item_kit_info->item_kit_number;?></td>
            <td class="left_table"><?php echo form_label(lang(item_kits_name) . ':', name, array('class' => wide)); ?></td>
            <td class="right_table"><?=$item_kit_info->name;?></td>
        </tr>
        <tr>
            <td class="left_table"><?php echo form_label(lang(item_kits_unit) . ':', unit, array('class' => wide)); ?></td>
            <td class="right_table"> <?= $this->Unit->get_info($item_kit_info->unit)->name ?></td>
            <td class="left_table"><?php echo form_label(lang(items_category) . ':', category, array('class' => wide)); ?></td>
            <td class="right_table"><?= $this->Category->get_info($item_kit_info->category)->name ?></td>
        </tr>
    </table>     
</fieldset>    
<?php echo form_open_multipart('item_kits/save_item_production/' . $request_id, array(id => item_kit_form_approve_estimate)); ?>    
<fieldset id="item_kit_feature">
    <legend>Thông tin sản xuất</legend>
    <div class="field_row clearfix">
        <?php echo form_label('Mã yêu cầu:', request_id, array('class' => wide)); ?>
        <div class='form_field'><?= $info_request_production->request_id ?></div>
    </div>
    <h4>&nbsp;* Tổng hợp mẫu sản xuất : </h4>
    <table id=item_kit_size>
        <tr style='text-align: center'>
            <th style="width: 10%" rowspan="2">Tên mẫu</th> 
            <th colspan="2">Thông tin size</th>
            <th colspan="8">Công thức nguyên vật liệu</th>
        </tr>
        <tr>
            <th style="width: 5%">Size</th> 
            <th style="width: 5%">SL size</th>
            <th style="width: 10%">Mã NVL</th>
            <th style="width: 10%">Tên NVL</th>
            <th style="width: 6%">ĐVT</th>
            <th style="width: 7%">Định mức/SP</th>
<!--            <th style="width: 7%">Tổng định mức</th>-->
            <th style="width: 10%">Giá nhập</th>
            <th style="width: 10%">Giá xuất</th>
            <th style="width: 10%">SL trong kho</th>
            <th style="width: 10%">SL còn lại</th>
           
        </tr>
        <?php $total_size = 0;
        $total_norms_per_item = 0;
        $total_norms = 0;
        $total_money_norms = 0;
        foreach ($request_feature as $f){
            $i = $this->Item_kit->count_formula_materials($f->feature_id);
            $info_feature = $this->Item_kit->get_info_item_kit_feature($f->feature_id);
            ?>
            <tr>
                <td style='text-align: left; width: 10%;' rowspan="<?= $i ?>"><?= $info_feature->name_feature ?></td> 
                <?php $info_sizes = $this->Item_kit->get_size_by_request_feature($f->request_id,$f->feature_id);?>
                <td rowspan="<?= $i ?>" style="width: 5%;">
                    <table id="size_detail">
                        <?php foreach ($info_sizes as $is) {?>
                        <tr>
                            <td>
                                <?= $is->size?>
                            </td>                            
                        </tr>
                        <?php
                        }?>
                    </table>
                </td>
                <td rowspan="<?= $i ?>" style="text-align: right; width: 5%">
                    <table id="quantity_detail">
                        <?php                         
                        foreach ($info_sizes as $is) {
                            $total_size += $is->quantity?>
                            <tr>
                                <td>
                                    <?= $is->quantity?>
                                </td>
                            </tr>
                        <?php
                        }?>
                    </table>
                </td>
                    <?php                
                $info_formula_material = $this->Item_kit->get_info_formula_materials($f->feature_id);
                foreach ($info_formula_material as $fm) {
                    $info_store = $this->Create_invetory->check_exist_store_materials();
                    $item_info = $this->Item->get_info_in_store_material($fm[item_id], $info_store[id]);
                    $info_formula_material_item = $this->Item_kit->get_info_formula_materials_item($fm[item_id]);
                    $unit_info = $this->Unit->get_info($info_formula_material_item->unit);
                    $item_size = $this->Item_kit->get_info_item_size($f->feature_id, $fm[item_id]);
                    $total_size_of_feature_request = 0;
                    foreach ($info_sizes as $val){
                        $total_size_of_feature_request += $val->quantity;
                    }
                    $total_quantity = $total_size_of_feature_request * $item_size->quantity;
                    $cost_price = $item_info->quantity_first != 0 ? $item_info->cost_price_rate : $item_info->cost_price;
                    
                    $total_norms_per_item += $item_size->quantity;
                    $total_norms += $total_quantity;
                    $total_money_norms += $total_quantity * $cost_price;
                    ?>
                    <td style="text-align: center; width: 10%;"><?= $item_info->item_number?></td>
                    <td style="width: 10%;"><?= $item_info->name?></td>
                    <td style="width: 6%;"><?= $unit_info->name?></td>
                    <td style="text-align: right; width: 7%;"><?= format_quantity($item_size->quantity)?></td>
                    <td style="text-align: right; width: 10%;">
                        <?= format_quantity($cost_price) ?>
                    </td>
                    <td style="text-align: right; width: 10%;">
                        <?= format_quantity($item_info->quantity_first != 0 ? $item_info->unit_price_rate : $item_info->unit_price) ?>
                    </td>
                    <td style="text-align: right; width: 10%;">
                        <?= format_quantity($item_info->quantity);?>
                    </td>
                    <td style="text-align: right; width: 10%;">
                        <?= format_quantity($item_info->quantity - $total_quantity >= 0 ? $item_info->quantity - $total_quantity : 0)?>
                    </td>
                </tr>
             <?php  
            }
        }?>
        <tfoot style="font-weight: bold">
            <td colspan="2"> Tổng</td>
            <td style="text-align: right;"><?= format_quantity($total_size);?></td>
            <td colspan="3" style="background: #e8e8e8"></td>
            <td style="text-align: right;"><?= format_quantity($total_norms_per_item);?></td>
            <td colspan="4" style="background: #e8e8e8"></td>
        </tfoot>
    </table>
    <?php
    foreach ($request_feature as $f){
        $size_quantity = 0;
        $sizes = $this->Item_kit->get_item_kit_request_feature_by_feature_id($request_id, $f->feature_id);
        foreach ($sizes->result() as $size){
            $size_quantity += $size->quantity;
        }
        $info_formula_material = $this->Item_kit->get_info_formula_materials($f->feature_id);
        if($info_formula_material){
            foreach ($info_formula_material as $fm) {
                $request_feature_quantity = $fm['quantity'] * $size_quantity;
                $quantitys[$fm['item_id']] += $request_feature_quantity;
            }
        }
    }?>
    <h4>&nbsp;* Tổng hợp số lượng vật tư : </h4>
    <table id=item_kit_size3>
        <tr style='text-align: center'>
            <th style="width: 10%">STT</th>
            <th style="width: 20%">Tên vật tư</th> 
            <th style="width: 20%">Tổng định mức vật tư</th>
            <th style="width: 20%">Số lượng vật tư trong kho</th>
            <th style="width: 20%">Số lượng vật tư còn lại</th>
        </tr>
        <?php
        $stt = 0;
        foreach ($quantitys as $item_id => $quantity){
            $item_fm = $this->Item_kit->get_item_fm($feature_ids, $item_id);
            $info_store = $this->Create_invetory->check_exist_store_materials();
            $item_info = $this->Item->get_info_in_store_material($item_id, $info_store[id]);
            $stt++;
            ?>
            <tr>
                <td style="text-align: center"><?= $stt ?></td>
                <td><?php
                echo form_input(array(
                    name => "item_id[$item_id]",
                    type => hidden,
                    value => $item_id
                ));
                echo $this->Item->get_info($item_id)->name ?></td>
                <td><?php $quantity2 = 0;
                    foreach ($item_fm->result() as $if){

                        $info_sizes = $this->Item_kit->get_size_by_request_feature($request_id,$if->feature_id);
                        $total_size_of_feature_request = 0;
                        foreach ($info_sizes as $val){
                            $total_size_of_feature_request += $val->quantity;
                        }
                        $item_size = $this->Item_kit->get_info_item_size($if->feature_id, $item_id);
                        $total_quantity = $total_size_of_feature_request * $item_size->quantity;
                        $quantity2 += $total_quantity;
                        echo form_input(array(
                            'id' => "qty_old$item_id",
                            'class' => "qty_old$if->feature_id$item_id",
                            type => hidden,
                            value => $total_quantity
                        ));
                    }
                    $norms_item_info = $this->Item_kit->get_info_item_kit_norms_item($request_id, $item_id);
                    $qty_total = $norms_item_info->quantity_total ? $norms_item_info->quantity_total : $quantity2;          
                    echo form_input(array(
                        name => "quantity_total[$item_id]",
                        'class' => "qty_total qty_total$item_id",
                        id => "qty_total_$item_id",
                        value => number_format($qty_total),
                        readonly => ''
                    ))?>
                </td>
                <td><?= 
                    form_input(array(
                        'class' => "qty_store qty_store$item_id",
                        value => $item_info->quantity,
                        readonly => ''
                    )) ?>
                </td>
                <td><?= 
                    form_input(array(
                        'class' => "qty_remain qty_remain$item_id",
                        readonly => '',
                        value => number_format($item_info->quantity - $qty_total)
                    )) ?>
                </td>
            </tr>
        <?php
        }?> 
    </table><br>
    
    <h4>&nbsp;* Tổng hợp công đoạn SX : </h4>
    <table id="brand_table">  
        <tr style="border: 1px solid green">
            <th style="width: 10%">STT</th>
            <th style="width: 30%">Công đoạn</th>
            <th style="width: 10%">Thời gian</th>
            <th style="width: 20%">Đơn vị thời gian</th>
            <th style="width: 30%">Chi phí công đoạn</th>
        </tr>
        <?php
        $unit_time = array(
            ''=>'-- Chọn đơn vị thời gian --',
            0=>Giờ, 
            1=>Ngày
        );
        $processes_money_total = 0;
        $pro_id = 1;
        $stt = 1;
        $time_processes_total = 0;
        foreach ($item_kit_processes->result() as $ip){
            $pro_id = $ip->pro_id;
            $processes_money_total += $ip->processes_money;
            $processes_cost = $this->Item_kit->get_info_processes_cost($request_id, $ip->id_processes);
            $time_processes_total += $ip->unit_time == 0 ? $ip->time_processes/8 : $ip->time_processes;
            ?>
            <tr class=brand_tr id=brand_tr_<?= $pro_id?>>
                <td><?= $stt ?></td>
                <td style="text-align: left; padding-left: 10px;"><?= $this->Item_kit->get_info_processes($ip->id_processes)->name_processes; ?></td>
                <td style="text-align: right; padding-right: 10px;"><?= $ip->time_processes ?></td>
                <td><?= $ip->unit_time == 0 ? Giờ : Ngày ?></td>
                <td style="text-align: right; padding-right: 20px;"><?= number_format($ip->processes_money) ?></td>
            </tr>
            <tr id=car_tr_<?= $pro_id?>>
                <td colspan="6" style="padding: 0px;">
                    <table class=car_table id=car_table_<?= $pro_id?>>  
                        <tr class=car_th>
                            <th style="width: 30%"><?= $processes_cost->row()->outsource == 0 ? 'Tên chi phí/ Nhân công/ Máy móc' : 'Tên nhà cung cấp' ?></th>
                            <th style="width: 20%">Giá chi phí</th>
                            <th style="width: 10%">Tài khoản nợ</th>
                            <th style="width: 10%">Tài khoản có</th>
                            <th style="width: 20%">Ghi chú</th>
                        </tr>
                        <?php $i=1;
                        $processes_cost = $this->Item_kit->get_info_processes_cost($request_id, $ip->id_processes);
                        foreach ($processes_cost->result() as $pc){
                            $pro_id_i = $pro_id.$i;
                            $info_employee = $this->Employee->get_info($pc->labor);
                            $info_asset = $this->Asset->get_info($pc->machine);
                            $info_supplier = $this->Supplier->get_info($pc->outsource);
                            ?>
                            <tr class=car_tr >
                                <td id=align_left >
                                    <?php
                                    if($pc->cost_name != '' )
                                        echo $pc->cost_name;
                                    if($pc->labor != 0 )
                                        echo $info_employee->first_name.' '.$info_employee->last_name;
                                    if($pc->machine != 0 )
                                        echo $info_asset->name;
                                    if($pc->outsource != 0 )
                                        echo $info_supplier->company_name;
                                    ?>
                                </td>
                                <td id=align_right >
                                    <?= number_format($pc->cost_money) ?>
                                </td>
                                <td id=align_left >
                                    <?= $pc->tk_no ?>
                                </td>
                                <td id=align_left >
                                    <?= $pc->tk_co ?>
                                </td>
                                <td id=align_right ><?= $pc->comment ?>
                                </td>
                            </tr>
                        <?php $i++;
                        }?>
                    </table>
                </td>
            </tr>
            <tr><td colspan="6" id="space_tr_<?= $pro_id ?>" class=space_tr></td></tr>
            <?php
            $pro_id++;
            $stt++;
        } ?>
    </table>
    <h4>&nbsp;* Tổng hợp chi phí SX: </h4>
    <table id=item_kit_money>
        <tr style="text-align: center">
            <th style='width: 25%;'>Tổng chi phí NVL</th>
            <th style='width: 25%;'>Tổng chi phí công đoạn SX</th>
            <th style='width: 25%;'>Tổng tiền</th>
            <th style='width: 25%;'>Tổng thời gian (ngày)</th>
        </tr>
            <tr style='text-align: right'>
                <td><?= number_format($total_money_norms) ?>
                </td>
                <td><?= number_format($processes_money_total) ?>
                </td>
                <td><?= number_format($total_money_norms + $processes_money_total) ?>
                </td>
                <td><?= number_format($time_processes_total, 2) ?>
                </td>
            </tr>
    </table><br>
	<?php
    if ($info_request_production->status == 0 || $info_request_production->status == 1) { ?>
        <div class="field_row clearfix" style="border-bottom:none">
            <?php echo form_label("Ngày bắt đầu: ", "time", array("class" => "required wide"));?>
            <div class='form_field'>


                <?= form_input(array(
                    'name'  => 'date_begin',
                    'id'    => 'date_begin',
                    'class' => 'date-pick',
                    'style' => 'width:80px',

                    'value' => $info_request_production->status == 0 ? "" : date('d-m-Y', strtotime($item_production->date_begin))
                ))?>
            </div>
        </div>

        <div class="field_row clearfix" style="border-bottom:none">
            <?php echo form_label("Ngày kết thúc: ", "time", array("class" => "required wide"));?>
            <div class='form_field'>
                <?= 
                form_input(array(
                    'name' => 'date_end',
                    'id' => 'date_end',
                    'class' => 'date-pick',
                    'style'=>'width:80px',

                    'value' => $info_request_production->status == 0 ? "" : date('d-m-Y', strtotime($item_production->date_end))
                ))?>
            </div>
        </div>
        <?php if ($info_request_production->status == 1) {?>
            <div class="field_row clearfix" style="border-bottom:none">
            <?php echo form_label("Trạng thái: ", "status", array("class" => "wide"));?>
            <div class='form_field'>Chưa xác nhận sản xuất</div>
        </div>
        <?php } ?>
        <br>   
        <?php echo form_submit(array(
            value => lang(common_submit),
            'class' => 'submit_button float_right',
            style => 'margin-bottom:20px',
            name => save_estimate

        ));
    } else { ?>
        <div class="field_row clearfix" style="border-bottom:none">
            <?php echo form_label("Ngày bắt đầu: ", "time", array("class" => "required wide"));?>
            <div class='form_field'><?= date('d-m-Y', strtotime($item_production->date_begin))?></div>
        </div>
        <div class="field_row clearfix" style="border-bottom:none">
            <?php echo form_label("Ngày kết thúc: ", "time", array("class" => "required wide"));?>
            <div class='form_field'><?= date('d-m-Y', strtotime($item_production->date_end))?>
            </div>
        </div>
         <div class="field_row clearfix" style="border-bottom:none">
            <?php echo form_label("Trạng thái: ", "status", array("class" => "wide"));?>
        <div class='form_field'>Đã xác nhận sản xuất</div>
    <?php }
    ?>   
</fieldset>
<?php echo form_close(); ?>
<script type="text/javascript">
$('#date_begin').datePicker({startDate: '01-01-1950'}).bind(
    'dpClosed',
    function(e, selectedDates){
                var d = selectedDates[0];
        if (d) {
                d = new Date(d);
            $('#date_end').dpSetStartDate(d.addDays(0).asString());
                }
        }
);
$('#date_end').datePicker().bind(
        'dpClosed',
        function(e, selectedDates){
                var d = selectedDates[0];
        if (d) {
                        d = new Date(d);
            $('#date_begin').dpSetEndDate(d.addDays(0).asString());
                }
        }
);    
$(document).ready(function(){         
    setTimeout(function () {
        $(":input:visible:first", "#item_kit_form_approve_estimate").focus();
    }, 100);
    var submitting = false;
    $('#item_kit_form_approve_estimate').validate({  
        submitHandler: function (form) {
            if (submitting)
                return;
            submitting = true;
            $(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
            $(form).ajaxSubmit({
                success: function (response) {
                    submitting = false;
                    tb_remove();
                    post_item_kit_form_submit(response);
                },
                dataType: 'json'
            });
        },
        errorLabelContainer: "#error_message_box",
        wrapper: "li",    
        rules: {
            date_begin: {
                required: true,
            },
            date_end: {
                required: true,
            },
        },
        messages: {
            date_begin: {
                required: 'Bạn chưa chọn ngày bắt đầu sản xuất !',
            },
            date_end: {
                required: 'Bạn chưa chọn ngày kết thúc sản xuất !',
            },
        }
    });
});
</script>
<style type="text/css"> 
#item_kit_size{
    width:99%;	
    font: 13px solid;
    margin-left: 5px ;
    margin-top: 10px !important;
}
#item_kit_size tr td{
    border: 1px solid #CDCDCD;
    padding: 3px 5px;
}
#item_kit_size tr th{
    border: 1px solid #CDCDCD;
    background: #e8e8e8;
    color: #000;
    padding: 5px 5px;
}
.submit_button{
    margin-bottom:20px
}
#item_kit_feature{
    margin-bottom: 10px;
}
#size_detail tr td, #quantity_detail tr td{
    line-height: 290%;
    border: none;
    border-top: 1px solid #CDCDCD;
}
#size_detail tr:first-child td, #quantity_detail tr:first-child td{
    border-top: none;
}

#item_kit_money{
    width:100%;	
    font: 13px solid;
    margin-left: 5px ;
    margin-top: 10px !important;
}
#item_kit_money{
    width:99%;	
}
#item_kit_money tr td{
    border: 1px solid #CDCDCD;
    padding: 3px 5px;
}
#item_kit_money tr th{
    border: 1px solid #CDCDCD;
    background: #e8e8e8;
    color: #000;
    padding: 5px 5px;
}

#table_info_item_kit{
    width: 98%;
    margin-left: 5px;
    font-size: 12px;    
}
#table_info_item_kit tr td{
    padding: 4px 0px;
}
#table_info_item_kit .left_table{
    width: 15%;
    font-weight: bold;
}
#table_info_item_kit .right_table{
    width: 35%;
}    
/*//Hưng Audi 3-8-15*/
.item_kit_processes tr td{
    padding: 3px 5px;
}
.time_processes, .processes_money{
    height: 20px;
    text-align: right;
    padding-right: 6px;
}
.id_processes, .unit_time{
    height: 22px;
    padding-left: 5px;
    text-align: left;
}
.cost_money{
    height: 20px;
    text-align: right;
    padding-right: 6px;
}
.cost_name, .outsource_input{
    height: 20px;
    width: 200px;
    text-align: left;
    padding-left: 6px;    
}
#brand_table{
    width: 100%;
    border: 1px solid #CDCDCD;
}    
#brand_table tr, #brand_table tr td, #brand_table tr th{
    border: 1px solid #CDCDCD;
    text-align: center;
    padding: 5px
}
#car_table{
    color: green;
}
.car_th{
    background: #e8e8e8;
}
.brand_tr{
    background: #E1E6FF;
}
.processes_money{
    background: #E1E6FF
}
.space_tr{
    background: #d1d1d1
}
.processes_money, .total_money_norms, .processes_money_total, .money_total{
    text-align: right;
    margin-right: 5px;
    border: none
}
.disable_input_cost {
	display: none;
}
.title_cost{
    border: none;
    background: #e8e8e8;
    font-size: 13px;
    font-weight: bold;
    }
tr#car_table_tr_first td, tr#car_table_tr_first, #row_selected tr, #row_selected tr td{
    border: none;
}
.append_car{
    font-size: 16px; 
    margin-left: 333px;
}
#item_kit_size3{
    width:99%;	
    font: 13px solid;
    margin-left: 5px ;
    margin-top: 10px !important;
}
#item_kit_size3 tr td{
    border: 1px solid #CDCDCD;
    padding: 3px 5px;
}
#item_kit_size3 tr th{
    border: 1px solid #CDCDCD;
    background: #e8e8e8;
    color: #000;
    padding: 5px 5px;
}
.qty_total, .qty_store, .qty_remain{
    border: none;
    text-align: right;
    font: 13px solid;
    width: 100%
}
.car_tr #align_left{
    text-align: left; 
    padding-left: 20px;
}
.car_tr #align_right{
    text-align: right; 
    padding-right: 20px;
}
</style>

