<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<?= form_open_multipart('item_kits/save_item_kit_cost_price/' . $item_kit_id, array('id' => 'item_kit_form'));?>
<fieldset id="item_kit_info">
    <legend>Thông tin giá vốn</legend>
    <input type='hidden' id="item_kit_id" name="item_kit_id" value="<?= $item_kit_id ?>" /> 
    <div class="field_row clearfix">
        <?php echo form_label('Chọn thời gian:', '', array('class' => 'wide required')); ?>
        <div class='form_field'>
            <input placeholder="Từ ngày"  class="date-pick" 
                id="start_date" name="start_date" value="<?= $info_cp->start_date ?>" />
            <input placeholder="Đến ngày" class="date-pick" 
                id="end_date" name="end_date" value="<?= $info_cp->end_date ?>" style="margin-left: 20px"/> 
        </div>
    </div>   
    <div>
        <div id="add_payment_button" class="small_button" >
            <span class="item" name="item" style="width: 50px" >Xem</span>
        </div>          
    </div>  
    <div class="field_row clearfix">
        <?php echo form_label('Số lượng:', array('class' => 'wide')); ?>
        <div class='form_field'>
            <input class="none_love quantity" readonly style=""
                   id="quantity" name="quantity" value="<?= number_format($info_cp->quantity, 2) ?>" />
        </div>
    </div>
    <div class="field_row clearfix">
        <?php echo form_label('Chi phí NVL:', array('class' => 'wide')); ?>
        <div class='form_field'>
            <input class="none_love money_norm" readonly
                id="money_norm" name="money_norm" value="<?= number_format($info_cp->money_norm) ?>" />
        </div>
    </div>
    <div class="field_row clearfix">
        <?php echo form_label('Chi phí nhân công:', array('class' => 'wide')); ?>
        <div class='form_field'>
            <input class="none_love money_labor" readonly
                id="money_labor" name="money_labor" value="<?= number_format($info_cp->money_labor) ?>" />
        </div>
    </div>
    <div class="field_row clearfix">
        <?php echo form_label('Chi phí máy móc:', array('class' => 'wide')); ?>
        <div class='form_field'>
            <input class="none_love money_machine" readonly
                id="money_machine" name="money_machine" value="<?= number_format($info_cp->money_machine) ?>" />
        </div>
    </div>
    <div class="field_row clearfix">
        <?php echo form_label('Chi phí thuê ngoài:', array('class' => 'wide')); ?>
        <div class='form_field'>
            <input class="none_love money_outsource" readonly
                id="money_outsource" name="money_outsource" value="<?= number_format($info_cp->money_outsource) ?>" />
        </div>
    </div>
    <div class="field_row clearfix">
        <?php echo form_label('Chi phí khác:', array('class' => 'wide')); ?>
        <div class='form_field'>
            <input class="none_love money_other" readonly
                id="money_other" name="money_other" value="<?= number_format($info_cp->money_other) ?>" />
        </div>
    </div>
    <?php
    $money_total = $info_cp->money_norm 
                    + $info_cp->money_labor 
                    + $info_cp->money_machine 
                    + $info_cp->money_outsource 
                    + $info_cp->money_other;
    ?>
    <div class="field_row clearfix">
        <?php echo form_label('Tổng chi phí:', array('class' => 'wide')); ?>
        <div class='form_field'>
            <input class="none_love money_total" readonly
                id="money_total" name="money_total" value="<?= number_format($money_total) ?>" />
        </div>
    </div>
    <div class="field_row clearfix">
        <?php echo form_label('Giá vốn:', array('class' => 'wide')); ?>
        <div class='form_field'>
            <input class="none_love cost_price" readonly
                id="cost_price" name="cost_price" value="<?= number_format($info_cp->cost_price, 2) ?>" />
        </div>
    </div>
<?php
echo form_submit(array(
    'value' => 'Cập nhật giá vốn',
    'class' => 'submit_button float_right',
    'style' => 'margin-top:10px; margin-right:30px; margin-bottom: 20px;',
    'name' => 'save_item'
));
?> 
</fieldset>
<?php echo form_close(); ?>
<script type='text/javascript'>
$(document).ready(function () {
    $.post('<?php echo site_url("item_kits/set_item_kit_id"); ?>', {item_kit_id: $('#item_kit_id').val()});
    $('#start_date').change(function () {
        $.post('<?php echo site_url("item_kits/set_start_date"); ?>', {start_date: $('#start_date').val()});
    });
    $("#end_date").change(function () {
        $.post('<?php echo site_url("item_kits/set_end_date"); ?>', {end_date: $('#end_date').val()});
    });    
    $('.item').click(function(){
        $.get('<?php echo site_url("item_kits/product_search_item_kit");?>',{},function(data){
            var quantity    = (data.quantity        ? data.quantity         : 0 +'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
            var norm        = (data.money_norm      ? data.money_norm       : 0 +'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
            var labor       = (data.money_labor     ? data.money_labor      : 0 +'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
            var machine     = (data.money_machine   ? data.money_machine    : 0 +'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
            var outsource   = (data.money_outsource ? data.money_outsource  : 0 +'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
            var other       = (data.money_other     ? data.money_other      : 0 +'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
            var total       = (data.money_total +'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
            var price       = data.cost_price ? (data.cost_price.toFixed(2) +'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") : 0;  
            
            $(".quantity").val(quantity);
            $(".money_norm").val(norm);
            $(".money_labor").val(labor);
            $(".money_machine").val(machine);
            $(".money_outsource").val(outsource);
            $(".money_other").val(other);
            $(".money_total").val(total);
            $(".cost_price").val(price);
        },'json');
    });
    
    /*~~~~ Hưng Audi 8-9-15 >>>>*/
    $('#start_date').datePicker({startDate: '01-01-1950'}).bind(
        'dpClosed',
        function (e, selectedDates) {
            var d = selectedDates[0];
            if (d) {
                d = new Date(d);
                $('#end_date').dpSetStartDate(d.addDays(0).asString());
            }
        }
    );
    $('#end_date').datePicker({startDate: '01-01-1950'}).bind(
        'dpClosed',
        function (e, selectedDates) {
            var d = selectedDates[0];
            if (d) {
                d = new Date(d);
                $('#start_date').dpSetEndDate(d.addDays(0).asString());
            }
        }
    );
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
        wrapper: "li",
        rules: {
            start_date: "required",
            end_date: "required",    
        },
        messages: {
            start_date: 'Bạn chưa chọn ngày bắt đầu',
            end_date: 'Bạn chưa chọn ngày kết thúc',            
        }
    });

});
function deleteItemKitRow(link) {
    $(link).parent().parent().remove();
    return false;
}
</script>
<style> 
#start_date, #end_date{
    width: 80px
}
.none_love{
    border: none !important;
    margin-top:-5px;
}

</style>