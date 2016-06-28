<ul id="error_message_box"></ul>
<?php echo form_open_multipart('item_kits/save_confirm_processes/' . $id, array('id' => 'item_kit_request_production_template')); ?>
<fieldset id="item_kit_info"><br>
    <?php $info_processes = $this->Item_kit->get_info_processes($id_processes);
    ?>
    <div class="field_row clearfix" style="font-size: 13px">
        <?php echo form_label('Tên công đoạn:', 'quantity_request', array('class' => 'wide')); ?>
        <div class='form_field'><?= $info_processes->name_processes ?></div>
    </div>     
    <div class="field_row clearfix" style="font-size: 13px">
        <label class="required wide" for="status" >Xác nhận hoàn thành</label>
        <div class='form_field'>
            <input type="checkbox" name="status" id="status" value="1" >    
        </div>
    </div> 
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
        $(":input:visible:first", "#item_kit_request_production_template").focus();
    }, 100);
    var submitting = false;
    $('#item_kit_request_production_template').validate({
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
            status:{
                required: true,
            },
        },
        messages: {          
            status:{
                required: 'Bạn chưa tích vào ô xác nhận',
            },
        }
    });
});
</script>   
<style type="text/css">   
#item_kit_items{
    width:86%;	
    font: 13px solid;
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