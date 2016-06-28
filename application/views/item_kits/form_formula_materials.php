<script src="<?php echo base_url(); ?>js/additional-methods.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js" type="text/javascript"></script>
<style type="text/css">
#item_kit_items{
    width:95%;	
    margin: 0px auto;
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
<ul id="error_message_box"></ul>
<?php echo form_open_multipart('item_kits/save_formula_materials/' . $feature_id, array('id' => 'item_kit_form_formula_materials')); ?>

<label style="font-weight: bold; margin-left: 15px">Mã thiết kế: </label>
<span style="font-weight: normal; color: #000FFF">
    <?= $info_design_template->code_design_template ?></span>

<label style="font-weight: bold;">- Mã kiểu SP: </label>
<span style="font-weight: normal; color: #000FFF">
    <?= $feature_id;?></span> 

<fieldset>
    <legend><?php echo lang("item_kits_formula_materials"); ?></legend>
    <div class="field_row clearfix" style="width: 600px;  float: left;">
        <?php echo form_label('Chọn nguyên vật liệu:', 'item', array('class' => 'wide', 'style' => 'width: 200px')); ?>
        <div class='form_field'>
            <?php echo form_input(array(
                'name' => 'item',
                'id' => 'items_kits'
            ));
            ?>
        </div>
    </div>
    <table id="item_kit_items">
        <tr>
            <th><?= lang('common_delete'); ?></th>
            <th><?= lang('item_kits_item'); ?></th>
            <th><?= lang('item_kits_unit'); ?></th>
            <th><?= lang("item_kits_norms"); ?></th>
        </tr>
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
                    <td style='text-align: left'> <?php echo $item_info->name; ?></td>
                    <td style="text-align: left"><?= $unit_info->name;?>
                        <input class="unit" id="unit_<?php echo $formula_material['item_id']; ?>" type='hidden' size='5' 
                               name=unit[<?php echo $formula_material['item_id'] ?>] 
                               value='<?php echo $formula_material['unit'] ?>'/>
                    </td>
                    <td style="width: 25%"> 
                        <input class="quantity" id="quantity_<?php echo $formula_material['item_id']; ?>" type='text' 
                               name=quantity[<?php echo $formula_material['item_id']; ?>] 
                               value='<?php echo number_format($formula_material['quantity']); ?>' onchange='calculateSuggestedPrices();' />
                    </td>
                </tr>
                <?php }
            }?>
    </table>
    <?php echo form_submit(array(
        'value' => lang('common_submit'),
        'class' => 'submit_button float_right',
        'style' => 'margin-bottom:20px',
        'name' => 'save_design_template'
    ));?>
<?php echo form_close(); ?>
</fieldset>
<script type="text/javascript">
    $(document).ready(function(){
        setTimeout(function () {
            $(":input:visible:first", "#item_kit_form_formula_materials").focus();
        }, 100);
        var submitting = false;
        $('#item_kit_form_formula_materials').validate({  
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
                        + "<td style='text-align: left'>" + ui.item.label + "</td>"
                        + "<td style='text-align: left'>" + ui.item.unit_name + "<input class='unit' id='unit_" + ui.item.value + "' type='hidden' size='3' name=unit[" + ui.item.value + "] value='" + ui.item.unit + "'/></td>"                       
                        + "<td style='width: 25%'><input class='quantity' id='quantity_" + ui.item.value + "' type='text' name=quantity[" + ui.item.value + "] value='1'/></td>"
                        + "</tr>"
                    );
                    $('#quantity_' + ui.item.value).maskMoney();//only entry number, add ","
                }
                return false;
            }
        });
        calculateSuggestedPrices();
    });
    function calculateSuggestedPrices() {
        $("#item_kit_items").find('.quantity').each(function (index, element) {
            $(element).maskMoney();
        }); 
    }
    function deleteItemKitRow(link) {
        $(link).parent().parent().remove();
        return false;
    }
</script>