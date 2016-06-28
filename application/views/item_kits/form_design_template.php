<script src="<?php echo base_url(); ?>js/additional-methods.js" type="text/javascript"></script>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<?php echo form_open_multipart('item_kits/save_design_template/' . $design_template->id_design_template, array('id' => 'item_kit_form_design_template')); ?>
<fieldset id="item_kit_info">
    <legend><?php echo lang("item_kits_design_template_info"); ?></legend>
    <?php echo form_hidden("item_kit_id", $item_kit_id); ?>
    <div class="field_row clearfix" style="border-bottom:none">
        <?php echo form_label(lang("item_kits_code_design_template") . ": ", "code_design_template", array("class" => "wide required")); ?>
        <div class='form_field'>
            <?php
            echo form_input(array(
                'name' => 'code_design_template',
                'id' => 'code_design_template',
                'type' => 'text',
                'value' => $design_template->code_design_template
            ));
            ?>
        </div>
    </div>
    <div class="field_row clearfix" style="border-bottom:none">
        <?php echo form_label(lang("item_kits_image_design_template") . ": ", "image_design_template", array("class" => "wide required")); ?>
        <div class='form_field'>
            <?php if ($design_template->id_design_template) { ?>
                <img src="./item_kit/design_template/<?php echo $design_template->image_design_template; ?>"><br>
                <?php
            }
            echo form_input(array(
                'name' => 'image_design_template',
                'id' => 'image_design_template',
                'type' => 'file',
                'style' => $design_template->id_design_template ? 'margin-left:130px; width: 53%' : 'width: 28%'
            ));
            ?>
        </div>
    </div>
    <div class="field_row clearfix" style="border-bottom:none">
        <?php echo form_label(lang("item_kits_description_design_template") . ": ", "description_design_template", array("class" => "wide")); ?>
        <div class="form_field">
            <textarea name="description_design_template" id="description_design_template"><?php echo $design_template->description; ?></textarea>
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
    $(document).ready(function(){
    setTimeout(function () {
    $(":input:visible:first", "#item_kit_form_design_template").focus();
    }, 100);
    var submitting = false;
    $('#item_kit_form_design_template').validate({
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
        code_design_template:{
            required: true,
            remote: {
                url: "<?= site_url('item_kits/check_code_design_template/' . $design_template->id_design_template); ?>",
                type: "post"
            }
        },
        image_design_template:{
<?php if (!$design_template->id_design_template) { ?>
                        required: true,
<?php } ?>
                    extension: "jpg|jpeg|png|gif"
                    }
            },
            messages:{
            code_design_template:{
            required: <?php echo json_encode(lang("item_kits_info_code_design_template")); ?>,
                    remote: <?php echo json_encode(lang("item_kits_exist_code_design_template")); ?>,
            },
                    image_design_template:{
<?php if (!$design_template->id_design_template) { ?>
                        required: <?php echo json_encode(lang("item_kits_choose_design_template")); ?>,
<?php } ?>
                    extension: <?php echo json_encode(lang("item_kits_format_design_template")); ?>
                    }
            }
    });
    });
</script>