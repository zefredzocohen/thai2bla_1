<style type="text/css"> 
    #item_kit_size, #item_kit_size3{
        width:99%;	
        font: 13px solid;
        margin-left: 5px ;
        margin-top: 10px !important;
    }
    #item_kit_size tr td, #item_kit_size3 tr td{
        border: 1px solid #CDCDCD;
        padding: 3px 5px;
    }
    #item_kit_size tr th, #item_kit_size3 tr th{
        border: 1px solid #CDCDCD;
        background: #e8e8e8;
        color: #000;
        padding: 5px 5px;
    } 
    #size_detail tr td, #quantity_detail tr td{
        border: none;
        border-top: 1px solid #CDCDCD;
    }
    #size_detail tr:first-child td, #quantity_detail tr:first-child td{
        border-top: none;
    } 
</style>
<fieldset>
    <legend>Thông tin chi tiết số lượng</legend>
    <table id=item_kit_size>
        <tr style='text-align: center'>
            <th style="width: 10%" rowspan="2">Tên mẫu</th> 
            <th colspan="2">Thông tin size</th>
            <th colspan="5">Công thức nguyên vật liệu</th>
        </tr>
        <tr style='text-align: center'>
            <th style="width: 5%">Size</th> 
            <th style="width: 5%">SL size</th>
            <th style="width: 10%">Mã NVL</th>
            <th style="width: 10%">Tên NVL</th>
            <th style="width: 6%">ĐVT</th>
            <th style="width: 7%">Định mức/SP</th>   
        </tr>
        <?php
        $total_size = 0;
        $total_norms_per_item = 0;
        $total_norms = 0;
        $total_money_norms = 0;
        foreach ($request_feature as $f) {
            $i = $this->Item_kit->count_formula_materials($f->feature_id);
            $info_feature = $this->Item_kit->get_info_item_kit_feature($f->feature_id);
            ?>
            <tr>
                <td style='text-align: left; width: 10%;' rowspan="<?= $i ?>"><?= $info_feature->name_feature ?></td> 
                <?php $info_sizes = $this->Item_kit->get_size_by_request_feature($f->request_id, $f->feature_id); ?>
                <td rowspan="<?= $i ?>" style="width: 5%; padding: 0px">
                    <table id="size_detail">
                        <?php foreach ($info_sizes as $is) { ?>
                            <tr>
                                <td>
                                    <?= $is->size ?>
                                </td>                            
                            </tr>
                        <?php }
                        ?>
                    </table>
                </td>
                <td rowspan="<?= $i ?>" style="text-align: right; width: 5%; padding: 0px">
                    <table id="quantity_detail">
                        <?php
                        foreach ($info_sizes as $is) {
                            $total_size += $is->quantity
                            ?>
                            <tr>
                                <td>
                                    <?= $is->quantity ?>
                                </td>
                            </tr>
                        <?php }
                        ?>
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
                    $total_quantity_of_feature_request = 0;
                    foreach ($info_sizes as $val) {
                        $total_quantity_of_feature_request += $val->quantity;
                    }
                    $total_quantity = $total_quantity_of_feature_request * $item_size->quantity;
                    $cost_price = $item_info->quantity_first != 0 ? $item_info->cost_price_rate : $item_info->cost_price;

                    $total_norms_per_item += $item_size->quantity;
                    $total_norms += $total_quantity;
                    $total_money_norms += $total_quantity * $cost_price;
                    ?>
                    <td style="text-align: center; width: 10%;"><?= $item_info->item_number ?></td>
                    <td style="width: 10%;"><?= $item_info->name ?></td>
                    <td style="width: 6%;"><?= $unit_info->name ?></td>
                    <td style="text-align: right; width: 7%;"><?= format_quantity($item_size->quantity) ?></td>
                </tr>
                <?php
            }
        }
        ?>
        <tfoot style="font-weight: bold">
        <td colspan="2"> Tổng</td>
        <td style="text-align: right;"><?= format_quantity($total_size) ?></td>
        <td colspan="3" style="background: #e8e8e8"></td>
        <td style="text-align: right;"><?= format_quantity($total_norms_per_item) ?></td>
        </tfoot>
    </table><br>
</fieldset>
<fieldset>
    <legend>Tổng hợp nguyên vật liệu</legend>
    <table id=item_kit_size3>
        <tr style='text-align: center'>
            <th style="width: 10%">STT</th>
            <th style="width: 60%">Tên vật tư</th> 
            <th style="width: 30%">Tổng định mức vật tư</th>
        </tr>
        <?php
        $stt = 0;
        $info_norms_item = $this->Item_kit->get_info_norms_item_by_request_id($request_id);
        foreach ($info_norms_item as $value) {
            $stt++;
            ?>
            <tr>
                <td style="text-align: center"><?= $stt ?></td>
                <td><?php echo $this->Item->get_info($value->item_id)->name; ?></td>
                <td style="text-align: right"><?php echo $value->quantity_total; ?></td>                
            </tr>
        <?php }
        ?> 
    </table>
    <?php
    if ($type == 1) {
        echo form_open('item_kits/confirm_production/' . $request_id, array("id" => "form_confirm_production"));
        echo form_submit(array(
            "value" => lang("common_submit"),
            'class' => 'submit_button float_right',
            "style" => 'margin-bottom:20px',
            "name" => "confirm_production"
        ));
        echo form_close();
    }
    ?>
</fieldset>
<script>
    $(document).ready(function () {
        setTimeout(function () {
            $(":input:visible:first", "#form_confirm_production").focus();
        }, 100);
        var submitting = false;
        $('#form_confirm_production').validate({
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
            }
        })
    })
</script>