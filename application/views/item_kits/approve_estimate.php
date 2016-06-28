<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<?php echo form_open_multipart('item_kits/save_approve_estimate/' . $id_design_template, array('id' => 'item_kit_form_approve_estimate')); ?>
<fieldset id="item_kit_info">
    <legend>Thông tin mẫu sản xuất</legend>
    <?php echo form_hidden("item_kit_id", $item_kit_id); ?>
    <div class="field_row clearfix" style="border-bottom:none">
        <?php echo form_label(lang("item_kits_feedback_design_template").": ", "status", array("class" => "wide required"));?>
        <div class='form_field'>
            <select name="status" id="status">
                <?php
                if($id_design_template_status_6){
                    $status_max = $id_design_template == $id_design_template_status_6 ? 6 : 5;//id đang phê duyệt có status = 6 -> các id khác sẽ bị ẩn 6 đi (chỉ còn đến 5)
                }else{
                    $status_max = 6;
                }
                for( $i = 4; $i <= $status_max; $i++){?>
                    <option value="<?= $i ?>" <?php echo $production_template->status == $i ? 'selected' : '' ?>>
                            <?php 
                        if($i == 4)
                            $status_name = 'Không đạt';
                        else if($i == 5)
                            $status_name = 'Duyệt tạm';
                        else if($i == 6)
                            $status_name = 'Duyệt sản xuất';
                        
                            echo $status_name ?>
                    </option>
                <?php
                }?>
            </select>
        </div>
    </div>
    <div class="field_row clearfix" style="border-bottom:none">
        <?php echo form_label(lang("item_kits_command_design_template").": ", "comment", array("class" => "wide"));?>
        <div class='form_field'>
            <?php echo form_textarea(array(
                'name' => 'comment',
                'id' => 'comment',
                'value' => $production_template->comment,
                'style'=>'width: 200px; margin-top:1px'
            ));
            ?>
        </div>
    </div>
    <?php echo form_submit(array(
        'value' => lang('common_submit'),
        'class' => 'submit_button float_right',
        'style' => 'margin-bottom:20px',
        'name' => 'save_estimate'
    ));?>
</fieldset>
<?php echo form_close(); ?>
<script type="text/javascript">
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
    });
});
</script>
 