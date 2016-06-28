<div style="height: 200px;">
    <div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
    <ul id="error_message_box"></ul>
    <?php echo form_open('category_processes/save/' . $info_cat_pro->cat_pro_id, array('id' => 'cat_pro_form'));?>
    <fieldset id="item_basic_info">
        <legend>Thông tin nhóm công đoạn</legend>
        <div class="field_row clearfix">
            <?php echo form_label('Tên nhóm công đoạn:', 'cat_pro_name', array('class' => 'required wide')); ?>
            <div class='form_field'>
                <?php echo form_input(array(
                    'name' => 'cat_pro_name',
                    'id' => 'cat_pro_name',
                    'value' => $info_cat_pro->cat_pro_name)
                );
                ?>
            </div>
        </div>
        <?php echo form_submit(array(
            'name' => 'submit',
            'id' => 'submit',
            'value' => lang('common_submit'),
            'class' => 'submit_button float_right')
        );
        ?></fieldset>
<?php echo form_close(); ?>
</div>
<script type='text/javascript'>
//validation and submit handling
    $(document).ready(function () {
        setTimeout(function () {
            $(":input:visible:first", "#cat_pro_form").focus();
        }, 100);
        var submitting = false;
        $('#cat_pro_form').validate({/*sau khi them submit no se goi lai manage*/
            submitHandler: function (form) {
                if (submitting)
                    return;
                submitting = true;
                $(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
                $(form).ajaxSubmit({
                    success: function (response) {
                        submitting = false;
                        tb_remove();
                        post_item_form_submit(response);
                    },
                    dataType: 'json'
                });
            },
            errorLabelContainer: "#error_message_box",
            wrapper: "li",
            rules: {
                cat_pro_name: {
                    required: true
                }
            },
            messages: {
                cat_pro_name: {
                    required: 'Vui lòng nhập tên nhóm công đoạn'                   
                }
            }
        });
    });
</script>
