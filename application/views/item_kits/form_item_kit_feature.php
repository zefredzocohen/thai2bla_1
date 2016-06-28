<script src="<?php echo base_url(); ?>js/additional-methods.js" type="text/javascript"></script>
<style type="text/css">
#item_kit_items{
    width:95%;	
    margin: 50px auto;
    font-size: 12px;
}
#item_kit_items tr td{
    border: 1px solid #CDCDCD;
    padding: 3px 5px;
}
#item_kit_items tr th{
    border: 1px solid #CDCDCD;
    background: #e8e8e8;
    color: #000;
    padding: 5px 5px;
}
.quantity{
    text-align: right;
    padding: 2px 10px;
    width: 80%;
}
</style>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<?php echo form_open_multipart('item_kits/save_item_kit_feature/' . $item_kit_feature->feature_id, array('id' => 'form_item_kit_feature')); ?>

<label style="font-weight: bold; margin-left: 15px">Mã mẫu TK: </label>
<span style="font-weight: normal; color: #000FFF">
    <?= $info_design_template->code_design_template ?></span>
<?php if($feature_id != -1){?>
<label style="font-weight: bold;"> &nbsp; - &nbsp; Mã công thức NVL: </label>
<span style="font-weight: normal; color: #000FFF">
    <?= $feature_id;?></span> 
<?php } ?>

<fieldset id="item_kit_info">
    <legend><?php echo 'Thông tin kiểu sản phẩm'; ?></legend>
    <?php echo form_hidden("id_design_template", $id_design_template); ?>
    <div class="field_row clearfix" style="border-bottom:none">
        <?php echo form_label("Mã số : ", "numer_feature", array("class" => "wide required"));?>
        <div class='form_field'>
            <?php if($feature_id == -1){?>
                <input type="text" name="number_feature" id="number_feature" value="<?= $item_kit_feature->number_feature ?>"> 
            <?php
            }else{?>
                <?= $item_kit_feature->number_feature ?>
                <input type="hidden" name="number_feature" id="number_feature" value="<?= $item_kit_feature->number_feature ?>"> 
                <?php
            }?>
        </div>
    </div>
    <div class="field_row clearfix" style="border-bottom:none">
        <?php echo form_label("Tên : ", "name_feature", array("class" => "wide required"));?>
        <div class='form_field'>
            <?php echo form_input(array(
                'name' => 'name_feature',
                'id' => 'name_feature',
                'type' => 'text',
                'value' => $item_kit_feature->name_feature
            ));
            ?>
        </div>
    </div>
</fieldset>  
<fieldset>
    <legend><?php echo lang("item_kits_formula_materials"); ?></legend>
    <?php
    if ($feature_design_template->num_rows() > 0) {
    ?>
    <div class="field_row clearfix" style="width: 600px;  float: left;">
        <?php echo form_label('Sao chép công thức NVL:', 'feature_design_template', array('class' => 'wide', 'style' => 'width: 200px')); ?>
        <div class='form_field'>
            <select name="feature_desgin_template" id="feature_desgin_template">
                <option value="">---Chọn công thức NVL---</option>
                <?php
                foreach ($feature_design_template->result() as $val){
                ?>
                <option value="<?= $val->feature_id; ?>"><?= $val->name_feature?></option>
                <?php 
                }
                ?>
            </select>
        </div>
    </div>
    <?php
    }
    ?>
    <div class="field_row clearfix" style="width: 600px;  float: left;">
        <?php echo form_label('Chọn nguyên vật liệu:', 'item', array('class' => 'required wide', 'style' => 'width: 200px')); ?>
        <div class='form_field'>
            <?php echo form_input(array(
                'name' => 'item',
                'id' => 'items_kits'
            ));?>
        </div>
    </div>
    <table id="item_kit_items">
        <thead>
        <tr>
            <th><?= lang('common_delete'); ?></th>
            <th>Mã NVL</th>
            <th><?= lang('item_kits_item'); ?></th>
            <th><?= lang('item_kits_unit'); ?></th>
            <th><?= lang("item_kits_norms"); ?></th>
        </tr>
        </thead>
        <tbody>
            <?php 
            if($info_formula_material){
                foreach ($info_formula_material as $formula_material) { ?>
                <tr>
                    <?php
                    $info_store = $this->Create_invetory->check_exist_store_materials();
                    $item_info = $this->Item->get_info_in_store_material($formula_material['item_id'], $info_store['id']);
                    $unit_info = $this->Unit->get_info($formula_material['unit']);
                    ?>
                    <td style="width: 5%"><a href="#" onclick='return deleteItemKitRow(this);'>X</a></td>
                    <td style="width: 10%"><?= $item_info->item_number;?></td>
                    <td style='text-align: left'> 
                        <input id='item_id_<?= $formula_material['item_id'] ?>' type='hidden' 
                               value='<?= $formula_material['item_id'] ?>' 
                               name='item_id[<?= $formula_material['item_id'] ?>]' class='item_id' />
                                <?php echo $item_info->name; ?>
                    </td>
                    <td style="text-align: left"><?= $unit_info->name;?>
                        <input class="unit" id="unit_<?php echo $formula_material['item_id']; ?>" type='hidden' size='5' 
                               name=unit[<?php echo $formula_material['item_id'] ?>] 
                               value='<?php echo $formula_material['unit'] ?>'/>
                    </td>
                    <td style="width: 25%"> 
                        <input class="quantity" id="quantity_<?php echo $formula_material['item_id']; ?>" type='text' 
                               name=quantity[<?php echo $formula_material['item_id']; ?>] 
                               value='<?php echo format_quantity($formula_material['quantity']); ?>' />
                    </td>
                </tr>
                <?php }
            }?>
        </tbody>
    </table>
    <?php echo form_submit(array(
        'value' => lang('common_submit'),
        'class' => 'submit_button float_right',
        'style' => 'margin-bottom:20px',
        'name' => 'save_design_template'
    ));?>
<?php echo form_close(); ?>
</fieldset>

<?php echo form_close(); ?>
<script type="text/javascript">
    $(document).ready(function(){
        setTimeout(function () {
            $(":input:visible:first", "#item_kit_form_item_kit_feature").focus();
        }, 100);
        var submitting = false;
        $('#form_item_kit_feature').validate({  
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
            rules:{
                number_feature:{
                    required: true,
                    maxlength: 15,
                    remote: {
                        url: "<?= site_url('item_kits/check_number_feature/'.$item_kit_feature->feature_id);?>",
                        type: "post"
                    }
                },            
                name_feature:{
                    required: true,
                    remote: {
                        url: "<?= site_url('item_kits/check_name_feature/'.$item_kit_feature->feature_id);?>",
                        type: "post"
                    }
                },              
            },
            messages:{
                number_feature:{
                    required: <?php echo json_encode('Mã số không được để trống'); ?>,
                    maxlength: <?php echo json_encode('Mã số không được lớn hơn 15 kí tự'); ?>,
                    remote: <?php echo json_encode('Mã số đã bị trùng. Vui lòng điền mã khác');?>,
                },            
                name_feature:{
                    required: <?php echo json_encode('Tên không được để trống...'); ?>,
                    remote: <?php echo json_encode('Tên đã bị trùng. Vui lòng điền tên khác');?>,
                },  
            }
        }); 
        $("#items_kits").autocomplete({
            source: '<?php echo site_url("items/item_search_product_store"); ?>',
            delay: 10,
            autoFocus: false,
            minLength: 0,
            select: function (event, ui) {
                $("#items_kits").val("");
                if ($("#quantity_" + ui.item.value).length == 1) {
                    $("#quantity_" + ui.item.value).val(parseFloat($("#quantity_" + ui.item.value).val()) + 1);
                } else {                   
                    $("#item_kit_items").append(
                        "<tr><td style='width: 5%'><a href='#' onclick='return deleteItemKitRow(this);'>X</a></td>"
                        + "<td style='width: 10%'>" + ui.item.item_number + "</td>"
                        + "<td style='text-align: left'><input id='item_id_" + ui.item.value + "' type='hidden' value='" + ui.item.value
                            + "' name='item_id[" + ui.item.value + "]' class='item_id' />" + ui.item.name + "</td>"
                    
                        + "<td style='text-align: left'>" + ui.item.unit_name + "<input class='unit' id='unit_" + ui.item.value 
                            + "' type='hidden' size='3' name=unit[" + ui.item.value + "] value='" + ui.item.unit + "'/></td>"  
                        
                        + "<td style='width: 25%'><input class='quantity' id='quantity_" + ui.item.value 
                            + "' type='text' name=quantity[" + ui.item.value + "] value='1'/></td>"
                        + "</tr>"
                    );
                }
                $(".quantity").keydown(function (e) {
                    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                      (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                      (e.keyCode >= 35 && e.keyCode <= 40)) {
                        return;
                    }
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });
                return false;
            }
        });
        $(".quantity").keydown(function (e) {
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
              (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
              (e.keyCode >= 35 && e.keyCode <= 40)) {
                return;
            }
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
    });
    
    $("#feature_desgin_template").change(function(){
        $.ajax({
            type: "post",
            url: "<?= site_url('item_kits/get_info_formula_materials')?>",
            data: {feature_id: $(this).val()},
            success: function(data){
                $("#item_kit_items tbody tr").remove();
                $(data).each(function(i, e){
                    $("#item_kit_items tbody").append(
                        "<tr>"
                        + "<td style='width: 5%'><a href='#' onclick='return deleteItemKitRow(this);'>X</a></td>"
                        + "<td style='width: 10%'>" + e.item_number + "</td>"
                        + "<td style='text-align: left'><input id='item_id_" + e.item_id + "' type='hidden' value='" + e.item_id
                            + "' name='item_id[" + e.item_id + "]' class='item_id'/>" + e.name + "</td>"
                        + "<td style='text-align: left'>" + e.unit_name + "<input class='unit' id='unit_" + e.item_id 
                            + "' type='hidden' size='3' name=unit[" + e.item_id + "] value='" + e.unit + "'/></td>"
                        + "<td style='width: 25%'><input class='quantity' id='quantity_" + e.item_id 
                            + "' type='text' name=quantity[" + e.item_id + "] value='" + e.quantity + "'/></td>"
                        + "</tr>"
                    );
                });
            },
            dataType: 'json'
        });
        return false;
    });
    
    $('.submit_button').click(function () {
        if (!$(".item_id").val()) {
            alert('Chưa chọn nguyên vật liệu cho công thức này. Vui lòng chọn !');
            return false;//not redirect
        }
    });    
    function deleteItemKitRow(link) {
        $(link).parent().parent().remove();
        return false;
    }
    $("#number_feature").keydown(function (e) {
        if (e.keyCode == 32) { 
            return false; // return false to prevent space from being added
        }
    });
</script>