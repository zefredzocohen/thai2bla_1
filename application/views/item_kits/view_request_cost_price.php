<fieldset id="item_kit_info">
    <legend>Thông tin giá vốn</legend>
    <input type='hidden' id="item_kit_id" name="item_kit_id" value="<?= $request_id ?>" /> 
    <div class="field_row clearfix">
        <?php echo form_label('Số lượng:', array('class' => 'wide')); ?>
        <div class='form_field'>
            <input class="none_love quantity" readonly style="" id="quantity" 
                   name="quantity" value="<?= number_format($product_inventory->quantity, 2) ?>" />
        </div>
    </div>
    <div class="field_row clearfix">
        <?php echo form_label('Chi phí NVL:', array('class' => 'wide')); ?>
        <div class='form_field'>
            <input class="none_love money_norm" readonly id="money_norm" 
                   name="money_norm" value="<?= number_format($request_production_Christmas->total_money_norms) ?>" />
        </div>
    </div>
    <div class="field_row clearfix">
        <?php echo form_label('Chi phí nhân công:', array('class' => 'wide')); ?>
        <div class='form_field'>
            <input class="none_love money_labor" readonly id="money_labor" 
                   name="money_labor" value="<?= number_format($processes_cost_labor->money_labor) ?>" />
        </div>
    </div>
    <div class="field_row clearfix">
        <?php echo form_label('Chi phí máy móc:', array('class' => 'wide')); ?>
        <div class='form_field'>
            <input class="none_love money_machine" readonly id="money_machine" 
                   name="money_machine" value="<?= number_format($processes_cost_machine->money_machine) ?>" />
        </div>
    </div>
    <div class="field_row clearfix">
        <?php echo form_label('Chi phí thuê ngoài:', array('class' => 'wide')); ?>
        <div class='form_field'>
            <input class="none_love money_outsource" readonly id="money_outsource" 
                   name="money_outsource" value="<?= number_format($processes_cost_outsource->money_outsource) ?>" />
        </div>
    </div>
    <div class="field_row clearfix">
        <?php echo form_label('Chi phí khác:', array('class' => 'wide')); ?>
        <div class='form_field'>
            <input class="none_love money_other" readonly id="money_other" 
                   name="money_other" value="<?= number_format($processes_cost_other->money_other) ?>" />
        </div>
    </div>
    <?php
    $money_total = $request_production_Christmas->total_money_norms 
                    + $processes_cost_labor->money_labor 
                    + $processes_cost_machine->money_machine 
                    + $processes_cost_outsource->money_outsource 
                    + $processes_cost_other->money_other;
    ?>
    <div class="field_row clearfix">
        <?php echo form_label('Tổng chi phí:', array('class' => 'wide')); ?>
        <div class='form_field'>
            <input class="none_love money_total" readonly id="money_total" 
                   name="money_total" value="<?= number_format($money_total) ?>" />
        </div>
    </div>
    <div class="field_row clearfix">
        <?php echo form_label('Giá vốn:', array('class' => 'wide')); ?>
        <div class='form_field'>
            <input class="none_love cost_price" readonly id="cost_price" 
                   name="cost_price" value="<?= number_format($money_total/$product_inventory->quantity, 2) ?>" />
        </div>
    </div>
</fieldset>
<?php echo form_close(); ?>
<script type='text/javascript'>
$(document).ready(function () {
    $.post('<?php echo site_url("item_kits/set_item_kit_id"); ?>', {item_kit_id: $('#item_kit_id').val()});
    setTimeout(function () {
        $(":input:visible:first", "#item_kit_form").focus();
    }, 100);
    var submitting = false;
    $('#item_kit_form').validate({
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
        wrapper: "li"
    });

});
</script>
<style>
.none_love{
    border: none !important;
    margin-top:-5px;
}
</style>