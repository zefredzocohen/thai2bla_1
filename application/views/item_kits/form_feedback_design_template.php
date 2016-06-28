<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<?php echo form_open_multipart('item_kits/save_feedback_design_template/' . $info_design_template->id_design_template, array('id' => 'item_kit_form_feedback_design_template')); ?>
<fieldset id="item_kit_info">
    <legend><?php echo lang("item_kits_design_template_info"); ?></legend>
    <?php echo form_hidden("item_kit_id", $item_kit_id); ?>
    <div class="field_row clearfix" style="border-bottom:none">
        <?php echo form_label(lang("item_kits_feedback_design_template").": ", "status", array("class" => "wide required"));?>
        <div class='form_field'>
            <select name="status" id="status">
                <?php
                for( $i = 0; $i <= 6; $i++){?>
                    <option value="<?= $i ?>" <?php echo $info_design_template->status == $i ? 'selected' : '' ?>>
                            <?php 
                        if($i == 0)
                            $status_name = 'Đề xuất';
                        else if($i == 1)
                            $status_name = 'Đang triển khai';
                        else if($i == 2)
                            $status_name = 'Đang xét duyệt';
                        else if($i == 3)
                            $status_name = 'Duyệt';
                        else if($i == 4)
                            $status_name = 'Không duyệt';
                        else if($i == 5)
                            $status_name = 'Thiết kế lại';
                        else
                            $status_name = 'Hủy';
                            
                        echo $status_name ?>
                    </option>
                <?php
                }?>
            </select>
        </div>
    </div>
    <div class="field_row clearfix" style="border-bottom:none">
        <?php echo form_label(lang("item_kits_command_design_template").": ", "command", array("class" => "wide"));?>
        <div class='form_field'>
            <?php echo form_textarea(array(
                'name' => 'command',
                'id' => 'command',
                'value' => $info_design_template->command
            ));
            ?>
        </div>
    </div>
    <?php echo form_submit(array(
        'value' => lang('common_submit'),
        'class' => 'submit_button float_right',
        'style' => 'margin-bottom:20px',
        'name' => 'save_design_template'
    ));?>
</fieldset>
<?php echo form_close(); ?>
<script type="text/javascript">
$(document).ready(function(){
    setTimeout(function () {
        $(":input:visible:first", "#item_kit_form_feedback_design_template").focus();
    }, 100);
    var submitting = false;
    $('#item_kit_form_feedback_design_template').validate({  
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