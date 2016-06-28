<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<?php echo form_open_multipart('item_kits/save_processes/' . $info_processes->id_processes, array('id' => 'item_kit_form_processes')); ?>
<fieldset id="item_kit_info">
    <legend><?php echo lang("item_kits_processes_info"); ?></legend>
    <div class="field_row clearfix" style="border-bottom:none">
        <?php echo form_label(lang("item_kits_name_processes") . ": ", "name_processes", array("class" => "wide required")); ?>
        <div class='form_field'>
            <?php
            echo form_input(array(
                'name' => 'name_processes',
                'id' => 'name_processes',
                'type' => 'text',
                'value' => $info_processes->name_processes
            ));
            ?>
        </div>
    </div>
    <div class="field_row clearfix" style="border-bottom:none">
<?php echo form_label(lang("category_processes") . ": ", "category_processes", array("class" => "wide required")); ?>
        <div class='form_field'>
            <select name="cat_pro_id">
                <option value="">--- Chọn nhóm công đoạn ---</option>
                <?php
                foreach ($category_processes as $cat_pro) {
                    if ($cat_pro->cat_pro_id == $info_processes->cat_pro_id) {
                        echo "<option value='" . $cat_pro->cat_pro_id . "' selected='selected'>$cat_pro->cat_pro_name</option>";
                    } else {
                        echo "<option value='" . $cat_pro->cat_pro_id . "'>$cat_pro->cat_pro_name</option>";
                    }
                }
                ?>
            </select>            
        </div>
    </div>
    <?php
    echo form_submit(array(
        'value' => lang('common_submit'),
        'class' => 'submit_button float_right',
        'style' => 'margin-bottom:20px',
        'name' => 'save_design_template'
    ));
    ?>
</fieldset>    
<?php echo form_close(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        setTimeout(function () {
            $(":input:visible:first", "#item_kit_form_processes").focus();
        }, 100);
        var submitting = false;
        $('#item_kit_form_processes').validate({
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
                name_processes: {
                    required: true
                },
                cat_pro_id: {
                    required: true
                }
            },
            messages: {
                name_processes: {
                    required: <?php echo json_encode(lang('item_kits_input_name_processes')); ?>
                },
                cat_pro_id: {
                    required: <?= json_encode(lang('category_processes_input_name')); ?>
                }
            }
        });
    });
</script>